<?php
namespace Browscap\Model;

/**
 * PHP version 5.3
 *
 * LICENSE:
 *
 * Copyright (c) 2013, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 *
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without 
 * modification, are permitted provided that the following conditions are met:
 *
 * * Redistributions of source code must retain the above copyright notice, 
 *   this list of conditions and the following disclaimer.
 * * Redistributions in binary form must reproduce the above copyright notice, 
 *   this list of conditions and the following disclaimer in the documentation 
 *   and/or other materials provided with the distribution.
 * * Neither the name of the authors nor the names of its contributors may be 
 *   used to endorse or promote products derived from this software without 
 *   specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" 
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE 
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE 
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE 
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR 
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF 
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN 
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE 
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  Browscap
 * @package   Browscap
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */

/**
 * Model
 *
 * @category  Browscap
 * @package   Browscap
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
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
        $wurflData = $this->find($idWurflData)->current();
        
        if ($wurflData) {
            $wurflData->getTable()->update(array('count' => new \Zend\Db\Expr('`count` + 1')), 'idWurflData = ' . $idWurflData);//count += 1;
        } else {
            // Provide the absolute or relative path to your wurfl-config.xml
            $wurflConfigFile = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'wurfl' . DIRECTORY_SEPARATOR . 'wurfl-config.xml');
            
            // Create WURFL Configuration from an XML config file
            $wurflConfig = new \WURFL_Configuration_XmlConfig($wurflConfigFile);
             
            // Create a WURFL Manager Factory from the WURFL Configuration
            $wurflManagerFactory = new \WURFL_WURFLManagerFactory($wurflConfig);
             
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
            
            $wurflData->save();
        }
        
        return $wurflData;
    }
    
    public function findByWurflkey($wurflKey, $wurflData = null)
    {
        if (empty($wurflKey) || !is_string($wurflKey)) {
            $wurflKey = 'generic';
        }
        
        $select = $this->select();
        $select->where('wurflKey = ?', $wurflKey);
        
        $data = $this->fetchRow($select);
        
        if (!$data) {
            $data = $this->createRow();
            
            $data->wurflKey = $wurflKey;
            $data->data     = serialize($wurflData);
            
            $data->save();
        }
        
        return $data;
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