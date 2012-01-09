<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Browser\Handlers;

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

use Browscap\Browser\Handler as BrowserHandler;

/**
 * SafariHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class NetFront extends BrowserHandler
{
    /**
     * Intercept all UAs Starting with Mozilla and Containing Safari and are not mobile browsers
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent)
    {
        if (!$this->utils->checkIfContainsAnyOf($userAgent, array('NetFront/', 'NF/', 'NetFrontLifeBrowser/', 'NF3'))) {
            return false;
        }
        
        $isNotReallyAnSafari = array(
            // using also the KHTML rendering engine
            'Kindle',
            //Fakes
            'User agent',
            'User-Agent'
        );
        
        if ($this->utils->checkIfContainsAnyOf($userAgent, $isNotReallyAnSafari)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * detects the browser name from the given user agent
     *
     * @param string $userAgent
     *
     * @return string
     */
    protected function detectBrowser($userAgent)
    {
        return 'Access NetFront';
    }
    
    /**
     * detects the browser version from the given user agent
     *
     * @param string $userAgent
     *
     * @return string
     */
    protected function detectVersion($userAgent)
    {
        $doMatch = preg_match('/NetFront\/([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return $matches[1];
        }
        
        $doMatch = preg_match('/NF\/([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return $matches[1];
        }
        
        $doMatch = preg_match('/NetFrontLifeBrowser\/([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return $matches[1];
        }
        
        $doMatch = preg_match('/NF3 ([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return $matches[1];
        }
        
        $doMatch = preg_match('/NF([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return $matches[1];
        }
        
        return '';
    }
}