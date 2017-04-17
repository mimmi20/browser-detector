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
namespace BrowserDetectorTest\Factory\Device;

use BrowserDetector\Factory\Device\TvFactory;
use BrowserDetector\Loader\DeviceLoader;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Stringy\Stringy;

/**
 * Test class for \BrowserDetector\Detector\Device\Tv\GeneralTv
 */
class TvFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Factory\Device\TvFactory
     */
    private $object = null;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $adapter      = new Local(__DIR__ . '/../../../cache/');
        $cache        = new FilesystemCachePool(new Filesystem($adapter));
        $loader       = new DeviceLoader($cache);
        $this->object = new TvFactory($loader);
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
                'general TV Device',
                'general TV Device',
                null,
                null,
                'TV Device',
                false,
                null,
            ],
            [
                'Opera/9.80 (Linux armv6l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0;THOMSON LF1V401; en) Presto/2.10.250 Version/11.60',
                'LF1V401',
                'LF1V401',
                'Thomson',
                'Thomson',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux armv6l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0;THOMSON LF1V394; en) Presto/2.10.250 Version/11.60',
                'LF1V394',
                'LF1V394',
                'Thomson',
                'Thomson',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux armv6l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0;THOM LF1V373; en) Presto/2.10.250 Version/11.60',
                'LF1V373',
                'LF1V373',
                'Thomson',
                'Thomson',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux armv7l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0;Vendor/THOMSON;SW-Version/V8-MT51F01-LF1V325;Cnt/HRV;Lan/swe; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0) Presto/2.12.362 Version/12.11',
                'LF1V325',
                'LF1V325',
                'Thomson',
                'Thomson',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux armv7l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0;Vendor/THOM;SW-Version/V8-MT51F01-LF1V307;Cnt/DEU;Lan/bul) Presto/2.12.362 Version/12.11',
                'LF1V307',
                'LF1V307',
                'Thomson',
                'Thomson',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'AppleCoreMedia/1.0.0.12F69 (Apple TV; U; CPU OS 8_3 like Mac OS X; en_us)',
                'AppleTV',
                'AppleTV',
                'Apple Inc',
                'Apple',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Xbox; Xbox One) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/13.10586',
                'Xbox One',
                'Xbox One',
                'Microsoft Corporation',
                'Microsoft',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux armv7l; LOEWE-SL32x/2.2.13.0 HbbTV/1.1.1 (; LOEWE; SL32x; LOH/2.2.13.0;;) CE-HTML/1.0 Config(L:deu,CC:DEU) NETRANGEMMH) Presto/2.12.407 Version/12.51',
                'SL32x',
                'SL32x',
                'Loewe',
                'Loewe',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux mips; ) Presto/2.12.407 Version/12.51 MB97/0.0.39.10 (ALDINORD, Mxl661L32, wireless) VSTVB_MB97',
                'Smart TV',
                'Smart TV',
                'Samsung',
                'Samsung',
                'TV Device',
                false,
                null,
            ],
            [
                'Opera/9.80 (Linux armv7l; InettvBrowser/2.2 (00014A;SonyDTV115;0002;0100) KDL42W655A; CC/DEU) Presto/2.12.362 Version/12.11',
                'KDL42W655A',
                'KDL42W655A',
                'Sony',
                'Sony',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux armv7l; InettvBrowser/2.2 (00014A;SonyDTV115;0002;0100) KDL32W655A; CC/DEU) Presto/2.12.362 Version/12.11',
                'KDL32W655A',
                'KDL32W655A',
                'Sony',
                'Sony',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux armv7l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0;Vendor/TCL;SW-Version/V8-MT51F03-LF1V464;Cnt/POL;Lan/pol) Presto/2.12.362 Version/12.11',
                'LF1V464',
                'LF1V464',
                'Thomson',
                'Thomson',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux armv7l; U; CE-HTML/1.0 NETTV/3.3.0; PHILIPS-AVM-2012; en) Presto/2.9.167 Version/11.50',
                'Blueray Player',
                'Blueray Player',
                'Philips',
                'Philips',
                'Media Player',
                false,
                null,
            ],
            [
                'Mozilla/5.0 (Linux; Android 4.4.2; gxt_dongle_3188 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/30.0.0.0 Safari/537.36 bdbrowserhd_i18n/1.8.0.1',
                'CX919',
                'CX919',
                'Andoer',
                'Andoer',
                'TV Device',
                false,
                null,
            ],
            [
                'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; Xbox)',
                'Xbox 360',
                'Xbox 360',
                'Microsoft Corporation',
                'Microsoft',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'curl/7.16.3 (Linux 2.6.28 intel.ce4100 dlink.dsm380 i686; en-US; beta) boxee/1.2.2.20482-64560cd',
                'DSM 380',
                'DSM 380',
                'D-Link',
                'D-Link',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Mozilla/5.0 (Linux; GoogleTV 3.2; NSZ-GS7/GX70 Build/MASTER) AppleWebKit/534.24 (KHTML, like Gecko) Chrome/11.0.696.77 Safari/534.24',
                'NSZ-GS7/GX70',
                'NSZ-GS7/GX70',
                'Sony',
                'Sony',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Mozilla/5.0 (;;;) AppleWebKit/534.6 HbbTV/1.1.1 (+DL+PVR; inverto; IDL-6651N Volksbox Web Edition; 1.0; 1.0;)  CE-HTML/1.0',
                'IDL-6651N',
                'IDL-6651N',
                null,
                null,
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/10.60 (Linux sh4 ; U; HbbTV/1.1.1 (+PVR; Loewe; SL121; LOH/3.10;;) CE-HTML/1.0 Config(L:deu,CC:DEU); en) Presto/2.6.33 Version/10.60',
                'SL121',
                'SL121',
                'Loewe',
                'Loewe',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux sh4; U; HbbTV/1.1.1 (+PVR; Loewe; SL150; LOH/3.10;;) CE-HTML/1.0 Config(L:deu,CC:DEU); en) Presto/2.10.250 Version/11.60',
                'SL150',
                'SL150',
                'Loewe',
                'Loewe',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux armv6l; U; NETRANGEMMH;HbbTV/1.1.1;CE-HTML/1.0; en) Presto/2.8.115 Version/11.10',
                'NETRANGEMMH',
                'NETRANGEMMH',
                'Netrange',
                'Netrange',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Mozilla/5.0 (X11; FreeBSD; U; Viera; de-DE) AppleWebKit/537.11 (KHTML, like Gecko) Viera/3.4.10 Chrome/23.0.1271.97 Safari/537.11',
                'Viera TV',
                'Viera TV',
                'Panasonic',
                'Panasonic',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux mips ; U; HbbTV/1.1.1 (; Philips; ; ; ; ) CE-HTML/1.0 NETTV/3.1.0; en) Presto/2.6.33 Version/10.70',
                'general Philips TV',
                'general Philips TV',
                'Philips',
                'Philips',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux mips; U; InettvBrowser/2.2 (00014A;SonyDTV115;0002;0100) KDL32HX755; CC/DEU; de) Presto/2.10.250 Version/11.60',
                'KDL32HX755',
                'KDL32HX755',
                'Sony',
                'Sony',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux mips; U; InettvBrowser/2.2 (00014A;SonyDTV115;0002;0100) KDL37EX720; CC/DEU; en) Presto/2.7.61 Version/11.00',
                'KDL37EX720',
                'KDL37EX720',
                'Sony',
                'Sony',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux mips; U; InettvBrowser/2.2 (00014A;SonyDTV115;0002;0100) KDL40EX720; CC/DEU; en) Presto/2.7.61 Version/11.00',
                'KDL40EX720',
                'KDL40EX720',
                'Sony',
                'Sony',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux armv7l; InettvBrowser/2.2 (00014A;SonyDTV140;0001;0001) KDL50W815B; CC/DEU) Presto/2.12.407 Version/12.50',
                'KDL50W815B',
                'KDL50W815B',
                'Sony',
                'Sony',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux armv7l; SonyDTV) Presto/2.12.407 Version/12.50',
                'general Sony TV',
                'general Sony TV',
                'Sony',
                'Sony',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux sh4; U; HbbTV/1.1.1 (;;;;;); CE-HTML; TechniSat DigiCorder ISIO S; de) Presto/2.9.167 Version/11.50',
                'DigiCorder ISIO S',
                'DigiCorder ISIO S',
                'TechniSat',
                'TechniSat',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux sh4; U; HbbTV/1.1.1 (;;;;;); CE-HTML; TechniSat Digit ISIO S; de) Presto/2.9.167 Version/11.50',
                'DIGIT ISIO S',
                'DIGIT ISIO S',
                'TechniSat',
                'TechniSat',
                'TV Device',
                false,
                'mouse',
            ],
            [
                'Opera/9.80 (Linux i686; U; HbbTV/1.1.1 (;;;;;); CE-HTML; TechniSat MultyVision ISIO; de) Presto/2.9.167 Version/11.50',
                'MultyVision ISIO',
                'MultyVision ISIO',
                'TechniSat',
                'TechniSat',
                'TV Device',
                false,
                'mouse',
            ],
        ];
    }
}
