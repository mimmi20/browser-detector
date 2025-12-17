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

use BrowserDetector\Data\Os;
use BrowserDetector\Parser\Header\XRequestedWithClientCode;
use BrowserDetector\Parser\Header\XRequestedWithPlatformCode;
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

        try {
            $header->getEngineCode();

            $this->fail('Exception expected');
        } catch (NotFoundException) {
            // do nothing
        }

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
     * @return list<list<bool|Os|string|null>>
     *
     * @throws void
     *
	 * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    public static function providerUa(): array
    {
        return [
            ['com.browser2345', true, '2345 browser', false, null, false, Os::unknown],
            ['this.is.a.fake.id.to.test.unknown.ids', false, null, false, null, false, Os::unknown],
            ['me.android.browser', true, 'me browser', false, null, false, Os::unknown],
            ['com.android.browser', true, 'android webview', false, null, false, Os::unknown],
            ['com.mx.browser', true, 'maxthon', false, null, false, Os::unknown],
            ['mobi.mgeek.TunnyBrowser', true, 'dolfin', false, null, false, Os::unknown],
            ['com.tencent.mm', true, 'wechat app', false, null, false, Os::unknown],
            ['com.asus.browser', true, 'asus browser', false, null, false, Os::unknown],
            ['com.UCMobile.lab', true, 'ucbrowser', false, null, false, Os::unknown],
            ['com.oupeng.browser', true, 'oupeng browser', false, null, false, Os::unknown],
            ['com.lenovo.browser', true, 'lenovo browser', false, null, false, Os::unknown],
            ['derek.iSurf', true, 'isurf', false, null, false, Os::unknown],
            ['com.aliyun.mobile.browser', true, 'aliyun-browser', false, null, false, Os::unknown],
            ['XMLHttpRequest', false, null, false, null, false, Os::unknown],
            ['com.tinyspeck.chatlyio', true, 'chatlyio app', false, null, false, Os::unknown],
            ['com.douban.group', true, 'douban app', false, null, false, Os::unknown],
            ['com.linkedin', true, 'linkedinbot', false, null, false, Os::unknown],
            ['com.google.android.apps.magazines', true, 'google play newsstand', false, null, false, Os::unknown],
            ['com.google.googlemobile', true, 'google mobile app', false, null, false, Os::unknown],
            ['com.google.android.youtube', true, 'youtube app', false, null, false, Os::unknown],
            ['com.apple.mobilenotes', true, 'apple mobilenotes', false, null, false, Os::unknown],
            ['com.apple.notes', true, 'apple notes app', false, null, false, Os::unknown],
            ['com.google.googleplus', true, 'google+ app', false, null, false, Os::unknown],
            ['com.apple.webkit', true, 'apple webkit service', false, null, false, Os::unknown],
            ['com.duckduckgo.mobile.android', true, 'duckduck app', false, null, false, Os::unknown],
            ['com.opera.mini.native', true, 'opera mini', false, null, false, Os::unknown],
            ['com.google.android.apps.searchlite', true, 'google search lite', false, null, false, Os::unknown],
            ['com.facebook.katana', true, 'facebook app', false, null, false, Os::unknown],
            ['com.huawei.browser', true, 'huawei-browser', false, null, false, Os::unknown],
            ['com.huawei.search', true, 'hi-search', false, null, false, Os::unknown],
            ['com.microsoft.bing', true, 'bingsearch', false, null, false, Os::unknown],
            ['com.microsoft.office.outlook', true, 'outlook', false, null, false, Os::unknown],
            ['com.opera.gx', true, 'opera gx', false, null, false, Os::unknown],
            ['com.ksmobile.cb', true, 'cm browser', false, null, false, Os::unknown],
            ['com.android.chrome', true, 'chrome', false, null, false, Os::unknown],
            ['com.facebook.orca', true, 'facebook messenger app', false, null, false, Os::unknown],
            ['jp.co.yahoo.android.yjtop', true, 'yahoo! japan', false, null, false, Os::unknown],
            ['com.instagram.android', true, 'instagram app', false, null, false, Os::unknown],
            ['com.microsoft.bingintl', true, 'bingsearch', false, null, false, Os::unknown],
            ['com.nhn.android.search', true, 'naver', false, null, false, Os::unknown],
            ['com.sina.weibo', true, 'weibo app', false, null, false, Os::unknown],
            ['com.opera.touch', true, 'opera touch', false, null, false, Os::unknown],
            ['org.mozilla.klar', true, 'firefox klar', false, null, false, Os::unknown],
            ['jp.co.fenrir.android.sleipnir', true, 'sleipnir', false, null, false, Os::unknown],
            ['de.gdata.mobilesecurityorange', true, 'g-data mobile security', false, null, false, Os::unknown],
            ['com.active.cleaner', true, 'active-cleaner', false, null, false, Os::unknown],
            ['com.aol.mobile.aolapp', true, 'aol-app', false, null, false, Os::unknown],
            ['com.appsinnova.android.keepclean', true, 'keep-clean', false, null, false, Os::unknown],
            ['com.ayoba.ayoba', true, 'ayoba-app', false, null, false, Os::unknown],
            ['com.cmcm.armorfly', true, 'armorfly-browser', false, null, false, Os::unknown],
            ['com.emporia.emporiaapprebuild', true, 'emporia-app', false, null, false, Os::unknown],
            ['com.espn.score_center', true, 'espn-app', false, null, false, Os::unknown],
            ['com.fancyclean.security.antivirus', true, 'fancy-security', false, null, false, Os::unknown],
            ['com.fsecure.ms.buhldata', true, 'wiso-internet-security', false, null, false, Os::unknown],
            ['com.fsecure.ms.darty', true, 'darty-securite', false, null, false, Os::unknown],
            ['com.fsecure.ms.dc', true, 'f-secure mobile security', false, null, false, Os::unknown],
            ['com.fsecure.ms.nifty', true, 'always safe security 24', false, null, false, Os::unknown],
            ['com.fsecure.ms.safe', true, 'f-secure safe', false, null, false, Os::unknown],
            ['com.fsecure.ms.saunalahti_m', true, 'elisa-turvapaketti', false, null, false, Os::unknown],
            ['com.fsecure.ms.swisscom.sa', true, 'swisscom-internet-security', false, null, false, Os::unknown],
            ['com.fsecure.ms.ziggo', true, 'ziggo-safe-online', false, null, false, Os::unknown],
            ['com.google.android.gms', true, 'google-play-services', false, null, false, Os::unknown],
            ['com.hld.anzenbokusu', true, 's-gallery', false, null, false, Os::unknown],
            ['com.hld.anzenbokusucal', true, 'calculator-photo', false, null, false, Os::unknown],
            ['com.hld.anzenbokusufake', true, 'calculator-hide', false, null, false, Os::unknown],
            ['com.hornet.android', true, 'hornet', false, null, false, Os::unknown],
            ['com.huawei.appmarket', true, 'huawei-app-gallery', false, null, false, Os::unknown],
            ['com.huawei.fastapp', true, 'huawei-quick-app-center', false, null, false, Os::unknown],
            ['com.huawei.hwsearch', true, 'huawei-petal-search', false, null, false, Os::unknown],
            ['com.amazon.webapps.gms.search', true, 'google-search', false, null, false, Os::unknown],
            ['com.andrewshu.android.reddit', true, 'reddit-is-fun', false, null, false, Os::unknown],
            ['com.andrewshu.android.redditdonation', true, 'reddit-is-fun', false, null, false, Os::unknown],
            ['com.jaumo', true, 'jaumo', false, null, false, Os::unknown],
            ['com.jaumo.prime', true, 'jaumo-prime', false, null, false, Os::unknown],
            ['com.jb.security', true, 'go-security', false, null, false, Os::unknown],
            ['com.lenovo.anyshare.gps', true, 'share-it', false, null, false, Os::unknown],
            ['com.michatapp.im', true, 'mi-chat-app', false, null, false, Os::unknown],
            ['com.michatapp.im.lite', true, 'mi-chat-lite', false, null, false, Os::unknown],
            ['com.noxgroup.app.security', true, 'nox-security', false, null, false, Os::unknown],
            ['com.rcplatform.livechat', true, 'tumile', false, null, false, Os::unknown],
            ['com.rs.explorer.filemanager', true, 'rs-file', false, null, false, Os::unknown],
            ['com.skout.android', true, 'skout', false, null, false, Os::unknown],
            ['com.sony.nfx.app.sfrc', true, 'news-suite-by-sony', false, null, false, Os::unknown],
            ['com.surfshark.vpnclient.android', true, 'surfshark-app', false, null, false, Os::unknown],
            ['com.swisscows.search', true, 'swisscows-private-search', false, null, false, Os::unknown],
            ['com.tinder', true, 'tinder-app', false, null, false, Os::unknown],
            ['com.totalav.android', true, 'total-av-mobile-security', false, null, false, Os::unknown],
            ['com.turtc', true, 'türkiye-milli-arama-motoru', false, null, false, Os::unknown],
            ['mark.via.gp', true, 'via-browser', false, null, false, Os::unknown],
            ['com.kiwibrowser.browser', true, 'kiwi', false, null, false, Os::unknown],
            ['com.brave.browser', true, 'brave', false, null, false, Os::unknown],
            ['org.mozilla.focus', true, 'firefox focus', false, null, false, Os::unknown],
            ['com.vivaldi.browser', true, 'vivaldi', false, null, false, Os::unknown],
            ['com.aloha.browser', true, 'aloha-browser', false, null, false, Os::unknown],
            ['com.cloudmosa.puffinFree', true, 'puffin', false, null, false, Os::unknown],
            ['com.ucmobile.intl', true, 'ucbrowser', false, null, false, Os::unknown],
            ['com.tvwebbrowser.v22', true, 'tv-browser-internet', false, null, false, Os::unknown],
            ['com.udicorn.proxy', true, 'blue-proxy', false, null, false, Os::unknown],
            ['com.ume.browser.cust', true, 'ume-browser', false, null, false, Os::unknown],
            ['com.v2.vpn.security.free', true, 'fast-unlimited-vpn', false, null, false, Os::unknown],
            ['com.videochat.livu', true, 'livu-app', false, null, false, Os::unknown],
            ['com.wiseplay', true, 'wiseplay', false, null, false, Os::unknown],
            ['com.yahoo.onesearch', true, 'yahoo-onesearch', false, null, false, Os::unknown],
            ['com.yy.hiyo', true, 'hago-app', false, null, false, Os::unknown],
            ['de.baumann.browser', true, 'foss-browser', false, null, false, Os::unknown],
            ['free.vpn.unblock.proxy.vpnmonster', true, 'vpn-monster', false, null, false, Os::unknown],
            ['io.metamask', true, 'meta-mask', false, null, false, Os::unknown],
            ['it.ideasolutions.kyms', true, 'kyms', false, null, false, Os::unknown],
            ['it.tolelab.fvd', true, 'free-video-downloader', false, null, false, Os::unknown],
            ['com.snapchat.android', true, 'snapchat app', false, null, false, Os::unknown],
            ['jp.gocro.smartnews.android', true, 'smart-news-app', false, null, false, Os::unknown],
            ['kik.android', true, 'kik', false, null, false, Os::unknown],
            ['com.hisense.odinbrowser', true, 'odin-browser', false, null, false, Os::unknown],
            ['org.quantumbadger.redreader', true, 'red-reader', false, null, false, Os::unknown],
            ['phone.cleaner.antivirus.speed.booster', true, 'phone-clean', false, null, false, Os::unknown],
            ['reactivephone.msearch', true, 'smart-search-web-browser', false, null, false, Os::unknown],
            ['secure.explorer.web.browser', true, 'browser lite', false, null, false, Os::unknown],
            ['snapu2b.com', true, 'snapu2b', false, null, false, Os::unknown],
            ['pi.browser', true, 'pi browser', false, null, false, Os::unknown],
            ['alohabrowser', true, 'aloha-browser', false, null, false, Os::unknown],
            ['org.telegram.messenger', true, 'telegram-app', false, null, false, Os::unknown],
            ['xbrowser', true, 'x-browser', false, null, false, Os::unknown],
            ['com.xbrowser.play', true, 'x-browser', false, null, false, Os::unknown],
            ['com.mycompany.app.soulbrowser', true, 'soul-browser', false, null, false, Os::unknown],
            ['com.sec.android.app.sbrowser.lite', true, 'samsung-browser-lite', false, null, false, Os::unknown],
            ['jp.ddo.pigsty.HabitBrowser', true, 'habit-browser', false, null, false, Os::unknown],
            ['com.mi.globalbrowser.mini', true, 'mint browser', false, null, false, Os::unknown],
            ['me.webalert', true, 'web-alert-app', false, null, false, Os::unknown],
            ['com.pure.mini.browser', true, 'mini-web-browser', false, null, false, Os::unknown],
            ['acr.browser.raisebrowserfull', true, 'raise-fast-browser', false, null, false, Os::unknown],
            ['com.Fast.BrowserUc.lite', true, 'fast-browser-uc-lite', false, null, false, Os::unknown],
            ['acr.browser.barebones', true, 'lightning-browser', false, null, false, Os::unknown],
            ['anar.app.darkweb', true, 'dark-web-browser', false, null, false, Os::unknown],
            ['com.cake.browser', true, 'cake-browser', false, null, false, Os::unknown],
            ['com.iebrowser.fast', true, 'ie-browser-fast', false, null, false, Os::unknown],
            ['info.sunista.app', true, 'sanista-persian-instagram', false, null, false, Os::unknown],
            ['com.instapro.app', true, 'insta-pro', false, null, false, Os::unknown],
            ['com.kakao.talk', true, 'kakaotalk', false, null, false, Os::unknown],
            ['acr.browser.linxy', true, 'vegas-browser', false, null, false, Os::unknown],
            ['com.oh.bro', true, 'oh-browser', false, null, false, Os::unknown],
            ['com.oh.brop', true, 'oh-private-browser', false, null, false, Os::unknown],
            ['net.onecook.browser', true, 'stargon-browser', false, null, false, Os::unknown],
            ['phx.hot.browser', true, 'anka-browser', false, null, false, Os::unknown],
            ['org.torproject.android', true, 'orbot', false, null, false, Os::unknown],
            ['web.browser.dragon', true, 'dragon-browser', false, null, false, Os::unknown],
            ['org.easyweb.browser', true, 'easy-browser', false, null, false, Os::unknown],
            ['com.sharkeeapp.browser', true, 'sharkee-browser', false, null, false, Os::unknown],
            ['com.mobiu.browser', true, 'lark-browser', false, null, false, Os::unknown],
            ['com.qflair.browserq', true, 'pluma-browser', false, null, false, Os::unknown],
            ['com.noxgroup.app.browser', true, 'nox-browser', false, null, false, Os::unknown],
            ['com.jio.web', true, 'jio-sphere', false, null, false, Os::unknown],
            ['com.cookiegames.smartcookie', true, 'smartcookieweb-privacy-browser', false, null, false, Os::unknown],
            ['org.lineageos.jelly', true, 'jelly-browser', false, null, true, Os::lineageos],
            ['com.oceanhero.search', true, 'ocean-hero-app', false, null, false, Os::unknown],
            ['com.oryon.multitasking', true, 'multitasking-app', false, null, false, Os::unknown],
            ['net.fast.web.browser', true, 'web-browser-web-explorer', false, null, false, Os::unknown],
            ['com.bestvideodownloader.newvideodownloader', true, 'all-video-downloader', false, null, false, Os::unknown],
            ['com.yiyinkuang.searchboard', true, 'search+-for-google', false, null, false, Os::unknown],
            ['com.aeroinsta.android', true, 'aero-insta', false, null, false, Os::unknown],
            ['com.cliqz.browser', true, 'cliqz-browser', false, null, false, Os::unknown],
            ['com.appssppa.idesktoppcbrowser', true, 'idesktop-pc-browser', false, null, false, Os::unknown],
            ['com.sec.app.samsungprintservice', true, 'samsung-print-service-plugin', false, null, false, Os::unknown],
            ['jp.co.canon.bsd.ad.pixmaprint', true, 'canon-print', false, null, false, Os::unknown],
            ['com.gl9.cloudBrowser', true, 'surfbrowser', false, null, false, Os::unknown],
            ['com.kaweapp.webexplorer', true, 'web-explorer', false, null, false, Os::unknown],
            ['com.snaptube.premium', true, 'snap-tube', false, null, false, Os::unknown],
            ['com.eagle.web.browser.internet.privacy.browser', true, 'private-browser-web-browser', false, null, false, Os::unknown],
            ['com.cleanmaster.security', true, 'cm-security', false, null, false, Os::unknown],
            ['devian.tubemate.v3', true, 'tube-mate', false, null, false, Os::unknown],
            ['de.einsundeins.searchapp.gmx.com', true, 'gmx-search', false, null, false, Os::unknown],
            ['acr.browser.lightning', true, 'lightning-browser', false, null, false, Os::unknown],
            ['acr.browser.lightning2', true, 'lightning-browser', false, null, false, Os::unknown],
            ['acr.browser.lightningq16w', true, 'lightning-browser', false, null, false, Os::unknown],
            ['com.web_view_mohammed.ad.webview_app', true, 'appso', false, null, false, Os::unknown],
            ['com.fsecure.ms.netcologne', true, 'sicherheitspaket', false, null, false, Os::unknown],
            ['de.telekom.mail', true, 'telekom-mail', false, null, false, Os::unknown],
            ['ai.blokee.browser.android', true, 'bloket-browser', false, null, false, Os::unknown],
            ['com.ume.browser.euas', true, 'ume-browser', false, null, false, Os::unknown],
            ['com.ume.browser.bose', true, 'ume-browser', false, null, false, Os::unknown],
            ['com.ume.browser.international', true, 'ume-browser', false, null, false, Os::unknown],
            ['com.ume.browser.latinamerican', true, 'ume-browser', false, null, false, Os::unknown],
            ['com.ume.browser.mexicotelcel', true, 'ume-browser', false, null, false, Os::unknown],
            ['com.ume.browser.venezuelavtelca', true, 'ume-browser', false, null, false, Os::unknown],
            ['com.ume.browser.northamerica', true, 'ume-browser', false, null, false, Os::unknown],
            ['com.ume.browser.newage', true, 'ume-browser', false, null, false, Os::unknown],
            ['com.wolvesinteractive.racinggo', true, 'racing-go', false, null, false, Os::unknown],
            ['com.microsoft.amp.apps.bingnews', true, 'microsoft-start', false, null, false, Os::unknown],
            ['com.litepure.browser.gp', true, 'pure-browser', false, null, false, Os::unknown],
            ['com.boatbrowser.free', true, 'boat-browser', false, null, false, Os::unknown],
            ['com.brother.mfc.brprint', true, 'brother-iprint-scan', false, null, false, Os::unknown],
            ['com.emoticon.screen.home.launcher', true, 'in-launcher', false, null, false, Os::unknown],
            ['com.explore.web.browser', true, 'web-browser-explorer', false, null, false, Os::unknown],
            ['com.emporia.browser', true, 'emporia-app', false, null, false, Os::unknown],
            ['de.telekom.epub', true, 'pageplace-reader', false, null, false, Os::unknown],
            ['com.appsverse.photon', true, 'photon-browser', false, null, false, Os::unknown],
            ['com.dolphin.browser.zero', true, 'dolfin-zero', false, null, false, Os::unknown],
            ['com.stoutner.privacybrowser.standard', true, 'stoutner-privacy-browser', false, null, false, Os::unknown],
            ['com.skype.raider', true, 'skype', false, null, false, Os::unknown],
            ['de.gdata.mobilesecurity2b', true, 'tie-team-mobile-security', false, null, false, Os::unknown],
            ['de.freenet.mail', true, 'freenet-mail', false, null, false, Os::unknown],
            ['com.transsion.phoenix', true, 'phoenix browser', false, null, false, Os::unknown],
            ['com.startpage', true, 'startpage-private-search-engine', false, null, false, Os::unknown],
            ['jp.hazuki.yuzubrowser', true, 'yuzu-browser', false, null, false, Os::unknown],
            ['net.dezor.browser', true, 'dezor-browser', false, null, false, Os::unknown],
            ['com.go.browser', true, 'go-browser', false, null, false, Os::unknown],
            ['com.dv.adm', true, 'advanced-download-manager', false, null, false, Os::unknown],
            ['com.androidbull.incognito.browser', true, 'incognito-browser', false, null, false, Os::unknown],
            ['com.symantec.mobile.idsafe', true, 'norton-password-manager', false, null, false, Os::unknown],
            ['com.lge.snappage', true, 'snap-page', false, null, false, Os::unknown],
            ['com.morrisxar.nav88', true, 'office-browser', false, null, false, Os::unknown],
            ['epson.print', true, 'epson-iprint', false, null, false, Os::unknown],
            ['miada.tv.webbrowser', true, 'internet-web-browser', false, null, false, Os::unknown],
            ['threads.thor', true, 'thor-browser', false, null, false, Os::unknown],
            ['com.opera.browser', true, 'opera', false, null, false, Os::unknown],
            ['com.opera.browser.afin', true, 'opera', false, null, false, Os::unknown],
            ['com.startpage.mobile', true, 'startpage-private-search-engine', false, null, false, Os::unknown],
            ['ace.avd.tube.video.downloader', true, 'free-video-downloader-pro', false, null, false, Os::unknown],
            ['com.catdaddy.cat22', true, 'wwe-supercard', false, null, false, Os::unknown],
            ['com.jlwf.droid.tutu', true, 'tutu-app', false, null, false, Os::unknown],
            ['com.tct.launcher', true, 'joy-launcher', false, null, false, Os::unknown],
            ['com.baidu.searchbox', true, 'baidu box app', false, null, false, Os::unknown],
            ['de.eue.mobile.android.mail', true, 'einsundeins-mail', false, null, false, Os::unknown],
            ['com.wfeng.droid.tutu', true, 'tutu-app', false, null, false, Os::unknown],
            ['com.honor.global', true, 'honor-store', false, null, false, Os::unknown],
            ['com.finimize.oban', true, 'finimize', false, null, false, Os::unknown],
            ['com.myhomescreen.weather', true, 'weather-home', false, null, false, Os::unknown],
            ['hot.fiery.browser', true, 'fiery-browser', false, null, false, Os::unknown],
            ['de.gmx.mobile.android.mail', true, 'gmx-mail', false, null, false, Os::unknown],
            ['de.twokit.castbrowser', true, 'tv-cast', false, null, false, Os::unknown],
            ['de.twokit.castbrowser.pro', true, 'tv-cast-pro', false, null, false, Os::unknown],
            ['com.esaba.downloader', true, 'downloader', false, null, false, Os::unknown],
            ['com.agilebits.onepassword', true, '1password', false, null, false, Os::unknown],
            ['com.browser2345_ucc', true, '2345 browser', false, null, false, Os::unknown],
            ['com.browser2345hd', true, '2345-browser-hd', false, null, false, Os::unknown],
            ['air.stage.web.view', true, 'adobe air', false, null, false, Os::unknown],
            ['air.stagewebview', true, 'adobe air', false, null, false, Os::unknown],
            ['air.StageWebViewBridgeTest.debug', true, 'adobe air', false, null, false, Os::unknown],
            ['air.StageWebViewVideo.debug', true, 'adobe air', false, null, false, Os::unknown],
            ['com.adobe.phonegap.app', true, 'adobe-phonegap', false, null, false, Os::unknown],
            ['com.adobe.reader', true, 'adobe-reader', false, null, false, Os::unknown],
            ['com.doro.apps.browser', true, 'doro-browser', false, null, false, Os::unknown],
            ['de.einsundeins.searchapp.web', true, 'web.de-search', false, null, false, Os::unknown],
            ['com.droidlogic.mboxlauncher', true, 'mbox-launcher', false, null, false, Os::unknown],
            ['com.droidlogic.xlauncher', true, 'x-launcher', false, null, false, Os::unknown],
            ['com.baidu.browser.apps', true, 'baidu browser', false, null, false, Os::unknown],
            ['com.hihonor.baidu.browser', true, 'honor-browser', false, null, false, Os::unknown],
            ['com.baidu.searchbox.lite', true, 'baidu box app lite', false, null, false, Os::unknown],
            ['com.microsoft.copilot', true, 'microsoft-copilot', false, null, false, Os::unknown],
            ['de.web.mobile.android.mail', true, 'web.de mail', false, null, false, Os::unknown],
            ['com.readly.client', true, 'readly-app', false, null, false, Os::unknown],
            ['com.gbox.android.helper', true, 'gbox-helper', false, null, false, Os::unknown],
            ['com.samsung.android.email.provider', true, 'samsung-email', false, null, false, Os::unknown],
            ['it.italiaonline.mail', true, 'libero-mail', false, null, false, Os::unknown],
            ['webexplorer.amazing.speed', true, 'web-browser-explorer', false, null, false, Os::unknown],
            ['nu.tommie.inbrowser', true, 'in-browser', false, null, false, Os::unknown],
            ['com.massimple.nacion.gcba.es', true, 'plus-simple-browser', false, null, false, Os::unknown],
            ['com.massimple.nacion.parana.es', true, 'plus-simple-browser', false, null, false, Os::unknown],
            ['every.browser.inc', true, 'every-browser', false, null, false, Os::unknown],
            ['com.til.timesnews', true, 'news-point', false, null, false, Os::unknown],
            ['com.omshyapps.vpn', true, 'omshy-vpn', false, null, false, Os::unknown],
            ['com.sharekaro.app', true, 'sharekaro', false, null, false, Os::unknown],
            ['com.transsion.itel.launcher', true, 'itel-os-launcher', false, null, false, Os::unknown],
            ['com.cleanmaster.mguard', true, 'clean-master', false, null, false, Os::unknown],
            ['com.cleanmaster.mguard.huawei', true, 'clean-master', false, null, false, Os::unknown],
            ['com.larus.wolf', true, 'cici', false, null, false, Os::unknown],
            ['com.kuto.vpn', true, 'kuto-vpn', false, null, false, Os::unknown],
            ['com.microsoft.math', true, 'microsoft-math', false, null, false, Os::unknown],
            ['com.google.android.apps.maps', true, 'google-maps', false, null, false, Os::unknown],
            ['com.phlox.tvwebbrowser', true, 'tv-bro', false, null, false, Os::unknown],
            ['com.transsion.XOSLauncher', true, 'xos-launcher', false, null, false, Os::unknown],
            ['com.infinix.xshare', true, 'xshare', false, null, false, Os::unknown],
            ['com.xshare.sharefiles1', true, 'xshare', false, null, false, Os::unknown],
            ['com.transsion.magicshow', true, 'visha', false, null, false, Os::unknown],
            ['com.awesapp.isp', true, 'isafeplay', false, null, false, Os::unknown],
            ['com.anydesk.anydeskandroid', true, 'anydesk-remote-desktop', false, null, false, Os::unknown],
            ['com.palmteam.imagesearch', true, 'search-by-image', false, null, false, Os::unknown],
            ['castify.roku', true, 'cast-web-videos', false, null, false, Os::unknown],
            ['za.co.tracker.consumer', true, 'tracker-connect', false, null, false, Os::unknown],
            ['nu.bi.moya', true, 'moyaapp', false, null, false, Os::unknown],
            ['com.tradron.hdvideodownloader', true, 'download-hub', false, null, false, Os::unknown],
            ['com.box.video.downloader', true, 'box-video-downloader', false, null, false, Os::unknown],
            ['com.sec.android.app.sbrowser', true, 'samsungbrowser', false, null, false, Os::unknown],
            ['com.opera.mini.native.beta', true, 'opera mini beta', false, null, false, Os::unknown],
            ['com.yandex.browser', true, 'yabrowser', false, null, false, Os::unknown],
            ['org.mozilla.firefox', true, 'firefox', false, null, false, Os::unknown],
            ['com.tv.browser.open', true, 'open-tv-browser', false, null, false, Os::unknown],
            ['com.logicui.tvbrowser2', true, 'logicui-tv-browser', false, null, false, Os::unknown],
            ['com.internet.tvbrowser', true, 'browser-app-browser', false, null, false, Os::unknown],
            ['com.sweep.cleaner.trash.junk', true, 'sweep-cleaner', false, null, false, Os::unknown],
            ['com.flatfish.cal.privacy', true, 'hidex-calculator-photo-vault', false, null, false, Os::unknown],
            ['com.myhomescreen.news', true, 'news-home', false, null, false, Os::unknown],
            ['com.myhomescreen.fitness', true, 'fit-home', false, null, false, Os::unknown],
            ['com.fsecure.ms.talktalksa', true, 'talktalk-supersafe', false, null, false, Os::unknown],
            ['com.fsecure.ms.actshield', true, 'act-shield', false, null, false, Os::unknown],
            ['com.fsecure.ms.kpn.veilig', true, 'veilig-virusscanner', false, null, false, Os::unknown],
            ['com.twitter.android', true, 'twitter app', false, null, false, Os::unknown],
            ['com.seraphic.openinet.pre', true, 'metax-open-browser', false, null, false, Os::unknown],
            ['org.telegram.messenger.web', true, 'telegram-app', false, null, false, Os::unknown],
            ['com.android.media.module.services', true, 'mediaservices-apk', false, null, false, Os::unknown],
            ['mojeek.app', true, 'mojeek-app', false, null, false, Os::unknown],
            ['com.castify', true, 'cast-to-tv-plus', false, null, false, Os::unknown],
            ['com.stickypassword.android', true, 'sticky-password', false, null, false, Os::unknown],
            ['com.qihoo.security', true, '360-security', false, null, false, Os::unknown],
            ['com.nytimes.crossword', true, 'nytimes-crossword', false, null, false, Os::unknown],
            ['com.aospstudio.tvsearch', true, 'neptune-tv-browser', false, null, false, Os::unknown],
            ['com.playit.videoplayer', true, 'play-it', false, null, false, Os::unknown],
            ['com.repotools.whatplay', true, 'what-play', false, null, false, Os::unknown],
            ['com.instabridge.android', true, 'insta-bridge', false, null, false, Os::unknown],
            ['com.antivirus.master.cmsecurity', true, 'cm-security', false, null, false, Os::unknown],
            ['com.nocardteam.nocardvpn.lite', true, 'no-card-lite', false, null, false, Os::unknown],
            ['com.nocardteam.nocardvpn', true, 'no-card', false, null, false, Os::unknown],
            ['com.ezt.vpn', true, 'ez-vpn', false, null, false, Os::unknown],
            ['net.daum.android.daum', true, 'daum-app', false, null, false, Os::unknown],
            ['com.fsecure.ms.sonera', true, 'telia-turvapaketti', false, null, false, Os::unknown],
            ['com.fsecure.ms.sfr', true, 'sfr-securite', false, null, false, Os::unknown],
            ['com.fsecure.ms.upc.ch', true, 'upc-internet-security', false, null, false, Os::unknown],
            ['com.fsecure.ms.dnafi', true, 'dna-digiturva', false, null, false, Os::unknown],
            ['com.nate.android.portalmini', true, 'nate-app', false, null, false, Os::unknown],
            ['com.bigqsys.photosearch.searchbyimage2020', true, 'photo-search-app', false, null, false, Os::unknown],
            ['com.qjy.browser', true, 'qjy-tv-browser', false, null, false, Os::unknown],
            ['com.myhomescreen.messenger.home.emoji.lite', true, 'messenger-lite', false, null, false, Os::unknown],
            ['com.myhomescreen.access', true, 'big-keyboard', false, null, false, Os::unknown],
            ['com.myhomescreen.email', true, 'email-home', false, null, false, Os::unknown],
            ['com.myhomescreen.sms', true, 'messenger-home', false, null, false, Os::unknown],
            ['io.bluewallet.bluewallet', true, 'blue-wallet', false, null, false, Os::unknown],
            ['com.bifrostwallet.app', true, 'bifrost-wallet', false, null, false, Os::unknown],
            ['com.tt.android.dm.view', true, 'download-manager', false, null, false, Os::unknown],
            ['com.wukongtv.wkcast.intl', true, 'quick-cast-app', false, null, false, Os::unknown],
            ['mobi.deallauncher.coupons.shopping', true, 'coupons-promo-codes', false, null, false, Os::unknown],
            ['idm.video.free', true, 'idm-video-download-manager', false, null, false, Os::unknown],
            ['de.twokit.video.tv.cast.browser.samsung', true, 'tv-cast', false, null, false, Os::unknown],
            ['de.twokit.video.tv.cast.browser.lg', true, 'tv-cast', false, null, false, Os::unknown],
            ['de.twokit.video.tv.cast.browser.firetv', true, 'tv-cast', false, null, false, Os::unknown],
            ['de.twokit.castbrowsernexusplayer', true, 'tv-cast', false, null, false, Os::unknown],
            ['com.tuya.smartlife', true, 'smart-life', false, null, false, Os::unknown],
            ['com.waze', true, 'waze-navigation', false, null, false, Os::unknown],
            ['com.transsion.hilauncher', true, 'hios-launcher', false, null, false, Os::unknown],
            ['com.opera.app.news', true, 'opera news', false, null, false, Os::unknown],
            ['com.reddit.frontpage', true, 'reddit-app', false, null, false, Os::unknown],
            ['com.harshad.someto', true, 'social-media-explorer', false, null, false, Os::unknown],
            ['com.tcl.live', true, 'tcl-live', false, null, false, Os::unknown],
            ['com.thinkfree.searchbyimage', true, 'reverse-image-search', false, null, false, Os::unknown],
            ['hippeis.com.photochecker', true, 'photo-sherlock', false, null, false, Os::unknown],
            ['hesoft.T2S', true, 't2s-app', false, null, false, Os::unknown],
            ['com.zeebusiness.news', true, 'zee-business', false, null, false, Os::unknown],
            ['com.netflix.mediaclient', true, 'netflix-app', false, null, false, Os::unknown],
            ['com.oxoo.kinogo', true, 'kinogo.ge', false, null, false, Os::unknown],
            ['ir.ilmili.telegraph', true, 'graph-messenger', false, null, false, Os::unknown],
            ['the.best.gram', true, 'bestgram', false, null, false, Os::unknown],
            ['org.aka.lite', true, 'aka-lite', false, null, false, Os::unknown],
            ['org.aka.messenger', true, 'aka', false, null, false, Os::unknown],
            ['com.saf.seca', true, 'search-craft', false, null, false, Os::unknown],
            ['com.fsecure.ms.teliasweden', true, 'telia-trygg', false, null, false, Os::unknown],
            ['com.gener8ads.wallet', true, 'gener8-browser', false, null, false, Os::unknown],
            ['com.jambo', true, 'jambo', false, null, false, Os::unknown],
            ['no.wifi.offline.games.puzzle.games', true, 'offline all in one', false, null, false, Os::unknown],
            ['webexplorer.amazing.biro', true, 'internet-browser', false, null, false, Os::unknown],
            ['com.xbh.universal.player', true, 'universal-player', false, null, false, Os::unknown],
            ['com.mobile.applock.wt', true, 'app-lock', false, null, false, Os::unknown],
            ['com.solide.filemanager.lte', true, 'solid-file-manager', false, null, false, Os::unknown],
            ['com.lechneralexander.privatebrowser', true, 'private-internet-browser', false, null, false, Os::unknown],
            ['com.moonshot.kimichat', true, 'kimi-app', false, null, false, Os::unknown],
            ['com.deepseek.chat', true, 'deepseek-app', false, null, false, Os::unknown],
            ['com.chainapsis.keplr', true, 'keplr-app', false, null, false, Os::unknown],
            ['com.viber.voip', true, 'viber-app', false, null, false, Os::unknown],
            ['com.fsecure.ms.voo', true, 'vis+ app', false, null, false, Os::unknown],
            ['com.fsecure.ms.fnac', true, 'ma protection app', false, null, false, Os::unknown],
            ['com.wecloud.lookr', true, 'lookr-app', false, null, false, Os::unknown],
            ['com.canopy.vpn.filter.parent', true, 'canopy-app', false, null, false, Os::unknown],
            ['ai.mainfunc.genspark', true, 'genspark-app', false, null, false, Os::unknown],
        ];
    }
}
