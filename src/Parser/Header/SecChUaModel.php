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

use BrowserDetector\Parser\Helper\Device;
use JsonException;
use Override;
use RuntimeException;
use UaParser\DeviceCodeInterface;

use function array_key_exists;
use function explode;
use function file_exists;
use function file_get_contents;
use function file_put_contents;
use function in_array;
use function is_array;
use function json_decode;
use function json_encode;
use function mb_strtolower;
use function mb_trim;
use function sprintf;

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

        if (
            !is_array($devicesFromMappingFile) || array_key_exists($devicecode, $devicesFromMappingFile)
        ) {
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
            // do nothing
        }
    }
}
