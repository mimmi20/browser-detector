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

namespace BrowserDetectorTest\Parser\Helper;

use BrowserDetector\Parser\Helper\RulefileParser;
use JsonClass\DecodeErrorException;
use JsonClass\JsonInterface;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\Constraint\IsInstanceOf;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use SplFileInfo;
use Throwable;

use function assert;

final class RulefileParserTest extends TestCase
{
    private const DATA_PATH = 'root';
    private const STRUCTURE = ['bot.json' => 'test-content'];

    protected function setUp(): void
    {
        vfsStream::setup(self::DATA_PATH, null, self::STRUCTURE);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function testParseEmptyFile(): void
    {
        $content  = 'test-content';
        $fallback = 'test-fallback';

        $fileInfo = $this->getMockBuilder(SplFileInfo::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fileInfo
            ->expects(self::once())
            ->method('getPathname')
            ->willReturn(vfsStream::url(self::DATA_PATH . '/bot.json'));

        $jsonParser = $this->getMockBuilder(JsonInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $jsonParser
            ->expects(self::once())
            ->method('decode')
            ->with($content, true)
            ->willReturn([]);

        $useragent = 'test-useragent';

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

        assert($jsonParser instanceof JsonInterface);
        assert($logger instanceof LoggerInterface);
        $object = new RulefileParser($jsonParser, $logger);

        assert($fileInfo instanceof SplFileInfo);
        $result = $object->parseFile($fileInfo, $useragent, $fallback);

        self::assertSame($fallback, $result);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function testParseFileError(): void
    {
        $content   = "[]\n";
        $fallback  = 'test-fallback';
        $exception = new DecodeErrorException('read-error', 0);

        $fileInfo = $this->getMockBuilder(SplFileInfo::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fileInfo
            ->expects(self::exactly(2))
            ->method('getPathname')
            ->willReturn('tests/test.json');

        $jsonParser = $this->getMockBuilder(JsonInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $jsonParser
            ->expects(self::once())
            ->method('decode')
            ->with($content, true)
            ->willThrowException($exception);

        $useragent = 'test-useragent';

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
            ->expects(self::once())
            ->method('error')
            ->with(new IsInstanceOf(Throwable::class));
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        assert($jsonParser instanceof JsonInterface);
        assert($logger instanceof LoggerInterface);
        $object = new RulefileParser($jsonParser, $logger);

        assert($fileInfo instanceof SplFileInfo);
        $result = $object->parseFile($fileInfo, $useragent, $fallback);

        self::assertSame($fallback, $result);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function testParseNotEmptyFile(): void
    {
        $content  = 'test-content';
        $fallback = 'test-fallback';
        $mode     = 'test-mode';

        $generic = 'test-generic';
        $rules   = ['/test-useragent/' => $mode, '/test/' => 'test-mode-2'];

        $fileInfo = $this->getMockBuilder(SplFileInfo::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fileInfo
            ->expects(self::once())
            ->method('getPathname')
            ->willReturn(vfsStream::url(self::DATA_PATH . '/bot.json'));

        $jsonParser = $this->getMockBuilder(JsonInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $jsonParser
            ->expects(self::once())
            ->method('decode')
            ->with($content, true)
            ->willReturn(['generic' => $generic, 'rules' => $rules]);

        $useragent = 'test-useragent';

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

        assert($jsonParser instanceof JsonInterface);
        assert($logger instanceof LoggerInterface);
        $object = new RulefileParser($jsonParser, $logger);

        assert($fileInfo instanceof SplFileInfo);
        $result = $object->parseFile($fileInfo, $useragent, $fallback);

        self::assertSame($mode, $result);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function testParseNotEmptyFile2(): void
    {
        $content  = 'test-content';
        $fallback = 'test-fallback';
        $mode     = 'test-mode';

        $generic = 'test-generic';
        $rules   = ['/test-useragent/' => $mode, '/test/' => 'test-mode-2'];

        $fileInfo = $this->getMockBuilder(SplFileInfo::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fileInfo
            ->expects(self::once())
            ->method('getPathname')
            ->willReturn(vfsStream::url(self::DATA_PATH . '/bot.json'));

        $jsonParser = $this->getMockBuilder(JsonInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $jsonParser
            ->expects(self::once())
            ->method('decode')
            ->with($content, true)
            ->willReturn(['generic' => $generic, 'rules' => $rules]);

        $useragent = 'tets-useragent';

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

        assert($jsonParser instanceof JsonInterface);
        assert($logger instanceof LoggerInterface);
        $object = new RulefileParser($jsonParser, $logger);

        assert($fileInfo instanceof SplFileInfo);
        $result = $object->parseFile($fileInfo, $useragent, $fallback);

        self::assertSame($generic, $result);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function testParseNotEmptyFile3(): void
    {
        $content  = 'test-content';
        $fallback = 'test-fallback';
        $mode     = 'test-mode';

        $generic = 'test-generic';
        $rules   = ['/(?<!test-?)useragent/' => 'test-mode-3', '/test-useragent/' => $mode, '/test/' => 'test-mode-2'];

        $fileInfo = $this->getMockBuilder(SplFileInfo::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fileInfo
            ->expects(self::exactly(2))
            ->method('getPathname')
            ->willReturn(vfsStream::url(self::DATA_PATH . '/bot.json'));

        $jsonParser = $this->getMockBuilder(JsonInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $jsonParser
            ->expects(self::once())
            ->method('decode')
            ->with($content, true)
            ->willReturn(['generic' => $generic, 'rules' => $rules]);

        $useragent = 'test-useragent';

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
            ->expects(self::once())
            ->method('error')
            ->with(new IsInstanceOf(Throwable::class));
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        assert($jsonParser instanceof JsonInterface);
        assert($logger instanceof LoggerInterface);
        $object = new RulefileParser($jsonParser, $logger);

        assert($fileInfo instanceof SplFileInfo);
        $result = $object->parseFile($fileInfo, $useragent, $fallback);

        self::assertSame($mode, $result);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function testParseNotEmptyFile4(): void
    {
        $content  = 'test-content';
        $fallback = 'test-fallback';
        $mode     = 'test-mode';

        $generic = 'test-generic';
        $rules   = [1 => 'test-mode-3', '/test-useragent/' => $mode, '/test/' => 'test-mode-2'];

        $fileInfo = $this->getMockBuilder(SplFileInfo::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fileInfo
            ->expects(self::exactly(2))
            ->method('getPathname')
            ->willReturn(vfsStream::url(self::DATA_PATH . '/bot.json'));

        $jsonParser = $this->getMockBuilder(JsonInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $jsonParser
            ->expects(self::once())
            ->method('decode')
            ->with($content, true)
            ->willReturn(['generic' => $generic, 'rules' => $rules]);

        $useragent = 'test-useragent';

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
            ->expects(self::once())
            ->method('error')
            ->with(new IsInstanceOf(Throwable::class));
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        assert($jsonParser instanceof JsonInterface);
        assert($logger instanceof LoggerInterface);
        $object = new RulefileParser($jsonParser, $logger);

        assert($fileInfo instanceof SplFileInfo);
        $result = $object->parseFile($fileInfo, $useragent, $fallback);

        self::assertSame($mode, $result);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function testParseNotExistingFile(): void
    {
        $fallback = 'test-fallback';

        $fileInfo = $this->getMockBuilder(SplFileInfo::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fileInfo
            ->expects(self::exactly(2))
            ->method('getPathname')
            ->willReturn(vfsStream::url(self::DATA_PATH . '/this-file-does-exist.json'));

        $jsonParser = $this->getMockBuilder(JsonInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $jsonParser
            ->expects(self::never())
            ->method('decode');

        $useragent = 'test-useragent';

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
            ->expects(self::once())
            ->method('error')
            ->with(new IsInstanceOf(Throwable::class));
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        assert($jsonParser instanceof JsonInterface);
        assert($logger instanceof LoggerInterface);
        $object = new RulefileParser($jsonParser, $logger);

        assert($fileInfo instanceof SplFileInfo);
        $result = $object->parseFile($fileInfo, $useragent, $fallback);

        self::assertSame($fallback, $result);
    }
}
