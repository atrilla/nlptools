<?php
include(dirname(__FILE__)."/pagemaker.php");
putHeader("code");
?>

<p>Written in the PHP programming language for its suitability to process
text on the web (i.e., by definition, the Hypertext Preprocessor). The 
latest version of the toolkit is available from the 
<a href="https://github.com/atrilla/nlptools">repo</a>.</p>

<h2>Design by Contract</h2>

<p>Loosely coupled modular design, with orthogonality, reusability and 
extensibility in mind, to not compromise its future growth. Designing
with Contracts is the 
<a href="http://www.codinghorror.com/blog/files/Pragmatic%20Quick%20Reference.htm">Pragmatic Programmer</a>'s tip 31.</p>

<p>
Specific preconditions on parameter types are enforced with Type Hinting on
objects and arrays, and casts to string, int, bool or float, on primitive
types. Therefore, it is of utmost importance to consider the parameter
descriptions in the 
<a href="../doc/html/">documentation</a> 
and to follow the contracts defined in the interface prototypes.
</p>

<p>
Other preconditions unrelated to type checking are asserted.
</p>

<p>
The rationale for using exceptions is to throw them <i>only</i> for
Exceptional Problems (tip 34). The strict following of the contracts 
should suffice to operate successfully.
</p>


<?php
putFooter();
?>
