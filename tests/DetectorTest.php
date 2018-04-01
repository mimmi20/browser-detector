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
namespace BrowserDetectorTest;

use BrowserDetector\Detector;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Simple\FilesystemCache;
use UaRequest\Constants;
use UaResult\Result\Result;
use UaResult\Result\ResultFactory;
use Zend\Diactoros\ServerRequestFactory;

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
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Seld\JsonLint\ParsingException
     *
     * @return void
     */
    protected function setUp(): void
    {
        //$this->markTestSkipped();
        $logger = new NullLogger();
        $cache  = new FilesystemCache('', 0, __DIR__ . '/../cache/');

        $this->object = new Detector($cache, $logger);
    }

    /**
     * @dataProvider providerGetBrowser
     *
     * @param string $userAgent
     * @param Result $expectedResult
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserFromUa(string $userAgent, Result $expectedResult): void
    {
        /* @var \UaResult\Result\Result $result */
        $result = $this->object->getBrowser($userAgent);

        self::assertInstanceOf(Result::class, $result);

        self::assertEquals($expectedResult, $result);
    }

    /**
     * @dataProvider providerGetBrowser
     *
     * @param string $userAgent
     * @param Result $expectedResult
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testParseString(string $userAgent, Result $expectedResult): void
    {
        /* @var \UaResult\Result\Result $result */
        $result = $this->object->parseString($userAgent);

        self::assertInstanceOf(Result::class, $result);

        self::assertEquals($expectedResult, $result);
    }

    /**
     * @dataProvider providerGetBrowser
     *
     * @param string $userAgent
     * @param Result $expectedResult
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserFromArray(string $userAgent, Result $expectedResult): void
    {
        /* @var Result $result */
        $result = $this->object->getBrowser([Constants::HEADER_HTTP_USERAGENT => $userAgent]);

        self::assertInstanceOf(Result::class, $result);

        self::assertEquals($expectedResult, $result);
    }

    /**
     * @dataProvider providerGetBrowser
     *
     * @param string $userAgent
     * @param Result $expectedResult
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testParseArray(string $userAgent, Result $expectedResult): void
    {
        /* @var Result $result */
        $result = $this->object->parseArray([Constants::HEADER_HTTP_USERAGENT => $userAgent]);

        self::assertInstanceOf(Result::class, $result);

        self::assertEquals($expectedResult, $result);
    }

    /**
     * @dataProvider providerGetBrowser
     *
     * @param string $userAgent
     * @param Result $expectedResult
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserFromPsr7Message(string $userAgent, Result $expectedResult): void
    {
        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => [$userAgent]]);

        /* @var Result $result */
        $result = $this->object->getBrowser($message);

        self::assertInstanceOf(Result::class, $result);

        self::assertEquals($expectedResult, $result);
    }

    /**
     * @dataProvider providerGetBrowser
     *
     * @param string $userAgent
     * @param Result $expectedResult
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testParseMessage(string $userAgent, Result $expectedResult): void
    {
        $message = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => [$userAgent]]);

        /* @var Result $result */
        $result = $this->object->parseMessage($message);

        self::assertInstanceOf(Result::class, $result);

        self::assertEquals($expectedResult, $result);
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
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
        $data   = [];
        $tests  = json_decode(file_get_contents('tests/data/detector.json'), true);
        $logger = new NullLogger();

        foreach ($tests as $key => $test) {
            if (isset($data[$key])) {
                // Test data is duplicated for key
                continue;
            }

            $data[$key] = [
                'ua'     => $test['ua'],
                'result' => (new ResultFactory())->fromArray($logger, $test['result']),
            ];
        }

        return $data;
    }
}
