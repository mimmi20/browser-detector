<?php
declare(ENCODING = 'utf-8');
namespace HTML\Common3\Form;

/**
 * Abstract Base class for simple HTMLCommon\ Form elements (not Containers)
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

// {{{ HTMLCommon\Form_Element

/**
 * Abstract Base class for simple HTMLCommon\ Form elements (not Containers)
 *
 * @category HTML
 * @package  HTMLCommon\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/HTMLCommon\
 * @abstract
 */
abstract class Element extends Node implements ElementsInterface
{
    // {{{ properties

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
    // {{{ getName

    /**
     * returns the Name for this Element
     *
     * @return string
     */
    public function getName()
    {
        return (string) $this->getAttribute('name');
    }

    // }}} getName
    // {{{ setName

    /**
     * sets the Name for this Element
     *
     * @param string $name Element Name
     *
     * @return HTMLCommon\Form_Element
     */
    public function setName($name)
    {
        $this->_attributes['name'] = (string) $name;
        parent::setName($name);

        return $this;
    }

    // }}} setName
    // {{{ setId

    /**
     * sets the ID Attribute to the element
     *
     * @param string $id the id for the element
     *
     * @return HTMLCommon\Form_Element
     */
    public function setId($id = null)
    {
        $root = $this->getRoot();

        if (is_null($id) || empty($id) || (string) $id == '') {
            $id = $root->generateId($this->getName());
        }

        $this->setAttribute('id', $id);
        $this->setName($id);

        return $this;
    }

    // }}} setId
    // {{{ getId

    /**
     * returns the ID Attribute of the element
     *
     * @return string the id for the element
     */
    public function getId()
    {
        return $this->getAttribute('id');
    }

    // }}} getId
    // {{{ getPersistentContent

    /**
     * Generates hidden form field containing the element's value
     *
     * This is used to pass the frozen element's value if 'persistent freeze'
     * feature is on
     *
     * @return string
     */
    protected function getPersistentContent()
    {
        if (!$this->persistent) {
            return '';
        }

        $this->value = $this->getValue();

        return $this->toHtml();//0, false, false, false);
    }

    // }}} getPersistentContent
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
        if ($this->persistent === true) {
            $name  = $this->getName();
            $value = $this->value;
            $id    = $this->getId();

            //save attributes
            $dummy            = $this->_attributes;
            $this->_attributes = array();

            $this->setId($id);
            $this->setName($name);
            $this->value = $value;
            $this->setAttribute('value', $value);
        }

        $txt = parent::toHtml($step, $dump, $comments, $levels);

        //restore attributes
        if ($this->persistent === true) {
            $this->_attributes = array();

            foreach ($dummy as $key => $value) {
                $this->setAttribute($key, $value);
            }
        }

        return $txt;
    }

    // }}} toHtml
}

// }}} HTMLCommon\Form_Element

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */