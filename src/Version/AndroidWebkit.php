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

use BrowserDetector\Version\Helper\Safari as SafariHelper;

final class AndroidWebkit implements VersionDetectorInterface
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
        $matches = [];

        $found = preg_match('/(?:Version|Safari)\/(?P<version>[\d\.]+)/', $useragent, $matches);

        if ((bool) $found) {
            $safariHelper = new SafariHelper();
            $version      = (new VersionFactory())->set($matches['version']);

            return (new VersionFactory())->set(
                $safariHelper->mapSafariVersion($version)
            );
        }

        return (new VersionFactory())->set('0');
    }
}
