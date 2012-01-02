<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Os;

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
 * @version    $id$
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
class Chain
{

    /**
     * @var \
     */
    private $_chain = null;
    
    protected $utils = null;
    
    private $_log = null;
    
    private $_service = null;

    /**
     * Initializes the factory with an instance of all possible WURFL_Handlers_Handler objects from the given $context
     * @param WURFL_Context $context
     */
    public function __construct()
    {
        // the utility classes
        $this->utils    = new Utils();
        $this->_chain   = new \SplPriorityQueue();
        $this->_service = new Os();
        
        // get all OS
        $directory = __DIR__ . DS . 'Handlers' . DS;
        $iterator  = new \DirectoryIterator($directory);
        
        foreach ($iterator as $fileinfo) {
            if ($fileinfo->isFile() && $fileinfo->isReadable()) {
                $filename = $fileinfo->getBasename('.php');
                
                if ('CatchAll' != $filename) {
                    //echo "\t\t\t" . 'detecting OS (Chain - add OS [' . $filename . ', 1]): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
                    
                    $this->_chain->insert($filename, 1);
                }
            }
        }
        
        $this->_log = \Zend\Registry::get('log');
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
        echo "\t\t\t" . 'detecting OS (Chain - init): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
        $os = new \StdClass();
        $os->name    = 'unknown';
        $os->version = 'unknown';
        $os->bits    = 0;
        echo "\t\t\t" . 'detecting OS (Chain - creating result class): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
        if ($this->_chain->count()) {
            $this->_chain->top();
            echo "\t\t\t" . 'detecting OS (Chain - go to top in chain): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
            while ($this->_chain->valid()) {
                $class = ltrim($this->_chain->current(), '\\');
                //$class = strtolower(str_replace(array('-', '_', ' ', '/', '\\'), ' ', $class));
                //$class = preg_replace('/[^a-zA-Z ]/', '', $class);
                //$class = str_replace(' ', '', ucwords($class));
                echo "\t\t\t" . 'detecting OS (Chain - creating class name [' . $class . ']): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
                $className = '\\' . __NAMESPACE__ . '\\Handlers\\' . $class;
                try {
                    $handler = new $className();
                } catch (\Exception $e) {
                    echo "Class '$className' not found \n";
                    
                    //$this->_log->warn($e);
                    
                    $this->_chain->next();
                    continue;
                }
                
                if ($handler->canHandle($userAgent)) {
                    echo "\t\t\t" . 'detecting OS (Chain - can handle [' . $class . ']): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
                    try {
                        echo "\t\t\t" . 'detecting OS (Chain - can handle [' . $class . '] - start): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
                        $os = $handler->detect($userAgent);
                        echo "\t\t\t" . 'detecting OS (Chain - can handle [' . $class . '] - end): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
                        return $os;
                    } catch (\UnexpectedValueException $e) {
                        // do nothing
                        //$this->_log->warn($e);
                        echo "\t\t\t" . 'detecting OS (Chain - can not handle [' . $class . ']): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
                        $this->_chain->next();
                        continue;
                    }
                }
                echo "\t\t\t" . 'detecting OS (Chain - can not handle [' . $class . ']): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
                $this->_chain->next();
            }
        }
        echo "\t\t\t" . 'detecting OS (Chain - not found in chain): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
        //if not deteceted yet, use ini file as fallback
        $handler = new Handlers\CatchAll();
        if ($handler->canHandle($userAgent)) {
            $os = $handler->detect($userAgent);
            echo "\t\t\t" . 'detecting OS (Chain - found in fallback [' . $os->name . ']): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
            $class = ltrim($os->name, '\\');
            $class = strtolower(str_replace(array('-', '_', ' ', '/', '\\'), ' ', $class));
            $class = preg_replace('/[^a-zA-Z ]/', '', $class);
            $class = str_replace(' ', '', ucwords($class));
            $className = '\\' . __NAMESPACE__ . '\\Handlers\\' . $class;
            echo "Class '$className' not found \n";
            $os->idOs = $this->_service->searchByName($os->name, $os->version, $os->bits)->idOs;
            
            if ($os->name) {
                $this->_chain->insert($os->name, 1);
            }
        }
        
        return $os;
    }
}