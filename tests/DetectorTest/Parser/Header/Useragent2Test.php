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
final class Useragent2Test extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws NotNumericException
     * @throws Exception
     * @throws UnexpectedValueException
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    #[DataProvider(methodName: 'providerUa3')]
    public function testData3(
        string $ua,
        string $normalizedUa,
        bool $hasDeviceInfo,
        string $deviceUa,
        string $deviceCode,
        bool $hasClientInfo,
        string | null $clientCode,
        bool $hasClientVersion,
        string | null $clientVersion,
        bool $hasPlatformInfo,
        Os $os,
        bool $hasPlatformVersion,
        string | null $platformVersion,
        bool $hasEngineInfo,
        \BrowserDetector\Data\Engine $engine,
        bool $hasEngineVersion,
        string | null $engineVersion,
    ): void {
        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::never())
            ->method('parse');

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::never())
            ->method('parse');

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::atLeastOnce())
            ->method('parse')
            ->with($normalizedUa)
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
            ->expects(self::never())
            ->method('loadFromOs');

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
            ->expects(self::exactly(3))
            ->method('getDeviceCode')
            ->willReturnMap(
                [
                    ['xiaomi; 24030pn60g', null],
                    [$deviceUa, $deviceCode],
                    [$ua, null],
                ],
            );

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
            $ua,
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
            $os,
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
    public static function providerUa3(): array
    {
        return [
            [
                'ua' => 'Instagram 396.0.0.46.242 Android (35/15; 420dpi; 1080x2400; Xiaomi; 24030PN60G; aurora; qcom; de_DE; 785863896)',
                'normalizedUa' => 'Instagram 396.0.0.46.242 Android (35/15; 420dpi; 1080x2400; Xiaomi; 24030PN60G; aurora; qcom; 785863896)',
                'hasDeviceInfo' => true,
                'deviceUa' => '24030pn60g',
                'deviceCode' => 'A369i',
                'hasClientInfo' => true,
                'clientCode' => 'instagram app',
                'hasClientVersion' => true,
                'clientVersion' => '396.0.0.46.242',
                'hasPlatformInfo' => true,
                'os' => Os::android,
                'hasPlatformVersion' => true,
                'platformVersion' => '15.0.0',
                'hasEngineInfo' => true,
                'engine' => \BrowserDetector\Data\Engine::webkit,
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
        ];
    }

    /**
     * @throws ExpectationFailedException
     * @throws NotNumericException
     * @throws Exception
     * @throws UnexpectedValueException
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    #[DataProvider(methodName: 'providerUa4')]
    public function testDataWithFindingADevice(
        string $ua,
        string $normalizedUa,
        bool $hasDeviceInfo,
        string $deviceUa,
        string $deviceCode,
        bool $hasClientInfo,
        string | null $clientCode,
        bool $hasClientVersion,
        string | null $clientVersion,
        bool $hasPlatformInfo,
        Os $os,
        bool $hasPlatformVersion,
        string | null $platformVersion,
        bool $hasEngineInfo,
        \BrowserDetector\Data\Engine $engine,
        bool $hasEngineVersion,
        string | null $engineVersion,
    ): void {
        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::never())
            ->method('parse');

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::atLeastOnce())
            ->method('parse')
            ->with($normalizedUa)
            ->willReturn('');

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::atLeastOnce())
            ->method('parse')
            ->with($normalizedUa)
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
            ->expects(self::never())
            ->method('loadFromOs');

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
            ->expects(self::atLeastOnce())
            ->method('getDeviceCode')
            ->willReturnMap(
                [
                    [$deviceUa, $deviceCode],
                    [$ua, null],
                ],
            );

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
            $ua,
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
            $os,
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
    public static function providerUa4(): array
    {
        return [
            [
                'ua' => 'ICQ_Android/5.0 (Android; 17; 4.2.2; eng.rd2version.1388046998; Philips W8555; ru-RU)',
                'normalizedUa' => 'ICQ_Android/5.0 (Android; 17; 4.2.2; eng.rd2version.1388046998; Philips W8555)',
                'hasDeviceInfo' => true,
                'deviceUa' => 'philips w8555',
                'deviceCode' => 'A369i',
                'hasClientInfo' => true,
                'clientCode' => null,
                'hasClientVersion' => true,
                'clientVersion' => null,
                'hasPlatformInfo' => true,
                'os' => Os::android,
                'hasPlatformVersion' => true,
                'platformVersion' => '4.2.2',
                'hasEngineInfo' => true,
                'engine' => \BrowserDetector\Data\Engine::webkit,
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
            [
                'ua' => 'GG-Android/4.0.0.20098 (OS;Android;17) (HWD;asus;ASUS Transformer Pad TF300T;4.2.1)',
                'normalizedUa' => 'GG-Android/4.0.0.20098 (OS;Android;17) (HWD;asus;ASUS Transformer Pad TF300T;4.2.1)',
                'hasDeviceInfo' => true,
                'deviceUa' => 'asus transformer pad tf300t',
                'deviceCode' => 'A369i',
                'hasClientInfo' => true,
                'clientCode' => null,
                'hasClientVersion' => true,
                'clientVersion' => null,
                'hasPlatformInfo' => true,
                'os' => Os::android,
                'hasPlatformVersion' => true,
                'platformVersion' => '4.2.1',
                'hasEngineInfo' => true,
                'engine' => \BrowserDetector\Data\Engine::webkit,
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
        ];
    }
}
