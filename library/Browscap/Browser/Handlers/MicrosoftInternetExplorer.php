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

/**
 * Handler Base class
 */
use Browscap\Browser\Handler as BrowserHandler;

/**
 * Browser Exceptions
 */
use Browscap\Browser\Exceptions;

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
class MicrosoftInternetExplorer extends BrowserHandler
{
    private $_patterns = array(
        '/Mozilla\/5\.0 \(compatible; MSIE 10\.0.*/'      => '10.0',
        '/Mozilla\/5\.0 \(compatible; MSIE 9\.0.*/'       => '9.0',
        '/Mozilla\/4\.0 \(compatible; MSIE 9\.0.*/'       => '9.0',
        '/Mozilla\/4\.0 \(compatible; MSIE 8\.0.*/'       => '8.0',
        '/Mozilla\/4\.0 \(compatible; MSIE 7\.0.*/'       => '7.0',
        '/Mozilla\/4\.0 \(.*compatible.*;.*MSIE 6\.0.*/'  => '6.0',
        '/Mozilla\/4\.0 \(.*compatible.*;.*MSIE 5\.5.*/'  => '5.5',
        '/Mozilla\/4\.0 \(.*compatible.*;.*MSIE 5\.01.*/' => '5.01',
        '/Mozilla\/4\.0 \(.*compatible.*;.*MSIE 5\.0.*/'  => '5.0',
        '/Mozilla\/4\.0 \(.*compatible.*;.*MSIE 4\.01.*/' => '4.01',
        '/Mozilla\/4\.0 \(.*compatible.*;.*MSIE 4\.0.*/'  => '4.0',
        '/Mozilla\/.*\(.*compatible.*;.*MSIE 3\..*/'      => '3.0',
        '/Mozilla\/.*\(.*compatible.*;.*MSIE 2\..*/'      => '2.0',
        '/Mozilla\/.*\(.*compatible.*;.*MSIE 1\..*/'      => '1.0'
    );
    
    /**
     * Intercept all UAs Starting with Mozilla and Containing MSIE and are not mobile browsers
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent)
    {
        if (!$this->utils->checkIfStartsWith($userAgent, 'Mozilla/')) {
            return false;
        }
        
        if (!$this->utils->checkIfContainsAll($userAgent, array('MSIE'))) {
            return false;
        }
        
        $isNotReallyAnIE = array(
            // using also the Trident rendering engine
            'Maxthon',
            'Galeon',
            'Lunascape',
            'Opera',
            'PaleMoon',
            'Flock',
            'Avant',
            'avantbrowser',
            'MyIE',
            // other Browsers
            'AppleWebKit',
            'Chrome',
            'Linux',
            'MSOffice',
            'Outlook',
            'IEMobile',
            'BlackBerry',
            'WebTV',
            'ArgClrInt',
            'Firefox',
            'MSIECrawler'
        );
        
        if ($this->utils->checkIfContainsAnyOf($userAgent, $isNotReallyAnIE)) {
            return false;
        }
        
        foreach (array_keys($this->_patterns) as $pattern) {
            if (preg_match($pattern, $userAgent)) {
                return true;
            }
        }
        
        return false;
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
        return 'Internet Explorer';
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
        $doMatch = preg_match('/MSIE ([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return $matches[1];
        }
        
        foreach ($this->_patterns as $pattern => $version) {
            if (preg_match($pattern, $userAgent)) {
                return $version;
            }
        }
        
        return '';
    }
    
    public function getWeight()
    {
        return 72994;
    }
}