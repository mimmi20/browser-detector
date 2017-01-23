<?php

namespace BrowserDetectorTest\Factory\Device\Mobile;

use BrowserDetector\Factory\Device\Mobile\SharpFactory;
use BrowserDetector\Loader\DeviceLoader;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class SharpFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BrowserDetector\Factory\Device\Mobile\SharpFactory
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
        $this->object = new SharpFactory($cache, $loader);
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
        $result = $this->object->detect($agent);

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
                'Mozilla/5.0 (Linux; U; Android 4.0.4; ja-jp; SH-10D Build/S4180; DOCOMO; mediatap) 720X1184 SHARP SH-10D AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
                'SH-10D',
                'SH-10D',
                'Sharp Corporation',
                'NTT DoCoMo',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'SHARP-TQ-GX30i/1.0 Profile/MIDP-1.0 Configuration/CLDC-1.0 UP.Browser/6.2.2.6.c.1.104 (GUI)',
                'TQ-GX30i',
                'TQ-GX30i',
                'Sharp Corporation',
                'Sharp',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; 306SH Build/S8216) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.81 Mobile Safari/537.36',
                '306SH',
                'Aquos Crystal',
                'Sharp Corporation',
                'Sprint',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
        ];
    }
}
