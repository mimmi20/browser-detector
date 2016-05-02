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
 * @author     James Titcumb <james@asgrim.com>
 * @group      useragenttest
 */
class UserAgentsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BrowserDetector\BrowserDetector
     */
    private $object = null;

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
        static $data = [];

        if (count($data)) {
            return $data;
        }

        $checks          = [];
        $sourceDirectory = 'vendor/browscap/browscap/tests/fixtures/issues/';

        $iterator = new \DirectoryIterator($sourceDirectory);

        foreach ($iterator as $file) {
            /** @var $file \SplFileInfo */
            if (!$file->isFile() || $file->getExtension() !== 'php') {
                continue;
            }

            $tests = require_once $file->getPathname();

            foreach ($tests as $key => $test) {
                if (isset($data[$key])) {
                    throw new \RuntimeException('Test data is duplicated for key "' . $key . '"');
                }

                if (isset($checks[$test['ua']])) {
                    throw new \RuntimeException(
                        'UA "' . $test['ua'] . '" added more than once, now for key "' . $key . '", before for key "'
                        . $checks[$test['ua']] . '"'
                    );
                }

                $data[$key]          = $test;
                $checks[$test['ua']] = $key;
            }
        }

        return $data;
    }

    /**
     * @dataProvider userAgentDataProvider
     * @coversNothing
     *
     * @param string $userAgent
     * @param array  $expectedProperties
     *
     * @throws \Exception
     * @group  integration
     * @group  useragenttest
     */
    public function testUserAgents($userAgent, $expectedProperties)
    {
        if (!is_array($expectedProperties) || !count($expectedProperties)) {
            self::markTestSkipped('Could not run test - no properties were defined to test');
        }

        $result = $this->object->getBrowser($userAgent, true);
        $mapper = new InputMapper();

        $expectedBrowserName = $mapper->mapBrowserName($expectedProperties['Browser']);
        $foundBrowserName    = $mapper->mapBrowserName($result->getBrowser()->getName());

        self::assertSame(
            $expectedBrowserName,
            $foundBrowserName,
            'Expected actual "Browser" to be "'
            . $expectedBrowserName . ' [' . $expectedProperties['Browser'] . ']'
            . '" (was "' . $foundBrowserName . ' [' . $result->getBrowser()->getName() . ']' . '")'
        );

        $expectedBrowserType = $mapper->mapBrowserType($expectedProperties['Browser_Type'])->getName();

        self::assertSame(
            $expectedBrowserType,
            $result->getBrowser()->getType()->getName(),
            'Expected actual "Browser_Type" to be "' . $expectedBrowserType
            . ' [' . $expectedProperties['Browser_Type'] . ']'
            . '" (was "' . $result->getBrowser()->getType()->getName() . '")'
        );

        $expectedBrowserMaker = $mapper->mapBrowserMaker(
            $expectedProperties['Browser_Maker'],
            $expectedProperties['Browser']
        );
        $foundBrowserMaker = $mapper->mapBrowserMaker(
            $result->getBrowser()->getManufacturer(),
            $result->getBrowser()->getName()
        );

        self::assertSame(
            $expectedBrowserMaker,
            $foundBrowserMaker,
            'Expected actual "Browser_Maker" to be "'
            . $expectedBrowserMaker . ' [' . $expectedProperties['Browser_Maker'] . ']'
            . '" (was "' . $foundBrowserMaker . ' [' . $result->getBrowser()->getManufacturer() . ']' . '")'
        );

        $expectedDeviceMaker = $mapper->mapDeviceMaker(
            $expectedProperties['Device_Maker'],
            $expectedProperties['Device_Code_Name']
        );
        $foundDeviceMaker = $mapper->mapDeviceMaker(
            $result->getDevice()->getManufacturer(),
            $result->getDevice()->getDeviceName()
        );

        self::assertSame(
            $expectedDeviceMaker,
            $foundDeviceMaker,
            'Expected actual "Device_Maker" to be "'
            . $expectedDeviceMaker . ' [' . $expectedProperties['Device_Maker'] . ']'
            . '" (was "' . $foundDeviceMaker . ' [' . $result->getDevice()->getManufacturer() . ']' . '"; class type was ' . get_class($result->getDevice()) . ')'
        );

        if (isset($expectedProperties['Device_Brand_Name'])) { //@todo: remove this check
            $expectedDeviceBrand = $mapper->mapDeviceBrandName(
                $expectedProperties['Device_Brand_Name'],
                $expectedProperties['Device_Code_Name']
            );
            $foundDeviceBrand = $mapper->mapDeviceBrandName(
                $result->getDevice()->getBrand(),
                $result->getDevice()->getDeviceName()
            );

            self::assertSame(
                $expectedDeviceBrand,
                $foundDeviceBrand,
                'Expected actual "Device_Brand_Name" to be "'
                . $expectedDeviceBrand . ' [' . $expectedProperties['Device_Brand_Name'] . ']'
                . '" (was "' . $foundDeviceBrand . ' [' . $result->getDevice()->getBrand() . ']' . '"; class type was ' . get_class($result->getDevice()) . ')'
            );
        }

        return; //@todo: remove

        $expectedDeviceCodeName = $mapper->mapDeviceName(
            $expectedProperties['Device_Code_Name']
        );
        $foundDeviceCodeName = $mapper->mapDeviceName(
            $result->getDevice()->getDeviceName()
        );

        self::assertSame(
            $expectedDeviceCodeName,
            $foundDeviceCodeName,
            'Expected actual "Device_Code_Name" to be "'
            . $expectedDeviceCodeName . ' [' . $expectedProperties['Device_Code_Name'] . ']'
            . '" (was "' . $foundDeviceCodeName . ' [' . $result->getDevice()->getDeviceName() . ']' . '"; class type was ' . get_class($result->getDevice()) . ')'
        );

        $expectedDeviceName = $mapper->mapDeviceMarketingName(
            $expectedProperties['Device_Name']
        );
        $foundDeviceName = $mapper->mapDeviceMarketingName(
            $result->getDevice()->getMarketingName()
        );

        self::assertSame(
            $expectedDeviceName,
            $foundDeviceName,
            'Expected actual "Device_Name" to be "'
            . $expectedDeviceName . ' [' . $expectedProperties['Device_Name'] . ']'
            . '" (was "' . $foundDeviceName . ' [' . $result->getDevice()->getMarketingName() . ']' . '"; class type was ' . get_class($result->getDevice()) . ')'
        );
    }
}
