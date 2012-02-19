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
|   File    : Dataset.php                                                 |
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

require(dirname(__FILE__)."/Feeder.php");

include_once(dirname(__FILE__)."/../../tokenisation/WhitespaceTok.php");

/**
 * @class Dataset
 * @brief Dataset handler. It separates the data from the labels.
 *
 * @author Alexandre Trilla (atrilla)
 */
class Dataset implements Feeder {

    /**
     * @param sourceURL Dataset file location.
     * @returns Multidimensional array separating the instance data 
     *     from the labels.
     *
     * @see Feeder#getFood($sourceURL)
     */
    public function getFood($sourceURL) {
        $text = array();
        $labs = array();
        $sourceURL = (string)$sourceURL;
        $sourceURL = realpath($sourceURL);
        if (!is_file($sourceURL)) {
            throw new Exception("Dataset feeder: source location ".
                "unknown!\n");
        } else {
            $contents = file_get_contents($sourceURL);
            $instance = explode("\n", $contents);
            // there's a blank line at the end
            array_pop($instance);
            $tokeniser = new WhitespaceTok;
            foreach($instance as $inst) {
                $words = $tokeniser->tokenise($inst);
                $labs[] = array_pop($words);
                $text[] = implode(" ", $words);
            }
        }
        return array($text, $labs);
    }
}

?>
