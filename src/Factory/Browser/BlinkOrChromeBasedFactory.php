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
class BlinkOrChromeBasedFactory implements FactoryInterface
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
            'baidubrowser' => 'baidu browser',
            'bdbrowserhd'  => 'baidu browser hd',
            'bdbrowser'    => 'baidu browser',
            'miuibrowser'  => 'miui browser',
            'omi/'         => 'opera devices',
            'opera mobi'   => 'opera mobile',
        ];

        foreach ($checkBeforeOpera as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if ($s->containsAny(['opera', 'opr'], false)
            && $s->containsAny(['android', 'mtk', 'maui', 'samsung', 'windows ce', 'symbos'], false)
        ) {
            return $this->loader->load('opera mobile', $useragent);
        }

        $checkBeforeComodoDragon = [
            'opr/'            => 'opera',
            'midori'          => 'midori',
            'yabrowser'       => 'yabrowser',
            'kamelio'         => 'kamelio app',
            'acheetahi'       => 'cm browser',
            'puffin'          => 'puffin',
            'oculusbrowser'   => 'oculus-browser',
            'surfbrowser'     => 'surfbrowser',
            'surf/'           => 'surfbrowser',
            'avirascout'      => 'avira scout',
            'samsungbrowser'  => 'samsungbrowser',
            'silk'            => 'silk',
            'coc_coc_browser' => 'coc_coc_browser',
            'flipboard'       => 'flipboard app',
            'seznam.cz'       => 'seznam browser',
            'sznprohlizec'    => 'seznam browser',
            'aviator'         => 'aviator',
            'sleipnir'        => 'sleipnir',
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
            'beamrise'       => 'beamrise',
            'diglo'          => 'diglo',
            'apusbrowser'    => 'apusbrowser',
            'iridium'        => 'iridium browser',
            'mxnitro'        => 'maxthon nitro',
            'maxthon'        => 'maxthon',
            'mxbrowser'      => 'maxthon',
            'micromessenger' => 'wechat app',
            'qqbrowser'      => 'qqbrowser',
            'pinterestbot'   => 'pinterest bot',
            'pinterest'      => 'pinterest app',
            'wkbrowser'      => 'wkbrowser',
            'mb2345browser'  => '2345 browser',
            '2345explorer'   => '2345 browser',
            '2345chrome'     => '2345 browser',
            'sohunews'       => 'sohunews app',
            'alohabrowser'   => 'aloha-browser',
            'vivobrowser'    => 'vivo-browser',
            'bingweb'        => 'bingweb',
            'klar/'          => 'firefox klar',
            'focus/'         => 'firefox klar',
            'eui browser'    => 'eui browser',
            'slimboat'       => 'slimboat',
            'yandexsearch'   => 'yandexsearch',
            'fban/messenger' => 'facebook messenger app',
            'fbav'           => 'facebook app',
            'gsa'            => 'google app',
            'bidubrowser'    => 'baidu browser',
            'ucbrowser'      => 'ucbrowser',
            'ubrowser'       => 'ucbrowser',
            'uc browser'     => 'ucbrowser',
            'baiduboxapp'    => 'baidu box app',
            'liebaofast'     => 'liebao fast',
        ];

        foreach ($checkBeforeWebview as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        if ($s->containsAll(['chrome', 'version'], false)) {
            return $this->loader->load('android webview', $useragent);
        }

        if ($s->contains('cent', false) && !$s->containsAny(['centos', 'center'], false)) {
            return $this->loader->load('cent', $useragent);
        }

        if ($s->contains('iron', false) && !$s->contains('IRON', true)) {
            return $this->loader->load('iron', $useragent);
        }

        $checkBeforeWire = [
            'haosouspider'                        => 'haosouspider',
            '360se'                               => '360 secure browser',
            '360ee'                               => '360 speed browser',
            'appengine-google'                    => 'google app engine',
            'theworld'                            => 'theworld',
            'ptst'                                => 'webpagetest',
            'chromium'                            => 'chromium',
            'google page speed insights'          => 'google pagespeed insights',
            'google wireless transcoder'          => 'google wireless transcoder',
            'viera'                               => 'smartviera',
            'nichrome'                            => 'nichrome',
            'kinza'                               => 'kinza',
            '1stbrowser'                          => '1stbrowser',
            'tenta'                               => 'tenta',
            'salam browser'                       => 'salam browser',
            'whale'                               => 'whale browser',
            'slimjet'                             => 'slimjet browser',
            'corom'                               => 'corom browser',
            'kuaiso'                              => 'kuaiso browser',
            'moatbot'                             => 'moatbot',
            'infegy'                              => 'infegy bot',
            'google keyword suggestion'           => 'google keyword suggestion',
            'google web preview analytics'        => 'google web preview analytics',
            'google web preview'                  => 'google web preview',
            'google-adwords-displayads-webrender' => 'google adwords displayads webrender',
            'hubspot marketing grader'            => 'hubspot marketing grader',
            'hubspot webcrawler'                  => 'hubspot webcrawler',
            'rockmelt'                            => 'rockmelt',
            ' se '                                => 'sogou explorer',
            'archivebot'                          => 'archivebot',
            'diffbot'                             => 'diffbot',
            'vivaldi'                             => 'vivaldi',
            'lbbrowser'                           => 'liebao',
            'amigo'                               => 'amigo',
            'chromeplus'                          => 'coolnovo chrome plus',
            'coolnovo'                            => 'coolnovo',
            'kenshoo'                             => 'kenshoo',
            'bowser'                              => 'bowser',
            'asw/'                                => 'avast safezone',
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
            'qupzilla'           => 'qupzilla',
            'ur browser'         => 'ur-browser',
            'urbrowser'          => 'ur-browser',
            ' ur/'               => 'ur-browser',
            'flock'              => 'flock',
            'crosswalk'          => 'crosswalk',
            'bromium safari'     => 'vsentry',
            'pagepeeker'         => 'pagepeeker',
            'bitdefendersafepay' => 'bitdefender safepay',
            'stormcrawler'       => 'stormcrawler',
            'whatsapp'           => 'whatsapp',
            'basecamp3'          => 'basecamp3',
            'bobrowser'          => 'bobrowser',
            'headlesschrome'     => 'headless-chrome',
            'wayback save page'  => 'wayback archive bot',
            'googlebot-mobile'   => 'googlebot-mobile',
            'googlebot-image'    => 'google image search',
            'googlebot'          => 'googlebot',
            'origin'             => 'origin',
            'qtwebengine'        => 'qtwebengine',
            'chrome/'            => 'chrome',
            'chromeframe'        => 'internet explorer with chromeframe',
        ];

        foreach ($lastBrowsers as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('chrome', $useragent);
    }
}
