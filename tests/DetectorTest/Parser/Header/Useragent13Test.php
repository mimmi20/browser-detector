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

namespace BrowserDetectorTest\Parser\Header;

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
final class Useragent13Test extends TestCase
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
    #[DataProvider('providerUa3')]
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
        string | null $platformCode,
        bool $hasPlatformVersion,
        string | null $platformVersion,
        bool $hasEngineInfo,
        string | null $engineCode,
        bool $hasEngineVersion,
        string | null $engineVersion,
    ): void {
        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::never())
            ->method('parse');

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::any())
            ->method('parse')
            ->with($normalizedUa)
            ->willReturn('');

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::any())
            ->method('parse')
            ->with($normalizedUa)
            ->willReturn('');

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::any())
            ->method('parse')
            ->with($normalizedUa)
            ->willReturn($engineCode);

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
            ->expects(self::any())
            ->method('load')
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
            ->expects(self::once())
            ->method('getDeviceCode')
            ->with($deviceUa)
            ->willReturn($deviceCode);

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
            $engineCode === '' ? null : $engineCode,
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
     * @return array<int, array<string, bool|string|null>>
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
                'platformCode' => 'android',
                'hasPlatformVersion' => true,
                'platformVersion' => '15.0.0',
                'hasEngineInfo' => true,
                'engineCode' => 'webkit',
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
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
                'platformCode' => 'android',
                'hasPlatformVersion' => true,
                'platformVersion' => '4.2.2',
                'hasEngineInfo' => true,
                'engineCode' => 'webkit',
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
                'platformCode' => 'android',
                'hasPlatformVersion' => true,
                'platformVersion' => '4.2.1',
                'hasEngineInfo' => true,
                'engineCode' => 'webkit',
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
        ];
    }

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
    #[DataProvider('providerUa4')]
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
        string $platformUa,
        string | null $platformCode,
        bool $hasPlatformVersion,
        string | null $platformVersion,
        bool $hasEngineInfo,
        string $engineUa,
        string | null $engineCode,
        bool $hasEngineVersion,
        string | null $engineVersion,
    ): void {
        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::once())
            ->method('parse')
            ->with($deviceUa)
            ->willReturn($deviceCode);

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::any())
            ->method('parse')
            ->with($platformUa)
            ->willReturn('');

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::any())
            ->method('parse')
            ->with($clientUa)
            ->willReturn('');

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::any())
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

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::any())
            ->method('load')
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
            $engineCode === '' ? null : $engineCode,
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
     * @return array<int, array<string, bool|string|null>>
     *
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    public static function providerUa4(): array
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
                'platformUa' => 'Android 17 - samsung meliuslte',
                'platformCode' => 'android',
                'hasPlatformVersion' => true,
                'platformVersion' => null,
                'hasEngineInfo' => true,
                'engineUa' => 'Android 17 - samsung meliuslte',
                'engineCode' => 'webkit',
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
            [
                'ua' => 'News Republic/12.1.5 (Linux; U; Android 26; en-us) Mobile Safari',
                'normalizedUa' => 'News Republic/12.1.5 (Linux; U; Android 26; en-us) Mobile Safari',
                'hasDeviceInfo' => true,
                'deviceUa' => 'News Republic/12.1.5 (Linux; Android 26) Mobile Safari',
                'deviceCode' => 'A369i',
                'hasClientInfo' => true,
                'clientUa' => 'News Republic/12.1.5 (Linux; Android 26) Mobile Safari',
                'clientCode' => null,
                'hasClientVersion' => true,
                'clientVersion' => null,
                'hasPlatformInfo' => true,
                'platformUa' => 'News Republic/12.1.5 (Linux; Android 26) Mobile Safari',
                'platformCode' => 'android',
                'hasPlatformVersion' => true,
                'platformVersion' => null,
                'hasEngineInfo' => true,
                'engineUa' => 'News Republic/12.1.5 (Linux; Android 26) Mobile Safari',
                'engineCode' => 'webkit',
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
            [
                'ua' => 'APP : Mozilla/5.0 (Linux; Android 23 ; LENOVO ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.98 Mobile Safari/537.36;mm-app-v2.0',
                'normalizedUa' => 'APP : Mozilla/5.0 (Linux; Android 23 ; LENOVO ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.98 Mobile Safari/537.36;mm-app-v2.0',
                'hasDeviceInfo' => true,
                'deviceUa' => 'APP : Mozilla/5.0 (Linux; Android 23 ; LENOVO ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.98 Mobile Safari/537.36;mm-app-v2.0',
                'deviceCode' => 'A369i',
                'hasClientInfo' => true,
                'clientUa' => 'APP : Mozilla/5.0 (Linux; Android 23 ; LENOVO ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.98 Mobile Safari/537.36;mm-app-v2.0',
                'clientCode' => null,
                'hasClientVersion' => true,
                'clientVersion' => null,
                'hasPlatformInfo' => true,
                'platformUa' => 'APP : Mozilla/5.0 (Linux; Android 23 ; LENOVO ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.98 Mobile Safari/537.36;mm-app-v2.0',
                'platformCode' => 'android',
                'hasPlatformVersion' => true,
                'platformVersion' => null,
                'hasEngineInfo' => true,
                'engineUa' => 'APP : Mozilla/5.0 (Linux; Android 23 ; LENOVO ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.98 Mobile Safari/537.36;mm-app-v2.0',
                'engineCode' => 'webkit',
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
            [
                'ua' => 'Mozilla/5.0 (Linux; Android 30.0.0 IOS; SM-A900F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.143 Mobile Safari/537.36',
                'normalizedUa' => 'Mozilla/5.0 (Linux; Android 30.0.0 IOS; SM-A900F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.143 Mobile Safari/537.36',
                'hasDeviceInfo' => true,
                'deviceUa' => 'Mozilla/5.0 (Linux; Android 30.0.0 IOS; SM-A900F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.143 Mobile Safari/537.36',
                'deviceCode' => 'A369i',
                'hasClientInfo' => true,
                'clientUa' => 'Mozilla/5.0 (Linux; Android 30.0.0 IOS; SM-A900F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.143 Mobile Safari/537.36',
                'clientCode' => null,
                'hasClientVersion' => true,
                'clientVersion' => null,
                'hasPlatformInfo' => true,
                'platformUa' => 'Mozilla/5.0 (Linux; Android 30.0.0 IOS; SM-A900F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.143 Mobile Safari/537.36',
                'platformCode' => 'android',
                'hasPlatformVersion' => true,
                'platformVersion' => null,
                'hasEngineInfo' => true,
                'engineUa' => 'Mozilla/5.0 (Linux; Android 30.0.0 IOS; SM-A900F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.143 Mobile Safari/537.36',
                'engineCode' => 'webkit',
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
                'platformUa' => 'SM-T970 (compatible; Tablet2.0) HandelsbladProduction, com.twipemobile.nrc 5.1.4 (511) / Android 33',
                'platformCode' => 'android',
                'hasPlatformVersion' => true,
                'platformVersion' => null,
                'hasEngineInfo' => true,
                'engineUa' => 'SM-T970 (compatible; Tablet2.0) HandelsbladProduction, com.twipemobile.nrc 5.1.4 (511) / Android 33',
                'engineCode' => 'webkit',
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
                'platformUa' => 'WNYC App/3.0.3 Android/24 device/Verizon-SM-G930V',
                'platformCode' => 'android',
                'hasPlatformVersion' => true,
                'platformVersion' => null,
                'hasEngineInfo' => true,
                'engineUa' => 'WNYC App/3.0.3 Android/24 device/Verizon-SM-G930V',
                'engineCode' => 'webkit',
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
        ];
    }
}
