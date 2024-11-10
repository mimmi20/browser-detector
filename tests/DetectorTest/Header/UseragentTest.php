<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Header;

use BrowserDetector\Header\Useragent;
use BrowserDetector\Loader\BrowserLoaderInterface;
use BrowserDetector\Loader\EngineLoaderInterface;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Loader\PlatformLoaderInterface;
use BrowserDetector\Parser\BrowserParserInterface;
use BrowserDetector\Parser\DeviceParserInterface;
use BrowserDetector\Parser\EngineParserInterface;
use BrowserDetector\Parser\PlatformParserInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\NormalizerFactory;
use UnexpectedValueException;

use function sprintf;

final class UseragentTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
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
            ->willReturn(['version' => $engineVersion]);

        $normalizerFactory = new NormalizerFactory();

        $header = new Useragent(
            $ua,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
            $browserLoader,
            $platformLoader,
            $engineLoader,
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
                'engineVersion' => '534.20',
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
                'normalizedUa' => 'pf(Linux);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko) );dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
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
                'engineUa' => 'pf(Linux);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko) );dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(Android 4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'engineCode' => 'webkit',
                'hasEngineVersion' => true,
                'engineVersion' => '534.31',
            ],
            [
                'ua' => 'pf(Symbian);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko));dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
                'normalizedUa' => 'pf(Symbian);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko) );dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
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
                'normalizedUa' => 'pf(Java);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko) );dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
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
                'normalizedUa' => 'pf(Windows);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko) );dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(Android 4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
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
                'normalizedUa' => 'pf(Windows);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko) );dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(wds 4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
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
                'normalizedUa' => 'pf(Windows);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko) );dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
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
                'normalizedUa' => 'pf(44);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko) );dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
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
                'normalizedUa' => 'pf(42);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko) );dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
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
                'normalizedUa' => 'pf(x);la(en-US);re(AppleWebKit/534.31 (KHTML, like Gecko) );dv(Lenovo A369i Build/JDQ39);pr(UCBrowser/9.1.0.297);ov(4.2.2);pi(480*762);ss(480*762);up(U3/0.8.0);er(U);bt(GZ);pm(1);bv(1);nm(0);im(0);sr(0);nt(3);',
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
        ];
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
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

        $header = new Useragent(
            $ua,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
            $browserLoader,
            $platformLoader,
            $engineLoader,
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

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
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
            ->willReturn([[]]);

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with($platformKey, $ua)
            ->willReturn([]);

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineKey, $ua)
            ->willReturn([]);

        $normalizerFactory = new NormalizerFactory();

        $header = new Useragent(
            $ua,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
            $browserLoader,
            $platformLoader,
            $engineLoader,
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
     * @throws Exception
     */
    public function testDataWithVersions(): void
    {
        $ua          = 'Mozilla/5.0 (Linux; Android 7.0; B1-7A0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36';
        $deviceKey   = 'test-device-key';
        $platformKey = 'test-platform-key';
        $clientKey   = 'test-client-key';
        $engineKey   = 'test-engine-key';

        $browserVersion  = '1.2';
        $platformVersion = '2.4';
        $engineVersion   = '4.8';

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
            ->willReturn([['version' => $browserVersion]]);

        $platformLoader = $this->createMock(PlatformLoaderInterface::class);
        $platformLoader
            ->expects(self::once())
            ->method('load')
            ->with($platformKey, $ua)
            ->willReturn(['version' => $platformVersion]);

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineKey, $ua)
            ->willReturn(['version' => $engineVersion]);

        $normalizerFactory = new NormalizerFactory();

        $header = new Useragent(
            $ua,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
            $browserLoader,
            $platformLoader,
            $engineLoader,
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
     * @throws Exception
     */
    public function testDataWithClientParserException(): void
    {
        $ua          = 'Mozilla/5.0 (Linux; Android 7.0; B1-7A0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36';
        $deviceKey   = 'test-device-key';
        $platformKey = 'test-platform-key';
        $engineKey   = 'test-engine-key';

        $platformVersion = '2.4';
        $engineVersion   = '4.8';

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
            ->willReturn(['version' => $platformVersion]);

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineKey, $ua)
            ->willReturn(['version' => $engineVersion]);

        $normalizerFactory = new NormalizerFactory();

        $header = new Useragent(
            $ua,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
            $browserLoader,
            $platformLoader,
            $engineLoader,
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
     * @throws Exception
     */
    public function testDataWithClientParserException2(): void
    {
        $ua          = 'Mozilla/5.0 (Linux; Android 7.0; B1-7A0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36';
        $deviceKey   = 'test-device-key';
        $platformKey = 'test-platform-key';
        $engineKey   = 'test-engine-key';

        $platformVersion = '2.4';
        $engineVersion   = '4.8';

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
            ->willReturn(['version' => $platformVersion]);

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineKey, $ua)
            ->willReturn(['version' => $engineVersion]);

        $normalizerFactory = new NormalizerFactory();

        $header = new Useragent(
            $ua,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
            $browserLoader,
            $platformLoader,
            $engineLoader,
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
     * @throws Exception
     */
    public function testDataWithClientParserException3(): void
    {
        $ua          = 'Mozilla/5.0 (Linux; Android 7.0; B1-7A0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/537.36';
        $deviceKey   = 'test-device-key';
        $platformKey = 'test-platform-key';
        $engineKey   = 'test-engine-key';

        $platformVersion = '2.4';
        $engineVersion   = '4.8';

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
            ->willReturn(['version' => $platformVersion]);

        $engineLoader = $this->createMock(EngineLoaderInterface::class);
        $engineLoader
            ->expects(self::once())
            ->method('load')
            ->with($engineKey, $ua)
            ->willReturn(['version' => $engineVersion]);

        $normalizerFactory = new NormalizerFactory();

        $header = new Useragent(
            $ua,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
            $browserLoader,
            $platformLoader,
            $engineLoader,
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
     * @throws Exception
     */
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

        $header = new Useragent(
            $ua,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
            $browserLoader,
            $platformLoader,
            $engineLoader,
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
     * @throws Exception
     */
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

        $header = new Useragent(
            $ua,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
            $browserLoader,
            $platformLoader,
            $engineLoader,
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
