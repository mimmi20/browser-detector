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

use BrowserDetector\RequestBuilder;
use Laminas\Diactoros\ServerRequestFactory;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use UaRequest\Constants;
use UaRequest\GenericRequest;
use UaRequest\GenericRequestFactory;

use function assert;
use function sprintf;

final class RequestBuilderTest extends TestCase
{
    private RequestBuilder $object;

    /** @throws void */
    protected function setUp(): void
    {
        $this->object = new RequestBuilder();
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testGetBrowserFromUaOld(): void
    {
        $useragent = 'testagent';
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::once())
            ->method('debug');
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

        assert($logger instanceof LoggerInterface);
        $result = $this->object->buildRequest($logger, $useragent);
        assert(
            $result instanceof GenericRequest,
            sprintf(
                '$result should be an instance of %s, but is %s',
                GenericRequest::class,
                $result::class,
            ),
        );

        self::assertInstanceOf(GenericRequest::class, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testGetBrowserFromGenericRequest(): void
    {
        $useragent = 'testagent';
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::once())
            ->method('debug');
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

        assert($logger instanceof LoggerInterface);

        $message        = ServerRequestFactory::fromGlobals(
            [Constants::HEADER_HTTP_USERAGENT => [$useragent]],
        );
        $requestFactory = new GenericRequestFactory();
        $request        = $requestFactory->createRequestFromPsr7Message($message);

        $result = $this->object->buildRequest($logger, $request);
        assert(
            $result instanceof GenericRequest,
            sprintf(
                '$result should be an instance of %s, but is %s',
                GenericRequest::class,
                $result::class,
            ),
        );

        self::assertInstanceOf(GenericRequest::class, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testGetBrowserFromGenericRequest2(): void
    {
        $useragent = 'testagent';
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::once())
            ->method('debug');
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

        assert($logger instanceof LoggerInterface);

        $message        = ServerRequestFactory::fromGlobals(
            [Constants::HEADER_HTTP_USERAGENT => [$useragent]],
        );
        $requestFactory = new GenericRequestFactory();
        $request        = $requestFactory->createRequestFromPsr7Message($message);

        $result = $this->object->buildRequest($logger, $request);
        assert(
            $result instanceof GenericRequest,
            sprintf(
                '$result should be an instance of %s, but is %s',
                GenericRequest::class,
                $result::class,
            ),
        );

        self::assertInstanceOf(GenericRequest::class, $result);
    }
}
