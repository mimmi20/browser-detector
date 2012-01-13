<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Browser;

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

use \Browscap\Utils;

/**
 * WURFL_Handlers_Handler is the base class that combines the classification of
 * the user agents and the matching process.
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
abstract class Handler implements MatcherInterface
{
    /**
     * @var string Prefix for this User Agent Handler
     */
    protected $prefix = '';
    
    /**
     * @var WURFL_Logger_Interface
     */
    protected $logger = null;
    
    protected $utils = null;
    
    /**
     * @param WURFL_Context $wurflContext
     * @param WURFL_Request_UserAgentNormalizer_Interface $userAgentNormalizer
     */
    public function __construct()
    {
        $this->utils = new Utils();
    }
    
    /**
     * Returns true if this handler can handle the given $userAgent
     *
     * @param string $userAgent
     *
     * @return bool
     */
    public function canHandle($userAgent)
    {
        return false;
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
        $class->browser     = $this->detectBrowser($userAgent);
        $class->version     = $this->detectVersion($userAgent);
        $class->browserFull = $class->browser . ($class->browser != $class->version && '' != $class->version ? ' ' . $class->version : '');
        $class->bits        = $this->detectBits($userAgent);
        
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
     * @return string
     */
    protected function detectVersion($userAgent)
    {
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
        // 64 bits
        if ($this->utils->checkIfContainsAnyOf($userAgent, array('x64', 'Win64', 'x86_64', 'amd64', 'AMD64'))) {
            return 64;
        }
        
        // old deprecated 16 bit windows systems
        if ($this->utils->checkIfContainsAnyOf($userAgent, array('Win3.1', 'Windows 3.1'))) {
            return 16;
        }
        
        // general windows or a 32 bit browser on a 64 bit system (WOW64)
        if ($this->utils->checkIfContainsAnyOf($userAgent, array('Win', 'WOW64', 'i586', 'i686', 'i386', 'i486'))) {
            return 32;
        }
        
        return '';
    }
    
    public function getWeight()
    {
        return 1;
    }
}