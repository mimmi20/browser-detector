<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Model;

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * \AppCore\Model\Cache
 *
 * Cache proxy for models, proxies calls to the model to
 * the Zend_Cache class cache.
 *
 * @category  CreditCalc
 * @package   Models
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * the class to ache all model actions
 */
use \Zend\Cache\Cache;

/**
 * \AppCore\Model\Cache
 *
 * Cache proxy for models, proxies calls to the model to
 * the Zend_Cache class cache.
 *
 * @category  CreditCalc
 * @package   Models
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 */
class ModelCache
{
    /**
     * @var array Class methods
     */
    private $_classMethods = array();

    /**
     * @var Zend_Cache
     */
    private $_cache = null;
    
    /**
     * @var \Zend\Config
     */
    private $_options = null;

    /**
     * @var \App\Model\Abstract
     */
    private $_model = null;

    /**
     * @var string The tag this call will be stored against
     */
    private $_tagged = '';
    
    /**
     * @var \Zend\Acl\Acl
     */
    private $_acl = null;

    /**
     * Constructor
     *
     * @param \AppCore\Model\ModelAbstract $model
     * @param array|Zend_Config $options
     */
    public function __construct(ModelAbstract $model, $options = null, $tagged = null)
    {
        $this->_model   = $model;
        $this->_options = $options;

        if (!empty($tagged)) {
            $this->setTagged($tagged);
        }
    }

    /**
     * Set the cache instance
     *
     * @param Cache $cache
     */
    public function setCache(Cache $cache)
    {
        $this->_cache = $cache;
    }

    /**
     * Get the cache instance, configure a new instance
     * if one not present.
     *
     * @return Cache
     */
    public function getCache()
    {
        if (null === $this->_cache) {
            $frontendOptions = $this->_options->frontend->options->toArray();
            $frontendOptions['cached_entity']  = $this->_model;
            
            $this->_cache = Cache::factory(
                $this->_options->frontend->name, 
                $this->_options->backend->name, 
                $frontendOptions, 
                $this->_options->backend->options->toArray(),
                $this->_options->frontend->customFrontendNaming,
                $this->_options->backend->customBackendNaming,
                $this->_options->frontendBackendAutoload
            );
            /**/
        }
        
        return $this->_cache;
    }

    /**
     * @param string $tagged the new tag
     *
     * @return void
     */
    public function setTagged($tagged = null)
    {
        $this->_tagged = $tagged;

        if (null === $tagged) {
            $this->_tagged = 'default';
        }
    }

    /**
     * Proxy calls from here to Zend_Cache, Zend_Cache
     * will be using the Class frontend which caches the model
     * classes methods.
     *
     * @param string $method
     * @param array $params
     * @return mixed
     * @throws \BadFunctionCallException
     */
    public function __call($method, $params)
    {
        if (!is_callable(array($this->_model, $method))) {
            throw new \BadFunctionCallException(
                'Method \'' . $method . '\' does not exist in class \'' .
                get_class($this->_model) . '\''
            );
        }
        
        $cache = $this->getCache();
        $cache->setTagsArray(array($this->_tagged));
        
        $callback = array($cache, $method);
        
        return call_user_func_array($callback, $params);
    }
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */