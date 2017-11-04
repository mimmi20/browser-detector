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
class WebkitOrKhtmlOrSafariBasedFactory implements FactoryInterface
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
        $checkBeforeWebview = [
            'ucbrowserhd'             => 'uc browser hd',
            'flyflow'                 => 'flyflow',
            'baidubrowser'            => 'baidu browser',
            'bdbrowserhd'             => 'baidu browser hd',
            'bdbrowser_mini'          => 'baidu browser mini',
            'bdbrowser'               => 'baidu browser',
            'opera mini'              => 'opera mini',
            'opios'                   => 'opera mini',
            'ucbrowser'               => 'ucbrowser',
            'ubrowser'                => 'ucbrowser',
            'uc browser'              => 'ucbrowser',
            'ucweb'                   => 'ucbrowser',
            'coast'                   => 'coast',
            'icabmobile'              => 'icab mobile',
            'icab'                    => 'icab',
            'phantomjs'               => 'phantomjs',
            'fban/messenger'          => 'facebook messenger app',
            'fbav'                    => 'facebook app',
            'silk'                    => 'silk',
            'navermatome'             => 'matome',
            'netfrontlifebrowser'     => 'netfrontlifebrowser',
            'chedot'                  => 'chedot',
            'qword'                   => 'qword browser',
            'mxbrowser'               => 'maxthon',
            'maxthon'                 => 'maxthon',
            'myie'                    => 'maxthon',
            'superbird'               => 'superbird',
            'micromessenger'          => 'wechat app',
            'qqbrowser'               => 'qqbrowser',
            'pinterest'               => 'pinterest app',
            'baiduboxapp'             => 'baidu box app',
            'miuibrowser'             => 'miui browser',
            'com.google.googlemobile' => 'google mobile app',
            'gsa'                     => 'google app',
            '1passwordthumbs'         => '1passwordthumbs',
            '1password'               => '1password',
            'bingweb'                 => 'bingweb',
            'klar/'                   => 'firefox klar',
            'com.apple.mobilenotes'   => 'apple mobilenotes',
        ];

        foreach ($checkBeforeWebview as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if ($s->containsAll(['safari', 'version', 'tizen'], false)) {
            return $this->loader->load('samsung webview', $useragent);
        }

        $checkbeforeIe = [
            'iemobile'           => 'iemobile',
            'wpdesktop'          => 'iemobile',
            'zunewp7'            => 'iemobile',
            'xblwp7'             => 'iemobile',
            '360 aphone browser' => '360 browser',
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

        $checkBeforeAndroidWebkit = [
            'midori'                      => 'midori',
            'com.google.googleplus'       => 'google+ app',
            'googlebot'                   => 'googlebot',
            'appcent'                     => 'appcent',
            'schoolwires'                 => 'schoolwires app',
            'qupzilla'                    => 'qupzilla',
            'domain.com'                  => 'pagepeeker screenshot maker',
            'crios'                       => 'chrome for ios',
            'dolfin'                      => 'dolfin',
            'dolphin'                     => 'dolfin',
            'arora'                       => 'arora',
            'com.douban.group'            => 'douban app',
            'com.apple.Notes'             => 'apple notes app',
            'ibrowser'                    => 'ibrowser',
            'onebrowser'                  => 'onebrowser',
            'http://www.baidu.com/search' => 'baidu mobile search',
            'yjapp'                       => 'yahoo! app',
            'yjtop'                       => 'yahoo! app',
            'ninesky'                     => 'ninesky-browser',
            'listia'                      => 'listia',
            'aldiko'                      => 'aldiko',
            'acheetahi'                   => 'cm browser',
            'iron'                                => 'iron',
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

        $checkBeforeQt = [
            'webos'         => 'webkit/webos',
            'wosbrowser'    => 'webkit/webos',
            'wossystem'     => 'webkit/webos',
            'omniweb'       => 'omniweb',
            'nokia'         => 'nokiabrowser',
            'twitter for i' => 'twitter app',
            'qtcarbrowser'  => 'model s browser',
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
            'worxwebappstore'       => 'worxwebappstore',
            'macappstore'           => 'macappstore',
            'appstore'              => 'apple appstore app',
            'webglance'             => 'web glance',
            'yhoo_search_app'       => 'yahoo mobile app',
            'newsblur feed fetcher' => 'newsblur feed fetcher',
            'applecoremedia'        => 'coremedia',
            'dataaccessd'           => 'ios dataaccessd',
            'hotmailbuzzr'          => 'hotmailbuzzr',
            'mailbuzzr%20hotmail'   => 'hotmailbuzzr',
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
            'playbook'                        => 'blackberry playbook tablet',
            'bb10'                            => 'blackberry',
            'blackberry'                      => 'blackberry',
            'wetab-browser'                   => 'wetab browser',
            'profiller'                       => 'profiller',
            'wkhtmltopdf'                     => 'wkhtmltopdf',
            'wkhtmltoimage'                   => 'wkhtmltoimage',
            'wp-iphone'                       => 'wordpress app',
            'oktamobile'                      => 'okta mobile app',
            'kmail2'                          => 'kmail2',
            'eb-iphone'                       => 'eb iphone/ipad app',
            'elmediaplayer'                   => 'elmedia player',
            'dreamweaver'                     => 'dreamweaver',
            'akregator'                       => 'akregator',
            'installatron'                    => 'installatron',
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
            'mediapartners-google'            => 'adsense bot',
            'diigobrowser'                    => 'diigo browser',
            'kontact'                         => 'kontact',
            'fxios'                           => 'firefox for ios',
            'qutebrowser'                     => 'qutebrowser',
            'otter'                           => 'otter',
            'palemoon'                        => 'palemoon',
            'applebot'                        => 'applebot',
            'soundcloud'                      => 'soundcloud app',
            'rival iq'                        => 'rival iq bot',
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
            'puffin'                          => 'puffin',
            'wayback save page'               => 'wayback archive bot',
            'safari'                          => 'safari',
            'snapchat'                        => 'snapchat app',
            'grindr'                          => 'grindr',
            'readkit'                         => 'readkit',
            'xing'                            => 'xing app',
        ];

        foreach ($checkBeforeSafari as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        $checkBeforeSafariUiwebview = [
            'twcan/sportsnet' => 'twc sportsnet',
            'adobeair'        => 'adobe air',
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
            'dalvik'          => 'dalvik',
            'bb_work_connect' => 'bb work connect',
            'luakit'          => 'luakit',
            'feeddlerrss'     => 'feeddler rss reader',
        ];

        foreach ($checkBeforeIos as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if (preg_match('/^mozilla\/5\.0 \((iphone|ipad|ipod).*CPU like Mac OS X.*\) AppleWebKit\/\d+/i', $useragent)) {
            return $this->loader->load('safari', $useragent);
        }

        $lastBrowsers = [
            'nx'                      => 'netfront nx',
            'wiiu'                    => 'netfront nx',
            'nintendo 3ds'            => 'netfront nx',
            'netfront'                => 'netfront',
            'playstation 4'           => 'netfront',
            'cloudflare-alwaysonline' => 'cloudflare alwaysonline',
            'phantom'                 => 'phantom browser',
            'shrook'                  => 'shrook',
            'hrcrawler'               => 'hrcrawler',
            'espial'                  => 'espial tv browser',
            'sitecon'                 => 'sitecon',
            'ibooks author'           => 'ibooks author',
            'iweb'                    => 'iweb',
            'newsfire'                => 'newsfire',
            'rmsnapkit'               => 'rmsnapkit',
            'sandvox'                 => 'sandvox',
            'tubetv'                  => 'tubetv',
            'elluminate live'         => 'elluminate live',
            'element browser'         => 'element browser',
            'quicklook'               => 'quicklook',
            'zetakey'                 => 'zetakey browser',
            'getprismatic.com'        => 'prismatic app',
            'openwebkitsharp'         => 'open-webkit-sharp',
            'unibox'                  => 'unibox',
            'atomicbrowser'           => 'atomic browser',
            'atomiclite'              => 'atomic browser lite',
            'perfect%20browser'       => 'perfect browser',
            'reeder'                  => 'reeder',
            'fastbrowser'             => 'fastbrowser',
            'bsnbrowserlite'          => 'bsnbrowserlite',
            'abrowse'                 => 'abrowse',
            'goog'                    => 'googlebot',
            'ios'                     => 'mobile safari uiwebview',
            'iphone'                  => 'mobile safari uiwebview',
            'ipad'                    => 'mobile safari uiwebview',
            'ipod'                    => 'mobile safari uiwebview',
            'cloudflare-amp'                    => 'cloudflare amp fetcher',
            'idownloader'                    => 'idownloader',
            'cronomail'                    => 'cronomail',
            'browser/'                    => 'darwin browser',
            'siriviewservice'                    => 'siriviewservice',
            'inboxcube'                    => 'inboxcube',
            'atbat'                    => 'atbat',
        ];

        foreach ($lastBrowsers as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('safari', $useragent);
    }
}
