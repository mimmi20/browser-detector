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
// $Id: Frame.php 162026 2004-06-24 17:23:08Z thesaur $

/**
 * The PEAR::HTML_Page2 package provides a simple interface for generating an XHTML compliant page
 * 
 * @category HTML
 * @package  HTML_Page2
 * @version  0.6.2
 * @version  $Id: Frame.php 162026 2004-06-24 17:23:08Z thesaur $
 * @license  http://www.php.net/license/3_0.txt PHP License 3.0
 * @author   Adam Daniel <adaniel1@eesus.jnj.com>
 * @author   Klaus Guenther <klaus@capitalfocus.org>
 * @since   PHP 4.0.3pl1
 */

/**
 * Include HTML_Common class
 */
require_once 'HTML/Common.php';

class HTML_Page2_Frameset_Frame extends HTML_Common
{
    var $xhtml;
    
    function HTML_Page2_Frameset_Frame($options = array())
    {
        if (isset($options['name'])) {
            $this->setAttributes(array('name' => $options['name']));
        }
        if (isset($options['src'])) {
            $this->setSource($options['src']);
        }
        if (isset($options['target'])) {
            $this->setTarget($options['target']);
        }
    } // end func constructor
    
    function setScrolling($string = '')
    {
        if ($string !== '') {
            $this->updateAttributes(array('scrolling' => $string));
        } else {
            $this->removeAttribute('scrolling');
        }
    } // end func setScrolling
    
    function setLongDescription($location = '')
    {
        if ($location !== ''){
            $this->updateAttributes(array('longdesc' => $location));
        } else {
            $this->removeAttribute('longdesc');
        }
    } // end func setSource
    
    function setSource($location)
    {
        $this->updateAttributes(array('src' => $location));
    } // end func setSource
    
    function setTarget($name = '_self')
    {
        $this->updateAttributes(array('target' => $name));
    } // end func setTarget
    
    function toHtml()
    {
        if ($this->xhtml === true) {
            $tagEnd = ' />';
        } else {
            $tagEnd = '>';
        }
        $strHtml = '<frame ' . $this->getAttributes(true) . $tagEnd;
        
        return $strHtml;
    } // end func toHtml
}
?>
