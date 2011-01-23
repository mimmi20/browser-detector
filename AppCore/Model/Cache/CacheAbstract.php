<?php
declare(ENCODING = 'iso-8859-1');
namespace Credit\Core\Model\Cache;

/**
 * \Credit\Core\Model\Cache_Abstract
 *
 * Cache proxy for models, proxies calls to the model to
 * the Zend_Cache class cache.
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: CacheAbstract.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * \Credit\Core\Model\Cache_Abstract
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
    protected $_classMethods;

    /**
     * @var Zend_Cache
     */
    protected $_cache;

    /**
     * @var string Frontend cache type, should be Class
     */
    protected $_frontend;

    /**
     * @var string Backend cache type
     */
    protected $_backend;

    /**
     * @var array Frontend options
     */
    protected $_frontendOptions = array();

    /**
     * @var array Backend options
     */
    protected $_backendOptions = array();

    /**
     * @var \Credit\Core\Model\Abstract
     */
    protected $_model;

    /**
     * @var string The tag this call will be stored against
     */
    protected $_tagged;

    /**
     * @var Zend_Config
     */
    //protected $_config = null;

    /**
     * Constructor
     *
     * @param \Credit\Core\Model\ModelAbstract $model
     * @param array|Zend_Config $options
     */
    public function __construct(
        \Credit\Core\Model\ModelAbstract $model,
        $options = null,
        $tagged = null)
    {
        $this->_model  = $model;

        if (!empty($options) && $options instanceof Zend_Config) {
            $options = $options->toArray();
        }

        if (!empty($options) && is_array($options)) {
            $this->setOptions($options);
        }

        if (!empty($tagged)) {
            $this->setTagged($tagged);
        }
    }

   /**
    * Set options using setter methods
    *
    * @param array $options
    * @return \Credit\Core\Model\Abstract
    */
    public function setOptions(array $options)
    {
        if (null === $this->_classMethods) {
            $this->_classMethods = get_class_methods($this);
        }
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $this->_classMethods)) {
                $this->$method($value);
            }
        }
        return $this;
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
        $config = \Zend\Registry::get('_config');

        if ($config->modelcache->enable) {
            if (null === $this->_cache) {
                $this->_cache = \Zend\Cache\Cache::factory(
                    $this->_frontend,
                    $this->_backend,
                    $this->_frontendOptions,
                    $this->_backendOptions
                );
            }
            return $this->_cache;
        } else {
            return $this->_model;
        }
    }

    /**
     * Set the frontend options
     *
     * @param array $frontend
     */
    public function setFrontendOptions(array $frontend)
    {
        $this->_frontendOptions = $frontend;
        $this->_frontendOptions['cached_entity'] = $this->_model;
    }

    /**
     * Set the backend options
     *
     * @param array $backend
     */
    public function setBackendOptions(array $backend)
    {
        $this->_backendOptions = $backend;
    }

    /**
     * Set the backend cache type
     *
     * @param string $backend
     */
    public function setBackend($backend)
    {
        $this->_backend = $backend;
    }

    /**
     * Set the frontend cache type
     *
     * @param string $frontend
     */
    public function setFrontend($frontend)
    {
        if ('ClassFrontend' != $frontend) {
            throw new \Zend\Exception(
                'Frontend type must be \'ClassFrontend\''
            );
        }
        $this->_frontend = $frontend;
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
            throw new \Zend\Exception(
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