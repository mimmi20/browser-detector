<?php
/**
 * Check data source validity with W3C CSS validator service
 *
 * PHP version 5
 *
 * @category   HTML
 * @package    HTML_CSS
 * @subpackage Examples
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @copyright  2007-2009 Laurent Laville
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD
 * @version    CVS: $Id: CSS_validate.php,v 1.2 2009/01/19 23:22:39 farell Exp $
 * @link       http://pear.php.net/package/HTML_CSS
 * @since      File available since Release 1.5.0
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


$print_dot_css = '
*{
margin: 4px; padding: 0px;
}

body{
font-family: Tahoma, Verdana, Helvetica, Arial, sans-serif;
text-align:centre;
background-color:#fff;
}
';

$styles = array(
    "body { font-size: 1e; }",  // volontary error here on font-size dimension
    $print_dot_css              // volontary error here on body text-align property
);

$prefs   = array(
    'push_callback' => 'myErrorHandler',
);
$attribs = null;

$css = new HTML_CSS($attribs, $prefs);

$messages = array();
$valid    = $css->validate($styles, $messages);
if ($valid === false) {
    var_export($messages);
    /*
    Output will look like :
    -----------------------
    Error: invalid input, source #0 : 1 error(s), 0 warning(s)
           in HTML_CSS->validate (file CSS_validate.php on line 64)
    Error: invalid input, source #1 : 1 error(s), 0 warning(s)
           in HTML_CSS->validate (file CSS_validate.php on line 64)

    $messages content :
    array (
      'errors' =>
      array (
        0 =>
        array (
          'errortype' => 'parse-error',
          'context' => 'body',
          'property' => 'font-size',
          'uri' => NULL,
          'line' => '1',
          'message' => 'Unknown dimension',
        ),
        1 =>
        array (
          'errortype' => 'parse-error',
          'context' => 'body',
          'property' => 'text-align',
          'uri' => NULL,
          'line' => '8',
          'message' => 'centre is not a text-align value',
        ),
      ),
      'warnings' =>
      array (
      ),
    )
    Still alive !
    */
}
print "\nStill alive !";
?>