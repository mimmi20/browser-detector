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

namespace BrowserDetectorTest\Loader\Helper;

use ArrayIterator;
use BrowserDetector\Loader\Helper\Data;
use Iterator;
use JsonClass\DecodeErrorException;
use JsonClass\JsonInterface;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use SplFileInfo;

use function assert;

final class DataTest extends TestCase
{
    private const DATA_PATH = 'root';
    private const STRUCTURE = [
        'bot.json' => '{"key": "value"}',
        'tool.json' => '{"key2": "value2"}',
    ];
    private const KEY       = 'rules';
    private const VALUE     = 'abc';

    protected function setUp(): void
    {
        vfsStream::setup(self::DATA_PATH, null, self::STRUCTURE);
    }

    public function testInvokeFail(): void
    {
        $file = $this->getMockBuilder(SplFileInfo::class)
            ->disableOriginalConstructor()
            ->getMock();
        $file
            ->expects(self::once())
            ->method('getPathname')
            ->willReturn(vfsStream::url(self::DATA_PATH . '/bot.json'));

        $iterator = $this->getMockBuilder(Iterator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $iterator
            ->expects(self::once())
            ->method('current')
            ->willReturn($file);
        $iterator
            ->expects(self::once())
            ->method('valid')
            ->willReturnCallback(
                static function (): bool {
                    static $i = 0;
                    $return   = false;
                    if (0 === $i) {
                        $return = true;
                    }

                    ++$i;

                    return $return;
                }
            );

        $jsonParser = $this->getMockBuilder(JsonInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $jsonParser
            ->expects(self::once())
            ->method('decode')
            ->with('{"key": "value"}', false, 512, 0)
            ->will(self::throwException(new DecodeErrorException('error', 0)));

        assert($iterator instanceof Iterator);
        assert($jsonParser instanceof JsonInterface);
        $object = new Data($iterator, $jsonParser);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('file "vfs://root/bot.json" contains invalid json');
        $this->expectExceptionCode(0);
        $object();
    }

    public function testInvokeFail2(): void
    {
        $file = $this->getMockBuilder(SplFileInfo::class)
            ->disableOriginalConstructor()
            ->getMock();
        $file
            ->expects(self::once())
            ->method('getPathname')
            ->willReturn(vfsStream::url(self::DATA_PATH . '/bot2.json'));

        $iterator = $this->getMockBuilder(Iterator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $iterator
            ->expects(self::once())
            ->method('current')
            ->willReturn($file);
        $iterator
            ->expects(self::once())
            ->method('valid')
            ->willReturnCallback(
                static function (): bool {
                    static $i = 0;
                    $return   = false;
                    if (0 === $i) {
                        $return = true;
                    }

                    ++$i;

                    return $return;
                }
            );

        $jsonParser = $this->getMockBuilder(JsonInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $jsonParser
            ->expects(self::never())
            ->method('decode');

        assert($iterator instanceof Iterator);
        assert($jsonParser instanceof JsonInterface);
        $object = new Data($iterator, $jsonParser);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('could not read file "vfs://root/bot2.json"');
        $this->expectExceptionCode(0);
        $object();
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \InvalidArgumentException
     */
    public function testInvokeSuccess(): void
    {
        $file = $this->getMockBuilder(SplFileInfo::class)
            ->disableOriginalConstructor()
            ->getMock();
        $file
            ->expects(self::exactly(2))
            ->method('getPathname')
            ->willReturnOnConsecutiveCalls(vfsStream::url(self::DATA_PATH . '/bot.json'), vfsStream::url(self::DATA_PATH . '/tool.json'));

        /** @var ArrayIterator<SplFileInfo>&MockObject $iterator */
        $iterator = $this->getMockBuilder(ArrayIterator::class)
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
                static function (): bool {
                    static $i = 0;
                    $return   = false;
                    if (1 >= $i) {
                        $return = true;
                    }

                    ++$i;

                    return $return;
                }
            );

        $jsonParser = $this->getMockBuilder(JsonInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $jsonParser
            ->expects(self::exactly(2))
            ->method('decode')
            ->withConsecutive(['{"key": "value"}', false, 512, 0], ['{"key2": "value2"}', false, 512, 0])
            ->willReturnOnConsecutiveCalls([self::KEY => self::VALUE, 'generic' => 'test', 'generic2' => 'test2'], ['generic' => 'test', 'generic2' => 'test2', 'new' => 'newValue']);

        assert($iterator instanceof ArrayIterator);
        assert($jsonParser instanceof JsonInterface);
        $object = new Data($iterator, $jsonParser);

        $object();

        self::assertTrue($object->isInitialized());

        $object();

        self::assertTrue($object->isInitialized());
        self::assertTrue($object->hasItem(self::KEY));
        self::assertSame(self::VALUE, $object->getItem(self::KEY));
        self::assertCount(4, $object);

        self::assertFalse($object->hasItem('key3'));
        self::assertNull($object->getItem('key3'));
    }
}
