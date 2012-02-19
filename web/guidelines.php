<?php
include(dirname(__FILE__)."/pagemaker.php");
putHeader("guidelines");
?>

<p>Please refer to the <a href="../doc/html/">documentation</a> for all
the usage details.

<h2>Installation</h2>
<p>The toolkit is deployed by directly copying the core wherever it is 
desired and by making it accessible to the applications. 
Module dependencies are set relative to their file paths.</p>

<p>The documentation has to be produced with Doxygen.</p>

<h2>Quick reference</h2>

<ul>
    <li><b><a href='../doc/html/interfaceClassifier.html'>Classifier</a></b> - Predicts the most suitable category label for given textual data.</li>
    <li><b><a href='../doc/html/interfaceFeeder.html'>Feeder</a></b> - Provides textual data to process.</li>
    <li><b><a href='../doc/html/interfaceTokeniser.html'>Tokeniser</a></b> - Splits a given text into smaller units called tokens.</li>
</ul>

<?php
putFooter();
?>
