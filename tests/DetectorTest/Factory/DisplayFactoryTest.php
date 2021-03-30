<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Factory;

use AssertionError;
use BrowserDetector\Factory\DisplayFactory;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use UaResult\Device\DisplayInterface;

use function assert;

final class DisplayFactoryTest extends TestCase
{
    public function testFromEmptyArray(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::never())
            ->method('debug');
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

        $object = new DisplayFactory();

        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage('"width" property is required');

        assert($logger instanceof LoggerInterface);
        $object->fromArray($logger, []);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function testFromArray(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::never())
            ->method('debug');
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

        $width  = 1280;
        $height = 1920;

        $object = new DisplayFactory();

        $size  = 12.1;
        $touch = true;

        assert($logger instanceof LoggerInterface);
        $result = $object->fromArray($logger, ['width' => $width, 'height' => $height, 'touch' => $touch, 'size' => $size]);

        self::assertInstanceOf(DisplayInterface::class, $result);
        self::assertSame($width, $result->getWidth());
        self::assertSame($height, $result->getHeight());
        self::assertTrue($result->hasTouch());
        self::assertSame($size, $result->getSize());

        self::assertIsArray($result->toArray());
        self::assertArrayHasKey('width', $result->toArray());
        self::assertArrayHasKey('height', $result->toArray());
        self::assertArrayHasKey('touch', $result->toArray());
        self::assertArrayHasKey('size', $result->toArray());

        self::assertSame($width, $result->toArray()['width']);
        self::assertSame($height, $result->toArray()['height']);
        self::assertTrue($result->toArray()['touch']);
        self::assertSame($size, $result->toArray()['size']);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function testFromArrayWithIntSize(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::never())
            ->method('debug');
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

        $width  = 1280;
        $height = 1920;

        $object = new DisplayFactory();

        $size  = 12;
        $touch = true;

        assert($logger instanceof LoggerInterface);
        $result = $object->fromArray($logger, ['width' => $width, 'height' => $height, 'touch' => $touch, 'size' => $size]);

        self::assertInstanceOf(DisplayInterface::class, $result);
        self::assertSame($width, $result->getWidth());
        self::assertSame($height, $result->getHeight());
        self::assertTrue($result->hasTouch());
        self::assertSame((float) $size, $result->getSize());

        self::assertIsArray($result->toArray());
        self::assertArrayHasKey('width', $result->toArray());
        self::assertArrayHasKey('height', $result->toArray());
        self::assertArrayHasKey('touch', $result->toArray());
        self::assertArrayHasKey('size', $result->toArray());

        self::assertSame($width, $result->toArray()['width']);
        self::assertSame($height, $result->toArray()['height']);
        self::assertTrue($result->toArray()['touch']);
        self::assertSame((float) $size, $result->toArray()['size']);
    }
}
