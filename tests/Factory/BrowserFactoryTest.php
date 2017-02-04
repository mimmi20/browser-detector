<?php

namespace BrowserDetectorTest\Factory;

use BrowserDetector\Factory\BrowserFactory;
use BrowserDetector\Loader\EngineLoader;
use BrowserDetector\Version\VersionFactory;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use Psr\Log\NullLogger;
use UaResult\Browser\Browser;
use UaResult\Company\Company;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class BrowserFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BrowserDetector\Factory\BrowserFactory
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
        $loader       = new EngineLoader($cache);
        $this->object = new BrowserFactory($cache, $loader);
    }

    public function testToarray()
    {
        $logger = new NullLogger();

        $name         = 'TestBrowser';
        $manufacturer = new Company('unknown', 'unknown');
        $version      = (new VersionFactory())->set('0.0.2-beta');

        $original = new Browser($name, $manufacturer, $version);

        $array  = $original->toArray();
        $object = $this->object->fromArray($logger, $array);

        self::assertSame($name, $object->getName());
        self::assertEquals($manufacturer, $object->getManufacturer());
        self::assertEquals($version, $object->getVersion());
    }
}
