<?php
/**
 * Simply ignores html_css errors that occurs.
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
 * @version    CVS: $Id: css_error_ignore.php,v 1.9 2009/01/19 23:22:39 farell Exp $
 * @link       http://pear.php.net/package/HTML_CSS
 * @since      File available since Release 1.0.0RC1
 * @ignore
 */

require_once 'HTML/CSS.php';

/**
 * Replace default internal error handler.
 *
 * Ignore all errors
 *
 * @return  null
 * @ignore
 */
function myErrorHandler()
{
    return null;
}

// Example A. ---------------------------------------------

$attribs = array();
$prefs   = array('error_handler' => 'myErrorHandler');

$css1 = new HTML_CSS($attribs, $prefs);

// A1. Error
$group1 = $css1->createGroup('body, html', 'grp1');
$group2 = $css1->createGroup('p, html', 'grp1');

// A2. Error
$css1->getStyle('h1', 'class');

// A3. Exception
$css1->setXhtmlCompliance('true');

print 'still alive !';
?>