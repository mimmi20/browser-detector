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
     * @return 
     */
    public function getBrowser()
    {
        $this->_detectDevice();
        
        if ($this->_device->hasOs()) {
            $this->_os = $this->_device->detectOs();
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
        $chain = new \Browscap\Engine\Chain();
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
        $chain = new \Browscap\Browser\Chain();
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
        $chain = new \Browscap\Os\Chain();
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
        $chain = new \Browscap\Device\Chain();
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
        
        return $this->_device->getCapability('model_name');
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
        
        return null; // $this->_device->getCapability('mobile_browser');
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
        
        $device  = $this->_device->getCapability('model_name');
        $version = null; // $this->getVersion();
        
        $device .= ($device != $version && '' != $version ? ' ' . $version : '');
        $manufacturer = $this->_device->getCapability('manufacturer_name');
        
        if ($withManufacturer 
            && $manufacturer 
            && 'unknown' != $manufacturer
            && false === strpos($device, 'general')
        ) {
            $device = $manufacturer . ' ' . $device;
        }
        
        return $device;
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
        
        return $this->_device->getCapability('manufacturer_name');
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
            $support = $support && $this->_engine->getCapability('rss_support');
        }
        
        if ($support && null !== $this->_browser) {
            $support = $support && $this->_browser->getCapability('rss_support');
        }
        
        if ($support && null !== $this->_device) {
            $support = $support && $this->_device->getCapability('rss_support');
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
            $support = $support && $this->_engine->getCapability('pdf_support');
        }
        
        if ($support && null !== $this->_browser) {
            $support = $support && $this->_browser->getCapability('pdf_support');
        }
        
        if ($support && null !== $this->_device) {
            $support = $support && $this->_device->getCapability('pdf_support');
        }
        
        return $support;
    }
    
    final public function getBrowserName()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->getCapability('mobile_browser');
    }
    
    final public function getVersion()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->getCapability('mobile_browser_version');
    }
    
    final public function getBits()
    {
        if (null === $this->_browser) {
            return null;
        }
        
        return $this->_browser->getCapability('mobile_browser_bits');
    }
    
    final public function getFullBrowser($withBits = true)
    {
        if (null === $this->_browser) {
            return null;
        }
        
        $browser = $this->_browser->getCapability('mobile_browser');
        $version = $this->_browser->getCapability('mobile_browser_version');
        $bits    = $this->_browser->getCapability('mobile_browser_bits');
        
        return $browser . ($browser != $version && '' != $version ? ' ' . $version : '') . (($bits && $withBits) ? ' (' . $bits . ' Bit)' : '');
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
        
        return $this->_browser->getCapability('mobile_browser_manufacturer');
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
        
        return $this->_os->getCapability('device_os_manufacturer');
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
        
        return $this->_browser->getCapability('is_transcoder');
    }
    
    final public function getName()
    {
        if (null === $this->_engine) {
            return null;
        }
        
        return $this->_engine->getCapability('renderingengine_name');
    }
    
    final public function getEngineVersion()
    {
        if (null === $this->_engine) {
            return null;
        }
        
        return $this->_engine->getCapability('renderingengine_version');
    }
    
    final public function getFullEngine()
    {
        if (null === $this->_engine) {
            return null;
        }
        
        $engine  = $this->_engine->getCapability('renderingengine_name');
        $version = $this->_engine->getCapability('renderingengine_version');
        
        return $engine . (($engine != $version && '' != $version) ? ' ' . $version : '');
    }
    
    final public function getPlatform()
    {
        if (null === $this->_os) {
            return null;
        }
        
        return $this->_os->getCapability('device_os');
    }
    
    final public function getPlatformVersion()
    {
        if (null === $this->_os) {
            return null;
        }
        
        return $this->_os->getCapability('device_os_version');
    }
    
    final public function getPlatformBits()
    {
        if (null === $this->_os) {
            return null;
        }
        
        return $this->_os->getCapability('device_os_bits');
    }
    
    final public function getFullPlatform($withBits = true)
    {
        if (null === $this->_os) {
            return null;
        }
        
        $name    = $this->_os->getCapability('device_os');
        $version = $this->_os->getCapability('device_os_version');
        $bits    = $this->_os->getCapability('device_os_bits');
        
        return $name . ($name != $version && '' != $version ? ' ' . $version : '') . (($bits && $withBits) ? ' (' . $bits . ' Bit)' : '');
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
            $notBanned = $notBanned && !$this->_browser->getCapability('is_banned');
        }
        
        if ($notBanned && null !== $this->_device) {
            $notBanned = $notBanned && !$this->_device->getCapability('is_banned');
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
        
        return $this->_device->getCapability('is_wireless_device');
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
        
        return $this->_device->getCapability('is_tablet');
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
        
        return $this->_device->getCapability('ux_full_desktop');
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
        
        return $this->_device->getCapability('is_smarttv');
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
        
        return $this->_browser->getCapability('is_bot');
    }
    
    /**
     * returns TRUE if the browser supports VBScript
     *
     * @return boolean
     */
    public function isConsole()
    {
        if (null === $this->_device) {
            return null;
        }
        
        return $this->_device->getCapability('is_console');
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