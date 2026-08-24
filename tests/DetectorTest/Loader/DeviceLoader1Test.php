<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2026, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Loader;

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\Data\DataInterface;
use BrowserDetector\Loader\Data\Device as DeviceData;
use BrowserDetector\Loader\DeviceLoader;
use BrowserDetector\Loader\InitData\Device as DataDevice;
use Laminas\Hydrator\Strategy\StrategyInterface;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use ReflectionException;
use ReflectionProperty;
use RuntimeException;
use UaDeviceType\Type;
use UaLoader\Exception\NotFoundException;
use UaResult\Bits\Bits;
use UaResult\Company\Company;
use UaResult\Device\Architecture;
use UaResult\Device\Device;
use UaResult\Device\Display;
use UnexpectedValueException;

#[CoversClass(className: DeviceLoader::class)]
#[CoversClass(className: DeviceData::class)]
final class DeviceLoader1Test extends TestCase
{
    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public function testLoadNotInCache(): void
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

        $device = new DeviceData(
            strategy: new class () implements StrategyInterface {
                /**
                 * @throws void
                 *
                 * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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

        $deviceLoader = new DeviceLoader(
            logger: $logger,
            initData: $device,
            companyLoader: $companyLoader,
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageIsOrContains('the device with key "test-key" was not found');
        $this->expectExceptionCode(0);

        $deviceLoader->load('test-key');
    }

    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public function testLoadNullInCache(): void
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

        $device = new DeviceData(
            strategy: new class () implements StrategyInterface {
                /**
                 * @throws void
                 *
                 * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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

        $deviceLoader = new DeviceLoader(
            logger: $logger,
            initData: $device,
            companyLoader: $companyLoader,
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageIsOrContains('the device with key "test-key" was not found');
        $this->expectExceptionCode(0);

        $deviceLoader->load('test-key');
    }

    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public function testLoadNullInCache2(): void
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

        $initData = $this->createMock(DataInterface::class);
        $initData
            ->expects(self::once())
            ->method('init');
        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn(value: null);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::never())
            ->method('load');

        $deviceLoader = new DeviceLoader(
            logger: $logger,
            initData: $initData,
            companyLoader: $companyLoader,
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageIsOrContains('the device with key "test-key" was not found');
        $this->expectExceptionCode(0);

        $deviceLoader->load('test-key');
    }

    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     * @throws ReflectionException
     */
    public function testLoadWithoutError1(): void
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
                 * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
                 */
                #[Override]
                public function hydrate(mixed $value, array | null $data): array
                {
                    return [];
                }
            },
            company: 'test-company',
        );

        $platformData = new DataDevice(
            architecture: Architecture::unknown,
            deviceName: null,
            marketingName: null,
            manufacturer: 'xyz',
            brand: 'xyz',
            type: null,
            display: [
                'width' => 720,
                'height' => 1440,
                'touch' => true,
                'size' => 7,
            ],
            dualOrientation: false,
            simCount: 0,
            bits: Bits::unknown,
            platform: 'test-platform',
        );

        $prop = new ReflectionProperty($initData, 'items');
        $prop->setValue($initData, ['test-key' => $platformData]);

        $company = new Company(type: 'xyz-type', name: null, brandname: null);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::exactly(2))
            ->method('load')
            ->with('xyz')
            ->willReturn($company);

        $deviceLoader = new DeviceLoader(
            logger: $logger,
            initData: $initData,
            companyLoader: $companyLoader,
        );

        $deviceData = $deviceLoader->load('test-key');

        $prop = new ReflectionProperty($initData, 'initialized');

        self::assertTrue($prop->getValue($initData));

        $expected = new Device(
            architecture: Architecture::unknown,
            deviceName: null,
            marketingName: null,
            manufacturer: $company,
            brand: $company,
            type: Type::Unknown,
            display: new Display(720, 1440, touch: false, size: 7),
            dualOrientation: false,
            simCount: 0,
            bits: Bits::unknown,
        );

        self::assertSame($expected->toArray(), $deviceData->getDevice()->toArray());
        self::assertSame('test-platform', $deviceData->getOs());
    }

    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     * @throws ReflectionException
     */
    public function testLoadWithError1(): void
    {
        $notFoundException = new NotFoundException('x was not found');

        $logger = $this->createMock(LoggerInterface::class);
        $logger
            ->expects(self::once())
            ->method('info')
            ->with($notFoundException, []);
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
                 * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
                 */
                #[Override]
                public function hydrate(mixed $value, array | null $data): array
                {
                    return [];
                }
            },
            company: 'test-company',
        );

        $platformData = new DataDevice(
            architecture: Architecture::unknown,
            deviceName: null,
            marketingName: null,
            manufacturer: 'xyz',
            brand: null,
            type: null,
            display: [
                'width' => 720,
                'height' => 1440,
                'touch' => true,
                'size' => 7,
            ],
            dualOrientation: false,
            simCount: 0,
            bits: Bits::unknown,
            platform: 'test-platform',
        );

        $reflectionProperty = new ReflectionProperty($initData, 'items');
        $reflectionProperty->setValue($initData, ['test-key' => $platformData]);

        $company = new Company(type: 'unknown', name: null, brandname: null);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('xyz')
            ->willThrowException($notFoundException);

        $deviceLoader = new DeviceLoader(
            logger: $logger,
            initData: $initData,
            companyLoader: $companyLoader,
        );

        $deviceData = $deviceLoader->load('test-key');

        $expected = new Device(
            architecture: Architecture::unknown,
            deviceName: null,
            marketingName: null,
            manufacturer: $company,
            brand: $company,
            type: Type::Unknown,
            display: new Display(720, 1440, touch: false, size: 7),
            dualOrientation: false,
            simCount: 0,
            bits: Bits::unknown,
        );

        self::assertSame($expected->toArray(), $deviceData->getDevice()->toArray());
        self::assertSame('test-platform', $deviceData->getOs());
    }

    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     * @throws ReflectionException
     */
    public function testLoadWithError2(): void
    {
        $notFoundException = new NotFoundException('x was not found');

        $logger = $this->createMock(LoggerInterface::class);
        $logger
            ->expects(self::once())
            ->method('info')
            ->with($notFoundException, []);
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
                 * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
                 */
                #[Override]
                public function hydrate(mixed $value, array | null $data): array
                {
                    return [];
                }
            },
            company: 'test-company',
        );

        $platformData = new DataDevice(
            architecture: Architecture::unknown,
            deviceName: null,
            marketingName: null,
            manufacturer: null,
            brand: 'xyz',
            type: null,
            display: [
                'width' => 720,
                'height' => 1440,
                'touch' => true,
                'size' => 7,
            ],
            dualOrientation: false,
            simCount: 0,
            bits: Bits::unknown,
            platform: 'test-platform',
        );

        $reflectionProperty = new ReflectionProperty($initData, 'items');
        $reflectionProperty->setValue($initData, ['test-key' => $platformData]);

        $company = new Company(type: 'unknown', name: null, brandname: null);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('xyz')
            ->willThrowException($notFoundException);

        $deviceLoader = new DeviceLoader(
            logger: $logger,
            initData: $initData,
            companyLoader: $companyLoader,
        );

        $deviceData = $deviceLoader->load('test-key');

        $expected = new Device(
            architecture: Architecture::unknown,
            deviceName: null,
            marketingName: null,
            manufacturer: $company,
            brand: $company,
            type: Type::Unknown,
            display: new Display(720, 1440, touch: false, size: 7),
            dualOrientation: false,
            simCount: 0,
            bits: Bits::unknown,
        );

        self::assertSame($expected->toArray(), $deviceData->getDevice()->toArray());
        self::assertSame('test-platform', $deviceData->getOs());
    }

    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     * @throws ReflectionException
     */
    public function testLoadWithError3(): void
    {
        $notFoundException = new NotFoundException('x was not found');

        $logger = $this->createMock(LoggerInterface::class);
        $logger
            ->expects(self::exactly(2))
            ->method('info')
            ->with($notFoundException, []);
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
                 * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
                 */
                #[Override]
                public function hydrate(mixed $value, array | null $data): array
                {
                    return [];
                }
            },
            company: 'test-company',
        );

        $platformData = new DataDevice(
            architecture: Architecture::unknown,
            deviceName: null,
            marketingName: null,
            manufacturer: 'xyz',
            brand: 'xyz',
            type: null,
            display: [
                'width' => 720,
                'height' => 1440,
                'touch' => true,
                'size' => 7,
            ],
            dualOrientation: false,
            simCount: 0,
            bits: Bits::unknown,
            platform: 'test-platform',
        );

        $reflectionProperty = new ReflectionProperty($initData, 'items');
        $reflectionProperty->setValue($initData, ['test-key' => $platformData]);

        $company = new Company(type: 'unknown', name: null, brandname: null);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::exactly(2))
            ->method('load')
            ->with('xyz')
            ->willThrowException($notFoundException);

        $deviceLoader = new DeviceLoader(
            logger: $logger,
            initData: $initData,
            companyLoader: $companyLoader,
        );

        $deviceData = $deviceLoader->load('test-key');

        $expected = new Device(
            architecture: Architecture::unknown,
            deviceName: null,
            marketingName: null,
            manufacturer: $company,
            brand: $company,
            type: Type::Unknown,
            display: new Display(720, 1440, touch: false, size: 7),
            dualOrientation: false,
            simCount: 0,
            bits: Bits::unknown,
        );

        self::assertSame($expected->toArray(), $deviceData->getDevice()->toArray());
        self::assertSame('test-platform', $deviceData->getOs());
    }

    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     */
    public function testLoadWithInitException(): void
    {
        $key = 'test-key';

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

        $initData = $this->createMock(DataInterface::class);
        $initData
            ->expects(self::once())
            ->method('init')
            ->willThrowException(new RuntimeException('error'));
        $initData
            ->expects(self::never())
            ->method('getItem');

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::never())
            ->method('load');

        $deviceLoader = new DeviceLoader(
            logger: $logger,
            initData: $initData,
            companyLoader: $companyLoader,
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessageIsOrContains('the device with key "' . $key . '" was not found');

        $deviceLoader->load($key);
    }

    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     * @throws ReflectionException
     */
    public function testLoadWithoutError2(): void
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
                 * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
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
                 * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
                 */
                #[Override]
                public function hydrate(mixed $value, array | null $data): array
                {
                    return [];
                }
            },
            company: 'test-company',
        );

        $platformData = new DataDevice(
            architecture: Architecture::unknown,
            deviceName: null,
            marketingName: null,
            manufacturer: 'xyz',
            brand: 'xyz',
            type: Type::Smartphone,
            display: [
                'width' => 720,
                'height' => 1440,
                'touch' => true,
                'size' => 7,
            ],
            dualOrientation: false,
            simCount: 1,
            bits: Bits::unknown,
            platform: 'test-platform',
        );

        $prop = new ReflectionProperty($initData, 'items');
        $prop->setValue($initData, ['test-key' => $platformData]);

        $company = new Company(type: 'xyz-type', name: null, brandname: null);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::exactly(2))
            ->method('load')
            ->with('xyz')
            ->willReturn($company);

        $deviceLoader = new DeviceLoader(
            logger: $logger,
            initData: $initData,
            companyLoader: $companyLoader,
        );

        $deviceData = $deviceLoader->load('test-key');

        $prop = new ReflectionProperty($initData, 'initialized');

        self::assertTrue($prop->getValue($initData));

        $expected = new Device(
            architecture: Architecture::unknown,
            deviceName: null,
            marketingName: null,
            manufacturer: $company,
            brand: $company,
            type: Type::Smartphone,
            display: new Display(720, 1440, touch: true, size: 7),
            dualOrientation: false,
            simCount: 1,
            bits: Bits::unknown,
        );

        self::assertSame($expected->toArray(), $deviceData->getDevice()->toArray());
        self::assertSame('test-platform', $deviceData->getOs());
    }
}
