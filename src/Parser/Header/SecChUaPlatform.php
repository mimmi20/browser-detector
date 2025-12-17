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

use BrowserDetector\Data\Os;
use Override;
use UaData\OsInterface;
use UaParser\PlatformCodeInterface;

use function in_array;
use function mb_strtolower;
use function mb_trim;

final class SecChUaPlatform implements PlatformCodeInterface
{
    /** @throws void */
    #[Override]
    public function hasPlatformCode(string $value): bool
    {
        $value = mb_trim($value, '"\\\'');
        $code  = mb_strtolower($value);

        return !in_array($code, ['', 'unknown'], true);
    }

    /** @throws void */
    #[Override]
    public function getPlatformCode(string $value, string | null $derivate = null): OsInterface
    {
        $value = mb_trim($value, '"\\\'');
        $code  = mb_strtolower($value);

        if ($derivate !== null) {
            $derivateCode = $this->getCode(mb_strtolower($derivate));

            if ($derivateCode !== Os::unknown) {
                return $derivateCode;
            }
        }

        return $this->getCode($code);
    }

    /** @throws void */
    private function getCode(string $code): OsInterface
    {
        return match ($code) {
            'android' => Os::android,
            'chromeos' => Os::chromeos,
            'lindows' => Os::lindows,
            'fuchsia' => Os::fuchsia,
            'macos', 'mac os x', 'macintel' => Os::macosx,
            'chrome os', 'chromium os' => Os::chromeos,
            'windows', 'win32' => Os::windows,
            'harmonyos' => Os::harmonyos,
            'linux', 'linux x86_64' => Os::linux,
            default => Os::unknown,
        };
    }
}
