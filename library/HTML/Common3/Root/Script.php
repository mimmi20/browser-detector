<?php
declare(ENCODING = 'utf-8');
namespace HTML\Common3\Root;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * HTMLCommon\Root\Script: Class for HTML <script> Elements
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

//Error codes

/**
 * No script started error
 */
define('HTML_Common3_Root_SCRIPT_ERROR_NOSTART', 500, true);

/**
 * Unknown error
 */
define('HTML_Common3_Root_SCRIPT_ERROR_UNKNOWN', 599, true);

/**
 * Last script was not ended error
 */
define('HTML_Common3_Root_SCRIPT_ERROR_NOEND', 501, true);

/**
 * No file was specified for setOutputMode()
 */
define('HTML_Common3_Root_SCRIPT_ERROR_NOFILE', 505, true);

/**
 * Cannot open file in write mode
 */
define('HTML_Common3_Root_SCRIPT_ERROR_WRITEFILE', 506, true);

//Output modes
/**
 * Just return the results (default mode)
 */
define('HTML_Common3_Root_SCRIPT_OUTPUT_RETURN', 1);

/**
 * Echo (print) the results directly to browser
 */
define('HTML_Common3_Root_SCRIPT_OUTPUT_ECHO', 2);

/**
 * Print the results to a file
 */
define('HTML_Common3_Root_SCRIPT_OUTPUT_FILE', 3);

// {{{ HTMLCommon\Root\Script

/**
 * Class for HTML <script> Elements
 *
 * @category HTML
 * @package  HTMLCommon\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/HTMLCommon\
 */
class Script extends HTMLCommon implements ElementsInterface
{
    // {{{ properties

    /**
     * HTML Tag of the Element
     *
     * @var      string
     */
    protected $_elementName = 'script';

    /**
     * Associative array of attributes
     *
     * @var      array
     */
    protected $_attributes = array(
        'type' => 'text/javascript'
    );

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
    protected $_watchedAttributes = array('type');

    /**
     * Indicator to tell, if the Object is an empty HTML Element
     *
     * @var      boolean
     */
    protected $_elementEmpty = false;

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
            'charset',
            'defer',
            'src',
            'type'
        ),
        'html' => array(
            '4.01' => array(
                'frameset' => array(
                    'language'
                ),
                'transitional' => array(
                    'language'
                )
            ),
            '5.0' => array(
                '#all' => array(
                    'async'
                )
            )
        ),
        'xhtml' => array(
            '1.0' => array(                '#all' => array(                    'xml:space'                ),
                'frameset' => array(
                    'language'
                ),
                'transitional' => array(
                    'language'
                )
            )
        )
    );

    /**
     * Used to determaine if a script has been started
     *
     * @var      boolean    $started
     * @deprecated just for compatibility with HTML_JAVASCRIPT
     */
    protected $_started = false;

    /**
     * The output mode specified for the script
     *
     * @var      integer    $mode
     */
    protected $_mode = HTML_Common3_Root_SCRIPT_OUTPUT_RETURN;

    /**
     * The file to direct the output to
     *
     * @var      string    $file
     */
    protected $_file = '';

    /**
     * value for text elements
     *
     * @var      string
     */
    protected $_value = array();

    /**
     * SVN Version for this class
     *
     * @var     string
     */
    const VERSION = '$Id$';

    // }}} properties
    // {{{ initAttributes

    /**
     * set the default attributes
     *
     * @return HTMLCommon\Root\Script
     */
    protected function initAttributes()
    {
        //set the default attributes
        $this->_attributes = array(
            'type' => 'text/javascript',
            'xml:space' => 'preserve'
        );

        return $this;
    }

    // }}} initAttributes
    // {{{ setValue

    /**
     * sets the value for the Element
     *
     * @param string  $value the value for the element
     * @param integer $flag  Determines whether to prepend, append or replace
     *                       the content. Use pre-defined constants.
     *
     * @return HTMLCommon\
     * @throws HTMLCommon\InvalidArgumentException
     *
     * NOTE: this function has no relation to the Attribute "value"
     */
    public function setValue($value, $flag = HTMLCommon::REPLACE)
    {
        $value = (string) $value;

        if (!($this->_elementEmpty)) {
            $lineEnd = $this->getOption('linebreak');
            $tab     = $this->getTab();

            $v = explode($lineEnd, $value);

            foreach ($v as $t) {
                $t = str_replace($tab, '    ', $t);
                $this->addLine($t);
            }

            return true;
        } else {
            return false;
        }
    }

    // }}} setValue
    // {{{ write

    /**
     * Returns the Element structure as HTML, works recursive
     * Instead of calling the writeInner function, this function wants to have
     * the inner HTML-code as a parameter
     *
     * @param string  $elementName the type name of the element
     * @param string  $innerHTML   the text inside the Element
     * @param int     $step        the level in which should startet the output,
     *                             the internal level is updated
     * @param boolean $dump        if TRUE an dump of the class is created
     * @param boolean $comments    if TRUE comments were added to the output
     * @param boolean $levels      if TRUE the levels are added,
     *                             if FALSE the levels will be ignored
     *
     * @return string
     * @see    toHtml()
     */
    protected function write($elementName, $innerHTML, $step = null,
                             $dump = false, $comments = false, $levels = true)
    {
        if ($this->_disabled) {
            return '';
        }

        $mode = $this->getOutputMode();
        $file = $this->_file;

        if ($mode == HTML_Common3_Root_SCRIPT_OUTPUT_FILE) {
            $this->toFile($file);
            $this->setAttribute('src', $file);
            $innerHTML = '';
            $this->_elements = array();
        } elseif (isset($this->_attributes['src'])) {
            $innerHTML = '';
            $this->_elements = array();
        }

        $txt = parent::write($elementName, $innerHTML, $step, $dump, $comments,
                             $levels);

        switch($mode) {
        case HTML_Common3_Root_SCRIPT_OUTPUT_RETURN:
        case HTML_Common3_Root_SCRIPT_OUTPUT_FILE:
            return $txt;
            break;

        case HTML_Common3_Root_SCRIPT_OUTPUT_ECHO:
            echo $txt;
            return '';
            break;

        default:
            throw new HTMLCommon\InvalidArgumentException(
                'Invalid output mode'
            );
            break;
        }
    }

    // }}} write
    // {{{ toFile

    /**
     * Generates the Script document and outputs it to a file.
     *
     * <p>Uses {@link file_put_content} when available. Includes a workaround
     * for older versions of PHP.</p>
     *
     * @param string $filename the name of the file, the content should be
     *                         written
     *
     * @return void
     * @throw  HTMLCommon\FileNotExistException
     */
    public function toFile($filename)
    {
        $filename = (string) $filename;

        if ($filename == '') {
            throw new HTMLCommon\InvalidArgumentException(
                'HTMLCommon\Root\Script::toFile() error: File name is missing'
            );
        }

        $this->setOutputMode(HTML_Common3_Root_SCRIPT_OUTPUT_FILE, $filename);

        $innerTxt = $this->writeInner(false, true, false);

        if (function_exists('file_put_content')) {
            file_put_content($filename, $innerTxt);
        } else {
            $file = fopen($filename, 'wb');
            fwrite($file, $innerTxt);
            fclose($file);
        }

        if (!file_exists($filename)) {
            throw new HTMLCommon\FileNotExistException(
                'HTMLCommon\Root\Script::toFile() error: Failed to write to '
                . $filename
            );
        }

    }

    // }}} toFile
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
     */
    public function writeInner($dump = false, $comments = false, $levels = true)
    {
        $txt        = '';
        $src        = $this->getAttribute('src');
        $root       = $this->getRoot();
        $childcount = count($this->_elements);

        if ((
             ($src === null) || ($src == '')
            ) &&
            (
             ($childcount) || ($this->_value != '')
            )
           ) {
            //write only the inner content, if the src-attribute is not set
            if ($levels) {
                $begin_txt = $this->getIndent();
            } else {
                $begin_txt = '';
            }

            $lineEnd = $root->getOption('linebreak');
            $step2   = (int) $this->getIndentLevel() + 1;
            $mode    = $this->getOutputMode();
            $docType = $root->getDoctype(false);

            if ($mode == HTML_Common3_Root_SCRIPT_OUTPUT_FILE) {
                $disableCDataMark = true;
            } else {
                $disableCDataMark = false;
                $parents          = $this->getParentTree();

                foreach ($parents as $object) {

                    if ($object->getElementName() == 'if') {
                        $disableCDataMark = true;
                        break;
                    }
                }
            }

            if (count($this->_elements) == 0) {
                $txt .= $lineEnd;
            }

            if (!$disableCDataMark) {
                if ($levels) {
                    $txt .= $begin_txt;
                }

                if ($docType['type'] == 'xhtml' ) {
                    $txt .= '/* <![CDATA[ */';
                } else {
                    $txt .= '<!--';
                }

                $txt .= $lineEnd;
            }

            if ($dump) {
                $txt .= $begin_txt . '//output - start' . $lineEnd;
            }

            $txt .= parent::writeInner($dump, $comments, $levels);

            if ($dump) {
                $txt .= $begin_txt . '//output - end';
            }

            if (!$disableCDataMark) {
                if ($dump) {
                    $txt .= $lineEnd;
                }

                if ($levels) {
                    $txt .= $begin_txt;
                }

                if ($docType['type'] == 'xhtml' ) {
                    $txt .= '/* ]]> */';
                } else {
                    $txt .= '//-->';
                }

                if ($mode != HTML_Common3_Root_SCRIPT_OUTPUT_FILE) {
                    $txt .= $lineEnd;
                }
            }

            if ($levels && count($this->_elements) == 0 &&
                $mode != HTML_Common3_Root_SCRIPT_OUTPUT_FILE) {

                $txt .= $begin_txt;
            }
        }

        return $txt;
    }

    // }}} writeInner
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

        if ($name != '') {
            if ($name == 'type') {
                if ($value === null || (string) $value == '') {
                    //new value is empty
                    //-> set the default value
                    $value = 'text/javascript';
                }
            }

            $this->_attributes[$name] = (string) $value;
        }
    }

    // }}} onAttributeChange
    // {{{ addLine

    /**
     * adds a new Code line to the Javascript Box
     *
     * @param string $str the string to output
     *
     * @return void
     */
    public function addLine($str)
    {
        $zero = new HTMLCommon\Root\Zero();        $zero->setValue((string) $str, HTMLCommon::REPLACE, false);        $this->_elements[] = $zero;
    }

    // }}} addLine
    // {{{ setOutputMode

    /**
     * Set the output mode for the script
     *
     * @param integer $mode the chosen output mode, can be either
     *                      {@link HTML_Common3_Root_SCRIPT_OUTPUT_RETURN},
     *                      {@link HTML_Common3_Root_SCRIPT_OUTPUT_ECHO}  or
     *                      {@link HTML_Common3_Root_SCRIPT_OUTPUT_FILE}
     * @param string  $file the path to the file
     *                      (if $mode is
     *                      {@link HTML_Common3_Root_SCRIPT_OUTPUT_FILE})
     *
     * @see    getOutputMode
     * @return mixed PEAR_Error or true
     */
    public function setOutputMode($mode = HTML_Common3_Root_SCRIPT_OUTPUT_RETURN,
                                  $file = null)
    {
        if ($mode == HTML_Common3_Root_SCRIPT_OUTPUT_FILE) {
            if (isset($file)) {
                $this->_file = (string) $file;
            } else {
                throw new HTMLCommon\InvalidArgumentException(
                    'HTMLCommon\Root\Script::setOutputMode() error: ' .
                    'A filename must be specified for setoutputMode()'
                );
            }
        }

        $this->mode = (int) $mode;
        return true;
    }

    // }}} setOutputMode
    // {{{ getOutputMode

    /**
     * Get the output mode for the script
     *
     * @see       setOutputMode
     * @return mixed PEAR_Error or true
     */
    public function getOutputMode()
    {
        return $this->_mode;
    }

    // }}} getOutputMode
    // {{{ startScript

    /**
     * Starts a new script
     *
     * @param boolean $defer whether to wait for the whole page to load
     *                       before starting the script or no. Use defer only
     *                       with script that does not change the document
     *                       (i.e.alert does not change it).
     *
     * @return void
     * @deprecated just for compatibility with HTML_JAVASCRIPT
     */
    public function startScript($defer = true)
    {
        if ($defer) {
            $this->setAttribute('defer', 'defer');
        } else {
            $this->setAttribute('defer', null);
        }
    }

    // }}} startScript
    // {{{ endScript

    /**
     * Used to end the script (</script>)
     *
     * @return mixed PEAR_Error if no script has been started
     *               or the end tag for the script
     * @return void
     * @deprecated just for compatibility with HTML_JAVASCRIPT
     */
    public function endScript()
    {
    }

    // }}} endScript
    // {{{ getVar

    /**
     * formats the input var
     *
     * @param string  $str the string to output
     * @param boolean $var set to true if $str is a variable name
     *
     * @return string
     */
    protected function getVar($str, $var = false)
    {
        if (!$var) {
            $str = '"' . $this->escapeString((string) $str) . '"';
        }

        return $str;
    }

    // }}} getVar
    // {{{ getVarInt

    /**
     * formats the input var
     *
     * @param string  $str the string to output
     * @param boolean $var set to true if $str is a variable name
     *
     * @return string|integer
     */
    protected function getVarInt($str, $var = false)
    {
        if (!$var) {
            $str = '"' . (int) $str . '"';
        }

        return $str;
    }

    // }}} getVarInt
    // {{{ JSwrite

    /**
     * A wrapper for document.write
     *
     * @param string  $str the string to output
     * @param boolean $var set to true if $str is a variable name
     *
     * @return void
     */
    public function JSwrite($str, $var = false)
    {
        unset($this->_attributes['defer']);
        $str = $this->getVar($str, $var);

        $this->addLine('document.write(' . $str . ');');
    }

    // }}} JSwrite
    // {{{ JSwriteln

    /**
     * A wrapper for document.writeln
     *
     * @param string  $str the string to output
     * @param boolean $var set to true if $str is a variable name
     *
     * @return void
     */
    public function JSwriteln($str, $var = false)
    {
        unset($this->_attributes['defer']);
        $str = $this->getVar($str, $var);

        $this->addLine('document.writeln(' . $str . ')');
    }

    // }}} JSwriteln
    // {{{ JSwriteLine

    /**
     * A wrapper for document.writeln with an addtional <br /> tag
     *
     * @param string  $str the string to output
     * @param boolean $var set to true if $str is a variable name
     *
     * @return HTMLCommon\Root\Zero
     */
    public function JSwriteLine($str, $var = false)
    {
        unset($this->_attributes['defer']);
        $str = $this->getVar($str, $var);

        return $this->addLine('document.writeln(' . $str . '+"<br />")');
    }

    // }}} JSwriteLine
    // {{{ alert

    /**
     * A wrapper for alert
     *
     * @param string  $str the string to output
     * @param boolean $var set to true if $str is a variable name
     *
     * @return HTMLCommon\Root\Zero
     */
    public function alert($str, $var = false)
    {
        $str = $this->getVar($str, $var);

        return $this->addLine('alert(' . $str . ');');
    }

    // {{{ alert
    // {{{ confirm

    /**
     * Create a box with yes and no buttons.
     * In futur releases, the 1st arg will change, $str will always be the 1st
     * argument, $assign the 2nd.
     *
     * @param string  $str    the string that will appear in the confirmation
     *                        box
     * @param string  $assign the JS variable to assign the confirmation box to
     * @param boolean $var    whether $str is a JS var or not
     * @param boolean $global if true, the JS var will be global
     *
     * @return HTMLCommon\Root\Zero
     */
    public function confirm($str, $assign, $var = false, $global = true)
    {
        $str = $this->getVar($str, $var);

        $assign    = (string) $assign;
        if ($assign != '') {
            $assign .= ' = ';

            if ($global) {
                $assign = 'var ' . $assign;
            }
        }

        return $this->addLine($assign . 'confirm(' . $str . ');');
    }

    // }}} confirm
    // {{{ prompt

    /**
     * Open a prompt (input box)
     *
     * @param string  $str     the string that will appear in the prompt
     * @param string  $assign  the JS var that the input will be assigned to
     * @param string  $default the default value
     * @param boolean $var     wether $str is a JS var or not
     * @param boolean $global  if true, the JS var will be global
     *
     * @return HTMLCommon\Root\Zero
     */
    public function prompt($str, $assign, $default = '', $var = false,
                           $global = true)
    {
        $str = $this->getVar($str, $var);

        $assign    = (string) $assign;
        if ($assign != '') {
            $assign .= ' = ';

            if ($global) {
                $assign = 'var ' . $assign;
            }
        }

        return $this->addLine($assign .
                              'prompt('.(string) $str.', "'.$default.'");');
    }

    // }}} prompt
    // {{{ popup

    /**
     * A method for easy generation of popup windows
     *
     * @param string  $assign the JS var to assign the window to
     * @param string  $file   the file that will appear in the new window
     * @param string  $title  the title of the new window
     * @param integer $width  the width of the window
     * @param integer $height the height of the window
     * @param mixed   $attr   an array containing the attributes for the new
     *                        window, each cell can contain either the ints 1/0
     *                        or the strings 'yes'/'no'.
     *                        The order of attributes:
     *                        resizable, scrollbars, menubar, toolbar,
     *                        status, location.
     *                        Can be also a boolean, and then all the
     *                        attributes are set to yes or no, according to
     *                          the boolean value.
     * @param integer $top    the distance from the top, in pixels
     *                          (only used if attr=false|true).
     * @param integer $left   the distance from the left, in pixels
     *                          (only used if attr=false|true).
     * @param boolean $global if true, the JS var will be global
     * @param boolean $var    wether the parameters are JS vars or not
     *
     * @return mixed HTMLCommon\Root\Zero or PEAR_Error
     */
    public function popup(
        $assign, $file, $title, $width = 800, $height = 600, $attr = true,
        $top = 300, $left = 300, $global = true, $var = false
    )
    {
        $file    = (string)    $file;
        if ($file == '') {
            throw new HTMLCommon\InvalidArgumentException(
                'File needed for Function HTMLCommon\Root\Script::popup'
            );
        }

        $file   = $this->getVar($file, $var);
        $title  = $this->getVar($title, $var);
        $width  = $this->getVarInt($width, $var);
        $height = $this->getVarInt($height, $var);
        $top    = $this->getVarInt($top, $var);
        $left   = $this->getVarInt($left, $var);

        if (!is_array($attr)) {
            if (!is_bool($attr)) {
                throw new HTMLCommon\InvalidArgumentException(
                    'Parameter $attr should be either an array or a boolean in '
                  . 'Function HTMLCommon\Root\Script::popup'
                );
            } else {
                if ($attr === true) {
                    $attr = array('yes','yes','yes','yes','yes','yes',$top,
                                  $left);
                } else {
                    $attr = array('no', 'no', 'no', 'no', 'no', 'no', $top,
                                  $left);
                }
            }
        }

        $assign    = (string) $assign;
        if ($assign != '') {
            $assign .= ' = ';

            if ($global) {
                $assign = 'var ' . $assign;
            }
        }

        $message    = $assign . 'window.open('.
            $file . ', ' . $title . ',' .
            ' "width="+' . $width . '+", height="+' . $height . '+"' .
            ((isset($attr[0])) ? ', resizable='     . $attr[0] : '') .
            ((isset($attr[1])) ? ', scrollbars='    . $attr[1] : '') .
            ((isset($attr[2])) ? ', menubar='       . $attr[2] : '') .
            ((isset($attr[3])) ? ', toolbar='       . $attr[3] : '') .
            ((isset($attr[4])) ? ', status='        . $attr[4] : '') .
            ((isset($attr[5])) ? ', location='      . $attr[5] : '') .
            ((isset($attr[6])) ? ', top="+'         . $attr[6] . '+"' : '') .
            ((isset($attr[7])) ? ', left="+'        . $attr[7] . '+"' : '') .
            '");';
        return $this->addLine($message);
    }

    // }}} popup
    // {{{ popupwrite

    /**
     * Creates a new popup window containing a string. Inside the popup windows
     * you can access the opener window with the opener var.
     *
     * @param string  $assign the JS variable to assign the window to
     * @param string  $str    the string that will appear in the new window
     *                        (HTML tags would be parsed by the browser,
     *                        of course)
     * @param string  $title  the title of the window
     * @param integer $width  the width of the window
     * @param integer $height the height of the window
     * @param mixed   $attr   see popup()
     * @param integer $top    distance from the top (in pixels
     * @param integer $left   distance from the left (in pixels)
     * @param boolean $global if true, the JS var will be global
     * @param boolean $var    wether the parameters are JS vars or not
     *
     * @see    popup()
     * @return PEAR_Error|null;
     */
    function popupwrite(
        $assign, $str, $title, $width = 800, $height = 600, $attr = true,
        $top = 300, $left = 300, $global = true, $var = false
    )
    {
        $assign    = (string) $assign;
        if ($assign != '') {
            $assign_str = $assign . ' = ';
        } else {
            throw new HTMLCommon\InvalidArgumentException(
                'Assign Parameter needed for Function ' .
                'HTMLCommon\Root\Script::popupwrite'
            );
        }

        if ($global) {
            $assign_str = 'var ' . $assign_str;
        }

        $str    = $this->getVar($str, $var);
        $title  = $this->getVar($title, $var);
        $width  = $this->getVarInt($width, $var);
        $height = $this->getVarInt($height, $var);
        $top    = $this->getVarInt($top, $var);
        $left   = $this->getVarInt($left, $var);

        if (!is_array($attr)) {
            if (!is_bool($attr)) {
                throw new HTMLCommon\InvalidArgumentException(
                    'Parameter $attr should be either an array or a boolean in '
                  . 'Function HTMLCommon\Root\Script::popupwrite'
                );
            } else {
                if ($attr === true) {
                    $attr = array('yes','yes','yes','yes','yes','yes',$top,
                                  $left);
                } else {
                    $attr = array('no', 'no', 'no', 'no', 'no', 'no', $top,
                                  $left);
                }
            }
        }

        $title    = (string) $title;

        $message    = $assign_str . 'window.open('.
            $title . ', ' . $title . ',' .
            ' "width="+' . $width . '+", height="+' . $height . '+"' .
            ((isset($attr[0])) ? ', resizable='     . $attr[0] : '') .
            ((isset($attr[1])) ? ', scrollbars='    . $attr[1] : '') .
            ((isset($attr[2])) ? ', menubar='       . $attr[2] : '') .
            ((isset($attr[3])) ? ', toolbar='       . $attr[3] : '') .
            ((isset($attr[4])) ? ', status='        . $attr[4] : '') .
            ((isset($attr[5])) ? ', location='      . $attr[5] : '') .
            ((isset($attr[6])) ? ', top="+'         . $attr[6] . '+"' : '') .
            ((isset($attr[7])) ? ', left="+'        . $attr[7] . '+"' : '') .
            '");';
        $this->addLine($message);

        $this->addLine('if (' . $assign . ') {');
        $this->addLine('    ' . $assign . '.focus();');
        $this->addLine('    ' . $assign . '.document.open();');
        $this->addLine('    ' . $assign . '.document.write(' . $str . ');');
        $this->addLine('    ' . $assign . '.document.close();');
        $this->addLine('    if ('.$assign.'.opener == null) ' .
                       $assign.'.opener = self;');
        $this->addLine('}');

        return null;
    }

    // }}} popupwrite
    // {{{ escapeString

    /**
     * Used to terminate escape characters in strings,
     * as javascript doesn't allow them
     *
     * @param string $str the string to be processed
     *
     * @return mixed the processed string
     * @source
     */
    public function escapeString($str)
    {
        $js_escape = array(
            "\r" => '\r',
            "\n" => "\n",
            "\t" => '\t',
            "'" => "\\'",
            '"' => '\"',
            '\\' => '\\\\',
            '</' => '<\/'
        );

        return strtr($str, $js_escape);
    }

    // }}} escapeString
}

// }}} HTMLCommon\Root\Script

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */