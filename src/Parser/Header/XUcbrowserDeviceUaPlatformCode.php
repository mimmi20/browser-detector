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
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaNormalizer\NormalizerFactory;
use UaParser\PlatformCodeInterface;
use UaParser\PlatformParserInterface;

use function preg_match;

final readonly class XUcbrowserDeviceUaPlatformCode implements PlatformCodeInterface
{
    private NormalizerInterface $normalizer;

    /** @throws void */
    public function __construct(private PlatformParserInterface $platformParser, NormalizerFactory $normalizerFactory)
    {
        $this->normalizer = $normalizerFactory->build();
    }

    /** @throws void */
    #[Override]
    public function hasPlatformCode(string $value): bool
    {
        if ($value === '?') {
            return false;
        }

        return (bool) preg_match(
            '/bada|android|blackberry|brew|iphone|mre|windows|mtk|symbian/i',
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
        if ($value === '?') {
            return null;
        }

        try {
            $normalizedValue = $this->normalizer->normalize($value);
        } catch (Exception) {
            return null;
        }

        if ($normalizedValue === '' || $normalizedValue === null) {
            return null;
        }

        $code = $this->platformParser->parse($normalizedValue);

        if ($code === '') {
            return null;
        }

        return $code;
    }
}
