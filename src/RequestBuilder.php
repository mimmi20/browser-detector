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
namespace BrowserDetector;

use Psr\Http\Message\MessageInterface;
use Psr\Log\LoggerInterface;
use UaRequest\GenericRequest;
use UaRequest\GenericRequestFactory;
use UnexpectedValueException;

final class RequestBuilder implements RequestBuilderInterface
{
    /**
     * @param \Psr\Log\LoggerInterface                                                  $logger
     * @param array|\Psr\Http\Message\MessageInterface|string|\UaRequest\GenericRequest $request
     *
     * @throws \UnexpectedValueException
     *
     * @return \UaRequest\GenericRequest
     */
    public function buildRequest(LoggerInterface $logger, $request): GenericRequest
    {
        if ($request instanceof GenericRequest) {
            $logger->debug('request object used as is');

            return $request;
        }

        $requestFactory = new GenericRequestFactory();

        if ($request instanceof MessageInterface) {
            $logger->debug('request object created from PSR-7 http message');

            return $requestFactory->createRequestFromPsr7Message($request);
        }

        if (is_array($request)) {
            $logger->debug('request object created from array');

            return $requestFactory->createRequestFromArray($request);
        }

        if (is_string($request)) {
            $logger->debug('request object created from string');

            return $requestFactory->createRequestFromString($request);
        }

        throw new UnexpectedValueException(
            'the request parameter has to be a string, an array or an instance of \Psr\Http\Message\MessageInterface'
        );
    }
}
