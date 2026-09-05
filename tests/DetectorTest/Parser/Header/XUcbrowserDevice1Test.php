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
use BrowserDetector\Parser\Header\XUcbrowserDevice;
use BrowserDetector\Parser\Helper\DeviceInterface;
use BrowserDetector\Version\NullVersion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\NormalizerFactory;
use UaParser\DeviceParserInterface;
use UaRequest\Exception\NotFoundException;
use UaRequest\Header\DeviceCodeOnlyHeader;
use UaResult\Bits\Bits;
use UaResult\Device\Architecture;

use function in_array;
use function mb_strtolower;
use function sprintf;

#[CoversClass(className: XUcbrowserDevice::class)]
final class XUcbrowserDevice1Test extends TestCase
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
        $searchCode = true;
        $isNull     = false;

        if (in_array(mb_strtolower($ua), ['j2me', 'opera', 'jblend'], strict: true)) {
            $searchCode = false;
        }

        if (!$searchCode || $deviceCode === '') {
            $isNull = true;
        }

        $normalizerFactory = new NormalizerFactory();
        $normalizerChain   = $normalizerFactory->build();

        $normalitedUa = $normalizerChain->normalize($ua);

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects($searchCode ? self::once() : self::never())
            ->method('parse')
            ->with($normalitedUa)
            ->willReturn($deviceCode);

        $deviceCodeHelper = $this->createMock(DeviceInterface::class);
        $deviceCodeHelper
            ->expects($searchCode ? self::once() : self::never())
            ->method('getDeviceCode')
            ->with(mb_strtolower($normalitedUa))
            ->willReturn(value: null);

        $logger = $this->createMock(LoggerInterface::class);
        $logger
            ->expects(self::never())
            ->method('info');
        $logger
            ->expects(self::never())
            ->method('notice');
        $logger
            ->expects(self::never())
            ->method('warning');
        $logger
            ->expects(self::never())
            ->method('error');
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        $deviceCodeOnlyHeader = new DeviceCodeOnlyHeader(
            value: $ua,
            deviceCode: new XUcbrowserDevice(
                deviceParser: $deviceParser,
                normalizer: $normalizerChain,
                device: $deviceCodeHelper,
                logger: $logger,
                autoUpdate: false,
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
