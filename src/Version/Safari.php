<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
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

final class Safari implements VersionDetectorInterface
{
    private LoggerInterface $logger;

    private VersionFactoryInterface $versionFactory;

    private SafariInterface $safariHelper;

    public function __construct(LoggerInterface $logger, VersionFactoryInterface $versionFactory, SafariInterface $safariHelper)
    {
        $this->logger         = $logger;
        $this->versionFactory = $versionFactory;
        $this->safariHelper   = $safariHelper;
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
                $version = $this->versionFactory->set($matches['version']);
            } catch (NotNumericException $e) {
                $this->logger->info($e);

                return new NullVersion();
            }

            $mappedVersion = $this->safariHelper->mapSafariVersion($version);

            if (null === $mappedVersion) {
                return new NullVersion();
            }

            try {
                return $this->versionFactory->set($mappedVersion);
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }
        }

        return new NullVersion();
    }
}
