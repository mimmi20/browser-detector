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

namespace BrowserDetector\Loader;

use BrowserDetector\Iterator\FilterIterator;
use JsonException;
use Override;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;
use SplFileInfo;

use function array_key_exists;
use function assert;
use function file_get_contents;
use function is_array;
use function is_string;
use function json_decode;
use function sprintf;
use function str_replace;

use const JSON_THROW_ON_ERROR;

final class MappingfileLoader implements MappingfileLoaderInterface
{
    private const string DATA_PATH = __DIR__ . '/../../data/device-mapping';

    /** @var array<string, non-empty-string> */
    private array $devices    = [];
    private bool $initialized = false;

    /** @throws void */
    public function __construct()
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

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(self::DATA_PATH));
        $files    = new FilterIterator($iterator, 'json');

        foreach ($files as $file) {
            assert($file instanceof SplFileInfo);

            $pathName = $file->getPathname();
            $filepath = str_replace('\\', '/', $pathName);
            assert(is_string($filepath));

            $content = @file_get_contents($filepath);

            assert($content === false || is_string($content));

            if ($content === false) {
                throw new RuntimeException(sprintf('could not read file "%s"', $file));
            }

            try {
                $fileData = json_decode(
                    $content,
                    associative: true,
                    depth: 512,
                    flags: JSON_THROW_ON_ERROR,
                );
            } catch (JsonException $e) {
                throw new RuntimeException(sprintf('could not decode file "%s"', $file), 0, $e);
            }

            assert(is_array($fileData));

            foreach ($fileData as $key => $data) {
                $stringKey = (string) $key;

                if (array_key_exists($stringKey, $this->devices)) {
                    continue;
                }

                if (!is_string($data)) {
                    continue;
                }

                if ($data === '') {
                    continue;
                }

                $this->devices[$stringKey] = $data;
            }
        }

        $this->initialized = true;
    }

    /**
     * @return non-empty-string|null
     *
     * @throws void
     */
    #[Override]
    public function getItem(string $code): string | null
    {
        return $this->devices[$code] ?? null;
    }
}
