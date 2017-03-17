<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory;

use BrowserDetector\Loader\LoaderInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use UaResult\Os\OsInterface;
use Stringy\Stringy;

/**
 * Browser detection class
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <mimmi20@live.de>
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class BrowserFactory implements FactoryInterface
{
    /**
     * @var \Psr\Cache\CacheItemPoolInterface|null
     */
    private $cache = null;

    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \Psr\Cache\CacheItemPoolInterface       $cache
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(CacheItemPoolInterface $cache, LoaderInterface $loader)
    {
        $this->cache  = $cache;
        $this->loader = $loader;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string                   $useragent
     * @param \UaResult\Os\OsInterface $platform
     *
     * @return array
     */
    public function detect(
        $useragent,
        OsInterface $platform = null
    ) {
        $s = new Stringy($useragent);

        if (preg_match('/RevIP\.info site analyzer/', $useragent)) {
            return $this->loader->load('reverse ip lookup', $useragent);
        }

        if (preg_match('/reddit pic scraper/i', $useragent)) {
            return $this->loader->load('reddit pic scraper', $useragent);
        }

        if (preg_match('/Mozilla crawl/', $useragent)) {
            return $this->loader->load('mozilla crawler', $useragent);
        }

        if (preg_match('/^\[FBAN/i', $useragent)) {
            return $this->loader->load('facebook app', $useragent);
        }

        if (preg_match('/UCBrowserHD/', $useragent)) {
            return $this->loader->load('uc browser hd', $useragent);
        }

        if (preg_match('/(ucbrowser|uc browser|ucweb)/i', $useragent) && preg_match('/opera mini/i', $useragent)) {
            return $this->loader->load('ucbrowser', $useragent);
        }

        if (preg_match('/(opera mini|opios)/i', $useragent)) {
            return $this->loader->load('opera mini', $useragent);
        }

        if (preg_match('/opera mobi/i', $useragent)
            || (preg_match('/(opera|opr)/i', $useragent) && preg_match('/(Android|MTK|MAUI|SAMSUNG|Windows CE|SymbOS)/', $useragent))
        ) {
            return $this->loader->load('opera mobile', $useragent);
        }

        if (preg_match('/(ucbrowser|uc browser|ucweb)/i', $useragent)) {
            return $this->loader->load('ucbrowser', $useragent);
        }

        if (preg_match('/IC OpenGraph Crawler/', $useragent)) {
            return $this->loader->load('ibm connections', $useragent);
        }

        if (preg_match('/coast/i', $useragent)) {
            return $this->loader->load('coast', $useragent);
        }

        if (preg_match('/(opera|opr)/i', $useragent)) {
            return $this->loader->load('opera', $useragent);
        }

        if (preg_match('/iCabMobile/', $useragent)) {
            return $this->loader->load('icab mobile', $useragent);
        }

        if (preg_match('/iCab/', $useragent)) {
            return $this->loader->load('icab', $useragent);
        }

        if (preg_match('/HggH PhantomJS Screenshoter/', $useragent)) {
            return $this->loader->load('hggh screenshot system with phantomjs', $useragent);
        }

        if (preg_match('/bl\.uk\_lddc\_bot/', $useragent)) {
            return $this->loader->load('bl.uk_lddc_bot', $useragent);
        }

        if (preg_match('/phantomas/', $useragent)) {
            return $this->loader->load('phantomas', $useragent);
        }

        if (preg_match('/Seznam screenshot\-generator/', $useragent)) {
            return $this->loader->load('seznam screenshot generator', $useragent);
        }

        if (false !== mb_strpos($useragent, 'PhantomJS')) {
            return $this->loader->load('phantomjs', $useragent);
        }

        if (false !== mb_strpos($useragent, 'YaBrowser')) {
            return $this->loader->load('yabrowser', $useragent);
        }

        if (false !== mb_strpos($useragent, 'Kamelio')) {
            return $this->loader->load('kamelio app', $useragent);
        }

        if (false !== mb_strpos($useragent, 'FBAV')) {
            return $this->loader->load('facebook app', $useragent);
        }

        if (false !== mb_strpos($useragent, 'ACHEETAHI')) {
            return $this->loader->load('cm browser', $useragent);
        }

        if (preg_match('/flyflow/i', $useragent)) {
            return $this->loader->load('flyflow', $useragent);
        }

        if (false !== mb_strpos($useragent, 'bdbrowser_i18n') || false !== mb_strpos($useragent, 'baidubrowser')) {
            return $this->loader->load('baidu browser', $useragent);
        }

        if (false !== mb_strpos($useragent, 'bdbrowserhd_i18n')) {
            return $this->loader->load('baidu browser hd', $useragent);
        }

        if (false !== mb_strpos($useragent, 'bdbrowser_mini')) {
            return $this->loader->load('baidu browser mini', $useragent);
        }

        if (false !== mb_strpos($useragent, 'Puffin')) {
            return $this->loader->load('puffin', $useragent);
        }

        if (preg_match('/stagefright/', $useragent)) {
            return $this->loader->load('stagefright', $useragent);
        }

        if (false !== mb_strpos($useragent, 'SamsungBrowser')) {
            return $this->loader->load('samsungbrowser', $useragent);
        }

        if (false !== mb_strpos($useragent, 'Silk')) {
            return $this->loader->load('silk', $useragent);
        }

        if (false !== mb_strpos($useragent, 'coc_coc_browser')) {
            return $this->loader->load('coc_coc_browser', $useragent);
        }

        if (false !== mb_strpos($useragent, 'NaverMatome')) {
            return $this->loader->load('matome', $useragent);
        }

        if (preg_match('/FlipboardProxy/', $useragent)) {
            return $this->loader->load('flipboardproxy', $useragent);
        }

        if (false !== mb_strpos($useragent, 'Flipboard')) {
            return $this->loader->load('flipboard app', $useragent);
        }

        if (false !== mb_strpos($useragent, 'Seznam.cz')) {
            return $this->loader->load('seznam browser', $useragent);
        }

        if (false !== mb_strpos($useragent, 'Aviator')) {
            return $this->loader->load('aviator', $useragent);
        }

        if (preg_match('/NetFrontLifeBrowser/', $useragent)) {
            return $this->loader->load('netfrontlifebrowser', $useragent);
        }

        if (preg_match('/IceDragon/', $useragent)) {
            return $this->loader->load('icedragon', $useragent);
        }

        if (false !== mb_strpos($useragent, 'Dragon') && false === mb_strpos($useragent, 'DragonFly')) {
            return $this->loader->load('dragon', $useragent);
        }

        if (false !== mb_strpos($useragent, 'Beamrise')) {
            return $this->loader->load('beamrise', $useragent);
        }

        if (false !== mb_strpos($useragent, 'Diglo')) {
            return $this->loader->load('diglo', $useragent);
        }

        if (false !== mb_strpos($useragent, 'APUSBrowser')) {
            return $this->loader->load('apusbrowser', $useragent);
        }

        if (false !== mb_strpos($useragent, 'Chedot')) {
            return $this->loader->load('chedot', $useragent);
        }

        if (false !== mb_strpos($useragent, 'Qword')) {
            return $this->loader->load('qword browser', $useragent);
        }

        if (false !== mb_strpos($useragent, 'Iridium')) {
            return $this->loader->load('iridium browser', $useragent);
        }

        if (preg_match('/avant/i', $useragent)) {
            return $this->loader->load('avant', $useragent);
        }

        if (false !== mb_strpos($useragent, 'MxNitro')) {
            return $this->loader->load('maxthon nitro', $useragent);
        }

        if (preg_match('/(mxbrowser|maxthon|myie)/i', $useragent)) {
            return $this->loader->load('maxthon', $useragent);
        }

        if (preg_match('/superbird/i', $useragent)) {
            return $this->loader->load('superbird', $useragent);
        }

        if (false !== mb_strpos($useragent, 'TinyBrowser')) {
            return $this->loader->load('tinybrowser', $useragent);
        }

        if (preg_match('/MicroMessenger/', $useragent)) {
            return $this->loader->load('wechat app', $useragent);
        }

        if (preg_match('/MQQBrowser\/Mini/', $useragent)) {
            return $this->loader->load('qqbrowser mini', $useragent);
        }

        if (preg_match('/MQQBrowser/', $useragent)) {
            return $this->loader->load('qqbrowser', $useragent);
        }

        if (preg_match('/pinterest/i', $useragent)) {
            return $this->loader->load('pinterest app', $useragent);
        }

        if (preg_match('/baiduboxapp/', $useragent)) {
            return $this->loader->load('baidu box app', $useragent);
        }

        if (preg_match('/wkbrowser/', $useragent)) {
            return $this->loader->load('wkbrowser', $useragent);
        }

        if (preg_match('/Mb2345Browser/', $useragent)) {
            return $this->loader->load('2345 browser', $useragent);
        }

        if (false !== mb_strpos($useragent, 'Chrome')
            && false !== mb_strpos($useragent, 'Version')
            && 0 < mb_strpos($useragent, 'Chrome')
        ) {
            return $this->loader->load('android webview', $useragent);
        }

        if (false !== mb_strpos($useragent, 'Safari')
            && false !== mb_strpos($useragent, 'Version')
            && false !== mb_strpos($useragent, 'Tizen')
        ) {
            return $this->loader->load('samsung webview', $useragent);
        }

        if (preg_match('/cybeye/i', $useragent)) {
            return $this->loader->load('cybeye', $useragent);
        }

        if (preg_match('/RebelMouse/', $useragent)) {
            return $this->loader->load('rebelmouse', $useragent);
        }

        if (preg_match('/SeaMonkey/', $useragent)) {
            return $this->loader->load('seamonkey', $useragent);
        }

        if (preg_match('/Jobboerse/', $useragent)) {
            return $this->loader->load('jobboerse bot', $useragent);
        }

        if (preg_match('/Navigator/', $useragent)) {
            return $this->loader->load('netscape navigator', $useragent);
        }

        if (preg_match('/firefox/i', $useragent) && preg_match('/anonym/i', $useragent)) {
            return $this->loader->load('firefox', $useragent);
        }

        if (preg_match('/trident/i', $useragent) && preg_match('/anonym/i', $useragent)) {
            return $this->loader->load('internet explorer', $useragent);
        }

        if (preg_match('/Windows\-RSS\-Platform/', $useragent)) {
            return $this->loader->load('windows-rss-platform', $useragent);
        }

        if (preg_match('/MarketwireBot/', $useragent)) {
            return $this->loader->load('marketwirebot', $useragent);
        }

        if (preg_match('/GoogleToolbar/', $useragent)) {
            return $this->loader->load('google toolbar', $useragent);
        }

        if (preg_match('/netscape/i', $useragent) && preg_match('/msie/i', $useragent)) {
            return $this->loader->load('netscape', $useragent);
        }

        if (preg_match('/LSSRocketCrawler/', $useragent)) {
            return $this->loader->load('lightspeed systems rocketcrawler', $useragent);
        }

        if (preg_match('/lightspeedsystems/i', $useragent)) {
            return $this->loader->load('lightspeed systems crawler', $useragent);
        }

        if (preg_match('/SL Commerce Client/', $useragent)) {
            return $this->loader->load('second live commerce client', $useragent);
        }

        if (preg_match('/(IEMobile|WPDesktop|ZuneWP7|XBLWP7)/', $useragent)) {
            return $this->loader->load('iemobile', $useragent);
        }

        if (preg_match('/BingPreview/', $useragent)) {
            return $this->loader->load('bing preview', $useragent);
        }

        if (preg_match('/360Spider/', $useragent)) {
            return $this->loader->load('360spider', $useragent);
        }

        if (preg_match('/Outlook\-Express/', $useragent)) {
            return $this->loader->load('outlook-express', $useragent);
        }

        if (preg_match('/Outlook/', $useragent)) {
            return $this->loader->load('outlook', $useragent);
        }

        if (preg_match('/microsoft office mobile/i', $useragent)) {
            return $this->loader->load('office', $useragent);
        }

        if (preg_match('/MSOffice/', $useragent)) {
            return $this->loader->load('office', $useragent);
        }

        if (preg_match('/Microsoft Office Protocol Discovery/', $useragent)) {
            return $this->loader->load('ms opd', $useragent);
        }

        if (preg_match('/excel/i', $useragent)) {
            return $this->loader->load('excel', $useragent);
        }

        if (preg_match('/powerpoint/i', $useragent)) {
            return $this->loader->load('powerpoint', $useragent);
        }

        if (preg_match('/WordPress/', $useragent)) {
            return $this->loader->load('wordpress', $useragent);
        }

        if (preg_match('/Word/', $useragent)) {
            return $this->loader->load('word', $useragent);
        }

        if (preg_match('/OneNote/', $useragent)) {
            return $this->loader->load('onenote', $useragent);
        }

        if (preg_match('/Visio/', $useragent)) {
            return $this->loader->load('visio', $useragent);
        }

        if (preg_match('/Access/', $useragent)) {
            return $this->loader->load('access', $useragent);
        }

        if (preg_match('/Lync/', $useragent)) {
            return $this->loader->load('lync', $useragent);
        }

        if (preg_match('/Office SyncProc/', $useragent)) {
            return $this->loader->load('office syncproc', $useragent);
        }

        if (preg_match('/Office Upload Center/', $useragent)) {
            return $this->loader->load('office upload center', $useragent);
        }

        if (preg_match('/frontpage/i', $useragent)) {
            return $this->loader->load('frontpage', $useragent);
        }

        if (preg_match('/microsoft office/i', $useragent)) {
            return $this->loader->load('office', $useragent);
        }

        if (preg_match('/Crazy Browser/', $useragent)) {
            return $this->loader->load('crazy browser', $useragent);
        }

        if (preg_match('/Deepnet Explorer/', $useragent)) {
            return $this->loader->load('deepnet explorer', $useragent);
        }

        if (preg_match('/kkman/i', $useragent)) {
            return $this->loader->load('kkman', $useragent);
        }

        if (preg_match('/Lunascape/', $useragent)) {
            return $this->loader->load('lunascape', $useragent);
        }

        if (preg_match('/Sleipnir/', $useragent)) {
            return $this->loader->load('sleipnir', $useragent);
        }

        if (preg_match('/Smartsite HTTPClient/', $useragent)) {
            return $this->loader->load('smartsite httpclient', $useragent);
        }

        if (preg_match('/GomezAgent/', $useragent)) {
            return $this->loader->load('gomez site monitor', $useragent);
        }

        if (preg_match('/Mozilla\/5\.0.*\(.*Trident\/8\.0.*rv\:\d+\).*/', $useragent)
            || preg_match('/Mozilla\/5\.0.*\(.*Trident\/7\.0.*\) like Gecko.*/', $useragent)
            || preg_match('/Mozilla\/5\.0.*\(.*MSIE 10\.\d.*Trident\/(4|5|6|7|8)\.0.*/', $useragent)
            || preg_match('/Mozilla\/(4|5)\.0.*\(.*MSIE (9|8|7|6)\.0.*/', $useragent)
            || preg_match('/Mozilla\/(4|5)\.0.*\(.*MSIE (5|4)\.\d+.*/', $useragent)
            || preg_match('/Mozilla\/\d\.\d+.*\(.*MSIE (3|2|1)\.\d+.*/', $useragent)
        ) {
            return $this->loader->load('internet explorer', $useragent);
        }

        if (false !== mb_strpos($useragent, 'Chromium')) {
            return $this->loader->load('chromium', $useragent);
        }

        if (false !== mb_strpos($useragent, 'Iron')) {
            return $this->loader->load('iron', $useragent);
        }

        if (preg_match('/midori/i', $useragent)) {
            return $this->loader->load('midori', $useragent);
        }

        if (preg_match('/Google Page Speed Insights/', $useragent)) {
            return $this->loader->load('google pagespeed insights', $useragent);
        }

        if (preg_match('/(web\/snippet)/', $useragent)) {
            return $this->loader->load('google web snippet', $useragent);
        }

        if (preg_match('/(googlebot\-mobile)/i', $useragent)) {
            return $this->loader->load('googlebot-mobile', $useragent);
        }

        if (preg_match('/Google Wireless Transcoder/', $useragent)) {
            return $this->loader->load('google wireless transcoder', $useragent);
        }

        if (preg_match('/Locubot/', $useragent)) {
            return $this->loader->load('locubot', $useragent);
        }

        if (preg_match('/(com\.google\.GooglePlus)/i', $useragent)) {
            return $this->loader->load('google+ app', $useragent);
        }

        if (preg_match('/Google\-HTTP\-Java\-Client/', $useragent)) {
            return $this->loader->load('google http client library for java', $useragent);
        }

        if (preg_match('/acapbot/i', $useragent)) {
            return $this->loader->load('acapbot', $useragent);
        }

        if (preg_match('/googlebot\-image/i', $useragent)) {
            return $this->loader->load('google image search', $useragent);
        }

        if (preg_match('/googlebot/i', $useragent)) {
            return $this->loader->load('googlebot', $useragent);
        }

        if (preg_match('/^GOOG$/', $useragent)) {
            return $this->loader->load('googlebot', $useragent);
        }

        if (preg_match('/viera/i', $useragent)) {
            return $this->loader->load('smartviera', $useragent);
        }

        if (preg_match('/Nichrome/', $useragent)) {
            return $this->loader->load('nichrome', $useragent);
        }

        if (preg_match('/Kinza/', $useragent)) {
            return $this->loader->load('kinza', $useragent);
        }

        if (preg_match('/Google Keyword Suggestion/', $useragent)) {
            return $this->loader->load('google keyword suggestion', $useragent);
        }

        if (preg_match('/Google Web Preview/', $useragent)) {
            return $this->loader->load('google web preview', $useragent);
        }

        if (preg_match('/Google-Adwords-DisplayAds-WebRender/', $useragent)) {
            return $this->loader->load('google adwords displayads webrender', $useragent);
        }

        if (preg_match('/HubSpot Webcrawler/', $useragent)) {
            return $this->loader->load('hubspot webcrawler', $useragent);
        }

        if (preg_match('/RockMelt/', $useragent)) {
            return $this->loader->load('rockmelt', $useragent);
        }

        if (preg_match('/ SE /', $useragent)) {
            return $this->loader->load('sogou explorer', $useragent);
        }

        if (preg_match('/ArchiveBot/', $useragent)) {
            return $this->loader->load('archivebot', $useragent);
        }

        if (preg_match('/Edge/', $useragent) && null !== $platform && 'Windows Phone OS' === $platform->getName()) {
            return $this->loader->load('edge mobile', $useragent);
        }

        if (preg_match('/Edge/', $useragent)) {
            return $this->loader->load('edge', $useragent);
        }

        if (preg_match('/diffbot/i', $useragent)) {
            return $this->loader->load('diffbot', $useragent);
        }

        if (preg_match('/vivaldi/i', $useragent)) {
            return $this->loader->load('vivaldi', $useragent);
        }

        if (preg_match('/LBBROWSER/', $useragent)) {
            return $this->loader->load('liebao', $useragent);
        }

        if (preg_match('/Amigo/', $useragent)) {
            return $this->loader->load('amigo', $useragent);
        }

        if (preg_match('/CoolNovoChromePlus/', $useragent)) {
            return $this->loader->load('coolnovo chrome plus', $useragent);
        }

        if (preg_match('/CoolNovo/', $useragent)) {
            return $this->loader->load('coolnovo', $useragent);
        }

        if (preg_match('/Kenshoo/', $useragent)) {
            return $this->loader->load('kenshoo', $useragent);
        }

        if (preg_match('/Bowser/', $useragent)) {
            return $this->loader->load('bowser', $useragent);
        }

        if (preg_match('/360SE/', $useragent)) {
            return $this->loader->load('360 secure browser', $useragent);
        }

        if (preg_match('/360EE/', $useragent)) {
            return $this->loader->load('360 speed browser', $useragent);
        }

        if (preg_match('/ASW/', $useragent)) {
            return $this->loader->load('avast safezone', $useragent);
        }

        if (preg_match('/Wire/', $useragent)) {
            return $this->loader->load('wire app', $useragent);
        }

        if (preg_match('/chrome\/(\d+)\.(\d+)/i', $useragent, $matches)
            && isset($matches[1])
            && isset($matches[2])
            && $matches[1] >= 1
            && $matches[2] > 0
            && $matches[2] <= 10
        ) {
            return $this->loader->load('dragon', $useragent);
        }

        if (preg_match('/Flock/', $useragent)) {
            return $this->loader->load('flock', $useragent);
        }

        if (preg_match('/Crosswalk/', $useragent)) {
            return $this->loader->load('crosswalk', $useragent);
        }

        if (preg_match('/Bromium Safari/', $useragent)) {
            return $this->loader->load('vsentry', $useragent);
        }

        if (preg_match('/(chrome|crmo|crios)/i', $useragent)) {
            return $this->loader->load('chrome', $useragent);
        }

        if (preg_match('/(dolphin http client)/i', $useragent)) {
            return $this->loader->load('dolphin smalltalk http client', $useragent);
        }

        if (preg_match('/(dolphin|dolfin)/i', $useragent)) {
            return $this->loader->load('dolfin', $useragent);
        }

        if (preg_match('/Arora/', $useragent)) {
            return $this->loader->load('arora', $useragent);
        }

        if (preg_match('/com\.douban\.group/i', $useragent)) {
            return $this->loader->load('douban app', $useragent);
        }

        if (preg_match('/ovibrowser/i', $useragent)) {
            return $this->loader->load('nokia proxy browser', $useragent);
        }

        if (preg_match('/MiuiBrowser/i', $useragent)) {
            return $this->loader->load('miui browser', $useragent);
        }

        if (preg_match('/ibrowser/i', $useragent)) {
            return $this->loader->load('ibrowser', $useragent);
        }

        if (preg_match('/OneBrowser/', $useragent)) {
            return $this->loader->load('onebrowser', $useragent);
        }

        if (preg_match('/Baiduspider\-image/', $useragent)) {
            return $this->loader->load('baidu image search', $useragent);
        }

        if (preg_match('/http:\/\/www\.baidu\.com\/search/', $useragent)) {
            return $this->loader->load('baidu mobile search', $useragent);
        }

        if (preg_match('/(yjapp|yjtop)/i', $useragent)) {
            return $this->loader->load('yahoo! app', $useragent);
        }

        if (preg_match('/(linux; u; android|linux; android)/i', $useragent) && preg_match('/version/i', $useragent)) {
            return $this->loader->load('android webkit', $useragent);
        }

        if (preg_match('/safari/i', $useragent) && null !== $platform && 'Android' === $platform->getName()) {
            return $this->loader->load('android webkit', $useragent);
        }

        if (preg_match('/Browser\/AppleWebKit/', $useragent)) {
            return $this->loader->load('android webkit', $useragent);
        }

        if (preg_match('/Android\/[\d\.]+ release/', $useragent)) {
            return $this->loader->load('android webkit', $useragent);
        }

        if (false !== mb_strpos($useragent, 'BlackBerry') && false !== mb_strpos($useragent, 'Version')) {
            return $this->loader->load('blackberry', $useragent);
        }

        if (preg_match('/(webOS|wOSBrowser|wOSSystem)/', $useragent)) {
            return $this->loader->load('webkit/webos', $useragent);
        }

        if (preg_match('/OmniWeb/', $useragent)) {
            return $this->loader->load('omniweb', $useragent);
        }

        if (preg_match('/Windows Phone Search/', $useragent)) {
            return $this->loader->load('windows phone search', $useragent);
        }

        if (preg_match('/Windows\-Update\-Agent/', $useragent)) {
            return $this->loader->load('windows-update-agent', $useragent);
        }

        if (preg_match('/classilla/i', $useragent)) {
            return $this->loader->load('classilla', $useragent);
        }

        if (preg_match('/nokia/i', $useragent)) {
            return $this->loader->load('nokiabrowser', $useragent);
        }

        if (preg_match('/twitter for i/i', $useragent)) {
            return $this->loader->load('twitter app', $useragent);
        }

        if (preg_match('/twitterbot/i', $useragent)) {
            return $this->loader->load('twitterbot', $useragent);
        }

        if (preg_match('/GSA/', $useragent)) {
            return $this->loader->load('google app', $useragent);
        }

        if (preg_match('/QtCarBrowser/', $useragent)) {
            return $this->loader->load('model s browser', $useragent);
        }

        if (preg_match('/Qt/', $useragent)) {
            return $this->loader->load('qt', $useragent);
        }

        if (preg_match('/Instagram/', $useragent)) {
            return $this->loader->load('instagram app', $useragent);
        }

        if (preg_match('/WebClip/', $useragent)) {
            return $this->loader->load('webclip app', $useragent);
        }

        if (preg_match('/Mercury/', $useragent)) {
            return $this->loader->load('mercury', $useragent);
        }

        if (preg_match('/MacAppStore/', $useragent)) {
            return $this->loader->load('macappstore', $useragent);
        }

        if (preg_match('/AppStore/', $useragent)) {
            return $this->loader->load('apple appstore app', $useragent);
        }

        if (preg_match('/Webglance/', $useragent)) {
            return $this->loader->load('web glance', $useragent);
        }

        if (preg_match('/YHOO\_Search\_App/', $useragent)) {
            return $this->loader->load('yahoo mobile app', $useragent);
        }

        if (preg_match('/NewsBlur Feed Fetcher/', $useragent)) {
            return $this->loader->load('newsblur feed fetcher', $useragent);
        }

        if (preg_match('/AppleCoreMedia/', $useragent)) {
            return $this->loader->load('coremedia', $useragent);
        }

        if (preg_match('/dataaccessd/', $useragent)) {
            return $this->loader->load('ios dataaccessd', $useragent);
        }

        if (preg_match('/MailChimp/', $useragent)) {
            return $this->loader->load('mailchimp.com', $useragent);
        }

        if (preg_match('/MailBar/', $useragent)) {
            return $this->loader->load('mailbar', $useragent);
        }

        if (preg_match('/^Mail/', $useragent)) {
            return $this->loader->load('apple mail', $useragent);
        }

        if (preg_match('/^Mozilla\/5\.0.*\(.*(CPU iPhone OS|CPU OS) \d+(_|\.)\d+.* like Mac OS X.*\) AppleWebKit.* \(KHTML, like Gecko\)$/', $useragent)) {
            return $this->loader->load('apple mail', $useragent);
        }

        if (preg_match('/^Mozilla\/5\.0 \(Macintosh; Intel Mac OS X.*\) AppleWebKit.* \(KHTML, like Gecko\)$/', $useragent)) {
            return $this->loader->load('apple mail', $useragent);
        }

        if (preg_match('/^Mozilla\/5\.0 \(Windows.*\) AppleWebKit.* \(KHTML, like Gecko\)$/', $useragent)) {
            return $this->loader->load('apple mail', $useragent);
        }

        if (preg_match('/msnbot\-media/i', $useragent)) {
            return $this->loader->load('msnbot-media', $useragent);
        }

        if (preg_match('/adidxbot/i', $useragent)) {
            return $this->loader->load('adidxbot', $useragent);
        }

        if (preg_match('/msnbot/i', $useragent)) {
            return $this->loader->load('bingbot', $useragent);
        }

        if (preg_match('/BlackberryPlaybookTablet/', $useragent)) {
            return $this->loader->load('blackberry playbook tablet', $useragent);
        }

        if (preg_match('/(blackberry|bb10)/i', $useragent)) {
            return $this->loader->load('blackberry', $useragent);
        }

        if (preg_match('/WeTab\-Browser/', $useragent)) {
            return $this->loader->load('wetab browser', $useragent);
        }

        if (preg_match('/profiller/', $useragent)) {
            return $this->loader->load('profiller', $useragent);
        }

        if (preg_match('/(wkhtmltopdf)/i', $useragent)) {
            return $this->loader->load('wkhtmltopdf', $useragent);
        }

        if (preg_match('/(wkhtmltoimage)/i', $useragent)) {
            return $this->loader->load('wkhtmltoimage', $useragent);
        }

        if (preg_match('/(wp\-iphone|wp\-android)/', $useragent)) {
            return $this->loader->load('wordpress app', $useragent);
        }

        if (preg_match('/OktaMobile/', $useragent)) {
            return $this->loader->load('okta mobile app', $useragent);
        }

        if (preg_match('/kmail2/', $useragent)) {
            return $this->loader->load('kmail2', $useragent);
        }

        if (preg_match('/eb\-iphone/', $useragent)) {
            return $this->loader->load('eb iphone/ipad app', $useragent);
        }

        if (preg_match('/ElmediaPlayer/', $useragent)) {
            return $this->loader->load('elmedia player', $useragent);
        }

        if (preg_match('/Schoolwires/', $useragent)) {
            return $this->loader->load('schoolwires app', $useragent);
        }

        if (preg_match('/Dreamweaver/', $useragent)) {
            return $this->loader->load('dreamweaver', $useragent);
        }

        if (preg_match('/akregator/', $useragent)) {
            return $this->loader->load('akregator', $useragent);
        }

        if (preg_match('/Installatron/', $useragent)) {
            return $this->loader->load('installatron', $useragent);
        }

        if (preg_match('/Quora Link Preview/', $useragent)) {
            return $this->loader->load('quora link preview bot', $useragent);
        }

        if (preg_match('/Quora/', $useragent)) {
            return $this->loader->load('quora app', $useragent);
        }

        if (preg_match('/Rocky ChatWork Mobile/', $useragent)) {
            return $this->loader->load('rocky chatwork mobile', $useragent);
        }

        if (preg_match('/AdsBot\-Google\-Mobile/', $useragent)) {
            return $this->loader->load('adsbot google-mobile', $useragent);
        }

        if (preg_match('/epiphany/i', $useragent)) {
            return $this->loader->load('epiphany', $useragent);
        }

        if (preg_match('/rekonq/', $useragent)) {
            return $this->loader->load('rekonq', $useragent);
        }

        if (preg_match('/Skyfire/', $useragent)) {
            return $this->loader->load('skyfire', $useragent);
        }

        if (preg_match('/FlixsteriOS/', $useragent)) {
            return $this->loader->load('flixster app', $useragent);
        }

        if (preg_match('/(adbeat\_bot|adbeat\.com)/', $useragent)) {
            return $this->loader->load('adbeat bot', $useragent);
        }

        if (preg_match('/(SecondLife|Second Life)/', $useragent)) {
            return $this->loader->load('second live client', $useragent);
        }

        if (preg_match('/(Salesforce1|SalesforceTouchContainer)/', $useragent)) {
            return $this->loader->load('salesforce app', $useragent);
        }

        if (preg_match('/(nagios\-plugins|check\_http)/', $useragent)) {
            return $this->loader->load('nagios', $useragent);
        }

        if (preg_match('/bingbot/i', $useragent)) {
            return $this->loader->load('bingbot', $useragent);
        }

        if (preg_match('/Mediapartners\-Google/', $useragent)) {
            return $this->loader->load('adsense bot', $useragent);
        }

        if (preg_match('/SMTBot/', $useragent)) {
            return $this->loader->load('smtbot', $useragent);
        }

        if (preg_match('/domain\.com/', $useragent)) {
            return $this->loader->load('pagepeeker screenshot maker', $useragent);
        }

        if (preg_match('/PagePeeker/', $useragent)) {
            return $this->loader->load('pagepeeker', $useragent);
        }

        if (preg_match('/DiigoBrowser/', $useragent)) {
            return $this->loader->load('diigo browser', $useragent);
        }

        if (preg_match('/kontact/', $useragent)) {
            return $this->loader->load('kontact', $useragent);
        }

        if (preg_match('/QupZilla/', $useragent)) {
            return $this->loader->load('qupzilla', $useragent);
        }

        if (preg_match('/FxiOS/', $useragent)) {
            return $this->loader->load('firefox for ios', $useragent);
        }

        if (preg_match('/qutebrowser/', $useragent)) {
            return $this->loader->load('qutebrowser', $useragent);
        }

        if (preg_match('/Otter/', $useragent)) {
            return $this->loader->load('otter', $useragent);
        }

        if (preg_match('/PaleMoon/', $useragent)) {
            return $this->loader->load('palemoon', $useragent);
        }

        if (preg_match('/slurp/i', $useragent)) {
            return $this->loader->load('slurp', $useragent);
        }

        if (preg_match('/applebot/i', $useragent)) {
            return $this->loader->load('applebot', $useragent);
        }

        if (preg_match('/SoundCloud/', $useragent)) {
            return $this->loader->load('soundcloud app', $useragent);
        }

        if (preg_match('/Rival IQ/', $useragent)) {
            return $this->loader->load('rival iq bot', $useragent);
        }

        if (preg_match('/Evernote Clip Resolver/', $useragent)) {
            return $this->loader->load('evernote clip resolver', $useragent);
        }

        if (preg_match('/Evernote/', $useragent)) {
            return $this->loader->load('evernote app', $useragent);
        }

        if (preg_match('/Fluid/', $useragent)) {
            return $this->loader->load('fluid', $useragent);
        }

        if (preg_match('/safari/i', $useragent)) {
            return $this->loader->load('safari', $useragent);
        }

        if (preg_match('/^Mozilla\/(4|5)\.0 \(Macintosh; .* Mac OS X .*\) AppleWebKit\/.* \(KHTML, like Gecko\) Version\/[\d\.]+$/i', $useragent)) {
            return $this->loader->load('safari', $useragent);
        }

        if (preg_match('/TWCAN\/SportsNet/', $useragent)) {
            return $this->loader->load('twc sportsnet', $useragent);
        }

        if (preg_match('/AdobeAIR/', $useragent)) {
            return $this->loader->load('adobe air', $useragent);
        }

        if (preg_match('/(easouspider)/i', $useragent)) {
            return $this->loader->load('easouspider', $useragent);
        }

        if (preg_match('/^Mozilla\/5\.0.*\((iPhone|iPad|iPod).*\).*AppleWebKit\/.*\(.*KHTML, like Gecko.*\).*Mobile.*/i', $useragent)) {
            return $this->loader->load('mobile safari uiwebview', $useragent);
        }

        if (preg_match('/waterfox/i', $useragent)) {
            return $this->loader->load('waterfox', $useragent);
        }

        if (preg_match('/Thunderbird/', $useragent)) {
            return $this->loader->load('thunderbird', $useragent);
        }

        if (preg_match('/Fennec/', $useragent)) {
            return $this->loader->load('fennec', $useragent);
        }

        if (preg_match('/myibrow/', $useragent)) {
            return $this->loader->load('my internet browser', $useragent);
        }

        if (preg_match('/Daumoa/', $useragent)) {
            return $this->loader->load('daumoa', $useragent);
        }

        if (preg_match('/PaleMoon/', $useragent)) {
            return $this->loader->load('palemoon', $useragent);
        }

        if (preg_match('/iceweasel/i', $useragent)) {
            return $this->loader->load('iceweasel', $useragent);
        }

        if (preg_match('/icecat/i', $useragent)) {
            return $this->loader->load('icecat', $useragent);
        }

        if (preg_match('/iceape/i', $useragent)) {
            return $this->loader->load('iceape', $useragent);
        }

        if (preg_match('/galeon/i', $useragent)) {
            return $this->loader->load('galeon', $useragent);
        }

        if (preg_match('/SurveyBot/', $useragent)) {
            return $this->loader->load('surveybot', $useragent);
        }

        if (preg_match('/aggregator\:Spinn3r/', $useragent)) {
            return $this->loader->load('spinn3r rss aggregator', $useragent);
        }

        if (preg_match('/TweetmemeBot/', $useragent)) {
            return $this->loader->load('tweetmeme bot', $useragent);
        }

        if (preg_match('/Butterfly/', $useragent)) {
            return $this->loader->load('butterfly robot', $useragent);
        }

        if (preg_match('/James BOT/', $useragent)) {
            return $this->loader->load('jamesbot', $useragent);
        }

        if (preg_match('/MSIE or Firefox mutant; not on Windows server/', $useragent)) {
            return $this->loader->load('daumoa', $useragent);
        }

        if (preg_match('/SailfishBrowser/', $useragent)) {
            return $this->loader->load('sailfish browser', $useragent);
        }

        if (preg_match('/KcB/', $useragent)) {
            return $this->loader->load('unknown', $useragent);
        }

        if (preg_match('/kazehakase/i', $useragent)) {
            return $this->loader->load('kazehakase', $useragent);
        }

        if (preg_match('/cometbird/i', $useragent)) {
            return $this->loader->load('cometbird', $useragent);
        }

        if (preg_match('/Camino/', $useragent)) {
            return $this->loader->load('camino', $useragent);
        }

        if (preg_match('/SlimerJS/', $useragent)) {
            return $this->loader->load('slimerjs', $useragent);
        }

        if (preg_match('/MultiZilla/', $useragent)) {
            return $this->loader->load('multizilla', $useragent);
        }

        if (preg_match('/Minimo/', $useragent)) {
            return $this->loader->load('minimo', $useragent);
        }

        if (preg_match('/MicroB/', $useragent)) {
            return $this->loader->load('microb', $useragent);
        }

        if (preg_match('/firefox/i', $useragent)
            && !preg_match('/gecko/i', $useragent)
            && preg_match('/anonymized/i', $useragent)
        ) {
            return $this->loader->load('firefox', $useragent);
        }

        if (preg_match('/(firefox|minefield|shiretoko|bonecho|namoroka)/i', $useragent)) {
            return $this->loader->load('firefox', $useragent);
        }

        if (preg_match('/gvfs/', $useragent)) {
            return $this->loader->load('gvfs', $useragent);
        }

        if (preg_match('/luakit/', $useragent)) {
            return $this->loader->load('luakit', $useragent);
        }

        if (preg_match('/playstation 3/i', $useragent)) {
            return $this->loader->load('netfront', $useragent);
        }

        if (preg_match('/sistrix/i', $useragent)) {
            return $this->loader->load('sistrix crawler', $useragent);
        }

        if (preg_match('/ezooms/i', $useragent)) {
            return $this->loader->load('ezooms', $useragent);
        }

        if (preg_match('/grapefx/i', $useragent)) {
            return $this->loader->load('grapefx', $useragent);
        }

        if (preg_match('/grapeshotcrawler/i', $useragent)) {
            return $this->loader->load('grapeshotcrawler', $useragent);
        }

        if (preg_match('/(mail\.ru)/i', $useragent)) {
            return $this->loader->load('mail.ru', $useragent);
        }

        if (preg_match('/(proximic)/i', $useragent)) {
            return $this->loader->load('proximic', $useragent);
        }

        if (preg_match('/(polaris)/i', $useragent)) {
            return $this->loader->load('polaris', $useragent);
        }

        if (preg_match('/(another web mining tool|awmt)/i', $useragent)) {
            return $this->loader->load('another web mining tool', $useragent);
        }

        if (preg_match('/(wbsearchbot|wbsrch)/i', $useragent)) {
            return $this->loader->load('wbsearchbot', $useragent);
        }

        if (preg_match('/(konqueror)/i', $useragent)) {
            return $this->loader->load('konqueror', $useragent);
        }

        if (preg_match('/(typo3\-linkvalidator)/i', $useragent)) {
            return $this->loader->load('typo3 linkvalidator', $useragent);
        }

        if (preg_match('/feeddlerrss/i', $useragent)) {
            return $this->loader->load('feeddler rss reader', $useragent);
        }

        if (preg_match('/^mozilla\/5\.0 \((iphone|ipad|ipod).*CPU like Mac OS X.*\) AppleWebKit\/\d+/i', $useragent)) {
            return $this->loader->load('safari', $useragent);
        }

        if (preg_match('/(ios|iphone|ipad|ipod)/i', $useragent)) {
            return $this->loader->load('mobile safari uiwebview', $useragent);
        }

        if (preg_match('/paperlibot/i', $useragent)) {
            return $this->loader->load('paper.li bot', $useragent);
        }

        if (preg_match('/spbot/i', $useragent)) {
            return $this->loader->load('seoprofiler', $useragent);
        }

        if (preg_match('/dotbot/i', $useragent)) {
            return $this->loader->load('dotbot', $useragent);
        }

        if (preg_match('/(google\-structureddatatestingtool|Google\-structured\-data\-testing\-tool)/i', $useragent)) {
            return $this->loader->load('google structured-data testingtool', $useragent);
        }

        if (preg_match('/webmastercoffee/i', $useragent)) {
            return $this->loader->load('webmastercoffee', $useragent);
        }

        if (preg_match('/ahrefs/i', $useragent)) {
            return $this->loader->load('ahrefsbot', $useragent);
        }

        if (preg_match('/apercite/i', $useragent)) {
            return $this->loader->load('apercite', $useragent);
        }

        if (preg_match('/woobot/', $useragent)) {
            return $this->loader->load('woobot', $useragent);
        }

        if (preg_match('/Blekkobot/', $useragent)) {
            return $this->loader->load('blekkobot', $useragent);
        }

        if (preg_match('/PagesInventory/', $useragent)) {
            return $this->loader->load('pagesinventory bot', $useragent);
        }

        if (preg_match('/Slackbot\-LinkExpanding/', $useragent)) {
            return $this->loader->load('slackbot-link-expanding', $useragent);
        }

        if (preg_match('/Slackbot/', $useragent)) {
            return $this->loader->load('slackbot', $useragent);
        }

        if (preg_match('/SEOkicks\-Robot/', $useragent)) {
            return $this->loader->load('seokicks robot', $useragent);
        }

        if (preg_match('/Exabot/', $useragent)) {
            return $this->loader->load('exabot', $useragent);
        }

        if (preg_match('/DomainSCAN/', $useragent)) {
            return $this->loader->load('domainscan server monitoring', $useragent);
        }

        if (preg_match('/JobRoboter/', $useragent)) {
            return $this->loader->load('jobroboter', $useragent);
        }

        if (preg_match('/AcoonBot/', $useragent)) {
            return $this->loader->load('acoonbot', $useragent);
        }

        if (preg_match('/woriobot/', $useragent)) {
            return $this->loader->load('woriobot', $useragent);
        }

        if (preg_match('/MonoBot/', $useragent)) {
            return $this->loader->load('monobot', $useragent);
        }

        if (preg_match('/DomainSigmaCrawler/', $useragent)) {
            return $this->loader->load('domainsigmacrawler', $useragent);
        }

        if (preg_match('/bnf\.fr\_bot/', $useragent)) {
            return $this->loader->load('bnf.fr bot', $useragent);
        }

        if (preg_match('/CrawlRobot/', $useragent)) {
            return $this->loader->load('crawlrobot', $useragent);
        }

        if (preg_match('/AddThis\.com robot/', $useragent)) {
            return $this->loader->load('addthis.com robot', $useragent);
        }

        if (preg_match('/(Yeti|naver\.com\/robots)/', $useragent)) {
            return $this->loader->load('naverbot', $useragent);
        }

        if (preg_match('/^robots$/', $useragent)) {
            return $this->loader->load('testcrawler', $useragent);
        }

        if (preg_match('/DeuSu/', $useragent)) {
            return $this->loader->load('werbefreie deutsche suchmaschine', $useragent);
        }

        if (preg_match('/obot/i', $useragent)) {
            return $this->loader->load('obot', $useragent);
        }

        if (preg_match('/ZumBot/', $useragent)) {
            return $this->loader->load('zumbot', $useragent);
        }

        if (preg_match('/(umbot)/i', $useragent)) {
            return $this->loader->load('umbot', $useragent);
        }

        if (preg_match('/(picmole)/i', $useragent)) {
            return $this->loader->load('picmole bot', $useragent);
        }

        if (preg_match('/(zollard)/i', $useragent)) {
            return $this->loader->load('zollard worm', $useragent);
        }

        if (preg_match('/(fhscan core)/i', $useragent)) {
            return $this->loader->load('fhscan core', $useragent);
        }

        if (preg_match('/nbot/i', $useragent)) {
            return $this->loader->load('nbot', $useragent);
        }

        if (preg_match('/(loadtimebot)/i', $useragent)) {
            return $this->loader->load('loadtimebot', $useragent);
        }

        if (preg_match('/(scrubby)/i', $useragent)) {
            return $this->loader->load('scrubby', $useragent);
        }

        if (preg_match('/(squzer)/i', $useragent)) {
            return $this->loader->load('squzer', $useragent);
        }

        if (preg_match('/PiplBot/', $useragent)) {
            return $this->loader->load('piplbot', $useragent);
        }

        if (preg_match('/EveryoneSocialBot/', $useragent)) {
            return $this->loader->load('everyonesocialbot', $useragent);
        }

        if (preg_match('/AOLbot/', $useragent)) {
            return $this->loader->load('aolbot', $useragent);
        }

        if (preg_match('/GLBot/', $useragent)) {
            return $this->loader->load('glbot', $useragent);
        }

        if (preg_match('/(lbot)/i', $useragent)) {
            return $this->loader->load('lbot', $useragent);
        }

        if (preg_match('/(blexbot)/i', $useragent)) {
            return $this->loader->load('blexbot', $useragent);
        }

        if (preg_match('/(socialradarbot)/i', $useragent)) {
            return $this->loader->load('socialradar bot', $useragent);
        }

        if (preg_match('/(synapse)/i', $useragent)) {
            return $this->loader->load('apache synapse', $useragent);
        }

        if (preg_match('/(linkdexbot)/i', $useragent)) {
            return $this->loader->load('linkdex bot', $useragent);
        }

        if (preg_match('/(coccoc)/i', $useragent)) {
            return $this->loader->load('coccoc bot', $useragent);
        }

        if (preg_match('/(siteexplorer)/i', $useragent)) {
            return $this->loader->load('siteexplorer', $useragent);
        }

        if (preg_match('/(semrushbot)/i', $useragent)) {
            return $this->loader->load('semrushbot', $useragent);
        }

        if (preg_match('/(istellabot)/i', $useragent)) {
            return $this->loader->load('istellabot', $useragent);
        }

        if (preg_match('/(meanpathbot)/i', $useragent)) {
            return $this->loader->load('meanpathbot', $useragent);
        }

        if (preg_match('/(XML Sitemaps Generator)/', $useragent)) {
            return $this->loader->load('xml sitemaps generator', $useragent);
        }

        if (preg_match('/SeznamBot/', $useragent)) {
            return $this->loader->load('seznambot', $useragent);
        }

        if (preg_match('/URLAppendBot/', $useragent)) {
            return $this->loader->load('urlappendbot', $useragent);
        }

        if (preg_match('/NetSeer crawler/', $useragent)) {
            return $this->loader->load('netseer crawler', $useragent);
        }

        if (preg_match('/SeznamBot/', $useragent)) {
            return $this->loader->load('seznambot', $useragent);
        }

        if (preg_match('/Add Catalog/', $useragent)) {
            return $this->loader->load('add catalog', $useragent);
        }

        if (preg_match('/Moreover/', $useragent)) {
            return $this->loader->load('moreover', $useragent);
        }

        if (preg_match('/LinkpadBot/', $useragent)) {
            return $this->loader->load('linkpadbot', $useragent);
        }

        if (preg_match('/Lipperhey SEO Service/', $useragent)) {
            return $this->loader->load('lipperhey seo service', $useragent);
        }

        if (preg_match('/Blog Search/', $useragent)) {
            return $this->loader->load('blog search', $useragent);
        }

        if (preg_match('/Qualidator\.com Bot/', $useragent)) {
            return $this->loader->load('qualidator.com bot', $useragent);
        }

        if (preg_match('/fr\-crawler/', $useragent)) {
            return $this->loader->load('fr-crawler', $useragent);
        }

        if (preg_match('/ca\-crawler/', $useragent)) {
            return $this->loader->load('ca-crawler', $useragent);
        }

        if (preg_match('/Website Thumbnail Generator/', $useragent)) {
            return $this->loader->load('website thumbnail generator', $useragent);
        }

        if (preg_match('/WebThumb/', $useragent)) {
            return $this->loader->load('webthumb', $useragent);
        }

        if (preg_match('/KomodiaBot/', $useragent)) {
            return $this->loader->load('komodiabot', $useragent);
        }

        if (preg_match('/GroupHigh/', $useragent)) {
            return $this->loader->load('grouphigh bot', $useragent);
        }

        if (preg_match('/theoldreader/', $useragent)) {
            return $this->loader->load('the old reader', $useragent);
        }

        if (preg_match('/Google\-Site\-Verification/', $useragent)) {
            return $this->loader->load('google-site-verification', $useragent);
        }

        if (preg_match('/Prlog/', $useragent)) {
            return $this->loader->load('prlog', $useragent);
        }

        if (preg_match('/CMS Crawler/', $useragent)) {
            return $this->loader->load('cms crawler', $useragent);
        }

        if (preg_match('/pmoz\.info ODP link checker/', $useragent)) {
            return $this->loader->load('pmoz.info odp link checker', $useragent);
        }

        if (preg_match('/Twingly Recon/', $useragent)) {
            return $this->loader->load('twingly recon', $useragent);
        }

        if (preg_match('/Embedly/', $useragent)) {
            return $this->loader->load('embedly', $useragent);
        }

        if (preg_match('/Alexabot/', $useragent)) {
            return $this->loader->load('alexabot', $useragent);
        }

        if (preg_match('/alexa site audit/', $useragent)) {
            return $this->loader->load('alexa site audit', $useragent);
        }

        if (preg_match('/MJ12bot/', $useragent)) {
            return $this->loader->load('mj12bot', $useragent);
        }

        if (preg_match('/HTTrack/', $useragent)) {
            return $this->loader->load('httrack', $useragent);
        }

        if (preg_match('/UnisterBot/', $useragent)) {
            return $this->loader->load('unisterbot', $useragent);
        }

        if (preg_match('/CareerBot/', $useragent)) {
            return $this->loader->load('careerbot', $useragent);
        }

        if (preg_match('/80legs/i', $useragent)) {
            return $this->loader->load('80legs', $useragent);
        }

        if (preg_match('/wada\.vn/i', $useragent)) {
            return $this->loader->load('wada.vn search bot', $useragent);
        }

        if (preg_match('/(NX|WiiU|Nintendo 3DS)/', $useragent)) {
            return $this->loader->load('netfront nx', $useragent);
        }

        if (preg_match('/(netfront|playstation 4)/i', $useragent)) {
            return $this->loader->load('netfront', $useragent);
        }

        if (preg_match('/XoviBot/', $useragent)) {
            return $this->loader->load('xovibot', $useragent);
        }

        if (preg_match('/007ac9 Crawler/', $useragent)) {
            return $this->loader->load('007ac9 crawler', $useragent);
        }

        if (preg_match('/200PleaseBot/', $useragent)) {
            return $this->loader->load('200pleasebot', $useragent);
        }

        if (preg_match('/Abonti/', $useragent)) {
            return $this->loader->load('abonti websearch', $useragent);
        }

        if (preg_match('/publiclibraryarchive/', $useragent)) {
            return $this->loader->load('publiclibraryarchive bot', $useragent);
        }

        if (preg_match('/PAD\-bot/', $useragent)) {
            return $this->loader->load('pad-bot', $useragent);
        }

        if (preg_match('/SoftListBot/', $useragent)) {
            return $this->loader->load('softlistbot', $useragent);
        }

        if (preg_match('/sReleaseBot/', $useragent)) {
            return $this->loader->load('sreleasebot', $useragent);
        }

        if (preg_match('/Vagabondo/', $useragent)) {
            return $this->loader->load('vagabondo', $useragent);
        }

        if (preg_match('/special\_archiver/', $useragent)) {
            return $this->loader->load('internet archive special archiver', $useragent);
        }

        if (preg_match('/Optimizer/', $useragent)) {
            return $this->loader->load('optimizer bot', $useragent);
        }

        if (preg_match('/Sophora Linkchecker/', $useragent)) {
            return $this->loader->load('sophora linkchecker', $useragent);
        }

        if (preg_match('/SEOdiver/', $useragent)) {
            return $this->loader->load('seodiver bot', $useragent);
        }

        if (preg_match('/itsscan/', $useragent)) {
            return $this->loader->load('itsscan', $useragent);
        }

        if (preg_match('/Google Desktop/', $useragent)) {
            return $this->loader->load('google desktop', $useragent);
        }

        if (preg_match('/Lotus\-Notes/', $useragent)) {
            return $this->loader->load('lotus notes', $useragent);
        }

        if (preg_match('/AskPeterBot/', $useragent)) {
            return $this->loader->load('askpeterbot', $useragent);
        }

        if (preg_match('/discoverybot/', $useragent)) {
            return $this->loader->load('discovery bot', $useragent);
        }

        if (preg_match('/YandexBot/', $useragent)) {
            return $this->loader->load('yandexbot', $useragent);
        }

        if (preg_match('/MOSBookmarks/', $useragent) && preg_match('/Link Checker/', $useragent)) {
            return $this->loader->load('mosbookmarks link checker', $useragent);
        }

        if (preg_match('/MOSBookmarks/', $useragent)) {
            return $this->loader->load('mosbookmarks', $useragent);
        }

        if (preg_match('/WebMasterAid/', $useragent)) {
            return $this->loader->load('webmasteraid', $useragent);
        }

        if (preg_match('/AboutUsBot Johnny5/', $useragent)) {
            return $this->loader->load('aboutus bot johnny5', $useragent);
        }

        if (preg_match('/AboutUsBot/', $useragent)) {
            return $this->loader->load('aboutus bot', $useragent);
        }

        if (preg_match('/semantic\-visions\.com crawler/', $useragent)) {
            return $this->loader->load('semantic-visions.com crawler', $useragent);
        }

        if (preg_match('/waybackarchive\.org/', $useragent)) {
            return $this->loader->load('wayback archive bot', $useragent);
        }

        if (preg_match('/OpenVAS/', $useragent)) {
            return $this->loader->load('open vulnerability assessment system', $useragent);
        }

        if (preg_match('/MixrankBot/', $useragent)) {
            return $this->loader->load('mixrankbot', $useragent);
        }

        if (preg_match('/InfegyAtlas/', $useragent)) {
            return $this->loader->load('infegyatlas', $useragent);
        }

        if (preg_match('/MojeekBot/', $useragent)) {
            return $this->loader->load('mojeekbot', $useragent);
        }

        if (preg_match('/memorybot/i', $useragent)) {
            return $this->loader->load('memorybot', $useragent);
        }

        if (preg_match('/DomainAppender/', $useragent)) {
            return $this->loader->load('domainappender bot', $useragent);
        }

        if (preg_match('/GIDBot/', $useragent)) {
            return $this->loader->load('gidbot', $useragent);
        }

        if (preg_match('/DBot/', $useragent)) {
            return $this->loader->load('dbot', $useragent);
        }

        if (preg_match('/PWBot/', $useragent)) {
            return $this->loader->load('pwbot', $useragent);
        }

        if (preg_match('/\+5Bot/', $useragent)) {
            return $this->loader->load('plus5bot', $useragent);
        }

        if (preg_match('/WASALive\-Bot/', $useragent)) {
            return $this->loader->load('wasalive bot', $useragent);
        }

        if (preg_match('/OpenHoseBot/', $useragent)) {
            return $this->loader->load('openhosebot', $useragent);
        }

        if (preg_match('/URLfilterDB\-crawler/', $useragent)) {
            return $this->loader->load('urlfilterdb crawler', $useragent);
        }

        if (preg_match('/metager2\-verification\-bot/', $useragent)) {
            return $this->loader->load('metager2-verification-bot', $useragent);
        }

        if (preg_match('/Powermarks/', $useragent)) {
            return $this->loader->load('powermarks', $useragent);
        }

        if (preg_match('/CloudFlare\-AlwaysOnline/', $useragent)) {
            return $this->loader->load('cloudflare alwaysonline', $useragent);
        }

        if (preg_match('/Phantom\.js bot/', $useragent)) {
            return $this->loader->load('phantom.js bot', $useragent);
        }

        if (preg_match('/Phantom/', $useragent)) {
            return $this->loader->load('phantom browser', $useragent);
        }

        if (preg_match('/Shrook/', $useragent)) {
            return $this->loader->load('shrook', $useragent);
        }

        if (preg_match('/netEstate NE Crawler/', $useragent)) {
            return $this->loader->load('netestate ne crawler', $useragent);
        }

        if (preg_match('/garlikcrawler/i', $useragent)) {
            return $this->loader->load('garlikcrawler', $useragent);
        }

        if (preg_match('/metageneratorcrawler/i', $useragent)) {
            return $this->loader->load('metageneratorcrawler', $useragent);
        }

        if (preg_match('/ScreenerBot/', $useragent)) {
            return $this->loader->load('screenerbot', $useragent);
        }

        if (preg_match('/WebTarantula\.com Crawler/', $useragent)) {
            return $this->loader->load('webtarantula', $useragent);
        }

        if (preg_match('/BacklinkCrawler/', $useragent)) {
            return $this->loader->load('backlinkcrawler', $useragent);
        }

        if (preg_match('/LinksCrawler/', $useragent)) {
            return $this->loader->load('linkscrawler', $useragent);
        }

        if (preg_match('/(ssearch\_bot|sSearch Crawler)/', $useragent)) {
            return $this->loader->load('ssearch crawler', $useragent);
        }

        if (preg_match('/HRCrawler/', $useragent)) {
            return $this->loader->load('hrcrawler', $useragent);
        }

        if (preg_match('/ICC\-Crawler/', $useragent)) {
            return $this->loader->load('icc-crawler', $useragent);
        }

        if (preg_match('/Arachnida Web Crawler/', $useragent)) {
            return $this->loader->load('arachnida web crawler', $useragent);
        }

        if (preg_match('/Finderlein Research Crawler/', $useragent)) {
            return $this->loader->load('finderlein research crawler', $useragent);
        }

        if (preg_match('/TestCrawler/', $useragent)) {
            return $this->loader->load('testcrawler', $useragent);
        }

        if (preg_match('/Scopia Crawler/', $useragent)) {
            return $this->loader->load('scopia crawler', $useragent);
        }

        if (preg_match('/Crawler/', $useragent)) {
            return $this->loader->load('crawler', $useragent);
        }

        if (preg_match('/MetaJobBot/', $useragent)) {
            return $this->loader->load('metajobbot', $useragent);
        }

        if (preg_match('/jig browser web/', $useragent)) {
            return $this->loader->load('jig browser web', $useragent);
        }

        if (preg_match('/T\-H\-U\-N\-D\-E\-R\-S\-T\-O\-N\-E/', $useragent)) {
            return $this->loader->load('texis webscript', $useragent);
        }

        if (preg_match('/focuseekbot/', $useragent)) {
            return $this->loader->load('focuseekbot', $useragent);
        }

        if (preg_match('/vBSEO/', $useragent)) {
            return $this->loader->load('vbulletin seo bot', $useragent);
        }

        if (preg_match('/kgbody/', $useragent)) {
            return $this->loader->load('kgbody', $useragent);
        }

        if (preg_match('/JobdiggerSpider/', $useragent)) {
            return $this->loader->load('jobdiggerspider', $useragent);
        }

        if (preg_match('/imrbot/', $useragent)) {
            return $this->loader->load('mignify bot', $useragent);
        }

        if (preg_match('/kulturarw3/', $useragent)) {
            return $this->loader->load('kulturarw3', $useragent);
        }

        if (preg_match('/LucidWorks/', $useragent)) {
            return $this->loader->load('lucidworks bot', $useragent);
        }

        if (preg_match('/MerchantCentricBot/', $useragent)) {
            return $this->loader->load('merchantcentricbot', $useragent);
        }

        if (preg_match('/Nett\.io bot/', $useragent)) {
            return $this->loader->load('nett.io bot', $useragent);
        }

        if (preg_match('/SemanticBot/', $useragent)) {
            return $this->loader->load('semanticbot', $useragent);
        }

        if (preg_match('/tweetedtimes/i', $useragent)) {
            return $this->loader->load('tweetedtimes bot', $useragent);
        }

        if (preg_match('/vkShare/', $useragent)) {
            return $this->loader->load('vkshare', $useragent);
        }

        if (preg_match('/Yahoo Ad monitoring/', $useragent)) {
            return $this->loader->load('yahoo ad monitoring', $useragent);
        }

        if (preg_match('/YioopBot/', $useragent)) {
            return $this->loader->load('yioopbot', $useragent);
        }

        if (preg_match('/zitebot/', $useragent)) {
            return $this->loader->load('zitebot', $useragent);
        }

        if (preg_match('/Espial/', $useragent)) {
            return $this->loader->load('espial tv browser', $useragent);
        }

        if (preg_match('/SiteCon/', $useragent)) {
            return $this->loader->load('sitecon', $useragent);
        }

        if (preg_match('/iBooks Author/', $useragent)) {
            return $this->loader->load('ibooks author', $useragent);
        }

        if (preg_match('/iWeb/', $useragent)) {
            return $this->loader->load('iweb', $useragent);
        }

        if (preg_match('/NewsFire/', $useragent)) {
            return $this->loader->load('newsfire', $useragent);
        }

        if (preg_match('/RMSnapKit/', $useragent)) {
            return $this->loader->load('rmsnapkit', $useragent);
        }

        if (preg_match('/Sandvox/', $useragent)) {
            return $this->loader->load('sandvox', $useragent);
        }

        if (preg_match('/TubeTV/', $useragent)) {
            return $this->loader->load('tubetv', $useragent);
        }

        if (preg_match('/Elluminate Live/', $useragent)) {
            return $this->loader->load('elluminate live', $useragent);
        }

        if (preg_match('/Element Browser/', $useragent)) {
            return $this->loader->load('element browser', $useragent);
        }

        if (preg_match('/K\-Meleon/', $useragent)) {
            return $this->loader->load('k-meleon', $useragent);
        }

        if (preg_match('/Esribot/', $useragent)) {
            return $this->loader->load('esribot', $useragent);
        }

        if ($s->contains('quicklook', false)) {
            return $this->loader->load('quicklook', $useragent);
        }

        if (preg_match('/dillo/i', $useragent)) {
            return $this->loader->load('dillo', $useragent);
        }

        if (preg_match('/Digg/', $useragent)) {
            return $this->loader->load('digg bot', $useragent);
        }

        if (preg_match('/Zetakey/', $useragent)) {
            return $this->loader->load('zetakey browser', $useragent);
        }

        if (preg_match('/getprismatic\.com/', $useragent)) {
            return $this->loader->load('prismatic app', $useragent);
        }

        if (preg_match('/(FOMA|SH05C)/', $useragent)) {
            return $this->loader->load('sharp', $useragent);
        }

        if (preg_match('/OpenWebKitSharp/', $useragent)) {
            return $this->loader->load('open-webkit-sharp', $useragent);
        }

        if (preg_match('/AjaxSnapBot/', $useragent)) {
            return $this->loader->load('ajaxsnapbot', $useragent);
        }

        if (preg_match('/Owler/', $useragent)) {
            return $this->loader->load('owler bot', $useragent);
        }

        if (preg_match('/Yahoo Link Preview/', $useragent)) {
            return $this->loader->load('yahoo link preview', $useragent);
        }

        if (preg_match('/pub\-crawler/', $useragent)) {
            return $this->loader->load('pub-crawler', $useragent);
        }

        if (preg_match('/Kraken/', $useragent)) {
            return $this->loader->load('kraken', $useragent);
        }

        if (preg_match('/Qwantify/', $useragent)) {
            return $this->loader->load('qwantify', $useragent);
        }

        if (preg_match('/SetLinks bot/', $useragent)) {
            return $this->loader->load('setlinks.ru crawler', $useragent);
        }

        if (preg_match('/MegaIndex\.ru/', $useragent)) {
            return $this->loader->load('megaindex bot', $useragent);
        }

        if (preg_match('/Cliqzbot/', $useragent)) {
            return $this->loader->load('cliqzbot', $useragent);
        }

        if (preg_match('/DAWINCI ANTIPLAG SPIDER/', $useragent)) {
            return $this->loader->load('dawinci antiplag spider', $useragent);
        }

        if (preg_match('/AdvBot/', $useragent)) {
            return $this->loader->load('advbot', $useragent);
        }

        if (preg_match('/DuckDuckGo\-Favicons\-Bot/', $useragent)) {
            return $this->loader->load('duckduck favicons bot', $useragent);
        }

        if (preg_match('/ZyBorg/', $useragent)) {
            return $this->loader->load('wisenut search engine crawler', $useragent);
        }

        if (preg_match('/HyperCrawl/', $useragent)) {
            return $this->loader->load('hypercrawl', $useragent);
        }

        if (preg_match('/ARCHIVE\.ORG\.UA crawler/', $useragent)) {
            return $this->loader->load('internet archive', $useragent);
        }

        if (preg_match('/worldwebheritage/', $useragent)) {
            return $this->loader->load('worldwebheritage.org bot', $useragent);
        }

        if (preg_match('/BegunAdvertising/', $useragent)) {
            return $this->loader->load('begun advertising bot', $useragent);
        }

        if (preg_match('/TrendWinHttp/', $useragent)) {
            return $this->loader->load('trendwinhttp', $useragent);
        }

        if (preg_match('/(winhttp|winhttprequest)/i', $useragent)) {
            return $this->loader->load('winhttp', $useragent);
        }

        if (preg_match('/SkypeUriPreview/', $useragent)) {
            return $this->loader->load('skypeuripreview', $useragent);
        }

        if (preg_match('/ScoutJet/', $useragent)) {
            return $this->loader->load('scoutjet', $useragent);
        }

        if (preg_match('/Lipperhey\-Kaus\-Australis/', $useragent)) {
            return $this->loader->load('lipperhey kaus australis', $useragent);
        }

        if (preg_match('/Digincore bot/', $useragent)) {
            return $this->loader->load('digincore bot', $useragent);
        }

        if (preg_match('/Steeler/', $useragent)) {
            return $this->loader->load('steeler', $useragent);
        }

        if (preg_match('/Orangebot/', $useragent)) {
            return $this->loader->load('orangebot', $useragent);
        }

        if (preg_match('/Jasmine/', $useragent)) {
            return $this->loader->load('jasmine', $useragent);
        }

        if (preg_match('/electricmonk/', $useragent)) {
            return $this->loader->load('duedil crawler', $useragent);
        }

        if (preg_match('/yoozBot/', $useragent)) {
            return $this->loader->load('yoozbot', $useragent);
        }

        if (preg_match('/online\-webceo\-bot/', $useragent)) {
            return $this->loader->load('webceo bot', $useragent);
        }

        if (preg_match('/^Mozilla\/5\.0 \(.*\) Gecko\/.*\/\d+/', $useragent)
            && !preg_match('/Netscape/', $useragent)
        ) {
            return $this->loader->load('firefox', $useragent);
        }

        if (preg_match('/^Mozilla\/5\.0 \(.*rv:\d+\.\d+.*\) Gecko\/.*\//', $useragent)
            && !preg_match('/Netscape/', $useragent)
        ) {
            return $this->loader->load('firefox', $useragent);
        }

        if (preg_match('/Netscape/', $useragent)) {
            return $this->loader->load('netscape', $useragent);
        }

        if (preg_match('/^Mozilla\/5\.0$/', $useragent)) {
            return $this->loader->load('unknown', $useragent);
        }

        if (preg_match('/Virtuoso/', $useragent)) {
            return $this->loader->load('virtuoso', $useragent);
        }

        if (preg_match('/^Mozilla\/(3|4)\.\d+/', $useragent, $matches)
            && !preg_match('/(msie|android)/i', $useragent, $matches)
        ) {
            return $this->loader->load('netscape', $useragent);
        }

        if (preg_match('/^Dalvik\/\d/', $useragent)) {
            return $this->loader->load('dalvik', $useragent);
        }

        if (preg_match('/niki\-bot/', $useragent)) {
            return $this->loader->load('niki-bot', $useragent);
        }

        if (preg_match('/ContextAd Bot/', $useragent)) {
            return $this->loader->load('contextad bot', $useragent);
        }

        if (preg_match('/integrity/', $useragent)) {
            return $this->loader->load('integrity', $useragent);
        }

        if (preg_match('/masscan/', $useragent)) {
            return $this->loader->load('masscan', $useragent);
        }

        if (preg_match('/ZmEu/', $useragent)) {
            return $this->loader->load('zmeu', $useragent);
        }

        if (preg_match('/sogou web spider/i', $useragent)) {
            return $this->loader->load('sogou web spider', $useragent);
        }

        if (preg_match('/(OpenWave|UP\.Browser|UP\/)/', $useragent)) {
            return $this->loader->load('openwave mobile browser', $useragent);
        }

        if (preg_match('/(ObigoInternetBrowser|obigo\-browser|Obigo|Teleca)(\/|-)Q(\d+)/', $useragent)) {
            return $this->loader->load('obigo q', $useragent);
        }

        if (preg_match('/(Teleca|Obigo|MIC\/|AU\-MIC)/', $useragent)) {
            return $this->loader->load('teleca-obigo', $useragent);
        }

        if (preg_match('/DavClnt/', $useragent)) {
            return $this->loader->load('microsoft-webdav', $useragent);
        }

        if (preg_match('/XING\-contenttabreceiver/', $useragent)) {
            return $this->loader->load('xing contenttabreceiver', $useragent);
        }

        if (preg_match('/Slingstone/', $useragent)) {
            return $this->loader->load('yahoo slingstone', $useragent);
        }

        if (preg_match('/BOT for JCE/', $useragent)) {
            return $this->loader->load('bot for jce', $useragent);
        }

        if (preg_match('/Validator\.nu\/LV/', $useragent)) {
            return $this->loader->load('validator.nu/lv', $useragent);
        }

        if (preg_match('/Curb/', $useragent)) {
            return $this->loader->load('curb', $useragent);
        }

        if (preg_match('/link_thumbnailer/', $useragent)) {
            return $this->loader->load('link_thumbnailer', $useragent);
        }

        if (preg_match('/Ruby/', $useragent)) {
            return $this->loader->load('generic ruby crawler', $useragent);
        }

        if (preg_match('/securepoint cf/', $useragent)) {
            return $this->loader->load('securepoint content filter', $useragent);
        }

        if (preg_match('/sogou\-spider/i', $useragent)) {
            return $this->loader->load('sogou spider', $useragent);
        }

        if (preg_match('/rankflex/i', $useragent)) {
            return $this->loader->load('rankflex', $useragent);
        }

        if (preg_match('/domnutch/i', $useragent)) {
            return $this->loader->load('domnutch bot', $useragent);
        }

        if (preg_match('/discovered/i', $useragent)) {
            return $this->loader->load('discovered', $useragent);
        }

        if (preg_match('/nutch/i', $useragent)) {
            return $this->loader->load('nutch', $useragent);
        }

        if (preg_match('/boardreader favicon fetcher/i', $useragent)) {
            return $this->loader->load('boardreader favicon fetcher', $useragent);
        }

        if (preg_match('/checksite verification agent/i', $useragent)) {
            return $this->loader->load('checksite verification agent', $useragent);
        }

        if (preg_match('/experibot/i', $useragent)) {
            return $this->loader->load('experibot', $useragent);
        }

        if (preg_match('/feedblitz/i', $useragent)) {
            return $this->loader->load('feedblitz', $useragent);
        }

        if (preg_match('/rss2html/i', $useragent)) {
            return $this->loader->load('rss2html', $useragent);
        }

        if (preg_match('/feedlyapp/i', $useragent)) {
            return $this->loader->load('feedly app', $useragent);
        }

        if (preg_match('/genderanalyzer/i', $useragent)) {
            return $this->loader->load('genderanalyzer', $useragent);
        }

        if (preg_match('/gooblog/i', $useragent)) {
            return $this->loader->load('gooblog', $useragent);
        }

        if (preg_match('/tumblr/i', $useragent)) {
            return $this->loader->load('tumblr app', $useragent);
        }

        if (preg_match('/w3c\_i18n\-checker/i', $useragent)) {
            return $this->loader->load('w3c i18n checker', $useragent);
        }

        if (preg_match('/w3c\_unicorn/i', $useragent)) {
            return $this->loader->load('w3c unicorn', $useragent);
        }

        if (preg_match('/alltop/i', $useragent)) {
            return $this->loader->load('alltop app', $useragent);
        }

        if (preg_match('/internetseer/i', $useragent)) {
            return $this->loader->load('internetseer.com', $useragent);
        }

        if (preg_match('/ADmantX Platform Semantic Analyzer/', $useragent)) {
            return $this->loader->load('admantx platform semantic analyzer', $useragent);
        }

        if (preg_match('/UniversalFeedParser/', $useragent)) {
            return $this->loader->load('universalfeedparser', $useragent);
        }

        if (preg_match('/(binlar|larbin)/i', $useragent)) {
            return $this->loader->load('larbin', $useragent);
        }

        if (preg_match('/unityplayer/i', $useragent)) {
            return $this->loader->load('unity web player', $useragent);
        }

        if (preg_match('/WeSEE\:Search/', $useragent)) {
            return $this->loader->load('wesee:search', $useragent);
        }

        if (preg_match('/WeSEE\:Ads/', $useragent)) {
            return $this->loader->load('wesee:ads', $useragent);
        }

        if (preg_match('/A6\-Indexer/', $useragent)) {
            return $this->loader->load('a6-indexer', $useragent);
        }

        if (preg_match('/NerdyBot/', $useragent)) {
            return $this->loader->load('nerdybot', $useragent);
        }

        if (preg_match('/Peeplo Screenshot Bot/', $useragent)) {
            return $this->loader->load('peeplo screenshot bot', $useragent);
        }

        if (preg_match('/CCBot/', $useragent)) {
            return $this->loader->load('ccbot', $useragent);
        }

        if (preg_match('/visionutils/', $useragent)) {
            return $this->loader->load('visionutils', $useragent);
        }

        if (preg_match('/Feedly/', $useragent)) {
            return $this->loader->load('feedly feed fetcher', $useragent);
        }

        if (preg_match('/Photon/', $useragent)) {
            return $this->loader->load('photon', $useragent);
        }

        if (preg_match('/WDG\_Validator/', $useragent)) {
            return $this->loader->load('html validator', $useragent);
        }

        if (preg_match('/Aboundex/', $useragent)) {
            return $this->loader->load('aboundexbot', $useragent);
        }

        if (preg_match('/YisouSpider/', $useragent)) {
            return $this->loader->load('yisouspider', $useragent);
        }

        if (preg_match('/hivaBot/', $useragent)) {
            return $this->loader->load('hivabot', $useragent);
        }

        if (preg_match('/Comodo Spider/', $useragent)) {
            return $this->loader->load('comodo spider', $useragent);
        }

        if (preg_match('/OpenWebSpider/i', $useragent)) {
            return $this->loader->load('openwebspider', $useragent);
        }

        if (preg_match('/R6_CommentReader/i', $useragent)) {
            return $this->loader->load('r6 commentreader', $useragent);
        }

        if (preg_match('/R6_FeedFetcher/i', $useragent)) {
            return $this->loader->load('r6 feedfetcher', $useragent);
        }

        if (preg_match('/(psbot\-image|psbot\-page)/i', $useragent)) {
            return $this->loader->load('picsearch bot', $useragent);
        }

        if (preg_match('/Bloglovin/', $useragent)) {
            return $this->loader->load('bloglovin bot', $useragent);
        }

        if (preg_match('/viralvideochart/i', $useragent)) {
            return $this->loader->load('viralvideochart bot', $useragent);
        }

        if (preg_match('/MetaHeadersBot/', $useragent)) {
            return $this->loader->load('metaheadersbot', $useragent);
        }

        if (preg_match('/Zend_?Http_?Client/', $useragent)) {
            return $this->loader->load('zend_http_client', $useragent);
        }

        if (preg_match('/wget/i', $useragent)) {
            return $this->loader->load('wget', $useragent);
        }

        if (preg_match('/Scrapy/', $useragent)) {
            return $this->loader->load('scrapy', $useragent);
        }

        if (preg_match('/Moozilla/', $useragent)) {
            return $this->loader->load('moozilla', $useragent);
        }

        if (preg_match('/AntBot/', $useragent)) {
            return $this->loader->load('antbot', $useragent);
        }

        if (preg_match('/Browsershots/', $useragent)) {
            return $this->loader->load('browsershots', $useragent);
        }

        if (preg_match('/revolt/', $useragent)) {
            return $this->loader->load('bot revolt', $useragent);
        }

        if (preg_match('/pdrlabs/i', $useragent)) {
            return $this->loader->load('pdrlabs bot', $useragent);
        }

        if (preg_match('/elinks/i', $useragent)) {
            return $this->loader->load('elinks', $useragent);
        }

        if (preg_match('/Links/', $useragent)) {
            return $this->loader->load('links', $useragent);
        }

        if (preg_match('/Airmail/', $useragent)) {
            return $this->loader->load('airmail', $useragent);
        }

        if (preg_match('/SonyEricsson/', $useragent)) {
            return $this->loader->load('semc', $useragent);
        }

        if (preg_match('/WEB\.DE MailCheck/', $useragent)) {
            return $this->loader->load('web.de mailcheck', $useragent);
        }

        if (preg_match('/Screaming Frog SEO Spider/', $useragent)) {
            return $this->loader->load('screaming frog seo spider', $useragent);
        }

        if (preg_match('/AndroidDownloadManager/', $useragent)) {
            return $this->loader->load('android download manager', $useragent);
        }

        if (preg_match('/Go ([\d\.]+) package http/', $useragent)) {
            return $this->loader->load('go httpclient', $useragent);
        }

        if (preg_match('/Go-http-client/', $useragent)) {
            return $this->loader->load('go httpclient', $useragent);
        }

        if (preg_match('/Proxy Gear Pro/', $useragent)) {
            return $this->loader->load('proxy gear pro', $useragent);
        }

        if (preg_match('/WAP Browser\/MAUI/', $useragent)) {
            return $this->loader->load('maui wap browser', $useragent);
        }

        if (preg_match('/Tiny Tiny RSS/', $useragent)) {
            return $this->loader->load('tiny tiny rss', $useragent);
        }

        if (preg_match('/Readability/', $useragent)) {
            return $this->loader->load('readability', $useragent);
        }

        if (preg_match('/NSPlayer/', $useragent)) {
            return $this->loader->load('windows media player', $useragent);
        }

        if (preg_match('/Pingdom/', $useragent)) {
            return $this->loader->load('pingdom', $useragent);
        }

        if (preg_match('/crazywebcrawler/i', $useragent)) {
            return $this->loader->load('crazywebcrawler', $useragent);
        }

        if (preg_match('/GG PeekBot/', $useragent)) {
            return $this->loader->load('gg peekbot', $useragent);
        }

        if (preg_match('/iTunes/', $useragent)) {
            return $this->loader->load('itunes', $useragent);
        }

        if (preg_match('/LibreOffice/', $useragent)) {
            return $this->loader->load('libreoffice', $useragent);
        }

        if (preg_match('/OpenOffice/', $useragent)) {
            return $this->loader->load('openoffice', $useragent);
        }

        if (preg_match('/ThumbnailAgent/', $useragent)) {
            return $this->loader->load('thumbnailagent', $useragent);
        }

        if (preg_match('/LinkStats Bot/', $useragent)) {
            return $this->loader->load('linkstats bot', $useragent);
        }

        if (preg_match('/eZ Publish Link Validator/', $useragent)) {
            return $this->loader->load('ez publish link validator', $useragent);
        }

        if (preg_match('/ThumbSniper/', $useragent)) {
            return $this->loader->load('thumbsniper', $useragent);
        }

        if (preg_match('/stq\_bot/', $useragent)) {
            return $this->loader->load('searchteq bot', $useragent);
        }

        if (preg_match('/SNK Screenshot Bot/', $useragent)) {
            return $this->loader->load('save n keep screenshot bot', $useragent);
        }

        if (preg_match('/SynHttpClient/', $useragent)) {
            return $this->loader->load('synhttpclient', $useragent);
        }

        if (preg_match('/HTTPClient/', $useragent)) {
            return $this->loader->load('httpclient', $useragent);
        }

        if (preg_match('/T\-Online Browser/', $useragent)) {
            return $this->loader->load('t-online browser', $useragent);
        }

        if (preg_match('/ImplisenseBot/', $useragent)) {
            return $this->loader->load('implisensebot', $useragent);
        }

        if (preg_match('/BuiBui\-Bot/', $useragent)) {
            return $this->loader->load('buibui-bot', $useragent);
        }

        if (preg_match('/thumbshots\-de\-bot/', $useragent)) {
            return $this->loader->load('thumbshots-de-bot', $useragent);
        }

        if (preg_match('/python\-requests/', $useragent)) {
            return $this->loader->load('python-requests', $useragent);
        }

        if (preg_match('/Python\-urllib/', $useragent)) {
            return $this->loader->load('python-urllib', $useragent);
        }

        if (preg_match('/Bot\.AraTurka\.com/', $useragent)) {
            return $this->loader->load('bot.araturka.com', $useragent);
        }

        if (preg_match('/http\_requester/', $useragent)) {
            return $this->loader->load('http_requester', $useragent);
        }

        if (preg_match('/WhatWeb/', $useragent)) {
            return $this->loader->load('whatweb web scanner', $useragent);
        }

        if (preg_match('/isc header collector handlers/', $useragent)) {
            return $this->loader->load('isc header collector handlers', $useragent);
        }

        if (preg_match('/Thumbor/', $useragent)) {
            return $this->loader->load('thumbor', $useragent);
        }

        if (preg_match('/Forum Poster/', $useragent)) {
            return $this->loader->load('forum poster', $useragent);
        }

        if (preg_match('/crawler4j/', $useragent)) {
            return $this->loader->load('crawler4j', $useragent);
        }

        if (preg_match('/Facebot/', $useragent)) {
            return $this->loader->load('facebot', $useragent);
        }

        if (preg_match('/NetzCheckBot/', $useragent)) {
            return $this->loader->load('netzcheckbot', $useragent);
        }

        if (preg_match('/MIB/', $useragent)) {
            return $this->loader->load('motorola internet browser', $useragent);
        }

        if (preg_match('/facebookscraper/', $useragent)) {
            return $this->loader->load('facebookscraper', $useragent);
        }

        if (preg_match('/Zookabot/', $useragent)) {
            return $this->loader->load('zookabot', $useragent);
        }

        if (preg_match('/MetaURI/', $useragent)) {
            return $this->loader->load('metauri bot', $useragent);
        }

        if (preg_match('/FreeWebMonitoring SiteChecker/', $useragent)) {
            return $this->loader->load('freewebmonitoring sitechecker', $useragent);
        }

        if (preg_match('/IPv4Scan/', $useragent)) {
            return $this->loader->load('ipv4scan', $useragent);
        }

        if (preg_match('/RED/', $useragent)) {
            return $this->loader->load('redbot', $useragent);
        }

        if (preg_match('/domainsbot/', $useragent)) {
            return $this->loader->load('domainsbot', $useragent);
        }

        if (preg_match('/BUbiNG/', $useragent)) {
            return $this->loader->load('bubing bot', $useragent);
        }

        if (preg_match('/RamblerMail/', $useragent)) {
            return $this->loader->load('ramblermail bot', $useragent);
        }

        if (preg_match('/ichiro\/mobile/', $useragent)) {
            return $this->loader->load('ichiro mobile bot', $useragent);
        }

        if (preg_match('/ichiro/', $useragent)) {
            return $this->loader->load('ichiro bot', $useragent);
        }

        if (preg_match('/iisbot/', $useragent)) {
            return $this->loader->load('iis site analysis web crawler', $useragent);
        }

        if (preg_match('/JoobleBot/', $useragent)) {
            return $this->loader->load('jooblebot', $useragent);
        }

        if (preg_match('/Superfeedr bot/', $useragent)) {
            return $this->loader->load('superfeedr bot', $useragent);
        }

        if (preg_match('/FeedBurner/', $useragent)) {
            return $this->loader->load('feedburner', $useragent);
        }

        if (preg_match('/Fastladder/', $useragent)) {
            return $this->loader->load('fastladder', $useragent);
        }

        if (preg_match('/livedoor/', $useragent)) {
            return $this->loader->load('livedoor', $useragent);
        }

        if (preg_match('/Icarus6j/', $useragent)) {
            return $this->loader->load('icarus6j', $useragent);
        }

        if (preg_match('/wsr\-agent/', $useragent)) {
            return $this->loader->load('wsr-agent', $useragent);
        }

        if (preg_match('/Blogshares Spiders/', $useragent)) {
            return $this->loader->load('blogshares spiders', $useragent);
        }

        if (preg_match('/TinEye\-bot/', $useragent)) {
            return $this->loader->load('tineye bot', $useragent);
        }

        if (preg_match('/QuickiWiki/', $useragent)) {
            return $this->loader->load('quickiwiki bot', $useragent);
        }

        if (preg_match('/PycURL/', $useragent)) {
            return $this->loader->load('pycurl', $useragent);
        }

        if (preg_match('/libcurl\-agent/', $useragent)) {
            return $this->loader->load('libcurl', $useragent);
        }

        if (preg_match('/Taproot/', $useragent)) {
            return $this->loader->load('taproot bot', $useragent);
        }

        if (preg_match('/GuzzleHttp/', $useragent)) {
            return $this->loader->load('guzzle http client', $useragent);
        }

        if (preg_match('/curl/i', $useragent)) {
            return $this->loader->load('curl', $useragent);
        }

        if (preg_match('/^PHP/', $useragent)) {
            return $this->loader->load('php', $useragent);
        }

        if (preg_match('/Apple\-PubSub/', $useragent)) {
            return $this->loader->load('apple pubsub', $useragent);
        }

        if (preg_match('/SimplePie/', $useragent)) {
            return $this->loader->load('simplepie', $useragent);
        }

        if (preg_match('/BigBozz/', $useragent)) {
            return $this->loader->load('bigbozz - financial search', $useragent);
        }

        if (preg_match('/ECCP/', $useragent)) {
            return $this->loader->load('eccp', $useragent);
        }

        if (preg_match('/facebookexternalhit/', $useragent)) {
            return $this->loader->load('facebookexternalhit', $useragent);
        }

        if (preg_match('/GigablastOpenSource/', $useragent)) {
            return $this->loader->load('gigablast search engine', $useragent);
        }

        if (preg_match('/WebIndex/', $useragent)) {
            return $this->loader->load('webindex', $useragent);
        }

        if (preg_match('/Prince/', $useragent)) {
            return $this->loader->load('prince', $useragent);
        }

        if (preg_match('/adsense\-snapshot\-google/i', $useragent)) {
            return $this->loader->load('adsense snapshot bot', $useragent);
        }

        if (preg_match('/Amazon CloudFront/', $useragent)) {
            return $this->loader->load('amazon cloudfront', $useragent);
        }

        if (preg_match('/bandscraper/', $useragent)) {
            return $this->loader->load('bandscraper', $useragent);
        }

        if (preg_match('/bitlybot/', $useragent)) {
            return $this->loader->load('bitlybot', $useragent);
        }

        if (preg_match('/^bot$/', $useragent)) {
            return $this->loader->load('bot', $useragent);
        }

        if (preg_match('/cars\-app\-browser/', $useragent)) {
            return $this->loader->load('cars-app-browser', $useragent);
        }

        if (preg_match('/Coursera\-Mobile/', $useragent)) {
            return $this->loader->load('coursera mobile app', $useragent);
        }

        if (preg_match('/Crowsnest/', $useragent)) {
            return $this->loader->load('crowsnest mobile app', $useragent);
        }

        if (preg_match('/Dorado WAP\-Browser/', $useragent)) {
            return $this->loader->load('dorado wap browser', $useragent);
        }

        if (preg_match('/Goldfire Server/', $useragent)) {
            return $this->loader->load('goldfire server', $useragent);
        }

        if (preg_match('/EventMachine HttpClient/', $useragent)) {
            return $this->loader->load('eventmachine httpclient', $useragent);
        }

        if (preg_match('/iBall/', $useragent)) {
            return $this->loader->load('iball', $useragent);
        }

        if (preg_match('/InAGist URL Resolver/', $useragent)) {
            return $this->loader->load('inagist url resolver', $useragent);
        }

        if (preg_match('/Jeode/', $useragent)) {
            return $this->loader->load('jeode', $useragent);
        }

        if (preg_match('/kraken/', $useragent)) {
            return $this->loader->load('krakenjs', $useragent);
        }

        if (preg_match('/com\.linkedin/', $useragent)) {
            return $this->loader->load('linkedinbot', $useragent);
        }

        if (preg_match('/LivelapBot/', $useragent)) {
            return $this->loader->load('livelap crawler', $useragent);
        }

        if (preg_match('/MixBot/', $useragent)) {
            return $this->loader->load('mixbot', $useragent);
        }

        if (preg_match('/BuSecurityProject/', $useragent)) {
            return $this->loader->load('busecurityproject', $useragent);
        }

        if (preg_match('/PageFreezer/', $useragent)) {
            return $this->loader->load('pagefreezer', $useragent);
        }

        if (preg_match('/restify/', $useragent)) {
            return $this->loader->load('restify', $useragent);
        }

        if (preg_match('/ShowyouBot/', $useragent)) {
            return $this->loader->load('showyoubot', $useragent);
        }

        if (preg_match('/vlc/i', $useragent)) {
            return $this->loader->load('vlc media player', $useragent);
        }

        if (preg_match('/WebRingChecker/', $useragent)) {
            return $this->loader->load('webringchecker', $useragent);
        }

        if (preg_match('/bot\-pge\.chlooe\.com/', $useragent)) {
            return $this->loader->load('chlooe bot', $useragent);
        }

        if (preg_match('/seebot/', $useragent)) {
            return $this->loader->load('seebot', $useragent);
        }

        if (preg_match('/ltx71/', $useragent)) {
            return $this->loader->load('ltx71 bot', $useragent);
        }

        if (preg_match('/CookieReports/', $useragent)) {
            return $this->loader->load('cookie reports bot', $useragent);
        }

        if (preg_match('/Elmer/', $useragent)) {
            return $this->loader->load('elmer', $useragent);
        }

        if (preg_match('/Iframely/', $useragent)) {
            return $this->loader->load('iframely bot', $useragent);
        }

        if (preg_match('/MetaInspector/', $useragent)) {
            return $this->loader->load('metainspector', $useragent);
        }

        if (preg_match('/Microsoft\-CryptoAPI/', $useragent)) {
            return $this->loader->load('microsoft cryptoapi', $useragent);
        }

        if (preg_match('/OWASP\_SECRET\_BROWSER/', $useragent)) {
            return $this->loader->load('owasp_secret_browser', $useragent);
        }

        if (preg_match('/SMRF URL Expander/', $useragent)) {
            return $this->loader->load('smrf url expander', $useragent);
        }

        if (preg_match('/Speedy Spider/', $useragent)) {
            return $this->loader->load('entireweb', $useragent);
        }

        if (preg_match('/kizasi\-spider/', $useragent)) {
            return $this->loader->load('kizasi-spider', $useragent);
        }

        if (preg_match('/Superarama\.com \- BOT/', $useragent)) {
            return $this->loader->load('superarama.com - bot', $useragent);
        }

        if (preg_match('/WNMbot/', $useragent)) {
            return $this->loader->load('wnmbot', $useragent);
        }

        if (preg_match('/Website Explorer/', $useragent)) {
            return $this->loader->load('website explorer', $useragent);
        }

        if (preg_match('/city\-map screenshot service/', $useragent)) {
            return $this->loader->load('city-map screenshot service', $useragent);
        }

        if (preg_match('/gosquared\-thumbnailer/', $useragent)) {
            return $this->loader->load('gosquared-thumbnailer', $useragent);
        }

        if (preg_match('/optivo\(R\) NetHelper/', $useragent)) {
            return $this->loader->load('optivo nethelper', $useragent);
        }

        if (preg_match('/pr\-cy\.ru Screenshot Bot/', $useragent)) {
            return $this->loader->load('screenshot bot', $useragent);
        }

        if (preg_match('/Cyberduck/', $useragent)) {
            return $this->loader->load('cyberduck', $useragent);
        }

        if (preg_match('/Lynx/', $useragent)) {
            return $this->loader->load('lynx', $useragent);
        }

        if (preg_match('/AccServer/', $useragent)) {
            return $this->loader->load('accserver', $useragent);
        }

        if (preg_match('/SafeSearch microdata crawler/', $useragent)) {
            return $this->loader->load('safesearch microdata crawler', $useragent);
        }

        if (preg_match('/iZSearch/', $useragent)) {
            return $this->loader->load('izsearch bot', $useragent);
        }

        if (preg_match('/NetLyzer FastProbe/', $useragent)) {
            return $this->loader->load('netlyzer fastprobe', $useragent);
        }

        if (preg_match('/MnoGoSearch/', $useragent)) {
            return $this->loader->load('mnogosearch', $useragent);
        }

        if (preg_match('/uipbot/', $useragent)) {
            return $this->loader->load('uipbot', $useragent);
        }

        if (preg_match('/mbot/', $useragent)) {
            return $this->loader->load('mbot', $useragent);
        }

        if (preg_match('/MS Web Services Client Protocol/', $useragent)) {
            return $this->loader->load('.net framework clr', $useragent);
        }

        if (preg_match('/(AtomicBrowser|AtomicLite)/', $useragent)) {
            return $this->loader->load('atomic browser', $useragent);
        }

        if (preg_match('/AppEngine\-Google/', $useragent)) {
            return $this->loader->load('google app engine', $useragent);
        }

        if (preg_match('/Feedfetcher\-Google/', $useragent)) {
            return $this->loader->load('google feedfetcher', $useragent);
        }

        if (preg_match('/Google/', $useragent)) {
            return $this->loader->load('google app', $useragent);
        }

        if (preg_match('/UnwindFetchor/', $useragent)) {
            return $this->loader->load('unwindfetchor', $useragent);
        }

        if (preg_match('/Perfect%20Browser/', $useragent)) {
            return $this->loader->load('perfect browser', $useragent);
        }

        if (preg_match('/Reeder/', $useragent)) {
            return $this->loader->load('reeder', $useragent);
        }

        if (preg_match('/FastBrowser/', $useragent)) {
            return $this->loader->load('fastbrowser', $useragent);
        }

        if (preg_match('/CFNetwork/', $useragent)) {
            return $this->loader->load('cfnetwork', $useragent);
        }

        if (preg_match('/Y\!J\-(ASR|BSC)/', $useragent)) {
            return $this->loader->load('yahoo! japan', $useragent);
        }

        if (preg_match('/test certificate info/', $useragent)) {
            return $this->loader->load('test certificate info', $useragent);
        }

        if (preg_match('/fastbot crawler/', $useragent)) {
            return $this->loader->load('fastbot crawler', $useragent);
        }

        if (preg_match('/Riddler/', $useragent)) {
            return $this->loader->load('riddler', $useragent);
        }

        if (preg_match('/SophosUpdateManager/', $useragent)) {
            return $this->loader->load('sophosupdatemanager', $useragent);
        }

        if (preg_match('/(Debian|Ubuntu) APT\-HTTP/', $useragent)) {
            return $this->loader->load('apt http transport', $useragent);
        }

        if (preg_match('/urlgrabber/', $useragent)) {
            return $this->loader->load('url grabber', $useragent);
        }

        if (preg_match('/UCS \(ESX\)/', $useragent)) {
            return $this->loader->load('univention corporate server', $useragent);
        }

        if (preg_match('/libwww\-perl/', $useragent)) {
            return $this->loader->load('libwww', $useragent);
        }

        if (preg_match('/OpenBSD ftp/', $useragent)) {
            return $this->loader->load('openbsd ftp', $useragent);
        }

        if (preg_match('/SophosAgent/', $useragent)) {
            return $this->loader->load('sophosagent', $useragent);
        }

        if (preg_match('/jupdate/', $useragent)) {
            return $this->loader->load('jupdate', $useragent);
        }

        if (preg_match('/Roku\/DVP/', $useragent)) {
            return $this->loader->load('roku dvp', $useragent);
        }

        if (preg_match('/VocusBot/', $useragent)) {
            return $this->loader->load('vocusbot', $useragent);
        }

        if (preg_match('/PostRank/', $useragent)) {
            return $this->loader->load('postrank', $useragent);
        }

        if (preg_match('/rogerbot/i', $useragent)) {
            return $this->loader->load('rogerbot', $useragent);
        }

        if (preg_match('/Safeassign/', $useragent)) {
            return $this->loader->load('safeassign', $useragent);
        }

        if (preg_match('/ExaleadCloudView/', $useragent)) {
            return $this->loader->load('exalead cloudview', $useragent);
        }

        if (preg_match('/Typhoeus/', $useragent)) {
            return $this->loader->load('typhoeus', $useragent);
        }

        if (preg_match('/Camo Asset Proxy/', $useragent)) {
            return $this->loader->load('camo asset proxy', $useragent);
        }

        if (preg_match('/YahooCacheSystem/', $useragent)) {
            return $this->loader->load('yahoocachesystem', $useragent);
        }

        if (preg_match('/wmtips\.com/', $useragent)) {
            return $this->loader->load('webmaster tips bot', $useragent);
        }

        if (preg_match('/linkCheck/', $useragent)) {
            return $this->loader->load('linkcheck', $useragent);
        }

        if (preg_match('/ABrowse/', $useragent)) {
            return $this->loader->load('abrowse', $useragent);
        }

        if (preg_match('/GWPImages/', $useragent)) {
            return $this->loader->load('gwpimages', $useragent);
        }

        if (preg_match('/NoteTextView/', $useragent)) {
            return $this->loader->load('notetextview', $useragent);
        }

        if (preg_match('/NING/', $useragent)) {
            return $this->loader->load('ning', $useragent);
        }

        if (preg_match('/Sprinklr/', $useragent)) {
            return $this->loader->load('sprinklr', $useragent);
        }

        if (preg_match('/URLChecker/', $useragent)) {
            return $this->loader->load('urlchecker', $useragent);
        }

        if (preg_match('/newsme/', $useragent)) {
            return $this->loader->load('newsme', $useragent);
        }

        if (preg_match('/Traackr/', $useragent)) {
            return $this->loader->load('traackr', $useragent);
        }

        if (preg_match('/nineconnections/', $useragent)) {
            return $this->loader->load('nineconnections', $useragent);
        }

        if (preg_match('/Xenu Link Sleuth/', $useragent)) {
            return $this->loader->load('xenus link sleuth', $useragent);
        }

        if (preg_match('/superagent/', $useragent)) {
            return $this->loader->load('superagent', $useragent);
        }

        if (preg_match('/Goose/', $useragent)) {
            return $this->loader->load('goose-extractor', $useragent);
        }

        if (preg_match('/AHC/', $useragent)) {
            return $this->loader->load('asynchronous http client', $useragent);
        }

        if (preg_match('/newspaper/', $useragent)) {
            return $this->loader->load('newspaper', $useragent);
        }

        if (preg_match('/Hatena::Bookmark/', $useragent)) {
            return $this->loader->load('hatena::bookmark', $useragent);
        }

        if (preg_match('/EasyBib AutoCite/', $useragent)) {
            return $this->loader->load('easybib autocite', $useragent);
        }

        if (preg_match('/ShortLinkTranslate/', $useragent)) {
            return $this->loader->load('shortlinktranslate', $useragent);
        }

        if (preg_match('/Marketing Grader/', $useragent)) {
            return $this->loader->load('marketing grader', $useragent);
        }

        if (preg_match('/Grammarly/', $useragent)) {
            return $this->loader->load('grammarly', $useragent);
        }

        if (preg_match('/Dispatch/', $useragent)) {
            return $this->loader->load('dispatch', $useragent);
        }

        if (preg_match('/Raven Link Checker/', $useragent)) {
            return $this->loader->load('raven link checker', $useragent);
        }

        if (preg_match('/http\-kit/', $useragent)) {
            return $this->loader->load('http kit', $useragent);
        }

        if (preg_match('/sfFeedReader/', $useragent)) {
            return $this->loader->load('symfony rss reader', $useragent);
        }

        if (preg_match('/Twikle/', $useragent)) {
            return $this->loader->load('twikle bot', $useragent);
        }

        if (preg_match('/node\-fetch/', $useragent)) {
            return $this->loader->load('node-fetch', $useragent);
        }

        if (preg_match('/BrokenLinkCheck\.com/', $useragent)) {
            return $this->loader->load('brokenlinkcheck', $useragent);
        }

        if (preg_match('/BCKLINKS/', $useragent)) {
            return $this->loader->load('bcklinks', $useragent);
        }

        if (preg_match('/Faraday/', $useragent)) {
            return $this->loader->load('faraday', $useragent);
        }

        if (preg_match('/gettor/', $useragent)) {
            return $this->loader->load('gettor', $useragent);
        }

        if (preg_match('/SEOstats/', $useragent)) {
            return $this->loader->load('seostats', $useragent);
        }

        if (preg_match('/ZnajdzFoto\/Image/', $useragent)) {
            return $this->loader->load('znajdzfoto/imagebot', $useragent);
        }

        if (preg_match('/infoX\-WISG/', $useragent)) {
            return $this->loader->load('infox-wisg', $useragent);
        }

        if (preg_match('/wscheck\.com/', $useragent)) {
            return $this->loader->load('wscheck bot', $useragent);
        }

        if (preg_match('/Tweetminster/', $useragent)) {
            return $this->loader->load('tweetminster bot', $useragent);
        }

        if (preg_match('/Astute SRM/', $useragent)) {
            return $this->loader->load('astute social', $useragent);
        }

        if (preg_match('/LongURL API/', $useragent)) {
            return $this->loader->load('longurl bot', $useragent);
        }

        if (preg_match('/Trove/', $useragent)) {
            return $this->loader->load('trove bot', $useragent);
        }

        if (preg_match('/Melvil Favicon/', $useragent)) {
            return $this->loader->load('melvil favicon bot', $useragent);
        }

        if (preg_match('/Melvil/', $useragent)) {
            return $this->loader->load('melvil bot', $useragent);
        }

        if (preg_match('/Pearltrees/', $useragent)) {
            return $this->loader->load('pearltrees bot', $useragent);
        }

        if (preg_match('/Svven\-Summarizer/', $useragent)) {
            return $this->loader->load('svven summarizer bot', $useragent);
        }

        if (preg_match('/Athena Site Analyzer/', $useragent)) {
            return $this->loader->load('athena site analyzer', $useragent);
        }

        if (preg_match('/Exploratodo/', $useragent)) {
            return $this->loader->load('exploratodo bot', $useragent);
        }

        if (preg_match('/WhatsApp/', $useragent)) {
            return $this->loader->load('whatsapp', $useragent);
        }

        if (preg_match('/DDG\-Android\-/', $useragent)) {
            return $this->loader->load('duckduck app', $useragent);
        }

        if (preg_match('/WebCorp/', $useragent)) {
            return $this->loader->load('webcorp', $useragent);
        }

        if (preg_match('/ROR Sitemap Generator/', $useragent)) {
            return $this->loader->load('ror sitemap generator', $useragent);
        }

        if (preg_match('/AuditMyPC Webmaster Tool/', $useragent)) {
            return $this->loader->load('auditmypc webmaster tool', $useragent);
        }

        if (preg_match('/XmlSitemapGenerator/', $useragent)) {
            return $this->loader->load('xmlsitemapgenerator', $useragent);
        }

        if (preg_match('/Stratagems Kumo/', $useragent)) {
            return $this->loader->load('stratagems kumo', $useragent);
        }

        if (preg_match('/YOURLS/', $useragent)) {
            return $this->loader->load('yourls', $useragent);
        }

        if (preg_match('/Embed PHP Library/', $useragent)) {
            return $this->loader->load('embed php library', $useragent);
        }

        if (preg_match('/SPIP/', $useragent)) {
            return $this->loader->load('spip', $useragent);
        }

        if (preg_match('/Friendica/', $useragent)) {
            return $this->loader->load('friendica', $useragent);
        }

        if (preg_match('/MagpieRSS/', $useragent)) {
            return $this->loader->load('magpierss', $useragent);
        }

        if (preg_match('/Short URL Checker/', $useragent)) {
            return $this->loader->load('short url checker', $useragent);
        }

        if (preg_match('/webnumbrFetcher/', $useragent)) {
            return $this->loader->load('webnumbr fetcher', $useragent);
        }

        if (preg_match('/(WAP Browser|Spice QT\-75|KKT20\/MIDP)/', $useragent)) {
            return $this->loader->load('wap browser', $useragent);
        }

        if (preg_match('/java/i', $useragent)) {
            return $this->loader->load('java', $useragent);
        }

        if (preg_match('/(unister\-test|unistertesting|unister\-https\-test)/i', $useragent)) {
            return $this->loader->load('unistertesting', $useragent);
        }

        if (preg_match('/AdMuncher/', $useragent)) {
            return $this->loader->load('ad muncher', $useragent);
        }

        if (preg_match('/AdvancedEmailExtractor/', $useragent)) {
            return $this->loader->load('advanced email extractor', $useragent);
        }

        if (preg_match('/AiHitBot/', $useragent)) {
            return $this->loader->load('aihitbot', $useragent);
        }

        if (preg_match('/Alcatel/', $useragent)) {
            return $this->loader->load('alcatel', $useragent);
        }

        if (preg_match('/AlcoholSearch/', $useragent)) {
            return $this->loader->load('alcohol search', $useragent);
        }

        if (preg_match('/ApacheHttpClient/', $useragent)) {
            return $this->loader->load('apache-httpclient', $useragent);
        }

        if (preg_match('/ArchiveDeBot/', $useragent)) {
            return $this->loader->load('internet archive de', $useragent);
        }

        if (preg_match('/Argclrint/', $useragent)) {
            return $this->loader->load('argclrint', $useragent);
        }

        if (preg_match('/AskBot/', $useragent)) {
            return $this->loader->load('ask bot', $useragent);
        }

        if (preg_match('/AugustBot/', $useragent)) {
            return $this->loader->load('augustbot', $useragent);
        }

        if (preg_match('/Awesomebot/', $useragent)) {
            return $this->loader->load('awesomebot', $useragent);
        }

        if (preg_match('/BaiduSpider/', $useragent)) {
            return $this->loader->load('baiduspider', $useragent);
        }

        if (preg_match('/Benq/', $useragent)) {
            return $this->loader->load('benq', $useragent);
        }

        if (preg_match('/Billigfluegefinal/', $useragent)) {
            return $this->loader->load('billigfluegefinal app', $useragent);
        }

        if (preg_match('/BingProductsBot/', $useragent)) {
            return $this->loader->load('bing product search', $useragent);
        }

        if (preg_match('/BlitzBot/', $useragent)) {
            return $this->loader->load('blitzbot', $useragent);
        }

        if (preg_match('/BluecoatDrtr/', $useragent)) {
            return $this->loader->load('dynamic realtime rating', $useragent);
        }

        if (preg_match('/BndCrawler/', $useragent)) {
            return $this->loader->load('bnd crawler', $useragent);
        }

        if (preg_match('/BoardReader/', $useragent)) {
            return $this->loader->load('boardreader', $useragent);
        }

        if (preg_match('/Boxee/', $useragent)) {
            return $this->loader->load('boxee', $useragent);
        }

        if (preg_match('/Browser360/', $useragent)) {
            return $this->loader->load('360 browser', $useragent);
        }

        if (preg_match('/Bwc/', $useragent)) {
            return $this->loader->load('bwc', $useragent);
        }

        if (preg_match('/Camcrawler/', $useragent)) {
            return $this->loader->load('camcrawler', $useragent);
        }

        if (preg_match('/CamelHttpStream/', $useragent)) {
            return $this->loader->load('camelhttpstream', $useragent);
        }

        if (preg_match('/Charlotte/', $useragent)) {
            return $this->loader->load('charlotte', $useragent);
        }

        if (preg_match('/CheckLinks/', $useragent)) {
            return $this->loader->load('checklinks', $useragent);
        }

        if (preg_match('/Choosy/', $useragent)) {
            return $this->loader->load('choosy', $useragent);
        }

        if (preg_match('/ClarityDailyBot/', $useragent)) {
            return $this->loader->load('claritydailybot', $useragent);
        }

        if (preg_match('/Clipish/', $useragent)) {
            return $this->loader->load('clipish', $useragent);
        }

        if (preg_match('/CloudSurfer/', $useragent)) {
            return $this->loader->load('cloudsurfer', $useragent);
        }

        if (preg_match('/CommonCrawl/', $useragent)) {
            return $this->loader->load('commoncrawl', $useragent);
        }

        if (preg_match('/ComodoCertificatesSpider/', $useragent)) {
            return $this->loader->load('comodo-certificates-spider', $useragent);
        }

        if (preg_match('/CompSpyBot/', $useragent)) {
            return $this->loader->load('compspybot', $useragent);
        }

        if (preg_match('/CoobyBot/', $useragent)) {
            return $this->loader->load('coobybot', $useragent);
        }

        if (preg_match('/CoreClassHttpClientCached/', $useragent)) {
            return $this->loader->load('core_class_httpclient_cached', $useragent);
        }

        if (preg_match('/Coverscout/', $useragent)) {
            return $this->loader->load('coverscout', $useragent);
        }

        if (preg_match('/CrystalSemanticsBot/', $useragent)) {
            return $this->loader->load('crystalsemanticsbot', $useragent);
        }

        if (preg_match('/CurlPhp/', $useragent)) {
            return $this->loader->load('curl php', $useragent);
        }

        if (preg_match('/CydralWebImageSearch/', $useragent)) {
            return $this->loader->load('cydral web image search', $useragent);
        }

        if (preg_match('/DarwinBrowser/', $useragent)) {
            return $this->loader->load('darwin browser', $useragent);
        }

        if (preg_match('/DCPbot/', $useragent)) {
            return $this->loader->load('dcpbot', $useragent);
        }

        if (preg_match('/Delibar/', $useragent)) {
            return $this->loader->load('delibar', $useragent);
        }

        if (preg_match('/Diga/', $useragent)) {
            return $this->loader->load('diga', $useragent);
        }

        if (preg_match('/DoCoMo/', $useragent)) {
            return $this->loader->load('docomo', $useragent);
        }

        if (preg_match('/DomainCrawler/', $useragent)) {
            return $this->loader->load('domaincrawler', $useragent);
        }

        if (preg_match('/Elefent/', $useragent)) {
            return $this->loader->load('elefent', $useragent);
        }

        if (preg_match('/ElisaBot/', $useragent)) {
            return $this->loader->load('elisabot', $useragent);
        }

        if (preg_match('/Eudora/', $useragent)) {
            return $this->loader->load('eudora', $useragent);
        }

        if (preg_match('/EuripBot/', $useragent)) {
            return $this->loader->load('europe internet portal', $useragent);
        }

        if (preg_match('/EventGuruBot/', $useragent)) {
            return $this->loader->load('eventguru bot', $useragent);
        }

        if (preg_match('/ExbLanguageCrawler/', $useragent)) {
            return $this->loader->load('exb language crawler', $useragent);
        }

        if (preg_match('/Extras4iMovie/', $useragent)) {
            return $this->loader->load('extras4imovie', $useragent);
        }

        if (preg_match('/FaceBookBot/', $useragent)) {
            return $this->loader->load('facebook bot', $useragent);
        }

        if (preg_match('/FalkMaps/', $useragent)) {
            return $this->loader->load('falkmaps', $useragent);
        }

        if (preg_match('/FeedFinder/', $useragent)) {
            return $this->loader->load('feedfinder', $useragent);
        }

        if (preg_match('/Findlinks/', $useragent)) {
            return $this->loader->load('findlinks', $useragent);
        }

        if (preg_match('/Firebird/', $useragent)) {
            return $this->loader->load('firebird', $useragent);
        }

        if (preg_match('/Genieo/', $useragent)) {
            return $this->loader->load('genieo', $useragent);
        }

        if (preg_match('/GenieoWebFilter/', $useragent)) {
            return $this->loader->load('genieo web filter', $useragent);
        }

        if (preg_match('/Getleft/', $useragent)) {
            return $this->loader->load('getleft', $useragent);
        }

        if (preg_match('/GetPhotos/', $useragent)) {
            return $this->loader->load('getphotos', $useragent);
        }

        if (preg_match('/Godzilla/', $useragent)) {
            return $this->loader->load('godzilla', $useragent);
        }

        if (preg_match('/Google/', $useragent)) {
            return $this->loader->load('google', $useragent);
        }

        if (preg_match('/GoogleAdsbot/', $useragent)) {
            return $this->loader->load('adsbot google', $useragent);
        }

        if (preg_match('/GoogleEarth/', $useragent)) {
            return $this->loader->load('google earth', $useragent);
        }

        if (preg_match('/GoogleFontAnalysis/', $useragent)) {
            return $this->loader->load('google fontanalysis', $useragent);
        }

        if (preg_match('/GoogleImageProxy/', $useragent)) {
            return $this->loader->load('google image proxy', $useragent);
        }

        if (preg_match('/GoogleMarkupTester/', $useragent)) {
            return $this->loader->load('google markup tester', $useragent);
        }

        if (preg_match('/GooglePageSpeed/', $useragent)) {
            return $this->loader->load('google page speed', $useragent);
        }

        if (preg_match('/GoogleSitemaps/', $useragent)) {
            return $this->loader->load('google sitemaps', $useragent);
        }

        if (preg_match('/GoogleTv/', $useragent)) {
            return $this->loader->load('googletv', $useragent);
        }

        if (preg_match('/Grindr/', $useragent)) {
            return $this->loader->load('grindr', $useragent);
        }

        if (preg_match('/GSLFbot/', $useragent)) {
            return $this->loader->load('gslfbot', $useragent);
        }

        if (preg_match('/HaosouSpider/', $useragent)) {
            return $this->loader->load('haosouspider', $useragent);
        }

        if (preg_match('/HbbTv/', $useragent)) {
            return $this->loader->load('hbbtv', $useragent);
        }

        if (preg_match('/Heritrix/', $useragent)) {
            return $this->loader->load('heritrix', $useragent);
        }

        if (preg_match('/HitLeapViewer/', $useragent)) {
            return $this->loader->load('hitleap viewer', $useragent);
        }

        if (preg_match('/Hitpad/', $useragent)) {
            return $this->loader->load('hitpad', $useragent);
        }

        if (preg_match('/HotWallpapers/', $useragent)) {
            return $this->loader->load('hot wallpapers', $useragent);
        }

        if (preg_match('/Ibisbrowser/', $useragent)) {
            return $this->loader->load('ibisbrowser', $useragent);
        }

        if (preg_match('/Ibrowse/', $useragent)) {
            return $this->loader->load('ibrowse', $useragent);
        }

        if (preg_match('/Ibuilder/', $useragent)) {
            return $this->loader->load('ibuilder', $useragent);
        }

        if (preg_match('/Icedove/', $useragent)) {
            return $this->loader->load('icedove', $useragent);
        }

        if (preg_match('/Iceowl/', $useragent)) {
            return $this->loader->load('iceowl', $useragent);
        }

        if (preg_match('/Ichromy/', $useragent)) {
            return $this->loader->load('ichromy', $useragent);
        }

        if (preg_match('/IcjobsCrawler/', $useragent)) {
            return $this->loader->load('icjobs crawler', $useragent);
        }

        if (preg_match('/ImageMobile/', $useragent)) {
            return $this->loader->load('imagemobile', $useragent);
        }

        if (preg_match('/ImageSearcherS/', $useragent)) {
            return $this->loader->load('imagesearchers', $useragent);
        }

        if (preg_match('/Incredimail/', $useragent)) {
            return $this->loader->load('incredimail', $useragent);
        }

        if (preg_match('/IndyLibrary/', $useragent)) {
            return $this->loader->load('indy library', $useragent);
        }

        if (preg_match('/InettvBrowser/', $useragent)) {
            return $this->loader->load('inettvbrowser', $useragent);
        }

        if (preg_match('/InfohelferCrawler/', $useragent)) {
            return $this->loader->load('infohelfer crawler', $useragent);
        }

        if (preg_match('/InsiteRobot/', $useragent)) {
            return $this->loader->load('insite robot', $useragent);
        }

        if (preg_match('/Insitesbot/', $useragent)) {
            return $this->loader->load('insitesbot', $useragent);
        }

        if (preg_match('/IntegromedbCrawler/', $useragent)) {
            return $this->loader->load('integromedb crawler', $useragent);
        }

        if (preg_match('/InternetArchive/', $useragent)) {
            return $this->loader->load('internet archive bot', $useragent);
        }

        if (preg_match('/Ipick/', $useragent)) {
            return $this->loader->load('ipick', $useragent);
        }

        if (preg_match('/Isource/', $useragent)) {
            return $this->loader->load('isource+ app', $useragent);
        }

        if (preg_match('/JakartaCommonsHttpClient/', $useragent)) {
            return $this->loader->load('jakarta commons httpclient', $useragent);
        }

        if (preg_match('/JigsawCssValidator/', $useragent)) {
            return $this->loader->load('jigsaw css validator', $useragent);
        }

        if (preg_match('/JustCrawler/', $useragent)) {
            return $this->loader->load('just-crawler', $useragent);
        }

        if (preg_match('/Kindle/', $useragent)) {
            return $this->loader->load('kindle', $useragent);
        }

        if (preg_match('/Linguatools/', $useragent)) {
            return $this->loader->load('linguatoolsbot', $useragent);
        }

        if (preg_match('/LingueeBot/', $useragent)) {
            return $this->loader->load('linguee bot', $useragent);
        }

        if (preg_match('/LinkCheckerBot/', $useragent)) {
            return $this->loader->load('link-checker', $useragent);
        }

        if (preg_match('/LinkdexComBot/', $useragent)) {
            return $this->loader->load('linkdex bot', $useragent);
        }

        if (preg_match('/LinkLint/', $useragent)) {
            return $this->loader->load('linklint', $useragent);
        }

        if (preg_match('/LinkWalkerBot/', $useragent)) {
            return $this->loader->load('linkwalker', $useragent);
        }

        if (preg_match('/LittleBookmarkBox/', $useragent)) {
            return $this->loader->load('little-bookmark-box app', $useragent);
        }

        if (preg_match('/LtBot/', $useragent)) {
            return $this->loader->load('ltbot', $useragent);
        }

        if (preg_match('/MacInroyPrivacyAuditors/', $useragent)) {
            return $this->loader->load('macinroy privacy auditors', $useragent);
        }

        if (preg_match('/MaemoBrowser/', $useragent)) {
            return $this->loader->load('maemo browser', $useragent);
        }

        if (preg_match('/MagpieCrawler/', $useragent)) {
            return $this->loader->load('magpie crawler', $useragent);
        }

        if (preg_match('/MailExchangeWebServices/', $useragent)) {
            return $this->loader->load('mail exchangewebservices', $useragent);
        }

        if (preg_match('/Maven/', $useragent)) {
            return $this->loader->load('maven', $useragent);
        }

        if (preg_match('/Mechanize/', $useragent)) {
            return $this->loader->load('mechanize', $useragent);
        }

        if (preg_match('/MicrosoftWindowsNetworkDiagnostics/', $useragent)) {
            return $this->loader->load('microsoft windows network diagnostics', $useragent);
        }

        if (preg_match('/Mitsubishi/', $useragent)) {
            return $this->loader->load('mitsubishi', $useragent);
        }

        if (preg_match('/Mjbot/', $useragent)) {
            return $this->loader->load('mjbot', $useragent);
        }

        if (preg_match('/Mobilerss/', $useragent)) {
            return $this->loader->load('mobilerss', $useragent);
        }

        if (preg_match('/MovableType/', $useragent)) {
            return $this->loader->load('movabletype web log', $useragent);
        }

        if (preg_match('/Mozad/', $useragent)) {
            return $this->loader->load('mozad', $useragent);
        }

        if (preg_match('/archive\-de\.com/', $useragent)) {
            return $this->loader->load('archive-de.com', $useragent);
        }

        if (preg_match('/Mozilla/', $useragent)) {
            return $this->loader->load('mozilla', $useragent);
        }

        if (preg_match('/MsieCrawler/', $useragent)) {
            return $this->loader->load('msiecrawler', $useragent);
        }

        if (preg_match('/MsSearch/', $useragent)) {
            return $this->loader->load('ms search', $useragent);
        }

        if (preg_match('/MyEnginesBot/', $useragent)) {
            return $this->loader->load('myengines bot', $useragent);
        }

        if (preg_match('/Nec/', $useragent)) {
            return $this->loader->load('nec', $useragent);
        }

        if (preg_match('/Netbox/', $useragent)) {
            return $this->loader->load('netbox', $useragent);
        }

        if (preg_match('/NetNewsWire/', $useragent)) {
            return $this->loader->load('netnewswire', $useragent);
        }

        if (preg_match('/NetPositive/', $useragent)) {
            return $this->loader->load('netpositive', $useragent);
        }

        if (preg_match('/NetSurf/', $useragent)) {
            return $this->loader->load('netsurf', $useragent);
        }

        if (preg_match('/NetTv/', $useragent)) {
            return $this->loader->load('nettv', $useragent);
        }

        if (preg_match('/Netvibes/', $useragent)) {
            return $this->loader->load('netvibes', $useragent);
        }

        if (preg_match('/NewsBot/', $useragent)) {
            return $this->loader->load('news bot', $useragent);
        }

        if (preg_match('/NewsRack/', $useragent)) {
            return $this->loader->load('newsrack', $useragent);
        }

        if (preg_match('/NixGibts/', $useragent)) {
            return $this->loader->load('nixgibts', $useragent);
        }

        if (preg_match('/NodeJsHttpRequest/', $useragent)) {
            return $this->loader->load('node.js http_request', $useragent);
        }

        if (preg_match('/OnePassword/', $useragent)) {
            return $this->loader->load('1password', $useragent);
        }

        if (preg_match('/OpenVas/', $useragent)) {
            return $this->loader->load('open vulnerability assessment system', $useragent);
        }

        if (preg_match('/OpenWeb/', $useragent)) {
            return $this->loader->load('openweb', $useragent);
        }

        if (preg_match('/Origin/', $useragent)) {
            return $this->loader->load('origin', $useragent);
        }

        if (preg_match('/OssProxy/', $useragent)) {
            return $this->loader->load('ossproxy', $useragent);
        }

        if (preg_match('/Pagebull/', $useragent)) {
            return $this->loader->load('pagebull', $useragent);
        }

        if (preg_match('/PalmPixi/', $useragent)) {
            return $this->loader->load('palmpixi', $useragent);
        }

        if (preg_match('/PalmPre/', $useragent)) {
            return $this->loader->load('palmpre', $useragent);
        }

        if (preg_match('/Panasonic/', $useragent)) {
            return $this->loader->load('panasonic', $useragent);
        }

        if (preg_match('/Pandora/', $useragent)) {
            return $this->loader->load('pandora', $useragent);
        }

        if (preg_match('/Parchbot/', $useragent)) {
            return $this->loader->load('parchbot', $useragent);
        }

        if (preg_match('/PearHttpRequest/', $useragent)) {
            return $this->loader->load('pear http_request', $useragent);
        }

        if (preg_match('/PearHttpRequest2/', $useragent)) {
            return $this->loader->load('pear http_request2', $useragent);
        }

        if (preg_match('/Philips/', $useragent)) {
            return $this->loader->load('philips', $useragent);
        }

        if (preg_match('/PixraySeeker/', $useragent)) {
            return $this->loader->load('pixray-seeker', $useragent);
        }

        if (preg_match('/Playstation/', $useragent)) {
            return $this->loader->load('playstation', $useragent);
        }

        if (preg_match('/PlaystationBrowser/', $useragent)) {
            return $this->loader->load('playstation browser', $useragent);
        }

        if (preg_match('/Plukkie/', $useragent)) {
            return $this->loader->load('plukkie', $useragent);
        }

        if (preg_match('/PodtechNetwork/', $useragent)) {
            return $this->loader->load('podtech network', $useragent);
        }

        if (preg_match('/Pogodak/', $useragent)) {
            return $this->loader->load('pogodak', $useragent);
        }

        if (preg_match('/Postbox/', $useragent)) {
            return $this->loader->load('postbox', $useragent);
        }

        if (preg_match('/Powertv/', $useragent)) {
            return $this->loader->load('powertv', $useragent);
        }

        if (preg_match('/Prism/', $useragent)) {
            return $this->loader->load('prism', $useragent);
        }

        if (preg_match('/Python/', $useragent)) {
            return $this->loader->load('python', $useragent);
        }

        if (preg_match('/Qihoo/', $useragent)) {
            return $this->loader->load('qihoo', $useragent);
        }

        if (preg_match('/Qtek/', $useragent)) {
            return $this->loader->load('qtek', $useragent);
        }

        if (preg_match('/QtWeb/', $useragent)) {
            return $this->loader->load('qtweb internet browser', $useragent);
        }

        if (preg_match('/Quantcastbot/', $useragent)) {
            return $this->loader->load('quantcastbot', $useragent);
        }

        if (preg_match('/QuerySeekerSpider/', $useragent)) {
            return $this->loader->load('queryseekerspider', $useragent);
        }

        if ($s->contains('quicktime', false)) {
            return $this->loader->load('quicktime', $useragent);
        }

        if (preg_match('/Realplayer/', $useragent)) {
            return $this->loader->load('realplayer', $useragent);
        }

        if (preg_match('/RgAnalytics/', $useragent)) {
            return $this->loader->load('rganalytics', $useragent);
        }

        if (preg_match('/Rippers/', $useragent)) {
            return $this->loader->load('ripper', $useragent);
        }

        if (preg_match('/Rojo/', $useragent)) {
            return $this->loader->load('rojo', $useragent);
        }

        if (preg_match('/RssingBot/', $useragent)) {
            return $this->loader->load('rssingbot', $useragent);
        }

        if (preg_match('/RssOwl/', $useragent)) {
            return $this->loader->load('rssowl', $useragent);
        }

        if (preg_match('/RukyBot/', $useragent)) {
            return $this->loader->load('ruky roboter', $useragent);
        }

        if (preg_match('/Ruunk/', $useragent)) {
            return $this->loader->load('ruunk', $useragent);
        }

        if (preg_match('/Samsung/', $useragent)) {
            return $this->loader->load('samsung', $useragent);
        }

        if (preg_match('/SamsungMobileBrowser/', $useragent)) {
            return $this->loader->load('samsung mobile browser', $useragent);
        }

        if (preg_match('/Sanyo/', $useragent)) {
            return $this->loader->load('sanyo', $useragent);
        }

        if (preg_match('/SaveTheWorldHeritage/', $useragent)) {
            return $this->loader->load('save-the-world-heritage bot', $useragent);
        }

        if (preg_match('/Scorpionbot/', $useragent)) {
            return $this->loader->load('scorpionbot', $useragent);
        }

        if (preg_match('/Scraper/', $useragent)) {
            return $this->loader->load('scraper', $useragent);
        }

        if (preg_match('/Searchmetrics/', $useragent)) {
            return $this->loader->load('searchmetricsbot', $useragent);
        }

        if (preg_match('/SemagerBot/', $useragent)) {
            return $this->loader->load('semager bot', $useragent);
        }

        if (preg_match('/SeoEngineWorldBot/', $useragent)) {
            return $this->loader->load('seoengine world bot', $useragent);
        }

        if (preg_match('/Setooz/', $useragent)) {
            return $this->loader->load('setooz', $useragent);
        }

        if (preg_match('/Shiira/', $useragent)) {
            return $this->loader->load('shiira', $useragent);
        }

        if (preg_match('/Shopsalad/', $useragent)) {
            return $this->loader->load('shopsalad', $useragent);
        }

        if (preg_match('/Siemens/', $useragent)) {
            return $this->loader->load('siemens', $useragent);
        }

        if (preg_match('/Sindice/', $useragent)) {
            return $this->loader->load('sindice fetcher', $useragent);
        }

        if (preg_match('/SiteKiosk/', $useragent)) {
            return $this->loader->load('sitekiosk', $useragent);
        }

        if (preg_match('/SlimBrowser/', $useragent)) {
            return $this->loader->load('slimbrowser', $useragent);
        }

        if (preg_match('/SmartSync/', $useragent)) {
            return $this->loader->load('smartsync app', $useragent);
        }

        if (preg_match('/SmartTv/', $useragent)) {
            return $this->loader->load('smarttv', $useragent);
        }

        if (preg_match('/SmartTvWebBrowser/', $useragent)) {
            return $this->loader->load('smarttv webbrowser', $useragent);
        }

        if (preg_match('/Snapbot/', $useragent)) {
            return $this->loader->load('snapbot', $useragent);
        }

        if (preg_match('/Snoopy/', $useragent)) {
            return $this->loader->load('snoopy', $useragent);
        }

        if (preg_match('/Snowtape/', $useragent)) {
            return $this->loader->load('snowtape', $useragent);
        }

        if (preg_match('/Songbird/', $useragent)) {
            return $this->loader->load('songbird', $useragent);
        }

        if (preg_match('/Sosospider/', $useragent)) {
            return $this->loader->load('sosospider', $useragent);
        }

        if (preg_match('/SpaceBison/', $useragent)) {
            return $this->loader->load('space bison', $useragent);
        }

        if (preg_match('/Spector/', $useragent)) {
            return $this->loader->load('spector', $useragent);
        }

        if (preg_match('/SpeedySpider/', $useragent)) {
            return $this->loader->load('speedy spider', $useragent);
        }

        if (preg_match('/SpellCheckBot/', $useragent)) {
            return $this->loader->load('spellcheck bot', $useragent);
        }

        if (preg_match('/SpiderLing/', $useragent)) {
            return $this->loader->load('spiderling', $useragent);
        }

        if (preg_match('/Spiderlytics/', $useragent)) {
            return $this->loader->load('spiderlytics', $useragent);
        }

        if (preg_match('/SpiderPig/', $useragent)) {
            return $this->loader->load('spider-pig', $useragent);
        }

        if (preg_match('/SprayCan/', $useragent)) {
            return $this->loader->load('spray-can', $useragent);
        }

        if (preg_match('/SPV/', $useragent)) {
            return $this->loader->load('spv', $useragent);
        }

        if (preg_match('/SquidWall/', $useragent)) {
            return $this->loader->load('squidwall', $useragent);
        }

        if (preg_match('/Sqwidgebot/', $useragent)) {
            return $this->loader->load('sqwidgebot', $useragent);
        }

        if (preg_match('/Strata/', $useragent)) {
            return $this->loader->load('strata', $useragent);
        }

        if (preg_match('/StrategicBoardBot/', $useragent)) {
            return $this->loader->load('strategicboardbot', $useragent);
        }

        if (preg_match('/StrawberryjamUrlExpander/', $useragent)) {
            return $this->loader->load('strawberryjam url expander', $useragent);
        }

        if (preg_match('/Sunbird/', $useragent)) {
            return $this->loader->load('sunbird', $useragent);
        }

        if (preg_match('/Superfish/', $useragent)) {
            return $this->loader->load('superfish', $useragent);
        }

        if (preg_match('/Superswan/', $useragent)) {
            return $this->loader->load('superswan', $useragent);
        }

        if (preg_match('/SymphonyBrowser/', $useragent)) {
            return $this->loader->load('symphonybrowser', $useragent);
        }

        if (preg_match('/SynapticWalker/', $useragent)) {
            return $this->loader->load('synapticwalker', $useragent);
        }

        if (preg_match('/TagInspectorBot/', $useragent)) {
            return $this->loader->load('taginspector', $useragent);
        }

        if (preg_match('/Tailrank/', $useragent)) {
            return $this->loader->load('tailrank', $useragent);
        }

        if (preg_match('/TasapImageRobot/', $useragent)) {
            return $this->loader->load('tasapimagerobot', $useragent);
        }

        if (preg_match('/TenFourFox/', $useragent)) {
            return $this->loader->load('tenfourfox', $useragent);
        }

        if (preg_match('/Terra/', $useragent)) {
            return $this->loader->load('terra', $useragent);
        }

        if (preg_match('/TheBatDownloadManager/', $useragent)) {
            return $this->loader->load('the bat download manager', $useragent);
        }

        if (preg_match('/ThemeSearchAndExtractionCrawler/', $useragent)) {
            return $this->loader->load('themesearchandextractioncrawler', $useragent);
        }

        if (preg_match('/ThumbShotsBot/', $useragent)) {
            return $this->loader->load('thumbshotsbot', $useragent);
        }

        if (preg_match('/Thunderstone/', $useragent)) {
            return $this->loader->load('thunderstone', $useragent);
        }

        if (preg_match('/TinEye/', $useragent)) {
            return $this->loader->load('tineye', $useragent);
        }

        if (preg_match('/TkcAutodownloader/', $useragent)) {
            return $this->loader->load('tkcautodownloader', $useragent);
        }

        if (preg_match('/TlsProber/', $useragent)) {
            return $this->loader->load('tlsprober', $useragent);
        }

        if (preg_match('/Toshiba/', $useragent)) {
            return $this->loader->load('toshiba', $useragent);
        }

        if (preg_match('/TrendictionBot/', $useragent)) {
            return $this->loader->load('trendiction bot', $useragent);
        }

        if (preg_match('/TrendMicro/', $useragent)) {
            return $this->loader->load('trend micro', $useragent);
        }

        if (preg_match('/TumblrRssSyndication/', $useragent)) {
            return $this->loader->load('tumblrrsssyndication', $useragent);
        }

        if (preg_match('/TuringMachine/', $useragent)) {
            return $this->loader->load('turingmachine', $useragent);
        }

        if (preg_match('/TurnitinBot/', $useragent)) {
            return $this->loader->load('turnitinbot', $useragent);
        }

        if (preg_match('/Tweetbot/', $useragent)) {
            return $this->loader->load('tweetbot', $useragent);
        }

        if (preg_match('/TwengabotDiscover/', $useragent)) {
            return $this->loader->load('twengabotdiscover', $useragent);
        }

        if (preg_match('/Twitturls/', $useragent)) {
            return $this->loader->load('twitturls', $useragent);
        }

        if (preg_match('/Typo/', $useragent)) {
            return $this->loader->load('typo3', $useragent);
        }

        if (preg_match('/TypoLinkvalidator/', $useragent)) {
            return $this->loader->load('typolinkvalidator', $useragent);
        }

        if (preg_match('/UnisterPortale/', $useragent)) {
            return $this->loader->load('unisterportale', $useragent);
        }

        if (preg_match('/UoftdbExperiment/', $useragent)) {
            return $this->loader->load('uoftdb experiment', $useragent);
        }

        if (preg_match('/Vanillasurf/', $useragent)) {
            return $this->loader->load('vanillasurf', $useragent);
        }

        if (preg_match('/Viralheat/', $useragent)) {
            return $this->loader->load('viral heat', $useragent);
        }

        if (preg_match('/VmsMosaic/', $useragent)) {
            return $this->loader->load('vmsmosaic', $useragent);
        }

        if (preg_match('/Vobsub/', $useragent)) {
            return $this->loader->load('vobsub', $useragent);
        }

        if (preg_match('/Voilabot/', $useragent)) {
            return $this->loader->load('voilabot', $useragent);
        }

        if (preg_match('/Vonnacom/', $useragent)) {
            return $this->loader->load('vonnacom', $useragent);
        }

        if (preg_match('/Voyager/', $useragent)) {
            return $this->loader->load('voyager', $useragent);
        }

        if (preg_match('/W3cChecklink/', $useragent)) {
            return $this->loader->load('w3c-checklink', $useragent);
        }

        if (preg_match('/W3cValidator/', $useragent)) {
            return $this->loader->load('w3c validator', $useragent);
        }

        if (preg_match('/W3m/', $useragent)) {
            return $this->loader->load('w3m', $useragent);
        }

        if (preg_match('/Webaroo/', $useragent)) {
            return $this->loader->load('webaroo', $useragent);
        }

        if (preg_match('/Webbotru/', $useragent)) {
            return $this->loader->load('webbotru', $useragent);
        }

        if (preg_match('/Webcapture/', $useragent)) {
            return $this->loader->load('webcapture', $useragent);
        }

        if (preg_match('/WebDownloader/', $useragent)) {
            return $this->loader->load('web downloader', $useragent);
        }

        if (preg_match('/Webimages/', $useragent)) {
            return $this->loader->load('webimages', $useragent);
        }

        if (preg_match('/Weblide/', $useragent)) {
            return $this->loader->load('weblide', $useragent);
        }

        if (preg_match('/WebLinkValidator/', $useragent)) {
            return $this->loader->load('web link validator', $useragent);
        }

        if (preg_match('/WebmasterworldServerHeaderChecker/', $useragent)) {
            return $this->loader->load('webmasterworldserverheaderchecker', $useragent);
        }

        if (preg_match('/WebOX/', $useragent)) {
            return $this->loader->load('webox', $useragent);
        }

        if (preg_match('/Webscan/', $useragent)) {
            return $this->loader->load('webscan', $useragent);
        }

        if (preg_match('/Websuchebot/', $useragent)) {
            return $this->loader->load('websuchebot', $useragent);
        }

        if (preg_match('/WebtvMsntv/', $useragent)) {
            return $this->loader->load('webtv/msntv', $useragent);
        }

        if (preg_match('/Wepbot/', $useragent)) {
            return $this->loader->load('wepbot', $useragent);
        }

        if (preg_match('/WiJobRoboter/', $useragent)) {
            return $this->loader->load('wi job roboter', $useragent);
        }

        if (preg_match('/Wikimpress/', $useragent)) {
            return $this->loader->load('wikimpress', $useragent);
        }

        if (preg_match('/Winamp/', $useragent)) {
            return $this->loader->load('winamp', $useragent);
        }

        if (preg_match('/Winkbot/', $useragent)) {
            return $this->loader->load('winkbot', $useragent);
        }

        if (preg_match('/Winwap/', $useragent)) {
            return $this->loader->load('winwap', $useragent);
        }

        if (preg_match('/Wire/', $useragent)) {
            return $this->loader->load('wire', $useragent);
        }

        if (preg_match('/Wisebot/', $useragent)) {
            return $this->loader->load('wisebot', $useragent);
        }

        if (preg_match('/Wizz/', $useragent)) {
            return $this->loader->load('wizz', $useragent);
        }

        if (preg_match('/Worldlingo/', $useragent)) {
            return $this->loader->load('worldlingo', $useragent);
        }

        if (preg_match('/WorldWideWeasel/', $useragent)) {
            return $this->loader->load('world wide weasel', $useragent);
        }

        if (preg_match('/Wotbox/', $useragent)) {
            return $this->loader->load('wotbox', $useragent);
        }

        if (preg_match('/WwwBrowser/', $useragent)) {
            return $this->loader->load('www browser', $useragent);
        }

        if (preg_match('/Wwwc/', $useragent)) {
            return $this->loader->load('wwwc', $useragent);
        }

        if (preg_match('/Wwwmail/', $useragent)) {
            return $this->loader->load('www4mail', $useragent);
        }

        if (preg_match('/WwwMechanize/', $useragent)) {
            return $this->loader->load('www-mechanize', $useragent);
        }

        if (preg_match('/Wwwster/', $useragent)) {
            return $this->loader->load('wwwster', $useragent);
        }

        if (preg_match('/XaldonWebspider/', $useragent)) {
            return $this->loader->load('xaldon webspider', $useragent);
        }

        if (preg_match('/XchaosArachne/', $useragent)) {
            return $this->loader->load('xchaos arachne', $useragent);
        }

        if (preg_match('/Xerka/', $useragent)) {
            return $this->loader->load('xerka', $useragent);
        }

        if (preg_match('/XmlRpcForPhp/', $useragent)) {
            return $this->loader->load('xml-rpc for php', $useragent);
        }

        if (preg_match('/Xspider/', $useragent)) {
            return $this->loader->load('xspider', $useragent);
        }

        if (preg_match('/Xyleme/', $useragent)) {
            return $this->loader->load('xyleme', $useragent);
        }

        if (preg_match('/YacyBot/', $useragent)) {
            return $this->loader->load('yacy bot', $useragent);
        }

        if (preg_match('/Yadowscrawler/', $useragent)) {
            return $this->loader->load('yadowscrawler', $useragent);
        }

        if (preg_match('/Yahoo/', $useragent)) {
            return $this->loader->load('yahoo!', $useragent);
        }

        if (preg_match('/YahooExternalCache/', $useragent)) {
            return $this->loader->load('yahooexternalcache', $useragent);
        }

        if (preg_match('/YahooMobileMessenger/', $useragent)) {
            return $this->loader->load('yahoo! mobile messenger', $useragent);
        }

        if (preg_match('/YahooPipes/', $useragent)) {
            return $this->loader->load('yahoo! pipes', $useragent);
        }

        if (preg_match('/YandexImagesBot/', $useragent)) {
            return $this->loader->load('yandeximages', $useragent);
        }

        if (preg_match('/YouWaveAndroidOnPc/', $useragent)) {
            return $this->loader->load('youwave android on pc', $useragent);
        }

        return $this->loader->load('unknown', $useragent);
    }

    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param array                    $data
     *
     * @return \UaResult\Browser\Browser
     */
    public function fromArray(LoggerInterface $logger, array $data)
    {
        return (new \UaResult\Browser\BrowserFactory())->fromArray($this->cache, $logger, $data);
    }
}
