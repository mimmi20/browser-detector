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
class Windows extends OsHandler
{
    private $_windows = array(
        'Win8', 'Win7', 'WinVista', 'WinXP', 'Win2000', 'Win98', 'Win95',
        'WinNT', 'Win31', 'WinME', 'Windows NT', 'Windows 98', 'Windows 95',
        'Windows 3.1', 'win9x/NT 4.90', 'Windows'
    );
    
    /**
     * Intercept all UAs Starting with Mozilla and Containing MSIE and are not mobile browsers
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent)
    {
        if (!$this->utils->checkIfContainsAnyOf($userAgent, $this->_windows)
            && !$this->utils->checkIfContainsAnyOf($userAgent, array('Trident', 'Microsoft', 'Outlook', 'MSOffice', 'ms-office'))
        ) {
            return false;
        }
        
        $isNotReallyAWindows = array(
            // using also the Trident rendering engine
            'Linux',
            'Macintosh',
            'Mac OS X',
            'Windows CE',
            'Windows Phone OS',
            'IEMobile'
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
        return 'Windows';
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
        $doMatch = preg_match('/Windows NT ([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            switch ($matches[1]) {
                case '6.2':
                    $version = '8';
                    break;
                case '6.1':
                    $version = '7';
                    break;
                case '6.0':
                    $version = 'Vista';
                    break;
                case '5.3':
                    $version = 'Server 2003';
                    break;
                case '5.2':
                    $version = 'Server 2003';
                    break;
                case '5.1':
                    $version = 'XP';
                    break;
                case '5.0':
                case '5.01':
                    $version = '2000';
                    break;
                case '4.0':
                default:
                    $version = 'NT';
                    break;
            }
            
            return $version;
        }
        
        $doMatch = preg_match('/Windows ([\d\.XP]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            switch ($matches[1]) {
                case '6.2':
                    $version = '8';
                    break;
                case '6.1':
                case '7':
                    $version = '7';
                    break;
                case '6.0':
                    $version = 'Vista';
                    break;
                case '5.2':
                    $version = '2003';
                    break;
                case '5.1':
                case 'XP':
                    $version = 'XP';
                    break;
                case '2000':
                case '5.0':
                case '5.01':
                    $version = '2000';
                    break;
                case '3.1':
                    $version = '3.1';
                    break;
                case '95':
                    $version = '95';
                    break;
                case '98':
                    $version = '98';
                    break;
                case '4.0':
                default:
                    $version = 'NT';
                    break;
            }
            
            return $version;
        }
        
        if ($this->utils->checkIfContainsAnyOf($userAgent, array('win9x/NT 4.90', 'Win 9x 4.90', 'Windows ME'))) {
            return 'ME';
        }
        
        $version = '';
        
        foreach ($this->_windows as $winVersion) {
            if ($this->utils->checkIfContains($userAgent, $winVersion)) {
                $version = substr($winVersion, 3);
                break;
            }
        }
        
        if ('dows NT' != $version) {
            return $version;
        }
        
        return '';
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
        if ($this->utils->checkIfContainsAnyOf($userAgent, array('x64', 'Win64', 'WOW64'))) {
            return 64;
        }
        
        if ($this->utils->checkIfContainsAnyOf($userAgent, array('Win31', 'Win3.1', 'Windows 3.1'))) {
            return 16;
        }
        
        return 32;
    }
    
    public function getWeight()
    {
        return 92993;
    }
}