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

use BrowserDetector\Header\XOperaminiPhone;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

use function sprintf;

final class XOperaminiPhoneTest extends TestCase
{
    /** @throws ExpectationFailedException */
    #[DataProvider('providerUa')]
    public function testData(string $ua, bool $hasDeviceInfo): void
    {
        $header = new XOperaminiPhone($ua);

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
        self::assertFalse(
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
            ['RIM # BlackBerry 8520', true],
            ['Samsung # GT-S8500', true],
            ['Samsung # GT-i8000', true],
            ['RIM # BlackBerry 8900', true],
            ['HTC # Touch Pro/T7272/TyTn III', true],
            ['Android #', false],
            ['? # ?', false],
            ['BlackBerry # 9700', true],
            ['Blackberry # 9300', true],
            ['Samsung # SCH-U380', true],
            ['Pantech # TXT8045', true],
            ['ZTE # F-450', true],
            ['LG # VN271', true],
            ['Casio # C781', true],
            ['Samsung # SCH-U485', true],
            ['Pantech # CDM8992', true],
            ['LG # VN530', true],
            ['Samsung # SCH-U680', true],
            ['Pantech # CDM8999', true],
            ['Apple # iPhone', true],
            ['Motorola # A1000', true],
            ['HTC # HD2', true],
        ];
    }
}
