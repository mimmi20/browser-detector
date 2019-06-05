<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
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

final class DisplayFactoryTest extends TestCase
{
    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     *
     * @return void
     */
    public function testFromEmptyArray(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('debug');
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        $type = $this->getMockBuilder(DisplayTypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $type
            ->expects(static::never())
            ->method('getType');

        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(static::once())
            ->method('loadByDiemsions')
            ->with(null, null)
            ->willReturn($type);

        /** @var TypeLoader $typeLoader */
        $object = new DisplayFactory($typeLoader);

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray($logger, []);

        static::assertInstanceOf(DisplayInterface::class, $result);
        static::assertNull($result->hasTouch());
        static::assertNull($result->getSize());
        static::assertInstanceOf(DisplayTypeInterface::class, $result->getType());
        static::assertSame($type, $result->getType());

        static::assertIsArray($result->toArray());
        static::assertArrayHasKey('width', $result->toArray());
        static::assertArrayHasKey('height', $result->toArray());
        static::assertArrayHasKey('touch', $result->toArray());
        static::assertArrayHasKey('size', $result->toArray());

        static::assertNull($result->toArray()['width']);
        static::assertNull($result->toArray()['height']);
        static::assertNull($result->toArray()['touch']);
        static::assertNull($result->toArray()['size']);
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     *
     * @return void
     */
    public function testFromArray(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('debug');
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        $width  = 1280;
        $height = 1920;

        $type = $this->getMockBuilder(DisplayTypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $type
            ->expects(static::never())
            ->method('getType');
        $type
            ->expects(static::exactly(10))
            ->method('getHeight')
            ->willReturn($height);
        $type
            ->expects(static::exactly(10))
            ->method('getWidth')
            ->willReturn($width);

        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(static::once())
            ->method('loadByDiemsions')
            ->with($height, $width)
            ->willReturn($type);

        /** @var TypeLoader $typeLoader */
        $object = new DisplayFactory($typeLoader);

        $size  = 12.1;
        $touch = true;

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray($logger, ['width' => $width, 'height' => $height, 'touch' => $touch, 'size' => $size]);

        static::assertInstanceOf(DisplayInterface::class, $result);
        static::assertSame($width, $result->getType()->getWidth());
        static::assertSame($height, $result->getType()->getHeight());
        static::assertTrue($result->hasTouch());
        static::assertSame($size, $result->getSize());

        $resultType = $result->getType();

        static::assertInstanceOf(DisplayTypeInterface::class, $resultType);
        static::assertSame($type, $resultType);

        static::assertIsArray($result->toArray());
        static::assertArrayHasKey('width', $result->toArray());
        static::assertArrayHasKey('height', $result->toArray());
        static::assertArrayHasKey('touch', $result->toArray());
        static::assertArrayHasKey('size', $result->toArray());

        static::assertSame($width, $result->toArray()['width']);
        static::assertSame($height, $result->toArray()['height']);
        static::assertTrue($result->toArray()['touch']);
        static::assertSame($size, $result->toArray()['size']);
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     *
     * @return void
     */
    public function testFromArrayWithTypeFailed(): void
    {
        $exception = new NotFoundException('fail');
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('debug');
        $logger
            ->expects(static::once())
            ->method('info')
            ->with($exception);
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        $width  = 1280;
        $height = 1920;

        $type = $this->getMockBuilder(DisplayTypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $type
            ->expects(static::never())
            ->method('getType');
        $type
            ->expects(static::never())
            ->method('getHeight');
        $type
            ->expects(static::never())
            ->method('getWidth');

        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(static::once())
            ->method('loadByDiemsions')
            ->with($height, $width)
            ->willThrowException($exception);

        /** @var TypeLoader $typeLoader */
        $object = new DisplayFactory($typeLoader);

        $size  = 12.1;
        $touch = true;

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray($logger, ['width' => $width, 'height' => $height, 'touch' => $touch, 'size' => $size]);

        static::assertInstanceOf(DisplayInterface::class, $result);
        static::assertNull($result->getType()->getWidth());
        static::assertNull($result->getType()->getHeight());
        static::assertTrue($result->hasTouch());
        static::assertSame($size, $result->getSize());

        $resultType = $result->getType();

        static::assertInstanceOf(DisplayTypeInterface::class, $resultType);
        static::assertNotSame($type, $resultType);

        static::assertIsArray($result->toArray());
        static::assertArrayHasKey('width', $result->toArray());
        static::assertArrayHasKey('height', $result->toArray());
        static::assertArrayHasKey('touch', $result->toArray());
        static::assertArrayHasKey('size', $result->toArray());

        static::assertNull($result->toArray()['width']);
        static::assertNull($result->toArray()['height']);
        static::assertTrue($result->toArray()['touch']);
        static::assertSame($size, $result->toArray()['size']);
    }
}
