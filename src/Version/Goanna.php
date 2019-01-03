<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Version;

final class Goanna implements VersionDetectorInterface
{
    /**
     * returns the version of the operating system/platform
     *
     * @param string $useragent
     *
     * @return \BrowserDetector\Version\VersionInterface
     */
    public function detectVersion(string $useragent): VersionInterface
    {
        // lastest version: version on "Goanna" token
        $doMatch = preg_match('/Goanna\/(\d{1,3}\.[\d\.]*)/', $useragent, $matchesFirst);

        if ($doMatch) {
            return (new VersionFactory())->set($matchesFirst[1]);
        }

        // second version: version on "rv:" token
        $doMatch = preg_match('/rv\:(\d\.[\d\.]*)/', $useragent, $matchesSecond);

        if ($doMatch && false !== mb_stripos($useragent, 'goanna')) {
            return (new VersionFactory())->set($matchesSecond[1]);
        }

        // first version: uses gecko version
        return (new VersionFactory())->set('1.0');
    }
}
