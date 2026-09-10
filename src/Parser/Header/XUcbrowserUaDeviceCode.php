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
use UaParser\DeviceCodeInterface;
use UaParser\DeviceParserInterface;

use function is_string;
use function mb_strtolower;
use function mb_trim;
use function preg_match;

final readonly class XUcbrowserUaDeviceCode implements DeviceCodeInterface
{
    use AutoUpdateDeviceDataTrait;

    /** @throws void */
    public function __construct(
        private DeviceParserInterface $deviceParser,
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

        $find = $matches['device']
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

        $code = $this->deviceParser->parse($matches['device']);

        if ($code === '') {
            return null;
        }

        if ($this->autoUpdate) {
            $this->saveToMappingJson($find, $code);
        }

        return $code;
    }
}
