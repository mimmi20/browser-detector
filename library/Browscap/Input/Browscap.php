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
    private $_userAgents  = array();
    private $_browsers    = array();
    private $_patterns    = array();
    private $_properties  = array();
    private $_config      = null;
    private $_globalCache = null;
    private $_localFile   = null;

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

        return (object) $browser;
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
    
    public function getAllBrowsers()
    {
        return $this->_expandRules();
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
            'Parent'
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
            }
            
            if (!isset($properties['Version']) || !isset($properties['Browser'])) {
                echo 'attribute not found for key "' . $key . '" and rule "' . $this->_userAgents[$key] . '"' . "\n";
                var_dump($properties);
                echo "\n\n";
                continue;
            }
            
            $version = explode('.', $properties['Version'], 2);
            $properties['MajorVer'] = $version[0];
            $properties['MinorVer'] = (isset($version[1]) ? $version[1] : '');
            
            $properties['Browser_Version'] = $properties['Version'];
            $properties['Browser_Name'] = $properties['Browser'];
            
            if ('0.0' != $properties['Browser_Version']) {
                $properties['Browser_Full'] = trim($properties['Browser_Name'] . ' ' . $properties['Browser_Version']);
            } else {
                $properties['Browser_Full'] = $properties['Browser_Name'];
            }
            
            $properties['Browser_isSyndicationReader'] = $properties['isSyndicationReader'];
            $properties['Browser_isBot'] = $properties['Crawler'];
            $properties['Browser_isAlpha'] = $properties['Alpha'];
            $properties['Browser_isBeta'] = $properties['Beta'];
            
            $utils = new \Browscap\Helper\Utils();
            $utils->setUserAgent($this->_userAgents[$key]);
            
            //if ($properties['Browser_Bits'] == 0) {
                if ($properties['Win64']) {
                    $properties['Browser_Bits'] = 64;
                } elseif ($properties['Win32']) {
                    $properties['Browser_Bits'] = 32;
                } elseif ($properties['Win16']) {
                    $properties['Browser_Bits'] = 16;
                }
                
                if ($utils->checkIfContains(array('x64', 'Win64', 'x86_64', 'amd64', 'AMD64', 'ppc64'))) {
                    // 64 bits
                    $properties['Browser_Bits'] = 64;
                } elseif ($utils->checkIfContains(array('Win3.1', 'Windows 3.1'))) {
                    // old deprecated 16 bit windows systems
                    $properties['Browser_Bits'] = 16;
                } elseif ($utils->checkIfContains(array('CP/M', '8-bit'))) {
                    // old deprecated 16 bit windows systems
                    $properties['Browser_Bits'] = 8; //CP/M; 8-bit
                } else {
                    // general windows or a 32 bit browser on a 64 bit system (WOW64)
                    $properties['Browser_Bits'] = 32;
                }
            //}
            
            //if ($properties['Platform_Bits'] == 0) {
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
            //}
            
            $properties['Win64'] = false;
            $properties['Win32'] = false;
            $properties['Win16'] = false;
                
            if ('Windows' == $properties['Platform']) {
                if (64 == $properties['Browser_Bits']) {
                    $properties['Win64'] = true;
                } elseif (32 == $properties['Browser_Bits']) {
                    $properties['Win32'] = true;
                } elseif (16 == $properties['Browser_Bits']) {
                    $properties['Win16'] = true;
                }
            }
            
            $properties['Platform_Name'] = $properties['Platform'];
            
            if ('0.0' != $properties['Platform_Version']) {
                $properties['Platform_Full'] = trim($properties['Platform_Name'] . ' ' . $properties['Platform_Version']);
            } else {
                $properties['Platform_Full'] = $properties['Platform_Name'];
            }
            
            if ('0.0' != $properties['RenderingEngine_Version']) {
                $properties['RenderingEngine_Full'] = trim($properties['RenderingEngine_Name'] . ' ' . $properties['RenderingEngine_Version']);
            } else {
                $properties['RenderingEngine_Full'] = $properties['RenderingEngine_Name'];
            }
            $properties['Device_isMobileDevice'] = $properties['isMobileDevice'];
            $properties['Device_isTablet'] = $properties['isTablet'];
            
            if ('DefaultProperties' == $this->_userAgents[$key] 
                || '*' == $this->_userAgents[$key]
            ) {
                $properties['Platform_Bits'] = 0;
                $properties['Browser_Bits'] = 0;
                $properties['isTablet'] = false;
            } elseif ($properties['Browser_isBot']) {
                $properties['RenderingEngine_Name'] = 'unknown';
                $properties['RenderingEngine_Full'] = 'unknown';
                $properties['RenderingEngine_Version'] = '0.0';
                $properties['RenderingEngine_Description'] = 'unknown';
                $properties['isTablet'] = false;
            } elseif ($properties['Device_Maker'] == 'RIM') {
                $properties['Device_Maker'] = 'RIM';
                $properties['isMobileDevice'] = true;
                $properties['isTablet'] = false;
                $properties['Device_isMobileDevice'] = true;
                $properties['Device_isTablet'] = false;
                $properties['Device_isDesktop'] = false;
                $properties['Device_isTv'] = false;
            } elseif ($properties['Platform_Name'] == 'Windows' 
                || $properties['Platform_Name'] == 'Win32'
            ) {
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
            } elseif ($properties['Platform_Name'] == 'CygWin') {
                $properties['Device_Name'] = 'Windows Desktop';
                $properties['Device_Maker'] = 'unknown';
                $properties['isMobileDevice'] = false;
                $properties['isTablet'] = false;
                $properties['Device_isMobileDevice'] = false;
                $properties['Device_isTablet'] = false;
                $properties['Device_isDesktop'] = true;
                $properties['Device_isTv'] = false;
                $properties['Platform_Maker'] = 'Microsoft';
            } elseif ($properties['Platform_Name'] == 'WinMobile' 
                || $properties['Platform_Name'] == 'Windows Mobile OS'
            ) {
                $properties['isMobileDevice'] = true;
                $properties['isTablet'] = false;
                $properties['Device_isMobileDevice'] = true;
                $properties['Device_isTablet'] = false;
                $properties['Device_isDesktop'] = false;
                $properties['Device_isTv'] = false;
                $properties['Platform'] = 'Windows Mobile OS';
                $properties['Platform_Name'] = 'Windows Mobile OS';
                $properties['Platform_Maker'] = 'Microsoft';
            } elseif ($properties['Platform_Name'] == 'Windows Phone OS') {
                $properties['isMobileDevice'] = true;
                $properties['isTablet'] = false;
                $properties['Device_isMobileDevice'] = true;
                $properties['Device_isTablet'] = false;
                $properties['Device_isDesktop'] = false;
                $properties['Device_isTv'] = false;
                $properties['Platform_Maker'] = 'Microsoft';
            } elseif ($properties['Platform_Name'] == 'Symbian OS' 
                || $properties['Platform_Name'] == 'SymbianOS'
            ) {
                $properties['isMobileDevice'] = true;
                $properties['isTablet'] = false;
                $properties['Device_isMobileDevice'] = true;
                $properties['Device_isTablet'] = false;
                $properties['Device_isDesktop'] = false;
                $properties['Device_isTv'] = false;
                $properties['Platform_Maker'] = 'Nokia';
            } elseif (($properties['Platform_Name'] == 'Linux' 
                || $properties['Platform_Name'] == 'Debian'
                || $properties['Platform_Name'] == 'CentOS')
                && $properties['Device_isMobileDevice'] == false
            ) {
                $properties['Device_Name'] = 'Linux Desktop';
                $properties['Device_Maker'] = 'unknown';
                $properties['isMobileDevice'] = false;
                $properties['isTablet'] = false;
                $properties['Device_isMobileDevice'] = false;
                $properties['Device_isTablet'] = false;
                $properties['Device_isDesktop'] = true;
                $properties['Device_isTv'] = false;
            } elseif ($properties['Platform_Name'] == 'Linux' 
                && $properties['Device_isMobileDevice'] == true
            ) {
                $properties['isMobileDevice'] = true;
                $properties['Device_isMobileDevice'] = true;
                $properties['Device_isDesktop'] = false;
                $properties['Device_isTv'] = false;
                $properties['Platform'] = 'Linux Smartphone OS';
                $properties['Platform_Name'] = 'Linux Smartphone OS';
            } elseif ($properties['Platform_Name'] == 'Macintosh' 
                || $properties['Platform_Name'] == 'MacOSX' 
                || $properties['Platform_Name'] == 'Darwin'
                || $properties['Platform_Name'] == 'Mac68K'
            ) {
                $properties['Device_Name'] = 'Macintosh';
                $properties['Device_Maker'] = 'Apple';
                $properties['isMobileDevice'] = false;
                $properties['isTablet'] = false;
                $properties['Device_isMobileDevice'] = false;
                $properties['Device_isTablet'] = false;
                $properties['Device_isDesktop'] = true;
                $properties['Device_isTv'] = false;
                $properties['Platform_Maker'] = 'Apple';
            } elseif (($properties['Platform_Name'] == 'iOS'
                || $properties['Device_Name'] == 'iPhone'
                || $properties['Device_Name'] == 'iPod')
                && $properties['Device_Name'] != 'iPad'
            ) {
                $properties['Device_Maker'] = 'Apple';
                $properties['isMobileDevice'] = true;
                $properties['isTablet'] = false;
                $properties['Device_isMobileDevice'] = true;
                $properties['Device_isTablet'] = false;
                $properties['Device_isDesktop'] = false;
                $properties['Device_isTv'] = false;
                $properties['Platform_Maker'] = 'Apple';
            } elseif ($properties['Device_Name'] == 'iPad') {
                $properties['Device_Maker'] = 'Apple';
                $properties['isMobileDevice'] = true;
                $properties['isTablet'] = true;
                $properties['Device_isMobileDevice'] = true;
                $properties['Device_isTablet'] = true;
                $properties['Device_isDesktop'] = false;
                $properties['Device_isTv'] = false;
                $properties['Platform_Maker'] = 'Apple';
            } elseif ($properties['Platform_Name'] == 'BeOS') {
                $properties['Device_Name'] = 'General Desktop';
                $properties['Device_Maker'] = 'unknown';
                $properties['isMobileDevice'] = false;
                $properties['isTablet'] = false;
                $properties['Device_isMobileDevice'] = false;
                $properties['Device_isTablet'] = false;
                $properties['Device_isDesktop'] = true;
                $properties['Device_isTv'] = false;
                $properties['Platform_Maker'] = 'Access';
            } elseif ($properties['Platform_Name'] == 'AIX') {
                $properties['Device_Name'] = 'General Desktop';
                $properties['Device_Maker'] = 'IBM';
                $properties['isMobileDevice'] = false;
                $properties['isTablet'] = false;
                $properties['Device_isMobileDevice'] = false;
                $properties['Device_isTablet'] = false;
                $properties['Device_isDesktop'] = true;
                $properties['Device_isTv'] = false;
                $properties['Platform_Maker'] = 'IBM';
            } elseif ($properties['Platform_Name'] == 'Digital Unix' 
                || $properties['Platform_Name'] == 'Tru64 UNIX'
            ) {
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
            } elseif ($properties['Platform_Name'] == 'HPUX' 
                || $properties['Platform_Name'] == 'OpenVMS'
            ) {
                $properties['Device_Name'] = 'General Desktop';
                $properties['Device_Maker'] = 'HP';
                $properties['isMobileDevice'] = false;
                $properties['isTablet'] = false;
                $properties['Device_isMobileDevice'] = false;
                $properties['Device_isTablet'] = false;
                $properties['Device_isDesktop'] = true;
                $properties['Device_isTv'] = false;
                $properties['Platform_Maker'] = 'HP';
            } elseif ($properties['Platform_Name'] == 'IRIX') {
                $properties['Device_Name'] = 'General Desktop';
                $properties['Device_Maker'] = 'SGI';
                $properties['isMobileDevice'] = false;
                $properties['isTablet'] = false;
                $properties['Device_isMobileDevice'] = false;
                $properties['Device_isTablet'] = false;
                $properties['Device_isDesktop'] = true;
                $properties['Device_isTv'] = false;
                $properties['Platform_Maker'] = 'SGI';
            } elseif ($properties['Platform_Name'] == 'Solaris' 
                || $properties['Platform_Name'] == 'SunOS'
            ) {
                $properties['Device_Name'] = 'General Desktop';
                $properties['Device_Maker'] = 'Oracle';
                $properties['isMobileDevice'] = false;
                $properties['isTablet'] = false;
                $properties['Device_isMobileDevice'] = false;
                $properties['Device_isTablet'] = false;
                $properties['Device_isDesktop'] = true;
                $properties['Device_isTv'] = false;
                $properties['Platform_Maker'] = 'Oracle';
            } elseif ($properties['Platform_Name'] == 'OS/2') {
                $properties['Device_Name'] = 'General Desktop';
                $properties['isMobileDevice'] = false;
                $properties['isTablet'] = false;
                $properties['Device_isMobileDevice'] = false;
                $properties['Device_isTablet'] = false;
                $properties['Device_isDesktop'] = true;
                $properties['Device_isTv'] = false;
                $properties['Platform_Maker'] = 'IBM';
            } elseif ($properties['Platform_Name'] == 'Android' 
                || $properties['Platform_Name'] == 'Dalvik'
            ) {
                $properties['isMobileDevice'] = true;
                $properties['Device_isMobileDevice'] = true;
                $properties['Device_isDesktop'] = false;
                $properties['Device_isTv'] = false;
                $properties['Platform_Maker'] = 'Google';
            } elseif ($properties['Platform_Name'] == 'FreeBSD' 
                || $properties['Platform_Name'] == 'NetBSD' 
                || $properties['Platform_Name'] == 'OpenBSD' 
                || $properties['Platform_Name'] == 'RISC OS' 
                || $properties['Platform_Name'] == 'Unix'
            ) {
                $properties['Device_Name'] = 'General Desktop';
                $properties['isMobileDevice'] = false;
                $properties['isTablet'] = false;
                $properties['Device_isMobileDevice'] = false;
                $properties['Device_isTablet'] = false;
                $properties['Device_isDesktop'] = true;
                $properties['Device_isTv'] = false;
            } elseif ($properties['Platform_Name'] == 'WebTV') {
                $properties['Device_Name'] = 'General TV Device';
                $properties['Device_Maker'] = 'unknown';
                $properties['isMobileDevice'] = false;
                $properties['isTablet'] = false;
                $properties['Device_isMobileDevice'] = false;
                $properties['Device_isTablet'] = false;
                $properties['Device_isDesktop'] = false;
                $properties['Device_isTv'] = true;
                $properties['Platform_Maker'] = 'unknown';
            } elseif ($properties['Platform_Name'] == 'ChromeOS') {
                $properties['Device_Name'] = 'General Desktop';
                $properties['isMobileDevice'] = false;
                $properties['isTablet'] = false;
                $properties['Device_isMobileDevice'] = false;
                $properties['Device_isTablet'] = false;
                $properties['Device_isDesktop'] = true;
                $properties['Device_isTv'] = false;
                $properties['Platform_Maker'] = 'Google';
            }
            
            $this->_browsers[$key] = $properties;
        }
        
        $allBrowsers = array();
        
        foreach ($this->_browsers as $key => $properties) {
            $allBrowsers[$this->_userAgents[$key]] = array($key, $properties);
        }
        
        //sort
        $sort1 = array();
        $sort2 = array();
        
        foreach ($allBrowsers as $title => $data) {
            $x = 0;
            
            $key        = $data[0];
            $properties = $data[1];
            
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
            $sort1[$title] = $x;
            $sort2[$title] = $key;
        }
        
        array_multisort($sort1, SORT_ASC, $sort2, SORT_ASC, $allBrowsers);
        /**/
        
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
                    //var_dump($key, $properties['Parent'], $agentsToFind[$properties['Parent']], $this->_browsers[$agentsToFind[$properties['Parent']]]);exit;
                    
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
            
            if (false === strpos($title, '*') 
                && false === strpos($title, '?')
                && ('DefaultProperties' == $title
                || 'DefaultProperties' == $properties['Parent']
                )
            ) {
                $output .= ';;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;' . "\n" . '; ' . $title . "\n" . ';;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;' . "\n\n";
            }
            
            $output .= '[' . $title . ']' . "\n";
            
            foreach ($this->_properties as $property) {
                if (!isset($propertiesToOutput[$property])) {
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
}