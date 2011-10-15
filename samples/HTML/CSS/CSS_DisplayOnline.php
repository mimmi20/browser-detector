<?php
/**
 * Example to produces an external stylesheet declarations to browser output
 *
 * PHP versions 4 and 5
 *
 * @category   HTML
 * @package    HTML_CSS
 * @subpackage Examples
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @copyright  2007-2009 Laurent Laville
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD
 * @version    CVS: $Id: CSS_DisplayOnline.php,v 1.5 2009/01/19 23:22:38 farell Exp $
 * @link       http://pear.php.net/package/HTML_CSS
 * @ignore
 */

require_once 'HTML/CSS.php';

$css = new HTML_CSS();

if (version_compare($css->apiVersion(), '1.3.0') >= 0) {
    // ability to download result as 'exOnline.css' file
    $css->setContentDisposition(true, 'exOnline.css');
}

// define styles
$css->setStyle('body', 'background-color', '#0c0c0c');
$css->setStyle('body', 'color', '#ffffff');
$css->setStyle('h1', 'text-align', 'center');
$css->setStyle('h1', 'font', '16pt helvetica, arial, sans-serif');
$css->setStyle('p', 'font', '12pt helvetica, arial, sans-serif');

// output the stylesheet directly to browser
$css->display();
?>