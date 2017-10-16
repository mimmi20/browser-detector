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
 * @author Thomas Müller <mimmi20@live.de>
 */
class ScreamingFrog implements VersionCacheFactoryInterface
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
        $doMatch = preg_match(
            '/Screaming Frog SEO Spider\/\d+,\d/',
            $useragent
        );

        if ($doMatch) {
            $useragent = str_replace(',', '.', $useragent);
        }

        return VersionFactory::detectVersion($useragent, ['Screaming Frog SEO Spider']);
    }
}
