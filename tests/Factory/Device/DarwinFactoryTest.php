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
namespace BrowserDetectorTest\Factory\Device;

use BrowserDetector\Factory\Device\DarwinFactory;
use BrowserDetector\Loader\DeviceLoader;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

/**
 * Test class for \BrowserDetector\Factory\Device\DarwinFactory
 */
class DarwinFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Factory\Platform\DarwinFactory
     */
    private $object = null;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $adapter      = new Local(__DIR__ . '/../../../cache/');
        $cache        = new FilesystemCachePool(new Filesystem($adapter));
        $loader       = new DeviceLoader($cache);
        $this->object = new DarwinFactory($cache, $loader);
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
        /** @var \UaResult\Device\DeviceInterface $result */
        list($result) = $this->object->detect($agent);

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
                'Mercury/894 CFNetwork/758.5.3 Darwin/15.6.0',
                'general Apple Device',
                'general Apple Device',
                'Apple Inc',
                'Apple',
                'Mobile Device',
                true,
                'touchscreen',
            ],
            [
                'Unibox/377 CFNetwork/796 Darwin/16.0.0 (x86_64)',
                'Macintosh',
                'Macintosh',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'Unibox/283 CFNetwork/760.6.3 Darwin/15.6.0 (x86_64)',
                'Macintosh',
                'Macintosh',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'Unibox/87 CFNetwork/798.3 Darwin/16.0.0',
                'Macintosh',
                'Macintosh',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'MobileSafari/601.1 CFNetwork/757 Darwin/15.0.0',
                'general Apple Device',
                'general Apple Device',
                'Apple Inc',
                'Apple',
                'Mobile Device',
                true,
                'touchscreen',
            ],
            [
                'TestApp/1.0 CFNetwork/808.2.16 Darwin/16.3.0',
                'general Apple Device',
                'general Apple Device',
                'Apple Inc',
                'Apple',
                'Mobile Device',
                true,
                'touchscreen',
            ],
        ];
    }
}
