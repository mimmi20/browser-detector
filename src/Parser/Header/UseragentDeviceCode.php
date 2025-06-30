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

use BrowserDetector\Parser\Helper\Device;
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
    public function __construct(private DeviceParserInterface $deviceParser, private NormalizerInterface $normalizer)
    {
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

        $deviceCodeHelper = new Device();
        $matches          = [];

        if (
            preg_match(
                '/^mozilla\/5\.0 \(linux; arm_64; android [\d.]+; (?P<devicecode>[^)]+)\) applewebkit\/[\d.]+ \(khtml, like gecko\) .*$/i',
                $normalizedValue,
                $matches,
            )
        ) {
            $code = $deviceCodeHelper->getDeviceCode(mb_strtolower($matches['devicecode']));

            if ($code !== '' && $code !== null) {
                return $code;
            }
        }

        $matches = [];

        if (
            preg_match(
                '/^mozilla\/5\.0 \(linux; (?:android [\d.]+;(?: harmonyos;)?) (?P<devicecode>[^);]+)(?:;? +(?:build\/|hmscore)[^)]+)\) applewebkit\/[\d.]+ \(khtml, like gecko\) .*$/i',
                $normalizedValue,
                $matches,
            )
        ) {
            $code = $deviceCodeHelper->getDeviceCode(mb_strtolower($matches['devicecode']));

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
