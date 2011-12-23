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
class InternetExplorer extends BrowserHandler
{
    /**
     * Intercept all UAs Starting with Mozilla and Containing MSIE and are not mobile browsers
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent)
    {
        if (!$this->utils->checkIfStartsWith($userAgent, 'Mozilla')) {
            return false;
        }
        
        if (!$this->utils->checkIfContainsAll($userAgent, array('MSIE'))) {
            return false;
        }
        
        if ($this->utils->isSpamOrCrawler($userAgent)) {
            return false;
        }
        
        $isNotReallyAnIE = array(
            // using also the Trident rendering engine
            'Maxthon',
            'Galeon',
            'Lunascape',
            'Opera',
            'Palemoon',
            'Flock',
            'Avant',
            'MyIE',
            'AppleWebKit',
            'Chrome',
            'Linux',
            'MSOffice',
            'Outlook',
            'IEMobile',
            'BlackBerry',
            'WebTV',
            'ArgClrInt'
        );
        
        if ($this->utils->checkIfContainsAnyOf($userAgent, $isNotReallyAnIE)) {
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
    protected function detectBrowser($userAgent, \StdClass $class = null)
    {
        $patterns = array(
            '/Mozilla\/5\.0 \(compatible; MSIE 10\.0.*/'      => 10.00,
            '/Mozilla\/5\.0 \(compatible; MSIE 9\.0.*/'       => 9.00,
            '/Mozilla\/4\.0 \(compatible; MSIE 8\.0.*/'       => 8.00,
            '/Mozilla\/4\.0 \(compatible; MSIE 7\.0.*/'       => 7.00,
            '/Mozilla\/4\.0 \(.*compatible.*;.*MSIE 6\.0.*/'  => 6.00,
            '/Mozilla\/4\.0 \(.*compatible.*;.*MSIE 5\.5.*/'  => 5.50,
            '/Mozilla\/4\.0 \(.*compatible.*;.*MSIE 5\.01.*/' => 5.01,
            '/Mozilla\/4\.0 \(.*compatible.*;.*MSIE 5\.0.*/'  => 5.00,
            '/Mozilla\/4\.0 \(.*compatible.*;.*MSIE 4\.01.*/' => 4.01,
            '/Mozilla\/4\.0 \(.*compatible.*;.*MSIE 4\.0.*/'  => 4.00,
            '/Mozilla\/.*\(.*compatible.*;.*MSIE 3\..*/'      => 3.00,
            '/Mozilla\/.*\(.*compatible.*;.*MSIE 2\..*/'      => 2.00
        );
        
        $class->browser = 'Internet Explorer';
        
        foreach ($patterns as $pattern => $version) {
            if (preg_match($pattern, $userAgent)) {
                $class->version = $version;
                
                return;
            }
        }
        
        throw new Exceptions\BrowserNotFoundException('Internet Explorer not detected in user agent (' . $userAgent . ')');
    }
}