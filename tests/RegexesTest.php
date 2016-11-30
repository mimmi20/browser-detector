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

use BrowserDetector\Factory\NormalizerFactory;
use BrowserDetector\Factory\RegexFactory;
use Monolog\Handler\NullHandler;
use Monolog\Logger;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

/**
 * Class UserAgentsTest
 *
 * @category   CompareTest
 *
 * @author     Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @group      useragenttest
 */
abstract class RegexesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BrowserDetector\Factory\RegexFactory
     */
    protected $object = null;

    /**
     * @var string
     */
    protected $sourceDirectory = 'tests/issues/00000-browscap/';

    protected static $ok  = 0;
    protected static $nok = 0;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $logger = new Logger('browser-detector-tests');
        $logger->pushHandler(new NullHandler());

        $adapter      = new Local(__DIR__ . '/../cache/');
        $cache        = new FilesystemCachePool(new Filesystem($adapter));
        $this->object = new RegexFactory($cache, $logger);
    }

    /**
     * @return array[]
     */
    public function userAgentDataProvider()
    {
        $start = microtime(true);

        echo 'starting provider ', static::class, ' ...';

        $data                  = [];
        $browscapIssueIterator = new \RecursiveDirectoryIterator($this->sourceDirectory);

        foreach (new \RecursiveIteratorIterator($browscapIssueIterator) as $file) {
            /** @var $file \SplFileInfo */
            if (!$file->isFile() || $file->getExtension() !== 'json') {
                continue;
            }

            $tests = json_decode(file_get_contents($file->getPathname()));

            foreach ($tests as $key => $test) {
                if (isset($data[$key])) {
                    // Test data is duplicated for key
                    continue;
                }

                $data[$key] = $test;
            }
        }

        echo ' finished (', number_format(microtime(true) - $start, 4), ' sec., ', str_pad(count($data), 6, ' ', STR_PAD_LEFT), ' test', (count($data) <> 1 ? 's' : ''), ')', PHP_EOL;

        return $data;
    }

    /**
     * @dataProvider userAgentDataProvider
     *
     * @param string $userAgent
     */
    public function testUserAgents($userAgent)
    {
        $normalizer = (new NormalizerFactory())->build();

        $normalizedUa = $normalizer->normalize($userAgent);

        $result = $this->object->detect($normalizedUa);

        self::assertNotNull($result, 'regexes are missing');
        self::assertNotFalse($result, "no match for UA \n    input     : $userAgent\n    normalized: $normalizedUa");
        self::$ok++;
    }

    /**
     * This method is called after the last test of this test class is run.
     */
    public static function tearDownAfterClass()
    {
        echo PHP_EOL, 'Result: ', self::$ok, ' detected', PHP_EOL;
    }
}
