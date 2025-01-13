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

use function mb_strtolower;
use function preg_match;

final class DeviceStockUaPlatformCode implements PlatformCodeInterface
{
    /** @throws void */
    #[Override]
    public function hasPlatformCode(string $value): bool
    {
        return (bool) preg_match(
            '/bada|android|blackberry|brew(?: mp)?|iphone os|mre|windows phone(?: os)?|mtk/i',
            $value,
        );
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getPlatformCode(string $value, string | null $derivate = null): string | null
    {
        $matches = [];

        if (
            preg_match(
                '/(?P<platform>bada|android|blackberry|brew(?: mp)?|iphone os|mre|windows phone(?: os)?|mtk)/i',
                $value,
                $matches,
            )
        ) {
            $code = mb_strtolower($matches['platform']);

            return match ($code) {
                'blackberry' => 'rim os',
                'iphone os' => 'ios',
                'mtk' => 'nucleus os',
                'windows phone os' => 'windows phone',
                'brew mp' => 'brew',
                default => $code,
            };
        }

        return null;
    }
}
