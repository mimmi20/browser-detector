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

final class XOperaminiPhoneUaPlatformCode implements PlatformCodeInterface
{
    /** @throws void */
    #[Override]
    public function hasPlatformCode(string $value): bool
    {
        return (bool) preg_match('/bada|android|blackberry|brew|iphone|mre|windows|mtk/i', $value);
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
                '/(?P<platform>bada|android|blackberry|brew|iphone|mre|windows( ce)?|mtk)/i',
                $value,
                $matches,
            )
        ) {
            $code = mb_strtolower($matches['platform']);

            return match ($code) {
                'blackberry' => 'rim os',
                'windows' => 'windows phone',
                'iphone' => 'ios',
                'mtk' => 'nucleus os',
                default => $code,
            };
        }

        return null;
    }
}
