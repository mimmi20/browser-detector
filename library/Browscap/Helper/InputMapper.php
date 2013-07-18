<?php
namespace Browscap\Helper;

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
final class InputMapper
{
    /**
     * mapps the browser
     *
     * @param string
     *
     * @return string
     */
    public function mapBrowserName($browserInput)
    {
        if (!is_string($browserInput)) {
            throw new \UnexpectedValueException(
                'a string is required as input in this function'
            );
        }
        
        $browserName = $browserInput;
        
        switch (strtolower($browserInput)) {
            case 'unknown':
            case 'other':
            case 'default browser':
                $browserName = null;
                break;
            case 'ie':
                $browserName = 'Internet Explorer';
                break;
            case 'iceweasel':
                $browserName = 'Iceweasel';
                break;
            case 'mobile safari':
                $browserName = 'Safari';
                break;
            case 'chrome mobile':
                $browserName = 'Chrome';
                break;
            case 'android':
                $browserName = 'Android Webkit';
                break;
            case 'googlebot':
                $browserName = 'Google Bot';
                break;
            case 'bingbot':
                $browserName = 'BingBot';
                break;
            case 'jakarta commons-httpclient':
                $browserName = 'Jakarta Commons HttpClient';
                break;
            case 'adsbot-google':
                $browserName = 'AdsBot Google';
                break;
            case 'seokicks-robot':
                $browserName = 'SEOkicks Robot';
                break;
            default:
                // nothing to do here
                break;
        }
        
        return $browserName;
    }
    
    /**
     * maps the browser version
     *
     * @param string $browserVersion
     * @param string $browserName
     *
     * @return string
     */
    public function mapBrowserVersion($browserVersion, $browserName = null)
    {
        switch (strtolower($browserVersion)) {
            case 'unknown':
            case 'other':
                $browserVersion = null;
                break;
            default:
                // nothing to do here
                break;
        }
        
        switch (strtolower($browserName)) {
            case 'unknown':
            case 'other':
                $browserVersion = null;
                break;
            default:
                // nothing to do here
                break;
        }
        
        return $browserVersion;
    }
    
    /**
     * maps the browser type
     *
     * @param string $browserType
     * @param string $browserName
     *
     * @return string
     */
    public function mapBrowserType($browserType, $browserName = null)
    {
        switch (strtolower($browserType)) {
            case 'unknown':
            case 'other':
                $browserType = null;
                break;
            default:
                // nothing to do here
                break;
        }
        
        switch (strtolower($browserName)) {
            case 'unknown':
            case 'other':
            case '':
                $browserType = null;
                break;
            case 'zend_http_client':
                $browserType = 'Bot/Crawler';
                break;
            default:
                // nothing to do here
                break;
        }
        
        return $browserType;
    }
    
    /**
     * maps the browser maker
     *
     * @param string $browserMaker
     * @param string $browserName
     *
     * @return string
     */
    public function mapBrowserMaker($browserMaker, $browserName = null)
    {
        switch (strtolower($browserMaker)) {
            case 'unknown':
            case 'other':
                $browserMaker = null;
                break;
            default:
                // nothing to do here
                break;
        }
        
        switch (strtolower($browserName)) {
            case 'unknown':
            case 'other':
            case '':
                $browserMaker = null;
                break;
            default:
                // nothing to do here
                break;
        }
        
        return $browserMaker;
    }
    
    /**
     * maps the name of the operating system
     *
     * @param string $osName
     *
     * @return string
     */
    public function mapOsName($osName)
    {
        switch (strtolower($osName)) {
            case 'unknown':
            case 'other':
                $osName = null;
                break;
            case 'winxp':
            case 'win7':
            case 'win8':
            case 'winvista':
            case 'win2000':
            case 'win2003':
            case 'win98':
                $osName = 'Windows';
                break;
            case 'winphone7':
                $osName = 'Windows Phone OS';
                break;
            case 'blackberry os':
                $osName = 'RIM OS';
                break;
            default:
                // nothing to do here
                break;
        }
        
        return $osName;
    }
    
    /**
     * maps the maker of the operating system
     *
     * @param string $osMaker
     * @param string $osName
     *
     * @return string
     */
    public function mapOsMaker($osMaker, $osName = null)
    {
        switch (strtolower($osMaker)) {
            case 'unknown':
            case 'other':
                $osMaker = null;
                break;
            default:
                // nothing to do here
                break;
        }
        
        switch (strtolower($osName)) {
            case 'unknown':
            case 'other':
                $osMaker = null;
                break;
            default:
                // nothing to do here
                break;
        }
        
        return $osMaker;
    }
    
    /**
     * maps the version of the operating system
     *
     * @param string $osVersion
     * @param string $osName
     *
     * @return string
     */
    public function mapOsVersion($osVersion, $osName = null)
    {
        switch (strtolower($osVersion)) {
            case 'unknown':
            case 'other':
                $osVersion = null;
                break;
            default:
                // nothing to do here
                break;
        }
        
        switch (strtolower($osName)) {
            case 'unknown':
            case 'other':
                $osversion = null;
                break;
            case 'winxp':
                $osversion = 'XP';
                break;
            case 'win7':
                $osversion = '7';
                break;
            case 'win8':
                $osversion = '8';
                break;
            case 'winvista':
                $osversion = 'Vista';
                break;
            case 'win2000':
                $osversion = '2000';
                break;
            case 'win2003':
                $osversion = '2003';
                break;
            case 'win98':
                $osversion = '98';
                break;
            case 'winphone7':
                $osversion = '7';
                break;
            default:
                // nothing to do here
                break;
        }
        
        return $osVersion;
    }
    
    /**
     * maps the name of a device
     *
     * @param string $deviceName
     *
     * @return string
     */
    public function mapDeviceName($deviceName)
    {
        switch (strtolower($deviceName)) {
            case 'pc':
            case 'android':
            case 'unknown':
            case 'other':
                $deviceName = null;
                break;
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
                $deviceName = 'general Mobile Device';
                break;
            // Motorola
            case 'motomz616':
                $deviceName = 'MZ616';
                break;
            case 'motoxt610':
                $deviceName = 'XT610';
                break;
            case 'motxt912b':
                $deviceName = 'XT912B';
                break;
            // LG
            case 'lg/c550/v1.0':
                $deviceName = 'C550';
                break;
            // Samsung
            case 'gt s8500':
                $deviceName = 'GT-S8500';
                break;
            case 'gp-p6810':
                $deviceName = 'GT-P6810';
                break;
            case 'gt-i8350':
                $deviceName = 'GT-I8350';
                break;
            case 'gt-i5500':
                $deviceName = 'GT-I5500';
                break;
            case 'gt i7500':
                $deviceName = 'GT-I7500';
                break;
            case 'gt s5620':
                $deviceName = 'GT-S5620';
                break;
            case 'sgh-i917':
                $deviceName = 'SGH-I917';
                break;
            case 'sgh-i957':
                $deviceName = 'SGH-I957';
                break;
            case 'sgh-i900v':
                $deviceName = 'SGH-I900V';
                break;
            case 'sgh-i917':
                $deviceName = 'SGH-I917';
                break;
            case 'sgh i900':
                $deviceName = 'SGH-I900';
                break;
            case 'sph-930':
                $deviceName = 'SPH-M930';
                break;
            // Acer
            case 'acer e310':
                $deviceName = 'E310';
                break;
            case 'acer e320':
                $deviceName = 'E320';
                break;
            // HTC
            case 'sensationxe beats z715e':
                $deviceName = 'Sensation XE Beats Z715e';
                break;
            // Asus
            case 'asus-padfone':
                $deviceName = 'PadFone';
                break;
            // Creative
            case 'creative ziio7':
                $deviceName = 'ZiiO7';
                break;
            // HP
            case 'touchpad':
                $deviceName = 'Touchpad';
                break;
            // Huawei
            case 'u8800':
                $deviceName = 'U8800';
                break;
            // Amazon
            case 'd01400':
                $deviceName = 'Kindle';
                break;
            // Nokia
            case 'nokia asha 201':
                $deviceName = 'Asha 201';
                break;
            // Medion
            case 'p9514':
                $deviceName = 'LifeTab P9514';
                break;
            default:
                // nothing to do here
                break;
        }
        
        return $deviceName;
    }
    
    /**
     * maps the maker of a device
     *
     * @param string $deviceMaker
     * @param string $deviceName
     *
     * @return string
     */
    public function mapDeviceMaker($deviceMaker, $deviceName = null)
    {
        switch (strtolower($deviceMaker)) {
            case 'unknown':
            case 'other':
                $deviceMaker = null;
                break;
            default:
                // nothing to do here
                break;
        }
        
        switch (strtolower($deviceName)) {
            case 'unknown':
            case 'other':
            case 'various':
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
                $deviceMaker = null;
                break;
            // Motorola
            case 'motomz616':
            case 'motoxt610':
            case 'motxt912b':
                $deviceMaker = 'Motorola';
                break;
            // LG
            case 'lg/c550/v1.0':
                $deviceMaker = 'LG';
                break;
            // Samsung
            case 'gt s8500':
            case 'gp-p6810':
            case 'gt-i8350':
            case 'gt-i5500':
            case 'gt i7500':
            case 'gt s5620':
            case 'sgh-i917':
            case 'sgh-i957':
            case 'sgh-i900v':
            case 'sgh-i917':
            case 'sgh i900':
            case 'sph-930':
                $deviceMaker = 'Samsung';
                break;
            // Acer
            case 'acer e310':
            case 'acer e320':
                $deviceMaker = 'Acer';
                break;
            // HTC
            case 'sensationxe beats z715e':
                $deviceMaker = 'HTC';
                break;
            // Asus
            case 'asus-padfone':
                $deviceMaker = 'Asus';
                break;
            // Creative
            case 'creative ziio7':
                $deviceMaker = 'Creative';
                break;
            // HP
            case 'touchpad':
                $deviceMaker = 'HP';
                break;
            // Huawei
            case 'u8800':
                $deviceMaker = 'Huawei';
                break;
            // Amazon
            case 'd01400':
                $deviceMaker = 'Amazon';
                break;
            // Nokia
            case 'nokia asha 201':
                $deviceMaker = 'Nokia';
                break;
            // Medion
            case 'p9514':
                $deviceMaker = 'Medion';
                break;
            default:
                // nothing to do here
                break;
        }
        
        return $deviceMaker;
    }
    
    /**
     * maps the marketing name of a device
     *
     * @param string $marketingName
     * @param string $deviceName
     *
     * @return string
     */
    public function mapDeviceMarketingName($marketingName, $deviceName = null)
    {
        switch (strtolower($marketingName)) {
            case 'unknown':
            case 'other':
                $marketingName = null;
                break;
            case 'lg optimus chat':
                $marketingName = 'Optimus Chat';
                break;
            case 't mobile move balance':
                $marketingName = 'T-Mobile Move Balance';
                break;
            case 'xperia arc so-01c for docomo':
                $marketingName = 'Xperia Arc SO-01C for DoCoMo';
                break;
            default:
                // nothing to do here
                break;
        }
        
        switch (strtolower($deviceName)) {
            case 'unknown':
            case 'other':
            case 'various':
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
                $marketingName = null;
                break;
            // Acer
            case 'acer e320':
                $marketingName = 'Liquid Express';
                break;
            // HP
            case 'touchpad':
                $marketingName = 'Touchpad';
                break;
            // Medion
            case 'p9514':
                $marketingName = 'LifeTab P9514';
                break;
            default:
                // nothing to do here
                break;
        }
        
        return $marketingName;
    }
    
    /**
     * maps the brand name of a device
     *
     * @param string $brandName
     * @param string $deviceName
     *
     * @return string
     */
    public function mapDeviceBrandName($brandName, $deviceName = null)
    {
        switch (strtolower($brandName)) {
            case 'unknown':
            case 'other':
            case 'generic':
                $brandName = null;
                break;
            default:
                // nothing to do here
                break;
        }
        
        switch (strtolower($deviceName)) {
            case 'unknown':
            case 'other':
            case 'various':
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
                $brandName = null;
                break;
            // Medion
            case 'p9514':
                $brandName = 'Medion';
                break;
            default:
                // nothing to do here
                break;
        }
        
        return $brandName;
    }
}
