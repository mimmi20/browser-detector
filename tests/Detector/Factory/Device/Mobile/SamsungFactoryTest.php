<?php

namespace BrowserDetectorTest\Detector\Factory\Device\Mobile;

use BrowserDetector\Detector\Factory\Device\Mobile\SamsungFactory;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class SamsungFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerDetect
     *
     * @param string $agent
     * @param string $deviceName
     * @param string $marketingName
     * @param string $manufacturer
     * @param string $brand
     */
    public function testDetect($agent, $deviceName, $marketingName, $manufacturer, $brand)
    {
        /** @var \UaResult\Device\DeviceInterface $result */
        $result = SamsungFactory::detect($agent);

        self::assertInstanceOf('\UaResult\Device\DeviceInterface', $result);
        self::assertSame($deviceName, $result->getDeviceName());
        self::assertSame($marketingName, $result->getMarketingName());
        self::assertSame($manufacturer, $result->getManufacturer());
        self::assertSame($brand, $result->getBrand());

        self::assertInternalType('string', $result->getManufacturer());
    }

    /**
     * @return array[]
     */
    public function providerDetect()
    {
        return [
            [
                'SAMSUNG-GT-C3312R Opera/9.80 (X11; Linux zvav; U; en) Presto/2.12.423 Version/12.16',
                'GT-C3312R',
                'GT-C3312R',
                'Samsung',
                'Samsung',
            ],
            [
                'SAMSUNG-GT-C3350/C3350MBULF1 NetFront/4.2 Profile/MIDP-2.0 Configuration/CLDC-1.1',
                'GT-C3350',
                'GT-C3350',
                'Samsung',
                'Samsung',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; SM-A500F Build/LRX22G) U2/1.0.0 UCBrowser/10.6.8.732 Mobile',
                'SM-A500F',
                'Galaxy A5',
                'Samsung',
                'Samsung',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0.2; SM-A500FU Build/LRX22G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.133 Mobile Safari/537.36',
                'SM-A500FU',
                'Galaxy A5 (Europe)',
                'Samsung',
                'Samsung',
            ],
        ];
    }
}
