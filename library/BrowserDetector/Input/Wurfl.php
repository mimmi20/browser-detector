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
            $apiMob = ('true' === $device->getVirtualCapability('is_mobile'));
            $apiOs  = $device->getVirtualCapability('advertised_device_os');
            $apiBro = $device->getVirtualCapability('advertised_browser');
            $apiVer = $device->getVirtualCapability('advertised_browser_version');
            
            if ($apiMob) {
                $apiDev    = $device->getCapability('model_name');
                $apiTab    = ('true' === $device->getCapability('is_tablet'));
                $apiMan    = $device->getCapability('manufacturer_name');
                $apiPhone  = ('true' === $device->getCapability('can_assign_phone_number'));
                $brandName = $device->getCapability('brand_name');
            } else {
                $apiDev    = null;
                $apiTab    = false;
                $apiMan    = null;
                $apiPhone  = false;
                $brandName = null;
            }
            
            $apiBot        = ('true' === $device->getVirtualCapability('is_robot'));
            $apiTv         = ('true' === $device->getCapability('is_smarttv'));
            $apiDesktop    = ('true' === $device->getVirtualCapability('is_full_desktop'));
            $apiTranscoder = ('true' === $device->getCapability('is_transcoder'));
            $browserMaker  = '';
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
