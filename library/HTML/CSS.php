<?php
/**
 * Copyright (c) 2003-2009, Klaus Guenther <klaus@capitalfocus.org>
 *                          Laurent Laville <pear@laurent-laville.org>
 *
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the authors nor the names of its contributors
 *       may be used to endorse or promote products derived from this software
 *       without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS
 * BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * PHP versions 4 and 5
 *
 * @category  HTML
 * @package   HTML_CSS
 * @author    Klaus Guenther <klaus@capitalfocus.org>
 * @author    Laurent Laville <pear@laurent-laville.org>
 * @copyright 2003-2009 Klaus Guenther, Laurent Laville
 * @license   http://www.opensource.org/licenses/bsd-license.php  New BSD License
 * @version   CVS: $Id: CSS.php,v 1.89 2009/07/03 15:52:22 farell Exp $
 * @link      http://pear.php.net/package/HTML_CSS
 * @since     File available since Release 0.2.0
 */

require_once 'HTML/Common.php';

/**#@+
 * Basic error codes
 *
 * @var        integer
 * @since      0.3.3
 */
define('HTML_CSS_ERROR_UNKNOWN', -1);
define('HTML_CSS_ERROR_INVALID_INPUT', -100);
define('HTML_CSS_ERROR_INVALID_GROUP', -101);
define('HTML_CSS_ERROR_NO_GROUP', -102);
define('HTML_CSS_ERROR_NO_ELEMENT', -103);
define('HTML_CSS_ERROR_NO_ELEMENT_PROPERTY', -104);
define('HTML_CSS_ERROR_NO_FILE', -105);
define('HTML_CSS_ERROR_WRITE_FILE', -106);
define('HTML_CSS_ERROR_INVALID_SOURCE', -107);
define('HTML_CSS_ERROR_INVALID_DEPS', -108);
define('HTML_CSS_ERROR_NO_ATRULE', -109);
/**#@-*/

/**
 * Base class for CSS definitions
 *
 * This class handles the details for creating properly
 * constructed CSS declarations.
 *
 * @category  HTML
 * @package   HTML_CSS
 * @author    Klaus Guenther <klaus@capitalfocus.org>
 * @author    Laurent Laville <pear@laurent-laville.org>
 * @copyright 2003-2009 Klaus Guenther, Laurent Laville
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD
 * @version   Release: 1.5.4
 * @link      http://pear.php.net/package/HTML_CSS
 * @since     Class available since Release 0.2.0
 */

class HTML_CSS extends HTML_Common
{
    /**
     * Options configuration list
     *
     * - xhtml :
     *    Defines whether element selectors should be automatically lowercased.
     *    Determines how parseSelectors treats the data.
     *    @see setXhtmlCompliance()
     * - tab :
     *    Sets indent string.
     *    @see setTab(), HTML_Common::setTab()
     * - filename :
     *    Name of file to be parsed.
     *    @see parseFile()
     * - cache :
     *    Determines whether the nocache headers are sent.
     *    Controls caching of the page.
     *    @see setCache()
     * - oneline :
     *    Defines whether to output all properties on one line.
     *    @see setSingleLineOutput()
     * - charset :
     *    Contains the character encoding string.
     *    @see setCharset()
     * - contentDisposition :
     *    Contains the Content-Disposition filename.
     *    @see setContentDisposition()
     * - lineEnd :
     *    Sets the line end style to Windows, Mac, Unix or a custom string.
     *    @see setLineEnd(), HTML_Common::setLineEnd()
     * - groupsfirst :
     *    Determines whether to output groups before elements.
     *    @see setOutputGroupsFirst()
     * - allowduplicates :
     *    Allow to have duplicate rules in selector. Useful for IE hack.
     *
     * @var        array
     * @since      1.4.0
     * @access     private
     * @see        __set(), __get()
     */
    var $options;

    /**
     * Contains the CSS definitions.
     *
     * @var        array
     * @since      0.2.0
     * @access     private
     */
    var $_css = array();

    /**
     * Contains "alibis" (other elements that share a definition) of an element
     * defined in CSS
     *
     * @var        array
     * @since      0.2.0
     * @access     private
     */
    var $_alibis = array();

    /**
     * Contains last assigned index for duplicate styles
     *
     * @var        array
     * @since      0.3.0
     * @access     private
     */
    var $_duplicateCounter = 0;

    /**
     * Contains grouped styles
     *
     * @var        array
     * @since      0.3.0
     * @access     private
     */
    var $_groups = array();

    /**
     * Number of CSS definition groups
     *
     * @var        int
     * @since      0.3.0
     * @access     private
     */
    var $_groupCount = 0;

    /**
     * Error message callback.
     * This will be used to generate the error message
     * from the error code.
     *
     * @var        false|string|array
     * @since      1.0.0
     * @access     private
     * @see        _initErrorStack()
     */
    var $_callback_message = false;

    /**
     * Error context callback.
     * This will be used to generate the error context for an error.
     *
     * @var        false|string|array
     * @since      1.0.0
     * @access     private
     * @see        _initErrorStack()
     */
    var $_callback_context = false;

    /**
     * Error push callback.
     * The return value will be used to determine whether to allow
     * an error to be pushed or logged.
     *
     * @var        false|string|array
     * @since      1.0.0
     * @access     private
     * @see        _initErrorStack()
     */
    var $_callback_push = false;

    /**
     * Error callback.
     * User function that decides what to do with error (display, log, ...)
     *
     * @var        false|string|array
     * @since      1.4.0
     * @access     private
     * @see        _initErrorStack()
     */
    var $_callback_error = false;

    /**
     * Error handler callback.
     * This will handle any errors raised by this package.
     *
     * @var        false|string|array
     * @since      1.0.0
     * @access     private
     * @see        _initErrorStack()
     */
    var $_callback_errorhandler = false;

    /**
     * Associative array of key-value pairs
     * that are used to specify any handler-specific settings.
     *
     * @var        array
     * @since      1.0.0
     * @access     private
     * @see        _initErrorStack()
     */
    var $_errorhandler_options = array();

    /**
     * Last error that might occured
     *
     * @var        false|mixed
     * @since      1.0.0RC2
     * @access     private
     * @see        isError(), raiseError()
     */
    var $_lastError = false;


    /**
     * Class constructor
     *
     * Class constructors :
     * Zend Engine 1 uses HTML_CSS, while Zend Engine 2 uses __construct
     *
     * @param array $attributes (optional) Pass options to the constructor.
     *                          Valid options are :
     *                           - xhtml (sets xhtml compliance),
     *                           - tab (sets indent string),
     *                           - filename (name of file to be parsed),
     *                           - cache (determines whether the nocache headers
     *                             are sent),
     *                           - oneline (whether to output each definition
     *                             on one line),
     *                           - groupsfirst (determines whether to output groups
     *                             before elements)
     *                           - allowduplicates (allow to have duplicate rules
     *                             in selector)
     * @param array $errorPrefs (optional) has to configure error handler
     *
     * @since      version 0.2.0 (2003-07-31)
     * @access     public
     */
    function HTML_CSS($attributes = array(), $errorPrefs = array())
    {
        $this->__construct($attributes, $errorPrefs);
    }

    /**
     * Class constructor
     *
     * Class constructors :
     * Zend Engine 1 uses HTML_CSS, while Zend Engine 2 uses __construct
     *
     * @param array $attributes (optional) Pass options to the constructor.
     *                          Valid options are :
     *                           - xhtml (sets xhtml compliance),
     *                           - tab (sets indent string),
     *                           - filename (name of file to be parsed),
     *                           - cache (determines whether the nocache headers
     *                             are sent),
     *                           - oneline (whether to output each definition
     *                             on one line),
     *                           - groupsfirst (determines whether to output groups
     *                             before elements)
     *                           - allowduplicates (allow to have duplicate rules
     *                             in selector)
     * @param array $errorPrefs (optional) has to configure error handler
     *
     * @since      version 1.4.0 (2007-12-13)
     * @access     protected
     */
    function __construct($attributes = array(), $errorPrefs = array())
    {
        $this->_initErrorStack($errorPrefs);

        if (!is_array($attributes)) {
            $attributes = array($attributes);
        }
        if ($attributes) {
            $attributes = $this->_parseAttributes($attributes);
        }

        $tab = '  ';
        $eol = strtolower(substr(PHP_OS, 0, 3)) == 'win' ? "\r\n" : "\n";

        // default options
        $this->options = array('xhtml' => true, 'tab' => $tab, 'cache' => true,
            'oneline' => false, 'charset' => 'iso-8859-1',
            'contentDisposition' => false, 'lineEnd' => $eol,
            'groupsfirst' => true, 'allowduplicates' => false);
        // and options that come directly from HTML_Common
        $this->setTab($tab);
        $this->setLineEnd($eol);

        // apply user options
        foreach ($attributes as $opt => $val) {
            $this->__set($opt, $val);
        }
    }

    /**
     * Return the current API version
     *
     * Since 1.0.0 a string is returned rather than a float (for previous versions).
     *
     * @return     string                   compatible with php.version_compare()
     * @since      version 0.2.0 (2003-07-31)
     * @access     public
     */
    function apiVersion()
    {
        return '1.5.0';
    }

    /**
     * Set option for the class
     *
     * Set an individual option value. Option must exist.
     *
     * @param string $option Name of option to set
     * @param string $val    Value of option to set
     *
     * @return void
     * @since  version 1.4.0 (2007-12-13)
     * @access public
     */
    function __set($option, $val)
    {
        if (isset($this->options[$option])) {
            $this->options[$option] = $val;
        }
    }

    /**
     * Get option for the class
     *
     * Return current value of an individual option. If option does not exist,
     * returns value is NULL.
     *
     * @param string $option Name of option to set
     *
     * @return mixed
     * @since  version 1.4.0 (2007-12-13)
     * @access public
     */
    function __get($option)
    {
        if (isset($this->options[$option])) {
            $r = $this->options[$option];
        } else {
            $r = null;
        }
        return $r;
    }

    /**
     * Return all options for the class
     *
     * Return all configuration options at once
     *
     * @return array
     * @since  version 1.5.0 (2008-01-15)
     * @access public
     */
    function getOptions()
    {
        return $this->options;
    }

    /**
     * Set tab value
     *
     * Sets the string used to indent HTML
     *
     * @param string $string String used to indent ("\11", "\t", '  ', etc.).
     *
     * @since     version 1.4.0 (2007-12-13)
     * @access    public
     * @return    void
     */
    function setTab($string)
    {
        $this->__set('tab', $string);
        parent::setTab($string);
    }

    /**
     * Set lineend value
     *
     * Set the line end style to Windows, Mac, Unix or a custom string
     *
     * @param string $style "win", "mac", "unix" or custom string.
     *
     * @since   version 1.4.0 (2007-12-13)
     * @access  public
     * @return  void
     */
    function setLineEnd($style)
    {
        $this->__set('lineEnd', $style);
        parent::setLineEnd($style);
    }

    /**
     * Set oneline flag
     *
     * Determine whether definitions are output on a single line or multi lines
     *
     * @param bool $value flag to true if single line, false for multi lines
     *
     * @return     void|PEAR_Error
     * @since      version 0.3.3 (2004-05-20)
     * @access     public
     * @throws     HTML_CSS_ERROR_INVALID_INPUT
     */
    function setSingleLineOutput($value)
    {
        if (!is_bool($value)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$value',
                      'was' => gettype($value),
                      'expected' => 'boolean',
                      'paramnum' => 1)
            );
        }
        $this->options['oneline'] = $value;
    }

    /**
     * Set groupsfirst flag
     *
     * Determine whether groups are output before elements or not
     *
     * @param bool $value flag to true if groups are output before elements,
     *                    false otherwise
     *
     * @return     void|PEAR_Error
     * @since      version 0.3.3 (2004-05-20)
     * @access     public
     * @throws     HTML_CSS_ERROR_INVALID_INPUT
     */
    function setOutputGroupsFirst($value)
    {
        if (!is_bool($value)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$value',
                      'was' => gettype($value),
                      'expected' => 'boolean',
                      'paramnum' => 1)
            );
        }
        $this->options['groupsfirst'] = $value;
    }

    /**
     * Parse a string containing selector(s)
     *
     * It processes it and returns an array or string containing
     * modified selectors (depends on XHTML compliance setting;
     * defaults to ensure lowercase element names)
     *
     * @param string $selectors  Selector string
     * @param int    $outputMode (optional) 0 = string; 1 = array; 2 = deep array
     *
     * @return     mixed|PEAR_Error
     * @since      version 0.3.2 (2004-03-24)
     * @access     protected
     * @throws     HTML_CSS_ERROR_INVALID_INPUT
     */
    function parseSelectors($selectors, $outputMode = 0)
    {
        if (!is_string($selectors)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$selectors',
                      'was' => gettype($selectors),
                      'expected' => 'string',
                      'paramnum' => 1)
            );

        } elseif (!is_int($outputMode)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$outputMode',
                      'was' => gettype($outputMode),
                      'expected' => 'integer',
                      'paramnum' => 2)
            );

        } elseif ($outputMode < 0 || $outputMode > 3) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$outputMode',
                      'was' => $outputMode,
                      'expected' => '0 | 1 | 2 | 3',
                      'paramnum' => 2)
            );
        }

        $selectors_array =  explode(',', $selectors);
        $i               = 0;
        foreach ($selectors_array as $selector) {
            // trim to remove possible whitespace
            $selector = trim($this->collapseInternalSpaces($selector));
            if (strpos($selector, ' ')) {
                $sel_a = array();
                foreach (explode(' ', $selector) as $sub_selector) {
                    $sel_a[] = $this->parseSelectors($sub_selector, $outputMode);
                }
                if ($outputMode === 0) {
                        $array[$i] = implode(' ', $sel_a);
                } else {
                    $sel_a2 = array();
                    foreach ($sel_a as $sel_a_temp) {
                        $sel_a2 = array_merge($sel_a2, $sel_a_temp);
                    }
                    if ($outputMode == 2) {
                        $array[$i]['inheritance'] = $sel_a2;
                    } else {
                        $array[$i] = implode(' ', $sel_a2);
                    }
                }
                $i++;
            } else {
                // initialize variables
                $element = '';
                $id      = '';
                $class   = '';
                $pseudo  = '';

                if (strpos($selector, ':') !== false) {
                    $pseudo   = strstr($selector, ':');
                    $selector = substr($selector, 0, strpos($selector, ':'));
                }
                if (strpos($selector, '.') !== false) {
                    $class    = strstr($selector, '.');
                    $selector = substr($selector, 0, strpos($selector, '.'));
                }
                if (strpos($selector, '#') !== false) {
                    $id       = strstr($selector, '#');
                    $selector = substr($selector, 0, strpos($selector, '#'));
                }
                if ($selector != '') {
                    $element = $selector;
                }
                if ($this->options['xhtml']) {
                    $element = strtolower($element);
                    $pseudo  = strtolower($pseudo);
                }
                if ($outputMode == 2) {
                    $array[$i]['element'] = $element;
                    $array[$i]['id']      = $id;
                    $array[$i]['class']   = $class;
                    $array[$i]['pseudo']  = $pseudo;
                } else {
                    $array[$i] = $element.$id.$class.$pseudo;
                }
                $i++;
            }
        }
        if ($outputMode == 0) {
            $output = implode(', ', $array);
            return $output;
        } else {
            return $array;
        }
    }

    /**
     * Strips excess spaces in string.
     *
     * @param string $subject string to format
     *
     * @return     string
     * @since      version 0.3.2 (2004-03-24)
     * @access     protected
     */
    function collapseInternalSpaces($subject)
    {
        $string = preg_replace('/\s+/', ' ', $subject);
        return $string;
    }

    /**
     * sort and move simple declarative At-Rules to the top
     *
     * @return     void
     * @access     protected
     * @since      version 1.5.0 (2008-01-15)
     */
    function sortAtRules()
    {
        // split simple declarative At-Rules from the other
        $return = array('atrules' => array(), 'newcss' => array());

        foreach ($this->_css as $key => $value) {
            if ((0 === strpos($key, "@")) && (1 !== strpos($key, "-"))) {
                $return["atrules"][$key] = $value;
            } else {
                $return["newcss"][$key] = $value;
            }
        }

        // bring sprecial rules to the top
        foreach (array('@namespace', '@import', '@charset') as $name) {
            if (isset($return['atrules'][$name])) {
                $rule = array($name => $return['atrules'][$name]);
                unset($return['atrules'][$name]);
                $return['atrules'] = $rule + $return['atrules'];
            }
        }

        $this->_css = $return['atrules'] + $return['newcss'];
    }

    /**
     * Set xhtml flag
     *
     * Active or not the XHTML mode compliant
     *
     * @param bool $value flag to true if XHTML compliance needed,
     *                    false otherwise
     *
     * @return     void|PEAR_Error
     * @since      version 0.3.2 (2004-03-24)
     * @access     public
     * @throws     HTML_CSS_ERROR_INVALID_INPUT
     */
    function setXhtmlCompliance($value)
    {
        if (!is_bool($value)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$value',
                      'was' => gettype($value),
                      'expected' => 'boolean',
                      'paramnum' => 1)
            );
        }
        $this->options['xhtml'] = $value;
    }

    /**
     * Return list of supported At-Rules
     *
     * Return the list of At-Rules supported by API 1.5.0 of HTML_CSS
     *
     * @return void
     * @since  version 1.5.0 (2008-01-15)
     * @access public
     */
    function getAtRulesList()
    {
        $atRules = array('@charset', '@font-face',
                         '@import', '@media', '@page', '@namespace');
        return $atRules;
    }

    /**
     * Create a new simple declarative At-Rule
     *
     * Create a simple at-rule without declaration style blocks.
     * That include @charset, @import and @namespace
     *
     * @param string $atKeyword  at-rule keyword
     * @param string $arguments  argument list for @charset, @import or @namespace
     * @param bool   $duplicates (optional) Allow or disallow duplicates
     *
     * @return void|PEAR_Error
     * @since  version 1.5.0 (2008-01-15)
     * @access public
     * @throws HTML_CSS_ERROR_INVALID_INPUT
     * @see    unsetAtRule()
     */
    function createAtRule($atKeyword, $arguments = '', $duplicates = null)
    {
        $allowed_atrules = array('@charset', '@import', '@namespace');

        if (!is_string($atKeyword)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$atKeyword',
                      'was' => gettype($atKeyword),
                      'expected' => 'string',
                      'paramnum' => 1)
            );

        } elseif (!in_array(strtolower($atKeyword), $allowed_atrules)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$atKeyword',
                      'was' => $atKeyword,
                      'expected' => implode('|', $allowed_atrules),
                      'paramnum' => 1)
            );

        } elseif (!is_string($arguments)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$arguments',
                      'was' => gettype($arguments),
                      'expected' => 'string',
                      'paramnum' => 2)
            );
        }

        if (empty($arguments)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$arguments',
                      'was' => $arguments,
                      'expected' => 'not empty value',
                      'paramnum' => 2)
            );
        }

        if (!isset($duplicates)) {
            $duplicates = $this->__get('allowduplicates');
        }

        if ($duplicates) {
            $this->_duplicateCounter++;
            $this->_css[strtolower($atKeyword)][$this->_duplicateCounter]
                = array($arguments => '');
        } else {
            $this->_css[strtolower($atKeyword)] = array($arguments => '');
        }
    }

    /**
     * Remove an existing At-Rule
     *
     * Remove an existing and supported at-rule. See HTML_CSS::getAtRulesList()
     * for a full list of supported At-Rules.
     *
     * @param string $atKeyword at-rule keyword
     *
     * @return void|PEAR_Error
     * @since  version 1.5.0 (2008-01-15)
     * @access public
     * @throws HTML_CSS_ERROR_INVALID_INPUT, HTML_CSS_ERROR_NO_ATRULE
     */
    function unsetAtRule($atKeyword)
    {
        $allowed_atrules = $this->getAtRulesList();

        if (!is_string($atKeyword)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$atKeyword',
                      'was' => gettype($atKeyword),
                      'expected' => 'string',
                      'paramnum' => 1)
            );

        } elseif (!in_array(strtolower($atKeyword), $allowed_atrules)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$atKeyword',
                      'was' => $atKeyword,
                      'expected' => implode('|', $allowed_atrules),
                      'paramnum' => 1)
            );

        } elseif (!isset($this->_css[strtolower($atKeyword)])) {
            return $this->raiseError(
                HTML_CSS_ERROR_NO_ATRULE, 'error',
                array('identifier' => $atKeyword)
            );
        }

        unset($this->_css[strtolower($atKeyword)]);
    }

    /**
     * Define a conditional/informative At-Rule
     *
     * Set arguments and declaration style block for at-rules that follow :
     * "@media, @page, @font-face"
     *
     * @param string $atKeyword  at-rule keyword
     * @param string $arguments  argument list
     *                           (optional for @font-face)
     * @param string $selectors  selectors of declaration style block
     *                           (optional for @media, @page, @font-face)
     * @param string $property   property of a single declaration style block
     * @param string $value      value of a single declaration style block
     * @param bool   $duplicates (optional) Allow or disallow duplicates
     *
     * @return void|PEAR_Error
     * @since  version 1.5.0 (2008-01-15)
     * @access public
     * @throws HTML_CSS_ERROR_INVALID_INPUT
     * @see    getAtRuleStyle()
     */
    function setAtRuleStyle($atKeyword, $arguments, $selectors, $property, $value,
        $duplicates = null
    ) {
        $allowed_atrules = array('@media', '@page', '@font-face');

        if (!is_string($atKeyword)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$atKeyword',
                      'was' => gettype($atKeyword),
                      'expected' => 'string',
                      'paramnum' => 1)
            );

        } elseif (!in_array(strtolower($atKeyword), $allowed_atrules)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$atKeyword',
                      'was' => $atKeyword,
                      'expected' => implode('|', $allowed_atrules),
                      'paramnum' => 1)
            );

        } elseif (empty($arguments) && strtolower($atKeyword) != '@font-face') {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$arguments',
                      'was' => $arguments,
                      'expected' => 'not empty value for '. $atKeyword,
                      'paramnum' => 2)
            );

        } elseif (!is_string($selectors)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$selectors',
                      'was' => gettype($selectors),
                      'expected' => 'string',
                      'paramnum' => 3)
            );

        } elseif (!is_string($property)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$property',
                      'was' => gettype($property),
                      'expected' => 'string',
                      'paramnum' => 4)
            );

        } elseif (!is_string($value)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$value',
                      'was' => gettype($value),
                      'expected' => 'string',
                      'paramnum' => 5)
            );

        } elseif (empty($property)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$property',
                      'was' => $property,
                      'expected' => 'no empty string',
                      'paramnum' => 4)
            );

        } elseif (empty($value)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$value',
                      'was' => gettype($value),
                      'expected' => 'no empty string',
                      'paramnum' => 5)
            );
        }

        if (!isset($duplicates)) {
            $duplicates = $this->__get('allowduplicates');
        }

        $atKeyword = strtolower($atKeyword);

        if (!empty($selectors)) {
            $selectors = $this->parseSelectors($selectors);
        }
        $this->_css[$atKeyword][$arguments][$selectors][$property] = $value;
    }

    /**
     * Get style value of an existing At-Rule
     *
     * Retrieve arguments or style value of an existing At-Rule.
     * See HTML_CSS::getAtRulesList() for a full list of supported At-Rules.
     *
     * @param string $atKeyword at-rule keyword
     * @param string $arguments argument list
     *                          (optional for @font-face)
     * @param string $selectors selectors of declaration style block
     *                          (optional for @media, @page, @font-face)
     * @param string $property  property of a single declaration style block
     *
     * @return void|PEAR_Error
     * @since  version 1.5.0 (2008-01-15)
     * @access public
     * @throws HTML_CSS_ERROR_INVALID_INPUT
     * @see    setAtRuleStyle()
     */
    function getAtRuleStyle($atKeyword, $arguments, $selectors, $property)
    {
        $allowed_atrules = $this->getAtRulesList();

        if (!is_string($atKeyword)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$atKeyword',
                      'was' => gettype($atKeyword),
                      'expected' => 'string',
                      'paramnum' => 1)
            );

        } elseif (!in_array(strtolower($atKeyword), $allowed_atrules)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$atKeyword',
                      'was' => $atKeyword,
                      'expected' => implode('|', $allowed_atrules),
                      'paramnum' => 1)
            );

        } elseif (!is_string($arguments)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$arguments',
                      'was' => gettype($arguments),
                      'expected' => 'string',
                      'paramnum' => 2)
            );

        } elseif (!is_string($selectors)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$selectors',
                      'was' => gettype($selectors),
                      'expected' => 'string',
                      'paramnum' => 3)
            );

        } elseif (!is_string($property)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$property',
                      'was' => gettype($property),
                      'expected' => 'string',
                      'paramnum' => 4)
            );
        }

        if (isset($this->_css[$atKeyword][$arguments][$selectors][$property])) {
            $val = $this->_css[$atKeyword][$arguments][$selectors][$property];
        } else {
            $val = null;
        }
        return $val;
    }

    /**
     * Create a new CSS definition group
     *
     * Create a new CSS definition group. Return an integer identifying the group.
     *
     * @param string $selectors Selector(s) to be defined, comma delimited.
     * @param mixed  $group     (optional) Group identifier. If not passed,
     *                          will return an automatically assigned integer.
     *
     * @return     mixed|PEAR_Error
     * @since      version 0.3.0 (2003-11-03)
     * @access     public
     * @throws     HTML_CSS_ERROR_INVALID_INPUT, HTML_CSS_ERROR_INVALID_GROUP
     * @see        unsetGroup()
     */
    function createGroup($selectors, $group = null)
    {
        if (!is_string($selectors)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$selectors',
                      'was' => gettype($selectors),
                      'expected' => 'string',
                      'paramnum' => 1)
            );
        }

        if (!isset($group)) {
            $this->_groupCount++;
            $group = $this->_groupCount;
        } else {
            if (isset($this->_groups['@-'.$group])) {
                return $this->raiseError(
                    HTML_CSS_ERROR_INVALID_GROUP, 'error',
                    array('identifier' => $group)
                );
            }
        }

        $groupIdent = '@-'.$group;

        $selectors = $this->parseSelectors($selectors, 1);
        foreach ($selectors as $selector) {
            $this->_alibis[$selector][] = $groupIdent;
        }

        $this->_groups[$groupIdent] = $selectors;

        return $group;
    }

    /**
     * Remove a CSS definition group
     *
     * Remove a CSS definition group. Use the same identifier as for group creation.
     *
     * @param mixed $group CSS definition group identifier
     *
     * @return     void|PEAR_Error
     * @since      version 0.3.0 (2003-11-03)
     * @access     public
     * @throws     HTML_CSS_ERROR_INVALID_INPUT, HTML_CSS_ERROR_NO_GROUP
     * @see        createGroup()
     */
    function unsetGroup($group)
    {
        if (!is_int($group) && !is_string($group)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$group',
                      'was' => gettype($group),
                      'expected' => 'integer | string',
                      'paramnum' => 1)
            );
        }
        $groupIdent = '@-'.$group;
        if ($group < 0 || $group > $this->_groupCount
            || !isset($this->_groups[$groupIdent])
        ) {
            return $this->raiseError(
                HTML_CSS_ERROR_NO_GROUP, 'error',
                array('identifier' => $group)
            );
        }

        $alibis = $this->_alibis;
        foreach ($alibis as $selector => $data) {
            foreach ($data as $key => $value) {
                if ($value == $groupIdent) {
                    unset($this->_alibis[$selector][$key]);
                    break;
                }
            }
            if (count($this->_alibis[$selector]) == 0) {
                unset($this->_alibis[$selector]);
            }
        }
        unset($this->_groups[$groupIdent]);
        unset($this->_css[$groupIdent]);
    }

    /**
     * Set or add a CSS definition for a CSS group
     *
     * Define the new value of a property for a CSS group. The group should exist.
     * If not, use HTML_CSS::createGroup first
     *
     * @param mixed  $group      CSS definition group identifier
     * @param string $property   Property defined
     * @param string $value      Value assigned
     * @param bool   $duplicates (optional) Allow or disallow duplicates.
     *
     * @return     void|int|PEAR_Error     Returns an integer if duplicates
     *                                     are allowed.
     * @since      version 0.3.0 (2003-11-03)
     * @access     public
     * @throws     HTML_CSS_ERROR_INVALID_INPUT, HTML_CSS_ERROR_NO_GROUP
     * @see        getGroupStyle()
     */
    function setGroupStyle($group, $property, $value, $duplicates = null)
    {
        if (!is_int($group) && !is_string($group)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$group',
                      'was' => gettype($group),
                      'expected' => 'integer | string',
                      'paramnum' => 1)
            );

        } elseif (!is_string($property)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$property',
                      'was' => gettype($property),
                      'expected' => 'string',
                      'paramnum' => 2)
            );

        } elseif (empty($property)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$property',
                      'was' => gettype($property),
                      'expected' => 'no empty string',
                      'paramnum' => 2)
            );

        } elseif (!is_string($value)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$value',
                      'was' => gettype($value),
                      'expected' => 'string',
                      'paramnum' => 3)
            );

        } elseif (isset($duplicates) && !is_bool($duplicates)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$duplicates',
                      'was' => gettype($duplicates),
                      'expected' => 'bool',
                      'paramnum' => 4)
            );
        }

        if (!isset($duplicates)) {
            $duplicates = $this->__get('allowduplicates');
        }

        $groupIdent = '@-'.$group;
        if ($group < 0 || $group > $this->_groupCount
            || !isset($this->_groups[$groupIdent])
        ) {
            return $this->raiseError(
                HTML_CSS_ERROR_NO_GROUP, 'error',
                array('identifier' => $group)
            );
        }

        if ($duplicates === true) {
            $this->_duplicateCounter++;
            $this->_css[$groupIdent][$this->_duplicateCounter][$property] = $value;
            return $this->_duplicateCounter;
        } else {
            $this->_css[$groupIdent][$property] = $value;
        }
    }

    /**
     * Return CSS definition for a CSS group
     *
     * Get the CSS definition for group created by setGroupStyle()
     *
     * @param mixed  $group    CSS definition group identifier
     * @param string $property Property defined
     *
     * @return     mixed|PEAR_Error
     * @since      version 0.3.0 (2003-11-03)
     * @access     public
     * @throws     HTML_CSS_ERROR_INVALID_INPUT, HTML_CSS_ERROR_NO_GROUP,
     *             HTML_CSS_ERROR_NO_ELEMENT
     * @see        setGroupStyle()
     */
    function getGroupStyle($group, $property)
    {
        if (!is_int($group) && !is_string($group)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$group',
                      'was' => gettype($group),
                      'expected' => 'integer | string',
                      'paramnum' => 1)
            );

        } elseif (!is_string($property)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$property',
                      'was' => gettype($property),
                      'expected' => 'string',
                      'paramnum' => 2)
            );
        }
        $groupIdent = '@-'.$group;
        if ($group < 0 || $group > $this->_groupCount
            || !isset($this->_groups[$groupIdent])
        ) {
            return $this->raiseError(
                HTML_CSS_ERROR_NO_GROUP, 'error',
                array('identifier' => $group)
            );
        }

        $styles = array();

        if (!isset($this->_css[$groupIdent])) {
            return $styles;
        }

        foreach ($this->_css[$groupIdent] as $rank => $prop) {
            // if the style is not duplicate
            if (!is_numeric($rank)) {
                $prop = array($rank => $prop);
            }
            foreach ($prop as $key => $value) {
                if ($key == $property) {
                    $styles[] = $value;
                }
            }
        }

        if (count($styles) < 2) {
            $styles = array_shift($styles);
        }
        return $styles;
    }

    /**
     * Add a selector to a CSS definition group.
     *
     * Add a selector to a CSS definition group
     *
     * @param mixed  $group     CSS definition group identifier
     * @param string $selectors Selector(s) to be defined, comma delimited.
     *
     * @return   void|PEAR_Error
     * @since    version 0.3.0 (2003-11-03)
     * @access   public
     * @throws   HTML_CSS_ERROR_NO_GROUP, HTML_CSS_ERROR_INVALID_INPUT
     */
    function addGroupSelector($group, $selectors)
    {
        if (!is_int($group) && !is_string($group)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$group',
                      'was' => gettype($group),
                      'expected' => 'integer | string',
                      'paramnum' => 1)
            );
        }
        $groupIdent = '@-'.$group;
        if ($group < 0 || $group > $this->_groupCount
            || !isset($this->_groups[$groupIdent])
        ) {
            return $this->raiseError(
                HTML_CSS_ERROR_NO_GROUP, 'error',
                array('identifier' => $group)
            );

        } elseif (!is_string($selectors)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$selectors',
                      'was' => gettype($selectors),
                      'expected' => 'string',
                      'paramnum' => 2)
            );
        }

        $newSelectors = $this->parseSelectors($selectors, 1);
        foreach ($newSelectors as $selector) {
            $this->_alibis[$selector][] = $groupIdent;
        }
        $oldSelectors = $this->_groups[$groupIdent];

        $this->_groups[$groupIdent] = array_merge($oldSelectors, $newSelectors);
    }

    /**
     * Remove a selector from a group
     *
     * Definitively remove a selector from a CSS group
     *
     * @param mixed  $group     CSS definition group identifier
     * @param string $selectors Selector(s) to be removed, comma delimited.
     *
     * @return   void|PEAR_Error
     * @since    version 0.3.0 (2003-11-03)
     * @access   public
     * @throws   HTML_CSS_ERROR_NO_GROUP, HTML_CSS_ERROR_INVALID_INPUT
     */
    function removeGroupSelector($group, $selectors)
    {
        if (!is_int($group) && !is_string($group)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$group',
                      'was' => gettype($group),
                      'expected' => 'integer | string',
                      'paramnum' => 1)
            );
        }
        $groupIdent = '@-'.$group;
        if ($group < 0 || $group > $this->_groupCount
            || !isset($this->_groups[$groupIdent])
        ) {
            return $this->raiseError(
                HTML_CSS_ERROR_NO_GROUP, 'error',
                array('identifier' => $group)
            );

        } elseif (!is_string($selectors)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$selectors',
                      'was' => gettype($selectors),
                      'expected' => 'string',
                      'paramnum' => 2)
            );
        }

        $oldSelectors = $this->_groups[$groupIdent];
        $selectors    = $this->parseSelectors($selectors, 1);
        foreach ($selectors as $selector) {
            foreach ($oldSelectors as $key => $value) {
                if ($value == $selector) {
                    unset($this->_groups[$groupIdent][$key]);
                }
            }
            foreach ($this->_alibis[$selector] as $key => $value) {
                if ($value == $groupIdent) {
                    unset($this->_alibis[$selector][$key]);
                }
            }
        }
    }

    /**
     * Set or add a CSS definition
     *
     * Add or change a single value for an element property
     *
     * @param string $element    Element (or class) to be defined
     * @param string $property   Property defined
     * @param string $value      Value assigned
     * @param bool   $duplicates (optional) Allow or disallow duplicates.
     *
     * @return     void|PEAR_Error
     * @since      version 0.2.0 (2003-07-31)
     * @access     public
     * @throws     HTML_CSS_ERROR_INVALID_INPUT
     * @see        getStyle()
     */
    function setStyle($element, $property, $value, $duplicates = null)
    {
        if (!is_string($element)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$element',
                      'was' => gettype($element),
                      'expected' => 'string',
                      'paramnum' => 1)
            );

        } elseif (!is_string($property)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$property',
                      'was' => gettype($property),
                      'expected' => 'string',
                      'paramnum' => 2)
            );

        } elseif (!is_string($value)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$value',
                      'was' => gettype($value),
                      'expected' => 'string',
                      'paramnum' => 3)
            );

        } elseif (strpos($element, ',')) {
            // Check if there are any groups.
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$element',
                      'was' => $element,
                      'expected' => 'string without comma',
                      'paramnum' => 1)
            );

        } elseif (isset($duplicates) && !is_bool($duplicates)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$duplicates',
                      'was' => gettype($duplicates),
                      'expected' => 'bool',
                      'paramnum' => 4)
            );
        }

        if (!isset($duplicates)) {
             $duplicates = $this->__get('allowduplicates');
        }

        $element = $this->parseSelectors($element);

        if ($duplicates === true) {
            $this->_duplicateCounter++;
            $this->_css[$element][$this->_duplicateCounter][$property] = $value;
            return $this->_duplicateCounter;
        } else {
            $this->_css[$element][$property] = $value;
        }
    }

    /**
     * Return the value of a CSS property
     *
     * Get the value of a property to an identifed simple CSS element
     *
     * @param string $element  Element (or class) to be defined
     * @param string $property Property defined
     *
     * @return     mixed|PEAR_Error
     * @since      version 0.3.0 (2003-11-03)
     * @access     public
     * @throws     HTML_CSS_ERROR_INVALID_INPUT,
     *             HTML_CSS_ERROR_NO_ELEMENT, HTML_CSS_ERROR_NO_ELEMENT_PROPERTY
     * @see        setStyle()
     */
    function getStyle($element, $property)
    {
        if (!is_string($element)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$element',
                      'was' => gettype($element),
                      'expected' => 'string',
                      'paramnum' => 1)
            );

        } elseif (!is_string($property)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$property',
                      'was' => gettype($property),
                      'expected' => 'string',
                      'paramnum' => 2)
            );
        }
        if (!isset($this->_css[$element]) && !isset($this->_alibis[$element])) {
            return $this->raiseError(
                HTML_CSS_ERROR_NO_ELEMENT, 'error',
                array('identifier' => $element)
            );
        }

        if (isset($this->_css[$element]) && isset($this->_alibis[$element])) {
            $lastImplementation = array_keys($this->_alibis[$element]);
            $lastImplementation = array_pop($lastImplementation);

            $group = substr($this->_alibis[$element][$lastImplementation], 2);

            $property_value = $this->getGroupStyle($group, $property);
            if (count($property_value) == 0) {
                unset($property_value);
            }
        }
        if (isset($this->_css[$element]) && !isset($property_value)) {
            $property_value = array();
            foreach ($this->_css[$element] as $rank => $prop) {
                if (!is_numeric($rank)) {
                    $prop = array($rank => $prop);
                }
                foreach ($prop as $key => $value) {
                    if ($key == $property) {
                        $property_value[] = $value;
                    }
                }
            }
            if (count($property_value) == 1) {
                $property_value = $property_value[0];
            } elseif (count($property_value) == 0) {
                unset($property_value);
            }
        }

        if (!isset($property_value)) {
            return $this->raiseError(
                HTML_CSS_ERROR_NO_ELEMENT_PROPERTY, 'error',
                array('identifier' => $element,
                      'property'   => $property)
            );
        }
        return $property_value;
    }

    /**
     * Retrieve styles corresponding to an element filter
     *
     * Return array entries of styles that match patterns (Perl compatible)
     *
     * @param string $elmPattern Element or class pattern to retrieve
     * @param string $proPattern (optional) Property pattern to retrieve
     *
     * @return     array|PEAR_Error
     * @since      version 1.1.0 (2007-01-01)
     * @access     public
     * @throws     HTML_CSS_ERROR_INVALID_INPUT
     * @link       http://www.php.net/en/ref.pcre.php
     *             Regular Expression Functions (Perl-Compatible)
     */
    function grepStyle($elmPattern, $proPattern = null)
    {
        if (!is_string($elmPattern)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$elmPattern',
                      'was' => gettype($elmPattern),
                      'expected' => 'string',
                      'paramnum' => 1)
            );

        } elseif (isset($proPattern) && !is_string($proPattern)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$proPattern',
                      'was' => gettype($proPattern),
                      'expected' => 'string',
                      'paramnum' => 2)
            );
        }

        $styles = array();

        // first, search inside alibis
        $alibis = array_keys($this->_alibis);
        $alibis = preg_grep($elmPattern, $alibis);
        foreach ($alibis as $a) {
            foreach ($this->_alibis[$a] as $g) {
                if (isset($proPattern)) {
                    $properties = array_keys($this->_css[$g]);
                    $properties = preg_grep($proPattern, $properties);
                    if (count($properties) == 0) {
                        // this group does not have a such property pattern
                        continue;
                    }
                }
                if (isset($styles[$a])) {
                    $styles[$a] = array_merge($styles[$a], $this->_css[$g]);
                } else {
                    $styles[$a] = $this->_css[$g];
                }
            }
        }

        // second, search inside elements
        $elements = array_keys($this->_css);
        $elements = preg_grep($elmPattern, $elements);
        foreach ($elements as $e) {
            if (substr($e, 0, 1) == '@' ) {
                // excludes groups (already found with alibis)
                continue;
            }
            if (isset($proPattern)) {
                $properties = array_keys($this->_css[$e]);
                $properties = preg_grep($proPattern, $properties);
                if (count($properties) == 0) {
                    // this element does not have a such property pattern
                    continue;
                }
            }
            if (isset($styles[$e])) {
                $styles[$e] = array_merge($styles[$e], $this->_css[$e]);
            } else {
                $styles[$e] = $this->_css[$e];
            }
        }
        return $styles;
    }

    /**
     * Apply same styles on two selectors
     *
     * Set or change the properties of new selectors
     * to the values of an existing selector
     *
     * @param string $new New selector(s) that should share the same
     *                    definitions, separated by commas
     * @param string $old Selector that is already defined
     *
     * @return     void|PEAR_Error
     * @since      version 0.2.0 (2003-07-31)
     * @access     public
     * @throws     HTML_CSS_ERROR_INVALID_INPUT, HTML_CSS_ERROR_NO_ELEMENT
     */
    function setSameStyle($new, $old)
    {
        if (!is_string($new)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$new',
                      'was' => gettype($new),
                      'expected' => 'string',
                      'paramnum' => 1)
            );

        } elseif (!is_string($old)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$old',
                      'was' => gettype($old),
                      'expected' => 'string',
                      'paramnum' => 2)
            );

        } elseif (strpos($new, ',')) {
            // Check if there are any groups.
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$new',
                      'was' => $new,
                      'expected' => 'string without comma',
                      'paramnum' => 1)
            );

        } elseif (strpos($old, ',')) {
            // Check if there are any groups.
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'error',
                array('var' => '$old',
                      'was' => $old,
                      'expected' => 'string without comma',
                      'paramnum' => 2)
            );
        }

        $old = $this->parseSelectors($old);
        if (!isset($this->_css[$old])) {
            return $this->raiseError(
                HTML_CSS_ERROR_NO_ELEMENT, 'error',
                array('identifier' => $old)
            );
        }

        $selector = implode(', ', array($old, $new));
        $grp      = $this->createGroup($selector, 'samestyleas_'.$old);

        $others = $this->parseSelectors($new, 1);
        foreach ($others as $other) {
            $other = trim($other);
            foreach ($this->_css[$old] as $rank => $property) {
                if (!is_numeric($rank)) {
                    $property = array($rank => $property);
                }
                foreach ($property as $key => $value) {
                    $this->setGroupStyle($grp, $key, $value);
                }
            }
            unset($this->_css[$old]);
        }
    }

    /**
     * Set cache flag
     *
     * Define if the document should be cached by the browser. Default to false.
     *
     * @param bool $cache (optional) flag to true to cache result, false otherwise
     *
     * @return     void|PEAR_Error
     * @since      version 0.2.0 (2003-07-31)
     * @access     public
     * @throws     HTML_CSS_ERROR_INVALID_INPUT
     */
    function setCache($cache = true)
    {
        if (!is_bool($cache)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$cache',
                      'was' => gettype($cache),
                      'expected' => 'boolean',
                      'paramnum' => 1)
            );
        }
        $this->options['cache'] = $cache;
    }

    /**
     * Returns the cache option value
     *
     * @return     boolean
     * @since      version 1.4.0 (2007-12-13)
     * @access     public
     * @see        setCache()
     */
    function getCache()
    {
        return $this->__get('cache');
    }

    /**
     * Set Content-Disposition header
     *
     * Define the Content-Disposition header to supply a recommended filename
     * and force the browser to display the save dialog.
     * Default to basename($_SERVER['PHP_SELF']).'.css'
     *
     * @param bool   $enable   (optional)
     * @param string $filename (optional)
     *
     * @return     void|PEAR_Error
     * @since      version 1.3.0 (2007-10-22)
     * @access     public
     * @throws     HTML_CSS_ERROR_INVALID_INPUT
     * @see        getContentDisposition()
     * @link       http://pear.php.net/bugs/bug.php?id=12195
     *             Patch by Carsten Wiedmann
     */
    function setContentDisposition($enable = true, $filename = '')
    {
        if (!is_bool($enable)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$enable',
                      'was' => gettype($enable),
                      'expected' => 'bool',
                      'paramnum' => 1)
            );
        } elseif (!is_string($filename)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$filename',
                      'was' => gettype($filename),
                      'expected' => 'string',
                      'paramnum' => 2)
            );
        }

        if ($enable == false) {
            $filename = false;
        } elseif ($filename == '') {
            $filename = basename($_SERVER['PHP_SELF']) . '.css';
        }

        $this->options['contentDisposition'] = $filename;
    }

    /**
     * Return the Content-Disposition header
     *
     * Get value of Content-Disposition header (inline filename) used
     * to display results
     *
     * @return     mixed     boolean FALSE if no content disposition, otherwise
     *                       string for inline filename
     * @since      version 1.3.0 (2007-10-22)
     * @access     public
     * @see        setContentDisposition()
     * @link       http://pear.php.net/bugs/bug.php?id=12195
     *             Patch by Carsten Wiedmann
     */
    function getContentDisposition()
    {
        return $this->__get('contentDisposition');
    }

    /**
     * Set charset value
     *
     * Define the charset for the file. Default to ISO-8859-1 because of CSS1
     * compatability issue for older browsers.
     *
     * @param string $type (optional) Charset encoding; defaults to ISO-8859-1.
     *
     * @return     void|PEAR_Error
     * @since      version 0.2.0 (2003-07-31)
     * @access     public
     * @throws     HTML_CSS_ERROR_INVALID_INPUT
     * @see        getCharset()
     */
    function setCharset($type = 'iso-8859-1')
    {
        if (!is_string($type)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$type',
                      'was' => gettype($type),
                      'expected' => 'string',
                      'paramnum' => 1)
            );
        }
        $this->options['charset'] = $type;
    }

    /**
     * Return the charset encoding string
     *
     * By default, HTML_CSS uses iso-8859-1 encoding.
     *
     * @return     string
     * @since      version 0.2.0 (2003-07-31)
     * @access     public
     * @see        setCharset()
     */
    function getCharset()
    {
        return $this->__get('charset');
    }

    /**
     * Parse a string
     *
     * Parse a string that contains CSS information
     *
     * @param string $str        text string to parse
     * @param bool   $duplicates (optional) Allows or disallows
     *                           duplicate style definitions
     *
     * @return     void|PEAR_Error
     * @since      version 0.3.0 (2003-11-03)
     * @access     public
     * @throws     HTML_CSS_ERROR_INVALID_INPUT
     * @see        createGroup(), setGroupStyle(), setStyle()
     */
    function parseString($str, $duplicates = null)
    {
        if (!is_string($str)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$str',
                      'was' => gettype($str),
                      'expected' => 'string',
                      'paramnum' => 1)
            );

        } elseif (isset($duplicates) && !is_bool($duplicates)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$duplicates',
                      'was' => gettype($duplicates),
                      'expected' => 'bool',
                      'paramnum' => 2)
            );
        }

        if (!isset($duplicates)) {
            $duplicates = $this->__get('allowduplicates');
        }

        // Remove comments
        $str = preg_replace("/\/\*(.*)?\*\//Usi", '', $str);

        // Protect parser vs IE hack
        $str = str_replace('"\"}\""', '#34#125#34', $str);

        // Parse simple declarative At-Rules
        $atRules    = array();
        $elements   = array();
        $properties = array();

        // core of major 1.5.4 parser
        preg_match_all(
            '/(?ims)([a-z0-9\s\.\:#_\-@,]+)\{([^\{|^\}]*)\}/',
            $str, $rules, PREG_SET_ORDER
        );

        // structure simplified
        $structure = preg_replace(
            '/(?ims)([a-zA-Z0-9\s\.\:#_\-@,]+)\{([^\{|^\}]*)\}/',
            '\1{}', $str
        );
        // structure map
        $structure = preg_split(
            '/([a-zA-Z0-9\s\.\:#_\-@,]+)\{(.*)\}/', $structure, -1,
            PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
        );

        $atRulesMap = array();
        $atRule = '';
        foreach ($structure as $struct) {
            $struct = trim($struct);
            if (empty($struct)) {
                continue;
            }
            if ($struct{0} == '}') {
                $atRule = '';
                $struct = substr($struct, 1);
                $struct = ltrim($struct);
            }

            if ($this->options['xhtml']) {
                $struct = strtolower($struct);
            }

            
            $has_AtRules = preg_match_all(
                '/^(@[a-zA-Z\-]+)\s+(.+);\s*$/m', $struct, $atRules,
                PREG_SET_ORDER
            );
            if ($has_AtRules) {
                foreach ($atRules as $value) {
                    $this->createAtRule(
                        trim($value[1]), trim($value[2]), $duplicates
                    );
                }
                continue;
            }
            $struct = $this->collapseInternalSpaces($struct);

            $pos = strpos($struct, '{');
            if ($pos
                || (strpos($struct, ':') && !empty($atRule))
            ) {
                $cc = count_chars($struct, 1);
                if ((isset($cc[64]) && $cc[64] > 1)
                    || (isset($cc[58]) && $cc[58] == 1)
                ) {
                    $context  = debug_backtrace();
                    $context  = @array_pop($context);
                    $function = strtolower($context['function']);
                    if ($function === 'parsestring') {
                        $var = 'str';
                    } elseif ($function === 'parsefile') {
                        $var = 'filename';
                    } else {
                        $var = 'styles';
                    }

                    return $this->raiseError(
                        HTML_CSS_ERROR_INVALID_INPUT, 'error',
                        array('var' => '$'.$var,
                              'was' => 'invalid data source',
                              'expected' => 'valid CSS structure',
                              'paramnum' => 1)
                    );
                }
                $atRule = rtrim(substr($struct, 0, $pos));

            } else {
                $atRulesMap[$struct][] = $atRule;
            }
        }

        foreach ($rules as $rule) {

            // prevent invalid css data structure
            $pos = strpos($rule[0], '{');
            $sel = trim($rule[1]);
            if ((strpos($rule[0], '{', $pos+1) !== false)
                || (substr($sel, -1, 1) == ':')
            ) {
                $context  = debug_backtrace();
                $context  = @array_pop($context);
                $function = strtolower($context['function']);
                if ($function === 'parsestring') {
                    $var = 'str';
                } elseif ($function === 'parsefile') {
                    $var = 'filename';
                } else {
                    $var = 'styles';
                }

                return $this->raiseError(
                    HTML_CSS_ERROR_INVALID_INPUT, 'error',
                    array('var' => '$'.$var,
                          'was' => 'invalid data source',
                          'expected' => 'valid CSS structure',
                          'paramnum' => 1)
                );
            }

            if ($this->options['xhtml']) {
                $rule[1] = strtolower($rule[1]);
            }

            $elements[]   = trim($rule[1]);
            $properties[] = trim($rule[2]);
        }

        foreach ($elements as $i => $keystr) {

            $key_a   = $this->parseSelectors($keystr, 1);
            $keystr  = implode(', ', $key_a);
            $codestr = $properties[$i];

            $key = trim($keystr);
            $parentAtRule = isset($atRulesMap[$key][$i])
                ? $atRulesMap[$key][$i] : $atRulesMap[$key][0];

            // Check if there are any groups; in standard selectors exclude at-rules
            if (strpos($keystr, ',') && (empty($parentAtRule))) {
                $group = $this->createGroup($keystr);

                // Parse each property of an element
                $codes = explode(";", trim($codestr));
                foreach ($codes as $code) {
                    if (strlen(trim($code)) > 0) {
                        // find the property and the value
                        $property
                            = trim(substr($code, 0, strpos($code, ':', 0)));
                        $value
                            = trim(substr($code, strpos($code, ':', 0) + 1));
                        // IE hack only
                        if (strcasecmp($property, 'voice-family') == 0) {
                            $value
                                = str_replace('#34#125#34', '"\"}\""', $value);
                        }
                        $this->setGroupStyle(
                            $group, $property, $value, $duplicates
                        );
                    }
                }
            } else {
                // Parse each property of an element
                $codes = explode(";", trim($codestr));
                foreach ($codes as $code) {
                    if (strlen(trim($code)) == 0) {
                        continue;
                    }
                    $code = ltrim($code, "\r\n}");

                    $p = trim(substr($code, 0, strpos($code, ':')));
                    $v = trim(substr($code, strpos($code, ':') + 1));
                    // IE hack only
                    if (strcasecmp($p, 'voice-family') == 0) {
                        $v = str_replace('#34#125#34', '"\"}\""', $v);
                    }

                    if (!empty($parentAtRule)) {
                        // at-rules
                        $atkw_args = preg_split(
                            '/(@[a-zA-Z\-]+)\s+(.+)/', $parentAtRule, -1,
                            PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
                        );
                        if (count($atkw_args) == 1) {
                            // special case of @font-face (without argument)
                            $atkw_args[] = '';
                        }
                        list($atKeyword, $arguments) = $atkw_args;
                        $this->setAtRuleStyle(
                            $atKeyword, $arguments, $keystr, $p, $v, $duplicates
                        );

                    } elseif ($key{0} == '@') {
                        $atkw_args = preg_split(
                            '/(@[a-zA-Z\-]+)\s+(.+)/', $key, -1,
                            PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
                        );
                        if (count($atkw_args) == 1) {
                            $atkw_args[] = '';
                        }
                        list($atKeyword, $arguments) = $atkw_args;
                        $this->setAtRuleStyle(
                            $atKeyword, $arguments, '', $p, $v, $duplicates
                        );
                    } else {
                        // simple declarative style
                        $this->setStyle($key, $p, $v, $duplicates);
                    }
                }
            }
        }
    }

    /**
     * Parse file content
     *
     * Parse a file that contains CSS information
     *
     * @param string $filename   file to parse
     * @param bool   $duplicates (optional) Allow or disallow duplicates.
     *
     * @return     void|PEAR_Error
     * @since      version 0.3.0 (2003-11-03)
     * @access     public
     * @throws     HTML_CSS_ERROR_INVALID_INPUT, HTML_CSS_ERROR_NO_FILE
     * @see        parseString()
     */
    function parseFile($filename, $duplicates = null)
    {
        if (!is_string($filename)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$filename',
                      'was' => gettype($filename),
                      'expected' => 'string',
                      'paramnum' => 1)
            );

        } elseif (!file_exists($filename)) {
            return $this->raiseError(
                HTML_CSS_ERROR_NO_FILE, 'error',
                array('identifier' => $filename)
            );

        } elseif (isset($duplicates) && !is_bool($duplicates)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$duplicates',
                      'was' => gettype($duplicates),
                      'expected' => 'bool',
                      'paramnum' => 2)
            );
        }

        if (!isset($duplicates)) {
            $duplicates = $this->__get('allowduplicates');
        }

        $ret = $this->parseString(file_get_contents($filename), $duplicates);
        return $ret;
    }

    /**
     * Parse multiple data sources
     *
     * Parse data sources, file(s) or string(s), that contains CSS information
     *
     * @param array $styles     data sources to parse
     * @param bool  $duplicates (optional) Allow or disallow duplicates.
     *
     * @return     void|PEAR_Error
     * @since      version 1.0.0RC2 (2005-12-15)
     * @access     public
     * @throws     HTML_CSS_ERROR_INVALID_INPUT
     * @see        parseString(), parseFile()
     */
    function parseData($styles, $duplicates = null)
    {
        if (!is_array($styles)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$styles',
                      'was' => gettype($styles),
                      'expected' => 'array',
                      'paramnum' => 1)
            );

        } elseif (isset($duplicates) && !is_bool($duplicates)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$duplicates',
                      'was' => gettype($duplicates),
                      'expected' => 'bool',
                      'paramnum' => 2)
            );
        }

        if (!isset($duplicates)) {
            $duplicates = $this->__get('allowduplicates');
        }

        foreach ($styles as $i => $style) {
            if (!is_string($style)) {
                return $this->raiseError(
                    HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                    array('var' => '$styles[' . $i . ']',
                          'was' => gettype($styles[$i]),
                          'expected' => 'string',
                          'paramnum' => 1)
                );
            }
            if (strcasecmp(substr($style, -4, 4), '.css') == 0) {
                $this->parseFile($style, $duplicates);
            } else {
                $this->parseString($style, $duplicates);
            }
        }
    }

    /**
     * Validate a CSS data source
     *
     * Execute the W3C CSS validator service on each data source (filename
     * or string) given by parameter $styles.
     *
     * @param array $styles    Data sources to check validity
     * @param array &$messages Error and Warning messages
     *                         issue from W3C CSS validator service
     *
     * @return     boolean|PEAR_Error
     * @since      version 1.5.0 (2008-01-15)
     * @access     public
     * @throws     HTML_CSS_ERROR_INVALID_INPUT,
     *             HTML_CSS_ERROR_INVALID_DEPS, HTML_CSS_ERROR_INVALID_SOURCE
     */
    function validate($styles, &$messages)
    {
        $php = phpversion();
        if (version_compare($php, '5.0.0', '<')) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_DEPS, 'exception',
                array('funcname' => __FUNCTION__,
                      'dependency' => 'PHP 5',
                      'currentdep' => "PHP $php")
            );
        }
        @include_once 'Services/W3C/CSSValidator.php';
        if (class_exists('Services_W3C_CSSValidator', false) === false) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_DEPS, 'exception',
                array('funcname' => __FUNCTION__,
                      'dependency' => 'PEAR::Services_W3C_CSSValidator',
                      'currentdep' => 'nothing')
            );
        }
        if (!is_array($styles)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$styles',
                      'was' => gettype($styles),
                      'expected' => 'array',
                      'paramnum' => 1)
            );

        } elseif (!is_array($messages)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$messages',
                      'was' => gettype($messages),
                      'expected' => 'array',
                      'paramnum' => 2)
            );
        }

        // prepare to call the W3C CSS validator service
        $v        = new Services_W3C_CSSValidator();
        $validity = true;
        $messages = array('errors' => array(), 'warnings' => array());

        foreach ($styles as $i => $source) {
            if (!is_string($source)) {
                return $this->raiseError(
                    HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                    array('var' => '$styles[' . $i . ']',
                          'was' => gettype($styles[$i]),
                          'expected' => 'string',
                          'paramnum' => 1)
                );
            }
            if (strcasecmp(substr($source, -4, 4), '.css') == 0) {
                // validate a file as CSS content
                $r = $v->validateFile($source);
            } else {
                // validate a string as CSS content
                $r = $v->validateFragment($source);
            }
            if ($r === false) {
                $validity = false;
            }
            if ($r->isValid() === false) {
                $validity = false;
                foreach ($r->errors as $error) {
                    $properties           = get_object_vars($error);
                    $messages['errors'][] = $properties;
                }
                foreach ($r->warnings as $warning) {
                    $properties             = get_object_vars($warning);
                    $messages['warnings'][] = $properties;
                }
                $this->raiseError(
                    HTML_CSS_ERROR_INVALID_SOURCE,
                    ((count($r->errors) == 0) ? 'warning' : 'error'),
                    array('sourcenum' => $i,
                          'errcount' => count($r->errors),
                          'warncount' => count($r->warnings))
                );
            }
        }
        return $validity;
    }

    /**
     * Return the CSS contents in an array
     *
     * Return the full contents of CSS data sources (parsed) in an array
     *
     * @return     array
     * @since      version 0.2.0 (2003-07-31)
     * @access     public
     */
    function toArray()
    {
        $css = array();

        // bring AtRules in correct order
        $this->sortAtRules();

        foreach ($this->_css as $key => $value) {
            if (strpos($key, '@-') === 0) {
                $key = implode(', ', $this->_groups[$key]);
            }
            $css[$key] = $value;
        }
        return $css;
    }

    /**
     * Return a string-properties for style attribute of an HTML element
     *
     * Generate and return the CSS properties of an element or class
     * as a string for inline use.
     *
     * @param string $element Element or class
     *                        for which inline CSS should be generated
     *
     * @return     string|PEAR_Error
     * @since      version 0.2.0 (2003-07-31)
     * @access     public
     * @throws     HTML_CSS_ERROR_INVALID_INPUT
     */
    function toInline($element)
    {
        if (!is_string($element)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$element',
                      'was' => gettype($element),
                      'expected' => 'string',
                      'paramnum' => 1)
            );
        }

        $strCss      = '';
        $newCssArray = array();

        // This allows for grouped elements definitions to work
        if (isset($this->_alibis[$element])) {
            $alibis = $this->_alibis[$element];

            // All the groups must be run through to be able to
            // properly assign the value to the inline.
            foreach ($alibis as $alibi) {
                foreach ($this->_css[$alibi] as $key => $value) {
                    $newCssArray[$key] = $value;
                }
            }
        }

        // This allows for single elements definitions to work
        if (isset($this->_css[$element])) {
            foreach ($this->_css[$element] as $rank => $property) {
                if (!is_numeric($rank)) {
                    $property = array($rank => $property);
                }
                foreach ($property as $key => $value) {
                    if ($key != 'other-elements') {
                        $newCssArray[$key] = $value;
                    }
                }
            }
        }

        foreach ($newCssArray as $key => $value) {
            if ((0 === strpos($element, '@')) && ('' == $value)) {
                // simple declarative At-Rule definition
                $strCss .= $key . ';';
            } else {
                // other CSS definition
                $strCss .= $key . ':' . $value . ";";
            }
        }

        return $strCss;
    }

    /**
     * Generate CSS and stores it in a file
     *
     * Generate current parsed CSS data sources and write result in a user file
     *
     * @param string $filename Name of file that content the stylesheet
     *
     * @return     void|PEAR_Error
     * @since      version 0.3.0 (2003-11-03)
     * @access     public
     * @throws     HTML_CSS_ERROR_INVALID_INPUT, HTML_CSS_ERROR_WRITE_FILE
     * @see        toString()
     */
    function toFile($filename)
    {
        if (!is_string($filename)) {
            return $this->raiseError(
                HTML_CSS_ERROR_INVALID_INPUT, 'exception',
                array('var' => '$filename',
                      'was' => gettype($filename),
                      'expected' => 'string',
                      'paramnum' => 1)
            );
        }

        if (function_exists('file_put_contents')) {
            file_put_contents($filename, $this->toString());
        } else {
            $file = fopen($filename, 'wb');
            fwrite($file, $this->toString());
            fclose($file);
        }
        if (!file_exists($filename)) {
            return $this->raiseError(
                HTML_CSS_ERROR_WRITE_FILE, 'error',
                array('filename' => $filename)
            );
        }
    }

    /**
     * Return current CSS parsed data as a string
     *
     * Generate current parsed CSS data sources and return result as a string
     *
     * @return     string
     * @since      version 0.2.0 (2003-07-31)
     * @access     public
     */
    function toString()
    {
        // get line endings
        $lnEnd = $this->_getLineEnd();
        $tabs  = $this->_getTabs();
        $tab   = $this->_getTab();

        // initialize $alibis
        $alibis = array();

        $strCss     = '';
        $strAtRules = '';

        // Allow a CSS comment
        if ($this->_comment) {
            $strCss = $tabs . '/* ' . $this->getComment() . ' */' . $lnEnd;
        }

        // If groups are to be output first, initialize a special variable
        if ($this->__get('groupsfirst')) {
            $strCssElements = '';
        }

        // bring AtRules in correct order
        $this->sortAtRules();

        // Iterate through the array and process each element
        foreach ($this->_css as $identifier => $rank) {

            // Groups are handled separately
            if (strpos($identifier, '@-') !== false) {
                // its a group
                $element = implode(', ', $this->_groups[$identifier]);
            } else {
                $element = $identifier;
            }

            if ((0 === strpos($element, '@')) && (1 !== strpos($element, '-'))) {
                // simple declarative At-Rule definition
                foreach ($rank as $arg => $decla) {
                    // check to see if it is a duplicate
                    if (is_numeric($arg)) {
                        $arg   = array_keys($decla);
                        $arg   = array_shift($arg);
                        $decla = array_values($decla);
                        $decla = array_shift($decla);
                    }
                    if (is_array($decla)) {
                        $strAtRules .= $element . ' ' . $arg;
                        foreach ($decla as $s => $d) {
                            $t = $tabs . $tab;
                            if (empty($s)) {
                                $strAtRules .= ' {' . $lnEnd;
                            } else {
                                $t          .= $tab;
                                $strAtRules .= ' {' . $lnEnd .
                                    $tab . $s . ' {' . $lnEnd;
                            }
                            foreach ($d as $p => $v) {
                                $strAtRules .= $t . $p . ': ' . $v . ';' . $lnEnd;
                            }
                            if (empty($s)) {
                                $strAtRules .= $tabs . '}';
                            } else {
                                $strAtRules .=  $tabs . $tab . '}' . $lnEnd . '}';
                            }
                        }
                        $strAtRules .=  $lnEnd . $lnEnd;;
                    } else {
                        $strAtRules .= $element . ' ' . $arg . ';' . $lnEnd . $lnEnd;
                    }
                }
            } else {
                // Start CSS element definition
                $definition = $element . ' {' . $lnEnd;

                // Iterate through the array of properties
                foreach ($rank as $pos => $property) {
                    // check to see if it is a duplicate
                    if (!is_numeric($pos)) {
                        $property = array($pos => $property);
                        unset($pos);
                    }
                    foreach ($property as $key => $value) {
                        $definition .= $tabs . $tab
                                    . $key . ': ' . $value . ';' . $lnEnd;
                    }
                }

                // end CSS element definition
                $definition .= $tabs . '}';
            }

            // if this is to be on a single line, collapse
            if ($this->options['oneline']) {
                $definition = $this->collapseInternalSpaces($definition);
                $strAtRules = $this->collapseInternalSpaces($strAtRules);
            }

            // if groups are to be output first, elements must be placed in a
            // different string which will be appended in the end
            if (isset($definition)) {
                if ($this->__get('groupsfirst') === true
                    && strpos($identifier, '@-') === false
                ) {
                    // add to elements
                    $strCssElements .= $lnEnd . $tabs . $definition . $lnEnd;
                } else {
                    // add to strCss
                    $strCss .= $lnEnd . $tabs . $definition . $lnEnd;
                }
            }
        }

        if ($this->__get('groupsfirst')) {
            $strCss .= $strCssElements;
        }

        $strAtRules = rtrim($strAtRules);
        if (!empty($strAtRules)) {
            $strAtRules .= $lnEnd;
        }
        $strCss = $strAtRules . $strCss;

        if ($this->options['oneline']) {
            $strCss = preg_replace('/(\n|\r\n|\r)/', '', $strCss);
        }

        return $strCss;
    }

    /**
     * Output CSS Code.
     *
     * Send the stylesheet content to standard output, handling cacheControl
     * and contentDisposition headers
     *
     * @return     void
     * @since      version 0.2.0 (2003-07-31)
     * @access     public
     * @see        toString()
     */
    function display()
    {
        if (!headers_sent()) {
            if ($this->__get('cache') !== true) {
                header("Expires: Tue, 1 Jan 1980 12:00:00 GMT");
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
                header("Cache-Control: no-cache");
                header("Pragma: no-cache");
            }

            // set character encoding
            header("Content-Type: text/css; charset=" . $this->__get('charset'));

            // set Content-Disposition
            if ($this->__get('contentDisposition') !== false) {
                header(
                    'Content-Disposition: inline; filename="' .
                    $this->__get('contentDisposition') . '"'
                );
            }
        }

        $strCss = $this->toString();
        print $strCss;
    }

    /**
     * Initialize Error engine preferences
     *
     * @param array $prefs (optional) hash of params to customize error generation
     *
     * @return     void
     * @since      version 0.3.3 (2004-05-20)
     * @access     private
     */
    function _initErrorStack($prefs = array())
    {
        // error message mapping callback
        if (isset($prefs['message_callback'])
            && is_callable($prefs['message_callback'])
        ) {
            $this->_callback_message = $prefs['message_callback'];
        } else {
            $this->_callback_message = array('HTML_CSS_Error', '_msgCallback');
        }

        // error context mapping callback
        if (isset($prefs['context_callback'])
            && is_callable($prefs['context_callback'])
        ) {
            $this->_callback_context = $prefs['context_callback'];
        } else {
            $this->_callback_context = array('HTML_CSS_Error', 'getBacktrace');
        }

        // determine whether to allow an error to be pushed or logged
        if (isset($prefs['push_callback'])
            && is_callable($prefs['push_callback'])
        ) {
            $this->_callback_push = $prefs['push_callback'];
        } else {
            $this->_callback_push = array('HTML_CSS_Error', '_handleError');
        }

        // determine whether to display or log an error by a free user function
        if (isset($prefs['error_callback'])
            && is_callable($prefs['error_callback'])
        ) {
            $this->_callback_error = $prefs['error_callback'];
        } else {
            $this->_callback_error = null;
        }

        // default error handler will use PEAR_Error
        if (isset($prefs['error_handler'])
            && is_callable($prefs['error_handler'])
        ) {
            $this->_callback_errorhandler = $prefs['error_handler'];
        } else {
            $this->_callback_errorhandler = array(&$this, '_errorHandler');
        }

        // any handler-specific settings
        if (isset($prefs['handler'])) {
            $this->_errorhandler_options = $prefs['handler'];
        }
    }

    /**
     * Standard error handler that will use PEAR_Error object
     *
     * To improve performances, the PEAR.php file is included dynamically.
     * The file is so included only when an error is triggered. So, in most
     * cases, the file isn't included and perfs are much better.
     *
     * @param integer $code   Error code.
     * @param string  $level  The error level of the message.
     * @param array   $params Associative array of error parameters
     *
     * @return     PEAR_Error
     * @since      version 1.0.0 (2006-06-24)
     * @access     private
     */
    function _errorHandler($code, $level, $params)
    {
        include_once 'HTML/CSS/Error.php';

        $mode    = call_user_func($this->_callback_push, $code, $level);
        $message = call_user_func($this->_callback_message, $code, $params);
        $options = $this->_callback_error;

        $userinfo['level'] = $level;

        if (isset($this->_errorhandler_options['display'])) {
            $userinfo['display'] = $this->_errorhandler_options['display'];
        } else {
            $userinfo['display'] = array();
        }
        if (isset($this->_errorhandler_options['log'])) {
            $userinfo['log'] = $this->_errorhandler_options['log'];
        } else {
            $userinfo['log'] = array();
        }

        return PEAR::raiseError(
            $message, $code, $mode, $options, $userinfo, 'HTML_CSS_Error'
        );
    }

    /**
     * A basic wrapper around the default PEAR_Error object
     *
     * This method is a wrapper that returns an instance of the configured
     * error class with this object's default error handling applied.
     *
     * @return     object    PEAR_Error when default error handler is used
     * @since      version 0.3.3 (2004-05-20)
     * @access     public
     * @see        _errorHandler()
     */
    function raiseError()
    {
        $args = func_get_args();
        $this->_lastError
            = call_user_func_array($this->_callback_errorhandler, $args);
        return $this->_lastError;
    }

    /**
     * Determine whether there is an error
     *
     * Determine whether last action raised an error or not
     *
     * @return     boolean               TRUE if error raised, FALSE otherwise
     * @since      version 1.0.0RC2 (2005-12-15)
     * @access     public
     */
    function isError()
    {
         $res              = (!is_bool($this->_lastError));
         $this->_lastError = false;
         return $res;
    }
}
?>