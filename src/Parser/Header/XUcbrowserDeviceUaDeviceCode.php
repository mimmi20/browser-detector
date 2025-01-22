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

use Override;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\DeviceCodeInterface;
use UaParser\DeviceParserInterface;

final readonly class XUcbrowserDeviceUaDeviceCode implements DeviceCodeInterface
{
    /** @throws void */
    public function __construct(private DeviceParserInterface $deviceParser, private NormalizerInterface $normalizer)
    {
        // nothing to do
    }

    /** @throws void */
    #[Override]
    public function hasDeviceCode(string $value): bool
    {
        return $value !== '?';
    }

    /** @throws void */
    #[Override]
    public function getDeviceCode(string $value): string | null
    {
        if ($value === '?') {
            return null;
        }

        try {
            $normalizedValue = $this->normalizer->normalize($value);
        } catch (Exception) {
            return null;
        }

        if ($normalizedValue === '' || $normalizedValue === null) {
            return null;
        }

        $code = $this->deviceParser->parse($normalizedValue);

        if ($code === '') {
            return null;
        }

        return $code;
    }
}
