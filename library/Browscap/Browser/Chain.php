<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Browser;

/**
 * Copyright(c) 2011 ScientiaMobile, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or(at your option) any later version.
 *
 * Refer to the COPYING file distributed with this package.
 *
 * @category   WURFL
 * @package    WURFL
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version   SVN: $Id$
 */

/**
 * Utility class which holds the detection functions
 */
use \Browscap\Utils;

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
    private $_chain = array();
    
    /**
     * @var Browscap\Utils
     */
    private $_utils = null;
    
    private $_log = null;
    
    private $_service = null;

    /**
     * Initializes the factory with an instance of all possible Handler objects from the given $context
     */
    public function __construct()
    {
        // the utility classes
        $this->_utils = new Utils();
        $this->_chain = array();
        $this->_log   = \Zend\Registry::get('log');
        
        // get all Browsers
        $directory = __DIR__ . DS . 'Handlers' . DS;
        $iterator  = new \DirectoryIterator($directory);
        
        foreach ($iterator as $fileinfo) {
            if ($fileinfo->isFile() && $fileinfo->isReadable()) {
                $filename = $fileinfo->getBasename('.php');
                
                if ('CatchAll' != $filename) {
                    $className = $this->_utils->getClassNameFromFile($filename, __NAMESPACE__, true);
                    //echo "\t\t\t" . 'detecting Browser (Chain - creating class name [' . $className . ']): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
                    try {
                        $handler = new $className();
                    } catch (\Exception $e) {
                        echo "Class '$className' not found \n";
                        
                        //$this->_log->warn($e);
                        
                        $this->_chain->next();
                        continue;
                    }
                    
                    $detector = array();
                    $detector['class']  = $handler;
                    $detector['weight'] = $handler->getWeight();
                    
                    $this->_chain[] = $detector;
                }
            }
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
        $this->_utils   = null;
        $this->_chain   = null;
        $this->_log     = null;
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
        $browser = new \StdClass();
        $browser->browser     = 'unknown';
        $browser->version     = '';
        $browser->bits        = 0;
        $browser->browserFull = 'unknown';
        
        if (count($this->_chain)) {
            foreach ($this->_chain as $detector) {
                $handler = $detector['class'];
                
                if ($handler->canHandle($userAgent)) {
                    //echo "\t\t\t" . 'detecting Browser (Chain - can handle [' . $class . ']): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
                    try {
                        //echo "\t\t\t" . 'detecting Browser (Chain - can handle [' . $class . '] - start): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
                        return $handler->detect($userAgent);
                    } catch (\UnexpectedValueException $e) {
                        // do nothing
                        //$this->_log->warn($e);
                        //echo "\t\t\t" . 'detecting Browser (Chain - can not handle [' . $class . '] - Exception): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
                        $this->_chain->next();
                        continue;
                    }
                }
            }
        }
        //echo "\t\t\t" . 'detecting Browser (Chain - not found in chain): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        //if not deteceted yet, use ini file as fallback
        $handler = new Handlers\CatchAll();
        if ($handler->canHandle($userAgent)) {
            $browser = $handler->detect($userAgent);
            
            //echo "\t\t\t" . 'detecting Browser (Chain - detect): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            
            if ($browser->browser) {
                try {
                    $className = $this->_utils->getClassNameFromDetected($browser->browser, __NAMESPACE__);
                    echo "Class '$className' not found \n";
                    $handler = new $className();
                    $this->_chain->insert($handler, $handler->getWeight());
                } catch (\Exception $e) {
                    //$this->_log->warn($e);
                }
            }
        }
        
        unset($handler);
        
        return $browser;
    }
}
