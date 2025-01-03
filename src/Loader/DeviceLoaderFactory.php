<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Loader;

use BrowserDetector\Loader\Helper\Data;
use Override;
use Psr\Log\LoggerInterface;
use RuntimeException;
use UaDeviceType\TypeLoader;
use UaLoader\DeviceLoaderInterface;

use function array_key_exists;

final class DeviceLoaderFactory implements DeviceLoaderFactoryInterface
{
    private const string DATA_PATH = __DIR__ . '/../../data/devices/';

    /** @var array<DeviceLoaderInterface> */
    private array $loader = [];

    /** @throws void */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly CompanyLoaderInterface $companyLoader,
    ) {
        // nothing to do
    }

    /** @throws RuntimeException */
    #[Override]
    public function __invoke(string $company = ''): DeviceLoaderInterface
    {
        if (array_key_exists($company, $this->loader)) {
            return $this->loader[$company];
        }

        $this->loader[$company] = new DeviceLoader(
            logger: $this->logger,
            initData: new Data(self::DATA_PATH . $company, 'json'),
            companyLoader: $this->companyLoader,
            typeLoader: new TypeLoader(),
        );

        return $this->loader[$company];
    }
}
