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
use UaResult\Bits\Bits;
use UaResult\Company\Company;
use UaResult\Device\Architecture;
use UaResult\Device\Device;
use UaResult\Device\Display;
use UnexpectedValueException;

#[CoversClass(DeviceLoader::class)]
#[CoversClass(DeviceData::class)]
final class DeviceLoader2Test extends TestCase
{
    /**
     * @throws Exception
     * @throws NotFoundException
     * @throws UnexpectedValueException
     * @throws RuntimeException
     * @throws ReflectionException
     * @throws NoPreviousThrowableException
     * @throws Exception
     */
    public function testLoadWithoutError3(): void
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
            simCount: 2,
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

        $object = new DeviceLoader(logger: $logger, initData: $initData, companyLoader: $companyLoader);

        $result = $object->load('test-key');

        $prop = new ReflectionProperty($initData, 'initialized');

        self::assertTrue($prop->getValue($initData));

        $expected = new Device(
            architecture: Architecture::unknown,
            deviceName: null,
            marketingName: null,
            manufacturer: $company,
            brand: $company,
            type: Type::Smartphone,
            display: new Display(720, 1440, true, 7),
            dualOrientation: false,
            simCount: 2,
            bits: Bits::unknown,
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
    public function testLoadWithoutError4(): void
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
            simCount: null,
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

        $object = new DeviceLoader(logger: $logger, initData: $initData, companyLoader: $companyLoader);

        $result = $object->load('test-key');

        $prop = new ReflectionProperty($initData, 'initialized');

        self::assertTrue($prop->getValue($initData));

        $expected = new Device(
            architecture: Architecture::unknown,
            deviceName: null,
            marketingName: null,
            manufacturer: $company,
            brand: $company,
            type: Type::Smartphone,
            display: new Display(720, 1440, true, 7),
            dualOrientation: false,
            simCount: 1,
            bits: Bits::unknown,
        );

        self::assertSame($expected->toArray(), $result->getDevice()->toArray());
        self::assertSame('test-platform', $result->getOs());
    }
}
