<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2022, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Loader\Helper;

use JsonException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use RuntimeException;
use stdClass;

use function array_key_exists;
use function assert;
use function count;
use function file_get_contents;
use function is_array;
use function is_string;
use function json_decode;
use function sprintf;

use const JSON_THROW_ON_ERROR;

final class Data implements DataInterface
{
    private string $path;
    private string $extension;

    /** @var array<string, stdClass> */
    private array $items = [];

    private bool $initialized = false;

    public function __construct(string $path, string $extension)
    {
        $this->path      = $path;
        $this->extension = $extension;
    }

    /**
     * @throws RuntimeException
     */
    public function __invoke(): void
    {
        if ($this->initialized) {
            return;
        }

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->path));
        $files    = new RegexIterator($iterator, '/^.+\.' . $this->extension . '$/i', RegexIterator::GET_MATCH);

        foreach ($files as $file) {
            assert(is_array($file));

            $file = $file[0];
            assert(is_string($file));

            $content = @file_get_contents($file);

            if (false === $content) {
                throw new RuntimeException(sprintf('could not read file "%s"', $file));
            }

            try {
                $fileData = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
            } catch (JsonException $e) {
                throw new RuntimeException(sprintf('file "%s" contains invalid json', $file), 0, $e);
            }

            assert(is_array($fileData) || $fileData instanceof stdClass);

            foreach ((array) $fileData as $key => $data) {
                if (array_key_exists($key, $this->items)) {
                    continue;
                }

                $this->items[(string) $key] = $data;
            }
        }

        $this->initialized = true;
    }

    /**
     * @return mixed
     */
    public function getItem(string $cacheId)
    {
        return $this->items[$cacheId] ?? null;
    }

    public function hasItem(string $cacheId): bool
    {
        return array_key_exists($cacheId, $this->items);
    }

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
     */
    public function count(): int
    {
        return count($this->items);
    }
}
