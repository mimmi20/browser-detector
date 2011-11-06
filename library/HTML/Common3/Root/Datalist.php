<?php
declare(ENCODING = 'utf-8');
namespace HTML\Common3\Root;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * HTMLCommon\Root\Datalist: Class for HTML <datalist> Elements
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

use HTML\Common3\Form\Element as CommonHTMLFormElement;

/**
 * class Interface for HTMLCommon\
 */
use HTML\Common3\ElementsInterface;

// {{{ HTMLCommon\Root\Datalist

/**
 * Class for HTML <datalist> Elements
 *
 * @category HTML
 * @package  HTMLCommon\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/HTMLCommon\
 */
class Datalist extends CommonHTMLFormElement implements ElementsInterface
{
    // {{{ properties

    /**
     * HTML Tag of the Element
     *
     * @var      string
     */
    protected $_elementName = 'datalist';

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
            'option'
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
            'disabled',
            'multiple',
            'name',
            'size',
            'tabindex'
        ),
        'html' => array(
            '#all' => array(
                'lang'
            ),
            '5.0' => array(
                '#all' => array(
                    'data'
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
     * List of option-Elements in this list
     *
     * @var      array
     */
    protected $_list = array();

    /**
     * List of all values of all option-Elements in this list
     *
     * @var      array
     */
    public $values = array();

    /**
     * List of all possible values of all option-Elements in this list
     *
     * @var      array
     */
    public $possibleValues = array();

    /**
     * Whether element's value should persist when element is frozen
     *
     * @var      boolean
     */
    protected $_persistent = true;

    /**
     * SVN Version for this class
     *
     * @var     string
     */
    const VERSION = '$Id$';

    // }}} properties
    // {{{ addOption

    /**
     * adds an Option to this Select
     *
     * @param string $text       Option text
     * @param string $value      'value' attribute for <option> tag
     * @param mixed  $attributes Array of attribute 'name' => 'value' pairs or
     *                          HTML attribute string
     *
     * @return HTMLCommon\Root\Option
     */
    public function addOption($text, $value, $attributes = null)
    {
        $attributes = $this->parseAttributes($attributes);
        $value      = (string) $value;

        if (isset($attributes['selected'])) {
            unset($attributes['selected']);

            $this->values[$value] = $value;
        }

        $attributes['value'] = $value;

        if (!isset($attributes['disabled'])) {
            $this->possibleValues[$value] = $value;
        }

        $option = $this->addElement('option', $attributes);
        //$option->setAttribute('value', $value);
        $option->setAttribute('label', $text);
        $option->setValue($text);

        $this->list[] =& $option;

        return $option;
    }

    // }}} addOption
    // {{{ addOptgroup

    /**
     * adds an addOptgroup to this Select
     *
     * @param string $label      label for the optgroup
     * @param mixed  $attributes Array of attribute 'name' => 'value' pairs or
     *                           HTML attribute string
     *
     * @return HTMLCommon\Root\Optgroup
     */
    public function addOptgroup($label, $attributes = null)
    {
        $optgroup = $this->addElement('optgroup', $attributes);
        $optgroup->setAttribute('label', $label);

        $this->list[] =& $optgroup;

        return $optgroup;
    }

    // }}} addOptgroup
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
        if (count($this->_elements) == 0) {
            return '';
        }

        $txt = $this->writeInner($dump, $comments, $levels);

        if ($txt == '') {
            return '';
        } else {
            if (isset($this->_attributes['multiple'])) {
                $name = $this->getName();

                if (substr($name, -2) != '[]') {
                    $this->setName($name . '[]');
                }
            }

            if ($this->frozen) {
                $txt = str_replace('<option', '<li', $txt);
                $txt = str_replace('</option', '</li', $txt);
                $txt = str_replace('<optgroup', '<ul', $txt);
                $txt = str_replace('</optgroup', '</ul', $txt);

                $txt = $this->write('ul', $txt, $step, $dump, $comments, $levels);
            } else {
                $txt = $this->toStringInner($txt, $step, $dump, $comments,
                                            $levels);
            }

            return $txt;
        }
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

        //$begin_txt    = $this->getIndent();

        $strValues = array_map('strval', $this->values);

        if (count($this->_elements)) {
            foreach ($this->_elements as $element) {
                if (is_object($element) && $element->isEnabled() === true) {
                    if (in_array($element->getAttribute('value'), $strValues, true)) {
                        $element->setAttribute('selected', 'selected');
                    }

                    $txt .= $element->toHtml($step, $dump, $comments, $levels);
                }
            }
        } else {
            $txt .= $this->value;
        }

        return $txt;
    }

    // }}} writeInner
    // {{{ getOptions

    /**
     * Returns an array of contained options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->list;
    }

    // }}} getOptions
    // {{{ count

    /**
     * Returns the number of elements in the container
     *
     * @return integer
     */
    public function count()
    {
        return count($this->list);
    }

    // }}} count
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
        if (0 == count($this->values) ||
            0 == count($this->possibleValues) ||
            $this->_attributes['disabled'] !== null) {
            return null;
        }

        $values = array();
        foreach ($this->values as $value) {
            if (isset($this->possibleValues[$value])) {
                $values[] = $value;
            }
        }
        if (0 == count($values)) {
            return null;
        } elseif ($this->_attributes['multiple'] !== null) {
            return $values;
        } elseif (1 == count($values)) {
            return $values[0];
        } else {
            // The <select> is not multiple, but several options are to be
            // selected. At least IE and Mozilla select the last selected
            // option in this case, we should do the same

            return $values[count($values) - 1];
        }
    }

    // }}} getValue
    // {{{ setValue

    /**
     * sets or adds a value to the element
     * it's not possible to set the values for an <select> directly
     *
     * @param string  $value an text that should be the value for the element
     * @param integer $flag  Determines whether to prepend, append or replace
     *                       the content. Use pre-defined constants.
     *
     * @return HTMLCommon\
     * @throws HTMLCommon\InvalidArgumentException
     *
     * NOTE: this function has no relation to the Attribute "value"
     */
    public function setValue($value, $flag = HTMLCommon::REPLACE)
    {
        return $this;
    }

    // }}} setValue
    // {{{ loadOptions

    /**
     * Loads <option>s (and <optgroup>s) for select element
     *
     * The method expects a array of options and optgroups:
     * <pre>
     * array(
     *     'option value 1' => 'option text 1',
     *     ...
     *     'option value N' => 'option text N',
     *     'optgroup label 1' => array(
     *         'option value' => 'option text',
     *         ...
     *     ),
     *     ...
     * )
     * </pre>
     * If value is a scalar, then array key is treated as "value" attribute of
     * <option> and value as this <option>'s text. If value is an array, then
     * key is treated as a "label" attribute of <optgroup> and value as an
     * array of <option>s for this <optgroup>.
     *
     * If you need to specify additional attributes for <option> and <optgroup>
     * tags, then you need to use {@link addOption()} and {@link addOptgroup()}
     * methods instead of this one.
     *
     * @param array $options Array that holds all options to load
     *
     * @throws HTMLCommon\InvalidArgumentException    if junk is given in $options
     * @return HTMLCommon\Root\Datalist
     */
    public function loadOptions(array $options)
    {
        $this->possibleValues = array();
        $this->loadOptionsFromArray($this, $options);
        return $this;
    }

    // }}} loadOptions
    // {{{ loadOptionsFromArray

    /**
     * Adds options from given array into given container
     *
     * @param mixed $container options will be added to this container
     * @param array $options   options array
     *
     * @return void
     */
    protected function loadOptionsFromArray($container, array $options)
    {
        if (!is_subclass_of($container, 'HTMLCommon\Root\Datalist') &&
            !is_subclass_of($container, 'HTMLCommon\Root\Optgroup')) {
            return;
        }

        foreach ($options as $key => $value) {
            if (is_array($value)) {
                $optgroup = $container->addOptgroup($key);
                $this->loadOptionsFromArray($optgroup, $value);
            } else {
                $container->addOption($value, $key);
            }
        }
    }

    // }}} loadOptionsFromArray
}

// }}} HTMLCommon\Root\Datalist

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */