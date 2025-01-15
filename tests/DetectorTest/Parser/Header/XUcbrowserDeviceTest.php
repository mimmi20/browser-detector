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

use BrowserDetector\Parser\Header\XUcbrowserDevice;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\NormalizerFactory;
use UaParser\DeviceParserInterface;
use UaRequest\Header\DeviceCodeOnlyHeader;

use function in_array;
use function mb_strtolower;
use function sprintf;

final class XUcbrowserDeviceTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    #[DataProvider('providerUa')]
    public function testData(string $ua, bool $hasDeviceInfo, string $deviceCode): void
    {
        $searchCode = true;
        $isNull     = false;

        if (in_array(mb_strtolower($ua), ['j2me', 'opera', 'jblend'], true)) {
            $searchCode = false;
        }

        if (!$searchCode || $deviceCode === '') {
            $isNull = true;
        }

        $normalizerFactory = new NormalizerFactory();
        $normalizer        = $normalizerFactory->build();

        $normalitedUa = $normalizer->normalize($ua);

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(!$searchCode ? self::never() : self::once())
            ->method('parse')
            ->with($normalitedUa)
            ->willReturn($deviceCode);

        $header = new DeviceCodeOnlyHeader(
            value: $ua,
            deviceCode: new XUcbrowserDevice(
                deviceParser: $deviceParser,
                normalizerFactory: $normalizerFactory,
            ),
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
        self::assertSame(
            !$isNull ? $deviceCode : null,
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
            ['nokia#200', true, '200'],
            ['nokia#C2-01', true, 'C2-01'],
            ['samsung#-GT-C3312', true, 'GT-C3312'],
            ['j2me', false, ''],
            ['nokia#501', true, '501'],
            ['nokia#C7-00', true, 'C7-00'],
            ['samsung#-GT-S3850', true, 'GT-S3850'],
            ['samsung#-GT-S5250', true, 'GT-S5250'],
            ['samsung#-GT-S8600', true, 'GT-S8600'],
            ['NOKIA # 6120c', true, '6120c'],
            ['Nokia # E7-00', true, 'E7-00'],
            ['Jblend', false, ''],
            ['nokia#501s', true, '501s'],
            ['nokia#503s', true, '503s'],
            ['nokia#Asha230DualSIM', true, ''],
            ['samsung#-gt-s5380d', true, 'gt-s5380d'],
            ['samsung#-GT-S5380K', true, 'GT-S5380K'],
            ['samsung#-GT-S5253', true, 'GT-S5253'],
            ['tcl#-C616', true, 'C616'],
            ['maui e800', true, 'e800'],
            ['Opera', false, ''],
        ];
    }
}
