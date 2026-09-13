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

use BrowserDetector\Loader\MappingfileLoaderInterface;
use Override;
use Psr\Log\LoggerInterface;
use RuntimeException;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\DeviceCodeInterface;
use UaParser\DeviceParserInterface;

use function in_array;
use function is_string;
use function mb_strtolower;
use function mb_trim;

final readonly class XUcbrowserDevice implements DeviceCodeInterface
{
    use AutoUpdateDeviceDataTrait;

    /** @throws void */
    public function __construct(
        private DeviceParserInterface $deviceParser,
        private NormalizerInterface $normalizer,
        private MappingfileLoaderInterface $mappingFileParser,
        private LoggerInterface $logger,
        private bool $autoUpdate = false,
    ) {
        // nothing to do
    }

    /** @throws void */
    #[Override]
    public function hasDeviceCode(string $value): bool
    {
        return !in_array(mb_strtolower($value), ['j2me', 'opera', 'jblend'], strict: true);
    }

    /** @throws void */
    #[Override]
    public function getDeviceCode(string $value): string | null
    {
        if (in_array(mb_strtolower($value), ['j2me', 'opera', 'jblend'], strict: true)) {
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

        $find = $normalizedValue
                |> mb_strtolower(...)
                |> mb_trim(...);

        try {
            $this->mappingFileParser->init();
        } catch (RuntimeException) {
            return null;
        }

        $code = $this->mappingFileParser->getItem($find);

        if (is_string($code)) {
            if ($this->autoUpdate) {
                $this->saveToMappingJson($find, $code);
            }

            return $code;
        }

        $code = $this->deviceParser->parse($normalizedValue);

        if ($code === '') {
            return null;
        }

        if ($this->autoUpdate) {
            $this->saveToMappingJson($find, $code);
        }

        return $code;
    }
}
