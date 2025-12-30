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
use BrowserDetector\Version\Helper\SafariInterface;
use Override;
use UnexpectedValueException;

use function is_string;
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
        $matches = [];

        $doMatch = preg_match('/version\/(?P<version>[\d\.]+)/i', $useragent, $matches);

        if ($doMatch && is_string($matches['version'])) {
            try {
                $version = $this->versionBuilder->set($matches['version']);
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

            return new NullVersion();
        }

        $doMatch = preg_match(
            '/NetworkingExtension\/.+ Network\/.+ iOS\/(?P<version>[\d\.]+)/',
            $useragent,
            $matches,
        );

        if ($doMatch && is_string($matches['version'])) {
            try {
                $version = $this->versionBuilder->set($matches['version']);
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

        $doMatch = preg_match(
            '/(Safari|com\.apple\.WebKit\.Networking|NetworkingExtension)\/(?P<version>[\d\.]+)/',
            $useragent,
            $matches,
        );

        if ($doMatch && is_string($matches['version'])) {
            try {
                $version = $this->versionBuilder->set($matches['version']);
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
