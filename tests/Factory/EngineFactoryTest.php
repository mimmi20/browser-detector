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
namespace BrowserDetectorTest\Factory;

use BrowserDetector\Factory\EngineFactory;
use BrowserDetector\Factory\NormalizerFactory;
use BrowserDetector\Factory\PlatformFactory;
use BrowserDetector\Loader\BrowserLoader;
use BrowserDetector\Loader\EngineLoader;
use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Loader\PlatformLoader;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class EngineFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Factory\EngineFactory
     */
    private $object = null;

    /**
     * @var \Psr\Cache\CacheItemPoolInterface|null
     */
    private $cache = null;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $adapter      = new Local(__DIR__ . '/../../cache/');
        $this->cache  = new FilesystemCachePool(new Filesystem($adapter));
        $loader       = new EngineLoader($this->cache);
        $this->object = new EngineFactory($loader);
    }

    /**
     * @dataProvider providerDetect
     *
     * @param string $userAgent
     * @param string $engine
     * @param string $version
     * @param string $manufacturer
     */
    public function testDetect($userAgent, $engine, $version, $manufacturer)
    {
        $normalizer      = (new NormalizerFactory())->build();
        $normalizedUa    = $normalizer->normalize($userAgent);
        $browserLoader   = new BrowserLoader($this->cache);
        $platformFactory = new PlatformFactory(new PlatformLoader($this->cache));

        try {
            $platform = $platformFactory->detect($normalizedUa);
        } catch (NotFoundException $e) {
            $platform = null;
        }

        /** @var \UaResult\Engine\EngineInterface $result */
        $result = $this->object->detect($normalizedUa, $browserLoader, $platform);

        self::assertInstanceOf('\UaResult\Engine\EngineInterface', $result);
        self::assertSame(
            $engine,
            $result->getName(),
            'Expected engine name to be "' . $engine . '" (was "' . $result->getName() . '")'
        );

        self::assertInstanceOf('\BrowserDetector\Version\Version', $result->getVersion());
        self::assertSame(
            $version,
            $result->getVersion()->getVersion(),
            'Expected version to be "' . $version . '" (was "' . $result->getVersion()->getVersion() . '")'
        );

        self::assertSame(
            $manufacturer,
            $result->getManufacturer()->getName(),
            'Expected manufacturer name to be "' . $manufacturer . '" (was "' . $result->getManufacturer()->getName() . '")'
        );
    }

    /**
     * @return array[]
     */
    public function providerDetect()
    {
        return json_decode(file_get_contents('tests/data/factory/engine.json'), true);
    }
}
