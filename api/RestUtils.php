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
|   File    : RestUtils.php                                               |
|   Created : 07-Mar-2013                                                 |
|   By      : atrilla                                                     |
|                                                                         |
|   nlpTools - Natural Language Processing Toolkit for PHP                |
|                                                                         |
|   Copyright (c) 2013 Alexandre Trilla                                   |
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

require(dirname(__FILE__)."/RestRequest.php");
/**
 * @brief Provides REST utilities.
 * See: http://www.gen-x-design.com/archives/create-a-rest-api-with-php
 *
 * @author Alexandre Trilla (atrilla)
 */
class RestUtils  
{  
    public static function processRequest()  
    {  
        // get our verb  
        $request_method = strtolower($_SERVER['REQUEST_METHOD']);  
        $return_obj     = new RestRequest();  
        // we'll store our data here  
        $data           = array();  
      
        // only POST is available
        switch ($request_method)  
        {  
            case 'post':  
                $data = $_POST;  
                break;  
        }  
      
        // store the method  
        $return_obj->setMethod($request_method);  
      
        // set the raw data, so we can access it if needed (there may be  
        // other pieces to your requests)  
        $return_obj->setRequestVars($data);  
      
        if(isset($data['service']))  
        {  
            // translate the JSON to an Object for use however you want  
            $return_obj->setService($data['service']);  
        }  

        if(isset($data['text']))  
        {  
            $return_obj->setTextToProc($data['text']);  
        }  

        return $return_obj;  
    }
  
	public static function sendResponse($status = 200, $body = '', $content_type = 'text/html')  
	{  
	    $status_header = 'HTTP/1.1 ' . $status . ' ' . RestUtils::getStatusCodeMessage($status);  
	    // set the status  
	    header($status_header);  
	    // set the content type  
	    header('Content-type: ' . $content_type);  
	  
	    // pages with body are easy  
	    if($body != '')  
	    {  
	        // send the body  
	        echo $body;  
	        exit;  
	    }  
	    // we need to create the body if none is passed  
	    else  
	    {  
	        // create some body messages  
	        $message = '';  
	  
	        // this is purely optional, but makes the pages a little nicer to read  
	        // for your users.  Since you won't likely send a lot of different status codes,  
	        // this also shouldn't be too ponderous to maintain  
	        switch($status)  
	        {  
	            case 400:  
	                $message = 'Please review the API format.';  
	                break;  
	            case 401:  
	                $message = 'I\'m sorry, but you exceeded the demo query limits to validate NLPTools. I would be very glad to know about your interest in NLPTools and to work out a solution with you. If there is anything I can do for you, please don\'t hesitate to drop me a line at alex (at) atrilla.net  --Alex';
	                break;  
	        }  
	  
	        // servers don't always have a signature turned on (this is an apache directive "ServerSignature On")  
	        $signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];  
	  
	        // this should be templatized in a real-world solution  
	        $body = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">  
	                    <html>  
	                        <head>  
	                            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">  
	                            <title>' . $status . ' ' . RestUtils::getStatusCodeMessage($status) . '</title>  
	                        </head>  
	                        <body>  
	                            <h1>' . RestUtils::getStatusCodeMessage($status) . '</h1>  
	                            <p>' . $message . '</p>  
	                            <hr />  
	                            <address>' . $signature . '</address>  
	                        </body>  
	                    </html>';  
	  
	        echo $body;  
	        exit;  
	    }  
	}
  
    public static function getStatusCodeMessage($status)  
    {  
        // these could be stored in a .ini file and loaded  
        // via parse_ini_file()... however, this will suffice  
        // for an example  
        $codes = Array(  
            100 => 'Continue',  
            101 => 'Switching Protocols',  
            200 => 'OK',  
            201 => 'Created',  
            202 => 'Accepted',  
            203 => 'Non-Authoritative Information',  
            204 => 'No Content',  
            205 => 'Reset Content',  
            206 => 'Partial Content',  
            300 => 'Multiple Choices',  
            301 => 'Moved Permanently',  
            302 => 'Found',  
            303 => 'See Other',  
            304 => 'Not Modified',  
            305 => 'Use Proxy',  
            306 => '(Unused)',  
            307 => 'Temporary Redirect',  
            400 => 'Bad Request',  
            401 => 'Unauthorized',  
            402 => 'Payment Required',  
            403 => 'Forbidden',  
            404 => 'Not Found',  
            405 => 'Method Not Allowed',  
            406 => 'Not Acceptable',  
            407 => 'Proxy Authentication Required',  
            408 => 'Request Timeout',  
            409 => 'Conflict',  
            410 => 'Gone',  
            411 => 'Length Required',  
            412 => 'Precondition Failed',  
            413 => 'Request Entity Too Large',  
            414 => 'Request-URI Too Long',  
            415 => 'Unsupported Media Type',  
            416 => 'Requested Range Not Satisfiable',  
            417 => 'Expectation Failed',  
            500 => 'Internal Server Error',  
            501 => 'Not Implemented',  
            502 => 'Bad Gateway',  
            503 => 'Service Unavailable',  
            504 => 'Gateway Timeout',  
            505 => 'HTTP Version Not Supported'  
        );  
  
        return (isset($codes[$status])) ? $codes[$status] : '';  
    }  
}
 
?>
