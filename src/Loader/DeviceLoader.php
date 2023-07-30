<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
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
use stdClass;
use UaDeviceType\TypeLoader;
use UaResult\Device\DeviceInterface;
use UaResult\Os\OsInterface;
use UnexpectedValueException;

use function assert;

final class DeviceLoader implements DeviceLoaderInterface
{
    /** @throws void */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly DataInterface $initData,
        private readonly CompanyLoaderInterface $companyLoader,
        private readonly PlatformParserInterface $platformParser,
    ) {
        $initData();
    }

    /**
     * @return array<int, (DeviceInterface|OsInterface|null)>
     * @phpstan-return array{0:DeviceInterface, 1:OsInterface|null}
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

        if ($deviceData === null) {
            throw new NotFoundException('the device with key "' . $key . '" was not found');
        }

        assert($deviceData instanceof stdClass);

        $platformKey = $deviceData->platform;
        $platform    = null;

        if ($platformKey !== null) {
            try {
                $platform = $this->platformParser->load($platformKey, $useragent);
            } catch (UnexpectedValueException $e) {
                $this->logger->warning($e);
            }
        }

        $deviceFactory = new DeviceFactory(
            $this->companyLoader,
            new TypeLoader(),
            new DisplayFactory(),
            $this->logger,
        );

        $device = $deviceFactory->fromArray((array) $deviceData, $useragent);

        return [$device, $platform];
    }
}
