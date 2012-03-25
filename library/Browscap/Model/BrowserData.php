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
class BrowserData extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'browserdata';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'idBrowserData';

    /**
     * Loads a row from the database and binds the fields to the object
     * properties
     *
     * @param mixed $browser (Optional) the browsers short name e.g. 'IE'
     *
     * @return boolean True if successful
     * @access public
     */
    public function searchByBrowser(
        $browser = null, $version = 0, $bits = null)
    {
        if (!is_string($browser)) {
            return false;
        }

        $select = $this->select();
        $select->from(array('b' => $this->_name));

        $select->where('`b`.`name` = ?', (string) $browser);
        $select->where('`b`.`version` = ?', (string) $version);
        $select->where('`b`.`bits` = ?', (int) $bits);

        $select->limit(1);

        return $this->fetchAll($select)->current();
    }
    
    public function count($idBrowsers)
    {
        $browser = $this->find($idBrowsers)->current();
        
        if ($browser) {
            $this->update(array('count' => $browser->count + 1), 'idBrowserData = ' . (int) $browser->idBrowserData);
        }
    }
    
    public function countByName($browserName, $browserVersion = 0.0, $bits = 0, array $data)
    {
        $browser = $this->searchByBrowser($browserName, $browserVersion, $bits);
        
        if ($browser) {
            $this->count($browser->idBrowserData);
        } else {
            $browser = $this->createRow();
            
            $browser->name    = (string) $browserName;
            $browser->version = (string) $browserVersion;
            $browser->bits    = $bits;
            $browser->data    = \Zend\Json\Json::encode($data);
            $browser->count   = 1;
            
            $browser->save();
        }
        
        return $browser->idBrowserData;
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
            array('c' => $this->_name)
        );

        $select->where('`c`.`idBrowserData` = :id');
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
        return 'BrowserData';
    }
}
