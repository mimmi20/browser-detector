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
            'outlook social connector'            => 'outlook social connector',
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
            '360se'                               => '360 secure browser',
            '360ee'                               => '360 speed browser',
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

        $checkBeforeSafariUiwebview = [
            'twcan/sportsnet' => 'twc sportsnet',
            'adobeair' => 'adobe air',
            'easouspider' => 'easouspider',
        ];

        foreach ($checkBeforeSafariUiwebview as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if (preg_match('/^Mozilla\/5\.0.*\((iPhone|iPad|iPod).*\).*AppleWebKit\/.*\(.*KHTML, like Gecko.*\).*Mobile.*/i', $useragent)) {
            return $this->loader->load('mobile safari uiwebview', $useragent);
        }

        $checkBeforeIos = [
            'waterfox' => 'waterfox',
            'thunderbird' => 'thunderbird',
            'fennec' => 'fennec',
            'myibrow' => 'my internet browser',
            'daumoa' => 'daumoa',
            'unister-test' => 'unistertesting',
            'unistertesting' => 'unistertesting',
            'unister-https-test' => 'unistertesting',
            'iceweasel' => 'iceweasel',
            'icecat' => 'icecat',
            'iceape' => 'iceape',
            'galeon' => 'galeon',
            'surveybot' => 'surveybot',
            'aggregator:spinn3r' => 'spinn3r rss aggregator',
            'tweetmemebot' => 'tweetmeme bot',
            'butterfly' => 'butterfly robot',
            'james bot' => 'jamesbot',
            'msie or firefox mutant; not on Windows server' => 'daumoa',
            'sailfishbrowser' => 'sailfish browser',
            'kazehakase' => 'kazehakase',
            'cometbird' => 'cometbird',
            'camino' => 'camino',
            'slimerjs' => 'slimerjs',
            'multizilla' => 'multizilla',
            'minimo' => 'minimo',
            'microb' => 'microb',
            'maemo browser' => 'microb',
            'maemobrowser' => 'microb',
            'k-meleon' => 'k-meleon',
            'curb' => 'curb',
            'link_thumbnailer' => 'link_thumbnailer',
            'mechanize' => 'mechanize',
            'ruby' => 'generic ruby crawler',
            'googleimageproxy' => 'google image proxy',
            'dalvik' => 'dalvik',
            'bb_work_connect' => 'bb work connect',
            'firefox' => 'firefox',
            'minefield' => 'firefox',
            'shiretoko' => 'firefox',
            'bonecho' => 'firefox',
            'namoroka' => 'firefox',
            'gvfs' => 'gvfs',
            'luakit' => 'luakit',
            'playstation 3' => 'netfront',
            'sistrix' => 'sistrix crawler',
            'ezooms' => 'ezooms',
            'grapefx' => 'grapefx',
            'grapeshotcrawler' => 'grapeshotcrawler',
            'mail.ru' => 'mail.ru',
            'proximic' => 'proximic',
            'polaris' => 'polaris',
            'another web mining tool' => 'another web mining tool',
            'awmt' => 'another web mining tool',
            'wbsearchbot' => 'wbsearchbot',
            'wbsrch' => 'wbsearchbot',
            'konqueror' => 'konqueror',
            'typo3-linkvalidator' => 'typo3 linkvalidator',
            'feeddlerrss' => 'feeddler rss reader',
        ];

        foreach ($checkBeforeIos as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if (preg_match('/^mozilla\/5\.0 \((iphone|ipad|ipod).*CPU like Mac OS X.*\) AppleWebKit\/\d+/i', $useragent)) {
            return $this->loader->load('safari', $useragent);
        }

        $checkBeforeMosbookmarks = [
            'ios' => 'mobile safari uiwebview',
            'iphone' => 'mobile safari uiwebview',
            'ipad' => 'mobile safari uiwebview',
            'ipod' => 'mobile safari uiwebview',
            'paperlibot' => 'paper.li bot',
            'spbot' => 'seoprofiler',
            'dotbot' => 'dotbot',
            'google-structureddatatestingtool' => 'google structured-data testingtool',
            'google-structured-data-testing-tool' => 'google structured-data testingtool',
            'webmastercoffee' => 'webmastercoffee',
            'ahrefs' => 'ahrefsbot',
            'apercite' => 'apercite',
            'woobot' => 'woobot',
            'scoutjet' => 'scoutjet',
            'blekkobot' => 'blekkobot',
            'pagesinventory' => 'pagesinventory bot',
            'slackbot-linkexpanding' => 'slackbot-link-expanding',
            'slackbot' => 'slackbot',
            'seokicks-robot' => 'seokicks robot',
            'alexabot' => 'alexabot',
            'exabot' => 'exabot',
            'domainscan' => 'domainscan server monitoring',
            'jobroboter' => 'jobroboter',
            'acoonbot' => 'acoonbot',
            'woriobot' => 'woriobot',
            'monobot' => 'monobot',
            'domainsigmacrawler' => 'domainsigmacrawler',
            'bnf.fr_bot' => 'bnf.fr bot',
            'crawlrobot' => 'crawlrobot',
            'addthis.com robot' => 'addthis.com robot',
            'yeti' => 'naverbot',
            'naver.com/robots' => 'naverbot',
            'robots' => 'testcrawler',
            'deusu' => 'werbefreie deutsche suchmaschine',
            'obot' => 'obot',
            'zumbot' => 'zumbot',
            'umbot' => 'umbot',
            'picmole' => 'picmole bot',
            'zollard' => 'zollard worm',
            'fhscan core' => 'fhscan core',
            'nbot' => 'nbot',
            'loadtimebot' => 'loadtimebot',
            'scrubby' => 'scrubby',
            'squzer' => 'squzer',
            'piplbot' => 'piplbot',
            'everyonesocialbot' => 'everyonesocialbot',
            'aolbot' => 'aolbot',
            'glbot' => 'glbot',
            'lbot' => 'lbot',
            'blexbot' => 'blexbot',
            'socialradarbot' => 'socialradar bot',
            'synapse' => 'apache synapse',
            'linkdexbot' => 'linkdex bot',
            'coccoc' => 'coccoc bot',
            'siteexplorer' => 'siteexplorer',
            'semrushbot' => 'semrushbot',
            'istellabot' => 'istellabot',
            'meanpathbot' => 'meanpathbot',
            'xml sitemaps generator' => 'xml sitemaps generator',
            'seznambot' => 'seznambot',
            'urlappendbot' => 'urlappendbot',
            'netseer crawler' => 'netseer crawler',
            'add catalog' => 'add catalog',
            'moreover' => 'moreover',
            'linkpadbot' => 'linkpadbot',
            'lipperhey seo service' => 'lipperhey seo service',
            'blog search' => 'blog search',
            'qualidator.com bot' => 'qualidator.com bot',
            'fr-crawler' => 'fr-crawler',
            'ca-crawler' => 'ca-crawler',
            'website thumbnail generator' => 'website thumbnail generator',
            'webthumb' => 'webthumb',
            'komodiabot' => 'komodiabot',
            'grouphigh' => 'grouphigh bot',
            'theoldreader' => 'the old reader',
            'google-site-verification' => 'google-site-verification',
            'prlog' => 'prlog',
            'cms crawler' => 'cms crawler',
            'pmoz.info odp link checker' => 'pmoz.info odp link checker',
            'twingly recon' => 'twingly recon',
            'embedly' => 'embedly',
            'alexa site audit' => 'alexa site audit',
            'mj12bot' => 'mj12bot',
            'httrack' => 'httrack',
            'unisterbot' => 'unisterbot',
            'careerbot' => 'careerbot',
            '80legs' => '80legs',
            '80bot' => '80legs',
            'wada.vn' => 'wada.vn search bot',
            'lynx' => 'lynx',
            'nx' => 'netfront nx',
            'wiiu' => 'netfront nx',
            'nintendo 3ds' => 'netfront nx',
            'netfront' => 'netfront',
            'playstation 4' => 'netfront',
            'xovibot' => 'xovibot',
            '007ac9 crawler' => '007ac9 crawler',
            '200pleasebot' => '200pleasebot',
            'abonti' => 'abonti websearch',
            'publiclibraryarchive' => 'publiclibraryarchive bot',
            'pad-bot' => 'pad-bot',
            'softlistbot' => 'softlistbot',
            'sreleasebot' => 'sreleasebot',
            'vagabondo' => 'vagabondo',
            'special_archiver' => 'internet archive special archiver',
            'optimizer' => 'optimizer bot',
            'sophora linkchecker' => 'sophora linkchecker',
            'seodiver' => 'seodiver bot',
            'itsscan' => 'itsscan',
            'google desktop' => 'google desktop',
            'lotus-notes' => 'lotus notes',
            'askpeterbot'=> 'askpeterbot',
            'discoverybot' => 'discovery bot',
            'yandexbot' => 'yandexbot',
        ];

        foreach ($checkBeforeMosbookmarks as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if ($s->containsAll(['mosbookmarks', 'link checker'], false)) {
            return $this->loader->load('mosbookmarks link checker', $useragent);
        }

        $checkBeforeKranken = [
            'mosbookmarks' => 'mosbookmarks',
            'webmasteraid' => 'webmasteraid',
            'aboutusbot johnny5' => 'aboutus bot johnny5',
            'aboutusbot' => 'aboutus bot',
            'semantic-visions.com crawler' => 'semantic-visions.com crawler',
            'waybackarchive.org' => 'wayback archive bot',
            'openvas' => 'open vulnerability assessment system',
            'mixrankbot' => 'mixrankbot',
            'infegyatlas' => 'infegyatlas',
            'mojeekbot' => 'mojeekbot',
            'memorybot' => 'memorybot',
            'domainappender' => 'domainappender bot',
            'gidbot' => 'gidbot',
            'wap browser/maui' => 'maui wap browser',
            'discovered' => 'discovered',
            'gosquared-thumbnailer' => 'gosquared-thumbnailer',
            'red' => 'redbot',
            'dbot' => 'dbot',
            'pwbot' => 'pwbot',
            '+5bot' => 'plus5bot',
            'wasalive-bot' => 'wasalive bot',
            'openhosebot' => 'openhosebot',
            'urlfilterdb-crawler' => 'urlfilterdb crawler',
            'metager2-verification-bot' => 'metager2-verification-bot',
            'powermarks' => 'powermarks',
            'cloudflare-alwaysonline' => 'cloudflare alwaysonline',
            'phantom.js bot' => 'phantom.js bot',
            'phantom' => 'phantom browser',
            'shrook' => 'shrook',
            'netestate ne crawler' => 'netestate ne crawler',
            'garlikcrawler' => 'garlikcrawler',
            'metageneratorcrawler' => 'metageneratorcrawler',
            'screenerbot' => 'screenerbot',
            'webtarantula.com crawler' => 'webtarantula',
            'backlinkcrawler' => 'backlinkcrawler',
            'linkscrawler' => 'linkscrawler',
            'ssearch_bot' => 'ssearch crawler',
            'ssearch crawler' => 'ssearch crawler',
            'hrcrawler' => 'hrcrawler',
            'icc-crawler' => 'icc-crawler',
            'arachnida web crawler' => 'arachnida web crawler',
            'finderlein research crawler' => 'finderlein research crawler',
            'testcrawler' => 'testcrawler',
            'scopia crawler' => 'scopia crawler',
            'metajobbot' => 'metajobbot',
            'lucidworks' => 'lucidworks bot',
            'pub-crawler' => 'pub-crawler',
            'archive.org.ua crawler' => 'internet archive',
            'digincore bot' => 'digincore bot',
            'steeler' => 'steeler',
            'electricmonk' => 'duedil crawler',
            'virtuoso' => 'virtuoso',
            'aboundex' => 'aboundexbot',
            'r6_commentreader' => 'r6 commentreader',
            'r6_feedfetcher' => 'r6 feedfetcher',
            'crazywebcrawler' => 'crazywebcrawler',
            'crawler4j' => 'crawler4j',
            'ichiro/mobile' => 'ichiro mobile bot',
            'ichiro' => 'ichiro bot',
            'tineye-bot' => 'tineye bot',
            'livelapbot' => 'livelap crawler',
            'safesearch microdata crawler' => 'safesearch microdata crawler',
            'fastbot crawler' => 'fastbot crawler',
            'camcrawler' => 'camcrawler',
            'domaincrawler' => 'domaincrawler',
            'pagefreezer' => 'pagefreezer',
            'showyoubot' => 'showyoubot',
            'y!j-asr' => 'yahoo! japan',
            'y!j-bsc' => 'yahoo! japan',
            'rogerbot' => 'rogerbot',
            'crawler' => 'crawler',
            'jig browser web' => 'jig browser web',
            't-h-u-n-d-e-r-s-t-o-n-e' => 'texis webscript',
            'focuseekbot' => 'focuseekbot',
            'vbseo' => 'vbulletin seo bot',
            'kgbody' => 'kgbody',
            'jobdiggerspider' => 'jobdiggerspider',
            'imrbot' => 'mignify bot',
            'kulturarw3' => 'kulturarw3',
            'merchantcentricbot' => 'merchantcentricbot',
            'nett.io bot' => 'nett.io bot',
            'semanticbot' => 'semanticbot',
            'tweetedtimes' => 'tweetedtimes bot',
            'vkshare' => 'vkshare',
            'yahoo ad monitoring' => 'yahoo ad monitoring',
            'yioopbot' => 'yioopbot',
            'zitebot' => 'zitebot',
            'espial' => 'espial tv browser',
            'sitecon' => 'sitecon',
            'ibooks author' => 'ibooks author',
            'iweb' => 'iweb',
            'newsfire' => 'newsfire',
            'rmsnapkit' => 'rmsnapkit',
            'sandvox' => 'sandvox',
            'tubetv' => 'tubetv',
            'elluminate live' => 'elluminate live',
            'element browser' => 'element browser',
            'esribot' => 'esribot',
            'quicklook' => 'quicklook',
            'dillo' => 'dillo',
            'digg' => 'digg bot',
            'zetakey' => 'zetakey browser',
            'getprismatic.com' => 'prismatic app',
            'foma' => 'sharp',
            'sh05c' => 'sharp',
            'openwebkitsharp' => 'open-webkit-sharp',
            'ajaxsnapbot' => 'ajaxsnapbot',
            'owler' => 'owler bot',
            'yahoo link preview' => 'yahoo link preview',
        ];

        foreach ($checkBeforeKranken as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if ($s->containsAll(['kraken', 'linkfluence'], false)) {
            return $this->loader->load('kraken', $useragent);
        }

        $checkBeforeOpenwaveBrowser = [
            'qwantify' => 'qwantify',
            'setlinks bot' => 'setlinks.ru crawler',
            'megaindex.ru' => 'megaindex bot',
            'cliqzbot' => 'cliqzbot',
            'dawinci antiplag spider' => 'dawinci antiplag spider',
            'advbot' => 'advbot',
            'duckduckgo-favicons-bot' => 'duckduck favicons bot',
            'zyborg' => 'wisenut search engine crawler',
            'hypercrawl' => 'hypercrawl',
            'worldwebheritage' => 'worldwebheritage.org bot',
            'begunadvertising' => 'begun advertising bot',
            'trendwinhttp' => 'trendwinhttp',
            'winhttp' => 'winhttp',
            'skypeuripreview' => 'skypeuripreview',
            'lipperhey-kaus-australis' => 'lipperhey kaus australis',
            'jasmine' => 'jasmine',
            'yoozbot' => 'yoozbot',
            'online-webceo-bot' => 'webceo bot',
            'niki-bot' => 'niki-bot',
            'contextad bot' => 'contextad bot',
            'integrity' => 'integrity',
            'masscan' => 'masscan',
            'zmeu' => 'zmeu',
            'sogou web spider' => 'sogou web spider',
            'openwave' => 'openwave mobile browser',
            'up.browser' => 'openwave mobile browser',
        ];

        foreach ($checkBeforeOpenwaveBrowser as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if ($s->contains('UP/', true)) {
            return $this->loader->load('openwave mobile browser', $useragent);
        }

        if (preg_match('/(obigointernetbrowser|obigo\-browser|obigo|telecabrowser|teleca)(\/|-)q(\d+)/i', $useragent)) {
            return $this->loader->load('obigo q', $useragent);
        }

        $checkBeforeGoHttpClient = [
            'teleca' => 'teleca-obigo',
            'obigo' => 'teleca-obigo',
            'au-mic' => 'teleca-obigo',
            'mic/' => 'teleca-obigo',
            'davclnt' => 'microsoft-webdav',
            'xing-contenttabreceiver' => 'xing contenttabreceiver',
            'slingstone' => 'yahoo slingstone',
            'bot for jce' => 'bot for jce',
            'validator.nu/lv' => 'validator.nu/lv',
            'securepoint cf' => 'securepoint content filter',
            'sogou-spider' => 'sogou spider',
            'rankflex' => 'rankflex',
            'domnutch' => 'domnutch bot',
            'nutch' => 'nutch',
            'boardreader favicon fetcher' => 'boardreader favicon fetcher',
            'checksite verification agent' => 'checksite verification agent',
            'experibot' => 'experibot',
            'feedblitz' => 'feedblitz',
            'rss2html' => 'rss2html',
            'feedlyapp' => 'feedly app',
            'genderanalyzer' => 'genderanalyzer',
            'gooblog' => 'gooblog',
            'tumblr' => 'tumblr app',
            'w3c_i18n-checker' => 'w3c i18n checker',
            'w3c_unicorn' => 'w3c unicorn',
            'alltop' => 'alltop app',
            'internetseer' => 'internetseer.com',
            'admantx platform semantic analyzer' => 'admantx platform semantic analyzer',
            'universalfeedparser' => 'universalfeedparser',
            'binlar' => 'larbin',
            'larbin' => 'larbin',
            'unityplayer' => 'unity web player',
            'wesee:search' => 'wesee:search',
            'wesee:ads' => 'wesee:ads',
            'a6-indexer' => 'a6-indexer',
            'nerdybot' => 'nerdybot',
            'peeplo screenshot bot' => 'peeplo screenshot bot',
            'ccbot' => 'ccbot',
            'visionutils' => 'visionutils',
            'feedly' => 'feedly feed fetcher',
            'photon' => 'photon',
            'wdg_validator' => 'html validator',
            'yisouspider' => 'yisouspider',
            'hivabot' => 'hivabot',
            'comodo spider' => 'comodo spider',
            'openwebspider' => 'openwebspider',
            'psbot-image' => 'picsearch bot',
            'psbot-page' => 'picsearch bot',
            'bloglovin' => 'bloglovin bot',
            'viralvideochart' => 'viralvideochart bot',
            'metaheadersbot' => 'metaheadersbot',
            'zendhttpclient' => 'zend_http_client',
            'zend_http_client' => 'zend_http_client',
            'zend\http\client' => 'zend_http_client',
            'wget' => 'wget',
            'scrapy' => 'scrapy',
            'moozilla' => 'moozilla',
            'antbot' => 'antbot',
            'browsershots' => 'browsershots',
            'revolt' => 'bot revolt',
            'pdrlabs' => 'pdrlabs bot',
            'elinks' => 'elinks',
            'linkstats bot' => 'linkstats bot',
            'bcklinks' => 'bcklinks',
            'links' => 'links',
            'airmail' => 'airmail',
            'web.de mailcheck' => 'web.de mailcheck',
            'screaming frog seo spider' => 'screaming frog seo spider',
            'androiddownloadmanager' => 'android download manager',
        ];

        foreach ($checkBeforeGoHttpClient as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if (preg_match('/go ([\d\.]+) package http/i', $useragent)) {
            return $this->loader->load('go httpclient', $useragent);
        }

        $checkBeforeSafariUiwebview = [
            'go-http-client' => 'go httpclient',
            'proxy gear pro' => 'proxy gear pro',
            'tiny tiny rss' => 'tiny tiny rss',
            'readability' => 'readability',
            'nsplayer' => 'windows media player',
            'pingdom' => 'pingdom',
            'gg peekbot' => 'gg peekbot',
            'itunes' => 'itunes',
            'libreoffice' => 'libreoffice',
            'openoffice' => 'openoffice',
            'thumbnailagent' => 'thumbnailagent',
            'ez publish link validator' => 'ez publish link validator',
            'thumbsniper' => 'thumbsniper',
            'stq_bot' => 'searchteq bot',
            'snk screenshot bot' => 'save n keep screenshot bot',
            'synhttpclient' => 'synhttpclient',
            'eventmachine httpclient' => 'eventmachine httpclient',
            'livedoor' => 'livedoor',
            'httpclient' => 'httpclient',
            'implisensebot' => 'implisensebot',
            'buibui-bot' => 'buibui-bot',
            'thumbshots-de-bot' => 'thumbshots-de-bot',
            'python-requests' => 'python-requests',
            'python-urllib' => 'python-urllib',
            'bot.araturka.com' => 'bot.araturka.com',
            'http_requester' => 'http_requester',
            'whatweb' => 'whatweb web scanner',
            'isc header collector handlers' => 'isc header collector handlers',
            'thumbor' => 'thumbor',
            'forum poster' => 'forum poster',
            'facebot' => 'facebot',
            'netzcheckbot' => 'netzcheckbot',
            'mib' => 'motorola internet browser',
            'facebookscraper' => 'facebookscraper',
            'zookabot' => 'zookabot',
            'metauri' => 'metauri bot',
            'freewebmonitoring sitechecker' => 'freewebmonitoring sitechecker',
            'ipv4scan' => 'ipv4scan',
            'domainsbot' => 'domainsbot',
            'bubing' => 'bubing bot',
            'ramblermail' => 'ramblermail bot',
            'iisbot' => 'iis site analysis web crawler',
            'jooblebot' => 'jooblebot',
            'superfeedr bot' => 'superfeedr bot',
            'feedburner' => 'feedburner',
            'icarus6j' => 'icarus6j',
            'wsr-agent' => 'wsr-agent',
            'blogshares spiders' => 'blogshares spiders',
            'quickiwiki' => 'quickiwiki bot',
            'pycurl' => 'pycurl',
            'libcurl-agent' => 'libcurl',
            'taproot' => 'taproot bot',
            'guzzlehttp' => 'guzzle http client',
            'curl' => 'curl',
            'facebookexternalhit' => 'facebookexternalhit',
            'embed php library' => 'embed php library',
            'php' => 'php',
            'apple-pubsub' => 'apple pubsub',
            'simplepie' => 'simplepie',
            'bigbozz' => 'bigbozz - financial search',
            'eccp' => 'eccp',
            'gigablastopensource' => 'gigablast search engine',
            'webindex' => 'webindex',
            'prince' => 'prince',
            'adsense-snapshot-google' => 'adsense snapshot bot',
            'amazon cloudfront' => 'amazon cloudfront',
            'bandscraper' => 'bandscraper',
            'bitlybot' => 'bitlybot',
            'cars-app-browser' => 'cars-app-browser',
            'coursera-mobile' => 'coursera mobile app',
            'crowsnest' => 'crowsnest mobile app',
            'dorado wap-browser' => 'dorado wap browser',
            'goldfire server' => 'goldfire server',
            'iball' => 'iball',
            'inagist url resolver' => 'inagist url resolver',
            'jeode' => 'jeode',
            'kraken' => 'krakenjs',
            'com.linkedin' => 'linkedinbot',
            'mixbot' => 'mixbot',
            'busecurityproject' => 'busecurityproject',
            'restify' => 'restify',
            'vlc' => 'vlc media player',
            'webringchecker' => 'webringchecker',
            'bot-pge.chlooe.com' => 'chlooe bot',
            'seebot' => 'seebot',
            'ltx71' => 'ltx71 bot',
            'cookiereports' => 'cookie reports bot',
            'elmer' => 'elmer',
            'iframely' => 'iframely bot',
            'metainspector' => 'metainspector',
            'microsoft-cryptoapi' => 'microsoft cryptoapi',
            'microsoft url control' => 'microsoft url control',
            'owasp_secret_browser' => 'owasp_secret_browser',
            'smrf url expander' => 'smrf url expander',
            'speedyspider' => 'speedy spider',
            'speedy spider' => 'speedy spider',
            'speedy_spider' => 'speedy spider',
            'superarama.com - bot' => 'superarama.com - bot',
            'wnmbot' => 'wnmbot',
            'website explorer' => 'website explorer',
            'city-map screenshot service' => 'city-map screenshot service',
            'optivo(r) nethelper' => 'optivo nethelper',
            'pr-cy.ru screenshot bot' => 'screenshot bot',
            'cyberduck' => 'cyberduck',
            'accserver' => 'accserver',
            'izsearch' => 'izsearch bot',
            'netlyzer fastprobe' => 'netlyzer fastprobe',
            'mnogosearch' => 'mnogosearch',
            'uipbot' => 'uipbot',
            'mbot' => 'mbot',
            'ms web services client protocol' => '.net framework clr',
            'atomicbrowser' => 'atomic browser',
            'atomiclite' => 'atomic browser lite',
            'feedfetcher-google' => 'google feedfetcher',
            'perfect%20browser' => 'perfect browser',
        ];

        foreach ($checkBeforeSafariUiwebview as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
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
