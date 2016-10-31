<?php

namespace BrowserDetectorTest\Factory\Device\Mobile;

use BrowserDetector\Factory\Device\Mobile\TechnisatFactory;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class TechnisatFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BrowserDetector\Factory\Device\Mobile\TechnisatFactory
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
        $this->object = new TechnisatFactory($cache);
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
        /** @var \UaResult\Device\DeviceInterface $result */
        $result = $this->object->detect($agent);

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
                'Mozilla/5.0 (Linux; U; Android 4.2.2; de-de; AQIPAD_7G Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'Aqiston Aqipad 7G',
                'Aqiston Aqipad 7G',
                'TechniSat',
                'TechniSat',
                'Tablet',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.3; de-de; TechniPhone 5 Build/JLS36C) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'TechniPhone 5',
                'TechniPhone 5',
                'TechniSat',
                'TechniSat',
                'Mobile Phone',
                false,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.1.1; de-de; TechniPad_10-3G Build/JRO03H) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'TechniPad 10 3G',
                'TechniPad 10 3G',
                'TechniSat',
                'TechniSat',
                'FonePad',
                true,
                'touchscreen',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.1.1; de-de; TechniPad 10 Build/JRO03H) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30',
                'TechniPad 10',
                'TechniPad 10',
                'TechniSat',
                'TechniSat',
                'Tablet',
                true,
                'touchscreen',
            ],
        ];
    }
}
