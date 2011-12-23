<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Os\Handlers;

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
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */

use Browscap\Os\Handler as OsHandler;

/**
 * MSIEAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class WindowsMobileOs extends OsHandler
{
    private $_windows = array(
        'Windows CE', 'Windows Phone OS'
    );
    
    /**
     * Intercept all UAs Starting with Mozilla and Containing MSIE and are not mobile browsers
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent)
    {
        if (!$this->utils->checkIfContainsAnyOf($userAgent, $this->_windows)) {
            return false;
        }
        
        $isNotReallyAWindows = array(
            // using also the Trident rendering engine
            'Linux',
        );
        
        if ($this->utils->checkIfContainsAnyOf($userAgent, $isNotReallyAWindows)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * detects the browser name from the given user agent
     *
     * @param string $userAgent
     *
     * @return StdClass
     */
    public function detect($userAgent)
    {
        $class = new \StdClass();
        $this->detectBrowser($userAgent, $class);
        $class->osFull  = $class->name . ' ' . $class->version;
        $class->bits    = 0;
        
        return $class;
    }
    
    /**
     * detects the browser name from the given user agent
     *
     * @param string $userAgent
     *
     * @return string
     */
    protected function detectBrowser($userAgent, $class = null)
    {
        $class->name    = 'Windows Mobile OS';
        
        if (!$this->utils->checkIfContains($userAgent, 'Windows CE')) {
            $class->version = '6.0 (CE)';
            
            return;
        }
        $doMatch = preg_match('/Windows Phone OS (\d+\.\d+)/', $userAgent, $matches);
        
        if ($doMatch) {
            $class->version = $matches[1];
            return;
        }
        
        $class->version = '';
    }
}