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
            '/(?P<client>instagram) [\d.]+ android \([\d.]+\/[\d.]+; \d+dpi; \d+x\d+; [a-z\/]+; [^);\/]+;/i',
            '/(?P<client>virgin%20radio)\/[\d.]+ \/ \(linux; android [\d.]+\) exoplayerlib\/[\d.]+ \/ samsung \(/i',
            '/(?P<client>tivimate)\/[\d.]+ \([^);\/]+;/i',
            '/(?P<client>pugpigbolt) [\d.]+ \([^);\/,]+, (android|ios) [\d.]+\) on phone \(model [^)]+\)/i',
            '/(?P<client>nrc audio)\/[\d.]+ \(nl\.nrc\.audio; build:[\d.]+; android [\d.]+; sdk:[\d.]+; manufacturer:samsung; model: [^)]+\) okhttp\/[\d.]+/i',
            '/(?P<client>luminary)\/[\d.]+ \(android [\d.]+; [^);\/]+; /i',
            '/(?P<client>lbc|heart)\/[\d.]+ android [\d.]+\/[^);\/]+/i',
            '/(?P<client>emaudioplayer) [\d.]+ \([\d.]+\) \/ android [\d.]+ \/ [^);\/]+/i',
            '/(?P<client>classic fm)\/[\d.]+ android [\d.]+\/[^);\/]+/i',
        ];

        $filtered = array_filter(
            $regexes,
            static fn (string $regex): bool => (bool) preg_match($regex, $normalizedValue),
        );

        $results = array_map(
            static function (string $regex) use ($normalizedValue): string {
                $matches = [];

                preg_match($regex, $normalizedValue, $matches);

                $client = mb_strtolower($matches['client'] ?? '');

                return match ($client) {
                    'instagram' => 'instagram app',
                    'virgin%20radio' => 'virgin-radio',
                    'tivimate' => 'tivimate-app',
                    'pugpigbolt' => 'pugpig-bolt',
                    'nrc audio' => 'nrc-audio',
                    'classic fm' => 'classic-fm',
                    default => $client,
                };
            },
            $filtered,
        );

        $code = reset($results);

        if ($code !== null && $code !== false && $code !== '') {
            return $code;
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
