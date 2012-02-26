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
|   File    : FeedRSS.php                                                 |
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

/**
 * @class FeedRSS
 * @brief Data provider from RSS feeds. 
 *
 * @author Alexandre Trilla (atrilla)
 */
class FeedRSS implements Feeder {

    /**
     * @brief Maximum number of items to retrieve.
     */
    private $maxItems = 20;

    /**
     * @returns Multiarray of feeds.
     *
     * @see Feeder#getFood($sourceURL)
     */
    public function getFood($sourceURL) {
        $sourceURL = (string)$sourceURL;
        // http://www.softarea51.com/tutorials/parse_rss_with_php.html
        $doc = new DOMDocument();
        $ok = $doc->load($sourceURL);
        if (!$ok) {
            throw new Exception("FeedRSS feeder: ".
                "source cannot be loaded!\n");
        } else {
	        $arrFeeds = array();
	        $newsCount = 0;
	        foreach ($doc->getElementsByTagName("item") as $node) {
		        if ($newsCount >= $this->maxItems) {
		            break;
		        } else {
		            $newsCount += 1;
		        }
	            $itemRSS = array ( 
	                "title" => $node->getElementsByTagName("title")->item(0)->nodeValue,
	                "desc" => $node->getElementsByTagName("description")->item(0)->nodeValue,
	                "link" => $node->getElementsByTagName("link")->item(0)->nodeValue,
	                "date" => $node->getElementsByTagName("pubDate")->item(0)->nodeValue
	                );
	            array_push($arrFeeds, $itemRSS);
            }
        }
        return $arrFeeds;
    }

    /**
     * @brief Sets the maximum number of items to retrieve.
     *
     * @param maxits The maximum number of items to retrieve.
     *
     * @pre The maximum number of items must be an integer number
     *     greater than zero.
     * @post The maximum number of items to retrieve is set.
     */
    public function setMaxItems($maxits) {
        $maxits = (int)$maxits;
        assert($maxits > 0);
        $this->maxItems = $maxits;
    }
}

?>
