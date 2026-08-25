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
use BrowserDetector\Parser\Header\SetVersionTrait;
use BrowserDetector\Version\ForcedNullVersion;
use BrowserDetector\Version\NullVersion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversTrait;
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

#[CoversClass(className: SecChUaPlatformVersion::class)]
#[CoversTrait(traitName: SetVersionTrait::class)]
final class SecChUaPlatformVersionTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws UnexpectedValueException
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    #[DataProvider(methodName: 'providerUa')]
    public function testData(string $ua, string | null $code, bool $hasVersion, string | null $version): void
    {
        $platformVersionOnlyHeader = new PlatformVersionOnlyHeader(
            value: $ua,
            platformVersion: new SecChUaPlatformVersion(),
        );

        self::assertSame(
            $ua,
            $platformVersionOnlyHeader->getValue(),
            sprintf('value mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $ua,
            $platformVersionOnlyHeader->getNormalizedValue(),
            sprintf('value mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $platformVersionOnlyHeader->hasDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            Architecture::unknown,
            $platformVersionOnlyHeader->getDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $platformVersionOnlyHeader->hasDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            Bits::unknown,
            $platformVersionOnlyHeader->getDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $platformVersionOnlyHeader->hasDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $platformVersionOnlyHeader->getDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $platformVersionOnlyHeader->hasDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $platformVersionOnlyHeader->getDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $platformVersionOnlyHeader->hasClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $platformVersionOnlyHeader->getClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $platformVersionOnlyHeader->hasClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertInstanceOf(
            NullVersion::class,
            $platformVersionOnlyHeader->getClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $platformVersionOnlyHeader->hasPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );

        try {
            $platformVersionOnlyHeader->getPlatformCode();

            self::fail('Exception expected');
        } catch (NotFoundException) {
            // do nothing
        }

        self::assertSame(
            $hasVersion,
            $platformVersionOnlyHeader->hasPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );

        if ($version === null) {
            self::assertInstanceOf(
                ForcedNullVersion::class,
                $platformVersionOnlyHeader->getPlatformVersionWithOs(Os::unknown),
                sprintf('platform info mismatch for ua "%s"', $ua),
            );
        } else {
            self::assertSame(
                $version,
                $platformVersionOnlyHeader->getPlatformVersionWithOs(
                    Os::fromName((string) $code),
                )->getVersion(),
                sprintf('platform info mismatch for ua "%s"', $ua),
            );
        }

        self::assertFalse(
            $platformVersionOnlyHeader->hasEngineCode(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );

        try {
            $platformVersionOnlyHeader->getEngineCode();

            self::fail('Exception expected');
        } catch (NotFoundException) {
            // do nothing
        }

        self::assertFalse(
            $platformVersionOnlyHeader->hasEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertInstanceOf(
            NullVersion::class,
            $platformVersionOnlyHeader->getEngineVersionWithEngine(Engine::unknown),
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
            ['"7.0.0"', 'Windows', true, '10.0.0'],
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
        $platformVersionOnlyHeader = new PlatformVersionOnlyHeader(
            value: '"9; HarmonyOS"',
            platformVersion: new SecChUaPlatformVersion(),
        );

        try {
            $platformVersionOnlyHeader->getPlatformVersionWithOs(Os::android);

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
        $platformVersionOnlyHeader = new PlatformVersionOnlyHeader(
            value: '"9;HarmonyOS"',
            platformVersion: new SecChUaPlatformVersion(),
        );

        try {
            $platformVersionOnlyHeader->getPlatformVersionWithOs(Os::android);

            self::fail('Exception expected');
        } catch (VersionContainsDerivateException $e) {
            self::assertSame('', $e->getMessage());
            self::assertSame(0, $e->getCode());
            self::assertNull($e->getPrevious());

            self::assertSame('HarmonyOS', $e->getDerivate());
        }
    }
}
