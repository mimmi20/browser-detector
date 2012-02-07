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

/**
 * Handler Base class
 */
use Browscap\Browser\Handler as BrowserHandler;

/**
 * Browser Exceptions
 */
use Browscap\Browser\Exceptions;

/**
 * MSIEAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version   SVN: $Id$
 */
class MicrosoftInternetExplorer extends BrowserHandler
{
    /**
     * @var string the detected browser
     */
    protected $_browser = 'Internet Explorer';
    
    private $_patterns = array(
        '/Mozilla\/5\.0 \(compatible; MSIE 10\.0.*/'      => '10.0',
        '/Mozilla\/5\.0 \(compatible; MSIE 9\.0.*/'       => '9.0',
        '/Mozilla\/4\.0 \(compatible; MSIE 9\.0.*/'       => '9.0',
        '/Mozilla\/4\.0 \(compatible; MSIE 8\.0.*/'       => '8.0',
        '/Mozilla\/4\.0 \(compatible; MSIE 7\.0.*/'       => '7.0',
        '/Mozilla\/4\.0 \(.*compatible.*;.*MSIE 6\.0.*/'  => '6.0',
        '/Mozilla\/4\.0 \(.*compatible.*;.*MSIE 5\.5.*/'  => '5.5',
        '/Mozilla\/4\.0 \(.*compatible.*;.*MSIE 5\.01.*/' => '5.01',
        '/Mozilla\/4\.0 \(.*compatible.*;.*MSIE 5\.0.*/'  => '5.0',
        '/Mozilla\/4\.0 \(.*compatible.*;.*MSIE 4\.01.*/' => '4.01',
        '/Mozilla\/4\.0 \(.*compatible.*;.*MSIE 4\.0.*/'  => '4.0',
        '/Mozilla\/.*\(.*compatible.*;.*MSIE 3\..*/'      => '3.0',
        '/Mozilla\/.*\(.*compatible.*;.*MSIE 2\..*/'      => '2.0',
        '/Mozilla\/.*\(.*compatible.*;.*MSIE 1\..*/'      => '1.0'
    );
    
    /**
     * Returns true if this handler can handle the given user agent
     *
     * @return bool
     */
    public function canHandle()
    {
        if (!$this->_utils->checkIfStartsWith($this->_useragent, 'Mozilla/')) {
            return false;
        }
        
        if (!$this->_utils->checkIfContainsAll($this->_useragent, array('MSIE'))) {
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
            'Avant',
            'avantbrowser',
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
        
        if ($this->_utils->checkIfContainsAnyOf($this->_useragent, $isNotReallyAnIE)) {
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
     * returns TRUE if the browser suppoorts css gradients
     *
     * @return boolean
     */
    public function supportsCssGradients()
    {
        if ($this->getVersion() <= 10) {
            return false;
        }
        
        return true;
    }
    
    /**
     * returns TRUE if the browser suppoorts css rounded corners
     *
     * @return boolean
     */
    public function supportsCssRoundedCorners()
    {
        if ($this->getVersion() <= 10) {
            return false;
        }
        
        return true;
    }
    
    /**
     * returns TRUE if the browser suppoorts css rounded corners
     *
     * @return boolean
     */
    public function supportsCssBorderImages()
    {
        if ($this->getVersion() <= 10) {
            return false;
        }
        
        return true;
    }
    
    /**
     * returns TRUE if the browser suppoorts css rounded corners
     *
     * @return boolean
     */
    public function supportsCssSpriting()
    {
        if ($this->getVersion() <= 10) {
            return false;
        }
        
        return true;
    }
    
    /**
     * returns TRUE if the browser suppoorts css rounded corners
     *
     * @return boolean
     */
    public function supportsCssWidthAsPercentage()
    {
        if ($this->getVersion() <= 10) {
            return false;
        }
        
        return true;
    }
    
    /**
     * returns TRUE if the browser suppoorts css rounded corners
     *
     * @return boolean
     */
    public function supportsHtmlCanvas()
    {
        if ($this->getVersion() <= 10) {
            return false;
        }
        
        return true;
    }
    
    /**
     * returns TRUE if the browser suppoorts css rounded corners
     *
     * @return boolean
     */
    public function supportsViewport()
    {
        return false;
    }
    
    /**
     * returns TRUE if the browser suppoorts css rounded corners
     *
     * @return boolean
     */
    public function supportsViewportWidth()
    {
        return false;
    }
    
    /**
     * returns TRUE if the browser suppoorts css rounded corners
     *
     * @return boolean
     */
    public function supportsViewportMinimumScale()
    {
        return false;
    }
    
    /**
     * returns TRUE if the browser suppoorts css rounded corners
     *
     * @return boolean
     */
    public function supportsViewportMaximumScale()
    {
        return false;
    }
    
    /**
     * returns TRUE if the browser suppoorts css rounded corners
     *
     * @return boolean
     */
    public function supportsViewportInitialScale()
    {
        return false;
    }
    
    /**
     * returns TRUE if the browser suppoorts css rounded corners
     *
     * @return boolean
     */
    public function isViewportUserscalable()
    {
        return false;
    }
    
    /**
     * returns TRUE if the browser suppoorts css rounded corners
     *
     * @return boolean
     */
    public function supportsImageInlining()
    {
        if ($this->getVersion() <= 10) {
            return false;
        }
        
        return true;
    }
    
    /**
     * returns TRUE if the browser suppoorts css rounded corners
     *
     * @return boolean
     */
    public function isMobileOptimized()
    {
        return false;
    }
    
    /**
     * returns TRUE if the browser suppoorts css rounded corners
     *
     * @return boolean
     */
    public function isHandheldFriendly()
    {
        return false;
    }
}