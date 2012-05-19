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
class Browsers extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'browsers';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'idBrowsers';
    /*
    CREATE TABLE `browsers` (
        `idBrowsers` INT(10) NULL AUTO_INCREMENT,
        `browser` VARCHAR(250) NULL,
        `version` DECIMAL(10,2) UNSIGNED NULL,
        `bits` INT UNSIGNED NULL,
        `count` BIGINT UNSIGNED NULL,
        PRIMARY KEY (`idBrowsers`),
        INDEX `count` (`count`),
        UNIQUE INDEX `browser_version_bits` (`browser`, `version`, `bits`)
    )
    COLLATE='utf8_general_ci'
    ENGINE=InnoDB
    ROW_FORMAT=DEFAULT
    */

    /**
     * Loads a row from the database and binds the fields to the object
     * properties
     *
     * @param mixed $browserName (Optional) the browsers short name e.g. 'IE'
     *
     * @return boolean True if successful
     * @access public
     */
    public function searchByBrowser(
        $browserName = null, $version = 0, $bits = null)
    {
        if (!is_string($browserName)) {
            return false;
        }

        $select = $this->select();
        $select->from(array('b' => $this->_name));

        $select->where('`b`.`browser` = ?', (string) $browserName);
        $select->where('`b`.`version` = ?', (string) $version);
        $select->where('`b`.`bits` = ?', (int) $bits);

        $select->limit(1);
        //echo $select->assemble() . "\n";
        $browser = $this->fetchAll($select)->current();
        //var_dump($this->fetchAll($select), $browser);
        if (!$browser) {
            $browser = $this->createRow();
            
            $browser->browser = (string) $browserName;
            $browser->version = (string) $version;
            $browser->bits    = (int) $bits;
            $browser->count   = 0;
            
            $browser->save();
        }
        
        return $browser;
    }
    
    public function count($idBrowsers)
    {
        $browser = $this->find($idBrowsers);
        
        if ($browser) {
            $this->update(array('count' => new \Zend\Db\Expr('`count` = `count` + 1')), 'idBrowsers = ' . (int) $browser->current()->idBrowsers);
        }
    }
    
    public function countByName($browserName, $browserVersion = 0.0, $bits = 0)
    {
        $browser = $this->searchByBrowser($browserName, $browserVersion, $bits);
        
        if (empty($browser->idBrowsers)) {
            return null;
        }
        
        $this->count($browser->idBrowsers);
        
        return $browser->idBrowsers;
    }
    
    public function getAll()
    {
        $select = $this->select();
        $select->from(
            $this->_name, 
            array(
                'name' => 'browser',
                'count' => new \Zend\Db\Expr('sum(`count`)')
            )
        );
        $select->group('browser');
        
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

        if (empty($this->_statements[__FUNCTION__])) {
            /**
             * @var Zend_Db_Table_Select
             */
            $select = $this->select();
            
            $select->from(
                array('c' => $this->_name)
            );
            
            $select->where('`c`.`idBrowsers` = :id');
            
            $select->limit(1);
            
            $stmt = new \Zend\Db\Statement\Pdo($this->_db, $select);
            
            $this->_statements[__FUNCTION__] = $stmt;
        } else {
            $stmt   = $this->_statements[__FUNCTION__];
            $select = null;
        }
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        
        $rows = $this->execute($stmt, \PDO::FETCH_ASSOC);
        
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
        return 'Browsers';
    }
}
