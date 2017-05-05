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
use Stringy\Stringy;
use UaResult\Os\OsInterface;

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
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(LoaderInterface $loader)
    {
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

        if ($s->contains('revip.info site analyzer', false)) {
            return $this->loader->load('reverse ip lookup', $useragent);
        }

        if ($s->contains('reddit pic scraper', false)) {
            return $this->loader->load('reddit pic scraper', $useragent);
        }

        if ($s->contains('mozilla crawl', false)) {
            return $this->loader->load('mozilla crawler', $useragent);
        }

        if ($s->startsWith('[fban', false)) {
            return $this->loader->load('facebook app', $useragent);
        }

        if ($s->contains('ucbrowserhd', false)) {
            return $this->loader->load('uc browser hd', $useragent);
        }

        if ($s->contains('flyflow', false)) {
            return $this->loader->load('flyflow', $useragent);
        }

        if ($s->containsAny(['bdbrowser_i18n', 'baidubrowser'], false)) {
            return $this->loader->load('baidu browser', $useragent);
        }

        if ($s->contains('bdbrowserhd_i18n', false)) {
            return $this->loader->load('baidu browser hd', $useragent);
        }

        if ($s->contains('bdbrowser_mini', false)) {
            return $this->loader->load('baidu browser mini', $useragent);
        }

        if ($s->containsAny(['ucbrowser', 'ubrowser', 'uc browser', 'ucweb'], false) && $s->contains('opera mini', false)) {
            return $this->loader->load('ucbrowser', $useragent);
        }

        if ($s->containsAny(['opera mini', 'opios'], false)) {
            return $this->loader->load('opera mini', $useragent);
        }

        if ($s->contains('opera mobi', false)
            || ($s->containsAny(['opera', 'opr'], false) && $s->containsAny(['android', 'mtk', 'maui', 'samsung', 'windows ce', 'symbos'], false))
        ) {
            return $this->loader->load('opera mobile', $useragent);
        }

        if ($s->containsAny(['ucbrowser', 'ubrowser', 'uc browser', 'ucweb'], false)) {
            return $this->loader->load('ucbrowser', $useragent);
        }

        if ($s->contains('ic opengraph crawler', false)) {
            return $this->loader->load('ibm connections', $useragent);
        }

        if ($s->contains('coast', false)) {
            return $this->loader->load('coast', $useragent);
        }

        if ($s->containsAny(['opera', 'opr'], false)) {
            return $this->loader->load('opera', $useragent);
        }

        if ($s->contains('icabmobile', false)) {
            return $this->loader->load('icab mobile', $useragent);
        }

        if ($s->contains('icab', false)) {
            return $this->loader->load('icab', $useragent);
        }

        if ($s->contains('hggh phantomjs screenshoter', false)) {
            return $this->loader->load('hggh screenshot system with phantomjs', $useragent);
        }

        if ($s->contains('bl.uk_lddc_bot', false)) {
            return $this->loader->load('bl.uk_lddc_bot', $useragent);
        }

        if ($s->contains('phantomas', false)) {
            return $this->loader->load('phantomas', $useragent);
        }

        if ($s->contains('seznam screenshot-generator', false)) {
            return $this->loader->load('seznam screenshot generator', $useragent);
        }

        if ($s->contains('phantomjs', false)) {
            return $this->loader->load('phantomjs', $useragent);
        }

        if ($s->contains('yabrowser', false)) {
            return $this->loader->load('yabrowser', $useragent);
        }

        if ($s->contains('kamelio', false)) {
            return $this->loader->load('kamelio app', $useragent);
        }

        if ($s->contains('fbav', false)) {
            return $this->loader->load('facebook app', $useragent);
        }

        if ($s->contains('acheetahi', false)) {
            return $this->loader->load('cm browser', $useragent);
        }

        if ($s->contains('puffin', false)) {
            return $this->loader->load('puffin', $useragent);
        }

        if ($s->contains('stagefright', false)) {
            return $this->loader->load('stagefright', $useragent);
        }

        if ($s->contains('samsungbrowser', false)) {
            return $this->loader->load('samsungbrowser', $useragent);
        }

        if ($s->contains('silk', false)) {
            return $this->loader->load('silk', $useragent);
        }

        if ($s->contains('coc_coc_browser', false)) {
            return $this->loader->load('coc_coc_browser', $useragent);
        }

        if ($s->contains('navermatome', false)) {
            return $this->loader->load('matome', $useragent);
        }

        if ($s->contains('flipboardproxy', false)) {
            return $this->loader->load('flipboardproxy', $useragent);
        }

        if ($s->contains('flipboard', false)) {
            return $this->loader->load('flipboard app', $useragent);
        }

        if ($s->contains('seznam.cz', false)) {
            return $this->loader->load('seznam browser', $useragent);
        }

        if ($s->contains('aviator', false)) {
            return $this->loader->load('aviator', $useragent);
        }

        if ($s->contains('netfrontlifebrowser', false)) {
            return $this->loader->load('netfrontlifebrowser', $useragent);
        }

        if ($s->contains('icedragon', false)) {
            return $this->loader->load('icedragon', $useragent);
        }

        if ($s->contains('dragon', false) && !$s->contains('dragonfly', false)) {
            return $this->loader->load('dragon', $useragent);
        }

        if ($s->contains('beamrise', false)) {
            return $this->loader->load('beamrise', $useragent);
        }

        if ($s->contains('diglo', false)) {
            return $this->loader->load('diglo', $useragent);
        }

        if ($s->contains('apusbrowser', false)) {
            return $this->loader->load('apusbrowser', $useragent);
        }

        if ($s->contains('chedot', false)) {
            return $this->loader->load('chedot', $useragent);
        }

        if ($s->contains('qword', false)) {
            return $this->loader->load('qword browser', $useragent);
        }

        if ($s->contains('iridium', false)) {
            return $this->loader->load('iridium browser', $useragent);
        }

        if ($s->contains('avant', false)) {
            return $this->loader->load('avant', $useragent);
        }

        if ($s->contains('mxnitro', false)) {
            return $this->loader->load('maxthon nitro', $useragent);
        }

        if ($s->containsAny(['mxbrowser', 'maxthon', 'myie'], false)) {
            return $this->loader->load('maxthon', $useragent);
        }

        if ($s->contains('superbird', false)) {
            return $this->loader->load('superbird', $useragent);
        }

        if ($s->contains('tinybrowser', false)) {
            return $this->loader->load('tinybrowser', $useragent);
        }

        if ($s->contains('micromessenger', false)) {
            return $this->loader->load('wechat app', $useragent);
        }

        if ($s->contains('mqqbrowser/mini', false)) {
            return $this->loader->load('qqbrowser mini', $useragent);
        }

        if ($s->contains('mqqbrowser', false)) {
            return $this->loader->load('qqbrowser', $useragent);
        }

        if ($s->contains('pinterest', false)) {
            return $this->loader->load('pinterest app', $useragent);
        }

        if ($s->contains('baiduboxapp', false)) {
            return $this->loader->load('baidu box app', $useragent);
        }

        if ($s->contains('wkbrowser', false)) {
            return $this->loader->load('wkbrowser', $useragent);
        }

        if ($s->contains('mb2345browser', false)) {
            return $this->loader->load('2345 browser', $useragent);
        }

        if ($s->containsAll(['chrome', 'version'], false)) {
            return $this->loader->load('android webview', $useragent);
        }

        if ($s->containsAll(['safari', 'version', 'tizen'], false)) {
            return $this->loader->load('samsung webview', $useragent);
        }

        if ($s->contains('cybeye', false)) {
            return $this->loader->load('cybeye', $useragent);
        }

        if ($s->contains('rebelmouse', false)) {
            return $this->loader->load('rebelmouse', $useragent);
        }

        if ($s->contains('seamonkey', false)) {
            return $this->loader->load('seamonkey', $useragent);
        }

        if ($s->contains('jobboerse', false)) {
            return $this->loader->load('jobboerse bot', $useragent);
        }

        if ($s->contains('navigator', false)) {
            return $this->loader->load('netscape navigator', $useragent);
        }

        if ($s->containsAll(['firefox', 'anonym'], false)) {
            return $this->loader->load('firefox', $useragent);
        }

        if ($s->containsAll(['trident', 'anonym'], false)) {
            return $this->loader->load('internet explorer', $useragent);
        }

        if ($s->contains('windows-rss-platform', false)) {
            return $this->loader->load('windows-rss-platform', $useragent);
        }

        if ($s->contains('marketwirebot', false)) {
            return $this->loader->load('marketwirebot', $useragent);
        }

        if ($s->contains('googletoolbar', false)) {
            return $this->loader->load('google toolbar', $useragent);
        }

        if ($s->contains('netscape', false)) {
            return $this->loader->load('netscape', $useragent);
        }

        if ($s->contains('lssrocketcrawler', false)) {
            return $this->loader->load('lightspeed systems rocketcrawler', $useragent);
        }

        if ($s->contains('lightspeedsystems', false)) {
            return $this->loader->load('lightspeed systems crawler', $useragent);
        }

        if ($s->contains('sl commerce client', false)) {
            return $this->loader->load('second live commerce client', $useragent);
        }

        if ($s->containsAny(['iemobile', 'wpdesktop', 'zunewp7', 'xblwp7'], false)) {
            return $this->loader->load('iemobile', $useragent);
        }

        if ($s->contains('bingpreview', false)) {
            return $this->loader->load('bing preview', $useragent);
        }

        if ($s->contains('haosouspider', false)) {
            return $this->loader->load('haosouspider', $useragent);
        }

        if ($s->contains('360spider', false)) {
            return $this->loader->load('360spider', $useragent);
        }

        if ($s->contains('outlook-express', false)) {
            return $this->loader->load('outlook-express', $useragent);
        }

        if ($s->contains('outlook', false)) {
            return $this->loader->load('outlook', $useragent);
        }

        if ($s->contains('microsoft office mobile', false)) {
            return $this->loader->load('office', $useragent);
        }

        if ($s->contains('msoffice', false)) {
            return $this->loader->load('office', $useragent);
        }

        if ($s->contains('microsoft office protocol discovery', false)) {
            return $this->loader->load('ms opd', $useragent);
        }

        if ($s->containsAny(['office excel', 'microsoft excel'], false)) {
            return $this->loader->load('excel', $useragent);
        }

        if ($s->contains('powerpoint', false)) {
            return $this->loader->load('powerpoint', $useragent);
        }

        if ($s->contains('wordpress', false)) {
            return $this->loader->load('wordpress', $useragent);
        }

        if ($s->containsAny(['office word', 'microsoft word'], false)) {
            return $this->loader->load('word', $useragent);
        }

        if ($s->containsAny(['office onenote', 'microsoft onenote'], false)) {
            return $this->loader->load('onenote', $useragent);
        }

        if ($s->containsAny(['office visio', 'microsoft visio'], false)) {
            return $this->loader->load('visio', $useragent);
        }

        if ($s->containsAny(['office access', 'microsoft access'], false)) {
            return $this->loader->load('access', $useragent);
        }

        if ($s->contains('lync', false)) {
            return $this->loader->load('lync', $useragent);
        }

        if ($s->contains('office syncproc', false)) {
            return $this->loader->load('office syncproc', $useragent);
        }

        if ($s->contains('office upload center', false)) {
            return $this->loader->load('office upload center', $useragent);
        }

        if ($s->contains('frontpage', false)) {
            return $this->loader->load('frontpage', $useragent);
        }

        if ($s->contains('microsoft office', false)) {
            return $this->loader->load('office', $useragent);
        }

        if ($s->contains('crazy browser', false)) {
            return $this->loader->load('crazy browser', $useragent);
        }

        if ($s->contains('deepnet explorer', false)) {
            return $this->loader->load('deepnet explorer', $useragent);
        }

        if ($s->contains('kkman', false)) {
            return $this->loader->load('kkman', $useragent);
        }

        if ($s->contains('lunascape', false)) {
            return $this->loader->load('lunascape', $useragent);
        }

        if ($s->contains('sleipnir', false)) {
            return $this->loader->load('sleipnir', $useragent);
        }

        if ($s->contains('smartsite httpclient', false)) {
            return $this->loader->load('smartsite httpclient', $useragent);
        }

        if ($s->contains('gomezagent', false)) {
            return $this->loader->load('gomez site monitor', $useragent);
        }

        if ($s->contains('orangebot', false)) {
            return $this->loader->load('orangebot', $useragent);
        }

        if ($s->containsAny(['tob', 't-online browser'], false)) {
            return $this->loader->load('t-online browser', $useragent);
        }

        if ($s->contains('appengine-google', false)) {
            return $this->loader->load('google app engine', $useragent);
        }

        if ($s->contains('crystalsemanticsbot', false)) {
            return $this->loader->load('crystalsemanticsbot', $useragent);
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

        if ($s->contains('chromium', false)) {
            return $this->loader->load('chromium', $useragent);
        }

        if ($s->contains('iron', false)) {
            return $this->loader->load('iron', $useragent);
        }

        if ($s->contains('midori', false)) {
            return $this->loader->load('midori', $useragent);
        }

        if ($s->contains('locubot', false)) {
            return $this->loader->load('locubot', $useragent);
        }

        if ($s->contains('acapbot', false)) {
            return $this->loader->load('acapbot', $useragent);
        }

        if ($s->contains('google page speed insights', false)) {
            return $this->loader->load('google pagespeed insights', $useragent);
        }

        if ($s->contains('web/snippet', false)) {
            return $this->loader->load('google web snippet', $useragent);
        }

        if ($s->contains('googlebot-mobile', false)) {
            return $this->loader->load('googlebot-mobile', $useragent);
        }

        if ($s->contains('google wireless transcoder', false)) {
            return $this->loader->load('google wireless transcoder', $useragent);
        }

        if ($s->contains('com.google.googleplus', false)) {
            return $this->loader->load('google+ app', $useragent);
        }

        if ($s->contains('google-http-java-client', false)) {
            return $this->loader->load('google http client library for java', $useragent);
        }

        if ($s->contains('googlebot-image', false)) {
            return $this->loader->load('google image search', $useragent);
        }

        if ($s->contains('googlebot', false)) {
            return $this->loader->load('googlebot', $useragent);
        }

        if ($s->startsWith('GOOG', true)) {
            return $this->loader->load('googlebot', $useragent);
        }

        if ($s->contains('viera', false)) {
            return $this->loader->load('smartviera', $useragent);
        }

        if ($s->contains('nichrome', false)) {
            return $this->loader->load('nichrome', $useragent);
        }

        if ($s->contains('kinza', false)) {
            return $this->loader->load('kinza', $useragent);
        }

        if ($s->contains('google keyword suggestion', false)) {
            return $this->loader->load('google keyword suggestion', $useragent);
        }

        if ($s->contains('google web preview', false)) {
            return $this->loader->load('google web preview', $useragent);
        }

        if ($s->contains('google-adwords-displayads-webrender', false)) {
            return $this->loader->load('google adwords displayads webrender', $useragent);
        }

        if ($s->contains('hubspot webcrawler', false)) {
            return $this->loader->load('hubspot webcrawler', $useragent);
        }

        if ($s->contains('rockmelt', false)) {
            return $this->loader->load('rockmelt', $useragent);
        }

        if ($s->contains(' se ', false)) {
            return $this->loader->load('sogou explorer', $useragent);
        }

        if ($s->contains('archivebot', false)) {
            return $this->loader->load('archivebot', $useragent);
        }

        if ($s->contains('edge', false) && null !== $platform && 'Windows Phone OS' === $platform->getName()) {
            return $this->loader->load('edge mobile', $useragent);
        }

        if ($s->contains('edge', false)) {
            return $this->loader->load('edge', $useragent);
        }

        if ($s->contains('diffbot', false)) {
            return $this->loader->load('diffbot', $useragent);
        }

        if ($s->contains('vivaldi', false)) {
            return $this->loader->load('vivaldi', $useragent);
        }

        if ($s->contains('lbbrowser', false)) {
            return $this->loader->load('liebao', $useragent);
        }

        if ($s->contains('amigo', false)) {
            return $this->loader->load('amigo', $useragent);
        }

        if ($s->contains('chromeplus', false)) {
            return $this->loader->load('coolnovo chrome plus', $useragent);
        }

        if ($s->contains('coolnovo', false)) {
            return $this->loader->load('coolnovo', $useragent);
        }

        if ($s->contains('kenshoo', false)) {
            return $this->loader->load('kenshoo', $useragent);
        }

        if ($s->contains('bowser', false)) {
            return $this->loader->load('bowser', $useragent);
        }

        if ($s->contains('360se', false)) {
            return $this->loader->load('360 secure browser', $useragent);
        }

        if ($s->contains('360ee', false)) {
            return $this->loader->load('360 speed browser', $useragent);
        }

        if ($s->contains('asw', false)) {
            return $this->loader->load('avast safezone', $useragent);
        }

        if ($s->contains('schoolwires', false)) {
            return $this->loader->load('schoolwires app', $useragent);
        }

        if ($s->contains('netnewswire', false)) {
            return $this->loader->load('netnewswire', $useragent);
        }

        if ($s->contains('wire', false)) {
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

        if ($s->contains('flock', false)) {
            return $this->loader->load('flock', $useragent);
        }

        if ($s->contains('crosswalk', false)) {
            return $this->loader->load('crosswalk', $useragent);
        }

        if ($s->contains('bromium safari', false)) {
            return $this->loader->load('vsentry', $useragent);
        }

        if ($s->contains('domain.com', false)) {
            return $this->loader->load('pagepeeker screenshot maker', $useragent);
        }

        if ($s->contains('pagepeeker', false)) {
            return $this->loader->load('pagepeeker', $useragent);
        }

        if ($s->containsAny(['chrome', 'crmo', 'crios'], false)) {
            return $this->loader->load('chrome', $useragent);
        }

        if ($s->contains('dolphin http client', false)) {
            return $this->loader->load('dolphin smalltalk http client', $useragent);
        }

        if ($s->containsAny(['dolphin', 'dolfin'], false)) {
            return $this->loader->load('dolfin', $useragent);
        }

        if ($s->contains('arora', false)) {
            return $this->loader->load('arora', $useragent);
        }

        if ($s->contains('com.douban.group', false)) {
            return $this->loader->load('douban app', $useragent);
        }

        if ($s->contains('ovibrowser', false)) {
            return $this->loader->load('nokia proxy browser', $useragent);
        }

        if ($s->contains('miuibrowser', false)) {
            return $this->loader->load('miui browser', $useragent);
        }

        if ($s->contains('ibrowser', false)) {
            return $this->loader->load('ibrowser', $useragent);
        }

        if ($s->contains('onebrowser', false)) {
            return $this->loader->load('onebrowser', $useragent);
        }

        if ($s->contains('baiduspider-image', false)) {
            return $this->loader->load('baidu image search', $useragent);
        }

        if ($s->contains('baiduspider', false)) {
            return $this->loader->load('baiduspider', $useragent);
        }

        if ($s->contains('http://www.baidu.com/search', false)) {
            return $this->loader->load('baidu mobile search', $useragent);
        }

        if ($s->containsAny(['yjapp', 'yjtop'], false)) {
            return $this->loader->load('yahoo! app', $useragent);
        }

        if ($s->containsAll(['linux; android', 'version'], false)) {
            return $this->loader->load('android webkit', $useragent);
        }

        if (preg_match('/android[\/ ][\d\.]+ release/i', $useragent)) {
            return $this->loader->load('android webkit', $useragent);
        }

        if ($s->contains('safari', false) && null !== $platform && 'Android' === $platform->getName()) {
            return $this->loader->load('android webkit', $useragent);
        }

        if ($s->containsAll(['blackberry', 'version'], false)) {
            return $this->loader->load('blackberry', $useragent);
        }

        if ($s->containsAny(['webos', 'wosbrowser', 'wossystem'], false)) {
            return $this->loader->load('webkit/webos', $useragent);
        }

        if ($s->contains('omniweb', false)) {
            return $this->loader->load('omniweb', $useragent);
        }

        if ($s->contains('windows phone search', false)) {
            return $this->loader->load('windows phone search', $useragent);
        }

        if ($s->contains('windows-update-agent', false)) {
            return $this->loader->load('windows-update-agent', $useragent);
        }

        if ($s->contains('classilla', false)) {
            return $this->loader->load('classilla', $useragent);
        }

        if ($s->contains('nokia', false)) {
            return $this->loader->load('nokiabrowser', $useragent);
        }

        if ($s->contains('twitter for i', false)) {
            return $this->loader->load('twitter app', $useragent);
        }

        if ($s->contains('twitterbot', false)) {
            return $this->loader->load('twitterbot', $useragent);
        }

        if ($s->contains('GSA', true)) {
            return $this->loader->load('google app', $useragent);
        }

        if ($s->contains('quicktime', false)) {
            return $this->loader->load('quicktime', $useragent);
        }

        if ($s->contains('qtcarbrowser', false)) {
            return $this->loader->load('model s browser', $useragent);
        }

        if ($s->contains('Qt', true)) {
            return $this->loader->load('qt', $useragent);
        }

        if ($s->contains('instagram', false)) {
            return $this->loader->load('instagram app', $useragent);
        }

        if ($s->contains('webclip', false)) {
            return $this->loader->load('webclip app', $useragent);
        }

        if ($s->contains('mercury', false)) {
            return $this->loader->load('mercury', $useragent);
        }

        if ($s->contains('macappstore', false)) {
            return $this->loader->load('macappstore', $useragent);
        }

        if ($s->contains('appstore', false)) {
            return $this->loader->load('apple appstore app', $useragent);
        }

        if ($s->contains('webglance', false)) {
            return $this->loader->load('web glance', $useragent);
        }

        if ($s->contains('yhoo_search_app', false)) {
            return $this->loader->load('yahoo mobile app', $useragent);
        }

        if ($s->contains('newsblur feed fetcher', false)) {
            return $this->loader->load('newsblur feed fetcher', $useragent);
        }

        if ($s->contains('applecoremedia', false)) {
            return $this->loader->load('coremedia', $useragent);
        }

        if ($s->contains('dataaccessd', false)) {
            return $this->loader->load('ios dataaccessd', $useragent);
        }

        if ($s->contains('mailchimp', false)) {
            return $this->loader->load('mailchimp.com', $useragent);
        }

        if ($s->contains('mailbar', false)) {
            return $this->loader->load('mailbar', $useragent);
        }

        if ($s->startsWith('mail', false)) {
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

        if ($s->contains('msnbot-media', false)) {
            return $this->loader->load('msnbot-media', $useragent);
        }

        if ($s->contains('adidxbot', false)) {
            return $this->loader->load('adidxbot', $useragent);
        }

        if ($s->contains('msnbot', false)) {
            return $this->loader->load('bingbot', $useragent);
        }

        if ($s->contains('playbook', false)) {
            return $this->loader->load('blackberry playbook tablet', $useragent);
        }

        if ($s->containsAny(['blackberry', 'bb10'], false)) {
            return $this->loader->load('blackberry', $useragent);
        }

        if ($s->contains('wetab-browser', false)) {
            return $this->loader->load('wetab browser', $useragent);
        }

        if ($s->contains('profiller', false)) {
            return $this->loader->load('profiller', $useragent);
        }

        if ($s->contains('wkhtmltopdf', false)) {
            return $this->loader->load('wkhtmltopdf', $useragent);
        }

        if ($s->contains('wkhtmltoimage', false)) {
            return $this->loader->load('wkhtmltoimage', $useragent);
        }

        if ($s->containsAny(['wp-iphone', 'wp-android'], false)) {
            return $this->loader->load('wordpress app', $useragent);
        }

        if ($s->contains('oktamobile', false)) {
            return $this->loader->load('okta mobile app', $useragent);
        }

        if ($s->contains('kmail2', false)) {
            return $this->loader->load('kmail2', $useragent);
        }

        if ($s->contains('eb-iphone', false)) {
            return $this->loader->load('eb iphone/ipad app', $useragent);
        }

        if ($s->contains('elmediaplayer', false)) {
            return $this->loader->load('elmedia player', $useragent);
        }

        if ($s->contains('dreamweaver', false)) {
            return $this->loader->load('dreamweaver', $useragent);
        }

        if ($s->contains('akregator', false)) {
            return $this->loader->load('akregator', $useragent);
        }

        if ($s->contains('installatron', false)) {
            return $this->loader->load('installatron', $useragent);
        }

        if ($s->contains('quora link preview', false)) {
            return $this->loader->load('quora link preview bot', $useragent);
        }

        if ($s->contains('quora', false)) {
            return $this->loader->load('quora app', $useragent);
        }

        if ($s->contains('rocky chatwork mobile', false)) {
            return $this->loader->load('rocky chatwork mobile', $useragent);
        }

        if ($s->contains('adsbot-google-mobile', false)) {
            return $this->loader->load('adsbot google-mobile', $useragent);
        }

        if ($s->contains('epiphany', false)) {
            return $this->loader->load('epiphany', $useragent);
        }

        if ($s->contains('rekonq', false)) {
            return $this->loader->load('rekonq', $useragent);
        }

        if ($s->contains('skyfire', false)) {
            return $this->loader->load('skyfire', $useragent);
        }

        if ($s->contains('flixsterios', false)) {
            return $this->loader->load('flixster app', $useragent);
        }

        if ($s->containsAny(['adbeat_bot', 'adbeat.com'], false)) {
            return $this->loader->load('adbeat bot', $useragent);
        }

        if ($s->containsAny(['secondlife', 'second life'], false)) {
            return $this->loader->load('second live client', $useragent);
        }

        if ($s->containsAny(['salesforce1', 'salesforcetouchcontainer'], false)) {
            return $this->loader->load('salesforce app', $useragent);
        }

        if ($s->containsAny(['nagios-plugins', 'check_http'], false)) {
            return $this->loader->load('nagios', $useragent);
        }

        if ($s->contains('bingbot', false)) {
            return $this->loader->load('bingbot', $useragent);
        }

        if ($s->contains('mediapartners-google', false)) {
            return $this->loader->load('adsense bot', $useragent);
        }

        if ($s->contains('smtbot', false)) {
            return $this->loader->load('smtbot', $useragent);
        }

        if ($s->contains('diigobrowser', false)) {
            return $this->loader->load('diigo browser', $useragent);
        }

        if ($s->contains('kontact', false)) {
            return $this->loader->load('kontact', $useragent);
        }

        if ($s->contains('qupzilla', false)) {
            return $this->loader->load('qupzilla', $useragent);
        }

        if ($s->contains('fxios', false)) {
            return $this->loader->load('firefox for ios', $useragent);
        }

        if ($s->contains('qutebrowser', false)) {
            return $this->loader->load('qutebrowser', $useragent);
        }

        if ($s->contains('otter', false)) {
            return $this->loader->load('otter', $useragent);
        }

        if ($s->contains('palemoon', false)) {
            return $this->loader->load('palemoon', $useragent);
        }

        if ($s->contains('slurp', false)) {
            return $this->loader->load('slurp', $useragent);
        }

        if ($s->contains('applebot', false)) {
            return $this->loader->load('applebot', $useragent);
        }

        if ($s->contains('soundcloud', false)) {
            return $this->loader->load('soundcloud app', $useragent);
        }

        if ($s->contains('rival iq', false)) {
            return $this->loader->load('rival iq bot', $useragent);
        }

        if ($s->contains('evernote clip resolver', false)) {
            return $this->loader->load('evernote clip resolver', $useragent);
        }

        if ($s->contains('evernote', false)) {
            return $this->loader->load('evernote app', $useragent);
        }

        if ($s->contains('fluid', false)) {
            return $this->loader->load('fluid', $useragent);
        }

        if ($s->contains('safari', false)) {
            return $this->loader->load('safari', $useragent);
        }

        if (preg_match('/^Mozilla\/(4|5)\.0 \(Macintosh; .* Mac OS X .*\) AppleWebKit\/.* \(KHTML, like Gecko\) Version\/[\d\.]+$/i', $useragent)) {
            return $this->loader->load('safari', $useragent);
        }

        if ($s->contains('twcan/sportsnet', false)) {
            return $this->loader->load('twc sportsnet', $useragent);
        }

        if ($s->contains('adobeair', false)) {
            return $this->loader->load('adobe air', $useragent);
        }

        if ($s->contains('easouspider', false)) {
            return $this->loader->load('easouspider', $useragent);
        }

        if (preg_match('/^Mozilla\/5\.0.*\((iPhone|iPad|iPod).*\).*AppleWebKit\/.*\(.*KHTML, like Gecko.*\).*Mobile.*/i', $useragent)) {
            return $this->loader->load('mobile safari uiwebview', $useragent);
        }

        if ($s->contains('waterfox', false)) {
            return $this->loader->load('waterfox', $useragent);
        }

        if ($s->contains('thunderbird', false)) {
            return $this->loader->load('thunderbird', $useragent);
        }

        if ($s->contains('fennec', false)) {
            return $this->loader->load('fennec', $useragent);
        }

        if ($s->contains('myibrow', false)) {
            return $this->loader->load('my internet browser', $useragent);
        }

        if ($s->contains('daumoa', false)) {
            return $this->loader->load('daumoa', $useragent);
        }

        if ($s->containsAny(['unister-test', 'unistertesting', 'unister-https-test'], false)) {
            return $this->loader->load('unistertesting', $useragent);
        }

        if ($s->contains('iceweasel', false)) {
            return $this->loader->load('iceweasel', $useragent);
        }

        if ($s->contains('icecat', false)) {
            return $this->loader->load('icecat', $useragent);
        }

        if ($s->contains('iceape', false)) {
            return $this->loader->load('iceape', $useragent);
        }

        if ($s->contains('galeon', false)) {
            return $this->loader->load('galeon', $useragent);
        }

        if ($s->contains('surveybot', false)) {
            return $this->loader->load('surveybot', $useragent);
        }

        if ($s->contains('aggregator:spinn3r', false)) {
            return $this->loader->load('spinn3r rss aggregator', $useragent);
        }

        if ($s->contains('tweetmemebot', false)) {
            return $this->loader->load('tweetmeme bot', $useragent);
        }

        if ($s->contains('butterfly', false)) {
            return $this->loader->load('butterfly robot', $useragent);
        }

        if ($s->contains('james bot', false)) {
            return $this->loader->load('jamesbot', $useragent);
        }

        if ($s->contains('msie or firefox mutant; not on Windows server', false)) {
            return $this->loader->load('daumoa', $useragent);
        }

        if ($s->contains('sailfishbrowser', false)) {
            return $this->loader->load('sailfish browser', $useragent);
        }

        if ($s->contains('kazehakase', false)) {
            return $this->loader->load('kazehakase', $useragent);
        }

        if ($s->contains('cometbird', false)) {
            return $this->loader->load('cometbird', $useragent);
        }

        if ($s->contains('camino', false)) {
            return $this->loader->load('camino', $useragent);
        }

        if ($s->contains('slimerjs', false)) {
            return $this->loader->load('slimerjs', $useragent);
        }

        if ($s->contains('multizilla', false)) {
            return $this->loader->load('multizilla', $useragent);
        }

        if ($s->contains('minimo', false)) {
            return $this->loader->load('minimo', $useragent);
        }

        if ($s->containsAny(['microb', 'maemo browser', 'maemobrowser'], false)) {
            return $this->loader->load('microb', $useragent);
        }

        if ($s->contains('k-meleon', false)) {
            return $this->loader->load('k-meleon', $useragent);
        }

        if ($s->contains('curb', false)) {
            return $this->loader->load('curb', $useragent);
        }

        if ($s->contains('link_thumbnailer', false)) {
            return $this->loader->load('link_thumbnailer', $useragent);
        }

        if ($s->contains('mechanize', false)) {
            return $this->loader->load('mechanize', $useragent);
        }

        if ($s->contains('ruby', false)) {
            return $this->loader->load('generic ruby crawler', $useragent);
        }

        if ($s->contains('googleimageproxy', false)) {
            return $this->loader->load('google image proxy', $useragent);
        }

        if ($s->contains('dalvik', false)) {
            return $this->loader->load('dalvik', $useragent);
        }

        if ($s->contains('bb_work_connect', false)) {
            return $this->loader->load('bb work connect', $useragent);
        }

        if ($s->containsAny(['firefox', 'minefield', 'shiretoko', 'bonecho', 'namoroka'], false)) {
            return $this->loader->load('firefox', $useragent);
        }

        if ($s->contains('gvfs', false)) {
            return $this->loader->load('gvfs', $useragent);
        }

        if ($s->contains('luakit', false)) {
            return $this->loader->load('luakit', $useragent);
        }

        if ($s->contains('playstation 3', false)) {
            return $this->loader->load('netfront', $useragent);
        }

        if ($s->contains('sistrix', false)) {
            return $this->loader->load('sistrix crawler', $useragent);
        }

        if ($s->contains('ezooms', false)) {
            return $this->loader->load('ezooms', $useragent);
        }

        if ($s->contains('grapefx', false)) {
            return $this->loader->load('grapefx', $useragent);
        }

        if ($s->contains('grapeshotcrawler', false)) {
            return $this->loader->load('grapeshotcrawler', $useragent);
        }

        if ($s->contains('mail.ru', false)) {
            return $this->loader->load('mail.ru', $useragent);
        }

        if ($s->contains('proximic', false)) {
            return $this->loader->load('proximic', $useragent);
        }

        if ($s->contains('polaris', false)) {
            return $this->loader->load('polaris', $useragent);
        }

        if ($s->containsAny(['another web mining tool', 'awmt'], false)) {
            return $this->loader->load('another web mining tool', $useragent);
        }

        if ($s->containsAny(['wbsearchbot', 'wbsrch'], false)) {
            return $this->loader->load('wbsearchbot', $useragent);
        }

        if ($s->contains('konqueror', false)) {
            return $this->loader->load('konqueror', $useragent);
        }

        if ($s->contains('typo3-linkvalidator', false)) {
            return $this->loader->load('typo3 linkvalidator', $useragent);
        }

        if ($s->contains('feeddlerrss', false)) {
            return $this->loader->load('feeddler rss reader', $useragent);
        }

        if (preg_match('/^mozilla\/5\.0 \((iphone|ipad|ipod).*CPU like Mac OS X.*\) AppleWebKit\/\d+/i', $useragent)) {
            return $this->loader->load('safari', $useragent);
        }

        if ($s->containsAny(['ios', 'iphone', 'ipad', 'ipod'], false)) {
            return $this->loader->load('mobile safari uiwebview', $useragent);
        }

        if ($s->contains('paperlibot', false)) {
            return $this->loader->load('paper.li bot', $useragent);
        }

        if ($s->contains('spbot', false)) {
            return $this->loader->load('seoprofiler', $useragent);
        }

        if ($s->contains('dotbot', false)) {
            return $this->loader->load('dotbot', $useragent);
        }

        if ($s->containsAny(['google-structureddatatestingtool', 'google-structured-data-testing-tool'], false)) {
            return $this->loader->load('google structured-data testingtool', $useragent);
        }

        if ($s->contains('webmastercoffee', false)) {
            return $this->loader->load('webmastercoffee', $useragent);
        }

        if ($s->contains('ahrefs', false)) {
            return $this->loader->load('ahrefsbot', $useragent);
        }

        if ($s->contains('apercite', false)) {
            return $this->loader->load('apercite', $useragent);
        }

        if ($s->contains('woobot', false)) {
            return $this->loader->load('woobot', $useragent);
        }

        if ($s->contains('scoutjet', false)) {
            return $this->loader->load('scoutjet', $useragent);
        }

        if ($s->contains('blekkobot', false)) {
            return $this->loader->load('blekkobot', $useragent);
        }

        if ($s->contains('pagesinventory', false)) {
            return $this->loader->load('pagesinventory bot', $useragent);
        }

        if ($s->contains('slackbot-linkexpanding', false)) {
            return $this->loader->load('slackbot-link-expanding', $useragent);
        }

        if ($s->contains('slackbot', false)) {
            return $this->loader->load('slackbot', $useragent);
        }

        if ($s->contains('seokicks-robot', false)) {
            return $this->loader->load('seokicks robot', $useragent);
        }

        if ($s->contains('alexabot', false)) {
            return $this->loader->load('alexabot', $useragent);
        }

        if ($s->contains('exabot', false)) {
            return $this->loader->load('exabot', $useragent);
        }

        if ($s->contains('domainscan', false)) {
            return $this->loader->load('domainscan server monitoring', $useragent);
        }

        if ($s->contains('jobroboter', false)) {
            return $this->loader->load('jobroboter', $useragent);
        }

        if ($s->contains('acoonbot', false)) {
            return $this->loader->load('acoonbot', $useragent);
        }

        if ($s->contains('woriobot', false)) {
            return $this->loader->load('woriobot', $useragent);
        }

        if ($s->contains('monobot', false)) {
            return $this->loader->load('monobot', $useragent);
        }

        if ($s->contains('domainsigmacrawler', false)) {
            return $this->loader->load('domainsigmacrawler', $useragent);
        }

        if ($s->contains('bnf.fr_bot', false)) {
            return $this->loader->load('bnf.fr bot', $useragent);
        }

        if ($s->contains('crawlrobot', false)) {
            return $this->loader->load('crawlrobot', $useragent);
        }

        if ($s->contains('addthis.com robot', false)) {
            return $this->loader->load('addthis.com robot', $useragent);
        }

        if ($s->containsAny(['yeti', 'naver.com/robots'], false)) {
            return $this->loader->load('naverbot', $useragent);
        }

        if ($s->startsWith('robots', false)) {
            return $this->loader->load('testcrawler', $useragent);
        }

        if ($s->contains('deusu', false)) {
            return $this->loader->load('werbefreie deutsche suchmaschine', $useragent);
        }

        if ($s->contains('obot', false)) {
            return $this->loader->load('obot', $useragent);
        }

        if ($s->contains('zumbot', false)) {
            return $this->loader->load('zumbot', $useragent);
        }

        if ($s->contains('umbot', false)) {
            return $this->loader->load('umbot', $useragent);
        }

        if ($s->contains('picmole', false)) {
            return $this->loader->load('picmole bot', $useragent);
        }

        if ($s->contains('zollard', false)) {
            return $this->loader->load('zollard worm', $useragent);
        }

        if ($s->contains('fhscan core', false)) {
            return $this->loader->load('fhscan core', $useragent);
        }

        if ($s->contains('nbot', false)) {
            return $this->loader->load('nbot', $useragent);
        }

        if ($s->contains('loadtimebot', false)) {
            return $this->loader->load('loadtimebot', $useragent);
        }

        if ($s->contains('scrubby', false)) {
            return $this->loader->load('scrubby', $useragent);
        }

        if ($s->contains('squzer', false)) {
            return $this->loader->load('squzer', $useragent);
        }

        if ($s->contains('piplbot', false)) {
            return $this->loader->load('piplbot', $useragent);
        }

        if ($s->contains('everyonesocialbot', false)) {
            return $this->loader->load('everyonesocialbot', $useragent);
        }

        if ($s->contains('aolbot', false)) {
            return $this->loader->load('aolbot', $useragent);
        }

        if ($s->contains('glbot', false)) {
            return $this->loader->load('glbot', $useragent);
        }

        if ($s->contains('lbot', false)) {
            return $this->loader->load('lbot', $useragent);
        }

        if ($s->contains('blexbot', false)) {
            return $this->loader->load('blexbot', $useragent);
        }

        if ($s->contains('socialradarbot', false)) {
            return $this->loader->load('socialradar bot', $useragent);
        }

        if ($s->contains('synapse', false)) {
            return $this->loader->load('apache synapse', $useragent);
        }

        if ($s->contains('linkdexbot', false)) {
            return $this->loader->load('linkdex bot', $useragent);
        }

        if ($s->contains('coccoc', false)) {
            return $this->loader->load('coccoc bot', $useragent);
        }

        if ($s->contains('siteexplorer', false)) {
            return $this->loader->load('siteexplorer', $useragent);
        }

        if ($s->contains('semrushbot', false)) {
            return $this->loader->load('semrushbot', $useragent);
        }

        if ($s->contains('istellabot', false)) {
            return $this->loader->load('istellabot', $useragent);
        }

        if ($s->contains('meanpathbot', false)) {
            return $this->loader->load('meanpathbot', $useragent);
        }

        if ($s->contains('xml sitemaps generator', false)) {
            return $this->loader->load('xml sitemaps generator', $useragent);
        }

        if ($s->contains('seznambot', false)) {
            return $this->loader->load('seznambot', $useragent);
        }

        if ($s->contains('urlappendbot', false)) {
            return $this->loader->load('urlappendbot', $useragent);
        }

        if ($s->contains('netseer crawler', false)) {
            return $this->loader->load('netseer crawler', $useragent);
        }

        if ($s->contains('add catalog', false)) {
            return $this->loader->load('add catalog', $useragent);
        }

        if ($s->contains('moreover', false)) {
            return $this->loader->load('moreover', $useragent);
        }

        if ($s->contains('linkpadbot', false)) {
            return $this->loader->load('linkpadbot', $useragent);
        }

        if ($s->contains('lipperhey seo service', false)) {
            return $this->loader->load('lipperhey seo service', $useragent);
        }

        if ($s->contains('blog search', false)) {
            return $this->loader->load('blog search', $useragent);
        }

        if ($s->contains('qualidator.com bot', false)) {
            return $this->loader->load('qualidator.com bot', $useragent);
        }

        if ($s->contains('fr-crawler', false)) {
            return $this->loader->load('fr-crawler', $useragent);
        }

        if ($s->contains('ca-crawler', false)) {
            return $this->loader->load('ca-crawler', $useragent);
        }

        if ($s->contains('website thumbnail generator', false)) {
            return $this->loader->load('website thumbnail generator', $useragent);
        }

        if ($s->contains('webthumb', false)) {
            return $this->loader->load('webthumb', $useragent);
        }

        if ($s->contains('komodiabot', false)) {
            return $this->loader->load('komodiabot', $useragent);
        }

        if ($s->contains('grouphigh', false)) {
            return $this->loader->load('grouphigh bot', $useragent);
        }

        if ($s->contains('theoldreader', false)) {
            return $this->loader->load('the old reader', $useragent);
        }

        if ($s->contains('google-site-verification', false)) {
            return $this->loader->load('google-site-verification', $useragent);
        }

        if ($s->contains('prlog', false)) {
            return $this->loader->load('prlog', $useragent);
        }

        if ($s->contains('cms crawler', false)) {
            return $this->loader->load('cms crawler', $useragent);
        }

        if ($s->contains('pmoz.info odp link checker', false)) {
            return $this->loader->load('pmoz.info odp link checker', $useragent);
        }

        if ($s->contains('twingly recon', false)) {
            return $this->loader->load('twingly recon', $useragent);
        }

        if ($s->contains('embedly', false)) {
            return $this->loader->load('embedly', $useragent);
        }

        if ($s->contains('alexa site audit', false)) {
            return $this->loader->load('alexa site audit', $useragent);
        }

        if ($s->contains('mj12bot', false)) {
            return $this->loader->load('mj12bot', $useragent);
        }

        if ($s->contains('httrack', false)) {
            return $this->loader->load('httrack', $useragent);
        }

        if ($s->contains('unisterbot', false)) {
            return $this->loader->load('unisterbot', $useragent);
        }

        if ($s->contains('careerbot', false)) {
            return $this->loader->load('careerbot', $useragent);
        }

        if ($s->containsAny(['80legs', '80bot'], false)) {
            return $this->loader->load('80legs', $useragent);
        }

        if ($s->contains('wada.vn', false)) {
            return $this->loader->load('wada.vn search bot', $useragent);
        }

        if ($s->contains('NX', true)) {
            return $this->loader->load('netfront nx', $useragent);
        }

        if ($s->containsAny(['wiiu', 'nintendo 3ds'], false)) {
            return $this->loader->load('netfront nx', $useragent);
        }

        if ($s->containsAny(['netfront', 'playstation 4'], false)) {
            return $this->loader->load('netfront', $useragent);
        }

        if ($s->contains('xovibot', false)) {
            return $this->loader->load('xovibot', $useragent);
        }

        if ($s->contains('007ac9 crawler', false)) {
            return $this->loader->load('007ac9 crawler', $useragent);
        }

        if ($s->contains('200pleasebot', false)) {
            return $this->loader->load('200pleasebot', $useragent);
        }

        if ($s->contains('abonti', false)) {
            return $this->loader->load('abonti websearch', $useragent);
        }

        if ($s->contains('publiclibraryarchive', false)) {
            return $this->loader->load('publiclibraryarchive bot', $useragent);
        }

        if ($s->contains('pad-bot', false)) {
            return $this->loader->load('pad-bot', $useragent);
        }

        if ($s->contains('softlistbot', false)) {
            return $this->loader->load('softlistbot', $useragent);
        }

        if ($s->contains('sreleasebot', false)) {
            return $this->loader->load('sreleasebot', $useragent);
        }

        if ($s->contains('vagabondo', false)) {
            return $this->loader->load('vagabondo', $useragent);
        }

        if ($s->contains('special_archiver', false)) {
            return $this->loader->load('internet archive special archiver', $useragent);
        }

        if ($s->contains('optimizer', false)) {
            return $this->loader->load('optimizer bot', $useragent);
        }

        if ($s->contains('sophora linkchecker', false)) {
            return $this->loader->load('sophora linkchecker', $useragent);
        }

        if ($s->contains('seodiver', false)) {
            return $this->loader->load('seodiver bot', $useragent);
        }

        if ($s->contains('itsscan', false)) {
            return $this->loader->load('itsscan', $useragent);
        }

        if ($s->contains('google desktop', false)) {
            return $this->loader->load('google desktop', $useragent);
        }

        if ($s->contains('lotus-notes', false)) {
            return $this->loader->load('lotus notes', $useragent);
        }

        if ($s->contains('askpeterbot', false)) {
            return $this->loader->load('askpeterbot', $useragent);
        }

        if ($s->contains('discoverybot', false)) {
            return $this->loader->load('discovery bot', $useragent);
        }

        if ($s->contains('yandexbot', false)) {
            return $this->loader->load('yandexbot', $useragent);
        }

        if ($s->containsAll(['mosbookmarks', 'link checker'], false)) {
            return $this->loader->load('mosbookmarks link checker', $useragent);
        }

        if ($s->contains('mosbookmarks', false)) {
            return $this->loader->load('mosbookmarks', $useragent);
        }

        if ($s->contains('webmasteraid', false)) {
            return $this->loader->load('webmasteraid', $useragent);
        }

        if ($s->contains('aboutusbot johnny5', false)) {
            return $this->loader->load('aboutus bot johnny5', $useragent);
        }

        if ($s->contains('aboutusbot', false)) {
            return $this->loader->load('aboutus bot', $useragent);
        }

        if ($s->contains('semantic-visions.com crawler', false)) {
            return $this->loader->load('semantic-visions.com crawler', $useragent);
        }

        if ($s->contains('waybackarchive.org', false)) {
            return $this->loader->load('wayback archive bot', $useragent);
        }

        if ($s->contains('openvas', false)) {
            return $this->loader->load('open vulnerability assessment system', $useragent);
        }

        if ($s->contains('mixrankbot', false)) {
            return $this->loader->load('mixrankbot', $useragent);
        }

        if ($s->contains('infegyatlas', false)) {
            return $this->loader->load('infegyatlas', $useragent);
        }

        if ($s->contains('mojeekbot', false)) {
            return $this->loader->load('mojeekbot', $useragent);
        }

        if ($s->contains('memorybot', false)) {
            return $this->loader->load('memorybot', $useragent);
        }

        if ($s->contains('domainappender', false)) {
            return $this->loader->load('domainappender bot', $useragent);
        }

        if ($s->contains('gidbot', false)) {
            return $this->loader->load('gidbot', $useragent);
        }

        if ($s->contains('RED', true)) {
            return $this->loader->load('redbot', $useragent);
        }

        if ($s->contains('dbot', false)) {
            return $this->loader->load('dbot', $useragent);
        }

        if ($s->contains('pwbot', false)) {
            return $this->loader->load('pwbot', $useragent);
        }

        if ($s->contains('+5bot', false)) {
            return $this->loader->load('plus5bot', $useragent);
        }

        if ($s->contains('wasalive-bot', false)) {
            return $this->loader->load('wasalive bot', $useragent);
        }

        if ($s->contains('openhosebot', false)) {
            return $this->loader->load('openhosebot', $useragent);
        }

        if ($s->contains('urlfilterdb-crawler', false)) {
            return $this->loader->load('urlfilterdb crawler', $useragent);
        }

        if ($s->contains('metager2-verification-bot', false)) {
            return $this->loader->load('metager2-verification-bot', $useragent);
        }

        if ($s->contains('powermarks', false)) {
            return $this->loader->load('powermarks', $useragent);
        }

        if ($s->contains('cloudflare-alwaysonline', false)) {
            return $this->loader->load('cloudflare alwaysonline', $useragent);
        }

        if ($s->contains('phantom.js bot', false)) {
            return $this->loader->load('phantom.js bot', $useragent);
        }

        if ($s->contains('phantom', false)) {
            return $this->loader->load('phantom browser', $useragent);
        }

        if ($s->contains('shrook', false)) {
            return $this->loader->load('shrook', $useragent);
        }

        if ($s->contains('netestate ne crawler', false)) {
            return $this->loader->load('netestate ne crawler', $useragent);
        }

        if ($s->contains('garlikcrawler', false)) {
            return $this->loader->load('garlikcrawler', $useragent);
        }

        if ($s->contains('metageneratorcrawler', false)) {
            return $this->loader->load('metageneratorcrawler', $useragent);
        }

        if ($s->contains('screenerbot', false)) {
            return $this->loader->load('screenerbot', $useragent);
        }

        if ($s->contains('webtarantula.com crawler', false)) {
            return $this->loader->load('webtarantula', $useragent);
        }

        if ($s->contains('backlinkcrawler', false)) {
            return $this->loader->load('backlinkcrawler', $useragent);
        }

        if ($s->contains('linkscrawler', false)) {
            return $this->loader->load('linkscrawler', $useragent);
        }

        if ($s->containsAny(['ssearch_bot', 'ssearch crawler'], false)) {
            return $this->loader->load('ssearch crawler', $useragent);
        }

        if ($s->contains('hrcrawler', false)) {
            return $this->loader->load('hrcrawler', $useragent);
        }

        if ($s->contains('icc-crawler', false)) {
            return $this->loader->load('icc-crawler', $useragent);
        }

        if ($s->contains('arachnida web crawler', false)) {
            return $this->loader->load('arachnida web crawler', $useragent);
        }

        if ($s->contains('finderlein research crawler', false)) {
            return $this->loader->load('finderlein research crawler', $useragent);
        }

        if ($s->contains('testcrawler', false)) {
            return $this->loader->load('testcrawler', $useragent);
        }

        if ($s->contains('scopia crawler', false)) {
            return $this->loader->load('scopia crawler', $useragent);
        }

        if ($s->contains('metajobbot', false)) {
            return $this->loader->load('metajobbot', $useragent);
        }

        if ($s->contains('lucidworks', false)) {
            return $this->loader->load('lucidworks bot', $useragent);
        }

        if ($s->contains('pub-crawler', false)) {
            return $this->loader->load('pub-crawler', $useragent);
        }

        if ($s->contains('archive.org.ua crawler', false)) {
            return $this->loader->load('internet archive', $useragent);
        }

        if ($s->contains('digincore bot', false)) {
            return $this->loader->load('digincore bot', $useragent);
        }

        if ($s->contains('steeler', false)) {
            return $this->loader->load('steeler', $useragent);
        }

        if ($s->contains('electricmonk', false)) {
            return $this->loader->load('duedil crawler', $useragent);
        }

        if ($s->contains('virtuoso', false)) {
            return $this->loader->load('virtuoso', $useragent);
        }

        if ($s->contains('discovered', false)) {
            return $this->loader->load('discovered', $useragent);
        }

        if ($s->contains('aboundex', false)) {
            return $this->loader->load('aboundexbot', $useragent);
        }

        if ($s->contains('r6_commentreader', false)) {
            return $this->loader->load('r6 commentreader', $useragent);
        }

        if ($s->contains('r6_feedfetcher', false)) {
            return $this->loader->load('r6 feedfetcher', $useragent);
        }

        if ($s->contains('crazywebcrawler', false)) {
            return $this->loader->load('crazywebcrawler', $useragent);
        }

        if ($s->contains('crawler4j', false)) {
            return $this->loader->load('crawler4j', $useragent);
        }

        if ($s->contains('ichiro/mobile', false)) {
            return $this->loader->load('ichiro mobile bot', $useragent);
        }

        if ($s->contains('ichiro', false)) {
            return $this->loader->load('ichiro bot', $useragent);
        }

        if ($s->contains('tineye-bot', false)) {
            return $this->loader->load('tineye bot', $useragent);
        }

        if ($s->contains('livelapbot', false)) {
            return $this->loader->load('livelap crawler', $useragent);
        }

        if ($s->contains('safesearch microdata crawler', false)) {
            return $this->loader->load('safesearch microdata crawler', $useragent);
        }

        if ($s->contains('fastbot crawler', false)) {
            return $this->loader->load('fastbot crawler', $useragent);
        }

        if ($s->contains('camcrawler', false)) {
            return $this->loader->load('camcrawler', $useragent);
        }

        if ($s->contains('domaincrawler', false)) {
            return $this->loader->load('domaincrawler', $useragent);
        }

        if ($s->contains('pagefreezer', false)) {
            return $this->loader->load('pagefreezer', $useragent);
        }

        if ($s->contains('showyoubot', false)) {
            return $this->loader->load('showyoubot', $useragent);
        }

        if ($s->containsAny(['y!j-asr', 'y!j-bsc'], false)) {
            return $this->loader->load('yahoo! japan', $useragent);
        }

        if ($s->contains('rogerbot', false)) {
            return $this->loader->load('rogerbot', $useragent);
        }

        if ($s->contains('crawler', false)) {
            return $this->loader->load('crawler', $useragent);
        }

        if ($s->contains('jig browser web', false)) {
            return $this->loader->load('jig browser web', $useragent);
        }

        if ($s->contains('t-h-u-n-d-e-r-s-t-o-n-e', false)) {
            return $this->loader->load('texis webscript', $useragent);
        }

        if ($s->contains('focuseekbot', false)) {
            return $this->loader->load('focuseekbot', $useragent);
        }

        if ($s->contains('vbseo', false)) {
            return $this->loader->load('vbulletin seo bot', $useragent);
        }

        if ($s->contains('kgbody', false)) {
            return $this->loader->load('kgbody', $useragent);
        }

        if ($s->contains('jobdiggerspider', false)) {
            return $this->loader->load('jobdiggerspider', $useragent);
        }

        if ($s->contains('imrbot', false)) {
            return $this->loader->load('mignify bot', $useragent);
        }

        if ($s->contains('kulturarw3', false)) {
            return $this->loader->load('kulturarw3', $useragent);
        }

        if ($s->contains('merchantcentricbot', false)) {
            return $this->loader->load('merchantcentricbot', $useragent);
        }

        if ($s->contains('nett.io bot', false)) {
            return $this->loader->load('nett.io bot', $useragent);
        }

        if ($s->contains('semanticbot', false)) {
            return $this->loader->load('semanticbot', $useragent);
        }

        if ($s->contains('tweetedtimes', false)) {
            return $this->loader->load('tweetedtimes bot', $useragent);
        }

        if ($s->contains('vkShare', false)) {
            return $this->loader->load('vkshare', $useragent);
        }

        if ($s->contains('yahoo ad monitoring', false)) {
            return $this->loader->load('yahoo ad monitoring', $useragent);
        }

        if ($s->contains('yioopbot', false)) {
            return $this->loader->load('yioopbot', $useragent);
        }

        if ($s->contains('zitebot', false)) {
            return $this->loader->load('zitebot', $useragent);
        }

        if ($s->contains('espial', false)) {
            return $this->loader->load('espial tv browser', $useragent);
        }

        if ($s->contains('sitecon', false)) {
            return $this->loader->load('sitecon', $useragent);
        }

        if ($s->contains('ibooks author', false)) {
            return $this->loader->load('ibooks author', $useragent);
        }

        if ($s->contains('iweb', false)) {
            return $this->loader->load('iweb', $useragent);
        }

        if ($s->contains('newsfire', false)) {
            return $this->loader->load('newsfire', $useragent);
        }

        if ($s->contains('rmsnapkit', false)) {
            return $this->loader->load('rmsnapkit', $useragent);
        }

        if ($s->contains('sandvox', false)) {
            return $this->loader->load('sandvox', $useragent);
        }

        if ($s->contains('tubetv', false)) {
            return $this->loader->load('tubetv', $useragent);
        }

        if ($s->contains('elluminate live', false)) {
            return $this->loader->load('elluminate live', $useragent);
        }

        if ($s->contains('element browser', false)) {
            return $this->loader->load('element browser', $useragent);
        }

        if ($s->contains('esribot', false)) {
            return $this->loader->load('esribot', $useragent);
        }

        if ($s->contains('quicklook', false)) {
            return $this->loader->load('quicklook', $useragent);
        }

        if ($s->contains('dillo', false)) {
            return $this->loader->load('dillo', $useragent);
        }

        if ($s->contains('digg', false)) {
            return $this->loader->load('digg bot', $useragent);
        }

        if ($s->contains('zetakey', false)) {
            return $this->loader->load('zetakey browser', $useragent);
        }

        if ($s->contains('getprismatic.com', false)) {
            return $this->loader->load('prismatic app', $useragent);
        }

        if ($s->containsAny(['FOMA', 'SH05C'], true)) {
            return $this->loader->load('sharp', $useragent);
        }

        if ($s->contains('openwebkitsharp', false)) {
            return $this->loader->load('open-webkit-sharp', $useragent);
        }

        if ($s->contains('ajaxsnapbot', false)) {
            return $this->loader->load('ajaxsnapbot', $useragent);
        }

        if ($s->contains('owler', false)) {
            return $this->loader->load('owler bot', $useragent);
        }

        if ($s->contains('yahoo link preview', false)) {
            return $this->loader->load('yahoo link preview', $useragent);
        }

        if ($s->containsAll(['kraken', 'linkfluence'], false)) {
            return $this->loader->load('kraken', $useragent);
        }

        if ($s->contains('qwantify', false)) {
            return $this->loader->load('qwantify', $useragent);
        }

        if ($s->contains('setlinks bot', false)) {
            return $this->loader->load('setlinks.ru crawler', $useragent);
        }

        if ($s->contains('megaindex.ru', false)) {
            return $this->loader->load('megaindex bot', $useragent);
        }

        if ($s->contains('cliqzbot', false)) {
            return $this->loader->load('cliqzbot', $useragent);
        }

        if ($s->contains('dawinci antiplag spider', false)) {
            return $this->loader->load('dawinci antiplag spider', $useragent);
        }

        if ($s->contains('advbot', false)) {
            return $this->loader->load('advbot', $useragent);
        }

        if ($s->contains('duckduckgo-favicons-bot', false)) {
            return $this->loader->load('duckduck favicons bot', $useragent);
        }

        if ($s->contains('zyborg', false)) {
            return $this->loader->load('wisenut search engine crawler', $useragent);
        }

        if ($s->contains('hypercrawl', false)) {
            return $this->loader->load('hypercrawl', $useragent);
        }

        if ($s->contains('worldwebheritage', false)) {
            return $this->loader->load('worldwebheritage.org bot', $useragent);
        }

        if ($s->contains('begunadvertising', false)) {
            return $this->loader->load('begun advertising bot', $useragent);
        }

        if ($s->contains('trendwinhttp', false)) {
            return $this->loader->load('trendwinhttp', $useragent);
        }

        if ($s->contains('winhttp', false)) {
            return $this->loader->load('winhttp', $useragent);
        }

        if ($s->contains('skypeuripreview', false)) {
            return $this->loader->load('skypeuripreview', $useragent);
        }

        if ($s->contains('lipperhey-kaus-australis', false)) {
            return $this->loader->load('lipperhey kaus australis', $useragent);
        }

        if ($s->contains('jasmine', false)) {
            return $this->loader->load('jasmine', $useragent);
        }

        if ($s->contains('yoozbot', false)) {
            return $this->loader->load('yoozbot', $useragent);
        }

        if ($s->contains('online-webceo-bot', false)) {
            return $this->loader->load('webceo bot', $useragent);
        }

        if ($s->contains('niki-bot', false)) {
            return $this->loader->load('niki-bot', $useragent);
        }

        if ($s->contains('contextad bot', false)) {
            return $this->loader->load('contextad bot', $useragent);
        }

        if ($s->contains('integrity', false)) {
            return $this->loader->load('integrity', $useragent);
        }

        if ($s->contains('masscan', false)) {
            return $this->loader->load('masscan', $useragent);
        }

        if ($s->contains('zmeu', false)) {
            return $this->loader->load('zmeu', $useragent);
        }

        if ($s->contains('sogou web spider', false)) {
            return $this->loader->load('sogou web spider', $useragent);
        }

        if ($s->containsAny(['openwave', 'up.browser'], false)) {
            return $this->loader->load('openwave mobile browser', $useragent);
        }

        if ($s->contains('UP/', true)) {
            return $this->loader->load('openwave mobile browser', $useragent);
        }

        if (preg_match('/(obigointernetbrowser|obigo\-browser|obigo|telecabrowser|teleca)(\/|-)q(\d+)/i', $useragent)) {
            return $this->loader->load('obigo q', $useragent);
        }

        if ($s->containsAny(['teleca', 'obigo', 'au-mic', 'mic/'], false)) {
            return $this->loader->load('teleca-obigo', $useragent);
        }

        if ($s->contains('davclnt', false)) {
            return $this->loader->load('microsoft-webdav', $useragent);
        }

        if ($s->contains('xing-contenttabreceiver', false)) {
            return $this->loader->load('xing contenttabreceiver', $useragent);
        }

        if ($s->contains('slingstone', false)) {
            return $this->loader->load('yahoo slingstone', $useragent);
        }

        if ($s->contains('bot for jce', false)) {
            return $this->loader->load('bot for jce', $useragent);
        }

        if ($s->contains('validator.nu/lv', false)) {
            return $this->loader->load('validator.nu/lv', $useragent);
        }

        if ($s->contains('securepoint cf', false)) {
            return $this->loader->load('securepoint content filter', $useragent);
        }

        if ($s->contains('sogou-spider', false)) {
            return $this->loader->load('sogou spider', $useragent);
        }

        if ($s->contains('rankflex', false)) {
            return $this->loader->load('rankflex', $useragent);
        }

        if ($s->contains('domnutch', false)) {
            return $this->loader->load('domnutch bot', $useragent);
        }

        if ($s->contains('nutch', false)) {
            return $this->loader->load('nutch', $useragent);
        }

        if ($s->contains('boardreader favicon fetcher', false)) {
            return $this->loader->load('boardreader favicon fetcher', $useragent);
        }

        if ($s->contains('checksite verification agent', false)) {
            return $this->loader->load('checksite verification agent', $useragent);
        }

        if ($s->contains('experibot', false)) {
            return $this->loader->load('experibot', $useragent);
        }

        if ($s->contains('feedblitz', false)) {
            return $this->loader->load('feedblitz', $useragent);
        }

        if ($s->contains('rss2html', false)) {
            return $this->loader->load('rss2html', $useragent);
        }

        if ($s->contains('feedlyapp', false)) {
            return $this->loader->load('feedly app', $useragent);
        }

        if ($s->contains('genderanalyzer', false)) {
            return $this->loader->load('genderanalyzer', $useragent);
        }

        if ($s->contains('gooblog', false)) {
            return $this->loader->load('gooblog', $useragent);
        }

        if ($s->contains('tumblr', false)) {
            return $this->loader->load('tumblr app', $useragent);
        }

        if ($s->contains('w3c_i18n-checker', false)) {
            return $this->loader->load('w3c i18n checker', $useragent);
        }

        if ($s->contains('w3c_unicorn', false)) {
            return $this->loader->load('w3c unicorn', $useragent);
        }

        if ($s->contains('alltop', false)) {
            return $this->loader->load('alltop app', $useragent);
        }

        if ($s->contains('internetseer', false)) {
            return $this->loader->load('internetseer.com', $useragent);
        }

        if ($s->contains('admantx platform semantic analyzer', false)) {
            return $this->loader->load('admantx platform semantic analyzer', $useragent);
        }

        if ($s->contains('universalfeedparser', false)) {
            return $this->loader->load('universalfeedparser', $useragent);
        }

        if ($s->containsAny(['binlar', 'larbin'], false)) {
            return $this->loader->load('larbin', $useragent);
        }

        if ($s->contains('unityplayer', false)) {
            return $this->loader->load('unity web player', $useragent);
        }

        if ($s->contains('wesee:search', false)) {
            return $this->loader->load('wesee:search', $useragent);
        }

        if ($s->contains('wesee:ads', false)) {
            return $this->loader->load('wesee:ads', $useragent);
        }

        if ($s->contains('a6-indexer', false)) {
            return $this->loader->load('a6-indexer', $useragent);
        }

        if ($s->contains('nerdybot', false)) {
            return $this->loader->load('nerdybot', $useragent);
        }

        if ($s->contains('peeplo screenshot bot', false)) {
            return $this->loader->load('peeplo screenshot bot', $useragent);
        }

        if ($s->contains('ccbot', false)) {
            return $this->loader->load('ccbot', $useragent);
        }

        if ($s->contains('visionutils', false)) {
            return $this->loader->load('visionutils', $useragent);
        }

        if ($s->contains('feedly', false)) {
            return $this->loader->load('feedly feed fetcher', $useragent);
        }

        if ($s->contains('photon', false)) {
            return $this->loader->load('photon', $useragent);
        }

        if ($s->contains('wdg_validator', false)) {
            return $this->loader->load('html validator', $useragent);
        }

        if ($s->contains('yisouspider', false)) {
            return $this->loader->load('yisouspider', $useragent);
        }

        if ($s->contains('hivabot', false)) {
            return $this->loader->load('hivabot', $useragent);
        }

        if ($s->contains('comodo spider', false)) {
            return $this->loader->load('comodo spider', $useragent);
        }

        if ($s->contains('openwebspider', false)) {
            return $this->loader->load('openwebspider', $useragent);
        }

        if ($s->containsAny(['psbot-image', 'psbot-page'], false)) {
            return $this->loader->load('picsearch bot', $useragent);
        }

        if ($s->contains('bloglovin', false)) {
            return $this->loader->load('bloglovin bot', $useragent);
        }

        if ($s->contains('viralvideochart', false)) {
            return $this->loader->load('viralvideochart bot', $useragent);
        }

        if ($s->contains('metaheadersbot', false)) {
            return $this->loader->load('metaheadersbot', $useragent);
        }

        if ($s->containsAny(['zendhttpclient', 'zend_http_client', 'zend\http\client'], false)) {
            return $this->loader->load('zend_http_client', $useragent);
        }

        if ($s->contains('wget', false)) {
            return $this->loader->load('wget', $useragent);
        }

        if ($s->contains('scrapy', false)) {
            return $this->loader->load('scrapy', $useragent);
        }

        if ($s->contains('moozilla', false)) {
            return $this->loader->load('moozilla', $useragent);
        }

        if ($s->contains('antbot', false)) {
            return $this->loader->load('antbot', $useragent);
        }

        if ($s->contains('browsershots', false)) {
            return $this->loader->load('browsershots', $useragent);
        }

        if ($s->contains('revolt', false)) {
            return $this->loader->load('bot revolt', $useragent);
        }

        if ($s->contains('pdrlabs', false)) {
            return $this->loader->load('pdrlabs bot', $useragent);
        }

        if ($s->contains('elinks', false)) {
            return $this->loader->load('elinks', $useragent);
        }

        if ($s->contains('linkstats bot', false)) {
            return $this->loader->load('linkstats bot', $useragent);
        }

        if ($s->contains('bcklinks', false)) {
            return $this->loader->load('bcklinks', $useragent);
        }

        if ($s->contains('links', false)) {
            return $this->loader->load('links', $useragent);
        }

        if ($s->contains('airmail', false)) {
            return $this->loader->load('airmail', $useragent);
        }

        if ($s->contains('web.de mailcheck', false)) {
            return $this->loader->load('web.de mailcheck', $useragent);
        }

        if ($s->contains('screaming frog seo spider', false)) {
            return $this->loader->load('screaming frog seo spider', $useragent);
        }

        if ($s->contains('androiddownloadmanager', false)) {
            return $this->loader->load('android download manager', $useragent);
        }

        if (preg_match('/go ([\d\.]+) package http/i', $useragent)) {
            return $this->loader->load('go httpclient', $useragent);
        }

        if ($s->contains('go-http-client', false)) {
            return $this->loader->load('go httpclient', $useragent);
        }

        if ($s->contains('proxy gear pro', false)) {
            return $this->loader->load('proxy gear pro', $useragent);
        }

        if ($s->contains('wap browser/maui', false)) {
            return $this->loader->load('maui wap browser', $useragent);
        }

        if ($s->contains('tiny tiny rss', false)) {
            return $this->loader->load('tiny tiny rss', $useragent);
        }

        if ($s->contains('readability', false)) {
            return $this->loader->load('readability', $useragent);
        }

        if ($s->contains('nsplayer', false)) {
            return $this->loader->load('windows media player', $useragent);
        }

        if ($s->contains('pingdom', false)) {
            return $this->loader->load('pingdom', $useragent);
        }

        if ($s->contains('gg peekbot', false)) {
            return $this->loader->load('gg peekbot', $useragent);
        }

        if ($s->contains('itunes', false)) {
            return $this->loader->load('itunes', $useragent);
        }

        if ($s->contains('libreoffice', false)) {
            return $this->loader->load('libreoffice', $useragent);
        }

        if ($s->contains('openoffice', false)) {
            return $this->loader->load('openoffice', $useragent);
        }

        if ($s->contains('thumbnailagent', false)) {
            return $this->loader->load('thumbnailagent', $useragent);
        }

        if ($s->contains('ez publish link validator', false)) {
            return $this->loader->load('ez publish link validator', $useragent);
        }

        if ($s->contains('thumbsniper', false)) {
            return $this->loader->load('thumbsniper', $useragent);
        }

        if ($s->contains('stq_bot', false)) {
            return $this->loader->load('searchteq bot', $useragent);
        }

        if ($s->contains('snk screenshot bot', false)) {
            return $this->loader->load('save n keep screenshot bot', $useragent);
        }

        if ($s->contains('synhttpclient', false)) {
            return $this->loader->load('synhttpclient', $useragent);
        }

        if ($s->contains('eventmachine httpclient', false)) {
            return $this->loader->load('eventmachine httpclient', $useragent);
        }

        if ($s->contains('livedoor', false)) {
            return $this->loader->load('livedoor', $useragent);
        }

        if ($s->contains('httpclient', false)) {
            return $this->loader->load('httpclient', $useragent);
        }

        if ($s->contains('implisensebot', false)) {
            return $this->loader->load('implisensebot', $useragent);
        }

        if ($s->contains('buibui-bot', false)) {
            return $this->loader->load('buibui-bot', $useragent);
        }

        if ($s->contains('thumbshots-de-bot', false)) {
            return $this->loader->load('thumbshots-de-bot', $useragent);
        }

        if ($s->contains('python-requests', false)) {
            return $this->loader->load('python-requests', $useragent);
        }

        if ($s->contains('python-urllib', false)) {
            return $this->loader->load('python-urllib', $useragent);
        }

        if ($s->contains('bot.araturka.com', false)) {
            return $this->loader->load('bot.araturka.com', $useragent);
        }

        if ($s->contains('http_requester', false)) {
            return $this->loader->load('http_requester', $useragent);
        }

        if ($s->contains('whatweb', false)) {
            return $this->loader->load('whatweb web scanner', $useragent);
        }

        if ($s->contains('isc header collector handlers', false)) {
            return $this->loader->load('isc header collector handlers', $useragent);
        }

        if ($s->contains('thumbor', false)) {
            return $this->loader->load('thumbor', $useragent);
        }

        if ($s->contains('forum poster', false)) {
            return $this->loader->load('forum poster', $useragent);
        }

        if ($s->contains('facebot', false)) {
            return $this->loader->load('facebot', $useragent);
        }

        if ($s->contains('netzcheckbot', false)) {
            return $this->loader->load('netzcheckbot', $useragent);
        }

        if ($s->contains('MIB', true)) {
            return $this->loader->load('motorola internet browser', $useragent);
        }

        if ($s->contains('facebookscraper', false)) {
            return $this->loader->load('facebookscraper', $useragent);
        }

        if ($s->contains('zookabot', false)) {
            return $this->loader->load('zookabot', $useragent);
        }

        if ($s->contains('metauri', false)) {
            return $this->loader->load('metauri bot', $useragent);
        }

        if ($s->contains('freewebmonitoring sitechecker', false)) {
            return $this->loader->load('freewebmonitoring sitechecker', $useragent);
        }

        if ($s->contains('ipv4scan', false)) {
            return $this->loader->load('ipv4scan', $useragent);
        }

        if ($s->contains('domainsbot', false)) {
            return $this->loader->load('domainsbot', $useragent);
        }

        if ($s->contains('bubing', false)) {
            return $this->loader->load('bubing bot', $useragent);
        }

        if ($s->contains('ramblermail', false)) {
            return $this->loader->load('ramblermail bot', $useragent);
        }

        if ($s->contains('iisbot', false)) {
            return $this->loader->load('iis site analysis web crawler', $useragent);
        }

        if ($s->contains('jooblebot', false)) {
            return $this->loader->load('jooblebot', $useragent);
        }

        if ($s->contains('superfeedr bot', false)) {
            return $this->loader->load('superfeedr bot', $useragent);
        }

        if ($s->contains('feedburner', false)) {
            return $this->loader->load('feedburner', $useragent);
        }

        if ($s->contains('icarus6j', false)) {
            return $this->loader->load('icarus6j', $useragent);
        }

        if ($s->contains('wsr-agent', false)) {
            return $this->loader->load('wsr-agent', $useragent);
        }

        if ($s->contains('blogshares spiders', false)) {
            return $this->loader->load('blogshares spiders', $useragent);
        }

        if ($s->contains('quickiwiki', false)) {
            return $this->loader->load('quickiwiki bot', $useragent);
        }

        if ($s->contains('pycurl', false)) {
            return $this->loader->load('pycurl', $useragent);
        }

        if ($s->contains('libcurl-agent', false)) {
            return $this->loader->load('libcurl', $useragent);
        }

        if ($s->contains('taproot', false)) {
            return $this->loader->load('taproot bot', $useragent);
        }

        if ($s->contains('guzzlehttp', false)) {
            return $this->loader->load('guzzle http client', $useragent);
        }

        if ($s->contains('curl', false)) {
            return $this->loader->load('curl', $useragent);
        }

        if ($s->startsWith('PHP', true)) {
            return $this->loader->load('php', $useragent);
        }

        if ($s->contains('apple-pubsub', false)) {
            return $this->loader->load('apple pubsub', $useragent);
        }

        if ($s->contains('simplepie', false)) {
            return $this->loader->load('simplepie', $useragent);
        }

        if ($s->contains('bigbozz', false)) {
            return $this->loader->load('bigbozz - financial search', $useragent);
        }

        if ($s->contains('eccp', false)) {
            return $this->loader->load('eccp', $useragent);
        }

        if ($s->contains('facebookexternalhit', false)) {
            return $this->loader->load('facebookexternalhit', $useragent);
        }

        if ($s->contains('gigablastopensource', false)) {
            return $this->loader->load('gigablast search engine', $useragent);
        }

        if ($s->contains('webindex', false)) {
            return $this->loader->load('webindex', $useragent);
        }

        if ($s->contains('prince', false)) {
            return $this->loader->load('prince', $useragent);
        }

        if ($s->contains('adsense-snapshot-google', false)) {
            return $this->loader->load('adsense snapshot bot', $useragent);
        }

        if ($s->contains('amazon cloudfront', false)) {
            return $this->loader->load('amazon cloudfront', $useragent);
        }

        if ($s->contains('bandscraper', false)) {
            return $this->loader->load('bandscraper', $useragent);
        }

        if ($s->contains('bitlybot', false)) {
            return $this->loader->load('bitlybot', $useragent);
        }

        if ($s->contains('cars-app-browser', false)) {
            return $this->loader->load('cars-app-browser', $useragent);
        }

        if ($s->contains('coursera-mobile', false)) {
            return $this->loader->load('coursera mobile app', $useragent);
        }

        if ($s->contains('crowsnest', false)) {
            return $this->loader->load('crowsnest mobile app', $useragent);
        }

        if ($s->contains('dorado wap-browser', false)) {
            return $this->loader->load('dorado wap browser', $useragent);
        }

        if ($s->contains('goldfire server', false)) {
            return $this->loader->load('goldfire server', $useragent);
        }

        if ($s->contains('iball', false)) {
            return $this->loader->load('iball', $useragent);
        }

        if ($s->contains('inagist url resolver', false)) {
            return $this->loader->load('inagist url resolver', $useragent);
        }

        if ($s->contains('jeode', false)) {
            return $this->loader->load('jeode', $useragent);
        }

        if ($s->contains('kraken', false)) {
            return $this->loader->load('krakenjs', $useragent);
        }

        if ($s->contains('com.linkedin', false)) {
            return $this->loader->load('linkedinbot', $useragent);
        }

        if ($s->contains('mixbot', false)) {
            return $this->loader->load('mixbot', $useragent);
        }

        if ($s->contains('busecurityproject', false)) {
            return $this->loader->load('busecurityproject', $useragent);
        }

        if ($s->contains('restify', false)) {
            return $this->loader->load('restify', $useragent);
        }

        if ($s->contains('vlc', false)) {
            return $this->loader->load('vlc media player', $useragent);
        }

        if ($s->contains('webringchecker', false)) {
            return $this->loader->load('webringchecker', $useragent);
        }

        if ($s->contains('bot-pge.chlooe.com', false)) {
            return $this->loader->load('chlooe bot', $useragent);
        }

        if ($s->contains('seebot', false)) {
            return $this->loader->load('seebot', $useragent);
        }

        if ($s->contains('ltx71', false)) {
            return $this->loader->load('ltx71 bot', $useragent);
        }

        if ($s->contains('cookiereports', false)) {
            return $this->loader->load('cookie reports bot', $useragent);
        }

        if ($s->contains('elmer', false)) {
            return $this->loader->load('elmer', $useragent);
        }

        if ($s->contains('iframely', false)) {
            return $this->loader->load('iframely bot', $useragent);
        }

        if ($s->contains('metainspector', false)) {
            return $this->loader->load('metainspector', $useragent);
        }

        if ($s->contains('microsoft-cryptoapi', false)) {
            return $this->loader->load('microsoft cryptoapi', $useragent);
        }

        if ($s->contains('owasp_secret_browser', false)) {
            return $this->loader->load('owasp_secret_browser', $useragent);
        }

        if ($s->contains('smrf url expander', false)) {
            return $this->loader->load('smrf url expander', $useragent);
        }

        if ($s->containsAny(['speedyspider', 'speedy spider', 'speedy_spider'], false)) {
            return $this->loader->load('speedy spider', $useragent);
        }

        if ($s->contains('superarama.com - bot', false)) {
            return $this->loader->load('superarama.com - bot', $useragent);
        }

        if ($s->contains('wnmbot', false)) {
            return $this->loader->load('wnmbot', $useragent);
        }

        if ($s->contains('website explorer', false)) {
            return $this->loader->load('website explorer', $useragent);
        }

        if ($s->contains('city-map screenshot service', false)) {
            return $this->loader->load('city-map screenshot service', $useragent);
        }

        if ($s->contains('gosquared-thumbnailer', false)) {
            return $this->loader->load('gosquared-thumbnailer', $useragent);
        }

        if ($s->contains('optivo(r) nethelper', false)) {
            return $this->loader->load('optivo nethelper', $useragent);
        }

        if ($s->contains('pr-cy.ru screenshot bot', false)) {
            return $this->loader->load('screenshot bot', $useragent);
        }

        if ($s->contains('cyberduck', false)) {
            return $this->loader->load('cyberduck', $useragent);
        }

        if ($s->contains('lynx', false)) {
            return $this->loader->load('lynx', $useragent);
        }

        if ($s->contains('accserver', false)) {
            return $this->loader->load('accserver', $useragent);
        }

        if ($s->contains('izsearch', false)) {
            return $this->loader->load('izsearch bot', $useragent);
        }

        if ($s->contains('netlyzer fastprobe', false)) {
            return $this->loader->load('netlyzer fastprobe', $useragent);
        }

        if ($s->contains('mnogosearch', false)) {
            return $this->loader->load('mnogosearch', $useragent);
        }

        if ($s->contains('uipbot', false)) {
            return $this->loader->load('uipbot', $useragent);
        }

        if ($s->contains('mbot', false)) {
            return $this->loader->load('mbot', $useragent);
        }

        if ($s->contains('ms web services client protocol', false)) {
            return $this->loader->load('.net framework clr', $useragent);
        }

        if ($s->containsAny(['atomicbrowser', 'atomiclite'], false)) {
            return $this->loader->load('atomic browser', $useragent);
        }

        if ($s->contains('feedfetcher-google', false)) {
            return $this->loader->load('google feedfetcher', $useragent);
        }

        if ($s->contains('perfect%20browser', false)) {
            return $this->loader->load('perfect browser', $useragent);
        }

        if ($s->contains('reeder', false)) {
            return $this->loader->load('reeder', $useragent);
        }

        if ($s->contains('fastbrowser', false)) {
            return $this->loader->load('fastbrowser', $useragent);
        }

        if ($s->contains('test certificate info', false)) {
            return $this->loader->load('test certificate info', $useragent);
        }

        if ($s->contains('riddler', false)) {
            return $this->loader->load('riddler', $useragent);
        }

        if ($s->contains('sophosupdatemanager', false)) {
            return $this->loader->load('sophosupdatemanager', $useragent);
        }

        if ($s->containsAny(['debian apt-http', 'ubuntu apt-http'], false)) {
            return $this->loader->load('apt http transport', $useragent);
        }

        if ($s->contains('urlgrabber', false)) {
            return $this->loader->load('url grabber', $useragent);
        }

        if ($s->contains('libwww-perl', false)) {
            return $this->loader->load('libwww', $useragent);
        }

        if ($s->contains('openbsd ftp', false)) {
            return $this->loader->load('openbsd ftp', $useragent);
        }

        if ($s->contains('sophosagent', false)) {
            return $this->loader->load('sophosagent', $useragent);
        }

        if ($s->contains('jupdate', false)) {
            return $this->loader->load('jupdate', $useragent);
        }

        if ($s->contains('roku/dvp', false)) {
            return $this->loader->load('roku dvp', $useragent);
        }

        if ($s->contains('safeassign', false)) {
            return $this->loader->load('safeassign', $useragent);
        }

        if ($s->contains('exaleadcloudview', false)) {
            return $this->loader->load('exalead cloudview', $useragent);
        }

        if ($s->contains('typhoeus', false)) {
            return $this->loader->load('typhoeus', $useragent);
        }

        if ($s->contains('camo asset proxy', false)) {
            return $this->loader->load('camo asset proxy', $useragent);
        }

        if ($s->contains('yahoocachesystem', false)) {
            return $this->loader->load('yahoocachesystem', $useragent);
        }

        if ($s->contains('wmtips.com', false)) {
            return $this->loader->load('webmaster tips bot', $useragent);
        }

        if ($s->contains('brokenlinkcheck.com', false)) {
            return $this->loader->load('brokenlinkcheck', $useragent);
        }

        if ($s->contains('linkcheck', false)) {
            return $this->loader->load('linkcheck', $useragent);
        }

        if ($s->contains('abrowse', false)) {
            return $this->loader->load('abrowse', $useragent);
        }

        if ($s->contains('gwpimages', false)) {
            return $this->loader->load('gwpimages', $useragent);
        }

        if ($s->contains('notetextview', false)) {
            return $this->loader->load('notetextview', $useragent);
        }

        if ($s->contains('yourls', false)) {
            return $this->loader->load('yourls', $useragent);
        }

        if ($s->contains('ning', false)) {
            return $this->loader->load('ning', $useragent);
        }

        if ($s->contains('sprinklr', false)) {
            return $this->loader->load('sprinklr', $useragent);
        }

        if ($s->contains('urlchecker', false)) {
            return $this->loader->load('urlchecker', $useragent);
        }

        if ($s->contains('newsme', false)) {
            return $this->loader->load('newsme', $useragent);
        }

        if ($s->contains('traackr', false)) {
            return $this->loader->load('traackr', $useragent);
        }

        if ($s->contains('nineconnections', false)) {
            return $this->loader->load('nineconnections', $useragent);
        }

        if ($s->contains('xenu link sleuth', false)) {
            return $this->loader->load('xenus link sleuth', $useragent);
        }

        if ($s->contains('superagent', false)) {
            return $this->loader->load('superagent', $useragent);
        }

        if ($s->contains('goose', false)) {
            return $this->loader->load('goose-extractor', $useragent);
        }

        if ($s->contains('ahc', false)) {
            return $this->loader->load('asynchronous http client', $useragent);
        }

        if ($s->contains('newspaper', false)) {
            return $this->loader->load('newspaper', $useragent);
        }

        if ($s->contains('hatena::bookmark', false)) {
            return $this->loader->load('hatena::bookmark', $useragent);
        }

        if ($s->contains('easybib autocite', false)) {
            return $this->loader->load('easybib autocite', $useragent);
        }

        if ($s->contains('shortlinktranslate', false)) {
            return $this->loader->load('shortlinktranslate', $useragent);
        }

        if ($s->contains('marketing grader', false)) {
            return $this->loader->load('marketing grader', $useragent);
        }

        if ($s->contains('grammarly', false)) {
            return $this->loader->load('grammarly', $useragent);
        }

        if ($s->contains('dispatch', false)) {
            return $this->loader->load('dispatch', $useragent);
        }

        if ($s->contains('raven link checker', false)) {
            return $this->loader->load('raven link checker', $useragent);
        }

        if ($s->contains('http-kit', false)) {
            return $this->loader->load('http kit', $useragent);
        }

        if ($s->contains('sffeedreader', false)) {
            return $this->loader->load('symfony rss reader', $useragent);
        }

        if ($s->contains('twikle', false)) {
            return $this->loader->load('twikle bot', $useragent);
        }

        if ($s->contains('node-fetch', false)) {
            return $this->loader->load('node-fetch', $useragent);
        }

        if ($s->contains('faraday', false)) {
            return $this->loader->load('faraday', $useragent);
        }

        if ($s->contains('gettor', false)) {
            return $this->loader->load('gettor', $useragent);
        }

        if ($s->contains('seostats', false)) {
            return $this->loader->load('seostats', $useragent);
        }

        if ($s->contains('znajdzfoto/image', false)) {
            return $this->loader->load('znajdzfoto/imagebot', $useragent);
        }

        if ($s->contains('infox-wisg', false)) {
            return $this->loader->load('infox-wisg', $useragent);
        }

        if ($s->contains('wscheck.com', false)) {
            return $this->loader->load('wscheck bot', $useragent);
        }

        if ($s->contains('tweetminster', false)) {
            return $this->loader->load('tweetminster bot', $useragent);
        }

        if ($s->contains('astute srm', false)) {
            return $this->loader->load('astute social', $useragent);
        }

        if ($s->contains('longurl api', false)) {
            return $this->loader->load('longurl bot', $useragent);
        }

        if ($s->contains('trove', false)) {
            return $this->loader->load('trove bot', $useragent);
        }

        if ($s->contains('melvil favicon', false)) {
            return $this->loader->load('melvil favicon bot', $useragent);
        }

        if ($s->contains('melvil', false)) {
            return $this->loader->load('melvil bot', $useragent);
        }

        if ($s->contains('pearltrees', false)) {
            return $this->loader->load('pearltrees bot', $useragent);
        }

        if ($s->contains('svven-summarizer', false)) {
            return $this->loader->load('svven summarizer bot', $useragent);
        }

        if ($s->contains('athena site analyzer', false)) {
            return $this->loader->load('athena site analyzer', $useragent);
        }

        if ($s->contains('exploratodo', false)) {
            return $this->loader->load('exploratodo bot', $useragent);
        }

        if ($s->contains('whatsapp', false)) {
            return $this->loader->load('whatsapp', $useragent);
        }

        if ($s->contains('ddg-android-', false)) {
            return $this->loader->load('duckduck app', $useragent);
        }

        if ($s->contains('webcorp', false)) {
            return $this->loader->load('webcorp', $useragent);
        }

        if ($s->contains('ror sitemap generator', false)) {
            return $this->loader->load('ror sitemap generator', $useragent);
        }

        if ($s->contains('auditmypc webmaster tool', false)) {
            return $this->loader->load('auditmypc webmaster tool', $useragent);
        }

        if ($s->contains('xmlsitemapgenerator', false)) {
            return $this->loader->load('xmlsitemapgenerator', $useragent);
        }

        if ($s->contains('stratagems kumo', false)) {
            return $this->loader->load('stratagems kumo', $useragent);
        }

        if ($s->contains('embed php library', false)) {
            return $this->loader->load('embed php library', $useragent);
        }

        if ($s->contains('spip', false)) {
            return $this->loader->load('spip', $useragent);
        }

        if ($s->contains('friendica', false)) {
            return $this->loader->load('friendica', $useragent);
        }

        if ($s->contains('magpierss', false)) {
            return $this->loader->load('magpierss', $useragent);
        }

        if ($s->contains('short url checker', false)) {
            return $this->loader->load('short url checker', $useragent);
        }

        if ($s->contains('webnumbrfetcher', false)) {
            return $this->loader->load('webnumbr fetcher', $useragent);
        }

        if ($s->containsAny(['wap browser', 'spice qt-75', 'kkt20/midp'], false)) {
            return $this->loader->load('wap browser', $useragent);
        }

        if ($s->contains('java', false)) {
            return $this->loader->load('java', $useragent);
        }

        if ($s->contains('argclrint', false)) {
            return $this->loader->load('argclrint', $useragent);
        }

        if ($s->contains('blitzbot', false)) {
            return $this->loader->load('blitzbot', $useragent);
        }

        if ($s->contains('charlotte', false)) {
            return $this->loader->load('charlotte', $useragent);
        }

        if ($s->contains('firebird', false)) {
            return $this->loader->load('firebird', $useragent);
        }

        if ($s->contains('heritrix', false)) {
            return $this->loader->load('heritrix', $useragent);
        }

        if ($s->contains('iceowl', false)) {
            return $this->loader->load('iceowl', $useragent);
        }

        if ($s->contains('icedove', false)) {
            return $this->loader->load('icedove', $useragent);
        }

        if ($s->contains('archive-de.com', false)) {
            return $this->loader->load('archive-de.com', $useragent);
        }

        if ($s->contains('socialcast', false)) {
            return $this->loader->load('socialcast bot', $useragent);
        }

        if ($s->contains('cloudinary', false)) {
            return $this->loader->load('cloudinary', $useragent);
        }

        return $this->loader->load('unknown', $useragent);
    }
}
