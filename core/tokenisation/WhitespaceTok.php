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
|   File    : WhitespaceTok.php                                           |
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

require(dirname(__FILE__)."/Tokeniser.php");

/**
 * @class WhitespaceTok
 * @brief Splits the words from a text by whitespace characters.
 *
 * Punctuation marks are also split from accompanying words.
 *
 * @author Alexandre Trilla (atrilla)
 */
class WhitespaceTok implements Tokeniser {

    /**
     * @see Tokeniser#tokenise(&$text)
     */
    public function tokenise(&$text) {
        $text = (string)$text;
        $text = trim($text);
        $text = preg_replace("/[^a-zA-Z0-9\ ]/", " $0 ", $text);
        $text = preg_replace("/\ \ +/", " ", $text);
        $words = explode(" ", $text);
        return $words;
    }
}

?>
