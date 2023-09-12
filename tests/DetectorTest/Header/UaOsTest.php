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

use BrowserDetector\Header\UaOs;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

use function sprintf;

final class UaOsTest extends TestCase
{
    /** @throws ExpectationFailedException */
    #[DataProvider('providerUa')]
    public function testData(string $ua, bool $hasPlatformInfo): void
    {
        $header = new UaOs($ua);

        self::assertSame($ua, $header->getValue(), sprintf('header mismatch for ua "%s"', $ua));
        self::assertFalse($header->hasDeviceCode(), sprintf('device info mismatch for ua "%s"', $ua));
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
        self::assertSame(
            $hasPlatformInfo,
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
            ['Windows CE (Smartphone) - Version 5.2', false],
            ['Windows CE (Pocket PC) - Version 5.2', true],
        ];
    }
}
