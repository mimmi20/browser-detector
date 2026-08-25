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
use BrowserDetector\Parser\Header\UaOsPlatformCode;
use BrowserDetector\Parser\Header\UaOsPlatformVersion;
use BrowserDetector\Version\ForcedNullVersion;
use BrowserDetector\Version\NullVersion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaRequest\Exception\NotFoundException;
use UaRequest\Header\PlatformHeader;
use UaResult\Bits\Bits;
use UaResult\Device\Architecture;
use UnexpectedValueException;

use function sprintf;

#[CoversClass(className: UaOsPlatformCode::class)]
#[CoversClass(className: UaOsPlatformVersion::class)]
final class UaOsTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws UnexpectedValueException
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    #[DataProvider(methodName: 'providerUa')]
    public function testData(
        string $ua,
        bool $hasPlatformInfo,
        Os $os,
        bool $hasPlatformVersion,
        string | null $platformVersion,
    ): void {
        $platformHeader = new PlatformHeader(
            value: $ua,
            platformCode: new UaOsPlatformCode(),
            platformVersion: new UaOsPlatformVersion(),
        );

        self::assertSame($ua, $platformHeader->getValue(), sprintf('value mismatch for ua "%s"', $ua));
        self::assertSame(
            $ua,
            $platformHeader->getNormalizedValue(),
            sprintf('value mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $platformHeader->hasDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            Architecture::unknown,
            $platformHeader->getDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $platformHeader->hasDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            Bits::unknown,
            $platformHeader->getDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $platformHeader->hasDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $platformHeader->getDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $platformHeader->hasDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $platformHeader->getDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $platformHeader->hasClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $platformHeader->getClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $platformHeader->hasClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertInstanceOf(
            NullVersion::class,
            $platformHeader->getClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasPlatformInfo,
            $platformHeader->hasPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $os,
            $platformHeader->getPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasPlatformVersion,
            $platformHeader->hasPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );

        if ($platformVersion === null) {
            self::assertInstanceOf(
                ForcedNullVersion::class,
                $platformHeader->getPlatformVersionWithOs(Os::unknown),
                sprintf('platform info mismatch for ua "%s"', $ua),
            );
        } else {
            self::assertSame(
                $platformVersion,
                $platformHeader->getPlatformVersionWithOs(Os::unknown)->getVersion(),
                sprintf('platform info mismatch for ua "%s"', $ua),
            );
        }

        self::assertFalse(
            $platformHeader->hasEngineCode(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );

        try {
            $platformHeader->getEngineCode();

            self::fail('Exception expected');
        } catch (NotFoundException) {
            // do nothing
        }

        self::assertFalse(
            $platformHeader->hasEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertInstanceOf(
            NullVersion::class,
            $platformHeader->getEngineVersionWithEngine(Engine::unknown),
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
            ['Windows CE (Smartphone) - Version 5.2', false, Os::unknown, false, null],
            ['Windows CE (Pocket PC) - Version 5.2', true, Os::windowsce, true, '5.2.0'],
        ];
    }
}
