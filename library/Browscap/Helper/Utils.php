<?php
namespace Browscap\Helper;

/**
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
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */
/**
 * WURFL user agent hander utilities
 * @package   Browscap
 */
final class Utils
{
    /**
     * @var string the user agent to handle
     */
    private $_useragent = '';
    
    /**
     * sets the user agent to be handled
     *
     * @return void
     */
    public function setUserAgent($userAgent)
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
        'folio100',
        'gingerbread',
        'hd_mini_t',
        'hp-tablet',
        'hpwOS',
        'htc',
        'ipad',
        'iphone',
        'iphoneosx',
        'iphone os',
        'ipod',
        'iris',
        'iuc(u;ios',
        'j2me',
        'juc(linux;u;',
        'kindle',
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
        'playstation',
        'pocket pc',
        'pocketpc',
        'rim tablet',
        'samsung',
        'series40',
        'series 60',
        'silk',
        'symbian',
        'symbianos',
        'symbos',
        'toshiba_ac_and_az',
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
        'xda_diamond_2',
        'zunewp7'
    );
    
    private $_bots = array(
        '<',
        '>',
        '\\x01',
        'acoon',
        'anyevent',
        'appengine-google',
        'ask.com',
        'bing',
        'bot',
        'catalog',
        'check_http',
        'clecko',
        'compatible; googletoolbar',
        'crawl',
        //'curl',
        'detection',
        //'download',
        'extract',
        'ezooms',
        'facebookexternalhit',
        'feedparser',
        'feed parser',
        'feedfetcher-google',
        'findlinks',
        'firefox/99',
        'generator',
        'gomezagent',
        'google',
        'grabber',
        'heritrix',
        'http_client',
        'httpclient',
        'httrack',
        'jig browser',
        'juc (linux; u; ',
        'libwww',
        'linkchecker',
        'mediapartners-google',
        'nagios',
        'naver',
        'nutch',
        'opera/9.751',
        'ossproxy',
        'parser',
        'presto/951',
        'retriever',
        'secmon',
        'siteinfo',
        'skymonk',
        'slurp',
        'smartlinksaddon',
        'snap',
        'spider',
        'stats',
        //'svn',
        'test-acceptance',
        'ua:',
        'unister-test',
        'user-agent: ',
        'www.auto.de', 
        'auto.de',
        //'w3m',
        'www.kredit.de', 
        'www.geld.de', 
        'www.versicherungen.de', 
        'insurance.preisvergleich.de', 
        'finanzen.shopping.de',
        'webcapture',
        'webu',
        'wget',
        'wordpress',
        'www.yahoo.com',
        'xxx',
        'yandex',
        'zend_http_client',
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
            $noBots = array(
                'xbox', 'badab', 'badap', 'simbar',
                'google wireless transcoder', 'google-tr', 'googlet', 
                'google page speed'
            );
            
            if ($this->checkIfContains($noBots, true)) {
                return false;
            }
            
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
        
        if ($this->checkIfContains('Windows NT 6.2; ARM;')) {
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
            if ($this->checkIfContains(array('google earth', 'google desktop'), true)) {
                return false;
            }
            
            return true;
        }
        
        if ($this->checkIfContains('search', true)
            && !$this->checkIfContains(array('searchtoolbar', 'searchalot ie'), true)
        ) {
            return true;
        }
        
        if ($this->checkIfContains('http', true)
            && $this->checkIfContains('request', true)
        ) {
            return true;
        }
        
        if ($this->checkIfContains('curl', true)
            && !$this->checkIfContains('boxee', true)
        ) {
            return true;
        }
        
        if ($this->checkIfStartsWith('Java/')) {
            return true;
        }
        
        if ('Mozilla/4.0 (compatible;)' === $this->_useragent) {
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
        if ($this->checkIfStartsWith(array('ie', 'msie', 'internet explorer', 'firefox', 'mozillafirefox', 'flock', 'konqueror', 'seamonkey', 'chrome'), true)) {
            return true;
        }
        
        if ($this->checkIfContains(array('mac; mac os ', 'fake', 'linux; unix os', '000000000;', 'google chrome'), true)) {
            return true;
        }
        
        if ($this->checkIfContains(array('internet explorer', 'blah'), true)
            && !$this->checkIfContains(array('internet explorer anonymized by'), true)
        ) {
            return true;
        }
        
        if (!$this->checkIfStartsWith('Mozilla/') // regular IE
            && !$this->checkIfStartsWith('Outlook-Express/') // Windows Live Mail
            && !$this->checkIfContains('Windows CE') // Windows CE
            && $this->checkIfContains('MSIE')
        ) {
            return true;
        }
        
        if ($this->checkIfContains('Gecko') 
            && !$this->checkIfContains(array('like gecko', 'ubuntu'), true) 
            && $this->checkIfContains(array('chrome', 'safari', 'internet explorer'), true)
        ) {
            return true;
        }
        
        if ($this->isFakeWindows()) {
            return true;
        }
        
        if ($this->checkIfContains('HTTrack')) {
            return false;
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
        
        if ($this->checkIfStartsWith(array('ua:'))) {
            return true;
        }
        
        return false;
    }
    
    public function isSafari()
    {
        if (!$this->checkIfStartsWith('Mozilla/')
            && !$this->checkIfStartsWith('Safari')
            && !$this->checkIfStartsWith('MobileSafari')
        ) {
            return false;
        }
        
        if (!$this->checkIfContains(array('Safari', 'AppleWebKit', 'CFNetwork'))) {
            return false;
        }
        
        $isNotReallyAnSafari = array(
            // using also the KHTML rendering engine
            '1Password',
            'AdobeAIR',
            'Arora',
            'BlackBerry',
            'BrowserNG',
            'Chrome',
            'Chromium',
            'Dolfin',
            'Dreamweaver',
            'Epiphany',
            'Flock',
            'Galeon',
            'Google Earth',
            'iCab',
            'Iron',
            'konqueror',
            'Lunascape',
            'Maemo',
            'Midori',
            'MQQBrowser',
            'NokiaBrowser',
            'OmniWeb',
            'PaleMoon',
            'PhantomJS',
            'Qt',
            'rekonq',
            'Rockmelt',
            'Silk',
            'Shiira',
            'WebBrowser',
            'WeTab',
            'wOSBrowser',
            //mobile Version
            //'Mobile',
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
        
        if ($this->checkIfContains(array('PLAYSTATION', 'Browser/AppleWebKit', 'CFNetwork', 'BlackBerry; U; BlackBerry'))) {
            return false;
        }
        
        return true;
    }
    
    public function isWindows()
    {
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
        
        $windows = array(
            'win8', 'win7', 'winvista', 'winxp', 'win2000', 'win98', 'win95',
            'winnt', 'win31', 'winme', 'windows nt', 'windows 98', 'windows 95',
            'windows 3.1', 'win9x/nt 4.90', 'windows xp', 'windows me', 
            'windows'
        );
        
        $ntVersions = array('4.0', '4.1', '5.0', '5.01', '5.1', '5.2', '5.3', '6.0', '6.1', '6.2');
        
        if (!$this->checkIfContains($windows, true)
            && !$this->checkIfContains(array('trident', 'Microsoft', 'outlook', 'msoffice', 'ms-office'), true)
        ) {
            return false;
        }
        
        if ($this->checkIfContains('trident', true)
            && !$this->checkIfContains($windows, true)
        ) {
            return false;
        }
        
        return true;
    }
    
    public function isTvDevice()
    {
        $tvDevices = array(
            'boxee',
            'ce-html',
            'dlink.dsm380',
            'googletv',
            'hbbtv',
            'idl-6651n',
            'kdl40ex720',
            'netrangemmh',
            'loewe; sl121',
            'loewe; sl150',
            'smart-tv',
            'sonydtv115',
            'viera',
            'xbox'
        );
        
        if ($this->checkIfContains($tvDevices, true)) {
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
        
        $ntVersions = array(
            '4.0', '4.1', '5.0', '5.01', '5.1', '5.2', '5.3', '6.0', '6.1', 
            '6.2'
        );
        
        $doMatch = preg_match('/Windows NT ([\d\.]+)/', $this->_useragent, $matches);
        if ($doMatch) {
            if (!$this->checkIfContains('linux', true) 
                && in_array($matches[1], $ntVersions)
            ) {
                return false;
            }
            
            return true;
        }
        
        $doMatch = preg_match('/windows nt ([\d\.]+)/i', $this->_useragent, $matches);
        if ($doMatch) {
            return true;
        }
        
        if ($this->checkIfStartsWith('Mozilla/') 
            && $this->checkIfContains('MSIE')
        ) {
            $doMatch = preg_match('/Mozilla\/(2|3|4|5)\.0 \(.*MSIE (3|4|5|6|7|8|9|10)\.\d.*/', $this->_useragent, $matches);
            if (!$doMatch) {
                return true;
            }
        }
        
        if ($this->checkIfContains('X11; MSIE')) {
            return true;
        }
        
        $doMatch = preg_match('/MSIE ([\d\.]+)/', $this->_useragent, $matches);
        if ($doMatch) {
            $versions = explode('.', $matches[1]);
            
            if ($versions[0] >= 6 && $versions[1] > 0) {
                return true;
            }
        }
        
        return false;
    }
    
    public function isMobileWindows()
    {
        $mobileWindows = array(
            'windows ce', 'windows phone', 'windows mobile', 
            'microsoft windows; ppc', 'iemobile', 'xblwp7', 'zunewp7',
            'windowsmobile'
        );
        
        if (!$this->checkIfContains($mobileWindows, true)) {
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
    
    /**
     * maps different Safari Versions to a normalized format
     *
     * @return string
     */
    public function mapSafariVersions($detectedVersion)
    {
        if ($detectedVersion >= 8500) {
            return '6.0';
        }
        
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