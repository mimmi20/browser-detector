<?php

namespace BrowserDetectorTest\Detector\Factory\Device\Mobile;

use BrowserDetector\Detector\Factory\Device\Mobile\AsusFactory;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class AsusFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerDetect
     *
     * @param string $agent
     * @param string $deviceName
     * @param string $marketingName
     * @param string $manufacturer
     * @param string $brand
     * @param string $deviceType
     * @param bool   $dualOrientation
     * @param string $pointingMethod
     */
    public function testDetect($agent, $deviceName, $marketingName, $manufacturer, $brand, $deviceType, $dualOrientation, $pointingMethod)
    {
        /** @var \UaResult\Device\DeviceInterface $result */
        $result = AsusFactory::detect($agent);

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
        self::assertSame(
            $deviceType,
            $result->getType()->getName(),
            'Expected device type to be "' . $deviceType . '" (was "' . $result->getType()->getName() . '")'
        );
        self::assertSame(
            $dualOrientation,
            $result->getDualOrientation(),
            'Expected dual orientation to be "' . $dualOrientation . '" (was "' . $result->getDualOrientation() . '")'
        );
        self::assertSame(
            $pointingMethod,
            $result->getPointingMethod(),
            'Expected pointing method to be "' . $pointingMethod . '" (was "' . $result->getPointingMethod() . '")'
        );
    }

    /**
     * @return array[]
     */
    public function providerDetect()
    {
        return [
            [
                'UCWEB/2.0(Linux; U; Opera Mini/7.1.32052/30.3697; en-US; PadFone 2 Build/JRO03L) U2/1.0.0 UCBrowser/10.7.0.636 Mobile',
                'A68',
                'PadFone 2',
                'Asus',
                'Asus',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'UCWEB/2.0(Linux; U; Opera Mini/7.1.32052/30.3697; en-US; Nexus 7 Build/LMY47V) U2/1.0.0 UCBrowser/10.6.2.599 Mobile',
                'Nexus 7',
                'Nexus 7',
                'Asus',
                'Google',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Linux Ventana; de-de; Transformer TF101G Build/HTJ85B) AppleWebKit/534.13 (KHTML, like Gecko) Chrome/8.0 Safari/534.13',
                'Eee Pad Transformer TF101G',
                'Eee Pad Transformer TF101',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Dalvik/1.6.0 (Linux; U; Android 4.2.2; ME302KL Build/JDQ39)',
                'ME302KL',
                'Memo Pad FHD 10',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0; K013 Build/LRX21V; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/49.0.2623.108 Safari/537.36',
                'K013',
                'Memo Pad 7',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; ME302C Build/JDQ39) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Safari/537.36',
                'ME302C',
                'Memo Pad FHD 10',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; ru; ASUS_T00J) U2/1.0.0 UCBrowser/8.9.2.373 Mobile',
                'T00J',
                'ZenFone 5',
                'Asus',
                'Asus',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; ru; ASUS_T00N) U2/1.0.0 UCBrowser/8.9.2.373 Mobile',
                'T00N',
                'PadFone S',
                'Asus',
                'Asus',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0.2; P01Y Build/LRX22G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.89 Safari/537.36',
                'P01Y',
                'ZenPad C 7.0',
                'Asus',
                'Asus',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.1; TF300T Build/LMY47D) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/39.0.0.0 Safari/537.36',
                'TF300T',
                'Transformer Pad TF300T',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
        ];
    }
}
