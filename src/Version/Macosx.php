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

use peterkahl\OSXbuild\OSXbuild;

/**
 * @author Thomas Müller <mimmi20@live.de>
 */
class Macosx implements VersionCacheFactoryInterface
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
        $matches = [];

        $doMatch = preg_match('/\((build )?(\d+[A-Z]\d+(?:[a-z])?)\)/i', $useragent, $matches);

        if ($doMatch && isset($matches[2])) {
            $buildVersion = OSXbuild::getVersion($matches[2]);

            if (false !== $buildVersion) {
                return VersionFactory::set($buildVersion);
            }
        }

        $searches = ['Mac OS X Version', 'Mac OS X v', 'Mac OS X', 'OS X', 'os=mac '];

        return VersionFactory::detectVersion($useragent, $searches);
    }
}
