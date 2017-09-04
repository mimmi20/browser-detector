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

/**
 * test case
 */
class GenericRequestFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Helper\GenericRequestFactory
     */
    private $object = null;

    public function setUp()
    {
        $this->object = new GenericRequestFactory();
    }

    public function testCreateRequestFromArray()
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

    public function testCreateRequestFromEmptyHeaders()
    {
        $header    = [];

        $expected = new GenericRequest($header);

        $result = $this->object->createRequestFromArray($header);

        self::assertInstanceOf('\BrowserDetector\Helper\GenericRequest', $result);
        self::assertEquals($expected, $result);
        self::assertSame('', $result->getBrowserUserAgent());
    }

    public function testCreateRequestFromString()
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

    public function testCreateRequestFromPsr7Message()
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
