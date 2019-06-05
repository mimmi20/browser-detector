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
     * @throws \UnexpectedValueException
     *
     * @return \BrowserDetector\Version\VersionInterface
     */
    public function detectVersion(string $useragent): VersionInterface
    {
        // lastest version: version on "Goanna" token
        $doMatch = (bool) preg_match('/Goanna\/(?P<version>\d{1,3}\.[\d\.]*)/', $useragent, $matchesFirst);

        if ($doMatch) {
            return (new VersionFactory())->set($matchesFirst['version']);
        }

        // second version: version on "rv:" token
        $doMatch = (bool) preg_match('/rv\:(?P<version>\d\.[\d\.]*)/', $useragent, $matchesSecond);

        if ($doMatch && false !== mb_stripos($useragent, 'goanna')) {
            return (new VersionFactory())->set($matchesSecond['version']);
        }

        // first version: uses gecko version
        return (new VersionFactory())->set('1.0');
    }
}
