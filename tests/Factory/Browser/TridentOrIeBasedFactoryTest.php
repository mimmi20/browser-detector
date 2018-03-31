<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Factory\Browser;

use BrowserDetector\Cache\Cache;
use BrowserDetector\Factory\Browser\TridentOrIeBasedFactory;
use BrowserDetector\Factory\PlatformFactory;
use BrowserDetector\Loader\BrowserLoader;
use BrowserDetector\Loader\PlatformLoader;
use BrowserDetectorTest\Factory\BrowserTestDetectTrait;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Simple\FilesystemCache;

class TridentOrIeBasedFactoryTest extends TestCase
{
    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Seld\JsonLint\ParsingException
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->markTestSkipped();
//        $cache  = new FilesystemCache('', 0, 'cache/');
//        $logger = new NullLogger();
//        $loader = BrowserLoader::getInstance(new Cache($cache), $logger);
//
//        $loader->warmupCache();
//
//        $this->object = new TridentOrIeBasedFactory($loader);
//
//        $platformLoader = PlatformLoader::getInstance(new Cache($cache), $logger);
//
//        $platformLoader->warmupCache();
//
//        $this->platformFactory = new PlatformFactory($platformLoader);
    }

    use BrowserTestDetectTrait;

    /**
     * @return array[]
     */
    public function providerDetect()
    {
        return json_decode(file_get_contents('tests/data/factory/browser/ie-based.json'), true);
    }
}
