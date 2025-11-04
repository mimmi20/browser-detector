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
use BrowserDetector\Version\ForcedNullVersion;
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
                ForcedNullVersion::class,
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
            ['com.browser2345', true, '2345 browser', true, null, false, null],
            ['this.is.a.fake.id.to.test.unknown.ids', false, null, false, null, false, null],
            ['me.android.browser', true, 'me browser', true, null, false, null],
            ['com.android.browser', true, 'android webview', true, null, false, null],
            ['com.mx.browser', true, 'maxthon', true, null, false, null],
            ['mobi.mgeek.TunnyBrowser', true, 'dolfin', true, null, false, null],
            ['com.tencent.mm', true, 'wechat app', true, null, false, null],
            ['com.asus.browser', true, 'asus browser', true, null, false, null],
            ['com.UCMobile.lab', true, 'ucbrowser', true, null, false, null],
            ['com.oupeng.browser', true, 'oupeng browser', true, null, false, null],
            ['com.lenovo.browser', true, 'lenovo browser', true, null, false, null],
            ['derek.iSurf', true, 'isurf', true, null, false, null],
            ['com.aliyun.mobile.browser', true, 'aliyun-browser', true, null, false, null],
            ['XMLHttpRequest', false, null, false, null, false, null],
            ['com.tinyspeck.chatlyio', true, 'chatlyio app', true, null, false, null],
            ['com.douban.group', true, 'douban app', true, null, false, null],
            ['com.linkedin', true, 'linkedinbot', true, null, false, null],
            ['com.google.android.apps.magazines', true, 'google play newsstand', true, null, false, null],
            ['com.google.googlemobile', true, 'google mobile app', true, null, false, null],
            ['com.google.android.youtube', true, 'youtube app', true, null, false, null],
            ['com.apple.mobilenotes', true, 'apple mobilenotes', true, null, false, null],
            ['com.apple.notes', true, 'apple notes app', true, null, false, null],
            ['com.google.googleplus', true, 'google+ app', true, null, false, null],
            ['com.apple.webkit', true, 'apple webkit service', true, null, false, null],
            ['com.duckduckgo.mobile.android', true, 'duckduck app', true, null, false, null],
            ['com.opera.mini.native', true, 'opera mini', true, null, false, null],
            ['com.google.android.apps.searchlite', true, 'google search lite', true, null, false, null],
            ['com.facebook.katana', true, 'facebook app', true, null, false, null],
            ['com.huawei.browser', true, 'huawei-browser', true, null, false, null],
            ['com.huawei.search', true, 'hi-search', true, null, false, null],
            ['com.microsoft.bing', true, 'bingsearch', true, null, false, null],
            ['com.microsoft.office.outlook', true, 'outlook', true, null, false, null],
            ['com.opera.gx', true, 'opera gx', true, null, false, null],
            ['com.ksmobile.cb', true, 'cm browser', true, null, false, null],
            ['com.android.chrome', true, 'chrome', true, null, false, null],
            ['com.facebook.orca', true, 'facebook messenger app', true, null, false, null],
            ['jp.co.yahoo.android.yjtop', true, 'yahoo! app', true, null, false, null],
            ['com.instagram.android', true, 'instagram app', true, null, false, null],
            ['com.microsoft.bingintl', true, 'bingsearch', true, null, false, null],
            ['com.nhn.android.search', true, 'naver', true, null, false, null],
            ['com.sina.weibo', true, 'weibo app', true, null, false, null],
            ['com.opera.touch', true, 'opera touch', true, null, false, null],
            ['org.mozilla.klar', true, 'firefox klar', true, null, false, null],
            ['jp.co.fenrir.android.sleipnir', true, 'sleipnir', true, null, false, null],
            ['de.gdata.mobilesecurityorange', true, 'g-data mobile security', true, null, false, null],
            ['com.active.cleaner', true, 'active-cleaner', true, null, false, null],
            ['com.aol.mobile.aolapp', true, 'aol-app', true, null, false, null],
            ['com.appsinnova.android.keepclean', true, 'keep-clean', true, null, false, null],
            ['com.ayoba.ayoba', true, 'ayoba-app', true, null, false, null],
            ['com.cmcm.armorfly', true, 'armorfly-browser', true, null, false, null],
            ['com.emporia.emporiaapprebuild', true, 'emporia-app', true, null, false, null],
            ['com.espn.score_center', true, 'espn-app', true, null, false, null],
            ['com.fancyclean.security.antivirus', true, 'fancy-security', true, null, false, null],
            ['com.fsecure.ms.buhldata', true, 'wiso-internet-security', true, null, false, null],
            ['com.fsecure.ms.darty', true, 'darty-securite', true, null, false, null],
            ['com.fsecure.ms.dc', true, 'f-secure mobile security', true, null, false, null],
            ['com.fsecure.ms.nifty', true, 'always safe security 24', true, null, false, null],
            ['com.fsecure.ms.safe', true, 'f-secure safe', true, null, false, null],
            ['com.fsecure.ms.saunalahti_m', true, 'elisa-turvapaketti', true, null, false, null],
            ['com.fsecure.ms.swisscom.sa', true, 'swisscom-internet-security', true, null, false, null],
            ['com.fsecure.ms.ziggo', true, 'ziggo-safe-online', true, null, false, null],
            ['com.google.android.gms', true, 'google-play-services', true, null, false, null],
            ['com.hld.anzenbokusu', true, 's-gallery', true, null, false, null],
            ['com.hld.anzenbokusucal', true, 'calculator-photo', true, null, false, null],
            ['com.hld.anzenbokusufake', true, 'calculator-hide', true, null, false, null],
            ['com.hornet.android', true, 'hornet', true, null, false, null],
            ['com.huawei.appmarket', true, 'huawei-app-gallery', true, null, false, null],
            ['com.huawei.fastapp', true, 'huawei-quick-app-center', true, null, false, null],
            ['com.huawei.hwsearch', true, 'huawei-petal-search', true, null, false, null],
            ['com.amazon.webapps.gms.search', true, 'google-search', true, null, false, null],
            ['com.andrewshu.android.reddit', true, 'reddit-is-fun', true, null, false, null],
            ['com.andrewshu.android.redditdonation', true, 'reddit-is-fun', true, null, false, null],
            ['com.jaumo', true, 'jaumo', true, null, false, null],
            ['com.jaumo.prime', true, 'jaumo-prime', true, null, false, null],
            ['com.jb.security', true, 'go-security', true, null, false, null],
            ['com.lenovo.anyshare.gps', true, 'share-it', true, null, false, null],
            ['com.michatapp.im', true, 'mi-chat-app', true, null, false, null],
            ['com.michatapp.im.lite', true, 'mi-chat-lite', true, null, false, null],
            ['com.noxgroup.app.security', true, 'nox-security', true, null, false, null],
            ['com.rcplatform.livechat', true, 'tumile', true, null, false, null],
            ['com.rs.explorer.filemanager', true, 'rs-file', true, null, false, null],
            ['com.skout.android', true, 'skout', true, null, false, null],
            ['com.sony.nfx.app.sfrc', true, 'news-suite-by-sony', true, null, false, null],
            ['com.surfshark.vpnclient.android', true, 'surfshark-app', true, null, false, null],
            ['com.swisscows.search', true, 'swisscows-private-search', true, null, false, null],
            ['com.tinder', true, 'tinder-app', true, null, false, null],
            ['com.totalav.android', true, 'total-av-mobile-security', true, null, false, null],
            ['com.turtc', true, 'türkiye-milli-arama-motoru', true, null, false, null],
            ['mark.via.gp', true, 'via-browser', true, null, false, null],
            ['com.kiwibrowser.browser', true, 'kiwi', true, null, false, null],
            ['com.brave.browser', true, 'brave', true, null, false, null],
            ['org.mozilla.focus', true, 'firefox focus', true, null, false, null],
            ['com.vivaldi.browser', true, 'vivaldi', true, null, false, null],
            ['com.aloha.browser', true, 'aloha-browser', true, null, false, null],
            ['com.cloudmosa.puffinFree', true, 'puffin', true, null, false, null],
            ['com.ucmobile.intl', true, 'ucbrowser', true, null, false, null],
            ['com.tvwebbrowser.v22', true, 'tv-browser-internet', true, null, false, null],
            ['com.udicorn.proxy', true, 'blue-proxy', true, null, false, null],
            ['com.ume.browser.cust', true, 'ume-browser', true, null, false, null],
            ['com.v2.vpn.security.free', true, 'fast-unlimited-vpn', true, null, false, null],
            ['com.videochat.livu', true, 'livu-app', true, null, false, null],
            ['com.wiseplay', true, 'wiseplay', true, null, false, null],
            ['com.yahoo.onesearch', true, 'yahoo-onesearch', true, null, false, null],
            ['com.yy.hiyo', true, 'hago-app', true, null, false, null],
            ['de.baumann.browser', true, 'foss-browser', true, null, false, null],
            ['free.vpn.unblock.proxy.vpnmonster', true, 'vpn-monster', true, null, false, null],
            ['io.metamask', true, 'meta-mask', true, null, false, null],
            ['it.ideasolutions.kyms', true, 'kyms', true, null, false, null],
            ['it.tolelab.fvd', true, 'free-video-downloader', true, null, false, null],
            ['com.snapchat.android', true, 'snapchat app', true, null, false, null],
            ['jp.gocro.smartnews.android', true, 'smart-news-app', true, null, false, null],
            ['kik.android', true, 'kik', true, null, false, null],
            ['com.hisense.odinbrowser', true, 'odin-browser', true, null, false, null],
            ['org.quantumbadger.redreader', true, 'red-reader', true, null, false, null],
            ['phone.cleaner.antivirus.speed.booster', true, 'phone-clean', true, null, false, null],
            ['reactivephone.msearch', true, 'smart-search-web-browser', true, null, false, null],
            ['secure.explorer.web.browser', true, 'browser lite', true, null, false, null],
            ['snapu2b.com', true, 'snapu2b', true, null, false, null],
            ['pi.browser', true, 'pi browser', true, null, false, null],
            ['alohabrowser', true, 'aloha-browser', true, null, false, null],
            ['org.telegram.messenger', true, 'telegram-app', true, null, false, null],
            ['xbrowser', true, 'x-browser', true, null, false, null],
            ['com.xbrowser.play', true, 'x-browser', true, null, false, null],
            ['com.mycompany.app.soulbrowser', true, 'soul-browser', true, null, false, null],
            ['com.sec.android.app.sbrowser.lite', true, 'samsung-browser-lite', true, null, false, null],
            ['jp.ddo.pigsty.HabitBrowser', true, 'habit-browser', true, null, false, null],
            ['com.mi.globalbrowser.mini', true, 'mint browser', true, null, false, null],
            ['me.webalert', true, 'web-alert-app', true, null, false, null],
            ['com.pure.mini.browser', true, 'mini-web-browser', true, null, false, null],
            ['acr.browser.raisebrowserfull', true, 'raise-fast-browser', true, null, false, null],
            ['com.Fast.BrowserUc.lite', true, 'fast-browser-uc-lite', true, null, false, null],
            ['acr.browser.barebones', true, 'lightning-browser', true, null, false, null],
            ['anar.app.darkweb', true, 'dark-web-browser', true, null, false, null],
            ['com.cake.browser', true, 'cake-browser', true, null, false, null],
            ['com.iebrowser.fast', true, 'ie-browser-fast', true, null, false, null],
            ['info.sunista.app', true, 'sanista-persian-instagram', true, null, false, null],
            ['com.instapro.app', true, 'insta-pro', true, null, false, null],
            ['com.kakao.talk', true, 'kakaotalk', true, null, false, null],
            ['acr.browser.linxy', true, 'vegas-browser', true, null, false, null],
            ['com.oh.bro', true, 'oh-browser', true, null, false, null],
            ['com.oh.brop', true, 'oh-private-browser', true, null, false, null],
            ['net.onecook.browser', true, 'stargon-browser', true, null, false, null],
            ['phx.hot.browser', true, 'anka-browser', true, null, false, null],
            ['org.torproject.android', true, 'orbot', true, null, false, null],
            ['web.browser.dragon', true, 'dragon-browser', true, null, false, null],
            ['org.easyweb.browser', true, 'easy-browser', true, null, false, null],
            ['com.sharkeeapp.browser', true, 'sharkee-browser', true, null, false, null],
            ['com.mobiu.browser', true, 'lark-browser', true, null, false, null],
            ['com.qflair.browserq', true, 'pluma-browser', true, null, false, null],
            ['com.noxgroup.app.browser', true, 'nox-browser', true, null, false, null],
            ['com.jio.web', true, 'jio-sphere', true, null, false, null],
            ['com.cookiegames.smartcookie', true, 'smartcookieweb-privacy-browser', true, null, false, null],
            ['org.lineageos.jelly', true, 'jelly-browser', true, null, true, 'lineageos'],
            ['com.oceanhero.search', true, 'ocean-hero-app', true, null, false, null],
            ['com.oryon.multitasking', true, 'multitasking-app', true, null, false, null],
            ['net.fast.web.browser', true, 'web-browser-web-explorer', true, null, false, null],
            ['com.bestvideodownloader.newvideodownloader', true, 'all-video-downloader', true, null, false, null],
            ['com.yiyinkuang.searchboard', true, 'search+-for-google', true, null, false, null],
            ['com.aeroinsta.android', true, 'aero-insta', true, null, false, null],
            ['com.cliqz.browser', true, 'cliqz-browser', true, null, false, null],
            ['com.appssppa.idesktoppcbrowser', true, 'idesktop-pc-browser', true, null, false, null],
            ['com.sec.app.samsungprintservice', true, 'samsung-print-service-plugin', true, null, false, null],
            ['jp.co.canon.bsd.ad.pixmaprint', true, 'canon-print', true, null, false, null],
            ['com.gl9.cloudBrowser', true, 'surfbrowser', true, null, false, null],
            ['com.kaweapp.webexplorer', true, 'web-explorer', true, null, false, null],
            ['com.snaptube.premium', true, 'snap-tube', true, null, false, null],
            ['com.eagle.web.browser.internet.privacy.browser', true, 'private-browser-web-browser', true, null, false, null],
            ['com.cleanmaster.security', true, 'cm-security', true, null, false, null],
            ['devian.tubemate.v3', true, 'tube-mate', true, null, false, null],
            ['de.einsundeins.searchapp.gmx.com', true, 'gmx-search', true, null, false, null],
            ['acr.browser.lightning', true, 'lightning-browser', true, null, false, null],
            ['acr.browser.lightning2', true, 'lightning-browser', true, null, false, null],
            ['acr.browser.lightningq16w', true, 'lightning-browser', true, null, false, null],
            ['com.web_view_mohammed.ad.webview_app', true, 'appso', true, null, false, null],
            ['com.fsecure.ms.netcologne', true, 'sicherheitspaket', true, null, false, null],
            ['de.telekom.mail', true, 'telekom-mail', true, null, false, null],
            ['ai.blokee.browser.android', true, 'bloket-browser', true, null, false, null],
            ['com.ume.browser.euas', true, 'ume-browser', true, null, false, null],
            ['com.ume.browser.bose', true, 'ume-browser', true, null, false, null],
            ['com.ume.browser.international', true, 'ume-browser', true, null, false, null],
            ['com.ume.browser.latinamerican', true, 'ume-browser', true, null, false, null],
            ['com.ume.browser.mexicotelcel', true, 'ume-browser', true, null, false, null],
            ['com.ume.browser.venezuelavtelca', true, 'ume-browser', true, null, false, null],
            ['com.ume.browser.northamerica', true, 'ume-browser', true, null, false, null],
            ['com.ume.browser.newage', true, 'ume-browser', true, null, false, null],
            ['com.wolvesinteractive.racinggo', true, 'racing-go', true, null, false, null],
            ['com.microsoft.amp.apps.bingnews', true, 'microsoft-start', true, null, false, null],
            ['com.litepure.browser.gp', true, 'pure-browser', true, null, false, null],
            ['com.boatbrowser.free', true, 'boat-browser', true, null, false, null],
            ['com.brother.mfc.brprint', true, 'brother-iprint-scan', true, null, false, null],
            ['com.emoticon.screen.home.launcher', true, 'in-launcher', true, null, false, null],
            ['com.explore.web.browser', true, 'web-browser-explorer', true, null, false, null],
            ['com.emporia.browser', true, 'emporia-app', true, null, false, null],
            ['de.telekom.epub', true, 'pageplace-reader', true, null, false, null],
            ['com.appsverse.photon', true, 'photon-browser', true, null, false, null],
            ['com.dolphin.browser.zero', true, 'dolfin-zero', true, null, false, null],
            ['com.stoutner.privacybrowser.standard', true, 'stoutner-privacy-browser', true, null, false, null],
            ['com.skype.raider', true, 'skype', true, null, false, null],
            ['de.gdata.mobilesecurity2b', true, 'tie-team-mobile-security', true, null, false, null],
            ['de.freenet.mail', true, 'freenet-mail', true, null, false, null],
            ['com.transsion.phoenix', true, 'phoenix browser', true, null, false, null],
            ['com.startpage', true, 'startpage-private-search-engine', true, null, false, null],
            ['jp.hazuki.yuzubrowser', true, 'yuzu-browser', true, null, false, null],
            ['net.dezor.browser', true, 'dezor-browser', true, null, false, null],
            ['com.go.browser', true, 'go-browser', true, null, false, null],
            ['com.dv.adm', true, 'advanced-download-manager', true, null, false, null],
            ['com.androidbull.incognito.browser', true, 'incognito-browser', true, null, false, null],
            ['com.symantec.mobile.idsafe', true, 'norton-password-manager', true, null, false, null],
            ['com.lge.snappage', true, 'snap-page', true, null, false, null],
            ['com.morrisxar.nav88', true, 'office-browser', true, null, false, null],
            ['epson.print', true, 'epson-iprint', true, null, false, null],
            ['miada.tv.webbrowser', true, 'internet-web-browser', true, null, false, null],
            ['threads.thor', true, 'thor-browser', true, null, false, null],
            ['com.opera.browser', true, 'opera', true, null, false, null],
            ['com.opera.browser.afin', true, 'opera', true, null, false, null],
            ['com.startpage.mobile', true, 'startpage-private-search-engine', true, null, false, null],
            ['ace.avd.tube.video.downloader', true, 'free-video-downloader-pro', true, null, false, null],
            ['com.catdaddy.cat22', true, 'wwe-supercard', true, null, false, null],
            ['com.jlwf.droid.tutu', true, 'tutu-app', true, null, false, null],
            ['com.tct.launcher', true, 'joy-launcher', true, null, false, null],
            ['com.baidu.searchbox', true, 'baidu box app', true, null, false, null],
            ['de.eue.mobile.android.mail', true, 'einsundeins-mail', true, null, false, null],
            ['com.wfeng.droid.tutu', true, 'tutu-app', true, null, false, null],
            ['com.honor.global', true, 'honor-store', true, null, false, null],
            ['com.finimize.oban', true, 'finimize', true, null, false, null],
            ['com.myhomescreen.weather', true, 'weather-home', true, null, false, null],
            ['hot.fiery.browser', true, 'fiery-browser', true, null, false, null],
            ['de.gmx.mobile.android.mail', true, 'gmx-mail', true, null, false, null],
            ['de.twokit.castbrowser', true, 'tv-cast', true, null, false, null],
            ['de.twokit.castbrowser.pro', true, 'tv-cast-pro', true, null, false, null],
            ['com.esaba.downloader', true, 'downloader', true, null, false, null],
            ['com.agilebits.onepassword', true, '1password', true, null, false, null],
            ['com.browser2345_ucc', true, '2345 browser', true, null, false, null],
            ['com.browser2345hd', true, '2345-browser-hd', true, null, false, null],
            ['air.stage.web.view', true, 'adobe air', true, null, false, null],
            ['air.stagewebview', true, 'adobe air', true, null, false, null],
            ['air.StageWebViewBridgeTest.debug', true, 'adobe air', true, null, false, null],
            ['air.StageWebViewVideo.debug', true, 'adobe air', true, null, false, null],
            ['com.adobe.phonegap.app', true, 'adobe-phonegap', true, null, false, null],
            ['com.adobe.reader', true, 'adobe-reader', true, null, false, null],
            ['com.doro.apps.browser', true, 'doro-browser', true, null, false, null],
            ['de.einsundeins.searchapp.web', true, 'web.de-search', true, null, false, null],
            ['com.droidlogic.mboxlauncher', true, 'mbox-launcher', true, null, false, null],
            ['com.droidlogic.xlauncher', true, 'x-launcher', true, null, false, null],
            ['com.baidu.browser.apps', true, 'baidu browser', true, null, false, null],
            ['com.hihonor.baidu.browser', true, 'honor-browser', true, null, false, null],
            ['com.baidu.searchbox.lite', true, 'baidu box app lite', true, null, false, null],
            ['com.microsoft.copilot', true, 'microsoft-copilot', true, null, false, null],
            ['de.web.mobile.android.mail', true, 'web.de mail', true, null, false, null],
            ['com.readly.client', true, 'readly-app', true, null, false, null],
            ['com.gbox.android.helper', true, 'gbox-helper', true, null, false, null],
            ['com.samsung.android.email.provider', true, 'samsung-email', true, null, false, null],
            ['it.italiaonline.mail', true, 'libero-mail', true, null, false, null],
            ['webexplorer.amazing.speed', true, 'web-browser-explorer', true, null, false, null],
            ['nu.tommie.inbrowser', true, 'in-browser', true, null, false, null],
            ['com.massimple.nacion.gcba.es', true, 'plus-simple-browser', true, null, false, null],
            ['com.massimple.nacion.parana.es', true, 'plus-simple-browser', true, null, false, null],
            ['every.browser.inc', true, 'every-browser', true, null, false, null],
            ['com.til.timesnews', true, 'news-point', true, null, false, null],
            ['com.omshyapps.vpn', true, 'omshy-vpn', true, null, false, null],
            ['com.sharekaro.app', true, 'sharekaro', true, null, false, null],
            ['com.transsion.itel.launcher', true, 'itel-os-launcher', true, null, false, null],
            ['com.cleanmaster.mguard', true, 'clean-master', true, null, false, null],
            ['com.cleanmaster.mguard.huawei', true, 'clean-master', true, null, false, null],
            ['com.larus.wolf', true, 'cici', true, null, false, null],
            ['com.kuto.vpn', true, 'kuto-vpn', true, null, false, null],
            ['com.microsoft.math', true, 'microsoft-math', true, null, false, null],
            ['com.google.android.apps.maps', true, 'google-maps', true, null, false, null],
            ['com.phlox.tvwebbrowser', true, 'tv-bro', true, null, false, null],
            ['com.transsion.XOSLauncher', true, 'xos-launcher', true, null, false, null],
            ['com.infinix.xshare', true, 'xshare', true, null, false, null],
            ['com.xshare.sharefiles1', true, 'xshare', true, null, false, null],
            ['com.transsion.magicshow', true, 'visha', true, null, false, null],
            ['com.awesapp.isp', true, 'isafeplay', true, null, false, null],
            ['com.anydesk.anydeskandroid', true, 'anydesk-remote-desktop', true, null, false, null],
            ['com.palmteam.imagesearch', true, 'search-by-image', true, null, false, null],
            ['castify.roku', true, 'cast-web-videos', true, null, false, null],
            ['za.co.tracker.consumer', true, 'tracker-connect', true, null, false, null],
            ['nu.bi.moya', true, 'moyaapp', true, null, false, null],
            ['com.tradron.hdvideodownloader', true, 'download-hub', true, null, false, null],
            ['com.box.video.downloader', true, 'box-video-downloader', true, null, false, null],
            ['com.sec.android.app.sbrowser', true, 'samsungbrowser', true, null, false, null],
            ['com.opera.mini.native.beta', true, 'opera mini beta', true, null, false, null],
            ['com.yandex.browser', true, 'yabrowser', true, null, false, null],
            ['org.mozilla.firefox', true, 'firefox', true, null, false, null],
            ['com.tv.browser.open', true, 'open-tv-browser', true, null, false, null],
            ['com.logicui.tvbrowser2', true, 'logicui-tv-browser', true, null, false, null],
            ['com.internet.tvbrowser', true, 'browser-app-browser', true, null, false, null],
            ['com.sweep.cleaner.trash.junk', true, 'sweep-cleaner', true, null, false, null],
            ['com.flatfish.cal.privacy', true, 'hidex-calculator-photo-vault', true, null, false, null],
            ['com.myhomescreen.news', true, 'news-home', true, null, false, null],
            ['com.myhomescreen.fitness', true, 'fit-home', true, null, false, null],
            ['com.fsecure.ms.talktalksa', true, 'talktalk-supersafe', true, null, false, null],
            ['com.fsecure.ms.actshield', true, 'act-shield', true, null, false, null],
            ['com.fsecure.ms.kpn.veilig', true, 'veilig-virusscanner', true, null, false, null],
            ['com.twitter.android', true, 'twitter app', true, null, false, null],
            ['com.seraphic.openinet.pre', true, 'metax-open-browser', true, null, false, null],
            ['org.telegram.messenger.web', true, 'telegram-app', true, null, false, null],
            ['com.android.media.module.services', true, 'mediaservices-apk', true, null, false, null],
            ['mojeek.app', true, 'mojeek-app', true, null, false, null],
            ['com.castify', true, 'cast-to-tv-plus', true, null, false, null],
            ['com.stickypassword.android', true, 'sticky-password', true, null, false, null],
            ['com.qihoo.security', true, '360-security', true, null, false, null],
            ['com.nytimes.crossword', true, 'nytimes-crossword', true, null, false, null],
            ['com.aospstudio.tvsearch', true, 'neptune-tv-browser', true, null, false, null],
            ['com.playit.videoplayer', true, 'play-it', true, null, false, null],
            ['com.repotools.whatplay', true, 'what-play', true, null, false, null],
            ['com.instabridge.android', true, 'insta-bridge', true, null, false, null],
            ['com.antivirus.master.cmsecurity', true, 'cm-security', true, null, false, null],
            ['com.nocardteam.nocardvpn.lite', true, 'no-card-lite', true, null, false, null],
            ['com.nocardteam.nocardvpn', true, 'no-card', true, null, false, null],
            ['com.ezt.vpn', true, 'ez-vpn', true, null, false, null],
            ['net.daum.android.daum', true, 'daum-app', true, null, false, null],
            ['com.fsecure.ms.sonera', true, 'telia-turvapaketti', true, null, false, null],
            ['com.fsecure.ms.sfr', true, 'sfr-securite', true, null, false, null],
            ['com.fsecure.ms.upc.ch', true, 'upc-internet-security', true, null, false, null],
            ['com.fsecure.ms.dnafi', true, 'dna-digiturva', true, null, false, null],
            ['com.nate.android.portalmini', true, 'nate-app', true, null, false, null],
            ['com.bigqsys.photosearch.searchbyimage2020', true, 'photo-search-app', true, null, false, null],
            ['com.qjy.browser', true, 'qjy-tv-browser', true, null, false, null],
            ['com.myhomescreen.messenger.home.emoji.lite', true, 'messenger-lite', true, null, false, null],
            ['com.myhomescreen.access', true, 'big-keyboard', true, null, false, null],
            ['com.myhomescreen.email', true, 'email-home', true, null, false, null],
            ['com.myhomescreen.sms', true, 'messenger-home', true, null, false, null],
            ['io.bluewallet.bluewallet', true, 'blue-wallet', true, null, false, null],
            ['com.bifrostwallet.app', true, 'bifrost-wallet', true, null, false, null],
            ['com.tt.android.dm.view', true, 'download-manager', true, null, false, null],
            ['com.wukongtv.wkcast.intl', true, 'quick-cast-app', true, null, false, null],
            ['mobi.deallauncher.coupons.shopping', true, 'coupons-promo-codes', true, null, false, null],
            ['idm.video.free', true, 'idm-video-download-manager', true, null, false, null],
            ['de.twokit.video.tv.cast.browser.samsung', true, 'tv-cast', true, null, false, null],
            ['de.twokit.video.tv.cast.browser.lg', true, 'tv-cast', true, null, false, null],
            ['de.twokit.video.tv.cast.browser.firetv', true, 'tv-cast', true, null, false, null],
            ['de.twokit.castbrowsernexusplayer', true, 'tv-cast', true, null, false, null],
            ['com.tuya.smartlife', true, 'smart-life', true, null, false, null],
            ['com.waze', true, 'waze-navigation', true, null, false, null],
            ['com.transsion.hilauncher', true, 'hios-launcher', true, null, false, null],
            ['com.opera.app.news', true, 'opera news', true, null, false, null],
            ['com.reddit.frontpage', true, 'reddit-app', true, null, false, null],
            ['com.harshad.someto', true, 'social-media-explorer', true, null, false, null],
            ['com.tcl.live', true, 'tcl-live', true, null, false, null],
            ['com.thinkfree.searchbyimage', true, 'reverse-image-search', true, null, false, null],
            ['hippeis.com.photochecker', true, 'photo-sherlock', true, null, false, null],
            ['hesoft.T2S', true, 't2s-app', true, null, false, null],
            ['com.zeebusiness.news', true, 'zee-business', true, null, false, null],
            ['com.netflix.mediaclient', true, 'netflix-app', true, null, false, null],
            ['com.oxoo.kinogo', true, 'kinogo.ge', true, null, false, null],
            ['ir.ilmili.telegraph', true, 'graph-messenger', true, null, false, null],
            ['the.best.gram', true, 'bestgram', true, null, false, null],
            ['org.aka.lite', true, 'aka-lite', true, null, false, null],
            ['org.aka.messenger', true, 'aka', true, null, false, null],
            ['com.saf.seca', true, 'search-craft', true, null, false, null],
            ['com.fsecure.ms.teliasweden', true, 'telia-trygg', true, null, false, null],
            ['com.gener8ads.wallet', true, 'gener8-browser', true, null, false, null],
            ['com.jambo', true, 'jambo', true, null, false, null],
            ['no.wifi.offline.games.puzzle.games', true, 'offline all in one', true, null, false, null],
            ['webexplorer.amazing.biro', true, 'internet-browser', true, null, false, null],
            ['com.xbh.universal.player', true, 'universal-player', true, null, false, null],
            ['com.mobile.applock.wt', true, 'app-lock', true, null, false, null],
            ['com.solide.filemanager.lte', true, 'solid-file-manager', true, null, false, null],
        ];
    }
}
