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
use \Browscap\Detector\Bits as BitsDetector;

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
        $this->setLocaleFile(__DIR__ . '/../data/modified_full_php_browscap.ini');
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @return \Browscap\Detector\Result the object containing the browsers details.
     */
    public function getBrowser()
    {
        $globalCache = $this->getGlobalCache();
        
        $browser = array();
        
        if (isset($globalCache['patterns'])
            && is_array($globalCache['patterns'])
        ) {
            foreach ($globalCache['patterns'] as $key => $pattern) {
                if (preg_match($pattern, $this->_agent)) {
                    $browser = array(
                        'userAgent'   => $this->_agent, // Original useragent
                        'usedRegex'   => trim(strtolower($pattern), '@'),
                        'usedPattern' => $globalCache['userAgents'][$key]
                    );

                    $browser += $globalCache['browsers'][$key];

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
        
        if (!empty($browser['Browser_Icon'])) {
            $browserIcon = $browser['Browser_Icon'];
        } else {
            $browserIcon = '';
        }
        
        $result->setCapability('mobile_browser_icon', $browserIcon);
        
        if (!empty($browser['Platform_Name'])) {
            $platform = $this->detectProperty($browser, 'Platform_Name');
        } else {
            $platform = $this->detectProperty($browser, 'Platform');
        }
        
        $platformVersion = $this->detectProperty(
            $browser, 'Platform_Version', true, $platform
        );
        
        $platformVersion = $mapper->mapOsVersion(trim($platformVersion), trim($platform));
        $platform        = $mapper->mapOsName(trim($platform));
        
        $platformbits = $this->detectProperty(
            $browser, 'Platform_Bits', true, $platform
        );
        $platformMaker = $this->detectProperty(
            $browser, 'Platform_Maker', true, $platform
        );
        $platformIcon = $this->detectProperty(
            $browser, 'Platform_Icon', true, $platform
        );
        
        $result->setCapability('device_os', $platform);
        $result->setCapability('device_os_version', $platformVersion);
        $result->setCapability('device_os_bits', $platformbits);
        $result->setCapability('device_os_manufacturer', $platformMaker);
        $result->setCapability('device_os_icon', $platformIcon);
        
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
        
        $engineIcon = $this->detectProperty(
            $browser, 'RenderingEngine_Icon', true, $engineName
        );
        
        $result->setCapability(
            'renderingengine_name', $engineName
        );
        
        $result->setCapability('renderingengine_manufacturer', $engineMaker);
        $result->setCapability('renderingengine_icon', $engineIcon);
        
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
        $cacheGlobalId = $this->cachePrefix . 'agentsGlobal';
        
        // Load the cache at the first request
        if (!($this->cache instanceof \Zend\Cache\Frontend\Core) 
            || !$globalCache = $this->cache->load($cacheGlobalId)
        ) {
            $globalCache = $this->getBrowserFromGlobalCache();
            
            if ($this->cache instanceof \Zend\Cache\Frontend\Core) {
                $this->cache->save($globalCache, $cacheGlobalId);
            }
        }
        
        return $globalCache;
    }
    
    /**
     * return all Browsers parsed from the ini file
     *
     * @return array
     */
    public function getAllBrowsers()
    {
        return $this->expandRules();
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
    
    private function parseIni()
    {
        if (empty($this->localFile)) {
            throw new Exception(
                'please set the ini file before trying to parse it', 
                Exception::LOCAL_FILE_MISSING
            );
        }
        
        if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
            $browsers = parse_ini_file($this->localFile, true, INI_SCANNER_RAW);
        } else {
            $browsers = parse_ini_file($this->localFile, true);
        }
        
        unset($browsers['GJK_Browscap_Version']);
        
        $this->properties = array_keys($browsers['DefaultProperties']);
        array_unshift(
            $this->properties,
            'Parent',
            'Parents'
        );

        $this->userAgents = array_keys($browsers);
        
        return $browsers;
    }

    /**
     * Parses the user agents
     *
     * @return bool whether the file was correctly written to the disk
     */
    private function parseAllAgents($browsers)
    {
        $aPropertiesKeys = array_flip($this->properties);
        $key             = 0;
        
        foreach ($this->userAgents as $userAgent) {
            $this->parseAgents(
                $browsers, $userAgent, $aPropertiesKeys, $key
            );
            $key++;
        }
    }
    
    private function expandRules()
    {
        $browsers = $this->parseIni();
        $this->parseAllAgents($browsers);
        
        $output = array();
        
        foreach ($this->browsers as $key => $properties) {
            $output[$this->userAgents[$key]] = $properties;
        }
        
        return $output;
    }
    
    public function expandIni($doSort = true)
    {
        $browsers = $this->parseIni();
        $this->parseAllAgents($browsers);
        
        $browserBitHelper = new BitsDetector\Browser();
        $osBitHelper      = new BitsDetector\Os();
        $version          = new Version();
        
        // full expand
        foreach ($this->browsers as $key => $properties) {
            foreach ($properties as $k => $property) {
                if (is_string($property)) {
                    $properties[$k] = trim($property);
                }
                
                if (!empty($this->injectedRules[$key][$k])) {
                    $properties[$k] = trim($this->injectedRules[$key][$k]);
                }
            }
            
            if (!isset($properties['Version']) || !isset($properties['Browser'])) {
                echo 'attribute not found for key "' . $key . '" and rule "' . $this->userAgents[$key] . '"' . "\n";
                var_dump($properties);
                echo "\n\n";
                continue;
            }
            
            $completeVersion = $properties['Version'];
            
            if (!empty($properties['Browser_Version'])) {
                $completeVersion = $properties['Browser_Version'];
            }
            
            $version->setVersion($completeVersion);
            $version->setUserAgent($this->userAgents[$key]);
            
            
            $properties['MajorVer'] = (int) $version->getVersion(Version::MAJORONLY);
            $v                      = $version->getVersion(Version::MINORMICRO | Version::IGNORE_MICRO_IF_EMPTY);
            if ($v) {
                $properties['MinorVer'] = $v;
            } else {
                $properties['MinorVer'] = 0;
            }
            
            $browserName = $properties['Browser'];
            
            if (!empty($properties['Browser_Name'])) {
                $browserName = $properties['Browser_Name'];
            }
            
            $properties['Version'] = $completeVersion;
            $properties['Browser'] = $browserName;
            
            if (!empty($properties['Browser_Type'])) {
                $browserType = $properties['Browser_Type'];
            } elseif (!empty($properties['Category'])) {
                $browserType = $properties['Category'];
            } else {
                $browserType = 'all';
            }
            
            $properties['Category']     = $browserType;
            $properties['Browser_Type'] = $browserType;
            
            if (!empty($properties['Browser_Type'])) {
                $browserSubType = $properties['Browser_Type'];
            } elseif (!empty($properties['SubCategory'])) {
                $browserSubType = $properties['SubCategory'];
            } else {
                $browserSubType = 'all';
            }
            
            $properties['SubCategory']     = $browserSubType;
            $properties['Browser_SubType'] = $browserSubType;
            
            if (!empty($completeVersion) 
                && '0.0' != $completeVersion
            ) {
                $properties['Browser_Full'] = trim($browserName . ' ' . $completeVersion);
            } else {
                $properties['Browser_Full'] = $browserName;
            }
            
            $syndicationReader = $properties['isSyndicationReader'];
            
            if (array_key_exists('Browser_isSyndicationReader', $properties)) {
                $syndicationReader = $properties['Browser_isSyndicationReader'];
            }
            
            $properties['isSyndicationReader']         = $syndicationReader;
            $properties['Browser_isSyndicationReader'] = $syndicationReader;
            
            if (array_key_exists('Browser_isBanned', $properties)) {
                $isBanned = $properties['Browser_isBanned'];
            } elseif (array_key_exists('isBanned', $properties)) {
                $isBanned = $properties['isBanned'];
            } else {
                $isBanned = false;
            }
            
            $properties['isBanned']         = $isBanned;
            $properties['Browser_isBanned'] = $isBanned;
            
            $crawler = $properties['Crawler'];
            
            if (!empty($properties['Browser_isBot'])) {
                $crawler               = $properties['Browser_isBot'];
                $properties['Crawler'] = $crawler;
            }
            
            if (array_key_exists('Browser_isAlpha', $properties)) {
                $properties['Alpha'] = $properties['Browser_isAlpha'];
            }
            
            if (array_key_exists('Browser_isBeta', $properties)) {
                $properties['Beta'] = $properties['Browser_isBeta'];
            }
            
            $browserBitHelper->setUserAgent($this->userAgents[$key]);
            $osBitHelper->setUserAgent($this->userAgents[$key]);
            
            $properties['Browser_Bits']  = (int) $browserBitHelper->getBits();
            $properties['Platform_Bits'] = (int) $osBitHelper->getBits();
            
            $properties['Win64'] = false;
            $properties['Win32'] = false;
            $properties['Win16'] = false;
            
            $platform = $properties['Platform'];
            
            if (!empty($properties['Platform_Name'])) {
                $platform               = $properties['Platform_Name'];
                $properties['Platform'] = $platform;
            }
                
            if ('Windows' == $platform) {
                if (64 == $properties['Browser_Bits']) {
                    $properties['Win64'] = true;
                } elseif (32 == $properties['Browser_Bits']) {
                    $properties['Win32'] = true;
                } elseif (16 == $properties['Browser_Bits']) {
                    $properties['Win16'] = true;
                }
            }
            
            if ('0.0' != $properties['Platform_Version']) {
                $properties['Platform_Full'] = trim($platform . ' ' . $properties['Platform_Version']);
            } else {
                $properties['Platform_Full'] = $platform;
            }
            
            if (!empty($properties['RenderingEngine_Version'])
                && !empty($properties['RenderingEngine_Name'])
                && '0.0' != $properties['RenderingEngine_Version']
            ) {
                $properties['RenderingEngine_Full'] = trim($properties['RenderingEngine_Name'] . ' ' . $properties['RenderingEngine_Version']);
            } elseif (!empty($properties['RenderingEngine_Name'])) {
                $properties['RenderingEngine_Full'] = $properties['RenderingEngine_Name'];
            } else {
                $properties['RenderingEngine_Full'] = '';
            }
            
            $mobileDevice = $properties['isMobileDevice'];
            
            if (!empty($properties['Device_isMobileDevice'])) {
                $mobileDevice = $properties['Device_isMobileDevice'];
            }
            
            $properties['isMobileDevice']        = $mobileDevice;
            $properties['Device_isMobileDevice'] = $mobileDevice;
            
            if (!empty($properties['Device_isTablet'])) {
                $isTablet = $properties['Device_isTablet'];
            } elseif (!empty($properties['isTablet'])) {
                $isTablet = $properties['isTablet'];
            } else {
                $isTablet = false;
            }
            
            $properties['Device_isTablet'] = $isTablet;
            $properties['isTablet']        = $isTablet;
            
            if ($isTablet) {
                $properties['Device_Type'] = 'Tablet';
            }
            
            if ('DefaultProperties' == $this->userAgents[$key]
                || '*' == $this->userAgents[$key]
            ) {
                $properties['Platform_Bits'] = 0;
                $properties['Browser_Bits'] = 0;
                $properties['isTablet'] = false;
                $properties['Device_Type'] = 'unknown';
                $properties['Platform_Description'] = '';
                $properties['Platform_Icon']        = '';
            } else {
                switch ($platform) {
                    case 'RIM OS':
                        $properties['Device_Maker'] = 'RIM';
                        $properties['isMobileDevice'] = true;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = true;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = false;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'RIM';
                        $properties['Device_Type'] = 'Mobile Phone';
                        $properties['Platform_Description'] = '';
                        $properties['Platform_Icon']        = '';
                        break;
                    case 'Windows':
                    case 'Win32':
                        $properties['Device_Name'] = 'Windows Desktop';
                        $properties['Device_Maker'] = 'unknown';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv'] = false;
                        $properties['Platform'] = 'Windows';
                        $properties['Platform_Name'] = 'Windows';
                        $properties['Platform_Maker'] = 'Microsoft Corporation';
                        $properties['Device_Type'] = 'Desktop';
                        $properties['Platform_Description'] = '';
                        $properties['Platform_Icon']        = '';
                        break;
                    case 'CygWin':
                        $properties['Device_Name'] = 'Windows Desktop';
                        $properties['Device_Maker'] = 'unknown';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'Microsoft Corporation';
                        $properties['Device_Type'] = 'Desktop';
                        $properties['Platform_Description'] = '';
                        $properties['Platform_Icon']        = '';
                        break;
                    case 'WinMobile':
                    case 'Windows Mobile OS':
                        $properties['isMobileDevice'] = true;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = true;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = false;
                        $properties['Device_isTv'] = false;
                        $properties['Platform'] = 'Windows Mobile OS';
                        $properties['Platform_Name'] = 'Windows Mobile OS';
                        $properties['Platform_Maker'] = 'Microsoft Corporation';
                        $properties['Device_Type'] = 'Mobile Phone';
                        $properties['Platform_Description'] = '';
                        $properties['Platform_Icon']        = '';
                        break;
                    case 'Windows Phone OS':
                        $properties['isMobileDevice'] = true;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = true;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = false;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'Microsoft Corporation';
                        $properties['Device_Type'] = 'Mobile Phone';
                        $properties['Platform_Description'] = '';
                        $properties['Platform_Icon']        = '';
                        break;
                    case 'Symbian OS':
                    case 'SymbianOS':
                        $properties['isMobileDevice'] = true;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = true;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = false;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Name'] = 'Symbian OS';
                        $properties['Platform_Maker'] = 'Nokia';
                        $properties['Device_Type'] = 'Mobile Phone';
                        $properties['Platform_Description'] = '';
                        $properties['Platform_Icon']        = '';
                        break;
                    case 'Debian':
                    case 'Linux':
                    case 'Linux for TV':
                    case 'Linux Smartphone OS':
                        $properties['Platform_Name'] = 'Linux';
                        $properties['Platform_Maker'] = 'Linux Foundation';
                        $properties['Platform_Description'] = '';
                        $properties['Platform_Icon']        = '';
                        
                        if ($mobileDevice === false
                            && !empty($properties['Device_isTv']) 
                            && $properties['Device_isTv'] === false
                        ) {
                            $properties['Device_Name'] = 'Linux Desktop';
                            $properties['Device_Maker'] = 'unknown';
                            $properties['isMobileDevice'] = false;
                            $properties['isTablet'] = false;
                            $properties['Device_isMobileDevice'] = false;
                            $properties['Device_isTablet'] = false;
                            $properties['Device_isDesktop'] = true;
                            $properties['Device_isTv'] = false;
                            $properties['Device_Type'] = 'Desktop';
                        } elseif (!empty($properties['Device_isTv']) 
                            && $properties['Device_isTv'] === true
                        ) {
                            $properties['Device_Name'] = 'general TV Device';
                            $properties['Device_Maker'] = 'unknown';
                            $properties['isMobileDevice'] = false;
                            $properties['isTablet'] = false;
                            $properties['Device_isMobileDevice'] = false;
                            $properties['Device_isTablet'] = false;
                            $properties['Device_isDesktop'] = false;
                            $properties['Device_isTv'] = true;
                            $properties['Platform_Name'] = 'Linux for TV';
                            $properties['Device_Type'] = 'TV Device';
                        } elseif ($mobileDevice == true) {
                            $properties['isMobileDevice'] = true;
                            $properties['Device_isMobileDevice'] = true;
                            $properties['Device_isDesktop'] = false;
                            $properties['Device_isTv'] = false;
                            $properties['Platform'] = 'Linux Smartphone OS';
                            $properties['Platform_Name'] = 'Linux Smartphone OS';
                            $properties['Device_Type'] = 'Mobile Phone';
                        }
                        break;
                    case 'CentOS':
                        $properties['Device_Name'] = 'Linux Desktop';
                        $properties['Device_Maker'] = 'unknown';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv'] = false;
                        $properties['Device_Type'] = 'Desktop';
                        $properties['Platform_Description'] = '';
                        $properties['Platform_Icon']        = '';
                        break;
                    case 'Macintosh':
                    case 'MacOSX':
                    case 'Mac OS X':
                    case 'Mac68K':
                        $properties['Device_Name'] = 'Macintosh';
                        $properties['Device_Maker'] = 'Apple Inc';
                        $properties['Device_Brand_Name'] = 'Apple';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'Apple Inc';
                        $properties['Device_Type'] = 'Desktop';
                        $properties['Platform_Description'] = '';
                        $properties['Platform_Icon']        = '';
                        break;
                    case 'Darwin':
                        $properties['Device_Maker'] = 'Apple Inc';
                        $properties['Device_Brand_Name'] = 'Apple';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = false;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'Apple Inc';
                        $properties['Platform_Description'] = '';
                        $properties['Platform_Icon']        = '';
                        
                        if (!empty($properties['Device_Name'])) {
                            switch ($properties['Device_Name']) {
                                case 'iPad':
                                    $properties['isMobileDevice'] = true;
                                    $properties['Device_isMobileDevice'] = true;
                                    $properties['isTablet'] = true;
                                    $properties['Device_isTablet'] = true;
                                    $properties['Device_Type'] = 'Tablet';
                                    break;
                                case 'iPod':
                                    $properties['isMobileDevice'] = true;
                                    $properties['Device_isMobileDevice'] = true;
                                    $properties['isTablet'] = false;
                                    $properties['Device_isTablet'] = false;
                                    $properties['Device_Type'] = 'Mobile Device';
                                    break;
                                case 'iPhone':
                                    $properties['isMobileDevice'] = true;
                                    $properties['Device_isMobileDevice'] = true;
                                    $properties['isTablet'] = false;
                                    $properties['Device_isTablet'] = false;
                                    $properties['Device_Type'] = 'Mobile Phone';
                                    break;
                                default:
                                    $properties['Device_Name'] = 'Macintosh';
                                    $properties['Device_isDesktop'] = true;
                                    $properties['Device_Type'] = 'Desktop';
                                    break;
                            }
                        }
                        break;
                    case 'iOS':
                        $properties['Device_Maker'] = 'Apple Inc';
                        $properties['Device_Brand_Name'] = 'Apple';
                        $properties['isMobileDevice'] = true;
                        $properties['Device_isMobileDevice'] = true;
                        $properties['Device_isDesktop'] = false;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'Apple Inc';
                        $properties['Platform_Description'] = '';
                        $properties['Platform_Icon']        = '';
                        
                        if (!empty($properties['Device_Name'])) {
                            switch ($properties['Device_Name']) {
                                case 'iPad':
                                    $properties['isTablet'] = true;
                                    $properties['Device_isTablet'] = true;
                                    $properties['Device_Type'] = 'Tablet';
                                    break;
                                case 'iPod':
                                    $properties['isTablet'] = false;
                                    $properties['Device_isTablet'] = false;
                                    $properties['Device_Type'] = 'Mobile Device';
                                    break;
                                case 'iPhone':
                                    $properties['isTablet'] = false;
                                    $properties['Device_isTablet'] = false;
                                    $properties['Device_Type'] = 'Mobile Phone';
                                    break;
                                default:
                                    // nothing to do here
                                    break;
                            }
                        }
                        break;
                    case 'BeOS':
                        $properties['Device_Name'] = 'general Desktop';
                        $properties['Device_Maker'] = 'unknown';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'Access';
                        $properties['Device_Type'] = 'Desktop';
                        $properties['Platform_Description'] = '';
                        $properties['Platform_Icon']        = '';
                        break;
                    case 'AIX':
                        $properties['Device_Name'] = 'general Desktop';
                        $properties['Device_Maker'] = 'IBM';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'IBM';
                        $properties['Device_Type'] = 'Desktop';
                        $properties['Platform_Description'] = '';
                        $properties['Platform_Icon']        = '';
                        break;
                    case 'Digital Unix':
                    case 'Tru64 UNIX':
                        $properties['Device_Name'] = 'general Desktop';
                        $properties['Device_Maker'] = 'HP';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv'] = false;
                        $properties['Platform'] = 'Tru64 UNIX';
                        $properties['Platform_Name'] = 'Tru64 UNIX';
                        $properties['Platform_Maker'] = 'HP';
                        $properties['Platform_Bits'] = '64';
                        $properties['Device_Type'] = 'Desktop';
                        $properties['Platform_Description'] = '';
                        $properties['Platform_Icon']        = '';
                        break;
                    case 'HPUX':
                    case 'HP-UX':
                    case 'OpenVMS':
                        $properties['Device_Name'] = 'general Desktop';
                        $properties['Device_Maker'] = 'HP';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'HP';
                        $properties['Device_Type'] = 'Desktop';
                        $properties['Platform_Description'] = '';
                        $properties['Platform_Icon']        = '';
                        break;
                    case 'IRIX':
                    case 'IRIX64':
                        $properties['Device_Name'] = 'general Desktop';
                        $properties['Device_Maker'] = 'SGI';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'SGI';
                        $properties['Device_Type'] = 'Desktop';
                        $properties['Platform_Description'] = '';
                        $properties['Platform_Icon']        = '';
                        break;
                    case 'Solaris':
                    case 'SunOS':
                        $properties['Device_Name'] = 'general Desktop';
                        $properties['Device_Maker'] = 'Oracle';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'Oracle';
                        $properties['Device_Type'] = 'Desktop';
                        $properties['Platform_Description'] = '';
                        $properties['Platform_Icon']        = '';
                        break;
                    case 'OS/2':
                        $properties['Device_Name'] = 'general Desktop';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'IBM';
                        $properties['Device_Type'] = 'Desktop';
                        $properties['Platform_Description'] = '';
                        $properties['Platform_Icon']        = '';
                        break;
                    case 'Android':
                    case 'Dalvik':
                        $properties['Platform_Description'] = '';
                        $properties['Platform_Icon']        = '';
                        
                        if (!empty($properties['Device_Name']) && $properties['Device_Name'] !== 'NBPC724') {
                            $properties['isMobileDevice'] = true;
                            $properties['Device_isMobileDevice'] = true;
                            $properties['Device_isDesktop'] = false;
                            $properties['Device_isTv'] = false;
                            $properties['Platform_Maker'] = 'Google Inc';
                            if ($isTablet) {
                                $properties['Device_Type'] = 'Tablet';
                            } else {
                                $properties['Device_Type'] = 'Mobile Phone';
                            }
                        } elseif (!empty($properties['Device_Name']) && $properties['Device_Name'] === 'NBPC724') {
                            $properties['isMobileDevice'] = false;
                            $properties['Device_isMobileDevice'] = false;
                            $properties['Device_isDesktop'] = true;
                            $properties['Device_isTv'] = false;
                            $properties['Platform_Maker'] = 'Google Inc';
                            $properties['Device_Type'] = 'Desktop';
                        }
                        break;
                    case 'FreeBSD':
                        $properties['Device_Name'] = 'general Desktop';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'FreeBSD Foundation';
                        $properties['Device_Type'] = 'Desktop';
                        $properties['Platform_Description'] = '';
                        $properties['Platform_Icon']        = '';
                        break;
                    case 'NetBSD':
                    case 'OpenBSD':
                    case 'RISC OS':
                    case 'Unix':
                        $properties['Device_Name'] = 'general Desktop';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'unknown';
                        $properties['Device_Type'] = 'Desktop';
                        $properties['Platform_Description'] = '';
                        $properties['Platform_Icon']        = '';
                        break;
                    case 'WebTV':
                        $properties['Device_Name'] = 'General TV Device';
                        $properties['Device_Maker'] = 'unknown';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = false;
                        $properties['Device_isTv'] = true;
                        $properties['Platform_Maker'] = 'unknown';
                        $properties['Device_Type'] = 'TV Device';
                        $properties['Platform_Description'] = '';
                        $properties['Platform_Icon']        = '';
                        break;
                    case 'ChromeOS':
                        $properties['Device_Name'] = 'general Desktop';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'Google Inc';
                        $properties['Device_Type'] = 'Desktop';
                        $properties['Platform_Description'] = '';
                        $properties['Platform_Icon']        = '';
                        break;
                    case 'Ubuntu':
                        $properties['Device_Name'] = 'Linux Desktop';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'Canonical';
                        $properties['Platform_Bits'] = 0;
                        $properties['Device_Type'] = 'Desktop';
                        $properties['Platform_Description'] = '';
                        $properties['Platform_Icon']        = '';
                        break;
                    default:
                        $properties['Platform_Description'] = '';
                        $properties['Platform_Icon']        = '';
                        break;
                }
            }
            
            if (empty($properties['Device_Name'])) {
                $properties['Device_Marketing_Name'] = '';
            } elseif (empty($properties['Device_Marketing_Name'])
                || false !== strpos($properties['Device_Marketing_Name'], 'unknown')
                || false !== strpos($properties['Device_Marketing_Name'], 'general')
            ) {
                $properties['Device_Marketing_Name'] = $properties['Device_Name'];
            }
            
            if (empty($properties['Device_Maker'])) {
                $properties['Device_Brand_Name'] = '';
            } elseif (empty($properties['Device_Brand_Name'])
                || false !== strpos($properties['Device_Brand_Name'], 'unknown')
                || false !== strpos($properties['Device_Brand_Name'], 'general')
            ) {
                $properties['Device_Brand_Name'] = $properties['Device_Maker'];
            }
            
            $this->browsers[$key] = $properties;
        }
        
        $allBrowsers = array();
        $groups      = array();
        
        foreach ($this->browsers as $key => $properties) {
            $allBrowsers[$this->userAgents[$key]] = array($key, $properties);
        }
        
        foreach ($allBrowsers as $title => $data) {
            $x = 0;
            
            $properties = $data[1];
            
            $groups[$properties['Parents']][] = $title;
        }
        /*
        if (true) {
            foreach ($allBrowsers as $title => $data) {
                $properties = $data[1];
                
                if ((!empty($properties['Parents'])
                    && false !== strpos(' on ', $properties['Parents']))
                    ||  false !== strpos(' on ', $title)
                ) {
                    continue;
                }
                
                if ('unknown' == $properties['Platform_Name']
                    || '' == $properties['Platform_Name']
                ) {
                    continue;
                }
                
                $newParent    = $properties['Parent'] . ' on ' . $properties['Platform_Name'];
                $newGroupName = $properties['Parents'] . ',' . $newParent;
                
                $newGroups[$newGroupName][] = $title;
                
                if ('unknown' == $properties['Platform_Full']
                    || '' == $properties['Platform_Full']
                    || $properties['Platform_Name'] == $properties['Platform_Full']
                ) {
                    continue;
                }
                
                $secondNewParent    = $properties['Parent'] . ' on ' . $properties['Platform_Full'];
                $secondNewGroupName = $properties['Parents']
                    . ',' . $newParent
                    . ',' . $secondNewParent;
                
                $newGroups[$secondNewGroupName][]  = $title;
                $newGroups2[$secondNewGroupName][] = $title;
            }
            
            foreach ($this->userAgents as $input => $title) {
                $x = 0;
                
                $properties = $allBrowsers[$title][1];
                
                if (($properties['Parents']
                    && false !== strpos(' on ', $properties['Parents']))
                    ||  false !== strpos(' on ', $title)
                ) {
                    continue;
                }
                
                if ('unknown' == $properties['Platform_Name']
                    || '' == $properties['Platform_Name']
                ) {
                    continue;
                }
                
                $newParent    = $properties['Parent'] . ' on ' . $properties['Platform_Name'];
                $newGroupName = $properties['Parents'] . ',' . $newParent;
                
                if (!isset($newGroups[$newGroupName])
                    // || count($newGroups[$newGroupName]) <= 1
                ) {
                    continue;
                }
                
                if (!isset($allBrowsers[$newParent])) {
                    $key             = count($allAgents);
                    $this->userAgents[$key] = $newParent;
                    
                    $newProperty = $allBrowsers[$allBrowsers[$title][1]['Parent']][1];
                    $newProperty['Browser_Version']      = $properties['Browser_Version'];
                    $newProperty['Version']              = $properties['Browser_Version'];
                    $newProperty['Platform_Name']        = $properties['Platform_Name'];
                    $newProperty['Platform']             = $properties['Platform'];
                    $newProperty['Platform_Maker']       = $properties['Platform_Maker'];
                    $newProperty['Platform_Description'] = $properties['Platform_Description'];
                    $newProperty['Parents']              = $properties['Parents'];
                    $newProperty['Parent']               = $allBrowsers[$title][1]['Parent'];
                    
                    $allBrowsers[$newParent][0] = $key;
                    $allBrowsers[$newParent][1] = $newProperty;
                    
                    $this->browsers[$key] = $newProperty;
                }
                
                $allBrowsers[$title][1]['Parent']  = $newParent;
                $allBrowsers[$title][1]['Parents'] = $newGroupName;
                
                $secondNewParent    = $properties['Parent'] . ' on ' . $properties['Platform_Full'];
                $secondNewGroupName = $properties['Parents']
                    . ',' . $newParent
                    . ',' . $secondNewParent;
                echo $secondNewParent;
                if ($newParent == $secondNewParent) { echo ' skipped (1) ...' . "\n";
                    continue;
                }
                
                if (!isset($newGroups2[$secondNewGroupName]) 
                    || count($newGroups2[$secondNewGroupName]) <= 1
                ) {echo ' skipped (2) ...' . "\n";
                    continue;
                }
                
                if (!isset($allBrowsers[$secondNewGroupName])) {
                    $secondKey             = count($allAgents);
                    $this->userAgents[$secondKey] = $secondNewParent;
                    
                    $newProperty = $allBrowsers[$allBrowsers[$title][1]['Parent']][1];
                    $newProperty['Browser_Version']      = $properties['Browser_Version'];
                    $newProperty['Version']              = $properties['Browser_Version'];
                    $newProperty['Platform_Name']        = $properties['Platform_Name'];
                    $newProperty['Platform']             = $properties['Platform'];
                    $newProperty['Platform_Maker']       = $properties['Platform_Maker'];
                    $newProperty['Platform_Description'] = $properties['Platform_Description'];
                    $newProperty['Parents']              = $properties['Parents'];
                    $newProperty['Platform_Version']     = $properties['Platform_Version'];
                    $newProperty['Platform_Full']        = $properties['Platform_Full'];
                    $newProperty['Parents']              = $newGroupName;
                    $newProperty['Parent']               = $newParent;
                    
                    $allBrowsers[$secondNewParent][0] = $secondKey;
                    $allBrowsers[$secondNewParent][1] = $newProperty;
                    
                    $this->browsers[$secondKey] = $newProperty;echo ' added ...' . "\n";
                } else {
                    echo ' existed ...' . "\n";
                }
                
                $allBrowsers[$title][1]['Parent']  = $secondNewParent;
                $allBrowsers[$title][1]['Parents'] = $secondNewGroupName;
            }
        }
        /**/
        
        //sort
        if ($doSort) {
            $sort1  = array();
            $sort2  = array();
            $sort3  = array();
            $sort4  = array();
            $sort5  = array();
            $sort6  = array();
            $sort7  = array();
            $sort8  = array();
            $sort9  = array();
            $sort10 = array();
            $sort11 = array();
            $sort12 = array();
            $sort13 = array();
            $sort14 = array();
            $sort15 = array();
            $sort16 = array();
            
            foreach ($allBrowsers as $title => $data) {
                $x = 0;
                
                $key        = $data[0];
                $properties = $data[1];
                
                if (!empty($properties['Category'])) {
                    switch ($properties['Category']) {
                        case 'Bot/Crawler':
                            $x = 1;
                            break;
                        case 'Application':
                            $x = 2;
                            break;
                        case 'Email Client':
                            $x = 3;
                            break;
                        case 'Library':
                            $x = 4;
                            break;
                        case 'Browser':
                            $x = 8;
                            break;
                        case 'Unister':
                            $x = 9;
                            break;
                        case 'all':
                            $x = 10;
                            break;
                        case 'unknown':
                        default:
                            // nothing to do here
                            break;
                    }
                }
                
                if ('DefaultProperties' === $title) {
                    $x = -1;
                }
                
                if ('*' === $title) {
                    $x = 11;
                }
                
                $sort1[$title] = $x;
                
                if (!empty($properties['Browser_Name'])) {
                    $sort2[$title] = strtolower($properties['Browser_Name']);
                } else {
                    $sort2[$title] = strtolower($properties['Browser']);
                }
                
                if (!empty($properties['Browser_Version'])) {
                    $v = (float) $properties['Browser_Version'];
                } elseif (!empty($properties['Version'])) {
                    $v = (float) $properties['Version'];
                } else {
                    $v = 0.0;
                }
                
                $version->setVersion($v);
                $version->setUserAgent($this->userAgents[$key]);
                $sort3[$title]  = $version->getVersion(Version::MAJORONLY);
                $sort13[$title] = $version->getVersion(Version::MINORONLY);
                $sort14[$title] = $version->getVersion(Version::MICROONLY);
                
                if (!empty($properties['Browser_Bits'])) {
                    $bits = $properties['Browser_Bits'];
                } else {
                    $bits = 0;
                }
                
                $sort5[$title] = $bits;
                
                if (!empty($properties['Platform_Name'])) {
                    $sort4[$title] = strtolower($properties['Platform_Name']);
                } else {
                    $sort4[$title] = strtolower($properties['Platform']);
                }
                
                $v = 0;
                
                switch ($properties['Platform_Version']) {
                    case '3.1':
                        $v = 3.1;
                        break;
                    case '95':
                        $v = 3.2;
                        break;
                    case 'NT':
                        $v = 4;
                        break;
                    case '98':
                        $v = 4.1;
                        break;
                    case 'ME':
                        $v = 4.2;
                        break;
                    case '2000':
                        $v = 4.3;
                        break;
                    case 'XP':
                        $v = 4.4;
                        break;
                    case '2003':
                        $v = 4.5;
                        break;
                    case 'Vista':
                        $v = 6;
                        break;
                    case '7':
                        $v = 7;
                        break;
                    case '8':
                        $v = 8;
                        break;
                    default:
                        $v = (float) $properties['Platform_Version'];
                        break;
                }
                
                $version->setVersion($v);
                $version->setUserAgent($this->userAgents[$key]);
                $sort6[$title]  = $version->getVersion(Version::MAJORONLY);
                $sort15[$title] = $version->getVersion(Version::MINORONLY);
                $sort16[$title] = $version->getVersion(Version::MICROONLY);
                
                if (!empty($properties['Platform_Bits'])) {
                    $bits = $properties['Platform_Bits'];
                } else {
                    $bits = 0;
                }
                
                $sort9[$title] = $bits;
                
                $parents = $properties['Parents'] . ',' . $title;
                
                if (!empty($groups[$parents])) {
                    $group    = $parents;
                    $subgroup = 0;
                } else {
                    $group    = $properties['Parents'];
                    $subgroup = 1;
                }
                
                if (!empty($properties['Device_Maker'])
                    && false !== strpos($properties['Device_Maker'], 'unknown')
                    && false !== strpos($properties['Device_Maker'], 'general')
                ) {
                    $brandName = strtolower($properties['Device_Maker']);
                } else {
                    $brandName = '';
                }
                
                if (!empty($properties['Device_Name'])
                    && false !== strpos($properties['Device_Name'], 'unknown')
                    && false !== strpos($properties['Device_Name'], 'general')
                ) {
                    $marketingName = strtolower($properties['Device_Name']);
                } else {
                    $marketingName = '';
                }
                
                $sort7[$title]  = strtolower($group);
                $sort8[$title]  = strtolower($subgroup);
                $sort11[$title] = $brandName;
                $sort12[$title] = $marketingName;
                $sort10[$title] = $key;
            }
            
            array_multisort(
                $sort1, SORT_ASC, 
                $sort7, SORT_ASC,      // Parents
                $sort8, SORT_ASC,      // Parent first
                $sort2, SORT_ASC,      // Browser Name
                $sort3, SORT_NUMERIC,  // Browser Version::Major
                $sort13, SORT_NUMERIC, // Browser Version::Minor
                $sort14, SORT_NUMERIC, // Browser Version::Micro
                $sort4, SORT_ASC,      // Platform Name
                $sort6, SORT_NUMERIC,  // Platform Version::Major
                $sort15, SORT_NUMERIC, // Platform Version::Minor
                $sort16, SORT_NUMERIC, // Platform Version::Micro
                $sort9, SORT_NUMERIC,  // Platform Bits
                $sort5, SORT_NUMERIC,  // Browser Bits
                $sort11, SORT_ASC,     // Device Hersteller
                $sort12, SORT_ASC,     // Device Name
                $sort10, SORT_ASC, 
                $allBrowsers
            );
        }
        
        $outputPhp = '';
        $outputAsp = '';
        
        $fp = fopen($this->localFile . '.full.php.ini', 'w');
        fwrite(
            $fp, 
';;; Provided courtesy of https://browsers.garykeith.com
;;; Created on Tuesday, March 12, 2013 at 3:03 AM UTC

;;; Keep up with the latest goings-on with the project:
;;; Follow us on Twitter <https://twitter.com/browscap>, or...
;;; Like us on Facebook <https://facebook.com/browscap>, or...
;;; Collaborate on GitHub <https://github.com/GaryKeith/browscap>, or...
;;; Discuss on Google Groups <https://groups.google.com/d/forum/browscap>.

;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;; Browscap Version

[GJK_Browscap_Version]
Version=5020
Released=$Date$

;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;; known Platforms
;
;unknown - not detected
;Dalvik  - VM on Andoid
;Darwin  - Free BSD based Hybridkernel OS for the MAC
;Bada    - a OS developt by Samsung
;Mac OS X
;MacPPC
;WAP
;Solaris
;Polaris - a free clone of Solaris
;' . "\n"
        );
        
        // shrink
        foreach ($allBrowsers as $title => $data) {
            $properties = $data[1];
            
            if (!isset($properties['Version'])) {
                continue;
            }
            
            if (!isset($properties['Parent']) 
                && 'DefaultProperties' !== $title 
                && '*' !== $title
            ) {
                continue;
            }
            
            if ('DefaultProperties' !== $title
                && '*' !== $title
            ) {
                $agentsToFind = array_flip($this->userAgents);
                if (!isset($this->browsers[$agentsToFind[$properties['Parent']]])) {
                    continue;
                }
                
                $parent = $this->browsers[$agentsToFind[$properties['Parent']]];
            } else {
                $parent = array();
            }
            
            $propertiesToOutput = $properties;
            
            foreach ($propertiesToOutput as $property => $value) {
                if (!isset($parent[$property])) {
                    continue;
                }
                
                if ($parent[$property] != $value) {
                    continue;
                }
                
                unset($propertiesToOutput[$property]);
            }
            
            // create output - php
            
            if ('DefaultProperties' == $title
                || empty($properties['Parent'])
                || 'DefaultProperties' == $properties['Parent']
            ) {
                fwrite($fp, ';;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;' . "\n" . '; ' . $title . "\n" . ';;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;' . "\n\n");
            }
            
            $parents = $properties['Parents'] . ',' . $title;
            
            if ('DefaultProperties' != $title
                && !empty($properties['Parent'])
                && 'DefaultProperties' != $properties['Parent']
                && !empty($groups[$parents])
                && count($groups[$parents])
            ) {
                if (false !== strpos($title, ' on ')) {
                    fwrite($fp, '; ' . $title . "\n\n");
                } else {
                    fwrite($fp, ';;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;; ' . $title . "\n\n");
                }
            }
            
            fwrite($fp, '[' . $title . ']' . "\n");
            
            foreach ($this->properties as $property) {
                if (!isset($propertiesToOutput[$property]) || 'Parents' === $property) {
                    continue;
                }
                
                $value = $propertiesToOutput[$property];
                
                if (true === $value) {
                    $valuePhp = 'true';
                    $valueAsp = 'true';
                } elseif (false === $value) {
                    $valuePhp = 'false';
                    $valueAsp = 'false';
                } elseif ('0' === $value
                    || 'Parent' === $property
                    || 'Version' === $property
                    || 'MajorVer' === $property
                    || 'MinorVer' === $property
                    || 'RenderingEngine_Version' === $property
                    || 'Platform_Version' === $property
                    || 'Browser_Version' === $property
                ) {
                    $valuePhp = $value;
                } else {
                    $valuePhp = '"' . $value . '"';
                }
                
                fwrite($fp, $property . '=' . $valuePhp . "\n");
            }
            
            fwrite($fp, "\n");
        }
        
        fclose($fp);
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @return array
     */
    private function getBrowserFromGlobalCache()
    {
        try {
            return $this->updateCache();
        } catch (Exception $e) {
            return array();
        }
    }

    /**
     * sets the name of the local file
     *
     * @param string $filename the file name
     *
     * @return void
     */
    public function setLocaleFile($filename)
    {
        if (empty($filename)) {
            throw new Exception(
                'the filename can not be empty', Exception::LOCAL_FILE_MISSING
            );
        }
        
        $this->localFile = $filename;
    }

    /**
     * Parses the ini file and updates the cache files
     *
     * @return array
     */
    private function updateCache()
    {
        $browsers = $this->parseIni();
        
        array_unshift(
            $this->properties,
            'browser_name',
            'browser_name_regex',
            'browser_name_pattern'
        );
        
        usort(
            $this->userAgents,
            function($a, $b) {
                $a = strlen($a);
                $b = strlen($b);
                return ($a == $b ? 0 :($a < $b ? 1 : -1));
            }
        );

        
        $this->parseAllAgents($browsers);

        // Save the keys lowercased if needed
        if ($this->lowercase) {
            $this->properties = array_map('strtolower', $this->properties);
        }
        
        return array(
            'browsers'   => $this->browsers,
            'userAgents' => $this->userAgents,
            'patterns'   => $this->patterns,
            'properties' => $this->properties
        );
    }

    /**
     * Parses the user agents
     */
    private function parseAgents(
        $browsers, $sUserAgent, $aPropertiesKeys, $outerKey)
    {
        $browser = array();

        $userAgent = $sUserAgent;
        $parents   = array($userAgent);
        
        while (isset($browsers[$userAgent]['Parent'])) {
            if ($userAgent === $browsers[$userAgent]['Parent']) {
                var_dump('Parent is identical to key for key "' . $userAgent . '"');
                break;
            }
            
            $parents[] = $browsers[$userAgent]['Parent'];
            $userAgent = $browsers[$userAgent]['Parent'];
        }
        unset($userAgent);
        
        $parents     = array_reverse($parents);
        $browserData = array();

        foreach ($parents as $parent) {
            if (!isset($browsers[$parent])) {
                var_dump('Parent not found for key "' . $parent . '"');
                continue;
            }
            
            if (!is_array($browsers[$parent])) {
                var_dump('empty Parent found for key "' . $parent . '"');
                continue;
            }
            
            if (isset($browsers[$parent]) && is_array($browsers[$parent])) {
                $browserData = array_merge($browserData, $browsers[$parent]);
            }
        }
        
        array_pop($parents);
        $browserData['Parents'] = implode(',', $parents);

        $search  = array('\*', '\?');
        $replace = array('.*', '.');
        $pattern = preg_quote($sUserAgent, '@');

        $this->patterns[$outerKey] = '@'
            . '^'
            . str_replace($search, $replace, $pattern)
            . '$'
            . '@';

        foreach ($browserData as $key => $value) {
            switch ($value) {
                case 'true':
                    $browser[$key] = true;
                    break;
                case 'false':
                    $browser[$key] = false;
                    break;
                default:
                    $browser[$key] = $value;
                    break;
            }
        }
        
        $this->browsers[$outerKey] = $browser;
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