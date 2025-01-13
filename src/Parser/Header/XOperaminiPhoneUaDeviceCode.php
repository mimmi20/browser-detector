<?php

/**
 * This file is part of the mimmi20/ua-generic-request package.
 *
 * Copyright (c) 2015-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Parser\Header;

use Override;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaNormalizer\NormalizerFactory;
use UaParser\DeviceCodeInterface;
use UaParser\DeviceParserInterface;

use function preg_match;

final class XOperaminiPhoneUaDeviceCode implements DeviceCodeInterface
{
    private readonly NormalizerInterface $normalizer;

    /** @throws Exception */
    public function __construct(
        private readonly DeviceParserInterface $deviceParser,
        NormalizerFactory $normalizerFactory,
    ) {
        $this->normalizer = $normalizerFactory->build();
    }

    /** @throws void */
    #[Override]
    public function hasDeviceCode(string $value): bool
    {
        return (bool) preg_match(
            '/samsung|nokia|blackberry|smartfren|sprint|iphone|lava|gionee|philips|htc|pantech|lg|casio|zte|mi 2sc|sm-g900f|gt-i9000|gt-s5830i|sne-lx1/i',
            $value,
        );
    }

    /** @throws void */
    #[Override]
    public function getDeviceCode(string $value): string | null
    {
        $normalizedValue = $this->normalizer->normalize($value);

        $code = $this->deviceParser->parse($normalizedValue);

        if ($code === '') {
            return null;
        }

        return $code;
    }
}
