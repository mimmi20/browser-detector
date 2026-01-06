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

namespace BrowserDetector\Parser\Header;

use BrowserDetector\Data\Os;
use Override;
use UaData\OsInterface;
use UaParser\PlatformCodeInterface;

use function mb_strtolower;

final class XRequestedWithPlatformCode implements PlatformCodeInterface
{
    /** @throws void */
    #[Override]
    public function hasPlatformCode(string $value): bool
    {
        return match (mb_strtolower($value)) {
            'org.lineageos.jelly' => true,
            default => false,
        };
    }

    /**
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getPlatformCode(string $value, string | null $derivate = null): OsInterface
    {
        // see also vendor/whichbrowser/parser/data/id-android.php
        // see also vendor/matomo/device-detector/regexes/client/hints/apps.yml
        return match (mb_strtolower($value)) {
            'org.lineageos.jelly' => Os::lineageos,
            default => Os::unknown,
        };
    }
}
