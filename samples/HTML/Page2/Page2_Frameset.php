<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | HTML_Page2                                                           |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997 - 2004 The PHP Group                              |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Author: Klaus Guenther <klaus@capitalfocus.org>                      |
// +----------------------------------------------------------------------+
//
// $Id: Page2_Frameset.php 162026 2004-06-24 17:23:08Z thesaur $

require_once 'HTML/Page2.php';

$page = new HTML_Page2(array(
                             'doctype' => 'XHTML 1.0 Frameset',
                             'tab' => '  '
                             ));
// Page title defaults to "New XHTML 1.0 Frameset Compliant Page"

$page->addBodyContent('<p>Your browser does not support frames.</p>');

$page->frameset->addRows(array('logo' => 200, 'bottom' => '*'));

$page->frameset->addFrame('logo', 'logo.htm');
$page->frameset->logo->setScrolling('no');

$page->frameset->addFrameset('bottom');
$page->frameset->bottom->addColumns(array('menu' => 200, 'main' => '*'));
$page->frameset->bottom->addFrame('menu', 'menu.htm', 'main');
$page->frameset->bottom->addFrame('main', 'main.htm', 'main');

$page->display();

?>
