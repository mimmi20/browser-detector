<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Engine\Handlers;

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
     * @param string $this->_useragent
     * @return boolean always true
     */
    public function canHandle($this->_useragent)
    {
        return true;
    }
    
    /**
     * detects the browser name from the given user agent
     *
     * @param string $this->_useragent
     *
     * @return StdClass
     */
    public function detect($this->_useragent)
    {
        $class = new \StdClass();
        
        $detector = new \Browscap\Browscap();
        $detected = $detector->getBrowser($this->_useragent);
        
        $class->engine     = $detected->renderEngine;
        $class->version    = $this->detectVersion($this->_useragent, $class->engine);
        $class->engineFull = $class->engine . ($class->engine != $class->version && '' != $class->version ? ' ' . $class->version : '');
        
        return $class;
    }
    
    /**
     * detects the browser version from the given user agent
     *
     * @param string $this->_useragent
     *
     * @return string
     */
    protected function detectVersion($this->_useragent, $engine = '')
    {
        $version = '';
        
        $doMatch = preg_match('/' . $engine . '\/([\d\.]+)/', $this->_useragent, $matches);
        
        if ($doMatch && '0' != $matches[1]) {
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
        return -1;
    }
}