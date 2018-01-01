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
namespace BrowserDetectorTest\Helper;

use BrowserDetector\Helper\Constants;
use BrowserDetector\Helper\GenericRequest;
use BrowserDetector\Helper\GenericRequestFactory;
use PHPUnit\Framework\TestCase;

/**
 * test case
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
class GenericRequestFactoryTest extends TestCase
{
    /**
     * @var \BrowserDetector\Helper\GenericRequestFactory
     */
    private $object;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->object = new GenericRequestFactory();
    }

    /**
     * @return void
     */
    public function testCreateRequestFromArray(): void
    {
        $userAgent = 'testUA';
        $header    = [
            Constants::HEADER_HTTP_USERAGENT => $userAgent,
        ];

        $expected = new GenericRequest($header);

        $result = $this->object->createRequestFromArray($header);

        self::assertInstanceOf('\BrowserDetector\Helper\GenericRequest', $result);
        self::assertEquals($expected, $result);
        self::assertSame($userAgent, $result->getBrowserUserAgent());
    }

    /**
     * @return void
     */
    public function testCreateRequestFromEmptyHeaders(): void
    {
        $header = [];

        $expected = new GenericRequest($header);

        $result = $this->object->createRequestFromArray($header);

        self::assertInstanceOf('\BrowserDetector\Helper\GenericRequest', $result);
        self::assertEquals($expected, $result);
        self::assertSame('', $result->getBrowserUserAgent());
    }

    /**
     * @return void
     */
    public function testCreateRequestFromString(): void
    {
        $userAgent = 'testUA';
        $header    = [
            Constants::HEADER_HTTP_USERAGENT => $userAgent,
        ];

        $expected = new GenericRequest($header);

        $result = $this->object->createRequestFromString($userAgent);

        self::assertInstanceOf('\BrowserDetector\Helper\GenericRequest', $result);
        self::assertEquals($expected, $result);
        self::assertSame($userAgent, $result->getBrowserUserAgent());
    }

    /**
     * @return void
     */
    public function testCreateRequestFromPsr7Message(): void
    {
        $userAgent = 'testUA';
        $deviceUa  = 'testDeviceUa';
        $headers   = [
            Constants::HEADER_HTTP_USERAGENT => $userAgent,
            Constants::HEADER_DEVICE_UA      => $deviceUa,
        ];

        $messageHeaders = [
            Constants::HEADER_HTTP_USERAGENT => [$userAgent],
            Constants::HEADER_DEVICE_UA      => [$deviceUa],
        ];

        $expected = new GenericRequest($headers);

        $message = $this->createMock('\Psr\Http\Message\MessageInterface');
        $message->expects(self::once())
            ->method('getHeaders')
            ->willReturn($messageHeaders);

        $result = $this->object->createRequestFromPsr7Message($message);

        self::assertInstanceOf('\BrowserDetector\Helper\GenericRequest', $result);
        self::assertEquals($expected, $result);
        self::assertSame($userAgent, $result->getBrowserUserAgent());
        self::assertSame($deviceUa, $result->getDeviceUserAgent());
    }
}
