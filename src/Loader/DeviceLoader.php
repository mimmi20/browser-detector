<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
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
use UaDeviceType\TypeLoader;
use UaResult\Device\DeviceInterface;
use UaResult\Os\OsInterface;
use UnexpectedValueException;

final class DeviceLoader implements DeviceLoaderInterface
{
    private LoggerInterface $logger;

    private PlatformParserInterface $platformParser;

    private DataInterface $initData;

    private CompanyLoaderInterface $companyLoader;

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
     * @return array<int, (OsInterface|DeviceInterface|null)>
     * @phpstan-return array(0:DeviceInterface, 1:OsInterface|null)
     *
     * @throws NotFoundException
     * @throws UnexpectedValueException
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
            } catch (UnexpectedValueException $e) {
                $this->logger->warning($e);
            }
        }

        $deviceFactory = new DeviceFactory(
            $this->companyLoader,
            new TypeLoader(),
            new DisplayFactory()
        );

        $device = $deviceFactory->fromArray($this->logger, (array) $deviceData, $useragent);

        return [$device, $platform];
    }
}
