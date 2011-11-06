<?php
declare(ENCODING = 'utf-8');
namespace HTML\Common3\Root;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * HTMLCommon\Root\Meta: Class for HTML <meta> Elements
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

// {{{ HTMLCommon\Root\Meta

/**
 * Class for HTML <meta> Elements
 *
 * @category HTML
 * @package  HTMLCommon\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/HTMLCommon\
 */
class Meta extends HTMLCommon implements ElementsInterface
{
    // {{{ properties

    /**
     * HTML Tag of the Element
     *
     * @var      string
     */
    protected $_elementName = 'meta';

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
    protected $_watchedAttributes = array('content', 'http-equiv', 'name');

    /**
     * Indicator to tell, if the Object is an empty HTML Element
     *
     * @var      boolean
     */
    protected $_elementEmpty = true;

    /**
     * Array of HTML Elements which are possible as child elements
     *
     * @var      array
     */
    protected $_posElements = array();

    /**
     * Array of Attibutes which are possible for an Element
     *
     * @var      array
     */
    protected $_posAttributes = array(
        '#all' => array(
            'content',
            'http-equiv',
            'name',
            'scheme'
        ),
        'html' => array(
            '#all' => array(
                'lang'
            ),
            '5.0' => array(
                '#all' => array(
                    'charset'
                )
            )
        ),
        'xhtml' => array(
            '#all' => array(
                'xml:lang',
                'dir'
            ),
            '1.0' => array(
                '#all' => array(
                    'lang'
                )
            )
        )
    );

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

        //var_dump("meta::onAttributeChange($name, $value)");
        //var_dump($this->_attributes);

        if ($name != '') {
            if ($name == 'content') {
                if ($value === null) {
                    throw new HTMLCommon\CanNotRemoveAttributeException(
                        "Required attribute 'content' can not be removed"
                    );
                }
            }

            if ($name == 'http-equiv') {
                if ($value === null) {
                    if ((string) $this->getName() == '') {
                        //Attribute must be set, if "name" is not set
                        throw new HTMLCommon\CanNotRemoveAttributeException(
                            "Required attribute 'http-equiv' can not be removed"
                        );
                    } else {
                        unset($this->_attributes[$name]);
                        //unset($this->_attributes[$name]);
                    }

                    return;
                }
            }

            if ($name == 'name') {
                if ($value === null) {
                    if ((string) $this->getAttribute('http-equiv') == '') {
                        //Attribute must be set, if "http-equiv" is not set
                        throw new HTMLCommon\CanNotRemoveAttributeException(
                            "Required attribute 'name' can not be removed"
                        );
                    } else {
                        unset($this->_attributes[$name]);
                        //unset($this->_attributes[$name]);
                    }

                    return;
                }
            }

            $this->_attributes[$name] = (string) $value;
        }
        //var_dump($this->_attributes);
    }

    // }}} onAttributeChange

    public function toHtml($step = 0, $dump = false, $comments = false,
                           $levels = true)
    {
        return parent::toHtml($step, $dump, $comments, $levels);
    }

    public function writeInner($dump = false, $comments = false, $levels = true)
    {
        return parent::writeInner($dump, $comments, $levels);
    }

    protected function write($elementName, $innerHTML, $step = null,
                             $dump = false, $comments = false, $levels = true)
    {
        return parent::write($elementName, $innerHTML, $step, $dump, $comments, $levels);
    }

    public function getAttributes($asString = false)
    {
        //var_dump("meta::getAttributes($asString)");
        //var_dump($this->_attributes);
        if ($asString) {
            //var_dump("meta::getAttributes($asString)");

            $x = $this->getAttributesString();

            //var_dump($x);

            return $x;
        } else {
            return $this->_attributes;
        }
    }

    protected function getAttributesString()
    {
        //var_dump("meta::getAttributesString()");
        //var_dump($this->_attributes);
        return parent::getAttributesString();
    }

    public function setAttribute($name, $value = null)
    {
        //var_dump("meta::setAttribute($name, $value)");
        //var_dump($this->_attributes);
        $a = parent::setAttribute($name, $value);
        //var_dump($this->_attributes);
        return $a;
    }
}

// }}} HTMLCommon\Root\Meta

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */