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
use UaParser\EngineCodeInterface;
use UaParser\EngineParserInterface;

use function preg_match;

final class XOperaminiPhoneUaEngineCode implements EngineCodeInterface
{
    private readonly NormalizerInterface $normalizer;

    /** @throws Exception */
    public function __construct(
        private readonly EngineParserInterface $engineParser,
        NormalizerFactory $normalizerFactory,
    ) {
        $this->normalizer = $normalizerFactory->build();
    }

    /** @throws void */
    #[Override]
    public function hasEngineCode(string $value): bool
    {
        return (bool) preg_match('/trident|presto|webkit|gecko/i', $value);
    }

    /** @throws void */
    #[Override]
    public function getEngineCode(string $value): string | null
    {
        $normalizedValue = $this->normalizer->normalize($value);

        $code = $this->engineParser->parse($normalizedValue);

        if ($code === '') {
            return null;
        }

        return $code;
    }
}
