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

use Stringy\Stringy;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class WindowsPhoneOs implements VersionCacheFactoryInterface
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
        $s = new Stringy($useragent);

        if ($s->containsAny(['XBLWP7', 'ZuneWP7'])) {
            return VersionFactory::set('7.5.0');
        }

        if ($s->contains('wds 8.10')) {
            return VersionFactory::set('8.1.0');
        }

        if ($s->contains('WPDesktop')) {
            if ($s->contains('Windows NT 6.3')) {
                return VersionFactory::set('8.1.0');
            }

            if ($s->contains('Windows NT 6.2')) {
                return VersionFactory::set('8.0.0');
            }

            return VersionFactory::set('0.0.0');
        }

        return VersionFactory::detectVersion(
            $useragent,
            ['Windows Phone OS', 'Windows Phone', 'wds', 'Windows Mobile', 'Windows NT']
        );
    }
}
