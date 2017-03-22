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

use BrowserDetector\Factory\Device\Mobile\ZteFactory;
use BrowserDetector\Loader\DeviceLoader;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Stringy\Stringy;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class ZteFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Factory\Device\Mobile\ZteFactory
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
        $this->object = new ZteFactory($cache, $loader);
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
                'general ZTE Device',
                'general ZTE Device',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0; ZTE; Tania)',
                'Tania',
                'Tania',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'ZTE-G-X991-Rio-orange/X991_V1_Z2_FRES_D18F109 Profile/MIDP-2.0 Configuration/CLDC-1.1 Obigo/Q03C',
                'G-X991',
                'Rio',
                'ZTE',
                'Orange',
                'Mobile Phone',
                false,
                null,
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0.2; ZTE Blade V6 Build/LRX22G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.36',
                'Blade V6',
                'Blade V6',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.1.2; zh-cn; ZTE N919 Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30; 360 Aphone Browser (6.9.9.89beta)',
                'N919',
                'N919',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.1; ZTE Blade L5 Plus Build/LMY47I; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/52.0.2743.98 Mobile Safari/537.36',
                'Blade L5 Plus',
                'Blade L5 Plus',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.1; ZTE Blade L6 Build/LMY47I) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.36',
                'Blade L6',
                'Blade L6',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.4; Beeline Pro Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 YaBrowser/14.12.2125.9740.00 Mobile Safari/537.36',
                'Beeline Pro',
                'Beeline Pro',
                'ZTE',
                'ZTE',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'UCWEB/2.0 (MIDP-2.0; U; Adr 4.2.2; es-LA; ZTE_V829) U2/1.0.0 UCBrowser/9.0.2.389 U2/1.0.0 Mobile',
                'V829',
                'Blade G Pro',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.2; en-US; ZTE Geek Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 UCBrowser/10.0.2.523 U3/0.8.0 Mobile Safari/534.30',
                'V975',
                'Geek',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.2; ru; ZTE LEO Q2 Build/JDQ39) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 UCBrowser/9.8.0.435 U3/0.8.0 Mobile Safari/533.1',
                'V769M',
                'Leo Q2',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.2; en-US; ZTE Blade L2 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 UCBrowser/10.0.2.523 U3/0.8.0 Mobile Safari/534.30',
                'Blade L2',
                'Blade L2',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0.2; ZTE Blade L3 Build/LRX22G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.97 Mobile Safari/537.36',
                'Blade L3',
                'Blade L3',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.1; X920 Build/JOP40D) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.102 YaBrowser/14.2.1700.12535.00 Mobile Safari/537.36',
                'X920',
                'X920',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Z221; Mozilla/5.0 (Profile/MIDP-2.0 Configuration/CLDC-1.1; Opera Mini/att/4.2.22250; U; en-US) Opera 9.50',
                'Z221',
                'Z221',
                'ZTE',
                'AT&T',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.1.2; ZTE V970 Build/JZO54K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.96 Mobile Safari/537.36',
                'V970',
                'V970',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.1; en-US; ZTE V967S Build/JOP40D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 UCBrowser/10.1.0.527 U3/0.8.0 Mobile Safari/534.30',
                'V967S',
                'Grand X2',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'MQQBrowser/3.7/Mozilla/5.0 (Linux; U; Android 2.2.2; zh-cn; ZTE-U V880 Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
                'V880',
                'V880',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.2; ru-ru; ZTE V808 Build/JDQ39) AppleWebKit/537.16 (KHTML, like Gecko) Version/4.0 Mobile Safari/537.16',
                'V808',
                'V808',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.3.6; ZTE V788D Build/GRK39F) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile',
                'V788D',
                'Kis Plus',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; V9 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/30.0.0.0 Mobile Safari/537.36',
                'V9',
                'V9',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.0.3; ZTE U930HD Build/IML74K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.93 Mobile Safari/537.36',
                'U930HD',
                'U930HD',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 3.2; de-de; SmartTab10-MSM8260-V03b-Apr162012-Vodafone-DE) AppleWebKit/534.13 (KHTML, like Gecko) Version/4.0 Safari/534.13',
                'Smart Tab 10',
                'Smart Tab 10',
                'ZTE',
                'Vodafone',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 3.2.1; en-US; SmartTab7 Build/HTK75) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 UCBrowser/10.3.0.552 U3/0.8.0 Mobile Safari/534.30',
                'SmartTab7',
                'Smart Tab 7',
                'ZTE',
                'Vodafone',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.2; de-de; Vodafone Smart 4G Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30 SWV/090.37DE',
                'Smart 4G',
                'Smart 4G',
                'ZTE',
                'Vodafone',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.3.5; de-de; ZTE Skate Build/GRJ22) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
                'Skate',
                'Skate',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'VMVID Android Application (13, vmvid v2.1) - wind RACERII ZTE - FFFFFFFF-B8CC-5A5D-FFFF-FFFFDDB6EDFB',
                'Racer II',
                'Racer II',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.1-Strabors-Mod-2.1.3; ru-ru; ZTE Racer Build/ERE27) AppleWebKit/530.17 (KHTML, like Gecko) V',
                'Racer',
                'Racer',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Mobile; ZTEOPEN; rv:18.1) Gecko/18.1 Firefox/18.1',
                'Open',
                'Open',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; NX402 Build/JDQ39) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.116 Mobile Safari/537.36 OPR/21.0.1437.74904',
                'NX402',
                'Nubia Z5 mini',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.4.4; zh-cn; N918St Build/KTU84P) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/5.4 TBS/025410 Mobile Safari/533.1 MicroMessenger/6.1.0.66_r1062275.542 NetType/3gnet',
                'N918St',
                'V5S',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla 5.0 (Linux; U; Android 2.1-update1; zh-cn; ZTE-C N600 Build ERE27) UC AppleWebKit 534.31 (KHTML, like Gecko) Mobile Safari 534.31',
                'N600',
                'N600',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.3.6; de-de; KIS PLUS Build/GRK39F) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
                'V788D',
                'Kis Plus',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; ZTE Blade Q Maxi Build/JDQ39) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.95 Mobile Safari/537.36',
                'Blade Q Maxi',
                'Blade Q Maxi',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; de-de; ZTE BLADE III Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'Blade',
                'Blade',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.2.2; de-de; ZTE-BLADE Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
                'Blade',
                'Blade',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.2; de-de; BASE Tab Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
                'BASE Tab',
                'BASE Tab',
                'ZTE',
                'ZTE',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.0.4; BASE_Lutea_3 Build/IMM76D) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.111 Mobile Safari/537.36',
                'Lutea 3',
                'Lutea 3',
                'ZTE',
                'Base',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.3.5; de-de; BASE Lutea 2 Build/GRJ22) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
                'Lutea 2',
                'Lutea 2',
                'ZTE',
                'Base',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.2.2; de-de; BASE lutea Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1',
                'Blade',
                'Blade',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; ATLAS_W) U2/1.0.0 UCBrowser/9.8.0.534 Mobile',
                'Atlas W',
                'Atlas W',
                'ZTE',
                'ZTE',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
        ];
    }
}
