<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Helper;

use BrowserDetector\Helper;
use PHPUnit\Framework\TestCase;
use Stringy\Stringy;

class AndroidOsTest extends TestCase
{
    /**
     * @dataProvider providerIsAndroidOs
     *
     * @param string $agent
     *
     * @return void
     */
    public function testIsAndroidOs(string $agent): void
    {
        self::markTestIncomplete();
        self::assertTrue((new Helper\AndroidOs(new Stringy($agent)))->isAndroid());
    }

    /**
     * @return array[]
     */
    public function providerIsAndroidOs(): array
    {
        return [
            ['Mozilla/5.0 (X11; U; Linux x86_64; en-gb) AppleWebKit/537.36 (KHTML, like Gecko)  Chrome/30.0.1599.114 Safari/537.36 Puffin/4.1.1.1119AP'],
            ['Mozilla/5.0 (Linux; U; en-us; BeyondPod 4)'],
            ['Opera/9.80 (Android; Opera Mini/9.0.1829/37.6283; U; de) Presto/2.12.423 Version/12.16'],
            ['Mozilla/5.0 (Linux; U; Android OUYA 4.1.2; en-us; OUYA Build/JZO54L-OUYA) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30'],
            ['Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_3; HTC_Sensation_Z710e; da-dk) AppleWebKit/533.16 (KHTML, like Gecko) Version/5.0 Safari/533.16'],
        ];
    }

    /**
     * @dataProvider providerIsNotAndroidOs
     *
     * @param string $agent
     *
     * @return void
     */
    public function testIsNotAndroidOs(string $agent): void
    {
        self::markTestIncomplete();
        self::assertFalse((new Helper\AndroidOs(new Stringy($agent)))->isAndroid());
    }

    /**
     * @return array[]
     */
    public function providerIsNotAndroidOs(): array
    {
        return [
            ['Microsoft Office Excel 2013'],
            ['Mozilla/5.0 (X11; U; Linux Core i7-4980HQ; de; rv:32.0; compatible; Jobboerse.com; http://www.xn--jobbrse-d1a.com) Gecko/20100401 Firefox/24.0'],
            ['Mozilla/5.0 (compatible; MSIE or Firefox mutant; not on Windows server; + http://tab.search.daum.net/aboutWebSearch.html) Daumoa/3.0'],
            ['amarok/2.8.0 (Phonon/4.8.0; Phonon-VLC/0.8.0) LibVLC/2.2.1'],
            ['Mozilla/4.0 (compatible; MSIE 6.0; Windows 95; PalmSource; Blazer 3.0) 16; 160x160'],
            ['Mozilla/4.0 (compatible; MSIE 4.01; Windows CE; PPC; 240x320; SPV M700; OpVer 19.123.2.733) OrangeBot-Mobile 2008.0 (mobilesearch.support@orange-ftgroup.com)'],
            ['Mozilla/5.0 (X11; U; Linux x86_64; ar-SA) AppleWebKit/534.35 (KHTML, like Gecko)  Chrome/11.0.696.65 Safari/534.35 Puffin/3.11546IP'],
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
            ['Opera/9.80 (Windows Mobile; Opera Mini/5.1.21595/37.6334; U; de) Presto/2.12.423 Version/12.16'],
            ['Opera/9.80 (J2ME/MIDP; Opera Mini/4.2.22228/37.6334; U; de) Presto/2.12.423 Version/12.16'],
            ['YUANDA50_12864_11B_HW (MRE\\2.5.00(800) resolution\\320480 chipset\\MT6250 touch\\1 tpannel\\1 camera\\1 gsensor\\0 keyboard\\reduced) C529AH_JY_539_W1.11B.V2.2 Release/2012.09.26 WAP Browser/MAUI (HTTP PGDL; HTTPS) Profile/ Q03C1-2.40 fr-FR'],
        ];
    }
}
