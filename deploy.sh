#!/bin/sh

#                           _    _______          _     
#                          | |  |__   __\        | |    
#                     _ __ | |_ __ | | ___   ___ | |___ 
#                    | '_ \| | '_ \| |/ _ \ / _ \| / __|
#                    | | | | | |_) | | (_) | (_) | \__ \
#                    |_| |_|_| .__/|_|\___/ \___/|_|___/
# ___________________________| |_________________________________________
#                            |_|                                        |\
#                                                                       |_\
#   File    : deploy.sh                                                   |
#   Created : 27-Feb-2012                                                 |
#   By      : atrilla                                                     |
#                                                                         |
#   nlpTools - Natural Language Processing Toolkit for PHP                |
#                                                                         |
#   Copyright (c) 2012 Alexandre Trilla                                   |
#                                                                         |
#   ___________________________________________________________________   |
#                                                                         |
#   This file is part of nlpTools.                                        |
#                                                                         |
#   nlpTools is free software: you can redistribute it and/or modify      |
#   it under the terms of the MIT/X11 License as published by the         |
#   Massachusetts Institute of Technology. See the MIT/X11 License        |
#   for more details.                                                     |
#                                                                         |
#   You should have received a copy of the MIT/X11 License along with     |
#   this source code distribution of nlpTools (see the COPYING file       |
#   in the root directory). If not, see                                   |
#   <http://www.opensource.org/licenses/mit-license>.                     |
#_________________________________________________________________________|

echo "Removing project files..."
rm *.md
rm COPYING
rm -rf web/util/

echo "Spreading custom php.ini..."
for i in `find . -type d`; do cp php.ini $i; done
rm doc/php.ini

echo "Generating the documentation..."
doxygen doc/nlptools.dox.cfg

echo "WARNING: Fix the DB parameters in core/util/dbauth/DBAuthManager.php"

echo "Delete this file."

echo "Then compress everything and deploy to webserver..."
