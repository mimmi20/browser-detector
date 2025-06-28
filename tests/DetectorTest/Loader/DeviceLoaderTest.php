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
use BrowserDetector\Loader\InitData\Device as DataDevice;
use Laminas\Hydrator\Strategy\StrategyInterface;
use Override;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use ReflectionException;
use ReflectionProperty;
use RuntimeException;
use UaDeviceType\Type;
use UaLoader\Exception\NotFoundException;
use UaResult\Company\Company;
use UaResult\Device\Device;
use UaResult\Device\Display;
use UnexpectedValueException;

#[CoversClass(DeviceLoader::class)]
final class DeviceLoaderTest extends TestCase
{
    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     * @throws NoPreviousThrowableException
     * @throws Exception
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
     * @throws NoPreviousThrowableException
     * @throws Exception
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

    /**
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     * @throws ReflectionException
     * @throws NoPreviousThrowableException
     * @throws Exception
     */
    public function testLoadWithoutError(): void
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

        $platformData = new DataDevice(
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

        $object = new DeviceLoader(logger: $logger, initData: $initData, companyLoader: $companyLoader);

        $result = $object->load('test-key');

        $expected = new Device(
            deviceName: null,
            marketingName: null,
            manufacturer: $company,
            brand: $company,
            type: Type::Unknown,
            display: new Display(720, 1440, true, 7),
            dualOrientation: false,
            simCount: 0,
        );

        self::assertSame($expected->toArray(), $result->getDevice()->toArray());
        self::assertSame('test-platform', $result->getOs());
    }

    /**
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     * @throws ReflectionException
     * @throws NoPreviousThrowableException
     * @throws Exception
     */
    public function testLoadWithError1(): void
    {
        $exception = new NotFoundException('x was not found');

        $logger = $this->createMock(LoggerInterface::class);
        $logger
            ->expects(self::once())
            ->method('info')
            ->with($exception, []);
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

        $platformData = new DataDevice(
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
            platform: 'test-platform',
        );

        $prop = new ReflectionProperty($initData, 'items');
        $prop->setValue($initData, ['test-key' => $platformData]);

        $company = new Company(type: 'unknown', name: null, brandname: null);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('xyz')
            ->willThrowException($exception);

        $object = new DeviceLoader(logger: $logger, initData: $initData, companyLoader: $companyLoader);

        $result = $object->load('test-key');

        $expected = new Device(
            deviceName: null,
            marketingName: null,
            manufacturer: $company,
            brand: $company,
            type: Type::Unknown,
            display: new Display(720, 1440, true, 7),
            dualOrientation: false,
            simCount: 0,
        );

        self::assertSame($expected->toArray(), $result->getDevice()->toArray());
        self::assertSame('test-platform', $result->getOs());
    }

    /**
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     * @throws ReflectionException
     * @throws NoPreviousThrowableException
     * @throws Exception
     */
    public function testLoadWithError2(): void
    {
        $exception = new NotFoundException('x was not found');

        $logger = $this->createMock(LoggerInterface::class);
        $logger
            ->expects(self::once())
            ->method('info')
            ->with($exception, []);
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

        $platformData = new DataDevice(
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
            platform: 'test-platform',
        );

        $prop = new ReflectionProperty($initData, 'items');
        $prop->setValue($initData, ['test-key' => $platformData]);

        $company = new Company(type: 'unknown', name: null, brandname: null);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::once())
            ->method('load')
            ->with('xyz')
            ->willThrowException($exception);

        $object = new DeviceLoader(logger: $logger, initData: $initData, companyLoader: $companyLoader);

        $result = $object->load('test-key');

        $expected = new Device(
            deviceName: null,
            marketingName: null,
            manufacturer: $company,
            brand: $company,
            type: Type::Unknown,
            display: new Display(720, 1440, true, 7),
            dualOrientation: false,
            simCount: 0,
        );

        self::assertSame($expected->toArray(), $result->getDevice()->toArray());
        self::assertSame('test-platform', $result->getOs());
    }

    /**
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     * @throws ReflectionException
     * @throws NoPreviousThrowableException
     * @throws Exception
     */
    public function testLoadWithError3(): void
    {
        $exception = new NotFoundException('x was not found');

        $logger = $this->createMock(LoggerInterface::class);
        $logger
            ->expects(self::exactly(2))
            ->method('info')
            ->with($exception, []);
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

        $platformData = new DataDevice(
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
            platform: 'test-platform',
        );

        $prop = new ReflectionProperty($initData, 'items');
        $prop->setValue($initData, ['test-key' => $platformData]);

        $company = new Company(type: 'unknown', name: null, brandname: null);

        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $companyLoader
            ->expects(self::exactly(2))
            ->method('load')
            ->with('xyz')
            ->willThrowException($exception);

        $object = new DeviceLoader(logger: $logger, initData: $initData, companyLoader: $companyLoader);

        $result = $object->load('test-key');

        $expected = new Device(
            deviceName: null,
            marketingName: null,
            manufacturer: $company,
            brand: $company,
            type: Type::Unknown,
            display: new Display(720, 1440, true, 7),
            dualOrientation: false,
            simCount: 0,
        );

        self::assertSame($expected->toArray(), $result->getDevice()->toArray());
        self::assertSame('test-platform', $result->getOs());
    }
}
