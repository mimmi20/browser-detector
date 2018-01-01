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
namespace BrowserDetectorTest\Factory\Device\Mobile;

use BrowserDetector\Cache\Cache;
use BrowserDetector\Factory\Device\Mobile\WoxterFactory;
use BrowserDetector\Loader\DeviceLoader;
use BrowserDetectorTest\Factory\DeviceTestDetectTrait;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Simple\FilesystemCache;

class WoxterFactoryTest extends TestCase
{
    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    protected function setUp(): void
    {
        $cache        = new FilesystemCache('', 0, 'cache/');
        $logger       = new NullLogger();
        $loader       = DeviceLoader::getInstance(new Cache($cache), $logger);

        $loader->warmupCache();

        $this->object = new WoxterFactory($loader);
    }

    use DeviceTestDetectTrait;

    /**
     * @return array[]
     */
    public function providerDetect()
    {
        return json_decode(file_get_contents('tests/data/factory/device/mobile/woxter.json'), true);
    }
}
