<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Header;

use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Parser\BrowserParserInterface;
use BrowserDetector\Parser\DeviceParserInterface;
use BrowserDetector\Parser\EngineParserInterface;
use BrowserDetector\Parser\PlatformParserInterface;
use UaNormalizer\Normalizer\Exception;
use UaNormalizer\NormalizerFactory;
use UnexpectedValueException;

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
        try {
            $code = $this->browserParser->parse($this->normalizedValue);

            if ($code === '') {
                return null;
            }

            return $code;
        } catch (NotFoundException | UnexpectedValueException) {
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
    public function getClientVersion(): string | null
    {
        try {
            $code = $this->browserParser->parse($this->normalizedValue);

            if ($code === '') {
                return null;
            }
        } catch (NotFoundException | UnexpectedValueException) {
            return null;
        }

        try {
            [$browser] = $this->browserParser->load($code, $this->normalizedValue);
        } catch (NotFoundException | UnexpectedValueException) {
            return null;
        }

        return $browser['version'] ?? null;
    }

    /** @throws void */
    public function hasPlatformCode(): bool
    {
        return true;
    }

    /** @throws void */
    public function getPlatformCode(): string | null
    {
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
        if ($code === null) {
            $code = $this->platformParser->parse($this->normalizedValue);

            if ($code === '') {
                return null;
            }
        }

        try {
            $platform = $this->platformParser->load($code, $this->normalizedValue);
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
            $engine = $this->engineParser->load($code, $this->normalizedValue);
        } catch (NotFoundException | UnexpectedValueException) {
            return null;
        }

        return $engine['version'];
    }
}
