<?php
namespace Browscap\Device\Handlers;

/**
 * Copyright (c) 2012 ScientiaMobile, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or(at your option) any later version.
 *
 * Refer to the COPYING.txt file distributed with this package.
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id$
 */

use Browscap\Device\Handler as DeviceHandler;

/**
 * CatchAllUserAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id$
 */

class GeneralDesktop extends DeviceHandler
{
    /**
     * @var string the detected device
     */
    protected $_device = 'general Desktop';
    
    /**
     * Final Interceptor: Intercept
     * Everything that has not been trapped by a previous handler
     *
     * @param string $this->_useragent
     * @return boolean always true
     */
    public function canHandle()
    {
        if ('' == $this->_useragent) {
            return false;
        }
        
        if ($this->_utils->isMobileBrowser($this->_useragent)) {
            return false;
        }
        
        $windows = array(
            'Win8', 'Win7', 'WinVista', 'WinXP', 'Win2000', 'Win98', 'Win95',
            'WinNT', 'Win31', 'WinME', 'Windows NT', 'Windows 98', 'Windows 95',
            'Windows 3.1', 'win9x/NT 4.90', 'Windows'
        );
        
        if ($this->_utils->checkIfContainsAnyOf($this->_useragent, $windows)
            || $this->_utils->checkIfContainsAnyOf($this->_useragent, array('Trident', 'Microsoft', 'Outlook', 'MSOffice', 'ms-office'))
        ) {
            return false;
        }
        
        $bots = array(
            'bot', 'spider'
        );
        
        if ($this->_utils->checkIfContainsAnyOf($this->_useragent, $bots)) {
            return false;
        }
        
        return true;
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
    
    /**
     * returns TRUE if the device is a mobile
     *
     * @return boolean
     */
    public function isMobileDevice()
    {
        return false;
    }
    
    /**
     * returns TRUE if the device supports RSS Feeds
     *
     * @return boolean
     */
    public function isRssSupported()
    {
        return true;
    }
    
    /**
     * returns TRUE if the device supports PDF documents
     *
     * @return boolean
     */
    public function isPdfSupported()
    {
        return true;
    }
}