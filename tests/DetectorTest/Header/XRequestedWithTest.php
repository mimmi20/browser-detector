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

namespace BrowserDetectorTest\Header;

use BrowserDetector\Header\XRequestedWith;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

use function sprintf;

final class XRequestedWithTest extends TestCase
{
    /** @throws ExpectationFailedException */
    #[DataProvider('providerUa')]
    public function testData(string $ua, bool $hasClientInfo, string | null $clientCode): void
    {
        $header = new XRequestedWith($ua);

        self::assertSame($ua, $header->getValue(), sprintf('value mismatch for ua "%s"', $ua));
        self::assertSame(
            $ua,
            $header->getNormalizedValue(),
            sprintf('value mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getDeviceIsMobile(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse($header->hasDeviceCode(), sprintf('device info mismatch for ua "%s"', $ua));
        self::assertNull(
            $header->getDeviceCode(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $hasClientInfo,
            $header->hasClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $clientCode,
            $header->getClientCode(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertFalse($header->hasEngineCode(), sprintf('engine info mismatch for ua "%s"', $ua));
        self::assertNull(
            $header->getEngineCode(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertNull(
            $header->getEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
    }

    /**
     * @return array<int, array<int, bool|string|null>>
     *
     * @throws void
     */
    public static function providerUa(): array
    {
        return [
            ['com.browser2345', true, '2345 browser'],
            ['this.is.a.fake.id.to.test.unknown.ids', false, null],
            ['me.android.browser', true, 'me browser'],
            ['com.android.browser', true, 'android webview'],
            ['com.mx.browser', true, 'maxthon'],
            ['mobi.mgeek.TunnyBrowser', true, 'dolfin'],
            ['com.tencent.mm', true, 'wechat app'],
            ['com.asus.browser', true, 'asus browser'],
            ['com.UCMobile.lab', true, 'ucbrowser'],
            ['com.oupeng.browser', true, 'oupeng browser'],
            ['com.lenovo.browser', true, 'lenovo browser'],
            ['derek.iSurf', true, null],
            ['com.aliyun.mobile.browser', true, 'aliyun-browser'],
            ['XMLHttpRequest', false, null],
            ['com.tinyspeck.chatlyio', true, 'chatlyio app'],
            ['com.douban.group', true, 'douban app'],
            ['com.linkedin', true, 'linkedinbot'],
            ['com.google.android.apps.magazines', true, 'google play newsstand'],
            ['com.google.googlemobile', true, 'google mobile app'],
            ['com.google.android.youtube', true, 'youtube app'],
            ['com.apple.mobilenotes', true, 'apple mobilenotes'],
            ['com.apple.notes', true, 'apple notes app'],
            ['com.google.googleplus', true, 'google+ app'],
            ['com.apple.webkit', true, 'apple webkit service'],
            ['com.duckduckgo.mobile.android', true, 'duckduck app'],
            ['com.opera.mini.native', true, 'opera mini'],
            ['com.google.android.apps.searchlite', true, 'google search lite'],
            ['com.facebook.katana', true, 'facebook app'],
            ['com.huawei.browser', true, 'huawei-browser'],
            ['com.huawei.search', true, 'hi-search'],
            ['com.microsoft.bing', true, 'bingsearch'],
            ['com.microsoft.office.outlook', true, 'outlook'],
            ['com.opera.gx', true, 'opera gx'],
            ['com.ksmobile.cb', true, 'cm browser'],
            ['com.android.chrome', true, 'chrome'],
            ['com.facebook.orca', true, 'facebook messenger app'],
            ['jp.co.yahoo.android.yjtop', true, 'yahoo! app'],
            ['com.instagram.android', true, 'instagram app'],
            ['com.microsoft.bingintl', true, 'bingsearch'],
            ['com.nhn.android.search', true, 'naver'],
            ['com.sina.weibo', true, 'weibo app'],
            ['com.opera.touch', true, 'opera touch'],
            ['org.mozilla.klar', true, 'firefox klar'],
            ['jp.co.fenrir.android.sleipnir', true, 'sleipnir'],
            ['de.gdata.mobilesecurityorange', true, 'g-data mobile security'],
            ['com.active.cleaner', true, 'active-cleaner'],
            ['com.aol.mobile.aolapp', true, 'aol-app'],
            ['com.appsinnova.android.keepclean', true, 'keep-clean'],
            ['com.ayoba.ayoba', true, 'ayoba-app'],
            ['com.cmcm.armorfly', true, 'armorfly-browser'],
            ['com.emporia.emporiaapprebuild', true, 'emporia-app'],
            ['com.espn.score_center', true, 'espn-app'],
            ['com.fancyclean.security.antivirus', true, 'fancy-security'],
            ['com.fsecure.ms.buhldata', true, 'wiso-internet-security'],
            ['com.fsecure.ms.darty', true, 'darty-securite'],
            ['com.fsecure.ms.dc', true, 'f-secure mobile security'],
            ['com.fsecure.ms.nifty', true, 'always safe security 24'],
            ['com.fsecure.ms.safe', true, 'f-secure safe'],
            ['com.fsecure.ms.saunalahti_m', true, 'elisa-turvapaketti'],
            ['com.fsecure.ms.swisscom.sa', true, 'swisscom-internet-security'],
            ['com.fsecure.ms.ziggo', true, 'ziggo-safe-online'],
            ['com.google.android.gms', true, 'google-play-services'],
            ['com.hld.anzenbokusu', true, 's-gallery'],
            ['com.hld.anzenbokusucal', true, 'calculator-photo'],
            ['com.hld.anzenbokusufake', true, 'calculator-hide'],
            ['com.hornet.android', true, 'hornet'],
            ['com.huawei.appmarket', true, 'huawei-app-gallery'],
            ['com.huawei.fastapp', true, 'huawei-quick-app-center'],
            ['com.huawei.hwsearch', true, 'huawei-petal-search'],
            ['com.amazon.webapps.gms.search', true, 'google-search'],
            ['com.andrewshu.android.reddit', true, 'reddit-is-fun'],
            ['com.andrewshu.android.redditdonation', true, 'reddit-is-fun'],
            ['com.jaumo', true, 'jaumo'],
            ['com.jaumo.prime', true, 'jaumo-prime'],
            ['com.jb.security', true, 'go-security'],
            ['com.lenovo.anyshare.gps', true, 'share-it'],
            ['com.michatapp.im', true, 'mi-chat-app'],
            ['com.michatapp.im.lite', true, 'mi-chat-lite'],
            ['com.noxgroup.app.security', true, 'nox-security'],
            ['com.rcplatform.livechat', true, 'tumile'],
        ];
    }
}
