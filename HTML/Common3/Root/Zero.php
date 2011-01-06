<?php
declare(ENCODING = 'iso-8859-1');
namespace HTML\Common3\Root;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * \HTML\Common3\Root\Zero: Class for HTML Data (CDATA or PCDATA)
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

// {{{ \HTML\Common3\Root\Zero

/**
 * Class for HTML Data (CDATA or PCDATA)
 *
 * @category HTML
 * @package  \HTML\Common3\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/\HTML\Common3\
 */
class Zeroextends \HTML\Common3implements \HTML\Common3\Face
{
    // {{{ properties

    /**
     * HTML Tag of the Element
     *
     * @var      string
     * @access   protected
     */
    protected $_elementName = '';

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
     * Array of HTML Elements which are possible as child elements
     *
     * @var      array
     * @access   protected
     */
    protected $_posElements = array();

    /**
     * Array of Attibutes which are possible for an Element
     *
     * @var      array
     * @access   protected
     */
    protected $_posAttributes = array();

    /**
     * Array of HTML Elements which are forbidden as parent elements
     * (and its parents)
     *
     * @var      array
     * @access   protected
     */
    protected $_forbidElements = array(
        '#all' => array(
            'head'
        )
    );    /**
     * value for text elements
     *
     * @var      string
     * @access   protected
     */
    protected $_value = '';

    /**
     * SVN Version for this class
     *
     * @var     string
     * @access  protected
     */
    const VERSION = '$Id$';

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

        $this->value = '';
    }

    // }}} __construct
    // {{{ setValue

    /**
     * sets or adds a value to the element
     *
     * @param string  $value     an text that should be the value for the element
     * @param integer $flag      Determines whether to prepend, append or replace
     *                           the content. Use pre-defined constants.
     * @param boolean $transform marks if the special chars should be transformed to
     *                           their HTML-equivalents
     *
     * @return \HTML\Common3\
     * @access public
     * @throws \HTML\Common3\InvalidArgumentException
     *
     * NOTE: this function has no relation to the Attribute "value"
     */
    public function setValue($value, $flag = HTML_REPLACE, $transform = true)
    {
        $value     = (string)  $value;
        $transform = (boolean) $transform;

        if ($transform === true) {
            $value = $this->replace($value, 'all');
        }

        if ($flag === HTML_APPEND) {
            $this->_value .= $value;//$this->replace($value, 'all');
        } elseif ($flag === HTML_REPLACE) {
            $this->_value = $value;//$this->replace($value, 'all');
        } else {
            //prepend
            $this->_value = $value . $this->_value;
        }
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
        return (string) $this->value;
    }

    // }}} getValue
    // {{{ toHtml

    /**
     * Returns the Element structure as HTML, works recursive
     *
     * @param int     $step     the level in which should startet the output,
     *                          the internal level is updated
     * @param boolean $dump     if TRUE an dump of the class is created
     * @param boolean $comments if TRUE comments were added to the output
     * @param boolean $levels   if TRUE the levels are added,
     *                          if FALSE the levels will be ignored
     *
     * @return string
     * @access public
     * @see    HTML_Common2::toHtml()
     */
    public function toHtml($step = 0, $dump = false, $comments = false,
                               $levels = true)
    {
        $txtInner = $this->writeInner($dump, $comments, $levels);

        if ($dump) {
            $txt = $this->write('zero', $txtInner, $step, $dump,
                                        $comments, $levels);
        } else {
            $txt = $this->write('', $txtInner, $step, $dump,
                                        $comments, $levels);
        }

        return $txt;
    }

    // }}} toHtml
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
        return $this->getValue();
    }

    // }}} writeInner
}

// }}} \HTML\Common3\Root\Zero

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */