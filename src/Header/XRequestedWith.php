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

namespace BrowserDetector\Header;

use function mb_strtolower;
use function preg_match;

final class XRequestedWith implements HeaderInterface
{
    use HeaderTrait;

    /** @throws void */
    public function hasClientCode(): bool
    {
        return preg_match('/xmlhttprequest|fake/i', $this->value) !== false;
    }

    /** @throws void */
    public function getClientCode(): string | null
    {
        return match (mb_strtolower($this->value)) {
            'com.oupeng.browser' => 'oupeng browser',
            'com.aliyun.mobile.browser' => 'aliyun-browser',
            'com.tencent.mm' => 'wechat app',
            'com.android.browser' => 'android webview',
            'com.lenovo.browser' => 'lenovo browser',
            'com.asus.browser' => 'asus browser',
            'mobi.mgeek.tunnybrowser' => 'dolfin',
            'com.ucmobile.lab' => 'ucbrowser',
            'com.tinyspeck.chatlyio' => 'chatlyio app',
            'com.douban.group' => 'douban app',
            'com.linkedin' => 'linkedinbot',
            'com.browser2345' => '2345 browser',
            'com.mx.browser' => 'maxthon',
            'com.google.android.apps.magazines' => 'google play newsstand',
            'com.google.googlemobile' => 'google mobile app',
            'com.google.android.youtube' => 'youtube app',
            'com.apple.mobilenotes' => 'apple mobilenotes',
            'com.apple.notes' => 'apple notes app',
            'com.google.googleplus' => 'google+ app',
            'com.apple.webkit' => 'apple webkit service',
            'me.android.browser' => 'me browser',
            default => null,
        };
    }
}
