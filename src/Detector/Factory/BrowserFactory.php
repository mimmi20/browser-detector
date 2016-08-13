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

use BrowserDetector\Detector\Browser;
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
     * @return \BrowserDetector\Detector\Browser\AbstractBrowser
     */
    public static function detect(
        $useragent,
        OsInterface $platform = null
    ) {
        if (preg_match('/RevIP\.info site analyzer/', $useragent)) {
            return new Browser\RevIpSnfoSiteAnalyzer($useragent);
        } elseif (preg_match('/reddit pic scraper/i', $useragent)) {
            return new Browser\RedditPicScraper($useragent);
        } elseif (preg_match('/Mozilla crawl/', $useragent)) {
            return new Browser\MozillaCrawler($useragent);
        } elseif (preg_match('/^\[FBAN/i', $useragent)) {
            return new Browser\FacebookApp($useragent);
        } elseif (preg_match('/UCBrowserHD/', $useragent)) {
            return new Browser\UcBrowserHd($useragent);
        } elseif (preg_match('/(ucbrowser|uc browser|ucweb)/i', $useragent) && preg_match('/opera mini/i', $useragent)) {
            return new Browser\UcBrowser($useragent);
        } elseif (preg_match('/(opera mini|opios)/i', $useragent)) {
            return new Browser\OperaMini($useragent);
        } elseif (preg_match('/opera mobi/i', $useragent)
            || (preg_match('/(opera|opr)/i', $useragent) && preg_match('/(Android|MTK|MAUI|SAMSUNG|Windows CE|SymbOS)/', $useragent))
        ) {
            return new Browser\OperaMobile($useragent);
        } elseif (preg_match('/(ucbrowser|uc browser|ucweb)/i', $useragent)) {
            return new Browser\UcBrowser($useragent);
        } elseif (preg_match('/IC OpenGraph Crawler/', $useragent)) {
            return new Browser\IbmConnections($useragent);
        } elseif (preg_match('/coast/i', $useragent)) {
            return new Browser\OperaCoast($useragent);
        } elseif (preg_match('/(opera|opr)/i', $useragent)) {
            return new Browser\Opera($useragent);
        } elseif (preg_match('/iCabMobile/', $useragent)) {
            return new Browser\IcabMobile($useragent);
        } elseif (preg_match('/iCab/', $useragent)) {
            return new Browser\Icab($useragent);
        } elseif (preg_match('/HggH PhantomJS Screenshoter/', $useragent)) {
            return new Browser\HgghPhantomjsScreenshoter($useragent);
        } elseif (preg_match('/bl\.uk\_lddc\_bot/', $useragent)) {
            return new Browser\BlukLddcBot($useragent);
        } elseif (preg_match('/phantomas/', $useragent)) {
            return new Browser\Phantomas($useragent);
        } elseif (preg_match('/Seznam screenshot\-generator/', $useragent)) {
            return new Browser\SeznamScreenshotGenerator($useragent);
        } elseif (false !== strpos($useragent, 'PhantomJS')) {
            return new Browser\PhantomJs($useragent);
        } elseif (false !== strpos($useragent, 'YaBrowser')) {
            return new Browser\YaBrowser($useragent);
        } elseif (false !== strpos($useragent, 'Kamelio')) {
            return new Browser\KamelioApp($useragent);
        } elseif (false !== strpos($useragent, 'FBAV')) {
            return new Browser\FacebookApp($useragent);
        } elseif (false !== strpos($useragent, 'ACHEETAHI')) {
            return new Browser\CmBrowser($useragent);
        } elseif (preg_match('/flyflow/i', $useragent)) {
            return new Browser\FlyFlow($useragent);
        } elseif (false !== strpos($useragent, 'bdbrowser_i18n') || false !== strpos($useragent, 'baidubrowser')) {
            return new Browser\BaiduBrowser($useragent);
        } elseif (false !== strpos($useragent, 'bdbrowserhd_i18n')) {
            return new Browser\BaiduHdBrowser($useragent);
        } elseif (false !== strpos($useragent, 'bdbrowser_mini')) {
            return new Browser\BaiduMiniBrowser($useragent);
        } elseif (false !== strpos($useragent, 'Puffin')) {
            return new Browser\Puffin($useragent);
        } elseif (preg_match('/stagefright/', $useragent)) {
            return new Browser\Stagefright($useragent);
        } elseif (false !== strpos($useragent, 'SamsungBrowser')) {
            return new Browser\SamsungBrowser($useragent);
        } elseif (false !== strpos($useragent, 'Silk')) {
            return new Browser\Silk($useragent);
        } elseif (false !== strpos($useragent, 'coc_coc_browser')) {
            return new Browser\CocCocBrowser($useragent);
        } elseif (false !== strpos($useragent, 'NaverMatome')) {
            return new Browser\NaverMatome($useragent);
        } elseif (preg_match('/FlipboardProxy/', $useragent)) {
            return new Browser\FlipboardProxy($useragent);
        } elseif (false !== strpos($useragent, 'Flipboard')) {
            return new Browser\Flipboard($useragent);
        } elseif (false !== strpos($useragent, 'Seznam.cz')) {
            return new Browser\SeznamBrowser($useragent);
        } elseif (false !== strpos($useragent, 'Aviator')) {
            return new Browser\WhiteHatAviator($useragent);
        } elseif (preg_match('/NetFrontLifeBrowser/', $useragent)) {
            return new Browser\NetFrontLifeBrowser($useragent);
        } elseif (preg_match('/IceDragon/', $useragent)) {
            return new Browser\ComodoIceDragon($useragent);
        } elseif (false !== strpos($useragent, 'Dragon') && false === strpos($useragent, 'DragonFly')) {
            return new Browser\ComodoDragon($useragent);
        } elseif (false !== strpos($useragent, 'Beamrise')) {
            return new Browser\Beamrise($useragent);
        } elseif (false !== strpos($useragent, 'Diglo')) {
            return new Browser\Diglo($useragent);
        } elseif (false !== strpos($useragent, 'APUSBrowser')) {
            return new Browser\ApusBrowser($useragent);
        } elseif (false !== strpos($useragent, 'Chedot')) {
            return new Browser\Chedot($useragent);
        } elseif (false !== strpos($useragent, 'Qword')) {
            return new Browser\QwordBrowser($useragent);
        } elseif (false !== strpos($useragent, 'Iridium')) {
            return new Browser\Iridium($useragent);
        } elseif (preg_match('/avant/i', $useragent)) {
            return new Browser\Avant($useragent);
        } elseif (false !== strpos($useragent, 'MxNitro')) {
            return new Browser\MaxthonNitro($useragent);
        } elseif (preg_match('/(mxbrowser|maxthon|myie)/i', $useragent)) {
            return new Browser\Maxthon($useragent);
        } elseif (preg_match('/superbird/i', $useragent)) {
            return new Browser\SuperBird($useragent);
        } elseif (false !== strpos($useragent, 'TinyBrowser')) {
            return new Browser\TinyBrowser($useragent);
        } elseif (preg_match('/MicroMessenger/', $useragent)) {
            return new Browser\WeChatApp($useragent);
        } elseif (preg_match('/MQQBrowser\/Mini/', $useragent)) {
            return new Browser\QqBrowserMini($useragent);
        } elseif (preg_match('/MQQBrowser/', $useragent)) {
            return new Browser\QqBrowser($useragent);
        } elseif (preg_match('/pinterest/i', $useragent)) {
            return new Browser\PinterestApp($useragent);
        } elseif (preg_match('/baiduboxapp/', $useragent)) {
            return new Browser\BaiduBoxApp($useragent);
        } elseif (preg_match('/wkbrowser/', $useragent)) {
            return new Browser\WkBrowser($useragent);
        } elseif (preg_match('/Mb2345Browser/', $useragent)) {
            return new Browser\Browser2345($useragent);
        } elseif (false !== strpos($useragent, 'Chrome')
            && false !== strpos($useragent, 'Version')
            && 0 < strpos($useragent, 'Chrome')
        ) {
            return new Browser\AndroidWebView($useragent);
        } elseif (false !== strpos($useragent, 'Safari')
            && false !== strpos($useragent, 'Version')
            && false !== strpos($useragent, 'Tizen')
        ) {
            return new Browser\SamsungWebView($useragent);
        } elseif (preg_match('/cybeye/i', $useragent)) {
            return new Browser\CybEye($useragent);
        } elseif (preg_match('/RebelMouse/', $useragent)) {
            return new Browser\RebelMouse($useragent);
        } elseif (preg_match('/SeaMonkey/', $useragent)) {
            return new Browser\Seamonkey($useragent);
        } elseif (preg_match('/Jobboerse/', $useragent)) {
            return new Browser\JobBoerseBot($useragent);
        } elseif (preg_match('/Navigator/', $useragent)) {
            return new Browser\NetscapeNavigator($useragent);
        } elseif (preg_match('/firefox/i', $useragent) && preg_match('/anonym/i', $useragent)) {
            return new Browser\Firefox($useragent);
        } elseif (preg_match('/trident/i', $useragent) && preg_match('/anonym/i', $useragent)) {
            return new Browser\MicrosoftInternetExplorer($useragent);
        } elseif (preg_match('/Windows\-RSS\-Platform/', $useragent)) {
            return new Browser\WindowsRssPlatform($useragent);
        } elseif (preg_match('/MarketwireBot/', $useragent)) {
            return new Browser\MarketwireBot($useragent);
        } elseif (preg_match('/GoogleToolbar/', $useragent)) {
            return new Browser\GoogleToolbar($useragent);
        } elseif (preg_match('/netscape/i', $useragent) && preg_match('/msie/i', $useragent)) {
            return new Browser\Netscape($useragent);
        } elseif (preg_match('/LSSRocketCrawler/', $useragent)) {
            return new Browser\LightspeedSystemsRocketCrawler($useragent);
        } elseif (preg_match('/lightspeedsystems/i', $useragent)) {
            return new Browser\LightspeedSystemsCrawler($useragent);
        } elseif (preg_match('/SL Commerce Client/', $useragent)) {
            return new Browser\SecondLiveCommerceClient($useragent);
        } elseif (preg_match('/(IEMobile|WPDesktop|ZuneWP7|XBLWP7)/', $useragent)) {
            return new Browser\MicrosoftMobileExplorer($useragent);
        } elseif (preg_match('/BingPreview/', $useragent)) {
            return new Browser\BingPreview($useragent);
        } elseif (preg_match('/360Spider/', $useragent)) {
            return new Browser\Bot360($useragent);
        } elseif (preg_match('/Outlook\-Express/', $useragent)) {
            return new Browser\WindowsLiveMail($useragent);
        } elseif (preg_match('/Outlook/', $useragent)) {
            return new Browser\MicrosoftOutlook($useragent);
        } elseif (preg_match('/microsoft office mobile/i', $useragent)) {
            return new Browser\MicrosoftOffice($useragent);
        } elseif (preg_match('/MSOffice/', $useragent)) {
            return new Browser\MicrosoftOffice($useragent);
        } elseif (preg_match('/Microsoft Office Protocol Discovery/', $useragent)) {
            return new Browser\MicrosoftOfficeProtocolDiscovery($useragent);
        } elseif (preg_match('/excel/i', $useragent)) {
            return new Browser\MicrosoftExcel($useragent);
        } elseif (preg_match('/powerpoint/i', $useragent)) {
            return new Browser\MicrosoftPowerPoint($useragent);
        } elseif (preg_match('/WordPress/', $useragent)) {
            return new Browser\WordPress($useragent);
        } elseif (preg_match('/Word/', $useragent)) {
            return new Browser\MicrosoftWord($useragent);
        } elseif (preg_match('/OneNote/', $useragent)) {
            return new Browser\MicrosoftOneNote($useragent);
        } elseif (preg_match('/Visio/', $useragent)) {
            return new Browser\MicrosoftVisio($useragent);
        } elseif (preg_match('/Access/', $useragent)) {
            return new Browser\MicrosoftAccess($useragent);
        } elseif (preg_match('/Lync/', $useragent)) {
            return new Browser\MicrosoftLync($useragent);
        } elseif (preg_match('/Office SyncProc/', $useragent)) {
            return new Browser\MicrosoftOfficeSyncProc($useragent);
        } elseif (preg_match('/Office Upload Center/', $useragent)) {
            return new Browser\MicrosoftOfficeUploadCenter($useragent);
        } elseif (preg_match('/frontpage/i', $useragent)) {
            return new Browser\MicrosoftFrontPage($useragent);
        } elseif (preg_match('/microsoft office/i', $useragent)) {
            return new Browser\MicrosoftOffice($useragent);
        } elseif (preg_match('/Crazy Browser/', $useragent)) {
            return new Browser\CrazyBrowser($useragent);
        } elseif (preg_match('/Deepnet Explorer/', $useragent)) {
            return new Browser\DeepnetExplorer($useragent);
        } elseif (preg_match('/kkman/i', $useragent)) {
            return new Browser\Kkman($useragent);
        } elseif (preg_match('/Lunascape/', $useragent)) {
            return new Browser\Lunascape($useragent);
        } elseif (preg_match('/Sleipnir/', $useragent)) {
            return new Browser\Sleipnir($useragent);
        } elseif (preg_match('/Smartsite HTTPClient/', $useragent)) {
            return new Browser\SmartsiteHttpClient($useragent);
        } elseif (preg_match('/GomezAgent/', $useragent)) {
            return new Browser\GomezSiteMonitor($useragent);
        } elseif (preg_match('/Mozilla\/5\.0.*\(.*Trident\/8\.0.*rv\:\d+\).*/', $useragent)
            || preg_match('/Mozilla\/5\.0.*\(.*Trident\/7\.0.*\) like Gecko.*/', $useragent)
            || preg_match('/Mozilla\/5\.0.*\(.*MSIE 10\.0.*Trident\/(4|5|6|7|8)\.0.*/', $useragent)
            || preg_match('/Mozilla\/(4|5)\.0.*\(.*MSIE (9|8|7|6)\.0.*/', $useragent)
            || preg_match('/Mozilla\/(4|5)\.0.*\(.*MSIE (5|4)\.\d+.*/', $useragent)
            || preg_match('/Mozilla\/\d\.\d+.*\(.*MSIE (3|2|1)\.\d+.*/', $useragent)
        ) {
            return new Browser\MicrosoftInternetExplorer($useragent);
        } elseif (false !== strpos($useragent, 'Chromium')) {
            return new Browser\Chromium($useragent);
        } elseif (false !== strpos($useragent, 'Iron')) {
            return new Browser\Iron($useragent);
        } elseif (preg_match('/midori/i', $useragent)) {
            return new Browser\Midori($useragent);
        } elseif (preg_match('/Google Page Speed Insights/', $useragent)) {
            return new Browser\GooglePageSpeedInsights($useragent);
        } elseif (preg_match('/(web\/snippet)/', $useragent)) {
            return new Browser\GoogleWebSnippet($useragent);
        } elseif (preg_match('/(googlebot\-mobile)/i', $useragent)) {
            return new Browser\GooglebotMobileBot($useragent);
        } elseif (preg_match('/Google Wireless Transcoder/', $useragent)) {
            return new Browser\GoogleWirelessTranscoder($useragent);
        } elseif (preg_match('/Locubot/', $useragent)) {
            return new Browser\Locubot($useragent);
        } elseif (preg_match('/(com\.google\.GooglePlus)/i', $useragent)) {
            return new Browser\GooglePlus($useragent);
        } elseif (preg_match('/Google\-HTTP\-Java\-Client/', $useragent)) {
            return new Browser\GoogleHttpClientLibraryForJava($useragent);
        } elseif (preg_match('/acapbot/i', $useragent)) {
            return new Browser\Acapbot($useragent);
        } elseif (preg_match('/googlebot\-image/i', $useragent)) {
            return new Browser\GoogleImageSearch($useragent);
        } elseif (preg_match('/googlebot/i', $useragent)) {
            return new Browser\Googlebot($useragent);
        } elseif (preg_match('/^GOOG$/', $useragent)) {
            return new Browser\Googlebot($useragent);
        } elseif (preg_match('/viera/i', $useragent)) {
            return new Browser\SmartViera($useragent);
        } elseif (preg_match('/Nichrome/', $useragent)) {
            return new Browser\Nichrome($useragent);
        } elseif (preg_match('/Kinza/', $useragent)) {
            return new Browser\Kinza($useragent);
        } elseif (preg_match('/Google Keyword Suggestion/', $useragent)) {
            return new Browser\GoogleKeywordSuggestion($useragent);
        } elseif (preg_match('/Google Web Preview/', $useragent)) {
            return new Browser\GoogleWebPreview($useragent);
        } elseif (preg_match('/Google-Adwords-DisplayAds-WebRender/', $useragent)) {
            return new Browser\GoogleAdwordsDisplayAdsWebRender($useragent);
        } elseif (preg_match('/HubSpot Webcrawler/', $useragent)) {
            return new Browser\HubSpotWebcrawler($useragent);
        } elseif (preg_match('/RockMelt/', $useragent)) {
            return new Browser\Rockmelt($useragent);
        } elseif (preg_match('/ SE /', $useragent)) {
            return new Browser\SogouExplorer($useragent);
        } elseif (preg_match('/ArchiveBot/', $useragent)) {
            return new Browser\ArchiveBot($useragent);
        } elseif (preg_match('/Edge/', $useragent) && null !== $platform && 'Windows Phone OS' === $platform->getName()) {
            return new Browser\MicrosoftEdgeMobile($useragent);
        } elseif (preg_match('/Edge/', $useragent)) {
            return new Browser\MicrosoftEdge($useragent);
        } elseif (preg_match('/diffbot/i', $useragent)) {
            return new Browser\Diffbot($useragent);
        } elseif (preg_match('/vivaldi/i', $useragent)) {
            return new Browser\Vivaldi($useragent);
        } elseif (preg_match('/LBBROWSER/', $useragent)) {
            return new Browser\Liebao($useragent);
        } elseif (preg_match('/Amigo/', $useragent)) {
            return new Browser\Amigo($useragent);
        } elseif (preg_match('/CoolNovoChromePlus/', $useragent)) {
            return new Browser\CoolNovoChromePlus($useragent);
        } elseif (preg_match('/CoolNovo/', $useragent)) {
            return new Browser\CoolNovo($useragent);
        } elseif (preg_match('/Kenshoo/', $useragent)) {
            return new Browser\Kenshoo($useragent);
        } elseif (preg_match('/Bowser/', $useragent)) {
            return new Browser\Bowser($useragent);
        } elseif (preg_match('/360SE/', $useragent)) {
            return new Browser\SecureBrowser360($useragent);
        } elseif (preg_match('/360EE/', $useragent)) {
            return new Browser\SpeedBrowser360($useragent);
        } elseif (preg_match('/ASW/', $useragent)) {
            return new Browser\AvastSafeZone($useragent);
        } elseif (preg_match('/Wire/', $useragent)) {
            return new Browser\WireApp($useragent);
        } elseif (preg_match('/chrome\/(\d+)\.(\d+)/i', $useragent, $matches)
            && isset($matches[1])
            && isset($matches[2])
            && $matches[1] >= 1
            && $matches[2] > 0
            && $matches[2] <= 10
        ) {
            return new Browser\ComodoDragon($useragent);
        } elseif (preg_match('/Flock/', $useragent)) {
            return new Browser\Flock($useragent);
        } elseif (preg_match('/Bromium Safari/', $useragent)) {
            return new Browser\Vsentry($useragent);
        } elseif (preg_match('/(chrome|crmo|crios)/i', $useragent)) {
            return new Browser\Chrome($useragent);
        } elseif (preg_match('/(dolphin http client)/i', $useragent)) {
            return new Browser\DolphinSmalltalkHttpClient($useragent);
        } elseif (preg_match('/(dolphin|dolfin)/i', $useragent)) {
            return new Browser\Dolfin($useragent);
        } elseif (preg_match('/Arora/', $useragent)) {
            return new Browser\Arora($useragent);
        } elseif (preg_match('/com\.douban\.group/i', $useragent)) {
            return new Browser\DoubanApp($useragent);
        } elseif (preg_match('/ovibrowser/i', $useragent)) {
            return new Browser\NokiaProxyBrowser($useragent);
        } elseif (preg_match('/MiuiBrowser/i', $useragent)) {
            return new Browser\MiuiBrowser($useragent);
        } elseif (preg_match('/ibrowser/i', $useragent)) {
            return new Browser\IBrowser($useragent);
        } elseif (preg_match('/OneBrowser/', $useragent)) {
            return new Browser\OneBrowser($useragent);
        } elseif (preg_match('/Baiduspider\-image/', $useragent)) {
            return new Browser\BaiduImageSearch($useragent);
        } elseif (preg_match('/http:\/\/www\.baidu\.com\/search/', $useragent)) {
            return new Browser\BaiduMobileSearch($useragent);
        } elseif (preg_match('/(yjapp|yjtop)/i', $useragent)) {
            return new Browser\YahooApp($useragent);
        } elseif (preg_match('/(linux; u; android|linux; android)/i', $useragent) && preg_match('/version/i', $useragent)) {
            return new Browser\AndroidWebkit($useragent);
        } elseif (preg_match('/safari/i', $useragent) && null !== $platform && 'Android' === $platform->getName()) {
            return new Browser\AndroidWebkit($useragent);
        } elseif (preg_match('/Browser\/AppleWebKit/', $useragent)) {
            return new Browser\AndroidWebkit($useragent);
        } elseif (preg_match('/Android\/[\d\.]+ release/', $useragent)) {
            return new Browser\AndroidWebkit($useragent);
        } elseif (false !== strpos($useragent, 'BlackBerry') && false !== strpos($useragent, 'Version')) {
            return new Browser\Blackberry($useragent);
        } elseif (preg_match('/(webOS|wOSBrowser|wOSSystem)/', $useragent)) {
            return new Browser\WebkitWebos($useragent);
        } elseif (preg_match('/OmniWeb/', $useragent)) {
            return new Browser\Omniweb($useragent);
        } elseif (preg_match('/Windows Phone Search/', $useragent)) {
            return new Browser\WindowsPhoneSearch($useragent);
        } elseif (preg_match('/Windows\-Update\-Agent/', $useragent)) {
            return new Browser\WindowsUpdateAgent($useragent);
        } elseif (preg_match('/nokia/i', $useragent)) {
            return new Browser\NokiaBrowser($useragent);
        } elseif (preg_match('/twitter for i/i', $useragent)) {
            return new Browser\TwitterApp($useragent);
        } elseif (preg_match('/twitterbot/i', $useragent)) {
            return new Browser\Twitterbot($useragent);
        } elseif (preg_match('/GSA/', $useragent)) {
            return new Browser\GoogleApp($useragent);
        } elseif (preg_match('/QtCarBrowser/', $useragent)) {
            return new Browser\ModelsBrowser($useragent);
        } elseif (preg_match('/Qt/', $useragent)) {
            return new Browser\Qt($useragent);
        } elseif (preg_match('/Instagram/', $useragent)) {
            return new Browser\InstagramApp($useragent);
        } elseif (preg_match('/WebClip/', $useragent)) {
            return new Browser\WebClip($useragent);
        } elseif (preg_match('/Mercury/', $useragent)) {
            return new Browser\Mercury($useragent);
        } elseif (preg_match('/MacAppStore/', $useragent)) {
            return new Browser\MacAppStore($useragent);
        } elseif (preg_match('/AppStore/', $useragent)) {
            return new Browser\AppleAppStoreApp($useragent);
        } elseif (preg_match('/Webglance/', $useragent)) {
            return new Browser\WebGlance($useragent);
        } elseif (preg_match('/YHOO\_Search\_App/', $useragent)) {
            return new Browser\YahooMobileApp($useragent);
        } elseif (preg_match('/NewsBlur Feed Fetcher/', $useragent)) {
            return new Browser\NewsBlurFeedFetcher($useragent);
        } elseif (preg_match('/AppleCoreMedia/', $useragent)) {
            return new Browser\AppleCoreMedia($useragent);
        } elseif (preg_match('/dataaccessd/', $useragent)) {
            return new Browser\IosDataaccessd($useragent);
        } elseif (preg_match('/MailChimp/', $useragent)) {
            return new Browser\MailChimp($useragent);
        } elseif (preg_match('/MailBar/', $useragent)) {
            return new Browser\MailBar($useragent);
        } elseif (preg_match('/^Mail/', $useragent)) {
            return new Browser\AppleMail($useragent);
        } elseif (preg_match('/^Mozilla\/5\.0.*\(.*(CPU iPhone OS|CPU OS) \d+(_|\.)\d+.* like Mac OS X.*\) AppleWebKit.* \(KHTML, like Gecko\)$/', $useragent)) {
            return new Browser\AppleMail($useragent);
        } elseif (preg_match('/^Mozilla\/5\.0 \(Macintosh; Intel Mac OS X.*\) AppleWebKit.* \(KHTML, like Gecko\)$/', $useragent)) {
            return new Browser\AppleMail($useragent);
        } elseif (preg_match('/^Mozilla\/5\.0 \(Windows.*\) AppleWebKit.* \(KHTML, like Gecko\)$/', $useragent)) {
            return new Browser\AppleMail($useragent);
        } elseif (preg_match('/msnbot\-media/i', $useragent)) {
            return new Browser\MsnBotMedia($useragent);
        } elseif (preg_match('/adidxbot/i', $useragent)) {
            return new Browser\Adidxbot($useragent);
        } elseif (preg_match('/msnbot/i', $useragent)) {
            return new Browser\Bingbot($useragent);
        } elseif (preg_match('/(backberry|bb10)/i', $useragent)) {
            return new Browser\Blackberry($useragent);
        } elseif (preg_match('/WeTab\-Browser/', $useragent)) {
            return new Browser\WeTabBrowser($useragent);
        } elseif (preg_match('/profiller/', $useragent)) {
            return new Browser\Profiller($useragent);
        } elseif (preg_match('/(wkhtmltopdf)/i', $useragent)) {
            return new Browser\WkHtmltopdf($useragent);
        } elseif (preg_match('/(wkhtmltoimage)/i', $useragent)) {
            return new Browser\WkHtmltoImage($useragent);
        } elseif (preg_match('/(wp\-iphone|wp\-android)/', $useragent)) {
            return new Browser\WordPressApp($useragent);
        } elseif (preg_match('/OktaMobile/', $useragent)) {
            return new Browser\OktaMobileApp($useragent);
        } elseif (preg_match('/kmail2/', $useragent)) {
            return new Browser\Kmail2($useragent);
        } elseif (preg_match('/eb\-iphone/', $useragent)) {
            return new Browser\EbApp($useragent);
        } elseif (preg_match('/ElmediaPlayer/', $useragent)) {
            return new Browser\ElmediaPlayer($useragent);
        } elseif (preg_match('/Schoolwires/', $useragent)) {
            return new Browser\SchoolwiresApp($useragent);
        } elseif (preg_match('/Dreamweaver/', $useragent)) {
            return new Browser\Dreamweaver($useragent);
        } elseif (preg_match('/akregator/', $useragent)) {
            return new Browser\Akregator($useragent);
        } elseif (preg_match('/Installatron/', $useragent)) {
            return new Browser\Installatron($useragent);
        } elseif (preg_match('/Quora Link Preview/', $useragent)) {
            return new Browser\QuoraLinkPreviewBot($useragent);
        } elseif (preg_match('/Quora/', $useragent)) {
            return new Browser\QuoraApp($useragent);
        } elseif (preg_match('/Rocky ChatWork Mobile/', $useragent)) {
            return new Browser\RockyChatWorkMobile($useragent);
        } elseif (preg_match('/AdsBot\-Google\-Mobile/', $useragent)) {
            return new Browser\GoogleAdsbotMobile($useragent);
        } elseif (preg_match('/epiphany/i', $useragent)) {
            return new Browser\Epiphany($useragent);
        } elseif (preg_match('/rekonq/', $useragent)) {
            return new Browser\Rekonq($useragent);
        } elseif (preg_match('/Skyfire/', $useragent)) {
            return new Browser\Skyfire($useragent);
        } elseif (preg_match('/FlixsteriOS/', $useragent)) {
            return new Browser\FlixsterApp($useragent);
        } elseif (preg_match('/(adbeat\_bot|adbeat\.com)/', $useragent)) {
            return new Browser\AdbeatBot($useragent);
        } elseif (preg_match('/(SecondLife|Second Life)/', $useragent)) {
            return new Browser\SecondLiveClient($useragent);
        } elseif (preg_match('/(Salesforce1|SalesforceTouchContainer)/', $useragent)) {
            return new Browser\SalesForceApp($useragent);
        } elseif (preg_match('/(nagios\-plugins|check\_http)/', $useragent)) {
            return new Browser\Nagios($useragent);
        } elseif (preg_match('/bingbot/i', $useragent)) {
            return new Browser\Bingbot($useragent);
        } elseif (preg_match('/Mediapartners\-Google/', $useragent)) {
            return new Browser\GoogleAdSenseBot($useragent);
        } elseif (preg_match('/SMTBot/', $useragent)) {
            return new Browser\SmtBot($useragent);
        } elseif (preg_match('/domain\.com/', $useragent)) {
            return new Browser\PagePeekerScreenshotMaker($useragent);
        } elseif (preg_match('/PagePeeker/', $useragent)) {
            return new Browser\PagePeeker($useragent);
        } elseif (preg_match('/DiigoBrowser/', $useragent)) {
            return new Browser\DiigoBrowser($useragent);
        } elseif (preg_match('/kontact/', $useragent)) {
            return new Browser\Kontact($useragent);
        } elseif (preg_match('/QupZilla/', $useragent)) {
            return new Browser\QupZilla($useragent);
        } elseif (preg_match('/FxiOS/', $useragent)) {
            return new Browser\FirefoxIos($useragent);
        } elseif (preg_match('/qutebrowser/', $useragent)) {
            return new Browser\QuteBrowser($useragent);
        } elseif (preg_match('/Otter/', $useragent)) {
            return new Browser\Otter($useragent);
        } elseif (preg_match('/PaleMoon/', $useragent)) {
            return new Browser\Palemoon($useragent);
        } elseif (preg_match('/slurp/i', $useragent)) {
            return new Browser\YahooSlurp($useragent);
        } elseif (preg_match('/applebot/i', $useragent)) {
            return new Browser\Applebot($useragent);
        } elseif (preg_match('/SoundCloud/', $useragent)) {
            return new Browser\SoundCloudApp($useragent);
        } elseif (preg_match('/Rival IQ/', $useragent)) {
            return new Browser\RivalIqBot($useragent);
        } elseif (preg_match('/Evernote Clip Resolver/', $useragent)) {
            return new Browser\EvernoteClipResolver($useragent);
        } elseif (preg_match('/Evernote/', $useragent)) {
            return new Browser\EvernoteApp($useragent);
        } elseif (preg_match('/Fluid/', $useragent)) {
            return new Browser\Fluid($useragent);
        } elseif (preg_match('/safari/i', $useragent)) {
            return new Browser\Safari($useragent);
        } elseif (preg_match('/^Mozilla\/(4|5)\.0 \(Macintosh; .* Mac OS X .*\) AppleWebKit\/.* \(KHTML, like Gecko\) Version\/[\d\.]+$/i', $useragent)) {
            return new Browser\Safari($useragent);
        } elseif (preg_match('/TWCAN\/SportsNet/', $useragent)) {
            return new Browser\TwcSportsNet($useragent);
        } elseif (preg_match('/AdobeAIR/', $useragent)) {
            return new Browser\AdobeAIR($useragent);
        } elseif (preg_match('/(easouspider)/i', $useragent)) {
            return new Browser\EasouSpider($useragent);
        } elseif (preg_match('/^Mozilla\/5\.0.*\((iPhone|iPad|iPod).*\).*AppleWebKit\/.*\(.*KHTML, like Gecko.*\).*Mobile.*/i', $useragent)) {
            return new Browser\MobileSafariUiWebView($useragent);
        } elseif (preg_match('/waterfox/i', $useragent)) {
            return new Browser\WaterFox($useragent);
        } elseif (preg_match('/Thunderbird/', $useragent)) {
            return new Browser\Thunderbird($useragent);
        } elseif (preg_match('/Fennec/', $useragent)) {
            return new Browser\Fennec($useragent);
        } elseif (preg_match('/myibrow/', $useragent)) {
            return new Browser\MyInternetBrowser($useragent);
        } elseif (preg_match('/Daumoa/', $useragent)) {
            return new Browser\Daumoa($useragent);
        } elseif (preg_match('/PaleMoon/', $useragent)) {
            return new Browser\Palemoon($useragent);
        } elseif (preg_match('/iceweasel/i', $useragent)) {
            return new Browser\Iceweasel($useragent);
        } elseif (preg_match('/icecat/i', $useragent)) {
            return new Browser\IceCat($useragent);
        } elseif (preg_match('/iceape/i', $useragent)) {
            return new Browser\Iceape($useragent);
        } elseif (preg_match('/galeon/i', $useragent)) {
            return new Browser\Galeon($useragent);
        } elseif (preg_match('/SurveyBot/', $useragent)) {
            return new Browser\SurveyBot($useragent);
        } elseif (preg_match('/aggregator\:Spinn3r/', $useragent)) {
            return new Browser\Spinn3rRssAggregator($useragent);
        } elseif (preg_match('/TweetmemeBot/', $useragent)) {
            return new Browser\TweetmemeBot($useragent);
        } elseif (preg_match('/Butterfly/', $useragent)) {
            return new Browser\ButterflyRobot($useragent);
        } elseif (preg_match('/James BOT/', $useragent)) {
            return new Browser\JamesBot($useragent);
        } elseif (preg_match('/MSIE or Firefox mutant; not on Windows server/', $useragent)) {
            return new Browser\Daumoa($useragent);
        } elseif (preg_match('/SailfishBrowser/', $useragent)) {
            return new Browser\SailfishBrowser($useragent);
        } elseif (preg_match('/KcB/', $useragent)) {
            return new Browser\UnknownBrowser($useragent);
        } elseif (preg_match('/kazehakase/i', $useragent)) {
            return new Browser\Kazehakase($useragent);
        } elseif (preg_match('/cometbird/i', $useragent)) {
            return new Browser\CometBird($useragent);
        } elseif (preg_match('/Camino/', $useragent)) {
            return new Browser\Camino($useragent);
        } elseif (preg_match('/SlimerJS/', $useragent)) {
            return new Browser\SlimerJs($useragent);
        } elseif (preg_match('/MultiZilla/', $useragent)) {
            return new Browser\MultiZilla($useragent);
        } elseif (preg_match('/Minimo/', $useragent)) {
            return new Browser\Minimo($useragent);
        } elseif (preg_match('/MicroB/', $useragent)) {
            return new Browser\MicroB($useragent);
        } elseif (preg_match('/firefox/i', $useragent)
            && !preg_match('/gecko/i', $useragent)
            && preg_match('/anonymized/i', $useragent)
        ) {
            return new Browser\Firefox($useragent);
        } elseif (preg_match('/(firefox|minefield|shiretoko|bonecho|namoroka)/i', $useragent)) {
            return new Browser\Firefox($useragent);
        } elseif (preg_match('/gvfs/', $useragent)) {
            return new Browser\Gvfs($useragent);
        } elseif (preg_match('/luakit/', $useragent)) {
            return new Browser\Luakit($useragent);
        } elseif (preg_match('/playstation 3/i', $useragent)) {
            return new Browser\NetFront($useragent);
        } elseif (preg_match('/sistrix/i', $useragent)) {
            return new Browser\Sistrix($useragent);
        } elseif (preg_match('/ezooms/i', $useragent)) {
            return new Browser\Ezooms($useragent);
        } elseif (preg_match('/grapefx/i', $useragent)) {
            return new Browser\GrapeFx($useragent);
        } elseif (preg_match('/grapeshotcrawler/i', $useragent)) {
            return new Browser\GrapeshotCrawler($useragent);
        } elseif (preg_match('/(mail\.ru)/i', $useragent)) {
            return new Browser\MailRu($useragent);
        } elseif (preg_match('/(proximic)/i', $useragent)) {
            return new Browser\Proximic($useragent);
        } elseif (preg_match('/(polaris)/i', $useragent)) {
            return new Browser\Polaris($useragent);
        } elseif (preg_match('/(another web mining tool|awmt)/i', $useragent)) {
            return new Browser\AnotherWebMiningTool($useragent);
        } elseif (preg_match('/(wbsearchbot|wbsrch)/i', $useragent)) {
            return new Browser\WbSearchBot($useragent);
        } elseif (preg_match('/(konqueror)/i', $useragent)) {
            return new Browser\Konqueror($useragent);
        } elseif (preg_match('/(typo3\-linkvalidator)/i', $useragent)) {
            return new Browser\Typo3Linkvalidator($useragent);
        } elseif (preg_match('/feeddlerrss/i', $useragent)) {
            return new Browser\FeeddlerRssReader($useragent);
        } elseif (preg_match('/^mozilla\/5\.0 \((iphone|ipad|ipod).*CPU like Mac OS X.*\) AppleWebKit\/\d+/i', $useragent)) {
            return new Browser\Safari($useragent);
        } elseif (preg_match('/(ios|iphone|ipad|ipod)/i', $useragent)) {
            return new Browser\MobileSafariUiWebView($useragent);
        } elseif (preg_match('/paperlibot/i', $useragent)) {
            return new Browser\PaperLiBot($useragent);
        } elseif (preg_match('/spbot/i', $useragent)) {
            return new Browser\Seoprofiler($useragent);
        } elseif (preg_match('/dotbot/i', $useragent)) {
            return new Browser\DotBot($useragent);
        } elseif (preg_match('/(google\-structureddatatestingtool|Google\-structured\-data\-testing\-tool)/i', $useragent)) {
            return new Browser\GoogleStructuredDataTestingTool($useragent);
        } elseif (preg_match('/webmastercoffee/i', $useragent)) {
            return new Browser\WebmasterCoffee($useragent);
        } elseif (preg_match('/ahrefs/i', $useragent)) {
            return new Browser\AhrefsBot($useragent);
        } elseif (preg_match('/apercite/i', $useragent)) {
            return new Browser\Apercite($useragent);
        } elseif (preg_match('/woobot/', $useragent)) {
            return new Browser\WooRank($useragent);
        } elseif (preg_match('/Blekkobot/', $useragent)) {
            return new Browser\BlekkoBot($useragent);
        } elseif (preg_match('/PagesInventory/', $useragent)) {
            return new Browser\PagesInventoryBot($useragent);
        } elseif (preg_match('/Slackbot\-LinkExpanding/', $useragent)) {
            return new Browser\SlackbotLinkExpanding($useragent);
        } elseif (preg_match('/Slackbot/', $useragent)) {
            return new Browser\Slackbot($useragent);
        } elseif (preg_match('/SEOkicks\-Robot/', $useragent)) {
            return new Browser\Seokicks($useragent);
        } elseif (preg_match('/Exabot/', $useragent)) {
            return new Browser\Exabot($useragent);
        } elseif (preg_match('/DomainSCAN/', $useragent)) {
            return new Browser\DomainScanServerMonitoring($useragent);
        } elseif (preg_match('/JobRoboter/', $useragent)) {
            return new Browser\JobRoboter($useragent);
        } elseif (preg_match('/AcoonBot/', $useragent)) {
            return new Browser\AcoonBot($useragent);
        } elseif (preg_match('/woriobot/', $useragent)) {
            return new Browser\Woriobot($useragent);
        } elseif (preg_match('/MonoBot/', $useragent)) {
            return new Browser\MonoBot($useragent);
        } elseif (preg_match('/DomainSigmaCrawler/', $useragent)) {
            return new Browser\DomainSigmaCrawler($useragent);
        } elseif (preg_match('/bnf\.fr\_bot/', $useragent)) {
            return new Browser\BnfFrBot($useragent);
        } elseif (preg_match('/CrawlRobot/', $useragent)) {
            return new Browser\CrawlRobot($useragent);
        } elseif (preg_match('/AddThis\.com robot/', $useragent)) {
            return new Browser\AddThisRobot($useragent);
        } elseif (preg_match('/(Yeti|naver\.com\/robots)/', $useragent)) {
            return new Browser\NaverBot($useragent);
        } elseif (preg_match('/^robots$/', $useragent)) {
            return new Browser\TestCrawler($useragent);
        } elseif (preg_match('/DeuSu/', $useragent)) {
            return new Browser\WerbefreieDeutscheSuchmaschine($useragent);
        } elseif (preg_match('/obot/i', $useragent)) {
            return new Browser\Obot($useragent);
        } elseif (preg_match('/ZumBot/', $useragent)) {
            return new Browser\ZumBot($useragent);
        } elseif (preg_match('/(umbot)/i', $useragent)) {
            return new Browser\UmBot($useragent);
        } elseif (preg_match('/(picmole)/i', $useragent)) {
            return new Browser\PicmoleBot($useragent);
        } elseif (preg_match('/(zollard)/i', $useragent)) {
            return new Browser\ZollardWorm($useragent);
        } elseif (preg_match('/(fhscan core)/i', $useragent)) {
            return new Browser\FhscanCore($useragent);
        } elseif (preg_match('/nbot/i', $useragent)) {
            return new Browser\Nbot($useragent);
        } elseif (preg_match('/(loadtimebot)/i', $useragent)) {
            return new Browser\LoadTimeBot($useragent);
        } elseif (preg_match('/(scrubby)/i', $useragent)) {
            return new Browser\Scrubby($useragent);
        } elseif (preg_match('/(squzer)/i', $useragent)) {
            return new Browser\Squzer($useragent);
        } elseif (preg_match('/PiplBot/', $useragent)) {
            return new Browser\PiplBot($useragent);
        } elseif (preg_match('/EveryoneSocialBot/', $useragent)) {
            return new Browser\EveryoneSocialBot($useragent);
        } elseif (preg_match('/AOLbot/', $useragent)) {
            return new Browser\AolBot($useragent);
        } elseif (preg_match('/GLBot/', $useragent)) {
            return new Browser\GlBot($useragent);
        } elseif (preg_match('/(lbot)/i', $useragent)) {
            return new Browser\Lbot($useragent);
        } elseif (preg_match('/(blexbot)/i', $useragent)) {
            return new Browser\BlexBot($useragent);
        } elseif (preg_match('/(socialradarbot)/i', $useragent)) {
            return new Browser\Socialradarbot($useragent);
        } elseif (preg_match('/(synapse)/i', $useragent)) {
            return new Browser\ApacheSynapse($useragent);
        } elseif (preg_match('/(linkdexbot)/i', $useragent)) {
            return new Browser\LinkdexBot($useragent);
        } elseif (preg_match('/(coccoc)/i', $useragent)) {
            return new Browser\CocCocBot($useragent);
        } elseif (preg_match('/(siteexplorer)/i', $useragent)) {
            return new Browser\SiteExplorer($useragent);
        } elseif (preg_match('/(semrushbot)/i', $useragent)) {
            return new Browser\SemrushBot($useragent);
        } elseif (preg_match('/(istellabot)/i', $useragent)) {
            return new Browser\IstellaBot($useragent);
        } elseif (preg_match('/(meanpathbot)/i', $useragent)) {
            return new Browser\MeanpathBot($useragent);
        } elseif (preg_match('/(XML Sitemaps Generator)/', $useragent)) {
            return new Browser\XmlSitemapsGenerator($useragent);
        } elseif (preg_match('/SeznamBot/', $useragent)) {
            return new Browser\SeznamBot($useragent);
        } elseif (preg_match('/URLAppendBot/', $useragent)) {
            return new Browser\UrlAppendBot($useragent);
        } elseif (preg_match('/NetSeer crawler/', $useragent)) {
            return new Browser\NetseerCrawler($useragent);
        } elseif (preg_match('/SeznamBot/', $useragent)) {
            return new Browser\SeznamBot($useragent);
        } elseif (preg_match('/Add Catalog/', $useragent)) {
            return new Browser\AddCatalog($useragent);
        } elseif (preg_match('/Moreover/', $useragent)) {
            return new Browser\Moreover($useragent);
        } elseif (preg_match('/LinkpadBot/', $useragent)) {
            return new Browser\LinkpadBot($useragent);
        } elseif (preg_match('/Lipperhey SEO Service/', $useragent)) {
            return new Browser\LipperheySeoService($useragent);
        } elseif (preg_match('/Blog Search/', $useragent)) {
            return new Browser\BlogSearch($useragent);
        } elseif (preg_match('/Qualidator\.com Bot/', $useragent)) {
            return new Browser\QualidatorBot($useragent);
        } elseif (preg_match('/fr\-crawler/', $useragent)) {
            return new Browser\FrCrawler($useragent);
        } elseif (preg_match('/ca\-crawler/', $useragent)) {
            return new Browser\CaCrawler($useragent);
        } elseif (preg_match('/Website Thumbnail Generator/', $useragent)) {
            return new Browser\WebsiteThumbnailGenerator($useragent);
        } elseif (preg_match('/WebThumb/', $useragent)) {
            return new Browser\WebThumb($useragent);
        } elseif (preg_match('/KomodiaBot/', $useragent)) {
            return new Browser\KomodiaBot($useragent);
        } elseif (preg_match('/GroupHigh/', $useragent)) {
            return new Browser\GroupHighBot($useragent);
        } elseif (preg_match('/theoldreader/', $useragent)) {
            return new Browser\TheOldReader($useragent);
        } elseif (preg_match('/Google\-Site\-Verification/', $useragent)) {
            return new Browser\GoogleSiteVerification($useragent);
        } elseif (preg_match('/Prlog/', $useragent)) {
            return new Browser\Prlog($useragent);
        } elseif (preg_match('/CMS Crawler/', $useragent)) {
            return new Browser\CmsCrawler($useragent);
        } elseif (preg_match('/pmoz\.info ODP link checker/', $useragent)) {
            return new Browser\PmozinfoOdpLinkChecker($useragent);
        } elseif (preg_match('/Twingly Recon/', $useragent)) {
            return new Browser\TwinglyRecon($useragent);
        } elseif (preg_match('/Embedly/', $useragent)) {
            return new Browser\Embedly($useragent);
        } elseif (preg_match('/Alexabot/', $useragent)) {
            return new Browser\Alexabot($useragent);
        } elseif (preg_match('/alexa site audit/', $useragent)) {
            return new Browser\AlexaSiteAudit($useragent);
        } elseif (preg_match('/MJ12bot/', $useragent)) {
            return new Browser\Mj12bot($useragent);
        } elseif (preg_match('/HTTrack/', $useragent)) {
            return new Browser\Httrack($useragent);
        } elseif (preg_match('/UnisterBot/', $useragent)) {
            return new Browser\Unisterbot($useragent);
        } elseif (preg_match('/CareerBot/', $useragent)) {
            return new Browser\CareerBot($useragent);
        } elseif (preg_match('/80legs/i', $useragent)) {
            return new Browser\Bot80Legs($useragent);
        } elseif (preg_match('/wada\.vn/i', $useragent)) {
            return new Browser\WadavnSearchBot($useragent);
        } elseif (preg_match('/(NX|WiiU|Nintendo 3DS)/', $useragent)) {
            return new Browser\NetFrontNx($useragent);
        } elseif (preg_match('/(netfront|playstation 4)/i', $useragent)) {
            return new Browser\NetFront($useragent);
        } elseif (preg_match('/XoviBot/', $useragent)) {
            return new Browser\XoviBot($useragent);
        } elseif (preg_match('/007ac9 Crawler/', $useragent)) {
            return new Browser\Crawler007AC9($useragent);
        } elseif (preg_match('/200PleaseBot/', $useragent)) {
            return new Browser\Please200Bot($useragent);
        } elseif (preg_match('/Abonti/', $useragent)) {
            return new Browser\AbontiBot($useragent);
        } elseif (preg_match('/publiclibraryarchive/', $useragent)) {
            return new Browser\PublicLibraryArchive($useragent);
        } elseif (preg_match('/PAD\-bot/', $useragent)) {
            return new Browser\PadBot($useragent);
        } elseif (preg_match('/SoftListBot/', $useragent)) {
            return new Browser\SoftListBot($useragent);
        } elseif (preg_match('/sReleaseBot/', $useragent)) {
            return new Browser\SreleaseBot($useragent);
        } elseif (preg_match('/Vagabondo/', $useragent)) {
            return new Browser\Vagabondo($useragent);
        } elseif (preg_match('/special\_archiver/', $useragent)) {
            return new Browser\InternetArchiveSpecialArchiver($useragent);
        } elseif (preg_match('/Optimizer/', $useragent)) {
            return new Browser\OptimizerBot($useragent);
        } elseif (preg_match('/Sophora Linkchecker/', $useragent)) {
            return new Browser\SophoraLinkchecker($useragent);
        } elseif (preg_match('/SEOdiver/', $useragent)) {
            return new Browser\SeoDiver($useragent);
        } elseif (preg_match('/itsscan/', $useragent)) {
            return new Browser\ItsScan($useragent);
        } elseif (preg_match('/Google Desktop/', $useragent)) {
            return new Browser\GoogleDesktop($useragent);
        } elseif (preg_match('/Lotus\-Notes/', $useragent)) {
            return new Browser\LotusNotes($useragent);
        } elseif (preg_match('/AskPeterBot/', $useragent)) {
            return new Browser\AskPeterBot($useragent);
        } elseif (preg_match('/discoverybot/', $useragent)) {
            return new Browser\DiscoveryBot($useragent);
        } elseif (preg_match('/YandexBot/', $useragent)) {
            return new Browser\YandexBot($useragent);
        } elseif (preg_match('/MOSBookmarks/', $useragent) && preg_match('/Link Checker/', $useragent)) {
            return new Browser\MosBookmarksLinkChecker($useragent);
        } elseif (preg_match('/MOSBookmarks/', $useragent)) {
            return new Browser\MosBookmarks($useragent);
        } elseif (preg_match('/WebMasterAid/', $useragent)) {
            return new Browser\WebMasterAid($useragent);
        } elseif (preg_match('/AboutUsBot Johnny5/', $useragent)) {
            return new Browser\AboutUsBotJohnny5($useragent);
        } elseif (preg_match('/AboutUsBot/', $useragent)) {
            return new Browser\AboutUsBot($useragent);
        } elseif (preg_match('/semantic\-visions\.com crawler/', $useragent)) {
            return new Browser\SemanticVisionsCrawler($useragent);
        } elseif (preg_match('/waybackarchive\.org/', $useragent)) {
            return new Browser\WaybackArchive($useragent);
        } elseif (preg_match('/OpenVAS/', $useragent)) {
            return new Browser\OpenVulnerabilityAssessmentSystem($useragent);
        } elseif (preg_match('/MixrankBot/', $useragent)) {
            return new Browser\MixrankBot($useragent);
        } elseif (preg_match('/InfegyAtlas/', $useragent)) {
            return new Browser\InfegyAtlasBot($useragent);
        } elseif (preg_match('/MojeekBot/', $useragent)) {
            return new Browser\MojeekBot($useragent);
        } elseif (preg_match('/memorybot/i', $useragent)) {
            return new Browser\MemoryBot($useragent);
        } elseif (preg_match('/DomainAppender/', $useragent)) {
            return new Browser\DomainAppenderBot($useragent);
        } elseif (preg_match('/GIDBot/', $useragent)) {
            return new Browser\GidBot($useragent);
        } elseif (preg_match('/DBot/', $useragent)) {
            return new Browser\Dbot($useragent);
        } elseif (preg_match('/PWBot/', $useragent)) {
            return new Browser\PwBot($useragent);
        } elseif (preg_match('/\+5Bot/', $useragent)) {
            return new Browser\Plus5Bot($useragent);
        } elseif (preg_match('/WASALive\-Bot/', $useragent)) {
            return new Browser\WasaLiveBot($useragent);
        } elseif (preg_match('/OpenHoseBot/', $useragent)) {
            return new Browser\OpenHoseBot($useragent);
        } elseif (preg_match('/URLfilterDB\-crawler/', $useragent)) {
            return new Browser\UrlfilterDbCrawler($useragent);
        } elseif (preg_match('/metager2\-verification\-bot/', $useragent)) {
            return new Browser\Metager2VerificationBot($useragent);
        } elseif (preg_match('/Powermarks/', $useragent)) {
            return new Browser\Powermarks($useragent);
        } elseif (preg_match('/CloudFlare\-AlwaysOnline/', $useragent)) {
            return new Browser\CloudFlareAlwaysOnline($useragent);
        } elseif (preg_match('/Phantom\.js bot/', $useragent)) {
            return new Browser\PhantomJsBot($useragent);
        } elseif (preg_match('/Phantom/', $useragent)) {
            return new Browser\PhantomBrowser($useragent);
        } elseif (preg_match('/Shrook/', $useragent)) {
            return new Browser\Shrook($useragent);
        } elseif (preg_match('/netEstate NE Crawler/', $useragent)) {
            return new Browser\NetEstateCrawler($useragent);
        } elseif (preg_match('/garlikcrawler/i', $useragent)) {
            return new Browser\GarlikCrawler($useragent);
        } elseif (preg_match('/metageneratorcrawler/i', $useragent)) {
            return new Browser\MetaGeneratorCrawler($useragent);
        } elseif (preg_match('/ScreenerBot/', $useragent)) {
            return new Browser\ScreenerBot($useragent);
        } elseif (preg_match('/WebTarantula\.com Crawler/', $useragent)) {
            return new Browser\WebTarantula($useragent);
        } elseif (preg_match('/BacklinkCrawler/', $useragent)) {
            return new Browser\BacklinkCrawler($useragent);
        } elseif (preg_match('/LinksCrawler/', $useragent)) {
            return new Browser\LinksCrawler($useragent);
        } elseif (preg_match('/(ssearch\_bot|sSearch Crawler)/', $useragent)) {
            return new Browser\SsearchCrawler($useragent);
        } elseif (preg_match('/HRCrawler/', $useragent)) {
            return new Browser\HrCrawler($useragent);
        } elseif (preg_match('/ICC\-Crawler/', $useragent)) {
            return new Browser\IccCrawler($useragent);
        } elseif (preg_match('/Arachnida Web Crawler/', $useragent)) {
            return new Browser\ArachnidaWebCrawler($useragent);
        } elseif (preg_match('/Finderlein Research Crawler/', $useragent)) {
            return new Browser\FinderleinResearchCrawler($useragent);
        } elseif (preg_match('/TestCrawler/', $useragent)) {
            return new Browser\TestCrawler($useragent);
        } elseif (preg_match('/Scopia Crawler/', $useragent)) {
            return new Browser\ScopiaCrawler($useragent);
        } elseif (preg_match('/Crawler/', $useragent)) {
            return new Browser\Crawler($useragent);
        } elseif (preg_match('/MetaJobBot/', $useragent)) {
            return new Browser\MetaJobBot($useragent);
        } elseif (preg_match('/jig browser web/', $useragent)) {
            return new Browser\JigBrowserWeb($useragent);
        } elseif (preg_match('/T\-H\-U\-N\-D\-E\-R\-S\-T\-O\-N\-E/', $useragent)) {
            return new Browser\TexisWebscript($useragent);
        } elseif (preg_match('/focuseekbot/', $useragent)) {
            return new Browser\Focuseekbot($useragent);
        } elseif (preg_match('/vBSEO/', $useragent)) {
            return new Browser\VbulletinSeoBot($useragent);
        } elseif (preg_match('/kgbody/', $useragent)) {
            return new Browser\Kgbody($useragent);
        } elseif (preg_match('/JobdiggerSpider/', $useragent)) {
            return new Browser\JobdiggerSpider($useragent);
        } elseif (preg_match('/imrbot/', $useragent)) {
            return new Browser\MignifyBot($useragent);
        } elseif (preg_match('/kulturarw3/', $useragent)) {
            return new Browser\Kulturarw3($useragent);
        } elseif (preg_match('/LucidWorks/', $useragent)) {
            return new Browser\LucidworksBot($useragent);
        } elseif (preg_match('/MerchantCentricBot/', $useragent)) {
            return new Browser\MerchantCentricBot($useragent);
        } elseif (preg_match('/Nett\.io bot/', $useragent)) {
            return new Browser\NettioBot($useragent);
        } elseif (preg_match('/SemanticBot/', $useragent)) {
            return new Browser\SemanticBot($useragent);
        } elseif (preg_match('/tweetedtimes/i', $useragent)) {
            return new Browser\TweetedTimesBot($useragent);
        } elseif (preg_match('/vkShare/', $useragent)) {
            return new Browser\VkShare($useragent);
        } elseif (preg_match('/Yahoo Ad monitoring/', $useragent)) {
            return new Browser\YahooAdMonitoring($useragent);
        } elseif (preg_match('/YioopBot/', $useragent)) {
            return new Browser\YioopBot($useragent);
        } elseif (preg_match('/zitebot/', $useragent)) {
            return new Browser\Zitebot($useragent);
        } elseif (preg_match('/Espial/', $useragent)) {
            return new Browser\EspialTvBrowser($useragent);
        } elseif (preg_match('/SiteCon/', $useragent)) {
            return new Browser\SiteCon($useragent);
        } elseif (preg_match('/iBooks Author/', $useragent)) {
            return new Browser\IbooksAuthor($useragent);
        } elseif (preg_match('/iWeb/', $useragent)) {
            return new Browser\Iweb($useragent);
        } elseif (preg_match('/NewsFire/', $useragent)) {
            return new Browser\NewsFire($useragent);
        } elseif (preg_match('/RMSnapKit/', $useragent)) {
            return new Browser\RmSnapKit($useragent);
        } elseif (preg_match('/Sandvox/', $useragent)) {
            return new Browser\Sandvox($useragent);
        } elseif (preg_match('/TubeTV/', $useragent)) {
            return new Browser\TubeTv($useragent);
        } elseif (preg_match('/Elluminate Live/', $useragent)) {
            return new Browser\ElluminateLive($useragent);
        } elseif (preg_match('/Element Browser/', $useragent)) {
            return new Browser\ElementBrowser($useragent);
        } elseif (preg_match('/K\-Meleon/', $useragent)) {
            return new Browser\Kmeleon($useragent);
        } elseif (preg_match('/Esribot/', $useragent)) {
            return new Browser\Esribot($useragent);
        } elseif (preg_match('/QuickLook/', $useragent)) {
            return new Browser\QuickLook($useragent);
        } elseif (preg_match('/dillo/i', $useragent)) {
            return new Browser\Dillo($useragent);
        } elseif (preg_match('/Digg/', $useragent)) {
            return new Browser\DiggBot($useragent);
        } elseif (preg_match('/Zetakey/', $useragent)) {
            return new Browser\ZetakeyBrowser($useragent);
        } elseif (preg_match('/getprismatic\.com/', $useragent)) {
            return new Browser\PrismaticApp($useragent);
        } elseif (preg_match('/(FOMA|SH05C)/', $useragent)) {
            return new Browser\Sharp($useragent);
        } elseif (preg_match('/OpenWebKitSharp/', $useragent)) {
            return new Browser\OpenWebkitSharp($useragent);
        } elseif (preg_match('/AjaxSnapBot/', $useragent)) {
            return new Browser\AjaxSnapBot($useragent);
        } elseif (preg_match('/Owler/', $useragent)) {
            return new Browser\OwlerBot($useragent);
        } elseif (preg_match('/Yahoo Link Preview/', $useragent)) {
            return new Browser\YahooLinkPreview($useragent);
        } elseif (preg_match('/pub\-crawler/', $useragent)) {
            return new Browser\PubCrawler($useragent);
        } elseif (preg_match('/Kraken/', $useragent)) {
            return new Browser\Kraken($useragent);
        } elseif (preg_match('/Qwantify/', $useragent)) {
            return new Browser\Qwantify($useragent);
        } elseif (preg_match('/SetLinks bot/', $useragent)) {
            return new Browser\SetLinksCrawler($useragent);
        } elseif (preg_match('/MegaIndex\.ru/', $useragent)) {
            return new Browser\MegaIndexBot($useragent);
        } elseif (preg_match('/Cliqzbot/', $useragent)) {
            return new Browser\Cliqzbot($useragent);
        } elseif (preg_match('/DAWINCI ANTIPLAG SPIDER/', $useragent)) {
            return new Browser\DawinciAntiplagSpider($useragent);
        } elseif (preg_match('/AdvBot/', $useragent)) {
            return new Browser\AdvBot($useragent);
        } elseif (preg_match('/DuckDuckGo\-Favicons\-Bot/', $useragent)) {
            return new Browser\DuckDuckFaviconsBot($useragent);
        } elseif (preg_match('/ZyBorg/', $useragent)) {
            return new Browser\WiseNutSearchEngineCrawler($useragent);
        } elseif (preg_match('/HyperCrawl/', $useragent)) {
            return new Browser\HyperCrawl($useragent);
        } elseif (preg_match('/ARCHIVE\.ORG\.UA crawler/', $useragent)) {
            return new Browser\ArchiveOrgBot($useragent);
        } elseif (preg_match('/worldwebheritage/', $useragent)) {
            return new Browser\WorldwebheritageBot($useragent);
        } elseif (preg_match('/BegunAdvertising/', $useragent)) {
            return new Browser\BegunAdvertisingBot($useragent);
        } elseif (preg_match('/TrendWinHttp/', $useragent)) {
            return new Browser\TrendWinHttp($useragent);
        } elseif (preg_match('/(winhttp|winhttprequest)/i', $useragent)) {
            return new Browser\WinHttpRequest($useragent);
        } elseif (preg_match('/SkypeUriPreview/', $useragent)) {
            return new Browser\SkypeUriPreview($useragent);
        } elseif (preg_match('/ScoutJet/', $useragent)) {
            return new Browser\Scoutjet($useragent);
        } elseif (preg_match('/Lipperhey\-Kaus\-Australis/', $useragent)) {
            return new Browser\LipperheyKausAustralis($useragent);
        } elseif (preg_match('/Digincore bot/', $useragent)) {
            return new Browser\DigincoreBot($useragent);
        } elseif (preg_match('/Steeler/', $useragent)) {
            return new Browser\Steeler($useragent);
        } elseif (preg_match('/Orangebot/', $useragent)) {
            return new Browser\Orangebot($useragent);
        } elseif (preg_match('/Jasmine/', $useragent)) {
            return new Browser\Jasmine($useragent);
        } elseif (preg_match('/electricmonk/', $useragent)) {
            return new Browser\DueDilCrawler($useragent);
        } elseif (preg_match('/yoozBot/', $useragent)) {
            return new Browser\YoozBot($useragent);
        } elseif (preg_match('/online\-webceo\-bot/', $useragent)) {
            return new Browser\WebceoBot($useragent);
        } elseif (preg_match('/^Mozilla\/5\.0 \(.*\) Gecko\/.*\/\d+/', $useragent)
            && !preg_match('/Netscape/', $useragent)
        ) {
            return new Browser\Firefox($useragent);
        } elseif (preg_match('/^Mozilla\/5\.0 \(.*rv:\d+\.\d+.*\) Gecko\/.*\//', $useragent)
            && !preg_match('/Netscape/', $useragent)
        ) {
            return new Browser\Firefox($useragent);
        } elseif (preg_match('/Netscape/', $useragent)) {
            return new Browser\Netscape($useragent);
        } elseif (preg_match('/^Mozilla\/5\.0$/', $useragent)) {
            return new Browser\UnknownBrowser($useragent);
        } elseif (preg_match('/Virtuoso/', $useragent)) {
            return new Browser\Virtuoso($useragent);
        } elseif (preg_match('/^Mozilla\/(3|4)\.\d+/', $useragent, $matches)
            && !preg_match('/(msie|android)/i', $useragent, $matches)
        ) {
            return new Browser\Netscape($useragent);
        } elseif (preg_match('/^Dalvik\/\d/', $useragent)) {
            return new Browser\Dalvik($useragent);
        } elseif (preg_match('/niki\-bot/', $useragent)) {
            return new Browser\NikiBot($useragent);
        } elseif (preg_match('/ContextAd Bot/', $useragent)) {
            return new Browser\ContextadBot($useragent);
        } elseif (preg_match('/integrity/', $useragent)) {
            return new Browser\Integrity($useragent);
        } elseif (preg_match('/masscan/', $useragent)) {
            return new Browser\DownloadAccelerator($useragent);
        } elseif (preg_match('/ZmEu/', $useragent)) {
            return new Browser\ZmEu($useragent);
        } elseif (preg_match('/sogou web spider/i', $useragent)) {
            return new Browser\SogouWebSpider($useragent);
        } elseif (preg_match('/(OpenWave|UP\.Browser|UP\/)/', $useragent)) {
            return new Browser\Openwave($useragent);
        } elseif (preg_match('/(ObigoInternetBrowser|obigo\-browser|Obigo|Teleca)(\/|-)Q(\d+)/', $useragent)) {
            return new Browser\ObigoQ($useragent);
        } elseif (preg_match('/(Teleca|Obigo|MIC\/|AU\-MIC)/', $useragent)) {
            return new Browser\TelecaObigo($useragent);
        } elseif (preg_match('/DavClnt/', $useragent)) {
            return new Browser\MicrosoftWebDav($useragent);
        } elseif (preg_match('/XING\-contenttabreceiver/', $useragent)) {
            return new Browser\XingContenttabreceiver($useragent);
        } elseif (preg_match('/Slingstone/', $useragent)) {
            return new Browser\YahooSlingstone($useragent);
        } elseif (preg_match('/BOT for JCE/', $useragent)) {
            return new Browser\BotForJce($useragent);
        } elseif (preg_match('/Validator\.nu\/LV/', $useragent)) {
            return new Browser\W3cValidatorNuLv($useragent);
        } elseif (preg_match('/Curb/', $useragent)) {
            return new Browser\Curb($useragent);
        } elseif (preg_match('/link_thumbnailer/', $useragent)) {
            return new Browser\LinkThumbnailer($useragent);
        } elseif (preg_match('/Ruby/', $useragent)) {
            return new Browser\Ruby($useragent);
        } elseif (preg_match('/securepoint cf/', $useragent)) {
            return new Browser\SecurepointContentFilter($useragent);
        } elseif (preg_match('/sogou\-spider/i', $useragent)) {
            return new Browser\SogouSpider($useragent);
        } elseif (preg_match('/rankflex/i', $useragent)) {
            return new Browser\RankFlex($useragent);
        } elseif (preg_match('/domnutch/i', $useragent)) {
            return new Browser\Domnutch($useragent);
        } elseif (preg_match('/discovered/i', $useragent)) {
            return new Browser\DiscoverEd($useragent);
        } elseif (preg_match('/nutch/i', $useragent)) {
            return new Browser\Nutch($useragent);
        } elseif (preg_match('/boardreader favicon fetcher/i', $useragent)) {
            return new Browser\BoardReaderFaviconFetcher($useragent);
        } elseif (preg_match('/checksite verification agent/i', $useragent)) {
            return new Browser\CheckSiteVerificationAgent($useragent);
        } elseif (preg_match('/experibot/i', $useragent)) {
            return new Browser\Experibot($useragent);
        } elseif (preg_match('/feedblitz/i', $useragent)) {
            return new Browser\FeedBlitz($useragent);
        } elseif (preg_match('/rss2html/i', $useragent)) {
            return new Browser\Rss2Html($useragent);
        } elseif (preg_match('/feedlyapp/i', $useragent)) {
            return new Browser\FeedlyApp($useragent);
        } elseif (preg_match('/genderanalyzer/i', $useragent)) {
            return new Browser\Genderanalyzer($useragent);
        } elseif (preg_match('/gooblog/i', $useragent)) {
            return new Browser\GooBlog($useragent);
        } elseif (preg_match('/tumblr/i', $useragent)) {
            return new Browser\TumblrApp($useragent);
        } elseif (preg_match('/w3c\_i18n\-checker/i', $useragent)) {
            return new Browser\W3cI18nChecker($useragent);
        } elseif (preg_match('/w3c\_unicorn/i', $useragent)) {
            return new Browser\W3cUnicorn($useragent);
        } elseif (preg_match('/alltop/i', $useragent)) {
            return new Browser\AlltopApp($useragent);
        } elseif (preg_match('/internetseer/i', $useragent)) {
            return new Browser\InternetSeer($useragent);
        } elseif (preg_match('/ADmantX Platform Semantic Analyzer/', $useragent)) {
            return new Browser\AdmantxPlatformSemanticAnalyzer($useragent);
        } elseif (preg_match('/UniversalFeedParser/', $useragent)) {
            return new Browser\UniversalFeedParser($useragent);
        } elseif (preg_match('/(binlar|larbin)/i', $useragent)) {
            return new Browser\Larbin($useragent);
        } elseif (preg_match('/unityplayer/i', $useragent)) {
            return new Browser\UnityWebPlayer($useragent);
        } elseif (preg_match('/WeSEE\:Search/', $useragent)) {
            return new Browser\WeseeSearch($useragent);
        } elseif (preg_match('/WeSEE\:Ads/', $useragent)) {
            return new Browser\WeseeAds($useragent);
        } elseif (preg_match('/A6\-Indexer/', $useragent)) {
            return new Browser\A6Indexer($useragent);
        } elseif (preg_match('/NerdyBot/', $useragent)) {
            return new Browser\NerdyBot($useragent);
        } elseif (preg_match('/Peeplo Screenshot Bot/', $useragent)) {
            return new Browser\PeeploScreenshotBot($useragent);
        } elseif (preg_match('/CCBot/', $useragent)) {
            return new Browser\CcBot($useragent);
        } elseif (preg_match('/visionutils/', $useragent)) {
            return new Browser\VisionUtils($useragent);
        } elseif (preg_match('/Feedly/', $useragent)) {
            return new Browser\Feedly($useragent);
        } elseif (preg_match('/Photon/', $useragent)) {
            return new Browser\Photon($useragent);
        } elseif (preg_match('/WDG\_Validator/', $useragent)) {
            return new Browser\WdgHtmlValidator($useragent);
        } elseif (preg_match('/Aboundex/', $useragent)) {
            return new Browser\Aboundexbot($useragent);
        } elseif (preg_match('/YisouSpider/', $useragent)) {
            return new Browser\YisouSpider($useragent);
        } elseif (preg_match('/hivaBot/', $useragent)) {
            return new Browser\HivaBot($useragent);
        } elseif (preg_match('/Comodo Spider/', $useragent)) {
            return new Browser\ComodoSpider($useragent);
        } elseif (preg_match('/OpenWebSpider/i', $useragent)) {
            return new Browser\OpenWebSpider($useragent);
        } elseif (preg_match('/R6_CommentReader/i', $useragent)) {
            return new Browser\R6CommentReader($useragent);
        } elseif (preg_match('/R6_FeedFetcher/i', $useragent)) {
            return new Browser\R6Feedfetcher($useragent);
        } elseif (preg_match('/(psbot\-image|psbot\-page)/i', $useragent)) {
            return new Browser\Picsearchbot($useragent);
        } elseif (preg_match('/Bloglovin/', $useragent)) {
            return new Browser\BloglovinBot($useragent);
        } elseif (preg_match('/viralvideochart/i', $useragent)) {
            return new Browser\ViralvideochartBot($useragent);
        } elseif (preg_match('/MetaHeadersBot/', $useragent)) {
            return new Browser\MetaHeadersBot($useragent);
        } elseif (preg_match('/Zend\_Http\_Client/', $useragent)) {
            return new Browser\ZendHttpClient($useragent);
        } elseif (preg_match('/wget/i', $useragent)) {
            return new Browser\Wget($useragent);
        } elseif (preg_match('/Scrapy/', $useragent)) {
            return new Browser\ScrapyBot($useragent);
        } elseif (preg_match('/Moozilla/', $useragent)) {
            return new Browser\Moozilla($useragent);
        } elseif (preg_match('/AntBot/', $useragent)) {
            return new Browser\AntBot($useragent);
        } elseif (preg_match('/Browsershots/', $useragent)) {
            return new Browser\Browsershots($useragent);
        } elseif (preg_match('/revolt/', $useragent)) {
            return new Browser\BotRevolt($useragent);
        } elseif (preg_match('/pdrlabs/i', $useragent)) {
            return new Browser\PdrlabsBot($useragent);
        } elseif (preg_match('/elinks/i', $useragent)) {
            return new Browser\Elinks($useragent);
        } elseif (preg_match('/Links/', $useragent)) {
            return new Browser\Links($useragent);
        } elseif (preg_match('/Airmail/', $useragent)) {
            return new Browser\Airmail($useragent);
        } elseif (preg_match('/SonyEricsson/', $useragent)) {
            return new Browser\SonyEricsson($useragent);
        } elseif (preg_match('/WEB\.DE MailCheck/', $useragent)) {
            return new Browser\WebdeMailCheck($useragent);
        } elseif (preg_match('/Screaming Frog SEO Spider/', $useragent)) {
            return new Browser\ScreamingFrogSeoSpider($useragent);
        } elseif (preg_match('/AndroidDownloadManager/', $useragent)) {
            return new Browser\AndroidDownloadManager($useragent);
        } elseif (preg_match('/Go ([\d\.]+) package http/', $useragent)) {
            return new Browser\GoHttpClient($useragent);
        } elseif (preg_match('/Go-http-client/', $useragent)) {
            return new Browser\GoHttpClient($useragent);
        } elseif (preg_match('/Proxy Gear Pro/', $useragent)) {
            return new Browser\ProxyGearPro($useragent);
        } elseif (preg_match('/WAP Browser\/MAUI/', $useragent)) {
            return new Browser\MauiWapBrowser($useragent);
        } elseif (preg_match('/Tiny Tiny RSS/', $useragent)) {
            return new Browser\TinyTinyRss($useragent);
        } elseif (preg_match('/Readability/', $useragent)) {
            return new Browser\Readability($useragent);
        } elseif (preg_match('/NSPlayer/', $useragent)) {
            return new Browser\WindowsMediaPlayer($useragent);
        } elseif (preg_match('/Pingdom/', $useragent)) {
            return new Browser\Pingdom($useragent);
        } elseif (preg_match('/crazywebcrawler/i', $useragent)) {
            return new Browser\Crazywebcrawler($useragent);
        } elseif (preg_match('/GG PeekBot/', $useragent)) {
            return new Browser\GgPeekBot($useragent);
        } elseif (preg_match('/iTunes/', $useragent)) {
            return new Browser\Itunes($useragent);
        } elseif (preg_match('/LibreOffice/', $useragent)) {
            return new Browser\LibreOffice($useragent);
        } elseif (preg_match('/OpenOffice/', $useragent)) {
            return new Browser\OpenOffice($useragent);
        } elseif (preg_match('/ThumbnailAgent/', $useragent)) {
            return new Browser\ThumbnailAgent($useragent);
        } elseif (preg_match('/LinkStats Bot/', $useragent)) {
            return new Browser\LinkStatsBot($useragent);
        } elseif (preg_match('/eZ Publish Link Validator/', $useragent)) {
            return new Browser\EzPublishLinkValidator($useragent);
        } elseif (preg_match('/ThumbSniper/', $useragent)) {
            return new Browser\ThumbSniper($useragent);
        } elseif (preg_match('/stq\_bot/', $useragent)) {
            return new Browser\SearchteqBot($useragent);
        } elseif (preg_match('/SNK Screenshot Bot/', $useragent)) {
            return new Browser\SnkScreenshotBot($useragent);
        } elseif (preg_match('/SynHttpClient/', $useragent)) {
            return new Browser\SynHttpClient($useragent);
        } elseif (preg_match('/HTTPClient/', $useragent)) {
            return new Browser\HttpClient($useragent);
        } elseif (preg_match('/T\-Online Browser/', $useragent)) {
            return new Browser\TonlineBrowser($useragent);
        } elseif (preg_match('/ImplisenseBot/', $useragent)) {
            return new Browser\ImplisenseBot($useragent);
        } elseif (preg_match('/BuiBui\-Bot/', $useragent)) {
            return new Browser\BuiBuiBot($useragent);
        } elseif (preg_match('/thumbshots\-de\-bot/', $useragent)) {
            return new Browser\ThumbShotsDeBot($useragent);
        } elseif (preg_match('/python\-requests/', $useragent)) {
            return new Browser\PythonRequests($useragent);
        } elseif (preg_match('/Python\-urllib/', $useragent)) {
            return new Browser\PythonUrlLib($useragent);
        } elseif (preg_match('/Bot\.AraTurka\.com/', $useragent)) {
            return new Browser\BotAraTurka($useragent);
        } elseif (preg_match('/http\_requester/', $useragent)) {
            return new Browser\HttpRequester($useragent);
        } elseif (preg_match('/WhatWeb/', $useragent)) {
            return new Browser\WhatWebWebScanner($useragent);
        } elseif (preg_match('/isc header collector handlers/', $useragent)) {
            return new Browser\IscHeaderCollectorHandlers($useragent);
        } elseif (preg_match('/Thumbor/', $useragent)) {
            return new Browser\Thumbor($useragent);
        } elseif (preg_match('/Forum Poster/', $useragent)) {
            return new Browser\ForumPoster($useragent);
        } elseif (preg_match('/crawler4j/', $useragent)) {
            return new Browser\Crawler4j($useragent);
        } elseif (preg_match('/Facebot/', $useragent)) {
            return new Browser\FaceBot($useragent);
        } elseif (preg_match('/NetzCheckBot/', $useragent)) {
            return new Browser\NetzCheckBot($useragent);
        } elseif (preg_match('/MIB/', $useragent)) {
            return new Browser\MotorolaInternetBrowser($useragent);
        } elseif (preg_match('/facebookscraper/', $useragent)) {
            return new Browser\Facebookscraper($useragent);
        } elseif (preg_match('/Zookabot/', $useragent)) {
            return new Browser\Zookabot($useragent);
        } elseif (preg_match('/MetaURI/', $useragent)) {
            return new Browser\MetaUri($useragent);
        } elseif (preg_match('/FreeWebMonitoring SiteChecker/', $useragent)) {
            return new Browser\FreeWebMonitoringSiteChecker($useragent);
        } elseif (preg_match('/IPv4Scan/', $useragent)) {
            return new Browser\Ipv4Scan($useragent);
        } elseif (preg_match('/RED/', $useragent)) {
            return new Browser\Redbot($useragent);
        } elseif (preg_match('/domainsbot/', $useragent)) {
            return new Browser\DomainsBot($useragent);
        } elseif (preg_match('/BUbiNG/', $useragent)) {
            return new Browser\Bubing($useragent);
        } elseif (preg_match('/RamblerMail/', $useragent)) {
            return new Browser\RamblerMail($useragent);
        } elseif (preg_match('/ichiro\/mobile/', $useragent)) {
            return new Browser\IchiroMobileBot($useragent);
        } elseif (preg_match('/ichiro/', $useragent)) {
            return new Browser\IchiroBot($useragent);
        } elseif (preg_match('/iisbot/', $useragent)) {
            return new Browser\IisBot($useragent);
        } elseif (preg_match('/JoobleBot/', $useragent)) {
            return new Browser\JoobleBot($useragent);
        } elseif (preg_match('/Superfeedr bot/', $useragent)) {
            return new Browser\SuperfeedrBot($useragent);
        } elseif (preg_match('/FeedBurner/', $useragent)) {
            return new Browser\FeedBurner($useragent);
        } elseif (preg_match('/Fastladder/', $useragent)) {
            return new Browser\FastladderFeedFetcher($useragent);
        } elseif (preg_match('/livedoor/', $useragent)) {
            return new Browser\LivedoorFeedFetcher($useragent);
        } elseif (preg_match('/Icarus6j/', $useragent)) {
            return new Browser\Icarus6j($useragent);
        } elseif (preg_match('/wsr\-agent/', $useragent)) {
            return new Browser\WsrAgent($useragent);
        } elseif (preg_match('/Blogshares Spiders/', $useragent)) {
            return new Browser\BlogsharesSpiders($useragent);
        } elseif (preg_match('/TinEye\-bot/', $useragent)) {
            return new Browser\TinEyeBot($useragent);
        } elseif (preg_match('/QuickiWiki/', $useragent)) {
            return new Browser\QuickiWikiBot($useragent);
        } elseif (preg_match('/PycURL/', $useragent)) {
            return new Browser\PyCurl($useragent);
        } elseif (preg_match('/libcurl\-agent/', $useragent)) {
            return new Browser\Libcurl($useragent);
        } elseif (preg_match('/Taproot/', $useragent)) {
            return new Browser\TaprootBot($useragent);
        } elseif (preg_match('/GuzzleHttp/', $useragent)) {
            return new Browser\GuzzleHttpClient($useragent);
        } elseif (preg_match('/curl/i', $useragent)) {
            return new Browser\Curl($useragent);
        } elseif (preg_match('/^PHP/', $useragent)) {
            return new Browser\Php($useragent);
        } elseif (preg_match('/Apple\-PubSub/', $useragent)) {
            return new Browser\ApplePubSub($useragent);
        } elseif (preg_match('/SimplePie/', $useragent)) {
            return new Browser\SimplePie($useragent);
        } elseif (preg_match('/BigBozz/', $useragent)) {
            return new Browser\BigBozz($useragent);
        } elseif (preg_match('/ECCP/', $useragent)) {
            return new Browser\Eccp($useragent);
        } elseif (preg_match('/facebookexternalhit/', $useragent)) {
            return new Browser\FacebookExternalHit($useragent);
        } elseif (preg_match('/GigablastOpenSource/', $useragent)) {
            return new Browser\GigablastOpenSource($useragent);
        } elseif (preg_match('/WebIndex/', $useragent)) {
            return new Browser\WebIndex($useragent);
        } elseif (preg_match('/Prince/', $useragent)) {
            return new Browser\Prince($useragent);
        } elseif (preg_match('/adsense\-snapshot\-google/i', $useragent)) {
            return new Browser\GoogleAdsenseSnapshot($useragent);
        } elseif (preg_match('/Amazon CloudFront/', $useragent)) {
            return new Browser\AmazonCloudFront($useragent);
        } elseif (preg_match('/bandscraper/', $useragent)) {
            return new Browser\Bandscraper($useragent);
        } elseif (preg_match('/bitlybot/', $useragent)) {
            return new Browser\BitlyBot($useragent);
        } elseif (preg_match('/^bot$/', $useragent)) {
            return new Browser\BotBot($useragent);
        } elseif (preg_match('/cars\-app\-browser/', $useragent)) {
            return new Browser\CarsAppBrowser($useragent);
        } elseif (preg_match('/Coursera\-Mobile/', $useragent)) {
            return new Browser\CourseraMobileApp($useragent);
        } elseif (preg_match('/Crowsnest/', $useragent)) {
            return new Browser\CrowsnestMobileApp($useragent);
        } elseif (preg_match('/Dorado WAP\-Browser/', $useragent)) {
            return new Browser\DoradoWapBrowser($useragent);
        } elseif (preg_match('/Goldfire Server/', $useragent)) {
            return new Browser\GoldfireServer($useragent);
        } elseif (preg_match('/EventMachine HttpClient/', $useragent)) {
            return new Browser\EventMachineHttpClient($useragent);
        } elseif (preg_match('/iBall/', $useragent)) {
            return new Browser\Iball($useragent);
        } elseif (preg_match('/InAGist URL Resolver/', $useragent)) {
            return new Browser\InagistUrlResolver($useragent);
        } elseif (preg_match('/Jeode/', $useragent)) {
            return new Browser\Jeode($useragent);
        } elseif (preg_match('/kraken/', $useragent)) {
            return new Browser\Krakenjs($useragent);
        } elseif (preg_match('/com\.linkedin/', $useragent)) {
            return new Browser\LinkedInBot($useragent);
        } elseif (preg_match('/LivelapBot/', $useragent)) {
            return new Browser\LivelapBot($useragent);
        } elseif (preg_match('/MixBot/', $useragent)) {
            return new Browser\MixBot($useragent);
        } elseif (preg_match('/BuSecurityProject/', $useragent)) {
            return new Browser\BuSecurityProject($useragent);
        } elseif (preg_match('/PageFreezer/', $useragent)) {
            return new Browser\PageFreezer($useragent);
        } elseif (preg_match('/restify/', $useragent)) {
            return new Browser\Restify($useragent);
        } elseif (preg_match('/ShowyouBot/', $useragent)) {
            return new Browser\ShowyouBot($useragent);
        } elseif (preg_match('/vlc/i', $useragent)) {
            return new Browser\VlcMediaPlayer($useragent);
        } elseif (preg_match('/WebRingChecker/', $useragent)) {
            return new Browser\WebRingChecker($useragent);
        } elseif (preg_match('/bot\-pge\.chlooe\.com/', $useragent)) {
            return new Browser\ChlooeBot($useragent);
        } elseif (preg_match('/seebot/', $useragent)) {
            return new Browser\SeeBot($useragent);
        } elseif (preg_match('/ltx71/', $useragent)) {
            return new Browser\Ltx71($useragent);
        } elseif (preg_match('/CookieReports/', $useragent)) {
            return new Browser\CookieReportsBot($useragent);
        } elseif (preg_match('/Elmer/', $useragent)) {
            return new Browser\Elmer($useragent);
        } elseif (preg_match('/Iframely/', $useragent)) {
            return new Browser\IframelyBot($useragent);
        } elseif (preg_match('/MetaInspector/', $useragent)) {
            return new Browser\MetaInspector($useragent);
        } elseif (preg_match('/Microsoft\-CryptoAPI/', $useragent)) {
            return new Browser\MicrosoftCryptoApi($useragent);
        } elseif (preg_match('/OWASP\_SECRET\_BROWSER/', $useragent)) {
            return new Browser\OwaspSecretBrowser($useragent);
        } elseif (preg_match('/SMRF URL Expander/', $useragent)) {
            return new Browser\SmrfUrlExpander($useragent);
        } elseif (preg_match('/Speedy Spider/', $useragent)) {
            return new Browser\Entireweb($useragent);
        } elseif (preg_match('/kizasi\-spider/', $useragent)) {
            return new Browser\Kizasispider($useragent);
        } elseif (preg_match('/Superarama\.com \- BOT/', $useragent)) {
            return new Browser\SuperaramaComBot($useragent);
        } elseif (preg_match('/WNMbot/', $useragent)) {
            return new Browser\Wnmbot($useragent);
        } elseif (preg_match('/Website Explorer/', $useragent)) {
            return new Browser\WebsiteExplorer($useragent);
        } elseif (preg_match('/city\-map screenshot service/', $useragent)) {
            return new Browser\CitymapScreenshotService($useragent);
        } elseif (preg_match('/gosquared\-thumbnailer/', $useragent)) {
            return new Browser\GosquaredThumbnailer($useragent);
        } elseif (preg_match('/optivo\(R\) NetHelper/', $useragent)) {
            return new Browser\OptivoNetHelper($useragent);
        } elseif (preg_match('/pr\-cy\.ru Screenshot Bot/', $useragent)) {
            return new Browser\ScreenshotBot($useragent);
        } elseif (preg_match('/Cyberduck/', $useragent)) {
            return new Browser\Cyberduck($useragent);
        } elseif (preg_match('/Lynx/', $useragent)) {
            return new Browser\Lynx($useragent);
        } elseif (preg_match('/AccServer/', $useragent)) {
            return new Browser\AccServer($useragent);
        } elseif (preg_match('/SafeSearch microdata crawler/', $useragent)) {
            return new Browser\SafeSearchMicrodataCrawler($useragent);
        } elseif (preg_match('/iZSearch/', $useragent)) {
            return new Browser\IzSearchBot($useragent);
        } elseif (preg_match('/NetLyzer FastProbe/', $useragent)) {
            return new Browser\NetLyzerFastProbe($useragent);
        } elseif (preg_match('/MnoGoSearch/', $useragent)) {
            return new Browser\MnogoSearch($useragent);
        } elseif (preg_match('/uipbot/', $useragent)) {
            return new Browser\Uipbot($useragent);
        } elseif (preg_match('/mbot/', $useragent)) {
            return new Browser\Mbot($useragent);
        } elseif (preg_match('/MS Web Services Client Protocol/', $useragent)) {
            return new Browser\MicrosoftDotNetFrameworkClr($useragent);
        } elseif (preg_match('/(AtomicBrowser|AtomicLite)/', $useragent)) {
            return new Browser\AtomicBrowser($useragent);
        } elseif (preg_match('/AppEngine\-Google/', $useragent)) {
            return new Browser\GoogleAppEngine($useragent);
        } elseif (preg_match('/Feedfetcher\-Google/', $useragent)) {
            return new Browser\GoogleFeedfetcher($useragent);
        } elseif (preg_match('/Google/', $useragent)) {
            return new Browser\GoogleApp($useragent);
        } elseif (preg_match('/UnwindFetchor/', $useragent)) {
            return new Browser\UnwindFetchor($useragent);
        } elseif (preg_match('/Perfect%20Browser/', $useragent)) {
            return new Browser\PerfectBrowser($useragent);
        } elseif (preg_match('/Reeder/', $useragent)) {
            return new Browser\Reeder($useragent);
        } elseif (preg_match('/FastBrowser/', $useragent)) {
            return new Browser\FastBrowser($useragent);
        } elseif (preg_match('/CFNetwork/', $useragent)) {
            return new Browser\CfNetwork($useragent);
        } elseif (preg_match('/Y\!J\-(ASR|BSC)/', $useragent)) {
            return new Browser\YahooJapan($useragent);
        } elseif (preg_match('/test certificate info/', $useragent)) {
            return new Browser\TestCertificateInfo($useragent);
        } elseif (preg_match('/fastbot crawler/', $useragent)) {
            return new Browser\FastbotCrawler($useragent);
        } elseif (preg_match('/Riddler/', $useragent)) {
            return new Browser\Riddler($useragent);
        } elseif (preg_match('/SophosUpdateManager/', $useragent)) {
            return new Browser\SophosUpdateManager($useragent);
        } elseif (preg_match('/(Debian|Ubuntu) APT\-HTTP/', $useragent)) {
            return new Browser\AptHttpTransport($useragent);
        } elseif (preg_match('/urlgrabber/', $useragent)) {
            return new Browser\UrlGrabber($useragent);
        } elseif (preg_match('/UCS \(ESX\)/', $useragent)) {
            return new Browser\UniventionCorporateServer($useragent);
        } elseif (preg_match('/libwww\-perl/', $useragent)) {
            return new Browser\Libwww($useragent);
        } elseif (preg_match('/OpenBSD ftp/', $useragent)) {
            return new Browser\OpenBsdFtp($useragent);
        } elseif (preg_match('/SophosAgent/', $useragent)) {
            return new Browser\SophosAgent($useragent);
        } elseif (preg_match('/jupdate/', $useragent)) {
            return new Browser\Jupdate($useragent);
        } elseif (preg_match('/Roku\/DVP/', $useragent)) {
            return new Browser\RokuDvp($useragent);
        } elseif (preg_match('/VocusBot/', $useragent)) {
            return new Browser\VocusBot($useragent);
        } elseif (preg_match('/PostRank/', $useragent)) {
            return new Browser\PostRank($useragent);
        } elseif (preg_match('/rogerbot/i', $useragent)) {
            return new Browser\Rogerbot($useragent);
        } elseif (preg_match('/Safeassign/', $useragent)) {
            return new Browser\Safeassign($useragent);
        } elseif (preg_match('/ExaleadCloudView/', $useragent)) {
            return new Browser\ExaleadCloudView($useragent);
        } elseif (preg_match('/Typhoeus/', $useragent)) {
            return new Browser\Typhoeus($useragent);
        } elseif (preg_match('/Camo Asset Proxy/', $useragent)) {
            return new Browser\CamoAssetProxy($useragent);
        } elseif (preg_match('/YahooCacheSystem/', $useragent)) {
            return new Browser\YahooCacheSystem($useragent);
        } elseif (preg_match('/wmtips\.com/', $useragent)) {
            return new Browser\WebmasterTipsBot($useragent);
        } elseif (preg_match('/linkCheck/', $useragent)) {
            return new Browser\LinkCheck($useragent);
        } elseif (preg_match('/ABrowse/', $useragent)) {
            return new Browser\Abrowse($useragent);
        } elseif (preg_match('/GWPImages/', $useragent)) {
            return new Browser\GwpImages($useragent);
        } elseif (preg_match('/NoteTextView/', $useragent)) {
            return new Browser\NoteTextView($useragent);
        } elseif (preg_match('/NING/', $useragent)) {
            return new Browser\Ning($useragent);
        } elseif (preg_match('/Sprinklr/', $useragent)) {
            return new Browser\SprinklrBot($useragent);
        } elseif (preg_match('/URLChecker/', $useragent)) {
            return new Browser\UrlChecker($useragent);
        } elseif (preg_match('/newsme/', $useragent)) {
            return new Browser\NewsMe($useragent);
        } elseif (preg_match('/Traackr/', $useragent)) {
            return new Browser\Traackr($useragent);
        } elseif (preg_match('/nineconnections/', $useragent)) {
            return new Browser\NineConnections($useragent);
        } elseif (preg_match('/Xenu Link Sleuth/', $useragent)) {
            return new Browser\XenusLinkSleuth($useragent);
        } elseif (preg_match('/superagent/', $useragent)) {
            return new Browser\Superagent($useragent);
        } elseif (preg_match('/Goose/', $useragent)) {
            return new Browser\GooseExtractor($useragent);
        } elseif (preg_match('/AHC/', $useragent)) {
            return new Browser\AsynchronousHttpClient($useragent);
        } elseif (preg_match('/newspaper/', $useragent)) {
            return new Browser\Newspaper($useragent);
        } elseif (preg_match('/Hatena::Bookmark/', $useragent)) {
            return new Browser\HatenaBookmark($useragent);
        } elseif (preg_match('/EasyBib AutoCite/', $useragent)) {
            return new Browser\EasyBibAutoCite($useragent);
        } elseif (preg_match('/ShortLinkTranslate/', $useragent)) {
            return new Browser\ShortLinkTranslate($useragent);
        } elseif (preg_match('/Marketing Grader/', $useragent)) {
            return new Browser\MarketingGrader($useragent);
        } elseif (preg_match('/Grammarly/', $useragent)) {
            return new Browser\Grammarly($useragent);
        } elseif (preg_match('/Dispatch/', $useragent)) {
            return new Browser\Dispatch($useragent);
        } elseif (preg_match('/Raven Link Checker/', $useragent)) {
            return new Browser\RavenLinkChecker($useragent);
        } elseif (preg_match('/http\-kit/', $useragent)) {
            return new Browser\HttpKit($useragent);
        } elseif (preg_match('/sfFeedReader/', $useragent)) {
            return new Browser\SymfonyRssReader($useragent);
        } elseif (preg_match('/Twikle/', $useragent)) {
            return new Browser\TwikleBot($useragent);
        } elseif (preg_match('/node\-fetch/', $useragent)) {
            return new Browser\NodeFetch($useragent);
        } elseif (preg_match('/BrokenLinkCheck\.com/', $useragent)) {
            return new Browser\BrokenLinkCheck($useragent);
        } elseif (preg_match('/BCKLINKS/', $useragent)) {
            return new Browser\BckLinks($useragent);
        } elseif (preg_match('/Faraday/', $useragent)) {
            return new Browser\Faraday($useragent);
        } elseif (preg_match('/gettor/', $useragent)) {
            return new Browser\Gettor($useragent);
        } elseif (preg_match('/SEOstats/', $useragent)) {
            return new Browser\SeoStats($useragent);
        } elseif (preg_match('/ZnajdzFoto\/Image/', $useragent)) {
            return new Browser\ZnajdzFotoImageBot($useragent);
        } elseif (preg_match('/infoX\-WISG/', $useragent)) {
            return new Browser\InfoxWisg($useragent);
        } elseif (preg_match('/wscheck\.com/', $useragent)) {
            return new Browser\WscheckBot($useragent);
        } elseif (preg_match('/Tweetminster/', $useragent)) {
            return new Browser\TweetminsterBot($useragent);
        } elseif (preg_match('/Astute SRM/', $useragent)) {
            return new Browser\AstuteSocial($useragent);
        } elseif (preg_match('/LongURL API/', $useragent)) {
            return new Browser\LongUrlBot($useragent);
        } elseif (preg_match('/Trove/', $useragent)) {
            return new Browser\TroveBot($useragent);
        } elseif (preg_match('/Melvil Favicon/', $useragent)) {
            return new Browser\MelvilFaviconBot($useragent);
        } elseif (preg_match('/Melvil/', $useragent)) {
            return new Browser\MelvilBot($useragent);
        } elseif (preg_match('/Pearltrees/', $useragent)) {
            return new Browser\PearltreesBot($useragent);
        } elseif (preg_match('/Svven\-Summarizer/', $useragent)) {
            return new Browser\SvvenSummarizerBot($useragent);
        } elseif (preg_match('/Athena Site Analyzer/', $useragent)) {
            return new Browser\AthenaSiteAnalyzer($useragent);
        } elseif (preg_match('/Exploratodo/', $useragent)) {
            return new Browser\ExploratodoBot($useragent);
        } elseif (preg_match('/WhatsApp/', $useragent)) {
            return new Browser\WhatsApp($useragent);
        } elseif (preg_match('/DDG\-Android\-/', $useragent)) {
            return new Browser\DuckDuckApp($useragent);
        } elseif (preg_match('/WebCorp/', $useragent)) {
            return new Browser\WebCorp($useragent);
        } elseif (preg_match('/ROR Sitemap Generator/', $useragent)) {
            return new Browser\RorSitemapGenerator($useragent);
        } elseif (preg_match('/AuditMyPC Webmaster Tool/', $useragent)) {
            return new Browser\AuditmypcWebmasterTool($useragent);
        } elseif (preg_match('/XmlSitemapGenerator/', $useragent)) {
            return new Browser\XmlSitemapGenerator($useragent);
        } elseif (preg_match('/Stratagems Kumo/', $useragent)) {
            return new Browser\StratagemsKumo($useragent);
        } elseif (preg_match('/YOURLS/', $useragent)) {
            return new Browser\Yourls($useragent);
        } elseif (preg_match('/Embed PHP Library/', $useragent)) {
            return new Browser\EmbedPhpLibrary($useragent);
        } elseif (preg_match('/SPIP/', $useragent)) {
            return new Browser\Spip($useragent);
        } elseif (preg_match('/Friendica/', $useragent)) {
            return new Browser\Friendica($useragent);
        } elseif (preg_match('/MagpieRSS/', $useragent)) {
            return new Browser\MagpieRss($useragent);
        } elseif (preg_match('/Short URL Checker/', $useragent)) {
            return new Browser\ShortUrlChecker($useragent);
        } elseif (preg_match('/webnumbrFetcher/', $useragent)) {
            return new Browser\WebnumbrFetcher($useragent);
        } elseif (preg_match('/(WAP Browser|Spice QT\-75|KKT20\/MIDP)/', $useragent)) {
            return new Browser\WapBrowser($useragent);
        } elseif (preg_match('/java/i', $useragent)) {
            return new Browser\JavaStandardLibrary($useragent);
        } elseif (preg_match('/(unister\-test|unistertesting|unister\-https\-test)/i', $useragent)) {
            return new Browser\UnisterTesting($useragent);
        } elseif (preg_match('/AdMuncher/', $useragent)) {
            return new Browser\AdMuncher($useragent);
        } elseif (preg_match('/AdvancedEmailExtractor/', $useragent)) {
            return new Browser\AdvancedEmailExtractor($useragent);
        } elseif (preg_match('/AiHitBot/', $useragent)) {
            return new Browser\AiHitBot($useragent);
        } elseif (preg_match('/Alcatel/', $useragent)) {
            return new Browser\Alcatel($useragent);
        } elseif (preg_match('/AlcoholSearch/', $useragent)) {
            return new Browser\AlcoholSearch($useragent);
        } elseif (preg_match('/ApacheHttpClient/', $useragent)) {
            return new Browser\ApacheHttpClient($useragent);
        } elseif (preg_match('/ArchiveDeBot/', $useragent)) {
            return new Browser\ArchiveDeBot($useragent);
        } elseif (preg_match('/Argclrint/', $useragent)) {
            return new Browser\Argclrint($useragent);
        } elseif (preg_match('/AskBot/', $useragent)) {
            return new Browser\AskBot($useragent);
        } elseif (preg_match('/AugustBot/', $useragent)) {
            return new Browser\AugustBot($useragent);
        } elseif (preg_match('/Awesomebot/', $useragent)) {
            return new Browser\Awesomebot($useragent);
        } elseif (preg_match('/BaiduSpider/', $useragent)) {
            return new Browser\BaiduSpider($useragent);
        } elseif (preg_match('/Benq/', $useragent)) {
            return new Browser\Benq($useragent);
        } elseif (preg_match('/Billigfluegefinal/', $useragent)) {
            return new Browser\Billigfluegefinal($useragent);
        } elseif (preg_match('/BingProductsBot/', $useragent)) {
            return new Browser\BingProductsBot($useragent);
        } elseif (preg_match('/BlackberryPlaybookTablet/', $useragent)) {
            return new Browser\BlackberryPlaybookTablet($useragent);
        } elseif (preg_match('/BlitzBot/', $useragent)) {
            return new Browser\BlitzBot($useragent);
        } elseif (preg_match('/BluecoatDrtr/', $useragent)) {
            return new Browser\BluecoatDrtr($useragent);
        } elseif (preg_match('/BndCrawler/', $useragent)) {
            return new Browser\BndCrawler($useragent);
        } elseif (preg_match('/BoardReader/', $useragent)) {
            return new Browser\BoardReader($useragent);
        } elseif (preg_match('/Boxee/', $useragent)) {
            return new Browser\Boxee($useragent);
        } elseif (preg_match('/Browser360/', $useragent)) {
            return new Browser\Browser360($useragent);
        } elseif (preg_match('/Bwc/', $useragent)) {
            return new Browser\Bwc($useragent);
        } elseif (preg_match('/Camcrawler/', $useragent)) {
            return new Browser\Camcrawler($useragent);
        } elseif (preg_match('/CamelHttpStream/', $useragent)) {
            return new Browser\CamelHttpStream($useragent);
        } elseif (preg_match('/Charlotte/', $useragent)) {
            return new Browser\Charlotte($useragent);
        } elseif (preg_match('/CheckLinks/', $useragent)) {
            return new Browser\CheckLinks($useragent);
        } elseif (preg_match('/Choosy/', $useragent)) {
            return new Browser\Choosy($useragent);
        } elseif (preg_match('/ClarityDailyBot/', $useragent)) {
            return new Browser\ClarityDailyBot($useragent);
        } elseif (preg_match('/Clipish/', $useragent)) {
            return new Browser\Clipish($useragent);
        } elseif (preg_match('/CloudSurfer/', $useragent)) {
            return new Browser\CloudSurfer($useragent);
        } elseif (preg_match('/CommonCrawl/', $useragent)) {
            return new Browser\CommonCrawl($useragent);
        } elseif (preg_match('/ComodoCertificatesSpider/', $useragent)) {
            return new Browser\ComodoCertificatesSpider($useragent);
        } elseif (preg_match('/CompSpyBot/', $useragent)) {
            return new Browser\CompSpyBot($useragent);
        } elseif (preg_match('/CoobyBot/', $useragent)) {
            return new Browser\CoobyBot($useragent);
        } elseif (preg_match('/CoreClassHttpClientCached/', $useragent)) {
            return new Browser\CoreClassHttpClientCached($useragent);
        } elseif (preg_match('/Coverscout/', $useragent)) {
            return new Browser\Coverscout($useragent);
        } elseif (preg_match('/CrystalSemanticsBot/', $useragent)) {
            return new Browser\CrystalSemanticsBot($useragent);
        } elseif (preg_match('/CurlPhp/', $useragent)) {
            return new Browser\CurlPhp($useragent);
        } elseif (preg_match('/CydralWebImageSearch/', $useragent)) {
            return new Browser\CydralWebImageSearch($useragent);
        } elseif (preg_match('/DarwinBrowser/', $useragent)) {
            return new Browser\DarwinBrowser($useragent);
        } elseif (preg_match('/DCPbot/', $useragent)) {
            return new Browser\DCPbot($useragent);
        } elseif (preg_match('/Delibar/', $useragent)) {
            return new Browser\Delibar($useragent);
        } elseif (preg_match('/Diga/', $useragent)) {
            return new Browser\Diga($useragent);
        } elseif (preg_match('/DoCoMo/', $useragent)) {
            return new Browser\DoCoMo($useragent);
        } elseif (preg_match('/DomainCrawler/', $useragent)) {
            return new Browser\DomainCrawler($useragent);
        } elseif (preg_match('/Elefent/', $useragent)) {
            return new Browser\Elefent($useragent);
        } elseif (preg_match('/ElisaBot/', $useragent)) {
            return new Browser\ElisaBot($useragent);
        } elseif (preg_match('/Eudora/', $useragent)) {
            return new Browser\Eudora($useragent);
        } elseif (preg_match('/EuripBot/', $useragent)) {
            return new Browser\EuripBot($useragent);
        } elseif (preg_match('/EventGuruBot/', $useragent)) {
            return new Browser\EventGuruBot($useragent);
        } elseif (preg_match('/ExbLanguageCrawler/', $useragent)) {
            return new Browser\ExbLanguageCrawler($useragent);
        } elseif (preg_match('/Extras4iMovie/', $useragent)) {
            return new Browser\Extras4iMovie($useragent);
        } elseif (preg_match('/FaceBookBot/', $useragent)) {
            return new Browser\FaceBookBot($useragent);
        } elseif (preg_match('/FalkMaps/', $useragent)) {
            return new Browser\FalkMaps($useragent);
        } elseif (preg_match('/FeedFinder/', $useragent)) {
            return new Browser\FeedFinder($useragent);
        } elseif (preg_match('/Findlinks/', $useragent)) {
            return new Browser\Findlinks($useragent);
        } elseif (preg_match('/Firebird/', $useragent)) {
            return new Browser\Firebird($useragent);
        } elseif (preg_match('/Genieo/', $useragent)) {
            return new Browser\Genieo($useragent);
        } elseif (preg_match('/GenieoWebFilter/', $useragent)) {
            return new Browser\GenieoWebFilter($useragent);
        } elseif (preg_match('/Getleft/', $useragent)) {
            return new Browser\Getleft($useragent);
        } elseif (preg_match('/GetPhotos/', $useragent)) {
            return new Browser\GetPhotos($useragent);
        } elseif (preg_match('/Godzilla/', $useragent)) {
            return new Browser\Godzilla($useragent);
        } elseif (preg_match('/Google/', $useragent)) {
            return new Browser\Google($useragent);
        } elseif (preg_match('/GoogleAdsbot/', $useragent)) {
            return new Browser\GoogleAdsbot($useragent);
        } elseif (preg_match('/GoogleEarth/', $useragent)) {
            return new Browser\GoogleEarth($useragent);
        } elseif (preg_match('/GoogleFontAnalysis/', $useragent)) {
            return new Browser\GoogleFontAnalysis($useragent);
        } elseif (preg_match('/GoogleImageProxy/', $useragent)) {
            return new Browser\GoogleImageProxy($useragent);
        } elseif (preg_match('/GoogleMarkupTester/', $useragent)) {
            return new Browser\GoogleMarkupTester($useragent);
        } elseif (preg_match('/GooglePageSpeed/', $useragent)) {
            return new Browser\GooglePageSpeed($useragent);
        } elseif (preg_match('/GoogleSitemaps/', $useragent)) {
            return new Browser\GoogleSitemaps($useragent);
        } elseif (preg_match('/GoogleTv/', $useragent)) {
            return new Browser\GoogleTv($useragent);
        } elseif (preg_match('/Grindr/', $useragent)) {
            return new Browser\Grindr($useragent);
        } elseif (preg_match('/GSLFbot/', $useragent)) {
            return new Browser\GSLFbot($useragent);
        } elseif (preg_match('/HaosouSpider/', $useragent)) {
            return new Browser\HaosouSpider($useragent);
        } elseif (preg_match('/HbbTv/', $useragent)) {
            return new Browser\HbbTv($useragent);
        } elseif (preg_match('/Heritrix/', $useragent)) {
            return new Browser\Heritrix($useragent);
        } elseif (preg_match('/HitLeapViewer/', $useragent)) {
            return new Browser\HitLeapViewer($useragent);
        } elseif (preg_match('/Hitpad/', $useragent)) {
            return new Browser\Hitpad($useragent);
        } elseif (preg_match('/HotWallpapers/', $useragent)) {
            return new Browser\HotWallpapers($useragent);
        } elseif (preg_match('/Ibisbrowser/', $useragent)) {
            return new Browser\Ibisbrowser($useragent);
        } elseif (preg_match('/Ibrowse/', $useragent)) {
            return new Browser\Ibrowse($useragent);
        } elseif (preg_match('/Ibuilder/', $useragent)) {
            return new Browser\Ibuilder($useragent);
        } elseif (preg_match('/Icedove/', $useragent)) {
            return new Browser\Icedove($useragent);
        } elseif (preg_match('/Iceowl/', $useragent)) {
            return new Browser\Iceowl($useragent);
        } elseif (preg_match('/Ichromy/', $useragent)) {
            return new Browser\Ichromy($useragent);
        } elseif (preg_match('/IcjobsCrawler/', $useragent)) {
            return new Browser\IcjobsCrawler($useragent);
        } elseif (preg_match('/ImageMobile/', $useragent)) {
            return new Browser\ImageMobile($useragent);
        } elseif (preg_match('/ImageSearcherS/', $useragent)) {
            return new Browser\ImageSearcherS($useragent);
        } elseif (preg_match('/Incredimail/', $useragent)) {
            return new Browser\Incredimail($useragent);
        } elseif (preg_match('/IndyLibrary/', $useragent)) {
            return new Browser\IndyLibrary($useragent);
        } elseif (preg_match('/InettvBrowser/', $useragent)) {
            return new Browser\InettvBrowser($useragent);
        } elseif (preg_match('/InfohelferCrawler/', $useragent)) {
            return new Browser\InfohelferCrawler($useragent);
        } elseif (preg_match('/InsiteRobot/', $useragent)) {
            return new Browser\InsiteRobot($useragent);
        } elseif (preg_match('/Insitesbot/', $useragent)) {
            return new Browser\Insitesbot($useragent);
        } elseif (preg_match('/IntegromedbCrawler/', $useragent)) {
            return new Browser\IntegromedbCrawler($useragent);
        } elseif (preg_match('/InternetArchive/', $useragent)) {
            return new Browser\InternetArchive($useragent);
        } elseif (preg_match('/Ipick/', $useragent)) {
            return new Browser\Ipick($useragent);
        } elseif (preg_match('/Isource/', $useragent)) {
            return new Browser\Isource($useragent);
        } elseif (preg_match('/JakartaCommonsHttpClient/', $useragent)) {
            return new Browser\JakartaCommonsHttpClient($useragent);
        } elseif (preg_match('/JigsawCssValidator/', $useragent)) {
            return new Browser\JigsawCssValidator($useragent);
        } elseif (preg_match('/JustCrawler/', $useragent)) {
            return new Browser\JustCrawler($useragent);
        } elseif (preg_match('/Kindle/', $useragent)) {
            return new Browser\Kindle($useragent);
        } elseif (preg_match('/Linguatools/', $useragent)) {
            return new Browser\Linguatools($useragent);
        } elseif (preg_match('/LingueeBot/', $useragent)) {
            return new Browser\LingueeBot($useragent);
        } elseif (preg_match('/LinkCheckerBot/', $useragent)) {
            return new Browser\LinkCheckerBot($useragent);
        } elseif (preg_match('/LinkdexComBot/', $useragent)) {
            return new Browser\LinkdexComBot($useragent);
        } elseif (preg_match('/LinkLint/', $useragent)) {
            return new Browser\LinkLint($useragent);
        } elseif (preg_match('/LinkWalkerBot/', $useragent)) {
            return new Browser\LinkWalkerBot($useragent);
        } elseif (preg_match('/LittleBookmarkBox/', $useragent)) {
            return new Browser\LittleBookmarkBox($useragent);
        } elseif (preg_match('/LtBot/', $useragent)) {
            return new Browser\LtBot($useragent);
        } elseif (preg_match('/MacInroyPrivacyAuditors/', $useragent)) {
            return new Browser\MacInroyPrivacyAuditors($useragent);
        } elseif (preg_match('/MaemoBrowser/', $useragent)) {
            return new Browser\MaemoBrowser($useragent);
        } elseif (preg_match('/MagpieCrawler/', $useragent)) {
            return new Browser\MagpieCrawler($useragent);
        } elseif (preg_match('/MailExchangeWebServices/', $useragent)) {
            return new Browser\MailExchangeWebServices($useragent);
        } elseif (preg_match('/Maven/', $useragent)) {
            return new Browser\Maven($useragent);
        } elseif (preg_match('/Mechanize/', $useragent)) {
            return new Browser\Mechanize($useragent);
        } elseif (preg_match('/MicrosoftWindowsNetworkDiagnostics/', $useragent)) {
            return new Browser\MicrosoftWindowsNetworkDiagnostics($useragent);
        } elseif (preg_match('/Mitsubishi/', $useragent)) {
            return new Browser\Mitsubishi($useragent);
        } elseif (preg_match('/Mjbot/', $useragent)) {
            return new Browser\Mjbot($useragent);
        } elseif (preg_match('/Mobilerss/', $useragent)) {
            return new Browser\Mobilerss($useragent);
        } elseif (preg_match('/MovableType/', $useragent)) {
            return new Browser\MovableType($useragent);
        } elseif (preg_match('/Mozad/', $useragent)) {
            return new Browser\Mozad($useragent);
        } elseif (preg_match('/Mozilla/', $useragent)) {
            return new Browser\Mozilla($useragent);
        } elseif (preg_match('/MsieCrawler/', $useragent)) {
            return new Browser\MsieCrawler($useragent);
        } elseif (preg_match('/MsSearch/', $useragent)) {
            return new Browser\MsSearch($useragent);
        } elseif (preg_match('/MyEnginesBot/', $useragent)) {
            return new Browser\MyEnginesBot($useragent);
        } elseif (preg_match('/Nec/', $useragent)) {
            return new Browser\Nec($useragent);
        } elseif (preg_match('/Netbox/', $useragent)) {
            return new Browser\Netbox($useragent);
        } elseif (preg_match('/NetNewsWire/', $useragent)) {
            return new Browser\NetNewsWire($useragent);
        } elseif (preg_match('/NetPositive/', $useragent)) {
            return new Browser\NetPositive($useragent);
        } elseif (preg_match('/NetSurf/', $useragent)) {
            return new Browser\NetSurf($useragent);
        } elseif (preg_match('/NetTv/', $useragent)) {
            return new Browser\NetTv($useragent);
        } elseif (preg_match('/Netvibes/', $useragent)) {
            return new Browser\Netvibes($useragent);
        } elseif (preg_match('/NewsBot/', $useragent)) {
            return new Browser\NewsBot($useragent);
        } elseif (preg_match('/NewsRack/', $useragent)) {
            return new Browser\NewsRack($useragent);
        } elseif (preg_match('/NixGibts/', $useragent)) {
            return new Browser\NixGibts($useragent);
        } elseif (preg_match('/NodeJsHttpRequest/', $useragent)) {
            return new Browser\NodeJsHttpRequest($useragent);
        } elseif (preg_match('/OnePassword/', $useragent)) {
            return new Browser\OnePassword($useragent);
        } elseif (preg_match('/OpenVas/', $useragent)) {
            return new Browser\OpenVas($useragent);
        } elseif (preg_match('/OpenWeb/', $useragent)) {
            return new Browser\OpenWeb($useragent);
        } elseif (preg_match('/Origin/', $useragent)) {
            return new Browser\Origin($useragent);
        } elseif (preg_match('/OssProxy/', $useragent)) {
            return new Browser\OssProxy($useragent);
        } elseif (preg_match('/Pagebull/', $useragent)) {
            return new Browser\Pagebull($useragent);
        } elseif (preg_match('/PalmPixi/', $useragent)) {
            return new Browser\PalmPixi($useragent);
        } elseif (preg_match('/PalmPre/', $useragent)) {
            return new Browser\PalmPre($useragent);
        } elseif (preg_match('/Panasonic/', $useragent)) {
            return new Browser\Panasonic($useragent);
        } elseif (preg_match('/Pandora/', $useragent)) {
            return new Browser\Pandora($useragent);
        } elseif (preg_match('/Parchbot/', $useragent)) {
            return new Browser\Parchbot($useragent);
        } elseif (preg_match('/PearHttpRequest/', $useragent)) {
            return new Browser\PearHttpRequest($useragent);
        } elseif (preg_match('/PearHttpRequest2/', $useragent)) {
            return new Browser\PearHttpRequest2($useragent);
        } elseif (preg_match('/Philips/', $useragent)) {
            return new Browser\Philips($useragent);
        } elseif (preg_match('/PixraySeeker/', $useragent)) {
            return new Browser\PixraySeeker($useragent);
        } elseif (preg_match('/Playstation/', $useragent)) {
            return new Browser\Playstation($useragent);
        } elseif (preg_match('/PlaystationBrowser/', $useragent)) {
            return new Browser\PlaystationBrowser($useragent);
        } elseif (preg_match('/Plukkie/', $useragent)) {
            return new Browser\Plukkie($useragent);
        } elseif (preg_match('/PodtechNetwork/', $useragent)) {
            return new Browser\PodtechNetwork($useragent);
        } elseif (preg_match('/Pogodak/', $useragent)) {
            return new Browser\Pogodak($useragent);
        } elseif (preg_match('/Postbox/', $useragent)) {
            return new Browser\Postbox($useragent);
        } elseif (preg_match('/Powertv/', $useragent)) {
            return new Browser\Powertv($useragent);
        } elseif (preg_match('/Prism/', $useragent)) {
            return new Browser\Prism($useragent);
        } elseif (preg_match('/Python/', $useragent)) {
            return new Browser\Python($useragent);
        } elseif (preg_match('/Qihoo/', $useragent)) {
            return new Browser\Qihoo($useragent);
        } elseif (preg_match('/Qtek/', $useragent)) {
            return new Browser\Qtek($useragent);
        } elseif (preg_match('/QtWeb/', $useragent)) {
            return new Browser\QtWeb($useragent);
        } elseif (preg_match('/Quantcastbot/', $useragent)) {
            return new Browser\Quantcastbot($useragent);
        } elseif (preg_match('/QuerySeekerSpider/', $useragent)) {
            return new Browser\QuerySeekerSpider($useragent);
        } elseif (preg_match('/Quicktime/', $useragent)) {
            return new Browser\Quicktime($useragent);
        } elseif (preg_match('/Realplayer/', $useragent)) {
            return new Browser\Realplayer($useragent);
        } elseif (preg_match('/RgAnalytics/', $useragent)) {
            return new Browser\RgAnalytics($useragent);
        } elseif (preg_match('/Rippers/', $useragent)) {
            return new Browser\Rippers($useragent);
        } elseif (preg_match('/Rojo/', $useragent)) {
            return new Browser\Rojo($useragent);
        } elseif (preg_match('/RssingBot/', $useragent)) {
            return new Browser\RssingBot($useragent);
        } elseif (preg_match('/RssOwl/', $useragent)) {
            return new Browser\RssOwl($useragent);
        } elseif (preg_match('/RukyBot/', $useragent)) {
            return new Browser\RukyBot($useragent);
        } elseif (preg_match('/Ruunk/', $useragent)) {
            return new Browser\Ruunk($useragent);
        } elseif (preg_match('/Samsung/', $useragent)) {
            return new Browser\Samsung($useragent);
        } elseif (preg_match('/SamsungMobileBrowser/', $useragent)) {
            return new Browser\SamsungMobileBrowser($useragent);
        } elseif (preg_match('/Sanyo/', $useragent)) {
            return new Browser\Sanyo($useragent);
        } elseif (preg_match('/SaveTheWorldHeritage/', $useragent)) {
            return new Browser\SaveTheWorldHeritage($useragent);
        } elseif (preg_match('/Scorpionbot/', $useragent)) {
            return new Browser\Scorpionbot($useragent);
        } elseif (preg_match('/Scraper/', $useragent)) {
            return new Browser\Scraper($useragent);
        } elseif (preg_match('/Searchmetrics/', $useragent)) {
            return new Browser\Searchmetrics($useragent);
        } elseif (preg_match('/SemagerBot/', $useragent)) {
            return new Browser\SemagerBot($useragent);
        } elseif (preg_match('/SeoEngineWorldBot/', $useragent)) {
            return new Browser\SeoEngineWorldBot($useragent);
        } elseif (preg_match('/Setooz/', $useragent)) {
            return new Browser\Setooz($useragent);
        } elseif (preg_match('/Shiira/', $useragent)) {
            return new Browser\Shiira($useragent);
        } elseif (preg_match('/Shopsalad/', $useragent)) {
            return new Browser\Shopsalad($useragent);
        } elseif (preg_match('/Siemens/', $useragent)) {
            return new Browser\Siemens($useragent);
        } elseif (preg_match('/Sindice/', $useragent)) {
            return new Browser\Sindice($useragent);
        } elseif (preg_match('/SiteKiosk/', $useragent)) {
            return new Browser\SiteKiosk($useragent);
        } elseif (preg_match('/SlimBrowser/', $useragent)) {
            return new Browser\SlimBrowser($useragent);
        } elseif (preg_match('/SmartSync/', $useragent)) {
            return new Browser\SmartSync($useragent);
        } elseif (preg_match('/SmartTv/', $useragent)) {
            return new Browser\SmartTv($useragent);
        } elseif (preg_match('/SmartTvWebBrowser/', $useragent)) {
            return new Browser\SmartTvWebBrowser($useragent);
        } elseif (preg_match('/Snapbot/', $useragent)) {
            return new Browser\Snapbot($useragent);
        } elseif (preg_match('/Snoopy/', $useragent)) {
            return new Browser\Snoopy($useragent);
        } elseif (preg_match('/Snowtape/', $useragent)) {
            return new Browser\Snowtape($useragent);
        } elseif (preg_match('/Songbird/', $useragent)) {
            return new Browser\Songbird($useragent);
        } elseif (preg_match('/Sosospider/', $useragent)) {
            return new Browser\Sosospider($useragent);
        } elseif (preg_match('/SpaceBison/', $useragent)) {
            return new Browser\SpaceBison($useragent);
        } elseif (preg_match('/Spector/', $useragent)) {
            return new Browser\Spector($useragent);
        } elseif (preg_match('/SpeedySpider/', $useragent)) {
            return new Browser\SpeedySpider($useragent);
        } elseif (preg_match('/SpellCheckBot/', $useragent)) {
            return new Browser\SpellCheckBot($useragent);
        } elseif (preg_match('/SpiderLing/', $useragent)) {
            return new Browser\SpiderLing($useragent);
        } elseif (preg_match('/Spiderlytics/', $useragent)) {
            return new Browser\Spiderlytics($useragent);
        } elseif (preg_match('/SpiderPig/', $useragent)) {
            return new Browser\SpiderPig($useragent);
        } elseif (preg_match('/SprayCan/', $useragent)) {
            return new Browser\SprayCan($useragent);
        } elseif (preg_match('/SPV/', $useragent)) {
            return new Browser\SPV($useragent);
        } elseif (preg_match('/SquidWall/', $useragent)) {
            return new Browser\SquidWall($useragent);
        } elseif (preg_match('/Sqwidgebot/', $useragent)) {
            return new Browser\Sqwidgebot($useragent);
        } elseif (preg_match('/Strata/', $useragent)) {
            return new Browser\Strata($useragent);
        } elseif (preg_match('/StrategicBoardBot/', $useragent)) {
            return new Browser\StrategicBoardBot($useragent);
        } elseif (preg_match('/StrawberryjamUrlExpander/', $useragent)) {
            return new Browser\StrawberryjamUrlExpander($useragent);
        } elseif (preg_match('/Sunbird/', $useragent)) {
            return new Browser\Sunbird($useragent);
        } elseif (preg_match('/Superfish/', $useragent)) {
            return new Browser\Superfish($useragent);
        } elseif (preg_match('/Superswan/', $useragent)) {
            return new Browser\Superswan($useragent);
        } elseif (preg_match('/SymphonyBrowser/', $useragent)) {
            return new Browser\SymphonyBrowser($useragent);
        } elseif (preg_match('/SynapticWalker/', $useragent)) {
            return new Browser\SynapticWalker($useragent);
        } elseif (preg_match('/TagInspectorBot/', $useragent)) {
            return new Browser\TagInspectorBot($useragent);
        } elseif (preg_match('/Tailrank/', $useragent)) {
            return new Browser\Tailrank($useragent);
        } elseif (preg_match('/TasapImageRobot/', $useragent)) {
            return new Browser\TasapImageRobot($useragent);
        } elseif (preg_match('/TenFourFox/', $useragent)) {
            return new Browser\TenFourFox($useragent);
        } elseif (preg_match('/Terra/', $useragent)) {
            return new Browser\Terra($useragent);
        } elseif (preg_match('/TheBatDownloadManager/', $useragent)) {
            return new Browser\TheBatDownloadManager($useragent);
        } elseif (preg_match('/ThemeSearchAndExtractionCrawler/', $useragent)) {
            return new Browser\ThemeSearchAndExtractionCrawler($useragent);
        } elseif (preg_match('/ThumbShotsBot/', $useragent)) {
            return new Browser\ThumbShotsBot($useragent);
        } elseif (preg_match('/Thunderstone/', $useragent)) {
            return new Browser\Thunderstone($useragent);
        } elseif (preg_match('/TinEye/', $useragent)) {
            return new Browser\TinEye($useragent);
        } elseif (preg_match('/TkcAutodownloader/', $useragent)) {
            return new Browser\TkcAutodownloader($useragent);
        } elseif (preg_match('/TlsProber/', $useragent)) {
            return new Browser\TlsProber($useragent);
        } elseif (preg_match('/Toshiba/', $useragent)) {
            return new Browser\Toshiba($useragent);
        } elseif (preg_match('/TrendictionBot/', $useragent)) {
            return new Browser\TrendictionBot($useragent);
        } elseif (preg_match('/TrendMicro/', $useragent)) {
            return new Browser\TrendMicro($useragent);
        } elseif (preg_match('/TumblrRssSyndication/', $useragent)) {
            return new Browser\TumblrRssSyndication($useragent);
        } elseif (preg_match('/TuringMachine/', $useragent)) {
            return new Browser\TuringMachine($useragent);
        } elseif (preg_match('/TurnitinBot/', $useragent)) {
            return new Browser\TurnitinBot($useragent);
        } elseif (preg_match('/Tweetbot/', $useragent)) {
            return new Browser\Tweetbot($useragent);
        } elseif (preg_match('/TwengabotDiscover/', $useragent)) {
            return new Browser\TwengabotDiscover($useragent);
        } elseif (preg_match('/Twitturls/', $useragent)) {
            return new Browser\Twitturls($useragent);
        } elseif (preg_match('/Typo/', $useragent)) {
            return new Browser\Typo($useragent);
        } elseif (preg_match('/TypoLinkvalidator/', $useragent)) {
            return new Browser\TypoLinkvalidator($useragent);
        } elseif (preg_match('/UnisterPortale/', $useragent)) {
            return new Browser\UnisterPortale($useragent);
        } elseif (preg_match('/UoftdbExperiment/', $useragent)) {
            return new Browser\UoftdbExperiment($useragent);
        } elseif (preg_match('/Vanillasurf/', $useragent)) {
            return new Browser\Vanillasurf($useragent);
        } elseif (preg_match('/Viralheat/', $useragent)) {
            return new Browser\Viralheat($useragent);
        } elseif (preg_match('/VmsMosaic/', $useragent)) {
            return new Browser\VmsMosaic($useragent);
        } elseif (preg_match('/Vobsub/', $useragent)) {
            return new Browser\Vobsub($useragent);
        } elseif (preg_match('/Voilabot/', $useragent)) {
            return new Browser\Voilabot($useragent);
        } elseif (preg_match('/Vonnacom/', $useragent)) {
            return new Browser\Vonnacom($useragent);
        } elseif (preg_match('/Voyager/', $useragent)) {
            return new Browser\Voyager($useragent);
        } elseif (preg_match('/W3cChecklink/', $useragent)) {
            return new Browser\W3cChecklink($useragent);
        } elseif (preg_match('/W3cValidator/', $useragent)) {
            return new Browser\W3cValidator($useragent);
        } elseif (preg_match('/W3m/', $useragent)) {
            return new Browser\W3m($useragent);
        } elseif (preg_match('/Webaroo/', $useragent)) {
            return new Browser\Webaroo($useragent);
        } elseif (preg_match('/Webbotru/', $useragent)) {
            return new Browser\Webbotru($useragent);
        } elseif (preg_match('/Webcapture/', $useragent)) {
            return new Browser\Webcapture($useragent);
        } elseif (preg_match('/WebDownloader/', $useragent)) {
            return new Browser\WebDownloader($useragent);
        } elseif (preg_match('/Webimages/', $useragent)) {
            return new Browser\Webimages($useragent);
        } elseif (preg_match('/Weblide/', $useragent)) {
            return new Browser\Weblide($useragent);
        } elseif (preg_match('/WebLinkValidator/', $useragent)) {
            return new Browser\WebLinkValidator($useragent);
        } elseif (preg_match('/WebmasterworldServerHeaderChecker/', $useragent)) {
            return new Browser\WebmasterworldServerHeaderChecker($useragent);
        } elseif (preg_match('/WebOX/', $useragent)) {
            return new Browser\WebOX($useragent);
        } elseif (preg_match('/Webscan/', $useragent)) {
            return new Browser\Webscan($useragent);
        } elseif (preg_match('/Websuchebot/', $useragent)) {
            return new Browser\Websuchebot($useragent);
        } elseif (preg_match('/WebtvMsntv/', $useragent)) {
            return new Browser\WebtvMsntv($useragent);
        } elseif (preg_match('/Wepbot/', $useragent)) {
            return new Browser\Wepbot($useragent);
        } elseif (preg_match('/WiJobRoboter/', $useragent)) {
            return new Browser\WiJobRoboter($useragent);
        } elseif (preg_match('/Wikimpress/', $useragent)) {
            return new Browser\Wikimpress($useragent);
        } elseif (preg_match('/Winamp/', $useragent)) {
            return new Browser\Winamp($useragent);
        } elseif (preg_match('/Winkbot/', $useragent)) {
            return new Browser\Winkbot($useragent);
        } elseif (preg_match('/Winwap/', $useragent)) {
            return new Browser\Winwap($useragent);
        } elseif (preg_match('/Wire/', $useragent)) {
            return new Browser\Wire($useragent);
        } elseif (preg_match('/Wisebot/', $useragent)) {
            return new Browser\Wisebot($useragent);
        } elseif (preg_match('/Wizz/', $useragent)) {
            return new Browser\Wizz($useragent);
        } elseif (preg_match('/Worldlingo/', $useragent)) {
            return new Browser\Worldlingo($useragent);
        } elseif (preg_match('/WorldWideWeasel/', $useragent)) {
            return new Browser\WorldWideWeasel($useragent);
        } elseif (preg_match('/Wotbox/', $useragent)) {
            return new Browser\Wotbox($useragent);
        } elseif (preg_match('/WwwBrowser/', $useragent)) {
            return new Browser\WwwBrowser($useragent);
        } elseif (preg_match('/Wwwc/', $useragent)) {
            return new Browser\Wwwc($useragent);
        } elseif (preg_match('/Wwwmail/', $useragent)) {
            return new Browser\Wwwmail($useragent);
        } elseif (preg_match('/WwwMechanize/', $useragent)) {
            return new Browser\WwwMechanize($useragent);
        } elseif (preg_match('/Wwwster/', $useragent)) {
            return new Browser\Wwwster($useragent);
        } elseif (preg_match('/XaldonWebspider/', $useragent)) {
            return new Browser\XaldonWebspider($useragent);
        } elseif (preg_match('/XchaosArachne/', $useragent)) {
            return new Browser\XchaosArachne($useragent);
        } elseif (preg_match('/Xerka/', $useragent)) {
            return new Browser\Xerka($useragent);
        } elseif (preg_match('/XmlRpcForPhp/', $useragent)) {
            return new Browser\XmlRpcForPhp($useragent);
        } elseif (preg_match('/Xspider/', $useragent)) {
            return new Browser\Xspider($useragent);
        } elseif (preg_match('/Xyleme/', $useragent)) {
            return new Browser\Xyleme($useragent);
        } elseif (preg_match('/YacyBot/', $useragent)) {
            return new Browser\YacyBot($useragent);
        } elseif (preg_match('/Yadowscrawler/', $useragent)) {
            return new Browser\Yadowscrawler($useragent);
        } elseif (preg_match('/Yahoo/', $useragent)) {
            return new Browser\Yahoo($useragent);
        } elseif (preg_match('/YahooExternalCache/', $useragent)) {
            return new Browser\YahooExternalCache($useragent);
        } elseif (preg_match('/YahooMobileMessenger/', $useragent)) {
            return new Browser\YahooMobileMessenger($useragent);
        } elseif (preg_match('/YahooPipes/', $useragent)) {
            return new Browser\YahooPipes($useragent);
        } elseif (preg_match('/YandexImagesBot/', $useragent)) {
            return new Browser\YandexImagesBot($useragent);
        } elseif (preg_match('/YouWaveAndroidOnPc/', $useragent)) {
            return new Browser\YouWaveAndroidOnPc($useragent);
        }

        return new Browser\UnknownBrowser($useragent);
    }
}
