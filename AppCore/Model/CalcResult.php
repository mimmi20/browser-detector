<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Model;

/**
 * the CalcResult is a virtual/temporary Table, which represents the result of
 * a calculation for credits or other finacial products in this application
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * the CalcResult is a virtual/temporary Table, which represents the result of
 * a calculation for credits or other finacial products in this application
 *
 * because the CalcResult is a virtual/temporary Table, it is not possible
 * to add or change the result rows and store them
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @abstract
 */
class CalcResult
{
    /**
     * Name of the table in the db schema relating to child class
     *
     * @var string
     */
    protected $_name = '';

    /**
     * Name of the primary key field in the table
     *
     * @var string
     */
    protected $_primary = '';

    /**
     * @var Zend_Db_Table_Row
     */
    protected $_result = null;

    /**
     * Konstruktor
     *
     * @return KreditCore_Model_CalcResult
     */
    public function __construct()
    {
        //$this->_db = Zend_Db_Table_Abstract::getDefaultAdapter();
    }

    /**
     * Returns the value of a param
     *
     * @param string $param the param name
     *
     * @return array
     */
    public function __get($param)
    {
        if (isset($this->_result[$param])) {
            return $this->_result[$param];
        } else {
            return null;
        }
    }

    /**
     * sets a new value for a param
     *
     * @param string $param    the param name
     * @param mixed  $newValue the new value
     *
     * @return KreditCore_Model_CalcResult
     */
    public function __set($param, $newValue)
    {
        if (isset($this->_result[$param])) {
            $this->_result[$param] = $newValue;
        }

        return $this;
    }

    /**
     * Binds a named array/hash to this object
     *
     * Can be overloaded/supplemented by the child class
     *
     * @param array|Zend_Db_Table_Row $result an associative array or object
     *
     * @return KreditCore_Model_CalcResult
     */
    public function bind($result)
    {
        if ($result instanceof Zend_Db_Table_Row) {
            $result = $result->toArray();
        }
        
        if (!is_array($result)) {
            throw new Zend_Exception(
                '$result must be an array or an instance of Zend_Db_Table_Row'
            );
        }
        
        $this->_result = $result;

        return $this;
    }

    /**
     * Returns the column/value data as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->_result;
    }
}