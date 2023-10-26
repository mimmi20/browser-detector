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

use BrowserDetector\Header\SecChUa;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

use function sprintf;

final class SecChUaTest extends TestCase
{
    /** @throws ExpectationFailedException */
    #[DataProvider('providerUa')]
    public function testData(
        string $ua,
        bool $hasClientCode,
        string | null $clientCode,
        bool $hasClientVersion,
        string | null $clientVersion,
    ): void {
        $header = new SecChUa($ua);

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
        self::assertFalse($header->hasDeviceCode(), sprintf('device info mismatch for ua "%s"', $ua));
        self::assertNull(
            $header->getDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasClientCode,
            $header->hasClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $clientCode,
            $header->getClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasClientVersion,
            $header->hasClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $clientVersion,
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
     * @return array<int, array<int, bool|string|null>>
     *
     * @throws void
     */
    public static function providerUa(): array
    {
        return [
            ['" Not A;Brand";v="99", "Chromium";v="99", "Google Chrome";v="99"', true, 'chrome', true, '99'],
            ['" Not A;Brand";v="99", "Chromium";v="101"', false, null, false, null],
            ['" Not A;Brand";v="99", "Chromium";v="102", "Microsoft Edge";v="102"', true, 'edge mobile', true, '102'],
            ['" Not A;Brand";v="99", "Chromium";v="101", "Opera";v="101"', true, 'opera', true, '101'],
            ['" Not A;Brand";v="99", "Chromium";v="100", "Yandex";v="22"', true, 'yabrowser', true, '22'],
            ['""', false, null, false, null],
            ['";Not A Brand";v="99", "Opera";v="80", "OperaMobile";v="66", "Chromium";v="94""', true, 'opera mobile', true, '66'],
            ['" Not A;Brand";v="99", "Chromium";v="100", "Atom";v="22"', true, 'atom', true, '22'],
            ['" Not A;Brand";v="99", "Chromium";v="99", "HuaweiBrowser";v="99"', true, 'huawei-browser', true, '99'],
            ['"Chromium";v="108", "Opera GX";v="94", "Not)A;Brand";v="99"', true, 'opera gx', true, '94'],
            ['"Chromium";v="110", "Not A(Brand";v="24", "Avast Secure Browser";v="110"', true, 'avast secure browser', true, '110'],
            ['" Not A;Brand";v="99", "Chromium";v="100", "CCleaner Browser";v="100"', true, 'ccleaner browser', true, '100'],
        ];
    }
}
