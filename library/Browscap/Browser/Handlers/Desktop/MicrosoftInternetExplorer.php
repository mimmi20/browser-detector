<?php
namespace Browscap\Browser\Handlers\Desktop;

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
 * Handler Base class
 */
use Browscap\Browser\Handler as BrowserHandler;

/**
 * MSIEAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id$
 */
class MicrosoftInternetExplorer extends BrowserHandler
{
    /**
     * @var string the detected browser
     */
    protected $_browser = 'Internet Explorer';

    /**
     * @var string the detected manufacturer
     */
    protected $_manufacturer = 'microsoft';
    
    private $_patterns = array(
        '/Mozilla\/(4|5)\.0 \(.*MSIE 10\.0.*/' => '10.0',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 9\.0.*/'  => '9.0',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 8\.0.*/'  => '8.0',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 7\.0.*/'  => '7.0',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 6\.0.*/'  => '6.0',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 5\.5.*/'  => '5.5',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 5\.01.*/' => '5.01',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 5\.0.*/'  => '5.0',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 4\.01.*/' => '4.01',
        '/Mozilla\/(4|5)\.0 \(.*MSIE 4\.0.*/'  => '4.0',
        '/Mozilla\/.*\(.*MSIE 3\..*/'          => '3.0',
        '/Mozilla\/.*\(.*MSIE 2\..*/'          => '2.0',
        '/Mozilla\/.*\(.*MSIE 1\..*/'          => '1.0'
    );
    
    /**
     * Returns true if this handler can handle the given user agent
     *
     * @return bool
     */
    public function canHandle()
    {
        if ('' == $this->_useragent) {
            return false;
        }
        
        if (!$this->_utils->checkIfStartsWith('Mozilla/')) {
            return false;
        }
        
        if (!$this->_utils->checkIfContains('MSIE')) {
            return false;
        }
        
        $isNotReallyAnIE = array(
            'Gecko',
            'Presto',
            'Webkit',
            'KHTML',
            // using also the Trident rendering engine
            'Maxthon',
            'Galeon',
            'Lunascape',
            'Opera',
            'PaleMoon',
            'Flock',
            'MyIE',
            'Crazy Browser',
            // other Browsers
            'AppleWebKit',
            'Chrome',
            'Linux',
            'MSOffice',
            'Outlook',
            'IEMobile',
            'BlackBerry',
            'WebTV',
            'ArgClrInt',
            'Firefox',
            'MSIECrawler',
            // Fakes
            'Mac; Mac OS '
        );
        
        if ($this->_utils->checkIfContains($isNotReallyAnIE)
            && !$this->_utils->checkIfContains('Bitte Mozilla Firefox verwenden')
        ) {
            return false;
        }
        
        foreach (array_keys($this->_patterns) as $pattern) {
            if (preg_match($pattern, $this->_useragent)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * detects the browser version from the given user agent
     *
     * @return string
     */
    protected function _detectVersion()
    {
        $doMatch = preg_match('/MSIE ([\d\.]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $matches[1];
            return;
        }
        
        foreach ($this->_patterns as $pattern => $version) {
            if (preg_match($pattern, $this->_useragent)) {
                $this->_version = $version;
                return;
            }
        }
        
        $this->_version = '';
    }
    
    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 72994;
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
        return true;
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
        return true;
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
        return true;
    }
    
    /**
     * returns TRUE if the browser should be banned
     *
     * @return boolean
     */
    public function isBanned()
    {
        if ($this->_version <= 6) {
            return true;
        }
        
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
     * returns TRUE if the browser has a specific rendering engine
     *
     * @return boolean
     */
    public function hasEngine()
    {
        return true;
    }
    
    /**
     * returns null, if the browser does not have a specific rendering engine
     * returns the Engine Handler otherwise
     *
     * @return null|\Browscap\Os\Handler
     */
    public function getEngine()
    {
        $handler = new \Browscap\Engine\Handlers\Trident();
        $handler->setLogger($this->_logger);
        $handler->setUseragent($this->_useragent);
        
        return $handler->detect();
    }
}