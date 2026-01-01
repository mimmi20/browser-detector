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
use Override;

use function mb_strtolower;
use function preg_match;
use function str_contains;

final readonly class Goanna implements VersionFactoryInterface
{
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
        // lastest version: version on "Goanna" token
        $doMatch = preg_match('/Goanna\/(?P<version>\d\.[\d\.]*)/', $useragent, $matchesFirst);

        if ($doMatch) {
            try {
                return $this->versionBuilder->set($matchesFirst['version']);
            } catch (NotNumericException) {
                // nothing to do
            }

            return new NullVersion();
        }

        // second version: version on "rv:" token
        $doMatch = preg_match('/rv\:(?P<version>\d\.[\d\.]*)/', $useragent, $matchesSecond);

        if ($doMatch && str_contains(mb_strtolower($useragent), 'goanna')) {
            try {
                return $this->versionBuilder->set($matchesSecond['version']);
            } catch (NotNumericException) {
                // nothing to do
            }

            return new NullVersion();
        }

        try {
            // first version: uses gecko version
            return $this->versionBuilder->set('1.0');
        } catch (NotNumericException) {
            // nothing to do
        }

        return new NullVersion();
    }
}
