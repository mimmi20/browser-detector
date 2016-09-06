<?php

namespace BrowserDetectorTest\Detector\Factory\Device\Mobile;

use BrowserDetector\Detector\Factory\Device\Mobile\SamsungFactory;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class SamsungFactoryTest extends \PHPUnit_Framework_TestCase
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
        $result = SamsungFactory::detect($agent);

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
                'SAMSUNG-GT-C3312R Opera/9.80 (X11; Linux zvav; U; en) Presto/2.12.423 Version/12.16',
                'GT-C3312R',
                'GT-C3312R',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                null,
                'touchscreen',
            ],
            [
                'SAMSUNG-GT-C3350/C3350MBULF1 NetFront/4.2 Profile/MIDP-2.0 Configuration/CLDC-1.1',
                'GT-C3350',
                'GT-C3350',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                null,
                'touchscreen',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; SM-A500F Build/LRX22G) U2/1.0.0 UCBrowser/10.6.8.732 Mobile',
                'SM-A500F',
                'Galaxy A5',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0.2; SM-A500FU Build/LRX22G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.133 Mobile Safari/537.36',
                'SM-A500FU',
                'Galaxy A5 (Europe)',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; GT-N7100) U2/1.0.0 UCBrowser/10.1.2.571 Mobile',
                'GT-N7100',
                'Galaxy Note II',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; GT-I9001) U2/1.0.0 UCBrowser/9.8.0.534 Mobile',
                'GT-I9001',
                'GT-I9001',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (SAMSUNG; SAMSUNG-GT-S8530-VODAFONE/S8530BUJL1; U; Bada/1.2; de-de) AppleWebKit/533.1 (KHTML, like Gecko) Dolfin/2.2 Mobile WVGA SMM-MMS/1.2.0 NexPlayer/3.0 profile/MIDP-2.1 configuration/CLDC-1.1 OPN-B',
                'GT-S8530',
                'Wave 2',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; GT-S6312 Build/JZO54K) U2/1.0.0 UCBrowser/10.2.0.584 Mobile',
                'GT-S6312',
                'Galaxy Young DUOS',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (SAMSUNG; SAMSUNG-GT-S8500/S8500CXKG1; U; Bada/1.0; pl-pl) AppleWebKit/533.1 (KHTML, like Gecko) Dolfin/2.0 Mobile WVGA SMM-MMS/1.2.0 NexPlayer/3.0 profile/MIDP-2.1 configuration/CLDC-1.1 OPN-B',
                'GT-S8500',
                'Wave',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; GT-I8160 Build/GINGERBREAD) U2/1.0.0 UCBrowser/10.1.4.573 Mobile',
                'GT-I8160',
                'Galaxy Ace 2',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'UCWEB/2.0(Linux; U; Opera Mini/7.1.32052/30.3697; en-US; GT-I9100 Build/JZO54K) U2/1.0.0 UCBrowser/10.5.0.575 Mobile',
                'GT-I9100',
                'Galaxy S II',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (SAMSUNG; SAMSUNG-GT-S7230E/S723EBWJK1; U; Bada/1.0; de-de) AppleWebKit/533.1 (KHTML, like Gecko) Dolfin/2.0 Mobile WQVGA SMM-MMS/1.2.0 NexPlayer/3.0 profile/MIDP-2.1 configuration/CLDC-1.1 OPN-B',
                'GT-S7230E',
                'Wave 723',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'UCWEB/2.0(Linux; U; Opera Mini/7.1.32052/30.3697; en-US; GT-I8190 Build/JZO54K) U2/1.0.0 UCBrowser/10.5.2.582 Mobile',
                'GT-I8190',
                'Galaxy S III Mini',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; GT-I9300) U2/1.0.0 UCBrowser/9.7.0.520 Mobile',
                'GT-I9300',
                'Galaxy S III',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (SAMSUNG; SAMSUNG-GT-S5250/S5250XXKB2; U; Bada/1.0; de-de) AppleWebKit/533.1 (KHTML, like Gecko) Dolfin/2.0 Mobile WQVGA SMM-MMS/1.2.0 OPN-B',
                'GT-S5250',
                'GT-S5250',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                null,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; de-de; GT-I9070 Build/GINGERBREAD) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Safari/533.1',
                'GT-I9070',
                'Galaxy S Advance',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; SM-P600 Build/LMY47X) U2/1.0.0 UCBrowser/10.7.2.757 Mobile',
                'SM-P600',
                'Galaxy Note 10.1 2014 Edition Wi-Fi',
                'Samsung',
                'Samsung',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'UCWEB/2.0(Linux; U; Opera Mini/7.1.32052/30.3697; en-US; GT-I9205 Build/KOT49H) U2/1.0.0 UCBrowser/10.6.2.599 Mobile',
                'GT-I9205',
                'Galaxy Mega 6.3',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Mozilla/5.0 (Linux; U; Android 4.5.1; en-US; GT-N9000 Build/IMM87D) AppleWebKit/534.12 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.199',
                'GT-N9000',
                'Galaxy Note 3 3G',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'SAMSUNG-GT-B2710/B2710BOLD1 SHP/VPP/R5 Dolfin/2.0 QTV/5.3 SMM-MMS/1.2.0 profile/MIDP-2.1 configuration/CLDC-1.1 OPN-B',
                'GT-B2710',
                'GT-B2710',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                null,
                null,
            ],
            [
                'SAMSUNG-SGH-F480/F480AOIC1 SHP/VPP/R5 NetFront/3.4 Qtv5.3 SMM-MMS/1.2.0 profile/MIDP-2.0 configuration/CLDC-1.1',
                'SGH-F480',
                'SGH-F480',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                null,
                null,
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; GT-I8160P Build/JZO54K) U2/1.0.0 UCBrowser/10.1.4.573 Mobile',
                'GT-I8160P',
                'Galaxy Ace 2 NFC',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; GT-I9195) U2/1.0.0 UCBrowser/9.7.0.520 Mobile',
                'GT-I9195',
                'Galaxy S4 Mini',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; SM-N9005 Build/LRX21V) U2/1.0.0 UCBrowser/10.7.6.805 Mobile',
                'SM-N9005',
                'Galaxy Note 3 LTE',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Windows NT 6.2; ARM; Trident/7.0; Touch; rv:11.0; WPDesktop; SGH-T899M) like Gecko',
                'SGH-T899M',
                'Ativ S',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'unused/0 (SCH-S720C GINGERBREAD); gzip',
                'SCH-S720C',
                'Galaxy Proclaim',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0.2; SAMSUNG SM-G925F Build/LRX22G) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/4.0 Chrome/44.0.2403.133 Mobile Safari/537.36',
                'SM-G925F',
                'Galaxy S6 Edge (Global)',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Dalvik/2.1.0 (Linux; U; Android 6.0.1; Nexus Player Build/MMB29T)',
                'Nexus Player',
                'Nexus Player',
                'Samsung',
                'Samsung',
                'Media Player',
                false,
                null,
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.4; GT-I9195I Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.130 Crosswalk/14.43.343.17 Mobile Safari/537.36',
                'GT-I9195I',
                'Galaxy S4 Mini LTE',
                'Samsung',
                'Samsung',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
        ];
    }
}
