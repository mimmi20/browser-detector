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

        $engineObject = $this->fetchAll($select);
        
        if (!$engineObject) {
            $engineObject = $this->createRow();
            
            $engineObject->engine  = (string) $engine;
            $engineObject->version = (string) $version;
            $engineObject->count   = 0;
            
            $engineObject->save();
        } else {
            $engineObject = $engineObject->current();
            
            if (!$engineObject) {
                return null;
            }
        }
        
        return (object) $engineObject->toArray();
    }
    
    public function count($idEngines)
    {
        if (null === $idEngines) {
            return;
        }
        
        $engine = $this->find($idEngines);
        
        if ($engine) {
            $this->update(array('count' => $engine->current()->count + 1), 'idEngines = ' . (int) $idEngines);
        }
    }
    
    public function countByName($engineName, $engineVersion = 0.0)
    {
        $engine = $this->searchByName($engineName, $engineVersion);
        
        if ($engine) {
            $this->count($engine->idEngines);
        } else {
            return false;
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

        if (empty($this->_statements[__FUNCTION__])) {
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
        
        $rowSet = new \Zend\Db\Table\Rowset($options);
        $rowSet->setTable($this);
        
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
