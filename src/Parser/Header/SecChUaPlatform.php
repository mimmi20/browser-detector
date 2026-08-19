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
use UaParser\DeviceCodeInterface;
use UaParser\PlatformCodeInterface;

use function in_array;
use function mb_strtolower;
use function mb_trim;

final class SecChUaPlatform implements DeviceCodeInterface, PlatformCodeInterface
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
    public function hasDeviceCode(string $value): bool
    {
        $value = mb_trim($value, '"\\\'');
        $code  = mb_strtolower($value);

        return !in_array($code, ['', 'unknown'], true);
    }

    /** @throws void */
    #[Override]
    public function getPlatformCode(string $value, string | null $derivate = null): OsInterface
    {
        if ($derivate !== null) {
            $derivateCode = $this->getCode(mb_strtolower($derivate));

            if ($derivateCode !== Os::unknown) {
                return $derivateCode;
            }
        }

        $value = mb_trim($value, '"\\\'');
        $code  = mb_strtolower($value);

        return $this->getCode($code);
    }

    /**
     * @return non-empty-string|null
     *
     * @throws void
     */
    #[Override]
    public function getDeviceCode(string $value): string | null
    {
        $value  = mb_trim($value, '"\\\'');
        $code   = mb_strtolower($value);
        $osCode = $this->getCode($code);

        return match ($osCode) {
            Os::macosx => 'apple=macintosh',
            Os::windows => 'unknown=windows desktop',
            Os::linux, Os::chromeos => 'unknown=linux desktop',
            default => null,
        };
    }

    /** @throws void */
    private function getCode(string $code): OsInterface
    {
        return match ($code) {
            'android' => Os::android,
            'chromeos', 'chrome os', 'chromium os', 'chromiumos' => Os::chromeos,
            'lindows' => Os::lindows,
            'fuchsia' => Os::fuchsia,
            'macos', 'mac os x', 'macintel' => Os::macosx,
            'windows', 'win32' => Os::windows,
            'harmonyos' => Os::harmonyos,
            'linux', 'linux x86_64' => Os::linux,
            'cloud phone 2.4' => Os::puffinOs,
            'openbsd' => Os::openbsd,
            'freebsd' => Os::freebsd,
            'ios' => Os::ios,
            default => Os::unknown,
        };
    }
}
