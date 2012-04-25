<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Os;

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

use \Browscap\Utils;

/**
 * the platform database model
 */
use \Browscap\Service\Os;

/**
 * Manages the creation and instatiation of all User Agent Handlers and Normalizers and provides a factory for creating User Agent Handler Chains
 * @package    WURFL
 * @see WURFL_UserAgentHandlerChain
 */
final class Chain
{
    /**
     * @var array
     */
    private $_chain = null;
    
    /**
     * @var Browscap\Utils
     */
    private $_utils = null;
    
    /*
     * @var \Zend\Log\Logger
     */
    private $_log = null;

    /**
     * a \Zend\Cache object
     *
     * @var \Zend\Cache
     */
    private $_cache = null;

    /**
     * Initializes the factory with an instance of all possible WURFL_Handlers_Handler objects from the given $context
     */
    public function __construct()
    {
        // the utility classes
        $this->_utils = new Utils();
        $this->_chain = array();
        
        // get all OS
        $directory = __DIR__ . DS . 'Handlers' . DS;
        $iterator  = new \DirectoryIterator($directory);
        
        foreach ($iterator as $fileinfo) {
            if (!$fileinfo->isFile() || !$fileinfo->isReadable()) {
                continue;
            }
            
            $filename  = $fileinfo->getBasename('.php');
            $className = $this->_utils->getClassNameFromFile($filename, __NAMESPACE__, true);
            
            try {
                require_once $fileinfo->getPathname();
                $handler = new $className();
            } catch (\Exception $e) {
                echo "Class '$className' not found \n";
                
                //$this->_log->warn($e);
                
                continue;
            }
            
            $detector = array();
            $detector['class']  = $handler;
            $detector['weight'] = $handler->getWeight();
            
            $this->_chain[] = $detector;
        }
        
        $sorter = array();
        
        foreach ($this->_chain as $key => $detector) {
            $sorter[$key] = $detector['weight'];
        }
        
        array_multisort($sorter, SORT_DESC, $this->_chain);
        
        unset($iterator, $directory);
    }

    /**
     * 
     */
    public function __destruct()
    {
        // the utility classes
        $this->_utils = null;
        $this->_chain = null;
        $this->_log   = null;
    }
    
    /**
     * sets the logger used when errors occur
     *
     * @param \Zend\Log\Logger $logger
     *
     * @return 
     */
    public function setLogger(\Zend\Log\Logger $logger = null)
    {
        $this->_log = $logger;
        
        return $this;
    }
    
    /**
     * sets the cache used to make the detection faster
     *
     * @param \Zend\Cache\Frontend\Core $cache
     *
     * @return 
     */
    public function setCache(\Zend\Cache\Frontend\Core $cache)
    {
        $this->_cache = $cache;
        
        return $this;
    }
    
    /**
     * detect the user agent
     *
     * @param string $userAgent The user agent
     *
     * @return string
     */
    public function detect($userAgent)
    {
        if ('' == $userAgent) {
            throw new \Exception('no user agent given');
        }
        
        if (count($this->_chain)) {
            foreach ($this->_chain as $detector) {
                $handler = $detector['class'];
                $handler->setLogger($this->_log);
                $handler->setUseragent($userAgent);
                
                if ($handler->canHandle()) {
                    try {
                        return $handler->detect();
                    } catch (\UnexpectedValueException $e) {
                        // do nothing
                        $this->_log->warn($e);
                        
                        continue;
                    }
                }
            }
        }
        
        return new Handlers\Unknown();
    }
}