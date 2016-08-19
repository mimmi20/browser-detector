<?php

namespace BrowserDetectorTest\Detector\Factory;

use BrowserDetector\Detector\Factory\DeviceFactory;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class DeviceFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerDetect
     *
     * @param string $agent
     * @param string $deviceName
     * @param string $marketingName
     * @param string $manufacturer
     * @param string $brand
     */
    public function testDetect($agent, $deviceName, $marketingName, $manufacturer, $brand)
    {
        /** @var \UaResult\Device\DeviceInterface $result */
        $result = DeviceFactory::detect($agent);

        self::assertInstanceOf('\UaResult\Device\DeviceInterface', $result);
        self::assertSame($deviceName, $result->getDeviceName());
        self::assertSame($marketingName, $result->getMarketingName());
        self::assertSame($manufacturer, $result->getManufacturer());
        self::assertSame($brand, $result->getBrand());

        self::assertInternalType('string', $result->getManufacturer());
    }

    /**
     * @return array[]
     */
    public function providerDetect()
    {
        return [
            [
                'Dalvik/1.6.0 (Linux; U; Android 4.4.4; MI PAD MIUI/5.11.1)',
                'Mi Pad',
                'Mi Pad',
                'Xiaomi Tech',
                'Xiaomi',
            ],
            [
                'Dalvik/2.1.0 (Linux; U; Android 6.0.1; MI 4LTE MIUI/V7.3.2.0.MXDCNDD) NewsArticle/5.1.3',
                'Mi 4 LTE',
                'Mi 4 LTE',
                'Xiaomi Tech',
                'Xiaomi',
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 4.01; Windows CE; PPC; 240x320; SPV M700; OpVer 19.123.2.733) OrangeBot-Mobile 2008.0 (mobilesearch.support@orange-ftgroup.com)',
                'M700',
                'M700',
                'SPV',
                'SPV',
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows 95; PalmSource; Blazer 3.0) 16; 160x160',
                'Blazer',
                'Blazer',
                'Palm',
                'Palm',
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows CE; Sprint:PPC-6700) Opera 8.65 [en]',
                '6700',
                '6700',
                'Sprint',
                'Sprint',
            ],
            [
                'Mozilla/5.0 (Macintosh; ARM Mac OS X) AppleWebKit/538.15 (KHTML, like Gecko) Safari/538.15 Version/6.0 Raspbian/8.0 (1:3.8.2.0-0rpi27rpi1g) Epiphany/3.8.2',
                'Raspberry Pi',
                'Raspberry Pi',
                'Raspberry Pi Foundation',
                'Raspberry Pi Foundation',
            ],
            [
                'TIANYU-KTOUCH/A930/Screen-240X320',
                'Tianyu A930',
                'Tianyu A930',
                'K-Touch',
                'K-Touch',
            ],
        ];
    }
}
