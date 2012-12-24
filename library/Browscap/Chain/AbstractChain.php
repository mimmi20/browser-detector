<?php
namespace Browscap\Chain;

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
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */

use \Browscap\Helper\Utils;

/**
 * Manages the creation and instatiation of all User Agent Handlers and Normalizers and provides a factory for creating User Agent Handler Chains
 * @package   Browscap
 * @see WURFL_UserAgentHandlerChain
 */
abstract class AbstractChain
{
    /**
     * @var \SplPriorityQueue
     */
    protected $_chain = null;
    
    /**
     * @var Browscap\Helper\Utils
     */
    protected $_utils = null;

    /**
     * a \Zend\Cache object
     *
     * @var \Zend\Cache
     */
    protected $_cache = null;
    
    /** @var boolean */
    protected $_useHandlersFromDir = true;
    
    /** @var array */
    protected $_handlersToUse = null;
    
    /** @var mixed */
    protected $_defaultHandler = null;
    
    /** @var string */
    protected $_directory = '';
    
    /** @var string */
    protected $_namespace = '';
    
    /** @var string */
    protected $_userAgent = '';
    
    

    /**
     * @param boolean      $useHandlersFromDir
     * @param string|array $handlersToUse
     */
    public function __construct($useHandlersFromDir = true, $handlersToUse = null, $directory = null, $namespace = null)
    {
        // the utility classes
        $this->_utils = new Utils();
        $this->_useHandlersFromDir = $useHandlersFromDir;
        
        if (null !== $handlersToUse 
            && !is_array($handlersToUse) 
            && !is_string($handlersToUse)
        ) {
            $handlersToUse = null;
        }
        
        // transform into an array
        if (null !== $handlersToUse && !is_array($handlersToUse)) {
            $handlersToUse = array($handlersToUse);
        }
        
        $this->_handlersToUse = $handlersToUse;
        
        $this->_setDefaultDirectory();
        $this->_setDefaultNamspace();
        
        if (null !== $directory) {
            $this->setDirectory($directory);
        }
        
        if (null !== $namespace) {
            $this->setNamespace($namespace);
        }
    }

    /**
     * 
     */
    public function __destruct()
    {
        // the utility classes
        $this->_utils  = null;
        $this->_useHandlersFromDir = true;
        $this->_handlersToUse = null;
        $this->_defaultHandler = null;
        $this->_directory = '';
        $this->_namespace = '';
        $this->_cache = null;
    }
    
    protected function _createChain()
    {
        $chain = new \SplPriorityQueue();
        
        if ($this->_useHandlersFromDir) {
            // get all Handlers from the directory
            $iterator = new \DirectoryIterator($this->_directory);
            
            foreach ($iterator as $fileinfo) {
                if (!$fileinfo->isFile() || !$fileinfo->isReadable()) {
                    continue;
                }
                
                $filename = $fileinfo->getBasename('.php');
                
                if (null !== $this->_handlersToUse 
                    && !in_array($filename, $this->_handlersToUse)
                ) {
                    continue;
                }
                
                $className = $this->_utils->getClassNameFromFile(
                    $filename, $this->_namespace, true
                );
                
                try {
                    $handler = new $className();
                } catch (\Exception $e) {
                    continue;
                }
                
                $chain->insert($handler, $handler->getWeight());
            }
        } else {
            foreach ($this->_handlersToUse as $filename) {
                $className = $this->_utils->getClassNameFromFile(
                    $filename, $this->_namespace, true
                );
                
                $handler = new $className();
                
                $chain->insert($handler, $handler->getWeight());
            }
        }
        
        return $chain;
    }
    
    /**
     * sets the cache used to make the detection faster
     *
     * @param \Zend\Cache\Frontend\Core $cache
     *
     * @return 
     */
    final public function setCache(\Zend\Cache\Frontend\Core $cache)
    {
        if (!($cache instanceof \Zend\Cache\Frontend\Core)) {
            throw new \InvalidArgumentException(
                'the cache must be an instance of \\Zend\\Cache\\Frontend\\Core'
            );
        }
        
        $this->_cache = $cache;
        
        return $this;
    }
    
    /**
     * sets the cache used to make the detection faster
     *
     * @param mixed $handler
     *
     * @return 
     */
    final public function setDefaultHandler($handler)
    {
        $this->_defaultHandler = $handler;
        
        return $this;
    }
    
    /**
     * sets the actual directory where the chain is searching
     *
     * @param string $directory
     *
     * @return 
     */
    final public function setDirectory($directory)
    {
        $this->_directory = $directory;
        
        return $this;
    }
    
    /**
     * sets the actual directory where the chain is searching
     *
     * @param string $directory
     *
     * @return 
     */
    final public function setNamespace($namespace)
    {
        $this->_namespace = $namespace;
        
        return $this;
    }
    
    /**
     * sets the UserAgent
     *
     * @param string $agent
     *
     * @return 
     */
    final public function setUserAgent($agent)
    {
        $this->_userAgent = $agent;
        
        return $this;
    }
    
    /**
     * sets the default directory where the chain is searching 
     *
     * @return 
     */
    protected function _setDefaultDirectory()
    {
        $this->_directory = '';
        
        return $this;
    }
    
    /**
     * sets the cache used to make the detection faster
     *
     * @return 
     */
    protected function _setDefaultNamspace()
    {
        $this->_namespace = '';
        
        return $this;
    }
    
    /**
     * detect the user agent
     *
     * @return string
     */
    final public function detect()
    {
        $chain = $this->_createChain();
        
        return $this->_detect($chain);
    }
    
    /**
     * detect the user agent
     *
     * @param \SplPriorityQueue $chain
     *
     * @return string
     */
    protected function _detect(\SplPriorityQueue $chainInput)
    {
        $chain = clone $chainInput;
        
        if ($chain->count()) {
            $chain->top();
            
            while ($chain->valid()) {
                $handler = $chain->current();
                        $handler->setUserAgent($this->_userAgent);
                
                if ($this->_cache instanceof \Zend\Cache\Frontend\Core) {
                    $handler->setCache($this->_cache);
                }
                
                if ($handler->canHandle()) {
                    return $handler->detect();
                }
                
                $chain->next();
            }
        }
        
        if (null !== $this->_defaultHandler 
            && is_object($this->_defaultHandler)
        ) {
            $handler = $this->_defaultHandler;
        } else {
            $className = $this->_utils->getClassNameFromFile(
                'Unknown', $this->_namespace, true
            );
            $handler = new $className();
        }
        $handler->setUserAgent($this->_userAgent);
        
        if ($this->_cache instanceof \Zend\Cache\Frontend\Core) {
            $handler->setCache($this->_cache);
        }
        
        return $handler;
    }
}