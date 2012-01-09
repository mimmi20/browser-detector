<?php
declare(ENCODING = 'utf-8');
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
 * @version   SVN: $Id$
 */

/**
 * Browscap.ini parsing class with caching and update capabilities
 *
 * @category  CreditCalc
 * @package   Browscap
 * @author    Jonathan Stoppani <st.jonathan@gmail.com>
 * @copyright 2007-2010 Unister GmbH
 */
class Browscap
{
    /**
     * Flag to enable only lowercase indexes in the result.
     * The cache has to be rebuilt in order to apply this option.
     *
     * @var bool
     */
    private $_lowercase = false;

    /**
     * Flag to be set to true after loading the cache
     *
     * @var bool
     */
    private $_cache = null;

    /**
     * Where to store the value of the included PHP cache file
     *
     * @var array
     */
    private $_userAgents  = array();
    private $_browsers    = array();
    private $_patterns    = array();
    private $_properties  = array();
    private $_logger      = null;
    private $_config      = null;
    private $_globalCache = null;

    /**
     * Constructor class, checks for the existence of (and loads) the cache and
     * if needed updated the definitions
     *
     * @param array|\Zend\Config\Config       $config
     * @param \Zend\Log\Logger                $log
     * @param array|\Zend\Cache\Frontend\Core $cache
     */
    public function __construct($config = null, $log = null, $cache = null)
    {
        if ($config instanceof \Zend\Config\Config) {
            $config = $config->toArray();
        } elseif (!is_array($config)) {
            $config = array();
        }
        
        $this->_config = $config;
        
        if ($cache instanceof \Zend\Cache\Frontend\Core) {
            $this->_cache = $cache;
        } elseif (!empty($config['cache'])) {
            $cacheConfig = $this->_config['cache'];
            
            $this->_cache = \Zend\Cache\Cache::factory(
                $cacheConfig['frontend'],
                $cacheConfig['backend'],
                $cacheConfig['front'],
                $cacheConfig['back']
            );
        }
        
        // default data file
        $file = __DIR__ . '/data/browscap.ini';
        
        if (isset($config['inifile'])) {
            $file = realpath((string) $config['inifile']);
        }
        
        $this->setLocaleFile($file);

        if ($log instanceof \Zend\Log\Logger) {
            $this->_logger = $log;
        }
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string $sUserAgent   the user agent string
     * @param bool   $bReturnAsArray whether return an array or an object
     *
     * @return stdClas|array the object containing the browsers details.
     *                       Array if $bReturnAsArray is set to true.
     */
    public function getBrowser($sUserAgent = null, $bReturnAsArray = false)
    {
        //echo "\t\t\t\t\t" . 'detecting Browser (Browscap - init): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        // Automatically detect the useragent
        if (empty($sUserAgent) || !is_string($sUserAgent)) {
            $support    = new Support();
            $sUserAgent = $support->getUserAgent();
        }
        //echo "\t\t\t\t\t" . 'detecting Browser (Browscap - get User-Agent): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        $cacheId = 'agent_' . preg_replace('/[^a-zA-Z0-9_]/', '', urlencode($sUserAgent));
        //echo "\t\t\t\t\t" . 'detecting Browser (Browscap - get Cache ID): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        if (!($this->_cache instanceof \Zend\Cache\Frontend\Core) 
            || !$array = $this->_cache->load($cacheId)
        ) {
            //echo "\t\t\t\t\t" . 'detecting Browser (Browscap - not found in Cache): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            $globalCache = $this->_getGlobalCache();
            //echo "\t\t\t\t\t" . 'detecting Browser (Browscap - get Global Cache): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            $browser = array();
            if (isset($globalCache['patterns'])
                && is_array($globalCache['patterns'])
            ) {
                //echo "\t\t\t\t\t" . 'detecting Browser (Browscap - get Pattern): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
                foreach ($globalCache['patterns'] as $key => $pattern) {
                    //echo "\t\t\t\t\t" . 'detecting Browser (Browscap - teste Pattern [' . $pattern . ']): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
                    if (preg_match($pattern, $sUserAgent)) {
                        $browser = array(
                            $sUserAgent, // Original useragent
                            trim(strtolower($pattern), '@'),
                            $globalCache['userAgents'][$key]
                        );

                        $browser = $browser
                                 + $globalCache['browsers'][$key];

                        break;
                    }
                }
            }

            // Add the keys for each property
            $array = array();
            foreach ($browser as $key => $value) {
                $array[$globalCache['properties'][(int)$key]] = $value;
            }

            if ($this->_cache instanceof \Zend\Cache\Frontend\Core) {
                $this->_cache->save($array, $cacheId);
            }
        }

        return $bReturnAsArray ? $array : (object) $array;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string $sUserAgent   the user agent string
     * @param bool   $bReturnAsArray whether return an array or an object
     *
     * @return stdClas|array the object containing the browsers details.
     *                       Array if $bReturnAsArray is set to true.
     */
    private function _getGlobalCache()
    {
        if (null === $this->_globalCache) {
            $cacheGlobalId = 'agentsGlobal';
            //echo "\t\t\t\t\t" . 'detecting Browser (Browscap - get ID of Global Cache): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            // Load the cache at the first request
            if (!($this->_cache instanceof \Zend\Cache\Frontend\Core) 
                || !$this->_globalCache = $this->_cache->load($cacheGlobalId)
            ) {
                //echo "\t\t\t\t\t" . 'detecting Browser (Browscap - GlobalCache not loaded): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
                $this->_globalCache = $this->_getBrowserFromCache();
                //echo "\t\t\t\t\t" . 'detecting Browser (Browscap - GlobalCache loaded): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
                if ($this->_cache instanceof \Zend\Cache\Frontend\Core) {
                    $this->_cache->save($this->_globalCache, $cacheGlobalId);
                }
            }
        }
        
        return $this->_globalCache;
    }
    
    public function getAllBrowsers()
    {
        $globalCache = $this->_getGlobalCache();
        
        if (empty($globalCache)) {
            return null;
        }
        
        $allBrowsers = array();
        
        foreach (array_keys($globalCache['patterns']) as $key) {
            $browser = $globalCache['browsers'][$key];
            $array   = array();
            
            foreach ($browser as $key => $value) {
                $array[$globalCache['properties'][(int)$key]] = $value;
            }
            
            $allBrowsers[] = $array;
        }
        
        return $allBrowsers;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @return array
     */
    private function _getBrowserFromCache()
    {
        try {
            return $this->_updateCache();
        } catch (Exception $e) {
            if ($this->_logger instanceof \Zend\Log\Log) {
                $this->_logger->err($e);
            }

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
        //echo "\t\t\t\t\t" . 'detecting Browser (Browscap - loading ini File - Start): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
            $browsers = parse_ini_file($this->_localFile, true, INI_SCANNER_RAW);
        } else {
            $browsers = parse_ini_file($this->_localFile, true);
        }
        //echo "\t\t\t\t\t" . 'detecting Browser (Browscap - loading ini File - End): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        array_shift($browsers);
        //echo "\t\t\t\t\t" . 'detecting Browser (Browscap - array_shift): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        $this->_properties  = array_keys($browsers['DefaultProperties']);
        array_unshift(
            $this->_properties,
            'browser_name',
            'browser_name_regex',
            'browser_name_pattern',
            'Parent'
        );

        $this->_userAgents  = array_keys($browsers);
        //echo "\t\t\t\t\t" . 'detecting Browser (Browscap - $this->_userAgents): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        usort(
            $this->_userAgents,
            function($a, $b) {
                $a = strlen($a);
                $b = strlen($b);
                return ($a == $b ? 0 :($a < $b ? 1 : -1));
            }
        );

        //$aUserAgentKeys  = array_flip($this->_userAgents);
        $aPropertiesKeys = array_flip($this->_properties);

        foreach ($this->_userAgents as $sUserAgent) {
            //echo "\t\t\t\t\t" . 'detecting Browser (Browscap - parse Agent [' . $sUserAgent . '] - Start): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            $this->_parseAgents(
                $browsers, $sUserAgent, $aPropertiesKeys
            );
            //echo "\t\t\t\t\t" . 'detecting Browser (Browscap - parse Agent [' . $sUserAgent . '] - End): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        }

        // Save the keys lowercased if needed
        if ($this->_lowercase) {
            $this->_properties = array_map('strtolower', $this->_properties);
        }
        //echo "\t\t\t\t\t" . 'detecting Browser (Browscap - $this->_lowercase): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
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
        $browsers, $sUserAgent, $aPropertiesKeys)
    {
        $browser = array();

        $userAgent = $sUserAgent;
        $parents   = array($userAgent);
        //echo "\t\t\t\t\t" . 'detecting Browser (Browscap - search all Parents - Start): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        while (isset($browsers[$userAgent]['Parent'])) {
            //echo "\t\t\t\t\t" . 'detecting Browser (Browscap - search Parent [' . $browsers[$userAgent]['Parent'] . ']): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            $parents[] = $browsers[$userAgent]['Parent'];
            $userAgent = $browsers[$userAgent]['Parent'];
        }
        unset($userAgent);
        //echo "\t\t\t\t\t" . 'detecting Browser (Browscap - search all Parents - End): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
        $parents     = array_reverse($parents);
        $browserData = array();

        foreach ($parents as $parent) {
            //echo "\t\t\t\t\t" . 'detecting Browser (Browscap - merge Parents [' . $parent . ']): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            if (isset($browsers[$parent]) && is_array($browsers[$parent])) {
                $browserData = array_merge($browserData, $browsers[$parent]);
            }
        }

        $search  = array('\*', '\?');
        $replace = array('.*', '.');
        $pattern = preg_quote($sUserAgent, '@');

        $this->_patterns[] = '@'
                           . '^'
                           . str_replace($search, $replace, $pattern)
                           . '$'
                           . '@';

        foreach ($browserData as $key => $value) {
            //echo "\t\t\t\t\t" . 'detecting Browser (Browscap - parse Values [' . $key . ']): ' . (microtime(true) - START_TIME) . ' Sek. ' . number_format(memory_get_usage(true), 0, ',', '.') . ' Bytes' . "\n";
            if (!isset($aPropertiesKeys[$key])) {
                continue;
            }
            
            $key = $aPropertiesKeys[$key];

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

        $this->_browsers[] = $browser;
    }
}