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

use BrowserDetector\Parser\Helper\DeviceInterface;
use Override;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\DeviceCodeInterface;
use UaParser\DeviceParserInterface;

use function array_filter;
use function array_first;
use function array_key_exists;
use function array_map;
use function mb_strtolower;
use function mb_trim;
use function preg_match;

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
        if (preg_match('/Android \d+; [A-Za-z0-9]{10}; U; [^;)]*\) AppleWebKit\/.+Chrome\//', $value)) {
            return 'unknown=general mobile phone';
        }

        try {
            $normalizedValue = $this->normalizer->normalize($value);
        } catch (Exception) {
            return null;
        }

        if ($normalizedValue === '' || $normalizedValue === null) {
            return null;
        }

        $matches = [];

        if (
            preg_match('/^WhatsApp\/[0-9.]+ (?P<code>[AWi])$/', $normalizedValue, $matches)
            && array_key_exists('code', $matches)
        ) {
            return match ($matches['code']) {
                'W' => 'unknown=windows desktop',
                'i' => 'apple=general apple device',
                default => 'unknown=general mobile phone',
            };
        }

        $regexes = [
            '/^mozilla\/[\d.]+ \((?:andr[o0]id|tizen) [\d.]+;(?: arm(?:_64)?;| harmonyos;)? (?P<devicecode>[^);\/]+)(?:(?:\/[^ ]+)? +(?:build|hmscore))[^)]+\)/i',
            '/^mozilla\/[\d.]+ \((?:andr[o0]id|tizen) [\d.]+;(?: arm(?:_64)?;| harmonyos;)? (?P<devicecode>[^);\/]+)[^)]*\)/i',
            '/^mozilla\/[\d.]+ \((linux|andr[o0]id);(?: arm(?:_64)?;)? (?:andr[o0]id|tizen) [\d.]+;(?: arm(?:_64)?;| harmonyos;)? (?P<devicecode>[^);\/]+)(?:(?:\/[^ ]+)? +(?:build|hmscore))[^)]+\)/i',
            '/^mozilla\/[\d.]+ \((linux|andr[o0]id);(?: arm(?:_64)?;)? (?:andr[o0]id|tizen) [\d.]+;(?: arm(?:_64)?;| harmonyos;)? (?P<devicecode>[^);\/]+)[^)]*\)/i',
            '/(?:androiddownloadmanager|mozilla|com\.[^\/]+|kodi|androidhttpclient)\/[\d.]+ \(linux; (?:(?:andr[o0]id|tizen) [\d.]+;(?: harmonyos;)?) (?P<devicecode>[^);\/]+)(?:;? +(?:build|hmscore))[^)]+\)/i',
            '/(?:androiddownloadmanager|mozilla|com\.[^\/]+|kodi|androidhttpclient)\/[\d.]+ \(linux; (?:(?:andr[o0]id|tizen) [\d.]+;(?: harmonyos;)?) (?P<devicecode>[^);\/]+)[^)]*\)/i',
            '/dalvik\/[\d.]+ \(linux; (?:andr[o0]id [\d.]+;) (?P<devicecode>[^);\/]+)(?:[);\/]?[^);\/]* +(?:build|hmscore|miui)[^)]+)\)/i',
            '/dalvik\/[\d.]+ \(linux; andr[o0]id [\d.]+\/viber [\d.]+ ; (?P<devicecode>[^);\/]+)[su]p1a/i',
            '/\(speedmode; proxy; android [\d.]+;(?P<devicecode>[^);\/]+)\)/i',
            '/ucweb\/[\d.]+ \((?:midp-2\.0|linux); (?:adr [\d.]+;) (?P<devicecode>[^);\/]+)(?:[^)]+)?\)/i',
            '/;fbdv\/(?P<devicecode>[^);\/]+);/i',
            '/slack\/[\d.]+ \((?P<devicecode>[^);\/]+)(?:;? (?:andr[o0]id|tizen) [\d.]+)(?:[^)]+)?\)/i',
            '/instagram [\d.]+ android \([\d.]+\/[\d.]+; \d+dpi; \d+x\d+; [a-z\/]+; (?P<devicecode>[^);\/]+);/i',
            '/icq_android\/[\d.]+ \(android; \d+; [\d.]+; [^;]+; (?P<devicecode>[^);\/]+)/i',
            '/gg-android\/[\d.]+ \(os;android;\d+\) \([^);\/]+;[^);\/]+;(?P<devicecode>[^);\/]+);[\d.]+/i',
            '/imoandroid\/[\d.]+; \d+; REL; (?P<devicecode>[^);\/]+)/i',
            '/tivimate\/[\d.]+ \((?P<devicecode>[^);\/]+);/i',
            '/; model: (?P<devicecode>[^);\/]+)\)/i',
            '/(lbc|heart)\/[\d.]+ andr[o0]id [\d.]+\/(?P<devicecode>[^);\/]+)/i',
            '/mozilla\/[\d.]+ \(mobile; (?P<devicecode>[^;]+)(?:;android)?; rv:[^)]+\) gecko\/[\d.]+ firefox\/[\d.]+ kaios\/[\d.]+/i',
            '/virgin radio\/[\d.]+ \/ \(linux; andr[o0]id [\d.]+\) exoplayerlib\/[\d.]+ \/ samsung \((?P<devicecode>[^)]+)\)/i',
            '/pugpigbolt [\d.]+ \([^);\/,]+, (android|ios) [\d.]+\) on phone \(model (?P<devicecode>[^)]+)\)/i',
            '/nrc audio\/[\d.]+ \(nl\.nrc\.audio; build:[\d.]+; andr[o0]id [\d.]+; sdk:[\d.]+; manufacturer:samsung; model: (?P<devicecode>[^)]+)\) okhttp\/[\d.]+/i',
            '/luminary\/[\d.]+ \(andr[o0]id [\d.]+; (?P<devicecode>[^);\/]+); /i',
            '/emaudioplayer [\d.]+ \([\d.]+\) \/ andr[o0]id [\d.]+ \/ (?P<devicecode>[^);\/]+)/i',
            '/andr[o0]id [\d.]+; (?P<devicecode>[^);\/]+)\) applewebkit/i',
            '/classic fm\/[\d.]+ andr[o0]id [\d.]+\/(?P<devicecode>[^);\/]+)/i',
            '/mozilla\/[\d.]+ \([\d.]+mb; [\d.]+x[\d.]+; [\d.]+x[\d.]+; [\d.]+x[\d.]+; (?P<devicecode>[^);\/]+); [\d.]+\) applewebkit/i',
            '/kodi\/[\d.]+ \(linux; andr[o0]id [\d.]+; (?P<devicecode>[^);\/]+)(?:[);\/]?[^);\/]* +(?:build|hmscore|miui)[^)]+)\)/i',
            '/androidhttpclient \(linux; (?:(?:andr[o0]id|tizen) [\d.]+;(?: harmonyos;)?) (?P<devicecode>[^);\/]+)(?:;? +(?:build|hmscore))[^)]+\)/i',
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
                    mb_trim(mb_strtolower($matches['devicecode'] ?? '')),
                );
            },
            $filtered,
        );

        $code = array_first($results);

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
