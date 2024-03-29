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

namespace BrowserDetector\Header;

use function mb_strtolower;
use function preg_match;

final class XRequestedWith implements HeaderInterface
{
    use HeaderTrait;

    /** @throws void */
    public function hasClientCode(): bool
    {
        $match = preg_match('/xmlhttprequest|fake\./i', $this->value);

        return $match === 0;
    }

    /** @throws void */
    public function getClientCode(): string | null
    {
        // see also vendor/whichbrowser/parser/data/id-android.php
        // see also vendor/matomo/device-detector/regexes/client/hints/apps.yml
        return match (mb_strtolower($this->value)) {
            'ace.avd.tube.video.downloader' => 'free-video-downloader-pro',
            'acr.browser.barebones', 'acr.browser.lightning', 'acr.browser.lightning2', 'acr.browser.lightningq16w' => 'lightning-browser',
            'acr.browser.linxy' => 'vegas-browser',
            'acr.browser.raisebrowserfull' => 'raise-fast-browser',
            'ai.blokee.browser.android' => 'bloket-browser',
            'air.stage.web.view', 'air.stagewebview', 'air.stagewebviewbridgetest.debug', 'air.stagewebviewvideo.debug' => 'adobe air',
            'anar.app.darkweb' => 'dark-web-browser',
            'com.active.cleaner' => 'active-cleaner',
            'com.adobe.phonegap.app' => 'adobe-phonegap',
            'com.adobe.reader' => 'adobe-reader',
            'com.aeroinsta.android' => 'aero-insta',
            'com.agilebits.onepassword' => '1password',
            'com.aliyun.mobile.browser' => 'aliyun-browser',
            'com.aloha.browser', 'alohabrowser' => 'aloha-browser',
            'com.amazon.webapps.gms.search' => 'google-search',
            'com.andrewshu.android.reddit', 'com.andrewshu.android.redditdonation' => 'reddit-is-fun',
            'com.androidbull.incognito.browser' => 'incognito-browser',
            'com.android.browser' => 'android webview',
            'com.android.chrome' => 'chrome',
            'com.aol.mobile.aolapp' => 'aol-app',
            'com.apple.mobilenotes' => 'apple mobilenotes',
            'com.apple.notes' => 'apple notes app',
            'com.apple.webkit' => 'apple webkit service',
            'com.appsinnova.android.keepclean' => 'keep-clean',
            'com.appssppa.idesktoppcbrowser' => 'idesktop-pc-browser',
            'com.appsverse.photon' => 'photon-browser',
            'com.asus.browser' => 'asus browser',
            'com.ayoba.ayoba' => 'ayoba-app',
            'com.baidu.searchbox' => 'baidu box app',
            'com.bestvideodownloader.newvideodownloader' => 'all-video-downloader',
            'com.boatbrowser.free' => 'boat-browser',
            'com.brave.browser' => 'brave',
            'com.brother.mfc.brprint' => 'brother-iprint-scan',
            'com.browser2345', 'com.browser2345_ucc' => '2345 browser',
            'com.browser2345hd' => '2345-browser-hd',
            'web.browser.dragon' => 'dragon-browser',
            'com.cake.browser' => 'cake-browser',
            'com.catdaddy.cat22' => 'wwe-supercard',
            'com.cleanmaster.security' => 'cm-security',
            'com.cliqz.browser' => 'cliqz-browser',
            'com.cloudmosa.puffinfree' => 'puffin',
            'com.cmcm.armorfly' => 'armorfly-browser',
            'com.cookiegames.smartcookie' => 'smartcookieweb-privacy-browser',
            'com.dolphin.browser.zero' => 'dolfin-zero',
            'com.doro.apps.browser' => 'doro-browser',
            'com.douban.group' => 'douban app',
            'com.droidlogic.mboxlauncher' => 'mbox-launcher',
            'com.droidlogic.xlauncher' => 'x-launcher',
            'com.duckduckgo.mobile.android' => 'duckduck app',
            'com.dv.adm' => 'advanced-download-manager',
            'com.eagle.web.browser.internet.privacy.browser' => 'private-browser-web-browser',
            'com.emoticon.screen.home.launcher' => 'in-launcher',
            'com.emporia.browser', 'com.emporia.emporiaapprebuild' => 'emporia-app',
            'com.esaba.downloader' => 'downloader',
            'com.espn.score_center' => 'espn-app',
            'com.explore.web.browser' => 'web-browser-explorer',
            'com.facebook.katana' => 'facebook app',
            'com.facebook.orca' => 'facebook messenger app',
            'com.fancyclean.security.antivirus' => 'fancy-security',
            'com.fast.browseruc.lite' => 'fast-browser-uc-lite',
            'com.finimize.oban' => 'finimize',
            'com.fsecure.ms.buhldata' => 'wiso-internet-security',
            'com.fsecure.ms.darty' => 'darty-securite',
            'com.fsecure.ms.dc' => 'f-secure mobile security',
            'com.fsecure.ms.netcologne' => 'sicherheitspaket',
            'com.fsecure.ms.nifty' => 'always safe security 24',
            'com.fsecure.ms.safe' => 'f-secure safe',
            'com.fsecure.ms.saunalahti_m' => 'elisa-turvapaketti',
            'com.fsecure.ms.swisscom.sa' => 'swisscom-internet-security',
            'com.fsecure.ms.ziggo' => 'ziggo-safe-online',
            'com.gl9.cloudbrowser' => 'surfbrowser',
            'com.go.browser' => 'go-browser',
            'com.google.android.apps.magazines' => 'google play newsstand',
            'com.google.android.apps.searchlite' => 'google search lite',
            'com.google.android.gms' => 'google-play-services',
            'com.google.android.youtube' => 'youtube app',
            'com.google.googlemobile' => 'google mobile app',
            'com.google.googleplus' => 'google+ app',
            'com.hisense.odinbrowser' => 'odin-browser',
            'com.hld.anzenbokusu' => 's-gallery',
            'com.hld.anzenbokusucal' => 'calculator-photo',
            'com.hld.anzenbokusufake' => 'calculator-hide',
            'com.honor.global' => 'honor-store',
            'com.hornet.android' => 'hornet',
            'com.huawei.appmarket' => 'huawei-app-gallery',
            'com.huawei.browser' => 'huawei-browser',
            'com.huawei.fastapp' => 'huawei-quick-app-center',
            'com.huawei.hwsearch' => 'huawei-petal-search',
            'com.huawei.search' => 'hi-search',
            'com.iebrowser.fast' => 'ie-browser-fast',
            'com.instagram.android' => 'instagram app',
            'com.instapro.app' => 'insta-pro',
            'com.jaumo' => 'jaumo',
            'com.jaumo.prime' => 'jaumo-prime',
            'com.jb.security' => 'go-security',
            'com.jio.web' => 'jio-sphere',
            'com.jlwf.droid.tutu', 'com.wfeng.droid.tutu' => 'tutu-app',
            'com.kakao.talk' => 'kakaotalk',
            'com.kaweapp.webexplorer' => 'web-explorer',
            'com.kiwibrowser.browser' => 'kiwi',
            'com.ksmobile.cb' => 'cm browser',
            'com.lenovo.anyshare.gps' => 'share-it',
            'com.lenovo.browser' => 'lenovo browser',
            'com.lge.snappage' => 'snap-page',
            'com.linkedin' => 'linkedinbot',
            'com.litepure.browser.gp' => 'pure-browser',
            'com.mi.globalbrowser.mini' => 'mint browser',
            'com.michatapp.im' => 'mi-chat-app',
            'com.michatapp.im.lite' => 'mi-chat-lite',
            'com.microsoft.amp.apps.bingnews' => 'microsoft-start',
            'com.microsoft.bing', 'com.microsoft.bingintl' => 'bingsearch',
            'com.microsoft.office.outlook' => 'outlook',
            'com.mobiu.browser' => 'lark-browser',
            'com.morrisxar.nav88' => 'office-browser',
            'com.mx.browser' => 'maxthon',
            'com.mycompany.app.soulbrowser' => 'soul-browser',
            'com.myhomescreen.weather' => 'weather-home',
            'com.nhn.android.search' => 'naver',
            'com.noxgroup.app.browser' => 'nox-browser',
            'com.noxgroup.app.security' => 'nox-security',
            'com.oceanhero.search' => 'ocean-hero-app',
            'com.oh.bro' => 'oh-browser',
            'com.oh.brop' => 'oh-private-browser',
            'com.opera.browser', 'com.opera.browser.afin' => 'opera',
            'com.opera.gx' => 'opera gx',
            'com.opera.mini.native' => 'opera mini',
            'com.opera.touch' => 'opera touch',
            'com.oryon.multitasking' => 'multitasking-app',
            'com.oupeng.browser' => 'oupeng browser',
            'com.pure.mini.browser' => 'mini-web-browser',
            'com.qflair.browserq' => 'pluma-browser',
            'com.rcplatform.livechat' => 'tumile',
            'com.rs.explorer.filemanager' => 'rs-file',
            'com.sharkeeapp.browser' => 'sharkee-browser',
            'com.sec.android.app.sbrowser.lite' => 'samsung-browser-lite',
            'com.sec.app.samsungprintservice' => 'samsung-print-service-plugin',
            'com.sina.weibo' => 'weibo app',
            'com.skout.android' => 'skout',
            'com.skype.raider' => 'skype',
            'com.snapchat.android' => 'snapchat app',
            'com.snaptube.premium' => 'snap-tube',
            'com.sony.nfx.app.sfrc' => 'news-suite-by-sony',
            'com.startpage', 'com.startpage.mobile' => 'startpage-private-search-engine',
            'com.stoutner.privacybrowser.standard' => 'stoutner-privacy-browser',
            'com.surfshark.vpnclient.android' => 'surfshark-app',
            'com.swisscows.search' => 'swisscows-private-search',
            'com.symantec.mobile.idsafe' => 'norton-password-manager',
            'com.tct.launcher' => 'joy-launcher',
            'org.telegram.messenger' => 'telegram-app',
            'com.tencent.mm' => 'wechat app',
            'com.tinder' => 'tinder-app',
            'com.tinyspeck.chatlyio' => 'chatlyio app',
            'com.totalav.android' => 'total-av-mobile-security',
            'com.transsion.phoenix' => 'phoenix browser',
            'com.turtc' => 'türkiye-milli-arama-motoru',
            'com.tvwebbrowser.v22' => 'tv-browser-internet',
            'com.ucmobile.intl', 'com.ucmobile.lab' => 'ucbrowser',
            'com.udicorn.proxy' => 'blue-proxy',
            'com.ume.browser.cust', 'com.ume.browser.euas', 'com.ume.browser.bose', 'com.ume.browser.international', 'com.ume.browser.latinamerican', 'com.ume.browser.mexicotelcel', 'com.ume.browser.venezuelavtelca', 'com.ume.browser.northamerica', 'com.ume.browser.newage' => 'ume-browser',
            'com.v2.vpn.security.free' => 'fast-unlimited-vpn',
            'com.videochat.livu' => 'livu-app',
            'com.vivaldi.browser' => 'vivaldi',
            'com.web_view_mohammed.ad.webview_app' => 'appso',
            'com.wiseplay' => 'wiseplay',
            'com.wolvesinteractive.racinggo' => 'racing-go',
            'com.yahoo.onesearch' => 'yahoo-onesearch',
            'com.yiyinkuang.searchboard' => 'search+-for-google',
            'com.yy.hiyo' => 'hago-app',
            'de.baumann.browser' => 'foss-browser',
            'de.einsundeins.searchapp.gmx.com' => 'gmx-search',
            'de.einsundeins.searchapp.web' => 'web.de-search',
            'de.eue.mobile.android.mail' => 'einsundeins-mail',
            'de.freenet.mail' => 'freenet-mail',
            'de.gdata.mobilesecurity2b' => 'tie-team-mobile-security',
            'de.gdata.mobilesecurityorange' => 'g-data mobile security',
            'de.gmx.mobile.android.mail' => 'gmx-mail',
            'de.telekom.epub' => 'pageplace-reader',
            'de.telekom.mail' => 'telekom-mail',
            'de.twokit.castbrowser' => 'tv-cast',
            'de.twokit.castbrowser.pro' => 'tv-cast-pro',
            'derek.isurf' => 'isurf',
            'devian.tubemate.v3' => 'tube-mate',
            'epson.print' => 'epson-iprint',
            'free.vpn.unblock.proxy.vpnmonster' => 'vpn-monster',
            'hot.fiery.browser' => 'fiery-browser',
            'info.sunista.app' => 'sanista-persian-instagram',
            'io.metamask' => 'meta-mask',
            'it.ideasolutions.kyms' => 'kyms',
            'it.tolelab.fvd' => 'free-video-downloader',
            'jp.co.canon.bsd.ad.pixmaprint' => 'canon-print',
            'jp.co.fenrir.android.sleipnir' => 'sleipnir',
            'jp.co.yahoo.android.yjtop' => 'yahoo! app',
            'jp.ddo.pigsty.habitbrowser' => 'habit-browser',
            'jp.gocro.smartnews.android' => 'smart-news-app',
            'jp.hazuki.yuzubrowser' => 'yuzu-browser',
            'kik.android' => 'kik',
            'mark.via.gp' => 'via-browser',
            'me.android.browser' => 'me browser',
            'me.webalert' => 'web-alert-app',
            'miada.tv.webbrowser' => 'internet-web-browser',
            'mobi.mgeek.tunnybrowser' => 'dolfin',
            'net.dezor.browser' => 'dezor-browser',
            'net.fast.web.browser' => 'web-browser-web-explorer',
            'net.onecook.browser' => 'stargon-browser',
            'org.easyweb.browser' => 'easy-browser',
            'org.lineageos.jelly' => 'jelly-browser',
            'org.mozilla.focus' => 'firefox focus',
            'org.mozilla.klar' => 'firefox klar',
            'org.quantumbadger.redreader' => 'red-reader',
            'org.torproject.android' => 'orbot',
            'phone.cleaner.antivirus.speed.booster' => 'phone-clean',
            'phx.hot.browser' => 'anka-browser',
            'pi.browser' => 'pi browser',
            'reactivephone.msearch' => 'smart-search-web-browser',
            'secure.explorer.web.browser' => 'browser lite',
            'snapu2b.com' => 'snapu2b',
            'threads.thor' => 'thor-browser',
            // 'webexplorer.amazing.biro' => '',
            'xbrowser', 'com.xbrowser.play' => 'x-browser',
            default => null,
        };
    }

    /** @throws void */
    public function hasClientVersion(): bool
    {
        $match = preg_match('/xmlhttprequest|fake\./i', $this->value);

        return $match === 0;
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function getClientVersion(string | null $code = null): string | null
    {
        return null;
    }
}
