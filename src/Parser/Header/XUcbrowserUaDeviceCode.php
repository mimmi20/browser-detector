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
use Override;
use UaParser\DeviceCodeInterface;
use UaParser\DeviceParserInterface;

use function mb_strtolower;
use function preg_match;

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

    /**
     * @throws void
     */
    private function saveToMappingJson(string $devicecode, string $code): void
    {
        if ($code === 'A369i') {
            return;
        }
        [$company] = explode('=', $code, 2);

        $file = sprintf('data/device-mapping/%s.json', $company);

        $devicesFromMappingFile = [];

        if (file_exists($file)) {
            try {
                $devicesFromMappingFile = json_decode((string)file_get_contents($file), true, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException) {
                // do nothing
            }
        }

        if (!array_key_exists($devicecode, $devicesFromMappingFile)) {
            $devicesFromMappingFile[$devicecode] = $code;

            try {
                file_put_contents($file, json_encode($devicesFromMappingFile, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT) . PHP_EOL);
            } catch (\JsonException) {
                // do nothing
            }
        }
    }
}
