<?php
declare(ENCODING = 'iso-8859-1');
namespace HTML\Common3\Root;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * \HTML\Common3\Root\Colgroup: Class for HTML <colgroup> Elements
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
 * base class for \HTML\Common3\
 */
require_once 'HTML/Common3.php';

/**
 * class Interface for \HTML\Common3\
 */
require_once 'HTML/Common3/Face.php';

// {{{ \HTML\Common3\Root\Colgroup

/**
 * Class for HTML <colgroup> Elements
 *
 * @category HTML
 * @package  \HTML\Common3\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/\HTML\Common3\
 */
class Colgroupextends \HTML\Common3implements \HTML\Common3\Face
{
    // {{{ properties

    /**
     * HTML Tag of the Element
     *
     * @var      string
     * @access   protected
     */
    protected $_elementName = 'colgroup';

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
            'col'
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
     * @access   protected
     */
    protected $_autoGrow = true;

    /**
     * Count of Cols in this table/row group
     *
     * @var      integer
     * @access   protected
     */
    protected $_colCount = 0;

    /**
     * Array of all columns in this table
     *
     * @var      array
     * @access   protected
     */
    protected $_cols = array();

    /**
     * SVN Version for this class
     *
     * @var     string
     * @access  protected
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
     * @access public
     * @return \HTML\Common3\Root\Colgroup
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
     * @param integer $cols the Amount of Cols
     *
     * @access public
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
     * @access public
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
     * @access protected
     * @throws \HTML\Common3\InvalidArgumentException
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
                throw new \HTML\Common3\InvalidArgumentException(
                    'Invalid col reference[' . $colnum .
                    '] in \HTML\Common3\Root\Colgroup::' . $method
                );
            }
        }
    }

    // }}} adjustColCount
}

// }}} \HTML\Common3\Root\Colgroup

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */