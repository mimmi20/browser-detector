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
use Symfony\Component\Finder\SplFileInfo;

class InitRules
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
     * @var \BrowserDetector\Loader\Helper\CacheKey
     */
    private $getCacheKey;

    /**
     * @var \Symfony\Component\Finder\SplFileInfo
     */
    private $file;

    /**
     * @param \BrowserDetector\Cache\CacheInterface   $cache
     * @param \Seld\JsonLint\JsonParser               $jsonParser
     * @param \BrowserDetector\Loader\Helper\CacheKey $cacheKey
     * @param \Symfony\Component\Finder\SplFileInfo   $file
     */
    public function __construct(
        CacheInterface $cache,
        JsonParser $jsonParser,
        CacheKey $cacheKey,
        SplFileInfo $file
    ) {
        $this->cache       = $cache;
        $this->jsonParser  = $jsonParser;
        $this->getCacheKey = $cacheKey;
        $this->file        = $file;
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function __invoke(): void
    {
        $cacheKey = $this->getCacheKey;

        try {
            $fileData = $this->jsonParser->parse(
                $this->file->getContents(),
                JsonParser::DETECT_KEY_CONFLICTS | JsonParser::PARSE_TO_ASSOC
            );
        } catch (ParsingException $e) {
            throw new \RuntimeException('file "' . $this->file->getPathname() . '" contains invalid json', 0, $e);
        }

        $this->cache->setItem($cacheKey('rules'), $fileData['rules']);
        $this->cache->setItem($cacheKey('generic'), $fileData['generic']);
    }
}
