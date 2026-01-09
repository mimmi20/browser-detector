<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2026, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Parser\Header;

use BrowserDetector\Data\Os;
use BrowserDetector\Parser\Header\UseragentClientCode;
use BrowserDetector\Parser\Header\UseragentClientVersion;
use BrowserDetector\Parser\Header\UseragentDeviceCode;
use BrowserDetector\Parser\Header\UseragentEngineCode;
use BrowserDetector\Parser\Header\UseragentEngineVersion;
use BrowserDetector\Parser\Header\UseragentPlatformCode;
use BrowserDetector\Parser\Header\UseragentPlatformVersion;
use BrowserDetector\Parser\Helper\DeviceInterface;
use BrowserDetector\Version\Exception\NotNumericException;
use BrowserDetector\Version\ForcedNullVersion;
use BrowserDetector\Version\VersionBuilder;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaLoader\BrowserLoaderInterface;
use UaLoader\EngineLoaderInterface;
use UaLoader\PlatformLoaderInterface;
use UaNormalizer\NormalizerFactory;
use UaParser\BrowserParserInterface;
use UaParser\DeviceParserInterface;
use UaParser\EngineParserInterface;
use UaParser\PlatformParserInterface;
use UaRequest\Header\FullHeader;
use UaResult\Bits\Bits;
use UaResult\Company\Company;
use UaResult\Device\Architecture;
use UaResult\Engine\Engine;
use UnexpectedValueException;

use function sprintf;

/** @phpcs:disable SlevomatCodingStandard.Classes.ClassLength.ClassTooLong */
#[CoversClass(UseragentClientCode::class)]
#[CoversClass(UseragentClientVersion::class)]
#[CoversClass(UseragentDeviceCode::class)]
#[CoversClass(UseragentEngineCode::class)]
#[CoversClass(UseragentEngineVersion::class)]
#[CoversClass(UseragentPlatformCode::class)]
#[CoversClass(UseragentPlatformVersion::class)]
final class Useragent4Test extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws NotNumericException
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     * @throws UnexpectedValueException
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    #[DataProvider('providerUa7')]
    public function testDataWithFindingADevice2(
        string $ua,
        string $normalizedUa,
        bool $hasDeviceInfo,
        string | null $deviceCode,
        bool $hasClientInfo,
        string | null $clientCode,
        bool $hasClientVersion,
        string | null $clientVersion,
        bool $hasPlatformInfo,
        string $platformUa,
        Os $platformCode,
        bool $hasPlatformVersion,
        string | null $platformVersion,
        bool $hasEngineInfo,
        string $engineUa,
        \BrowserDetector\Data\Engine $engineCode,
        bool $hasEngineVersion,
        string | null $engineVersion,
    ): void {
        $os = new \UaResult\Os\Os(
            name: $platformCode->getName(),
            marketingName: $platformCode->getMarketingName(),
            manufacturer: new Company(type: 'unknown', name: null, brandname: null),
            version: (new VersionBuilder())->set((string) $platformVersion),
            bits: Bits::unknown,
        );

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::never())
            ->method('parse');

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::atLeastOnce())
            ->method('parse')
            ->with($platformUa)
            ->willReturn($platformCode);

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::never())
            ->method('parse');

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::atLeastOnce())
            ->method('parse')
            ->with($engineUa)
            ->willReturn($engineCode);

        $browserLoader = $this->createMock(BrowserLoaderInterface::class);
        $browserLoader
            ->expects(self::never())
            ->method('load');

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::never())
            ->method('load');
        $platformLoader
            ->expects(self::atLeastOnce())
            ->method('loadFromOs')
            ->with($platformCode, $platformUa)
            ->willReturn($os);

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::never())
            ->method('load');
        $engineLoader
            ->expects(self::atLeastOnce())
            ->method('loadFromEngine')
            ->with($engineCode)
            ->willReturn(
                new Engine(
                    name: null,
                    manufacturer: new Company(type: '', name: null, brandname: null),
                    version: (new VersionBuilder())->set((string) $engineVersion),
                ),
            );

        $deviceCodeHelper = $this->createMock(DeviceInterface::class);
        $deviceCodeHelper
            ->expects(self::never())
            ->method('getDeviceCode');

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
            $normalizedUa,
            $header->getNormalizedValue(),
            sprintf('value mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            Architecture::unknown,
            $header->getDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            Bits::unknown,
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
        self::assertSame(
            $hasDeviceInfo,
            $header->hasDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $deviceCode,
            $header->getDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasClientInfo,
            $header->hasClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $clientCode,
            $header->getClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasClientVersion,
            $header->hasClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );

        if ($clientVersion === null) {
            self::assertInstanceOf(
                ForcedNullVersion::class,
                $header->getClientVersion(),
                sprintf('browser info mismatch for ua "%s"', $ua),
            );
        } else {
            self::assertSame(
                $clientVersion,
                $header->getClientVersion()->getVersion(),
                sprintf('browser info mismatch for ua "%s"', $ua),
            );
        }

        self::assertSame(
            $hasPlatformInfo,
            $header->hasPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $platformCode,
            $header->getPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasPlatformVersion,
            $header->hasPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );

        if ($platformVersion === null) {
            self::assertInstanceOf(
                ForcedNullVersion::class,
                $header->getPlatformVersion(),
                sprintf('platform info mismatch for ua "%s"', $ua),
            );
        } else {
            self::assertSame(
                $platformVersion,
                $header->getPlatformVersion()->getVersion(),
                sprintf('platform info mismatch for ua "%s"', $ua),
            );
        }

        self::assertSame(
            $hasEngineInfo,
            $header->hasEngineCode(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $engineCode,
            $header->getEngineCode(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasEngineVersion,
            $header->hasEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );

        if ($engineVersion === null) {
            self::assertInstanceOf(
                ForcedNullVersion::class,
                $header->getEngineVersion(),
                sprintf('engine info mismatch for ua "%s"', $ua),
            );
        } else {
            self::assertSame(
                $engineVersion,
                $header->getEngineVersion()->getVersion(),
                sprintf('engine info mismatch for ua "%s"', $ua),
            );
        }
    }

    /**
     * @return array<int, array<string, bool|\BrowserDetector\Data\Engine|Os|string|null>>
     *
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    public static function providerUa7(): array
    {
        return [
            [
                'ua' => 'Mozilla/5.0 (Linux; Android 14; ZRnsYAf5vy; U; en) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.6367.42 Mobile Safari/537.36',
                'normalizedUa' => 'Mozilla/5.0 (Linux; Android 14; ZRnsYAf5vy; U; en) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.6367.42 Mobile Safari/537.36',
                'hasDeviceInfo' => true,
                'deviceCode' => 'unknown=general mobile phone',
                'hasClientInfo' => true,
                'clientCode' => 'avast secure browser',
                'hasClientVersion' => true,
                'clientVersion' => null,
                'hasPlatformInfo' => true,
                'platformUa' => 'Mozilla/5.0 (Linux; Android 14; ZRnsYAf5vy) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.6367.42 Mobile Safari/537.36',
                'platformCode' => Os::android,
                'hasPlatformVersion' => true,
                'platformVersion' => '14.0.0',
                'hasEngineInfo' => true,
                'engineUa' => 'Mozilla/5.0 (Linux; Android 14; ZRnsYAf5vy) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.6367.42 Mobile Safari/537.36',
                'engineCode' => \BrowserDetector\Data\Engine::webkit,
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
        ];
    }
}
