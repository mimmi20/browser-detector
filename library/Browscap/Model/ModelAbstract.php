<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Model;

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * abstrakte Basis-Klasse für alle Models
 *
 * PHP version 5
 *
 * @category  CreditCalc
 * @package   Db
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: ModelAbstract.php 102 2011-10-25 21:18:56Z  $
 */

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * abstrakte Basis-Klasse für alle Models
 *
 * @category  CreditCalc
 * @package   Db
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 * @abstract
 */
abstract class ModelAbstract extends \Zend\Db\Table\AbstractTable
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
            $this->_db = \Zend\Db\Table\AbstractTable::getDefaultAdapter();
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
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */