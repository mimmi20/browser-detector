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
use Stringy\Stringy;

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
        $this->object = new DarwinFactory($loader);
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
                'Macintosh',
                'Macintosh',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
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
            [
                'Safari/9537.85.10.17.1 CFNetwork/673.5 Darwin/13.4.0 (x86_64) (iMac11%2C3)',
                'iMac',
                'iMac',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'Safari/9537.85.11.5 CFNetwork/673.5 Darwin/13.4.0 (x86_64) (MacBookPro5%2C1)',
                'MacBook Pro',
                'MacBook Pro',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'Safari/7534.53.10 CFNetwork/520.3.2 Darwin/11.3.0 (x86_64) (MacBookAir4%2C1)',
                'MacBook Air',
                'MacBook Air',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'Safari/6534.59.10 CFNetwork/454.12.4 Darwin/10.8.0 (i386) (MacBook4%2C1)',
                'MacBook',
                'MacBook',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'Unibox/283 CFNetwork/673.5 Darwin/13.4.0 (x86_64) (Macmini5%2C2)',
                'Mac Mini',
                'Mac Mini',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'Safari/6534.59.10 CFNetwork/454.12.4 Darwin/10.8.0 (i386) (MacPro4%2C1)',
                'MacPro',
                'MacPro',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'Safari5533.22.3 CFNetwork/438.16 Darwin/9.8.0 (Power%20Macintosh) (PowerMac12%2C1)',
                'PowerMac',
                'PowerMac',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'Safari/12602.1.50 CFNetwork/807.0.1 Darwin/16.0.0 (x86_64)',
                'Macintosh',
                'Macintosh',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'Safari/12602.1.43 CFNetwork/802.1 Darwin/16.0.0 (x86_64)',
                'Macintosh',
                'Macintosh',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'Safari/12602.1.32.7 CFNetwork/790.2 Darwin/16.0.0 (x86_64)',
                'Macintosh',
                'Macintosh',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'Safari/10600.1.25.1 CFNetwork/720.1.1 Darwin/14.0.0 (x86_64)',
                'Macintosh',
                'Macintosh',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'Unibox/283 CFNetwork/718 Darwin/14.0.0 (x86_64)',
                'Macintosh',
                'Macintosh',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'Unibox/189 CFNetwork/714 Darwin/14.0.0 (x86_64)',
                'Macintosh',
                'Macintosh',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'MobileSafari/600.1.4 CFNetwork/711.5.6 Darwin/14.0.0',
                'general Apple Device',
                'general Apple Device',
                'Apple Inc',
                'Apple',
                'Mobile Device',
                true,
                'touchscreen',
            ],
            [
                'MobileSafari/600.1.4 CFNetwork/709.1 Darwin/14.0.0',
                'general Apple Device',
                'general Apple Device',
                'Apple Inc',
                'Apple',
                'Mobile Device',
                true,
                'touchscreen',
            ],
            [
                'Unibox/190 CFNetwork/708.1 Darwin/14.0.0 (x86_64)',
                'Macintosh',
                'Macintosh',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'Unibox/190 CFNetwork/705 Darwin/14.0.0 (x86_64)',
                'Macintosh',
                'Macintosh',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'com.apple.WebKit.WebContent/10538.39.41 CFNetwork/699 Darwin/14.0.0 (x86_64)',
                'Macintosh',
                'Macintosh',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'Unibox/190 CFNetwork/696.0.2 Darwin/14.0.0 (x86_64))',
                'Macintosh',
                'Macintosh',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'Safari/9537.85.11.5 CFNetwork/673.5 Darwin/13.4.0 (x86_64) (MacBookPro5%2C1)',
                'MacBook Pro',
                'MacBook Pro',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'MobileSafari/9537.53 CFNetwork/672.1.14 Darwin/14.0.0',
                'general Apple Device',
                'general Apple Device',
                'Apple Inc',
                'Apple',
                'Mobile Device',
                true,
                'touchscreen',
            ],
            [
                'MobileSafari/8536.25 CFNetwork/609 Darwin/13.0.0',
                'general Apple Device',
                'general Apple Device',
                'Apple Inc',
                'Apple',
                'Mobile Device',
                true,
                'touchscreen',
            ],
            [
                'MobileSafari/8536.25 CFNetwork/602 Darwin/13.0.0',
                'general Apple Device',
                'general Apple Device',
                'Apple Inc',
                'Apple',
                'Mobile Device',
                true,
                'touchscreen',
            ],
            [
                'Safari/8537.85.12.18 CFNetwork/596.6.3 Darwin/12.6.0 (x86_64) (MacBookPro7%2C1)',
                'MacBook Pro',
                'MacBook Pro',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'MobileSafari/7534.48.3 CFNetwork/548.1.4 Darwin/11.0.0',
                'general Apple Device',
                'general Apple Device',
                'Apple Inc',
                'Apple',
                'Mobile Device',
                true,
                'touchscreen',
            ],
            [
                'Safari/7534.20.8 CFNetwork/515.1 Darwin/11.0.0 (x86_64) (MacBook7%2C1)',
                'MacBook',
                'MacBook',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'MobileSafari/6533.18.5 CFNetwork/485.13.9 Darwin/11.0.0',
                'general Apple Device',
                'general Apple Device',
                'Apple Inc',
                'Apple',
                'Mobile Device',
                true,
                'touchscreen',
            ],
            [
                'MobileSafari/531.21.10 CFNetwork/467.12 Darwin/10.3.1',
                'general Apple Device',
                'general Apple Device',
                'Apple Inc',
                'Apple',
                'Mobile Device',
                true,
                'touchscreen',
            ],
            [
                'MobileSafari/528.16 CFNetwork/459 Darwin/10.0.0d3',
                'general Apple Device',
                'general Apple Device',
                'Apple Inc',
                'Apple',
                'Mobile Device',
                true,
                'touchscreen',
            ],
            [
                'Safari5531.9 CFNetwork/422.15.2 Darwin/9.6.0 (i386) (MacBookPro5%2C1)',
                'MacBook Pro',
                'MacBook Pro',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'Safari/5526.11.2 CFNetwork/339.5 Darwin/9.5.0 (Power%20Macintosh) (PowerMac3,4)',
                'PowerMac',
                'PowerMac',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
        ];
    }
}
