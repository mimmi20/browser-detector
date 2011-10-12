<?php
declare(ENCODING = 'utf-8');
namespace HTML\Common3\Root;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * \HTML\Common3\Root\Img: Class for HTML <img> Elements
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

// {{{ \HTML\Common3\Root\Img

/**
 * Class for HTML <img> Elements
 *
 * @category HTML
 * @package  \HTML\Common3\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/\HTML\Common3\
 */
class Imgextends \HTML\Common3implements \HTML\Common3\Face
{
    // {{{ properties

    /**
     * HTML Tag of the Element
     *
     * @var      string
     * @access   protected
     */
    protected $_elementName = 'img';

    /**
     * Associative array of attributes
     *
     * @var      array
     * @access   protected
     */
    protected $_attributes = array(
        'alt' => '',
        'src' => ''
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
    protected $_watchedAttributes = array('src', 'alt');

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
            'alt',
            'height',
            'ismap',
            'longdesc',
            'src',
            'usemap',
            'width'
        ),
        'html' => array(
            '#all' => array(
                'lang',
                'name'
            ),
            '4.01' => array(
                'frameset' => array(
                    'align',
                    'border',
                    'hspace',
                    'vspace'
                ),
                'transitional' => array(
                    'align',
                    'border',
                    'hspace',
                    'vspace',
                    'name'
                )
            ),
            '5.0' => array(
                'transitional' => array(
                    'align',
                    'border',
                    'hspace',
                    'vspace',
                    'name'
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
                    'align',
                    'border',
                    'hspace',
                    'vspace',
                    'name'
                ),
                'transitional' => array(
                    'align',
                    'border',
                    'hspace',
                    'vspace',
                    'name'
                )
            )
        )
    );

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
     * @return \HTML\Common3\Root\Img
     */
    protected function initAttributes()
    {
        //set the default attributes
        $this->_attributes = array(
            'alt' => '',
            'src' => ''
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
            if ($name == 'src') {
                if ($value === null) {
                    throw new \HTML\Common3\CanNotRemoveAttributeException(
                        "Required attribute 'src' can not be removed"
                    );
                }
            }

            if ($name == 'alt') {
                if ($value === null) {
                    throw new \HTML\Common3\CanNotRemoveAttributeException(
                        "Required attribute 'alt' can not be removed"
                    );
                }
            }

            $this->_attributes[$name] = (string) $value;
        }
    }

    // }}} onAttributeChange
}

// }}} \HTML\Common3\Root\Img

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */