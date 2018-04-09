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
namespace BrowserDetector\Loader;

use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use Psr\SimpleCache\InvalidArgumentException;
use UaResult\Company\CompanyLoader;
use UaResult\Engine\Engine;
use UaResult\Engine\EngineInterface;

class EngineLoader implements EngineLoaderInterface
{
    use LoaderTrait;

    /**
     * @param string $useragent
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return EngineInterface
     */
    public function __invoke(string $useragent): EngineInterface
    {
        $this->init();

        $cacheKey = $this->cacheKey;
        $devices  = $this->cache->getItem($cacheKey('rules'));
        $generic  = $this->cache->getItem($cacheKey('generic'));

        return $this->detectInArray($devices, $generic, $useragent);
    }

    /**
     * @param string $engineKey
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return \UaResult\Engine\EngineInterface
     */
    public function load(string $engineKey, string $useragent = ''): EngineInterface
    {
        $cacheKey = $this->cacheKey;

        try {
            $engineData = $this->cache->getItem($cacheKey($engineKey));
        } catch (InvalidArgumentException $e) {
            throw new NotFoundException('the engine with key "' . $engineKey . '" was not found', 0, $e);
        }

        if (null === $engineData) {
            throw new NotFoundException('the engine with key "' . $engineKey . '" was not found');
        }

        $engineVersionClass = $engineData->version->class;
        $manufacturer       = CompanyLoader::getInstance()->load($engineData->manufacturer);

        if (!is_string($engineVersionClass)) {
            $version = new Version('0');
        } elseif ('VersionFactory' === $engineVersionClass) {
            $version = (new VersionFactory())->detectVersion($useragent, $engineData->version->search);
        } else {
            /* @var \BrowserDetector\Version\VersionCacheFactoryInterface $versionClass */
            $versionClass = new $engineVersionClass();
            $version      = $versionClass->detectVersion($useragent);
        }

        return new Engine(
            $engineData->name,
            $manufacturer,
            $version
        );
    }
}
