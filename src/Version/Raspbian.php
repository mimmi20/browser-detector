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

final class Raspbian implements VersionDetectorInterface
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
        if (preg_match('/raspbian\/([\d\.]+)/i', $useragent, $matches)) {
            return (new VersionFactory())->set($matches[1]);
        }

        if (preg_match('/debian\/([\d\.]+).*rpi/i', $useragent, $matches)) {
            return (new VersionFactory())->set($matches[1]);
        }

        return (new VersionFactory())->set('0');
    }
}
