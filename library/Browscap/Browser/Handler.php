<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Browser;

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

use \Browscap\Utils;

/**
 * WURFL_Handlers_Handler is the base class that combines the classification of
 * the user agents and the matching process.
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id$
 */
abstract class Handler implements MatcherInterface
{
    /**
     * @var string the user agent to handle
     */
    protected $_useragent = '';
    
    /**
     * @var \Zend\Log\Logger
     */
    protected $_logger = null;
    
    /**
     * @var \Browscap\Utils the helper class
     */
    protected $_utils = null;
    
    /**
     * @var string the detected browser
     */
    protected $_browser = 'unknown';
    
    /**
     * @var string the detected browser version
     */
    protected $_version = '';
    
    /**
     * @var string the bits of the detected browser
     */
    protected $_bits = '';
    
    /**
     * @param WURFL_Context $wurflContext
     * @param WURFL_Request_UserAgentNormalizer_Interface $this->_useragentNormalizer
     */
    public function __construct()
    {
        $this->_utils = new Utils();
    }
    
    /**
     * sets the logger used when errors occur
     *
     * @param \Zend\Log\Logger $logger
     *
     * @return 
     */
    final public function setLogger(\Zend\Log\Logger $logger = null)
    {
        $this->_logger = $logger;
        
        return $this;
    }
    
    /**
     * sets the user agent to be handled
     *
     * @return void
     */
    final public function setUserAgent($userAgent)
    {
        $this->_useragent = $userAgent;
        
        return $this;
    }
    
    /**
     * Returns true if this handler can handle the given user agent
     *
     * @return bool
     */
    public function canHandle()
    {
        return false;
    }
    
    /**
     * detects the browser name from the given user agent
     *
     * @return StdClass
     */
    final public function detect()
    {
        $this->_detectBits();
        $this->_detectVersion();
        
        return $this;
    }
    
    final public function getBrowser()
    {
        return $this->_browser;
    }
    
    final public function getVersion()
    {
        return $this->_version;
    }
    
    final public function getBits()
    {
        return $this->_bits;
    }
    
    final public function getFullBrowser($withBits = true)
    {
        $browser = $this->getBrowser();
        $version = $this->getVersion();
        $bits    = $this->getBits();
        
        return $browser . ($browser != $version && '' != $version ? ' ' . $version : '') . (($bits && $withBits) ? ' (' . $bits . ' Bit)' : '');
    }
    
    /**
     * detects the browser version from the given user agent
     *
     * @return void
     */
    protected function _detectVersion()
    {
        $this->_version = '';
        
        return $this;
    }
    
    /**
     * detects the bit count by this browser from the given user agent
     *
     * @return void
     */
    final protected function _detectBits()
    {
        // 64 bits
        if ($this->_utils->checkIfContainsAnyOf($this->_useragent, array('x64', 'Win64', 'x86_64', 'amd64', 'AMD64'))) {
            $this->_bits = '64';
            
            return $this;
        }
        
        // old deprecated 16 bit windows systems
        if ($this->_utils->checkIfContainsAnyOf($this->_useragent, array('Win3.1', 'Windows 3.1'))) {
            $this->_bits = '16';
            
            return $this;
        }
        
        // general windows or a 32 bit browser on a 64 bit system (WOW64)
        if ($this->_utils->checkIfContainsAnyOf($this->_useragent, array('Win', 'WOW64', 'i586', 'i686', 'i386', 'i486', 'i86'))) {
            $this->_bits = '32';
            
            return $this;
        }
        
        $this->_bits = '';
        
        return $this;
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
     * returns TRUE if the browser should be banned
     *
     * @return boolean
     */
    public function isBanned()
    {
        return false;
    }
    
    /**
     * returns TRUE if the browser is a Syndication Reader
     *
     * @return boolean
     */
    public function isSyndicationReader()
    {
        return false;
    }
    
    /**
     * returns TRUE if the browser supports VBScript
     *
     * @return boolean
     */
    public function isCrawler()
    {
        return false;
    }
    
    /**
     * returns TRUE if the browser is a Syndication Reader
     *
     * @return boolean
     */
    public function isTranscoder()
    {
        return false;
    }
    
    /**
     * returns TRUE if the browser supports RSS Feeds
     *
     * @return boolean
     */
    public function isRssSupported()
    {
        return false;
    }
    
    /**
     * returns TRUE if the browser supports PDF documents
     *
     * @return boolean
     */
    public function isPdfSupported()
    {
        return false;
    }
}