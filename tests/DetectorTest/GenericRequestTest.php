<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest;

use BrowserDetector\Constants;
use BrowserDetector\GenericRequest;
use BrowserDetector\Header\HeaderInterface;
use BrowserDetector\Header\HeaderLoaderInterface;
use BrowserDetector\NotFoundException;
use Laminas\Diactoros\ServerRequestFactory;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\MessageInterface;

final class GenericRequestTest extends TestCase
{
    /** @throws Exception */
    public function testConstruct(): void
    {
        $userAgent = 'testUA';
        $browserUa = 'pr(testBrowserUA)';
        $deviceUa  = 'testDeviceUA';
        $headers   = [
            Constants::HEADER_HTTP_USERAGENT => $userAgent,
            'HTTP_DEVICE_STOCK_UA' => $deviceUa,
            'HTTP_X_UCBROWSER_UA' => $browserUa,
        ];

        $expectedHeaders = [
            Constants::HEADER_USERAGENT => $userAgent,
            Constants::HEADER_DEVICE_STOCK_UA => $deviceUa,
            Constants::HEADER_UCBROWSER_UA => $browserUa,
        ];

        $header1 = $this->createMock(HeaderInterface::class);
        $header1->expects(self::any())
            ->method('getValue')
            ->willReturn($deviceUa);
        $header1->expects(self::any())
            ->method('hasPlatformCode')
            ->willReturn(false);
        $header1->expects(self::any())
            ->method('hasClientCode')
            ->willReturn(false);
        $header1->expects(self::any())
            ->method('hasDeviceCode')
            ->willReturn(true);
        $header2 = $this->createMock(HeaderInterface::class);
        $header2->expects(self::any())
            ->method('getValue')
            ->willReturn($browserUa);
        $header2->expects(self::any())
            ->method('hasPlatformCode')
            ->willReturn(false);
        $header2->expects(self::any())
            ->method('hasClientCode')
            ->willReturn(true);
        $header2->expects(self::any())
            ->method('hasEngineCode')
            ->willReturn(true);
        $header2->expects(self::any())
            ->method('hasDeviceCode')
            ->willReturn(false);
        $header3 = $this->createMock(HeaderInterface::class);
        $header3->expects(self::any())
            ->method('getValue')
            ->willReturn($userAgent);
        $header3->expects(self::any())
            ->method('hasPlatformCode')
            ->willReturn(true);
        $header3->expects(self::any())
            ->method('hasClientCode')
            ->willReturn(true);
        $header3->expects(self::any())
            ->method('hasEngineCode')
            ->willReturn(true);
        $header3->expects(self::any())
            ->method('hasDeviceCode')
            ->willReturn(true);

        $loader = $this->createMock(HeaderLoaderInterface::class);
        $loader->expects(self::never())
            ->method('has');
        $matcher = self::exactly(3);
        $loader->expects($matcher)
            ->method('load')
            ->willReturnCallback(
                static function (string $key, string $value) use ($matcher, $browserUa, $deviceUa, $userAgent, $header1, $header2, $header3): HeaderInterface {
                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame(Constants::HEADER_UCBROWSER_UA, $key),
                        2 => self::assertSame(Constants::HEADER_DEVICE_STOCK_UA, $key),
                        default => self::assertSame(Constants::HEADER_USERAGENT, $key),
                    };

                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame($browserUa, $value),
                        2 => self::assertSame($deviceUa, $value),
                        default => self::assertSame($userAgent, $value),
                    };

                    return match ($matcher->numberOfInvocations()) {
                        1 => $header1,
                        2 => $header2,
                        default => $header3,
                    };
                },
            );

        $object = new GenericRequest(ServerRequestFactory::fromGlobals($headers), $loader);

        self::assertSame($expectedHeaders, $object->getHeaders());
    }

    /** @throws Exception */
    public function testToarraySimple(): void
    {
        $userAgent = 'testUA';
        $headers   = [Constants::HEADER_HTTP_USERAGENT => $userAgent, 'HTTP_X_TEST' => 'test', 'HTTP_X_TEST_2' => ''];

        $header = $this->createMock(HeaderInterface::class);
        $header->expects(self::once())
            ->method('getValue')
            ->willReturn($userAgent);
        $header->expects(self::never())
            ->method('hasPlatformCode');
        $header->expects(self::never())
            ->method('hasClientCode');
        $header->expects(self::never())
            ->method('hasEngineCode');
        $header->expects(self::never())
            ->method('hasDeviceCode');

        $loader = $this->createMock(HeaderLoaderInterface::class);
        $loader->expects(self::never())
            ->method('has');
        $loader->expects(self::once())
            ->method('load')
            ->with(Constants::HEADER_USERAGENT, $userAgent)
            ->willReturn($header);

        $original = new GenericRequest(ServerRequestFactory::fromGlobals($headers), $loader);

        self::assertSame(
            [Constants::HEADER_USERAGENT => $userAgent, 'x-test' => 'test'],
            $original->getHeaders(),
        );
        self::assertSame([Constants::HEADER_USERAGENT => $header], $original->getFilteredHeaders());
        self::assertSame('65f857531eabdc37d27f0bce4f03f36863cf88e7', $original->getHash());
    }

    /** @throws Exception */
    public function testGetFilteredHeaders(): void
    {
        $userAgent = 'SAMSUNG-GT-S8500';
        $browserUa = 'pr(testBrowserUA)';
        $deviceUa  = 'testDeviceUA';
        $headers   = [
            Constants::HEADER_HTTP_USERAGENT => $userAgent,
            'HTTP_DEVICE_STOCK_UA' => $deviceUa,
            'HTTP_X_UCBROWSER_UA' => $browserUa,
            'via' => 'test',
        ];

        $header1 = $this->createMock(HeaderInterface::class);
        $header1->expects(self::once())
            ->method('getValue')
            ->willReturn($browserUa);
        $header1->expects(self::never())
            ->method('hasPlatformCode');
        $header1->expects(self::never())
            ->method('hasClientCode');
        $header1->expects(self::never())
            ->method('hasDeviceCode');

        $header2 = $this->createMock(HeaderInterface::class);
        $header2->expects(self::once())
            ->method('getValue')
            ->willReturn($deviceUa);
        $header2->expects(self::never())
            ->method('hasPlatformCode');
        $header2->expects(self::never())
            ->method('hasClientCode');
        $header2->expects(self::never())
            ->method('hasDeviceCode');

        $header3 = $this->createMock(HeaderInterface::class);
        $header3->expects(self::once())
            ->method('getValue')
            ->willReturn($userAgent);
        $header3->expects(self::never())
            ->method('hasPlatformCode');
        $header3->expects(self::never())
            ->method('hasClientCode');
        $header3->expects(self::never())
            ->method('hasDeviceCode');

        $expectedHeaders = [
            Constants::HEADER_UCBROWSER_UA => $header1,
            Constants::HEADER_DEVICE_STOCK_UA => $header2,
            Constants::HEADER_USERAGENT => $header3,
        ];

        $loader = $this->createMock(HeaderLoaderInterface::class);
        $loader->expects(self::never())
            ->method('has');
        $matcher = self::exactly(3);
        $loader->expects($matcher)
            ->method('load')
            ->willReturnCallback(
                static function (string $key, string $value) use ($matcher, $browserUa, $deviceUa, $userAgent, $header1, $header2, $header3): HeaderInterface {
                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame(Constants::HEADER_UCBROWSER_UA, $key),
                        2 => self::assertSame(Constants::HEADER_DEVICE_STOCK_UA, $key),
                        default => self::assertSame(Constants::HEADER_USERAGENT, $key),
                    };

                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame($browserUa, $value),
                        2 => self::assertSame($deviceUa, $value),
                        default => self::assertSame($userAgent, $value),
                    };

                    return match ($matcher->numberOfInvocations()) {
                        1 => $header1,
                        2 => $header2,
                        default => $header3,
                    };
                },
            );

        $original      = new GenericRequest(ServerRequestFactory::fromGlobals($headers), $loader);
        $resultHeaders = $original->getFilteredHeaders();

        self::assertSame($expectedHeaders, $resultHeaders);
        self::assertSame('230c34f734fa2f80c81be71068dd4ccad2dc0ff2', $original->getHash());
    }

    /** @throws Exception */
    public function testGetFilteredHeadersWithLoadException(): void
    {
        $userAgent       = 'SAMSUNG-GT-S8500';
        $expectedHeaders = [];
        $headers         = [
            'HTTP_DEVICE_STOCK_UA' => $userAgent,
            'via' => 'test',
        ];

        $header = $this->createMock(HeaderInterface::class);
        $header->expects(self::never())
            ->method('getValue');
        $header->expects(self::never())
            ->method('hasPlatformCode');
        $header->expects(self::never())
            ->method('hasClientCode');
        $header->expects(self::never())
            ->method('hasDeviceCode');

        $loader = $this->createMock(HeaderLoaderInterface::class);
        $loader->expects(self::never())
            ->method('has');
        $loader->expects(self::once())
            ->method('load')
            ->with(Constants::HEADER_DEVICE_STOCK_UA, $userAgent)
            ->willThrowException(new NotFoundException('not-found'));

        $original      = new GenericRequest(ServerRequestFactory::fromGlobals($headers), $loader);
        $resultHeaders = $original->getFilteredHeaders();

        self::assertSame($expectedHeaders, $resultHeaders);
        self::assertSame('8739602554c7f3241958e3cc9b57fdecb474d508', $original->getHash());
    }

    /** @throws Exception */
    public function testGetFilteredHeadersWithLoadException2(): void
    {
        $userAgent = 'SAMSUNG-GT-S8500';
        $browserUa = 'pr(testBrowserUA)';
        $deviceUa  = 'testDeviceUA';
        $headers   = [
            Constants::HEADER_HTTP_USERAGENT => $userAgent,
            'x-unknown-header' => 'test',
            'HTTP_DEVICE_STOCK_UA' => $deviceUa,
            'HTTP_X_UCBROWSER_UA' => $browserUa,
            'via' => 'test',
        ];

        $header1 = $this->createMock(HeaderInterface::class);
        $header1->expects(self::once())
            ->method('getValue')
            ->willReturn($browserUa);
        $header1->expects(self::never())
            ->method('hasPlatformCode');
        $header1->expects(self::never())
            ->method('hasClientCode');
        $header1->expects(self::never())
            ->method('hasDeviceCode');

        $header2 = $this->createMock(HeaderInterface::class);
        $header2->expects(self::once())
            ->method('getValue')
            ->willReturn($userAgent);
        $header2->expects(self::never())
            ->method('hasPlatformCode');
        $header2->expects(self::never())
            ->method('hasClientCode');
        $header2->expects(self::never())
            ->method('hasDeviceCode');

        $expectedHeaders = [
            Constants::HEADER_UCBROWSER_UA => $header1,
            Constants::HEADER_USERAGENT => $header2,
        ];

        $loader = $this->createMock(HeaderLoaderInterface::class);
        $loader->expects(self::never())
            ->method('has');
        $matcher = self::exactly(3);
        $loader->expects($matcher)
            ->method('load')
            ->willReturnCallback(
                static function (string $key, string $value) use ($matcher, $browserUa, $deviceUa, $userAgent, $header1, $header2): HeaderInterface {
                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame(Constants::HEADER_UCBROWSER_UA, $key),
                        2 => self::assertSame(Constants::HEADER_DEVICE_STOCK_UA, $key),
                        default => self::assertSame(Constants::HEADER_USERAGENT, $key),
                    };

                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame($browserUa, $value),
                        2 => self::assertSame($deviceUa, $value),
                        default => self::assertSame($userAgent, $value),
                    };

                    return match ($matcher->numberOfInvocations()) {
                        1 => $header1,
                        2 => throw new NotFoundException('not-found'),
                        default => $header2,
                    };
                },
            );

        $original      = new GenericRequest(ServerRequestFactory::fromGlobals($headers), $loader);
        $resultHeaders = $original->getFilteredHeaders();

        self::assertSame($expectedHeaders, $resultHeaders);
        self::assertSame('f7191df756b36dcfd684d6976dbbebb180da9410', $original->getHash());
    }

    /** @throws Exception */
    public function testGetFilteredHeadersWithLoadException3(): void
    {
        $userAgent = 'SAMSUNG-GT-S8500';
        $browserUa = 'pr(testBrowserUA)';
        $deviceUa  = 'testDeviceUA';
        $headers   = [
            Constants::HEADER_USERAGENT => $userAgent,
            0 => 'test',
            'x-unknown-header' => 'test',
            Constants::HEADER_DEVICE_STOCK_UA => $deviceUa,
            Constants::HEADER_UCBROWSER_UA => $browserUa,
            'via' => 'test',
        ];

        $header1 = $this->createMock(HeaderInterface::class);
        $header1->expects(self::once())
            ->method('getValue')
            ->willReturn($browserUa);
        $header1->expects(self::never())
            ->method('hasPlatformCode');
        $header1->expects(self::never())
            ->method('hasClientCode');
        $header1->expects(self::never())
            ->method('hasDeviceCode');

        $header2 = $this->createMock(HeaderInterface::class);
        $header2->expects(self::once())
            ->method('getValue')
            ->willReturn($userAgent);
        $header2->expects(self::never())
            ->method('hasPlatformCode');
        $header2->expects(self::never())
            ->method('hasClientCode');
        $header2->expects(self::never())
            ->method('hasDeviceCode');

        $expectedHeaders = [
            Constants::HEADER_UCBROWSER_UA => $header1,
            Constants::HEADER_USERAGENT => $header2,
        ];

        $loader = $this->createMock(HeaderLoaderInterface::class);
        $loader->expects(self::never())
            ->method('has');
        $matcher = self::exactly(3);
        $loader->expects($matcher)
            ->method('load')
            ->willReturnCallback(
                static function (string $key, string $value) use ($matcher, $browserUa, $deviceUa, $userAgent, $header1, $header2): HeaderInterface {
                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame(Constants::HEADER_UCBROWSER_UA, $key),
                        2 => self::assertSame(Constants::HEADER_DEVICE_STOCK_UA, $key),
                        default => self::assertSame(Constants::HEADER_USERAGENT, $key),
                    };

                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame($browserUa, $value),
                        2 => self::assertSame($deviceUa, $value),
                        default => self::assertSame($userAgent, $value),
                    };

                    return match ($matcher->numberOfInvocations()) {
                        1 => $header1,
                        2 => throw new NotFoundException('not-found'),
                        default => $header2,
                    };
                },
            );

        $message = $this->createMock(MessageInterface::class);
        $message->expects(self::once())
            ->method('getHeaders')
            ->willReturn($headers);
        $matcher = self::exactly(5);
        $message->expects($matcher)
            ->method('getHeaderLine')
            ->willReturnCallback(
                static function (string $name) use ($matcher, $browserUa, $deviceUa, $userAgent): string {
                    match ($matcher->numberOfInvocations()) {
                        2 => self::assertSame('x-unknown-header', $name),
                        3 => self::assertSame(Constants::HEADER_DEVICE_STOCK_UA, $name),
                        4 => self::assertSame(Constants::HEADER_UCBROWSER_UA, $name),
                        5 => self::assertSame('via', $name),
                        default => self::assertSame(Constants::HEADER_USERAGENT, $name),
                    };

                    return match ($matcher->numberOfInvocations()) {
                        2 => 'test',
                        3 => $deviceUa,
                        4 => $browserUa,
                        5 => 'test',
                        default => $userAgent,
                    };
                },
            );

        $original      = new GenericRequest($message, $loader);
        $resultHeaders = $original->getFilteredHeaders();

        self::assertSame($expectedHeaders, $resultHeaders);
        self::assertSame('f7191df756b36dcfd684d6976dbbebb180da9410', $original->getHash());
    }

    /** @throws Exception */
    public function testGetFilteredHeaders2(): void
    {
        $userAgent = 'SAMSUNG-GT-S8500';
        $browserUa = 'pr(testBrowserUA)';
        $deviceUa  = 'testDeviceUA';
        $headers   = [
            Constants::HEADER_USERAGENT => [$userAgent],
            Constants::HEADER_DEVICE_STOCK_UA => [$deviceUa],
            'via' => ['test'],
            'x-test' => [''],
            Constants::HEADER_UCBROWSER_UA => [$browserUa],
        ];

        $header1 = $this->createMock(HeaderInterface::class);
        $header1->expects(self::once())
            ->method('getValue')
            ->willReturn($browserUa);
        $header1->expects(self::never())
            ->method('hasPlatformCode');
        $header1->expects(self::never())
            ->method('hasClientCode');
        $header1->expects(self::never())
            ->method('hasDeviceCode');

        $header2 = $this->createMock(HeaderInterface::class);
        $header2->expects(self::once())
            ->method('getValue')
            ->willReturn($deviceUa);
        $header2->expects(self::never())
            ->method('hasPlatformCode');
        $header2->expects(self::never())
            ->method('hasClientCode');
        $header2->expects(self::never())
            ->method('hasDeviceCode');

        $header3 = $this->createMock(HeaderInterface::class);
        $header3->expects(self::once())
            ->method('getValue')
            ->willReturn($userAgent);
        $header3->expects(self::never())
            ->method('hasPlatformCode');
        $header3->expects(self::never())
            ->method('hasClientCode');
        $header3->expects(self::never())
            ->method('hasDeviceCode');

        $expectedHeaders = [
            Constants::HEADER_UCBROWSER_UA => $header1,
            Constants::HEADER_DEVICE_STOCK_UA => $header2,
            Constants::HEADER_USERAGENT => $header3,
        ];

        $loader = $this->createMock(HeaderLoaderInterface::class);
        $loader->expects(self::never())
            ->method('has');
        $matcher = self::exactly(3);
        $loader->expects($matcher)
            ->method('load')
            ->willReturnCallback(
                static function (string $key, string $value) use ($matcher, $browserUa, $deviceUa, $userAgent, $header1, $header2, $header3): HeaderInterface {
                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame(Constants::HEADER_UCBROWSER_UA, $key),
                        2 => self::assertSame(Constants::HEADER_DEVICE_STOCK_UA, $key),
                        default => self::assertSame(Constants::HEADER_USERAGENT, $key),
                    };

                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame($browserUa, $value),
                        2 => self::assertSame($deviceUa, $value),
                        default => self::assertSame($userAgent, $value),
                    };

                    return match ($matcher->numberOfInvocations()) {
                        1 => $header1,
                        2 => $header2,
                        default => $header3,
                    };
                },
            );

        $message = $this->createMock(MessageInterface::class);
        $message->expects(self::once())
            ->method('getHeaders')
            ->willReturn($headers);
        $matcher = self::exactly(5);
        $message->expects($matcher)
            ->method('getHeaderLine')
            ->willReturnCallback(
                static function (string $name) use ($matcher, $userAgent, $deviceUa, $browserUa): string {
                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame(Constants::HEADER_USERAGENT, $name),
                        2 => self::assertSame(Constants::HEADER_DEVICE_STOCK_UA, $name),
                        5 => self::assertSame(Constants::HEADER_UCBROWSER_UA, $name),
                        3 => self::assertSame('via', $name),
                        default => self::assertSame('x-test', $name),
                    };

                    return match ($matcher->numberOfInvocations()) {
                        1 => $userAgent,
                        2 => $deviceUa,
                        5 => $browserUa,
                        3 => 'test',
                        default => '',
                    };
                },
            );

        $original      = new GenericRequest($message, $loader);
        $resultHeaders = $original->getFilteredHeaders();

        self::assertSame($expectedHeaders, $resultHeaders);
        self::assertSame('230c34f734fa2f80c81be71068dd4ccad2dc0ff2', $original->getHash());
    }
}
