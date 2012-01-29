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
 * @version   SVN: $Id$
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
 * @version   SVN: $Id$
 */
class Ios extends OsHandler
{
    /**
     * Intercept all UAs Starting with Mozilla and Containing MSIE and are not mobile browsers
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent)
    {
        if (!$this->utils->checkIfContainsAnyOf($userAgent, array('IphoneOSX', 'iPhone OS', 'like Mac OS X', 'iPad', 'IPad', 'iPhone', 'iPod'))) {
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
        return 'iOS';
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
        $doMatch = preg_match('/IphoneOSX\/([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return $matches[1];
        }
        
        $doMatch = preg_match('/CPU OS ([\d\_]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return str_replace('_', '.', $matches[1]);
        }
        
        $doMatch = preg_match('/CPU iPad OS ([\d\_]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return str_replace('_', '.', $matches[1]);
        }
        
        $doMatch = preg_match('/iPhone OS ([\d\_]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return str_replace('_', '.', $matches[1]);
        }
        
        $doMatch = preg_match('/CPU like Mac OS X/', $userAgent, $matches);
        
        if ($doMatch) {
            return '1.0';
        }
        
        $doMatch = preg_match('/iPhone OS ([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return str_replace('_', '.', $matches[1]);
        }
        
        $doMatch = preg_match('/iPhone_OS\/([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return str_replace('_', '.', $matches[1]);
        }
        
        return '';
    }
    
    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 404;
    }
}