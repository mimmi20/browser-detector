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
use PHPUnit\Framework\TestCase;
use Seld\JsonLint\JsonParser;
use Seld\JsonLint\ParsingException;
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
            ->setMethods(['getContents'])
            ->getMock();
        $file
            ->expects(self::once())
            ->method('getContents')
            ->will(self::returnValue('{"key": "value"}'));

        $iterator = $this->getMockBuilder(\ArrayIterator::class)
            ->disableOriginalConstructor()
            ->setMethods(['current', 'valid'])
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
            ->setMethods(['in', 'getIterator'])
            ->getMock();
        $finder
            ->expects(self::never())
            ->method('in')
            ->will(self::returnSelf());
        $finder
            ->expects(self::once())
            ->method('getIterator')
            ->will(self::returnValue($iterator));

        $jsonParser = $this->getMockBuilder(JsonParser::class)
            ->disableOriginalConstructor()
            ->setMethods(['parse'])
            ->getMock();

        $jsonParser
            ->expects(self::once())
            ->method('parse')
            ->will(self::throwException(new ParsingException('error')));

        /** @var Finder $finder */
        /** @var JsonParser $jsonParser */
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
        $file = $this->getMockBuilder(SplFileInfo::class)
            ->disableOriginalConstructor()
            ->setMethods(['getContents'])
            ->getMock();
        $file
            ->expects(self::exactly(2))
            ->method('getContents')
            ->will(self::returnValue('{"key": "value"}'));

        $iterator = $this->getMockBuilder(\ArrayIterator::class)
            ->disableOriginalConstructor()
            ->setMethods(['current', 'valid'])
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
            ->setMethods(['in', 'getIterator'])
            ->getMock();
        $finder
            ->expects(self::never())
            ->method('in')
            ->will(self::returnSelf());
        $finder
            ->expects(self::once())
            ->method('getIterator')
            ->will(self::returnValue($iterator));

        $jsonParser = $this->getMockBuilder(JsonParser::class)
            ->disableOriginalConstructor()
            ->setMethods(['parse'])
            ->getMock();

        $jsonParser
            ->expects(self::exactly(2))
            ->method('parse')
            ->will(self::returnValue(['rules' => 'abc', 'generic' => 'test', 'generic2' => 'test2']));

        /** @var Finder $finder */
        /** @var JsonParser $jsonParser */
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
        $jsonParser = $this->createMock(JsonParser::class);

        /** @var Finder $finder */
        /** @var JsonParser $jsonParser */
        $object = new Data($finder, $jsonParser);

        self::assertFalse($object->flush());
        self::assertFalse($object->removeItem(''));
        self::assertFalse($object->hasItem(''));
        self::assertFalse($object->setItem('', ''));
        self::assertNull($object->getItem(''));
    }
}
