<?php
declare(ENCODING = 'iso-8859-1');
namespace HTML\Common3;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * \HTML\Common3\Box: Base Class for the most of boxed HTML Elements like
 * <div> or <p>
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

// {{{ \HTML\Common3\Box

/**
 * abstract Base Class for the most of the HTML boxed Elements
 *
 * Implements methods for working with HTML attributes, parsing and generating
 * attribute strings. Port of HTML_Common class for PHP4 originally written by
 * Adam Daniel with contributions from numerous other developers.
 *
 * @category HTML
 * @package  \HTML\Common3\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/\HTML\Common3\
 * @abstract
 */
abstract class Boxextends \HTML\Common3implements \HTML\Common3\Face
{
    // {{{ properties

    /**
     * Associative array of attributes
     *
     * @var      array
     * @access   protected
     */
    protected $_attributes = array();

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
    protected $_watchedAttributes = array('id', 'class');

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
            'a',
            'abbr',
            'acronym',
            'address',
            'applet',
            'article',
            'aside',
            'audio',
            'b',
            'bb',
            'bdo',
            'big',
            'blockquote',
            'br',
            'button',
            'canvas',
            'center',
            'cite',
            'code',
            'del',
            'details',
            'dfn',
            'dir',
            'div',
            'dl',
            'em',
            'embed',
            'figure',
            'font',
            'footer',
            'form',
            'h1',
            'h2',
            'h3',
            'h4',
            'h5',
            'h6',
            'header',
            'hr',
            'i',
            'iframe',
            'img',
            'input',
            'ins',
            'isindex',
            'kbd',
            'label',
            'map',
            'mark',
            'math',
            'menu',
            'meter',
            'nav',
            'noscript',
            'object',
            'ol',
            'p',
            'pre',
            'progress',
            'q',
            'ruby',
            's',
            'samp',
            'script',
            'section',
            'select',
            'small',
            'span',
            'strike',
            'strong',
            'sub',
            'sup',
            'svg',
            'table',
            'textarea',
            'time',
            'tt',
            'u',
            'ul',
            'var',
            'video',
            'zero'
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
            'onkeyup'
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
     * SVN Version for this class
     *
     * @var     string
     * @access  protected
     */
    const VERSION = '$Id$';

    // }}} properties    // {{{ addDiv

    /**
     * adds an Div-Container to this Element
     *
     * @param string $style the CSS style for the Div
     * @param string $class the CSS class for the Div
     * @param string $lang  the language for the Div
     * @param string $id    the id for the Div
     *
     * @access public
     * @return \HTML\Common3\Root\Div
     */
    public function addDiv($style = '', $class = '', $lang = '', $id = '')
    {
        $div = $this->addElement('div');
        $div->setDiv($style, $class, $lang, $id);

        return $div;
    }

    // }}} addDiv
    // {{{ addLink

    /**
     * adds an link to this Element
     *
     * @param integer $lang    Language Code
     * @param array   $func    Array including all actions to add
     * @param string  $ref     target address for this link or "#" if javascript is
     *                         used
     * @param string  $key     Char for Accesskey
     * @param string  $name    Name and ID for the Link
     * @param integer $index   Number for Tabindex
     * @param string  $char    target charset
     * @param string  $titel   Title
     * @param string  $typ     target Mime-Typ
     * @param string  $info    text to display with link
     * @param boolean $dis     Boolean-Value, if TRUE the Link will be deactivatet
     * @param string  $ico     path to an Icon
     * @param string  $target  default for target - not used
     * @param string  $weite   default for width
     * @param string  $display CSS display property
     *
     * @access public
     * @return \HTML\Common3\Root\A
     */
    public function addLink($lang, $func, $ref='#', $key='', $name='', $index=0,
                            $char='UTF-8', $titel='', $typ='text/html', $info='',
                            $dis=false, $ico='', $target='_blank', $weite=0,
                            $display='block')
    {
        $a = $this->addElement('a');
        $a->setLink($lang, $func, $ref, $key, $name, $index, $char, $titel, $typ,
                    $info, $dis, $ico, $target, $weite, $display);

        return $a;
    }

    // }}} addLink
    // {{{ addTable

    /**
     * adds an table to this Element
     *
     * @param string $lang    the language for the table
     * @param string $class   the CSS class for the table
     * @param string $summary the summary for the table
     * @param string $style   the CSS style for the table
     *
     * @access public
     * @return \HTML\Common3\Root\Table
     */
    public function addTable($lang = 'de', $class = '', $summary = '', $style = '')
    {
        $table = $this->addElement('table');
        $table->setTable($lang, $class, $summary, $style);

        return $table;
    }

    // }}} addTable
    // {{{ addInput

    /**
     * adds an input to this Element
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
     * @return \HTML\Common3\Root\Div
     */
    public function addInput($type = 'text', $id = '', $class = '', $lang = '',
                             $title = '', $value = '', $style = '')
    {
        $input = $this->addElement('input');
        $input->setInput($type, $id, $class, $lang, $title, $value, $style);

        return $input;
    }

    // }}} addInput
    // {{{ addForm

    /**
     * adds a form to this Element and sets specified attributes to the form
     *
     * @param string $lang  (optional) the language for the whole form
     * @param string $class (optional) a CSS class for the form
     * @param string $style (optional) a CSS style definition for the form
     *
     * @return \HTML\Common3\Root\Form
     * @access public
     */
    public function addForm($lang = 'de', $class = '', $style = '')
    {
        $form = $this->addElement('form');
        $form->setForm($lang, $class, $style);

        return $form;
    }

    // }}} addForm
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
            if ($name == 'id') {
                if ($value === null) {
                    //generate new ID
                    $id = $root->generateId($this->getName());

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

            if ($name == 'class') {
                if ($value === null) {
                    throw new \HTML\Common3\CanNotRemoveAttributeException(
                        "Required attribute 'class' can not be removed"
                    );
                }
            }

            $this->_attributes[$name] = (string) $value;
        }
    }

    // }}} onAttributeChange
    // {{{ toHtml

    /**
     * Returns the HTML representation of the element
     *
     * This magic method allows using the instances of \HTML\Common3\ in string
     * contexts
     *
     * @param int     $step     the level in which should startet the output,
     *                          the internal level is updated
     * @param boolean $dump     if TRUE an dump of the class is created
     * @param boolean $comments if TRUE comments were added to the output
     * @param boolean $levels   if TRUE the levels are added,
     *                          if FALSE the levels will be ignored
     *
     * @access public
     * @return string
     * @see    HTML_Common::toHtml()
     * @see    HTML_Page2::toHtml()
     * @see    write()
     */
    public function toHtml($step = 0, $dump = false, $comments = false,
                           $levels = true)
    {
        $elementName = $this->getElementName();
        $innerHTML   = $this->writeInner($dump, $comments, $levels);
        if ($innerHTML == '') {
            $txt = '';
        } else {
            $txt = $this->write($elementName, $innerHTML, $step, $dump,
                                    $comments, $levels);
        }
        return $txt;
    }

    // }}} toHtml
}

// }}} \HTML\Common3\Box

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */