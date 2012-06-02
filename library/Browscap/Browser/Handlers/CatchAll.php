<?php
namespace Browscap\Browser\Handlers;

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
class CatchAll extends Unknown
{
    /**
     * Final Interceptor: Intercept
     * Everything that has not been trapped by a previous handler
     *
     * @return boolean always true
     */
    public function canHandle()
    {
        return false;
    }
    
    /**
     * detects the browser version from the given user agent
     *
     * @return string
     */
    protected function _detectVersion()
    {
        $detector = new \Browscap\Browscap();
        $detector->setLogger($this->_logger);
        
        $detected = $detector->getBrowser($this->_useragent);
        
        $this->_browser = $detected->Browser;
        $this->_version = $detected->Version;
        
        if ($detected->Win64) {
            $this->_bits = 64;
        } elseif ($detected->Win32) {
            $this->_bits = 32;
        } elseif ($detected->Win16) {
            $this->_bits = 16;
        } else {
            $this->_bits = 0;
        }
    }
    
    /**
     * detects the browser name from the given user agent
     *
     * @return StdClass
     */
    public function detectAll()
    {
        $detector = new \Browscap\Browscap();
        return $detector->getAllBrowsers();
    }
    
    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return -1;
    }
}