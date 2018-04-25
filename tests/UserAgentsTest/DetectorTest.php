<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace UserAgentsTest;

use BrowserDetector\DetectorFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;
use UaResult\Result\Result;
use UaResult\Result\ResultFactory;

class DetectorTest extends TestCase
{
    /**
     * @var \BrowserDetector\Detector
     */
    private $object;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $logger = new NullLogger();
        $cache  = new FilesystemCache('', 0, 'cache/');

        $factory = new DetectorFactory($cache, $logger);

        $this->object = $factory();
    }

    /**
     * @dataProvider providerGetBrowser
     *
     * @param array  $headers
     * @param Result $expectedResult
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowser(array $headers, Result $expectedResult): void
    {
        $object = $this->object;

        /* @var Result $result */
        $result = $object($headers);

        self::assertInstanceOf(Result::class, $result);

        self::assertEquals($expectedResult, $result);
    }

    /**
     * @return array[]
     */
    public function providerGetBrowser(): array
    {
        $finder = new Finder();
        $finder->files();
        $finder->name('*.yaml');
        $finder->ignoreDotFiles(true);
        $finder->ignoreVCS(true);
        $finder->ignoreUnreadableDirs();
        $finder->in('tests/data/');

        $data   = [];
        $logger = new NullLogger();

        foreach ($finder as $file) {
            /* @var \Symfony\Component\Finder\SplFileInfo $file */

            $tests = Yaml::parse($file->getContents(), Yaml::PARSE_EXCEPTION_ON_INVALID_TYPE);

            foreach ($tests as $test) {
                $expectedResult = (new ResultFactory())->fromArray($logger, $test);

                $data[] = [
                    'headers' => $expectedResult->getHeaders(),
                    'result' => $expectedResult,
                ];
            }
        }

        return $data;
    }
}
