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
use BrowserDetector\Parser\Header\SecChUaPlatform;
use BrowserDetector\Parser\Header\SecChUaPlatformDevice;
use BrowserDetector\Version\NullVersion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaRequest\Exception\NotFoundException;
use UaRequest\Header\SecChUaPlatformHeader;
use UaResult\Bits\Bits;
use UaResult\Device\Architecture;

use function sprintf;

#[CoversClass(SecChUaPlatform::class)]
final class SecChUaPlatformTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     */
    #[DataProvider('providerUa')]
    public function testData(
        string $ua,
        bool $hasPlatform,
        Os $platform,
        bool $hasDeviceCode,
        string | null $deviceCode,
    ): void {
        $header = new SecChUaPlatformHeader(
            value: $ua,
            platformCode: new SecChUaPlatform(),
            deviceCode: new SecChUaPlatformDevice(),
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
            $hasDeviceCode,
            $header->hasDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $deviceCode,
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
            $header->getPlatformVersionWithOs(Os::unknown),
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
            $header->getEngineVersionWithEngine(Engine::unknown),
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
            ['Android', true, Os::android, false, null],
            ['"Android"', true, Os::android, false, null],
            ['"Windows"', true, Os::windows, true, 'unknown=windows desktop'],
            ['"Chrome OS"', true, Os::chromeos, false, null],
            ['"Linux"', true, Os::linux, false, null],
            ['"ChromeOS"', true, Os::chromeos, false, null],
            ['"macOS"', true, Os::macosx, false, null],
            ['"Chromium OS"', true, Os::chromeos, false, null],
            ['"Unknown"', false, Os::unknown, false, null],
            ['"Win32"', true, Os::windows, true, 'unknown=windows desktop'],
            ['"Mac OS X"', true, Os::macosx, false, null],
            ['\"Windows\"', true, Os::windows, true, 'unknown=windows desktop'],
            ['Lindows', true, Os::lindows, false, null],
            ['\'Linux\'', true, Os::linux, false, null],
            ['\'Linux x86_64\'', true, Os::linux, false, null],
            ['"MacIntel"', true, Os::macosx, false, null],
            ['"Fuchsia"', true, Os::fuchsia, false, null],
            ['""', false, Os::unknown, false, null],
        ];
    }

    /**
     * @throws ExpectationFailedException
     * @throws NotFoundException
     */
    public function testHeaderWithDerivate(): void
    {
        $header = new SecChUaPlatformHeader(
            value: '"Android"',
            platformCode: new SecChUaPlatform(),
            deviceCode: new SecChUaPlatformDevice(),
        );

        self::assertSame(
            Os::harmonyos,
            $header->getPlatformCode('HarmonyOS'),
        );
    }

    /**
     * @throws ExpectationFailedException
     * @throws NotFoundException
     */
    public function testHeaderWithDerivate2(): void
    {
        $header = new SecChUaPlatformHeader(
            value: '"Android"',
            platformCode: new SecChUaPlatform(),
            deviceCode: new SecChUaPlatformDevice(),
        );

        self::assertSame(
            Os::android,
            $header->getPlatformCode('x'),
        );
    }
}
