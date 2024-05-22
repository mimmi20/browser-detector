<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Version;

use BrowserDetector\Version\Exception\NotNumericException;
use Psr\Log\LoggerInterface;

use function array_unshift;
use function mb_strtolower;
use function str_contains;

final class RimOs implements VersionFactoryInterface
{
    /** @throws void */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly VersionBuilderInterface $versionBuilder,
    ) {
        // nothing to do
    }

    /**
     * returns the version of the operating system/platform
     *
     * @throws void
     */
    public function detectVersion(string $useragent): VersionInterface
    {
        $lowerAgent = mb_strtolower($useragent);

        if (str_contains($lowerAgent, 'bb10') && !str_contains($lowerAgent, 'version')) {
            try {
                return $this->versionBuilder->set('10.0.0');
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }

            return new NullVersion();
        }

        $searches = ['BlackBerry[0-9a-z]+', 'BlackBerry; [0-9a-z]+\/', 'BlackBerrySimulator'];

        if (str_contains($lowerAgent, 'bb10') || !str_contains($lowerAgent, 'opera')) {
            array_unshift($searches, 'Version');
        }

        try {
            return $this->versionBuilder->detectVersion($useragent, $searches);
        } catch (NotNumericException $e) {
            $this->logger->info($e);
        }

        return new NullVersion();
    }
}
