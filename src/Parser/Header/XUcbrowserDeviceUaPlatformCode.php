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
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaNormalizer\NormalizerFactory;
use UaParser\PlatformCodeInterface;
use UaParser\PlatformParserInterface;

use function preg_match;

final class XUcbrowserDeviceUaPlatformCode implements PlatformCodeInterface
{
    private readonly NormalizerInterface $normalizer;

    /** @throws Exception */
    public function __construct(
        private readonly PlatformParserInterface $platformParser,
        NormalizerFactory $normalizerFactory,
    ) {
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

        $normalizedValue = $this->normalizer->normalize($value);

        $code = $this->platformParser->parse($normalizedValue);

        if ($code === '') {
            return null;
        }

        return $code;
    }
}
