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

use BrowserDetector\Loader\Helper\Data;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\InvalidArgumentException;
use UaDeviceType\TypeLoader;
use UaResult\Company\CompanyLoader;
use UaResult\Device\Device;

class DeviceLoader implements SpecificLoaderInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

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
     * @var \BrowserDetector\Loader\Helper\Data
     */
    private $initData;

    /**
     * @param \Psr\Log\LoggerInterface                       $logger
     * @param \UaResult\Company\CompanyLoader                $companyLoader
     * @param \UaDeviceType\TypeLoader                       $typeLoader
     * @param \BrowserDetector\Loader\GenericLoaderInterface $platformLoader
     * @param \BrowserDetector\Loader\Helper\Data            $initData
     */
    public function __construct(
        LoggerInterface $logger,
        CompanyLoader $companyLoader,
        TypeLoader $typeLoader,
        GenericLoaderInterface $platformLoader,
        Data $initData
    ) {
        $this->logger         = $logger;
        $this->companyLoader  = $companyLoader;
        $this->typeLoader     = $typeLoader;
        $this->platformLoader = $platformLoader;
        $this->initData       = $initData;
    }

    /**
     * @param string $key
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return array
     */
    public function __invoke(string $key, string $useragent = ''): array
    {
        if (!$this->initData->hasItem($key)) {
            throw new NotFoundException('the device with key "' . $key . '" was not found');
        }

        $deviceData = $this->initData->getItem($key);

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
