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

class CoreMedia implements VersionCacheFactoryInterface
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
        $doMatch = preg_match('/(?:CoreMedia v|AppleCoreMedia\/)(\d+)\.(\d+)\.(\d+)/', $useragent, $matchesFirst);

        if ($doMatch) {
            return (new VersionFactory())->set($matchesFirst[1] . '.' . $matchesFirst[2] . '.' . $matchesFirst[3]);
        }

        return (new VersionFactory())->set('0');
    }
}
