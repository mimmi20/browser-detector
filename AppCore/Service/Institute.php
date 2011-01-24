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
 * @version   SVN: $Id: Institute.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Service
 *
 * @category  Kreditrechner
 * @package   Services
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Institute extends ServiceAbstract
{
    /**
     * Class Constructor
     *
     * @return \\AppCore\\Service\Institute
     */
    public function __construct()
    {
        $this->_model = new \AppCore\Model\Institute();
    }

    /**
     * returns the id of an institute
     *
     * @param string|integer $value ID oder Name des Institutes
     *
     * @return boolean|integer FALSE, wenn die Sparte nicht existiert,
     *                         ansonsten die ID der Sparte
     * @access public
     */
    public function getId($value)
    {
        return $this->_model->getCached('institute')->getId($value);
    }

    /**
     * returns the Color for a given Institute
     *
     * @param integer $kiId the Institute ID
     *
     * @return string the color
     * @access public
     */
    public function getColor($kiId)
    {
        return $this->_model->getCached('institute')->getColor($kiId);
    }

    /**
     * returns the Color for a given Institute
     *
     * @param integer $kiId the Institute ID
     *
     * @return string the color
     * @access public
     */
    public function getName($kiId)
    {
        return $this->_model->getCached('institute')->getName($kiId);
    }

    /**
     * returns the id of an institute
     *
     * @return Zend_Db_Table_Select
     * @access public
     */
    public function getList()
    {
        return $this->_model->getCached('institute')->getList();
    }

    /**
     * Fetches rows by primary key.  The argument specifies one or more primary
     * key value(s).  To find multiple rows by primary key, the argument must
     * be an array.
     *
     * This method accepts a variable number of arguments.  If the table has a
     * multi-column primary key, the number of arguments must be the same as
     * the number of columns in the primary key.  To find multiple rows in a
     * table with a multi-column primary key, each argument must be an array
     * with the same number of elements.
     *
     * The find() method always returns a Rowset object, even if only one row
     * was found.
     *
     * @param  mixed $key The value(s) of the primary keys.
     * @return \Zend\Db\Table\Rowset_Abstract Row(s) matching the criteria.
     * @throws Zend_Db_Table_Exception
     */
    public function find($instituteId = null)
    {
        return $this->_model->getCached('campaign')->find($instituteId);
    }

    /**
     * cleans the model cache
     *
     * calls the {@link _cleanCache} function with defined tag name
     *
     * @return \\AppCore\\Service\Institute
     */
    public function cleanCache()
    {
        return $this->cleanTaggedCache('institute');
    }
}