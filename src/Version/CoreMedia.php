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

final class CoreMedia implements VersionDetectorInterface
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
        $doMatch = preg_match('/(?:CoreMedia v|AppleCoreMedia\/)(?P<major>\d+)\.(?P<minor>\d+)\.(?P<micro>\d+)/', $useragent, $matchesFirst);

        if (0 < $doMatch) {
            try {
                return $this->versionFactory->set(
                    $matchesFirst['major'] . '.' . $matchesFirst['minor'] . '.' . $matchesFirst['micro']
                );
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }
        }

        return new NullVersion();
    }
}
