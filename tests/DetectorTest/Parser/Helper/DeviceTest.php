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

namespace BrowserDetectorTest\Parser\Helper;

use BrowserDetector\Loader\MappingfileLoaderInterface;
use BrowserDetector\Parser\Helper\Device;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

use function sprintf;

/** @phpcs:disable SlevomatCodingStandard.Classes.ClassLength.ClassTooLong */
#[CoversClass(className: Device::class)]
final class DeviceTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws RuntimeException
     */
    public function testGetDeviceCodeFound(): void
    {
        $code  = 'lm-g710';
        $model = 'lg=lg lm-g710';

        $mappingFileParser = $this->createMock(MappingfileLoaderInterface::class);
        $mappingFileParser
            ->expects(self::once())
            ->method('init');
        $mappingFileParser
            ->expects(self::once())
            ->method('getItem')
            ->with($code)
            ->willReturn($model);

        $device = new Device($mappingFileParser);

        self::assertSame(
            $model,
            $device->getDeviceCode($code),
            sprintf('device info mismatch for ua "%s"', $code),
        );
    }

    /**
     * @throws ExpectationFailedException
     * @throws RuntimeException
     */
    public function testGetDeviceCodeNotFound(): void
    {
        $code = 'xxx';

        $mappingFileParser = $this->createMock(MappingfileLoaderInterface::class);
        $mappingFileParser
            ->expects(self::once())
            ->method('init');
        $mappingFileParser
            ->expects(self::once())
            ->method('getItem')
            ->with($code)
            ->willReturn(value: null);

        $device = new Device($mappingFileParser);

        self::assertNull(
            $device->getDeviceCode($code),
            sprintf('device info mismatch for ua "%s"', $code),
        );
    }
}
