<?php
namespace Browscap\Input;

/**
 * Browscap.ini parsing class with caching and update capabilities
 *
 * PHP version 5.3
 *
 * LICENSE:
 *
 * Copyright (c) 2013, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 *
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without 
 * modification, are permitted provided that the following conditions are met:
 *
 * * Redistributions of source code must retain the above copyright notice, 
 *   this list of conditions and the following disclaimer.
 * * Redistributions in binary form must reproduce the above copyright notice, 
 *   this list of conditions and the following disclaimer in the documentation 
 *   and/or other materials provided with the distribution.
 * * Neither the name of the authors nor the names of its contributors may be 
 *   used to endorse or promote products derived from this software without 
 *   specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" 
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE 
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE 
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE 
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR 
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF 
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN 
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE 
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  Browscap
 * @package   Browscap
 * @author    Jonathan Stoppani <st.jonathan@gmail.com>
 * @copyright 2006-2008 Jonathan Stoppani
 * @version   SVN: $Id$
 */

/**
 * Browscap.ini parsing class with caching and update capabilities
 *
 * @category  Browscap
 * @package   Browscap
 * @author    Jonathan Stoppani <st.jonathan@gmail.com>
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
class UserAgent extends Core
{
    /**
     * the detected browser
     *
     * @var StdClass
     */
    private $_browser = null;
    
    /**
     * the detected browser engine
     *
     * @var StdClass
     */
    private $_engine = null;
    
    /**
     * the detected platform
     *
     * @var StdClass
     */
    private $_os = null;
    
    /**
     * the detected device
     *
     * @var StdClass
     */
    private $_device = null;

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string  $userAgent the user agent string
     *
     * @return 
     */
    public function getBrowser()
    {
        $this->_detectDevice();
        
        if ($this->_device->hasOs()) {
            $this->_os = $this->_device->getOs();
        } else {
            $this->_os = $this->_detectOs();
        }
        
        if ($this->_device->hasBrowser()) {
            $this->_browser = $this->_device->getBrowser();
        } else {
            $this->_browser = $this->_detectBrowser();
        }
        
        if ($this->_browser->hasEngine()) {
            $this->_engine = $this->_browser->getName();
        } else {
            $this->_engine = $this->_detectEngine();
        }
        
        return $this;
    }

    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @return 
     */
    private function _detectEngine()
    {
        $chain = new Engine\Chain();
        $chain->setUserAgent($this->_agent);
        
        return $chain->detect();
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @return 
     */
    private function _detectBrowser()
    {
        $chain = new Browser\Chain();
        $chain->setUserAgent($this->_agent);
        
        return $chain->detect();
    }

    /**
     * Gets the information about the os by User Agent
     *
     * @return 
     */
    private function _detectOs()
    {
        $chain = new Os\Chain();
        $chain->setUserAgent($this->_agent);
        
        return $chain->detect();
    }

    /**
     * Gets the information about the device by User Agent
     *
     * @return UserAgent
     */
    private function _detectDevice()
    {
        $chain = new Device\Chain();
        $chain->setUserAgent($this->_agent);
        
        $this->_device = $chain->detect();
        
        return $this;
    }
    
    /**
     * returns the stored user agent
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getAgent();
    }
    
    /**
     * returns the name of the actual device without version
     *
     * @return string
     */
    final public function getDevice()
    {
        if (null === $this->_device) {
            return null;
        }
        
        return $this->_device->getDevice();
    }
    
    /**
     * returns the veraion of the actual device
     *
     * @return string
     */
    final public function getDeviceVersion()
    {
        if (null === $this->_device) {
            return null;
        }
        
        return $this->_device->getVersion();
    }
    
    /**
     * returns the name of the actual device with version
     *
     * @return string
     */
    final public function getFullDevice($withManufacturer = false)
    {
        if (null === $this->_device) {
            return null;
        }
        
        return $this->_device->getFullDeviceName($withManufacturer);
    }
    
    /**
     * returns the manufacturer of the actual device
     *
     * @return string
     */
    final public function getDeviceManufacturer()
    {
        if (null === $this->_device) {
            return null;
        }
        
        return $this->_device->getManufacturer();
    }
    
    /**
     * returns TRUE if the device supports RSS Feeds
     *
     * @return boolean
     */
    public function isRssSupported()
    {
        if (null === $this->_browser 
            && null === $this->_engine 
            && null === $this->_device
        ) {
            return null;
        }
        
        $support = true;
        
        if (null !== $this->_engine) {
            $support = $support && $this->_engine->isRssSupported();
        }
        
        if ($support && null !== $this->_browser) {
            $support = $support && $this->_browser->isRssSupported();
        }
        
        if ($support && null !== $this->_device) {
            $support = $support && $this->_device->isRssSupported();
        }
        
        return $support;
    }
    
    /**
     * returns TRUE if the device supports PDF documents
     *
     * @return boolean
     */
    public function isPdfSupported()
    {
        if (null === $this->_browser 
            && null === $this->_engine 
            && null === $this->_device
        ) {
            return null;
        }
        
        $support = true;
        
        if (null !== $this->_engine) {
            $support = $support && $this->_engine->isPdfSupported();
        }
        
        if ($support && null !== $this->_browser) {
            $support = $support && $this->_browser->isPdfSupported();
        }
        
        if ($support && null !== $this->_device) {
            $support = $support && $this->_device->isPdfSupported();
        }
        
        return $support;
    }
    
    final public function getBrowserName()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->getBrowser();
    }
    
    final public function getVersion()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->getVersion();
    }
    
    final public function getBits()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->getBits();
    }
    
    final public function getFullBrowser($withBits = true)
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->getFullBrowser($withBits);
    }
    
    /**
     * returns the manufacturer of the actual browser
     *
     * @return string
     */
    final public function getBrowserManufacturer()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->getManufacturer();
    }
    
    /**
     * returns the manufacturer of the actual browser
     *
     * @return string
     */
    final public function getOsManufacturer()
    {
        if (null === $this->_os) {
            return null;
        }
        
        return $this->_os->getManufacturer();
    }
    
    /**
     * returns TRUE if the device is a Transcoder
     *
     * @return boolean
     */
    public function isTranscoder()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->isTranscoder();
    }
    
    final public function getName()
    {
        if (null === $this->_engine) {
            return null;
        }
        
        return $this->_engine->getName();
    }
    
    final public function getEngineVersion()
    {
        if (null === $this->_engine) {
            return null;
        }
        
        return $this->_engine->getVersion();
    }
    
    final public function getFullEngine()
    {
        if (null === $this->_engine) {
            return null;
        }
        
        return $this->_engine->getFullName();
    }
    
    final public function getPlatform()
    {
        if (null === $this->_os) {
            return null;
        }
        
        return $this->_os->getName();
    }
    
    final public function getPlatformVersion()
    {
        if (null === $this->_os) {
            return null;
        }
        
        return $this->_os->getVersion();
    }
    
    final public function getPlatformBits()
    {
        if (null === $this->_os) {
            return null;
        }
        
        return $this->_os->getBits();
    }
    
    final public function getFullPlatform($withBits = true)
    {
        if (null === $this->_os) {
            return null;
        }
        
        return $this->_os->getFullName($withBits);
    }
    
    /**
     * returns TRUE if the browser should be banned
     *
     * @return boolean
     */
    public function isBanned()
    {
        if (null === $this->_browser && null === $this->_device) {
            return null;
        }
        
        $notBanned = true;
        
        if (null !== $this->_browser) {
            $notBanned = $notBanned && !$this->_browser->isBanned();
        }
        
        if ($notBanned && null !== $this->_device) {
            $notBanned = $notBanned && !$this->_device->isBanned();
        }
        
        return (!$notBanned);
    }
    
    /**
     * returns TRUE if the device is a mobile
     *
     * @return boolean
     */
    public function isMobileDevice()
    {
        if (null === $this->_device) {
            return null;
        }
        
        return $this->_device->isMobileDevice();
    }
    
    /**
     * returns TRUE if the device is a tablet
     *
     * @return boolean
     */
    public function isTablet()
    {
        if (null === $this->_device) {
            return null;
        }
        
        return $this->_device->isTablet();
    }
    
    /**
     * returns TRUE if the device is a desktop device
     *
     * @return boolean
     */
    public function isDesktop()
    {
        if (null === $this->_device) {
            return null;
        }
        
        return $this->_device->isDesktop();
    }
    
    /**
     * returns TRUE if the device is a TV device
     *
     * @return boolean
     */
    public function isTvDevice()
    {
        if (null === $this->_device) {
            return null;
        }
        
        return $this->_device->isTvDevice();
    }
    
    /**
     * returns TRUE if the browser supports VBScript
     *
     * @return boolean
     */
    public function isCrawler()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->isCrawler();
    }
    
    /**
     * returns TRUE if the browser supports Frames
     *
     * @return boolean
     */
    public function supportsFrames()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->supportsFrames();
    }
    
    /**
     * returns TRUE if the browser supports IFrames
     *
     * @return boolean
     */
    public function supportsIframes()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->supportsIframes();
    }
    
    /**
     * returns TRUE if the browser supports Tables
     *
     * @return boolean
     */
    public function supportsTables()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->supportsTables();
    }
    
    /**
     * returns TRUE if the browser supports Cookies
     *
     * @return boolean
     */
    public function supportsCookies()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->supportsCookies();
    }
    
    /**
     * returns TRUE if the browser supports BackgroundSounds
     *
     * @return boolean
     */
    public function supportsBackgroundSounds()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->supportsBackgroundSounds();
    }
    
    /**
     * returns TRUE if the browser supports JavaScript
     *
     * @return boolean
     */
    public function supportsJavaScript()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->supportsJavaScript();
    }
    
    /**
     * returns TRUE if the browser supports VBScript
     *
     * @return boolean
     */
    public function supportsVbScript()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->supportsVbScript();
    }
    
    /**
     * returns TRUE if the browser supports Java Applets
     *
     * @return boolean
     */
    public function supportsJavaApplets()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->supportsJavaApplets();
    }
    
    /**
     * returns TRUE if the browser supports ActiveX Controls
     *
     * @return boolean
     */
    public function supportsActivexControls()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->supportsActivexControls();
    }
    
    /**
     * returns TRUE if the device is a Syndication Reader
     *
     * @return boolean
     */
    public function isSyndicationReader()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->isSyndicationReader();
    }
}