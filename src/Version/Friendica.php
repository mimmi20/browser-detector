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

final class Friendica implements VersionDetectorInterface
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
        $doMatch = preg_match('/Friendica \'[^\']*\' (\d+[\d\.\_\-\+abcdehlprstv]*).*/', $useragent, $matches);

        if (!$doMatch) {
            return new Version('0');
        }

        return (new VersionFactory())->set($matches[1]);
    }
}
