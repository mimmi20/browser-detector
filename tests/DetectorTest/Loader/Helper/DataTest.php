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

use BrowserDetector\Loader\Helper\Data;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

final class DataTest extends TestCase
{
    private const DATA_PATH = 'root';

    public function testInvokeFail(): void
    {
        $structure = [
            'invalid' => ['bot.json' => "{'key': 'value'}"],
        ];

        vfsStream::setup(self::DATA_PATH, null, $structure);

        $object = new Data(vfsStream::url(self::DATA_PATH . '/invalid'), 'json');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('file "vfs://root/invalid/bot.json" contains invalid json');
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
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \InvalidArgumentException
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
}
