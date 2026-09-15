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
use BrowserDetector\Loader\InitData\Client as DataClient;
use Override;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;
use UnexpectedValueException;

use function array_key_exists;
use function assert;
use function get_debug_type;
use function is_array;
use function is_string;
use function str_replace;

final class Client implements DataInterface
{
    private const string DATA_PATH = __DIR__ . '/../../../data/browsers';

    /** @var array<string, DataClient> */
    private array $items      = [];
    private bool $initialized = false;

    /** @throws void */
    public function __construct()
    {
        // nothing to do
    }

    /** @throws UnexpectedValueException */
    #[Override]
    public function init(): void
    {
        if ($this->initialized) {
            return;
        }

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(self::DATA_PATH));
        $files    = new FilterIterator($iterator, 'yaml');

        foreach ($files as $file) {
            assert($file instanceof SplFileInfo);

            $pathName = $file->getPathname();
            $filepath = str_replace('\\', '/', $pathName);
            assert(is_string($filepath));

            try {
                $fileData = Yaml::parseFile($filepath);
            } catch (ParseException) {
                continue;
            }

            if (!is_array($fileData)) {
                continue;
            }

            foreach ($fileData as $key => $data) {
                $stringKey = (string) $key;

                if (array_key_exists($stringKey, $this->items) || !is_array($data)) {
                    continue;
                }

                assert(
                    is_string($data['name']) || $data['name'] === null,
                    get_debug_type($data['name']),
                );
                assert(
                    is_string($data['manufacturer']) || $data['manufacturer'] === null,
                    get_debug_type($data['manufacturer']),
                );
                assert(
                    is_string($data['type']) || $data['type'] === null,
                    get_debug_type($data['type']),
                );
                assert(
                    is_string($data['engine']) || $data['engine'] === null,
                    get_debug_type($data['engine']),
                );

                $this->items[$stringKey] = new DataClient(
                    name: $data['name'],
                    manufacturer: $data['manufacturer'],
                    version: array_key_exists('version', $data) && is_array($data['version'])
                        ? (object) $data['version']
                        : null,
                    type: $data['type'],
                    engine: $data['engine'],
                );
            }
        }

        $this->initialized = true;
    }

    /** @throws void */
    #[Override]
    public function getItem(string $stringKey): DataClient | null
    {
        return $this->items[$stringKey] ?? null;
    }
}
