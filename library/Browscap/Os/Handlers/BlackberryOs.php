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
class BlackberryOs extends Linux
{
    /**
     * Intercept all UAs Starting with Mozilla and Containing MSIE and are not mobile browsers
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent)
    {
        if (!$this->utils->checkIfContainsAll($userAgent, array('BlackBerry'))) {
            return false;
        }
        
        $isNotReallyAWindows = array(
            //Fakes
            'User agent',
            'User-Agent'
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
     * @return string
     */
    protected function detectBrowser($userAgent)
    {
        return 'BlackberryOs';
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
        $doMatch = preg_match('/BlackBerry\/([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return $matches[1];
        }
        
        return '';
    }
    
    public function getWeight()
    {
        return 4;
    }
}