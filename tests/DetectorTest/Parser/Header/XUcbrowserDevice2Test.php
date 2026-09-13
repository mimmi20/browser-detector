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

use BrowserDetector\Loader\MappingfileLoaderInterface;
use BrowserDetector\Parser\Header\XUcbrowserDevice;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use UaNormalizer\Normalizer\Exception\Exception;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\DeviceParserInterface;

#[CoversClass(className: XUcbrowserDevice::class)]
final class XUcbrowserDevice2Test extends TestCase
{
    /** @throws \PHPUnit\Framework\Exception */
    public function testGetDeviceCodeWithNormalizerException(): void
    {
        $value     = 'test-value';
        $exception = new Exception('test');

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::never())
            ->method('parse');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willThrowException($exception);

        $mappingFileParser = $this->createMock(MappingfileLoaderInterface::class);
        $mappingFileParser
            ->expects(self::never())
            ->method('init');
        $mappingFileParser
            ->expects(self::never())
            ->method('getItem');

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

        $xUcbrowserDevice = new XUcbrowserDevice(
            deviceParser: $deviceParser,
            normalizer: $normalizer,
            mappingFileParser: $mappingFileParser,
            logger: $logger,
            autoUpdate: false,
        );

        self::assertNull($xUcbrowserDevice->getDeviceCode($value));
    }

    /** @throws \PHPUnit\Framework\Exception */
    public function testGetDeviceCode(): void
    {
        $value = 'test-value';

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::never())
            ->method('parse');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn(value: null);

        $mappingFileParser = $this->createMock(MappingfileLoaderInterface::class);
        $mappingFileParser
            ->expects(self::never())
            ->method('init');
        $mappingFileParser
            ->expects(self::never())
            ->method('getItem');

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

        $xUcbrowserDevice = new XUcbrowserDevice(
            deviceParser: $deviceParser,
            normalizer: $normalizer,
            mappingFileParser: $mappingFileParser,
            logger: $logger,
            autoUpdate: false,
        );

        self::assertNull($xUcbrowserDevice->getDeviceCode($value));
    }

    /** @throws \PHPUnit\Framework\Exception */
    public function testGetDeviceCode2(): void
    {
        $value = 'test-value';

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::never())
            ->method('parse');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn('');

        $mappingFileParser = $this->createMock(MappingfileLoaderInterface::class);
        $mappingFileParser
            ->expects(self::never())
            ->method('init');
        $mappingFileParser
            ->expects(self::never())
            ->method('getItem');

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

        $xUcbrowserDevice = new XUcbrowserDevice(
            deviceParser: $deviceParser,
            normalizer: $normalizer,
            mappingFileParser: $mappingFileParser,
            logger: $logger,
            autoUpdate: false,
        );

        self::assertNull($xUcbrowserDevice->getDeviceCode($value));
    }
}
