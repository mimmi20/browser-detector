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

use BrowserDetector\Parser\DeviceParserInterface;
use UaNormalizer\Normalizer\Exception;
use UaNormalizer\NormalizerFactory;

use function in_array;
use function mb_strtolower;

final class XUcbrowserDevice implements HeaderInterface
{
    use HeaderTrait;

    private readonly string $normalizedValue;

    /** @throws Exception */
    public function __construct(
        string $value,
        private readonly DeviceParserInterface $deviceParser,
        private readonly NormalizerFactory $normalizerFactory,
    ) {
        $this->value = $value;

        $normalizer = $this->normalizerFactory->build();

        $this->normalizedValue = $normalizer->normalize($value);
    }

    /** @throws void */
    public function hasDeviceCode(): bool
    {
        return !in_array(mb_strtolower($this->value), ['j2me', 'opera', 'jblend'], true);
    }

    /** @throws void */
    public function getDeviceCode(): string | null
    {
        if (in_array(mb_strtolower($this->value), ['j2me', 'opera', 'jblend'], true)) {
            return null;
        }

        $code = $this->deviceParser->parse($this->normalizedValue);

        if ($code === '') {
            return null;
        }

        return $code;
    }
}
