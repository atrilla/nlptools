<?php
include(dirname(__FILE__).
    "/../core/classification/MultinomialNaiveBayes.php");
include(dirname(__FILE__).
    "/../core/util/feeding/FeedRSS.php");
include(dirname(__FILE__)."/pagemaker.php");
putHeader("Text Categorisation and Topic/Domain Identification");
?>

<p>Identifies the semantic field of a given text and relates it
to its corresponding topic or domain.</p>

<p>In order to produce this system, a Text Classification technique
has to be adapted to a given set of application domains. In this demo, 
the <a href='http://kdd.ics.uci.edu/databases/reuters_transcribed/reuters_transcribed.html'>Reuters Transcribed Subset</a>
is of use for training the classifier, and the learnt model is then 
applied to predicting the topic of the most read articles from Reuters:</p>

<?php
// Prepare classifier
$classifier = new MultinomialNaiveBayes();
$classifier->setDatabase("ReutersTranscribedSubset");

// Prepare data
$feeder = new FeedRSS();
$aFeeds = 
    $feeder->getFood("http://feeds.reuters.com/reuters/MostRead?format=xml");
foreach($aFeeds as $feed) {
    $lab = $classifier->classify($feed["title"]);
    echo "<p><font color='#808080'>Topic: ".$lab."</font><br />";
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>"
        .$feed["title"]."</b>"." - <a href='".$feed["link"].
        "'>Read more</a><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
        preg_replace("/<.+>/", "", $feed["desc"])."</p>";
}

?>

<?php
putFooter();
?>
