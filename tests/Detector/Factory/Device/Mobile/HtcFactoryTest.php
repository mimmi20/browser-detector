<?php

namespace BrowserDetectorTest\Detector\Factory\Device\Mobile;

use BrowserDetector\Detector\Factory\Device\Mobile\HtcFactory;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class HtcFactoryTest extends \PHPUnit_Framework_TestCase
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
        $result = HtcFactory::detect($agent);

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
                'Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0; HTC; HD7 T9292)',
                'T9292',
                'HD7',
                'HTC',
                'HTC',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0; HTC; 7 Pro T7576)',
                'T7576',
                '7 Pro',
                'HTC',
                'HTC',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'HTC_HD2_T8585/480x800 4.0 (compatible; MSIE 6.0; Windows CE; IEMobile 8.12; MSIEMobile 6.0)',
                'T8585',
                'HD2',
                'HTC',
                'HTC',
                'Mobile Phone',
                false,
                null,
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.1; en-US; One Build/MIUI 4.8.29) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 UCBrowser/10.8.8.730 U3/0.8.0 Mobile Safari/534.30',
                'M7',
                'One',
                'HTC',
                'HTC',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'HTC_Touch_HD_T8282 Opera/9.50 (Windows NT 5.1; U; de)',
                'Touch HD T8282',
                'BlackStone',
                'HTC',
                'HTC',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; HTC_Desire) U2/1.0.0 UCBrowser/10.1.0.563 Mobile',
                'Desire',
                'Desire',
                'HTC',
                'HTC',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Vodafone/1.0/HTC_HD2/1.72.162.0 (82124) Opera/9.7 (Windows NT 5.1; U; de)',
                'HD2',
                'HD2',
                'HTC',
                'HTC',
                'Mobile Phone',
                false,
                null,
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows CE; IEMobile 8.12; MSIEMobile 6.5) Vodafone/1.0/HTC_HD_mini/1.11.162.1 (87652)',
                'mini T5555',
                'mini T5555',
                'HTC',
                'HTC',
                'Mobile Phone',
                null,
                'touchscreen',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; HTC Wildfire Build/FRG83D) U2/1.0.0 UCBrowser/10.1.5.583 Mobile',
                'Wildfire',
                'Wildfire',
                'HTC',
                'HTC',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_3; HTC_Flyer_P512; de-ch) AppleWebKit/533.16 (KHTML, like Gecko) Version/5.0 Safari/533.16',
                'Flyer',
                'Flyer',
                'HTC',
                'HTC',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (compatible; MSIE 10.0; Windows Phone 8.0; Trident/6.0; IEMobile/10.0; ARM; Touch; HTC; PM23300)',
                'Windows Phone 8X',
                'Windows Phone 8X',
                'HTC',
                'HTC',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0; HTC; TITAN X310e; 4.06.162.01)',
                'X310e',
                'Titan',
                'HTC',
                'HTC',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0; HTC; Radar)',
                'Radar',
                'Radar',
                'HTC',
                'HTC',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0; HTC; 7 Trophy)',
                'Spark',
                '7 Trophy',
                'HTC',
                'HTC',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; de-de; HTC HD2 Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'HD2',
                'HD2',
                'HTC',
                'HTC',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_3; HTC_EVO3D_X515m; de-de) AppleWebKit/533.16 (KHTML, like Gecko) Version/5.0 Safari/533.16',
                'X515m',
                'EVO 3D',
                'HTC',
                'HTC',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_3; HTC_Flyer_P510e; de-de) AppleWebKit/533.16 (KHTML, like Gecko) Version/5.0 Safari/533.16',
                'Flyer',
                'Flyer',
                'HTC',
                'HTC',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 7.0; Windows Phone OS 7.0; Trident/3.1; IEMobile/7.0; HTC; 0P6B180)',
                '0P6B180',
                'One M8 for Windows',
                'HTC',
                'HTC',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_3; HTC_DesireHD_A9191; de-de) AppleWebKit/533.16 (KHTML, like Gecko) Version/5.0 Safari/533.16',
                'A9191',
                'Desire HD',
                'HTC',
                'HTC',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
        ];
    }
}
