<?php
declare(ENCODING = 'utf-8');
namespace HTML\Common3\Form;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * HTMLCommon\Form_HiddenSelect: Class for pseudo HTML <select> Elements
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

use HTML\Common3\Root\Select as HTMLSelectField;

/**
 * class Interface for HTMLCommon\
 */
use HTML\Common3\ElementsInterface;

// {{{ HTMLCommon\Form_HiddenSelect

/**
 * Class for pseudo HTML <select> Elements
 *
 * This class takes the same arguments as a select element, but instead
 * of creating a select ring it creates hidden elements for all values
 * already selected with setDefault or setConstant.  This is useful if
 * you have a select ring that you don't want visible, but you need all
 * selected values to be passed.
 *
 * @category HTML
 * @package  HTMLCommon\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/HTMLCommon\
 */
class HiddenSelect extends HTMLSelectField implements ElementsInterface
{
    // {{{ properties

    /**
     * Associative array of attributes
     *
     * @var      array
     */
    protected $_attributes = array();

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
        $name = (string) $name;
        $root = $this->getRoot();

        if ($name != '') {
            if ($name == 'name') {
                if ($value === null) {
                    //set default size
                    $id = (string) $this->getId();

                    if ($id == '') {
                        throw new HTMLCommon\CanNotRemoveAttributeException(
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
                    $id = $root->generateId($this->getName());

                    if ($id == '') {
                        throw new HTMLCommon\CanNotRemoveAttributeException(
                            "Required attribute 'id' can not be removed"
                        );
                    } else {
                        $this->_attributes[$name] = (string) $id;
                    }

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
     * @param string $type  the type for the input - ignored for this type
     * @param string $id    the id for the input
     * @param string $class the CSS class for the input
     * @param string $lang  the language for the input
     * @param string $title the title for the input
     * @param string $value the value for the input
     * @param string $style the CSS style for the input
     *
     * @return HTMLCommon\Root\Div
     */
    /*
    public function setInput($type = 'file', $id = '', $class = '', $lang = '',
                             $title = '', $value = '', $style = '')
    {
        parent::setInput('file', $id, $class, $lang, $title, $value, $style);
    }
    */
    // }}} setInput
    // {{{ getType

    /**
     * returns the element type
     *
     * @return string the element type (mostly the same as the element name)
     */
    public function getType()
    {
        return 'hiddenselect';
    }

    // }}} getType
}

// }}} HTMLCommon\Form_HiddenSelect

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */