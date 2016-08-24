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
                'unknown',
                'unknown',
                'unknown',
            ],
            [
                'SYM.S200.SYM.T63.DEWAV60A_64_11B_HW (MRE/3.1.00(1280);MAUI/_DY33891_Symphony_L102;BDATE/2014/04/18 14:22;LCD/240320;CHIP/MT6260;KEY/Normal;TOUCH/0;CAMERA/1;SENSOR/0;DEV/DEWAV60A_64_11B_HW;WAP Browser/MAUI (HTTP PGDL;HTTPS);GMOBI/001;MBOUNCE/002;MOMAGIC/003;INDEX/004;SPICEI2I/005;GAMELOFT/006;) Y3389_DY33891_Symphony_L102 Release/2014.04.18 WAP Browser/MAUI (HTTP PGDL; HTTPS) Profile/  Q03C1-2.40 en-US',
                'I2I',
                'I2I',
                'Spice',
                'Spice',
                'unknown',
                'unknown',
                'unknown',
            ],
        ];
    }
}
