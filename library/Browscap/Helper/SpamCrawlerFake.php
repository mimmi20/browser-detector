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
final class SpamCrawlerFake
{
    /**
     * @var string the user agent to handle
     */
    private $_useragent = '';
    
    /**
     * @var \Browscap\Helper\Utils the helper class
     */
    private $utils = null;
    
    /**
     * Class Constructor
     *
     * @return DeviceHandler
     */
    public function __construct()
    {
        $this->utils = new Utils();
    }
    
    /**
     * sets the user agent to be handled
     *
     * @return void
     */
    public function setUserAgent($userAgent)
    {
        $this->_useragent = $userAgent;
        $this->utils->setUserAgent($userAgent);
        
        return $this;
    }
    
    /**
     * Returns true if the give $userAgent is from a spam bot or crawler
     * @param string $userAgent
     * @return bool
     */
    public function isSpamOrCrawler()
    {
        $bots = array(
            '<',
            '>',
            '\\x01',
            '.exe',
            'abonti',
            'acoon',
            'adbeat.com',
            'adsbot-google',
            'anyevent',
            'appengine-google',
            'apple-pubsub',
            'ask.com',
            'bing',
            'bluecoat drtr',
            'bot',
            'camelhttpstream',
            'catalog',
            'check_http',
            'clecko',
            'compatible; googletoolbar',
            'crawl',
            'detection',
            'downloader',
            'elefent',
            'extract',
            'ezooms',
            'facebookexternalhit',
            'facebookplatform',
            'feedparser',
            'feed parser',
            'feedfetcher-google',
            'findlinks',
            'firefox/99',
            'generator',
            'gomezagent',
            'googlebot',
            'google-fontanalysis',
            'google wireless transcoder',
            'grabber',
            'heritrix',
            'http_client',
            'httpclient',
            'httrack',
            'jig browser',
            'larbin',
            'libwww',
            'linkchecker',
            'link-checker',
            'linkdex',
            'link sleuth',
            'mail.ru',
            'mailwalker',
            'mediapartners-google',
            'metauri',
            'nagios',
            'naver',
            'nutch',
            'openvas',
            'openweb',
            'opera/9.751',
            'ossproxy',
            'parser',
            'ping',
            'presto/951',
            'ramblermail',
            'rebelmouse',
            'retriever',
            'secmon',
            'semager',
            'siteexplorer',
            'siteinfo',
            'skymonk',
            'slurp',
            'smartlinksaddon',
            'snap',
            'sniper',
            'space bison',
            'spider',
            'spray-can',
            'squidwall',
            'stats',
            'synapticwalker',
            'test-acceptance',
            'thebat',
            'tlsprober',
            'ua:',
            'unister-test',
            'unwindfetchor',
            'user-agent: ',
            'web walker',
            'wotbox',
            'www.auto.de', 
            'auto.de',
            //'w3m',
            'www.kredit.de', 
            'www.geld.de', 
            'www.versicherungen.de', 
            'insurance.preisvergleich.de', 
            'finanzen.shopping.de',
            'geld_class_service_kfzcomeback',
            'validator',
            'webcapture',
            'webfilter',
            'webu',
            'wget',
            'wordpress',
            'www.yahoo.com',
            'xxx',
            'yahoo pipes',
            'yandex',
            'zend_http_client',
            'zmeu'
        );
        
        if ($this->utils->checkIfContains($bots, true)) {
            $noBot = array(
                'google earth', 'google desktop', 'googletoolbar', 'googlet5',
                'simbar', 'google web preview', 'googletv', 'google_impact',
                'google page speed', 'google-tr', '=google', 'enusbingip'
            );
            
            if ($this->utils->checkIfContains($noBot, true)) {
                return false;
            }
            
            return true;
        }
        
        $searchNoBot = array(
            'searchtoolbar', 'searchalot ie', 'isearch', 'searchbar'
        );
        
        if ($this->utils->checkIfContains('search', true)
            && !$this->utils->checkIfContains($searchNoBot, true)
        ) {
            return true;
        }
        
        if ($this->utils->checkIfContains('http', true)
            && $this->utils->checkIfContains('request', true)
        ) {
            return true;
        }
        
        if ($this->utils->checkIfContains('curl', true)
            && !$this->utils->checkIfContains('boxee', true)
        ) {
            return true;
        }
        
        if ($this->utils->checkIfStartsWith('Java/')) {
            return true;
        }
        
        if ('Mozilla/4.0 (compatible;)' === $this->_useragent
            || 'Mozilla/5.0 (compatible)' === $this->_useragent
        ) {
            return true;
        }
        
        if ($this->utils->checkIfStartsWith(array('PHP/', 'PHP-SOAP/'))) {
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
        if ($this->utils->checkIfContains(array('HTTrack', 'OpenVAS', 'OpenWeb', 'Maxthon'))) {
            return false;
        }
        
        if ($this->utils->checkIfStartsWith(array('ie', 'msie', 'internet explorer', 'firefox', 'mozillafirefox', 'flock', 'konqueror', 'seamonkey', 'chrome'), true)) {
            return true;
        }
        
        if ($this->utils->checkIfContains(array('mac; mac os ', 'fake', 'linux; unix os', '000000000;', 'google chrome', 'ua:', 'user-agent:'), true)) {
            return true;
        }
        
        if ($this->utils->checkIfContains(array('internet explorer', 'blah'), true)
            && !$this->utils->checkIfContains(array('internet explorer anonymized by'), true)
        ) {
            return true;
        }
        
        if (!$this->utils->checkIfStartsWith('Mozilla/') // regular IE
            && !$this->utils->checkIfStartsWith('Outlook-Express/') // Windows Live Mail
            && !$this->utils->checkIfContains('Windows CE') // Windows CE
            && !$this->utils->checkIfContains('Opera') // Opera
            && $this->utils->checkIfContains('MSIE')
        ) {
            return true;
        }
        
        if ($this->utils->checkIfContains('Gecko') 
            && !$this->utils->checkIfContains(array('like gecko', 'ubuntu'), true) 
            && $this->utils->checkIfContains(array('chrome', 'safari', 'internet explorer'), true)
        ) {
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
            
            if (4 > $matches[1] || $matches[1] >= 7) {
                return true;
            }
        }
        
        $doMatch = preg_match('/^Mozilla\/5\.0 \(X11; U; Linux i686; .*; rv:([\d\.]+)\) Gecko\/.* Firefox\/([\d\.]+)/', $this->_useragent, $matches);
        
        if ($doMatch 
            && (float)$matches[2] >= 4 
            && ((float)$matches[1] != (float)$matches[2])
        ) {
            return true;
        }
        
        $doMatch = preg_match('/Presto\/(\d+)\.(\d+)/', $this->_useragent, $matches);
        
        if ($doMatch && $matches[1] > 2) {
            return true;
        }
        
        $doMatch = preg_match('/SeaMonkey\/(\d+)\.(\d+)/', $this->_useragent, $matches);
        
        if ($doMatch && $matches[1] > 2) {
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
            '6.2', '6.3'
        );
        
        $doMatch = preg_match('/Windows NT ([\d\.]+)(;|\))/', $this->_useragent, $matches);
        if ($doMatch) {
            if (!$this->utils->checkIfContains('linux', true) 
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
        
        if ($this->utils->checkIfStartsWith('Mozilla/') 
            && $this->utils->checkIfContains('MSIE')
        ) {
            $doMatch = preg_match('/Mozilla\/(2|3|4|5)\.0 \(.*MSIE (3|4|5|6|7|8|9|10|11)\.\d.*/', $this->_useragent, $matches);
            if (!$doMatch) {
                return true;
            }
        }
        
        if ($this->utils->checkIfContains('X11; MSIE')) {
            return true;
        }
        
        $doMatch = preg_match('/MSIE ([\d\.]+)/', $this->_useragent, $matches);
        if ($doMatch && isset($matches[1])) {
            $versions = explode('.', $matches[1]);
            
            if ($versions[0] >= 6 && $versions[1] > 0) {
                return true;
            }
        }
        
        return false;
    }
}