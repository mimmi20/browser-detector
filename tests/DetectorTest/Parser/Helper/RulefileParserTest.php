<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Parser\Helper;

use BrowserDetector\Parser\Helper\RulefileParser;
use JsonException;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Stringable;
use Throwable;

use function assert;
use function sprintf;

#[CoversClass(RulefileParser::class)]
final class RulefileParserTest extends TestCase
{
    private const string DATA_PATH = 'root';

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testParseInvalidFile(): void
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
            ->willReturnCallback(
                static function (string | Stringable $message, array $context = []): void {
                    assert($message instanceof Throwable);

                    self::assertInstanceOf(Throwable::class, $message);
                    self::assertSame([], $context);

                    self::assertSame(
                        sprintf(
                            'could not load file %s',
                            vfsStream::url(self::DATA_PATH . '/bot2.json'),
                        ),
                        $message->getMessage(),
                    );

                    self::assertSame(0, $message->getCode());
                    self::assertNull($message->getPrevious());
                },
            );
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

        $result = $object->parseFile(
            vfsStream::url(self::DATA_PATH . '/bot2.json'),
            $useragent,
            $fallback,
        );

        self::assertSame($fallback, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testParseFileError(): void
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
            ->willReturnCallback(
                static function (string | Stringable $message, array $context = []): void {
                    assert($message instanceof Throwable);

                    self::assertInstanceOf(Throwable::class, $message);
                    self::assertSame([], $context);

                    self::assertSame(
                        'could not decode content of file vfs://root/bot.json',
                        $message->getMessage(),
                    );

                    self::assertSame(0, $message->getCode());
                    self::assertInstanceOf(JsonException::class, $message->getPrevious());
                },
            );
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

        $result = $object->parseFile(
            vfsStream::url(self::DATA_PATH . '/bot.json'),
            $useragent,
            $fallback,
        );

        self::assertSame($fallback, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testParseNoJsonContent(): void
    {
        $structure = ['bot.json' => 'test-content'];

        vfsStream::setup(self::DATA_PATH, null, $structure);

        $path = vfsStream::url(self::DATA_PATH . '/bot.json');

        $fallback  = 'test-fallback';
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
            ->willReturnCallback(
                static function (string | Stringable $message, array $context = []) use ($path): void {
                    assert($message instanceof Throwable);

                    self::assertInstanceOf(Throwable::class, $message);
                    self::assertSame([], $context);

                    self::assertSame(
                        sprintf('could not decode content of file %s', $path),
                        $message->getMessage(),
                    );

                    self::assertSame(0, $message->getCode());
                    self::assertInstanceOf(JsonException::class, $message->getPrevious());
                },
            );
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

        $result = $object->parseFile($path, $useragent, $fallback);

        self::assertSame($fallback, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testParseNotEmptyFile(): void
    {
        $structure = ['bot.json' => '{"generic": "test-generic", "rules": {"/test-useragent/": "test-mode", "/test/": "test-mode-2"}}'];

        vfsStream::setup(self::DATA_PATH, null, $structure);

        $fallback  = 'test-fallback';
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

        $result = $object->parseFile(
            vfsStream::url(self::DATA_PATH . '/bot.json'),
            $useragent,
            $fallback,
        );

        self::assertSame('test-mode', $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testParseNotEmptyFile2(): void
    {
        $structure = ['bot2.json' => '{"generic": "test-generic", "rules": {"1": "test-mode-3", "/test-useragent/": "test-mode", "/test/": "test-mode-2"}}'];

        vfsStream::setup(self::DATA_PATH, null, $structure);

        $fallback  = 'test-fallback';
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
            ->willReturnCallback(
                static function (string | Stringable $message, array $context = []): void {
                    assert($message instanceof Throwable);

                    self::assertInstanceOf(Throwable::class, $message);
                    self::assertSame([], $context);

                    self::assertSame(
                        'invalid numeric rule "1" found in file vfs://root/bot2.json',
                        $message->getMessage(),
                    );

                    self::assertSame(0, $message->getCode());
                    self::assertNull($message->getPrevious());
                },
            );
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

        $result = $object->parseFile(
            vfsStream::url(self::DATA_PATH . '/bot2.json'),
            $useragent,
            $fallback,
        );

        self::assertSame('test-mode', $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testParseNotEmptyFile3(): void
    {
        $structure = ['bot2.json' => '{"generic": "test-generic", "rules": {"/(?<!test-?)useragent/": "test-mode-3", "/test-useragent/": "test-mode", "/test/": "test-mode-2"}}'];

        vfsStream::setup(self::DATA_PATH, null, $structure);

        $fallback  = 'test-fallback';
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
            ->willReturnCallback(
                static function (string | Stringable $message, array $context = []): void {
                    assert($message instanceof Throwable);

                    self::assertInstanceOf(Throwable::class, $message);
                    self::assertSame([], $context);

                    self::assertSame(
                        'could not match rule "/(?<!test-?)useragent/" of file vfs://root/bot2.json: 1',
                        $message->getMessage(),
                    );

                    self::assertSame(0, $message->getCode());
                    self::assertNull($message->getPrevious());
                },
            );
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

        $result = $object->parseFile(
            vfsStream::url(self::DATA_PATH . '/bot2.json'),
            $useragent,
            $fallback,
        );

        self::assertSame('test-mode', $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testParseNotEmptyFile4(): void
    {
        $structure = ['bot2.json' => '{"generic": "test-generic", "rules": {"/(?<!test-?)useragent/": "test-mode-3"}}'];

        vfsStream::setup(self::DATA_PATH, null, $structure);

        $fallback  = 'test-fallback';
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
            ->willReturnCallback(
                static function (string | Stringable $message, array $context = []): void {
                    assert($message instanceof Throwable);

                    self::assertInstanceOf(Throwable::class, $message);
                    self::assertSame([], $context);

                    self::assertSame(
                        'could not match rule "/(?<!test-?)useragent/" of file vfs://root/bot2.json: 1',
                        $message->getMessage(),
                    );

                    self::assertSame(0, $message->getCode());
                    self::assertNull($message->getPrevious());
                },
            );
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

        $result = $object->parseFile(
            vfsStream::url(self::DATA_PATH . '/bot2.json'),
            $useragent,
            $fallback,
        );

        self::assertSame('test-generic', $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testParseNotEmptyFile5(): void
    {
        $structure = ['bot2.json' => '{"rules": {"/(?<!test-?)useragent/": "test-mode-3"}}'];

        vfsStream::setup(self::DATA_PATH, null, $structure);

        $fallback  = 'test-fallback';
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
            ->willReturnCallback(
                static function (string | Stringable $message, array $context = []): void {
                    assert($message instanceof Throwable);

                    self::assertInstanceOf(Throwable::class, $message);
                    self::assertSame([], $context);

                    self::assertSame(
                        'could not match rule "/(?<!test-?)useragent/" of file vfs://root/bot2.json: 1',
                        $message->getMessage(),
                    );

                    self::assertSame(0, $message->getCode());
                    self::assertNull($message->getPrevious());
                },
            );
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

        $result = $object->parseFile(
            vfsStream::url(self::DATA_PATH . '/bot2.json'),
            $useragent,
            $fallback,
        );

        self::assertSame($fallback, $result);
    }
}
