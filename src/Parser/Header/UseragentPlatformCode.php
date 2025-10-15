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
use UaParser\PlatformCodeInterface;
use UaParser\PlatformParserInterface;

use function array_filter;
use function array_map;
use function mb_strtolower;
use function preg_match;
use function reset;

final readonly class UseragentPlatformCode implements PlatformCodeInterface
{
    /** @throws void */
    public function __construct(
        private PlatformParserInterface $platformParser,
        private NormalizerInterface $normalizer,
    ) {
        // nothing to do
    }

    /**
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function hasPlatformCode(string $value): bool
    {
        return true;
    }

    /**
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getPlatformCode(string $value, string | null $derivate = null): string | null
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

        $regexes = [
            '/instagram [\d.]+ (?P<platform>android) \([\d.]+\/[\d.]+; \d+dpi; \d+x\d+; [a-z\/]+; [^);\/]+;/i',
            '/icq_android\/[\d.]+ \((?P<platform>android); \d+; [\d.]+/i',
            '/gg-android\/[\d.]+ \(os;(?P<platform>android);\d+\) \([^);\/]+;[^);\/]+;[^);\/]+;[\d.]+/i',
            '/^(?P<platform>android) \d+ - /i',
            '/news republic\/[\d.]+ \(linux; (?P<platform>android) \d+/i',
            '/^app : mozilla\/[\d.]+ \(linux; (?P<platform>android) \d+ ; \w+ \)/i',
            '/mozilla\/[\d.]+ \(linux; (?P<platform>android) [\d.]+ ios;/i',
            '/ \/ (?P<platform>android) \d+$/i',
            '/wnyc app\/[\d.]+ (?P<platform>android)\/\d+ /i',
        ];

        $filtered = array_filter(
            $regexes,
            static fn (string $regex): bool => (bool) preg_match($regex, $normalizedValue),
        );

        $results = array_map(
            static function (string $regex) use ($normalizedValue): string {
                $matches = [];

                preg_match($regex, $normalizedValue, $matches);

                // @todo: need to find a solution to find android forks like mocordroid
                return mb_strtolower($matches['platform'] ?? '');
            },
            $filtered,
        );

        $code = reset($results);

        if ($code !== null && $code !== false && $code !== '') {
            return $code;
        }

        $code = $this->platformParser->parse($normalizedValue);

        if ($code === '') {
            return null;
        }

        return $code;
    }
}
