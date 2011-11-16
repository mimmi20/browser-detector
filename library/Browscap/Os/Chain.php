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
        
        //get all OS
        
        //get amount of calls for each OS
        
        //create list ordered by amount of calls
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
        $os = new \StdClass();
        $os->name    = 'unknown';
        $os->version = 'unknown';
        $os->bits    = 0;
        
        //$osModel = new Browsers();
        
        if ($this->_chain->count()) {
            $this->_chain->top();
            
            while ($this->_chain->valid()) {
                $class     = $this->_chain->current();
                $className = __NAMESPACE__ . '\\Handlers\\' . $class;
                $handler   = new $className();
                
                if ($handler->canHandle($userAgent)) {
                    $os = $handler->detect($userAgent);
                    var_dump($os);exit;
                    //$osModel->countByName($class);
                    
                    return $os;
                }
                
                $this->_chain->next();
            }
        }
        
        //if not deteceted yet, use ini file as fallback
        $handler = new Handlers\CatchAll();
        if ($handler->canHandle($userAgent)) {
            $os = $handler->detect($userAgent);
            //var_dump($os);exit;
            //$osModel->countByName($os->browser, $os->version, $os->bits);
        }
        
        return $os;
    }
}