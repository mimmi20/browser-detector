<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
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
 */
class WebkitFactory implements FactoryInterface
{
    private $browsers = [
        'ucbrowserhd'                                                                                                        => 'uc browser hd',
        'flyflow'                                                                                                            => 'flyflow',
        'baidubrowser'                                                                                                       => 'baidu browser',
        'bdbrowserhd'                                                                                                        => 'baidu browser hd',
        'bdbrowser_mini'                                                                                                     => 'baidu browser mini',
        'bdbrowser'                                                                                                          => 'baidu browser',
        'opera mini'                                                                                                         => 'opera mini',
        'opios'                                                                                                              => 'opera mini',
        'bidubrowser'                                                                                                        => 'baidu browser',
        'ucbrowser'                                                                                                          => 'ucbrowser',
        'ubrowser'                                                                                                           => 'ucbrowser',
        'uc browser'                                                                                                         => 'ucbrowser',
        'ucweb'                                                                                                              => 'ucbrowser',
        'coast'                                                                                                              => 'coast',
        'icabmobile'                                                                                                         => 'icab mobile',
        'icab'                                                                                                               => 'icab',
        'phantomjs'                                                                                                          => 'phantomjs',
        'fban/messenger'                                                                                                     => 'facebook messenger app',
        'fbav'                                                                                                               => 'facebook app',
        'silk'                                                                                                               => 'silk',
        'flipboard'                                                                                                          => 'flipboard app',
        'navermatome'                                                                                                        => 'matome',
        'netfrontlifebrowser'                                                                                                => 'netfrontlifebrowser',
        'chedot'                                                                                                             => 'chedot',
        'qword'                                                                                                              => 'qword browser',
        'mxbrowser'                                                                                                          => 'maxthon',
        'maxthon'                                                                                                            => 'maxthon',
        'myie'                                                                                                               => 'maxthon',
        'superbird'                                                                                                          => 'superbird',
        'micromessenger'                                                                                                     => 'wechat app',
        'qqbrowser'                                                                                                          => 'qqbrowser',
        'pinterestbot'                                                                                                       => 'pinterest bot',
        'pinterest'                                                                                                          => 'pinterest app',
        'baiduboxapp'                                                                                                        => 'baidu box app',
        'miuibrowser'                                                                                                        => 'miui browser',
        'com.google.googlemobile'                                                                                            => 'google mobile app',
        'gsa'                                                                                                                => 'google app',
        '1passwordthumbs'                                                                                                    => '1passwordthumbs',
        '1password'                                                                                                          => '1password',
        'alohabrowser'                                                                                                       => 'aloha-browser',
        'bingweb'                                                                                                            => 'bingweb',
        'klar/'                                                                                                              => 'firefox klar',
        'focus/'                                                                                                             => 'firefox klar',
        'com.apple.mobilenotes'                                                                                              => 'apple mobilenotes',
        '/tizen.*version.*safari/i'                                                                                          => 'samsung webview',
        'iemobile'                                                                                                           => 'iemobile',
        'wpdesktop'                                                                                                          => 'iemobile',
        'zunewp7'                                                                                                            => 'iemobile',
        'xblwp7'                                                                                                             => 'iemobile',
        '360 aphone browser'                                                                                                 => '360 browser',
        '/Mozilla\/5\.0.*\(.*Trident\/8\.0.*rv\:\d+\).*/'                                                                    => 'internet explorer',
        '/Mozilla\/5\.0.*\(.*Trident\/7\.0.*\) like Gecko.*/'                                                                => 'internet explorer',
        '/Mozilla\/5\.0.*\(.*MSIE 10\.\d.*Trident\/(4|5|6|7|8)\.0.*/'                                                        => 'internet explorer',
        '/Mozilla\/(4|5)\.0.*\(.*MSIE (9|8|7|6)\.0.*/'                                                                       => 'internet explorer',
        '/Mozilla\/(4|5)\.0.*\(.*MSIE (5|4)\.\d+.*/'                                                                         => 'internet explorer',
        '/Mozilla\/\d\.\d+.*\(.*MSIE (3|2|1)\.\d+.*/'                                                                        => 'internet explorer',
        '/(?:android|mtk|maui|samsung|windows ce|symbos).*(?:opera|opr)/i'                                                   => 'opera mobile',
        '/(?:opera|opr).*(?:android|mtk|maui|samsung|windows ce|symbos)/i'                                                   => 'opera mobile',
        'iron/'                                                                                                              => 'iron',
        'opr'                                                                                                                => 'opera',
        'midori'                                                                                                             => 'midori',
        'com.google.googleplus'                                                                                              => 'google+ app',
        'googlebot'                                                                                                          => 'googlebot',
        'appcent'                                                                                                            => 'appcent',
        'schoolwires'                                                                                                        => 'schoolwires app',
        'qupzilla'                                                                                                           => 'qupzilla',
        'domain.com'                                                                                                         => 'pagepeeker screenshot maker',
        'coc_coc_browser'                                                                                                    => 'coc_coc_browser',
        'crios'                                                                                                              => 'chrome for ios',
        'dolfin'                                                                                                             => 'dolfin',
        'dolphin'                                                                                                            => 'dolfin',
        'arora'                                                                                                              => 'arora',
        'lunascape'                                                                                                          => 'lunascape',
        'com.douban.group'                                                                                                   => 'douban app',
        'com.apple.Notes'                                                                                                    => 'apple notes app',
        'ibrowser/mini'                                                                                                      => 'ibrowser mini',
        'ibrowser'                                                                                                           => 'ibrowser',
        'onebrowser'                                                                                                         => 'onebrowser',
        'http://www.baidu.com/search'                                                                                        => 'baidu mobile search',
        'yjapp'                                                                                                              => 'yahoo! app',
        'yjtop'                                                                                                              => 'yahoo! app',
        'ninesky'                                                                                                            => 'ninesky-browser',
        'listia'                                                                                                             => 'listia',
        'aldiko'                                                                                                             => 'aldiko',
        'yabrowser'                                                                                                          => 'yabrowser',
        'acheetahi'                                                                                                          => 'cm browser',
        'outlook'                                                                                                            => 'outlook',
        'newb'                                                                                                               => 'newb',
        'chromium'                                                                                                           => 'chromium',
        'surfbrowser'                                                                                                        => 'surfbrowser',
        'surf/'                                                                                                              => 'surfbrowser',
        'v1_and_sq'                                                                                                          => 'qqbrowser',
        'qvodplayerbrowser'                                                                                                  => 'qvodplayerbrowser',
        '/linux; android.*version/i'                                                                                         => 'android webkit',
        '/android[\/ ][\d\.]+ release/i'                                                                                     => 'android webkit',
        '/(?:android|mtk|maui|samsung|windows ce|symbos).*safari/i'                                                          => 'android webkit',
        'webos'                                                                                                              => 'webkit/webos',
        'wosbrowser'                                                                                                         => 'webkit/webos',
        'wossystem'                                                                                                          => 'webkit/webos',
        'omniweb'                                                                                                            => 'omniweb',
        'nokia'                                                                                                              => 'nokiabrowser',
        'twitter for i'                                                                                                      => 'twitter app',
        'twitter/'                                                                                                           => 'twitter app',
        'qtcarbrowser'                                                                                                       => 'model s browser',
        'qtweb internet browser'                                                                                             => 'qtweb internet browser',
        'boxee'                                                                                                              => 'boxee',
        '/Qt/'                                                                                                               => 'qt',
        'instagram'                                                                                                          => 'instagram app',
        'webclip'                                                                                                            => 'webclip app',
        'mercury'                                                                                                            => 'mercury',
        'worxwebappstore'                                                                                                    => 'worxwebappstore',
        'macappstore'                                                                                                        => 'macappstore',
        'appstore'                                                                                                           => 'apple appstore app',
        'webglance'                                                                                                          => 'web glance',
        'yhoo_search_app'                                                                                                    => 'yahoo mobile app',
        'newsblur feed fetcher'                                                                                              => 'newsblur feed fetcher',
        'applecoremedia'                                                                                                     => 'coremedia',
        'dataaccessd'                                                                                                        => 'ios dataaccessd',
        'hotmailbuzzr'                                                                                                       => 'hotmailbuzzr',
        'mailbuzzr%20hotmail'                                                                                                => 'hotmailbuzzr',
        'mailbar'                                                                                                            => 'mailbar',
        '/^mail/i'                                                                                                           => 'apple mail',
        '/^Mozilla\/5\.0.*\(.*(CPU iPhone OS|CPU OS) \d+(_|\.)\d+.* like Mac OS X.*\) AppleWebKit.* \(KHTML, like Gecko\)$/' => 'apple mail',
        '/^Mozilla\/5\.0 \(Macintosh; Intel Mac OS X.*\) AppleWebKit.* \(KHTML, like Gecko\)$/'                              => 'apple mail',
        '/^Mozilla\/5\.0 \(Windows.*\) AppleWebKit.* \(KHTML, like Gecko\)$/'                                                => 'apple mail',
        'msnbot-media'                                                                                                       => 'msnbot-media',
        'playbook'                                                                                                           => 'blackberry playbook tablet',
        'bb10'                                                                                                               => 'blackberry',
        'blackberry'                                                                                                         => 'blackberry',
        'wetab-browser'                                                                                                      => 'wetab browser',
        'profiller'                                                                                                          => 'profiller',
        'wkhtmltopdf'                                                                                                        => 'wkhtmltopdf',
        'wkhtmltoimage'                                                                                                      => 'wkhtmltoimage',
        'wp-iphone'                                                                                                          => 'wordpress app',
        'oktamobile'                                                                                                         => 'okta mobile app',
        'kmail2'                                                                                                             => 'kmail2',
        'eb-iphone'                                                                                                          => 'eb iphone/ipad app',
        'elmediaplayer'                                                                                                      => 'elmedia player',
        'dreamweaver'                                                                                                        => 'dreamweaver',
        'akregator'                                                                                                          => 'akregator',
        'installatron'                                                                                                       => 'installatron',
        'quora'                                                                                                              => 'quora app',
        'rocky chatwork mobile'                                                                                              => 'rocky chatwork mobile',
        'adsbot-google-mobile'                                                                                               => 'adsbot google-mobile',
        'epiphany'                                                                                                           => 'epiphany',
        'rekonq'                                                                                                             => 'rekonq',
        'skyfire'                                                                                                            => 'skyfire',
        'flixsterios'                                                                                                        => 'flixster app',
        'adbeat_bot'                                                                                                         => 'adbeat bot',
        'adbeat.com'                                                                                                         => 'adbeat bot',
        'secondlife'                                                                                                         => 'second live client',
        'second life'                                                                                                        => 'second live client',
        'salesforce1'                                                                                                        => 'salesforce app',
        'salesforcetouchcontainer'                                                                                           => 'salesforce app',
        'mediapartners-google'                                                                                               => 'adsense bot',
        'appengine-google'                                                                                                   => 'google app engine',
        'diigobrowser'                                                                                                       => 'diigo browser',
        'kontact'                                                                                                            => 'kontact',
        'fxios'                                                                                                              => 'firefox for ios',
        'qutebrowser'                                                                                                        => 'qutebrowser',
        'otter'                                                                                                              => 'otter',
        'palemoon'                                                                                                           => 'palemoon',
        'applebot'                                                                                                           => 'applebot',
        'soundcloud'                                                                                                         => 'soundcloud app',
        'rival iq'                                                                                                           => 'rival iq bot',
        'evernote'                                                                                                           => 'evernote app',
        'fluid'                                                                                                              => 'fluid',
        'qhbrowser'                                                                                                          => 'qh-browser',
        'google earth'                                                                                                       => 'google earth',
        'kded'                                                                                                               => 'kded',
        'iris/'                                                                                                              => 'iris',
        'online-versicherungsportal.info'                                                                                    => 'online-versicherungsportal.info bot',
        'versicherungssuchmaschine.net'                                                                                      => 'versicherungssuchmaschine.net bot',
        'konqueror'                                                                                                          => 'konqueror',
        'mythbrowser'                                                                                                        => 'mythbrowser',
        'puffin'                                                                                                             => 'puffin',
        'wayback save page'                                                                                                  => 'wayback archive bot',
        'sailfishbrowser'                                                                                                    => 'sailfish browser',
        'safari'                                                                                                             => 'safari',
        'snapchat'                                                                                                           => 'snapchat app',
        'grindr'                                                                                                             => 'grindr',
        'readkit'                                                                                                            => 'readkit',
        'xing'                                                                                                               => 'xing app',
        'twcan/sportsnet'                                                                                                    => 'twc sportsnet',
        'adobeair'                                                                                                           => 'adobe air',
        'itunes'                                                                                                             => 'itunes',
        'ddg-ios-'                                                                                                           => 'duckduck app',
        '/^Mozilla\/5\.0.*\((iPhone|iPad|iPod).*\).*AppleWebKit\/.*\(.*KHTML, like Gecko.*\).*Mobile.*/i'                    => 'mobile safari uiwebview',
        'dalvik'                                                                                                             => 'dalvik',
        'bb_work_connect'                                                                                                    => 'bb work connect',
        'luakit'                                                                                                             => 'luakit',
        'feeddlerrss'                                                                                                        => 'feeddler rss reader',
        '/^mozilla\/5\.0 \((iphone|ipad|ipod).*CPU like Mac OS X.*\) AppleWebKit\/\d+/i'                                     => 'safari',
        'nx'                                                                                                                 => 'netfront nx',
        'wiiu'                                                                                                               => 'netfront nx',
        'nintendo 3ds'                                                                                                       => 'netfront nx',
        'netfront'                                                                                                           => 'netfront',
        'playstation 4'                                                                                                      => 'netfront',
        'cloudflare-alwaysonline'                                                                                            => 'cloudflare alwaysonline',
        'phantom'                                                                                                            => 'phantom browser',
        'shrook'                                                                                                             => 'shrook',
        'hrcrawler'                                                                                                          => 'hrcrawler',
        'espial'                                                                                                             => 'espial tv browser',
        'sitecon'                                                                                                            => 'sitecon',
        'ibooks author'                                                                                                      => 'ibooks author',
        ' qq/'                                                                                                               => 'qqbrowser',
        'uiwebview'                                                                                                          => 'mobile safari uiwebview',
        'iweb'                                                                                                               => 'iweb',
        'newsfire'                                                                                                           => 'newsfire',
        'rmsnapkit'                                                                                                          => 'rmsnapkit',
        'sandvox'                                                                                                            => 'sandvox',
        'tubetv'                                                                                                             => 'tubetv',
        'elluminate live'                                                                                                    => 'elluminate live',
        'element browser'                                                                                                    => 'element browser',
        'quicklook'                                                                                                          => 'quicklook',
        'zetakey'                                                                                                            => 'zetakey browser',
        'getprismatic.com'                                                                                                   => 'prismatic app',
        'openwebkitsharp'                                                                                                    => 'open-webkit-sharp',
        'unibox'                                                                                                             => 'unibox',
        'atomicbrowser'                                                                                                      => 'atomic browser',
        'atomiclite'                                                                                                         => 'atomic browser lite',
        'perfect%20browser'                                                                                                  => 'perfect browser',
        'reeder'                                                                                                             => 'reeder',
        'fastbrowser'                                                                                                        => 'fastbrowser',
        'bsnbrowserlite'                                                                                                     => 'bsnbrowserlite',
        'abrowse'                                                                                                            => 'abrowse',
        'goog'                                                                                                               => 'googlebot',
        'ios'                                                                                                                => 'mobile safari uiwebview',
        'iphone'                                                                                                             => 'mobile safari uiwebview',
        'ipad'                                                                                                               => 'mobile safari uiwebview',
        'ipod'                                                                                                               => 'mobile safari uiwebview',
        'cloudflare-amp'                                                                                                     => 'cloudflare amp fetcher',
        'idownloader'                                                                                                        => 'idownloader',
        'cronomail'                                                                                                          => 'cronomail',
        'browser/'                                                                                                           => 'darwin browser',
        'siriviewservice'                                                                                                    => 'siriviewservice',
        'inboxcube'                                                                                                          => 'inboxcube',
        'atbat'                                                                                                              => 'atbat',
        'mavenplus'                                                                                                          => 'mavenplus',
        'maven'                                                                                                              => 'maven',
        'android'                                                                                                            => 'android webkit',
    ];

    /**
     * @var string
     */
    private $genericBrowser = 'safari';

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
        foreach ($this->browsers as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load($this->genericBrowser, $useragent);
    }
}
