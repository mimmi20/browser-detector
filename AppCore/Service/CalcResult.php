<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Service;

/**
 * Service
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Services
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Campaigns.php 31 2011-06-26 22:02:43Z tmu $
 */

/**
 * Service
 *
 * @category  Kreditrechner
 * @package   Services
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class CalcResult extends ServiceAbstract
{
    /**
     * Class Constructor
     *
     * @return \\AppCore\\Service\\CalcResult
     */
    public function __construct($institute = null)
    {
        if (null === $institute || !is_string($institute)) {
            throw new \InvalidArgumentException('Parameter $institute is missing or not a string');
        }
        
        $institute = ucfirst(strtolower($institute));
        
        $class        = '\\AppCore\\Model\\CalcResult\\' . $institute;
        $this->_model = new $class();
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
        return $this->_model->$param;
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
        $this->_model->$param = $newValue;

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
        if ($result instanceof \Zend\Db\Table\Row) {
            $result = $result->toArray();
        }
        
        if (!is_array($result)) {
            throw new \InvalidArgumentException(
                '$result must be an array or an instance of \\Zend\\Db\\Table\\Row'
            );
        }
        
        $this->_model->bind($result);

        return $this;
    }

    /**
     * Returns the column/value data as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->_model->toArray();
    }
    
    /**
     * checks if the result is valid
     *
     * validates the result against the requirements of the institutes, if
     * there are any
     *
     * @return boolean TRUE if completely successful,
     *                 FALSE if partially or not succesful.
     * @access public
     */
    public function isValid()
    {
        return $this->_model->isValid();
    }

    /**
     * checks if the institute is able to handle the forms of unister
     *
     * @return boolean TRUE if the internal forms are possible,
     *                 FALSE otherwise.
     * @access public
     */
    public function canInternal()
    {
        return $this->_model->canInternal();
    }

    /**
     * checks if the institute is able to load the institute site
     *
     * @return boolean TRUE if the institute site is possible,
     *                 FALSE otherwise.
     * @access public
     */
    public function canExternal()
    {
        return $this->_model->canExternal();
    }

    /**
     * cleans the model cache
     *
     * calls the {@link _cleanCache} function with defined tag name
     *
     * @return \AppCore\Service\Campaigns
     */
    public function cleanCache()
    {
        return $this->cleanTaggedCache('calcresult');
    }
}