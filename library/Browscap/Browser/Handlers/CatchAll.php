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
 * CatchAllUserAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version   SVN: $Id$
 */

class CatchAll extends BrowserHandler
{
    /**
     * Final Interceptor: Intercept
     * Everything that has not been trapped by a previous handler
     *
     * @return boolean always true
     */
    public function canHandle()
    {
        return true;
    }
    
    /**
     * detects the browser name from the given user agent
     *
     * @return StdClass
     */
    public function detect()
    {
        $detector = new \Browscap\Browscap();
        $detector->setLogger($this->_logger);
        
        $detected = $detector->getBrowser($this->_useragent);
        
        $class = new \StdClass();
        $class->browser     = $detected->Browser;
        $class->version     = $detected->Version;
        $class->browserFull = $class->browser . ($class->browser != $class->version && '' != $class->version ? ' ' . $class->version : '');
        
        if ($detected->Win64) {
            $class->bits = 64;
        } elseif ($detected->Win32) {
            $class->bits = 32;
        } elseif ($detected->Win16) {
            $class->bits = 16;
        } else {
            $class->bits = 0;
        }
        
        return $class;
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