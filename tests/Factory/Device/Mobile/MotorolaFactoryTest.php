<?php

namespace BrowserDetectorTest\Factory\Device\Mobile;

use BrowserDetector\Factory\Device\Mobile\MotorolaFactory;
use BrowserDetector\Loader\DeviceLoader;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class MotorolaFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BrowserDetector\Factory\Device\Mobile\MotorolaFactory
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
        $this->object = new MotorolaFactory($cache, $loader);
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
        list($result,) = $this->object->detect($agent);

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
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows CE; IEMobile 7.11) Sprint:MotoQ9c',
                'Q9c',
                'Q9c',
                'Motorola',
                'Motorola',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'MOT-E1000/80.28.08I MIB/2.2.1 Profile/MIDP-2.0 Configuration/CLDC-1.1',
                'E1000',
                'E1000',
                'Motorola',
                'Motorola',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'MOT-L7/08.D5.09R MIB/2.2.1 Profile/MIDP-2.0 Configuration/CLDC-1.1',
                'SLVR L7',
                'SLVR L7',
                'Motorola',
                'Motorola',
                'Mobile Phone',
                false,
                null,
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; XT389 Build/0C.03.05R_S) U2/1.0.0 UCBrowser/10.7.2.757 Mobile',
                'XT389',
                'Motoluxe XT389',
                'Motorola',
                'Motorola',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'MOT-V3i/08.B4.34R MIB/2.2.1 Profile/MIDP-2.0 Configuration/CLDC-1.1 UP.Link/6.3.0.0.0',
                'RAZR V3i',
                'RAZR V3i',
                'Motorola',
                'Motorola',
                'Mobile Phone',
                false,
                null,
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0.2; XT1068 Build/LXB22.46-28) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.89 Mobile Safari/537.36',
                'XT1068',
                'Moto G Dual SIM (2nd gen)',
                'Motorola',
                'Motorola',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.1.1; MotoG3 Build/LPI23.72-47.4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.36',
                'MotoG3',
                'Moto G (3rd gen)',
                'Motorola',
                'Motorola',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.1; XT1039 Build/LPBS23.13-17.3-1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.36',
                'XT1039',
                'Moto G 4G',
                'Motorola',
                'Motorola',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0.2; Nexus 6 Build/LRX22G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.63 Mobile Safari/537.36',
                'Nexus 6',
                'Nexus 6',
                'Motorola',
                'Google',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0.2; XT1032 Build/LXB22.46-28.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.36',
                'XT1032',
                'Moto G',
                'Motorola',
                'Motorola',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.2.2; ru-ru; MB612 Build/KRNS-X4-1.1.10) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
                'MB612',
                'XPRT (CDMA)',
                'Motorola',
                'Motorola',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.4; XT1080 Build/SU5-24) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.59 Mobile Safari/537.36',
                'XT1080',
                'Droid Ultra',
                'Motorola',
                'Motorola',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.1; XT1021 Build/LPCS23.13-34.8-3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.94 Mobile Safari/537.36',
                'XT1021',
                'Moto E',
                'Motorola',
                'Motorola',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
        ];
    }
}
