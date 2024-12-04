<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Helper;

use BrowserDetector\Helper\Tv;
use Override;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

use function sprintf;

final class TvTest extends TestCase
{
    private Tv $object;

    /** @throws void */
    #[Override]
    protected function setUp(): void
    {
        $this->object = new Tv();
    }

    /** @throws ExpectationFailedException */
    #[DataProvider('providerIsTv')]
    public function testIsTv(string $agent): void
    {
        self::assertTrue(
            $this->object->isTvDevice($agent),
            sprintf('isMobile detected to FALSE instead of expected TRUE for UA "%s"', $agent),
        );
    }

    /**
     * @return array<int, array<int, string>>
     *
     * @throws void
     */
    public static function providerIsTv(): array
    {
        return [
            ['dlink.dsm380'],
            ['Mozilla/5.0 (DTV) AppleWebKit/531.2+ (KHTML, like Gecko) Espial/6.1.15 AQUOSBrowser/2.0 (US01DTV;V;0001;0001)'],
            ['Mozilla/5.0 (Linux; Android 4.4.2; gxt_dongle_3188 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/30.0.0.0 Safari/537.36 bdbrowserhd_i18n/1.8.0.1'],
            ['Opera/9.80 (Linux armv6l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0;THOMSON LF1V401; en) Presto/2.10.250 Version/11.60'],
            ['Opera/9.80 (Linux armv6l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0;THOMSON LF1V394; en) Presto/2.10.250 Version/11.60'],
            ['Opera/9.80 (Linux armv6l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0;THOM LF1V373; en) Presto/2.10.250 Version/11.60'],
            ['Opera/9.80 (Linux armv7l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0;Vendor/THOMSON;SW-Version/V8-MT51F01-LF1V325;Cnt/HRV;Lan/swe; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0) Presto/2.12.362 Version/12.11'],
            ['Opera/9.80 (Linux armv7l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0;Vendor/THOM;SW-Version/V8-MT51F01-LF1V307;Cnt/DEU;Lan/bul) Presto/2.12.362 Version/12.11'],
            ['AppleCoreMedia/1.0.0.12F69 (Apple TV; U; CPU OS 8_3 like Mac OS X; en_us)'],
            ['Opera/9.80 (Linux mips; ) Presto/2.12.407 Version/12.51 MB97/0.0.39.10 (ALDINORD, Mxl661L32, wireless) VSTVB_MB97'],
            ['Opera/9.80 (Linux armv7l; U; CE-HTML/1.0 NETTV/3.3.0; PHILIPS-AVM-2012; en) Presto/2.9.167 Version/11.50'],
            ['Mozilla/3.01 (compatible; Netbox/3.5 R92; Linux 2.2)'],
            ['Opera/9.80 (Linux armv7l; HbbTV/1.2.1 (; Philips; ; ; ; ) CE-HTML/1.0 NETTV/6.0.2 SmartTvA/3.0.0 (PhilipsTV, 6.1.1,) en) Presto/2.12.407 Version/12.50'],
            ['Mozilla/5.0 (X11; Linux aarch64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.84 Safari/537.36 CrKey/1.22.74257'],
            ['Mozilla/5.0 (X11; Linux x86) AppleWebKit/537.30 (KHTML, like Gecko) Safari/537.30 HbbTV/1.1.1 (;Metz;MMS;;;) CE-HTML/1.0 FXM-U2FsdGVkX1/I+pI+pC2BJzChzdtVQ20DxoszKQr/82SvOOeNG27+jrwW50OgfU6C-END'],
            ['Mozilla/5.0 (Linux armv7l) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36 OPR/31.0.1890.0 OMI/4.6.1.40.Dominik2.193 VSTVB MB100 HbbTV/1.2.1 (; ALDINORD; MB120; 2.40.9.1; ;) SmartTvA/3.0.0 CE-HTML/1.0 FXM-U2FsdGVkX1+oZew0140/QNxKXuu32h+r21+34s8L+MjqqqQi/PMpJIi/ttX1gk36-END'],
            ['Mozilla/5.0 (Linux armv7l) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36 OPR/31.0.1890.0 OMI/4.6.1.40.Dominik2.193'],
            ['Mozilla/5.0 (Web0S; Linux/SmartTV) AppleWebKit/537.36 (KHTML, like Gecko) QtWebEngine/5.2.1 Chr0me/38.0.2125.122 Safari/537.36 LG Browser/8.00.00(LGE; 32LH590U-ZE; 03.01.00; 1; DTV_W16R); webOS.TV-2016; LG NetCast.TV-2013 Compatible (LGE, 32LH590U-ZE, wireless)'],
            ['Mozilla/5.0 (DirectFB; Linux armv7l) AppleWebKit/534.26+ (KHTML, like Gecko) Version/5.0 Safari/534.26+ LG Browser/5.00.00(+mouse+3D+SCREEN+TUNER; LGE; 47LM9600-NA; 06.00.00; 0x00000001;); LG NetCast.TV-2012 0'],
            ['Mozilla/5.0 (Linux; U) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36 OPR/46.0.2207.0 LOEWE-SL320/4.6.13.0 HbbTV/1.2.1 (; LOEWE; SL320; LOH/4.6.13.0;;) CE-HTML/1.0 Config(L:deu,CC:DEU) NETRANGEMMH'],
            ['Mozilla/4.0 (compatible; MSIE 5.01; Windows 98; Linux 3.3.8-3.3) [Netgem; 7.7.01-51; i-Player; netbox; sezmi_totalgem]'],
            ['LG Browser/7.00.00(LGE; WEBOS1; 00.00.00) webOS.TV-2015)'],
            ['Mozilla/5.0 (Unknown; Linux armv7l) AppleWebKit/537.1+ Hybridcast/1.0(;00E091;LGwebOSTV;1;0;)0'],
            ['Mozilla/5.0 (Unknown; Linux armv7l) AppleWebKit/537.1+ (KHTML, like Gecko) Safari/537.1+ OHTV/1.0 ( ;LGE ;GLOBAL-PLAT4 ;02.22.01 ;0x00000001'],
            ['Mozilla/5.0 (Linux aarch64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36 OPR/36.0.2128.0 OMI/4.8.0.129.JFK.669 TiVo, TiVo_STB_BCM7278/21.11.1.v22-USM-12 (TiVo, TCDD6F000, wired)'],
            ['Mozilla/5.0 (Linux aarch64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36 OPR/36.0.2128.0 OMI/4.8.0.129.JFK.669 TiVo, TiVo_STB_BCM7278/21.11.1.v22-USM-12 (TiVo, TCDD6E000, wireless)'],
            ['Mozilla/5.0 (Linux aarch64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36 OPR/36.0.2128.0 OMI/4.8.0.129.JFK.669 TiVo, TiVo_STB_BCM7278/21.11.1.v22-USM-12 (TiVo, TCDD6F000, wireless)'],
        ];
    }

    /** @throws ExpectationFailedException */
    #[DataProvider('providerIsNotTv')]
    public function testIsNotTv(string $agent): void
    {
        self::assertFalse(
            $this->object->isTvDevice($agent),
            sprintf('isMobile detected to TRUE instead of expected FALSE for UA "%s"', $agent),
        );
    }

    /**
     * @return array<int, array<int, string>>
     *
     * @throws void
     */
    public static function providerIsNotTv(): array
    {
        return [
            ['Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) MxNitro/1.0.0.2000 Chrome/35.0.1849.0 Safari/537.36'],
            ['Mozilla/5.0 (Mobile; ALCATELOneTouch4012X/SVN 01010B; rv:18.1) Gecko/18.1 Firefox/18.1'],
            ['Mozilla/5.0 (PLAYSTATION 3; 2.00)'],
            ['Microsoft Office Word 2013 (15.0.4693) Windows NT 6.2'],
            ['Microsoft Outlook Social Connector (15.0.4569) MsoStatic (15.0.4569)'],
            ['Mozilla/5.0 (X11; U; Linux Core i7-4980HQ; de; rv:32.0; compatible; Jobboerse.com; http://www.xn--jobbrse-d1a.com) Gecko/20100401 Firefox/24.0'],
            ['gvfs/1.4.3'],
            ['Mozilla/5.0 (X11; NetBSD amd64; rv:43.0) Gecko/20100101 Firefox/43.0'],
            ['Mozilla/5.0 (X11; U; SunOS sun4u; pl-PL; rv:1.8.1.6) Gecko/20071217 Firefox/2.0.0.6'],
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
            ['WAP Browser-Karbonn K84/1.0.0'],
            ['Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/534.24 (KHTML, like Gecko) Chrome/61.0.3163.128 Safari/534.24 XiaoMi/MiuiBrowser/9.4.1-Beta'],
            ['Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; Metzler Offline Explorer; GTB6; Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1) ; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0; freenet.de frndial 5.0; .NET CLR 2.0.50727; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; .NET4.0C; .NET4.0E)'],
            ['Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; Touch; MDDCJS; rv:11.0) like Gecko'],
            ['Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.141 CitizenFX/1.0.0.6556 Safari/537.36'],
            ['Mozilla/5.0 (Linux; Android 10; GM1910 Build/QKQ1.190716.003; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/66.0.3359.126 MBrowser/6.2 TBS/045008 Mobile Safari/537.36 BiliApp/5531000 mobi_app/android channel/oppo Buvid/<hide> internal_version/5531000'],
        ];
    }
}
