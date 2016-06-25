<?php

namespace BrowserDetectorTest\Detector\Factory;

use BrowserDetector\Detector\Factory\PlatformFactory;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class PlatformFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerDetect
     *
     * @param string $agent
     * @param string $platform
     * @param string $version
     */
    public function testDetect($agent, $platform, $version)
    {
        /** @var \UaResult\Os\OsInterface $result */
        $result = PlatformFactory::detect($agent);

        self::assertInstanceOf('\UaResult\Os\OsInterface', $result);
        self::assertSame($platform, $result->getName());

        self::assertInstanceOf('\BrowserDetector\Version\Version', $result->getVersion());
        self::assertSame($version, $result->getVersion()->getVersion());
    }

    /**
     * @return array[]
     */
    public function providerDetect()
    {
        return [
            [
                'Mozilla/5.0 (iPad; CPU OS 8_1_2 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12B440 Safari/600.1.4',
                'iOS',
                '8.1.2',
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.2; Trident/4.0; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; .NET4.0C; .NET4.0E)',
                'Windows',
                'XP.0.0',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.3; de-de; GT-I9300 Build/JSS15J) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'Android',
                '4.3.0',
            ],
            [
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko)',
                'Mac OS X',
                '10.10.1',
            ],
            [
                'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; Touch; rv:11.0) like Gecko',
                'Windows',
                '8.1.0',
            ],
            [
                'Mozilla/5.0 (BB10; Touch) AppleWebKit/537.35+ (KHTML, like Gecko) Version/10.2.2.1609 Mobile Safari/537.35+',
                'RIM OS',
                '10.2.2.1609',
            ],
            [
                'Mozilla/5.0 (Nintendo 3DS; U; ; de) Version/1.7567.EU',
                'Nintendo OS',
                '0.0.0',
            ],
            [
                'Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; NOKIA; Lumia 930) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537',
                'Windows Phone OS',
                '8.1.0',
            ],
            [
                'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36 Edge/12.0',
                'Windows',
                '10.0.0',
            ],
            [
                'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5; U; fr-CA) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/234.83 Safari/534.6 Touchpad/1.0',
                'webOS',
                '3.0.5',
            ],
            [
                'SAMSUNG-SGH-T528g/T528UDKE4[TF355314045027030009640018153425713] Dolfin/1.5 SMM-MMS/1.2.0 profile/MIDP-2.1 configuration/CLDC-1.1',
                'Java',
                '0.0.0',
            ],
            [
                'SonyEricssonS312/R1EA Browser/OpenWave/1.0 Profile/MIDP-2.1 Configuration/CLDC-1.1',
                'Java',
                '0.0.0',
            ],
            [
                'Huawei/1.0/HUAWEI-G7300 Browser/Opera MMS/1.0 Profile/MIDP-2.0 Configuration/CLDC-1.1 Opera/9.80 (MTK; Nucleus; Opera Mobi/4000; U; it-IT) Presto/2.5.28 Version/10.10',
                'Android',
                '0.0.0',
            ],
            [
                'SAMSUNG-GT-E3309T Opera/9.80 (J2ME/MIDP; Opera Mini/4.4.34189/34.1016; U; en) Presto/2.8.119 Version/11.10',
                'Java',
                '0.0.0',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; AX5_Duo) U2/1.0.0 UCBrowser/8.8.1.359 Mobile',
                'Android',
                '0.0.0',
            ],
            [
                'MicromaxX650 ASTRO36_TD/v3 MAUI/10A1032MP_ASTRO_W1052 Release/31.12.2010 Browser/Opera Sync/SyncClient1.1 Profile/MIDP-2.0 Configuration/CLDC-1.1 Opera/9.80 (MTK; U; en-US) Presto/2.5.28 Version/10.10',
                'Java',
                '0.0.0',
            ],
            [
                'Opera/9.80 (MAUI Runtime; Opera Mini/4.4.31762/34.1000; U; en) Presto/2.8.119 Version/11.10',
                'Android',
                '0.0.0',
            ],
            [
                'SAMSUNG-GT-B7722/DDKD1 SHP/VPP/R5 Dolfin/1.5 Nextreaming SMM-MMS/1.2.0 profile/MIDP-2.1 configuration/CLDC-1.1',
                'Java',
                '0.0.0',
            ],
            [
                'Opera/9.80 (SpreadTrum; Opera Mini/4.4.31492/34.1000; U; en) Presto/2.8.119 Version/11.10',
                'Android',
                '0.0.0',
            ],
            [
                'Wget/1.17.1 (cygwin)',
                'Cygwin',
                '0.0.0',
            ],
            [
                'Opera/9.80 (VRE; Opera Mini/4.2/34.1000; U; en) Presto/2.8.119 Version/11.10',
                'Android',
                '0.0.0',
            ],
            [
                'Mozilla/5.0 AppleWebKit/536.30.1 (KHTML, like Gecko) Version/6.0.5 Safari/536.30.1 Installatron (Mimicking WebKit)',
                'Linux',
                '0.0.0',
            ],
            [
                'Mozilla/5.0 (X11; U; Linux i686; rv:1.9a3pre) Gecko/20070330',
                'Linux',
                '0.0.0',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.1; AT10-A Build/JOP40D) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.102 Safari/537.36',
                'Android',
                '4.2.1',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; SM-T235 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.102 Safari/537.36',
                'Android',
                '4.4.2',
            ],
            [
                'Mozilla/5.0 (Windows NT 6.2; ARM; Trident/7.0; Touch; rv:11.0; WPDesktop; Lumia 928) like Gecko',
                'Windows Phone OS',
                '8.1.0',
            ],
            [
                'Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; NOKIA; Lumia 920; Vodafone ES) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537',
                'Windows Phone OS',
                '8.1.0',
            ],
            [
                'ASTRO36_TD/v3 MAUI/10A1032MP_ASTRO_W1052 Release/31.12.2010 Browser/Opera Profile/MIDP-2.0 Configuration/CLDC-1.1 Sync/SyncClient1.1 Opera/9.80 (MTK; U; en-US) Presto/2.5.28 Version/10.10',
                'Java',
                '0.0.0',
            ],
            [
                'YUANDA50_12864_11B_HW (MRE\\2.5.00(800) resolution\\320480 chipset\\MT6250 touch\\1 tpannel\\1 camera\\1 gsensor\\0 keyboard\\reduced) C529AH_JY_539_W1.11B.V2.2 Release/2012.09.26 WAP Browser/MAUI (HTTP PGDL; HTTPS) Profile/ Q03C1-2.40 fr-FR',
                'Java',
                '0.0.0',
            ],
            [
                'SYM.S200.SYM.T63.DEWAV60A_64_11B_HW (MRE/3.1.00(1280);MAUI/_DY33891_Symphony_L102;BDATE/2014/04/18 14:22;LCD/240320;CHIP/MT6260;KEY/Normal;TOUCH/0;CAMERA/1;SENSOR/0;DEV/DEWAV60A_64_11B_HW;WAP Browser/MAUI (HTTP PGDL;HTTPS);GMOBI/001;MBOUNCE/002;MOMAGIC/003;INDEX/004;SPICEI2I/005;GAMELOFT/006;) Y3389_DY33891_Symphony_L102 Release/2014.04.18 WAP Browser/MAUI (HTTP PGDL; HTTPS) Profile/  Q03C1-2.40 en-US',
                'Java',
                '0.0.0',
            ],
            [
                'Dorado WAP-Browser/1.0.0',
                'Java',
                '0.0.0',
            ],
            [
                'Lynx/2.8.5rel.1 libwww-FM/2.15FC SSL-MM/1.4.1c OpenSSL/0.9.7e-dev',
                'Java',
                '0.0.0',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.1.2; de-de; CINK PEAX 2 Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'Android',
                '4.1.2',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; ru; HTC T328w Build/IML74K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 UCBrowser/9.8.9.457 U3/0.8.0 Mobile Safari/534.30',
                'Android',
                '4.0.4',
            ],
            [
                'UCWEB/2.0 (MIDP-2.0; U; Adr 4.2.0; ru; iPhone5) U2/1.0.0 UCBrowser/10.1.2.571 U2/1.0.0 Mobile',
                'Android',
                '4.2.0',
            ],
        ];
    }
}
