<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Parser\Header;

use UaRequest\Constants;

enum Headers: string
{
    case HEADER_BAIDU_FLYFLOW = Constants::HEADER_BAIDU_FLYFLOW;

    case HEADER_DEVICE_STOCK_UA = Constants::HEADER_DEVICE_STOCK_UA;

    case HEADER_SEC_CH_UA = Constants::HEADER_SEC_CH_UA;

    case HEADER_SEC_CH_UA_ARCH = Constants::HEADER_SEC_CH_UA_ARCH;

    case HEADER_SEC_CH_UA_BITNESS = Constants::HEADER_SEC_CH_UA_BITNESS;

    case HEADER_SEC_CH_UA_FULL_VERSION = Constants::HEADER_SEC_CH_UA_FULL_VERSION;

    case HEADER_SEC_CH_UA_FULL_VERSION_LIST = Constants::HEADER_SEC_CH_UA_FULL_VERSION_LIST;

    case HEADER_SEC_CH_UA_MOBILE = Constants::HEADER_SEC_CH_UA_MOBILE;

    case HEADER_SEC_CH_UA_MODEL = Constants::HEADER_SEC_CH_UA_MODEL;

    case HEADER_SEC_CH_UA_PLATFORM = Constants::HEADER_SEC_CH_UA_PLATFORM;

    case HEADER_SEC_CH_UA_PLATFORM_VERSION = Constants::HEADER_SEC_CH_UA_PLATFORM_VERSION;

    case HEADER_UA_OS = Constants::HEADER_UA_OS;

    case HEADER_CRAWLED_BY = Constants::HEADER_CRAWLED_BY;

    case HEADER_USERAGENT = Constants::HEADER_USERAGENT;

    case HEADER_ORIGINAL_UA = Constants::HEADER_ORIGINAL_UA;

    case HEADER_DEVICE_UA = Constants::HEADER_DEVICE_UA;

    case HEADER_OPERAMINI_PHONE = Constants::HEADER_OPERAMINI_PHONE;

    case HEADER_OPERAMINI_PHONE_UA = Constants::HEADER_OPERAMINI_PHONE_UA;

    case HEADER_PUFFIN_UA = Constants::HEADER_PUFFIN_UA;

    case HEADER_REQUESTED_WITH = Constants::HEADER_REQUESTED_WITH;

    case HEADER_UCBROWSER_DEVICE = Constants::HEADER_UCBROWSER_DEVICE;

    case HEADER_UCBROWSER_DEVICE_UA = Constants::HEADER_UCBROWSER_DEVICE_UA;

    case HEADER_UCBROWSER_PHONE = Constants::HEADER_UCBROWSER_PHONE;

    case HEADER_UCBROWSER_PHONE_UA = Constants::HEADER_UCBROWSER_PHONE_UA;

    case HEADER_UCBROWSER_UA = Constants::HEADER_UCBROWSER_UA;
}
