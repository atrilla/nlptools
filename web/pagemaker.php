<?php
function putHeader($menuopt) {
    echo("
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN'
'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>

<html xmlns='http://www.w3.org/1999/xhtml'>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <title>nlpTools - Natural Language Processing Toolkit for PHP</title>
    <link href='style.css' type='text/css' rel='stylesheet' />
    <meta name='keywords' content='engineering, information technology, 
      web, php, natural language processing, computational linguistics, 
      machine learning, artificial intelligence, data mining, pattern 
      recognition, pattern classification, knowledge, software, code, 
      development, free software, open source' />
    <meta name='description' content='Natural Language Processing Toolkit
      for PHP' />
    <link href='favicon.ico' rel='icon' type='image/x-icon' />
    <a href='http://github.com/atrilla/nlptools'><img style='position: absolute; top: 0; left: 0; border: 0;' src='forkme.png' alt='Fork nlpTools on GitHub'></a>
  </head>
  <body>
    <div id='main'>
      <center><img src='nlptoolslogo.png' 
        alt='nlpTools - Natural Language Processing Toolkit for PHP'>
      </center>
    </div>
    <div id='menu'>
      <ul>");
    $menulab = $menuopt;
    if ($menuopt == "about") {
        $menulab = "About";
        echo("<li>About</li>");
    } else {
        echo("<li><a href='index.php'>About</a></li>");
    }
    if ($menuopt == "guidelines") {
        $menulab = "Guidelines";
        echo("<li>Guidelines</li>");
    } else {
        echo("<li><a href='guidelines.php'>Guidelines</a></li>");
    }
    if ($menuopt == "code") {
        $menulab = "Code";
        echo("<li>Code</li>");
    } else {
        echo("<li><a href='code.php'>Code</a></li>");
    }
    if ($menuopt == "appdemos") {
        $menulab = "Demos";
        echo("<li>Demos</li>");
    } else {
        echo("<li><a href='appdemos.php'>Demos</a></li>");
    }
    if ($menuopt == "api") {
        $menulab = "API";
        echo("<li>API</li>");
    } else {
        echo("<li><a href='api.php'>API</a></li>");
    }

    echo("
      </ul>
    </div>
    <h1>$menulab</h1>");
}


function putFooter() {
    echo("<div id=footer>All contents &copy; Alexandre Trilla 2012-");
    echo(date('Y'));
    echo("</div>
  </body>
</html>");
}

?>
