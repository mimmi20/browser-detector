<?php

namespace BrowserDetectorTest\Detector\Factory\Device\Mobile;

use BrowserDetector\Detector\Factory\Device\Mobile\TechnisatFactory;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class TechnisatFactoryTest extends \PHPUnit_Framework_TestCase
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
        $result = TechnisatFactory::detect($agent);

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
                'Mozilla/5.0 (Linux; U; Android 4.2.2; de-de; AQIPAD_7G Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'Aqiston Aqipad 7G',
                'Aqiston Aqipad 7G',
                'TechniSat',
                'TechniSat',
            ],
        ];
    }
}
