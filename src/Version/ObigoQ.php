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

final class ObigoQ implements VersionDetectorInterface
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
        $doMatch = (bool) preg_match('/ObigoInternetBrowser\/QO?(?P<version>[\d.]+)/', $useragent, $matches);

        if ($doMatch) {
            return (new VersionFactory())->set($matches['version']);
        }

        $doMatch = (bool) preg_match('/obigo\-browser\/q(?P<version>[\d.]+)/i', $useragent, $matches);

        if ($doMatch) {
            return (new VersionFactory())->set($matches['version']);
        }

        $doMatch = (bool) preg_match('/(?:teleca|obigo)[\-\/]q(?P<version>[\d.]+)/i', $useragent, $matches);

        if ($doMatch) {
            return (new VersionFactory())->set($matches['version']);
        }

        return (new VersionFactory())->set('0');
    }
}
