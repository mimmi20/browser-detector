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
use UaParser\BrowserParserInterface;
use UaParser\ClientCodeInterface;
use UnexpectedValueException;

use function mb_strtolower;
use function preg_match;

final readonly class UseragentClientCode implements ClientCodeInterface
{
    /** @throws void */
    public function __construct(private BrowserParserInterface $browserParser, private NormalizerInterface $normalizer)
    {
        // nothing to do
    }

    /**
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function hasClientCode(string $value): bool
    {
        return true;
    }

    /**
     * @return non-empty-string|null
     *
     * @throws void
     */
    #[Override]
    public function getClientCode(string $value): string | null
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

        if (preg_match('/pr\((?P<client>[^\/)]+)(?:\/[\d.]+)?\);/', $normalizedValue, $matches)) {
            $code = mb_strtolower($matches['client']);

            if ($code === 'ucbrowser') {
                return $code;
            }
        }

        if (preg_match('/(?P<client>instagram) [\d.]+ android \([\d.]+\/[\d.]+; \d+dpi; \d+x\d+; [a-z\/]+; [^);\/]+;/i', $normalizedValue, $matches)) {
            return 'instagram app';
        }

        try {
            $code = $this->browserParser->parse($normalizedValue);

            if ($code === '') {
                return null;
            }

            return $code;
        } catch (UnexpectedValueException) {
            // do nothing
        }

        return null;
    }
}
