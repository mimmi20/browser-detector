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
namespace BrowserDetector\Helper;

use Stringy\Stringy;

/**
 * a helper to detect windows
 */
class Ios
{
    /**
     * @var \Stringy\Stringy the user agent to handle
     */
    private $useragent;

    /**
     * Class Constructor
     *
     * @param \Stringy\Stringy $useragent
     */
    public function __construct(Stringy $useragent)
    {
        $this->useragent = $useragent;
    }

    /**
     * @return bool
     */
    public function isIos(): bool
    {
        if ($this->useragent->containsAny(['trident', 'windows phone', 'android', 'technipad'], false)) {
            return false;
        }

        if ($this->useragent->containsAny(['like mac os x', 'ipad', 'iphone', 'ipod', 'cpu os', 'cpu ios', 'ios;'], false)) {
            return true;
        }

        if (preg_match('/iuc ?\(/i', (string) $this->useragent)) {
            return true;
        }

        if (preg_match('/Puffin\/[\d\.]+I(P|T)/', (string) $this->useragent)) {
            return true;
        }

        $os = [
            'antenna/',
            'antennapod',
            'rss_radio',
            'rssradio',
            'podcruncher',
            'audioboom',
            'stitcher/ios',
            'captivenetwork',
            'dataaccessd',
        ];

        if (!$this->useragent->containsAny($os, false)) {
            return false;
        }

        return true;
    }
}
