<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Header;

use function mb_strtolower;
use function trim;

final class SecChUaPlatform implements HeaderInterface
{
    use HeaderTrait;

    /** @throws void */
    public function hasPlatformCode(): bool
    {
        return true;
    }

    /** @throws void */
    public function getPlatformCode(): string | null
    {
        $value = trim($this->value, '"');

        if ($value === '') {
            return null;
        }

        $code = mb_strtolower($value);

        return match ($code) {
            'android', 'windows', 'linux', 'chromeos' => $code,
            'macos' => 'mac os x',
            'chrome os' => 'chromeos',
            default => null,
        };
    }
}
