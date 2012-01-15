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
final class Chain
{
    /**
     * @var \
     */
    private $_chain = null;
    
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
        $this->_utils   = new Utils();
        $this->_chain   = array();
        $this->_service = new Browsers();
        $this->_log     = \Zend\Registry::get('log');
        
        // get all Browsers
        $directory = __DIR__ . DS . 'Handlers' . DS;
        $iterator  = new \DirectoryIterator($directory);
        
        foreach ($iterator as $fileinfo) {
            if ($fileinfo->isFile() && $fileinfo->isReadable()) {
                $filename = $fileinfo->getBasename('.php');
                
                if ('CatchAll' != $filename) {
                    $className = $this->_utils->getClassNameFromFile($filename, __NAMESPACE__, true);
                    
                    try {
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
        $this->_service = null;
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
        $browser             = new \StdClass();
        $browser->browser    = 'unknown';
        $browser->version    = 0.0;
        $browser->bits       = 0;
        $browser->idBrowsers = null;
        
        if (count($this->_chain)) {
            foreach ($this->_chain as $detector) {
                $handler = $detector['class'];
                
                if ($handler->canHandle($userAgent)) {
                    try {
                        return $handler->detect($userAgent);
                    } catch (\UnexpectedValueException $e) {
                        // do nothing
                        //$this->_log->warn($e);
                        
                        continue;
                    }
                }
            }
        }
        
        return $browser;
    }
}
