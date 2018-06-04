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

class WindowsTest extends TestCase
{
    /**
     * @dataProvider providerIsWindows
     *
     * @param string $agent
     *
     * @return void
     */
    public function testIsWindows(string $agent): void
    {
        self::assertTrue((new Helper\Windows(new Stringy($agent)))->isWindows());
    }

    /**
     * @return array[]
     */
    public function providerIsWindows(): array
    {
        return [
            ['Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0)'],
            ['Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.9) Gecko/2008052906 Firefox/3.0'],
            ['Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)'],
            ['Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4'],
            ['Mozilla/5.0 (Windows NT 6.3; Win64; x64; Trident/7.0; Touch; rv:11.0) like Gecko'],
            ['revolt'],
            ['Microsoft Office Word 2013 (15.0.4693) Windows NT 6.2'],
            ['Microsoft Outlook Social Connector (15.0.4569) MsoStatic (15.0.4569)'],
            ['WMPlayer/10.0.0.364 guid/3300AD50-2C39-46C0-AE0A-AC7B8159E203'],
            ['NSPlayer/12.00.10011.16384 WMFSDK/12.00.10011.16384'],
            ['Mozilla/5.0 (Windows NT 5.2) AppleWebKit/5342 (KHTML, like Gecko) Chrome/36.0.873.0 Mobile Safari/5342'],
            ['Mozilla/5.0 (Windows; U; Windows NT 5.1; fr; rv:1.9.2.13) Gecko/20101203 iPhone'],
            ['Opera/9.80 (Windows NT 6.0; Opera Mobi/49; U; en) Presto/2.4.18 Version/10.00'],
            ['BarcaPro/1.4.12'],
            ['Barca/2.8.2'],
            ['The Bat! 4.0.0.22'],
            ['Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; Touch; tb-webde/2.6.9; MASEJS; rv:11.0) like Gecko'],
            ['Mozilla/5.0 (Windows NT 5.1; rv:) Gecko/20100101 Firefox/ anonymized by Abelssoft 1433017337'],
            ['Mozilla/5.0 (Windows 95; Anonymisiert durch AlMiSoft Browser-Anonymisierer 69351893; Trident/7.0; rv:11.0) like Gecko'],
            ['Wget/1.17.1 (cygwin)'],
        ];
    }

    /**
     * @dataProvider providerIsNotWindows
     *
     * @param string $agent
     *
     * @return void
     */
    public function testIsNotWindows(string $agent): void
    {
        self::assertFalse((new Helper\Windows(new Stringy($agent)))->isWindows());
    }

    /**
     * @return array[]
     */
    public function providerIsNotWindows(): array
    {
        return [
            ['Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3'],
            ['Microsoft Office Excel 2013'],
            ['Mozilla/5.0 (X11; U; Linux Core i7-4980HQ; de; rv:32.0; compatible; Jobboerse.com; http://www.xn--jobbrse-d1a.com) Gecko/20100401 Firefox/24.0'],
            ['Mozilla/5.0 (compatible; MSIE or Firefox mutant; not on Windows server; + http://tab.search.daum.net/aboutWebSearch.html) Daumoa/3.0'],
            ['amarok/2.8.0 (Phonon/4.8.0; Phonon-VLC/0.8.0) LibVLC/2.2.1'],
            ['Mozilla/4.0 (compatible; MSIE 6.0; Windows 95; PalmSource; Blazer 3.0) 16; 160x160'],
            ['DWDS-Crawler +http://odo.dwds.de/dwds-crawler.html'],
            ['Mozilla/5.0 (iPhone; CPU iPhone OS 8_0_2 like Mac OS X) (Windows NT 6.1; WOW64) AppleWebKit/600.1.4 (KHTML, like Gecko) Mobile/12A405 MicroMessenger/5.4.2 NetType/WIFI'],
            ['>Forum.WindowsFAQ.ru</a>'],
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
            ['Mozilla/4.0 (compatible; MSIE 4.01; Windows CE; PPC; 240x320; SPV M700; OpVer 19.123.2.733) OrangeBot-Mobile 2008.0 (mobilesearch.support@orange-ftgroup.com)'],
            ['UCWEB/2.0 (Windows; U; wds 7.10; en-US; SAMSUNG; GT-I8350) U2/1.0.0 UCBrowser/3.2.0.340 U2/1.0.0 Mobile'],
            ['Mozilla/5.0 (Windows IoT 10.0; Android 6.0.1; WebView/3.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Mobile Safari/537.36 Edge/17.17083'],
        ];
    }

    /**
     * @dataProvider providerIsMobileWindows
     *
     * @param string $agent
     *
     * @return void
     */
    public function testIsMobileWindows(string $agent): void
    {
        self::assertTrue((new Helper\Windows(new Stringy($agent)))->isMobileWindows());
    }

    /**
     * @return array[]
     */
    public function providerIsMobileWindows(): array
    {
        return [
            ['Mozilla/4.0 (compatible; MSIE 4.01; Windows CE; PPC; 240x320; SPV M700; OpVer 19.123.2.733) OrangeBot-Mobile 2008.0 (mobilesearch.support@orange-ftgroup.com)'],
            ['UCWEB/2.0 (Windows; U; wds 7.10; en-US; SAMSUNG; GT-I8350) U2/1.0.0 UCBrowser/3.2.0.340 U2/1.0.0 Mobile'],
            ['Opera/9.80 (Windows Mobile; Opera Mini/5.1.21595/37.6334; U; de) Presto/2.12.423 Version/12.16'],
            ['MQQBrowser/2.6/WP7 (zh-cn;WPOS:7.10.8112;HTC; HD7T9292)'],
            ['Mozilla/5.0 (Windows IoT 10.0; Android 6.0.1; WebView/3.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Mobile Safari/537.36 Edge/17.17083'],
        ];
    }

    /**
     * @dataProvider providerIsNotMobileWindows
     *
     * @param string $agent
     *
     * @return void
     */
    public function testIsNotMobileWindows(string $agent): void
    {
        self::assertFalse((new Helper\Windows(new Stringy($agent)))->isMobileWindows());
    }

    /**
     * @return array[]
     */
    public function providerIsNotMobileWindows(): array
    {
        return [
            ['Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3'],
            ['Microsoft Office Excel 2013'],
            ['Mozilla/5.0 (X11; U; Linux Core i7-4980HQ; de; rv:32.0; compatible; Jobboerse.com; http://www.xn--jobbrse-d1a.com) Gecko/20100401 Firefox/24.0'],
            ['Mozilla/5.0 (compatible; MSIE or Firefox mutant; not on Windows server; + http://tab.search.daum.net/aboutWebSearch.html) Daumoa/3.0'],
            ['amarok/2.8.0 (Phonon/4.8.0; Phonon-VLC/0.8.0) LibVLC/2.2.1'],
            ['Mozilla/4.0 (compatible; MSIE 6.0; Windows 95; PalmSource; Blazer 3.0) 16; 160x160'],
            ['Mozilla/5.0 (X11; U; Linux i686; th-TH@calendar=gregorian) AppleWebKit/534.12 (KHTML, like Gecko) Puffin/1.3.2665MS Safari/534.12'],
            ['DWDS-Crawler +http://odo.dwds.de/dwds-crawler.html'],
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
            ['Mozilla/5.0 (Linux; U; Linux Ventana; de-de; Transformer TF101G Build/HTJ85B) AppleWebKit/534.13 (KHTML, like Gecko) Chrome/8.0 Safari/534.13'],
            ['Mozilla/5.0 (X11; U; Linux i686; de; rv:1.9.1.1) Gecko/20090725 Moblin/3.5.1-2.5.14.moblin2 Shiretoko/3.5.1'],
        ];
    }
}
