<?php
declare(ENCODING = 'utf-8');
namespace HTML\Common3\Root;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * \HTML\Common3\Root\Table: Class for HTML <table> Elements
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

require_once 'HTML/Common3/Table/Root.php';

/**
 * class Interface for \HTML\Common3\
 */
require_once 'HTML/Common3/Face.php';

// {{{ \HTML\Common3\Root\Table

/**
 * Class for HTML <table> Elements
 *
 * @category HTML
 * @package  \HTML\Common3\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/\HTML\Common3\
 */
class Tableextends \HTML\Common3\Table\Rootimplements \HTML\Common3\Face
{
    // {{{ properties

    /**
     * HTML Tag of the Element
     *
     * @var      string
     * @access   protected
     */
    protected $_elementName = 'table';

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
    protected $_watchedAttributes = array();

    /**
     * Array of HTML Elements which are possible as child elements
     *
     * @var      array
     * @access   protected
     */
    protected $_posElements = array(
        '#all' => array(
            'caption',
            'colgroup',
            'tbody',
            'thead',
            'tfoot'//,
            //'col',    // do not use directly here, use it inside colgroup only
            //'tr'      // do not use directly here, use it inside tbody, thead or tfoot only
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
            'border',
            'cellpadding',
            'cellspacing',
            'frame',
            'rules',
            'summary',
            'width'
        ),
        'html' => array(
            '#all' => array(
                'lang'
            ),
            '4.01' => array(
                'frameset' => array(
                    'align',
                    'bgcolor'
                ),
                'transitional' => array(
                    'align',
                    'bgcolor'
                )
            ),
            '5.0' => array(
                'transitional' => array(
                    'align',
                    'bgcolor'
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
                    'align',
                    'bgcolor'
                ),
                'transitional' => array(
                    'align',
                    'bgcolor'
                )
            )
        )
    );

    /**
     * Array of all col groups in this table
     *
     * @var      array
     * @access   protected
     */
    protected $_colgroups = array();

    /**
     * pointer to the caption of this table
     *
     * @var      pointer
     * @access   protected
     */
    protected $_caption = null;

    /**
     * array of all row groups including thead and tfoot (also if they aren't
     * needed)
     *
     * @var      array
     * @access   protected
     */
    protected $_tRowGroups = array();

    /**
     * count of all table bodies
     *
     * @var      integer
     * @access   protected
     */
    protected $_tbodyCount = 0;

    /**
     * SVN Version for this class
     *
     * @var     string
     * @access  protected
     */
    const VERSION = '$Id$';

    // }}} properties
    // {{{ global Functions, inherited
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
     * @return \HTML\Common3\Root\Table
     */
    public function __construct($attributes = null,
    \HTML\Common3 $parent = null, \HTML\Common3 $html = null)
    {
        parent::__construct($attributes, $parent, $html);

        //create the table head
        $this->addRowGroup(-2, $attributes);

        //create the table footer
        $this->addRowGroup(-1, $attributes);

        //create the first table body
        $this->addBody($attributes);
    }

    // }}} __construct
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
        $txt       = '';
        $txtGroups = '';

        if (is_array($this->_tRowGroups)) {
            $step = (int) $this->getIndentLevel() + 1;

            foreach ($this->_tRowGroups as $tRowGroup) {
                $tRowGroup->setColCount($this->getColCount());

                $txtGroups .= $tRowGroup->toHtml($step, $dump, $comments, $levels);
            }

            if ($txtGroups) {
                if ($this->_caption !== null && is_object($this->_caption)) {
                    $txtCaption = $this->_caption->toHtml($step, $dump, $comments, $levels);

                    $txt .= $txtCaption;
                }

                if (is_array($this->_colgroups)) {
                    foreach ($this->_colgroups as $colgroup) {
                        $txt .= $colgroup->toHtml($step, $dump, $comments, $levels);
                    }
                }

                $txt .= $txtGroups;
            }
        }

        return $txt;
    }

    // {{{ writeInner
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
        if (count($this->_tRowGroups) == 0) {
            return '';
        }

        $txt = $this->writeInner($dump, $comments, $levels);

        if ($txt == '') {
            return '';
        } else {
            return $this->toStringInner($txt, $step, $dump, $comments, $levels);
        }
    }

    // }}} toHtml
    // {{{ addElement

    /**
     * add a new Child Element
     *
     * @param string|\HTML\Common3\ $type       the HTML Tag for the new Child
     *                                        Element or an \HTML\Common3\ Child
     *                                        object
     * @param string              $attributes Array of attribute 'name' => 'value'
     *                                        pairs or HTML attribute string
     * @param integer             $flag       Determines whether to prepend,
     *                                        append or replace the content.
     *                                        Use pre-defined constants.
     *
     * @return null|\HTML\Common3\
     * @access public
     * @throw  \HTML\Common3\Exception
     */
    public function addElement($type, $attributes = null, $flag = HTML_APPEND)
    {
        $element = parent::addElement($type, $attributes, $flag);

        if ($element !== null) {
            $elementName = $element->getElementName();

            if ($elementName == 'caption') {
                $this->_caption =& $element;
            }
        }

        return $element;
    }

    // }}} addElement
    // }}} global Functions, inherited
    // {{{ Table related Functions
    // {{{ setTable

    /**
     * set specified attributes to the table
     *
     * @param string $lang    (optional) the language for the whole table
     * @param string $class   (optional) a CSS class for the table
     * @param string $summary (optional) Cell type either 'th' or 'td'
     * @param string $style   (optional) a CSS style definition for the table
     *
     * @return \HTML\Common3\Root\Table
     * @access public
     */
    public function setTable($lang = '', $class = '', $summary = '', $style = '')
    {
        $lang = (string) $lang;

        if ($lang != '') {
            $this->setLang($lang, true);
        }

        $class = (string) $class;

        if ($class != '') {
            $this->setAttribute('class', $class);
        }

        $summary = (string) $summary;

        if ($summary != '') {
            $this->setAttribute('summary', $summary);
        }

        $style = (string) $style;

        if ($style != '') {
            $this->setAttribute('style', $style);
        }

        return $this;
    }

    // }}} setTable
    // {{{ setAutoFill

    /**
     * Sets the autoFill value
     *
     * @param string  $fill     the new autofill content
     * @param integer $rowGroup (optional) The index of the body to set.
     *                          Pass null to set for all bodies.
     *
     * @access public
     * @return \HTML\Common3\Root\Table
     */
    public function setAutoFill($fill, $rowGroup = null)
    {
        $this->_autoFill = (string) $fill;

        if (!is_null($rowGroup)) {
            $rowGroup = (int) $rowGroup;
            $ret      = $this->adjustTbodyCount($rowGroup, 'setAutoFill');

            $this->_tRowGroups[$rowGroup]->setAutoFill($this->_autoFill);
        } else {
            foreach ($this->_tRowGroups as $tRowGroup) {
                $tRowGroup->setAutoFill($this->_autoFill);
            }
        }

        return $this;
    }

    // }}} setAutoFill
    // {{{ getAutoFill

    /**
     * Returns the autoFill value
     *
     * @param integer $rowGroup (optional) The index of the body to set.
     *                          Pass null to set for all bodies.
     *
     * @return string
     * @access public
     */
    public function getAutoFill($rowGroup = null)
    {
        if (!is_null($rowGroup)) {
            $rowGroup = (int) $rowGroup;
            $ret      = $this->adjustTbodyCount($rowGroup, 'getAutoFill');

            return $this->_tRowGroups[$rowGroup]->getAutoFill();
        } else {
            return $this->_autoFill;
        }
    }

    // }}} getAutoFill
    // {{{ setAutoGrow

    /**
     * Sets the autoGrow value
     *
     * @param boolean $grow     TRUE, if the table should grow automatilly
     * @param integer $rowGroup (optional) The index of the body to set.
     *                          Pass null to set for all bodies.
     *
     * @access public
     * @return \HTML\Common3\Root\Table
     */
    public function setAutoGrow($grow, $rowGroup = null)
    {
        $this->_autoGrow = (boolean) $grow;

        if (!is_null($rowGroup)) {
            $rowGroup = (int) $rowGroup;
            $ret      = $this->adjustTbodyCount($rowGroup, 'setAutoGrow');

            $this->_tRowGroups[$rowGroup]->setAutoGrow($this->_autoGrow);
        } else {
            foreach ($this->_tRowGroups as $tRowGroup) {
                $tRowGroup->setAutoGrow($this->_autoGrow);
            }
        }

        return $this;
    }

    // }}} setAutoGrow
    // {{{ getAutoGrow

    /**
     * Returns the autoGrow value
     *
     * @param integer $rowGroup (optional) The index of the body to set.
     *                          Pass null to set for all bodies.
     *
     * @return boolean
     * @access public
     */
    public function getAutoGrow($rowGroup = null)
    {
        if (!is_null($rowGroup)) {
            $rowGroup = (int) $rowGroup;
            $ret      = $this->adjustTbodyCount($rowGroup, 'getAutoGrow');

            return $this->_tRowGroups[$rowGroup]->getAutoGrow();
        } else {
            return (boolean) $this->_autoGrow;
        }
    }

    // }}} getAutoGrow
    // }}} Table related Functions
    // {{{ Caption related Functions
    // {{{ addCaption

    /**
     * adds a Caption to the table
     *
     * @param string $value the Caption text
     * @param string $lang  (optional) the language for the whole table
     * @param string $class (optional) a CSS class for the table
     *
     * @return \HTML\Common3\Root\Caption
     * @access public
     */
    public function addCaption($value, $lang = '', $class = '')
    {
        $caption = $this->setCaption($value);

        if ($class != '') {
            $caption->setAttribute('class', $class);
        }

        if ($lang != '') {
            $caption->setLang($lang, true);
        }

        return $caption;
    }

    // }}} addCaption
    // {{{ setCaption

    /**
     * Sets the table caption
     *
     * @param string $captionvalue the caption value
     * @param mixed  $attributes   Associative array or string of table row
     *                               attributes
     *
     * @return \HTML\Common3\Root\Caption
     * @access public
     */
    public function setCaption($captionvalue, $attributes = null)
    {
        if ($this->_caption === null) {
            $caption       = $this->addElement('caption', $attributes);
            $this->_caption =& $caption;
        } else {
            $caption =& $this->_caption;
        }

        $caption->setValue($captionvalue);

        return $caption;
    }

    // }}} setCaption
    // }}} Caption related Functions
    // {{{ Colgroup related Functions
    // {{{ addColgroup

    /**
     * adds a new colgroup to this table
     *
     * @param mixed $attributes (optional) Associative array or string of
     *                          colgroup attributes. This can
     *                          also be an array of attributes,
     *                          in which case the attributes
     *                          will be repeated in a loop.
     *
     * @return \HTML\Common3\Root\Table
     * @access public
     */
    public function addColgroup($attributes = null)
    {
        $this->setColGroup(array(), $attributes);

        return $this;
    }

    // }}} addColgroup
    // {{{ setColGroup

    /**
     * Sets the table columns group specifications, or removes existing ones.
     *
     * @param mixed $colAttr    (optional) string or array of Columns attributes
     * @param mixed $attributes (optional) Associative array or string
     *                          of colgroup attributes
     *
     * @access public
     * @return \HTML\Common3\Root\Table
     */
    public function setColGroup($colAttr = null, $attributes = null)
    {
        if (isset($colAttr)) {
            $colgroup           = $this->addElement('colgroup', $attributes);
            $this->_colgroups[] =& $colgroup;

            if (!is_array($colAttr)) {
                $colAttr = array($colAttr);
            }

            foreach ($colAttr as $attribute) {
                $col = $colgroup->addCol();
                $col->setAttributes($attribute);
            }
        } else {
            $groups = array_keys($this->_colgroups);

            foreach ($groups as $group) {
                unset($this->_colgroups[$group]);
            }

            $this->_colgroups = array();
        }

        return $this;
    }

    // }}} setColGroup
    // }}} Colgroup related Functions
    // {{{ Rowgroup related Functions
    // {{{ getHeader

    /**
     * Returns the HTML_Table_Storage object for <thead>
     *
     * @access public
     * @return \HTML\Common3\Root\Thead
     */
    public function getHeader()
    {
        if (!isset($this->_tRowGroups[-2])) {
            $this->addRowGroup(-2);
        }

        return $this->_tRowGroups[-2];
    }

    // }}} getHeader
    // {{{ getFooter

    /**
     * Returns the HTML_Table_Storage object for <tfoot>
     *
     * @access public
     * @return \HTML\Common3\Root\Tfoot
     */
    public function getFooter()
    {
        if (!isset($this->_tRowGroups[-1])) {
            $this->addRowGroup(-1);
        }

        return $this->_tRowGroups[-1];
    }

    // }}} getFooter
    // {{{ getBody

    /**
     * Returns the HTML_Table_Storage object for the specified <tbody>
     * (or the whole table if <t{head|foot|body}> is not used)
     *
     * @param integer $body (optional) The index of the body to return.
     *
     * @access public
     * @return \HTML\Common3\Root\Tbody
     */
    public function getBody($body = 0)
    {
        $body = (int) $body;
        $ret  = $this->adjustTbodyCount($body, 'getBody');

        return $this->_tRowGroups[$body];
    }

    // }}} getBody
    // {{{ addBody

    /**
     * Adds a table body and returns the body identifier
     *
     * @param mixed $attributes (optional) Associative array or string of
     *                          table body attributes
     *
     * @access public
     * @return \HTML\Common3\Root\Tbody
     */
    public function addBody($attributes = null)
    {
        $body = $this->tbodyCount++;

        return $this->addRowGroup($body, $attributes);
    }

    // }}} addBody
    // {{{ addRowGroup

    /**
     * Adds a table body and returns the body identifier
     *
     * @param integer $body       the number of the tbody/thead/tfoot to add
     * @param mixed   $attributes (optional) Associative array or string of
     *                            table body attributes
     *
     * @access protected
     * @return \HTML\Common3\Table_Storage
     */
    protected function addRowGroup($body, $attributes = null)
    {
        $this->useTGroups = true;

        if ($body === -2) {
            $this->_tRowGroups[$body] = $this->addElement('thead', $attributes);
        } elseif ($body === -1) {
            $this->_tRowGroups[$body] = $this->addElement('tfoot', $attributes);
        } else {
            $body                     = (int) $body;
            $this->_tRowGroups[$body] = $this->addElement('tbody', $attributes);
        }

        if ($this->_tRowGroups[$body] !== null) {
            $this->_tRowGroups[$body]->setAutoFill($this->_autoFill);
            $this->_tRowGroups[$body]->setAutoGrow($this->_autoGrow);
            $this->_tRowGroups[$body]->setColCount($this->getColCount());
            $this->_tRowGroups[$body]->setUseTGroups(true);
        }

        return $this->_tRowGroups[$body];
    }

    // }}} addRowGroup
    // {{{ adjustTbodyCount

    /**
     * Adjusts the number of bodies
     *
     * @param integer $body   Body index
     * @param string  $method Name of calling method
     *
     * @access protected
     * @throws \HTML\Common3\InvalidArgumentException
     * @return void
     */
    protected function adjustTbodyCount($body, $method)
    {
        $body = (int) $body;

        if ($this->_autoGrow && !isset($this->_tRowGroups[$body])) {
            while ($this->tbodyCount <= $body) {
                $this->addBody();
            }
        } elseif (!isset($this->_tRowGroups[$body])) {
            throw new \HTML\Common3\InvalidArgumentException(
                'Invalid body reference[' . $body .
                '] in \HTML\Common3\Root\Table::' . $method
            );
        }
    }

    // }}} adjustTbodyCount
    // }}} Rowgroup related Functions
    // {{{ Row related Functions
    // {{{ addRow

    /**
     * Adds a table row and returns the row identifier
     *
     * @param array   $contents   (optional) Must be a indexed array of valid
     *                            cell contents
     * @param mixed   $attributes (optional) Associative array or string of
     *                            table row attributes. This can
     *                            also be an array of attributes,
     *                            in which case the attributes
     *                            will be repeated in a loop.
     * @param string  $type       (optional) Cell type either 'th' or 'td'
     * @param boolean $inTR       (optional) false if attributes are to be
     *                            applied in <td>|<th> tags; true if
     *                            attributes are to be applied in <tr> tag
     * @param integer $rowGroup   (optional) The index of the body to set.
     *
     * @return \HTML\Common3\Root\Tr
     * @access public
     */
    public function addRow($contents = null, $attributes = null, $type = 'td',
        $inTR = true, $rowGroup = 0)
    {
        $rowGroup = (int) $rowGroup;
        $ret      = $this->adjustTbodyCount($rowGroup, 'addRow');

        if (isset($contents) && !is_array($contents)) {
            $contents = array($contents);
        }

        if (is_null($contents)) {
            $contents = array();
        }

        $rownum = $this->_rowCount++;

        $row = $this->_tRowGroups[$rowGroup]->addRow($contents, $attributes,
               $type, $inTR);

        $row->setColCount($this->getColCount());
        $row->setAutoFill($this->_autoFill);
        $row->setAutoGrow($this->_autoGrow);

        $this->_rows[$rownum] =& $row;

        return $row;
    }

    // }}} addRow
    // {{{ setRowCount

    /**
     * Sets the number of rows in the table
     *
     * @param integer $rows     the Amount of Rows
     * @param integer $rowGroup (optional) The index of the body to set.
     *
     * @access public
     * @return \HTML\Common3\Root\Table
     */
    public function setRowCount($rows, $rowGroup = 0)
    {
        if (!is_null($rowGroup)) {
            $rowGroup = (int) $rowGroup;
            $ret      = $this->adjustTbodyCount($rowGroup, 'setRowCount');

            $this->_rowCount = (int) $rows;

            $this->_tRowGroups[$rowGroup]->setRowCount($this->_rowCount);
        }

        return $this;
    }

    // }}} setRowCount
    // {{{ getRowCount

    /**
     * Returns the number of rows in the table
     *
     * @param integer $rowGroup (optional) The index of the body to set.
     *                          Pass null to set for all bodies.
     *
     * @return integer
     * @access public
     */
    public function getRowCount($rowGroup = null)
    {
        if (!is_null($rowGroup)) {
            $rowGroup = (int) $rowGroup;
            $ret      = $this->adjustTbodyCount($rowGroup, 'getRowCount');

            return $this->_tRowGroups[$rowGroup]->getRowCount();
        } else {
            $count = 0;

            foreach ($this->_tRowGroups as $tRowGroup) {
                $count += (int) $tRowGroup->getRowCount();
            }

            return $count;
        }
    }

    // }}} getRowCount
    // {{{ setRowType

    /**
     * Sets a rows type 'th' or 'td'
     *
     * @param integer $row      Row index
     * @param string  $type     'th' or 'td'
     * @param integer $rowGroup (optional) The index of the body to set.
     *
     * @access public
     * @return \HTML\Common3\Root\Table
     */
    public function setRowType($row, $type, $rowGroup = 0)
    {
        $row      = (int) $row;
        $rowGroup = (int) $rowGroup;
        $ret      = $this->adjustTbodyCount($rowGroup, 'setRowType');

        $this->_tRowGroups[$rowGroup]->setRowType($row, $type);

        return $this;
    }

    // }}} setRowType
    // {{{ setRowAttributes

    /**
     * Sets the row attributes for an existing row
     *
     * @param integer $row        Row index
     * @param mixed   $attributes Associative array or string of table
     *                            row attributes. This can also be an
     *                            array of attributes, in which case the
     *                            attributes will be repeated in a loop.
     * @param boolean $inTR       false if attributes are to be applied
     *                            in <td>|<th> tags; true if attributes are to
     *                            be applied in <tr> tag
     * @param integer $rowGroup   (optional) The index of the body to set.
     *
     * @access public
     * @return mixed
     */
    public function setRowAttributes($row, $attributes, $inTR = true,
        $rowGroup = 0)
    {
        $row      = (int) $row;
        $rowGroup = (int) $rowGroup;
        $ret      = $this->adjustTbodyCount($rowGroup, 'setRowAttributes');

        return $this->_tRowGroups[$rowGroup]->setRowAttributes($row,
               $attributes, $inTR);
    }

    // }}} setRowAttributes
    // {{{ updateRowAttributes

    /**
     * Updates the row attributes for an existing row
     *
     * @param integer $row        Row index
     * @param mixed   $attributes Associative array or string of table
     *                            row attributes
     * @param boolean $inTR       false if attributes are to be applied
     *                            in <td>|<th> tags; true if attributes are to
     *                            be applied in <tr> tag
     * @param integer $rowGroup   (optional) The index of the body to set.
     *
     * @access public
     * @return mixed
     */
    public function updateRowAttributes($row, $attributes = null, $inTR = true,
        $rowGroup = 0)
    {
        $row      = (int) $row;
        $rowGroup = (int) $rowGroup;
        $ret      = $this->adjustTbodyCount($rowGroup, 'updateRowAttributes');

        return $this->_tRowGroups[$rowGroup]->updateRowAttributes($row,
               $attributes, $inTR);
    }

    // }}} updateRowAttributes
    // {{{ getRowAttributes

    /**
     * Returns the attributes for a given row as contained in the <tr> tag
     *
     * @param integer $row      Row index
     * @param integer $rowGroup (optional) The index of the body to set.
     *
     * @return array
     * @access public
     */
    public function getRowAttributes($row, $rowGroup = 0)
    {
        $row      = (int) $row;
        $rowGroup = (int) $rowGroup;
        $ret      = $this->adjustTbodyCount($rowGroup, 'getRowAttributes');

        return $this->_tRowGroups[$rowGroup]->getRowAttributes($row);
    }

    // }}} getRowAttributes
    // {{{ altRowAttributes

    /**
     * Alternates the row attributes starting at $start
     *
     * @param integer $start           Row index of row in which alternating
     *                                 begins
     * @param mixed   $attributes1     Associative array or string of table
     *                                 row attributes
     * @param mixed   $attributes2     Associative array or string of table
     *                                 row attributes
     * @param boolean $inTR            false if attributes are to be applied
     *                                 in <td>|<th> tags; true if attributes are to
     *                                 be applied in <tr> tag
     * @param integer $firstAttributes (optional) Which attributes should be
     *                                 applied to the first row, 1 or 2.
     * @param integer $rowGroup        (optional) The index of the body to
     *                                 set.
     *
     * @access public
     * @return mixed
     */
    public function altRowAttributes($start, $attributes1, $attributes2,
        $inTR = true, $firstAttributes = 1, $rowGroup = 0)
    {
        $rowGroup = (int) $rowGroup;
        $ret      = $this->adjustTbodyCount($rowGroup, 'altRowAttributes');

        return $this->_tRowGroups[$rowGroup]->altRowAttributes($start,
               $attributes1, $attributes2, $inTR, $firstAttributes);
    }

    // }}} altRowAttributes
    // }}} Row related Functions
    // {{{ Column related Functions
    // {{{ setColCount

    /**
     * Sets the number of columns in the table
     *
     * @param integer $cols           the Amount of Cols
     * @param integer $rowGroup       (optional) The index of the body to set.
     *                                Pass null to set for all bodies.
     * @param boolean $addNewColgroup (optional) if TRUE the missing columns
     *                                are placed into a new colgroup.
     *
     * @access public
     * @return integer
     */
    public function setColCount($cols, $rowGroup = null, $addNewColgroup = false)
    {
        /* count the existing Columns in the Table */
        $oldCols = 0;

        foreach ($this->_tRowGroups as $tRowGroup) {
            $colCount = $tRowGroup->getColCount();

            if ($colCount > $oldCols) {
                $oldCols = $colCount;
            }
        }

        $cols = (int) $cols;

        if ($oldCols > $cols) {
            $cols = $oldCols;
        }

        $groupsColCount = 0;

        foreach ($this->_colgroups as $colGroup) {
            $groupsColCount += $colGroup->getColCount();
        }

        if ($groupsColCount < $cols) {
            $colDiff = $cols - $groupsColCount;

            if ($addNewColgroup || count($this->_colgroups) == 0) {
                $this->addColgroup();
            }

            $lastColGroup = $this->_colgroups[count($this->_colgroups) - 1];
            $lastColGroup->setColCount($lastColGroup->getColCount() + $colDiff);
        } else {
            $cols = $groupsColCount;
        }

        $this->_colCount = $cols;

        //var_dump(8);
        if (!is_null($rowGroup)) {
            /* a specific RowGroup is given
             * -> set the new ColCount to this Group only
             */

            $rowGroup = (int) $rowGroup;
            $ret      = $this->adjustTbodyCount($rowGroup, 'setColCount');
            //var_dump(9);
            return $this->_tRowGroups[$rowGroup]->setColCount($cols);
        } else {
            foreach ($this->_tRowGroups as $tRowGroup) {
                $c = $tRowGroup->setColCount($this->_colCount);
            }
            //var_dump(10);
            return $this->_colCount;
        }
    }

    // }}} setColCount
    // {{{ getColCount

    /**
     * Gets the number of columns in the table
     *
     * If a row index is specified, the count will not take
     * the spanned cells into account in the return value.
     *
     * @param integer $row      (optional) Row index to serve for cols count
     * @param integer $rowGroup (optional) The index of the body to set.
     *                          Pass null to set for all bodies.
     *
     * @return integer
     * @access public
     */
    public function getColCount($row = null, $rowGroup = null)
    {
        if (!is_null($rowGroup)) {
            $rowGroup = (int) $rowGroup;
            $ret      = $this->adjustTbodyCount($rowGroup, 'getColCount');

            $cols = $this->_tRowGroups[$rowGroup]->getColCount($row);
        } else {
            foreach ($this->_tRowGroups as $tRowGroup) {
                $dummy = (int) $tRowGroup->getColCount($row);

                if ($dummy > $this->_colCount) {
                    $this->_colCount = $dummy;
                }
            }

            $cols = $this->_colCount;
        }

        $groupsColCount = 0;

        foreach ($this->_colgroups as $colGroup) {
            $groupsColCount += $colGroup->getColCount();
        }

        if ($groupsColCount > $cols) {
            $cols = $groupsColCount;
        }

        return $cols;
    }

    // }}} getColCount
    // {{{ setColType

    /**
     * Sets a columns type 'th' or 'td'
     *
     * @param integer $col      Column index
     * @param string  $type     'th' or 'td'
     * @param integer $rowGroup (optional) The index of the body to set.
     *                          Pass null to set for all bodies.
     *
     * @access public
     * @return \HTML\Common3\Root\Table
     */
    public function setColType($col, $type, $rowGroup = null)
    {
        $col = (int) $col;

        if (!is_null($rowGroup)) {
            $rowGroup = (int) $rowGroup;
            $ret      = $this->adjustTbodyCount($rowGroup, 'setColType');

            $this->_tRowGroups[$rowGroup]->setColType($col, $type);
        } else {
            foreach ($this->_tRowGroups as $tRowGroup) {
                $tRowGroup->setColType($col, $type);
            }
        }

        return $this;
    }

    // }}} setColType
    // {{{ addCol

    /**
     * Adds a table column and returns the column identifier
     *
     * @param array   $contents   (optional) Must be a indexed array of valid
     *                            cell contents
     *                            IS IGNORED, IF $rowGroup IS NULL
     * @param mixed   $attributes (optional) Associative array or string of
     *                            table row attributes
     * @param string  $type       (optional) Cell type either 'th' or 'td'
     * @param integer $rowGroup   (optional) The index of the body to set.
     *                            Pass null to set for all bodies.
     *
     * @return integer
     * @access public
     */
    public function addCol($contents = null, $attributes = null, $type = 'td',
        $rowGroup = null)
    {
        if (!is_null($rowGroup)) {
            $rowGroup = (int) $rowGroup;
            $ret      = $this->adjustTbodyCount($rowGroup, 'addCol');

            $colCount = $this->_tRowGroups[$rowGroup]->addCol($contents,
                        $attributes, $type);
        } else {
            $colCount = 0;

            foreach ($this->_tRowGroups as $tRowGroup) {
                $count = $tRowGroup->addCol(null, $attributes, $type);

                if ($count > $colCount) {
                    $colCount = $count;
                }
            }
        }

        $this->setColCount($colCount);
        return $colCount;
    }

    // }}} addCol
    // {{{ setColAttributes

    /**
     * Sets the column attributes for an existing column
     *
     * @param integer $col        Column index
     * @param mixed   $attributes (optional) Associative array or string
     *                            of table row attributes
     * @param integer $rowGroup   (optional) The index of the body to set.
     *                            Pass null to set for all bodies.
     *
     * @access public
     * @return \HTML\Common3\Root\Table
     */
    public function setColAttributes($col, $attributes = null, $rowGroup = null)
    {
        if (!is_null($rowGroup)) {
            $rowGroup = (int) $rowGroup;
            $ret      = $this->adjustTbodyCount($rowGroup, 'setColAttributes');

            $this->_tRowGroups[$rowGroup]->setColAttributes($col, $attributes);
        } else {
            foreach ($this->_tRowGroups as $tRowGroup) {
                $tRowGroup->setColAttributes($col, $attributes);
            }
        }

        return $this;
    }

    // }}} setColAttributes
    // {{{ updateColAttributes

    /**
     * Updates the column attributes for an existing column
     *
     * @param integer $col        Column index
     * @param mixed   $attributes (optional) Associative array or string
     *                            of table row attributes
     * @param integer $rowGroup   (optional) The index of the body to set.
     *                            Pass null to set for all bodies.
     *
     * @access public
     * @return \HTML\Common3\Root\Table
     */
    public function updateColAttributes($col, $attributes = null, $rowGroup = null)
    {
        if (!is_null($rowGroup)) {
            $rowGroup = (int) $rowGroup;
            $ret      = $this->adjustTbodyCount($rowGroup, 'updateColAttributes');

            $this->_tRowGroups[$rowGroup]->updateColAttributes($col, $attributes);
        } else {
            foreach ($this->_tRowGroups as $tRowGroup) {
                $tRowGroup->updateColAttributes($col, $attributes);
            }
        }

        return $this;
    }

    // }}} updateColAttributes
    // {{{ altColAttributes

    /**
     * Alternates the col attributes starting at $start
     *
     * @param integer $start           Col index of col in which alternating
     *                                 begins
     * @param mixed   $attributes1     Associative array or string of table
     *                                 col attributes
     * @param mixed   $attributes2     Associative array or string of table
     *                                 col attributes
     * @param integer $firstAttributes (optional) Which attributes should be
     *                                 applied to the first col, 1 or 2.
     * @param integer $rowGroup        (optional) The index of the body to
     *                                 set.
     *
     * @access public
     * @return \HTML\Common3\Root\Table
     */
    public function altColAttributes($start, $attributes1, $attributes2,
        $firstAttributes = 1, $rowGroup = null)
    {
        if (!is_null($rowGroup)) {
            $rowGroup = (int) $rowGroup;
            $ret      = $this->adjustTbodyCount($rowGroup, 'altColAttributes');

            $this->_tRowGroups[$rowGroup]->altColAttributes($start,
                   $attributes1, $attributes2, $firstAttributes);
        } else {
            $colCount = $this->getColCount();

            foreach ($this->_tRowGroups as $tRowGroup) {
                $tRowGroup->setColCount($colCount);
                $tRowGroup->altColAttributes($start,
                   $attributes1, $attributes2, $firstAttributes);
            }
        }

        return $this;
    }

    // }}} altColAttributes
    // }}} Column related Functions
    // {{{ Cell related Functions
    // {{{ setCellAttributes

    /**
     * Sets the cell attributes for an existing cell.
     *
     * If the given indices do not exist and autoGrow is true then the given
     * row and/or col is automatically added.  If autoGrow is false then an
     * error is returned.
     *
     * @param integer $row        Row index
     * @param integer $col        Column index
     * @param mixed   $attributes Associative array or string of table
     *                            row attributes
     * @param integer $rowGroup   (optional) The index of the body to set.
     *
     * @access public
     * @return mixed
     */
    public function setCellAttributes($row, $col, $attributes, $rowGroup = 0)
    {
        $row      = (int) $row;
        $col      = (int) $col;
        $rowGroup = (int) $rowGroup;
        $ret      = $this->adjustTbodyCount($rowGroup, 'setCellAttributes');

        return $this->_tRowGroups[$rowGroup]->setCellAttributes($row, $col,
               $attributes);
    }

    // }}} setCellAttributes
    // {{{ updateCellAttributes

    /**
     * Updates the cell attributes passed but leaves other existing attributes
     * intact
     *
     * @param integer $row        Row index
     * @param integer $col        Column index
     * @param mixed   $attributes Associative array or string of table row
     *                            attributes
     * @param integer $rowGroup   (optional) The index of the body to set.
     *
     * @access public
     * @throws PEAR_Error
     * @return mixed
     */
    public function updateCellAttributes($row, $col, $attributes, $rowGroup = 0)
    {
        $row      = (int) $row;
        $rowGroup = (int) $rowGroup;
        $ret      = $this->adjustTbodyCount($rowGroup, 'updateCellAttributes');

        if ($ret !== null) {
            return $ret;
        } else {
            return $this->_tRowGroups[$rowGroup]->updateCellAttributes($row, $col,
            $attributes);
        }
    }

    // }}} updateCellAttributes
    // {{{ getCellAttributes

    /**
     * Returns the attributes for a given cell
     *
     * @param integer $row      Row index
     * @param integer $col      Column index
     * @param integer $rowGroup (optional) The index of the body to set.
     *
     * @return array
     * @access public
     */
    public function getCellAttributes($row, $col, $rowGroup = 0)
    {
        $row      = (int) $row;
        $rowGroup = (int) $rowGroup;
        $ret      = $this->adjustTbodyCount($rowGroup, 'getCellAttributes');

        return $this->_tRowGroups[$rowGroup]->getCellAttributes($row, $col);
    }

    // }}} getCellAttributes
    // {{{ setCellContents

    /**
     * Sets the cell contents for an existing cell
     *
     * If the given indices do not exist and autoGrow is true then the given
     * row and/or col is automatically added.  If autoGrow is false then an
     * error is returned.
     *
     * @param integer $row      Row index
     * @param integer $col      Column index
     * @param mixed   $contents May contain html or any object with a
     *                          toHTML() method; if it is an array(with
     *                          strings and/or objects), $col will be used
     *                          as start offset and the array elements will
     *                          be set to this and the following columns
     *                          in $row
     * @param string  $type     (optional) Cell type either 'th' or 'td'
     * @param integer $rowGroup (optional) The index of the body to set.
     *
     * @access public
     * @return mixed
     */
    public function setCellContents($row, $col, $contents, $type = 'td',
        $rowGroup = 0)
    {
        $row      = (int) $row;
        $rowGroup = (int) $rowGroup;
        $ret      = $this->adjustTbodyCount($rowGroup, 'setCellContents');

        return $this->_tRowGroups[$rowGroup]->setCellContents($row, $col,
               $contents, $type);
    }

    // }}} setCellContents
    // {{{ getCellContents

    /**
     * Returns the cell contents for an existing cell
     *
     * @param integer $row      Row index
     * @param integer $col      Column index
     * @param integer $rowGroup (optional) The index of the body to set.
     *
     * @access public
     * @return mixed
     * @throws PEAR_Error
     */
    public function getCellContents($row, $col, $rowGroup = 0)
    {
        $row      = (int) $row;
        $rowGroup = (int) $rowGroup;
        $ret      = $this->adjustTbodyCount($rowGroup, 'getCellContents');

        if ($ret !== null) {
            return $ret;
        } else {
            return $this->_tRowGroups[$rowGroup]->getCellContents($row, $col);
        }
    }

    // }}} getCellContents
    // {{{ setHeaderContents

    /**
     * Sets the contents of a header cell
     *
     * @param integer $row        Row index
     * @param integer $col        Column index
     * @param mixed   $contents   the cell content
     * @param mixed   $attributes (optional) Associative array or string of
     *                            table row attributes
     * @param integer $rowGroup   (optional) The index of the body to set.
     *
     * @access public
     * @return mixed
     */
    public function setHeaderContents($row, $col, $contents, $attributes = null,
        $rowGroup = 0)
    {
        $row      = (int) $row;
        $rowGroup = (int) $rowGroup;
        $ret      = $this->adjustTbodyCount($rowGroup, 'setHeaderContents');

        return $this->_tRowGroups[$rowGroup]->setHeaderContents($row, $col,
               $contents, $attributes);
    }

    // }}} setHeaderContents
    // {{{ setAllAttributes

    /**
     * Sets the attributes for all cells
     *
     * @param mixed   $attributes (optional) Associative array or
     *                            string of table row attributes
     * @param integer $rowGroup   (optional) The index of the body to set.
     *                            Pass null to set for all bodies.
     *
     * @access public
     * @return \HTML\Common3\Root\Table
     */
    public function setAllAttributes($attributes = null, $rowGroup = null)
    {
        if (!is_null($rowGroup)) {
            $rowGroup = (int) $rowGroup;
            $ret      = $this->adjustTbodyCount($rowGroup, 'setAllAttributes');

            $this->_tRowGroups[$rowGroup]->setAllAttributes($attributes);
        } else {
            foreach ($this->_tRowGroups as $tRowGroup) {
                $tRowGroup->setAllAttributes($attributes);
            }
        }

        return $this;
    }

    // }}} setAllAttributes
    // {{{ updateAllAttributes

    /**
     * Updates the attributes for all cells
     *
     * @param mixed   $attributes (optional) Associative array or
     *                            string of table row attributes
     * @param integer $rowGroup   (optional) The index of the body to set.
     *                            Pass null to set for all bodies.
     *
     * @access public
     * @return \HTML\Common3\Root\Table
     */
    public function updateAllAttributes($attributes = null, $rowGroup = null)
    {
        if (!is_null($rowGroup)) {
            $rowGroup = (int) $rowGroup;
            $ret      = $this->adjustTbodyCount($rowGroup, 'updateAllAttributes');

            $this->_tRowGroups[$rowGroup]->updateAllAttributes($attributes);
        } else {
            foreach ($this->_tRowGroups as $tRowGroup) {
                $tRowGroup->updateAllAttributes($attributes);
            }
        }

        return $this;
    }

    // }}} updateAllAttributes
    // }}} Cell related Functions
}

// }}} \HTML\Common3\Root\Table

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */