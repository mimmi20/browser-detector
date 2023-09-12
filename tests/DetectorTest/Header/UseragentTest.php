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

use BrowserDetector\Header\Useragent;
use BrowserDetector\Parser\BrowserParserInterface;
use BrowserDetector\Parser\DeviceParserInterface;
use BrowserDetector\Parser\EngineParserInterface;
use BrowserDetector\Parser\PlatformParserInterface;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaNormalizer\Normalizer\Exception;
use UaNormalizer\NormalizerFactory;

use function sprintf;

final class UseragentTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testData(): void
    {
        $ua = 'Windows CE (Smartphone) - Version 5.2';

        $deviceParser      = $this->createMock(DeviceParserInterface::class);
        $platformParser    = $this->createMock(PlatformParserInterface::class);
        $browserParser     = $this->createMock(BrowserParserInterface::class);
        $engineParser      = $this->createMock(EngineParserInterface::class);
        $normalizerFactory = new NormalizerFactory();

        $header = new Useragent(
            $ua,
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
        );

        self::assertSame($ua, $header->getValue(), sprintf('header mismatch for ua "%s"', $ua));
        self::assertTrue($header->hasDeviceCode(), sprintf('device info mismatch for ua "%s"', $ua));
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
        self::assertTrue($header->hasClientCode(), sprintf('browser info mismatch for ua "%s"', $ua));
        self::assertTrue(
            $header->hasPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertTrue(
            $header->hasPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertTrue($header->hasEngineCode(), sprintf('engine info mismatch for ua "%s"', $ua));
    }
}
