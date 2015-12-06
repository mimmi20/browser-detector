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
 * @package    Test
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
 * @package    Test
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

        $cache = new NullStorage();
        $this->object = new BrowserDetector($cache, $logger);
    }

    /**
     * @return array[]
     */
    public function userAgentDataProvider()
    {
        static $data = array();

        if (count($data)) {
            return $data;
        }

        $checks          = array();
        $sourceDirectory = 'vendor/browscap/browscap/tests/fixtures/issues/';

        $iterator = new \DirectoryIterator($sourceDirectory);

        foreach ($iterator as $file) {
            /** @var $file \SplFileInfo */
            if (!$file->isFile() || $file->getExtension() != 'php') {
                continue;
            }

            $tests = require_once $file->getPathname();

            foreach ($tests as $key => $test) {
                if (isset($data[$key])) {
                    throw new \RuntimeException('Test data is duplicated for key "' . $key . '"');
                }

                if (isset($checks[$test[0]])) {
                    throw new \RuntimeException(
                        'UA "' . $test[0] . '" added more than once, now for key "' . $key . '", before for key "'
                        . $checks[$test[0]] . '"'
                    );
                }

                $data[$key]       = $test;
                $checks[$test[0]] = $key;
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

        self::assertSame(
            $expectedBrowserName,
            $result->getBrowser()->getName(),
            'Expected actual "Browser" to be "' . $expectedBrowserName
            . ' [' . $expectedProperties['Browser'] . ']'
            . '" (was "' . $result->getBrowser()->getName() . '")'
        );

        $expectedBrowserType = $mapper->mapBrowserType($expectedProperties['Browser_Type'])->getName();

        self::assertSame(
            $expectedBrowserType,
            $result->getBrowser()->getBrowserType()->getName(),
            'Expected actual "Browser_Type" to be "' . $expectedBrowserType
            . ' [' . $expectedProperties['Browser_Type'] . ']'
            . '" (was "' . $result->getBrowser()->getBrowserType()->getName() . '")'
        );

        $expectedBrowserMaker = $mapper->mapBrowserMaker(
            $expectedProperties['Browser_Maker'],
            $expectedProperties['Browser']
        );

        self::assertSame(
            $expectedBrowserMaker,
            $result->getBrowser()->getManufacturer()->getName(),
            'Expected actual "Browser_Maker" to be "' . $expectedBrowserMaker
            . ' [' . $expectedProperties['Browser_Maker'] . ']'
            . '" (was "' . $result->getBrowser()->getManufacturer()->getName() . '")'
        );
    }
}
