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

namespace BrowserDetectorTest;

use BrowserDetector\Cache\CacheInterface;
use BrowserDetector\Detector;
use BrowserDetector\Loader\Data\DeviceData;
use BrowserDetector\Loader\DeviceLoaderFactoryInterface;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionBuilderFactoryInterface;
use BrowserDetector\Version\VersionBuilderInterface;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Stringable;
use UaDeviceType\Type;
use UaLoader\BrowserLoaderInterface;
use UaLoader\DeviceLoaderInterface;
use UaLoader\EngineLoaderInterface;
use UaLoader\Exception\NotFoundException;
use UaLoader\PlatformLoaderInterface;
use UaRequest\GenericRequestInterface;
use UaRequest\Header\HeaderInterface;
use UaRequest\RequestBuilderInterface;
use UaResult\Company\Company;
use UaResult\Device\Device;
use UaResult\Device\Display;
use UaResult\Os\Os;
use UnexpectedValueException;

use function assert;
use function sprintf;

#[CoversClass(Detector::class)]
final class Detector2Test extends TestCase
{
    /**
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    public function testGetBrowserWithoutCacheButWithDeviceCode(): void
    {
        $hash                = 'test-hash';
        $headers             = ['xyz' => 'abc'];
        $deviceCodeForLoader = 'lg=lg lm-g710';
        $platformFromDevice  = 'android';

        $header = $this->createMock(HeaderInterface::class);
        $header
            ->expects(self::once())
            ->method('getValue')
            ->willReturn('abc');
        $header
            ->expects(self::never())
            ->method('getNormalizedValue');
        $header
            ->expects(self::once())
            ->method('hasDeviceArchitecture')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getDeviceArchitecture');
        $header
            ->expects(self::once())
            ->method('hasDeviceBitness')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getDeviceBitness');
        $header
            ->expects(self::once())
            ->method('hasDeviceIsMobile')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getDeviceIsMobile');
        $header
            ->expects(self::once())
            ->method('hasDeviceCode')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getDeviceCode')
            ->willReturn($deviceCodeForLoader);
        $header
            ->expects(self::once())
            ->method('hasClientCode')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getClientCode');
        $header
            ->expects(self::once())
            ->method('hasClientVersion')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getClientVersion');
        $header
            ->expects(self::once())
            ->method('hasPlatformCode')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getPlatformCode');
        $header
            ->expects(self::once())
            ->method('hasPlatformVersion')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getPlatformVersion');
        $header
            ->expects(self::once())
            ->method('hasEngineCode')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getEngineCode');
        $header
            ->expects(self::once())
            ->method('hasEngineVersion')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getEngineVersion');

        $filteredHeaders = ['xyz' => $header];

        $expected = [
            'headers' => $headers,
            'device' => [
                'architecture' => null,
                'deviceName' => 'LM-G710',
                'marketingName' => 'G7 ThinQ',
                'manufacturer' => 'lg',
                'brand' => 'lg',
                'dualOrientation' => null,
                'simCount' => null,
                'display' => [
                    'width' => 3120,
                    'height' => 1440,
                    'touch' => true,
                    'size' => 6.1,
                ],
                'type' => 'smartphone',
                'ismobile' => true,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => 'Android',
                'marketingName' => 'Android',
                'version' => null,
                'manufacturer' => 'google',
            ],
            'client' => [
                'name' => null,
                'version' => null,
                'manufacturer' => 'unknown',
                'type' => 'unknown',
                'isbot' => false,
            ],
            'engine' => [
                'name' => null,
                'version' => null,
                'manufacturer' => 'unknown',
            ],
        ];

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

        $cache = $this->createMock(CacheInterface::class);
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->with($hash)
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->with($hash, $expected);

        $request = $this->createMock(GenericRequestInterface::class);
        $request
            ->expects(self::once())
            ->method('getHash')
            ->willReturn($hash);
        $request
            ->expects(self::exactly(2))
            ->method('getHeaders')
            ->willReturn($filteredHeaders);

        $requestBuilder = $this->createMock(RequestBuilderInterface::class);
        $requestBuilder
            ->expects(self::once())
            ->method('buildRequest')
            ->with($headers)
            ->willReturn($request);

        $deviceLoader = $this->createMock(DeviceLoaderInterface::class);
        $deviceLoader
            ->expects(self::once())
            ->method('load')
            ->with('lg lm-g710')
            ->willReturn(
                new DeviceData(
                    device: new Device(
                        deviceName: 'LM-G710',
                        marketingName: 'G7 ThinQ',
                        manufacturer: new Company(type: 'lg', name: null, brandname: null),
                        brand: new Company(type: 'lg', name: null, brandname: null),
                        type: Type::Smartphone,
                        display: new Display(
                            width: 3120,
                            height: 1440,
                            touch: true,
                            size: 6.1,
                        ),
                        dualOrientation: null,
                        simCount: null,
                    ),
                    os: $platformFromDevice,
                ),
            );

        $deviceLoaderFactory = $this->createMock(DeviceLoaderFactoryInterface::class);
        $deviceLoaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('lg')
            ->willReturn($deviceLoader);

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with($platformFromDevice, '')
            ->willReturn(
                new Os(
                    name: 'Android',
                    marketingName: 'Android',
                    manufacturer: new Company(type: 'google', name: null, brandname: null),
                    version: new NullVersion(),
                ),
            );

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::never())
            ->method('load');

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::never())
            ->method('load');

        $versionBuilderFactory = $this->createMock(VersionBuilderFactoryInterface::class);
        $versionBuilderFactory
            ->expects(self::never())
            ->method('__invoke');

        $detector = new Detector(
            $logger,
            $cache,
            $requestBuilder,
            $deviceLoaderFactory,
            $platformLoader,
            $browserLoader,
            $engineLoader,
            $versionBuilderFactory,
        );

        self::assertSame($expected, $detector->getBrowser($headers));
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    public function testGetBrowserWithoutCacheButWithDeviceCode2(): void
    {
        $hash                = 'test-hash';
        $headers             = ['xyz' => 'abc'];
        $company             = 'lg';
        $key                 = 'lg lm-g710';
        $deviceCodeForLoader = $company . '=' . $key;

        $exception = new NotFoundException('device not found');

        $header = $this->createMock(HeaderInterface::class);
        $header
            ->expects(self::once())
            ->method('getValue')
            ->willReturn('abc');
        $header
            ->expects(self::never())
            ->method('getNormalizedValue');
        $header
            ->expects(self::once())
            ->method('hasDeviceArchitecture')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getDeviceArchitecture');
        $header
            ->expects(self::once())
            ->method('hasDeviceBitness')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getDeviceBitness');
        $header
            ->expects(self::once())
            ->method('hasDeviceIsMobile')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getDeviceIsMobile');
        $header
            ->expects(self::once())
            ->method('hasDeviceCode')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getDeviceCode')
            ->willReturn($deviceCodeForLoader);
        $header
            ->expects(self::once())
            ->method('hasClientCode')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getClientCode');
        $header
            ->expects(self::once())
            ->method('hasClientVersion')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getClientVersion');
        $header
            ->expects(self::once())
            ->method('hasPlatformCode')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getPlatformCode');
        $header
            ->expects(self::once())
            ->method('hasPlatformVersion')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getPlatformVersion');
        $header
            ->expects(self::once())
            ->method('hasEngineCode')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getEngineCode');
        $header
            ->expects(self::once())
            ->method('hasEngineVersion')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getEngineVersion');

        $filteredHeaders = ['xyz' => $header];

        $expected = [
            'headers' => $headers,
            'device' => [
                'architecture' => null,
                'deviceName' => null,
                'marketingName' => null,
                'manufacturer' => 'unknown',
                'brand' => 'unknown',
                'dualOrientation' => null,
                'simCount' => null,
                'display' => [
                    'width' => null,
                    'height' => null,
                    'touch' => null,
                    'size' => null,
                ],
                'type' => 'unknown',
                'ismobile' => false,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => null,
                'marketingName' => null,
                'version' => null,
                'manufacturer' => 'unknown',
            ],
            'client' => [
                'name' => null,
                'version' => null,
                'manufacturer' => 'unknown',
                'type' => 'unknown',
                'isbot' => false,
            ],
            'engine' => [
                'name' => null,
                'version' => null,
                'manufacturer' => 'unknown',
            ],
        ];

        $logger = $this->createMock(LoggerInterface::class);
        $logger
            ->expects(self::once())
            ->method('info')
            ->willReturnCallback(
                static function (string | Stringable $message, array $context = []) use ($exception, $company, $key): void {
                    assert($message instanceof UnexpectedValueException);
                    self::assertInstanceOf(UnexpectedValueException::class, $message);
                    self::assertSame(
                        sprintf('Device %s of Manufacturer %s was not found', $key, $company),
                        $message->getMessage(),
                    );
                    self::assertSame(0, $message->getCode());
                    self::assertSame($exception, $message->getPrevious());
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

        $cache = $this->createMock(CacheInterface::class);
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->with($hash)
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->with($hash, $expected);

        $request = $this->createMock(GenericRequestInterface::class);
        $request
            ->expects(self::once())
            ->method('getHash')
            ->willReturn($hash);
        $request
            ->expects(self::exactly(2))
            ->method('getHeaders')
            ->willReturn($filteredHeaders);

        $requestBuilder = $this->createMock(RequestBuilderInterface::class);
        $requestBuilder
            ->expects(self::once())
            ->method('buildRequest')
            ->with($headers)
            ->willReturn($request);

        $deviceLoader = $this->createMock(DeviceLoaderInterface::class);
        $deviceLoader
            ->expects(self::once())
            ->method('load')
            ->with($key)
            ->willThrowException($exception);

        $deviceLoaderFactory = $this->createMock(DeviceLoaderFactoryInterface::class);
        $deviceLoaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with($company)
            ->willReturn($deviceLoader);

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::never())
            ->method('load');

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::never())
            ->method('load');

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::never())
            ->method('load');

        $versionBuilderFactory = $this->createMock(VersionBuilderFactoryInterface::class);
        $versionBuilderFactory
            ->expects(self::never())
            ->method('__invoke');

        $detector = new Detector(
            $logger,
            $cache,
            $requestBuilder,
            $deviceLoaderFactory,
            $platformLoader,
            $browserLoader,
            $engineLoader,
            $versionBuilderFactory,
        );

        self::assertSame($expected, $detector->getBrowser($headers));
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    public function testGetBrowserWithoutCacheButWithPlatformCode2(): void
    {
        $hash                = 'test-hash';
        $headerValue         = 'abc';
        $headers             = ['xyz' => $headerValue];
        $deviceCodeForLoader = 'lg=lg lm-g710';
        $platformFromDevice  = 'android';
        $platformCode        = 'linux';
        $platformVersion     = '2.4.5.6';

        $exception = new NotFoundException('device not found');

        $header = $this->createMock(HeaderInterface::class);
        $header
            ->expects(self::exactly(2))
            ->method('getValue')
            ->willReturn($headerValue);
        $header
            ->expects(self::never())
            ->method('getNormalizedValue');
        $header
            ->expects(self::once())
            ->method('hasDeviceArchitecture')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getDeviceArchitecture');
        $header
            ->expects(self::once())
            ->method('hasDeviceBitness')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getDeviceBitness');
        $header
            ->expects(self::once())
            ->method('hasDeviceIsMobile')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getDeviceIsMobile');
        $header
            ->expects(self::once())
            ->method('hasDeviceCode')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getDeviceCode')
            ->willReturn($deviceCodeForLoader);
        $header
            ->expects(self::once())
            ->method('hasClientCode')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getClientCode');
        $header
            ->expects(self::once())
            ->method('hasClientVersion')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getClientVersion');
        $header
            ->expects(self::once())
            ->method('hasPlatformCode')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getPlatformCode')
            ->willReturn($platformCode);
        $header
            ->expects(self::once())
            ->method('hasPlatformVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getPlatformVersion')
            ->with($platformCode)
            ->willReturn($platformVersion);
        $header
            ->expects(self::once())
            ->method('hasEngineCode')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getEngineCode');
        $header
            ->expects(self::once())
            ->method('hasEngineVersion')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getEngineVersion');

        $filteredHeaders = ['xyz' => $header];

        $expected = [
            'headers' => $headers,
            'device' => [
                'architecture' => null,
                'deviceName' => 'LM-G710',
                'marketingName' => 'G7 ThinQ',
                'manufacturer' => 'lg',
                'brand' => 'lg',
                'dualOrientation' => null,
                'simCount' => null,
                'display' => [
                    'width' => 3120,
                    'height' => 1440,
                    'touch' => true,
                    'size' => 6.1,
                ],
                'type' => 'smartphone',
                'ismobile' => true,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => null,
                'marketingName' => null,
                'version' => $platformVersion,
                'manufacturer' => 'unknown',
            ],
            'client' => [
                'name' => null,
                'version' => null,
                'manufacturer' => 'unknown',
                'type' => 'unknown',
                'isbot' => false,
            ],
            'engine' => [
                'name' => null,
                'version' => null,
                'manufacturer' => 'unknown',
            ],
        ];

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

        $cache = $this->createMock(CacheInterface::class);
        $cache
            ->expects(self::once())
            ->method('hasItem')
            ->with($hash)
            ->willReturn(false);
        $cache
            ->expects(self::never())
            ->method('getItem');
        $cache
            ->expects(self::once())
            ->method('setItem')
            ->with($hash, $expected);

        $request = $this->createMock(GenericRequestInterface::class);
        $request
            ->expects(self::once())
            ->method('getHash')
            ->willReturn($hash);
        $request
            ->expects(self::exactly(2))
            ->method('getHeaders')
            ->willReturn($filteredHeaders);

        $requestBuilder = $this->createMock(RequestBuilderInterface::class);
        $requestBuilder
            ->expects(self::once())
            ->method('buildRequest')
            ->with($headers)
            ->willReturn($request);

        $deviceLoader = $this->createMock(DeviceLoaderInterface::class);
        $deviceLoader
            ->expects(self::once())
            ->method('load')
            ->with('lg lm-g710')
            ->willReturn(
                new DeviceData(
                    device: new Device(
                        deviceName: 'LM-G710',
                        marketingName: 'G7 ThinQ',
                        manufacturer: new Company(type: 'lg', name: null, brandname: null),
                        brand: new Company(type: 'lg', name: null, brandname: null),
                        type: Type::Smartphone,
                        display: new Display(
                            width: 3120,
                            height: 1440,
                            touch: true,
                            size: 6.1,
                        ),
                        dualOrientation: null,
                        simCount: null,
                    ),
                    os: $platformFromDevice,
                ),
            );

        $deviceLoaderFactory = $this->createMock(DeviceLoaderFactoryInterface::class);
        $deviceLoaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('lg')
            ->willReturn($deviceLoader);

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with($platformCode, $headerValue)
            ->willThrowException($exception);

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::never())
            ->method('load');

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::never())
            ->method('load');

        $version = $this->createMock(VersionInterface::class);
        $version
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::COMPLETE)
            ->willReturn($platformVersion);

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with($platformVersion)
            ->willReturn($version);
        $versionBuilder
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder
            ->expects(self::never())
            ->method('setRegex');

        $versionBuilderFactory = $this->createMock(VersionBuilderFactoryInterface::class);
        $versionBuilderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with(null)
            ->willReturn($versionBuilder);

        $detector = new Detector(
            $logger,
            $cache,
            $requestBuilder,
            $deviceLoaderFactory,
            $platformLoader,
            $browserLoader,
            $engineLoader,
            $versionBuilderFactory,
        );

        self::assertSame($expected, $detector->getBrowser($headers));
    }
}
