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
class MicrosoftInternetExplorer implements VersionCacheFactoryInterface
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
        $version       = (new Trident())->detectVersion($useragent);
        $engineVersion = (int) $version->getMajor();

        switch ($engineVersion) {
            case 4:
                return VersionFactory::set('8.0');
                break;
            case 5:
                return VersionFactory::set('9.0');
                break;
            case 6:
                return VersionFactory::set('10.0');
                break;
            case 7:
                return VersionFactory::set('11.0');
                break;
            default:
                //nothing to do
                break;
        }

        $doMatch = preg_match('/MSIE ([\d\.]+)/', $useragent, $matches);

        if ($doMatch) {
            return VersionFactory::set($matches[1]);
        }

        return VersionFactory::set('0');
    }
}
