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

final class Safari implements VersionDetectorInterface
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

        preg_match('/(?:Version|Safari)\/(?P<version>[\d\.]+)/', $useragent, $matches);

        if (array_key_exists('version', $matches)) {
            $safariHelper = new SafariHelper();
            $version      = (new VersionFactory())->set($matches['version']);

            return (new VersionFactory())->set($safariHelper->mapSafariVersion($version));
        }

        return (new VersionFactory())->set('0');
    }
}
