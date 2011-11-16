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
 * @version    $id$
 */

/**
 * Utility class which holds the detection functions
 */
use \Browscap\Utils;

/**
 * the browser database model
 */
use \Browscap\Service\Browsers;

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
    
    /**
     * @var Browscap\Utils
     */
    protected $utils = null;
    
    /**
     * @var Browscap\Browser\Handler
     */
    protected $handler = null;

    /**
     * Initializes the factory with an instance of all possible WURFL_Handlers_Handler objects from the given $context
     * @param WURFL_Context $context
     */
    public function __construct()
    {
        // the utility classes
        $this->utils  = new Utils();
        $this->_chain = new \SplPriorityQueue();
        
        // get all Browsers
        $browserModel = new Browsers();
        $allBrowsers  = $browserModel->getAll();
        
        foreach ($allBrowsers as $singleBrowser) {
            $this->_chain->insert($singleBrowser->name, $singleBrowser->count);
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
        $browser = new \StdClass();
        $browser->browser = 'unknown';
        $browser->version = 0.0;
        $browser->bits    = 0;
        
        $browserModel = new Browsers();
        
        if ($this->_chain->count()) {
            $this->_chain->top();
            
            while ($this->_chain->valid()) {
                $class     = $this->_chain->current();
                $className = __NAMESPACE__ . '\\Handlers\\' . $class;
                $handler   = new $className();
                
                if ($handler->canHandle($userAgent)) {
                    $browser = $handler->detect($userAgent);
                    var_dump($browser);exit;
                    $browserModel->countByName($class);
                    
                    return $browser;
                }
                
                $this->_chain->next();
            }
        }
        
        //if not deteceted yet, use ini file as fallback
        $handler = new Handlers\CatchAll();
        if ($handler->canHandle($userAgent)) {
            $browser = $handler->detect($userAgent);
            //var_dump($browser);exit;
            $browserModel->countByName($browser->browser, $browser->version, $browser->bits);
        }
        
        return $browser;
    }
}