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
use UaDeviceType\Type;
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
use UaResult\Engine\Engine;
use UaResult\Os\Os;
use UnexpectedValueException;

#[CoversClass(Detector::class)]
final class Detector7Test extends TestCase
{
    /**
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testGetBrowserWithoutCacheButWithPlatformCode14(): void
    {
        $hash                    = 'test-hash';
        $headerValue             = 'abc';
        $headers                 = ['xyz' => $headerValue];
        $deviceCodeForLoader     = 'apple=apple ipad';
        $platformFromDevice      = 'ios';
        $platformCode            = 'ios';
        $platformVersion         = '13';
        $completePlatformVersion = '13.0.0';
        $engineCode              = 'webkit';

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
            ->with(null)
            ->willReturn(null);
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
            ->expects(self::never())
            ->method('hasEngineCode');
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
                'ismobile' => false,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => 'iPadOS',
                'marketingName' => 'iPadOS',
                'version' => $completePlatformVersion,
                'manufacturer' => 'apple',
            ],
            'client' => [
                'name' => null,
                'version' => null,
                'manufacturer' => 'unknown',
                'type' => 'unknown',
                'isbot' => false,
            ],
            'engine' => [
                'name' => 'WebKit',
                'version' => null,
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
            ->with('apple ipad')
            ->willReturn(
                new DeviceData(
                    device: new Device(
                        deviceName: 'iPad',
                        marketingName: 'iPad',
                        manufacturer: new Company(type: 'apple', name: null, brandname: null),
                        brand: new Company(type: 'apple', name: null, brandname: null),
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
            ->with('apple')
            ->willReturn($deviceLoader);

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with($platformCode, $headerValue)
            ->willReturn(
                new Os(
                    name: 'iOS',
                    marketingName: 'iOS',
                    manufacturer: new Company(type: 'apple', name: null, brandname: null),
                    version: new NullVersion(),
                ),
            );

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::never())
            ->method('load');

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineCode)
            ->willReturn(
                new Engine(
                    name: 'WebKit',
                    manufacturer: new Company(type: 'apple', name: null, brandname: null),
                    version: new NullVersion(),
                ),
            );

        $version = $this->createMock(VersionInterface::class);
        $matcher = self::exactly(3);
        $version
            ->expects($matcher)
            ->method('getVersion')
            ->willReturnCallback(
                static function (int $mode) use ($matcher, $completePlatformVersion, $platformVersion): string {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        2 => self::assertSame(
                            VersionInterface::IGNORE_MINOR,
                            $mode,
                            (string) $invocation,
                        ),
                        default => self::assertSame(
                            VersionInterface::COMPLETE,
                            $mode,
                            (string) $invocation,
                        ),
                    };

                    return match ($invocation) {
                        2 => $platformVersion,
                        default => $completePlatformVersion,
                    };
                },
            );

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::never())
            ->method('setRegex');
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with($platformVersion)
            ->willReturn($version);
        $versionBuilder
            ->expects(self::never())
            ->method('detectVersion');

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
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testGetBrowserWithoutCacheButWithPlatformCode15(): void
    {
        $hash                    = 'test-hash';
        $headerValue             = 'abc';
        $headers                 = ['xyz' => $headerValue];
        $deviceCodeForLoader     = 'apple=apple ipad';
        $platformFromDevice      = 'ios';
        $platformCode            = 'ios';
        $platformVersion         = '14';
        $completePlatformVersion = '14.0.0';
        $engineCode              = 'webkit';

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
            ->with(null)
            ->willReturn(null);
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
            ->expects(self::never())
            ->method('hasEngineCode');
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
                'ismobile' => false,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => 'iPadOS',
                'marketingName' => 'iPadOS',
                'version' => $completePlatformVersion,
                'manufacturer' => 'apple',
            ],
            'client' => [
                'name' => null,
                'version' => null,
                'manufacturer' => 'unknown',
                'type' => 'unknown',
                'isbot' => false,
            ],
            'engine' => [
                'name' => 'WebKit',
                'version' => null,
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
            ->with('apple ipad')
            ->willReturn(
                new DeviceData(
                    device: new Device(
                        deviceName: 'iPad',
                        marketingName: 'iPad',
                        manufacturer: new Company(type: 'apple', name: null, brandname: null),
                        brand: new Company(type: 'apple', name: null, brandname: null),
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
            ->with('apple')
            ->willReturn($deviceLoader);

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with($platformCode, $headerValue)
            ->willReturn(
                new Os(
                    name: 'iOS',
                    marketingName: 'iOS',
                    manufacturer: new Company(type: 'apple', name: null, brandname: null),
                    version: new NullVersion(),
                ),
            );

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::never())
            ->method('load');

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineCode)
            ->willReturn(
                new Engine(
                    name: 'WebKit',
                    manufacturer: new Company(type: 'apple', name: null, brandname: null),
                    version: new NullVersion(),
                ),
            );

        $version = $this->createMock(VersionInterface::class);
        $matcher = self::exactly(3);
        $version
            ->expects($matcher)
            ->method('getVersion')
            ->willReturnCallback(
                static function (int $mode) use ($matcher, $completePlatformVersion, $platformVersion): string {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        2 => self::assertSame(
                            VersionInterface::IGNORE_MINOR,
                            $mode,
                            (string) $invocation,
                        ),
                        default => self::assertSame(
                            VersionInterface::COMPLETE,
                            $mode,
                            (string) $invocation,
                        ),
                    };

                    return match ($invocation) {
                        2 => $platformVersion,
                        default => $completePlatformVersion,
                    };
                },
            );

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::never())
            ->method('setRegex');
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with($platformVersion)
            ->willReturn($version);
        $versionBuilder
            ->expects(self::never())
            ->method('detectVersion');

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
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testGetBrowserWithoutCacheButWithPlatformCode16(): void
    {
        $hash                    = 'test-hash';
        $headerValue             = 'abc';
        $headers                 = ['xyz' => $headerValue];
        $deviceCodeForLoader     = 'apple=apple ipad';
        $platformFromDevice      = 'ios';
        $platformCode            = 'ios';
        $platformVersion         = '12';
        $completePlatformVersion = '12.0.0';
        $engineCode              = 'webkit';

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
            ->with(null)
            ->willReturn(null);
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
            ->expects(self::never())
            ->method('hasEngineCode');
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
                'ismobile' => false,
                'istv' => false,
                'bits' => null,
            ],
            'os' => [
                'name' => 'iOS',
                'marketingName' => 'iOS',
                'version' => $completePlatformVersion,
                'manufacturer' => 'apple',
            ],
            'client' => [
                'name' => null,
                'version' => null,
                'manufacturer' => 'unknown',
                'type' => 'unknown',
                'isbot' => false,
            ],
            'engine' => [
                'name' => 'WebKit',
                'version' => null,
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
            ->with('apple ipad')
            ->willReturn(
                new DeviceData(
                    device: new Device(
                        deviceName: 'iPad',
                        marketingName: 'iPad',
                        manufacturer: new Company(type: 'apple', name: null, brandname: null),
                        brand: new Company(type: 'apple', name: null, brandname: null),
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
            ->with('apple')
            ->willReturn($deviceLoader);

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with($platformCode, $headerValue)
            ->willReturn(
                new Os(
                    name: 'iOS',
                    marketingName: 'iOS',
                    manufacturer: new Company(type: 'apple', name: null, brandname: null),
                    version: new NullVersion(),
                ),
            );

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::never())
            ->method('load');

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineCode)
            ->willReturn(
                new Engine(
                    name: 'WebKit',
                    manufacturer: new Company(type: 'apple', name: null, brandname: null),
                    version: new NullVersion(),
                ),
            );

        $version = $this->createMock(VersionInterface::class);
        $matcher = self::exactly(3);
        $version
            ->expects($matcher)
            ->method('getVersion')
            ->willReturnCallback(
                static function (int $mode) use ($matcher, $completePlatformVersion, $platformVersion): string {
                    $invocation = $matcher->numberOfInvocations();

                    match ($invocation) {
                        2 => self::assertSame(
                            VersionInterface::IGNORE_MINOR,
                            $mode,
                            (string) $invocation,
                        ),
                        default => self::assertSame(
                            VersionInterface::COMPLETE,
                            $mode,
                            (string) $invocation,
                        ),
                    };

                    return match ($invocation) {
                        2 => $platformVersion,
                        default => $completePlatformVersion,
                    };
                },
            );

        $versionBuilder = $this->createMock(VersionBuilderInterface::class);
        $versionBuilder
            ->expects(self::never())
            ->method('setRegex');
        $versionBuilder
            ->expects(self::once())
            ->method('set')
            ->with($platformVersion)
            ->willReturn($version);
        $versionBuilder
            ->expects(self::never())
            ->method('detectVersion');

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
