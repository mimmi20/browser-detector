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

use BrowserDetector\Factory\DeviceFactory;
use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Parser\PlatformParserInterface;
use Psr\Log\LoggerInterface;

final class DeviceLoader implements SpecificLoaderInterface
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
     * @var \BrowserDetector\Loader\Helper\Data
     */
    private $initData;

    /**
     * @var \BrowserDetector\Loader\CompanyLoader
     */
    private $companyLoader;

    /**
     * @param \Psr\Log\LoggerInterface                        $logger
     * @param \BrowserDetector\Loader\Helper\Data             $initData
     * @param \BrowserDetector\Loader\CompanyLoader           $companyLoader
     * @param \BrowserDetector\Parser\PlatformParserInterface $platformParser
     */
    public function __construct(
        LoggerInterface $logger,
        Data $initData,
        CompanyLoader $companyLoader,
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
                $platform = $this->platformParser->load($platformKey, $useragent);
            } catch (NotFoundException $e) {
                $this->logger->warning($e);
            }
        }

        $device = (new DeviceFactory($this->companyLoader))->fromArray($this->logger, (array) $deviceData);

        return [$device, $platform];
    }
}
