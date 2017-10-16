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
namespace BrowserDetectorTest;

use BrowserDetector\Detector;
use BrowserDetector\Helper\Constants;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use UaResult\Result\Result;
use UaResult\Result\ResultFactory;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
class DetectorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Detector
     */
    private $object;

    /**
     * @var \Psr\Cache\CacheItemPoolInterface
     */
    private static $cache = null;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private static $logger = null;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new Detector(static::getCache(), static::getLogger());
    }

    /**
     * @dataProvider providerGetBrowser
     *
     * @param string                  $userAgent
     * @param \UaResult\Result\Result $expectedResult
     *
     * @return void
     */
    public function testGetBrowserFromUa(string $userAgent, Result $expectedResult): void
    {
        /* @var \UaResult\Result\Result $result */
        $result = $this->object->getBrowser($userAgent);

        self::assertInstanceOf('\UaResult\Result\Result', $result);

        self::assertEquals($expectedResult, $result);
    }

    /**
     * @dataProvider providerGetBrowser
     *
     * @param string                  $userAgent
     * @param \UaResult\Result\Result $expectedResult
     *
     * @return void
     */
    public function testGetBrowserFromArray(string $userAgent, Result $expectedResult): void
    {
        /* @var \UaResult\Result\Result $result */
        $result = $this->object->getBrowser([Constants::HEADER_HTTP_USERAGENT => $userAgent]);

        self::assertInstanceOf('\UaResult\Result\Result', $result);

        self::assertEquals($expectedResult, $result);
    }

    /**
     * @dataProvider providerGetBrowser
     *
     * @param string                  $userAgent
     * @param \UaResult\Result\Result $expectedResult
     *
     * @return void
     */
    public function testGetBrowserFromPsr7Message(string $userAgent, Result $expectedResult): void
    {
        /* @var \PHPUnit_Framework_MockObject_MockObject|\Psr\Http\Message\MessageInterface $message */
        $message = $this->createMock('\Psr\Http\Message\MessageInterface');
        $message
            ->expects(self::once())
            ->method('getHeaders')
            ->willReturn([Constants::HEADER_HTTP_USERAGENT => [$userAgent]]);

        /* @var \UaResult\Result\Result $result */
        $result = $this->object->getBrowser($message);

        self::assertInstanceOf('\UaResult\Result\Result', $result);

        self::assertEquals($expectedResult, $result);
    }

    /**
     * @return void
     */
    public function testGetBrowserFromInvalid(): void
    {
        $this->expectException('\UnexpectedValueException');
        $this->expectExceptionMessage('the request parameter has to be a string, an array or an instance of \Psr\Http\Message\MessageInterface');

        $this->object->getBrowser(new \stdClass());
    }

    /**
     * @return array[]
     */
    public function providerGetBrowser(): array
    {
        $data  = [];
        $tests = json_decode(file_get_contents('tests/data/detector.json'), true);

        foreach ($tests as $key => $test) {
            if (isset($data[$key])) {
                // Test data is duplicated for key
                continue;
            }

            $data[$key] = [
                'ua'     => $test['ua'],
                'result' => (new ResultFactory())->fromArray(static::getCache(), static::getLogger(), $test['result']),
            ];
        }

        return $data;
    }

    /**
     * @return \Psr\Cache\CacheItemPoolInterface
     */
    private static function getCache(): CacheItemPoolInterface
    {
        if (null !== static::$cache) {
            return static::$cache;
        }

        static::$cache = new FilesystemAdapter('', 0, __DIR__ . '/../cache/');

        return static::$cache;
    }

    /**
     * @return \Psr\Log\LoggerInterface
     */
    private static function getLogger(): LoggerInterface
    {
        if (null !== static::$logger) {
            return static::$logger;
        }

        static::$logger = new NullLogger();

        return static::$logger;
    }
}
