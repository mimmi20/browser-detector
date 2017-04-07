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

use BrowserDetector\Factory\Device\Mobile\MicromaxFactory;
use BrowserDetector\Loader\DeviceLoader;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Stringy\Stringy;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class MicromaxFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Factory\Device\Mobile\MicromaxFactory
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
        $this->object = new MicromaxFactory($loader);
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
                'general Micromax Device',
                'general Micromax Device',
                'Micromax',
                'Micromax',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; en-us; Micromax_A101 Build/MicromaxMicromax_A101) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'A101',
                'A101',
                'Micromax',
                'Micromax',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.1.2; ru-ru; Micromax A59 Build/JZO57K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30 ACHEETAHI/2100501080',
                'A59',
                'Bolt',
                'Micromax',
                'Micromax',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'MicromaxX650 ASTRO36_TD/v3 MAUI/10A1032MP_ASTRO_W1052 Release/31.12.2010 Browser/Opera Sync/SyncClient1.1 Profile/MIDP-2.0 Configuration/CLDC-1.1 Opera/9.80 (MTK; U; en-US) Presto/2.5.28 Version/10.10',
                'X650',
                'X650',
                'Micromax',
                'Micromax',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.2; en-in; Micromax A120 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'A120',
                'Canvas 2 Colors',
                'Micromax',
                'Micromax',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; Micromax A116 Build/JOP40D) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.81 Mobile Safari/537.36 OPR/28.0.1764.90386',
                'A116',
                'Canvas HD',
                'Micromax',
                'Micromax',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.2; en-in; Micromax A114 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'A114',
                'Canvas 2.2',
                'Micromax',
                'Micromax',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; A114 Build/JDQ39) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.109 Mobile Safari/537.36',
                'A114',
                'Canvas 2.2',
                'Micromax',
                'Micromax',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.4.2; en-US; Micromax A093 Build/KOT49H) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 UCBrowser/11.2.0.915 U3/0.8.0 Mobile Safari/534.30',
                'A093',
                'A093',
                'Micromax',
                'Micromax',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0(Linux; Android 4.4.2; Micromax A065 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/30.0.0.0 Mobile Safari/537.36',
                'A065',
                'Bolt',
                'Micromax',
                'Micromax',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux;U; Android 2.3.5; en-us; Micromax A40 Build/IML74K) AppleWebKit/534.30(khtml,LIKE Gecko) Version/4.0 Mobile Safari/534.30',
                'A40',
                'A40',
                'Micromax',
                'Micromax',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 2.3.5; en-us; Micromax A35 Build/IML74K) AppleWebKit/534.30(KHTML,like Gecko) Version/4.0 Mobile Safari/534.30',
                'A35',
                'A35',
                'Micromax',
                'Micromax',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'OneBrowser/4.2.0/Adr(Linux; U; Android 2.3.5; en-us; Micromax A27 Build/MocorDroid2.3.5) AppleWebKit/533.1 (KHTML, like Gecko) Mobile Safari/533.1',
                'A27',
                'A27',
                'Micromax',
                'Micromax',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
        ];
    }
}
