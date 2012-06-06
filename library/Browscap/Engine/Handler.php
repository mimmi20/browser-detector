<?php
namespace Browscap\Engine;

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
     * @var string the detected engine
     */
    protected $_engine = 'unknown';
    
    /**
     * @var string the detected engine version
     */
    protected $_version = '';

    /**
     * a \Zend\Cache object
     *
     * @var \Zend\Cache
     */
    protected $_cache = null;
    
    /**
     * @param WURFL_Context $wurflContext
     * @param WURFL_Request_UserAgentNormalizer_Interface $this->_useragentNormalizer
     */
    public function __construct()
    {
        $this->_utils = new Utils();
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
     * Returns true if this handler can handle the given user agent
     *
     * @return bool
     */
    public function canHandle()
    {
        return false;
    }
    
    final public function getEngine()
    {
        return $this->_engine;
    }
    
    final public function getVersion()
    {
        return $this->_version;
    }
    
    final public function getFullEngine()
    {
        $engine  = $this->getEngine();
        $version = $this->getVersion();
        
        return $engine . (($engine != $version && '' != $version) ? ' ' . $version : '');
    }
    
    /**
     * detects the browser name from the given user agent
     *
     * @return StdClass
     */
    final public function detect()
    {
        $this->_detectVersion();
        
        return $this;
    }
    
    /**
     * detects the browser version from the given user agent
     *
     * @return string
     */
    protected function _detectVersion()
    {
        $this->_version = '';
        
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
     * returns TRUE if the browser supports Frames
     *
     * @return boolean
     */
    public function supportsFrames()
    {
        return true;
    }
    
    /**
     * returns TRUE if the browser supports IFrames
     *
     * @return boolean
     */
    public function supportsIframes()
    {
        return true;
    }
    
    /**
     * returns TRUE if the browser supports Tables
     *
     * @return boolean
     */
    public function supportsTables()
    {
        return true;
    }
    
    /**
     * returns TRUE if the browser supports Cookies
     *
     * @return boolean
     */
    public function supportsCookies()
    {
        return true;
    }
    
    /**
     * returns TRUE if the browser supports BackgroundSounds
     *
     * @return boolean
     */
    public function supportsBackgroundSounds()
    {
        return false;
    }
    
    /**
     * returns TRUE if the browser supports JavaScript
     *
     * @return boolean
     */
    public function supportsJavaScript()
    {
        return true;
    }
    
    /**
     * returns TRUE if the browser supports VBScript
     *
     * @return boolean
     */
    public function supportsVbScript()
    {
        return false;
    }
    
    /**
     * returns TRUE if the browser supports Java Applets
     *
     * @return boolean
     */
    public function supportsJavaApplets()
    {
        return true;
    }
    
    /**
     * returns TRUE if the browser supports ActiveX Controls
     *
     * @return boolean
     */
    public function supportsActivexControls()
    {
        return false;
    }
}