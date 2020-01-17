<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2020, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Version\Helper;

final class MicrosoftOffice
{
    /**
     * maps the version
     *
     * @param string $version
     *
     * @return string
     */
    public function mapOfficeVersion(string $version): string
    {
        $intVersion = (int) $version;

        if (in_array($intVersion, [2007, 2010, 2013, 2016], true)) {
            return (string) $intVersion;
        }

        if (16 === $intVersion) {
            return '2016';
        }

        if (15 === $intVersion) {
            return '2013';
        }

        if (14 === $intVersion) {
            return '2010';
        }

        if (12 === $intVersion) {
            return '2007';
        }

        return '0';
    }
}
