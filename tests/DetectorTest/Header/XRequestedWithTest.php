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
            ['derek.iSurf', true, 'isurf'],
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
            ['com.rs.explorer.filemanager', true, 'rs-file'],
            ['com.skout.android', true, 'skout'],
            ['com.sony.nfx.app.sfrc', true, 'news-suite-by-sony'],
            ['com.surfshark.vpnclient.android', true, 'surfshark-app'],
            ['com.swisscows.search', true, 'swisscows-private-search'],
            ['com.tinder', true, 'tinder-app'],
            ['com.totalav.android', true, 'total-av-mobile-security'],
            ['com.turtc', true, 'türkiye-milli-arama-motoru'],
            ['mark.via.gp', true, 'via-browser'],
            ['com.kiwibrowser.browser', true, 'kiwi'],
            ['com.brave.browser', true, 'brave'],
            ['org.mozilla.focus', true, 'firefox focus'],
            ['com.vivaldi.browser', true, 'vivaldi'],
            ['com.aloha.browser', true, 'aloha-browser'],
            ['com.cloudmosa.puffinFree', true, 'puffin'],
            ['com.ucmobile.intl', true, 'ucbrowser'],
            ['com.tvwebbrowser.v22', true, 'tv-browser-internet'],
            ['com.udicorn.proxy', true, 'blue-proxy'],
            ['com.ume.browser.cust', true, 'ume-browser'],
            ['com.v2.vpn.security.free', true, 'fast-unlimited-vpn'],
            ['com.videochat.livu', true, 'livu-app'],
            ['com.wiseplay', true, 'wiseplay'],
            ['com.yahoo.onesearch', true, 'yahoo-onesearch'],
            ['com.yy.hiyo', true, 'hago-app'],
            ['de.baumann.browser', true, 'foss-browser'],
            ['free.vpn.unblock.proxy.vpnmonster', true, 'vpn-monster'],
            ['io.metamask', true, 'meta-mask'],
            ['it.ideasolutions.kyms', true, 'kyms'],
            ['it.tolelab.fvd', true, 'free-video-downloader'],
            ['com.snapchat.android', true, 'snapchat app'],
            ['jp.gocro.smartnews.android', true, 'smart-news-app'],
            ['kik.android', true, 'kik'],
            ['com.hisense.odinbrowser', true, 'odin-browser'],
            ['org.quantumbadger.redreader', true, 'red-reader'],
            ['phone.cleaner.antivirus.speed.booster', true, 'phone-clean'],
            ['reactivephone.msearch', true, 'smart-search-web-browser'],
            ['secure.explorer.web.browser', true, 'browser lite'],
            ['snapu2b.com', true, 'snapu2b'],
            ['pi.browser', true, 'pi browser'],
            ['alohabrowser', true, 'aloha-browser'],
            ['org.telegram.messenger', true, 'telegram-app'],
            ['xbrowser', true, 'x-browser'],
            ['com.xbrowser.play', true, 'x-browser'],
            ['com.mycompany.app.soulbrowser', true, 'soul-browser'],
            ['com.sec.android.app.sbrowser.lite', true, 'samsung-browser-lite'],
            ['jp.ddo.pigsty.HabitBrowser', true, 'habit-browser'],
            ['com.mi.globalbrowser.mini', true, 'mint browser'],
            ['me.webalert', true, 'web-alert-app'],
            ['com.pure.mini.browser', true, 'mini-web-browser'],
            ['acr.browser.raisebrowserfull', true, 'raise-fast-browser'],
            ['com.Fast.BrowserUc.lite', true, 'fast-browser-uc-lite'],
            ['acr.browser.barebones', true, 'lightning-browser'],
            ['anar.app.darkweb', true, 'dark-web-browser'],
            ['com.cake.browser', true, 'cake-browser'],
            ['com.iebrowser.fast', true, 'ie-browser-fast'],
            ['info.sunista.app', true, 'sanista-persian-instagram'],
            ['com.instapro.app', true, 'insta-pro'],
            ['com.kakao.talk', true, 'kakaotalk'],
            ['acr.browser.linxy', true, 'vegas-browser'],
            ['com.oh.bro', true, 'oh-browser'],
            ['com.oh.brop', true, 'oh-private-browser'],
            ['net.onecook.browser', true, 'stargon-browser'],
            ['phx.hot.browser', true, 'anka-browser'],
            ['org.torproject.android', true, 'orbot'],
            ['web.browser.dragon', true, 'dragon-browser'],
            ['org.easyweb.browser', true, 'easy-browser'],
            ['com.sharkeeapp.browser', true, 'sharkee-browser'],
            ['com.mobiu.browser', true, 'lark-browser'],
            ['com.qflair.browserq', true, 'pluma-browser'],
            ['com.noxgroup.app.browser', true, 'nox-browser'],
            ['com.jio.web', true, 'jio-sphere'],
            ['com.cookiegames.smartcookie', true, 'smartcookieweb-privacy-browser'],
            ['org.lineageos.jelly', true, 'jelly-browser'],
            ['com.oceanhero.search', true, 'ocean-hero-app'],
            ['com.oryon.multitasking', true, 'multitasking-app'],
            ['net.fast.web.browser', true, 'web-browser-web-explorer'],
            ['com.bestvideodownloader.newvideodownloader', true, 'all-video-downloader'],
            ['com.yiyinkuang.searchboard', true, 'search+-for-google'],
            ['com.aeroinsta.android', true, 'aero-insta'],
            ['com.cliqz.browser', true, 'cliqz-browser'],
            ['com.appssppa.idesktoppcbrowser', true, 'idesktop-pc-browser'],
            ['com.sec.app.samsungprintservice', true, 'samsung-print-service-plugin'],
            // ['com.doro.apps.browser', true, ''],
            ['jp.co.canon.bsd.ad.pixmaprint', true, 'canon-print'],
            ['com.gl9.cloudBrowser', true, 'surfbrowser'],
            ['com.kaweapp.webexplorer', true, 'web-explorer'],
            ['com.snaptube.premium', true, 'snap-tube'],
            ['com.eagle.web.browser.internet.privacy.browser', true, 'private-browser-web-browser'],
            ['com.cleanmaster.security', true, 'cm-security'],
            ['devian.tubemate.v3', true, 'tube-mate'],
            ['de.einsundeins.searchapp.gmx.com', true, 'gmx-search'],
            ['acr.browser.lightning', true, 'lightning-browser'],
            ['acr.browser.lightning2', true, 'lightning-browser'],
            ['acr.browser.lightningq16w', true, 'lightning-browser'],
            ['com.web_view_mohammed.ad.webview_app', true, 'appso'],
            ['com.fsecure.ms.netcologne', true, 'sicherheitspaket'],
            ['de.telekom.mail', true, 'telekom-mail'],
            ['ai.blokee.browser.android', true, 'bloket-browser'],
            ['com.ume.browser.euas', true, 'ume-browser'],
            ['com.ume.browser.bose', true, 'ume-browser'],
            ['com.ume.browser.international', true, 'ume-browser'],
            ['com.ume.browser.latinamerican', true, 'ume-browser'],
            ['com.ume.browser.mexicotelcel', true, 'ume-browser'],
            ['com.ume.browser.venezuelavtelca', true, 'ume-browser'],
            ['com.ume.browser.northamerica', true, 'ume-browser'],
            ['com.ume.browser.newage', true, 'ume-browser'],
            ['com.wolvesinteractive.racinggo', true, 'racing-go'],
            ['com.microsoft.amp.apps.bingnews', true, 'microsoft-start'],
            ['com.litepure.browser.gp', true, 'pure-browser'],
            ['com.boatbrowser.free', true, 'boat-browser'],
            ['com.brother.mfc.brprint', true, 'brother-iprint-scan'],
            ['com.emoticon.screen.home.launcher', true, 'in-launcher'],
            ['com.explore.web.browser', true, 'web-browser-explorer'],
            ['com.emporia.browser', true, 'emporia-app'],
            ['de.telekom.epub', true, 'pageplace-reader'],
            ['com.appsverse.photon', true, 'photon-browser'],
            ['com.dolphin.browser.zero', true, 'dolfin-zero'],
            ['com.stoutner.privacybrowser.standard', true, 'stoutner-privacy-browser'],
            ['com.skype.raider', true, 'skype'],
            ['de.gdata.mobilesecurity2b', true, 'tie-team-mobile-security'],
            // ['webexplorer.amazing.biro', true, ''],
            ['de.freenet.mail', true, 'freenet-mail'],
            ['com.transsion.phoenix', true, 'phoenix browser'],
            ['com.startpage', true, 'startpage-private-search-engine'],
            ['jp.hazuki.yuzubrowser', true, 'yuzu-browser'],
            ['net.dezor.browser', true, 'dezor-browser'],
            ['com.go.browser', true, 'go-browser'],
            ['com.dv.adm', true, 'advanced-download-manager'],
            ['com.androidbull.incognito.browser', true, 'incognito-browser'],
            ['com.symantec.mobile.idsafe', true, 'norton-password-manager'],
            ['com.lge.snappage', true, 'snap-page'],
        ];
    }
}
