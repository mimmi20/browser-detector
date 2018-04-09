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

class CacheKey
{
    /**
     * @var string
     */
    private $dataPath = '';

    /**
     * @var string
     */
    private $rulesPath = '';

    /**
     * @var string
     */
    private $cachePrefix = '';

    /**
     * @param string $cachePrefix
     * @param string $dataPath
     * @param string $rulesPath
     */
    public function __construct(string $cachePrefix, string $dataPath, string $rulesPath)
    {
        $this->cachePrefix = $cachePrefix;
        $this->dataPath    = $dataPath;
        $this->rulesPath   = $rulesPath;
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function __invoke(string $key): string
    {
        return sprintf(
            '%s_%s_%s_%s',
            $this->cachePrefix,
            $this->clearCacheKey($this->dataPath),
            $this->clearCacheKey($this->rulesPath),
            $this->clearCacheKey($key)
        );
    }

    /**
     * @param string $key
     *
     * @return string
     */
    private function clearCacheKey(string $key): string
    {
        return str_replace(['{', '}', '(', ')', '/', '\\', '@', ':'], '_', $key);
    }
}
