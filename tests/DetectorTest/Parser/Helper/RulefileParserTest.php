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
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\Constraint\IsInstanceOf;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use Throwable;

final class RulefileParserTest extends TestCase
{
    private const DATA_PATH = 'root';

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function testParseInvalidFile(): void
    {
        $structure = ['bot.json' => 'test-content'];

        vfsStream::setup(self::DATA_PATH, null, $structure);

        $content  = 'test-content';
        $fallback = 'test-fallback';

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

        $object = new RulefileParser($logger);

        $result = $object->parseFile(vfsStream::url(self::DATA_PATH . '/bot2.json'), $useragent, $fallback);

        self::assertSame($fallback, $result);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function testParseFileError(): void
    {
        $structure = ['bot.json' => 'test-content'];

        vfsStream::setup(self::DATA_PATH, null, $structure);

        $content  = "[]\n";
        $fallback = 'test-fallback';

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

        $object = new RulefileParser($logger);

        $result = $object->parseFile(vfsStream::url(self::DATA_PATH . '/bot.json'), $useragent, $fallback);

        self::assertSame($fallback, $result);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function testParseNoJsonContent(): void
    {
        $structure = ['bot.json' => 'test-content'];

        vfsStream::setup(self::DATA_PATH, null, $structure);

        $fallback = 'test-fallback';

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

        $object = new RulefileParser($logger);

        $result = $object->parseFile(vfsStream::url(self::DATA_PATH . '/bot.json'), $useragent, $fallback);

        self::assertSame($fallback, $result);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function testParseNotEmptyFile(): void
    {
        $structure = ['bot.json' => '{"generic": "test-generic", "rules": {"/test-useragent/": "test-mode", "/test/": "test-mode-2"}}'];

        vfsStream::setup(self::DATA_PATH, null, $structure);

        $fallback = 'test-fallback';

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

        $object = new RulefileParser($logger);

        $result = $object->parseFile(vfsStream::url(self::DATA_PATH . '/bot.json'), $useragent, $fallback);

        self::assertSame('test-mode', $result);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function testParseNotEmptyFile2(): void
    {
        $structure = ['bot2.json' => '{"generic": "test-generic", "rules": {"1": "test-mode-3", "/test-useragent/": "test-mode", "/test/": "test-mode-2"}}'];

        vfsStream::setup(self::DATA_PATH, null, $structure);

        $fallback = 'test-fallback';

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

        $object = new RulefileParser($logger);

        $result = $object->parseFile(vfsStream::url(self::DATA_PATH . '/bot2.json'), $useragent, $fallback);

        self::assertSame('test-mode', $result);
    }

    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function testParseNotEmptyFile3(): void
    {
        $structure = ['bot2.json' => '{"generic": "test-generic", "rules": {"/(?<!test-?)useragent/": "test-mode-3", "/test-useragent/": "test-mode", "/test/": "test-mode-2"}}'];

        vfsStream::setup(self::DATA_PATH, null, $structure);

        $fallback = 'test-fallback';

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

        $object = new RulefileParser($logger);

        $result = $object->parseFile(vfsStream::url(self::DATA_PATH . '/bot2.json'), $useragent, $fallback);

        self::assertSame('test-mode', $result);
    }
}
