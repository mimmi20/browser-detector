<?php
declare(ENCODING = 'utf-8');
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

use Browscap\Browser\Handler as BrowserHandler;

/**
 * SafariHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id$
 */
class Safari extends BrowserHandler
{
    /**
     * @var string the detected browser
     */
    protected $_browser = 'Safari';
    
    /**
     * Returns true if this handler can handle the given user agent
     *
     * @return bool
     */
    public function canHandle()
    {
        if (!$this->_utils->checkIfStartsWith($this->_useragent, 'Mozilla/')
            && !$this->_utils->checkIfStartsWith($this->_useragent, 'Safari')
        ) {
            return false;
        }
        
        if (!$this->_utils->checkIfContainsAnyOf($this->_useragent, array('Safari', 'AppleWebKit', 'CFNetwork'))) {
            return false;
        }
        
        $isNotReallyAnSafari = array(
            // using also the KHTML rendering engine
            'Chrome',
            'Chromium',
            'Flock',
            'Galeon',
            'Lunascape',
            'Iron',
            'Maemo',
            'PaleMoon',
            'Rockmelt',
            'rekonq',
            'OmniWeb',
            'Silk',
            'MQQBrowser',
            'konqueror',
            'Epiphany',
            'Shiira',
            //mobile Version
            'Mobile',
            'Tablet',
            'Android',
            // Fakes
            'Mac; Mac OS '
        );
        
        if ($this->_utils->checkIfContainsAnyOf($this->_useragent, $isNotReallyAnSafari)) {
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
        $doMatch = preg_match('/Version\/([\d\.]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $this->_mapVersion($matches[1]);
            return;
        }
        
        $doMatch = preg_match('/Safari\/([\d\.]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $this->_mapVersion($matches[1]);
            return;
        }
        
        $doMatch = preg_match('/Safari([\d\.]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $this->_mapVersion($matches[1]);
            return;
        }
        
        $doMatch = preg_match('/AppleWebKit\/([\d\.]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $this->_mapVersion($matches[1]);
            return;
        }
        
        $this->_version = '';
    }
    
    private function _mapVersion($detectedVersion)
    {
        if ($detectedVersion >= 7500) {
            return 5.1;
        }
        
        if ($detectedVersion >= 6500) {
            return 5.0;
        }
        
        if ($detectedVersion >= 750) {
            return 5.1;
        }
        
        if ($detectedVersion >= 650) {
            return 5.0;
        }
        
        if ($detectedVersion >= 500) {
            return 4.0;
        }
        
        return $detectedVersion;
    }
    
    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 276;
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
        return true;
    }
}