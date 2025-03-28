<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Cache;

use Override;
use Psr\SimpleCache\InvalidArgumentException;

use function array_key_exists;
use function is_array;
use function is_string;
use function serialize;
use function unserialize;

final readonly class Cache implements CacheInterface
{
    /** @throws void */
    public function __construct(private \Psr\SimpleCache\CacheInterface $cache)
    {
        // nothing to do
    }

    /**
     * Get an item.
     *
     * @return mixed Data on success, null on failure
     *
     * @throws InvalidArgumentException
     */
    #[Override]
    public function getItem(string $cacheId): mixed
    {
        if (!$this->cache->has($cacheId)) {
            return null;
        }

        $data = $this->cache->get($cacheId);

        if (!is_array($data) || !array_key_exists('content', $data) || !is_string($data['content'])) {
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
     * @return bool whether the file was correctly written to the disk
     *
     * @throws InvalidArgumentException
     */
    #[Override]
    public function setItem(string $cacheId, mixed $content): bool
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
     * @throws InvalidArgumentException
     */
    #[Override]
    public function hasItem(string $cacheId): bool
    {
        return $this->cache->has($cacheId);
    }
}
