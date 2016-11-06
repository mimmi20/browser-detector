<?php

namespace BrowserDetectorTest\Loader;

use BrowserDetector\Loader\PlatformLoader;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

/**
 * Test class for \BrowserDetector\Loader\PlatformLoader
 */
class PlatformLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BrowserDetector\Loader\PlatformLoader
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
        $this->object = new PlatformLoader($cache);
    }

    /**
     * @expectedException \BrowserDetector\Loader\NotFoundException
     * @expectedExceptionMessage the platform with key "does not exist" was not found
     */
    public function testLoadNotAvailable()
    {
        $this->object->load('does not exist', 'test-ua');
    }
}
