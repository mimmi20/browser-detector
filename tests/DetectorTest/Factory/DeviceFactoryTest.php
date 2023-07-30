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

namespace BrowserDetectorTest\Factory;

use AssertionError;
use BrowserDetector\Factory\DeviceFactory;
use BrowserDetector\Factory\DisplayFactoryInterface;
use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\NotFoundException;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use stdClass;
use Stringable;
use UaDeviceType\TypeInterface;
use UaDeviceType\TypeLoaderInterface;
use UaDeviceType\Unknown;
use UaResult\Company\CompanyInterface;
use UaResult\Device\Device;
use UaResult\Device\DisplayInterface;

final class DeviceFactoryTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testFromEmptyArray(): void
    {
        $useragent     = 'this is a test';
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::never())
            ->method('load');

        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::never())
            ->method('load');

        $displayFactory = $this->getMockBuilder(DisplayFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $displayFactory
            ->expects(self::never())
            ->method('fromArray');

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::never())
            ->method('debug');
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

        $object = new DeviceFactory($companyLoader, $typeLoader, $displayFactory, $logger);

        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage('"deviceName" property is required');

        $object->fromArray([], $useragent);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testFromArrayWithoutData(): void
    {
        $useragent     = 'this is a test';
        $company       = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::exactly(2))
            ->method('load')
            ->with('unknown', $useragent)
            ->willReturn($company);

        $type       = $this->getMockBuilder(TypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('')
            ->willReturn($type);

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::never())
            ->method('debug');
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

        $displayParam   = [];
        $display        = $this->getMockBuilder(DisplayInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $displayFactory = $this->getMockBuilder(DisplayFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $displayFactory
            ->expects(self::once())
            ->method('fromArray')
            ->with($logger, $displayParam)
            ->willReturn($display);

        $object = new DeviceFactory($companyLoader, $typeLoader, $displayFactory, $logger);

        $result = $object->fromArray(
            ['deviceName' => '', 'marketingName' => '', 'manufacturer' => 'unknown', 'brand' => 'unknown', 'type' => null, 'display' => null],
            $useragent,
        );

        self::assertInstanceOf(Device::class, $result);
        self::assertNull($result->getDeviceName());
        self::assertNull($result->getMarketingName());

        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());
        self::assertInstanceOf(DisplayInterface::class, $result->getDisplay());
        self::assertSame($display, $result->getDisplay());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
        self::assertInstanceOf(CompanyInterface::class, $result->getBrand());
        self::assertSame($company, $result->getBrand());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testFromArrayWithData(): void
    {
        $useragent     = 'this is a test';
        $deviceName    = 'deviceName';
        $marketingName = 'marketingName';

        $manufacturerParam = 'test-manufacturer';
        $brandParam        = 'test-brand';

        $manufacturer  = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $brand         = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $matcher       = self::exactly(2);
        $companyLoader
            ->expects($matcher)
            ->method('load')
            ->willReturnCallback(
                static function (string $key, string $useragentParam = '') use ($matcher, $manufacturerParam, $brandParam, $useragent, $manufacturer, $brand): CompanyInterface {
                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame($manufacturerParam, $key),
                default => self::assertSame($brandParam, $key),
                    };

                    self::assertSame($useragent, $useragentParam);

                    return match ($matcher->numberOfInvocations()) {
                        1 => $manufacturer,
                default => $brand,
                    };
                },
            );

        $typeParam  = '1';
        $type       = $this->getMockBuilder(TypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with($typeParam)
            ->willReturn($type);

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::never())
            ->method('debug');
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

        $displayParam   = [];
        $display        = $this->getMockBuilder(DisplayInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $displayFactory = $this->getMockBuilder(DisplayFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $displayFactory
            ->expects(self::once())
            ->method('fromArray')
            ->with($logger, $displayParam)
            ->willReturn($display);

        $object = new DeviceFactory($companyLoader, $typeLoader, $displayFactory, $logger);

        $data = [
            'deviceName' => $deviceName,
            'marketingName' => $marketingName,
            'manufacturer' => $manufacturerParam,
            'brand' => $brandParam,
            'display' => new stdClass(),
            'type' => $typeParam,
        ];

        $result = $object->fromArray($data, $useragent);

        self::assertInstanceOf(Device::class, $result);
        self::assertIsString($result->getDeviceName());
        self::assertSame($deviceName, $result->getDeviceName());
        self::assertIsString($result->getMarketingName());
        self::assertSame($marketingName, $result->getMarketingName());

        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());
        self::assertInstanceOf(DisplayInterface::class, $result->getDisplay());
        self::assertSame($display, $result->getDisplay());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($manufacturer, $result->getManufacturer());
        self::assertInstanceOf(CompanyInterface::class, $result->getBrand());
        self::assertSame($brand, $result->getBrand());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testFromArrayWithDataFailure(): void
    {
        $useragent     = 'this is a test';
        $deviceName    = 'deviceName';
        $marketingName = 'marketingName';

        $manufacturerParam = 'test-manufacturer';
        $brandParam        = 'test-brand';
        $companyException  = new NotFoundException('company failed');
        $typeException     = new \UaDeviceType\NotFoundException('type failed');

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $matcher       = self::exactly(2);
        $companyLoader
            ->expects($matcher)
            ->method('load')
            ->willReturnCallback(
                static function (string $key, string $useragentParam = '') use ($matcher, $manufacturerParam, $brandParam, $useragent, $companyException): CompanyInterface {
                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame($manufacturerParam, $key),
                default => self::assertSame($brandParam, $key),
                    };

                    self::assertSame($useragent, $useragentParam);

                    throw $companyException;
                },
            );

        $typeParam  = '1';
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with($typeParam)
            ->willThrowException($typeException);

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::never())
            ->method('debug');
        $matcher = self::exactly(3);
        $logger
            ->expects($matcher)
            ->method('info')
            ->willReturnCallback(
                static function (string | Stringable $message, array $context = []) use ($matcher, $typeException, $companyException): void {
                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame($typeException, $message),
                default => self::assertSame($companyException, $message),
                    };

                    self::assertSame([], $context);
                },
            );
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

        $display        = $this->getMockBuilder(DisplayInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $displayParam   = [];
        $displayFactory = $this->getMockBuilder(DisplayFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $displayFactory
            ->expects(self::once())
            ->method('fromArray')
            ->with($logger, $displayParam)
            ->willReturn($display);

        $object = new DeviceFactory($companyLoader, $typeLoader, $displayFactory, $logger);

        $data = [
            'deviceName' => $deviceName,
            'marketingName' => $marketingName,
            'manufacturer' => $manufacturerParam,
            'brand' => $brandParam,
            'display' => new stdClass(),
            'type' => $typeParam,
        ];

        $result = $object->fromArray($data, $useragent);

        self::assertInstanceOf(Device::class, $result);
        self::assertIsString($result->getDeviceName());
        self::assertSame($deviceName, $result->getDeviceName());
        self::assertIsString($result->getMarketingName());
        self::assertSame($marketingName, $result->getMarketingName());

        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertInstanceOf(Unknown::class, $result->getType());
        self::assertInstanceOf(DisplayInterface::class, $result->getDisplay());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertInstanceOf(CompanyInterface::class, $result->getBrand());
    }
}
