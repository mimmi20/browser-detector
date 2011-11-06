<?php
declare(ENCODING = 'utf-8');
namespace HTML\Common3\Root;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * HTMLCommon\Root\Colgroup: Class for HTML <colgroup> Elements
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

// {{{ HTMLCommon\Root\Colgroup

/**
 * Class for HTML <colgroup> Elements
 *
 * @category HTML
 * @package  HTMLCommon\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/HTMLCommon\
 */
class Colgroup extends HTMLCommon implements ElementsInterface
{
    // {{{ properties

    /**
     * HTML Tag of the Element
     *
     * @var      string
     */
    protected $_elementName = 'colgroup';

    /**
     * Associative array of attributes
     *
     * @var      array
     */
    protected $_attributes = array();

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
    protected $_watchedAttributes = array();

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
    protected $_posElements = array(
        '#all' => array(
            'col'
        )
    );

    /**
     * Array of Attibutes which are possible for an Element
     *
     * @var      array
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
            'span'
        ),
        'html' => array(
            '#all' => array(
                'lang'
            ),
            '4.01' => array(
                '#all' => array(
                    'align',
                    'char',
                    'charoff',
                    'valign'
                ),
                'frameset' => array(
                    'width'
                ),
                'transitional' => array(
                    'width'
                )
            ),
            '5.0' => array(
                '#all' => array(
                )
            )
        ),
        'xhtml' => array(
            '#all' => array(
                'align',
                'char',
                'charoff',
                'valign',
                'xml:lang'
            ),
            '1.0' => array(
                '#all' => array(
                    'lang'
                ),
                'frameset' => array(
                    'width'
                ),
                'transitional' => array(
                    'width'
                )
            )
        )
    );

    /**
     * Automatically adds a new row, column, or body if a given row, column, or
     * body index does not exist.
     * This is used as a default for newly-created tbodies.
     *
     * @var      boolean
     */
    protected $_autoGrow = true;

    /**
     * Count of Cols in this table/row group
     *
     * @var      integer
     */
    protected $_colCount = 0;

    /**
     * Array of all columns in this table
     *
     * @var      array
     */
    protected $_cols = array();

    /**
     * SVN Version for this class
     *
     * @var     string
     */
    const VERSION = '$Id$';

    // }}} properties
    // {{{ addCol

    /**
     * adds a new Col-Element to this colgroup
     *
     * @param string  $style CSS-style for the Col-Element
     * @param integer $span  amount of Cols to be added
     *
     * @return HTMLCommon\Root\Colgroup
     */
    public function addCol($style = '', $span = 1)
    {
        for ($i = 0; $i < (int) $span; $i++) {
            $col          = $this->addElement('col');
            $this->cols[] =& $col;

            if ($style != '') {
                $col->setAttribute('style', $style);
            }
        }

        return $col;
    }

    // }}} addCol
    // {{{ setAutoGrow

    /**
     * Sets the autoGrow value
     *
     * @param boolean $grow TRUE, if the row should grow automatilly
     *
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
     * @param integer $cols the Amount of Cols
     *
     * @return integer
     */
    public function setColCount($cols)
    {
        $cols = (int) $cols;

        $this->adjustColCount($cols, 'setColCount');

        return $this->colCount;
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
     */
    public function getColCount()
    {
        $this->colCount = count($this->cols);

        return $this->colCount;
    }

    // }}} getColCount
    // {{{ adjustColCount

    /**
     * Adjusts the number of bodies
     *
     * @param integer $colnum Column index
     * @param string  $method Name of calling method
     *
     * @throws HTMLCommon\InvalidArgumentException
     * @return void
     */
    protected function adjustColCount($colnum, $method)
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
                    $this->addCol();
                } while ($this->getColCount() < $colnum);
                /**/
                return $this->getColCount();
            } else {
                throw new HTMLCommon\InvalidArgumentException(
                    'Invalid col reference[' . $colnum .
                    '] in HTMLCommon\Root\Colgroup::' . $method
                );
            }
        }
    }

    // }}} adjustColCount
}

// }}} HTMLCommon\Root\Colgroup

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */