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

namespace BrowserDetector\Detector\Factory;

use BrowserDetector\Detector\Browser\A6Indexer;
use BrowserDetector\Detector\Browser\AdmantxPlatformSemanticAnalyzer;
use BrowserDetector\Detector\Browser\AhrefsBot;
use BrowserDetector\Detector\Browser\AlltopApp;
use BrowserDetector\Detector\Browser\AndroidWebkit;
use BrowserDetector\Detector\Browser\AndroidWebView;
use BrowserDetector\Detector\Browser\AnotherWebMiningTool;
use BrowserDetector\Detector\Browser\ApacheSynapse;
use BrowserDetector\Detector\Browser\Apercite;
use BrowserDetector\Detector\Browser\ApusBrowser;
use BrowserDetector\Detector\Browser\Arora;
use BrowserDetector\Detector\Browser\Avant;
use BrowserDetector\Detector\Browser\BaiduBrowser;
use BrowserDetector\Detector\Browser\BaiduHdBrowser;
use BrowserDetector\Detector\Browser\BaiduMiniBrowser;
use BrowserDetector\Detector\Browser\Beamrise;
use BrowserDetector\Detector\Browser\Blackberry;
use BrowserDetector\Detector\Browser\BlexBot;
use BrowserDetector\Detector\Browser\BoardReaderFaviconFetcher;
use BrowserDetector\Detector\Browser\BotForJce;
use BrowserDetector\Detector\Browser\CcBot;
use BrowserDetector\Detector\Browser\CheckSiteVerificationAgent;
use BrowserDetector\Detector\Browser\Chedot;
use BrowserDetector\Detector\Browser\Chrome;
use BrowserDetector\Detector\Browser\Chromium;
use BrowserDetector\Detector\Browser\CmBrowser;
use BrowserDetector\Detector\Browser\CocCocBot;
use BrowserDetector\Detector\Browser\CocCocBrowser;
use BrowserDetector\Detector\Browser\ComodoDragon;
use BrowserDetector\Detector\Browser\ContextadBot;
use BrowserDetector\Detector\Browser\CybEye;
use BrowserDetector\Detector\Browser\Dalvik;
use BrowserDetector\Detector\Browser\Daumoa;
use BrowserDetector\Detector\Browser\Diglo;
use BrowserDetector\Detector\Browser\DiscoverEd;
use BrowserDetector\Detector\Browser\Dolfin;
use BrowserDetector\Detector\Browser\DolphinSmalltalkHttpClient;
use BrowserDetector\Detector\Browser\Domnutch;
use BrowserDetector\Detector\Browser\DotBot;
use BrowserDetector\Detector\Browser\DoubanApp;
use BrowserDetector\Detector\Browser\DownloadAccelerator;
use BrowserDetector\Detector\Browser\EasouSpider;
use BrowserDetector\Detector\Browser\Experibot;
use BrowserDetector\Detector\Browser\Ezooms;
use BrowserDetector\Detector\Browser\FacebookApp;
use BrowserDetector\Detector\Browser\FakeBrowser;
use BrowserDetector\Detector\Browser\FeedBlitz;
use BrowserDetector\Detector\Browser\FeeddlerRssReader;
use BrowserDetector\Detector\Browser\Feedly;
use BrowserDetector\Detector\Browser\FeedlyApp;
use BrowserDetector\Detector\Browser\Fennec;
use BrowserDetector\Detector\Browser\FhscanCore;
use BrowserDetector\Detector\Browser\Firefox;
use BrowserDetector\Detector\Browser\Flipboard;
use BrowserDetector\Detector\Browser\FlyFlow;
use BrowserDetector\Detector\Browser\GarlikCrawler;
use BrowserDetector\Detector\Browser\Genderanalyzer;
use BrowserDetector\Detector\Browser\GooBlog;
use BrowserDetector\Detector\Browser\Googlebot;
use BrowserDetector\Detector\Browser\GooglebotMobileBot;
use BrowserDetector\Detector\Browser\GoogleHttpClientLibraryForJava;
use BrowserDetector\Detector\Browser\GoogleImageProxy;
use BrowserDetector\Detector\Browser\GooglePageSpeedInsights;
use BrowserDetector\Detector\Browser\GooglePlus;
use BrowserDetector\Detector\Browser\GoogleStructuredDataTestingTool;
use BrowserDetector\Detector\Browser\GoogleWebSnippet;
use BrowserDetector\Detector\Browser\GoogleWirelessTranscoder;
use BrowserDetector\Detector\Browser\GrapeFx;
use BrowserDetector\Detector\Browser\GrapeshotCrawler;
use BrowserDetector\Detector\Browser\Gvfs;
use BrowserDetector\Detector\Browser\IBrowser;
use BrowserDetector\Detector\Browser\Icab;
use BrowserDetector\Detector\Browser\Integrity;
use BrowserDetector\Detector\Browser\InternetSeer;
use BrowserDetector\Detector\Browser\Iridium;
use BrowserDetector\Detector\Browser\Iron;
use BrowserDetector\Detector\Browser\IstellaBot;
use BrowserDetector\Detector\Browser\KamelioApp;
use BrowserDetector\Detector\Browser\Kazehakase;
use BrowserDetector\Detector\Browser\Konqueror;
use BrowserDetector\Detector\Browser\Kontact;
use BrowserDetector\Detector\Browser\Larbin;
use BrowserDetector\Detector\Browser\Lbot;
use BrowserDetector\Detector\Browser\LightspeedSystemsCrawler;
use BrowserDetector\Detector\Browser\LightspeedSystemsRocketCrawler;
use BrowserDetector\Detector\Browser\LinkdexBot;
use BrowserDetector\Detector\Browser\LoadTimeBot;
use BrowserDetector\Detector\Browser\Luakit;
use BrowserDetector\Detector\Browser\MailRu;
use BrowserDetector\Detector\Browser\Maxthon;
use BrowserDetector\Detector\Browser\MaxthonNitro;
use BrowserDetector\Detector\Browser\MeanpathBot;
use BrowserDetector\Detector\Browser\MetaGeneratorCrawler;
use BrowserDetector\Detector\Browser\MicrosoftInternetExplorer;
use BrowserDetector\Detector\Browser\MicrosoftOffice;
use BrowserDetector\Detector\Browser\MicrosoftWebDav;
use BrowserDetector\Detector\Browser\Midori;
use BrowserDetector\Detector\Browser\MyInternetBrowser;
use BrowserDetector\Detector\Browser\NaverMatome;
use BrowserDetector\Detector\Browser\Nbot;
use BrowserDetector\Detector\Browser\NerdyBot;
use BrowserDetector\Detector\Browser\NetEstateCrawler;
use BrowserDetector\Detector\Browser\Netscape;
use BrowserDetector\Detector\Browser\NikiBot;
use BrowserDetector\Detector\Browser\NokiaBrowser;
use BrowserDetector\Detector\Browser\NokiaProxyBrowser;
use BrowserDetector\Detector\Browser\Obot;
use BrowserDetector\Detector\Browser\Omniweb;
use BrowserDetector\Detector\Browser\OneBrowser;
use BrowserDetector\Detector\Browser\Openwave;
use BrowserDetector\Detector\Browser\Opera;
use BrowserDetector\Detector\Browser\OperaCoast;
use BrowserDetector\Detector\Browser\OperaMini;
use BrowserDetector\Detector\Browser\OperaMobile;
use BrowserDetector\Detector\Browser\Palemoon;
use BrowserDetector\Detector\Browser\PaperLiBot;
use BrowserDetector\Detector\Browser\PeeploScreenshotBot;
use BrowserDetector\Detector\Browser\PhantomJs;
use BrowserDetector\Detector\Browser\Photon;
use BrowserDetector\Detector\Browser\PicmoleBot;
use BrowserDetector\Detector\Browser\PinterestApp;
use BrowserDetector\Detector\Browser\PlaystationBrowser;
use BrowserDetector\Detector\Browser\Polaris;
use BrowserDetector\Detector\Browser\Proximic;
use BrowserDetector\Detector\Browser\Puffin;
use BrowserDetector\Detector\Browser\QqBrowser;
use BrowserDetector\Detector\Browser\Qt;
use BrowserDetector\Detector\Browser\QupZilla;
use BrowserDetector\Detector\Browser\Qword;
use BrowserDetector\Detector\Browser\RankFlex;
use BrowserDetector\Detector\Browser\Rss2Html;
use BrowserDetector\Detector\Browser\Ruby;
use BrowserDetector\Detector\Browser\Safari;
use BrowserDetector\Detector\Browser\SamsungBrowser;
use BrowserDetector\Detector\Browser\SamsungWebView;
use BrowserDetector\Detector\Browser\ScreenerBot;
use BrowserDetector\Detector\Browser\Scrubby;
use BrowserDetector\Detector\Browser\SecurepointContentFilter;
use BrowserDetector\Detector\Browser\SemrushBot;
use BrowserDetector\Detector\Browser\Seoprofiler;
use BrowserDetector\Detector\Browser\SeznamBrowser;
use BrowserDetector\Detector\Browser\Silk;
use BrowserDetector\Detector\Browser\Sistrix;
use BrowserDetector\Detector\Browser\SiteExplorer;
use BrowserDetector\Detector\Browser\SmartViera;
use BrowserDetector\Detector\Browser\SmtBot;
use BrowserDetector\Detector\Browser\Socialradarbot;
use BrowserDetector\Detector\Browser\SogouSpider;
use BrowserDetector\Detector\Browser\SogouWebSpider;
use BrowserDetector\Detector\Browser\Squzer;
use BrowserDetector\Detector\Browser\SuperBird;
use BrowserDetector\Detector\Browser\TelecaObigo;
use BrowserDetector\Detector\Browser\Thunderbird;
use BrowserDetector\Detector\Browser\TinyBrowser;
use BrowserDetector\Detector\Browser\TumblrApp;
use BrowserDetector\Detector\Browser\TwitterApp;
use BrowserDetector\Detector\Browser\Typo3Linkvalidator;
use BrowserDetector\Detector\Browser\UcBrowser;
use BrowserDetector\Detector\Browser\UmBot;
use BrowserDetector\Detector\Browser\UnityWebPlayer;
use BrowserDetector\Detector\Browser\UniversalFeedParser;
use BrowserDetector\Detector\Browser\UnknownBrowser;
use BrowserDetector\Detector\Browser\VisionUtils;
use BrowserDetector\Detector\Browser\W3cI18nChecker;
use BrowserDetector\Detector\Browser\W3cUnicorn;
use BrowserDetector\Detector\Browser\W3cValidatorNuLv;
use BrowserDetector\Detector\Browser\WaterFox;
use BrowserDetector\Detector\Browser\WbSearchBot;
use BrowserDetector\Detector\Browser\WebkitWebos;
use BrowserDetector\Detector\Browser\WebmasterCoffee;
use BrowserDetector\Detector\Browser\WeseeSearch;
use BrowserDetector\Detector\Browser\WhiteHatAviator;
use BrowserDetector\Detector\Browser\WooRank;
use BrowserDetector\Detector\Browser\XingContenttabreceiver;
use BrowserDetector\Detector\Browser\XmlSitemapsGenerator;
use BrowserDetector\Detector\Browser\YaBrowser;
use BrowserDetector\Detector\Browser\YahooSlingstone;
use BrowserDetector\Detector\Browser\YahooSlurp;
use BrowserDetector\Detector\Browser\ZmEu;
use BrowserDetector\Detector\Browser\ZollardWorm;
use Psr\Log\LoggerInterface;
use WurflCache\Adapter\AdapterInterface;
use UaMatcher\Os\OsInterface;

/**
 * Browser detection class
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class BrowserFactory
{
    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @param string                               $agent
     * @param \UaMatcher\Os\OsInterface            $platform
     * @param \Psr\Log\LoggerInterface             $logger
     * @param \WurflCache\Adapter\AdapterInterface $cache
     *
     * @return \BrowserDetector\Detector\Browser\AbstractBrowser
     */
    public static function detect($agent, OsInterface $platform, LoggerInterface $logger, AdapterInterface $cache = null)
    {
        if (preg_match('/windows nt (7|8|9)/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/(khtml like gecko)/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/(os x \d{4,5}\))/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/(x11; windows)/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/(windows x86\_64)/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/(app3lewebkit)/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/Mozilla\/(6|7|8|9)/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif ((false !== strpos($agent, 'OPR') && false !== strpos($agent, 'Android'))
            || (false !== strpos($agent, 'Opera Mobi'))
        ) {
            $browser = new OperaMobile($agent, $logger);
        } elseif (preg_match('/(ucbrowser|uc browser|ucweb)/i', $agent)) {
            $browser = new UcBrowser($agent, $logger);
        } elseif (preg_match('/(opera mini)/i', $agent)) {
            $browser = new OperaMini($agent, $logger);
        } elseif (preg_match('/(opera|opr)/i', $agent)) {
            $browser = new Opera($agent, $logger);
        } elseif (false !== strpos($agent, 'iCab')) {
            $browser = new Icab($agent, $logger);
        } elseif (false !== strpos($agent, 'PhantomJS')) {
            $browser = new PhantomJs($agent, $logger);
        } elseif (false !== strpos($agent, 'YaBrowser')) {
            $browser = new YaBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'Kamelio')) {
            $browser = new KamelioApp($agent, $logger);
        } elseif (false !== strpos($agent, 'FBAV')) {
            $browser = new FacebookApp($agent, $logger);
        } elseif (false !== strpos($agent, 'ACHEETAHI')) {
            $browser = new CmBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'bdbrowser_i18n')) {
            $browser = new BaiduBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'bdbrowserhd_i18n')) {
            $browser = new BaiduHdBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'bdbrowser_mini')) {
            $browser = new BaiduMiniBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'Puffin')) {
            $browser = new Puffin($agent, $logger);
        } elseif (false !== strpos($agent, 'SamsungBrowser')) {
            $browser = new SamsungBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'Silk')) {
            $browser = new Silk($agent, $logger);
        } elseif (false !== strpos($agent, 'coc_coc_browser')) {
            $browser = new CocCocBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'NaverMatome')) {
            $browser = new NaverMatome($agent, $logger);
        } elseif (false !== strpos($agent, 'Flipboard')) {
            $browser = new Flipboard($agent, $logger);
        } elseif (false !== strpos($agent, 'Seznam.cz')) {
            $browser = new SeznamBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'Aviator')) {
            $browser = new WhiteHatAviator($agent, $logger);
        } elseif (false !== strpos($agent, 'Dragon')) {
            $browser = new ComodoDragon($agent, $logger);
        } elseif (false !== strpos($agent, 'Beamrise')) {
            $browser = new Beamrise($agent, $logger);
        } elseif (false !== strpos($agent, 'Diglo')) {
            $browser = new Diglo($agent, $logger);
        } elseif (false !== strpos($agent, 'APUSBrowser')) {
            $browser = new ApusBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'Chedot')) {
            $browser = new Chedot($agent, $logger);
        } elseif (false !== strpos($agent, 'Qword')) {
            $browser = new Qword($agent, $logger);
        } elseif (false !== strpos($agent, 'Iridium')) {
            $browser = new Iridium($agent, $logger);
        } elseif (preg_match('/avant/i', $agent)) {
            $browser = new Avant($agent, $logger);
        } elseif (false !== strpos($agent, 'MxNitro')) {
            $browser = new MaxthonNitro($agent, $logger);
        } elseif (preg_match('/(mxbrowser|maxthon|myie)/i', $agent)) {
            $browser = new Maxthon($agent, $logger);
        } elseif (preg_match('/(superbird)/i', $agent)) {
            $browser = new SuperBird($agent, $logger);
        } elseif (false !== strpos($agent, 'TinyBrowser')) {
            $browser = new TinyBrowser($agent, $logger);
        } elseif (false !== strpos($agent, 'Chrome') && false !== strpos($agent, 'Version')) {
            $browser = new AndroidWebView($agent, $logger);
        } elseif (false !== strpos($agent, 'Safari')
            && false !== strpos($agent, 'Version')
            && false !== strpos($agent, 'Tizen')
        ) {
            $browser = new SamsungWebView($agent, $logger);
        } elseif (preg_match('/(cybeye)/i', $agent)) {
            $browser = new CybEye($agent, $logger);
        } elseif (!preg_match('/trident/i', $agent) && preg_match('/msie (8|9|10|11)/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/trident\/4/i', $agent) && preg_match('/msie (9|10|11)/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/trident\/5/i', $agent) && preg_match('/msie (10|11)/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/trident\/6/i', $agent) && preg_match('/msie 11/i', $agent)) {
            $browser = new FakeBrowser($agent, $logger);
        } elseif (preg_match('/LSSRocketCrawler/', $agent)) {
            $browser = new LightspeedSystemsRocketCrawler($agent, $logger);
        } elseif (preg_match('/lightspeedsystems/i', $agent)) {
            $browser = new LightspeedSystemsCrawler($agent, $logger);
        } elseif (preg_match('/Mozilla\/5\.0.*\(.*Trident\/7\.0.*rv\:11\.0.*\) like Gecko.*/', $agent)
            || preg_match('/Mozilla\/5\.0.*\(.*MSIE 10\.0.*Trident\/6\.0.*/', $agent)
            || preg_match('/Mozilla\/(4|5)\.0.*\(.*MSIE (9|8)\.0.*/', $agent)
            || preg_match('/Mozilla\/(4|5)\.0.*\(.*MSIE (7|6)\.0.*/', $agent)
            || preg_match('/Mozilla\/(4|5)\.0.*\(.*MSIE (5|4)\.\d+.*/', $agent)
            || preg_match('/Mozilla\/\d\.\d+.*\(.*MSIE (3|2|1)\.\d+.*/', $agent)
        ) {
            $browser = new MicrosoftInternetExplorer($agent, $logger);
        } elseif (false !== strpos($agent, 'Chromium')) {
            $browser = new Chromium($agent, $logger);
        } elseif (false !== strpos($agent, 'Iron')) {
            $browser = new Iron($agent, $logger);
        } elseif (preg_match('/(midori)/i', $agent)) {
            $browser = new Midori($agent, $logger);
        } elseif (preg_match('/(Google Page Speed Insights)/', $agent)) {
            $browser = new GooglePageSpeedInsights($agent, $logger);
        } elseif (preg_match('/(GoogleImageProxy)/', $agent)) {
            $browser = new GoogleImageProxy($agent, $logger);
        } elseif (preg_match('/(web\/snippet)/', $agent)) {
            $browser = new GoogleWebSnippet($agent, $logger);
        } elseif (preg_match('/(googlebot\-mobile)/i', $agent)) {
            $browser = new GooglebotMobileBot($agent, $logger);
        } elseif (preg_match('/(Google Wireless Transcoder)/', $agent)) {
            $browser = new GoogleWirelessTranscoder($agent, $logger);
        } elseif (preg_match('/(googlebot)/i', $agent)) {
            $browser = new Googlebot($agent, $logger);
        } elseif (preg_match('/(viera)/i', $agent)) {
            $browser = new SmartViera($agent, $logger);
        } elseif (preg_match('/(chrome|crmo|crios)/i', $agent)) {
            $browser = new Chrome($agent, $logger);
        } elseif (preg_match('/(flyflow)/i', $agent)) {
            $browser = new FlyFlow($agent, $logger);
        } elseif (preg_match('/(dolphin http client)/i', $agent)) {
            $browser = new DolphinSmalltalkHttpClient($agent, $logger);
        } elseif (preg_match('/(dolphin|dolfin)/i', $agent)) {
            $browser = new Dolfin($agent, $logger);
        } elseif (preg_match('/(MQQBrowser)/', $agent)) {
            $browser = new QqBrowser($agent, $logger);
        } elseif (preg_match('/(Arora)/', $agent)) {
            $browser = new Arora($agent, $logger);
        } elseif (preg_match('/(com\.douban\.group)/i', $agent)) {
            $browser = new DoubanApp($agent, $logger);
        } elseif (preg_match('/(com\.google\.GooglePlus)/i', $agent)) {
            $browser = new GooglePlus($agent, $logger);
        }  elseif (preg_match('/(ovibrowser)/i', $agent)) {
            $browser = new NokiaProxyBrowser($agent, $logger);
        }elseif (preg_match('/(ibrowser)/i', $agent)) {
            $browser = new IBrowser($agent, $logger);
        } elseif (preg_match('/(OneBrowser)/', $agent)) {
            $browser = new OneBrowser($agent, $logger);
        } elseif (preg_match('/(linux; u; android|linux; android)/i', $agent) && preg_match('/(version)/i', $agent)) {
            $browser = new AndroidWebkit($agent, $logger);
        } elseif (preg_match('/(safari)/i', $agent) && 'Android' === $platform->getName()) {
            $browser = new AndroidWebkit($agent, $logger);
        } elseif (preg_match('/(Browser\/AppleWebKit)/', $agent)) {
            $browser = new AndroidWebkit($agent, $logger);
        } elseif (false !== strpos($agent, 'BlackBerry') && false !== strpos($agent, 'Version')) {
            $browser = new Blackberry($agent, $logger);
        } elseif (preg_match('/(webOS|wOSBrowser|wOSSystem)/', $agent)) {
            $browser = new WebkitWebos($agent, $logger);
        } elseif (preg_match('/(OmniWeb)/', $agent)) {
            $browser = new Omniweb($agent, $logger);
        } elseif (preg_match('/(nokia)/i', $agent)) {
            $browser = new NokiaBrowser($agent, $logger);
        } elseif (preg_match('/(coast)/i', $agent)) {
            $browser = new OperaCoast($agent, $logger);
        } elseif (preg_match('/(twitter for i)/i', $agent)) {
            $browser = new TwitterApp($agent, $logger);
        } elseif (preg_match('/(safari)/i', $agent)) {
            $browser = new Safari($agent, $logger);
        } elseif (preg_match('/(PaleMoon)/', $agent)) {
            $browser = new Palemoon($agent, $logger);
        } elseif (preg_match('/(waterfox)/i', $agent)) {
            $browser = new WaterFox($agent, $logger);
        } elseif (preg_match('/(QupZilla)/', $agent)) {
            $browser = new QupZilla($agent, $logger);
        } elseif (preg_match('/(Thunderbird)/', $agent)) {
            $browser = new Thunderbird($agent, $logger);
        } elseif (preg_match('/(kontact)/', $agent)) {
            $browser = new Kontact($agent, $logger);
        } elseif (preg_match('/(Fennec)/', $agent)) {
            $browser = new Fennec($agent, $logger);
        } elseif (preg_match('/(myibrow)/', $agent)) {
            $browser = new MyInternetBrowser($agent, $logger);
        } elseif (preg_match('/(Daumoa)/', $agent)) {
            $browser = new Daumoa($agent, $logger);
        } elseif (preg_match('/(PaleMoon)/', $agent)) {
            $browser = new Palemoon($agent, $logger);
        } elseif (preg_match('/(firefox|minefield|shiretoko|bonecho|namoroka|fxios)/i', $agent)) {
            $browser = new Firefox($agent, $logger);
        } elseif (preg_match('/(SMTBot)/', $agent)) {
            $browser = new SmtBot($agent, $logger);
        } elseif (preg_match('/(gvfs)/', $agent)) {
            $browser = new Gvfs($agent, $logger);
        } elseif (preg_match('/(luakit)/', $agent)) {
            $browser = new Luakit($agent, $logger);
        } elseif (preg_match('/(playstation 3)/i', $agent)) {
            $browser = new PlaystationBrowser($agent, $logger);
        } elseif (preg_match('/(sistrix crawler)/i', $agent)) {
            $browser = new Sistrix($agent, $logger);
        } elseif (preg_match('/(ezooms)/i', $agent)) {
            $browser = new Ezooms($agent, $logger);
        } elseif (preg_match('/(backberry|bb10)/i', $agent)) {
            $browser = new Blackberry($agent, $logger);
        } elseif (preg_match('/(grapefx)/i', $agent)) {
            $browser = new GrapeFx($agent, $logger);
        } elseif (preg_match('/(grapeshotcrawler)/i', $agent)) {
            $browser = new GrapeshotCrawler($agent, $logger);
        } elseif (preg_match('/(mail\.ru)/i', $agent)) {
            $browser = new MailRu($agent, $logger);
        } elseif (preg_match('/(kazehakase)/i', $agent)) {
            $browser = new Kazehakase($agent, $logger);
        } elseif (preg_match('/(proximic)/i', $agent)) {
            $browser = new Proximic($agent, $logger);
        } elseif (preg_match('/(polaris)/i', $agent)) {
            $browser = new Polaris($agent, $logger);
        } elseif (preg_match('/(another web mining tool|awmt)/i', $agent)) {
            $browser = new AnotherWebMiningTool($agent, $logger);
        } elseif (preg_match('/(wbsearchbot)/i', $agent)) {
            $browser = new WbSearchBot($agent, $logger);
        } elseif (preg_match('/(konqueror)/i', $agent)) {
            $browser = new Konqueror($agent, $logger);
        } elseif (preg_match('/(typo3\-linkvalidator)/i', $agent)) {
            $browser = new Typo3Linkvalidator($agent, $logger);
        } elseif (preg_match('/feeddlerrss/i', $agent)) {
            $browser = new FeeddlerRssReader($agent, $logger);
        } elseif (preg_match('/(ios|iphone|ipad|ipod)/i', $agent)) {
            $browser = new Safari($agent, $logger);
        } elseif (preg_match('/(slurp)/i', $agent)) {
            $browser = new YahooSlurp($agent, $logger);
        } elseif (preg_match('/(paperlibot)/i', $agent)) {
            $browser = new PaperLiBot($agent, $logger);
        } elseif (preg_match('/(spbot)/i', $agent)) {
            $browser = new Seoprofiler($agent, $logger);
        } elseif (preg_match('/(dotbot)/i', $agent)) {
            $browser = new DotBot($agent, $logger);
        } elseif (preg_match('/(google\-structureddatatestingtool)/i', $agent)) {
            $browser = new GoogleStructuredDataTestingTool($agent, $logger);
        } elseif (preg_match('/(webmastercoffee)/i', $agent)) {
            $browser = new WebmasterCoffee($agent, $logger);
        } elseif (preg_match('/(ahrefs)/i', $agent)) {
            $browser = new AhrefsBot($agent, $logger);
        } elseif (preg_match('/apercite/i', $agent)) {
            $browser = new Apercite($agent, $logger);
        } elseif (preg_match('/woobot/', $agent)) {
            $browser = new WooRank($agent, $logger);
        } elseif (preg_match('/(obot)/i', $agent)) {
            $browser = new Obot($agent, $logger);
        } elseif (preg_match('/(umbot)/i', $agent)) {
            $browser = new UmBot($agent, $logger);
        } elseif (preg_match('/(picmole)/i', $agent)) {
            $browser = new PicmoleBot($agent, $logger);
        } elseif (preg_match('/(zollard)/i', $agent)) {
            $browser = new ZollardWorm($agent, $logger);
        } elseif (preg_match('/(fhscan core)/i', $agent)) {
            $browser = new FhscanCore($agent, $logger);
        } elseif (preg_match('/(nbot)/i', $agent)) {
            $browser = new Nbot($agent, $logger);
        } elseif (preg_match('/(loadtimebot)/i', $agent)) {
            $browser = new LoadTimeBot($agent, $logger);
        } elseif (preg_match('/(scrubby)/i', $agent)) {
            $browser = new Scrubby($agent, $logger);
        } elseif (preg_match('/(squzer)/i', $agent)) {
            $browser = new Squzer($agent, $logger);
        } elseif (preg_match('/(lbot)/i', $agent)) {
            $browser = new Lbot($agent, $logger);
        } elseif (preg_match('/(blexbot)/i', $agent)) {
            $browser = new BlexBot($agent, $logger);
        } elseif (preg_match('/(easouspider)/i', $agent)) {
            $browser = new EasouSpider($agent, $logger);
        } elseif (preg_match('/(socialradarbot)/i', $agent)) {
            $browser = new Socialradarbot($agent, $logger);
        } elseif (preg_match('/(synapse)/i', $agent)) {
            $browser = new ApacheSynapse($agent, $logger);
        } elseif (preg_match('/(linkdexbot)/i', $agent)) {
            $browser = new LinkdexBot($agent, $logger);
        } elseif (preg_match('/(coccoc)/i', $agent)) {
            $browser = new CocCocBot($agent, $logger);
        } elseif (preg_match('/(siteexplorer)/i', $agent)) {
            $browser = new SiteExplorer($agent, $logger);
        } elseif (preg_match('/(semrushbot)/i', $agent)) {
            $browser = new SemrushBot($agent, $logger);
        } elseif (preg_match('/(istellabot)/i', $agent)) {
            $browser = new IstellaBot($agent, $logger);
        } elseif (preg_match('/Qt/', $agent)) {
            $browser = new Qt($agent, $logger);
        } elseif (preg_match('/(meanpathbot)/i', $agent)) {
            $browser = new MeanpathBot($agent, $logger);
        } elseif (preg_match('/(XML Sitemaps Generator)/', $agent)) {
            $browser = new XmlSitemapsGenerator($agent, $logger);
        } elseif (preg_match('/^Mozilla\/\d/', $agent)) {
            $browser = new Netscape($agent, $logger);
        } elseif (preg_match('/^Dalvik\/\d/', $agent)) {
            $browser = new Dalvik($agent, $logger);
        } elseif (preg_match('/niki\-bot/', $agent)) {
            $browser = new NikiBot($agent, $logger);
        } elseif (preg_match('/ContextAd Bot/', $agent)) {
            $browser = new ContextadBot($agent, $logger);
        } elseif (preg_match('/integrity/', $agent)) {
            $browser = new Integrity($agent, $logger);
        } elseif (preg_match('/masscan/', $agent)) {
            $browser = new DownloadAccelerator($agent, $logger);
        } elseif (preg_match('/ZmEu/', $agent)) {
            $browser = new ZmEu($agent, $logger);
        } elseif (preg_match('/sogou web spider/i', $agent)) {
            $browser = new SogouWebSpider($agent, $logger);
        } elseif (preg_match('/(OpenWave|UP\.Browser|UP\/)/', $agent)) {
            $browser = new Openwave($agent, $logger);
        } elseif (preg_match('/(Teleca|Obigo|MIC\/|AU\-MIC)/', $agent)) {
            $browser = new TelecaObigo($agent, $logger);
        } elseif (preg_match('/DavClnt/', $agent)) {
            $browser = new MicrosoftWebDav($agent, $logger);
        } elseif (preg_match('/XING\-contenttabreceiver/', $agent)) {
            $browser = new XingContenttabreceiver($agent, $logger);
        } elseif (preg_match('/netEstate NE Crawler/', $agent)) {
            $browser = new NetEstateCrawler($agent, $logger);
        } elseif (preg_match('/Slingstone/', $agent)) {
            $browser = new YahooSlingstone($agent, $logger);
        } elseif (preg_match('/BOT for JCE/', $agent)) {
            $browser = new BotForJce($agent, $logger);
        } elseif (preg_match('/Google\-HTTP\-Java\-Client/', $agent)) {
            $browser = new GoogleHttpClientLibraryForJava($agent, $logger);
        } elseif (preg_match('/Validator\.nu\/LV/', $agent)) {
            $browser = new W3cValidatorNuLv($agent, $logger);
        } elseif (preg_match('/Ruby/', $agent)) {
            $browser = new Ruby($agent, $logger);
        } elseif (preg_match('/securepoint cf/', $agent)) {
            $browser = new SecurepointContentFilter($agent, $logger);
        } elseif (preg_match('/sogou\-spider/i', $agent)) {
            $browser = new SogouSpider($agent, $logger);
        } elseif (preg_match('/rankflex/i', $agent)) {
            $browser = new RankFlex($agent, $logger);
        } elseif (preg_match('/domnutch/i', $agent)) {
            $browser = new Domnutch($agent, $logger);
        } elseif (preg_match('/discovered/i', $agent)) {
            $browser = new DiscoverEd($agent, $logger);
        } elseif (preg_match('/boardreader favicon fetcher/i', $agent)) {
            $browser = new BoardReaderFaviconFetcher($agent, $logger);
        } elseif (preg_match('/checksite verification agent/i', $agent)) {
            $browser = new CheckSiteVerificationAgent($agent, $logger);
        } elseif (preg_match('/experibot/i', $agent)) {
            $browser = new Experibot($agent, $logger);
        } elseif (preg_match('/feedblitz/i', $agent)) {
            $browser = new FeedBlitz($agent, $logger);
        } elseif (preg_match('/rss2html/i', $agent)) {
            $browser = new Rss2Html($agent, $logger);
        } elseif (preg_match('/feedlyapp/i', $agent)) {
            $browser = new FeedlyApp($agent, $logger);
        } elseif (preg_match('/garlikcrawler/i', $agent)) {
            $browser = new GarlikCrawler($agent, $logger);
        } elseif (preg_match('/genderanalyzer/i', $agent)) {
            $browser = new Genderanalyzer($agent, $logger);
        } elseif (preg_match('/gooblog/i', $agent)) {
            $browser = new GooBlog($agent, $logger);
        } elseif (preg_match('/metageneratorcrawler/i', $agent)) {
            $browser = new MetaGeneratorCrawler($agent, $logger);
        } elseif (preg_match('/microsoft office mobile/i', $agent)) {
            $browser = new MicrosoftOffice($agent, $logger);
        } elseif (preg_match('/tumblr/i', $agent)) {
            $browser = new TumblrApp($agent, $logger);
        } elseif (preg_match('/w3c\_i18n\-checker/i', $agent)) {
            $browser = new W3cI18nChecker($agent, $logger);
        } elseif (preg_match('/w3c\_unicorn/i', $agent)) {
            $browser = new W3cUnicorn($agent, $logger);
        } elseif (preg_match('/alltop/i', $agent)) {
            $browser = new AlltopApp($agent, $logger);
        } elseif (preg_match('/internetseer/i', $agent)) {
            $browser = new InternetSeer($agent, $logger);
        } elseif (preg_match('/pinterest/i', $agent)) {
            $browser = new PinterestApp($agent, $logger);
        } elseif (preg_match('/ADmantX Platform Semantic Analyzer/', $agent)) {
            $browser = new AdmantxPlatformSemanticAnalyzer($agent, $logger);
        } elseif (preg_match('/UniversalFeedParser/', $agent)) {
            $browser = new UniversalFeedParser($agent, $logger);
        } elseif (preg_match('/(binlar|larbin)/i', $agent)) {
            $browser = new Larbin($agent, $logger);
        } elseif (preg_match('/unityplayer/i', $agent)) {
            $browser = new UnityWebPlayer($agent, $logger);
        } elseif (preg_match('/WeSEE\:Search/', $agent)) {
            $browser = new WeseeSearch($agent, $logger);
        } elseif (preg_match('/A6\-Indexer/', $agent)) {
            $browser = new A6Indexer($agent, $logger);
        } elseif (preg_match('/NerdyBot/', $agent)) {
            $browser = new NerdyBot($agent, $logger);
        } elseif (preg_match('/Peeplo Screenshot Bot/', $agent)) {
            $browser = new PeeploScreenshotBot($agent, $logger);
        } elseif (preg_match('/CCBot/', $agent)) {
            $browser = new CcBot($agent, $logger);
        } elseif (preg_match('/visionutils/', $agent)) {
            $browser = new VisionUtils($agent, $logger);
        } elseif (preg_match('/Feedly/', $agent)) {
            $browser = new Feedly($agent, $logger);
        } elseif (preg_match('/ScreenerBot/', $agent)) {
            $browser = new ScreenerBot($agent, $logger);
        } elseif (preg_match('/Photon/', $agent)) {
            $browser = new Photon($agent, $logger);
        } else {
            $browser = new UnknownBrowser($agent, $logger);
        }

        $browser->setCache($cache);

        return $browser;
    }
}
