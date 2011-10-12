<?php
declare(ENCODING = 'utf-8');
namespace HTML\Common3\Root;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * \HTML\Common3\Root\Head: Class for HTML <head> Elements
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
 * class Interface for \HTML\Common3
 */
require_once 'HTML/Common3/Face.php';

// {{{ \HTML\Common3\Root\Head

/**
 * Class for HTML <head> Elements
 *
 * @category HTML
 * @package  \HTML\Common3
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/\HTML\Common3
 */
class Head
extends \HTML\Common3
implements \HTML\Common3\Face
{
    // {{{ properties

    /**
     * Pointer to the Title-Tag inside the Head
     *
     * @var      Pointer
     * @access   protected
     */
    protected $_title = null;

    /**
     * Pointer to the Base-Tag inside the Head
     *
     * @var      Pointer
     * @access   protected
     */
    protected $_base = null;

    /**
     * Pointer to the Favicon inside the Head
     *
     * @var      Pointer
     * @access   protected
     */
    protected $_favicon = null;

    /**
     * Array of all Link-Tags inside the Head
     *
     * @var      Array
     * @access   protected
     */
    protected $_link = array();

    /**
     * Array of all Meta-Tags inside the Head
     *
     * @var      Array
     * @access   protected
     */
    protected $_meta = array();

    /**
     * Array of all Script-Tags inside the Head
     *
     * @var      Array
     * @access   protected
     */
    protected $_script = array();

    /**
     * Array of all Style-Tags inside the Head
     *
     * @var      Array
     * @access   protected
     */
    protected $_style = array();

    /**
     * HTML Tag of the Element
     *
     * @var      string
     * @access   protected
     */
    protected $_elementName = 'head';

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
            'object',
            'link',
            'title',
            'meta',
            'script',
            'style',
            'base',
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
            'abbr',
            'acronym',
            'address',
            'applet',
            'b',
            'bdo',
            'big',
            'blockquote',            'body',
            'br',
            'button',
            'center',
            'cite',
            'code',
            'del',
            'dfn',
            'dir',
            'div',
            'dl',
            'em',            'fieldset',
            'font',
            'form',
            'h1',
            'h2',
            'h3',
            'h4',
            'h5',
            'h6',            'head',
            'hr',
            'i',
            'iframe',
            'img',
            'input',
            'ins',
            'kbd',
            'label',
            'map',
            'menu',
            'noscript',
            'ol',
            'p',
            'pre',
            'q',
            's',
            'samp',
            'select',
            'small',
            'span',
            'strike',
            'strong',
            'sub',
            'sup',
            'table',
            'textarea',
            'tt',
            'u',
            'ul',
            'var',
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
            'profile'
        ),
        'html' => array(
            '#all' => array(
                'lang'
            )
        ),
        'xhtml' => array(
            '#all' => array(
                'dir',
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
     * Indicator to tell, if the Meta-Tags after Dublin Core are enabled
     *
     * @var      boolean
     * @access   protected
     */
    protected $_dc = false;

    /**
     * SVN Version for this class
     *
     * @var     string
     * @access  protected
     */
    const VERSION = '$Id$';

    // }}} properties
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
        if ($this->_elementEmpty) {
            return '';
        }

        $step     = (int)     $this->getIndentLevel() + 1;        //var_dump('Head::writeInner::$step:' . $step);
        $dump     = (boolean) $dump;
        $comments = (boolean) $comments;
        $levels   = (boolean) $levels;
        $txt      = '';

        $txt .= $this->_title->toHtml($step, $dump, $comments, $levels);

        if ($this->_base !== null) {
            $txt .= $this->_base->toHtml($step, $dump, $comments, $levels);
        }

        if ($this->_dc) {
            $this->addHeadLink("http://purl.org/dc/elements/1.1/", "schema.DC", 'rel');
            $this->addHeadLink("http://purl.org/dc/terms/", "schema.DCTERMS", 'rel');
        }

        if (isset($this->_link['rel'])) {
            foreach ($this->_link['rel'] as $linksOfRel) {
                foreach ($linksOfRel as $link) {
                    $txt .= $link->toHtml($step, $dump, $comments, $levels);
                }
            }
        }

        if (isset($this->_link['rev'])) {
            foreach ($this->_link['rev'] as $linksOfRel) {
                foreach ($linksOfRel as $link) {
                    $txt .= $link->toHtml($step, $dump, $comments, $levels);
                }
            }
        }

        if (isset($this->_meta['http-equiv'])) {
            foreach ($this->_meta['http-equiv'] as $x_meta) {
                if (is_array($x_meta)) {
                    foreach ($x_meta as $meta) {
                        $txt .= $meta->toHtml($step, $dump, $comments, $levels);
                    }
                } else {
                    $txt .= $x_meta->toHtml($step, $dump, $comments, $levels);
                }
            }
        }

        if (isset($this->_meta['name'])) {
            foreach ($this->_meta['name'] as $x_meta) {
                if (is_array($x_meta)) {
                    foreach ($x_meta as $meta) {
                        $txt .= $meta->toHtml($step, $dump, $comments, $levels);
                    }
                } else {
                    $txt .= $x_meta->toHtml($step, $dump, $comments, $levels);
                }
            }
        }

        if (isset($this->_script['file'])) {
            foreach ($this->_script['file'] as $script) {
                $txt .= $script->toHtml($step, $dump, $comments, $levels);
            }
        }

        if (isset($this->_script['insert'])) {
            foreach ($this->_script['insert'] as $script) {
                $txt .= $script->toHtml($step, $dump, $comments, $levels);
            }
        }

        foreach ($this->_style as $style) {
            $txt .= $style->toHtml($step, $dump, $comments, $levels);
        }

        $usedElements = array('base', 'title', 'link', 'meta', 'script', 'style');
        foreach ($this->_elements as $element) {
            if (is_object($element) &&
                !in_array($element->getElementName(), $usedElements)) {
                $txt .= $element->toHtml($step, $dump, $comments, $levels);
            }
        }


        return $txt;
    }

    // }}} writeInner
    // {{{ addTitle

    /**
     * adds an <title> element to this head
     *
     * @param string $titlevalue the title string
     * @param string $attributes Array of attribute 'name' => 'value'
     *                             pairs or HTML attribute string
     *
     * @access public
     * @return \HTML\Common3\Root\Title
     */
    public function addTitle($titlevalue, $attributes = null)
    {
        if ($this->_title === null) {
            //var_dump($this->_title);
            $title        = parent::addElement('title', $attributes);
            //var_dump($title);
            $this->_title =& $title;
        } else {
            $title = $this->_title;
        }

        $title->setValue((string) $titlevalue);

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
    public function addMeta($type = 'name', $name = '', $content = '', $lang = '', $schema = '')
    {
        $posTypes = array(
            'name',
            'http-equiv'
        );

        if (!in_array($type, $posTypes)) {
            return null;
        }

        $name = strtolower($name);

        $attributes = array(
            $type => $name,
            'content' => $content
        );

        if ($schema != '') {
            $attributes['scheme'] = $schema;
        }

        $meta = parent::addElement('meta', $attributes);

        if ($lang != '') {
            $meta->setLang($lang, true);
        }

        if (substr($name, 0, 3) == 'dc.') {
            $this->_meta[$type][$name][] =& $meta;
        } else {
            $this->_meta[$type][$name] =& $meta;
        }

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
        if ($this->_base === null) {
            $base = parent::addElement('base');
            $base->setAttribute('href', $href);

            $this->_base =& $base;
        } else {
            $base =& $this->_base;
            $base->setAttribute('href', $href);
        }
        return $base;
    }

    // }}} addBase
    // {{{ addHeadLink

    /**
     * Adds <link> tags to the head of the document
     *
     * <p>$relType defaults to 'rel' as it is the most common relation type used.
     * ('rev' refers to reverse relation, 'rel' indicates normal, forward relation.)
     * Typical tag: <link href="index.php" rel="Start"></p>
     *
     * @param string       $href       The link that is being related.
     * @param string       $relation   Relation of link.
     * @param string       $relType    Relation type attribute.
     *                                 Either rel or rev (default: 'rel').
     * @param array|string $attributes Associative array of remaining attributes
     *
     * @access public
     * @return \HTML\Common3\Root\Link|null
     */
    function addHeadLink($href, $relation, $relType = 'rel', $attributes = array())
    {
        $posTypes = array('rel', 'rev');
        $relType  = (string) $relType;

        if (in_array($relType, $posTypes)) {
            $relation   = (string) $relation;
            $attributes = $this->parseAttributes($attributes);

            $attributes['href']   = (string) $href;
            $attributes[$relType] = $relation;

            $link = parent::addElement('link', $attributes);

            $this->_link[$relType][$relation][] =& $link;

            return $link;
        } else {
            return null;
        }
    }

    // }}} addHeadLink
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
    public function addMetalink($href, $rel='stylesheet', $type='', $charset='',
                                $id='')
    {
        $link = $this->addHeadLink($href, $rel, 'rel', array());

        if ($type != '') {
            $link->setAttribute('type', (string) $type);
        }

        if ($charset != '') {
            $link->setAttribute('charset', strtolower((string) $charset));
        }

        if ($id != '') {
            $link->setId((string) $id);
        }

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
        $file = parent::addElement('script');

        $file->setAttribute('type', $type);
        $file->setValue($content);

        $this->_script['insert'][] =& $file;

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
        $file = parent::addElement('script');

        $file->setAttribute('type', $type);
        $file->setAttribute('src', $url);

        $this->_script['file'][$url] =& $file;

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
        $styleSheet = $this->addMetalink($url, 'stylesheet', $type, '', '');

        if ($media !== null) {
            $styleSheet->setAttribute('media', $media);
        }

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
        $style = parent::addElement('style');
        $style->setAttribute('type', $type);
        $style->setValue($content);

        $this->_style[] =& $style;

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
     * @param string $href     The link that is being related.
     * @param string $type     File type
     * @param string $relation Relation of link
     *
     * @access public
     * @return \HTML\Common3\Root\Link
     */
    function addFavicon($href, $type = 'image/x-icon', $relation = 'shortcut icon')
    {
        if ($this->_favicon === null) {
            $favicon        = $this->addMetalink($href, $relation, $type, '', '');
            $this->_favicon =& $favicon;
        } else {
            $favicon = $this->_favicon;
        }

        return $favicon;
    }

    // }}} addFavicon
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
     * @return \HTML\Common3\Root\Head
     */
    function setHeadProfile($profile = '')
    {
        $this->setAttribute('profile', (string) $profile);        return $this;
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
     * @return string $profile URL to profile
     * @access public
     */
    public function getHeadProfile()
    {
        return (string) $this->getAttribute('profile');
    }

    // }}} getHeadProfile
    // {{{ getTitle

    /**
     * Return the title of the page.
     *
     * @return   string
     * @access   public
     */
    public function getTitle()
    {
        return $this->_title->getValue();
    }

    // }}} getTitle
    // {{{ setMetaData

    /**
     * Sets or alters a meta tag.
     *
     * @param string  $name       Value of name or http-equiv tag
     * @param string  $content    Value of the content tag
     * @param boolean $http_equiv META type "http-equiv" defaults to null
     *
     * @access public
     * @return \HTML\Common3\Root\Head
     */
    public function setMetaData($name, $content, $http_equiv = false)
    {
        if ((string) $content != '') {
            if ($http_equiv === true) {
                $this->addMeta('http-equiv', $name, $content, '', '');
            } else {
                $this->addMeta('name', $name, $content, '', '');
            }
        }        return $this;
    }

    // }}} setMetaData
    // {{{ unsetMetaData

    /**
     * Unsets a meta tag.
     *
     * @param string  $name       Value of name or http-equiv tag
     * @param boolean $http_equiv META type "http-equiv" defaults to null
     *
     * @access public
     * @return \HTML\Common3\Root\Head
     */
    public function unsetMetaData($name, $http_equiv = false)
    {
        if ($http_equiv === true) {
            unset($this->_meta['http-equiv'][$name]);
        } else {
            unset($this->_meta['name'][$name]);
        }        return $this;
    }

    // }}} unsetMetaData
    // {{{ setMetaRefresh

    /**
     * Shortcut to set or alter a refresh meta tag
     *
     * <p>If no $url is passed, "self" is presupposed, and the appropriate URL
     * will be automatically generated. In this case, an optional third
     * boolean parameter enables https redirects to self.</p>
     *
     * @param integer $time  Time till refresh (in seconds)
     * @param string  $url   Absolute URL or "self"
     * @param boolean $https If $url == self, this allows for the https
     *                       protocol defaults to null
     *
     * @access public
     * @return \HTML\Common3\Root\Head
     */
    public function setMetaRefresh($time, $url = 'self', $https = false)
    {
        if ($url === 'self') {
            if ($https === true) {
                $protocol = 'https://';
            } else {
                $protocol = 'http://';
            }

            $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        }

        $this->addMeta('http-equiv', 'Refresh', "$time; url=$url");        return $this;
    }

    // }}} setMetaRefresh
    // {{{ setMetaContentType

    /**
     * Sets an http-equiv Content-Type meta tag
     *
     * @access public
     * @return \HTML\Common3\Root\Head
     */
    public function setMetaContentType()
    {
        $this->addMeta('http-equiv', 'Content-Type', $this->getContentType());        return $this;
    }

    // }}} setMetaContentType
    // {{{ addElement

    /**
     * add a new Child Element
     *
     * @param string|\HTML\Common3 $type       the HTML Tag for the new Child Element
     *                                        or an \HTML\Common3 Child object
     * @param string              $attributes Array of attribute 'name' => 'value'
     *                                        pairs or HTML attribute string
     * @param integer             $flag       Determines whether to prepend, append
     *                                        or replace the content. Use pre-defined
     *                                        constants.
     *
     * @return null|\HTML\Common3
     * @access public
     * @throw  \HTML\Common3\Exception
     */
    public function addElement($type, $attributes = null, $flag = HTML_APPEND)
    {
        $root        = $this->getRoot();
        $docType     = $root->getDoctype(false);
        $element     = null;
        $elementName = $this->getElementName();

        if (!$root->_allElements[$elementName]['hasChildren']) {
            return null;
        }

        if ($type === null || $type === '' || is_int($type)) {
            return null;
        }

        if (is_object($type)) {
            $elementType = 'object';

            // If this is an object, attempt to generate the appropriate HTML
            // code.
            $element = $type;
            if (is_subclass_of($type, '\HTML\Common3')) {
                $type = $element->getElementName();

                if (!$attributes) {
                    $attributes = $element->getAttributes(true);
                }

                $element->setParent($this);
                $element->setHtml($root);

                $element->setDoctype($root->getDoctype(true));
                $element->setCharset($root->getCharset());
            } elseif (get_class($element) === 'HTML_Form' ||
                      get_class($element) === 'HTML_Quickform' ||
                      get_class($element) === 'HTML_Quickform2') {

                $type = 'form';
            } elseif (get_class($element) === 'HTML_Table') {
                $type = 'table';
            } elseif (get_class($element) === 'HTML_Page' ||
                      get_class($element) === 'HTML_Page2') {

                $type = 'html';
            } elseif (get_class($element) === 'HTML_Javascript') {
                $type = 'script';
            } else {
                //not supported
                $type        = '';
                $elementType = '';
            }
        } elseif (is_string($type)) {
            $type        = strtolower((string) $type);
            $elementType = 'string';
        }

        switch ($type) {
        case 'meta':
            $element = $this->addMeta(((isset($attributes['type'])) ? $attributes['type'] : null),
                                      ((isset($attributes['name'])) ? $attributes['name'] : null),
                                      ((isset($attributes['content'])) ? $attributes['content'] : null),
                                      ((isset($attributes['lang'])) ? $attributes['lang'] : null),
                                      ((isset($attributes['schema'])) ? $attributes['schema'] : null));
            break;
        case 'link':
            $element = $this->addHeadLink(((isset($attributes['href'])) ? $attributes['href'] : null),
                                          ((isset($attributes['relation'])) ? $attributes['relation'] : null),
                                          ((isset($attributes['relType'])) ? $attributes['relType']: null),
                                          $attributes);
            break;
        case 'script':
            if (!isset($attributes['type']) || $attributes['type'] == '') {
                $type = 'text/javascript';
            } else {
                $type = $attributes['type'];
            }

            if (is_object($element)) {
                $element = $this->addScriptDeclaration($element->getValue(), $type);
            } else {
                $element = $this->addScriptDeclaration('', $type);
            }
            break;
        case 'title':
            if (isset($attributes['title'])) {
                $element = $this->addTitle($attributes['title'], $attributes);
            } else {
                return null;
            }
            break;
        case 'style':
            $element = $this->addStyleSheet(((isset($attributes['url'])) ? $attributes['url'] : null),
                                            ((isset($attributes['type'])) ? $attributes['type'] : null),
                                            ((isset($attributes['media'])) ? $attributes['media'] : null));
            break;
        case 'base':
            if (isset($attributes['href'])) {
                $element = $this->addBase($attributes['href']);
            } else {
                return null;
            }
            break;
        default:
            $element = parent::addElement($type);
        }

        if ($element) {
            $element->setAttributes($attributes);
        }

        return $element;
    }

    // }}} addElement
    // {{{ getMeta

    /**
     * returns the meta-tags as array
     *
     * @access public
     * @return array
     */
    public function getMeta()
    {
        return $this->_meta;
    }

    // }}} getMeta
    // {{{ enableDublinCore

    /**
     * enables the Dublin Core Meta Tages
     *
     * @access public
     * @return \HTML\Common3\Root\Head
     */
    public function enableDublinCore()
    {
        $this->_dc = true;        return $this;
    }

    // }}} enableDublinCore
    // {{{ disableDublinCore

    /**
     * enables the Dublin Core Meta Tages
     *
     * @access public
     * @return \HTML\Common3\Root\Head
     */
    public function disableDublinCore()
    {
        $this->_dc = false;

        return $this;
    }

    // }}} disableDublinCore
    // {{{ addCopyRight

    /**
     * adds the Copyright to the Meta-tags
     *
     * @param string $copy the copyright message
     *
     * @access public
     * @return \HTML\Common3\Root\Head
     */
    public function addCopyRight($copy)
    {
        $copy = $this->clean($copy);

        $this->addMeta('name', 'copyright', $copy);

        if ($this->_dc) {
            $this->addMeta('name', 'dc.rights', $copy);
        }        return $this;
    }

    // }}} addCopyRight
    // {{{ addAuthor

    /**
     * adds the Author to the Meta-tags
     *
     * @param string $author the Author message
     *
     * @access public
     * @return \HTML\Common3\Root\Head
     */
    public function addAuthor($author)
    {
        $author = $this->clean($author);

        $this->addMeta('name', 'author', $author);

        if ($this->_dc) {
            $this->addMeta('name', 'dc.creator', $author);
        }        return $this;
    }

    // }}} addAuthor
    // {{{ addDesc

    /**
     * adds the Description to the Meta-tags
     *
     * @param string $desc the Author message
     *
     * @access public
     * @return \HTML\Common3\Root\Head
     */
    public function addDesc($desc)
    {
        $desc = $this->clean($desc);

        $this->addMeta('name', 'description', $desc);

        if ($this->_dc) {
            $this->addMeta('name', 'dc.description', $desc);
        }        return $this;
    }

    // }}} addDesc
}

// }}} \HTML\Common3\Root\Head

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */