<?php
declare(ENCODING = 'iso-8859-1');
namespace HTML\Common3\Root;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * \HTML\Common3\Root\Body: Class for HTML <body> Elements
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
 * @version  SVN: $Id: Body.php 11 2010-10-10 19:17:21Z tmu $
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

// {{{ \HTML\Common3\Root\Body

/**
 * Class for HTML <body> Elements
 *
 * @category HTML
 * @package  \HTML\Common3\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/\HTML\Common3\
 */
class Bodyextends \HTML\Common3implements \HTML\Common3\Face
{
    // {{{ properties

    /**
     * HTML Tag of the Element
     *
     * @var      string
     * @access   protected
     */
    protected $_elementName = 'body';

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
                    /* BlockContainer */
                    'br'
                ),
                'transitional' => array(
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
                    /* BlockContainer */
                    'br'
                ),
                'transitional' => array(
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
                    /* BlockContainer */
                    'br'
                )
            )
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
            'onblur',
            'onclick',
            'ondblclick',
            'onmouseover',
            'onmouseout',
            'onmousedown',
            'onmouseup',
            'onmousemove',
            'onkeypress',
            'onkeydown',
            'onkeyup',
            'title',
            'style',
            'id',
            'class',
            'dir',
            'onload',
            'onunload'
        ),
        'html' => array(
            '#all' => array(
                'lang'
            ),
            '4.01' => array(
                'frameset' => array(
                    'alink',
                    'background',
                    'bgcolor',
                    'link',
                    'text',
                    'vlink'
                ),
                'transitional' => array(
                    'alink',
                    'background',
                    'bgcolor',
                    'link',
                    'text',
                    'vlink'
                )
            ),
            '5.0' => array(
                'transitional' => array(
                    'alink',
                    'background',
                    'bgcolor',
                    'link',
                    'text',
                    'vlink'
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
                    'alink',
                    'background',
                    'bgcolor',
                    'link',
                    'text',
                    'vlink'
                ),
                'transitional' => array(
                    'alink',
                    'background',
                    'bgcolor',
                    'link',
                    'text',
                    'vlink'
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
    const VERSION = '$Id: Body.php 11 2010-10-10 19:17:21Z tmu $';

    // }}} properties
    // {{{ setValue

    /**
     * sets or adds a value to the element
     *
     * @param string  $value an text that should be the value for the element
     * @param integer $flag  Determines whether to prepend, append or replace
     *                       the content. Use pre-defined constants.
     *
     * @return \HTML\Common3\
     * @access public
     * @throws \HTML\Common3\InvalidArgumentException
     *
     * NOTE: this function has no relation to the Attribute "value"
     */
    public function setValue($value, $flag = HTML_REPLACE)
    {
        if (!$this->_elementEmpty) {
            $posElements = $this->getPosElements();
            $key         = 'zero';

            $value = (string)  $value;

            if ($flag === HTML_APPEND) {
                $this->value .= $value;//$this->replace($value, 'all');
            } elseif ($flag === HTML_REPLACE) {
                $this->value = $value;//$this->replace($value, 'all');
            } else {
                //prepend
                $this->value = $value . $this->value;
            }

            //var_dump(count($this->_elements));
            $leave = $this->parseValue($value, $flag);
            //var_dump($leave);
            //var_dump(count($this->_elements));

            if (in_array($key, $posElements) &&
                array_key_exists($key, \HTML\Common3\Globals::$allElements) &&
                !$this->_elementEmpty
               ) {
                if ($leave === false) {
                    //var_dump(2);
                    $zero = $this->addElement('zero', null, $flag);
                    if ($zero !== null) {
                        $zero->addValue($value);
                    }
                }
            }
        }

        return $this;
    }

    // }}} setValue
    // {{{ addDiv

    /**
     * adds an Div-Container to this Body
     *
     * @param string $style the CSS style for the Div
     * @param string $class the CSS class for the Div
     * @param string $lang  the language for the Div
     * @param string $id    the id for the Div
     *
     * @access public
     * @return \HTML\Common3\Root\Div
     */
    public function addDiv($style = '', $class = '', $lang = '', $id = '')
    {
        $div = $this->addElement('div');
        $div->setDiv($style, $class, $lang, $id);

        return $div;
    }

    // }}} addDiv
    // {{{ addBodyContent

    /**
     * Sets the content of the <body> tag
     *
     * <p>It is possible to add objects, strings or an array of strings
     * and/or objects. Objects must have a toHtml or toString method.</p>
     *
     * <p>By default, if content already exists, the new content is appended.
     * If you wish to overwrite whatever is in the body, use {@link setBody};
     * {@link unsetBody} completely empties the body without inserting new
     * content. You can also use {@link prependBodyContent} to prepend content
     * to whatever is currently in the array of body elements.</p>
     *
     * <p>The following constants are defined to be passed as the flag
     * attribute: \HTML\Common3\Root\APPEND, HTML_PREPEND and HTML_REPLACE.
     * Their usage should be quite clear from their names.</p>
     *
     * @param string  $content New <body> tag content
     * @param integer $flag    Determines whether to prepend, append or replace
     *                         the content. Use pre-defined constants.
     *
     * @access public
     * @return void
     */
    public function addBodyContent($content, $flag = HTML_APPEND)
    {
        if (is_array($content)) {
            $content = (string) $content[0];
        } elseif (is_string($content)) {
            $content = (string) $content;
        } elseif (is_subclass_of($content, "html_common")) {
            $content = (string) $content->toHtml();
            //$this->addElement($content);
            //return;
        } elseif (is_subclass_of($content, '\HTML\Common3')) {
            $this->addElement($content, null, $flag);
            return;
        } else {
            $content = null;
        }

        if ($content !== null) {
            $this->setValue($content, $flag);
        }
    }

    // }}} addBodyContent
    // {{{ prependBodyContent

    /**
     * Prepends content to the content of the <body> tag. Wrapper for
     * {@link addBodyContent}
     *
     * <p>If you wish to overwrite whatever is in the body, use {@link setBody};
     * {@link addBodyContent} provides full functionality including appending;
     * {@link unsetBody} completely empties the body without inserting new content.
     * It is possible to add objects, strings or an array of strings and/or objects
     * Objects must have a toString method.</p>
     *
     * @param mixed $content New <body> tag content (may be passed as a reference)
     *
     * @access public
     * @return void
     */
    function prependBodyContent($content)
    {
        $this->addBodyContent($content, HTML_PREPEND);
    }

    // }}} prependBodyContent
    // {{{ setBody

    /**
     * Sets the content of the <body> tag.
     *
     * <p>If content exists, it is overwritten. If you wish to use a "safe"
     * version, use {@link addBodyContent}. Objects must have a toString
     * method.</p>
     *
     * <p>This function acts as a wrapper for {@link addBodyContent}. If you
     * are using PHP 4.x and would like to pass an object by reference, this
     * is not the function to use. Use {@link addBodyContent} with the flag
     * HTML_PAGE2_REPLACE instead.</p>
     *
     * @param mixed $content New <body> tag content. May be an object.
     *                       (may be passed as a reference)
     *
     * @access public
     * @return void
     */
    function setBody($content)
    {
        $this->addBodyContent($content, HTML_REPLACE);
    }

    // }}} setBody
    // {{{ unsetBody

    /**
     * Unsets the content of the <body> tag.
     *
     * @access public
     * @return void
     */
    function unsetBody()
    {
        $this->_elements = array();
        $this->value    = '';
    }

    // }}} unsetBody
    // {{{ writeInner

    /**
     * Returns the inner Element structure as HTML, works recursive
     *
     * @param boolean $dump     if TRUE an dump of the class is created
     * @param boolean $comments if TRUE comments were added to the output
     * @param boolean $levels   if TRUE the levels are added,
     *                          if FALSE the levels will be ignored
     *
     * @return string
     * @access public
     */
    public function writeInner($dump = false, $comments = false, $levels = true)
    {
        if ($this->_elementEmpty) {
            return '';
        }

        $step      = (int)     $this->getIndentLevel() + 1;
        $dump      = (boolean) $dump;
        $comments  = (boolean) $comments;
        $levels    = (boolean) $levels;
        $lineEnd   = $this->getOption('linebreak');
        $begin_txt = $this->getIndent();
        $txt       = '';

        if (count($this->_elements) == 0) {
            $txt .= $lineEnd;
            $txt .= $begin_txt. '<!-- no Content to show -->' . $lineEnd;
            $txt .= $begin_txt;
        } else {
            foreach ($this->_elements as $element) {
                if (is_object($element)) {
                    $txt .= $element->toHtml($step, $dump, $comments, $levels);
                }
            }
        }

        return $txt;
    }

    // }}} writeInner
}

// }}} \HTML\Common3\Root\Body

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */