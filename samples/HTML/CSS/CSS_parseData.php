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
 * @copyright  2005-2009 Laurent Laville
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD
 * @version    CVS: $Id: CSS_parseData.php,v 1.8 2009/01/19 23:22:39 farell Exp $
 * @link       http://pear.php.net/package/HTML_CSS
 * @since      File available since Release 1.0.0RC2
 * @ignore
 */

require_once 'HTML/CSS.php';

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
    "print.css",
    "default.css"
);

$prefs   = array(
    'push_callback' => 'myErrorHandler',
);
$attribs = null;

$css = new HTML_CSS($attribs, $prefs);

$res = $css->parseData($styles);
if ($css->isError($res)) {
    $line  = __LINE__ - 1;
    $style = 'background-color:red; color:yellow; font-weight:bold; padding:0.4em;';
    echo '<p style="'.$style.'">Error message detected by isError() at line ' .
        $line . '</p>';
}
print 'Still alive !';
?>