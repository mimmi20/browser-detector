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
     * @param string $deviceType
     * @param bool   $dualOrientation
     * @param string $pointingMethod
     */
    public function testDetect($agent, $deviceName, $marketingName, $manufacturer, $brand, $deviceType, $dualOrientation, $pointingMethod)
    {
        /** @var \UaResult\Device\DeviceInterface $result */
        $result = TvFactory::detect($agent);

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
                'Opera/9.80 (Linux armv6l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0;THOMSON LF1V401; en) Presto/2.10.250 Version/11.60',
                'LF1V401',
                'LF1V401',
                'Thomson',
                'Thomson',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux armv6l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0;THOMSON LF1V394; en) Presto/2.10.250 Version/11.60',
                'LF1V394',
                'LF1V394',
                'Thomson',
                'Thomson',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux armv6l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0;THOM LF1V373; en) Presto/2.10.250 Version/11.60',
                'LF1V373',
                'LF1V373',
                'Thomson',
                'Thomson',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux armv7l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0;Vendor/THOMSON;SW-Version/V8-MT51F01-LF1V325;Cnt/HRV;Lan/swe; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0) Presto/2.12.362 Version/12.11',
                'LF1V325',
                'LF1V325',
                'Thomson',
                'Thomson',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux armv7l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0;Vendor/THOM;SW-Version/V8-MT51F01-LF1V307;Cnt/DEU;Lan/bul) Presto/2.12.362 Version/12.11',
                'LF1V307',
                'LF1V307',
                'Thomson',
                'Thomson',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'AppleCoreMedia/1.0.0.12F69 (Apple TV; U; CPU OS 8_3 like Mac OS X; en_us)',
                'AppleTV',
                'AppleTV',
                'Apple Inc',
                'Apple',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Xbox; Xbox One) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/13.10586',
                'Xbox One',
                'Xbox One',
                'Microsoft Corporation',
                'Microsoft',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux armv7l; LOEWE-SL32x/2.2.13.0 HbbTV/1.1.1 (; LOEWE; SL32x; LOH/2.2.13.0;;) CE-HTML/1.0 Config(L:deu,CC:DEU) NETRANGEMMH) Presto/2.12.407 Version/12.51',
                'SL32x',
                'SL32x',
                'Loewe',
                'Loewe',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux mips; ) Presto/2.12.407 Version/12.51 MB97/0.0.39.10 (ALDINORD, Mxl661L32, wireless) VSTVB_MB97',
                'Smart TV',
                'Smart TV',
                'Samsung',
                'Samsung',
                'TV Device',
                false,
                'unknown',
            ],
            [
                'Opera/9.80 (Linux armv7l; InettvBrowser/2.2 (00014A;SonyDTV115;0002;0100) KDL42W655A; CC/DEU) Presto/2.12.362 Version/12.11',
                'KDL42W655A',
                'KDL42W655A',
                'Sony',
                'Sony',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux armv7l; InettvBrowser/2.2 (00014A;SonyDTV115;0002;0100) KDL32W655A; CC/DEU) Presto/2.12.362 Version/12.11',
                'KDL32W655A',
                'KDL32W655A',
                'Sony',
                'Sony',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux armv7l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0;Vendor/TCL;SW-Version/V8-MT51F03-LF1V464;Cnt/POL;Lan/pol) Presto/2.12.362 Version/12.11',
                'LF1V464',
                'LF1V464',
                'Thomson',
                'Thomson',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux armv7l; U; CE-HTML/1.0 NETTV/3.3.0; PHILIPS-AVM-2012; en) Presto/2.9.167 Version/11.50',
                'Blueray Player',
                'Blueray Player',
                'Philips',
                'Philips',
                'Media Player',
                false,
                null,
            ],
        ];
    }
}
