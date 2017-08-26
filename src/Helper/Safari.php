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
namespace BrowserDetector\Helper;

/**
 * a helper for detecting safari and some of his derefered browsers
 */
class Safari
{
    /**
     * maps different Safari Versions to a normalized format
     *
     * @param string $detectedVersion
     *
     * @return string
     */
    public function mapSafariVersions(string $detectedVersion): string
    {
        if ($detectedVersion >= 12600) {
            $detectedVersion = '10.0';
        } elseif ($detectedVersion >= 11600) {
            $detectedVersion = '9.1';
        } elseif ($detectedVersion >= 10500) {
            $detectedVersion = '8.0';
        } elseif ($detectedVersion >= 9500) {
            $detectedVersion = '7.0';
        } elseif ($detectedVersion >= 8500) {
            $detectedVersion = '6.0';
        } elseif ($detectedVersion >= 7500) {
            $detectedVersion = '5.1';
        } elseif ($detectedVersion >= 6500) {
            $detectedVersion = '5.0';
        } elseif ($detectedVersion >= 4500) {
            $detectedVersion = '4.0';
        } elseif ($detectedVersion >= 600) {
            $detectedVersion = '5.0';
        } elseif ($detectedVersion >= 500) {
            $detectedVersion = '4.0';
        } elseif ($detectedVersion >= 400) {
            $detectedVersion = '3.0';
        }

        $regularVersions = [
            '3.0',
            '3.1',
            '3.2',
            '4.0',
            '4.1',
            '4.2',
            '4.3',
            '4.4',
            '5.0',
            '5.1',
            '5.2',
            '6.0',
            '6.1',
            '6.2',
            '7.0',
            '7.1',
            '8.0',
            '8.1',
            '9.0',
            '9.1',
            '10.0',
            '10.1',
            '11.0',
        ];

        if (in_array(mb_substr($detectedVersion, 0, 3), $regularVersions)
            || in_array(mb_substr($detectedVersion, 0, 4), $regularVersions)
        ) {
            return $detectedVersion;
        }

        return '';
    }
}
