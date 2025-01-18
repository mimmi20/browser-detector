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

use BrowserDetector\Loader\InitData\Device as DataDevice;
use Laminas\Hydrator\ArraySerializableHydrator;
use Laminas\Hydrator\Exception\InvalidArgumentException;
use Laminas\Hydrator\Strategy\CollectionStrategy;
use Laminas\Hydrator\Strategy\SerializableStrategy;
use Laminas\Hydrator\Strategy\StrategyChain;
use Laminas\Serializer\Adapter\Json;
use Override;
use Psr\Log\LoggerInterface;
use RuntimeException;
use UaLoader\DeviceLoaderInterface;

use function array_key_exists;

final class DeviceLoaderFactory implements DeviceLoaderFactoryInterface
{
    /** @var array<string, DeviceLoaderInterface> */
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

        $serializableStrategy = new SerializableStrategy(
            new Json(),
        );

        try {
            $this->loader[$company] = new DeviceLoader(
                logger: $this->logger,
                initData: new Data\Device(
                    strategy: new StrategyChain(
                        [
                            new CollectionStrategy(
                                new ArraySerializableHydrator(),
                                DataDevice::class,
                            ),
                            $serializableStrategy,
                        ],
                    ),
                    company: $company,
                ),
                companyLoader: $this->companyLoader,
            );
        } catch (InvalidArgumentException $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }

        return $this->loader[$company];
    }
}
