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
        'hp-tablet',
        'hpwOS',
        'htc',
        'ipad',
        'iphone',
        'iphoneosx',
        'iphone os',
        'ipod',
        'iris',
        'j2me',
        'lenovo',
        'like mac os x',
        'look-alike',
        'maemo',
        'meego',
        'midp',
        'netfront',
        'nintendo',
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
        'symbian',
        'symbianos',
        'symbos',
        'touchpad',
        'transformer tf',
        'up.browser',
        'up.link',
        'xblwp7',
        'wap2',
        'webos',
        'wetab-browser',
        'windows ce',
        'windows mobile',
        'windows phone os',
        'wireless',
        'zunewp7'
    );
    
    private $_bots = array(
        '<',
        '>',
        //'\\x',
        'acoon',
        'anyevent',
        'appengine-google',
        'bing',
        'bot',
        'catalog',
        'clecko',
        'crawl',
        'curl',
        'detection',
        //'download',
        'extract',
        'feedparser',
        'feed parser',
        'feedfetcher-google',
        'findlinks',
        'firefox/99',
        'gecko/17',
        'gecko/6',
        'generator',
        'gomezagent',
        'grabber',
        'heritrix',
        'httrack',
        'jig browser',
        'linkchecker',
        'naver',
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
        //'svn',
        'test-acceptance',
        'unister-test',
        'webu',
        'wget',
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
        
        if ($this->checkIfContains('tablet', true)
            && !$this->checkIfContains('tablet pc', true)
        ) {
            return true;
        }
        
        if ($this->checkIfContains('mobile', true)
            && !$this->checkIfContains('automobile', true)
        ) {
            return true;
        }
        
        if ($this->checkIfContains('sony', true)
            && !$this->checkIfContains('sonydtv', true)
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
        if ($this->checkIfContains(array('internet explorer', 'blah'), true)
            && !$this->checkIfContains(array('internet explorer anonymized by'), true)
        ) {
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
        
        $doMatch = preg_match('/Presto\/(\d+)\.(\d+)/', $this->_useragent, $matches);
        
        if ($doMatch && $matches[1] > 2) {
            return true;
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
            'iCab',
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
            'Google Earth',
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
    
    public function isTvDevice()
    {
        $tvDevices = array(
            'Loewe; SL121',
            'dlink.dsm380',
            'IDL-6651N',
            'SonyDTV115',
            'SMART-TV'
        );
        
        if ($this->checkIfContains($tvDevices)) {
            return true;
        }
        
        return false;
    }
    
    public function isFakeWindows()
    {
        $doMatch = preg_match('/(Win|Windows )(31|3\.1|95|98|ME|2000|XP|2003|Vista|7|8) ([\d\.]+)/', $this->_useragent, $matches);
        if ($doMatch) {
            return true;
        }
        
        $ntVersions = array('4.0', '4.1', '5.0', '5.01', '5.1', '5.2', '5.3', '6.0', '6.1', '6.2');
        
        $doMatch = preg_match('/Windows NT ([\d\.]+)/', $this->_useragent, $matches);
        if ($doMatch) {
            if (in_array($matches[1], $ntVersions)) {
                return false;
            }
            
            return true;
        }
        
        if ($this->checkIfStartsWith('Mozilla/') 
            && $this->checkIfContains('MSIE')
        ) {
            $doMatch = preg_match('/Mozilla\/(4|5)\.0 \(.*MSIE (4|5|6|7|8|9|10)\.\d.*/', $this->_useragent, $matches);
            if (!$doMatch) {
                return true;
            }
        }
        
        return false;
    }
    
    public function isMobileWindows()
    {
        $mobileWindows = array(
            'Windows CE', 'Windows Phone', 'Windows Mobile', 
            'Microsoft Windows; PPC', 'IEMobile', 'XBLWP7', 'ZuneWP7'
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
    
    /**
     * maps different Safari Versions to a normalized format
     *
     * @return string
     */
    public function mapSafariVersions($detectedVersion)
    {
        if ($detectedVersion >= 7500) {
            return '5.1';
        }
        
        if ($detectedVersion >= 6500) {
            return '5.0';
        }
        
        if ($detectedVersion >= 750) {
            return '5.1';
        }
        
        if ($detectedVersion >= 650) {
            return '5.0';
        }
        
        if ($detectedVersion >= 500) {
            return '4.0';
        }
        
        $regularVersions = array(
            '3.0', '3.1', '3.2', '4.0', '4.1', '5.0', '5.1', '5.2', '6.0'
        );
        
        if (in_array(substr($detectedVersion, 0, 3), $regularVersions)) {
            return $detectedVersion;
        }
        
        return '';
    }
}