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
use BrowserDetector\Parser\Header\Exception\VersionContainsDerivateException;
use BrowserDetector\Parser\Header\SecChUaPlatformVersion;
use BrowserDetector\Version\ForcedNullVersion;
use BrowserDetector\Version\NullVersion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaRequest\Exception\NotFoundException;
use UaRequest\Header\PlatformVersionOnlyHeader;
use UaResult\Bits\Bits;
use UaResult\Device\Architecture;
use UnexpectedValueException;

use function sprintf;

#[CoversClass(SecChUaPlatformVersion::class)]
final class SecChUaPlatformVersionTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws UnexpectedValueException
     */
    #[DataProvider('providerUa')]
    public function testData(string $ua, string | null $code, bool $hasVersion, string | null $version): void
    {
        $header = new PlatformVersionOnlyHeader(
            value: $ua,
            platformVersion: new SecChUaPlatformVersion(),
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
        self::assertFalse(
            $header->hasPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );

        try {
            $header->getPlatformCode();

            self::fail('Exception expected');
        } catch (NotFoundException) {
            // do nothing
        }

        self::assertSame(
            $hasVersion,
            $header->hasPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );

        if ($version === null) {
            self::assertInstanceOf(
                ForcedNullVersion::class,
                $header->getPlatformVersionWithOs(Os::unknown),
                sprintf('platform info mismatch for ua "%s"', $ua),
            );
        } else {
            self::assertSame(
                $version,
                $header->getPlatformVersionWithOs(
                    Os::fromName((string) $code),
                )->getVersion(),
                sprintf('platform info mismatch for ua "%s"', $ua),
            );
        }

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
     * @return array<int, array<int, bool|string|null>>
     *
     * @throws void
     */
    public static function providerUa(): array
    {
        return [
            ['9.0.0', 'Android', true, '9.0.0'],
            ['10.0.0', 'Android', true, '10.0.0'],
            ['11.0.0', 'Android', true, '11.0.0'],
            ['12.0.0', 'Android', true, '12.0.0'],
            ['16.0.0', null, true, '16.0.0'],
            ['11.0.0', null, true, '11.0.0'],
            ['"11.0.0"', null, true, '11.0.0'],
            ['"14.0.0"', 'Windows', true, '11.0.0'],
            ['"11.0.0"', 'Windows', true, '11.0.0'],
            ['"10.0.0"', 'Windows', true, '10.0.0'],
            ['"8.0.0"', 'Windows', true, '10.0.0'],
            ['"0.3"', 'Windows', true, '8.1.0'],
            ['"0.2"', 'Windows', true, '8.0.0'],
            ['"0.1"', 'Windows', true, '7.0.0'],
            ['""', null, false, null],
            ['"14_5"', null, true, '14.5.0'],
        ];
    }

    /** @throws ExpectationFailedException */
    public function testHeaderWithDerivate(): void
    {
        $header = new PlatformVersionOnlyHeader(
            value: '"9; HarmonyOS"',
            platformVersion: new SecChUaPlatformVersion(),
        );

        try {
            $header->getPlatformVersionWithOs(Os::android);

            self::fail('Exception expected');
        } catch (VersionContainsDerivateException $e) {
            self::assertSame('', $e->getMessage());
            self::assertSame(0, $e->getCode());
            self::assertNull($e->getPrevious());

            self::assertSame('HarmonyOS', $e->getDerivate());
        }
    }

    /** @throws ExpectationFailedException */
    public function testHeaderWithDerivate2(): void
    {
        $header = new PlatformVersionOnlyHeader(
            value: '"9;HarmonyOS"',
            platformVersion: new SecChUaPlatformVersion(),
        );

        try {
            $header->getPlatformVersionWithOs(Os::android);

            self::fail('Exception expected');
        } catch (VersionContainsDerivateException $e) {
            self::assertSame('', $e->getMessage());
            self::assertSame(0, $e->getCode());
            self::assertNull($e->getPrevious());

            self::assertSame('HarmonyOS', $e->getDerivate());
        }
    }
}
