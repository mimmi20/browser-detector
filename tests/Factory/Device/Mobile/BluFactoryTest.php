<?php

namespace BrowserDetectorTest\Factory\Device\Mobile;

use BrowserDetector\Factory\Device\Mobile\BluFactory;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class BluFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BrowserDetector\Factory\Device\Mobile\BluFactory
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
        $this->object = new BluFactory($cache);
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
                'Mozilla/5.0 (Windows Phone 8.1; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; BLU; WIN HD LTE; BLU 000-33) like Gecko',
                'Win HD LTE',
                'Win HD LTE',
                'BLU',
                'BLU',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; BLU; WIN JR LTE; BLU 000-33) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537',
                'Win JR LTE',
                'Win JR LTE',
                'BLU',
                'BLU',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; BLU; WIN HD W510u) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537',
                'Win HD W510u',
                'Win HD W510u',
                'BLU',
                'BLU',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; BLU; WIN JR W410a) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537',
                'Win JR W410a',
                'Win JR W410a',
                'BLU',
                'BLU',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Windows NT 10.0; ARM; WIN JR LTE) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Safari/537.36 Edge/13.10586',
                'Win JR LTE',
                'Win JR LTE',
                'BLU',
                'BLU',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.1; ru-ru; STUDIO 5.5 Build/JOP40D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30 [FB_IAB/FB4A;FBAV/30.0.0.19.17;]',
                'Studio 5.5',
                'Studio 5.5',
                'BLU',
                'BLU',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
        ];
    }
}
