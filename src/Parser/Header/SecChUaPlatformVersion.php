<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Parser\Header;

use Override;
use UaParser\PlatformVersionInterface;

use function mb_strtolower;
use function mb_trim;

final class SecChUaPlatformVersion implements PlatformVersionInterface
{
    /** @throws void */
    #[Override]
    public function hasPlatformVersion(string $value): bool
    {
        $value = mb_trim($value, '"\\\'');

        return $value !== '';
    }

    /**
     * @return non-empty-string|null
     *
     * @throws void
     */
    #[Override]
    public function getPlatformVersion(string $value, string | null $code = null): string | null
    {
        $value = mb_trim($value, '"\\\'');

        if ($value === '') {
            return null;
        }

        if ($code === null || mb_strtolower($code) !== 'windows') {
            return $value;
        }

        $windowsVersion = (float) $value;

        if ($windowsVersion < 1) {
            $windowsVersion      = (int) ($windowsVersion * 10);
            $minorVersionMapping = [1 => '7', 2 => '8', 3 => '8.1'];

            return $minorVersionMapping[$windowsVersion] ?? $value;
        }

        if ($windowsVersion < 11) {
            return '10';
        }

        return '11';
    }
}
