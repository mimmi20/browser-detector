<?php
declare(ENCODING = 'iso-8859-1');
namespace HTML\Common3\Root;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * \HTML\Common3\Root\Tr: Class for HTML <tr> Elements
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
 * @version  SVN: $Id: Tr.php 11 2010-10-10 19:17:21Z tmu $
 * @link     http://pear.php.net/package/\HTML\Common3\
 */

require_once 'HTML/Common3/Table/Root.php';

/**
 * class Interface for \HTML\Common3\
 */
require_once 'HTML/Common3/Face.php';

// {{{ \HTML\Common3\Root\Tr

/**
 * Class for HTML <tr> Elements
 *
 * @category HTML
 * @package  \HTML\Common3\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/\HTML\Common3\
 */
class Trextends \HTML\Common3\Table\Rootimplements \HTML\Common3\Face
{
    // {{{ properties

    /**
     * HTML Tag of the Element
     *
     * @var      string
     * @access   protected
     */
    protected $_elementName = 'tr';

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
            'td',
            'th'
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
            ),
            '4.01' => array(
                'frameset' => array(
                    'bgcolor'
                ),
                'transitional' => array(
                    'bgcolor'
                )
            ),
            '5.0' => array(
                'transitional' => array(
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
                    'bgcolor'
                ),
                'transitional' => array(
                    'bgcolor'
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
    const VERSION = '$Id: Tr.php 11 2010-10-10 19:17:21Z tmu $';

    // }}} properties
    // {{{ addCell

    /**
     * Sets the autoFill value
     *
     * @param string  $type   the cell type (td or th)
     * @param string  $style  the CSS style for the cell
     * @param integer $width  the width for the cells
     * @param integer $span   the colspan attribute
     * @param string  $title  the title attribute
     * @param string  $abbr   the abbriviation attribute
     * @param string  $axis   the axis attribute
     * @param string  $lang   the language for the cell
     * @param mixed   $func   an array of attributes or an attribute string
     * @param string  $inhalt the cell content
     *
     * @access public
     * @return \HTML\Common3\Root\Td | \HTML\Common3\Root\Th | null
     */
    public function addCell($type = 'td', $style = '', $width = 0, $span = 1,
                            $title = '', $abbr = '', $axis = '', $lang = 'de',
                            $func = '', $inhalt = '')
    {
        $type = strtolower((string) $type);
        $span = (int) $span;

        if ($type == 'td' || $type == 'th') {
            if ($inhalt == '') {
                $inhalt = $this->autoFill;
            }

            $stil = '';

            $cell         = $this->addElement($type);
            $this->cols[] =& $cell;

            if ($span > 1) {
                $cell->setAttribute('colspan', $span);

                for ($dummyspan = 2; $dummyspan < $span; $dummyspan++) {
                    $this->cols[] = null;
                }
            }

            if ($style != '') {
                $stil .= $style;
            }

            if ($width > 0) {
                $stil .= 'width:' . $width . ';';
                //$cell->setAttribute('style', "width:$width;");
            }

            if ($stil != '') {
                $cell->setAttribute('style', $stil);
            }

            /*
            if ($type == 'td') {
                //TD
                if ($this->table->headerrows == true) {
                    if ($style == 'use_id') {
                        if ($i == 1) {
                            $cell->setAttribute('headers', $id);
                        }
                    }
                }

                //$id = "table_cell_col" . $i . "_row" . $this->counter;
            } else {
                //TH
                $this->table->headerrows=true;

                $id = "cell_$id_" . $this->counter;
            }
            */

            if ($title != '') {
                $cell->setAttribute('title', $title);
            }

            if ($abbr != '') {
                $cell->setAttribute('abbr', $abbr);
            }

            if ($axis != '') {
                $cell->setAttribute('axis', $axis);
            }

            $cell->setLang($lang, true);
            //$cell->setId($id);

            //$cell->setAttribute('class', 'geo');

            if (is_array($func)) {
                foreach ($func as $funktion) {
                    $cell->addAttribute($funktion);
                }
            } else {
                $cell->addAttribute($func);
            }

            if ($inhalt != '' && $width <> 0) {
                $cell->setValue($inhalt);
            }

            return $cell;
        }

        return null;
    }

    // }}} addCell
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
        $oldAutoFill    = $this->autoFill;
        $this->autoFill = (string) $fill;

        foreach ($this->cols as $col) {
            if ($col === null || $col->getValue() == $this->autoFill) {
                continue;
            }

            if ($col->getValue() == '' ||
                $col->getValue() == $oldAutoFill) {

                $col->setValue($this->autoFill);
            }
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
        return $this->autoFill;
    }

    // }}} getAutoFill
    // {{{ setAutoGrow

    /**
     * Sets the autoGrow value
     *
     * @param boolean $grow TRUE, if the row should grow automatilly
     *
     * @access public
     * @return void
     */
    public function setAutoGrow($grow)
    {
        $this->autoGrow = (boolean) $grow;
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
        return $this->autoGrow;
    }

    // }}} getAutoGrow
    // {{{ setColCount

    /**
     * Sets the number of columns in the table
     *
     * @param integer $colnum the Amount of Cols
     *
     * @access public
     * @return integer
     */
    public function setColCount($colnum)
    {
        return $this->adjustColCount((int) $colnum, 'setColCount');
    }

    // }}} setColCount
    // {{{ getColCount

    /**
     * Gets the number of columns in the table
     *
     * If a row index is specified, the count will not take
     * the spanned cells into account in the return value.
     *
     * @return integer
     * @access public
     */
    public function getColCount()
    {
        $this->colCount = count($this->cols);

        return $this->colCount;
    }

    // }}} getColCount
    // {{{ setRowType

    /**
     * Sets a rows type 'th' or 'td'
     *
     * @param string $type the new row type, the new type for all cells in the row
     *                     possible values: 'th' or 'td'
     *
     * @access public
     * @return void
     */
    public function setRowType($type)
    {
        $type = (string) $type;
        //$root = $this->getRoot();

        $posElements = $this->getPosElements();

        if (in_array($type, $posElements) &&
            array_key_exists($type, \HTML\Common3\Globals::$allElements)
           ) {
            foreach ($this->cols as $col) {
                $col->setElementName($type);
            }
        }
    }

    // }}} setRowType
    // {{{ setColType

    /**
     * Sets a columns type 'th' or 'td'
     *
     * @param integer $colnum Column index
     * @param string  $type   'th' or 'td'
     *
     * @access public
     * @return integer|null|PEAR_Error
     */
    public function setColType($colnum, $type)
    {
        $colnum = (int) $colnum;
        $type   = (string) $type;
        //$root   = $this->getRoot();

        $posElements = $this->getPosElements();

        if (in_array($type, $posElements) &&
            array_key_exists($type, \HTML\Common3\Globals::$allElements)
           ) {
            $this->adjustColCount($colnum, 'setColType');

            if ($this->cols[$colnum - 1] !== null) {
                return $this->cols[$colnum - 1]->setElementName($type);
            } else {
                return null;
            }
        }

        return null;
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
     * @param integer $colnum     Column index
     * @param mixed   $attributes Associative array or string of table
     *                            row attributes
     *
     * @access public
     * @return void
     */
    public function setCellAttributes($colnum, $attributes)
    {
        $colnum = (int) $colnum;

        $this->adjustColCount($colnum, 'setCellAttributes');

        if ($this->cols[$colnum - 1] !== null) {
            $attributes = $this->parseAttributes($attributes);
            $this->cols[$colnum - 1]->setAttributes($attributes);

            if (isset($attributes['colspan'])) {
                $colspan = (int) $attributes['colspan'];

                $this->adjustColCount($colnum + $colspan - 1, 'setCellAttributes');

                for ($i = 1; $i < $colspan; $i++) {
                    //$this->cols[$colnum + $i - 1] = null;
                    $this->setNullCell($colnum + $i);
                }
            }
        }
    }

    // }}} setCellAttributes
    // {{{ updateCellAttributes

    /**
     * Updates the cell attributes passed but leaves other existing attributes
     * intact
     *
     * @param integer $colnum     Column index
     * @param mixed   $attributes Associative array or string of table row
     *                            attributes
     *
     * @access public
     * @return void
     */
    public function updateCellAttributes($colnum, $attributes)
    {
        $colnum = (int) $colnum;

        $this->adjustColCount($colnum, 'updateCellAttributes');

        if ($this->cols[$colnum - 1] !== null) {
            $attributes = $this->parseAttributes($attributes);
            $this->cols[$colnum - 1]->setAttributes($attributes);

            if (isset($attributes['colspan'])) {
                $colspan = (int) $attributes['colspan'];

                $this->adjustColCount($colnum + $colspan - 1,
                    'updateCellAttributes');

                for ($i = 1; $i < $colspan; $i++) {
                    //$this->cols[$colnum + $i - 1] = null;
                    $this->setNullCell($colnum + $i);
                }
            }
        }
    }

    // }}} updateCellAttributes
    // {{{ getCellAttributes

    /**
     * Returns the attributes for a given cell
     *
     * @param integer $colnum Column index
     *
     * @return array
     * @access public
     */
    public function getCellAttributes($colnum)
    {
        $colnum = (int) $colnum;

        $this->adjustColCount($colnum, 'getCellAttributes');

        if ($this->cols[$colnum - 1] !== null) {
            return $this->cols[$colnum - 1]->getAttributes();
        } else {
            return null;
        }
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
     * @param integer $colnum   Column index
     * @param mixed   $contents May contain html or any object with a
     *                          toHTML() method; if it is an array(with
     *                          strings and/or objects), $col will be used
     *                          as start offset and the array elements will
     *                          be set to this and the following columns
     *                          in $row
     * @param string  $type     (optional) Cell type either 'th' or 'td'
     *
     * @access public
     * @throws \HTML\Common3\InvalidArgumentException
     * @return mixed
     */
    public function setCellContents($colnum, $contents, $type = 'td')
    {
        $colnum = (int) $colnum;

        $this->adjustColCount($colnum, 'setCellContents', $type);

        if (is_array($contents)) {
            foreach ($contents as $content) {
                if ($this->cols[$colnum - 1] !== null) {
                    $this->cols[$colnum - 1]->setElementName($type);
                    $this->cols[$colnum - 1]->setValue($content, HTML_REPLACE);
                }
                $colnum++;

                $this->adjustColCount($colnum, 'setCellContents');
            }
        } elseif (is_string($contents)) {
            if ($this->cols[$colnum - 1] !== null) {
                $this->cols[$colnum - 1]->setElementName($type);
                $this->cols[$colnum - 1]->setValue($contents, HTML_REPLACE);
            }
        } else {
            throw new \HTML\Common3\InvalidArgumentException(
                'Parameter $contents must be an Array or a String in '.
                '\HTML\Common3\Root\Tr::setCellContents'
            );
        }
    }

    // }}} setCellContents
    // {{{ setHeaderContents

    /**
     * Sets the contents for an header cell
     *
     * @param integer $colnum     Column index
     * @param mixed   $contents   the new content for the header cells
     * @param mixed   $attributes (optional) Associative array or string of
     *                              table row attributes
     *
     * @access public
     * @throws PEAR_Error
     * @return \HTML\Common3\Table_Storage
     */
    public function setHeaderContents($colnum, $contents, $attributes = null)
    {
        $colnum = (int) $colnum;

        $this->adjustColCount($colnum, 'setCellContents', 'th');

        if (is_array($contents)) {
            foreach ($contents as $content) {
                $this->adjustColCount($colnum, 'setCellContents');

                if ($this->cols[$colnum - 1] !== null) {
                    $this->cols[$colnum - 1]->setElementName('th');
                    $this->cols[$colnum - 1]->setAttributes($attributes);
                    $this->cols[$colnum - 1]->setValue($content, HTML_REPLACE);
                }

                $colnum++;
            }
        } elseif (is_string($contents)) {
            if ($this->cols[$colnum - 1] !== null) {
                $this->cols[$colnum - 1]->setElementName('th');
                $this->cols[$colnum - 1]->setAttributes($attributes);
                $this->cols[$colnum - 1]->setValue($contents, HTML_REPLACE);
            }
        } else {
            throw new \HTML\Common3\InvalidArgumentException(
                'Parameter $contents must be an Array or a String in '.
                '\HTML\Common3\Root\Tr::setCellContents'
            );
        }
    }

    // }}} setHeaderContents
    // {{{ getCellContents

    /**
     * Returns the cell contents for an existing cell
     *
     * @param integer $colnum Column index
     *
     * @access public
     * @return mixed
     */
    public function getCellContents($colnum)
    {
        $colnum = (int) $colnum;

        $this->adjustColCount($colnum, 'getCellContents');

        if ($this->cols[$colnum - 1] !== null) {
            return $this->cols[$colnum - 1]->getValue();
        } else {
            return '';
        }
    }

    // }}} getCellContents
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
     * @return integer
     * @access public
     */
    public function addCol($contents = null, $attributes = null, $type = 'td')
    {
        if (!is_array($contents)) {
            $contents = array($contents);
        }

        $type = strtolower(trim((string) $type));

        //$rownum    = $this->rowCount++;

        foreach ($contents as $colnum => $content) {
            $col = $this->addCell($type);

            if ($col) {
                $col->setValue($content);
                $col->setAttributes($attributes);
                //$this->cols[$colnum] =& $col;
            }
        }

        $count = $this->getColCount();

        return $count;
    }

    // }}} addCol
    // {{{ setColAttributes

    /**
     * Sets the column attributes for an existing column
     *
     * @param integer $colnum     Column index
     * @param mixed   $attributes (optional) Associative array or string
     *                            of table row attributes
     *
     * @access public
     * @return void
     */
    public function setColAttributes($colnum, $attributes = null)
    {
        $this->setCellAttributes($colnum, $attributes);
    }

    // }}} setColAttributes
    // {{{ updateColAttributes

    /**
     * Updates the column attributes for an existing column
     *
     * @param integer $colnum     Column index
     * @param mixed   $attributes (optional) Associative array or string
     *                            of table row attributes
     *
     * @access public
     * @return void
     */
    public function updateColAttributes($colnum, $attributes = null)
    {
        $this->updateCellAttributes($colnum, $attributes);
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
     * @return \HTML\Common3\Root\Tr
     */
    public function altColAttributes($start, $attributes1, $attributes2,
        $firstAttributes = 1)
    {
        $count = $this->getColCount();

        if ($start <= $count) {
            for ($colnum = $start; $colnum <= $count; $colnum++) {
                if (($colnum + $start + ($firstAttributes - 1)) % 2 == 0) {
                    $attributes = $attributes1;
                } else {
                    $attributes = $attributes2;
                }

                $this->updateCellAttributes($colnum, $attributes);
            }
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
     * @throws PEAR_Error
     * @return void
     */
    public function setAllAttributes($attributes = null)
    {
        $this->setAttributes($attributes);

        foreach ($this->cols as $col) {
            if ($col) {
                $col->setAttributes($attributes);
            }
        }
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
     * @throws PEAR_Error
     * @return void
     */
    public function updateAllAttributes($attributes = null)
    {
        $this->setAttributes($attributes);

        foreach ($this->cols as $col) {
            if ($col) {
                $col->setAttributes($attributes);
            }
        }
    }

    // }}} updateAllAttributes
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
        if (count($this->cols) == 0) {
            return '';
        } else {
            $txt = $this->writeInner($dump, $comments, $levels);

            return $this->toStringInner($txt, $step, $dump, $comments, $levels);
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
     * @return string
     * @access public
     */
    public function writeInner($dump = false, $comments = false, $levels = true)
    {
        if ($this->_elementEmpty) {
            return '';
        }

        $step     = (int)     $this->getOption('level') + 1;
        $dump     = (boolean) $dump;
        $comments = (boolean) $comments;
        $levels   = (boolean) $levels;
        //$lineEnd    = $this->getOption('linebreak');

        $txt = '';

        //$begin_txt    = $this->getIndent();

        $count = count($this->_elements);

        if ($count) {
            foreach ($this->cols as $col) {
                if ($col && $col->isEnabled()) {
                    $txt .= $col->toHtml($step, $dump, $comments, $levels);
                }
            }
        }

        return $txt;
    }

    // }}} writeInner
    // {{{ adjustColCount

    /**
     * Adjusts the number of bodies
     *
     * @param integer $colnum Column index
     * @param string  $method Name of calling method
     * @param string  $type   type of cells to add
     *
     * @access protected
     * @throws \HTML\Common3\InvalidArgumentException
     * @return void
     */
    protected function adjustColCount($colnum, $method, $type = 'td')
    {
        $colnum = (int) $colnum;

        if (isset($this->cols[$colnum])) {
            return; //column exists already
        }

        if ($colnum > 1 && isset($this->cols[$colnum - 1])) {
            return; //column exists already
        }

        if (!isset($this->cols[$colnum])) {
            if ($this->autoGrow === true) {
                do {
                    $this->addCell($type);
                } while ($this->getColCount() < $colnum);
                /**/
                return $this->getColCount();
            } else {
                throw new \HTML\Common3\InvalidArgumentException(
                    'Invalid col reference[' . $colnum .
                    '] in \HTML\Common3\Root\Tr::' . $method
                );
            }
        }
    }

    // }}} adjustColCount
    // {{{ setRowAttributes

    /**
     * Sets the row attributes for an existing row
     *
     * @param mixed   $attributes Associative array or string of table
     *                            row attributes. This can also be an
     *                            array of attributes, in which case the
     *                            attributes will be repeated in a loop.
     * @param boolean $inTR       false if attributes are to be applied
     *                            in <td>|<th> tags; true if attributes are to
     *                            be applied in <tr> tag
     *
     * @access public
     * @return void
     */
    public function setRowAttributes($attributes, $inTR = true)
    {
        $inTR = (boolean) $inTR;

        if ($inTR === true) {
            $this->setAttributes($attributes);
        } else {
            $multiAttr = $this->isAttributesArray($attributes);
            $i         = 0;

            foreach ($this->cols as $col) {
                if ($col) {
                    if ($multiAttr) {
                        $col->setAttributes($attributes[$i -
                            ((ceil(($i + 1) / count($attributes))) - 1) *
                            count($attributes)]);
                    } else {
                        $col->setAttributes($attributes);
                    }

                    $i++;
                }
            }
        }
    }

    // }}} setRowAttributes
    // {{{ updateRowAttributes

    /**
     * Updates the row attributes for an existing row
     *
     * @param mixed   $attributes Associative array or string of table
     *                            row attributes
     * @param boolean $inTR       false if attributes are to be applied
     *                            in <td>|<th> tags; true if attributes are to
     *                            be applied in <tr> tag
     *
     * @access public
     * @return void
     */
    public function updateRowAttributes($attributes, $inTR = true)
    {
        $this->setRowAttributes($attributes, $inTR);
    }

    // }}} updateRowAttributes
    // {{{ setNullCell

    /**
     * Updates the cell attributes passed but leaves other existing attributes
     * intact
     *
     * @param integer $colnum Column index
     *
     * @access public
     * @return void
     */
    public function setNullCell($colnum)
    {
        $colnum = (int) $colnum;

        $this->adjustColCount($colnum, 'setNullCell');

        $this->cols[$colnum - 1] = null;
    }

    // }}} setNullCell
}

// }}} \HTML\Common3\Root\Tr

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */