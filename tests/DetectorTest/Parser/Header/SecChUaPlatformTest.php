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

#[CoversClass(className: SecChUaPlatform::class)]
#[CoversClass(className: SecChUaPlatformDevice::class)]
final class SecChUaPlatformTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NotFoundException
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    #[DataProvider(methodName: 'providerUa')]
    public function testData(
        string $ua,
        bool $hasPlatform,
        Os $os,
        bool $hasDeviceCode,
        string | null $deviceCode,
    ): void {
        $secChUaPlatformHeader = new SecChUaPlatformHeader(
            value: $ua,
            platformCode: new SecChUaPlatform(),
            deviceCode: new SecChUaPlatformDevice(),
        );

        self::assertSame(
            $ua,
            $secChUaPlatformHeader->getValue(),
            sprintf('value mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $ua,
            $secChUaPlatformHeader->getNormalizedValue(),
            sprintf('value mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $secChUaPlatformHeader->hasDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            Architecture::unknown,
            $secChUaPlatformHeader->getDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $secChUaPlatformHeader->hasDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            Bits::unknown,
            $secChUaPlatformHeader->getDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $secChUaPlatformHeader->hasDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $secChUaPlatformHeader->getDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasDeviceCode,
            $secChUaPlatformHeader->hasDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $deviceCode,
            $secChUaPlatformHeader->getDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $secChUaPlatformHeader->hasClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $secChUaPlatformHeader->getClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $secChUaPlatformHeader->hasClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertInstanceOf(
            NullVersion::class,
            $secChUaPlatformHeader->getClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasPlatform,
            $secChUaPlatformHeader->hasPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $os,
            $secChUaPlatformHeader->getPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $secChUaPlatformHeader->hasPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertInstanceOf(
            NullVersion::class,
            $secChUaPlatformHeader->getPlatformVersionWithOs(Os::unknown),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $secChUaPlatformHeader->hasEngineCode(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );

        try {
            $secChUaPlatformHeader->getEngineCode();

            self::fail('Exception expected');
        } catch (NotFoundException) {
            // do nothing
        }

        self::assertFalse(
            $secChUaPlatformHeader->hasEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertInstanceOf(
            NullVersion::class,
            $secChUaPlatformHeader->getEngineVersionWithEngine(Engine::unknown),
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
            ['"Windows"', true, Os::windows, false, 'unknown=windows desktop'],
            ['"Chrome OS"', true, Os::chromeos, false, null],
            ['"Linux"', true, Os::linux, false, null],
            ['"ChromeOS"', true, Os::chromeos, false, null],
            ['"macOS"', true, Os::macosx, false, 'apple=macintosh'],
            ['"Chromium OS"', true, Os::chromeos, false, null],
            ['"Unknown"', false, Os::unknown, false, null],
            ['"Win32"', true, Os::windows, false, 'unknown=windows desktop'],
            ['"Mac OS X"', true, Os::macosx, false, null],
            ['\"Windows\"', true, Os::windows, false, 'unknown=windows desktop'],
            ['Lindows', true, Os::lindows, false, null],
            ['\'Linux\'', true, Os::linux, false, null],
            ['\'Linux x86_64\'', true, Os::linux, false, null],
            ['"MacIntel"', true, Os::macosx, false, null],
            ['"Fuchsia"', true, Os::fuchsia, false, null],
            ['""', false, Os::unknown, false, null],
            ['Cloud Phone 2.4', true, Os::puffinOs, false, null],
            ['OpenBSD', true, Os::openbsd, false, null],
            ['FreeBSD', true, Os::freebsd, false, null],
            ['Ios', true, Os::ios, false, null],
            ['ChromiumOS', true, Os::chromeos, false, null],
            ['Ubuntu', true, Os::ubuntu, false, null],
        ];
    }

    /**
     * @throws ExpectationFailedException
     * @throws NotFoundException
     */
    public function testHeaderWithDerivate(): void
    {
        $secChUaPlatformHeader = new SecChUaPlatformHeader(
            value: '"Android"',
            platformCode: new SecChUaPlatform(),
            deviceCode: new SecChUaPlatformDevice(),
        );

        self::assertSame(
            Os::harmonyos,
            $secChUaPlatformHeader->getPlatformCode('HarmonyOS'),
        );
    }

    /**
     * @throws ExpectationFailedException
     * @throws NotFoundException
     */
    public function testHeaderWithDerivate2(): void
    {
        $secChUaPlatformHeader = new SecChUaPlatformHeader(
            value: '"Android"',
            platformCode: new SecChUaPlatform(),
            deviceCode: new SecChUaPlatformDevice(),
        );

        self::assertSame(
            Os::android,
            $secChUaPlatformHeader->getPlatformCode('x'),
        );
    }
}
