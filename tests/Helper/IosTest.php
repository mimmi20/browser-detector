<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Helper;

use BrowserDetector\Helper;

/**
 * Test class for KreditCore_Class_BrowserDetector.
 * Generated by PHPUnit on 2010-09-05 at 22:13:26.
 */
class IosTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider providerIsiOSPositive
     *
     * @param string $agent
     */
    public function testIsiOSPositive($agent)
    {
        $object = new Helper\Ios($agent);

        self::assertTrue($object->isIos());
    }

    public function providerIsiOSPositive()
    {
        return [
            ['AntennaPod/1.5.2.0'],
            ['Antenna/965 CFNetwork/758.2.8 Darwin/15.0.0'],
            ['RSS_Radio 1.5'],
            ['RSSRadio (Push Notification Scanner;support@dorada.co.uk)'],
            ['iTunes/10.5.2 (PodCruncher 2.2)'],
            ['https://audioboom.com/boos/'],
            ['Stitcher/iOS'],
            ['CaptiveNetworkSupport-324 wispr'],
            ['Mozilla/5.0 (iOS; U; en) AppleWebKit/533.19.4 (KHTML, like Gecko) AdobeAIR/13.0'],
            ['Mozilla/5.0 (iPad; CPU OS 8_1_2 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12B440 Safari/600.1.4'],
            ['Mozilla/5.0 (X11; U; Linux x86_64; ar-SA) AppleWebKit/534.35 (KHTML, like Gecko)  Chrome/11.0.696.65 Safari/534.35 Puffin/3.11546IP'],
            ['iOS/6.1.3 (10B329) dataaccessd/1.0'],
            ['Mozilla/5.0 (iPhone; CPU iPhone OS 8_0_2 like Mac OS X) (Windows NT 6.1; WOW64) AppleWebKit/600.1.4 (KHTML, like Gecko) Mobile/12A405 MicroMessenger/5.4.2 NetType/WIFI'],
        ];
    }

    /**
     * @dataProvider providerIsiOSNegative
     *
     * @param string $agent
     */
    public function testIsiOSNegative($agent)
    {
        $object = new Helper\Ios($agent);

        self::assertFalse($object->isIos());
    }

    public function providerIsiOSNegative()
    {
        return [
            ['Microsoft Office Excel 2013'],
            ['Mozilla/5.0 (X11; U; Linux Core i7-4980HQ; de; rv:32.0; compatible; Jobboerse.com; http://www.xn--jobbrse-d1a.com) Gecko/20100401 Firefox/24.0'],
            ['Mozilla/5.0 (compatible; MSIE or Firefox mutant; not on Windows server; + http://tab.search.daum.net/aboutWebSearch.html) Daumoa/3.0'],
            ['Mozilla/5.0 (Windows Phone 8.1; ARM; Trident/7.0; Touch; rv:11; IEMobile/11.0) like Android 4.1.2; compatible) like iPhone OS 7_0_3 Mac OS X WebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.99 Mobile Safari /537.36'],
            ['Mozilla/5.0 (Linux; U; Android 4.2.1; de-de; iphone Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30'],
        ];
    }
}
