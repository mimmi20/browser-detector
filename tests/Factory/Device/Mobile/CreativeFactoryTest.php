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

use BrowserDetector\Factory\Device\Mobile\CreativeFactory;
use BrowserDetector\Loader\DeviceLoader;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Stringy\Stringy;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class CreativeFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Factory\Device\Mobile\CreativeFactory
     */
    private $object = null;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $adapter      = new Local(__DIR__ . '/../../../../cache/');
        $cache        = new FilesystemCachePool(new Filesystem($adapter));
        $loader       = new DeviceLoader($cache);
        $this->object = new CreativeFactory($loader);
    }

    /**
     * @dataProvider providerDetect
     *
     * @param string $agent
     * @param string $deviceName
     * @param string $marketingName
     * @param string $manufacturer
     * @param string $brand
     * @param string $deviceType
     * @param bool   $dualOrientation
     * @param string $pointingMethod
     */
    public function testDetect($agent, $deviceName, $marketingName, $manufacturer, $brand, $deviceType, $dualOrientation, $pointingMethod)
    {
        $s = new Stringy($agent);

        /** @var \UaResult\Device\DeviceInterface $result */
        list($result) = $this->object->detect($agent, $s);

        self::assertInstanceOf('\UaResult\Device\DeviceInterface', $result);

        self::assertSame(
            $deviceName,
            $result->getDeviceName(),
            'Expected device name to be "' . $deviceName . '" (was "' . $result->getDeviceName() . '")'
        );
        self::assertSame(
            $marketingName,
            $result->getMarketingName(),
            'Expected marketing name to be "' . $marketingName . '" (was "' . $result->getMarketingName() . '")'
        );
        self::assertSame(
            $manufacturer,
            $result->getManufacturer()->getName(),
            'Expected manufacturer name to be "' . $manufacturer . '" (was "' . $result->getManufacturer()->getName() . '")'
        );
        self::assertSame(
            $brand,
            $result->getBrand()->getBrandName(),
            'Expected brand name to be "' . $brand . '" (was "' . $result->getBrand()->getBrandName() . '")'
        );
        self::assertSame(
            $deviceType,
            $result->getType()->getName(),
            'Expected device type to be "' . $deviceType . '" (was "' . $result->getType()->getName() . '")'
        );
        self::assertSame(
            $dualOrientation,
            $result->getDualOrientation(),
            'Expected dual orientation to be "' . $dualOrientation . '" (was "' . $result->getDualOrientation() . '")'
        );
        self::assertSame(
            $pointingMethod,
            $result->getPointingMethod(),
            'Expected pointing method to be "' . $pointingMethod . '" (was "' . $result->getPointingMethod() . '")'
        );
    }

    /**
     * @return array[]
     */
    public function providerDetect()
    {
        return [
            [
                'this is a fake ua to trigger the fallback',
                'general Creative Device',
                'general Creative Device',
                'Creative',
                'Creative',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.2.1; ZiiLABS ZiiO10  Build/v2.00.07-FROYO) AppleWebKit/528.18 (KHTML, like Gecko) Version/4.0 Mobile Safari/528.16',
                'ZiiO 10',
                'ZiiO 10',
                'Creative',
                'Creative',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.2.1; ZiiLABS ZiiO7  Build/v2.00.13-FROYO) AppleWebKit/528.18 (KHTML, like Gecko) Version/4.0 Mobile Safari/528.16',
                'ZiiO7',
                'ZiiO7',
                'Creative',
                'Creative',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                '"Mozilla/5.0 (Linux; U; Android 2.1-update2; en-; ZiiO7 Build/v1.00.28-ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17',
                'ZiiO7',
                'ZiiO7',
                'Creative',
                'Creative',
                'Tablet',
                true,
                'touchscreen',
            ],
        ];
    }
}
