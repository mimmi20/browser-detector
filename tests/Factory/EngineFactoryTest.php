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
use BrowserDetector\Version\Version;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Stringy\Stringy;
use BrowserDetector\Cache\Cache;
use Symfony\Component\Cache\Simple\FilesystemCache;
use UaResult\Engine\EngineInterface;

class EngineFactoryTest extends TestCase
{
    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $cache        = new FilesystemCache('', 0, 'cache/');
        $logger       = new NullLogger();
        $loader       = EngineLoader::getInstance(new Cache($cache), $logger);
        $this->object = new EngineFactory($loader);

        $platformLoader        = PlatformLoader::getInstance(new Cache($cache), $logger);

        $platformLoader->warmupCache();

        $this->platformFactory = new PlatformFactory($platformLoader);

        $this->browserLoader   = BrowserLoader::getInstance(new Cache($cache), $logger);

        $this->browserLoader->warmupCache();

        $this->browserLoader->warmupCache();
    }

    use EngineTestDetectTrait;

    /**
     * @return array[]
     */
    public function providerDetect()
    {
        return json_decode(file_get_contents('tests/data/factory/engine.json'), true);
    }
}
