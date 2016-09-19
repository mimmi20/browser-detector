<?php

namespace BrowserDetectorTest\Detector\Factory\Device\Mobile;

use BrowserDetector\Detector\Factory\Device\Mobile\ZteFactory;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class ZteFactoryTest extends \PHPUnit_Framework_TestCase
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
        $result = ZteFactory::detect($agent);

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
                'Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0; ZTE; Tania)',
                'Tania',
                'Tania',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'ZTE-G-X991-Rio-orange/X991_V1_Z2_FRES_D18F109 Profile/MIDP-2.0 Configuration/CLDC-1.1 Obigo/Q03C',
                'G-X991',
                'Rio',
                'ZTE',
                'Orange',
                'Mobile Phone',
                null,
                null,
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0.2; ZTE Blade V6 Build/LRX22G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.36',
                'Blade V6',
                'Blade V6',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.1.2; zh-cn; ZTE N919 Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30; 360 Aphone Browser (6.9.9.89beta)',
                'N919',
                'N919',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.1; ZTE Blade L5 Plus Build/LMY47I; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/52.0.2743.98 Mobile Safari/537.36',
                'Blade L5 Plus',
                'Blade L5 Plus',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.1; ZTE Blade L6 Build/LMY47I) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.36',
                'Blade L6',
                'Blade L6',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.4; Beeline Pro Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 YaBrowser/14.12.2125.9740.00 Mobile Safari/537.36',
                'Beeline Pro',
                'Beeline Pro',
                'ZTE',
                'ZTE',
                'Tablet',
                true,
                'touchscreen',
            ],
        ];
    }
}
