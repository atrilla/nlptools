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
|   File    : Classifier.php                                              |
|   Created : 15-Feb-2012                                                 |
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

/**
 * @interface Classifier
 * @brief Predicts the most suitable category label for given textual
 *     data.
 *
 * @author Alexandre Trilla (atrilla)
 */
interface Classifier {

    /**
     * @brief Out-of-vocabulary common symbol.
     */
    const OOV = "__OOV__";

    /**
     * @brief Trains the classifier with the given example data.
     *
     * @param dataTrain Data instances, e.g., in textual form.
     * @param dataLabel Instance labels.
     * @throws Exception if data/label sizes don't match, i.e., 
     *     different numbers of labelled instances are given.
     * 
     * @pre Parameters must be arrays of the same length.
     * @post Classification model is learnt in computer memory.
     */
    public function train(array &$dataTrain, array &$dataLabel);

    /**
     * @brief Sets the name of the database to operate on.
     *
     * @param name Name of the working database.
     *
     * @pre The given name should be a valid string.
     * @post The name of the working database is set.
     */
    public function setDatabase($name);

    /**
     * @brief Uploads the learnt parameters to a new database.
     *
     * @throws Exception if the connection to the database management
     *     system fails.
     *
     * @pre The classifier should be trained in computer memory.
     * @pre A valid and original database name should be set.
     * @post The learnt parameters are saved on the new database.
     */
    public function save();

    /**
     * @brief Predicts the most suitable category label for the given
     *     test data.
     *
     * @param dataTest The test data, e.g., in textual form.
     * @returns The predicted category label.
     * @throws Exception if the connection to the working database
     *     cannot be established.
     *
     * @pre The test data should be a valid string.
     * @pre A trained model should be available on the working
     *     database, i.e., an existing and non-empty database.
     * @post The most appropriate category label is delivered.
     */
    public function classify($dataTest);

    /**
     * @brief Likelihood/relatedness interface.
     *
     * @param dataTest The test data, e.g., in textual form.
     * @param cat The category to be evaluated.
     * @returns The likelihood score.
     * @throws Exception if the connection to the working database
     *     cannot be established.
     *
     * @pre The test and category data should be valid strings.
     * @pre A trained model should be available on the working
     *     database, i.e., an existing and non-empty database.
     * @post The similarity score is delivered.
     */
    public function likelihood($dataTest, $cat);
}

?>
