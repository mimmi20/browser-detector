<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2026, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Version\Helper;

use BrowserDetector\Version\VersionInterface;
use Override;
use UnexpectedValueException;

use function in_array;
use function version_compare;

final class Safari implements SafariInterface
{
    private const array REGULAR_VERSIONS = [
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
        '17.3',
        '17.4',
        '17.5',
        '17.6',
        '17.7',
        '17.8',
        '17.9',
        '17.10',
        '17.11',
        '17.12',
        '17.13',
        '18.0',
        '18.1',
        '18.2',
        '18.3',
        '18.4',
        '18.5',
        '18.6',
        '18.7',
        '26.0',
        '26.1',
        '26.2',
        '26.3',
        '26.4',
    ];

    private const array MAP_VERSIONS = [
        '20624.11' => '26.4',
        '20623.2' => '26.3',
        '20623.1' => '26.2',
        '20622.2' => '26.1',
        '20622.1' => '26.0',
        '20621.3' => '18.6',
        '20621.2' => '18.5',
        '20621.1' => '18.4',
        '20620.2' => '18.3',
        '20620.1' => '18.2',
        '20619.2' => '18.1',
        '20619.1' => '18.0',
        '19618.3' => '17.6',
        '19618.2' => '17.5',
        '19618.1' => '17.4',
        '19617.2' => '17.3',
        '19617.1' => '17.2',
        '19616.2' => '17.1',
        '19616.1' => '17.0',
        '18615.3' => '16.6',
        '18615.2' => '16.5',
        '18615.1' => '16.4',
        '18614.4' => '16.3',
        '18614.3' => '16.2',
        '18614.2' => '16.1',
        '18614.1' => '16.0',
        '17613.3' => '15.6',
        '17613.2' => '15.5',
        '17613.1' => '15.4',
        '17612.3' => '15.2',
        '17612.1' => '15.0',
        '16611' => '14.1',
        '16610' => '14.0',
        '15609' => '13.1',
        '15600' => '13.0',
        '14607' => '12.1',
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
    #[Override]
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
