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

final class MicrosoftInternetExplorer implements VersionDetectorInterface
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
        $version = (new Trident())->detectVersion($useragent);

        $versions = [
            '8' => '11.0',
            '7' => '11.0',
            '6' => '10.0',
            '5' => '9.0',
            '4' => '8.0',
        ];

        foreach ($versions as $engineVersion => $ieVersion) {
            if (version_compare($version->getMajor(), (string) $engineVersion, '>=')) {
                return (new VersionFactory())->set($ieVersion);
            }
        }

        $doMatch = (bool) preg_match('/MSIE ([\d\.]+)/', $useragent, $matches);

        if ($doMatch) {
            return (new VersionFactory())->set($matches[1]);
        }

        return (new VersionFactory())->set('0');
    }
}
