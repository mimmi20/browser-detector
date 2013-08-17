<?php
namespace Browscap\Input\Browscap;

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
class IniExpander
{
    /**
     * Where to store the value of the included PHP cache file
     *
     * @var array
     */
    private $globalCache   = null;
    private $injectedRules = array();
    private $localFile     = null;
    
    /**
     * a \Zend\Cache object
     *
     * @var \Zend\Cache
     */
    private $cache = null;
    
    /*
     * @var string
     */
    private $cachePrefix = '';
    
    /**
     * injects rules
     *
     * @param array $injectedRules
     *
     * @return IniExpander
     */
    public function injectRules(array $injectedRules)
    {
        $this->injectedRules = $injectedRules;
        
        return $this;
    }
    
    /**
     * sets the cache used to make the detection faster
     *
     * @param \Zend\Cache\Frontend\Core $cache
     *
     * @return IniExpander
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
     * @return IniExpander
     */
    public function setCachePrefix($prefix)
    {
        $this->cachePrefix = $prefix;
        
        return $this;
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
                $this->globalCache = new IniHandler();
                $this->globalCache->setLocaleFile($this->localFile);
                $this->globalCache->load();
                
                if ($this->cache instanceof \Zend\Cache\Frontend\Core) {
                    $this->cache->save($this->globalCache, $cacheGlobalId);
                }
            }
        }
    }
    
    public function expandIni($doSort = true, $addNewGroups = false)
    {
        $this->getGlobalCache();
        
        $allAgents     = $this->globalCache->getUserAgents();
        $browsers      = $this->globalCache->getBrowsers();
        $allProperties = $this->globalCache->getProperties();
        
        $browserBitHelper = new \Browscap\Detector\Bits\Browser();
        $osBitHelper      = new \Browscap\Detector\Bits\Os();
        
        // full expand
        foreach ($browsers as $key => $properties) {
            foreach ($properties as $k => $property) {
                if (is_string($property)) {
                    $properties[$k] = trim($property);
                }
                
                if (!empty($this->injectedRules[$key][$k])) {
                    $properties[$k] = trim($this->injectedRules[$key][$k]);
                }
            }
            
            if (!isset($properties['Version']) || !isset($properties['Browser'])) {
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
            
            $properties['Version']         = $completeVersion;
            $properties['Browser_Version'] = $completeVersion;
            $properties['Browser']         = $browserName;
            $properties['Browser_Name']    = $browserName;
            
            if (!empty($properties['Browser_Type'])) {
                $browserType = $properties['Browser_Type'];
            } elseif (!empty($properties['Category'])) {
                $browserType = $properties['Category'];
            } else {
                $browserType = 'all';
            }
            
            $properties['Category']     = $browserType;
            $properties['Browser_Type'] = $browserType;
            
            if (!empty($properties['Browser_SubType'])) {
                $browserSubType = $properties['Browser_SubType'];
            } elseif (!empty($properties['SubCategory'])) {
                $browserSubType = $properties['SubCategory'];
            } else {
                $browserSubType = '';
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
                $crawler = $properties['Browser_isBot'];
            }
            
            $properties['Crawler']       = $crawler;
            $properties['Browser_isBot'] = $crawler;
            
            $alpha = $properties['Alpha'];
            
            if (array_key_exists('Browser_isAlpha', $properties)) {
                $alpha = $properties['Browser_isAlpha'];
            }
            
            $properties['Alpha']           = $alpha;
            $properties['Browser_isAlpha'] = $alpha;
            
            $beta = $properties['Beta'];
            
            if (array_key_exists('Browser_isBeta', $properties)) {
                $beta = $properties['Browser_isBeta'];
            }
            
            $properties['Beta']           = $beta;
            $properties['Browser_isBeta'] = $beta;
            
            $browserBitHelper->setUserAgent($allAgents[$key]);
            $osBitHelper->setUserAgent($allAgents[$key]);
            
            $properties['Browser_Bits']  = $browserBitHelper->getBits();
            $properties['Platform_Bits'] = $osBitHelper->getBits();
            
            $properties['Win64'] = false;
            $properties['Win32'] = false;
            $properties['Win16'] = false;
            
            $platform = $properties['Platform'];
            
            if (!empty($properties['Platform_Name'])) {
                $platform = $properties['Platform_Name'];
            }
            
            $properties['Platform']      = $platform;
            $properties['Platform_Name'] = $platform;
                
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
            
            if ('DefaultProperties' == $allAgents[$key]
                || '*' == $allAgents[$key]
            ) {
                $properties['Platform_Bits'] = 0;
                $properties['Browser_Bits'] = 0;
                $properties['isTablet'] = false;
                $properties['Device_Type'] = 'unknown';
            } elseif ($crawler) {
                // $properties['RenderingEngine_Name'] = 'unknown';
                // $properties['RenderingEngine_Full'] = 'unknown';
                // $properties['RenderingEngine_Version'] = '0.0';
                // $properties['RenderingEngine_Description'] = 'unknown';
                // $properties['isTablet'] = false;
                // $properties['Win64'] = false;
                // $properties['Win32'] = false;
                // $properties['Win16'] = false;
                // $properties['Platform_Bits'] = 0;
                // $properties['Browser_Bits'] = 0;
                // $properties['Platform_Maker'] = 'Bot';
                // $properties['Device_Type'] = 'Bot';
            } elseif (!empty($properties['Device_Maker']) && $properties['Device_Maker'] == 'RIM') {
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
                        $properties['Platform_Maker'] = 'Microsoft Corporation';
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
                        $properties['Platform_Maker'] = 'Microsoft Corporation';
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
                        $properties['Platform_Maker'] = 'Microsoft Corporation';
                        $properties['Device_Type'] = 'Mobile Phone';
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
                    case 'MacOSX':
                    case 'Mac OS X':
                    case 'Mac68K':
                    case 'Darwin':
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
                        break;
                    case 'iOS':
                        $properties['Device_Maker'] = 'Apple Inc';
                        $properties['Device_Brand_Name'] = 'Apple';
                        $properties['isMobileDevice'] = true;
                        $properties['Device_isMobileDevice'] = true;
                        $properties['Device_isDesktop'] = false;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'Apple Inc';
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
                        break;
                    case 'HPUX':
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
                        break;
                    case 'IRIX':
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
                        break;
                    case 'Android':
                    case 'Dalvik':
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
                        $properties['Device_Name'] = 'general Desktop';
                        $properties['isMobileDevice'] = false;
                        $properties['isTablet'] = false;
                        $properties['Device_isMobileDevice'] = false;
                        $properties['Device_isTablet'] = false;
                        $properties['Device_isDesktop'] = true;
                        $properties['Device_isTv'] = false;
                        $properties['Platform_Maker'] = 'Google Inc';
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
            
            $browsers[$key] = $properties;
        }
        
        $allBrowsers = array();
        $groups      = array();
        $newGroups   = array();
        $newGroups2  = array();
        
        foreach ($browsers as $key => $properties) {
            $allBrowsers[$allAgents[$key]] = array($key, $properties);
        }
        
        foreach ($allBrowsers as $title => $data) {
            $properties = $data[1];
            
            $groups[$properties['Parents']][] = $title;
        }
        
        if ($addNewGroups) {
            foreach ($allBrowsers as $title => $data) {
                $properties = $data[1];
                
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
                
                $newGroupName = $properties['Parents']
                    . ',' . $properties['Parent'] . ' on ' . $properties['Platform_Name'];
                
                $newGroups[$newGroupName][] = $title;
                
                if ('unknown' == $properties['Platform_Full']
                    || '' == $properties['Platform_Full']
                    || $properties['Platform_Name'] == $properties['Platform_Full']
                ) {
                    continue;
                }
                
                $newGroupName = $properties['Parents']
                    . ',' . $properties['Parent'] . ' on ' . $properties['Platform_Name']
                    . ',' . $properties['Parent'] . ' on ' . $properties['Platform_Full'];
                
                $newGroups[$newGroupName][]  = $title;
                $newGroups2[$newGroupName][] = $title;
            }
            
            foreach ($allAgents as $input => $title) {
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
                    || count($newGroups[$newGroupName]) <= 1
                ) {
                    continue;
                }
                
                if (!isset($allBrowsers[$newParent])) {
                    $key             = count($allAgents);
                    $allAgents[$key] = $newParent;
                    
                    $newProperty = $allBrowsers[$allBrowsers[$title][1]['Parent']][1];
                    $newProperty['Platform_Name']        = $properties['Platform_Name'];
                    $newProperty['Platform']             = $properties['Platform'];
                    $newProperty['Platform_Maker']       = $properties['Platform_Maker'];
                    $newProperty['Platform_Description'] = $properties['Platform_Description'];
                    $newProperty['Parent']               = $allBrowsers[$title][1]['Parent'];
                    
                    $allBrowsers[$newParent][0] = $key;
                    $allBrowsers[$newParent][1] = $newProperty;
                    
                    $browsers[$key] = $newProperty;
                }
                
                // $allBrowsers[$title][1]['Parent']  = $newParent;
                // $allBrowsers[$title][1]['Parents'] = $newGroupName;
                
                $secondNewParent    = $properties['Parent'] . ' on ' . $properties['Platform_Name'];
                $secondNewGroupName = $properties['Parents']
                    . ',' . $newParent
                    . ',' . $secondNewParent;
                
                if ($newParent == $secondNewParent
                    || !isset($newGroups2[$secondNewGroupName]) 
                    || count($newGroups2[$secondNewGroupName]) <= 1
                ) {
                    continue;
                }
                
                if (!isset($allBrowsers[$secondNewGroupName])) {
                    $secondKey             = count($allAgents);
                    $allAgents[$secondKey] = $secondNewParent;
                    
                    $newProperty = $allBrowsers[$newParent];
                    $newProperty['Platform_Name']        = $properties['Platform_Name'];
                    $newProperty['Platform']             = $properties['Platform'];
                    $newProperty['Platform_Maker']       = $properties['Platform_Maker'];
                    $newProperty['Platform_Description'] = $properties['Platform_Description'];
                    $newProperty['Platform_Version']     = $properties['Platform_Version'];
                    $newProperty['Platform_Full']        = $properties['Platform_Full'];
                    $newProperty['Parent']               = $newParent;
                    
                    $allBrowsers[$secondNewGroupName][0] = $secondKey;
                    $allBrowsers[$secondNewGroupName][1] = $newProperty;
                    
                    $browsers[$secondKey] = $newProperty;
                }
                
                // $allBrowsers[$title][1]['Parent']  = $secondNewParent;
                // $allBrowsers[$title][1]['Parents'] = $secondNewGroupName;
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
                    $sort3[$title] = (float) $properties['Browser_Version'];
                } else {
                    $sort3[$title] = (float) $properties['Version'];
                }
                
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
                $sort1, SORT_ASC,     // Category
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
                $sort10, SORT_DESC, 
                $allBrowsers
            );
        }
        
        $outputPhp = '';
        $outputAsp = '';
        
        $fp = fopen($this->localFile . '.full.php.ini', 'w');
        
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
                $agentsToFind = array_flip($allAgents);
                // var_dump($properties['Parent'], $agentsToFind[$properties['Parent']]);
                // var_dump(isset($browsers[$agentsToFind[$properties['Parent']]]));
                if (!isset($browsers[$agentsToFind[$properties['Parent']]])) {
                    continue;
                }
                
                $parent = $browsers[$agentsToFind[$properties['Parent']]];
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
                fwrite($fp, ';;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;; ' . $title . "\n\n");
            }
            
            fwrite($fp, '[' . $title . ']' . "\n");
            
            foreach ($allProperties as $property) {
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
}