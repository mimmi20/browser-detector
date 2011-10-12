<?php
declare(ENCODING = 'utf-8');
namespace HTML\Common3\Root;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * \HTML\Common3\Root\Optgroup: Class for HTML <optgroup> Elements
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

// {{{ \HTML\Common3\Root\Optgroup

/**
 * Class for HTML <optgroup> Elements
 *
 * @category HTML
 * @package  \HTML\Common3\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/\HTML\Common3\
 */
class Optgroupextends \HTML\Common3\Form\Elementimplements \HTML\Common3\Face
{
    // {{{ properties

    /**
     * HTML Tag of the Element
     *
     * @var      string
     * @access   protected
     */
    protected $_elementName = 'optgroup';

    /**
     * Associative array of attributes
     *
     * @var      array
     * @access   protected
     */
    protected $_attributes = array(
        'label' => ''
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
    protected $_watchedAttributes = array('label');

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
            'option',
            //'optgroup' //not supported now
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
            'onkeyup',
            'disabled',
            'label'
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
     * List of option-Elements in this optgoup
     *
     * @var        array
     * @access    protected
     */
    protected $_list = array();

    /**
     * List of all values of all option-Elements in this list
     *
     * @var        array
     * @access    protected
     */
    protected $_values = array();

    /**
     * List of all possible values of all option-Elements in this list
     *
     * @var        array
     * @access    protected
     */
    protected $_possibleValues = array();

    /**
     * Whether element's value should persist when element is frozen
     *
     * @var        boolean
     * @access    protected
     */
    protected $_persistent = true;

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
     * @return \HTML\Common3\Root\Optgroup
     */
    protected function initAttributes()
    {
        //set the default attributes
        $this->_attributes = array(
            'label' => ''
        );

        return $this;
    }

    // }}} initAttributes
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
        if (count($this->_elements) == 0) {
            return '';
        }

        $txt = $this->writeInner($dump, $comments, $levels);

        if ($txt == '') {
            return '';
        } else {
            $txt = $this->toStringInner($txt, $step, $dump, $comments, $levels);            //var_dump($txt);            return $txt;
        }
    }

    // }}} toHtml
    // {{{ addOption

    /**
     * adds an Option to this Select
     *
     * @param string $text       Option text
     * @param string $value      'value' attribute for <option> tag
     * @param mixed  $attributes Array of attribute 'name' => 'value' pairs or
     *                           HTML attribute string
     *
     * @access public
     * @return \HTML\Common3\Root\Option
     */
    public function addOption($text, $value, $attributes = null)
    {
        $attributes = $this->parseAttributes($attributes);
        $value      = (string) $value;

        if (isset($attributes['selected'])) {
            unset($attributes['selected']);

            $this->values[$value]         = $value;
            $this->_parent->values[$value] = $value;
        }

        $attributes['value'] = $value;

        if (!isset($attributes['disabled'])) {
            $this->possibleValues[$value]         = $value;
            $this->_parent->possibleValues[$value] = $value;
        }

        $option = $this->addElement('option', $attributes);
        //$option->setAttribute('value', $value);
        $option->setAttribute('label', $text);
        $option->setValue($text);

        $this->list[] =& $option;

        return $option;
    }

    // }}} addOption
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
        $root = $this->getRoot();

        if ($name != '') {
            if ($name == 'label') {
                if ($value === null) {
                    //Attribute must be set
                    throw new \HTML\Common3\CanNotRemoveAttributeException(
                        "Required attribute 'label' can not be removed"
                    );
                }
            }

            $this->_attributes[$name] = (string) $value;
        }
    }

    // }}} onAttributeChange
}

// }}} \HTML\Common3\Root\Optgroup

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */