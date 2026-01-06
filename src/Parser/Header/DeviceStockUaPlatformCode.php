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
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getPlatformCode(string $value, string | null $derivate = null): OsInterface
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
                'blackberry' => Os::rimOs,
                'iphone os' => Os::ios,
                'mtk' => Os::nucleus,
                'windows phone', 'windows phone os' => Os::windowsphone,
                'brew', 'brew mp' => Os::brew,
                'bada' => Os::bada,
                'mre' => Os::mre,
                'android' => Os::android,
                default => Os::unknown,
            };
        }

        return Os::unknown;
    }
}
