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
 * @version   SVN: $Id$
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
 * @version   SVN: $Id$
 */
class Netscape extends BrowserHandler
{
    /**
     * Intercept all UAs Containing Firefox and are not mobile browsers
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent)
    {
        if (!$this->utils->checkIfStartsWith($userAgent, 'Mozilla/')) {
            return false;
        }
        
        $isNotReallyAnFirefox = array(
            // using also the Gecko rendering engine
            'Firefox',
            'Maemo',
            'Maxthon',
            'Camino',
            'Galeon',
            'Lunascape',
            'Opera',
            'Navigator',
            'PaleMoon',
            'SeaMonkey',
            'Flock',
            'Fennec',
            //Nutch
            'Nutch',
            'CazoodleBot',
            'LOOQ',
            // using the Trident rendering engine
            'MSIE',
            'AOL',
            'TOB',
            'Avant',
            'MyIE',
            'AppleWebKit',
            'Chrome',
            'MSOffice',
            'Outlook',
            'IEMobile',
            'BlackBerry',
            'WebTV',
            'ArgClrInt',
            // using the KHTML rendering engine
            'AppleWebKit',
            'Chrome',
            'Chromium',
            'Iron',
            'Rockmelt',
            'libwww',
            // Fakes
            'Mac; Mac OS '
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
     * @return string
     */
    protected function detectBrowser($userAgent)
    {
        return 'Netscape';
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
        $doMatch = preg_match('/rv\:([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return $matches[1];
        }
        
        $doMatch = preg_match('/Mozilla\/([\d\.]+)/', $userAgent, $matches);
        
        if ($doMatch) {
            return $matches[1];
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
        return 2;
    }
}