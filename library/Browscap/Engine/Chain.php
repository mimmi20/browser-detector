<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Engine;

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
 * the engine database model
 */
use \Browscap\Service\Engines;

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
        $this->utils = new Utils();
        
        $this->_chain = new \SplPriorityQueue();
        
        // get all Engines
        $this->_service = new Engines();
        $allEngines     = $this->_service->getAll();
        
        foreach ($allEngines as $singleEngine) {
            if ($singleEngine->name) {
                echo "\t\t\t" . 'detecting rendering Engine (Chain - add Engine [' . $singleEngine->name . ', ' . $singleEngine->count . ']): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
                $this->_chain->insert($singleEngine->name, $singleEngine->count);
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
        echo "\t\t\t" . 'detecting rendering Engine (Chain - init): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
        $engine = new \StdClass();
        $engine->name = 'unknown';
        $engine->version = 0.0;
        echo "\t\t\t" . 'detecting rendering Engine (Chain - creating result class): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
        if ($this->_chain->count()) {
            $this->_chain->top();
            echo "\t\t\t" . 'detecting rendering Engine (Chain - go to top in chain): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
            while ($this->_chain->valid()) {
                $class = ltrim($this->_chain->current(), '\\');
                $class = strtolower(str_replace(array('-', '_', ' ', '/', '\\'), ' ', $class));
                $class = preg_replace('/[^a-zA-Z ]/', '', $class);
                $class = str_replace(' ', '', ucwords($class));
                echo "\t\t\t" . 'detecting rendering Engine (Chain - creating class name [' . $class . ']): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
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
                    echo "\t\t\t" . 'detecting rendering Engine (Chain - can handle [' . $class . ']): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
                    try {
                        echo "\t\t\t" . 'detecting rendering Engine (Chain - can handle [' . $class . '] - start): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
                        $engine = $handler->detect($userAgent);
                        echo "\t\t\t" . 'detecting rendering Engine (Chain - can handle [' . $class . '] - end): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
                        return $engine;
                    } catch (\UnexpectedValueException $e) {
                        // do nothing
                        $this->_log->warn($e);
                        echo "\t\t\t" . 'detecting rendering Engine (Chain - can not handle): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
                        $this->_chain->next();
                        continue;
                    }
                }
                
                $this->_chain->next();
            }
        }
        echo "\t\t\t" . 'detecting rendering Engine (Chain - not found in chain): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
        //if not deteceted yet, use ini file as fallback
        $handler = new Handlers\CatchAll();
        if ($handler->canHandle($userAgent)) {
            $engine = $handler->detect($userAgent);
            echo "\t\t\t" . 'detecting rendering Engine (Chain - found in fallback [' . $engine->engine . ']): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";var_dump($userAgent, $engine);
            if ($engine->engine) {
                $this->_chain->insert($engine->engine, 1);
            }
        }
        
        return $engine;
    }
}