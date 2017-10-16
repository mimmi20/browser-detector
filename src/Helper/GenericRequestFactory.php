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
namespace BrowserDetector\Helper;

use Psr\Http\Message\MessageInterface;

/**
 * Creates a Generic WURFL Request from the raw HTTP Request
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
class GenericRequestFactory
{
    /**
     * Creates Generic Request from the given HTTP Request (normally $_SERVER).
     *
     * @param array $headers HTTP Request
     *
     * @return \BrowserDetector\Helper\GenericRequest
     */
    public function createRequestFromArray(array $headers)
    {
        return new GenericRequest($headers);
    }

    /**
     * Create a Generic Request from the given $userAgent
     *
     * @param string $userAgent
     *
     * @return \BrowserDetector\Helper\GenericRequest
     */
    public function createRequestFromString(string $userAgent)
    {
        return new GenericRequest([Constants::HEADER_HTTP_USERAGENT => $userAgent]);
    }

    /**
     * Create a Generic Request from a given PSR-7 HTTP message
     *
     * @param \Psr\Http\Message\MessageInterface $message
     *
     * @return \BrowserDetector\Helper\GenericRequest
     */
    public function createRequestFromPsr7Message(MessageInterface $message)
    {
        $headers = [];

        foreach ($message->getHeaders() as $name => $values) {
            $headers[$name] = implode(', ', $values);
        }

        return new GenericRequest($headers);
    }
}
