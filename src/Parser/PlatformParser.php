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

namespace BrowserDetector\Parser;

use BrowserDetector\Data\Os;
use Override;
use UaData\OsInterface;
use UaParser\PlatformParserInterface;

use function preg_match;

final readonly class PlatformParser implements PlatformParserInterface
{
    /** @throws void */
    public function __construct()
    {
        // nothing to do
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    #[Override]
    public function parse(string $useragent): OsInterface
    {
        $regexes = [
            '/(?:pacific|(?<!like )quest).+oculusbrowser|standalone hmd|portalgo/i' => Os::horizon,
            '/leafos/i' => Os::leafOs,
            '/cloud phone/i' => Os::puffinOs,
            '/risingos/i' => Os::risingos,
            '/linux\/.+-microsoft/i' => Os::azurelinux,
            '/vizios/i' => Os::viziOs,
            '/blackpanther os/i' => Os::blackpantheros,
            '/wophone/i' => Os::wophone,
            '/kin\.(?:one|two)/i' => Os::kinos,
            '/star-blade os/i' => Os::starbladeos,
            '/qtopia/i' => Os::qtopia,
            '/openvms/i' => Os::openvms,
            '/ AROS[; ]/' => Os::aros,
            '/\(NEXT\)/' => Os::nextstep,
            '/NEWS-OS/' => Os::newsos,
            '/ULTRIX/' => Os::ultrix,
            '/turbolinux/i' => Os::turboLinux,
            '/joli os/i' => Os::jolios,
            '/GENIX/' => Os::genix,
            '/windows iot 10/i' => Os::windowsiot,
            '/windows ?ce|windows mobile; wce|ceos/i' => Os::windowsce,
            '/windows phone(?: os)? (10|[678])\.[015]/i' => Os::windowsphone,
            '/Windows Phone OS|XBLWP7|ZuneWP7|Windows Phone(?! 6)|WPDesktop| wds |WPOS\:|Windows Mobile (?:7|8|10)|Windows NT (?:7|8|10)(?:[\.\d]+)?; ARM; (?:Lumia|RM-)/' => Os::windowsphone,
            '/windows (phone|iot|ce)|microsoft windows; ppc|iemobile|xblwp7|zunewp7|windows ?mobile|wpdesktop|mobile version|lumia| wds |wpos:/i' => Os::windowsmobileos,
            '/palm os|palmsource/i' => Os::palmOs,
            '/windows[ _]nt 10|windows 10/i' => Os::windows10,
            '/windows nt 6\.4|windows 6\.4/i' => Os::windowsnt64,
            '/windows nt 6\.3; arm/i' => Os::windowsrt63,
            '/windows nt 6\.3|windows 6\.3|windows 8\.1/i' => Os::windowsnt63,
            '/windows nt 6\.2; arm/i' => Os::windowsrt62,
            '/windows nt 6\.2|windows 6\.2|windows 8|winnt 6\.2/i' => Os::windowsnt62,
            '/windows nt 6\.1|windows 6\.1|windows 7|cygwin_nt-6\.1/i' => Os::windowsnt61,
            '/windows nt 6\.0|windows 6\.0|windows vista/i' => Os::windowsnt60,
            '/windows 2003/i' => Os::windows2003,
            '/windows nt 5\.3|windows 5\.3/i' => Os::windowsnt53,
            '/windows nt 5\.2|windows 5\.2/i' => Os::windowsnt52,
            '/win9x\/nt 4\.90|win 9x ?4\.90|windows me/i' => Os::windowsme,
            '/windows nt 5\.1|windows 5\.1|windows xp|cygwin_nt-5\.1/i' => Os::windowsnt51,
            '/windows nt 5\.01|windows 5\.01/i' => Os::windowsnt501,
            '/windows nt ?5\.0|windows 5\.0|windows 2000|cygwin_nt-5\.0/i' => Os::windowsnt50,
            '/win98|windows 98/i' => Os::windows98,
            '/win95|windows 95|win32/i' => Os::windows95,
            '/windows nt 4\.10|windows 4\.10/i' => Os::windowsnt410,
            '/windows nt 4\.1|windows 4\.1/i' => Os::windowsnt41,
            '/windows nt 4\.0|windows nt4\.0|windows 4\.0|winnt4\.0/i' => Os::windowsnt40,
            '/windows nt 3\.51|windows 3\.51|winnt3\.51/i' => Os::windowsnt351,
            '/windows nt 3\.5|windows 3\.5|winnt3\.5/i' => Os::windowsnt35,
            '/windows nt 3\.1|winnt3\.1/i' => Os::windowsnt31,
            '/windows nt|winnt/i' => Os::windowsnt,
            '/windows 3\.11/i' => Os::windows311,
            '/win16|windows 3\.1/i' => Os::windows31,
            '/windows|win(10|9|8|7|vista|xp|2000|me|9x|98|95|nt|31|32|16)|barca|the bat!|cygwin_(?:nt|9[58]|me)|[\-\( ]mingw32/i' => Os::windows,
            '/commoncrawler|msie or firefox mutant|not on windows server/i' => Os::unknown,
            '/symbian\/3/i' => Os::symbianOs,
            '/series ?60|s60v[35]|s60; ?symbos/i' => Os::series60,
            '/series ?40/i' => Os::series40,
            '/symb(?:ian|os)|series ?30|nokia7230/i' => Os::symbianOs,
            '/netbsd/i' => Os::netbsd,
            '/openbsd/i' => Os::openbsd,
            '/dragonfly/i' => Os::dragonflybsd,
            '/kfreebsd/i' => Os::debianWithFreeBSDKernel,
            '/darwin; freebsd/i' => Os::macintosh,
            '/freebsd/i' => Os::freebsd,
            '/(?<![0-9\-])bsd(?!k)/i' => Os::bsd,
            '/debian apt-http/i' => Os::debian,
            '/plasma mobile/i' => Os::plasmaMobile,
            '/kubuntu/i' => Os::kubuntu,
            '/xubuntu/i' => Os::xubuntu,
            '/ubuntu/i' => Os::ubuntu,
            '/debian/i' => Os::debian,
            '/(?<!no)tizen/i' => Os::tizen,
            '/remixos|remix (?:pro|mini)/i' => Os::remixOs,
            '/(?<![0-9a-z])bada/i' => Os::bada,
            '/meego/i' => Os::meego,
            '/sailfish/i' => Os::sailfishOs,
            '/chinese operating system|(?<!ma)cos;|\(cos [0-9]|android; cos/i' => Os::cos,
            '/wh\/|whaletv|zeasn/i' => Os::whaleOS,
            '/maemo/i' => Os::maemo,
            '/web0s/i' => Os::lgwebos,
            '/webos|hpwos/i' => Os::webos,
            '/opensolaris/i' => Os::opensolaris,
            '/solaris/i' => Os::solaris,
            '/sunos/i' => Os::sunos,
            '/hp-?ux/i' => Os::hpux,
            '/irix/i' => Os::irix,
            '/(?<![ch])aix(?![u\-])/i' => Os::aix,
            '/(tru64|digital) unix/i' => Os::tru64unix,
            '/osf1/i' => Os::osf1,
            '/unix/i' => Os::unix,
            '/kukui|(?<!i)cros(?!s)|build\/r\d+-\d+[.\d]+|chromebook/i' => Os::chromeos,
            '/fire os|(?:andr[o0]id (\d([\d.])*);? |amazon;|smarttv_)aft|aeo[acbhkt]|[ (]kf[adfgjkmorstq]|.+firetvstick2018|cordova-amazon-fireos/i' => Os::fireos,
            '/kaios/i' => Os::kaios,
            '/spreadtrum/i' => Os::mocorOS,
            '/smartisan[_ ]|(sm(?:70[15]|801|919)|yq60[1357]|dt2002c|de106|dt190[12]a|o[ce]106|oc105)[ \/;\)]/i' => Os::smartisanOS,
            '/baidu yi/i' => Os::yi,
            '/yunos/i' => Os::yunOs,
            '/openharmony/i' => Os::openHarmony,
            '/harmonyos/i' => Os::harmonyos,
            '/aosp/i' => Os::aosp,
            '/cyanogenmod/i' => Os::cyanogenmod,
            '/mocordroid/i' => Os::mocordroid,
            '/andr0id|android tv|g[o0][o0]gle tv/i' => Os::androidtv,
            '/sm-r[0-9]{3}/i' => Os::wearos,
            '/(?<!o)andr[0o]id|silk|juc ?\(linux;|adr |gingerbread|ucweb\/2\.0 \(linux;|vre;|beyondpod|htc_sensation_z710e|puffin\/[\d\.]+a[tp]|okhttp/i' => Os::android,
            '/watchos/i' => Os::watchos,
            '/mobilesafari\/.*cfnetwork|watchos|(?<!like |t)iphone|cpu i?os|like mac os x/i' => Os::ios,
            '/mac os x|os\=mac 10/i' => Os::macosx,
            '/morphos/i' => Os::morphos,
            '/mac_powerpc|ppc|68k/i' => Os::macintosh,
            '/safari\/.*cfnetwork|(?<!like )mac os x|power macintosh|nook browser/i' => Os::macosx,
            '/(networkingextension|com\.apple\.webkit\.networking|safariviewservice|safari technology preview|safarifetcherd)\/[\d\.]+ .* darwin\/|i?mac\d/i' => Os::macosx,
            '/(networkingextension|com\.apple\.webkit\.networking)\/[\d\.]+ .* ios\//i' => Os::ios,
            '/(mobilesafari)\/[\d\.]+ .* darwin\//i' => Os::ios,
            '/cfnetwork\/.+ darwin\/(?:[\d\.]+).+(?:x86_64|i386|power macintosh)|(?:x86_64-apple-)?darwin(?:[\d\.]+)|cpython\/[\d\.]+ darwin\/[\d\.]+/i' => Os::macosx,
            '/^(?!com.apple.safari.searchhelper|safari).*cfnetwork\/.+ darwin\/(\d+[\.\d]+)(?!.*(?:x86_64|i386|powermac|power macintosh))/i' => Os::ios,
            '/cfnetwork\/.*\((x86_64|i386)\)|cfnetwork\/(80[27]|79[68]|760|720|71[48]|70[58]|69[69]|673|647|59[56]|561|520|515|454|43[38]|422|33[09]|22[01]|217|12[89]|4\.0|1\.[12])/i' => Os::macosx,
            '/cfnetwork\/(1402|1378|109[18]|108[58]|97[14568]|96[92]|95[85]|948|90[21]|89[743]|88[79]|811|808|790|75[78]|711|709|672|60[29]|548|485|467|459)/i' => Os::ios,
            '/(?<!FBSN\/|\()darwin|cfnetwork/i' => Os::macintosh,
            '/smarthub; ?smart-tv|hbbtv\/.+maple|samsung;smarttv201[2-5]/i' => Os::orsay,
            '/Linux (?:[^;]+); Opera TV(?: Store)?\/|^Opera\/\d+\.\d+ \(Linux mips|OPR\/.+TV Store\/(\d+[.\d]+)/i' => Os::operaTv,
            '/linux mint/i' => Os::linuxmint,
            '/fedora/i' => Os::fedoraLinux,
            '/red ?hat/i' => Os::redhatLinux,
            '/raspbian/i' => Os::raspbian,
            '/centos/i' => Os::centos,
            '/openmandriva/i' => Os::openMandriva,
            '/mandriva/i' => Os::mandrivaLinux,
            '/opensuse/i' => Os::openSuse,
            '/suse/i' => Os::suseLinux,
            '/gentoo/i' => Os::gentooLinux,
            '/slackware/i' => Os::slackwareLinux,
            '/ventana/i' => Os::ventanaLinux,
            '/moblin/i' => Os::moblin,
            '/zenwalk gnu/i' => Os::zenwalkgnulinux,
            '/startos/i' => Os::startos,
            '/kantonix/i' => Os::kantonix,
            '/backtrack/i' => Os::backtracklinux,
            '/ark linux/i' => Os::arklinux,
            '/openpda/i' => Os::openpda,
            '/arch ?linux/i' => Os::archlinux,
            '/pardus/i' => Os::pardus,
            '/linspire/i' => Os::linspire,
            '/lindows/i' => Os::lindows,
            '/linux|esx|netcast|dillo|gvfs|libvlc|lynx|tinybrowser|akregator|installatron|nettv|hbbtv|smart-tv|x11|wayland/i' => Os::linux,
            '/rim tablet/i' => Os::rimTabletOs,
            '/blackberry|bb10; ?(kbd|touch)/i' => Os::rimOs,
            '/^Mozilla\/5\.0 \(.*(Mobile|Tablet);.*rv:(\d+\.\d+).*\) Gecko\/(\d+).* Firefox\/(\d+\.\d+).*/' => Os::firefoxos,
            '/amigaos/i' => Os::amigaos,
            '/haiku/i' => Os::haiku,
            '/beos/i' => Os::beos,
            '/ip[ao]d|(?<![tx])ios[;\/]|iuc ?\(|puffin\/[\d\.]+i[pt]|antenna\/|antennapod|rss_?radio|podcruncher|audioboom|stitcher\/ios|captivenetwork|ios\.watch/i' => Os::ios,
            '/(?<!devicename:)nokia/i' => Os::symbianOs,
            '/brew/i' => Os::brew,
            '/Java ME|J2ME|Profile\/MIDP|CLDC|Java; MIDP|MMP\/\d\.\d/i' => Os::javaMe,
            '/mtk[; 0-9]|nucleus/i' => Os::nucleus,
            '/mre|maui runtime/i' => Os::mre,
            '/threadx/i' => Os::threadx,
            '/\bprofile\b|gt\-c3312r|kkt20|lemon b556|spark284|obigo|jasmine\/1\.0|netfront|profile\/midp|j2me\/|java|micromaxx650|dolfin\/|yuanda50|wap[- ]?browser/i' => Os::javaos,
            '/macintosh|os=mac 10|camino|pubsub|integrity|mac ?os[;\/]/i' => Os::macintosh,
            '/risc/i' => Os::riscos,
            '/os\/2|warp/i' => Os::os2,
            '/cp\/m/i' => Os::cpm,
            '/nintendo wii|wiios/i' => Os::nintendoWiiOs,
            '/nintendo 3ds/i' => Os::nintendoOs,
            '/wyderos/i' => Os::wyderos,
            '/liberate/i' => Os::liberate,
            '/inferno/i' => Os::infernoOs,
            '/syllable/i' => Os::syllable,
            '/fuchsia/i' => Os::fuchsia,
        ];

        foreach ($regexes as $regex => $os) {
            if (preg_match($regex, $useragent)) {
                return $os;
            }
        }

        return Os::unknown;
    }
}
