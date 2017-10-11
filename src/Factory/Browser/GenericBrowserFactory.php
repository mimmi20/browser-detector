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
namespace BrowserDetector\Factory\Browser;

use BrowserDetector\Factory\FactoryInterface;
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;
use UaResult\Os\OsInterface;

/**
 * Browser detection class
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
class GenericBrowserFactory implements FactoryInterface
{
    /**
     * @var \BrowserDetector\Loader\ExtendedLoaderInterface
     */
    private $loader;

    /**
     * @param \BrowserDetector\Loader\ExtendedLoaderInterface $loader
     */
    public function __construct(ExtendedLoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string                        $useragent
     * @param Stringy                       $s
     * @param \UaResult\Os\OsInterface|null $platform
     *
     * @return array
     */
    public function detect(string $useragent, Stringy $s, ?OsInterface $platform = null): array
    {
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
            'fban/messenger'              => 'facebook messenger app',
            'fbav'                        => 'facebook app',
            'acheetahi'                   => 'cm browser',
            'puffin'                      => 'puffin',
            'stagefright'                 => 'stagefright',
            'oculusbrowser'               => 'oculus-browser',
            'surfbrowser'                 => 'surfbrowser',
            'surf/'                       => 'surfbrowser',
            'avirascout'                  => 'avira scout',
            'samsungbrowser'              => 'samsungbrowser',
            'silk'                        => 'silk',
            'coc_coc_browser'             => 'coc_coc_browser',
            'navermatome'                 => 'matome',
            'flipboardproxy'              => 'flipboardproxy',
            'flipboard'                   => 'flipboard app',
            'seznambot'                   => 'seznambot',
            'seznam.cz'                   => 'seznam browser',
            'sznprohlizec'                => 'seznam browser',
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
            'qqbrowser'       => 'qqbrowser',
            'Pinterestbot'    => 'pinterest bot',
            'pinterest'       => 'pinterest app',
            'baiduboxapp'     => 'baidu box app',
            'wkbrowser'       => 'wkbrowser',
            'mb2345browser'   => '2345 browser',
            '2345explorer'    => '2345 browser',
            '2345chrome'      => '2345 browser',
            'sohunews'        => 'sohunews app',
            'miuibrowser'     => 'miui browser',
            'gsa'             => 'google app',
            'alohabrowser'    => 'aloha-browser',
            'vivobrowser'     => 'vivo-browser',
            'bingweb'         => 'bingweb',
            '1passwordthumbs' => '1passwordthumbs',
            '1password'       => '1password',
            'klar/'           => 'firefox klar',
            'eui browser'     => 'eui browser',
            'slimboat'        => 'slimboat',
            'yandexsearch'    => 'yandexsearch',
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
            'cybeye'           => 'cybeye',
            'rebelmouse'       => 'rebelmouse',
            'seamonkey'        => 'seamonkey',
            'jobboerse'        => 'jobboerse bot',
            'navigator'        => 'netscape navigator',
            'tob'              => 't-online browser',
            't-online browser' => 't-online browser',
            'to-browser'       => 't-online browser',
            'dt-browser'       => 'dt-browser',
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
            'microsoft office protocol discovery' => 'ms opd',
            'excel '                              => 'excel',
            'excel/'                              => 'excel',
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
            'microsoft office mobile'             => 'office',
            'msoffice'                            => 'office',
            'microsoft office'                    => 'office',
            'crazy browser'                       => 'crazy browser',
            'deepnet explorer'                    => 'deepnet explorer',
            'kkman'                               => 'kkman',
            'lunascape'                           => 'lunascape',
            'sleipnir'                            => 'sleipnir',
            'smartsite httpclient'                => 'smartsite httpclient',
            'gomezagent'                          => 'gomez site monitor',
            'orangebot'                           => 'orangebot',
            'appengine-google'                    => 'google app engine',
            'crystalsemanticsbot'                 => 'crystalsemanticsbot',
            '360se'                               => '360 secure browser',
            '360ee'                               => '360 speed browser',
            '360 aphone browser'                  => '360 browser',
            'theworld'                            => 'theworld',
            'ptst'                                => 'webpagetest',
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

        $checkBeforeCentBrowser = [
            'chromium'                   => 'chromium',
            'iron'                       => 'iron',
            'midori'                     => 'midori',
            'locubot'                    => 'locubot',
            'acapbot'                    => 'acapbot',
            'deepcrawl'                  => 'deepcrawl',
            'google page speed insights' => 'google pagespeed insights',
            'web/snippet'                => 'google web snippet',
            'googlebot-mobile'           => 'googlebot-mobile',
            'google wireless transcoder' => 'google wireless transcoder',
            'com.google.googleplus'      => 'google+ app',
            'google-http-java-client'    => 'google http client library for java',
            'googlebot-image'            => 'google image search',
            'googlebot'                  => 'googlebot',
            'viera'                      => 'smartviera',
            'nichrome'                   => 'nichrome',
            'kinza'                      => 'kinza',
            '1stbrowser'                 => '1stbrowser',
            'tenta'                      => 'tenta',
            'merchantcentricbot'         => 'merchantcentricbot',
            'appcent'                    => 'appcent',
            'commerce browser center'    => 'commerce browser center',
            'iccrawler'                  => 'iccrawler',
            'centil-schweiz webbot'      => 'centil-schweiz webbot',
        ];

        foreach ($checkBeforeCentBrowser as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if ($s->contains('cent', false) && !$s->contains('centos', false)) {
            return $this->loader->load('cent', $useragent);
        }

        $checkBeforeEdge = [
            'salam browser'                       => 'salam browser',
            'whale'                               => 'whale browser',
            'slimjet'                             => 'slimjet browser',
            'corom'                               => 'corom browser',
            'kuaiso'                              => 'kuaiso browser',
            'moatbot'                             => 'moatbot',
            'socialradarbot'                      => 'socialradar bot',
            'infegyatlas'                         => 'infegyatlas',
            'infegy'                              => 'infegy bot',
            'google keyword suggestion'           => 'google keyword suggestion',
            'google web preview'                  => 'google web preview',
            'google-adwords-displayads-webrender' => 'google adwords displayads webrender',
            'hubspot marketing grader'            => 'hubspot marketing grader',
            'hubspot webcrawler'                  => 'hubspot webcrawler',
            'rockmelt'                            => 'rockmelt',
            ' se '                                => 'sogou explorer',
            'archivebot'                          => 'archivebot',
            'word'                                => 'word',
        ];

        foreach ($checkBeforeEdge as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if ($s->contains('edge', false) && null !== $platform && 'Windows Phone OS' === $platform->getName()) {
            return $this->loader->load('edge mobile', $useragent);
        }

        $checkBeforeWire = [
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
        ];

        foreach ($checkBeforeWire as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if ($s->contains('wire', false) && !$s->containsAny(['wired', 'wireless'], false)) {
            return $this->loader->load('wire app', $useragent);
        }

        $checkBeforeDragon = [
            'qupzilla'   => 'qupzilla',
            'ur browser' => 'ur-browser',
            'urbrowser'  => 'ur-browser',
            ' ur/'       => 'ur-browser',
        ];

        foreach ($checkBeforeDragon as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if (preg_match('/chrome\/(\d+)\.(\d+)/i', $useragent, $matches)
            && isset($matches[1], $matches[2])
            && 1 <= $matches[1]
            && 0 < $matches[2]
            && 10 >= $matches[2]
        ) {
            return $this->loader->load('dragon', $useragent);
        }

        $checkBeforeAndroidWebkit = [
            'flock'                       => 'flock',
            'crosswalk'                   => 'crosswalk',
            'bromium safari'              => 'vsentry',
            'domain.com'                  => 'pagepeeker screenshot maker',
            'pagepeeker'                  => 'pagepeeker',
            'bitdefendersafepay'          => 'bitdefender safepay',
            'stormcrawler'                => 'stormcrawler',
            'whatsapp'                    => 'whatsapp',
            'basecamp3'                   => 'basecamp3',
            'bobrowser'                   => 'bobrowser',
            'headlesschrome'              => 'headless-chrome',
            'crios'                       => 'chrome for ios',
            'chrome'                      => 'chrome',
            'crmo'                        => 'chrome',
            'dolphin http client'         => 'dolphin smalltalk http client',
            'dolfin'                      => 'dolfin',
            'dolphin'                     => 'dolfin',
            'arora'                       => 'arora',
            'com.douban.group'            => 'douban app',
            'com.apple.Notes'             => 'apple notes app',
            'ovibrowser'                  => 'nokia proxy browser',
            'ibrowser'                    => 'ibrowser',
            'onebrowser'                  => 'onebrowser',
            'baiduspider-image'           => 'baidu image search',
            'baiduspider'                 => 'baiduspider',
            'http://www.baidu.com/search' => 'baidu mobile search',
            'yjapp'                       => 'yahoo! app',
            'yjtop'                       => 'yahoo! app',
            'ninesky'                     => 'ninesky-browser',
            'listia'                      => 'listia',
            'aldiko'                      => 'aldiko',
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
            'webos'                  => 'webkit/webos',
            'wosbrowser'             => 'webkit/webos',
            'wossystem'              => 'webkit/webos',
            'omniweb'                => 'omniweb',
            'windows phone search'   => 'windows phone search',
            'windows-update-agent'   => 'windows-update-agent',
            'classilla'              => 'classilla',
            'nokia'                  => 'nokiabrowser',
            'twitter for i'          => 'twitter app',
            'twitterbot'             => 'twitterbot',
            'quicktime'              => 'quicktime',
            'qtweb internet browser' => 'qtweb internet browser',
            'qtcarbrowser'           => 'model s browser',
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
            'msnbot-media'                    => 'msnbot-media',
            'adidxbot'                        => 'adidxbot',
            'msnbot'                          => 'bingbot',
            'playbook'                        => 'blackberry playbook tablet',
            'bb10'                            => 'blackberry',
            'blackberry'                      => 'blackberry',
            'wetab-browser'                   => 'wetab browser',
            'profiller'                       => 'profiller',
            'wkhtmltopdf'                     => 'wkhtmltopdf',
            'wkhtmltoimage'                   => 'wkhtmltoimage',
            'wp-iphone'                       => 'wordpress app',
            'wp-android'                      => 'wordpress app',
            'oktamobile'                      => 'okta mobile app',
            'kmail2'                          => 'kmail2',
            'eb-iphone'                       => 'eb iphone/ipad app',
            'elmediaplayer'                   => 'elmedia player',
            'dreamweaver'                     => 'dreamweaver',
            'akregator'                       => 'akregator',
            'installatron'                    => 'installatron',
            'quora link preview'              => 'quora link preview bot',
            'quora'                           => 'quora app',
            'rocky chatwork mobile'           => 'rocky chatwork mobile',
            'adsbot-google-mobile'            => 'adsbot google-mobile',
            'epiphany'                        => 'epiphany',
            'rekonq'                          => 'rekonq',
            'skyfire'                         => 'skyfire',
            'flixsterios'                     => 'flixster app',
            'adbeat_bot'                      => 'adbeat bot',
            'adbeat.com'                      => 'adbeat bot',
            'secondlife'                      => 'second live client',
            'second life'                     => 'second live client',
            'salesforce1'                     => 'salesforce app',
            'salesforcetouchcontainer'        => 'salesforce app',
            'nagios-plugins'                  => 'nagios',
            'check_http'                      => 'nagios',
            'bingbot'                         => 'bingbot',
            'mediapartners-google'            => 'adsense bot',
            'smtbot'                          => 'smtbot',
            'diigobrowser'                    => 'diigo browser',
            'kontact'                         => 'kontact',
            'fxios'                           => 'firefox for ios',
            'qutebrowser'                     => 'qutebrowser',
            'otter'                           => 'otter',
            'palemoon'                        => 'palemoon',
            'slurp'                           => 'slurp',
            'applebot'                        => 'applebot',
            'soundcloud'                      => 'soundcloud app',
            'rival iq'                        => 'rival iq bot',
            'evernote clip resolver'          => 'evernote clip resolver',
            'evernote'                        => 'evernote app',
            'fluid'                           => 'fluid',
            'qhbrowser'                       => 'qh-browser',
            'google earth'                    => 'google earth',
            'kded'                            => 'kded',
            'iris/'                           => 'iris',
            'online-versicherungsportal.info' => 'online-versicherungsportal.info bot',
            'versicherungssuchmaschine.net'   => 'versicherungssuchmaschine.net bot',
            'konqueror'                       => 'konqueror',
            'mythbrowser'                     => 'mythbrowser',
            'safari'                          => 'safari',
            'windows phone ad client'         => 'windows phone ad client',
            'ddg-android-'                    => 'duckduck app',
            'ddg-ios-'                        => 'duckduck app',
            'snapchat'                        => 'snapchat app',
            'grindr'                          => 'grindr',
            'readkit'                         => 'readkit',
            'xing-contenttabreceiver'         => 'xing contenttabreceiver',
            'xing'                            => 'xing app',
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
            'adobeair'        => 'adobe air',
            'easouspider'     => 'easouspider',
            'itunes'          => 'itunes',
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
            'waterfox'                                      => 'waterfox',
            'thunderbird'                                   => 'thunderbird',
            'fennec'                                        => 'fennec',
            'myibrow'                                       => 'my internet browser',
            'daumoa'                                        => 'daumoa',
            'unister-test'                                  => 'unistertesting',
            'unistertesting'                                => 'unistertesting',
            'unister-https-test'                            => 'unistertesting',
            'iceweasel'                                     => 'iceweasel',
            'icecat'                                        => 'icecat',
            'iceape'                                        => 'iceape',
            'galeon'                                        => 'galeon',
            'surveybot'                                     => 'surveybot',
            'aggregator:spinn3r'                            => 'spinn3r rss aggregator',
            'tweetmemebot'                                  => 'tweetmeme bot',
            'butterfly'                                     => 'butterfly robot',
            'james bot'                                     => 'jamesbot',
            'msie or firefox mutant; not on Windows server' => 'daumoa',
            'sailfishbrowser'                               => 'sailfish browser',
            'kazehakase'                                    => 'kazehakase',
            'cometbird'                                     => 'cometbird',
            'camino'                                        => 'camino',
            'slimerjs'                                      => 'slimerjs',
            'multizilla'                                    => 'multizilla',
            'minimo'                                        => 'minimo',
            'microb'                                        => 'microb',
            'maemo browser'                                 => 'microb',
            'maemobrowser'                                  => 'microb',
            'k-meleon'                                      => 'k-meleon',
            'k-ninja'                                       => 'k-ninja',
            'curb'                                          => 'curb',
            'link_thumbnailer'                              => 'link_thumbnailer',
            'mechanize'                                     => 'mechanize',
            'ruby'                                          => 'generic ruby crawler',
            'googleimageproxy'                              => 'google image proxy',
            'dalvik'                                        => 'dalvik',
            'bb_work_connect'                               => 'bb work connect',
            'lolifox'                                       => 'lolifox',
            'cyberfox'                                      => 'cyberfox',
            'webmoney advisor'                              => 'webmoney advisor',
            'firefox'                                       => 'firefox',
            'minefield'                                     => 'firefox',
            'shiretoko'                                     => 'firefox',
            'bonecho'                                       => 'firefox',
            'namoroka'                                      => 'firefox',
            'gvfs'                                          => 'gvfs',
            'luakit'                                        => 'luakit',
            'playstation 3'                                 => 'netfront',
            'sistrix'                                       => 'sistrix crawler',
            'ezooms'                                        => 'ezooms',
            'grapefx'                                       => 'grapefx',
            'grapeshotcrawler'                              => 'grapeshotcrawler',
            'mail.ru'                                       => 'mail.ru',
            'proximic'                                      => 'proximic',
            'polaris'                                       => 'polaris',
            'another web mining tool'                       => 'another web mining tool',
            'awmt'                                          => 'another web mining tool',
            'wbsearchbot'                                   => 'wbsearchbot',
            'wbsrch'                                        => 'wbsearchbot',
            'typo3-linkvalidator'                           => 'typo3 linkvalidator',
            'typo3'                                         => 'typo3',
            'feeddlerrss'                                   => 'feeddler rss reader',
        ];

        foreach ($checkBeforeIos as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if (preg_match('/^mozilla\/5\.0 \((iphone|ipad|ipod).*CPU like Mac OS X.*\) AppleWebKit\/\d+/i', $useragent)) {
            return $this->loader->load('safari', $useragent);
        }

        $checkLastUiwebview = [
            'ios'    => 'mobile safari uiwebview',
            'iphone' => 'mobile safari uiwebview',
            'ipad'   => 'mobile safari uiwebview',
            'ipod'   => 'mobile safari uiwebview',
        ];

        foreach ($checkLastUiwebview as $search => $key) {
            if (!$s->contains('windows', false) && $s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        $checkBeforeMosbookmarks = [
            'paperlibot'                          => 'paper.li bot',
            'spbot'                               => 'seoprofiler',
            'dotbot'                              => 'dotbot',
            'google-structureddatatestingtool'    => 'google structured-data testingtool',
            'google-structured-data-testing-tool' => 'google structured-data testingtool',
            'webmastercoffee'                     => 'webmastercoffee',
            'ahrefs'                              => 'ahrefsbot',
            'apercite'                            => 'apercite',
            'woobot'                              => 'woobot',
            'scoutjet'                            => 'scoutjet',
            'blekkobot'                           => 'blekkobot',
            'pagesinventory'                      => 'pagesinventory bot',
            'slackbot-linkexpanding'              => 'slackbot-link-expanding',
            'slackbot'                            => 'slackbot',
            'seokicks-robot'                      => 'seokicks robot',
            'alexabot'                            => 'alexabot',
            'exabot'                              => 'exabot',
            'domainscan'                          => 'domainscan server monitoring',
            'jobroboter'                          => 'jobroboter',
            'acoonbot'                            => 'acoonbot',
            'woriobot'                            => 'woriobot',
            'monobot'                             => 'monobot',
            'domainsigmacrawler'                  => 'domainsigmacrawler',
            'bnf.fr_bot'                          => 'bnf.fr bot',
            'crawlrobot'                          => 'crawlrobot',
            'addthis.com robot'                   => 'addthis.com robot',
            'yeti'                                => 'naverbot',
            'naver.com/robots'                    => 'naverbot',
            'robots'                              => 'testcrawler',
            'deusu'                               => 'werbefreie deutsche suchmaschine',
            'obot'                                => 'obot',
            'zumbot'                              => 'zumbot',
            'umbot'                               => 'umbot',
            'picmole'                             => 'picmole bot',
            'zollard'                             => 'zollard worm',
            'fhscan core'                         => 'fhscan core',
            'com.linkedin'                        => 'linkedinbot',
            'linkedinbot'                         => 'linkedinbot',
            'nbot'                                => 'nbot',
            'loadtimebot'                         => 'loadtimebot',
            'scrubby'                             => 'scrubby',
            'squzer'                              => 'squzer',
            'piplbot'                             => 'piplbot',
            'everyonesocialbot'                   => 'everyonesocialbot',
            'aolbot'                              => 'aolbot',
            'glbot'                               => 'glbot',
            'sslbot'                              => 'sslbot',
            'lbot'                                => 'lbot',
            'blexbot'                             => 'blexbot',
            'synapse'                             => 'apache synapse',
            'linkdexbot'                          => 'linkdex bot',
            'coccoc'                              => 'coccoc bot',
            'siteexplorer'                        => 'siteexplorer',
            'semrushbot'                          => 'semrushbot',
            'istellabot'                          => 'istellabot',
            'meanpathbot'                         => 'meanpathbot',
            'xml sitemaps generator'              => 'xml sitemaps generator',
            'urlappendbot'                        => 'urlappendbot',
            'netseer crawler'                     => 'netseer crawler',
            'add catalog'                         => 'add catalog',
            'moreover'                            => 'moreover',
            'linkpadbot'                          => 'linkpadbot',
            'lipperhey seo service'               => 'lipperhey seo service',
            'blog search'                         => 'blog search',
            'qualidator.com bot'                  => 'qualidator.com bot',
            'fr-crawler'                          => 'fr-crawler',
            'ca-crawler'                          => 'ca-crawler',
            'website thumbnail generator'         => 'website thumbnail generator',
            'webthumb'                            => 'webthumb',
            'komodiabot'                          => 'komodiabot',
            'grouphigh'                           => 'grouphigh bot',
            'theoldreader'                        => 'the old reader',
            'google-site-verification'            => 'google-site-verification',
            'prlog'                               => 'prlog',
            'cms crawler'                         => 'cms crawler',
            'pmoz.info odp link checker'          => 'pmoz.info odp link checker',
            'twingly recon'                       => 'twingly recon',
            'embedly'                             => 'embedly',
            'alexa site audit'                    => 'alexa site audit',
            'mj12bot'                             => 'mj12bot',
            'httrack'                             => 'httrack',
            'unisterbot'                          => 'unisterbot',
            'careerbot'                           => 'careerbot',
            '80legs'                              => '80legs',
            '80bot'                               => '80legs',
            'wada.vn'                             => 'wada.vn search bot',
            'lynx'                                => 'lynx',
            'nx'                                  => 'netfront nx',
            'wiiu'                                => 'netfront nx',
            'nintendo 3ds'                        => 'netfront nx',
            'netfront'                            => 'netfront',
            'playstation 4'                       => 'netfront',
            'xovibot'                             => 'xovibot',
            '007ac9 crawler'                      => '007ac9 crawler',
            '200pleasebot'                        => '200pleasebot',
            'abonti'                              => 'abonti websearch',
            'publiclibraryarchive'                => 'publiclibraryarchive bot',
            'pad-bot'                             => 'pad-bot',
            'softlistbot'                         => 'softlistbot',
            'sreleasebot'                         => 'sreleasebot',
            'vagabondo'                           => 'vagabondo',
            'special_archiver'                    => 'internet archive special archiver',
            'optimizer'                           => 'optimizer bot',
            'sophora linkchecker'                 => 'sophora linkchecker',
            'seodiver'                            => 'seodiver bot',
            'itsscan'                             => 'itsscan',
            'google desktop'                      => 'google desktop',
            'lotus-notes'                         => 'lotus notes',
            'askpeterbot'                         => 'askpeterbot',
            'discoverybot'                        => 'discovery bot',
            'yandexbot'                           => 'yandexbot',
            'yandeximages'                        => 'yandeximages',
        ];

        foreach ($checkBeforeMosbookmarks as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if ($s->containsAll(['mosbookmarks', 'link checker'], false)) {
            return $this->loader->load('mosbookmarks link checker', $useragent);
        }

        $checkBeforeOpenwaveBrowser = [
            'mosbookmarks'                 => 'mosbookmarks',
            'webmasteraid'                 => 'webmasteraid',
            'aboutusbot johnny5'           => 'aboutus bot johnny5',
            'aboutusbot'                   => 'aboutus bot',
            'semantic-visions.com crawler' => 'semantic-visions.com crawler',
            'waybackarchive.org'           => 'wayback archive bot',
            'openvas'                      => 'open vulnerability assessment system',
            'mixrankbot'                   => 'mixrankbot',
            'mojeekbot'                    => 'mojeekbot',
            'memorybot'                    => 'memorybot',
            'domainappender'               => 'domainappender bot',
            'gidbot'                       => 'gidbot',
            'wap browser/maui'             => 'maui wap browser',
            'discovered'                   => 'discovered',
            'gosquared-thumbnailer'        => 'gosquared-thumbnailer',
            'pycurl'                       => 'pycurl',
            'libcurl-agent'                => 'libcurl',
            'taproot'                      => 'taproot bot',
            'guzzlehttp'                   => 'guzzle http client',
            'php-curl-class'               => 'php-curl-class',
            'curl'                         => 'curl',
            'red'                          => 'redbot',
            'dbot'                         => 'dbot',
            'pwbot'                        => 'pwbot',
            '+5bot'                        => 'plus5bot',
            'wasalive-bot'                 => 'wasalive bot',
            'openhosebot'                  => 'openhosebot',
            'urlfilterdb-crawler'          => 'urlfilterdb crawler',
            'metager2-verification-bot'    => 'metager2-verification-bot',
            'powermarks'                   => 'powermarks',
            'cloudflare-alwaysonline'      => 'cloudflare alwaysonline',
            'phantom.js bot'               => 'phantom.js bot',
            'phantom'                      => 'phantom browser',
            'shrook'                       => 'shrook',
            'netestate ne crawler'         => 'netestate ne crawler',
            'garlikcrawler'                => 'garlikcrawler',
            'metageneratorcrawler'         => 'metageneratorcrawler',
            'screenerbot'                  => 'screenerbot',
            'webtarantula.com crawler'     => 'webtarantula',
            'backlinkcrawler'              => 'backlinkcrawler',
            'linkscrawler'                 => 'linkscrawler',
            'ssearch_bot'                  => 'ssearch crawler',
            'ssearch crawler'              => 'ssearch crawler',
            'hrcrawler'                    => 'hrcrawler',
            'icc-crawler'                  => 'icc-crawler',
            'arachnida web crawler'        => 'arachnida web crawler',
            'finderlein research crawler'  => 'finderlein research crawler',
            'testcrawler'                  => 'testcrawler',
            'scopia crawler'               => 'scopia crawler',
            'metajobbot'                   => 'metajobbot',
            'lucidworks'                   => 'lucidworks bot',
            'pub-crawler'                  => 'pub-crawler',
            'archive.org.ua crawler'       => 'internet archive',
            'digincore bot'                => 'digincore bot',
            'steeler'                      => 'steeler',
            'electricmonk'                 => 'duedil crawler',
            'virtuoso'                     => 'virtuoso',
            'aboundex'                     => 'aboundexbot',
            'r6_commentreader'             => 'r6 commentreader',
            'r6_feedfetcher'               => 'r6 feedfetcher',
            'crazywebcrawler'              => 'crazywebcrawler',
            'fast-webcrawler'              => 'fast webcrawler',
            'crawler4j'                    => 'crawler4j',
            'ichiro/mobile'                => 'ichiro mobile bot',
            'ichiro'                       => 'ichiro bot',
            'tineye-bot'                   => 'tineye bot',
            'livelapbot'                   => 'livelap crawler',
            'safesearch microdata crawler' => 'safesearch microdata crawler',
            'fastbot crawler'              => 'fastbot crawler',
            'camcrawler'                   => 'camcrawler',
            'domaincrawler'                => 'domaincrawler',
            'pagefreezer'                  => 'pagefreezer',
            'showyoubot'                   => 'showyoubot',
            'y!j-asr'                      => 'yahoo! japan',
            'y!j-bsc'                      => 'yahoo! japan',
            'rogerbot'                     => 'rogerbot',
            'commoncrawler node'           => 'commoncrawler node',
            'adcrawler'                    => 'adcrawler',
            'contacts crawler'             => 'contacts crawler',
            'vorboss web crawler'          => 'vorboss web crawler',
            'crawler'                      => 'crawler',
            'jig browser web'              => 'jig browser web',
            't-h-u-n-d-e-r-s-t-o-n-e'      => 'texis webscript',
            'focuseekbot'                  => 'focuseekbot',
            'vbseo'                        => 'vbulletin seo bot',
            'kgbody'                       => 'kgbody',
            'jobdiggerspider'              => 'jobdiggerspider',
            'imrbot'                       => 'mignify bot',
            'kulturarw3'                   => 'kulturarw3',
            'nett.io bot'                  => 'nett.io bot',
            'semanticbot'                  => 'semanticbot',
            'tweetedtimes'                 => 'tweetedtimes bot',
            'vkshare'                      => 'vkshare',
            'yahoo ad monitoring'          => 'yahoo ad monitoring',
            'yioopbot'                     => 'yioopbot',
            'zitebot'                      => 'zitebot',
            'espial'                       => 'espial tv browser',
            'sitecon'                      => 'sitecon',
            'ibooks author'                => 'ibooks author',
            'iweb'                         => 'iweb',
            'newsfire'                     => 'newsfire',
            'rmsnapkit'                    => 'rmsnapkit',
            'sandvox'                      => 'sandvox',
            'tubetv'                       => 'tubetv',
            'elluminate live'              => 'elluminate live',
            'element browser'              => 'element browser',
            'esribot'                      => 'esribot',
            'quicklook'                    => 'quicklook',
            'dillo'                        => 'dillo',
            'digg'                         => 'digg bot',
            'zetakey'                      => 'zetakey browser',
            'getprismatic.com'             => 'prismatic app',
            'foma'                         => 'sharp',
            'sh05c'                        => 'sharp',
            'openwebkitsharp'              => 'open-webkit-sharp',
            'ajaxsnapbot'                  => 'ajaxsnapbot',
            'owler'                        => 'owler bot',
            'yahoo link preview'           => 'yahoo link preview',
            'linkfluence'                  => 'kraken',
            'qwantify'                     => 'qwantify',
            'setlinks bot'                 => 'setlinks.ru crawler',
            'megaindex.ru'                 => 'megaindex bot',
            'cliqzbot'                     => 'cliqzbot',
            'dawinci antiplag spider'      => 'dawinci antiplag spider',
            'advbot'                       => 'advbot',
            'duckduckgo-favicons-bot'      => 'duckduck favicons bot',
            'duckduckbot'                  => 'duckduck bot',
            'zyborg'                       => 'wisenut search engine crawler',
            'hypercrawl'                   => 'hypercrawl',
            'worldwebheritage'             => 'worldwebheritage.org bot',
            'begunadvertising'             => 'begun advertising bot',
            'trendwinhttp'                 => 'trendwinhttp',
            'winhttp'                      => 'winhttp',
            'skypeuripreview'              => 'skypeuripreview',
            'lipperhey-kaus-australis'     => 'lipperhey kaus australis',
            'jasmine'                      => 'jasmine',
            'yoozbot'                      => 'yoozbot',
            'online-webceo-bot'            => 'webceo bot',
            'niki-bot'                     => 'niki-bot',
            'contextad bot'                => 'contextad bot',
            'integrity'                    => 'integrity',
            'masscan'                      => 'masscan',
            'zmeu'                         => 'zmeu',
            'sogou web spider'             => 'sogou web spider',
            'openwave'                     => 'openwave mobile browser',
            'up.browser'                   => 'openwave mobile browser',
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
            'teleca'                             => 'teleca-obigo',
            'obigo'                              => 'teleca-obigo',
            'au-mic'                             => 'teleca-obigo',
            'mic/'                               => 'teleca-obigo',
            'davclnt'                            => 'microsoft-webdav',
            'slingstone'                         => 'yahoo slingstone',
            'bot for jce'                        => 'bot for jce',
            'validator.nu/lv'                    => 'validator.nu/lv',
            'securepoint cf'                     => 'securepoint content filter',
            'sogou-spider'                       => 'sogou spider',
            'rankflex'                           => 'rankflex',
            'kiodia spider'                      => 'kiodia-spider',
            'domnutch'                           => 'domnutch bot',
            'nutch'                              => 'nutch',
            'boardreader favicon fetcher'        => 'boardreader favicon fetcher',
            'checksite verification agent'       => 'checksite verification agent',
            'experibot'                          => 'experibot',
            'feedblitz'                          => 'feedblitz',
            'rss2html'                           => 'rss2html',
            'feedlyapp'                          => 'feedly app',
            'genderanalyzer'                     => 'genderanalyzer',
            'gooblog'                            => 'gooblog',
            'tumblr'                             => 'tumblr app',
            'w3c_i18n-checker'                   => 'w3c i18n checker',
            'w3c_unicorn'                        => 'w3c unicorn',
            'alltop'                             => 'alltop app',
            'internetseer'                       => 'internetseer.com',
            'admantx platform semantic analyzer' => 'admantx platform semantic analyzer',
            'universalfeedparser'                => 'universalfeedparser',
            'binlar'                             => 'larbin',
            'larbin'                             => 'larbin',
            'unityplayer'                        => 'unity web player',
            'wesee:search'                       => 'wesee:search',
            'wesee:ads'                          => 'wesee:ads',
            'a6-indexer'                         => 'a6-indexer',
            'nerdybot'                           => 'nerdybot',
            'peeplo screenshot bot'              => 'peeplo screenshot bot',
            'ccbot'                              => 'ccbot',
            'visionutils'                        => 'visionutils',
            'feedly'                             => 'feedly feed fetcher',
            'photon'                             => 'photon',
            'wdg_validator'                      => 'html validator',
            'yisouspider'                        => 'yisouspider',
            'hivabot'                            => 'hivabot',
            'comodo spider'                      => 'comodo spider',
            'openwebspider'                      => 'openwebspider',
            'psbot-image'                        => 'picsearch bot',
            'psbot-page'                         => 'picsearch bot',
            'bloglovin'                          => 'bloglovin bot',
            'viralvideochart'                    => 'viralvideochart bot',
            'metaheadersbot'                     => 'metaheadersbot',
            'zendhttpclient'                     => 'zend_http_client',
            'zend_http_client'                   => 'zend_http_client',
            'zend\http\client'                   => 'zend_http_client',
            'wget'                               => 'wget',
            'scrapy'                             => 'scrapy',
            'moozilla'                           => 'moozilla',
            'antbot'                             => 'antbot',
            'browsershots'                       => 'browsershots',
            'revolt'                             => 'bot revolt',
            'pdrlabs'                            => 'pdrlabs bot',
            'elinks'                             => 'elinks',
            'linkstats bot'                      => 'linkstats bot',
            'bcklinks'                           => 'bcklinks',
            'links'                              => 'links',
            'airmail'                            => 'airmail',
            'hotmailbuzzr'                       => 'hotmailbuzzr',
            'web.de mailcheck'                   => 'web.de mailcheck',
            'screaming frog seo spider'          => 'screaming frog seo spider',
            'androiddownloadmanager'             => 'android download manager',
            'unibox'                             => 'unibox',
        ];

        foreach ($checkBeforeGoHttpClient as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if (preg_match('/go ([\d\.]+) package http/i', $useragent)) {
            return $this->loader->load('go httpclient', $useragent);
        }

        $lastBrowsers = [
            'go-http-client'                  => 'go httpclient',
            'proxy gear pro'                  => 'proxy gear pro',
            'tiny tiny rss'                   => 'tiny tiny rss',
            'readability'                     => 'readability',
            'nsplayer'                        => 'windows media player',
            'pingdom'                         => 'pingdom',
            'gg peekbot'                      => 'gg peekbot',
            'libreoffice'                     => 'libreoffice',
            'openoffice'                      => 'openoffice',
            'thumbnailagent'                  => 'thumbnailagent',
            'ez publish link validator'       => 'ez publish link validator',
            'thumbsniper'                     => 'thumbsniper',
            'stq_bot'                         => 'searchteq bot',
            'snk screenshot bot'              => 'save n keep screenshot bot',
            'okhttp'                          => 'okhttp',
            'synhttpclient'                   => 'synhttpclient',
            'eventmachine httpclient'         => 'eventmachine httpclient',
            'livedoor'                        => 'livedoor',
            'jakarta commons-httpclient'      => 'jakarta commons-httpclient',
            'httpclient'                      => 'httpclient',
            'implisensebot'                   => 'implisensebot',
            'buibui-bot'                      => 'buibui-bot',
            'thumbshots-de-bot'               => 'thumbshots-de-bot',
            'python-requests'                 => 'python-requests',
            'python-urllib'                   => 'python-urllib',
            'bot.araturka.com'                => 'bot.araturka.com',
            'http_requester'                  => 'http_requester',
            'whatweb'                         => 'whatweb web scanner',
            'isc header collector handlers'   => 'isc header collector handlers',
            'thumbor'                         => 'thumbor',
            'forum poster'                    => 'forum poster',
            'facebot'                         => 'facebot',
            'netzcheckbot'                    => 'netzcheckbot',
            'mib'                             => 'motorola internet browser',
            'facebookscraper'                 => 'facebookscraper',
            'zookabot'                        => 'zookabot',
            'metauri'                         => 'metauri bot',
            'freewebmonitoring sitechecker'   => 'freewebmonitoring sitechecker',
            'ipv4scan'                        => 'ipv4scan',
            'domainsbot'                      => 'domainsbot',
            'bubing'                          => 'bubing bot',
            'ramblermail'                     => 'ramblermail bot',
            'iisbot'                          => 'iis site analysis web crawler',
            'jooblebot'                       => 'jooblebot',
            'superfeedr bot'                  => 'superfeedr bot',
            'feedburner'                      => 'feedburner',
            'icarus6j'                        => 'icarus6j',
            'wsr-agent'                       => 'wsr-agent',
            'blogshares spiders'              => 'blogshares spiders',
            'quickiwiki'                      => 'quickiwiki bot',
            'facebookexternalhit'             => 'facebookexternalhit',
            'ror sitemap generator'           => 'ror sitemap generator',
            'sitemap generator'               => 'sitemap generator',
            'embed php library'               => 'embed php library',
            'toquo.es'                        => 'toquo.es-bot',
            'php'                             => 'php',
            'apple-pubsub'                    => 'apple pubsub',
            'simplepie'                       => 'simplepie',
            'bigbozz'                         => 'bigbozz - financial search',
            'eccp'                            => 'eccp',
            'gigablastopensource'             => 'gigablast search engine',
            'webindex'                        => 'webindex',
            'prince'                          => 'prince',
            'adsense-snapshot-google'         => 'adsense snapshot bot',
            'amazon cloudfront'               => 'amazon cloudfront',
            'bandscraper'                     => 'bandscraper',
            'bitlybot'                        => 'bitlybot',
            'cars-app-browser'                => 'cars-app-browser',
            'coursera-mobile'                 => 'coursera mobile app',
            'crowsnest'                       => 'crowsnest mobile app',
            'dorado wap-browser'              => 'dorado wap browser',
            'goldfire server'                 => 'goldfire server',
            'iball'                           => 'iball',
            'inagist url resolver'            => 'inagist url resolver',
            'jeode'                           => 'jeode',
            'kraken'                          => 'krakenjs',
            'mixbot'                          => 'mixbot',
            'busecurityproject'               => 'busecurityproject',
            'restify'                         => 'restify',
            'vlc'                             => 'vlc media player',
            'webringchecker'                  => 'webringchecker',
            'bot-pge.chlooe.com'              => 'chlooe bot',
            'seebot'                          => 'seebot',
            'ltx71'                           => 'ltx71 bot',
            'cookiereports'                   => 'cookie reports bot',
            'elmer'                           => 'elmer',
            'iframely'                        => 'iframely bot',
            'metainspector'                   => 'metainspector',
            'microsoft-cryptoapi'             => 'microsoft cryptoapi',
            'microsoft url control'           => 'microsoft url control',
            'microsoft data access internet publishing provider dav'           => 'microsoft data access internet publishing provider dav',
            'owasp_secret_browser'            => 'owasp_secret_browser',
            'smrf url expander'               => 'smrf url expander',
            'speedyspider'                    => 'speedy spider',
            'speedy spider'                   => 'speedy spider',
            'speedy_spider'                   => 'speedy spider',
            'superarama.com - bot'            => 'superarama.com - bot',
            'wnmbot'                          => 'wnmbot',
            'website explorer'                => 'website explorer',
            'city-map screenshot service'     => 'city-map screenshot service',
            'optivo(r) nethelper'             => 'optivo nethelper',
            'pr-cy.ru screenshot bot'         => 'screenshot bot',
            'cyberduck'                       => 'cyberduck',
            'accserver'                       => 'accserver',
            'izsearch'                        => 'izsearch bot',
            'netlyzer fastprobe'              => 'netlyzer fastprobe',
            'mnogosearch'                     => 'mnogosearch',
            'uipbot'                          => 'uipbot',
            'mbot'                            => 'mbot',
            'ms web services client protocol' => '.net framework clr',
            'atomicbrowser'                   => 'atomic browser',
            'atomiclite'                      => 'atomic browser lite',
            'feedfetcher-google'              => 'google feedfetcher',
            'perfect%20browser'               => 'perfect browser',
            'reeder'                          => 'reeder',
            'fastbrowser'                     => 'fastbrowser',
            'test certificate info'           => 'test certificate info',
            'riddler'                         => 'riddler',
            'sophosupdatemanager'             => 'sophosupdatemanager',
            'debian apt-http'                 => 'apt http transport',
            'ubuntu apt-http'                 => 'apt http transport',
            'urlgrabber'                      => 'url grabber',
            'w3c-checklink'                   => 'w3c-checklink',
            'libwww-perl'                     => 'libwww',
            'openbsd ftp'                     => 'openbsd ftp',
            'sophosagent'                     => 'sophosagent',
            'jupdate'                         => 'jupdate',
            'roku/dvp'                        => 'roku dvp',
            'safeassign'                      => 'safeassign',
            'exaleadcloudview'                => 'exalead cloudview',
            'typhoeus'                        => 'typhoeus',
            'camo asset proxy'                => 'camo asset proxy',
            'yahoocachesystem'                => 'yahoocachesystem',
            'wmtips.com'                      => 'webmaster tips bot',
            'brokenlinkcheck.com'             => 'brokenlinkcheck',
            'linkcheck'                       => 'linkcheck',
            'abrowse'                         => 'abrowse',
            'gwpimages'                       => 'gwpimages',
            'notetextview'                    => 'notetextview',
            'yourls'                          => 'yourls',
            'lightningquail'                  => 'lightningquail',
            'ning'                            => 'ning',
            'sprinklr'                        => 'sprinklr',
            'urlchecker'                      => 'urlchecker',
            'newsme'                          => 'newsme',
            'traackr'                         => 'traackr',
            'nineconnections'                 => 'nineconnections',
            'xenu link sleuth'                => 'xenus link sleuth',
            'superagent'                      => 'superagent',
            'goose'                           => 'goose-extractor',
            'ahc'                             => 'asynchronous http client',
            'newspaper'                       => 'newspaper',
            'hatena::bookmark'                => 'hatena::bookmark',
            'easybib autocite'                => 'easybib autocite',
            'shortlinktranslate'              => 'shortlinktranslate',
            'marketing grader'                => 'marketing grader',
            'grammarly'                       => 'grammarly',
            'dispatch'                        => 'dispatch',
            'raven link checker'              => 'raven link checker',
            'http-kit'                        => 'http kit',
            'sffeedreader'                    => 'symfony rss reader',
            'twikle'                          => 'twikle bot',
            'node-fetch'                      => 'node-fetch',
            'faraday'                         => 'faraday',
            'gettor'                          => 'gettor',
            'seostats'                        => 'seostats',
            'znajdzfoto/image'                => 'znajdzfoto/imagebot',
            'infox-wisg'                      => 'infox-wisg',
            'wscheck.com'                     => 'wscheck bot',
            'tweetminster'                    => 'tweetminster bot',
            'astute srm'                      => 'astute social',
            'longurl api'                     => 'longurl bot',
            'trove'                           => 'trove bot',
            'melvil favicon'                  => 'melvil favicon bot',
            'melvil'                          => 'melvil bot',
            'pearltrees'                      => 'pearltrees bot',
            'svven-summarizer'                => 'svven summarizer bot',
            'athena site analyzer'            => 'athena site analyzer',
            'exploratodo'                     => 'exploratodo bot',
            'webcorp'                         => 'webcorp',
            'auditmypc webmaster tool'        => 'auditmypc webmaster tool',
            'xmlsitemapgenerator'             => 'xmlsitemapgenerator',
            'stratagems kumo'                 => 'stratagems kumo',
            'spip'                            => 'spip',
            'friendica'                       => 'friendica',
            'magpierss'                       => 'magpierss',
            'short url checker'               => 'short url checker',
            'webnumbrfetcher'                 => 'webnumbr fetcher',
            'wap browser'                     => 'wap browser',
            'spice qt-75'                     => 'wap browser',
            'kkt20/midp'                      => 'wap browser',
            'yacybot'                         => 'yacybot',
            'java'                            => 'java',
            'argclrint'                       => 'argclrint',
            'blitzbot'                        => 'blitzbot',
            'charlotte'                       => 'charlotte',
            'firebird'                        => 'firebird',
            'heritrix'                        => 'heritrix',
            'iceowl'                          => 'iceowl',
            'icedove'                         => 'icedove',
            'archive-de.com'                  => 'archive-de.com',
            'socialcast'                      => 'socialcast bot',
            'cloudinary'                      => 'cloudinary',
            'evc-batch'                       => 'evc-batch',
            'researchbot'                     => 'research-bot',
            'intelligentsearchassistant'      => 'intelligent-search-assistant',
            'doccheckbot'                     => 'doccheckbot',
            'rankactivelinkbot'               => 'rankactivelinkbot',
            'lippershey'                      => 'lippershey',
            'boxee'                           => 'boxee',
            'webianshell'                     => 'webianshell',
            'nightingale'                     => 'nightingale',
            'sundance'                        => 'sundance',
            'ucrawlr'                         => 'ucrawlr',
            'mozilla'                         => 'mozilla',
            'goog'                            => 'googlebot',
            'fetchstream'                     => 'fetch-stream',
            'autoit'                          => 'autoit',
            'atvoice'                         => 'atvoice',
            'rankingbot2'                     => 'rankingbot2',
            'pcore-http'                      => 'pcore-http',
            'gloomarbot'                      => 'gloomarbot',
            'booglebot'                       => 'booglebot',
            'orbiter'                         => 'orbiter',
            'generic site loader'             => 'generic site loader',
        ];

        foreach ($lastBrowsers as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('unknown', $useragent);
    }
}
