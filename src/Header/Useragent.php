<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Header;

use BrowserDetector\Loader\BrowserLoaderInterface;
use BrowserDetector\Loader\EngineLoaderInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Loader\PlatformLoaderInterface;
use BrowserDetector\Parser\BrowserParserInterface;
use BrowserDetector\Parser\DeviceParserInterface;
use BrowserDetector\Parser\EngineParserInterface;
use BrowserDetector\Parser\PlatformParserInterface;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\NormalizerFactory;
use UnexpectedValueException;

use function mb_strtolower;
use function preg_match;
use function str_replace;

final class Useragent implements HeaderInterface
{
    use HeaderTrait;

    private readonly string $normalizedValue;

    /** @throws Exception */
    public function __construct(
        string $value,
        private readonly DeviceParserInterface $deviceParser,
        private readonly PlatformParserInterface $platformParser,
        private readonly BrowserParserInterface $browserParser,
        private readonly EngineParserInterface $engineParser,
        private readonly NormalizerFactory $normalizerFactory,
        private readonly BrowserLoaderInterface $browserLoader,
        private readonly PlatformLoaderInterface $platformLoader,
        private readonly EngineLoaderInterface $engineLoader,
    ) {
        $this->value = $value;

        $normalizer = $this->normalizerFactory->build();

        $this->normalizedValue = $normalizer->normalize($value);
    }

    /**
     * Retrieve normalized header value
     *
     * @throws void
     */
    public function getNormalizedValue(): string
    {
        return $this->normalizedValue;
    }

    /** @throws void */
    public function hasDeviceCode(): bool
    {
        return true;
    }

    /** @throws void */
    public function getDeviceCode(): string | null
    {
        $matches = [];

        if (preg_match('/dv\((?P<device>[^)]+)\);/', $this->value, $matches)) {
            $code = $this->deviceParser->parse($matches['device']);

            if ($code !== '') {
                return $code;
            }
        }

        $code = $this->deviceParser->parse($this->normalizedValue);

        if ($code === '') {
            return null;
        }

        return $code;
    }

    /** @throws void */
    public function hasClientCode(): bool
    {
        return true;
    }

    /** @throws void */
    public function getClientCode(): string | null
    {
        $matches = [];

        if (preg_match('/pr\((?P<client>[^\/)]+)(?:\/[\d.]+)?\);/', $this->value, $matches)) {
            $code = mb_strtolower($matches['client']);

            if ($code === 'ucbrowser') {
                return $code;
            }
        }

        try {
            $code = $this->browserParser->parse($this->normalizedValue);

            if ($code === '') {
                return null;
            }

            return $code;
        } catch (UnexpectedValueException) {
            // do nothing
        }

        return null;
    }

    /** @throws void */
    public function hasClientVersion(): bool
    {
        return true;
    }

    /** @throws void */
    public function getClientVersion(string | null $code = null): string | null
    {
        $matches = [];

        if (preg_match('/pr\([^\/]+\/(?P<version>[\d.]+)\);/', $this->value, $matches)) {
            return $matches['version'];
        }

        if ($code === null) {
            try {
                $code = $this->browserParser->parse($this->normalizedValue);

                if ($code === '') {
                    return null;
                }
            } catch (UnexpectedValueException) {
                return null;
            }
        }

        try {
            [$browser] = $this->browserLoader->load($code, $this->normalizedValue);
        } catch (UnexpectedValueException) {
            return null;
        }

        return $browser['version'] ?? null;
    }

    /** @throws void */
    public function hasPlatformCode(): bool
    {
        return true;
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function getPlatformCode(string | null $derivate = null): string | null
    {
        $matches = [];

        if (preg_match('/pf\((?P<platform>[^)]+)\);/', $this->value, $matches)) {
            $code = mb_strtolower($matches['platform']);

            return match ($code) {
                'symbian', 'java' => $code,
                'windows' => 'windows phone',
                '42', '44' => 'ios',
                'linux' => 'android',
                default => null,
            };
        }

        $code = $this->platformParser->parse($this->normalizedValue);

        if ($code === '') {
            return null;
        }

        return $code;
    }

    /** @throws void */
    public function hasPlatformVersion(): bool
    {
        return true;
    }

    /** @throws void */
    public function getPlatformVersion(string | null $code = null): string | null
    {
        $matches = [];

        if (preg_match('/ov\((?:(wds|android) )?(?P<version>[\d_.]+)\);/i', $this->value, $matches)) {
            return str_replace('_', '.', $matches['version']);
        }

        if ($code === null) {
            $code = $this->platformParser->parse($this->normalizedValue);

            if ($code === '') {
                return null;
            }
        }

        try {
            $platform = $this->platformLoader->load($code, $this->normalizedValue);
        } catch (NotFoundException | UnexpectedValueException) {
            return null;
        }

        return $platform['version'] ?? null;
    }

    /** @throws void */
    public function hasEngineCode(): bool
    {
        return true;
    }

    /** @throws void */
    public function getEngineCode(): string | null
    {
        $code = $this->engineParser->parse($this->normalizedValue);

        if ($code === '') {
            return null;
        }

        return $code;
    }

    /** @throws void */
    public function hasEngineVersion(): bool
    {
        return true;
    }

    /** @throws void */
    public function getEngineVersion(string | null $code = null): string | null
    {
        if ($code === null) {
            $code = $this->engineParser->parse($this->normalizedValue);

            if ($code === '') {
                return null;
            }
        }

        try {
            $engine = $this->engineLoader->load($code, $this->normalizedValue);
        } catch (NotFoundException | UnexpectedValueException) {
            return null;
        }

        return $engine['version'] ?? null;
    }
}
