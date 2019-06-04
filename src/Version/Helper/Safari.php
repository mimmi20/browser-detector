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

        if (in_array($detectedVersion, $regularVersions, true)) {
            return $detectedVersion;
        }

        $versions = [
            '14600' => '12.0',
            '13600' => '11.0',
            '12600' => '10.0',
            '11600' => '9.1',
            '10500' => '8.0',
            '9500' => '7.0',
            '8500' => '6.0',
            '7500' => '5.1',
            '6500' => '5.0',
            '4500' => '4.0',
            '600' => '5.0',
            '500' => '4.0',
            '400' => '3.0',
        ];

        foreach ($versions as $engineVersion => $osVersion) {
            if (version_compare($detectedVersion, (string) $engineVersion, '>=')) {
                return $osVersion;
            }
        }

        return '0';
    }
}
