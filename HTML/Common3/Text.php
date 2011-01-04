<?php
declare(ENCODING = 'iso-8859-1');
namespace HTML\Common3;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * \HTML\Common3\Text: Base Class for the most of the HTML inline Elements
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
 * @version  SVN: $Id: Text.php 11 2010-10-10 19:17:21Z tmu $
 * @link     http://pear.php.net/package/\HTML\Common3\
 */

/**
 * base class for \HTML\Common3\
 */
require_once 'HTML/Common3.php';

/**
 * \HTML\Common3\Root\Zero represents the text Content
 */
require_once 'HTML/Common3/Root/Zero.php';

/**
 * class Interface for \HTML\Common3\
 */
require_once 'HTML/Common3/Face.php';

// {{{ \HTML\Common3\Text

/**
 * abstract Base Class for the most of the HTML inline Elements
 *
 * @category HTML
 * @package  \HTML\Common3\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/\HTML\Common3\
 * @abstract
 */
abstract class Text
extends \HTML\Common3
implements \HTML\Common3\Face
{
    // {{{ properties

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
            'mark',
            'meter',
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
            'time',
            'tt',
            'u',
            'var',
            /* Text */
            'zero'
        ),
        'html' => array(
            '4.01' => array(
                'transitional' => array(
                    /* InlineContainer */
                    //'noscript',
                    'object'
                )
            ),
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
     * value for text elements
     *
     * @var      string
     * @access   protected
     */
    protected $_value = null;

    /**
     * SVN Version for this class
     *
     * @var     string
     * @access  protected
     */
    const VERSION = '$Id: Text.php 11 2010-10-10 19:17:21Z tmu $';

    // }}} properties
    // {{{ __construct

    /**
     * Class constructor, sets default attributes
     *
     * @param string|array $attributes Array of attribute 'name' => 'value' pairs
     *                                 or HTML attribute string
     * @param \HTML\Common3\ $parent     pointer to the parent object
     * @param \HTML\Common3\ $html       pointer to the HTML root object
     *
     * @return \HTML\Common3\
     * @access public
     * @see    HTML_Common::HTML_Common()
     * @see    HTML_Common2::__construct()
     * @see    HTML_Page2::HTML_Page2()
     */
    public function __construct($attributes = null,
    \HTML\Common3 $parent = null, \HTML\Common3 $html = null)
    {
        parent::__construct($attributes, $parent, $html);

        if ($this->getElementName() != '') {
            $this->value = new \HTML\Common3\Root\Zero(); //all Elements expect zero
        } else {
            $this->value = ''; //the zero element
        }
    }

    // }}} __construct
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
            if (is_object($this->value)) {
                $this->value->setValue((string) $value, $flag, true);
            } else {
                $this->value = (string) $value;
            }
        }

        return $this;
    }

    // }}} setValue
    // {{{ getValue

    /**
     * gets the value to the element
     *
     * NOTE: this function has no relation to the Attribute "value"
     *
     * @return string
     * @access public
     */
    public function getValue()
    {
        if (!$this->_elementEmpty) {
            if (is_object($this->value)) {
                return (string) $this->value->getValue();
            } else {
                return (string) $this->value;
            }
        } else {
            return '';
        }
    }

    // }}} getValue
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

        $step       = (int)     $this->getOption('level') + 1;
        $dump       = (boolean) $dump;
        $comments   = (boolean) $comments;
        $levels     = (boolean) $levels;
        $txt        = '';
        $childcount = count($this->_elements);

        if ($childcount) {
            foreach ($this->_elements as $element) {
                if (is_subclass_of($element, '\HTML\Common3')) {
                    if (is_object($element) && $element->isEnabled()) {
                        $txt .= $element->toHtml(
                            $step, $dump, $comments, $levels
                        );
                    }
                } elseif (is_subclass_of($element, '\HTML_Common')) {
                    $txt .= $element->toHtml();
                } elseif (is_subclass_of($element, '\HTML_Common2')) {
                    try {
                        $txt .= $element->toHtml();
                    } catch (HTML_QuickForm2_Exception $e) {
                        //no output
                    }
                } else {
                    /*
                    throw new \HTML\Common3\ChildElementNotSupportedException(
                        'Type of Child Element \'' . get_class($element) .
                        '\' is not supported'
                    );
                    */
                    //do nothing
                }
            }
        } else {
            //echo "getvalue";
            $txt .= $this->getValue();
        }/**/

        return $txt;
    }

    // }}} writeInner
}

// }}} \HTML\Common3\Text

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */