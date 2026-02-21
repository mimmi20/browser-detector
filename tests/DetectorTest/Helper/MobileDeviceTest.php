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

use BrowserDetector\Helper\MobileDevice;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(MobileDevice::class)]
final class MobileDeviceTest extends TestCase
{
    private MobileDevice $object;

    /** @throws void */
    #[Override]
    protected function setUp(): void
    {
        $this->object = new MobileDevice();
    }

    /** @throws ExpectationFailedException */
    #[DataProvider('providerIsMobile')]
    public function testIsMobile(string $agent): void
    {
        self::assertTrue(
            $this->object->isMobile($agent),
            sprintf('isMobile detected to FALSE instead of expected TRUE for UA "%s"', $agent),
        );
    }

    /**
     * @return array<int, array<int, string>>
     *
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    public static function providerIsMobile(): array
    {
        return [
            ['Mozilla/5.0 (Mobile; ALCATELOneTouch4012X/SVN 01010B; rv:18.1) Gecko/18.1 Firefox/18.1'],
            ['Mozilla/5.0 (PLAYSTATION 3; 2.00)'],
            ['Crowsnest/0.5 (+http://www.crowsnest.tv/)'],
            ['Dorado WAP-Browser/1.0.0'],
            ['DINO762 Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/534.24 (KHTML, like Gecko) Chrome/11.0.696.34 Safari/534.24'],
            ['TBD1083 Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/534.24 (KHTML, like Gecko) Chrome/11.0.696.34 Safari/534.24'],
            ['TBDB863 Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/534.24 (KHTML, like Gecko) Chrome/11.0.696.34 Safari/534.24'],
            ['TERRA_101 Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/534.24 (KHTML, like Gecko) Chrome/11.0.696.34 Safari/534.24'],
            ['AntennaPod/1.5.2.0'],
            ['Antenna/965 CFNetwork/758.2.8 Darwin/15.0.0'],
            ['RSS_Radio 1.5'],
            ['RSSRadio (Push Notification Scanner;support@dorada.co.uk)'],
            ['iTunes/10.5.2 (PodCruncher 2.2)'],
            ['https://audioboom.com/boos/'],
            ['Stitcher/iOS'],
            ['Mozilla/5.0 (X11; U; Linux x86_64; en-gb) AppleWebKit/537.36 (KHTML, like Gecko)  Chrome/30.0.1599.114 Safari/537.36 Puffin/4.1.1.1119AP'],
            ['Mozilla/5.0 (Linux; U; en-us; BeyondPod 4)'],
            ['CaptiveNetworkSupport-324 wispr'],
            ['Mozilla/5.0 (iOS; U; en) AppleWebKit/533.19.4 (KHTML, like Gecko) AdobeAIR/13.0'],
            ['Mozilla/4.0 (compatible; MSIE 4.01; Windows CE; PPC; 240x320; SPV M700; OpVer 19.123.2.733) OrangeBot-Mobile 2008.0 (mobilesearch.support@orange-ftgroup.com)'],
            ['Opera/9.80 (J2ME/MIDP; Opera Mini/4.3.24214 (Windows; U; Windows NT 6.1) AppleWebKit/24.838; U; id) Presto/2.5.25 Version/10.54'],
            ['Mozilla/5.0 (iPad; CPU OS 8_1_2 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12B440 Safari/600.1.4'],
            ['Mozilla/5.0 (X11; U; Linux x86_64; ar-SA) AppleWebKit/534.35 (KHTML, like Gecko)  Chrome/11.0.696.65 Safari/534.35 Puffin/3.11546IP'],
            ['Mozilla/5.0 (X11; U; Linux i686; th-TH@calendar=gregorian) AppleWebKit/534.12 (KHTML, like Gecko) Puffin/1.3.2665MS Safari/534.12'],
            ['TIANYU-KTOUCH/A930/Screen-240X320'],
            ['Lemon B556'],
            ['LAVA Spark284/MIDP-2.0 Configuration/CLDC-1.1/Screen-240x320'],
            ['Spice QT-75'],
            ['ALCATEL_TRIBE_3075A/1.0 Profile/MIDP-2.0 Configuration/CLDC-1.1 ObigoInternetBrowser/Q05A'],
            ['KKT20/MIDP-2.0 Configuration/CLDC-1.1/Screen-240x320'],
            ['Mozilla/5.0 (Linux; U; en-us; Velocitymicro/T408) AppleWebKit/530.17(KHTML, like Gecko) Version/4.0Safari/530.17'],
            ['Mozilla/5.0 (Mobile; rv:32.0) Gecko/20100101 Firefox/32.0'],
            ['TBDG773 Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/534.24 (KHTML, like Gecko) Chrome/11.0.696.34 Safari/534.24'],
            ['Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0; ARM; Touch; WPDesktop)'],
            ['Mozilla/5.0 (Windows NT 6.2; ARM; Trident/7.0; Touch; rv:11.0; WPDesktop; Lumia 640 LTE) like Gecko'],
            ['Mozilla/5.0 (iPhone; CPU iPhone OS 8_0_2 like Mac OS X) (Windows NT 6.1; WOW64) AppleWebKit/600.1.4 (KHTML, like Gecko) Mobile/12A405 MicroMessenger/5.4.2 NetType/WIFI'],
            ['Mozilla/5.0 (Windows NT 10.0; ARM; Lumia 650) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Safari/537.36 Edge/13.10586'],
            ['Mozilla/5.0 (Windows NT 10.0; ARM; WIN JR LTE) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Safari/537.36 Edge/13.10586'],
            ['Mozilla/5.0 (Windows NT 10.0; Trident/7.0; Touch; SurfTab duo W1 10.1; rv:11.0) like Gecko'],
            ['Mozilla/5.0 (Linux; U; Linux Ventana; de-de; Transformer TF101G Build/HTJ85B) AppleWebKit/534.13 (KHTML, like Gecko) Chrome/8.0 Safari/534.13'],
            ['Mozilla/5.0 (Linux;U;Linux2.6; de-de; TSB_CLOUD_COMPANION;FOLIO_AND_A) AppleWebKit/533.1 (KHTML,like Gecko) Version/4.0 Safari/533.1'],
            ['DoCoMo/2.0 N705i(c100;TB;W24H16)'],
            ['S8500 UCWEB6.0/UC Browser7.7.0.81'],
            ['portalmmm/2.0 S500i(c20;TB)'],
            ['Hisense-W2003'],
            ['YourWap Siemens SL45/2.63'],
            ['Mozilla/5.0 (Mobile; rv:32.0) Gecko/20100101 Firefox/32.0'],
            ['Mozilla/5.0 (Mobile; OneTouch6015X SVN:01010B MMS:1.1; rv:32.0) Gecko/32.0 Firefox/32.0'],
            ['Mozilla/5.0 (Windows NT 6.3; ARM; Trident/7.0; Touch; rv:11.0) like Gecko'],
            ['Opera/9.80 (Windows Mobile; Opera Mini/5.1.21595/37.6334; U; de) Presto/2.12.423 Version/12.16'],
            ['Mozilla/5.0 (Android; Mobile; rv:10.0.5) Gecko/10.0.5 Firefox/10.0.5 Fennec/10.0.5'],
            ['Mozilla/5.0 (Linux;u;Android 2.3.7;zh-cn;) AppleWebKit/533.1 (KHTML,like Gecko) Version/4.0 Mobile Safari/533.1 (compatible; +http://www.baidu.com/search/spider.html)'],
            ['Mozilla/5.0 (Linux; U; Android 4.0; de-DE; EK-GC100 Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30'],
            ['WAP Browser-Karbonn K84/1.0.0'],
            ['Mozilla/4.0 (compatible; MSIE 6.0; Windows CE; IEMobile 6.12; Microsoft ZuneHD 4.3)'],
            ['Mozilla/5.0 (Windows; U; Windows NT 5.1;en-us;LenovoTablet Build/1.0) AppleWebKit/534.13 (KHTML, like Gecko) Version/4.0 Safari/534.13'],
            ['Mozilla/5.0 (Tablet; rv:26.0) Gecko/18.0 Firefox/26.0'],
            ['Mozilla/5.0 (Mobile; rv:18.0) Gecko/18.0 Firefox/18.0'],
            ['Browse/0.6.mini (Linux 3.4.0+; RemixOS 6.0; Motorola Moto G 2014; en_us) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.119 Desktop'],
            ['J2ME/UCWEB7.0.3.45/139/7687'],
            ['MicromaxX263/Q03C MAUI-browser/'],
            ['OV-SteelCore(B) Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/534.24 (KHTML, like Gecko) Chrome/11.0.696.34 Safari/534.24'],
            ['Mozilla/5.0 (Linux; U; Android 4.1.1; es-es; bq Curie Build/1.1.0 20130322-14:50) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30'],
            ['Mozilla/5.0 (Linux; U; Android 4.0.4; es-es; bq Edison Build/1.1.7 20121029-11:59) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30'],
            ['Mozilla/5.0 (Linux; Android 4.2.2; bq Edison 2 Quad Core Build/1.2.0_20140106-13:59) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.114 Safari/537.36'],
            ['Mozilla/5.0 (Linux; U; Android 4.1.2; es-es; bq Elcano Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30'],
            ['Mozilla/5.0 (Linux; U; Android 4.0.4; en-us; bq Maxwell Plus Build/1.0.3 20121201-14:07) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30'],
            ['AppleCoreMedia/1.0.0.16R5303d (Apple Watch; U; CPU OS 5_0 like Mac OS X; en_au)'],
            ['AppleCoreMedia/1.0.0.16A303 (HomePod; U; CPU OS 12_0 like Mac OS X; en_us)'],
            ['YUANDA50_12864_11B_HW (MRE\\2.5.00(800) resolution\\320480 chipset\\MT6250 touch\\1 tpannel\\1 camera\\1 gsensor\\0 keyboard\\reduced) C529AH_JY_539_W1.11B.V2.2 Release/2012.09.26 WAP Browser/MAUI (HTTP PGDL; HTTPS) Profile/ Q03C1-2.40 fr-FR'],
            ['Mozilla/5.0 (Linux; Android 7.1.2; H96 Max Build/NHG47K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.111 Safari/537.36'],
            ['W3C-mobileOK/DDC-1.0 (see http://www.w3.org/2006/07/mobileok-ddc)'],
            ['Coursera-Mobile 1.2.1'],
            ['Microsoft Office Mobile/15.0'],
            ['CWEB/2.0 (Linux; U; Adr 2.1-update1; en-US; E10i) U2/1.0.0 UC \\x11@0C75@/8.2.0.242 U2/1.0.0 Mobile'],
            ['Mozilla/5.0 (Linux; U; en-us; EBRD1201; EXT) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1'],
            ['Mozilla/5.0 (Linux; U; en-us; EBRD1101; EXT) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1'],
            ['Mozilla/5.0 (;;; en-us; Huawei-U8651 Build/U8651SV100R001USAC85B843) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1'],
            ['Mozilla/5.0 (Linux; U; Tizen 2.0; en-us) AppleWebKit/537.1 (KHTML, like Gecko) Mobile TizenBrowser/2'],
            ['Mozilla/5.0 (Linux; Android 4.4.2; N9106 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.76 Safari/537.36'],
            ['dv(iPh4,1);pr(UCBrowser/10.2.0.517);ov(7_1_2);ss(320x416);bt(UC);pm(0);bv(0);nm(0);im(0);nt(1);'],
            ['pf(44);la(zh-CN);dv(iPd5,1);pr(UCBrowser);ov(7_0_2);pi(640x1136);ss(320x416);er(U);bt(UM);up();re(AppleWebKit/537.51.1 (KHTML, like Gecko));pm(0);bv(0);nm(0);im(0);nt(2);'],
            ['pf(Linux);la(en-US);re(U2/1.0.0);dv(TECNO_S3);pr(UCBrowser/8.8.1.359);ov(4.2.2);pi(320*480);ss(320*480);up(U2/1.0.0);er(U);bt(GJ);pm(1);nm(0);im(0);sr(2);nt(99);'],
            ['iBrowser/Mini2.5 (LG-T375)'],
            ['Mozilla/5.0 (SonyEricssonU5i)UC AppleWebkit(like Gecko) Safari/530'],
            ['Mozilla/5.0 (COS 998;COS 998; COS 998 Build/12345) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.166 Safari/535.19'],
            ['Cricket-A415/1.0 Polaris/v6.17'],
            ['Mozilla/5.0 (Linux; U; Intel Mac OSX 10_6_3; 3.2; de-de; MZ601 Build/HTJ85B) AppleWebKit/534.13 (KHTML, like Gecko) Version/4.0 Safari/534.13'],
            ['NetFront/3.5.1 (BREW 5.0.1.2; U; en-us; LG; NetFront/3.5.1/AMB) Sprint LN510 MMP/2.0 Profile/MIDP-2.1 Configuration/CLDC-1.1'],
            ['NetFront/4.2 (BMP 1.0.4; U; en-us; LG; NetFront/4.2/AMB) Boost LG272 MMP/2.0 Profile/MIDP-2.1 Configuration/CLDC-1.1'],
            ['Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0; LG; LG-C900)'],
            ['POLARIS/6.01 (BREW 3.1.5; U; en-us; LG; LX265; POLARIS/6.01/WAP) MMP/2.0 profile/MIDP-2.1 Configuration/CLDC-1.1'],
            ['Mozilla/5.0 (CLT-L29 19.0.0.300) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36'],
            ['Mozilla/5.0 (Linux; U; Android 13; de-de; Redmi 12C Build/TP1A.220624.014) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/112.0.5615.136 Mobile Safari/537.36 XiaoMi/MiuiBrowser/13.38.0-gn'],
            ['HISTORY/6.3.0 (com.aetn.history.ios.watch; build:4385; iOS 16.6.0) Alamofire/4.8.2'],
            ['Mozilla/4.0 (compatible; MSIE 6.0; KDDI-CA3B) Opera 8.60 [ja]'],
            ['Mozilla/5.0 (Linux; Android 10; GM1910 Build/QKQ1.190716.003; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/66.0.3359.126 MBrowser/6.2 TBS/045008 Mobile Safari/537.36 BiliApp/5531000 mobi_app/android channel/oppo Buvid/<hide> internal_version/5531000'],
            ['ZTE S519/1.0 Threadx/4.0 Mocor/W12 Realease/01.01.2013 Browser/Dorado1.0'],
            ['(null)/(null) watchOS/5.0.1 model/Watch4,2 hwp/t8006 build/16R382 (6; dt:191)'],
            ['CFNetwork, iPhone OS 5.1.1, iPhone4,1'],
            ['Mozilla/5.0 (Linux; U; YunOs 1.0.0.3; en-; K-Touch W619 Build/AliyunOs-2012) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1'],
            ['Himalaya/2.6.32 (iPhone; iOS 16.5.1; Scale/3.00; CFNetwork; iPhone13,4)'],
            ['NetworkingExtension/8621.5.1.10.7 Network/4277.140.33.700.1 iOS/18.7.2'],
            ['Mozilla/5.0 (Linux like Android; de_DE) AppleWebKit/534.34 PocketBook/626 (screen 758x1024; FW O626.4.4.979) Mobile'],
            ['Jam/2.0.4 iOS/16.3.1 (www.listentojam.com)'],
            ['KKBOX/7.10.70/iOS/14.2'],
            ['BIRD S710_BLEU/1.00 Nucleus RTOS/V1.11.19 MTK6223/07A Release/07.28.2007 Browser/Teleca'],
            ['Mozilla/5.0 (Linux; Ubuntu 20.04 like Android 9) AppleWebKit/537.36 Chrome/87.0.4280.144 Mobile Safari/537.36'],
            ['Mozilla/5.0 (X11; Linux x86_64; Quest 2) AppleWebKit/537.36 (KHTML, like Gecko) OculusBrowser/34.4.0.236.170.637352867 Chrome/126.0.6478.226 VR Safari/537.36'],
            ['7plus/6.0.1 (com.swm.live; build:95045; iOS 17.6.1) Alamofire/5.4.3'],
            ['Mozilla/5.0 (Web0S) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.0.0 Safari/537.36 WebAppManager'],
        ];
    }

    /** @throws ExpectationFailedException */
    #[DataProvider('providerIsNotMobile')]
    public function testIsNotMobile(string $agent): void
    {
        self::assertFalse(
            $this->object->isMobile($agent),
            sprintf('isMobile detected to TRUE instead of expected FALSE for UA "%s"', $agent),
        );
    }

    /**
     * @return array<int, array<int, string>>
     *
     * @throws void
     */
    public static function providerIsNotMobile(): array
    {
        return [
            ['Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) MxNitro/1.0.0.2000 Chrome/35.0.1849.0 Safari/537.36'],
            ['Mozilla/5.0 (compatible; MSIE 9.0; Windows NT; MarketwireBot +http://www.marketwire.com)'],
            ['Mozilla/5.0 (DTV) AppleWebKit/531.2+ (KHTML, like Gecko) Espial/6.1.15 AQUOSBrowser/2.0 (US01DTV;V;0001;0001)'],
            ['Microsoft Office Word 2013 (15.0.4693) Windows NT 6.2'],
            ['MSFrontPage/15.0'],
            ['amarok/2.8.0 (Phonon/4.8.0; Phonon-VLC/0.8.0) LibVLC/2.2.1'],
            ['Opera/9.80 (Linux armv6l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0;THOMSON LF1V401; en) Presto/2.10.250 Version/11.60'],
            ['AppleCoreMedia/1.0.0.12F69 (Apple TV; U; CPU OS 8_3 like Mac OS X; en_us)'],
            ['Apple-PubSub/65.28'],
            ['gvfs/1.4.3'],
            ['Opera/9.80 (Linux mips; ) Presto/2.12.407 Version/12.51 MB97/0.0.39.10 (ALDINORD, Mxl661L32, wireless) VSTVB_MB97'],
            ['Mozilla/5.0 (Windows NT 5.2) AppleWebKit/5342 (KHTML, like Gecko) Chrome/36.0.873.0 Mobile Safari/5342'],
            ['Opera/9.80 (Linux armv7l; U; CE-HTML/1.0 NETTV/3.3.0; PHILIPS-AVM-2012; en) Presto/2.9.167 Version/11.50'],
            ['Opera/9.80 (Windows NT 6.0; Opera Mobi/49; U; en) Presto/2.4.18 Version/10.00'],
            ['Mozilla/5.0 (X11; NetBSD amd64; rv:43.0) Gecko/20100101 Firefox/43.0'],
            ['Mozilla/5.0 (X11; U; SunOS sun4u; pl-PL; rv:1.8.1.6) Gecko/20071217 Firefox/2.0.0.6'],
            ['Mozilla/5.0 (Windows; U; Windows NT 5.1; fr; rv:1.9.2.13) Gecko/20101203 iPhone'],
            ['Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; Touch; tb-webde/2.6.9; MASEJS; rv:11.0) like Gecko'],
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
            ['Mozilla/5.0 (X11; U; Linux i686; de; rv:1.9.1.1) Gecko/20090725 Moblin/3.5.1-2.5.14.moblin2 Shiretoko/3.5.1'],
            ['QuickTime\\\\xaa.7.0.4 (qtver=7.0.4;cpu=PPC;os=Mac 10.3.9)'],
            ['Opera/9.80 (Linux armv7l; InettvBrowser/2.2 (00014A;SonyDTV140;0001;0001) KD49X8505B; CC/DEU) Presto/2.12.407 Version/12.50'],
            ['Mozilla/5.0 (X11; Linux aarch64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.84 Safari/537.36 CrKey/1.22.74257'],
            ['Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:2.1) Gecko/20110318 Firefox/4.0b13pre Fennec/4.0'],
            ['Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36 SailfishBrowser/Rulz ~LenovoG780'],
            ['Mozilla/5.0 (Windows IoT 10.0; Android 6.0.1; WebView/3.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Mobile Safari/537.36 Edge/17.17083'],
            ['Mozilla/5.0 (Web0S; Linux/SmartTV) AppleWebKit/537.36 (KHTML, like Gecko) QtWebEngine/5.2.1 Chr0me/38.0.2125.122 Safari/537.36 LG Browser/8.00.00(LGE; 32LH590U-ZE; 03.01.00; 1; DTV_W16R); webOS.TV-2016; LG NetCast.TV-2013 Compatible (LGE, 32LH590U-ZE, wireless)'],
            ['Mozilla/5.0 (DirectFB; Linux armv7l) AppleWebKit/534.26+ (KHTML, like Gecko) Version/5.0 Safari/534.26+ LG Browser/5.00.00(+mouse+3D+SCREEN+TUNER; LGE; 47LM9600-NA; 06.00.00; 0x00000001;); LG NetCast.TV-2012 0'],
            ['Mozilla/5.0 (X11; Linux armv7l) AppleWebKit/537.36 (KHTML, like Gecko) Raspbian Chromium/65.0.3325.181 Chrome/65.0.3325.181 Safari/537.36'],
            ['Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.111 Safari/537.36 Puffin/7.6.1.531WD'],
            ['Mozilla/5.0 (Linux; Andr0id 7.0; BRAVIA 4K GB Build/NRD91N.S139) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36 OPR/40.0.2207.0 OMI/4.9.0.59.E9103576.154'],
            ['Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/8.0 Chrome/63.0.3239.111 Safari/537.36'],
            ['Mozilla/4.0 (compatible; MSIE 5.01; Windows 98; Linux 3.3.8-3.3) [Netgem; 7.7.01-51; i-Player; netbox; sezmi_totalgem]'],
            ['WordPress/4.9.5; http://www.smartphone-advertising.com'],
            ['Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; MyIE2; Maxthon; SV1; .NET CLR 1.1.4322; Tablet PC 1.7; .NET CLR 1.0.3705)'],
            ['Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; Siemens A/S; .NET CLR 1.0.3705; .NET CLR 1.1.4322)'],
            ['Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SS.CC. Palma)'],
            ['Mozilla/5.0 (Windows NT 10.0.17134.590; osmeta 10.3.31799) AppleWebKit/602.1.1 (KHTML, like Gecko) Version/9.0 Safari/602.1.1 osmeta/10.3.31799 Build/31799 [FBAN/FBW;FBMD/80QB;FBSN/Windows;FBSV/10.0.17134.706;FBSS/1;FBCR/;FBID/desktop;FBLC/de_DE;FBOP/45]'],
            ['Mozilla/3.01-C-MACOS8 (Macintosh; I; PPC)'],
            ['LG Browser/7.00.00(LGE; WEBOS1; 00.00.00) webOS.TV-2015)'],
            ['Mozilla/5.0 (Unknown; Linux armv7l) AppleWebKit/537.1+ Hybridcast/1.0(;00E091;LGwebOSTV;1;0;)0'],
            ['Mozilla/5.0 (Unknown; Linux armv7l) AppleWebKit/537.1+ (KHTML, like Gecko) Safari/537.1+ OHTV/1.0 ( ;LGE ;GLOBAL-PLAT4 ;02.22.01 ;0x00000001'],
            ['Mozilla/5.0 (iPhone; CPU iPhone OS 8_0_2 like Mac OS X) (Windows NT 6.1; WOW64) AppleWebKit/600.1.4 (KHTML, like Gecko) Mobile Safari/537.36'],
            ['Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36 Edg/115.0.1901.203 OpenWave/96.4.5253.54'],
            ['Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; Touch; MDDCJS; rv:11.0) like Gecko'],
            ['Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.141 CitizenFX/1.0.0.6556 Safari/537.36'],
            ['Mozilla/5.0 (Linux aarch64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36 OPR/36.0.2128.0 OMI/4.8.0.129.JFK.669 TiVo, TiVo_STB_BCM7278/21.11.1.v22-USM-12 (TiVo, TCDD6F000, wired)'],
            ['Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36 MicroMessenger/6.5.2.501 NetType/WIFI WindowsWechat'],
            ['Mozilla/4.0 (compatible; MSIE 6.0; Windows 98; htcomp.net)'],
            ['VMS_Mosaic/4.0 (Motif;OpenVMS V8.3 COMPAQ Professional Workstation ) libwww/2.12_Mosaic'],
            ['Mozilla/5.0 (Linux; Android 7.1.1; Build/R62-9901.77.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2706.0 Safari/537.36'],
            ['Mozilla/5.0 (X11; 78; CentOS; US-en) AppleWebKit/527+ (KHTML, like Gecko) Bolt/0.862 Version/3.0 Safari/523.15'],
            ['ELinks/0.11.4-3maemo0 (textmode; Debian; Linux 2.6.28.10power46 armv7l; -)'],
            ['Mozilla/5.0 (Windows NT; U; en) AppleWebKit/525.18.1 (KHTML, like Gecko) Version/3.1.1 Iris/1.1.7 Safari/525.20'],
            ['Mozilla/5.0 (Linux; Android 9; SW-LED42SB300 Build/PPR2.180905.006.A1; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/66.0.3359.158 YaBrowser/22.8.0.9 (lite) TV Safari/537.36'],
            ['Mozilla/5.0 (Linux; Android 10; 2020/2021 UHD Android TV Build/QTG3.201102.001; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/100.0.4896.88 Mobile Safari/537.36'],
            ['Mozilla/5.0 (Linux; Android 4.2.2; Hisense Google TV TV Build/3.0.0-105-gb209657) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.62 Safari/537.36'],
            ['macOS/14.6.1 (23G93) dataaccessd/1.0'],
            ['Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.102 Safari/537.36 NetType/WIFI MicroMessenger/6.8.0(0x16080000) MacWechat/3.8.3(0x13080310) XWEB/30817 Flue'],
            ['Opera/9.80 (Linux mips; ) Presto/2.12.407 Version/12.51 MB95/3.6.6.i (POLAROID, Si2157LG32, wireless)'],
            ['Mozilla/5.0 (iPad; U; CPU OS 5_0 like Mac OS X; en-us) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.0.2 Mobile/9A5248d Safari/6533.18.5#2.0#TCL/TCL-EU-RT2851-S1/28/tclwebkit1.0.2/1920*1080(547201164,null;223638693,5e1c14b212714aba9f902d376e3504aa)'],
            ['Mozilla/5.0 (Linux armv7l) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.140 Safari/537.36 OPR/46.0.2207.0 OMI/4.21.2.50.Honey.220 Model/Hisense-NT72671D'],
            ['VIZIO V755M-K04 ViziOS/1.4.519.868.1 WatchFree/24.07.25 FancyPlayer/1.1.30-qa'],
            ['nook browser/1.0'],
            ['Mozilla/5.0 (Linux; x86_64 GNU/Linux) AppleWebKit/601.1 (KHTML, like Gecko) Version/8.0 Safari/601.1 WPE ComcastAppPlatform E500AC55C Firebolt/0.8.1'],
            ['Mozilla/5.0 (Linux; x86_64 GNU/Linux) AppleWebKit/601.1 (KHTML, like Gecko) Version/8.0 Safari/601.1 WPE ComcastAppPlatform AX061AEI Firebolt/0.8.1,gzip(gfe),gzip(gfe) 1.0.0.0 Xfinity'],
        ];
    }
}
