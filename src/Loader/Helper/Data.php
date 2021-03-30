<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Loader\Helper;

use ExceptionalJSON\DecodeErrorException;
use Iterator;
use JsonClass\JsonInterface;
use RuntimeException;
use SplFileInfo;
use stdClass;

use function array_key_exists;
use function assert;
use function count;
use function file_get_contents;
use function sprintf;

final class Data implements DataInterface
{
    /** @var Iterator<SplFileInfo> */
    private Iterator $finder;

    /** @var array<string, stdClass> */
    private array $items = [];

    private bool $initialized = false;

    private JsonInterface $json;

    /**
     * @param Iterator<SplFileInfo> $finder
     */
    public function __construct(Iterator $finder, JsonInterface $json)
    {
        $this->finder = $finder;
        $this->json   = $json;
    }

    /**
     * @throws RuntimeException
     */
    public function __invoke(): void
    {
        if ($this->initialized) {
            return;
        }

        foreach ($this->finder as $file) {
            assert($file instanceof SplFileInfo);
            $path    = $file->getPathname();
            $content = file_get_contents($path);

            assert(false !== $content, sprintf('could not read file "%s"', $path));

            try {
                $fileData = $this->json->decode($content, false);
            } catch (DecodeErrorException $e) {
                throw new RuntimeException(sprintf('file "%s" contains invalid json', $path), 0, $e);
            }

            foreach ($fileData as $key => $data) {
                if (array_key_exists($key, $this->items)) {
                    continue;
                }

                $this->items[$key] = $data;
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
