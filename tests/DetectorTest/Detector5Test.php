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
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Version\VersionBuilderFactoryInterface;
use BrowserDetector\Version\VersionBuilderInterface;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\InvalidArgumentException;
use UaLoader\BrowserLoaderInterface;
use UaLoader\EngineLoaderInterface;
use UaLoader\PlatformLoaderInterface;
use UaRequest\GenericRequestInterface;
use UaRequest\Header\HeaderInterface;
use UaRequest\RequestBuilderInterface;
use UnexpectedValueException;

final class Detector5Test extends TestCase
{
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
}
