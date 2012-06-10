<?php
namespace Browscap\Model;

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Model
 *
 * PHP version 5
 *
 * @category  CreditCalc
 * @package   Models
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 * @version    SVN: $Id$
 */

/**
 * Model
 *
 * @category  CreditCalc
 * @package   Models
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 */
class DeviceData extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'devisedata';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'idWurflData';
    
    public function count($idDevices)
    {
        $device = $this->find($idDevices)->current();
        
        if ($device) {
            $this->update(array('count' => $device->count + 1), 'idWurflData = ' . (int) $device->idWurflData);
        }
    }
    
    public function getAll()
    {
        $select = $this->select();
        $select->from(
            $this->_name, 
            array(
                'name' => 'name',
                'count' => new \Zend\Db\Expr('sum(`count`)')
            )
        );
        $select->group('name');
        
        return $this->fetchAll($select);
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
     * @return Zend_Db_Table_Rowset_Abstract Row(s) matching the criteria.
     * @throws Zend_Db_Table_Exception
     */
    public function find($id = null)
    {
        if (null === $id) {
            return false;
        }
        
        $id = (int) $id;

        /**
         * @var Zend_Db_Table_Select
         */
        $select = $this->select();
        $select->from(
            array('d' => $this->_name)
        );

        $select->where('`d`.`idWurflData` = :id');
        $select->limit(1);

        $stmt = new \Zend\Db\Statement\Pdo($this->_db, $select);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

        $rows = $this->execute(
            $stmt,
            \PDO::FETCH_ASSOC,
            $select,
            array(
                'id' => array('value' => $id, 'type' => 'PDO::PARAM_INT')
            )
        );

        if (false === $rows) {
            $rows = array();
        }

        $options = array(
            'data' => $rows
        );

        try {
            $rowSet = new \Zend\Db\Table\Rowset($options);
            $rowSet->setTable($this);
        } catch (\Exception $e) {
            $this->_logger->err($e);

            return false;
        }

        while ($rowSet->valid()) {
            $rowSet->current();
            $rowSet->next();
        }

        return $rowSet->rewind();
    }
    
    public function getResource()
    {
        return 'deviceData';
    }
}
