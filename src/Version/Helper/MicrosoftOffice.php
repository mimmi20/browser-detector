<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Version\Helper;

use function in_array;

final class MicrosoftOffice
{
    /**
     * maps the version
     *
     * @throws void
     */
    public function mapOfficeVersion(string $version): string
    {
        $intVersion = (int) $version;

        if (in_array($intVersion, [2007, 2010, 2013, 2016], true)) {
            return (string) $intVersion;
        }

        if ($intVersion === 16) {
            return '2016';
        }

        if ($intVersion === 15) {
            return '2013';
        }

        if ($intVersion === 14) {
            return '2010';
        }

        if ($intVersion === 12) {
            return '2007';
        }

        return '0';
    }
}
