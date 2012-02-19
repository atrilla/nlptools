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
|   File    : ClassifierTrainer.php                                       |
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

include_once(dirname(__FILE__).
    "/../../core/classification/MultinomialNaiveBayes.php");
include_once(dirname(__FILE__).
    "/../../core/util/feeding/Dataset.php");

/**
 * @brief Simple online service to train classifiers.
 *
 * @author Alexandre Trilla (atrilla)
 */

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <title>nlptools / Classifier Trainer</title>
    </head>
    <body>
        <h1>nlptools / Classifier Trainer</h1>
        <h2>Simple script to train a model for Text Classification</h2>
        <form method="post" enctype="multipart/form-data">
            New DB name: <input type="text" name="newdbname" />
            <br />
            <font size="1">(No database with this name should
            exist!)</font>
            <br /><br />
            Training dataset file: <input type="file" name="datafile" />
            <br />
            <font size="1">(The last word in each instance should
            refer to the category!)</font>
            <br /><br />
            <input type="hidden" name="gotrain" value="true" />
            <input type="submit" value="Go!">
        </form>
        <p>
            <font size="2">
            Note: adjust the server parameter settings in order to
            cope with a long training time.
            </font>
        </p>
        <hr>
        <?php
        if (isset($_POST["gotrain"])) {
            if ($_POST["gotrain"] == "true") {
                if (($_FILES["datafile"]["error"] > 0) || 
                    (empty($_POST["newdbname"]))) {
                    echo "Error!!! Missing parameters!\n";
                } else {
                    try {
                        echo "<p>Loading dataset... ";
                        $dataset = new Dataset;
                        list($text, $labs) = 
                            $dataset->getFood($_FILES["datafile"]["tmp_name"]);
                        echo "OK</p>";
                        echo "<p>Training model... ";
                        $classifier = new MultinomialNaiveBayes();
                        $classifier->train($text, $labs);
                        echo "OK</p>";
                        echo "<p>Saving parameters... ";
                        $classifier->setDatabase($_POST["newdbname"]);
                        $classifier->save();
                        echo "OK</p>";
                        echo "<p><b>Training process completed ".
                            "successfully!</b></p>";
                    } catch (Exception $e) {
                        echo "Caught exception: ".$e->getMessage()."\n";
                    }
                }
            } 
        }

        ?>
    </body>
</html>
