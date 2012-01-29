<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Device\Handlers;

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
 * @version   SVN: $Id: GeneralDesktop.php 168 2012-01-22 16:26:29Z  $
 */

use Browscap\Device\Handler as DeviceHandler;

/**
 * CatchAllUserAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version   SVN: $Id: GeneralDesktop.php 168 2012-01-22 16:26:29Z  $
 */

class GeneralMobile extends DeviceHandler
{
    /**
     * Final Interceptor: Intercept
     * Everything that has not been trapped by a previous handler
     *
     * @param string $userAgent
     * @return boolean always true
     */
    public function canHandle($userAgent)
    {
        $mobiles = array(
            'Windows CE',
            'Windows Phone OS',
            'Windows Mobile',
            'Android',
            'Bada',
            'BREW',
            'Dalvik',
            'IphoneOSX',
            'iPhone OS',
            'like Mac OS X',
            'iPad',
            'IPad',
            'iPhone',
            'iPod',
            'MeeGo',
            'Nintendo Wii',
            'Nokia',
            'Series40',
            'BlackBerry',
            'RIM Tablet',
            'SymbianOS',
            'SymbOS',
            'Symbian',
            'Series 60',
            'Opera Mini',
            'Opera Mobi'
        );
        
        if ($this->utils->checkIfContainsAnyOf($userAgent, $mobiles)) {
            return true;
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
    protected function detectDevice($userAgent)
    {
        return 'general Mobile Device';
    }
    
    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 1;
    }
}