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

use BrowserDetector\Cache\Cache;
use BrowserDetector\Loader\Helper\CacheKey;
use BrowserDetector\Loader\Helper\InitData;
use PHPUnit\Framework\TestCase;
use Seld\JsonLint\JsonParser;
use Seld\JsonLint\ParsingException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class InitDataTest extends TestCase
{
    /**
     * @throws \ReflectionException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testInvokeFail(): void
    {
        $cache = $this->createMock(Cache::class);

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

        $cacheKey = $this->createMock(CacheKey::class);

        /** @var Cache $cache */
        /** @var Finder $finder */
        /** @var JsonParser $jsonParser */
        /** @var CacheKey $cacheKey */
        $object = new InitData($cache, $finder, $jsonParser, $cacheKey);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('file "" contains invalid json');
        $object();
    }

    /**
     * @throws \ReflectionException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testInvokeSuccess(): void
    {
        $cache = $this->getMockBuilder(Cache::class)
            ->disableOriginalConstructor()
            ->setMethods(['hasItem', 'setItem'])
            ->getMock();

        $map = [
            ['rules', 'rules_key'],
            ['generic', 'generic_key'],
            ['generic2', 'generic_key'],
        ];

        $cache
            ->expects(self::exactly(3))
            ->method('hasItem')
            ->will(self::returnCallback(
                static function (...$values) {
                    static $i = 0;

                    if ('generic_key' !== $values[0]) {
                        return false;
                    }

                    $return = false;
                    if (0 === $i) {
                        $return = true;
                    }
                    ++$i;

                    return $return;
                }
            ));
        $cache
            ->expects(self::exactly(2))
            ->method('setItem')
            ->will(self::returnValue(true));

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
            ->expects(self::exactly(2))
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
            ->will(self::returnValue(['rules' => 'abc', 'generic' => 'test', 'generic2' => 'test2']));

        $map = [
            ['rules', 'rules_key'],
            ['generic', 'generic_key'],
            ['generic2', 'generic_key'],
        ];

        $cacheKey = $this->getMockBuilder(CacheKey::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();
        $cacheKey
            ->expects(self::any())
            ->method('__invoke')
            ->will(self::returnValueMap($map));

        /** @var Cache $cache */
        /** @var Finder $finder */
        /** @var JsonParser $jsonParser */
        /** @var CacheKey $cacheKey */
        $object = new InitData($cache, $finder, $jsonParser, $cacheKey);

        $object();

        self::assertTrue(true);
    }
}
