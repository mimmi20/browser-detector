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

namespace BrowserDetector;

use Psr\Http\Message\MessageInterface;
use Psr\Log\LoggerInterface;
use UaRequest\GenericRequestFactory;
use UaRequest\GenericRequestInterface;

use function is_array;

final class RequestBuilder implements RequestBuilderInterface
{
    /** @throws void */
    public function buildRequest(
        LoggerInterface $logger,
        array | GenericRequestInterface | MessageInterface | string $request,
    ): GenericRequestInterface {
        if ($request instanceof GenericRequestInterface) {
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

        $logger->debug('request object created from string');

        return $requestFactory->createRequestFromString($request);
    }
}
