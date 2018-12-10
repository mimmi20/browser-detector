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
namespace BrowserDetectorTest\Factory;

use BrowserDetector\Factory\Device\DarwinParser;
use BrowserDetector\Factory\Device\DesktopParser;
use BrowserDetector\Factory\Device\MobileParser;
use BrowserDetector\Factory\Device\TvParser;
use BrowserDetector\Factory\DeviceFactory;
use BrowserDetector\Loader\DeviceLoaderFactory;
use BrowserDetector\Loader\GenericLoader;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class DeviceFactoryTest extends TestCase
{
    /**
     * @var \BrowserDetector\Factory\DeviceFactory
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new DeviceFactory();
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     *
     * @return void
     */
    public function testToArray(): void
    {
        self::markTestIncomplete();
    }
}
