<?php

namespace BrowserDetectorTest\Detector\Factory\Device\Mobile;

use BrowserDetector\Detector\Factory\Device\Mobile\BlackBerryFactory;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class BlackBerryFactoryTest extends \PHPUnit_Framework_TestCase
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
        $result = BlackBerryFactory::detect($agent);

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
                'BlackBerry9000/4.6.0.126 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/285',
                'BlackBerry 9000',
                'Bold',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'clickwheel',
            ],
            [
                'BlackBerry9700/5.0.0.321 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/604',
                'BlackBerry 9700',
                'Bold',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'clickwheel',
            ],
            [
                'BlackBerry8100/4.5.0.55 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/107',
                'BlackBerry 8100',
                'BlackBerry 8100',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                null,
                'clickwheel',
            ],
            [
                'BlackBerry8520/5.0.0.1075 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/168',
                'BlackBerry 8520',
                'Curve',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'clickwheel',
            ],
            [
                'Opera/9.80 (J2ME/MIDP; Opera Mini/9 (Compatible; MSIE:9.0; iPhone; BlackBerry9700; AppleWebKit/24.746; U; en) Presto/2.5.25 Version/10.54',
                'BlackBerry 9700',
                'Bold',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'clickwheel',
            ],
            [
                'Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; it) AppleWebKit/534.8+ (KHTML, like Gecko) Version/6.0.0.668 Mobile Safari/534.8+',
                'BlackBerry 9800',
                'Torch',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
        ];
    }
}
