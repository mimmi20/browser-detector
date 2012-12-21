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
 * the class to ache all model actions
 */
use \Zend\Cache\Cache;

/**
 * \AppCore\Model\Cache
 *
 * Cache proxy for models, proxies calls to the model to
 * the Zend_Cache class cache.
 *
 * @category  Browscap
 * @package   Browscap
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
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