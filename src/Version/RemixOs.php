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

use function preg_match;

final readonly class RemixOs implements VersionFactoryInterface
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
        $remixOsVersion = '0';

        if (preg_match('/remix pro/i', $useragent)) {
            $remixOsVersion = '3';
        } elseif (preg_match('/remixos 6|remix mini/i', $useragent)) {
            $remixOsVersion = '2';
        } elseif (preg_match('/remixos 5/i', $useragent)) {
            $remixOsVersion = '1';
        }

        return $this->versionBuilder->set($remixOsVersion);
    }
}
