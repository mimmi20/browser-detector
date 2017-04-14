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
class WindowsMobileOs implements VersionCacheFactoryInterface
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
        if (false !== mb_strpos($useragent, 'Windows NT 5.1')) {
            return VersionFactory::set('6.0');
        }

        $s = new Stringy($useragent);

        if ($s->containsAny(['Windows Mobile', 'MSIEMobile'])) {
            return VersionFactory::detectVersion($useragent, ['MSIEMobile'], '6.0');
        }

        return VersionFactory::detectVersion($useragent, ['Windows Phone']);
    }
}
