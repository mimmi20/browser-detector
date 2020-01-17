<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2020, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Loader\Helper;

use ExceptionalJSON\DecodeErrorException;
use JsonClass\JsonInterface;

final class Data implements DataInterface
{
    /**
     * @var \Iterator
     */
    private $finder;

    /**
     * @var array
     */
    private $items = [];

    /**
     * @var bool
     */
    private $initialized = false;

    /**
     * @var \JsonClass\JsonInterface
     */
    private $json;

    /**
     * @param \Iterator                $finder
     * @param \JsonClass\JsonInterface $json
     */
    public function __construct(\Iterator $finder, JsonInterface $json)
    {
        $this->finder = $finder;
        $this->json   = $json;
    }

    /**
     * @param string $cacheId
     *
     * @return mixed
     */
    public function getItem(string $cacheId)
    {
        return $this->items[$cacheId] ?? null;
    }

    /**
     * @param string $cacheId
     *
     * @return bool
     */
    public function hasItem(string $cacheId): bool
    {
        return array_key_exists($cacheId, $this->items);
    }

    /**
     * @return bool
     */
    public function isInitialized(): bool
    {
        return $this->initialized;
    }

    /**
     * @throws \RuntimeException
     *
     * @return void
     */
    public function __invoke(): void
    {
        if ($this->initialized) {
            return;
        }

        foreach ($this->finder as $file) {
            /* @var \SplFileInfo $file */
            try {
                $fileData = $this->json->decode(
                    file_get_contents($file->getPathname()),
                    false
                );
            } catch (DecodeErrorException $e) {
                throw new \RuntimeException('file "' . $file->getPathname() . '" contains invalid json', 0, $e);
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
     * Count elements of an object
     *
     * @see https://php.net/manual/en/countable.count.php
     *
     * @return int The custom count as an integer.
     *             </p>
     *             <p>
     *             The return value is cast to an integer.
     *
     * @since 5.1.0
     */
    public function count(): int
    {
        return count($this->items);
    }
}
