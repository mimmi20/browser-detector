<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Loader;

use BrowserDetector\Loader\BrowserLoader;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

/**
 * Test class for \BrowserDetector\Loader\BrowserLoader
 */
class BrowserLoaderTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Loader\BrowserLoader
     */
    private $object = null;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $adapter      = new Local(__DIR__ . '/../../cache/');
        $cache        = new FilesystemCachePool(new Filesystem($adapter));
        $this->object = new BrowserLoader($cache);
    }

    public function testLoadNotAvailable()
    {
        $this->expectException('\BrowserDetector\Loader\NotFoundException');
        $this->expectExceptionMessage('the browser with key "does not exist" was not found');

        $this->object->load('does not exist', 'test-ua');
    }
}
