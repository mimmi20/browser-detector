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
use UaRequest\Constants;
use UaRequest\GenericRequestFactory;
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
     * @param string $userAgent
     * @param Result $expectedResult
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testGetBrowserFromUaOld(string $userAgent, Result $expectedResult): void
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
    public function testGetBrowserFromUa(string $userAgent, Result $expectedResult): void
    {
        $object = $this->object;

        /* @var \UaResult\Result\Result $result */
        $result = $object($userAgent);

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
        $object = $this->object;

        /* @var Result $result */
        $result = $object([Constants::HEADER_HTTP_USERAGENT => $userAgent]);

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
        $object  = $this->object;

        /* @var Result $result */
        $result = $object($message);

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
    public function testGetBrowserFromGenericRequest(string $userAgent, Result $expectedResult): void
    {
        $message        = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => [$userAgent]]);
        $requestFactory = new GenericRequestFactory();
        $object         = $this->object;
        $request        = $requestFactory->createRequestFromPsr7Message($message);

        /* @var Result $result */
        $result = $object($request);

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

        $object = $this->object;

        $object(new \stdClass());
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
                'ua' => $test['ua'],
                'result' => (new ResultFactory())->fromArray($logger, $test['result']),
            ];
        }

        return $data;
    }
}
