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
use \BrowserDetector\Helper\InputMapper;

/**
 * BrowserDetector.ini parsing class with caching and update capabilities
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
class Wurfl extends Core
{
    /**
     * the wurfl detector class
     *
     * @var
     */
    private $wurflManager = null;
    
    /**
     * a flag to tell, if the wurfl data should be mapped
     *
     * @var boolean
     */
    private $mapWurflData = true;
    
    /**
     * sets the wurfl detection manager
     *
     * @var \Wurfl\Manager $wurfl
     *
     * @return \BrowserDetector\Input\Wurfl
     */
    public function setWurflManager($wurfl)
    {
        if (!($wurfl instanceof \Wurfl\Manager)) {
            throw new \UnexpectedValueException(
                'the $wurfl object has to be an instance of \\Wurfl\\Manager'
            );
        }
        
        $this->wurflManager = $wurfl;
        
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
        $this->mapWurflData = ($map ? true : false);
        
        return $this;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @return \BrowserDetector\Detector\Result
     */
    public function getBrowser()
    {
        if (!($this->wurflManager instanceof \Wurfl\Manager)) {
            throw new \UnexpectedValueException(
                'the $wurfl object has to be an instance of \\Wurfl\\ManagerFactory or an instance of \\Wurfl\\ManagerFactory'
            );
        }
        
        try {
            $agent         = str_replace('Toolbar', '', $this->_agent);
            $device        = $this->wurflManager->getDeviceForUserAgent($agent);
            $allProperties = $device->getAllCapabilities();
            
            $apiKey = $device->id;
            $apiMob = ('true' === $device->getCapability('is_wireless_device'));
            
            if ($apiMob) {
                $apiOs    = ('iPhone OS' == $device->getCapability('device_os') ? 'iOS' : $device->getCapability('device_os'));
                $apiBro   = $device->getCapability('mobile_browser');
                $apiVer   = $device->getCapability('mobile_browser_version');
                $apiDev   = $device->getCapability('model_name');
                $apiTab   = ('true' === $device->getCapability('is_tablet'));
                $apiMan   = $device->getCapability('manufacturer_name');
                $apiPhone = ('true' === $device->getCapability('can_assign_phone_number'));
                
                $brandName = $device->getCapability('brand_name');
                
                if ('Opera' == $brandName && $this->mapWurflData) {
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
            
            $apiBot        = ('true' === $device->getCapability('is_bot'));
            $apiTv         = ('true' === $device->getCapability('is_smarttv'));
            $apiDesktop    = ('true' === $device->getCapability('ux_full_desktop'));
            $apiTranscoder = ('true' === $device->getCapability('is_transcoder'));
            $browserMaker  = '';
            
            if ($this->mapWurflData) {
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
                
                $mapper = new InputMapper();
                
                $apiDev        = $mapper->mapDeviceName($apiDev);
                $apiMan        = $mapper->mapDeviceMaker($apiMan, $apiDev);
                $marketingName = $mapper->mapDeviceMarketingName($marketingName, $apiDev);
                $brandName     = $mapper->mapDeviceBrandName($brandName, $apiDev);
                
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
                        $browserMaker = 'Microsoft';
                        
                        switch (strtolower($apiVer)) {
                            case 'internet explorer':
                                $apiBro = 'Internet Explorer';
                                $apiVer = '';
                                break;
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
                            case 'outlook express':
                                $apiBro = 'Windows Live Mail';
                                $apiVer = '';
                                break;
                            default:
                                // nothing to do
                                break;
                        }
                        break;
                    case 'microsoft internet explorer':
                    case 'msie':
                        $apiBro       = 'Internet Explorer';
                        $browserMaker = 'Microsoft';
                        break;
                    case 'microsoft mobile explorer':
                        $apiBro       = 'IEMobile';
                        $browserMaker = 'Microsoft';
                        break;
                    case 'opera mobi':
                        $browserMaker = 'Opera Software ASA';
                        $apiBro = 'Opera Mobile';
                        $apiVer = '';
                        break;
                    case 'opera tablet':
                        $browserMaker = 'Opera Software ASA';
                        $apiBro = 'Opera Tablet';
                        $apiVer = '';
                        break;
                    case 'google chrome':
                    case 'chrome mobile':
                    case 'chrome':
                        $apiBro = 'Chrome';
                        $apiVer = '';
                        $browserMaker = 'Google';
                        break;
                    case 'google':
                        $browserMaker = 'Google';
                        
                        switch (strtolower($apiVer)) {
                            case 'chrome':
                                $apiBro = 'Chrome';
                                $apiVer = '';
                                break;
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
                            case 'adsense bot':
                                $apiBro        = 'AdSense Bot';
                                $apiVer        = '';
                                $apiDesktop    = false;
                                $apiBot        = true;
                                $apiTranscoder = true;
                                break;
                            default:
                                // nothing to do
                                break;
                        }
                        break;
                    case 'mozilla firefox':
                    case 'firefox':
                        $apiBro = 'Firefox';
                        $browserMaker = 'Mozilla';
                        if ('3.0' == $apiVer) {
                            $apiVer = null;
                        }
                        break;
                    case 'mozilla':
                        $browserMaker = 'Mozilla';
                        
                        switch (strtolower($apiVer)) {
                            case 'firefox':
                                $apiBro = 'Firefox';
                                $apiVer = '';
                                break;
                            default:
                                // nothing to do
                                break;
                        }
                        break;
                    case 'fennec':
                        $apiBro = 'Firefox';
                        $browserMaker = 'Mozilla';
                        $apiVer = null;
                        break;
                    case 'apple safari':
                    case 'safari':
                        $apiBro = 'Safari';
                        $browserMaker = 'Apple';
                        $apiVer = '';
                        break;
                    case 'apple':
                        $browserMaker = 'Apple';
                        
                        switch (strtolower($apiVer)) {
                            case 'safari':
                                $apiBro = 'Safari';
                                $apiVer = '';
                                break;
                            default:
                                // nothing to do
                                break;
                        }
                        break;
                    case 'opera software opera':
                    case 'opera':
                        $apiBro = 'Opera';
                        $browserMaker = 'Opera Software ASA';
                        $apiVer = '';
                        break;
                    case 'opera software':
                        $browserMaker = 'Opera Software ASA';
                        
                        switch (strtolower($apiVer)) {
                            case 'opera':
                                $apiBro = 'Opera';
                                $apiVer = '';
                                break;
                            default:
                                // nothing to do
                                break;
                        }
                        break;
                    case 'konqueror':
                        $apiBro = 'Konqueror';
                        break;
                    case 'access netfront':
                        $apiBro = 'NetFront';
                        $browserMaker = 'Access';
                        break;
                    case 'nokia':
                    case 'nokia browserng':
                        $apiBro = 'Nokia Browser';
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
                    case 'bing bot':
                        $apiBro       = 'BingBot';
                        $browserMaker = 'Microsoft';
                        $apiDesktop   = false;
                        $apiBot       = true;
                        $apiTv        = false;
                        break;
                    case 'bing':
                        $browserMaker = 'Microsoft';
                        
                        switch (strtolower($apiVer)) {
                            case 'bot':
                                $apiBro = 'BingBot';
                                $apiVer = '';
                                break;
                            default:
                                // nothing to do
                                break;
                        }
                        break;
                    case 'google bot':
                    case 'facebook bot':
                        $apiDesktop = false;
                        $apiBot     = true;
                        $apiTv      = false;
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
                    case 'unknown':
                        $browserMaker = 'unknown';
                        $apiBro       = 'unknown';
                        
                        switch (strtolower($apiVer)) {
                            case 'bot or crawler':
                                $apiDesktop = false;
                                $apiBot     = true;
                                $apiTv      = false;
                                $apiDev     = 'general Bot';
                                $apiBro     = 'unknown';
                                $apiVer     = '';
                                break;
                            default:
                                // nothing to do
                                break;
                        }
                        break;
                    case 'wii':
                        $apiDesktop = false;
                        $apiBot     = false;
                        $apiTv      = true;
                        $apiDev     = 'Wii';
                        $apiBro     = 'Wii Browser';
                        $apiMan     = 'Nintendo';
                        break;
                    case 'android webkit':
                    case 'android':
                        $apiBro     = 'Android Webkit';
                        if ('4.01' == $apiVer) {
                            $apiVer = '4.0.1';
                        }
                        $browserMaker = 'Google';
                        break;
                    case 'unknown':
                        $browserMaker = 'unknown';
                        $apiBro       = 'unknown';
                        
                        switch (strtolower($apiVer)) {
                            case 'bot or crawler':
                                $apiDesktop = false;
                                $apiBot     = true;
                                $apiTv      = false;
                                $apiDev     = 'general Bot';
                                $apiBro     = 'unknown';
                                $apiVer     = '';
                                break;
                            default:
                                // nothing to do
                                break;
                        }
                        break;
                    case 'UCWeb':
                        $apiBro = 'UC Browser';
                        break;
                    case 'seomoz':
                        $browserMaker = 'SEOmoz';
                        
                        switch (strtolower($apiVer)) {
                            case 'rogerbot':
                                $apiBro = 'Rogerbot';
                                $apiVer = '';
                                break;
                            default:
                                // nothing to do
                                break;
                        }
                        break;
                    case 'java':
                        $browserMaker = 'unknown';
                        
                        switch (strtolower($apiVer)) {
                            case 'updater':
                                $apiBro = 'Generic Java Crawler';
                                $apiVer = '';
                                break;
                            default:
                                // nothing to do
                                break;
                        }
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
            
            $brandName    = null;
            $xhtmlLevel   = null;
            $browserMaker = '';
            
            //throw $e;
        }
        
        $result = new Result();
        $result->setCapability('useragent', $this->_agent);
        
        if ($apiDev || $apiBro) {
            $versionFields = array(
                'mobile_browser_version', 'renderingengine_version', 
                'device_os_version', 'controlcap_advertised_browser_version',
                'controlcap_advertised_device_os_version'
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
            
            $allProperties = array_intersect_key(
                $allProperties, $result->getCapabilities()
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
        $result->setCapability('mobile_browser_manufacturer', $browserMaker);
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
            if ($apiTab && $apiPhone) {
                $type = 'FonePad';
            } elseif ($apiTab) {
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
        
        if (($type == 'Mobile Phone' || $type == 'Tablet' || $type == 'FonePad')
            && 'true' === $device->getCapability('dual_orientation')
        ) {
            $width  = (int) $device->getCapability('resolution_width');
            $height = (int) $device->getCapability('resolution_height');
            
            if ($type == 'Mobile Phone') {
                $result->setCapability('resolution_width', min($height, $width));
                $result->setCapability('resolution_height', max($height, $width));
            } elseif ($type == 'Tablet' || $type == 'FonePad') {
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
     * returns the stored user agent
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getAgent();
    }
}
