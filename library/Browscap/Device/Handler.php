<?php
namespace Browscap\Device;

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

use \Browscap\Helper\Utils;

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
     * @var \Browscap\Helper\Utils the helper class
     */
    protected $_utils = null;
    
    /**
     * @var string the detected device
     */
    protected $_device = 'unknown';
    
    /**
     * @var string the detected device version
     */
    protected $_version = '';

    /**
     * @var string the detected manufacturer
     */
    protected $_manufacturer = 'unknown';
    
    /**
     * a \Zend\Cache object
     *
     * @var \Zend\Cache
     */
    protected $_cache = null;
    
    /**
     * @param WURFL_Context $wurflContext
     * @param WURFL_Request_UserAgentNormalizer_Interface $userAgentNormalizer
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
        $this->_utils->setLogger($logger);
        
        return $this;
    }
    
    /**
     * sets the cache used to make the detection faster
     *
     * @param \Zend\Cache\Frontend\Core $cache
     *
     * @return 
     */
    final public function setCache(\Zend\Cache\Frontend\Core $cache)
    {
        $this->_cache = $cache;
        
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
        $this->_utils->setUserAgent($userAgent);
        
        return $this;
    }
    
    /**
     * Returns true if this handler can handle the given $userAgent
     *
     * @param string $userAgent
     *
     * @return bool
     */
    public function canHandle()
    {
        return false;
    }
    
    /**
     * detects the device name from the given user agent
     *
     * @param string $userAgent
     *
     * @return StdClass
     */
    public function detect()
    {
        return $this;
    }
    
    /**
     * returns the name of the actual device without version
     *
     * @return string
     */
    final public function getDevice()
    {
        return $this->_device;
    }
    
    /**
     * returns the veraion of the actual device
     *
     * @return string
     */
    final public function getVersion()
    {
        return $this->_version;
    }
    
    /**
     * returns the name of the actual device with version
     *
     * @return string
     */
    final public function getFullDevice()
    {
        $device  = $this->getDevice();
        $version = $this->getVersion();
        
        return $device . ($device != $version && '' != $version ? ' ' . $version : '');
    }
    
    /**
     * returns the manufacturer of the actual device
     *
     * @return string
     */
    final public function getManufacturer()
    {
        return $this->_manufacturer;
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
     * returns TRUE if the device is a tablet
     *
     * @return boolean
     */
    public function isTablet()
    {
        return false;
    }
    
    /**
     * returns TRUE if the browser should be banned
     *
     * @return boolean
     */
    public function isDesktop()
    {
        return false;
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
     * returns TRUE if the device supports RSS Feeds
     *
     * @return boolean
     */
    public function isRssSupported()
    {
        return false;
    }
    
    /**
     * returns TRUE if the device supports PDF documents
     *
     * @return boolean
     */
    public function isPdfSupported()
    {
        return false;
    }
    
    /**
     * returns TRUE if the device has a specific Operating System
     *
     * @return boolean
     */
    public function hasOs()
    {
        return false;
    }
    
    /**
     * returns null, if the device does not have a specific Operating System
     * returns the OS Handler otherwise
     *
     * @return null|\Browscap\Os\Handler
     */
    public function getOs()
    {
        return null;
    }
    
    /**
     * returns TRUE if the device has a specific Browser
     *
     * @return boolean
     */
    public function hasBrowser()
    {
        return false;
    }
    
    /**
     * returns null, if the device does not have a specific Browser
     * returns the Browser Handler otherwise
     *
     * @return null|\Browscap\Os\Handler
     */
    public function getBrowser()
    {
        return null;
    }
}