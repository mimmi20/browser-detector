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

final class Maxthon implements VersionDetectorInterface
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
        if (false !== mb_strpos($useragent, 'MyIE2')) {
            return (new VersionFactory())->set('2.0');
        }

        if (false !== mb_strpos($useragent, 'MyIE')) {
            $versionFactory = new VersionFactory('/^v?(?<major>\d+)(?:[-|\.](?<minor>\d+))?(?:[-|\.](?<micro>\d+))?(?:[-|\.](?<patch>\d+))?(?:[-|\.](?<micropatch>\d+))?(?:[-_.+ ]?(?<stability>rc|alpha|a|beta|b|patch|pl?|stable|dev|d)[-_.+ ]?(?<build>\d*))?.*$/i');

            return $versionFactory->detectVersion($useragent, ['MyIE']);
        }

        return (new VersionFactory())->detectVersion($useragent, ['MxBrowser\\-iPhone', 'Maxthon', 'MxBrowser', 'Version']);
    }
}
