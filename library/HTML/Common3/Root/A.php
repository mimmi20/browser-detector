<?php
declare(ENCODING = 'utf-8');
namespace HTML\Common3\Root;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * \HTML\Common3\Root\A: Class for HTML <a> Elements
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
 * base class for \HTML\Common3\ Text Elements
 */
require_once 'HTML/Common3/Text.php';

/**
 * class Interface for \HTML\Common3\
 */
require_once 'HTML/Common3/Face.php';

// {{{ \HTML\Common3\Root\A

/**
 * Class for HTML <a> Elements
 *
 * @category HTML
 * @package  \HTML\Common3\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/\HTML\Common3\
 */
class A
extends \HTML\Common3\Text
implements \HTML\Common3\Face
{
    // {{{ properties

    /**
     * HTML Tag of the Element
     *
     * @var      string
     * @access   protected
     */
    protected $_elementName = 'a';

    /**
     * pointer to an image var if added
     *
     * @var      Pointer
     * @access   public
     */
    public $img = null;

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
    protected $_watchedAttributes = array('id', 'name', 'href');

    /**
     * Array of HTML Elements which are possible as child elements
     *
     * @var      array
     * @access   protected
     */
    protected $_posElements = array(
        '#all' => array(
            /* InlineContainer */
            'abbr',
            'acronym',
            //'applet',
            'b',
            'bdo',
            //'big',
            'br',
            'button',
            'cite',
            'code',
            'del',
            'dfn',
            'dir',
            'em',
            'font',
            'i',
            'iframe',
            'img',
            'input',
            'ins',
            'kbd',
            'label',
            'map',
            //'noscript',
            'object',
            'q',
            's',
            'samp',
            'script',
            'select',
            'small',
            'span',
            'strike',
            'strong',
            'sub',
            'sup',
            'textarea',
            'tt',
            'u',
            'var',
            /* Text */
            'zero',
            'if'
        )
    );

    /**
     * Array of HTML Elements which are forbidden as parent elements
     * (and its parents)
     *
     * @var      array
     * @access   protected
     */
    protected $_forbidElements = array(
        '#all' => array(
            'a',
            'dir',
            'head'
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
            'onblur',
            'onfocus',
            'accesskey',
            'charset',
            /*'coords', //not supported */
            'href',
            'hreflang',
            'rel',
            /*'shape', //not supported */
            'type'
        ),
        'html' => array(
            '#all' => array(
                'lang'
            ),
            '4.01' => array(
                '#all' => array(
                    'rev',
                    'tabindex'
                ),
                'frameset' => array(
                    'name',
                    'target'
                ),
                'transitional' => array(
                    'name',
                    'target'
                )
            ),
            '5.0' => array(
                '#all' => array(
                    'media',
                    'ping',
                    'target'
                )
            )
        ),
        'xhtml' => array(
            '#all' => array(
                'xml:lang'
            ),
            '1.0' => array(
                '#all' => array(
                    'lang',
                    'rev',
                    'tabindex'
                ),
                'frameset' => array(
                    'name',
                    'target'
                ),
                'transitional' => array(
                    'name',
                    'target'
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
     * @param string $nameValue Attribute name
     * @param string $value     Attribute value, null if attribute is being removed
     *
     * @access protected
     * @return void
     */
    protected function onAttributeChange($nameValue, $value = null)
    {
        $nameValue = (string) $nameValue;

        if ($nameValue != '') {
            if ($nameValue == 'name') {
                if ($value === null) {
                    //set default size
                    $id = (string) $this->getId();

                    if ($id == '') {
                        throw new \HTML\Common3\CanNotRemoveAttributeException(
                            "Required attribute 'name' can not be removed"
                        );
                    } else {
                        $this->_attributes[$nameValue] = (string) $id;
                    }

                    return;
                }
            }

            if ($nameValue == 'id') {
                if ($value === null) {
                    $root = $this->getRoot();

                    //generate new ID
                    $id = $root->generateId($this->getName());

                    if ($id == '') {
                        throw new \HTML\Common3\CanNotRemoveAttributeException(
                            "Required attribute 'id' can not be removed"
                        );
                    } else {
                        $this->_attributes[$nameValue] = (string) $id;
                    }

                    return;
                }
            }

            if ($nameValue == 'href') {
                if ($value === null) {
                    $name = (string) $this->getName();

                    if ($name == '') {
                        throw new \HTML\Common3\CanNotRemoveAttributeException(
                            "Required attribute 'href' can not be removed"
                        );

                        return;
                    }
                }
            }

            $this->_attributes[$nameValue] = (string) $value;
        }
    }

    // }}} onAttributeChange
    // {{{ setLink

    /**
     * sets attributes to this link
     *
     * @param string       $lang    Language Code
     * @param string|array $func    Array including all actions to add
     * @param string       $ref     target address for this link or
     *                              "#" if javascript is used
     * @param string       $key     Char for Accesskey
     * @param string       $name    Name and ID for the Link
     * @param integer      $index   Number for Tabindex
     * @param string       $char    target charset
     * @param string       $titel   Title
     * @param string       $typ     target Mime-Typ
     * @param string       $info    text to display with link
     * @param boolean      $dis     Boolean-Value, if TRUE the Link will be
     *                              deactivated
     * @param string       $ico     path to an Icon
     * @param string       $target  default for target - not used
     * @param string       $weite   default for width
     * @param string       $display default for CSS-Attribute display
     *
     * @access public
     * @return void
     */
    public function setLink($lang, $func, $ref = '#', $key = '', $name = '',
                            $index = 0, $char = 'utf-8', $titel = '',
                            $typ = 'text/html', $info = '', $dis = false, $ico = '',
                            $target = '_blank', $weite = 0, $display = 'block')
    {
        //$txt = '';
        //$info_orig = $info;

        //if(is_bool($dis))echo $dis;

        //redefine function reference internal
        if ($dis == true) {
            //Link ist "disabled", also keine Funktion
            $func_int = '';
        } else {
            $func_int = $func;
        }

        //set href-Attribute
        if ($ref != '') {
            $this->setAttribute('href', $ref);
        }

        if ($ref != '#' && $target != '') {
            //set target Attribute
            $this->setAttribute('target', $target);
        }

        //set accesskey Attribute
        if ($key != '') {
            $this->setAttribute('accesskey', $key);

            $countReplaces = 1;

            //underline accesskey in Info text
            $info = str_replace(strtoupper($key),
                                '<span>'.strtoupper($key).'</span>',
                                $info,
                                $countReplaces);
        }

        //set title Attrbute
        if ($titel != '') {
            $this->setAttribute('title', $titel);
        }

        //set charset for link target (only for blind or internal link)
        if ($char != '' && $ref == '#') {
            $this->setAttribute('charset', $char);
        }

        //set tabindex Attribute
        if ($index > 0) {
            $this->setAttribute('tabindex', $index);
        }

        //set mime-type  for link target (only for blind or internal link)
        if ($typ != '' && $ref == '#') {
            $this->setAttribute('type', $typ);
        }

        //set id Attrbute with given name
        if ($name != '') {
            $this->setId($name);
        }

        //set language  for link target (only for blind or internal link)
        if ($ref == '#') {
            $this->setAttribute('hreflang', $lang);
        }

        //set disabled Attribute
        if ($dis == 'true') {
            $this->setAttribute('disabled', 'disabled');
        }

        //set language
        if ($lang != '') {
            $this->setLang($lang, true);
        }

        //add Action array
        if (is_array($func_int)) {
            foreach ($func_int as $funktion) {
                $this->addAttribute($funktion);
            }
        } else {
            $this->addAttribute($func_int);
        }

        //set width and display type
        $stil = '';
        if ($display != '') {
            $stil .= "display:$display;";
        }

        if ($weite > 0) {
            if (strlen(strip_tags($info)) * 10 > $weite) {
                $weite = (floor(strlen(strip_tags($info)) * 10 / 100) + 1) * 101;
            }

            $stil .= 'width:' . $weite . 'px;';
        }

        //set style
        if ($stil != '') {
            $this->setAttribute('style', $stil);
        }

        //insert icon
        if ($ico != '') {
            $icon = $this->addElement('img');

            $this->img = $icon;

            //set source and title for the icon
            $icon->setAttribute('src', $ico);
            $icon->setAttribute('alt', $titel);

            //set language for the icon
            if ($lang != '') {
                $icon->setLang($lang, true);
            }

            //add action array to the icon
            if (is_array($func_int)) {
                foreach ($func_int as $funktion) {
                    $icon->addAttribute($funktion);
                }
            } else {
                $icon->addAttribute($func_int);
            }
        }

        $this->setValue($info);
    }

    // }}} setLink
}

// }}} \HTML\Common3\Root\A

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */