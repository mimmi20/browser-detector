<?php
/**
 * Copyright (c) 2012-2016, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
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
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector\Factory;

use BrowserDetector\Detector\Version\AndroidWebkit;
use BrowserDetector\Detector\Version\Friendica;
use BrowserDetector\Detector\Version\Maxthon;
use BrowserDetector\Detector\Version\MicrosoftAccess;
use BrowserDetector\Detector\Version\MicrosoftExcel;
use BrowserDetector\Detector\Version\MicrosoftFrontPage;
use BrowserDetector\Detector\Version\MicrosoftInternetExplorer;
use BrowserDetector\Detector\Version\MicrosoftLync;
use BrowserDetector\Detector\Version\MicrosoftOffice;
use BrowserDetector\Detector\Version\MicrosoftOfficeSyncProc;
use BrowserDetector\Detector\Version\MicrosoftOfficeUploadCenter;
use BrowserDetector\Detector\Version\MicrosoftOneNote;
use BrowserDetector\Detector\Version\MicrosoftOutlook;
use BrowserDetector\Detector\Version\MicrosoftPowerPoint;
use BrowserDetector\Detector\Version\MicrosoftVisio;
use BrowserDetector\Detector\Version\MicrosoftWord;
use BrowserDetector\Detector\Version\ObigoQ;
use BrowserDetector\Detector\Version\Safari;
use BrowserDetector\Detector\Version\YouWaveAndroidOnPc;
use BrowserDetector\Version\VersionFactory;
use BrowserDetector\Version\Version;
use UaResult\Browser\Browser;
use UaResult\Os\OsInterface;
use BrowserDetector\Detector\Bits\Browser as BrowserBits;
use UaBrowserType;

/**
 * Browser detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class BrowserFactory implements FactoryInterface
{
    /**
     * Gets the information about the rendering engine by User Agent
     *
     * @param string                   $useragent
     * @param \UaResult\Os\OsInterface $platform
     *
     * @return \UaResult\Browser\Browser
     */
    public static function detect(
        $useragent,
        OsInterface $platform = null
    ) {
        $bits = (new BrowserBits($useragent))->getBits();

        if (preg_match('/RevIP\.info site analyzer/', $useragent)) {
            return new Browser($useragent, 'Reverse IP Lookup', VersionFactory::detectVersion($useragent, ['RevIP\.info site analyzer v']), 'Binarymonkey', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/reddit pic scraper/i', $useragent)) {
            return new Browser($useragent, 'reddit pic scraper', VersionFactory::detectVersion($useragent, ['reddit pic scraper']), 'Reddit', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Mozilla crawl/', $useragent)) {
            return new Browser($useragent, 'Mozilla Crawler', VersionFactory::detectVersion($useragent, ['Mozilla crawl']), 'Fairshare', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/^\[FBAN/i', $useragent)) {
            return new Browser($useragent, 'Facebook App', VersionFactory::detectVersion($useragent, ['Facebook', 'FBAV', 'facebookexternalhit']), 'Facebook', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (preg_match('/UCBrowserHD/', $useragent)) {
            return new Browser($useragent, 'UC Browser HD', VersionFactory::detectVersion($useragent, ['UC Browser', 'UCBrowser', 'UCWEB', 'Browser']), 'UcWeb', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (preg_match('/(ucbrowser|uc browser|ucweb)/i', $useragent) && preg_match('/opera mini/i', $useragent)) {
            return new Browser($useragent, 'UC Browser', VersionFactory::detectVersion($useragent, ['UC Browser', 'UCBrowser', 'UCWEB', 'Browser']), 'UcWeb', $bits, new UaBrowserType\Transcoder(), true, false, true, false, true, true, true);
        } elseif (preg_match('/(opera mini|opios)/i', $useragent)) {
            return new Browser($useragent, 'Opera Mini', VersionFactory::detectVersion($useragent, ['OPiOS']), 'Opera', $bits, new UaBrowserType\Transcoder(), true, false, true, true, true, true, true);
        } elseif (preg_match('/opera mobi/i', $useragent)
            || (preg_match('/(opera|opr)/i', $useragent) && preg_match('/(Android|MTK|MAUI|SAMSUNG|Windows CE|SymbOS)/', $useragent))
        ) {
            return new Browser($useragent, 'Opera Mobile', VersionFactory::detectVersion($useragent, ['Version', 'OPR', 'Opera ', 'Opera Mobi', 'Opera']), 'Opera', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/(ucbrowser|uc browser|ucweb)/i', $useragent)) {
            return new Browser($useragent, 'UC Browser', VersionFactory::detectVersion($useragent, ['UC Browser', 'UCBrowser', 'UCWEB', 'Browser']), 'UcWeb', $bits, new UaBrowserType\Transcoder(), true, false, true, false, true, true, true);
        } elseif (preg_match('/IC OpenGraph Crawler/', $useragent)) {
            return new Browser($useragent, 'IBM Connections', VersionFactory::detectVersion($useragent, ['IC OpenGraph Crawler']), 'Ibm', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/coast/i', $useragent)) {
            return new Browser($useragent, 'Coast', VersionFactory::detectVersion($useragent, ['OperaCoast', 'Opera%20Coast', 'Coast']), 'Opera', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (preg_match('/(opera|opr)/i', $useragent)) {
            return new Browser($useragent, 'Opera', VersionFactory::detectVersion($useragent, ['Version', 'Opera', 'OPR']), 'Opera', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/iCabMobile/', $useragent)) {
            return new Browser($useragent, 'iCab Mobile', VersionFactory::detectVersion($useragent, ['iCabMobile', 'iCab']), 'AlexanderClauss', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/iCab/', $useragent)) {
            return new Browser($useragent, 'iCab', VersionFactory::detectVersion($useragent, ['iCabMobile', 'iCab']), 'AlexanderClauss', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/HggH PhantomJS Screenshoter/', $useragent)) {
            return new Browser($useragent, 'HggH Screenshot System with PhantomJS', VersionFactory::detectVersion($useragent, ['HggH PhantomJS Screenshoter']), 'JonasGenannt', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/bl\.uk\_lddc\_bot/', $useragent)) {
            return new Browser($useragent, 'bl.uk_lddc_bot', new Version(0), 'TheBritishLegalDepositLibraries', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/phantomas/', $useragent)) {
            return new Browser($useragent, 'phantomas', VersionFactory::detectVersion($useragent, ['phantomas']), 'MaciejBrencz', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Seznam screenshot\-generator/', $useragent)) {
            return new Browser($useragent, 'Seznam Screenshot Generator', VersionFactory::detectVersion($useragent, ['SeznamScreenshotGenerator', 'Seznam screenshot-generator']), 'Seznam', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (false !== strpos($useragent, 'PhantomJS')) {
            return new Browser($useragent, 'PhantomJS', VersionFactory::detectVersion($useragent, ['PhantomJS']), 'PhantomJs', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (false !== strpos($useragent, 'YaBrowser')) {
            return new Browser($useragent, 'Yandex Browser', VersionFactory::detectVersion($useragent, ['YaBrowser']), 'Yandex', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (false !== strpos($useragent, 'Kamelio')) {
            return new Browser($useragent, 'Kamelio App', VersionFactory::detectVersion($useragent, [            'Kamelio',        ]), 'Kamelio', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (false !== strpos($useragent, 'FBAV')) {
            return new Browser($useragent, 'Facebook App', VersionFactory::detectVersion($useragent, ['Facebook', 'FBAV', 'facebookexternalhit']), 'Facebook', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (false !== strpos($useragent, 'ACHEETAHI')) {
            return new Browser($useragent, 'CM Browser', new Version(0), 'CheetahMobile', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/flyflow/i', $useragent)) {
            return new Browser($useragent, 'FlyFlow', VersionFactory::detectVersion($useragent, ['FlyFlow', 'FlyFlow\-']), 'Baidu', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (false !== strpos($useragent, 'bdbrowser_i18n') || false !== strpos($useragent, 'baidubrowser')) {
            return new Browser($useragent, 'Baidu Browser', VersionFactory::detectVersion($useragent, ['bdbrowser_i18n']), 'Baidu', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (false !== strpos($useragent, 'bdbrowserhd_i18n')) {
            return new Browser($useragent, 'Baidu Browser HD', VersionFactory::detectVersion($useragent, ['bdbrowserhd_i18n']), 'Baidu', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (false !== strpos($useragent, 'bdbrowser_mini')) {
            return new Browser($useragent, 'Baidu Browser Mini', VersionFactory::detectVersion($useragent, ['bdbrowser_mini']), 'Baidu', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (false !== strpos($useragent, 'Puffin')) {
            return new Browser($useragent, 'Puffin', VersionFactory::detectVersion($useragent, ['Puffin', 'Puffin%20Free']), 'CloudMosa', $bits, new UaBrowserType\Browser(), true, false, false, false, true, true, true);
        } elseif (preg_match('/stagefright/', $useragent)) {
            return new Browser($useragent, 'stagefright', VersionFactory::detectVersion($useragent, ['stagefright']), 'Unknown', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (false !== strpos($useragent, 'SamsungBrowser')) {
            return new Browser($useragent, 'Samsung Browser', VersionFactory::detectVersion($useragent, ['SamsungBrowser']), 'Samsung', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (false !== strpos($useragent, 'Silk')) {
            return new Browser($useragent, 'Silk', VersionFactory::detectVersion($useragent, ['Silk']), 'Amazon', $bits, new UaBrowserType\Transcoder(), true, false, true, false, true, true, true);
        } elseif (false !== strpos($useragent, 'coc_coc_browser')) {
            return new Browser($useragent, 'Coc Coc Browser', VersionFactory::detectVersion($useragent, ['coc_coc_browser']), 'CocCocCompany', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (false !== strpos($useragent, 'NaverMatome')) {
            return new Browser($useragent, 'Matome', VersionFactory::detectVersion($useragent, ['NaverMatome\-Android']), 'NhnCorporation', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/FlipboardProxy/', $useragent)) {
            return new Browser($useragent, 'FlipboardProxy', VersionFactory::detectVersion($useragent, ['FlipboardProxy']), 'Flipboard', $bits, new UaBrowserType\Bot(), true, false, true, false, true, true, true);
        } elseif (false !== strpos($useragent, 'Flipboard')) {
            return new Browser($useragent, 'Flipboard App', VersionFactory::detectVersion($useragent, ['Flipboard']), 'Flipboard', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (false !== strpos($useragent, 'Seznam.cz')) {
            return new Browser($useragent, 'Seznam Browser', VersionFactory::detectVersion($useragent, ['Seznam\.cz']), 'Seznam', $bits, new UaBrowserType\Browser(), true, false, false, false, true, true, true);
        } elseif (false !== strpos($useragent, 'Aviator')) {
            return new Browser($useragent, 'Aviator', VersionFactory::detectVersion($useragent, ['Aviator']), 'WhiteHat', $bits, new UaBrowserType\Browser(), true, false, false, false, true, true, true);
        } elseif (preg_match('/NetFrontLifeBrowser/', $useragent)) {
            return new Browser($useragent, 'NetFrontLifeBrowser', VersionFactory::detectVersion($useragent, ['NetFrontLifeBrowser']), 'Access', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/IceDragon/', $useragent)) {
            return new Browser($useragent, 'IceDragon', VersionFactory::detectVersion($useragent, ['IceDragon']), 'Comodo', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (false !== strpos($useragent, 'Dragon') && false === strpos($useragent, 'DragonFly')) {
            return new Browser($useragent, 'Dragon', VersionFactory::detectVersion($useragent, ['Comodo Dragon', 'Dragon', 'Chrome']), 'Comodo', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (false !== strpos($useragent, 'Beamrise')) {
            return new Browser($useragent, 'Beamrise', VersionFactory::detectVersion($useragent, ['Beamrise']), 'BeamriseTeam', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (false !== strpos($useragent, 'Diglo')) {
            return new Browser($useragent, 'Diglo', VersionFactory::detectVersion($useragent, ['Diglo']), 'Diglo', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (false !== strpos($useragent, 'APUSBrowser')) {
            return new Browser($useragent, 'APUSBrowser', VersionFactory::detectVersion($useragent, ['APUSBrowser']), 'ApusGroup', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (false !== strpos($useragent, 'Chedot')) {
            return new Browser($useragent, 'Chedot', VersionFactory::detectVersion($useragent, ['Chedot']), 'Chedot', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (false !== strpos($useragent, 'Qword')) {
            return new Browser($useragent, 'Qword Browser', VersionFactory::detectVersion($useragent, ['Qword']), 'QwordCorporation', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (false !== strpos($useragent, 'Iridium')) {
            return new Browser($useragent, 'Iridium Browser', VersionFactory::detectVersion($useragent, ['Iridium']), 'IridiumBrowserTeam', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/avant/i', $useragent)) {
            return new Browser($useragent, 'Avant', new Version(0), 'AvantForce', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (false !== strpos($useragent, 'MxNitro')) {
            return new Browser($useragent, 'Maxthon Nitro', VersionFactory::detectVersion($useragent, ['MxNitro']), 'Maxthon', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/(mxbrowser|maxthon|myie)/i', $useragent)) {
            return new Browser($useragent, 'Maxthon', Maxthon::detectVersion($useragent), 'Maxthon', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/superbird/i', $useragent)) {
            return new Browser($useragent, 'SuperBird', VersionFactory::detectVersion($useragent, ['Superbird']), 'SuperBird', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (false !== strpos($useragent, 'TinyBrowser')) {
            return new Browser($useragent, 'TinyBrowser', VersionFactory::detectVersion($useragent, ['TinyBrowser']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/MicroMessenger/', $useragent)) {
            return new Browser($useragent, 'WeChat App', VersionFactory::detectVersion($useragent, ['MicroMessenger']), 'Tencent', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/MQQBrowser\/Mini/', $useragent)) {
            return new Browser($useragent, 'QQbrowser Mini', VersionFactory::detectVersion($useragent, ['MQQBrowser\/Mini']), 'Tencent', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/MQQBrowser/', $useragent)) {
            return new Browser($useragent, 'QQbrowser', VersionFactory::detectVersion($useragent, ['MQQBrowser']), 'Tencent', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/pinterest/i', $useragent)) {
            return new Browser($useragent, 'Pinterest App', VersionFactory::detectVersion($useragent, ['Pinterest']), 'EricssonResearch', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/baiduboxapp/', $useragent)) {
            return new Browser($useragent, 'Baidu Box App', VersionFactory::detectVersion($useragent, ['baiduboxapp']), 'Baidu', $bits, new UaBrowserType\Application(), true, false, true, true, true, true, true);
        } elseif (preg_match('/wkbrowser/', $useragent)) {
            return new Browser($useragent, 'WKBrowser', VersionFactory::detectVersion($useragent, ['wkbrowser']), 'KeanuLee', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Mb2345Browser/', $useragent)) {
            return new Browser($useragent, '2345 Browser', VersionFactory::detectVersion($useragent, ['Mb2345Browser']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (false !== strpos($useragent, 'Chrome')
            && false !== strpos($useragent, 'Version')
            && 0 < strpos($useragent, 'Chrome')
        ) {
            return new Browser($useragent, 'Android WebView', VersionFactory::detectVersion($useragent, ['Version']), 'Google', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (false !== strpos($useragent, 'Safari')
            && false !== strpos($useragent, 'Version')
            && false !== strpos($useragent, 'Tizen')
        ) {
            return new Browser($useragent, 'Samsung WebView', VersionFactory::detectVersion($useragent, ['Version']), 'Samsung', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/cybeye/i', $useragent)) {
            return new Browser($useragent, 'CybEye', VersionFactory::detectVersion($useragent, ['CybEye\.com']), 'CybEye', $bits, new UaBrowserType\Application(), true, true, true, false, true, true, true);
        } elseif (preg_match('/RebelMouse/', $useragent)) {
            return new Browser($useragent, 'RebelMouse', VersionFactory::detectVersion($useragent, ['RebelMouse']), 'RebelMouse', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SeaMonkey/', $useragent)) {
            return new Browser($useragent, 'SeaMonkey', VersionFactory::detectVersion($useragent, ['SeaMonkey', 'Seamonkey']), 'MozillaFoundation', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Jobboerse/', $useragent)) {
            return new Browser($useragent, 'JobBoerse Bot', VersionFactory::detectVersion($useragent, ['findlinks']), 'Jobboerse', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Navigator/', $useragent)) {
            return new Browser($useragent, 'Netscape Navigator', VersionFactory::detectVersion($useragent, ['Navigator']), 'Netscape', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/firefox/i', $useragent) && preg_match('/anonym/i', $useragent)) {
            return new Browser($useragent, 'Firefox', VersionFactory::detectVersion($useragent, [            'Firefox',            'Minefield',            'Shiretoko',            'BonEcho',            'Namoroka',            'Fennec',        ]), 'MozillaFoundation', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/trident/i', $useragent) && preg_match('/anonym/i', $useragent)) {
            return new Browser($useragent, 'Internet Explorer', MicrosoftInternetExplorer::detectVersion($useragent), 'Microsoft', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Windows\-RSS\-Platform/', $useragent)) {
            return new Browser($useragent, 'Windows-RSS-Platform', VersionFactory::detectVersion($useragent, ['Windows\-RSS\-Platform']), 'Microsoft', $bits, new UaBrowserType\Bot(), true, false, true, false, true, true, true);
        } elseif (preg_match('/MarketwireBot/', $useragent)) {
            return new Browser($useragent, 'MarketwireBot', VersionFactory::detectVersion($useragent, ['MarketwireBot']), 'Marketwire', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/GoogleToolbar/', $useragent)) {
            return new Browser($useragent, 'Google Toolbar', VersionFactory::detectVersion($useragent, ['GoogleToolbar']), 'Google', $bits, new UaBrowserType\Bot(), false, false, false, false, true, true, true);
        } elseif (preg_match('/netscape/i', $useragent) && preg_match('/msie/i', $useragent)) {
            return new Browser($useragent, 'Netscape', VersionFactory::detectVersion($useragent, ['Netscape', 'Netscape6', 'rv\:', 'Mozilla']), 'Netscape', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/LSSRocketCrawler/', $useragent)) {
            return new Browser($useragent, 'Lightspeed Systems RocketCrawler', VersionFactory::detectVersion($useragent, ['LSSRocketCrawler']), 'LightspeedSystems', $bits, new UaBrowserType\Bot(), true, false, true, false, true, true, true);
        } elseif (preg_match('/lightspeedsystems/i', $useragent)) {
            return new Browser($useragent, 'Lightspeed Systems Crawler', new Version(0), 'LightspeedSystems', $bits, new UaBrowserType\Bot(), true, false, true, false, true, true, true);
        } elseif (preg_match('/SL Commerce Client/', $useragent)) {
            return new Browser($useragent, 'Second Live Commerce Client', VersionFactory::detectVersion($useragent, ['SL Commerce Client v', 'SL Commerce Client']), 'LindenLabs', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(IEMobile|WPDesktop|ZuneWP7|XBLWP7)/', $useragent)) {
            return new Browser($useragent, 'IEMobile', VersionFactory::detectVersion($useragent, ['IEMobile', 'MSIE', 'rv\:']), 'Microsoft', $bits, new UaBrowserType\Browser(), true, true, true, true, true, true, true);
        } elseif (preg_match('/BingPreview/', $useragent)) {
            return new Browser($useragent, 'Bing Preview', VersionFactory::detectVersion($useragent, ['BingPreview']), 'Microsoft', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/360Spider/', $useragent)) {
            return new Browser($useragent, '360Spider', VersionFactory::detectVersion($useragent, ['360Spider']), 'Qihoo', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Outlook\-Express/', $useragent)) {
            return new Browser($useragent, 'Windows Live Mail', VersionFactory::detectVersion($useragent, ['Outlook-Express']), 'Microsoft', $bits, new UaBrowserType\EmailClient(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Outlook/', $useragent)) {
            return new Browser($useragent, 'Outlook', MicrosoftOutlook::detectVersion($useragent), 'Microsoft', $bits, new UaBrowserType\EmailClient(), true, false, true, true, true, true, true);
        } elseif (preg_match('/microsoft office mobile/i', $useragent)) {
            return new Browser($useragent, 'Office', MicrosoftOffice::detectVersion($useragent), 'Microsoft', $bits, new UaBrowserType\Application(), true, false, true, true, true, true, true);
        } elseif (preg_match('/MSOffice/', $useragent)) {
            return new Browser($useragent, 'Office', MicrosoftOffice::detectVersion($useragent), 'Microsoft', $bits, new UaBrowserType\Application(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Microsoft Office Protocol Discovery/', $useragent)) {
            return new Browser($useragent, 'MS OPD', VersionFactory::detectVersion($useragent, ['Microsoft Office Protocol Discovery']), 'Microsoft', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/excel/i', $useragent)) {
            return new Browser($useragent, 'Excel', MicrosoftExcel::detectVersion($useragent), 'Microsoft', $bits, new UaBrowserType\Application(), true, false, true, true, true, true, true);
        } elseif (preg_match('/powerpoint/i', $useragent)) {
            return new Browser($useragent, 'PowerPoint', MicrosoftPowerPoint::detectVersion($useragent), 'Microsoft', $bits, new UaBrowserType\Application(), true, false, true, true, true, true, true);
        } elseif (preg_match('/WordPress/', $useragent)) {
            return new Browser($useragent, 'WordPress', VersionFactory::detectVersion($useragent, ['WordPress', 'WordPress\-B\-', 'WordPress\-Do\-P\-']), 'WordPress', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Word/', $useragent)) {
            return new Browser($useragent, 'Word', MicrosoftWord::detectVersion($useragent), 'Microsoft', $bits, new UaBrowserType\Application(), true, false, true, true, true, true, true);
        } elseif (preg_match('/OneNote/', $useragent)) {
            return new Browser($useragent, 'OneNote', MicrosoftOneNote::detectVersion($useragent), 'Microsoft', $bits, new UaBrowserType\Application(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Visio/', $useragent)) {
            return new Browser($useragent, 'Visio', MicrosoftVisio::detectVersion($useragent), 'Microsoft', $bits, new UaBrowserType\Application(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Access/', $useragent)) {
            return new Browser($useragent, 'Access', MicrosoftAccess::detectVersion($useragent), 'Microsoft', $bits, new UaBrowserType\Application(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Lync/', $useragent)) {
            return new Browser($useragent, 'Lync', MicrosoftLync::detectVersion($useragent), 'Microsoft', $bits, new UaBrowserType\Application(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Office SyncProc/', $useragent)) {
            return new Browser($useragent, 'Office SyncProc', MicrosoftOfficeSyncProc::detectVersion($useragent), 'Microsoft', $bits, new UaBrowserType\Application(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Office Upload Center/', $useragent)) {
            return new Browser($useragent, 'Office Upload Center', MicrosoftOfficeUploadCenter::detectVersion($useragent), 'Microsoft', $bits, new UaBrowserType\Application(), true, false, true, true, true, true, true);
        } elseif (preg_match('/frontpage/i', $useragent)) {
            return new Browser($useragent, 'FrontPage', MicrosoftFrontPage::detectVersion($useragent), 'Microsoft', $bits, new UaBrowserType\Application(), true, false, true, true, true, true, true);
        } elseif (preg_match('/microsoft office/i', $useragent)) {
            return new Browser($useragent, 'Office', MicrosoftOffice::detectVersion($useragent), 'Microsoft', $bits, new UaBrowserType\Application(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Crazy Browser/', $useragent)) {
            return new Browser($useragent, 'Crazy Browser', VersionFactory::detectVersion($useragent, ['Crazy Browser']), 'CrazyBrowser', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Deepnet Explorer/', $useragent)) {
            return new Browser($useragent, 'Deepnet Explorer', VersionFactory::detectVersion($useragent, ['Deepnet Explorer']), 'DeepnetSecurity', $bits, new UaBrowserType\Browser(), true, false, false, false, true, true, true);
        } elseif (preg_match('/kkman/i', $useragent)) {
            return new Browser($useragent, 'KKMAN', VersionFactory::detectVersion($useragent, ['KKman']), 'Kkbox', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Lunascape/', $useragent)) {
            return new Browser($useragent, 'Lunascape', VersionFactory::detectVersion($useragent, ['Lunascape', 'iLunascape']), 'Lunascape', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Sleipnir/', $useragent)) {
            return new Browser($useragent, 'Sleipnir', VersionFactory::detectVersion($useragent, ['Version', 'Sleipnir']), 'Fenrir', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Smartsite HTTPClient/', $useragent)) {
            return new Browser($useragent, 'Smartsite HTTPClient', VersionFactory::detectVersion($useragent, ['Smartsite HTTPClient']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, true, false, true, true, true);
        } elseif (preg_match('/GomezAgent/', $useragent)) {
            return new Browser($useragent, 'Gomez Site Monitor', VersionFactory::detectVersion($useragent, ['GomezAgent']), 'CompuwareApm', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Mozilla\/5\.0.*\(.*Trident\/8\.0.*rv\:\d+\).*/', $useragent)
            || preg_match('/Mozilla\/5\.0.*\(.*Trident\/7\.0.*\) like Gecko.*/', $useragent)
            || preg_match('/Mozilla\/5\.0.*\(.*MSIE 10\.0.*Trident\/(4|5|6|7|8)\.0.*/', $useragent)
            || preg_match('/Mozilla\/(4|5)\.0.*\(.*MSIE (9|8|7|6)\.0.*/', $useragent)
            || preg_match('/Mozilla\/(4|5)\.0.*\(.*MSIE (5|4)\.\d+.*/', $useragent)
            || preg_match('/Mozilla\/\d\.\d+.*\(.*MSIE (3|2|1)\.\d+.*/', $useragent)
        ) {
            return new Browser($useragent, 'Internet Explorer', MicrosoftInternetExplorer::detectVersion($useragent), 'Microsoft', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (false !== strpos($useragent, 'Chromium')) {
            return new Browser($useragent, 'Chromium', VersionFactory::detectVersion($useragent, ['Chromium']), 'Google', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (false !== strpos($useragent, 'Iron')) {
            return new Browser($useragent, 'Iron', VersionFactory::detectVersion($useragent, ['Iron', 'Chrome']), 'Srware', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/midori/i', $useragent)) {
            return new Browser($useragent, 'Midori', VersionFactory::detectVersion($useragent, ['Midori', 'Midori\-']), 'ChristianDywan', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Google Page Speed Insights/', $useragent)) {
            return new Browser($useragent, 'Google PageSpeed Insights', VersionFactory::detectVersion($useragent, ['Google Page Speed Insights']), 'Google', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(web\/snippet)/', $useragent)) {
            return new Browser($useragent, 'Google Web Snippet', new Version(0), 'Google', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(googlebot\-mobile)/i', $useragent)) {
            return new Browser($useragent, 'Google Bot Mobile', VersionFactory::detectVersion($useragent, ['Googlebot\-Mobile']), 'Google', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Google Wireless Transcoder/', $useragent)) {
            return new Browser($useragent, 'Google Wireless Transcoder', VersionFactory::detectVersion($useragent, ['Google Wireless Transcoder']), 'Google', $bits, new UaBrowserType\BotTrancoder(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Locubot/', $useragent)) {
            return new Browser($useragent, 'Locubot', VersionFactory::detectVersion($useragent, ['Locubot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(com\.google\.GooglePlus)/i', $useragent)) {
            return new Browser($useragent, 'Google+ App', new Version(0), 'Google', $bits, new UaBrowserType\Application(), true, true, true, false, true, true, true);
        } elseif (preg_match('/Google\-HTTP\-Java\-Client/', $useragent)) {
            return new Browser($useragent, 'Google HTTP Client Library for Java', VersionFactory::detectVersion($useragent, ['Google\-HTTP\-Java\-Client']), 'Google', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/acapbot/i', $useragent)) {
            return new Browser($useragent, 'acapbot', VersionFactory::detectVersion($useragent, ['acapbot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/googlebot\-image/i', $useragent)) {
            return new Browser($useragent, 'Google Image Search', VersionFactory::detectVersion($useragent, [            'Googlebot\-Image',        ]), 'Google', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/googlebot/i', $useragent)) {
            return new Browser($useragent, 'Google Bot', VersionFactory::detectVersion($useragent, [            'Googlebot',            'Googlebot v',            'Googlebot\-News',            'Google',        ]), 'Google', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/^GOOG$/', $useragent)) {
            return new Browser($useragent, 'Google Bot', VersionFactory::detectVersion($useragent, [            'Googlebot',            'Googlebot v',            'Googlebot\-News',            'Google',        ]), 'Google', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/viera/i', $useragent)) {
            return new Browser($useragent, 'SmartViera', VersionFactory::detectVersion($useragent, ['Viera', 'SMART\-TV']), 'Panasonic', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Nichrome/', $useragent)) {
            return new Browser($useragent, 'Nichrome', VersionFactory::detectVersion($useragent, ['Nichrome\/self', 'Nichrome']), 'Rambler', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Kinza/', $useragent)) {
            return new Browser($useragent, 'Kinza', VersionFactory::detectVersion($useragent, ['Kinza']), 'Kinza', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Google Keyword Suggestion/', $useragent)) {
            return new Browser($useragent, 'Google Keyword Suggestion', VersionFactory::detectVersion($useragent, ['Google Keyword Suggestion']), 'Google', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Google Web Preview/', $useragent)) {
            return new Browser($useragent, 'Google Web Preview', VersionFactory::detectVersion($useragent, ['Google Web Preview']), 'Google', $bits, new UaBrowserType\BotTrancoder(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Google-Adwords-DisplayAds-WebRender/', $useragent)) {
            return new Browser($useragent, 'Google Adwords DisplayAds WebRender', VersionFactory::detectVersion($useragent, ['Google\-Adwords\-DisplayAds\-WebRender']), 'Google', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/HubSpot Webcrawler/', $useragent)) {
            return new Browser($useragent, 'HubSpot Webcrawler', VersionFactory::detectVersion($useragent, ['HubSpot Webcrawler']), 'HubSpotInc', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/RockMelt/', $useragent)) {
            return new Browser($useragent, 'RockMelt', VersionFactory::detectVersion($useragent, ['RockMelt']), 'Yahoo', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/ SE /', $useragent)) {
            return new Browser($useragent, 'Sogou Explorer', VersionFactory::detectVersion($useragent, ['SE']), 'Sogou', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/ArchiveBot/', $useragent)) {
            return new Browser($useragent, 'ArchiveBot', new Version(0), 'ArchiveTeam', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Edge/', $useragent) && null !== $platform && 'Windows Phone OS' === $platform->getName()) {
            return new Browser($useragent, 'Edge Mobile', VersionFactory::detectVersion($useragent, ['Edge']), 'Microsoft', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Edge/', $useragent)) {
            return new Browser($useragent, 'Edge', VersionFactory::detectVersion($useragent, ['Edge']), 'Microsoft', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/diffbot/i', $useragent)) {
            return new Browser($useragent, 'Diffbot', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/vivaldi/i', $useragent)) {
            return new Browser($useragent, 'Vivaldi', VersionFactory::detectVersion($useragent, ['Vivaldi']), 'Vivaldi', $bits, new UaBrowserType\Browser(), true, false, false, false, true, true, true);
        } elseif (preg_match('/LBBROWSER/', $useragent)) {
            return new Browser($useragent, 'liebao', VersionFactory::detectVersion($useragent, ['LBBROWSER']), 'Kingsoft', $bits, new UaBrowserType\Browser(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Amigo/', $useragent)) {
            return new Browser($useragent, 'Amigo', VersionFactory::detectVersion($useragent, ['Amigo']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/CoolNovoChromePlus/', $useragent)) {
            return new Browser($useragent, 'CoolNovo Chrome Plus', VersionFactory::detectVersion($useragent, ['CoolNovoChromePlus']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/CoolNovo/', $useragent)) {
            return new Browser($useragent, 'CoolNovo', VersionFactory::detectVersion($useragent, ['CoolNovo']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Kenshoo/', $useragent)) {
            return new Browser($useragent, 'Kenshoo', VersionFactory::detectVersion($useragent, ['Kenshoo']), 'Kenshoo', $bits, new UaBrowserType\Application(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Bowser/', $useragent)) {
            return new Browser($useragent, 'Bowser', VersionFactory::detectVersion($useragent, ['Bowser']), 'EricssonResearch', $bits, new UaBrowserType\Browser(), false, false, true, false, true, true, true);
        } elseif (preg_match('/360SE/', $useragent)) {
            return new Browser($useragent, '360 Secure Browser', VersionFactory::detectVersion($useragent, ['QIHU 360SE']), 'Qihoo', $bits, new UaBrowserType\Browser(), true, false, false, false, true, true, true);
        } elseif (preg_match('/360EE/', $useragent)) {
            return new Browser($useragent, '360 Speed Browser', VersionFactory::detectVersion($useragent, ['QIHU 360EE']), 'Qihoo', $bits, new UaBrowserType\Browser(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ASW/', $useragent)) {
            return new Browser($useragent, 'Avast SafeZone', VersionFactory::detectVersion($useragent, ['ASW']), 'AvastSoftware', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Wire/', $useragent)) {
            return new Browser($useragent, 'Wire App', VersionFactory::detectVersion($useragent, ['Wire']), 'WireSwiss', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/chrome\/(\d+)\.(\d+)/i', $useragent, $matches)
            && isset($matches[1])
            && isset($matches[2])
            && $matches[1] >= 1
            && $matches[2] > 0
            && $matches[2] <= 10
        ) {
            return new Browser($useragent, 'Dragon', VersionFactory::detectVersion($useragent, ['Comodo Dragon', 'Dragon', 'Chrome']), 'Comodo', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Flock/', $useragent)) {
            return new Browser($useragent, 'Flock', VersionFactory::detectVersion($useragent, ['Flock']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Bromium Safari/', $useragent)) {
            return new Browser($useragent, 'vSentry', VersionFactory::detectVersion($useragent, ['Bromium Safari']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(chrome|crmo|crios)/i', $useragent)) {
            return new Browser($useragent, 'Chrome', VersionFactory::detectVersion($useragent, ['Chrome', 'CrMo', 'CriOS']), 'Google', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/(dolphin http client)/i', $useragent)) {
            return new Browser($useragent, 'Dolphin smalltalk http client', VersionFactory::detectVersion($useragent, ['Dolphin http client']), 'SteveWaring', $bits, new UaBrowserType\Bot(), true, false, true, true, true, true, true);
        } elseif (preg_match('/(dolphin|dolfin)/i', $useragent)) {
            return new Browser($useragent, 'Dolfin', VersionFactory::detectVersion($useragent, ['Dolphin HD', 'Dolphin\/INT\-', 'Dolphin\/INT', 'Dolfin', 'Dolphin']), 'MopoTab', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Arora/', $useragent)) {
            return new Browser($useragent, 'Arora', VersionFactory::detectVersion($useragent, ['Arora']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/com\.douban\.group/i', $useragent)) {
            return new Browser($useragent, 'douban App', VersionFactory::detectVersion($useragent, [            'com\.douban\.group',        ]), 'Unknown', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ovibrowser/i', $useragent)) {
            return new Browser($useragent, 'Nokia Proxy Browser', VersionFactory::detectVersion($useragent, ['OviBrowser']), 'Nokia', $bits, new UaBrowserType\Transcoder(), true, false, true, false, true, true, true);
        } elseif (preg_match('/MiuiBrowser/i', $useragent)) {
            return new Browser($useragent, 'Miui Browser', VersionFactory::detectVersion($useragent, ['MiuiBrowser']), 'XiaomiTech', $bits, new UaBrowserType\Browser(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ibrowser/i', $useragent)) {
            return new Browser($useragent, 'iBrowser', VersionFactory::detectVersion($useragent, ['iBrowser']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/OneBrowser/', $useragent)) {
            return new Browser($useragent, 'OneBrowser', VersionFactory::detectVersion($useragent, ['OneBrowser']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Baiduspider\-image/', $useragent)) {
            return new Browser($useragent, 'Baidu Image Search', VersionFactory::detectVersion($useragent, ['Baiduspider-image']), 'Baidu', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/http:\/\/www\.baidu\.com\/search/', $useragent)) {
            return new Browser($useragent, 'Baidu Mobile Search', new Version(0), 'Baidu', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(yjapp|yjtop)/i', $useragent)) {
            return new Browser($useragent, 'Yahoo! App', VersionFactory::detectVersion($useragent, [            'jp\.co\.yahoo\.android\.yjtop',            'yjapp',        ]), 'Yahoo', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(linux; u; android|linux; android)/i', $useragent) && preg_match('/version/i', $useragent)) {
            return new Browser($useragent, 'Android Webkit', AndroidWebkit::detectVersion($useragent), 'Google', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/safari/i', $useragent) && null !== $platform && 'Android' === $platform->getName()) {
            return new Browser($useragent, 'Android Webkit', AndroidWebkit::detectVersion($useragent), 'Google', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Browser\/AppleWebKit/', $useragent)) {
            return new Browser($useragent, 'Android Webkit', AndroidWebkit::detectVersion($useragent), 'Google', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Android\/[\d\.]+ release/', $useragent)) {
            return new Browser($useragent, 'Android Webkit', AndroidWebkit::detectVersion($useragent), 'Google', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (false !== strpos($useragent, 'BlackBerry') && false !== strpos($useragent, 'Version')) {
            return new Browser($useragent, 'BlackBerry', VersionFactory::detectVersion($useragent, [            'BlackBerry[0-9a-z]+',            'BlackBerrySimulator',            'Version',        ]), 'Rim', $bits, new UaBrowserType\Browser(), false, false, true, true, true, true, true);
        } elseif (preg_match('/(webOS|wOSBrowser|wOSSystem)/', $useragent)) {
            return new Browser($useragent, 'WebKit/webOS', VersionFactory::detectVersion($useragent, ['Version', 'webOS', 'webOSBrowser']), 'Hp', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/OmniWeb/', $useragent)) {
            return new Browser($useragent, 'OmniWeb', VersionFactory::detectVersion($useragent, ['Version', 'Omniweb', 'OmniWeb']), 'OmniDevelopment', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Windows Phone Search/', $useragent)) {
            return new Browser($useragent, 'Windows Phone Search', new Version(0), 'Microsoft', $bits, new UaBrowserType\Bot(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Windows\-Update\-Agent/', $useragent)) {
            return new Browser($useragent, 'Windows-Update-Agent', VersionFactory::detectVersion($useragent, ['Windows\-Update\-Agent']), 'Microsoft', $bits, new UaBrowserType\Bot(), true, false, true, false, true, true, true);
        } elseif (preg_match('/nokia/i', $useragent)) {
            return new Browser($useragent, 'Nokia Browser', VersionFactory::detectVersion($useragent, ['BrowserNG', 'NokiaBrowser']), 'Nokia', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/twitter for i/i', $useragent)) {
            return new Browser($useragent, 'Twitter App', new Version(0), 'Twitter', $bits, new UaBrowserType\Application(), true, true, true, false, true, true, true);
        } elseif (preg_match('/twitterbot/i', $useragent)) {
            return new Browser($useragent, 'Twitterbot', VersionFactory::detectVersion($useragent, ['Twitterbot']), 'Twitter', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/GSA/', $useragent)) {
            return new Browser($useragent, 'Google App', VersionFactory::detectVersion($useragent, [            'GSA',        ]), 'Google', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/QtCarBrowser/', $useragent)) {
            return new Browser($useragent, 'Model S Browser', VersionFactory::detectVersion($useragent, ['QtCarBrowser']), 'TeslaMotors', $bits, new UaBrowserType\Browser(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Qt/', $useragent)) {
            return new Browser($useragent, 'Qt', VersionFactory::detectVersion($useragent, ['Qt']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Instagram/', $useragent)) {
            return new Browser($useragent, 'Instagram App', VersionFactory::detectVersion($useragent, ['Instagram']), 'Facebook', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (preg_match('/WebClip/', $useragent)) {
            return new Browser($useragent, 'WebClip App', VersionFactory::detectVersion($useragent, ['Webclip', 'WebClip']), 'Unknown', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Mercury/', $useragent)) {
            return new Browser($useragent, 'Mercury', VersionFactory::detectVersion($useragent, ['Mercury3', 'Mercury', 'Mercury3Free']), 'IlegendSoft', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/MacAppStore/', $useragent)) {
            return new Browser($useragent, 'MacAppStore', VersionFactory::detectVersion($useragent, ['MacAppStore']), 'Apple', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/AppStore/', $useragent)) {
            return new Browser($useragent, 'Apple AppStore App', VersionFactory::detectVersion($useragent, ['AppStore']), 'Apple', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Webglance/', $useragent)) {
            return new Browser($useragent, 'Web Glance', VersionFactory::detectVersion($useragent, ['Webglance']), 'Webglance', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/YHOO\_Search\_App/', $useragent)) {
            return new Browser($useragent, 'Yahoo Mobile App', VersionFactory::detectVersion($useragent, ['YHOO\_Search\_App']), 'Yahoo', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/NewsBlur Feed Fetcher/', $useragent)) {
            return new Browser($useragent, 'NewsBlur Feed Fetcher', VersionFactory::detectVersion($useragent, ['NewsBlur Feed Fetcher']), 'NewsBlur', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/AppleCoreMedia/', $useragent)) {
            return new Browser($useragent, 'CoreMedia', VersionFactory::detectVersion($useragent, ['CoreMedia v']), 'Apple', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (preg_match('/dataaccessd/', $useragent)) {
            return new Browser($useragent, 'iOS dataaccessd', VersionFactory::detectVersion($useragent, ['dataaccessd']), 'Apple', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/MailChimp/', $useragent)) {
            return new Browser($useragent, 'MailChimp.com', VersionFactory::detectVersion($useragent, ['MailChimp\.com']), 'TheRocketScienceGroup', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/MailBar/', $useragent)) {
            return new Browser($useragent, 'MailBar', VersionFactory::detectVersion($useragent, ['MailBar']), 'MailBar', $bits, new UaBrowserType\EmailClient(), true, false, false, false, true, true, true);
        } elseif (preg_match('/^Mail/', $useragent)) {
            return new Browser($useragent, 'Apple Mail', VersionFactory::detectVersion($useragent, ['Mail']), 'Apple', $bits, new UaBrowserType\EmailClient(), true, false, true, true, true, true, true);
        } elseif (preg_match('/^Mozilla\/5\.0.*\(.*(CPU iPhone OS|CPU OS) \d+(_|\.)\d+.* like Mac OS X.*\) AppleWebKit.* \(KHTML, like Gecko\)$/', $useragent)) {
            return new Browser($useragent, 'Apple Mail', VersionFactory::detectVersion($useragent, ['Mail']), 'Apple', $bits, new UaBrowserType\EmailClient(), true, false, true, true, true, true, true);
        } elseif (preg_match('/^Mozilla\/5\.0 \(Macintosh; Intel Mac OS X.*\) AppleWebKit.* \(KHTML, like Gecko\)$/', $useragent)) {
            return new Browser($useragent, 'Apple Mail', VersionFactory::detectVersion($useragent, ['Mail']), 'Apple', $bits, new UaBrowserType\EmailClient(), true, false, true, true, true, true, true);
        } elseif (preg_match('/^Mozilla\/5\.0 \(Windows.*\) AppleWebKit.* \(KHTML, like Gecko\)$/', $useragent)) {
            return new Browser($useragent, 'Apple Mail', VersionFactory::detectVersion($useragent, ['Mail']), 'Apple', $bits, new UaBrowserType\EmailClient(), true, false, true, true, true, true, true);
        } elseif (preg_match('/msnbot\-media/i', $useragent)) {
            return new Browser($useragent, 'msnbot-media', VersionFactory::detectVersion($useragent, ['MsnBot\-Media ', 'msnbot\-media']), 'Microsoft', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/adidxbot/i', $useragent)) {
            return new Browser($useragent, 'adidxbot', VersionFactory::detectVersion($useragent, ['adidxbot']), 'Microsoft', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/msnbot/i', $useragent)) {
            return new Browser($useragent, 'BingBot', VersionFactory::detectVersion($useragent, ['bingbot', 'Bing', 'Bing for iPad', 'msnbot']), 'Microsoft', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(backberry|bb10)/i', $useragent)) {
            return new Browser($useragent, 'BlackBerry', VersionFactory::detectVersion($useragent, [            'BlackBerry[0-9a-z]+',            'BlackBerrySimulator',            'Version',        ]), 'Rim', $bits, new UaBrowserType\Browser(), false, false, true, true, true, true, true);
        } elseif (preg_match('/WeTab\-Browser/', $useragent)) {
            return new Browser($useragent, 'WeTab Browser', new Version(0), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/profiller/', $useragent)) {
            return new Browser($useragent, 'profiller', VersionFactory::detectVersion($useragent, ['profiller']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(wkhtmltopdf)/i', $useragent)) {
            return new Browser($useragent, 'wkhtmltopdf', VersionFactory::detectVersion($useragent, ['wkhtmltopdf']), 'WkHtmltopdfOrg', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (preg_match('/(wkhtmltoimage)/i', $useragent)) {
            return new Browser($useragent, 'wkhtmltoimage', VersionFactory::detectVersion($useragent, ['wkhtmltoimage']), 'WkHtmltopdfOrg', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (preg_match('/(wp\-iphone|wp\-android)/', $useragent)) {
            return new Browser($useragent, 'WordPress App', VersionFactory::detectVersion($useragent, ['wp\-iphone', 'wp\-android']), 'WordPress', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/OktaMobile/', $useragent)) {
            return new Browser($useragent, 'Okta Mobile App', VersionFactory::detectVersion($useragent, ['OktaMobile']), 'Okta', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/kmail2/', $useragent)) {
            return new Browser($useragent, 'KMail2', VersionFactory::detectVersion($useragent, ['kmail2']), 'Kde', $bits, new UaBrowserType\EmailClient(), true, false, true, false, true, true, true);
        } elseif (preg_match('/eb\-iphone/', $useragent)) {
            return new Browser($useragent, 'EB iPhone/IPad App', VersionFactory::detectVersion($useragent, ['eb\-iphone']), 'Unknown', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (preg_match('/ElmediaPlayer/', $useragent)) {
            return new Browser($useragent, 'Elmedia Player', VersionFactory::detectVersion($useragent, ['ElmediaPlayer']), 'EltimaSoftware', $bits, new UaBrowserType\MultimediaPlayer(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Schoolwires/', $useragent)) {
            return new Browser($useragent, 'Schoolwires App', VersionFactory::detectVersion($useragent, ['Schoolwires']), 'Schoolwires', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Dreamweaver/', $useragent)) {
            return new Browser($useragent, 'Dreamweaver', VersionFactory::detectVersion($useragent, ['Dreamweaver']), 'Adobe', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (preg_match('/akregator/', $useragent)) {
            return new Browser($useragent, 'akregator', VersionFactory::detectVersion($useragent, ['Akregator']), 'Kde', $bits, new UaBrowserType\FeedReader(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Installatron/', $useragent)) {
            return new Browser($useragent, 'Installatron', VersionFactory::detectVersion($useragent, ['Version', 'Installatron']), 'Installatron', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Quora Link Preview/', $useragent)) {
            return new Browser($useragent, 'Quora Link Preview Bot', VersionFactory::detectVersion($useragent, ['Quora Link Preview']), 'Quora', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Quora/', $useragent)) {
            return new Browser($useragent, 'Quora App', VersionFactory::detectVersion($useragent, ['Quora']), 'Quora', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Rocky ChatWork Mobile/', $useragent)) {
            return new Browser($useragent, 'Rocky ChatWork Mobile', VersionFactory::detectVersion($useragent, ['Rocky ChatWork Mobile']), 'ChatWork', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/AdsBot\-Google\-Mobile/', $useragent)) {
            return new Browser($useragent, 'AdsBot Google-Mobile', VersionFactory::detectVersion($useragent, ['AdsBot\-Google\-Mobile']), 'Google', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/epiphany/i', $useragent)) {
            return new Browser($useragent, 'Epiphany', VersionFactory::detectVersion($useragent, ['Epiphany', 'Version', 'Safari', 'AppleWebKit']), 'TheGnomeProject', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/rekonq/', $useragent)) {
            return new Browser($useragent, 'rekonq', VersionFactory::detectVersion($useragent, ['Version', 'rekonq']), 'Kde', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Skyfire/', $useragent)) {
            return new Browser($useragent, 'Skyfire', VersionFactory::detectVersion($useragent, ['Skyfire']), 'Opera', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/FlixsteriOS/', $useragent)) {
            return new Browser($useragent, 'Flixster App', VersionFactory::detectVersion($useragent, ['FlixsteriOS']), 'Flixster', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(adbeat\_bot|adbeat\.com)/', $useragent)) {
            return new Browser($useragent, 'Adbeat Bot', VersionFactory::detectVersion($useragent, ['adbeat\.com']), 'Adbeat', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(SecondLife|Second Life)/', $useragent)) {
            return new Browser($useragent, 'Second Live Client', VersionFactory::detectVersion($useragent, ['SecondLife']), 'LindenLabs', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(Salesforce1|SalesforceTouchContainer)/', $useragent)) {
            return new Browser($useragent, 'SalesForce App', VersionFactory::detectVersion($useragent, ['Salesforce1']), 'Salesforce', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(nagios\-plugins|check\_http)/', $useragent)) {
            return new Browser($useragent, 'Nagios', VersionFactory::detectVersion($useragent, ['nagios\-plugins', 'check_http']), 'NagiosEnterprises', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/bingbot/i', $useragent)) {
            return new Browser($useragent, 'BingBot', VersionFactory::detectVersion($useragent, ['bingbot', 'Bing', 'Bing for iPad', 'msnbot']), 'Microsoft', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Mediapartners\-Google/', $useragent)) {
            return new Browser($useragent, 'AdSense Bot', VersionFactory::detectVersion($useragent, ['Mediapartners\-Google']), 'Google', $bits, new UaBrowserType\BotTrancoder(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SMTBot/', $useragent)) {
            return new Browser($useragent, 'SMTBot', VersionFactory::detectVersion($useragent, ['SMTBot']), 'SimilarTech', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/domain\.com/', $useragent)) {
            return new Browser($useragent, 'PagePeeker Screenshot Maker', new Version(0), 'PagePeeker', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/PagePeeker/', $useragent)) {
            return new Browser($useragent, 'PagePeeker', VersionFactory::detectVersion($useragent, ['PagePeeker']), 'PagePeeker', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/DiigoBrowser/', $useragent)) {
            return new Browser($useragent, 'Diigo Browser', VersionFactory::detectVersion($useragent, ['Version', 'DiigoBrowser']), 'Diigo', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/kontact/', $useragent)) {
            return new Browser($useragent, 'Kontact', VersionFactory::detectVersion($useragent, ['kontact']), 'Kde', $bits, new UaBrowserType\EmailClient(), true, false, true, true, true, true, true);
        } elseif (preg_match('/QupZilla/', $useragent)) {
            return new Browser($useragent, 'QupZilla', VersionFactory::detectVersion($useragent, ['QupZilla']), 'DavidRosca', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/FxiOS/', $useragent)) {
            return new Browser($useragent, 'Firefox for iOS', VersionFactory::detectVersion($useragent, ['FxiOS']), 'MozillaFoundation', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/qutebrowser/', $useragent)) {
            return new Browser($useragent, 'qutebrowser', VersionFactory::detectVersion($useragent, ['qutebrowser']), 'FlorianBruhin', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Otter/', $useragent)) {
            return new Browser($useragent, 'Otter', VersionFactory::detectVersion($useragent, ['Otter']), 'OtterBrowserOrg', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/PaleMoon/', $useragent)) {
            return new Browser($useragent, 'PaleMoon', VersionFactory::detectVersion($useragent, ['PaleMoon']), 'MoonchildProductions', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/slurp/i', $useragent)) {
            return new Browser($useragent, 'Slurp', new Version(0), 'Yahoo', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/applebot/i', $useragent)) {
            return new Browser($useragent, 'Applebot', VersionFactory::detectVersion($useragent, ['Applebot']), 'Apple', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SoundCloud/', $useragent)) {
            return new Browser($useragent, 'SoundCloud App', VersionFactory::detectVersion($useragent, ['SoundCloud']), 'SoundCloud', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Rival IQ/', $useragent)) {
            return new Browser($useragent, 'Rival IQ Bot', VersionFactory::detectVersion($useragent, ['Rival IQ']), 'RivalIq', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Evernote Clip Resolver/', $useragent)) {
            return new Browser($useragent, 'Evernote Clip Resolver', VersionFactory::detectVersion($useragent, ['Evernote Clip Resolver']), 'Evernote', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Evernote/', $useragent)) {
            return new Browser($useragent, 'Evernote App', new Version(0), 'Evernote', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Fluid/', $useragent)) {
            return new Browser($useragent, 'Fluid', VersionFactory::detectVersion($useragent, ['Fluid']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/safari/i', $useragent)) {
            return new Browser($useragent, 'Safari', Safari::detectVersion($useragent), 'Apple', $bits, new UaBrowserType\Browser(), true, true, true, true, true, true, true);
        } elseif (preg_match('/^Mozilla\/(4|5)\.0 \(Macintosh; .* Mac OS X .*\) AppleWebKit\/.* \(KHTML, like Gecko\) Version\/[\d\.]+$/i', $useragent)) {
            return new Browser($useragent, 'Safari', Safari::detectVersion($useragent), 'Apple', $bits, new UaBrowserType\Browser(), true, true, true, true, true, true, true);
        } elseif (preg_match('/TWCAN\/SportsNet/', $useragent)) {
            return new Browser($useragent, 'TWC SportsNet', new Version(0), 'TimeWarnerCable', $bits, new UaBrowserType\Application(), true, true, true, false, true, true, true);
        } elseif (preg_match('/AdobeAIR/', $useragent)) {
            return new Browser($useragent, 'Adobe AIR', VersionFactory::detectVersion($useragent, ['AdobeAIR']), 'Adobe', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (preg_match('/(easouspider)/i', $useragent)) {
            return new Browser($useragent, 'EasouSpider', VersionFactory::detectVersion($useragent, ['EasouSpider']), 'Easou', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/^Mozilla\/5\.0.*\((iPhone|iPad|iPod).*\).*AppleWebKit\/.*\(.*KHTML, like Gecko.*\).*Mobile.*/i', $useragent)) {
            return new Browser($useragent, 'Mobile Safari UIWebView', new Version(0), 'Apple', $bits, new UaBrowserType\Browser(), true, true, true, true, true, true, true);
        } elseif (preg_match('/waterfox/i', $useragent)) {
            return new Browser($useragent, 'Waterfox', VersionFactory::detectVersion($useragent, ['WaterFox', 'Waterfox']), 'WaterfoxProject', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Thunderbird/', $useragent)) {
            return new Browser($useragent, 'Thunderbird', VersionFactory::detectVersion($useragent, ['Thunderbird']), 'MozillaFoundation', $bits, new UaBrowserType\EmailClient(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Fennec/', $useragent)) {
            return new Browser($useragent, 'Fennec', VersionFactory::detectVersion($useragent, [            'Fennec',        ]), 'MozillaFoundation', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/myibrow/', $useragent)) {
            return new Browser($useragent, 'My Internet Browser', VersionFactory::detectVersion($useragent, ['myibrow']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Daumoa/', $useragent)) {
            return new Browser($useragent, 'Daumoa', VersionFactory::detectVersion($useragent, ['Daumoa']), 'DaumCorporation', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/PaleMoon/', $useragent)) {
            return new Browser($useragent, 'PaleMoon', VersionFactory::detectVersion($useragent, ['PaleMoon']), 'MoonchildProductions', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/iceweasel/i', $useragent)) {
            return new Browser($useragent, 'Iceweasel', VersionFactory::detectVersion($useragent, ['Iceweasel', 'Firefox']), 'SoftwareInThePublicInterest', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/icecat/i', $useragent)) {
            return new Browser($useragent, 'IceCat', VersionFactory::detectVersion($useragent, ['IceCat']), 'Gnu', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/iceape/i', $useragent)) {
            return new Browser($useragent, 'Iceape', VersionFactory::detectVersion($useragent, ['Iceape']), 'SoftwareInThePublicInterest', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/galeon/i', $useragent)) {
            return new Browser($useragent, 'Galeon', VersionFactory::detectVersion($useragent, ['Galeon']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/SurveyBot/', $useragent)) {
            return new Browser($useragent, 'SurveyBot', VersionFactory::detectVersion($useragent, ['SurveyBot']), 'DomainTools', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/aggregator\:Spinn3r/', $useragent)) {
            return new Browser($useragent, 'Spinn3r RSS Aggregator', VersionFactory::detectVersion($useragent, ['Spinn3r']), 'Tailrank', $bits, new UaBrowserType\BotSyndicationReader(), true, false, false, false, true, true, true);
        } elseif (preg_match('/TweetmemeBot/', $useragent)) {
            return new Browser($useragent, 'Tweetmeme Bot', VersionFactory::detectVersion($useragent, ['TweetmemeBot']), 'Datasift', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Butterfly/', $useragent)) {
            return new Browser($useragent, 'Butterfly Robot', VersionFactory::detectVersion($useragent, ['Butterfly']), 'TopsyLabs', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/James BOT/', $useragent)) {
            return new Browser($useragent, 'JamesBOT', VersionFactory::detectVersion($useragent, ['fr-crawler']), 'Geskimo', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/MSIE or Firefox mutant; not on Windows server/', $useragent)) {
            return new Browser($useragent, 'Daumoa', VersionFactory::detectVersion($useragent, ['Daumoa']), 'DaumCorporation', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SailfishBrowser/', $useragent)) {
            return new Browser($useragent, 'Sailfish Browser', VersionFactory::detectVersion($useragent, ['SailfishBrowser']), 'Jolla', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/KcB/', $useragent)) {
            return new Browser($useragent, 'unknown', new Version(0), 'Unknown', $bits, new UaBrowserType\Unknown(), true, false, false, false, true, true, true);
        } elseif (preg_match('/kazehakase/i', $useragent)) {
            return new Browser($useragent, 'Kazehakase', VersionFactory::detectVersion($useragent, ['Kazehakase']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/cometbird/i', $useragent)) {
            return new Browser($useragent, 'CometBird', VersionFactory::detectVersion($useragent, ['CometBird']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Camino/', $useragent)) {
            return new Browser($useragent, 'Camino', VersionFactory::detectVersion($useragent, ['Camino']), 'MozillaFoundation', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/SlimerJS/', $useragent)) {
            return new Browser($useragent, 'SlimerJS', VersionFactory::detectVersion($useragent, ['SlimerJS']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/MultiZilla/', $useragent)) {
            return new Browser($useragent, 'MultiZilla', VersionFactory::detectVersion($useragent, ['MultiZilla']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Minimo/', $useragent)) {
            return new Browser($useragent, 'Minimo', VersionFactory::detectVersion($useragent, ['Minimo']), 'MozillaFoundation', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/MicroB/', $useragent)) {
            return new Browser($useragent, 'MicroB', VersionFactory::detectVersion($useragent, ['MicroB']), 'Nokia', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/firefox/i', $useragent)
            && !preg_match('/gecko/i', $useragent)
            && preg_match('/anonymized/i', $useragent)
        ) {
            return new Browser($useragent, 'Firefox', VersionFactory::detectVersion($useragent, [            'Firefox',            'Minefield',            'Shiretoko',            'BonEcho',            'Namoroka',            'Fennec',        ]), 'MozillaFoundation', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/(firefox|minefield|shiretoko|bonecho|namoroka)/i', $useragent)) {
            return new Browser($useragent, 'Firefox', VersionFactory::detectVersion($useragent, [            'Firefox',            'Minefield',            'Shiretoko',            'BonEcho',            'Namoroka',            'Fennec',        ]), 'MozillaFoundation', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/gvfs/', $useragent)) {
            return new Browser($useragent, 'gvfs', VersionFactory::detectVersion($useragent, ['gvfs']), 'TheGnomeProject', $bits, new UaBrowserType\Tool(), true, false, false, false, true, true, true);
        } elseif (preg_match('/luakit/', $useragent)) {
            return new Browser($useragent, 'luakit', VersionFactory::detectVersion($useragent, ['WebKitGTK\+']), 'MasonLarobina', $bits, new UaBrowserType\Browser(), true, false, false, false, true, true, true);
        } elseif (preg_match('/playstation 3/i', $useragent)) {
            return new Browser($useragent, 'NetFront', VersionFactory::detectVersion($useragent, ['NetFront', 'NF', 'NetFrontLifeBrowser', 'NF3']), 'Access', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/sistrix/i', $useragent)) {
            return new Browser($useragent, 'Sistrix Crawler', new Version(0), 'Sistrix', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ezooms/i', $useragent)) {
            return new Browser($useragent, 'Ezooms', VersionFactory::detectVersion($useragent, ['Ezooms']), 'SeoMoz', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/grapefx/i', $useragent)) {
            return new Browser($useragent, 'grapeFX', VersionFactory::detectVersion($useragent, ['grapeFX']), 'GrapeshotLimited', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/grapeshotcrawler/i', $useragent)) {
            return new Browser($useragent, 'GrapeshotCrawler', VersionFactory::detectVersion($useragent, ['GrapeshotCrawler']), 'GrapeshotLimited', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(mail\.ru)/i', $useragent)) {
            return new Browser($useragent, 'Mail.Ru', VersionFactory::detectVersion($useragent, ['Mail\.RU_Bot\/Fast', 'Mail\.RU_Bot', 'Mail\.RU']), 'MailRu', $bits, new UaBrowserType\Bot(), true, false, true, false, true, true, true);
        } elseif (preg_match('/(proximic)/i', $useragent)) {
            return new Browser($useragent, 'proximic', VersionFactory::detectVersion($useragent, ['proximic']), 'Proximic', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(polaris)/i', $useragent)) {
            return new Browser($useragent, 'Polaris', VersionFactory::detectVersion($useragent, ['Polaris']), 'Infraware', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (preg_match('/(another web mining tool|awmt)/i', $useragent)) {
            return new Browser($useragent, 'Another Web Mining Tool', VersionFactory::detectVersion($useragent, ['Another Web Mining Tool']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, true, false, true, true, true);
        } elseif (preg_match('/(wbsearchbot|wbsrch)/i', $useragent)) {
            return new Browser($useragent, 'WBSearchBot', VersionFactory::detectVersion($useragent, ['WBSearchBot', 'WbSrch']), 'Warebay', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(konqueror)/i', $useragent)) {
            return new Browser($useragent, 'Konqueror', VersionFactory::detectVersion($useragent, ['Konqueror', 'konqueror']), 'Kde', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/(typo3\-linkvalidator)/i', $useragent)) {
            return new Browser($useragent, 'TYPO3 Linkvalidator', VersionFactory::detectVersion($useragent, ['TYPO3\-linkvalidator']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/feeddlerrss/i', $useragent)) {
            return new Browser($useragent, 'Feeddler RSS Reader', VersionFactory::detectVersion($useragent, ['FeeddlerRSS']), 'CheBinLiu', $bits, new UaBrowserType\FeedReader(), true, false, false, false, true, true, true);
        } elseif (preg_match('/^mozilla\/5\.0 \((iphone|ipad|ipod).*CPU like Mac OS X.*\) AppleWebKit\/\d+/i', $useragent)) {
            return new Browser($useragent, 'Safari', Safari::detectVersion($useragent), 'Apple', $bits, new UaBrowserType\Browser(), true, true, true, true, true, true, true);
        } elseif (preg_match('/(ios|iphone|ipad|ipod)/i', $useragent)) {
            return new Browser($useragent, 'Mobile Safari UIWebView', new Version(0), 'Apple', $bits, new UaBrowserType\Browser(), true, true, true, true, true, true, true);
        } elseif (preg_match('/paperlibot/i', $useragent)) {
            return new Browser($useragent, 'Paper.li Bot', VersionFactory::detectVersion($useragent, ['PaperLiBot']), 'PaperLi', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/spbot/i', $useragent)) {
            return new Browser($useragent, 'SEOprofiler', VersionFactory::detectVersion($useragent, ['spbot', 'sp_auditbot']), 'Axandra', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/dotbot/i', $useragent)) {
            return new Browser($useragent, 'DotBot', VersionFactory::detectVersion($useragent, ['DotBot']), 'SeoMoz', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(google\-structureddatatestingtool|Google\-structured\-data\-testing\-tool)/i', $useragent)) {
            return new Browser($useragent, 'Google Structured-Data TestingTool', new Version(0), 'Google', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/webmastercoffee/i', $useragent)) {
            return new Browser($useragent, 'WebmasterCoffee', VersionFactory::detectVersion($useragent, ['WebmasterCoffee']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ahrefs/i', $useragent)) {
            return new Browser($useragent, 'AhrefsBot', VersionFactory::detectVersion($useragent, ['AhrefsBot']), 'Ahrefs', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/apercite/i', $useragent)) {
            return new Browser($useragent, 'Apercite', VersionFactory::detectVersion($useragent, ['Apercite']), 'Apercite', $bits, new UaBrowserType\Bot(), true, false, true, false, true, true, true);
        } elseif (preg_match('/woobot/', $useragent)) {
            return new Browser($useragent, 'WooRank', VersionFactory::detectVersion($useragent, ['woobot']), 'WooRank', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Blekkobot/', $useragent)) {
            return new Browser($useragent, 'BlekkoBot', VersionFactory::detectVersion($useragent, ['Blekkobot']), 'BlekkoCom', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/PagesInventory/', $useragent)) {
            return new Browser($useragent, 'PagesInventory Bot', VersionFactory::detectVersion($useragent, ['PagesInventory']), 'PagesInventory', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Slackbot\-LinkExpanding/', $useragent)) {
            return new Browser($useragent, 'Slackbot-Link-Expanding', VersionFactory::detectVersion($useragent, ['Slackbot\-LinkExpanding']), 'Slack', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Slackbot/', $useragent)) {
            return new Browser($useragent, 'Slackbot', VersionFactory::detectVersion($useragent, ['Slackbot']), 'Slack', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SEOkicks\-Robot/', $useragent)) {
            return new Browser($useragent, 'SEOkicks Robot', new Version(0), 'TorstenRueckertInternetdienstleistungen', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Exabot/', $useragent)) {
            return new Browser($useragent, 'Exabot', VersionFactory::detectVersion($useragent, ['Exabot']), 'DassaultSystemes', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/DomainSCAN/', $useragent)) {
            return new Browser($useragent, 'DomainScan Server Monitoring', VersionFactory::detectVersion($useragent, ['DomainSCAN']), 'GhSoftware', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/JobRoboter/', $useragent)) {
            return new Browser($useragent, 'JobRoboter', VersionFactory::detectVersion($useragent, ['JobRoboter']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/AcoonBot/', $useragent)) {
            return new Browser($useragent, 'AcoonBot', VersionFactory::detectVersion($useragent, ['AcoonBot']), 'MichaelSchoebel', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/woriobot/', $useragent)) {
            return new Browser($useragent, 'woriobot', new Version(0), 'Flipboard', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/MonoBot/', $useragent)) {
            return new Browser($useragent, 'MonoBot', VersionFactory::detectVersion($useragent, ['MonoBot']), 'Mono', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/DomainSigmaCrawler/', $useragent)) {
            return new Browser($useragent, 'DomainSigmaCrawler', VersionFactory::detectVersion($useragent, ['DomainSigmaCrawler']), 'DomainSigma', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/bnf\.fr\_bot/', $useragent)) {
            return new Browser($useragent, 'bnf.fr Bot', VersionFactory::detectVersion($useragent, ['bnf.fr_bot']), 'BibliothequeNationaledeFrance', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/CrawlRobot/', $useragent)) {
            return new Browser($useragent, 'CrawlRobot', VersionFactory::detectVersion($useragent, ['CrawlRobot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/AddThis\.com robot/', $useragent)) {
            return new Browser($useragent, 'AddThis.com robot', VersionFactory::detectVersion($useragent, ['AddThis\.com robot']), 'AddThis', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(Yeti|naver\.com\/robots)/', $useragent)) {
            return new Browser($useragent, 'NaverBot', VersionFactory::detectVersion($useragent, ['Naver', 'Yeti']), 'NhnCorporation', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/^robots$/', $useragent)) {
            return new Browser($useragent, 'TestCrawler', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/DeuSu/', $useragent)) {
            return new Browser($useragent, 'Werbefreie Deutsche Suchmaschine', VersionFactory::detectVersion($useragent, ['DeuSu']), 'MichaelSchoebel', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/obot/i', $useragent)) {
            return new Browser($useragent, 'oBot', VersionFactory::detectVersion($useragent, ['oBot']), 'Ibm', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ZumBot/', $useragent)) {
            return new Browser($useragent, 'ZumBot', VersionFactory::detectVersion($useragent, ['ZumBot']), 'ZuminternetCorp', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(umbot)/i', $useragent)) {
            return new Browser($useragent, 'uMBot', VersionFactory::detectVersion($useragent, ['uMBot\-LN']), 'UbermetricsTechnologies', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(picmole)/i', $useragent)) {
            return new Browser($useragent, 'picmole Bot', VersionFactory::detectVersion($useragent, ['picmole']), 'Picmole', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(zollard)/i', $useragent)) {
            return new Browser($useragent, 'Zollard Worm', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(fhscan core)/i', $useragent)) {
            return new Browser($useragent, 'FHScan Core', VersionFactory::detectVersion($useragent, ['FHScan Core']), 'Tarasco', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/nbot/i', $useragent)) {
            return new Browser($useragent, 'nbot', VersionFactory::detectVersion($useragent, ['nbot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(loadtimebot)/i', $useragent)) {
            return new Browser($useragent, 'LoadTimeBot', VersionFactory::detectVersion($useragent, ['LoadTimeBot']), 'LoadTime', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(scrubby)/i', $useragent)) {
            return new Browser($useragent, 'Scrubby', VersionFactory::detectVersion($useragent, ['Scrubby']), 'ScrubTheWeb', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(squzer)/i', $useragent)) {
            return new Browser($useragent, 'Squzer', VersionFactory::detectVersion($useragent, ['Squzer']), 'Declum', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/PiplBot/', $useragent)) {
            return new Browser($useragent, 'PiplBot', VersionFactory::detectVersion($useragent, ['PiplBot']), 'Pipl', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/EveryoneSocialBot/', $useragent)) {
            return new Browser($useragent, 'EveryoneSocialBot', VersionFactory::detectVersion($useragent, ['EveryoneSocialBot']), 'EveryoneSocial', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/AOLbot/', $useragent)) {
            return new Browser($useragent, 'AOLbot', VersionFactory::detectVersion($useragent, ['AOLbot']), 'AolSoft', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/GLBot/', $useragent)) {
            return new Browser($useragent, 'GLBot', VersionFactory::detectVersion($useragent, ['GLBot']), 'GalaxyDownloads', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(lbot)/i', $useragent)) {
            return new Browser($useragent, 'lbot', VersionFactory::detectVersion($useragent, ['lbot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(blexbot)/i', $useragent)) {
            return new Browser($useragent, 'BLEXBot', VersionFactory::detectVersion($useragent, ['BLEXBot']), 'WebmeupCrawlerCom', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(socialradarbot)/i', $useragent)) {
            return new Browser($useragent, 'Socialradar Bot', VersionFactory::detectVersion($useragent, ['Socialradarbot']), 'Infegy', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(synapse)/i', $useragent)) {
            return new Browser($useragent, 'Apache Synapse', VersionFactory::detectVersion($useragent, ['Synapse']), 'Apache', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(linkdexbot)/i', $useragent)) {
            return new Browser($useragent, 'Linkdex Bot', VersionFactory::detectVersion($useragent, ['linkdexbot']), 'Linkdex', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(coccoc)/i', $useragent)) {
            return new Browser($useragent, 'Coccoc bot', VersionFactory::detectVersion($useragent, ['coccoc']), 'CocCocCompany', $bits, new UaBrowserType\Bot(), true, false, true, true, true, true, true);
        } elseif (preg_match('/(siteexplorer)/i', $useragent)) {
            return new Browser($useragent, 'SiteExplorer', VersionFactory::detectVersion($useragent, ['SiteExplorer']), 'SiteExplorer', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(semrushbot)/i', $useragent)) {
            return new Browser($useragent, 'SemrushBot', VersionFactory::detectVersion($useragent, ['SemrushBot']), 'Semrush', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(istellabot)/i', $useragent)) {
            return new Browser($useragent, 'IstellaBot', VersionFactory::detectVersion($useragent, ['IstellaBot']), 'Tiscali', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(meanpathbot)/i', $useragent)) {
            return new Browser($useragent, 'meanpathbot', VersionFactory::detectVersion($useragent, ['meanpathbot']), 'Meanpath', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(XML Sitemaps Generator)/', $useragent)) {
            return new Browser($useragent, 'XML Sitemaps Generator', VersionFactory::detectVersion($useragent, ['XML\-Sitemaps']), 'XmlSitemaps', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SeznamBot/', $useragent)) {
            return new Browser($useragent, 'SeznamBot', VersionFactory::detectVersion($useragent, ['SeznamBot']), 'Seznam', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/URLAppendBot/', $useragent)) {
            return new Browser($useragent, 'URLAppendBot', VersionFactory::detectVersion($useragent, ['URLAppendBot']), 'ProfoundNetworks', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/NetSeer crawler/', $useragent)) {
            return new Browser($useragent, 'NetSeer Crawler', VersionFactory::detectVersion($useragent, ['NetSeer crawler']), 'NetSeer', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SeznamBot/', $useragent)) {
            return new Browser($useragent, 'SeznamBot', VersionFactory::detectVersion($useragent, ['SeznamBot']), 'Seznam', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Add Catalog/', $useragent)) {
            return new Browser($useragent, 'Add Catalog', VersionFactory::detectVersion($useragent, ['Add Catalog']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Moreover/', $useragent)) {
            return new Browser($useragent, 'Moreover', VersionFactory::detectVersion($useragent, ['Moreover']), 'MoreoverTechnologies', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/LinkpadBot/', $useragent)) {
            return new Browser($useragent, 'LinkpadBot', VersionFactory::detectVersion($useragent, ['LinkpadBot']), 'LinkPad', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Lipperhey SEO Service/', $useragent)) {
            return new Browser($useragent, 'Lipperhey SEO Service', VersionFactory::detectVersion($useragent, ['Lipperhey SEO Service']), 'Lipperhey', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Blog Search/', $useragent)) {
            return new Browser($useragent, 'Blog Search', VersionFactory::detectVersion($useragent, ['Blog Search']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Qualidator\.com Bot/', $useragent)) {
            return new Browser($useragent, 'Qualidator.com Bot', VersionFactory::detectVersion($useragent, ['Qualidator\.com Bot']), 'Qualidator', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/fr\-crawler/', $useragent)) {
            return new Browser($useragent, 'fr-crawler', VersionFactory::detectVersion($useragent, ['fr-crawler']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ca\-crawler/', $useragent)) {
            return new Browser($useragent, 'ca-crawler', VersionFactory::detectVersion($useragent, ['ca-crawler']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Website Thumbnail Generator/', $useragent)) {
            return new Browser($useragent, 'Website Thumbnail Generator', VersionFactory::detectVersion($useragent, ['WebThumbnail']), 'Webthumbnail', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/WebThumb/', $useragent)) {
            return new Browser($useragent, 'WebThumb', VersionFactory::detectVersion($useragent, ['WebThumb']), 'Boutell', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/KomodiaBot/', $useragent)) {
            return new Browser($useragent, 'KomodiaBot', VersionFactory::detectVersion($useragent, ['KomodiaBot']), 'KomodiaInc', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/GroupHigh/', $useragent)) {
            return new Browser($useragent, 'GroupHigh Bot', VersionFactory::detectVersion($useragent, ['GroupHigh']), 'GroupHigh', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/theoldreader/', $useragent)) {
            return new Browser($useragent, 'The Old Reader', VersionFactory::detectVersion($useragent, ['theoldreader']), 'TheOldReader', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Google\-Site\-Verification/', $useragent)) {
            return new Browser($useragent, 'Google-Site-Verification', VersionFactory::detectVersion($useragent, ['Google\-Site\-Verification']), 'Google', $bits, new UaBrowserType\Bot(), false, false, false, false, true, true, true);
        } elseif (preg_match('/Prlog/', $useragent)) {
            return new Browser($useragent, 'Prlog', VersionFactory::detectVersion($useragent, ['Prlog']), 'Prlog', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/CMS Crawler/', $useragent)) {
            return new Browser($useragent, 'CMS Crawler', VersionFactory::detectVersion($useragent, ['CMS Crawler']), 'Viderem', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/pmoz\.info ODP link checker/', $useragent)) {
            return new Browser($useragent, 'pmoz.info ODP link checker', VersionFactory::detectVersion($useragent, ['pmoz\.info ODP link checker']), 'PlantRob', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Twingly Recon/', $useragent)) {
            return new Browser($useragent, 'Twingly Recon', VersionFactory::detectVersion($useragent, ['Twingly Recon']), 'Twingly', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Embedly/', $useragent)) {
            return new Browser($useragent, 'Embedly', VersionFactory::detectVersion($useragent, ['Embedly']), 'Embedly', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Alexabot/', $useragent)) {
            return new Browser($useragent, 'Alexabot', VersionFactory::detectVersion($useragent, ['Alexabot']), 'AlexaInternet', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/alexa site audit/', $useragent)) {
            return new Browser($useragent, 'Alexa Site Audit', VersionFactory::detectVersion($useragent, ['alexa site audit']), 'AlexaInternet', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/MJ12bot/', $useragent)) {
            return new Browser($useragent, 'MJ12bot', VersionFactory::detectVersion($useragent, ['MJ12bot\/v', 'MJ12bot']), 'Majestic12', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/HTTrack/', $useragent)) {
            return new Browser($useragent, 'HTTrack', VersionFactory::detectVersion($useragent, ['HTTrack']), 'XavierRoche', $bits, new UaBrowserType\OfflineBrowser(), true, false, false, false, true, true, true);
        } elseif (preg_match('/UnisterBot/', $useragent)) {
            return new Browser($useragent, 'UnisterBot', VersionFactory::detectVersion($useragent, ['Unisterbot']), 'Unister', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/CareerBot/', $useragent)) {
            return new Browser($useragent, 'CareerBot', VersionFactory::detectVersion($useragent, ['CareerBot']), 'Careerx', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/80legs/i', $useragent)) {
            return new Browser($useragent, '80Legs', VersionFactory::detectVersion($useragent, ['80legs', '008']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/wada\.vn/i', $useragent)) {
            return new Browser($useragent, 'Wada.vn Search Bot', VersionFactory::detectVersion($useragent, ['Wada\.vn']), 'Wada', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(NX|WiiU|Nintendo 3DS)/', $useragent)) {
            return new Browser($useragent, 'NetFront NX', VersionFactory::detectVersion($useragent, ['NX']), 'Access', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/(netfront|playstation 4)/i', $useragent)) {
            return new Browser($useragent, 'NetFront', VersionFactory::detectVersion($useragent, ['NetFront', 'NF', 'NetFrontLifeBrowser', 'NF3']), 'Access', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/XoviBot/', $useragent)) {
            return new Browser($useragent, 'XoviBot', VersionFactory::detectVersion($useragent, ['XoviBot']), 'Xovi', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/007ac9 Crawler/', $useragent)) {
            return new Browser($useragent, '007AC9 Crawler', VersionFactory::detectVersion($useragent, ['007ac9 Crawler']), 'Sistrix', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/200PleaseBot/', $useragent)) {
            return new Browser($useragent, '200PleaseBot', VersionFactory::detectVersion($useragent, ['200PleaseBot']), 'Please200', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Abonti/', $useragent)) {
            return new Browser($useragent, 'Abonti WebSearch', VersionFactory::detectVersion($useragent, ['Abonti']), 'Abonti', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/publiclibraryarchive/', $useragent)) {
            return new Browser($useragent, 'publiclibraryarchive Bot', VersionFactory::detectVersion($useragent, ['publiclibraryarchive', 'publiclibraryarchive\.org']), 'PublicLibraryArchive', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/PAD\-bot/', $useragent)) {
            return new Browser($useragent, 'PAD-bot', VersionFactory::detectVersion($useragent, ['PAD\-bot']), 'InbotTechnology', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SoftListBot/', $useragent)) {
            return new Browser($useragent, 'SoftListBot', VersionFactory::detectVersion($useragent, ['SoftListBot']), 'SoftList', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/sReleaseBot/', $useragent)) {
            return new Browser($useragent, 'sReleaseBot', VersionFactory::detectVersion($useragent, ['sReleaseBot']), 'Srelease', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Vagabondo/', $useragent)) {
            return new Browser($useragent, 'Vagabondo', VersionFactory::detectVersion($useragent, ['Vagabondo']), 'WiseGuysNl', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/special\_archiver/', $useragent)) {
            return new Browser($useragent, 'Internet Archive Special Archiver', VersionFactory::detectVersion($useragent, ['special_archiver']), 'ArchiveOrg', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Optimizer/', $useragent)) {
            return new Browser($useragent, 'Optimizer Bot', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Sophora Linkchecker/', $useragent)) {
            return new Browser($useragent, 'Sophora Linkchecker', VersionFactory::detectVersion($useragent, ['Sophora Linkchecker']), 'Subshell', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SEOdiver/', $useragent)) {
            return new Browser($useragent, 'SEOdiver Bot', VersionFactory::detectVersion($useragent, ['SEOdiver']), 'Seodiver', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/itsscan/', $useragent)) {
            return new Browser($useragent, 'itsscan', new Version(0), 'MuensterUniversityOfAppliedSciences', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Google Desktop/', $useragent)) {
            return new Browser($useragent, 'Google Desktop', VersionFactory::detectVersion($useragent, ['Google Desktop']), 'Google', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Lotus\-Notes/', $useragent)) {
            return new Browser($useragent, 'Lotus Notes', VersionFactory::detectVersion($useragent, ['LotusNotes', 'Lotus\-Notes']), 'Ibm', $bits, new UaBrowserType\EmailClient(), true, false, true, false, true, true, true);
        } elseif (preg_match('/AskPeterBot/', $useragent)) {
            return new Browser($useragent, 'AskPeterBot', VersionFactory::detectVersion($useragent, ['AskPeterBot']), 'AskPeter', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/discoverybot/', $useragent)) {
            return new Browser($useragent, 'Discovery Bot', VersionFactory::detectVersion($useragent, ['discoverybot']), 'DiscoveryEngine', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/YandexBot/', $useragent)) {
            return new Browser($useragent, 'YandexBot', VersionFactory::detectVersion($useragent, ['YandexBot']), 'Yandex', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/MOSBookmarks/', $useragent) && preg_match('/Link Checker/', $useragent)) {
            return new Browser($useragent, 'MOSBookmarks Link Checker', VersionFactory::detectVersion($useragent, ['MOSBookmarks', 'MOSBookmarks\/v']), 'Tegdesign', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/MOSBookmarks/', $useragent)) {
            return new Browser($useragent, 'MOSBookmarks', VersionFactory::detectVersion($useragent, ['MOSBookmarks', 'MOSBookmarks\/v']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/WebMasterAid/', $useragent)) {
            return new Browser($useragent, 'WebMasterAid', VersionFactory::detectVersion($useragent, ['WebMasterAid']), 'Wmaid', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/AboutUsBot Johnny5/', $useragent)) {
            return new Browser($useragent, 'AboutUs Bot Johnny5', VersionFactory::detectVersion($useragent, ['AboutUsBot Johnny5']), 'AboutUs', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/AboutUsBot/', $useragent)) {
            return new Browser($useragent, 'AboutUs Bot', VersionFactory::detectVersion($useragent, ['AboutUsBot']), 'AboutUs', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/semantic\-visions\.com crawler/', $useragent)) {
            return new Browser($useragent, 'semantic-visions.com crawler', VersionFactory::detectVersion($useragent, ['semantic\-visions.com crawler; HTTPClient']), 'SemanticVisions', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/waybackarchive\.org/', $useragent)) {
            return new Browser($useragent, 'Wayback Archive Bot', VersionFactory::detectVersion($useragent, ['waybackarchive.org']), 'WaybackArchiveOrg', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/OpenVAS/', $useragent)) {
            return new Browser($useragent, 'Open Vulnerability Assessment System', new Version(0), 'Openvas', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/MixrankBot/', $useragent)) {
            return new Browser($useragent, 'MixrankBot', VersionFactory::detectVersion($useragent, ['MixrankBot']), 'OnlineMediaGroup', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/InfegyAtlas/', $useragent)) {
            return new Browser($useragent, 'InfegyAtlas', VersionFactory::detectVersion($useragent, ['InfegyAtlas']), 'Infegy', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/MojeekBot/', $useragent)) {
            return new Browser($useragent, 'MojeekBot', VersionFactory::detectVersion($useragent, ['MojeekBot']), 'Mojeek', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/memorybot/i', $useragent)) {
            return new Browser($useragent, 'memoryBot', VersionFactory::detectVersion($useragent, ['memorybot']), 'InternetMemoryFoundation', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/DomainAppender/', $useragent)) {
            return new Browser($useragent, 'DomainAppender Bot', VersionFactory::detectVersion($useragent, ['DomainAppender \/', 'DomainAppender']), 'ProfoundNetworks', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/GIDBot/', $useragent)) {
            return new Browser($useragent, 'GIDBot', VersionFactory::detectVersion($useragent, ['GIDBot']), 'JdeSilva', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/DBot/', $useragent)) {
            return new Browser($useragent, 'DBot', VersionFactory::detectVersion($useragent, ['DBot']), 'Getdownload', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/PWBot/', $useragent)) {
            return new Browser($useragent, 'PWBot', VersionFactory::detectVersion($useragent, ['PWBot']), 'Eurofiles', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/\+5Bot/', $useragent)) {
            return new Browser($useragent, 'Plus5Bot', VersionFactory::detectVersion($useragent, ['\+5Bot']), 'Plus5Files', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/WASALive\-Bot/', $useragent)) {
            return new Browser($useragent, 'WASALive Bot', VersionFactory::detectVersion($useragent, ['WASALive\-Bot']), 'WasaLive', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/OpenHoseBot/', $useragent)) {
            return new Browser($useragent, 'OpenHoseBot', VersionFactory::detectVersion($useragent, ['OpenHoseBot']), 'OpenHose', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/URLfilterDB\-crawler/', $useragent)) {
            return new Browser($useragent, 'URLfilterDB Crawler', VersionFactory::detectVersion($useragent, ['URLfilterDB\-crawler']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/metager2\-verification\-bot/', $useragent)) {
            return new Browser($useragent, 'metager2-verification-bot', new Version(0), 'SumaEv', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Powermarks/', $useragent)) {
            return new Browser($useragent, 'Powermarks', VersionFactory::detectVersion($useragent, ['Powermarks']), 'KaylonTechnologies', $bits, new UaBrowserType\Bot(), true, false, true, false, true, true, true);
        } elseif (preg_match('/CloudFlare\-AlwaysOnline/', $useragent)) {
            return new Browser($useragent, 'CloudFlare AlwaysOnline', VersionFactory::detectVersion($useragent, ['CloudFlare\-AlwaysOnline']), 'CloudFlare', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Phantom\.js bot/', $useragent)) {
            return new Browser($useragent, 'Phantom.js bot', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Phantom/', $useragent)) {
            return new Browser($useragent, 'Phantom Browser', VersionFactory::detectVersion($useragent, ['Phantom', 'Phantom\/V']), 'Lg', $bits, new UaBrowserType\Browser(), false, false, true, false, true, true, true);
        } elseif (preg_match('/Shrook/', $useragent)) {
            return new Browser($useragent, 'Shrook', new Version(0), 'UtsireSoftware', $bits, new UaBrowserType\FeedReader(), true, false, false, false, true, true, true);
        } elseif (preg_match('/netEstate NE Crawler/', $useragent)) {
            return new Browser($useragent, 'netEstate NE Crawler', VersionFactory::detectVersion($useragent, ['netEstate NE Crawler']), 'NetEstate', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/garlikcrawler/i', $useragent)) {
            return new Browser($useragent, 'GarlikCrawler', VersionFactory::detectVersion($useragent, ['GarlikCrawler']), 'Experian', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/metageneratorcrawler/i', $useragent)) {
            return new Browser($useragent, 'MetaGeneratorCrawler', VersionFactory::detectVersion($useragent, ['MetaGeneratorCrawler']), 'JanBogutzki', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ScreenerBot/', $useragent)) {
            return new Browser($useragent, 'ScreenerBot', VersionFactory::detectVersion($useragent, ['ScreenerBot Crawler Beta']), 'ScreenerBot', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/WebTarantula\.com Crawler/', $useragent)) {
            return new Browser($useragent, 'WebTarantula', VersionFactory::detectVersion($useragent, ['WebTarantula\.com Crawler']), 'Webtarantula', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/BacklinkCrawler/', $useragent)) {
            return new Browser($useragent, 'BacklinkCrawler', new Version(0), 'BacklinkTest', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/LinksCrawler/', $useragent)) {
            return new Browser($useragent, 'LinksCrawler', VersionFactory::detectVersion($useragent, ['LinksCrawler']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(ssearch\_bot|sSearch Crawler)/', $useragent)) {
            return new Browser($useragent, 'sSearch Crawler', VersionFactory::detectVersion($useragent, ['sSearch Crawler']), 'Semantissimo', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/HRCrawler/', $useragent)) {
            return new Browser($useragent, 'HRCrawler', VersionFactory::detectVersion($useragent, ['HRCrawler']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ICC\-Crawler/', $useragent)) {
            return new Browser($useragent, 'ICC-Crawler', VersionFactory::detectVersion($useragent, ['ICC\-Crawler']), 'Niict', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Arachnida Web Crawler/', $useragent)) {
            return new Browser($useragent, 'Arachnida Web Crawler', VersionFactory::detectVersion($useragent, ['Arachnida Web Crawler']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Finderlein Research Crawler/', $useragent)) {
            return new Browser($useragent, 'Finderlein Research Crawler', VersionFactory::detectVersion($useragent, ['Finderlein Research Crawler']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/TestCrawler/', $useragent)) {
            return new Browser($useragent, 'TestCrawler', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Scopia Crawler/', $useragent)) {
            return new Browser($useragent, 'Scopia Crawler', VersionFactory::detectVersion($useragent, ['Scopia Crawler']), 'Pagedesign', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Crawler/', $useragent)) {
            return new Browser($useragent, 'Crawler', VersionFactory::detectVersion($useragent, ['Crawler']), 'Linkfluence', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/MetaJobBot/', $useragent)) {
            return new Browser($useragent, 'MetaJobBot', VersionFactory::detectVersion($useragent, ['MetaJobBot']), 'ManfredSchauer', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/jig browser web/', $useragent)) {
            return new Browser($useragent, 'jig browser web', VersionFactory::detectVersion($useragent, ['jig browser web; ']), 'W3c', $bits, new UaBrowserType\Browser(), true, false, false, false, true, true, true);
        } elseif (preg_match('/T\-H\-U\-N\-D\-E\-R\-S\-T\-O\-N\-E/', $useragent)) {
            return new Browser($useragent, 'Texis Webscript', new Version(0), 'ThunderstoneSoftware', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/focuseekbot/', $useragent)) {
            return new Browser($useragent, 'focuseekbot', VersionFactory::detectVersion($useragent, ['focuseekbot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/vBSEO/', $useragent)) {
            return new Browser($useragent, 'vBulletin SEO Bot', VersionFactory::detectVersion($useragent, ['vBSEO']), 'Vbseo', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/kgbody/', $useragent)) {
            return new Browser($useragent, 'kgbody', VersionFactory::detectVersion($useragent, ['kgbody']), 'NttResonant', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/JobdiggerSpider/', $useragent)) {
            return new Browser($useragent, 'JobdiggerSpider', VersionFactory::detectVersion($useragent, ['JobdiggerSpider']), 'Jobdigger', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/imrbot/', $useragent)) {
            return new Browser($useragent, 'Mignify Bot', VersionFactory::detectVersion($useragent, ['imrbot']), 'InternetMemoryResearch', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/kulturarw3/', $useragent)) {
            return new Browser($useragent, 'kulturarw3', VersionFactory::detectVersion($useragent, ['kulturarw3']), 'NationalLibraryOfSweden', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/LucidWorks/', $useragent)) {
            return new Browser($useragent, 'Lucidworks Bot', VersionFactory::detectVersion($useragent, ['LucidWorks']), 'Lucidworks', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/MerchantCentricBot/', $useragent)) {
            return new Browser($useragent, 'MerchantCentricBot', VersionFactory::detectVersion($useragent, ['MerchantCentricBot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Nett\.io bot/', $useragent)) {
            return new Browser($useragent, 'Nett.io bot', VersionFactory::detectVersion($useragent, ['Nett\.io bot']), 'Nettio', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SemanticBot/', $useragent)) {
            return new Browser($useragent, 'SemanticBot', VersionFactory::detectVersion($useragent, ['SemanticBot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/tweetedtimes/i', $useragent)) {
            return new Browser($useragent, 'TweetedTimes Bot', VersionFactory::detectVersion($useragent, ['TweetedTimes Bot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/vkShare/', $useragent)) {
            return new Browser($useragent, 'vkShare', VersionFactory::detectVersion($useragent, ['vkShare']), 'Vk', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Yahoo Ad monitoring/', $useragent)) {
            return new Browser($useragent, 'Yahoo Ad Monitoring', VersionFactory::detectVersion($useragent, ['Yahoo Ad monitoring']), 'Yahoo', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/YioopBot/', $useragent)) {
            return new Browser($useragent, 'YioopBot', VersionFactory::detectVersion($useragent, ['YioopBot']), 'Yioop', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/zitebot/', $useragent)) {
            return new Browser($useragent, 'zitebot', VersionFactory::detectVersion($useragent, ['zitebot']), 'Flipboard', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Espial/', $useragent)) {
            return new Browser($useragent, 'Espial TV Browser', VersionFactory::detectVersion($useragent, ['Espial']), 'EspialGroup', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/SiteCon/', $useragent)) {
            return new Browser($useragent, 'SiteCon', VersionFactory::detectVersion($useragent, ['SiteCon']), 'NccGroup', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/iBooks Author/', $useragent)) {
            return new Browser($useragent, 'iBooks Author', VersionFactory::detectVersion($useragent, ['iBooks Author']), 'Apple', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/iWeb/', $useragent)) {
            return new Browser($useragent, 'iWeb', VersionFactory::detectVersion($useragent, ['iWeb']), 'Apple', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/NewsFire/', $useragent)) {
            return new Browser($useragent, 'NewsFire', VersionFactory::detectVersion($useragent, ['NewsFire']), 'DavidWatanabe', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/RMSnapKit/', $useragent)) {
            return new Browser($useragent, 'RMSnapKit', VersionFactory::detectVersion($useragent, ['RMSnapKit']), 'Realmacsoftware', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Sandvox/', $useragent)) {
            return new Browser($useragent, 'Sandvox', VersionFactory::detectVersion($useragent, ['Sandvox']), 'KareliaSoftware', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (preg_match('/TubeTV/', $useragent)) {
            return new Browser($useragent, 'TubeTV', VersionFactory::detectVersion($useragent, ['TubeTV']), 'Chimoosoft', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Elluminate Live/', $useragent)) {
            return new Browser($useragent, 'Elluminate Live', new Version(0), 'Blackboard', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Element Browser/', $useragent)) {
            return new Browser($useragent, 'Element Browser', VersionFactory::detectVersion($useragent, ['Element Browser']), 'ElementSoftware', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/K\-Meleon/', $useragent)) {
            return new Browser($useragent, 'K-Meleon', VersionFactory::detectVersion($useragent, ['K\-Meleon']), 'KmeleonBrowserOrg', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Esribot/', $useragent)) {
            return new Browser($useragent, 'Esribot', VersionFactory::detectVersion($useragent, ['Esribot']), 'Esrihu', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/QuickLook/', $useragent)) {
            return new Browser($useragent, 'QuickLook', VersionFactory::detectVersion($useragent, ['QuickLook']), 'Apple', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/dillo/i', $useragent)) {
            return new Browser($useragent, 'Dillo', VersionFactory::detectVersion($useragent, ['Dillo']), 'DilloProject', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Digg/', $useragent)) {
            return new Browser($useragent, 'Digg Bot', VersionFactory::detectVersion($useragent, ['Digg']), 'NewsMe', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Zetakey/', $useragent)) {
            return new Browser($useragent, 'Zetakey Browser', VersionFactory::detectVersion($useragent, ['Zetakey']), 'ZetakeySolutions', $bits, new UaBrowserType\Browser(), true, false, false, false, true, true, true);
        } elseif (preg_match('/getprismatic\.com/', $useragent)) {
            return new Browser($useragent, 'Prismatic App', new Version(0), 'Prismatic', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (preg_match('/(FOMA|SH05C)/', $useragent)) {
            return new Browser($useragent, 'Sharp', new Version(0), 'Sharp', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/OpenWebKitSharp/', $useragent)) {
            return new Browser($useragent, 'open-webkit-sharp', VersionFactory::detectVersion($useragent, ['OpenWebKitSharp']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, false, false, true, true, true);
        } elseif (preg_match('/AjaxSnapBot/', $useragent)) {
            return new Browser($useragent, 'AjaxSnapBot', VersionFactory::detectVersion($useragent, ['AjaxSnapBot']), 'Tockify', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Owler/', $useragent)) {
            return new Browser($useragent, 'Owler Bot', VersionFactory::detectVersion($useragent, ['Owler']), 'Owler', $bits, new UaBrowserType\Bot(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Yahoo Link Preview/', $useragent)) {
            return new Browser($useragent, 'Yahoo Link Preview', new Version(0), 'Yahoo', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/pub\-crawler/', $useragent)) {
            return new Browser($useragent, 'pub-crawler', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Kraken/', $useragent)) {
            return new Browser($useragent, 'Kraken', VersionFactory::detectVersion($useragent, ['Kraken']), 'Linkfluence', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Qwantify/', $useragent)) {
            return new Browser($useragent, 'Qwantify', VersionFactory::detectVersion($useragent, ['Qwantify']), 'Qwant', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SetLinks bot/', $useragent)) {
            return new Browser($useragent, 'SetLinks.ru Crawler', VersionFactory::detectVersion($useragent, ['SetLinks bot']), 'SetLinks', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/MegaIndex\.ru/', $useragent)) {
            return new Browser($useragent, 'MegaIndex Bot', VersionFactory::detectVersion($useragent, ['MegaIndex\.ru']), 'MegaIndex', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Cliqzbot/', $useragent)) {
            return new Browser($useragent, 'Cliqzbot', VersionFactory::detectVersion($useragent, ['Cliqzbot']), 'Tenbetterpages', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/DAWINCI ANTIPLAG SPIDER/', $useragent)) {
            return new Browser($useragent, 'DAWINCI ANTIPLAG SPIDER', VersionFactory::detectVersion($useragent, ['DAWINCI ANTIPLAG SPIDER']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/AdvBot/', $useragent)) {
            return new Browser($useragent, 'AdvBot', VersionFactory::detectVersion($useragent, ['AdvBot']), 'AdvBot', $bits, new UaBrowserType\Bot(), true, false, true, true, true, true, true);
        } elseif (preg_match('/DuckDuckGo\-Favicons\-Bot/', $useragent)) {
            return new Browser($useragent, 'DuckDuck Favicons Bot', VersionFactory::detectVersion($useragent, ['DuckDuckGo\-Favicons\-Bot']), 'DuckDuckGo', $bits, new UaBrowserType\Bot(), true, false, true, true, true, true, true);
        } elseif (preg_match('/ZyBorg/', $useragent)) {
            return new Browser($useragent, 'WiseNut search engine crawler', VersionFactory::detectVersion($useragent, ['ZyBorg']), 'LookSmart', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/HyperCrawl/', $useragent)) {
            return new Browser($useragent, 'HyperCrawl', VersionFactory::detectVersion($useragent, ['HyperCrawl']), 'SeoGraph', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ARCHIVE\.ORG\.UA crawler/', $useragent)) {
            return new Browser($useragent, 'Internet Archive', new Version(0), 'ArchiveOrg', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/worldwebheritage/', $useragent)) {
            return new Browser($useragent, 'worldwebheritage.org Bot', VersionFactory::detectVersion($useragent, ['worldwebheritage\.org']), 'GoDaddy', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/BegunAdvertising/', $useragent)) {
            return new Browser($useragent, 'Begun Advertising Bot', VersionFactory::detectVersion($useragent, ['BegunAdvertising']), 'Begun', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/TrendWinHttp/', $useragent)) {
            return new Browser($useragent, 'TrendWinHttp', VersionFactory::detectVersion($useragent, ['TrendWinHttp']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(winhttp|winhttprequest)/i', $useragent)) {
            return new Browser($useragent, 'WinHttp', VersionFactory::detectVersion($useragent, ['WinHttpRequest', 'WinHttpRequest\.']), 'Microsoft', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SkypeUriPreview/', $useragent)) {
            return new Browser($useragent, 'SkypeUriPreview', VersionFactory::detectVersion($useragent, ['SkypeUriPreview', 'Preview']), 'Microsoft', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ScoutJet/', $useragent)) {
            return new Browser($useragent, 'ScoutJet', VersionFactory::detectVersion($useragent, ['Scoutjet']), 'BlekkoCom', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Lipperhey\-Kaus\-Australis/', $useragent)) {
            return new Browser($useragent, 'Lipperhey Kaus Australis', VersionFactory::detectVersion($useragent, ['Lipperhey\-Kaus\-Australis']), 'Lipperhey', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Digincore bot/', $useragent)) {
            return new Browser($useragent, 'Digincore Bot', VersionFactory::detectVersion($useragent, ['Digincore bot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Steeler/', $useragent)) {
            return new Browser($useragent, 'Steeler', VersionFactory::detectVersion($useragent, ['Steeler']), 'KitsuregawaLaboratory', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Orangebot/', $useragent)) {
            return new Browser($useragent, 'Orangebot', VersionFactory::detectVersion($useragent, ['Orangebot']), 'Orange', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Jasmine/', $useragent)) {
            return new Browser($useragent, 'Jasmine', VersionFactory::detectVersion($useragent, ['Jasmine']), 'PivotalLabs', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/electricmonk/', $useragent)) {
            return new Browser($useragent, 'DueDil Crawler', VersionFactory::detectVersion($useragent, ['electricmonk']), 'DueDil', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/yoozBot/', $useragent)) {
            return new Browser($useragent, 'yoozBot', VersionFactory::detectVersion($useragent, ['yoozBot\-']), 'Yooz', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/online\-webceo\-bot/', $useragent)) {
            return new Browser($useragent, 'webceo Bot', VersionFactory::detectVersion($useragent, ['online\-webceo\-bot']), 'Webceo', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/^Mozilla\/5\.0 \(.*\) Gecko\/.*\/\d+/', $useragent)
            && !preg_match('/Netscape/', $useragent)
        ) {
            return new Browser($useragent, 'Firefox', VersionFactory::detectVersion($useragent, [            'Firefox',            'Minefield',            'Shiretoko',            'BonEcho',            'Namoroka',            'Fennec',        ]), 'MozillaFoundation', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/^Mozilla\/5\.0 \(.*rv:\d+\.\d+.*\) Gecko\/.*\//', $useragent)
            && !preg_match('/Netscape/', $useragent)
        ) {
            return new Browser($useragent, 'Firefox', VersionFactory::detectVersion($useragent, [            'Firefox',            'Minefield',            'Shiretoko',            'BonEcho',            'Namoroka',            'Fennec',        ]), 'MozillaFoundation', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Netscape/', $useragent)) {
            return new Browser($useragent, 'Netscape', VersionFactory::detectVersion($useragent, ['Netscape', 'Netscape6', 'rv\:', 'Mozilla']), 'Netscape', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/^Mozilla\/5\.0$/', $useragent)) {
            return new Browser($useragent, 'unknown', new Version(0), 'Unknown', $bits, new UaBrowserType\Unknown(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Virtuoso/', $useragent)) {
            return new Browser($useragent, 'Virtuoso', VersionFactory::detectVersion($useragent, ['Virtuoso']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/^Mozilla\/(3|4)\.\d+/', $useragent, $matches)
            && !preg_match('/(msie|android)/i', $useragent, $matches)
        ) {
            return new Browser($useragent, 'Netscape', VersionFactory::detectVersion($useragent, ['Netscape', 'Netscape6', 'rv\:', 'Mozilla']), 'Netscape', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/^Dalvik\/\d/', $useragent)) {
            return new Browser($useragent, 'Dalvik', VersionFactory::detectVersion($useragent, ['Dalvik']), 'Google', $bits, new UaBrowserType\Application(), true, false, true, true, true, true, true);
        } elseif (preg_match('/niki\-bot/', $useragent)) {
            return new Browser($useragent, 'NikiBot', VersionFactory::detectVersion($useragent, ['niki-bot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ContextAd Bot/', $useragent)) {
            return new Browser($useragent, 'ContextAd Bot', VersionFactory::detectVersion($useragent, ['ContextAd Bot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/integrity/', $useragent)) {
            return new Browser($useragent, 'Integrity', VersionFactory::detectVersion($useragent, ['integrity']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/masscan/', $useragent)) {
            return new Browser($useragent, 'Download Accelerator', VersionFactory::detectVersion($useragent, ['masscan']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ZmEu/', $useragent)) {
            return new Browser($useragent, 'ZmEu', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/sogou web spider/i', $useragent)) {
            return new Browser($useragent, 'Sogou Web Spider', VersionFactory::detectVersion($useragent, ['Sogou web spider']), 'Sogou', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(OpenWave|UP\.Browser|UP\/)/', $useragent)) {
            return new Browser($useragent, 'Openwave Mobile Browser', VersionFactory::detectVersion($useragent, ['UP\.Browser', 'UP', 'OpenWave']), 'Myriad', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/(ObigoInternetBrowser|obigo\-browser|Obigo|Teleca)(\/|-)Q(\d+)/', $useragent)) {
            return new Browser($useragent, 'Obigo Q', ObigoQ::detectVersion($useragent), 'Obigo', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/(Teleca|Obigo|MIC\/|AU\-MIC)/', $useragent)) {
            return new Browser($useragent, 'Teleca-Obigo', VersionFactory::detectVersion($useragent, [            'MIC',            'ObigoInternetBrowser',            'Obigo Browser',            'Obigo\-Browser',            'Teleca\-Obigo',            'TelecaBrowser',        ]), 'Obigo', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/DavClnt/', $useragent)) {
            return new Browser($useragent, 'Microsoft-WebDAV', VersionFactory::detectVersion($useragent, ['Microsoft\-WebDAV\-MiniRedir', 'Microsoft\-WebDAV', 'DavClnt']), 'Microsoft', $bits, new UaBrowserType\Bot(), true, false, true, false, true, true, true);
        } elseif (preg_match('/XING\-contenttabreceiver/', $useragent)) {
            return new Browser($useragent, 'XING Contenttabreceiver', VersionFactory::detectVersion($useragent, ['XING\-contenttabreceiver']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Slingstone/', $useragent)) {
            return new Browser($useragent, 'Yahoo Slingstone', new Version(0), 'Yahoo', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/BOT for JCE/', $useragent)) {
            return new Browser($useragent, 'BOT for JCE', VersionFactory::detectVersion($useragent, ['BOT']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Validator\.nu\/LV/', $useragent)) {
            return new Browser($useragent, 'Validator.nu/LV', new Version(0), 'W3c', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Curb/', $useragent)) {
            return new Browser($useragent, 'Curb', VersionFactory::detectVersion($useragent, ['Curb']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/link_thumbnailer/', $useragent)) {
            return new Browser($useragent, 'link_thumbnailer', VersionFactory::detectVersion($useragent, ['link_thumbnailer']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Ruby/', $useragent)) {
            return new Browser($useragent, 'Generic Ruby Crawler', VersionFactory::detectVersion($useragent, ['Ruby']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/securepoint cf/', $useragent)) {
            return new Browser($useragent, 'Securepoint Content Filter', new Version(0), 'Securepoint', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/sogou\-spider/i', $useragent)) {
            return new Browser($useragent, 'Sogou Spider', VersionFactory::detectVersion($useragent, ['Sogou\-Spider']), 'Sogou', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/rankflex/i', $useragent)) {
            return new Browser($useragent, 'RankFlex', new Version(0), 'RankFlex', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/domnutch/i', $useragent)) {
            return new Browser($useragent, 'Domnutch Bot', VersionFactory::detectVersion($useragent, ['Domnutch\-Bot', 'Nutch\-']), 'NutchDe', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/discovered/i', $useragent)) {
            return new Browser($useragent, 'DiscoverEd', VersionFactory::detectVersion($useragent, ['DiscoverEd\/Nutch\-', 'DiscoverEd']), 'CreativeCommons', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/nutch/i', $useragent)) {
            return new Browser($useragent, 'Nutch', VersionFactory::detectVersion($useragent, ['Nutch', 'Nutch\-']), 'Apache', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/boardreader favicon fetcher/i', $useragent)) {
            return new Browser($useragent, 'BoardReader Favicon Fetcher', VersionFactory::detectVersion($useragent, ['BoardReader Favicon Fetcher', 'BoardReader Favicon Fetcher ']), 'BoardReader', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/checksite verification agent/i', $useragent)) {
            return new Browser($useragent, 'CheckSite Verification Agent', new Version(0), 'Checksite', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/experibot/i', $useragent)) {
            return new Browser($useragent, 'Experibot', VersionFactory::detectVersion($useragent, ['Experibot\_v']), 'AmirKrause', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/feedblitz/i', $useragent)) {
            return new Browser($useragent, 'FeedBlitz', VersionFactory::detectVersion($useragent, ['FeedBlitz']), 'FeedBlitz', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/rss2html/i', $useragent)) {
            return new Browser($useragent, 'RSS2HTML', VersionFactory::detectVersion($useragent, ['FeedForAll rss2html\.php v']), 'NotePage', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/feedlyapp/i', $useragent)) {
            return new Browser($useragent, 'feedly App', VersionFactory::detectVersion($useragent, ['FeedlyApp']), 'FeedlyCom', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/genderanalyzer/i', $useragent)) {
            return new Browser($useragent, 'Genderanalyzer', VersionFactory::detectVersion($useragent, ['Genderanalyzer']), 'GenderAnalyzer', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/gooblog/i', $useragent)) {
            return new Browser($useragent, 'gooblog', VersionFactory::detectVersion($useragent, ['gooblog']), 'NttResonant', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/tumblr/i', $useragent)) {
            return new Browser($useragent, 'Tumblr App', VersionFactory::detectVersion($useragent, ['Tumblr']), 'Tumblr', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (preg_match('/w3c\_i18n\-checker/i', $useragent)) {
            return new Browser($useragent, 'W3C I18n Checker', VersionFactory::detectVersion($useragent, ['W3C\_I18n\-Checker']), 'W3c', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/w3c\_unicorn/i', $useragent)) {
            return new Browser($useragent, 'W3C Unicorn', VersionFactory::detectVersion($useragent, ['W3C_Unicorn']), 'W3c', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/alltop/i', $useragent)) {
            return new Browser($useragent, 'Alltop App', VersionFactory::detectVersion($useragent, ['Alltop']), 'Alltop', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/internetseer/i', $useragent)) {
            return new Browser($useragent, 'InternetSeer.com', VersionFactory::detectVersion($useragent, ['InternetSeer\.com']), 'InternetSeer', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ADmantX Platform Semantic Analyzer/', $useragent)) {
            return new Browser($useragent, 'ADmantX Platform Semantic Analyzer', new Version(0), 'AdmantxInc', $bits, new UaBrowserType\Bot(), true, false, true, true, true, true, true);
        } elseif (preg_match('/UniversalFeedParser/', $useragent)) {
            return new Browser($useragent, 'UniversalFeedParser', VersionFactory::detectVersion($useragent, ['UniversalFeedParser']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(binlar|larbin)/i', $useragent)) {
            return new Browser($useragent, 'Larbin', VersionFactory::detectVersion($useragent, ['binlar\_', 'larbin\_']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/unityplayer/i', $useragent)) {
            return new Browser($useragent, 'Unity Web Player', VersionFactory::detectVersion($useragent, ['UnityPlayer']), 'UnityTechnologies', $bits, new UaBrowserType\Bot(), true, false, true, false, true, true, true);
        } elseif (preg_match('/WeSEE\:Search/', $useragent)) {
            return new Browser($useragent, 'WeSEE:Search', VersionFactory::detectVersion($useragent, ['WeSEE:Search']), 'Wesee', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/WeSEE\:Ads/', $useragent)) {
            return new Browser($useragent, 'WeSEE:Ads', VersionFactory::detectVersion($useragent, ['WeSEE:Ads']), 'Wesee', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/A6\-Indexer/', $useragent)) {
            return new Browser($useragent, 'A6-Indexer', VersionFactory::detectVersion($useragent, ['A6\-Indexer']), 'A6Corp', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/NerdyBot/', $useragent)) {
            return new Browser($useragent, 'NerdyBot', VersionFactory::detectVersion($useragent, ['NerdyBot']), 'NerdyData', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Peeplo Screenshot Bot/', $useragent)) {
            return new Browser($useragent, 'Peeplo Screenshot Bot', VersionFactory::detectVersion($useragent, ['Peeplo Screenshot Bot']), 'Peeplo', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/CCBot/', $useragent)) {
            return new Browser($useragent, 'CCBot', VersionFactory::detectVersion($useragent, ['CCBot']), 'CommonCrawlFoundation', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/visionutils/', $useragent)) {
            return new Browser($useragent, 'visionutils', VersionFactory::detectVersion($useragent, ['visionutils']), 'BobMottram', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Feedly/', $useragent)) {
            return new Browser($useragent, 'feedly Feed Fetcher', VersionFactory::detectVersion($useragent, ['Feedly']), 'FeedlyCom', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Photon/', $useragent)) {
            return new Browser($useragent, 'Photon', VersionFactory::detectVersion($useragent, ['Photon']), 'PhotonProject', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/WDG\_Validator/', $useragent)) {
            return new Browser($useragent, 'HTML Validator', VersionFactory::detectVersion($useragent, ['WDG_Validator']), 'WebDesignGroup', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Aboundex/', $useragent)) {
            return new Browser($useragent, 'Aboundexbot', VersionFactory::detectVersion($useragent, ['Aboundex']), 'Aboundex', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/YisouSpider/', $useragent)) {
            return new Browser($useragent, 'YisouSpider', new Version(0), 'Yisou', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/hivaBot/', $useragent)) {
            return new Browser($useragent, 'hivaBot', VersionFactory::detectVersion($useragent, ['hivaBot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Comodo Spider/', $useragent)) {
            return new Browser($useragent, 'Comodo Spider', VersionFactory::detectVersion($useragent, ['Comodo Spider']), 'Comodo', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/OpenWebSpider/i', $useragent)) {
            return new Browser($useragent, 'OpenWebSpider', VersionFactory::detectVersion($useragent, ['OpenWebSpider']), 'StefanoAlimonti', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/R6_CommentReader/i', $useragent)) {
            return new Browser($useragent, 'R6 CommentReader', new Version(0), 'Salesforce', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/R6_FeedFetcher/i', $useragent)) {
            return new Browser($useragent, 'R6 FeedFetcher', new Version(0), 'Salesforce', $bits, new UaBrowserType\BotSyndicationReader(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(psbot\-image|psbot\-page)/i', $useragent)) {
            return new Browser($useragent, 'Picsearch Bot', VersionFactory::detectVersion($useragent, ['Picsearchbot', 'psbot']), 'Picsearch', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Bloglovin/', $useragent)) {
            return new Browser($useragent, 'Bloglovin Bot', VersionFactory::detectVersion($useragent, ['Bloglovin']), 'Bloglovin', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/viralvideochart/i', $useragent)) {
            return new Browser($useragent, 'viralvideochart Bot', VersionFactory::detectVersion($useragent, ['viralvideochart']), 'UnrulyGroup', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/MetaHeadersBot/', $useragent)) {
            return new Browser($useragent, 'MetaHeadersBot', VersionFactory::detectVersion($useragent, ['MetaHeadersBot']), 'Metaheaders', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Zend\_Http\_Client/', $useragent)) {
            return new Browser($useragent, 'Zend_Http_Client', VersionFactory::detectVersion($useragent, ['Zend_Http_Client']), 'Zend', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/wget/i', $useragent)) {
            return new Browser($useragent, 'wget', VersionFactory::detectVersion($useragent, ['Wget', 'wget']), 'FreeSoftwareFoundation', $bits, new UaBrowserType\OfflineBrowser(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Scrapy/', $useragent)) {
            return new Browser($useragent, 'Scrapy', VersionFactory::detectVersion($useragent, ['Scrapy']), 'ScrapyOrg', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Moozilla/', $useragent)) {
            return new Browser($useragent, 'Moozilla', VersionFactory::detectVersion($useragent, ['Moozilla']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/AntBot/', $useragent)) {
            return new Browser($useragent, 'AntBot', VersionFactory::detectVersion($useragent, ['AntBot']), 'AntCom', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Browsershots/', $useragent)) {
            return new Browser($useragent, 'Browsershots', VersionFactory::detectVersion($useragent, ['Browsershots']), 'Browsershots', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/revolt/', $useragent)) {
            return new Browser($useragent, 'Bot Revolt', VersionFactory::detectVersion($useragent, ['revolt']), 'BotRevolt', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/pdrlabs/i', $useragent)) {
            return new Browser($useragent, 'pdrlabs Bot', VersionFactory::detectVersion($useragent, ['pdrlabs']), 'Pdrlabs', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/elinks/i', $useragent)) {
            return new Browser($useragent, 'ELinks', VersionFactory::detectVersion($useragent, ['ELinks']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Links/', $useragent)) {
            return new Browser($useragent, 'Links', VersionFactory::detectVersion($useragent, ['Links', 'Links \(']), 'MikulasPatocka', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Airmail/', $useragent)) {
            return new Browser($useragent, 'Airmail', VersionFactory::detectVersion($useragent, ['Airmail']), 'Bloop', $bits, new UaBrowserType\EmailClient(), true, false, true, false, true, true, true);
        } elseif (preg_match('/SonyEricsson/', $useragent)) {
            return new Browser($useragent, 'SEMC', VersionFactory::detectVersion($useragent, ['SEMC\-Browser']), 'SonyEricsson', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/WEB\.DE MailCheck/', $useragent)) {
            return new Browser($useragent, 'WEB.DE MailCheck', VersionFactory::detectVersion($useragent, ['WEB\.DE MailCheck']), 'EinsUndEins', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Screaming Frog SEO Spider/', $useragent)) {
            return new Browser($useragent, 'Screaming Frog SEO Spider', VersionFactory::detectVersion($useragent, ['Screaming Frog SEO Spider']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/AndroidDownloadManager/', $useragent)) {
            return new Browser($useragent, 'Android Download Manager', VersionFactory::detectVersion($useragent, ['AndroidDownloadManager']), 'Unknown', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Go ([\d\.]+) package http/', $useragent)) {
            return new Browser($useragent, 'GO HttpClient', VersionFactory::detectVersion($useragent, ['Go\-http\-client', 'Go']), 'Google', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Go-http-client/', $useragent)) {
            return new Browser($useragent, 'GO HttpClient', VersionFactory::detectVersion($useragent, ['Go\-http\-client', 'Go']), 'Google', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Proxy Gear Pro/', $useragent)) {
            return new Browser($useragent, 'Proxy Gear Pro', VersionFactory::detectVersion($useragent, ['Proxy Gear Pro']), 'ProxyBase', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/WAP Browser\/MAUI/', $useragent)) {
            return new Browser($useragent, 'MAUI Wap Browser', new Version(0), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Tiny Tiny RSS/', $useragent)) {
            return new Browser($useragent, 'Tiny Tiny RSS', VersionFactory::detectVersion($useragent, ['Tiny Tiny RSS']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Readability/', $useragent)) {
            return new Browser($useragent, 'Readability', new Version(0), 'SfxEntertainment', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/NSPlayer/', $useragent)) {
            return new Browser($useragent, 'Windows Media Player', VersionFactory::detectVersion($useragent, ['Windows\-Media\-Player', 'NSPlayer']), 'Microsoft', $bits, new UaBrowserType\MultimediaPlayer(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Pingdom/', $useragent)) {
            return new Browser($useragent, 'Pingdom', VersionFactory::detectVersion($useragent, ['Pingdom\.com\_bot\_version\_']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, true, false, true, true, true);
        } elseif (preg_match('/crazywebcrawler/i', $useragent)) {
            return new Browser($useragent, 'Crazywebcrawler', VersionFactory::detectVersion($useragent, ['CRAZYWEBCRAWLER']), 'Crazywebcrawler', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/GG PeekBot/', $useragent)) {
            return new Browser($useragent, 'GG PeekBot', VersionFactory::detectVersion($useragent, ['GG PeekBot']), 'GaduGadu', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/iTunes/', $useragent)) {
            return new Browser($useragent, 'iTunes', VersionFactory::detectVersion($useragent, ['iTunes']), 'Apple', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/LibreOffice/', $useragent)) {
            return new Browser($useragent, 'LibreOffice', VersionFactory::detectVersion($useragent, ['LibreOffice']), 'TheDocumentFoundation', $bits, new UaBrowserType\Application(), true, false, true, true, true, true, true);
        } elseif (preg_match('/OpenOffice/', $useragent)) {
            return new Browser($useragent, 'OpenOffice', VersionFactory::detectVersion($useragent, ['OpenOffice']), 'Apache', $bits, new UaBrowserType\Application(), true, false, true, true, true, true, true);
        } elseif (preg_match('/ThumbnailAgent/', $useragent)) {
            return new Browser($useragent, 'ThumbnailAgent', VersionFactory::detectVersion($useragent, ['ThumbnailAgent']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/LinkStats Bot/', $useragent)) {
            return new Browser($useragent, 'LinkStats Bot', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/eZ Publish Link Validator/', $useragent)) {
            return new Browser($useragent, 'eZ Publish Link Validator', new Version(0), 'EzSystems', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ThumbSniper/', $useragent)) {
            return new Browser($useragent, 'ThumbSniper', new Version(0), 'ThomasSchulte', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/stq\_bot/', $useragent)) {
            return new Browser($useragent, 'Searchteq Bot', VersionFactory::detectVersion($useragent, ['stq\_bot']), 'Searchteq', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SNK Screenshot Bot/', $useragent)) {
            return new Browser($useragent, 'Save n Keep Screenshot Bot', VersionFactory::detectVersion($useragent, ['SNK Screenshot Bot']), 'Savenkeep', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SynHttpClient/', $useragent)) {
            return new Browser($useragent, 'SynHttpClient', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/HTTPClient/', $useragent)) {
            return new Browser($useragent, 'httpclient', VersionFactory::detectVersion($useragent, ['HTTPClient']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/T\-Online Browser/', $useragent)) {
            return new Browser($useragent, 'T-Online Browser', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ImplisenseBot/', $useragent)) {
            return new Browser($useragent, 'ImplisenseBot', VersionFactory::detectVersion($useragent, ['ImplisenseBot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/BuiBui\-Bot/', $useragent)) {
            return new Browser($useragent, 'BuiBui-Bot', VersionFactory::detectVersion($useragent, ['BuiBui\-Bot']), 'Dadapro', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/thumbshots\-de\-bot/', $useragent)) {
            return new Browser($useragent, 'thumbshots-de-bot', new Version(0), 'Thumbshots', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/python\-requests/', $useragent)) {
            return new Browser($useragent, 'python-requests', VersionFactory::detectVersion($useragent, ['python\-requests']), 'PythonSoftwareFoundation', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Python\-urllib/', $useragent)) {
            return new Browser($useragent, 'Python-urllib', VersionFactory::detectVersion($useragent, ['Python\-urllib']), 'PythonSoftwareFoundation', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Bot\.AraTurka\.com/', $useragent)) {
            return new Browser($useragent, 'Bot.AraTurka.com', VersionFactory::detectVersion($useragent, ['Bot\.AraTurka\.com']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/http\_requester/', $useragent)) {
            return new Browser($useragent, 'http_requester', VersionFactory::detectVersion($useragent, ['http_requester']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/WhatWeb/', $useragent)) {
            return new Browser($useragent, 'WhatWeb Web Scanner', VersionFactory::detectVersion($useragent, ['WhatWeb']), 'AndrewHorton', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/isc header collector handlers/', $useragent)) {
            return new Browser($useragent, 'isc header collector handlers', VersionFactory::detectVersion($useragent, ['isc header collector handlers']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Thumbor/', $useragent)) {
            return new Browser($useragent, 'Thumbor', VersionFactory::detectVersion($useragent, ['Thumbor']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Forum Poster/', $useragent)) {
            return new Browser($useragent, 'Forum Poster', VersionFactory::detectVersion($useragent, ['Forum Poster V', 'Forum Poster']), 'ForumPoster', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/crawler4j/', $useragent)) {
            return new Browser($useragent, 'crawler4j', VersionFactory::detectVersion($useragent, ['crawler4j']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Facebot/', $useragent)) {
            return new Browser($useragent, 'Facebot', VersionFactory::detectVersion($useragent, ['Facebot']), 'Facebook', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/NetzCheckBot/', $useragent)) {
            return new Browser($useragent, 'NetzCheckBot', VersionFactory::detectVersion($useragent, ['NetzCheckBot']), 'NetzCheck', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/MIB/', $useragent)) {
            return new Browser($useragent, 'Motorola Internet Browser', VersionFactory::detectVersion($useragent, ['MIB', 'MIB\/BER']), 'Motorola', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/facebookscraper/', $useragent)) {
            return new Browser($useragent, 'Facebookscraper', VersionFactory::detectVersion($useragent, ['facebookscraper']), 'Facebook', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Zookabot/', $useragent)) {
            return new Browser($useragent, 'Zookabot', VersionFactory::detectVersion($useragent, ['Zookabot']), 'Zookabot', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/MetaURI/', $useragent)) {
            return new Browser($useragent, 'MetaURI Bot', VersionFactory::detectVersion($useragent, ['MetaURI API']), 'Metauri', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/FreeWebMonitoring SiteChecker/', $useragent)) {
            return new Browser($useragent, 'FreeWebMonitoring SiteChecker', VersionFactory::detectVersion($useragent, ['FreeWebMonitoring SiteChecker']), 'FreeWebMonitoring', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/IPv4Scan/', $useragent)) {
            return new Browser($useragent, 'IPv4Scan', VersionFactory::detectVersion($useragent, ['IPv4Scan']), 'Ipv4Scan', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/RED/', $useragent)) {
            return new Browser($useragent, 'redbot', VersionFactory::detectVersion($useragent, ['RED']), 'Redbot', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/domainsbot/', $useragent)) {
            return new Browser($useragent, 'DomainsBot', VersionFactory::detectVersion($useragent, ['domainsbot']), 'DomainsBot', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/BUbiNG/', $useragent)) {
            return new Browser($useragent, 'BUbiNG Bot', VersionFactory::detectVersion($useragent, ['BUbiNG']), 'LawDiUnimiIt', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/RamblerMail/', $useragent)) {
            return new Browser($useragent, 'RamblerMail Bot', VersionFactory::detectVersion($useragent, ['RamblerMail']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ichiro\/mobile/', $useragent)) {
            return new Browser($useragent, 'Ichiro Mobile Bot', new Version(0), 'Ichiro', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ichiro/', $useragent)) {
            return new Browser($useragent, 'Ichiro Bot', VersionFactory::detectVersion($useragent, ['ichiro']), 'Ichiro', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/iisbot/', $useragent)) {
            return new Browser($useragent, 'IIS Site Analysis Web Crawler', VersionFactory::detectVersion($useragent, ['iisbot']), 'IisNet', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/JoobleBot/', $useragent)) {
            return new Browser($useragent, 'JoobleBot', VersionFactory::detectVersion($useragent, ['JoobleBot']), 'Jooble', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Superfeedr bot/', $useragent)) {
            return new Browser($useragent, 'Superfeedr Bot', VersionFactory::detectVersion($useragent, ['Superfeedr bot']), 'Superfeedr', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/FeedBurner/', $useragent)) {
            return new Browser($useragent, 'FeedBurner', VersionFactory::detectVersion($useragent, ['FeedBurner']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Fastladder/', $useragent)) {
            return new Browser($useragent, 'Fastladder', VersionFactory::detectVersion($useragent, ['Fastladder FeedFetcher']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/livedoor/', $useragent)) {
            return new Browser($useragent, 'Livedoor', VersionFactory::detectVersion($useragent, ['livedoor FeedFetcher']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Icarus6j/', $useragent)) {
            return new Browser($useragent, 'Icarus6j', VersionFactory::detectVersion($useragent, ['Icarus6j']), 'Icarus6', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/wsr\-agent/', $useragent)) {
            return new Browser($useragent, 'wsr-agent', VersionFactory::detectVersion($useragent, ['wsr\-agent']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Blogshares Spiders/', $useragent)) {
            return new Browser($useragent, 'Blogshares Spiders', VersionFactory::detectVersion($useragent, ['Blogshares Spiders \(Renewed V', 'Blogshares Spiders']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/TinEye\-bot/', $useragent)) {
            return new Browser($useragent, 'TinEye Bot', VersionFactory::detectVersion($useragent, ['TinEye\-bot']), 'Idee', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/QuickiWiki/', $useragent)) {
            return new Browser($useragent, 'QuickiWiki Bot', VersionFactory::detectVersion($useragent, ['QuickiWiki']), 'QuickiWiki', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/PycURL/', $useragent)) {
            return new Browser($useragent, 'PycURL', VersionFactory::detectVersion($useragent, ['PycURL']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/libcurl\-agent/', $useragent)) {
            return new Browser($useragent, 'libcurl', VersionFactory::detectVersion($useragent, ['libcurl\-agent']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Taproot/', $useragent)) {
            return new Browser($useragent, 'Taproot Bot', VersionFactory::detectVersion($useragent, ['Taproot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/GuzzleHttp/', $useragent)) {
            return new Browser($useragent, 'Guzzle Http Client', VersionFactory::detectVersion($useragent, ['GuzzleHttp']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/curl/i', $useragent)) {
            return new Browser($useragent, 'cURL', VersionFactory::detectVersion($useragent, ['curl']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/^PHP/', $useragent)) {
            return new Browser($useragent, 'PHP', VersionFactory::detectVersion($useragent, ['PHP', 'PHP\-SOAP']), 'PhpGroup', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Apple\-PubSub/', $useragent)) {
            return new Browser($useragent, 'Apple PubSub', VersionFactory::detectVersion($useragent, ['Apple\-PubSub']), 'Apple', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SimplePie/', $useragent)) {
            return new Browser($useragent, 'SimplePie', VersionFactory::detectVersion($useragent, ['SimplePie']), 'RyanParman', $bits, new UaBrowserType\Bot(), true, false, true, false, true, true, true);
        } elseif (preg_match('/BigBozz/', $useragent)) {
            return new Browser($useragent, 'BigBozz - Financial Search', VersionFactory::detectVersion($useragent, ['BigBozz']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ECCP/', $useragent)) {
            return new Browser($useragent, 'ECCP', VersionFactory::detectVersion($useragent, ['ECCP']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/facebookexternalhit/', $useragent)) {
            return new Browser($useragent, 'FacebookExternalHit', VersionFactory::detectVersion($useragent, ['facebookexternalhit']), 'Facebook', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/GigablastOpenSource/', $useragent)) {
            return new Browser($useragent, 'Gigablast Search Engine', VersionFactory::detectVersion($useragent, ['GigablastOpenSource']), 'GigablastCom', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/WebIndex/', $useragent)) {
            return new Browser($useragent, 'WebIndex', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Prince/', $useragent)) {
            return new Browser($useragent, 'Prince', VersionFactory::detectVersion($useragent, ['Prince']), 'YesLogic', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/adsense\-snapshot\-google/i', $useragent)) {
            return new Browser($useragent, 'AdSense Snapshot Bot', VersionFactory::detectVersion($useragent, ['Adsense\-Snapshot\-Google']), 'Google', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Amazon CloudFront/', $useragent)) {
            return new Browser($useragent, 'Amazon CloudFront', VersionFactory::detectVersion($useragent, ['Amazon CloudFront']), 'Amazon', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/bandscraper/', $useragent)) {
            return new Browser($useragent, 'bandscraper', VersionFactory::detectVersion($useragent, ['bandscraper']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/bitlybot/', $useragent)) {
            return new Browser($useragent, 'BitlyBot', VersionFactory::detectVersion($useragent, ['bitlybot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/^bot$/', $useragent)) {
            return new Browser($useragent, 'bot', VersionFactory::detectVersion($useragent, ['bot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/cars\-app\-browser/', $useragent)) {
            return new Browser($useragent, 'cars-app-browser', VersionFactory::detectVersion($useragent, ['cars\-app\-browser']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Coursera\-Mobile/', $useragent)) {
            return new Browser($useragent, 'Coursera Mobile App', VersionFactory::detectVersion($useragent, ['Coursera\-Mobile']), 'Coursera', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Crowsnest/', $useragent)) {
            return new Browser($useragent, 'Crowsnest Mobile App', VersionFactory::detectVersion($useragent, ['Crowsnest']), 'Gocro', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Dorado WAP\-Browser/', $useragent)) {
            return new Browser($useragent, 'Dorado WAP Browser', VersionFactory::detectVersion($useragent, ['Dorado WAP\-Browser']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Goldfire Server/', $useragent)) {
            return new Browser($useragent, 'Goldfire Server', VersionFactory::detectVersion($useragent, ['Goldfire Server']), 'InventionMachine', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/EventMachine HttpClient/', $useragent)) {
            return new Browser($useragent, 'EventMachine HttpClient', VersionFactory::detectVersion($useragent, ['EventMachine HttpClient']), 'IlyaGrigorik', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/iBall/', $useragent)) {
            return new Browser($useragent, 'iBall', new Version(0), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/InAGist URL Resolver/', $useragent)) {
            return new Browser($useragent, 'InAGist URL Resolver', VersionFactory::detectVersion($useragent, ['InAGist URL Resolver']), 'IyottaSoftware', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Jeode/', $useragent)) {
            return new Browser($useragent, 'Jeode', VersionFactory::detectVersion($useragent, ['Jeode']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/kraken/', $useragent)) {
            return new Browser($useragent, 'krakenjs', VersionFactory::detectVersion($useragent, ['kraken']), 'Paypal', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/com\.linkedin/', $useragent)) {
            return new Browser($useragent, 'LinkedInBot', VersionFactory::detectVersion($useragent, ['com\.linkedin']), 'LinkedIn', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/LivelapBot/', $useragent)) {
            return new Browser($useragent, 'Livelap Crawler', VersionFactory::detectVersion($useragent, ['LivelapBot']), 'Paypal', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/MixBot/', $useragent)) {
            return new Browser($useragent, 'MixBot', VersionFactory::detectVersion($useragent, ['MixBot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/BuSecurityProject/', $useragent)) {
            return new Browser($useragent, 'BuSecurityProject', VersionFactory::detectVersion($useragent, ['BuSecurityProject']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/PageFreezer/', $useragent)) {
            return new Browser($useragent, 'PageFreezer', VersionFactory::detectVersion($useragent, ['PageFreezer']), 'PageFreezerSoftware', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/restify/', $useragent)) {
            return new Browser($useragent, 'restify', VersionFactory::detectVersion($useragent, ['restify']), 'MarkCavage', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ShowyouBot/', $useragent)) {
            return new Browser($useragent, 'ShowyouBot', VersionFactory::detectVersion($useragent, ['ShowyouBot']), 'Remixation', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/vlc/i', $useragent)) {
            return new Browser($useragent, 'VLC Media Player', VersionFactory::detectVersion($useragent, ['VLC']), 'VideoLan', $bits, new UaBrowserType\MultimediaPlayer(), true, false, true, false, true, true, true);
        } elseif (preg_match('/WebRingChecker/', $useragent)) {
            return new Browser($useragent, 'WebRingChecker', VersionFactory::detectVersion($useragent, ['WebRingChecker']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/bot\-pge\.chlooe\.com/', $useragent)) {
            return new Browser($useragent, 'chlooe Bot', VersionFactory::detectVersion($useragent, ['bot\-pge\.chlooe\.com']), 'AsiaWsNetwork', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/seebot/', $useragent)) {
            return new Browser($useragent, 'SeeBot', VersionFactory::detectVersion($useragent, ['seebot']), 'Seegnify', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ltx71/', $useragent)) {
            return new Browser($useragent, 'ltx71 Bot', VersionFactory::detectVersion($useragent, ['ltx71']), 'Ltx71', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/CookieReports/', $useragent)) {
            return new Browser($useragent, 'Cookie Reports Bot', VersionFactory::detectVersion($useragent, ['CookieReports\.com']), 'CookieReportsLimited', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Elmer/', $useragent)) {
            return new Browser($useragent, 'Elmer', new Version(0), 'ThingLinkOy', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Iframely/', $useragent)) {
            return new Browser($useragent, 'Iframely Bot', VersionFactory::detectVersion($useragent, ['Iframely']), 'Itteco', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/MetaInspector/', $useragent)) {
            return new Browser($useragent, 'MetaInspector', VersionFactory::detectVersion($useragent, ['MetaInspector']), 'JaimeIniesta', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Microsoft\-CryptoAPI/', $useragent)) {
            return new Browser($useragent, 'Microsoft CryptoAPI', VersionFactory::detectVersion($useragent, ['Microsoft CryptoAPI']), 'Microsoft', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/OWASP\_SECRET\_BROWSER/', $useragent)) {
            return new Browser($useragent, 'OWASP_SECRET_BROWSER', VersionFactory::detectVersion($useragent, ['OWASP\_SECRET\_BROWSER']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SMRF URL Expander/', $useragent)) {
            return new Browser($useragent, 'SMRF URL Expander', VersionFactory::detectVersion($useragent, ['SMRF URL Expander']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Speedy Spider/', $useragent)) {
            return new Browser($useragent, 'Entireweb', VersionFactory::detectVersion($useragent, ['Entireweb']), 'Entireweb', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/kizasi\-spider/', $useragent)) {
            return new Browser($useragent, 'kizasi-spider', VersionFactory::detectVersion($useragent, ['kizasi-spider']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Superarama\.com \- BOT/', $useragent)) {
            return new Browser($useragent, 'Superarama.com - BOT', VersionFactory::detectVersion($useragent, ['Superarama\.com \- BOT']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/WNMbot/', $useragent)) {
            return new Browser($useragent, 'WNMbot', VersionFactory::detectVersion($useragent, ['WNMbot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Website Explorer/', $useragent)) {
            return new Browser($useragent, 'Website Explorer', VersionFactory::detectVersion($useragent, ['Website Explorer']), 'Umechando', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/city\-map screenshot service/', $useragent)) {
            return new Browser($useragent, 'city-map screenshot service', VersionFactory::detectVersion($useragent, ['city\-map screenshot service']), 'CitymapInternetmarketing', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/gosquared\-thumbnailer/', $useragent)) {
            return new Browser($useragent, 'gosquared-thumbnailer', VersionFactory::detectVersion($useragent, ['gosquared\-thumbnailer']), 'GoSquared', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/optivo\(R\) NetHelper/', $useragent)) {
            return new Browser($useragent, 'optivo NetHelper', new Version(0), 'Optivo', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/pr\-cy\.ru Screenshot Bot/', $useragent)) {
            return new Browser($useragent, 'Screenshot Bot', new Version(0), 'Prcy', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Cyberduck/', $useragent)) {
            return new Browser($useragent, 'Cyberduck', VersionFactory::detectVersion($useragent, ['Cyberduck']), 'Iterate', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Lynx/', $useragent)) {
            return new Browser($useragent, 'Lynx', VersionFactory::detectVersion($useragent, ['Lynx']), 'ThomasDickey', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/AccServer/', $useragent)) {
            return new Browser($useragent, 'AccServer', VersionFactory::detectVersion($useragent, ['AccServer']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SafeSearch microdata crawler/', $useragent)) {
            return new Browser($useragent, 'SafeSearch microdata crawler', new Version(0), 'AviraOperations', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/iZSearch/', $useragent)) {
            return new Browser($useragent, 'iZSearch Bot', new Version(0), 'IzSearch', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/NetLyzer FastProbe/', $useragent)) {
            return new Browser($useragent, 'NetLyzer FastProbe', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/MnoGoSearch/', $useragent)) {
            return new Browser($useragent, 'MnoGoSearch', VersionFactory::detectVersion($useragent, ['MnoGoSearch']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/uipbot/', $useragent)) {
            return new Browser($useragent, 'Uipbot', VersionFactory::detectVersion($useragent, ['uipbot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/mbot/', $useragent)) {
            return new Browser($useragent, 'mbot', VersionFactory::detectVersion($useragent, ['mbot v\.', 'mbot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/MS Web Services Client Protocol/', $useragent)) {
            return new Browser($useragent, '.NET Framework CLR', VersionFactory::detectVersion($useragent, ['MS Web Services Client Protocol']), 'Microsoft', $bits, new UaBrowserType\Bot(), true, false, true, false, true, true, true);
        } elseif (preg_match('/(AtomicBrowser|AtomicLite)/', $useragent)) {
            return new Browser($useragent, 'Atomic Browser', VersionFactory::detectVersion($useragent, ['AtomicBrowser', 'AtomicLite']), 'RichardTrautvetter', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/AppEngine\-Google/', $useragent)) {
            return new Browser($useragent, 'Google App Engine', new Version(0), 'Google', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Feedfetcher\-Google/', $useragent)) {
            return new Browser($useragent, 'Google Feedfetcher', VersionFactory::detectVersion($useragent, [            'Feedfetcher\-Google',            'Feedfetcher\-Google\-iGoogleGadgets',        ]), 'Google', $bits, new UaBrowserType\BotSyndicationReader(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Google/', $useragent)) {
            return new Browser($useragent, 'Google App', VersionFactory::detectVersion($useragent, [            'GSA',        ]), 'Google', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/UnwindFetchor/', $useragent)) {
            return new Browser($useragent, 'UnwindFetchor', VersionFactory::detectVersion($useragent, ['UnwindFetchor']), 'Gnip', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Perfect%20Browser/', $useragent)) {
            return new Browser($useragent, 'PERFECT Browser', VersionFactory::detectVersion($useragent, ['Perfect Browser', 'Perfect Browser\-iPad', 'Perfect%20Browser']), 'Unknown', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Reeder/', $useragent)) {
            return new Browser($useragent, 'Reeder', VersionFactory::detectVersion($useragent, ['Reeder']), 'Unknown', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (preg_match('/FastBrowser/', $useragent)) {
            return new Browser($useragent, 'FastBrowser', VersionFactory::detectVersion($useragent, ['FastBrowser']), 'Unknown', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (preg_match('/CFNetwork/', $useragent)) {
            return new Browser($useragent, 'CFNetwork', new Version(0), 'Apple', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Y\!J\-(ASR|BSC)/', $useragent)) {
            return new Browser($useragent, 'Yahoo! Japan', new Version(0), 'YahooJapan', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/test certificate info/', $useragent)) {
            return new Browser($useragent, 'test certificate info', VersionFactory::detectVersion($useragent, ['test certificate info']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/fastbot crawler/', $useragent)) {
            return new Browser($useragent, 'fastbot crawler', VersionFactory::detectVersion($useragent, ['fastbot crawler beta', 'fastbot crawler']), 'Pagedesign', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Riddler/', $useragent)) {
            return new Browser($useragent, 'Riddler', VersionFactory::detectVersion($useragent, ['Riddler']), 'Riddler', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SophosUpdateManager/', $useragent)) {
            return new Browser($useragent, 'SophosUpdateManager', VersionFactory::detectVersion($useragent, ['SophosUpdateManager']), 'Sophos', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(Debian|Ubuntu) APT\-HTTP/', $useragent)) {
            return new Browser($useragent, 'Apt HTTP Transport', VersionFactory::detectVersion($useragent, ['Debian APT\-HTTP', 'Ubuntu APT\-HTTP']), 'SoftwareInThePublicInterest', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/urlgrabber/', $useragent)) {
            return new Browser($useragent, 'URL Grabber', VersionFactory::detectVersion($useragent, ['urlgrabber']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/UCS \(ESX\)/', $useragent)) {
            return new Browser($useragent, 'Univention Corporate Server', VersionFactory::detectVersion($useragent, ['UCS \(ESX\) \- ']), 'Univention', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/libwww\-perl/', $useragent)) {
            return new Browser($useragent, 'libwww', VersionFactory::detectVersion($useragent, ['libwww', 'libwww\-perl']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/OpenBSD ftp/', $useragent)) {
            return new Browser($useragent, 'OpenBSD ftp', VersionFactory::detectVersion($useragent, ['OpenBSD ftp']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SophosAgent/', $useragent)) {
            return new Browser($useragent, 'SophosAgent', VersionFactory::detectVersion($useragent, ['SophosAgent']), 'Sophos', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/jupdate/', $useragent)) {
            return new Browser($useragent, 'Jupdate', VersionFactory::detectVersion($useragent, ['jupdate']), 'DmSolutions', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Roku\/DVP/', $useragent)) {
            return new Browser($useragent, 'Roku DVP', VersionFactory::detectVersion($useragent, ['Roku\/DVP\-']), 'Roku', $bits, new UaBrowserType\MultimediaPlayer(), true, false, false, false, true, true, true);
        } elseif (preg_match('/VocusBot/', $useragent)) {
            return new Browser($useragent, 'VocusBot', VersionFactory::detectVersion($useragent, ['VocusBot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/PostRank/', $useragent)) {
            return new Browser($useragent, 'PostRank', VersionFactory::detectVersion($useragent, ['PostRank']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/rogerbot/i', $useragent)) {
            return new Browser($useragent, 'Rogerbot', VersionFactory::detectVersion($useragent, ['rogerbot', 'rogerBot']), 'SeoMoz', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Safeassign/', $useragent)) {
            return new Browser($useragent, 'Safeassign', new Version(0), 'Blackboard', $bits, new UaBrowserType\Bot(), false, false, false, false, true, true, true);
        } elseif (preg_match('/ExaleadCloudView/', $useragent)) {
            return new Browser($useragent, 'Exalead CloudView', VersionFactory::detectVersion($useragent, ['ExaleadCloudView']), 'DassaultSystemes', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Typhoeus/', $useragent)) {
            return new Browser($useragent, 'Typhoeus', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Camo Asset Proxy/', $useragent)) {
            return new Browser($useragent, 'Camo Asset Proxy', VersionFactory::detectVersion($useragent, ['Camo Asset Proxy']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/YahooCacheSystem/', $useragent)) {
            return new Browser($useragent, 'YahooCacheSystem', VersionFactory::detectVersion($useragent, ['YahooCacheSystem']), 'Yahoo', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/wmtips\.com/', $useragent)) {
            return new Browser($useragent, 'Webmaster Tips Bot', VersionFactory::detectVersion($useragent, ['wmtips\.com']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/linkCheck/', $useragent)) {
            return new Browser($useragent, 'linkCheck', VersionFactory::detectVersion($useragent, ['linkCheck']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ABrowse/', $useragent)) {
            return new Browser($useragent, 'ABrowse', VersionFactory::detectVersion($useragent, ['ABrowse']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/GWPImages/', $useragent)) {
            return new Browser($useragent, 'GWPImages', VersionFactory::detectVersion($useragent, ['GWPImages']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/NoteTextView/', $useragent)) {
            return new Browser($useragent, 'NoteTextView', VersionFactory::detectVersion($useragent, ['NoteTextView']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/NING/', $useragent)) {
            return new Browser($useragent, 'NING', VersionFactory::detectVersion($useragent, ['NING']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Sprinklr/', $useragent)) {
            return new Browser($useragent, 'Sprinklr', VersionFactory::detectVersion($useragent, ['Sprinklr']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/URLChecker/', $useragent)) {
            return new Browser($useragent, 'URLChecker', VersionFactory::detectVersion($useragent, ['URLChecker']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/newsme/', $useragent)) {
            return new Browser($useragent, 'newsme', VersionFactory::detectVersion($useragent, ['newsme']), 'NewsMe', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Traackr/', $useragent)) {
            return new Browser($useragent, 'Traackr', VersionFactory::detectVersion($useragent, ['Traackr']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/nineconnections/', $useragent)) {
            return new Browser($useragent, 'nineconnections', VersionFactory::detectVersion($useragent, ['nineconnections']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Xenu Link Sleuth/', $useragent)) {
            return new Browser($useragent, 'Xenus Link Sleuth', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/superagent/', $useragent)) {
            return new Browser($useragent, 'superagent', VersionFactory::detectVersion($useragent, ['superagent']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Goose/', $useragent)) {
            return new Browser($useragent, 'goose-extractor', VersionFactory::detectVersion($useragent, ['Goose']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/AHC/', $useragent)) {
            return new Browser($useragent, 'Asynchronous HTTP Client', VersionFactory::detectVersion($useragent, ['AHC']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/newspaper/', $useragent)) {
            return new Browser($useragent, 'newspaper', VersionFactory::detectVersion($useragent, ['newspaper']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Hatena::Bookmark/', $useragent)) {
            return new Browser($useragent, 'Hatena::Bookmark', VersionFactory::detectVersion($useragent, ['Hatena::Bookmark']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/EasyBib AutoCite/', $useragent)) {
            return new Browser($useragent, 'EasyBib AutoCite', VersionFactory::detectVersion($useragent, ['EasyBib AutoCite']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, true, false, true, true, true);
        } elseif (preg_match('/ShortLinkTranslate/', $useragent)) {
            return new Browser($useragent, 'ShortLinkTranslate', VersionFactory::detectVersion($useragent, ['ShortLinkTranslate']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Marketing Grader/', $useragent)) {
            return new Browser($useragent, 'Marketing Grader', VersionFactory::detectVersion($useragent, ['Marketing Grader']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Grammarly/', $useragent)) {
            return new Browser($useragent, 'Grammarly', VersionFactory::detectVersion($useragent, ['Grammarly']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Dispatch/', $useragent)) {
            return new Browser($useragent, 'Dispatch', VersionFactory::detectVersion($useragent, ['Dispatch']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Raven Link Checker/', $useragent)) {
            return new Browser($useragent, 'Raven Link Checker', VersionFactory::detectVersion($useragent, ['Raven Link Checker']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/http\-kit/', $useragent)) {
            return new Browser($useragent, 'HTTP Kit', VersionFactory::detectVersion($useragent, ['http\-kit']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/sfFeedReader/', $useragent)) {
            return new Browser($useragent, 'Symfony RSS Reader', VersionFactory::detectVersion($useragent, ['sfFeedReader']), 'Unknown', $bits, new UaBrowserType\FeedReader(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Twikle/', $useragent)) {
            return new Browser($useragent, 'Twikle Bot', VersionFactory::detectVersion($useragent, ['Twikle']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/node\-fetch/', $useragent)) {
            return new Browser($useragent, 'node-fetch', VersionFactory::detectVersion($useragent, ['node\-fetch']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/BrokenLinkCheck\.com/', $useragent)) {
            return new Browser($useragent, 'BrokenLinkCheck', VersionFactory::detectVersion($useragent, ['BrokenLinkCheck\.com']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/BCKLINKS/', $useragent)) {
            return new Browser($useragent, 'BCKLINKS', VersionFactory::detectVersion($useragent, ['BCKLINKS']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Faraday/', $useragent)) {
            return new Browser($useragent, 'Faraday', VersionFactory::detectVersion($useragent, ['Faraday v', 'Faraday']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/gettor/', $useragent)) {
            return new Browser($useragent, 'gettor', VersionFactory::detectVersion($useragent, ['gettor']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SEOstats/', $useragent)) {
            return new Browser($useragent, 'SEOstats', VersionFactory::detectVersion($useragent, ['SEOstats']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ZnajdzFoto\/Image/', $useragent)) {
            return new Browser($useragent, 'ZnajdzFoto/ImageBot', VersionFactory::detectVersion($useragent, ['ZnajdzFoto\/Image']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/infoX\-WISG/', $useragent)) {
            return new Browser($useragent, 'infoX-WISG', VersionFactory::detectVersion($useragent, ['infoX\-WISG']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/wscheck\.com/', $useragent)) {
            return new Browser($useragent, 'WSCheck Bot', VersionFactory::detectVersion($useragent, ['wscheck\.com']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Tweetminster/', $useragent)) {
            return new Browser($useragent, 'Tweetminster Bot', VersionFactory::detectVersion($useragent, ['Tweetminster']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Astute SRM/', $useragent)) {
            return new Browser($useragent, 'Astute Social', VersionFactory::detectVersion($useragent, ['Astute SRM']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/LongURL API/', $useragent)) {
            return new Browser($useragent, 'LongURL Bot', VersionFactory::detectVersion($useragent, ['LongURL API']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Trove/', $useragent)) {
            return new Browser($useragent, 'Trove Bot', VersionFactory::detectVersion($useragent, ['Trove']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Melvil Favicon/', $useragent)) {
            return new Browser($useragent, 'Melvil Favicon Bot', VersionFactory::detectVersion($useragent, ['Melvil Favicon']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Melvil/', $useragent)) {
            return new Browser($useragent, 'Melvil Bot', VersionFactory::detectVersion($useragent, ['Melvil']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Pearltrees/', $useragent)) {
            return new Browser($useragent, 'Pearltrees Bot', VersionFactory::detectVersion($useragent, ['Pearltrees']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Svven\-Summarizer/', $useragent)) {
            return new Browser($useragent, 'Svven Summarizer Bot', VersionFactory::detectVersion($useragent, ['Svven\-Summarizer']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Athena Site Analyzer/', $useragent)) {
            return new Browser($useragent, 'Athena Site Analyzer', VersionFactory::detectVersion($useragent, ['Athena Site Analyzer']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Exploratodo/', $useragent)) {
            return new Browser($useragent, 'Exploratodo Bot', VersionFactory::detectVersion($useragent, ['Exploratodo']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/WhatsApp/', $useragent)) {
            return new Browser($useragent, 'WhatsApp', VersionFactory::detectVersion($useragent, ['WhatsApp']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/DDG\-Android\-/', $useragent)) {
            return new Browser($useragent, 'DuckDuck App', VersionFactory::detectVersion($useragent, ['DDG\-Android\-']), 'DuckDuckGo', $bits, new UaBrowserType\Application(), true, false, true, true, true, true, true);
        } elseif (preg_match('/WebCorp/', $useragent)) {
            return new Browser($useragent, 'WebCorp', VersionFactory::detectVersion($useragent, ['WebCorp']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ROR Sitemap Generator/', $useragent)) {
            return new Browser($useragent, 'ROR Sitemap Generator', VersionFactory::detectVersion($useragent, ['ROR Sitemap Generator']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/AuditMyPC Webmaster Tool/', $useragent)) {
            return new Browser($useragent, 'AuditMyPC Webmaster Tool', VersionFactory::detectVersion($useragent, ['AuditMyPC Webmaster Tool']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/XmlSitemapGenerator/', $useragent)) {
            return new Browser($useragent, 'XmlSitemapGenerator', VersionFactory::detectVersion($useragent, ['XmlSitemapGenerator']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Stratagems Kumo/', $useragent)) {
            return new Browser($useragent, 'Stratagems Kumo', VersionFactory::detectVersion($useragent, ['Stratagems Kumo']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, true, false, true, true, true);
        } elseif (preg_match('/YOURLS/', $useragent)) {
            return new Browser($useragent, 'YOURLS', VersionFactory::detectVersion($useragent, ['YOURLS v', 'YOURLS']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Embed PHP Library/', $useragent)) {
            return new Browser($useragent, 'Embed PHP Library', VersionFactory::detectVersion($useragent, ['Embed PHP Library']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SPIP/', $useragent)) {
            return new Browser($useragent, 'SPIP', VersionFactory::detectVersion($useragent, ['SPIP\-', 'SPIP']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Friendica/', $useragent)) {
            return new Browser($useragent, 'Friendica', Friendica::detectVersion($useragent), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/MagpieRSS/', $useragent)) {
            return new Browser($useragent, 'MagpieRSS', VersionFactory::detectVersion($useragent, ['MagpieRSS']), 'Unknown', $bits, new UaBrowserType\FeedReader(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Short URL Checker/', $useragent)) {
            return new Browser($useragent, 'Short URL Checker', VersionFactory::detectVersion($useragent, ['Short URL Checker']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/webnumbrFetcher/', $useragent)) {
            return new Browser($useragent, 'webnumbr Fetcher', VersionFactory::detectVersion($useragent, ['webnumbrFetcher']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(WAP Browser|Spice QT\-75|KKT20\/MIDP)/', $useragent)) {
            return new Browser($useragent, 'WAP Browser', new Version(0), 'Unknown', $bits, new UaBrowserType\WapBrowser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/java/i', $useragent)) {
            return new Browser($useragent, 'Java Standard Library', VersionFactory::detectVersion($useragent, ['Java']), 'Oracle', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(unister\-test|unistertesting|unister\-https\-test)/i', $useragent)) {
            return new Browser($useragent, 'UnisterTesting', VersionFactory::detectVersion($useragent, ['UnisterTesting']), 'Unister', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Ad Muncher/', $useragent)) {
            return new Browser($useragent, 'Ad Muncher', VersionFactory::detectVersion($useragent, ['Ad Muncher', 'Ad Muncher v']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Advanced Email Extractor', $useragent)) {
            return new Browser($useragent, 'Advanced Email Extractor', VersionFactory::detectVersion($useragent, ['Advanced Email Extractor', 'Advanced Email Extractor v']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/aiHitBot/', $useragent)) {
            return new Browser($useragent, 'aiHitBot', VersionFactory::detectVersion($useragent, ['aiHitBot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/alcatel/i', $useragent)) {
            return new Browser($useragent, 'Alcatel', new Version(0), 'Alcatel', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Alcohol Search/', $useragent)) {
            return new Browser($useragent, 'Alcohol Search', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Apache\-HttpClient/', $useragent)) {
            return new Browser($useragent, 'Apache-HttpClient', VersionFactory::detectVersion($useragent, ['Apache\-HttpClient']), 'Apache', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/archive\-de\.com/', $useragent)) {
            return new Browser($useragent, 'Internet Archive DE', VersionFactory::detectVersion($useragent, ['archive\-de\.com']), 'InternetArchiveDe', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ArgClrInt/', $useragent)) {
            return new Browser($useragent, 'ArgClrInt', VersionFactory::detectVersion($useragent, ['ArgClrInt', 'Argclrint']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Ask Jeeves/', $useragent)) {
            return new Browser($useragent, 'Ask Bot', VersionFactory::detectVersion($useragent, ['Ask']), 'Ask', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/AugustBot/', $useragent)) {
            return new Browser($useragent, 'AugustBot', VersionFactory::detectVersion($useragent, ['AugustBot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/awesomebot/i', $useragent)) {
            return new Browser($useragent, 'Awesomebot', VersionFactory::detectVersion($useragent, ['awesomebot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/baidu/i', $useragent)) {
            return new Browser($useragent, 'BaiduSpider', VersionFactory::detectVersion($useragent, ['baiduspider', 'Baiduspider']), 'Baidu', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/benq/i', $useragent)) {
            return new Browser($useragent, 'Benq', new Version(0), 'Benq', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/billigfluegefinal/i', $useragent)) {
            return new Browser($useragent, 'billigFluegeFinal App', VersionFactory::detectVersion($useragent, ['BilligFluegeFinal', 'billigFluegeFinal']), 'Unknown', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (preg_match('/msnbot\-products/i', $useragent)) {
            return new Browser($useragent, 'Bing Product Search', VersionFactory::detectVersion($useragent, ['msnbot\-Products']), 'Microsoft', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/PlayBook/', $useragent)) {
            return new Browser($useragent, 'Blackberry Playbook Tablet', VersionFactory::detectVersion($useragent, ['Version']), 'Rim', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/BlitzBOT/', $useragent)) {
            return new Browser($useragent, 'BlitzBot', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Bluecoat DRTR/', $useragent)) {
            return new Browser($useragent, 'Dynamic Realtime Rating', VersionFactory::detectVersion($useragent, ['Bluecoat DRTR']), 'Bluecoat', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/BND Crawler/', $useragent)) {
            return new Browser($useragent, 'BND Crawler', VersionFactory::detectVersion($useragent, ['BND Crawler']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/BoardReader/', $useragent)) {
            return new Browser($useragent, 'BoardReader', VersionFactory::detectVersion($useragent, ['BoardReader']), 'BoardReader', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/boxee/i', $useragent)) {
            return new Browser($useragent, 'Boxee', VersionFactory::detectVersion($useragent, ['Boxee', 'boxee']), 'Boxee', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/360%20Browser/', $useragent)) {
            return new Browser($useragent, '360 Browser', VersionFactory::detectVersion($useragent, ['360%20Browser']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/BWC/', $useragent)) {
            return new Browser($useragent, 'BWC', VersionFactory::detectVersion($useragent, ['BWC']), 'Bynergy', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Camcrawler/', $useragent)) {
            return new Browser($useragent, 'Camcrawler', VersionFactory::detectVersion($useragent, ['Camcrawler']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/CamelHttpStream/', $useragent)) {
            return new Browser($useragent, 'CamelHttpStream', VersionFactory::detectVersion($useragent, ['CamelHttpStream']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Charlotte/', $useragent)) {
            return new Browser($useragent, 'Charlotte', VersionFactory::detectVersion($useragent, ['Charlotte']), 'Searchme', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/CheckLinks/', $useragent)) {
            return new Browser($useragent, 'CheckLinks', VersionFactory::detectVersion($useragent, ['CheckLinks']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Choosy/', $useragent)) {
            return new Browser($useragent, 'Choosy', VersionFactory::detectVersion($useragent, ['Choosy']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/ClarityDailyBot/', $useragent)) {
            return new Browser($useragent, 'ClarityDailyBot', VersionFactory::detectVersion($useragent, ['ClarityDailyBot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Clipish/', $useragent)) {
            return new Browser($useragent, 'Clipish', VersionFactory::detectVersion($useragent, ['Clipish']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/CloudSurfer/', $useragent)) {
            return new Browser($useragent, 'CloudSurfer', VersionFactory::detectVersion($useragent, ['CloudSurfer']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/commoncrawl/i', $useragent)) {
            return new Browser($useragent, 'commoncrawl', VersionFactory::detectVersion($useragent, ['commoncrawl']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Comodo\-Certificates\-Spider/', $useragent)) {
            return new Browser($useragent, 'Comodo-Certificates-Spider', VersionFactory::detectVersion($useragent, ['Comodo\-Certificates\-Spider']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/CompSpyBot/', $useragent)) {
            return new Browser($useragent, 'CompSpyBot', VersionFactory::detectVersion($useragent, ['CompSpyBot']), 'Compspy', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(CoobyBot|Cooby Bot)/', $useragent)) {
            return new Browser($useragent, 'CoobyBot', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Core\_Class\_HttpClient\_Cached/', $useragent)) {
            return new Browser($useragent, 'Core_Class_HttpClient_Cached', VersionFactory::detectVersion($useragent, ['Core_Class_HttpClient_Cached']), 'Unister', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/CoverScout/', $useragent)) {
            return new Browser($useragent, 'CoverScout', VersionFactory::detectVersion($useragent, ['CoverScout']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/CrystalSemanticsBot/', $useragent)) {
            return new Browser($useragent, 'CrystalSemanticsBot', new Version(0), 'CrystalSemantics', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Curl\/PHP/', $useragent)) {
            return new Browser($useragent, 'cURL PHP', VersionFactory::detectVersion($useragent, ['Curl\/PHP']), 'TeamHaxx', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/CydralSpider/', $useragent)) {
            return new Browser($useragent, 'Cydral Web Image Search', VersionFactory::detectVersion($useragent, ['CydralSpider']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/browser/i', $useragent) && preg_match('/(CFNetwork|Darwin)/', $useragent)) {
            return new Browser($useragent, 'Darwin Browser', new Version(0), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/DCPbot/', $useragent)) {
            return new Browser($useragent, 'DCPbot', VersionFactory::detectVersion($useragent, ['DCPbot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Delibar/', $useragent)) {
            return new Browser($useragent, 'Delibar', VersionFactory::detectVersion($useragent, ['Delibar']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Diga/', $useragent)) {
            return new Browser($useragent, 'Diga', VersionFactory::detectVersion($useragent, ['Diga']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/DoCoMo/', $useragent)) {
            return new Browser($useragent, 'DoCoMo', new Version(0), 'DoCoMo', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/DomainCrawler/', $useragent)) {
            return new Browser($useragent, 'DomainCrawler', VersionFactory::detectVersion($useragent, ['DomainCrawler']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Elefent/', $useragent)) {
            return new Browser($useragent, 'Elefent', VersionFactory::detectVersion($useragent, ['Elefent']), 'Elefent', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ElisaBot/', $useragent)) {
            return new Browser($useragent, 'ElisaBot', VersionFactory::detectVersion($useragent, ['ElisaBot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Eudora/', $useragent)) {
            return new Browser($useragent, 'Eudora', VersionFactory::detectVersion($useragent, ['Eudora']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/(euripbot|www.eurip.com)/i', $useragent)) {
            return new Browser($useragent, 'Europe Internet Portal', VersionFactory::detectVersion($useragent, ['EuripBot']), 'Eurip', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/EventGuruBot/', $useragent)) {
            return new Browser($useragent, 'EventGuru Bot', VersionFactory::detectVersion($useragent, ['EventGuruBot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ExB Language Crawler/', $useragent)) {
            return new Browser($useragent, 'ExB Language Crawler', VersionFactory::detectVersion($useragent, ['ExB Language Crawler']), 'Exb', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Extras4iMovie/', $useragent)) {
            return new Browser($useragent, 'Extras4iMovie', VersionFactory::detectVersion($useragent, ['Extras4iMovie']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/facebookplatform/i', $useragent)) {
            return new Browser($useragent, 'FaceBook Bot', VersionFactory::detectVersion($useragent, ['facebookplatform']), 'Facebook', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/FalkMaps/', $useragent)) {
            return new Browser($useragent, 'FalkMaps', VersionFactory::detectVersion($useragent, ['FalkMaps']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/FeedFinder/', $useragent)) {
            return new Browser($useragent, 'FeedFinder', VersionFactory::detectVersion($useragent, ['FeedFinder']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/findlinks/i', $useragent)) {
            return new Browser($useragent, 'findlinks', VersionFactory::detectVersion($useragent, ['findlinks']), 'WortschatzUniLeipzig', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Firebird/', $useragent)) {
            return new Browser($useragent, 'Firebird', VersionFactory::detectVersion($useragent, ['Firebird']), 'MozillaFoundation', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/webfilter/i', $useragent)) {
            return new Browser($useragent, 'Genieo Web Filter', VersionFactory::detectVersion($useragent, ['Genieo']), 'Genieo', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Genieo/', $useragent)) {
            return new Browser($useragent, 'Genieo', VersionFactory::detectVersion($useragent, ['Genieo']), 'Genieo', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Getleft/', $seragent)) {
            return new Browser($useragent, 'Getleft', VersionFactory::detectVersion($useragent, ['Getleft']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/GetPhotos/', $useragent)) {
            return new Browser($useragent, 'GetPhotos', VersionFactory::detectVersion($useragent, ['GetPhotos']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Godzilla/', $useragent)) {
            return new Browser($useragent, 'Godzilla', VersionFactory::detectVersion($useragent, ['Godzilla']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/adsbot\-google/i', $useragent)) {
            return new Browser($useragent, 'AdsBot Google', VersionFactory::detectVersion($useragent, ['AdsBot\-Google']), 'Google', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Google Earth/', $useragent)) {
            return new Browser($useragent, 'Google Earth', VersionFactory::detectVersion($useragent, ['Google Earth']), 'Google', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/(google\-fontanalysis|www\.google\.com\/webfonts)/i', $useragent)) {
            return new Browser($useragent, 'Google FontAnalysis', VersionFactory::detectVersion($useragent, ['Google\-FontAnalysis']), 'Google', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/GoogleImageProxy/', $useragent)) {
            return new Browser($useragent, 'Google Image Proxy', VersionFactory::detectVersion($useragent, ['GoogleImageProxy']), 'Google', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Google Markup Tester/', $useragent)) {
            return new Browser($useragent, 'Google Markup Tester', VersionFactory::detectVersion($useragent, ['Google Markup Tester']), 'Google', $bits, new UaBrowserType\BotTrancoder(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Google Page Speed/', $useragent)) {
            return new Browser($useragent, 'Google Page Speed', VersionFactory::detectVersion($useragent, ['Google Page Speed']), 'Google', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Google\-Sitemaps/', $useragent)) {
            return new Browser($useragent, 'Google Sitemaps', VersionFactory::detectVersion($useragent, ['Google\-Sitemaps']), 'Google', $bits, new UaBrowserType\Bot(), false, false, false, false, true, true, true);
        } elseif (preg_match('/GoogleTV/', $useragent)) {
            return new Browser($useragent, 'GoogleTV', new Version(0), 'Google', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Google/', $useragent)) {
            return new Browser($useragent, 'Google', new Version(0), 'Google', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Grindr/', $useragent)) {
            return new Browser($useragent, 'Grindr', VersionFactory::detectVersion($useragent, ['Grindr']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/GSLFbot/', $useragent)) {
            return new Browser($useragent, 'GSLFbot', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/HaosouSpider/', $useragent)) {
            return new Browser($useragent, 'HaosouSpider', VersionFactory::detectVersion($useragent, ['360Spider']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/heritrix/i', $useragent)) {
            return new Browser($useragent, 'Heritrix', VersionFactory::detectVersion($useragent, ['heritrix', 'Heritrix']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/HitLeap Viewer/', $useragent)) {
            return new Browser($useragent, 'HitLeap Viewer', VersionFactory::detectVersion($useragent, ['HitLeap Viewer']), 'HitLeap', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Hitpad/', $useragent)) {
            return new Browser($useragent, 'Hitpad', VersionFactory::detectVersion($useragent, ['Hitpad']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Hot Wallpapers/', $useragent)) {
            return new Browser($useragent, 'Hot Wallpapers', VersionFactory::detectVersion($useragent, ['Hot Wallpapers']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Ibisbrowser/', $useragent)) {
            return new Browser($useragent, 'Ibisbrowser', VersionFactory::detectVersion($useragent, ['Ibisbrowser']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/IBrowse/', $useragent)) {
            return new Browser($useragent, 'IBrowse', VersionFactory::detectVersion($useragent, ['IBrowse']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/iBuilder/', $useragent)) {
            return new Browser($useragent, 'iBuilder', VersionFactory::detectVersion($useragent, ['iBuilder']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Icedove/', $useragent)) {
            return new Browser($useragent, 'Icedove', VersionFactory::detectVersion($useragent, ['Icedove']), 'SoftwareInThePublicInterest', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Iceowl/', $useragent)) {
            return new Browser($useragent, 'Iceowl', VersionFactory::detectVersion($useragent, ['Iceowl']), 'SoftwareInThePublicInterest', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/iChromy/', $useragent)) {
            return new Browser($useragent, 'iChromy', new Version(0), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/iCjobs/', $useragent)) {
            return new Browser($useragent, 'iCjobs Crawler', VersionFactory::detectVersion($useragent, ['iCjobs']), 'Icjobs', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ImageMobile/', $useragent)) {
            return new Browser($useragent, 'ImageMobile', VersionFactory::detectVersion($useragent, ['ImageMobile']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(ImageSearcherS|ImageSearcherProS)/', $useragent)) {
            return new Browser($useragent, 'ImageSearcherS', VersionFactory::detectVersion($useragent, ['ImageSearcherS']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Incredimail/', $useragent)) {
            return new Browser($useragent, 'Incredimail', VersionFactory::detectVersion($useragent, ['Incredimail', 'Incredimail\-']), 'Unknown', $bits, new UaBrowserType\EmailClient(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Indy Library/', $useragent)) {
            return new Browser($useragent, 'Indy Library', VersionFactory::detectVersion($useragent, ['Indy Library']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, true, true, true, true, true);
        } elseif (preg_match('/InettvBrowser/', $useragent)) {
            return new Browser($useragent, 'InettvBrowser', VersionFactory::detectVersion($useragent, ['InettvBrowser', 'Version']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Infohelfer/', $useragent)) {
            return new Browser($useragent, 'Infohelfer Crawler', VersionFactory::detectVersion($useragent, ['Infohelfer']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/InsiteRobot/', $useragent)) {
            return new Browser($useragent, 'Insite Robot', VersionFactory::detectVersion($useragent, ['InsiteRobot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Insitesbot/', $useragent)) {
            return new Browser($useragent, 'Insitesbot', VersionFactory::detectVersion($useragent, ['Insitesbot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/integromedb\.org/', $useragent)) {
            return new Browser($useragent, 'IntegromeDB Crawler', VersionFactory::detectVersion($useragent, ['integromedb.org']), 'BiologicalNetworks', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ia\_archiver/', $useragent)) {
            return new Browser($useragent, 'Internet Archive Bot', VersionFactory::detectVersion($useragent, ['ia_archiver']), 'ArchiveOrg', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/iPick/', $useragent)) {
            return new Browser($useragent, 'iPick', VersionFactory::detectVersion($useragent, ['iPick']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/iSource\+/', $useragent)) {
            return new Browser($useragent, 'iSource+ App', VersionFactory::detectVersion($useragent, ['iSource\+']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Wepbot/', $useragent)) {
            return new Browser($useragent, 'Wepbot', VersionFactory::detectVersion($useragent, ['Wepbot']), 'Apache', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Jakarta Commons-HttpClient/', $useragent)) {
            return new Browser($useragent, 'Jakarta Commons HttpClient', VersionFactory::detectVersion($useragent, ['Jakarta Commons\-HttpClient']), 'Apache', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(Jigsaw|W3C\_CSS\_Validator\_JFouffa)/', $useragent)) {
            return new Browser($useragent, 'Jigsaw CSS Validator', VersionFactory::detectVersion($useragent, ['Jigsaw']), 'W3c', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/JUST\-CRAWLER/', $useragent)) {
            return new Browser($useragent, 'Just-Crawler', VersionFactory::detectVersion($useragent, ['JUST\-CRAWLER']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Kindle/', $useragent)) {
            return new Browser($useragent, 'Kindle', VersionFactory::detectVersion($useragent, ['Kindle']), 'Amazon', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/linguatools/', $useragent)) {
            return new Browser($useragent, 'linguatoolsbot', VersionFactory::detectVersion($useragent, ['linguatools']), 'Linguatools', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Linguee Bot/', $useragent)) {
            return new Browser($useragent, 'Linguee Bot', VersionFactory::detectVersion($useragent, ['Linguee Bot']), 'Linguee', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Link\-Checker/', $useragent)) {
            return new Browser($useragent, 'Link-Checker', VersionFactory::detectVersion($useragent, ['Link\-Checker']), 'PwInternetSolutions', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/linkdex\.com/', $useragent)) {
            return new Browser($useragent, 'Linkdex Bot', VersionFactory::detectVersion($useragent, ['linkdex\.com', 'linkdex\.com\/v']), 'Linkdex', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/LinkLint/', $useragent)) {
            return new Browser($useragent, 'LinkLint', VersionFactory::detectVersion($useragent, ['LinkLint\-checkonly', 'LinkLint']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/LinkWalker/', $useragent)) {
            return new Browser($useragent, 'LinkWalker', VersionFactory::detectVersion($useragent, ['LinkWalker']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Little%20Bookmark%20Box/', $useragent)) {
            return new Browser($useragent, 'Little-Bookmark-Box App', VersionFactory::detectVersion($useragent, ['Little%20Bookmark%20Box']), 'Unknown', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (preg_match('/ltbot/i', $useragent)) {
            return new Browser($useragent, 'ltbot', VersionFactory::detectVersion($useragent, ['ltbot']), 'LanguageTools', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/MacInroy Privacy Auditors/', $useragent)) {
            return new Browser($useragent, 'MacInroy Privacy Auditors', VersionFactory::detectVersion($useragent, ['MacInroy Privacy Auditors']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Maemo/', $useragent)) {
            return new Browser($useragent, 'Maemo Browser', VersionFactory::detectVersion($useragent, ['Maemo Browser']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/magpie\-crawler/', $useragent)) {
            return new Browser($useragent, 'Magpie Crawler', VersionFactory::detectVersion($useragent, ['magpie\-crawler']), 'Brandwatch', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(ExchangeWebServices|Mail\/)/', $useragent)) {
            return new Browser($useragent, 'Mail ExchangeWebServices', VersionFactory::detectVersion($useragent, ['ExchangeWebServices', 'Mail']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Maven/', $useragent)) {
            return new Browser($useragent, 'Maven', VersionFactory::detectVersion($useragent, ['Maven']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/WWW\-Mechanize/', $useragent)) {
            return new Browser($useragent, 'WWW-Mechanize', VersionFactory::detectVersion($useragent, ['Mechanize']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Mechanize/', $useragent)) {
            return new Browser($useragent, 'Mechanize', VersionFactory::detectVersion($useragent, ['Mechanize']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Microsoft Windows Network Diagnostics/', $useragent)) {
            return new Browser($useragent, 'Microsoft Windows Network Diagnostics', VersionFactory::detectVersion($useragent, ['Microsoft Windows Network Diagnostics']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Mitsu/', $useragent)) {
            return new Browser($useragent, 'Mitsubishi', new Version(0), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Mjbot/', $useragent)) {
            return new Browser($useragent, 'Mjbot', VersionFactory::detectVersion($useragent, ['Mjbot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/MobileRSS/', $useragent)) {
            return new Browser($useragent, 'MobileRSS', VersionFactory::detectVersion($useragent, ['MobileRSS', 'MobileRSSFree', 'MobileRSSFree\-iPad']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/MovableType/', $useragent)) {
            return new Browser($useragent, 'MovableType Web Log', VersionFactory::detectVersion($useragent, ['MovableType']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Mozad/', $useragent)) {
            return new Browser($useragent, 'Mozad', VersionFactory::detectVersion($useragent, ['Mozad']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Mozilla\//', $useragent)) {
            return new Browser($useragent, 'Mozilla', VersionFactory::detectVersion($useragent, ['rv\:']), 'MozillaFoundation', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/(MSIECrawler|Crawler; MSIE)/', $useragent)) {
            return new Browser($useragent, 'MSIECrawler', VersionFactory::detectVersion($useragent, ['MSIECrawler']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/MS Search/', $useragent)) {
            return new Browser($useragent, 'MS Search', VersionFactory::detectVersion($useragent, ['MS Search']), 'Microsoft', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/MyEngines\-Bot/', $useragent)) {
            return new Browser($useragent, 'MyEngines Bot', VersionFactory::detectVersion($useragent, ['MyEngines-Bot', 'Version: ']), 'DomainDe', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(NEC\-|KGT)/', $useragent)) {
            return new Browser($useragent, 'Nec', new Version(0), 'Nec', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Netbox/', $useragent)) {
            return new Browser($useragent, 'Netbox', VersionFactory::detectVersion($useragent, ['Netbox']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/NetNewsWire/', $useragent)) {
            return new Browser($useragent, 'NetNewsWire', VersionFactory::detectVersion($useragent, ['NetNewsWire']), 'BlackPixel', $bits, new UaBrowserType\Browser(), true, false, false, false, true, true, true);
        } elseif (preg_match('/NetPositive/', $useragent)) {
            return new Browser($useragent, 'NetPositive', VersionFactory::detectVersion($useragent, ['NetPositive']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/NetSurf/', $useragent)) {
            return new Browser($useragent, 'NetSurf', VersionFactory::detectVersion($useragent, ['NetSurf']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/nettv/i', $useragent)) {
            return new Browser($useragent, 'NetTV', VersionFactory::detectVersion($useragent, ['NETTV']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Netvibes/', $useragent)) {
            return new Browser($useragent, 'Netvibes', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(news bot|newsbot)/', $useragent)) {
            return new Browser($useragent, 'News Bot', VersionFactory::detectVersion($useragent, ['news bot', 'news bot ']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/NewsRack/', $useragent)) {
            return new Browser($useragent, 'NewsRack', VersionFactory::detectVersion($useragent, ['NewsRack']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/NixGibts/', $useragent)) {
            return new Browser($useragent, 'NixGibts', VersionFactory::detectVersion($useragent, ['NixGibts']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/http\.clientRequest/i', $useragent) && preg_match('/node\.js/i', $useragent)) {
            return new Browser($useragent, 'node.js HTTP_Request', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/1Password/', $useragent)) {
            return new Browser($useragent, '1Password', VersionFactory::detectVersion($useragent, ['1Password']), 'Apple', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/OpenVAS/', $useragent)) {
            return new Browser($useragent, 'Open Vulnerability Assessment System', VersionFactory::detectVersion($useragent, ['OpenVAS']), 'Openvas', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/OpenWeb/', $useragent)) {
            return new Browser($useragent, 'OpenWeb', VersionFactory::detectVersion($useragent, ['OpenWeb']), 'OpenWave', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Origin/', $useragent)) {
            return new Browser($useragent, 'Origin', VersionFactory::detectVersion($useragent, ['Origin']), 'ElectronicArts', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/OSSProxy/', $useragent)) {
            return new Browser($useragent, 'OSSProxy', VersionFactory::detectVersion($useragent, ['OSSProxy']), 'Marketscore', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Pagebull/', $useragent)) {
            return new Browser($useragent, 'Pagebull', VersionFactory::detectVersion($useragent, ['Pagebull']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/PalmPixi/', $useragent)) {
            return new Browser($useragent, 'PalmPixi', VersionFactory::detectVersion($useragent, ['PalmPixi']), 'Hp', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/PalmPre/', $useragent)) {
            return new Browser($useragent, 'PalmPre', VersionFactory::detectVersion($useragent, ['PalmPre']), 'Hp', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Panasonic/', $useragent)) {
            return new Browser($useragent, 'Panasonic', new Version(0), 'Panasonic', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Pandora/', $useragent)) {
            return new Browser($useragent, 'Pandora', VersionFactory::detectVersion($useragent, ['Pandora']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Parchbot/', $useragent)) {
            return new Browser($useragent, 'Parchbot', VersionFactory::detectVersion($useragent, ['Parchbot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/HTTP_Request2/', $useragent)) {
            return new Browser($useragent, 'PEAR HTTP_Request2', VersionFactory::detectVersion($useragent, ['HTTP_Request2']), 'PhpGroup', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/HTTP_Request/', $useragent)) {
            return new Browser($useragent, 'PEAR HTTP_Request', VersionFactory::detectVersion($useragent, ['HTTP_Request']), 'PhpGroup', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/philips/i', $useragent)) {
            return new Browser($useragent, 'Philips', new Version(0), 'Philips', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Pixray\-Seeker/', $useragent)) {
            return new Browser($useragent, 'Pixray-Seeker', VersionFactory::detectVersion($useragent, ['Pixray\-Seeker']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/playstation 3/i', $useragent)) {
            return new Browser($useragent, 'Playstation Browser', new Version(0), 'Sony', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Playstation/', $useragent)) {
            return new Browser($useragent, 'Playstation', VersionFactory::detectVersion($useragent, ['Playstation']), 'Sony', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Plukkie/', $useragent)) {
            return new Browser($useragent, 'Plukkie', VersionFactory::detectVersion($useragent, ['Plukkie']), 'BotjeCom', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/PodtechNetwork/', $useragent)) {
            return new Browser($useragent, 'Podtech Network', VersionFactory::detectVersion($useragent, ['PodtechNetwork']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Pogodak/', $useragent)) {
            return new Browser($useragent, 'Pogodak', VersionFactory::detectVersion($useragent, ['Pogodak']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Postbox/', $useragent)) {
            return new Browser($useragent, 'Postbox', VersionFactory::detectVersion($useragent, ['Postbox']), 'Postbox', $bits, new UaBrowserType\EmailClient(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Powertv/', $useragent)) {
            return new Browser($useragent, 'Powertv', VersionFactory::detectVersion($useragent, ['Powertv']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Prism/', $useragent)) {
            return new Browser($useragent, 'Prism', VersionFactory::detectVersion($useragent, ['Prism']), 'MozillaFoundation', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/python/i', $useragent)) {
            return new Browser($useragent, 'Python', VersionFactory::detectVersion($useragent, ['Python', 'python\-requests']), 'PythonSoftwareFoundation', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Qihoo/', $useragent)) {
            return new Browser($useragent, 'Qihoo', VersionFactory::detectVersion($useragent, ['Qihoo']), 'Qihoo', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Qtek/', $useragent)) {
            return new Browser($useragent, 'Qtek', new Version(0), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/QtWeb Internet Browser/', $useragent)) {
            return new Browser($useragent, 'QtWeb Internet Browser', VersionFactory::detectVersion($useragent, ['QtWeb Internet Browser']), 'LogicWare', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Quantcastbot/', $useragent)) {
            return new Browser($useragent, 'Quantcastbot', VersionFactory::detectVersion($useragent, ['Quantcastbot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/queryseekerspider/i', $useragent)) {
            return new Browser($useragent, 'QuerySeekerSpider', VersionFactory::detectVersion($useragent, ['QuerySeekerSpider']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Quicktime/', $useragent)) {
            return new Browser($useragent, 'Quicktime', VersionFactory::detectVersion($useragent, ['Quicktime']), 'Apple', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Realplayer/', $useragent)) {
            return new Browser($useragent, 'Realplayer', VersionFactory::detectVersion($useragent, ['Realplayer']), 'RealNetworks', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/RGAnalytics/', $useragent)) {
            return new Browser($useragent, 'RGAnalytics', VersionFactory::detectVersion($useragent, ['RGAnalytics']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Rojo/', $useragent)) {
            return new Browser($useragent, 'Rojo', VersionFactory::detectVersion($useragent, ['Rojo']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/RSSingBot/', $useragent)) {
            return new Browser($useragent, 'RSSingBot', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/RSSOwl/', $useragent)) {
            return new Browser($useragent, 'RSSOwl', VersionFactory::detectVersion($useragent, ['RSSOwl']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Ruky\-Roboter/', $useragent)) {
            return new Browser($useragent, 'Ruky Roboter', VersionFactory::detectVersion($useragent, ['Ruky\-Roboter \(Version\: ']), 'Searchme', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Ruunk/', $useragent)) {
            return new Browser($useragent, 'Ruunk', VersionFactory::detectVersion($useragent, ['Ruunk']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/(SEC\-|Samsung|SAMSUNG|SPH|SGH|SCH)/', $useragent)) {
            return new Browser($useragent, 'Samsung Mobile Browser', new Version(0), 'Samsung', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/sanyo/i', $useragent)) {
            return new Browser($useragent, 'Sanyo', new Version(0), 'Sanyo', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/savetheworldheritage/i', $useragent)) {
            return new Browser($useragent, 'save-the-world-heritage Bot', VersionFactory::detectVersion($useragent, ['savetheworldheritage\.org', 'savetheworldheritage']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Scorpionbot/', $useragent)) {
            return new Browser($useragent, 'Scorpionbot', VersionFactory::detectVersion($useragent, ['Scorpionbot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/scraper/i', $useragent)) {
            return new Browser($useragent, 'scraper', VersionFactory::detectVersion($useragent, ['scraper', 'scraper v']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/searchmetricsbot/i', $useragent)) {
            return new Browser($useragent, 'SearchmetricsBot', new Version(0), 'Searchmetrics', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Semager/', $useragent)) {
            return new Browser($useragent, 'Semager Bot', VersionFactory::detectVersion($useragent, ['Semager']), 'Semager', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SEOENGWorldBot/', $useragent)) {
            return new Browser($useragent, 'SeoEngine World Bot', VersionFactory::detectVersion($useragent, ['SEOENGWorldBot']), 'SeoEngine', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Setooz/', $useragent)) {
            return new Browser($useragent, 'Setooz', VersionFactory::detectVersion($useragent, ['Setooz']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Shiira/', $useragent)) {
            return new Browser($useragent, 'Shiira', VersionFactory::detectVersion($useragent, ['Shiira']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Shopsalad/', $useragent)) {
            return new Browser($useragent, 'Shopsalad', VersionFactory::detectVersion($useragent, ['Shopsalad']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SIE\-/', $useragent)) {
            return new Browser($useragent, 'Siemens', new Version(0), 'Siemens', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/sindice/i', $useragent)) {
            return new Browser($useragent, 'Sindice Fetcher', VersionFactory::detectVersion($useragent, ['sindice\-fetcher']), 'Sindice', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SiteKiosk/', $useragent)) {
            return new Browser($useragent, 'SiteKiosk', VersionFactory::detectVersion($useragent, ['SiteKiosk']), 'Provisio', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/SlimBrowser/', $useragent)) {
            return new Browser($useragent, 'SlimBrowser', VersionFactory::detectVersion($useragent, ['SlimBrowser']), 'FlashPeak', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/SmartSync/', $useragent)) {
            return new Browser($useragent, 'SmartSync App', VersionFactory::detectVersion($useragent, ['SmartSync']), 'Unknown', $bits, new UaBrowserType\Application(), true, false, true, false, true, true, true);
        } elseif (preg_match('/WebBrowser/', $useragent)) {
            return new Browser($useragent, 'SmartTV WebBrowser', VersionFactory::detectVersion($useragent, ['WebBrowser']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/(SmartTV|SMART-TV)/', $useragent)) {
            return new Browser($useragent, 'SmartTV', VersionFactory::detectVersion($useragent, ['SmartTV', 'SMART\-TV', 'WebBrowser']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Snapbot/', $useragent)) {
            return new Browser($useragent, 'Snapbot', VersionFactory::detectVersion($useragent, ['Snapbot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Snoopy/', $useragent)) {
            return new Browser($useragent, 'Snoopy', VersionFactory::detectVersion($useragent, ['Snoopy']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Snowtape/', $useragent)) {
            return new Browser($useragent, 'Snowtape', VersionFactory::detectVersion($useragent, ['Snowtape']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Songbird/', $useragent)) {
            return new Browser($useragent, 'Songbird', VersionFactory::detectVersion($useragent, ['Songbird']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Sosospider/', $useragent)) {
            return new Browser($useragent, 'Sosospider', VersionFactory::detectVersion($useragent, ['Sosospider']), 'Soso', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Space Bison/', $useragent)) {
            return new Browser($useragent, 'Space Bison', VersionFactory::detectVersion($useragent, ['Space Bison']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Spector/', $useragent)) {
            return new Browser($useragent, 'Spector', VersionFactory::detectVersion($useragent, ['Spector', 'Spector%20Pro']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Speedy Spider/', $useragent)) {
            return new Browser($useragent, 'Speedy Spider', VersionFactory::detectVersion($useragent, ['Speedy Spider']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SpellCheck Bot/', $useragent)) {
            return new Browser($useragent, 'SpellCheck Bot', VersionFactory::detectVersion($useragent, ['SpellCheck Bot']), 'Showword', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SpiderLing/', $useragent)) {
            return new Browser($useragent, 'SpiderLing', VersionFactory::detectVersion($useragent, ['SpiderLing']), 'SpiderLing', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Spiderlytics/', $useragent)) {
            return new Browser($useragent, 'Spiderlytics', VersionFactory::detectVersion($useragent, ['Spiderlytics']), 'Spiderlytics', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Spider\-Pig/', $useragent)) {
            return new Browser($useragent, 'Spider-Pig', new Version(0), 'Tinfoilsecurity', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/spray\-can/i', $useragent)) {
            return new Browser($useragent, 'spray-can', VersionFactory::detectVersion($useragent, ['spray\-can']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/SPV/', $useragent)) {
            return new Browser($useragent, 'SPV', new Version(0), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/squidwall/i', $useragent)) {
            return new Browser($useragent, 'squidwall', VersionFactory::detectVersion($useragent, ['squidwall']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Sqwidgebot/', $useragent)) {
            return new Browser($useragent, 'Sqwidgebot', VersionFactory::detectVersion($useragent, ['Sqwidgebot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Strata/', $useragent)) {
            return new Browser($useragent, 'Strata', VersionFactory::detectVersion($useragent, ['Strata']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/StrategicBoardBot/', $useragent)) {
            return new Browser($useragent, 'StrategicBoardBot', VersionFactory::detectVersion($useragent, ['StrategicBoardBot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/StrawberryjamUrlExpander/', $useragent)) {
            return new Browser($useragent, 'Strawberryjam Url Expander', VersionFactory::detectVersion($useragent, ['StrawberryjamUrlExpander']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Sunbird/', $useragent)) {
            return new Browser($useragent, 'Sunbird', VersionFactory::detectVersion($useragent, ['Sunbird']), 'MozillaFoundation', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Superfish/', $useragent)) {
            return new Browser($useragent, 'Superfish', VersionFactory::detectVersion($useragent, ['Superfish']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Superswan/', $useragent)) {
            return new Browser($useragent, 'Superswan', VersionFactory::detectVersion($useragent, ['Superswan']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/SymphonyBrowser/', $useragent)) {
            return new Browser($useragent, 'SymphonyBrowser', VersionFactory::detectVersion($useragent, ['SymphonyBrowser']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/SynapticWalker/', $useragent)) {
            return new Browser($useragent, 'SynapticWalker', VersionFactory::detectVersion($useragent, ['SynapticWalker']), 'Websynaptics', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/TagInspector/', $useragent)) {
            return new Browser($useragent, 'TagInspector', new Version(0), 'Infotrust', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Tailrank/', $useragent)) {
            return new Browser($useragent, 'Tailrank', VersionFactory::detectVersion($useragent, ['Tailrank']), 'Tailrank', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/TasapImageRobot/', $useragent)) {
            return new Browser($useragent, 'TasapImageRobot', VersionFactory::detectVersion($useragent, ['TasapImageRobot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/TenFourFox/', $useragent)) {
            return new Browser($useragent, 'TenFourFox', VersionFactory::detectVersion($useragent, ['TenFourFox']), 'CameronKaiser', $bits, new UaBrowserType\Browser(), true, false, true, true, true, true, true);
        } elseif (preg_match('/Terra/', $useragent)) {
            return new Browser($useragent, 'Terra', VersionFactory::detectVersion($useragent, ['Terra', 'TerraFree', 'TerraFree\-iPad']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/thebat/i', $useragent)) {
            return new Browser($useragent, 'The Bat Download Manager', VersionFactory::detectVersion($useragent, ['thebat']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ThemeSearchAndExtraction\-crawler/', $useragent)) {
            return new Browser($useragent, 'ThemeSearchAndExtractionCrawler', VersionFactory::detectVersion($useragent, ['ThemeSearchAndExtraction\-crawler']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/ThumbShotsBot/', $useragent)) {
            return new Browser($useragent, 'ThumbShotsBot', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Thunderstone/', $useragent)) {
            return new Browser($useragent, 'Thunderstone', VersionFactory::detectVersion($useragent, ['Thunderstone']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/tineye/i', $useragent)) {
            return new Browser($useragent, 'TinEye', VersionFactory::detectVersion($useragent, ['TinEye']), 'TinEye', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/TkcAutodownloader/', $useragent)) {
            return new Browser($useragent, 'TkcAutodownloader', VersionFactory::detectVersion($useragent, ['TkcAutodownloader']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/TLSProber/', $useragent)) {
            return new Browser($useragent, 'TLSProber', VersionFactory::detectVersion($useragent, ['TLSProber']), 'Abonti', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Toshiba/', $useragent)) {
            return new Browser($useragent, 'Toshiba', new Version(0), 'Toshiba', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/trendiction/i', $useragent)) {
            return new Browser($useragent, 'Trendiction Bot', VersionFactory::detectVersion($useragent, ['trendictionbot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/TrendMicro/', $useragent)) {
            return new Browser($useragent, 'Trend Micro', VersionFactory::detectVersion($useragent, ['TrendMicro']), 'TrendMicro', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/TumblrRssSyndication/', $useragent)) {
            return new Browser($useragent, 'TumblrRssSyndication', VersionFactory::detectVersion($useragent, ['TumblrRssSyndication']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/TuringMachine/', $useragent)) {
            return new Browser($useragent, 'TuringMachine', VersionFactory::detectVersion($useragent, ['TuringMachine']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/turnitin/i', $useragent)) {
            return new Browser($useragent, 'TurnitinBot', VersionFactory::detectVersion($useragent, ['TurnitinBot']), 'Iparadigms', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Tweetbot/', $useragent)) {
            return new Browser($useragent, 'Tweetbot', VersionFactory::detectVersion($useragent, ['Tweetbot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/TwengabotDiscover/', $useragent)) {
            return new Browser($useragent, 'TwengabotDiscover', VersionFactory::detectVersion($useragent, ['TwengabotDiscover']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Twitturls/', $useragent)) {
            return new Browser($useragent, 'Twitturls', VersionFactory::detectVersion($useragent, ['Twitturls']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/typo3/i', $useragent)) {
            return new Browser($useragent, 'Typo3', VersionFactory::detectVersion($useragent, ['TYPO3']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/TypoLinkvalidator/', $useragent)) {
            return new Browser($useragent, 'TypoLinkvalidator', VersionFactory::detectVersion($useragent, ['TypoLinkvalidator']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(auto|geld|kredit|versicherungen|preisvergleich|shopping)\.de/', $useragent)) {
            return new Browser($useragent, 'UnisterPortale', new Version(0), 'Unister', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/UoftdbExperiment/', $useragent)) {
            return new Browser($useragent, 'Uoftdb Experiment', VersionFactory::detectVersion($useragent, ['UoftdbExperiment']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Vanillasurf/', $useragent)) {
            return new Browser($useragent, 'Vanillasurf', VersionFactory::detectVersion($useragent, ['Vanillasurf']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Viralheat/', $useragent)) {
            return new Browser($useragent, 'Viral Heat', VersionFactory::detectVersion($useragent, ['Viralheat']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/VmsMosaic/', $useragent)) {
            return new Browser($useragent, 'VmsMosaic', VersionFactory::detectVersion($useragent, ['VmsMosaic']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/vobsub/i', $useragent)) {
            return new Browser($useragent, 'vobsub', VersionFactory::detectVersion($useragent, ['vobsub']), 'Unknown', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/voilabot/i', $useragent)) {
            return new Browser($useragent, 'Voilabot', VersionFactory::detectVersion($useragent, ['Voilabot', 'VoilaBot BETA']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Vonnacom/', $useragent)) {
            return new Browser($useragent, 'Vonnacom', VersionFactory::detectVersion($useragent, ['Vonnacom']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Voyager/', $useragent)) {
            return new Browser($useragent, 'Voyager', VersionFactory::detectVersion($useragent, ['Voyager']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/W3C\-checklink/', $useragent)) {
            return new Browser($useragent, 'W3C-checklink', VersionFactory::detectVersion($useragent, ['W3C\-checklink']), 'W3c', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/W3C\_Validator/', $useragent)) {
            return new Browser($useragent, 'W3C Validator', VersionFactory::detectVersion($useragent, ['W3C_Validator']), 'W3c', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/w3m/i', $useragent)) {
            return new Browser($useragent, 'w3m', VersionFactory::detectVersion($useragent, ['w3m']), 'SakamotoHironori', $bits, new UaBrowserType\Browser(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Webaroo/', $useragent)) {
            return new Browser($useragent, 'Webaroo', VersionFactory::detectVersion($useragent, ['Webaroo']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Webbotru/', $useragent)) {
            return new Browser($useragent, 'Webbotru', VersionFactory::detectVersion($useragent, ['Webbotru']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Webcapture/', $useragent)) {
            return new Browser($useragent, 'Webcapture', VersionFactory::detectVersion($useragent, ['Webcapture']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Web Downloader/', $useragent)) {
            return new Browser($useragent, 'Web Downloader', VersionFactory::detectVersion($useragent, ['Web Downloader']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/WebImages/', $useragent)) {
            return new Browser($useragent, 'WebImages', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Weblide/', $useragent)) {
            return new Browser($useragent, 'Weblide', VersionFactory::detectVersion($useragent, ['Weblide']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Web Link Validator/', $useragent)) {
            return new Browser($useragent, 'Web Link Validator', VersionFactory::detectVersion($useragent, ['Web Link Validator']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/WebmasterworldServerHeaderChecker/', $useragent)) {
            return new Browser($useragent, 'WebmasterworldServerHeaderChecker', VersionFactory::detectVersion($useragent, ['WebmasterworldServerHeaderChecker']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/WebOX/', $useragent)) {
            return new Browser($useragent, 'WebOX', VersionFactory::detectVersion($useragent, ['WebOX']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/Webscan/', $useragent)) {
            return new Browser($useragent, 'Webscan', VersionFactory::detectVersion($useragent, ['Webscan']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Websuchebot/', $useragent)) {
            return new Browser($useragent, 'Websuchebot', VersionFactory::detectVersion($useragent, ['Websuchebot\/Shooter']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/WebTV/', $useragent)) {
            return new Browser($useragent, 'WebTV/MSNTV', VersionFactory::detectVersion($useragent, ['WebTV']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/WI Job Roboter/', $useragent)) {
            return new Browser($useragent, 'WI Job Roboter', VersionFactory::detectVersion($useragent, ['WI Job Roboter Spider Version']), 'WebIntegrationItService', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Wikimpress/', $useragent)) {
            return new Browser($useragent, 'Wikimpress', VersionFactory::detectVersion($useragent, ['Wikimpress']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/WinampMPEG/', $useragent)) {
            return new Browser($useragent, 'Winamp', VersionFactory::detectVersion($useragent, ['WinampMPEG']), 'Unknown', $bits, new UaBrowserType\MultimediaPlayer(), true, false, true, false, true, true, true);
        } elseif (preg_match('/WinkBot/', $useragent)) {
            return new Browser($useragent, 'WinkBot', VersionFactory::detectVersion($useragent, ['WinkBot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/WinWAP/', $useragent)) {
            return new Browser($useragent, 'WinWAP', VersionFactory::detectVersion($useragent, ['WinWAP', 'WinWAP\-PRO']), 'Unknown', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        } elseif (preg_match('/WIRE/', $useragent)) {
            return new Browser($useragent, 'WIRE', VersionFactory::detectVersion($useragent, ['WIRE']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/WISEbot/', $useragent)) {
            return new Browser($useragent, 'WISEbot', VersionFactory::detectVersion($useragent, ['WISEbot']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Wizz RSS News Reader/', $useragent)) {
            return new Browser($useragent, 'Wizz', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/WebIndexer/', $useragent)) {
            return new Browser($useragent, 'WorldLingo', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/WWWeasel Robot v/', $useragent)) {
            return new Browser($useragent, 'World Wide Weasel', VersionFactory::detectVersion($useragent, ['WWWeasel Robot v']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Wotbox/', $useragent)) {
            return new Browser($useragent, 'Wotbox', VersionFactory::detectVersion($useragent, ['Wotbox']), 'Wotbox', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/WWW\_Browser/', $useragent)) {
            return new Browser($useragent, 'WWW Browser', VersionFactory::detectVersion($useragent, ['WWW_Browser']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/WWWC/', $useragent)) {
            return new Browser($useragent, 'WWWC', VersionFactory::detectVersion($useragent, ['WWWC']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/www4mail/i', $useragent)) {
            return new Browser($useragent, 'www4mail', VersionFactory::detectVersion($useragent, ['www4mail']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/wwwster/i', $useragent)) {
            return new Browser($useragent, 'wwwster', VersionFactory::detectVersion($useragent, ['wwwster']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Xaldon WebSpider/', $useragent)) {
            return new Browser($useragent, 'Xaldon WebSpider', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/xChaos\_Arachne/', $useragent)) {
            return new Browser($useragent, 'xChaos Arachne', VersionFactory::detectVersion($useragent, ['xChaos_Arachne']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Xerka WebBot/', $useragent)) {
            return new Browser($useragent, 'Xerka', VersionFactory::detectVersion($useragent, ['Xerka WebBot v']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/XML\-RPC for PHP/', $useragent)) {
            return new Browser($useragent, 'XML-RPC for PHP', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/XSpider/', $useragent)) {
            return new Browser($useragent, 'XSpider', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/cosmos/', $useragent)) {
            return new Browser($useragent, 'Xyleme', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/yacybot/i', $useragent)) {
            return new Browser($useragent, 'YaCy Bot', new Version(0), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/YadowsCrawler/', $useragent)) {
            return new Browser($useragent, 'YadowsCrawler', VersionFactory::detectVersion($useragent, ['YadowsCrawler']), 'Unknown', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/YahooExternalCache/', $useragent)) {
            return new Browser($useragent, 'YahooExternalCache', new Version(0), 'Yahoo', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/YahooMobileMessenger/', $useragent)) {
            return new Browser($useragent, 'Yahoo! Mobile Messenger', VersionFactory::detectVersion($useragent, ['YahooMobileMessenger']), 'Yahoo', $bits, new UaBrowserType\Application(), true, false, false, false, true, true, true);
        } elseif (preg_match('/Yahoo Pipes/', $useragent)) {
            return new Browser($useragent, 'Yahoo! Pipes', VersionFactory::detectVersion($useragent, ['Yahoo Pipes']), 'Yahoo', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/(YahooYSMcm|Scooter|Y!OASIS|YahooYSMcm|YRL_ODP_CRAWLER|yahoo\.com)/', $useragent)) {
            return new Browser($useragent, 'Yahoo!', new Version(0), 'Yahoo', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/YandexImages/', $useragent)) {
            return new Browser($useragent, 'YandexImages', VersionFactory::detectVersion($useragent, ['YandexImages']), 'Yandex', $bits, new UaBrowserType\Bot(), true, false, false, false, true, true, true);
        } elseif (preg_match('/i99(88|99)_custom/', $useragent)) {
            return new Browser($useragent, 'YouWave Android on PC', YouWaveAndroidOnPc::detectVersion($useragent), 'YouWave', $bits, new UaBrowserType\Browser(), true, false, true, false, true, true, true);
        }

        return new Browser($useragent, 'unknown', new Version(0), 'Unknown', $bits, new UaBrowserType\Unknown(), true, false, false, false, true, true, true);
    }
}
