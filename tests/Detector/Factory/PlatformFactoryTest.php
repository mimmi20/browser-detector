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

        //self::assertInstanceOf('\UaResult\Company\CompanyInterface', $result->getManufacturer());
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
                '8.1',
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.2; Trident/4.0; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; .NET4.0C; .NET4.0E)',
                'Windows',
                'XP.0',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.3; de-de; GT-I9300 Build/JSS15J) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'Android',
                '4.3',
            ],
            [
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko)',
                'Mac OS X',
                '10.10',
            ],
            [
                'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; Touch; rv:11.0) like Gecko',
                'Windows',
                '8.1',
            ],
            [
                'Mozilla/5.0 (BB10; Touch) AppleWebKit/537.35+ (KHTML, like Gecko) Version/10.2.2.1609 Mobile Safari/537.35+',
                'RIM OS',
                '10.2',
            ],
            [
                'Mozilla/5.0 (Nintendo 3DS; U; ; de) Version/1.7567.EU',
                'Nintendo OS',
                '0.0',
            ],
            [
                'Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; NOKIA; Lumia 930) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537',
                'Windows Phone OS',
                '8.1',
            ],
            [
                'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36 Edge/12.0',
                'Windows',
                '10.0',
            ],
            [
                'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5; U; fr-CA) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/234.83 Safari/534.6 Touchpad/1.0',
                'webOS',
                '3.0.5',
            ],
            [
                'SAMSUNG-SGH-T528g/T528UDKE4[TF355314045027030009640018153425713] Dolfin/1.5 SMM-MMS/1.2.0 profile/MIDP-2.1 configuration/CLDC-1.1',
                'Java',
                'unknown',
            ],
            [
                'SonyEricssonS312/R1EA Browser/OpenWave/1.0 Profile/MIDP-2.1 Configuration/CLDC-1.1',
                'Java',
                '0.0',
            ],
            [
                'Huawei/1.0/HUAWEI-G7300 Browser/Opera MMS/1.0 Profile/MIDP-2.0 Configuration/CLDC-1.1 Opera/9.80 (MTK; Nucleus; Opera Mobi/4000; U; it-IT) Presto/2.5.28 Version/10.10',
                'Android',
                'unknown',
            ],
            [
                'SAMSUNG-GT-E3309T Opera/9.80 (J2ME/MIDP; Opera Mini/4.4.34189/34.1016; U; en) Presto/2.8.119 Version/11.10',
                'Java',
                '0.0',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; AX5_Duo) U2/1.0.0 UCBrowser/8.8.1.359 Mobile',
                'Android',
                'unknown',
            ],
            [
                'MicromaxX650 ASTRO36_TD/v3 MAUI/10A1032MP_ASTRO_W1052 Release/31.12.2010 Browser/Opera Sync/SyncClient1.1 Profile/MIDP-2.0 Configuration/CLDC-1.1 Opera/9.80 (MTK; U; en-US) Presto/2.5.28 Version/10.10',
                'Java',
                '0.0',
            ],
            [
                'Opera/9.80 (MAUI Runtime; Opera Mini/4.4.31762/34.1000; U; en) Presto/2.8.119 Version/11.10',
                'Android',
                'unknown',
            ],
            [
                'SAMSUNG-GT-B7722/DDKD1 SHP/VPP/R5 Dolfin/1.5 Nextreaming SMM-MMS/1.2.0 profile/MIDP-2.1 configuration/CLDC-1.1',
                'Java',
                '0.0',
            ],
            [
                'Opera/9.80 (SpreadTrum; Opera Mini/4.4.31492/34.1000; U; en) Presto/2.8.119 Version/11.10',
                'Android',
                'unknown',
            ],
        ];
    }
}
