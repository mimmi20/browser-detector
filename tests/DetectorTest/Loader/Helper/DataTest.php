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
namespace BrowserDetectorTest\Loader\Helper;

use BrowserDetector\Loader\Helper\Data;
use ExceptionalJSON\DecodeErrorException;
use JsonClass\Json;
use JsonClass\JsonInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class DataTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvokeFail(): void
    {
        self::markTestIncomplete();
        $file = $this->getMockBuilder(SplFileInfo::class)
            ->disableOriginalConstructor()
            ->getMock();
        $file
            ->expects(self::once())
            ->method('getContents')
            ->will(self::returnValue('{"key": "value"}'));

        $iterator = $this->getMockBuilder(\ArrayIterator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $iterator
            ->expects(self::once())
            ->method('current')
            ->will(self::returnValue($file));
        $iterator
            ->expects(self::once())
            ->method('valid')
            ->will(
                self::returnCallback(
                    static function () {
                        static $i = 0;
                        $return = false;
                        if (0 === $i) {
                            $return = true;
                        }
                        ++$i;

                        return $return;
                    }
                )
            );

        $finder = $this->getMockBuilder(Finder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $finder
            ->expects(self::never())
            ->method('in')
            ->will(self::returnSelf());
        $finder
            ->expects(self::once())
            ->method('getIterator')
            ->will(self::returnValue($iterator));

        $jsonParser = $this->getMockBuilder(JsonInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $jsonParser
            ->expects(self::once())
            ->method('decode')
            ->with('{"key": "value"}')
            ->will(self::throwException(new DecodeErrorException(0, 'error', '')));

        /** @var Finder $finder */
        /** @var Json $jsonParser */
        $object = new Data($finder, $jsonParser);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('file "" contains invalid json');
        $object();
    }

    /**
     * @return void
     */
    public function testInvokeSuccess(): void
    {
        self::markTestIncomplete();
        $file = $this->getMockBuilder(SplFileInfo::class)
            ->disableOriginalConstructor()
            ->getMock();
        $file
            ->expects(self::exactly(2))
            ->method('getContents')
            ->will(self::returnValue('{"key": "value"}'));

        $iterator = $this->getMockBuilder(\ArrayIterator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $iterator
            ->expects(self::exactly(2))
            ->method('current')
            ->will(self::returnValue($file));
        $iterator
            ->expects(self::exactly(3))
            ->method('valid')
            ->will(
                self::returnCallback(
                    static function () {
                        static $i = 0;
                        $return = false;
                        if (1 >= $i) {
                            $return = true;
                        }
                        ++$i;

                        return $return;
                    }
                )
            );

        $finder = $this->getMockBuilder(Finder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $finder
            ->expects(self::never())
            ->method('in')
            ->will(self::returnSelf());
        $finder
            ->expects(self::once())
            ->method('getIterator')
            ->will(self::returnValue($iterator));

        $jsonParser = $this->getMockBuilder(JsonInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $jsonParser
            ->expects(self::exactly(2))
            ->method('decode')
            ->with('{"key": "value"}')
            ->will(self::returnValue(['rules' => 'abc', 'generic' => 'test', 'generic2' => 'test2']));

        /** @var Finder $finder */
        /** @var Json $jsonParser */
        $object = new Data($finder, $jsonParser);

        $object();

        self::assertTrue($object->isInitialized());
    }

    /**
     * @return void
     */
    public function testFlush(): void
    {
        $finder     = $this->createMock(Finder::class);
        $jsonParser = $this->createMock(JsonInterface::class);

        /** @var Finder $finder */
        /** @var Json $jsonParser */
        $object = new Data($finder, $jsonParser);

        self::assertFalse($object->flush());
        self::assertFalse($object->removeItem(''));
        self::assertFalse($object->hasItem(''));
        self::assertFalse($object->setItem('', ''));
        self::assertNull($object->getItem(''));
    }
}
