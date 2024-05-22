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

use function preg_match;

final class Gecko implements VersionFactoryInterface
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
        $geckoMatches = null;
        $rvMatches    = null;
        $ffMatches    = null;
        $doMatch      = preg_match('/gecko\/(?P<geckoversion>[\d\.]+)/i', $useragent, $geckoMatches);

        if (!$doMatch) {
            return new NullVersion();
        }

        preg_match('/rv:(?P<rvversion>[\d\.]+)/i', $useragent, $rvMatches);
        preg_match('/firefox\/(?P<ffversion>[\d\.]+)/i', $useragent, $ffMatches);

        $geckoversion = $geckoMatches['geckoversion'] ?? null;
        $ffversion    = $ffMatches['ffversion'] ?? null;
        $rvversion    = $rvMatches['rvversion'] ?? null;

        if (!empty($geckoversion) && !empty($ffversion) && $geckoversion === $ffversion) {
            try {
                return $this->versionBuilder->set($geckoversion);
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }

            return new NullVersion();
        }

        if (!empty($rvversion)) {
            try {
                return $this->versionBuilder->set($rvversion);
            } catch (NotNumericException $e) {
                $this->logger->info($e);
            }
        }

        return new NullVersion();
    }
}
