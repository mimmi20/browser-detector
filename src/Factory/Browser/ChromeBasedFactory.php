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
class ChromeBasedFactory implements FactoryInterface
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
        $checkBeforeOpera = [
//            'ucbrowserhd'      => 'uc browser hd',
//            'flyflow'          => 'flyflow',
//            'bdbrowser_i18n'   => 'baidu browser',
//            'baidubrowser'     => 'baidu browser',
            'bdbrowserhd_i18n' => 'baidu browser hd',
//            'bdbrowser_mini'   => 'baidu browser mini',
        ];

        foreach ($checkBeforeOpera as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if ($s->contains('opera mobi', false)
            || ($s->containsAny(['opera', 'opr'], false) && $s->containsAny(['android', 'mtk', 'maui', 'samsung', 'windows ce', 'symbos'], false))
        ) {
            return $this->loader->load('opera mobile', $useragent);
        }

        $checkBeforeComodoDragon = [
//            'ucbrowser'                   => 'ucbrowser',
//            'ubrowser'                    => 'ucbrowser',
//            'uc browser'                  => 'ucbrowser',
//            'ucweb'                       => 'ucbrowser',
//            'ic opengraph crawler'        => 'ibm connections',
//            'coast'                       => 'coast',
            'opr'                         => 'opera',
//            'opera'                       => 'opera',
//            'icabmobile'                  => 'icab mobile',
//            'icab'                        => 'icab',
//            'hggh phantomjs screenshoter' => 'hggh screenshot system with phantomjs',
//            'bl.uk_lddc_bot'              => 'bl.uk_lddc_bot',
//            'phantomas'                   => 'phantomas',
//            'seznam screenshot-generator' => 'seznam screenshot generator',
//            'phantomjs'                   => 'phantomjs',
            'yabrowser'                   => 'yabrowser',
            'kamelio'                     => 'kamelio app',
//            'fban/messenger'              => 'facebook messenger app',
//            'fbav'                        => 'facebook app',
            'acheetahi'                   => 'cm browser',
            'puffin'                      => 'puffin',
//            'stagefright'                 => 'stagefright',
            'oculusbrowser'               => 'oculus-browser',
            'surfbrowser'                 => 'surfbrowser',
            'surf/'                       => 'surfbrowser',
            'avirascout'                  => 'avira scout',
            'samsungbrowser'              => 'samsungbrowser',
            'silk'                        => 'silk',
            'coc_coc_browser'             => 'coc_coc_browser',
//            'navermatome'                 => 'matome',
//            'flipboardproxy'              => 'flipboardproxy',
            'flipboard'                   => 'flipboard app',
//            'seznambot'                   => 'seznambot',
            'seznam.cz'                   => 'seznam browser',
            'sznprohlizec'                => 'seznam browser',
            'aviator'                     => 'aviator',
//            'netfrontlifebrowser'         => 'netfrontlifebrowser',
//            'icedragon'                   => 'icedragon',
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
//            'chedot'          => 'chedot',
//            'qword'           => 'qword browser',
            'iridium'         => 'iridium browser',
//            'avant'           => 'avant',
            'mxnitro'         => 'maxthon nitro',
//            'mxbrowser'       => 'maxthon',
//            'maxthon'         => 'maxthon',
//            'myie'            => 'maxthon',
//            'superbird'       => 'superbird',
//            'tinybrowser'     => 'tinybrowser',
//            'micromessenger'  => 'wechat app',
//            'mqqbrowser/mini' => 'qqbrowser mini',
//            'mqqbrowser'      => 'qqbrowser',
            'qqbrowser'       => 'qqbrowser',
//            'Pinterestbot'    => 'pinterest bot',
            'pinterest'       => 'pinterest app',
//            'baiduboxapp'     => 'baidu box app',
            'wkbrowser'       => 'wkbrowser',
            'mb2345browser'   => '2345 browser',
            '2345explorer'    => '2345 browser',
            '2345chrome'      => '2345 browser',
            'sohunews'        => 'sohunews app',
            'miuibrowser'     => 'miui browser',
//            'gsa'             => 'google app',
            'alohabrowser'    => 'aloha-browser',
            'vivobrowser'     => 'vivo-browser',
            'bingweb'         => 'bingweb',
//            '1passwordthumbs' => '1passwordthumbs',
//            '1password'       => '1password',
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

        if ($s->contains('cent', false) && !$s->contains('centos', false)) {
            return $this->loader->load('cent', $useragent);
        }

        $checkBeforeWire = [
//            'windows-rss-platform'                => 'windows-rss-platform',
//            'marketwirebot'                       => 'marketwirebot',
//            'googletoolbar'                       => 'google toolbar',
//            'netscape'                            => 'netscape',
//            'lssrocketcrawler'                    => 'lightspeed systems rocketcrawler',
//            'lightspeedsystems'                   => 'lightspeed systems crawler',
//            'sl commerce client'                  => 'second live commerce client',
//            'iemobile'                            => 'iemobile',
//            'wpdesktop'                           => 'iemobile',
//            'zunewp7'                             => 'iemobile',
//            'xblwp7'                              => 'iemobile',
//            'bingpreview'                         => 'bing preview',
            'haosouspider'                        => 'haosouspider',
//            '360spider'                           => '360spider',
//            'outlook-express'                     => 'outlook-express',
//            'outlook social connector'            => 'outlook social connector',
//            'outlook'                             => 'outlook',
//            'microsoft office protocol discovery' => 'ms opd',
//            'excel '                              => 'excel',
//            'excel/'                              => 'excel',
//            'powerpoint'                          => 'powerpoint',
//            'wordpress'                           => 'wordpress',
//            'office word'                         => 'word',
//            'microsoft word'                      => 'word',
//            'office onenote'                      => 'onenote',
//            'microsoft onenote'                   => 'onenote',
//            'office visio'                        => 'visio',
//            'microsoft visio'                     => 'visio',
//            'office access'                       => 'access',
//            'microsoft access'                    => 'access',
//            'lync'                                => 'lync',
//            'office syncproc'                     => 'office syncproc',
//            'office upload center'                => 'office upload center',
//            'frontpage'                           => 'frontpage',
//            'microsoft office mobile'             => 'office',
//            'msoffice'                            => 'office',
//            'microsoft office'                    => 'office',
//            'crazy browser'                       => 'crazy browser',
//            'deepnet explorer'                    => 'deepnet explorer',
//            'kkman'                               => 'kkman',
//            'lunascape'                           => 'lunascape',
//            'sleipnir'                            => 'sleipnir',
//            'smartsite httpclient'                => 'smartsite httpclient',
//            'gomezagent'                          => 'gomez site monitor',
//            'orangebot'                           => 'orangebot',
//            'appengine-google'                    => 'google app engine',
//            'crystalsemanticsbot'                 => 'crystalsemanticsbot',
            '360se'                               => '360 secure browser',
            '360ee'                               => '360 speed browser',
//            '360 aphone browser'                  => '360 browser',
//            'theworld'                            => 'theworld',
            'ptst'                                => 'webpagetest',
            'chromium'                   => 'chromium',
            'iron'                       => 'iron',
//            'midori'                     => 'midori',
//            'locubot'                    => 'locubot',
//            'acapbot'                    => 'acapbot',
//            'deepcrawl'                  => 'deepcrawl',
            'google page speed insights' => 'google pagespeed insights',
//            'web/snippet'                => 'google web snippet',
//            'googlebot-mobile'           => 'googlebot-mobile',
            'google wireless transcoder' => 'google wireless transcoder',
//            'com.google.googleplus'      => 'google+ app',
//            'google-http-java-client'    => 'google http client library for java',
//            'googlebot-image'            => 'google image search',
//            'googlebot'                  => 'googlebot',
            'viera'                      => 'smartviera',
            'nichrome'                   => 'nichrome',
            'kinza'                      => 'kinza',
            '1stbrowser'                 => '1stbrowser',
            'tenta'                      => 'tenta',
//            'merchantcentricbot'         => 'merchantcentricbot',
//            'appcent'                    => 'appcent',
//            'commerce browser center'    => 'commerce browser center',
//            'iccrawler'                  => 'iccrawler',
//            'centil-schweiz webbot'      => 'centil-schweiz webbot',
            'salam browser'                       => 'salam browser',
            'whale'                               => 'whale browser',
            'slimjet'                             => 'slimjet browser',
            'corom'                               => 'corom browser',
            'kuaiso'                              => 'kuaiso browser',
            'moatbot'                             => 'moatbot',
//            'socialradarbot'                      => 'socialradar bot',
//            'infegyatlas'                         => 'infegyatlas',
            'infegy'                              => 'infegy bot',
            'google keyword suggestion'           => 'google keyword suggestion',
            'google web preview'                  => 'google web preview',
            'google-adwords-displayads-webrender' => 'google adwords displayads webrender',
            'hubspot marketing grader'            => 'hubspot marketing grader',
            'hubspot webcrawler'                  => 'hubspot webcrawler',
            'rockmelt'                            => 'rockmelt',
            ' se '                                => 'sogou explorer',
            'archivebot'                          => 'archivebot',
//            'word'                                => 'word',
//            'edge'        => 'edge',
            'diffbot'     => 'diffbot',
            'vivaldi'     => 'vivaldi',
            'lbbrowser'   => 'liebao',
            'amigo'       => 'amigo',
            'chromeplus'  => 'coolnovo chrome plus',
            'coolnovo'    => 'coolnovo',
            'kenshoo'     => 'kenshoo',
            'bowser'      => 'bowser',
            'asw'         => 'avast safezone',
//            'schoolwires' => 'schoolwires app',
//            'netnewswire' => 'netnewswire',
        ];

        foreach ($checkBeforeWire as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if ($s->contains('wire', false) && !$s->containsAny(['wired', 'wireless'], false)) {
            return $this->loader->load('wire app', $useragent);
        }

        if (preg_match('/chrome\/(\d+)\.(\d+)/i', $useragent, $matches)
            && isset($matches[1], $matches[2])
            && 1 <= $matches[1]
            && 0 < $matches[2]
            && 10 >= $matches[2]
        ) {
            return $this->loader->load('dragon', $useragent);
        }

        $lastBrowsers = [
            'qupzilla'   => 'qupzilla',
            'ur browser' => 'ur-browser',
            'urbrowser'  => 'ur-browser',
            ' ur/'       => 'ur-browser',
            'flock'                       => 'flock',
            'crosswalk'                   => 'crosswalk',
            'bromium safari'              => 'vsentry',
//            'domain.com'                  => 'pagepeeker screenshot maker',
            'pagepeeker'                  => 'pagepeeker',
            'bitdefendersafepay'          => 'bitdefender safepay',
            'stormcrawler'                => 'stormcrawler',
            'whatsapp'                    => 'whatsapp',
            'basecamp3'                   => 'basecamp3',
            'bobrowser'                   => 'bobrowser',
            'headlesschrome'              => 'headless-chrome',
//            'crios'                       => 'chrome for ios',
//            'chrome'                      => 'chrome',
//            'crmo'                        => 'chrome',
//            'dolphin http client'         => 'dolphin smalltalk http client',
//            'dolfin'                      => 'dolfin',
//            'dolphin'                     => 'dolfin',
//            'arora'                       => 'arora',
//            'com.douban.group'            => 'douban app',
//            'com.apple.Notes'             => 'apple notes app',
//            'ovibrowser'                  => 'nokia proxy browser',
//            'ibrowser'                    => 'ibrowser',
//            'onebrowser'                  => 'onebrowser',
//            'baiduspider-image'           => 'baidu image search',
//            'baiduspider'                 => 'baiduspider',
//            'http://www.baidu.com/search' => 'baidu mobile search',
//            'yjapp'                       => 'yahoo! app',
//            'yjtop'                       => 'yahoo! app',
//            'ninesky'                     => 'ninesky-browser',
//            'listia'                      => 'listia',
//            'aldiko'                      => 'aldiko',
        ];

        foreach ($lastBrowsers as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('chrome', $useragent);
    }
}
