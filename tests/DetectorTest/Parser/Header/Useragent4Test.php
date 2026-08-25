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

namespace BrowserDetectorTest\Parser\Header;

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
#[CoversClass(className: UseragentClientCode::class)]
#[CoversClass(className: UseragentClientVersion::class)]
#[CoversClass(className: UseragentDeviceCode::class)]
#[CoversClass(className: UseragentEngineCode::class)]
#[CoversClass(className: UseragentEngineVersion::class)]
#[CoversClass(className: UseragentPlatformCode::class)]
#[CoversClass(className: UseragentPlatformVersion::class)]
final class Useragent4Test extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws NotNumericException
     * @throws Exception
     * @throws UnexpectedValueException
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    #[DataProvider(methodName: 'providerUa7')]
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
        \BrowserDetector\Data\Engine $engine,
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
            ->willReturn($engine);

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
            ->with($engine)
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
        $normalizerChain   = $normalizerFactory->build();

        $fullHeader = new FullHeader(
            value: $ua,
            deviceCode: new UseragentDeviceCode(
                deviceParser: $deviceParser,
                normalizer: $normalizerChain,
                device: $deviceCodeHelper,
            ),
            clientCode: new UseragentClientCode(
                browserParser: $browserParser,
                normalizer: $normalizerChain,
            ),
            clientVersion: new UseragentClientVersion(
                browserParser: $browserParser,
                browserLoader: $browserLoader,
                normalizer: $normalizerChain,
            ),
            platformCode: new UseragentPlatformCode(
                platformParser: $platformParser,
                normalizer: $normalizerChain,
            ),
            platformVersion: new UseragentPlatformVersion(
                platformParser: $platformParser,
                platformLoader: $platformLoader,
                normalizer: $normalizerChain,
            ),
            engineCode: new UseragentEngineCode(
                engineParser: $engineParser,
                normalizer: $normalizerChain,
            ),
            engineVersion: new UseragentEngineVersion(
                engineParser: $engineParser,
                engineLoader: $engineLoader,
                normalizer: $normalizerChain,
            ),
        );

        self::assertSame($ua, $fullHeader->getValue(), sprintf('value mismatch for ua "%s"', $ua));
        self::assertSame(
            $normalizedUa,
            $fullHeader->getNormalizedValue(),
            sprintf('value mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $fullHeader->hasDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            Architecture::unknown,
            $fullHeader->getDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $fullHeader->hasDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            Bits::unknown,
            $fullHeader->getDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $fullHeader->hasDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $fullHeader->getDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasDeviceInfo,
            $fullHeader->hasDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $deviceCode,
            $fullHeader->getDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasClientInfo,
            $fullHeader->hasClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $clientCode,
            $fullHeader->getClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasClientVersion,
            $fullHeader->hasClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );

        if ($clientVersion === null) {
            self::assertInstanceOf(
                ForcedNullVersion::class,
                $fullHeader->getClientVersion(),
                sprintf('browser info mismatch for ua "%s"', $ua),
            );
        } else {
            self::assertSame(
                $clientVersion,
                $fullHeader->getClientVersion()->getVersion(),
                sprintf('browser info mismatch for ua "%s"', $ua),
            );
        }

        self::assertSame(
            $hasPlatformInfo,
            $fullHeader->hasPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $platformCode,
            $fullHeader->getPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasPlatformVersion,
            $fullHeader->hasPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );

        if ($platformVersion === null) {
            self::assertInstanceOf(
                ForcedNullVersion::class,
                $fullHeader->getPlatformVersionWithOs(Os::unknown),
                sprintf('platform info mismatch for ua "%s"', $ua),
            );
        } else {
            self::assertSame(
                $platformVersion,
                $fullHeader->getPlatformVersionWithOs(Os::unknown)->getVersion(),
                sprintf('platform info mismatch for ua "%s"', $ua),
            );
        }

        self::assertSame(
            $hasEngineInfo,
            $fullHeader->hasEngineCode(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $engine,
            $fullHeader->getEngineCode(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasEngineVersion,
            $fullHeader->hasEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );

        if ($engineVersion === null) {
            self::assertInstanceOf(
                ForcedNullVersion::class,
                $fullHeader->getEngineVersionWithEngine(\BrowserDetector\Data\Engine::unknown),
                sprintf('engine info mismatch for ua "%s"', $ua),
            );
        } else {
            self::assertSame(
                $engineVersion,
                $fullHeader->getEngineVersionWithEngine(
                    \BrowserDetector\Data\Engine::unknown,
                )->getVersion(),
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
                'engine' => \BrowserDetector\Data\Engine::webkit,
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
        ];
    }
}
