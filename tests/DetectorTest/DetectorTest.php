<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest;

use BrowserDetector\Cache\CacheInterface;
use BrowserDetector\Detector;
use BrowserDetector\GenericRequestInterface;
use BrowserDetector\Header\HeaderInterface;
use BrowserDetector\Loader\BrowserLoaderInterface;
use BrowserDetector\Loader\DeviceLoaderFactoryInterface;
use BrowserDetector\Loader\DeviceLoaderInterface;
use BrowserDetector\Loader\EngineLoaderInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Loader\PlatformLoaderInterface;
use BrowserDetector\RequestBuilderInterface;
use BrowserDetector\Version\Exception\NotNumericException;
use BrowserDetector\Version\VersionBuilderFactoryInterface;
use BrowserDetector\Version\VersionBuilderInterface;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\InvalidArgumentException;
use Stringable;
use UnexpectedValueException;

use function assert;
use function sprintf;

final class DetectorTest extends TestCase
{
    /**
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function testGetBrowserFromCache(): void
    {
        $headers = ['xyz' => 'abc'];
        $hash    = 'test-hash';

        $expected = [1, 2, 3, 4];

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
            ->willReturn(true);
        $cache
            ->expects(self::once())
            ->method('getItem')
            ->with($hash)
            ->willReturn($expected);
        $cache
            ->expects(self::never())
            ->method('setItem');

        $request = $this->createMock(GenericRequestInterface::class);
        $request
            ->expects(self::once())
            ->method('getHash')
            ->willReturn($hash);
        $request
            ->expects(self::never())
            ->method('getHeaders');
        $request
            ->expects(self::never())
            ->method('getFilteredHeaders');

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
    public function testGetBrowserWithoutCacheAndAnyDataFound(): void
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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getDeviceIsMobile');
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
                'manufacturer' => null,
                'brand' => null,
                'dualOrientation' => false,
                'simCount' => null,
                'display' => [
                    'width' => null,
                    'height' => null,
                    'touch' => null,
                    'size' => null,
                ],
                'type' => null,
                'ismobile' => false,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => null,
                'marketingName' => null,
                'version' => null,
                'manufacturer' => null,
            ],
            'client' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
                'type' => null,
                'isbot' => false,
            ],
            'engine' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
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
    public function testGetBrowserWithoutCacheButWithArchitectureData(): void
    {
        $hash    = 'test-hash';
        $headers = ['xyz' => 'abc'];

        $architecture = 'x86';

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
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getDeviceArchitecture')
            ->willReturn($architecture);
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
                'architecture' => $architecture,
                'deviceName' => null,
                'marketingName' => null,
                'manufacturer' => null,
                'brand' => null,
                'dualOrientation' => false,
                'simCount' => null,
                'display' => [
                    'width' => null,
                    'height' => null,
                    'touch' => null,
                    'size' => null,
                ],
                'type' => null,
                'ismobile' => false,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => null,
                'marketingName' => null,
                'version' => null,
                'manufacturer' => null,
            ],
            'client' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
                'type' => null,
                'isbot' => false,
            ],
            'engine' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
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
    public function testGetBrowserWithoutCacheButWithBitnessData(): void
    {
        $hash    = 'test-hash';
        $headers = ['xyz' => 'abc'];
        $bits    = 64;

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
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getDeviceBitness')
            ->willReturn($bits);
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
                'manufacturer' => null,
                'brand' => null,
                'dualOrientation' => false,
                'simCount' => null,
                'display' => [
                    'width' => null,
                    'height' => null,
                    'touch' => null,
                    'size' => null,
                ],
                'type' => null,
                'ismobile' => false,
                'istv' => false,
                'bits' => $bits,
            ],
            'os' => [
                'name' => null,
                'marketingName' => null,
                'version' => null,
                'manufacturer' => null,
            ],
            'client' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
                'type' => null,
                'isbot' => false,
            ],
            'engine' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
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
    public function testGetBrowserWithoutCacheButWithMobileData(): void
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
            ->willReturn(true);
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
                'manufacturer' => null,
                'brand' => null,
                'dualOrientation' => false,
                'simCount' => null,
                'display' => [
                    'width' => null,
                    'height' => null,
                    'touch' => null,
                    'size' => null,
                ],
                'type' => null,
                'ismobile' => true,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => null,
                'marketingName' => null,
                'version' => null,
                'manufacturer' => null,
            ],
            'client' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
                'type' => null,
                'isbot' => false,
            ],
            'engine' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
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
    public function testGetBrowserWithoutCacheButWithDeviceCode(): void
    {
        $hash                = 'test-hash';
        $headers             = ['xyz' => 'abc'];
        $deviceCodeForLoader = 'lg=lg lm-g710';
        $platformFromDevice  = 'android';

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
                'name' => 'Android',
                'marketingName' => 'Android',
                'version' => null,
                'manufacturer' => 'google',
            ],
            'client' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
                'type' => null,
                'isbot' => false,
            ],
            'engine' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
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
                    [
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
                    ],
                    $platformFromDevice,
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
            ->with($platformFromDevice, '')
            ->willReturn(
                [
                    'name' => 'Android',
                    'marketingName' => 'Android',
                    'version' => null,
                    'manufacturer' => 'google',
                ],
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

        $filteredHeaders = ['abc' => $header];

        $expected = [
            'headers' => $headers,
            'device' => [
                'architecture' => null,
                'deviceName' => null,
                'marketingName' => null,
                'manufacturer' => null,
                'brand' => null,
                'dualOrientation' => false,
                'simCount' => null,
                'display' => [
                    'width' => null,
                    'height' => null,
                    'touch' => null,
                    'size' => null,
                ],
                'type' => null,
                'ismobile' => false,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => null,
                'marketingName' => null,
                'version' => null,
                'manufacturer' => null,
            ],
            'client' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
                'type' => null,
                'isbot' => false,
            ],
            'engine' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
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
     */
    public function testGetBrowserWithoutCacheButWithPlatformCode(): void
    {
        $hash                = 'test-hash';
        $headerValue         = 'abc';
        $headers             = ['xyz' => $headerValue];
        $deviceCodeForLoader = 'lg=lg lm-g710';
        $platformFromDevice  = 'android';
        $platformCode        = 'linux';
        $platformVersion     = '2.4.5.6';
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
                'version' => $platformVersion,
                'manufacturer' => 'linux-foundation',
            ],
            'client' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
                'type' => null,
                'isbot' => false,
            ],
            'engine' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
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
                    [
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
                    ],
                    $platformFromDevice,
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
                [
                    'name' => 'Linux',
                    'marketingName' => 'Linux',
                    'version' => $platformVersion2,
                    'manufacturer' => 'linux-foundation',
                ],
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
            ->with($logger, null)
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
                'name' => null,
                'marketingName' => null,
                'version' => $platformVersion,
                'manufacturer' => null,
            ],
            'client' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
                'type' => null,
                'isbot' => false,
            ],
            'engine' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
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
                    [
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
                    ],
                    $platformFromDevice,
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
            ->with($logger, null)
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
    public function testGetBrowserWithoutCacheButWithPlatformCode3(): void
    {
        $hash                = 'test-hash';
        $headerValue         = 'abc';
        $headers             = ['xyz' => $headerValue];
        $deviceCodeForLoader = 'lg=lg lm-g710';
        $platformFromDevice  = 'android';
        $platformCode        = 'linux';

        $exception = new NotFoundException('device not found');

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
                'ismobile' => true,
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
                'manufacturer' => null,
                'type' => null,
                'isbot' => false,
            ],
            'engine' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
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
                    [
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
                    ],
                    $platformFromDevice,
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
                [
                    'name' => 'Linux',
                    'marketingName' => 'Linux',
                    'version' => null,
                    'manufacturer' => 'linux-foundation',
                ],
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
     */
    public function testGetBrowserWithoutCacheButWithPlatformCode4(): void
    {
        $hash                = 'test-hash';
        $headerValue         = 'abc';
        $headers             = ['xyz' => $headerValue];
        $deviceCodeForLoader = 'lg=lg lm-g710';
        $platformFromDevice  = 'android';
        $platformCode        = 'linux';

        $exception = new UnexpectedValueException('device not found');

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
                'ismobile' => true,
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
                'manufacturer' => null,
                'type' => null,
                'isbot' => false,
            ],
            'engine' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
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
                    [
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
                    ],
                    $platformFromDevice,
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
                [
                    'name' => 'Linux',
                    'marketingName' => 'Linux',
                    'version' => null,
                    'manufacturer' => 'linux-foundation',
                ],
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
     */
    public function testGetBrowserWithoutCacheButWithClientCode(): void
    {
        $hash        = 'test-hash';
        $headerValue = 'abc';
        $headers     = ['xyz' => $headerValue];
        $clientCode  = 'test-client';

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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getDeviceCode');
        $header
            ->expects(self::once())
            ->method('hasClientCode')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientCode')
            ->willReturn($clientCode);
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
                'manufacturer' => null,
                'brand' => null,
                'dualOrientation' => false,
                'simCount' => null,
                'display' => [
                    'width' => null,
                    'height' => null,
                    'touch' => null,
                    'size' => null,
                ],
                'type' => null,
                'ismobile' => false,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => null,
                'marketingName' => null,
                'version' => null,
                'manufacturer' => null,
            ],
            'client' => [
                'name' => 'Android WebView',
                'version' => null,
                'manufacturer' => 'google',
                'type' => 'browser',
                'isbot' => false,
            ],
            'engine' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
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
            ->expects(self::once())
            ->method('load')
            ->with($clientCode, $headerValue)
            ->willReturn(
                [
                    [
                        'name' => 'Android WebView',
                        'version' => null,
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => false,
                    ],
                    null,
                ],
            );

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
    public function testGetBrowserWithoutCacheButWithClientCode2(): void
    {
        $hash        = 'test-hash';
        $headerValue = 'abc';
        $headers     = ['xyz' => $headerValue];
        $clientCode  = 'test-client';

        $exception = new NotFoundException('device not found');

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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getDeviceCode');
        $header
            ->expects(self::once())
            ->method('hasClientCode')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientCode')
            ->willReturn($clientCode);
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
                'manufacturer' => null,
                'brand' => null,
                'dualOrientation' => false,
                'simCount' => null,
                'display' => [
                    'width' => null,
                    'height' => null,
                    'touch' => null,
                    'size' => null,
                ],
                'type' => null,
                'ismobile' => false,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => null,
                'marketingName' => null,
                'version' => null,
                'manufacturer' => null,
            ],
            'client' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
                'type' => null,
                'isbot' => false,
            ],
            'engine' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
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
            ->expects(self::once())
            ->method('load')
            ->with($clientCode, $headerValue)
            ->willThrowException($exception);

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
    public function testGetBrowserWithoutCacheButWithClientCode3(): void
    {
        $hash                     = 'test-hash';
        $headerValue              = 'abc';
        $headers                  = ['xyz' => $headerValue];
        $clientCode               = 'test-client';
        $clientVersion            = '1.2.34.56';
        $engineCodenameFromClient = 'blink';

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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getDeviceCode');
        $header
            ->expects(self::once())
            ->method('hasClientCode')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientCode')
            ->willReturn($clientCode);
        $header
            ->expects(self::once())
            ->method('hasClientVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientVersion')
            ->with($clientCode)
            ->willReturn($clientVersion);
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
                'manufacturer' => null,
                'brand' => null,
                'dualOrientation' => false,
                'simCount' => null,
                'display' => [
                    'width' => null,
                    'height' => null,
                    'touch' => null,
                    'size' => null,
                ],
                'type' => null,
                'ismobile' => false,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => null,
                'marketingName' => null,
                'version' => null,
                'manufacturer' => null,
            ],
            'client' => [
                'name' => 'Android WebView',
                'version' => $clientVersion,
                'manufacturer' => 'google',
                'type' => 'browser',
                'isbot' => true,
            ],
            'engine' => [
                'name' => 'Blink',
                'version' => null,
                'manufacturer' => 'google',
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
            ->expects(self::once())
            ->method('load')
            ->with($clientCode, $headerValue)
            ->willReturn(
                [
                    [
                        'name' => 'Android WebView',
                        'version' => null,
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => true,
                    ],
                    $engineCodenameFromClient,
                ],
            );

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineCodenameFromClient, '')
            ->willReturn(
                [
                    'name' => 'Blink',
                    'version' => null,
                    'manufacturer' => 'google',
                ],
            );

        $version = $this->createMock(VersionInterface::class);
        $version
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::COMPLETE)
            ->willReturn($clientVersion);

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with($clientVersion)
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
            ->with($logger, null)
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
    public function testGetBrowserWithoutCacheButWithClientCode4(): void
    {
        $hash                     = 'test-hash';
        $headerValue              = 'abc';
        $headers                  = ['xyz' => $headerValue];
        $clientCode               = 'test-client';
        $clientVersion            = '1.2.34.56';
        $engineCodenameFromClient = 'blink';
        $engineCode               = 'u3';
        $engineVersion            = '34.56.78.90';

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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getDeviceCode');
        $header
            ->expects(self::once())
            ->method('hasClientCode')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientCode')
            ->willReturn($clientCode);
        $header
            ->expects(self::once())
            ->method('hasClientVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientVersion')
            ->with($clientCode)
            ->willReturn($clientVersion);
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
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getEngineCode')
            ->willReturn($engineCode);
        $header
            ->expects(self::once())
            ->method('hasEngineVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getEngineVersion')
            ->with($engineCode)
            ->willReturn($engineVersion);

        $filteredHeaders = ['abc' => $header];

        $expected = [
            'headers' => $headers,
            'device' => [
                'architecture' => null,
                'deviceName' => null,
                'marketingName' => null,
                'manufacturer' => null,
                'brand' => null,
                'dualOrientation' => false,
                'simCount' => null,
                'display' => [
                    'width' => null,
                    'height' => null,
                    'touch' => null,
                    'size' => null,
                ],
                'type' => null,
                'ismobile' => false,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => null,
                'marketingName' => null,
                'version' => null,
                'manufacturer' => null,
            ],
            'client' => [
                'name' => 'Android WebView',
                'version' => $clientVersion,
                'manufacturer' => 'google',
                'type' => 'browser',
                'isbot' => true,
            ],
            'engine' => [
                'name' => 'U3',
                'version' => $engineVersion,
                'manufacturer' => 'ucweb',
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
            ->expects(self::once())
            ->method('load')
            ->with($clientCode, $headerValue)
            ->willReturn(
                [
                    [
                        'name' => 'Android WebView',
                        'version' => null,
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => true,
                    ],
                    $engineCodenameFromClient,
                ],
            );

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineCode, $headerValue)
            ->willReturn(
                [
                    'name' => 'U3',
                    'version' => null,
                    'manufacturer' => 'ucweb',
                ],
            );

        $version1 = $this->createMock(VersionInterface::class);
        $version1
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::COMPLETE)
            ->willReturn($clientVersion);

        $versionBuilder1 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder1
            ->expects(self::once())
            ->method('set')
            ->with($clientVersion)
            ->willReturn($version1);
        $versionBuilder1
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder1
            ->expects(self::never())
            ->method('setRegex');

        $version2 = $this->createMock(VersionInterface::class);
        $version2
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::COMPLETE)
            ->willReturn($engineVersion);

        $versionBuilder2 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder2
            ->expects(self::once())
            ->method('set')
            ->with($engineVersion)
            ->willReturn($version2);
        $versionBuilder2
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder2
            ->expects(self::never())
            ->method('setRegex');

        $versionBuilderFactory = $this->createMock(VersionBuilderFactoryInterface::class);
        $versionBuilderFactory
            ->expects(self::exactly(2))
            ->method('__invoke')
            ->with($logger, null)
            ->willReturn($versionBuilder1, $versionBuilder2);

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
    public function testGetBrowserWithoutCacheButWithClientCode5(): void
    {
        $hash                     = 'test-hash';
        $headerValue              = 'abc';
        $headers                  = ['xyz' => $headerValue];
        $clientCode               = 'test-client';
        $engineCodenameFromClient = 'blink';
        $engineCode               = 'u3';
        $engineVersion            = '34.56.78.90';

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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getDeviceCode');
        $header
            ->expects(self::once())
            ->method('hasClientCode')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientCode')
            ->willReturn($clientCode);
        $header
            ->expects(self::once())
            ->method('hasClientVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientVersion')
            ->with($clientCode)
            ->willThrowException($exception);
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
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getEngineCode')
            ->willReturn($engineCode);
        $header
            ->expects(self::once())
            ->method('hasEngineVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getEngineVersion')
            ->with($engineCode)
            ->willReturn($engineVersion);

        $filteredHeaders = ['abc' => $header];

        $expected = [
            'headers' => $headers,
            'device' => [
                'architecture' => null,
                'deviceName' => null,
                'marketingName' => null,
                'manufacturer' => null,
                'brand' => null,
                'dualOrientation' => false,
                'simCount' => null,
                'display' => [
                    'width' => null,
                    'height' => null,
                    'touch' => null,
                    'size' => null,
                ],
                'type' => null,
                'ismobile' => false,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => null,
                'marketingName' => null,
                'version' => null,
                'manufacturer' => null,
            ],
            'client' => [
                'name' => 'Android WebView',
                'version' => null,
                'manufacturer' => 'google',
                'type' => 'browser',
                'isbot' => true,
            ],
            'engine' => [
                'name' => 'U3',
                'version' => $engineVersion,
                'manufacturer' => 'ucweb',
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
            ->expects(self::once())
            ->method('load')
            ->with($clientCode, $headerValue)
            ->willReturn(
                [
                    [
                        'name' => 'Android WebView',
                        'version' => null,
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => true,
                    ],
                    $engineCodenameFromClient,
                ],
            );

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineCode, $headerValue)
            ->willReturn(
                [
                    'name' => 'U3',
                    'version' => null,
                    'manufacturer' => 'ucweb',
                ],
            );

        $version = $this->createMock(VersionInterface::class);
        $version
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::COMPLETE)
            ->willReturn($engineVersion);

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with($engineVersion)
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
            ->with($logger, null)
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
    public function testGetBrowserWithoutCacheButWithClientCode6(): void
    {
        $hash                     = 'test-hash';
        $headerValue              = 'abc';
        $headers                  = ['xyz' => $headerValue];
        $clientCode               = 'test-client';
        $clientVersion            = '1.2.34.56';
        $engineCodenameFromClient = 'blink';
        $engineCode               = 'webkit';
        $engineVersion            = '34.56.78.90';
        $platformCode             = 'ios';

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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getDeviceCode');
        $header
            ->expects(self::once())
            ->method('hasClientCode')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientCode')
            ->willReturn($clientCode);
        $header
            ->expects(self::once())
            ->method('hasClientVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientVersion')
            ->with($clientCode)
            ->willReturn($clientVersion);
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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getPlatformVersion');
        $header
            ->expects(self::never())
            ->method('hasEngineCode');
        $header
            ->expects(self::never())
            ->method('getEngineCode');
        $header
            ->expects(self::once())
            ->method('hasEngineVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getEngineVersion')
            ->with($engineCode)
            ->willReturn($engineVersion);

        $filteredHeaders = ['abc' => $header];

        $expected = [
            'headers' => $headers,
            'device' => [
                'architecture' => null,
                'deviceName' => null,
                'marketingName' => null,
                'manufacturer' => null,
                'brand' => null,
                'dualOrientation' => false,
                'simCount' => null,
                'display' => [
                    'width' => null,
                    'height' => null,
                    'touch' => null,
                    'size' => null,
                ],
                'type' => null,
                'ismobile' => false,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => 'iOS',
                'marketingName' => 'iOS',
                'version' => null,
                'manufacturer' => 'apple',
            ],
            'client' => [
                'name' => 'Android WebView',
                'version' => $clientVersion,
                'manufacturer' => 'google',
                'type' => 'browser',
                'isbot' => true,
            ],
            'engine' => [
                'name' => 'WebKit',
                'version' => $engineVersion,
                'manufacturer' => 'apple',
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
            ->expects(self::once())
            ->method('load')
            ->with($platformCode, $headerValue)
            ->willReturn(
                [
                    'name' => 'iOS',
                    'marketingName' => 'iOS',
                    'version' => null,
                    'manufacturer' => 'apple',
                ],
            );

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::once())
            ->method('load')
            ->with($clientCode, $headerValue)
            ->willReturn(
                [
                    [
                        'name' => 'Android WebView',
                        'version' => null,
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => true,
                    ],
                    $engineCodenameFromClient,
                ],
            );

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineCode, '')
            ->willReturn(
                [
                    'name' => 'WebKit',
                    'version' => null,
                    'manufacturer' => 'apple',
                ],
            );

        $version1 = $this->createMock(VersionInterface::class);
        $version1
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::IGNORE_MINOR)
            ->willReturn($clientVersion);

        $versionBuilder1 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder1
            ->expects(self::once())
            ->method('set')
            ->with('')
            ->willReturn($version1);
        $versionBuilder1
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder1
            ->expects(self::never())
            ->method('setRegex');

        $version2 = $this->createMock(VersionInterface::class);
        $version2
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::COMPLETE)
            ->willReturn($clientVersion);

        $versionBuilder2 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder2
            ->expects(self::once())
            ->method('set')
            ->with($clientVersion)
            ->willReturn($version2);
        $versionBuilder2
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder2
            ->expects(self::never())
            ->method('setRegex');

        $version3 = $this->createMock(VersionInterface::class);
        $version3
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::COMPLETE)
            ->willReturn($engineVersion);

        $versionBuilder3 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder3
            ->expects(self::once())
            ->method('set')
            ->with($engineVersion)
            ->willReturn($version3);
        $versionBuilder3
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder3
            ->expects(self::never())
            ->method('setRegex');

        $versionBuilderFactory = $this->createMock(VersionBuilderFactoryInterface::class);
        $versionBuilderFactory
            ->expects(self::exactly(3))
            ->method('__invoke')
            ->with($logger, null)
            ->willReturn($versionBuilder1, $versionBuilder2, $versionBuilder3);

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
    public function testGetBrowserWithoutCacheButWithClientCode7(): void
    {
        $hash                     = 'test-hash';
        $headerValue              = 'abc';
        $headers                  = ['xyz' => $headerValue];
        $clientCode               = 'test-client';
        $clientVersion            = '1.2.34.56';
        $engineCodenameFromClient = 'blink';
        $engineCode               = 'webkit';
        $engineVersion            = '34.56.78.90';
        $platformCode             = 'ios';

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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getDeviceCode');
        $header
            ->expects(self::once())
            ->method('hasClientCode')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientCode')
            ->willReturn($clientCode);
        $header
            ->expects(self::once())
            ->method('hasClientVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientVersion')
            ->with($clientCode)
            ->willReturn($clientVersion);
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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getPlatformVersion');
        $header
            ->expects(self::never())
            ->method('hasEngineCode');
        $header
            ->expects(self::never())
            ->method('getEngineCode');
        $header
            ->expects(self::once())
            ->method('hasEngineVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getEngineVersion')
            ->with($engineCode)
            ->willReturn($engineVersion);

        $filteredHeaders = ['abc' => $header];

        $expected = [
            'headers' => $headers,
            'device' => [
                'architecture' => null,
                'deviceName' => null,
                'marketingName' => null,
                'manufacturer' => null,
                'brand' => null,
                'dualOrientation' => false,
                'simCount' => null,
                'display' => [
                    'width' => null,
                    'height' => null,
                    'touch' => null,
                    'size' => null,
                ],
                'type' => null,
                'ismobile' => false,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => 'iOS',
                'marketingName' => 'iOS',
                'version' => null,
                'manufacturer' => 'apple',
            ],
            'client' => [
                'name' => 'Android WebView',
                'version' => $clientVersion,
                'manufacturer' => 'google',
                'type' => 'browser',
                'isbot' => true,
            ],
            'engine' => [
                'name' => null,
                'version' => $engineVersion,
                'manufacturer' => null,
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

        $deviceLoaderFactory = $this->createMock(DeviceLoaderFactoryInterface::class);
        $deviceLoaderFactory
            ->expects(self::never())
            ->method('__invoke');

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with($platformCode, $headerValue)
            ->willReturn(
                [
                    'name' => 'iOS',
                    'marketingName' => 'iOS',
                    'version' => null,
                    'manufacturer' => 'apple',
                ],
            );

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::once())
            ->method('load')
            ->with($clientCode, $headerValue)
            ->willReturn(
                [
                    [
                        'name' => 'Android WebView',
                        'version' => null,
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => true,
                    ],
                    $engineCodenameFromClient,
                ],
            );

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineCode, '')
            ->willThrowException($exception);

        $version1 = $this->createMock(VersionInterface::class);
        $version1
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::IGNORE_MINOR)
            ->willReturn(null);

        $versionBuilder1 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder1
            ->expects(self::once())
            ->method('set')
            ->with('')
            ->willReturn($version1);
        $versionBuilder1
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder1
            ->expects(self::never())
            ->method('setRegex');

        $version2 = $this->createMock(VersionInterface::class);
        $version2
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::COMPLETE)
            ->willReturn($clientVersion);

        $versionBuilder2 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder2
            ->expects(self::once())
            ->method('set')
            ->with($clientVersion)
            ->willReturn($version2);
        $versionBuilder2
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder2
            ->expects(self::never())
            ->method('setRegex');

        $version3 = $this->createMock(VersionInterface::class);
        $version3
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::COMPLETE)
            ->willReturn($engineVersion);

        $versionBuilder3 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder3
            ->expects(self::once())
            ->method('set')
            ->with($engineVersion)
            ->willReturn($version3);
        $versionBuilder3
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder3
            ->expects(self::never())
            ->method('setRegex');

        $versionBuilderFactory = $this->createMock(VersionBuilderFactoryInterface::class);
        $versionBuilderFactory
            ->expects(self::exactly(3))
            ->method('__invoke')
            ->with($logger, null)
            ->willReturn($versionBuilder1, $versionBuilder2, $versionBuilder3);

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
    public function testGetBrowserWithoutCacheButWithClientCode8(): void
    {
        $hash                     = 'test-hash';
        $headerValue              = 'abc';
        $headers                  = ['xyz' => $headerValue];
        $clientCode               = 'test-client';
        $clientVersion            = '1.2.34.56';
        $engineCodenameFromClient = 'blink';
        $engineCode               = 'webkit';
        $platformCode             = 'ios';

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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getDeviceCode');
        $header
            ->expects(self::once())
            ->method('hasClientCode')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientCode')
            ->willReturn($clientCode);
        $header
            ->expects(self::once())
            ->method('hasClientVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientVersion')
            ->with($clientCode)
            ->willReturn($clientVersion);
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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getPlatformVersion');
        $header
            ->expects(self::never())
            ->method('hasEngineCode');
        $header
            ->expects(self::never())
            ->method('getEngineCode');
        $header
            ->expects(self::once())
            ->method('hasEngineVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getEngineVersion')
            ->with($engineCode)
            ->willThrowException($exception);

        $filteredHeaders = ['abc' => $header];

        $expected = [
            'headers' => $headers,
            'device' => [
                'architecture' => null,
                'deviceName' => null,
                'marketingName' => null,
                'manufacturer' => null,
                'brand' => null,
                'dualOrientation' => false,
                'simCount' => null,
                'display' => [
                    'width' => null,
                    'height' => null,
                    'touch' => null,
                    'size' => null,
                ],
                'type' => null,
                'ismobile' => false,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => 'iOS',
                'marketingName' => 'iOS',
                'version' => null,
                'manufacturer' => 'apple',
            ],
            'client' => [
                'name' => 'Android WebView',
                'version' => $clientVersion,
                'manufacturer' => 'google',
                'type' => 'browser',
                'isbot' => true,
            ],
            'engine' => [
                'name' => 'WebKit',
                'version' => null,
                'manufacturer' => 'apple',
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

        $deviceLoaderFactory = $this->createMock(DeviceLoaderFactoryInterface::class);
        $deviceLoaderFactory
            ->expects(self::never())
            ->method('__invoke');

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with($platformCode, $headerValue)
            ->willReturn(
                [
                    'name' => 'iOS',
                    'marketingName' => 'iOS',
                    'version' => null,
                    'manufacturer' => 'apple',
                ],
            );

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::once())
            ->method('load')
            ->with($clientCode, $headerValue)
            ->willReturn(
                [
                    [
                        'name' => 'Android WebView',
                        'version' => null,
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => true,
                    ],
                    $engineCodenameFromClient,
                ],
            );

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineCode, '')
            ->willReturn(
                [
                    'name' => 'WebKit',
                    'version' => null,
                    'manufacturer' => 'apple',
                ],
            );

        $version1 = $this->createMock(VersionInterface::class);
        $version1
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::IGNORE_MINOR)
            ->willReturn(null);

        $versionBuilder1 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder1
            ->expects(self::once())
            ->method('set')
            ->with('')
            ->willReturn($version1);
        $versionBuilder1
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder1
            ->expects(self::never())
            ->method('setRegex');

        $version2 = $this->createMock(VersionInterface::class);
        $version2
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::COMPLETE)
            ->willReturn($clientVersion);

        $versionBuilder2 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder2
            ->expects(self::once())
            ->method('set')
            ->with($clientVersion)
            ->willReturn($version2);
        $versionBuilder2
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder2
            ->expects(self::never())
            ->method('setRegex');

        $versionBuilderFactory = $this->createMock(VersionBuilderFactoryInterface::class);
        $versionBuilderFactory
            ->expects(self::exactly(2))
            ->method('__invoke')
            ->with($logger, null)
            ->willReturn($versionBuilder1, $versionBuilder2);

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
    public function testGetBrowserWithoutCacheButWithClientCode9(): void
    {
        $hash                     = 'test-hash';
        $headerValue              = 'abc';
        $headers                  = ['xyz' => $headerValue];
        $clientCode               = 'test-client';
        $clientVersion            = '1.2.34.56';
        $engineCodenameFromClient = 'blink';
        $engineCode               = 'webkit';
        $platformCode             = 'ios';

        $exception = new UnexpectedValueException('device not found');

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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getDeviceCode');
        $header
            ->expects(self::once())
            ->method('hasClientCode')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientCode')
            ->willReturn($clientCode);
        $header
            ->expects(self::once())
            ->method('hasClientVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientVersion')
            ->with($clientCode)
            ->willReturn($clientVersion);
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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getPlatformVersion');
        $header
            ->expects(self::never())
            ->method('hasEngineCode');
        $header
            ->expects(self::never())
            ->method('getEngineCode');
        $header
            ->expects(self::once())
            ->method('hasEngineVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getEngineVersion')
            ->with($engineCode)
            ->willThrowException($exception);

        $filteredHeaders = ['abc' => $header];

        $expected = [
            'headers' => $headers,
            'device' => [
                'architecture' => null,
                'deviceName' => null,
                'marketingName' => null,
                'manufacturer' => null,
                'brand' => null,
                'dualOrientation' => false,
                'simCount' => null,
                'display' => [
                    'width' => null,
                    'height' => null,
                    'touch' => null,
                    'size' => null,
                ],
                'type' => null,
                'ismobile' => false,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => 'iOS',
                'marketingName' => 'iOS',
                'version' => null,
                'manufacturer' => 'apple',
            ],
            'client' => [
                'name' => 'Android WebView',
                'version' => $clientVersion,
                'manufacturer' => 'google',
                'type' => 'browser',
                'isbot' => true,
            ],
            'engine' => [
                'name' => 'WebKit',
                'version' => null,
                'manufacturer' => 'apple',
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

        $deviceLoaderFactory = $this->createMock(DeviceLoaderFactoryInterface::class);
        $deviceLoaderFactory
            ->expects(self::never())
            ->method('__invoke');

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with($platformCode, $headerValue)
            ->willReturn(
                [
                    'name' => 'iOS',
                    'marketingName' => 'iOS',
                    'version' => null,
                    'manufacturer' => 'apple',
                ],
            );

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::once())
            ->method('load')
            ->with($clientCode, $headerValue)
            ->willReturn(
                [
                    [
                        'name' => 'Android WebView',
                        'version' => null,
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => true,
                    ],
                    $engineCodenameFromClient,
                ],
            );

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineCode, '')
            ->willReturn(
                [
                    'name' => 'WebKit',
                    'version' => null,
                    'manufacturer' => 'apple',
                ],
            );

        $version1 = $this->createMock(VersionInterface::class);
        $version1
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::IGNORE_MINOR)
            ->willReturn(null);

        $versionBuilder1 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder1
            ->expects(self::once())
            ->method('set')
            ->with('')
            ->willReturn($version1);
        $versionBuilder1
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder1
            ->expects(self::never())
            ->method('setRegex');

        $version2 = $this->createMock(VersionInterface::class);
        $version2
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::COMPLETE)
            ->willReturn($clientVersion);

        $versionBuilder2 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder2
            ->expects(self::once())
            ->method('set')
            ->with($clientVersion)
            ->willReturn($version2);
        $versionBuilder2
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder2
            ->expects(self::never())
            ->method('setRegex');

        $versionBuilderFactory = $this->createMock(VersionBuilderFactoryInterface::class);
        $versionBuilderFactory
            ->expects(self::exactly(2))
            ->method('__invoke')
            ->with($logger, null)
            ->willReturn($versionBuilder1, $versionBuilder2);

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
    public function testGetBrowserWithoutCacheButWithClientCode10(): void
    {
        $hash                     = 'test-hash';
        $headerValue              = 'abc';
        $headers                  = ['xyz' => $headerValue];
        $clientCode               = 'test-client';
        $engineCodenameFromClient = 'blink';
        $engineCode               = 'u3';
        $engineVersion            = '34.56.78.90';

        $exception = new UnexpectedValueException('device not found');

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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getDeviceCode');
        $header
            ->expects(self::once())
            ->method('hasClientCode')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientCode')
            ->willReturn($clientCode);
        $header
            ->expects(self::once())
            ->method('hasClientVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientVersion')
            ->with($clientCode)
            ->willThrowException($exception);
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
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getEngineCode')
            ->willReturn($engineCode);
        $header
            ->expects(self::once())
            ->method('hasEngineVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getEngineVersion')
            ->with($engineCode)
            ->willReturn($engineVersion);

        $filteredHeaders = ['abc' => $header];

        $expected = [
            'headers' => $headers,
            'device' => [
                'architecture' => null,
                'deviceName' => null,
                'marketingName' => null,
                'manufacturer' => null,
                'brand' => null,
                'dualOrientation' => false,
                'simCount' => null,
                'display' => [
                    'width' => null,
                    'height' => null,
                    'touch' => null,
                    'size' => null,
                ],
                'type' => null,
                'ismobile' => false,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => null,
                'marketingName' => null,
                'version' => null,
                'manufacturer' => null,
            ],
            'client' => [
                'name' => 'Android WebView',
                'version' => null,
                'manufacturer' => 'google',
                'type' => 'browser',
                'isbot' => true,
            ],
            'engine' => [
                'name' => 'U3',
                'version' => $engineVersion,
                'manufacturer' => 'ucweb',
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
            ->expects(self::once())
            ->method('load')
            ->with($clientCode, $headerValue)
            ->willReturn(
                [
                    [
                        'name' => 'Android WebView',
                        'version' => null,
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => true,
                    ],
                    $engineCodenameFromClient,
                ],
            );

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineCode, $headerValue)
            ->willReturn(
                [
                    'name' => 'U3',
                    'version' => null,
                    'manufacturer' => 'ucweb',
                ],
            );

        $version = $this->createMock(VersionInterface::class);
        $version
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::COMPLETE)
            ->willReturn($engineVersion);

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with($engineVersion)
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
            ->with($logger, null)
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
    public function testGetBrowserWithoutCacheButWithClientCode11(): void
    {
        $hash                     = 'test-hash';
        $headerValue              = 'abc';
        $headers                  = ['xyz' => $headerValue];
        $clientCode               = 'test-client';
        $clientVersion            = '1.2.34.56';
        $engineCodenameFromClient = 'blink';
        $engineCode               = 'webkit';
        $platformCode             = 'ios';
        $platformFromDevice       = 'ios';
        $deviceCodeForLoader      = 'apple=apple ipad';
        $platformVersion          = '12.0';

        $exception = new UnexpectedValueException('device not found');

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
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientCode')
            ->willReturn($clientCode);
        $header
            ->expects(self::once())
            ->method('hasClientVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientVersion')
            ->with($clientCode)
            ->willReturn($clientVersion);
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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getPlatformVersion');
        $header
            ->expects(self::never())
            ->method('hasEngineCode');
        $header
            ->expects(self::never())
            ->method('getEngineCode');
        $header
            ->expects(self::once())
            ->method('hasEngineVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getEngineVersion')
            ->with($engineCode)
            ->willThrowException($exception);

        $filteredHeaders = ['abc' => $header];

        $expected = [
            'headers' => $headers,
            'device' => [
                'architecture' => null,
                'deviceName' => 'iPad',
                'marketingName' => 'iPad',
                'manufacturer' => 'apple',
                'brand' => 'apple',
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
                'name' => 'iOS',
                'marketingName' => 'iOS',
                'version' => $platformVersion,
                'manufacturer' => 'apple',
            ],
            'client' => [
                'name' => 'Android WebView',
                'version' => $clientVersion,
                'manufacturer' => 'google',
                'type' => 'browser',
                'isbot' => true,
            ],
            'engine' => [
                'name' => 'WebKit',
                'version' => null,
                'manufacturer' => 'apple',
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
            ->with('apple ipad')
            ->willReturn(
                [
                    [
                        'deviceName' => 'iPad',
                        'marketingName' => 'iPad',
                        'manufacturer' => 'apple',
                        'brand' => 'apple',
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
                    ],
                    $platformFromDevice,
                ],
            );

        $deviceLoaderFactory = $this->createMock(DeviceLoaderFactoryInterface::class);
        $deviceLoaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('apple')
            ->willReturn($deviceLoader);

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with($platformCode, $headerValue)
            ->willReturn(
                [
                    'name' => 'iOS',
                    'marketingName' => 'iOS',
                    'version' => $platformVersion,
                    'manufacturer' => 'apple',
                ],
            );

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::once())
            ->method('load')
            ->with($clientCode, $headerValue)
            ->willReturn(
                [
                    [
                        'name' => 'Android WebView',
                        'version' => null,
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => true,
                    ],
                    $engineCodenameFromClient,
                ],
            );

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineCode, '')
            ->willReturn(
                [
                    'name' => 'WebKit',
                    'version' => null,
                    'manufacturer' => 'apple',
                ],
            );

        $version1 = $this->createMock(VersionInterface::class);
        $version1
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::IGNORE_MINOR)
            ->willReturn($platformVersion);

        $versionBuilder1 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder1
            ->expects(self::once())
            ->method('set')
            ->with($platformVersion)
            ->willReturn($version1);
        $versionBuilder1
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder1
            ->expects(self::never())
            ->method('setRegex');

        $version2 = $this->createMock(VersionInterface::class);
        $version2
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::COMPLETE)
            ->willReturn($clientVersion);

        $versionBuilder2 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder2
            ->expects(self::once())
            ->method('set')
            ->with($clientVersion)
            ->willReturn($version2);
        $versionBuilder2
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder2
            ->expects(self::never())
            ->method('setRegex');

        $versionBuilderFactory = $this->createMock(VersionBuilderFactoryInterface::class);
        $versionBuilderFactory
            ->expects(self::exactly(2))
            ->method('__invoke')
            ->with($logger, null)
            ->willReturn($versionBuilder1, $versionBuilder2);

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
    public function testGetBrowserWithoutCacheButWithClientCode12(): void
    {
        $hash                     = 'test-hash';
        $headerValue              = 'abc';
        $headers                  = ['xyz' => $headerValue];
        $clientCode               = 'test-client';
        $clientVersion            = '1.2.34.56';
        $engineCodenameFromClient = 'blink';
        $engineCode               = 'webkit';
        $platformCode             = 'ios';
        $platformFromDevice       = 'ios';
        $deviceCodeForLoader      = 'apple=apple ipad';
        $platformVersion          = '13.0.0';

        $exception = new UnexpectedValueException('device not found');

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
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientCode')
            ->willReturn($clientCode);
        $header
            ->expects(self::once())
            ->method('hasClientVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientVersion')
            ->with($clientCode)
            ->willReturn($clientVersion);
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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getPlatformVersion');
        $header
            ->expects(self::never())
            ->method('hasEngineCode');
        $header
            ->expects(self::never())
            ->method('getEngineCode');
        $header
            ->expects(self::once())
            ->method('hasEngineVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getEngineVersion')
            ->with($engineCode)
            ->willThrowException($exception);

        $filteredHeaders = ['abc' => $header];

        $expected = [
            'headers' => $headers,
            'device' => [
                'architecture' => null,
                'deviceName' => 'iPad',
                'marketingName' => 'iPad',
                'manufacturer' => 'apple',
                'brand' => 'apple',
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
                'name' => 'iPadOS',
                'marketingName' => 'iPadOS',
                'version' => $platformVersion,
                'manufacturer' => 'apple',
            ],
            'client' => [
                'name' => 'Android WebView',
                'version' => $clientVersion,
                'manufacturer' => 'google',
                'type' => 'browser',
                'isbot' => true,
            ],
            'engine' => [
                'name' => 'WebKit',
                'version' => null,
                'manufacturer' => 'apple',
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
            ->with('apple ipad')
            ->willReturn(
                [
                    [
                        'deviceName' => 'iPad',
                        'marketingName' => 'iPad',
                        'manufacturer' => 'apple',
                        'brand' => 'apple',
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
                    ],
                    $platformFromDevice,
                ],
            );

        $deviceLoaderFactory = $this->createMock(DeviceLoaderFactoryInterface::class);
        $deviceLoaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('apple')
            ->willReturn($deviceLoader);

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with($platformCode, $headerValue)
            ->willReturn(
                [
                    'name' => 'iOS',
                    'marketingName' => 'iOS',
                    'version' => $platformVersion,
                    'manufacturer' => 'apple',
                ],
            );

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::once())
            ->method('load')
            ->with($clientCode, $headerValue)
            ->willReturn(
                [
                    [
                        'name' => 'Android WebView',
                        'version' => null,
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => true,
                    ],
                    $engineCodenameFromClient,
                ],
            );

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineCode, '')
            ->willReturn(
                [
                    'name' => 'WebKit',
                    'version' => null,
                    'manufacturer' => 'apple',
                ],
            );

        $version1 = $this->createMock(VersionInterface::class);
        $version1
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::IGNORE_MINOR)
            ->willReturn((string) (int) $platformVersion);

        $versionBuilder1 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder1
            ->expects(self::once())
            ->method('set')
            ->with($platformVersion)
            ->willReturn($version1);
        $versionBuilder1
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder1
            ->expects(self::never())
            ->method('setRegex');

        $version2 = $this->createMock(VersionInterface::class);
        $version2
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::COMPLETE)
            ->willReturn($clientVersion);

        $versionBuilder2 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder2
            ->expects(self::once())
            ->method('set')
            ->with($clientVersion)
            ->willReturn($version2);
        $versionBuilder2
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder2
            ->expects(self::never())
            ->method('setRegex');

        $versionBuilderFactory = $this->createMock(VersionBuilderFactoryInterface::class);
        $versionBuilderFactory
            ->expects(self::exactly(2))
            ->method('__invoke')
            ->with($logger, null)
            ->willReturn($versionBuilder1, $versionBuilder2);

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
    public function testGetBrowserWithoutCacheButWithClientCode13(): void
    {
        $hash                     = 'test-hash';
        $headerValue              = 'abc';
        $headers                  = ['xyz' => $headerValue];
        $clientCode               = 'test-client';
        $clientVersion            = '1.2.34.56';
        $engineCodenameFromClient = 'blink';
        $engineCode               = 'webkit';
        $platformCode             = 'ios';
        $platformFromDevice       = 'ios';
        $deviceCodeForLoader      = 'apple=apple ipad';
        $platformVersion          = '14.0.0';

        $exception = new UnexpectedValueException('device not found');

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
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientCode')
            ->willReturn($clientCode);
        $header
            ->expects(self::once())
            ->method('hasClientVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientVersion')
            ->with($clientCode)
            ->willReturn($clientVersion);
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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getPlatformVersion');
        $header
            ->expects(self::never())
            ->method('hasEngineCode');
        $header
            ->expects(self::never())
            ->method('getEngineCode');
        $header
            ->expects(self::once())
            ->method('hasEngineVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getEngineVersion')
            ->with($engineCode)
            ->willThrowException($exception);

        $filteredHeaders = ['abc' => $header];

        $expected = [
            'headers' => $headers,
            'device' => [
                'architecture' => null,
                'deviceName' => 'iPad',
                'marketingName' => 'iPad',
                'manufacturer' => 'apple',
                'brand' => 'apple',
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
                'name' => 'iPadOS',
                'marketingName' => 'iPadOS',
                'version' => $platformVersion,
                'manufacturer' => 'apple',
            ],
            'client' => [
                'name' => 'Android WebView',
                'version' => $clientVersion,
                'manufacturer' => 'google',
                'type' => 'browser',
                'isbot' => true,
            ],
            'engine' => [
                'name' => 'WebKit',
                'version' => null,
                'manufacturer' => 'apple',
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
            ->with('apple ipad')
            ->willReturn(
                [
                    [
                        'deviceName' => 'iPad',
                        'marketingName' => 'iPad',
                        'manufacturer' => 'apple',
                        'brand' => 'apple',
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
                    ],
                    $platformFromDevice,
                ],
            );

        $deviceLoaderFactory = $this->createMock(DeviceLoaderFactoryInterface::class);
        $deviceLoaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('apple')
            ->willReturn($deviceLoader);

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with($platformCode, $headerValue)
            ->willReturn(
                [
                    'name' => 'iOS',
                    'marketingName' => 'iOS',
                    'version' => $platformVersion,
                    'manufacturer' => 'apple',
                ],
            );

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::once())
            ->method('load')
            ->with($clientCode, $headerValue)
            ->willReturn(
                [
                    [
                        'name' => 'Android WebView',
                        'version' => null,
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => true,
                    ],
                    $engineCodenameFromClient,
                ],
            );

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineCode, '')
            ->willReturn(
                [
                    'name' => 'WebKit',
                    'version' => null,
                    'manufacturer' => 'apple',
                ],
            );

        $version1 = $this->createMock(VersionInterface::class);
        $version1
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::IGNORE_MINOR)
            ->willReturn((string) (int) $platformVersion);

        $versionBuilder1 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder1
            ->expects(self::once())
            ->method('set')
            ->with($platformVersion)
            ->willReturn($version1);
        $versionBuilder1
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder1
            ->expects(self::never())
            ->method('setRegex');

        $version2 = $this->createMock(VersionInterface::class);
        $version2
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::COMPLETE)
            ->willReturn($clientVersion);

        $versionBuilder2 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder2
            ->expects(self::once())
            ->method('set')
            ->with($clientVersion)
            ->willReturn($version2);
        $versionBuilder2
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder2
            ->expects(self::never())
            ->method('setRegex');

        $versionBuilderFactory = $this->createMock(VersionBuilderFactoryInterface::class);
        $versionBuilderFactory
            ->expects(self::exactly(2))
            ->method('__invoke')
            ->with($logger, null)
            ->willReturn($versionBuilder1, $versionBuilder2);

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
    public function testGetBrowserWithoutCacheButWithClientCode14(): void
    {
        $hash                     = 'test-hash';
        $headerValue              = 'abc';
        $headers                  = ['xyz' => $headerValue];
        $clientCode               = 'test-client';
        $clientVersion            = '1.2.34.56';
        $engineCodenameFromClient = 'blink';
        $engineCode               = 'webkit';
        $platformCode             = 'ios';
        $platformFromDevice       = 'ios';
        $deviceCodeForLoader      = 'apple=apple ipad';
        $platformVersion          = 'a.x.y';

        $exception1 = new UnexpectedValueException('device not found');
        $exception2 = new NotNumericException('device not found');

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
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientCode')
            ->willReturn($clientCode);
        $header
            ->expects(self::once())
            ->method('hasClientVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientVersion')
            ->with($clientCode)
            ->willReturn($clientVersion);
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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getPlatformVersion');
        $header
            ->expects(self::never())
            ->method('hasEngineCode');
        $header
            ->expects(self::never())
            ->method('getEngineCode');
        $header
            ->expects(self::once())
            ->method('hasEngineVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getEngineVersion')
            ->with($engineCode)
            ->willThrowException($exception1);

        $filteredHeaders = ['abc' => $header];

        $expected = [
            'headers' => $headers,
            'device' => [
                'architecture' => null,
                'deviceName' => 'iPad',
                'marketingName' => 'iPad',
                'manufacturer' => 'apple',
                'brand' => 'apple',
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
                'name' => 'iOS',
                'marketingName' => 'iOS',
                'version' => $platformVersion,
                'manufacturer' => 'apple',
            ],
            'client' => [
                'name' => 'Android WebView',
                'version' => $clientVersion,
                'manufacturer' => 'google',
                'type' => 'browser',
                'isbot' => true,
            ],
            'engine' => [
                'name' => 'WebKit',
                'version' => null,
                'manufacturer' => 'apple',
            ],
        ];

        $logger  = $this->createMock(LoggerInterface::class);
        $matcher = self::exactly(2);
        $logger
            ->expects($matcher)
            ->method('info')
            ->willReturnCallback(
                static function (string | Stringable $message, array $context = []) use ($matcher, $exception2, $exception1): void {
                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame($exception2, $message),
                        default => self::assertSame($exception1, $message),
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
            ->with('apple ipad')
            ->willReturn(
                [
                    [
                        'deviceName' => 'iPad',
                        'marketingName' => 'iPad',
                        'manufacturer' => 'apple',
                        'brand' => 'apple',
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
                    ],
                    $platformFromDevice,
                ],
            );

        $deviceLoaderFactory = $this->createMock(DeviceLoaderFactoryInterface::class);
        $deviceLoaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('apple')
            ->willReturn($deviceLoader);

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with($platformCode, $headerValue)
            ->willReturn(
                [
                    'name' => 'iOS',
                    'marketingName' => 'iOS',
                    'version' => $platformVersion,
                    'manufacturer' => 'apple',
                ],
            );

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::once())
            ->method('load')
            ->with($clientCode, $headerValue)
            ->willReturn(
                [
                    [
                        'name' => 'Android WebView',
                        'version' => null,
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => true,
                    ],
                    $engineCodenameFromClient,
                ],
            );

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineCode, '')
            ->willReturn(
                [
                    'name' => 'WebKit',
                    'version' => null,
                    'manufacturer' => 'apple',
                ],
            );

        $version1 = $this->createMock(VersionInterface::class);
        $version1
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::IGNORE_MINOR)
            ->willThrowException($exception2);

        $versionBuilder1 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder1
            ->expects(self::once())
            ->method('set')
            ->with($platformVersion)
            ->willReturn($version1);
        $versionBuilder1
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder1
            ->expects(self::never())
            ->method('setRegex');

        $version2 = $this->createMock(VersionInterface::class);
        $version2
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::COMPLETE)
            ->willReturn($clientVersion);

        $versionBuilder2 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder2
            ->expects(self::once())
            ->method('set')
            ->with($clientVersion)
            ->willReturn($version2);
        $versionBuilder2
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder2
            ->expects(self::never())
            ->method('setRegex');

        $versionBuilderFactory = $this->createMock(VersionBuilderFactoryInterface::class);
        $versionBuilderFactory
            ->expects(self::exactly(2))
            ->method('__invoke')
            ->with($logger, null)
            ->willReturn($versionBuilder1, $versionBuilder2);

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
    public function testGetBrowserWithoutCacheButWithClientCode15(): void
    {
        $hash                     = 'test-hash';
        $headerValue              = 'abc';
        $headers                  = ['xyz' => $headerValue];
        $clientCode               = 'test-client';
        $clientVersion            = '1.2.34.56';
        $engineCodenameFromClient = 'blink';
        $engineCode               = 'webkit';
        $platformCode             = 'ios';
        $platformFromDevice       = 'ios';
        $deviceCodeForLoader      = 'apple=apple ipad';
        $platformVersion          = 'a.x.y';

        $exception1 = new UnexpectedValueException('device not found');
        $exception2 = new UnexpectedValueException('device not found');

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
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientCode')
            ->willReturn($clientCode);
        $header
            ->expects(self::once())
            ->method('hasClientVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientVersion')
            ->with($clientCode)
            ->willReturn($clientVersion);
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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getPlatformVersion');
        $header
            ->expects(self::never())
            ->method('hasEngineCode');
        $header
            ->expects(self::never())
            ->method('getEngineCode');
        $header
            ->expects(self::once())
            ->method('hasEngineVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getEngineVersion')
            ->with($engineCode)
            ->willThrowException($exception1);

        $filteredHeaders = ['abc' => $header];

        $expected = [
            'headers' => $headers,
            'device' => [
                'architecture' => null,
                'deviceName' => 'iPad',
                'marketingName' => 'iPad',
                'manufacturer' => 'apple',
                'brand' => 'apple',
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
                'name' => 'iOS',
                'marketingName' => 'iOS',
                'version' => $platformVersion,
                'manufacturer' => 'apple',
            ],
            'client' => [
                'name' => 'Android WebView',
                'version' => $clientVersion,
                'manufacturer' => 'google',
                'type' => 'browser',
                'isbot' => true,
            ],
            'engine' => [
                'name' => 'WebKit',
                'version' => null,
                'manufacturer' => 'apple',
            ],
        ];

        $logger  = $this->createMock(LoggerInterface::class);
        $matcher = self::exactly(2);
        $logger
            ->expects($matcher)
            ->method('info')
            ->willReturnCallback(
                static function (string | Stringable $message, array $context = []) use ($matcher, $exception2, $exception1): void {
                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame($exception2, $message),
                        default => self::assertSame($exception1, $message),
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
            ->with('apple ipad')
            ->willReturn(
                [
                    [
                        'deviceName' => 'iPad',
                        'marketingName' => 'iPad',
                        'manufacturer' => 'apple',
                        'brand' => 'apple',
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
                    ],
                    $platformFromDevice,
                ],
            );

        $deviceLoaderFactory = $this->createMock(DeviceLoaderFactoryInterface::class);
        $deviceLoaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('apple')
            ->willReturn($deviceLoader);

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with($platformCode, $headerValue)
            ->willReturn(
                [
                    'name' => 'iOS',
                    'marketingName' => 'iOS',
                    'version' => $platformVersion,
                    'manufacturer' => 'apple',
                ],
            );

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::once())
            ->method('load')
            ->with($clientCode, $headerValue)
            ->willReturn(
                [
                    [
                        'name' => 'Android WebView',
                        'version' => null,
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => true,
                    ],
                    $engineCodenameFromClient,
                ],
            );

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineCode, '')
            ->willReturn(
                [
                    'name' => 'WebKit',
                    'version' => null,
                    'manufacturer' => 'apple',
                ],
            );

        $version1 = $this->createMock(VersionInterface::class);
        $version1
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::IGNORE_MINOR)
            ->willThrowException($exception2);

        $versionBuilder1 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder1
            ->expects(self::once())
            ->method('set')
            ->with($platformVersion)
            ->willReturn($version1);
        $versionBuilder1
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder1
            ->expects(self::never())
            ->method('setRegex');

        $version2 = $this->createMock(VersionInterface::class);
        $version2
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::COMPLETE)
            ->willReturn($clientVersion);

        $versionBuilder2 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder2
            ->expects(self::once())
            ->method('set')
            ->with($clientVersion)
            ->willReturn($version2);
        $versionBuilder2
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder2
            ->expects(self::never())
            ->method('setRegex');

        $versionBuilderFactory = $this->createMock(VersionBuilderFactoryInterface::class);
        $versionBuilderFactory
            ->expects(self::exactly(2))
            ->method('__invoke')
            ->with($logger, null)
            ->willReturn($versionBuilder1, $versionBuilder2);

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
    public function testGetBrowserWithoutCacheButWithClientCode16(): void
    {
        $hash                     = 'test-hash';
        $headerValue              = 'abc';
        $headers                  = ['xyz' => $headerValue];
        $clientCode               = 'test-client';
        $clientVersion            = '1.2.34.56';
        $engineCodenameFromClient = 'blink';
        $engineCode               = 'webkit';
        $platformCode             = 'ios';
        $platformFromDevice       = 'ios';
        $deviceCodeForLoader      = 'apple=apple ipad';
        $platformVersion          = '12.a';

        $exception = new UnexpectedValueException('device not found');

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
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientCode')
            ->willReturn($clientCode);
        $header
            ->expects(self::once())
            ->method('hasClientVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientVersion')
            ->with($clientCode)
            ->willReturn($clientVersion);
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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getPlatformVersion');
        $header
            ->expects(self::never())
            ->method('hasEngineCode');
        $header
            ->expects(self::never())
            ->method('getEngineCode');
        $header
            ->expects(self::once())
            ->method('hasEngineVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getEngineVersion')
            ->with($engineCode)
            ->willThrowException($exception);

        $filteredHeaders = ['abc' => $header];

        $expected = [
            'headers' => $headers,
            'device' => [
                'architecture' => null,
                'deviceName' => 'iPad',
                'marketingName' => 'iPad',
                'manufacturer' => 'apple',
                'brand' => 'apple',
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
                'name' => 'iOS',
                'marketingName' => 'iOS',
                'version' => $platformVersion,
                'manufacturer' => 'apple',
            ],
            'client' => [
                'name' => 'Android WebView',
                'version' => $clientVersion,
                'manufacturer' => 'google',
                'type' => 'browser',
                'isbot' => true,
            ],
            'engine' => [
                'name' => 'WebKit',
                'version' => null,
                'manufacturer' => 'apple',
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
            ->with('apple ipad')
            ->willReturn(
                [
                    [
                        'deviceName' => 'iPad',
                        'marketingName' => 'iPad',
                        'manufacturer' => 'apple',
                        'brand' => 'apple',
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
                    ],
                    $platformFromDevice,
                ],
            );

        $deviceLoaderFactory = $this->createMock(DeviceLoaderFactoryInterface::class);
        $deviceLoaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('apple')
            ->willReturn($deviceLoader);

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with($platformCode, $headerValue)
            ->willReturn(
                [
                    'name' => 'iOS',
                    'marketingName' => 'iOS',
                    'version' => $platformVersion,
                    'manufacturer' => 'apple',
                ],
            );

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::once())
            ->method('load')
            ->with($clientCode, $headerValue)
            ->willReturn(
                [
                    [
                        'name' => 'Android WebView',
                        'version' => null,
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => true,
                    ],
                    $engineCodenameFromClient,
                ],
            );

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineCode, '')
            ->willReturn(
                [
                    'name' => 'WebKit',
                    'version' => null,
                    'manufacturer' => 'apple',
                ],
            );

        $version1 = $this->createMock(VersionInterface::class);
        $version1
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::IGNORE_MINOR)
            ->willReturn($platformVersion);

        $versionBuilder1 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder1
            ->expects(self::once())
            ->method('set')
            ->with($platformVersion)
            ->willReturn($version1);
        $versionBuilder1
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder1
            ->expects(self::never())
            ->method('setRegex');

        $version2 = $this->createMock(VersionInterface::class);
        $version2
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::COMPLETE)
            ->willReturn($clientVersion);

        $versionBuilder2 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder2
            ->expects(self::once())
            ->method('set')
            ->with($clientVersion)
            ->willReturn($version2);
        $versionBuilder2
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder2
            ->expects(self::never())
            ->method('setRegex');

        $versionBuilderFactory = $this->createMock(VersionBuilderFactoryInterface::class);
        $versionBuilderFactory
            ->expects(self::exactly(2))
            ->method('__invoke')
            ->with($logger, null)
            ->willReturn($versionBuilder1, $versionBuilder2);

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
    public function testGetBrowserWithoutCacheButWithClientCode17(): void
    {
        $hash                     = 'test-hash';
        $headerValue              = 'abc';
        $headers                  = ['xyz' => $headerValue];
        $clientCode               = 'test-client';
        $clientVersion            = '1.2.34.56';
        $clientVersion2           = '1.2.34.57';
        $engineCodenameFromClient = 'blink';
        $engineCode               = 'webkit';
        $platformCode             = 'ios';
        $platformFromDevice       = 'ios';
        $deviceCodeForLoader      = 'apple=apple ipad';
        $platformVersion          = '12.0';

        $exception = new NotNumericException('invalid version');

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
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientCode')
            ->willReturn($clientCode);
        $header
            ->expects(self::once())
            ->method('hasClientVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientVersion')
            ->with($clientCode)
            ->willReturn($clientVersion);
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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getPlatformVersion');
        $header
            ->expects(self::never())
            ->method('hasEngineCode');
        $header
            ->expects(self::never())
            ->method('getEngineCode');
        $header
            ->expects(self::once())
            ->method('hasEngineVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getEngineVersion')
            ->with($engineCode)
            ->willThrowException($exception);

        $filteredHeaders = ['abc' => $header];

        $expected = [
            'headers' => $headers,
            'device' => [
                'architecture' => null,
                'deviceName' => 'iPad',
                'marketingName' => 'iPad',
                'manufacturer' => 'apple',
                'brand' => 'apple',
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
                'name' => 'iOS',
                'marketingName' => 'iOS',
                'version' => $platformVersion,
                'manufacturer' => 'apple',
            ],
            'client' => [
                'name' => 'Android WebView',
                'version' => $clientVersion,
                'manufacturer' => 'google',
                'type' => 'browser',
                'isbot' => true,
            ],
            'engine' => [
                'name' => 'WebKit',
                'version' => null,
                'manufacturer' => 'apple',
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
            ->with('apple ipad')
            ->willReturn(
                [
                    [
                        'deviceName' => 'iPad',
                        'marketingName' => 'iPad',
                        'manufacturer' => 'apple',
                        'brand' => 'apple',
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
                    ],
                    $platformFromDevice,
                ],
            );

        $deviceLoaderFactory = $this->createMock(DeviceLoaderFactoryInterface::class);
        $deviceLoaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('apple')
            ->willReturn($deviceLoader);

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with($platformCode, $headerValue)
            ->willReturn(
                [
                    'name' => 'iOS',
                    'marketingName' => 'iOS',
                    'version' => $platformVersion,
                    'manufacturer' => 'apple',
                ],
            );

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::once())
            ->method('load')
            ->with($clientCode, $headerValue)
            ->willReturn(
                [
                    [
                        'name' => 'Android WebView',
                        'version' => $clientVersion2,
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => true,
                    ],
                    $engineCodenameFromClient,
                ],
            );

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineCode, '')
            ->willReturn(
                [
                    'name' => 'WebKit',
                    'version' => null,
                    'manufacturer' => 'apple',
                ],
            );

        $version1 = $this->createMock(VersionInterface::class);
        $version1
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::IGNORE_MINOR)
            ->willReturn($platformVersion);

        $versionBuilder1 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder1
            ->expects(self::once())
            ->method('set')
            ->with($platformVersion)
            ->willReturn($version1);
        $versionBuilder1
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder1
            ->expects(self::never())
            ->method('setRegex');

        $version2 = $this->createMock(VersionInterface::class);
        $version2
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::COMPLETE)
            ->willReturn($clientVersion);

        $versionBuilder2 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder2
            ->expects(self::once())
            ->method('set')
            ->with($clientVersion)
            ->willReturn($version2);
        $versionBuilder2
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder2
            ->expects(self::never())
            ->method('setRegex');

        $versionBuilderFactory = $this->createMock(VersionBuilderFactoryInterface::class);
        $versionBuilderFactory
            ->expects(self::exactly(2))
            ->method('__invoke')
            ->with($logger, null)
            ->willReturn($versionBuilder1, $versionBuilder2);

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
    public function testGetBrowserWithoutCacheButWithClientCode18(): void
    {
        $hash                     = 'test-hash';
        $headerValue              = 'abc';
        $headers                  = ['xyz' => $headerValue];
        $clientCode               = 'test-client';
        $engineCodenameFromClient = 'blink';
        $engineCode               = 'u3';
        $engineVersion            = '34.56.78.90';
        $engineVersion2           = '34.56.78.92';

        $exception = new NotNumericException('invalid version');

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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getDeviceCode');
        $header
            ->expects(self::once())
            ->method('hasClientCode')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientCode')
            ->willReturn($clientCode);
        $header
            ->expects(self::once())
            ->method('hasClientVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientVersion')
            ->with($clientCode)
            ->willThrowException($exception);
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
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getEngineCode')
            ->willReturn($engineCode);
        $header
            ->expects(self::once())
            ->method('hasEngineVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getEngineVersion')
            ->with($engineCode)
            ->willReturn($engineVersion);

        $filteredHeaders = ['abc' => $header];

        $expected = [
            'headers' => $headers,
            'device' => [
                'architecture' => null,
                'deviceName' => null,
                'marketingName' => null,
                'manufacturer' => null,
                'brand' => null,
                'dualOrientation' => false,
                'simCount' => null,
                'display' => [
                    'width' => null,
                    'height' => null,
                    'touch' => null,
                    'size' => null,
                ],
                'type' => null,
                'ismobile' => false,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => null,
                'marketingName' => null,
                'version' => null,
                'manufacturer' => null,
            ],
            'client' => [
                'name' => 'Android WebView',
                'version' => null,
                'manufacturer' => 'google',
                'type' => 'browser',
                'isbot' => true,
            ],
            'engine' => [
                'name' => 'U3',
                'version' => $engineVersion,
                'manufacturer' => 'ucweb',
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
            ->expects(self::once())
            ->method('load')
            ->with($clientCode, $headerValue)
            ->willReturn(
                [
                    [
                        'name' => 'Android WebView',
                        'version' => null,
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => true,
                    ],
                    $engineCodenameFromClient,
                ],
            );

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineCode, $headerValue)
            ->willReturn(
                [
                    'name' => 'U3',
                    'version' => $engineVersion2,
                    'manufacturer' => 'ucweb',
                ],
            );

        $version = $this->createMock(VersionInterface::class);
        $version
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::COMPLETE)
            ->willReturn($engineVersion);

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with($engineVersion)
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
            ->with($logger, null)
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
    public function testGetBrowserWithoutCacheButWithPlatformCode5(): void
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
            ->willReturn(null);
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
                'ismobile' => true,
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
                'manufacturer' => null,
                'type' => null,
                'isbot' => false,
            ],
            'engine' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
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
                    [
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
                    ],
                    $platformFromDevice,
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
                [
                    'name' => 'Linux',
                    'marketingName' => 'Linux',
                    'version' => null,
                    'manufacturer' => 'linux-foundation',
                ],
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
     */
    public function testGetBrowserWithoutCacheButWithPlatformCode6(): void
    {
        $hash                = 'test-hash';
        $headerValue         = 'abc';
        $headers             = ['xyz' => $headerValue];
        $deviceCodeForLoader = 'lg=lg lm-g710=a';
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
                'ismobile' => true,
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
                'manufacturer' => null,
                'type' => null,
                'isbot' => false,
            ],
            'engine' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
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
            ->with('lg lm-g710=a')
            ->willReturn(
                [
                    [
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
                    ],
                    $platformFromDevice,
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
                [
                    'name' => 'Linux',
                    'marketingName' => 'Linux',
                    'version' => null,
                    'manufacturer' => 'linux-foundation',
                ],
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
     */
    public function testGetBrowserWithoutCacheButWithClientCode19(): void
    {
        $hash                     = 'test-hash';
        $headerValue              = 'abc';
        $headers                  = ['xyz' => $headerValue];
        $clientCode               = 'test-client';
        $clientVersion            = '1.2.34.56';
        $engineCodenameFromClient = 'blink';
        $engineCode               = 'u3';
        $engineVersion            = '34.56.78.90';

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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getDeviceCode');
        $header
            ->expects(self::once())
            ->method('hasClientCode')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientCode')
            ->willReturn($clientCode);
        $header
            ->expects(self::once())
            ->method('hasClientVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientVersion')
            ->with($clientCode)
            ->willReturn($clientVersion);
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
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getEngineCode')
            ->willReturn($engineCode);
        $header
            ->expects(self::once())
            ->method('hasEngineVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getEngineVersion')
            ->with($engineCode)
            ->willReturn(null);

        $filteredHeaders = ['abc' => $header];

        $expected = [
            'headers' => $headers,
            'device' => [
                'architecture' => null,
                'deviceName' => null,
                'marketingName' => null,
                'manufacturer' => null,
                'brand' => null,
                'dualOrientation' => false,
                'simCount' => null,
                'display' => [
                    'width' => null,
                    'height' => null,
                    'touch' => null,
                    'size' => null,
                ],
                'type' => null,
                'ismobile' => false,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => null,
                'marketingName' => null,
                'version' => null,
                'manufacturer' => null,
            ],
            'client' => [
                'name' => 'Android WebView',
                'version' => $clientVersion,
                'manufacturer' => 'google',
                'type' => 'browser',
                'isbot' => true,
            ],
            'engine' => [
                'name' => 'U3',
                'version' => $engineVersion,
                'manufacturer' => 'ucweb',
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
            ->expects(self::once())
            ->method('load')
            ->with($clientCode, $headerValue)
            ->willReturn(
                [
                    [
                        'name' => 'Android WebView',
                        'version' => null,
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => true,
                    ],
                    $engineCodenameFromClient,
                ],
            );

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineCode, $headerValue)
            ->willReturn(
                [
                    'name' => 'U3',
                    'version' => $engineVersion,
                    'manufacturer' => 'ucweb',
                ],
            );

        $version1 = $this->createMock(VersionInterface::class);
        $version1
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::COMPLETE)
            ->willReturn($clientVersion);

        $versionBuilder1 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder1
            ->expects(self::once())
            ->method('set')
            ->with($clientVersion)
            ->willReturn($version1);
        $versionBuilder1
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder1
            ->expects(self::never())
            ->method('setRegex');

        $version2 = $this->createMock(VersionInterface::class);
        $version2
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::COMPLETE)
            ->willReturn(null);

        $versionBuilder2 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder2
            ->expects(self::once())
            ->method('set')
            ->with('')
            ->willReturn($version2);
        $versionBuilder2
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder2
            ->expects(self::never())
            ->method('setRegex');

        $versionBuilderFactory = $this->createMock(VersionBuilderFactoryInterface::class);
        $versionBuilderFactory
            ->expects(self::exactly(2))
            ->method('__invoke')
            ->with($logger, null)
            ->willReturn($versionBuilder1, $versionBuilder2);

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
    public function testGetBrowserWithoutCacheButWithClientCode20(): void
    {
        $hash        = 'test-hash';
        $headerValue = 'abc';
        $headers     = ['xyz' => $headerValue];

        $filteredHeaders = [];

        $expected = [
            'headers' => $headers,
            'device' => [
                'architecture' => null,
                'deviceName' => null,
                'marketingName' => null,
                'manufacturer' => null,
                'brand' => null,
                'dualOrientation' => false,
                'simCount' => null,
                'display' => [
                    'width' => null,
                    'height' => null,
                    'touch' => null,
                    'size' => null,
                ],
                'type' => null,
                'ismobile' => false,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => null,
                'marketingName' => null,
                'version' => null,
                'manufacturer' => null,
            ],
            'client' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
                'type' => null,
                'isbot' => false,
            ],
            'engine' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
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
                'manufacturer' => null,
                'type' => null,
                'isbot' => false,
            ],
            'engine' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
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
                    [
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
                    ],
                    $platformFromDevice,
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
                [
                    'name' => 'Linux',
                    'marketingName' => 'Linux',
                    'version' => $platformVersion2,
                    'manufacturer' => 'linux-foundation',
                ],
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
            ->with($logger, null)
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
    public function testGetBrowserWithoutCacheButWithClientCode21(): void
    {
        $hash                     = 'test-hash';
        $headerValue              = 'abc';
        $headers                  = ['xyz' => $headerValue];
        $clientCode               = 'test-client';
        $engineCodenameFromClient = 'blink';
        $engineCode               = 'u3';
        $engineVersion            = null;
        $engineVersion2           = '34.56.78.92';

        $exception = new NotNumericException('invalid version');

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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getDeviceCode');
        $header
            ->expects(self::once())
            ->method('hasClientCode')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientCode')
            ->willReturn($clientCode);
        $header
            ->expects(self::once())
            ->method('hasClientVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientVersion')
            ->with($clientCode)
            ->willThrowException($exception);
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
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getEngineCode')
            ->willReturn($engineCode);
        $header
            ->expects(self::once())
            ->method('hasEngineVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getEngineVersion')
            ->with($engineCode)
            ->willReturn($engineVersion);

        $filteredHeaders = ['abc' => $header];

        $expected = [
            'headers' => $headers,
            'device' => [
                'architecture' => null,
                'deviceName' => null,
                'marketingName' => null,
                'manufacturer' => null,
                'brand' => null,
                'dualOrientation' => false,
                'simCount' => null,
                'display' => [
                    'width' => null,
                    'height' => null,
                    'touch' => null,
                    'size' => null,
                ],
                'type' => null,
                'ismobile' => false,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => null,
                'marketingName' => null,
                'version' => null,
                'manufacturer' => null,
            ],
            'client' => [
                'name' => 'Android WebView',
                'version' => null,
                'manufacturer' => 'google',
                'type' => 'browser',
                'isbot' => true,
            ],
            'engine' => [
                'name' => 'U3',
                'version' => $engineVersion2,
                'manufacturer' => 'ucweb',
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
            ->expects(self::once())
            ->method('load')
            ->with($clientCode, $headerValue)
            ->willReturn(
                [
                    [
                        'name' => 'Android WebView',
                        'version' => null,
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => true,
                    ],
                    $engineCodenameFromClient,
                ],
            );

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineCode, $headerValue)
            ->willReturn(
                [
                    'name' => 'U3',
                    'version' => $engineVersion2,
                    'manufacturer' => 'ucweb',
                ],
            );

        $version = $this->createMock(VersionInterface::class);
        $version
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::COMPLETE)
            ->willReturn($engineVersion);

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with($engineVersion)
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
            ->with($logger, null)
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
    public function testGetBrowserWithoutCacheButWithClientCode22(): void
    {
        $hash                     = 'test-hash';
        $headerValue              = 'abc';
        $headers                  = ['xyz' => $headerValue];
        $clientCode               = 'test-client';
        $clientVersion            = null;
        $clientVersion2           = '1.2.34.57';
        $engineCodenameFromClient = 'blink';
        $engineCode               = 'webkit';
        $platformCode             = 'ios';
        $platformFromDevice       = 'ios';
        $deviceCodeForLoader      = 'apple=apple ipad';
        $platformVersion          = '12.0';

        $exception = new NotNumericException('invalid version');

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
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientCode')
            ->willReturn($clientCode);
        $header
            ->expects(self::once())
            ->method('hasClientVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getClientVersion')
            ->with($clientCode)
            ->willReturn($clientVersion);
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
            ->willReturn(false);
        $header
            ->expects(self::never())
            ->method('getPlatformVersion');
        $header
            ->expects(self::never())
            ->method('hasEngineCode');
        $header
            ->expects(self::never())
            ->method('getEngineCode');
        $header
            ->expects(self::once())
            ->method('hasEngineVersion')
            ->willReturn(true);
        $header
            ->expects(self::once())
            ->method('getEngineVersion')
            ->with($engineCode)
            ->willThrowException($exception);

        $filteredHeaders = ['abc' => $header];

        $expected = [
            'headers' => $headers,
            'device' => [
                'architecture' => null,
                'deviceName' => 'iPad',
                'marketingName' => 'iPad',
                'manufacturer' => 'apple',
                'brand' => 'apple',
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
                'name' => 'iOS',
                'marketingName' => 'iOS',
                'version' => $platformVersion,
                'manufacturer' => 'apple',
            ],
            'client' => [
                'name' => 'Android WebView',
                'version' => $clientVersion2,
                'manufacturer' => 'google',
                'type' => 'browser',
                'isbot' => true,
            ],
            'engine' => [
                'name' => 'WebKit',
                'version' => null,
                'manufacturer' => 'apple',
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
            ->with('apple ipad')
            ->willReturn(
                [
                    [
                        'deviceName' => 'iPad',
                        'marketingName' => 'iPad',
                        'manufacturer' => 'apple',
                        'brand' => 'apple',
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
                    ],
                    $platformFromDevice,
                ],
            );

        $deviceLoaderFactory = $this->createMock(DeviceLoaderFactoryInterface::class);
        $deviceLoaderFactory
            ->expects(self::once())
            ->method('__invoke')
            ->with('apple')
            ->willReturn($deviceLoader);

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with($platformCode, $headerValue)
            ->willReturn(
                [
                    'name' => 'iOS',
                    'marketingName' => 'iOS',
                    'version' => $platformVersion,
                    'manufacturer' => 'apple',
                ],
            );

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::once())
            ->method('load')
            ->with($clientCode, $headerValue)
            ->willReturn(
                [
                    [
                        'name' => 'Android WebView',
                        'version' => $clientVersion2,
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => true,
                    ],
                    $engineCodenameFromClient,
                ],
            );

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineCode, '')
            ->willReturn(
                [
                    'name' => 'WebKit',
                    'version' => null,
                    'manufacturer' => 'apple',
                ],
            );

        $version1 = $this->createMock(VersionInterface::class);
        $version1
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::IGNORE_MINOR)
            ->willReturn($platformVersion);

        $versionBuilder1 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder1
            ->expects(self::once())
            ->method('set')
            ->with($platformVersion)
            ->willReturn($version1);
        $versionBuilder1
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder1
            ->expects(self::never())
            ->method('setRegex');

        $version2 = $this->createMock(VersionInterface::class);
        $version2
            ->expects(self::once())
            ->method('getVersion')
            ->with(VersionInterface::COMPLETE)
            ->willReturn($clientVersion);

        $versionBuilder2 = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder2
            ->expects(self::once())
            ->method('set')
            ->with($clientVersion)
            ->willReturn($version2);
        $versionBuilder2
            ->expects(self::never())
            ->method('detectVersion');
        $versionBuilder2
            ->expects(self::never())
            ->method('setRegex');

        $versionBuilderFactory = $this->createMock(VersionBuilderFactoryInterface::class);
        $versionBuilderFactory
            ->expects(self::exactly(2))
            ->method('__invoke')
            ->with($logger, null)
            ->willReturn($versionBuilder1, $versionBuilder2);

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
                'manufacturer' => null,
                'brand' => null,
                'dualOrientation' => false,
                'simCount' => null,
                'display' => [
                    'width' => null,
                    'height' => null,
                    'touch' => null,
                    'size' => null,
                ],
                'type' => null,
                'ismobile' => false,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => null,
                'marketingName' => null,
                'version' => null,
                'manufacturer' => null,
            ],
            'client' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
                'type' => null,
                'isbot' => false,
            ],
            'engine' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
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
                'manufacturer' => null,
                'brand' => null,
                'dualOrientation' => false,
                'simCount' => null,
                'display' => [
                    'width' => null,
                    'height' => null,
                    'touch' => null,
                    'size' => null,
                ],
                'type' => null,
                'ismobile' => false,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => null,
                'marketingName' => null,
                'version' => null,
                'manufacturer' => null,
            ],
            'client' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
                'type' => null,
                'isbot' => false,
            ],
            'engine' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
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
                'manufacturer' => null,
                'type' => null,
                'isbot' => false,
            ],
            'engine' => [
                'name' => null,
                'version' => null,
                'manufacturer' => null,
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
                    [
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
                    ],
                    $platformFromDevice,
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
                [
                    'name' => 'Linux',
                    'marketingName' => 'Linux',
                    'version' => null,
                    'manufacturer' => 'linux-foundation',
                ],
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
