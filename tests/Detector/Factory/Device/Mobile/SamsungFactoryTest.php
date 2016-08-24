<?php

namespace BrowserDetectorTest\Detector\Factory\Device\Mobile;

use BrowserDetector\Detector\Factory\Device\Mobile\SamsungFactory;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class SamsungFactoryTest extends \PHPUnit_Framework_TestCase
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
        $result = SamsungFactory::detect($agent);

        self::assertInstanceOf('\UaResult\Device\DeviceInterface', $result);

        self::assertSame(
            $deviceName,
            $result->getDeviceName(),
            'Expected device name to be "' . $deviceName . '" (was "' . $result->getDeviceName() . '")'
        );
        self::assertSame(
            $marketingName,
            $result->getMarketingName(),
            'Expected marketing name to be "' . $marketingName . '" (was "' . $result->getMarketingName() . '")'
        );
        self::assertSame(
            $manufacturer,
            $result->getManufacturer(),
            'Expected manufacturer name to be "' . $manufacturer . '" (was "' . $result->getManufacturer() . '")'
        );
        self::assertSame(
            $brand,
            $result->getBrand(),
            'Expected brand name to be "' . $brand . '" (was "' . $result->getBrand() . '")'
        );

        self::assertInternalType('string', $result->getManufacturer());
    }

    /**
     * @return array[]
     */
    public function providerDetect()
    {
        return [
            [
                'SAMSUNG-GT-C3312R Opera/9.80 (X11; Linux zvav; U; en) Presto/2.12.423 Version/12.16',
                'GT-C3312R',
                'GT-C3312R',
                'Samsung',
                'Samsung',
                'unknown',
                'unknown',
                'unknown',
            ],
            [
                'SAMSUNG-GT-C3350/C3350MBULF1 NetFront/4.2 Profile/MIDP-2.0 Configuration/CLDC-1.1',
                'GT-C3350',
                'GT-C3350',
                'Samsung',
                'Samsung',
                'unknown',
                'unknown',
                'unknown',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; SM-A500F Build/LRX22G) U2/1.0.0 UCBrowser/10.6.8.732 Mobile',
                'SM-A500F',
                'Galaxy A5',
                'Samsung',
                'Samsung',
                'unknown',
                'unknown',
                'unknown',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0.2; SM-A500FU Build/LRX22G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.133 Mobile Safari/537.36',
                'SM-A500FU',
                'Galaxy A5 (Europe)',
                'Samsung',
                'Samsung',
                'unknown',
                'unknown',
                'unknown',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; GT-N7100) U2/1.0.0 UCBrowser/10.1.2.571 Mobile',
                'GT-N7100',
                'Galaxy Note II',
                'Samsung',
                'Samsung',
                'unknown',
                'unknown',
                'unknown',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; GT-I9001) U2/1.0.0 UCBrowser/9.8.0.534 Mobile',
                'GT-I9001',
                'GT-I9001',
                'Samsung',
                'Samsung',
                'unknown',
                'unknown',
                'unknown',
            ],
            [
                'Mozilla/5.0 (SAMSUNG; SAMSUNG-GT-S8530-VODAFONE/S8530BUJL1; U; Bada/1.2; de-de) AppleWebKit/533.1 (KHTML, like Gecko) Dolfin/2.2 Mobile WVGA SMM-MMS/1.2.0 NexPlayer/3.0 profile/MIDP-2.1 configuration/CLDC-1.1 OPN-B',
                'GT-S8530',
                'Wave 2',
                'Samsung',
                'Samsung',
                'unknown',
                'unknown',
                'unknown',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; GT-S6312 Build/JZO54K) U2/1.0.0 UCBrowser/10.2.0.584 Mobile',
                'GT-S6312',
                'Galaxy Young DUOS',
                'Samsung',
                'Samsung',
                'unknown',
                'unknown',
                'unknown',
            ],
        ];
    }
}
