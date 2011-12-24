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
use \Browscap\Model\Engines;

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

    /**
     * Initializes the factory with an instance of all possible WURFL_Handlers_Handler objects from the given $context
     * @param WURFL_Context $context
     */
    public function __construct()
    {
        $this->utils = new Utils();
        
        $this->_chain = new \SplPriorityQueue();
        
        // get all Engines
        $engineModel = new Engines();
        $allEngines  = $engineModel->getAll();
        
        foreach ($allEngines as $singleEngine) {
            $this->_chain->insert($singleEngine->name, $singleEngine->count);
        }
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
        $engine = new \StdClass();
        $engine->name = 'unknown';
        $engine->version = 0.0;
        
        if ($this->_chain->count()) {
            $this->_chain->top();
            
            while ($this->_chain->valid()) {
                $class = ltrim($this->_chain->current(), '\\');
                $class = strtolower(str_replace(array('-', '_', ' ', '/', '\\'), ' ', $class));
                $class = preg_replace('/[^a-zA-Z ]/', '', $class);
                $class = str_replace(' ', '', ucwords($class));
                
                $className = '\\' . __NAMESPACE__ . '\\Handlers\\' . $class;
                try {
                    $handler = new $className();
                } catch (\Exception $e) {
                    echo "Class '$className' not found \n";
                    
                    // TODO log this
                    
                    $this->_chain->next();
                    continue;
                }
                
                if ($handler->canHandle($userAgent)) {
                    return $handler->detect($userAgent);
                }
                
                $this->_chain->next();
            }
        }
        
        //if not deteceted yet, use ini file as fallback
        $handler = new Handlers\CatchAll();
        if ($handler->canHandle($userAgent)) {
            $engine = $handler->detect($userAgent);
        }
        
        return $engine;
    }
}