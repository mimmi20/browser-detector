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

final class XUcbrowserUaEngineCode implements EngineCodeInterface
{
    /** @throws void */
    #[Override]
    public function hasEngineCode(string $value): bool
    {
        return (bool) preg_match('/(?<!o)re\(([^)]+)\)/', $value);
    }

    /** @throws void */
    #[Override]
    public function getEngineCode(string $value): string | null
    {
        $matches = [];

        if (preg_match('/(?<!o)re\((?P<engine>[^\/)]+)(?:\/[\d.]+)?/', $value, $matches)) {
            $code = mb_strtolower($matches['engine']);

            return match ($code) {
                'applewebkit' => 'webkit',
                default => $code,
            };
        }

        return null;
    }
}
