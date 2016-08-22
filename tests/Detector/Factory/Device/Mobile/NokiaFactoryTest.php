<?php

namespace BrowserDetectorTest\Detector\Factory\Device\Mobile;

use BrowserDetector\Detector\Factory\Device\Mobile\NokiaFactory;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class NokiaFactoryTest extends \PHPUnit_Framework_TestCase
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
        $result = NokiaFactory::detect($agent);

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
                'Mozilla/5.0 (Series40; NokiaC2-03/06.96; Profile/MIDP-2.1 Configuration/CLDC-1.1) Gecko/20100401 S40OviBrowser/5.0.0.0.31',
                'C2-03',
                'C2',
                'Nokia',
                'Nokia',
            ],
            [
                'Nokia205/2.0 (03.19) Profile/MIDP-2.1 Configuration/CLDC-1.1 UCWEB/2.0 (Java; U; MIDP-2.0; en-US; Nokia205) U2/1.0.0 UCBrowser/9.5.0.449 U2/1.0.0 Mobile',
                'Asha 205',
                'Asha 205',
                'Nokia',
                'Nokia',
            ],
            [
                'Nokia311/5.0 (03.81) Profile/MIDP-2.1 Configuration/CLDC-1.1 UCWEB/2.0 (Java; U; MIDP-2.0; en-US; Nokia311) U2/1.0.0 UCBrowser/9.5.0.449 U2/1.0.0 Mobile',
                '311',
                'Asha 311',
                'Nokia',
                'Nokia',
            ],
            [
                'NokiaX2-01/5.0 (08.71) Profile/MIDP-2.1 Configuration/CLDC-1.1 UCWEB/2.0 (Java; U; MIDP-2.0; en-US; NokiaX2-01) U2/1.0.0 UCBrowser/9.4.1.377 U2/1.0.0 Mobile',
                'X2-01',
                'X2',
                'Nokia',
                'Nokia',
            ],
            [
                'Nokia110/2.0 (03.47) Profile/MIDP-2.1 Configuration/CLDC-1.1 UCWEB/2.0 (Java; U; MIDP-2.0; en-US; Nokia110) U2/1.0.0 UCBrowser/9.5.0.449 U2/1.0.0 Mobile',
                '110',
                '110',
                'Nokia',
                'Nokia',
            ],
            [
                'NokiaC2-03/2.0 (07.63) Profile/MIDP-2.1 Configuration/CLDC-1.1 UCWEB/2.0 (Java; U; MIDP-2.0; en-US; NokiaC2-03) U2/1.0.0 UCBrowser/9.5.0.449 U2/1.0.0 Mobile',
                'C2-03',
                'C2',
                'Nokia',
                'Nokia',
            ],
            [
                'Nokia206/2.0 (04.52) Profile/MIDP-2.1 Configuration/CLDC-1.1 UCWEB/2.0 (Java; U; MIDP-2.0; en-US; Nokia206) U2/1.0.0 UCBrowser/9.5.0.449 U2/1.0.0 Mobile',
                'Asha 206',
                'Asha 206',
                'Nokia',
                'Nokia',
            ],
            [
                'Nokia200/2.0 (12.04) Profile/MIDP-2.1 Configuration/CLDC-1.1 UCWEB/2.0 (Java; U; MIDP-2.0; en-US; Nokia200) U2/1.0.0 UCBrowser/9.5.0.449 U2/1.0.0 Mobile',
                'Asha 200',
                'Asha 200',
                'Nokia',
                'Nokia',
            ],
            [
                'NokiaX2-02/2.0 (11.57) Profile/MIDP-2.1 Configuration/CLDC-1.1 UCWEB/2.0 (Java; U; MIDP-2.0; en-US; NokiaX2-02) U2/1.0.0 UCBrowser/9.5.0.449 U2/1.0.0 Mobile',
                'X2-02',
                'X2',
                'Nokia',
                'Nokia',
            ],
            [
                'Nokia308/2.0 (05.80) Profile/MIDP-2.1 Configuration/CLDC-1.1 UCWEB/2.0 (Java; U; MIDP-2.0; en-US; Nokia308) U2/1.0.0 UCBrowser/9.5.0.449 U2/1.0.0 Mobile',
                '308',
                '308',
                'Nokia',
                'Nokia',
            ],
            [
                'Nokia305/2.0 (07.42) Profile/MIDP-2.1 Configuration/CLDC-1.1 UCWEB/2.0 (Java; U; MIDP-2.0; en-US; Nokia305) U2/1.0.0 UCBrowser/9.5.0.449 U2/1.0.0 Mobile',
                '305',
                '305',
                'Nokia',
                'Nokia',
            ],
            [
                'NokiaC1-01/2.0 (03.35) Profile/MIDP-2.1 Configuration/CLDC-1.1 nokiac1-01/UC Browser7.6.1.82/69/351 UNTRUSTED/1.0',
                'C1-01',
                'C1',
                'Nokia',
                'Nokia',
            ],
            [
                'Mozilla/5.0 (Symbian/3; Series60/5.3 Nokia500/111.021.0028; Profile/MIDP-2.1 Configuration/CLDC-1.1 ) AppleWebKit/535.1 (KHTML, like Gecko) NokiaBrowser/8.3.1.4 Mobile Safari/535.1 3gpp-gba',
                '500',
                '500',
                'Nokia',
                'Nokia',
            ],
            [
                'Mozilla/5.0 (Series30Plus; Nokia220/10.03.11; Profile/Series30Plus Configuration/Series30Plus) Gecko/20100401 S40OviBrowser/3.8.1.0.5',
                '220',
                'Asha 220',
                'Nokia',
                'Nokia',
            ],
            [
                'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 650) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/13.10586',
                'Lumia 650',
                'Lumia 650',
                'Microsoft Corporation',
                'Microsoft',
            ],
            [
                'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 535) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/13.10586',
                'Lumia 535',
                'Lumia 535',
                'Microsoft Corporation',
                'Microsoft',
            ],
            [
                'Mozilla/5.0 (Windows NT 6.2; ARM; Trident/7.0; Touch; rv:11.0; WPDesktop; Lumia 640 LTE) like Gecko',
                'Lumia 640 LTE',
                'Lumia 640 LTE',
                'Microsoft Corporation',
                'Microsoft',
            ],
            [
                'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 540 Dual SIM) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/13.10586',
                'Lumia 540',
                'Lumia 540',
                'Microsoft Corporation',
                'Microsoft',
            ],
            [
                'UCWEB/2.0 (Java; U; MIDP-2.0; Nokia203/20.37) U2/1.0.0 UCBrowser/8.7.0.218 U2/1.0.0 Mobile',
                'Asha 203',
                'Asha 203',
                'Nokia',
                'Nokia',
            ],
            [
                'Nokia6120c/3.83; Profile/MIDP-2.0 Configuration/CLDC-1.1 Google',
                '6120c',
                '6120 Classic',
                'Nokia',
                'Nokia',
            ],
            [
                'UCWEB/2.0 (Windows; U; wds 8.10; de-DE; NOKIA; RM-974_1080) U2/1.0.0 UCBrowser/4.2.1.541 U2/1.0.0 Mobile',
                'RM-974',
                'Lumia 635 International',
                'Nokia',
                'Nokia',
            ],
            [
                'UCWEB/2.0 (Windows; U; wds 8.10; de-DE; NOKIA; RM-1045_1012) U2/1.0.0 UCBrowser/4.2.1.541 U2/1.0.0 Mobile',
                'RM-1045',
                'Lumia 930 International',
                'Nokia',
                'Nokia',
            ],
        ];
    }
}
