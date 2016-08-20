<?php

namespace BrowserDetectorTest\Detector\Factory\Device\Mobile;

use BrowserDetector\Detector\Factory\Device\Mobile\SpiceFactory;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class SpiceFactoryTest extends \PHPUnit_Framework_TestCase
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
        $result = SpiceFactory::detect($agent);

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
                'Spice QT-75',
                'QT-75',
                'QT-75',
                'Spice',
                'Spice',
            ],
        ];
    }
}
