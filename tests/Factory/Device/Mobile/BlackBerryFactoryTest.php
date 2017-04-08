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

use BrowserDetector\Factory\Device\Mobile\BlackBerryFactory;
use BrowserDetector\Loader\DeviceLoader;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Stringy\Stringy;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class BlackBerryFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Factory\Device\Mobile\BlackBerryFactory
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
        $this->object = new BlackBerryFactory($loader);
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
                'general BlackBerry Device',
                'general BlackBerry Device',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'BlackBerry9000/4.6.0.126 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/285',
                'BlackBerry 9000',
                'Bold',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'clickwheel',
            ],
            [
                'BlackBerry9700/5.0.0.321 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/604',
                'BlackBerry 9700',
                'Bold',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'clickwheel',
            ],
            [
                'BlackBerry8100/4.5.0.55 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/107',
                'BlackBerry 8100',
                'BlackBerry 8100',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'clickwheel',
            ],
            [
                'BlackBerry8520/5.0.0.1075 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/168',
                'BlackBerry 8520',
                'Curve',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'clickwheel',
            ],
            [
                'Opera/9.80 (J2ME/MIDP; Opera Mini/9 (Compatible; MSIE:9.0; iPhone; BlackBerry9700; AppleWebKit/24.746; U; en) Presto/2.5.25 Version/10.54',
                'BlackBerry 9700',
                'Bold',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'clickwheel',
            ],
            [
                'Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; it) AppleWebKit/534.8+ (KHTML, like Gecko) Version/6.0.0.668 Mobile Safari/534.8+',
                'BlackBerry 9800',
                'Torch',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (BlackBerry; U; BlackBerry 9790; en) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.1.0.714 Mobile Safari/534.11+',
                'BlackBerry 9790',
                'BlackBerry Bold',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'clickwheel',
            ],
            [
                'Mozilla/5.0 (BB10; Touch) AppleWebKit/537.10+ (KHTML, like Gecko) Version/10.1.0.2354 Mobile Safari/537.10+',
                'Z10',
                'Z10',
                'BlackBerry Limited',
                'BlackBerry',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (BlackBerry; U; BlackBerry 9720; en) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.1.0.1121 Mobile Safari/534.11+',
                'BlackBerry 9720',
                'Bold',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'clickwheel',
            ],
            [
                'Mozilla/5.0 (BB10; Kbd) AppleWebKit/537.35+ (KHTML, like Gecko)',
                'KBD',
                'KBD',
                'BlackBerry Limited',
                'BlackBerry',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML, like Gecko) Version/7.2.1.0 Safari/536.2+',
                'PlayBook',
                'PlayBook',
                'Research In Motion Limited',
                'RIM',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (BlackBerry; U; BlackBerry 9981; ar) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.0.0.579 Mobile Safari/534.11+',
                'BlackBerry 9981',
                'Porsche Design P9981',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (BlackBerry; U; BlackBerry 9900; ko) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.1.0.1098 Mobile Safari/534.11+',
                'BlackBerry Bold Touch 9900',
                'Dakota',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (BlackBerry; U; BlackBerry 9860; de) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.0.0.261 Mobile Safari/534.11+',
                'BlackBerry Torch 9860',
                'Monza',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (BlackBerry; U; BlackBerry 9810; de) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.1.0.342 Mobile Safari/534.11+',
                'BlackBerry 9810',
                'Torch 4G',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (BlackBerry; U; BlackBerry 9780; de) AppleWebKit/534.8+ (KHTML, like Gecko) Version/6.0.0.668 Mobile Safari/534.8+',
                'BlackBerry 9780',
                'BlackBerry 9780',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'trackpad',
            ],
            [
                'Mozilla/5.0 (BlackBerry; U; BlackBerry 9670; en) AppleWebKit/534.1 (KHTML, like Gecko) Version/6.0.0.248 Mobile Safari/534.1',
                'BlackBerry 9670',
                'BlackBerry 9670',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'clickwheel',
            ],
            [
                'BlackBerry9630,gzip(gfe),gzip(gfe),gzip(gfe)',
                'BlackBerry 9630',
                'BlackBerry 9630',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'clickwheel',
            ],
            [
                'BlackBerry9550/4.2.0.124 Profile/MIDP-2.0 Configuration/CLDC-1.1/UC Browser7.8.0.95/161/352',
                'BlackBerry 9550',
                'Storm II',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'BlackBerry9520/5.0.0.669 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/111',
                'BlackBerry 9520',
                'Storm II',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'BlackBerry9500/4.7.0.108 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/120',
                'BlackBerry 9500',
                'Storm',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'BlackBerry9380/7.0.0.482 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/331',
                'BlackBerry 9380',
                'Curve',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'BlackBerry9360/7.1.0 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/124',
                'BlackBerry 9360',
                'Curve',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'BlackBerry9320/7.1.0 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/129',
                'BlackBerry 9320',
                'Curve',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                true,
                'touchscreen',
            ],
            [
                'BlackBerry9300/5.0.0.794 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/114',
                'BlackBerry 9300',
                'Curve 3G',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'clickwheel',
            ],
            [
                'BlackBerry9220/7.1.0 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/603',
                'BlackBerry 9220',
                'BlackBerry 9220',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'BlackBerry9105/5.0.0.604 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/1',
                'BlackBerry 9105',
                'Pearl 3G',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'clickwheel',
            ],
            [
                'BlackBerry8900/4.6.1.101 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/111',
                'BlackBerry 8900',
                'Curve',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'clickwheel',
            ],
            [
                'Mozilla/2.0 (compatible; MSIE 3.02; Windows CE; PPC; 240x320) BlackBerry8830/4.2.2 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/104',
                'BlackBerry 8830',
                'BlackBerry 8830',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'clickwheel',
            ],
            [
                'Mozilla/2.0 (compatible; MSIE 3.02; Windows CE; PPC; 240x320) BlackBerry8800/4.2.1 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/175',
                'BlackBerry 8800',
                'BlackBerry 8800',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'clickwheel',
            ],
            [
                'Mozilla/2.0 (compatible; MSIE 3.02; Windows CE; PPC; 240x320) BlackBerry8700/4.1.0 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/102 UP.Link/6.3.0.0.0',
                'BlackBerry 8700',
                'BlackBerry 8700',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'clickwheel',
            ],
            [
                'BlackBerry8530/5.0.0.1000 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/109',
                'BlackBerry 8530',
                'BlackBerry 8530',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'clickwheel',
            ],
            [
                'BlackBerry8310/4.2.1 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/179',
                'BlackBerry 8310',
                'Curve',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'clickwheel',
            ],
            [
                'BlackBerry8230/4.6.1.160 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/105',
                'BlackBerry 8230',
                'BlackBerry 8230',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'clickwheel',
            ],
            [
                'BlackBerry8110/4.3.0 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/102',
                'BlackBerry 8110',
                'Pearl',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'clickwheel',
            ],
            [
                'BlackBerry7520/4.0.0 Profile/MIDP-2.0 Configuration/CLDC-1.1 UP.Browser/5.0.3.3 UP.Link/5.1.2.12 (Google WAP Proxy/1.0)',
                'BlackBerry 7520',
                'BlackBerry 7520',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'clickwheel',
            ],
            [
                'Mozilla/2.0 (compatible; MSIE 3.02; Windows CE; PPC; 240x320) BlackBerry7130/4.2.1 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/120',
                'BlackBerry 7130',
                'BlackBerry 7130',
                'Research In Motion Limited',
                'RIM',
                'Mobile Phone',
                false,
                'clickwheel',
            ],
        ];
    }
}
