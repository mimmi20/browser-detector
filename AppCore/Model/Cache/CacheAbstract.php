<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Model\Cache;

/**
 * \\AppCore\\Model\Cache_Abstract
 *
 * Cache proxy for models, proxies calls to the model to
 * the Zend_Cache class cache.
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * \\AppCore\\Model\Cache_Abstract
 *
 * Cache proxy for models, proxies calls to the model to
 * the Zend_Cache class cache.
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
abstract class CacheAbstract
{
    /**
     * @var array Class methods
     */
    protected $_classMethods = array();

    /**
     * @var Zend_Cache
     */
    protected $_cache = null;
    
    /**
     * @var \Zend\Config
     */
    protected $_options = null;

    /**
     * @var \AppCore\Model\Abstract
     */
    protected $_model = null;

    /**
     * @var string The tag this call will be stored against
     */
    protected $_tagged = '';

    /**
     * Constructor
     *
     * @param \\AppCore\\Model\ModelAbstract $model
     * @param array|Zend_Config $options
     */
    public function __construct(
        \AppCore\Model\ModelAbstract $model,
        $options = null,
        $tagged = null)
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
     * @param Zend_Cache $cache
     */
    public function setCache(Zend_Cache $cache)
    {
        $this->_cache = $cache;
    }

    /**
     * Get the cache instance, configure a new instance
     * if one not present.
     *
     * @return Zend_Cache
     */
    public function getCache()
    {
        if (null === $this->_cache) {
            $frontendOptions = $this->_options->frontend->options->toArray();
            $frontendOptions['cached_entity']  = $this->_model;
            //$frontendOptions['cached_methods'] = get_methods($this->_model);
            //unset($frontendOptions['cached_methods']['save']);
            
            $this->_cache = \Zend\Cache\Cache::factory(
                $this->_options->frontend->name, 
                $this->_options->backend->name, 
                $frontendOptions, 
                $this->_options->backend->options->toArray(),
                $this->_options->frontend->customFrontendNaming,
                $this->_options->backend->customBackendNaming,
                $this->_options->frontendBackendAutoload
            );
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