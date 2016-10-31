<?php

namespace BrowserDetectorTest\Factory\Device\Mobile;

use BrowserDetector\Factory\Device\Mobile\PipoFactory;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class PipoFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BrowserDetector\Factory\Device\Mobile\PipoFactory
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
        $this->object = new PipoFactory($cache);
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
            $result->getManufacturer(),
            'Expected manufacturer name to be "' . $manufacturer . '" (was "' . $result->getManufacturer() . '")'
        );
        self::assertSame(
            $brand,
            $result->getBrand(),
            'Expected brand name to be "' . $brand . '" (was "' . $result->getBrand() . '")'
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
                'Mozilla/5.0 (Linux; U; Android 4.2.2; en-US; M7T Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 UCBrowser/10.4.1.565 U3/0.8.0 Mobile Safari/534.30',
                'M7T',
                'M7T 3G',
                'PiPO Technology',
                'PiPO',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; ru-ru; M83g Build/M83g-eng 4.0.4 IMM76D test-keys_OTA:MID_2.1.1.1_20130207.131452) AppleWebKit/537.16 (KHTML, like Gecko) Version/4.0 Safari/537.16',
                'M8 3G',
                'Max M8 3G',
                'PiPO Technology',
                'PiPO',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.2; uk-ua; M6 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30 [FB_IAB/FB4A;FBAV/31.0.0.20.13;]',
                'M6',
                'M6',
                'PiPO Technology',
                'PiPO',
                'Tablet',
                true,
                'touchscreen',
            ],
        ];
    }
}
