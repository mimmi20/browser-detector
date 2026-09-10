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

namespace BrowserDetector\Loader\Data;

use BrowserDetector\Iterator\FilterIterator;
use BrowserDetector\Loader\InitData\Device as DataDevice;
use Laminas\Hydrator\Strategy\StrategyInterface;
use Override;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;
use SplFileInfo;

use Symfony\Component\Yaml\Yaml;
use UaDeviceType\Type;
use UaResult\Bits\Bits;
use UaResult\Device\Architecture;
use UaResult\Device\Display;
use function array_key_exists;
use function assert;
use function file_get_contents;
use function is_array;
use function is_string;
use function sprintf;
use function str_replace;

final class Device implements DataInterface
{
    private const string DATA_PATH = __DIR__ . '/../../../data/devices/';

    /** @var array<string, DataDevice> */
    private array $items      = [];
    private bool $initialized = false;

    /** @throws void */
    public function __construct(private readonly string $company)
    {
        // nothing to do
    }

    /** @throws RuntimeException */
    #[Override]
    public function init(): void
    {
        if ($this->initialized) {
            return;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(self::DATA_PATH . $this->company),
        );
        $files    = new FilterIterator($iterator, 'yaml');

        foreach ($files as $file) {
            assert($file instanceof SplFileInfo);

            $pathName = $file->getPathname();
            $filepath = str_replace('\\', '/', $pathName);
            assert(is_string($filepath));

            $fileData = Yaml::parseFile($filepath);

            assert(is_array($fileData));

            foreach ($fileData as $key => $data) {
                $stringKey = (string) $key;

                if (array_key_exists($stringKey, $this->items)) {
                    continue;
                }

                $this->items[$stringKey] = new DataDevice(
                    architecture: Architecture::from($data['architecture'] ?? ''),
                    deviceName: $data['deviceName'],
                    marketingName: $data['marketingName'],
                    manufacturer: $data['manufacturer'],
                    brand: $data['brand'],
                    type: Type::from($data['type'] ?? ''),
                    display: $data['display'],
                    dualOrientation: $data['dualOrientation'],
                    simCount: $data['simCount'],
                    bits: Bits::from($data['bits'] ?? 0),
                    platform: $data['platform'],
                );
            }
        }

        $this->initialized = true;
    }

    /** @throws void */
    #[Override]
    public function getItem(string $stringKey): DataDevice | null
    {
        return $this->items[$stringKey] ?? null;
    }
}
