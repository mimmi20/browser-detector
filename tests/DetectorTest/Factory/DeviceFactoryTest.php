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
            ->expects(static::never())
            ->method('load');

        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(static::never())
            ->method('load');

        $displayFactory = $this->getMockBuilder(DisplayFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $displayFactory
            ->expects(static::never())
            ->method('fromArray');

        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \UaDeviceType\TypeLoaderInterface $typeLoader */
        /** @var \BrowserDetector\Factory\DisplayFactoryInterface $displayFactory */
        $object = new DeviceFactory($companyLoader, $typeLoader, $displayFactory);

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('debug');
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
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
            ->expects(static::exactly(4))
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
            ->expects(static::once())
            ->method('load')
            ->with('')
            ->willReturn($type);

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('debug');
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        $displayParam = [];
        $display      = $this->getMockBuilder(DisplayInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $displayFactory = $this->getMockBuilder(DisplayFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $displayFactory
            ->expects(static::once())
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

        static::assertInstanceOf(Device::class, $result);
        static::assertNull($result->getDeviceName());
        static::assertNull($result->getMarketingName());

        static::assertInstanceOf(TypeInterface::class, $result->getType());
        static::assertSame($type, $result->getType());
        static::assertInstanceOf(DisplayInterface::class, $result->getDisplay());
        static::assertSame($display, $result->getDisplay());
        static::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        static::assertSame($company, $result->getManufacturer());
        static::assertInstanceOf(CompanyInterface::class, $result->getBrand());
        static::assertSame($company, $result->getBrand());
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
            ->expects(static::exactly(4))
            ->method('load')
            ->withConsecutive(['unknown', $useragent], [$manufacturerParam, $useragent], ['unknown', $useragent], [$brandParam, $useragent])
            ->willReturnOnConsecutiveCalls($company, $manufacturer, $company, $brand);

        $typeParam = 1;
        $type      = $this->getMockBuilder(TypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(static::once())
            ->method('load')
            ->with('1')
            ->willReturn($type);

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('debug');
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        $displayParam = [];
        $display      = $this->getMockBuilder(DisplayInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $displayFactory = $this->getMockBuilder(DisplayFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $displayFactory
            ->expects(static::once())
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

        static::assertInstanceOf(Device::class, $result);
        static::assertIsString($result->getDeviceName());
        static::assertSame($deviceName, $result->getDeviceName());
        static::assertIsString($result->getMarketingName());
        static::assertSame($marketingName, $result->getMarketingName());

        static::assertInstanceOf(TypeInterface::class, $result->getType());
        static::assertSame($type, $result->getType());
        static::assertInstanceOf(DisplayInterface::class, $result->getDisplay());
        static::assertSame($display, $result->getDisplay());
        static::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        static::assertSame($manufacturer, $result->getManufacturer());
        static::assertInstanceOf(CompanyInterface::class, $result->getBrand());
        static::assertSame($brand, $result->getBrand());
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \BrowserDetector\Loader\NotFoundException
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

        $company = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $manufacturer = $this->getMockBuilder(CompanyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $companyLoader
            ->expects(static::exactly(4))
            ->method('load')
            ->withConsecutive(['unknown', $useragent], [$manufacturerParam, $useragent], ['unknown', $useragent], [$brandParam, $useragent])
            ->willReturnCallback(static function (string $key, string $useragent = '') use ($company, $companyException) {
                if ('unknown' === $key) {
                    return $company;
                }
                throw $companyException;
            });

        $typeParam  = 1;
        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(static::once())
            ->method('load')
            ->with('1')
            ->willThrowException($typeException);

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('debug');
        $logger
            ->expects(static::exactly(3))
            ->method('info')
            ->withConsecutive($typeException, $companyException, $companyException);
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        $display = $this->getMockBuilder(DisplayInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $displayParam   = [];
        $displayFactory = $this->getMockBuilder(DisplayFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $displayFactory
            ->expects(static::once())
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

        static::assertInstanceOf(Device::class, $result);
        static::assertIsString($result->getDeviceName());
        static::assertSame($deviceName, $result->getDeviceName());
        static::assertIsString($result->getMarketingName());
        static::assertSame($marketingName, $result->getMarketingName());

        static::assertInstanceOf(TypeInterface::class, $result->getType());
        static::assertInstanceOf(Unknown::class, $result->getType());
        static::assertInstanceOf(DisplayInterface::class, $result->getDisplay());
        static::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        static::assertInstanceOf(CompanyInterface::class, $result->getBrand());
    }
}
