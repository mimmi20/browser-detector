<?php

namespace BrowserDetectorTest\Helper;

use BrowserDetector\Helper;

/**
 * Test class for KreditCore_Class_BrowserDetector.
 * Generated by PHPUnit on 2010-09-05 at 22:13:26.
 */
class WindowsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerIsWindowsPositive
     *
     * @param string $agent
     */
    public function testIsWindowsPositive($agent)
    {
        self::assertTrue((new Helper\Windows($agent))->isWindows());
    }

    public function providerIsWindowsPositive()
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
        ];
    }

    /**
     * @dataProvider providerIsWindowsNegative
     *
     * @param string $agent
     */
    public function testIsWindowsNegative($agent)
    {
        self::assertFalse((new Helper\Windows($agent))->isWindows());
    }

    public function providerIsWindowsNegative()
    {
        return [
            ['Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3'],
            ['Microsoft Office Excel 2013'],
            ['Mozilla/5.0 (X11; U; Linux Core i7-4980HQ; de; rv:32.0; compatible; Jobboerse.com; http://www.xn--jobbrse-d1a.com) Gecko/20100401 Firefox/24.0'],
            ['Mozilla/5.0 (compatible; MSIE or Firefox mutant; not on Windows server; + http://tab.search.daum.net/aboutWebSearch.html) Daumoa/3.0'],
            ['amarok/2.8.0 (Phonon/4.8.0; Phonon-VLC/0.8.0) LibVLC/2.2.1'],
            ['Mozilla/4.0 (compatible; MSIE 6.0; Windows 95; PalmSource; Blazer 3.0) 16; 160x160'],
        ];
    }

    /**
     * @dataProvider providerIsMobileWindowsPositive
     *
     * @param string $agent
     */
    public function testIsMobileWindowsPositive($agent)
    {
        self::assertTrue((new Helper\Windows($agent))->isMobileWindows());
    }

    public function providerIsMobileWindowsPositive()
    {
        return [
            ['Mozilla/4.0 (compatible; MSIE 4.01; Windows CE; PPC; 240x320; SPV M700; OpVer 19.123.2.733) OrangeBot-Mobile 2008.0 (mobilesearch.support@orange-ftgroup.com)'],
        ];
    }

    /**
     * @dataProvider providerIsMobileWindowsNegative
     *
     * @param string $agent
     */
    public function testIsMobileWindowsNegative($agent)
    {
        self::assertFalse((new Helper\Windows($agent))->isMobileWindows());
    }

    public function providerIsMobileWindowsNegative()
    {
        return [
            ['Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3'],
            ['Microsoft Office Excel 2013'],
            ['Mozilla/5.0 (X11; U; Linux Core i7-4980HQ; de; rv:32.0; compatible; Jobboerse.com; http://www.xn--jobbrse-d1a.com) Gecko/20100401 Firefox/24.0'],
            ['Mozilla/5.0 (compatible; MSIE or Firefox mutant; not on Windows server; + http://tab.search.daum.net/aboutWebSearch.html) Daumoa/3.0'],
            ['amarok/2.8.0 (Phonon/4.8.0; Phonon-VLC/0.8.0) LibVLC/2.2.1'],
            ['Mozilla/4.0 (compatible; MSIE 6.0; Windows 95; PalmSource; Blazer 3.0) 16; 160x160'],
        ];
    }
}
