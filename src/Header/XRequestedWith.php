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
        $match = preg_match('/xmlhttprequest|fake\\./i', $this->value);

        return $match === 0;
    }

    /** @throws void */
    public function getClientCode(): string | null
    {
        return match (mb_strtolower($this->value)) {
            'acr.browser.barebones' => 'lightning-browser',
            'acr.browser.linxy' => 'vegas-browser',
            'acr.browser.raisebrowserfull' => 'raise-fast-browser',
            'anar.app.darkweb' => 'dark-web-browser',
            'com.active.cleaner' => 'active-cleaner',
            'com.aliyun.mobile.browser' => 'aliyun-browser',
            'com.aloha.browser', 'alohabrowser' => 'aloha-browser',
            'com.amazon.webapps.gms.search' => 'google-search',
            'com.andrewshu.android.reddit', 'com.andrewshu.android.redditdonation' => 'reddit-is-fun',
            'com.android.browser' => 'android webview',
            'com.android.chrome' => 'chrome',
            'com.aol.mobile.aolapp' => 'aol-app',
            'com.apple.mobilenotes' => 'apple mobilenotes',
            'com.apple.notes' => 'apple notes app',
            'com.apple.webkit' => 'apple webkit service',
            'com.appsinnova.android.keepclean' => 'keep-clean',
            'com.asus.browser' => 'asus browser',
            'com.ayoba.ayoba' => 'ayoba-app',
            'com.brave.browser' => 'brave',
            'com.browser2345' => '2345 browser',
            'com.cake.browser' => 'cake-browser',
            'com.cloudmosa.puffinfree' => 'puffin',
            'com.cmcm.armorfly' => 'armorfly-browser',
            'com.douban.group' => 'douban app',
            'com.duckduckgo.mobile.android' => 'duckduck app',
            'com.emporia.emporiaapprebuild' => 'emporia-app',
            'com.espn.score_center' => 'espn-app',
            'com.facebook.katana' => 'facebook app',
            'com.facebook.orca' => 'facebook messenger app',
            'com.fancyclean.security.antivirus' => 'fancy-security',
            'com.fast.browseruc.lite' => 'fast-browser-uc-lite',
            'com.fsecure.ms.buhldata' => 'wiso-internet-security',
            'com.fsecure.ms.darty' => 'darty-securite',
            'com.fsecure.ms.dc' => 'f-secure mobile security',
            'com.fsecure.ms.nifty' => 'always safe security 24',
            'com.fsecure.ms.safe' => 'f-secure safe',
            'com.fsecure.ms.saunalahti_m' => 'elisa-turvapaketti',
            'com.fsecure.ms.swisscom.sa' => 'swisscom-internet-security',
            'com.fsecure.ms.ziggo' => 'ziggo-safe-online',
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
            'com.kakao.talk' => 'kakaotalk',
            'com.kiwibrowser.browser' => 'kiwi',
            'com.ksmobile.cb' => 'cm browser',
            'com.lenovo.anyshare.gps' => 'share-it',
            'com.lenovo.browser' => 'lenovo browser',
            'com.linkedin' => 'linkedinbot',
            'com.mi.globalbrowser.mini' => 'mint browser',
            'com.michatapp.im' => 'mi-chat-app',
            'com.michatapp.im.lite' => 'mi-chat-lite',
            'com.microsoft.bing', 'com.microsoft.bingintl' => 'bingsearch',
            'com.microsoft.office.outlook' => 'outlook',
            'com.mx.browser' => 'maxthon',
            'com.mycompany.app.soulbrowser' => 'soul-browser',
            'com.nhn.android.search' => 'naver',
            'com.noxgroup.app.security' => 'nox-security',
            'com.oh.bro' => 'oh-browser',
            'com.oh.brop' => 'oh-private-browser',
            'com.opera.gx' => 'opera gx',
            'com.opera.mini.native' => 'opera mini',
            'com.opera.touch' => 'opera touch',
            'com.oupeng.browser' => 'oupeng browser',
            'com.pure.mini.browser' => 'mini-web-browser',
            'com.rcplatform.livechat' => 'tumile',
            'com.rs.explorer.filemanager' => 'rs-file',
            'com.sec.android.app.sbrowser.lite' => 'samsung-browser-lite',
            'com.sina.weibo' => 'weibo app',
            'com.skout.android' => 'skout',
            'com.snapchat.android' => 'snapchat app',
            'com.sony.nfx.app.sfrc' => 'news-suite-by-sony',
            'com.surfshark.vpnclient.android' => 'surfshark-app',
            'com.swisscows.search' => 'swisscows-private-search',
            'org.telegram.messenger' => 'telegram-app',
            'com.tencent.mm' => 'wechat app',
            'com.tinder' => 'tinder-app',
            'com.tinyspeck.chatlyio' => 'chatlyio app',
            'com.totalav.android' => 'total-av-mobile-security',
            'com.turtc' => 'türkiye-milli-arama-motoru',
            'com.tvwebbrowser.v22' => 'tv-browser-internet',
            'com.ucmobile.intl', 'com.ucmobile.lab' => 'ucbrowser',
            'com.udicorn.proxy' => 'blue-proxy',
            'com.ume.browser.cust' => 'ume-browser',
            'com.v2.vpn.security.free' => 'fast-unlimited-vpn',
            'com.videochat.livu' => 'livu-app',
            'com.vivaldi.browser' => 'vivaldi',
            'com.wiseplay' => 'wiseplay',
            'com.yahoo.onesearch' => 'yahoo-onesearch',
            'com.yy.hiyo' => 'hago-app',
            'de.baumann.browser' => 'foss-browser',
            'de.gdata.mobilesecurityorange' => 'g-data mobile security',
            'derek.isurf' => 'isurf',
            'free.vpn.unblock.proxy.vpnmonster' => 'vpn-monster',
            'info.sunista.app' => 'sanista-persian-instagram',
            'io.metamask' => 'meta-mask',
            'it.ideasolutions.kyms' => 'kyms',
            'it.tolelab.fvd' => 'free-video-downloader',
            'jp.co.fenrir.android.sleipnir' => 'sleipnir',
            'jp.co.yahoo.android.yjtop' => 'yahoo! app',
            'jp.ddo.pigsty.habitbrowser' => 'habit-browser',
            'jp.gocro.smartnews.android' => 'smart-news-app',
            'kik.android' => 'kik',
            'mark.via.gp' => 'via-browser',
            'me.android.browser' => 'me browser',
            'me.webalert' => 'web-alert-app',
            'mobi.mgeek.tunnybrowser' => 'dolfin',
            'net.onecook.browser' => 'stargon-browser',
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
            'xbrowser', 'com.xbrowser.play' => 'x-browser',
            default => null,
        };
    }
}
