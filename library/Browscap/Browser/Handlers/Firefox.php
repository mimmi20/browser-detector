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
 * FirefoxUserAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class Firefox extends BrowserHandler
{
    /**
     * Intercept all UAs Containing Firefox and are not mobile browsers
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent)
    {
        if (!$this->utils->checkIfStartsWith($userAgent, 'Mozilla')) {
            return false;
        }
        
        if (!$this->utils->checkIfContainsAll($userAgent, array('Firefox', 'Gecko'))) {
            return false;
        }
        
        if ($this->utils->isSpamOrCrawler($userAgent)) {
            return false;
        }
        
        $isNotReallyAnFirefox = array(
            // using also the Gecko rendering engine
            'Maemo',
            'Maxthon',
            'Camino',
            'Galeon',
            'Lunascape',
            'Opera',
            'Navigator',
            'Palemoon',
            'SeaMonkey',
            'Flock',
            'Fennec'
        );
        
        if ($this->utils->checkIfContainsAnyOf($userAgent, $isNotReallyAnFirefox)) {
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
        $class->browser = $this->detectBrowser($userAgent);
        $class->version = $this->detectVersion($userAgent);
        $class->bits    = $this->detectBits($userAgent);
        
        return $class;
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
        return 'Firefox';
    }
    
    /**
     * detects the browser version from the given user agent
     *
     * @param string $userAgent
     *
     * @return float
     */
    protected function detectVersion($userAgent)
    {
        $doMatch = preg_match('/Firefox\/(\d+\.[\dab]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return (float) $matches[1];
        }
        
        return 0;
    }
    
    /**
     * detects the bit count by this browser from the given user agent
     *
     * @param string $userAgent
     *
     * @return integer
     */
    protected function detectBits($userAgent)
    {
        if ($this->utils->checkIfContainsAnyOf($userAgent, array('x64', 'Win64'))) {
            return 64;
        }
        
        if ($this->utils->checkIfContainsAnyOf($userAgent, array('Win31', 'Win3.1', 'Windows 3.1'))) {
            return 16;
        }
        
        if ($this->utils->checkIfContainsAnyOf($userAgent, array('Win', 'x86', 'i586', 'i686'))) {
            return 32;
        }
        
        return 0;
    }
}