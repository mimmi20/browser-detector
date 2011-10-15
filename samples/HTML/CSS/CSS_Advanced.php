<?php
/**
 * Grouping selectors example
 *
 * PHP versions 4 and 5
 *
 * @category   HTML
 * @package    HTML_CSS
 * @subpackage Examples
 * @author     Klaus Guenther <klaus@capitalfocus.org>
 * @copyright  2003-2009 Klaus Guenther, Laurent Laville
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD
 * @version    CVS: $Id: CSS_Advanced.php,v 1.5 2009/01/19 23:22:38 farell Exp $
 * @link       http://pear.php.net/package/HTML_CSS
 * @ignore
 */

require_once 'HTML/CSS.php';

$css = new HTML_CSS();

// define styles
$css->setStyle('p', 'text-align', 'center');
$css->setStyle('p', 'color', '#ffffff');
$css->setStyle('p', 'text-align', 'left');
$css->setStyle('p', 'font', '16pt helvetica, arial, sans-serif');
$css->setStyle('p', 'font', '12pt helvetica, arial, sans-serif');

$css->createGroup('p, a', 'myGroup');
$css->setGroupStyle('myGroup', 'font', '12pt helvetica, arial, sans-serif');

// output the stylesheet directly to browser
$css->display();
?>