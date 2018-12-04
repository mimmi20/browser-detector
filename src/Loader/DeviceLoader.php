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
use UaDeviceType\TypeLoader;
use UaResult\Device\Device;
use UaResult\Device\DisplayFactory;

class DeviceLoader implements SpecificLoaderInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \BrowserDetector\Loader\CompanyLoader
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
     * @param \BrowserDetector\Loader\CompanyLoader          $companyLoader
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
            }
        }

        $display = null;

        if (null !== $deviceData->display) {
            $display = (new DisplayFactory())->fromArray($this->logger, $deviceData->display);
        }

        $device = new Device(
            $deviceData->deviceName,
            $deviceData->marketingName,
            $this->companyLoader->load($deviceData->manufacturer),
            $this->companyLoader->load($deviceData->brand),
            $this->typeLoader->load($deviceData->type),
            $display,
            $deviceData->dualOrientation
        );

        return [$device, $platform];
    }
}
