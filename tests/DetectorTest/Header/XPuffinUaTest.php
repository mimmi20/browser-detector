<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Header;

use BrowserDetector\Header\XPuffinUa;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

use function sprintf;

final class XPuffinUaTest extends TestCase
{
    /** @throws ExpectationFailedException */
    #[DataProvider('providerUa')]
    public function testData(string $ua, bool $hasDeviceInfo, bool $hasPlatformInfo): void
    {
        $header = new XPuffinUa($ua);

        self::assertSame($ua, $header->getValue(), sprintf('header mismatch for ua "%s"', $ua));
        self::assertSame(
            $hasDeviceInfo,
            $header->hasDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse($header->hasDeviceName(), sprintf('device info mismatch for ua "%s"', $ua));
        self::assertFalse(
            $header->hasDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse($header->hasClientCode(), sprintf('browser info mismatch for ua "%s"', $ua));
        self::assertSame(
            $hasPlatformInfo,
            $header->hasPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertFalse($header->hasEngineCode(), sprintf('engine info mismatch for ua "%s"', $ua));
    }

    /**
     * @return array<int, array<int, bool|string>>
     *
     * @throws void
     */
    public static function providerUa(): array
    {
        return [
            ['iPhone OS/iPad4,1/1536x2048', true, true],
            ['Android/D6503/1080x1776', true, true],
            ['Android/SM-G900F/1080x1920', true, true],
            ['Android/Nexus 10/1600x2464', true, true],
            ['Android/SAMSUNG-SM-N910A/1440x2560', true, true],
            ['Android/bq Edison/1280x752', true, true],
            ['iPhone OS/iPhone6,1/320x568', true, true],
            ['Android/LenovoA3300-HV/600x976', true, true],
            ['Android/SM-T310/1280x800', true, true],
            ['iPhone OS/iPhone7,1/1242x2208', true, true],
            ['iPhone OS/iPad4,1/1024x768', true, true],
            ['iPhone OS/iPhone 3GS/320x480', true, true],
            ['fake OS/iPhone 3GS/320x480', true, false],
        ];
    }
}
