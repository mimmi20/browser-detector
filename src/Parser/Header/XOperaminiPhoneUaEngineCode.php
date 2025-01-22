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

use function preg_match;

final readonly class XOperaminiPhoneUaEngineCode implements EngineCodeInterface
{
    /** @throws void */
    public function __construct(private EngineParserInterface $engineParser, private NormalizerInterface $normalizer)
    {
        // nothing to do
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
        try {
            $normalizedValue = $this->normalizer->normalize($value);
        } catch (Exception) {
            return null;
        }

        if ($normalizedValue === '' || $normalizedValue === null) {
            return null;
        }

        $code = $this->engineParser->parse($normalizedValue);

        if ($code === '') {
            return null;
        }

        return $code;
    }
}
