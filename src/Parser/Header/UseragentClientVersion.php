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

use BrowserDetector\Version\ForcedNullVersion;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionInterface;
use Override;
use UaLoader\BrowserLoaderInterface;
use UaLoader\Exception\NotFoundException;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\BrowserParserInterface;
use UaParser\ClientVersionInterface;
use UnexpectedValueException;

use function array_filter;
use function array_map;
use function preg_match;
use function reset;

final readonly class UseragentClientVersion implements ClientVersionInterface
{
    use SetVersionTrait;

    /** @throws void */
    public function __construct(
        private BrowserParserInterface $browserParser,
        private BrowserLoaderInterface $browserLoader,
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
    public function hasClientVersion(string $value): bool
    {
        return true;
    }

    /** @throws void */
    #[Override]
    public function getClientVersion(string $value, string | null $code = null): VersionInterface
    {
        try {
            $normalizedValue = $this->normalizer->normalize($value);
        } catch (Exception) {
            return new ForcedNullVersion();
        }

        if ($normalizedValue === '' || $normalizedValue === null) {
            return new ForcedNullVersion();
        }

        $regexes = [
            '/pr\([^\/]+\/(?P<version>[\d.]+)\);/i',
            '/instagram (?P<version>[\d.]+) android \([\d.]+\/[\d.]+; \d+dpi; \d+x\d+; [a-z\/]+; [^);\/]+;/i',
            '/mozilla\/[\d.]+ \(mobile; [^;]+(?:;android)?; rv:[^)]+\) gecko\/[\d.]+ firefox\/(?P<version>[\d.]+) kaios\/[\d.]+/i',
            '/virgin%20radio\\/(?P<version>[\d.]+) \\/ \\(linux; android [\d.]+\\) exoplayerlib\\/[\d.]+ \\/ samsung \\(/i',
            '/tivimate\/(?P<version>[\d.]+) \([^);\/]+;/i',
            '/pugpigbolt (?P<version>[\d.]+) \\([^);\/,]+, (android|ios) [\d.]+\\) on phone \\(model [^)]+\\)/i',
            '/nrc audio\\/(?P<version>[\d.]+) \\(nl\\.nrc\\.audio; build:[\d.]+; android [\d.]+; sdk:[\d.]+; manufacturer:samsung; model: [^)]+\\) okhttp\\/[\d.]+/i',
            '/luminary\\/(?P<version>[\d.]+) \\(android [\d.]+; [^);\/]+; /i',
            '/(lbc|heart)\/(?P<version>[\d.]+) android [\d.]+\/[^);\/]+/i',
            '/emaudioplayer (?P<version>[\d.]+) \([\d.]+\) \/ android [\d.]+ \/ [^);\/]+/i',
            '/classic fm\/(?P<version>[\d.]+) android [\d.]+\/[^);\/]+/i',
        ];

        $filtered = array_filter(
            $regexes,
            static fn (string $regex): bool => (bool) preg_match($regex, $normalizedValue),
        );

        $results = array_map(
            static function (string $regex) use ($normalizedValue): string {
                $matches = [];

                preg_match($regex, $normalizedValue, $matches);

                return $matches['version'] ?? '';
            },
            $filtered,
        );

        $detectedVersion = reset($results);

        if ($detectedVersion !== null && $detectedVersion !== false && $detectedVersion !== '') {
            return $this->setVersion($detectedVersion);
        }

        if ($code === null) {
            try {
                $code = $this->browserParser->parse($normalizedValue);

                if ($code === '') {
                    return new ForcedNullVersion();
                }
            } catch (UnexpectedValueException) {
                return new NullVersion();
            }
        }

        try {
            $clientData = $this->browserLoader->load($code, $normalizedValue);
        } catch (NotFoundException) {
            return new NullVersion();
        }

        try {
            $version = $clientData->getClient()->getVersion()->getVersion();
        } catch (UnexpectedValueException) {
            return new NullVersion();
        }

        if ($version === '' || $version === null) {
            return new NullVersion();
        }

        return $this->setVersion($version);
    }
}
