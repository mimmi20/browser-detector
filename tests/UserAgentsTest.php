<?php
/**
 * Copyright (c) 1998-2014 Browser Capabilities Project
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * Refer to the LICENSE file distributed with this package.
 *
 * @category   CompareTest
 *
 * @copyright  1998-2014 Browser Capabilities Project
 * @license    MIT
 */

namespace BrowserDetectorTest;

use BrowserDetector\BrowserDetector;
use Monolog\Handler\NullHandler;
use Monolog\Logger;
use UaDataMapper\InputMapper;
use WurflCache\Adapter\NullStorage;

/**
 * Class UserAgentsTest
 *
 * @category   CompareTest
 *
 * @author     Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @group      useragenttest
 */
abstract class UserAgentsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BrowserDetector\BrowserDetector
     */
    protected $object = null;

    /**
     * @var \UaDataMapper\InputMapper
     */
    protected static $mapper = null;

    /**
     * @var string
     */
    protected $sourceDirectory = 'tests/issues/00000-browscap/';

    /**
     * This method is called before the first test of this test class is run.
     *
     * @since Method available since Release 3.4.0
     */
    public static function setUpBeforeClass()
    {
        static::$mapper = new InputMapper();
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $logger = new Logger('browser-detector-tests');
        $logger->pushHandler(new NullHandler());

        $cache        = new NullStorage();
        $this->object = new BrowserDetector($cache, $logger);
    }

    /**
     * @return array[]
     */
    public function userAgentDataProvider()
    {
        echo 'start provider', PHP_EOL;

        $data            = [];
        $checks          = [];

        $iterator = new \DirectoryIterator($this->sourceDirectory);

        foreach ($iterator as $file) {
            /** @var $file \SplFileInfo */
            if (!$file->isFile() || $file->getExtension() !== 'php') {
                continue;
            }

            $tests = require_once $file->getPathname();

            foreach ($tests as $key => $test) {
                if (isset($data[$key])) {
                    // Test data is duplicated for key
                    continue;
                }

                if (isset($checks[$test['ua']])) {
                    // UA was added more than once
                    continue;
                }

                $data[$key]          = $test;
                $checks[$test['ua']] = $key;
            }
        }

        echo 'finish provider', PHP_EOL;

        return $data;
    }

    /**
     * @dataProvider userAgentDataProvider
     *
     * @param string $userAgent
     * @param array  $expectedProperties
     *
     * @throws \Exception
     * @group  integration
     * @group  useragenttest
     * @group  00000
     */
    public function testUserAgents($userAgent, $expectedProperties)
    {
        $result = $this->object->getBrowser($userAgent);

        $expectedPlatformName = $expectedProperties['Platform_Name'];
        $foundPlatform        = $result->getOs();
        $foundPlatformName    = $foundPlatform->getName();

        self::assertSame(
            $expectedPlatformName,
            $foundPlatformName,
            'Expected actual "Platform_Name" to be "' . $expectedPlatformName . '" (was "' . $foundPlatformName . '" [class: ' . get_class($foundPlatform) . '])'
        );

        /*
        $expectedBrowserName = $expectedProperties['Browser_Name'];
        $foundBrowserName    = $result->getBrowser()->getName();

        self::assertSame(
            $expectedBrowserName,
            $foundBrowserName,
            'Expected actual "Browser" to be "' . $expectedBrowserName . '" (was "' . $foundBrowserName . '")'
        );

        /**
        // @todo: add check for browser version
        // @todo: add check for browser modus
        $expectedBrowserType = self::$mapper->mapBrowserType($expectedProperties['Browser_Type'])->getName();
        $foundBrowserType    = $result->getBrowser()->getType()->getName();

        self::assertSame(
            $expectedBrowserType,
            $foundBrowserType,
            'Expected actual "Browser_Type" to be "' . $expectedBrowserType . '" (was "' . $foundBrowserType . '")'
        );

        $expectedBrowserMaker = $expectedProperties['Browser_Maker'];
        $foundBrowserMaker    = $result->getBrowser()->getManufacturer();

        self::assertSame(
            $expectedBrowserMaker,
            $foundBrowserMaker,
            'Expected actual "Browser_Maker" to be "' . $expectedBrowserMaker . '" (was "' . $foundBrowserMaker . '")'
        );

        // @todo: add check for browser bits

        $expectedDeviceMaker = $expectedProperties['Device_Maker'];
        $foundDeviceMaker    = $result->getDevice()->getManufacturer();

        self::assertSame(
            $expectedDeviceMaker,
            $foundDeviceMaker,
            'Expected actual "Device_Maker" to be "' . $expectedDeviceMaker . '" (was "' . $foundDeviceMaker . '")'
        );

        $expectedDeviceBrand = $expectedProperties['Device_Brand_Name'];
        $foundDeviceBrand    = $result->getDevice()->getBrand();

        self::assertSame(
            $expectedDeviceBrand,
            $foundDeviceBrand,
            'Expected actual "Device_Brand_Name" to be "' . $expectedDeviceBrand . '" (was "' . $foundDeviceBrand . '")'
        );

        $expectedDeviceCodeName = $expectedProperties['Device_Code_Name'];
        $foundDeviceCodeName    = $result->getDevice()->getDeviceName();

        self::assertSame(
            $expectedDeviceCodeName,
            $foundDeviceCodeName,
            'Expected actual "Device_Code_Name" to be "' . $expectedDeviceCodeName . '" (was "' . $foundDeviceCodeName . '")'
        );

        $expectedDeviceName = $expectedProperties['Device_Name'];
        $foundDeviceName    = $result->getDevice()->getMarketingName();

        self::assertSame(
            $expectedDeviceName,
            $foundDeviceName,
            'Expected actual "Device_Name" to be "' . $expectedDeviceName . '" (was "' . $foundDeviceName . '"'
        );
        /**/
    }
}
