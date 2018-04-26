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

use BrowserDetector\Bits\Browser as BrowserBits;
use BrowserDetector\Cache\CacheInterface;
use BrowserDetector\Loader\Helper\CacheKey;
use BrowserDetector\Version\Version;
use BrowserDetector\Version\VersionFactory;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\InvalidArgumentException;
use UaBrowserType\TypeLoader;
use UaResult\Browser\Browser;
use UaResult\Company\CompanyLoader;

class BrowserLoader implements SpecificLoaderInterface
{
    /**
     * @var \BrowserDetector\Cache\CacheInterface
     */
    private $cache;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \BrowserDetector\Loader\Helper\CacheKey
     */
    private $cacheKey;

    /**
     * @var \UaResult\Company\CompanyLoader
     */
    private $companyLoader;
    /**
     * @var \UaBrowserType\TypeLoader
     */
    private $typeLoader;
    /**
     * @var \BrowserDetector\Loader\GenericLoaderInterface
     */
    private $engineLoader;

    /**
     * @param \BrowserDetector\Cache\CacheInterface   $cache
     * @param \Psr\Log\LoggerInterface                $logger
     * @param \BrowserDetector\Loader\Helper\CacheKey $cacheKey
     * @param \UaResult\Company\CompanyLoader         $companyLoader
     * @param \UaBrowserType\TypeLoader               $typeLoader
     * @param \BrowserDetector\Loader\GenericLoaderInterface   $engineLoader
     */
    public function __construct(
        CacheInterface $cache,
        LoggerInterface $logger,
        CacheKey $cacheKey,
        CompanyLoader $companyLoader,
        TypeLoader $typeLoader,
        GenericLoaderInterface $engineLoader
    ) {
        $this->cache         = $cache;
        $this->logger        = $logger;
        $this->cacheKey      = $cacheKey;
        $this->companyLoader = $companyLoader;
        $this->typeLoader    = $typeLoader;
        $this->engineLoader  = $engineLoader;
    }

    /**
     * @param string $key
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return array
     */
    public function __invoke(string $key, string $useragent = ''): array
    {
        $cacheKey = $this->cacheKey;

        try {
            $browserData = $this->cache->getItem($cacheKey($key));
        } catch (InvalidArgumentException $e) {
            throw new NotFoundException('the browser with key "' . $key . '" was not found', 0, $e);
        }

        if (null === $browserData) {
            throw new NotFoundException('the browser with key "' . $key . '" was not found');
        }

        $browserVersionClass = $browserData->version->class;
        $manufacturer        = $this->companyLoader->load($browserData->manufacturer);
        $type                = $this->typeLoader->load($browserData->type);

        if (!is_string($browserVersionClass)) {
            $version = new Version('0');
        } elseif ('VersionFactory' === $browserVersionClass) {
            $version = (new VersionFactory())->detectVersion($useragent, $browserData->version->search);
        } else {
            /* @var \BrowserDetector\Version\VersionCacheFactoryInterface $versionClass */
            $versionClass = new $browserVersionClass();
            $version      = $versionClass->detectVersion($useragent);
        }

        $bits      = (new BrowserBits($useragent))->getBits();
        $engineKey = $browserData->engine;
        $engine    = null;

        if (null !== $engineKey) {
            try {
                $this->engineLoader->init();
                $engine = $this->engineLoader->load($engineKey, $useragent);
            } catch (NotFoundException | InvalidArgumentException $e) {
                $this->logger->info($e);
            }
        }

        $browser = new Browser($browserData->name, $manufacturer, $version, $type, $bits);

        return [$browser, $engine];
    }
}
