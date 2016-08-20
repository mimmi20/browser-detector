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
        ];
    }
}
