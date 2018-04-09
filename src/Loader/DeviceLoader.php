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

use Psr\SimpleCache\InvalidArgumentException;
use UaDeviceType\TypeLoader;
use UaResult\Company\CompanyLoader;
use UaResult\Device\Device;

class DeviceLoader
{
    use LoaderTrait;

    /**
     * @param string $deviceKey
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return array
     */
    private function load(string $deviceKey, string $useragent = ''): array
    {
        $cacheKey = $this->cacheKey;

        try {
            $deviceData = $this->cache->getItem($cacheKey($deviceKey));
        } catch (InvalidArgumentException $e) {
            throw new NotFoundException('the device with key "' . $deviceKey . '" was not found', 0, $e);
        }

        if (null === $deviceData) {
            throw new NotFoundException('the device with key "' . $deviceKey . '" was not found');
        }

        $platformKey = $deviceData->platform;
        $platform    = null;

        if (null !== $platformKey) {
            try {
                $loaderFactory = new PlatformLoaderFactory($this->cache, $this->logger);
                $loader        = $loaderFactory('unknown');
                $loader->init();
                $platform = $loader->load($platformKey, $useragent);
            } catch (NotFoundException | InvalidArgumentException $e) {
                $this->logger->info($e);
            }
        }

        $companyLoader = CompanyLoader::getInstance();

        $device = new Device(
            $deviceData->codename,
            $deviceData->marketingName,
            $companyLoader->load($deviceData->manufacturer),
            $companyLoader->load($deviceData->brand),
            (new TypeLoader())->load($deviceData->type),
            $deviceData->pointingMethod,
            $deviceData->resolutionWidth,
            $deviceData->resolutionHeight,
            $deviceData->dualOrientation
        );

        return [$device, $platform];
    }
}
