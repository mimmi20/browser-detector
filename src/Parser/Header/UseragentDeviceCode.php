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

use function mb_strtolower;
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
            preg_match(
                '/^mozilla\/[\d.]+ \(linux;(?: arm(?:_64)?;)? (?:android|tizen) [\d.]+; (?P<devicecode>[^);\/]+)(?:[^)]+)?\) applewebkit\/[\d.]+ \(khtml, like gecko\)/i',
                $normalizedValue,
                $matches,
            )
        ) {
            $code = $this->deviceCodeHelper->getDeviceCode(mb_strtolower($matches['devicecode']));

            if ($code !== '' && $code !== null) {
                return $code;
            }
        }

        $matches = [];

        if (
            preg_match(
                '/^(?:androiddownloadmanager|mozilla|com\.[^\/]+)\/[\d.]+ \(linux; (?:(?:android|tizen) [\d.]+;(?: harmonyos;)?) (?P<devicecode>[^);]+)(?:;? +(?:build|hmscore)[^)]+)\)/i',
                $normalizedValue,
                $matches,
            )
        ) {
            $code = $this->deviceCodeHelper->getDeviceCode(mb_strtolower($matches['devicecode']));

            if ($code !== '' && $code !== null) {
                return $code;
            }
        }

        $matches = [];

        if (
            preg_match(
                '/dalvik\/[\d.]+ \(linux; (?:android [\d.]+;) (?P<devicecode>[^);]+)(?:;? +(?:build|hmscore|miui)[^)]+)\)/i',
                $normalizedValue,
                $matches,
            )
        ) {
            $code = $this->deviceCodeHelper->getDeviceCode(mb_strtolower($matches['devicecode']));

            if ($code !== '' && $code !== null) {
                return $code;
            }
        }

        $matches = [];

        if (
            preg_match(
                '/ucweb\/[\d.]+ \((?:midp-2\.0|linux); (?:adr [\d.]+;) (?P<devicecode>[^);]+)(?:[^)]+)?\)/i',
                $normalizedValue,
                $matches,
            )
        ) {
            $code = $this->deviceCodeHelper->getDeviceCode(mb_strtolower($matches['devicecode']));

            if ($code !== '' && $code !== null) {
                return $code;
            }
        }

        $matches = [];

        if (preg_match('/dv\((?P<device>[^)]+)\);/', $normalizedValue, $matches)) {
            $code = $this->deviceParser->parse($matches['device']);

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
