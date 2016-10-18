<?php

namespace BrowserDetectorTest\Detector\Factory\Device\Mobile;

use BrowserDetector\Detector\Factory\Device\Mobile\TriQFactory;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class TriQFactoryTest extends \PHPUnit_Framework_TestCase
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
        $result = TriQFactory::detect($agent);

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
                'Mozilla/5.0 (Linux; U; Android 4.2.2; ru-ru; AC0732C Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'AC0732C',
                'Q-lite',
                '3Q',
                '3Q',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.1.1; en-us; RC9724C Build/JRO03H) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'RC9724C',
                'Q-pad',
                '3Q',
                '3Q',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; MT0739D Build/JDQ39) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.138 Mobile Safari/537.36',
                'MT0739D',
                'Q-pad',
                '3Q',
                '3Q',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.1.1; en-us;LC0720C Build/JRO03C) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 4.1.1; ru-ru; Build/JRO03CSafari/534.30 ACHEETAHI/2100501072',
                'LC0720C',
                'Q-pad',
                '3Q',
                '3Q',
                'Tablet',
                true,
                'touchscreen',
            ],
        ];
    }
}
