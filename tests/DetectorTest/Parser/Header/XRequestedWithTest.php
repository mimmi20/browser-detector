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

namespace BrowserDetectorTest\Parser\Header;

use BrowserDetector\Parser\Header\XRequestedWithClientCode;
use BrowserDetector\Parser\Header\XRequestedWithClientVersion;
use BrowserDetector\Parser\Header\XRequestedWithPlatformCode;
use BrowserDetector\Version\NullVersion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaRequest\Header\XRequestedWith;
use UaResult\Bits\Bits;
use UaResult\Device\Architecture;
use UnexpectedValueException;

use function sprintf;

#[CoversClass(XRequestedWithClientCode::class)]
#[CoversClass(XRequestedWithClientVersion::class)]
final class XRequestedWithTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws UnexpectedValueException
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    #[DataProvider('providerUa')]
    public function testData(
        string $ua,
        bool $hasClientInfo,
        string | null $clientCode,
        bool $hasClientVersion,
        string | null $clientVersion,
        bool $hasPlatformCode,
        string | null $platformCode,
    ): void {
        $header = new XRequestedWith(
            value: $ua,
            clientCode: new XRequestedWithClientCode(),
            clientVersion: new XRequestedWithClientVersion(),
            platformCode: new XRequestedWithPlatformCode(),
        );

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
        self::assertSame(
            Architecture::unknown,
            $header->getDeviceArchitecture(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasDeviceBitness(),
            sprintf('device info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            Bits::unknown,
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
        self::assertSame(
            $hasClientVersion,
            $header->hasClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );

        if ($clientVersion === null) {
            self::assertInstanceOf(
                NullVersion::class,
                $header->getClientVersion(),
                sprintf('browser info mismatch for ua "%s"', $ua),
            );
        } else {
            self::assertSame(
                $clientVersion,
                $header->getClientVersion()->getVersion(),
                sprintf('browser info mismatch for ua "%s"', $ua),
            );
        }

        self::assertSame(
            $hasPlatformCode,
            $header->hasPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $platformCode,
            $header->getPlatformCode(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertFalse(
            $header->hasPlatformVersion(),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertInstanceOf(
            NullVersion::class,
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
        self::assertInstanceOf(
            NullVersion::class,
            $header->getEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
    }

    /**
     * @return array<int, array<int, bool|string|null>>
     *
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    public static function providerUa(): array
    {
        return [
            ['com.browser2345', true, '2345 browser', false, null, false, null],
            ['this.is.a.fake.id.to.test.unknown.ids', false, null, false, null, false, null],
            ['me.android.browser', true, 'me browser', false, null, false, null],
            ['com.android.browser', true, 'android webview', false, null, false, null],
            ['com.mx.browser', true, 'maxthon', false, null, false, null],
            ['mobi.mgeek.TunnyBrowser', true, 'dolfin', false, null, false, null],
            ['com.tencent.mm', true, 'wechat app', false, null, false, null],
            ['com.asus.browser', true, 'asus browser', false, null, false, null],
            ['com.UCMobile.lab', true, 'ucbrowser', false, null, false, null],
            ['com.oupeng.browser', true, 'oupeng browser', false, null, false, null],
            ['com.lenovo.browser', true, 'lenovo browser', false, null, false, null],
            ['derek.iSurf', true, 'isurf', false, null, false, null],
            ['com.aliyun.mobile.browser', true, 'aliyun-browser', false, null, false, null],
            ['XMLHttpRequest', false, null, false, null, false, null],
            ['com.tinyspeck.chatlyio', true, 'chatlyio app', false, null, false, null],
            ['com.douban.group', true, 'douban app', false, null, false, null],
            ['com.linkedin', true, 'linkedinbot', false, null, false, null],
            ['com.google.android.apps.magazines', true, 'google play newsstand', false, null, false, null],
            ['com.google.googlemobile', true, 'google mobile app', false, null, false, null],
            ['com.google.android.youtube', true, 'youtube app', false, null, false, null],
            ['com.apple.mobilenotes', true, 'apple mobilenotes', false, null, false, null],
            ['com.apple.notes', true, 'apple notes app', false, null, false, null],
            ['com.google.googleplus', true, 'google+ app', false, null, false, null],
            ['com.apple.webkit', true, 'apple webkit service', false, null, false, null],
            ['com.duckduckgo.mobile.android', true, 'duckduck app', false, null, false, null],
            ['com.opera.mini.native', true, 'opera mini', false, null, false, null],
            ['com.google.android.apps.searchlite', true, 'google search lite', false, null, false, null],
            ['com.facebook.katana', true, 'facebook app', false, null, false, null],
            ['com.huawei.browser', true, 'huawei-browser', false, null, false, null],
            ['com.huawei.search', true, 'hi-search', false, null, false, null],
            ['com.microsoft.bing', true, 'bingsearch', false, null, false, null],
            ['com.microsoft.office.outlook', true, 'outlook', false, null, false, null],
            ['com.opera.gx', true, 'opera gx', false, null, false, null],
            ['com.ksmobile.cb', true, 'cm browser', false, null, false, null],
            ['com.android.chrome', true, 'chrome', false, null, false, null],
            ['com.facebook.orca', true, 'facebook messenger app', false, null, false, null],
            ['jp.co.yahoo.android.yjtop', true, 'yahoo! japan', false, null, false, null],
            ['com.instagram.android', true, 'instagram app', false, null, false, null],
            ['com.microsoft.bingintl', true, 'bingsearch', false, null, false, null],
            ['com.nhn.android.search', true, 'naver', false, null, false, null],
            ['com.sina.weibo', true, 'weibo app', false, null, false, null],
            ['com.opera.touch', true, 'opera touch', false, null, false, null],
            ['org.mozilla.klar', true, 'firefox klar', false, null, false, null],
            ['jp.co.fenrir.android.sleipnir', true, 'sleipnir', false, null, false, null],
            ['de.gdata.mobilesecurityorange', true, 'g-data mobile security', false, null, false, null],
            ['com.active.cleaner', true, 'active-cleaner', false, null, false, null],
            ['com.aol.mobile.aolapp', true, 'aol-app', false, null, false, null],
            ['com.appsinnova.android.keepclean', true, 'keep-clean', false, null, false, null],
            ['com.ayoba.ayoba', true, 'ayoba-app', false, null, false, null],
            ['com.cmcm.armorfly', true, 'armorfly-browser', false, null, false, null],
            ['com.emporia.emporiaapprebuild', true, 'emporia-app', false, null, false, null],
            ['com.espn.score_center', true, 'espn-app', false, null, false, null],
            ['com.fancyclean.security.antivirus', true, 'fancy-security', false, null, false, null],
            ['com.fsecure.ms.buhldata', true, 'wiso-internet-security', false, null, false, null],
            ['com.fsecure.ms.darty', true, 'darty-securite', false, null, false, null],
            ['com.fsecure.ms.dc', true, 'f-secure mobile security', false, null, false, null],
            ['com.fsecure.ms.nifty', true, 'always safe security 24', false, null, false, null],
            ['com.fsecure.ms.safe', true, 'f-secure safe', false, null, false, null],
            ['com.fsecure.ms.saunalahti_m', true, 'elisa-turvapaketti', false, null, false, null],
            ['com.fsecure.ms.swisscom.sa', true, 'swisscom-internet-security', false, null, false, null],
            ['com.fsecure.ms.ziggo', true, 'ziggo-safe-online', false, null, false, null],
            ['com.google.android.gms', true, 'google-play-services', false, null, false, null],
            ['com.hld.anzenbokusu', true, 's-gallery', false, null, false, null],
            ['com.hld.anzenbokusucal', true, 'calculator-photo', false, null, false, null],
            ['com.hld.anzenbokusufake', true, 'calculator-hide', false, null, false, null],
            ['com.hornet.android', true, 'hornet', false, null, false, null],
            ['com.huawei.appmarket', true, 'huawei-app-gallery', false, null, false, null],
            ['com.huawei.fastapp', true, 'huawei-quick-app-center', false, null, false, null],
            ['com.huawei.hwsearch', true, 'huawei-petal-search', false, null, false, null],
            ['com.amazon.webapps.gms.search', true, 'google-search', false, null, false, null],
            ['com.andrewshu.android.reddit', true, 'reddit-is-fun', false, null, false, null],
            ['com.andrewshu.android.redditdonation', true, 'reddit-is-fun', false, null, false, null],
            ['com.jaumo', true, 'jaumo', false, null, false, null],
            ['com.jaumo.prime', true, 'jaumo-prime', false, null, false, null],
            ['com.jb.security', true, 'go-security', false, null, false, null],
            ['com.lenovo.anyshare.gps', true, 'share-it', false, null, false, null],
            ['com.michatapp.im', true, 'mi-chat-app', false, null, false, null],
            ['com.michatapp.im.lite', true, 'mi-chat-lite', false, null, false, null],
            ['com.noxgroup.app.security', true, 'nox-security', false, null, false, null],
            ['com.rcplatform.livechat', true, 'tumile', false, null, false, null],
            ['com.rs.explorer.filemanager', true, 'rs-file', false, null, false, null],
            ['com.skout.android', true, 'skout', false, null, false, null],
            ['com.sony.nfx.app.sfrc', true, 'news-suite-by-sony', false, null, false, null],
            ['com.surfshark.vpnclient.android', true, 'surfshark-app', false, null, false, null],
            ['com.swisscows.search', true, 'swisscows-private-search', false, null, false, null],
            ['com.tinder', true, 'tinder-app', false, null, false, null],
            ['com.totalav.android', true, 'total-av-mobile-security', false, null, false, null],
            ['com.turtc', true, 'türkiye-milli-arama-motoru', false, null, false, null],
            ['mark.via.gp', true, 'via-browser', false, null, false, null],
            ['com.kiwibrowser.browser', true, 'kiwi', false, null, false, null],
            ['com.brave.browser', true, 'brave', false, null, false, null],
            ['org.mozilla.focus', true, 'firefox focus', false, null, false, null],
            ['com.vivaldi.browser', true, 'vivaldi', false, null, false, null],
            ['com.aloha.browser', true, 'aloha-browser', false, null, false, null],
            ['com.cloudmosa.puffinFree', true, 'puffin', false, null, false, null],
            ['com.ucmobile.intl', true, 'ucbrowser', false, null, false, null],
            ['com.tvwebbrowser.v22', true, 'tv-browser-internet', false, null, false, null],
            ['com.udicorn.proxy', true, 'blue-proxy', false, null, false, null],
            ['com.ume.browser.cust', true, 'ume-browser', false, null, false, null],
            ['com.v2.vpn.security.free', true, 'fast-unlimited-vpn', false, null, false, null],
            ['com.videochat.livu', true, 'livu-app', false, null, false, null],
            ['com.wiseplay', true, 'wiseplay', false, null, false, null],
            ['com.yahoo.onesearch', true, 'yahoo-onesearch', false, null, false, null],
            ['com.yy.hiyo', true, 'hago-app', false, null, false, null],
            ['de.baumann.browser', true, 'foss-browser', false, null, false, null],
            ['free.vpn.unblock.proxy.vpnmonster', true, 'vpn-monster', false, null, false, null],
            ['io.metamask', true, 'meta-mask', false, null, false, null],
            ['it.ideasolutions.kyms', true, 'kyms', false, null, false, null],
            ['it.tolelab.fvd', true, 'free-video-downloader', false, null, false, null],
            ['com.snapchat.android', true, 'snapchat app', false, null, false, null],
            ['jp.gocro.smartnews.android', true, 'smart-news-app', false, null, false, null],
            ['kik.android', true, 'kik', false, null, false, null],
            ['com.hisense.odinbrowser', true, 'odin-browser', false, null, false, null],
            ['org.quantumbadger.redreader', true, 'red-reader', false, null, false, null],
            ['phone.cleaner.antivirus.speed.booster', true, 'phone-clean', false, null, false, null],
            ['reactivephone.msearch', true, 'smart-search-web-browser', false, null, false, null],
            ['secure.explorer.web.browser', true, 'browser lite', false, null, false, null],
            ['snapu2b.com', true, 'snapu2b', false, null, false, null],
            ['pi.browser', true, 'pi browser', false, null, false, null],
            ['alohabrowser', true, 'aloha-browser', false, null, false, null],
            ['org.telegram.messenger', true, 'telegram-app', false, null, false, null],
            ['xbrowser', true, 'x-browser', false, null, false, null],
            ['com.xbrowser.play', true, 'x-browser', false, null, false, null],
            ['com.mycompany.app.soulbrowser', true, 'soul-browser', false, null, false, null],
            ['com.sec.android.app.sbrowser.lite', true, 'samsung-browser-lite', false, null, false, null],
            ['jp.ddo.pigsty.HabitBrowser', true, 'habit-browser', false, null, false, null],
            ['com.mi.globalbrowser.mini', true, 'mint browser', false, null, false, null],
            ['me.webalert', true, 'web-alert-app', false, null, false, null],
            ['com.pure.mini.browser', true, 'mini-web-browser', false, null, false, null],
            ['acr.browser.raisebrowserfull', true, 'raise-fast-browser', false, null, false, null],
            ['com.Fast.BrowserUc.lite', true, 'fast-browser-uc-lite', false, null, false, null],
            ['acr.browser.barebones', true, 'lightning-browser', false, null, false, null],
            ['anar.app.darkweb', true, 'dark-web-browser', false, null, false, null],
            ['com.cake.browser', true, 'cake-browser', false, null, false, null],
            ['com.iebrowser.fast', true, 'ie-browser-fast', false, null, false, null],
            ['info.sunista.app', true, 'sanista-persian-instagram', false, null, false, null],
            ['com.instapro.app', true, 'insta-pro', false, null, false, null],
            ['com.kakao.talk', true, 'kakaotalk', false, null, false, null],
            ['acr.browser.linxy', true, 'vegas-browser', false, null, false, null],
            ['com.oh.bro', true, 'oh-browser', false, null, false, null],
            ['com.oh.brop', true, 'oh-private-browser', false, null, false, null],
            ['net.onecook.browser', true, 'stargon-browser', false, null, false, null],
            ['phx.hot.browser', true, 'anka-browser', false, null, false, null],
            ['org.torproject.android', true, 'orbot', false, null, false, null],
            ['web.browser.dragon', true, 'dragon-browser', false, null, false, null],
            ['org.easyweb.browser', true, 'easy-browser', false, null, false, null],
            ['com.sharkeeapp.browser', true, 'sharkee-browser', false, null, false, null],
            ['com.mobiu.browser', true, 'lark-browser', false, null, false, null],
            ['com.qflair.browserq', true, 'pluma-browser', false, null, false, null],
            ['com.noxgroup.app.browser', true, 'nox-browser', false, null, false, null],
            ['com.jio.web', true, 'jio-sphere', false, null, false, null],
            ['com.cookiegames.smartcookie', true, 'smartcookieweb-privacy-browser', false, null, false, null],
            ['org.lineageos.jelly', true, 'jelly-browser', false, null, true, 'lineageos'],
            ['com.oceanhero.search', true, 'ocean-hero-app', false, null, false, null],
            ['com.oryon.multitasking', true, 'multitasking-app', false, null, false, null],
            ['net.fast.web.browser', true, 'web-browser-web-explorer', false, null, false, null],
            ['com.bestvideodownloader.newvideodownloader', true, 'all-video-downloader', false, null, false, null],
            ['com.yiyinkuang.searchboard', true, 'search+-for-google', false, null, false, null],
            ['com.aeroinsta.android', true, 'aero-insta', false, null, false, null],
            ['com.cliqz.browser', true, 'cliqz-browser', false, null, false, null],
            ['com.appssppa.idesktoppcbrowser', true, 'idesktop-pc-browser', false, null, false, null],
            ['com.sec.app.samsungprintservice', true, 'samsung-print-service-plugin', false, null, false, null],
            ['jp.co.canon.bsd.ad.pixmaprint', true, 'canon-print', false, null, false, null],
            ['com.gl9.cloudBrowser', true, 'surfbrowser', false, null, false, null],
            ['com.kaweapp.webexplorer', true, 'web-explorer', false, null, false, null],
            ['com.snaptube.premium', true, 'snap-tube', false, null, false, null],
            ['com.eagle.web.browser.internet.privacy.browser', true, 'private-browser-web-browser', false, null, false, null],
            ['com.cleanmaster.security', true, 'cm-security', false, null, false, null],
            ['devian.tubemate.v3', true, 'tube-mate', false, null, false, null],
            ['de.einsundeins.searchapp.gmx.com', true, 'gmx-search', false, null, false, null],
            ['acr.browser.lightning', true, 'lightning-browser', false, null, false, null],
            ['acr.browser.lightning2', true, 'lightning-browser', false, null, false, null],
            ['acr.browser.lightningq16w', true, 'lightning-browser', false, null, false, null],
            ['com.web_view_mohammed.ad.webview_app', true, 'appso', false, null, false, null],
            ['com.fsecure.ms.netcologne', true, 'sicherheitspaket', false, null, false, null],
            ['de.telekom.mail', true, 'telekom-mail', false, null, false, null],
            ['ai.blokee.browser.android', true, 'bloket-browser', false, null, false, null],
            ['com.ume.browser.euas', true, 'ume-browser', false, null, false, null],
            ['com.ume.browser.bose', true, 'ume-browser', false, null, false, null],
            ['com.ume.browser.international', true, 'ume-browser', false, null, false, null],
            ['com.ume.browser.latinamerican', true, 'ume-browser', false, null, false, null],
            ['com.ume.browser.mexicotelcel', true, 'ume-browser', false, null, false, null],
            ['com.ume.browser.venezuelavtelca', true, 'ume-browser', false, null, false, null],
            ['com.ume.browser.northamerica', true, 'ume-browser', false, null, false, null],
            ['com.ume.browser.newage', true, 'ume-browser', false, null, false, null],
            ['com.wolvesinteractive.racinggo', true, 'racing-go', false, null, false, null],
            ['com.microsoft.amp.apps.bingnews', true, 'microsoft-start', false, null, false, null],
            ['com.litepure.browser.gp', true, 'pure-browser', false, null, false, null],
            ['com.boatbrowser.free', true, 'boat-browser', false, null, false, null],
            ['com.brother.mfc.brprint', true, 'brother-iprint-scan', false, null, false, null],
            ['com.emoticon.screen.home.launcher', true, 'in-launcher', false, null, false, null],
            ['com.explore.web.browser', true, 'web-browser-explorer', false, null, false, null],
            ['com.emporia.browser', true, 'emporia-app', false, null, false, null],
            ['de.telekom.epub', true, 'pageplace-reader', false, null, false, null],
            ['com.appsverse.photon', true, 'photon-browser', false, null, false, null],
            ['com.dolphin.browser.zero', true, 'dolfin-zero', false, null, false, null],
            ['com.stoutner.privacybrowser.standard', true, 'stoutner-privacy-browser', false, null, false, null],
            ['com.skype.raider', true, 'skype', false, null, false, null],
            ['de.gdata.mobilesecurity2b', true, 'tie-team-mobile-security', false, null, false, null],
            ['de.freenet.mail', true, 'freenet-mail', false, null, false, null],
            ['com.transsion.phoenix', true, 'phoenix browser', false, null, false, null],
            ['com.startpage', true, 'startpage-private-search-engine', false, null, false, null],
            ['jp.hazuki.yuzubrowser', true, 'yuzu-browser', false, null, false, null],
            ['net.dezor.browser', true, 'dezor-browser', false, null, false, null],
            ['com.go.browser', true, 'go-browser', false, null, false, null],
            ['com.dv.adm', true, 'advanced-download-manager', false, null, false, null],
            ['com.androidbull.incognito.browser', true, 'incognito-browser', false, null, false, null],
            ['com.symantec.mobile.idsafe', true, 'norton-password-manager', false, null, false, null],
            ['com.lge.snappage', true, 'snap-page', false, null, false, null],
            ['com.morrisxar.nav88', true, 'office-browser', false, null, false, null],
            ['epson.print', true, 'epson-iprint', false, null, false, null],
            ['miada.tv.webbrowser', true, 'internet-web-browser', false, null, false, null],
            ['threads.thor', true, 'thor-browser', false, null, false, null],
            ['com.opera.browser', true, 'opera', false, null, false, null],
            ['com.opera.browser.afin', true, 'opera', false, null, false, null],
            ['com.startpage.mobile', true, 'startpage-private-search-engine', false, null, false, null],
            ['ace.avd.tube.video.downloader', true, 'free-video-downloader-pro', false, null, false, null],
            ['com.catdaddy.cat22', true, 'wwe-supercard', false, null, false, null],
            ['com.jlwf.droid.tutu', true, 'tutu-app', false, null, false, null],
            ['com.tct.launcher', true, 'joy-launcher', false, null, false, null],
            ['com.baidu.searchbox', true, 'baidu box app', false, null, false, null],
            ['de.eue.mobile.android.mail', true, 'einsundeins-mail', false, null, false, null],
            ['com.wfeng.droid.tutu', true, 'tutu-app', false, null, false, null],
            ['com.honor.global', true, 'honor-store', false, null, false, null],
            ['com.finimize.oban', true, 'finimize', false, null, false, null],
            ['com.myhomescreen.weather', true, 'weather-home', false, null, false, null],
            ['hot.fiery.browser', true, 'fiery-browser', false, null, false, null],
            ['de.gmx.mobile.android.mail', true, 'gmx-mail', false, null, false, null],
            ['de.twokit.castbrowser', true, 'tv-cast', false, null, false, null],
            ['de.twokit.castbrowser.pro', true, 'tv-cast-pro', false, null, false, null],
            ['com.esaba.downloader', true, 'downloader', false, null, false, null],
            ['com.agilebits.onepassword', true, '1password', false, null, false, null],
            ['com.browser2345_ucc', true, '2345 browser', false, null, false, null],
            ['com.browser2345hd', true, '2345-browser-hd', false, null, false, null],
            ['air.stage.web.view', true, 'adobe air', false, null, false, null],
            ['air.stagewebview', true, 'adobe air', false, null, false, null],
            ['air.StageWebViewBridgeTest.debug', true, 'adobe air', false, null, false, null],
            ['air.StageWebViewVideo.debug', true, 'adobe air', false, null, false, null],
            ['com.adobe.phonegap.app', true, 'adobe-phonegap', false, null, false, null],
            ['com.adobe.reader', true, 'adobe-reader', false, null, false, null],
            ['com.doro.apps.browser', true, 'doro-browser', false, null, false, null],
            ['de.einsundeins.searchapp.web', true, 'web.de-search', false, null, false, null],
            ['com.droidlogic.mboxlauncher', true, 'mbox-launcher', false, null, false, null],
            ['com.droidlogic.xlauncher', true, 'x-launcher', false, null, false, null],
            ['com.baidu.browser.apps', true, 'baidu browser', false, null, false, null],
            ['com.hihonor.baidu.browser', true, 'honor-browser', false, null, false, null],
            ['com.baidu.searchbox.lite', true, 'baidu box app lite', false, null, false, null],
            ['com.microsoft.copilot', true, 'microsoft-copilot', false, null, false, null],
            ['de.web.mobile.android.mail', true, 'web.de mail', false, null, false, null],
            ['com.readly.client', true, 'readly-app', false, null, false, null],
            ['com.gbox.android.helper', true, 'gbox-helper', false, null, false, null],
            ['com.samsung.android.email.provider', true, 'samsung-email', false, null, false, null],
            ['it.italiaonline.mail', true, 'libero-mail', false, null, false, null],
            ['webexplorer.amazing.speed', true, 'web-browser-explorer', false, null, false, null],
            ['nu.tommie.inbrowser', true, 'in-browser', false, null, false, null],
            ['com.massimple.nacion.gcba.es', true, 'plus-simple-browser', false, null, false, null],
            ['com.massimple.nacion.parana.es', true, 'plus-simple-browser', false, null, false, null],
            ['every.browser.inc', true, 'every-browser', false, null, false, null],
            ['com.til.timesnews', true, 'news-point', false, null, false, null],
            ['com.omshyapps.vpn', true, 'omshy-vpn', false, null, false, null],
            ['com.sharekaro.app', true, 'sharekaro', false, null, false, null],
            ['com.transsion.itel.launcher', true, 'itel-os-launcher', false, null, false, null],
            ['com.cleanmaster.mguard', true, 'clean-master', false, null, false, null],
            ['com.cleanmaster.mguard.huawei', true, 'clean-master', false, null, false, null],
            ['com.larus.wolf', true, 'cici', false, null, false, null],
            ['com.kuto.vpn', true, 'kuto-vpn', false, null, false, null],
            ['com.microsoft.math', true, 'microsoft-math', false, null, false, null],
            ['com.google.android.apps.maps', true, 'google-maps', false, null, false, null],
            ['com.phlox.tvwebbrowser', true, 'tv-bro', false, null, false, null],
            ['com.transsion.XOSLauncher', true, 'xos-launcher', false, null, false, null],
            ['com.infinix.xshare', true, 'xshare', false, null, false, null],
            ['com.xshare.sharefiles1', true, 'xshare', false, null, false, null],
            ['com.transsion.magicshow', true, 'visha', false, null, false, null],
            ['com.awesapp.isp', true, 'isafeplay', false, null, false, null],
            ['com.anydesk.anydeskandroid', true, 'anydesk-remote-desktop', false, null, false, null],
            ['com.palmteam.imagesearch', true, 'search-by-image', false, null, false, null],
            ['castify.roku', true, 'cast-web-videos', false, null, false, null],
            ['za.co.tracker.consumer', true, 'tracker-connect', false, null, false, null],
            ['nu.bi.moya', true, 'moyaapp', false, null, false, null],
            ['com.tradron.hdvideodownloader', true, 'download-hub', false, null, false, null],
            ['com.box.video.downloader', true, 'box-video-downloader', false, null, false, null],
            ['com.sec.android.app.sbrowser', true, 'samsungbrowser', false, null, false, null],
            ['com.opera.mini.native.beta', true, 'opera mini beta', false, null, false, null],
            ['com.yandex.browser', true, 'yabrowser', false, null, false, null],
            ['org.mozilla.firefox', true, 'firefox', false, null, false, null],
            ['com.tv.browser.open', true, 'open-tv-browser', false, null, false, null],
            ['com.logicui.tvbrowser2', true, 'logicui-tv-browser', false, null, false, null],
            ['com.internet.tvbrowser', true, 'browser-app-browser', false, null, false, null],
            ['com.sweep.cleaner.trash.junk', true, 'sweep-cleaner', false, null, false, null],
            ['com.flatfish.cal.privacy', true, 'hidex-calculator-photo-vault', false, null, false, null],
            ['com.myhomescreen.news', true, 'news-home', false, null, false, null],
            ['com.myhomescreen.fitness', true, 'fit-home', false, null, false, null],
            ['com.fsecure.ms.talktalksa', true, 'talktalk-supersafe', false, null, false, null],
            ['com.fsecure.ms.actshield', true, 'act-shield', false, null, false, null],
            ['com.fsecure.ms.kpn.veilig', true, 'veilig-virusscanner', false, null, false, null],
            ['com.twitter.android', true, 'twitter app', false, null, false, null],
            ['com.seraphic.openinet.pre', true, 'metax-open-browser', false, null, false, null],
            ['org.telegram.messenger.web', true, 'telegram-app', false, null, false, null],
            ['com.android.media.module.services', true, 'mediaservices-apk', false, null, false, null],
            ['mojeek.app', true, 'mojeek-app', false, null, false, null],
            ['com.castify', true, 'cast-to-tv-plus', false, null, false, null],
            ['com.stickypassword.android', true, 'sticky-password', false, null, false, null],
            ['com.qihoo.security', true, '360-security', false, null, false, null],
            ['com.nytimes.crossword', true, 'nytimes-crossword', false, null, false, null],
            ['com.aospstudio.tvsearch', true, 'neptune-tv-browser', false, null, false, null],
            ['com.playit.videoplayer', true, 'play-it', false, null, false, null],
            ['com.repotools.whatplay', true, 'what-play', false, null, false, null],
            ['com.instabridge.android', true, 'insta-bridge', false, null, false, null],
            ['com.antivirus.master.cmsecurity', true, 'cm-security', false, null, false, null],
            ['com.nocardteam.nocardvpn.lite', true, 'no-card-lite', false, null, false, null],
            ['com.nocardteam.nocardvpn', true, 'no-card', false, null, false, null],
            ['com.ezt.vpn', true, 'ez-vpn', false, null, false, null],
            ['net.daum.android.daum', true, 'daum-app', false, null, false, null],
            ['com.fsecure.ms.sonera', true, 'telia-turvapaketti', false, null, false, null],
            ['com.fsecure.ms.sfr', true, 'sfr-securite', false, null, false, null],
            ['com.fsecure.ms.upc.ch', true, 'upc-internet-security', false, null, false, null],
            ['com.fsecure.ms.dnafi', true, 'dna-digiturva', false, null, false, null],
            ['com.nate.android.portalmini', true, 'nate-app', false, null, false, null],
            ['com.bigqsys.photosearch.searchbyimage2020', true, 'photo-search-app', false, null, false, null],
            ['com.qjy.browser', true, 'qjy-tv-browser', false, null, false, null],
            ['com.myhomescreen.messenger.home.emoji.lite', true, 'messenger-lite', false, null, false, null],
            ['com.myhomescreen.access', true, 'big-keyboard', false, null, false, null],
            ['com.myhomescreen.email', true, 'email-home', false, null, false, null],
            ['com.myhomescreen.sms', true, 'messenger-home', false, null, false, null],
            ['io.bluewallet.bluewallet', true, 'blue-wallet', false, null, false, null],
            ['com.bifrostwallet.app', true, 'bifrost-wallet', false, null, false, null],
            ['com.tt.android.dm.view', true, 'download-manager', false, null, false, null],
            ['com.wukongtv.wkcast.intl', true, 'quick-cast-app', false, null, false, null],
            ['mobi.deallauncher.coupons.shopping', true, 'coupons-promo-codes', false, null, false, null],
            ['idm.video.free', true, 'idm-video-download-manager', false, null, false, null],
            ['de.twokit.video.tv.cast.browser.samsung', true, 'tv-cast', false, null, false, null],
            ['de.twokit.video.tv.cast.browser.lg', true, 'tv-cast', false, null, false, null],
            ['de.twokit.video.tv.cast.browser.firetv', true, 'tv-cast', false, null, false, null],
            ['de.twokit.castbrowsernexusplayer', true, 'tv-cast', false, null, false, null],
            ['com.tuya.smartlife', true, 'smart-life', false, null, false, null],
            ['com.waze', true, 'waze-navigation', false, null, false, null],
            ['com.transsion.hilauncher', true, 'hios-launcher', false, null, false, null],
            ['com.opera.app.news', true, 'opera news', false, null, false, null],
            ['com.reddit.frontpage', true, 'reddit-app', false, null, false, null],
            ['com.harshad.someto', true, 'social-media-explorer', false, null, false, null],
            ['com.tcl.live', true, 'tcl-live', false, null, false, null],
            ['com.thinkfree.searchbyimage', true, 'reverse-image-search', false, null, false, null],
            ['hippeis.com.photochecker', true, 'photo-sherlock', false, null, false, null],
            ['hesoft.T2S', true, 't2s-app', false, null, false, null],
            ['com.zeebusiness.news', true, 'zee-business', false, null, false, null],
            ['com.netflix.mediaclient', true, 'netflix-app', false, null, false, null],
            ['com.oxoo.kinogo', true, 'kinogo.ge', false, null, false, null],
            ['ir.ilmili.telegraph', true, 'graph-messenger', false, null, false, null],
            ['the.best.gram', true, 'bestgram', false, null, false, null],
            ['org.aka.lite', true, 'aka-lite', false, null, false, null],
            ['org.aka.messenger', true, 'aka', false, null, false, null],
            ['com.saf.seca', true, 'search-craft', false, null, false, null],
            ['com.fsecure.ms.teliasweden', true, 'telia-trygg', false, null, false, null],
            ['com.gener8ads.wallet', true, 'gener8-browser', false, null, false, null],
            ['com.jambo', true, 'jambo', false, null, false, null],
            ['no.wifi.offline.games.puzzle.games', true, 'offline all in one', false, null, false, null],
            ['webexplorer.amazing.biro', true, 'internet-browser', false, null, false, null],
            ['com.xbh.universal.player', true, 'universal-player', false, null, false, null],
            ['com.mobile.applock.wt', true, 'app-lock', false, null, false, null],
            ['com.solide.filemanager.lte', true, 'solid-file-manager', false, null, false, null],
            ['com.lechneralexander.privatebrowser', true, 'private-internet-browser', false, null, false, null],
            ['com.moonshot.kimichat', true, 'kimi-app', false, null, false, null],
            ['com.deepseek.chat', true, 'deepseek-app', false, null, false, null],
            ['com.chainapsis.keplr', true, 'keplr-app', false, null, false, null],
            ['com.viber.voip', true, 'viber-app', false, null, false, null],
            ['com.fsecure.ms.voo', true, 'vis+ app', false, null, false, null],
            ['com.fsecure.ms.fnac', true, 'ma protection app', false, null, false, null],
            ['com.wecloud.lookr', true, 'lookr-app', false, null, false, null],
            ['com.canopy.vpn.filter.parent', true, 'canopy-app', false, null, false, null],
            ['ai.mainfunc.genspark', true, 'genspark-app', false, null, false, null],
        ];
    }
}
