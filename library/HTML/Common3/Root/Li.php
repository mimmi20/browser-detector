<?php
declare(ENCODING = 'utf-8');
namespace HTML\Common3\Root;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * \HTML\Common3\Root\Li: Class for HTML <li> Elements
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
 * @package  \HTML\Common3\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @version  SVN: $Id$
 * @link     http://pear.php.net/package/\HTML\Common3\
 */

/**
 * base class for \HTML\Common3\
 */
require_once 'HTML/Common3.php';

/**
 * class Interface for \HTML\Common3\
 */
require_once 'HTML/Common3/Face.php';

// {{{ \HTML\Common3\Root\Li

/**
 * Class for HTML <li> Elements
 *
 * @category HTML
 * @package  \HTML\Common3\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/\HTML\Common3\
 */
class Liextends \HTML\Common3implements \HTML\Common3\Face
{
    // {{{ properties

    /**
     * HTML Tag of the Element
     *
     * @var      string
     * @access   protected
     */
    protected $_elementName = 'li';

    /**
     * Associative array of attributes
     *
     * @var      array
     * @access   protected
     */
    protected $_attributes = array();

    /**
     * List of attributes to which will be announced via
     * {@link onAttributeChange()} method rather than performed by
     * \HTML\Common3\ class itself
     *
     * contains all required attributes
     *
     * @var      array
     * @see      onAttributeChange()
     * @see      getWatchedAttributes()
     * @access   protected
     * @readonly
     */
    protected $_watchedAttributes = array();

    /**
     * Indicator to tell, if the Object is an empty HTML Element
     *
     * @var      boolean
     * @access   protected
     */
    protected $_elementEmpty = false;

    /**
     * Array of HTML Elements which are possible as child elements
     *
     * @var      array
     * @access   protected
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
            'noscript',
            'object',
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
        )
    );

    /**
     * Array of Attibutes which are possible for an Element
     *
     * @var      array
     * @access   protected
     */
    protected $_posAttributes = array(
        '#all' => array(
            'class',
            'dir',
            'id',
            'style',
            'title',
            'onclick',
            'ondblclick',
            'onmousedown',
            'onmouseup',
            'onmouseover',
            'onmousemove',
            'onmouseout',
            'onkeypress',
            'onkeydown',
            'onkeyup'
        ),
        'html' => array(
            '#all' => array(
                'lang'
            ),
            '4.01' => array(
                'frameset' => array(
                    'type',
                    'value'
                ),
                'transitional' => array(
                    'type',
                    'value'
                )
            ),
            '5.0' => array(
                '#all' => array(
                    'value'
                )
            )
        ),
        'xhtml' => array(
            '#all' => array(
                'xml:lang'
            ),
            '1.0' => array(
                '#all' => array(
                    'lang'
                ),
                'frameset' => array(
                    'type',
                    'value'
                ),
                'transitional' => array(
                    'type',
                    'value'
                )
            )
        )
    );

    /**
     * SVN Version for this class
     *
     * @var     string
     * @access  protected
     */
    const VERSION = '$Id$';

    // }}} properties
    // {{{ addLink

    /**
     * adds an link to this list entry
     *
     * @param integer $lang    Language Code
     * @param array   $func    Array including all actions to add
     * @param string  $ref     target address for this link
     *                         or "#" if javascript is used
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
     * @access public
     * @return \HTML\Common3\Root\A
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
}

// }}} \HTML\Common3\Root\Li

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */