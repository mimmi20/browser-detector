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

namespace BrowserDetector\Detector\Factory;

use BrowserDetector\Detector\Browser\A6Indexer;
use BrowserDetector\Detector\Browser\AbontiBot;
use BrowserDetector\Detector\Browser\AcoonBot;
use BrowserDetector\Detector\Browser\AdbeatBot;
use BrowserDetector\Detector\Browser\Adidxbot;
use BrowserDetector\Detector\Browser\AdMuncher;
use BrowserDetector\Detector\Browser\AdobeAIR;
use BrowserDetector\Detector\Browser\AdvancedEmailExtractor;
use BrowserDetector\Detector\Browser\AhrefsBot;
use BrowserDetector\Detector\Browser\AiHitBot;
use BrowserDetector\Detector\Browser\Airmail;
use BrowserDetector\Detector\Browser\Akregator;
use BrowserDetector\Detector\Browser\Alcatel;
use BrowserDetector\Detector\Browser\AlcoholSearch;
use BrowserDetector\Detector\Browser\Amigo;
use BrowserDetector\Detector\Browser\AndroidWebView;
use BrowserDetector\Detector\Browser\Argclrint;
use BrowserDetector\Detector\Browser\Arora;
use BrowserDetector\Detector\Browser\Avant;
use BrowserDetector\Detector\Browser\BingPreview;
use BrowserDetector\Detector\Browser\Blackberry;
use BrowserDetector\Detector\Browser\Bot360;
use BrowserDetector\Detector\Browser\Camino;
use BrowserDetector\Detector\Browser\Chrome;
use BrowserDetector\Detector\Browser\Chromium;
use BrowserDetector\Detector\Browser\CometBird;
use BrowserDetector\Detector\Browser\CommonCrawl;
use BrowserDetector\Detector\Browser\ComodoDragon;
use BrowserDetector\Detector\Browser\ComodoIceDragon;
use BrowserDetector\Detector\Browser\CoolNovo;
use BrowserDetector\Detector\Browser\CrazyBrowser;
use BrowserDetector\Detector\Browser\CrystalSemanticsBot;
use BrowserDetector\Detector\Browser\DeepnetExplorer;
use BrowserDetector\Detector\Browser\Epiphany;
use BrowserDetector\Detector\Browser\Fennec;
use BrowserDetector\Detector\Browser\Firebird;
use BrowserDetector\Detector\Browser\Firefox;
use BrowserDetector\Detector\Browser\Flock;
use BrowserDetector\Detector\Browser\Galeon;
use BrowserDetector\Detector\Browser\GomezAgent;
use BrowserDetector\Detector\Browser\GoogleEarth;
use BrowserDetector\Detector\Browser\GoogleImageProxy;
use BrowserDetector\Detector\Browser\GooglePageSpeed;
use BrowserDetector\Detector\Browser\GooglePageSpeedInsights;
use BrowserDetector\Detector\Browser\GoogleWebPreview;
use BrowserDetector\Detector\Browser\GoogleWebSnippet;
use BrowserDetector\Detector\Browser\GoogleWirelessTranscoder;
use BrowserDetector\Detector\Browser\HubSpotWebcrawler;
use BrowserDetector\Detector\Browser\Iceape;
use BrowserDetector\Detector\Browser\IceCat;
use BrowserDetector\Detector\Browser\Icedove;
use BrowserDetector\Detector\Browser\Iceowl;
use BrowserDetector\Detector\Browser\Iceweasel;
use BrowserDetector\Detector\Browser\InettvBrowser;
use BrowserDetector\Detector\Browser\Iron;
use BrowserDetector\Detector\Browser\Kmeleon;
use BrowserDetector\Detector\Browser\Linguatools;
use BrowserDetector\Detector\Browser\Lunascape;
use BrowserDetector\Detector\Browser\MaemoBrowser;
use BrowserDetector\Detector\Browser\Maxthon;
use BrowserDetector\Detector\Browser\MicrosoftEdge;
use BrowserDetector\Detector\Browser\MicrosoftInternetExplorer;
use BrowserDetector\Detector\Browser\MicrosoftMobileExplorer;
use BrowserDetector\Detector\Browser\MicrosoftOffice;
use BrowserDetector\Detector\Browser\MicrosoftOutlook;
use BrowserDetector\Detector\Browser\MqqBrowser;
use BrowserDetector\Detector\Browser\MsieCrawler;
use BrowserDetector\Detector\Browser\NetscapeNavigator;
use BrowserDetector\Detector\Browser\Nutch;
use BrowserDetector\Detector\Browser\Opera;
use BrowserDetector\Detector\Browser\OperaMini;
use BrowserDetector\Detector\Browser\OperaMobile;
use BrowserDetector\Detector\Browser\PagePeeker;
use BrowserDetector\Detector\Browser\Palemoon;
use BrowserDetector\Detector\Browser\Seamonkey;
use BrowserDetector\Detector\Browser\Silk;
use BrowserDetector\Detector\Browser\SlimBrowser;
use BrowserDetector\Detector\Browser\Spinn3r;
use BrowserDetector\Detector\Browser\TagInspectorBot;
use BrowserDetector\Detector\Browser\TenFourFox;
use BrowserDetector\Detector\Browser\Ucweb;
use BrowserDetector\Detector\Browser\UnisterTesting;
use BrowserDetector\Detector\Browser\UnknownBrowser;
use BrowserDetector\Detector\Browser\WaterFox;
use BrowserDetector\Detector\Browser\WebtvMsntv;
use BrowserDetector\Detector\Browser\YaBrowser;
use BrowserDetector\Detector\Browser\YahooSlurp;
use BrowserDetector\Detector\Version;
use BrowserDetector\Helper\MobileDevice;
use BrowserDetector\Helper\SpamCrawlerFake;
use BrowserDetector\Helper\Utils;

/**
 * Browser detection class
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class BrowserFactory
{
    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @param string $agent
     *
     * @return \BrowserDetector\Detector\MatcherInterface\BrowserInterface
     */
    public static function detectEngine($agent)
    {
        $utils = new Utils();
        $utils->setUserAgent($agent);

        if ($utils->checkIfContains(array('ucweb', 'uc browser', 'ucbrowser'), true)) {
            return new Ucweb();
        }

        if ($utils->checkIfContains(array('maxthon', 'myie', 'mxbrowser'), true)) {
            return new Maxthon();
        }

        if ($utils->checkIfContains(array('Lunascape', 'iLunascape'))) {
            return new Lunascape();
        }

        if ($utils->checkIfContains(array('Opera Mini', 'OPiOS'))) {
            return new OperaMini();
        }

        $mobileDeviceHelper = new MobileDevice();
        $mobileDeviceHelper->setUserAgent($agent);

        if ($utils->checkIfContains(array('Opera Mobi', 'Opera Tablet'))
            || ($mobileDeviceHelper->isMobile() && $utils->checkIfContains(array('Opera', 'OPR')))
        ) {
            return new OperaMobile();
        }

        if ($utils->checkIfContains('InettvBrowser')) {
            return new InettvBrowser();
        }

        if ($utils->checkIfContains(array('Opera', 'OPR'))) {
            return new Opera();
        }

        if ($utils->checkIfContainsAll(array('PaleMoon'))) {
            return new Palemoon();
        }

        if ($utils->checkIfContainsAll(array('Flock'))) {
            return new Flock();
        }

        if ($utils->checkIfContainsAll(array('ArgClrInt'))) {
            return new Argclrint();
        }

        if ($utils->checkIfContains(array('Outlook'))) {
            return new MicrosoftOutlook();
        }

        if ($utils->checkIfContains(array('microsoft Office', 'MSOffice'))) {
            return new MicrosoftOffice();
        }

        if ($utils->checkIfContains('MQQBrowser')) {
            return new MqqBrowser();
        }

        if ($utils->checkIfContains(array('BlackBerry', 'Blackberry', 'BB10'))) {
            return new Blackberry();
        }

        if ($utils->checkIfContains(array('WebTV/'))) {
            return new WebtvMsntv();
        }

        if ($utils->checkIfContains(array('Edge'))) {
            return new MicrosoftEdge();
        }

        if ($utils->checkIfContains(array('360Spider'))) {
            return new Bot360();
        }

        if ($utils->checkIfContains(array('BingPreview/'))) {
            return new BingPreview();
        }

        if ($utils->checkIfContains(array('SlimBrowser'))) {
            return new SlimBrowser();
        }

        if ($utils->checkIfContains(array('Crazy Browser'))) {
            return new CrazyBrowser();
        }

        if ($utils->checkIfContains('avant', true)) {
            return new Avant();
        }

        if ($utils->checkIfContains(array('GomezAgent'))) {
            return new GomezAgent();
        }

        if ($utils->checkIfContains('Deepnet Explorer')) {
            return new DeepnetExplorer();
        }

        if ($utils->checkIfContainsAll(array('Galeon'))) {
            return new Galeon();
        }

        if ($utils->checkIfContains('CrystalSemanticsBot')) {
            return new CrystalSemanticsBot();
        }

        if ($utils->checkIfContains(array('MSIECrawler', 'Crawler; MSIE'))) {
            return new MsieCrawler();
        }

        if (!$utils->checkIfStartsWith('IE')) {
            if ($utils->checkIfContains(array('IEMobile', 'Windows CE', 'MSIE', 'WPDesktop', 'XBLWP7', 'ZuneWP7'))) {
                return new MicrosoftMobileExplorer();
            }

            if ($utils->checkIfContains(array('MSIE', 'Trident'))
                || $utils->checkIfContainsAll(array('like Gecko', 'rv:11.0'))
            ) {
                return new MicrosoftInternetExplorer();
            }
        }

        if ($utils->checkIfContainsAll(array('AppleWebKit', 'Arora'))) {
            return new Arora();
        }

        if ($utils->checkIfContainsAll(array('applewebkit', 'chromium'), true)) {
            return new Chromium();
        }

        if ($utils->checkIfContains(array('Comodo Dragon', 'Dragon'))) {
            return new ComodoDragon();
        }

        if ($utils->checkIfContains(array('Google Earth'))) {
            return new GoogleEarth();
        }

        if ($utils->checkIfContains('iron', true)) {
            return new Iron();
        }

        if ($utils->checkIfContains('Silk')) {
            return new Silk();
        }

        if ($utils->checkIfContains(array('YaBrowser'))) {
            return new YaBrowser();
        }

        if ($utils->checkIfContains(array('amigo'), true)) {
            return new Amigo();
        }

        if ($utils->checkIfContainsAll(array('CoolNovo'))) {
            return new CoolNovo();
        }

        if ($utils->checkIfContains(array('PagePeeker'))) {
            return new PagePeeker();
        }

        if ($utils->checkIfContains('Google Web Preview')) {
            return new GoogleWebPreview();
        }

        if ($utils->checkIfContains('Google Wireless Transcoder')) {
            return new GoogleWirelessTranscoder();
        }

        if ($utils->checkIfContains('Google Page Speed Insights')) {
            return new GooglePageSpeedInsights();
        }

        if ($utils->checkIfContains('Google Page Speed')) {
            return new GooglePageSpeed();
        }

        if ($utils->checkIfContains(array('HubSpot Webcrawler'))) {
            return new HubSpotWebcrawler();
        }

        if ($utils->checkIfContains(array('TagInspector'))) {
            return new TagInspectorBot();
        }

        if ($utils->checkIfContainsAll(array('Version', 'Chrome'))) {
            return new AndroidWebView();
        }

        $detector = new Version();
        $detector->setUserAgent($agent);
        $detector->detectVersion(array('Chrome'));

        if ($utils->checkIfContains(array('Chrome')) && 0 != $detector->getVersion(Version::MINORONLY)) {
            return new ComodoDragon();
        }

        if ($utils->checkIfContains(array('Chrome', 'CrMo', 'CriOS'))) {
            return new Chrome();
        }

        if ($utils->checkIfContains('Fennec')) {
            return new Fennec();
        }

        if ($utils->checkIfContains('seamonkey', true)) {
            return new Seamonkey();
        }

        if ($utils->checkIfContains('Navigator')) {
            return new NetscapeNavigator();
        }

        if ($utils->checkIfContainsAll(array('Camino', 'Gecko'))) {
            return new Camino();
        }

        if ($utils->checkIfContainsAll(array('Gecko', 'Maemo'))) {
            return new MaemoBrowser();
        }

        if ($utils->checkIfContainsAll(array('CometBird'))) {
            return new CometBird();
        }

        if ($utils->checkIfContains('Epiphany')) {
            return new Epiphany();
        }

        if ($utils->checkIfContainsAll(array('IceCat', 'Gecko'))) {
            return new IceCat();
        }

        if ($utils->checkIfContains(array('unistertesting', 'unister-test', 'unister-https-test'), true)) {
            return new UnisterTesting();
        }

        if ($utils->checkIfContainsAll(array('Iceweasel', 'Gecko'))) {
            return new Iceweasel();
        }

        if ($utils->checkIfContainsAll(array('Iceowl', 'Gecko'))) {
            return new Iceowl();
        }

        if ($utils->checkIfContainsAll(array('Icedove', 'Gecko'))) {
            return new Icedove();
        }

        if ($utils->checkIfContainsAll(array('Iceape', 'Gecko'))) {
            return new Iceape();
        }

        if ($utils->checkIfContains(array('Firebird'))) {
            return new Firebird();
        }

        if ($utils->checkIfContainsAll(array('Gecko', 'Firefox', 'IceDragon'))) {
            return new ComodoIceDragon();
        }

        if ($utils->checkIfContains('TenFourFox')) {
            return new TenFourFox();
        }

        if ($utils->checkIfContains('waterfox', true)) {
            return new WaterFox();
        }

        if ($utils->checkIfContains('K-Meleon')) {
            return new Kmeleon();
        }

        if ($utils->checkIfContains('developers.google.com/+/web/snippet/', true)) {
            return new GoogleWebSnippet();
        }

        if ($utils->checkIfContains(array('linguatools'))) {
            return new Linguatools();
        }

        if ($utils->checkIfContains('commoncrawl')) {
            return new CommonCrawl();
        }

        if ($utils->checkIfContains(array('Nutch'))) {
            return new Nutch();
        }

        if ($utils->checkIfContains('GoogleImageProxy')) {
            return new GoogleImageProxy();
        }

        if ($utils->checkIfContains(array('Spinn3r'))) {
            return new Spinn3r();
        }

        if ($utils->checkIfContains('Yahoo! Slurp')) {
            return new YahooSlurp();
        }

        if ($utils->checkIfContains(array('adbeat.com', 'adbeat_bot'))) {
            return new AdbeatBot();
        }

        $spamHelper = new SpamCrawlerFake();
        $spamHelper->setUserAgent($agent);

        $firefoxCodes = array(
            'Firefox',
            'Minefield',
            'Nightly',
            'Shiretoko',
            'BonEcho',
            'Namoroka',
        );

        if ($utils->checkIfContains($firefoxCodes) && !$spamHelper->isAnonymized()) {
            return new Firefox();
        }

        if ($utils->checkIfContains('A6-Indexer')) {
            return new A6Indexer();
        }

        if ($utils->checkIfContains(array('Abonti'))) {
            return new AbontiBot();
        }

        if ($utils->checkIfContains('AcoonBot')) {
            return new AcoonBot();
        }

        if ($utils->checkIfContains(array('adidxbot'))) {
            return new Adidxbot();
        }

        if ($utils->checkIfContains('Ad Muncher')) {
            return new AdMuncher();
        }

        if ($utils->checkIfContains('AdobeAIR')) {
            return new AdobeAIR();
        }

        if ($utils->checkIfContains('Advanced Email Extractor')) {
            return new AdvancedEmailExtractor();
        }

        if ($utils->checkIfContains('AhrefsBot')) {
            return new AhrefsBot();
        }

        if ($utils->checkIfContains('aiHitBot')) {
            return new AiHitBot();
        }

        if ($utils->checkIfContains(array('Airmail'))) {
            return new Airmail();
        }

        if ($utils->checkIfContains('Akregator')) {
            return new Akregator();
        }

        if ($utils->checkIfContains('Alcatel', true)) {
            return new Alcatel();
        }

        if ($utils->checkIfContains('Alcohol Search')) {
            return new AlcoholSearch();
        }

        return new UnknownBrowser();
    }
}
