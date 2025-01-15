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

use BrowserDetector\Parser\Header\XPuffinUaDeviceCode;
use BrowserDetector\Parser\Header\XPuffinUaPlatformCode;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaRequest\Header\XPuffinUa;

use function sprintf;

final class XPuffinUaTest extends TestCase
{
    /** @throws ExpectationFailedException */
    #[DataProvider('providerUa')]
    public function testData(
        string $ua,
        bool $hasDeviceInfo,
        string | null $deviceInfo,
        bool $hasPlatformInfo,
        string | null $platformCode,
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
        self::assertNull(
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
        self::assertNull(
            $header->getPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertFalse($header->hasEngineCode(), sprintf('engine info mismatch for ua "%s"', $ua));
        self::assertNull(
            $header->getEngineCode(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
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
            ['iPhone OS/iPad4,1/1536x2048', true, 'apple=apple ipad 4,1', true, 'ios'],
            ['Android/D6503/1080x1776', true, 'sony=sony d6503', true, 'android'],
            ['Android/SM-G900F/1080x1920', true, 'samsung=samsung sm-g900f', true, 'android'],
            ['Android/Nexus 10/1600x2464', true, 'google=google nexus 10', true, 'android'],
            ['Android/SAMSUNG-SM-N910A/1440x2560', true, 'samsung=samsung sm-n910a', true, 'android'],
            ['Android/bq Edison/1280x752', true, 'bq=bq edison', true, 'android'],
            ['iPhone OS/iPhone6,1/320x568', true, 'apple=apple iphone 6,1', true, 'ios'],
            ['Android/LenovoA3300-HV/600x976', true, 'lenovo=lenovo a3300-hv', true, 'android'],
            ['Android/SM-T310/1280x800', true, 'samsung=samsung sm-t310', true, 'android'],
            ['iPhone OS/iPhone7,1/1242x2208', true, 'apple=apple iphone 7,1', true, 'ios'],
            ['iPhone OS/iPad4,1/1024x768', true, 'apple=apple ipad 4,1', true, 'ios'],
            ['iPhone OS/iPhone 3GS/320x480', true, 'apple=apple iphone 2,1', true, 'ios'],
            ['fake OS/iPhone 3GS/320x480', false, null, false, null],
            ['iPhone OS/x/320x480', true, null, true, 'ios'],
        ];
    }
}
