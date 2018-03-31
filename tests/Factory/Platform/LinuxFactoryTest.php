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
namespace BrowserDetectorTest\Factory\Platform;

use BrowserDetector\Cache\Cache;
use BrowserDetector\Factory\Platform\LinuxFactory;
use BrowserDetector\Loader\PlatformLoader;
use BrowserDetectorTest\Factory\PlatformTestDetectTrait;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Simple\FilesystemCache;

class LinuxFactoryTest extends TestCase
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
//        $loader = PlatformLoader::getInstance(new Cache($cache), $logger);
//
//        $loader->warmupCache();
//
//        $this->object = new LinuxFactory($loader);
    }

    use PlatformTestDetectTrait;

    /**
     * @return array[]
     */
    public function providerDetect()
    {
        return json_decode(file_get_contents('tests/data/factory/platform/linux.json'), true);
    }
}
