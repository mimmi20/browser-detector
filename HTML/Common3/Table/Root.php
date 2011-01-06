<?php
declare(ENCODING = 'iso-8859-1');
namespace HTML\Common3\Table;

/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * \HTML\Common3\Table\Root: Base Class for HTML table, tbody, tfoot, thead and tr
 *
 * This class stores data for tables built with \HTML\Common3\Root\Table. When having
 * more than one instance, it can be used for grouping the table into the
 * parts <thead>...</thead>, <tfoot>...</tfoot> and <tbody>...</tbody>.
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

// {{{ \HTML\Common3\Table\Root

/**
 * Base Class for HTML <table>, <tbody>, <tfoot>, <thead> and <tr>
 *
 * @category HTML
 * @package  \HTML\Common3\
 * @author   Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://pear.php.net/package/\HTML\Common3\
 * @abstract
 */
abstract class Rootextends \HTML\Common3implements \HTML\Common3\Face
{
    // {{{ properties

    /**
     * Associative array of attributes
     *
     * @var      array
     * @access   protected
     */
    protected $_attributes = array();

    /**
     * Value to insert into empty cells. This is used as a default for
     * newly-created tbodies.
     *
     * @var      string
     * @access   protected
     */
    protected $_autoFill = '';

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
     * Whether to use <thead>, <tfoot> and <tbody> or not
     *
     * @var      boolean
     * @access   protected
     */
    protected $_useTGroups = true;

    /**
     * Count of Rows in this table/row group
     *
     * @var      integer
     * @access   protected
     */
    protected $_rowCount = 0;

    /**
     * Count of Cols in this table/row group
     *
     * @var      integer
     * @access   protected
     */
    protected $_colCount = 0;

    /**
     * Array of all rows in this table
     *
     * @var      array
     * @access   protected
     */
    protected $_rows = array();

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
    // {{{ isAttributesArray

    /**
     * Tells if the parameter is an array of attribute arrays/strings
     *
     * @param mixed $attributes Variable to test
     *
     * @access protected
     * @return boolean
     */
    protected function isAttributesArray($attributes)
    {
        if (is_array($attributes) && isset($attributes[0])) {
            if (is_array($attributes[0]) ||
                (is_string($attributes[0]) && count($attributes) > 1)) {
                return true;
            }
        }
        return false;
    }

    // }}} isAttributesArray
}

// }}} \HTML\Common3\Table\Root

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */