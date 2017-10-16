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

/**
 * API Constants
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
class Constants
{
    public const HEADER_HTTP_USERAGENT      = 'HTTP_USER_AGENT';
    public const HEADER_DEVICE_STOCK_UA     = 'HTTP_DEVICE_STOCK_UA';
    public const HEADER_DEVICE_UA           = 'HTTP_X_DEVICE_USER_AGENT';
    public const HEADER_SKYFIRE_VERSION     = 'HTTP_X_SKYFIRE_VERSION';
    public const HEADER_SKYFIRE_PHONE       = 'HTTP_X_SKYFIRE_PHONE';
    public const HEADER_BLUECOAT_VIA        = 'HTTP_X_BLUECOAT_VIA';
    public const HEADER_OPERAMINI_PHONE_UA  = 'HTTP_X_OPERAMINI_PHONE_UA';
    public const HEADER_UCBROWSER_UA        = 'HTTP_X_UCBROWSER_UA';
    public const HEADER_UCBROWSER_DEVICE_UA = 'HTTP_X_UCBROWSER_DEVICE_UA';
    public const HEADER_ORIGINAL_UA         = 'HTTP_X_ORIGINAL_USER_AGENT';
    public const HEADER_BOLT_PHONE_UA       = 'HTTP_X_BOLT_PHONE_UA';
    public const HEADER_MOBILE_UA           = 'HTTP_X_MOBILE_UA';
}
