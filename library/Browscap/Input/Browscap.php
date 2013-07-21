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
    private $_lowercase = false;

    /**
     * Where to store the value of the included PHP cache file
     *
     * @var array
     */
    private $_userAgents    = array();
    private $_browsers      = array();
    private $_patterns      = array();
    private $_properties    = array();
    private $_config        = null;
    private $_globalCache   = null;
    private $_localFile     = null;
    private $_injectedRules = array();

    /**
     * Constructor class, checks for the existence of (and loads) the cache and
     * if needed updated the definitions
     *
     * @param array|\Zend\Config\Config       $config
     * @param \Zend\Log\Logger                $log
     * @param array|\Zend\Cache\Frontend\Core $cache
     */
    public function __construct()
    {
        // default data file
        $this->setLocaleFile(__DIR__ . '/../data/browscap.ini');
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @return stdClas|array the object containing the browsers details.
     *                       Array if $bReturnAsArray is set to true.
     */
    public function getBrowser()
    {
        $this->_getGlobalCache();
        
        $browser = array();
        
        if (isset($this->_globalCache['patterns'])
            && is_array($this->_globalCache['patterns'])
        ) {
            foreach ($this->_globalCache['patterns'] as $key => $pattern) {
                if (preg_match($pattern, $this->_agent)) {
                    $browser = array(
                        'userAgent'   => $this->_agent, // Original useragent
                        'usedRegex'   => trim(strtolower($pattern), '@'),
                        'usedPattern' => $this->_globalCache['userAgents'][$key]
                    );

                    $browser += $this->_globalCache['browsers'][$key];

                    break;
                }
            }
        }

        $result = new Result();
        $result->setCapability('useragent', $this->_agent);
        
        $detector = new Version();
        $detector->setMode(
            Version::COMPLETE
            | Version::IGNORE_MINOR_IF_EMPTY
            | Version::IGNORE_MICRO_IF_EMPTY
        );
        
        $mapper = new InputMapper();
        
        if (empty($browser['Browser_Name'])) {
            $browserName = $this->_detectProperty($browser, 'Browser');
        } else {
            $browserName = $this->_detectProperty($browser, 'Browser_Name');
        }
        if (!empty($browser['Browser_Version'])) {
            $browserVersion = $this->_detectProperty(
                $browser, 'Browser_Version', true, $browserName
            );
        } else {
            $browserVersion = $this->_detectProperty(
                $browser, 'Version', true, $browserName
            );
        }
        
        $browserName = $mapper->mapBrowserName($browserName);
        
        $browserBits = $this->_detectProperty(
            $browser, 'Browser_Bits', true, $browserName
        );
        $browserMaker = $this->_detectProperty(
            $browser, 'Browser_Maker', true, $browserName
        );
        
        $detectorBrowser = clone $detector;
        
        $result->setCapability('mobile_browser', $browserName);        
        $result->setCapability(
            'mobile_browser_version',
            $detectorBrowser->setVersion($browserVersion)
        );
        $result->setCapability('mobile_browser_bits', $browserBits);
        $result->setCapability('mobile_browser_manufacturer', $browserMaker);
        
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
            $platform = $this->_detectProperty($browser, 'Platform_Name');
        } else {
            $platform = $this->_detectProperty($browser, 'Platform');
        }
        
        $platformVersion = $this->_detectProperty(
            $browser, 'Platform_Version', true, $platform
        );
        
        $platform        = $mapper->mapOsName(trim($platform));
        $platformVersion = $mapper->mapOsVersion(trim($platformVersion), $platform);
        
        $platformbits = $this->_detectProperty(
            $browser, 'Platform_Bits', true, $platform
        );
        $platformMaker = $this->_detectProperty(
            $browser, 'Platform_Maker', true, $platform
        );
        
        $detectorOs = clone $detector;
        
        $result->setCapability('device_os', $platform);
        $result->setCapability(
            'device_os_version', $detectorOs->setVersion($platformVersion)
        );
        $result->setCapability('device_os_bits', $platformbits);
        $result->setCapability('device_os_manufacturer', $platformMaker);
        
        $deviceName = $this->_detectProperty($browser, 'Device_Name');
        $deviceType = $this->_detectProperty($browser, 'Device_Type');
        
        $result->setCapability('device_type', $deviceType);
        
        $deviceName = $mapper->mapDeviceName($deviceName);
        
        $deviceMaker = $this->_detectProperty(
            $browser, 'Device_Maker', true, $deviceName
        );
        
        $deviceMarketingName = $this->_detectProperty(
            $browser, 'Device_Marketing_Name', true, $deviceName
        );
        
        $deviceBrandName = $this->_detectProperty(
            $browser, 'Device_Brand_Name', true, $deviceName
        );
        
        $deviceMaker = $mapper->mapDeviceMaker($deviceMaker, $deviceName);
        
        $result->setCapability('model_name', $deviceName);
        $result->setCapability('marketing_name', $deviceMarketingName);
        $result->setCapability('brand_name', $deviceBrandName);
        $result->setCapability('manufacturer_name', $deviceMaker);
        
        $engineName = $this->_detectProperty($browser, 'RenderingEngine_Name');
        
        if ('unknown' === $engineName || '' === $engineName) {
            $engineName = null;
        }
        
        /*
        $detectorEngine = clone $detector;
        
        $engineVersion = $this->_detectProperty(
            $browser, 'RenderingEngine_Version', true, $engineName
        );
        
        if ('unknown' === $engineVersion || '' === $engineVersion) {
            $engineVersion = null;
        }
        /**/
        
        $engineMaker = $this->_detectProperty(
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
        
        $supportFrames = $browser['Frames'];
        
        switch ($supportFrames) {
            case true:
                $supportFrames = 'full';
                break;
            case false:
                $supportFrames = 'none';
                break;
            default:
                // nothing to do here
                break;
        }
        
        $result->setCapability('xhtml_supports_frame', $supportFrames);
        
        $supportFrames = $browser['IFrames'];
        
        switch ($supportFrames) {
            case true:
                $supportFrames = 'full';
                break;
            case false:
                $supportFrames = 'none';
                break;
            default:
                // nothing to do here
                break;
        }
        $result->setCapability('xhtml_supports_iframe', $supportFrames);
        $result->setCapability('xhtml_table_support', $browser['Tables']);
        $result->setCapability('cookie_support', $browser['Cookies']);
        $result->setCapability('supports_background_sounds', $browser['BackgroundSounds']);
        $result->setCapability('supports_vb_script', $browser['VBScript']);
        $result->setCapability('ajax_support_javascript', $browser['JavaScript']);
        $result->setCapability('supports_java_applets', $browser['JavaApplets']);
        $result->setCapability('supports_activex_controls', $browser['ActiveXControls']);
        
        return $result;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string $userAgent   the user agent string
     * @param bool   $bReturnAsArray whether return an array or an object
     *
     * @return void
     */
    private function _getGlobalCache()
    {
        if (null === $this->_globalCache) {
            $cacheGlobalId = $this->_cachePrefix . 'agentsGlobal';
            
            // Load the cache at the first request
            if (!($this->_cache instanceof \Zend\Cache\Frontend\Core) 
                || !$this->_globalCache = $this->_cache->load($cacheGlobalId)
            ) {
                $this->_globalCache = $this->_getBrowserFromGlobalCache();
                
                if ($this->_cache instanceof \Zend\Cache\Frontend\Core) {
                    $this->_cache->save($this->_globalCache, $cacheGlobalId);
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
        return $this->_expandRules();
    }
    
    /**
     * injects rules
     *
     * @param array $injectedRules
     */
    public function injectRules(array $injectedRules)
    {
        $this->_injectedRules = $injectedRules;
        
        return $this;
    }
    
    private function _parseIni()
    {
        if (empty($this->_localFile)) {
            throw new Exception(
                'please set the ini file before trying to parse it', 
                Exception::LOCAL_FILE_MISSING
            );
        }
        
        if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
            $browsers = parse_ini_file($this->_localFile, true, INI_SCANNER_RAW);
        } else {
            $browsers = parse_ini_file($this->_localFile, true);
        }
        
        array_shift($browsers);
        
        $this->_properties = array_keys($browsers['DefaultProperties']);
        array_unshift(
            $this->_properties,
            'Parent',
            'Parents'
        );

        $this->_userAgents = array_keys($browsers);
        
        return $browsers;
    }

    /**
     * Parses the user agents
     *
     * @return bool whether the file was correctly written to the disk
     */
    private function _parseAllAgents($browsers)
    {   
        $aPropertiesKeys = array_flip($this->_properties);
        $key             = 0;
        
        foreach ($this->_userAgents as $userAgent) {
            $this->_parseAgents(
                $browsers, $userAgent, $aPropertiesKeys, $key
            );
            $key++;
        }
    }
    
    private function _expandRules()
    {
        $browsers = $this->_parseIni();
        $this->_parseAllAgents($browsers);
        
        $output = array();
        
        foreach ($this->_browsers as $key => $properties) {
            $output[$this->_userAgents[$key]] = $properties;
        }
        
        return $output;
    }
    
    public function expandIni()
    {
        $browsers = $this->_parseIni();
        $this->_parseAllAgents($browsers);
        
        // full expand
        foreach ($this->_browsers as $key => $properties) {
            foreach ($properties as $k => $property) {
                if (is_string($property)) {
                    $properties[$k] = trim($property);
                }
                
                if (!empty($this->_injectedRules[$key][$k])) {
                    $properties[$k] = trim($this->_injectedRules[$key][$k]);
                }
            }
            
            if (!isset($properties['Version']) || !isset($properties['Browser'])) {
                echo 'attribute not found for key "' . $key . '" and rule "' . $this->_userAgents[$key] . '"' . "\n";
                var_dump($properties);
                echo "\n\n";
                continue;
            }
            
            $completeVersion = $properties['Version'];
            
            if (!empty($properties['Browser_Version'])) {
                $completeVersion = $properties['Browser_Version'];
            }
            
            $version = explode('.', $completeVersion, 2);
            $properties['MajorVer'] = $version[0];
            $properties['MinorVer'] = (isset($version[1]) ? $version[1] : '');
            
            $browserName = $properties['Browser'];
            
            if (!empty($properties['Browser_Name'])) {
                $browserName = $properties['Browser_Name'];
            }
            
            $properties['Version'] = $completeVersion;
            $properties['Browser'] = $browserName;
            
            $browserType    = $properties['Category'];
            $browserSubType = $properties['SubCategory'];
            /*
            if (!empty($properties['Browser_Type'])
                && 'unknown' !== $properties['Browser_Type']
                && 'all' !== $properties['Browser_Type']
            ) {
                $browserType = $properties['Browser_Type'];
            }
            */
            $properties['Category']     = $browserType;
            $properties['Browser_Type'] = $browserType;
            /*
            if (!empty($properties['Browser_SubType'])
                && 'unknown' !== $properties['Browser_SubType']
                && 'all' !== $properties['Browser_SubType']
            ) {
                $browserSubType = $properties['Browser_SubType'];
            }
            */
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
            
            $isBanned = $properties['isBanned'];
            
            if (array_key_exists('Browser_isBanned', $properties)) {
                $isBanned = $properties['Browser_isBanned'];
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
            
            $utils = new \Browscap\Helper\Utils();
            $utils->setUserAgent($this->_userAgents[$key]);
            
            if ($utils->checkIfContains(array('x64', 'Win64', 'x86_64', 'amd64', 'AMD64', 'ppc64'))) {
                // 64 bits
                $properties['Browser_Bits'] = 64;
            } elseif ($utils->checkIfContains(array('Win3.1', 'Windows 3.1', 'Win16'))) {
                // old deprecated 16 bit windows systems
                $properties['Browser_Bits'] = 16;
            } elseif ($utils->checkIfContains(array('CP/M', '8-bit'))) {
                // old deprecated 16 bit windows systems
                $properties['Browser_Bits'] = 8; //CP/M; 8-bit
            } else {
                // general windows or a 32 bit browser on a 64 bit system (WOW64)
                $properties['Browser_Bits'] = 32;
            }
            
            if ($utils->checkIfContains(array('x64', 'Win64', 'WOW64', 'x86_64', 'amd64', 'AMD64', 'ppc64'))) {
                $properties['Platform_Bits'] = 64;
            } elseif ($utils->checkIfContains(array('Win3.1', 'Windows 3.1'))) {
                $properties['Platform_Bits'] = 16;
            } elseif ($utils->checkIfContains(array('CP/M', '8-bit'))) {
                // old deprecated 16 bit windows systems
                $properties['Platform_Bits'] = 8; //CP/M; 8-bit
            } else {
                $properties['Platform_Bits'] = 32;
            }
            
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
            
            if (empty($properties['Platform_Description']) 
                || 'unknown' === $properties['Platform_Description']
            ) {
                $properties['Platform_Description'] = $properties['Platform_Full'];
            }
            
            if ('0.0' != $properties['RenderingEngine_Version']) {
                $properties['RenderingEngine_Full'] = trim($properties['RenderingEngine_Name'] . ' ' . $properties['RenderingEngine_Version']);
            } else {
                $properties['RenderingEngine_Full'] = $properties['RenderingEngine_Name'];
            }
            
            $mobileDevice = $properties['isMobileDevice'];
            
            if (!empty($properties['Device_isMobileDevice'])) {
                $mobileDevice = $properties['Device_isMobileDevice'];
            }
            
            $properties['isMobileDevice']        = $mobileDevice;
            $properties['Device_isMobileDevice'] = $mobileDevice;
            
            $isTablet = $properties['isTablet'];
            
            if (!empty($properties['Device_isTablet'])) {
                $isTablet = $properties['Device_isTablet'];
            }
            
            $properties['Device_isTablet'] = $isTablet;
            $properties['isTablet']        = $isTablet;
            
            if ($isTablet) {
                $properties['Device_Type'] = 'Tablet';
            }
            
            if ('DefaultProperties' == $this->_userAgents[$key] 
                || '*' == $this->_userAgents[$key]
            ) {
                $properties['Platform_Bits'] = 0;
                $properties['Browser_Bits'] = 0;
                $properties['isTablet'] = false;
                $properties['Device_Type'] = 'unknown';
            } elseif ($crawler) {
                $properties['RenderingEngine_Name'] = 'unknown';
                $properties['RenderingEngine_Full'] = 'unknown';
                $properties['RenderingEngine_Version'] = '0.0';
                $properties['RenderingEngine_Description'] = 'unknown';
                $properties['isTablet'] = false;
                $properties['Win64'] = false;
                $properties['Win32'] = false;
                $properties['Win16'] = false;
                $properties['Platform_Bits'] = 0;
                $properties['Browser_Bits'] = 0;
                $properties['Platform_Maker'] = 'Bot';
                $properties['Device_Type'] = 'Bot';
            } elseif ($properties['Device_Maker'] == 'RIM') {
                $properties['Device_Maker'] = 'RIM';
                $properties['isMobileDevice'] = true;
                $properties['isTablet'] = false;
                $properties['Device_isMobileDevice'] = true;
                $properties['Device_isTablet'] = false;
                $properties['Device_isDesktop'] = false;
                $properties['Device_isTv'] = false;
                $properties['Platform_Maker'] = 'RIM';
                $properties['Device_Type'] = 'Mobile Phone';
            } else {
                switch ($platform) {
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
                        $properties['Platform_Maker'] = 'Microsoft';
                        $properties['Device_Type'] = 'Desktop';
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
                        $properties['Platform_Maker'] = 'Microsoft';
                        $properties['Device_Type'] = 'Desktop';
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
                        $properties['Platform_Maker'] = 'Microsoft';
                        $properties['Device_Type'] = 'Mobile Phone';
                        break;
                    case 'Windows Phone OS':
                        $properties['isMobileDevice'] = true;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = true;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = false;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'Microsoft';
                        $properties['Device_Type'] = 'Mobile Phone';
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
                        break;
                    case 'Debian':
                    case 'Linux':
                    case 'Linux for TV':
                    case 'Linux Smartphone OS':
                        $properties['Platform_Name'] = 'Linux';
                        $properties['Platform_Maker'] = 'Linux Foundation';
                        
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
                        break;
                    case 'Macintosh':
                    case 'Mac OS X':
                    case 'Mac68K':
                    case 'Darwin':
                        $properties['Device_Name'] = 'Macintosh';
                        $properties['Device_Maker'] = 'Apple';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'Apple';
                        $properties['Device_Type'] = 'Desktop';
                        break;
                    case 'iOS':
                        $properties['Device_Maker'] = 'Apple';
                        $properties['isMobileDevice'] = true;
                        $properties['Device_isMobileDevice'] = true;
                        $properties['Device_isDesktop'] = false;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'Apple';
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
                        break;
                    case 'BeOS':
                        $properties['Device_Name'] = 'General Desktop';
                        $properties['Device_Maker'] = 'unknown';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'Access';
                        $properties['Device_Type'] = 'Desktop';
                        break;
                    case 'AIX':
                        $properties['Device_Name'] = 'General Desktop';
                        $properties['Device_Maker'] = 'IBM';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'IBM';
                        $properties['Device_Type'] = 'Desktop';
                        break;
                    case 'Digital Unix':
                    case 'Tru64 UNIX':
                        $properties['Device_Name'] = 'General Desktop';
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
                        break;
                    case 'HPUX':
                    case 'OpenVMS':
                        $properties['Device_Name'] = 'General Desktop';
                        $properties['Device_Maker'] = 'HP';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'HP';
                        $properties['Device_Type'] = 'Desktop';
                        break;
                    case 'IRIX':
                        $properties['Device_Name'] = 'General Desktop';
                        $properties['Device_Maker'] = 'SGI';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'SGI';
                        $properties['Device_Type'] = 'Desktop';
                        break;
                    case 'Solaris':
                    case 'SunOS':
                        $properties['Device_Name'] = 'General Desktop';
                        $properties['Device_Maker'] = 'Oracle';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'Oracle';
                        $properties['Device_Type'] = 'Desktop';
                        break;
                    case 'OS/2':
                        $properties['Device_Name'] = 'General Desktop';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'IBM';
                        $properties['Device_Type'] = 'Desktop';
                        break;
                    case 'Android':
                    case 'Dalvik':
                        if ($properties['Device_Name'] !== 'NBPC724') {
                            $properties['isMobileDevice'] = true;
                            $properties['Device_isMobileDevice'] = true;
                            $properties['Device_isDesktop'] = false;
                            $properties['Device_isTv'] = false;
                            $properties['Platform_Maker'] = 'Google';
                            $properties['Device_Type'] = 'Mobile Phone';
                        } elseif ($properties['Device_Name'] === 'NBPC724') {
                            $properties['isMobileDevice'] = false;
                            $properties['Device_isMobileDevice'] = false;
                            $properties['Device_isDesktop'] = true;
                            $properties['Device_isTv'] = false;
                            $properties['Platform_Maker'] = 'Google';
                            $properties['Device_Type'] = 'Desktop';
                        }
                        break;
                    case 'FreeBSD':
                    case 'NetBSD':
                    case 'OpenBSD':
                    case 'RISC OS':
                    case 'Unix':
                        $properties['Device_Name'] = 'General Desktop';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'unknown';
                        $properties['Device_Type'] = 'Desktop';
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
                        break;
                    case 'ChromeOS':
                        $properties['Device_Name'] = 'General Desktop';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'Google';
                        $properties['Device_Type'] = 'Desktop';
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
                        break;
                }
            }
            
            if (empty($properties['Device_Marketing_Name'])
                || false !== strpos($properties['Device_Marketing_Name'], 'unknown')
                || false !== strpos($properties['Device_Marketing_Name'], 'general')
            ) {
                $properties['Device_Marketing_Name'] = $properties['Device_Name'];
            }
            
            if (empty($properties['Device_Brand_Name'])
                || false !== strpos($properties['Device_Brand_Name'], 'unknown')
                || false !== strpos($properties['Device_Brand_Name'], 'general')
            ) {
                $properties['Device_Brand_Name'] = $properties['Device_Maker'];
            }
            
            $this->_browsers[$key] = $properties;
        }
        
        $allBrowsers = array();
        $parents     = array();
        $groups      = array();
        
        foreach ($this->_browsers as $key => $properties) {
            $allBrowsers[$this->_userAgents[$key]] = array($key, $properties);
        }
        
        foreach ($allBrowsers as $title => $data) {
            $x = 0;
            
            $key        = $data[0];
            $properties = $data[1];
            
            $groups[$properties['Parents']][] = $title;
            
            $parents[$title] = explode(',', $properties['Parents']);
        }
        
        //sort
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
                    case 'Email Clients':
                        $x = 3;
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
            
            $sort1[$title] = $x;
            
            $sort2[$title] = strtolower($properties['Browser_Name']);
            $sort3[$title] = (float) $properties['Browser_Version'];
            
            if (!empty($properties['Browser_Bits'])) {
                $bits = $properties['Browser_Bits'];
            } else {
                $bits = 0;
            }
            
            $sort5[$title] = $bits;
            $sort4[$title] = strtolower($properties['Platform_Name']);
            
            $version = 0;
            
            switch ($properties['Platform_Version']) {
                case '3.1':
                    $version = 3.1;
                    break;
                case '95':
                    $version = 3.2;
                    break;
                case 'NT':
                    $version = 4;
                    break;
                case '98':
                    $version = 4.1;
                    break;
                case 'ME':
                    $version = 4.2;
                    break;
                case '2000':
                    $version = 4.3;
                    break;
                case 'XP':
                    $version = 4.4;
                    break;
                case '2003':
                    $version = 4.5;
                    break;
                case 'Vista':
                    $version = 6;
                    break;
                case '7':
                    $version = 7;
                    break;
                case '8':
                    $version = 8;
                    break;
                default:
                    $version = (float) $properties['Platform_Version'];
                    break;
            }
            
            $sort6[$title] = $version;
            
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
            $sort8[$title]  = $subgroup;
            $sort10[$title] = $key;
            $sort11[$title] = $brandName;
            $sort12[$title] = $marketingName;
        }
        
        array_multisort(
            $sort1, SORT_ASC, 
            $sort7, SORT_ASC,     // Parents
            $sort8, SORT_ASC,     // Parent first
            $sort2, SORT_ASC,     // Browser Name
            $sort3, SORT_NUMERIC, // Browser Version
            $sort4, SORT_ASC,     // Platform Name
            $sort6, SORT_NUMERIC, // Platform Version
            $sort9, SORT_NUMERIC, // Platform Bits
            $sort5, SORT_NUMERIC, // Browser Bits
            $sort11, SORT_ASC,    // Device Hersteller
            $sort12, SORT_ASC,    // Device Name
            $sort10, SORT_ASC, 
            $allBrowsers
        );
        
        $output = '';
        
        // shrink
        foreach ($allBrowsers as $title => $data) {
            $key        = $data[0];
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
                $agentsToFind = array_flip($this->_userAgents);
                if (!isset($this->_browsers[$agentsToFind[$properties['Parent']]])) {
                    continue;
                }
                
                $parent = $this->_browsers[$agentsToFind[$properties['Parent']]];
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
            
            // create output
            
            if ('DefaultProperties' == $title
                || empty($properties['Parent'])
                || 'DefaultProperties' == $properties['Parent']
            ) {
                $output .= ';;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;' . "\n" . '; ' . $title . "\n" . ';;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;' . "\n\n";
            }
            
            $parents = $properties['Parents'] . ',' . $title;
            
            if ('DefaultProperties' != $title
                && !empty($properties['Parent'])
                && 'DefaultProperties' != $properties['Parent']
                && !empty($groups[$parents])
                && count($groups[$parents])
            ) {
                $output .= ';;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;; ' . $title . "\n\n";
            }
            
            $output .= '[' . $title . ']' . "\n";
            
            foreach ($this->_properties as $property) {
                if (!isset($propertiesToOutput[$property]) || 'Parents' === $property) {
                    continue;
                }
                
                $value = $propertiesToOutput[$property];
                
                if (true === $value) {
                    $value = 'true';
                } elseif (false === $value) {
                    $value = 'false';
                } elseif ('0' === $value || 'Parent' === $property || 'Version' === $property || 'MajorVer' === $property || 'MinorVer' === $property) {
                    // nothing to do here
                } else {
                    $value = '"' . $value . '"';
                }
                
                $output .= $property . '=' . $value . "\n";
            }
            
            $output .= "\n";
        }
        
        file_put_contents($this->_localFile . '.full.ini', $output);
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @return array
     */
    private function _getBrowserFromGlobalCache()
    {
        try {
            return $this->_updateCache();
        } catch (Exception $e) {
            return array();
        }
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
        
        $this->_localFile = $file;
    }

    /**
     * Parses the ini file and updates the cache files
     *
     * @return array
     */
    private function _updateCache()
    {
        $browsers = $this->_parseIni();
        
        array_unshift(
            $this->_properties,
            'browser_name',
            'browser_name_regex',
            'browser_name_pattern'
        );
        
        usort(
            $this->_userAgents,
            function($a, $b) {
                $a = strlen($a);
                $b = strlen($b);
                return ($a == $b ? 0 :($a < $b ? 1 : -1));
            }
        );

        
        $this->_parseAllAgents($browsers);

        // Save the keys lowercased if needed
        if ($this->_lowercase) {
            $this->_properties = array_map('strtolower', $this->_properties);
        }
        
        return array(
            'browsers'   => $this->_browsers,
            'userAgents' => $this->_userAgents,
            'patterns'   => $this->_patterns,
            'properties' => $this->_properties
        );
    }

    /**
     * Parses the user agents
     *
     * @return bool whether the file was correctly written to the disk
     */
    private function _parseAgents(
        $browsers, $sUserAgent, $aPropertiesKeys, $outerKey)
    {
        $browser = array();

        $userAgent = $sUserAgent;
        $parents   = array($userAgent);
        
        while (isset($browsers[$userAgent]['Parent'])) {
            $parents[] = $browsers[$userAgent]['Parent'];
            $userAgent = $browsers[$userAgent]['Parent'];
        }
        unset($userAgent);
        
        $parents     = array_reverse($parents);
        $browserData = array();

        foreach ($parents as $parent) {
            if (!isset($browsers[$parent])) {
                continue;
            }
            
            if (!is_array($browsers[$parent])) {
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

        $this->_patterns[$outerKey] = '@'
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
        
        $this->_browsers[$outerKey] = $browser;
    }
    
    private function _detectProperty(
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