<?php

namespace BrowserDetectorTest\Detector\Factory\Device;

use BrowserDetector\Detector\Factory\Device\MobileFactory;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class MobileFactoryTest extends \PHPUnit_Framework_TestCase
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
        $result = MobileFactory::detect($agent);

        self::assertInstanceOf('\UaResult\Device\DeviceInterface', $result);
        self::assertSame($deviceName, $result->getDeviceName());
        self::assertSame($marketingName, $result->getMarketingName());
        self::assertSame($manufacturer, $result->getManufacturer());
        self::assertSame($brand, $result->getBrand());

        self::assertInternalType('string', $result->getManufacturer());
    }

    /**
     * @return array[]
     */
    public function providerDetect()
    {
        return [
            [
                'Dalvik/1.6.0 (Linux; U; Android 4.4.4; MI PAD MIUI/5.11.1)',
                'Mi Pad',
                'Mi Pad',
                'Xiaomi Tech',
                'Xiaomi',
            ],
            [
                'Dalvik/2.1.0 (Linux; U; Android 6.0.1; MI 4LTE MIUI/V7.3.2.0.MXDCNDD) NewsArticle/5.1.3',
                'Mi 4 LTE',
                'Mi 4 LTE',
                'Xiaomi Tech',
                'Xiaomi',
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 4.01; Windows CE; PPC; 240x320; SPV M700; OpVer 19.123.2.733) OrangeBot-Mobile 2008.0 (mobilesearch.support@orange-ftgroup.com)',
                'M700',
                'M700',
                'SPV',
                'SPV',
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows 95; PalmSource; Blazer 3.0) 16; 160x160',
                'Blazer',
                'Blazer',
                'Palm',
                'Palm',
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows CE; Sprint:PPC-6700) Opera 8.65 [en]',
                '6700',
                '6700',
                'Sprint',
                'Sprint',
            ],
            [
                'TIANYU-KTOUCH/A930/Screen-240X320',
                'Tianyu A930',
                'Tianyu A930',
                'K-Touch',
                'K-Touch',
            ],
            [
                'Lemon B556',
                'B556',
                'B556',
                'Lemon',
                'Lemon',
            ],
            [
                'LAVA Spark284/MIDP-2.0 Configuration/CLDC-1.1/Screen-240x320',
                'Spark 284',
                'Spark 284',
                'Lava',
                'Lava',
            ],
            [
                'Spice QT-75',
                'QT-75',
                'QT-75',
                'Spice',
                'Spice',
            ],
            [
                'KKT20/MIDP-2.0 Configuration/CLDC-1.1/Screen-240x320',
                'KKT20',
                'KKT20',
                'Lava',
                'Lava',
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows CE; IEMobile 7.11) Sprint:MotoQ9c',
                'Q9c',
                'Q9c',
                'Motorola',
                'Motorola',
            ],
            [
                'Mozilla/5.0 (Linux; U; en-us; Velocitymicro/T408) AppleWebKit/530.17(KHTML, like Gecko) Version/4.0Safari/530.17',
                'Cruz',
                'T408',
                'Velocity Micro',
                'Velocity Micro',
            ],
            [
                'SAMSUNG-GT-C3312R Opera/9.80 (X11; Linux zvav; U; en) Presto/2.12.423 Version/12.16',
                'GT-C3312R',
                'GT-C3312R',
                'Samsung',
                'Samsung',
            ],
            [
                'SYM.S200.SYM.T63.DEWAV60A_64_11B_HW (MRE/3.1.00(1280);MAUI/_DY33891_Symphony_L102;BDATE/2014/04/18 14:22;LCD/240320;CHIP/MT6260;KEY/Normal;TOUCH/0;CAMERA/1;SENSOR/0;DEV/DEWAV60A_64_11B_HW;WAP Browser/MAUI (HTTP PGDL;HTTPS);GMOBI/001;MBOUNCE/002;MOMAGIC/003;INDEX/004;SPICEI2I/005;GAMELOFT/006;) Y3389_DY33891_Symphony_L102 Release/2014.04.18 WAP Browser/MAUI (HTTP PGDL; HTTPS) Profile/  Q03C1-2.40 en-US',
                'I2I',
                'I2I',
                'Spice',
                'Spice',
            ],
            [
                'Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0; HTC; HD7 T9292)',
                'T9292',
                'HD7',
                'HTC',
                'HTC',
            ],
            [
                'Mozilla/5.0 (Series40; NokiaC2-03/06.96; Profile/MIDP-2.1 Configuration/CLDC-1.1) Gecko/20100401 S40OviBrowser/5.0.0.0.31',
                'C2-03',
                'C2',
                'Nokia',
                'Nokia',
            ],
            [
                'Nokia205/2.0 (03.19) Profile/MIDP-2.1 Configuration/CLDC-1.1 UCWEB/2.0 (Java; U; MIDP-2.0; en-US; Nokia205) U2/1.0.0 UCBrowser/9.5.0.449 U2/1.0.0 Mobile',
                'Asha 205',
                'Asha 205',
                'Nokia',
                'Nokia',
            ],
            [
                'Nokia311/5.0 (03.81) Profile/MIDP-2.1 Configuration/CLDC-1.1 UCWEB/2.0 (Java; U; MIDP-2.0; en-US; Nokia311) U2/1.0.0 UCBrowser/9.5.0.449 U2/1.0.0 Mobile',
                '311',
                'Asha 311',
                'Nokia',
                'Nokia',
            ],
            [
                'NokiaX2-01/5.0 (08.71) Profile/MIDP-2.1 Configuration/CLDC-1.1 UCWEB/2.0 (Java; U; MIDP-2.0; en-US; NokiaX2-01) U2/1.0.0 UCBrowser/9.4.1.377 U2/1.0.0 Mobile',
                'X2-01',
                'X2',
                'Nokia',
                'Nokia',
            ],
            [
                'Nokia110/2.0 (03.47) Profile/MIDP-2.1 Configuration/CLDC-1.1 UCWEB/2.0 (Java; U; MIDP-2.0; en-US; Nokia110) U2/1.0.0 UCBrowser/9.5.0.449 U2/1.0.0 Mobile',
                '110',
                '110',
                'Nokia',
                'Nokia',
            ],
            [
                'NokiaC2-03/2.0 (07.63) Profile/MIDP-2.1 Configuration/CLDC-1.1 UCWEB/2.0 (Java; U; MIDP-2.0; en-US; NokiaC2-03) U2/1.0.0 UCBrowser/9.5.0.449 U2/1.0.0 Mobile',
                'C2-03',
                'C2',
                'Nokia',
                'Nokia',
            ],
            [
                'Nokia206/2.0 (04.52) Profile/MIDP-2.1 Configuration/CLDC-1.1 UCWEB/2.0 (Java; U; MIDP-2.0; en-US; Nokia206) U2/1.0.0 UCBrowser/9.5.0.449 U2/1.0.0 Mobile',
                'Asha 206',
                'Asha 206',
                'Nokia',
                'Nokia',
            ],
            [
                'Nokia200/2.0 (12.04) Profile/MIDP-2.1 Configuration/CLDC-1.1 UCWEB/2.0 (Java; U; MIDP-2.0; en-US; Nokia200) U2/1.0.0 UCBrowser/9.5.0.449 U2/1.0.0 Mobile',
                'Asha 200',
                'Asha 200',
                'Nokia',
                'Nokia',
            ],
            [
                'NokiaX2-02/2.0 (11.57) Profile/MIDP-2.1 Configuration/CLDC-1.1 UCWEB/2.0 (Java; U; MIDP-2.0; en-US; NokiaX2-02) U2/1.0.0 UCBrowser/9.5.0.449 U2/1.0.0 Mobile',
                'X2-02',
                'X2',
                'Nokia',
                'Nokia',
            ],
            [
                'Nokia308/2.0 (05.80) Profile/MIDP-2.1 Configuration/CLDC-1.1 UCWEB/2.0 (Java; U; MIDP-2.0; en-US; Nokia308) U2/1.0.0 UCBrowser/9.5.0.449 U2/1.0.0 Mobile',
                '308',
                '308',
                'Nokia',
                'Nokia',
            ],
            [
                'Nokia305/2.0 (07.42) Profile/MIDP-2.1 Configuration/CLDC-1.1 UCWEB/2.0 (Java; U; MIDP-2.0; en-US; Nokia305) U2/1.0.0 UCBrowser/9.5.0.449 U2/1.0.0 Mobile',
                '305',
                '305',
                'Nokia',
                'Nokia',
            ],
            [
                'NokiaC1-01/2.0 (03.35) Profile/MIDP-2.1 Configuration/CLDC-1.1 nokiac1-01/UC Browser7.6.1.82/69/351 UNTRUSTED/1.0',
                'C1-01',
                'C1',
                'Nokia',
                'Nokia',
            ],
            [
                'Mozilla/5.0 (Symbian/3; Series60/5.3 Nokia500/111.021.0028; Profile/MIDP-2.1 Configuration/CLDC-1.1 ) AppleWebKit/535.1 (KHTML, like Gecko) NokiaBrowser/8.3.1.4 Mobile Safari/535.1 3gpp-gba',
                '500',
                '500',
                'Nokia',
                'Nokia',
            ],
            [
                'Mozilla/5.0 (Series30Plus; Nokia220/10.03.11; Profile/Series30Plus Configuration/Series30Plus) Gecko/20100401 S40OviBrowser/3.8.1.0.5',
                '220',
                'Asha 220',
                'Nokia',
                'Nokia',
            ],
            [
                'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 650) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/13.10586',
                'Lumia 650',
                'Lumia 650',
                'Microsoft',
                'Microsoft',
            ],
            [
                'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 535) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/13.10586',
                'Lumia 535',
                'Lumia 535',
                'Microsoft',
                'Microsoft',
            ],
        ];
    }
}
