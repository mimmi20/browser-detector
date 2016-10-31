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
use BrowserDetector\Factory\RegexFactory;
use Cache\Adapter\Void\VoidCachePool;
use Monolog\Handler\NullHandler;
use Monolog\Logger;
use UaDataMapper\InputMapper;
use UaNormalizer\Generic;
use UaNormalizer\UserAgentNormalizer;
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
        $adapter      = new Local(__DIR__ . '/../cache/');
        $cache        = new FilesystemCachePool(new Filesystem($adapter));
        $this->object = new RegexFactory($cache);
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
            if (!$file->isFile() || $file->getExtension() !== 'php') {
                continue;
            }

            $tests = require_once $file->getPathname();

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
     * @group  regex
     */
    public function testRegexes()
    {
        $regexes = $this->object->getRegexes();

        self::assertInternalType('array', $regexes, 'no regexes available');

        foreach ($regexes as $regex) {
            self::assertInternalType('string', $regex);

            echo 'testing regex "', $regex, '"', PHP_EOL;

            self::assertInternalType('int', preg_match($regex, 'test-ua'));
        }
    }

    /**
     * @dataProvider userAgentDataProvider
     *
     * @param string $userAgent
     */
    public function testUserAgents($userAgent)
    {
        $normalizer = new UserAgentNormalizer(
            [
                new Generic\BabelFish(),
                new Generic\IISLogging(),
                new Generic\LocaleRemover(),
                new Generic\EncryptionRemover(),
                new Generic\Mozilla(),
                new Generic\KhtmlGecko(),
                new Generic\NovarraGoogleTranslator(),
                new Generic\SerialNumbers(),
                new Generic\TransferEncoding(),
                new Generic\YesWAP(),
            ]
        );

        $normalizedUa = $normalizer->normalize($userAgent);

        $result = $this->object->detect($normalizedUa);

        self::assertNotNull($result, 'regexes are missing');
        self::assertNotFalse($result, 'no match for UA ' . $normalizedUa);
        self::assertInternalType('array', $result, 'wrong result type for UA ' . $normalizedUa);
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
