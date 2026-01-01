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
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\PlatformCodeInterface;
use UaParser\PlatformParserInterface;

use function preg_match;

final readonly class XUcbrowserDeviceUaPlatformCode implements PlatformCodeInterface
{
    /** @throws void */
    public function __construct(
        private PlatformParserInterface $platformParser,
        private NormalizerInterface $normalizer,
    ) {
        // nothing to do
    }

    /** @throws void */
    #[Override]
    public function hasPlatformCode(string $value): bool
    {
        return (bool) preg_match(
            '/bada|android|blackberry|brew|iphone|mre|windows|mtk|symbian/i',
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
        if ($value === '?') {
            return Os::unknown;
        }

        try {
            $normalizedValue = $this->normalizer->normalize($value);
        } catch (Exception) {
            return Os::unknown;
        }

        if ($normalizedValue === '' || $normalizedValue === null) {
            return Os::unknown;
        }

        return $this->platformParser->parse($normalizedValue);
    }
}
