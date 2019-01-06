<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Loader\Helper;

use BrowserDetector\Loader\Helper\Filter;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;

class FilterTest extends TestCase
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
            'dir' => [
                'bot.txt' => 'some text',
                'bot.json' => '{"key": "value"}',
                'tool.json' => '{"key2": "value2"}',
            ],
        ];

        $this->root = vfsStream::setup(self::DATA_PATH, null, $structure);
    }

    /**
     * @return void
     */
    public function testInvokeFail(): void
    {
        $object = new Filter();

        $result = $object(vfsStream::url(self::DATA_PATH . '/dir'), 'json');

        self::assertInstanceOf(\Iterator::class, $result);

        $counter = 0;

        foreach ($result as $file) {
            self::assertInstanceOf(\SplFileInfo::class, $file);
            ++$counter;
        }

        self::assertSame(2, $counter);
    }
}
