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
namespace BrowserDetectorTest\Factory\Platform;

use BrowserDetector\Factory\Platform\DarwinFactory;
use BrowserDetector\Loader\PlatformLoader;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Stringy\Stringy;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class DarwinFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Factory\Platform\DarwinFactory
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
        $loader       = new PlatformLoader($cache);
        $this->object = new DarwinFactory($loader);
    }

    /**
     * @dataProvider providerDetect
     *
     * @param string $agent
     * @param string $platform
     * @param string $version
     * @param string $manufacturer
     * @param int    $bits
     */
    public function testDetect($agent, $platform, $version, $manufacturer, $bits)
    {
        $s = new Stringy($agent);

        /** @var \UaResult\Os\OsInterface $result */
        $result = $this->object->detect($agent, $s);

        self::assertInstanceOf('\UaResult\Os\OsInterface', $result);
        self::assertSame(
            $platform,
            $result->getName(),
            'Expected platform name to be "' . $platform . '" (was "' . $result->getName() . '")'
        );

        self::assertInstanceOf('\BrowserDetector\Version\Version', $result->getVersion());
        self::assertSame(
            $version,
            $result->getVersion()->getVersion(),
            'Expected version to be "' . $version . '" (was "' . $result->getVersion()->getVersion() . '")'
        );

        self::assertSame(
            $manufacturer,
            $result->getManufacturer()->getName(),
            'Expected manufacturer name to be "' . $manufacturer . '" (was "' . $result->getManufacturer()->getName() . '")'
        );

        self::assertSame(
            $bits,
            $result->getBits(),
            'Expected bits count to be "' . $bits . '" (was "' . $result->getBits() . '")'
        );
    }

    /**
     * @return array[]
     */
    public function providerDetect()
    {
        return [
            [
                'Safari/12602.1.50.0.2 CFNetwork/807.0.1 Darwin/16.0.0 (x86_64)',
                'macOS',
                '10.12.0',
                'Apple Inc',
                64,
            ],
            [
                'TestApp/1.0 CFNetwork/808.2.16 Darwin/16.3.0',
                'iOS',
                '10.2.0',
                'Apple Inc',
                32,
            ],
            [
                'TestApp/1.0 CFNetwork/808.1.4 Darwin/16.1.0',
                'iOS',
                '10.1.0',
                'Apple Inc',
                32,
            ],
            [
                'Unibox/87 CFNetwork/808.0.2 Darwin/16.0.0',
                'iOS',
                '10.0.0',
                'Apple Inc',
                32,
            ],
            [
                'Safari/12602.1.43 CFNetwork/802.1 Darwin/16.0.0 (x86_64)',
                'macOS',
                '10.12.0',
                'Apple Inc',
                64,
            ],
            [
                'Safari/12602.1.40.4 CFNetwork/798.3 Darwin/16.0.0 (x86_64)',
                'macOS',
                '10.12.0',
                'Apple Inc',
                64,
            ],
            [
                'MobileSafari/602.1 CFNetwork/796.1 Darwin/16.0.0',
                'macOS',
                '10.12.0',
                'Apple Inc',
                32,
            ],
            [
                'Safari/12602.1.32.7 CFNetwork/790.2 Darwin/16.0.0 (x86_64)',
                'iOS',
                '10.0.0',
                'Apple Inc',
                64,
            ],
            [
                'Safari/11601.5.17.1 CFNetwork/760.4.2 Darwin/15.4.0 (x86_64)',
                'Mac OS X',
                '10.11.0',
                'Apple Inc',
                64,
            ],
            [
                'TestApp/1.0 CFNetwork/758.0.2 Darwin/15.0.0',
                'iOS',
                '9.0.0',
                'Apple Inc',
                32,
            ],
            [
                'MobileSafari/601.1 CFNetwork/757 Darwin/15.0.0',
                'iOS',
                '9.0.0',
                'Apple Inc',
                32,
            ],
            [
                'Safari/10600.1.25.1 CFNetwork/720.1.1 Darwin/14.0.0 (x86_64)',
                'Mac OS X',
                '10.10.0',
                'Apple Inc',
                64,
            ],
            [
                'com.apple.WebKit.WebContent/10600.1.15 CFNetwork/718 Darwin/14.0.0 (x86_64)',
                'Mac OS X',
                '10.10.0',
                'Apple Inc',
                64,
            ],
            [
                'com.apple.WebKit.WebContent/10600.1.8 CFNetwork/714 Darwin/14.0.0 (x86_64)',
                'Mac OS X',
                '10.10.0',
                'Apple Inc',
                64,
            ],
            [
                'MobileSafari/600.1.4 CFNetwork/711.5.6 Darwin/14.0.0',
                'iOS',
                '8.4.0',
                'Apple Inc',
                32,
            ],
            [
                'Mercury/894 CFNetwork/711.4.6 Darwin/14.0.0',
                'iOS',
                '8.4.0',
                'Apple Inc',
                32,
            ],
            [
                'Mercury/894 CFNetwork/711.3.18 Darwin/14.0.0',
                'iOS',
                '8.3.0',
                'Apple Inc',
                32,
            ],
            [
                'Mail/53 CFNetwork/711.2.23 Darwin/14.0.0',
                'iOS',
                '8.2.0',
                'Apple Inc',
                32,
            ],
            [
                'MobileSafari/600.1.4 CFNetwork/711.1.16 Darwin/14.0.0',
                'iOS',
                '8.1.0',
                'Apple Inc',
                32,
            ],
            [
                'Mercury/870 CFNetwork/711.0.6 Darwin/14.0.0',
                'iOS',
                '8.0.0',
                'Apple Inc',
                32,
            ],
            [
                'MobileSafari/600.1.4 CFNetwork/709.1 Darwin/14.0.0',
                'Mac OS X',
                '10.10.0',
                'Apple Inc',
                32,
            ],
            [
                'Unibox/190 CFNetwork/708.1 Darwin/14.0.0 (x86_64)',
                'Mac OS X',
                '10.10.0',
                'Apple Inc',
                64,
            ],
            [
                'com.apple.WebKit.WebContent/10538.46 CFNetwork/705 Darwin/14.0.0 (x86_64)',
                'Mac OS X',
                '10.10.0',
                'Apple Inc',
                64,
            ],
            [
                'com.apple.WebKit.WebContent/10538.39.41 CFNetwork/699 Darwin/14.0.0 (x86_64)',
                'Mac OS X',
                '10.10.0',
                'Apple Inc',
                64,
            ],
            [
                'Unibox/190 CFNetwork/696.0.2 Darwin/14.0.0 (x86_64)',
                'Mac OS X',
                '10.10.0',
                'Apple Inc',
                64,
            ],
            [
                'Safari/9537.86.3.9.1 CFNetwork/673.6 Darwin/13.4.0 (x86_64) (iMac10%2C1)',
                'Mac OS X',
                '10.9.0',
                'Apple Inc',
                64,
            ],
            [
                'MobileSafari/9537.53 CFNetwork/672.1.15 Darwin/14.0.0',
                'iOS',
                '7.1.0',
                'Apple Inc',
                32,
            ],
            [
                'AtomicBrowser/7.0.1 CFNetwork/672.0.8 Darwin/14.0.0',
                'iOS',
                '7.0.0',
                'Apple Inc',
                32,
            ],
            [
                'AtomicBrowser/7.0.1 CFNetwork/609.1.4 Darwin/13.0.0',
                'iOS',
                '6.1.0',
                'Apple Inc',
                32,
            ],
            [
                'MobileSafari/8536.25 CFNetwork/609 Darwin/13.0.0',
                'iOS',
                '6.0.0',
                'Apple Inc',
                32,
            ],
            [
                'MobileSafari/8536.25 CFNetwork/602 Darwin/13.0.0',
                'iOS',
                '6.0.0',
                'Apple Inc',
                32,
            ],
            [
                'Safari/8536.30.1 CFNetwork/596.4.3 Darwin/12.4.0 (x86_64) (Macmini6%2C2)',
                'Mac OS X',
                '10.8.0',
                'Apple Inc',
                64,
            ],
            [
                'AdSheet/1.0 CFNetwork/548.1.4 Darwin/11.0.0',
                'iOS',
                '5.1.0',
                'Apple Inc',
                32,
            ],
            [
                'AtomicBrowser/6.0.1 CFNetwork/548.0.4 Darwin/11.0.0',
                'iOS',
                '5.0.0',
                'Apple Inc',
                32,
            ],
            [
                'Safari/7537.78.2 CFNetwork/520.5.3 Darwin/11.4.2 (i386) (MacBookPro2%2C2)',
                'Mac OS X',
                '10.7.0',
                'Apple Inc',
                32,
            ],
            [
                'Safari/7534.20.8 CFNetwork/515.1 Darwin/11.0.0 (x86_64) (MacBook7%2C1)',
                'Mac OS X',
                '10.7.0',
                'Apple Inc',
                64,
            ],
            [
                'AtomicBrowser/5.8.0 CFNetwork/485.13.9 Darwin/11.0.0',
                'iOS',
                '4.3.0',
                'Apple Inc',
                32,
            ],
            [
                'CSN%20Philly/1.03.01 CFNetwork/485.12.30 Darwin/10.4.0',
                'iOS',
                '4.2.0',
                'Apple Inc',
                32,
            ],
            [
                'MobileSafari/6531.22.7 CFNetwork/485.10.2 Darwin/10.3.1',
                'iOS',
                '4.1.0',
                'Apple Inc',
                32,
            ],
            [
                'MobileSafari/6531.22.7 CFNetwork/485.2 Darwin/10.3.1',
                'iOS',
                '4.0.0',
                'Apple Inc',
                32,
            ],
            [
                'AtomicBrowser/3.7.1 CFNetwork/467.12 Darwin/10.3.1',
                'iOS',
                '3.2.0',
                'Apple Inc',
                32,
            ],
            [
                'Stitcher/3.310746 CFNetwork/459 Darwin/10.0.0d3',
                'iOS',
                '3.1.0',
                'Apple Inc',
                32,
            ],
            [
                'Safari/6534.59.10 CFNetwork/454.12.4 Darwin/10.8.0 (i386) (iMac5%2C2)',
                'Mac OS X',
                '10.6.0',
                'Apple Inc',
                32,
            ],
            [
                'Safari5533.22.3 CFNetwork/438.16 Darwin/9.8.0 (i386) (iMac8%2C1)',
                'Mac OS X',
                '10.5.0',
                'Apple Inc',
                32,
            ],
            [
                'ContentBarrier%20X510.5.4%20 CFNetwork/422.15.2 Darwin/9.6.0 (i386) (MacBook5%2C1)',
                'Mac OS X',
                '10.5.0',
                'Apple Inc',
                32,
            ],
            [
                'Cooliris/1.2 CFNetwork/339.3 Darwin/9.4.1',
                'Mac OS X',
                '10.5.0',
                'Apple Inc',
                32,
            ],
        ];
    }
}
