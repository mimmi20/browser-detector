<?php
/**
 * @ignore
 */
header('Content-Type: text/plain');
require_once 'HTML/CSS.php';

function myErrorHandler($code, $level)
{
    return PEAR_ERROR_PRINT;  // rather than PEAR_ERROR_DIE
}

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

$prefs = array(
    'push_callback' => 'myErrorHandler',
);

$css = new HTML_CSS(null, $prefs);
$css->setStyle('html', 'height', '100%');

$css->createAtRule('@charset', '"UTF-8"');
$css->createAtRule('@import', 'url("foo.css") screen, print');

//$css->unsetAtRule('@Charset');

$css->setAtRuleStyle('@media', 'screen', '', 'color', 'green');
$css->setAtRuleStyle('@media', 'screen', '', 'background-color', 'yellow');
$css->setAtRuleStyle('@media', 'print', 'blockquote', 'font-size', '16pt');
$css->setAtRuleStyle('@page', ':first', '', 'size', '3im 8im');
$css->setAtRuleStyle('@font-face', '', '', 'font-family', 'dreamy');
$css->setAtRuleStyle('@font-face', '', '', 'font-weight', 'bold');
$css->setAtRuleStyle('@font-face', '', '', 'src', 'url(http://www.example.com/font.eot)');

var_export($css->toArray());

echo PHP_EOL .$css->toString() . PHP_EOL;
?>