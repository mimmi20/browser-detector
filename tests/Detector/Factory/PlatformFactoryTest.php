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
     * @param string $manufacturer
     */
    public function testDetect($agent, $platform, $version, $manufacturer)
    {
        /** @var \UaResult\Os\OsInterface $result */
        $result = PlatformFactory::detect($agent);

        self::assertInstanceOf('\UaResult\Os\OsInterface', $result);
        self::assertSame($platform, $result->getName());

        self::assertInstanceOf('\BrowserDetector\Version\Version', $result->getVersion());
        self::assertSame($version, $result->getVersion()->getVersion());

        self::assertSame($manufacturer, $result->getManufacturer());
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
                'Apple Inc',
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.2; Trident/4.0; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; .NET4.0C; .NET4.0E)',
                'Windows',
                'XP.0.0',
                'Microsoft Corporation',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.3; de-de; GT-I9300 Build/JSS15J) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'Android',
                '4.3.0',
                'Google Inc',
            ],
            [
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko)',
                'Mac OS X',
                '10.10.1',
                'Apple Inc',
            ],
            [
                'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; Touch; rv:11.0) like Gecko',
                'Windows',
                '8.1.0',
                'Microsoft Corporation',
            ],
            [
                'Mozilla/5.0 (BB10; Touch) AppleWebKit/537.35+ (KHTML, like Gecko) Version/10.2.2.1609 Mobile Safari/537.35+',
                'RIM OS',
                '10.2.2.1609',
                'Research In Motion Limited',
            ],
            [
                'Mozilla/5.0 (Nintendo 3DS; U; ; de) Version/1.7567.EU',
                'Nintendo OS',
                '0.0.0',
                'Nintendo',
            ],
            [
                'Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; NOKIA; Lumia 930) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537',
                'Windows Phone OS',
                '8.1.0',
                'Microsoft Corporation',
            ],
            [
                'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36 Edge/12.0',
                'Windows',
                '10.0.0',
                'Microsoft Corporation',
            ],
            [
                'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5; U; fr-CA) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/234.83 Safari/534.6 Touchpad/1.0',
                'webOS',
                '3.0.5',
                'HP',
            ],
            [
                'SAMSUNG-SGH-T528g/T528UDKE4[TF355314045027030009640018153425713] Dolfin/1.5 SMM-MMS/1.2.0 profile/MIDP-2.1 configuration/CLDC-1.1',
                'Java',
                '0.0.0',
                'Oracle',
            ],
            [
                'SonyEricssonS312/R1EA Browser/OpenWave/1.0 Profile/MIDP-2.1 Configuration/CLDC-1.1',
                'Java',
                '0.0.0',
                'Oracle',
            ],
            [
                'Huawei/1.0/HUAWEI-G7300 Browser/Opera MMS/1.0 Profile/MIDP-2.0 Configuration/CLDC-1.1 Opera/9.80 (MTK; Nucleus; Opera Mobi/4000; U; it-IT) Presto/2.5.28 Version/10.10',
                'Android',
                '0.0.0',
                'Google Inc',
            ],
            [
                'SAMSUNG-GT-E3309T Opera/9.80 (J2ME/MIDP; Opera Mini/4.4.34189/34.1016; U; en) Presto/2.8.119 Version/11.10',
                'Java',
                '0.0.0',
                'Oracle',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; AX5_Duo) U2/1.0.0 UCBrowser/8.8.1.359 Mobile',
                'Android',
                '0.0.0',
                'Google Inc',
            ],
            [
                'MicromaxX650 ASTRO36_TD/v3 MAUI/10A1032MP_ASTRO_W1052 Release/31.12.2010 Browser/Opera Sync/SyncClient1.1 Profile/MIDP-2.0 Configuration/CLDC-1.1 Opera/9.80 (MTK; U; en-US) Presto/2.5.28 Version/10.10',
                'Java',
                '0.0.0',
                'Oracle',
            ],
            [
                'Opera/9.80 (MAUI Runtime; Opera Mini/4.4.31762/34.1000; U; en) Presto/2.8.119 Version/11.10',
                'Android',
                '0.0.0',
                'Google Inc',
            ],
            [
                'SAMSUNG-GT-B7722/DDKD1 SHP/VPP/R5 Dolfin/1.5 Nextreaming SMM-MMS/1.2.0 profile/MIDP-2.1 configuration/CLDC-1.1',
                'Java',
                '0.0.0',
                'Oracle',
            ],
            [
                'Opera/9.80 (SpreadTrum; Opera Mini/4.4.31492/34.1000; U; en) Presto/2.8.119 Version/11.10',
                'Android',
                '0.0.0',
                'Google Inc',
            ],
            [
                'Wget/1.17.1 (cygwin)',
                'Cygwin',
                '0.0.0',
                'unknown',
            ],
            [
                'Opera/9.80 (VRE; Opera Mini/4.2/34.1000; U; en) Presto/2.8.119 Version/11.10',
                'Android',
                '0.0.0',
                'Google Inc',
            ],
            [
                'Mozilla/5.0 AppleWebKit/536.30.1 (KHTML, like Gecko) Version/6.0.5 Safari/536.30.1 Installatron (Mimicking WebKit)',
                'Linux',
                '0.0.0',
                'Linux Foundation',
            ],
            [
                'Mozilla/5.0 (X11; U; Linux i686; rv:1.9a3pre) Gecko/20070330',
                'Linux',
                '0.0.0',
                'Linux Foundation',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.1; AT10-A Build/JOP40D) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.102 Safari/537.36',
                'Android',
                '4.2.1',
                'Google Inc',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; SM-T235 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.102 Safari/537.36',
                'Android',
                '4.4.2',
                'Google Inc',
            ],
            [
                'Mozilla/5.0 (Windows NT 6.2; ARM; Trident/7.0; Touch; rv:11.0; WPDesktop; Lumia 928) like Gecko',
                'Windows Phone OS',
                '8.1.0',
                'Microsoft Corporation',
            ],
            [
                'Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; NOKIA; Lumia 920; Vodafone ES) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537',
                'Windows Phone OS',
                '8.1.0',
                'Microsoft Corporation',
            ],
            [
                'ASTRO36_TD/v3 MAUI/10A1032MP_ASTRO_W1052 Release/31.12.2010 Browser/Opera Profile/MIDP-2.0 Configuration/CLDC-1.1 Sync/SyncClient1.1 Opera/9.80 (MTK; U; en-US) Presto/2.5.28 Version/10.10',
                'Android',
                '0.0.0',
                'Google Inc',
            ],
            [
                'YUANDA50_12864_11B_HW (MRE\\2.5.00(800) resolution\\320480 chipset\\MT6250 touch\\1 tpannel\\1 camera\\1 gsensor\\0 keyboard\\reduced) C529AH_JY_539_W1.11B.V2.2 Release/2012.09.26 WAP Browser/MAUI (HTTP PGDL; HTTPS) Profile/ Q03C1-2.40 fr-FR',
                'Java',
                '0.0.0',
                'Oracle',
            ],
            [
                'SYM.S200.SYM.T63.DEWAV60A_64_11B_HW (MRE/3.1.00(1280);MAUI/_DY33891_Symphony_L102;BDATE/2014/04/18 14:22;LCD/240320;CHIP/MT6260;KEY/Normal;TOUCH/0;CAMERA/1;SENSOR/0;DEV/DEWAV60A_64_11B_HW;WAP Browser/MAUI (HTTP PGDL;HTTPS);GMOBI/001;MBOUNCE/002;MOMAGIC/003;INDEX/004;SPICEI2I/005;GAMELOFT/006;) Y3389_DY33891_Symphony_L102 Release/2014.04.18 WAP Browser/MAUI (HTTP PGDL; HTTPS) Profile/  Q03C1-2.40 en-US',
                'Java',
                '0.0.0',
                'Oracle',
            ],
            [
                'Dorado WAP-Browser/1.0.0',
                'Java',
                '0.0.0',
                'Oracle',
            ],
            [
                'Lynx/2.8.5rel.1 libwww-FM/2.15FC SSL-MM/1.4.1c OpenSSL/0.9.7e-dev',
                'Linux',
                '0.0.0',
                'Linux Foundation',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.1.2; de-de; CINK PEAX 2 Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'Android',
                '4.1.2',
                'Google Inc',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; ru; HTC T328w Build/IML74K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 UCBrowser/9.8.9.457 U3/0.8.0 Mobile Safari/534.30',
                'Android',
                '4.0.4',
                'Google Inc',
            ],
            [
                'UCWEB/2.0 (MIDP-2.0; U; Adr 4.2.0; ru; iPhone5) U2/1.0.0 UCBrowser/10.1.2.571 U2/1.0.0 Mobile',
                'Android',
                '4.2.0',
                'Google Inc',
            ],
            [
                'Opera/9.80 (Linux armv7l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0;Vendor/THOM;SW-Version/V8-MT51F01-LF1V307;Cnt/DEU;Lan/bul) Presto/2.12.362 Version/12.11',
                'Linux Smartphone OS (Maemo)',
                '0.0.0',
                'Linux Foundation',
            ],
            [
                'Dalvik/1.6.0 (Linux; U; Android 4.4.4; MI PAD MIUI/5.11.1)',
                'Miui OS',
                '5.11.1',
                'Xiaomi Tech',
            ],
            [
                'Mozilla/4.0 (compatible; Windows Mobile; WCE; Opera Mobi/WMD-50433; U; de) Presto/2.4.13 Version/10.00',
                'Windows CE',
                '0.0.0',
                'Microsoft Corporation',
            ],
            [
                'Mozilla/4.77C-SGI [en] (X11; I; IRIX64 6.5 IP30)',
                'IRIX',
                '0.0.0',
                'unknown',
            ],
            [
                'Mozilla/4.77 [en] (X11; U; HP-UX B.11.00 9000/800)',
                'HP-UX',
                '0.0.0',
                'HP',
            ],
            [
                'Mozilla/5.0 (X11; U; OSF1 alpha; en-US; rv:0.9.4.1) Gecko/20020517 Netscape6/6.2.3',
                'Tru64 UNIX',
                '0.0.0',
                'HP',
            ],
            [
                'Opera/9.80 (J2ME/MIDP; Opera Mini/4.3.24214 (Windows; U; Windows NT 6.1) AppleWebKit/24.838; U; id) Presto/2.5.25 Version/10.54',
                'Java',
                '0.0.0',
                'Oracle',
            ],
            [
                'Opera/9.80 (J2ME/MIDP; Opera Mini/4.3.24214; iPhone; CPU iPhone OS 4_2_1 like Mac OS X; AppleWebKit/24.783; U; en) Presto/2.5.25 Version/10.54',
                'iOS',
                '4.2.1',
                'Apple Inc',
            ],
            [
                'amarok/2.8.0 (Phonon/4.8.0; Phonon-VLC/0.8.0) LibVLC/2.2.1',
                'Linux',
                '0.0.0',
                'Linux Foundation',
            ],
            [
                'Mozilla/5.0 (X11; U; Linux arm7tdmi; rv:1.8.1.11) Gecko/20071130 Minimo/0.025',
                'Linux Smartphone OS (Maemo)',
                '0.0.0',
                'Linux Foundation',
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows 95; PalmSource; Blazer 3.0) 16; 160x160',
                'PalmOS',
                '0.0.0',
                'Palm',
            ],
            [
                'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1b4pre) Gecko/20090311 Ubuntu/9.04 (jaunty) Shiretoko/3.1b4pre',
                'Ubuntu',
                '9.04.0',
                'Canonical Foundation',
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1) Opera 8.60 [en]',
                'Windows',
                'XP.0.0',
                'Microsoft Corporation',
            ],
            [
                'Mozilla/4.41  (BEOS; U ;Nav)',
                'BeOS',
                '0.0.0',
                'Access',
            ],
            [
                'Mozilla/5.0 (Macintosh; U; PPC Mac OS X Mach-O; rv:1.7.2) Gecko/20040804 Netscape/7.2',
                'Mac OS X',
                '10.0.0',
                'Apple Inc',
            ],
            [
                'Mozilla/5.0 (Darwin; FreeBSD 5.6; en-GB; rv:1.8.1.17pre) Gecko/20080716 K-Meleon/1.5.0',
                'FreeBSD',
                '5.6.0',
                'FreeBSD Foundation',
            ],
            [
                'Mozilla/4.08 (Charon; Inferno)',
                'Inferno OS',
                '0.0.0',
                'Vita Nuova Holdings Ltd',
            ],
            [
                'Mozilla/5.0 (compatible; ABrowse 0.4; Syllable)',
                'Syllable',
                '0.0.0',
                'Syllable Project',
            ],
            [
                'Mozilla/5.0 Gecko/20030306 Camino/0.7',
                'Mac OS X',
                '10.0.0',
                'Apple Inc',
            ],
            [
                'Mozilla/5.0 (Macintosh; ARM Mac OS X) AppleWebKit/538.15 (KHTML, like Gecko) Safari/538.15 Version/6.0 Raspbian/8.0 (1:3.8.2.0-0rpi27rpi1g) Epiphany/3.8.2',
                'Debian',
                '0.0.0',
                'Software in the Public Interest, Inc.',
            ],
            [
                'Mozilla/5.0 (Maemo; Linux; U; Jolla; Sailfish; like Android) AppleWebKit/538.1 (KHTML, like Gecko) Mobile Safari/538.1 (compatible)',
                'SailfishOS',
                '0.0.0',
                'Jolla Ltd.',
            ],
            [
                'Lemon B556',
                'Java',
                '0.0.0',
                'Oracle',
            ],
            [
                'LAVA Spark284/MIDP-2.0 Configuration/CLDC-1.1/Screen-240x320',
                'Java',
                '0.0.0',
                'Oracle',
            ],
            [
                'KKT20/MIDP-2.0 Configuration/CLDC-1.1/Screen-240x320',
                'Java',
                '0.0.0',
                'Oracle',
            ],
            [
                'Microsoft-CryptoAPI/6.3',
                'unknown',
                '0.0.0',
                'unknown',
            ],
            [
                'UCS (ESX) - 4.0-3 errata302 - 28d414cc-2dac-4c0e-a34a-734020b8af66 - 00000000-0000-0000-0000-000000000000 -',
                'Linux',
                '0.0.0',
                'Linux Foundation',
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows CE; IEMobile 7.11) Sprint:MotoQ9c',
                'Windows CE',
                '0.0.0',
                'Microsoft Corporation',
            ],
            [
                'Mozilla/5.0 (Linux; U; en-us; Velocitymicro/T408) AppleWebKit/530.17(KHTML, like Gecko) Version/4.0Safari/530.17',
                'Android',
                '0.0.0',
                'Google Inc',
            ],
            [
                'Mozilla/5.0 (SAMSUNG; SAMSUNG-GT-S5380/Z3x_tmXXKK4',
                'Bada',
                '0.0.0',
                'Samsung',
            ],
            [
                'Mozilla/5.0 (Mobile; rv:32.0) Gecko/20100101 Firefox/32.0',
                'FirefoxOS',
                '2.0.0',
                'Mozilla Foundation',
            ],
            [
                'SAMSUNG-GT-C3312R Opera/9.80 (X11; Linux zvav; U; en) Presto/2.12.423 Version/12.16',
                'Java',
                '0.0.0',
                'Oracle',
            ],
            [
                'TinyBrowser/2.0 (TinyBrowser Comment; rv:1.9.1a2pre) Gecko/20201231',
                'Linux',
                '0.0.0',
                'Linux Foundation',
            ],
            [
                'Mozilla/5.0 (Android; Linux armv7l; rv:5.0) Gecko/20110603 Firefox/5.0 Fennec/5.0',
                'Android',
                '0.0.0',
                'Google Inc',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; ja-jp; SH-10D Build/S4180; DOCOMO; mediatap) 720X1184 SHARP SH-10D AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
                'Android',
                '4.0.4',
                'Google Inc',
            ],
            [
                'Apple-PubSub/65.28',
                'Mac OS X',
                '10.0.0',
                'Apple Inc',
            ],
            [
                'integrity/4',
                'Mac OS X',
                '10.0.0',
                'Apple Inc',
            ],
            [
                'Mozilla/5.0 (Symbian/3; Series60/5.3 Nokia500/111.021.0028; Profile/MIDP-2.1 Configuration/CLDC-1.1 ) AppleWebKit/535.1 (KHTML, like Gecko) NokiaBrowser/8.3.1.4 Mobile Safari/535.1 3gpp-gba',
                'Symbian OS',
                '0.0.0',
                'Symbian Foundation',
            ],
            [
                'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 650) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/13.10586',
                'Windows Phone OS',
                '10.0.0',
                'Microsoft Corporation',
            ],
            [
                'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Xbox; Xbox One) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/13.10586',
                'Windows Phone OS',
                '10.0.0',
                'Microsoft Corporation',
            ],
            [
                'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 650) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/13.10586',
                'Windows Phone OS',
                '10.0.0',
                'Microsoft Corporation',
            ],
            [
                'Mozilla/5.0 (X11; Ubuntu; Linux armv7l; rv:17.0) Gecko/20100101 Firefox/17.0',
                'Ubuntu',
                '0.0.0',
                'Canonical Foundation',
            ],
            [
                'Mozilla/5.0 (SMART-TV; X11; Linux armv7l) AppleWebKit/537.42 (KHTML, like Gecko) Chromium/25.0.1349.2 Chrome/25.0.1349.2 Safari/537.42',
                'Linux Smartphone OS (Maemo)',
                '0.0.0',
                'Linux Foundation',
            ],
            [
                'Debian APT-HTTP/1.3 (1.0.1ubuntu2)',
                'Debian',
                '0.0.0',
                'Software in the Public Interest, Inc.',
            ],
        ];
    }
}
