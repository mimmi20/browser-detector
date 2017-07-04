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
namespace BrowserDetector\Helper;

use Stringy\Stringy;

/**
 * a helper to detect windows
 */
class Ios
{
    /**
     * @var string the user agent to handle
     */
    private $useragent = '';

    /**
     * Class Constructor
     *
     * @param string $useragent
     *
     * @return \BrowserDetector\Helper\Ios
     */
    public function __construct($useragent)
    {
        $this->useragent = $useragent;
    }

    /**
     * @return bool
     */
    public function isIos()
    {
        $s = new Stringy($this->useragent);

        if ($s->containsAny(['trident', 'windows phone', 'android', 'technipad'], false)) {
            return false;
        }

        if ($s->containsAny(['like mac os x', 'ipad', 'iphone', 'ipod', 'cpu os', 'cpu ios', 'ios;'], false)) {
            return true;
        }

        if (preg_match('/iuc ?\(/i', $this->useragent)) {
            return true;
        }

        if (preg_match('/Puffin\/[\d\.]+I(P|T)/', $this->useragent)) {
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

        if (!$s->containsAny($os, false)) {
            return false;
        }

        return true;
    }
}
