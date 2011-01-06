<?php
declare(ENCODING = 'iso-8859-1');
namespace HTML\Common3\Root;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * \HTML\Common3\Root\Form: Class for HTML <form> Elements
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

require_once 'HTML/Common3/Form/Container.php';

/**
 * class Interface for \HTML\Common3\
 */
require_once 'HTML/Common3/Face.php';

// {{{ \HTML\Common3\Root\Form

/**
 * Class for HTML <form> Elements
 *
 * @category HTML
 * @package  \HTML\Common3\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/\HTML\Common3\
 */
class Form
extends \HTML\Common3\Form\Container
implements \HTML\Common3\Face
{
    // {{{ properties

    /**
     * HTML Tag of the Element
     *
     * @var      string
     * @access   protected
     */
    protected $_elementName = 'form';

    /**
     * Associative array of attributes
     *
     * @var      array
     * @access   protected
     */
    protected $_attributes = array();

    /**
     * pointer to an legend if added
     *
     * @var      Pointer
     * @access   public
     */
    public $legend = null;

    /**
     * pointer to an fieldset if added
     *
     * @var      Pointer
     * @access   public
     */
    public $fieldset = null;

    /**
     * array of all fieldses in the form
     *
     * @var      Pointer
     * @access   public
     */
    public $fieldsets = array();

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
    protected $_watchedAttributes = array('name', 'action', 'method', 'id');

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
            /* BlockContainer */
            'address',
            'blockquote',
            'center',
            'del',
            'div',
            'dl',
            'fieldset',
            'h1',
            'h2',
            'h3',
            'h4',
            'h5',
            'h6',
            'hr',
            'ins',
            'menu',
            'ol',
            'p',
            'pre',
            'table',
            'ul',
            'if'
        ),
        'html' => array(
            '4.01' => array(
                'frameset' => array(
                    /* InlineContainer */
                    'a',
                    'abbr',
                    'acronym',
                    'applet',
                    'b',
                    'bdo',
                    'big',
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
                    'noscript',
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
                    /* BlockContainer */
                    'br'
                ),
                'transitional' => array(
                    /* InlineContainer */
                    'a',
                    'abbr',
                    'acronym',
                    'applet',
                    'b',
                    'bdo',
                    'big',
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
                    'noscript',
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
                    /* BlockContainer */
                    'br'
                )
            ),
            '5.0' => array(
                'transitional' => array(
                    /* InlineContainer */
                    'a',
                    'abbr',
                    'acronym',
                    'applet',
                    'b',
                    'bdo',
                    'big',
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
                    'noscript',
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
                    /* BlockContainer */
                    'br'
                )
            )
        ),
        'xhtml' => array(
            '1.0' => array(
                'frameset' => array(
                    /* InlineContainer */
                    'a',
                    'abbr',
                    'acronym',
                    'applet',
                    'b',
                    'bdo',
                    'big',
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
                    'noscript',
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
                    /* BlockContainer */
                    'br'
                ),
                'transitional' => array(
                    /* InlineContainer */
                    'a',
                    'abbr',
                    'acronym',
                    'applet',
                    'b',
                    'bdo',
                    'big',
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
                    'noscript',
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
                    /* BlockContainer */
                    'br'
                )
            )
        )
    );

    /**
     * Array of Attibutes which are possible for an Element
     *
     * @var        array
     * @access    protected
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
            'onreset',
            'onsubmit',
            'accept',
            'accept-charset',
            'action',
            'enctype',
            'method'
        ),
        'html' => array(
            '#all' => array(
                'lang'
            ),
            '4.01' => array(
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
                    'data',
                    'replace'
                ),
                'transitional' => array(
                    'name',
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
                    'lang'
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
     * Array of HTML Elements which are forbidden as parent elements
     * (and its parents)
     *
     * @var        array
     * @access    protected
     */
    protected $_forbidElements = array(
        '#all' => array(
            'form'
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
    // {{{ __construct

    /**
     * Class constructor, sets default attributes
     *
     * @param string|array $attributes Array of attribute 'name' => 'value' pairs
     *                                 or HTML attribute string
     * @param \HTML\Common3\ $parent     pointer to the parent object
     * @param \HTML\Common3\ $html       pointer to the HTML root object
     *
     * @return \HTML\Common3\
     * @access public
     * @see    HTML_Common::HTML_Common()
     * @see    HTML_Common2::__construct()
     * @see    HTML_Page2::HTML_Page2()
     */
    public function __construct($attributes = null,
    \HTML\Common3 $parent = null, \HTML\Common3 $html = null)
    {
        $attributes = $this->parseAttributes($attributes);

        if (!isset($attributes['action']) || $attributes['action'] == '') {
            $attributes['action'] = $_SERVER['PHP_SELF'];
        }

        parent::__construct($attributes, $parent, $html);

        $this->addFieldset();
    }

    // }}} __construct
    // {{{ initAttributes

    /**
     * set the default attributes
     *
     * @access public
     * @return \HTML\Common3\Root\Form
     */
    protected function initAttributes()
    {
        //set the default attributes
        $this->_attributes = array(
            'mothod' => 'post',
            'action' => ''
        );

        return $this;
    }

    // }}} initAttributes
    // {{{ addFieldset

    /**
     * adds an fieldset to this form
     *
     * @param string $legend the legend string for the fieldset
     *
     * @access public
     * @return \HTML\Common3\Root\Div
     */
    public function addFieldset($legend = 'Legend')
    {
        $fieldset          = $this->addFormElement('fieldset');

        $this->fieldset    =& $fieldset;
        $this->fieldsets[] =& $fieldset;

        $this->legend =& $fieldset->legend;

        if (is_string($legend)) {
            $this->legend->setValue($legend);
        }

        return $fieldset;
    }

    // }}} addFieldset
    // {{{ addDiv

    /**
     * adds an Div-Container to this form
     *
     * @param string $style the CSS style for the Div
     * @param string $class the CSS class for the Div
     * @param string $lang  the language for the Div
     * @param string $id    the id for the Div
     *
     * @access public
     * @return \HTML\Common3\Root\Div
     */
    public function addDiv($style='', $class='', $lang='', $id='')
    {
        $div = $this->fieldset->addElement('div');
        $div->setDiv($style, $class, $lang, $id);

        return $div;
    }

    // }}} addDiv
    // {{{ addLink

    /**
     * adds an link to this form
     *
     * @param integer $lang    Language Code
     * @param array   $func    Array including all actions to add
     * @param string  $ref     target address for this link or
     *                         "#" if javascript is used
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
    public function addLink($lang, $func, $ref = '#', $key = '', $name = '',
                            $index = 0, $char = 'UTF-8', $titel = '',
                            $typ = 'text/html', $info = '', $dis = false, $ico = '',
                            $target = '_blank', $weite = 0, $display = 'block')
    {
        $a = $this->fieldset->addElement('a');
        $a->setLink($lang, $func, $ref, $key, $name, $index, $char, $titel, $typ,
                    $info, $dis, $ico, $target, $weite, $display);

        return $a;
    }

    // }}} addLink
    // {{{ addTable

    /**
     * adds an table to this form
     *
     * @param string $lang    the language for the table
     * @param string $class   the CSS class for the table
     * @param string $summary the summary for the table
     * @param string $style   the CSS style for the table
     *
     * @access public
     * @return \HTML\Common3\Root\Table
     */
    public function addTable($lang='de', $class='', $summary='', $style='')
    {
        $table = $this->fieldset->addElement('table');
        $table->setTable($lang, $class, $summary, $style);

        return $table;
    }

    // }}} addTable
    // {{{ addInput

    /**
     * adds an input to this form
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
        $input = $this->fieldset->addElement('input');
        $input->setInput($type, $id, $class, $lang, $title, $value, $style);

        return $input;
    }

    // }}} addInput
    // {{{ changeClass

    /**
     * changes the class attribute for this form, the actual fieldset and its legend
     *
     * @param string $class the CSS class for the form
     *
     * @access public
     * @return void
     */
    public function changeClass($class)
    {
        $this->setAttribute('class', $class);
        $this->fieldset->setAttribute('class', $class);
        $this->legend->setAttribute('class', $class);
    }

    // }}} changeClass
    // {{{ disableFieldset

    /**
     * disables all fieldsets in this form
     *
     * @access public
     * @return void
     */
    public function disableFieldset()
    {
        $this->fieldset->disable();
        $this->legend->disable();

        foreach ($this->_elements as $element) {
            if ($element->getElementName() == "fieldset") {
                $element->disable();
            }
        }
    }

    // }}} disableFieldset
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

            if ($name == 'action') {
                if ($value === null) {
                    //set empty string
                    $value = '';
                }
            }

            if ($name == 'method') {
                if ($value === null || (string) $value == '') {
                    //set default value
                    $value = 'post';
                }
            }

            $this->_attributes[$name] = (string) $value;
        }
    }

    // }}} onAttributeChange
    // {{{ setForm

    /**
     * set specified attributes to the form
     *
     * @param string $lang  (optional) the language for the whole form
     * @param string $class (optional) a CSS class for the form
     * @param string $style (optional) a CSS style definition for the form
     *
     * @return \HTML\Common3\Root\Form
     * @access public
     */
    public function setForm($lang = '', $class = '', $style = '')
    {
        $lang = (string) $lang;

        if ($lang != '') {
            $this->setLang($lang, true);
        }

        $class = (string) $class;
        if ($class != '') {
            $this->setAttribute('class', $class);
        }

        $style = (string) $style;
        if ($style != '') {
            $this->setAttribute('style', $style);
        }

        return $this;
    }

    // }}} setForm
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
     * @access public
     */
    public function writeInner($dump = false, $comments = false, $levels = true)
    {
        $txt  = '';
        $step = (int) $this->getIndentLevel() + 1;

        foreach ($this->fieldsets as $fieldset) {
            if (is_object($fieldset)) {
                if ($fieldset->isEnabled() === true) {
                    $txt .= $fieldset->toHtml($step, $dump, $comments, $levels);
                } else {
                    $childElements = $fieldset->getChildren();

                    foreach ($childElements as $childElement) {
                        if ($childElement->getElementName() != 'legend') {
                            $txt .= $childElement->toHtml($step, $dump,
                                                          $comments, $levels);
                        }
                    }
                }
            }
        }

        return $txt;
    }

    // {{{ writeInner
    // {{{ setValue

    /**
     * sets or adds a value to the element
     * NOTE: this function has no relation to the Attribute "value"
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
        $this->fieldset->setValue($value, $flag);

        return $this;
    }

    // }}} setValue
    // {{{ addFormElement

    /**
     * add a new Child Element
     *
     * @param string|\HTML\Common3\ $type       the HTML Tag for the new Child Element
     *                                        or an \HTML\Common3\ Child object
     * @param string              $attributes Array of attribute 'name' => 'value'
     *                                        pairs or HTML attribute string
     * @param integer             $flag       Determines whether to prepend, append
     *                                        or replace the content. Use pre-defined
     *                                        constants.
     * @param string              $name       Element name
     * @param string              $labelText  the Label text for the Element
     * @param string|array        $data       Element-specific data (not used)
     *
     * @return void
     * @access public
     * @throw  \HTML\Common3\Exception
     */
    public function addFormElement($type, $attributes = null,
    $flag = HTML_APPEND, $name = null, $labelText = null, $data = null)
    {
        $i = count($this->_elements);

        $posElements = $this->getPosElements();
        $element     = null;
        $level       = $this->getIndentLevel() + 1;
        $root        = $this->getRoot();
        $docType     = $root->getDoctype(false);
        $elementName = $this->getElementName();

        if (!\HTML\Common3\Globals::getElementChildren($elementName)) {
            return null;
        }

        if (is_object($type)) {
            $elementType = 'object';

            //var_dump(1);
            // If this is an object, attempt to generate the appropriate HTML
            // code.
            $element = $type;
            if (is_subclass_of($type, '\HTML\Common3')) {
                $type = $element->getElementName();

                if (!$attributes) {
                    $attributes = $element->getAttributes(true);
                }

                $element->_parent = $this;
                $element->_html   = $this->_html;
            } elseif (get_class($element) === 'HTML_QuickForm' ||
                      get_class($element) === 'HTML_QuickForm2') {

                $type = 'form';
            } elseif (get_class($element) === 'HTML_Table') {
                //var_dump(2);
                $type = 'table';
            } elseif (get_class($element) === 'HTML_Page' ||
                      get_class($element) === 'HTML_Page2') {

                $type = 'html';
            } elseif (get_class($element) === 'HTML_Javascript') {
                //var_dump(2);
                $type = 'script';
            } else {
                //not supported
                throw new \HTML\Common3\ChildElementNotSupportedException(
                    'Type of Child Element \'' . get_class($element) .
                    '\' is not supported'
                );
            }
        } elseif (is_string($type)) {
            $type = strtolower((string) $type);
        } else {
            return null;
        }

        switch ($type) {
        case 'reset':
            require_once 'HTML/Common3/Form/Reset.php';

            $type    = new \HTML\Common3\Form\Reset($attributes);
            $element = $this->fieldset->addElement($type, $attributes, $flag);
            $element->setValue($labelText);

            break;
        case 'text':
            $label = $this->fieldset->addElement('label', array('for' => $name));
            $label->setValue($labelText);
            //var_dump($label);
            require_once 'HTML/Common3/Form/Text.php';

            $type    = new \HTML\Common3\Form\Text($attributes);
            $element = $this->fieldset->addElement($type, $attributes, $flag);

            break;
        case 'password':
            $label = $this->fieldset->addElement('label', array('for' => $name));
            $label->setValue($labelText);

            require_once 'HTML/Common3/Form/Password.php';

            $type    = new \HTML\Common3\Form\Password($attributes);
            $element = $this->fieldset->addElement($type, $attributes, $flag);

            break;
        case 'hidden':
            require_once 'HTML/Common3/Form/Hidden.php';

            $type    = new \HTML\Common3\Form\Hidden($attributes);
            $element = $this->fieldset->addElement($type, $attributes, $flag);

            $element->setValue($labelText);
            break;
        case 'checkbox':
            $label = $this->fieldset->addElement('label', array('for' => $name));
            $label->setValue($labelText);

            require_once 'HTML/Common3/Form/Checkbox.php';

            $type    = new \HTML\Common3\Form\Checkbox($attributes);
            $element = $this->fieldset->addElement($type, $attributes, $flag);

            break;
        case 'radio':
            $label = $this->fieldset->addElement('label', array('for' => $name));
            $label->setValue($labelText);

            require_once 'HTML/Common3/Form/Radio.php';

            $type    = new \HTML\Common3\Form\Radio($attributes);
            $element = $this->fieldset->addElement($type, $attributes, $flag);

            break;
        case 'submit':
            require_once 'HTML/Common3/Form/Submit.php';

            $type    = new \HTML\Common3\Form\Submit($attributes);
            $element = $this->fieldset->addElement($type, $attributes, $flag);
            $element->setValue($labelText);

            break;
        case 'image':
            $label = $this->fieldset->addElement('label', array('for' => $name));
            $label->setValue($labelText);

            require_once 'HTML/Common3/Form/Image.php';

            $type    = new \HTML\Common3\Form\Image($attributes);
            $element = $this->fieldset->addElement($type, $attributes, $flag);

            break;
        case 'button':
            require_once 'HTML/Common3/Form/Button.php';

            $type    = new \HTML\Common3\Form\Button($attributes);
            $element = $this->fieldset->addElement($type, $attributes, $flag);
            $element->setValue($labelText);

            break;
        case 'file':
            $label = $this->fieldset->addElement('label', array('for' => $name));
            $label->setValue($labelText);

            require_once 'HTML/Common3/Form/File.php';

            $type    = new \HTML\Common3\Form\File($attributes);
            $element = $this->fieldset->addElement($type, $attributes, $flag);

            break;
        case 'xbutton':
            require_once 'HTML/Common3/Root/Button.php';

            $type    = new \HTML\Common3\Root\Button($attributes);
            $element = $this->fieldset->addElement($type, $attributes, $flag);
            $element->setValue($labelText);

            break;
        case 'static':
            $label = $this->fieldset->addElement('label', array('for' => $name));
            $label->setValue($labelText);

            require_once 'HTML/Common3/Form/StaticText.php';

            $type    = new \HTML\Common3\Form\StaticText($attributes);
            $element = $this->fieldset->addElement($type, $attributes, $flag);

            break;
        case 'html':
            $label = $this->fieldset->addElement('label', array('for' => $name));
            $label->setValue($labelText);

            require_once 'HTML/Common3/Form/Html.php';

            $type    = new \HTML\Common3\Form\Html($attributes);
            $element = $this->fieldset->addElement($type, $attributes, $flag);

            break;
        case 'link':
            $label = $this->fieldset->addElement('label', array('for' => $name));
            $label->setValue($labelText);

            require_once 'HTML/Common3/Root/A.php';

            $type    = new \HTML\Common3\Root\A($attributes);
            $element = $this->fieldset->addElement($type, $attributes, $flag);

            break;
        case 'hiddenselect':
            require_once 'HTML/Common3/Form/HiddenSelect.php';

            $type    = new \HTML\Common3\Form\HiddenSelect($attributes);
            $element = $this->fieldset->addElement($type, $attributes, $flag);

            break;
        case 'header':
            if (in_array('zero', $posElements)) {
                require_once 'HTML/Common3/Root/Zero.php';

                $type    = new \HTML\Common3\Root\Zero();
                $element = $this->fieldset->addElement($type, $attributes, $flag);
            } else {
                //$this->fieldset->legend->setValue('');
            }
            break;
        case 'textarea':
            $label = $this->fieldset->addElement('label', array('for' => $name));
            $label->setValue($labelText);

            require_once 'HTML/Common3/Root/Textarea.php';

            $type    = new \HTML\Common3\Root\Textarea($attributes);
            $element = $this->fieldset->addElement($type, $attributes, $flag);

            break;
        default:
            $dt = $docType['type'];
            $ve = $docType['version'];
            $va = $docType['variant'];

            $enabled = \HTML\Common3\Globals::isElementEnabled($type, $dt, $ve,
            $va);

            if (!$enabled) {
                $replace = \HTML\Common3\Globals::getReplacement($elementName);

                if ($replace !== null && is_string($replace)) {
                    $type = $replace;
                } else {
                    return null;
                }
            }

            $element = null;

            if (!in_array($type, $posElements)) {
                $element = $this->fieldset->addElement($type, $attributes, $flag);
            } else {
                $element = parent::addElement($type, $attributes, $flag);
            }
        }

        if ($element !== null) {
            $element->setId((string) $name);
        }

        return $element;
    }

    // }}} addFormElement
}

// }}} \HTML\Common3\Root\Form

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */