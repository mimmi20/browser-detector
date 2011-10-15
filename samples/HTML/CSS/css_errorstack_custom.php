<?php
/**
 * Customize error renderer with PEAR_ErrorStack.
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
 * @version    CVS: $Id: css_errorstack_custom.php,v 1.9 2009/01/19 23:22:39 farell Exp $
 * @link       http://pear.php.net/package/HTML_CSS
 * @since      File available since Release 1.0.0RC1
 * @ignore
 */

require_once 'HTML/CSS.php';
require_once 'HTML/CSS/Error.php';
require_once 'PEAR/ErrorStack.php';

/**
 * This class creates a css error stack object with help of PEAR_ErrorStack
 *
 * @category   HTML
 * @package    HTML_CSS
 * @subpackage Examples
 * @author     Klaus Guenther <klaus@capitalfocus.org>
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @copyright  2005-2009 Klaus Guenther, Laurent Laville
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD
 * @link       http://pear.php.net/package/HTML_CSS
 * @ignore
 */
class HTML_CSS_ErrorStack
{
    /**
     * HTML_CSS_ErrorStack class constructor
     */
    function HTML_CSS_ErrorStack()
    {
        $s = &PEAR_ErrorStack::singleton('HTML_CSS');
        $t = HTML_CSS_Error::_getErrorMessage();
        $s->setErrorMessageTemplate($t);
        $s->setContextCallback(array(&$this,'getBacktrace'));
        $logger = array(&$this,'log');
        $s->setLogger($logger);
        $s->pushCallback(array(&$this,'errorHandler'));
    }

    /**
     * Add an error to the HTML_CSS error stack
     *
     * @param int    $code   Package-specific error code
     * @param string $level  Error level.  This is NOT spell-checked
     * @param array  $params Associative array of error parameters
     *
     * @return PEAR_Error|array if compatibility mode is on
     */
    function push($code, $level, $params)
    {
        $s = &PEAR_ErrorStack::singleton('HTML_CSS');
        return $s->push($code, $level, $params);
    }

    /**
     * Get the call backtrace from where the error was generated.
     *
     * @return mixed bool|array
     */
    function getBacktrace()
    {
        if (function_exists('debug_backtrace')) {
            $backtrace = debug_backtrace();
            $backtrace = $backtrace[count($backtrace)-1];
        } else {
            $backtrace = false;
        }
        return $backtrace;
    }

    /**
     * Print the current error
     *
     * @param array $err user info error with call context
     *
     * @return void
     */
    function log($err)
    {
        global $prefs;

        $lineFormat    = '<b>%1$s:</b> %2$s<br/>[%3$s]<hr/>'."<br/>\n";
        $contextFormat = 'in <b>%1$s</b> on line <b>%2$s</b>';

        if (isset($prefs['handler']['display']['lineFormat'])) {
            $lineFormat = $prefs['handler']['display']['lineFormat'];
        }
        if (isset($prefs['handler']['display']['contextFormat'])) {
            $contextFormat = $prefs['handler']['display']['contextFormat'];
        }

        $context = $err['context'];

        if ($context) {
            $file = $context['file'];
            $line = $context['line'];

            $contextExec = sprintf($contextFormat, $file, $line);
        } else {
            $contextExec = '';
        }

        printf($lineFormat,
               ucfirst(get_class($this)) . ' ' . $err['level'],
               $err['message'],
               $contextExec);
    }

    /**
     * Error Callback used by PEAR_ErrorStack on each error raised
     *
     * @param array $err user info error with call context
     *
     * @return void|int
     */
    function errorHandler($err)
    {
        global $halt_onException;

        if ($halt_onException) {
            if ($err['level'] == 'exception') {
                return PEAR_ERRORSTACK_DIE;
            }
        }
    }
}

// set it to on if you want to halt script on any exception
$halt_onException = false;


// Example A. ---------------------------------------------

$stack =& new HTML_CSS_ErrorStack();

$attribs = array();
$prefs   = array('error_handler' => array(&$stack, 'push'));

// A1. Error
$css1 = new HTML_CSS($attribs, $prefs);

$group1 = $css1->createGroup('body, html', 'grp1');
$group2 = $css1->createGroup('p, html', 'grp1');


// Example B. ---------------------------------------------

$displayConfig = array(
    'lineFormat' => '<b>%1$s</b>: %2$s<br/>%3$s<hr/>',
    'contextFormat' =>   '<b>File:</b> %1$s <br/>'
                       . '<b>Line:</b> %2$s '
);
$attribs       = array();
$prefs         = array(
    'error_handler' => array(&$stack, 'push'),
    'handler' => array('display' => $displayConfig)
);

$css2 = new HTML_CSS($attribs, $prefs);

// B1. Error
$css2->getStyle('h1', 'class');

// B2. Exception
$css2->setXhtmlCompliance('true');


print 'still alive !';
?>