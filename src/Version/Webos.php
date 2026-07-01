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

use function array_key_exists;
use function preg_match;

final readonly class Webos implements VersionFactoryInterface
{
    /** @throws void */
    public function __construct(private VersionBuilderInterface $versionBuilder)
    {
        // nothing to do
    }

    /**
     * returns the version of the operating system/platform
     *
     * @throws NotNumericException
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    #[Override]
    public function detectVersion(string $useragent): VersionInterface
    {
        if (
            preg_match('/(?:webos|hpwos)\/(?<version>\d+[.\d]+)/i', $useragent, $matches)
            && array_key_exists('version', $matches)
        ) {
            return $this->versionBuilder->set($matches['version']);
        }

        $versions = [
            26 => '/web0s; linux\/smarttv.+chr[o0]me\/132/i',
            25 => '/web0s; linux\/smarttv.+chr[o0]me\/120/i',
            24 => '/web0s; linux\/smarttv.+chr[o0]me\/108/i',
            23 => '/web0s; linux\/smarttv.+chr[o0]me\/94/i',
            22 => '/web0s; linux\/smarttv.+chr[o0]me\/87/i',
            6 => '/web0s; linux\/smarttv.+chr[o0]me\/79/i',
            5 => '/web0s; linux\/smarttv.+chr[o0]me\/68/i',
            4 => '/web0s; linux\/smarttv.+chr[o0]me\/53/i',
            3 => '/web0s; linux\/smarttv.+chr[o0]me\/38/i',
            2 => '/web0s; linux\/smarttv.+safari\/538/i',
            1 => '/webos1|web0s; linux\/smarttv.+safari\/537/i',
        ];

        foreach ($versions as $version => $regex) {
            if (preg_match($regex, $useragent)) {
                return $this->versionBuilder->set((string) $version);
            }
        }

        return new NullVersion();
    }
}
