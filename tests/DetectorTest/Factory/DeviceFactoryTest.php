<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Factory;

use BrowserDetector\Factory\DeviceFactory;
use BrowserDetector\Factory\DisplayFactoryInterface;
use BrowserDetector\Factory\MarketFactoryInterface;
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
use UaResult\Device\MarketInterface;

class DeviceFactoryTest extends TestCase
{
    /**
     * @return void
     */
    public function testFromEmptyArray(): void
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
            ->method('__invoke')
            ->with('Unknown', $useragent)
            ->willReturn($company);

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

        $marketFactory = $this->getMockBuilder(MarketFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $marketFactory
            ->expects(self::never())
            ->method('fromArray');

        /* @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /* @var \UaDeviceType\TypeLoaderInterface $typeLoader */
        /* @var \BrowserDetector\Factory\DisplayFactoryInterface $displayFactory */
        /* @var \BrowserDetector\Factory\MarketFactoryInterface $marketFactory */
        $object = new DeviceFactory($companyLoader, $typeLoader, $displayFactory, $marketFactory);

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

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray($logger, [], $useragent);

        self::assertInstanceOf(Device::class, $result);
        self::assertNull($result->getDeviceName());
        self::assertNull($result->getMarketingName());
        self::assertFalse($result->getDualOrientation());
        self::assertIsInt($result->getSimCount());
        self::assertSame(0, $result->getSimCount());
        self::assertIsArray($result->getConnections());
        self::assertSame([], $result->getConnections());

        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertInstanceOf(Unknown::class, $result->getType());
        self::assertInstanceOf(DisplayInterface::class, $result->getDisplay());
        self::assertInstanceOf(MarketInterface::class, $result->getMarket());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
        self::assertInstanceOf(CompanyInterface::class, $result->getBrand());
        self::assertSame($company, $result->getBrand());
    }

    /**
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
            ->method('__invoke')
            ->with('Unknown', $useragent)
            ->willReturn($company);

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

        $marketFactory = $this->getMockBuilder(MarketFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $marketFactory
            ->expects(self::never())
            ->method('fromArray');

        /* @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /* @var \UaDeviceType\TypeLoaderInterface $typeLoader */
        /* @var \BrowserDetector\Factory\DisplayFactoryInterface $displayFactory */
        /* @var \BrowserDetector\Factory\MarketFactoryInterface $marketFactory */
        $object = new DeviceFactory($companyLoader, $typeLoader, $displayFactory, $marketFactory);

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

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray($logger, ['deviceName' => '', 'marketingName' => '', 'dualOrientation' => 0, 'simCount' => 'a', 'connections' => new \stdClass()], $useragent);

        self::assertInstanceOf(Device::class, $result);
        self::assertNull($result->getDeviceName());
        self::assertNull($result->getMarketingName());
        self::assertFalse($result->getDualOrientation());
        self::assertIsInt($result->getSimCount());
        self::assertSame(0, $result->getSimCount());
        self::assertIsArray($result->getConnections());
        self::assertSame([], $result->getConnections());

        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertInstanceOf(Unknown::class, $result->getType());
        self::assertInstanceOf(DisplayInterface::class, $result->getDisplay());
        self::assertInstanceOf(MarketInterface::class, $result->getMarket());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($company, $result->getManufacturer());
        self::assertInstanceOf(CompanyInterface::class, $result->getBrand());
        self::assertSame($company, $result->getBrand());
    }

    /**
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
            ->expects(self::exactly(4))
            ->method('__invoke')
            ->withConsecutive(['Unknown', $useragent], [$manufacturerParam, $useragent], ['Unknown', $useragent], [$brandParam, $useragent])
            ->willReturnOnConsecutiveCalls($company, $manufacturer, $company, $brand);

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

        $marketParam = [];
        $market      = $this->getMockBuilder(MarketInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $marketFactory = $this->getMockBuilder(MarketFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $marketFactory
            ->expects(self::once())
            ->method('fromArray')
            ->with($marketParam)
            ->willReturn($market);

        /* @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /* @var \UaDeviceType\TypeLoaderInterface $typeLoader */
        /* @var \BrowserDetector\Factory\DisplayFactoryInterface $displayFactory */
        /* @var \BrowserDetector\Factory\MarketFactoryInterface $marketFactory */
        $object = new DeviceFactory($companyLoader, $typeLoader, $displayFactory, $marketFactory);

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
        self::assertTrue($result->getDualOrientation());
        self::assertIsInt($result->getSimCount());
        self::assertSame($simCount, $result->getSimCount());
        self::assertIsArray($result->getConnections());
        self::assertSame($connections, $result->getConnections());

        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());
        self::assertInstanceOf(DisplayInterface::class, $result->getDisplay());
        self::assertSame($display, $result->getDisplay());
        self::assertInstanceOf(MarketInterface::class, $result->getMarket());
        self::assertSame($market, $result->getMarket());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($manufacturer, $result->getManufacturer());
        self::assertInstanceOf(CompanyInterface::class, $result->getBrand());
        self::assertSame($brand, $result->getBrand());
    }

    /**
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
        $displayException  = new NotFoundException('display failed');
        $marketException   = new NotFoundException('market failed');
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
            ->expects(self::exactly(4))
            ->method('__invoke')
            ->withConsecutive(['Unknown', $useragent], [$manufacturerParam, $useragent], ['Unknown', $useragent], [$brandParam, $useragent])
            ->willReturnCallback(static function (string $key, string $useragent = '') use ($company, $companyException, $manufacturerParam, $manufacturer) {
                if ('Unknown' === $key) {
                    return $company;
                }
                if ($manufacturerParam === $key) {
                    return $manufacturer;
                }
                throw $companyException;
            });

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
            ->expects(self::exactly(4))
            ->method('info')
            ->withConsecutive($typeException, $companyException, $displayException, $marketException);
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
        $displayFactory = $this->getMockBuilder(DisplayFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $displayFactory
            ->expects(self::once())
            ->method('fromArray')
            ->with($logger, $displayParam)
            ->willThrowException($displayException);

        $marketParam   = [];
        $marketFactory = $this->getMockBuilder(MarketFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $marketFactory
            ->expects(self::once())
            ->method('fromArray')
            ->with($marketParam)
            ->willThrowException($marketException);

        /* @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /* @var \UaDeviceType\TypeLoaderInterface $typeLoader */
        /* @var \BrowserDetector\Factory\DisplayFactoryInterface $displayFactory */
        /* @var \BrowserDetector\Factory\MarketFactoryInterface $marketFactory */
        $object = new DeviceFactory($companyLoader, $typeLoader, $displayFactory, $marketFactory);

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
        self::assertTrue($result->getDualOrientation());
        self::assertIsInt($result->getSimCount());
        self::assertSame($simCount, $result->getSimCount());
        self::assertIsArray($result->getConnections());
        self::assertSame($connections, $result->getConnections());

        self::assertInstanceOf(TypeInterface::class, $result->getType());
        self::assertInstanceOf(Unknown::class, $result->getType());
        self::assertInstanceOf(DisplayInterface::class, $result->getDisplay());
        self::assertInstanceOf(MarketInterface::class, $result->getMarket());
        self::assertInstanceOf(CompanyInterface::class, $result->getManufacturer());
        self::assertSame($manufacturer, $result->getManufacturer());
        self::assertInstanceOf(CompanyInterface::class, $result->getBrand());
        self::assertSame($company, $result->getBrand());
    }
}
