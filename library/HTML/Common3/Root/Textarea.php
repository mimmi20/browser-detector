<?php
declare(ENCODING = 'utf-8');
namespace HTML\Common3\Root;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * HTMLCommon\Root\Textarea: Class for HTML <textarea> Elements
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

// {{{ HTMLCommon\Root\Textarea

/**
 * Class for HTML <textarea> Elements
 *
 * @category HTML
 * @package  HTMLCommon\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/HTMLCommon\
 */
class Textarea extends HTMLCommon implements ElementsInterface
{
    // {{{ properties

    /**
     * HTML Tag of the Element
     *
     * @var      string
     */
    protected $_elementName = 'textarea';

    /**
     * Associative array of attributes
     *
     * @var      array
     */
    protected $_attributes = array(
        'cols' => 20,
        'rows' => 5
    );

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
    protected $_watchedAttributes = array('cols', 'rows');

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
            /* Text */
            'zero'
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
            'onblur',
            'onchange',
            'onfocus',
            'onselect',
            'accesskey',
            'cols',
            'disabled',
            'name',
            'readonly',
            'rows',
            'tabindex'
        ),
        'html' => array(
            '#all' => array(
                'lang'
            ),
            '5.0' => array(
                '#all' => array(
                    'autofocus',
                    'form',
                    'inputmode',
                    'replace',
                    'required'
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
                )
            )
        )
    );

    /**
     * Whether element's value should persist when element is frozen
     *
     * @var      boolean
     */
    protected $_persistent = true;

    /**
     * value for the textarea field
     *
     * @var      string
     */
    protected $_value = '';

    /**
     * SVN Version for this class
     *
     * @var     string
     */
    const VERSION = '$Id$';

    // }}} properties
    // {{{ initAttributes

    /**
     * set the default attributes
     *
     * @return HTMLCommon\Root\Textarea
     */
    protected function initAttributes()
    {
        //set the default attributes
        $this->_attributes = array(
            'cols' => 20,
            'rows' => 5
        );

        return $this;
    }

    // }}} initAttributes
    // {{{ onAttributeChange

    /**
     * Called if trying to change an attribute with name in $watchedAttributes
     *
     * This method is called for each attribute whose name is in the
     * $watchedAttributes array and which is being changed by setAttribute(),
     * setAttributes() or mergeAttributes() or removed via removeAttribute().
     * Note that the operation for the attribute is not carried on after calling
     * this method, it is the responsibility of this method to change or remove
     * (or not) the attribute.
     *
     * @param string $name  Attribute name
     * @param string $value Attribute value, null if attribute is being removed
     *
     * @return void
     */
    protected function onAttributeChange($name, $value = null)
    {
        $name = (string) $name;

        if ($name != '') {
            if ($name == 'cols') {
                if ($value === null || (string) $value == '') {
                    //set default size
                    $value = 20;
                }
            }

            if ($name == 'rows') {
                if ($value === null || (string) $value == '') {
                    //set default size
                    $value = 5;
                }
            }

            $this->_attributes[$name] = (string) $value;
        }
    }

    // }}} onAttributeChange
    // {{{ getValue

    /**
     * gets the value to the element
     *
     * NOTE: this function has no relation to the Attribute "value"
     *
     * @return string
     */
    public function getValue()
    {
        if (!$this->_elementEmpty 
            && (!isset($this->_attributes['disabled'])
            || (isset($this->_attributes['disabled'])
            && (boolean) $this->_attributes['disabled'] === false))
        ) {
            return (string) $this->replace($this->value, 'all');
        } else {
            return '';
        }
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
     */
    public function toHtml($step = 0, $dump = false, $comments = false,
                               $levels = true)
    {
        if ($this->frozen) {
            $txt = $this->getFrozenHtml($levels);
        } else {
            $txt = parent::toHtml($step, $dump, $comments, $levels);
        }

        //var_dump($txt);
        return $txt;
    }

    // }}} toHtml
    // {{{ getFrozenHtml

    /**
     * Generates a not editable field
     *
     * @param boolean $levels if TRUE the levels are added,
     *                        if FALSE the levels will be ignored
     *
     * @return string
     */
    public function getFrozenHtml($levels = true)
    {
        $value = htmlspecialchars($this->value, ENT_QUOTES,
                 $this->getOption('charset'));

        if ('off' == $this->getAttribute('wrap')) {
            $html = $this->write('pre', $value, false, false, $levels);
        } else {
            $html = nl2br($value) . $this->getOption('linbebreak');
        }

        return $html . $this->getPersistentContent();
    }

    // }}} getFrozenHtml
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
     */
    public function writeInner($dump = false, $comments = false, $levels = true)
    {
        if ($this->_elementEmpty) {
            return '';
        }

        $step     = (int)     $this->getIndentLevel() + 1;
        $dump     = (boolean) $dump;
        $comments = (boolean) $comments;
        $levels   = (boolean) $levels;

        $txt = '';

        $count = count($this->_elements);

        if ($count) {
            foreach ($this->_elements as $element) {
                if (is_object($element) && $element->isEnabled() === true) {
                    //$element->setMimeEncoding($this->getMimeEncoding());

                    $txt .= $element->toHtml($step, $dump, $comments, $levels);
                }
            }
        } else {
            $txt .= $this->value;
        }

        /*
        if ($this->frozen !== true && $count) {
            $lineend = (strtolower(substr(PHP_OS, 0, 3)) == 'win' ?
                            '&#010;&#013;' :
                            '&#010;');

            $txt = preg_replace("/(\r\n|\n|\r)/", '&#010;',
                   htmlspecialchars($txt, ENT_QUOTES, $this->getOption('charset')));

            $lineEnd    = $this->getOption('linebreak');
            $txt       .= $lineEnd . $this->getIndent();
        }
        */

        return $txt;
    }

    // }}} writeInner
}

// }}} HTMLCommon\Root\Textarea

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */