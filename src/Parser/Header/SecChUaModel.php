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
use BrowserDetector\Parser\Helper\Device;
use CallbackFilterIterator;
use JsonException;
use Override;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;
use SplFileInfo;
use UaParser\DeviceCodeInterface;
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

/** @phpcs:disable SlevomatCodingStandard.Classes.ClassLength.ClassTooLong */
final readonly class SecChUaModel implements DeviceCodeInterface
{
    /** @throws void */
    public function __construct(private Device $device)
    {
        // nothing to do
    }

    /** @throws void */
    #[Override]
    public function hasDeviceCode(string $value): bool
    {
        $value = mb_trim($value, '"\\\'');
        $code  = mb_strtolower($value);

        return !in_array(
            $code,
            ['', 'model', ': ', 'some unknown model', 'k', 'android'],
            strict: true,
        );
    }

    /**
     * @return non-empty-string|null
     *
     * @throws RuntimeException
     */
    #[Override]
    public function getDeviceCode(string $value): string | null
    {
        $value = mb_trim($value, '"\\\'');
        $code  = mb_strtolower($value);

        return match ($code) {
            // special case
            'a065' => 'nothing-phone=nothing-phone a065',
            's61' => 'doogee=doogee s61',
            's200' => 'doogee=doogee s200',
            'p50' => 'cubot=cubot p50',
            default => $this->getCode($code),
        };
    }

    /**
     * @return non-empty-string|null
     *
     * @throws RuntimeException
     */
    private function getCode(string $code): string | null
    {
        $devicecode = $this->device->getDeviceCode($code);

        if ($devicecode !== null) {
            $this->saveToMappingJson($code, $devicecode);
        }

        return $devicecode;
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
            echo "\n\t", 'Could not find factories';
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
                echo "\n\t", 'Could not read file ', $filepath;
                continue;
            }

            try {
                $fileData = json_decode($content, associative: true, flags: JSON_THROW_ON_ERROR);
            } catch (JsonException) {
                echo "\n\t", 'Could not decode file ', $filepath;
                continue;
            }

            assert(is_array($fileData));

            $newFileData = [
                'rules' => array_filter(
                    $fileData['rules'] ?? [],
                    static fn (mixed $v): bool => is_string($v) && $v !== $code,
                ),
                'generic' => $fileData['generic'],
            ];

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
