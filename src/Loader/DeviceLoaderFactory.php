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

use BrowserDetector\Loader\Helper\Data;
use Psr\Log\LoggerInterface;
use UaDeviceType\TypeLoader;

use function array_key_exists;

final class DeviceLoaderFactory implements DeviceLoaderFactoryInterface
{
    public const DATA_PATH = __DIR__ . '/../../data/devices/';

    /** @var array<DeviceLoaderInterface> */
    private array $loader = [];

    /** @throws void */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly CompanyLoaderInterface $companyLoader,
    ) {
        // nothing to do
    }

    /** @throws void */
    public function __invoke(string $company = ''): DeviceLoaderInterface
    {
        if (array_key_exists($company, $this->loader)) {
            return $this->loader[$company];
        }

        $this->loader[$company] = new DeviceLoader(
            $this->logger,
            new Data(self::DATA_PATH . $company, 'json'),
            $this->companyLoader,
            new TypeLoader(),
        );

        return $this->loader[$company];
    }
}
