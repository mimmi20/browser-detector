<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
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

    /**
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testInvokeFail(): void
    {
        vfsStream::setup(self::DATA_PATH);

        $baseDir = vfsStreamWrapper::getRoot();

        $dir = vfsStream::newDirectory('invalid');
        $baseDir->addChild($dir);

        $file1 = vfsStream::newFile('bot.json');
        $file1->withContent('{\'key\': \'value\'}');

        $dir->addChild($file1);

        $object = new Data($dir->url(), 'json');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('file "vfs://root/invalid/bot.json" contains invalid json');
        $this->expectExceptionCode(0);

        $object();
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testInvokeSuccess(): void
    {
        vfsStream::setup(self::DATA_PATH);

        $baseDir = vfsStreamWrapper::getRoot();

        $dir = vfsStream::newDirectory('valid');
        $baseDir->addChild($dir);

        $file1 = vfsStream::newFile('tool.json');
        $file1->withContent('{"rules": {"abc": "xyz"}}');

        $dir->addChild($file1);

        $key   = 'rules';
        $value = ['abc' => 'xyz'];

        $object = new Data($dir->url(), 'json');

        self::assertFalse($object->isInitialized());

        $object();

        self::assertTrue($object->isInitialized());

        $object();

        self::assertTrue($object->isInitialized());
        self::assertTrue($object->hasItem($key));
        self::assertEquals((object) $value, $object->getItem($key));
        self::assertCount(1, $object);

        self::assertFalse($object->hasItem('key3'));
        self::assertNull($object->getItem('key3'));
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testInvokeSuccess2(): void
    {
        vfsStream::setup(self::DATA_PATH);

        $baseDir = vfsStreamWrapper::getRoot();

        $dir = vfsStream::newDirectory('valid');
        $baseDir->addChild($dir);

        $file1 = vfsStream::newFile('tool.json');
        $file1->withContent('{"rules": {"abc": "xyz"}}');

        $file2 = vfsStream::newFile('tool2.json');
        $file2->withContent('{"rules": {"abc2": "xyz2"}, "key3": {"abc3": "value3"}}');

        $dir->addChild($file1);
        $dir->addChild($file2);

        $key   = 'rules';
        $value = ['abc' => 'xyz'];

        $object = new Data($dir->url(), 'json');

        self::assertFalse($object->isInitialized());

        $object();

        self::assertTrue($object->isInitialized());

        $object();

        self::assertTrue($object->isInitialized());
        self::assertTrue($object->hasItem($key));
        self::assertEquals((object) $value, $object->getItem($key));
        self::assertCount(2, $object);

        self::assertTrue($object->hasItem('key3'));
        self::assertEquals((object) ['abc3' => 'value3'], $object->getItem('key3'));
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testInvokeFail2(): void
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

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testInvokeSuccess3(): void
    {
        vfsStream::setup(self::DATA_PATH);

        $baseDir = vfsStreamWrapper::getRoot();

        $dir = vfsStream::newDirectory('valid');
        $baseDir->addChild($dir);

        $file1 = vfsStream::newFile('tool.json');
        $file1->withContent('{"aix": {"abc": "xyz"}}');

        $file2 = vfsStream::newFile('tool2.json5');
        $file2->withContent(
            '{"aix": {"abc2": "xyz2"}, "amiga os": {"abc3": "value3"}, "test": "test", "42": {"abc4": "test4"}}',
        );

        $file3 = vfsStream::newFile('tool2.json');
        $file3->withContent(
            '{"aix": {"abc2": "xyz2"}, "amiga os": {"abc3": "value3"}, "test": "test", "42": {"abc4": "test4"}}',
        );

        $dir->addChild($file1);
        $dir->addChild($file2);
        $dir->addChild($file3);

        $key   = 'aix';
        $value = ['abc' => 'xyz'];

        $object = new Data($dir->url(), 'json');

        self::assertFalse($object->isInitialized());

        $object();

        self::assertTrue($object->isInitialized());

        $object();

        self::assertTrue($object->isInitialized());
        self::assertTrue($object->hasItem($key));
        self::assertEquals((object) $value, $object->getItem($key));
        self::assertCount(3, $object);

        self::assertTrue($object->hasItem('amiga os'));
        self::assertEquals((object) ['abc3' => 'value3'], $object->getItem('amiga os'));

        self::assertFalse($object->hasItem('test'));

        self::assertTrue($object->hasItem('42'));
        self::assertEquals((object) ['abc4' => 'test4'], $object->getItem('42'));
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function testInvokeSuccess4(): void
    {
        vfsStream::setup(self::DATA_PATH);

        $baseDir = vfsStreamWrapper::getRoot();

        $dir = vfsStream::newDirectory('valid.json');
        $baseDir->addChild($dir);

        $file1 = vfsStream::newFile('tool.json');
        $file1->withContent('{"aix": {"abc": "xyz"}}');

        $file2 = vfsStream::newFile('tool2.json5');
        $file2->withContent(
            '{"aix": {"abc2": "xyz2"}, "amiga os": {"abc3": "value3"}, "test": "test", "42": {"abc4": "test4"}}',
        );

        $file3 = vfsStream::newFile('tool2.json');
        $file3->withContent(
            '{"aix": {"abc2": "xyz2"}, "amiga os": {"abc3": "value3"}, "test": "test", "42": {"abc4": "test4"}}',
        );

        $dir->addChild($file1);
        $dir->addChild($file2);
        $dir->addChild($file3);

        $key   = 'aix';
        $value = ['abc' => 'xyz'];

        $object = new Data($dir->url(), 'json');

        self::assertFalse($object->isInitialized());

        $object();

        self::assertTrue($object->isInitialized());

        $object();

        self::assertTrue($object->isInitialized());
        self::assertTrue($object->hasItem($key));
        self::assertEquals((object) $value, $object->getItem($key));
        self::assertCount(3, $object);

        self::assertTrue($object->hasItem('amiga os'));
        self::assertEquals((object) ['abc3' => 'value3'], $object->getItem('amiga os'));

        self::assertFalse($object->hasItem('test'));

        self::assertTrue($object->hasItem('42'));
        self::assertEquals((object) ['abc4' => 'test4'], $object->getItem('42'));
    }
}
