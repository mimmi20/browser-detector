<?php
declare(ENCODING = 'utf-8');
namespace HTML\Common3\Root;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * \HTML\Common3\Root\Html: Class for HTML <html> Elements
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
 * @package  \HTML\Common3
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @version  SVN: $Id$
 * @link     http://pear.php.net/package/\HTML\Common3
 */

/**
 * base class for \HTML\Common3
 */
require_once 'HTML/Common3.php';

/**
 * DTD class for \HTML\Common3
 */
require_once 'HTML/Common3/Root/Dtd.php';

/**
 * class Interface for \HTML\Common3
 */
require_once 'HTML/Common3/Face.php';

// {{{ \HTML\Common3\Root\Html

/**
 * Class for HTML <html> Elements
 *
 * @category HTML
 * @package  \HTML\Common3
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/\HTML\Common3
 */
class Htmlextends \HTML\Common3implements \HTML\Common3\Face
{
    // {{{ properties

    /**
     * HTML Tag of the Element
     *
     * @var      string
     * @access   protected
     */
    protected $_elementName = 'html';

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
     * \HTML\Common3 class itself
     *
     * contains all required attributes
     *
     * @var      array
     * @see      onAttributeChange()
     * @see      getWatchedAttributes()
     * @access   protected
     * @readonly
     */
    protected $_watchedAttributes = array();

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
            'head'
        ),
        'html' => array(
            '4.01' => array(
                'strict' => array(
                    'body'
                ),
                'frameset' => array(
                    'frameset'
                ),
                'transitional' => array(
                    'body'
                )
            ),
            '5.0' => array(
                '#all' => array(
                    'body'
                )
            )
        ),
        'xhtml' => array(
            '1.0' => array(
                'strict' => array(
                    'body'
                ),
                'frameset' => array(
                    'frameset'
                ),
                'transitional' => array(
                    'body'
                )
            ),
            '1.1' => array(
                '#all' => array(
                    'body'
                )
            ),
            '2.0' => array(
                '#all' => array(
                    'body'
                )
            )
        )
    );

    /**
     * Array of Attibutes which are possible for an Element
     *
     * @var      array
     * @access   protected
     */
    protected $_posAttributes = array(
        '#all' => array(),
        'html' => array(
            '#all' => array(
                'lang'
            ),
            '5.0' => array(
                '#all' => array(
                    'manifest'
                )
            )
        ),
        'xhtml' => array(
            '#all' => array(
                'dir',
                'xml:lang',
                'xmlns'
            ),
            '1.0' => array(
                '#all' => array(
                    'lang'
                )
            ),
            '1.1' => array(
                '#all' => array(
                    'xmlns:xsi',            //xsi namespace
                    'xsi:schemalocation'    //xsi namespace
                )
            ),
            '2.0' => array(
                '#all' => array(
                    'xmlns:xsi',            //xsi namespace
                    'xsi:schemalocation',   //xsi namespace
                    'version'
                )
            )
        )
    );

    /**
     * Pointer to the head object, the object is set up in Constructor
     *
     * @var      pointer
     * @access   public
     */
    public $head = null;

    /**
     * Pointer to the body object, the object is set up in Constructor
     *
     * @var      pointer
     * @access   public
     */
    public $body = null;

    /**
     * Pointer to the frameset object, the object is set up in Constructor
     *
     * @var      pointer
     * @access   public
     */
    public $frameset = null;

    /**
     * Indicator to tell, if the Object is an the Root of the HTML-Tree
     *
     * @var      boolean
     * @access   protected
     */
    protected $_isRootElement = true;

    /**
     * Defines whether XML prolog should be prepended to XHTML documents
     *
     * @var      boolean
     * @see      enableXmlProlog()
     * @see      disableXmlProlog()
     * @access   protected
     */
    protected $_xmlProlog = false;

    /**
     * Indicator to tell, if the language is already added to the <meta> tags
     *
     * @var      boolean
     * @access   protected
     */
    protected $_langAdded = false;

    /**
     * Pointer to the DTD object, the object is set up in Constructor
     *
     * @var      pointer
     * @access   public
     */
    public $rootDtd = null;

    /**
     * SVN Version for this class
     *
     * @var     string
     * @access  protected
     */
    const VERSION = '$Id$';

    // }}} properties
    // {{{ Constructor and Destructor ******************************************
    // {{{ __construct

    /**
     * Class constructor, sets default attributes
     *
     * @param string|array $attributes Array of attribute 'name' => 'value'
     *                                 pairs or HTML attribute string
     * @param \HTML\Common3 $parent     pointer to the parent object
     * @param \HTML\Common3 $html       pointer to the HTML root object
     *
     * @access public
     * @return \HTML\Common3\Root\Html
     */
    public function __construct($attributes = null,
    \HTML\Common3 $parent = null, \HTML\Common3 $html = null)
    {
        $attributes = $this->parseAttributes($attributes);

        parent::__construct($attributes, $parent, $html);

        //disable xml prolog by default
        $this->_xmlProlog = false;

        //disable cache by default
        $this->setCache(false);

        //set, if the xml-prolog should be shown
        if (isset($attributes['prolog'])) {
            if ($attributes['prolog']) {
                $root->enableXmlProlog();
            } else {
                $root->disableXmlProlog();
            }

            unset($attributes['prolog']);
        }

        //set the head profile
        if (isset($attributes['profile'])) {
            $root->setHeadProfile($attributes['profile']);

            unset($attributes['profile']);
        }

        //create the document structure
        $this->createStructure();
    }

    // }}} __construct
    // {{{ createStructure

    /**
     * creates the main structure of an HTML File
     *
     * @access protected
     * @return void
     */
    protected function createStructure()
    {
        $head = $this->addElement('head');
        //var_dump(1);
        $head->setMetaContentType();
        //var_dump(2);
        $head->addTitle('');
        //var_dump(3);
        $this->head =& $head;
        //var_dump($this->_doctype);
        if ($this->_doctype['variant'] == 'frameset') {
            $frameset = $this->addElement('frameset');

            $this->frameset =& $frameset;

            $noframes = $frameset->addElement('noframes');
            $body     = $noframes->addElement('body');            $frame    = $frameset->addElement('frame');

            $body->setDoctype($this->getDoctype(true));
        } else {
            $body = $this->addElement('body');
        }

        $this->body =& $body;
        //var_dump($body);
        if ($this->langAdded === false) {
            $this->head->addMeta('http-equiv', 'Content-Language',
                                 $this->getLang());
            $this->langAdded = true;
        }

        $this->rootDtd = new \HTML\Common3\Root\Dtd($this->_attributes, $this,
                                                   $this);

        $this->initDtd();
    }

    // }}} createStructure
    // }}} Constructor and Destructor ******************************************
    // {{{ Initialisation ******************************************************
    // {{{ initDtd

    /**
     * initiates the DTD
     *
     * @access protected
     * @return void
     */
    protected function initDtd()
    {
        if ($this->rootDtd !== null) {
            $this->rootDtd->_parent = $this;
            $this->rootDtd->_html   = $this;
            $this->rootDtd->setDoctype($this->getDoctype(true));
            $this->rootDtd->setCharset($this->getCharset());
            $this->rootDtd->setLang($this->getLang());
        }
    }

    // }}} initDtd
    // }}} Initialisation ******************************************************
    // {{{ getter and setter functions *****************************************
    // {{{ getElementEmpty

    /**
     * Returns true, if the Element is empty, false otherwise
     * HTML is never empty
     *
     * @return boolean
     * @access public
     * @see    getEmpty
     *
     * @assert() === false
     */
    public function getElementEmpty()
    {
        return false;
    }

    // }}} getElementEmpty
    // {{{ getIsRootElement

    /**
     * returns TRUE, if the element is the root element, returns false otherwise
     * HTML is ever an root element
     *
     * @return boolean
     * @access public
     *
     * @assert() === true
     */
    public function getIsRootElement()
    {
        return true;
    }

    // }}} getIsRootElement
    // {{{ setDisabled

    /**
     * sets the disable flag for the element
     * HTML can't be disabled
     *
     * @param boolean $disabled TRUE, if the Element should be disabled
     *
     * @return \HTML\Common3\Root\Html
     * @access public
     */
    public function setDisabled($disabled = false)
    {
        return $this;
    }

    // }}} setDisabled
    // {{{ getDisabled

    /**
     * Returns true, if the Element is disabled
     * HTML can't be disabled
     *
     * @return boolean
     * @access public
     *
     * @assert() === false
     */
    public function getDisabled()
    {
        return false;
    }

    // }}} getDisabled
    // {{{ setParent

    /**
     * sets the parent object in the HTML tree
     * HTML has no parent
     *
     * @param \HTML\Common3 $parent the parent object
     *
     * @return \HTML\Common3\Root\Html
     * @access protected
     */
    protected function setParent(\HTML\Common3 $parent)
    {
        return $this;
    }

    // }}} setParent
    // {{{ getParent

    /**
     * Returns the parent object in the HTML tree
     * HTML has no parent
     *
     * @return \HTML\Common3\Root\Html
     * @access public
     *
     * @assert() === null
     */
    public function getParent()
    {
        return null;
    }

    // }}} getParent
    // {{{ setHtml

    /**
     * sets the root object in the HTML tree
     * HTML is the Root itself
     *
     * @param \HTML\Common3 $html the root object
     *
     * @return \HTML\Common3
     * @access protected
     */
    protected function setHtml(\HTML\Common3 $html)
    {
        return $this;
    }

    // }}} setHtml
    // {{{ getHtml

    /**
     * Returns the root object in the HTML tree
     * HTML is the Root itself
     *
     * @return \HTML\Common3
     * @access public
     *
     * @assert() === null
     */
    public function getHtml()
    {
        return null;
    }

    // }}} getHtml
    // {{{ setIDs

    /**
     * sets a list of all stored ID's
     *
     * @param array $elements the new possible Element
     *
     * @access public
     * @return \HTML\Common3\Root\Html
     */
    public function setIDs(array $elements)
    {
        $this->_ids = $elements;

        return $this;
    }

    // }}} setIDs
    // {{{ getIDs

    /**
     * return a list of all stored ID's
     *
     * @access public
     * @return array
     *
     * @assert() === array()
     */
    public function getIDs()
    {
        return $this->_ids;
    }

    // }}} getIDs
    // {{{ getDoctypes

    /**
     * Returns true, if the Element is empty, false otherwise
     *
     * @return array
     * @access public
     */
    public function getDoctypes()
    {
        return $this->_doctypes;
    }

    // }}} getDoctypes
    // {{{ getDtd
    /**
     * Returns all possible DTD's
     *
     * @return array
     * @access public
     */
    public function getDtd()
    {
        return $this->_dtd;
    }

    // }}} getDtd
    // {{{ getAllNamespace

    /**
     * returns a list of all possible Namespaces
     *
     * @access public
     * @return array
     */
    public function getAllNamespaces()
    {
        return $this->_allNamespaces;
    }

    // }}} getAllNamespace
    // {{{ setAddToDtd

    /**
     * sets an Indicator, if not existing elements or attributes can be added to
     * the DTD
     *
     * @param boolean $addToDtd Indicator to set
     *
     * @return \HTML\Common3\Root\Html
     * @access public
     */
    public function setAddToDtd($addToDtd = false)
    {
        parent::setAddToDtd($addToDtd);

        /*
         @see http://www.alistapart.com/articles/customdtd/

        <!DOCTYPE html PUBLIC
        "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"
        [
          <!ATTLIST textarea maxlength CDATA #IMPLIED>
          <!ATTLIST textarea required (true|false) #IMPLIED>
          <!ATTLIST input required (true|false) #IMPLIED>
          <!ATTLIST select required (true|false) #IMPLIED>
        ]>
        */

        return $this;
    }

    // }}} setAddToDtd
    // {{{ getAddToDtd

    /**
     * returns an Indicator, if not existing elements or attributes can be added
     * to the DTD
     *
     * @return boolean
     * @access public
     *
     * @assert() === false
     */
    public function getAddToDtd()
    {
        return parent::getAddToDtd();
    }

    // }}} getAddToDtd
    // {{{ setLang

    /**
     * sets the Lang Attribute to the element
     *
     * @param string $lang the lang code for the element
     *
     * @access public
     * @return void
     */
    public function setLang($lang)
    {
        if (!is_string($lang)) {
            return;
        }

        parent::setLang($lang);

        if ($this->head !== null) {
            $this->head->addMeta('http-equiv', 'Content-Language', $lang);
            $this->langAdded = true;
        } else {
            $this->langAdded = false;
        }
    }

    // }}} setLang
    // }}} getter and setter functions *****************************************
    // {{{ Attribute related functions *****************************************
    // {{{ generateId

    /**
     * Generates an id for the element
     *
     * Called when an element is created without explicitly given id
     *
     * @param string $elementName Element name
     *
     * @return string The generated element id
     * @access protected
     * @throw  \HTML\Common3\InvalidArgumentException
     * @see    HTML_QuickForm2_Node::generateId()
     */
    protected function generateId($elementName = '')
    {
        $id = (string) $this->getId();
        if ($id !== '') {
            return $id;
        }

        $tokens = (strlen((string) $elementName)?
                   implode('-', explode('[', str_replace(']', '',
                   (string) $elementName))): 'qfauto_01');

        $container =& $this->_ids;

        $token     = 0;

        do {
            if (isset($container[$tokens])) {
                $tokens++;
            } else {
                $container[$tokens] =& $this;
                break;
            }
        } while (true);

        return $tokens;
    }

    // }}} generateId
    // {{{ storeId

    /**
     * Stores the explicitly given id to prevent duplicate id generation
     *
     * @param string      $id      the Element's id
     * @param object|null $element the Element object, if it is set to an
     *                             foreign object
     *
     * @return bollean True, if the ID is stored, FALSE otherwise
     * @access protected
     * @throw  \HTML\Common3\InvalidArgumentException
     * @see    HTML_QuickForm2_Node::storeId()
     */
    protected function storeId($id, $element = null)
    {
        if ($id == '' || $id === null) {
            return false;
        }

        $id = (string) $id;
        if ($element === null) {
            $element =& $this;
        }

        if ($this->registerId($id) === true) {
            $container =& $this->_ids;

            if (!isset($container[$id])) {
                $container[$id] =& $element;
                return true;
            } elseif (isset($container[$id]) &&
                ($container[$id] === null || $container[$id] === '')) {
                $container[$id] =& $element;
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    // }}} storeId
    // {{{ registerId

    /**
     * Registers the explicitly given id to prevent duplicate id generation
     *
     * @param string $id Element id
     *
     * @return bollean True, if the ID is registered, FALSE otherwise
     * @access protected
     * @throw  \HTML\Common3\InvalidArgumentException
     */
    protected function registerId($id)
    {
        $id = (string) $id;

        $container =& $this->_ids;

        if (!isset($container[$id])) {
            $container[$id] = '';
            return true;
        } else {
            $usedBy = '';

            if (is_string($container[$id]) || is_int($container[$id])) {
                $usedBy = $container[$id];
            } elseif (is_object($container[$id])) {
                $usedBy = $container[$id]->getId();
            }

            $isSelf = false;

            if ($usedBy == $id) {
                if (is_object($container[$id])) {
                    if ($this->getElementName() ==
                        $container[$id]->getElementName()) {
                        $isSelf = true;
                    }
                } else {
                    $isSelf = true;
                }
            }

            if ($isSelf === true) {
                return true;
            } elseif ($usedBy != '') {
                throw new \HTML\Common3\CanNotRegisterIDException(
                    'Registering of ID \'' . $id .
                    '\' was not possible! ID is used already:\'' .
                    $usedBy . '\'.');
            } else {
                return true;
            }
        }

        return false;
    }

    // }}} registerId
    // }}} Attribute related functions *****************************************
    // {{{ Option related functions ********************************************
    // {{{ setTabOffset

    /**
     * Sets the tab offset
     *
     * @param integer $offset new ident level for the element
     *
     * @access public
     * @return \HTML\Common3
     * @see    HTML_Common::setTabOffset()
     * @see    setIndentLevel()
     * @deprecated
     */
    public function setTabOffset($offset)
    {
        return $this;
    }

    // }}} setTabOffset
    // {{{ setIndentLevel

    /**
     * Sets the indentation level to an element and all its child elements
     *
     * @param integer $level new ident level for the Element
     *
     * @return \HTML\Common3
     * @access public
     * @see    HTML_Common2::setIndentLevel()
     * @see    changeLevel()
     */
    public function setIndentLevel($level)
    {
        return $this;
    }

    // }}} setIndentLevel
    // {{{ getTabOffset

    /**
     * Returns the tabOffset
     *
     * @access public
     * @return integer
     * @see    HTML_Common::getTabOffset()
     * @see    getIndentLevel()
     * @deprecated
     */
    public function getTabOffset()
    {
        return 0;
    }

    // }}} getTabOffset
    // {{{ getIndentLevel

    /**
     * Gets the indentation level
     *
     * @return integer
     * @access public
     * @see    HTML_Common2::getIndentLevel()
     *
     * @assert() === 0
     */
    public function getIndentLevel()
    {
        return 0;
    }

    // }}} getIndentLevel
    // }}} Option related functions ********************************************
    // {{{ output functions ****************************************************
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
        $step = 0;
        $this->changeLevel($step, true);

        $dump     = (boolean) $dump;
        $comments = (boolean) $comments;
        $levels   = (boolean) $levels;
        $lineEnd  = $this->getOption('linebreak');
        $type     = $this->_doctype['type'];        $version  = $this->_doctype['version'];

        $txt = '';

        if ($type === 'xhtml' /*|| ($type == 'html' && $version == '5.0')*/) {
            if ($this->_xmlProlog === true) {
                $txt .= '<?xml version="1.0" encoding="' . $this->getCharset() .
                        '"?>' . $lineEnd;
            }

            $this->setAttribute('xmlns', $this->getNamespace());
        }

        $this->initDtd();

        $txt .= $this->rootDtd->toHtml($step, $dump, $comments, $levels);
        $txt .= parent::toHtml($step, $dump, $comments, $levels);

        return $txt;
    }

    // }}} toHtml
    // {{{ display

     /**
     * Outputs the HTML content to the browser
     *
     * <p>This method outputs to the default display device. Normally that
     * will be the browser.</p>
     *
     * <p>If caching is turned off, which is the default case, this generates
     * the appropriate headers:</p>
     *
     * <code>
     * header("Expires: Tue, 1 Jan 1980 12:00:00 GMT");
     * header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
     * header("Cache-Control: no-cache");
     * header("Pragma: no-cache");
     * </code>
     *
     * <p>This functionality can be disabled:</p>
     *
     * <code>
     * $page->setCache('true');
     * </code>
     *
     * @return void
     * @access public
     * @see    HTML_Common::display()
     * @see    HTML_Page2::display()
     */
    public function display()
    {
        // Set mime type and character encoding
        $contentType = $this->getContentType();
        header('Content-Type: ' . $contentType);
        header('Content-Language: ' . $this->getLang(), true);

        // Generate HTML document
        $strHtml = $this->toHtml(0, false, false, false);
        header('Content-Length: ' . strlen($strHtml), true);

        $meta = $this->head->getMeta();

        if (isset($meta['http-equiv'])) {
            $meta['http-equiv'] = array_unique($meta['http-equiv']);

            $keys = array_keys($meta['http-equiv']);
            foreach ($keys as $x_key) {
                $x_meta = $meta['http-equiv'][$x_key];

                if (is_array($x_meta)) {
                    foreach ($x_meta as $y_meta) {
                        $key   = $y_meta->getAttribute('http-equiv');
                        $value = $y_meta->getAttribute('content');
                        //echo "2 $key: $value\n";
                        header("$key: $value", true);
                    }
                } else {
                    $key   = $x_meta->getAttribute('http-equiv');
                    $value = $x_meta->getAttribute('content');
                    //echo "1 $key: $value\n";
                    header("$key: $value", true);
                }
            }
        }

        // Output to browser, screen or other default device
        print $strHtml;
    }

    // }}} display
    // {{{ displayInner

    /**
     * Outputs the HTML content to the browser
     *
     * <p>This method outputs to the default display device. Normally that
     * will be the browser.</p>
     *
     * <p>If caching is turned off, which is the default case, this generates
     * the appropriate headers:</p>
     *
     * <code>
     * header("Expires: Tue, 1 Jan 1980 12:00:00 GMT");
     * header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
     * header("Cache-Control: no-cache");
     * header("Pragma: no-cache");
     * </code>
     *
     * <p>This functionality can be disabled:</p>
     *
     * <code>
     * $page->setCache('true');
     * </code>
     *
     * @return void
     * @access public
     * @see    HTML_Common::display()
     * @see    HTML_Page2::display()
     */
    public function displayInner()
    {
        // Generate HTML document
        $strHtml = $this->writeInner(false, false, false);

        // Output to browser, screen or other default device
        print $strHtml;
    }

    // }}} displayInner
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
        $step = 0;
        $this->changeLevel($step, true);        $step = 1;
        $txt  = $this->head->toHtml($step, $dump, $comments, $levels);

        $variant = $this->_doctype['variant'];

        if ($variant === 'frameset') {
            $txt .= $this->frameset->toHtml($step, $dump, $comments, $levels);
        } else {
            $txt .= $this->body->toHtml($step, $dump, $comments, $levels);
        }

        return $txt;
    }

    // }}} writeInner
    // }}} output functions ****************************************************
    // {{{ other functions *****************************************************
    // {{{ setValue

    /**
     * sets or adds a value to the element
     * HTML has no value
     *
     * @param string          $value an text that should be the value for the
     *                               element
     * @param integer|boolean $flag  Determines whether to prepend, append or
     *                               replace the content. Use pre-defined
     *                               constants.
     *
     * @return \HTML\Common3\Root\Html
     * @access public
     * @throws \HTML\Common3\InvalidArgumentException
     *
     * NOTE: this function has no relation to the Attribute "value"
     */
    public function setValue($value, $flag = HTML_REPLACE)
    {
        return $this;
    }

    // }}} setValue
    // {{{ getValue

    /**
     * gets the value to the element
     * HTML has no value
     *
     * @return string
     * @access public
     *
     * @assert() === ''
     */
    public function getValue()
    {
        return '';
    }

    // }}} getValue
    // {{{ getParentTree

    /**
     * returns a list of all elements which are in in the parent tree of the
     * current element
     *
     * @access protected
     * @return array
     */
    protected function getParentTree()
    {
        return array($this);
    }

    // }}} getParentTree
    // {{{ getRoot

    /**
     * returns an the Root Element of the object tree
     * HTML is the Root
     *
     * @access public
     * @return \HTML\Common3\Root\Html
     */
    public function getRoot()
    {
        return $this;
    }

    // }}} getRoot
    // {{{ isRoot

    /**
     * returns an the Indicator if the Element is the Root Element of the object
     * tree
     * HTML is the Root
     *
     * @return boolean
     * @access public
     */
    public function isRoot()
    {
        return true;
    }

    // }}} isRoot
    // {{{ addDtdAttribute

    /**
     * add an forbidden Element to the dtd to make it possible
     *
     * @param string $elementName the name of the element which should add the
     *                            new attribute for
     * @param string $attribute   the name of the attribute which should be
     *                            added
     * @param string $type        (Optional) the type for the new attribute
     * @param string $need        (Optional) the need level for the new
     *                            attribute
     *
     * @return \HTML\Common3\Root\Html
     * @access public
     */
    public function addDtdAttribute($elementName, $attribute, $type = 'CDATA',
        $need = '#IMPLIED')
    {
        $allNeeds = array(
            '#IMPLIED',
            '#REQUIRED'
        );

        $allTypes = array(
            'CDATA',
            'ID',
            '(true|false)'
        );

        $elementName = strtolower($elementName);
        $attribute   = strtolower($attribute);
        $type        = strtolower($type);
        //$need        = strtoupper($need);

        if ($elementName == '') {
            $elementName = $this->getElementName();
        }

        if ($elementName !== '' && $attribute !== '') {
            if (!in_array($type, $allTypes)) {
                $type = 'CDATA';
            }

            if (!in_array($need, $allNeeds)) {
                $need = '#IMPLIED';
            }

            if ($need == '#REQUIRED') {
                $this->_watchedAttributes[] = $type;
            }

            $this->rootDtd->addDtdAttribute($elementName, $attribute, $type,
                                            $need);
        }

        return $this;
    }

    // }}} addDtdAttribute
    // {{{ unsetDtdAttribute

    /**
     * unsets an forbidden Attribute to the DTD to make it unpossible
     *
     * @param string $elementName the name of the element which should add the new
     *                            attribute for
     * @param string $attribute   the name of the attribute which should be added
     * @param string $type        (Optional) the type for the new attribute
     * @param string $need        (Optional) the need level for the new attribute
     *
     * @return \HTML\Common3\Root\Dtd
     * @access public
     */
    public function unsetDtdAttribute($elementName, $attribute)
    {
        $elementName = strtolower((string) $elementName);
        $attribute   = strtolower((string) $attribute);

        if ($elementName !== '' && $attribute !== '') {
            $this->rootDtd->unsetDtdAttribute($elementName, $attribute);
        }

        return $this;
    }

    // }}} unsetDtdAttribute
    // }}} other functions *****************************************************
    // {{{ PAGE related functions **********************************************
    // {{{ setXmlProlog

    /**
     * Sets the flag for the XML prolog
     *
     * @param boolean $xmlProlog the new flag
     *
     * @access public
     * @return \HTML\Common3\Root\Html
     */
    public function setXmlProlog($xmlProlog = false)
    {
        if ($xmlProlog) {
            $this->_xmlProlog = true;
        } else {
            $this->_xmlProlog = false;
        }

        return $this;
    }

    // }}} setXmlProlog
    // {{{ getXmlProlog

    /**
     * returns the XML prolog flag
     *
     * @return boolean
     * @access public
     * @see    getMimeEncoding()
     */
    public function getXmlProlog()
    {
        return $this->_xmlProlog;
    }

    // }}} getXmlProlog
    // {{{ disableXmlProlog

    /**
     *  Disables prepending the XML prolog for XHTML documents
     *
     * <p>Normally, XHTML documents require the XML prolog to be on the first
     * line of each valid document:</p>
     *
     * <code>
     * <?xml version="1.0" encoding="utf-8"?>
     * <!DOCTYPE html
     *     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     *     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
     *
     * <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
     * <head>
     * ...
     * </code>
     *
     * <p>However, some browsers, most noticeably Microsoft Internet Explorer,
     * have difficulties properly displaying XHTML in compatibility mode with
     * this. This method is for workaround solutions, such as the infamous CSS
     * Box Hack.</p>
     *
     * <p>The opposite (and default) effect can be achieved using the
     * {@link enableXmlProlog} method.</p>
     *
     * <p>Usage:</p>
     *
     * <code>
     * $page->disableXmlProlog();
     * </code>
     *
     * @access public
     * @return \HTML\Common3\Root\Html
     * @see    HTML_Page2::disableXmlProlog()
     */
    public function disableXmlProlog()
    {
        $this->setXmlProlog(false);

        return $this;
    }

    // }}} disableXmlProlog
    // {{{ enableXmlProlog

    /**
     * Enables prepending the XML prolog for XHTML documents (default)
     *
     * <p>This method enables the default XHTML output, with an XML prolog on
     * the first line of the document. See {@link disableXmlProlog} for more
     * details on why it may or may not be advantageous to have the XML prolog
     * disabled.</p>
     *
     * <p>Usage:</p>
     *
     * <code>
     * $page->enableXmlProlog();
     * </code>
     *
     * @access public
     * @return \HTML\Common3\Root\Html
     * @see    HTML_Page2::ensableXmlProlog()
     */
    public function enableXmlProlog()
    {
        $this->setXmlProlog(true);

        return $this;
    }

    // }}} enableXmlProlog
    // {{{ addTitle

    /**
     * adds an <title> element to this head
     *
     * @param string $titlevalue the title string
     *
     * @access public
     * @return \HTML\Common3\Root\Title
     */
    public function addTitle($titlevalue)
    {
        $title = $this->head->addTitle($titlevalue);

        return $title;
    }

    // }}} addTitle
    // {{{ addMeta

    /**
     * adds an <meta> element to this head
     *
     * @param string $type    the type for this meta, allowed are "name" and
     *                        "http-equiv"
     * @param string $name    the name for this meta
     * @param string $content the content for this meta
     * @param string $lang    the language for this meta
     * @param string $schema  the schema for this meta
     *
     * @access public
     * @return \HTML\Common3\Root\Meta
     */
    public function addMeta($type='name', $name = '', $content = '', $lang = '',
                            $schema = '')
    {
        $meta = $this->head->addMeta($type, $name, $content, $lang, $schema);

        return $meta;
    }

    // }}} addMeta
    // {{{ addBase

    /**
     * adds an <base> element to this head
     *
     * @param string $href the base href for the page
     *
     * @access public
     * @return \HTML\Common3\Root\Base
     */
    public function addBase($href)
    {
        $base = $this->head->addBase($href);

        return $base;
    }

    // }}} addBase
    // {{{ addMetalink

    /**
     * Adds <link> tags of type "rel" to the head of the document
     *
     * @param string $href    The link that is being related.
     * @param string $rel     Relation of link.
     * @param string $type    type of <link>
     * @param string $charset charset of <link>
     * @param array  $id      id for the <link>
     *
     * @access public
     * @return \HTML\Common3\Root\Link
     */
    public function addMetalink($href, $rel = 'stylesheet', $type = '',
                                $charset = '', $id = '')
    {
        $link = $this->head->addMetalink($href, $rel, $type, $charset, $id);

        return $link;
    }

    // }}} addMetalink
    // {{{ addScriptDeclaration

    /**
     * Adds a script to the page
     *
     * <p>Content can be a string or an object with a toString method.
     * Defaults to text/javascript.</p>
     *
     * @param mixed  $content Script (may be passed as a reference)
     * @param string $type    Scripting mime (defaults to 'text/javascript')
     *
     * @access public
     * @return \HTML\Common3\Root\Script
     */
    public function addScriptDeclaration($content, $type = 'text/javascript')
    {
        $file = $this->head->addScriptDeclaration($content, $type);

        return $file;
    }

    // }}} addScriptDeclaration
    // {{{ addScript

    /**
     * Adds a linked script to the page
     *
     * @param string $url  URL to the linked script
     * @param string $type Type of script. Defaults to 'text/javascript'
     *
     * @access public
     * @return \HTML\Common3\Root\Script
     */
    public function addScript($url, $type="text/javascript")
    {
        $file = $this->head->addScript($url, $type);

        return $file;
    }

    // }}} addScript
    // {{{ addStyleSheet

    /**
     * Adds a linked stylesheet to the page
     *
     * @param string $url   URL to the linked style sheet
     * @param string $type  Mime encoding type
     * @param string $media Media type that this stylesheet applies to
     *
     * @access public
     * @return \HTML\Common3\Root\Link
     */
    public function addStyleSheet($url, $type = 'text/css', $media = null)
    {
        $styleSheet = $this->head->addStyleSheet($url, $type, $media);

        return $styleSheet;
    }

    // }}} addStyleSheet
    // {{{ addStyleDeclaration
    /**
     * Adds a stylesheet declaration to the page
     *
     * <p>Content can be a string or an object with a toString method.
     * Defaults to text/css.</p>
     *
     * @param mixed  $content Style declarations (may be passed as a reference)
     * @param string $type    Type of stylesheet (defaults to 'text/css')
     *
     * @access public
     * @return \HTML\Common3\Root\Style
     */
    public function addStyleDeclaration($content, $type = 'text/css')
    {
        $style = $this->head->addStyleDeclaration($content, $type);

        return $style;
    }

    // }}} addStyleDeclaration
    // {{{ addFavicon

    /**
     * Adds a shortcut icon (favicon)
     *
     * <p>This adds a link to the icon shown in the favorites list or on
     * the left of the url in the address bar. Some browsers display
     * it on the tab, as well.</p>
     *
     * @param string $href     the link that is being related.
     * @param string $type     File type
     * @param string $relation Relation of link, not used
     *
     * @access public
     * @return \HTML\Common3\Root\Link
     */
    public function addFavicon($href, $type = 'image/x-icon',
        $relation = 'shortcut icon')
    {
        $favicon = $this->addMetalink($href, 'shortcut icon', $type);

        return $favicon;
    }

    // }}} addFavicon
    // {{{ addHeadLink

    /**
     * Adds <link> tags to the head of the document
     *
     * <p>$relType defaults to 'rel' as it is the most common relation type
     * used. ('rev' refers to reverse relation, 'rel' indicates normal,
     * forward relation.)
     * Typical tag: <a href="index.php" rel="Start">some text</a>
     *
     * @param string $href       The link that is being related.
     * @param string $relation   Relation of link.
     * @param string $relType    Relation type attribute.  Either rel or rev
     *                           (default: 'rel').
     * @param array  $attributes Associative array of remaining attributes.
     *
     * @access public
     * @return \HTML\Common3\Root\Link
     */
    public function addHeadLink($href, $relation, $relType = 'rel',
        $attributes = array())
    {
        $link = $this->head->addHeadLink($href, $relation, $relType, $attributes);

        return $link;
    }

    // }}} addHeadLink
    // {{{ setHeadProfile

    /**
     * Sets the <head> profile
     *
     * <p>Profiles allow for adding various uncommented links, etc. to the
     * head section. For more details, see the W3C documents
     * ({@link http://www.w3.org/TR/html4/struct/global.html#h-7.4.4.3
     * http://www.w3.org/TR/html4/struct/global.html#h-7.4.4.3} and
     * {@link http://www.w3.org/TR/html401/types.html#type-links
     * http://www.w3.org/TR/html401/types.html#type-links})
     * detailing proper use.</p>
     *
     * @param string $profile URL to profile
     *
     * @access public
     * @return \HTML\Common3\Root\Html
     */
    public function setHeadProfile($profile = '')
    {
        $this->head->setAttribute('profile', (string) $profile);

        return $this;
    }

    // }}} setHeadProfile
    // {{{ getHeadProfile

    /**
     * returns the <head> profile
     *
     * <p>Profiles allow for adding various uncommented links, etc. to the
     * head section. For more details, see the W3C documents
     * ({@link http://www.w3.org/TR/html4/struct/global.html#h-7.4.4.3
     * http://www.w3.org/TR/html4/struct/global.html#h-7.4.4.3} and
     * {@link http://www.w3.org/TR/html401/types.html#type-links
     * http://www.w3.org/TR/html401/types.html#type-links})
     * detailing proper use.</p>
     *
     * @return string URL to profile
     * @access public
     */
    public function getHeadProfile()
    {
        return (string) $this->head->getAttribute('profile');
    }

    // }}} getHeadProfile
    // {{{ addBodyContent

    /**
     * Sets the content of the <body> tag
     *
     * <p>It is possible to add objects, strings or an array of strings
     * and/or objects. Objects must have a toHtml or toString method.</p>
     *
     * <p>By default, if content already exists, the new content is appended.
     * If you wish to overtoHtml whatever is in the body, use {@link setBody};
     * {@link unsetBody} completely empties the body without inserting new
     * content. You can also use {@link prependBodyContent} to prepend content
     * to whatever is currently in the array of body elements.</p>
     *
     * <p>The following constants are defined to be passed as the flag
     * attribute: HTML_APPEND, HTML_PREPEND and HTML_REPLACE.
     * Their usage should be quite clear from their names.</p>
     *
     * @param mixed $content New <body> tag content (may be passed as a
     *                       reference)
     * @param int   $flag    Determines whether to prepend, append or replace
     *                       the content. Use pre-defined constants.
     *
     * @access public
     * @return \HTML\Common3\Root\Html
     */
    public function addBodyContent($content, $flag = HTML_APPEND)
    {

        $this->body->addBodyContent($content, $flag);

        return $this;
    }

    // }}} addBodyContent
    // {{{ prependBodyContent

    /**
     * Prepends content to the content of the <body> tag. Wrapper for
     * {@link addBodyContent}
     *
     * <p>If you wish to overwrite whatever is in the body, use {@link setBody};
     * {@link addBodyContent} provides full functionality including appending;
     * {@link unsetBody} completely empties the body without inserting new
     * content. It is possible to add objects, strings or an array of strings
     * and/or objects Objects must have a toString method.</p>
     *
     * @param mixed $content New <body> tag content (may be passed as a
     *                       reference)
     *
     * @access public
     * @return \HTML\Common3\Root\Html
     */
    public function prependBodyContent($content)
    {
        $this->body->prependBodyContent($content);

        return $this;
    }

    // }}} prependBodyContent
    // {{{ setBody

    /**
     * Sets the content of the <body> tag.
     *
     * <p>If content exists, it is overwritten. If you wish to use a "safe"
     * version, use {@link addBodyContent}. Objects must have a toString
     * method.</p>
     *
     * <p>This function acts as a wrapper for {@link addBodyContent}. If you
     * are using PHP 4.x and would like to pass an object by reference, this
     * is not the function to use. Use {@link addBodyContent} with the flag
     * HTML_PAGE2_REPLACE instead.</p>
     *
     * @param mixed $content New <body> tag content. May be an object.
     *                       (may be passed as a reference)
     *
     * @access public
     * @return \HTML\Common3\Root\Html
     */
    public function setBody($content)
    {
        $this->body->setBody($content);

        return $this;
    }

    // }}} setBody
    // {{{ unsetBody

    /**
     * Unsets the content of the <body> tag.
     *
     * @access public
     * @return \HTML\Common3\Root\Html
     */
    public function unsetBody()
    {
        $this->body->unsetBody();

        return $this;
    }

    // }}} unsetBody
    // {{{ setBodyAttributes

    /**
     * Sets the attributes of the <body> tag
     *
     * <p>If attributes exist, they are overwritten. In XHTML, all attribute
     * names must be lowercase. As lowercase attributes are legal in SGML, all
     * attributes are automatically lowercased. This also prevents accidentally
     * creating duplicate attributes when attempting to update one.</p>
     *
     * @param array $attributes <body> tag attributes.
     *
     * @access public
     * @return \HTML\Common3\Root\Html
     */
    public function setBodyAttributes($attributes)
    {
        $this->body->setAttributes($attributes);

        return $this;
    }

    // }}} setBodyAttributes
    // {{{ getTitle

    /**
     * Return the title of the page.
     *
     * @return string
     * @access public
     */
    public function getTitle()
    {
        return $this->head->getValue();
    }

    // }}} getTitle
    // {{{ setMetaData

    /**
     * Sets or alters a <meta> tag.
     *
     * @param string $name       Value of name or http-equiv tag
     * @param string $content    Value of the content tag
     * @param bool   $http_equiv META type "http-equiv" defaults to null
     *
     * @access public
     * @return \HTML\Common3\Root\Html
     */
    public function setMetaData($name, $content, $http_equiv = false)
    {
        $this->head->setMetaData($name, $content, $http_equiv);

        return $this;
    }

    // }}} setMetaData
    // {{{ unsetMetaData

    /**
     * Unsets a <meta> tag.
     *
     * @param string $name       Value of name or http-equiv tag
     * @param bool   $http_equiv META type "http-equiv" defaults to null
     *
     * @access public
     * @return \HTML\Common3\Root\Html
     */
    public function unsetMetaData($name, $http_equiv = false)
    {
        $this->head->unsetMetaData($name, $http_equiv);

        return $this;
    }

    // }}} unsetMetaData
    // {{{ setMetaRefresh

    /**
     * Shortcut to set or alter a refresh <meta> tag
     *
     * <p>If no $url is passed, "self" is presupposed, and the appropriate URL
     * will be automatically generated. In this case, an optional third
     * boolean parameter enables https redirects to self.</p>
     *
     * @param integer $time  Time till refresh (in seconds)
     * @param string  $url   Absolute URL or "self"
     * @param boolean $https if $url == self, this allows for the https
     *                       protocol defaults to null
     *
     * @access public
     * @return \HTML\Common3\Root\Html
     */
    public function setMetaRefresh($time, $url = 'self', $https = false)
    {
        $this->head->setMetaRefresh($time, $url, $https);

        return $this;
    }

    // }}} setMetaRefresh
    // {{{ setMetaContentType

    /**
     * Sets an http-equiv Content-Type <meta> tag
     *
     * @access public
     * @return \HTML\Common3\Root\Html
     */
    public function setMetaContentType()
    {
        $this->head->setMetaContentType();

        return $this;
    }

    // }}} setMetaContentType
    // {{{ setTitle

    /**
     * Sets the title of the page
     *
     * <p>Usage:</p>
     *
     * <code>
     * $page->setTitle('My Page');
     * </code>
     *
     * @param string $title the new page title
     *
     * @access public
     * @return \HTML\Common3\Root\Html
     */
    public function setTitle($title)
    {
        $this->head->addTitle($title);

        return $this;
    }

    // }}} setTitle
    // {{{ addDiv

    /**
     * adds an Div-Container to this div
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
        $div = $this->body->addElement('div');
        $div->setDiv($style, $class, $lang, $id);

        return $div;
    }

    // }}} addDiv
    // {{{ enableDublinCore

    /**
     * enables the Dublin Core Meta Tages
     *
     * @access public
     * @return \HTML\Common3\Root\Html
     */
    public function enableDublinCore()
    {
        $this->head->enableDublinCore();

        return $this;
    }

    // }}} enableDublinCore
    // {{{ disableDublinCore

    /**
     * enables the Dublin Core Meta Tages
     *
     * @access public
     * @return \HTML\Common3\Root\Html
     */
    public function disableDublinCore()
    {
        $this->head->_disabledublinCore();

        return $this;
    }

    // }}} disableDublinCore
    // {{{ addCopyRight

    /**
     * enables the Dublin Core Meta Tages
     *
     * @access public
     * @return \HTML\Common3\Root\Html
     */
    public function addCopyRight($copy)
    {
        $this->head->addCopyRight($copy);

        return $this;
    }

    // }}} addCopyRight
    // {{{ addAuthor

    /**
     * adds the Author to the Meta-tags
     *
     * @param string $author the Author message
     *
     * @access public
     * @return \HTML\Common3\Root\Html
     */
    public function addAuthor($author)
    {
        $this->head->addAuthor($author);

        return $this;
    }

    // }}} addAuthor
    // {{{ addDesc

    /**
     * adds the Description to the Meta-tags
     *
     * @param string $desc the Author message
     *
     * @access public
     * @return \HTML\Common3\Root\Html
     */
    public function addDesc($desc)
    {
        $this->head->addDesc($desc);

        return $this;
    }

    // }}} addDesc
    // }}} PAGE related functions **********************************************
}

// }}} \HTML\Common3\Root\Html

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */