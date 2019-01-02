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
            ->method('in');
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
            ->with('{"key": "value"}', false, 512, 0)
            ->will(self::throwException(new DecodeErrorException(0, 'error', '')));

        /** @var Finder $finder */
        /** @var Json $jsonParser */
        $object = new Data($finder, $jsonParser);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('file "" contains invalid json');
        $this->expectExceptionCode(0);
        $object();
    }

    /**
     * @return void
     */
    public function testInvokeSuccess(): void
    {
        $file = $this->getMockBuilder(SplFileInfo::class)
            ->disableOriginalConstructor()
            ->getMock();
        $file
            ->expects(self::exactly(2))
            ->method('getContents')
            ->willReturnOnConsecutiveCalls('{"key": "value"}', '{"key2": "value2"}');

        $iterator = $this->getMockBuilder(\ArrayIterator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $iterator
            ->expects(self::exactly(2))
            ->method('current')
            ->willReturn($file);
        $iterator
            ->expects(self::exactly(3))
            ->method('valid')
            ->willReturnCallback(
                static function () {
                    static $i = 0;
                    $return = false;
                    if (1 >= $i) {
                        $return = true;
                    }
                    ++$i;

                    return $return;
                }
            );

        $finder = $this->getMockBuilder(Finder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $finder
            ->expects(self::never())
            ->method('in');
        $finder
            ->expects(self::once())
            ->method('getIterator')
            ->willReturn($iterator);

        $jsonParser = $this->getMockBuilder(JsonInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $key   = 'rules';
        $value = 'abc';

        $jsonParser
            ->expects(self::exactly(2))
            ->method('decode')
            ->withConsecutive(['{"key": "value"}', false, 512, 0], ['{"key2": "value2"}', false, 512, 0])
            ->willReturnOnConsecutiveCalls([$key => $value, 'generic' => 'test', 'generic2' => 'test2'], ['generic' => 'test', 'generic2' => 'test2', 'new' => 'newValue']);

        /** @var Finder $finder */
        /** @var Json $jsonParser */
        $object = new Data($finder, $jsonParser);

        $object();

        self::assertTrue($object->isInitialized());

        $object();

        self::assertTrue($object->isInitialized());
        self::assertTrue($object->hasItem($key));
        self::assertSame($value, $object->getItem($key));
        self::assertCount(4, $object);
    }
}
