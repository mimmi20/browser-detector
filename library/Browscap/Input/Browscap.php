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

use \Browscap\Detector\Version;
use \Browscap\Detector\Company;
use \Browscap\Detector\Result;
use \Browscap\Helper\InputMapper;

/**
 * Browscap.ini parsing class with caching and update capabilities
 *
 * @category  Browscap
 * @package   Browscap
 * @author    Jonathan Stoppani <st.jonathan@gmail.com>
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
class Browscap extends Core
{
    /**
     * Flag to enable only lowercase indexes in the result.
     * The cache has to be rebuilt in order to apply this option.
     *
     * @var bool
     */
    private $lowercase = false;

    /**
     * Where to store the value of the included PHP cache file
     *
     * @var array
     */
    private $userAgents    = array();
    private $browsers      = array();
    private $patterns      = array();
    private $properties    = array();
    private $globalCache   = null;
    private $localFile     = null;
    private $injectedRules = array();

    /**
     * Constructor class, checks for the existence of (and loads) the cache and
     * if needed updated the definitions
     */
    public function __construct()
    {
        // default data file
        $this->setLocaleFile(__DIR__ . '/../data/browscap.ini');
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @return \Browscap\Detector\Result the object containing the browsers details.
     */
    public function getBrowser()
    {
        $this->getGlobalCache();
        
        $browser     = array();
        $pattern     = $this->globalCache->getPattern();
        $allAgents   = $this->globalCache->getUserAgents();
        $allBrowsers = $this->globalCache->getBrowsers();
        
        if (is_array($pattern)) {
            foreach ($pattern as $key => $pattern) {
                if (preg_match($pattern, $this->_agent)) {
                    $browser = array(
                        'userAgent'   => $this->_agent, // Original useragent
                        'usedRegex'   => trim(strtolower($pattern), '@'),
                        'usedPattern' => $allAgents[$key]
                    );

                    $browser += $allBrowsers[$key];

                    break;
                }
            }
        }

        $result = new Result();
        $result->setCapability('useragent', $this->_agent);
        
        $mapper = new InputMapper();
        
        if (empty($browser['Browser_Name'])) {
            $browserName = $this->detectProperty($browser, 'Browser');
        } else {
            $browserName = $this->detectProperty($browser, 'Browser_Name');
        }
        if (!empty($browser['Browser_Version'])) {
            $browserVersion = $this->detectProperty(
                $browser, 'Browser_Version', true, $browserName
            );
        } else {
            $browserVersion = $this->detectProperty(
                $browser, 'Version', true, $browserName
            );
        }
        
        $browserName    = $mapper->mapBrowserName($browserName);
        $browserVersion = $mapper->mapBrowserVersion(
            $browserVersion, $browserName
        );
        
        $browserBits = $this->detectProperty(
            $browser, 'Browser_Bits', true, $browserName
        );
        $browserMaker = $this->detectProperty(
            $browser, 'Browser_Maker', true, $browserName
        );
        
        $result->setCapability('mobile_browser', $browserName);        
        $result->setCapability('mobile_browser_version', $browserVersion);
        $result->setCapability('mobile_browser_bits', $browserBits);
        $result->setCapability(
            'mobile_browser_manufacturer',
            $mapper->mapBrowserMaker($browserMaker, $browserName)
        );
        
        if (!empty($browser['Browser_Type'])) {
            $browserType = $browser['Browser_Type'];
        } elseif (!empty($browser['Category'])) {
            $browserType = $browser['Category'];
        } else {
            $browserType = null;
        }
        
        $result->setCapability('browser_type', $browserType);
        
        if (!empty($browser['Browser_Modus'])) {
            $browserModus = $browser['Browser_Modus'];
        } else {
            $browserModus = '';
        }
        
        $result->setCapability('mobile_browser_modus', $browserModus);
        
        if (!empty($browser['Platform_Name'])) {
            $platform = $this->detectProperty($browser, 'Platform_Name');
        } else {
            $platform = $this->detectProperty($browser, 'Platform');
        }
        
        $platformVersion = $this->detectProperty(
            $browser, 'Platform_Version', true, $platform
        );
        
        $platform        = $mapper->mapOsName(trim($platform));
        $platformVersion = $mapper->mapOsVersion(trim($platformVersion), $platform);
        
        $platformbits = $this->detectProperty(
            $browser, 'Platform_Bits', true, $platform
        );
        $platformMaker = $this->detectProperty(
            $browser, 'Platform_Maker', true, $platform
        );
        
        $result->setCapability('device_os', $platform);
        $result->setCapability('device_os_version', $platformVersion);
        $result->setCapability('device_os_bits', $platformbits);
        $result->setCapability('device_os_manufacturer', $platformMaker);
        
        $deviceName = $this->detectProperty($browser, 'Device_Name');
        $deviceType = $this->detectProperty($browser, 'Device_Type');
        
        $result->setCapability('device_type', $deviceType);
        
        $deviceName = $mapper->mapDeviceName($deviceName);
        
        $deviceMaker = $this->detectProperty(
            $browser, 'Device_Maker', true, $deviceName
        );
        
        $deviceMarketingName = $this->detectProperty(
            $browser, 'Device_Marketing_Name', true, $deviceName
        );
        
        $deviceBrandName = $this->detectProperty(
            $browser, 'Device_Brand_Name', true, $deviceName
        );
        
        $result->setCapability('model_name', $deviceName);
        $result->setCapability('marketing_name', $mapper->mapDeviceMarketingName($deviceMarketingName, $deviceName));
        $result->setCapability('brand_name', $mapper->mapDeviceBrandName($deviceBrandName, $deviceName));
        $result->setCapability('manufacturer_name', $mapper->mapDeviceMaker($deviceMaker, $deviceName));
        
        $engineName = $this->detectProperty($browser, 'RenderingEngine_Name');
        
        if ('unknown' === $engineName || '' === $engineName) {
            $engineName = null;
        }
        
        $engineMaker = $this->detectProperty(
            $browser, 'RenderingEngine_Maker', true, $engineName
        );
        
        $result->setCapability(
            'renderingengine_name', $engineName
        );
        
        $result->setCapability('renderingengine_manufacturer', $engineMaker);
        
        if (!empty($browser['Device_isDesktop'])) {
            $result->setCapability('ux_full_desktop', 
            $browser['Device_isDesktop']);
        }
        
        if (!empty($browser['Device_isTv'])) {
            $result->setCapability('is_smarttv', $browser['Device_isTv']);
        }
        
        if (!empty($browser['Device_isMobileDevice'])) {
            $result->setCapability(
                'is_wireless_device', $browser['Device_isMobileDevice']
            );
        } elseif (!empty($browser['isMobileDevice'])) {
            $result->setCapability(
                'is_wireless_device', $browser['isMobileDevice']
            );
        }
        
        if (!empty($browser['Device_isTablet'])) {
            $result->setCapability('is_tablet', $browser['Device_isTablet']);
        } elseif (!empty($browser['isTablet'])) {
            $result->setCapability('is_tablet', $browser['isTablet']);
        }
        
        if (!empty($browser['Browser_isBot'])) {
            $result->setCapability('is_bot', $browser['Browser_isBot']);
        } elseif (!empty($browser['Crawler'])) {
            $result->setCapability('is_bot', $browser['Crawler']);
        }
        
        if (!empty($browser['Browser_isSyndicationReader'])) {
            $result->setCapability(
                'is_syndication_reader', $browser['Browser_isSyndicationReader']
            );
        } elseif (!empty($browser['isSyndicationReader'])) {
            $result->setCapability(
                'is_syndication_reader', $browser['isSyndicationReader']
            );
        }
        
        if (!empty($browser['Browser_isBanned'])) {
            $result->setCapability(
                'is_banned', $browser['Browser_isBanned']
            );
        } elseif (!empty($browser['isBanned'])) {
            $result->setCapability(
                'is_banned', $browser['isBanned']
            );
        }
        
        if (!empty($browser['Frames'])) {
            $framesSupport = $browser['Frames'];
        } else {
            $framesSupport = null;
        }
        
        $result->setCapability('xhtml_supports_frame', $mapper->mapFrameSupport($framesSupport));
        
        if (!empty($browser['IFrames'])) {
            $framesSupport = $browser['IFrames'];
        } else {
            $framesSupport = null;
        }
        
        $result->setCapability('xhtml_supports_iframe', $mapper->mapFrameSupport($framesSupport));
        
        if (!empty($browser['Tables'])) {
            $tablesSupport = $browser['Tables'];
        } else {
            $tablesSupport = null;
        }
        
        $result->setCapability('xhtml_table_support', $tablesSupport);
        
        if (!empty($browser['Cookies'])) {
            $cookieSupport = $browser['Cookies'];
        } else {
            $cookieSupport = null;
        }
        
        $result->setCapability('cookie_support', $cookieSupport);
        
        if (!empty($browser['BackgroundSounds'])) {
            $bgsoundSupport = $browser['BackgroundSounds'];
        } else {
            $bgsoundSupport = null;
        }
        
        $result->setCapability('supports_background_sounds', $bgsoundSupport);
        
        if (!empty($browser['VBScript'])) {
            $vbSupport = $browser['VBScript'];
        } else {
            $vbSupport = null;
        }
        
        $result->setCapability('supports_vb_script', $vbSupport);
        
        if (!empty($browser['JavaScript'])) {
            $jsSupport = $browser['JavaScript'];
        } else {
            $jsSupport = null;
        }
        
        $result->setCapability('ajax_support_javascript', $jsSupport);
        
        if (!empty($browser['JavaApplets'])) {
            $appletsSupport = $browser['JavaApplets'];
        } else {
            $appletsSupport = null;
        }
        
        $result->setCapability('supports_java_applets', $appletsSupport);
        
        if (!empty($browser['ActiveXControls'])) {
            $activexSupport = $browser['ActiveXControls'];
        } else {
            $activexSupport = null;
        }
        
        $result->setCapability('supports_activex_controls', $activexSupport);
        
        return $result;
    }

    /**
     * Gets the information about the browser by User Agent
     */
    private function getGlobalCache()
    {
        if (null === $this->globalCache) {
            $cacheGlobalId = $this->cachePrefix . 'agentsGlobal';
            
            // Load the cache at the first request
            if (!($this->cache instanceof \Zend\Cache\Frontend\Core) 
                || !$this->globalCache = $this->cache->load($cacheGlobalId)
            ) {
                $this->globalCache = new Browscap\IniHandler();
                $this->globalCache->setLocaleFile($this->localFile);
                $this->globalCache->load();
                
                if ($this->cache instanceof \Zend\Cache\Frontend\Core) {
                    $this->cache->save($this->globalCache, $cacheGlobalId);
                }
            }
        }
    }
    
    /**
     * return all Browsers parsed from the ini file
     *
     * @return array
     */
    public function getAllBrowsers()
    {
        $this->getGlobalCache();
        
        $allAgents   = $this->globalCache->getUserAgents();
        $allBrowsers = $this->globalCache->getBrowsers();
        
        $output = array();
        
        foreach ($allBrowsers as $key => $properties) {
            $output[$allAgents[$key]] = $properties;
        }
        
        return $output;
    }
    
    /**
     * injects rules
     *
     * @param array $injectedRules
     */
    public function injectRules(array $injectedRules)
    {
        $this->injectedRules = $injectedRules;
        
        return $this;
    }
    
    public function expandIni($doSort = true, $addNewGroups = false)
    {
        $expander = new Browscap\IniExpander();
        $expander->setLocaleFile($this->localFile);
        $expander->injectRules($this->injectedRules);
        $expander->setCache($this->cache);
        $expander->setCachePrefix($this->cachePrefix);
        
        $expander->expandIni($doSort, $addNewGroups);
    }

    /**
     * sets the name of the local file
     *
     * @param string $file the file name
     *
     * @return void
     */
    public function setLocaleFile($file)
    {
        if (empty($file)) {
            throw new Exception(
                'the file can not be empty', Exception::LOCAL_FILE_MISSING
            );
        }
        
        $this->localFile = $file;
    }
    
    private function detectProperty(
        array $allProperties, $propertyName, $depended = false, 
        $dependingValue = null)
    {
        $propertyValue = (empty($allProperties[$propertyName]) ? null : trim($allProperties[$propertyName]));
        
        if (empty($propertyValue)
            || '' == $propertyValue
        ) {
            $propertyValue = null;
        }
        
        if ($depended && null !== $propertyValue && !$dependingValue) {
            $propertyValue = null;
        }
        
        return $propertyValue;
    }
}