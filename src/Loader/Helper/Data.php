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
namespace BrowserDetector\Loader\Helper;

use BrowserDetector\Cache\CacheInterface;
use Seld\JsonLint\JsonParser;
use Seld\JsonLint\ParsingException;
use Symfony\Component\Finder\Finder;

class Data implements CacheInterface
{
    /**
     * @var \Seld\JsonLint\JsonParser
     */
    private $jsonParser;

    /**
     * @var \Symfony\Component\Finder\Finder
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
     * @param \Symfony\Component\Finder\Finder $finder
     * @param \Seld\JsonLint\JsonParser        $jsonParser
     */
    public function __construct(
        Finder $finder,
        JsonParser $jsonParser
    ) {
        $this->finder     = $finder;
        $this->jsonParser = $jsonParser;
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
     * @param mixed  $content
     *
     * @return bool
     */
    public function setItem(string $cacheId, $content): bool
    {
        return false;
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
     * @param string $cacheId
     *
     * @return bool
     */
    public function removeItem(string $cacheId): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function flush(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isInitialized(): bool
    {
        return $this->initialized;
    }

    /**
     * @return void
     */
    public function __invoke(): void
    {
        foreach ($this->finder as $file) {
            /* @var \Symfony\Component\Finder\SplFileInfo $file */
            try {
                $fileData = $this->jsonParser->parse(
                    $file->getContents(),
                    JsonParser::DETECT_KEY_CONFLICTS
                );
            } catch (ParsingException $e) {
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
}
