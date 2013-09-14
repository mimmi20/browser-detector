<?php
namespace BrowserDetector\Input;

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
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2013 Thomas Mueller
 * @version   SVN: $Id$
 */

use \BrowserDetector\Detector\Version;
use \BrowserDetector\Detector\Company;
use \BrowserDetector\Detector\Result;
use \BrowserDetector\Helper\InputMapper;
use \BrowserDetector\Detector\Bits as BitsDetector;

/**
 * Browscap.ini parsing class with caching and update capabilities
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2013 Thomas Mueller
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
class Browscap extends Core
{
    /**
     * the UAParser class
     *
     * @var \phpbrowscap\Browscap
     */
    private $uaParser = null;
    
    /**
     * sets the UA Parser detector
     *
     * @var \phpbrowscap\Browscap $parser
     *
     * @return \phpbrowscap\Browscap
     */
    public function setParser(\phpbrowscap\Browscap $parser)
    {
        $this->uaParser = $parser;
        
        return $this;
    }
    
    /**
     * sets the cache used to make the detection faster
     *
     * @param \Zend\Cache\Storage\Adapter\AbstractAdapter $cache
     *
     * @return \BrowserDetector\Input\Uaparser
     */
    public function setCache(\Zend\Cache\Storage\Adapter\AbstractAdapter $cache)
    {
        $this->cache = $cache;
        
        return $this;
    }

    /**
     * sets the the cache prfix
     *
     * @param string $prefix the new prefix
     *
     * @return \BrowserDetector\Input\Uaparser
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
     * Gets the information about the browser by User Agent
     *
     * @return \BrowserDetector\Detector\Result the object containing the browsers details.
     */
    public function getBrowser()
    {
        if (!($this->uaParser instanceof \phpbrowscap\Browscap)) {
            throw new \UnexpectedValueException(
                'the parser object has to be an instance of \\phpbrowscap\\Browscap'
            );
        }
        
        $parserResult = $this->uaParser->getBrowser($this->_agent, true);
        
        $result = new Result();
        $result->setCapability('useragent', $this->_agent);
        
        $mapper = new InputMapper();
        
        if (empty($parserResult['Browser_Name'])) {
            $browserName = $this->detectProperty($parserResult, 'Browser');
        } else {
            $browserName = $this->detectProperty($parserResult, 'Browser_Name');
        }
        if (!empty($parserResult['Browser_Version'])) {
            $browserVersion = $this->detectProperty(
                $parserResult, 'Browser_Version', true, $browserName
            );
        } else {
            $browserVersion = $this->detectProperty(
                $parserResult, 'Version', true, $browserName
            );
        }
        
        $browserName    = $mapper->mapBrowserName($browserName);
        $browserVersion = $mapper->mapBrowserVersion(
            $browserVersion, $browserName
        );
        
        $browserBits = $this->detectProperty(
            $parserResult, 'Browser_Bits', true, $browserName
        );
        $browserMaker = $this->detectProperty(
            $parserResult, 'Browser_Maker', true, $browserName
        );
        
        $result->setCapability('mobile_browser', $browserName);        
        $result->setCapability('mobile_browser_version', $browserVersion);
        $result->setCapability('mobile_browser_bits', $browserBits);
        $result->setCapability(
            'mobile_browser_manufacturer',
            $mapper->mapBrowserMaker($browserMaker, $browserName)
        );
        
        if (!empty($parserResult['Browser_Type'])) {
            $browserType = $parserResult['Browser_Type'];
        } elseif (!empty($parserResult['Category'])) {
            $browserType = $parserResult['Category'];
        } else {
            $browserType = null;
        }
        
        $result->setCapability('browser_type', $browserType);
        
        if (!empty($parserResult['Browser_Modus'])) {
            $browserModus = $parserResult['Browser_Modus'];
        } else {
            $browserModus = '';
        }
        
        $result->setCapability('mobile_browser_modus', $browserModus);
        
        if (!empty($parserResult['Browser_Icon'])) {
            $browserIcon = $parserResult['Browser_Icon'];
        } else {
            $browserIcon = '';
        }
        
        $result->setCapability('mobile_browser_icon', $browserIcon);
        
        if (!empty($parserResult['Platform_Name'])) {
            $platform = $this->detectProperty($parserResult, 'Platform_Name');
        } else {
            $platform = $this->detectProperty($parserResult, 'Platform');
        }
        
        $platformVersion = $this->detectProperty(
            $parserResult, 'Platform_Version', true, $platform
        );
        
        $platformVersion = $mapper->mapOsVersion(trim($platformVersion), trim($platform));
        $platform        = $mapper->mapOsName(trim($platform));
        
        $platformbits = $this->detectProperty(
            $parserResult, 'Platform_Bits', true, $platform
        );
        $platformMaker = $this->detectProperty(
            $parserResult, 'Platform_Maker', true, $platform
        );
        $platformIcon = $this->detectProperty(
            $parserResult, 'Platform_Icon', true, $platform
        );
        
        $result->setCapability('device_os', $platform);
        $result->setCapability('device_os_version', $platformVersion);
        $result->setCapability('device_os_bits', $platformbits);
        $result->setCapability('device_os_manufacturer', $platformMaker);
        $result->setCapability('device_os_icon', $platformIcon);
        
        $deviceName = $this->detectProperty($parserResult, 'Device_Code_Name');
        $deviceType = $this->detectProperty($parserResult, 'Device_Type');
        
        $result->setCapability('device_type', $deviceType);
        
        $deviceName = $mapper->mapDeviceName($deviceName);
        
        $deviceMaker = $this->detectProperty(
            $parserResult, 'Device_Maker', true, $deviceName
        );
        
        $deviceMarketingName = $this->detectProperty(
            $parserResult, 'Device_Name', true, $deviceName
        );
        
        $deviceBrandName = $this->detectProperty(
            $parserResult, 'Device_Brand_Name', true, $deviceName
        );
        
        $result->setCapability('model_name', $deviceName);
        $result->setCapability('marketing_name', $mapper->mapDeviceMarketingName($deviceMarketingName, $deviceName));
        $result->setCapability('brand_name', $mapper->mapDeviceBrandName($deviceBrandName, $deviceName));
        $result->setCapability('manufacturer_name', $mapper->mapDeviceMaker($deviceMaker, $deviceName));
        
        $engineName = $this->detectProperty($parserResult, 'RenderingEngine_Name');
        
        if ('unknown' === $engineName || '' === $engineName) {
            $engineName = null;
        }
        
        $engineMaker = $this->detectProperty(
            $parserResult, 'RenderingEngine_Maker', true, $engineName
        );
        
        $engineIcon = $this->detectProperty(
            $parserResult, 'RenderingEngine_Icon', true, $engineName
        );
        
        $result->setCapability(
            'renderingengine_name', $engineName
        );
        
        $result->setCapability('renderingengine_manufacturer', $engineMaker);
        $result->setCapability('renderingengine_icon', $engineIcon);
        
        if (!empty($parserResult['Device_isDesktop'])) {
            $result->setCapability('ux_full_desktop', 
            $parserResult['Device_isDesktop']);
        }
        
        if (!empty($parserResult['Device_isTv'])) {
            $result->setCapability('is_smarttv', $parserResult['Device_isTv']);
        }
        
        if (!empty($parserResult['Device_isMobileDevice'])) {
            $result->setCapability(
                'is_wireless_device', $parserResult['Device_isMobileDevice']
            );
        } elseif (!empty($parserResult['isMobileDevice'])) {
            $result->setCapability(
                'is_wireless_device', $parserResult['isMobileDevice']
            );
        }
        
        if (!empty($parserResult['Device_isTablet'])) {
            $result->setCapability('is_tablet', $parserResult['Device_isTablet']);
        } elseif (!empty($parserResult['isTablet'])) {
            $result->setCapability('is_tablet', $parserResult['isTablet']);
        }
        
        if (!empty($parserResult['Browser_isBot'])) {
            $result->setCapability('is_bot', $parserResult['Browser_isBot']);
        } elseif (!empty($parserResult['Crawler'])) {
            $result->setCapability('is_bot', $parserResult['Crawler']);
        }
        
        if (!empty($parserResult['Browser_isSyndicationReader'])) {
            $result->setCapability(
                'is_syndication_reader', $parserResult['Browser_isSyndicationReader']
            );
        } elseif (!empty($parserResult['isSyndicationReader'])) {
            $result->setCapability(
                'is_syndication_reader', $parserResult['isSyndicationReader']
            );
        }
        
        if (!empty($parserResult['Browser_isBanned'])) {
            $result->setCapability(
                'is_banned', $parserResult['Browser_isBanned']
            );
        } elseif (!empty($parserResult['isBanned'])) {
            $result->setCapability(
                'is_banned', $parserResult['isBanned']
            );
        }
        
        if (!empty($parserResult['Frames'])) {
            $framesSupport = $parserResult['Frames'];
        } else {
            $framesSupport = null;
        }
        
        $result->setCapability('xhtml_supports_frame', $mapper->mapFrameSupport($framesSupport));
        
        if (!empty($parserResult['IFrames'])) {
            $framesSupport = $parserResult['IFrames'];
        } else {
            $framesSupport = null;
        }
        
        $result->setCapability('xhtml_supports_iframe', $mapper->mapFrameSupport($framesSupport));
        
        if (!empty($parserResult['Tables'])) {
            $tablesSupport = $parserResult['Tables'];
        } else {
            $tablesSupport = null;
        }
        
        $result->setCapability('xhtml_table_support', $tablesSupport);
        
        if (!empty($parserResult['Cookies'])) {
            $cookieSupport = $parserResult['Cookies'];
        } else {
            $cookieSupport = null;
        }
        
        $result->setCapability('cookie_support', $cookieSupport);
        
        if (!empty($parserResult['BackgroundSounds'])) {
            $bgsoundSupport = $parserResult['BackgroundSounds'];
        } else {
            $bgsoundSupport = null;
        }
        
        $result->setCapability('supports_background_sounds', $bgsoundSupport);
        
        if (!empty($parserResult['VBScript'])) {
            $vbSupport = $parserResult['VBScript'];
        } else {
            $vbSupport = null;
        }
        
        $result->setCapability('supports_vb_script', $vbSupport);
        
        if (!empty($parserResult['JavaScript'])) {
            $jsSupport = $parserResult['JavaScript'];
        } else {
            $jsSupport = null;
        }
        
        $result->setCapability('ajax_support_javascript', $jsSupport);
        
        if (!empty($parserResult['JavaApplets'])) {
            $appletsSupport = $parserResult['JavaApplets'];
        } else {
            $appletsSupport = null;
        }
        
        $result->setCapability('supports_java_applets', $appletsSupport);
        
        if (!empty($parserResult['ActiveXControls'])) {
            $activexSupport = $parserResult['ActiveXControls'];
        } else {
            $activexSupport = null;
        }
        
        $result->setCapability('supports_activex_controls', $activexSupport);
        
        return $result;
    }
    
    /**
     * checks the parser result for special keys
     *
     * @param array   $allProperties  The parser result array
     * @param string  $propertyName   The name of the property to detect
     * @param boolean $depended       If TRUE the parameter $dependingValue has to be set
     * @param string  $dependingValue An master value
     *
     * @return string|integer|boolean The value of the detected property
     */
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