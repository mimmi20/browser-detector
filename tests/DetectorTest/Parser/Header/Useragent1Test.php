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

use function mb_strtolower;
use function sprintf;

/** @phpcs:disable SlevomatCodingStandard.Classes.ClassLength.ClassTooLong */
#[CoversClass(UseragentClientCode::class)]
#[CoversClass(UseragentClientVersion::class)]
#[CoversClass(UseragentDeviceCode::class)]
#[CoversClass(UseragentEngineCode::class)]
#[CoversClass(UseragentEngineVersion::class)]
#[CoversClass(UseragentPlatformCode::class)]
#[CoversClass(UseragentPlatformVersion::class)]
final class Useragent1Test extends TestCase
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
    #[DataProvider('providerUa')]
    public function testData(
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
        string $engineUa,
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
            ->expects(self::never())
            ->method('parse')
            ->with($ua)
            ->willReturn('');

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::never())
            ->method('parse')
            ->with($ua)
            ->willReturn('');

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::never())
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
            ->expects(self::never())
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
    public static function providerUa(): array
    {
        return [
            [
                'ua' => 'pf(Linux);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'normalizedUa' => 'pf(Linux);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'hasDeviceInfo' => true,
                'deviceUa' => 'lenovo a369i',
                'deviceCode' => 'A369i',
                'hasClientInfo' => true,
                'clientCode' => 'ucbrowser',
                'hasClientVersion' => true,
                'clientVersion' => '9.1.0.297',
                'hasPlatformInfo' => true,
                'platformCode' => 'android',
                'hasPlatformVersion' => true,
                'platformVersion' => '4.2.2',
                'hasEngineInfo' => true,
                'engineUa' => 'pf(Linux);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(Android 4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'engineCode' => 'webkit',
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
            [
                'ua' => 'pf(Symbian);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'normalizedUa' => 'pf(Symbian);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'hasDeviceInfo' => true,
                'deviceUa' => 'lenovo a369i',
                'deviceCode' => 'A369i',
                'hasClientInfo' => true,
                'clientCode' => 'ucbrowser',
                'hasClientVersion' => true,
                'clientVersion' => '9.1.0.297',
                'hasPlatformInfo' => true,
                'platformCode' => 'symbian',
                'hasPlatformVersion' => true,
                'platformVersion' => '4.2.2',
                'hasEngineInfo' => true,
                'engineUa' => '',
                'engineCode' => 'webkit',
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
            [
                'ua' => 'pf(Java);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'normalizedUa' => 'pf(Java);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'hasDeviceInfo' => true,
                'deviceUa' => 'lenovo a369i',
                'deviceCode' => 'A369i',
                'hasClientInfo' => true,
                'clientCode' => 'ucbrowser',
                'hasClientVersion' => true,
                'clientVersion' => '9.1.0.297',
                'hasPlatformInfo' => true,
                'platformCode' => 'java',
                'hasPlatformVersion' => true,
                'platformVersion' => '4.2.2',
                'hasEngineInfo' => true,
                'engineUa' => '',
                'engineCode' => 'webkit',
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
            [
                'ua' => 'pf(Windows);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(Android 4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'normalizedUa' => 'pf(Windows);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(Android 4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'hasDeviceInfo' => true,
                'deviceUa' => 'lenovo a369i',
                'deviceCode' => 'A369i',
                'hasClientInfo' => true,
                'clientCode' => 'ucbrowser',
                'hasClientVersion' => true,
                'clientVersion' => '9.1.0.297',
                'hasPlatformInfo' => true,
                'platformCode' => 'android',
                'hasPlatformVersion' => true,
                'platformVersion' => '4.2.2',
                'hasEngineInfo' => true,
                'engineUa' => '',
                'engineCode' => 'webkit',
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
            [
                'ua' => 'pf(Windows);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(wds 4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'normalizedUa' => 'pf(Windows);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(wds 4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'hasDeviceInfo' => true,
                'deviceUa' => 'lenovo a369i',
                'deviceCode' => 'A369i',
                'hasClientInfo' => true,
                'clientCode' => 'ucbrowser',
                'hasClientVersion' => true,
                'clientVersion' => '9.1.0.297',
                'hasPlatformInfo' => true,
                'platformCode' => 'windows phone',
                'hasPlatformVersion' => true,
                'platformVersion' => '4.2.2',
                'hasEngineInfo' => true,
                'engineUa' => '',
                'engineCode' => 'webkit',
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
            [
                'ua' => 'pf(Windows);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'normalizedUa' => 'pf(Windows);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'hasDeviceInfo' => true,
                'deviceUa' => 'lenovo a369i',
                'deviceCode' => 'A369i',
                'hasClientInfo' => true,
                'clientCode' => 'ucbrowser',
                'hasClientVersion' => true,
                'clientVersion' => '9.1.0.297',
                'hasPlatformInfo' => true,
                'platformCode' => 'windows phone',
                'hasPlatformVersion' => true,
                'platformVersion' => '4.2.2',
                'hasEngineInfo' => true,
                'engineUa' => '',
                'engineCode' => 'webkit',
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
            [
                'ua' => 'pf(44);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'normalizedUa' => 'pf(44);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'hasDeviceInfo' => true,
                'deviceUa' => 'lenovo a369i',
                'deviceCode' => 'A369i',
                'hasClientInfo' => true,
                'clientCode' => 'ucbrowser',
                'hasClientVersion' => true,
                'clientVersion' => '9.1.0.297',
                'hasPlatformInfo' => true,
                'platformCode' => 'ios',
                'hasPlatformVersion' => true,
                'platformVersion' => '4.2.2',
                'hasEngineInfo' => true,
                'engineUa' => '',
                'engineCode' => 'webkit',
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
            [
                'ua' => 'pf(42);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'normalizedUa' => 'pf(42);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'hasDeviceInfo' => true,
                'deviceUa' => 'lenovo a369i',
                'deviceCode' => 'A369i',
                'hasClientInfo' => true,
                'clientCode' => 'ucbrowser',
                'hasClientVersion' => true,
                'clientVersion' => '9.1.0.297',
                'hasPlatformInfo' => true,
                'platformCode' => 'ios',
                'hasPlatformVersion' => true,
                'platformVersion' => '4.2.2',
                'hasEngineInfo' => true,
                'engineUa' => '',
                'engineCode' => 'webkit',
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
            [
                'ua' => 'pf(x);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'normalizedUa' => 'pf(x);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'hasDeviceInfo' => true,
                'deviceUa' => 'lenovo a369i',
                'deviceCode' => 'A369i',
                'hasClientInfo' => true,
                'clientCode' => 'ucbrowser',
                'hasClientVersion' => true,
                'clientVersion' => '9.1.0.297',
                'hasPlatformInfo' => true,
                'platformCode' => null,
                'hasPlatformVersion' => true,
                'platformVersion' => '4.2.2',
                'hasEngineInfo' => true,
                'engineUa' => '',
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
    #[DataProvider('providerUa2')]
    public function testData2(
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
            ->expects(self::never())
            ->method('parse')
            ->with($ua)
            ->willReturn('');

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::never())
            ->method('parse')
            ->with($ua)
            ->willReturn('');

        $engineParser = $this->createMock(EngineParserInterface::class);
        $engineParser
            ->expects(self::never())
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
            ->expects(self::never())
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
            ->with(mb_strtolower($deviceUa))
            ->willReturn(null);

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
    public static function providerUa2(): array
    {
        return [
            [
                'ua' => 'pf(x);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'normalizedUa' => 'pf(x);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'hasDeviceInfo' => true,
                'deviceUa' => 'Lenovo A369i',
                'deviceCode' => 'A369i',
                'hasClientInfo' => true,
                'clientCode' => 'ucbrowser',
                'hasClientVersion' => true,
                'clientVersion' => '9.1.0.297',
                'hasPlatformInfo' => true,
                'platformCode' => null,
                'hasPlatformVersion' => true,
                'platformVersion' => '4.2.2',
                'hasEngineInfo' => true,
                'engineUa' => '',
                'engineCode' => 'webkit',
                'hasEngineVersion' => true,
                'engineVersion' => '534.31.0',
            ],
        ];
    }
}
