<?php
namespace Browscap\Device;

/**
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
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */

use \Browscap\Helper\Utils;

/**
 * WURFL_Handlers_Handler is the base class that combines the classification of
 * the user agents and the matching process.
 *
 * @category  Browscap
 * @package   Browscap
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */
abstract class Handler implements MatcherInterface
{
    /**
     * @var string the user agent to handle
     */
    protected $_useragent = '';
    
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
     * @var string the detected CPU used in the device
     */
    protected $_cpu = '';
    
    /**
     * @var string the Bit-Width for the detected CPU
     */
    protected $_bits = '';
    
    /**
     * @var \Browscap\Os\Handler
     */
    protected $_os = null;
    
    /**
     * @var \Browscap\Browser\Handler
     */
    protected $_browser = null;
    
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
     * sets the cache used to make the detection faster
     *
     * @param \Zend\Cache\Frontend\Core $cache
     *
     * @return 
     */
    final public function setCache(\Zend\Cache\Frontend\Core $cache)
    {
        if (!($cache instanceof \Zend\Cache\Frontend\Core)) {
            throw new \InvalidArgumentException(
                'the cache must be an instance of \\Zend\\Cache\\Frontend\\Core'
            );
        }
        
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
    final public function detect()
    {
        $this->_cpu  = $this->_detectCpu();
        $this->_bits = $this->_detectBits();
        $this->_os   = $this->detectOs();
        
        if (null !== $this->_os) {
            $this->_browser = $this->_os->getBrowser();
        }
        
        if (null === $this->_browser) {
            $this->_browser = $this->detectBrowser();
        }
        
        return $this->detectDevice();
    }
    
    /**
     * detects the device name from the given user agent
     *
     * @param string $userAgent
     *
     * @return StdClass
     */
    public function detectDevice()
    {
        return $this;
    }
    
    /**
     * detects the device name from the given user agent
     *
     * @return StdClass|null
     */
    public function detectOs()
    {
        return null;
    }
    
    /**
     * detects the device name from the given user agent
     *
     * @return StdClass|null
     */
    public function detectBrowser()
    {
        return null;
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
     * returns the name of the actual device with version
     *
     * @return string
     */
    final public function getFullDeviceName($withManufacturer = false)
    {
        $device       = $this->getFullDevice();
        $manufacturer = $this->getManufacturer();
        
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
     * detect the cpu which is build into the device
     *
     * @return Handler
     */
    protected function _detectCpu()
    {
        return $this;
    }
    
    /**
     * detect the bits of the cpu which is build into the device
     *
     * @return Handler
     */
    protected function _detectBits()
    {
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
     * returns TRUE if the device is a normal Desktop
     *
     * @return boolean
     */
    public function isDesktop()
    {
        return false;
    }
    
    /**
     * returns TRUE if the device is a TV device
     *
     * @return boolean
     */
    public function isTvDevice()
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
    final public function getOs()
    {
        return $this->_os;
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
    final public function getBrowser()
    {
        return $this->_browser;
    }
}