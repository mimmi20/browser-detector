<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Loader\Helper;

use BrowserDetector\Loader\Helper\Data;
use InvalidArgumentException;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

use function sprintf;

final class DataTest extends TestCase
{
    private const DATA_PATH = 'root';

    /** @throws void */
    public function testInvokeFail(): void
    {
        $structure = [
            'invalid' => ['bot.json' => '{\'key\': \'value\'}'],
        ];

        vfsStream::setup(self::DATA_PATH, null, $structure);

        $object = new Data(vfsStream::url(self::DATA_PATH . '/invalid'), 'json');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('file "vfs://root/invalid/bot.json" contains invalid json');
        $this->expectExceptionCode(0);

        $object();
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testInvokeSuccess(): void
    {
        $structure = [
            'valid' => ['tool.json' => '{"rules": "abc"}'],
        ];

        vfsStream::setup(self::DATA_PATH, null, $structure);

        $key   = 'rules';
        $value = 'abc';

        $object = new Data(vfsStream::url(self::DATA_PATH . '/valid'), 'json');

        self::assertFalse($object->isInitialized());

        $object();

        self::assertTrue($object->isInitialized());

        $object();

        self::assertTrue($object->isInitialized());
        self::assertTrue($object->hasItem($key));
        self::assertSame($value, $object->getItem($key));
        self::assertCount(1, $object);

        self::assertFalse($object->hasItem('key3'));
        self::assertNull($object->getItem('key3'));
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testInvokeSuccess2(): void
    {
        $structure = [
            'valid' => [
                'tool.json' => '{"rules": "abc"}',
                'tool2.json' => '{"rules": "abc2", "key3": "value3"}',
            ],
        ];

        vfsStream::setup(self::DATA_PATH, null, $structure);

        $key   = 'rules';
        $value = 'abc';

        $object = new Data(vfsStream::url(self::DATA_PATH . '/valid'), 'json');

        self::assertFalse($object->isInitialized());

        $object();

        self::assertTrue($object->isInitialized());

        $object();

        self::assertTrue($object->isInitialized());
        self::assertTrue($object->hasItem($key));
        self::assertSame($value, $object->getItem($key));
        self::assertCount(2, $object);

        self::assertTrue($object->hasItem('key3'));
        self::assertSame('value3', $object->getItem('key3'));
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testInvokeSuccess3(): void
    {
        vfsStream::setup(self::DATA_PATH);

        $baseDir = vfsStreamWrapper::getRoot();

        $dir = vfsStream::newDirectory('valid');
        $baseDir->addChild($dir);

        $file1 = vfsStream::newFile('tool.json', 0001);
        $file1->withContent('{"rules": "abc"}');

        $file2 = vfsStream::newFile('tool2.json', 0001);
        $file2->withContent('{"rules": "abc2", "key3": "value3"}');

        $dir->addChild($file1);
        $dir->addChild($file2);

        $object = new Data($dir->url(), 'json');

        self::assertFalse($object->isInitialized());

        $this->expectException(RuntimeException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage(sprintf('could not read file "%s"', $file1->url()));

        $object();
    }
}
