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

use function preg_match;

final class UaOsPlatformCode implements PlatformCodeInterface
{
    /** @throws void */
    #[Override]
    public function hasPlatformCode(string $value): bool
    {
        return (bool) preg_match('/Windows CE \(Pocket PC\) - Version \d+\.\d+/', $value);
    }

    /**
     * @return non-empty-string|null
     *
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getPlatformCode(string $value, string | null $derivate = null): string | null
    {
        $matches = [];

        if (preg_match('/(?P<name>Windows CE) \(Pocket PC\) - Version \d+\.\d+/', $value, $matches)) {
            return 'windows ce';
        }

        return null;
    }
}
