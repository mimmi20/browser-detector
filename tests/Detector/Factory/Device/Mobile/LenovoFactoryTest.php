<?php

namespace BrowserDetectorTest\Detector\Factory\Device\Mobile;

use BrowserDetector\Detector\Factory\Device\Mobile\LenovoFactory;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class LenovoFactoryTest extends \PHPUnit_Framework_TestCase
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
        $result = LenovoFactory::detect($agent);

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
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; Lenovo_S856) U2/1.0.0 UCBrowser/9.7.0.520 Mobile',
                'S856',
                'S856',
                'Lenovo',
                'Lenovo',
            ],
        ];
    }
}
