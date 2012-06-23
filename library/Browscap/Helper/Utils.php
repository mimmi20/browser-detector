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
        'firefox or ie',
        'foma',
        'htc',
        'ipad',
        'iphone',
        'iphoneosx',
        'iphone os',
        'ipod',
        'iris',
        'j2me',
        'like mac os x',
        'look-alike',
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
        'ppc',
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
        '<',
        '>',
        '\\x',
        'acoon',
        'anyevent',
        'appengine-google',
        'bot',
        'catalog',
        'clecko',
        'crawl',
        'curl',
        'detection',
        'download',
        'extract',
        'feedparser',
        'feed parser',
        'feedfetcher-google',
        'findlinks',
        'gecko/17',
        'gecko/6',
        'generator',
        'grabber',
        'heritrix',
        'httrack',
        'java/',
        'jig browser',
        'linkchecker',
        'nutch',
        'opera/9.751',
        'parser',
        'presto/951',
        'retriever',
        'secmon',
        'siteinfo',
        'skymonk',
        'smartlinksaddon',
        'snap',
        'spider',
        'stats',
        'svn',
        'test-acceptance',
        'unister-test',
        'webu',
        'wordpress',
        'www.yahoo.com',
        'xxx',
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
        
        if ($this->checkIfContains($userAgent, 'search', true)
            && !$this->checkIfContains($userAgent, 'searchtoolbar', true)
        ) {
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
        if ($this->checkIfContainsAnyOf($userAgent, array('internet explorer', 'blah'), true)) {
            return true;
        }
        
        if ($this->checkIfStartsWithAnyOf($userAgent, array('ie', 'msie', 'internet explorer', 'firefox', 'mozillafirefox', 'flock', 'konqueror', 'seamonkey', 'chrome'), true)) {
            return true;
        }
        
        if (!$this->checkIfStartsWith($userAgent, 'Mozilla/') // regular IE
            && !$this->checkIfStartsWith($userAgent, 'Outlook-Express/') // Windows Live Mail
            && $this->checkIfContains($userAgent, 'MSIE')
        ) {
            return true;
        }
        
        if ($this->checkIfContains($userAgent, 'Gecko') 
            && !$this->checkIfContains($userAgent, 'like Gecko') 
            && $this->checkIfContainsAnyOf($userAgent, array('opera', 'chrome', 'safari', 'internet explorer'), true)
        ) {
            return true;
        }
        
        if ($this->checkIfContainsAnyOf($userAgent, array('mac; mac os ', 'fake', 'linux; unix os', '000000000;', 'google chrome'), true)) {
            return true;
        }
        
        if ($this->isFakeWindows($userAgent)) {
            return true;
        }
        
        $doMatch = preg_match('/^Mozilla\/(\d+)\.(\d+)/', $userAgent, $matches);
        
        if ($doMatch) {
            if ($matches[2]) {
                return true;
            }
            
            if (4 > $matches[1] || $matches[1] >= 6) {
                return true;
            }
        }
        
        return false;
    }
    
    public function isSafari($userAgent)
    {
        if (!$this->checkIfStartsWith($userAgent, 'Mozilla/')
            && !$this->checkIfStartsWith($userAgent, 'Safari')
        ) {
            return false;
        }
        
        if (!$this->checkIfContainsAnyOf($userAgent, array('Safari', 'AppleWebKit', 'CFNetwork'))) {
            return false;
        }
        
        $isNotReallyAnSafari = array(
            // using also the KHTML rendering engine
            'Arora',
            'Chrome',
            'Chromium',
            'Flock',
            'Galeon',
            'Lunascape',
            'Iron',
            'Maemo',
            'PaleMoon',
            'Rockmelt',
            'rekonq',
            'OmniWeb',
            'Qt',
            'Silk',
            'MQQBrowser',
            'konqueror',
            'Epiphany',
            'Shiira',
            'Midori',
            'BrowserNG',
            'AdobeAIR',
            'Dreamweaver',
            //mobile Version
            'Mobile',
            'Tablet',
            'Android',
            // Fakes
            'Mac; Mac OS '
        );
        
        if ($this->checkIfContainsAnyOf($userAgent, $isNotReallyAnSafari)) {
            return false;
        }
        
        return true;
    }
    
    public function isMobileAsSafari($userAgent)
    {
        if (!$this->isSafari($useragent)) {
            return false;
        }
        
        if (!$this->isMobileBrowser($useragent)) {
            return false;
        }
        
        return true;
    }
    
    public function isWindows($userAgent)
    {
        $windows = array(
            'win8', 'win7', 'winvista', 'winxp', 'win2000', 'win98', 'win95',
            'winnt', 'win31', 'winme', 'windows nt', 'windows 98', 'windows 95',
            'windows 3.1', 'win9x/nt 4.90', 'windows'
        );
        
        $ntVersions = array('4.0', '4.1', '5.0', '5.01', '5.1', '5.2', '5.3', '6.0', '6.1', '6.2');
        
        if (!$this->checkIfContainsAnyOf($userAgent, $windows, true)
            && !$this->checkIfContainsAnyOf($userAgent, array('trident', 'microsoft', 'outlook', 'msoffice', 'ms-office'), true)
        ) {
            return false;
        }
        
        $isNotReallyAWindows = array(
            // other OS and Mobile Windows
            'Linux',
            'Macintosh',
            'Mac OS X',
            'Mobi'
        );
        
        if ($this->checkIfContainsAnyOf($userAgent, $isNotReallyAWindows)
            || $this->isFakeWindows($userAgent)
            || $this->isMobileWindows($userAgent)
        ) {
            return false;
        }
        
        return true;
    }
    
    public function isFakeWindows($userAgent)
    {
        $doMatch = preg_match('/(Win|Windows )(31|3\.1|95|98|ME|2000|XP|2003|Vista|7|8) (\d+\.\d+)/', $userAgent, $matches);
        if ($doMatch) {
            return true;
        }
        
        $ntVersions = array('4.0', '4.1', '5.0', '5.01', '5.1', '5.2', '5.3', '6.0', '6.1', '6.2');
        
        $doMatch = preg_match('/Windows NT (\d+\.\d+)/', $userAgent, $matches);
        if ($doMatch) {
            if (in_array($matches[1], $ntVersions)) {
                return false;
            }
            
            return true;
        }
        
        return false;
    }
    
    public function isMobileWindows($userAgent)
    {
        $mobileWindows = array(
            'Windows CE', 'Windows Phone OS', 'Windows Mobile', 
            'Microsoft Windows; PPC', 'IEMobile'
        );
        
        if (!$this->checkIfContainsAnyOf($userAgent, $mobileWindows)) {
            return false;
        }
        
        $isNotReallyAWindows = array(
            // other OS
            'Linux'
            'Macintosh',
            'Mac OS X',
        );
        
        if ($this->checkIfContainsAnyOf($userAgent, $isNotReallyAWindows)) {
            return false;
        }
        
        return true;
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