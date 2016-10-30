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

namespace BrowserDetector\Factory;

use BrowserDetector\Bits\Browser as BrowserBits;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use UaBrowserType;
use UaResult\Browser\Browser;
use UaResult\Os\OsInterface;

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
    public function detect(
        $useragent,
        OsInterface $platform = null
    ) {
        $browserKey = 'unknown';

        if (preg_match('/RevIP\.info site analyzer/', $useragent)) {
            $browserKey = 'reverse ip lookup';
        } elseif (preg_match('/reddit pic scraper/i', $useragent)) {
            $browserKey = 'reddit pic scraper';
        } elseif (preg_match('/Mozilla crawl/', $useragent)) {
            $browserKey = 'mozilla crawler';
        } elseif (preg_match('/^\[FBAN/i', $useragent)) {
            $browserKey = 'facebook app';
        } elseif (preg_match('/UCBrowserHD/', $useragent)) {
            $browserKey = 'uc browser hd';
        } elseif (preg_match('/(ucbrowser|uc browser|ucweb)/i', $useragent) && preg_match('/opera mini/i', $useragent)) {
            $browserKey = 'uc browser';
        } elseif (preg_match('/(opera mini|opios)/i', $useragent)) {
            $browserKey = 'opera mini';
        } elseif (preg_match('/opera mobi/i', $useragent)
            || (preg_match('/(opera|opr)/i', $useragent) && preg_match('/(Android|MTK|MAUI|SAMSUNG|Windows CE|SymbOS)/', $useragent))
        ) {
            $browserKey = 'opera mobile';
        } elseif (preg_match('/(ucbrowser|uc browser|ucweb)/i', $useragent)) {
            $browserKey = 'uc browser';
        } elseif (preg_match('/IC OpenGraph Crawler/', $useragent)) {
            $browserKey = 'ibm connections';
        } elseif (preg_match('/coast/i', $useragent)) {
            $browserKey = 'coast';
        } elseif (preg_match('/(opera|opr)/i', $useragent)) {
            $browserKey = 'opera';
        } elseif (preg_match('/iCabMobile/', $useragent)) {
            $browserKey = 'icab mobile';
        } elseif (preg_match('/iCab/', $useragent)) {
            $browserKey = 'icab';
        } elseif (preg_match('/HggH PhantomJS Screenshoter/', $useragent)) {
            $browserKey = 'hggh screenshot system with phantomjs';
        } elseif (preg_match('/bl\.uk\_lddc\_bot/', $useragent)) {
            $browserKey = 'bl.uk_lddc_bot';
        } elseif (preg_match('/phantomas/', $useragent)) {
            $browserKey = 'phantomas';
        } elseif (preg_match('/Seznam screenshot\-generator/', $useragent)) {
            $browserKey = 'seznam screenshot generator';
        } elseif (false !== strpos($useragent, 'PhantomJS')) {
            $browserKey = 'phantomjs';
        } elseif (false !== strpos($useragent, 'YaBrowser')) {
            $browserKey = 'yandex browser';
        } elseif (false !== strpos($useragent, 'Kamelio')) {
            $browserKey = 'kamelio app';
        } elseif (false !== strpos($useragent, 'FBAV')) {
            $browserKey = 'facebook app';
        } elseif (false !== strpos($useragent, 'ACHEETAHI')) {
            $browserKey = 'cm browser';
        } elseif (preg_match('/flyflow/i', $useragent)) {
            $browserKey = 'flyflow';
        } elseif (false !== strpos($useragent, 'bdbrowser_i18n') || false !== strpos($useragent, 'baidubrowser')) {
            $browserKey = 'baidu browser';
        } elseif (false !== strpos($useragent, 'bdbrowserhd_i18n')) {
            $browserKey = 'baidu browser hd';
        } elseif (false !== strpos($useragent, 'bdbrowser_mini')) {
            $browserKey = 'baidu browser mini';
        } elseif (false !== strpos($useragent, 'Puffin')) {
            $browserKey = 'puffin';
        } elseif (preg_match('/stagefright/', $useragent)) {
            $browserKey = 'stagefright';
        } elseif (false !== strpos($useragent, 'SamsungBrowser')) {
            $browserKey = 'samsung browser';
        } elseif (false !== strpos($useragent, 'Silk')) {
            $browserKey = 'silk';
        } elseif (false !== strpos($useragent, 'coc_coc_browser')) {
            $browserKey = 'coc coc browser';
        } elseif (false !== strpos($useragent, 'NaverMatome')) {
            $browserKey = 'matome';
        } elseif (preg_match('/FlipboardProxy/', $useragent)) {
            $browserKey = 'flipboardproxy';
        } elseif (false !== strpos($useragent, 'Flipboard')) {
            $browserKey = 'flipboard app';
        } elseif (false !== strpos($useragent, 'Seznam.cz')) {
            $browserKey = 'seznam browser';
        } elseif (false !== strpos($useragent, 'Aviator')) {
            $browserKey = 'aviator';
        } elseif (preg_match('/NetFrontLifeBrowser/', $useragent)) {
            $browserKey = 'netfrontlifebrowser';
        } elseif (preg_match('/IceDragon/', $useragent)) {
            $browserKey = 'icedragon';
        } elseif (false !== strpos($useragent, 'Dragon') && false === strpos($useragent, 'DragonFly')) {
            $browserKey = 'dragon';
        } elseif (false !== strpos($useragent, 'Beamrise')) {
            $browserKey = 'beamrise';
        } elseif (false !== strpos($useragent, 'Diglo')) {
            $browserKey = 'diglo';
        } elseif (false !== strpos($useragent, 'APUSBrowser')) {
            $browserKey = 'apusbrowser';
        } elseif (false !== strpos($useragent, 'Chedot')) {
            $browserKey = 'chedot';
        } elseif (false !== strpos($useragent, 'Qword')) {
            $browserKey = 'qword browser';
        } elseif (false !== strpos($useragent, 'Iridium')) {
            $browserKey = 'iridium browser';
        } elseif (preg_match('/avant/i', $useragent)) {
            $browserKey = 'avant';
        } elseif (false !== strpos($useragent, 'MxNitro')) {
            $browserKey = 'maxthon nitro';
        } elseif (preg_match('/(mxbrowser|maxthon|myie)/i', $useragent)) {
            $browserKey = 'maxthon';
        } elseif (preg_match('/superbird/i', $useragent)) {
            $browserKey = 'superbird';
        } elseif (false !== strpos($useragent, 'TinyBrowser')) {
            $browserKey = 'tinybrowser';
        } elseif (preg_match('/MicroMessenger/', $useragent)) {
            $browserKey = 'wechat app';
        } elseif (preg_match('/MQQBrowser\/Mini/', $useragent)) {
            $browserKey = 'qqbrowser mini';
        } elseif (preg_match('/MQQBrowser/', $useragent)) {
            $browserKey = 'qqbrowser';
        } elseif (preg_match('/pinterest/i', $useragent)) {
            $browserKey = 'pinterest app';
        } elseif (preg_match('/baiduboxapp/', $useragent)) {
            $browserKey = 'baidu box app';
        } elseif (preg_match('/wkbrowser/', $useragent)) {
            $browserKey = 'wkbrowser';
        } elseif (preg_match('/Mb2345Browser/', $useragent)) {
            $browserKey = '2345 browser';
        } elseif (false !== strpos($useragent, 'Chrome')
            && false !== strpos($useragent, 'Version')
            && 0 < strpos($useragent, 'Chrome')
        ) {
            $browserKey = 'android webview';
        } elseif (false !== strpos($useragent, 'Safari')
            && false !== strpos($useragent, 'Version')
            && false !== strpos($useragent, 'Tizen')
        ) {
            $browserKey = 'samsung webview';
        } elseif (preg_match('/cybeye/i', $useragent)) {
            $browserKey = 'cybeye';
        } elseif (preg_match('/RebelMouse/', $useragent)) {
            $browserKey = 'rebelmouse';
        } elseif (preg_match('/SeaMonkey/', $useragent)) {
            $browserKey = 'seamonkey';
        } elseif (preg_match('/Jobboerse/', $useragent)) {
            $browserKey = 'jobboerse bot';
        } elseif (preg_match('/Navigator/', $useragent)) {
            $browserKey = 'netscape navigator';
        } elseif (preg_match('/firefox/i', $useragent) && preg_match('/anonym/i', $useragent)) {
            $browserKey = 'firefox';
        } elseif (preg_match('/trident/i', $useragent) && preg_match('/anonym/i', $useragent)) {
            $browserKey = 'internet explorer';
        } elseif (preg_match('/Windows\-RSS\-Platform/', $useragent)) {
            $browserKey = 'windows-rss-platform';
        } elseif (preg_match('/MarketwireBot/', $useragent)) {
            $browserKey = 'marketwirebot';
        } elseif (preg_match('/GoogleToolbar/', $useragent)) {
            $browserKey = 'google toolbar';
        } elseif (preg_match('/netscape/i', $useragent) && preg_match('/msie/i', $useragent)) {
            $browserKey = 'netscape';
        } elseif (preg_match('/LSSRocketCrawler/', $useragent)) {
            $browserKey = 'lightspeed systems rocketcrawler';
        } elseif (preg_match('/lightspeedsystems/i', $useragent)) {
            $browserKey = 'lightspeed systems crawler';
        } elseif (preg_match('/SL Commerce Client/', $useragent)) {
            $browserKey = 'second live commerce client';
        } elseif (preg_match('/(IEMobile|WPDesktop|ZuneWP7|XBLWP7)/', $useragent)) {
            $browserKey = 'iemobile';
        } elseif (preg_match('/BingPreview/', $useragent)) {
            $browserKey = 'bing preview';
        } elseif (preg_match('/360Spider/', $useragent)) {
            $browserKey = '360spider';
        } elseif (preg_match('/Outlook\-Express/', $useragent)) {
            $browserKey = 'windows live mail';
        } elseif (preg_match('/Outlook/', $useragent)) {
            $browserKey = 'outlook';
        } elseif (preg_match('/microsoft office mobile/i', $useragent)) {
            $browserKey = 'office';
        } elseif (preg_match('/MSOffice/', $useragent)) {
            $browserKey = 'office';
        } elseif (preg_match('/Microsoft Office Protocol Discovery/', $useragent)) {
            $browserKey = 'ms opd';
        } elseif (preg_match('/excel/i', $useragent)) {
            $browserKey = 'excel';
        } elseif (preg_match('/powerpoint/i', $useragent)) {
            $browserKey = 'powerpoint';
        } elseif (preg_match('/WordPress/', $useragent)) {
            $browserKey = 'wordpress';
        } elseif (preg_match('/Word/', $useragent)) {
            $browserKey = 'word';
        } elseif (preg_match('/OneNote/', $useragent)) {
            $browserKey = 'onenote';
        } elseif (preg_match('/Visio/', $useragent)) {
            $browserKey = 'visio';
        } elseif (preg_match('/Access/', $useragent)) {
            $browserKey = 'access';
        } elseif (preg_match('/Lync/', $useragent)) {
            $browserKey = 'lync';
        } elseif (preg_match('/Office SyncProc/', $useragent)) {
            $browserKey = 'office syncproc';
        } elseif (preg_match('/Office Upload Center/', $useragent)) {
            $browserKey = 'office upload center';
        } elseif (preg_match('/frontpage/i', $useragent)) {
            $browserKey = 'frontpage';
        } elseif (preg_match('/microsoft office/i', $useragent)) {
            $browserKey = 'office';
        } elseif (preg_match('/Crazy Browser/', $useragent)) {
            $browserKey = 'crazy browser';
        } elseif (preg_match('/Deepnet Explorer/', $useragent)) {
            $browserKey = 'deepnet explorer';
        } elseif (preg_match('/kkman/i', $useragent)) {
            $browserKey = 'kkman';
        } elseif (preg_match('/Lunascape/', $useragent)) {
            $browserKey = 'lunascape';
        } elseif (preg_match('/Sleipnir/', $useragent)) {
            $browserKey = 'sleipnir';
        } elseif (preg_match('/Smartsite HTTPClient/', $useragent)) {
            $browserKey = 'smartsite httpclient';
        } elseif (preg_match('/GomezAgent/', $useragent)) {
            $browserKey = 'gomez site monitor';
        } elseif (preg_match('/Mozilla\/5\.0.*\(.*Trident\/8\.0.*rv\:\d+\).*/', $useragent)
            || preg_match('/Mozilla\/5\.0.*\(.*Trident\/7\.0.*\) like Gecko.*/', $useragent)
            || preg_match('/Mozilla\/5\.0.*\(.*MSIE 10\.0.*Trident\/(4|5|6|7|8)\.0.*/', $useragent)
            || preg_match('/Mozilla\/(4|5)\.0.*\(.*MSIE (9|8|7|6)\.0.*/', $useragent)
            || preg_match('/Mozilla\/(4|5)\.0.*\(.*MSIE (5|4)\.\d+.*/', $useragent)
            || preg_match('/Mozilla\/\d\.\d+.*\(.*MSIE (3|2|1)\.\d+.*/', $useragent)
        ) {
            $browserKey = 'internet explorer';
        } elseif (false !== strpos($useragent, 'Chromium')) {
            $browserKey = 'chromium';
        } elseif (false !== strpos($useragent, 'Iron')) {
            $browserKey = 'iron';
        } elseif (preg_match('/midori/i', $useragent)) {
            $browserKey = 'midori';
        } elseif (preg_match('/Google Page Speed Insights/', $useragent)) {
            $browserKey = 'google pagespeed insights';
        } elseif (preg_match('/(web\/snippet)/', $useragent)) {
            $browserKey = 'google web snippet';
        } elseif (preg_match('/(googlebot\-mobile)/i', $useragent)) {
            $browserKey = 'google bot mobile';
        } elseif (preg_match('/Google Wireless Transcoder/', $useragent)) {
            $browserKey = 'google wireless transcoder';
        } elseif (preg_match('/Locubot/', $useragent)) {
            $browserKey = 'locubot';
        } elseif (preg_match('/(com\.google\.GooglePlus)/i', $useragent)) {
            $browserKey = 'google+ app';
        } elseif (preg_match('/Google\-HTTP\-Java\-Client/', $useragent)) {
            $browserKey = 'google http client library for java';
        } elseif (preg_match('/acapbot/i', $useragent)) {
            $browserKey = 'acapbot';
        } elseif (preg_match('/googlebot\-image/i', $useragent)) {
            $browserKey = 'google image search';
        } elseif (preg_match('/googlebot/i', $useragent)) {
            $browserKey = 'google bot';
        } elseif (preg_match('/^GOOG$/', $useragent)) {
            $browserKey = 'google bot';
        } elseif (preg_match('/viera/i', $useragent)) {
            $browserKey = 'smartviera';
        } elseif (preg_match('/Nichrome/', $useragent)) {
            $browserKey = 'nichrome';
        } elseif (preg_match('/Kinza/', $useragent)) {
            $browserKey = 'kinza';
        } elseif (preg_match('/Google Keyword Suggestion/', $useragent)) {
            $browserKey = 'google keyword suggestion';
        } elseif (preg_match('/Google Web Preview/', $useragent)) {
            $browserKey = 'google web preview';
        } elseif (preg_match('/Google-Adwords-DisplayAds-WebRender/', $useragent)) {
            $browserKey = 'google adwords displayads webrender';
        } elseif (preg_match('/HubSpot Webcrawler/', $useragent)) {
            $browserKey = 'hubspot webcrawler';
        } elseif (preg_match('/RockMelt/', $useragent)) {
            $browserKey = 'rockmelt';
        } elseif (preg_match('/ SE /', $useragent)) {
            $browserKey = 'sogou explorer';
        } elseif (preg_match('/ArchiveBot/', $useragent)) {
            $browserKey = 'archivebot';
        } elseif (preg_match('/Edge/', $useragent) && null !== $platform && 'Windows Phone OS' === $platform->getName()) {
            $browserKey = 'edge mobile';
        } elseif (preg_match('/Edge/', $useragent)) {
            $browserKey = 'edge';
        } elseif (preg_match('/diffbot/i', $useragent)) {
            $browserKey = 'diffbot';
        } elseif (preg_match('/vivaldi/i', $useragent)) {
            $browserKey = 'vivaldi';
        } elseif (preg_match('/LBBROWSER/', $useragent)) {
            $browserKey = 'liebao';
        } elseif (preg_match('/Amigo/', $useragent)) {
            $browserKey = 'amigo';
        } elseif (preg_match('/CoolNovoChromePlus/', $useragent)) {
            $browserKey = 'coolnovo chrome plus';
        } elseif (preg_match('/CoolNovo/', $useragent)) {
            $browserKey = 'coolnovo';
        } elseif (preg_match('/Kenshoo/', $useragent)) {
            $browserKey = 'kenshoo';
        } elseif (preg_match('/Bowser/', $useragent)) {
            $browserKey = 'bowser';
        } elseif (preg_match('/360SE/', $useragent)) {
            $browserKey = '360 secure browser';
        } elseif (preg_match('/360EE/', $useragent)) {
            $browserKey = '360 speed browser';
        } elseif (preg_match('/ASW/', $useragent)) {
            $browserKey = 'avast safezone';
        } elseif (preg_match('/Wire/', $useragent)) {
            $browserKey = 'wire app';
        } elseif (preg_match('/chrome\/(\d+)\.(\d+)/i', $useragent, $matches)
            && isset($matches[1])
            && isset($matches[2])
            && $matches[1] >= 1
            && $matches[2] > 0
            && $matches[2] <= 10
        ) {
            $browserKey = 'dragon';
        } elseif (preg_match('/Flock/', $useragent)) {
            $browserKey = 'flock';
        } elseif (preg_match('/Bromium Safari/', $useragent)) {
            $browserKey = 'vsentry';
        } elseif (preg_match('/(chrome|crmo|crios)/i', $useragent)) {
            $browserKey = 'chrome';
        } elseif (preg_match('/(dolphin http client)/i', $useragent)) {
            $browserKey = 'dolphin smalltalk http client';
        } elseif (preg_match('/(dolphin|dolfin)/i', $useragent)) {
            $browserKey = 'dolfin';
        } elseif (preg_match('/Arora/', $useragent)) {
            $browserKey = 'arora';
        } elseif (preg_match('/com\.douban\.group/i', $useragent)) {
            $browserKey = 'douban app';
        } elseif (preg_match('/ovibrowser/i', $useragent)) {
            $browserKey = 'nokia proxy browser';
        } elseif (preg_match('/MiuiBrowser/i', $useragent)) {
            $browserKey = 'miui browser';
        } elseif (preg_match('/ibrowser/i', $useragent)) {
            $browserKey = 'ibrowser';
        } elseif (preg_match('/OneBrowser/', $useragent)) {
            $browserKey = 'onebrowser';
        } elseif (preg_match('/Baiduspider\-image/', $useragent)) {
            $browserKey = 'baidu image search';
        } elseif (preg_match('/http:\/\/www\.baidu\.com\/search/', $useragent)) {
            $browserKey = 'baidu mobile search';
        } elseif (preg_match('/(yjapp|yjtop)/i', $useragent)) {
            $browserKey = 'yahoo! app';
        } elseif (preg_match('/(linux; u; android|linux; android)/i', $useragent) && preg_match('/version/i', $useragent)) {
            $browserKey = 'android webkit';
        } elseif (preg_match('/safari/i', $useragent) && null !== $platform && 'Android' === $platform->getName()) {
            $browserKey = 'android webkit';
        } elseif (preg_match('/Browser\/AppleWebKit/', $useragent)) {
            $browserKey = 'android webkit';
        } elseif (preg_match('/Android\/[\d\.]+ release/', $useragent)) {
            $browserKey = 'android webkit';
        } elseif (false !== strpos($useragent, 'BlackBerry') && false !== strpos($useragent, 'Version')) {
            $browserKey = 'blackberry';
        } elseif (preg_match('/(webOS|wOSBrowser|wOSSystem)/', $useragent)) {
            $browserKey = 'webkit/webos';
        } elseif (preg_match('/OmniWeb/', $useragent)) {
            $browserKey = 'omniweb';
        } elseif (preg_match('/Windows Phone Search/', $useragent)) {
            $browserKey = 'windows phone search';
        } elseif (preg_match('/Windows\-Update\-Agent/', $useragent)) {
            $browserKey = 'windows-update-agent';
        } elseif (preg_match('/nokia/i', $useragent)) {
            $browserKey = 'nokia browser';
        } elseif (preg_match('/twitter for i/i', $useragent)) {
            $browserKey = 'twitter app';
        } elseif (preg_match('/twitterbot/i', $useragent)) {
            $browserKey = 'twitterbot';
        } elseif (preg_match('/GSA/', $useragent)) {
            $browserKey = 'google app';
        } elseif (preg_match('/QtCarBrowser/', $useragent)) {
            $browserKey = 'model s browser';
        } elseif (preg_match('/Qt/', $useragent)) {
            $browserKey = 'qt';
        } elseif (preg_match('/Instagram/', $useragent)) {
            $browserKey = 'instagram app';
        } elseif (preg_match('/WebClip/', $useragent)) {
            $browserKey = 'webclip app';
        } elseif (preg_match('/Mercury/', $useragent)) {
            $browserKey = 'mercury';
        } elseif (preg_match('/MacAppStore/', $useragent)) {
            $browserKey = 'macappstore';
        } elseif (preg_match('/AppStore/', $useragent)) {
            $browserKey = 'apple appstore app';
        } elseif (preg_match('/Webglance/', $useragent)) {
            $browserKey = 'web glance';
        } elseif (preg_match('/YHOO\_Search\_App/', $useragent)) {
            $browserKey = 'yahoo mobile app';
        } elseif (preg_match('/NewsBlur Feed Fetcher/', $useragent)) {
            $browserKey = 'newsblur feed fetcher';
        } elseif (preg_match('/AppleCoreMedia/', $useragent)) {
            $browserKey = 'coremedia';
        } elseif (preg_match('/dataaccessd/', $useragent)) {
            $browserKey = 'ios dataaccessd';
        } elseif (preg_match('/MailChimp/', $useragent)) {
            $browserKey = 'mailchimp.com';
        } elseif (preg_match('/MailBar/', $useragent)) {
            $browserKey = 'mailbar';
        } elseif (preg_match('/^Mail/', $useragent)) {
            $browserKey = 'apple mail';
        } elseif (preg_match('/^Mozilla\/5\.0.*\(.*(CPU iPhone OS|CPU OS) \d+(_|\.)\d+.* like Mac OS X.*\) AppleWebKit.* \(KHTML, like Gecko\)$/', $useragent)) {
            $browserKey = 'apple mail';
        } elseif (preg_match('/^Mozilla\/5\.0 \(Macintosh; Intel Mac OS X.*\) AppleWebKit.* \(KHTML, like Gecko\)$/', $useragent)) {
            $browserKey = 'apple mail';
        } elseif (preg_match('/^Mozilla\/5\.0 \(Windows.*\) AppleWebKit.* \(KHTML, like Gecko\)$/', $useragent)) {
            $browserKey = 'apple mail';
        } elseif (preg_match('/msnbot\-media/i', $useragent)) {
            $browserKey = 'msnbot-media';
        } elseif (preg_match('/adidxbot/i', $useragent)) {
            $browserKey = 'adidxbot';
        } elseif (preg_match('/msnbot/i', $useragent)) {
            $browserKey = 'bingbot';
        } elseif (preg_match('/(backberry|bb10)/i', $useragent)) {
            $browserKey = 'blackberry';
        } elseif (preg_match('/WeTab\-Browser/', $useragent)) {
            $browserKey = 'wetab browser';
        } elseif (preg_match('/profiller/', $useragent)) {
            $browserKey = 'profiller';
        } elseif (preg_match('/(wkhtmltopdf)/i', $useragent)) {
            $browserKey = 'wkhtmltopdf';
        } elseif (preg_match('/(wkhtmltoimage)/i', $useragent)) {
            $browserKey = 'wkhtmltoimage';
        } elseif (preg_match('/(wp\-iphone|wp\-android)/', $useragent)) {
            $browserKey = 'wordpress app';
        } elseif (preg_match('/OktaMobile/', $useragent)) {
            $browserKey = 'okta mobile app';
        } elseif (preg_match('/kmail2/', $useragent)) {
            $browserKey = 'kmail2';
        } elseif (preg_match('/eb\-iphone/', $useragent)) {
            $browserKey = 'eb iphone/ipad app';
        } elseif (preg_match('/ElmediaPlayer/', $useragent)) {
            $browserKey = 'elmedia player';
        } elseif (preg_match('/Schoolwires/', $useragent)) {
            $browserKey = 'schoolwires app';
        } elseif (preg_match('/Dreamweaver/', $useragent)) {
            $browserKey = 'dreamweaver';
        } elseif (preg_match('/akregator/', $useragent)) {
            $browserKey = 'akregator';
        } elseif (preg_match('/Installatron/', $useragent)) {
            $browserKey = 'installatron';
        } elseif (preg_match('/Quora Link Preview/', $useragent)) {
            $browserKey = 'quora link preview bot';
        } elseif (preg_match('/Quora/', $useragent)) {
            $browserKey = 'quora app';
        } elseif (preg_match('/Rocky ChatWork Mobile/', $useragent)) {
            $browserKey = 'rocky chatwork mobile';
        } elseif (preg_match('/AdsBot\-Google\-Mobile/', $useragent)) {
            $browserKey = 'adsbot google-mobile';
        } elseif (preg_match('/epiphany/i', $useragent)) {
            $browserKey = 'epiphany';
        } elseif (preg_match('/rekonq/', $useragent)) {
            $browserKey = 'rekonq';
        } elseif (preg_match('/Skyfire/', $useragent)) {
            $browserKey = 'skyfire';
        } elseif (preg_match('/FlixsteriOS/', $useragent)) {
            $browserKey = 'flixster app';
        } elseif (preg_match('/(adbeat\_bot|adbeat\.com)/', $useragent)) {
            $browserKey = 'adbeat bot';
        } elseif (preg_match('/(SecondLife|Second Life)/', $useragent)) {
            $browserKey = 'second live client';
        } elseif (preg_match('/(Salesforce1|SalesforceTouchContainer)/', $useragent)) {
            $browserKey = 'salesforce app';
        } elseif (preg_match('/(nagios\-plugins|check\_http)/', $useragent)) {
            $browserKey = 'nagios';
        } elseif (preg_match('/bingbot/i', $useragent)) {
            $browserKey = 'bingbot';
        } elseif (preg_match('/Mediapartners\-Google/', $useragent)) {
            $browserKey = 'adsense bot';
        } elseif (preg_match('/SMTBot/', $useragent)) {
            $browserKey = 'smtbot';
        } elseif (preg_match('/domain\.com/', $useragent)) {
            $browserKey = 'pagepeeker screenshot maker';
        } elseif (preg_match('/PagePeeker/', $useragent)) {
            $browserKey = 'pagepeeker';
        } elseif (preg_match('/DiigoBrowser/', $useragent)) {
            $browserKey = 'diigo browser';
        } elseif (preg_match('/kontact/', $useragent)) {
            $browserKey = 'kontact';
        } elseif (preg_match('/QupZilla/', $useragent)) {
            $browserKey = 'qupzilla';
        } elseif (preg_match('/FxiOS/', $useragent)) {
            $browserKey = 'firefox for ios';
        } elseif (preg_match('/qutebrowser/', $useragent)) {
            $browserKey = 'qutebrowser';
        } elseif (preg_match('/Otter/', $useragent)) {
            $browserKey = 'otter';
        } elseif (preg_match('/PaleMoon/', $useragent)) {
            $browserKey = 'palemoon';
        } elseif (preg_match('/slurp/i', $useragent)) {
            $browserKey = 'slurp';
        } elseif (preg_match('/applebot/i', $useragent)) {
            $browserKey = 'applebot';
        } elseif (preg_match('/SoundCloud/', $useragent)) {
            $browserKey = 'soundcloud app';
        } elseif (preg_match('/Rival IQ/', $useragent)) {
            $browserKey = 'rival iq bot';
        } elseif (preg_match('/Evernote Clip Resolver/', $useragent)) {
            $browserKey = 'evernote clip resolver';
        } elseif (preg_match('/Evernote/', $useragent)) {
            $browserKey = 'evernote app';
        } elseif (preg_match('/Fluid/', $useragent)) {
            $browserKey = 'fluid';
        } elseif (preg_match('/safari/i', $useragent)) {
            $browserKey = 'safari';
        } elseif (preg_match('/^Mozilla\/(4|5)\.0 \(Macintosh; .* Mac OS X .*\) AppleWebKit\/.* \(KHTML, like Gecko\) Version\/[\d\.]+$/i', $useragent)) {
            $browserKey = 'safari';
        } elseif (preg_match('/TWCAN\/SportsNet/', $useragent)) {
            $browserKey = 'twc sportsnet';
        } elseif (preg_match('/AdobeAIR/', $useragent)) {
            $browserKey = 'adobe air';
        } elseif (preg_match('/(easouspider)/i', $useragent)) {
            $browserKey = 'easouspider';
        } elseif (preg_match('/^Mozilla\/5\.0.*\((iPhone|iPad|iPod).*\).*AppleWebKit\/.*\(.*KHTML, like Gecko.*\).*Mobile.*/i', $useragent)) {
            $browserKey = 'mobile safari uiwebview';
        } elseif (preg_match('/waterfox/i', $useragent)) {
            $browserKey = 'waterfox';
        } elseif (preg_match('/Thunderbird/', $useragent)) {
            $browserKey = 'thunderbird';
        } elseif (preg_match('/Fennec/', $useragent)) {
            $browserKey = 'fennec';
        } elseif (preg_match('/myibrow/', $useragent)) {
            $browserKey = 'my internet browser';
        } elseif (preg_match('/Daumoa/', $useragent)) {
            $browserKey = 'daumoa';
        } elseif (preg_match('/PaleMoon/', $useragent)) {
            $browserKey = 'palemoon';
        } elseif (preg_match('/iceweasel/i', $useragent)) {
            $browserKey = 'iceweasel';
        } elseif (preg_match('/icecat/i', $useragent)) {
            $browserKey = 'icecat';
        } elseif (preg_match('/iceape/i', $useragent)) {
            $browserKey = 'iceape';
        } elseif (preg_match('/galeon/i', $useragent)) {
            $browserKey = 'galeon';
        } elseif (preg_match('/SurveyBot/', $useragent)) {
            $browserKey = 'surveybot';
        } elseif (preg_match('/aggregator\:Spinn3r/', $useragent)) {
            $browserKey = 'spinn3r rss aggregator';
        } elseif (preg_match('/TweetmemeBot/', $useragent)) {
            $browserKey = 'tweetmeme bot';
        } elseif (preg_match('/Butterfly/', $useragent)) {
            $browserKey = 'butterfly robot';
        } elseif (preg_match('/James BOT/', $useragent)) {
            $browserKey = 'jamesbot';
        } elseif (preg_match('/MSIE or Firefox mutant; not on Windows server/', $useragent)) {
            $browserKey = 'daumoa';
        } elseif (preg_match('/SailfishBrowser/', $useragent)) {
            $browserKey = 'sailfish browser';
        } elseif (preg_match('/KcB/', $useragent)) {
            $browserKey = 'unknown';
        } elseif (preg_match('/kazehakase/i', $useragent)) {
            $browserKey = 'kazehakase';
        } elseif (preg_match('/cometbird/i', $useragent)) {
            $browserKey = 'cometbird';
        } elseif (preg_match('/Camino/', $useragent)) {
            $browserKey = 'camino';
        } elseif (preg_match('/SlimerJS/', $useragent)) {
            $browserKey = 'slimerjs';
        } elseif (preg_match('/MultiZilla/', $useragent)) {
            $browserKey = 'multizilla';
        } elseif (preg_match('/Minimo/', $useragent)) {
            $browserKey = 'minimo';
        } elseif (preg_match('/MicroB/', $useragent)) {
            $browserKey = 'microb';
        } elseif (preg_match('/firefox/i', $useragent)
            && !preg_match('/gecko/i', $useragent)
            && preg_match('/anonymized/i', $useragent)
        ) {
            $browserKey = 'firefox';
        } elseif (preg_match('/(firefox|minefield|shiretoko|bonecho|namoroka)/i', $useragent)) {
            $browserKey = 'firefox';
        } elseif (preg_match('/gvfs/', $useragent)) {
            $browserKey = 'gvfs';
        } elseif (preg_match('/luakit/', $useragent)) {
            $browserKey = 'luakit';
        } elseif (preg_match('/playstation 3/i', $useragent)) {
            $browserKey = 'netfront';
        } elseif (preg_match('/sistrix/i', $useragent)) {
            $browserKey = 'sistrix crawler';
        } elseif (preg_match('/ezooms/i', $useragent)) {
            $browserKey = 'ezooms';
        } elseif (preg_match('/grapefx/i', $useragent)) {
            $browserKey = 'grapefx';
        } elseif (preg_match('/grapeshotcrawler/i', $useragent)) {
            $browserKey = 'grapeshotcrawler';
        } elseif (preg_match('/(mail\.ru)/i', $useragent)) {
            $browserKey = 'mail.ru';
        } elseif (preg_match('/(proximic)/i', $useragent)) {
            $browserKey = 'proximic';
        } elseif (preg_match('/(polaris)/i', $useragent)) {
            $browserKey = 'polaris';
        } elseif (preg_match('/(another web mining tool|awmt)/i', $useragent)) {
            $browserKey = 'another web mining tool';
        } elseif (preg_match('/(wbsearchbot|wbsrch)/i', $useragent)) {
            $browserKey = 'wbsearchbot';
        } elseif (preg_match('/(konqueror)/i', $useragent)) {
            $browserKey = 'konqueror';
        } elseif (preg_match('/(typo3\-linkvalidator)/i', $useragent)) {
            $browserKey = 'typo3 linkvalidator';
        } elseif (preg_match('/feeddlerrss/i', $useragent)) {
            $browserKey = 'feeddler rss reader';
        } elseif (preg_match('/^mozilla\/5\.0 \((iphone|ipad|ipod).*CPU like Mac OS X.*\) AppleWebKit\/\d+/i', $useragent)) {
            $browserKey = 'safari';
        } elseif (preg_match('/(ios|iphone|ipad|ipod)/i', $useragent)) {
            $browserKey = 'mobile safari uiwebview';
        } elseif (preg_match('/paperlibot/i', $useragent)) {
            $browserKey = 'paper.li bot';
        } elseif (preg_match('/spbot/i', $useragent)) {
            $browserKey = 'seoprofiler';
        } elseif (preg_match('/dotbot/i', $useragent)) {
            $browserKey = 'dotbot';
        } elseif (preg_match('/(google\-structureddatatestingtool|Google\-structured\-data\-testing\-tool)/i', $useragent)) {
            $browserKey = 'google structured-data testingtool';
        } elseif (preg_match('/webmastercoffee/i', $useragent)) {
            $browserKey = 'webmastercoffee';
        } elseif (preg_match('/ahrefs/i', $useragent)) {
            $browserKey = 'ahrefsbot';
        } elseif (preg_match('/apercite/i', $useragent)) {
            $browserKey = 'apercite';
        } elseif (preg_match('/woobot/', $useragent)) {
            $browserKey = 'woorank';
        } elseif (preg_match('/Blekkobot/', $useragent)) {
            $browserKey = 'blekkobot';
        } elseif (preg_match('/PagesInventory/', $useragent)) {
            $browserKey = 'pagesinventory bot';
        } elseif (preg_match('/Slackbot\-LinkExpanding/', $useragent)) {
            $browserKey = 'slackbot-link-expanding';
        } elseif (preg_match('/Slackbot/', $useragent)) {
            $browserKey = 'slackbot';
        } elseif (preg_match('/SEOkicks\-Robot/', $useragent)) {
            $browserKey = 'seokicks robot';
        } elseif (preg_match('/Exabot/', $useragent)) {
            $browserKey = 'exabot';
        } elseif (preg_match('/DomainSCAN/', $useragent)) {
            $browserKey = 'domainscan server monitoring';
        } elseif (preg_match('/JobRoboter/', $useragent)) {
            $browserKey = 'jobroboter';
        } elseif (preg_match('/AcoonBot/', $useragent)) {
            $browserKey = 'acoonbot';
        } elseif (preg_match('/woriobot/', $useragent)) {
            $browserKey = 'woriobot';
        } elseif (preg_match('/MonoBot/', $useragent)) {
            $browserKey = 'monobot';
        } elseif (preg_match('/DomainSigmaCrawler/', $useragent)) {
            $browserKey = 'domainsigmacrawler';
        } elseif (preg_match('/bnf\.fr\_bot/', $useragent)) {
            $browserKey = 'bnf.fr bot';
        } elseif (preg_match('/CrawlRobot/', $useragent)) {
            $browserKey = 'crawlrobot';
        } elseif (preg_match('/AddThis\.com robot/', $useragent)) {
            $browserKey = 'addthis.com robot';
        } elseif (preg_match('/(Yeti|naver\.com\/robots)/', $useragent)) {
            $browserKey = 'naverbot';
        } elseif (preg_match('/^robots$/', $useragent)) {
            $browserKey = 'testcrawler';
        } elseif (preg_match('/DeuSu/', $useragent)) {
            $browserKey = 'werbefreie deutsche suchmaschine';
        } elseif (preg_match('/obot/i', $useragent)) {
            $browserKey = 'obot';
        } elseif (preg_match('/ZumBot/', $useragent)) {
            $browserKey = 'zumbot';
        } elseif (preg_match('/(umbot)/i', $useragent)) {
            $browserKey = 'umbot';
        } elseif (preg_match('/(picmole)/i', $useragent)) {
            $browserKey = 'picmole bot';
        } elseif (preg_match('/(zollard)/i', $useragent)) {
            $browserKey = 'zollard worm';
        } elseif (preg_match('/(fhscan core)/i', $useragent)) {
            $browserKey = 'fhscan core';
        } elseif (preg_match('/nbot/i', $useragent)) {
            $browserKey = 'nbot';
        } elseif (preg_match('/(loadtimebot)/i', $useragent)) {
            $browserKey = 'loadtimebot';
        } elseif (preg_match('/(scrubby)/i', $useragent)) {
            $browserKey = 'scrubby';
        } elseif (preg_match('/(squzer)/i', $useragent)) {
            $browserKey = 'squzer';
        } elseif (preg_match('/PiplBot/', $useragent)) {
            $browserKey = 'piplbot';
        } elseif (preg_match('/EveryoneSocialBot/', $useragent)) {
            $browserKey = 'everyonesocialbot';
        } elseif (preg_match('/AOLbot/', $useragent)) {
            $browserKey = 'aolbot';
        } elseif (preg_match('/GLBot/', $useragent)) {
            $browserKey = 'glbot';
        } elseif (preg_match('/(lbot)/i', $useragent)) {
            $browserKey = 'lbot';
        } elseif (preg_match('/(blexbot)/i', $useragent)) {
            $browserKey = 'blexbot';
        } elseif (preg_match('/(socialradarbot)/i', $useragent)) {
            $browserKey = 'socialradar bot';
        } elseif (preg_match('/(synapse)/i', $useragent)) {
            $browserKey = 'apache synapse';
        } elseif (preg_match('/(linkdexbot)/i', $useragent)) {
            $browserKey = 'linkdex bot';
        } elseif (preg_match('/(coccoc)/i', $useragent)) {
            $browserKey = 'coccoc bot';
        } elseif (preg_match('/(siteexplorer)/i', $useragent)) {
            $browserKey = 'siteexplorer';
        } elseif (preg_match('/(semrushbot)/i', $useragent)) {
            $browserKey = 'semrushbot';
        } elseif (preg_match('/(istellabot)/i', $useragent)) {
            $browserKey = 'istellabot';
        } elseif (preg_match('/(meanpathbot)/i', $useragent)) {
            $browserKey = 'meanpathbot';
        } elseif (preg_match('/(XML Sitemaps Generator)/', $useragent)) {
            $browserKey = 'xml sitemaps generator';
        } elseif (preg_match('/SeznamBot/', $useragent)) {
            $browserKey = 'seznambot';
        } elseif (preg_match('/URLAppendBot/', $useragent)) {
            $browserKey = 'urlappendbot';
        } elseif (preg_match('/NetSeer crawler/', $useragent)) {
            $browserKey = 'netseer crawler';
        } elseif (preg_match('/SeznamBot/', $useragent)) {
            $browserKey = 'seznambot';
        } elseif (preg_match('/Add Catalog/', $useragent)) {
            $browserKey = 'add catalog';
        } elseif (preg_match('/Moreover/', $useragent)) {
            $browserKey = 'moreover';
        } elseif (preg_match('/LinkpadBot/', $useragent)) {
            $browserKey = 'linkpadbot';
        } elseif (preg_match('/Lipperhey SEO Service/', $useragent)) {
            $browserKey = 'lipperhey seo service';
        } elseif (preg_match('/Blog Search/', $useragent)) {
            $browserKey = 'blog search';
        } elseif (preg_match('/Qualidator\.com Bot/', $useragent)) {
            $browserKey = 'qualidator.com bot';
        } elseif (preg_match('/fr\-crawler/', $useragent)) {
            $browserKey = 'fr-crawler';
        } elseif (preg_match('/ca\-crawler/', $useragent)) {
            $browserKey = 'ca-crawler';
        } elseif (preg_match('/Website Thumbnail Generator/', $useragent)) {
            $browserKey = 'website thumbnail generator';
        } elseif (preg_match('/WebThumb/', $useragent)) {
            $browserKey = 'webthumb';
        } elseif (preg_match('/KomodiaBot/', $useragent)) {
            $browserKey = 'komodiabot';
        } elseif (preg_match('/GroupHigh/', $useragent)) {
            $browserKey = 'grouphigh bot';
        } elseif (preg_match('/theoldreader/', $useragent)) {
            $browserKey = 'the old reader';
        } elseif (preg_match('/Google\-Site\-Verification/', $useragent)) {
            $browserKey = 'google-site-verification';
        } elseif (preg_match('/Prlog/', $useragent)) {
            $browserKey = 'prlog';
        } elseif (preg_match('/CMS Crawler/', $useragent)) {
            $browserKey = 'cms crawler';
        } elseif (preg_match('/pmoz\.info ODP link checker/', $useragent)) {
            $browserKey = 'pmoz.info odp link checker';
        } elseif (preg_match('/Twingly Recon/', $useragent)) {
            $browserKey = 'twingly recon';
        } elseif (preg_match('/Embedly/', $useragent)) {
            $browserKey = 'embedly';
        } elseif (preg_match('/Alexabot/', $useragent)) {
            $browserKey = 'alexabot';
        } elseif (preg_match('/alexa site audit/', $useragent)) {
            $browserKey = 'alexa site audit';
        } elseif (preg_match('/MJ12bot/', $useragent)) {
            $browserKey = 'mj12bot';
        } elseif (preg_match('/HTTrack/', $useragent)) {
            $browserKey = 'httrack';
        } elseif (preg_match('/UnisterBot/', $useragent)) {
            $browserKey = 'unisterbot';
        } elseif (preg_match('/CareerBot/', $useragent)) {
            $browserKey = 'careerbot';
        } elseif (preg_match('/80legs/i', $useragent)) {
            $browserKey = '80legs';
        } elseif (preg_match('/wada\.vn/i', $useragent)) {
            $browserKey = 'wada.vn search bot';
        } elseif (preg_match('/(NX|WiiU|Nintendo 3DS)/', $useragent)) {
            $browserKey = 'netfront nx';
        } elseif (preg_match('/(netfront|playstation 4)/i', $useragent)) {
            $browserKey = 'netfront';
        } elseif (preg_match('/XoviBot/', $useragent)) {
            $browserKey = 'xovibot';
        } elseif (preg_match('/007ac9 Crawler/', $useragent)) {
            $browserKey = '007ac9 crawler';
        } elseif (preg_match('/200PleaseBot/', $useragent)) {
            $browserKey = '200pleasebot';
        } elseif (preg_match('/Abonti/', $useragent)) {
            $browserKey = 'abonti websearch';
        } elseif (preg_match('/publiclibraryarchive/', $useragent)) {
            $browserKey = 'publiclibraryarchive bot';
        } elseif (preg_match('/PAD\-bot/', $useragent)) {
            $browserKey = 'pad-bot';
        } elseif (preg_match('/SoftListBot/', $useragent)) {
            $browserKey = 'softlistbot';
        } elseif (preg_match('/sReleaseBot/', $useragent)) {
            $browserKey = 'sreleasebot';
        } elseif (preg_match('/Vagabondo/', $useragent)) {
            $browserKey = 'vagabondo';
        } elseif (preg_match('/special\_archiver/', $useragent)) {
            $browserKey = 'internet archive special archiver';
        } elseif (preg_match('/Optimizer/', $useragent)) {
            $browserKey = 'optimizer bot';
        } elseif (preg_match('/Sophora Linkchecker/', $useragent)) {
            $browserKey = 'sophora linkchecker';
        } elseif (preg_match('/SEOdiver/', $useragent)) {
            $browserKey = 'seodiver bot';
        } elseif (preg_match('/itsscan/', $useragent)) {
            $browserKey = 'itsscan';
        } elseif (preg_match('/Google Desktop/', $useragent)) {
            $browserKey = 'google desktop';
        } elseif (preg_match('/Lotus\-Notes/', $useragent)) {
            $browserKey = 'lotus notes';
        } elseif (preg_match('/AskPeterBot/', $useragent)) {
            $browserKey = 'askpeterbot';
        } elseif (preg_match('/discoverybot/', $useragent)) {
            $browserKey = 'discovery bot';
        } elseif (preg_match('/YandexBot/', $useragent)) {
            $browserKey = 'yandexbot';
        } elseif (preg_match('/MOSBookmarks/', $useragent) && preg_match('/Link Checker/', $useragent)) {
            $browserKey = 'mosbookmarks link checker';
        } elseif (preg_match('/MOSBookmarks/', $useragent)) {
            $browserKey = 'mosbookmarks';
        } elseif (preg_match('/WebMasterAid/', $useragent)) {
            $browserKey = 'webmasteraid';
        } elseif (preg_match('/AboutUsBot Johnny5/', $useragent)) {
            $browserKey = 'aboutus bot johnny5';
        } elseif (preg_match('/AboutUsBot/', $useragent)) {
            $browserKey = 'aboutus bot';
        } elseif (preg_match('/semantic\-visions\.com crawler/', $useragent)) {
            $browserKey = 'semantic-visions.com crawler';
        } elseif (preg_match('/waybackarchive\.org/', $useragent)) {
            $browserKey = 'wayback archive bot';
        } elseif (preg_match('/OpenVAS/', $useragent)) {
            $browserKey = 'open vulnerability assessment system';
        } elseif (preg_match('/MixrankBot/', $useragent)) {
            $browserKey = 'mixrankbot';
        } elseif (preg_match('/InfegyAtlas/', $useragent)) {
            $browserKey = 'infegyatlas';
        } elseif (preg_match('/MojeekBot/', $useragent)) {
            $browserKey = 'mojeekbot';
        } elseif (preg_match('/memorybot/i', $useragent)) {
            $browserKey = 'memorybot';
        } elseif (preg_match('/DomainAppender/', $useragent)) {
            $browserKey = 'domainappender bot';
        } elseif (preg_match('/GIDBot/', $useragent)) {
            $browserKey = 'gidbot';
        } elseif (preg_match('/DBot/', $useragent)) {
            $browserKey = 'dbot';
        } elseif (preg_match('/PWBot/', $useragent)) {
            $browserKey = 'pwbot';
        } elseif (preg_match('/\+5Bot/', $useragent)) {
            $browserKey = 'plus5bot';
        } elseif (preg_match('/WASALive\-Bot/', $useragent)) {
            $browserKey = 'wasalive bot';
        } elseif (preg_match('/OpenHoseBot/', $useragent)) {
            $browserKey = 'openhosebot';
        } elseif (preg_match('/URLfilterDB\-crawler/', $useragent)) {
            $browserKey = 'urlfilterdb crawler';
        } elseif (preg_match('/metager2\-verification\-bot/', $useragent)) {
            $browserKey = 'metager2-verification-bot';
        } elseif (preg_match('/Powermarks/', $useragent)) {
            $browserKey = 'powermarks';
        } elseif (preg_match('/CloudFlare\-AlwaysOnline/', $useragent)) {
            $browserKey = 'cloudflare alwaysonline';
        } elseif (preg_match('/Phantom\.js bot/', $useragent)) {
            $browserKey = 'phantom.js bot';
        } elseif (preg_match('/Phantom/', $useragent)) {
            $browserKey = 'phantom browser';
        } elseif (preg_match('/Shrook/', $useragent)) {
            $browserKey = 'shrook';
        } elseif (preg_match('/netEstate NE Crawler/', $useragent)) {
            $browserKey = 'netestate ne crawler';
        } elseif (preg_match('/garlikcrawler/i', $useragent)) {
            $browserKey = 'garlikcrawler';
        } elseif (preg_match('/metageneratorcrawler/i', $useragent)) {
            $browserKey = 'metageneratorcrawler';
        } elseif (preg_match('/ScreenerBot/', $useragent)) {
            $browserKey = 'screenerbot';
        } elseif (preg_match('/WebTarantula\.com Crawler/', $useragent)) {
            $browserKey = 'webtarantula';
        } elseif (preg_match('/BacklinkCrawler/', $useragent)) {
            $browserKey = 'backlinkcrawler';
        } elseif (preg_match('/LinksCrawler/', $useragent)) {
            $browserKey = 'linkscrawler';
        } elseif (preg_match('/(ssearch\_bot|sSearch Crawler)/', $useragent)) {
            $browserKey = 'ssearch crawler';
        } elseif (preg_match('/HRCrawler/', $useragent)) {
            $browserKey = 'hrcrawler';
        } elseif (preg_match('/ICC\-Crawler/', $useragent)) {
            $browserKey = 'icc-crawler';
        } elseif (preg_match('/Arachnida Web Crawler/', $useragent)) {
            $browserKey = 'arachnida web crawler';
        } elseif (preg_match('/Finderlein Research Crawler/', $useragent)) {
            $browserKey = 'finderlein research crawler';
        } elseif (preg_match('/TestCrawler/', $useragent)) {
            $browserKey = 'testcrawler';
        } elseif (preg_match('/Scopia Crawler/', $useragent)) {
            $browserKey = 'scopia crawler';
        } elseif (preg_match('/Crawler/', $useragent)) {
            $browserKey = 'crawler';
        } elseif (preg_match('/MetaJobBot/', $useragent)) {
            $browserKey = 'metajobbot';
        } elseif (preg_match('/jig browser web/', $useragent)) {
            $browserKey = 'jig browser web';
        } elseif (preg_match('/T\-H\-U\-N\-D\-E\-R\-S\-T\-O\-N\-E/', $useragent)) {
            $browserKey = 'texis webscript';
        } elseif (preg_match('/focuseekbot/', $useragent)) {
            $browserKey = 'focuseekbot';
        } elseif (preg_match('/vBSEO/', $useragent)) {
            $browserKey = 'vbulletin seo bot';
        } elseif (preg_match('/kgbody/', $useragent)) {
            $browserKey = 'kgbody';
        } elseif (preg_match('/JobdiggerSpider/', $useragent)) {
            $browserKey = 'jobdiggerspider';
        } elseif (preg_match('/imrbot/', $useragent)) {
            $browserKey = 'mignify bot';
        } elseif (preg_match('/kulturarw3/', $useragent)) {
            $browserKey = 'kulturarw3';
        } elseif (preg_match('/LucidWorks/', $useragent)) {
            $browserKey = 'lucidworks bot';
        } elseif (preg_match('/MerchantCentricBot/', $useragent)) {
            $browserKey = 'merchantcentricbot';
        } elseif (preg_match('/Nett\.io bot/', $useragent)) {
            $browserKey = 'nett.io bot';
        } elseif (preg_match('/SemanticBot/', $useragent)) {
            $browserKey = 'semanticbot';
        } elseif (preg_match('/tweetedtimes/i', $useragent)) {
            $browserKey = 'tweetedtimes bot';
        } elseif (preg_match('/vkShare/', $useragent)) {
            $browserKey = 'vkshare';
        } elseif (preg_match('/Yahoo Ad monitoring/', $useragent)) {
            $browserKey = 'yahoo ad monitoring';
        } elseif (preg_match('/YioopBot/', $useragent)) {
            $browserKey = 'yioopbot';
        } elseif (preg_match('/zitebot/', $useragent)) {
            $browserKey = 'zitebot';
        } elseif (preg_match('/Espial/', $useragent)) {
            $browserKey = 'espial tv browser';
        } elseif (preg_match('/SiteCon/', $useragent)) {
            $browserKey = 'sitecon';
        } elseif (preg_match('/iBooks Author/', $useragent)) {
            $browserKey = 'ibooks author';
        } elseif (preg_match('/iWeb/', $useragent)) {
            $browserKey = 'iweb';
        } elseif (preg_match('/NewsFire/', $useragent)) {
            $browserKey = 'newsfire';
        } elseif (preg_match('/RMSnapKit/', $useragent)) {
            $browserKey = 'rmsnapkit';
        } elseif (preg_match('/Sandvox/', $useragent)) {
            $browserKey = 'sandvox';
        } elseif (preg_match('/TubeTV/', $useragent)) {
            $browserKey = 'tubetv';
        } elseif (preg_match('/Elluminate Live/', $useragent)) {
            $browserKey = 'elluminate live';
        } elseif (preg_match('/Element Browser/', $useragent)) {
            $browserKey = 'element browser';
        } elseif (preg_match('/K\-Meleon/', $useragent)) {
            $browserKey = 'k-meleon';
        } elseif (preg_match('/Esribot/', $useragent)) {
            $browserKey = 'esribot';
        } elseif (preg_match('/QuickLook/', $useragent)) {
            $browserKey = 'quicklook';
        } elseif (preg_match('/dillo/i', $useragent)) {
            $browserKey = 'dillo';
        } elseif (preg_match('/Digg/', $useragent)) {
            $browserKey = 'digg bot';
        } elseif (preg_match('/Zetakey/', $useragent)) {
            $browserKey = 'zetakey browser';
        } elseif (preg_match('/getprismatic\.com/', $useragent)) {
            $browserKey = 'prismatic app';
        } elseif (preg_match('/(FOMA|SH05C)/', $useragent)) {
            $browserKey = 'sharp';
        } elseif (preg_match('/OpenWebKitSharp/', $useragent)) {
            $browserKey = 'open-webkit-sharp';
        } elseif (preg_match('/AjaxSnapBot/', $useragent)) {
            $browserKey = 'ajaxsnapbot';
        } elseif (preg_match('/Owler/', $useragent)) {
            $browserKey = 'owler bot';
        } elseif (preg_match('/Yahoo Link Preview/', $useragent)) {
            $browserKey = 'yahoo link preview';
        } elseif (preg_match('/pub\-crawler/', $useragent)) {
            $browserKey = 'pub-crawler';
        } elseif (preg_match('/Kraken/', $useragent)) {
            $browserKey = 'kraken';
        } elseif (preg_match('/Qwantify/', $useragent)) {
            $browserKey = 'qwantify';
        } elseif (preg_match('/SetLinks bot/', $useragent)) {
            $browserKey = 'setlinks.ru crawler';
        } elseif (preg_match('/MegaIndex\.ru/', $useragent)) {
            $browserKey = 'megaindex bot';
        } elseif (preg_match('/Cliqzbot/', $useragent)) {
            $browserKey = 'cliqzbot';
        } elseif (preg_match('/DAWINCI ANTIPLAG SPIDER/', $useragent)) {
            $browserKey = 'dawinci antiplag spider';
        } elseif (preg_match('/AdvBot/', $useragent)) {
            $browserKey = 'advbot';
        } elseif (preg_match('/DuckDuckGo\-Favicons\-Bot/', $useragent)) {
            $browserKey = 'duckduck favicons bot';
        } elseif (preg_match('/ZyBorg/', $useragent)) {
            $browserKey = 'wisenut search engine crawler';
        } elseif (preg_match('/HyperCrawl/', $useragent)) {
            $browserKey = 'hypercrawl';
        } elseif (preg_match('/ARCHIVE\.ORG\.UA crawler/', $useragent)) {
            $browserKey = 'internet archive';
        } elseif (preg_match('/worldwebheritage/', $useragent)) {
            $browserKey = 'worldwebheritage.org bot';
        } elseif (preg_match('/BegunAdvertising/', $useragent)) {
            $browserKey = 'begun advertising bot';
        } elseif (preg_match('/TrendWinHttp/', $useragent)) {
            $browserKey = 'trendwinhttp';
        } elseif (preg_match('/(winhttp|winhttprequest)/i', $useragent)) {
            $browserKey = 'winhttp';
        } elseif (preg_match('/SkypeUriPreview/', $useragent)) {
            $browserKey = 'skypeuripreview';
        } elseif (preg_match('/ScoutJet/', $useragent)) {
            $browserKey = 'scoutjet';
        } elseif (preg_match('/Lipperhey\-Kaus\-Australis/', $useragent)) {
            $browserKey = 'lipperhey kaus australis';
        } elseif (preg_match('/Digincore bot/', $useragent)) {
            $browserKey = 'digincore bot';
        } elseif (preg_match('/Steeler/', $useragent)) {
            $browserKey = 'steeler';
        } elseif (preg_match('/Orangebot/', $useragent)) {
            $browserKey = 'orangebot';
        } elseif (preg_match('/Jasmine/', $useragent)) {
            $browserKey = 'jasmine';
        } elseif (preg_match('/electricmonk/', $useragent)) {
            $browserKey = 'duedil crawler';
        } elseif (preg_match('/yoozBot/', $useragent)) {
            $browserKey = 'yoozbot';
        } elseif (preg_match('/online\-webceo\-bot/', $useragent)) {
            $browserKey = 'webceo bot';
        } elseif (preg_match('/^Mozilla\/5\.0 \(.*\) Gecko\/.*\/\d+/', $useragent)
            && !preg_match('/Netscape/', $useragent)
        ) {
            $browserKey = 'firefox';
        } elseif (preg_match('/^Mozilla\/5\.0 \(.*rv:\d+\.\d+.*\) Gecko\/.*\//', $useragent)
            && !preg_match('/Netscape/', $useragent)
        ) {
            $browserKey = 'firefox';
        } elseif (preg_match('/Netscape/', $useragent)) {
            $browserKey = 'netscape';
        } elseif (preg_match('/^Mozilla\/5\.0$/', $useragent)) {
            $browserKey = 'unknown';
        } elseif (preg_match('/Virtuoso/', $useragent)) {
            $browserKey = 'virtuoso';
        } elseif (preg_match('/^Mozilla\/(3|4)\.\d+/', $useragent, $matches)
            && !preg_match('/(msie|android)/i', $useragent, $matches)
        ) {
            $browserKey = 'netscape';
        } elseif (preg_match('/^Dalvik\/\d/', $useragent)) {
            $browserKey = 'dalvik';
        } elseif (preg_match('/niki\-bot/', $useragent)) {
            $browserKey = 'nikibot';
        } elseif (preg_match('/ContextAd Bot/', $useragent)) {
            $browserKey = 'contextad bot';
        } elseif (preg_match('/integrity/', $useragent)) {
            $browserKey = 'integrity';
        } elseif (preg_match('/masscan/', $useragent)) {
            $browserKey = 'download accelerator';
        } elseif (preg_match('/ZmEu/', $useragent)) {
            $browserKey = 'zmeu';
        } elseif (preg_match('/sogou web spider/i', $useragent)) {
            $browserKey = 'sogou web spider';
        } elseif (preg_match('/(OpenWave|UP\.Browser|UP\/)/', $useragent)) {
            $browserKey = 'openwave mobile browser';
        } elseif (preg_match('/(ObigoInternetBrowser|obigo\-browser|Obigo|Teleca)(\/|-)Q(\d+)/', $useragent)) {
            $browserKey = 'obigo q';
        } elseif (preg_match('/(Teleca|Obigo|MIC\/|AU\-MIC)/', $useragent)) {
            $browserKey = 'teleca-obigo';
        } elseif (preg_match('/DavClnt/', $useragent)) {
            $browserKey = 'microsoft-webdav';
        } elseif (preg_match('/XING\-contenttabreceiver/', $useragent)) {
            $browserKey = 'xing contenttabreceiver';
        } elseif (preg_match('/Slingstone/', $useragent)) {
            $browserKey = 'yahoo slingstone';
        } elseif (preg_match('/BOT for JCE/', $useragent)) {
            $browserKey = 'bot for jce';
        } elseif (preg_match('/Validator\.nu\/LV/', $useragent)) {
            $browserKey = 'validator.nu/lv';
        } elseif (preg_match('/Curb/', $useragent)) {
            $browserKey = 'curb';
        } elseif (preg_match('/link_thumbnailer/', $useragent)) {
            $browserKey = 'link_thumbnailer';
        } elseif (preg_match('/Ruby/', $useragent)) {
            $browserKey = 'generic ruby crawler';
        } elseif (preg_match('/securepoint cf/', $useragent)) {
            $browserKey = 'securepoint content filter';
        } elseif (preg_match('/sogou\-spider/i', $useragent)) {
            $browserKey = 'sogou spider';
        } elseif (preg_match('/rankflex/i', $useragent)) {
            $browserKey = 'rankflex';
        } elseif (preg_match('/domnutch/i', $useragent)) {
            $browserKey = 'domnutch bot';
        } elseif (preg_match('/discovered/i', $useragent)) {
            $browserKey = 'discovered';
        } elseif (preg_match('/nutch/i', $useragent)) {
            $browserKey = 'nutch';
        } elseif (preg_match('/boardreader favicon fetcher/i', $useragent)) {
            $browserKey = 'boardreader favicon fetcher';
        } elseif (preg_match('/checksite verification agent/i', $useragent)) {
            $browserKey = 'checksite verification agent';
        } elseif (preg_match('/experibot/i', $useragent)) {
            $browserKey = 'experibot';
        } elseif (preg_match('/feedblitz/i', $useragent)) {
            $browserKey = 'feedblitz';
        } elseif (preg_match('/rss2html/i', $useragent)) {
            $browserKey = 'rss2html';
        } elseif (preg_match('/feedlyapp/i', $useragent)) {
            $browserKey = 'feedly app';
        } elseif (preg_match('/genderanalyzer/i', $useragent)) {
            $browserKey = 'genderanalyzer';
        } elseif (preg_match('/gooblog/i', $useragent)) {
            $browserKey = 'gooblog';
        } elseif (preg_match('/tumblr/i', $useragent)) {
            $browserKey = 'tumblr app';
        } elseif (preg_match('/w3c\_i18n\-checker/i', $useragent)) {
            $browserKey = 'w3c i18n checker';
        } elseif (preg_match('/w3c\_unicorn/i', $useragent)) {
            $browserKey = 'w3c unicorn';
        } elseif (preg_match('/alltop/i', $useragent)) {
            $browserKey = 'alltop app';
        } elseif (preg_match('/internetseer/i', $useragent)) {
            $browserKey = 'internetseer.com';
        } elseif (preg_match('/ADmantX Platform Semantic Analyzer/', $useragent)) {
            $browserKey = 'admantx platform semantic analyzer';
        } elseif (preg_match('/UniversalFeedParser/', $useragent)) {
            $browserKey = 'universalfeedparser';
        } elseif (preg_match('/(binlar|larbin)/i', $useragent)) {
            $browserKey = 'larbin';
        } elseif (preg_match('/unityplayer/i', $useragent)) {
            $browserKey = 'unity web player';
        } elseif (preg_match('/WeSEE\:Search/', $useragent)) {
            $browserKey = 'wesee:search';
        } elseif (preg_match('/WeSEE\:Ads/', $useragent)) {
            $browserKey = 'wesee:ads';
        } elseif (preg_match('/A6\-Indexer/', $useragent)) {
            $browserKey = 'a6-indexer';
        } elseif (preg_match('/NerdyBot/', $useragent)) {
            $browserKey = 'nerdybot';
        } elseif (preg_match('/Peeplo Screenshot Bot/', $useragent)) {
            $browserKey = 'peeplo screenshot bot';
        } elseif (preg_match('/CCBot/', $useragent)) {
            $browserKey = 'ccbot';
        } elseif (preg_match('/visionutils/', $useragent)) {
            $browserKey = 'visionutils';
        } elseif (preg_match('/Feedly/', $useragent)) {
            $browserKey = 'feedly feed fetcher';
        } elseif (preg_match('/Photon/', $useragent)) {
            $browserKey = 'photon';
        } elseif (preg_match('/WDG\_Validator/', $useragent)) {
            $browserKey = 'html validator';
        } elseif (preg_match('/Aboundex/', $useragent)) {
            $browserKey = 'aboundexbot';
        } elseif (preg_match('/YisouSpider/', $useragent)) {
            $browserKey = 'yisouspider';
        } elseif (preg_match('/hivaBot/', $useragent)) {
            $browserKey = 'hivabot';
        } elseif (preg_match('/Comodo Spider/', $useragent)) {
            $browserKey = 'comodo spider';
        } elseif (preg_match('/OpenWebSpider/i', $useragent)) {
            $browserKey = 'openwebspider';
        } elseif (preg_match('/R6_CommentReader/i', $useragent)) {
            $browserKey = 'r6 commentreader';
        } elseif (preg_match('/R6_FeedFetcher/i', $useragent)) {
            $browserKey = 'r6 feedfetcher';
        } elseif (preg_match('/(psbot\-image|psbot\-page)/i', $useragent)) {
            $browserKey = 'picsearch bot';
        } elseif (preg_match('/Bloglovin/', $useragent)) {
            $browserKey = 'bloglovin bot';
        } elseif (preg_match('/viralvideochart/i', $useragent)) {
            $browserKey = 'viralvideochart bot';
        } elseif (preg_match('/MetaHeadersBot/', $useragent)) {
            $browserKey = 'metaheadersbot';
        } elseif (preg_match('/Zend\_Http\_Client/', $useragent)) {
            $browserKey = 'zend_http_client';
        } elseif (preg_match('/wget/i', $useragent)) {
            $browserKey = 'wget';
        } elseif (preg_match('/Scrapy/', $useragent)) {
            $browserKey = 'scrapy';
        } elseif (preg_match('/Moozilla/', $useragent)) {
            $browserKey = 'moozilla';
        } elseif (preg_match('/AntBot/', $useragent)) {
            $browserKey = 'antbot';
        } elseif (preg_match('/Browsershots/', $useragent)) {
            $browserKey = 'browsershots';
        } elseif (preg_match('/revolt/', $useragent)) {
            $browserKey = 'bot revolt';
        } elseif (preg_match('/pdrlabs/i', $useragent)) {
            $browserKey = 'pdrlabs bot';
        } elseif (preg_match('/elinks/i', $useragent)) {
            $browserKey = 'elinks';
        } elseif (preg_match('/Links/', $useragent)) {
            $browserKey = 'links';
        } elseif (preg_match('/Airmail/', $useragent)) {
            $browserKey = 'airmail';
        } elseif (preg_match('/SonyEricsson/', $useragent)) {
            $browserKey = 'semc';
        } elseif (preg_match('/WEB\.DE MailCheck/', $useragent)) {
            $browserKey = 'web.de mailcheck';
        } elseif (preg_match('/Screaming Frog SEO Spider/', $useragent)) {
            $browserKey = 'screaming frog seo spider';
        } elseif (preg_match('/AndroidDownloadManager/', $useragent)) {
            $browserKey = 'android download manager';
        } elseif (preg_match('/Go ([\d\.]+) package http/', $useragent)) {
            $browserKey = 'go httpclient';
        } elseif (preg_match('/Go-http-client/', $useragent)) {
            $browserKey = 'go httpclient';
        } elseif (preg_match('/Proxy Gear Pro/', $useragent)) {
            $browserKey = 'proxy gear pro';
        } elseif (preg_match('/WAP Browser\/MAUI/', $useragent)) {
            $browserKey = 'maui wap browser';
        } elseif (preg_match('/Tiny Tiny RSS/', $useragent)) {
            $browserKey = 'tiny tiny rss';
        } elseif (preg_match('/Readability/', $useragent)) {
            $browserKey = 'readability';
        } elseif (preg_match('/NSPlayer/', $useragent)) {
            $browserKey = 'windows media player';
        } elseif (preg_match('/Pingdom/', $useragent)) {
            $browserKey = 'pingdom';
        } elseif (preg_match('/crazywebcrawler/i', $useragent)) {
            $browserKey = 'crazywebcrawler';
        } elseif (preg_match('/GG PeekBot/', $useragent)) {
            $browserKey = 'gg peekbot';
        } elseif (preg_match('/iTunes/', $useragent)) {
            $browserKey = 'itunes';
        } elseif (preg_match('/LibreOffice/', $useragent)) {
            $browserKey = 'libreoffice';
        } elseif (preg_match('/OpenOffice/', $useragent)) {
            $browserKey = 'openoffice';
        } elseif (preg_match('/ThumbnailAgent/', $useragent)) {
            $browserKey = 'thumbnailagent';
        } elseif (preg_match('/LinkStats Bot/', $useragent)) {
            $browserKey = 'linkstats bot';
        } elseif (preg_match('/eZ Publish Link Validator/', $useragent)) {
            $browserKey = 'ez publish link validator';
        } elseif (preg_match('/ThumbSniper/', $useragent)) {
            $browserKey = 'thumbsniper';
        } elseif (preg_match('/stq\_bot/', $useragent)) {
            $browserKey = 'searchteq bot';
        } elseif (preg_match('/SNK Screenshot Bot/', $useragent)) {
            $browserKey = 'save n keep screenshot bot';
        } elseif (preg_match('/SynHttpClient/', $useragent)) {
            $browserKey = 'synhttpclient';
        } elseif (preg_match('/HTTPClient/', $useragent)) {
            $browserKey = 'httpclient';
        } elseif (preg_match('/T\-Online Browser/', $useragent)) {
            $browserKey = 't-online browser';
        } elseif (preg_match('/ImplisenseBot/', $useragent)) {
            $browserKey = 'implisensebot';
        } elseif (preg_match('/BuiBui\-Bot/', $useragent)) {
            $browserKey = 'buibui-bot';
        } elseif (preg_match('/thumbshots\-de\-bot/', $useragent)) {
            $browserKey = 'thumbshots-de-bot';
        } elseif (preg_match('/python\-requests/', $useragent)) {
            $browserKey = 'python-requests';
        } elseif (preg_match('/Python\-urllib/', $useragent)) {
            $browserKey = 'python-urllib';
        } elseif (preg_match('/Bot\.AraTurka\.com/', $useragent)) {
            $browserKey = 'bot.araturka.com';
        } elseif (preg_match('/http\_requester/', $useragent)) {
            $browserKey = 'http_requester';
        } elseif (preg_match('/WhatWeb/', $useragent)) {
            $browserKey = 'whatweb web scanner';
        } elseif (preg_match('/isc header collector handlers/', $useragent)) {
            $browserKey = 'isc header collector handlers';
        } elseif (preg_match('/Thumbor/', $useragent)) {
            $browserKey = 'thumbor';
        } elseif (preg_match('/Forum Poster/', $useragent)) {
            $browserKey = 'forum poster';
        } elseif (preg_match('/crawler4j/', $useragent)) {
            $browserKey = 'crawler4j';
        } elseif (preg_match('/Facebot/', $useragent)) {
            $browserKey = 'facebot';
        } elseif (preg_match('/NetzCheckBot/', $useragent)) {
            $browserKey = 'netzcheckbot';
        } elseif (preg_match('/MIB/', $useragent)) {
            $browserKey = 'motorola internet browser';
        } elseif (preg_match('/facebookscraper/', $useragent)) {
            $browserKey = 'facebookscraper';
        } elseif (preg_match('/Zookabot/', $useragent)) {
            $browserKey = 'zookabot';
        } elseif (preg_match('/MetaURI/', $useragent)) {
            $browserKey = 'metauri bot';
        } elseif (preg_match('/FreeWebMonitoring SiteChecker/', $useragent)) {
            $browserKey = 'freewebmonitoring sitechecker';
        } elseif (preg_match('/IPv4Scan/', $useragent)) {
            $browserKey = 'ipv4scan';
        } elseif (preg_match('/RED/', $useragent)) {
            $browserKey = 'redbot';
        } elseif (preg_match('/domainsbot/', $useragent)) {
            $browserKey = 'domainsbot';
        } elseif (preg_match('/BUbiNG/', $useragent)) {
            $browserKey = 'bubing bot';
        } elseif (preg_match('/RamblerMail/', $useragent)) {
            $browserKey = 'ramblermail bot';
        } elseif (preg_match('/ichiro\/mobile/', $useragent)) {
            $browserKey = 'ichiro mobile bot';
        } elseif (preg_match('/ichiro/', $useragent)) {
            $browserKey = 'ichiro bot';
        } elseif (preg_match('/iisbot/', $useragent)) {
            $browserKey = 'iis site analysis web crawler';
        } elseif (preg_match('/JoobleBot/', $useragent)) {
            $browserKey = 'jooblebot';
        } elseif (preg_match('/Superfeedr bot/', $useragent)) {
            $browserKey = 'superfeedr bot';
        } elseif (preg_match('/FeedBurner/', $useragent)) {
            $browserKey = 'feedburner';
        } elseif (preg_match('/Fastladder/', $useragent)) {
            $browserKey = 'fastladder';
        } elseif (preg_match('/livedoor/', $useragent)) {
            $browserKey = 'livedoor';
        } elseif (preg_match('/Icarus6j/', $useragent)) {
            $browserKey = 'icarus6j';
        } elseif (preg_match('/wsr\-agent/', $useragent)) {
            $browserKey = 'wsr-agent';
        } elseif (preg_match('/Blogshares Spiders/', $useragent)) {
            $browserKey = 'blogshares spiders';
        } elseif (preg_match('/TinEye\-bot/', $useragent)) {
            $browserKey = 'tineye bot';
        } elseif (preg_match('/QuickiWiki/', $useragent)) {
            $browserKey = 'quickiwiki bot';
        } elseif (preg_match('/PycURL/', $useragent)) {
            $browserKey = 'pycurl';
        } elseif (preg_match('/libcurl\-agent/', $useragent)) {
            $browserKey = 'libcurl';
        } elseif (preg_match('/Taproot/', $useragent)) {
            $browserKey = 'taproot bot';
        } elseif (preg_match('/GuzzleHttp/', $useragent)) {
            $browserKey = 'guzzle http client';
        } elseif (preg_match('/curl/i', $useragent)) {
            $browserKey = 'curl';
        } elseif (preg_match('/^PHP/', $useragent)) {
            $browserKey = 'php';
        } elseif (preg_match('/Apple\-PubSub/', $useragent)) {
            $browserKey = 'apple pubsub';
        } elseif (preg_match('/SimplePie/', $useragent)) {
            $browserKey = 'simplepie';
        } elseif (preg_match('/BigBozz/', $useragent)) {
            $browserKey = 'bigbozz - financial search';
        } elseif (preg_match('/ECCP/', $useragent)) {
            $browserKey = 'eccp';
        } elseif (preg_match('/facebookexternalhit/', $useragent)) {
            $browserKey = 'facebookexternalhit';
        } elseif (preg_match('/GigablastOpenSource/', $useragent)) {
            $browserKey = 'gigablast search engine';
        } elseif (preg_match('/WebIndex/', $useragent)) {
            $browserKey = 'webindex';
        } elseif (preg_match('/Prince/', $useragent)) {
            $browserKey = 'prince';
        } elseif (preg_match('/adsense\-snapshot\-google/i', $useragent)) {
            $browserKey = 'adsense snapshot bot';
        } elseif (preg_match('/Amazon CloudFront/', $useragent)) {
            $browserKey = 'amazon cloudfront';
        } elseif (preg_match('/bandscraper/', $useragent)) {
            $browserKey = 'bandscraper';
        } elseif (preg_match('/bitlybot/', $useragent)) {
            $browserKey = 'bitlybot';
        } elseif (preg_match('/^bot$/', $useragent)) {
            $browserKey = 'bot';
        } elseif (preg_match('/cars\-app\-browser/', $useragent)) {
            $browserKey = 'cars-app-browser';
        } elseif (preg_match('/Coursera\-Mobile/', $useragent)) {
            $browserKey = 'coursera mobile app';
        } elseif (preg_match('/Crowsnest/', $useragent)) {
            $browserKey = 'crowsnest mobile app';
        } elseif (preg_match('/Dorado WAP\-Browser/', $useragent)) {
            $browserKey = 'dorado wap browser';
        } elseif (preg_match('/Goldfire Server/', $useragent)) {
            $browserKey = 'goldfire server';
        } elseif (preg_match('/EventMachine HttpClient/', $useragent)) {
            $browserKey = 'eventmachine httpclient';
        } elseif (preg_match('/iBall/', $useragent)) {
            $browserKey = 'iball';
        } elseif (preg_match('/InAGist URL Resolver/', $useragent)) {
            $browserKey = 'inagist url resolver';
        } elseif (preg_match('/Jeode/', $useragent)) {
            $browserKey = 'jeode';
        } elseif (preg_match('/kraken/', $useragent)) {
            $browserKey = 'krakenjs';
        } elseif (preg_match('/com\.linkedin/', $useragent)) {
            $browserKey = 'linkedinbot';
        } elseif (preg_match('/LivelapBot/', $useragent)) {
            $browserKey = 'livelap crawler';
        } elseif (preg_match('/MixBot/', $useragent)) {
            $browserKey = 'mixbot';
        } elseif (preg_match('/BuSecurityProject/', $useragent)) {
            $browserKey = 'busecurityproject';
        } elseif (preg_match('/PageFreezer/', $useragent)) {
            $browserKey = 'pagefreezer';
        } elseif (preg_match('/restify/', $useragent)) {
            $browserKey = 'restify';
        } elseif (preg_match('/ShowyouBot/', $useragent)) {
            $browserKey = 'showyoubot';
        } elseif (preg_match('/vlc/i', $useragent)) {
            $browserKey = 'vlc media player';
        } elseif (preg_match('/WebRingChecker/', $useragent)) {
            $browserKey = 'webringchecker';
        } elseif (preg_match('/bot\-pge\.chlooe\.com/', $useragent)) {
            $browserKey = 'chlooe bot';
        } elseif (preg_match('/seebot/', $useragent)) {
            $browserKey = 'seebot';
        } elseif (preg_match('/ltx71/', $useragent)) {
            $browserKey = 'ltx71 bot';
        } elseif (preg_match('/CookieReports/', $useragent)) {
            $browserKey = 'cookie reports bot';
        } elseif (preg_match('/Elmer/', $useragent)) {
            $browserKey = 'elmer';
        } elseif (preg_match('/Iframely/', $useragent)) {
            $browserKey = 'iframely bot';
        } elseif (preg_match('/MetaInspector/', $useragent)) {
            $browserKey = 'metainspector';
        } elseif (preg_match('/Microsoft\-CryptoAPI/', $useragent)) {
            $browserKey = 'microsoft cryptoapi';
        } elseif (preg_match('/OWASP\_SECRET\_BROWSER/', $useragent)) {
            $browserKey = 'owasp_secret_browser';
        } elseif (preg_match('/SMRF URL Expander/', $useragent)) {
            $browserKey = 'smrf url expander';
        } elseif (preg_match('/Speedy Spider/', $useragent)) {
            $browserKey = 'entireweb';
        } elseif (preg_match('/kizasi\-spider/', $useragent)) {
            $browserKey = 'kizasi-spider';
        } elseif (preg_match('/Superarama\.com \- BOT/', $useragent)) {
            $browserKey = 'superarama.com - bot';
        } elseif (preg_match('/WNMbot/', $useragent)) {
            $browserKey = 'wnmbot';
        } elseif (preg_match('/Website Explorer/', $useragent)) {
            $browserKey = 'website explorer';
        } elseif (preg_match('/city\-map screenshot service/', $useragent)) {
            $browserKey = 'city-map screenshot service';
        } elseif (preg_match('/gosquared\-thumbnailer/', $useragent)) {
            $browserKey = 'gosquared-thumbnailer';
        } elseif (preg_match('/optivo\(R\) NetHelper/', $useragent)) {
            $browserKey = 'optivo nethelper';
        } elseif (preg_match('/pr\-cy\.ru Screenshot Bot/', $useragent)) {
            $browserKey = 'screenshot bot';
        } elseif (preg_match('/Cyberduck/', $useragent)) {
            $browserKey = 'cyberduck';
        } elseif (preg_match('/Lynx/', $useragent)) {
            $browserKey = 'lynx';
        } elseif (preg_match('/AccServer/', $useragent)) {
            $browserKey = 'accserver';
        } elseif (preg_match('/SafeSearch microdata crawler/', $useragent)) {
            $browserKey = 'safesearch microdata crawler';
        } elseif (preg_match('/iZSearch/', $useragent)) {
            $browserKey = 'izsearch bot';
        } elseif (preg_match('/NetLyzer FastProbe/', $useragent)) {
            $browserKey = 'netlyzer fastprobe';
        } elseif (preg_match('/MnoGoSearch/', $useragent)) {
            $browserKey = 'mnogosearch';
        } elseif (preg_match('/uipbot/', $useragent)) {
            $browserKey = 'uipbot';
        } elseif (preg_match('/mbot/', $useragent)) {
            $browserKey = 'mbot';
        } elseif (preg_match('/MS Web Services Client Protocol/', $useragent)) {
            $browserKey = '.net framework clr';
        } elseif (preg_match('/(AtomicBrowser|AtomicLite)/', $useragent)) {
            $browserKey = 'atomic browser';
        } elseif (preg_match('/AppEngine\-Google/', $useragent)) {
            $browserKey = 'google app engine';
        } elseif (preg_match('/Feedfetcher\-Google/', $useragent)) {
            $browserKey = 'google feedfetcher';
        } elseif (preg_match('/Google/', $useragent)) {
            $browserKey = 'google app';
        } elseif (preg_match('/UnwindFetchor/', $useragent)) {
            $browserKey = 'unwindfetchor';
        } elseif (preg_match('/Perfect%20Browser/', $useragent)) {
            $browserKey = 'perfect browser';
        } elseif (preg_match('/Reeder/', $useragent)) {
            $browserKey = 'reeder';
        } elseif (preg_match('/FastBrowser/', $useragent)) {
            $browserKey = 'fastbrowser';
        } elseif (preg_match('/CFNetwork/', $useragent)) {
            $browserKey = 'cfnetwork';
        } elseif (preg_match('/Y\!J\-(ASR|BSC)/', $useragent)) {
            $browserKey = 'yahoo! japan';
        } elseif (preg_match('/test certificate info/', $useragent)) {
            $browserKey = 'test certificate info';
        } elseif (preg_match('/fastbot crawler/', $useragent)) {
            $browserKey = 'fastbot crawler';
        } elseif (preg_match('/Riddler/', $useragent)) {
            $browserKey = 'riddler';
        } elseif (preg_match('/SophosUpdateManager/', $useragent)) {
            $browserKey = 'sophosupdatemanager';
        } elseif (preg_match('/(Debian|Ubuntu) APT\-HTTP/', $useragent)) {
            $browserKey = 'apt http transport';
        } elseif (preg_match('/urlgrabber/', $useragent)) {
            $browserKey = 'url grabber';
        } elseif (preg_match('/UCS \(ESX\)/', $useragent)) {
            $browserKey = 'univention corporate server';
        } elseif (preg_match('/libwww\-perl/', $useragent)) {
            $browserKey = 'libwww';
        } elseif (preg_match('/OpenBSD ftp/', $useragent)) {
            $browserKey = 'openbsd ftp';
        } elseif (preg_match('/SophosAgent/', $useragent)) {
            $browserKey = 'sophosagent';
        } elseif (preg_match('/jupdate/', $useragent)) {
            $browserKey = 'jupdate';
        } elseif (preg_match('/Roku\/DVP/', $useragent)) {
            $browserKey = 'roku dvp';
        } elseif (preg_match('/VocusBot/', $useragent)) {
            $browserKey = 'vocusbot';
        } elseif (preg_match('/PostRank/', $useragent)) {
            $browserKey = 'postrank';
        } elseif (preg_match('/rogerbot/i', $useragent)) {
            $browserKey = 'rogerbot';
        } elseif (preg_match('/Safeassign/', $useragent)) {
            $browserKey = 'safeassign';
        } elseif (preg_match('/ExaleadCloudView/', $useragent)) {
            $browserKey = 'exalead cloudview';
        } elseif (preg_match('/Typhoeus/', $useragent)) {
            $browserKey = 'typhoeus';
        } elseif (preg_match('/Camo Asset Proxy/', $useragent)) {
            $browserKey = 'camo asset proxy';
        } elseif (preg_match('/YahooCacheSystem/', $useragent)) {
            $browserKey = 'yahoocachesystem';
        } elseif (preg_match('/wmtips\.com/', $useragent)) {
            $browserKey = 'webmaster tips bot';
        } elseif (preg_match('/linkCheck/', $useragent)) {
            $browserKey = 'linkcheck';
        } elseif (preg_match('/ABrowse/', $useragent)) {
            $browserKey = 'abrowse';
        } elseif (preg_match('/GWPImages/', $useragent)) {
            $browserKey = 'gwpimages';
        } elseif (preg_match('/NoteTextView/', $useragent)) {
            $browserKey = 'notetextview';
        } elseif (preg_match('/NING/', $useragent)) {
            $browserKey = 'ning';
        } elseif (preg_match('/Sprinklr/', $useragent)) {
            $browserKey = 'sprinklr';
        } elseif (preg_match('/URLChecker/', $useragent)) {
            $browserKey = 'urlchecker';
        } elseif (preg_match('/newsme/', $useragent)) {
            $browserKey = 'newsme';
        } elseif (preg_match('/Traackr/', $useragent)) {
            $browserKey = 'traackr';
        } elseif (preg_match('/nineconnections/', $useragent)) {
            $browserKey = 'nineconnections';
        } elseif (preg_match('/Xenu Link Sleuth/', $useragent)) {
            $browserKey = 'xenus link sleuth';
        } elseif (preg_match('/superagent/', $useragent)) {
            $browserKey = 'superagent';
        } elseif (preg_match('/Goose/', $useragent)) {
            $browserKey = 'goose-extractor';
        } elseif (preg_match('/AHC/', $useragent)) {
            $browserKey = 'asynchronous http client';
        } elseif (preg_match('/newspaper/', $useragent)) {
            $browserKey = 'newspaper';
        } elseif (preg_match('/Hatena::Bookmark/', $useragent)) {
            $browserKey = 'hatena::bookmark';
        } elseif (preg_match('/EasyBib AutoCite/', $useragent)) {
            $browserKey = 'easybib autocite';
        } elseif (preg_match('/ShortLinkTranslate/', $useragent)) {
            $browserKey = 'shortlinktranslate';
        } elseif (preg_match('/Marketing Grader/', $useragent)) {
            $browserKey = 'marketing grader';
        } elseif (preg_match('/Grammarly/', $useragent)) {
            $browserKey = 'grammarly';
        } elseif (preg_match('/Dispatch/', $useragent)) {
            $browserKey = 'dispatch';
        } elseif (preg_match('/Raven Link Checker/', $useragent)) {
            $browserKey = 'raven link checker';
        } elseif (preg_match('/http\-kit/', $useragent)) {
            $browserKey = 'http kit';
        } elseif (preg_match('/sfFeedReader/', $useragent)) {
            $browserKey = 'symfony rss reader';
        } elseif (preg_match('/Twikle/', $useragent)) {
            $browserKey = 'twikle bot';
        } elseif (preg_match('/node\-fetch/', $useragent)) {
            $browserKey = 'node-fetch';
        } elseif (preg_match('/BrokenLinkCheck\.com/', $useragent)) {
            $browserKey = 'brokenlinkcheck';
        } elseif (preg_match('/BCKLINKS/', $useragent)) {
            $browserKey = 'bcklinks';
        } elseif (preg_match('/Faraday/', $useragent)) {
            $browserKey = 'faraday';
        } elseif (preg_match('/gettor/', $useragent)) {
            $browserKey = 'gettor';
        } elseif (preg_match('/SEOstats/', $useragent)) {
            $browserKey = 'seostats';
        } elseif (preg_match('/ZnajdzFoto\/Image/', $useragent)) {
            $browserKey = 'znajdzfoto/imagebot';
        } elseif (preg_match('/infoX\-WISG/', $useragent)) {
            $browserKey = 'infox-wisg';
        } elseif (preg_match('/wscheck\.com/', $useragent)) {
            $browserKey = 'wscheck bot';
        } elseif (preg_match('/Tweetminster/', $useragent)) {
            $browserKey = 'tweetminster bot';
        } elseif (preg_match('/Astute SRM/', $useragent)) {
            $browserKey = 'astute social';
        } elseif (preg_match('/LongURL API/', $useragent)) {
            $browserKey = 'longurl bot';
        } elseif (preg_match('/Trove/', $useragent)) {
            $browserKey = 'trove bot';
        } elseif (preg_match('/Melvil Favicon/', $useragent)) {
            $browserKey = 'melvil favicon bot';
        } elseif (preg_match('/Melvil/', $useragent)) {
            $browserKey = 'melvil bot';
        } elseif (preg_match('/Pearltrees/', $useragent)) {
            $browserKey = 'pearltrees bot';
        } elseif (preg_match('/Svven\-Summarizer/', $useragent)) {
            $browserKey = 'svven summarizer bot';
        } elseif (preg_match('/Athena Site Analyzer/', $useragent)) {
            $browserKey = 'athena site analyzer';
        } elseif (preg_match('/Exploratodo/', $useragent)) {
            $browserKey = 'exploratodo bot';
        } elseif (preg_match('/WhatsApp/', $useragent)) {
            $browserKey = 'whatsapp';
        } elseif (preg_match('/DDG\-Android\-/', $useragent)) {
            $browserKey = 'duckduck app';
        } elseif (preg_match('/WebCorp/', $useragent)) {
            $browserKey = 'webcorp';
        } elseif (preg_match('/ROR Sitemap Generator/', $useragent)) {
            $browserKey = 'ror sitemap generator';
        } elseif (preg_match('/AuditMyPC Webmaster Tool/', $useragent)) {
            $browserKey = 'auditmypc webmaster tool';
        } elseif (preg_match('/XmlSitemapGenerator/', $useragent)) {
            $browserKey = 'xmlsitemapgenerator';
        } elseif (preg_match('/Stratagems Kumo/', $useragent)) {
            $browserKey = 'stratagems kumo';
        } elseif (preg_match('/YOURLS/', $useragent)) {
            $browserKey = 'yourls';
        } elseif (preg_match('/Embed PHP Library/', $useragent)) {
            $browserKey = 'embed php library';
        } elseif (preg_match('/SPIP/', $useragent)) {
            $browserKey = 'spip';
        } elseif (preg_match('/Friendica/', $useragent)) {
            $browserKey = 'friendica';
        } elseif (preg_match('/MagpieRSS/', $useragent)) {
            $browserKey = 'magpierss';
        } elseif (preg_match('/Short URL Checker/', $useragent)) {
            $browserKey = 'short url checker';
        } elseif (preg_match('/webnumbrFetcher/', $useragent)) {
            $browserKey = 'webnumbr fetcher';
        } elseif (preg_match('/(WAP Browser|Spice QT\-75|KKT20\/MIDP)/', $useragent)) {
            $browserKey = 'wap browser';
        } elseif (preg_match('/java/i', $useragent)) {
            $browserKey = 'java standard library';
        } elseif (preg_match('/(unister\-test|unistertesting|unister\-https\-test)/i', $useragent)) {
            $browserKey = 'unistertesting';
        } elseif (preg_match('/AdMuncher/', $useragent)) {
            $browserKey = 'ad muncher';
        } elseif (preg_match('/AdvancedEmailExtractor/', $useragent)) {
            $browserKey = 'advanced email extractor';
        } elseif (preg_match('/AiHitBot/', $useragent)) {
            $browserKey = 'aihitbot';
        } elseif (preg_match('/Alcatel/', $useragent)) {
            $browserKey = 'alcatel';
        } elseif (preg_match('/AlcoholSearch/', $useragent)) {
            $browserKey = 'alcohol search';
        } elseif (preg_match('/ApacheHttpClient/', $useragent)) {
            $browserKey = 'apache-httpclient';
        } elseif (preg_match('/ArchiveDeBot/', $useragent)) {
            $browserKey = 'internet archive de';
        } elseif (preg_match('/Argclrint/', $useragent)) {
            $browserKey = 'argclrint';
        } elseif (preg_match('/AskBot/', $useragent)) {
            $browserKey = 'ask bot';
        } elseif (preg_match('/AugustBot/', $useragent)) {
            $browserKey = 'augustbot';
        } elseif (preg_match('/Awesomebot/', $useragent)) {
            $browserKey = 'awesomebot';
        } elseif (preg_match('/BaiduSpider/', $useragent)) {
            $browserKey = 'baiduspider';
        } elseif (preg_match('/Benq/', $useragent)) {
            $browserKey = 'benq';
        } elseif (preg_match('/Billigfluegefinal/', $useragent)) {
            $browserKey = 'billigfluegefinal app';
        } elseif (preg_match('/BingProductsBot/', $useragent)) {
            $browserKey = 'bing product search';
        } elseif (preg_match('/BlackberryPlaybookTablet/', $useragent)) {
            $browserKey = 'blackberry playbook tablet';
        } elseif (preg_match('/BlitzBot/', $useragent)) {
            $browserKey = 'blitzbot';
        } elseif (preg_match('/BluecoatDrtr/', $useragent)) {
            $browserKey = 'dynamic realtime rating';
        } elseif (preg_match('/BndCrawler/', $useragent)) {
            $browserKey = 'bnd crawler';
        } elseif (preg_match('/BoardReader/', $useragent)) {
            $browserKey = 'boardreader';
        } elseif (preg_match('/Boxee/', $useragent)) {
            $browserKey = 'boxee';
        } elseif (preg_match('/Browser360/', $useragent)) {
            $browserKey = '360 browser';
        } elseif (preg_match('/Bwc/', $useragent)) {
            $browserKey = 'bwc';
        } elseif (preg_match('/Camcrawler/', $useragent)) {
            $browserKey = 'camcrawler';
        } elseif (preg_match('/CamelHttpStream/', $useragent)) {
            $browserKey = 'camelhttpstream';
        } elseif (preg_match('/Charlotte/', $useragent)) {
            $browserKey = 'charlotte';
        } elseif (preg_match('/CheckLinks/', $useragent)) {
            $browserKey = 'checklinks';
        } elseif (preg_match('/Choosy/', $useragent)) {
            $browserKey = 'choosy';
        } elseif (preg_match('/ClarityDailyBot/', $useragent)) {
            $browserKey = 'claritydailybot';
        } elseif (preg_match('/Clipish/', $useragent)) {
            $browserKey = 'clipish';
        } elseif (preg_match('/CloudSurfer/', $useragent)) {
            $browserKey = 'cloudsurfer';
        } elseif (preg_match('/CommonCrawl/', $useragent)) {
            $browserKey = 'commoncrawl';
        } elseif (preg_match('/ComodoCertificatesSpider/', $useragent)) {
            $browserKey = 'comodo-certificates-spider';
        } elseif (preg_match('/CompSpyBot/', $useragent)) {
            $browserKey = 'compspybot';
        } elseif (preg_match('/CoobyBot/', $useragent)) {
            $browserKey = 'coobybot';
        } elseif (preg_match('/CoreClassHttpClientCached/', $useragent)) {
            $browserKey = 'core_class_httpclient_cached';
        } elseif (preg_match('/Coverscout/', $useragent)) {
            $browserKey = 'coverscout';
        } elseif (preg_match('/CrystalSemanticsBot/', $useragent)) {
            $browserKey = 'crystalsemanticsbot';
        } elseif (preg_match('/CurlPhp/', $useragent)) {
            $browserKey = 'curl php';
        } elseif (preg_match('/CydralWebImageSearch/', $useragent)) {
            $browserKey = 'cydral web image search';
        } elseif (preg_match('/DarwinBrowser/', $useragent)) {
            $browserKey = 'darwin browser';
        } elseif (preg_match('/DCPbot/', $useragent)) {
            $browserKey = 'dcpbot';
        } elseif (preg_match('/Delibar/', $useragent)) {
            $browserKey = 'delibar';
        } elseif (preg_match('/Diga/', $useragent)) {
            $browserKey = 'diga';
        } elseif (preg_match('/DoCoMo/', $useragent)) {
            $browserKey = 'docomo';
        } elseif (preg_match('/DomainCrawler/', $useragent)) {
            $browserKey = 'domaincrawler';
        } elseif (preg_match('/Elefent/', $useragent)) {
            $browserKey = 'elefent';
        } elseif (preg_match('/ElisaBot/', $useragent)) {
            $browserKey = 'elisabot';
        } elseif (preg_match('/Eudora/', $useragent)) {
            $browserKey = 'eudora';
        } elseif (preg_match('/EuripBot/', $useragent)) {
            $browserKey = 'europe internet portal';
        } elseif (preg_match('/EventGuruBot/', $useragent)) {
            $browserKey = 'eventguru bot';
        } elseif (preg_match('/ExbLanguageCrawler/', $useragent)) {
            $browserKey = 'exb language crawler';
        } elseif (preg_match('/Extras4iMovie/', $useragent)) {
            $browserKey = 'extras4imovie';
        } elseif (preg_match('/FaceBookBot/', $useragent)) {
            $browserKey = 'facebook bot';
        } elseif (preg_match('/FalkMaps/', $useragent)) {
            $browserKey = 'falkmaps';
        } elseif (preg_match('/FeedFinder/', $useragent)) {
            $browserKey = 'feedfinder';
        } elseif (preg_match('/Findlinks/', $useragent)) {
            $browserKey = 'findlinks';
        } elseif (preg_match('/Firebird/', $useragent)) {
            $browserKey = 'firebird';
        } elseif (preg_match('/Genieo/', $useragent)) {
            $browserKey = 'genieo';
        } elseif (preg_match('/GenieoWebFilter/', $useragent)) {
            $browserKey = 'genieo web filter';
        } elseif (preg_match('/Getleft/', $useragent)) {
            $browserKey = 'getleft';
        } elseif (preg_match('/GetPhotos/', $useragent)) {
            $browserKey = 'getphotos';
        } elseif (preg_match('/Godzilla/', $useragent)) {
            $browserKey = 'godzilla';
        } elseif (preg_match('/Google/', $useragent)) {
            $browserKey = 'google';
        } elseif (preg_match('/GoogleAdsbot/', $useragent)) {
            $browserKey = 'adsbot google';
        } elseif (preg_match('/GoogleEarth/', $useragent)) {
            $browserKey = 'google earth';
        } elseif (preg_match('/GoogleFontAnalysis/', $useragent)) {
            $browserKey = 'google fontanalysis';
        } elseif (preg_match('/GoogleImageProxy/', $useragent)) {
            $browserKey = 'google image proxy';
        } elseif (preg_match('/GoogleMarkupTester/', $useragent)) {
            $browserKey = 'google markup tester';
        } elseif (preg_match('/GooglePageSpeed/', $useragent)) {
            $browserKey = 'google page speed';
        } elseif (preg_match('/GoogleSitemaps/', $useragent)) {
            $browserKey = 'google sitemaps';
        } elseif (preg_match('/GoogleTv/', $useragent)) {
            $browserKey = 'googletv';
        } elseif (preg_match('/Grindr/', $useragent)) {
            $browserKey = 'grindr';
        } elseif (preg_match('/GSLFbot/', $useragent)) {
            $browserKey = 'gslfbot';
        } elseif (preg_match('/HaosouSpider/', $useragent)) {
            $browserKey = 'haosouspider';
        } elseif (preg_match('/HbbTv/', $useragent)) {
            $browserKey = 'hbbtv';
        } elseif (preg_match('/Heritrix/', $useragent)) {
            $browserKey = 'heritrix';
        } elseif (preg_match('/HitLeapViewer/', $useragent)) {
            $browserKey = 'hitleap viewer';
        } elseif (preg_match('/Hitpad/', $useragent)) {
            $browserKey = 'hitpad';
        } elseif (preg_match('/HotWallpapers/', $useragent)) {
            $browserKey = 'hot wallpapers';
        } elseif (preg_match('/Ibisbrowser/', $useragent)) {
            $browserKey = 'ibisbrowser';
        } elseif (preg_match('/Ibrowse/', $useragent)) {
            $browserKey = 'ibrowse';
        } elseif (preg_match('/Ibuilder/', $useragent)) {
            $browserKey = 'ibuilder';
        } elseif (preg_match('/Icedove/', $useragent)) {
            $browserKey = 'icedove';
        } elseif (preg_match('/Iceowl/', $useragent)) {
            $browserKey = 'iceowl';
        } elseif (preg_match('/Ichromy/', $useragent)) {
            $browserKey = 'ichromy';
        } elseif (preg_match('/IcjobsCrawler/', $useragent)) {
            $browserKey = 'icjobs crawler';
        } elseif (preg_match('/ImageMobile/', $useragent)) {
            $browserKey = 'imagemobile';
        } elseif (preg_match('/ImageSearcherS/', $useragent)) {
            $browserKey = 'imagesearchers';
        } elseif (preg_match('/Incredimail/', $useragent)) {
            $browserKey = 'incredimail';
        } elseif (preg_match('/IndyLibrary/', $useragent)) {
            $browserKey = 'indy library';
        } elseif (preg_match('/InettvBrowser/', $useragent)) {
            $browserKey = 'inettvbrowser';
        } elseif (preg_match('/InfohelferCrawler/', $useragent)) {
            $browserKey = 'infohelfer crawler';
        } elseif (preg_match('/InsiteRobot/', $useragent)) {
            $browserKey = 'insite robot';
        } elseif (preg_match('/Insitesbot/', $useragent)) {
            $browserKey = 'insitesbot';
        } elseif (preg_match('/IntegromedbCrawler/', $useragent)) {
            $browserKey = 'integromedb crawler';
        } elseif (preg_match('/InternetArchive/', $useragent)) {
            $browserKey = 'internet archive bot';
        } elseif (preg_match('/Ipick/', $useragent)) {
            $browserKey = 'ipick';
        } elseif (preg_match('/Isource/', $useragent)) {
            $browserKey = 'isource+ app';
        } elseif (preg_match('/JakartaCommonsHttpClient/', $useragent)) {
            $browserKey = 'jakarta commons httpclient';
        } elseif (preg_match('/JigsawCssValidator/', $useragent)) {
            $browserKey = 'jigsaw css validator';
        } elseif (preg_match('/JustCrawler/', $useragent)) {
            $browserKey = 'just-crawler';
        } elseif (preg_match('/Kindle/', $useragent)) {
            $browserKey = 'kindle';
        } elseif (preg_match('/Linguatools/', $useragent)) {
            $browserKey = 'linguatoolsbot';
        } elseif (preg_match('/LingueeBot/', $useragent)) {
            $browserKey = 'linguee bot';
        } elseif (preg_match('/LinkCheckerBot/', $useragent)) {
            $browserKey = 'link-checker';
        } elseif (preg_match('/LinkdexComBot/', $useragent)) {
            $browserKey = 'linkdex bot';
        } elseif (preg_match('/LinkLint/', $useragent)) {
            $browserKey = 'linklint';
        } elseif (preg_match('/LinkWalkerBot/', $useragent)) {
            $browserKey = 'linkwalker';
        } elseif (preg_match('/LittleBookmarkBox/', $useragent)) {
            $browserKey = 'little-bookmark-box app';
        } elseif (preg_match('/LtBot/', $useragent)) {
            $browserKey = 'ltbot';
        } elseif (preg_match('/MacInroyPrivacyAuditors/', $useragent)) {
            $browserKey = 'macinroy privacy auditors';
        } elseif (preg_match('/MaemoBrowser/', $useragent)) {
            $browserKey = 'maemo browser';
        } elseif (preg_match('/MagpieCrawler/', $useragent)) {
            $browserKey = 'magpie crawler';
        } elseif (preg_match('/MailExchangeWebServices/', $useragent)) {
            $browserKey = 'mail exchangewebservices';
        } elseif (preg_match('/Maven/', $useragent)) {
            $browserKey = 'maven';
        } elseif (preg_match('/Mechanize/', $useragent)) {
            $browserKey = 'mechanize';
        } elseif (preg_match('/MicrosoftWindowsNetworkDiagnostics/', $useragent)) {
            $browserKey = 'microsoft windows network diagnostics';
        } elseif (preg_match('/Mitsubishi/', $useragent)) {
            $browserKey = 'mitsubishi';
        } elseif (preg_match('/Mjbot/', $useragent)) {
            $browserKey = 'mjbot';
        } elseif (preg_match('/Mobilerss/', $useragent)) {
            $browserKey = 'mobilerss';
        } elseif (preg_match('/MovableType/', $useragent)) {
            $browserKey = 'movabletype web log';
        } elseif (preg_match('/Mozad/', $useragent)) {
            $browserKey = 'mozad';
        } elseif (preg_match('/Mozilla/', $useragent)) {
            $browserKey = 'mozilla';
        } elseif (preg_match('/MsieCrawler/', $useragent)) {
            $browserKey = 'msiecrawler';
        } elseif (preg_match('/MsSearch/', $useragent)) {
            $browserKey = 'ms search';
        } elseif (preg_match('/MyEnginesBot/', $useragent)) {
            $browserKey = 'myengines bot';
        } elseif (preg_match('/Nec/', $useragent)) {
            $browserKey = 'nec';
        } elseif (preg_match('/Netbox/', $useragent)) {
            $browserKey = 'netbox';
        } elseif (preg_match('/NetNewsWire/', $useragent)) {
            $browserKey = 'netnewswire';
        } elseif (preg_match('/NetPositive/', $useragent)) {
            $browserKey = 'netpositive';
        } elseif (preg_match('/NetSurf/', $useragent)) {
            $browserKey = 'netsurf';
        } elseif (preg_match('/NetTv/', $useragent)) {
            $browserKey = 'nettv';
        } elseif (preg_match('/Netvibes/', $useragent)) {
            $browserKey = 'netvibes';
        } elseif (preg_match('/NewsBot/', $useragent)) {
            $browserKey = 'news bot';
        } elseif (preg_match('/NewsRack/', $useragent)) {
            $browserKey = 'newsrack';
        } elseif (preg_match('/NixGibts/', $useragent)) {
            $browserKey = 'nixgibts';
        } elseif (preg_match('/NodeJsHttpRequest/', $useragent)) {
            $browserKey = 'node.js http_request';
        } elseif (preg_match('/OnePassword/', $useragent)) {
            $browserKey = '1password';
        } elseif (preg_match('/OpenVas/', $useragent)) {
            $browserKey = 'open vulnerability assessment system';
        } elseif (preg_match('/OpenWeb/', $useragent)) {
            $browserKey = 'openweb';
        } elseif (preg_match('/Origin/', $useragent)) {
            $browserKey = 'origin';
        } elseif (preg_match('/OssProxy/', $useragent)) {
            $browserKey = 'ossproxy';
        } elseif (preg_match('/Pagebull/', $useragent)) {
            $browserKey = 'pagebull';
        } elseif (preg_match('/PalmPixi/', $useragent)) {
            $browserKey = 'palmpixi';
        } elseif (preg_match('/PalmPre/', $useragent)) {
            $browserKey = 'palmpre';
        } elseif (preg_match('/Panasonic/', $useragent)) {
            $browserKey = 'panasonic';
        } elseif (preg_match('/Pandora/', $useragent)) {
            $browserKey = 'pandora';
        } elseif (preg_match('/Parchbot/', $useragent)) {
            $browserKey = 'parchbot';
        } elseif (preg_match('/PearHttpRequest/', $useragent)) {
            $browserKey = 'pear http_request';
        } elseif (preg_match('/PearHttpRequest2/', $useragent)) {
            $browserKey = 'pear http_request2';
        } elseif (preg_match('/Philips/', $useragent)) {
            $browserKey = 'philips';
        } elseif (preg_match('/PixraySeeker/', $useragent)) {
            $browserKey = 'pixray-seeker';
        } elseif (preg_match('/Playstation/', $useragent)) {
            $browserKey = 'playstation';
        } elseif (preg_match('/PlaystationBrowser/', $useragent)) {
            $browserKey = 'playstation browser';
        } elseif (preg_match('/Plukkie/', $useragent)) {
            $browserKey = 'plukkie';
        } elseif (preg_match('/PodtechNetwork/', $useragent)) {
            $browserKey = 'podtech network';
        } elseif (preg_match('/Pogodak/', $useragent)) {
            $browserKey = 'pogodak';
        } elseif (preg_match('/Postbox/', $useragent)) {
            $browserKey = 'postbox';
        } elseif (preg_match('/Powertv/', $useragent)) {
            $browserKey = 'powertv';
        } elseif (preg_match('/Prism/', $useragent)) {
            $browserKey = 'prism';
        } elseif (preg_match('/Python/', $useragent)) {
            $browserKey = 'python';
        } elseif (preg_match('/Qihoo/', $useragent)) {
            $browserKey = 'qihoo';
        } elseif (preg_match('/Qtek/', $useragent)) {
            $browserKey = 'qtek';
        } elseif (preg_match('/QtWeb/', $useragent)) {
            $browserKey = 'qtweb internet browser';
        } elseif (preg_match('/Quantcastbot/', $useragent)) {
            $browserKey = 'quantcastbot';
        } elseif (preg_match('/QuerySeekerSpider/', $useragent)) {
            $browserKey = 'queryseekerspider';
        } elseif (preg_match('/Quicktime/', $useragent)) {
            $browserKey = 'quicktime';
        } elseif (preg_match('/Realplayer/', $useragent)) {
            $browserKey = 'realplayer';
        } elseif (preg_match('/RgAnalytics/', $useragent)) {
            $browserKey = 'rganalytics';
        } elseif (preg_match('/Rippers/', $useragent)) {
            $browserKey = 'ripper';
        } elseif (preg_match('/Rojo/', $useragent)) {
            $browserKey = 'rojo';
        } elseif (preg_match('/RssingBot/', $useragent)) {
            $browserKey = 'rssingbot';
        } elseif (preg_match('/RssOwl/', $useragent)) {
            $browserKey = 'rssowl';
        } elseif (preg_match('/RukyBot/', $useragent)) {
            $browserKey = 'ruky roboter';
        } elseif (preg_match('/Ruunk/', $useragent)) {
            $browserKey = 'ruunk';
        } elseif (preg_match('/Samsung/', $useragent)) {
            $browserKey = 'samsung';
        } elseif (preg_match('/SamsungMobileBrowser/', $useragent)) {
            $browserKey = 'samsung mobile browser';
        } elseif (preg_match('/Sanyo/', $useragent)) {
            $browserKey = 'sanyo';
        } elseif (preg_match('/SaveTheWorldHeritage/', $useragent)) {
            $browserKey = 'save-the-world-heritage bot';
        } elseif (preg_match('/Scorpionbot/', $useragent)) {
            $browserKey = 'scorpionbot';
        } elseif (preg_match('/Scraper/', $useragent)) {
            $browserKey = 'scraper';
        } elseif (preg_match('/Searchmetrics/', $useragent)) {
            $browserKey = 'searchmetricsbot';
        } elseif (preg_match('/SemagerBot/', $useragent)) {
            $browserKey = 'semager bot';
        } elseif (preg_match('/SeoEngineWorldBot/', $useragent)) {
            $browserKey = 'seoengine world bot';
        } elseif (preg_match('/Setooz/', $useragent)) {
            $browserKey = 'setooz';
        } elseif (preg_match('/Shiira/', $useragent)) {
            $browserKey = 'shiira';
        } elseif (preg_match('/Shopsalad/', $useragent)) {
            $browserKey = 'shopsalad';
        } elseif (preg_match('/Siemens/', $useragent)) {
            $browserKey = 'siemens';
        } elseif (preg_match('/Sindice/', $useragent)) {
            $browserKey = 'sindice fetcher';
        } elseif (preg_match('/SiteKiosk/', $useragent)) {
            $browserKey = 'sitekiosk';
        } elseif (preg_match('/SlimBrowser/', $useragent)) {
            $browserKey = 'slimbrowser';
        } elseif (preg_match('/SmartSync/', $useragent)) {
            $browserKey = 'smartsync app';
        } elseif (preg_match('/SmartTv/', $useragent)) {
            $browserKey = 'smarttv';
        } elseif (preg_match('/SmartTvWebBrowser/', $useragent)) {
            $browserKey = 'smarttv webbrowser';
        } elseif (preg_match('/Snapbot/', $useragent)) {
            $browserKey = 'snapbot';
        } elseif (preg_match('/Snoopy/', $useragent)) {
            $browserKey = 'snoopy';
        } elseif (preg_match('/Snowtape/', $useragent)) {
            $browserKey = 'snowtape';
        } elseif (preg_match('/Songbird/', $useragent)) {
            $browserKey = 'songbird';
        } elseif (preg_match('/Sosospider/', $useragent)) {
            $browserKey = 'sosospider';
        } elseif (preg_match('/SpaceBison/', $useragent)) {
            $browserKey = 'space bison';
        } elseif (preg_match('/Spector/', $useragent)) {
            $browserKey = 'spector';
        } elseif (preg_match('/SpeedySpider/', $useragent)) {
            $browserKey = 'speedy spider';
        } elseif (preg_match('/SpellCheckBot/', $useragent)) {
            $browserKey = 'spellcheck bot';
        } elseif (preg_match('/SpiderLing/', $useragent)) {
            $browserKey = 'spiderling';
        } elseif (preg_match('/Spiderlytics/', $useragent)) {
            $browserKey = 'spiderlytics';
        } elseif (preg_match('/SpiderPig/', $useragent)) {
            $browserKey = 'spider-pig';
        } elseif (preg_match('/SprayCan/', $useragent)) {
            $browserKey = 'spray-can';
        } elseif (preg_match('/SPV/', $useragent)) {
            $browserKey = 'spv';
        } elseif (preg_match('/SquidWall/', $useragent)) {
            $browserKey = 'squidwall';
        } elseif (preg_match('/Sqwidgebot/', $useragent)) {
            $browserKey = 'sqwidgebot';
        } elseif (preg_match('/Strata/', $useragent)) {
            $browserKey = 'strata';
        } elseif (preg_match('/StrategicBoardBot/', $useragent)) {
            $browserKey = 'strategicboardbot';
        } elseif (preg_match('/StrawberryjamUrlExpander/', $useragent)) {
            $browserKey = 'strawberryjam url expander';
        } elseif (preg_match('/Sunbird/', $useragent)) {
            $browserKey = 'sunbird';
        } elseif (preg_match('/Superfish/', $useragent)) {
            $browserKey = 'superfish';
        } elseif (preg_match('/Superswan/', $useragent)) {
            $browserKey = 'superswan';
        } elseif (preg_match('/SymphonyBrowser/', $useragent)) {
            $browserKey = 'symphonybrowser';
        } elseif (preg_match('/SynapticWalker/', $useragent)) {
            $browserKey = 'synapticwalker';
        } elseif (preg_match('/TagInspectorBot/', $useragent)) {
            $browserKey = 'taginspector';
        } elseif (preg_match('/Tailrank/', $useragent)) {
            $browserKey = 'tailrank';
        } elseif (preg_match('/TasapImageRobot/', $useragent)) {
            $browserKey = 'tasapimagerobot';
        } elseif (preg_match('/TenFourFox/', $useragent)) {
            $browserKey = 'tenfourfox';
        } elseif (preg_match('/Terra/', $useragent)) {
            $browserKey = 'terra';
        } elseif (preg_match('/TheBatDownloadManager/', $useragent)) {
            $browserKey = 'the bat download manager';
        } elseif (preg_match('/ThemeSearchAndExtractionCrawler/', $useragent)) {
            $browserKey = 'themesearchandextractioncrawler';
        } elseif (preg_match('/ThumbShotsBot/', $useragent)) {
            $browserKey = 'thumbshotsbot';
        } elseif (preg_match('/Thunderstone/', $useragent)) {
            $browserKey = 'thunderstone';
        } elseif (preg_match('/TinEye/', $useragent)) {
            $browserKey = 'tineye';
        } elseif (preg_match('/TkcAutodownloader/', $useragent)) {
            $browserKey = 'tkcautodownloader';
        } elseif (preg_match('/TlsProber/', $useragent)) {
            $browserKey = 'tlsprober';
        } elseif (preg_match('/Toshiba/', $useragent)) {
            $browserKey = 'toshiba';
        } elseif (preg_match('/TrendictionBot/', $useragent)) {
            $browserKey = 'trendiction bot';
        } elseif (preg_match('/TrendMicro/', $useragent)) {
            $browserKey = 'trend micro';
        } elseif (preg_match('/TumblrRssSyndication/', $useragent)) {
            $browserKey = 'tumblrrsssyndication';
        } elseif (preg_match('/TuringMachine/', $useragent)) {
            $browserKey = 'turingmachine';
        } elseif (preg_match('/TurnitinBot/', $useragent)) {
            $browserKey = 'turnitinbot';
        } elseif (preg_match('/Tweetbot/', $useragent)) {
            $browserKey = 'tweetbot';
        } elseif (preg_match('/TwengabotDiscover/', $useragent)) {
            $browserKey = 'twengabotdiscover';
        } elseif (preg_match('/Twitturls/', $useragent)) {
            $browserKey = 'twitturls';
        } elseif (preg_match('/Typo/', $useragent)) {
            $browserKey = 'typo3';
        } elseif (preg_match('/TypoLinkvalidator/', $useragent)) {
            $browserKey = 'typolinkvalidator';
        } elseif (preg_match('/UnisterPortale/', $useragent)) {
            $browserKey = 'unisterportale';
        } elseif (preg_match('/UoftdbExperiment/', $useragent)) {
            $browserKey = 'uoftdb experiment';
        } elseif (preg_match('/Vanillasurf/', $useragent)) {
            $browserKey = 'vanillasurf';
        } elseif (preg_match('/Viralheat/', $useragent)) {
            $browserKey = 'viral heat';
        } elseif (preg_match('/VmsMosaic/', $useragent)) {
            $browserKey = 'vmsmosaic';
        } elseif (preg_match('/Vobsub/', $useragent)) {
            $browserKey = 'vobsub';
        } elseif (preg_match('/Voilabot/', $useragent)) {
            $browserKey = 'voilabot';
        } elseif (preg_match('/Vonnacom/', $useragent)) {
            $browserKey = 'vonnacom';
        } elseif (preg_match('/Voyager/', $useragent)) {
            $browserKey = 'voyager';
        } elseif (preg_match('/W3cChecklink/', $useragent)) {
            $browserKey = 'w3c-checklink';
        } elseif (preg_match('/W3cValidator/', $useragent)) {
            $browserKey = 'w3c validator';
        } elseif (preg_match('/W3m/', $useragent)) {
            $browserKey = 'w3m';
        } elseif (preg_match('/Webaroo/', $useragent)) {
            $browserKey = 'webaroo';
        } elseif (preg_match('/Webbotru/', $useragent)) {
            $browserKey = 'webbotru';
        } elseif (preg_match('/Webcapture/', $useragent)) {
            $browserKey = 'webcapture';
        } elseif (preg_match('/WebDownloader/', $useragent)) {
            $browserKey = 'web downloader';
        } elseif (preg_match('/Webimages/', $useragent)) {
            $browserKey = 'webimages';
        } elseif (preg_match('/Weblide/', $useragent)) {
            $browserKey = 'weblide';
        } elseif (preg_match('/WebLinkValidator/', $useragent)) {
            $browserKey = 'web link validator';
        } elseif (preg_match('/WebmasterworldServerHeaderChecker/', $useragent)) {
            $browserKey = 'webmasterworldserverheaderchecker';
        } elseif (preg_match('/WebOX/', $useragent)) {
            $browserKey = 'webox';
        } elseif (preg_match('/Webscan/', $useragent)) {
            $browserKey = 'webscan';
        } elseif (preg_match('/Websuchebot/', $useragent)) {
            $browserKey = 'websuchebot';
        } elseif (preg_match('/WebtvMsntv/', $useragent)) {
            $browserKey = 'webtv/msntv';
        } elseif (preg_match('/Wepbot/', $useragent)) {
            $browserKey = 'wepbot';
        } elseif (preg_match('/WiJobRoboter/', $useragent)) {
            $browserKey = 'wi job roboter';
        } elseif (preg_match('/Wikimpress/', $useragent)) {
            $browserKey = 'wikimpress';
        } elseif (preg_match('/Winamp/', $useragent)) {
            $browserKey = 'winamp';
        } elseif (preg_match('/Winkbot/', $useragent)) {
            $browserKey = 'winkbot';
        } elseif (preg_match('/Winwap/', $useragent)) {
            $browserKey = 'winwap';
        } elseif (preg_match('/Wire/', $useragent)) {
            $browserKey = 'wire';
        } elseif (preg_match('/Wisebot/', $useragent)) {
            $browserKey = 'wisebot';
        } elseif (preg_match('/Wizz/', $useragent)) {
            $browserKey = 'wizz';
        } elseif (preg_match('/Worldlingo/', $useragent)) {
            $browserKey = 'worldlingo';
        } elseif (preg_match('/WorldWideWeasel/', $useragent)) {
            $browserKey = 'world wide weasel';
        } elseif (preg_match('/Wotbox/', $useragent)) {
            $browserKey = 'wotbox';
        } elseif (preg_match('/WwwBrowser/', $useragent)) {
            $browserKey = 'www browser';
        } elseif (preg_match('/Wwwc/', $useragent)) {
            $browserKey = 'wwwc';
        } elseif (preg_match('/Wwwmail/', $useragent)) {
            $browserKey = 'www4mail';
        } elseif (preg_match('/WwwMechanize/', $useragent)) {
            $browserKey = 'www-mechanize';
        } elseif (preg_match('/Wwwster/', $useragent)) {
            $browserKey = 'wwwster';
        } elseif (preg_match('/XaldonWebspider/', $useragent)) {
            $browserKey = 'xaldon webspider';
        } elseif (preg_match('/XchaosArachne/', $useragent)) {
            $browserKey = 'xchaos arachne';
        } elseif (preg_match('/Xerka/', $useragent)) {
            $browserKey = 'xerka';
        } elseif (preg_match('/XmlRpcForPhp/', $useragent)) {
            $browserKey = 'xml-rpc for php';
        } elseif (preg_match('/Xspider/', $useragent)) {
            $browserKey = 'xspider';
        } elseif (preg_match('/Xyleme/', $useragent)) {
            $browserKey = 'xyleme';
        } elseif (preg_match('/YacyBot/', $useragent)) {
            $browserKey = 'yacy bot';
        } elseif (preg_match('/Yadowscrawler/', $useragent)) {
            $browserKey = 'yadowscrawler';
        } elseif (preg_match('/Yahoo/', $useragent)) {
            $browserKey = 'yahoo!';
        } elseif (preg_match('/YahooExternalCache/', $useragent)) {
            $browserKey = 'yahooexternalcache';
        } elseif (preg_match('/YahooMobileMessenger/', $useragent)) {
            $browserKey = 'yahoo! mobile messenger';
        } elseif (preg_match('/YahooPipes/', $useragent)) {
            $browserKey = 'yahoo! pipes';
        } elseif (preg_match('/YandexImagesBot/', $useragent)) {
            $browserKey = 'yandeximages';
        } elseif (preg_match('/YouWaveAndroidOnPc/', $useragent)) {
            $browserKey = 'youwave android on pc';
        }

        return self::get($browserKey, $useragent);
    }

    /**
     * @param string $browserKey
     * @param string $useragent
     *
     * @return \UaResult\Browser\Browser
     */
    public function get($browserKey, $useragent)
    {
        static $browsers = null;

        if (null === $browsers) {
            $browsers = json_decode(file_get_contents(__DIR__ . '/../../data/browsers.json'));
        }

        $engineFactory = new EngineFactory();

        if (!isset($browsers->$browserKey)) {
            return new Browser(
                'unknown',
                'unknown',
                'unknown',
                new Version(0),
                $engineFactory->get('unknown', $useragent),
                new UaBrowserType\Unknown()
            );
        }

        $browserVersionClass = $browsers->$browserKey->version->class;

        if (!is_string($browserVersionClass)) {
            $version = new Version(0);
        } elseif ('VersionFactory' === $browserVersionClass) {
            $version = VersionFactory::detectVersion($useragent, $browsers->$browserKey->version->search);
        } else {
            /** @var \BrowserDetector\Version\VersionFactoryInterface $browserVersionClass */
            $version = $browserVersionClass::detectVersion($useragent);
        }

        $typeClass = '\\UaBrowserType\\' . $browsers->$browserKey->type;

        return new Browser(
            $browsers->$browserKey->name,
            $browsers->$browserKey->manufacturer,
            $browsers->$browserKey->brand,
            $version,
            $engineFactory->get($browsers->$browserKey->engine, $useragent),
            new $typeClass(),
            (new BrowserBits($useragent))->getBits(),
            $browsers->$browserKey->pdfSupport,
            $browsers->$browserKey->rssSupport,
            $browsers->$browserKey->canSkipAlignedLinkRow,
            $browsers->$browserKey->claimsWebSupport,
            $browsers->$browserKey->supportsEmptyOptionValues,
            $browsers->$browserKey->supportsBasicAuthentication,
            $browsers->$browserKey->supportsPostMethod
        );
    }
}
