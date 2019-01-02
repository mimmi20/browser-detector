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

use Stringy\Stringy;

final class WindowsMobileOs implements VersionDetectorInterface
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

        if ($s->contains('windows nt 5.1', false) && !$s->containsAny(['windows mobile', 'windows phone'], false)) {
            return (new VersionFactory())->set('6.0');
        }

        return (new VersionFactory())->detectVersion($useragent, ['Windows Mobile', 'Windows Phone']);
    }
}
