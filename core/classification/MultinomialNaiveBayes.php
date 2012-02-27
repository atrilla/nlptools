<!--
                           _    _______          _     
                          | |  |__   __\        | |    
                     _ __ | |_ __ | | ___   ___ | |___ 
                    | '_ \| | '_ \| |/ _ \ / _ \| / __|
                    | | | | | |_) | | (_) | (_) | \__ \
                    |_| |_|_| .__/|_|\___/ \___/|_|___/
 ___________________________| |_________________________________________
|                           |_|                                        |\
|                                                                      |_\
|   File    : MultinomialNaiveBayes.php                                   |
|   Created : 16-Feb-2012                                                 |
|   By      : atrilla                                                     |
|                                                                         |
|   nlpTools - Natural Language Processing Toolkit for PHP                |
|                                                                         |
|   Copyright (c) 2012 Alexandre Trilla                                   |
|                                                                         |
|   ___________________________________________________________________   |
|                                                                         |
|   This file is part of nlpTools.                                        |
|                                                                         |
|   nlpTools is free software: you can redistribute it and/or modify      |
|   it under the terms of the MIT/X11 License as published by the         |
|   Massachusetts Institute of Technology. See the MIT/X11 License        |
|   for more details.                                                     |
|                                                                         |
|   You should have received a copy of the MIT/X11 License along with     |
|   this source code distribution of nlpTools (see the COPYING file       |
|   in the root directory). If not, see                                   |
|   <http://www.opensource.org/licenses/mit-license>.                     |
|_________________________________________________________________________|
-->

<?php

require(dirname(__FILE__)."/Classifier.php");

include_once("DB.php");
include_once(dirname(__FILE__)."/../util/dbauth/DBAuthManager.php");
include_once(dirname(__FILE__)."/../tokenisation/WhitespaceTok.php");

/**
 * @class MultinomialNaiveBayes
 * @brief Implementation of the Multinomial Naive Bayes classifier similar
 *     to the one that is described in Manning, et al. (2008).
 *
 * Instead of computing counts of documents for the priors, this
 * MultinomialNaiveBayes uses sums of class-wise term frequencies. The
 * rationale behind this decision is that the overall amount of instances
 * should not influence the prior term, in favour of the overall amount of 
 * actual terms in the text. By following this criterion, a class with
 * 1 sentence/instance and N instances would be comparable to another
 * class with one single instance composed of N sentences, regarding the 
 * amount of information that they may contain.
 *
 * --<br>
 * (Manning, et al., 2008) Manning, C. D., Raghavan, P. and Schutze, H., 
 * "Introduction to Information Retrieval", Cambridge: Cambridge 
 * University Press, 2008, ISBN: 0521865719 
 *
 * @author Alexandre Trilla (atrilla)
 */
class MultinomialNaiveBayes implements Classifier {

    /**
     * @brief The category-prior probability dictionary.
     */
    private $thePrior;

    /**
     * @brief The category-term conditional probability dictionary.
     */
    private $theCondProb;

    /**
     * @brief The name of the working database.
     */
    private $theDBName;

    /**
     * @brief Reference to a tokeniser to process plain text.
     */
    private $theTokeniser;

    /**
     * @brief Name of the table for the prior probabilities.
     */
    const tabPriorName = "prior";

    /**
     * @brief Name of the table for the conditional probabilities.
     */
    const tabCondName = "cond";

    /**
     * @brief Default constructor.
     *
     * @post Initialises the classifier with a tokeniser.
     */
    public function __construct() {
        $this->theTokeniser = new WhitespaceTok;
    }

    /**
     * @see Classifier#train(array &$dataTrain, array &$dataLabel)
     */
    public function train(array &$dataTrain, array &$dataLabel) {
        if (count($dataTrain) != count($dataLabel)) {
            throw new Exception("MultinomialNaiveBayes classifier: ".
                "different numbers of labelled instances are given!\n");
        }
        $catVocabCount = 
            $this->extractCatVocabCounts($dataTrain, $dataLabel);
        $total = 0;
        $catCount = array();
        $vocabulary = array();
        foreach($catVocabCount as $cat => $termCounts) {
            $catCount[$cat] = 0;
            foreach($termCounts as $term => $count) {
                // Total sum of term freqs in the corpus
                $catCount[$cat] += $count;
                $vocabulary[$term] = 1;
            }
            $total += $catCount[$cat];
        }
        $vocabSize = count($vocabulary);
        foreach($catCount as $cat => &$cCount) {
            foreach($catVocabCount[$cat] as $term => &$tCount) {
                $tCount = ($tCount + 1) / ($cCount + $vocabSize);
            }
            // For all the rest of terms in the vocabulary...
            // which are OOV wrt the given category...
            $catVocabCount[$cat][Classifier::OOV] = 1 / 
                ($cCount + $vocabSize);
            $cCount /= $total;
        }
        $this->thePrior = &$catCount;
        $this->theCondProb = &$catVocabCount;
    }

    /**
     * @brief Counts the frequency of terms per category.
     *
     * @param text Data instances, e.g., in textual form.
     * @param lab Instance labels.
     * @return Dictionary of category-term counts.
     *
     * @pre Data instances should be in textual form.
     * @pre Parameters must be arrays of the same length.
     * @post Dictionary of category-term frequencies is delivered.
     */
    private function extractCatVocabCounts(array &$text, array &$lab) {
        $catVoc = array();
        foreach(range(0, count($text) - 1) as $ind) {
            if (!array_key_exists($lab[$ind], $catVoc)) {
                $catVoc[$lab[$ind]] = array();
                $workingProb = &$catVoc[$lab[$ind]];
            } else {
                $workingProb = &$catVoc[$lab[$ind]];
            }
            // parse text with space char
            $words = $this->theTokeniser->tokenise($text[$ind]);
            foreach($words as $word) {
                if (!array_key_exists($word, $workingProb)) {
                    $workingProb[$word] = 1;
                } else {
                    $workingProb[$word] += 1;
                }
            }
        }
        return $catVoc;
    }

    /**
     * @see Classifier#setDatabase($name)
     */
    public function setDatabase($name) {
        $name = (string)$name;
        if (getPrefixID() != "") {
            $this->theDBName = getPrefixID()."_".$name;
        } else {
            $this->theDBName = $name;
        }
    }

    /**
     * @see Classifier#save()
     */
    public function save() {
        $db = DB::connect(getConnection());
        if (DB::isError($db)) {
            throw Exception("MultinomialNaiveBayes classifier: ".
                "DBMS connection error! ".$db->getMessage()."\n");
        } else {
            $db->query("CREATE DATABASE ".$this->theDBName.";");
            // Trained classifier
            assert(!is_null($this->thePrior) && 
                !is_null($this->theCondProb));
            $db->query("USE ".$this->theDBName.";");
            $db->query("CREATE TABLE ".
                MultinomialNaiveBayes::tabPriorName.
                " ( Category varchar(255), Probability Double );");
            foreach($this->thePrior as $cat => $prob) {
                $db->query("INSERT INTO ".
                    MultinomialNaiveBayes::tabPriorName.
                    " VALUES ( '$cat', $prob );");
            }
            // By using one table for each category, the amount
            // of cat-wise terms is reduced drastically due to
            // sparseness issues.
            foreach($this->theCondProb as $cat => $termProb) {
                $db->query("CREATE TABLE ".
                    MultinomialNaiveBayes::tabCondName."_$cat".
                    " ( Term varchar(255), Probability Double )");
                foreach($termProb as $term => $prob) {
                    $db->query("INSERT INTO ".
                        MultinomialNaiveBayes::tabCondName."_$cat".
                        " VALUES ( '$term', $prob );");
                }
            }
            $db->disconnect();
        }
    }

    /**
     * @brief Bayes decision rule.
     *
     * @see Classifier#classify(&$dataTest)
     */
    public function classify($dataTest) {
        $db = DB::connect(getConnection().$this->theDBName);
        if (DB::isError($db)) {
            throw new Exception("MultinomialNaiveBayes classifier: ".
                "DB connection error! ".$db->getMessage()."\n");
        } else {
            $dataTest = (string)$dataTest;
            assert(!is_null($db->query("SHOW TABLES;")));
            $decision = "indeterminate";
            $probDecision = 0;
            $words = $this->theTokeniser->tokenise($dataTest);
            $catLabel = $db->getCol("SELECT Category FROM ".
                MultinomialNaiveBayes::tabPriorName.";");
            foreach($catLabel as $cat) {
                $prior = $db->getOne("SELECT Probability FROM ".
                    MultinomialNaiveBayes::tabPriorName.
                    " WHERE Category = '$cat';");
                $score = log($prior);
                foreach($words as $word) {
                    $itExists = $db->getOne("SELECT Probability FROM ".
                        MultinomialNaiveBayes::tabCondName."_$cat".
                        " WHERE Term = '$word';");
                    if (!is_null($itExists)) {
                        $score += log($itExists);
                    } else {
                        $oovProb = $db->getOne("SELECT Probability ".
                            "FROM ".
                            MultinomialNaiveBayes::tabCondName."_$cat".
                            " WHERE Term = '".Classifier::OOV."';");
                        $score += log($oovProb);
                    }
                }
                if ($decision == "indeterminate") {
                    $decision = $cat;
                    $probDecision = $score;
                } elseif ($score > $probDecision) {
                    $decision = $cat;
                    $probDecision = $score;
                }
            }
            return $decision;
        }
    }
}

?>
