<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
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
    public function testData(
        string $ua,
        bool $hasClientInfo,
        string | null $clientCode,
        bool $hasClientVersion,
        string | null $clientVersion,
    ): void {
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
        self::assertSame(
            $hasClientVersion,
            $header->hasClientVersion(),
            sprintf('browser info mismatch for ua "%s"', $ua),
        );
        self::assertSame(
            $clientVersion,
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
            ['com.browser2345', true, '2345 browser', true, null],
            ['this.is.a.fake.id.to.test.unknown.ids', false, null, false, null],
            ['me.android.browser', true, 'me browser', true, null],
            ['com.android.browser', true, 'android webview', true, null],
            ['com.mx.browser', true, 'maxthon', true, null],
            ['mobi.mgeek.TunnyBrowser', true, 'dolfin', true, null],
            ['com.tencent.mm', true, 'wechat app', true, null],
            ['com.asus.browser', true, 'asus browser', true, null],
            ['com.UCMobile.lab', true, 'ucbrowser', true, null],
            ['com.oupeng.browser', true, 'oupeng browser', true, null],
            ['com.lenovo.browser', true, 'lenovo browser', true, null],
            ['derek.iSurf', true, 'isurf', true, null],
            ['com.aliyun.mobile.browser', true, 'aliyun-browser', true, null],
            ['XMLHttpRequest', false, null, false, null],
            ['com.tinyspeck.chatlyio', true, 'chatlyio app', true, null],
            ['com.douban.group', true, 'douban app', true, null],
            ['com.linkedin', true, 'linkedinbot', true, null],
            ['com.google.android.apps.magazines', true, 'google play newsstand', true, null],
            ['com.google.googlemobile', true, 'google mobile app', true, null],
            ['com.google.android.youtube', true, 'youtube app', true, null],
            ['com.apple.mobilenotes', true, 'apple mobilenotes', true, null],
            ['com.apple.notes', true, 'apple notes app', true, null],
            ['com.google.googleplus', true, 'google+ app', true, null],
            ['com.apple.webkit', true, 'apple webkit service', true, null],
            ['com.duckduckgo.mobile.android', true, 'duckduck app', true, null],
            ['com.opera.mini.native', true, 'opera mini', true, null],
            ['com.google.android.apps.searchlite', true, 'google search lite', true, null],
            ['com.facebook.katana', true, 'facebook app', true, null],
            ['com.huawei.browser', true, 'huawei-browser', true, null],
            ['com.huawei.search', true, 'hi-search', true, null],
            ['com.microsoft.bing', true, 'bingsearch', true, null],
            ['com.microsoft.office.outlook', true, 'outlook', true, null],
            ['com.opera.gx', true, 'opera gx', true, null],
            ['com.ksmobile.cb', true, 'cm browser', true, null],
            ['com.android.chrome', true, 'chrome', true, null],
            ['com.facebook.orca', true, 'facebook messenger app', true, null],
            ['jp.co.yahoo.android.yjtop', true, 'yahoo! app', true, null],
            ['com.instagram.android', true, 'instagram app', true, null],
            ['com.microsoft.bingintl', true, 'bingsearch', true, null],
            ['com.nhn.android.search', true, 'naver', true, null],
            ['com.sina.weibo', true, 'weibo app', true, null],
            ['com.opera.touch', true, 'opera touch', true, null],
            ['org.mozilla.klar', true, 'firefox klar', true, null],
            ['jp.co.fenrir.android.sleipnir', true, 'sleipnir', true, null],
            ['de.gdata.mobilesecurityorange', true, 'g-data mobile security', true, null],
            ['com.active.cleaner', true, 'active-cleaner', true, null],
            ['com.aol.mobile.aolapp', true, 'aol-app', true, null],
            ['com.appsinnova.android.keepclean', true, 'keep-clean', true, null],
            ['com.ayoba.ayoba', true, 'ayoba-app', true, null],
            ['com.cmcm.armorfly', true, 'armorfly-browser', true, null],
            ['com.emporia.emporiaapprebuild', true, 'emporia-app', true, null],
            ['com.espn.score_center', true, 'espn-app', true, null],
            ['com.fancyclean.security.antivirus', true, 'fancy-security', true, null],
            ['com.fsecure.ms.buhldata', true, 'wiso-internet-security', true, null],
            ['com.fsecure.ms.darty', true, 'darty-securite', true, null],
            ['com.fsecure.ms.dc', true, 'f-secure mobile security', true, null],
            ['com.fsecure.ms.nifty', true, 'always safe security 24', true, null],
            ['com.fsecure.ms.safe', true, 'f-secure safe', true, null],
            ['com.fsecure.ms.saunalahti_m', true, 'elisa-turvapaketti', true, null],
            ['com.fsecure.ms.swisscom.sa', true, 'swisscom-internet-security', true, null],
            ['com.fsecure.ms.ziggo', true, 'ziggo-safe-online', true, null],
            ['com.google.android.gms', true, 'google-play-services', true, null],
            ['com.hld.anzenbokusu', true, 's-gallery', true, null],
            ['com.hld.anzenbokusucal', true, 'calculator-photo', true, null],
            ['com.hld.anzenbokusufake', true, 'calculator-hide', true, null],
            ['com.hornet.android', true, 'hornet', true, null],
            ['com.huawei.appmarket', true, 'huawei-app-gallery', true, null],
            ['com.huawei.fastapp', true, 'huawei-quick-app-center', true, null],
            ['com.huawei.hwsearch', true, 'huawei-petal-search', true, null],
            ['com.amazon.webapps.gms.search', true, 'google-search', true, null],
            ['com.andrewshu.android.reddit', true, 'reddit-is-fun', true, null],
            ['com.andrewshu.android.redditdonation', true, 'reddit-is-fun', true, null],
            ['com.jaumo', true, 'jaumo', true, null],
            ['com.jaumo.prime', true, 'jaumo-prime', true, null],
            ['com.jb.security', true, 'go-security', true, null],
            ['com.lenovo.anyshare.gps', true, 'share-it', true, null],
            ['com.michatapp.im', true, 'mi-chat-app', true, null],
            ['com.michatapp.im.lite', true, 'mi-chat-lite', true, null],
            ['com.noxgroup.app.security', true, 'nox-security', true, null],
            ['com.rcplatform.livechat', true, 'tumile', true, null],
            ['com.rs.explorer.filemanager', true, 'rs-file', true, null],
            ['com.skout.android', true, 'skout', true, null],
            ['com.sony.nfx.app.sfrc', true, 'news-suite-by-sony', true, null],
            ['com.surfshark.vpnclient.android', true, 'surfshark-app', true, null],
            ['com.swisscows.search', true, 'swisscows-private-search', true, null],
            ['com.tinder', true, 'tinder-app', true, null],
            ['com.totalav.android', true, 'total-av-mobile-security', true, null],
            ['com.turtc', true, 'türkiye-milli-arama-motoru', true, null],
            ['mark.via.gp', true, 'via-browser', true, null],
            ['com.kiwibrowser.browser', true, 'kiwi', true, null],
            ['com.brave.browser', true, 'brave', true, null],
            ['org.mozilla.focus', true, 'firefox focus', true, null],
            ['com.vivaldi.browser', true, 'vivaldi', true, null],
            ['com.aloha.browser', true, 'aloha-browser', true, null],
            ['com.cloudmosa.puffinFree', true, 'puffin', true, null],
            ['com.ucmobile.intl', true, 'ucbrowser', true, null],
            ['com.tvwebbrowser.v22', true, 'tv-browser-internet', true, null],
            ['com.udicorn.proxy', true, 'blue-proxy', true, null],
            ['com.ume.browser.cust', true, 'ume-browser', true, null],
            ['com.v2.vpn.security.free', true, 'fast-unlimited-vpn', true, null],
            ['com.videochat.livu', true, 'livu-app', true, null],
            ['com.wiseplay', true, 'wiseplay', true, null],
            ['com.yahoo.onesearch', true, 'yahoo-onesearch', true, null],
            ['com.yy.hiyo', true, 'hago-app', true, null],
            ['de.baumann.browser', true, 'foss-browser', true, null],
            ['free.vpn.unblock.proxy.vpnmonster', true, 'vpn-monster', true, null],
            ['io.metamask', true, 'meta-mask', true, null],
            ['it.ideasolutions.kyms', true, 'kyms', true, null],
            ['it.tolelab.fvd', true, 'free-video-downloader', true, null],
            ['com.snapchat.android', true, 'snapchat app', true, null],
            ['jp.gocro.smartnews.android', true, 'smart-news-app', true, null],
            ['kik.android', true, 'kik', true, null],
            ['com.hisense.odinbrowser', true, 'odin-browser', true, null],
            ['org.quantumbadger.redreader', true, 'red-reader', true, null],
            ['phone.cleaner.antivirus.speed.booster', true, 'phone-clean', true, null],
            ['reactivephone.msearch', true, 'smart-search-web-browser', true, null],
            ['secure.explorer.web.browser', true, 'browser lite', true, null],
            ['snapu2b.com', true, 'snapu2b', true, null],
            ['pi.browser', true, 'pi browser', true, null],
            ['alohabrowser', true, 'aloha-browser', true, null],
            ['org.telegram.messenger', true, 'telegram-app', true, null],
            ['xbrowser', true, 'x-browser', true, null],
            ['com.xbrowser.play', true, 'x-browser', true, null],
            ['com.mycompany.app.soulbrowser', true, 'soul-browser', true, null],
            ['com.sec.android.app.sbrowser.lite', true, 'samsung-browser-lite', true, null],
            ['jp.ddo.pigsty.HabitBrowser', true, 'habit-browser', true, null],
            ['com.mi.globalbrowser.mini', true, 'mint browser', true, null],
            ['me.webalert', true, 'web-alert-app', true, null],
            ['com.pure.mini.browser', true, 'mini-web-browser', true, null],
            ['acr.browser.raisebrowserfull', true, 'raise-fast-browser', true, null],
            ['com.Fast.BrowserUc.lite', true, 'fast-browser-uc-lite', true, null],
            ['acr.browser.barebones', true, 'lightning-browser', true, null],
            ['anar.app.darkweb', true, 'dark-web-browser', true, null],
            ['com.cake.browser', true, 'cake-browser', true, null],
            ['com.iebrowser.fast', true, 'ie-browser-fast', true, null],
            ['info.sunista.app', true, 'sanista-persian-instagram', true, null],
            ['com.instapro.app', true, 'insta-pro', true, null],
            ['com.kakao.talk', true, 'kakaotalk', true, null],
            ['acr.browser.linxy', true, 'vegas-browser', true, null],
            ['com.oh.bro', true, 'oh-browser', true, null],
            ['com.oh.brop', true, 'oh-private-browser', true, null],
            ['net.onecook.browser', true, 'stargon-browser', true, null],
            ['phx.hot.browser', true, 'anka-browser', true, null],
            ['org.torproject.android', true, 'orbot', true, null],
            ['web.browser.dragon', true, 'dragon-browser', true, null],
            ['org.easyweb.browser', true, 'easy-browser', true, null],
            ['com.sharkeeapp.browser', true, 'sharkee-browser', true, null],
            ['com.mobiu.browser', true, 'lark-browser', true, null],
            ['com.qflair.browserq', true, 'pluma-browser', true, null],
            ['com.noxgroup.app.browser', true, 'nox-browser', true, null],
            ['com.jio.web', true, 'jio-sphere', true, null],
            ['com.cookiegames.smartcookie', true, 'smartcookieweb-privacy-browser', true, null],
            ['org.lineageos.jelly', true, 'jelly-browser', true, null],
            ['com.oceanhero.search', true, 'ocean-hero-app', true, null],
            ['com.oryon.multitasking', true, 'multitasking-app', true, null],
            ['net.fast.web.browser', true, 'web-browser-web-explorer', true, null],
            ['com.bestvideodownloader.newvideodownloader', true, 'all-video-downloader', true, null],
            ['com.yiyinkuang.searchboard', true, 'search+-for-google', true, null],
            ['com.aeroinsta.android', true, 'aero-insta', true, null],
            ['com.cliqz.browser', true, 'cliqz-browser', true, null],
            ['com.appssppa.idesktoppcbrowser', true, 'idesktop-pc-browser', true, null],
            ['com.sec.app.samsungprintservice', true, 'samsung-print-service-plugin', true, null],
            ['jp.co.canon.bsd.ad.pixmaprint', true, 'canon-print', true, null],
            ['com.gl9.cloudBrowser', true, 'surfbrowser', true, null],
            ['com.kaweapp.webexplorer', true, 'web-explorer', true, null],
            ['com.snaptube.premium', true, 'snap-tube', true, null],
            ['com.eagle.web.browser.internet.privacy.browser', true, 'private-browser-web-browser', true, null],
            ['com.cleanmaster.security', true, 'cm-security', true, null],
            ['devian.tubemate.v3', true, 'tube-mate', true, null],
            ['de.einsundeins.searchapp.gmx.com', true, 'gmx-search', true, null],
            ['acr.browser.lightning', true, 'lightning-browser', true, null],
            ['acr.browser.lightning2', true, 'lightning-browser', true, null],
            ['acr.browser.lightningq16w', true, 'lightning-browser', true, null],
            ['com.web_view_mohammed.ad.webview_app', true, 'appso', true, null],
            ['com.fsecure.ms.netcologne', true, 'sicherheitspaket', true, null],
            ['de.telekom.mail', true, 'telekom-mail', true, null],
            ['ai.blokee.browser.android', true, 'bloket-browser', true, null],
            ['com.ume.browser.euas', true, 'ume-browser', true, null],
            ['com.ume.browser.bose', true, 'ume-browser', true, null],
            ['com.ume.browser.international', true, 'ume-browser', true, null],
            ['com.ume.browser.latinamerican', true, 'ume-browser', true, null],
            ['com.ume.browser.mexicotelcel', true, 'ume-browser', true, null],
            ['com.ume.browser.venezuelavtelca', true, 'ume-browser', true, null],
            ['com.ume.browser.northamerica', true, 'ume-browser', true, null],
            ['com.ume.browser.newage', true, 'ume-browser', true, null],
            ['com.wolvesinteractive.racinggo', true, 'racing-go', true, null],
            ['com.microsoft.amp.apps.bingnews', true, 'microsoft-start', true, null],
            ['com.litepure.browser.gp', true, 'pure-browser', true, null],
            ['com.boatbrowser.free', true, 'boat-browser', true, null],
            ['com.brother.mfc.brprint', true, 'brother-iprint-scan', true, null],
            ['com.emoticon.screen.home.launcher', true, 'in-launcher', true, null],
            ['com.explore.web.browser', true, 'web-browser-explorer', true, null],
            ['com.emporia.browser', true, 'emporia-app', true, null],
            ['de.telekom.epub', true, 'pageplace-reader', true, null],
            ['com.appsverse.photon', true, 'photon-browser', true, null],
            ['com.dolphin.browser.zero', true, 'dolfin-zero', true, null],
            ['com.stoutner.privacybrowser.standard', true, 'stoutner-privacy-browser', true, null],
            ['com.skype.raider', true, 'skype', true, null],
            ['de.gdata.mobilesecurity2b', true, 'tie-team-mobile-security', true, null],
            ['de.freenet.mail', true, 'freenet-mail', true, null],
            ['com.transsion.phoenix', true, 'phoenix browser', true, null],
            ['com.startpage', true, 'startpage-private-search-engine', true, null],
            ['jp.hazuki.yuzubrowser', true, 'yuzu-browser', true, null],
            ['net.dezor.browser', true, 'dezor-browser', true, null],
            ['com.go.browser', true, 'go-browser', true, null],
            ['com.dv.adm', true, 'advanced-download-manager', true, null],
            ['com.androidbull.incognito.browser', true, 'incognito-browser', true, null],
            ['com.symantec.mobile.idsafe', true, 'norton-password-manager', true, null],
            ['com.lge.snappage', true, 'snap-page', true, null],
            ['com.morrisxar.nav88', true, 'office-browser', true, null],
            ['epson.print', true, 'epson-iprint', true, null],
            ['miada.tv.webbrowser', true, 'internet-web-browser', true, null],
            ['threads.thor', true, 'thor-browser', true, null],
            ['com.opera.browser', true, 'opera', true, null],
            ['com.opera.browser.afin', true, 'opera', true, null],
            ['com.startpage.mobile', true, 'startpage-private-search-engine', true, null],
            ['ace.avd.tube.video.downloader', true, 'free-video-downloader-pro', true, null],
            ['com.catdaddy.cat22', true, 'wwe-supercard', true, null],
            ['com.jlwf.droid.tutu', true, 'tutu-app', true, null],
            ['com.tct.launcher', true, 'joy-launcher', true, null],
            ['com.baidu.searchbox', true, 'baidu box app', true, null],
            ['de.eue.mobile.android.mail', true, 'einsundeins-mail', true, null],
            ['com.wfeng.droid.tutu', true, 'tutu-app', true, null],
            ['com.honor.global', true, 'honor-store', true, null],
            ['com.finimize.oban', true, 'finimize', true, null],
            ['com.myhomescreen.weather', true, 'weather-home', true, null],
            ['hot.fiery.browser', true, 'fiery-browser', true, null],
            ['de.gmx.mobile.android.mail', true, 'gmx-mail', true, null],
            ['de.twokit.castbrowser', true, 'tv-cast', true, null],
            ['de.twokit.castbrowser.pro', true, 'tv-cast-pro', true, null],
            ['com.esaba.downloader', true, 'downloader', true, null],
            ['com.agilebits.onepassword', true, '1password', true, null],
            ['com.browser2345_ucc', true, '2345 browser', true, null],
            ['com.browser2345hd', true, '2345-browser-hd', true, null],
            ['air.stage.web.view', true, 'adobe air', true, null],
            ['air.stagewebview', true, 'adobe air', true, null],
            ['air.StageWebViewBridgeTest.debug', true, 'adobe air', true, null],
            ['air.StageWebViewVideo.debug', true, 'adobe air', true, null],
            ['com.adobe.phonegap.app', true, 'adobe-phonegap', true, null],
            ['com.adobe.reader', true, 'adobe-reader', true, null],
            ['com.doro.apps.browser', true, 'doro-browser', true, null],
            ['de.einsundeins.searchapp.web', true, 'web.de-search', true, null],
            ['com.droidlogic.mboxlauncher', true, 'mbox-launcher', true, null],
            ['com.droidlogic.xlauncher', true, 'x-launcher', true, null],
            ['com.baidu.browser.apps', true, 'baidu browser', true, null],
            ['com.hihonor.baidu.browser', true, 'honor-browser', true, null],
            ['com.baidu.searchbox.lite', true, 'baidu box app lite', true, null],
            ['com.microsoft.copilot', true, 'microsoft-copilot', true, null],
            ['de.web.mobile.android.mail', true, 'web.de mail', true, null],
            ['com.readly.client', true, 'readly-app', true, null],
            ['com.gbox.android.helper', true, 'gbox-helper', true, null],
            ['com.samsung.android.email.provider', true, 'samsung-email', true, null],
            ['it.italiaonline.mail', true, 'libero-mail', true, null],
            ['webexplorer.amazing.speed', true, 'web-browser-explorer', true, null],
            ['nu.tommie.inbrowser', true, 'in-browser', true, null],
            ['com.massimple.nacion.gcba.es', true, 'plus-simple-browser', true, null],
            ['com.massimple.nacion.parana.es', true, 'plus-simple-browser', true, null],
            ['every.browser.inc', true, 'every-browser', true, null],
            ['com.til.timesnews', true, 'news-point', true, null],
            ['com.omshyapps.vpn', true, 'omshy-vpn', true, null],
            ['com.sharekaro.app', true, 'sharekaro', true, null],
            ['com.transsion.itel.launcher', true, 'itel-os-launcher', true, null],
            ['com.cleanmaster.mguard', true, 'clean-master', true, null],
            ['com.cleanmaster.mguard.huawei', true, 'clean-master', true, null],
            ['com.larus.wolf', true, 'cici', true, null],
            ['com.kuto.vpn', true, 'kuto-vpn', true, null],
            ['com.microsoft.math', true, 'microsoft-math', true, null],
            ['com.google.android.apps.maps', true, 'google-maps', true, null],
            ['com.phlox.tvwebbrowser', true, 'tv-bro', true, null],
            ['com.transsion.XOSLauncher', true, 'xos-launcher', true, null],
            ['com.infinix.xshare', true, 'xshare', true, null],
            ['com.xshare.sharefiles1', true, 'xshare', true, null],
            ['com.transsion.magicshow', true, 'visha', true, null],
            ['com.awesapp.isp', true, 'isafeplay', true, null],
            ['com.anydesk.anydeskandroid', true, 'anydesk-remote-desktop', true, null],
            // ['webexplorer.amazing.biro', true, '', true, null],
        ];
    }
}
