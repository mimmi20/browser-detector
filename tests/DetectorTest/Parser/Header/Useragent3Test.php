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
use Psr\Log\LoggerInterface;
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

use function mb_strtolower;
use function sprintf;

/** @phpcs:disable SlevomatCodingStandard.Classes.ClassLength.ClassTooLong */
#[CoversClass(className: UseragentClientCode::class)]
#[CoversClass(className: UseragentClientVersion::class)]
#[CoversClass(className: UseragentDeviceCode::class)]
#[CoversClass(className: UseragentEngineCode::class)]
#[CoversClass(className: UseragentEngineVersion::class)]
#[CoversClass(className: UseragentPlatformCode::class)]
#[CoversClass(className: UseragentPlatformVersion::class)]
final class Useragent3Test extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws NotNumericException
     * @throws Exception
     * @throws UnexpectedValueException
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    #[DataProvider(methodName: 'providerUa5')]
    public function testDataWithoutFindingADevice(
        string $ua,
        string $normalizedUa,
        bool $hasDeviceInfo,
        string $deviceUa,
        string $deviceCode,
        bool $hasClientInfo,
        string $clientUa,
        string | null $clientCode,
        bool $hasClientVersion,
        string | null $clientVersion,
        bool $hasPlatformInfo,
        Os $os,
        bool $hasPlatformVersion,
        string | null $platformVersion,
        bool $hasEngineInfo,
        string $engineUa,
        \BrowserDetector\Data\Engine $engine,
        bool $hasEngineVersion,
        string | null $engineVersion,
    ): void {
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

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::once())
            ->method('parse')
            ->with($deviceUa)
            ->willReturn($deviceCode);

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::never())
            ->method('parse');

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::atLeastOnce())
            ->method('parse')
            ->with($clientUa)
            ->willReturn('');

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
            ->expects(self::once())
            ->method('getDeviceCode')
            ->with(mb_strtolower($ua))
            ->willReturn(value: null);

        $normalizerFactory = new NormalizerFactory();
        $normalizerChain   = $normalizerFactory->build();

        $fullHeader = new FullHeader(
            value: $ua,
            deviceCode: new UseragentDeviceCode(
                deviceParser: $deviceParser,
                normalizer: $normalizerChain,
                device: $deviceCodeHelper,
                logger: $logger,
                autoUpdate: false,
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
    public static function providerUa5(): array
    {
        return [
            [
                'ua' => 'Android 17 - samsung meliuslte',
                'normalizedUa' => 'Android 17 - samsung meliuslte',
                'hasDeviceInfo' => true,
                'deviceUa' => 'Android 17 - samsung meliuslte',
                'deviceCode' => 'A369i',
                'hasClientInfo' => true,
                'clientUa' => 'Android 17 - samsung meliuslte',
                'clientCode' => null,
                'hasClientVersion' => true,
                'clientVersion' => null,
                'hasPlatformInfo' => true,
                'os' => Os::android,
                'hasPlatformVersion' => true,
                'platformVersion' => null,
                'hasEngineInfo' => true,
                'engineUa' => 'Android 17 - samsung meliuslte',
                'engine' => \BrowserDetector\Data\Engine::webkit,
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
            [
                'ua' => 'News Republic/12.1.5 (Linux; Android 26) Mobile Safari',
                'normalizedUa' => 'News Republic/12.1.5 (Linux; Android 26) Mobile Safari',
                'hasDeviceInfo' => true,
                'deviceUa' => 'News Republic/12.1.5 (Linux; Android 26) Mobile Safari',
                'deviceCode' => 'A369i',
                'hasClientInfo' => true,
                'clientUa' => 'News Republic/12.1.5 (Linux; Android 26) Mobile Safari',
                'clientCode' => null,
                'hasClientVersion' => true,
                'clientVersion' => null,
                'hasPlatformInfo' => true,
                'os' => Os::android,
                'hasPlatformVersion' => true,
                'platformVersion' => null,
                'hasEngineInfo' => true,
                'engineUa' => 'News Republic/12.1.5 (Linux; Android 26) Mobile Safari',
                'engine' => \BrowserDetector\Data\Engine::webkit,
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
            [
                'ua' => 'SM-T970 (compatible; Tablet2.0) HandelsbladProduction, com.twipemobile.nrc 5.1.4 (511) / Android 33',
                'normalizedUa' => 'SM-T970 (compatible; Tablet2.0) HandelsbladProduction, com.twipemobile.nrc 5.1.4 (511) / Android 33',
                'hasDeviceInfo' => true,
                'deviceUa' => 'SM-T970 (compatible; Tablet2.0) HandelsbladProduction, com.twipemobile.nrc 5.1.4 (511) / Android 33',
                'deviceCode' => 'A369i',
                'hasClientInfo' => true,
                'clientUa' => 'SM-T970 (compatible; Tablet2.0) HandelsbladProduction, com.twipemobile.nrc 5.1.4 (511) / Android 33',
                'clientCode' => null,
                'hasClientVersion' => true,
                'clientVersion' => null,
                'hasPlatformInfo' => true,
                'os' => Os::android,
                'hasPlatformVersion' => true,
                'platformVersion' => null,
                'hasEngineInfo' => true,
                'engineUa' => 'SM-T970 (compatible; Tablet2.0) HandelsbladProduction, com.twipemobile.nrc 5.1.4 (511) / Android 33',
                'engine' => \BrowserDetector\Data\Engine::webkit,
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
            [
                'ua' => 'WNYC App/3.0.3 Android/24 device/Verizon-SM-G930V',
                'normalizedUa' => 'WNYC App/3.0.3 Android/24 device/Verizon-SM-G930V',
                'hasDeviceInfo' => true,
                'deviceUa' => 'WNYC App/3.0.3 Android/24 device/Verizon-SM-G930V',
                'deviceCode' => 'A369i',
                'hasClientInfo' => true,
                'clientUa' => 'WNYC App/3.0.3 Android/24 device/Verizon-SM-G930V',
                'clientCode' => null,
                'hasClientVersion' => true,
                'clientVersion' => null,
                'hasPlatformInfo' => true,
                'os' => Os::android,
                'hasPlatformVersion' => true,
                'platformVersion' => null,
                'hasEngineInfo' => true,
                'engineUa' => 'WNYC App/3.0.3 Android/24 device/Verizon-SM-G930V',
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
    #[DataProvider(methodName: 'providerUa6')]
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
        string $engineUa,
        \BrowserDetector\Data\Engine $engine,
        bool $hasEngineVersion,
        string | null $engineVersion,
    ): void {
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
                logger: $logger,
                autoUpdate: false,
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
    public static function providerUa6(): array
    {
        return [
            [
                'ua' => 'Virgin Radio/45.2.0.22026 / (Linux; Android 14) ExoPlayerLib/2.17.1 / samsung (SM-G996B)',
                'normalizedUa' => 'Virgin Radio/45.2.0.22026 / (Linux; Android 14) ExoPlayerLib/2.17.1 / samsung (SM-G996B)',
                'hasDeviceInfo' => true,
                'deviceUa' => 'sm-g996b',
                'deviceCode' => 'A369i',
                'hasClientInfo' => true,
                'clientCode' => 'virgin-radio',
                'hasClientVersion' => true,
                'clientVersion' => '45.2.0.22026',
                'hasPlatformInfo' => true,
                'os' => Os::android,
                'hasPlatformVersion' => true,
                'platformVersion' => '14.0.0',
                'hasEngineInfo' => true,
                'engineUa' => 'Virgin Radio/45.2.0.22026 / (Linux; Android 14) ExoPlayerLib/2.17.1 / samsung (SM-G996B)',
                'engine' => \BrowserDetector\Data\Engine::webkit,
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
            [
                'ua' => 'TiviMate/4.7.0 (Onn. 4K Streaming Box; Android 12)',
                'normalizedUa' => 'TiviMate/4.7.0 (Onn. 4K Streaming Box; Android 12)',
                'hasDeviceInfo' => true,
                'deviceUa' => 'onn. 4k streaming box',
                'deviceCode' => 'A369i',
                'hasClientInfo' => true,
                'clientCode' => 'tivimate-app',
                'hasClientVersion' => true,
                'clientVersion' => '4.7.0',
                'hasPlatformInfo' => true,
                'os' => Os::android,
                'hasPlatformVersion' => true,
                'platformVersion' => '12.0.0',
                'hasEngineInfo' => true,
                'engineUa' => 'TiviMate/4.7.0 (Onn. 4K Streaming Box; Android 12)',
                'engine' => \BrowserDetector\Data\Engine::webkit,
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
            [
                'ua' => 'PugpigBolt 3.8.10 (samsung, Android 13) on phone (model SM-G998U)',
                'normalizedUa' => 'PugpigBolt 3.8.10 (samsung, Android 13) on phone (model SM-G998U)',
                'hasDeviceInfo' => true,
                'deviceUa' => 'sm-g998u',
                'deviceCode' => 'A369i',
                'hasClientInfo' => true,
                'clientCode' => 'pugpig-bolt',
                'hasClientVersion' => true,
                'clientVersion' => '3.8.10',
                'hasPlatformInfo' => true,
                'os' => Os::android,
                'hasPlatformVersion' => true,
                'platformVersion' => '13.0.0',
                'hasEngineInfo' => true,
                'engineUa' => 'PugpigBolt 3.8.10 (samsung, Android 13) on phone (model SM-G998U)',
                'engine' => \BrowserDetector\Data\Engine::webkit,
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
            [
                'ua' => 'Classic FM/2.0.0 Android 12/SM-G975F',
                'normalizedUa' => 'Classic FM/2.0.0 Android 12/SM-G975F',
                'hasDeviceInfo' => true,
                'deviceUa' => 'sm-g975f',
                'deviceCode' => 'A369i',
                'hasClientInfo' => true,
                'clientCode' => 'classic-fm',
                'hasClientVersion' => true,
                'clientVersion' => '2.0.0',
                'hasPlatformInfo' => true,
                'os' => Os::android,
                'hasPlatformVersion' => true,
                'platformVersion' => '12.0.0',
                'hasEngineInfo' => true,
                'engineUa' => 'Classic FM/2.0.0 Android 12/SM-G975F',
                'engine' => \BrowserDetector\Data\Engine::webkit,
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
        ];
    }
}
