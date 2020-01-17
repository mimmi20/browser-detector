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
namespace BrowserDetector\Cache;

/**
 * a cache proxy to be able to use the cache adapters provided by the WurflCache package
 */
interface CacheInterface
{
    /**
     * Get an item.
     *
     * @param string $cacheId
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return mixed Data on success, null on failure
     */
    public function getItem(string $cacheId);

    /**
     * save the content into an php file
     *
     * @param string $cacheId The cache id
     * @param mixed  $content The content to store
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return bool whether the file was correctly written to the disk
     */
    public function setItem(string $cacheId, $content): bool;

    /**
     * Test if an item exists.
     *
     * @param string $cacheId
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return bool
     */
    public function hasItem(string $cacheId): bool;
}
