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

use BrowserDetector\Parser\Header\XOperaminiPhone;
use BrowserDetector\Version\NullVersion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaRequest\Exception\NotFoundException;
use UaRequest\Header\DeviceCodeOnlyHeader;
use UaResult\Bits\Bits;
use UaResult\Device\Architecture;

use function sprintf;

#[CoversClass(XOperaminiPhone::class)]
final class XOperaminiPhoneTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    #[DataProvider('providerUa')]
    public function testData(string $ua, bool $hasDeviceInfo, string | null $deviceCode): void
    {
        $header = new DeviceCodeOnlyHeader(
            value: $ua,
            deviceCode: new XOperaminiPhone(),
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
        self::assertFalse(
            $header->hasPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );

        try {
            $header->getPlatformCode();

            $this->fail('Exception expected');
        } catch (NotFoundException) {
            // do nothing
        }

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

            $this->fail('Exception expected');
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
     * @return array<int, array<int, bool|string|null>>
     *
     * @throws void
     */
    public static function providerUa(): array
    {
        return [
            ['RIM # BlackBerry 8520', true, 'rim=blackberry 8520'],
            ['Samsung # GT-S8500', true, 'samsung=samsung gt-s8500'],
            ['Samsung # GT-i8000', true, 'samsung=samsung gt-i8000'],
            ['RIM # BlackBerry 8900', true, 'rim=blackberry 8900'],
            ['HTC # Touch Pro/T7272/TyTn III', true, 'htc=htc t7272'],
            ['Android #', false, null],
            ['? # ?', false, null],
            ['BlackBerry # 9700', true, 'rim=blackberry 9700'],
            ['Blackberry # 9300', true, 'rim=blackberry 9300'],
            ['Samsung # SCH-U380', true, 'samsung=samsung sch-u380'],
            ['Pantech # TXT8045', true, 'pantech=pantech txt8045'],
            ['ZTE # F-450', true, 'zte=zte f-450'],
            ['LG # VN271', true, 'lg=lg vn271'],
            ['Casio # C781', true, 'casio=casio c781'],
            ['Samsung # SCH-U485', true, 'samsung=samsung sch-u485'],
            ['Pantech # CDM8992', true, 'pantech=pantech cdm8992'],
            ['LG # VN530', true, 'lg=lg vn530'],
            ['Samsung # SCH-U680', true, 'samsung=samsung sch-u680'],
            ['Pantech # CDM8999', true, 'pantech=pantech cdm8999'],
            ['Apple # iPhone', true, 'apple=apple iphone'],
            ['Motorola # A1000', true, 'motorola=motorola a1000'],
            ['HTC # HD2', true, 'htc=htc t8585'],
            [' HTC # HD2', false, null],
            ['HTC # HD2 ', true, null],
        ];
    }
}
