<?php
/**
 * Copyright (c) 2012-2015, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
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
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Helper;

use BrowserDetector\Detector\Browser\FakeBrowser;
use BrowserDetector\Detector\Factory\BrowserFactory;
use UaHelper\Utils;

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
    private $useragent = '';

    /**
     * @var \UaHelper\Utils the helper class
     */
    private $utils = null;

    /**
     * Class Constructor
     *
     * @param string $useragent
     *
     * @return \BrowserDetector\Helper\SpamCrawlerFake
     */
    public function __construct($useragent)
    {
        $this->utils = new Utils();

        $this->useragent = $useragent;
        $this->utils->setUserAgent($useragent);
    }

    /**
     * Returns true if the given $useragent is from a bot/crawler
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
            'bubing',
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
            'fastprobe',
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
            'google page speed',
            'google wireless transcoder',
            'grabber',
            'gsa/',
            'heritrix',
            'hitleap',
            'http_client',
            'httpclient',
            'http client',
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
            'microsoft office protocol discovery',
            'moozilla',
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
                'simbar', 'googletv', 'google_impact',
                'google-tr', '=google', 'enusbingip',
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

        if ('Mozilla/4.0 (compatible;)' === $this->useragent
            || 'Mozilla/5.0 (compatible)' === $this->useragent
        ) {
            return true;
        }

        if ($this->utils->checkIfStartsWith(array('PHP/', 'PHP-SOAP/'))) {
            return true;
        }

        return false;
    }

    /**
     * Returns true if the given $useragent looks like it was changed to fake other browsers
     *
     * @return bool
     */
    public function isFakeBrowser()
    {
        $browser = BrowserFactory::detect($this->useragent);

        return ($browser instanceof FakeBrowser);
    }

    /**
     * returns true if the given useragent looks like an anonymizer was used to change it
     *
     * @return bool
     */
    public function isAnonymized()
    {
        if ($this->utils->checkIfContains(array('anonymisiert durch', 'anonymized by'), true)) {
            return true;
        }

        return false;
    }

    /**
     * returns true if the given useragent lokks like it was faked to look like an IE
     *
     * @return bool
     */
    public function isFakeIe()
    {
        $doMatch = preg_match('/MSIE (\d+)\.(\d+)/', $this->useragent, $matches);

        if ($doMatch && isset($matches[1])) {
            if ($matches[1] >= 6 && $matches[2] > 0) {
                return true;
            }
        }

        if (preg_match('/CybEye/', $this->useragent)) {
            return false;
        }

        if (preg_match('/trident\/4/i', $this->useragent) && preg_match('/msie (9|10|11)/i', $this->useragent)) {
            return true;
        }

        if (preg_match('/trident\/5/i', $this->useragent) && preg_match('/msie (10|11)/i', $this->useragent)) {
            return true;
        }

        if (preg_match('/trident\/6/i', $this->useragent) && preg_match('/msie 11/i', $this->useragent)) {
            return true;
        }

        if (preg_match('/netscape/i', $this->useragent) && preg_match('/msie/i', $this->useragent)) {
            return true;
        }

        return false;
    }

    /**
     * returns true if the given useragent lokks like it was faked to look like a windows system
     *
     * @return bool
     */
    public function isFakeWindows()
    {
        if (preg_match('/windows nt (7|8|9)/i', $this->useragent)) {
            return true;
        }

        if (preg_match('/(os x \d{3,5}\)|like macos x|like Geccko)/i', $this->useragent)) {
            return true;
        }

        if (preg_match('/(x11; windows)/i', $this->useragent)) {
            return true;
        }

        if (preg_match('/(windows x86\_64|compatible\-|window nt)/i', $this->useragent)) {
            return true;
        }

        if (preg_match('/(app3lewebkit)/i', $this->useragent)) {
            return true;
        }

        if (preg_match('/Mozilla\/(6|7|8|9)/i', $this->useragent)) {
            return true;
        }

        if (preg_match('/Mozilla\/(4|5)\.0(\+|  )/', $this->useragent)) {
            return true;
        }

        if (preg_match('/Mozilla\/(4|5)\.0 \(;;/', $this->useragent)) {
            return true;
        }

        if (preg_match('/Mozilla\/(4|5)\.0 \(\)/', $this->useragent)) {
            return true;
        }

        if (preg_match('/^Mozilla /', $this->useragent)) {
            return true;
        }

        if (preg_match('/Mozilla\/4\.0 \(compatible\;Android\;/', $this->useragent)) {
            return true;
        }

        if (!preg_match('/^\[FBAN/i', $this->useragent) && preg_match('/^(\'|\"|\[|\]|\=|\\\x|%|\(|label\=|intel mac os x|agent\:|chrome)/i', $this->useragent)) {
            return true;
        }

        if (preg_match('/applewebkit\/1\.1/i', $this->useragent)) {
            return true;
        }

        if (preg_match('/(mozila|mozilmozilla|mozzila)/i', $this->useragent)) {
            return true;
        }

        $ntVersions = array(
            '3.5', '4.0', '4.1', '5.0', '5.01', '5.1', '5.2', '5.3', '6.0', '6.1',
            '6.2', '6.3', '6.4', '10.0'
        );

        $doMatch = preg_match('/Windows NT ([\d\.]+)(;| ;|\))/', $this->useragent, $matches)
            || preg_match('/Windows NT ([\d\.]+)$/', $this->useragent, $matches);

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

        $doMatch = preg_match('/windows nt ([\d\.]+)/i', $this->useragent);
        if ($doMatch) {
            return true;
        }

        if ($this->utils->checkIfStartsWith('Mozilla/')
            && $this->utils->checkIfContains('MSIE')
        ) {
            $doMatch = preg_match(
                '/Mozilla\/(2|3|4|5)\.0 \(.*MSIE (3|4|5|6|7|8|9|10|11)\.\d.*/',
                $this->useragent
            );
            if (!$doMatch) {
                return true;
            }
        }

        return false;
    }
}
