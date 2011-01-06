<?php
declare(ENCODING = 'iso-8859-1');
namespace HTML\Common3\Root;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * \HTML\Common3\Root\If: Class for Conditional Comments
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

// {{{ \HTML\Common3\Root\If

/**
 * Class for Conditional Comments
 *
 * @category HTML
 * @package  \HTML\Common3\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/\HTML\Common3\
 */
class IfHtmlextends \HTML\Common3\Textimplements \HTML\Common3\Face
{
    // {{{ properties

    /**
     * HTML Tag of the Element
     *
     * @var      string
     * @access   protected
     */
    protected $_elementName = 'if';

    /**
     * Array of HTML Elements which are possible as child elements
     *
     * @var      array
     * @access   protected
     */
    protected $_posElements = array(
        '#all' => array(
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
            'address',
            'blockquote',
            'center',
            'div',
            'dl',
            'fieldset',
            'form',
            'h1',
            'h2',
            'h3',
            'h4',
            'h5',
            'h6',
            'hr',
            'menu',
            'ol',
            'p',
            'pre',
            'table',
            'ul'
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
            'if'
        )
    );

    /**
     * condition for this element
     *
     * @var      string
     * @access   protected
     * @see      setCondition()
     * @see      getCondition()
     */
    protected $_condition = 'if IE';

    /**
     * defines, if the output should be valid (X)HTML
     *
     * @var      boolean
     * @access   protected
     * @see      setValid()
     * @see      getValid()
     */
    protected $_makeValid = true;

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
     * @access public
     * @return \HTML\Common3\Root\Html
     */
    public function __construct($attributes = null,
    \HTML\Common3 $parent = null, \HTML\Common3 $html = null)
    {
        $attributes = $this->parseAttributes($attributes);

        parent::__construct($attributes, $parent, $html);

        if (isset($attributes['CONDITION']) && $attributes['CONDITION'] != '') {
            $this->setCondition($attributes['CONDITION']);
        }
    }

    // }}} __construct
    // {{{ setCondition

    /**
     * sets the condition for this element
     *
     * @param string $condition condition for this element
     *
     * @access public
     * @return \HTML\Common3\Root\If
     */
    public function setCondition($condition = 'if IE')
    {
        $allConditions = array(
            //general IE
            'if IE',
            //equal version
            'if IE 5',
            'if IE 5.0',
            'if IE 5.5',
            'if IE 6',
            'if IE 7',
            'if IE 8',
            'if eq IE 5',
            'if eq IE 5.0',
            'if eq IE 5.5',
            'if eq IE 6',
            'if eq IE 7',
            'if eq IE 8',
            //not version
            'if !IE 5',
            'if !IE 5.0',
            'if !IE 5.5',
            'if !IE 6',
            'if !IE 7',
            'if !IE 8',
            //lower than version
            'if lt IE 5',
            'if lt IE 5.0',
            'if lt IE 5.5',
            'if lt IE 6',
            'if lt IE 7',
            'if lt IE 8',
            //lower or equal than version
            'if lte IE 5',
            'if lte IE 5.0',
            'if lte IE 5.5',
            'if lte IE 6',
            'if lte IE 7',
            'if lte IE 8',
            //greater than version
            'if gt IE 5',
            'if gt IE 5.0',
            'if gt IE 5.5',
            'if gt IE 6',
            'if gt IE 7',
            'if gt IE 8',
            //greater or equal than version
            'if gte IE 5',
            'if gte IE 5.0',
            'if gte IE 5.5',
            'if gte IE 6',
            'if gte IE 7',
            'if gte IE 8'
        );

        $condition = (string) $condition;

        if (in_array($condition, $allConditions)) {
            $this->condition = (string) $condition;

            $this->setComment('Contitional Comment with condition [' . $condition .
            ']');
        }

        return $this;
    }

    // }}} setCondition
    // {{{ getCondition

    /**
     * returns the condition of this element
     *
     * @access public
     * @return string
     */
    public function getCondition()
    {
        return (string) $this->condition;
    }

    // }}} getCondition
    // {{{ setValid

    /**
     * sets the condition for a valid output
     *
     * @param boolean $valid TRUE if the output should be valid
     *
     * @access public
     * @return \HTML\Common3\Root\If
     */
    public function setValid($valid = true)
    {
        $this->makeValid = (boolean) $valid;

        return $this;
    }

    // }}} setValid
    // {{{ getValid

    /**
     * returns the condition of this element for a valid output
     *
     * @access public
     * @return boolean
     */
    public function getValid()
    {
        return (boolean) $this->makeValid;
    }

    // }}} getValid
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
        $txt  = '';
        $root = $this->getRoot();

        $usedBrowser = $root->_options['browser'];

        if ($usedBrowser) {
            $browser = $usedBrowser->browser;
        } else {
            $browser = null;
        }

        $docType = $root->getDoctype(false);

        if (($docType['type'] == 'xhtml' ||
            $docType['variant'] == 'strict' ||
            $browser != 'IE') &&
            $this->getValid() === true) {

            // XHTML or strict Mode or no IE
            //-> do not output the Condition for an valid document

            $output = false;

            if (isset($usedBrowser->majorver)) {
                $major = $usedBrowser->majorver;
            } else {
                $major = 0;
            }
            //$minor   = $usedBrowser->minorver;
            if (isset($usedBrowser->version)) {
                $version = $usedBrowser->version;
            } else {
                $version = 0;
            }

            $formula = "'" . $browser . "'=='IE'";
            $cond    = $this->getCondition();

            if ($cond != 'if IE') {
                $formula .= " && '";

                $cond = str_replace('if IE ', 'if eq IE ', $cond);
                $cond = str_replace('if ', '', $cond);
                $cond = str_replace('IE ', '', $cond);

                if (substr($cond, 0, 2) == '! ') {
                    //skelleton from NOT clause
                    if ($cond == '!5.0' || $cond == '!5.5') {
                        $formula .= $version ."'!='" . substr($cond, -3, 3) . "'";
                    } else {
                        $formula .= $major ."'!='" .
                        substr($cond, -1 * strlen($major), strlen($major)) . "'";
                    }
                } elseif (substr($cond, 0, 3) == 'eq ') {
                    //skelleton from EQUAL clause
                    if ($cond == 'eq 5.0' || $cond == 'eq 5.5') {
                        $formula .= $version ."'=='" . substr($cond, -3, 3) . "'";
                    } else {
                        $formula .= $major ."'=='" .
                        substr($cond, -1 * strlen($major), strlen($major)) . "'";
                    }
                } elseif (substr($cond, 0, 3) == 'lt ') {
                    //skelleton from Lower clause
                    if ($cond == 'lt 5.0' || $cond == 'lt 5.5') {
                        $formula .= $version ."'<'" . substr($cond, -3, 3) . "'";
                    } else {
                        $formula .= $major ."'<'" .
                        substr($cond, -1 * strlen($major), strlen($major)) . "'";
                    }
                } elseif (substr($cond, 0, 3) == 'gt ') {
                    //skelleton from Lower Or Equal clause
                    if ($cond == 'gt 5.0' || $cond == 'gt 5.5') {
                        $formula .= $version ."'>'" . substr($cond, -3, 3) . "'";
                    } else {
                        $formula .= $major ."'>'" .
                        substr($cond, -1 * strlen($major), strlen($major)) . "'";
                    }
                } elseif (substr($cond, 0, 4) == 'lte ') {
                    //skelleton from Greater clause
                    if ($cond == 'lte 5.0' || $cond == 'lte 5.5') {
                        $formula .= $version ."'<='" . substr($cond, -3, 3) . "'";
                    } else {
                        $formula .= $major ."'<='" .
                        substr($cond, -1 * strlen($major), strlen($major)) . "'";
                    }
                } elseif (substr($cond, 0, 4) == 'gte ') {
                    //skelleton from Greater or Equal clause
                    if ($cond == 'gte 5.0' || $cond == 'gte 5.5') {
                        $formula .= $version ."'>='" . substr($cond, -3, 3) . "'";
                    } else {
                        $formula .= $major ."'>='" .
                        substr($cond, -1 * strlen($major), strlen($major)) . "'";
                    }
                } else {
                     $formula .= $browser ."'==''";
                }
            }
            //var_dump($formula);
            $formula     = 'return (' . $formula . ');';
            $outputInner = (boolean) eval($formula);
        } else {
            // HTML and not strict Mode
            //-> output the Condition
            //-> creates an invalid document

            $output      = true;
            $outputInner = true;
        }

        $begin_txt = '';
        $lineEnd   = $root->getOption('linebreak');

        if ($levels) {
            $this->changeLevel($this->getIndentLevel(), false);
            $begin_txt .= $this->getIndent();

            if ($output !== true) {
                $this->changeLevel($this->getIndentLevel() - 1, true);
            }
        }

        $comment = $this->getComment();

        if (!$comment && $dump === true) {
            $comment = 'if';
        }

        if ($comment || $dump === true) {
            $showComment = true;

            $txt .= $begin_txt . "<!-- " . $comment . " - start -->" . $lineEnd;
        } else {
            $showComment = false;
        }

        $output = ($output === true || $dump === true);
        if ($output) {
            $txt .= $begin_txt . '<!--[' . $this->getCondition() . ']>' . $lineEnd;
        }

        $count = count($this->_elements);

        if (!$count) {
            $txt .= $begin_txt;
        }

        //var_dump($outputInner);
        if ($outputInner) {
            $txt .= $this->writeInner($dump, !$output, $levels);
        }

        if (!$count) {
            $txt .= $lineEnd;
        }

        if ($output) {
            $txt .= $begin_txt . '<![endif]-->' . $lineEnd;
        }

        if ($showComment === true) {
            $txt .= $begin_txt . "<!-- " . $comment . " - end -->" . $lineEnd;
        }

        return $txt;
    }

    // }}} toHtml
}

// }}} \HTML\Common3\Root\If

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */