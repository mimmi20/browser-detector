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
namespace BrowserDetectorTest\Factory\Device\Mobile;

use BrowserDetector\Factory\Device\Mobile\AsusFactory;
use BrowserDetector\Loader\DeviceLoader;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Stringy\Stringy;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class AsusFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Factory\Device\Mobile\AsusFactory
     */
    private $object = null;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $adapter      = new Local(__DIR__ . '/../../../../cache/');
        $cache        = new FilesystemCachePool(new Filesystem($adapter));
        $loader       = new DeviceLoader($cache);
        $this->object = new AsusFactory($loader);
    }

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
        $s = new Stringy($agent);

        /** @var \UaResult\Device\DeviceInterface $result */
        list($result) = $this->object->detect($agent, $s);

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
            $result->getManufacturer()->getName(),
            'Expected manufacturer name to be "' . $manufacturer . '" (was "' . $result->getManufacturer()->getName() . '")'
        );
        self::assertSame(
            $brand,
            $result->getBrand()->getBrandName(),
            'Expected brand name to be "' . $brand . '" (was "' . $result->getBrand()->getBrandName() . '")'
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
                'this is a fake ua to trigger the fallback',
                'general Asus Device',
                'general Asus Device',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
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
            [
                'Mozilla/5.0 (Linux; U; Android 5.0.2; PadFone T004 Build/LRX22G; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/52.0.2743.98 Mobile Safari/537.36 OPR/18.0.2254.106542',
                'PadFone T004',
                'PadFone T004',
                'Asus',
                'Asus',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; K01E Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Safari/537.36',
                'K01E',
                'K01E',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0; ASUS_Z00AD Build/LRX21V) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.36',
                'Z00AD',
                'Zenfone 2',
                'Asus',
                'Asus',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.1; ASUS Tablet P1801-T Build/JOP40D) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Safari/537.36',
                'P1801-T',
                'Tablet AiO',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'UCWEB/2.0 (MIDP-2.0; U; Adr 6.0.1; en-US; Nexus_7) U2/1.0.0 UCBrowser/10.7.5.785 U2/1.0.0 Mobile',
                'Nexus 7',
                'Nexus 7',
                'Asus',
                'Google',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.1.1; Transformer Prime TF201 Build/JRO03C) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.83 Safari/537.36',
                'Eee Pad TF201',
                'Transformer Prime',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.3; K00C Build/JSS15J) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.117 Safari/537.36 OPR/24.0.1565.82367',
                'K00C',
                'Transformer Pad TF701T',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; K00F Build/JDQ39) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.89 Safari/537.36',
                'K00F',
                'Memo pad ME102',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0; K00Z Build/LRX21V) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.89 Safari/537.36',
                'K00Z',
                'K00Z',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.3; K01A Build/JSS15Q) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.102 Safari/537.36',
                'K01A',
                'Memo Pad 7',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.3; K017 Build/JSS15Q) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.93 Safari/537.36',
                'K017',
                'Memo Pad 7',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.3; K012 Build/JSS15Q) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.94 Safari/537.36',
                'K012',
                'K012',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; K00E Build/KVT49L) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/30.0.0.0 Safari/537.36 ACHEETAHI/2100501066',
                'K00E',
                'FonePad 7',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.1.1; de-de; ME172V Build/JRO03H) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'ME172V',
                'Memo Pad ME172V',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; ME173X Build/JDQ39) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.114 Safari/537.36',
                'ME173X',
                'Memo Pad HD7',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.1; de-de; ME301T Build/JOP40D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'ME301T',
                'Memo Pad Smart 10',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.1.2; ME371MG Build/JZO54K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.102 Safari/537.36',
                'ME371MG',
                'Fonepad ME371MG',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.4; Transformer TF101 Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/33.0.0.0 Safari/537.36 [FB_IAB/FB4A;FBAV/31.0.0.19.13;]',
                'TF101',
                'Eee Pad Transformer TF101',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.1; ASUS Transformer Pad TF300TL Build/JOP40D) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.95 Safari/537.36',
                'TF300TL',
                'Transformer Pad TF300TL',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.1.1; ASUS Transformer Pad TF300TG Build/JRO03C) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.89 Safari/537.36',
                'TF300TG',
                'Transformer Pad TF300T',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.1; ru; ASUS Transformer Pad TF700T) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 UCBrowser/9.4.0.347 U3/0.8.0 Mobile Safari/533.1',
                'TF700T',
                'Transformer Pad TF700T',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.0.3; Slider SL101 Build/IML74K) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.166  Safari/535.19',
                'SL101',
                'Eee Pad SL101 Slider',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.1-update1; de-de; Garmin-Asus A50 Build/ERE27) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17',
                'A50',
                'A50',
                'Asus',
                'Garmin-Asus',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.1-update1; fr-fr; Garmin-Asus A10 Build/ERE27) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17; A10-V5.0.67-user-20101018',
                'A10',
                'A10',
                'Asus',
                'Garmin-Asus',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; Transformer Prime Build/JDQ39) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.58 Safari/537.31',
                'Eee Pad TF201',
                'Transformer Prime',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; de-de; PadFone Build/IMM76I) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'PadFone',
                'PadFone',
                'Asus',
                'Asus',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 7.0; Windows Phone OS 7.0; Trident/3.1; IEMobile/ 7.0; WpsLondonTest; Asus;Galaxy6)',
                'Galaxy6',
                'Galaxy6',
                'Asus',
                'Asus',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 1.5; en-us; eee_701 Build/CUPCAKE) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1',
                'EEE 701',
                'EEE 701',
                'Asus',
                'Asus',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; ASUS_T00Q Build/KVT49L) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/30.0.0.0 Mobile Safari/537.36',
                'T00Q',
                'Zenfone 4 A450CG',
                'Asus',
                'Asus',
                'Smartphone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; K019 Build/KVT49L) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.132 Safari/537.36',
                'K019',
                'Fonepad 7 FE375CG',
                'Asus',
                'Asus',
                'FonePad',
                true,
                'touchscreen',
            ],
        ];
    }
}
