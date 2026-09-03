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

use BrowserDetector\Parser\Helper\DeviceInterface;
use JsonException;
use Override;
use UaParser\DeviceCodeInterface;
use UaParser\DeviceParserInterface;

use function array_key_exists;
use function explode;
use function file_exists;
use function file_get_contents;
use function file_put_contents;
use function is_array;
use function is_string;
use function json_decode;
use function json_encode;
use function mb_strtolower;
use function mb_trim;
use function preg_match;
use function sprintf;

use const JSON_PRETTY_PRINT;
use const JSON_THROW_ON_ERROR;
use const PHP_EOL;

final readonly class XUcbrowserUaDeviceCode implements DeviceCodeInterface
{
    /** @throws void */
    public function __construct(private DeviceParserInterface $deviceParser, private DeviceInterface $device)
    {
        // nothing to do
    }

    /** @throws void */
    #[Override]
    public function hasDeviceCode(string $value): bool
    {
        $matches = [];

        if (!preg_match('/dv\((?P<device>[^)]+)\);/', $value, $matches)) {
            return false;
        }

        return $matches['device'] !== 'j2me' && $matches['device'] !== 'Opera';
    }

    /** @throws void */
    #[Override]
    public function getDeviceCode(string $value): string | null
    {
        $matches = [];

        if (!preg_match('/dv\((?P<device>[^)]+)\);/', $value, $matches)) {
            return null;
        }

        if ($matches['device'] === 'j2me' || $matches['device'] === 'Opera') {
            return null;
        }

        $code = $this->device->getDeviceCode(mb_strtolower($matches['device']));

        if (is_string($code)) {
            $this->saveToMappingJson(mb_trim(mb_strtolower($matches['device'])), $code);

            return $code;
        }

        $code = $this->deviceParser->parse($matches['device']);

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
