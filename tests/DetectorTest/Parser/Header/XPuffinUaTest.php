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

use BrowserDetector\Data\Engine;
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

#[CoversClass(className: XPuffinUaDeviceCode::class)]
#[CoversClass(className: XPuffinUaPlatformCode::class)]
final class XPuffinUaTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     */
    #[DataProvider(methodName: 'providerUa')]
    public function testData(
        string $ua,
        bool $hasDeviceInfo,
        string | null $deviceInfo,
        bool $hasPlatformInfo,
        Os $os,
    ): void {
        $xPuffinUa = new XPuffinUa(
            value: $ua,
            deviceCode: new XPuffinUaDeviceCode(),
            platformCode: new XPuffinUaPlatformCode(),
        );

        self::assertSame($ua, $xPuffinUa->getValue(), sprintf('value mismatch for ua "%s"', $ua));
        self::assertSame(
            $ua,
            $xPuffinUa->getNormalizedValue(),
            sprintf('value mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $xPuffinUa->hasDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            Architecture::unknown,
            $xPuffinUa->getDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $xPuffinUa->hasDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            Bits::unknown,
            $xPuffinUa->getDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $xPuffinUa->hasDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $xPuffinUa->getDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasDeviceInfo,
            $xPuffinUa->hasDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $deviceInfo,
            $xPuffinUa->getDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $xPuffinUa->hasClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $xPuffinUa->getClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $xPuffinUa->hasClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertInstanceOf(
            NullVersion::class,
            $xPuffinUa->getClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasPlatformInfo,
            $xPuffinUa->hasPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $os,
            $xPuffinUa->getPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $xPuffinUa->hasPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertInstanceOf(
            NullVersion::class,
            $xPuffinUa->getPlatformVersionWithOs(Os::unknown),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $xPuffinUa->hasEngineCode(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );

        try {
            $xPuffinUa->getEngineCode();

            self::fail('Exception expected');
        } catch (NotFoundException) {
            // do nothing
        }

        self::assertFalse(
            $xPuffinUa->hasEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertInstanceOf(
            NullVersion::class,
            $xPuffinUa->getEngineVersionWithEngine(Engine::unknown),
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
