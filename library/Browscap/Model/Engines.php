<?php
declare(ENCODING = 'utf-8');
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
 * @version   SVN: $Id$
 */

/**
 * Model
 *
 * @category  CreditCalc
 * @package   Models
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Engines extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'engines';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'idEngines';

    /**
     * Loads a row from the database and binds the fields to the object
     * properties
     *
     * @param mixed $engine (Optional) the browsers short name e.g. 'IE'
     *
     * @return boolean True if successful
     * @access public
     */
    public function searchByName($engine = null, $version = 0)
    {
        if (!is_string($engine)) {
            return false;
        }

        $select = $this->select();
        $select->from(array('b' => $this->_name));

        $select->where('`b`.`engine` = ?', (string) $engine);
        $select->where('`b`.`version` = ?', (string) $version);

        $select->limit(1);

        return $this->fetchAll($select)->current();
    }
    
    public function count($idEngines)
    {
        $engine = $this->find($idEngines)->current();
        
        if ($engine) {
            $this->update(array('count' => $engine->count + 1), 'idEngines = ' . (int) $idEngines);
        }
    }
    
    public function countByName($engineName, $engineVersion = 0.0)
    {
        $engine = $this->searchByName($engineName, $engineVersion);
        
        if ($engine) {
            $this->count($engine->idEngines);
        } else {
            $engine = $this->createRow();
            
            $engine->engine  = (string) $engineName;
            $engine->version = (string) $engineVersion;
            $engine->count   = 1;
            
            $engine->save();
        }
        
        return $engine->idEngines;
    }
    
    public function getAll()
    {
        $select = $this->select();
        $select->from(
            $this->_name, 
            array(
                'name' => 'engine',
                'count' => new \Zend\Db\Expr('sum(`count`)')
            )
        );
        $select->group('engine');
        
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
            array('c' => $this->_name)
        );

        $select->where('`c`.`idEngines` = :id');
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
        return 'Engines';
    }
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
