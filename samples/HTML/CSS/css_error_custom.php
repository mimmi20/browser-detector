<?php
/**
 * Customize error renderer with default PEAR_Error object.
 *
 * PHP versions 4 and 5
 *
 * @category   HTML
 * @package    HTML_CSS
 * @subpackage Examples
 * @author     Klaus Guenther <klaus@capitalfocus.org>
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @copyright  2005-2009 Klaus Guenther, Laurent Laville
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD
 * @version    CVS: $Id: css_error_custom.php,v 1.9 2009/01/19 23:22:39 farell Exp $
 * @link       http://pear.php.net/package/HTML_CSS
 * @since      File available since Release 1.0.0RC1
 * @ignore
 */

require_once 'HTML/CSS.php';
require_once 'PEAR.php';

/**
 * Determine whether to display or log an error.
 *
 * @param object $pb_error instance of HTML_CSS_Error
 *
 * @return  void
 * @ignore
 */
function myErrorCallback($pb_error)
{
    $keys = array('error_message_prefix', 'mode', 'level', 'code', 'message');

    foreach ($keys as $i => $k) {
        printf("%s = %s <br/>\n", $k, $pb_error->$k);
    }
    echo '<hr/>';
}

/**
 * Replace default internal error handler.
 *
 * Print rather than dies if the error is an exception.
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
    if ($level == 'exception') {
        return PEAR_ERROR_PRINT;  // rather than PEAR_ERROR_DIE
    } else {
        return PEAR_ERROR_CALLBACK;
    }
}

/**
 * Be sure that we will print and log error details.
 * @see HTML_CSS_Error::log()
 */
ini_set('display_errors', 1);
ini_set('log_errors', 1);


// Example A. ---------------------------------------------

PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'myErrorCallback');

$css1 = new HTML_CSS();

// A1. Error
$group1 = $css1->createGroup('body, html', 'grp1');
$group2 = $css1->createGroup('p, html', 'grp1');


// Example B. ---------------------------------------------

$displayConfig = array(
    'lineFormat' => '<b>%1$s</b>: %2$s<br/>%3$s<hr/>',
    'contextFormat' =>   '<b>File:</b> %1$s <br />'
                       . '<b>Line:</b> %2$s <br />'
                       . '<b>Function:</b> %3$s '
);

$prefs = array(
    'push_callback' => 'myErrorHandler',
    'handler' => array('display' => $displayConfig)
);

$css2 = new HTML_CSS(null, $prefs);

// B1. Error
$css2->getStyle('h1', 'class');

// B2. Exception
$css2->setXhtmlCompliance('true');

print 'still alive !';
?>