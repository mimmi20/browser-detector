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

namespace BrowserDetectorTest\Iterator;

use BrowserDetector\Iterator\FilterIterator;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use UnexpectedValueException;

#[CoversClass(FilterIterator::class)]
final class FilterIteratorTest extends TestCase
{
    private const string DATA_PATH = 'root';

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws UnexpectedValueException
     */
    public function testFilter(): void
    {
        $structure = ['bot.json' => 'test-content'];

        vfsStream::setup(self::DATA_PATH, null, $structure);

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(vfsStream::url(self::DATA_PATH)),
        );
        $files    = new FilterIterator($iterator, 'json');

        self::assertCount(1, $files);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws UnexpectedValueException
     */
    public function testFilter2(): void
    {
        $structure = ['bot.json5' => 'test-content'];

        vfsStream::setup(self::DATA_PATH, null, $structure);

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(vfsStream::url(self::DATA_PATH)),
        );
        $files    = new FilterIterator($iterator, 'json');

        self::assertCount(0, $files);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws UnexpectedValueException
     */
    public function testFilter3(): void
    {
        $structure = ['abc' => ['bot.json' => 'test-content']];

        vfsStream::setup(self::DATA_PATH, null, $structure);

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(vfsStream::url(self::DATA_PATH)),
        );
        $files    = new FilterIterator($iterator, 'json');

        self::assertCount(1, $files);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws UnexpectedValueException
     */
    public function testFilter4(): void
    {
        $structure = ['abc' => ['bot.json5' => 'test-content']];

        vfsStream::setup(self::DATA_PATH, null, $structure);

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(vfsStream::url(self::DATA_PATH)),
        );
        $files    = new FilterIterator($iterator, 'json');

        self::assertCount(0, $files);
    }
}
