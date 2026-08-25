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
use BrowserDetector\Parser\Header\XDeviceUseragent;
use BrowserDetector\Version\NullVersion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\NormalizerFactory;
use UaParser\DeviceParserInterface;
use UaRequest\Exception\NotFoundException;
use UaRequest\Header\DeviceCodeOnlyHeader;
use UaResult\Bits\Bits;
use UaResult\Device\Architecture;

use function sprintf;

#[CoversClass(className: XDeviceUseragent::class)]
final class XDeviceUseragent1Test extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \PHPUnit\Framework\Exception
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    #[DataProvider(methodName: 'providerUa')]
    public function testData(string $ua, bool $hasDeviceInfo, string $deviceCode): void
    {
        $isNull = false;

        if ($deviceCode === '') {
            $isNull = true;
        }

        $normalizerFactory = new NormalizerFactory();
        $normalizerChain   = $normalizerFactory->build();

        $normalitedUa = $normalizerChain->normalize($ua);

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::once())
            ->method('parse')
            ->with($normalitedUa)
            ->willReturn($deviceCode);

        $deviceCodeOnlyHeader = new DeviceCodeOnlyHeader(
            value: $ua,
            deviceCode: new XDeviceUseragent(
                deviceParser: $deviceParser,
                normalizer: $normalizerChain,
            ),
        );

        self::assertSame(
            $ua,
            $deviceCodeOnlyHeader->getValue(),
            sprintf('value mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $ua,
            $deviceCodeOnlyHeader->getNormalizedValue(),
            sprintf('value mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $deviceCodeOnlyHeader->hasDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            Architecture::unknown,
            $deviceCodeOnlyHeader->getDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $deviceCodeOnlyHeader->hasDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            Bits::unknown,
            $deviceCodeOnlyHeader->getDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $deviceCodeOnlyHeader->hasDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $deviceCodeOnlyHeader->getDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasDeviceInfo,
            $deviceCodeOnlyHeader->hasDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $isNull ? null : $deviceCode,
            $deviceCodeOnlyHeader->getDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $deviceCodeOnlyHeader->hasClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $deviceCodeOnlyHeader->getClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $deviceCodeOnlyHeader->hasClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertInstanceOf(
            NullVersion::class,
            $deviceCodeOnlyHeader->getClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $deviceCodeOnlyHeader->hasPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );

        try {
            $deviceCodeOnlyHeader->getPlatformCode();

            self::fail('Exception expected');
        } catch (NotFoundException) {
            // do nothing
        }

        self::assertFalse(
            $deviceCodeOnlyHeader->hasPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertInstanceOf(
            NullVersion::class,
            $deviceCodeOnlyHeader->getPlatformVersionWithOs(Os::unknown),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $deviceCodeOnlyHeader->hasEngineCode(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );

        try {
            $deviceCodeOnlyHeader->getEngineCode();

            self::fail('Exception expected');
        } catch (NotFoundException) {
            // do nothing
        }

        self::assertFalse(
            $deviceCodeOnlyHeader->hasEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertInstanceOf(
            NullVersion::class,
            $deviceCodeOnlyHeader->getEngineVersionWithEngine(Engine::unknown),
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
            ['Nokia6288/2.0 (05.94) Profile/MIDP-2.0 Configuration/CLDC-1.1', true, ''],
            ['Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420.1 (KHTML, like Gecko) Version/3.0 Mobile/4A93 Safari/419.3', true, 'iPhone'],
        ];
    }
}
