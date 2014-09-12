<?php
/**
 * Copyright (c) 2012-2014, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Helper;

/**
 * a helper to detect bot and fake browsers
 *
 * @package   BrowserDetector
 */
class SpamCrawlerFake
{
    /**
     * @var string the user agent to handle
     */
    private $_useragent = '';

    /**
     * @var \BrowserDetector\Helper\Utils the helper class
     */
    private $utils = null;

    /**
     * Class Constructor
     *
     * @return \BrowserDetector\Helper\SpamCrawlerFake
     */
    public function __construct()
    {
        $this->utils = new Utils();
    }

    /**
     * sets the user agent to be handled
     *
     * @param string $userAgent
     *
     * @return \BrowserDetector\Helper\SpamCrawlerFake
     */
    public function setUserAgent($userAgent)
    {
        $this->_useragent = $userAgent;
        $this->utils->setUserAgent($userAgent);

        return $this;
    }

    /**
     * Returns true if the give $userAgent is from a spam bot or crawler
     *
     * @param string $userAgent
     *
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
            'ad muncher',
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
            'developers.google.com/+/web/snippet/',
            'detection',
            'downloader',
            'elefent',
            'extract',
            'ezooms',
            'facebookexternalhit',
            'facebookplatform',
            'favicon fetcher',
            'feedparser',
            'feed parser',
            'feedfetcher-google',
            'findlinks',
            'firefox/99',
            'generator',
            'gomezagent',
            'googlebot',
            'google-fontanalysis',
            'google web preview',
            'google wireless transcoder',
            'grabber',
            'gsa/',
            'heritrix',
            'hitleap',
            'http_client',
            'httpclient',
            'httrack',
            'indexer',
            'jig browser',
            'larbin',
            'libwww',
            'linkchecker',
            'link-checker',
            'linkdex',
            'link sleuth',
            'macinroy privacy auditors',
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
            'privacy auditors',
            'python',
            'ramblermail',
            'rebelmouse',
            'retriever',
            'scraper',
            'scrapy',
            'scraping',
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
            'unister-https-test',
            'unwindfetchor',
            'user-agent: ',
            'web walker',
            'wotbox',
            'auto.de',
            //'w3m',
            'kredit.de',
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
                'google page speed', 'google-tr', '=google', 'enusbingip',
                'fbmapping', 'yandex.translate', 'yandex browser'
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

        if ($this->utils->checkIfContainsAll(array('http', 'request'), true)) {
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
     *
     * @param string $userAgent
     *
     * @return bool
     */
    public function isFakeBrowser()
    {
        if ($this->utils->checkIfContains(array('HTTrack', 'OpenVAS', 'OpenWeb', 'Maxthon'))) {
            return false;
        }

        if ($this->isAnonymized()) {
            return false;
        }

        if ($this->utils->checkIfStartsWith(
            array(
                'ie', 'msie', 'internet explorer', 'firefox', 'mozillafirefox', 'flock', 'konqueror', 'seamonkey',
                'chrome'
            ), true
        )
        ) {
            return true;
        }

        if ($this->utils->checkIfContains(
            array('mac; mac os ', 'fake', 'linux; unix os', '000000000;', 'google chrome', 'ua:', 'user-agent:'), true
        )
        ) {
            return true;
        }

        if ($this->utils->checkIfContains(array('internet explorer'), true)
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

        if ($this->isFakeWindows() || $this->isFakeIe()) {
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

        $doMatch = preg_match(
            '/^Mozilla\/5\.0 \(X11; U; Linux i686; .*; rv:([\d\.]+)\) Gecko\/.* Firefox\/([\d\.]+)/', $this->_useragent,
            $matches
        );

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

    public function isAnonymized()
    {
        if ($this->utils->checkIfContains(array('anonymisiert durch', 'anonymized by'), true)) {
            return true;
        }

        return false;
    }

    public function isFakeIe()
    {
        $doMatch = preg_match('/MSIE (\d+)\.(\d+)/', $this->_useragent, $matches);

        if ($doMatch && isset($matches[1])) {
            if ($matches[1] >= 6 && $matches[2] > 0) {
                return true;
            }
        }

        return false;
    }

    public function isFakeWindows()
    {
        $doMatch = preg_match(
            '/(Win|Windows )(31|3\.1|95|98|ME|2000|XP|2003|Vista|7|8) ([\d\.]+)/', $this->_useragent, $matches
        );
        if ($doMatch && !$this->utils->checkIfContains('anonym', true)) {
            return true;
        }

        $ntVersions = array(
            '3.5', '4.0', '4.1', '5.0', '5.01', '5.1', '5.2', '5.3', '6.0', '6.1',
            '6.2', '6.3'
        );

        $doMatch = preg_match('/Windows NT ([\d\.]+)(;|\))/', $this->_useragent, $matches)
                || preg_match('/(Win|Windows )(ME|2000|XP|2003|Vista|7|8)/', $this->_useragent, $matches);

        if ($doMatch) {
            if ($this->utils->checkIfContains('anonym', true)) {
                return false;
            }

            if ($this->utils->checkIfContains('linux', true)
                    && !$this->utils->checkIfContains('edition linux mint', true)
            ) {
                return true;
            }

            if (in_array($matches[1], $ntVersions)) {
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
            $doMatch = preg_match(
                '/Mozilla\/(2|3|4|5)\.0 \(.*MSIE (3|4|5|6|7|8|9|10|11)\.\d.*/', $this->_useragent, $matches
            );
            if (!$doMatch) {
                return true;
            }
        }

        if ($this->utils->checkIfContains('X11; MSIE')) {
            return true;
        }

        return false;
    }
}