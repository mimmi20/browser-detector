<?php
namespace Browscap\Chain;

/**
 * Copyright (c) 2012 ScientiaMobile, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or(at your option) any later version.
 *
 * Refer to the COPYING.txt file distributed with this package.
 *
 * @category   WURFL
 * @package    WURFL
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id: Chain.php 219 2012-05-19 16:50:35Z  $
 */

use \Browscap\Utils;

/**
 * Manages the creation and instatiation of all User Agent Handlers and Normalizers and provides a factory for creating User Agent Handler Chains
 * @package    WURFL
 * @see WURFL_UserAgentHandlerChain
 */
abstract class AbstractChain
{
    /**
     * @var \SplPriorityQueue
     */
    protected $_chain = null;
    
    /**
     * @var Browscap\Utils
     */
    protected $_utils = null;
    
    /*
     * @var \Zend\Log\Logger
     */
    protected $_logger = null;

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

    /**
     * @param boolean      $useHandlersFromDir
     * @param string|array $handlersToUse
     */
    public function __construct($useHandlersFromDir = true, $handlersToUse = null)
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
    }

    /**
     * 
     */
    public function __destruct()
    {
        // the utility classes
        $this->_utils  = null;
        $this->_logger = null;
    }
    
    protected function _createChain($directory, $namespace)
    {
        $chain = new \SplPriorityQueue();
        
        if ($this->_useHandlersFromDir) {
            // get all Handlers from the directory
            $iterator = new \DirectoryIterator($directory);
            
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
                    $filename, $namespace, true
                );
                
                try {
                    $handler = new $className();
                } catch (\Exception $e) {
                    $this->_logger->err($e);
                    
                    continue;
                }
                
                $chain->insert($handler, $handler->getWeight());
            }
        } else {
            foreach ($this->_handlersToUse as $filename) {
                $className = $this->_utils->getClassNameFromFile(
                    $filename, $namespace, true
                );
                
                try {
                    $handler = new $className();
                } catch (\Exception $e) {
                    $this->_logger->err($e);
                    
                    continue;
                }
                
                $chain->insert($handler, $handler->getWeight());
            }
        }
        
        return $chain;
    }
    
    /**
     * sets the logger used when errors occur
     *
     * @param \Zend\Log\Logger $logger
     *
     * @return 
     */
    final public function setLogger(\Zend\Log\Logger $logger = null)
    {
        $this->_logger = $logger;
        
        return $this;
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
        $this->_cache = $cache;
        
        return $this;
    }
    
    /**
     * detect the user agent
     *
     * @param \SplPriorityQueue $chain
     * @param string            $userAgent The user agent
     * @param string            $namespace
     *
     * @return string
     */
    protected function _detect(\SplPriorityQueue $chainInput, $userAgent, $namespace)
    {
        $chain = clone $chainInput;
        
        if ($chain->count()) {
            $chain->top();
            
            while ($chain->valid()) {
                $handler = $chain->current();
                $handler->setLogger($this->_logger);
                $handler->setUserAgent($userAgent);
                
                if ($this->_cache instanceof \Zend\Cache\Frontend\Core) {
                    $handler->setCache($this->_cache);
                }
                
                if ($handler->canHandle()) {
                    try {
                        return $handler->detect();
                    } catch (\UnexpectedValueException $e) {
                        $this->_logger->err($e);
                    }
                }
                
                $chain->next();
            }
        }
        
        $className = $this->_utils->getClassNameFromFile(
            'Unknown', $namespace, true
        );
        $handler = new $className();
        $handler->setLogger($this->_logger);
        $handler->setUserAgent($userAgent);
        
        if ($this->_cache instanceof \Zend\Cache\Frontend\Core) {
            $handler->setCache($this->_cache);
        }
        
        return $handler;
    }
}