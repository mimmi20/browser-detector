<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Loader;

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Loader\DeviceLoader;
use BrowserDetector\Loader\Helper\DataInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Parser\PlatformParserInterface;
use BrowserDetector\Version\TestFactory;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use UaResult\Device\DeviceInterface;
use UaResult\Os\OsInterface;
use UnexpectedValueException;

use function assert;
use function gettype;
use function is_object;
use function sprintf;

final class DeviceLoaderTest extends TestCase
{
    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function testInvokeNotInCache(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
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

        $initData = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $initData
            ->expects(self::once())
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(false);
        $initData
            ->expects(self::never())
            ->method('getItem')
            ->with('test-key')
            ->willReturn(false);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        assert($logger instanceof LoggerInterface);
        assert($companyLoader instanceof CompanyLoaderInterface);
        assert($platformParser instanceof PlatformParserInterface);
        assert($initData instanceof DataInterface);
        $object = new DeviceLoader(
            $logger,
            $initData,
            $companyLoader,
            $platformParser
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the device with key "test-key" was not found');

        $object->load('test-key', 'test-ua');
    }

    /**
     * @throws NotFoundException
     * @throws UnexpectedValueException
     */
    public function testInvokeNullInCache(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
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

        $initData = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $initData
            ->expects(self::once())
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);
        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn(null);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        assert($logger instanceof LoggerInterface);
        assert($companyLoader instanceof CompanyLoaderInterface);
        assert($platformParser instanceof PlatformParserInterface);
        assert($initData instanceof DataInterface);
        $object = new DeviceLoader(
            $logger,
            $initData,
            $companyLoader,
            $platformParser
        );

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the device with key "test-key" was not found');

        $object->load('test-key', 'test-ua');
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws \InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function testInvokeNoVersion(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
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

        $initData = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $initData
            ->expects(self::once())
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $deviceData = (object) [
            'version' => (object) ['class' => null],
            'manufacturer' => 'unknown',
            'brand' => 'unknown',
            'type' => 'unknown',
            'deviceName' => null,
            'marketingName' => null,
            'platform' => null,
            'display' => ['width' => null, 'height' => null, 'touch' => null, 'size' => null],
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($deviceData);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        assert($logger instanceof LoggerInterface);
        assert($companyLoader instanceof CompanyLoaderInterface);
        assert($platformParser instanceof PlatformParserInterface);
        assert($initData instanceof DataInterface);
        $object = new DeviceLoader(
            $logger,
            $initData,
            $companyLoader,
            $platformParser
        );

        $result = $object->load('test-key', 'test-ua');

        self::assertIsArray($result);
        self::assertArrayHasKey(0, $result);
        self::assertInstanceOf(DeviceInterface::class, $result[0]);
        self::assertArrayHasKey(1, $result);
        self::assertNull($result[1]);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws \InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function testInvokeGenericVersionAndPlatformInvalidException(): void
    {
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
            ->expects(self::once())
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

        $initData = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $initData
            ->expects(self::once())
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $deviceData = (object) [
            'version' => (object) ['class' => 'VersionFactory', 'search' => ['test']],
            'manufacturer' => 'unknown',
            'brand' => 'unknown',
            'type' => 'unknown',
            'deviceName' => null,
            'marketingName' => null,
            'platform' => 'test-platform',
            'display' => ['width' => null, 'height' => null, 'touch' => null, 'size' => null],
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($deviceData);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser->expects(self::once())
            ->method('load')
            ->with('test-platform')
            ->willThrowException(new NotFoundException());

        assert($logger instanceof LoggerInterface);
        assert($companyLoader instanceof CompanyLoaderInterface);
        assert($platformParser instanceof PlatformParserInterface);
        assert($initData instanceof DataInterface);
        $object = new DeviceLoader(
            $logger,
            $initData,
            $companyLoader,
            $platformParser
        );

        $result = $object->load('test-key', 'test/1.0');

        self::assertIsArray($result);
        self::assertArrayHasKey(0, $result);
        self::assertInstanceOf(DeviceInterface::class, $result[0]);
        self::assertArrayHasKey(1, $result);
        self::assertNull($result[1]);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     * @throws \InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function testInvokeVersionAndPlatform(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
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

        $initData = $this->getMockBuilder(DataInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $initData
            ->expects(self::once())
            ->method('__invoke');
        $initData
            ->expects(self::once())
            ->method('hasItem')
            ->with('test-key')
            ->willReturn(true);

        $deviceData = (object) [
            'version' => (object) ['factory' => TestFactory::class],
            'manufacturer' => 'unknown',
            'brand' => 'unknown',
            'type' => 'unknown',
            'deviceName' => 'test-device',
            'marketingName' => null,
            'platform' => 'test-platform',
            'display' => ['width' => null, 'height' => null, 'touch' => null, 'size' => null],
        ];

        $initData
            ->expects(self::once())
            ->method('getItem')
            ->with('test-key')
            ->willReturn($deviceData);

        $companyLoader = $this->getMockBuilder(CompanyLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platform      = $this->getMockBuilder(OsInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $platformParser = $this->getMockBuilder(PlatformParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $platformParser->expects(self::once())
            ->method('load')
            ->with('test-platform')
            ->willReturn($platform);

        assert($logger instanceof LoggerInterface);
        assert($companyLoader instanceof CompanyLoaderInterface);
        assert($platformParser instanceof PlatformParserInterface);
        assert($initData instanceof DataInterface);
        $object = new DeviceLoader(
            $logger,
            $initData,
            $companyLoader,
            $platformParser
        );

        $result = $object->load('test-key', 'test/1.0');

        self::assertIsArray($result);
        self::assertArrayHasKey(0, $result);
        $deviceResult = $result[0];

        assert(
            $deviceResult instanceof DeviceInterface,
            sprintf(
                '$deviceResult should be an instance of %s, but is %s',
                DeviceInterface::class,
                is_object($deviceResult) ? $deviceResult::class : gettype($deviceResult)
            )
        );

        self::assertInstanceOf(DeviceInterface::class, $deviceResult);

        self::assertArrayHasKey(1, $result);
        $platformResult = $result[1];

        assert(
            $platformResult instanceof OsInterface,
            sprintf(
                '$platformResult should be an instance of %s, but is %s',
                OsInterface::class,
                is_object($platformResult) ? $platformResult::class : gettype($platformResult)
            )
        );

        self::assertInstanceOf(OsInterface::class, $platformResult);
        self::assertSame($platform, $platformResult);

        self::assertSame('test-device', $deviceResult->getDeviceName());
    }
}
