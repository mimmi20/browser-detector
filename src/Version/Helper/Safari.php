<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Version\Helper;

use BrowserDetector\Version\VersionInterface;
use UnexpectedValueException;

use function in_array;
use function version_compare;

final class Safari implements SafariInterface
{
    private const REGULAR_VERSIONS = [
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
        '9.2',
        '9.3',
        '10.0',
        '10.1',
        '10.2',
        '10.3',
        '11.0',
        '11.1',
        '11.2',
        '11.3',
        '11.4',
        '12.0',
        '12.1',
        '12.2',
        '12.3',
        '12.4',
        '13.0',
        '13.1',
        '13.2',
        '13.3',
        '13.4',
        '13.5',
        '13.6',
        '13.7',
        '14.0',
        '14.1',
        '14.2',
        '14.3',
        '14.4',
        '14.5',
        '14.6',
        '14.7',
        '14.8',
        '15.0',
        '15.1',
        '15.2',
        '15.3',
        '15.4',
        '15.5',
        '15.6',
        '15.7',
        '16.0',
        '16.1',
        '16.2',
        '16.3',
        '16.4',
        '16.5',
        '16.6',
        '17.0',
        '17.1',
        '17.2',
        '18.0',
    ];

    private const MAP_VERSIONS = [
        '15600' => '13.0',
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

    /**
     * maps different Safari Versions to a normalized format
     *
     * @throws UnexpectedValueException
     */
    public function mapSafariVersion(VersionInterface $detectedVersion): string | null
    {
        if (
            in_array(
                $detectedVersion->getVersion(VersionInterface::IGNORE_MICRO),
                self::REGULAR_VERSIONS,
                true,
            )
        ) {
            return $detectedVersion->getVersion();
        }

        foreach (self::MAP_VERSIONS as $engineVersion => $osVersion) {
            if (
                version_compare(
                    (string) $detectedVersion->getVersion(VersionInterface::IGNORE_MICRO),
                    (string) $engineVersion,
                    '>=',
                )
            ) {
                return $osVersion;
            }
        }

        return null;
    }
}
