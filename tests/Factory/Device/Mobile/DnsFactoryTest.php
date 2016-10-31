<?php

namespace BrowserDetectorTest\Factory\Device\Mobile;

use BrowserDetector\Factory\Device\Mobile\DnsFactory;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class DnsFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BrowserDetector\Factory\Device\Mobile\DnsFactory
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
        $this->object = new DnsFactory($cache);
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
                'Mozilla/5.0 (Linux; U; Android 4.1.2; ru; s4502 Build/JZO54K) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 UCBrowser/9.6.3.413 U3/0.8.0 Mobile Safari/533.1',
                'S4502',
                'S4502',
                'DNS',
                'DNS',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'UCWEB/2.0 (MIDP-2.0; U; Adr 4.1.2; ru; S4501M) U2/1.0.0 UCBrowser/10.1.1.570 U2/1.0.0 Mobile',
                'S4501M',
                'S4501M',
                'DNS',
                'DNS',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.1.2; ru; s4502m Build/JZO54K) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 UCBrowser/9.6.3.413 U3/0.8.0 Mobile Safari/533.1',
                'S4502M',
                'S4502M',
                'DNS',
                'DNS',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.1.2; S4503Q Build/JZO54K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.72 Mobile Safari/537.36 OPR/16.0.1212.63780',
                'S4503Q',
                'S4503Q',
                'DNS',
                'DNS',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
        ];
    }
}
