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
class TridentOrIeBasedFactory implements FactoryInterface
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
        $lastBrowsers = [
            'avant'                                         => 'avant',
            'maxthon'                                       => 'maxthon',
            'myie'                                          => 'maxthon',
            '2345explorer'                                  => '2345 browser',
            'cybeye'                                        => 'cybeye',
            't-online browser'                              => 't-online browser',
            'to-browser'                                    => 't-online browser',
            'tob'                                           => 't-online browser',
            'marketwirebot'                                 => 'marketwirebot',
            'googletoolbar'                                 => 'google toolbar',
            'netscape'                                      => 'netscape',
            'lightspeedsystems'                             => 'lightspeed systems crawler',
            'sl commerce client'                            => 'second live commerce client',
            'iemobile'                                      => 'iemobile',
            'wpdesktop'                                     => 'iemobile',
            'zunewp7'                                       => 'iemobile',
            'xblwp7'                                        => 'iemobile',
            'bingpreview'                                   => 'bing preview',
            'haosouspider'                                  => 'haosouspider',
            'outlook-express'                               => 'outlook-express',
            'outlook'                                       => 'outlook',
            'msoffice'                                      => 'office',
            'microsoft office'                              => 'office',
            'crazy browser'                                 => 'crazy browser',
            'deepnet explorer'                              => 'deepnet explorer',
            'kkman'                                         => 'kkman',
            'lunascape'                                     => 'lunascape',
            'sleipnir'                                      => 'sleipnir',
            'smartsite httpclient'                          => 'smartsite httpclient',
            'orangebot'                                     => 'orangebot',
            'appengine-google'                              => 'google app engine',
            'crystalsemanticsbot'                           => 'crystalsemanticsbot',
            '360se'                                         => '360 secure browser',
            'theworld'                                      => 'theworld',
            'ptst'                                          => 'webpagetest',
            'mathplayer'                                    => 'mathplayer',
            'daumoa'                                        => 'daumoa',
            'msie or firefox mutant; not on Windows server' => 'daumoa',
            'foma'                                          => 'sharp',
            'sh05c'                                         => 'sharp',
            'sogou-spider'                                  => 'sogou spider',
            'simplepie'                                     => 'simplepie',
            'argclrint'                                     => 'argclrint',
            'wayback save page'                             => 'wayback archive bot',
            'savewealth'                                    => 'savewealth',
            'cobalt'                                    => 'cobalt',
        ];

        foreach ($lastBrowsers as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('internet explorer', $useragent);
    }
}
