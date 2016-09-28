<?php

namespace BrowserDetectorTest\Detector\Factory\Device\Mobile;

use BrowserDetector\Detector\Factory\Device\Mobile\LgFactory;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class LgFactoryTest extends \PHPUnit_Framework_TestCase
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
        $result = LgFactory::detect($agent);

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
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; Nexus 4 Build/LMY48T) U2/1.0.0 UCBrowser/10.5.0.668 Mobile',
                'Nexus 4',
                'Nexus 4',
                'LG',
                'Google',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (LG/GD880 Browser/AppleWebKit/531 Widget/LGMW/3.0 MMS/LG-MMS-V1.0/1.2 MediaPlayer/LGPlayer/1.0 Java/ASVM/1.1 Profile/MIDP-2.1 Configuration/CLDC-1.1)',
                'GD880',
                'GD880',
                'LG',
                'LG',
                'Mobile Phone',
                null,
                'touchscreen',
            ],
            [
                'LG-GS290/V100 Obigo/WAP2.0 Profile/MIDP-2.1 Configuration/CLDC-1.1',
                'GS290',
                'GS290',
                'LG',
                'LG',
                'Mobile Phone',
                null,
                null,
            ],
            [
                'LG-H345/V10f Player/LG Player 1.0 for Android 5.1.1 (stagefright alternative)',
                'H345',
                'Leon 4G LTE',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.4.2; tr-tr; LG-D802TR Build/KOT49I.D802TR20c) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/30.0.1599.103 Mobile Safari/537.36',
                'D802TR',
                'G2',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 5.0; en-us; LG-D855 Build/LRX21R.A1421650137) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/34.0.1847.118 Mobile Safari/537.36',
                'D855',
                'G2',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.4.2; ko-kr; LG-F240K/20h Build/KOT49I.F240K20h) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/30.0.1599.103 Mobile Safari/537.36',
                'F240K',
                'Optimus G Pro',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; LG-D320 Build/KOT49I.A1413827496) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.36',
                'D320',
                'L70',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0.1; LG-H320 Build/LRX21Y) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.36',
                'H320',
                'Leon',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Dalvik/2.1.0 (Linux; U; Android 6.0.1; LG-H850 Build/MMB29M)',
                'H850',
                'G5',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; LG-D290 Build/KOT49I.A1452595206) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.81 Mobile Safari/537.36',
                'D290',
                'L Fino',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; LG-D290 Build/KOT49I.A1452595206) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.81 Mobile Safari/537.36',
                'D290',
                'L Fino',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; LG-D955 Build/KOT49I.D95520b) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.36',
                'D955',
                'G2',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MTC20F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2826.2 Mobile Safari/537.36',
                'Nexus 5X',
                'Nexus 5X',
                'LG',
                'Google',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; Nexus 5 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.114 Mobile Safari/537.36',
                'Nexus 5',
                'Nexus 5',
                'LG',
                'Google',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.1.1; LG-V935 Build/LMY47V) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Safari/537.36',
                'V935',
                'G Pad II 10.1 LTE',
                'LG',
                'LG',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0.2; LG-X150 Build/LRX21M) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.36',
                'X150',
                'Bello II',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; LG-D373 Build/KOT49I.A1406608409) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.81 Mobile Safari/537.36',
                'D373',
                'L80',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.1.2; LG-D682TR Build/JZO54K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.108 Mobile Safari/537.36',
                'D682TR',
                'G Pro Lite',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.1.2; LG-D682 Build/JZO54K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.108 Mobile Safari/537.36',
                'D682',
                'D682',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.1.2; LG-E425 Build/JZO54K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.59 Mobile Safari/537.36 OPR/26.0.1656.87080',
                'E425',
                'Optimus L3 II',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.1.2; uk-ua; LG-E612 Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/2162D3',
                'E612',
                'Optimus L5 Dual',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.4.2; en-US; LG-D415 Build/KOT49I.D41510e) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1 UCBrowser/9.8.0.534 Mobile',
                'D415',
                'Optimus L90',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; LG-D325 Build/KOT49I.A1401767730) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.10549 YaBrowser/13.12.1599.10549 Mobile Safari/537.36',
                'D325',
                'L70 Dual',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 5.0.1; ru-ru; LG-D856 Build/LRX22G) AppleWebKit/537.16 (KHTML, like Gecko) Version/4.0 Mobile Safari/537.16',
                'D856',
                'G3 Dual LTE',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; LG-F220K Build/KOT49I.F220K20c) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/30.0.0.0 Mobile Safari/537.36 ACHEETAHI/2100501080',
                'F220K',
                'Optimus GK',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.4.2; en-us; LG-D958 Build/KOT49I.D95820a) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/30.0.1599.103 Mobile Safari/537.36',
                'D958',
                'G Flex',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'UCWEB/2.0 (MIDP-2.0; U; Adr 4.0.4; ru; LG-P765) U2/1.0.0 UCBrowser/9.7.0.520 U2/1.0.0 Mobile',
                'P765',
                'Optimus L9 (India)',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 6.0; LG-H525n Build/MRA58K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.97 Mobile Safari/537.36',
                'H525N',
                'G4c',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.1.2; LG-E460 Build/JZO54K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.36',
                'E460',
                'Optimus L5 II',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.4.2; ru; LG-D690 Build/KOT49I.A1413286746) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 UCBrowser/9.9.2.467 U3/0.8.0 Mobile Safari/534.30',
                'D690',
                'G3 Stylus',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0.1; LG-H340n Build/LRX21Y) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.36',
                'H340N',
                'Leon 4G LTE',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.0.4; LG-P970 Build/IMM76L) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.166 Mobile Safari/535.19',
                'P970',
                'Optimus Black',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; LG-V490 Build/KOT49I.A1441782698) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Safari/537.36',
                'V490',
                'G Pad 8.0 4G LTE',
                'LG',
                'LG',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; LG-D620 Build/KOT49I.A1404447153) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.36',
                'D620',
                'D620',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.4; LG-D410 Build/KTU84Q) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.109 Mobile Safari/537.36',
                'D410',
                'Optimus L90 Dual',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; ru-ru; LG-E615 Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30 SRCHAPP CHANNEL_normal_install UUID_0472bb87bfdf4e0ded70426f78b9722a',
                'E615',
                'Optimus L5 Dual',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; LG-E989 Build/KOT49I.E98920b) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.38 Mobile Safari/537.36',
                'E989',
                'Optimus G Pro 5.5',
                'LG',
                'LG',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
        ];
    }
}
