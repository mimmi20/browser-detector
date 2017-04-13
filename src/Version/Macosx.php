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
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Macosx implements VersionCacheFactoryInterface
{
    /**
     * returns the version of the operating system/platform
     *
     * @param string $useragent
     *
     * @return \BrowserDetector\Version\Version
     */
    public function detectVersion($useragent)
    {
        $detectedVersion = VersionFactory::detectVersion(
            $useragent,
            ['Mac OS X Version', 'Mac OS X v', 'Mac OS X', 'OS X', 'os=mac ']
        );

        if ($detectedVersion->getVersion(VersionInterface::IGNORE_MINOR) > 999) {
            $versions = [];
            $found    = preg_match('/(\d\d)(\d)(\d)/', $detectedVersion->getVersion(VersionInterface::IGNORE_MINOR), $versions);

            if ($found) {
                return VersionFactory::set($versions[1] . '.' . $versions[2] . '.' . $versions[3]);
            }
        }

        if ($detectedVersion->getVersion(VersionInterface::IGNORE_MINOR) > 99) {
            $versions = [];
            $found    = preg_match('/(\d\d)(\d)/', $detectedVersion->getVersion(VersionInterface::IGNORE_MINOR), $versions);

            if ($found) {
                return VersionFactory::set($versions[1] . '.' . $versions[2]);
            }
        }

        return $detectedVersion;
    }
}
