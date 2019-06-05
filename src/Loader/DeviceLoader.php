<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Loader;

use BrowserDetector\Factory\DeviceFactory;
use BrowserDetector\Factory\DisplayFactory;
use BrowserDetector\Loader\Helper\DataInterface;
use BrowserDetector\Parser\PlatformParserInterface;
use Psr\Log\LoggerInterface;

final class DeviceLoader implements DeviceLoaderInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \BrowserDetector\Parser\PlatformParserInterface
     */
    private $platformParser;

    /**
     * @var \BrowserDetector\Loader\Helper\DataInterface
     */
    private $initData;

    /**
     * @var \BrowserDetector\Loader\CompanyLoaderInterface
     */
    private $companyLoader;

    /**
     * @param \Psr\Log\LoggerInterface                        $logger
     * @param \BrowserDetector\Loader\Helper\DataInterface    $initData
     * @param \BrowserDetector\Loader\CompanyLoaderInterface  $companyLoader
     * @param \BrowserDetector\Parser\PlatformParserInterface $platformParser
     */
    public function __construct(
        LoggerInterface $logger,
        DataInterface $initData,
        CompanyLoaderInterface $companyLoader,
        PlatformParserInterface $platformParser
    ) {
        $this->logger         = $logger;
        $this->platformParser = $platformParser;
        $this->companyLoader  = $companyLoader;

        $initData();

        $this->initData = $initData;
    }

    /**
     * @param string $key
     * @param string $useragent
     *
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \UnexpectedValueException
     *
     * @return array
     */
    public function load(string $key, string $useragent = ''): array
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
                $platform = $this->platformParser->load($platformKey, $useragent);
            } catch (NotFoundException | \UnexpectedValueException $e) {
                $this->logger->warning($e);
            }
        }

        $deviceFactory = new DeviceFactory(
            $this->companyLoader,
            new \UaDeviceType\TypeLoader(),
            new DisplayFactory(new \UaDisplaySize\TypeLoader())
        );
        $device = $deviceFactory->fromArray($this->logger, (array) $deviceData, $useragent);

        return [$device, $platform];
    }
}
