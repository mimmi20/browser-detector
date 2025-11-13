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

final readonly class FireOs
{
    private const array VERSION_MAP = [
        '11' => '8',
        '10' => '8',
        '9' => '7',
        '7' => '6',
        '5' => '5',
        '4.4.3' => '4.5.1',
        '4.4.2' => '4',
        '4.2.2' => '3',
        '4.0.3' => '3',
        '4.0.2' => '3',
        '4' => '2',
        '2' => '1',
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
            $fireOsVersion = self::VERSION_MAP[$androidVersion];
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
            $fireOsVersion     = current($lineageOsVersions);

            if ($fireOsVersion === false) {
                $fireOsVersion = '';
            }
        }

        return $this->versionBuilder->set($fireOsVersion);
    }
}
