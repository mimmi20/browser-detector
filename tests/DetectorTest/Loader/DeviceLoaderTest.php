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

namespace BrowserDetectorTest\Loader;

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\Data\Device as DeviceData;
use BrowserDetector\Loader\DeviceLoader;
use Laminas\Hydrator\Strategy\StrategyInterface;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use RuntimeException;
use UaLoader\Exception\NotFoundException;
use UnexpectedValueException;

#[CoversClass(DeviceLoader::class)]
final class DeviceLoaderTest extends TestCase
{
    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public function testInvokeNotInCache(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger
            ->expects(self::never())
            ->method('info');
        $logger
            ->expects(self::never())
            ->method('notice');
        $logger
            ->expects(self::never())
            ->method('warning');
        $logger
            ->expects(self::never())
            ->method('error');
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        $initData = new DeviceData(
            strategy: new class () implements StrategyInterface {
                /**
                 * @throws void
                 *
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
                 */
                #[Override]
                public function extract(mixed $value, object | null $object = null): null
                {
                    return null;
                }

                /**
                 * @param array<mixed>|null $data
                 *
                 * @return array<string, mixed>
                 *
                 * @throws void
                 *
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
                 */
                #[Override]
                public function hydrate(mixed $value, array | null $data): array
                {
                    return [];
                }
            },
            company: 'test-company',
        );

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::never())
            ->method('load');

        $object = new DeviceLoader(logger: $logger, initData: $initData, companyLoader: $companyLoader);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the device with key "test-key" was not found');
        $this->expectExceptionCode(0);

        $object->load('test-key');
    }

    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public function testInvokeNullInCache(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger
            ->expects(self::never())
            ->method('info');
        $logger
            ->expects(self::never())
            ->method('notice');
        $logger
            ->expects(self::never())
            ->method('warning');
        $logger
            ->expects(self::never())
            ->method('error');
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        $initData = new DeviceData(
            strategy: new class () implements StrategyInterface {
                /**
                 * @throws void
                 *
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
                 */
                #[Override]
                public function extract(mixed $value, object | null $object = null): null
                {
                    return null;
                }

                /**
                 * @param array<mixed>|null $data
                 *
                 * @return array<string, mixed>
                 *
                 * @throws void
                 *
                 * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
                 */
                #[Override]
                public function hydrate(mixed $value, array | null $data): array
                {
                    return [];
                }
            },
            company: 'test-company',
        );

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::never())
            ->method('load');

        $object = new DeviceLoader(logger: $logger, initData: $initData, companyLoader: $companyLoader);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the device with key "test-key" was not found');
        $this->expectExceptionCode(0);

        $object->load('test-key');
    }
}
