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
 * @version    SVN: $Id$
 */

use \Browscap\Helper\Utils;

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
     * @var Browscap\Helper\Utils
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
        $this->_logger = null;
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
                
                //$ex = new \Exception('Class:' . $className . ' Memory: ' . number_format(memory_get_usage(true), 0, ',', '.') . 'Bytes');
                //echo "\n\n" . $ex->getMessage() . "\n" . $ex->getTraceAsString() . "\n\n";
                
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
                    $filename, $this->_namespace, true
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
                $handler->setLogger($this->_logger);
                $handler->setUserAgent($this->_userAgent);
                
                if ($this->_cache instanceof \Zend\Cache\Frontend\Core) {
                    $handler->setCache($this->_cache);
                }
                
                if ($handler->canHandle()) {
                    try {
                        //$ex = new \Exception('Agent:' . $this->_userAgent . "\n" . 'Class:' . get_class($handler) . ' Memory: ' . number_format(memory_get_usage(true), 0, ',', '.') . 'Bytes');
                        //echo "\n\n" . $ex->getMessage() . "\n" . $ex->getTraceAsString() . "\n\n";
                        
                        return $handler->detect();
                    } catch (\UnexpectedValueException $e) {
                        $this->_logger->err($e);
                    }
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
        $handler->setLogger($this->_logger);
        $handler->setUserAgent($this->_userAgent);
        
        if ($this->_cache instanceof \Zend\Cache\Frontend\Core) {
            $handler->setCache($this->_cache);
        }
        
        return $handler;
    }
}