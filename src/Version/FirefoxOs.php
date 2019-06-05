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

final class FirefoxOs implements VersionDetectorInterface
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
        if (!(bool) preg_match('/rv:(?P<version>\d+\.\d+)/', $useragent, $matches)) {
            return new Version('0');
        }

        $versions = [
            '44.0' => '2.5',
            '37.0' => '2.2',
            '34.0' => '2.1',
            '32.0' => '2.0',
            '30.0' => '1.4',
            '28.0' => '1.3',
            '26.0' => '1.2',
            '18.1' => '1.1',
            '18.0' => '1.0',
        ];

        foreach ($versions as $engineVersion => $osVersion) {
            if (version_compare($matches['version'], $engineVersion, '>=')) {
                return (new VersionFactory())->set($osVersion);
            }
        }

        return new Version('0');
    }
}
