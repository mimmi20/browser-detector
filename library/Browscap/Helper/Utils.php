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
final class Utils
{
    /**
     * @var string the user agent to handle
     */
    private $_useragent = '';
    
    /**
     * @var \Zend\Log\Logger
     */
    private $_logger = null;
    
    /**
     * sets the logger used when errors occur
     *
     * @param \Zend\Log\Logger $logger
     *
     * @return 
     */
    final public function setLogger(\Zend\Log\Logger $logger = null)
    {
        $this->_logger = $logger;
        
        return $this;
    }
    
    /**
     * sets the user agent to be handled
     *
     * @return void
     */
    final public function setUserAgent($userAgent)
    {
        $this->_useragent = $userAgent;
        
        return $this;
    }
    
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
        'gingerbread',
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
        'rim tablet',
        'series40',
        'series 60',
        'silk',
        'sony',
        'symbian',
        'symbianos',
        'symbos',
        'touchpad',
        'up.browser',
        'up.link',
        'wap2',
        'webos',
        'windows ce',
        'windows mobile',
        'windows phone os',
        'wireless'
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
    public function isMobileBrowser()
    {
        if ($this->checkIfContains($this->_mobileBrowsers, true)) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Returns true if the give $userAgent is from a spam bot or crawler
     * @param string $userAgent
     * @return bool
     */
    public function isSpamOrCrawler()
    {
        if ($this->checkIfContains($this->_bots, true)) {
            return true;
        }
        
        if ($this->checkIfContains('search', true)
            && !$this->checkIfContains('searchtoolbar', true)
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
    public function isFakeBrowser()
    {
        if ($this->checkIfContains(array('internet explorer', 'blah'), true)) {
            return true;
        }
        
        if ($this->checkIfStartsWith(array('ie', 'msie', 'internet explorer', 'firefox', 'mozillafirefox', 'flock', 'konqueror', 'seamonkey', 'chrome'), true)) {
            return true;
        }
        
        if (!$this->checkIfStartsWith('Mozilla/') // regular IE
            && !$this->checkIfStartsWith('Outlook-Express/') // Windows Live Mail
            && $this->checkIfContains('MSIE')
        ) {
            return true;
        }
        
        if ($this->checkIfContains('Gecko') 
            && !$this->checkIfContains('like Gecko') 
            && $this->checkIfContains(array('opera', 'chrome', 'safari', 'internet explorer'), true)
        ) {
            return true;
        }
        
        if ($this->checkIfContains(array('mac; mac os ', 'fake', 'linux; unix os', '000000000;', 'google chrome'), true)) {
            return true;
        }
        
        if ($this->isFakeWindows()) {
            return true;
        }
        
        $doMatch = preg_match('/^Mozilla\/(\d+)\.(\d+)/', $this->_useragent, $matches);
        
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
    
    public function isSafari()
    {
        if (!$this->checkIfStartsWith('Mozilla/')
            && !$this->checkIfStartsWith('Safari')
        ) {
            return false;
        }
        
        if (!$this->checkIfContains(array('Safari', 'AppleWebKit', 'CFNetwork'))) {
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
        
        if ($this->checkIfContains($isNotReallyAnSafari)) {
            return false;
        }
        
        return true;
    }
    
    public function isMobileAsSafari()
    {
        if (!$this->isSafari()) {
            return false;
        }
        
        if (!$this->isMobileBrowser()) {
            return false;
        }
        
        return true;
    }
    
    public function isWindows()
    {
        $windows = array(
            'win8', 'win7', 'winvista', 'winxp', 'win2000', 'win98', 'win95',
            'winnt', 'win31', 'winme', 'windows nt', 'windows 98', 'windows 95',
            'windows 3.1', 'win9x/nt 4.90', 'windows xp', 'windows me', 
            'windows'
        );
        
        $ntVersions = array('4.0', '4.1', '5.0', '5.01', '5.1', '5.2', '5.3', '6.0', '6.1', '6.2');
        
        if (!$this->checkIfContains($windows, true)
            && !$this->checkIfContains(array('trident', 'microsoft', 'outlook', 'msoffice', 'ms-office'), true)
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
        
        if ($this->checkIfContains($isNotReallyAWindows)
            || $this->isFakeWindows()
            || $this->isMobileWindows()
        ) {
            return false;
        }
        
        return true;
    }
    
    public function isFakeWindows()
    {
        $doMatch = preg_match('/(Win|Windows )(31|3\.1|95|98|ME|2000|XP|2003|Vista|7|8) (\d+\.\d+)/', $this->_useragent, $matches);
        if ($doMatch) {
            return true;
        }
        
        $ntVersions = array('4.0', '4.1', '5.0', '5.01', '5.1', '5.2', '5.3', '6.0', '6.1', '6.2');
        
        $doMatch = preg_match('/Windows NT (\d+\.\d+)/', $this->_useragent, $matches);
        if ($doMatch) {
            if (in_array($matches[1], $ntVersions)) {
                return false;
            }
            
            return true;
        }
        
        return false;
    }
    
    public function isMobileWindows()
    {
        $mobileWindows = array(
            'Windows CE', 'Windows Phone OS', 'Windows Mobile', 
            'Microsoft Windows; PPC', 'IEMobile'
        );
        
        if (!$this->checkIfContains($mobileWindows)) {
            return false;
        }
        
        $isNotReallyAWindows = array(
            // other OS
            'Linux',
            'Macintosh',
            'Mac OS X',
        );
        
        if ($this->checkIfContains($isNotReallyAWindows)) {
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
    public function checkIfContains($needle, $ci = false)
    {
        if (is_array($needle)) {
            foreach ($needle as $singleneedle) {
                if ($this->checkIfContains($singleneedle, $ci)) {
                    return true;
                }
            }
            
            return false;
        }
        
        if (!is_string($needle)) {
            return false;
        }
        
        if ($ci) {
            return stripos($this->_useragent, $needle) !== false;
        }
        
        return strpos($this->_useragent, $needle) !== false;
    }
    
    /**
     * Returns true if $haystack contains all of the(string)needles in $needles
     * @param string $haystack Haystack
     * @param array $needles Array of(string)needles
     * @return bool
     */
    public function checkIfContainsAll(array $needles = array(), $ci = false)
    {
        foreach ($needles as $needle) {
            if (!$this->checkIfContains($needle, $ci)) {
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
    public function checkIfStartsWith($needle, $ci = false) 
    {
        if (is_array($needle)) {
            foreach ($needle as $singleneedle) {
                if ($this->checkIfStartsWith($singleneedle, $ci)) {
                    return true;
                }
            }
            
            return false;
        }
        
        if (!is_string($needle)) {
            return false;
        }
        
        if ($ci) {
            return stripos($this->_useragent, $needle) === 0;
        }
        
        return strpos($this->_useragent, $needle) === 0;
    }
    
    public function getClassNameFromFile($filename, $namespace = __NAMESPACE__, $createFullName = true)
    {
        $filename = ltrim($filename, '\\');
        
        if (!$createFullName) {
            return $filename;
        }
        
        return '\\' . $namespace . '\\' . $filename;
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