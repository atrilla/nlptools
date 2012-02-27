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
|   File    : DBAuthManager.php                                           |
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

/**
 * @brief Provides the credentials to connect to the DBMS.
 * @returns The credentials.
 *
 * Hard-coded in PHP code for security purposes.
 *
 * @author Alexandre Trilla (atrilla)
 */
function getConnection() {
    return "mysql://root:@localhost/";
}

/**
 * @brief Provides the DB prefix ID.
 * @returns The prefix ID.
 *
 * @author Alexandre Trilla (atrilla)
 */
function getPrefixID() {
    return "";
}

?>
