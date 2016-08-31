<?php

namespace BrowserDetectorTest\Detector\Factory\Device;

use BrowserDetector\Detector\Factory\Device\DarwinFactory;

/**
 * Test class for \BrowserDetector\Detector\Factory\Device\DarwinFactory
 */
class DarwinFactoryTest extends \PHPUnit_Framework_TestCase
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
        $result = DarwinFactory::detect($agent);

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
                'Mercury/894 CFNetwork/758.5.3 Darwin/15.6.0',
                'general Apple Device',
                'general Apple Device',
                'Apple Inc',
                'Apple',
                'Mobile Device',
                true,
                'touchscreen',
            ],
            [
                'Unibox/377 CFNetwork/796 Darwin/16.0.0 (x86_64)',
                'Macintosh',
                'Macintosh',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'Unibox/283 CFNetwork/760.6.3 Darwin/15.6.0 (x86_64)',
                'Macintosh',
                'Macintosh',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
            [
                'Unibox/87 CFNetwork/798.3 Darwin/16.0.0',
                'Macintosh',
                'Macintosh',
                'Apple Inc',
                'Apple',
                'Desktop',
                false,
                'mouse',
            ],
        ];
    }
}
