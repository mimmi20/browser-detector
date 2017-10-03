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
 * @author Thomas Müller <mimmi20@live.de>
 */
class Debian implements VersionCacheFactoryInterface
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
        $s = new Stringy($useragent);

        if ($s->containsAll(['debian', 'squeeze'], false)) {
            return VersionFactory::set('6.0');
        }

        return VersionFactory::detectVersion($useragent, ['kFreeBSD', 'Debian', 'Raspbian']);
    }
}
