<?php
namespace Browscap;

/**
 * Browscap.ini parsing class with caching and update capabilities
 *
 * PHP version 5
 *
 * LICENSE: This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301 USA
 *
 * @category  CreditCalc
 * @package   Browscap
 * @author    Jonathan Stoppani <st.jonathan@gmail.com>
 * @copyright 2006-2008 Jonathan Stoppani
 * @version    SVN: $Id$
 */

/**
 * Browscap.ini parsing class with caching and update capabilities
 *
 * @category  CreditCalc
 * @package   Browscap
 * @author    Jonathan Stoppani <st.jonathan@gmail.com>
 * @copyright 2007-2010 Unister GmbH
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
        $this->setLocaleFile(__DIR__ . '/data/browscap.ini');
        
        parent::__construct();
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string $userAgent   the user agent string
     * @param bool   $bReturnAsArray whether return an array or an object
     *
     * @return stdClas|array the object containing the browsers details.
     *                       Array if $bReturnAsArray is set to true.
     */
    public function getBrowser($userAgent = null, $forceDetect = false)
    {
        if ('' === $this->_agent 
            && (empty($userAgent) || !is_string($userAgent))
        ) {
            $userAgent = $this->_support->getUserAgent();
        }
        
        if (null !== $userAgent) {
            $this->_agent = $userAgent;
        }
        
        $this->_cleanedAgent = $this->_support->cleanAgent($this->_agent);
            
        if (!$array = $this->_getBrowserFromCache($this->_agent)) {
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

            // Add the keys for each property
            $array = $browser;
            
            if ($this->_cache instanceof \Zend\Cache\Frontend\Core) {
                $cacheId = $this->_getCacheFromAgent($this->_agent);
                
                $this->_cache->save($array, $cacheId);
            }
        }

        return (object) $array;
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
            if (!isset($properties['Version']) || !isset($properties['Browser'])) {
                echo 'attribute not found for key "' . $key . '" and rule "' . $this->_userAgents[$key] . '"' . "\n";
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
                } elseif ($utils->checkIfContains(array('Win', 'WOW64', 'i586', 'i686', 'i386', 'i486', 'i86'))) {
                    // general windows or a 32 bit browser on a 64 bit system (WOW64)
                    $properties['Browser_Bits'] = 32;
                }
            //}
            
            //if ($properties['Platform_Bits'] == 0) {
                if ($utils->checkIfContains(array('x64', 'Win64', 'WOW64', 'x86_64', 'amd64', 'AMD64', 'ppc64'))) {
                    $properties['Platform_Bits'] = 64;
                } elseif ($utils->checkIfContains(array('Win3.1', 'Windows 3.1'))) {
                    $properties['Platform_Bits'] = 16;
                } elseif ($utils->checkIfContains(array('Win', 'i586', 'i686', 'i386', 'i486', 'i86'))) {
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
            
            $this->_browsers[$key] = $properties;
        }
        
        $output = '';
        
        // shrink
        foreach ($this->_browsers as $key => $properties) {
            if (!isset($properties['Version'])) {
                continue;
            }
            
            if (!isset($properties['Parent'])) {
                continue;
            }
            
            $agentsToFind = array_flip($this->_userAgents);
            if (!isset($this->_browsers[$agentsToFind[$properties['Parent']]])) {
                //var_dump($key, $properties['Parent'], $agentsToFind[$properties['Parent']], $this->_browsers[$agentsToFind[$properties['Parent']]]);exit;
                
                continue;
            }
            
            $parent = $this->_browsers[$agentsToFind[$properties['Parent']]];
            
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
            
            $output .= '[' . $this->_userAgents[$key] . ']' . "\n";
            
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
            $this->_log($e, \Zend\Log\Logger::ERR);

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
                $this->_log(
                    '"' . $parent . '" not found in browsers collection',
                    \Zend\Log\Logger::WARN
                );
                
                continue;
            }
            
            if (!is_array($browsers[$parent])) {
                $this->_log(
                    '"' . $parent . '" found in browsers collection, '
                    . 'but the entry is empty',
                    \Zend\Log\Logger::WARN
                );
                
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