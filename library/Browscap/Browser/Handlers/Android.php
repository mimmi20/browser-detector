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
 * @version   SVN: $Id$
 */

/**
 * AndroidUserAgentHanlder
 * 
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version   SVN: $Id$
 */
class Android extends MobileSafari
{
    /**
     * @var string the detected browser
     */
    protected $_browser = 'Android Webkit (Mobile Safari)';
    
    /**
     * Returns true if this handler can handle the given user agent
     *
     * @return bool
     */
    public function canHandle()
    {
        if (!$this->_utils->checkIfStartsWith($this->_useragent, 'Dalvik/')
            && !$this->_utils->checkIfContains($this->_useragent, 'Android')
            && !parent::canHandle($this->_useragent)
        ) {
            return false;
        }
        
        if ($this->_utils->checkIfContainsAnyOf($this->_useragent, array('NokiaBrowser', 'BlackBerry', 'Blackberry', 'Opera', 'Firefox', 'Fennec', 'iPad', 'iPhone'))) {
            return false;
        }
        
        return true;
    }
    
    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 287;
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
        return true;
    }
    
    /**
     * returns TRUE if the browser suppoorts css rounded corners
     *
     * @return boolean
     */
    public function supportsCssWidthAsPercentage()
    {
        return true;
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
        return true;
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
    public function getHtmlPreferedDtd()
    {
        return '';
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
