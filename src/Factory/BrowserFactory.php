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

        if ($s->containsAll(['netscape', 'msie'], false)) {
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

        if ($s->contains('PiplBot', false)) {
            return $this->loader->load('piplbot', $useragent);
        }

        if ($s->contains('EveryoneSocialBot', false)) {
            return $this->loader->load('everyonesocialbot', $useragent);
        }

        if ($s->contains('AOLbot', false)) {
            return $this->loader->load('aolbot', $useragent);
        }

        if ($s->contains('GLBot', false)) {
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

        if ($s->contains('XML Sitemaps Generator', false)) {
            return $this->loader->load('xml sitemaps generator', $useragent);
        }

        if ($s->contains('SeznamBot', false)) {
            return $this->loader->load('seznambot', $useragent);
        }

        if ($s->contains('URLAppendBot', false)) {
            return $this->loader->load('urlappendbot', $useragent);
        }

        if ($s->contains('NetSeer crawler', false)) {
            return $this->loader->load('netseer crawler', $useragent);
        }

        if ($s->contains('SeznamBot', false)) {
            return $this->loader->load('seznambot', $useragent);
        }

        if ($s->contains('Add Catalog', false)) {
            return $this->loader->load('add catalog', $useragent);
        }

        if ($s->contains('Moreover', false)) {
            return $this->loader->load('moreover', $useragent);
        }

        if ($s->contains('LinkpadBot', false)) {
            return $this->loader->load('linkpadbot', $useragent);
        }

        if ($s->contains('Lipperhey SEO Service', false)) {
            return $this->loader->load('lipperhey seo service', $useragent);
        }

        if ($s->contains('Blog Search', false)) {
            return $this->loader->load('blog search', $useragent);
        }

        if ($s->contains('Qualidator.com Bot', false)) {
            return $this->loader->load('qualidator.com bot', $useragent);
        }

        if ($s->contains('fr-crawler', false)) {
            return $this->loader->load('fr-crawler', $useragent);
        }

        if ($s->contains('ca-crawler', false)) {
            return $this->loader->load('ca-crawler', $useragent);
        }

        if ($s->contains('Website Thumbnail Generator', false)) {
            return $this->loader->load('website thumbnail generator', $useragent);
        }

        if ($s->contains('WebThumb', false)) {
            return $this->loader->load('webthumb', $useragent);
        }

        if ($s->contains('KomodiaBot', false)) {
            return $this->loader->load('komodiabot', $useragent);
        }

        if ($s->contains('GroupHigh', false)) {
            return $this->loader->load('grouphigh bot', $useragent);
        }

        if ($s->contains('theoldreader', false)) {
            return $this->loader->load('the old reader', $useragent);
        }

        if ($s->contains('Google-Site-Verification', false)) {
            return $this->loader->load('google-site-verification', $useragent);
        }

        if ($s->contains('Prlog', false)) {
            return $this->loader->load('prlog', $useragent);
        }

        if ($s->contains('CMS Crawler', false)) {
            return $this->loader->load('cms crawler', $useragent);
        }

        if ($s->contains('pmoz.info ODP link checker', false)) {
            return $this->loader->load('pmoz.info odp link checker', $useragent);
        }

        if ($s->contains('Twingly Recon', false)) {
            return $this->loader->load('twingly recon', $useragent);
        }

        if ($s->contains('Embedly', false)) {
            return $this->loader->load('embedly', $useragent);
        }

        if ($s->contains('alexa site audit', false)) {
            return $this->loader->load('alexa site audit', $useragent);
        }

        if ($s->contains('MJ12bot', false)) {
            return $this->loader->load('mj12bot', $useragent);
        }

        if ($s->contains('HTTrack', false)) {
            return $this->loader->load('httrack', $useragent);
        }

        if ($s->contains('UnisterBot', false)) {
            return $this->loader->load('unisterbot', $useragent);
        }

        if ($s->contains('CareerBot', false)) {
            return $this->loader->load('careerbot', $useragent);
        }

        if ($s->contains('80legs', false)) {
            return $this->loader->load('80legs', $useragent);
        }

        if ($s->contains('wada.vn', false)) {
            return $this->loader->load('wada.vn search bot', $useragent);
        }

        if ($s->containsAny(['NX', 'WiiU', 'Nintendo 3DS'], false)) {
            return $this->loader->load('netfront nx', $useragent);
        }

        if ($s->containsAny(['netfront', 'playstation 4'], false)) {
            return $this->loader->load('netfront', $useragent);
        }

        if ($s->contains('XoviBot', false)) {
            return $this->loader->load('xovibot', $useragent);
        }

        if ($s->contains('007ac9 Crawler', false)) {
            return $this->loader->load('007ac9 crawler', $useragent);
        }

        if ($s->contains('200PleaseBot', false)) {
            return $this->loader->load('200pleasebot', $useragent);
        }

        if ($s->contains('Abonti', false)) {
            return $this->loader->load('abonti websearch', $useragent);
        }

        if ($s->contains('publiclibraryarchive', false)) {
            return $this->loader->load('publiclibraryarchive bot', $useragent);
        }

        if ($s->contains('PAD-bot', false)) {
            return $this->loader->load('pad-bot', $useragent);
        }

        if ($s->contains('SoftListBot', false)) {
            return $this->loader->load('softlistbot', $useragent);
        }

        if ($s->contains('sReleaseBot', false)) {
            return $this->loader->load('sreleasebot', $useragent);
        }

        if ($s->contains('Vagabondo', false)) {
            return $this->loader->load('vagabondo', $useragent);
        }

        if ($s->contains('special_archiver', false)) {
            return $this->loader->load('internet archive special archiver', $useragent);
        }

        if ($s->contains('Optimizer', false)) {
            return $this->loader->load('optimizer bot', $useragent);
        }

        if ($s->contains('Sophora Linkchecker', false)) {
            return $this->loader->load('sophora linkchecker', $useragent);
        }

        if ($s->contains('SEOdiver', false)) {
            return $this->loader->load('seodiver bot', $useragent);
        }

        if ($s->contains('itsscan', false)) {
            return $this->loader->load('itsscan', $useragent);
        }

        if ($s->contains('Google Desktop', false)) {
            return $this->loader->load('google desktop', $useragent);
        }

        if ($s->contains('Lotus-Notes', false)) {
            return $this->loader->load('lotus notes', $useragent);
        }

        if ($s->contains('AskPeterBot', false)) {
            return $this->loader->load('askpeterbot', $useragent);
        }

        if ($s->contains('discoverybot', false)) {
            return $this->loader->load('discovery bot', $useragent);
        }

        if ($s->contains('YandexBot', false)) {
            return $this->loader->load('yandexbot', $useragent);
        }

        if ($s->containsAll(['MOSBookmarks', 'Link Checker'], false)) {
            return $this->loader->load('mosbookmarks link checker', $useragent);
        }

        if ($s->contains('MOSBookmarks', false)) {
            return $this->loader->load('mosbookmarks', $useragent);
        }

        if ($s->contains('WebMasterAid', false)) {
            return $this->loader->load('webmasteraid', $useragent);
        }

        if ($s->contains('AboutUsBot Johnny5', false)) {
            return $this->loader->load('aboutus bot johnny5', $useragent);
        }

        if ($s->contains('AboutUsBot', false)) {
            return $this->loader->load('aboutus bot', $useragent);
        }

        if ($s->contains('semantic-visions.com crawler', false)) {
            return $this->loader->load('semantic-visions.com crawler', $useragent);
        }

        if ($s->contains('waybackarchive.org', false)) {
            return $this->loader->load('wayback archive bot', $useragent);
        }

        if ($s->contains('OpenVAS', false)) {
            return $this->loader->load('open vulnerability assessment system', $useragent);
        }

        if ($s->contains('MixrankBot', false)) {
            return $this->loader->load('mixrankbot', $useragent);
        }

        if ($s->contains('InfegyAtlas', false)) {
            return $this->loader->load('infegyatlas', $useragent);
        }

        if ($s->contains('MojeekBot', false)) {
            return $this->loader->load('mojeekbot', $useragent);
        }

        if ($s->contains('memorybot', false)) {
            return $this->loader->load('memorybot', $useragent);
        }

        if ($s->contains('DomainAppender', false)) {
            return $this->loader->load('domainappender bot', $useragent);
        }

        if ($s->contains('GIDBot', false)) {
            return $this->loader->load('gidbot', $useragent);
        }

        if ($s->contains('DBot', false)) {
            return $this->loader->load('dbot', $useragent);
        }

        if ($s->contains('PWBot', false)) {
            return $this->loader->load('pwbot', $useragent);
        }

        if ($s->contains('+5Bot', false)) {
            return $this->loader->load('plus5bot', $useragent);
        }

        if ($s->contains('WASALive-Bot', false)) {
            return $this->loader->load('wasalive bot', $useragent);
        }

        if ($s->contains('OpenHoseBot', false)) {
            return $this->loader->load('openhosebot', $useragent);
        }

        if ($s->contains('URLfilterDB-crawler', false)) {
            return $this->loader->load('urlfilterdb crawler', $useragent);
        }

        if ($s->contains('metager2-verification-bot', false)) {
            return $this->loader->load('metager2-verification-bot', $useragent);
        }

        if ($s->contains('Powermarks', false)) {
            return $this->loader->load('powermarks', $useragent);
        }

        if ($s->contains('CloudFlare-AlwaysOnline', false)) {
            return $this->loader->load('cloudflare alwaysonline', $useragent);
        }

        if ($s->contains('Phantom.js bot', false)) {
            return $this->loader->load('phantom.js bot', $useragent);
        }

        if ($s->contains('Phantom', false)) {
            return $this->loader->load('phantom browser', $useragent);
        }

        if ($s->contains('Shrook', false)) {
            return $this->loader->load('shrook', $useragent);
        }

        if ($s->contains('netEstate NE Crawler', false)) {
            return $this->loader->load('netestate ne crawler', $useragent);
        }

        if ($s->contains('garlikcrawler', false)) {
            return $this->loader->load('garlikcrawler', $useragent);
        }

        if ($s->contains('metageneratorcrawler', false)) {
            return $this->loader->load('metageneratorcrawler', $useragent);
        }

        if ($s->contains('ScreenerBot', false)) {
            return $this->loader->load('screenerbot', $useragent);
        }

        if ($s->contains('WebTarantula.com Crawler', false)) {
            return $this->loader->load('webtarantula', $useragent);
        }

        if ($s->contains('BacklinkCrawler', false)) {
            return $this->loader->load('backlinkcrawler', $useragent);
        }

        if ($s->contains('LinksCrawler', false)) {
            return $this->loader->load('linkscrawler', $useragent);
        }

        if ($s->containsAny(['ssearch_bot', 'sSearch Crawler'], false)) {
            return $this->loader->load('ssearch crawler', $useragent);
        }

        if ($s->contains('HRCrawler', false)) {
            return $this->loader->load('hrcrawler', $useragent);
        }

        if ($s->contains('ICC-Crawler', false)) {
            return $this->loader->load('icc-crawler', $useragent);
        }

        if ($s->contains('Arachnida Web Crawler', false)) {
            return $this->loader->load('arachnida web crawler', $useragent);
        }

        if ($s->contains('Finderlein Research Crawler', false)) {
            return $this->loader->load('finderlein research crawler', $useragent);
        }

        if ($s->contains('TestCrawler', false)) {
            return $this->loader->load('testcrawler', $useragent);
        }

        if ($s->contains('Scopia Crawler', false)) {
            return $this->loader->load('scopia crawler', $useragent);
        }

        if ($s->contains('Crawler', false)) {
            return $this->loader->load('crawler', $useragent);
        }

        if ($s->contains('MetaJobBot', false)) {
            return $this->loader->load('metajobbot', $useragent);
        }

        if ($s->contains('jig browser web', false)) {
            return $this->loader->load('jig browser web', $useragent);
        }

        if ($s->contains('T-H-U-N-D-E-R-S-T-O-N-E', false)) {
            return $this->loader->load('texis webscript', $useragent);
        }

        if ($s->contains('focuseekbot', false)) {
            return $this->loader->load('focuseekbot', $useragent);
        }

        if ($s->contains('vBSEO', false)) {
            return $this->loader->load('vbulletin seo bot', $useragent);
        }

        if ($s->contains('kgbody', false)) {
            return $this->loader->load('kgbody', $useragent);
        }

        if ($s->contains('JobdiggerSpider', false)) {
            return $this->loader->load('jobdiggerspider', $useragent);
        }

        if ($s->contains('imrbot', false)) {
            return $this->loader->load('mignify bot', $useragent);
        }

        if ($s->contains('kulturarw3', false)) {
            return $this->loader->load('kulturarw3', $useragent);
        }

        if ($s->contains('LucidWorks', false)) {
            return $this->loader->load('lucidworks bot', $useragent);
        }

        if ($s->contains('MerchantCentricBot', false)) {
            return $this->loader->load('merchantcentricbot', $useragent);
        }

        if ($s->contains('Nett.io bot', false)) {
            return $this->loader->load('nett.io bot', $useragent);
        }

        if ($s->contains('SemanticBot', false)) {
            return $this->loader->load('semanticbot', $useragent);
        }

        if ($s->contains('tweetedtimes', false)) {
            return $this->loader->load('tweetedtimes bot', $useragent);
        }

        if ($s->contains('vkShare', false)) {
            return $this->loader->load('vkshare', $useragent);
        }

        if ($s->contains('Yahoo Ad monitoring', false)) {
            return $this->loader->load('yahoo ad monitoring', $useragent);
        }

        if ($s->contains('YioopBot', false)) {
            return $this->loader->load('yioopbot', $useragent);
        }

        if ($s->contains('zitebot', false)) {
            return $this->loader->load('zitebot', $useragent);
        }

        if ($s->contains('Espial', false)) {
            return $this->loader->load('espial tv browser', $useragent);
        }

        if ($s->contains('SiteCon', false)) {
            return $this->loader->load('sitecon', $useragent);
        }

        if ($s->contains('iBooks Author', false)) {
            return $this->loader->load('ibooks author', $useragent);
        }

        if ($s->contains('iWeb', false)) {
            return $this->loader->load('iweb', $useragent);
        }

        if ($s->contains('NewsFire', false)) {
            return $this->loader->load('newsfire', $useragent);
        }

        if ($s->contains('RMSnapKit', false)) {
            return $this->loader->load('rmsnapkit', $useragent);
        }

        if ($s->contains('Sandvox', false)) {
            return $this->loader->load('sandvox', $useragent);
        }

        if ($s->contains('TubeTV', false)) {
            return $this->loader->load('tubetv', $useragent);
        }

        if ($s->contains('Elluminate Live', false)) {
            return $this->loader->load('elluminate live', $useragent);
        }

        if ($s->contains('Element Browser', false)) {
            return $this->loader->load('element browser', $useragent);
        }

        if ($s->contains('K-Meleon', false)) {
            return $this->loader->load('k-meleon', $useragent);
        }

        if ($s->contains('Esribot', false)) {
            return $this->loader->load('esribot', $useragent);
        }

        if ($s->contains('quicklook', false)) {
            return $this->loader->load('quicklook', $useragent);
        }

        if ($s->contains('dillo', false)) {
            return $this->loader->load('dillo', $useragent);
        }

        if ($s->contains('Digg', false)) {
            return $this->loader->load('digg bot', $useragent);
        }

        if ($s->contains('Zetakey', false)) {
            return $this->loader->load('zetakey browser', $useragent);
        }

        if ($s->contains('getprismatic.com', false)) {
            return $this->loader->load('prismatic app', $useragent);
        }

        if ($s->containsAny(['FOMA', 'SH05C'], true)) {
            return $this->loader->load('sharp', $useragent);
        }

        if ($s->contains('OpenWebKitSharp', false)) {
            return $this->loader->load('open-webkit-sharp', $useragent);
        }

        if ($s->contains('AjaxSnapBot', false)) {
            return $this->loader->load('ajaxsnapbot', $useragent);
        }

        if ($s->contains('Owler', false)) {
            return $this->loader->load('owler bot', $useragent);
        }

        if ($s->contains('Yahoo Link Preview', false)) {
            return $this->loader->load('yahoo link preview', $useragent);
        }

        if ($s->contains('pub-crawler', false)) {
            return $this->loader->load('pub-crawler', $useragent);
        }

        if ($s->contains('Kraken', false)) {
            return $this->loader->load('kraken', $useragent);
        }

        if ($s->contains('Qwantify', false)) {
            return $this->loader->load('qwantify', $useragent);
        }

        if ($s->contains('SetLinks bot', false)) {
            return $this->loader->load('setlinks.ru crawler', $useragent);
        }

        if ($s->contains('MegaIndex.ru', false)) {
            return $this->loader->load('megaindex bot', $useragent);
        }

        if ($s->contains('Cliqzbot', false)) {
            return $this->loader->load('cliqzbot', $useragent);
        }

        if ($s->contains('DAWINCI ANTIPLAG SPIDER', false)) {
            return $this->loader->load('dawinci antiplag spider', $useragent);
        }

        if ($s->contains('AdvBot', false)) {
            return $this->loader->load('advbot', $useragent);
        }

        if ($s->contains('DuckDuckGo-Favicons-Bot', false)) {
            return $this->loader->load('duckduck favicons bot', $useragent);
        }

        if ($s->contains('ZyBorg', false)) {
            return $this->loader->load('wisenut search engine crawler', $useragent);
        }

        if ($s->contains('HyperCrawl', false)) {
            return $this->loader->load('hypercrawl', $useragent);
        }

        if ($s->contains('ARCHIVE.ORG.UA crawler', false)) {
            return $this->loader->load('internet archive', $useragent);
        }

        if ($s->contains('worldwebheritage', false)) {
            return $this->loader->load('worldwebheritage.org bot', $useragent);
        }

        if ($s->contains('BegunAdvertising', false)) {
            return $this->loader->load('begun advertising bot', $useragent);
        }

        if ($s->contains('TrendWinHttp', false)) {
            return $this->loader->load('trendwinhttp', $useragent);
        }

        if ($s->contains('winhttp', false)) {
            return $this->loader->load('winhttp', $useragent);
        }

        if ($s->contains('SkypeUriPreview', false)) {
            return $this->loader->load('skypeuripreview', $useragent);
        }

        if ($s->contains('ScoutJet', false)) {
            return $this->loader->load('scoutjet', $useragent);
        }

        if ($s->contains('Lipperhey-Kaus-Australis', false)) {
            return $this->loader->load('lipperhey kaus australis', $useragent);
        }

        if ($s->contains('Digincore bot', false)) {
            return $this->loader->load('digincore bot', $useragent);
        }

        if ($s->contains('Steeler', false)) {
            return $this->loader->load('steeler', $useragent);
        }

        if ($s->contains('Orangebot', false)) {
            return $this->loader->load('orangebot', $useragent);
        }

        if ($s->contains('Jasmine', false)) {
            return $this->loader->load('jasmine', $useragent);
        }

        if ($s->contains('electricmonk', false)) {
            return $this->loader->load('duedil crawler', $useragent);
        }

        if ($s->contains('yoozBot', false)) {
            return $this->loader->load('yoozbot', $useragent);
        }

        if ($s->contains('online-webceo-bot', false)) {
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

        if ($s->contains('Netscape', false)) {
            return $this->loader->load('netscape', $useragent);
        }

        if (preg_match('/^Mozilla\/5\.0$/', $useragent)) {
            return $this->loader->load('unknown', $useragent);
        }

        if ($s->contains('Virtuoso', false)) {
            return $this->loader->load('virtuoso', $useragent);
        }

        if (preg_match('/^Mozilla\/5\.0 \(.*rv:\d+\.\d+.*\) Gecko\/.*\//', $useragent)
            && !preg_match('/(msie|android)/i', $useragent)
        ) {
            return $this->loader->load('netscape', $useragent);
        }

        if (preg_match('/^Dalvik\/\d/', $useragent)) {
            return $this->loader->load('dalvik', $useragent);
        }

        if ($s->contains('niki-bot', false)) {
            return $this->loader->load('niki-bot', $useragent);
        }

        if ($s->contains('ContextAd Bot', false)) {
            return $this->loader->load('contextad bot', $useragent);
        }

        if ($s->contains('integrity', false)) {
            return $this->loader->load('integrity', $useragent);
        }

        if ($s->contains('masscan', false)) {
            return $this->loader->load('masscan', $useragent);
        }

        if ($s->contains('ZmEu', false)) {
            return $this->loader->load('zmeu', $useragent);
        }

        if ($s->contains('sogou web spider', false)) {
            return $this->loader->load('sogou web spider', $useragent);
        }

        if ($s->containsAny(['OpenWave', 'UP.Browser', 'UP/'], false)) {
            return $this->loader->load('openwave mobile browser', $useragent);
        }

        if (preg_match('/(ObigoInternetBrowser|obigo\-browser|Obigo|Teleca)(\/|-)Q(\d+)/', $useragent)) {
            return $this->loader->load('obigo q', $useragent);
        }

        if ($s->containsAny(['Teleca', 'Obigo', 'MIC/', 'AU-MIC'], false)) {
            return $this->loader->load('teleca-obigo', $useragent);
        }

        if ($s->contains('DavClnt', false)) {
            return $this->loader->load('microsoft-webdav', $useragent);
        }

        if ($s->contains('XING-contenttabreceiver', false)) {
            return $this->loader->load('xing contenttabreceiver', $useragent);
        }

        if ($s->contains('Slingstone', false)) {
            return $this->loader->load('yahoo slingstone', $useragent);
        }

        if ($s->contains('BOT for JCE', false)) {
            return $this->loader->load('bot for jce', $useragent);
        }

        if ($s->contains('Validator.nu/LV', false)) {
            return $this->loader->load('validator.nu/lv', $useragent);
        }

        if ($s->contains('Curb', false)) {
            return $this->loader->load('curb', $useragent);
        }

        if ($s->contains('link_thumbnailer', false)) {
            return $this->loader->load('link_thumbnailer', $useragent);
        }

        if ($s->contains('Ruby', false)) {
            return $this->loader->load('generic ruby crawler', $useragent);
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

        if ($s->contains('discovered', false)) {
            return $this->loader->load('discovered', $useragent);
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

        if ($s->contains('ADmantX Platform Semantic Analyzer', false)) {
            return $this->loader->load('admantx platform semantic analyzer', $useragent);
        }

        if ($s->contains('UniversalFeedParser', false)) {
            return $this->loader->load('universalfeedparser', $useragent);
        }

        if ($s->containsAny(['binlar', 'larbin'], false)) {
            return $this->loader->load('larbin', $useragent);
        }

        if ($s->contains('unityplayer', false)) {
            return $this->loader->load('unity web player', $useragent);
        }

        if ($s->contains('WeSEE:Search', false)) {
            return $this->loader->load('wesee:search', $useragent);
        }

        if ($s->contains('WeSEE:Ads', false)) {
            return $this->loader->load('wesee:ads', $useragent);
        }

        if ($s->contains('A6-Indexer', false)) {
            return $this->loader->load('a6-indexer', $useragent);
        }

        if ($s->contains('NerdyBot', false)) {
            return $this->loader->load('nerdybot', $useragent);
        }

        if ($s->contains('Peeplo Screenshot Bot', false)) {
            return $this->loader->load('peeplo screenshot bot', $useragent);
        }

        if ($s->contains('CCBot', false)) {
            return $this->loader->load('ccbot', $useragent);
        }

        if ($s->contains('visionutils', false)) {
            return $this->loader->load('visionutils', $useragent);
        }

        if ($s->contains('Feedly', false)) {
            return $this->loader->load('feedly feed fetcher', $useragent);
        }

        if ($s->contains('Photon', false)) {
            return $this->loader->load('photon', $useragent);
        }

        if ($s->contains('WDG_Validator', false)) {
            return $this->loader->load('html validator', $useragent);
        }

        if ($s->contains('Aboundex', false)) {
            return $this->loader->load('aboundexbot', $useragent);
        }

        if ($s->contains('YisouSpider', false)) {
            return $this->loader->load('yisouspider', $useragent);
        }

        if ($s->contains('hivaBot', false)) {
            return $this->loader->load('hivabot', $useragent);
        }

        if ($s->contains('Comodo Spider', false)) {
            return $this->loader->load('comodo spider', $useragent);
        }

        if ($s->contains('OpenWebSpider', false)) {
            return $this->loader->load('openwebspider', $useragent);
        }

        if ($s->contains('R6_CommentReader', false)) {
            return $this->loader->load('r6 commentreader', $useragent);
        }

        if ($s->contains('R6_FeedFetcher', false)) {
            return $this->loader->load('r6 feedfetcher', $useragent);
        }

        if ($s->containsAny(['psbot-image', 'psbot-page'], false)) {
            return $this->loader->load('picsearch bot', $useragent);
        }

        if ($s->contains('Bloglovin', false)) {
            return $this->loader->load('bloglovin bot', $useragent);
        }

        if ($s->contains('viralvideochart', false)) {
            return $this->loader->load('viralvideochart bot', $useragent);
        }

        if ($s->contains('MetaHeadersBot', false)) {
            return $this->loader->load('metaheadersbot', $useragent);
        }

        if ($s->containsAny(['ZendHttpClient', 'Zend_Http_Client', 'Zend\Http\Client'], false)) {
            return $this->loader->load('zend_http_client', $useragent);
        }

        if ($s->contains('wget', false)) {
            return $this->loader->load('wget', $useragent);
        }

        if ($s->contains('Scrapy', false)) {
            return $this->loader->load('scrapy', $useragent);
        }

        if ($s->contains('Moozilla', false)) {
            return $this->loader->load('moozilla', $useragent);
        }

        if ($s->contains('AntBot', false)) {
            return $this->loader->load('antbot', $useragent);
        }

        if ($s->contains('Browsershots', false)) {
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

        if ($s->contains('Links', false)) {
            return $this->loader->load('links', $useragent);
        }

        if ($s->contains('Airmail', false)) {
            return $this->loader->load('airmail', $useragent);
        }

        if ($s->contains('SonyEricsson', false)) {
            return $this->loader->load('semc', $useragent);
        }

        if ($s->contains('WEB.DE MailCheck', false)) {
            return $this->loader->load('web.de mailcheck', $useragent);
        }

        if ($s->contains('Screaming Frog SEO Spider', false)) {
            return $this->loader->load('screaming frog seo spider', $useragent);
        }

        if ($s->contains('AndroidDownloadManager', false)) {
            return $this->loader->load('android download manager', $useragent);
        }

        if (preg_match('/Go ([\d\.]+) package http/', $useragent)) {
            return $this->loader->load('go httpclient', $useragent);
        }

        if ($s->contains('Go-http-client', false)) {
            return $this->loader->load('go httpclient', $useragent);
        }

        if ($s->contains('Proxy Gear Pro', false)) {
            return $this->loader->load('proxy gear pro', $useragent);
        }

        if ($s->contains('WAP Browser/MAUI', false)) {
            return $this->loader->load('maui wap browser', $useragent);
        }

        if ($s->contains('Tiny Tiny RSS', false)) {
            return $this->loader->load('tiny tiny rss', $useragent);
        }

        if ($s->contains('Readability', false)) {
            return $this->loader->load('readability', $useragent);
        }

        if ($s->contains('NSPlayer', false)) {
            return $this->loader->load('windows media player', $useragent);
        }

        if ($s->contains('Pingdom', false)) {
            return $this->loader->load('pingdom', $useragent);
        }

        if ($s->contains('crazywebcrawler', false)) {
            return $this->loader->load('crazywebcrawler', $useragent);
        }

        if ($s->contains('GG PeekBot', false)) {
            return $this->loader->load('gg peekbot', $useragent);
        }

        if ($s->contains('iTunes', false)) {
            return $this->loader->load('itunes', $useragent);
        }

        if ($s->contains('LibreOffice', false)) {
            return $this->loader->load('libreoffice', $useragent);
        }

        if ($s->contains('OpenOffice', false)) {
            return $this->loader->load('openoffice', $useragent);
        }

        if ($s->contains('ThumbnailAgent', false)) {
            return $this->loader->load('thumbnailagent', $useragent);
        }

        if ($s->contains('LinkStats Bot', false)) {
            return $this->loader->load('linkstats bot', $useragent);
        }

        if ($s->contains('eZ Publish Link Validator', false)) {
            return $this->loader->load('ez publish link validator', $useragent);
        }

        if ($s->contains('ThumbSniper', false)) {
            return $this->loader->load('thumbsniper', $useragent);
        }

        if ($s->contains('stq_bot', false)) {
            return $this->loader->load('searchteq bot', $useragent);
        }

        if ($s->contains('SNK Screenshot Bot', false)) {
            return $this->loader->load('save n keep screenshot bot', $useragent);
        }

        if ($s->contains('SynHttpClient', false)) {
            return $this->loader->load('synhttpclient', $useragent);
        }

        if ($s->contains('HTTPClient', false)) {
            return $this->loader->load('httpclient', $useragent);
        }

        if ($s->contains('T-Online Browser', false)) {
            return $this->loader->load('t-online browser', $useragent);
        }

        if ($s->contains('ImplisenseBot', false)) {
            return $this->loader->load('implisensebot', $useragent);
        }

        if ($s->contains('BuiBui-Bot', false)) {
            return $this->loader->load('buibui-bot', $useragent);
        }

        if ($s->contains('thumbshots-de-bot', false)) {
            return $this->loader->load('thumbshots-de-bot', $useragent);
        }

        if ($s->contains('python-requests', false)) {
            return $this->loader->load('python-requests', $useragent);
        }

        if ($s->contains('Python-urllib', false)) {
            return $this->loader->load('python-urllib', $useragent);
        }

        if ($s->contains('Bot.AraTurka.com', false)) {
            return $this->loader->load('bot.araturka.com', $useragent);
        }

        if ($s->contains('http_requester', false)) {
            return $this->loader->load('http_requester', $useragent);
        }

        if ($s->contains('WhatWeb', false)) {
            return $this->loader->load('whatweb web scanner', $useragent);
        }

        if ($s->contains('isc header collector handlers', false)) {
            return $this->loader->load('isc header collector handlers', $useragent);
        }

        if ($s->contains('Thumbor', false)) {
            return $this->loader->load('thumbor', $useragent);
        }

        if ($s->contains('Forum Poster', false)) {
            return $this->loader->load('forum poster', $useragent);
        }

        if ($s->contains('crawler4j', false)) {
            return $this->loader->load('crawler4j', $useragent);
        }

        if ($s->contains('Facebot', false)) {
            return $this->loader->load('facebot', $useragent);
        }

        if ($s->contains('NetzCheckBot', false)) {
            return $this->loader->load('netzcheckbot', $useragent);
        }

        if ($s->contains('MIB', true)) {
            return $this->loader->load('motorola internet browser', $useragent);
        }

        if ($s->contains('facebookscraper', false)) {
            return $this->loader->load('facebookscraper', $useragent);
        }

        if ($s->contains('Zookabot', false)) {
            return $this->loader->load('zookabot', $useragent);
        }

        if ($s->contains('MetaURI', false)) {
            return $this->loader->load('metauri bot', $useragent);
        }

        if ($s->contains('FreeWebMonitoring SiteChecker', false)) {
            return $this->loader->load('freewebmonitoring sitechecker', $useragent);
        }

        if ($s->contains('IPv4Scan', false)) {
            return $this->loader->load('ipv4scan', $useragent);
        }

        if ($s->contains('RED', true)) {
            return $this->loader->load('redbot', $useragent);
        }

        if ($s->contains('domainsbot', false)) {
            return $this->loader->load('domainsbot', $useragent);
        }

        if ($s->contains('BUbiNG', false)) {
            return $this->loader->load('bubing bot', $useragent);
        }

        if ($s->contains('RamblerMail', false)) {
            return $this->loader->load('ramblermail bot', $useragent);
        }

        if ($s->contains('ichiro/mobile', false)) {
            return $this->loader->load('ichiro mobile bot', $useragent);
        }

        if ($s->contains('ichiro', false)) {
            return $this->loader->load('ichiro bot', $useragent);
        }

        if ($s->contains('iisbot', false)) {
            return $this->loader->load('iis site analysis web crawler', $useragent);
        }

        if ($s->contains('JoobleBot', false)) {
            return $this->loader->load('jooblebot', $useragent);
        }

        if ($s->contains('Superfeedr bot', false)) {
            return $this->loader->load('superfeedr bot', $useragent);
        }

        if ($s->contains('FeedBurner', false)) {
            return $this->loader->load('feedburner', $useragent);
        }

        if ($s->contains('Fastladder', false)) {
            return $this->loader->load('fastladder', $useragent);
        }

        if ($s->contains('livedoor', false)) {
            return $this->loader->load('livedoor', $useragent);
        }

        if ($s->contains('Icarus6j', false)) {
            return $this->loader->load('icarus6j', $useragent);
        }

        if ($s->contains('wsr-agent', false)) {
            return $this->loader->load('wsr-agent', $useragent);
        }

        if ($s->contains('Blogshares Spiders', false)) {
            return $this->loader->load('blogshares spiders', $useragent);
        }

        if ($s->contains('TinEye-bot', false)) {
            return $this->loader->load('tineye bot', $useragent);
        }

        if ($s->contains('QuickiWiki', false)) {
            return $this->loader->load('quickiwiki bot', $useragent);
        }

        if ($s->contains('PycURL', false)) {
            return $this->loader->load('pycurl', $useragent);
        }

        if ($s->contains('libcurl-agent', false)) {
            return $this->loader->load('libcurl', $useragent);
        }

        if ($s->contains('Taproot', false)) {
            return $this->loader->load('taproot bot', $useragent);
        }

        if ($s->contains('GuzzleHttp', false)) {
            return $this->loader->load('guzzle http client', $useragent);
        }

        if ($s->contains('curl', false)) {
            return $this->loader->load('curl', $useragent);
        }

        if ($s->startsWith('PHP', true)) {
            return $this->loader->load('php', $useragent);
        }

        if ($s->contains('Apple-PubSub', false)) {
            return $this->loader->load('apple pubsub', $useragent);
        }

        if ($s->contains('SimplePie', false)) {
            return $this->loader->load('simplepie', $useragent);
        }

        if ($s->contains('BigBozz', false)) {
            return $this->loader->load('bigbozz - financial search', $useragent);
        }

        if ($s->contains('ECCP', false)) {
            return $this->loader->load('eccp', $useragent);
        }

        if ($s->contains('facebookexternalhit', false)) {
            return $this->loader->load('facebookexternalhit', $useragent);
        }

        if ($s->contains('GigablastOpenSource', false)) {
            return $this->loader->load('gigablast search engine', $useragent);
        }

        if ($s->contains('WebIndex', false)) {
            return $this->loader->load('webindex', $useragent);
        }

        if ($s->contains('Prince', false)) {
            return $this->loader->load('prince', $useragent);
        }

        if ($s->contains('adsense-snapshot-google', false)) {
            return $this->loader->load('adsense snapshot bot', $useragent);
        }

        if ($s->contains('Amazon CloudFront', false)) {
            return $this->loader->load('amazon cloudfront', $useragent);
        }

        if ($s->contains('bandscraper', false)) {
            return $this->loader->load('bandscraper', $useragent);
        }

        if ($s->contains('bitlybot', false)) {
            return $this->loader->load('bitlybot', $useragent);
        }

        if ($s->startsWith('bot', false)) {
            return $this->loader->load('bot', $useragent);
        }

        if ($s->contains('cars-app-browser', false)) {
            return $this->loader->load('cars-app-browser', $useragent);
        }

        if ($s->contains('Coursera-Mobile', false)) {
            return $this->loader->load('coursera mobile app', $useragent);
        }

        if ($s->contains('Crowsnest', false)) {
            return $this->loader->load('crowsnest mobile app', $useragent);
        }

        if ($s->contains('Dorado WAP-Browser', false)) {
            return $this->loader->load('dorado wap browser', $useragent);
        }

        if ($s->contains('Goldfire Server', false)) {
            return $this->loader->load('goldfire server', $useragent);
        }

        if ($s->contains('EventMachine HttpClient', false)) {
            return $this->loader->load('eventmachine httpclient', $useragent);
        }

        if ($s->contains('iBall', false)) {
            return $this->loader->load('iball', $useragent);
        }

        if ($s->contains('InAGist URL Resolver', false)) {
            return $this->loader->load('inagist url resolver', $useragent);
        }

        if ($s->contains('Jeode', false)) {
            return $this->loader->load('jeode', $useragent);
        }

        if ($s->contains('kraken', false)) {
            return $this->loader->load('krakenjs', $useragent);
        }

        if ($s->contains('com.linkedin', false)) {
            return $this->loader->load('linkedinbot', $useragent);
        }

        if ($s->contains('LivelapBot', false)) {
            return $this->loader->load('livelap crawler', $useragent);
        }

        if ($s->contains('MixBot', false)) {
            return $this->loader->load('mixbot', $useragent);
        }

        if ($s->contains('BuSecurityProject', false)) {
            return $this->loader->load('busecurityproject', $useragent);
        }

        if ($s->contains('PageFreezer', false)) {
            return $this->loader->load('pagefreezer', $useragent);
        }

        if ($s->contains('restify', false)) {
            return $this->loader->load('restify', $useragent);
        }

        if ($s->contains('ShowyouBot', false)) {
            return $this->loader->load('showyoubot', $useragent);
        }

        if ($s->contains('vlc', false)) {
            return $this->loader->load('vlc media player', $useragent);
        }

        if ($s->contains('WebRingChecker', false)) {
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

        if ($s->contains('CookieReports', false)) {
            return $this->loader->load('cookie reports bot', $useragent);
        }

        if ($s->contains('Elmer', false)) {
            return $this->loader->load('elmer', $useragent);
        }

        if ($s->contains('Iframely', false)) {
            return $this->loader->load('iframely bot', $useragent);
        }

        if ($s->contains('MetaInspector', false)) {
            return $this->loader->load('metainspector', $useragent);
        }

        if ($s->contains('Microsoft-CryptoAPI', false)) {
            return $this->loader->load('microsoft cryptoapi', $useragent);
        }

        if ($s->contains('OWASP_SECRET_BROWSER', false)) {
            return $this->loader->load('owasp_secret_browser', $useragent);
        }

        if ($s->contains('SMRF URL Expander', false)) {
            return $this->loader->load('smrf url expander', $useragent);
        }

        if ($s->contains('Speedy Spider', false)) {
            return $this->loader->load('entireweb', $useragent);
        }

        if ($s->contains('kizasi-spider', false)) {
            return $this->loader->load('kizasi-spider', $useragent);
        }

        if ($s->contains('Superarama.com - BOT', false)) {
            return $this->loader->load('superarama.com - bot', $useragent);
        }

        if ($s->contains('WNMbot', false)) {
            return $this->loader->load('wnmbot', $useragent);
        }

        if ($s->contains('Website Explorer', false)) {
            return $this->loader->load('website explorer', $useragent);
        }

        if ($s->contains('city-map screenshot service', false)) {
            return $this->loader->load('city-map screenshot service', $useragent);
        }

        if ($s->contains('gosquared-thumbnailer', false)) {
            return $this->loader->load('gosquared-thumbnailer', $useragent);
        }

        if ($s->contains('optivo(R) NetHelper', false)) {
            return $this->loader->load('optivo nethelper', $useragent);
        }

        if ($s->contains('pr-cy.ru Screenshot Bot', false)) {
            return $this->loader->load('screenshot bot', $useragent);
        }

        if ($s->contains('Cyberduck', false)) {
            return $this->loader->load('cyberduck', $useragent);
        }

        if ($s->contains('Lynx', false)) {
            return $this->loader->load('lynx', $useragent);
        }

        if ($s->contains('AccServer', false)) {
            return $this->loader->load('accserver', $useragent);
        }

        if ($s->contains('SafeSearch microdata crawler', false)) {
            return $this->loader->load('safesearch microdata crawler', $useragent);
        }

        if ($s->contains('iZSearch', false)) {
            return $this->loader->load('izsearch bot', $useragent);
        }

        if ($s->contains('NetLyzer FastProbe', false)) {
            return $this->loader->load('netlyzer fastprobe', $useragent);
        }

        if ($s->contains('MnoGoSearch', false)) {
            return $this->loader->load('mnogosearch', $useragent);
        }

        if ($s->contains('uipbot', false)) {
            return $this->loader->load('uipbot', $useragent);
        }

        if ($s->contains('mbot', false)) {
            return $this->loader->load('mbot', $useragent);
        }

        if ($s->contains('MS Web Services Client Protocol', false)) {
            return $this->loader->load('.net framework clr', $useragent);
        }

        if ($s->containsAny(['AtomicBrowser', 'AtomicLite'], false)) {
            return $this->loader->load('atomic browser', $useragent);
        }

        if ($s->contains('AppEngine-Google', false)) {
            return $this->loader->load('google app engine', $useragent);
        }

        if ($s->contains('Feedfetcher-Google', false)) {
            return $this->loader->load('google feedfetcher', $useragent);
        }

        if ($s->contains('Google', false)) {
            return $this->loader->load('google app', $useragent);
        }

        if ($s->contains('UnwindFetchor', false)) {
            return $this->loader->load('unwindfetchor', $useragent);
        }

        if ($s->contains('Perfect%20Browser', false)) {
            return $this->loader->load('perfect browser', $useragent);
        }

        if ($s->contains('Reeder', false)) {
            return $this->loader->load('reeder', $useragent);
        }

        if ($s->contains('FastBrowser', false)) {
            return $this->loader->load('fastbrowser', $useragent);
        }

        if ($s->contains('CFNetwork', false)) {
            return $this->loader->load('cfnetwork', $useragent);
        }

        if (preg_match('/Y\!J\-(ASR|BSC)/', $useragent)) {
            return $this->loader->load('yahoo! japan', $useragent);
        }

        if ($s->contains('test certificate info', false)) {
            return $this->loader->load('test certificate info', $useragent);
        }

        if ($s->contains('fastbot crawler', false)) {
            return $this->loader->load('fastbot crawler', $useragent);
        }

        if ($s->contains('Riddler', false)) {
            return $this->loader->load('riddler', $useragent);
        }

        if ($s->contains('SophosUpdateManager', false)) {
            return $this->loader->load('sophosupdatemanager', $useragent);
        }

        if (preg_match('/(Debian|Ubuntu) APT\-HTTP/', $useragent)) {
            return $this->loader->load('apt http transport', $useragent);
        }

        if ($s->contains('urlgrabber', false)) {
            return $this->loader->load('url grabber', $useragent);
        }

        if ($s->contains('UCS (ESX)', false)) {
            return $this->loader->load('univention corporate server', $useragent);
        }

        if ($s->contains('libwww-perl', false)) {
            return $this->loader->load('libwww', $useragent);
        }

        if ($s->contains('OpenBSD ftp', false)) {
            return $this->loader->load('openbsd ftp', $useragent);
        }

        if ($s->contains('SophosAgent', false)) {
            return $this->loader->load('sophosagent', $useragent);
        }

        if ($s->contains('jupdate', false)) {
            return $this->loader->load('jupdate', $useragent);
        }

        if ($s->contains('Roku/DVP', false)) {
            return $this->loader->load('roku dvp', $useragent);
        }

        if ($s->contains('VocusBot', false)) {
            return $this->loader->load('vocusbot', $useragent);
        }

        if ($s->contains('PostRank', false)) {
            return $this->loader->load('postrank', $useragent);
        }

        if ($s->contains('rogerbot', false)) {
            return $this->loader->load('rogerbot', $useragent);
        }

        if ($s->contains('Safeassign', false)) {
            return $this->loader->load('safeassign', $useragent);
        }

        if ($s->contains('ExaleadCloudView', false)) {
            return $this->loader->load('exalead cloudview', $useragent);
        }

        if ($s->contains('Typhoeus', false)) {
            return $this->loader->load('typhoeus', $useragent);
        }

        if ($s->contains('Camo Asset Proxy', false)) {
            return $this->loader->load('camo asset proxy', $useragent);
        }

        if ($s->contains('YahooCacheSystem', false)) {
            return $this->loader->load('yahoocachesystem', $useragent);
        }

        if ($s->contains('wmtips.com', false)) {
            return $this->loader->load('webmaster tips bot', $useragent);
        }

        if ($s->contains('linkCheck', false)) {
            return $this->loader->load('linkcheck', $useragent);
        }

        if ($s->contains('ABrowse', false)) {
            return $this->loader->load('abrowse', $useragent);
        }

        if ($s->contains('GWPImages', false)) {
            return $this->loader->load('gwpimages', $useragent);
        }

        if ($s->contains('NoteTextView', false)) {
            return $this->loader->load('notetextview', $useragent);
        }

        if ($s->contains('NING', false)) {
            return $this->loader->load('ning', $useragent);
        }

        if ($s->contains('Sprinklr', false)) {
            return $this->loader->load('sprinklr', $useragent);
        }

        if ($s->contains('URLChecker', false)) {
            return $this->loader->load('urlchecker', $useragent);
        }

        if ($s->contains('newsme', false)) {
            return $this->loader->load('newsme', $useragent);
        }

        if ($s->contains('Traackr', false)) {
            return $this->loader->load('traackr', $useragent);
        }

        if ($s->contains('nineconnections', false)) {
            return $this->loader->load('nineconnections', $useragent);
        }

        if ($s->contains('Xenu Link Sleuth', false)) {
            return $this->loader->load('xenus link sleuth', $useragent);
        }

        if ($s->contains('superagent', false)) {
            return $this->loader->load('superagent', $useragent);
        }

        if ($s->contains('Goose', false)) {
            return $this->loader->load('goose-extractor', $useragent);
        }

        if ($s->contains('AHC', true)) {
            return $this->loader->load('asynchronous http client', $useragent);
        }

        if ($s->contains('newspaper', false)) {
            return $this->loader->load('newspaper', $useragent);
        }

        if ($s->contains('Hatena::Bookmark', false)) {
            return $this->loader->load('hatena::bookmark', $useragent);
        }

        if ($s->contains('EasyBib AutoCite', false)) {
            return $this->loader->load('easybib autocite', $useragent);
        }

        if ($s->contains('ShortLinkTranslate', false)) {
            return $this->loader->load('shortlinktranslate', $useragent);
        }

        if ($s->contains('Marketing Grader', false)) {
            return $this->loader->load('marketing grader', $useragent);
        }

        if ($s->contains('Grammarly', false)) {
            return $this->loader->load('grammarly', $useragent);
        }

        if ($s->contains('Dispatch', false)) {
            return $this->loader->load('dispatch', $useragent);
        }

        if ($s->contains('Raven Link Checker', false)) {
            return $this->loader->load('raven link checker', $useragent);
        }

        if ($s->contains('http-kit', false)) {
            return $this->loader->load('http kit', $useragent);
        }

        if ($s->contains('sfFeedReader', false)) {
            return $this->loader->load('symfony rss reader', $useragent);
        }

        if ($s->contains('Twikle', false)) {
            return $this->loader->load('twikle bot', $useragent);
        }

        if ($s->contains('node-fetch', false)) {
            return $this->loader->load('node-fetch', $useragent);
        }

        if ($s->contains('BrokenLinkCheck.com', false)) {
            return $this->loader->load('brokenlinkcheck', $useragent);
        }

        if ($s->contains('BCKLINKS', false)) {
            return $this->loader->load('bcklinks', $useragent);
        }

        if ($s->contains('Faraday', false)) {
            return $this->loader->load('faraday', $useragent);
        }

        if ($s->contains('gettor', false)) {
            return $this->loader->load('gettor', $useragent);
        }

        if ($s->contains('SEOstats', false)) {
            return $this->loader->load('seostats', $useragent);
        }

        if ($s->contains('ZnajdzFoto/Image', false)) {
            return $this->loader->load('znajdzfoto/imagebot', $useragent);
        }

        if ($s->contains('infoX-WISG', false)) {
            return $this->loader->load('infox-wisg', $useragent);
        }

        if ($s->contains('wscheck.com', false)) {
            return $this->loader->load('wscheck bot', $useragent);
        }

        if ($s->contains('Tweetminster', false)) {
            return $this->loader->load('tweetminster bot', $useragent);
        }

        if ($s->contains('Astute SRM', false)) {
            return $this->loader->load('astute social', $useragent);
        }

        if ($s->contains('LongURL API', false)) {
            return $this->loader->load('longurl bot', $useragent);
        }

        if ($s->contains('Trove', false)) {
            return $this->loader->load('trove bot', $useragent);
        }

        if ($s->contains('Melvil Favicon', false)) {
            return $this->loader->load('melvil favicon bot', $useragent);
        }

        if ($s->contains('Melvil', false)) {
            return $this->loader->load('melvil bot', $useragent);
        }

        if ($s->contains('Pearltrees', false)) {
            return $this->loader->load('pearltrees bot', $useragent);
        }

        if ($s->contains('Svven-Summarizer', false)) {
            return $this->loader->load('svven summarizer bot', $useragent);
        }

        if ($s->contains('Athena Site Analyzer', false)) {
            return $this->loader->load('athena site analyzer', $useragent);
        }

        if ($s->contains('Exploratodo', false)) {
            return $this->loader->load('exploratodo bot', $useragent);
        }

        if ($s->contains('WhatsApp', false)) {
            return $this->loader->load('whatsapp', $useragent);
        }

        if ($s->contains('DDG-Android-', false)) {
            return $this->loader->load('duckduck app', $useragent);
        }

        if ($s->contains('WebCorp', false)) {
            return $this->loader->load('webcorp', $useragent);
        }

        if ($s->contains('ROR Sitemap Generator', false)) {
            return $this->loader->load('ror sitemap generator', $useragent);
        }

        if ($s->contains('AuditMyPC Webmaster Tool', false)) {
            return $this->loader->load('auditmypc webmaster tool', $useragent);
        }

        if ($s->contains('XmlSitemapGenerator', false)) {
            return $this->loader->load('xmlsitemapgenerator', $useragent);
        }

        if ($s->contains('Stratagems Kumo', false)) {
            return $this->loader->load('stratagems kumo', $useragent);
        }

        if ($s->contains('YOURLS', false)) {
            return $this->loader->load('yourls', $useragent);
        }

        if ($s->contains('Embed PHP Library', false)) {
            return $this->loader->load('embed php library', $useragent);
        }

        if ($s->contains('SPIP', false)) {
            return $this->loader->load('spip', $useragent);
        }

        if ($s->contains('Friendica', false)) {
            return $this->loader->load('friendica', $useragent);
        }

        if ($s->contains('MagpieRSS', false)) {
            return $this->loader->load('magpierss', $useragent);
        }

        if ($s->contains('Short URL Checker', false)) {
            return $this->loader->load('short url checker', $useragent);
        }

        if ($s->contains('webnumbrFetcher', false)) {
            return $this->loader->load('webnumbr fetcher', $useragent);
        }

        if ($s->containsAny(['WAP Browser', 'Spice QT-75', 'KKT20/MIDP'], false)) {
            return $this->loader->load('wap browser', $useragent);
        }

        if ($s->contains('java', false)) {
            return $this->loader->load('java', $useragent);
        }

        if ($s->containsAny(['unister-test', 'unistertesting', 'unister-https-test'], false)) {
            return $this->loader->load('unistertesting', $useragent);
        }

        if ($s->contains('AdMuncher', false)) {
            return $this->loader->load('ad muncher', $useragent);
        }

        if ($s->contains('AdvancedEmailExtractor', false)) {
            return $this->loader->load('advanced email extractor', $useragent);
        }

        if ($s->contains('AiHitBot', false)) {
            return $this->loader->load('aihitbot', $useragent);
        }

        if ($s->contains('Alcatel', false)) {
            return $this->loader->load('alcatel', $useragent);
        }

        if ($s->contains('AlcoholSearch', false)) {
            return $this->loader->load('alcohol search', $useragent);
        }

        if ($s->contains('ApacheHttpClient', false)) {
            return $this->loader->load('apache-httpclient', $useragent);
        }

        if ($s->contains('ArchiveDeBot', false)) {
            return $this->loader->load('internet archive de', $useragent);
        }

        if ($s->contains('Argclrint', false)) {
            return $this->loader->load('argclrint', $useragent);
        }

        if ($s->contains('AskBot', false)) {
            return $this->loader->load('ask bot', $useragent);
        }

        if ($s->contains('AugustBot', false)) {
            return $this->loader->load('augustbot', $useragent);
        }

        if ($s->contains('Awesomebot', false)) {
            return $this->loader->load('awesomebot', $useragent);
        }

        if ($s->contains('Benq', false)) {
            return $this->loader->load('benq', $useragent);
        }

        if ($s->contains('Billigfluegefinal', false)) {
            return $this->loader->load('billigfluegefinal app', $useragent);
        }

        if ($s->contains('BingProductsBot', false)) {
            return $this->loader->load('bing product search', $useragent);
        }

        if ($s->contains('BlitzBot', false)) {
            return $this->loader->load('blitzbot', $useragent);
        }

        if ($s->contains('BluecoatDrtr', false)) {
            return $this->loader->load('dynamic realtime rating', $useragent);
        }

        if ($s->contains('BndCrawler', false)) {
            return $this->loader->load('bnd crawler', $useragent);
        }

        if ($s->contains('BoardReader', false)) {
            return $this->loader->load('boardreader', $useragent);
        }

        if ($s->contains('Boxee', false)) {
            return $this->loader->load('boxee', $useragent);
        }

        if ($s->contains('Browser360', false)) {
            return $this->loader->load('360 browser', $useragent);
        }

        if ($s->contains('Bwc', false)) {
            return $this->loader->load('bwc', $useragent);
        }

        if ($s->contains('Camcrawler', false)) {
            return $this->loader->load('camcrawler', $useragent);
        }

        if ($s->contains('CamelHttpStream', false)) {
            return $this->loader->load('camelhttpstream', $useragent);
        }

        if ($s->contains('Charlotte', false)) {
            return $this->loader->load('charlotte', $useragent);
        }

        if ($s->contains('CheckLinks', false)) {
            return $this->loader->load('checklinks', $useragent);
        }

        if ($s->contains('Choosy', false)) {
            return $this->loader->load('choosy', $useragent);
        }

        if ($s->contains('ClarityDailyBot', false)) {
            return $this->loader->load('claritydailybot', $useragent);
        }

        if ($s->contains('Clipish', false)) {
            return $this->loader->load('clipish', $useragent);
        }

        if ($s->contains('CloudSurfer', false)) {
            return $this->loader->load('cloudsurfer', $useragent);
        }

        if ($s->contains('CommonCrawl', false)) {
            return $this->loader->load('commoncrawl', $useragent);
        }

        if ($s->contains('ComodoCertificatesSpider', false)) {
            return $this->loader->load('comodo-certificates-spider', $useragent);
        }

        if ($s->contains('CompSpyBot', false)) {
            return $this->loader->load('compspybot', $useragent);
        }

        if ($s->contains('CoobyBot', false)) {
            return $this->loader->load('coobybot', $useragent);
        }

        if ($s->contains('CoreClassHttpClientCached', false)) {
            return $this->loader->load('core_class_httpclient_cached', $useragent);
        }

        if ($s->contains('Coverscout', false)) {
            return $this->loader->load('coverscout', $useragent);
        }

        if ($s->contains('CrystalSemanticsBot', false)) {
            return $this->loader->load('crystalsemanticsbot', $useragent);
        }

        if ($s->contains('CurlPhp', false)) {
            return $this->loader->load('curl php', $useragent);
        }

        if ($s->contains('CydralWebImageSearch', false)) {
            return $this->loader->load('cydral web image search', $useragent);
        }

        if ($s->contains('DarwinBrowser', false)) {
            return $this->loader->load('darwin browser', $useragent);
        }

        if ($s->contains('DCPbot', false)) {
            return $this->loader->load('dcpbot', $useragent);
        }

        if ($s->contains('Delibar', false)) {
            return $this->loader->load('delibar', $useragent);
        }

        if ($s->contains('Diga', false)) {
            return $this->loader->load('diga', $useragent);
        }

        if ($s->contains('DoCoMo', false)) {
            return $this->loader->load('docomo', $useragent);
        }

        if ($s->contains('DomainCrawler', false)) {
            return $this->loader->load('domaincrawler', $useragent);
        }

        if ($s->contains('Elefent', false)) {
            return $this->loader->load('elefent', $useragent);
        }

        if ($s->contains('ElisaBot', false)) {
            return $this->loader->load('elisabot', $useragent);
        }

        if ($s->contains('Eudora', false)) {
            return $this->loader->load('eudora', $useragent);
        }

        if ($s->contains('EuripBot', false)) {
            return $this->loader->load('europe internet portal', $useragent);
        }

        if ($s->contains('EventGuruBot', false)) {
            return $this->loader->load('eventguru bot', $useragent);
        }

        if ($s->contains('ExbLanguageCrawler', false)) {
            return $this->loader->load('exb language crawler', $useragent);
        }

        if ($s->contains('Extras4iMovie', false)) {
            return $this->loader->load('extras4imovie', $useragent);
        }

        if ($s->contains('FaceBookBot', false)) {
            return $this->loader->load('facebook bot', $useragent);
        }

        if ($s->contains('FalkMaps', false)) {
            return $this->loader->load('falkmaps', $useragent);
        }

        if ($s->contains('FeedFinder', false)) {
            return $this->loader->load('feedfinder', $useragent);
        }

        if ($s->contains('Findlinks', false)) {
            return $this->loader->load('findlinks', $useragent);
        }

        if ($s->contains('Firebird', false)) {
            return $this->loader->load('firebird', $useragent);
        }

        if ($s->contains('Genieo', false)) {
            return $this->loader->load('genieo', $useragent);
        }

        if ($s->contains('GenieoWebFilter', false)) {
            return $this->loader->load('genieo web filter', $useragent);
        }

        if ($s->contains('Getleft', false)) {
            return $this->loader->load('getleft', $useragent);
        }

        if ($s->contains('GetPhotos', false)) {
            return $this->loader->load('getphotos', $useragent);
        }

        if ($s->contains('Godzilla', false)) {
            return $this->loader->load('godzilla', $useragent);
        }

        if ($s->contains('Google', false)) {
            return $this->loader->load('google', $useragent);
        }

        if ($s->contains('GoogleAdsbot', false)) {
            return $this->loader->load('adsbot google', $useragent);
        }

        if ($s->contains('GoogleEarth', false)) {
            return $this->loader->load('google earth', $useragent);
        }

        if ($s->contains('GoogleFontAnalysis', false)) {
            return $this->loader->load('google fontanalysis', $useragent);
        }

        if ($s->contains('GoogleImageProxy', false)) {
            return $this->loader->load('google image proxy', $useragent);
        }

        if ($s->contains('GoogleMarkupTester', false)) {
            return $this->loader->load('google markup tester', $useragent);
        }

        if ($s->contains('GooglePageSpeed', false)) {
            return $this->loader->load('google page speed', $useragent);
        }

        if ($s->contains('GoogleSitemaps', false)) {
            return $this->loader->load('google sitemaps', $useragent);
        }

        if ($s->contains('GoogleTv', false)) {
            return $this->loader->load('googletv', $useragent);
        }

        if ($s->contains('Grindr', false)) {
            return $this->loader->load('grindr', $useragent);
        }

        if ($s->contains('GSLFbot', false)) {
            return $this->loader->load('gslfbot', $useragent);
        }

        if ($s->contains('HaosouSpider', false)) {
            return $this->loader->load('haosouspider', $useragent);
        }

        if ($s->contains('HbbTv', false)) {
            return $this->loader->load('hbbtv', $useragent);
        }

        if ($s->contains('Heritrix', false)) {
            return $this->loader->load('heritrix', $useragent);
        }

        if ($s->contains('HitLeapViewer', false)) {
            return $this->loader->load('hitleap viewer', $useragent);
        }

        if ($s->contains('Hitpad', false)) {
            return $this->loader->load('hitpad', $useragent);
        }

        if ($s->contains('HotWallpapers', false)) {
            return $this->loader->load('hot wallpapers', $useragent);
        }

        if ($s->contains('Ibisbrowser', false)) {
            return $this->loader->load('ibisbrowser', $useragent);
        }

        if ($s->contains('Ibrowse', false)) {
            return $this->loader->load('ibrowse', $useragent);
        }

        if ($s->contains('Ibuilder', false)) {
            return $this->loader->load('ibuilder', $useragent);
        }

        if ($s->contains('Icedove', false)) {
            return $this->loader->load('icedove', $useragent);
        }

        if ($s->contains('Iceowl', false)) {
            return $this->loader->load('iceowl', $useragent);
        }

        if ($s->contains('Ichromy', false)) {
            return $this->loader->load('ichromy', $useragent);
        }

        if ($s->contains('IcjobsCrawler', false)) {
            return $this->loader->load('icjobs crawler', $useragent);
        }

        if ($s->contains('ImageMobile', false)) {
            return $this->loader->load('imagemobile', $useragent);
        }

        if ($s->contains('ImageSearcherS', false)) {
            return $this->loader->load('imagesearchers', $useragent);
        }

        if ($s->contains('Incredimail', false)) {
            return $this->loader->load('incredimail', $useragent);
        }

        if ($s->contains('IndyLibrary', false)) {
            return $this->loader->load('indy library', $useragent);
        }

        if ($s->contains('InettvBrowser', false)) {
            return $this->loader->load('inettvbrowser', $useragent);
        }

        if ($s->contains('InfohelferCrawler', false)) {
            return $this->loader->load('infohelfer crawler', $useragent);
        }

        if ($s->contains('InsiteRobot', false)) {
            return $this->loader->load('insite robot', $useragent);
        }

        if ($s->contains('Insitesbot', false)) {
            return $this->loader->load('insitesbot', $useragent);
        }

        if ($s->contains('IntegromedbCrawler', false)) {
            return $this->loader->load('integromedb crawler', $useragent);
        }

        if ($s->contains('InternetArchive', false)) {
            return $this->loader->load('internet archive bot', $useragent);
        }

        if ($s->contains('Ipick', false)) {
            return $this->loader->load('ipick', $useragent);
        }

        if ($s->contains('Isource', false)) {
            return $this->loader->load('isource+ app', $useragent);
        }

        if ($s->contains('JakartaCommonsHttpClient', false)) {
            return $this->loader->load('jakarta commons httpclient', $useragent);
        }

        if ($s->contains('JigsawCssValidator', false)) {
            return $this->loader->load('jigsaw css validator', $useragent);
        }

        if ($s->contains('JustCrawler', false)) {
            return $this->loader->load('just-crawler', $useragent);
        }

        if ($s->contains('Kindle', false)) {
            return $this->loader->load('kindle', $useragent);
        }

        if ($s->contains('Linguatools', false)) {
            return $this->loader->load('linguatoolsbot', $useragent);
        }

        if ($s->contains('LingueeBot', false)) {
            return $this->loader->load('linguee bot', $useragent);
        }

        if ($s->contains('LinkCheckerBot', false)) {
            return $this->loader->load('link-checker', $useragent);
        }

        if ($s->contains('LinkdexComBot', false)) {
            return $this->loader->load('linkdex bot', $useragent);
        }

        if ($s->contains('LinkLint', false)) {
            return $this->loader->load('linklint', $useragent);
        }

        if ($s->contains('LinkWalkerBot', false)) {
            return $this->loader->load('linkwalker', $useragent);
        }

        if ($s->contains('LittleBookmarkBox', false)) {
            return $this->loader->load('little-bookmark-box app', $useragent);
        }

        if ($s->contains('LtBot', false)) {
            return $this->loader->load('ltbot', $useragent);
        }

        if ($s->contains('MacInroyPrivacyAuditors', false)) {
            return $this->loader->load('macinroy privacy auditors', $useragent);
        }

        if ($s->contains('MagpieCrawler', false)) {
            return $this->loader->load('magpie crawler', $useragent);
        }

        if ($s->contains('MailExchangeWebServices', false)) {
            return $this->loader->load('mail exchangewebservices', $useragent);
        }

        if ($s->contains('Maven', false)) {
            return $this->loader->load('maven', $useragent);
        }

        if ($s->contains('Mechanize', false)) {
            return $this->loader->load('mechanize', $useragent);
        }

        if ($s->contains('MicrosoftWindowsNetworkDiagnostics', false)) {
            return $this->loader->load('microsoft windows network diagnostics', $useragent);
        }

        if ($s->contains('Mitsubishi', false)) {
            return $this->loader->load('mitsubishi', $useragent);
        }

        if ($s->contains('Mjbot', false)) {
            return $this->loader->load('mjbot', $useragent);
        }

        if ($s->contains('Mobilerss', false)) {
            return $this->loader->load('mobilerss', $useragent);
        }

        if ($s->contains('MovableType', false)) {
            return $this->loader->load('movabletype web log', $useragent);
        }

        if ($s->contains('Mozad', false)) {
            return $this->loader->load('mozad', $useragent);
        }

        if ($s->contains('archive-de.com', false)) {
            return $this->loader->load('archive-de.com', $useragent);
        }

        if ($s->contains('Mozilla', false)) {
            return $this->loader->load('mozilla', $useragent);
        }

        if ($s->contains('MsieCrawler', false)) {
            return $this->loader->load('msiecrawler', $useragent);
        }

        if ($s->contains('MsSearch', false)) {
            return $this->loader->load('ms search', $useragent);
        }

        if ($s->contains('MyEnginesBot', false)) {
            return $this->loader->load('myengines bot', $useragent);
        }

        if ($s->contains('Nec', false)) {
            return $this->loader->load('nec', $useragent);
        }

        if ($s->contains('Netbox', false)) {
            return $this->loader->load('netbox', $useragent);
        }

        if ($s->contains('NetNewsWire', false)) {
            return $this->loader->load('netnewswire', $useragent);
        }

        if ($s->contains('NetPositive', false)) {
            return $this->loader->load('netpositive', $useragent);
        }

        if ($s->contains('NetSurf', false)) {
            return $this->loader->load('netsurf', $useragent);
        }

        if ($s->contains('NetTv', false)) {
            return $this->loader->load('nettv', $useragent);
        }

        if ($s->contains('Netvibes', false)) {
            return $this->loader->load('netvibes', $useragent);
        }

        if ($s->contains('NewsBot', false)) {
            return $this->loader->load('news bot', $useragent);
        }

        if ($s->contains('NewsRack', false)) {
            return $this->loader->load('newsrack', $useragent);
        }

        if ($s->contains('NixGibts', false)) {
            return $this->loader->load('nixgibts', $useragent);
        }

        if ($s->contains('NodeJsHttpRequest', false)) {
            return $this->loader->load('node.js http_request', $useragent);
        }

        if ($s->contains('OnePassword', false)) {
            return $this->loader->load('1password', $useragent);
        }

        if ($s->contains('OpenVas', false)) {
            return $this->loader->load('open vulnerability assessment system', $useragent);
        }

        if ($s->contains('OpenWeb', false)) {
            return $this->loader->load('openweb', $useragent);
        }

        if ($s->contains('Origin', false)) {
            return $this->loader->load('origin', $useragent);
        }

        if ($s->contains('OssProxy', false)) {
            return $this->loader->load('ossproxy', $useragent);
        }

        if ($s->contains('Pagebull', false)) {
            return $this->loader->load('pagebull', $useragent);
        }

        if ($s->contains('PalmPixi', false)) {
            return $this->loader->load('palmpixi', $useragent);
        }

        if ($s->contains('PalmPre', false)) {
            return $this->loader->load('palmpre', $useragent);
        }

        if ($s->contains('Panasonic', false)) {
            return $this->loader->load('panasonic', $useragent);
        }

        if ($s->contains('Pandora', false)) {
            return $this->loader->load('pandora', $useragent);
        }

        if ($s->contains('Parchbot', false)) {
            return $this->loader->load('parchbot', $useragent);
        }

        if ($s->contains('PearHttpRequest2', false)) {
            return $this->loader->load('pear http_request2', $useragent);
        }

        if ($s->contains('PearHttpRequest', false)) {
            return $this->loader->load('pear http_request', $useragent);
        }

        if ($s->contains('Philips', false)) {
            return $this->loader->load('philips', $useragent);
        }

        if ($s->contains('PixraySeeker', false)) {
            return $this->loader->load('pixray-seeker', $useragent);
        }

        if ($s->contains('Playstation', false)) {
            return $this->loader->load('playstation', $useragent);
        }

        if ($s->contains('PlaystationBrowser', false)) {
            return $this->loader->load('playstation browser', $useragent);
        }

        if ($s->contains('Plukkie', false)) {
            return $this->loader->load('plukkie', $useragent);
        }

        if ($s->contains('PodtechNetwork', false)) {
            return $this->loader->load('podtech network', $useragent);
        }

        if ($s->contains('Pogodak', false)) {
            return $this->loader->load('pogodak', $useragent);
        }

        if ($s->contains('Postbox', false)) {
            return $this->loader->load('postbox', $useragent);
        }

        if ($s->contains('Powertv', false)) {
            return $this->loader->load('powertv', $useragent);
        }

        if ($s->contains('Prism', false)) {
            return $this->loader->load('prism', $useragent);
        }

        if ($s->contains('Python', false)) {
            return $this->loader->load('python', $useragent);
        }

        if ($s->contains('Qihoo', false)) {
            return $this->loader->load('qihoo', $useragent);
        }

        if ($s->contains('Qtek', false)) {
            return $this->loader->load('qtek', $useragent);
        }

        if ($s->contains('QtWeb', false)) {
            return $this->loader->load('qtweb internet browser', $useragent);
        }

        if ($s->contains('Quantcastbot', false)) {
            return $this->loader->load('quantcastbot', $useragent);
        }

        if ($s->contains('QuerySeekerSpider', false)) {
            return $this->loader->load('queryseekerspider', $useragent);
        }

        if ($s->contains('Realplayer', false)) {
            return $this->loader->load('realplayer', $useragent);
        }

        if ($s->contains('RgAnalytics', false)) {
            return $this->loader->load('rganalytics', $useragent);
        }

        if ($s->contains('Rippers', false)) {
            return $this->loader->load('ripper', $useragent);
        }

        if ($s->contains('Rojo', false)) {
            return $this->loader->load('rojo', $useragent);
        }

        if ($s->contains('RssingBot', false)) {
            return $this->loader->load('rssingbot', $useragent);
        }

        if ($s->contains('RssOwl', false)) {
            return $this->loader->load('rssowl', $useragent);
        }

        if ($s->contains('RukyBot', false)) {
            return $this->loader->load('ruky roboter', $useragent);
        }

        if ($s->contains('Ruunk', false)) {
            return $this->loader->load('ruunk', $useragent);
        }

        if ($s->contains('SamsungMobileBrowser', false)) {
            return $this->loader->load('samsung mobile browser', $useragent);
        }

        if ($s->contains('Samsung', false)) {
            return $this->loader->load('samsung', $useragent);
        }

        if ($s->contains('Sanyo', false)) {
            return $this->loader->load('sanyo', $useragent);
        }

        if ($s->contains('SaveTheWorldHeritage', false)) {
            return $this->loader->load('save-the-world-heritage bot', $useragent);
        }

        if ($s->contains('Scorpionbot', false)) {
            return $this->loader->load('scorpionbot', $useragent);
        }

        if ($s->contains('Scraper', false)) {
            return $this->loader->load('scraper', $useragent);
        }

        if ($s->contains('Searchmetrics', false)) {
            return $this->loader->load('searchmetricsbot', $useragent);
        }

        if ($s->contains('SemagerBot', false)) {
            return $this->loader->load('semager bot', $useragent);
        }

        if ($s->contains('SeoEngineWorldBot', false)) {
            return $this->loader->load('seoengine world bot', $useragent);
        }

        if ($s->contains('Setooz', false)) {
            return $this->loader->load('setooz', $useragent);
        }

        if ($s->contains('Shiira', false)) {
            return $this->loader->load('shiira', $useragent);
        }

        if ($s->contains('Shopsalad', false)) {
            return $this->loader->load('shopsalad', $useragent);
        }

        if ($s->contains('Siemens', false)) {
            return $this->loader->load('siemens', $useragent);
        }

        if ($s->contains('Sindice', false)) {
            return $this->loader->load('sindice fetcher', $useragent);
        }

        if ($s->contains('SiteKiosk', false)) {
            return $this->loader->load('sitekiosk', $useragent);
        }

        if ($s->contains('SlimBrowser', false)) {
            return $this->loader->load('slimbrowser', $useragent);
        }

        if ($s->contains('SmartSync', false)) {
            return $this->loader->load('smartsync app', $useragent);
        }

        if ($s->contains('SmartTv', false)) {
            return $this->loader->load('smarttv', $useragent);
        }

        if ($s->contains('SmartTvWebBrowser', false)) {
            return $this->loader->load('smarttv webbrowser', $useragent);
        }

        if ($s->contains('Snapbot', false)) {
            return $this->loader->load('snapbot', $useragent);
        }

        if ($s->contains('Snoopy', false)) {
            return $this->loader->load('snoopy', $useragent);
        }

        if ($s->contains('Snowtape', false)) {
            return $this->loader->load('snowtape', $useragent);
        }

        if ($s->contains('Songbird', false)) {
            return $this->loader->load('songbird', $useragent);
        }

        if ($s->contains('Sosospider', false)) {
            return $this->loader->load('sosospider', $useragent);
        }

        if ($s->contains('SpaceBison', false)) {
            return $this->loader->load('space bison', $useragent);
        }

        if ($s->contains('Spector', false)) {
            return $this->loader->load('spector', $useragent);
        }

        if ($s->contains('SpeedySpider', false)) {
            return $this->loader->load('speedy spider', $useragent);
        }

        if ($s->contains('SpellCheckBot', false)) {
            return $this->loader->load('spellcheck bot', $useragent);
        }

        if ($s->contains('SpiderLing', false)) {
            return $this->loader->load('spiderling', $useragent);
        }

        if ($s->contains('Spiderlytics', false)) {
            return $this->loader->load('spiderlytics', $useragent);
        }

        if ($s->contains('SpiderPig', false)) {
            return $this->loader->load('spider-pig', $useragent);
        }

        if ($s->contains('SprayCan', false)) {
            return $this->loader->load('spray-can', $useragent);
        }

        if ($s->contains('SPV', false)) {
            return $this->loader->load('spv', $useragent);
        }

        if ($s->contains('SquidWall', false)) {
            return $this->loader->load('squidwall', $useragent);
        }

        if ($s->contains('Sqwidgebot', false)) {
            return $this->loader->load('sqwidgebot', $useragent);
        }

        if ($s->contains('Strata', false)) {
            return $this->loader->load('strata', $useragent);
        }

        if ($s->contains('StrategicBoardBot', false)) {
            return $this->loader->load('strategicboardbot', $useragent);
        }

        if ($s->contains('StrawberryjamUrlExpander', false)) {
            return $this->loader->load('strawberryjam url expander', $useragent);
        }

        if ($s->contains('Sunbird', false)) {
            return $this->loader->load('sunbird', $useragent);
        }

        if ($s->contains('Superfish', false)) {
            return $this->loader->load('superfish', $useragent);
        }

        if ($s->contains('Superswan', false)) {
            return $this->loader->load('superswan', $useragent);
        }

        if ($s->contains('SymphonyBrowser', false)) {
            return $this->loader->load('symphonybrowser', $useragent);
        }

        if ($s->contains('SynapticWalker', false)) {
            return $this->loader->load('synapticwalker', $useragent);
        }

        if ($s->contains('TagInspectorBot', false)) {
            return $this->loader->load('taginspector', $useragent);
        }

        if ($s->contains('Tailrank', false)) {
            return $this->loader->load('tailrank', $useragent);
        }

        if ($s->contains('TasapImageRobot', false)) {
            return $this->loader->load('tasapimagerobot', $useragent);
        }

        if ($s->contains('TenFourFox', false)) {
            return $this->loader->load('tenfourfox', $useragent);
        }

        if ($s->contains('Terra', false)) {
            return $this->loader->load('terra', $useragent);
        }

        if ($s->contains('TheBatDownloadManager', false)) {
            return $this->loader->load('the bat download manager', $useragent);
        }

        if ($s->contains('ThemeSearchAndExtractionCrawler', false)) {
            return $this->loader->load('themesearchandextractioncrawler', $useragent);
        }

        if ($s->contains('ThumbShotsBot', false)) {
            return $this->loader->load('thumbshotsbot', $useragent);
        }

        if ($s->contains('Thunderstone', false)) {
            return $this->loader->load('thunderstone', $useragent);
        }

        if ($s->contains('TinEye', false)) {
            return $this->loader->load('tineye', $useragent);
        }

        if ($s->contains('TkcAutodownloader', false)) {
            return $this->loader->load('tkcautodownloader', $useragent);
        }

        if ($s->contains('TlsProber', false)) {
            return $this->loader->load('tlsprober', $useragent);
        }

        if ($s->contains('Toshiba', false)) {
            return $this->loader->load('toshiba', $useragent);
        }

        if ($s->contains('TrendictionBot', false)) {
            return $this->loader->load('trendiction bot', $useragent);
        }

        if ($s->contains('TrendMicro', false)) {
            return $this->loader->load('trend micro', $useragent);
        }

        if ($s->contains('TumblrRssSyndication', false)) {
            return $this->loader->load('tumblrrsssyndication', $useragent);
        }

        if ($s->contains('TuringMachine', false)) {
            return $this->loader->load('turingmachine', $useragent);
        }

        if ($s->contains('TurnitinBot', false)) {
            return $this->loader->load('turnitinbot', $useragent);
        }

        if ($s->contains('Tweetbot', false)) {
            return $this->loader->load('tweetbot', $useragent);
        }

        if ($s->contains('TwengabotDiscover', false)) {
            return $this->loader->load('twengabotdiscover', $useragent);
        }

        if ($s->contains('Twitturls', false)) {
            return $this->loader->load('twitturls', $useragent);
        }

        if ($s->contains('Typo', false)) {
            return $this->loader->load('typo3', $useragent);
        }

        if ($s->contains('TypoLinkvalidator', false)) {
            return $this->loader->load('typolinkvalidator', $useragent);
        }

        if ($s->contains('UnisterPortale', false)) {
            return $this->loader->load('unisterportale', $useragent);
        }

        if ($s->contains('UoftdbExperiment', false)) {
            return $this->loader->load('uoftdb experiment', $useragent);
        }

        if ($s->contains('Vanillasurf', false)) {
            return $this->loader->load('vanillasurf', $useragent);
        }

        if ($s->contains('Viralheat', false)) {
            return $this->loader->load('viral heat', $useragent);
        }

        if ($s->contains('VmsMosaic', false)) {
            return $this->loader->load('vmsmosaic', $useragent);
        }

        if ($s->contains('Vobsub', false)) {
            return $this->loader->load('vobsub', $useragent);
        }

        if ($s->contains('Voilabot', false)) {
            return $this->loader->load('voilabot', $useragent);
        }

        if ($s->contains('Vonnacom', false)) {
            return $this->loader->load('vonnacom', $useragent);
        }

        if ($s->contains('Voyager', false)) {
            return $this->loader->load('voyager', $useragent);
        }

        if ($s->contains('W3cChecklink', false)) {
            return $this->loader->load('w3c-checklink', $useragent);
        }

        if ($s->contains('W3cValidator', false)) {
            return $this->loader->load('w3c validator', $useragent);
        }

        if ($s->contains('W3m', false)) {
            return $this->loader->load('w3m', $useragent);
        }

        if ($s->contains('Webaroo', false)) {
            return $this->loader->load('webaroo', $useragent);
        }

        if ($s->contains('Webbotru', false)) {
            return $this->loader->load('webbotru', $useragent);
        }

        if ($s->contains('Webcapture', false)) {
            return $this->loader->load('webcapture', $useragent);
        }

        if ($s->contains('WebDownloader', false)) {
            return $this->loader->load('web downloader', $useragent);
        }

        if ($s->contains('Webimages', false)) {
            return $this->loader->load('webimages', $useragent);
        }

        if ($s->contains('Weblide', false)) {
            return $this->loader->load('weblide', $useragent);
        }

        if ($s->contains('WebLinkValidator', false)) {
            return $this->loader->load('web link validator', $useragent);
        }

        if ($s->contains('WebmasterworldServerHeaderChecker', false)) {
            return $this->loader->load('webmasterworldserverheaderchecker', $useragent);
        }

        if ($s->contains('WebOX', false)) {
            return $this->loader->load('webox', $useragent);
        }

        if ($s->contains('Webscan', false)) {
            return $this->loader->load('webscan', $useragent);
        }

        if ($s->contains('Websuchebot', false)) {
            return $this->loader->load('websuchebot', $useragent);
        }

        if ($s->contains('WebtvMsntv', false)) {
            return $this->loader->load('webtv/msntv', $useragent);
        }

        if ($s->contains('Wepbot', false)) {
            return $this->loader->load('wepbot', $useragent);
        }

        if ($s->contains('WiJobRoboter', false)) {
            return $this->loader->load('wi job roboter', $useragent);
        }

        if ($s->contains('Wikimpress', false)) {
            return $this->loader->load('wikimpress', $useragent);
        }

        if ($s->contains('Winamp', false)) {
            return $this->loader->load('winamp', $useragent);
        }

        if ($s->contains('Winkbot', false)) {
            return $this->loader->load('winkbot', $useragent);
        }

        if ($s->contains('Winwap', false)) {
            return $this->loader->load('winwap', $useragent);
        }

        if ($s->contains('Wire', false)) {
            return $this->loader->load('wire', $useragent);
        }

        if ($s->contains('Wisebot', false)) {
            return $this->loader->load('wisebot', $useragent);
        }

        if ($s->contains('Wizz', false)) {
            return $this->loader->load('wizz', $useragent);
        }

        if ($s->contains('Worldlingo', false)) {
            return $this->loader->load('worldlingo', $useragent);
        }

        if ($s->contains('WorldWideWeasel', false)) {
            return $this->loader->load('world wide weasel', $useragent);
        }

        if ($s->contains('Wotbox', false)) {
            return $this->loader->load('wotbox', $useragent);
        }

        if ($s->contains('WwwBrowser', false)) {
            return $this->loader->load('www browser', $useragent);
        }

        if ($s->contains('Wwwc', false)) {
            return $this->loader->load('wwwc', $useragent);
        }

        if ($s->contains('Wwwmail', false)) {
            return $this->loader->load('www4mail', $useragent);
        }

        if ($s->contains('WwwMechanize', false)) {
            return $this->loader->load('www-mechanize', $useragent);
        }

        if ($s->contains('Wwwster', false)) {
            return $this->loader->load('wwwster', $useragent);
        }

        if ($s->contains('XaldonWebspider', false)) {
            return $this->loader->load('xaldon webspider', $useragent);
        }

        if ($s->contains('XchaosArachne', false)) {
            return $this->loader->load('xchaos arachne', $useragent);
        }

        if ($s->contains('Xerka', false)) {
            return $this->loader->load('xerka', $useragent);
        }

        if ($s->contains('XmlRpcForPhp', false)) {
            return $this->loader->load('xml-rpc for php', $useragent);
        }

        if ($s->contains('Xspider', false)) {
            return $this->loader->load('xspider', $useragent);
        }

        if ($s->contains('Xyleme', false)) {
            return $this->loader->load('xyleme', $useragent);
        }

        if ($s->contains('YacyBot', false)) {
            return $this->loader->load('yacy bot', $useragent);
        }

        if ($s->contains('Yadowscrawler', false)) {
            return $this->loader->load('yadowscrawler', $useragent);
        }

        if ($s->contains('Yahoo', false)) {
            return $this->loader->load('yahoo!', $useragent);
        }

        if ($s->contains('YahooExternalCache', false)) {
            return $this->loader->load('yahooexternalcache', $useragent);
        }

        if ($s->contains('YahooMobileMessenger', false)) {
            return $this->loader->load('yahoo! mobile messenger', $useragent);
        }

        if ($s->contains('YahooPipes', false)) {
            return $this->loader->load('yahoo! pipes', $useragent);
        }

        if ($s->contains('YandexImagesBot', false)) {
            return $this->loader->load('yandeximages', $useragent);
        }

        if ($s->contains('YouWaveAndroidOnPc', false)) {
            return $this->loader->load('youwave android on pc', $useragent);
        }

        return $this->loader->load('unknown', $useragent);
    }
}
