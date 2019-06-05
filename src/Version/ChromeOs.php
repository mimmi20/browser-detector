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

final class ChromeOs implements VersionDetectorInterface
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
        if ((bool) preg_match('/(?:CrOS [a-z0-9_]+|Windows aarch64|CrOS aarch64) \d{4,5}\.\d+\.\d+\) .* Chrome\/(?P<version>\d+[\d\.]+)/', $useragent, $firstMatches)) {
            return (new VersionFactory())->set($firstMatches['version']);
        }

        if ((bool) preg_match('/CrOS [a-z0-9_]+ (?P<version>\d+[\d\.]+)/', $useragent, $secondMatches)) {
            return (new VersionFactory())->set($secondMatches['version']);
        }

        return new Version('0');
    }
}
