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

namespace Parser\Header;

use BrowserDetector\Loader\Data\ClientData;
use BrowserDetector\Parser\Header\UseragentClientCode;
use BrowserDetector\Parser\Header\UseragentClientVersion;
use BrowserDetector\Parser\Header\UseragentDeviceCode;
use BrowserDetector\Parser\Header\UseragentEngineCode;
use BrowserDetector\Parser\Header\UseragentEngineVersion;
use BrowserDetector\Parser\Header\UseragentPlatformCode;
use BrowserDetector\Parser\Header\UseragentPlatformVersion;
use BrowserDetector\Parser\Helper\DeviceInterface;
use BrowserDetector\Version\Exception\NotNumericException;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionBuilder;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaBrowserType\Type;
use UaLoader\BrowserLoaderInterface;
use UaLoader\EngineLoaderInterface;
use UaLoader\Exception\NotFoundException;
use UaLoader\PlatformLoaderInterface;
use UaNormalizer\NormalizerFactory;
use UaParser\BrowserParserInterface;
use UaParser\DeviceParserInterface;
use UaParser\EngineParserInterface;
use UaParser\PlatformParserInterface;
use UaRequest\Header\FullHeader;
use UaResult\Browser\Browser;
use UaResult\Company\Company;
use UaResult\Engine\Engine;
use UaResult\Os\Os;

use function sprintf;

/** @phpcs:disable SlevomatCodingStandard.Classes.ClassLength.ClassTooLong */
#[CoversClass(UseragentClientCode::class)]
#[CoversClass(UseragentClientVersion::class)]
#[CoversClass(UseragentDeviceCode::class)]
#[CoversClass(UseragentEngineCode::class)]
#[CoversClass(UseragentEngineVersion::class)]
#[CoversClass(UseragentPlatformCode::class)]
#[CoversClass(UseragentPlatformVersion::class)]
final class Useragent2Test extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    public function testData7(): void
    {
        $ua        = 'Mozilla/5.0 (Linux; Android 7.0; B1-7A0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36';
        $deviceKey = 'acer=acer b1-7a0';

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::never())
            ->method('parse');

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::exactly(2))
            ->method('parse')
            ->with($ua)
            ->willReturn('');

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::exactly(2))
            ->method('parse')
            ->with($ua)
            ->willReturn('');

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::exactly(2))
            ->method('parse')
            ->with($ua)
            ->willReturn('');

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::never())
            ->method('load');

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::never())
            ->method('load');

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::never())
            ->method('load');

        $deviceCodeHelper = $this->createMock(DeviceInterface::class);
        $deviceCodeHelper
            ->expects(self::once())
            ->method('getDeviceCode')
            ->with('b1-7a0')
            ->willReturn($deviceKey);

        $normalizerFactory = new NormalizerFactory();
        $normalizer        = $normalizerFactory->build();

        $header = new FullHeader(
            value: $ua,
            deviceCode: new UseragentDeviceCode(
                deviceParser: $deviceParser,
                normalizer: $normalizer,
                deviceCodeHelper: $deviceCodeHelper,
            ),
            clientCode: new UseragentClientCode(
                browserParser: $browserParser,
                normalizer: $normalizer,
            ),
            clientVersion: new UseragentClientVersion(
                browserParser: $browserParser,
                browserLoader: $browserLoader,
                normalizer: $normalizer,
            ),
            platformCode: new UseragentPlatformCode(
                platformParser: $platformParser,
                normalizer: $normalizer,
            ),
            platformVersion: new UseragentPlatformVersion(
                platformParser: $platformParser,
                platformLoader: $platformLoader,
                normalizer: $normalizer,
            ),
            engineCode: new UseragentEngineCode(
                engineParser: $engineParser,
                normalizer: $normalizer,
            ),
            engineVersion: new UseragentEngineVersion(
                engineParser: $engineParser,
                engineLoader: $engineLoader,
                normalizer: $normalizer,
            ),
        );

        self::assertSame($ua, $header->getValue(), sprintf('value mismatch for ua "%s"', $ua));
        self::assertSame(
            $ua,
            $header->getNormalizedValue(),
            sprintf('value mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertTrue($header->hasDeviceCode(), sprintf('device info mismatch for ua "%s"', $ua));
        self::assertSame(
            $deviceKey,
            $header->getDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertTrue($header->hasClientCode(), sprintf('browser info mismatch for ua "%s"', $ua));
        self::assertNull(
            $header->getClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertTrue(
            $header->hasClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertTrue(
            $header->hasPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertTrue(
            $header->hasPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertTrue($header->hasEngineCode(), sprintf('engine info mismatch for ua "%s"', $ua));
        self::assertNull(
            $header->getEngineCode(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertTrue(
            $header->hasEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    public function testDataWithoutVersions(): void
    {
        $ua          = 'Mozilla/5.0 (Linux; Android 7.0; B1-7A0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36';
        $deviceKey   = 'acer=acer b1-7a0';
        $platformKey = 'test-platform-key';
        $clientKey   = 'test-client-key';
        $engineKey   = 'test-engine-key';

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::never())
            ->method('parse');

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::exactly(2))
            ->method('parse')
            ->with($ua)
            ->willReturn($platformKey);

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::exactly(2))
            ->method('parse')
            ->with($ua)
            ->willReturn($clientKey);

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::exactly(2))
            ->method('parse')
            ->with($ua)
            ->willReturn($engineKey);

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::once())
            ->method('load')
            ->with($clientKey, $ua)
            ->willReturn(
                new ClientData(
                    client: new Browser(
                        name: null,
                        manufacturer: new Company(type: '', name: null, brandname: null),
                        version: new NullVersion(),
                        type: Type::Browser,
                    ),
                    engine: null,
                ),
            );

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with($platformKey, $ua)
            ->willReturn(
                new Os(
                    name: null,
                    marketingName: null,
                    manufacturer: new Company(type: '', name: null, brandname: null),
                    version: new NullVersion(),
                ),
            );

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineKey, $ua)
            ->willReturn(
                new Engine(
                    name: null,
                    manufacturer: new Company(type: '', name: null, brandname: null),
                    version: new NullVersion(),
                ),
            );

        $deviceCodeHelper = $this->createMock(DeviceInterface::class);
        $deviceCodeHelper
            ->expects(self::once())
            ->method('getDeviceCode')
            ->with('b1-7a0')
            ->willReturn($deviceKey);

        $normalizerFactory = new NormalizerFactory();
        $normalizer        = $normalizerFactory->build();

        $header = new FullHeader(
            value: $ua,
            deviceCode: new UseragentDeviceCode(
                deviceParser: $deviceParser,
                normalizer: $normalizer,
                deviceCodeHelper: $deviceCodeHelper,
            ),
            clientCode: new UseragentClientCode(
                browserParser: $browserParser,
                normalizer: $normalizer,
            ),
            clientVersion: new UseragentClientVersion(
                browserParser: $browserParser,
                browserLoader: $browserLoader,
                normalizer: $normalizer,
            ),
            platformCode: new UseragentPlatformCode(
                platformParser: $platformParser,
                normalizer: $normalizer,
            ),
            platformVersion: new UseragentPlatformVersion(
                platformParser: $platformParser,
                platformLoader: $platformLoader,
                normalizer: $normalizer,
            ),
            engineCode: new UseragentEngineCode(
                engineParser: $engineParser,
                normalizer: $normalizer,
            ),
            engineVersion: new UseragentEngineVersion(
                engineParser: $engineParser,
                engineLoader: $engineLoader,
                normalizer: $normalizer,
            ),
        );

        self::assertSame($ua, $header->getValue(), sprintf('value mismatch for ua "%s"', $ua));
        self::assertSame(
            $ua,
            $header->getNormalizedValue(),
            sprintf('value mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertTrue($header->hasDeviceCode(), sprintf('device info mismatch for ua "%s"', $ua));
        self::assertSame(
            $deviceKey,
            $header->getDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertTrue($header->hasClientCode(), sprintf('browser info mismatch for ua "%s"', $ua));
        self::assertSame(
            $clientKey,
            $header->getClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertTrue(
            $header->hasClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertTrue(
            $header->hasPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $platformKey,
            $header->getPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertTrue(
            $header->hasPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertTrue($header->hasEngineCode(), sprintf('engine info mismatch for ua "%s"', $ua));
        self::assertSame(
            $engineKey,
            $header->getEngineCode(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertTrue(
            $header->hasEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
    }

    /**
     * @throws ExpectationFailedException
     * @throws NotNumericException
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    public function testDataWithVersions(): void
    {
        $ua          = 'Mozilla/5.0 (Linux; Android 7.0; B1-7A0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36';
        $deviceKey   = 'acer=acer b1-7a0';
        $platformKey = 'test-platform-key';
        $clientKey   = 'test-client-key';
        $engineKey   = 'test-engine-key';

        $browserVersion  = '1.2.0';
        $platformVersion = '2.4.0';
        $engineVersion   = '4.8.0';

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::never())
            ->method('parse');

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::exactly(2))
            ->method('parse')
            ->with($ua)
            ->willReturn($platformKey);

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::exactly(2))
            ->method('parse')
            ->with($ua)
            ->willReturn($clientKey);

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::exactly(2))
            ->method('parse')
            ->with($ua)
            ->willReturn($engineKey);

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::once())
            ->method('load')
            ->with($clientKey, $ua)
            ->willReturn(
                new ClientData(
                    client: new Browser(
                        name: null,
                        manufacturer: new Company(type: '', name: null, brandname: null),
                        version: (new VersionBuilder())->set($browserVersion),
                        type: Type::Browser,
                    ),
                    engine: null,
                ),
            );

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with($platformKey, $ua)
            ->willReturn(
                new Os(
                    name: null,
                    marketingName: null,
                    manufacturer: new Company(type: '', name: null, brandname: null),
                    version: (new VersionBuilder())->set($platformVersion),
                ),
            );

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineKey, $ua)
            ->willReturn(
                new Engine(
                    name: null,
                    manufacturer: new Company(type: '', name: null, brandname: null),
                    version: (new VersionBuilder())->set($engineVersion),
                ),
            );

        $deviceCodeHelper = $this->createMock(DeviceInterface::class);
        $deviceCodeHelper
            ->expects(self::once())
            ->method('getDeviceCode')
            ->with('b1-7a0')
            ->willReturn($deviceKey);

        $normalizerFactory = new NormalizerFactory();
        $normalizer        = $normalizerFactory->build();

        $header = new FullHeader(
            value: $ua,
            deviceCode: new UseragentDeviceCode(
                deviceParser: $deviceParser,
                normalizer: $normalizer,
                deviceCodeHelper: $deviceCodeHelper,
            ),
            clientCode: new UseragentClientCode(
                browserParser: $browserParser,
                normalizer: $normalizer,
            ),
            clientVersion: new UseragentClientVersion(
                browserParser: $browserParser,
                browserLoader: $browserLoader,
                normalizer: $normalizer,
            ),
            platformCode: new UseragentPlatformCode(
                platformParser: $platformParser,
                normalizer: $normalizer,
            ),
            platformVersion: new UseragentPlatformVersion(
                platformParser: $platformParser,
                platformLoader: $platformLoader,
                normalizer: $normalizer,
            ),
            engineCode: new UseragentEngineCode(
                engineParser: $engineParser,
                normalizer: $normalizer,
            ),
            engineVersion: new UseragentEngineVersion(
                engineParser: $engineParser,
                engineLoader: $engineLoader,
                normalizer: $normalizer,
            ),
        );

        self::assertSame($ua, $header->getValue(), sprintf('value mismatch for ua "%s"', $ua));
        self::assertSame(
            $ua,
            $header->getNormalizedValue(),
            sprintf('value mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertTrue($header->hasDeviceCode(), sprintf('device info mismatch for ua "%s"', $ua));
        self::assertSame(
            $deviceKey,
            $header->getDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertTrue($header->hasClientCode(), sprintf('browser info mismatch for ua "%s"', $ua));
        self::assertSame(
            $clientKey,
            $header->getClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertTrue(
            $header->hasClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $browserVersion,
            $header->getClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertTrue(
            $header->hasPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $platformKey,
            $header->getPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertTrue(
            $header->hasPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $platformVersion,
            $header->getPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertTrue($header->hasEngineCode(), sprintf('engine info mismatch for ua "%s"', $ua));
        self::assertSame(
            $engineKey,
            $header->getEngineCode(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertTrue(
            $header->hasEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $engineVersion,
            $header->getEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
    }

    /**
     * @throws ExpectationFailedException
     * @throws NotNumericException
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    public function testDataWithClientParserException(): void
    {
        $ua          = 'Mozilla/5.0 (Linux; Android 7.0; B1-7A0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36';
        $deviceKey   = 'acer=acer b1-7a0';
        $platformKey = 'test-platform-key';
        $engineKey   = 'test-engine-key';

        $platformVersion = '2.4.0';
        $engineVersion   = '4.8.0';

        $clientException = new NotFoundException('client-exception');

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::never())
            ->method('parse');

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::exactly(2))
            ->method('parse')
            ->with($ua)
            ->willReturn($platformKey);

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::exactly(2))
            ->method('parse')
            ->with($ua)
            ->willThrowException($clientException);

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::exactly(2))
            ->method('parse')
            ->with($ua)
            ->willReturn($engineKey);

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::never())
            ->method('load');

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with($platformKey, $ua)
            ->willReturn(
                new Os(
                    name: null,
                    marketingName: null,
                    manufacturer: new Company(type: '', name: null, brandname: null),
                    version: (new VersionBuilder())->set($platformVersion),
                ),
            );

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineKey, $ua)
            ->willReturn(
                new Engine(
                    name: null,
                    manufacturer: new Company(type: '', name: null, brandname: null),
                    version: (new VersionBuilder())->set($engineVersion),
                ),
            );

        $deviceCodeHelper = $this->createMock(DeviceInterface::class);
        $deviceCodeHelper
            ->expects(self::once())
            ->method('getDeviceCode')
            ->with('b1-7a0')
            ->willReturn($deviceKey);

        $normalizerFactory = new NormalizerFactory();
        $normalizer        = $normalizerFactory->build();

        $header = new FullHeader(
            value: $ua,
            deviceCode: new UseragentDeviceCode(
                deviceParser: $deviceParser,
                normalizer: $normalizer,
                deviceCodeHelper: $deviceCodeHelper,
            ),
            clientCode: new UseragentClientCode(
                browserParser: $browserParser,
                normalizer: $normalizer,
            ),
            clientVersion: new UseragentClientVersion(
                browserParser: $browserParser,
                browserLoader: $browserLoader,
                normalizer: $normalizer,
            ),
            platformCode: new UseragentPlatformCode(
                platformParser: $platformParser,
                normalizer: $normalizer,
            ),
            platformVersion: new UseragentPlatformVersion(
                platformParser: $platformParser,
                platformLoader: $platformLoader,
                normalizer: $normalizer,
            ),
            engineCode: new UseragentEngineCode(
                engineParser: $engineParser,
                normalizer: $normalizer,
            ),
            engineVersion: new UseragentEngineVersion(
                engineParser: $engineParser,
                engineLoader: $engineLoader,
                normalizer: $normalizer,
            ),
        );

        self::assertSame($ua, $header->getValue(), sprintf('value mismatch for ua "%s"', $ua));
        self::assertSame(
            $ua,
            $header->getNormalizedValue(),
            sprintf('value mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertTrue($header->hasDeviceCode(), sprintf('device info mismatch for ua "%s"', $ua));
        self::assertSame(
            $deviceKey,
            $header->getDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertTrue($header->hasClientCode(), sprintf('browser info mismatch for ua "%s"', $ua));
        self::assertNull(
            $header->getClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertTrue(
            $header->hasClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertTrue(
            $header->hasPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $platformKey,
            $header->getPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertTrue(
            $header->hasPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $platformVersion,
            $header->getPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertTrue($header->hasEngineCode(), sprintf('engine info mismatch for ua "%s"', $ua));
        self::assertSame(
            $engineKey,
            $header->getEngineCode(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertTrue(
            $header->hasEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $engineVersion,
            $header->getEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
    }
}
