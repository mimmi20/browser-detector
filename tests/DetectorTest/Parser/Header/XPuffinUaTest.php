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

use BrowserDetector\Data\Os;
use BrowserDetector\Parser\Header\XPuffinUaDeviceCode;
use BrowserDetector\Parser\Header\XPuffinUaPlatformCode;
use BrowserDetector\Version\NullVersion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaRequest\Exception\NotFoundException;
use UaRequest\Header\XPuffinUa;
use UaResult\Bits\Bits;
use UaResult\Device\Architecture;

use function sprintf;

#[CoversClass(XPuffinUaDeviceCode::class)]
#[CoversClass(XPuffinUaPlatformCode::class)]
final class XPuffinUaTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     */
    #[DataProvider('providerUa')]
    public function testData(
        string $ua,
        bool $hasDeviceInfo,
        string | null $deviceInfo,
        bool $hasPlatformInfo,
        Os $platformCode,
    ): void {
        $header = new XPuffinUa(
            value: $ua,
            deviceCode: new XPuffinUaDeviceCode(),
            platformCode: new XPuffinUaPlatformCode(),
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
            $deviceInfo,
            $header->getDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse($header->hasClientCode(), sprintf('browser info mismatch for ua "%s"', $ua));
        self::assertNull(
            $header->getClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertInstanceOf(
            NullVersion::class,
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
     * @return list<list<bool|Os|string|null>>
     *
     * @throws void
     */
    public static function providerUa(): array
    {
        return [
            ['iPhone OS/iPad4,1/1536x2048', true, 'apple=apple ipad 4,1', true, Os::ios],
            ['Android/D6503/1080x1776', true, 'sony=sony d6503', true, Os::android],
            ['Android/SM-G900F/1080x1920', true, 'samsung=samsung sm-g900f', true, Os::android],
            ['Android/Nexus 10/1600x2464', true, 'google=google nexus 10', true, Os::android],
            ['Android/SAMSUNG-SM-N910A/1440x2560', true, 'samsung=samsung sm-n910a', true, Os::android],
            ['Android/bq Edison/1280x752', true, 'bq=bq edison', true, Os::android],
            ['iPhone OS/iPhone6,1/320x568', true, 'apple=apple iphone 6,1', true, Os::ios],
            ['Android/LenovoA3300-HV/600x976', true, 'lenovo=lenovo a3300-hv', true, Os::android],
            ['Android/SM-T310/1280x800', true, 'samsung=samsung sm-t310', true, Os::android],
            ['iPhone OS/iPhone7,1/1242x2208', true, 'apple=apple iphone 7,1', true, Os::ios],
            ['iPhone OS/iPad4,1/1024x768', true, 'apple=apple ipad 4,1', true, Os::ios],
            ['iPhone OS/iPhone 3GS/320x480', true, 'apple=apple iphone 2,1', true, Os::ios],
            ['fake OS/iPhone 3GS/320x480', false, null, false, Os::unknown],
            ['iPhone OS/x/320x480', true, null, true, Os::ios],
        ];
    }
}
