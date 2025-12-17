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
use BrowserDetector\Parser\Header\SecChUaPlatform;
use BrowserDetector\Version\NullVersion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaRequest\Exception\NotFoundException;
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
     * @throws NotFoundException
     */
    #[DataProvider('providerUa')]
    public function testData(string $ua, bool $hasPlatform, Os $platform): void
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
     * @return list<list<bool|Os|string>>
     *
     * @throws void
     */
    public static function providerUa(): array
    {
        return [
            ['Android', true, Os::android],
            ['"Android"', true, Os::android],
            ['"Windows"', true, Os::windows],
            ['"Chrome OS"', true, Os::chromeos],
            ['"Linux"', true, Os::linux],
            ['"ChromeOS"', true, Os::chromeos],
            ['"macOS"', true, Os::macosx],
            ['"Chromium OS"', true, Os::chromeos],
            ['"Unknown"', false, Os::unknown],
            ['"Win32"', true, Os::windows],
            ['"Mac OS X"', true, Os::macosx],
            ['\"Windows\"', true, Os::windows],
            ['Lindows', true, Os::lindows],
            ['\'Linux\'', true, Os::linux],
            ['\'Linux x86_64\'', true, Os::linux],
            ['"MacIntel"', true, Os::macosx],
            ['"Fuchsia"', true, Os::fuchsia],
            ['""', false, Os::unknown],
        ];
    }

    /**
     * @throws ExpectationFailedException
     * @throws NotFoundException
     */
    public function testHeaderWithDerivate(): void
    {
        $header = new PlatformCodeOnlyHeader(
            value: '"Android"',
            platformCode: new SecChUaPlatform(),
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
        $header = new PlatformCodeOnlyHeader(
            value: '"Android"',
            platformCode: new SecChUaPlatform(),
        );

        self::assertSame(
            Os::android,
            $header->getPlatformCode('x'),
        );
    }
}
