<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997 - 2003 The PHP Group                              |
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
// $Id$

require_once 'HTML/Page.php';
require_once 'HTML/Table.php';

// This is an example from HTML_Table
$table = new HTML_Table('width=100%');
$table->setCaption('256 colors table');
$i = $j = 0;
for ($R = 0; $R <= 255; $R += 51) {
    for ($G = 0; $G <= 255; $G += 51) {
        for($B = 0; $B <= 255; $B += 51) {
            $table->setCellAttributes($i, $j, 'style="background-color:'.sprintf('%02X%02X%02X', $R, $G, $B).';"');
            $j++;
        }
    }
    $i++;
    $j = 0;
}
// end of HTML_Table example

// The initializing code can also be in in the form of an HTML
// attr="value" string.
// Possible attributes are:
//      - cache ("true" or "false")
//      - charset (e.g., "utf-8")
//      - doctype (e.g., "XHTML Basic 1.0")
//      - language (two letter designator: e.g., "en")
//      - lineend ("unix", "win", "mac", custom string)
//      - mime (e.g., "application/xhtml+xml")
//      - namespace (string)
//      - tab (e.g., "    ")
// All the above have defaults, so it is not necessary
// to specify everything. For example, the proper namespace
// is chosen by default.

$p = new HTML_Page(array ( 
                           'lineend'   => 'unix',
                           'doctype'   => 'XHTML 1.0 Strict',
                           'language'  => 'en',
                           'cache'     => 'false'
                         ));
 
// Page title defaults to "New XHTML 1.0 Strict Page"
$p->setTitle("HTML_Page Color Chart example");
$p->setMetaData("author", "Klaus Guenther");

// let's add a Content-Type meta tag
$p->setMetaContentType();

$p->addBodyContent("<h1>Color Chart</h1>");

// Objects with toHtml and toString are supported.
$p->addBodyContent($table);
$p->addBodyContent('<p>Copyright 2003 The PHP Group</p>');

// output to browser
$p->display();
// or to a file
//$p->toFile('example.html');
?>
