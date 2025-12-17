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

use BrowserDetector\Data\Os;
use Override;
use UaData\OsInterface;
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
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getPlatformCode(string $value, string | null $derivate = null): OsInterface
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
                'blackberry' => Os::rimOs,
                'windows' => Os::windowsphone,
                'windows ce' => Os::windowsce,
                'iphone' => Os::ios,
                'mtk' => Os::nucleus,
                'bada' => Os::bada,
                'brew' => Os::brew,
                'android' => Os::android,
                'mre' => Os::mre,
                default => Os::unknown,
            };
        }

        return Os::unknown;
    }
}
