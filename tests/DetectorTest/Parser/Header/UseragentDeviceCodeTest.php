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
use BrowserDetector\Parser\Header\UseragentDeviceCode;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use UaNormalizer\Normalizer\NormalizerInterface;
use UaParser\DeviceParserInterface;

use function mb_strtolower;

#[CoversClass(className: UseragentDeviceCode::class)]
final class UseragentDeviceCodeTest extends TestCase
{
    /** @throws Exception */
    #[DataProvider(methodName: 'providerUa1')]
    public function testWithUasWithoutDeviceCode(string $value, string $expected): void
    {
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

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::never())
            ->method('parse');

        $mappingFileParser = $this->createMock(MappingfileLoaderInterface::class);
        $mappingFileParser
            ->expects(self::never())
            ->method('init');
        $mappingFileParser
            ->expects(self::never())
            ->method('getItem');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $useragentDeviceCode = new UseragentDeviceCode(
            deviceParser: $deviceParser,
            normalizer: $normalizer,
            mappingFileParser: $mappingFileParser,
            logger: $logger,
            autoUpdate: false,
        );

        self::assertTrue($useragentDeviceCode->hasDeviceCode($value));
        self::assertSame(
            $expected,
            $useragentDeviceCode->getDeviceCode($value),
        );
    }

    /**
     * @return array<int, array<int, string>>
     *
     * @throws void
     */
    public static function providerUa1(): array
    {
        return [
            ['WhatsApp/2.2587.9 A', 'unknown=general mobile phone'],
            ['WhatsApp/2.2587.9 W', 'unknown=windows desktop'],
            ['WhatsApp/2.2587.9 i', 'apple=general apple device'],
            ['WhatsApp/2.2587.9 N', 'apple=macintosh'],
            ['WhatsApp/2.2587.9/i', 'apple=general apple device'],
        ];
    }

    /** @throws Exception */
    public function testWithUas2(): void
    {
        $value = 'WhatsApp/2.2587.9 A';

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

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::never())
            ->method('parse');

        $mappingFileParser = $this->createMock(MappingfileLoaderInterface::class);
        $mappingFileParser
            ->expects(self::never())
            ->method('init');
        $mappingFileParser
            ->expects(self::never())
            ->method('getItem');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn('');

        $useragentDeviceCode = new UseragentDeviceCode(
            deviceParser: $deviceParser,
            normalizer: $normalizer,
            mappingFileParser: $mappingFileParser,
            logger: $logger,
            autoUpdate: false,
        );

        self::assertTrue($useragentDeviceCode->hasDeviceCode($value));
        self::assertNull(
            $useragentDeviceCode->getDeviceCode($value),
        );
    }

    /** @throws Exception */
    public function testWithUas3(): void
    {
        $value = 'WhatsApp/2.2587.9 A';

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

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::never())
            ->method('parse');

        $mappingFileParser = $this->createMock(MappingfileLoaderInterface::class);
        $mappingFileParser
            ->expects(self::never())
            ->method('init');
        $mappingFileParser
            ->expects(self::never())
            ->method('getItem');

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willThrowException(new \UaNormalizer\Normalizer\Exception\Exception('x'));

        $useragentDeviceCode = new UseragentDeviceCode(
            deviceParser: $deviceParser,
            normalizer: $normalizer,
            mappingFileParser: $mappingFileParser,
            logger: $logger,
            autoUpdate: false,
        );

        self::assertTrue($useragentDeviceCode->hasDeviceCode($value));
        self::assertNull(
            $useragentDeviceCode->getDeviceCode($value),
        );
    }

    /** @throws Exception */
    public function testWithUas4(): void
    {
        $value = 'A/8.1.0/ANS/L51/msm8909/unknown/QCX3/l3584062258010650401/-/+490760838/-/ANS/110712/110713/-/2.5/1/W';

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

        $deviceParser = $this->createMock(DeviceParserInterface::class);
        $deviceParser
            ->expects(self::once())
            ->method('parse')
            ->with($value)
            ->willReturn('');

        $mappingFileParser = $this->createMock(MappingfileLoaderInterface::class);
        $mappingFileParser
            ->expects(self::once())
            ->method('init');
        $mappingFileParser
            ->expects(self::once())
            ->method('getItem')
            ->with(mb_strtolower($value))
            ->willReturn(value: null);

        $normalizer = $this->createMock(NormalizerInterface::class);
        $normalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($value)
            ->willReturn($value);

        $useragentDeviceCode = new UseragentDeviceCode(
            deviceParser: $deviceParser,
            normalizer: $normalizer,
            mappingFileParser: $mappingFileParser,
            logger: $logger,
            autoUpdate: false,
        );

        self::assertTrue($useragentDeviceCode->hasDeviceCode($value));
        self::assertNull(
            $useragentDeviceCode->getDeviceCode($value),
        );
    }
}
