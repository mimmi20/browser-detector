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
use BrowserDetector\Loader\DeviceLoaderFactoryInterface;
use BrowserDetector\Version\Exception\NotNumericException;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionBuilder;
use BrowserDetector\Version\VersionBuilderFactoryInterface;
use BrowserDetector\Version\VersionBuilderInterface;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\InvalidArgumentException;
use UaDeviceType\Smartphone;
use UaLoader\BrowserLoaderInterface;
use UaLoader\DeviceLoaderInterface;
use UaLoader\EngineLoaderInterface;
use UaLoader\PlatformLoaderInterface;
use UaRequest\GenericRequestInterface;
use UaRequest\Header\HeaderInterface;
use UaRequest\RequestBuilderInterface;
use UaResult\Company\Company;
use UaResult\Device\Device;
use UaResult\Device\Display;
use UaResult\Os\Os;
use UnexpectedValueException;

final class Detector5Test extends TestCase
{
    /**
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     * @throws NotNumericException
     */
    public function testGetBrowserWithoutCacheButWithPlatformCode7(): void
    {
        $hash                = 'test-hash';
        $headerValue         = 'abc';
        $headers             = ['xyz' => $headerValue];
        $deviceCodeForLoader = 'lg=lg lm-g710';
        $platformFromDevice  = 'android';
        $platformCode        = 'linux';
        $platformVersion     = null;
        $platformVersion2    = '2.4.7.8';

        $header = $this->createMock(HeaderInterface::class);
        $header
            ->expects(self::once())
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

        $filteredHeaders = ['abc' => $header];

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
                'name' => 'Linux',
                'marketingName' => 'Linux',
                'version' => $platformVersion2,
                'manufacturer' => 'linux-foundation',
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
            ->expects(self::once())
            ->method('getHeaders')
            ->willReturn($headers);
        $request
            ->expects(self::once())
            ->method('getFilteredHeaders')
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
                [
                    'device' => new Device(
                        deviceName: 'LM-G710',
                        marketingName: 'G7 ThinQ',
                        manufacturer: new Company(type: 'lg', name: null, brandname: null),
                        brand: new Company(type: 'lg', name: null, brandname: null),
                        type: new Smartphone(),
                        display: new Display(
                            width: 3120,
                            height: 1440,
                            touch: true,
                            size: 6.1,
                        ),
                        dualOrientation: null,
                        simCount: null,
                    ),
                    'os' => $platformFromDevice,
                ],
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
            ->willReturn(
                new Os(
                    name: 'Linux',
                    marketingName: 'Linux',
                    manufacturer: new Company(type: 'linux-foundation', name: null, brandname: null),
                    version: (new VersionBuilder())->set($platformVersion2),
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

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function testGetBrowserWithoutCacheButWithMobileData2(): void
    {
        $hash    = 'test-hash';
        $headers = ['xyz' => 'abc'];

        $header = $this->createMock(HeaderInterface::class);
        $header
            ->expects(self::never())
            ->method('getValue');
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
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getDeviceIsMobile')
            ->willReturn(false);
        $header
            ->expects(self::once())
            ->method('hasDeviceCode')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getDeviceCode');
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

        $filteredHeaders = ['abc' => $header];

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
            ->expects(self::once())
            ->method('getHeaders')
            ->willReturn($headers);
        $request
            ->expects(self::once())
            ->method('getFilteredHeaders')
            ->willReturn($filteredHeaders);

        $requestBuilder = $this->createMock(RequestBuilderInterface::class);
        $requestBuilder
            ->expects(self::once())
            ->method('buildRequest')
            ->with($headers)
            ->willReturn($request);

        $deviceLoaderFactory = $this->createMock(DeviceLoaderFactoryInterface::class);
        $deviceLoaderFactory
            ->expects(self::never())
            ->method('__invoke');

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
     */
    public function testGetBrowserWithoutCacheButWithMobileData3(): void
    {
        $hash    = 'test-hash';
        $headers = ['xyz' => 'abc'];

        $header = $this->createMock(HeaderInterface::class);
        $header
            ->expects(self::never())
            ->method('getValue');
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
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getDeviceIsMobile')
            ->willReturn(null);
        $header
            ->expects(self::once())
            ->method('hasDeviceCode')
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getDeviceCode');
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

        $filteredHeaders = ['abc' => $header];

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
            ->expects(self::once())
            ->method('getHeaders')
            ->willReturn($headers);
        $request
            ->expects(self::once())
            ->method('getFilteredHeaders')
            ->willReturn($filteredHeaders);

        $requestBuilder = $this->createMock(RequestBuilderInterface::class);
        $requestBuilder
            ->expects(self::once())
            ->method('buildRequest')
            ->with($headers)
            ->willReturn($request);

        $deviceLoaderFactory = $this->createMock(DeviceLoaderFactoryInterface::class);
        $deviceLoaderFactory
            ->expects(self::never())
            ->method('__invoke');

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
     */
    public function testGetBrowserWithoutCacheButWithPlatformCode8(): void
    {
        $hash                = 'test-hash';
        $headerValue         = 'abc';
        $headers             = ['xyz' => $headerValue];
        $deviceCodeForLoader = 'lg=lg lm-g710';
        $platformFromDevice  = 'android';
        $platformCode        = 'linux';

        $exception = new NotNumericException('invalid version');

        $header = $this->createMock(HeaderInterface::class);
        $header
            ->expects(self::once())
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
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getDeviceIsMobile')
            ->willReturn(false);
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
            ->willThrowException($exception);
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

        $filteredHeaders = ['abc' => $header];

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
                'ismobile' => false,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => 'Linux',
                'marketingName' => 'Linux',
                'version' => null,
                'manufacturer' => 'linux-foundation',
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
            ->expects(self::once())
            ->method('getHeaders')
            ->willReturn($headers);
        $request
            ->expects(self::once())
            ->method('getFilteredHeaders')
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
                [
                    'device' => new Device(
                        deviceName: 'LM-G710',
                        marketingName: 'G7 ThinQ',
                        manufacturer: new Company(type: 'lg', name: null, brandname: null),
                        brand: new Company(type: 'lg', name: null, brandname: null),
                        type: new Smartphone(),
                        display: new Display(
                            width: 3120,
                            height: 1440,
                            touch: true,
                            size: 6.1,
                        ),
                        dualOrientation: null,
                        simCount: null,
                    ),
                    'os' => $platformFromDevice,
                ],
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
            ->willReturn(
                new Os(
                    name: 'Linux',
                    marketingName: 'Linux',
                    manufacturer: new Company(type: 'linux-foundation', name: null, brandname: null),
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
}
