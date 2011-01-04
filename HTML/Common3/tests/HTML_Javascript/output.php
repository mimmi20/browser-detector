<?php
/**
* A file intended for testing output direction in the HTML_Javascript class
*/
require_once('HTML/Javascript.php');
$js = new HTML_Javascript();
$js->setOutputMode(HTML_JAVASCRIPT_OUTPUT_FILE, '/tmp/out.js');
$js->prompt('Foo?', 'foo', 'Bar!');
$js->alert('Muhahaha!');
?>
