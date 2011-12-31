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
class WurflData extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'wurfldata';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'idWurflData';
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
    
    public function count($idWurflData, $userAgent = '')
    {
        $wurflData = null;
        
        $wurflData = $this->find($idWurflData)->current();
        
        if ($wurflData) {
            $wurflData->count += 1;
        } else {
            // Provide the absolute or relative path to your wurfl-config.xml
            $wurflConfigFile = realpath(__DIR__ . DS . '..' . DS . 'data' . DS . 'wurfl' . DS . 'wurfl-config.xml');
            
            // Create WURFL Configuration from an XML config file
            $wurflConfig = new \Wurfl\Configuration\XmlConfig($wurflConfigFile);
             
            // Create a WURFL Manager Factory from the WURFL Configuration
            $wurflManagerFactory = new \Wurfl\WURFLManagerFactory($wurflConfig);
             
            // Create a WURFL Manager
            $wurflManager = $wurflManagerFactory->create();
            $device       = $wurflManager->getDeviceForUserAgent($userAgent);
            
            $wurflData = $this->findByWurflkey($device->id)->current();
            //var_dump('$device->id', $device->id, '$wurflData', $wurflData);
            if ($wurflData) {
                $wurflData->data   = serialize($device);
                $wurflData->count += 1;
            } else {
                $wurflData = $this->createRow();
                
                $wurflData->wurflKey = $device->id;
                $wurflData->data     = serialize($device);
                $wurflData->count    = 1;
            }
        }
        //var_dump('$wurflData', $wurflData);
        //exit;
        $wurflData->save();
        
        return $wurflData;
    }
    
    public function findByWurflkey($wurflKey)
    {
        if (empty($wurflKey) || !is_string($wurflKey)) {
            return 'generic';
        }
        
        $select = $this->select();
        $select->where('wurflKey = ?', $wurflKey);
        
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

        $select->where('`c`.`idWurflData` = :id');
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
        return 'WurflData';
    }
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */