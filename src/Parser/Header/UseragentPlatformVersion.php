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

use BrowserDetector\Data\Os;
use BrowserDetector\Version\ForcedNullVersion;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionInterface;
use Override;
use UaData\OsInterface;
use UaLoader\Exception\NotFoundException;
use UaLoader\PlatformLoaderInterface;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\PlatformParserInterface;
use UaParser\PlatformVersionInterface;
use UnexpectedValueException;

use function array_filter;
use function array_first;
use function array_map;
use function preg_match;
use function str_replace;

final readonly class UseragentPlatformVersion implements PlatformVersionInterface
{
    use SetVersionTrait;

    /** @throws void */
    public function __construct(
        private PlatformParserInterface $platformParser,
        private PlatformLoaderInterface $platformLoader,
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
    public function hasPlatformVersion(string $value): bool
    {
        return true;
    }

    /**
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function getPlatformVersionWithOs(string $value, OsInterface $os): VersionInterface
    {
        return $this->getVersion($value, $os);
    }

    /** @throws void */
    private function getVersion(string $value, OsInterface $os): VersionInterface
    {
        try {
            $normalizedValue = $this->normalizer->normalize($value);
        } catch (Exception) {
            return new ForcedNullVersion();
        }

        if ($normalizedValue === '' || $normalizedValue === null) {
            return new ForcedNullVersion();
        }

        if (preg_match('/^WhatsApp\/[0-9.]+ (?P<code>[AWi])$/', $normalizedValue)) {
            return new ForcedNullVersion();
        }

        if (
            preg_match('/android \d+ - /i', $normalizedValue)
            || preg_match('/news republic\/[\d.]+ \(linux; android \d+/i', $normalizedValue)
            || preg_match('/app : mozilla\/[\d.]+ \(linux; android \d+ ; \w+ \)/i', $normalizedValue)
            || preg_match('/mozilla\/[\d.]+ \(linux; android [\d.]+ ios;/i', $normalizedValue)
            || preg_match('/ \/ android \d+$/i', $normalizedValue)
            || preg_match('/wnyc app\/[\d.]+ android\/\d+ /i', $normalizedValue)
        ) {
            return new ForcedNullVersion();
        }

        $regexes = [
            '/ov\((?:(wds|android) )?(?P<version>[\d_.]+)\);/i',
            '/instagram [\d.]+ android \([\d.]+\/(?P<version>[\d.]+); \d+dpi; \d+x\d+; [a-z\/]+; [^);\/]+;/i',
            '/icq_android\/[\d.]+ \(android; \d+; (?P<version>[\d.]+)/i',
            '/gg-android\/[\d.]+ \(os;android;\d+\) \([^);\/]+;[^);\/]+;[^);\/]+;(?P<version>[\d.]+)/i',
            '/mozilla\/[\d.]+ \(mobile; [^;]+(?:;android)?; rv:[^)]+\) gecko\/[\d.]+ firefox\/[\d.]+ kaios\/(?P<version>[\d.]+)/i',
            '/virgin radio\/[\d.]+ \/ \(linux; android (?P<version>[\d.]+)\) exoplayerlib\/[\d.]+ \/ samsung \(/i',
            '/pugpigbolt [\d.]+ \([^);\/,]+, (android|ios) (?P<version>[\d.]+)\) on phone \(model [^)]+\)/i',
            '/nrc audio\/[\d.]+ \(nl\.nrc\.audio; build:[\d.]+; android (?P<version>[\d.]+); sdk:[\d.]+; manufacturer:samsung; model: [^)]+\) okhttp\/[\d.]+/i',
            '/luminary\/[\d.]+ \(android (?P<version>[\d.]+); [^);\/]+; /i',
            '/(lbc|heart)\/[\d.]+ android (?P<version>[\d.]+)\/[^);\/]+/i',
            '/emaudioplayer [\d.]+ \([\d.]+\) \/ android (?P<version>[\d.]+) \/ [^);\/]+/i',
            '/tivimate\/[\d.]+ \([^);\/]+; android (?P<version>[\d.]+)\)/i',
            '/classic fm\/[\d.]+ android (?P<version>[\d.]+)\/[^);\/]+/i',
        ];

        $filtered = array_filter(
            $regexes,
            static fn (string $regex): bool => (bool) preg_match($regex, $normalizedValue),
        );

        $results = array_map(
            static function (string $regex) use ($normalizedValue): string {
                $matches = [];

                preg_match($regex, $normalizedValue, $matches);

                return str_replace('_', '.', $matches['version'] ?? '');
            },
            $filtered,
        );

        $detectedVersion = array_first($results);

        if ($detectedVersion !== null && $detectedVersion !== '') {
            return $this->setVersion($detectedVersion);
        }

        if ($os === Os::unknown) {
            $os = $this->platformParser->parse($normalizedValue);

            if ($os === Os::unknown) {
                return new ForcedNullVersion();
            }
        }

        try {
            $platform = $this->platformLoader->loadFromOs($os, $normalizedValue);
        } catch (NotFoundException) {
            return new NullVersion();
        }

        try {
            $version = $platform->getVersion()->getVersion();
        } catch (UnexpectedValueException) {
            return new NullVersion();
        }

        if ($version === '' || $version === null) {
            return new NullVersion();
        }

        return $this->setVersion($version);
    }
}
