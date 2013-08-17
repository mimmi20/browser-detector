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
use \Browscap\Input\Exception;

/**
 * Browscap.ini parsing class
 *
 * @category  Browscap
 * @package   Browscap
 * @author    Jonathan Stoppani <st.jonathan@gmail.com>
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 */
final class IniHandler implements \Serializable
{
    /**
     * Where to store the value of the included PHP cache file
     *
     * @var array
     */
    private $userAgents    = array();
    private $browsers      = array();
    private $patterns      = array();
    private $properties    = array();
    private $localFile     = null;

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
     * serializes the object
     *
     * @return string
     */
    public function serialize()
    {
        return serialize(
            array(
                'userAgents'    => $this->userAgents,
                'browsers'      => $this->browsers,
                'patterns'      => $this->patterns,
                'properties'    => $this->properties,
                'localFile'     => $this->localFile
            )
        );
    }
    
    /**
     * unserializes the object
     *
     * @param string $data The serialized data
     */
    public function unserialize($data)
    {
        $unseriliazedData = unserialize($data);
        
        $this->userAgents    = $unseriliazedData['userAgents'];
        $this->browsers      = $unseriliazedData['browsers'];
        $this->patterns      = $unseriliazedData['patterns'];
        $this->properties    = $unseriliazedData['properties'];
        $this->localFile     = $unseriliazedData['localFile'];
    }
    /*
    public static function __set_state($an_array)
    {
        $obj = new self;
        $obj->var1 = $an_array['var1'];
        $obj->var2 = $an_array['var2'];
        return $obj;
    }
    /**/

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
    
    /**
     * loads all rules from a local ini file
     */
    public function load()
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
        
        // remove the version info from the browsers array
        array_shift($browsers);
        
        // read the properties
        $this->properties = array_keys($browsers['DefaultProperties']);
        
        array_unshift(
            $this->properties,
            'browser_name',
            'browser_name_regex',
            'browser_name_pattern',
            'Parent',
            'Parents',
            'key'
        );
        
        $this->userAgents = array_keys($browsers);
        
        usort(
            $this->userAgents,
            function($a, $b) {
                $a = strlen($a);
                $b = strlen($b);
                return ($a == $b ? 0 :($a < $b ? 1 : -1));
            }
        );
        
        $this->browsers = $this->expandAgents($browsers);
        
        return $this;
    }
    
    public function getProperties()
    {
        return $this->properties;
    }
    
    public function getUserAgents()
    {
        return $this->userAgents;
    }
    
    public function getBrowsers()
    {
        return $this->browsers;
    }
    
    public function getPattern()
    {
        return $this->patterns;
    }

    /**
     * Parses the user agents
     *
     * @return bool whether the file was correctly written to the disk
     */
    private function expandAgents($browsers)
    {   
        $key         = 0;
        $allBrowsers = array();
        
        foreach ($this->userAgents as $userAgent) {
            $allBrowsers[$key] = $this->parseAgents($browsers, $userAgent, $key);
            ++$key;
        }
        
        return $allBrowsers;
    }

    /**
     * Parses the user agents
     */
    private function parseAgents($browsers, $sUserAgent, $outerKey)
    {
        $browser = array();

        $userAgent = $sUserAgent;
        $parents   = array($userAgent);
        
        while (isset($browsers[$userAgent]['Parent'])) {
            if ($browsers[$userAgent]['Parent'] == $userAgent) {
                throw new Exception('Rule is Parent of itself for rule "' . $userAgent . '"');
            }
            
            $parents[] = $browsers[$userAgent]['Parent'];
            $userAgent = $browsers[$userAgent]['Parent'];
        }
        
        unset($userAgent);
        
        $parents     = array_reverse($parents);
        $browserData = array();

        foreach ($parents as $parent) {
            if (!isset($browsers[$parent])) {
                var_dump('Parent not found for key "' . $sUserAgent . '"');
                continue;
            }
            
            if (!is_array($browsers[$parent])) {
                var_dump('empty Parent found for key "' . $sUserAgent . '"');
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
        
        return $browser;
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