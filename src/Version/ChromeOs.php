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

use Psr\Log\LoggerInterface;

use function preg_match;

final class ChromeOs implements VersionDetectorInterface
{
    private LoggerInterface $logger;

    private VersionFactoryInterface $versionFactory;

    public function __construct(LoggerInterface $logger, VersionFactoryInterface $versionFactory)
    {
        $this->logger         = $logger;
        $this->versionFactory = $versionFactory;
    }

    /**
     * returns the version of the operating system/platform
     */
    public function detectVersion(string $useragent): VersionInterface
    {
        if (0 < preg_match('/(?:CrOS [a-z0-9_]+|Windows aarch64) \d{4,5}\.\d+\.\d+\) .* Chrome\/(?P<version>\d+[\d\.]+)/', $useragent, $firstMatches)) {
            try {
                return $this->versionFactory->set($firstMatches['version']);
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }

            return new NullVersion();
        }

        if (0 < preg_match('/CrOS [a-z0-9_]+ (?P<version>\d+[\d\.]+)/', $useragent, $secondMatches)) {
            try {
                return $this->versionFactory->set($secondMatches['version']);
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }
        }

        return new NullVersion();
    }
}
