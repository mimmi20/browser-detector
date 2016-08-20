<?php

namespace BrowserDetectorTest\Detector\Factory\Device;

use BrowserDetector\Detector\Factory\Device\TvFactory;

/**
 * Test class for \BrowserDetector\Detector\Device\Tv\GeneralTv
 */
class TvFactoryTest extends \PHPUnit_Framework_TestCase
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
        $result = TvFactory::detect($agent);

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
                'Opera/9.80 (Linux armv6l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0;THOMSON LF1V401; en) Presto/2.10.250 Version/11.60',
                'LF1V401',
                'LF1V401',
                'Thomson',
                'Thomson',
            ],
            [
                'Opera/9.80 (Linux armv6l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0;THOMSON LF1V394; en) Presto/2.10.250 Version/11.60',
                'LF1V394',
                'LF1V394',
                'Thomson',
                'Thomson',
            ],
            [
                'Opera/9.80 (Linux armv6l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0;THOM LF1V373; en) Presto/2.10.250 Version/11.60',
                'LF1V373',
                'LF1V373',
                'Thomson',
                'Thomson',
            ],
            [
                'Opera/9.80 (Linux armv7l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0;Vendor/THOMSON;SW-Version/V8-MT51F01-LF1V325;Cnt/HRV;Lan/swe; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0) Presto/2.12.362 Version/12.11',
                'LF1V325',
                'LF1V325',
                'Thomson',
                'Thomson',
            ],
            [
                'Opera/9.80 (Linux armv7l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0;Vendor/THOM;SW-Version/V8-MT51F01-LF1V307;Cnt/DEU;Lan/bul) Presto/2.12.362 Version/12.11',
                'LF1V307',
                'LF1V307',
                'Thomson',
                'Thomson',
            ],
            [
                'AppleCoreMedia/1.0.0.12F69 (Apple TV; U; CPU OS 8_3 like Mac OS X; en_us)',
                'AppleTV',
                'AppleTV',
                'Apple Inc',
                'Apple',
            ],
        ];
    }
}
