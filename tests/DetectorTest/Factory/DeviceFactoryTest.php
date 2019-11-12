<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Factory;

use BrowserDetector\Factory\DeviceFactory;
use BrowserDetector\Factory\DisplayFactoryInterface;
use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\NotFoundException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use UaDeviceType\TypeInterface;
use UaDeviceType\TypeLoaderInterface;
use UaDeviceType\Unknown;
use UaResult\Company\CompanyInterface;
use UaResult\Device\Device;
use UaResult\Device\DisplayInterface;

final class DeviceFactoryTest extends TestCase
{
    /**
     * @return void
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

        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \UaDeviceType\TypeLoaderInterface $typeLoader */
        /** @var \BrowserDetector\Factory\DisplayFactoryInterface $displayFactory */
        $object = new DeviceFactory($companyLoader, $typeLoader, $displayFactory);

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

        $this->expectException(\AssertionError::class);
        $this->expectExceptionMessage('"deviceName" property is required');

        /* @var \Psr\Log\LoggerInterface $logger */
        $object->fromArray($logger, [], $useragent);
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     *
     * @return void
     */
    public function testFromArrayWithoutData(): void
    {
        $useragent = 'this is a test';
        $company   = $this->getMockBuilder(CompanyInterface::class)
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

        $type = $this->getMockBuilder(TypeInterface::class)
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

        $displayParam = [];
        $display      = $this->getMockBuilder(DisplayInterface::class)
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

        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \UaDeviceType\TypeLoaderInterface $typeLoader */
        /** @var \BrowserDetector\Factory\DisplayFactoryInterface $displayFactory */
        $object = new DeviceFactory($companyLoader, $typeLoader, $displayFactory);

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray(
            $logger,
            ['deviceName' => '', 'marketingName' => '', 'manufacturer' => 'unknown', 'brand' => 'unknown', 'type' => null, 'display' => null],
            $useragent
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
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     *
     * @return void
     */
    public function testFromArrayWithData(): void
    {
        $useragent     = 'this is a test';
        $deviceName    = 'deviceName';
        $marketingName = 'marketingName';
        $simCount      = 2;
        $connections   = ['LTE', 'GSM'];

        $manufacturerParam = 'test-manufacturer';
        $brandParam        = 'test-brand';

        $company = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $manufacturer = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $brand = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::exactly(2))
            ->method('load')
            ->withConsecutive([$manufacturerParam, $useragent], [$brandParam, $useragent])
            ->willReturnOnConsecutiveCalls($manufacturer, $brand);

        $typeParam = 1;
        $type      = $this->getMockBuilder(TypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('1')
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

        $displayParam = [];
        $display      = $this->getMockBuilder(DisplayInterface::class)
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

        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \UaDeviceType\TypeLoaderInterface $typeLoader */
        /** @var \BrowserDetector\Factory\DisplayFactoryInterface $displayFactory */
        $object = new DeviceFactory($companyLoader, $typeLoader, $displayFactory);

        $data = [
            'deviceName' => $deviceName,
            'marketingName' => $marketingName,
            'dualOrientation' => true,
            'simCount' => $simCount,
            'connections' => $connections,
            'type' => $typeParam,
            'display' => new \stdClass(),
            'market' => new \stdClass(),
            'manufacturer' => $manufacturerParam,
            'brand' => $brandParam,
        ];

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray($logger, $data, $useragent);

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
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     *
     * @return void
     */
    public function testFromArrayWithDataFailure(): void
    {
        $useragent     = 'this is a test';
        $deviceName    = 'deviceName';
        $marketingName = 'marketingName';
        $simCount      = 2;
        $connections   = ['LTE', 'GSM'];

        $manufacturerParam = 'test-manufacturer';
        $brandParam        = 'test-brand';
        $companyException  = new NotFoundException('company failed');
        $typeException     = new NotFoundException('type failed');

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(self::exactly(2))
            ->method('load')
            ->withConsecutive([$manufacturerParam, $useragent], [$brandParam, $useragent])
            ->willThrowException($companyException);

        $typeParam  = 1;
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('1')
            ->willThrowException($typeException);

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::never())
            ->method('debug');
        $logger
            ->expects(self::exactly(3))
            ->method('info')
            ->withConsecutive([$typeException], [$companyException], [$companyException]);
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

        $display = $this->getMockBuilder(DisplayInterface::class)
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

        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \UaDeviceType\TypeLoaderInterface $typeLoader */
        /** @var \BrowserDetector\Factory\DisplayFactoryInterface $displayFactory */
        $object = new DeviceFactory($companyLoader, $typeLoader, $displayFactory);

        $data = [
            'deviceName' => $deviceName,
            'marketingName' => $marketingName,
            'dualOrientation' => true,
            'simCount' => $simCount,
            'connections' => $connections,
            'type' => $typeParam,
            'display' => new \stdClass(),
            'market' => new \stdClass(),
            'manufacturer' => $manufacturerParam,
            'brand' => $brandParam,
        ];

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray($logger, $data, $useragent);

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
