<?php

namespace BrowserDetectorTest\Detector\Factory\Device\Mobile;

use BrowserDetector\Detector\Factory\Device\Mobile\XiaomiFactory;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class XiaomiFactoryTest extends \PHPUnit_Framework_TestCase
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
        $result = XiaomiFactory::detect($agent);

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
                'UCWEB/2.0(Linux; U; Opera Mini/7.1.32052/30.3697; en-US; HM NOTE 1S Build/KTU84P) U2/1.0.0 UCBrowser/10.5.2.582 Mobile',
                'HM NOTE 1S',
                'HM NOTE 1S',
                'Xiaomi Tech',
                'Xiaomi',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; Redmi_Note_3) U2/1.0.0 UCBrowser/9.7.0.520 Mobile',
                'Redmi Note 3',
                'Redmi Note 3',
                'Xiaomi Tech',
                'Xiaomi',
            ],
        ];
    }
}
