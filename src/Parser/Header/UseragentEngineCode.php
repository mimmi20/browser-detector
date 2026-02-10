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

use BrowserDetector\Data\Engine;
use Override;
use UaData\EngineInterface;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\EngineCodeInterface;
use UaParser\EngineParserInterface;
use UnexpectedValueException;

use function array_filter;
use function array_first;
use function array_map;
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
    public function getEngineCode(string $value): EngineInterface
    {
        try {
            $normalizedValue = $this->normalizer->normalize($value);
        } catch (Exception) {
            return Engine::unknown;
        }

        if ($normalizedValue === '' || $normalizedValue === null) {
            return Engine::unknown;
        }

        $regexes = [
            '/(?<!o)re\((?P<engine>[^\/)]+)(?:\/[\d.]+)?/i',
            '/mozilla\/[\d.]+ \(mobile; [^;]+(?:;android)?; rv:[^)]+\) (?P<engine>gecko)\/[\d.]+ firefox\/[\d.]+ kaios\/[\d.]+/i',
        ];

        $filtered = array_filter(
            $regexes,
            static fn (string $regex): bool => (bool) preg_match($regex, $normalizedValue),
        );

        $results = array_map(
            static function (string $regex) use ($normalizedValue): string {
                $matches = [];

                preg_match($regex, $normalizedValue, $matches);

                return mb_strtolower($matches['engine'] ?? '');
            },
            $filtered,
        );

        $code = array_first($results);

        if ($code !== null && $code !== false && $code !== '') {
            try {
                return Engine::fromName($code);
            } catch (UnexpectedValueException) {
                return Engine::unknown;
            }
        }

        return $this->engineParser->parse($normalizedValue);
    }
}
