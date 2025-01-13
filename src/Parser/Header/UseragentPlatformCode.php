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

use function mb_strtolower;
use function preg_match;

final class UseragentPlatformCode implements PlatformCodeInterface
{
    private readonly NormalizerInterface $normalizer;

    /** @throws Exception */
    public function __construct(
        private readonly PlatformParserInterface $platformParser,
        NormalizerFactory $normalizerFactory,
    ) {
        $this->normalizer = $normalizerFactory->build();
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function hasPlatformCode(string $value): bool
    {
        return true;
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getPlatformCode(string $value, string | null $derivate = null): string | null
    {
        $normalizedValue = $this->normalizer->normalize($value);

        $matches = [];

        if (preg_match('/ov\((?P<platform>wds|android) (?:[\d_.]+)\);/i', $normalizedValue, $matches)) {
            $code = mb_strtolower($matches['platform']);

            return match ($code) {
                'wds' => 'windows phone',
                default => 'android',
            };
        }

        if (preg_match('/pf\((?P<platform>[^)]+)\);/', $normalizedValue, $matches)) {
            $code = mb_strtolower($matches['platform']);

            return match ($code) {
                'symbian', 'java' => $code,
                'windows' => 'windows phone',
                '42', '44' => 'ios',
                'linux' => 'android',
                default => null,
            };
        }

        $code = $this->platformParser->parse($normalizedValue);

        if ($code === '') {
            return null;
        }

        return $code;
    }
}
