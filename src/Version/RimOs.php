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

final class RimOs implements VersionDetectorInterface
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
        if (false !== mb_stripos($useragent, 'bb10') && false === mb_stripos($useragent, 'version')) {
            return (new VersionFactory())->set('10.0.0');
        }

        $searches = ['BlackBerry[0-9a-z]+', 'BlackBerry; [0-9a-z]+\/', 'BlackBerrySimulator'];

        if (false !== mb_stripos($useragent, 'bb10') || false === mb_stripos($useragent, 'opera')) {
            array_unshift($searches, 'Version');
        }

        return (new VersionFactory())->detectVersion($useragent, $searches);
    }
}
