<?php

/**
 * This file is part of the mimmi20/ua-generic-request package.
 *
 * Copyright (c) 2015-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Parser\Header;

use Override;
use UaParser\PlatformCodeInterface;

use function in_array;
use function mb_strtolower;
use function trim;

final class SecChUaPlatform implements PlatformCodeInterface
{
    /** @throws void */
    #[Override]
    public function hasPlatformCode(string $value): bool
    {
        $value = trim($value, '"\\\'');
        $code  = mb_strtolower($value);

        return !in_array($code, ['', 'unknown'], true);
    }

    /** @throws void */
    #[Override]
    public function getPlatformCode(string $value, string | null $derivate = null): string | null
    {
        $value = trim($value, '"\\\'');
        $code  = mb_strtolower($value);

        if ($derivate !== null) {
            $derivate     = mb_strtolower($derivate);
            $derivateCode = $this->getCode($derivate);

            if ($derivateCode !== null) {
                return $derivateCode;
            }
        }

        return $this->getCode($code);
    }

    /** @throws void */
    private function getCode(string $code): string | null
    {
        return match ($code) {
            'android', 'linux', 'chromeos', 'lindows' => $code,
            'macos', 'mac os x' => 'mac os x',
            'chrome os', 'chromium os' => 'chromeos',
            'windows', 'win32' => 'windows',
            'harmonyos' => 'harmony-os',
            default => null,
        };
    }
}
