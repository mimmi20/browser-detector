<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Version;

use BrowserDetector\Version\Helper\MicrosoftOffice as MicrosoftOfficeHelper;

class MicrosoftWord implements VersionCacheFactoryInterface
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
        $doMatch = preg_match('/Word[\/ ]([\d\.]+)/', $useragent, $matches);

        if ($doMatch) {
            return VersionFactory::set((new MicrosoftOfficeHelper())->mapOfficeVersion($matches[1]));
        }

        return VersionFactory::set('0.0');
    }
}
