<?php
include(dirname(__FILE__).
    "/../core/classification/MultinomialNaiveBayes.php");
include(dirname(__FILE__).
    "/../core/util/feeding/FeedRSS.php");
include(dirname(__FILE__)."/pagemaker.php");
putHeader("Opinion Mining and Sentiment Analysis");
?>

<p>Identifies the semantic orientation, aka polarity, that is expressed
in subjective text such as written opinions. 
Overall, what this task aims to accomplish is sensing and
predicting whether a given text shows a 
<font style='background-color: #90EE90'>positive</font>, 
<font style='background-color: #FFA07A'>negative</font> or
<font style='background-color: #DCDCDC'>neutral</font>
sentiment/feeling.</p>

<p>In order to produce this system, a Text Classification technique
has to be adapted to a given application domain. In this demo, the
<a href='http://nlp.cs.swarthmore.edu/semeval/'>SemEval-2007 dataset</a>
is of use for training the classifier, and the learnt model is then 
applied to processing similar world news headlines from 
The Washington Post:</p>

<?php
// Prepare classifier
$classifier = new MultinomialNaiveBayes();
$classifier->setDatabase("semeval07");

// Prepare data
$feeder = new FeedRSS();
$aFeeds = 
    $feeder->getFood("http://feeds.washingtonpost.com/rss/world");
foreach($aFeeds as $feed) {
    $lab = $classifier->classify($feed["title"]);
    if ($lab == "NEG") {
        echo "<p class='neg'>";
    } elseif ($lab == "NEU") {
        echo "<p class='neu'>";
    } else {
        echo "<p class='pos'>";
    }
    echo "&#8226;&nbsp;&nbsp;".$feed["title"].
        " - <a href='".$feed["link"]."'>Read more</a></p>";
}

?>

<?php
putFooter();
?>
