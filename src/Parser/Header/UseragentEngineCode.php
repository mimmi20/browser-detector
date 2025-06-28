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
use UaParser\EngineCodeInterface;
use UaParser\EngineParserInterface;

use function mb_strtolower;
use function preg_match;

final readonly class UseragentEngineCode implements EngineCodeInterface
{
    /** @throws void */
    public function __construct(private EngineParserInterface $engineParser, private NormalizerInterface $normalizer)
    {
        // nothing to do
    }

    /**
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function hasEngineCode(string $value): bool
    {
        return true;
    }

    /** @throws void */
    #[Override]
    public function getEngineCode(string $value): string | null
    {
        try {
            $normalizedValue = $this->normalizer->normalize($value);
        } catch (Exception) {
            return null;
        }

        if ($normalizedValue === '' || $normalizedValue === null) {
            return null;
        }

        $matches = [];

        if (preg_match('/(?<!o)re\((?P<engine>[^\/)]+)(?:\/[\d.]+)?/', $normalizedValue, $matches)) {
            $code = mb_strtolower($matches['engine']);

            return match ($code) {
                'applewebkit' => 'webkit',
                default => $code,
            };
        }

        $code = $this->engineParser->parse($normalizedValue);

        if ($code === '') {
            return null;
        }

        return $code;
    }
}
