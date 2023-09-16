<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Loader\Helper;

use FilterIterator;
use Iterator;
use JsonException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;
use SplFileInfo;
use stdClass;

use function array_key_exists;
use function assert;
use function count;
use function file_get_contents;
use function is_array;
use function is_string;
use function json_decode;
use function sprintf;
use function str_replace;

use const JSON_THROW_ON_ERROR;

final class Data implements DataInterface
{
    /** @var array<string, stdClass> */
    private array $items      = [];
    private bool $initialized = false;

    /** @throws void */
    public function __construct(private readonly string $path, private readonly string $extension)
    {
        // nothing to do
    }

    /** @throws RuntimeException */
    public function __invoke(): void
    {
        if ($this->initialized) {
            return;
        }

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->path));
        $files    = new class ($iterator, $this->extension) extends FilterIterator {
            /**
             * @param Iterator<SplFileInfo> $iterator
             *
             * @throws void
             */
            public function __construct(Iterator $iterator, private readonly string $extension)
            {
                parent::__construct($iterator);
            }

            /** @throws void */
            public function accept(): bool
            {
                $file = $this->getInnerIterator()->current();

                assert($file instanceof SplFileInfo);

                return $file->isFile() && $file->getExtension() === $this->extension;
            }
        };

        foreach ($files as $file) {
            assert($file instanceof SplFileInfo);

            $pathName = $file->getPathname();
            $filepath = str_replace('\\', '/', $pathName);
            assert(is_string($filepath));

            $content = @file_get_contents($filepath);

            if ($content === false) {
                throw new RuntimeException(sprintf('could not read file "%s"', $file));
            }

            try {
                $fileData = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
            } catch (JsonException $e) {
                throw new RuntimeException(sprintf('file "%s" contains invalid json', $file), 0, $e);
            }

            assert(is_array($fileData) || $fileData instanceof stdClass);

            foreach ((array) $fileData as $key => $data) {
                $stringKey = (string) $key;

                if (array_key_exists($stringKey, $this->items) || !$data instanceof stdClass) {
                    continue;
                }

                $this->items[$stringKey] = $data;
            }
        }

        $this->initialized = true;
    }

    /** @throws void */
    public function getItem(string $cacheId): mixed
    {
        return $this->items[$cacheId] ?? null;
    }

    /** @throws void */
    public function hasItem(string $cacheId): bool
    {
        return array_key_exists($cacheId, $this->items);
    }

    /** @throws void */
    public function isInitialized(): bool
    {
        return $this->initialized;
    }

    /**
     * Count elements of an object
     *
     * @see https://php.net/manual/en/countable.count.php
     *
     * @return int the custom count as an integer
     *
     * @throws void
     */
    public function count(): int
    {
        return count($this->items);
    }
}
