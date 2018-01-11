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
namespace BrowserDetector\Helper\GenericRequest;

use BrowserDetector\Helper\Constants;

/**
 * WURFL related utilities
 */
class Utils
{
    /**
     * @var array
     */
    private $userAgentSearchOrder = [
        Constants::HEADER_DEVICE_STOCK_UA     => 'device',
        Constants::HEADER_DEVICE_UA           => 'device',
        Constants::HEADER_UCBROWSER_DEVICE_UA => 'device',
        Constants::HEADER_SKYFIRE_PHONE       => 'device',
        Constants::HEADER_SKYFIRE_VERSION     => 'browser',
        Constants::HEADER_BLUECOAT_VIA        => 'browser',
        Constants::HEADER_OPERAMINI_PHONE_UA  => 'browser',
        Constants::HEADER_BOLT_PHONE_UA       => 'browser',
        Constants::HEADER_UCBROWSER_UA        => 'browser',
        Constants::HEADER_MOBILE_UA           => 'browser',
        Constants::HEADER_ORIGINAL_UA         => 'generic',
        Constants::HEADER_HTTP_USERAGENT      => 'generic',
    ];

    /**
     * @var array
     */
    private $request = [];

    /**
     * @param array $request
     */
    public function __construct(array $request = [])
    {
        $this->request = $request;
    }

    /**
     * returns the User Agent or empty string if not found
     *
     * @return string
     */
    public function getDeviceUserAgent(): string
    {
        foreach ($this->userAgentSearchOrder as $header => $type) {
            if (!in_array($type, ['device', 'generic'])) {
                continue;
            }

            if (isset($this->request[$header])) {
                return $this->request[$header];
            }
        }

        return '';
    }

    /**
     * returns the User Agent or empty string if not found
     *
     * @return string
     */
    public function getBrowserUserAgent(): string
    {
        foreach ($this->userAgentSearchOrder as $header => $type) {
            if (!in_array($type, ['browser', 'generic'])) {
                continue;
            }

            if (isset($this->request[$header])) {
                return $this->request[$header];
            }
        }

        return '';
    }
}
