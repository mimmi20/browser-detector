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

use Override;
use UaParser\DeviceCodeInterface;

use function mb_strtolower;
use function mb_trim;

final class SecChUaPlatformDevice implements DeviceCodeInterface
{
    /**
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function hasDeviceCode(string $value): bool
    {
        // @todo: check again
        return false;
    }

    /**
     * @return non-empty-string|null
     *
     * @throws void
     */
    #[Override]
    public function getDeviceCode(string $value): string | null
    {
        $value = mb_trim($value, '"\\\'');
        $code  = mb_strtolower($value);

        return match ($code) {
            'windows', 'win32' => 'unknown=windows desktop',
            'macos' => 'apple=macintosh',
            default => null,
        };
    }
}
