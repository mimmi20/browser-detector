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
namespace BrowserDetectorTest\Factory\Device\Tv;

use BrowserDetector\Factory\Device\Tv\SonyFactory;
use BrowserDetector\Loader\DeviceLoader;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Stringy\Stringy;

/**
 * Test class for \BrowserDetector\Factory\Device\Tv\SonyFactory
 */
class SonyFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Factory\Device\Tv\SonyFactory
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
        $this->object = new SonyFactory($loader);
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
                'general Sony TV',
                'general Sony TV',
                'Sony',
                'Sony',
                'TV Device',
                false,
                'mouse',
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
        ];
    }
}
