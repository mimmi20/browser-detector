<?php
namespace BrowserDetector\Input;

/**
 * BrowserDetector.ini parsing class with caching and update capabilities
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
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2013 Thomas Mueller
 * @version   SVN: $Id$
 */
use \BrowserDetector\Detector\MatcherInterface;
use \BrowserDetector\Detector\MatcherInterface\DeviceInterface;
use \BrowserDetector\Detector\MatcherInterface\OsInterface;
use \BrowserDetector\Detector\MatcherInterface\BrowserInterface;
use \BrowserDetector\Detector\EngineHandler;
use \BrowserDetector\Detector\Result;
use \BrowserDetector\Detector\Version;
use \BrowserDetector\Detector\Company;

/**
 * BrowserDetector.ini parsing class with caching and update capabilities
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
class WurflCloud extends Core
{
    /**
     * the detected browser
     *
     * @var Stdclass
     */
    private $_browser = null;
    
    /**
     * the detected browser engine
     *
     * @var Stdclass
     */
    private $_engine = null;
    
    /**
     * the detected platform
     *
     * @var Stdclass
     */
    private $_os = null;
    
    /**
     * the detected device
     *
     * @var Stdclass
     */
    private $_device = null;
    
    /**
     * the wurfl detector class
     *
     * @var
     */
    private $_wurflManager = null;
    
    /**
     * a flag to tell, if the wurfl data should be mapped
     *
     * @var boolean
     */
    private $_mapWurflData = true;
    
    /**
     * the config object
     *
     * @var \Wurfl\Configuration\Config
     *
     * @throws \UnexpectedValueException
     */
    private $_config = null;
    
    /**
     * sets the wurfl detection manager
     *
     * @var \Wurfl\ManagerFactory|\Wurfl\Manager $wurfl
     *
     * @return \BrowserDetector\Input\Wurfl
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
     * sets the flag to tell, if the wurfl data should be mapped
     *
     * @var boolean $map
     *
     * @return \BrowserDetector\Input\Wurfl
     */
    public function setMapWurflData($map)
    {
        $this->_mapWurflData = ($map ? true : false);
        
        return $this;
    }
    
    /**
     * sets the cache used to make the detection faster
     *
     * @param \Zend\Cache\Frontend\Core $cache
     *
     * @return \\BrowserDetector\\BrowserDetector
     */
    public function setCache(\Zend\Cache\Frontend\Core $cache)
    {
        $this->cache = $cache;
        
        return $this;
    }

    /**
     * sets the the cache prfix
     *
     * @param string $prefix the new prefix
     *
     * @return \\BrowserDetector\\BrowserDetector
     */
    public function setCachePrefix($prefix)
    {
        if (!is_string($prefix)) {
            throw new \UnexpectedValueException(
                'the cache prefix has to be a string'
            );
        }
        
        $this->cachePrefix = $prefix;
        
        return $this;
    }

    /**
     * sets the the cache prfix
     *
     * @param \Wurfl\Configuration\Config $config the new config
     *
     * @return \\BrowserDetector\\BrowserDetector
     */
    public function setConfig(\Wurfl\Configuration\Config $config)
    {
        $this->_config = $config;
        
        return $this;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @return \BrowserDetector\Detector\Result
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
            $apiMob = ('true' === $device->getCapability('device_type')->isMobile());
            
            if ($apiMob) {
                $apiOs    = ('iPhone OS' == $device->getCapability('device_os') ? 'iOS' : $device->getCapability('device_os'));
                $apiBro   = $device->getCapability('mobile_browser');
                $apiVer   = $device->getCapability('mobile_browser_version');
                $apiDev   = $device->getCapability('model_name');
                $apiTab   = ('true' === $device->getCapability('is_tablet'));
                $apiMan   = $device->getCapability('manufacturer_name');
                $apiPhone = ('true' === $device->getCapability('can_assign_phone_number'));
                
                $brandName = $device->getCapability('brand_name');
                
                if ('Opera' == $brandName && $this->_mapWurflData) {
                    $brandName = null;
                }
            } else {
                $apiOs    = null;
                $apiBro   = $device->getCapability('brand_name');
                $apiVer   = $device->getCapability('model_name');
                $apiDev   = null;
                $apiTab   = false;
                $apiMan   = null;
                $apiPhone = false;
                
                $brandName = null;
            }
            
            $apiBot     = ('true' === $device->getCapability('is_bot'));
            $apiTv      = ('true' === $device->getCapability('is_smarttv'));
            $apiDesktop = ('true' === $device->getCapability('ux_full_desktop'));
            $apiTranscoder = ('true' === $device->getCapability('is_transcoder'));
            
            if ($this->_mapWurflData) {
                $apiOs = trim($apiOs);
                if (!$apiOs) {
                    $apiOs = null;
                } else {
                    $apiOs = trim($apiOs);
                }
                
                switch (strtolower($apiOs)) {
                    case 'symbian os':
                        switch (strtolower($apiVer)) {
                            case 's3':
                            case 'belle':
                            case 'anna':
                                $apiVer = 'S3';
                                break;
                            default:
                                // nothing to do here
                                break;
                        }
                        break;
                    default:
                        // nothing to do here
                        break;
                }
                
                $marketingName = $device->getCapability('marketing_name');
                
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
                    case 'windows mobile 7':
                    case 'windows mobile 7.5':
                    case 'windows phone 8':
                    case 'fennec tablet':
                    case 'tablet on android':
                    case 'fennec':
                    case 'opera for series 60':
                    case 'opera mini for s60':
                    case 'windows mobile (opera)':
                        $apiDev = 'general Mobile Device';
                        $apiKey = null;
                        break;
                    // Motorola
                    case 'motomz616':
                        $apiDev = 'MZ616';
                        break;
                    case 'motoxt610':
                        $apiDev = 'XT610';
                        break;
                    case 'motxt912b':
                        $apiDev = 'XT912B';
                        break;
                    // LG
                    case 'lg/c550/v1.0':
                        $apiDev = 'C550';
                        $apiMan = 'LG';
                        break;
                    // Samsung
                    case 'gt s8500':
                        $apiDev = 'GT-S8500';
                        break;
                    case 'gp-p6810':
                        $apiDev = 'GT-P6810';
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
                    case 'gt s5620':
                        $apiDev = 'GT-S5620';
                        break;
                    case 'sgh-i917':
                        $apiDev = 'SGH-I917';
                        break;
                    case 'sgh-i957':
                        $apiDev = 'SGH-I957';
                        break;
                    case 'sgh-i900v':
                        $apiDev = 'SGH-I900V';
                        break;
                    case 'sgh-i917':
                        $apiDev = 'SGH-I917';
                        break;
                    case 'sgh i900':
                        $apiDev = 'SGH-I900';
                        break;
                    case 'sph-930':
                        $apiDev = 'SPH-M930';
                        break;
                    // Acer
                    case 'acer e310':
                        $apiDev        = 'E310';
                        // $marketingName = 'E310';
                        $apiMan        = 'Acer';
                        break;
                    case 'acer e320':
                        $apiDev        = 'E320';
                        $marketingName = 'Liquid Express';
                        $apiMan        = 'Acer';
                        break;
                    // HTC
                    case 'sensationxe beats z715e':
                        $apiDev = 'Sensation XE Beats Z715e';
                        break;
                    // Asus
                    case 'asus-padfone':
                        $apiDev = 'PadFone';
                        break;
                    // Creative
                    case 'creative ziio7':
                        $apiDev = 'ZiiO7';
                        $apiMan = 'Creative';
                        break;
                    // HP
                    case 'touchpad':
                        $apiDev        = 'Touchpad';
                        $marketingName = 'Touchpad';
                        break;
                    // Huawei
                    case 'u8800':
                        $apiDev = 'U8800';
                        break;
                    // Amazon
                    case 'd01400':
                        $apiDev = 'Kindle';
                        break;
                    // Nokia
                    case 'nokia asha 201':
                        $apiDev = 'Asha 201';
                        break;
                    // Medion
                    case 'p9514':
                        $apiDev        = 'Lifetab P9514';
                        $marketingName = 'Lifetab P9514';
                        $apiMan        = 'Medion';
                        $brandName     = 'Medion';
                        break;
                    default:
                        // nothing to do here
                        break;
                }
                
                switch ($marketingName) {
                    case 'Galaxy S II':
                        $marketingName = 'Galaxy S II';
                        break;
                    case 'Galaxy S II LTE':
                        $marketingName = 'Galaxy S II LTE';
                        break;
                    case 'LG Optimus Chat':
                        $marketingName = 'Optimus Chat';
                        break;
                    case 'T Mobile Move Balance':
                        $marketingName = 'T-Mobile Move Balance';
                        break;
                    case 'Xperia arc SO-01C for DoCoMo':
                        $marketingName = 'Xperia Arc SO-01C for DoCoMo';
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
                    $apiMan        = null;
                    $apiDev        = null;
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
                            case 'xbox 360':
                                $apiBro = 'Internet Explorer';
                                $apiVer = '9.0';
                                $apiDev = 'Xbox 360';
                                $apiMan = 'Microsoft';
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
                        $apiVer = '';
                        break;
                    case 'opera tablet':
                        $apiBro = 'Opera Tablet';
                        $apiVer = '';
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
                    case 'fennec':
                        $apiBro = 'Firefox';
                        $apiVer = null;
                        break;
                    case 'safari':
                        $apiBro = 'Safari';
                        $apiVer = '';
                        break;
                    case 'opera':
                        $apiBro = 'Opera';
                        $apiVer = '';
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
                    case 'generic web browser':
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
                    case 'robot bot or crawler':
                    case 'robot':
                        $apiDesktop = false;
                        $apiBot     = true;
                        $apiTv      = false;
                        $apiDev     = 'general Bot';
                        $apiBro     = 'unknown';
                        break;
                    case 'generic smarttv':
                        $apiDesktop = false;
                        $apiBot     = false;
                        $apiTv      = true;
                        $apiDev     = 'general TV Device';
                        $apiBro     = 'unknown';
                        break;
                    case 'wii':
                        $apiDesktop = false;
                        $apiBot     = false;
                        $apiTv      = true;
                        $apiDev     = 'Wii';
                        $apiBro     = 'Wii Browser';
                        $apiMan     = 'Nintendo';
                        break;
                    case 'android':
                        if ('4.01' == $apiVer) {
                            $apiVer = '4.0.1';
                        }
                        break;
                    case 'UCWeb':
                        $apiBro = 'UC Browser';
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
                    
                    $apiPhone      = null;
                    $apiDesktop    = null;
                    $allProperties = array();
                    $marketingName = null;
                    $apiTranscoder = null;
                }
                
                $xhtmlLevel = null;
                
                if ($apiDev || $apiBro) {
                    $xhtmlLevel = $device->getCapability('xhtml_support_level');
                }
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
            
            $apiPhone      = false;
            $apiDesktop    = false;
            $allProperties = array();
            $marketingName = null;
            $apiTranscoder = null;
            
            $brandName  = null;
            $xhtmlLevel = null;
            
            //throw $e;
        }
        
        $result = new Result();
        $result->setCapability('useragent', $this->_agent);
        
        if ($apiDev || $apiBro) {
            $versionFields = array(
                'mobile_browser_version', 'renderingengine_version', 
                'device_os_version'
            );
            $integerFields = array(
                'max_deck_size', 'max_length_of_username', 'max_no_of_bookmarks',
                'max_length_of_password', 'max_no_of_connection_settings',
                'max_object_size', 'max_url_length_bookmark',
                'max_url_length_cached_page', 'max_url_length_in_requests',
                'max_url_length_homepage', 'colors', 'physical_screen_width',
                'physical_screen_height', 'columns', 'rows', 'max_image_width',
                'max_image_height', 'resolution_width', 'resolution_height'
            );
            
            foreach ($allProperties as $capabilityName => $capabilityValue) {
                if (in_array($capabilityName, $versionFields)) {
                    $version = new Version();
                    $capabilityValue = $version->setVersion($capabilityValue);
                } elseif (in_array($capabilityName, $integerFields)) {
                    $capabilityValue = (int) $capabilityValue;
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
            $apiDesktop = false;
            $apiTv      = false;
            $apiMob     = false;
            $apiPhone   = false;
        }
        
        $type = null;
        
        if ($apiBot) {
            $type = 'Bot';
        } elseif (!$apiMob) {
            if ($apiTv) {
                $type = 'TV Device';
            } elseif ($apiDesktop) {
                $type = 'Desktop';
            } else {
                $type = 'general Device';
            }
        } else {
            if ($apiTab) {
                $type = 'Tablet';
            } elseif ($apiPhone) {
                $type = 'Mobile Phone';
            } else {
                $type = 'Mobile Device';
            }
        }
        
        if (!$apiBro) {
            $apiDesktop = null;
            $apiTv      = null;
            $apiMob     = null;
            $apiBot     = null;
            $apiPhone   = null;
            $type       = null;
        }
        
        $result->setCapability('is_bot', $apiBot);
        $result->setCapability('is_smarttv', $apiTv);
        $result->setCapability('ux_full_desktop', $apiDesktop);
        $result->setCapability('is_wireless_device', $apiMob);
        $result->setCapability('is_tablet', $apiTab);
        $result->setCapability('is_transcoder', $apiTranscoder);
        $result->setCapability('can_assign_phone_number', $apiPhone);
        
        if ($apiDev || $apiBro) {
            $result->setCapability('xhtml_support_level', (int) $xhtmlLevel);
        }
        
        if (($type == 'Mobile Phone' || $type == 'Tablet')
            && 'true' === $device->getCapability('dual_orientation')
        ) {
            $width  = (int) $device->getCapability('resolution_width');
            $height = (int) $device->getCapability('resolution_height');
            
            if ($type == 'Mobile Phone') {
                $result->setCapability('resolution_width', min($height, $width));
                $result->setCapability('resolution_height', max($height, $width));
            } elseif ($type == 'Tablet') {
                $result->setCapability('resolution_width', max($height, $width));
                $result->setCapability('resolution_height', min($height, $width));
            } else {
                $result->setCapability('resolution_width', $width);
                $result->setCapability('resolution_height', $height);
            }
        }
        
        $result->setCapability('wurflKey', $apiKey);
        $result->setCapability('device_type', $type);
        
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
        
        $chain = new \BrowserDetector\Detector\Chain();
        $chain->setUserAgent($this->_agent);
        $chain->setNamespace('\\BrowserDetector\\Detector\\Engine');
        $chain->setHandlers($handlersToUse);
        $chain->setDefaultHandler(new \BrowserDetector\Detector\Engine\Unknown());
        
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
        
        $chain = new \BrowserDetector\Detector\Chain();
        $chain->setUserAgent($this->_agent);
        $chain->setNamespace('\\BrowserDetector\\Detector\\Browser');
        $chain->setHandlers($handlersToUse);
        $chain->setDefaultHandler(new \BrowserDetector\Detector\Browser\Unknown());
        
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
        
        $chain = new \BrowserDetector\Detector\Chain();
        $chain->setUserAgent($this->_agent);
        $chain->setNamespace('\\BrowserDetector\\Detector\\Os');
        $chain->setHandlers($handlersToUse);
        $chain->setDefaultHandler(new \BrowserDetector\Detector\Os\Unknown());
        
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
            new \BrowserDetector\Detector\Device\GeneralBot(),
            new \BrowserDetector\Detector\Device\GeneralMobile(),
            new \BrowserDetector\Detector\Device\GeneralTv(),
            new \BrowserDetector\Detector\Device\GeneralDesktop()
        );
        
        $chain = new \BrowserDetector\Detector\Chain();
        $chain->setUserAgent($this->_agent);
        $chain->setNamespace('\\BrowserDetector\\Detector\\Device');
        $chain->setHandlers($handlersToUse);
        $chain->setDefaultHandler(new \BrowserDetector\Detector\Device\Unknown());
        
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
