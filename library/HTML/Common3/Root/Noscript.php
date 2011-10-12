<?php
declare(ENCODING = 'utf-8');
namespace HTML\Common3\Root;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * \HTML\Common3\Root\Noscript: Class for HTML <noscript> Elements
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

// {{{ \HTML\Common3\Root\Noscript

/**
 * Class for HTML <noscript> Elements
 *
 * @category HTML
 * @package  \HTML\Common3\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/\HTML\Common3\
 */
class Noscriptextends \HTML\Common3implements \HTML\Common3\Face
{
    // {{{ properties

    /**
     * HTML Tag of the Element
     *
     * @var      string
     * @access   protected
     */
    protected $_elementName = 'noscript';

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
            'applet',
            'del',
            'dir',
            'font',
            //'iframe',
            'ins',
            //'map',
            //'noscript',
            //'script',
            'select',
            /* BlockContainer */
            'address',
            'blockquote',
            'center',
            'del',
            'div',
            'dl',
            'form',
            'h1',
            'h2',
            'h3',
            'h4',
            'h5',
            'h6',
            'hr',
            'ins',
            'menu',
            'ol',
            'p',
            'pre',
            'table',
            'ul',
            'if'
        ),
        'html' => array(
            '4.01' => array(
                'frameset' => array(
                    /* InlineContainer */
                    'a',
                    'abbr',
                    'acronym',
                    'object',
                    'b',
                    'bdo',
                    'big',
                    'br',
                    'button',
                    'cite',
                    'code',
                    'dfn',
                    'em',
                    'i',
                    'img',
                    'input',
                    'kbd',
                    'label',
                    'q',
                    's',
                    'samp',
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
                    /* BlockContainer */
                    'br'
                ),
                'transitional' => array(
                    /* InlineContainer */
                    'a',
                    'abbr',
                    'acronym',
                    'object',
                    'b',
                    'bdo',
                    'big',
                    'br',
                    'button',
                    'cite',
                    'code',
                    'dfn',
                    'em',
                    'i',
                    'img',
                    'input',
                    'kbd',
                    'label',
                    'q',
                    's',
                    'samp',
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
                    /* BlockContainer */
                    'br'
                )
            ),
            '5.0' => array(
                'transitional' => array(
                    /* InlineContainer */
                    'a',
                    'abbr',
                    'acronym',
                    'object',
                    'b',
                    'bdo',
                    'big',
                    'br',
                    'button',
                    'cite',
                    'code',
                    'dfn',
                    'em',
                    'i',
                    'img',
                    'input',
                    'kbd',
                    'label',
                    'q',
                    's',
                    'samp',
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
                    /* BlockContainer */
                    'br'
                )
            )
        ),
        'xhtml' => array(
            '1.0' => array(
                'frameset' => array(
                    /* InlineContainer */
                    'a',
                    'abbr',
                    'acronym',
                    'object',
                    'b',
                    'bdo',
                    'big',
                    'br',
                    'button',
                    'cite',
                    'code',
                    'dfn',
                    'em',
                    'i',
                    'img',
                    'input',
                    'kbd',
                    'label',
                    'q',
                    's',
                    'samp',
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
                    /* BlockContainer */
                    'br'
                ),
                'transitional' => array(
                    /* InlineContainer */
                    'a',
                    'abbr',
                    'acronym',
                    'object',
                    'b',
                    'bdo',
                    'big',
                    'br',
                    'button',
                    'cite',
                    'code',
                    'dfn',
                    'em',
                    'i',
                    'img',
                    'input',
                    'kbd',
                    'label',
                    'q',
                    's',
                    'samp',
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
                    /* BlockContainer */
                    'br'
                )
            )
        )
    );

    /**
     * Array of Attibutes which are possible for an Element
     *
     * @var        array
     * @access    protected
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
            )
        ),
        'xhtml' => array(
            '#all' => array(
                'xml:lang'
            ),
            '1.0' => array(
                '#all' => array(
                    'lang'
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
    // {{{ toHtml

    /**
     * Returns the HTML representation of the element
     *
     * This magic method allows using the instances of \HTML\Common3\ in string
     * contexts
     *
     * @param int     $step     the level in which should startet the output,
     *                          the internal level is updated
     * @param boolean $dump     if TRUE an dump of the class is created
     * @param boolean $comments if TRUE comments were added to the output
     * @param boolean $levels   if TRUE the levels are added,
     *                          if FALSE the levels will be ignored
     *
     * @access public
     * @return string
     * @see    HTML_Common::toHtml()
     * @see    HTML_Page2::toHtml()
     * @see    write()
     */
    public function toHtml($step = 0, $dump = false, $comments = false,
                           $levels = true)
    {
        $elementName = $this->getElementName();
        $innerHTML   = $this->writeInner($dump, $comments, $levels);
        if ($innerHTML == '') {
            $txt = '';
        } else {
            $txt = $this->write($elementName, $innerHTML, $step, $dump,
                                    $comments, $levels);
        }
        return $txt;
    }

    // }}} toHtml
}

// }}} \HTML\Common3\Root\Noscript

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */