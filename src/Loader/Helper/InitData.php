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

class InitData
{
    /**
     * @var \BrowserDetector\Cache\CacheInterface
     */
    private $cache;

    /**
     * @var \Seld\JsonLint\JsonParser
     */
    private $jsonParser;

    /**
     * @var \Symfony\Component\Finder\Finder
     */
    private $finder;

    /**
     * @var \BrowserDetector\Loader\Helper\CacheKey
     */
    private $cacheKey;

    /**
     * @param \BrowserDetector\Cache\CacheInterface   $cache
     * @param \Symfony\Component\Finder\Finder        $finder
     * @param \Seld\JsonLint\JsonParser               $jsonParser
     * @param \BrowserDetector\Loader\Helper\CacheKey $cacheKey
     */
    public function __construct(
        CacheInterface $cache,
        Finder $finder,
        JsonParser $jsonParser,
        CacheKey $cacheKey
    ) {
        $this->cache      = $cache;
        $this->finder     = $finder;
        $this->jsonParser = $jsonParser;
        $this->cacheKey   = $cacheKey;
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function __invoke(): void
    {
        $cacheKey = $this->cacheKey;

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
                $itemKey = $cacheKey((string) $key);

                if ($this->cache->hasItem($itemKey)) {
                    continue;
                }

                $this->cache->setItem($itemKey, $data);
            }
        }
    }
}
