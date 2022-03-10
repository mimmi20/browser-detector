<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2022, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Version;

use Psr\Log\LoggerInterface;

use function array_unshift;
use function mb_stripos;

final class RimOs implements VersionDetectorInterface
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
        if (false !== mb_stripos($useragent, 'bb10') && false === mb_stripos($useragent, 'version')) {
            try {
                return $this->versionFactory->set('10.0.0');
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }

            return new NullVersion();
        }

        $searches = ['BlackBerry[0-9a-z]+', 'BlackBerry; [0-9a-z]+\/', 'BlackBerrySimulator'];

        if (false !== mb_stripos($useragent, 'bb10') || false === mb_stripos($useragent, 'opera')) {
            array_unshift($searches, 'Version');
        }

        try {
            return $this->versionFactory->detectVersion($useragent, $searches);
        } catch (NotNumericException $e) {
            $this->logger->info($e);
        }

        return new NullVersion();
    }
}
