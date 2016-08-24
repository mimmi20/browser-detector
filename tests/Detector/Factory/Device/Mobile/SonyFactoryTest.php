<?php

namespace BrowserDetectorTest\Detector\Factory\Device\Mobile;

use BrowserDetector\Detector\Factory\Device\Mobile\SonyFactory;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class SonyFactoryTest extends \PHPUnit_Framework_TestCase
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
        $result = SonyFactory::detect($agent);

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
                'SonyEricssonCK15i/R3AE017 TelecaBrowser/Q07C1-1 Profile/MIDP-2.0 Configuration/CLDC-1.1',
                'CK15i',
                'CK15i',
                'SonyEricsson',
                'SonyEricsson',
                'unknown',
                'unknown',
                'unknown',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; MT27i Build/6.1.1.B.1.54) U2/1.0.0 UCBrowser/10.6.0.706 Mobile',
                'MT27i',
                'Xperia Sola',
                'SonyEricsson',
                'SonyEricsson',
                'unknown',
                'unknown',
                'unknown',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.3.1; de-de; Xperia T Build/JLS36I) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30 CyanogenMod/10.2.0/mint',
                'LT30p',
                'Xperia T',
                'Sony',
                'Sony',
                'unknown',
                'unknown',
                'unknown',
            ],
        ];
    }
}
