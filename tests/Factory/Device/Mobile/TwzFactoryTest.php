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

use BrowserDetector\Factory\Device\Mobile\TwzFactory;
use BrowserDetector\Loader\DeviceLoader;
use BrowserDetectorTest\Factory\DeviceTestDetectTrait;
use Stringy\Stringy;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class TwzFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Factory\Device\Mobile\TwzFactory
     */
    private $object = null;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $cache        = new FilesystemAdapter('', 0, __DIR__ . '/../../../../cache/');
        $loader       = new DeviceLoader($cache);
        $this->object = new TwzFactory($loader);
    }

    use DeviceTestDetectTrait;

    /**
     * @return array[]
     */
    public function providerDetect()
    {
        return json_decode(file_get_contents('tests/data/factory/device/mobile/twz.json'), true);
    }
}
