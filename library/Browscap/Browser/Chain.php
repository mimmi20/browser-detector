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
    
    private $_log = null;
    
    private $_service = null;

    /**
     * Initializes the factory with an instance of all possible Handler objects from the given $context
     * @param WURFL_Context $context
     */
    public function __construct()
    {
        // the utility classes
        $this->utils    = new Utils();
        $this->_chain   = new \SplPriorityQueue();
        $this->_service = new Browsers();
        
        // get all Browsers
        $directory = __DIR__ . DS . 'Handlers' . DS;
        $iterator  = new \DirectoryIterator($directory);
        
        foreach ($iterator as $fileinfo) {
            if ($fileinfo->isFile() && $fileinfo->isReadable()) {
                $filename = $fileinfo->getBasename('.php');
                
                if ('CatchAll' != $filename) {
                    //echo "\t\t\t" . 'detecting Browser (Chain - add Browser [' . $filename . ', 1]): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
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
        echo "\t\t\t" . 'detecting Browser (Chain - init): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
        $browser = new \StdClass();
        $browser->browser    = 'unknown';
        $browser->version    = 0.0;
        $browser->bits       = 0;
        $browser->idBrowsers = null;
        echo "\t\t\t" . 'detecting Browser (Chain - creating result class): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
        if ($this->_chain->count()) {
            $this->_chain->top();
            echo "\t\t\t" . 'detecting Browser (Chain - go to top in chain): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
            while ($this->_chain->valid()) {
                $class = ltrim($this->_chain->current(), '\\');
                //$class = strtolower(str_replace(array('-', '_', ' ', '/', '\\'), ' ', $class));
                //$class = preg_replace('/[^a-zA-Z ]/', '', $class);
                //$class = str_replace(' ', '', ucwords($class));
                echo "\t\t\t" . 'detecting Browser (Chain - creating class name [' . $class . ']): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
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
                    echo "\t\t\t" . 'detecting Browser (Chain - can handle [' . $class . ']): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
                    try {
                        echo "\t\t\t" . 'detecting Browser (Chain - can handle [' . $class . '] - start): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
                        $browser = $handler->detect($userAgent);
                        
                        $browser->idBrowsers = $this->_service->searchByBrowser($browser->browser, $browser->version, $browser->bits)->idBrowsers;
                        echo "\t\t\t" . 'detecting Browser (Chain - can handle [' . $class . '] - end): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
                        return $browser;
                    } catch (\UnexpectedValueException $e) {
                        // do nothing
                        $this->_log->warn($e);
                        echo "\t\t\t" . 'detecting Browser (Chain - can not handle [' . $class . ']): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
                        $this->_chain->next();
                        continue;
                    }
                }
                echo "\t\t\t" . 'detecting Browser (Chain - can not handle [' . $class . ']): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
                $this->_chain->next();
            }
        }
        echo "\t\t\t" . 'detecting Browser (Chain - not found in chain): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
        //if not deteceted yet, use ini file as fallback
        $handler = new Handlers\CatchAll();
        if ($handler->canHandle($userAgent)) {
            $browser = $handler->detect($userAgent);
            //echo print_r($browser, true);
            $searchresult = $this->_service->searchByBrowser($browser->browser, $browser->version, $browser->bits);
            
            if ($searchresult) {
                $browser->idBrowsers = $searchresult->idBrowsers;
            }
            echo "\t\t\t" . 'detecting Browser (Chain - found in fallback [' . $browser->browser . ']): ' . (microtime(true) - START_TIME) . ' Sek.' . "\n";
            $class = ltrim($browser->browser, '\\');
            $class = strtolower(str_replace(array('-', '_', ' ', '/', '\\'), ' ', $class));
            $class = preg_replace('/[^a-zA-Z ]/', '', $class);
            $class = str_replace(' ', '', ucwords($class));
            $className = '\\' . __NAMESPACE__ . '\\Handlers\\' . $class;
            echo "Class '$className' not found \n";
            if ($browser->browser) {
                $this->_chain->insert($browser->browser, 1);
            }
            /*
            $allBrowsers = $handler->detectAll();
            foreach ($allBrowsers as $singleBrowser) {
                $bits = 0;
                
                if (!empty($singleBrowser['Win64']) && $singleBrowser['Win64']) {
                    $bits = 64;
                } elseif (!empty($singleBrowser['Win32']) && $singleBrowser['Win32']) {
                    $bits = 32;
                } elseif (!empty($singleBrowser['Win16']) && $singleBrowser['Win16']) {
                    $bits = 16;
                }
                
                if (!empty($singleBrowser['Browser'])) {
                    $this->_service->searchByBrowser($singleBrowser['Browser'], empty($singleBrowser['Version']) ? '0' : $singleBrowser['Version'], $bits);
                }
            }
            /**/
        }
        
        return $browser;
    }
}
