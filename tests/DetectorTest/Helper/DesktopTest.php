<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2026, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Helper;

use BrowserDetector\Helper\Desktop;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(Desktop::class)]
final class DesktopTest extends TestCase
{
    private Desktop $object;

    /** @throws void */
    #[Override]
    protected function setUp(): void
    {
        $this->object = new Desktop();
    }

    /** @throws ExpectationFailedException */
    #[DataProvider('providerIsDesktop')]
    public function testIsDesktop(string $agent): void
    {
        self::assertTrue(
            $this->object->isDesktopDevice($agent),
            sprintf('isMobile detected to FALSE instead of expected TRUE for UA "%s"', $agent),
        );
    }

    /**
     * @return array<int, array<int, string>>
     *
     * @throws void
     */
    public static function providerIsDesktop(): array
    {
        return [
            ['Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) MxNitro/1.0.0.2000 Chrome/35.0.1849.0 Safari/537.36'],
            ['CybEye.com/2.0 (compatible; MSIE 9.0; Windows NT 5.1; Trident/4.0; GTB6.4)'],
            ['revolt'],
            ['Microsoft Office Excel 2013'],
            ['iTunes/11.3.1 (Windows; Microsoft Windows 7 x64 Home Premium Edition Service Pack 1 (Build 7601)) AppleWebKit/537.60.17'],
            ['Mozilla/5.0 (X11; BSD Four) AppleWebKit/534.34 (KHTML, like Gecko) wkhtmltoimage Safari/534.34'],
            ['Microsoft Office Word 2013 (15.0.4693) Windows NT 6.2'],
            ['Microsoft Outlook Social Connector (15.0.4569) MsoStatic (15.0.4569)'],
            ['MSFrontPage/15.0'],
            ['Mozilla/2.0 (compatible; MS FrontPage 5.0)'],
            ['Mozilla/5.0 Gecko/20030306 Camino/0.7'],
            ['UCS (ESX) - 4.0-3 errata302 - 28d414cc-2dac-4c0e-a34a-734020b8af66 - 00000000-0000-0000-0000-000000000000 -'],
            ['TinyBrowser/2.0 (TinyBrowser Comment; rv:1.9.1a2pre) Gecko/20201231'],
            ['Apple-PubSub/65.28'],
            ['gvfs/1.4.3'],
            ['Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.1.9) Gecko/20071025 FreeBSD/i386 Firefox/2.0.0.9'],
            ['Mozilla/5.0 (X11; U; OSF1 alpha; en-US; rv:1.7.5) Gecko/20050112 Firefox/1.0'],
            ['Mozilla/5.0 (Windows NT 5.2) AppleWebKit/5342 (KHTML, like Gecko) Chrome/36.0.873.0 Mobile Safari/5342'],
            ['Opera/9.80 (Windows NT 6.0; Opera Mobi/49; U; en) Presto/2.4.18 Version/10.00'],
            ['Mozilla/5.0 (X11; NetBSD amd64; rv:43.0) Gecko/20100101 Firefox/43.0'],
            ['Mozilla/5.0 (X11; U; SunOS sun4u; pl-PL; rv:1.8.1.6) Gecko/20071217 Firefox/2.0.0.6'],
            ['BarcaPro/1.4.12'],
            ['Barca/2.8.2'],
            ['The Bat! 4.0.0.22'],
            ['Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; Touch; tb-webde/2.6.9; MASEJS; rv:11.0) like Gecko'],
            ['Mozilla/5.0 (X11; BSD Four) AppleWebKit/534.34 (KHTML, like Gecko) wkhtmltoimage Safari/534.34'],
            ['Opera/9.80 (X11; Linux i686; Edition Linux Mint) Presto/2.12.388 Version/12.16'],
            ['Mozilla/5.0 (X11; U; Linux i686; pl-PL; rv:1.9.2a1pre) Gecko/20090330 Kubuntu/8.10 (intrepid) Minefield/3.2a1pre'],
            ['curl/7.15.5 (x86_64-redhat-linux-gnu) libcurl/7.15.5 OpenSSL/0.9.8b zlib/1.2.3 libidn/0.6.5'],
            ['OMozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.2.9) Gecko/20100827 Red Hat/3.6.9-2.el6 Firefox/3.6.9'],
            ['Mozilla/5.0 (X11; U; Linux i686; en-GB; rv:1.8.0.5) Gecko/20060805 CentOS/1.0.3-0.el4.1.centos4 SeaMonkey/1.0.3'],
            ['Mozilla/5.0 (X11; CrOS x86_64 14.4.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2558.0 Safari/537.36'],
            ['Mozilla/5.0 (X11; Jolicloud Linux i686) AppleWebKit/537.6 (KHTML, like Gecko) Joli OS/1.2 Chromium/23.0.1240.0 Chrome/23.0.1240.0 Safari/537.6'],
            ['Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.0.7) Gecko/2009031120 Mandriva/1.9.0.7-0.1mdv2009.0 (2009.0) Firefox/3.0.7'],
            ['Mozilla/5.0 (X11; U; Linux i686; de; rv:1.9.0.14) Gecko/2009090900 SUSE/3.0.14-0.1 Firefox/3.0.14'],
            ['Mozilla/5.0 (X11; U; Linux i686; en; rv:1.9) Gecko/20080528 (Gentoo) Epiphany/2.22 Firefox/3.0'],
            ['Mozilla/5.0 (X11; Linux i686) AppleWebKit/534.30 (KHTML, like Gecko) Slackware/Chrome/12.0.742.100 Safari/534.30'],
            ['Mozilla/5.0 (Linux; U; Linux Ventana; de-de; Transformer TF101G Build/HTJ85B) AppleWebKit/534.13 (KHTML, like Gecko) Chrome/8.0 Safari/534.13'],
            ['Mozilla/5.0 (X11; U; Linux i686; de; rv:1.9.1.1) Gecko/20090725 Moblin/3.5.1-2.5.14.moblin2 Shiretoko/3.5.1'],
            ['QuickTime\\\\xaa.7.0.4 (qtver=7.0.4;cpu=PPC;os=Mac 10.3.9)'],
            ['Mozilla/5.0 (X11; U; HP-UX 9000/785; en-US; rv:1.7) Gecko/20040617'],
            ['Mozilla/5.0 (Windows NT 5.1; rv:) Gecko/20100101 Firefox/ anonymized by Abelssoft 1433017337'],
            ['Mozilla/5.0 (Windows 95; Anonymisiert durch AlMiSoft Browser-Anonymisierer 69351893; Trident/7.0; rv:11.0) like Gecko'],
            ['Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36 SailfishBrowser/Rulz ~LenovoG780'],
            ['Mozilla/5.0 (X11; Windows aarch64 10718.88.2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.118 Safari/537.36 CitrixChromeApp'],
            ['Mozilla/5.0 (X11; CrOS aarch64 11021.19.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.22 Safari/537.36'],
            ['Mozilla/5.0 (BeOS; U; BeOS BePC; en-US; rv:1.9a1) Gecko/20051002 Firefox/52.4.0'],
            ['Mozilla/5.0 (compatible; U; Webpositive/533.4; Haiku) AppleWebkit/533.4 (KHTML, like gecko) Chrome/5.0.375.55 Safari/533.4'],
            ['Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; Touch; MDDCJS; rv:11.0) like Gecko'],
            ['Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.141 CitizenFX/1.0.0.6556 Safari/537.36'],
            ['Mozilla/5.0 (compatible; U; ABrowse 0.6; Syllable) AppleWebKit/420+ (KHTML, like Gecko)'],
            ['Wget/1.11.4 Red Hat modified'],
            ['mozilla/5.0 (compatible; fedora core 3) fc3 gnome'],
            ['AmigaVoyager/3.4.4 (MorphOS/PPC native)'],
            ['Mozilla/5.0 (X11; U; DragonFly i386; de; rv:1.9.1b2) Gecko/20081201 Firefox/3.1b2'],
            ['Mozilla/5.0 (X11; U; Gentoo x86_64; de-DE) Firefox/26.0'],
            ['Mozilla/4.08 (Charon; Inferno)'],
            ['Mozilla/5.0 (compatible; Odyssey Web Browser; AROS; rv:1.16) AppleWebKit/535.14 (KHTML, like Gecko) OWB/1.16 Safari/535.14'],
            ['Mozilla/5.0 (PC; OpenHarmony 5.0; HarmonyOS 5.0) AppleWebKit/537.36 (KHTML,like Gecko) Chrome/114.0.0.0 Safari/537.36 ArkWeb/4.1.6.1 Browser/harmony360Browser/1.0.0'],
            ['Mozilla/4.0 (compatible; MSIE 6.0; Slackware)'],
            ['Mozilla/1.1I (X11; I; NEWS-OS 6.1.1 news5000)'],
            ['Mozilla/5.0 (X11; U; GENIX 4.1 MG-200/NS32332; en-US; rv:4.7.1.1) Gecko/20080815 SeaMonkey/1.2.3'],
            ['Links (2.8; ULTRIX 4.5 VAX; GNU C 1; text)'],
            ['Mozilla/6.0 (Future Star Technologies Corp. Star-Blade OS; U; en-US) iNet Browser 2.5'],
            ['Mozilla/5.0 (X11; 78; CentOS; US-en) AppleWebKit/527+ (KHTML, like Gecko) Bolt/0.862 Version/3.0 Safari/523.15'],
            ['Mozilla/5.0 (PPC; rv:9.0) Gecko/20090818 Firefox/9.0'],
            ['ELinks/0.11.4-3maemo0 (textmode; Debian; Linux 2.6.28.10power46 armv7l; -)'],
            ['Mozilla/4.75 [en] (X11; U; BSD/OS 4.0.1 i386)'],
            ['Mozilla/5.0 (compatible; Konqueror/3.0.1 (CVS >= 20020327); Linux) Linspire (Lindows, Inc.)'],
            ['Linspire Internet Suite'],
            ['IBrowse 2.4 (AmigaOS 4.5)'],
            ['Mozilla/4.0 (compatible; Voyager; AmigaOS)'],
            ['Klondike/1.70 (HTTP PPC3)'],
            ['macOS/14.6.1 (23G93) dataaccessd/1.0'],
            ['Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.102 Safari/537.36 NetType/WIFI MicroMessenger/6.8.0(0x16080000) MacWechat/3.8.3(0x13080310) XWEB/30817 Flue'],
            ['R (4.4.1 x86_64-w64-mingw32 x86_64 mingw32)'],
            ['Mozilla/5.0 (X11;) Firefox/38.0'],
            ['Mozilla/5.0 (X11) AppleWebKit/62.41 (KHTML, like Gecko) Edge/17.10859 Safari/452.6'],
        ];
    }

    /** @throws ExpectationFailedException */
    #[DataProvider('providerIsNoDesktop')]
    public function testIsNoDesktop(string $agent): void
    {
        self::assertFalse(
            $this->object->isDesktopDevice($agent),
            sprintf('isMobile detected to TRUE instead of expected FALSE for UA "%s"', $agent),
        );
    }

    /**
     * @return array<int, array<int, string>>
     *
     * @throws void
     */
    public static function providerIsNoDesktop(): array
    {
        return [
            ['Mozilla/5.0 (Mobile; ALCATELOneTouch4012X/SVN 01010B; rv:18.1) Gecko/18.1 Firefox/18.1'],
            ['Mozilla/5.0 (PLAYSTATION 3; 2.00)'],
            ['Crowsnest/0.5 (+http://www.crowsnest.tv/)'],
            ['Dorado WAP-Browser/1.0.0'],
            ['Mozilla/5.0 (DTV) AppleWebKit/531.2+ (KHTML, like Gecko) Espial/6.1.15 AQUOSBrowser/2.0 (US01DTV;V;0001;0001)'],
            ['Mozilla/5.0 (compatible; PAD-bot/9.0; +http://www.descargarprogramagratis.com/)'],
            ['Lemon B556'],
            ['LAVA Spark284/MIDP-2.0 Configuration/CLDC-1.1/Screen-240x320'],
            ['Spice QT-75'],
            ['ALCATEL_TRIBE_3075A/1.0 Profile/MIDP-2.0 Configuration/CLDC-1.1 ObigoInternetBrowser/Q05A'],
            ['KKT20/MIDP-2.0 Configuration/CLDC-1.1/Screen-240x320'],
            ['Mozilla/5.0 (Mobile; rv:32.0) Gecko/20100101 Firefox/32.0'],
            ['WAP Browser-Karbonn K84/1.0.0'],
            ['Mozilla/5.0 (Windows IoT 10.0; Android 6.0.1; WebView/3.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Mobile Safari/537.36 Edge/17.17083'],
            ['Mozilla/4.0 (compatible; MSIE 5.01; Windows 98; Linux 3.3.8-3.3) [Netgem; 7.7.01-51; i-Player; netbox; sezmi_totalgem]'],
            ['Mozilla/5.0 (Linux; U; Intel Mac OSX 10_6_3; 3.2; de-de; Xoom Build/HTJ85B) AppleWebKit/534.13 (KHTML, like Gecko) Version/4.0 Safari/534.13'],
        ];
    }
}
