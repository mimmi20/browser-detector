<?php
/**
 * Tell whether a value return by HTML_CSS is an error.
 * Solution to use HTML_CSS::isError() method.
 *
 * PHP versions 4 and 5
 *
 * @category   HTML
 * @package    HTML_CSS
 * @subpackage Examples
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @copyright  2005-2008 Laurent Laville
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD
 * @version    CVS: $Id: CSS_parseData.php 86 2011-10-13 19:17:16Z tmu $
 * @link       http://pear.php.net/package/HTML_CSS
 * @since      File available since Release 1.0.0RC2
 * @ignore
 */

require_once 'HTML/CSS3.php';

/**
 * Replace default internal error handler.
 *
 * Always print rather than dies if the error is an exception.
 *
 * @param int    $code  a numeric error code.
 *                      Valid are HTML_CSS_ERROR_* constants
 * @param string $level error level ('exception', 'error', 'warning', ...)
 *
 * @return  integer
 * @ignore
 */
function myErrorHandler($code, $level)
{
    return PEAR_ERROR_PRINT;  // always print all error messages
}

/*
body { font-size: 1em; }

---- print.css ----
*{
margin: 4px; padding: 0px;
}

body{
font-family: Tahoma, Verdana, Helvetica, Arial, sans-serif;
text-align:center;
background-color:#fff;
}

---- default.css ----
*{
margin: 0px; padding: 0px;
}

body{
font-family: Lucida Grande, Tahoma, Verdana, Arial, sans-serif;
text-align:center;
background-color:#fff;
}
*/

$styles = array(
    "body { font-size: 1em; }",
    "fixed.css",
    "kredite_antrag.css",
    "mrmoney.antrag.css",
    "mrmoney.antrag.OLD.css",
    "mrmoney.css",
    "print.css",
    "pvg.head.css",
    "ssd.css",
    "standard.css",
    "standard_forms.css",
    "standard_google.css",
    "standard_modules.css",
    "standard_navigation.css",
    "standard_zusatz.css",
    "superextend.css"
);

$prefs   = array(
    'push_callback' => 'myErrorHandler',
);
$attribs = null;

ini_set('error_reporting', E_ALL ^ E_NOTICE | E_STRICT /**/);
ini_set('display_errors', 1);

$css = new HTML_CSS3($attribs, $prefs);

$res = $css->parseData($styles);

print 'Still alive !';
?>