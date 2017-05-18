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

use BrowserDetector\Factory\Device\Mobile\PrestigioFactory;
use BrowserDetector\Loader\DeviceLoader;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Stringy\Stringy;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class PrestigioFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Factory\Device\Mobile\PrestigioFactory
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
        $this->object = new PrestigioFactory($loader);
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
                'general Prestigio Device',
                'general Prestigio Device',
                'Prestigio',
                'Prestigio',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; PRESTIGIO; PSP8400DUO) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537',
                'PSP8400',
                'MultiPhone 8400 Duo',
                'Prestigio',
                'Prestigio',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; PRESTIGIO; PSP8500DUO) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537',
                'PSP8500',
                'MultiPhone 8500 Duo',
                'Prestigio',
                'Prestigio',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.2; ru-ru; Prestigio PAP5000TDUO Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30 XiaoMi/MiuiBrowser/1.0',
                'PAP5000TDUO',
                'Multipad 2 Ultra Duo 8.0 3G',
                'Prestigio',
                'Prestigio',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; PMT3037_3G Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 YaBrowser/13.9.1500.3524 Safari/537.36',
                'PMT3037_3G',
                'MultiPad Wize 3037 3G',
                'Prestigio',
                'Prestigio',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.3.3; ru; PMP7074B3GRU Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 UCBrowser/9.6.0.378 U3/0.8.0 Mobile Safari/533.1',
                'PMP7074B3GRU',
                'MultiPad 7074',
                'Prestigio',
                'Prestigio',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.1; ru-ee; PAP7600DUO Build/JOP40D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'PAP7600DUO',
                'Multiphone 7600 Duo',
                'Prestigio',
                'Prestigio',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; ru; PAP4500DUO Build/PrestigioPAP4500DUO) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1 UCBrowser/9.9.0.543 Mobile',
                'PAP4500DUO',
                'MultiPhone 4500 Duo',
                'Prestigio',
                'Prestigio',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; PAP5503 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.108 Mobile Safari/537.36',
                'PAP5503',
                'MultiPhone 5503',
                'Prestigio',
                'Prestigio',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; PMP3007C Build/JDQ39) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.138 Safari/537.36 OPR/22.0.1485.81203',
                'PMP3007C',
                'MultiPad Rider 7.0 3G',
                'Prestigio',
                'Prestigio',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.1.1; PAP4044DUO Build/PrestigioPAP4044DUO) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 YaBrowser/14.7.1916.15743.00 Mobile Safari/537.36',
                'PAP4044DUO',
                'MultiPhone 4044 Duo',
                'Prestigio',
                'Prestigio',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.4; PAP5044DUO Build/16.0.B.2.13) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.68 Mobile Safari/537.36',
                'PAP5044DUO',
                'MultiPhone 5044 Duo',
                'Prestigio',
                'Prestigio',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.2; lv-lv; PAP3350DUO Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'PAP3350DUO',
                'MultiPhone 3350 Duo',
                'Prestigio',
                'Prestigio',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.1.1; en-US; PMP3970B Build/JRO03C) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 UCBrowser/10.3.0.552 U3/0.8.0 Mobile Safari/534.30',
                'PMP3970B',
                'MultiPad 7.0 HD',
                'Prestigio',
                'Prestigio',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; PMT7077_3G Build/JDQ39) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.59 Safari/537.36',
                'PMT7077_3G',
                'MultiPad 4 Diamond 7.85, 3G',
                'Prestigio',
                'Prestigio',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.3; PMT3287_3G Build/JLS36C) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.114 Safari/537.36',
                'PMT3287_3G',
                'MultiPad Ranger 8.0 3G Wifi',
                'Prestigio',
                'Prestigio',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.3; PMT3277_3G Build/JLS36C) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.114 Safari/537.36',
                'PMT3277_3G',
                'MultiPad Ranger 7.0 3G',
                'Prestigio',
                'Prestigio',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; PMT5587_Wi Build/JDQ39) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.94 Safari/537.36',
                'PMT5587_Wi',
                'MultiPad 8.0 HD',
                'Prestigio',
                'Prestigio',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; PMT3377_Wi Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.102 Safari/537.36',
                'PMT3377_Wi',
                'MultiPad Thunder 7.0i',
                'Prestigio',
                'Prestigio',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.1; PMP7480D3G_QUAD Build/PMP7480D3G) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.58 Safari/537.31',
                'PMP7480D3G_QUAD',
                'MultiPad 4 Ultimate 8.0 3G',
                'Prestigio',
                'Prestigio',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.2; hr-hr; PMP7380D3G_QUAD Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'PMP7380D3G',
                'PMP7380D3G',
                'Prestigio',
                'Prestigio',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; PMP7280C3G_QUAD Build/JDQ39) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.94 Safari/537.36',
                'PMP7280C3G_QUAD',
                'MultiPad 4 Ultra Quad 8.0 3G',
                'Prestigio',
                'Prestigio',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; PMP7280C3G_QUAD Build/JDQ39) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.94 Safari/537.36',
                'PMP7280C3G_QUAD',
                'MultiPad 4 Ultra Quad 8.0 3G',
                'Prestigio',
                'Prestigio',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.0.4; PMP7170B3G Build/IMM76D) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 YaBrowser/14.12.2125.9740.01 Safari/537.36',
                'PMP7170B3G',
                'Multipad 7.0 Prime 3G',
                'Prestigio',
                'Prestigio',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; de-de; PMP7100D3G Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'PMP7100D3G',
                'Multipad',
                'Prestigio',
                'Prestigio',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; PMP7079D_QUAD Build/PMP7079DQUAD.20131016.1.0.07) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.131 YaBrowser/14.5.1847.18432.00 Safari/537.36',
                'PMP7079D_QUAD',
                'MultiPad 4 Diamond 7.85',
                'Prestigio',
                'Prestigio',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; PMP7079D3G_QUAD Build/JDQ39) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.58 Safari/537.31',
                'PMP7079D3G_QUAD',
                'MultiPad 4 Diamond 7.85 3G',
                'Prestigio',
                'Prestigio',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'UCWEB/2.0 (MIDP-2.0; U; Adr 4.4.2; ru; PMP7070C3G) U2/1.0.0 UCBrowser/9.2.0.419 U2/1.0.0 Mobile',
                'PMP7070C3G',
                'MultiPad 4 Diamond 7.0 3G',
                'Prestigio',
                'Prestigio',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; PMP5785C_QUAD Build/JDQ39) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.58 Safari/537.31',
                'PMP5785C_QUAD',
                'MultiPad 4 Quantum 7.85',
                'Prestigio',
                'Prestigio',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.2; ru-ru; PMP5785C3G_QUAD Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30 ACHEETAHI/2100501044',
                'PMP5785C3G_QUAD',
                'MultiPad 4 Quantum 7.85 3G',
                'Prestigio',
                'Prestigio',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; de-de; PMP5770D Build/IMM76I) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'PMP5770D',
                'MultiPad 7.0 Prime Duo',
                'Prestigio',
                'Prestigio',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.1.1; PMP5670C_DUO Build/JRO03C) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.166  Safari/535.19',
                'PMP5670C_DUO',
                'MultiPad 2 PRO DUO 7.0',
                'Prestigio',
                'Prestigio',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; de-de; PMP5580C Build/IMM76I) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'PMP5580C',
                'MultiPad 8.0 Pro Duo',
                'Prestigio',
                'Prestigio',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.0.4; PMP5570C Build/IMM76D) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.93 Safari/537.36',
                'PMP5570C',
                'MultiPad 7.0 Pro Duo',
                'Prestigio',
                'Prestigio',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.2; ru-ru; PMP5297C_QUAD Build/JDQ39) AppleWebKit/537.16 (KHTML, like Gecko) Version/4.0 Safari/537.16',
                'PMP5297C_QUAD',
                'MultiPad 4 Quantum 9.7',
                'Prestigio',
                'Prestigio',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.3; de-de; PMP5197DULTRA Build/IML74K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'PMP5197DULTRA',
                'MultiPad 9.7 Ultra',
                'Prestigio',
                'Prestigio',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; PMP5101C_QUAD Build/JDQ39) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.102 Safari/537.36',
                'PMP5101C_QUAD',
                'MultiPad 4 Quantum 10.1',
                'Prestigio',
                'Prestigio',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.3; de-de; PMP5080CPRO Build/IML74K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'PMP5080CPRO',
                'MultiPad 5080 Pro',
                'Prestigio',
                'Prestigio',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.3; ru-ru; PMP5080B Build/IML74K)Maxthon AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'PMP5080B',
                'PMP5080B',
                'Prestigio',
                'Prestigio',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.1.1; Build/PMP3870C) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 YaBrowser/14.12.2125.9740.01 Safari/537.36',
                'PMP3870C',
                'MultiPad 7.0 HD+',
                'Prestigio',
                'Prestigio',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.3; ru-ru; PMP3370B Build/IML74K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'PMP3370B',
                'MultiPad 7.0 Ultra',
                'Prestigio',
                'Prestigio',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.1-update1-2.0.16; ru-ru; PMP3074BRU Build/ECLAIR.eng.root.20110810.102128) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17',
                'PMP3074BRU',
                'MultiPad PMP3074B',
                'Prestigio',
                'Prestigio',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; lt-lt; PAP5000DUO Build/PrestigioPAP5000DUO) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30 [FB_IAB/FB4A;FBAV/24.0.0.30.15;]',
                'PAP5000DUO',
                'MultiPhone 5000 Duo',
                'Prestigio',
                'Prestigio',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; en-US; GV7777 Build/GV7777) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 UCBrowser/9.9.4.484 U3/0.8.0 Mobile Safari/534.30',
                'GV7777',
                'GeoVision',
                'Prestigio',
                'Prestigio',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.1.2; de-de; PMP7280C3G Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'PMP7280C3G',
                'Multipad 2 Ultra Duo 8.0 3G',
                'Prestigio',
                'Prestigio',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; PMT7177_3G Build/JDQ39) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.59 Safari/537.36',
                'PMT7177_3G',
                'MultiPad 4 Diamond 10.1 3G',
                'Prestigio',
                'Prestigio',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; PSP5453DUO Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/30.0.0.0 Mobile Safari/537.36',
                'PSP5453DUO',
                'Multiphone 5453 Duo',
                'Prestigio',
                'Prestigio',
                'Smartphone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; PSP5517DUO Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/30.0.0.0 Mobile Safari/537.36',
                'PSP5517DUO',
                'MultiPhone 5517 Duo',
                'Prestigio',
                'Prestigio',
                'Smartphone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; PSP5505DUO Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/30.0.0.0 Mobile Safari/537.36',
                'PSP5505DUO',
                'MultiPhone 5505 Duo',
                'Prestigio',
                'Prestigio',
                'Smartphone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; PSP5508DUO Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/30.0.0.0 Mobile Safari/537.36',
                'PSP5508DUO',
                'MultiPhone 5508 Duo',
                'Prestigio',
                'Prestigio',
                'Smartphone',
                true,
                'touchscreen',
            ],
        ];
    }
}
