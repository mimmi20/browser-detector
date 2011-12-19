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
 * @version    $id$
 */

use Browscap\Browser\Handler as BrowserHandler;

/**
 * SamsungUserAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class Samsung extends BrowserHandler
{
    /**
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent) {
        return $this->utils->checkIfContains($userAgent, 'Samsung/SGH')
                || $this->utils->checkIfStartsWithAnyOf($userAgent, array('SEC-','Samsung','SAMSUNG', 'SPH', 'SGH', 'SCH'));
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
        $class->browser = $this->detectBrowser($userAgent);
        $class->version = $this->detectVersion($userAgent);
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
    protected function detectBrowser($userAgent)
    {
        return 'unknown';
    }
    
    /**
     * detects the browser version from the given user agent
     *
     * @param string $userAgent
     *
     * @return float
     */
    protected function detectVersion($userAgent)
    {
        return 0.0;
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
        return 0;
    }

 
    private function tolerance($userAgent)
    {
        if($this->utils->checkIfStartsWithAnyOf($userAgent, array('SEC-', 'SAMSUNG-', 'SCH'))) {
            return $this->utils->firstSlash($userAgent);
        }
        if($this->utils->checkIfStartsWithAnyOf($userAgent, array('Samsung-','SPH', 'SGH'))) {
            return $this->utils->firstSpace($userAgent);
        }
        if($this->utils->checkIfStartsWith($userAgent, 'SAMSUNG/')) {
            return $this->utils->secondSlash($userAgent);
        }
        return $this->utils->firstSlash($userAgent);
    }

    protected $prefix = 'SAMSUNG';
}

