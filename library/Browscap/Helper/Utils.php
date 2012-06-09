<?php
namespace Browscap\Helper;

/**
 * Copyright (c) 2012 ScientiaMobile, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or(at your option) any later version.
 *
 * Refer to the COPYING.txt file distributed with this package.
 *
 *
 * @category   WURFL
 * @package    WURFL
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id$
 */
/**
 * WURFL user agent hander utilities
 * @package    WURFL
 */
class Utils
{
    /**
     * @var array Collection of mobile browser keywords
     */
    private $_mobileBrowsers = array(
        'android',
        'aspen simulator',
        'bada',
        'blackberry',
        'blazer',
        'bolt',
        'brew',
        'cldc',
        'dalvik',
        'danger hiptop',
        'embider',
        'fennec',
        'foma',
        'ipad',
        'iphone',
        'iphoneosx',
        'iphone os',
        'ipod',
        'iris',
        'j2me',
        'like mac os x',
        'maemo',
        'meego',
        'midp',
        'mobile',
        'netfront',
        'nintendo wii',
        'nitro',
        'nokia',
        'obigo',
        'openwave',
        'opera mini',
        'opera mobi',
        'palm',
        'phone',
        'pocket pc',
        'pocketpc',
        'rim tablet',
        'series40',
        'series 60',
        'sony',
        'symbian',
        'symbianos',
        'symbos',
        'up.browser',
        'up.link',
        'wap2',
        'webos',
        'windows ce',
        'windows mobile',
        'windows phone os',
        'wireless',
        '160x160',
        '480x640'
    );
    
    private $_bots = array(
        'acoon', 
        'appengine-google',
        'bot',
        'crawl',
        'curl',
        'extract',
        'feedparser',
        'feedfetcher-google',
        'grabber',
        //'http:',
        'java/',
        'jig browser',
        'retriever',
        'secmon',
        'smartlinksaddon',
        'spider',
        'stats',
        'svn',
        'webu',
        'wordpress',
        'www.yahoo.com',
        'zmeu'
    );
    
    /**
     * Returns true if the give $userAgent is from a mobile device
     * @param string $userAgent
     * @return bool
     */
    public function isMobileBrowser($userAgent)
    {
        if ($this->checkIfContainsAnyOf($userAgent, $this->_mobileBrowsers, true)) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Returns true if the give $userAgent is from a spam bot or crawler
     * @param string $userAgent
     * @return bool
     */
    public function isSpamOrCrawler($userAgent)
    {
        if ($this->checkIfContainsAnyOf($userAgent, $this->_bots, true)) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Returns true if the give $userAgent is from a spam bot or crawler
     * @param string $userAgent
     * @return bool
     */
    public function isFakeBrowser($userAgent)
    {
        if ($this->checkIfContainsAnyOf($userAgent, array('internet explorer/'), true)) {
            return true;
        }
        
        if ($this->checkIfStartsWithAnyOf($userAgent, array('ie', 'msie', 'internet explorer', 'firefox', 'mozillafirefox', 'flock', 'konqueror', 'seamonkey'), true)) {
            return true;
        }
        
        if (!$this->checkIfStartsWith($userAgent, 'Mozilla/') // regular IE
            && !$this->checkIfStartsWith($userAgent, 'Outlook-Express/') // Windows Live Mail
            && $this->checkIfContains($userAgent, 'MSIE')
        ) {
            return true;
        }
        
        if ($this->checkIfContainsAnyOf($userAgent, array('Mac; Mac OS ', 'fake', 'Linux; Unix OS', '000000000'))) {
            return true;
        }
        
        $doMatch = preg_match('/^Mozilla\/(\d+)\.(\d+)/', $userAgent, $matches);
        
        if ($doMatch) {
            if ($matches[2]) {
                return true;
            }
            
            if (4 > $matches[1] || $matches[1] > 6) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Returns true if $haystack contains $needle
     * @param string $haystack Haystack
     * @param string $needle Needle
     * @return bool
     */
    public function checkIfContains($haystack, $needle, $ci = false)
    {
        if ($ci) {
            return stripos($haystack, $needle) !== false;
        }
        
        return strpos($haystack, $needle) !== false;
    }
    
    /**
     * Returns true if $haystack contains any of the(string)needles in $needles
     * @param string $haystack Haystack
     * @param array $needles Array of(string)needles
     * @return bool
     */
    public function checkIfContainsAnyOf($haystack, $needles, $ci = false)
    {
        foreach ($needles as $needle) {
            if ($this->checkIfContains($haystack, $needle, $ci)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Returns true if $haystack contains all of the(string)needles in $needles
     * @param string $haystack Haystack
     * @param array $needles Array of(string)needles
     * @return bool
     */
    public function checkIfContainsAll($haystack, array $needles = array(), $ci = false)
    {
        foreach ($needles as $needle) {
            if (!$this->checkIfContains($haystack, $needle, $ci)) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Returns true if $haystack starts with $needle
     * @param string $haystack Haystack
     * @param string $needle Needle
     * @return bool
     */
    public function checkIfStartsWith($haystack, $needle, $ci = false) 
    {
        if ($ci) {
            return stripos($haystack, $needle) === 0;
        }
        
        return strpos($haystack, $needle) === 0;
    }
    
    /**
     * Returns true if $haystack starts with any of the $needles
     * @param string $haystack Haystack
     * @param array $needles Array of(string)needles
     * @return bool
     */
    public function checkIfStartsWithAnyOf($haystack, array $needles = array(), $ci = false) 
    {
        if (is_array($needles)) {
            foreach ($needles as $needle) {
                if ($this->checkIfStartsWith($haystack, $needle, $ci)) {
                    return true;
                }
            }
        }
        
        return false;
    }
    
    public function getClassNameFromFile($filename, $namespace = __NAMESPACE__, $createFullName = true)
    {
        $filename = ltrim($filename, '\\');
        
        if (!$createFullName) {
            return $filename;
        }
        
        return '\\' . $namespace . '\\Handlers\\' . $filename;
    }
    
    public function getClassNameFromDetected($detected, $namespace = __NAMESPACE__)
    {
        $class = $this->getClassNameFromFile($detected, $namespace, false);
        
        $class = strtolower(str_replace(array('-', '_', ' ', '/', '\\'), ' ', $class));
        $class = preg_replace('/[^a-zA-Z ]/', '', $class);
        $class = str_replace(' ', '', ucwords($class));
        
        return '\\' . $namespace . '\\Handlers\\' . $class;
    }
}