<?php
declare(ENCODING = 'iso-8859-1');
namespace HTML\Common3\Table;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * \HTML\Common3\Table_Storage: Storage class for HTML::Common3 (Table) data
 *
 * This class stores data for tables built with \HTML\Common3\Root\Table.
 * When having more than one instance, it can be used for grouping the table
 * into the parts <thead>...</thead>, <tfoot>...</tfoot> and <tbody>...</tbody>.
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
 * @version  SVN: $Id: Storage.php 11 2010-10-10 19:17:21Z tmu $
 * @link     http://pear.php.net/package/\HTML\Common3\
 */

require_once 'HTML/Common3/Table/Root.php';

/**
 * class Interface for \HTML\Common3\
 */
require_once 'HTML/Common3/Face.php';

// {{{ \HTML\Common3\Table_Storage

/**
 * Base Class for HTML <tbody>, <tfoot> and <thead>
 *
 * @category HTML
 * @package  \HTML\Common3\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/\HTML\Common3\
 * @abstract
 */
abstract class Storageextends \HTML\Common3\Table\Rootimplements \HTML\Common3\Face
{
    // {{{ properties

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
            'tr'
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
            'align',
            'char',
            'charoff',
            'valign'
        ),
        'html' => array(
            '#all' => array(
                'lang'
            )
        ),
        'xhtml' => array(
            '#all' => array(
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
     * SVN Version for this class
     *
     * @var     string
     * @access  protected
     */
    const VERSION = '$Id: Storage.php 11 2010-10-10 19:17:21Z tmu $';

    // }}} properties
    // {{{ setAutoFill

    /**
     * Sets the autoFill value
     *
     * @param string $fill the new autofill content
     *
     * @access public
     * @return void
     */
    public function setAutoFill($fill)
    {
        $this->_autoFill = (string) $fill;

        foreach ($this->_rows as $row) {
            $row->setAutoFill($this->_autoFill);
        }
    }

    // }}} setAutoFill
    // {{{ getAutoFill

    /**
     * Returns the autoFill value
     *
     * @return mixed
     * @access public
     */
    public function getAutoFill()
    {
        return $this->_autoFill;
    }

    // }}} getAutoFill
    // {{{ setAutoGrow

    /**
     * Sets the autoGrow value
     *
     * @param boolean $grow the new autogrow value
     *
     * @access public
     * @return void
     */
    public function setAutoGrow($grow)
    {
        $this->_autoGrow = (boolean) $grow;

        foreach ($this->_rows as $row) {
            $row->setAutoGrow($this->_autoGrow);
        }
    }

    // }}} setAutoGrow
    // {{{ getAutoGrow

    /**
     * Returns the autoGrow value
     *
     * @return boolean
     * @access public
     */
    public function getAutoGrow()
    {
        return (boolean) $this->_autoGrow;
    }

    // }}} getAutoGrow
    // {{{ setRowCount

    /**
     * Sets the number of rows in the table storage
     *
     * @param integer $rows the Amount of Rows
     *
     * @access public
     * @return void
     */
    public function setRowCount($rows)
    {
        return $this->adjustRowCount($rows, 'setRowCount');
    }

    // }}} setRowCount
    // {{{ getRowCount

    /**
     * Returns the number of rows in the table storage
     *
     * @return integer
     * @access public
     */
    public function getRowCount()
    {
        return count($this->_rows);
    }

    // }}} getRowCount
    // {{{ setColCount

    /**
     * Sets the number of columns in the table storage
     *
     * @param integer $cols the Amount of Cols
     *
     * @access public
     * @return integer
     */
    public function setColCount($cols)
    {
        $cols = (int) $cols;

        $rows = array_keys($this->_rows);

        foreach ($rows as $rownum) {
            $row      = $this->_rows[$rownum];
            $colCount = $row->getColCount();

            if ($colCount > $cols) {
                $cols = $colCount;
            }
        }

        $this->_colCount = $cols;

        $rows = array_keys($this->_rows);

        foreach ($rows as $rownum) {
            $row = $this->_rows[$rownum];

            $row->setColCount($this->_colCount);

            $row->setAutoGrow($this->_autoGrow);
            $row->setAutoFill($this->_autoFill);
        }

        return $this->_colCount;
    }

    // }}} setColCount
    // {{{ getColCount

    /**
     * Gets the number of columns in the table
     *
     * If a row index is specified, the count will not take
     * the spanned cells into account in the return value.
     *
     * @param integer $rownum (Optional) Row index to serve for cols count
     *
     * @return integer
     * @access public
     */
    public function getColCount($rownum = null)
    {
        if (!is_null($rownum)) {
            $rownum = (int) $rownum;
            $ret    = $this->adjustRowCount($rownum, 'getColCount');

            return $this->_rows[$rownum - 1]->getColCount();
        } else {
            $rows = array_keys($this->_rows);

            foreach ($rows as $rownum) {
                $row   = $this->_rows[$rownum];
                $dummy = (int) $row->getColCount();

                if ($dummy > $this->_colCount) {
                    $this->_colCount = $dummy;
                }
            }

            return $this->_colCount;
        }

    }

    // }}} getColCount
    // {{{ setRowType

    /**
     * Sets a rows type 'th' or 'td'
     *
     * @param integer $rownum Row index
     * @param string  $type   'th' or 'td'
     *
     * @access public
     * @return \HTML\Common3\Table_Storage
     */
    public function setRowType($rownum, $type)
    {
        $rownum = (int) $rownum;
        $ret    = $this->adjustRowCount($rownum, 'setRowType');

        $this->_rows[$rownum - 1]->setRowType($type);

        return $this;
    }

    // }}} setRowType
    // {{{ setColType

    /**
     * Sets a columns type 'th' or 'td'
     *
     * @param integer $col  Column index
     * @param string  $type 'th' or 'td'
     *
     * @access public
     * @return \HTML\Common3\Table_Storage
     */
    public function setColType($col, $type)
    {
        $col = (int) $col;

        foreach ($this->_rows as $row) {
            $row->setColType($col, $type);
        }

        return $this;
    }

    // }}} setColType
    // {{{ setCellAttributes

    /**
     * Sets the cell attributes for an existing cell.
     *
     * If the given indices do not exist and autoGrow is true then the given
     * row and/or col is automatically added.  If autoGrow is false then an
     * error is returned.
     *
     * @param integer $rownum     Row index
     * @param integer $col        Column index
     * @param mixed   $attributes Associative array or string of table
     *                            row attributes
     *
     * @access public
     * @return \HTML\Common3\Table_Storage
     */
    public function setCellAttributes($rownum, $col, $attributes)
    {
        $col    = (int) $col;
        $rownum = (int) $rownum;

        $attributes = $this->parseAttributes($attributes);

        if (isset($attributes['rowspan'])) {
            $rowspan = (int) $attributes['rowspan'];
        } else {
            $rowspan = 1;
        }

        if (isset($attributes['colspan'])) {
            $colspan = (int) $attributes['colspan'];
        } else {
            $colspan = 1;
        }

        $ret = $this->adjustRowCount($rownum + $rowspan - 1, 'setCellAttributes');

        $this->_rows[$rownum - 1]->setCellAttributes($col, $attributes);

        for ($i = 1; $i < $rowspan; $i++) {
            for ($j = 0; $j < $colspan; $j++) {
                $this->_rows[$rownum + $i - 1]->setNullCell($col + $j);
            }
        }



        return $this;
    }

    // }}} setCellAttributes
    // {{{ updateCellAttributes

    /**
     * Updates the cell attributes passed but leaves other existing attributes
     * intact
     *
     * @param integer $rownum     Row index
     * @param integer $col        Column index
     * @param mixed   $attributes Associative array or string of table row
     *                            attributes
     *
     * @access public
     * @return \HTML\Common3\Table_Storage
     */
    public function updateCellAttributes($rownum, $col, $attributes)
    {
        $col = (int) $col;

        if (!is_null($rownum)) {
            $rownum = (int) $rownum;
            $ret    = $this->adjustRowCount($rownum, 'updateCellAttributes');

            $this->_rows[$rownum - 1]->updateCellAttributes($col, $attributes);
        } else {
            foreach ($this->_rows as $row) {
                $row->updateCellAttributes($col, $attributes);
            }
        }

        return $this;
    }

    // }}} updateCellAttributes
    // {{{ getCellAttributes

    /**
     * Returns the attributes for a given cell
     *
     * @param integer $rownum Row index
     * @param integer $col    Column index
     *
     * @return array
     * @access public
     */
    public function getCellAttributes($rownum, $col)
    {
        $col    = (int) $col;
        $rownum = (int) $rownum;
        $ret    = $this->adjustRowCount($rownum, 'getCellAttributes');

        return $this->_rows[$rownum - 1]->getCellAttributes($col);
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
     * @param integer $rownum   Row index
     * @param integer $col      Column index
     * @param mixed   $contents May contain html or any object with a
     *                          toHTML() method; if it is an array(with
     *                          strings and/or objects), $col will be used
     *                          as start offset and the array elements will
     *                          be set to this and the following columns
     *                          in $row
     * @param string  $type     (optional) Cell type either 'th' or 'td'
     *
     * @access public
     * @return \HTML\Common3\Table_Storage
     */
    public function setCellContents($rownum, $col, $contents, $type = 'td')
    {
        $col    = (int) $col;
        $rownum = (int) $rownum;
        $ret    = $this->adjustRowCount($rownum, 'setCellContents');

        if (is_array($contents)) {
            foreach ($contents as $singleContent) {
                $ret = $this->_rows[$rownum - 1]->setCellContents($col,
                       $singleContent, $type);

                $col++;
            }
        } else {
            $this->_rows[$rownum - 1]->setCellContents($col, $contents, $type);
        }

        return $this;
    }

    // }}} setCellContents
    // {{{ getCellContents

    /**
     * Returns the cell contents for an existing cell
     *
     * @param integer $rownum Row index
     * @param integer $col    Column index
     *
     * @access public
     * @return array
     */
    public function getCellContents($rownum, $col)
    {
        $col    = (int) $col;
        $rownum = (int) $rownum;
        $ret    = $this->adjustRowCount($rownum, 'getCellContents');

        return $this->_rows[$rownum - 1]->getCellContents($col);
    }

    // }}} getCellContents
    // {{{ setHeaderContents

    /**
     * Sets the contents for an header cell
     *
     * @param integer $rownum     Row index
     * @param integer $col        Column index
     * @param mixed   $contents   the new content for the header cells
     * @param mixed   $attributes (optional) Associative array or string of
     *                              table row attributes
     *
     * @access public
     * @throws PEAR_Error
     * @return \HTML\Common3\Table_Storage
     */
    public function setHeaderContents($rownum, $col, $contents, $attributes = null)
    {
        $col    = (int) $col;
        $rownum = (int) $rownum;

        $this->_rows[$rownum - 1]->setHeaderContents($col, $contents, $attributes);

        return $this;
    }

    // }}} setHeaderContents
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
     *
     * @return \HTML\Common3\Root\Tr
     * @access public
     */
    public function addRow($contents = null, $attributes = null, $type = 'td',
        $inTR = true)
    {
        if (!is_array($contents)) {
            $contents = array();
        }

        $type   = strtolower(trim((string) $type));
        $inTR   = (boolean) $inTR;
        $rownum = $this->_rowCount++;

        $row = $this->addElement('tr');

        if ($row !== null) {
            $colCount = max($this->getColCount(), count($contents));

            $row->setColCount($colCount);

            for ($col = 0; $col < $colCount; $col++) {
                //$col = $cols[$i];
                if (isset($contents[$col])) {
                    $content = $contents[$col];
                } else {
                    $content = $this->_autoFill;
                }

                if ($type == 'td' || $type == 'th') {
                    $row->setCellContents($col + 1, $content, $type);
                }
            }

            $row->setRowAttributes($attributes, $inTR);

            $row->setAutoFill($this->_autoFill);
            $row->setAutoGrow($this->_autoGrow);

            $this->_rows[$rownum] =& $row;
        }

        return $row;
    }

    // }}} addRow
    // {{{ setRowAttributes

    /**
     * Sets the row attributes for an existing row
     *
     * @param integer $rownum     Row index
     * @param mixed   $attributes Associative array or string of table
     *                            row attributes. This can also be an
     *                            array of attributes, in which case the
     *                            attributes will be repeated in a loop.
     * @param boolean $inTR       (Optional) false if attributes are to be applied
     *                            in <td>|<th> tags; true if attributes are to
     *                            be applied in <tr> tag
     *
     * @access public
     * @return \HTML\Common3\Table_Storage
     */
    public function setRowAttributes($rownum, $attributes, $inTR = true)
    {
        if (!is_null($rownum)) {
            $rownum = (int) $rownum;
            $ret    = $this->adjustRowCount($rownum, 'setRowAttributes');

            $this->_rows[$rownum - 1]->setRowAttributes($attributes, $inTR);
        } else {
            foreach ($this->_rows as $row) {
                $row->setRowAttributes($attributes, $inTR);
            }
        }

        return $this;
    }

    // }}} setRowAttributes
    // {{{ updateRowAttributes

    /**
     * Updates the row attributes for an existing row
     *
     * @param integer $rownum     Row index
     * @param mixed   $attributes Associative array or string of table
     *                            row attributes
     * @param boolean $inTR       false if attributes are to be applied
     *                            in <td>|<th> tags; true if attributes are to
     *                            be applied in <tr> tag
     *
     * @access public
     * @return \HTML\Common3\Table_Storage
     */
    public function updateRowAttributes($rownum, $attributes, $inTR = true)
    {
        if (!is_null($rownum)) {
            $rownum = (int) $rownum;
            $ret    = $this->adjustRowCount($rownum, 'updateRowAttributes');

            $this->_rows[$rownum - 1]->updateRowAttributes($attributes, $inTR);
        } else {
            foreach ($this->_rows as $row) {
                $row->updateRowAttributes($attributes, $inTR);
            }
        }

        return $this;
    }

    // }}} updateRowAttributes
    // {{{ getRowAttributes

    /**
     * Returns the attributes for a given row as contained in the <tr> tag
     *
     * @param integer $rownum Row index
     *
     * @return array
     * @access public
     */
    public function getRowAttributes($rownum)
    {
        $rownum = (int) $rownum;
        $ret    = $this->adjustRowCount($rownum, 'getRowAttributes');

        return $this->_rows[$rownum - 1]->getAttributes();
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
     *                                 in <td>|<th> tags; true if attributes are
     *                                 to be applied in <tr> tag
     * @param integer $firstAttributes (optional) Which attributes should be
     *                                 applied to the first row, 1 or 2.
     *
     * @access public
     * @return \HTML\Common3\Table_Storage
     */
    public function altRowAttributes($start, $attributes1, $attributes2,
        $inTR = true, $firstAttributes = 1)
    {
        $count = $this->getRowCount();

        if ($start <= $count) {
            for ($rownum = $start; $rownum <= $count; $rownum++) {
                if (($rownum + $start + ($firstAttributes - 1)) % 2 == 0) {
                    $attributes = $attributes1;
                } else {
                    $attributes = $attributes2;
                }

                $this->updateRowAttributes($rownum, $attributes, $inTR);
            }
        }

        return $this;
    }

    // }}} altRowAttributes
    // {{{ addCol

    /**
     * Adds a table column and returns the column identifier
     *
     * @param array  $contents   (optional) Must be a indexed array of valid
     *                           cell contents
     * @param mixed  $attributes (optional) Associative array or string of
     *                           table row attributes
     * @param string $type       (optional) Cell type either 'th' or 'td'
     *
     * @access public
     * @return integer
     */
    public function addCol($contents = null, $attributes = null, $type = 'td')
    {
        if (isset($contents) && !is_array($contents)) {
            $contents = array($contents);
        }
        if (is_null($contents)) {
            $contents = array();
        }

        $multiAttr = $this->isAttributesArray($attributes);

        $maxRow    = max(count($this->_rows), count($contents));
        $attrCount = count($attributes);

        $this->setRowCount($maxRow);
        $colCount = 0;

        for ($rownum = 0; $rownum < $maxRow; $rownum++) {
            if (isset($contents[$rownum])) {
                $ret     = $this->adjustRowCount($rownum + 1, 'addCol');
                $row     = $this->_rows[$rownum];
                $content = $contents[$rownum];

                if ($multiAttr) {
                    $index = $rownum -
                        ((ceil(($rownum + 1) / $attrCount)) - 1) * $attrCount;
                    $attr  = $attributes[$index];
                } else {
                    $attr = $attributes;
                }

                $attr = $this->parseAttributes($attr);

                $col = $row->addCol($content, $attr, $type);

                if (isset($attributes['rowspan']) &&
                    (int) $attributes['rowspan'] > 1) {

                    $rowspan = (int) $attributes['rowspan'];

                    for ($rsdummy = 2; $rsdummy < $rowspan; $rsdummy++) {

                        $rownum++;
                    }
                }

                $count = $row->getColCount();

                if ($count > $colCount) {
                    $colCount = $count;
                }
            }
        }

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
     *
     * @access public
     * @return \HTML\Common3\Table_Storage
     */
    public function setColAttributes($col, $attributes = null)
    {
        $col = (int) $col;

        $multiAttr = $this->isAttributesArray($attributes);
        $i         = 0;

        $attrCount = count($attributes);

        foreach ($this->_rows as $row) {
            if ($multiAttr) {
                $index = $i - ((ceil(($i + 1) / $attrCount)) - 1) * $attrCount;
                $attr  = $attributes[$index];
            } else {
                $attr = $attributes;
            }

            $row->setColAttributes($col, $attr);
            $i++;
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
     *
     * @access public
     * @return \HTML\Common3\Table_Storage
     */
    public function updateColAttributes($col, $attributes = null)
    {
        $col = (int) $col;

        $multiAttr = $this->isAttributesArray($attributes);
        $i         = 0;

        $attrCount = count($attributes);

        foreach ($this->_rows as $row) {
            if ($multiAttr) {
                $index = $i - ((ceil(($i + 1) / $attrCount)) - 1) * $attrCount;
                $attr  = $attributes[$index];
            } else {
                $attr = $attributes;
            }

            $row->updateColAttributes($col, $attr);
            $i++;
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
     *
     * @access public
     * @return \HTML\Common3\Table_Storage
     */
    public function altColAttributes($start, $attributes1, $attributes2,
        $firstAttributes = 1)
    {
        $colCount = $this->getColCount();

        foreach ($this->_rows as $row) {
            $row->setColCount($colCount);
            $row->altColAttributes($start, $attributes1, $attributes2,
                  $firstAttributes);
        }

        return $this;
    }

    // }}} altColAttributes
    // {{{ setAllAttributes

    /**
     * Sets the attributes for all cells
     *
     * @param mixed $attributes (optional) Associative array or
     *                          string of table row attributes
     *
     * @access public
     * @return \HTML\Common3\Table_Storage
     */
    public function setAllAttributes($attributes = null)
    {
        foreach ($this->_rows as $row) {
            $row->setRowAttributes($attributes);
            $row->setAllAttributes($attributes);
        }

        return $this;
    }

    // }}} setAllAttributes
    // {{{ updateAllAttributes

    /**
     * Updates the attributes for all cells
     *
     * @param mixed $attributes (optional) Associative array or
     *                          string of table row attributes
     *
     * @access public
     * @return \HTML\Common3\Table_Storage
     */
    public function updateAllAttributes($attributes = null)
    {
        foreach ($this->_rows as $row) {
            $row->updateRowAttributes($attributes);
            $row->updateAllAttributes($attributes);
        }

        return $this;
    }

    // }}} updateAllAttributes
    // {{{ toHtml

    /**
     * Returns the Element structure as HTML, works recursive
     *
     * @param integer $step     the level in which should startet the output,
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
        if (count($this->_rows) == 0) {
            return '';
        } else {
            return parent::toHtml($step, $dump, $comments, $levels);
        }
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
     * @access public
     * @return string
     */
    public function writeInner($dump = false, $comments = false, $levels = true)
    {
        $txt  = '';
        $step = (int) $this->getIndentLevel() + 1;

        foreach ($this->_rows as $row) {
            $txt .= $row->toHtml($step, $dump, $comments, $levels);
        }

        return $txt;
    }

    // {{{ writeInner
    // {{{ adjustRowCount

    /**
     * Adjusts the number of bodies
     *
     * @param integer $rownum Row index
     * @param string  $method Name of calling method
     *
     * @access protected
     * @throws \HTML\Common3\InvalidArgumentException
     * @return void
     */
    protected function adjustRowCount($rownum, $method)
    {
        $rownum = (int) $rownum;

        if (isset($this->_rows[$rownum])) {
            return; //row exists already
        }

        if ($rownum > 1 && isset($this->_rows[$rownum - 1])) {
            return; //row exists already
        }

        if (!isset($this->_rows[$rownum])) {
            if ($this->_autoGrow === true) {
                do {
                    $this->addRow();
                } while ($this->getRowCount() < $rownum);
            } else {
                throw new \HTML\Common3\InvalidArgumentException(
                    'Invalid row reference[' . $rownum .
                    '] in \HTML\Common3\Table_Storage::' . $method
                );
            }
        }
    }

    // }}} adjustRowCount
    // {{{ setUseTGroups

    /**
     * Sets the useTGroups value
     *
     * @param boolean $useTGroups TRUE, if TGroups should be used, FALSE otherwise
     *
     * @access public
     * @return void
     */
    public function setUseTGroups($useTGroups)
    {
        $this->_useTGroups = (boolean) $useTGroups;
    }

    // }}} setUseTGroups
    // {{{ getUseTGroups

    /**
     * Gets the useTGroups value
     *
     * @return boolean
     * @access public
     */
    public function getUseTGroups()
    {
        return (boolean) $this->_useTGroups;
    }

    // }}} getUseTGroups
}

// }}} \HTML\Common3\Table_Storage

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */