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

namespace BrowserDetector\Version;

use BrowserDetector\Version\Exception\NotNumericException;
use BrowserDetector\Version\Helper\SafariInterface;
use Override;
use UnexpectedValueException;

use function array_filter;
use function array_first;
use function array_map;
use function preg_match;

final readonly class Safari implements VersionFactoryInterface
{
    /** @throws void */
    public function __construct(
        private VersionBuilderInterface $versionBuilder,
        private SafariInterface $safariHelper,
    ) {
        // nothing to do
    }

    /**
     * returns the version of the operating system/platform
     *
     * @throws UnexpectedValueException
     */
    #[Override]
    public function detectVersion(string $useragent): VersionInterface
    {
        $regexes = [
            '/version\/(?P<version>[\d\.]+)/i',
            '/NetworkingExtension\/.+ Network\/.+ iOS\/(?P<version>[\d\.]+)/',
            '/(Safari|com\.apple\.WebKit\.Networking|NetworkingExtension|Safari Technology Preview|safarifetcherd)\/(?P<version>[\d\.]+)/',
        ];

        $filtered = array_filter(
            $regexes,
            static fn (string $regex): bool => (bool) preg_match($regex, $useragent),
        );

        $results = array_map(
            static function (string $regex) use ($useragent): string {
                $matches = [];

                preg_match($regex, $useragent, $matches);

                return $matches['version'] ?? '';
            },
            $filtered,
        );

        $detectedVersion = array_first($results);

        if ($detectedVersion !== null && $detectedVersion !== '') {
            try {
                $version = $this->versionBuilder->set($detectedVersion);
            } catch (NotNumericException) {
                return new NullVersion();
            }

            $mappedVersion = $this->safariHelper->mapSafariVersion($version);

            if ($mappedVersion === null) {
                return new NullVersion();
            }

            try {
                return $this->versionBuilder->set($mappedVersion);
            } catch (NotNumericException) {
                // nothing to do
            }
        }

        return new NullVersion();
    }
}
