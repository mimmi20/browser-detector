<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Cache;

use Psr\SimpleCache\CacheInterface as PsrCacheInterface;

final class Cache implements CacheInterface
{
    /**
     * @var \Psr\SimpleCache\CacheInterface
     */
    private $cache;

    /**
     * Constructor class, checks for the existence of (and loads) the cache and
     * if needed updated the definitions
     *
     * @param \Psr\SimpleCache\CacheInterface $adapter
     */
    public function __construct(PsrCacheInterface $adapter)
    {
        $this->cache = $adapter;
    }

    /**
     * Get an item.
     *
     * @param string $cacheId
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return mixed Data on success, null on failure
     */
    public function getItem(string $cacheId)
    {
        if (!$this->cache->has($cacheId)) {
            return null;
        }

        $data = $this->cache->get($cacheId);

        if (!is_array($data) || !array_key_exists('content', $data)) {
            return null;
        }

        return unserialize($data['content']);
    }

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
    public function setItem(string $cacheId, $content): bool
    {
        // Get the whole PHP code
        $data = [
            'content' => serialize($content),
        ];

        // Save and return
        return $this->cache->set($cacheId, $data);
    }

    /**
     * Test if an item exists.
     *
     * @param string $cacheId
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return bool
     */
    public function hasItem(string $cacheId): bool
    {
        return $this->cache->has($cacheId);
    }
}
