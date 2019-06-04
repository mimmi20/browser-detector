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
     * @return \BrowserDetector\Version\VersionInterface
     */
    public function detectVersion(string $useragent): VersionInterface
    {
        $safariHelper = new SafariHelper();

        $doMatch = (bool) preg_match('/(?:Version|Safari)\/([\d\.]+)/', $useragent, $matches);

        if ($doMatch) {
            return (new VersionFactory())->set($safariHelper->mapSafariVersion($matches[1]));
        }

        return new Version('0');
    }
}
