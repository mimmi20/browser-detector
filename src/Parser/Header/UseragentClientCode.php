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

use function array_filter;
use function array_map;
use function mb_strtolower;
use function preg_match;
use function reset;

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

        $regexes = [
            '/pr\((?P<client>ucbrowser)(?:\/[\d.]+)?\);/i',
            '/mozilla\/[\d.]+ \(mobile; [^;]+(?:;android)?; rv:[^)]+\) gecko\/[\d.]+ (?P<client>firefox)\/[\d.]+ kaios\/[\d.]+/i',
        ];

        $filtered = array_filter(
            $regexes,
            static fn (string $regex): bool => (bool) preg_match($regex, $normalizedValue),
        );

        $results = array_map(
            static function (string $regex) use ($normalizedValue): string {
                $matches = [];

                preg_match($regex, $normalizedValue, $matches);

                return mb_strtolower($matches['client'] ?? '');
            },
            $filtered,
        );

        $code = reset($results);

        if ($code !== null && $code !== false && $code !== '') {
            return $code;
        }

        if (
            preg_match(
                '/(?P<client>instagram) [\d.]+ android \([\d.]+\/[\d.]+; \d+dpi; \d+x\d+; [a-z\/]+; [^);\/]+;/i',
                $normalizedValue,
                $matches,
            )
        ) {
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
