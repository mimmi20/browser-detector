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

        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::never())
            ->method('loadByDiemsions');

        /** @var TypeLoader $typeLoader */
        $object = new DisplayFactory($typeLoader);

        $this->expectException(\AssertionError::class);
        $this->expectExceptionMessage('"width" property is required');

        /* @var \Psr\Log\LoggerInterface $logger */
        $object->fromArray($logger, []);
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

        $type = $this->getMockBuilder(DisplayTypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $type
            ->expects(self::never())
            ->method('getType');
        $type
            ->expects(self::exactly(10))
            ->method('getHeight')
            ->willReturn($height);
        $type
            ->expects(self::exactly(10))
            ->method('getWidth')
            ->willReturn($width);

        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('loadByDiemsions')
            ->with($height, $width)
            ->willReturn($type);

        /** @var TypeLoader $typeLoader */
        $object = new DisplayFactory($typeLoader);

        $size  = 12.1;
        $touch = true;

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray($logger, ['width' => $width, 'height' => $height, 'touch' => $touch, 'size' => $size]);

        self::assertInstanceOf(DisplayInterface::class, $result);
        self::assertSame($width, $result->getType()->getWidth());
        self::assertSame($height, $result->getType()->getHeight());
        self::assertTrue($result->hasTouch());
        self::assertSame($size, $result->getSize());

        $resultType = $result->getType();

        self::assertInstanceOf(DisplayTypeInterface::class, $resultType);
        self::assertSame($type, $resultType);

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

        $width  = 1280;
        $height = 1920;

        $type = $this->getMockBuilder(DisplayTypeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $type
            ->expects(self::never())
            ->method('getType');
        $type
            ->expects(self::never())
            ->method('getHeight');
        $type
            ->expects(self::never())
            ->method('getWidth');

        $typeLoader = $this->getMockBuilder(TypeLoaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $typeLoader
            ->expects(self::once())
            ->method('loadByDiemsions')
            ->with($height, $width)
            ->willThrowException($exception);

        /** @var TypeLoader $typeLoader */
        $object = new DisplayFactory($typeLoader);

        $size  = 12.1;
        $touch = true;

        /** @var \Psr\Log\LoggerInterface $logger */
        $result = $object->fromArray($logger, ['width' => $width, 'height' => $height, 'touch' => $touch, 'size' => $size]);

        self::assertInstanceOf(DisplayInterface::class, $result);
        self::assertNull($result->getType()->getWidth());
        self::assertNull($result->getType()->getHeight());
        self::assertTrue($result->hasTouch());
        self::assertSame($size, $result->getSize());

        $resultType = $result->getType();

        self::assertInstanceOf(DisplayTypeInterface::class, $resultType);
        self::assertNotSame($type, $resultType);

        self::assertIsArray($result->toArray());
        self::assertArrayHasKey('width', $result->toArray());
        self::assertArrayHasKey('height', $result->toArray());
        self::assertArrayHasKey('touch', $result->toArray());
        self::assertArrayHasKey('size', $result->toArray());

        self::assertNull($result->toArray()['width']);
        self::assertNull($result->toArray()['height']);
        self::assertTrue($result->toArray()['touch']);
        self::assertSame($size, $result->toArray()['size']);
    }
}
