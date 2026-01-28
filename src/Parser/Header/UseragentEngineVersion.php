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
use BrowserDetector\Version\ForcedNullVersion;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionInterface;
use Deprecated;
use Override;
use UaData\EngineInterface;
use UaLoader\EngineLoaderInterface;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\EngineParserInterface;
use UaParser\EngineVersionInterface;
use UnexpectedValueException;

use function array_filter;
use function array_map;
use function mb_strtolower;
use function preg_match;
use function reset;

final readonly class UseragentEngineVersion implements EngineVersionInterface
{
    use SetVersionTrait;

    /** @throws void */
    public function __construct(
        private EngineParserInterface $engineParser,
        private EngineLoaderInterface $engineLoader,
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
    public function hasEngineVersion(string $value): bool
    {
        return true;
    }

    /** @throws void */
    #[Override]
    #[Deprecated(message: 'use getEngineVersionWithEngine() instead', since: '10.0.27')]
    public function getEngineVersion(string $value, string | null $code = null): VersionInterface
    {
        try {
            $engine = Engine::fromName((string) $code);
        } catch (UnexpectedValueException) {
            $engine = Engine::unknown;
        }

        return $this->getVersion($value, $engine);
    }

    /** @throws void */
    #[Override]
    public function getEngineVersionWithEngine(string $value, EngineInterface $engine): VersionInterface
    {
        return $this->getVersion($value, $engine);
    }

    /** @throws void */
    private function getVersion(string $value, EngineInterface $engine): VersionInterface
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
            '/(?<!o)re\([^\/]+\/(?P<version>[\d.]+)/i',
            '/mozilla\/[\d.]+ \(mobile; [^;]+(?:;android)?; rv:[^)]+\) gecko\/(?P<version>[\d.]+) firefox\/[\d.]+ kaios\/[\d.]+/i',
        ];

        $filtered = array_filter(
            $regexes,
            static fn (string $regex): bool => (bool) preg_match($regex, $normalizedValue),
        );

        $results = array_map(
            static function (string $regex) use ($normalizedValue): string {
                $matches = [];

                preg_match($regex, $normalizedValue, $matches);

                return mb_strtolower($matches['version'] ?? '');
            },
            $filtered,
        );

        $detectedVersion = reset($results);

        if ($detectedVersion !== null && $detectedVersion !== false && $detectedVersion !== '') {
            return $this->setVersion($detectedVersion);
        }

        if ($engine === Engine::unknown) {
            $engine = $this->engineParser->parse($normalizedValue);

            if ($engine === Engine::unknown) {
                return new ForcedNullVersion();
            }
        }

        try {
            $engineObj = $this->engineLoader->loadFromEngine($engine, $normalizedValue);
        } catch (UnexpectedValueException) {
            return new NullVersion();
        }

        try {
            $version = $engineObj->getVersion()->getVersion();
        } catch (UnexpectedValueException) {
            return new NullVersion();
        }

        if ($version === '' || $version === null) {
            return new NullVersion();
        }

        return $this->setVersion($version);
    }
}
