<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest;

use BrowserDetector\RequestBuilder;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use UaRequest\Constants;
use UaRequest\GenericRequest;
use UaRequest\GenericRequestFactory;
use UaResult\Result\Result;
use Zend\Diactoros\ServerRequestFactory;

final class RequestBuilderTest extends TestCase
{
    /**
     * @var \BrowserDetector\RequestBuilder
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new RequestBuilder();
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testGetBrowserFromUaOld(): void
    {
        $useragent = 'testagent';
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::once())
            ->method('debug');
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var \UaResult\Result\Result $result */
        $result = $this->object->buildRequest($logger, $useragent);

        static::assertInstanceOf(GenericRequest::class, $result);
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testGetBrowserFromGenericRequest(): void
    {
        $useragent = 'testagent';
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::once())
            ->method('debug');
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        /** @var \Psr\Log\LoggerInterface $logger */

        $message        = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => [$useragent]]);
        $requestFactory = new GenericRequestFactory();
        $request        = $requestFactory->createRequestFromPsr7Message($message);

        /** @var Result $result */
        $result = $this->object->buildRequest($logger, $request);

        static::assertInstanceOf(GenericRequest::class, $result);
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testGetBrowserFromGenericRequest2(): void
    {
        $useragent = 'testagent';
        $logger    = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::once())
            ->method('debug');
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        /** @var \Psr\Log\LoggerInterface $logger */

        $message        = ServerRequestFactory::fromGlobals([Constants::HEADER_HTTP_USERAGENT => [$useragent]]);
        $requestFactory = new GenericRequestFactory();
        $request        = $requestFactory->createRequestFromPsr7Message($message);

        /** @var Result $result */
        $result = $this->object->buildRequest($logger, $request);

        static::assertInstanceOf(GenericRequest::class, $result);
    }

    /**
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testGetBrowserFromInvalid(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('debug');
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        /* @var \Psr\Log\LoggerInterface $logger */

        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('the request parameter has to be a string, an array or an instance of \Psr\Http\Message\MessageInterface');

        $this->object->buildRequest($logger, new \stdClass());
    }
}
