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

class EngineLoader implements SpecificLoaderInterface
{
    use LoaderTrait;

    /**
     * @param string $key
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return \UaResult\Engine\EngineInterface
     */
    public function __invoke(string $key, string $useragent = ''): EngineInterface
    {
        $cacheKey = $this->cacheKey;

        try {
            $engineData = $this->cache->getItem($cacheKey($key));
        } catch (InvalidArgumentException $e) {
            throw new NotFoundException('the engine with key "' . $key . '" was not found', 0, $e);
        }

        if (null === $engineData) {
            throw new NotFoundException('the engine with key "' . $key . '" was not found');
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
