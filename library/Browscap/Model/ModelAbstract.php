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

use \Zend\Db\Table\AbstractTable as ZendDbTableAbstractTable;

/**
 * abstrakte Basis-Klasse für alle Models
 *
 * @category  Browscap
 * @package   Browscap
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @abstract
 */
abstract class ModelAbstract extends ZendDbTableAbstractTable
{
    /**
     * @var SF_Model_Cache_Abstract
     */
    protected $_cache;

    /**
     * @var Zend_Config
     */
    protected $_config = null;

    /**
     * @var \Zend\Log\Logger
     */
    protected $_logger = null;
    
    /**
     * holds the data about the actual record
     *
     * @var \Zend\Db\Table\Row
     */
    protected $_data = null;
    
    /**
     * dataholder for PDO statements
     * @var array
     */
    protected $_statements = array();

    /**
     * Konstruktor
     *
     * @param array $config the config
     *
     * @return void
     * @access public
     */
    public function init()
    {
        parent::init();
        
        if (\Zend\Registry::isRegistered('BROWSCAP_DB')) {
            $this->_db = \Zend\Registry::get('BROWSCAP_DB');
        } else {
            $this->_db = ZendDbTableAbstractTable::getDefaultAdapter();
        }
        $this->_db->setFetchMode(\Zend\Db\Db::FETCH_OBJ);
        
        $front         = \Zend\Controller\Front::getInstance();
        $this->_config = \Zend\Registry::get('_config');
        $this->_logger = \Zend\Registry::get('log');
        
        $this->_db->exec("SET NAMES 'utf8';");
    }

    /**
     * Query the cache
     *
     * @param string $tagged The tag to save data to
     *
     * @return Crdit\Core\Model\Cache|Crdit\Core\Model\ModelAbstract
     */
    public function getCached($tagged = null)
    {
        if (null === $this->_cache) {
            $this->_cache = new ModelCache(
                $this,
                $this->_config->resources->cachemanager->model
            );
            
            $this->_cache->setTagged($tagged);
        }
        
        return $this->_cache;
    }

    /**
     * Get the cache instance, configure a new instance
     * if one not present.
     *
     * @return Zend_Cache
     */
    public function getCache()
    {
        return $this->_cache->getCache();
    }

    /**
     * Clean cache entries
     *
     * Available modes are :
     * 'all' (default)  => remove all cache entries ($tags is not used)
     * 'old'            => remove too old cache entries ($tags is not used)
     * 'matchingTag'    => remove cache entries matching all given tags
     *                     ($tags can be an array of strings or a single string)
     * 'notMatchingTag' => remove cache entries not matching one of the given tags
     *                     ($tags can be an array of strings or a single string)
     * 'matchingAnyTag' => remove cache entries matching any given tags
     *                     ($tags can be an array of strings or a single string)
     *
     * @param  string       $mode
     * @param  array|string $tags
     * @throws Zend_Cache_Exception
     * @return boolean True if ok
     */
    public function clean($mode = 'all', $tags = array())
    {
        return $this->_cache->getCache()->clean($mode, $tags);
    }
    
    abstract public function getResource();

    /**
     * executes a statement
     *
     * @param \Zend\Db\Statement\Pdo $stmt
     *
     * @return array|boolean
     */
    protected function execute(
        \Zend\Db\Statement\Pdo $stmt, $fetchMode = \PDO::FETCH_OBJ)
    {
        try {
            $stmt->execute();

            /**
             * @var array
             */
            return $stmt->fetchAll($fetchMode);
        } catch (\Exception $e) {
            $this->logExecuteError($e, $stmt);

            return false;
        }
    }

    protected function logExecuteError(\Exception $e, \Zend\Db\Statement\Pdo $stmt)
    {
        $message   = $e->getMessage()
            . "\n" . 'ErrorInfo: ' . serialize($stmt->errorInfo());

        $exception = new \Exception($message, $e->getCode(), $e);

        $this->_logger->err($exception);
    }
}