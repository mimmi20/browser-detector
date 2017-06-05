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
class ObigoQ implements VersionCacheFactoryInterface
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
        $doMatch = preg_match('/ObigoInternetBrowser\/Q(\d+)/', $useragent, $matches);

        if ($doMatch) {
            return VersionFactory::set($matches[1]);
        }

        $doMatch = preg_match('/obigo\-browser\/q(\d+)/i', $useragent, $matches);

        if ($doMatch) {
            return VersionFactory::set($matches[1]);
        }

        $searches = [
            'Teleca\-Q',
            'Obigo\-Q',
            'Obigo\/Q',
            'Teleca\/Q',
        ];

        return VersionFactory::detectVersion($useragent, $searches);
    }
}
