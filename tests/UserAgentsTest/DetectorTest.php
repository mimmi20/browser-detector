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
use Seld\JsonLint\JsonParser;
use Seld\JsonLint\ParsingException;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\Finder\Finder;
use UaResult\Browser\BrowserInterface;
use UaResult\Device\DeviceInterface;
use UaResult\Engine\EngineInterface;
use UaResult\Os\OsInterface;
use UaResult\Result\Result;
use UaResult\Result\ResultFactory;
use UaResult\Result\ResultInterface;

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
     * @throws \ReflectionException
     *
     * @return void
     */
    protected function setUp(): void
    {
        $logger = $this->getMockBuilder(NullLogger::class)
            ->disableOriginalConstructor()
            ->setMethods(['info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])
            ->getMock();
        $logger
            ->expects(self::never())
            ->method('info');
        $logger
            ->expects(self::never())
            ->method('notice');
        $logger
            ->expects(self::never())
            ->method('warning');
        $logger
            ->expects(self::never())
            ->method('error');
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        $cache = new FilesystemCache('', 0, 'cache/');

        /** @var NullLogger $logger */
        $factory = new DetectorFactory($cache, $logger);

        $object = $factory();
        $prop   = new \ReflectionProperty($object, 'logger');
        $prop->setAccessible(true);
        $prop->setValue($object, $logger);
        $this->object = $object;
    }

    /**
     * @dataProvider providerGetBrowser
     *
     * @param array  $headers
     * @param Result $expectedResult
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return void
     */
    public function testGetBrowser(array $headers, Result $expectedResult): void
    {
        $object = $this->object;

        /* @var Result $result */
        $result = $object($headers);

        static::assertInstanceOf(
            ResultInterface::class,
            $result,
            sprintf(
                'found result is not an instance of "\UaResult\Result\ResultInterface" for headers %s',
                json_encode($headers, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
            )
        );

        $foundBrowser = $result->getBrowser();

        static::assertInstanceOf(
            BrowserInterface::class,
            $foundBrowser,
            sprintf(
                'found browser is not an instance of "\UaResult\Browser\BrowserInterface" for headers %s',
                json_encode($headers, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
            )
        );

        $foundEngine = $result->getEngine();

        static::assertInstanceOf(
            EngineInterface::class,
            $foundEngine,
            sprintf(
                'found engine is not an instance of "\UaResult\Engine\EngineInterface" for headers %s',
                json_encode($headers, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
            )
        );

        $foundPlatform = $result->getOs();

        static::assertInstanceOf(
            OsInterface::class,
            $foundPlatform,
            sprintf(
                'found platform is not an instance of "\UaResult\Os\OsInterface" for headers %s',
                json_encode($headers, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
            )
        );

        $foundDevice = $result->getDevice();

        static::assertInstanceOf(
            DeviceInterface::class,
            $foundDevice,
            sprintf(
                'found result is not an instance of "\UaResult\Device\DeviceInterface" for headers %s',
                json_encode($headers, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
            )
        );

        self::assertEquals(
            $expectedResult,
            $result,
            sprintf(
                'detection result mismatch for headers %s',
                json_encode($headers, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
            )
        );
    }

    /**
     * @throws \Exception
     *
     * @return array[]
     */
    public function providerGetBrowser(): array
    {
        $finder = new Finder();
        $finder->files();
        $finder->name('*.json');
        $finder->ignoreDotFiles(true);
        $finder->ignoreVCS(true);
        $finder->ignoreUnreadableDirs();
        $finder->in('tests/data/');

        $data   = [];
        $logger = new NullLogger();

        $jsonParser = new JsonParser();

        foreach ($finder as $file) {
            /* @var \Symfony\Component\Finder\SplFileInfo $file */

            try {
                $tests = $jsonParser->parse(
                    $file->getContents(),
                    JsonParser::DETECT_KEY_CONFLICTS | JsonParser::PARSE_TO_ASSOC
                );
            } catch (ParsingException $e) {
                throw new \Exception(sprintf('file "%s" contains invalid json', $file->getPathname()), 0, $e);
            }

            foreach ($tests as $i => $test) {
                $expectedResult = (new ResultFactory())->fromArray($logger, $test);
                $index          = sprintf('file:%s test:%d', $file->getRelativePathname(), $i);

                $data[$index] = [
                    'headers' => $expectedResult->getHeaders(),
                    'result' => $expectedResult,
                ];
            }
        }

        return $data;
    }
}
