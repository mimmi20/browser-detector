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

use BrowserDetector\Parser\Header\SecChUaPlatform;
use BrowserDetector\Version\NullVersion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaRequest\Header\PlatformCodeOnlyHeader;
use UaResult\Bits\Bits;
use UaResult\Device\Architecture;

use function sprintf;

#[CoversClass(SecChUaPlatform::class)]
final class SecChUaPlatformTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    #[DataProvider('providerUa')]
    public function testData(string $ua, bool $hasPlatform, string | null $platform): void
    {
        $header = new PlatformCodeOnlyHeader(
            value: $ua,
            platformCode: new SecChUaPlatform(),
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
            $hasPlatform,
            $header->hasPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $platform,
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
        self::assertNull(
            $header->getEngineCode(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
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
            ['Android', true, 'android'],
            ['"Android"', true, 'android'],
            ['"Windows"', true, 'windows'],
            ['"Chrome OS"', true, 'chromeos'],
            ['"Linux"', true, 'linux'],
            ['"ChromeOS"', true, 'chromeos'],
            ['"macOS"', true, 'mac os x'],
            ['"Chromium OS"', true, 'chromeos'],
            ['"Unknown"', false, null],
            ['"Win32"', true, 'windows'],
            ['"Mac OS X"', true, 'mac os x'],
            ['\"Windows\"', true, 'windows'],
            ['Lindows', true, 'lindows'],
            ['\'Linux\'', true, 'linux'],
            ['\'Linux x86_64\'', true, 'linux'],
            ['"MacIntel"', true, 'mac os x'],
            ['""', false, null],
        ];
    }

    /** @throws ExpectationFailedException */
    public function testHeaderWithDerivate(): void
    {
        $header = new PlatformCodeOnlyHeader(
            value: '"Android"',
            platformCode: new SecChUaPlatform(),
        );

        self::assertSame(
            'harmony-os',
            $header->getPlatformCode('HarmonyOS'),
        );
    }

    /** @throws ExpectationFailedException */
    public function testHeaderWithDerivate2(): void
    {
        $header = new PlatformCodeOnlyHeader(
            value: '"Android"',
            platformCode: new SecChUaPlatform(),
        );

        self::assertSame(
            'android',
            $header->getPlatformCode('x'),
        );
    }
}
