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
use Override;

use function preg_match;
use function version_compare;

final readonly class FirefoxOs implements VersionFactoryInterface
{
    private const array SEARCHES = [
        '44.0' => '2.5',
        '37.0' => '2.2',
        '34.0' => '2.1',
        '32.0' => '2.0',
        '30.0' => '1.4',
        '28.0' => '1.3',
        '26.0' => '1.2',
        '18.1' => '1.1',
        '18.0' => '1.0',
    ];

    /** @throws void */
    public function __construct(private VersionBuilderInterface $versionBuilder)
    {
        // nothing to do
    }

    /**
     * returns the version of the operating system/platform
     *
     * @throws void
     */
    #[Override]
    public function detectVersion(string $useragent): VersionInterface
    {
        if (!preg_match('/rv:(?P<version>\d+\.\d+)/', $useragent, $matches)) {
            return new NullVersion();
        }

        foreach (self::SEARCHES as $engineVersion => $osVersion) {
            if (!version_compare($matches['version'], $engineVersion, '>=')) {
                continue;
            }

            try {
                return $this->versionBuilder->set($osVersion);
            } catch (NotNumericException) {
                return new NullVersion();
            }
        }

        return new NullVersion();
    }
}
