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
class GeckoOrFirefoxBasedFactory implements FactoryInterface
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
        if ($s->containsAll(['firefox', 'anonym'], false)) {
            return $this->loader->load('firefox', $useragent);
        }

        $lastBrowsers = [
            'flipboardproxy'                                => 'flipboardproxy',
            'icedragon'                                     => 'icedragon',
            'tinybrowser'                                   => 'tinybrowser',
            'rebelmouse'                                    => 'rebelmouse',
            'seamonkey'                                     => 'seamonkey',
            'jobboerse'                                     => 'jobboerse bot',
            'navigator'                                     => 'netscape navigator',
            'dt-browser'                                    => 'dt-browser',
            '360spider'                                     => '360spider',
            'gomezagent'                                    => 'gomez site monitor',
            'appengine-google'                              => 'google app engine',
            'web/snippet'                                   => 'google web snippet',
            'ovibrowser'                                    => 'nokia proxy browser',
            'palemoon'                                      => 'palemoon',
            'waterfox'                                      => 'waterfox',
            'thunderbird'                                   => 'thunderbird',
            'fennec'                                        => 'fennec',
            'myibrow'                                       => 'my internet browser',
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
            'ruby'                                          => 'generic ruby crawler',
            'googleimageproxy'                              => 'google image proxy',
            'lolifox'                                       => 'lolifox',
            'cyberfox'                                      => 'cyberfox',
            'to-browser'                                    => 't-online browser',
            'tob'                                           => 't-online browser',
            'webmoney advisor'                              => 'webmoney advisor',
            'wayback save page'                             => 'wayback archive bot',
            'firefox'                                       => 'firefox',
            'minefield'                                     => 'firefox',
            'shiretoko'                                     => 'firefox',
            'bonecho'                                       => 'firefox',
            'namoroka'                                      => 'firefox',
            'xml sitemaps generator'                        => 'xml sitemaps generator',
            'webthumb'                                      => 'webthumb',
            '80legs'                                        => '80legs',
            '80bot'                                         => '80legs',
            'lightningquail'                                => 'lightningquail',
            'charlotte'                                     => 'charlotte',
            'firebird'                                      => 'firebird',
            'iceowl'                                        => 'iceowl',
            'icedove'                                       => 'icedove',
            'webianshell'                                   => 'webianshell',
            'nightingale'                                   => 'nightingale',
            'mozilla'                                       => 'mozilla',
        ];

        foreach ($lastBrowsers as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('firefox', $useragent);
    }
}
