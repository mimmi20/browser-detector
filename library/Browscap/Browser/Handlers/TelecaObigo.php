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
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version   SVN: $Id$
 */

use Browscap\Browser\Handler as BrowserHandler;

/**
 * SonyEricssonUserAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version   SVN: $Id$
 */
class TelecaObigo extends BrowserHandler
{
    /**
     * Intercept all UAs containing 'Teleca-Obigo'
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent)
    {
        return $this->utils->checkIfContainsAnyOf($userAgent, array('Teleca', 'AU-MIC', 'MIC/', 'Obigo', 'ObigoInternetBrowser'));
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
        return 'Teleca-Obigo';
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
        $doMatch = preg_match('/MIC\/([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return $matches[1];
        }
        
        $doMatch = preg_match('/ObigoInternetBrowser\/([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return $matches[1];
        }
        
        $doMatch = preg_match('/Obigo Browser ([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return $matches[1];
        }
        
        $doMatch = preg_match('/Obigo\-Browser\/([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return $matches[1];
        }
        
        $doMatch = preg_match('/Teleca\-Obigo ([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return $matches[1];
        }
        
        $doMatch = preg_match('/Obigo\-Q05A\/([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return $matches[1];
        }
        
        $doMatch = preg_match('/TelecaBrowser\/([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return $matches[1];
        }
        
        $doMatch = preg_match('/Teleca\-Q([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return ltrim($matches[1], '0');
        }
        
        $doMatch = preg_match('/Obigo\-Q([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return ltrim($matches[1], '0');
        }
        
        $doMatch = preg_match('/Obigo\/Q([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return ltrim($matches[1], '0');
        }
        
        $doMatch = preg_match('/Teleca\/Q([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return ltrim($matches[1], '0');
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
        return 3;
    }
}
