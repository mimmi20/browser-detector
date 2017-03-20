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

use BrowserDetector\Factory\Device\Mobile\LenovoFactory;
use BrowserDetector\Loader\DeviceLoader;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Stringy\Stringy;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class LenovoFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Factory\Device\Mobile\LenovoFactory
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
        $this->object = new LenovoFactory($cache, $loader);
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
                'general Lenovo Device',
                'general Lenovo Device',
                'Lenovo',
                'Lenovo',
                'Tablet',
                false,
                'touchscreen',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; Lenovo_S856) U2/1.0.0 UCBrowser/9.7.0.520 Mobile',
                'S856',
                'S856',
                'Lenovo',
                'Lenovo',
                'Mobile Phone',
                false,
                null,
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; Lenovo_A319) U2/1.0.0 UCBrowser/9.8.0.534 Mobile',
                'A319',
                'RocStar',
                'Lenovo',
                'Lenovo',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; Lenovo S856 Build/KVT49L) U2/1.0.0 UCBrowser/10.5.0.668 Mobile',
                'S856',
                'S856',
                'Lenovo',
                'Lenovo',
                'Mobile Phone',
                false,
                null,
            ],
            [
                'UCWEB/2.0 (Linux; U; Opera Mini/7.1.32052/30.3697; en-US; Lenovo_A816) U2/1.0.0 UCBrowser/9.7.0.520 Mobile',
                'A816',
                'A816',
                'Lenovo',
                'Lenovo',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.1.2; IdeaTabA1000L-F Build/JZO54K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.10549 YaBrowser/13.12.1599.10549 Safari/537.36',
                'A1000L-F',
                'IdeaTab A1000L-F',
                'Lenovo',
                'Lenovo',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.2; en-us; Lenovo S660 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'S660',
                'S660',
                'Lenovo',
                'Lenovo',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Dalvik/1.6.0 (Linux; U; Android 4.2.2; IdeaTab S6000-H Build/JDQ39)',
                'S6000-H',
                'IdeaTab S6000-H',
                'Lenovo',
                'Vodafone',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0; P1032X Build/LRX21V; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/52.0.2743.98 Safari/537.36',
                'LifeTab P1032X',
                'LifeTab P1032X',
                'Lenovo',
                'Lenovo',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.3; de-de; SmartTabII10 Build/IML74K) AppleWebKit/537.16 (KHTML, like Gecko) Version/4.0 Safari/537.16 Chrome/33.0.0.0',
                'SmartTab II 10',
                'SmartTab II 10',
                'Lenovo',
                'Vodafone',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; Lenovo S920 Build/JDQ39) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.81 Mobile Safari/537.36',
                'S920',
                'S920',
                'Lenovo',
                'Lenovo',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0; Lenovo A7000-a Build/LRX21M) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.133 Mobile Safari/537.36',
                'A7000-A',
                'A7000',
                'Lenovo',
                'Lenovo',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; Lenovo B6000-H Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.94 Safari/537.36 OPR/37.0.2192.105088',
                'B6000-H',
                'Yoga B6000-H',
                'Lenovo',
                'Lenovo',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; Lenovo B6000-HV Build/JDQ39) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.93 Safari/537.36',
                'B6000-HV',
                'Yoga 8 3G + WiFi',
                'Lenovo',
                'Lenovo',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; Lenovo A606 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/30.0.0.0 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/29.0.0.23.13;]',
                'A606',
                'A606',
                'Lenovo',
                'Lenovo',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.1; en-gb; Lenovo A766 Build/JOP40D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30 Mobile UCBrowser/3.4.2.525',
                'A766',
                'A766',
                'Lenovo',
                'Lenovo',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.2.2; ru-ru; LenovoA3300-GV Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30 OkApp',
                'A3300-GV',
                'TAB A7-30 Wi-Fi',
                'Lenovo',
                'Lenovo',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.4; ru; Lenovo S720 Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 UCBrowser/9.8.9.457 U3/0.8.0 Mobile Safari/534.30',
                'S720',
                'S720',
                'Lenovo',
                'Lenovo',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.5.3; ru-ru; AT1010-T Build/KOT49H) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'AT1010-T',
                'AT1010-T',
                'Lenovo',
                'Lenovo',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.0.4; IdeaTabS2109A-F Build/IMM76D) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.74 Safari/537.36 OPR/28.0.1764.89981',
                'S2109A-F',
                'Ideatab S2109A',
                'Lenovo',
                'Lenovo',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.0.3; de-de; IdeaTabS2110AF Build/IML74K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'S2110A-F',
                'IdeaTab S2110A',
                'Lenovo',
                'Lenovo',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.0.3; IdeaTabS2110AH Build/IML74K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.93 Safari/537.36',
                'S2110A-H',
                'IdeaTab S2110A',
                'Lenovo',
                'Lenovo',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0.1; YOGA Tablet 2-1050L Build/LRX22C) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.97 Safari/537.36',
                '1050L',
                'Yoga Tablet 2 10.1 LTE',
                'Lenovo',
                'Lenovo',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0.1; YOGA Tablet 2-1050F Build/LRX22C) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.105 Safari/537.36',
                '1050F',
                'Yoga Tablet 2 10.1',
                'Lenovo',
                'Lenovo',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0.1; YOGA Tablet 2-830L Build/LRX22C; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/52.0.2743.98 Safari/537.36',
                '830L',
                'Yoga Tablet 2 8.0 LTE',
                'Lenovo',
                'Lenovo',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0.1; YOGA Tablet 2-830F Build/LRX22C) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.97 Safari/537.36',
                '830F',
                'Yoga Tablet 2 8.0',
                'Lenovo',
                'Lenovo',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0.1; YOGA Tablet 2 Pro-1380L Build/LRX22C; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/52.0.2743.98 Safari/537.36',
                '1380L',
                'Yoga Tablet 2 Pro 13.3 LTE',
                'Lenovo',
                'Lenovo',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0.1; YOGA Tablet 2 Pro-1380F Build/LRX22C) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Safari/537.36',
                '1380F',
                'Yoga Tablet 2 Pro 13.3',
                'Lenovo',
                'Lenovo',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.3; Lenovo K900 Build/JSS15Q) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.122 Mobile Safari/537.36',
                'K900',
                'IdeaPhone',
                'Lenovo',
                'Lenovo',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 6.0.1; P1050X Build/MMB29M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/52.0.2743.98 Safari/537.36',
                'LifeTab P1050X',
                'LifeTab P1050X',
                'Lenovo',
                'Lenovo',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.4; Lenovo TAB 2 A10-70F Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.94 Safari/537.36 OPR/37.0.2192.105088',
                'A10-70F',
                'Tab 2',
                'Lenovo',
                'Lenovo',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; Lenovo A536 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.36',
                'A536',
                'A536',
                'Lenovo',
                'Lenovo',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; Vodafone Smart Tab III 10 Build/JDQ39) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Safari/537.36',
                'Smart Tab III 10',
                'Smart Tab III 10',
                'Lenovo',
                'Vodafone',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.4; hu-hu; Vodafone Smart Tab 4G Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/33.0.0.0 Safari/537.36 SVN/060FHG1',
                'Smart Tab 4G',
                'Smart Tab 4G',
                'Lenovo',
                'Vodafone',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.4; hu-hu; Vodafone Smart Tab 4 Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/33.0.0.0 Safari/537.36 SVN/060FHG1',
                'Smart Tab 4',
                'Smart Tab 4',
                'Vodafone',
                'Vodafone',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.4; hu-hu; Vodafone Smart Tab 3G Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/33.0.0.0 Safari/537.36 SVN/060FHG1',
                'Smart Tab 3G',
                'Smart Tab 3G',
                'Lenovo',
                'Vodafone',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; Lenovo B8080-H Build/KVT49L) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.124 Safari/537.36',
                'B8080-H',
                'Yoga Tablet 10 HD+',
                'Lenovo',
                'Lenovo',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.1.1; Lenovo TB2-X30F Build/LenovoTB2-X30F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.124 Safari/537.36',
                'TB2-X30F',
                'TB2-X30F',
                'Lenovo',
                'Lenovo',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.0; Lenovo A1000 Build/S100) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.81 Mobile Safari/537.36',
                'A1000',
                'IdeaPad A1000',
                'Lenovo',
                'Lenovo',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.1.1; Lenovo YT3-X50L Build/LMY47V) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.124 Safari/537.36',
                'YT3-X50L',
                'YT3-X50L',
                'Lenovo',
                'Lenovo',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.2.2; Lenovo B6000-F Build/JDQ39) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.124 Safari/537.36',
                'B6000-F',
                'Yoga B6000-F',
                'Lenovo',
                'Lenovo',
                'Tablet',
                true,
                'touchscreen',
            ],
        ];
    }
}
