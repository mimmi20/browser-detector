<?php
/**
 * New feature of version 1.1.0 explained :
 * Ability to find if an element or property is already defined and where
 *
 * PHP versions 4 and 5
 *
 * @category   HTML
 * @package    HTML_CSS
 * @subpackage Examples
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @copyright  2006-2009 Laurent Laville
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD
 * @version    CVS: $Id: CSS_grepStyles.php,v 1.6 2009/01/19 23:22:38 farell Exp $
 * @link       http://pear.php.net/package/HTML_CSS
 * @since      File available since Release 1.1.0
 * @ignore
 */

require_once 'HTML/CSS.php';

/**
 * HTML render for css grep results.
 *
 * @param array $styles HTML_CSS array output render
 *
 * @return void
 * @ignore
 */
function displayResults($styles)
{
    if (count($styles) == 0) {
        echo 'does not exists';
    } else {
        echo 'is already defined by ';

        echo '<h2>Class selectors </h2>';
        echo implode(', ', array_keys($styles));

        echo '<h2>Full Dump</h2>';
        echo '<pre>';
        var_dump($styles);
        echo '</pre>';
    }
}


$styleSheet = '
#PB1.cellPB1I, #PB1.cellPB1A {
  width: 15px;
  height: 20px;
  font-family: Courier, Verdana;
  font-size: 8px;
  float: left;
}

#PB1.progressBorderPB1 {
  width: 172px;
  height: 24px;
  border-width: 1px;
  border-style: solid;
  border-color: #404040 #dfdfdf #dfdfdf #404040;
  background-color: #CCCCCC;
}

.progressPercentLabelpct1PB1 {
  width: 50px;
  text-align: right;
  background-color: transparent;
  font-size: 11px;
  font-family: Verdana, Tahoma, Arial;
  font-weight: normal;
  color: #000000;
}

.progressTextLabeltxt1PB1 {
  text-align: left;
  background-color: transparent;
  font-size: 11px;
  font-family: Verdana, Tahoma, Arial;
  font-weight: normal;
  color: #000000;
}

.cellPB1I {
  background-color: #CCCCCC;
}

.cellPB1A {
  background-color: #0033FF;
}

body {
    background-color: #E0E0E0;
    color: #000000;
    font-family: Verdana, Arial;
}
';

$css = new HTML_CSS();
$css->parseString($styleSheet);

// 1. is class selector pattern ".progressBorder" already defined ?
$styles = $css->grepStyle('/.*\.progressBorder/');
echo '<h1>1. class selector pattern ".progressBorder"</h1>';
displayResults($styles);

// 2. is class selector pattern ".#PB1" already defined ?
$styles = $css->grepStyle('/^#PB1/');
echo '<h1>2. class selector pattern "#PB1"</h1>';
displayResults($styles);

// 3. is property "font-weight" already defined inside class selectors pattern #PB1?
$styles = $css->grepStyle('/^#PB1/', '/^font-weight$/');
echo '<h1>3. property "font-weight" inside class selector pattern "#PB1"</h1>';
displayResults($styles);

// 4. is property "color" already defined ?
$styles = $css->grepStyle('/./', '/^color$/');
echo '<h1>4. property "color"</h1>';
displayResults($styles);
?>