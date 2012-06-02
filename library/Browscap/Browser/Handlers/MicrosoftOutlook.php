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
class MicrosoftOutlook extends BrowserHandler
{
    /**
     * @var string the detected browser
     */
    protected $_browser = 'Microsoft Outlook';
    
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
        
        if (!$this->_utils->checkIfContainsAnyOf($this->_useragent, array('Outlook', 'Microsoft Office', 'MSOffice'))) {
            return false;
        }
        
        $isNotReallyAnIE = array(
            // using also the Trident rendering engine
            'Maxthon',
            'Galeon',
            'Lunascape',
            'Opera',
            'PaleMoon',
            'Flock',
            'AOL',
            'TOB',
            'MyIE',
            'Excel',
            'Word',
            'PowerPoint',
            //others
            'AppleWebKit',
            'Chrome',
            'Linux',
            'IEMobile',
            'BlackBerry',
            'WebTV',
            'WebWasher',
            // Outlook Express
            'Outlook-Express'
        );
        
        if ($this->_utils->checkIfContainsAnyOf($this->_useragent, $isNotReallyAnIE)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * detects the browser version from the given user agent
     *
     * @return string
     */
    protected function _detectVersion()
    {
        $doMatch = preg_match('/Microsoft Office Outlook (\d+\.\d+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $this->_mapVersion($matches[1]);
            return;
        }
        
        $doMatch = preg_match('/Microsoft Office Outlook (\d+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $this->_mapVersion($matches[1]);
            return;
        }
        
        $doMatch = preg_match('/Microsoft Outlook (\d+\.\d+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $this->_mapVersion($matches[1]);
            return;
        }
        
        $doMatch = preg_match('/Microsoft Outlook (\d+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $this->_mapVersion($matches[1]);
            return;
        }
        
        $doMatch = preg_match('/MSOffice (\d+\.\d+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $this->_mapVersion($matches[1]);
            return;
        }
        
        $doMatch = preg_match('/MSOffice (\d+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $this->_mapVersion($matches[1]);
            return;
        }
        
        $doMatch = preg_match('/Microsoft Office\/(\d+\.\d+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $this->_mapVersion($matches[1]);
            return;
        }
        
        $doMatch = preg_match('/Microsoft Office\/(\d+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $this->_mapVersion($matches[1]);
            return;
        }
        
        $this->_version = '';
    }
    
    private function _mapVersion($version)
    {
        if (14 == (int) $version) {
            return '2010';
        }
        
        if (12 == (int) $version) {
            return '2007';
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
        return 4200;
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
        return false;
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