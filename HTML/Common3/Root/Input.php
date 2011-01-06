<?php
declare(ENCODING = 'iso-8859-1');
namespace HTML\Common3\Root;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * \HTML\Common3\Root\Input: Class for HTML <input> Elements
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

require_once 'HTML/Common3/Form/Element.php';

/**
 * class Interface for \HTML\Common3\
 */
require_once 'HTML/Common3/Face.php';

// {{{ \HTML\Common3\Root\Input

/**
 * Class for HTML <input> Elements
 *
 * @category HTML
 * @package  \HTML\Common3\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/\HTML\Common3\
 */
class Inputextends \HTML\Common3\Form\Elementimplements \HTML\Common3\Face
{
    // {{{ properties

    /**
     * HTML Tag of the Element
     *
     * @var      string
     * @access   protected
     */
    protected $_elementName = 'input';

    /**
     * Associative array of attributes
     *
     * @var      array
     * @access   protected
     */
    protected $_attributes = array(
        'type' => 'text'
    );

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
    protected $_watchedAttributes = array('name', 'id', 'type', 'ismap');

    /**
     * Indicator to tell, if the Object is an empty HTML Element
     *
     * @var      boolean
     * @access   protected
     */
    protected $_elementEmpty = true;

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
            'accept',
            'accesskey',
            'alt', //for type="image"
            'checked',
            'disabled',
            'ismap', //for type="image"
            'maxlength',
            'name',
            'readonly',
            'size',
            'src', //for type="image"
            'tabindex',
            'type',
            'usemap',
            'value'
        ),
        'html' => array(
            '#all' => array(
                'lang'
            ),
            '4.01' => array(
                'frameset' => array(
                    'align'
                ),
                'transitional' => array(
                    'align'
                )
            ),
            '5.0' => array(
                '#all' => array(
                    'autocomplete',
                    'autofocus', //only if type is not hidden
                    'form',
                    'inputmode',
                    'list',
                    'max',
                    'min',
                    'pattern',
                    'replace',
                    'required',
                    'step'
                ),
                'transitional' => array(
                    'align'
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
                    'align'
                ),
                'transitional' => array(
                    'align'
                )
            )
        )
    );

    /**
     * pointer to an Label element for this Input
     *
     * @var      Pointer
     * @access   protected
     */
    protected $_label = null;

    /**
     * SVN Version for this class
     *
     * @var     string
     * @access  protected
     */
    const VERSION = '$Id$';

    // }}} properties
    // {{{ initAttributes

    /**
     * set the default attributes
     *
     * @access public
     * @return \HTML\Common3\Root\Input
     */
    protected function initAttributes()
    {
        //set the default attributes
        $this->_attributes = array(
            'type' => 'text'
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
     * @access protected
     * @return void
     */
    protected function onAttributeChange($name, $value = null)
    {
        $name = (string) $name;

        if ($name != '') {
            if ($name == 'name') {
                if ($value === null) {
                    //set default size
                    $id = (string) $this->getId();

                    if ($id == '') {
                        throw new \HTML\Common3\CanNotRemoveAttributeException(
                            "Required attribute 'name' can not be removed"
                        );
                    } else {
                        $this->_attributes[$name] = (string) $id;
                    }

                    return;
                }
            }

            if ($name == 'id') {
                if ($value === null) {
                    //generate new ID
                    $root = $this->getRoot();
                    $id   = $root->generateId($this->getName());

                    if ($id == '') {
                        throw new \HTML\Common3\CanNotRemoveAttributeException(
                            "Required attribute 'id' can not be removed"
                        );
                    } else {
                        $this->_attributes[$name] = (string) $id;
                    }

                    return;
                }
            }

            if ($name == 'type') {
                /*
                throw new \HTML\Common3\CanNotChangeAttributeException(
                    "Attribute 'type' is read-only"
                );

                return;
                */

                if ($value === null || (string) $value == '') {
                    //set to default value
                    $value = 'text';
                }
            }

            if ($name == 'ismap') {
                if ($this->getAttribute('type') != 'image') {
                    //ismap attribute is allowed only if type="image"
                    unset($this->_attributes[$name]);
                    return;
                }
            }

            $this->_attributes[$name] = (string) $value;
        }
    }

    // }}} onAttributeChange
    // {{{ setInput

    /**
     * format this input
     *
     * @param string $type  the type for the input
     * @param string $id    the id for the input
     * @param string $class the CSS class for the input
     * @param string $lang  the language for the input
     * @param string $title the title for the input
     * @param string $value the value for the input
     * @param string $style the CSS style for the input
     *
     * @access public
     * @return void
     */
    public function setInput($type = 'text', $id = '', $class = '', $lang = '',
                             $title = '', $value = '', $style = '')
    {
        $this->setAttribute('type', $type);

        if ($id != '') {
            $this->setId($id);
        }

        if ($class != '') {
            $this->setAttribute('class', $class);
        }

        if ($lang != '') {
            $this->setAttribute('lang', $lang);
        }

        if ($title != '') {
            $this->setAttribute('title', $title);
        }

        if ($value != '') {
            $this->setAttribute('value', $value);
        }

        if ($style != '') {
            $this->setAttribute('style', $style);
        }
    }

    // }}} setInput
    // {{{ getType

    /**
     * returns the element type
     *
     * @return string the element type (mostly the same as the element name)
     * @access public
     */
    public function getType()
    {
        return $this->getAttribute('type');
    }

    // }}} getType
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
        if (!$this->getAttribute('disabled')) {
            $value = (string) $value;

            if ($flag === HTML_APPEND) {
                $value = $this->getValue() . $value;//$this->replace($value, 'all');
            } elseif ($flag === HTML_PREPEND) {
                $value = $value . $this->getValue();
            }

            $this->setAttribute('value', $value, $flag);
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
        if (!$this->getAttribute('disabled')) {
            return $this->getAttribute('value');
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
     * @access public
     */
    public function toHtml($step = 0, $dump = false, $comments = false,
                               $levels = true)
    {
        if ($this->frozen) {
            return $this->getFrozenHtml();
        } else {
            return parent::toHtml($step, $dump, $comments, $levels);
        }
    }

    // }}} toHtml
    // {{{ getFrozenHtml

    /**
     * Returns the field's value without HTML tags
     *
     * @return string
     */
    protected function getFrozenHtml()
    {
        $value = $this->getAttribute('value');
        return (('' != $value)? htmlspecialchars(
            $value, ENT_QUOTES,
            $this->getOption('charset')
        ): '&nbsp;') . $this->getPersistentContent();
    }

    // }}} getFrozenHtml
}

// }}} \HTML\Common3\Root\Input

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */