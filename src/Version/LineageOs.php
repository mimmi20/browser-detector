<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Version;

use BrowserDetector\Version\Exception\NotNumericException;

use function array_filter;
use function array_key_exists;
use function current;
use function version_compare;

use const ARRAY_FILTER_USE_KEY;

final readonly class LineageOs
{
    private const array VERSION_MAP = [
        '16' => '23',
        '15' => '22',
        '14' => '21',
        '13' => '20',
        '12.1' => '19.1',
        '12' => '19',
        '11' => '18',
        '10' => '17',
        '9' => '16',
        '8.1' => '15.1',
        '8' => '15',
        '7.1.2' => '14.1',
        '7.1.1' => '14.1',
        '7' => '14',
        '6.0.1' => '13',
        '6' => '13',
        '5.1.1' => '12.1',
        '5.0.2' => '12',
        '5' => '12',
        '4.4.4' => '11',
        '4.3' => '10.2',
        '4.2.2' => '10.1',
        '4.0.4' => '9.1',
    ];

    /** @throws void */
    public function __construct(private VersionBuilderInterface $versionBuilder)
    {
        // nothing to do
    }

    /**
     * returns the version of the operating system/platform
     *
     * @throws NotNumericException
     */
    public function getVersion(string $androidVersion): VersionInterface
    {
        if (array_key_exists($androidVersion, self::VERSION_MAP)) {
            $lineageOsVersion = self::VERSION_MAP[$androidVersion];
        } else {
            $lineageOsVersions = array_filter(
                self::VERSION_MAP,
                static fn (int | string $key): bool => version_compare(
                    $androidVersion,
                    (string) $key,
                    '>',
                ),
                ARRAY_FILTER_USE_KEY,
            );
            $lineageOsVersion  = current($lineageOsVersions);

            if ($lineageOsVersion === false) {
                $lineageOsVersion = '';
            }
        }

        return $this->versionBuilder->set($lineageOsVersion);
    }
}
