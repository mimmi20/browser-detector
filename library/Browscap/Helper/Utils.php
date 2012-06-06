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
    
    /**
     * Returns true if the give $userAgent is from a mobile device
     * @param string $userAgent
     * @return bool
     */
    public function isMobileBrowser($userAgent)
    {
        $mobileBrowser = false;
        
        foreach ($this->_mobileBrowsers as $key) {
            if (stripos($userAgent, $key) !== false) {
                $mobileBrowser = true;
                break;
            }
        }
        
        return $mobileBrowser;
    }
    
    /**
     * Returns true if the give $userAgent is from a spam bot or crawler
     * @param string $userAgent
     * @return bool
     */
    public function isSpamOrCrawler($userAgent)
    {
        $bots = array(
            'AppEngine-Google',
            'bot',
            'spider',
            'crawler',
            'feedparser',
            'Feedfetcher-Google',
            'http:',
            'WebWasher',
            'WordPress'
        );
        
        if ($this->checkIfContainsAnyOfCaseInsensitive($userAgent, $bots)) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Returns true if $haystack contains $needle
     * @param string $haystack Haystack
     * @param string $needle Needle
     * @return bool
     */
    public function checkIfContains($haystack, $needle)
    {
        return strpos($haystack, $needle) !== false;
    }
    
    /**
     * Returns true if $haystack contains any of the(string)needles in $needles
     * @param string $haystack Haystack
     * @param array $needles Array of(string)needles
     * @return bool
     */
    public function checkIfContainsAnyOf($haystack, $needles)
    {
        foreach ($needles as $needle) {
            if ($this->checkIfContains($haystack, $needle)) {
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
    public function checkIfContainsAll($haystack, $needles=array())
    {
        foreach ($needles as $needle) {
            if (!$this->checkIfContains($haystack, $needle)) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Returns true if $haystack contains $needle without regard for case
     * @param string $haystack Haystack
     * @param string $needle Needle
     * @return bool
     */
    public function checkIfContainsCaseInsensitive($haystack, $needle) 
    {
        return stripos($haystack, $needle) !== FALSE;
    }
    
    /**
     * Returns true if $haystack contains any of the(string)needles in $needles
     * @param string $haystack Haystack
     * @param array $needles Array of(string)needles
     * @return bool
     */
    public function checkIfContainsAnyOfCaseInsensitive($haystack, $needles)
    {
        foreach ($needles as $needle) {
            if ($this->checkIfContainsCaseInsensitive($haystack, $needle)) {
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
    public function checkIfContainsAllCaseInsensitive($haystack, $needles=array())
    {
        foreach ($needles as $needle) {
            if (!$this->checkIfContainsCaseInsensitive($haystack, $needle)) {
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
    public function checkIfStartsWith($haystack, $needle) 
    {
        return strpos($haystack, $needle) === 0;
    }
    
    /**
     * Returns true if $haystack starts with any of the $needles
     * @param string $haystack Haystack
     * @param array $needles Array of(string)needles
     * @return bool
     */
    public function checkIfStartsWithAnyOf($haystack, $needles) 
    {
        if (is_array($needles)) {
            foreach ($needles as $needle) {
                if ($this->checkIfStartsWith($haystack, $needle)) {
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