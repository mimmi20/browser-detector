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
 *
 * @author Thomas Müller <mimmi20@live.de>
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
        if (12600 <= $detectedVersion) {
            $detectedVersion = '10.0';
        } elseif (11600 <= $detectedVersion) {
            $detectedVersion = '9.1';
        } elseif (10500 <= $detectedVersion) {
            $detectedVersion = '8.0';
        } elseif (9500 <= $detectedVersion) {
            $detectedVersion = '7.0';
        } elseif (8500 <= $detectedVersion) {
            $detectedVersion = '6.0';
        } elseif (7500 <= $detectedVersion) {
            $detectedVersion = '5.1';
        } elseif (6500 <= $detectedVersion) {
            $detectedVersion = '5.0';
        } elseif (4500 <= $detectedVersion) {
            $detectedVersion = '4.0';
        } elseif (600 <= $detectedVersion) {
            $detectedVersion = '5.0';
        } elseif (500 <= $detectedVersion) {
            $detectedVersion = '4.0';
        } elseif (400 <= $detectedVersion) {
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
