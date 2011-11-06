<?php
declare(ENCODING = 'utf-8');
namespace HTML\Common3\Root;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * HTMLCommon\Root\Mark: Class for HTML <mark> Elements
 *
 * PHP versions 5 and 6
 *
 * LICENSE:
 *
 * Copyright (c) 2007 - 2009, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 *
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 * * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 * * Redistributions in binary form must reproduce the above copyright
 * notice, this list of conditions and the following disclaimer in the
 * documentation and/or other materials provided with the distribution.
 * * The names of the authors may not be used to endorse or promote products
 * derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS
 * IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
 * PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY
 * OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 * NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @category HTML
 * @package  HTMLCommon\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @version  SVN: $Id$
 * @link     http://pear.php.net/package/HTMLCommon\
 */

/**
 * base class for HTMLCommon\ Text Elements
 */
use HTML\Common3\Text as CommonHTMLText;

/**
 * class Interface for HTMLCommon\
 */
use HTML\Common3\ElementsInterface;

// {{{ HTMLCommon\Root\Mark

/**
 * Class for HTML <mark> Elements
 *
 * @category HTML
 * @package  HTMLCommon\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/HTMLCommon\
 */
class Mark extends CommonHTMLText implements ElementsInterface
{
    // {{{ properties

    /**
     * HTML Tag of the Element
     *
     * @var      string
     */
    protected $_elementName = 'mark';

    /**
     * List of attributes to which will be announced via
     * {@link onAttributeChange()} method rather than performed by
     * HTMLCommon\ class itself
     *
     * contains all required attributes
     *
     * @var      array
     * @see      onAttributeChange()
     * @see      getWatchedAttributes()
     * @readonly
     */
    protected $_watchedAttributes = array();

    /**
     * Array of HTML Elements which are possible as child elements
     *
     * @var      array
     */
    protected $_posElements = array(
        '#all' => array(
            /* InlineContainer */
            'a',
            'abbr',
            'acronym',
            'applet',
            'b',
            'bdo',
            'big',
            'br',
            'button',
            'cite',
            'code',
            'del',
            'dfn',
            'dir',
            'em',
            'font',
            'i',
            'iframe',
            'img',
            'input',
            'ins',
            'kbd',
            'label',
            'map',
            'q',
            's',
            'samp',
            'script',
            'select',
            'small',
            'span',
            'strike',
            'strong',
            'sub',
            'sup',
            'textarea',
            'tt',
            'u',
            'var',
            /* Text */
            'zero',
            'if'
        ),
        'html' => array(
            '4.01' => array(
                'frameset' => array(
                    /* InlineContainer */
                    //'noscript',
                    'object'
                ),
                'transitional' => array(
                    /* InlineContainer */
                    //'noscript',
                    'object'
                )
            ),
            '5.0' => array(
                'transitional' => array(
                    /* InlineContainer */
                    //'noscript',
                    'object'
                )
            )
        ),
        'xhtml' => array(
            '1.0' => array(
                'frameset' => array(
                    /* InlineContainer */
                    //'noscript',
                    'object'
                ),
                'transitional' => array(
                    /* InlineContainer */
                    //'noscript',
                    'object'
                )
            )
        )
    );

    /**
     * SVN Version for this class
     *
     * @var     string
     */
    const VERSION = '$Id$';

    // }}} properties
    // {{{ addLink

    /**
     * adds an <a> link to this span
     *
     * @param integer $lang    Language Code
     * @param array   $func    Array including all actions to add
     * @param string  $ref     target address for this link or
     *                         "#" if javascript is used
     * @param string  $key     Char for Accesskey
     * @param string  $name    Name and ID for the Link
     * @param integer $index   Number for Tabindex
     * @param string  $char    target charset
     * @param string  $titel   Title
     * @param string  $typ     target Mime-Typ
     * @param string  $info    text to display with link
     * @param boolean $dis     Boolean-Value, if TRUE the Link will be deactivatet
     * @param string  $ico     path to an Icon
     * @param string  $target  default for target - not used
     * @param string  $weite   default for width
     * @param string  $display CSS display property
     *
     * @return HTMLCommon\Root\A
     */
    public function addLink($lang, $func, $ref = '#', $key = '', $name = '',
                            $index = 0, $char = 'UTF-8', $titel = '',
                            $typ = 'text/html', $info = '', $dis = false, $ico = '',
                            $target = '_blank', $weite = 0, $display = 'block')
    {
        $a = $this->addElement('a');
        $a->setLink($lang, $func, $ref, $key, $name, $index, $char, $titel, $typ,
                    $info, $dis, $ico, $target, $weite, $display);

        return $a;
    }

    // }}} addLink
    // {{{ addTable

    /**
     * adds an <table> to this span
     *
     * @param string $lang    the language for the table
     * @param string $class   the CSS class for the table
     * @param string $summary the summary for the table
     * @param string $style   the CSS style for the table
     *
     * @return HTMLCommon\Root\Table
     */
    public function addTable($lang='de', $class='', $summary='', $style='')
    {
        $table = $this->addElement('table');
        $table->setTable($lang, $class, $summary, $style);

        return $table;
    }

    // }}} addTable
    // {{{ addInput

    /**
     * adds an <input> to this span
     *
     * @param string $type  the type for the input
     * @param string $id    the id for the input
     * @param string $class the CSS class for the input
     * @param string $lang  the language for the input
     * @param string $title the title for the input
     * @param string $value the value for the input
     * @param string $style the CSS style for the input
     *
     * @return HTMLCommon\Root\Input
     */
    public function addInput($type = 'text', $id = '', $class = '', $lang = '',
                             $title = '', $value = '', $style = '')
    {
        $input = $this->addElement('input');
        $input->setInput($type, $id, $class, $lang, $title, $value, $style);

        return $input;
    }

    // }}} addInput
}

// }}} HTMLCommon\Root\Mark

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */