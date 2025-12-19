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

use BrowserDetector\Parser\Header\SecChUaClientCode;
use BrowserDetector\Parser\Header\SecChUaClientVersion;
use BrowserDetector\Version\ForcedNullVersion;
use BrowserDetector\Version\NullVersion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaRequest\Exception\NotFoundException;
use UaRequest\Header\ClientHeader;
use UaResult\Bits\Bits;
use UaResult\Device\Architecture;
use UnexpectedValueException;

use function sprintf;

#[CoversClass(SecChUaClientCode::class)]
#[CoversClass(SecChUaClientVersion::class)]
final class SecChUaTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws UnexpectedValueException
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    #[DataProvider('providerUa')]
    public function testData(
        string $ua,
        bool $hasClientCode,
        string | null $clientCode,
        bool $hasClientVersion,
        string | null $clientVersion,
    ): void {
        $header = new ClientHeader(
            value: $ua,
            clientCode: new SecChUaClientCode(),
            clientVersion: new SecChUaClientVersion(),
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
        self::assertFalse($header->hasDeviceCode(), sprintf('device info mismatch for ua "%s"', $ua));
        self::assertNull(
            $header->getDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasClientCode,
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

        self::assertFalse(
            $header->hasPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );

        try {
            $header->getPlatformCode();

            self::fail('Exception expected');
        } catch (NotFoundException) {
            // do nothing
        }

        self::assertFalse(
            $header->hasPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertInstanceOf(
            NullVersion::class,
            $header->getPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertFalse($header->hasEngineCode(), sprintf('engine info mismatch for ua "%s"', $ua));

        try {
            $header->getEngineCode();

            self::fail('Exception expected');
        } catch (NotFoundException) {
            // do nothing
        }

        self::assertFalse(
            $header->hasEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertInstanceOf(
            NullVersion::class,
            $header->getEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
    }

    /**
     * @return array<int, array<int, bool|string|null>>
     *
     * @throws void
     */
    public static function providerUa(): array
    {
        return [
            ['" Not A;Brand";v="99", "Chromium";v="99", "Google Chrome";v="99"', true, 'chrome', true, '99.0.0'],
            ['" Not A;Brand";v="99", "Chromium";v="101"', false, null, false, null],
            ['" Not A;Brand";v="99", "Chromium";v="102", "Microsoft Edge";v="102"', true, 'edge', true, '102.0.0'],
            ['" Not A;Brand";v="99", "Chromium";v="101", "Opera";v="101"', true, 'opera', true, '101.0.0'],
            ['" Not A;Brand";v="99", "Chromium";v="100", "Yandex";v="22"', true, 'yabrowser', true, '22.0.0'],
            ['""', false, null, false, null],
            ['";Not A Brand";v="99", "Opera";v="80", "OperaMobile";v="66", "Chromium";v="94"', true, 'opera mobile', true, '66.0.0'],
            ['" Not A;Brand";v="99", "Chromium";v="100", "Atom";v="22"', true, 'atom', true, '22.0.0'],
            ['" Not A;Brand";v="99", "Chromium";v="99", "HuaweiBrowser";v="99"', true, 'huawei-browser', true, '99.0.0'],
            ['"Chromium";v="108", "Opera GX";v="94", "Not)A;Brand";v="99"', true, 'opera gx', true, '94.0.0'],
            ['"Chromium";v="110", "Not A(Brand";v="24", "Avast Secure Browser";v="110"', true, 'avast secure browser', true, '110.0.0'],
            ['"Avast Secure Browser";v="110", "Chromium";v="110", "Not A(Brand";v="24"', true, 'avast secure browser', true, '110.0.0'],
            ['" Not A;Brand";v="99", "Chromium";v="100", "CCleaner Browser";v="100"', true, 'ccleaner browser', true, '100.0.0'],
            ['"CCleaner Browser";v="100", " Not A;Brand";v="99", "Chromium";v="100"', true, 'ccleaner browser', true, '100.0.0'],
            ['"AvastSecureBrowser";v="6.6.0", " Not A;Brand";v="99.0.0.0", "Chromium";v="98.0.4758.101"', true, 'avast secure browser', true, '6.6.0'],
            ['"WaveBrowser";v="112", "WaveBrowser";v="112", "Not:A-Brand";v="99"', true, 'wave-browser', true, '112.0.0'],
            ['"Opera";v="86", ";Not A Brand";v="99", "Chromium";v="100", "OperaMobile";v="69"', true, 'opera mobile', true, '69.0.0'],
            ['"Chromium";v="124", "Android WebView";v="124", "Not-A.Brand";v="99"', true, 'android webview', true, '124.0.0'],
            ['"Android WebView";v="124", "Chromium";v="124", "Not-A.Brand";v="99"', true, 'android webview', true, '124.0.0'],
            ['"Chromium";v="130", "Brave";v="130", "Not?A_Brand";v="99"', true, 'brave', true, '130.0.0'],
            ['"Brave";v="130", "Chromium";v="130", "Not?A_Brand";v="99"', true, 'brave', true, '130.0.0'],
            ['"DuckDuckGo";v="119", "Chromium";v="119", "Not?A_Brand";v="24"', true, 'duckduck app', true, '119.0.0'],
            ['"Not/A)Brand";v="8", "Chromium";v="126", "Android WebView";v="126"', true, 'android webview', true, '126.0.0'],
            ['"Not/A)Brand";v="99", "Samsung Internet";v="23.0", "Chromium";v="115"', true, 'samsungbrowser', true, '23.0.0'],
            ['"Not/A)Brand";v="99.0.0.0", "Norton Secure Browser";v="115.0.21984.175", "Chromium";v="115.0.21984.175"', true, 'norton-secure-browser', true, '115.0.21984.175'],
            ['"Microsoft Edge";v="111", "Not(A:Brand";v="8", "Chromium";v="111", "Microsoft Edge WebView2";v="111"', true, 'edge webview', true, '111.0.0'],
            ['"Not/A)Brand";v="8", "Chromium";v="126", "HeadlessChrome";v="126"', true, 'headless-chrome', true, '126.0.0'],
            ['"Not/A)Brand";v="8", "Chromium";v="126", "YaBrowser";v="24.7", "Yowser";v="2.5"', true, 'yowser', true, '2.5.0'],
            ['"Not/A)Brand";v="8", "Chromium";v="126", "Norton Private Browser";v="126"', true, 'norton-secure-browser', true, '126.0.0'],
            ['"Not/A)Brand";v="8", "Chromium";v="126", "Vivaldi";v="6.8"', true, 'vivaldi', true, '6.8.0'],
            ['"Not/A)Brand";v="8", "Chromium";v="126", "AVG Secure Browser";v="126"', true, 'avg secure browser', true, '126.0.0'],
            ['"AVG Secure Browser";v="126", "Not/A)Brand";v="8", "Chromium";v="126"', true, 'avg secure browser', true, '126.0.0'],
            ['"Not/A)Brand";v="8", "Chromium";v="126", "YaBrowser";v="24.7"', true, 'yabrowser', true, '24.7.0'],
            ['"Not/A)Brand";v="8", "Chromium";v="126", "Android WebView";v="126"', true, 'android webview', true, '126.0.0'],
            ['"Not/A)Brand";v="8"', false, null, false, null],
            ['"Chromium";v="106", "Brave Browser";v="106", "Not;A=Brand";v="99"', true, 'brave', true, '106.0.0'],
            ['"Brave Browser";v="106", "Chromium";v="106", "Not;A=Brand";v="99"', true, 'brave', true, '106.0.0'],
            ['https://www.crazyfuturetech.com/', false, null, false, null],
            ['"Not.A/Brand";v="8", "Chromium";v="114", "Avira Secure Browser";v="114"', true, 'avira-secure-browser', true, '114.0.0'],
            ['"Avira Secure Browser";v="114", "Not.A/Brand";v="8", "Chromium";v="114"', true, 'avira-secure-browser', true, '114.0.0'],
            ['"Chromium";v="96", " Not A;Brand";v="99", "Whale";v="2"', true, 'whale browser', true, '2.0.0'],
            ['"Not_A Brand";v="8", "Chromium";v="120", "Oculus Browser";v="31"', true, 'oculus-browser', true, '31.0.0'],
            ['" Not;A Brand";v="99", "CocCoc";v="97", "Chromium";v="97"', true, 'coc_coc_browser', true, '97.0.0'],
            ['" Not A;Brand";v="99.0.0.0", "Chromium";v="99.0.4844.16", "Opera Crypto";v="99.0.4844.16"', true, 'opera-crypto', true, '99.0.4844.16'],
            ['" Not A;Brand";v="99.0.0.0", "Chromium";v="98.0.4758.109", "Gener8";v="98.0.4758.109"', true, 'gener8-browser', true, '98.0.4758.109'],
            ['"Not.A/Brand";v="8", "Chromium";v="94", "CrowBrowser";v="94"', true, 'crow-browser', true, '94.0.0'],
            ['"Not_A Brand";v="8", "Chromium";v="120", "Vewd Core";v="4.24"', true, 'vewd-core', true, '4.24.0'],
            ['"Not_A Brand";v="8", "Chromium";v="120", "Microsoft Edge";v="120", "Edge Side Panel";v="120"', true, 'edge-side-panel', true, '120.0.0'],
            ['"Not_A Brand";v="8", "Edge Side Panel";v="120", "Chromium";v="120", "Microsoft Edge";v="120"', true, 'edge-side-panel', true, '120.0.0'],
            ['"Not)A;Brand";v="99", "HeadlessEdg";v="127", "Chromium";v="127"', true, 'headless-edge', true, '127.0.0'],
            ['"Chromium";v="118", "Wavebox";v="118", "Not=A?Brand";v="99"', true, 'wavebox-browser', true, '118.0.0'],
            ['"Not)A;Brand";v="24", "Total Browser";v="116"', true, 'total-browser', true, '116.0.0'],
            ['"Version"; v="14.1.2", "Safari"; v="605.1.15", "Chromium"; v="Not A;Brand", "Not;A Brand"; v="99"', true, 'safari', true, '14.1.2'],
            ['"Opera Air";v="121", "Chromium";v="137", "Not/A)Brand";v="24"', true, 'opera-air', true, '121.0.0'],
            ['"Opera Mini Android";v="95", "Chromium";v="137", "Not/A)Brand";v="24"', true, 'opera mini', true, '95.0.0'],
            ['"Chromium";v="142", "Island";v="142", "Not_A Brand";v="99"', true, 'the-enterprise-browser', true, '142.0.0'],
            ['"Opera Mini Android";v="95", "Chromium";v="140", "Not=A?Brand";v="24", "Android WebView";v="140"', true, 'opera mini', true, '95.0.0'],
        ];
    }
}
