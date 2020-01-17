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

use BrowserDetector\Version\VersionInterface;

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
        '10.0',
        '10.1',
        '11.0',
        '12.0',
        '13.0',
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
     * @param VersionInterface $detectedVersion
     *
     * @throws \UnexpectedValueException
     *
     * @return string|null
     */
    public function mapSafariVersion(VersionInterface $detectedVersion): ?string
    {
        if (in_array($detectedVersion->getVersion(VersionInterface::IGNORE_MICRO), self::REGULAR_VERSIONS, true)) {
            return $detectedVersion->getVersion();
        }

        foreach (self::MAP_VERSIONS as $engineVersion => $osVersion) {
            if (version_compare((string) $detectedVersion->getVersion(VersionInterface::IGNORE_MICRO), (string) $engineVersion, '>=')) {
                return $osVersion;
            }
        }

        return null;
    }
}
