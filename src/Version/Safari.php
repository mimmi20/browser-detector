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

namespace BrowserDetector\Version;

use BrowserDetector\Version\Helper\SafariInterface;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;

use function preg_match;

final class Safari implements VersionFactoryInterface
{
    /** @throws void */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly VersionBuilderInterface $versionBuilder,
        private readonly SafariInterface $safariHelper,
    ) {
        // nothing to do
    }

    /**
     * returns the version of the operating system/platform
     *
     * @throws UnexpectedValueException
     */
    public function detectVersion(string $useragent): VersionInterface
    {
        $matches = [];

        $doMatch = preg_match('/(?:Version|Safari)\/(?P<version>[\d\.]+)/', $useragent, $matches);

        if ($doMatch) {
            try {
                $version = $this->versionBuilder->set($matches['version']);
            } catch (NotNumericException $e) {
                $this->logger->info($e);

                return new NullVersion();
            }

            $mappedVersion = $this->safariHelper->mapSafariVersion($version);

            if ($mappedVersion === null) {
                return new NullVersion();
            }

            try {
                return $this->versionBuilder->set($mappedVersion);
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }
        }

        return new NullVersion();
    }
}
