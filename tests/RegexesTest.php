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
use Cache\Adapter\Void\VoidCachePool;
use Monolog\Handler\NullHandler;
use Monolog\Logger;
use UaDataMapper\InputMapper;

/**
 * Class UserAgentsTest
 *
 * @category   CompareTest
 *
 * @author     Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @group      useragenttest
 */
class RegexesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BrowserDetector\BrowserDetector
     */
    private $object = null;

    /**
     * @var \UaDataMapper\InputMapper
     */
    private static $mapper = null;

    /**
     * @var string
     */
    private $sourceDirectory = 'tests/issues/00000-browscap/';

    private static $ok  = 0;
    private static $nok = 0;

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
        $logger = new Logger('browser-detector-regex-tests');
        $logger->pushHandler(new NullHandler());

        $cache        = new VoidCachePool();
        $this->object = new BrowserDetector($cache, $logger);
    }

    /**
     * @return array[]
     */
    public function userAgentDataProvider()
    {
        $start = microtime(true);

        $data                  = [];
        $browscapIssueIterator = new \RecursiveDirectoryIterator($this->sourceDirectory);

        foreach (new \RecursiveIteratorIterator($browscapIssueIterator) as $file) {
            /** @var $file \SplFileInfo */
            if (!$file->isFile() || $file->getExtension() !== 'php') {
                continue;
            }

            echo 'reading file ', $file->getRealPath(), ' ...', PHP_EOL;

            $tests = require_once $file->getPathname();

            foreach ($tests as $key => $test) {
                if (isset($data[$key])) {
                    // Test data is duplicated for key
                    continue;
                }

                $data[$key] = $test;
            }
        }

        echo 'finished (', number_format(microtime(true) - $start, 4), ' sec., ', str_pad(count($data), 6, ' ', STR_PAD_LEFT), ' test', (count($data) <> 1 ? 's' : ''), ')', PHP_EOL;

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
    public function testUserAgents($userAgent)
    {
        try {
            $this->object->getBrowser($userAgent);
            self::$ok++;
        } catch (\UnexpectedValueException $e) {
            self::$nok++;

            $this->fail($e->getMessage());
        }
    }

    /**
     * This method is called after the last test of this test class is run.
     *
     * @since Method available since Release 3.4.0
     */
    public static function tearDownAfterClass()
    {
        echo PHP_EOL, 'Result: ', self::$ok, ' detected, ', self::$nok, ' not detected', PHP_EOL;
    }
}
