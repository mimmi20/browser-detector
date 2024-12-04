<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Cache;

use Psr\SimpleCache\InvalidArgumentException;

/**
 * a cache proxy to be able to use the cache adapters provided by the WurflCache package
 */
interface CacheInterface
{
    /**
     * Get an item.
     *
     * @return mixed Data on success, null on failure
     *
     * @throws InvalidArgumentException
     */
    public function getItem(string $cacheId): mixed;

    /**
     * save the content into an php file
     *
     * @param string $cacheId The cache id
     * @param mixed  $content The content to store
     *
     * @return bool whether the file was correctly written to the disk
     *
     * @throws InvalidArgumentException
     */
    public function setItem(string $cacheId, mixed $content): bool;

    /**
     * Test if an item exists.
     *
     * @throws InvalidArgumentException
     */
    public function hasItem(string $cacheId): bool;
}
