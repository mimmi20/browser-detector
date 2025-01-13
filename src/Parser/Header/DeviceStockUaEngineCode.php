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
use UaParser\EngineCodeInterface;

use function mb_strtolower;
use function preg_match;

final class DeviceStockUaEngineCode implements EngineCodeInterface
{
    /** @throws void */
    #[Override]
    public function hasEngineCode(string $value): bool
    {
        return (bool) preg_match('/trident|presto|webkit|gecko/i', $value);
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getEngineCode(string $value): string | null
    {
        $matches = [];

        if (preg_match('/(?P<engine>trident|presto|webkit|gecko)/i', $value, $matches)) {
            return mb_strtolower($matches['engine']);
        }

        return null;
    }
}
