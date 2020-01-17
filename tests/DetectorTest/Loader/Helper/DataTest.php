<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2020, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Loader\Helper;

use BrowserDetector\Loader\Helper\Data;
use ExceptionalJSON\DecodeErrorException;
use JsonClass\JsonInterface;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;

final class DataTest extends TestCase
{
    private const DATA_PATH = 'root';

    /**
     * @var \org\bovigo\vfs\vfsStreamDirectory
     */
    private $root;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $structure = [
            'bot.json' => '{"key": "value"}',
            'tool.json' => '{"key2": "value2"}',
        ];

        $this->root = vfsStream::setup(self::DATA_PATH, null, $structure);
    }

    /**
     * @return void
     */
    public function testInvokeFail(): void
    {
        $file = $this->getMockBuilder(\SplFileInfo::class)
            ->disableOriginalConstructor()
            ->getMock();
        $file
            ->expects(self::exactly(2))
            ->method('getPathname')
            ->willReturnOnConsecutiveCalls(vfsStream::url(self::DATA_PATH . '/bot.json'), vfsStream::url(self::DATA_PATH . '/tool.json'));

        $iterator = $this->getMockBuilder(\Iterator::class)
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
                    $return = false;
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
            ->will(self::throwException(new DecodeErrorException(0, 'error', '')));

        /** @var \Iterator $iterator */
        /** @var \JsonClass\Json $jsonParser */
        $object = new Data($iterator, $jsonParser);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('file "vfs://root/tool.json" contains invalid json');
        $this->expectExceptionCode(0);
        $object();
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \InvalidArgumentException
     *
     * @return void
     */
    public function testInvokeSuccess(): void
    {
        $file = $this->getMockBuilder(\SplFileInfo::class)
            ->disableOriginalConstructor()
            ->getMock();
        $file
            ->expects(self::exactly(2))
            ->method('getPathname')
            ->willReturnOnConsecutiveCalls(vfsStream::url(self::DATA_PATH . '/bot.json'), vfsStream::url(self::DATA_PATH . '/tool.json'));

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
                static function (): bool {
                    static $i = 0;
                    $return = false;
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

        $key   = 'rules';
        $value = 'abc';

        $jsonParser
            ->expects(self::exactly(2))
            ->method('decode')
            ->withConsecutive(['{"key": "value"}', false, 512, 0], ['{"key2": "value2"}', false, 512, 0])
            ->willReturnOnConsecutiveCalls([$key => $value, 'generic' => 'test', 'generic2' => 'test2'], ['generic' => 'test', 'generic2' => 'test2', 'new' => 'newValue']);

        /** @var \Iterator $iterator */
        /** @var \JsonClass\Json $jsonParser */
        $object = new Data($iterator, $jsonParser);

        $object();

        self::assertTrue($object->isInitialized());

        $object();

        self::assertTrue($object->isInitialized());
        self::assertTrue($object->hasItem($key));
        self::assertSame($value, $object->getItem($key));
        self::assertCount(4, $object);
    }
}
