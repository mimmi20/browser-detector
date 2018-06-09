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

use BrowserDetector\Cache\CacheInterface;
use BrowserDetector\Loader\Helper\CacheKey;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\InvalidArgumentException;
use UaDeviceType\TypeLoader;
use UaResult\Company\CompanyLoader;
use UaResult\Device\Device;

class DeviceLoader implements SpecificLoaderInterface
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
     * @var \UaDeviceType\TypeLoader
     */
    private $typeLoader;
    /**
     * @var \BrowserDetector\Loader\GenericLoaderInterface
     */
    private $platformLoader;

    /**
     * @param \BrowserDetector\Cache\CacheInterface          $cache
     * @param \Psr\Log\LoggerInterface                       $logger
     * @param \BrowserDetector\Loader\Helper\CacheKey        $cacheKey
     * @param \UaResult\Company\CompanyLoader                $companyLoader
     * @param \UaDeviceType\TypeLoader                       $typeLoader
     * @param \BrowserDetector\Loader\GenericLoaderInterface $platformLoader
     */
    public function __construct(
        CacheInterface $cache,
        LoggerInterface $logger,
        CacheKey $cacheKey,
        CompanyLoader $companyLoader,
        TypeLoader $typeLoader,
        GenericLoaderInterface $platformLoader
    ) {
        $this->cache          = $cache;
        $this->logger         = $logger;
        $this->cacheKey       = $cacheKey;
        $this->companyLoader  = $companyLoader;
        $this->typeLoader     = $typeLoader;
        $this->platformLoader = $platformLoader;
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
            $deviceData = $this->cache->getItem($cacheKey($key));
        } catch (InvalidArgumentException $e) {
            throw new NotFoundException('the device with key "' . $key . '" was not found', 0, $e);
        }

        if (null === $deviceData) {
            throw new NotFoundException('the device with key "' . $key . '" was not found');
        }

        $platformKey = $deviceData->platform;
        $platform    = null;

        if (null !== $platformKey) {
            try {
                $this->platformLoader->init();
                $platform = $this->platformLoader->load($platformKey, $useragent);
            } catch (NotFoundException $e) {
                $this->logger->warning($e);
            } catch (InvalidArgumentException $e) {
                $this->logger->error($e);
            }
        }

        $device = new Device(
            $deviceData->codename,
            $deviceData->marketingName,
            $this->companyLoader->load($deviceData->manufacturer),
            $this->companyLoader->load($deviceData->brand),
            $this->typeLoader->load($deviceData->type),
            $deviceData->pointingMethod,
            $deviceData->resolutionWidth,
            $deviceData->resolutionHeight,
            $deviceData->dualOrientation
        );

        return [$device, $platform];
    }
}
