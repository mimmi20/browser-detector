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

use BrowserDetector\Helper\GenericRequest\Utils;

/**
 * Generic WURFL Request object containing User Agent, UAProf and xhtml device data; its id
 * property is the SHA512 hash of the user agent
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
class GenericRequest
{
    /**
     * @var array
     */
    private $headers;

    /**
     * @param array $headers
     */
    public function __construct(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getBrowserUserAgent(): string
    {
        return (new Utils($this->headers))->getBrowserUserAgent();
    }

    /**
     * @return string
     */
    public function getDeviceUserAgent(): string
    {
        return (new Utils($this->headers))->getDeviceUserAgent();
    }
}
