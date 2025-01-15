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

use BrowserDetector\Loader\Data\ClientData;
use BrowserDetector\Parser\Header\UseragentClientCode;
use BrowserDetector\Parser\Header\UseragentClientVersion;
use BrowserDetector\Parser\Header\UseragentDeviceCode;
use BrowserDetector\Parser\Header\UseragentEngineCode;
use BrowserDetector\Parser\Header\UseragentEngineVersion;
use BrowserDetector\Parser\Header\UseragentPlatformCode;
use BrowserDetector\Parser\Header\UseragentPlatformVersion;
use BrowserDetector\Version\Exception\NotNumericException;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\VersionBuilder;
use PHPUnit\Framework\Attributes\DataProvider;
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
use UnexpectedValueException;

use function sprintf;

final class UseragentTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws NotNumericException
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
            ->expects(self::once())
            ->method('parse')
            ->with($deviceUa)
            ->willReturn($deviceCode);

        $platformParser = $this->createMock(PlatformParserInterface::class);
        $platformParser
            ->expects(self::any())
            ->method('parse')
            ->with($ua)
            ->willReturn('');

        $browserParser = $this->createMock(BrowserParserInterface::class);
        $browserParser
            ->expects(self::any())
            ->method('parse')
            ->with($ua)
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

        $normalizerFactory = new NormalizerFactory();

        $header = new FullHeader(
            value: $ua,
            deviceCode: new UseragentDeviceCode(
                deviceParser: $deviceParser,
                normalizerFactory: $normalizerFactory,
            ),
            clientCode: new UseragentClientCode(
                browserParser: $browserParser,
                normalizerFactory: $normalizerFactory,
            ),
            clientVersion: new UseragentClientVersion(
                browserParser: $browserParser,
                browserLoader: $browserLoader,
                normalizerFactory: $normalizerFactory,
            ),
            platformCode: new UseragentPlatformCode(
                platformParser: $platformParser,
                normalizerFactory: $normalizerFactory,
            ),
            platformVersion: new UseragentPlatformVersion(
                platformParser: $platformParser,
                platformLoader: $platformLoader,
                normalizerFactory: $normalizerFactory,
            ),
            engineCode: new UseragentEngineCode(
                engineParser: $engineParser,
                normalizerFactory: $normalizerFactory,
            ),
            engineVersion: new UseragentEngineVersion(
                engineParser: $engineParser,
                engineLoader: $engineLoader,
                normalizerFactory: $normalizerFactory,
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
        self::assertSame(
            $clientVersion,
            $header->getClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
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
        self::assertSame(
            $platformVersion,
            $header->getPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
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
        self::assertSame(
            $engineVersion,
            $header->getEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
    }

    /**
     * @return array<int, array<string, bool|string|null>>
     *
     * @throws void
     */
    public static function providerUa(): array
    {
        return [
            [
                'ua' => 'Mozilla/5.0 (Linux; Android 7.0; B1-7A0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36',
                'normalizedUa' => 'Mozilla/5.0 (Linux; Android 7.0; B1-7A0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36',
                'hasDeviceInfo' => true,
                'deviceUa' => 'Mozilla/5.0 (Linux; Android 7.0; B1-7A0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36',
                'deviceCode' => 'B1-7A0',
                'hasClientInfo' => true,
                'clientCode' => null,
                'hasClientVersion' => true,
                'clientVersion' => null,
                'hasPlatformInfo' => true,
                'platformCode' => null,
                'hasPlatformVersion' => true,
                'platformVersion' => null,
                'hasEngineInfo' => true,
                'engineUa' => 'Mozilla/5.0 (Linux; Android 7.0; B1-7A0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36',
                'engineCode' => 'webkit',
                'hasEngineVersion' => true,
                'engineVersion' => '534.20.0',
            ],
            [
                'ua' => 'dv(iPh14,4);pr(UCBrowse/11a);ov(17a);ss(375x812);bt(GJ);pm(0);bv(0);nm(0);im(0);nt(2);',
                'normalizedUa' => 'dv(iPh14,4);pr(UCBrowse/11a);ov(17a);ss(375x812);bt(GJ);pm(0);bv(0);nm(0);im(0);nt(2);',
                'hasDeviceInfo' => true,
                'deviceUa' => 'iPh14,4',
                'deviceCode' => 'iPh14,4',
                'hasClientInfo' => true,
                'clientCode' => null,
                'hasClientVersion' => true,
                'clientVersion' => null,
                'hasPlatformInfo' => true,
                'platformCode' => null,
                'hasPlatformVersion' => true,
                'platformVersion' => null,
                'hasEngineInfo' => true,
                'engineUa' => 'dv(iPh14,4);pr(UCBrowse/11a);ov(17a);ss(375x812);bt(GJ);pm(0);bv(0);nm(0);im(0);nt(2);',
                'engineCode' => '',
                'hasEngineVersion' => true,
                'engineVersion' => null,
            ],
            [
                'ua' => 'dv(iPh14,4);pr(UCBrowser/11.3.5.1203);ov(17_3_1);ss(375x812);bt(GJ);pm(0);bv(0);nm(0);im(0);nt(2);',
                'normalizedUa' => 'dv(iPh14,4);pr(UCBrowser/11.3.5.1203);ov(17_3_1);ss(375x812);bt(GJ);pm(0);bv(0);nm(0);im(0);nt(2);',
                'hasDeviceInfo' => true,
                'deviceUa' => 'iPh14,4',
                'deviceCode' => 'iPh14,4',
                'hasClientInfo' => true,
                'clientCode' => 'ucbrowser',
                'hasClientVersion' => true,
                'clientVersion' => '11.3.5.1203',
                'hasPlatformInfo' => true,
                'platformCode' => null,
                'hasPlatformVersion' => true,
                'platformVersion' => '17.3.1',
                'hasEngineInfo' => true,
                'engineUa' => 'dv(iPh14,4);pr(UCBrowser/11.3.5.1203);ov(17_3_1);ss(375x812);bt(GJ);pm(0);bv(0);nm(0);im(0);nt(2);',
                'engineCode' => '',
                'hasEngineVersion' => true,
                'engineVersion' => null,
            ],
            [
                'ua' => 'pf(Linux);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'normalizedUa' => 'pf(Linux);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'hasDeviceInfo' => true,
                'deviceUa' => 'Lenovo A369i Build/JDQ39',
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
                'engineVersion' => '534.31',
            ],
            [
                'ua' => 'pf(Symbian);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'normalizedUa' => 'pf(Symbian);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'hasDeviceInfo' => true,
                'deviceUa' => 'Lenovo A369i Build/JDQ39',
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
                'engineVersion' => '534.31',
            ],
            [
                'ua' => 'pf(Java);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'normalizedUa' => 'pf(Java);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'hasDeviceInfo' => true,
                'deviceUa' => 'Lenovo A369i Build/JDQ39',
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
                'engineVersion' => '534.31',
            ],
            [
                'ua' => 'pf(Windows);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(Android 4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'normalizedUa' => 'pf(Windows);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(Android 4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'hasDeviceInfo' => true,
                'deviceUa' => 'Lenovo A369i Build/JDQ39',
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
                'engineVersion' => '534.31',
            ],
            [
                'ua' => 'pf(Windows);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(wds 4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'normalizedUa' => 'pf(Windows);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(wds 4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'hasDeviceInfo' => true,
                'deviceUa' => 'Lenovo A369i Build/JDQ39',
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
                'engineVersion' => '534.31',
            ],
            [
                'ua' => 'pf(Windows);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'normalizedUa' => 'pf(Windows);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'hasDeviceInfo' => true,
                'deviceUa' => 'Lenovo A369i Build/JDQ39',
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
                'engineVersion' => '534.31',
            ],
            [
                'ua' => 'pf(44);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'normalizedUa' => 'pf(44);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'hasDeviceInfo' => true,
                'deviceUa' => 'Lenovo A369i Build/JDQ39',
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
                'engineVersion' => '534.31',
            ],
            [
                'ua' => 'pf(42);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'normalizedUa' => 'pf(42);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'hasDeviceInfo' => true,
                'deviceUa' => 'Lenovo A369i Build/JDQ39',
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
                'engineVersion' => '534.31',
            ],
            [
                'ua' => 'pf(x);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'normalizedUa' => 'pf(x);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'hasDeviceInfo' => true,
                'deviceUa' => 'Lenovo A369i Build/JDQ39',
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
                'engineVersion' => '534.31',
            ],
            [
                'ua' => 'pf(Linux);la(en-US);re(U2/1.0.0);dv(GT-S7262);pr(UCBrowser/9.4.1.482);ov(4.1.2);pi(480*800);ss(480*800);up(U2/1.0.0);er(U);bt(GJ);pm(1);nm(0);im(0);sr(2);nt(99);',
                'normalizedUa' => 'pf(Linux);la(en-US);re(U2/1.0.0);dv(GT-S7262);pr(UCBrowser/9.4.1.482);ov(4.1.2);pi(480*800);ss(480*800);up(U2/1.0.0);er(U);bt(GJ);pm(1);nm(0);im(0);sr(2);nt(99);',
                'hasDeviceInfo' => true,
                'deviceUa' => 'GT-S7262',
                'deviceCode' => 'A369i',
                'hasClientInfo' => true,
                'clientCode' => 'ucbrowser',
                'hasClientVersion' => true,
                'clientVersion' => '9.4.1.482',
                'hasPlatformInfo' => true,
                'platformCode' => 'android',
                'hasPlatformVersion' => true,
                'platformVersion' => '4.1.2',
                'hasEngineInfo' => true,
                'engineUa' => '',
                'engineCode' => 'u2',
                'hasEngineVersion' => true,
                'engineVersion' => '1.0.0',
            ],
        ];
    }

    /** @throws ExpectationFailedException */
    public function testData7(): void
    {
        $ua = 'Mozilla/5.0 (Linux; Android 7.0; B1-7A0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36';

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::once())
            ->method('parse')
            ->with($ua)
            ->willReturn('');

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

        $normalizerFactory = new NormalizerFactory();

        $header = new FullHeader(
            value: $ua,
            deviceCode: new UseragentDeviceCode(
                deviceParser: $deviceParser,
                normalizerFactory: $normalizerFactory,
            ),
            clientCode: new UseragentClientCode(
                browserParser: $browserParser,
                normalizerFactory: $normalizerFactory,
            ),
            clientVersion: new UseragentClientVersion(
                browserParser: $browserParser,
                browserLoader: $browserLoader,
                normalizerFactory: $normalizerFactory,
            ),
            platformCode: new UseragentPlatformCode(
                platformParser: $platformParser,
                normalizerFactory: $normalizerFactory,
            ),
            platformVersion: new UseragentPlatformVersion(
                platformParser: $platformParser,
                platformLoader: $platformLoader,
                normalizerFactory: $normalizerFactory,
            ),
            engineCode: new UseragentEngineCode(
                engineParser: $engineParser,
                normalizerFactory: $normalizerFactory,
            ),
            engineVersion: new UseragentEngineVersion(
                engineParser: $engineParser,
                engineLoader: $engineLoader,
                normalizerFactory: $normalizerFactory,
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
        self::assertNull(
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

    /** @throws ExpectationFailedException */
    public function testDataWithoutVersions(): void
    {
        $ua          = 'Mozilla/5.0 (Linux; Android 7.0; B1-7A0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36';
        $deviceKey   = 'test-device-key';
        $platformKey = 'test-platform-key';
        $clientKey   = 'test-client-key';
        $engineKey   = 'test-engine-key';

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::once())
            ->method('parse')
            ->with($ua)
            ->willReturn($deviceKey);

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
                        version: new NullVersion(),
                        manufacturer: new Company(type: '', name: null, brandname: null),
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

        $normalizerFactory = new NormalizerFactory();

        $header = new FullHeader(
            value: $ua,
            deviceCode: new UseragentDeviceCode(
                deviceParser: $deviceParser,
                normalizerFactory: $normalizerFactory,
            ),
            clientCode: new UseragentClientCode(
                browserParser: $browserParser,
                normalizerFactory: $normalizerFactory,
            ),
            clientVersion: new UseragentClientVersion(
                browserParser: $browserParser,
                browserLoader: $browserLoader,
                normalizerFactory: $normalizerFactory,
            ),
            platformCode: new UseragentPlatformCode(
                platformParser: $platformParser,
                normalizerFactory: $normalizerFactory,
            ),
            platformVersion: new UseragentPlatformVersion(
                platformParser: $platformParser,
                platformLoader: $platformLoader,
                normalizerFactory: $normalizerFactory,
            ),
            engineCode: new UseragentEngineCode(
                engineParser: $engineParser,
                normalizerFactory: $normalizerFactory,
            ),
            engineVersion: new UseragentEngineVersion(
                engineParser: $engineParser,
                engineLoader: $engineLoader,
                normalizerFactory: $normalizerFactory,
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
     */
    public function testDataWithVersions(): void
    {
        $ua          = 'Mozilla/5.0 (Linux; Android 7.0; B1-7A0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36';
        $deviceKey   = 'test-device-key';
        $platformKey = 'test-platform-key';
        $clientKey   = 'test-client-key';
        $engineKey   = 'test-engine-key';

        $browserVersion  = '1.2.0';
        $platformVersion = '2.4.0';
        $engineVersion   = '4.8.0';

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::once())
            ->method('parse')
            ->with($ua)
            ->willReturn($deviceKey);

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
                        version: (new VersionBuilder())->set($browserVersion),
                        manufacturer: new Company(type: '', name: null, brandname: null),
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

        $normalizerFactory = new NormalizerFactory();

        $header = new FullHeader(
            value: $ua,
            deviceCode: new UseragentDeviceCode(
                deviceParser: $deviceParser,
                normalizerFactory: $normalizerFactory,
            ),
            clientCode: new UseragentClientCode(
                browserParser: $browserParser,
                normalizerFactory: $normalizerFactory,
            ),
            clientVersion: new UseragentClientVersion(
                browserParser: $browserParser,
                browserLoader: $browserLoader,
                normalizerFactory: $normalizerFactory,
            ),
            platformCode: new UseragentPlatformCode(
                platformParser: $platformParser,
                normalizerFactory: $normalizerFactory,
            ),
            platformVersion: new UseragentPlatformVersion(
                platformParser: $platformParser,
                platformLoader: $platformLoader,
                normalizerFactory: $normalizerFactory,
            ),
            engineCode: new UseragentEngineCode(
                engineParser: $engineParser,
                normalizerFactory: $normalizerFactory,
            ),
            engineVersion: new UseragentEngineVersion(
                engineParser: $engineParser,
                engineLoader: $engineLoader,
                normalizerFactory: $normalizerFactory,
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
     */
    public function testDataWithClientParserException(): void
    {
        $ua          = 'Mozilla/5.0 (Linux; Android 7.0; B1-7A0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36';
        $deviceKey   = 'test-device-key';
        $platformKey = 'test-platform-key';
        $engineKey   = 'test-engine-key';

        $platformVersion = '2.4.0';
        $engineVersion   = '4.8.0';

        $clientException = new NotFoundException('client-exception');

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::once())
            ->method('parse')
            ->with($ua)
            ->willReturn($deviceKey);

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

        $normalizerFactory = new NormalizerFactory();

        $header = new FullHeader(
            value: $ua,
            deviceCode: new UseragentDeviceCode(
                deviceParser: $deviceParser,
                normalizerFactory: $normalizerFactory,
            ),
            clientCode: new UseragentClientCode(
                browserParser: $browserParser,
                normalizerFactory: $normalizerFactory,
            ),
            clientVersion: new UseragentClientVersion(
                browserParser: $browserParser,
                browserLoader: $browserLoader,
                normalizerFactory: $normalizerFactory,
            ),
            platformCode: new UseragentPlatformCode(
                platformParser: $platformParser,
                normalizerFactory: $normalizerFactory,
            ),
            platformVersion: new UseragentPlatformVersion(
                platformParser: $platformParser,
                platformLoader: $platformLoader,
                normalizerFactory: $normalizerFactory,
            ),
            engineCode: new UseragentEngineCode(
                engineParser: $engineParser,
                normalizerFactory: $normalizerFactory,
            ),
            engineVersion: new UseragentEngineVersion(
                engineParser: $engineParser,
                engineLoader: $engineLoader,
                normalizerFactory: $normalizerFactory,
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

    /**
     * @throws ExpectationFailedException
     * @throws NotNumericException
     */
    public function testDataWithClientParserException2(): void
    {
        $ua          = 'Mozilla/5.0 (Linux; Android 7.0; B1-7A0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36';
        $deviceKey   = 'test-device-key';
        $platformKey = 'test-platform-key';
        $engineKey   = 'test-engine-key';

        $platformVersion = '2.4.0';
        $engineVersion   = '4.8.0';

        $clientException = new UnexpectedValueException('client-exception');

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::once())
            ->method('parse')
            ->with($ua)
            ->willReturn($deviceKey);

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

        $normalizerFactory = new NormalizerFactory();

        $header = new FullHeader(
            value: $ua,
            deviceCode: new UseragentDeviceCode(
                deviceParser: $deviceParser,
                normalizerFactory: $normalizerFactory,
            ),
            clientCode: new UseragentClientCode(
                browserParser: $browserParser,
                normalizerFactory: $normalizerFactory,
            ),
            clientVersion: new UseragentClientVersion(
                browserParser: $browserParser,
                browserLoader: $browserLoader,
                normalizerFactory: $normalizerFactory,
            ),
            platformCode: new UseragentPlatformCode(
                platformParser: $platformParser,
                normalizerFactory: $normalizerFactory,
            ),
            platformVersion: new UseragentPlatformVersion(
                platformParser: $platformParser,
                platformLoader: $platformLoader,
                normalizerFactory: $normalizerFactory,
            ),
            engineCode: new UseragentEngineCode(
                engineParser: $engineParser,
                normalizerFactory: $normalizerFactory,
            ),
            engineVersion: new UseragentEngineVersion(
                engineParser: $engineParser,
                engineLoader: $engineLoader,
                normalizerFactory: $normalizerFactory,
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

    /**
     * @throws ExpectationFailedException
     * @throws NotNumericException
     */
    public function testDataWithClientParserException3(): void
    {
        $ua          = 'Mozilla/5.0 (Linux; Android 7.0; B1-7A0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36';
        $deviceKey   = 'test-device-key';
        $platformKey = 'test-platform-key';
        $engineKey   = 'test-engine-key';

        $platformVersion = '2.4.0';
        $engineVersion   = '4.8.0';

        $clientException = new NotFoundException('client-exception');

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::once())
            ->method('parse')
            ->with($ua)
            ->willReturn($deviceKey);

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

        $normalizerFactory = new NormalizerFactory();

        $header = new FullHeader(
            value: $ua,
            deviceCode: new UseragentDeviceCode(
                deviceParser: $deviceParser,
                normalizerFactory: $normalizerFactory,
            ),
            clientCode: new UseragentClientCode(
                browserParser: $browserParser,
                normalizerFactory: $normalizerFactory,
            ),
            clientVersion: new UseragentClientVersion(
                browserParser: $browserParser,
                browserLoader: $browserLoader,
                normalizerFactory: $normalizerFactory,
            ),
            platformCode: new UseragentPlatformCode(
                platformParser: $platformParser,
                normalizerFactory: $normalizerFactory,
            ),
            platformVersion: new UseragentPlatformVersion(
                platformParser: $platformParser,
                platformLoader: $platformLoader,
                normalizerFactory: $normalizerFactory,
            ),
            engineCode: new UseragentEngineCode(
                engineParser: $engineParser,
                normalizerFactory: $normalizerFactory,
            ),
            engineVersion: new UseragentEngineVersion(
                engineParser: $engineParser,
                engineLoader: $engineLoader,
                normalizerFactory: $normalizerFactory,
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

    /** @throws ExpectationFailedException */
    public function testDataWithLoaderExceptions(): void
    {
        $ua          = 'Mozilla/5.0 (Linux; Android 7.0; B1-7A0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36';
        $deviceKey   = 'test-device-key';
        $platformKey = 'test-platform-key';
        $clientKey   = 'test-client-key';
        $engineKey   = 'test-engine-key';

        $clientException   = new NotFoundException('client-exception');
        $platformException = new NotFoundException('platform-exception');
        $engineException   = new NotFoundException('engine-exception');

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::once())
            ->method('parse')
            ->with($ua)
            ->willReturn($deviceKey);

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
            ->willThrowException($clientException);

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with($platformKey, $ua)
            ->willThrowException($platformException);

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineKey, $ua)
            ->willThrowException($engineException);

        $normalizerFactory = new NormalizerFactory();

        $header = new FullHeader(
            value: $ua,
            deviceCode: new UseragentDeviceCode(
                deviceParser: $deviceParser,
                normalizerFactory: $normalizerFactory,
            ),
            clientCode: new UseragentClientCode(
                browserParser: $browserParser,
                normalizerFactory: $normalizerFactory,
            ),
            clientVersion: new UseragentClientVersion(
                browserParser: $browserParser,
                browserLoader: $browserLoader,
                normalizerFactory: $normalizerFactory,
            ),
            platformCode: new UseragentPlatformCode(
                platformParser: $platformParser,
                normalizerFactory: $normalizerFactory,
            ),
            platformVersion: new UseragentPlatformVersion(
                platformParser: $platformParser,
                platformLoader: $platformLoader,
                normalizerFactory: $normalizerFactory,
            ),
            engineCode: new UseragentEngineCode(
                engineParser: $engineParser,
                normalizerFactory: $normalizerFactory,
            ),
            engineVersion: new UseragentEngineVersion(
                engineParser: $engineParser,
                engineLoader: $engineLoader,
                normalizerFactory: $normalizerFactory,
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

    /** @throws ExpectationFailedException */
    public function testDataWithLoaderExceptions2(): void
    {
        $ua          = 'Mozilla/5.0 (Linux; Android 7.0; B1-7A0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36';
        $deviceKey   = 'test-device-key';
        $platformKey = 'test-platform-key';
        $clientKey   = 'test-client-key';
        $engineKey   = 'test-engine-key';

        $clientException   = new NotFoundException('client-exception');
        $platformException = new NotFoundException('platform-exception');
        $engineException   = new NotFoundException('engine-exception');

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::once())
            ->method('parse')
            ->with($ua)
            ->willReturn($deviceKey);

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
            ->willThrowException($clientException);

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with($platformKey, $ua)
            ->willThrowException($platformException);

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineKey, $ua)
            ->willThrowException($engineException);

        $normalizerFactory = new NormalizerFactory();

        $header = new FullHeader(
            value: $ua,
            deviceCode: new UseragentDeviceCode(
                deviceParser: $deviceParser,
                normalizerFactory: $normalizerFactory,
            ),
            clientCode: new UseragentClientCode(
                browserParser: $browserParser,
                normalizerFactory: $normalizerFactory,
            ),
            clientVersion: new UseragentClientVersion(
                browserParser: $browserParser,
                browserLoader: $browserLoader,
                normalizerFactory: $normalizerFactory,
            ),
            platformCode: new UseragentPlatformCode(
                platformParser: $platformParser,
                normalizerFactory: $normalizerFactory,
            ),
            platformVersion: new UseragentPlatformVersion(
                platformParser: $platformParser,
                platformLoader: $platformLoader,
                normalizerFactory: $normalizerFactory,
            ),
            engineCode: new UseragentEngineCode(
                engineParser: $engineParser,
                normalizerFactory: $normalizerFactory,
            ),
            engineVersion: new UseragentEngineVersion(
                engineParser: $engineParser,
                engineLoader: $engineLoader,
                normalizerFactory: $normalizerFactory,
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
}
