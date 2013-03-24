<?php
namespace Browscap\Input;

/**
 * Browscap.ini parsing final class with caching and update capabilities
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
use \Browscap\Detector\MatcherInterface;
use \Browscap\Detector\MatcherInterface\DeviceInterface;
use \Browscap\Detector\MatcherInterface\OsInterface;
use \Browscap\Detector\MatcherInterface\BrowserInterface;
use \Browscap\Detector\EngineHandler;
use \Browscap\Detector\Result;
use \Browscap\Detector\Version;

/**
 * Browscap.ini parsing final class with caching and update capabilities
 *
 * @category  Browscap
 * @package   Browscap
 * @author    Jonathan Stoppani <st.jonathan@gmail.com>
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
final class Wurfl extends Core
{
    /**
     * the detected browser
     *
     * @var Stdfinal class
     */
    private $_browser = null;
    
    /**
     * the detected browser engine
     *
     * @var Stdfinal class
     */
    private $_engine = null;
    
    /**
     * the detected platform
     *
     * @var Stdfinal class
     */
    private $_os = null;
    
    /**
     * the detected device
     *
     * @var Stdfinal class
     */
    private $_device = null;
    
    /**
     * the wurfl detector class
     *
     * @var
     */
    private $_wurflManager = null;
    
    /**
     * the config object
     *
     * @var \Wurfl\Configuration\Config
     *
     * @throws \UnexpectedValueException
     */
    private $_config = null;
    
    /**
     * sets ab wurfl detection manager
     *
     * @var \Wurfl\ManagerFactory|\Wurfl\Manager
     *
     * @return \Browscap\Input\Wurfl
     */
    public function setWurflManager($wurfl)
    {
        if ($wurfl instanceof \Wurfl\ManagerFactory) {
            $wurfl = $wurfl->create();
        }
        
        if (!($wurfl instanceof \Wurfl\Manager)) {
            throw new \UnexpectedValueException(
                'the $wurfl object has to be an instance of \\Wurfl\\ManagerFactory or an instance of \\Wurfl\\ManagerFactory'
            );
        }
        
        $this->_wurflManager = $wurfl;
        
        return $this;
    }
    
    /**
     * sets the cache used to make the detection faster
     *
     * @param \Zend\Cache\Frontend\Core $cache
     *
     * @return \\Browscap\\Browscap
     */
    public function setCache(\Zend\Cache\Frontend\Core $cache)
    {
        $this->_cache = $cache;
        
        return $this;
    }

    /**
     * sets the the cache prfix
     *
     * @param string $prefix the new prefix
     *
     * @return \\Browscap\\Browscap
     */
    public function setCachePrefix($prefix)
    {
        if (!is_string($prefix)) {
            throw new \UnexpectedValueException(
                'the cache prefix has to be a string'
            );
        }
        
        $this->_cachePrefix = $prefix;
        
        return $this;
    }

    /**
     * sets the the cache prfix
     *
     * @param \Wurfl\Configuration\Config $config the new config
     *
     * @return \\Browscap\\Browscap
     */
    public function setConfig(\Wurfl\Configuration\Config $config)
    {
        $this->_config = $config;
        
        return $this;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @return \Browscap\Detector\Result
     */
    public function getBrowser()
    {
        if (!($this->_wurflManager instanceof \Wurfl\Manager)) {
            throw new \UnexpectedValueException(
                'the $wurfl object has to be an instance of \\Wurfl\\ManagerFactory or an instance of \\Wurfl\\ManagerFactory'
            );
        }
        
        try {
            $agent         = str_replace('Toolbar', '', $this->_agent);
            $device        = $this->_wurflManager->getDeviceForUserAgent($agent);
            $allProperties = $device->getAllCapabilities();
            
            $apiKey = $device->id;
            $apiMob = ('true' === $device->getCapability('is_wireless_device'));
            
            if ($apiMob) {
                $apiOs  = ('iPhone OS' == $device->getCapability('device_os') ? 'iOS' : $device->getCapability('device_os'));
                $apiBro = $device->getCapability('mobile_browser');
                $apiVer = $device->getCapability('mobile_browser_version');
                $apiDev = $device->getCapability('model_name');
                $apiTab = ('true' === $device->getCapability('is_tablet'));
                $apiMan = $device->getCapability('manufacturer_name');
                
                $brandName = $device->getCapability('brand_name');
            } else {
                $apiOs  = null;
                $apiBro = $device->getCapability('brand_name');
                $apiVer = $device->getCapability('model_name');
                $apiDev = null;
                $apiTab = false;
                $apiMan = null;
                
                $brandName = null;
            }
            
            $apiBot     = ('true' === $device->getCapability('is_bot'));
            $apiTv      = ('true' === $device->getCapability('is_smarttv'));
            $apiDesktop = ('true' === $device->getCapability('ux_full_desktop'));
            $apiTranscoder = ('true' === $device->getCapability('is_transcoder'));
            
            $apiOs = trim($apiOs);
            if (!$apiOs) {
                $apiOs = null;
            } else {
                $apiOs = trim($apiOs);
            }
            
            switch (strtolower($apiDev)) {
                case 'android 1.6':
                case 'android 2.0':
                case 'android 2.1':
                case 'android 2.2':
                case 'android 2.3':
                case 'android 3.0':
                case 'android 3.1':
                case 'android 3.2':
                case 'android 4.0':
                case 'android 4.1':
                case 'android 4.2':
                case 'disguised as macintosh':
                case 'mini 1':
                case 'mini 4':
                case 'mini 5':
                case 'windows mobile 6.5':
                case 'windows mobile 7.5':
                case 'fennec tablet':
                case 'tablet on android':
                case 'fennec':
                    $apiDev = 'general Mobile Device';
                    break;
                case 'opera for series 60':
                    $apiDev = 'general Nokia Device';
                    break;
                case 'gt s8500':
                    $apiDev = 'GT-S8500';
                    break;
                case 'motomz616':
                    $apiDev = 'MZ616';
                    break;
                case 'gp-p6810':
                    $apiDev = 'GT-P6810';
                    break;
                case 'lg/c550/v1.0':
                    $apiDev = 'C550';
                    break;
                case 'gt-i8350':
                    $apiDev = 'GT-I8350';
                    break;
                case 'gt-i5500':
                    $apiDev = 'GT-I5500';
                    break;
                case 'gt i7500':
                    $apiDev = 'GT-I7500';
                    break;
                case 'acer e310':
                    $apiDev = 'E310';
                    $apiMan = 'Acer';
                    break;
                case 'sensationxe beats z715e':
                    $apiDev = 'Sensation XE Beats Z715e';
                    break;
                default:
                    // nothing to do here
                    break;
            }
            
            $marketingName = $device->getCapability('marketing_name');
            
            switch ($marketingName) {
                case 'Galaxy SII':
                    $marketingName = 'Galaxy S II';
                    break;
                case 'LG Optimus Chat':
                    $marketingName = 'Optimus Chat';
                    break;
                default:
                    // nothing to do here
                    break;
            }
            
            switch ($brandName) {
                case 'Generic':
                    $brandName = 'unknown';
                    break;
                default:
                    // nothing to do here
                    break;
            }
            
            if ('Generic' == $apiMan || 'Opera' == $apiMan) {
                $apiMan = null;
                $apiDev = null;
                $marketingName = null;
            }
            
            $apiDev = trim($apiDev);
            if (!$apiDev) {
                $apiDev = null;
            }
            
            switch (strtolower($apiBro)) {
                case 'microsoft':
                    switch (strtolower($apiVer)) {
                        case 'internet explorer 10':
                            $apiBro = 'Internet Explorer';
                            $apiVer = '10.0';
                            break;
                        case 'internet explorer 9':
                            $apiBro = 'Internet Explorer';
                            $apiVer = '9.0';
                            break;
                        case 'internet explorer 8':
                            $apiBro = 'Internet Explorer';
                            $apiVer = '8.0';
                            break;
                        case 'internet explorer 7':
                            $apiBro = 'Internet Explorer';
                            $apiVer = '7.0';
                            break;
                        case 'internet explorer 6':
                            $apiBro = 'Internet Explorer';
                            $apiVer = '6.0';
                            break;
                        case 'internet explorer 5.5':
                            $apiBro = 'Internet Explorer';
                            $apiVer = '5.5';
                            break;
                        case 'internet explorer 5':
                            $apiBro = 'Internet Explorer';
                            $apiVer = '5.0';
                            break;
                        case 'internet explorer 4.0':
                        case 'internet explorer 4':
                            $apiBro = 'Internet Explorer';
                            $apiVer = '4.0';
                            break;
                        case 'mobile explorer':
                            $apiBro = 'IEMobile';
                            $apiVer = '';
                            break;
                        case 'mobile explorer 4.0':
                            $apiBro = 'IEMobile';
                            $apiVer = '4.0';
                            break;
                        case 'mobile explorer 6':
                            $apiBro = 'IEMobile';
                            $apiVer = '6.0';
                            break;
                        case 'mobile explorer 7.6':
                            $apiBro = 'IEMobile';
                            $apiVer = '7.6';
                            break;
                        case 'mobile explorer 7.11':
                            $apiBro = 'IEMobile';
                            $apiVer = '7.11';
                            break;
                        case 'mobile explorer 6.12':
                            $apiBro = 'IEMobile';
                            $apiVer = '6.12';
                            break;
                        default:
                            // nothing to do
                            break;
                    }
                    break;
                case 'microsoft mobile explorer':
                    $apiBro = 'IEMobile';
                    break;
                case 'msie':
                    $apiBro = 'Internet Explorer';
                    break;
                case 'opera mobi':
                    $apiBro = 'Opera Mobile';
                    break;
                case 'chrome mobile':
                case 'chrome':
                    $apiBro = 'Chrome';
                    $apiVer = '';
                    break;
                case 'firefox':
                    $apiBro = 'Firefox';
                    if ('3.0' == $apiVer) {
                        $apiVer = null;
                    }
                    break;
                case 'safari':
                    $apiBro = 'Safari';
                    break;
                case 'opera':
                    $apiBro = 'Opera';
                    break;
                case 'konqueror':
                    $apiBro = 'Konqueror';
                    break;
                case 'access netfront':
                    $apiBro = 'NetFront';
                    break;
                case 'nokia':
                case 'nokia browserng':
                    $apiBro = 'Nokia Browser';
                    break;
                case 'google':
                    switch (strtolower($apiVer)) {
                        case 'bot':
                            $apiBro     = 'Google Bot';
                            $apiVer     = '';
                            $apiDesktop = false;
                            $apiBot     = true;
                            break;
                        case 'wireless transcoder':
                            $apiBro        = 'Google Wireless Transcoder';
                            $apiVer        = '';
                            $apiDesktop    = false;
                            $apiBot        = true;
                            $apiTranscoder = true;
                            break;
                        default:
                            // nothing to do here
                            break;
                    }
                    break;
                case 'facebook':
                    switch (strtolower($apiVer)) {
                        case 'bot':
                            $apiBro     = 'FaceBook Bot';
                            $apiVer     = '';
                            $apiDesktop = false;
                            $apiBot     = true;
                            break;
                        default:
                            // nothing to do here
                            break;
                    }
                    break;
                case 'google bot':
                case 'facebook bot':
                    $apiDesktop = false;
                    $apiBot     = true;
                    break;
                case 'chrome':
                    if ($apiVer == '2.0') {
                        $apiVer = '';
                    }
                    break;
                case 'generic web browser':
                case 'robot bot or crawler':
                    $apiBro     = null;
                    $apiOs      = null;
                    $apiMob     = null;
                    $apiTab     = null;
                    $apiDev     = null;
                    $apiMan     = null;
                    $apiBot     = null;
                    $apiTv      = null;
                    $apiDesktop = null;
                    break;
                default:
                    // nothing to do here
                    break;
            }
            
            $apiBro = trim($apiBro);
            if (!$apiBro) {
                $apiBro = null;
                $apiOs  = null;
                $apiMob = null;
                $apiTab = null;
                $apiDev = null;
                $apiMan = null;
                $apiBot = null;
                $apiTv  = null;
                
                $apiDesktop    = null;
                $allProperties = array();
                $marketingName = null;
                $apiTranscoder = null;
            }
        } catch(\Exception $e) {
            $apiKey = 'error';
            $apiMob = false;
            $apiOs  = 'error';
            $apiBro = $e->getMessage();
            $apiVer = '';
            $apiDev = 'error';
            $apiTab = false;
            $apiMan = null;
            $apiBot = true;
            $apiTv  = false;
            
            $apiDesktop    = false;
            $allProperties = array();
            $marketingName = null;
            $apiTranscoder = null;
            
            $brandName = null;
        }
        
        $result = new Result();
        
        $versionfields = array(
            'mobile_browser_version', 'renderingengine_version', 
            'device_os_version'
        );
        
        foreach ($allProperties as $capabilityName => $capabilityValue) {
            if (in_array($capabilityName, $versionfields)) {
                $version = new Version();
                $capabilityValue = $version->setVersion($capabilityValue);
            } elseif ('unknown' === $capabilityValue
                || 'null' === $capabilityValue
                || null === $capabilityValue
            ) {
                $capabilityValue = null;
            } elseif ('false' === $capabilityValue
                || false === $capabilityValue
            ) {
                $capabilityValue = false;
            } elseif ('true' === $capabilityValue
                || true === $capabilityValue
            ) {
                $capabilityValue = true;
            }
            
            $result->setCapability($capabilityName, $capabilityValue);
        }
        
        $version = new Version();
        
        $result->setCapability('mobile_browser', $apiBro);        
        $result->setCapability(
            'mobile_browser_version',
            $version->setVersion($apiVer)
        );
        
        $result->setCapability('device_os', $apiOs);
        
        $result->setCapability('model_name', $apiDev);
        $result->setCapability('manufacturer_name', $apiMan);
        $result->setCapability('marketing_name', $marketingName);
        $result->setCapability('brand_name', $brandName);
        
        if ($apiBot) {
            $apiDesktop = null;
            $apiTv      = null;
            $apiMob     = null;
        }
        
        if (!$apiBro) {
            $apiDesktop = null;
            $apiTv      = null;
            $apiMob     = null;
            $apiBot     = null;
        }
        
        $result->setCapability('is_bot', $apiBot);
        $result->setCapability('is_smarttv', $apiTv);
        $result->setCapability('ux_full_desktop', $apiDesktop);
        $result->setCapability('is_wireless_device', $apiMob);
        $result->setCapability('is_transcoder', $apiTranscoder);
        
        $result->setCapability('wurflKey', $apiKey);
        
        return $result;
    }

    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @return 
     */
    private function _detectEngine()
    {
        $handlersToUse = array();
        
        $chain = new \Browscap\Detector\Chain();
        $chain->setUserAgent($this->_agent);
        $chain->setNamespace('\\Browscap\\Detector\\Engine');
        $chain->setHandlers($handlersToUse);
        $chain->setDefaultHandler(new \Browscap\Detector\Engine\Unknown());
        
        return $chain->detect();
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @return 
     */
    private function _detectBrowser()
    {
        $handlersToUse = array(
        );
        
        $chain = new \Browscap\Detector\Chain();
        $chain->setUserAgent($this->_agent);
        $chain->setNamespace('\\Browscap\\Detector\\Browser');
        $chain->setHandlers($handlersToUse);
        $chain->setDefaultHandler(new \Browscap\Detector\Browser\Unknown());
        
        return $chain->detect();
    }

    /**
     * Gets the information about the os by User Agent
     *
     * @return 
     */
    private function _detectOs()
    {
        $handlersToUse = array(
        );
        
        $chain = new \Browscap\Detector\Chain();
        $chain->setUserAgent($this->_agent);
        $chain->setNamespace('\\Browscap\\Detector\\Os');
        $chain->setHandlers($handlersToUse);
        $chain->setDefaultHandler(new \Browscap\Detector\Os\Unknown());
        
        return $chain->detect();
    }

    /**
     * Gets the information about the device by User Agent
     *
     * @return UserAgent
     */
    private function _detectDevice()
    {
        $handlersToUse = array(
            new \Browscap\Detector\Device\GeneralBot(),
            new \Browscap\Detector\Device\GeneralMobile(),
            new \Browscap\Detector\Device\GeneralTv(),
            new \Browscap\Detector\Device\GeneralDesktop()
        );
        
        $chain = new \Browscap\Detector\Chain();
        $chain->setUserAgent($this->_agent);
        $chain->setNamespace('\\Browscap\\Detector\\Device');
        $chain->setHandlers($handlersToUse);
        $chain->setDefaultHandler(new \Browscap\Detector\Device\Unknown());
        
        return $chain->detect();
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
}