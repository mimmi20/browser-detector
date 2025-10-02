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

use BrowserDetector\Parser\Helper\DeviceInterface;
use Override;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\DeviceCodeInterface;
use UaParser\DeviceParserInterface;

use function array_filter;
use function array_map;
use function mb_strtolower;
use function preg_match;
use function reset;

final readonly class UseragentDeviceCode implements DeviceCodeInterface
{
    /** @throws void */
    public function __construct(
        private DeviceParserInterface $deviceParser,
        private NormalizerInterface $normalizer,
        private DeviceInterface $deviceCodeHelper,
    ) {
        // nothing to do
    }

    /**
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function hasDeviceCode(string $value): bool
    {
        return true;
    }

    /**
     * @return non-empty-string|null
     *
     * @throws void
     */
    #[Override]
    public function getDeviceCode(string $value): string | null
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
            '/^mozilla\/[\d.]+ \(linux;(?: arm(?:_64)?;)? (?:andr[o0]id|tizen) [\d.]+;(?: arm(?:_64)?;)? (?P<devicecode>[^);\/]+)(?:(?:\/[^ ]+)? +(?:build|hmscore))[^)]+\)/i',
            '/^mozilla\/[\d.]+ \(linux;(?: arm(?:_64)?;)? (?:andr[o0]id|tizen) [\d.]+;(?: arm(?:_64)?;)? (?P<devicecode>[^);\/]+)[^)]*\)/i',
            '/(?:androiddownloadmanager|mozilla|com\.[^\/]+)\/[\d.]+ \(linux; (?:(?:andr[o0]id|tizen) [\d.]+;(?: harmonyos;)?) (?P<devicecode>[^);\/]+)(?:;? +(?:build|hmscore))[^)]+\)/i',
            '/(?:androiddownloadmanager|mozilla|com\.[^\/]+)\/[\d.]+ \(linux; (?:(?:andr[o0]id|tizen) [\d.]+;(?: harmonyos;)?) (?P<devicecode>[^);\/]+)[^)]*\)/i',
            '/dalvik\/[\d.]+ \(linux; (?:andr[o0]id [\d.]+;) (?P<devicecode>[^);\/]+)(?:;? +(?:build|hmscore|miui)[^)]+)\)/i',
            '/ucweb\/[\d.]+ \((?:midp-2\.0|linux); (?:adr [\d.]+;) (?P<devicecode>[^);\/]+)(?:[^)]+)?\)/i',
            '/;fbdv\/(?P<devicecode>[^);\/]+);/i',
            '/slack\/[\d.]+ \((?P<devicecode>[^);\/]+)(?:;? (?:andr[o0]id|tizen) [\d.]+)(?:[^)]+)?\)/i',
            '/instagram [\d.]+ android \([\d.]+\/[\d.]+; \d+dpi; \d+x\d+; [a-z\/]+; (?P<devicecode>[^);\/]+);/i',
        ];

        $filtered = array_filter(
            $regexes,
            static fn (string $regex): bool => (bool) preg_match($regex, $normalizedValue),
        );

        $results = array_map(
            function (string $regex) use ($normalizedValue): string | null {
                $matches = [];

                preg_match($regex, $normalizedValue, $matches);

                return $this->deviceCodeHelper->getDeviceCode(
                    mb_strtolower($matches['devicecode'] ?? ''),
                );
            },
            $filtered,
        );

        $code = reset($results);

        if ($code !== null && $code !== false) {
            return $code;
        }

        $matches = [];

        if (
            preg_match(
                '/dv\((?P<devicecode>[^);\/]+)(?:;? +(?:build|hmscore|miui)?[^)]+)?\);/',
                $normalizedValue,
                $matches,
            )
        ) {
            $code = $this->deviceCodeHelper->getDeviceCode(mb_strtolower($matches['devicecode']));

            if ($code !== null) {
                return $code;
            }

            $code = $this->deviceParser->parse($matches['devicecode']);

            if ($code !== '') {
                return $code;
            }
        }

        $code = $this->deviceParser->parse($normalizedValue);

        if ($code === '') {
            return null;
        }

        return $code;
    }
}
