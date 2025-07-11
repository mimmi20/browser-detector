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
use UaParser\PlatformCodeInterface;

use function mb_strtolower;
use function preg_match;

final class XUcbrowserUaPlatformCode implements PlatformCodeInterface
{
    /** @throws void */
    #[Override]
    public function hasPlatformCode(string $value): bool
    {
        if (preg_match('/pf\((?P<platform>[^)]+)\);/', $value, $matches)) {
            return match (mb_strtolower($matches['platform'])) {
                'linux', 'symbian', '42', '44', 'windows', 'java' => true,
                default => false,
            };
        }

        return false;
    }

    /**
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getPlatformCode(string $value, string | null $derivate = null): string | null
    {
        $matches = [];

        if (preg_match('/pf\((?P<platform>[^)]+)\);/', $value, $matches)) {
            $code = mb_strtolower($matches['platform']);

            return match ($code) {
                'symbian', 'java' => $code,
                'windows' => 'windows phone',
                '42', '44' => 'ios',
                'linux' => 'android',
                default => null,
            };
        }

        return null;
    }
}
