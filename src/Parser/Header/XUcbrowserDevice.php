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

use BrowserDetector\Iterator\FilterIterator;
use BrowserDetector\Parser\Helper\DeviceInterface;
use CallbackFilterIterator;
use JsonException;
use Override;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\DeviceCodeInterface;
use UaParser\DeviceParserInterface;
use UnexpectedValueException;

use function array_filter;
use function array_key_exists;
use function assert;
use function explode;
use function file_exists;
use function file_get_contents;
use function file_put_contents;
use function in_array;
use function is_array;
use function is_string;
use function json_decode;
use function json_encode;
use function mb_strtolower;
use function mb_trim;
use function sprintf;
use function str_contains;
use function str_replace;

use const JSON_PRETTY_PRINT;
use const JSON_THROW_ON_ERROR;
use const PHP_EOL;

final readonly class XUcbrowserDevice implements DeviceCodeInterface
{
    /** @throws void */
    public function __construct(
        private DeviceParserInterface $deviceParser,
        private NormalizerInterface $normalizer,
        private DeviceInterface $device,
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

        $code = $this->device->getDeviceCode(mb_strtolower($normalizedValue));

        if (is_string($code)) {
            $this->saveToMappingJson(mb_trim(mb_strtolower($normalizedValue)), $code);

            return $code;
        }

        $code = $this->deviceParser->parse($normalizedValue);

        if ($code === '') {
            return null;
        }

        return $code;
    }

    /** @throws void */
    private function saveToMappingJson(string $devicecode, string $code): void
    {
        if ($code === 'A369i' || $code === 'test-device-code') {
            return;
        }

        [$company] = explode('=', $code, 2);

        if ($company === '') {
            return;
        }

        $file = sprintf('data/device-mapping/%s.json', $company);

        $devicesFromMappingFile = [];

        if (file_exists($file)) {
            try {
                $devicesFromMappingFile = json_decode(
                    (string) file_get_contents($file),
                    associative: true,
                    flags: JSON_THROW_ON_ERROR,
                );
            } catch (JsonException) {
                // do nothing
            }
        }

        if (!is_array($devicesFromMappingFile)) {
            return;
        }

        if (array_key_exists($devicecode, $devicesFromMappingFile)) {
            $this->deleteFromFactories($company, $code);

            return;
        }

        $devicesFromMappingFile[$devicecode] = $code;

        try {
            file_put_contents(
                $file,
                json_encode(
                    $devicesFromMappingFile,
                    JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT,
                ) . PHP_EOL,
            );
        } catch (JsonException) {
            return;
        }

        $this->deleteFromFactories($company, $code);
    }

    /** @throws void */
    private function deleteFromFactories(string $company, string $code): void
    {
        try {
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator('../../../data/factories'),
            );
        } catch (UnexpectedValueException) {
            return;
        }

        $files = new FilterIterator($iterator, 'json');
        $files = new CallbackFilterIterator(
            $files,
            static fn (SplFileInfo $current): bool => str_contains(
                $current->getPathname(),
                $company,
            ),
        );

        foreach ($files as $file) {
            assert($file instanceof SplFileInfo);

            $pathName = $file->getPathname();
            $filepath = str_replace('\\', '/', $pathName);
            assert(is_string($filepath));

            $content = @file_get_contents($filepath);

            assert($content === false || is_string($content));

            if ($content === false) {
                continue;
            }

            try {
                $fileData = json_decode($content, associative: true, flags: JSON_THROW_ON_ERROR);
            } catch (JsonException) {
                continue;
            }

            assert(is_array($fileData));

            $newFileData = array_filter(
                $fileData,
                static fn (mixed $v): bool => is_string($v) && $v !== $code,
            );

            try {
                file_put_contents(
                    $filepath,
                    json_encode(
                        $newFileData,
                        JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT,
                    ) . PHP_EOL,
                );
            } catch (JsonException) {
                // do nothing
            }
        }
    }
}
