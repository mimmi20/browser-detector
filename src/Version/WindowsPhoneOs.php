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

final class WindowsPhoneOs implements VersionDetectorInterface
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
        if ((bool) preg_match('/xblwp7|zunewp7/i', $useragent)) {
            return (new VersionFactory())->set('7.5.0');
        }

        if ((bool) preg_match('/wds ([\d.]+)/i', $useragent, $matches)) {
            return (new VersionFactory())->set($matches[1]);
        }

        if ((bool) preg_match('/wpdesktop/i', $useragent)) {
            if ((bool) preg_match('/windows nt 6\.3/i', $useragent)) {
                return (new VersionFactory())->set('8.1.0');
            }

            if ((bool) preg_match('/windows nt 6\.2/i', $useragent)) {
                return (new VersionFactory())->set('8.0.0');
            }

            return (new VersionFactory())->set('0');
        }

        $searches = ['Windows Phone OS', 'Windows Phone', 'Windows Mobile', 'Windows NT', 'WPOS\:'];

        return (new VersionFactory())->detectVersion($useragent, $searches);
    }
}
