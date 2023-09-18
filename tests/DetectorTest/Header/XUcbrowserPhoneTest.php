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

use BrowserDetector\Header\XUcbrowserPhone;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

use function sprintf;

final class XUcbrowserPhoneTest extends TestCase
{
    /** @throws ExpectationFailedException */
    #[DataProvider('providerUa')]
    public function testData(string $ua, bool $hasDeviceInfo, bool $hasBrowserInfo): void
    {
        $header = new XUcbrowserPhone($ua);

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
        self::assertNull(
            $header->getDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasBrowserInfo,
            $header->hasClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
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
        self::assertFalse(
            $header->hasPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
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
     * @return array<int, array<int, bool|string>>
     *
     * @throws void
     */
    public static function providerUa(): array
    {
        return [
            ['maui browser', false, true],
            ['nokia701', true, false],
            ['sunmicro', false, false],
            ['nokiac3-01', true, false],
            ['nokia305', true, false],
            ['gt-s5233s', true, false],
            ['sonyericssonj108i', true, false],
        ];
    }
}
