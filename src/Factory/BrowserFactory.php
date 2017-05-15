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

        $firstCheck = [
            'revip.info site analyzer' => 'reverse ip lookup',
            'reddit pic scraper'       => 'reddit pic scraper',
            'mozilla crawl'            => 'mozilla crawler',
        ];

        foreach ($firstCheck as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if ($s->startsWith('[fban', false)) {
            return $this->loader->load('facebook app', $useragent);
        }

        $checkBeforeOpera = [
            'ucbrowserhd'      => 'uc browser hd',
            'flyflow'          => 'flyflow',
            'bdbrowser_i18n'   => 'baidu browser',
            'baidubrowser'     => 'baidu browser',
            'bdbrowserhd_i18n' => 'baidu browser hd',
            'bdbrowser_mini'   => 'baidu browser mini',
        ];

        foreach ($checkBeforeOpera as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
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

        $checkBeforeComodoDragon = [
            'ucbrowser'                   => 'ucbrowser',
            'ubrowser'                    => 'ucbrowser',
            'uc browser'                  => 'ucbrowser',
            'ucweb'                       => 'ucbrowser',
            'ic opengraph crawler'        => 'ibm connections',
            'coast'                       => 'coast',
            'opr'                         => 'opera',
            'opera'                       => 'opera',
            'icabmobile'                  => 'icab mobile',
            'icab'                        => 'icab',
            'hggh phantomjs screenshoter' => 'hggh screenshot system with phantomjs',
            'bl.uk_lddc_bot'              => 'bl.uk_lddc_bot',
            'phantomas'                   => 'phantomas',
            'seznam screenshot-generator' => 'seznam screenshot generator',
            'phantomjs'                   => 'phantomjs',
            'yabrowser'                   => 'yabrowser',
            'kamelio'                     => 'kamelio app',
            'fbav'                        => 'facebook app',
            'acheetahi'                   => 'cm browser',
            'puffin'                      => 'puffin',
            'stagefright'                 => 'stagefright',
            'samsungbrowser'              => 'samsungbrowser',
            'silk'                        => 'silk',
            'coc_coc_browser'             => 'coc_coc_browser',
            'navermatome'                 => 'matome',
            'flipboardproxy'              => 'flipboardproxy',
            'flipboard'                   => 'flipboard app',
            'seznam.cz'                   => 'seznam browser',
            'aviator'                     => 'aviator',
            'netfrontlifebrowser'         => 'netfrontlifebrowser',
            'icedragon'                   => 'icedragon',
        ];

        foreach ($checkBeforeComodoDragon as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if ($s->contains('dragon', false) && !$s->contains('dragonfly', false)) {
            return $this->loader->load('dragon', $useragent);
        }

        $checkBeforeWebview = [
            'beamrise'        => 'beamrise',
            'diglo'           => 'diglo',
            'apusbrowser'     => 'apusbrowser',
            'chedot'          => 'chedot',
            'qword'           => 'qword browser',
            'iridium'         => 'iridium browser',
            'avant'           => 'avant',
            'mxnitro'         => 'maxthon nitro',
            'mxbrowser'       => 'maxthon',
            'maxthon'         => 'maxthon',
            'myie'            => 'maxthon',
            'superbird'       => 'superbird',
            'tinybrowser'     => 'tinybrowser',
            'micromessenger'  => 'wechat app',
            'mqqbrowser/mini' => 'qqbrowser mini',
            'mqqbrowser'      => 'qqbrowser',
            'pinterest'       => 'pinterest app',
            'baiduboxapp'     => 'baidu box app',
            'wkbrowser'       => 'wkbrowser',
            'mb2345browser'   => '2345 browser',
        ];

        foreach ($checkBeforeWebview as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if ($s->containsAll(['chrome', 'version'], false)) {
            return $this->loader->load('android webview', $useragent);
        }

        if ($s->containsAll(['safari', 'version', 'tizen'], false)) {
            return $this->loader->load('samsung webview', $useragent);
        }

        $checkBeforeAnonymus = [
            'cybeye'     => 'cybeye',
            'rebelmouse' => 'rebelmouse',
            'seamonkey'  => 'seamonkey',
            'jobboerse'  => 'jobboerse bot',
            'navigator'  => 'netscape navigator',
        ];

        foreach ($checkBeforeAnonymus as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if ($s->containsAll(['firefox', 'anonym'], false)) {
            return $this->loader->load('firefox', $useragent);
        }

        if ($s->containsAll(['trident', 'anonym'], false)) {
            return $this->loader->load('internet explorer', $useragent);
        }

        $checkbeforeIe = [
            'windows-rss-platform'                => 'windows-rss-platform',
            'marketwirebot'                       => 'marketwirebot',
            'googletoolbar'                       => 'google toolbar',
            'netscape'                            => 'netscape',
            'lssrocketcrawler'                    => 'lightspeed systems rocketcrawler',
            'lightspeedsystems'                   => 'lightspeed systems crawler',
            'sl commerce client'                  => 'second live commerce client',
            'iemobile'                            => 'iemobile',
            'wpdesktop'                           => 'iemobile',
            'zunewp7'                             => 'iemobile',
            'xblwp7'                              => 'iemobile',
            'bingpreview'                         => 'bing preview',
            'haosouspider'                        => 'haosouspider',
            '360spider'                           => '360spider',
            'outlook-express'                     => 'outlook-express',
            'outlook'                             => 'outlook',
            'microsoft office mobile'             => 'office',
            'msoffice'                            => 'office',
            'microsoft office protocol discovery' => 'ms opd',
            'office excel'                        => 'excel',
            'microsoft excel'                     => 'excel',
            'powerpoint'                          => 'powerpoint',
            'wordpress'                           => 'wordpress',
            'office word'                         => 'word',
            'microsoft word'                      => 'word',
            'office onenote'                      => 'onenote',
            'microsoft onenote'                   => 'onenote',
            'office visio'                        => 'visio',
            'microsoft visio'                     => 'visio',
            'office access'                       => 'access',
            'microsoft access'                    => 'access',
            'lync'                                => 'lync',
            'office syncproc'                     => 'office syncproc',
            'office upload center'                => 'office upload center',
            'frontpage'                           => 'frontpage',
            'microsoft office'                    => 'office',
            'crazy browser'                       => 'crazy browser',
            'deepnet explorer'                    => 'deepnet explorer',
            'kkman'                               => 'kkman',
            'lunascape'                           => 'lunascape',
            'sleipnir'                            => 'sleipnir',
            'smartsite httpclient'                => 'smartsite httpclient',
            'gomezagent'                          => 'gomez site monitor',
            'orangebot'                           => 'orangebot',
            'tob'                                 => 't-online browser',
            't-online browser'                    => 't-online browser',
            'appengine-google'                    => 'google app engine',
            'crystalsemanticsbot'                 => 'crystalsemanticsbot',
        ];

        foreach ($checkbeforeIe as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
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

        $checkBeforeEdge = [
            'chromium'                            => 'chromium',
            'iron'                                => 'iron',
            'midori'                              => 'midori',
            'locubot'                             => 'locubot',
            'acapbot'                             => 'acapbot',
            'google page speed insights'          => 'google pagespeed insights',
            'web/snippet'                         => 'google web snippet',
            'googlebot-mobile'                    => 'googlebot-mobile',
            'google wireless transcoder'          => 'google wireless transcoder',
            'com.google.googleplus'               => 'google+ app',
            'google-http-java-client'             => 'google http client library for java',
            'googlebot-image'                     => 'google image search',
            'googlebot'                           => 'googlebot',
            'viera'                               => 'smartviera',
            'nichrome'                            => 'nichrome',
            'kinza'                               => 'kinza',
            'google keyword suggestion'           => 'google keyword suggestion',
            'google web preview'                  => 'google web preview',
            'google-adwords-displayads-webrender' => 'google adwords displayads webrender',
            'hubspot webcrawler'                  => 'hubspot webcrawler',
            'rockmelt'                            => 'rockmelt',
            ' se '                                => 'sogou explorer',
            'archivebot'                          => 'archivebot',
        ];

        foreach ($checkBeforeEdge as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if ($s->contains('edge', false) && null !== $platform && 'Windows Phone OS' === $platform->getName()) {
            return $this->loader->load('edge mobile', $useragent);
        }

        $checkBeforeDragon = [
            'edge'        => 'edge',
            'diffbot'     => 'diffbot',
            'vivaldi'     => 'vivaldi',
            'lbbrowser'   => 'liebao',
            'amigo'       => 'amigo',
            'chromeplus'  => 'coolnovo chrome plus',
            'coolnovo'    => 'coolnovo',
            'kenshoo'     => 'kenshoo',
            'bowser'      => 'bowser',
            '360se'       => '360 secure browser',
            '360ee'       => '360 speed browser',
            'asw'         => 'avast safezone',
            'schoolwires' => 'schoolwires app',
            'netnewswire' => 'netnewswire',
            'wire'        => 'wire app',
        ];

        foreach ($checkBeforeDragon as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
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

        $checkBeforeAndroidWebkit = [
            'flock'                       => 'flock',
            'crosswalk'                   => 'crosswalk',
            'bromium safari'              => 'vsentry',
            'domain.com'                  => 'pagepeeker screenshot maker',
            'pagepeeker'                  => 'pagepeeker',
            'chrome'                      => 'chrome',
            'crios'                       => 'chrome',
            'crmo'                        => 'chrome',
            'dolphin http client'         => 'dolphin smalltalk http client',
            'dolfin'                      => 'dolfin',
            'dolphin'                     => 'dolfin',
            'arora'                       => 'arora',
            'com.douban.group'            => 'douban app',
            'ovibrowser'                  => 'nokia proxy browser',
            'miuibrowser'                 => 'miui browser',
            'ibrowser'                    => 'ibrowser',
            'onebrowser'                  => 'onebrowser',
            'baiduspider-image'           => 'baidu image search',
            'baiduspider'                 => 'baiduspider',
            'http://www.baidu.com/search' => 'baidu mobile search',
            'yjapp'                       => 'yahoo! app',
            'yjtop'                       => 'yahoo! app',
        ];

        foreach ($checkBeforeAndroidWebkit as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
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

        $checkBeforeQt = [
            'webos'                => 'webkit/webos',
            'wosbrowser'           => 'webkit/webos',
            'wossystem'            => 'webkit/webos',
            'omniweb'              => 'omniweb',
            'windows phone search' => 'windows phone search',
            'windows-update-agent' => 'windows-update-agent',
            'classilla'            => 'classilla',
            'nokia'                => 'nokiabrowser',
            'twitter for i'        => 'twitter app',
            'twitterbot'           => 'twitterbot',
            'gsa'                  => 'google app',
            'quicktime'            => 'quicktime',
            'qtcarbrowser'         => 'model s browser',
        ];

        foreach ($checkBeforeQt as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if ($s->contains('Qt', true)) {
            return $this->loader->load('qt', $useragent);
        }

        $checkBeforeAppleMail = [
            'instagram'             => 'instagram app',
            'webclip'               => 'webclip app',
            'mercury'               => 'mercury',
            'macappstore'           => 'macappstore',
            'appstore'              => 'apple appstore app',
            'webglance'             => 'web glance',
            'yhoo_search_app'       => 'yahoo mobile app',
            'newsblur feed fetcher' => 'newsblur feed fetcher',
            'applecoremedia'        => 'coremedia',
            'dataaccessd'           => 'ios dataaccessd',
            'mailchimp'             => 'mailchimp.com',
            'mailbar'               => 'mailbar',
        ];

        foreach ($checkBeforeAppleMail as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
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

        $checkBeforeSafari = [
            'msnbot-media'             => 'msnbot-media',
            'adidxbot'                 => 'adidxbot',
            'msnbot'                   => 'bingbot',
            'playbook'                 => 'blackberry playbook tablet',
            'bb10'                     => 'blackberry',
            'blackberry'               => 'blackberry',
            'wetab-browser'            => 'wetab browser',
            'profiller'                => 'profiller',
            'wkhtmltopdf'              => 'wkhtmltopdf',
            'wkhtmltoimage'            => 'wkhtmltoimage',
            'wp-iphone'                => 'wordpress app',
            'wp-android'               => 'wordpress app',
            'oktamobile'               => 'okta mobile app',
            'kmail2'                   => 'kmail2',
            'eb-iphone'                => 'eb iphone/ipad app',
            'elmediaplayer'            => 'elmedia player',
            'dreamweaver'              => 'dreamweaver',
            'akregator'                => 'akregator',
            'installatron'             => 'installatron',
            'quora link preview'       => 'quora link preview bot',
            'quora'                    => 'quora app',
            'rocky chatwork mobile'    => 'rocky chatwork mobile',
            'adsbot-google-mobile'     => 'adsbot google-mobile',
            'epiphany'                 => 'epiphany',
            'rekonq'                   => 'rekonq',
            'skyfire'                  => 'skyfire',
            'flixsterios'              => 'flixster app',
            'adbeat_bot'               => 'adbeat bot',
            'adbeat.com'               => 'adbeat bot',
            'secondlife'               => 'second live client',
            'second life'              => 'second live client',
            'salesforce1'              => 'salesforce app',
            'salesforcetouchcontainer' => 'salesforce app',
            'nagios-plugins'           => 'nagios',
            'check_http'               => 'nagios',
            'bingbot'                  => 'bingbot',
            'mediapartners-google'     => 'adsense bot',
            'smtbot'                   => 'smtbot',
            'diigobrowser'             => 'diigo browser',
            'kontact'                  => 'kontact',
            'qupzilla'                 => 'qupzilla',
            'fxios'                    => 'firefox for ios',
            'qutebrowser'              => 'qutebrowser',
            'otter'                    => 'otter',
            'palemoon'                 => 'palemoon',
            'slurp'                    => 'slurp',
            'applebot'                 => 'applebot',
            'soundcloud'               => 'soundcloud app',
            'rival iq'                 => 'rival iq bot',
            'evernote clip resolver'   => 'evernote clip resolver',
            'evernote'                 => 'evernote app',
            'fluid'                    => 'fluid',
            'safari'                   => 'safari',
            'windows phone ad client'  => 'windows phone ad client',
        ];

        foreach ($checkBeforeSafari as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
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

        if ($s->contains('microsoft url control', false)) {
            return $this->loader->load('microsoft url control', $useragent);
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

        if ($s->contains('mozilla', false)) {
            return $this->loader->load('mozilla', $useragent);
        }

        if ($s->startsWith('GOOG', true)) {
            return $this->loader->load('googlebot', $useragent);
        }

        if ($s->contains('fetchstream', false)) {
            return $this->loader->load('fetch-stream', $useragent);
        }

        if ($s->contains('autoit', false)) {
            return $this->loader->load('autoit', $useragent);
        }

        if ($s->contains('atvoice', false)) {
            return $this->loader->load('atvoice', $useragent);
        }

        return $this->loader->load('unknown', $useragent);
    }
}
