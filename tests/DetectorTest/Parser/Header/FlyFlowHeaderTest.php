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
use BrowserDetector\Parser\Header\BaiduFlyflow;
use BrowserDetector\Version\NullVersion;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaParser\DeviceParserInterface;
use UaRequest\Exception\NotFoundException;
use UaRequest\Header\DeviceCodeOnlyHeader;
use UaResult\Bits\Bits;
use UaResult\Device\Architecture;

use function preg_match;
use function sprintf;

#[CoversClass(BaiduFlyflow::class)]
final class FlyFlowHeaderTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    #[DataProvider('providerUa')]
    public function testData(string $ua, bool $hasDeviceInfo, string $deviceCode): void
    {
        $searchCode = false;
        $isNull     = false;

        if (!preg_match('/;htc;htc;/i', $ua)) {
            $searchCode = true;
        }

        if (!$searchCode || $deviceCode === '') {
            $isNull = true;
        }

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects($searchCode ? self::once() : self::never())
            ->method('parse')
            ->with($ua)
            ->willReturn($deviceCode);

        $header = new DeviceCodeOnlyHeader(
            value: $ua,
            deviceCode: new BaiduFlyflow(deviceParser: $deviceParser),
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

        self::assertFalse(
            $header->hasPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertInstanceOf(
            NullVersion::class,
            $header->getPlatformVersionWithOs(Os::unknown),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
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
     * @return array<int, array<int, bool|string>>
     *
     * @throws void
     */
    public static function providerUa(): array
    {
        return [
            ['Microsoft Windows NT 8.10.14219.0;4.0.30508.0;HUAWEI;HUAWEI W2-U00;4a1b5d7105057f0c0208d83c699276ff92cedbff;2.5.0.12', true, 'W2-U00'],
            ['Microsoft Windows NT 8.10.14219.0;4.0.30508.0;NOKIA;RM-997_apac_prc_906;e7477c026c2d2dab09d667a0d502a19faf960316;2.5.0.12', true, 'RM-997_apac_prc_906'],
            ['Microsoft Windows CE 7.10.8862;3.7.11140.0;HTC;HTC;f96cbdcb5bb37bb7bea3fdf0443f9c24ccc92597;1.0.3.3', false, ''],
            ['Microsoft Windows CE 8.10.14219.0;4.0.30508.0;NOKIA;RM-941_eu_belarus_russia_215;d0be80b1a6380df0429cef6d36f56a9b318115fe;1.0.3.3', true, 'RM-941_eu_belarus_russia_215'],
            ['Microsoft Windows NT 8.0.10512.0;4.0.50829.0;NOKIA;RM-822_apac_prc_204;ca23bc5b9a1777612837b43014640b3cce62fc50;2.5.0.12', true, 'RM-822_apac_prc_204'],
            ['Microsoft Windows NT 8.0.10521.0;4.0.50829.0;NOKIA;RM-821_apac_hong_kong_234;03988de8b2eab0b1cadee6ec115612692262e40d;2.5.0.12', true, ''],
            ['Microsoft Windows NT 8.0.10327.0;4.0.50829.0;HTC;A620e;cadbcd6ff7d136b26075066cd7e9b382f0f6e896;2.5.0.12', true, 'A620e'],
        ];
    }
}
