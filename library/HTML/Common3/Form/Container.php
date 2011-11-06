<?php
declare(ENCODING = 'utf-8');
namespace HTML\Common3\Form;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * Abstract Base class for simple HTMLCommon\ Form containers
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
 *    * Redistributions of source code must retain the above copyright
 *      notice, this list of conditions and the following disclaimer.
 *    * Redistributions in binary form must reproduce the above copyright
 *      notice, this list of conditions and the following disclaimer in the
 *      documentation and/or other materials provided with the distribution.
 *    * The names of the authors may not be used to endorse or promote products
 *      derived from this software without specific prior written permission.
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
 * class Interface for HTMLCommon\
 */
use HTML\Common3\ElementsInterface;

// {{{ HTMLCommon\Form_Container

/**
 * Abstract Base class for simple HTMLCommon\ Form containers
 *
 * @category HTML
 * @package  HTMLCommon\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/HTMLCommon\
 * @abstract
 */
abstract class Container extends Node implements ElementsInterface
{
    // {{{ properties

    /**
     * Array of field elements contained in this container
     *
     * @var      array
     */
    protected $_fields = array();

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
    protected $_watchedAttributes = array('id', 'name');

    /**
     * SVN Version for this class
     *
     * @var     string
     */
    const VERSION = '$Id$';

    // }}} properties
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
        if ('name' == $name) {
            if (null === $value) {
                throw new HTMLCommon\InvalidArgumentException(
                    "Required attribute 'name' can not be removed"
                );
            } else {
                $this->setName($value);
            }
        } elseif ('id' == $name) {
            if (null === $value) {
                throw new HTMLCommon\InvalidArgumentException(
                    "Required attribute 'id' can not be removed"
                );
            } else {
                $this->setId($value);
            }
        }
    }

    // }}} onAttributeChange
    // {{{ toggleFrozen

    /**
     * Changes the element's frozen status
     *
     * @param boolean $freeze Whether the element should be frozen or editable. If
     *                        omitted, the method will not change the frozen status,
     *                        just return its current value
     *
     * @return boolean Old value of element's frozen status
     */
    public function toggleFrozen($freeze = null)
    {
        if (null !== $freeze) {
            foreach ($this->_fields as $child) {
                $child->toggleFrozen($freeze);
            }
        }
        return parent::toggleFrozen($freeze);
    }

    // }}} toggleFrozen
    // {{{ persistentFreeze

    /**
     * Changes the element's persistent freeze behaviour
     *
     * If persistent freeze is on, the element's value will be kept (and
     * submitted) in a hidden field when the element is frozen.
     *
     * @param boolean $persistent New value for "persistent freeze". If omitted, the
     *                            method will not set anything, just return the
     *                            current value of the flag.
     *
     * @return boolean    Old value of "persistent freeze" flag
     */
    public function persistentFreeze($persistent = null)
    {
        if (null !== $persistent) {
            foreach ($this->_fields as $child) {
                $child->persistentFreeze($persistent);
            }
        }
        return parent::persistentFreeze($persistent);
    }

    // }}} persistentFreeze
    // {{{ getValue

    /**
     * Returns the element's value
     *
     * The default implementation for Containers is to return an array with
     * contained elements' values. The array is indexed the same way $_GET and
     * $_POST arrays would be for these elements.
     *
     * @return array|null
     */
    public function getValue()
    {
        $values = array();

        foreach ($this->_fields as $child) {
            $value = $child->getValue();
            if (null !== $value) {
                if ($child instanceof HTMLCommon\Form_Container) {
                    $values = $this->arrayMerge($values, $value);
                } else {
                    $name = $child->getName();

                    if (!strpos($name, '[')) {
                        $values[$name] = $value;
                    } else {
                        $tokens   =  explode('[', str_replace(']', '', $name));
                        $valueAry =& $values;
                        do {
                            $token = array_shift($tokens);
                            if (!isset($valueAry[$token])) {
                                $valueAry[$token] = array();
                            }
                            $valueAry =& $valueAry[$token];
                        } while (count($tokens) > 1);

                        $valueAry[$tokens[0]] = $value;
                    }
                }
            }
        }

        return empty($values)? null: $values;
    }

    // }}} getValue
    // {{{ arrayMerge

    /**
     * Merges two arrays
     *
     * Merges two arrays like the PHP function array_merge_recursive does,
     * the difference being that existing integer keys will not be renumbered.
     *
     * @param array $a first array
     * @param array $b second array
     *
     * @return array resulting array
     */
    protected function arrayMerge(array $a, array $b)
    {
        foreach ($b as $k => $v) {
            if (!is_array($v) || isset($a[$k]) && !is_array($a[$k])) {
                $a[$k] = $v;
            } else {
                $a[$k] = $this->arrayMerge(isset($a[$k])? $a[$k]: array(), $v);
            }
        }
        return $a;
    }

    // }}} arrayMerge
    // {{{ getElements

    /**
     * Returns an array of this container's elements
     *
     * @return array Container elements
     */
    public function getElements()
    {
        return $this->_fields;
    }

    // }}} getElements
    // {{{ appendChild

    /**
     * Appends an element to the container
     *
     * If the element was previously added to the container or to another
     * container, it is first removed there.
     *
     * @param HTMLCommon\Form\Node $element    Element to add
     * @param mixed                  $attributes Element attributes
     * @param integer                $flag       Determines whether to prepend,
     *                                           append or replace the content.
     *                                           Use pre-defined constants.
     *
     * @return HTMLCommon\Form\Node Added element
     * @throws HTMLCommon\InvalidArgumentException
     */
    public function appendChild(HTMLCommon\Form\Node $element,
        $attributes = null, $flag = HTMLCommon::APPEND)
    {
        if ($this === $element->getContainer()) {
            $this->removeChild($element);
        }

        $dummy = parent::addElement($element, $attributes, $flag);

        if ($dummy !== null) {
            $element->setContainer($this);
            $this->_fields[] = $element;
        }

        return $element;
    }

    // }}} appendChild
    // {{{ addElement

    /**
     * Appends an element to the container (possibly creating it first)
     *
     * If the first parameter is an instance of HTMLCommon\Form\Node then all
     * other parameters are ignored and the method just calls {@link appendChild()}.
     * In the other case the element is first created via
     * {@link HTMLCommon\Factory::createElement()} and then added via the
     * same method. This is a convenience method to reduce typing and ease
     * porting from HTML_QuickForm.
     *
     * @param string|HTMLCommon\ $type       the HTML Tag for the new Child Element
     *                                        or an HTMLCommon\ Child object
     * @param string              $attributes Array of attribute 'name' => 'value'
     *                                        pairs or HTML attribute string
     * @param integer             $flag       Determines whether to prepend, append
     *                                        or replace the content. Use pre-defined
     *                                        constants.
     * @param string              $name       Element name
     * @param array               $data       Element-specific data (not used)
     *
     * @return HTMLCommon\Form\Node the added element
     * @throws HTMLCommon\InvalidArgumentException
     * @throws HTMLCommon\NotFoundException
     */
    public function addElement($type, $attributes = null, $flag = HTMLCommon::APPEND,
    $name = null, array $data = array())
    {
        if ($type instanceof HTMLCommon\Form\Node) {
            return $this->appendChild($type, $attributes, $flag);
        } else {
            $element = parent::addElement($type, $attributes, $flag);

            if ($element) {
                $element->setName((string) $name);
                $this->_fields[] = $element;
            }

            return $element;
        }
    }

    // }}} addElement
    // {{{ removeChild

    /**
     * Removes the element from this container
     *
     * If the reference object is not given, the element will be appended.
     *
     * @param HTMLCommon\Form\Node $element Element to remove
     *
     * @return HTMLCommon\Form\Node Removed object
     */
    public function removeChild(HTMLCommon\Form\Node $element)
    {
        if ($element->getContainer() !== $this) {
            throw new HTMLCommon\NotFoundException(
                "Element with name '".$element->getName()."' was not found"
            );
        }
        foreach ($this->_fields as $key => $child) {
            if ($child === $element) {
                unset($this->_fields[$key]);
                $element->setContainer(null);
                break;
            }
        }
        return $element;
    }

    // }}} removeChild
    // {{{ insertBefore

    /**
     * Inserts an element in the container
     *
     * If the reference object is not given, the element will be appended.
     *
     * @param HTMLCommon\Form\Node $element   Element to insert
     * @param HTMLCommon\Form\Node $reference Reference to insert before
     *
     * @return HTMLCommon\Form\Node Inserted element
     */
    public function insertBefore(HTMLCommon\Form\Node $element,
                                 HTMLCommon\Form\Node $reference = null)
    {
        if (null === $reference) {
            return $this->appendChild($element);
        }
        $offset = 0;
        foreach ($this->_fields as $child) {
            if ($child === $reference) {
                if ($this === $element->getContainer()) {
                    $this->removeChild($element);
                }
                $element->setContainer($this);
                array_splice($this->_fields, $offset, 0, array($element));
                return $element;
            }
            $offset++;
        }
        throw new HTMLCommon\NotFoundException(
            "Reference element with name '".$reference->getName() .
            "' was not found"
        );
    }

    // }}} insertBefore
    // {{{ count

    /**
     * Returns the number of elements in the container
     *
     * @return integer
     */
    public function count()
    {
        return count($this->_fields);
    }

    // }}} count
}

// }}} HTMLCommon\Form_Container

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */