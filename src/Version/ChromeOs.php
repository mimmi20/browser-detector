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
namespace BrowserDetector\Version;

/**
 * @author Thomas Müller <mimmi20@live.de>
 */
class ChromeOs implements VersionCacheFactoryInterface
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
        if (preg_match('/CrOS [a-z0-9_]+ \d\d\d\d\.\d+\.\d+\) .* Chrome\/(\d+[\d\.]+)/', $useragent, $firstMatches)) {
            return VersionFactory::set($firstMatches[1]);
        }

        if (preg_match('/CrOS [a-z0-9_]+ (\d+[\d\.]+)/', $useragent, $secondMatches)) {
            return VersionFactory::set($secondMatches[1]);
        }

        return new Version('0');
    }
}
