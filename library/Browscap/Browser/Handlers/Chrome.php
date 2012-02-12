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

use Browscap\Browser\Handler as BrowserHandler;

/**
 * ChromeUserAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version   SVN: $Id$
 */
class Chrome extends BrowserHandler
{
    /**
     * @var string the detected browser
     */
    protected $_browser = 'Chrome';
    
    /**
     * Returns true if this handler can handle the given user agent
     *
     * @return bool
     */
    public function canHandle()
    {
        if (!$this->_utils->checkIfStartsWith($this->_useragent, 'Mozilla/')
            && !$this->_utils->checkIfStartsWith($this->_useragent, 'Chrome/')
        ) {
            return false;
        }
        
        if (!$this->_utils->checkIfContainsAll($this->_useragent, array('AppleWebKit', 'Chrome'))) {
            return false;
        }
        
        $isNotReallyAnSafari = array(
            // using also the KHTML rendering engine
            'Chromium',
            'Flock',
            'Galeon',
            'Lunascape',
            'Iron',
            'Maemo',
            'PaleMoon',
            'Rockmelt',
            'Comodo Dragon',
            'Google Earth',
            'Arora',
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
        $doMatch = preg_match('/Chrome\/([\d\.]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $matches[1];
            return;
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
        return 778;
    }
    
    /**
     * returns TRUE if the browser suppoorts css gradients
     *
     * @return boolean
     */
    public function supportsCssGradients()
    {
        return false;
    }
    
    /**
     * returns TRUE if the browser suppoorts css rounded corners
     *
     * @return boolean
     */
    public function supportsCssRoundedCorners()
    {
        return false;
    }
    
    /**
     * returns TRUE if the browser suppoorts css rounded corners
     *
     * @return boolean
     */
    public function supportsCssBorderImages()
    {
        return false;
    }
    
    /**
     * returns TRUE if the browser suppoorts css rounded corners
     *
     * @return boolean
     */
    public function supportsCssSpriting()
    {
        return false;
    }
    
    /**
     * returns TRUE if the browser suppoorts css rounded corners
     *
     * @return boolean
     */
    public function supportsCssWidthAsPercentage()
    {
        return false;
    }
    
    /**
     * returns TRUE if the browser suppoorts css rounded corners
     *
     * @return boolean
     */
    public function supportsHtmlCanvas()
    {
        return false;
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
        return false;
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