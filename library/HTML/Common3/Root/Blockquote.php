<?php
declare(ENCODING = 'utf-8');
namespace HTML\Common3\Root;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * HTMLCommon\Root\Blockquote: Class for HTML <blockquote> Elements
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
 * base class for HTMLCommon\
 */
use HTML\Common3 as HTMLCommon;

/**
 * class Interface for HTMLCommon\
 */
use HTML\Common3\ElementsInterface;

// {{{ HTMLCommon\Root\Blockquote

/**
 * Class for HTML <blockquote> Elements
 *
 * @category HTML
 * @package  HTMLCommon\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/HTMLCommon\
 */
class Blockquote extends HTMLCommon implements ElementsInterface
{
    // {{{ properties

    /**
     * HTML Tag of the Element
     *
     * @var      string
     */
    protected $_elementName = 'blockquote';

    /**
     * Associative array of attributes
     *
     * @var      array
     */
    protected $_attributes = array();

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
     * Indicator to tell, if the Object is an empty HTML Element
     *
     * @var      boolean
     */
    protected $_elementEmpty = false;

    /**
     * Array of HTML Elements which are possible as child elements
     *
     * @var      array
     */
    protected $_posElements = array(
        '#all' => array(
            /* BlockContainer */
            'address',
            'blockquote',
            'center',
            'del',
            'div',
            'dl',
            //'form',
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
                    //'a',
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
                    //'iframe',
                    'img',
                    //'input',
                    'ins',
                    'kbd',
                    //'label',
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
                    //'textarea',
                    'tt',
                    'u',
                    'var',
                    /* Text */
                    'zero',
                    /* BlockContainer */
                    'br'
                ),
                'transitional' => array(
                    /* InlineContainer */
                    //'a',
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
                    //'iframe',
                    'img',
                    //'input',
                    'ins',
                    'kbd',
                    //'label',
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
                    //'textarea',
                    'tt',
                    'u',
                    'var',
                    /* Text */
                    'zero',
                    /* BlockContainer */
                    'br'
                )
            ),
            '5.0' => array(
                'transitional' => array(
                    /* InlineContainer */
                    //'a',
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
                    //'iframe',
                    'img',
                    //'input',
                    'ins',
                    'kbd',
                    //'label',
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
                    //'textarea',
                    'tt',
                    'u',
                    'var',
                    /* Text */
                    'zero',
                    /* BlockContainer */
                    'br'
                )
            )
        ),
        'xhtml' => array(
            '1.0' => array(
                'frameset' => array(
                    /* InlineContainer */
                    //'a',
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
                    //'iframe',
                    'img',
                    //'input',
                    'ins',
                    'kbd',
                    //'label',
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
                    //'textarea',
                    'tt',
                    'u',
                    'var',
                    /* Text */
                    'zero',
                    /* BlockContainer */
                    'br'
                ),
                'transitional' => array(
                    /* InlineContainer */
                    //'a',
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
                    //'iframe',
                    'img',
                    //'input',
                    'ins',
                    'kbd',
                    //'label',
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
                    //'textarea',
                    'tt',
                    'u',
                    'var',
                    /* Text */
                    'zero',
                    /* BlockContainer */
                    'br'
                )
            )
        )
    );

    /**
     * Array of HTML Elements which are forbidden as parent elements
     * (and its parents)
     *
     * @var      array
     */
    protected $_forbidElements = array(
        '#all' => array(
            'fieldset',
            'form'
        )
    );

    /**
     * Array of Attibutes which are possible for an Element
     *
     * @var      array
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
            'onkeyup',
            'cite'
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
     */
    const VERSION = '$Id$';

    // }}} properties
    // {{{ toHtml

    /**
     * Returns the HTML representation of the element
     *
     * This magic method allows using the instances of HTMLCommon\ in string
     * contexts
     *
     * @param int     $step     the level in which should startet the output,
     *                          the internal level is updated
     * @param boolean $dump     if TRUE an dump of the class is created
     * @param boolean $comments if TRUE comments were added to the output
     * @param boolean $levels   if TRUE the levels are added,
     *                          if FALSE the levels will be ignored
     *
     * @return string
     * @see    HTML_Common::toHtml()
     * @see    HTML_Page2::toHtml()
     * @see    write()
     */
    public function toHtml($step = 0, $dump = false, $comments = false,
                           $levels = true)
    {
        $elementName = $this->getElementName();
        $innerHTML   = $this->writeInner($dump, $comments, $levels);        if ($innerHTML == '') {            $txt = '';        } else {
            $txt = $this->write($elementName, $innerHTML, $step, $dump,
                                    $comments, $levels);
        }
        return $txt;
    }

    // }}} toHtml
}

// }}} HTMLCommon\Root\Blockquote

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */