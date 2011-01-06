<?php
declare(ENCODING = 'iso-8859-1');
namespace HTML;

/**
 * Copyright (c) 2007, 2008 Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
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
 * PHP versions 5 and 6
 *
 * @category HTML
 * @package  \HTML\CSS3
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://www.opensource.org/licenses/bsd-license.php  New BSD License
 * @version  SVN: $Id$
 * @link     http://pear.php.net/package/\HTML\CSS3
 */

require_once 'HTML/Common3/Root/Style.php';

/**
 * class Interface for HTML_Common3
 */
require_once 'HTML/Common3/Face.php';

/**#@+
 * Basic error codes
 *
 * @var        integer
 */
define('CSS3_ERROR_UNKNOWN', -1);
define('CSS3_ERROR_INVALID_INPUT', -100);
define('CSS3_ERROR_INVALID_GROUP', -101);
define('CSS3_ERROR_NO_GROUP', -102);
define('CSS3_ERROR_NO_ELEMENT', -103);
define('CSS3_ERROR_NO_ELEMENT_PROPERTY', -104);
define('CSS3_ERROR_NO_FILE', -105);
define('CSS3_ERROR_WRITE_FILE', -106);
define('CSS3_ERROR_INVALID_SOURCE', -107);
define('CSS3_ERROR_INVALID_DEPS', -108);
define('CSS3_ERROR_NO_ATRULE', -109);
/**#@-*/

// {{{ \HTML\CSS3

/**
 * Base class for CSS definitions
 *
 * This class handles the details for creating properly
 * constructed CSS declarations.
 *
 * @category HTML
 * @package  \HTML\CSS3
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD
 * @link     http://pear.php.net/package/\HTML\CSS3
 */

class CSS3
extends \HTML\Common3\Root\Style
implements \HTML\Common3\Face
{
    // {{{ properties

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
     * @var      HTML_Common3_Collection
     * @access   protected
     * @see      __set(), __get()
     */
    protected $_options = null;

    /**
     * Contains the CSS definitions.
     *
     * @var      array
     * @access   private
     */
    private $_css = array();

    /**
     * Contains "alibis" (other elements that share a definition) of an element
     * defined in CSS
     *
     * @var      array
     * @access   private
     */
    private $_alibis = array();

    /**
     * Contains last assigned index for duplicate styles
     *
     * @var      array
     * @access   private
     */
    private $_duplicateCounter = 0;

    /**
     * Contains grouped styles
     *
     * @var      array
     * @access   private
     */
    private $_groups = array();

    /**
     * Number of CSS definition groups
     *
     * @var      integer
     * @access   private
     */
    private $_groupCount = 0;

    /**
     * SVN Version for this class
     *
     * @var     string
     * @access  protected
     */
    const VERSION = '$Id$';

    // }}} properties
    // {{{ __set

    /**
     * Sets the value of the attribute
     *
     * @param string $name  Attribute name
     * @param string $value Attribute value (will be set to $name if omitted)
     *
     * @return void
     * @access public
     * @see    setAttribute()
     */
    public function __set($name, $value)
    {
        $this->setOption($name, $value);

        return $this;
    }

    // }}} __set
    // {{{ __get

    /**
     * Returns the value of an attribute
     *
     * @param string $name Attribute name
     *
     * @return string|null Attribute value, null if attribute does not exist
     * @access public
     * @see    getAttribute()
     */
    public function __get($name)
    {
        return $this->getOption($name);
    }

    // }}} __get
    // {{{ apiVersion

    /**
     * Returns the current API version
     *
     * @access public
     * @return string
     * @static
     * @see    HTML_Common::apiVersion()
     *
     * @assert() === '3.0.0'
     */
    public static function apiVersion()
    {
        return '3.0.0';
    }

    // }}} apiVersion
    // {{{ initOptions

    /**
     * set/reset the options to default values
     *
     * @access protected
     * @return \HTML\CSS3
     */
    protected function initOptions()
    {
        //set the default options
        $this->_options = array(
            'charset' => 'iso-8859-1',
            'indent' => "    ",
            'linebreak' => "\12",
            'level' => 0,           //Identlevel
            'comment' => null,      //Comment
            'browser' => null,      //Browser properties
            'i18n' => null,         //I18Nv2_Negotiator Object
            'cache' => false,       //Caching
            'mime' => 'text/html',  //MIME type
            'oneline' => false,
            'contentdisposition' => false,
            'groupsfirst' => true,
            'allowduplicates' => false,
            'xhtml' => true
        );

        if ($this->_doctype['type'] == 'xhtml') {
            $this->_options['xhtml'] = true;
        } else {
            $this->_options['xhtml'] = false;
        }

        return $this;
    }

    // }}} initOptions
    // {{{ getOptions

    /**
     * Return all options for the class
     *
     * Return all configuration options at once
     *
     * @return array
     * @access public
     */
    public function getOptions()
    {
        return $this->_options;
    }

    // }}} getOptions
    // {{{ setOption

    /**
     * Sets a global option
     *
     * @param string $name  Option name
     * @param mixed  $value Option value
     *
     * @return \HTML\CSS3
     * @access public
     * @see    HTML_Common2::setOption()
     * @see    HTML_Common3::setOption()
     */
    public function setOption($name, $value)
    {
        if ($name == 'xhtml') {
            $root = $this->getRoot();

            if ($value) {
                $root->setDoctype('XHTML 1.0 Strict');
            } else {
                $root->setDoctype('HTML 4.01');
            }
        }

        if ($name == 'tab') {
            $name = 'indent';
        }

        if ($name == 'lineEnd') {
            $name = 'linebreak';
        }

        parent::setOption($name, $value);

        return $this;
    }

    // }}} setOption
    // {{{ getOption

    /**
     * Gets a global option
     *
     * @param string $name Option name
     *
     * @return mixed|null Option value, null if option does not exist
     * @access public
     * @see    HTML_Common2::getOption()
     * @see    HTML_Common3::getOption()
     *
     * @assert('foobar')    === null
     * @assert('charset')   ==  'utf-8'
     * @assert('indent')    ==  '    '
     * @assert('linebreak') ==  "\12"
     * @assert('level')     === 0
     * @assert('comment')   === null
     * @assert('browser')   === null
     * @assert('i18n')      === null
     * @assert('mime')      ==  'text/html'
     * @assert('cache')     === false
     */
    public function getOption($name)
    {
        if ($name == 'tab') {
            $name = 'indent';
        }

        if ($name == 'lineEnd') {
            $name = 'linebreak';
        }

        return parent::getOption($name);
    }

    // }}} getOption
    // {{{ setSingleLineOutput

    /**
     * Set oneline flag
     *
     * Determine whether definitions are output on a single line or multi lines
     *
     * @param bool $value flag to true if single line, false for multi lines
     *
     * @return \HTML\CSS3
     * @access public
     */
    public function setSingleLineOutput($value)
    {
        $this->setOption('oneline', (boolean) $value);

        return $this;
    }

    // }}} setSingleLineOutput
    // {{{ setOutputGroupsFirst

    /**
     * Set groupsfirst flag
     *
     * Determine whether groups are output before elements or not
     *
     * @param bool $value flag to true if groups are output before elements,
     *                    false otherwise
     *
     * @return \HTML\CSS3
     * @access public
     */
    public function setOutputGroupsFirst($value)
    {
        $this->setOption('groupsfirst', (boolean) $value);

        return $this;
    }

    // }}} setOutputGroupsFirst
    // {{{ parseSelectors

    /**
     * Parse a string containing selector(s)
     *
     * It processes it and returns an array or string containing
     * modified selectors (depends on XHTML compliance setting;
     * defaults to ensure lowercase element names)
     *
     * @param string  $selectors  Selector string
     * @param integer $outputMode (optional) 0 = string; 1 = array;
     *                            2 = deep array
     *
     * @return array|string
     * @access public
     */
    public function parseSelectors($selectors, $outputMode = 0)
    {
        if (!is_string($selectors)) {
            throw new \HTML\Common3\InvalidArgumentException(
                '\HTML\CSS3::parseSelectors() error: ' .
                'string required for parameter $selectors, ' .
                gettype($selectors) . ' given'
            );
        }

        if (!is_int($outputMode)) {
            throw new \HTML\Common3\InvalidArgumentException(
                '\HTML\CSS3::parseSelectors() error: ' .
                'integer required for parameter $outputMode, ' .
                gettype($outputMode) . ' given'
            );
        }

        if ($outputMode < 0 || $outputMode > 2) {
            throw new \HTML\Common3\InvalidArgumentException(
                '\HTML\CSS3::parseSelectors() error: ' .
                'values 0 | 1 | 2 expected for parameter $outputMode, ' .
                $outputMode . ' given'
            );
        }

        $selectors_array = explode(',', $selectors);
        $i               = 0;

        foreach ($selectors_array as $selector) {
            // trim to remove possible whitespace
            $selector = trim($this->collapseInternalSpaces($selector));
            if (strpos($selector, ' ')) {
                $sel_a = array();
                foreach (explode(' ', $selector) as $sub_selector) {
                    $sel_a[] = $this->parseSelectors($sub_selector,
                    $outputMode);
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

                $element = strtolower($element);
                $pseudo  = strtolower($pseudo);

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

    // }}} parseSelectors
    // {{{ setXhtmlCompliance

    /**
     * Sets XHTML compliance
     *
     * @param bool $value flag to true if XHTML compliance needed,
     *                    false otherwise
     *
     * @return     \HTML\CSS3
     * @access     public
     */
    function setXhtmlCompliance($value)
    {
        $this->setOption('xhtml', (boolean) $value);

        return $this;
    }

    // }}} setXhtmlCompliance
    // {{{ sortAtRules

    /**
     * sort and move simple declarative At-Rules to the top
     *
     * @return \HTML\CSS3
     * @access protected
     */
    protected function sortAtRules()
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

        return $this;
    }

    // }}} sortAtRules
    // {{{ getAtRulesList

    /**
     * Return list of supported At-Rules
     *
     * Return the list of supported At-Rules
     *
     * @return array
     * @access public
     */
    public function getAtRulesList()
    {
        $atRules = array(
            '@charset',
            '@font-face',
            '@import',
            '@media',
            '@page',
            '@namespace'
        );

        return $atRules;
    }

    // }}} getAtRulesList
    // {{{ createAtRule

    /**
     * Create a new simple declarative At-Rule
     *
     * Create a simple at-rule without declaration style blocks.
     * That include @charset, @import and @namespace
     *
     * @param string $atKeyword at-rule keyword
     * @param string $arguments argument list for @charset, @import or
     *                          @namespace
     *
     * @return \HTML\CSS3
     * @access public
     * @see    unsetAtRule()
     */
    public function createAtRule($atKeyword, $arguments = '')
    {
        if (!is_string($atKeyword)) {
            throw new \HTML\Common3\InvalidArgumentException(
                '\HTML\CSS3::createAtRule() error: ' .
                'string required for parameter $atKeyword, ' .
                gettype($atKeyword) . ' given'
            );
        }

        $allowed_atrules = array('@charset', '@import', '@namespace');

        if (!in_array(strtolower($atKeyword), $allowed_atrules)) {
            throw new \HTML\Common3\InvalidArgumentException(
                '\HTML\CSS3::createAtRule() error: ' .
                'value of (' . implode(' | ', $allowed_atrules) .
                ') required for parameter $atKeyword, ' . $atKeyword . ' given'
            );
        }

        if (!is_string($arguments)) {
            throw new \HTML\Common3\InvalidArgumentException(
                '\HTML\CSS3::createAtRule() error: ' .
                'string required for parameter $arguments, ' .
                gettype($arguments) . ' given'
            );
        }

        if (empty($arguments)) {
            throw new \HTML\Common3\InvalidArgumentException(
                '\HTML\CSS3::createAtRule() error: ' .
                'none empty value required for parameter $arguments, \'' .
                $arguments . '\' given'
            );
        }

        $atKeyword = strtolower((string) $atKeyword);

        if (in_array($atKeyword, $allowed_atrules)) {
            $arguments = (string) $arguments;

            if ($arguments != '') {
                $this->_css[$atKeyword] = array($arguments => '');
            }
        }

        return $this;
    }

    // }}} createAtRule
    // {{{ unsetAtRule

    /**
     * Remove an existing At-Rule
     *
     * Remove an existing and supported at-rule. See \HTML\CSS3::getAtRulesList()
     * for a full list of supported At-Rules.
     *
     * @param string $atKeyword at-rule keyword
     *
     * @return \HTML\CSS3
     * @access public
     */
    public function unsetAtRule($atKeyword)
    {
        if (!is_string($atKeyword)) {
            throw new \HTML\Common3\InvalidArgumentException(
                '\HTML\CSS3::unsetAtRule() error: ' .
                'string required for parameter $atKeyword, ' .
                gettype($atKeyword) . ' given'
            );
        }

        $allowed_atrules = $this->getAtRulesList();

        if (!in_array(strtolower($atKeyword), $allowed_atrules)) {
            throw new \HTML\Common3\InvalidArgumentException(
                '\HTML\CSS3::unsetAtRule() error: ' .
                'value of (' . implode(' | ', $allowed_atrules) .
                ') required for parameter $atKeyword, ' . $atKeyword . ' given'
            );
        }

        $atKeyword = strtolower((string) $atKeyword);

        if (!isset($this->_css[$atKeyword])) {
            throw new \HTML\Common3\InvalidArgumentException(
                '\HTML\CSS3::unsetAtRule() error: ' .
                'unknown @rule for parameter $atKeyword given'
            );
        }

        if (in_array($atKeyword, $allowed_atrules)) {
            unset($this->_css[$atKeyword]);
        }

        return $this;
    }

    // }}} unsetAtRule
    // {{{ setAtRuleStyle

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
     * @return \HTML\CSS3
     * @access public
     * @see    getAtRuleStyle()
     */
    public function setAtRuleStyle($atKeyword, $arguments, $selectors,
    $property, $value, $duplicates = null)
    {
        if (!is_string($atKeyword)) {
            throw new \HTML\Common3\InvalidArgumentException(
                '\HTML\CSS3::setAtRuleStyle() error: ' .
                'string required for parameter $atKeyword, ' .
                gettype($atKeyword) . ' given'
            );
        }

        $allowed_atrules = array('@media', '@page', '@font-face');
        $atKeyword       = strtolower((string) $atKeyword);

        if (!in_array($atKeyword, $allowed_atrules)) {
            throw new \HTML\Common3\InvalidArgumentException(
                '\HTML\CSS3::setAtRuleStyle() error: ' .
                'value of (' . implode(' | ', $allowed_atrules) .
                ') required for parameter $atKeyword, ' . $atKeyword . ' given'
            );
        }

        if (empty($arguments) && $atKeyword != '@font-face') {
            throw new \HTML\Common3\InvalidArgumentException(
                '\HTML\CSS3::setAtRuleStyle() error: ' .
                'not empty value for $atKeyword == ' . $atKeyword .
                ' required for parameter $arguments, \'' .
                $arguments . '\' given'
            );
        }

        if (!is_string($selectors)) {
            throw new \HTML\Common3\InvalidArgumentException(
                '\HTML\CSS3::setAtRuleStyle() error: ' .
                'string required for parameter $selectors, ' .
                gettype($selectors) . ' given'
            );
        }

        if (!is_string($property)) {
            throw new \HTML\Common3\InvalidArgumentException(
                '\HTML\CSS3::setAtRuleStyle() error: ' .
                'string required for parameter $property, ' .
                gettype($property) . ' given'
            );
        }

        if (!is_string($value)) {
            throw new \HTML\Common3\InvalidArgumentException(
                '\HTML\CSS3::setAtRuleStyle() error: ' .
                'string required for parameter $value, ' .
                gettype($value) . ' given'
            );
        }

        if (empty($property)) {
            throw new \HTML\Common3\InvalidArgumentException(
                '\HTML\CSS3::createAtRule() error: ' .
                'none empty value required for parameter $property, \'' .
                $property . '\' given'
            );
        }

        if (empty($value)) {
            throw new \HTML\Common3\InvalidArgumentException(
                '\HTML\CSS3::createAtRule() error: ' .
                'none empty value required for parameter $value, \'' .
                $value . '\' given'
            );
        }

        if (in_array($atKeyword, $allowed_atrules)) {
            $arguments = (string) $arguments;
            $selectors = (string) $selectors;
            $property  = (string) $property;
            $value     = (string) $value;

            if (($arguments != '' || $atKeyword == '@font-face') &&
                 $property != '' &&
                 $value != '') {

                if (!isset($duplicates)) {
                    $duplicates = $this->getOption('allowduplicates');
                } else {
                    $duplicates = (boolean) $duplicates;
                }

                //just to shorten the length of the command
                $a = $atKeyword;
                $b = $arguments;
                if ($selectors == '') {
                    $this->_css[$a][$b][$selectors][$property] = $value;
                } else {
                    $selectors = $this->parseSelectors($selectors, 1);

                    foreach ($selectors as $selector) {
                        $this->_css[$a][$b][$selector][$property] = $value;
                    }
                }
            }
        }

        return $this;
    }

    // }}} setAtRuleStyle
    // {{{ getAtRuleStyle

    /**
     * Get style value of an existing At-Rule
     *
     * Retrieve arguments or style value of an existing At-Rule.
     * See \HTML\CSS3::getAtRulesList() for a full list of supported At-Rules.
     *
     * @param string $atKeyword at-rule keyword
     * @param string $arguments argument list
     *                          (optional for @font-face)
     * @param string $selectors selectors of declaration style block
     *                          (optional for @media, @page, @font-face)
     * @param string $property  property of a single declaration style block
     *
     * @return null|string
     * @access public
     * @see    setAtRuleStyle()
     */
    public function getAtRuleStyle($atKeyword, $arguments, $selectors,
    $property)
    {
        $allowed_atrules = $this->getAtRulesList();

        $atKeyword = strtolower((string) $atKeyword);
        $val       = null;

        if (in_array($atKeyword, $allowed_atrules)) {
            $selectors = (string) $selectors;
            $property  = (string) $property;

            //just to shorten the length of the command
            $a = $atKeyword;
            $b = (string) $arguments;
            if (isset($this->_css[$a][$b][$selectors][$property])) {
                $val = $this->_css[$a][$b][$selectors][$property];
            }
        }

        return $val;
    }

    // }}} getAtRuleStyle
    // {{{ createGroup

    /**
     * Create a new CSS definition group
     *
     * Create a new CSS definition group. Return an integer identifying the
     * group.
     *
     * @param string $selectors Selector(s) to be defined, comma delimited.
     * @param mixed  $group     (optional) Group identifier. If not passed,
     *                          will return an automatically assigned integer.
     *
     * @return mixed
     * @access public
     * @see    unsetGroup()
     */
    public function createGroup($selectors, $group = null)
    {
        if (!isset($group)) {
            $this->_groupCount++;
            $group = $this->_groupCount;
        }

        $selectors = (string) $selectors;

        if (isset($this->_groups['@-' . $group])) {
            return $group;
        }


        $groupIdent = '@-' . $group;

        $selectors = $this->parseSelectors($selectors, 1);

        foreach ($selectors as $selector) {
            $this->_alibis[$selector][] = $groupIdent;
        }

        $this->_groups[$groupIdent] = $selectors;

        return $group;
    }

    // }}} createGroup
    // {{{ unsetGroup

    /**
     * Remove a CSS definition group
     *
     * Remove a CSS definition group. Use the same identifier as for group
     * creation.
     *
     * @param mixed $group CSS definition group identifier
     *
     * @return \HTML\CSS3
     * @access public
     * @see    createGroup()
     */
    public function unsetGroup($group)
    {
        $group      = (string) $group;
        $groupIdent = '@-' . $group;

        if (isset($this->_groups[$groupIdent])) {
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

        return $this;
    }

    // }}} unsetGroup
    // {{{ setGroupStyle

    /**
     * Set or add a CSS definition for a CSS group
     *
     * Define the new value of a property for a CSS group. The group should
     * exist.
     * If not, use function {@link \HTML\CSS3::createGroup()} first
     *
     * @param mixed  $group      CSS definition group identifier
     * @param string $property   Property defined
     * @param string $value      Value assigned
     * @param bool   $duplicates (optional) Allow or disallow duplicates.
     *
     * @return null|int Returns an integer if duplicates are allowed.
     * @access public
     * @see    getGroupStyle()
     */
    public function setGroupStyle($group, $property, $value, $duplicates = null)
    {
        $group      = (string) $group;
        $groupIdent = '@-' . $group;

        if (isset($this->_groups[$groupIdent])) {
            $property = (string) $property;
            $value    = (string) $value;

            if (!isset($duplicates)) {
                $duplicates = $this->getOption('allowduplicates');
            } else {
                $duplicates = (boolean) $duplicates;
            }

            if ($duplicates === true) {
                $this->_duplicateCounter++;

                $d = $this->_duplicateCounter;

                $this->_css[$groupIdent][$d][$property] = $value;
                return $this->_duplicateCounter;
            } else {
                $this->_css[$groupIdent][$property] = $value;
                return 0;
            }
        } else {
            return null;
        }
    }

    // }}} setGroupStyle
    // {{{ getGroupStyle

    /**
     * Return CSS definition for a CSS group
     *
     * Get the CSS definition for group created by setGroupStyle()
     *
     * @param mixed  $group    CSS definition group identifier
     * @param string $property Property defined
     *
     * @return array
     * @access public
     * @see    setGroupStyle()
     */
    public function getGroupStyle($group, $property)
    {
        $group      = (string) $group;
        $groupIdent = '@-' . $group;
        $styles     = array();

        if (isset($this->_groups[$groupIdent]) &&
        isset($this->_css[$groupIdent])) {
            $property = (string) $property;

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
        }

        return $styles;
    }

    // }}} getGroupStyle
    // {{{ addGroupSelector

    /**
     * Add a selector to a CSS definition group.
     *
     * @param mixed  $group     CSS definition group identifier
     * @param string $selectors Selector(s) to be defined, comma delimited.
     *
     * @return \HTML\CSS3
     * @access public
     */
    public function addGroupSelector($group, $selectors)
    {
        $group      = (string) $group;
        $groupIdent = '@-' . $group;

        if (isset($this->_groups[$groupIdent])) {
            $selectors = (string) $selectors;

            $newSelectors = $this->parseSelectors($selectors, 1);

            foreach ($newSelectors as $selector) {
                $this->_alibis[$selector][] = $groupIdent;
            }

            $oldSelectors = $this->_groups[$groupIdent];

            $this->_groups[$groupIdent] = array_merge($oldSelectors,
            $newSelectors);
        }

        return $this;
    }

    // }}} addGroupSelector
    // {{{ removeGroupSelector

    /**
     * Remove a selector from a group
     *
     * Definitively remove a selector from a CSS group
     *
     * @param mixed  $group     CSS definition group identifier
     * @param string $selectors Selector(s) to be removed, comma delimited.
     *
     * @return \HTML\CSS3
     * @access public
     */
    public function removeGroupSelector($group, $selectors)
    {
        $group      = (string) $group;
        $groupIdent = '@-' . $group;

        if (isset($this->_groups[$groupIdent])) {
            $selectors = (string) $selectors;

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

        return $this;
    }

    // }}} removeGroupSelector
    // {{{ setStyle

    /**
     * Set or add a CSS definition
     *
     * Add or change a single value for an element property
     *
     * @param string $element    a single Element (or class) to be defined
     * @param string $property   Property defined
     * @param string $value      Value assigned
     * @param bool   $duplicates (optional) Allow or disallow duplicates.
     *
     * @return null|integer
     * @access public
     * @see    getStyle()
     */
    public function setStyle($element, $property, $value, $duplicates = null)
    {
        $element  = (string) $element;
        $property = (string) $property;
        $value    = (string) $value;

        if (!isset($duplicates)) {
            $duplicates = $this->getOption('allowduplicates');
        } else {
            $duplicates = (boolean) $duplicates;
        }

        if (strpos($element, ',')) {
            // a group of elements is given
            //-> use the first element only
            $element = substr($element, 0, strpos($element, ','));
        }

        $element = $this->parseSelectors($element, 0);

        if ($duplicates === true) {
            $this->_duplicateCounter++;
            $this->_css[$element][$this->_duplicateCounter][$property] = $value;
            return $this->_duplicateCounter;
        } else {
            $this->_css[$element][$property] = $value;
            //var_dump($this->_css);
            return null;
        }
    }

    // }}} setStyle
    // {{{ getStyle

    /**
     * Return the value of a CSS property
     *
     * Get the value of a property to an identifed simple CSS element
     *
     * @param string $element  Element (or class) to be defined
     * @param string $property Property defined
     *
     * @return mixed
     * @access public
     * @see    setStyle()
     */
    public function getStyle($element, $property)
    {
        $element  = (string) $element;
        $property = (string) $property;


        if (!isset($this->_css[$element]) && !isset($this->_alibis[$element])) {
            return null;
        }

        if (isset($this->_alibis[$element])) {
            $lastImplementation = array_keys($this->_alibis[$element]);
            $lastImplementation = array_pop($lastImplementation);

            $group = substr($this->_alibis[$element][$lastImplementation], 2);

            $property_value = $this->getGroupStyle($group, $property);
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
            return null;
        }

        return $property_value;
    }

    // }}} getStyle
    // {{{ grepStyle

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
     * @throws     \HTML\CSS3_ERROR_INVALID_INPUT
     * @link       http://www.php.net/en/ref.pcre.php
     *             Regular Expression Functions (Perl-Compatible)
     */
    public function grepStyle($elmPattern, $proPattern = '')
    {
        if (is_int($elmPattern)) {
            return array();
        }

        $elmPattern = (string) $elmPattern;
        $proPattern = (string) $proPattern;

        $styles = array();

        // first, search inside alibis
        $alibis = array_keys($this->_alibis);
        $alibis = preg_grep($elmPattern, $alibis);

        foreach ($alibis as $a) {
            foreach ($this->_alibis[$a] as $g) {
                if (isset($proPattern) && $proPattern != '') {
                    $properties = array_keys($this->_css[$g]);

                    if ($proPattern == '') {
                        // no property pattern given
                        continue;
                    }

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

            if (isset($proPattern) && $proPattern != '') {
                $properties = array_keys($this->_css[$e]);

                if ($proPattern == '') {
                    // no property pattern given
                    continue;
                }

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

    // }}} grepStyle
    // {{{ setSameStyle

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
     * @return boolean FALSE in a case of an error, TRUE otherwise
     * @access public
     */
    public function setSameStyle($new, $old)
    {
        $new = (string) $new;
        $old = (string) $old;

        $old = $this->parseSelectors($old, 0);

        if (!isset($this->_css[$old])) {
            return false;
        }

        $selector = implode(', ', array($old, $new));
        $grp      = $this->createGroup($selector, 'samestyleas_' . $old);

        $others = $this->parseSelectors($new, 1);

        foreach ($others as $other) {
            $other = trim($other);

            if (isset($this->_css[$old])) {
                $keys  = array_keys($this->_css[$old]);
                //foreach ($this->_css[$old] as $rank => $property) {
                foreach ($keys as $rank) {
                    $property = $this->_css[$old][$rank];

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

        return true;
    }

    // }}} setSameStyle
    // {{{ setCache

    /**
     * Set cache flag
     *
     * Define if the document should be cached by the browser. Default to false.
     *
     * @param bool $cache (optional) flag to true to cache result, false
     *                    otherwise
     *
     * @return \HTML\CSS3
     * @access public
     */
    public function setCache($cache = true)
    {
        $this->setOption('cache', (boolean) $cache);

        return $this;
    }

    // }}} setCache
    // {{{ getCache

    /**
     * Returns the cache option value
     *
     * @return boolean
     * @access public
     * @see    setCache()
     */
    public function getCache()
    {
        return $this->getOption('cache');
    }

    // }}} getCache
    // {{{ setContentDisposition

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
     * @return \HTML\CSS3
     * @access public
     * @see    getContentDisposition()
     * @link   http://pear.php.net/bugs/bug.php?id=12195 Patch by Carsten Wiedmann
     */
    public function setContentDisposition($enable = true, $filename = '')
    {
        $enable   = (boolean) $enable;
        $filename = (string) $filename;

        if ($enable === false) {
            $filename = false;
        } elseif ($filename == '') {
            $filename = basename($_SERVER['PHP_SELF']) . '.css';
        }

        $this->setOption('contentDisposition', $filename);

        return $this;
    }

    // }}} setContentDisposition
    // {{{ getContentDisposition

    /**
     * Return the Content-Disposition header
     *
     * Get value of Content-Disposition header (inline filename) used
     * to display results
     *
     * @return string|boolean boolean FALSE if no content disposition, otherwise
     *                        string for inline filename
     * @access public
     * @see    setContentDisposition()
     * @link   http://pear.php.net/bugs/bug.php?id=12195 Patch by Carsten Wiedmann
     */
    public function getContentDisposition()
    {
        return $this->getOption('contentDisposition');
    }

    // }}} getContentDisposition
    // {{{ setCharset

    /**
     * Set charset value
     *
     * Define the charset for the file. Default to ISO-8859-1 because of CSS1
     * compatability issue for older browsers.
     *
     * @param string $type (optional) Charset encoding; defaults to ISO-8859-1.
     *
     * @return \HTML\CSS3
     * @access public
     * @see    getCharset()
     */
    public function setCharset($type = 'iso-8859-1')
    {
        $this->setOption('charset', (string) $type);

        return $this;
    }

    // }}} setCharset
    // {{{ getCharset

    /**
     * Return the charset encoding string
     *
     * By default, \HTML\CSS3 uses iso-8859-1 encoding.
     *
     * @return string
     * @access public
     * @see    setCharset()
     */
    public function getCharset()
    {
        return $this->getOption('charset');
    }

    // }}} getCharset
    // {{{ parseString

    /**
     * Parse a string
     *
     * Parse a string that contains CSS information
     *
     * @param string $str        text string to parse
     * @param bool   $duplicates (optional) Allows or disallows
     *                           duplicate style definitions
     *
     * @return \HTML\CSS3
     * @access public
     * @see    createGroup(), setGroupStyle(), setStyle()
     */
    public function parseString($str, $duplicates = null)
    {
        $str = (string) $str;

        if (!isset($duplicates)) {
            $duplicates = $this->getOption('allowduplicates');
        } else {
            $duplicates = (boolean) $duplicates;
        }

        // Remove comments
        $str = preg_replace("/\/\*(.*)?\*\//Usi", '', $str);

        // Protect parser vs IE hack
        $str = str_replace('"\"}\""', '#34#125#34', $str);

        // Parse simple declarative At-Rules
        $atRules = array();
        if (preg_match_all('/^\s*(@[a-z\-]+)\s+(.+);\s*$/m', $str, $atRules,
            PREG_SET_ORDER)) {
            foreach ($atRules as $value) {
                $this->createAtRule(trim($value[1]), trim($value[2]));
            }
            $str = preg_replace('/^\s*@[a-z\-]+\s+.+;\s*$/m', '', $str);
        }

        $elements   = array();
        $properties = array();

        // Parse each element of csscode
        $parts = explode("}", $str);
        foreach ($parts as $part) {
            $part = trim($part);
            if (strlen($part) == 0) {
                continue;
            }
            // prevent invalide css data structure
            $pos = strpos($part, '{');
            if (strpos($part, '{', $pos + 1) !== false && $part{0} !== '@') {

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

                throw new \HTML\Common3\InvalidArgumentException(
                    '\HTML\CSS3::parseString() error: ' .
                    'Invalid CSS structure (invalid data source) ' .
                    'given in parameter $' . $var
                );
            }

            $parse = preg_split('/\{(.*)\}/', "$part }", -1,
                         PREG_SPLIT_DELIM_CAPTURE);

            if (count($parse) == 1) {
                list($keystr, $codestr) = explode("{", $part);
                $elements[]             = trim($keystr);
                $properties[]           = trim($codestr);
            } else {
                for ($i = 0; $i < 2; $i++) {
                    if ($i == 0) {
                        $part = ltrim($parse[$i], "\r\n}");
                        $pos  = strpos($part, '{');
                        if ($pos === false) {
                            $elements[] = trim($part);
                        } else {
                            // Remove eol
                            $part = preg_replace("/\r?\n?/", '', $part);

                            if (strpos($part, '}', $pos+1) === false) {
                                // complex declaration block style (nested)
                                list($keystr, $codestr) = explode("{", $part);
                                $elements[]             = trim($part);
                            } else {
                                // simple declaration block style
                                $parse = preg_split('/\{(.*)\}/', "$part }",
                                -1, PREG_SPLIT_DELIM_CAPTURE);

                                $elements[]   = trim($parse[0]);
                                $properties[] = trim($parse[1]);
                            }
                        }
                    } else {
                        $properties[] = trim($parse[$i]);
                    }
                }
            }
        }

        foreach ($elements as $i => $keystr) {
            if (strpos($keystr, '{') === false) {
                $nested_bloc = false;
            } else {
                $nested_bloc = true;

                list($keystr, $nestedsel) = explode("{", $keystr);
            }

            $key_a   = $this->parseSelectors($keystr, 1);
            $keystr  = implode(', ', $key_a);
            $codestr = $properties[$i];

            // Check if there are any groups; in standard selectors exclude
            // at-rules
            if (strpos($keystr, ',') && $keystr{0} !== '@') {
                $group = $this->createGroup($keystr);

                // Parse each property of an element
                $codes = explode(";", trim($codestr));
                foreach ($codes as $code) {
                    if (strlen(trim($code)) > 0) {
                        // find the property and the value
                        $property = trim(substr($code, 0,
                        strpos($code, ':', 0)));
                        $value    = trim(substr($code,
                        strpos($code, ':', 0) + 1));

                        // IE hack only
                        if (strcasecmp($property, 'voice-family') == 0) {
                            $value = str_replace('#34#125#34', '"\"}\""',
                            $value);
                        }

                        $this->setGroupStyle($group, $property, $value,
                            $duplicates);
                    }
                }
            } else {
                // let's get on with regular definitions
                $key = trim($keystr);

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
                        $v = str_replace('#34#125#34', '"\"}\""',
                                     $v);
                    }

                    if ($key{0} == '@') {
                        // at-rules
                        list($atKeyword, $arguments) = explode(' ', "$key ");
                        if ($nested_bloc) {
                            $this->setAtRuleStyle($atKeyword, $arguments,
                            $nestedsel, $p, $v, $duplicates);
                        } else {
                            $this->setAtRuleStyle($atKeyword, $arguments,
                            '', $p, $v, $duplicates);
                        }

                    } else {
                        // simple declarative style
                        $this->setStyle($key, $p, $v, $duplicates);
                    }
                }
            }
        }

        return $this;
    }

    // }}} parseString
    // {{{ parseFile

    /**
     * Parse file content
     *
     * Parse a file that contains CSS information
     *
     * @param string $filename   file to parse
     * @param bool   $duplicates (optional) Allow or disallow duplicates.
     *
     * @return \HTML\CSS3|PEAR_Error
     * @access public
     * @throws \HTML\CSS3_ERROR_NO_FILE
     * @see    parseString()
     */
    public function parseFile($filename, $duplicates = null)
    {
        $filename = (string) $filename;

        if (!isset($duplicates)) {
            $duplicates = $this->getOption('allowduplicates');
        } else {
            $duplicates = (boolean) $duplicates;
        }

        if (!file_exists($filename)) {
            throw new \HTML\Common3\InvalidArgumentException(
                "file $filename does not exist"
            );
            //return $this->raiseCssError(CSS3_ERROR_NO_FILE, 'error',
            //        array('identifier' => $filename));
        }

        $fileContent = file_get_contents($filename);
        $this->parseString($fileContent, $duplicates);

        return $this;
    }

    // }}} parseFile
    // {{{ parseData

    /**
     * Parse multiple data sources
     *
     * Parse data sources, file(s) or string(s), that contains CSS information
     *
     * @param array $styles     data sources to parse
     * @param bool  $duplicates (optional) Allow or disallow duplicates.
     *
     * @return     \HTML\CSS3
     * @access     public
     * @see        parseString(), parseFile()
     */
    public function parseData($styles, $duplicates = null)
    {
        if (!is_array($styles)) {
            $styles = array((string) $styles);
        }

        if (!isset($duplicates)) {
            $duplicates = $this->getOption('allowduplicates');
        } else {
            $duplicates = (boolean) $duplicates;
        }

        foreach ($styles as $i => $style) {
            $style = (string) $style;

            if (strcasecmp(substr($style, -4, 4), '.css') == 0) {
                $this->parseFile($style, $duplicates);
            } else {
                $this->parseString($style, $duplicates);
            }
        }

        return $this;
    }

    // }}} parseData
    // {{{ validate

    /**
     * Validate a CSS data source
     *
     * Execute the W3C CSS validator service on each data source (filename
     * or string) given by parameter $styles.
     *
     * @param array   $styles       Data sources to check validity
     * @param array   &$messages    Error and Warning messages
     *                              issue from W3C CSS validator service
     * @param boolean $showWarnings TRUE, to show the warnings
     *
     * @return boolean|null
     * @access public
     * @throws \HTML\CSS3_ERROR_INVALID_DEPS, \HTML\CSS3_ERROR_INVALID_SOURCE
     */
    public function validate($styles, &$messages, $showWarnings = true)
    {
        $php = phpversion();
        if (version_compare($php, '5.0.0', '<')) {
            return $this->raiseCssError(\HTML\CSS3_ERROR_INVALID_DEPS, 'exception',
                array('funcname' => __FUNCTION__,
                      'dependency' => 'PHP 5',
                      'currentdep' => "PHP $php"));
        }
        @require_once 'Services/W3C/CSSValidator.php';
        if (class_exists('Services_W3C_CSSValidator', false) === false) {
            return $this->raiseCssError(\HTML\CSS3_ERROR_INVALID_DEPS, 'exception',
                array('funcname' => __FUNCTION__,
                      'dependency' => 'PEAR::Services_W3C_CSSValidator',
                      'currentdep' => 'nothing'));
        }
        if (!is_array($styles)) {
            $styles = array((string) $styles);
        } elseif (!is_array($messages)) {
            $messages = array((string) $messages);
        }

        // prepare to call the W3C CSS validator service
        $v        = new \Services_W3C_CSSValidator();
        $validity = true;
        $messages = array('errors' => array(), 'warnings' => array());

        $countErrors   = 0;
        $countWarnings = 0;

        foreach ($styles as $i => $source) {
            $source = (string) $source;

            //var_dump($source);

            if (strcasecmp(substr($source, -4, 4), '.css') == 0) {
                // validate a file as CSS content
                $r      = $v->validateFile($source);
                $isFile = true;
            } else {
                // validate a string as CSS content
                if (version_compare(PHP_VERSION, '5.9.9', '>')) {
                    $source = (binary) $source;
                }

                $r      = $v->validateFragment($source);
                $isFile = false;
            }

            if ($r === false) {
                $validity = false;
            } elseif ($r->isValid() === false) {
                $validity = false;

                $showWarnings = (boolean) $showWarnings;

                foreach ($r->errors as $error) {
                    $properties = get_object_vars($error);

                    if (is_array($properties) && count($properties) > 0) {
                        $messages['errors'][$countErrors] = $properties;

                        if ($isFile === true) {
                            $messages['errors'][$countErrors]['file'] = $source;
                        }

                        $countErrors++;
                    }
                }

                if ($showWarnings === true) {
                    foreach ($r->warnings as $warning) {
                        $properties = get_object_vars($warning);

                        if (is_array($properties) && count($properties) > 0) {
                            $messages['warnings'][$countWarnings] = $properties;

                            if ($isFile === true) {
                                $messages['warnings'][$countWarnings]['file'] =
                                $source;
                            }

                            $countWarnings++;
                        }
                    }
                }

                $this->raiseCssError(\HTML\CSS3_ERROR_INVALID_SOURCE,
                    ((count($r->errors) == 0) ? 'warning' : 'error'),
                    array('sourcenum' => $i,
                          'errcount' => count($r->errors),
                          'warncount' => count($r->warnings)));
            }
        }

        return $validity;
    }

    // }}} validate
    // {{{ toArray

    /**
     * Return the CSS contents in an array
     *
     * Return the full contents of CSS data sources (parsed) in an array
     *
     * @return array
     * @access public
     */
    public function toArray()
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

    // }}} toArray
    // {{{ toInline

    /**
     * Return a string-properties for style attribute of an HTML element
     *
     * Generate and return the CSS properties of an element or class
     * as a string for inline use.
     *
     * @param string $element Element or class
     *                        for which inline CSS should be generated
     *
     * @return     string
     * @access     public
     */
    public function toInline($element)
    {
        $element = (string) $element;

        if (!isset($this->_alibis[$element]) && !isset($this->_css[$element])) {
            return '';
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

    // }}} toInline
    // {{{ toFile

    /**
     * Generate CSS and stores it in a file
     *
     * Generate current parsed CSS data sources and write result in a user file
     *
     * @param string $filename Name of file that content the stylesheet
     *
     * @return     string
     * @access     public
     * @throws     \HTML\CSS3_ERROR_WRITE_FILE
     * @see        toHtml()
     */
    public function toFile($filename)
    {
        $filename = (string) $filename;
        $content  = $this->toHtml(0, false, false, false);

        if (function_exists('file_put_contents')) {
            file_put_contents($filename, $content);
        } else {
            $file = fopen($filename, 'wb');
            fwrite($file, $content);
            fclose($file);
        }

        if (!file_exists($filename)) {
            return $this->raiseCssError(\HTML\CSS3_ERROR_WRITE_FILE, 'error',
                    array('filename' => $filename));
        }

        //return $filename;
    }

    // }}} toFile
    // {{{ toString

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
     * @see    HTML_CSS::toString()
     */
    public function toString()
    {
        return $this->toHtml(0, false, false, false);
    }

    // }}} toString
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
     * @see    HTML_Common2::toHtml()
     */
    public function toHtml($step = 0, $dump = false, $comments = false,
                           $levels = true)
    {
        return $this->writeInner($dump, $comments, $levels);
    }

    // }}} toHtml
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
        // get line endings
        $lnEnd = $this->getLineEnd();
        $tabs  = $this->getTabs();
        $tab   = $this->getTab();

        // initialize $alibis
        $alibis = array();

        $strCss     = '';
        $strAtRules = '';

        // Allow a CSS comment
        $comment = $this->getComment();
        if ($comment) {
            $strCss = $tabs . '/* ' . $comment . ' */' . $lnEnd;
        }

        // If groups are to be output first, initialize a special variable
        if ($this->getOption('groupsfirst')) {
            $strCssElements = '';
        }

        // bring AtRules in correct order
        $this->sortAtRules();

        $oneLine = $this->getOption('oneline');

        // Iterate through the array and process each element
        foreach ($this->_css as $identifier => $rank) {
            // Groups are handled separately
            if (strpos($identifier, '@-') !== false) {
                // its a group
                $element = implode(', ', $this->_groups[$identifier]);
            } else {
                $element = $identifier;
            }

            $definition = null;

            if ((0 === strpos($element, '@')) &&
                (1 !== strpos($element, '-'))) {
                // simple declarative At-Rule definition

                foreach ($rank as $arg => $decla) {
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
                                $strAtRules .= $t . $p . ': ' . $v . ';'
                                            . $lnEnd;
                            }
                            if (empty($s)) {
                                $strAtRules .= $tabs . '}';
                            } else {
                                $strAtRules .=  $tabs . $tab . '}'
                                            . $lnEnd . '}';
                            }
                        }
                        $strAtRules .=  $lnEnd . $lnEnd;;
                    } else {
                        $strAtRules .= $element . ' ' . $arg . ';' . $lnEnd
                                    . $lnEnd;
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
            if ($oneLine) {
                $definition = $this->collapseInternalSpaces($definition);
                $strAtRules = $this->collapseInternalSpaces($strAtRules);
            }

            // if groups are to be output first, elements must be placed in a
            // different string which will be appended in the end
            if (isset($definition)) {
                if ($this->getOption('groupsfirst')
                    && strpos($identifier, '@-') === false) {
                    // add to elements
                    $strCssElements .= $lnEnd . $tabs . $definition . $lnEnd;
                } else {
                    // add to strCss
                    $strCss .= $lnEnd . $tabs . $definition . $lnEnd;
                }
            }
        }

        if ($this->getOption('groupsfirst')) {
            $strCss .= $strCssElements;
        }

        $strAtRules = rtrim($strAtRules);
        if (!empty($strAtRules)) {
            $strAtRules .= $lnEnd;
        }
        $strCss = $strAtRules . $strCss;

        if ($oneLine) {
            $strCss = preg_replace('/(\n|\r\n|\r)/', '', $strCss);
        }

        return $strCss;
    }

    // }}} writeInner
    // {{{ display

    /**
     * Output CSS Code.
     *
     * Send the stylesheet content to standard output, handling cacheControl
     * and contentDisposition headers
     *
     * @return     void
     * @access     public
     * @see        writeInner()
     */
    public function display()
    {
        $this->displayInner();
    }

    // }}} display
    // {{{ displayInner

    /**
     * Output CSS Code.
     *
     * Send the stylesheet content to standard output, handling cacheControl
     * and contentDisposition headers
     *
     * @return void
     * @access public
     */
    public function displayInner()
    {
        if (!headers_sent()) {
            $this->setDisplayHeaders();

            // set Content-Disposition
            $cd = $this->getOption('contentDisposition');
            if ($cd) {
                header('Content-Disposition: inline; filename="' . $cd . '"');
            }
        }
        $strCss = $this->writeInner();

        // Output to browser, screen or other default device
        print $strCss;
    }

    // }}} displayInner
    // {{{ getMime

    /**
     * returns the document MIME encoding that is sent to the browser.
     *
     * @return string
     * @access public
     * @see    getMimeEncoding()
     *
     * @assert() === 'text/css'
     */
    public function getMime()
    {
        return 'text/css';
    }

    // }}} getMime
    // {{{ getContentType

    /**
     * returns the Content type
     *
     * @access protected
     * @return string
     */
    protected function getContentType()
    {
        return 'Content-Type: text/css; charset=' . $this->getCharset();
    }

    // }}} getContentType
}

// }}} \HTML\CSS3

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */