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
namespace BrowserDetector\Version\Helper;

final class Safari
{
    /**
     * maps different Safari Versions to a normalized format
     *
     * @param string $detectedVersion
     *
     * @return string
     */
    public function mapSafariVersion(string $detectedVersion): string
    {
        $floatVersion = (float) $detectedVersion;

        $regularVersions = [
            3.0,
            3.1,
            3.2,
            4.0,
            4.1,
            4.2,
            4.3,
            4.4,
            5.0,
            5.1,
            5.2,
            6.0,
            6.1,
            6.2,
            7.0,
            7.1,
            8.0,
            8.1,
            9.0,
            9.1,
            10.0,
            10.1,
            11.0,
            12.0,
        ];

        if (in_array($floatVersion, $regularVersions)) {
            return $detectedVersion;
        }

        if (13600 <= $detectedVersion) {
            return '11.0';
        }

        if (12600 <= $detectedVersion) {
            return '10.0';
        }

        if (11600 <= $detectedVersion) {
            return '9.1';
        }

        if (10500 <= $detectedVersion) {
            return '8.0';
        }

        if (9500 <= $detectedVersion) {
            return '7.0';
        }

        if (8500 <= $detectedVersion) {
            return '6.0';
        }

        if (7500 <= $detectedVersion) {
            return '5.1';
        }

        if (6500 <= $detectedVersion) {
            return '5.0';
        }

        if (4500 <= $detectedVersion) {
            return '4.0';
        }

        if (600 <= $detectedVersion) {
            return '5.0';
        }

        if (500 <= $detectedVersion) {
            return '4.0';
        }

        if (400 <= $detectedVersion) {
            return '3.0';
        }

        return '0';
    }
}
