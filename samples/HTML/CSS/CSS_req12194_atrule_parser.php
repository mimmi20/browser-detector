<?php
/**
 * @ignore
 */
header('Content-Type: text/plain');
require_once 'HTML/CSS.php';

$cssDef = <<<EOD
@import  url("foo.css") screen, print;
@media screen { color: green; background-color: yellow; }
@media    print {
    blockquote { font-size: 16pt }
}
html { height: 100%; }
@charset "UTF-8";
@page thin:first  { size: 3in 8in }
@font-face {
    font-family: dreamy;
    font-weight: bold;
    src: url(http://www.example.com/font.eot);
}
EOD;

$css = new HTML_CSS();
$css->parseString($cssDef);

echo $css->toString() . PHP_EOL;

var_export($css->toArray());
?>