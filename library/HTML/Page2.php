<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | HTML_Page2                                                           |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997 - 2004 The PHP Group                              |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Adam Daniel <adaniel1@eesus.jnj.com>                        |
// |          Klaus Guenther <klaus@capitalfocus.org>                     |
// +----------------------------------------------------------------------+
//
// $Id$

/**
 * The PEAR::HTML_Page2 package provides a simple interface for generating an XHTML compliant page
 *
 * Features:
 * - supports virtually all HTML doctypes, from HTML 2.0 through XHTML 1.1 and
 *   XHTML Basic 1.0 plus preliminary support for XHTML 2.0
 * - namespace support
 * - global language declaration for the document
 * - line ending styles
 * - full META tag support
 * - support for stylesheet declaration in the head section
 * - support for script declaration in the head section
 * - support for linked stylesheets and scripts
 * - full support for header <link> tags
 * - body can be a string, object with toHtml or toString methods or an array
 *   (can be combined)
 *
 * Ideas for use:
 * - Use to validate the output of a class for XHTML compliance
 * - Quick prototyping using PEAR packages is now a breeze
 * @category HTML
 * @package  HTML_Page2
 * @version  0.6.2
 * @version  $Id$
 * @license  http://www.php.net/license/3_0.txt PHP License 3.0
 * @author   Adam Daniel <adaniel1@eesus.jnj.com>
 * @author   Klaus Guenther <klaus@capitalfocus.org>
 * @since   PHP 4.0.3pl1
 */

/**
 * Include PEAR core
 */
require_once 'PEAR.php';

/**
 * Include HTML_Common class
 *
 * <p>Additional required files:</p>
 *
 * <p>HTML/Page2/Doctypes.php is required in private method
 * _getDoctype()</p>
 *
 * <p>HTML/Page2/Namespaces.php is required in private method
 * _getNamespace()</p>
 *
 * <p>HTML/Page2/Frameset.php is optionally required in method setDoctype() if
 * the doctype variant is frameset.</p>
 */
require_once 'HTML/Common.php';

/**#@+
 * Determines how content is added to the body.
 *
 * Use with the @see addBodyContent method.
 *
 * @since      2.0.0
 */
define('HTML_PAGE2_APPEND',  0);
define('HTML_PAGE2_PREPEND', 1);
define('HTML_PAGE2_REPLACE', 2);
/**#@-*/

/**
 * (X)HTML Page generation class
 *
 * <p>This class handles the details for creating a properly constructed XHTML page.
 * Page caching, stylesheets, client side script, and Meta tags can be
 * managed using this class.</p>
 *
 * <p>The body may be a string, object, or array of objects or strings. Objects with
 * toHtml() and toString() methods are supported.</p>
 *
 * <p><b>XHTML Examples:</b></p>
 *
 * <p>Simplest example:</p>
 * <code>
 * // the default doctype is XHTML 1.0 Transitional
 * // All doctypes and defaults are set in HTML/Page/Doctypes.php
 * $p = new HTML_Page2();
 *
 * //add some content
 * $p->addBodyContent("<p>some text</p>");
 *
 * // print to browser
 * $p->display();
 * ?>
 * </code>
 *
 * <p>Complex XHTML example:</p>
 * <code>
 * <?php
 * // The array takes an array of attributes that determine many important
 * // aspects of the page generations.
 *
 * // Possible attributes are: charset, mime, lineend, tab, doctype, namespace,
 * // language and cache
 *
 * $p = new HTML_Page2(array (
 *
 *                          // Sets the charset encoding (default: utf-8)
 *                          'charset'  => 'utf-8',
 *
 *                          // Sets the line end character (default: unix (\n))
 *                          'lineend'  => 'unix',
 *
 *                          // Sets the tab string for autoindent (default: tab (\t))
 *                          'tab'  => '  ',
 *
 *                          // This is where you define the doctype
 *                          'doctype'  => "XHTML 1.0 Strict",
 *
 *                          // Global page language setting
 *                          'language' => 'en',
 *
 *                          // If cache is set to true, the browser may cache the output.
 *                          'cache'    => 'false'
 *                          ));
 *
 * // Here we go
 *
 * // Set the page title
 * $p->setTitle("My page");
 *
 * // Add optional meta data
 * $p->setMetaData("author", "My Name");
 *
 * // Put something into the body
 * $p->addBodyContent("<p>some text</p>");
 *
 * // If at some point you want to clear the page content
 * // and output an error message, you can easily do that
 * // See the source for {@link toHtml} and {@link _getDoctype}
 * // for more details
 * if ($error) {
 *     $p->setTitle("Error!");
 *     $p->setBody("<p>Houston, we have a problem: $error</p>");
 *     $p->display();
 *     die;
 * } // end error handling
 *
 * // print to browser
 * $p->display();
 * // output to file
 * $p->toFile('example.html');
 * ?>
 * </code>
 *
 * Simple XHTML declaration example:
 * <code>
 * <?php
 * $p = new HTML_Page2();
 * // An XHTML compliant page (with title) is automatically generated
 *
 * // This overrides the XHTML 1.0 Transitional default
 * $p->setDoctype('XHTML 1.0 Strict');
 *
 * // Put some content in here
 * $p->addBodyContent("<p>some text</p>");
 *
 * // print to browser
 * $p->display();
 * ?>
 * </code>
 *
 * <p><b>HTML examples:</b></p>
 *
 * <p>HTML 4.01 example:</p>
 * <code>
 * <?php
 * $p = new HTML_Page2('doctype="HTML 4.01 Strict"');
 * $p->addBodyContent = "<p>some text</p>";
 * $p->display();
 * ?>
 * </code>
 *
 * <p>nuke doctype declaration:</p>
 *
 * <code>
 * <?php
 * $p = new HTML_Page2('doctype="none"');
 * $p->addBodyContent = "<p>some text</p>";
 * $p->display();
 * ?>
 * </code>
 *
 *
 * @version 2.0.0
 * @package HTML_Page2
 * @author   Adam Daniel <adaniel1@eesus.jnj.com>
 * @author   Klaus Guenther <klaus@capitalfocus.org>
 */
class HTML_Page2 extends HTML_Common {

    /**
     * Contains the content of the <body> tag.
     *
     * @var     array
     * @since   2.0
     */
    private $_body = array();

    /**
     * Controls caching of the page
     *
     * @var     bool
     * @since   2.0
     */
    private $_cache = false;

    /**
     * Contains the character encoding string
     *
     * @var     string
     * @since   2.0
     */
    private $_charset = 'utf-8';

    /**
     * Contains the !DOCTYPE definition
     *
     * @var array
     * @since   2.0
     */
    private $_doctype = array('type'=>'xhtml','version'=>'1.0','variant'=>'transitional');

    /**
     * Contains the page language setting
     *
     * @var     string
     * @since   2.0
     */
    private $_language = 'en';

    /**
     * Array of Header <link> tags
     *
     * @var     array
     * @since   2.0
     */
    private $_links = array();

    /**
     * Array of meta tags
     *
     * @var     array
     * @since   2.0
     */
    private $_metaTags = array( 'standard' => array ( 'Generator' => 'PEAR HTML_Page' ) );

    /**
     * Document mime type
     *
     * @var      string
     * @since   2.0
     */
    private $_mime = 'text/html';

    /**
     * Document namespace
     *
     * @var      string
     * @since   2.0
     */
    private $_namespace = '';

    /**
     * Document profile
     *
     * @var      string
     * @since   2.0
     */
    private $_profile = '';

    /**
     * Array of linked scripts
     *
     * @var      array
     * @since   2.0
     */
    private $_scripts = array();

    /**
     * Array of scripts placed in the header
     *
     * @var  array
     * @since   2.0
     */
    private $_script = array();

    /**
     * Suppresses doctype
     *
     * @var     bool
     * @since   2.0
     */
    private $_simple = false;

    /**
     * Array of included style declarations
     *
     * @var     array
     * @since   2.0
     */
    private $_style = array();

    /**
     * Array of linked style sheets
     *
     * @var     array
     * @since   2.0
     */
    private $_styleSheets = array();

    /**
     * HTML page title
     *
     * @var     string
     * @since   2.0
     */
    private $_title = '';

    /**
     * Defines whether XML prolog should be prepended to XHTML documents
     *
     * @var     bool
     * @since   2.0
     */
    private $_xmlProlog = true;

    /**
     * Contains an instance of {@see HTML_Page2_Frameset}
     *
     * @var     object
     * @since   2.0
     */
    public $frameset;

    /**
     * Class constructor.
     *
     * <p>Accepts an array of attributes</p>
     *
     * <p><b>General options:</b></p>
     *     - "lineend" => "unix|win|mac" (Sets line ending style; defaults to
     *        unix.) See also {@link setLineEnd}.
     *     - "tab"     => string (Sets line ending style; defaults to \t.) See
     *        also {@link setTab}.
     *     - "cache"   => "false|true"  See also {@link setCache}.
     *     - "charset" => charset string (Sets charset encoding; defaults
     *       to utf-8) See also {@link setCharset} and {@link getCharset}.
     *     - "mime"    => mime encoding string (Sets document mime type;
     *       defaults to text/html)  See also {@link setMimeEncoding}.
     * <p><b>XHTML specific options:</b></p>
     *     - "doctype"  => string (Sets XHTML doctype; defaults to
     *       XHTML 1.0 Transitional.)  See also {@link setDoctype}.
     *     - "language" => two letter language designation. (Defines global
     *       document language; defaults to "en".) See also {@link setLang}.
     *     - "namespace"  => string (Sets document namespace; defaults to the
     *       W3C defined namespace.) See also {@link setNamespace}.
     *     - "profile" => string (Sets head section profile) See also
     *       {@link setHeadProfile}.
     *     - "prolog" => bool (Enables or disables the XML prolog. This is
     *       usually unwanted, as it makes the page invalid XHTML.) See also
     *       {@link disableXmlProlog} and {@link enableXmlProlog}.
     *
     * <p>For extensive usage examples, see class-level documentation
     * ({@see HTML_Page2}).</p>
     *
     * @param   mixed   $attributes     Associative array of table tag
     *                                  attributes
     * @since   2.0
     */
    public function __construct($attributes = array())
    {

        if ($attributes) {
            $attributes = $this->_parseAttributes($attributes);
        }

        if (isset($attributes['lineend'])) {
            $this->setLineEnd($attributes['lineend']);
        }

        if (isset($attributes['charset'])) {
            $this->setCharset($attributes['charset']);
        }

        if (isset($attributes['doctype'])){
            if ($attributes['doctype'] == 'none') {
                $this->_simple = true;
            } elseif ($attributes['doctype']) {
                $this->setDoctype($attributes['doctype']);
            }
        }

        if (isset($attributes['language'])) {
            $this->setLang($attributes['language']);
        }

        if (isset($attributes['mime'])) {
            $this->setMimeEncoding($attributes['mime']);
        }

        if (isset($attributes['namespace'])) {
            $this->setNamespace($attributes['namespace']);
        }

        if (isset($attributes['profile'])) {
            $this->setHeadProfile($attributes['profile']);
        }

        if (isset($attributes['tab'])) {
            $this->setTab($attributes['tab']);
        }

        if (isset($attributes['cache'])) {
            $this->setCache($attributes['cache']);
        }

        if (isset($attributes['prolog'])) {
            if ($attributes['prolog'] === false) {
                $this->disableXmlProlog();
            } else {
                $this->enableXmlProlog();
            }
        }

    } // end class constructor

    /**
     * Iterates through an array, returning an HTML string
     *
     * <p>It also handles objects, calling the toHTML or toString methods
     * and propagating the line endings and tabs for objects that
     * extend HTML_Common.</p>
     *
     * <p>For more details read the well-documented source.</p>
     *
     * @param   mixed       $element   The element to be processed
     * @return  string
     */
    private function _elementToHtml(&$element) // It's a reference just to save some memory.
    {

        // get the special formatting settings
        $lnEnd  = $this->_getLineEnd();
        $tab    = $this->_getTab();
        $tabs   = $this->_getTabs();
        $offset = $this->getTabOffset() + 1;

        // initialize the variable that will collect our generated HTML
        $strHtml = '';

        // Attempt to generate HTML code for what is passed
        if (is_object($element)) {
            // If this is an object, attempt to generate the appropriate HTML
            // code.

            if (is_subclass_of($element, 'html_common')) {
                // For this special case, we set the appropriate indentation
                // and line end styles. That way uniform HTML is generated.

                // The reason this does not check for each method individually
                // is that it could be that setTab, for example, could
                // possibly refer to setTable, etc. And such ambiguity could
                // create a big mess. So this will simply bias  the HTML_Page
                // class family toward other HTML_Common-based classes.

                // Of course, these features are not necessarily implemented
                // in all HTML_Common-based packages. But at least this makes
                // it possible to propagate the settings.
                $element->setTabOffset($offset);
                $element->setTab($tab);
                $element->setLineEnd($lnEnd);
            }

            // Attempt to generate code using first toHtml and then toString
            // methods. The result is not parsed with _elementToHtml because
            // it would improperly add one tab indentation to the initial line
            // of each object's output.
            if (method_exists($element, 'toHtml')) {
                $strHtml .= $element->toHtml() . $lnEnd;
            } elseif (method_exists($element, 'toString')) {
                $strHtml .= $element->toString() . $lnEnd;
            } else {
                // If the class does not have an appropriate method, an error
                // should be returned rather than simply dying or outputting
                // the difficult to troubleshoot 'Object' output.
                $class = get_class($element);
                PEAR::raiseError("Error: Content object (class $class) " .
                                 'does not support  methods toHtml() or ' .
                                 'toString().',0,PEAR_ERROR_TRIGGER);
            }
        } elseif (is_array($element)) {
            foreach ($element as $item) {
                // Parse each element individually
                $strHtml .= $this->_elementToHtml($item);
            }
        } else {
            // If we don't have an object or array, we can simply output
            // the element after indenting it and properly ending the line.
            $strHtml .= $tabs . $tab . $element . $lnEnd;
        }

        return $strHtml;

    } // end func _elementToHtml

    /**
     * Generates the HTML string for the <body> tag
     *
     * @return  string
     */
    private function _generateBody()
    {
        // get line endings
        $lnEnd = $this->_getLineEnd();
        $tabs = $this->_getTabs();

        // If body attributes exist, add them to the body tag.
        // Many attributes are depreciated because of CSS.
        $strAttr = $this->_getAttrString($this->_attributes);

        // If this is a frameset, we don't want to output the body tag, but
        // rather the <noframes> tag.
        if (isset($this->_doctype['variant']) && $this->_doctype['variant'] == 'frameset') {
            $this->_tabOffset++;
            $tabs = $this->_getTabs();
            $strHtml = $tabs . '<noframes>' . $lnEnd;
            $this->_tabOffset++;
            $tabs = $this->_getTabs();
        } else {
            $strHtml = '';
        }

        if ($strAttr) {
            $strHtml .= $tabs . "<body $strAttr>" . $lnEnd;
        } else {
            $strHtml .= $tabs . '<body>' . $lnEnd;
        }

        // Allow for mixed content in the body array, recursing into inner
        // array serching for non-array types.
        $strHtml .= $this->_elementToHtml($this->_body);

        // Close tag
        $strHtml .= $tabs . '</body>' . $lnEnd;

        // See above comment for frameset usage
        if (isset($this->_doctype['variant']) && $this->_doctype['variant'] == 'frameset') {
            $this->_tabOffset--;
            $strHtml .= $this->_getTabs() . '</noframes>' . $lnEnd;
            $this->_tabOffset--;
        }

        // Let's roll!
        return $strHtml;
    } // end func _generateBody

    /**
     * Generates the HTML string for the <head> tag
     *
     * @return string
     */
    private function _generateHead()
    {
        // Close empty tags if XHTML for XML compliance
        if ($this->_doctype['type'] == 'html'){
            $tagEnd = '>';
        } else {
            $tagEnd = ' />';
        }

        // get line endings
        $lnEnd = $this->_getLineEnd();
        $tab = $this->_getTab();
        $tabs = $this->_getTabs();

        $strHtml  = $tabs . '<head>' . $lnEnd;

        // Generate META tags
        foreach ($this->_metaTags as $type => $tag) {
            foreach ($tag as $name => $content) {
                if ($type == 'http-equiv') {
                    $strHtml .= $tabs . $tab . "<meta http-equiv=\"$name\" content=\"$content\"" . $tagEnd . $lnEnd;
                } elseif ($type == 'standard') {
                    $strHtml .= $tabs . $tab . "<meta name=\"$name\" content=\"$content\"" . $tagEnd . $lnEnd;
                }
            }
        }

        // Generate the title tag.
        // Pre-XHTML compatibility:
        //     This comes after meta tags because of possible
        //     http-equiv character set declarations.
        $strHtml .= $tabs . $tab . '<title>' . $this->getTitle() . '</title>' . $lnEnd;

        // Generate link declarations
        foreach ($this->_links as $link) {
            $strHtml .= $tabs . $tab . $link . $tagEnd . $lnEnd;
        }

        // Generate stylesheet links
        foreach ($this->_styleSheets as $strSrc => $strAttr ) {
            $strHtml .= $tabs . $tab . "<link rel=\"stylesheet\" href=\"$strSrc\" type=\"".$strAttr['mime'].'"';
            if (!is_null($strAttr['media'])){
                $strHtml .= ' media="'.$strAttr['media'].'"';
            }
            $strHtml .= $tagEnd . $lnEnd;
        }

        // Generate stylesheet declarations
        foreach ($this->_style as $styledecl) {
            foreach ($styledecl as $type => $content) {
                $strHtml .= $tabs . $tab . '<style type="' . $type . '">' . $lnEnd;

                // This is for full XHTML support.
                if ($this->_mime == 'text/html' ) {
                    $strHtml .= $tabs . $tab . $tab . '<!--' . $lnEnd;
                } else {
                    if(substr($content , 0 , strlen('@import ')) != '@import ') {
                        $strHtml .= $tab . $tab . $tab . '<![CDATA[' . $lnEnd;
                    }
                }

                if (is_object($content)) {

                    // first let's propagate line endings and tabs for other HTML_Common-based objects
                    if (is_subclass_of($content, "html_common")) {
                        $content->setTab($tab);
                        $content->setTabOffset(3);
                        $content->setLineEnd($lnEnd);
                    }

                    // now let's get a string from the object
                    if (method_exists($content, "toString")) {
                        $strHtml .= $content->toString() . $lnEnd;
                    } else {
                        PEAR::raiseError('Error: Style content object does not support  method toString().',
                                0,PEAR_ERROR_TRIGGER);
                    }

                } else {
                    $strHtml .= $content . $lnEnd;
                }

                // See above note
                if ($this->_mime == 'text/html' ) {
                    $strHtml .= $tabs . $tab . $tab . '-->' . $lnEnd;
                } else {
                    if(substr($content , 0 , strlen('@import ')) != '@import ') {
                        $strHtml .= $tab . $tab . ']]>' . $lnEnd;
                    }
                }
                $strHtml .= $tabs . $tab . '</style>' . $lnEnd;
            }
        } // end generating stylesheet blocks

        // Generate script file links
        foreach ($this->_scripts as $strSrc => $strType) {
            $strHtml .= $tabs . $tab . "<script type=\"$strType\" src=\"$strSrc\"></script>" . $lnEnd;
        }

        // Generate script declarations
        foreach ($this->_script as $script) {
            foreach ($script as $type => $content) {
                $strHtml .= $tabs . $tab . '<script type="' . $type . '">' . $lnEnd;

                // This is for full XHTML support.
                if ($this->_mime == 'text/html' ) {
                    $strHtml .= $tabs . $tab . $tab . '// <!--' . $lnEnd;
                } else {
                    $strHtml .= $tabs . $tab . $tab . '<![CDATA[' . $lnEnd;
                }

                if (is_object($content)) {

                    // first let's propagate line endings and tabs for other HTML_Common-based objects
                    if (is_subclass_of($content, "html_common")) {
                        $content->setTab($tab);
                        $content->setTabOffset(3);
                        $content->setLineEnd($lnEnd);
                    }

                    // now let's get a string from the object
                    if (method_exists($content, "toString")) {
                        $strHtml .= $content->toString() . $lnEnd;
                    } else {
                        PEAR::raiseError('Error: Script content object does not support  method toString().',
                                0,PEAR_ERROR_TRIGGER);
                    }

                } else {
                    $strHtml .= $content . $lnEnd;
                }

                // See above note
                if ($this->_mime == 'text/html' ) {
                    $strHtml .= $tabs . $tab . $tab . '// -->' . $lnEnd;
                } else {
                    $strHtml .= $tabs . $tab . $tab . '// ]]>' . $lnEnd;
                }
                $strHtml .= $tabs . $tab . '</script>' . $lnEnd;
            }
        } // end generating script blocks

        // Close tag
        $strHtml .=  $tabs . '</head>' . $lnEnd;

        // Let's roll!
        return $strHtml;
    } // end func _generateHead

    /**
     * Returns the doctype declaration
     *
     * @return string
     */
    private function _getDoctype()
    {
        require('HTML/Page2/Doctypes.php');

        if (isset($this->_doctype['type'])) {
            $type = $this->_doctype['type'];
        }

        if (isset($this->_doctype['version'])) {
            $version = $this->_doctype['version'];
        }

        if (isset($this->_doctype['variant'])) {
            $variant = $this->_doctype['variant'];
        }

        $strDoctype = '';

        if (isset($variant)) {
            if (isset($doctype[$type][$version][$variant][0])) {
                foreach ( $doctype[$type][$version][$variant] as $string) {
                    $strDoctype .= $string.$this->_getLineEnd();
                }
            }
        } elseif (isset($version)) {
            if (isset($doctype[$type][$version][0])) {
                foreach ( $doctype[$type][$version] as $string) {
                    $strDoctype .= $string.$this->_getLineEnd();
                }
            } else {
                if (isset($default[$type][$version][0])) {
                    $this->_doctype = $this->_parseDoctypeString($default[$type][$version][0]);
                    $strDoctype = $this->_getDoctype();
                }
            }
        } elseif (isset($type)) {
            if (isset($default[$type][0])){
                $this->_doctype = $this->_parseDoctypeString($default[$type][0]);
                $strDoctype = $this->_getDoctype();
            }
        } else {
            $this->_doctype = $this->_parseDoctypeString($default['default'][0]);
            $strDoctype = $this->_getDoctype();
        }

        if ($strDoctype) {
            return $strDoctype;
        } else {
            PEAR::raiseError('Error: "'.$this->getDoctypeString().'" is an unsupported or illegal document type.',
                                    0,PEAR_ERROR_TRIGGER);
            $this->_simple = true;
            return false;
        }

    } // end func _getDoctype

    /**
     * Retrieves the document namespace
     *
     * @return string
     */
    private function _getNamespace()
    {

        require('HTML/Page2/Namespaces.php');

        if (isset($this->_doctype['type'])) {
            $type = $this->_doctype['type'];
        }

        if (isset($this->_doctype['version'])) {
            $version = $this->_doctype['version'];
        }

        if (isset($this->_doctype['variant'])) {
            $variant = $this->_doctype['variant'];
        }

        $strNamespace = '';

        if (isset($variant)){
            if (isset($namespace[$type][$version][$variant][0]) && is_string($namespace[$type][$version][$variant][0])) {
                $strNamespace = $namespace[$type][$version][$variant][0];
            } elseif (isset($namespace[$type][$version][0]) && is_string($namespace[$type][$version][0]) ) {
                $strNamespace = $namespace[$type][$version][0];
            } elseif (isset($namespace[$type][0]) && is_string($namespace[$type][0]) ) {
                $strNamespace = $namespace[$type][0];
            }
        } elseif (isset($version)) {
            if (isset($namespace[$type][$version][0]) && is_string($namespace[$type][$version][0]) ) {
                $strNamespace = $namespace[$type][$version][0];
            } elseif (isset($namespace[$type][0]) && is_string($namespace[$type][0]) ) {
                $strNamespace = $namespace[$type][0];
            }
        } else {
            if (isset($namespace[$type][0]) && is_string($namespace[$type][0]) ) {
                $strNamespace = $namespace[$type][0];
            }
        }

        if ($strNamespace) {
            return $strNamespace;
        } else {
            PEAR::raiseError('Error: "' . $this->getDoctypeString() .
                                    '" does not have a default namespace.' .
                                    ' Use setNamespace() to define your namespace.',
                                    0, PEAR_ERROR_TRIGGER);
            return false;
        }

    } // end func _getNamespace

    /**
     * Parses a doctype declaration like "XHTML 1.0 Strict" to an array
     *
     * @param   string  $string     The string to be parsed
     * @return array
     */
    private function _parseDoctypeString($string)
    {

        $split = explode(' ',strtolower($string));
        $elements = count($split);

        if (isset($split[2])){
            $array = array('type'=>$split[0],'version'=>$split[1],'variant'=>$split[2]);
        } elseif (isset($split[1])){
            $array = array('type'=>$split[0],'version'=>$split[1]);
        } else {
            $array = array('type'=>$split[0]);
        }

        return $array;

    } // end func _parseDoctypeString

    /**
     * Sets the content of the <body> tag
     *
     * <p>It is possible to add objects, strings or an array of strings
     * and/or objects. Objects must have a toHtml or toString method.</p>
     *
     * <p>By default, if content already exists, the new content is appended.
     * If you wish to overwrite whatever is in the body, use {@link setBody};
     * {@link unsetBody} completely empties the body without inserting new
     * content. You can also use {@link prependBodyContent} to prepend content
     * to whatever is currently in the array of body elements.</p>
     *
     * <p>The following constants are defined to be passed as the flag
     * attribute: HTML_PAGE2_APPEND, HTML_PAGE2_PREPEND and HTML_PAGE2_REPLACE.
     * Their usage should be quite clear from their names.</p>
     *
     * @param mixed $content  New <body> tag content (may be passed as a
     *                        reference)
     * @param int   $flag     Determines whether to prepend, append or replace
     *                        the content. Use pre-defined constants.
     */
    public function addBodyContent($content, $flag = HTML_PAGE2_APPEND)
    {

        if ($flag == HTML_PAGE2_REPLACE) {       // replaces any content in body
            $this->unsetBody();
            $this->_body[] =& $content;
        } elseif ($flag == HTML_PAGE2_PREPEND) { // prepends content to the body
            array_unshift($this->_body, $content);
        } else {                                // appends content to the body
            $this->_body[] =& $content;
        }

    } // end addBodyContent

    /**
     * Adds a linked script to the page
     *
     * @param    string  $url        URL to the linked script
     * @param    string  $type       Type of script. Defaults to 'text/javascript'
     */
    public function addScript($url, $type="text/javascript")
    {
        $this->_scripts[$url] = $type;
    } // end func addScript

    /**
     * Adds a script to the page
     *
     * <p>Content can be a string or an object with a toString method.
     * Defaults to text/javascript.</p>
     *
     * @param    mixed   $content   Script (may be passed as a reference)
     * @param    string  $type      Scripting mime (defaults to 'text/javascript')
     * @return   void
     */
    public function addScriptDeclaration($content, $type = 'text/javascript')
    {
        $this->_script[][strtolower($type)] =& $content;
    } // end func addScriptDeclaration

    /**
     * Adds a linked stylesheet to the page
     *
     * @param    string  $url    URL to the linked style sheet
     * @param    string  $type   Mime encoding type
     * @param    string  $media  Media type that this stylesheet applies to
     * @return   void
     */
    public function addStyleSheet($url, $type = 'text/css', $media = null)
    {
        $this->_styleSheets[$url]['mime']  = $type;
        $this->_styleSheets[$url]['media'] = $media;
    } // end func addStyleSheet

    /**
     * Adds a stylesheet declaration to the page
     *
     * <p>Content can be a string or an object with a toString method.
     * Defaults to text/css.</p>
     *
     * @param    mixed   $content   Style declarations (may be passed as a reference)
     * @param    string  $type      Type of stylesheet (defaults to 'text/css')
     * @return   void
     */
    public function addStyleDeclaration($content, $type = 'text/css')
    {
        $this->_style[][strtolower($type)] =& $content;
    } // end func addStyleDeclaration

    /**
     * Adds a shortcut icon (favicon)
     *
     * <p>This adds a link to the icon shown in the favorites list or on
     * the left of the url in the address bar. Some browsers display
     * it on the tab, as well.</p>
     *
     * @param     string  $href        The link that is being related.
     * @param     string  $type        File type
     * @param     string  $relation    Relation of link
     * @return    void
     */
    public function addFavicon($href, $type = 'image/x-icon', $relation = 'shortcut icon') {
        $this->_links[] = "<link href=\"$href\" rel=\"$relation\" type=\"$type\"";
    } // end func addFavicon

    /**
     * Adds <link> tags to the head of the document
     *
     * <p>$relType defaults to 'rel' as it is the most common relation type used.
     * ('rev' refers to reverse relation, 'rel' indicates normal, forward relation.)
     * Typical tag: <link href="index.php" rel="Start"></p>
     *
     * @param    string  $href       The link that is being related.
     * @param    string  $relation   Relation of link.
     * @param    string  $relType    Relation type attribute.  Either rel or rev (default: 'rel').
     * @param    array   $attributes Associative array of remaining attributes.
     * @return   void
     */
    public function addHeadLink($href, $relation, $relType = 'rel', $attributes = array()) {
        $attributes = $this->_parseAttributes($attributes);
        $generatedTag = $this->_getAttrString($attributes);
        $generatedTag = "<link href=\"$href\" $relType=\"$relation\"" . $generatedTag;
        $this->_links[] = $generatedTag;
    } // end func addHeadLink

    /**
     * Returns the current API version
     *
     * @return   double
     */
    public function apiVersion()
    {
        return 2.0;
    } // end func apiVersion

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
     *     "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
     * @return  void
     */
    public function disableXmlProlog()
    {
        $this->_xmlProlog = false;
    } // end func disableXmlProlog

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
     * @return   void
     */
    public function enableXmlProlog()
    {
        $this->_xmlProlog = true;
    } // end func enableXmlProlog

    /**
     * Returns the document charset encoding.
     *
     * @return string
     */
    public function getCharset()
    {
        return $this->_charset;
    } // end setCache

    /**
     * Returns the document type string
     *
     * @return string
     */
    public function getDoctypeString()
    {
        $strDoctype = strtoupper($this->_doctype['type']);
        $strDoctype .= ' '.ucfirst(strtolower($this->_doctype['version']));
        if ($this->_doctype['variant']) {
            $strDoctype .= ' ' . ucfirst(strtolower($this->_doctype['variant']));
        }
        return trim($strDoctype);
    } // end func getDoctypeString

    /**
     * Returns the document language.
     *
     * @return string
     */
    public function getLang()
    {
        return $this->_language;
    } // end func getLang

    /**
     * Return the title of the page.
     *
     * @return   string
     */
    public function getTitle()
    {
        if (!$this->_title){
            if ($this->_simple) {
                return 'New Page';
            } else {
                return 'New '. $this->getDoctypeString() . ' Compliant Page';
            }
        } else {
            return $this->_title;
        }
    } // end func getTitle

    /**
     * Prepends content to the content of the <body> tag. Wrapper for {@link addBodyContent}
     *
     * <p>If you wish to overwrite whatever is in the body, use {@link setBody};
     * {@link addBodyContent} provides full functionality including appending;
     * {@link unsetBody} completely empties the body without inserting new content.
     * It is possible to add objects, strings or an array of strings and/or objects
     * Objects must have a toString method.</p>
     *
     * @param mixed $content  New <body> tag content (may be passed as a reference)
     */
    public function prependBodyContent($content)
    {
        $this->addBodyContent($content, HTML_PAGE2_PREPEND);
    } // end func prependBodyContent

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
     * @param mixed    $content   New <body> tag content. May be an object.
     *                            (may be passed as a reference)
     */
    public function setBody($content)
    {
        $this->addBodyContent($content, HTML_PAGE2_REPLACE);
    } // end setBody

    /**
     * Unsets the content of the <body> tag.
     *
     */
    public function unsetBody()
    {
        $this->_body = array();
    } // end unsetBody

    /**
     * Sets the attributes of the <body> tag
     *
     * <p>If attributes exist, they are overwritten. In XHTML, all attribute
     * names must be lowercase. As lowercase attributes are legal in SGML, all
     * attributes are automatically lowercased. This also prevents accidentally
     * creating duplicate attributes when attempting to update one.</p>
     *
     * @param  array   $attributes   <body> tag attributes.
     */
    public function setBodyAttributes($attributes)
    {
        $this->setAttributes($attributes);
    } // end setBodyAttributes

    /**
     * Defines if the document should be cached by the browser
     *
     * <p>Defaults to false.</p>
     *
     * <p>A fully configurable cache header is in the works. for now, though
     * if you would like to determine exactly what caching headers are sent to
     * to the browser, set cache to true, and then output your own headers
     * before calling {@link display}.</p>
     *
     * @param  string   $cache  Options are currently 'true' or 'false'
     */
    public function setCache($cache = 'false')
    {
        if ($cache == 'true'){
            $this->_cache = true;
        } else {
            $this->_cache = false;
        }
    } // end setCache

    /**
     * Sets the document charset
     *
     * <p>By default, HTML_Page2 uses UTF-8 encoding. This is properly handled
     * by PHP, but remember to use the htmlentities attribute for charset so
     * that whatever you get from a database is properly handled by the
     * browser.</p>
     *
     * <p>The current most popular encoding: iso-8859-1. If it is used,
     * htmlentities and htmlspecialchars can be used without any special
     * settings.</p>
     *
     * @param   string   $type  Charset encoding string
     * @return  void
     */
    public function setCharset($type = 'utf-8')
    {
        $this->_charset = $type;
    } // end setCache

    /**
     * Sets or alters the !DOCTYPE declaration.
     *
     * <p>Can be set to "strict", "transitional" or "frameset".
     * Defaults to "XHTML 1.0 Transitional".</p>
     *
     * <p>This must come <i>after</i> declaring the character encoding with
     * {@link setCharset} or directly when the class is initiated
     * {@link HTML_Page2}. Use in conjunction with {@link setMimeEncoding}</p>
     *
     * <p>Framesets are not yet implemented.</p>
     *
     * @param   string   $type  String containing a document type
     * @return  void
     */
    public function setDoctype($type = "XHTML 1.0 Transitional")
    {
        $this->_doctype = $this->_parseDoctypeString($type);
        if($this->_doctype['variant'] == 'frameset') {

            $options = array('master' => true);
            if ($this->_doctype['type'] == 'xhtml') {
                $options['xhtml'] = true;
            }

            // make sure we have the frameset class loaded
            require_once 'HTML/Page2/Frameset.php';
            $this->frameset = new HTML_Page2_Frameset($options);
        }
    } // end func setDoctype

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
     * @param    string    $profile   URL to profile
     * @return   void
     */
    public function setHeadProfile($profile = '')
    {
        $this->_profile = $profile;
    } // end func setHeadProfile

    /**
     * Sets the global document language declaration. Default is English.
     *
     * @param   string   $lang    Two-letter language designation
     */
    public function setLang($lang = "en")
    {
        $this->_language = strtolower($lang);
    } // end setLang

    /**
     * Sets or alters a meta tag.
     *
     * @param string  $name           Value of name or http-equiv tag
     * @param string  $content        Value of the content tag
     * @param bool    $http_equiv     META type "http-equiv" defaults to null
     * @return void
     */
    public function setMetaData($name, $content, $http_equiv = false)
    {
        if ($content == '') {
            $this->unsetMetaData($name, $http_equiv);
        } else {
            if ($http_equiv == true) {
                $this->_metaTags['http-equiv'][$name] = $content;
            } else {
                $this->_metaTags['standard'][$name] = $content;
            }
        }
    } // end func setMetaData

    /**
     * Unsets a meta tag.
     *
     * @param string  $name           Value of name or http-equiv tag
     * @param bool    $http_equiv     META type "http-equiv" defaults to null
     * @return void
     */
    public function unsetMetaData($name, $http_equiv = false)
    {
        if ($http_equiv == true) {
            unset($this->_metaTags['http-equiv'][$name]);
        } else {
            unset($this->_metaTags['standard'][$name]);
        }
    } // end func unsetMetaData

    /**
     * Sets an http-equiv Content-Type meta tag
     *
     * @return   void
     */
    public function setMetaContentType()
    {
        $this->setMetaData('Content-Type', $this->_mime . '; charset=' . $this->_charset , true );
    } // end func setMetaContentType

    /**
     * Shortcut to set or alter a refresh meta tag
     *
     * <p>If no $url is passed, "self" is presupposed, and the appropriate URL
     * will be automatically generated. In this case, an optional third
     * boolean parameter enables https redirects to self.</p>
     *
     * @param int     $time    Time till refresh (in seconds)
     * @param string  $url     Absolute URL or "self"
     * @param bool    $https   If $url == self, this allows for the https
     *                         protocol defaults to null
     * @return void
     */
    public function setMetaRefresh($time, $url = 'self', $https = false)
    {
        if ($url == 'self') {
            if ($https) {
                $protocol = 'https://';
            } else {
                $protocol = 'http://';
            }
            $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        }
        $this->setMetaData("Refresh", "$time; url=$url", true);
    } // end func setMetaRefresh

    /**
     * Sets the document MIME encoding that is sent to the browser.
     *
     * <p>This usually will be text/html because most browsers cannot yet
     * accept the proper mime settings for XHTML: application/xhtml+xml
     * and to a lesser extent application/xml and text/xml. See the W3C note
     * ({@link http://www.w3.org/TR/xhtml-media-types/
     * http://www.w3.org/TR/xhtml-media-types/}) for more details.</p>
     *
     * <p>Here is a possible way of automatically including the proper mime
     * type for XHTML 1.0 if the requesting browser supports it:</p>
     *
     * <code>
     * <?php
     * // Initialize the HTML_Page2 object:
     * require 'HTML/Page2.php';
     * $page = new HTML_Page2();
     *
     * // Check if browse can take the proper mime type
     * if ( strpos($_SERVER['HTTP_ACCEPT'], 'application/xhtml+xml') ) {
     *     $page->setDoctype('XHTML 1.0 Strict');
     *     $page->setMimeEncoding('application/xhtml+xml');
     * } else {
     *     // HTML that qualifies for XHTML 1.0 Strict automatically
     *     // also complies with XHTML 1.0 Transitional, so if the
     *     // requesting browser doesn't take the necessary mime type
     *     // for XHTML 1.0 Strict, let's give it what it can take.
     *     $page->setDoctype('XHTML 1.0 Transitional');
     * }
     *
     * // finish building your page here..
     *
     * $page->display();
     * ?>
     * </code>
     *
     * @param    string    $type
     * @return   void
     */
    public function setMimeEncoding($type = 'text/html')
    {
        $this->_mime = strtolower($type);
    } // end func setMimeEncoding

    /**
     * Sets the document namespace
     *
     * <p>By default, W3C namespaces are used. However, if you need to define
     * your own namespace, you can set it here.</p>
     *
     * <p>Usage:<p>
     *
     * <code>
     * // This is how you can set your own namespace:
     * $page->setNamespace('http://www.w3.org/1999/xhtml');
     *
     * // This reverts to default setting and retrieves the appropriate
     * // W3C namespace for the document type:
     * $page->setNamespace();
     * </code>
     *
     * @param    string    $namespace  Optional. W3C namespaces are used by default.
     * @return   void
     */
    public function setNamespace($namespace = '')
    {
        if (isset($namespace)){
            $this->_namespace = $namespace;
        } else {
            $this->_namespace = $this->_getNamespace();
        }
    } // end func setTitle

    /**
     * Sets the title of the page
     *
     * <p>Usage:</p>
     *
     * <code>
     * $page->setTitle('My Page');
     * </code>
     *
     * @param    string    $title
     * @return   void
     */
    public function setTitle($title)
    {
        $this->_title = $title;
    } // end func setTitle

    /**
     * Generates and returns the complete page as a string
     *
     * <p>This is what you would call if you want to save the page in a
     * database. It creates a complete, valid HTML document, and returns
     * it as a string.</p>
     *
     * <p>Usage example:</p>
     * <code>
     * <?php
     * require "HTML/Page2.php";
     * $page = new HTML_Page2();
     * $page->setTitle('My Page');
     * $page->addBodyContent('<h1>My Page</h1>');
     * $page->addBodyContent('<p>First Paragraph.</p>');
     * $page->addBodyContent('<p>Second Paragraph.</p>');
     * $html = $page->toHtml();
     * // here you insert HTML into a database
     * ?>
     * </code>
     *
     * @return string
     */
    public function toHtml()
    {

        // get line endings
        $lnEnd = $this->_getLineEnd();

        // get the doctype declaration
        $strDoctype = $this->_getDoctype();

        // This determines how the doctype is declared and enables various
        // features depending on whether the the document is XHTML, HTML or
        // if no doctype declaration is desired
        if ($this->_simple) {

            $strHtml = '<html>' . $lnEnd;

        } elseif ($this->_doctype['type'] == 'xhtml') {

            // get the namespace if not already set
            if (!$this->_namespace){
                $this->_namespace = $this->_getNamespace();
            }

            $strHtml = $strDoctype . $lnEnd;
            $strHtml .= '<html xmlns="' . $this->_namespace . '" xml:lang="' . $this->_language . '"';

            // If a special profile is defined, make sure it is included
            // in the opening html tag. Normally this will not be the case.
            if ($this->_profile) {
                $strHtml .= ' profile="'.$this->_profile.'"';
            }
            $strHtml .= '>' . $lnEnd;

            // check whether the XML prolog should be prepended
            if ($this->_xmlProlog){
                $strHtml  = '<?xml version="1.0" encoding="' . $this->_charset . '"?>' . $lnEnd . $strHtml;
            }

        } else {

            $strHtml  = $strDoctype . $lnEnd;
            $strHtml .= '<html';

            // If a special profile is defined, make sure it is included
            // in the opening html tag. Normally this will not be the case.
            if ($this->_profile) {
                $strHtml .= ' profile="'.$this->_profile.'"';
            }

            $strHtml .= '>' . $lnEnd;

        }

        // indent all nodes of <html> one place
        $this->_tabOffset++;

        $strHtml .= $this->_generateHead();

        if (isset($this->_doctype['variant']) && $this->_doctype['variant'] == 'frameset') {

            // pass on settings to the frameset
            $this->frameset->setTab($this->_getTab());
            $this->frameset->setTabOffset($this->getTabOffset());
            $this->frameset->setLineEnd($lnEnd);

            $strHtml .= $this->frameset->toHtml();
            $strHtml .= $this->_generateBody();
            $strHtml .= $this->_getTabs() . '</frameset>' . $lnEnd;

        } else {

            $strHtml .= $this->_generateBody();

        }

        // In case something else is going to be done with this object,
        // let's set the offset back to normal.
        $this->_tabOffset--;

        $strHtml .= '</html>';
        return $strHtml;
    } // end func toHtml

    /**
     * Generates the document and outputs it to a file.
     *
     * <p>Uses {@link file_put_contents} when available. Includes a workaround
     * for older versions of PHP.</p>
     *
     * <p>Usage example:</p>
     * <code>
     * <?php
     * require "HTML/Page2.php";
     * $page = new HTML_Page2();
     * $page->setTitle('My Page');
     * $page->addBodyContent('<h1>My Page</h1>');
     * $page->addBodyContent('<p>First Paragraph.</p>');
     * $page->addBodyContent('<p>Second Paragraph.</p>');
     * $page->toFile('myPage.html');
     * ?>
     * </code>
     *
     * @return  void
     * @since   2.0
     */
    public function toFile($filename)
    {
        if (function_exists('file_put_contents')) {
            file_put_contents($filename, $this->toHtml());
        } else {
            $file = fopen($filename,'wb');
            fwrite($file, $this->toHtml());
            fclose($file);
        }

        if (!file_exists($filename)){
            PEAR::raiseError("HTML_Page::toFile() error: Failed to write to $filename", 0, PEAR_ERROR_TRIGGER);
        }

    } // end func toFile

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
     * @return   void
     */
    public function display()
    {

        // If caching is to be implemented, this bit of code will need to be
        // replaced with a private function. Else it may be possible to
        // borrow from Cache or Cache_Lite.
        if(!$this->_cache) {
            header("Expires: Tue, 1 Jan 1980 12:00:00 GMT");
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-cache");
            header("Pragma: no-cache");
        }

        // Set mime type and character encoding
        header('Content-Type: ' . $this->_mime .  '; charset=' . $this->_charset);

        // Generate HTML document
        $strHtml = $this->toHTML();

        // Output to browser, screen or other default device
        print $strHtml;

    } // end func display

}