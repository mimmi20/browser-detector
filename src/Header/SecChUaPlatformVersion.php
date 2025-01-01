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

namespace BrowserDetector\Header;

use Override;

use function mb_strtolower;
use function trim;

final class SecChUaPlatformVersion implements HeaderInterface
{
    use HeaderTrait;

    /** @throws void */
    #[Override]
    public function hasPlatformVersion(): bool
    {
        $value = trim($this->value, '"\\\'');

        return $value !== '';
    }

    /** @throws void */
    #[Override]
    public function getPlatformVersion(string | null $code = null): string | null
    {
        $value = trim($this->value, '"\\\'');

        if ($value === '') {
            return null;
        }

        if (mb_strtolower($code ?? '') === 'windows') {
            $windowsVersion = (float) $value;

            if ($windowsVersion < 1) {
                $windowsVersion     *= 10;
                $minorVersionMapping = [1 => '7', 2 => '8', 3 => '8.1'];

                $value = $minorVersionMapping[$windowsVersion] ?? $value;
            } elseif ($windowsVersion > 0 && $windowsVersion < 11) {
                $value = '10';
            } elseif ($windowsVersion > 10) {
                $value = '11';
            }
        }

        return $value;
    }
}
