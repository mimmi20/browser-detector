<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Factory;

use BrowserDetector\Factory\DisplayFactory;
use BrowserDetector\Loader\NotFoundException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use UaDisplaySize\DisplayTypeInterface;
use UaDisplaySize\TypeLoader;
use UaDisplaySize\TypeLoaderInterface;
use UaResult\Device\DisplayInterface;

class DisplayFactoryTest extends TestCase
{
    /**
     * @return void
     */
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

        $typeName = 'test-type';
        $type     = $this->getMockBuilder(DisplayTypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $type
            ->expects(self::exactly(11))
            ->method('getType')
            ->willReturn($typeName);

        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with('unknown')
            ->willReturn($type);

        /** @var TypeLoader $typeLoader */
        $object = new DisplayFactory($typeLoader);

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray($logger, []);

        self::assertInstanceOf(DisplayInterface::class, $result);
        self::assertNull($result->getWidth());
        self::assertNull($result->getHeight());
        self::assertNull($result->hasTouch());
        self::assertNull($result->getSize());
        self::assertInstanceOf(DisplayTypeInterface::class, $result->getType());
        self::assertSame($type, $result->getType());

        self::assertIsArray($result->toArray());
        self::assertArrayHasKey('width', $result->toArray());
        self::assertArrayHasKey('height', $result->toArray());
        self::assertArrayHasKey('touch', $result->toArray());
        self::assertArrayHasKey('type', $result->toArray());
        self::assertArrayHasKey('size', $result->toArray());

        self::assertNull($result->toArray()['width']);
        self::assertNull($result->toArray()['height']);
        self::assertNull($result->toArray()['touch']);
        self::assertSame($typeName, $result->toArray()['type']);
        self::assertNull($result->toArray()['size']);
    }

    /**
     * @return void
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

        $typeName = 'test-type';
        $type     = $this->getMockBuilder(DisplayTypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $type
            ->expects(self::exactly(11))
            ->method('getType')
            ->willReturn($typeName);

        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with($typeName)
            ->willReturn($type);

        /** @var TypeLoader $typeLoader */
        $object = new DisplayFactory($typeLoader);

        $width  = 1280;
        $height = 1920;
        $size   = 12.1;
        $touch  = true;

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray($logger, ['width' => $width, 'height' => $height, 'touch' => $touch, 'size' => $size, 'type' => $typeName]);

        self::assertInstanceOf(DisplayInterface::class, $result);
        self::assertSame($width, $result->getWidth());
        self::assertSame($height, $result->getHeight());
        self::assertTrue($result->hasTouch());
        self::assertSame($size, $result->getSize());

        $resultType = $result->getType();

        self::assertInstanceOf(DisplayTypeInterface::class, $resultType);
        self::assertSame($type, $resultType);

        self::assertIsArray($result->toArray());
        self::assertArrayHasKey('width', $result->toArray());
        self::assertArrayHasKey('height', $result->toArray());
        self::assertArrayHasKey('touch', $result->toArray());
        self::assertArrayHasKey('type', $result->toArray());
        self::assertArrayHasKey('size', $result->toArray());

        self::assertSame($width, $result->toArray()['width']);
        self::assertSame($height, $result->toArray()['height']);
        self::assertTrue($result->toArray()['touch']);
        self::assertSame($typeName, $result->toArray()['type']);
        self::assertSame($size, $result->toArray()['size']);
    }

    /**
     * @return void
     */
    public function testFromArrayWithTypeFailed(): void
    {
        $exception = new NotFoundException('fail');
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::never())
            ->method('debug');
        $logger
            ->expects(self::once())
            ->method('info')
            ->with($exception);
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

        $typeName = 'test-type';
        $type     = $this->getMockBuilder(DisplayTypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $type
            ->expects(self::never())
            ->method('getType')
            ->willReturn($typeName);

        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('load')
            ->with($typeName)
            ->willThrowException($exception);

        /** @var TypeLoader $typeLoader */
        $object = new DisplayFactory($typeLoader);

        $width  = 1280;
        $height = 1920;
        $size   = 12.1;
        $touch  = true;

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray($logger, ['width' => $width, 'height' => $height, 'touch' => $touch, 'size' => $size, 'type' => $typeName]);

        self::assertInstanceOf(DisplayInterface::class, $result);
        self::assertSame($width, $result->getWidth());
        self::assertSame($height, $result->getHeight());
        self::assertTrue($result->hasTouch());
        self::assertSame($size, $result->getSize());

        $resultType = $result->getType();

        self::assertInstanceOf(DisplayTypeInterface::class, $resultType);
        self::assertNotSame($type, $resultType);

        self::assertIsArray($result->toArray());
        self::assertArrayHasKey('width', $result->toArray());
        self::assertArrayHasKey('height', $result->toArray());
        self::assertArrayHasKey('touch', $result->toArray());
        self::assertArrayHasKey('type', $result->toArray());
        self::assertArrayHasKey('size', $result->toArray());

        self::assertSame($width, $result->toArray()['width']);
        self::assertSame($height, $result->toArray()['height']);
        self::assertTrue($result->toArray()['touch']);
        self::assertSame('unknown', $result->toArray()['type']);
        self::assertSame($size, $result->toArray()['size']);
    }
}
