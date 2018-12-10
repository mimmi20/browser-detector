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
namespace BrowserDetector\Version;

use Stringy\Stringy;

final class WindowsPhoneOs implements VersionDetectorInterface
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
        $s = new Stringy($useragent);

        if ($s->containsAny(['xblwp7', 'zunewp7'], false)) {
            return (new VersionFactory())->set('7.5.0');
        }

        if (preg_match('/wds ([\d.]+)/i', $useragent, $matches)) {
            return (new VersionFactory())->set($matches[1]);
        }

        if ($s->contains('wpdesktop', false)) {
            if ($s->contains('windows nt 6.3', false)) {
                return (new VersionFactory())->set('8.1.0');
            }

            if ($s->contains('windows nt 6.2', false)) {
                return (new VersionFactory())->set('8.0.0');
            }

            return (new VersionFactory())->set('0');
        }

        $searches = ['Windows Phone OS', 'Windows Phone', 'Windows Mobile', 'Windows NT', 'WPOS\:'];

        return (new VersionFactory())->detectVersion($useragent, $searches);
    }
}
