10-Mar-2013  Alexandre Trilla  <alex@atrilla.net

* api/index.php: getMethod brackets.

* api/RestUtils.php: form encoded data used to obtain array.


08-Mar-2013  Alexandre Trilla  <alex@atrilla.net

* api/index.php: creation.


07-Mar-2013  Alexandre Trilla  <alex@atrilla.net

* api/RestUtils.php: creation.
* api/RestRequest.php: creation.


27-Feb-2012  Alexandre Trilla  <alex@atrilla.net

* core/util/dbauth/DBAuthManager.php (getPrefixID): DB ID.
* core/classification/MultinomialNaiveBayes.php (setDatabase)


26-Feb-2012  Alexandre Trilla  <alex@atrilla.net

* web/topicid.php: classification based on title and description
    trash removed with regexp.
* web/appdemos.php


22-Feb-2012  Alexandre Trilla  <alex@atrilla.net

* core/util/feeding/FeedRSS.php (setMaxItems): added function. To be
    documented.

* web/topicid.php: creation. Analysis based on RSS description (too
    slow). Links appear there also.


19-Feb-2012  Alexandre Trilla  <alex@atrilla.net

* core/classification/MultinomialNaiveBayes.php (train, classify): 
    vocabSize should be the vocabulary size from the whole dataset,
    pass by value.
* core/classification/Classifier.php


18-Feb-2012  Alexandre Trilla  <alex@atrilla.net

* core/classification/MultinomialNaiveBayes.php (classify):
    exception throwing (new).

* core/util/feeding/FeedRSS (getFood): exception throwing (new).


17-Feb-2012  Alexandre Trilla  <alex@atrilla.net

* core/classification: former classification.
* core/tokenisation: former tokenisation.
* core/util: former util.

* web: creation.
* web/util/ClassifierTrainer.php: 
    former util/training/ClassifierTrainer.php.

* core/tokenisation/WhitespaceTok.php (tokenise): split punctuation 
    marks.


16-Feb-2012  Alexandre Trilla  <alex@atrilla.net

* util/training/ClassifierTrainer.php: creation.

* util/feeding/Feeder.php: creation.
* util/feeding/Dataset.php: creation.
* util/feeding/FeedRSS.php: creation.

* util/dbauth/DBAuthManager.php: creation.

* tokenisation/Tokeniser.php: creation.
* tokenisation/WhitespaceTok.php: creation.

* classification/Classifier.php: prototypes definitions maintained, 
    redefined functions.
* classification/MultinomialNaiveBayes.php: creation.


15-Feb-2012  Alexandre Trilla  <alex@atrilla.net

* classification/Classifier.php: creation. 
