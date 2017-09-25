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
class GenericRequestTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruct(): void
    {
        $userAgent = 'testUA';
        $browserUa = 'testBrowserUA';
        $deviceUa  = 'testDeviceUA';
        $headers   = [
            Constants::HEADER_HTTP_USERAGENT => $userAgent,
            Constants::HEADER_DEVICE_UA      => $deviceUa,
            Constants::HEADER_UCBROWSER_UA   => $browserUa,
        ];

        $object = new GenericRequest($headers);

        self::assertSame($headers, $object->getHeaders());
        self::assertSame($browserUa, $object->getBrowserUserAgent());
        self::assertSame($deviceUa, $object->getDeviceUserAgent());
    }

    public function testToarray(): void
    {
        $userAgent = 'testUA';
        $headers   = [
            Constants::HEADER_HTTP_USERAGENT => $userAgent,
        ];

        $original   = new GenericRequest($headers);
        $array      = $original->getHeaders();
        $object     = (new GenericRequestFactory())->createRequestFromArray($array);

        self::assertEquals($original, $object);
    }

    public function testToarraySimple(): void
    {
        $userAgent = 'testUA';
        $headers   = [
            Constants::HEADER_HTTP_USERAGENT => $userAgent,
        ];

        $original   = new GenericRequest($headers);
        $array      = $original->getHeaders();

        self::assertEquals($headers, $array);
    }
}
