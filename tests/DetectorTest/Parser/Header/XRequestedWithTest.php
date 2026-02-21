<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2026, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Parser\Header;

use BrowserDetector\Data\Engine;
use BrowserDetector\Data\Os;
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
use UaRequest\Exception\NotFoundException;
use UaRequest\Header\XRequestedWith;
use UaResult\Bits\Bits;
use UaResult\Device\Architecture;
use UnexpectedValueException;

use function sprintf;

#[CoversClass(XRequestedWithClientCode::class)]
#[CoversClass(XRequestedWithClientVersion::class)]
#[CoversClass(XRequestedWithPlatformCode::class)]
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
        Os $platformCode,
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
            $header->getPlatformVersionWithOs(Os::unknown),
            sprintf('platform info mismatch for ua "%s"', $ua),
        );
        self::assertFalse($header->hasEngineCode(), sprintf('engine info mismatch for ua "%s"', $ua));

        try {
            $header->getEngineCode();

            self::fail('Exception expected');
        } catch (NotFoundException) {
            // do nothing
        }

        self::assertFalse(
            $header->hasEngineVersion(),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
        self::assertInstanceOf(
            NullVersion::class,
            $header->getEngineVersionWithEngine(Engine::unknown),
            sprintf('engine info mismatch for ua "%s"', $ua),
        );
    }

    /**
     * @return list<list<bool|Os|string|null>>
     *
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    public static function providerUa(): array
    {
        return [
            ['com.browser2345', true, '2345 browser', true, null, false, Os::unknown],
            ['this.is.a.fake.id.to.test.unknown.ids', false, null, false, null, false, Os::unknown],
            ['me.android.browser', true, 'me browser', true, null, false, Os::unknown],
            ['com.android.browser', true, 'android webview', true, null, false, Os::unknown],
            ['com.mx.browser', true, 'maxthon', true, null, false, Os::unknown],
            ['mobi.mgeek.TunnyBrowser', true, 'dolfin', true, null, false, Os::unknown],
            ['com.tencent.mm', true, 'wechat app', true, null, false, Os::unknown],
            ['com.asus.browser', true, 'asus browser', true, null, false, Os::unknown],
            ['com.UCMobile.lab', true, 'ucbrowser', true, null, false, Os::unknown],
            ['com.oupeng.browser', true, 'oupeng browser', true, null, false, Os::unknown],
            ['com.lenovo.browser', true, 'lenovo browser', true, null, false, Os::unknown],
            ['derek.iSurf', true, 'isurf', true, null, false, Os::unknown],
            ['com.aliyun.mobile.browser', true, 'aliyun-browser', true, null, false, Os::unknown],
            ['XMLHttpRequest', false, null, false, null, false, Os::unknown],
            ['com.tinyspeck.chatlyio', true, 'chatlyio app', true, null, false, Os::unknown],
            ['com.douban.group', true, 'douban app', true, null, false, Os::unknown],
            ['com.linkedin', true, 'linkedinbot', true, null, false, Os::unknown],
            ['com.google.android.apps.magazines', true, 'google play newsstand', true, null, false, Os::unknown],
            ['com.google.googlemobile', true, 'google mobile app', true, null, false, Os::unknown],
            ['com.google.android.youtube', true, 'youtube app', true, null, false, Os::unknown],
            ['com.apple.mobilenotes', true, 'apple mobilenotes', true, null, false, Os::unknown],
            ['com.apple.notes', true, 'apple notes app', true, null, false, Os::unknown],
            ['com.google.googleplus', true, 'google+ app', true, null, false, Os::unknown],
            ['com.apple.webkit', true, 'apple webkit service', true, null, false, Os::unknown],
            ['com.duckduckgo.mobile.android', true, 'duckduck app', true, null, false, Os::unknown],
            ['com.opera.mini.native', true, 'opera mini', true, null, false, Os::unknown],
            ['com.google.android.apps.searchlite', true, 'google search lite', true, null, false, Os::unknown],
            ['com.facebook.katana', true, 'facebook app', true, null, false, Os::unknown],
            ['com.huawei.browser', true, 'huawei-browser', true, null, false, Os::unknown],
            ['com.huawei.search', true, 'hi-search', true, null, false, Os::unknown],
            ['com.microsoft.bing', true, 'bingsearch', true, null, false, Os::unknown],
            ['com.microsoft.office.outlook', true, 'outlook', true, null, false, Os::unknown],
            ['com.opera.gx', true, 'opera gx', true, null, false, Os::unknown],
            ['com.ksmobile.cb', true, 'cm browser', true, null, false, Os::unknown],
            ['com.android.chrome', true, 'chrome', true, null, false, Os::unknown],
            ['com.facebook.orca', true, 'facebook messenger app', true, null, false, Os::unknown],
            ['jp.co.yahoo.android.yjtop', true, 'yahoo-japan-app', true, null, false, Os::unknown],
            ['com.instagram.android', true, 'instagram app', true, null, false, Os::unknown],
            ['com.microsoft.bingintl', true, 'bingsearch', true, null, false, Os::unknown],
            ['com.nhn.android.search', true, 'naver', true, null, false, Os::unknown],
            ['com.sina.weibo', true, 'weibo app', true, null, false, Os::unknown],
            ['com.opera.touch', true, 'opera touch', true, null, false, Os::unknown],
            ['org.mozilla.klar', true, 'firefox klar', true, null, false, Os::unknown],
            ['jp.co.fenrir.android.sleipnir', true, 'sleipnir', true, null, false, Os::unknown],
            ['de.gdata.mobilesecurityorange', true, 'g-data mobile security', true, null, false, Os::unknown],
            ['com.active.cleaner', true, 'active-cleaner', true, null, false, Os::unknown],
            ['com.aol.mobile.aolapp', true, 'aol-app', true, null, false, Os::unknown],
            ['com.appsinnova.android.keepclean', true, 'keep-clean', true, null, false, Os::unknown],
            ['com.ayoba.ayoba', true, 'ayoba-app', true, null, false, Os::unknown],
            ['com.cmcm.armorfly', true, 'armorfly-browser', true, null, false, Os::unknown],
            ['com.emporia.emporiaapprebuild', true, 'emporia-app', true, null, false, Os::unknown],
            ['com.espn.score_center', true, 'espn-app', true, null, false, Os::unknown],
            ['com.fancyclean.security.antivirus', true, 'fancy-security', true, null, false, Os::unknown],
            ['com.fsecure.ms.buhldata', true, 'wiso-internet-security', true, null, false, Os::unknown],
            ['com.fsecure.ms.darty', true, 'darty-securite', true, null, false, Os::unknown],
            ['com.fsecure.ms.dc', true, 'f-secure mobile security', true, null, false, Os::unknown],
            ['com.fsecure.ms.nifty', true, 'always safe security 24', true, null, false, Os::unknown],
            ['com.fsecure.ms.safe', true, 'f-secure safe', true, null, false, Os::unknown],
            ['com.fsecure.ms.saunalahti_m', true, 'elisa-turvapaketti', true, null, false, Os::unknown],
            ['com.fsecure.ms.swisscom.sa', true, 'swisscom-internet-security', true, null, false, Os::unknown],
            ['com.fsecure.ms.ziggo', true, 'ziggo-safe-online', true, null, false, Os::unknown],
            ['com.google.android.gms', true, 'google-play-services', true, null, false, Os::unknown],
            ['com.hld.anzenbokusu', true, 's-gallery', true, null, false, Os::unknown],
            ['com.hld.anzenbokusucal', true, 'calculator-photo', true, null, false, Os::unknown],
            ['com.hld.anzenbokusufake', true, 'calculator-hide', true, null, false, Os::unknown],
            ['com.hornet.android', true, 'hornet', true, null, false, Os::unknown],
            ['com.huawei.appmarket', true, 'huawei-app-gallery', true, null, false, Os::unknown],
            ['com.huawei.fastapp', true, 'huawei-quick-app-center', true, null, false, Os::unknown],
            ['com.huawei.hwsearch', true, 'huawei-petal-search', true, null, false, Os::unknown],
            ['com.amazon.webapps.gms.search', true, 'google-search', true, null, false, Os::unknown],
            ['com.andrewshu.android.reddit', true, 'reddit-is-fun', true, null, false, Os::unknown],
            ['com.andrewshu.android.redditdonation', true, 'reddit-is-fun', true, null, false, Os::unknown],
            ['com.jaumo', true, 'jaumo', true, null, false, Os::unknown],
            ['com.jaumo.prime', true, 'jaumo-prime', true, null, false, Os::unknown],
            ['com.jb.security', true, 'go-security', true, null, false, Os::unknown],
            ['com.lenovo.anyshare.gps', true, 'share-it', true, null, false, Os::unknown],
            ['com.michatapp.im', true, 'mi-chat-app', true, null, false, Os::unknown],
            ['com.michatapp.im.lite', true, 'mi-chat-lite', true, null, false, Os::unknown],
            ['com.noxgroup.app.security', true, 'nox-security', true, null, false, Os::unknown],
            ['com.rcplatform.livechat', true, 'tumile', true, null, false, Os::unknown],
            ['com.rs.explorer.filemanager', true, 'rs-file', true, null, false, Os::unknown],
            ['com.skout.android', true, 'skout', true, null, false, Os::unknown],
            ['com.sony.nfx.app.sfrc', true, 'news-suite-by-sony', true, null, false, Os::unknown],
            ['com.surfshark.vpnclient.android', true, 'surfshark-app', true, null, false, Os::unknown],
            ['com.swisscows.search', true, 'swisscows-private-search', true, null, false, Os::unknown],
            ['com.tinder', true, 'tinder-app', true, null, false, Os::unknown],
            ['com.totalav.android', true, 'total-av-mobile-security', true, null, false, Os::unknown],
            ['com.turtc', true, 'türkiye-milli-arama-motoru', true, null, false, Os::unknown],
            ['mark.via.gp', true, 'via-browser', true, null, false, Os::unknown],
            ['com.kiwibrowser.browser', true, 'kiwi', true, null, false, Os::unknown],
            ['com.brave.browser', true, 'brave', true, null, false, Os::unknown],
            ['org.mozilla.focus', true, 'firefox focus', true, null, false, Os::unknown],
            ['com.vivaldi.browser', true, 'vivaldi', true, null, false, Os::unknown],
            ['com.aloha.browser', true, 'aloha-browser', true, null, false, Os::unknown],
            ['com.cloudmosa.puffinFree', true, 'puffin', true, null, false, Os::unknown],
            ['com.ucmobile.intl', true, 'ucbrowser', true, null, false, Os::unknown],
            ['com.tvwebbrowser.v22', true, 'tv-browser-internet', true, null, false, Os::unknown],
            ['com.udicorn.proxy', true, 'blue-proxy', true, null, false, Os::unknown],
            ['com.ume.browser.cust', true, 'ume-browser', true, null, false, Os::unknown],
            ['com.v2.vpn.security.free', true, 'fast-unlimited-vpn', true, null, false, Os::unknown],
            ['com.videochat.livu', true, 'livu-app', true, null, false, Os::unknown],
            ['com.wiseplay', true, 'wiseplay', true, null, false, Os::unknown],
            ['com.yahoo.onesearch', true, 'yahoo-onesearch', true, null, false, Os::unknown],
            ['com.yy.hiyo', true, 'hago-app', true, null, false, Os::unknown],
            ['de.baumann.browser', true, 'foss-browser', true, null, false, Os::unknown],
            ['free.vpn.unblock.proxy.vpnmonster', true, 'vpn-monster', true, null, false, Os::unknown],
            ['io.metamask', true, 'meta-mask', true, null, false, Os::unknown],
            ['it.ideasolutions.kyms', true, 'kyms', true, null, false, Os::unknown],
            ['it.tolelab.fvd', true, 'free-video-downloader', true, null, false, Os::unknown],
            ['com.snapchat.android', true, 'snapchat app', true, null, false, Os::unknown],
            ['jp.gocro.smartnews.android', true, 'smart-news-app', true, null, false, Os::unknown],
            ['kik.android', true, 'kik', true, null, false, Os::unknown],
            ['com.hisense.odinbrowser', true, 'odin-browser', true, null, false, Os::unknown],
            ['org.quantumbadger.redreader', true, 'red-reader', true, null, false, Os::unknown],
            ['phone.cleaner.antivirus.speed.booster', true, 'phone-clean', true, null, false, Os::unknown],
            ['reactivephone.msearch', true, 'smart-search-web-browser', true, null, false, Os::unknown],
            ['secure.explorer.web.browser', true, 'browser lite', true, null, false, Os::unknown],
            ['snapu2b.com', true, 'snapu2b', true, null, false, Os::unknown],
            ['pi.browser', true, 'pi browser', true, null, false, Os::unknown],
            ['alohabrowser', true, 'aloha-browser', true, null, false, Os::unknown],
            ['org.telegram.messenger', true, 'telegram-app', true, null, false, Os::unknown],
            ['xbrowser', true, 'x-browser', true, null, false, Os::unknown],
            ['com.xbrowser.play', true, 'x-browser', true, null, false, Os::unknown],
            ['com.mycompany.app.soulbrowser', true, 'soul-browser', true, null, false, Os::unknown],
            ['com.sec.android.app.sbrowser.lite', true, 'samsung-browser-lite', true, null, false, Os::unknown],
            ['jp.ddo.pigsty.HabitBrowser', true, 'habit-browser', true, null, false, Os::unknown],
            ['com.mi.globalbrowser.mini', true, 'mint browser', true, null, false, Os::unknown],
            ['me.webalert', true, 'web-alert-app', true, null, false, Os::unknown],
            ['com.pure.mini.browser', true, 'mini-web-browser', true, null, false, Os::unknown],
            ['acr.browser.raisebrowserfull', true, 'raise-fast-browser', true, null, false, Os::unknown],
            ['com.Fast.BrowserUc.lite', true, 'fast-browser-uc-lite', true, null, false, Os::unknown],
            ['acr.browser.barebones', true, 'lightning-browser', true, null, false, Os::unknown],
            ['anar.app.darkweb', true, 'dark-web-browser', true, null, false, Os::unknown],
            ['com.cake.browser', true, 'cake-browser', true, null, false, Os::unknown],
            ['com.iebrowser.fast', true, 'ie-browser-fast', true, null, false, Os::unknown],
            ['info.sunista.app', true, 'sanista-persian-instagram', true, null, false, Os::unknown],
            ['com.instapro.app', true, 'insta-pro', true, null, false, Os::unknown],
            ['com.kakao.talk', true, 'kakaotalk', true, null, false, Os::unknown],
            ['acr.browser.linxy', true, 'vegas-browser', true, null, false, Os::unknown],
            ['com.oh.bro', true, 'oh-browser', true, null, false, Os::unknown],
            ['com.oh.brop', true, 'oh-private-browser', true, null, false, Os::unknown],
            ['net.onecook.browser', true, 'stargon-browser', true, null, false, Os::unknown],
            ['phx.hot.browser', true, 'anka-browser', true, null, false, Os::unknown],
            ['org.torproject.android', true, 'orbot', true, null, false, Os::unknown],
            ['web.browser.dragon', true, 'dragon-browser', true, null, false, Os::unknown],
            ['org.easyweb.browser', true, 'easy-browser', true, null, false, Os::unknown],
            ['com.sharkeeapp.browser', true, 'sharkee-browser', true, null, false, Os::unknown],
            ['com.mobiu.browser', true, 'lark-browser', true, null, false, Os::unknown],
            ['com.qflair.browserq', true, 'pluma-browser', true, null, false, Os::unknown],
            ['com.noxgroup.app.browser', true, 'nox-browser', true, null, false, Os::unknown],
            ['com.jio.web', true, 'jio-sphere', true, null, false, Os::unknown],
            ['com.cookiegames.smartcookie', true, 'smartcookieweb-privacy-browser', true, null, false, Os::unknown],
            ['org.lineageos.jelly', true, 'jelly-browser', true, null, true, Os::lineageos],
            ['com.oceanhero.search', true, 'ocean-hero-app', true, null, false, Os::unknown],
            ['com.oryon.multitasking', true, 'multitasking-app', true, null, false, Os::unknown],
            ['net.fast.web.browser', true, 'web-browser-web-explorer', true, null, false, Os::unknown],
            ['com.bestvideodownloader.newvideodownloader', true, 'all-video-downloader', true, null, false, Os::unknown],
            ['com.yiyinkuang.searchboard', true, 'search+-for-google', true, null, false, Os::unknown],
            ['com.aeroinsta.android', true, 'aero-insta', true, null, false, Os::unknown],
            ['com.cliqz.browser', true, 'cliqz-browser', true, null, false, Os::unknown],
            ['com.appssppa.idesktoppcbrowser', true, 'idesktop-pc-browser', true, null, false, Os::unknown],
            ['com.sec.app.samsungprintservice', true, 'samsung-print-service-plugin', true, null, false, Os::unknown],
            ['jp.co.canon.bsd.ad.pixmaprint', true, 'canon-print', true, null, false, Os::unknown],
            ['com.gl9.cloudBrowser', true, 'surfbrowser', true, null, false, Os::unknown],
            ['com.kaweapp.webexplorer', true, 'web-explorer', true, null, false, Os::unknown],
            ['com.snaptube.premium', true, 'snap-tube', true, null, false, Os::unknown],
            ['com.eagle.web.browser.internet.privacy.browser', true, 'private-browser-web-browser', true, null, false, Os::unknown],
            ['com.cleanmaster.security', true, 'cm-security', true, null, false, Os::unknown],
            ['devian.tubemate.v3', true, 'tube-mate', true, null, false, Os::unknown],
            ['de.einsundeins.searchapp.gmx.com', true, 'gmx-search', true, null, false, Os::unknown],
            ['acr.browser.lightning', true, 'lightning-browser', true, null, false, Os::unknown],
            ['acr.browser.lightning2', true, 'lightning-browser', true, null, false, Os::unknown],
            ['acr.browser.lightningq16w', true, 'lightning-browser', true, null, false, Os::unknown],
            ['com.web_view_mohammed.ad.webview_app', true, 'appso', true, null, false, Os::unknown],
            ['com.fsecure.ms.netcologne', true, 'sicherheitspaket', true, null, false, Os::unknown],
            ['de.telekom.mail', true, 'telekom-mail', true, null, false, Os::unknown],
            ['ai.blokee.browser.android', true, 'bloket-browser', true, null, false, Os::unknown],
            ['com.ume.browser.euas', true, 'ume-browser', true, null, false, Os::unknown],
            ['com.ume.browser.bose', true, 'ume-browser', true, null, false, Os::unknown],
            ['com.ume.browser.international', true, 'ume-browser', true, null, false, Os::unknown],
            ['com.ume.browser.latinamerican', true, 'ume-browser', true, null, false, Os::unknown],
            ['com.ume.browser.mexicotelcel', true, 'ume-browser', true, null, false, Os::unknown],
            ['com.ume.browser.venezuelavtelca', true, 'ume-browser', true, null, false, Os::unknown],
            ['com.ume.browser.northamerica', true, 'ume-browser', true, null, false, Os::unknown],
            ['com.ume.browser.newage', true, 'ume-browser', true, null, false, Os::unknown],
            ['com.wolvesinteractive.racinggo', true, 'racing-go', true, null, false, Os::unknown],
            ['com.microsoft.amp.apps.bingnews', true, 'msn-app', true, null, false, Os::unknown],
            ['com.litepure.browser.gp', true, 'pure-browser', true, null, false, Os::unknown],
            ['com.boatbrowser.free', true, 'boat-browser', true, null, false, Os::unknown],
            ['com.brother.mfc.brprint', true, 'brother-iprint-scan', true, null, false, Os::unknown],
            ['com.emoticon.screen.home.launcher', true, 'in-launcher', true, null, false, Os::unknown],
            ['com.explore.web.browser', true, 'web-browser-explorer', true, null, false, Os::unknown],
            ['com.emporia.browser', true, 'emporia-app', true, null, false, Os::unknown],
            ['de.telekom.epub', true, 'pageplace-reader', true, null, false, Os::unknown],
            ['com.appsverse.photon', true, 'photon-browser', true, null, false, Os::unknown],
            ['com.dolphin.browser.zero', true, 'dolfin-zero', true, null, false, Os::unknown],
            ['com.stoutner.privacybrowser.standard', true, 'stoutner-privacy-browser', true, null, false, Os::unknown],
            ['com.skype.raider', true, 'skype', true, null, false, Os::unknown],
            ['de.gdata.mobilesecurity2b', true, 'tie-team-mobile-security', true, null, false, Os::unknown],
            ['de.freenet.mail', true, 'freenet-mail', true, null, false, Os::unknown],
            ['com.transsion.phoenix', true, 'phoenix browser', true, null, false, Os::unknown],
            ['com.startpage', true, 'startpage-private-search-engine', true, null, false, Os::unknown],
            ['jp.hazuki.yuzubrowser', true, 'yuzu-browser', true, null, false, Os::unknown],
            ['net.dezor.browser', true, 'dezor-browser', true, null, false, Os::unknown],
            ['com.go.browser', true, 'go-browser', true, null, false, Os::unknown],
            ['com.dv.adm', true, 'advanced-download-manager', true, null, false, Os::unknown],
            ['com.androidbull.incognito.browser', true, 'incognito-browser', true, null, false, Os::unknown],
            ['com.symantec.mobile.idsafe', true, 'norton-password-manager', true, null, false, Os::unknown],
            ['com.lge.snappage', true, 'snap-page', true, null, false, Os::unknown],
            ['com.morrisxar.nav88', true, 'office-browser', true, null, false, Os::unknown],
            ['epson.print', true, 'epson-iprint', true, null, false, Os::unknown],
            ['miada.tv.webbrowser', true, 'internet-web-browser', true, null, false, Os::unknown],
            ['threads.thor', true, 'thor-browser', true, null, false, Os::unknown],
            ['com.opera.browser', true, 'opera', true, null, false, Os::unknown],
            ['com.opera.browser.afin', true, 'opera', true, null, false, Os::unknown],
            ['com.startpage.mobile', true, 'startpage-private-search-engine', true, null, false, Os::unknown],
            ['com.startpage.app', true, 'startpage-private-search-engine', true, null, false, Os::unknown],
            ['ace.avd.tube.video.downloader', true, 'free-video-downloader-pro', true, null, false, Os::unknown],
            ['com.catdaddy.cat22', true, 'wwe-supercard', true, null, false, Os::unknown],
            ['com.jlwf.droid.tutu', true, 'tutu-app', true, null, false, Os::unknown],
            ['com.tct.launcher', true, 'joy-launcher', true, null, false, Os::unknown],
            ['com.baidu.searchbox', true, 'baidu box app', true, null, false, Os::unknown],
            ['de.eue.mobile.android.mail', true, 'einsundeins-mail', true, null, false, Os::unknown],
            ['com.wfeng.droid.tutu', true, 'tutu-app', true, null, false, Os::unknown],
            ['com.honor.global', true, 'honor-store', true, null, false, Os::unknown],
            ['com.finimize.oban', true, 'finimize', true, null, false, Os::unknown],
            ['com.myhomescreen.weather', true, 'weather-home', true, null, false, Os::unknown],
            ['hot.fiery.browser', true, 'fiery-browser', true, null, false, Os::unknown],
            ['de.gmx.mobile.android.mail', true, 'gmx-mail', true, null, false, Os::unknown],
            ['de.twokit.castbrowser', true, 'tv-cast', true, null, false, Os::unknown],
            ['de.twokit.castbrowser.pro', true, 'tv-cast-pro', true, null, false, Os::unknown],
            ['com.esaba.downloader', true, 'downloader', true, null, false, Os::unknown],
            ['com.agilebits.onepassword', true, '1password', true, null, false, Os::unknown],
            ['com.browser2345_ucc', true, '2345 browser', true, null, false, Os::unknown],
            ['com.browser2345hd', true, '2345-browser-hd', true, null, false, Os::unknown],
            ['air.stage.web.view', true, 'adobe air', true, null, false, Os::unknown],
            ['air.stagewebview', true, 'adobe air', true, null, false, Os::unknown],
            ['air.StageWebViewBridgeTest.debug', true, 'adobe air', true, null, false, Os::unknown],
            ['air.StageWebViewVideo.debug', true, 'adobe air', true, null, false, Os::unknown],
            ['com.adobe.phonegap.app', true, 'adobe-phonegap', true, null, false, Os::unknown],
            ['com.adobe.reader', true, 'adobe-reader', true, null, false, Os::unknown],
            ['com.doro.apps.browser', true, 'doro-browser', true, null, false, Os::unknown],
            ['de.einsundeins.searchapp.web', true, 'web.de-search', true, null, false, Os::unknown],
            ['com.droidlogic.mboxlauncher', true, 'mbox-launcher', true, null, false, Os::unknown],
            ['com.droidlogic.xlauncher', true, 'x-launcher', true, null, false, Os::unknown],
            ['com.baidu.browser.apps', true, 'baidu browser', true, null, false, Os::unknown],
            ['com.hihonor.baidu.browser', true, 'honor-browser', true, null, false, Os::unknown],
            ['com.baidu.searchbox.lite', true, 'baidu box app lite', true, null, false, Os::unknown],
            ['com.microsoft.copilot', true, 'microsoft-copilot', true, null, false, Os::unknown],
            ['de.web.mobile.android.mail', true, 'web.de mail', true, null, false, Os::unknown],
            ['com.readly.client', true, 'readly-app', true, null, false, Os::unknown],
            ['com.gbox.android.helper', true, 'gbox-helper', true, null, false, Os::unknown],
            ['com.samsung.android.email.provider', true, 'samsung-email', true, null, false, Os::unknown],
            ['it.italiaonline.mail', true, 'libero-mail', true, null, false, Os::unknown],
            ['webexplorer.amazing.speed', true, 'web-browser-explorer', true, null, false, Os::unknown],
            ['nu.tommie.inbrowser', true, 'in-browser', true, null, false, Os::unknown],
            ['com.massimple.nacion.gcba.es', true, 'plus-simple-browser', true, null, false, Os::unknown],
            ['com.massimple.nacion.parana.es', true, 'plus-simple-browser', true, null, false, Os::unknown],
            ['every.browser.inc', true, 'every-browser', true, null, false, Os::unknown],
            ['com.til.timesnews', true, 'news-point', true, null, false, Os::unknown],
            ['com.omshyapps.vpn', true, 'omshy-vpn', true, null, false, Os::unknown],
            ['com.sharekaro.app', true, 'sharekaro', true, null, false, Os::unknown],
            ['com.transsion.itel.launcher', true, 'itel-os-launcher', true, null, false, Os::unknown],
            ['com.cleanmaster.mguard', true, 'clean-master', true, null, false, Os::unknown],
            ['com.cleanmaster.mguard.huawei', true, 'clean-master', true, null, false, Os::unknown],
            ['com.larus.wolf', true, 'cici', true, null, false, Os::unknown],
            ['com.kuto.vpn', true, 'kuto-vpn', true, null, false, Os::unknown],
            ['com.microsoft.math', true, 'microsoft-math', true, null, false, Os::unknown],
            ['com.google.android.apps.maps', true, 'google-maps', true, null, false, Os::unknown],
            ['com.phlox.tvwebbrowser', true, 'tv-bro', true, null, false, Os::unknown],
            ['com.transsion.XOSLauncher', true, 'xos-launcher', true, null, false, Os::unknown],
            ['com.infinix.xshare', true, 'xshare', true, null, false, Os::unknown],
            ['com.xshare.sharefiles1', true, 'xshare', true, null, false, Os::unknown],
            ['com.transsion.magicshow', true, 'visha', true, null, false, Os::unknown],
            ['com.awesapp.isp', true, 'isafeplay', true, null, false, Os::unknown],
            ['com.anydesk.anydeskandroid', true, 'anydesk-remote-desktop', true, null, false, Os::unknown],
            ['com.palmteam.imagesearch', true, 'search-by-image', true, null, false, Os::unknown],
            ['castify.roku', true, 'cast-web-videos', true, null, false, Os::unknown],
            ['za.co.tracker.consumer', true, 'tracker-connect', true, null, false, Os::unknown],
            ['nu.bi.moya', true, 'moyaapp', true, null, false, Os::unknown],
            ['com.tradron.hdvideodownloader', true, 'download-hub', true, null, false, Os::unknown],
            ['com.box.video.downloader', true, 'box-video-downloader', true, null, false, Os::unknown],
            ['com.sec.android.app.sbrowser', true, 'samsungbrowser', true, null, false, Os::unknown],
            ['com.opera.mini.native.beta', true, 'opera mini beta', true, null, false, Os::unknown],
            ['com.yandex.browser', true, 'yabrowser', true, null, false, Os::unknown],
            ['org.mozilla.firefox', true, 'firefox', true, null, false, Os::unknown],
            ['com.tv.browser.open', true, 'open-tv-browser', true, null, false, Os::unknown],
            ['com.logicui.tvbrowser2', true, 'logicui-tv-browser', true, null, false, Os::unknown],
            ['com.internet.tvbrowser', true, 'browser-app-browser', true, null, false, Os::unknown],
            ['com.sweep.cleaner.trash.junk', true, 'sweep-cleaner', true, null, false, Os::unknown],
            ['com.flatfish.cal.privacy', true, 'hidex-calculator-photo-vault', true, null, false, Os::unknown],
            ['com.myhomescreen.news', true, 'news-home', true, null, false, Os::unknown],
            ['com.myhomescreen.fitness', true, 'fit-home', true, null, false, Os::unknown],
            ['com.fsecure.ms.talktalksa', true, 'talktalk-supersafe', true, null, false, Os::unknown],
            ['com.fsecure.ms.actshield', true, 'act-shield', true, null, false, Os::unknown],
            ['com.fsecure.ms.kpn.veilig', true, 'veilig-virusscanner', true, null, false, Os::unknown],
            ['com.twitter.android', true, 'twitter app', true, null, false, Os::unknown],
            ['com.seraphic.openinet.pre', true, 'metax-open-browser', true, null, false, Os::unknown],
            ['org.telegram.messenger.web', true, 'telegram-app', true, null, false, Os::unknown],
            ['com.android.media.module.services', true, 'mediaservices-apk', true, null, false, Os::unknown],
            ['mojeek.app', true, 'mojeek-app', true, null, false, Os::unknown],
            ['com.castify', true, 'cast-to-tv-plus', true, null, false, Os::unknown],
            ['com.stickypassword.android', true, 'sticky-password', true, null, false, Os::unknown],
            ['com.qihoo.security', true, '360-security', true, null, false, Os::unknown],
            ['com.nytimes.crossword', true, 'nytimes-crossword', true, null, false, Os::unknown],
            ['com.aospstudio.tvsearch', true, 'neptune-tv-browser', true, null, false, Os::unknown],
            ['com.playit.videoplayer', true, 'play-it', true, null, false, Os::unknown],
            ['com.repotools.whatplay', true, 'what-play', true, null, false, Os::unknown],
            ['com.instabridge.android', true, 'insta-bridge', true, null, false, Os::unknown],
            ['com.antivirus.master.cmsecurity', true, 'cm-security', true, null, false, Os::unknown],
            ['com.nocardteam.nocardvpn.lite', true, 'no-card-lite', true, null, false, Os::unknown],
            ['com.nocardteam.nocardvpn', true, 'no-card', true, null, false, Os::unknown],
            ['com.ezt.vpn', true, 'ez-vpn', true, null, false, Os::unknown],
            ['net.daum.android.daum', true, 'daum-app', true, null, false, Os::unknown],
            ['com.fsecure.ms.sonera', true, 'telia-turvapaketti', true, null, false, Os::unknown],
            ['com.fsecure.ms.sfr', true, 'sfr-securite', true, null, false, Os::unknown],
            ['com.fsecure.ms.upc.ch', true, 'upc-internet-security', true, null, false, Os::unknown],
            ['com.fsecure.ms.dnafi', true, 'dna-digiturva', true, null, false, Os::unknown],
            ['com.nate.android.portalmini', true, 'nate-app', true, null, false, Os::unknown],
            ['com.bigqsys.photosearch.searchbyimage2020', true, 'photo-search-app', true, null, false, Os::unknown],
            ['com.qjy.browser', true, 'qjy-tv-browser', true, null, false, Os::unknown],
            ['com.myhomescreen.messenger.home.emoji.lite', true, 'messenger-lite', true, null, false, Os::unknown],
            ['com.myhomescreen.access', true, 'big-keyboard', true, null, false, Os::unknown],
            ['com.myhomescreen.email', true, 'email-home', true, null, false, Os::unknown],
            ['com.myhomescreen.sms', true, 'messenger-home', true, null, false, Os::unknown],
            ['io.bluewallet.bluewallet', true, 'blue-wallet', true, null, false, Os::unknown],
            ['com.bifrostwallet.app', true, 'bifrost-wallet', true, null, false, Os::unknown],
            ['com.tt.android.dm.view', true, 'download-manager', true, null, false, Os::unknown],
            ['com.wukongtv.wkcast.intl', true, 'quick-cast-app', true, null, false, Os::unknown],
            ['mobi.deallauncher.coupons.shopping', true, 'coupons-promo-codes', true, null, false, Os::unknown],
            ['idm.video.free', true, 'idm-video-download-manager', true, null, false, Os::unknown],
            ['de.twokit.video.tv.cast.browser.samsung', true, 'tv-cast', true, null, false, Os::unknown],
            ['de.twokit.video.tv.cast.browser.lg', true, 'tv-cast', true, null, false, Os::unknown],
            ['de.twokit.video.tv.cast.browser.firetv', true, 'tv-cast', true, null, false, Os::unknown],
            ['de.twokit.castbrowsernexusplayer', true, 'tv-cast', true, null, false, Os::unknown],
            ['com.tuya.smartlife', true, 'smart-life', true, null, false, Os::unknown],
            ['com.waze', true, 'waze-navigation', true, null, false, Os::unknown],
            ['com.transsion.hilauncher', true, 'hios-launcher', true, null, false, Os::unknown],
            ['com.opera.app.news', true, 'opera news', true, null, false, Os::unknown],
            ['com.reddit.frontpage', true, 'reddit-app', true, null, false, Os::unknown],
            ['com.harshad.someto', true, 'social-media-explorer', true, null, false, Os::unknown],
            ['com.tcl.live', true, 'tcl-live', true, null, false, Os::unknown],
            ['com.thinkfree.searchbyimage', true, 'reverse-image-search', true, null, false, Os::unknown],
            ['hippeis.com.photochecker', true, 'photo-sherlock', true, null, false, Os::unknown],
            ['hesoft.T2S', true, 't2s-app', true, null, false, Os::unknown],
            ['com.zeebusiness.news', true, 'zee-business', true, null, false, Os::unknown],
            ['com.netflix.mediaclient', true, 'netflix-app', true, null, false, Os::unknown],
            ['com.oxoo.kinogo', true, 'kinogo.ge', true, null, false, Os::unknown],
            ['ir.ilmili.telegraph', true, 'graph-messenger', true, null, false, Os::unknown],
            ['the.best.gram', true, 'bestgram', true, null, false, Os::unknown],
            ['org.aka.lite', true, 'aka-lite', true, null, false, Os::unknown],
            ['org.aka.messenger', true, 'aka', true, null, false, Os::unknown],
            ['com.saf.seca', true, 'search-craft', true, null, false, Os::unknown],
            ['com.fsecure.ms.teliasweden', true, 'telia-trygg', true, null, false, Os::unknown],
            ['com.gener8ads.wallet', true, 'gener8-browser', true, null, false, Os::unknown],
            ['com.jambo', true, 'jambo', true, null, false, Os::unknown],
            ['no.wifi.offline.games.puzzle.games', true, 'offline all in one', true, null, false, Os::unknown],
            ['webexplorer.amazing.biro', true, 'internet-browser', true, null, false, Os::unknown],
            ['com.xbh.universal.player', true, 'universal-player', true, null, false, Os::unknown],
            ['com.mobile.applock.wt', true, 'app-lock', true, null, false, Os::unknown],
            ['com.solide.filemanager.lte', true, 'solid-file-manager', true, null, false, Os::unknown],
            ['com.lechneralexander.privatebrowser', true, 'private-internet-browser', true, null, false, Os::unknown],
            ['com.moonshot.kimichat', true, 'kimi-app', true, null, false, Os::unknown],
            ['com.deepseek.chat', true, 'deepseek-app', true, null, false, Os::unknown],
            ['com.chainapsis.keplr', true, 'keplr-app', true, null, false, Os::unknown],
            ['com.viber.voip', true, 'viber-app', true, null, false, Os::unknown],
            ['com.fsecure.ms.voo', true, 'vis+ app', true, null, false, Os::unknown],
            ['com.fsecure.ms.fnac', true, 'ma protection app', true, null, false, Os::unknown],
            ['com.wecloud.lookr', true, 'lookr-app', true, null, false, Os::unknown],
            ['com.canopy.vpn.filter.parent', true, 'canopy-app', true, null, false, Os::unknown],
            ['ai.mainfunc.genspark', true, 'genspark-app', true, null, false, Os::unknown],
            ['com.rocks.music.videoplayer', true, 'rocks-player', true, null, false, Os::unknown],
            ['proxy.browser.unblock.sites.proxybrowser.unblocksites', true, 'proxy-browser', true, null, false, Os::unknown],
            ['com.google.android.apps.youtube.music', true, 'youtube-music', true, null, false, Os::unknown],
            ['nl.nrc.audio', true, 'nrc-audio', true, null, false, Os::unknown],
            ['org.telegram.plus', true, 'telegram-plus-messenger', true, null, false, Os::unknown],
            ['com.android.launcher3', true, 'launcher3', true, null, false, Os::unknown],
            ['pure.lite.browser', true, 'pure-lite-browser', true, null, false, Os::unknown],
            ['de.inseven.dogtorance', true, 'dogtorance-app', true, null, false, Os::unknown],
            ['jp.naver.line.android', true, 'line', true, null, false, Os::unknown],
            ['com.netqin.ps', true, 'vault-app', true, null, false, Os::unknown],
            ['com.dubox.drive', true, 'terabox-app', true, null, false, Os::unknown],
            ['com.hihonor.search', true, 'honor-search-app', true, null, false, Os::unknown],
            ['org.flow.browser', true, 'flowsurf', true, null, false, Os::unknown],
            ['com.tcl.browser', true, 'browse-here', true, null, false, Os::unknown],
            ['com.imo.android.imoim', true, 'imo-international-calls-chat', true, null, false, Os::unknown],
            ['com.heytap.browser', true, 'heytapbrowser', true, null, false, Os::unknown],
            ['ai.perplexity.comet', true, 'comet', true, null, false, Os::unknown],
            ['com.tencent.mtt', true, 'qqbrowser', true, null, false, Os::unknown],
        ];
    }
}
