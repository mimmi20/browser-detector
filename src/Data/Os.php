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

namespace BrowserDetector\Data;

use BrowserDetector\Version\AndroidOsFactory;
use BrowserDetector\Version\ChromeOsFactory;
use BrowserDetector\Version\FirefoxOsFactory;
use BrowserDetector\Version\IosFactory;
use BrowserDetector\Version\MacosFactory;
use BrowserDetector\Version\VersionBuilderFactory;
use BrowserDetector\Version\WindowsMobileOsFactory;
use BrowserDetector\Version\WindowsPhoneOsFactory;
use Override;
use UnexpectedValueException;

use function mb_strtolower;
use function sprintf;

enum Os: string implements OsInterface
{
    case unknown = 'unknown';

    case amigaos = 'Amiga OS';

    case android = 'Android';

    case aosp = 'Android Opensource Project';

    case arklinux = 'Ark Linux';

    case asha = 'Asha';

    case atvosx = 'ATV OS X';

    case audioos = 'audioOS';

    case backtracklinux = 'BackTrack Linux';

    case bada = 'Bada';

    case brew = 'Brew';

    case cellos = 'CellOS';

    case orbisos = 'Orbis OS';

    case centos = 'Cent OS Linux';

    case ios = 'iOS';

    case cos = 'Chinese Operating System';

    case chromeos = 'ChromeOS';

    case cpm = 'CP/M';

    case cyanogenmod = 'CyanogenMod';

    case fireos = 'Fire OS';

    case fuchsia = 'Fuchsia';

    case macosx = 'Mac OS X';

    case cygwin = 'Cygwin';

    case darwin = 'Darwin';

    case dragonflybsd = 'DragonFly BSD';

    case firefoxos = 'Firefox OS';

    case geos = 'Geos';

    case irix = 'IRIX';

    case jolios = 'Joli OS';

    case kantonix = 'Kantonix';

    case liberate = 'Liberate';

    case linuxmint = 'Linux Mint';

    case macintosh = 'Macintosh';

    case miuios = 'Miui OS';

    case moblin = 'Moblin';

    case mocordroid = 'MocorDroid';

    case netbsd = 'NetBSD';

    case netcast = 'NetCast';

    case nokiaos = 'Nokia OS';

    case openbsd = 'OpenBSD';

    case openpda = 'OpenPDA';

    case riscos = 'RISC OS';

    case ruby = 'Ruby';

    case series30 = 'Series 30';

    case series40 = 'Series 40';

    case series60 = 'Series 60';

    case threadx = 'ThreadX';

    case unix = 'Unix';

    case watchos = 'watchOS';

    case lgwebos = 'webOS';

    case windows = 'Windows';

    case windows2003 = 'Windows 2003';

    case windows31 = 'Windows 3.1';

    case windows311 = 'Windows 3.11';

    case windows95 = 'Windows 95';

    case windows98 = 'Windows 98';

    case windowsce = 'Windows CE';

    case windowsiot = 'Windows IoT';

    case windowsme = 'Windows ME';

    case windowsmobileos = 'Windows Mobile OS';

    case windowsnt = 'Windows NT';

    case windows10 = 'Windows 10';

    case windows11 = 'Windows 11';

    case windowsnt31 = 'Windows NT 3.1';

    case windowsnt35 = 'Windows NT 3.5';

    case windowsnt351 = 'Windows NT 3.51';

    case windowsnt40 = 'Windows NT 4.0';

    case windowsnt41 = 'Windows NT 4.1';

    case windowsnt410 = 'Windows NT 4.10';

    case windowsnt50 = 'Windows NT 5.0';

    case windowsnt501 = 'Windows NT 5.01';

    case windowsnt51 = 'Windows NT 5.1';

    case windowsnt52 = 'Windows NT 5.2';

    case windowsnt53 = 'Windows NT 5.3';

    case windowsnt60 = 'Windows NT 6.0';

    case windowsnt61 = 'Windows NT 6.1';

    case windowsnt62 = 'Windows NT 6.2';

    case windowsnt63 = 'Windows NT 6.3';

    case windowsnt64 = 'Windows NT 6.4';

    case windowsphone = 'Windows Phone OS';

    case windowsphone10 = 'Windows Phone OS 10.0';

    case windowsphone65 = 'Windows Phone OS 6.5';

    case windowsphone75 = 'Windows Phone OS 7.5';

    case windowsphone80 = 'Windows Phone OS 8.0';

    case windowsphone81 = 'Windows Phone OS 8.1';

    case windowsrt62 = 'Windows RT 6.2';

    case windowsrt63 = 'Windows RT 6.3';

    case wyderos = 'WyderOS';

    case yi = 'Yi';

    case zenwalkgnulinux = 'Zenwalk GNU Linux';

    case harmonyos = 'HarmonyOS';

    case archlinux = 'ArchLinux';

    case pardus = 'Pardus';

    case risingos = 'risingOS';

    case azurelinux = 'Azure Linux';

    case blackpantheros = 'blackPanther OS';

    case kinos = 'KIN OS';

    case wophone = 'WoPhone';

    case starbladeos = 'Star-Blade OS';

    case aros = 'AROS';

    case turbolinux = 'Turbolinux';

    case genix = 'GENIX';

    case nextstep = 'NeXTSTEP';

    case newsos = 'NEWS-OS';

    case lindows = 'Lindows';

    case wearos = 'Wear OS';

    case androidtv = 'Android TV';

    case lineageos = 'LineageOS';

    /**
     * @throws UnexpectedValueException
     *
     * @api
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    public static function fromName(string $name): self
    {
        return match (mb_strtolower($name)) {
            'amigaos', 'amiga os' => self::amigaos,
            'android' => self::android,
            'aosp', 'android opensource project' => self::aosp,
            'arklinux', 'ark linux' => self::arklinux,
            'asha' => self::asha,
            'atvosx', 'atv os x' => self::atvosx,
            'audioos', 'audio os' => self::audioos,
            'backtracklinux', 'backtrack linux' => self::backtracklinux,
            'bada' => self::bada,
            'brew' => self::brew,
            'cellos' => self::cellos,
            'orbisos', 'orbis os' => self::orbisos,
            'centos', 'cent os linux' => self::centos,
            'ios' => self::ios,
            'cos', 'chinese operating system' => self::cos,
            'chromeos' => self::chromeos,
            'cpm', 'cp/m' => self::cpm,
            'cyanogenmod' => self::cyanogenmod,
            'fireos', 'fire os', 'fire-os' => self::fireos,
            'fuchsia' => self::fuchsia,
            'macosx', 'mac os x' => self::macosx,
            'cygwin' => self::cygwin,
            'darwin' => self::darwin,
            'dragonflybsd', 'dragonfly bsd' => self::dragonflybsd,
            'firefoxos', 'firefox os' => self::firefoxos,
            'geos' => self::geos,
            'irix' => self::irix,
            'jolios', 'joli os' => self::jolios,
            'kantonix' => self::kantonix,
            'liberate' => self::liberate,
            'linuxmint', 'linux mint' => self::linuxmint,
            'macintosh' => self::macintosh,
            'miuios', 'miui os' => self::miuios,
            'moblin' => self::moblin,
            'mocordroid' => self::mocordroid,
            'netbsd' => self::netbsd,
            'netcast' => self::netcast,
            'nokiaos', 'nokia os' => self::nokiaos,
            'openbsd' => self::openbsd,
            'openpda' => self::openpda,
            'riscos', 'risc os' => self::riscos,
            'ruby' => self::ruby,
            'series30', 'series 30' => self::series30,
            'series40', 'series 40' => self::series40,
            'series60', 'series 60' => self::series60,
            'threadx' => self::threadx,
            'unix' => self::unix,
            'watchos' => self::watchos,
            'lgwebos', 'lg webos' => self::lgwebos,
            'windows' => self::windows,
            'windows2003', 'windows 2003' => self::windows2003,
            'windows31', 'windows 3.1' => self::windows31,
            'windows311', 'windows 3.11' => self::windows311,
            'windows95', 'windows 95' => self::windows95,
            'windows98', 'windows 98' => self::windows98,
            'windowsce', 'windows ce' => self::windowsce,
            'windowsiot', 'windows iot', 'windows iot 10.0' => self::windowsiot,
            'windowsme', 'windows me' => self::windowsme,
            'windowsmobileos', 'windows mobile os' => self::windowsmobileos,
            'windowsnt', 'windows nt' => self::windowsnt,
            'windows10', 'windows 10', 'windows nt 10', 'windows nt 10.0' => self::windows10,
            'windows11', 'windows 11', 'windows nt 11' => self::windows11,
            'windowsnt31', 'windows nt 3.1' => self::windowsnt31,
            'windowsnt35', 'windows nt 3.5' => self::windowsnt35,
            'windowsnt351', 'windows nt 3.51' => self::windowsnt351,
            'windowsnt40', 'windows nt 4.0' => self::windowsnt40,
            'windowsnt41', 'windows nt 4.1' => self::windowsnt41,
            'windowsnt410', 'windows nt 4.10' => self::windowsnt410,
            'windowsnt50', 'windows nt 5.0' => self::windowsnt50,
            'windowsnt501', 'windows nt 5.01' => self::windowsnt501,
            'windowsnt51', 'windows nt 5.1' => self::windowsnt51,
            'windowsnt52', 'windows nt 5.2' => self::windowsnt52,
            'windowsnt53', 'windows nt 5.3' => self::windowsnt53,
            'windowsnt60', 'windows nt 6.0' => self::windowsnt60,
            'windowsnt61', 'windows nt 6.1' => self::windowsnt61,
            'windowsnt62', 'windows nt 6.2' => self::windowsnt62,
            'windowsnt63', 'windows nt 6.3' => self::windowsnt63,
            'windowsnt64', 'windows nt 6.4' => self::windowsnt64,
            'windowsphone', 'windows phone os' => self::windowsphone,
            'windowsphone10', 'windows phone 10.0' => self::windowsphone10,
            'windowsphone65', 'windows phone 6.5' => self::windowsphone65,
            'windowsphone75', 'windows phone 7.5' => self::windowsphone75,
            'windowsphone80', 'windows phone 8.0' => self::windowsphone80,
            'windowsphone81', 'windows phone 8.1' => self::windowsphone81,
            'windowsrt62', 'windows rt 6.2' => self::windowsrt62,
            'windowsrt63', 'windows rt 6.3' => self::windowsrt63,
            'wyderos' => self::wyderos,
            'yi' => self::yi,
            'zenwalkgnulinux', 'zenwalk gnu linux' => self::zenwalkgnulinux,
            'harmonyos', 'harmony-os' => self::harmonyos,
            'archlinux', 'arch-linux' => self::archlinux,
            'pardus' => self::pardus,
            'risingos', 'rising-os' => self::risingos,
            'azurelinux', 'azure linux', 'azure-linux' => self::azurelinux,
            'blackpantheros', 'blackpanther os', 'black-panther-os' => self::blackpantheros,
            'kinos', 'kin os', 'kin-os' => self::kinos,
            'wophone', 'wo-phone' => self::wophone,
            'starbladeos', 'star-blade-os', 'star-blade os' => self::starbladeos,
            'aros' => self::aros,
            'turbolinux' => self::turbolinux,
            'genix' => self::genix,
            'nextstep', 'next-step' => self::nextstep,
            'newsos', 'news-os' => self::newsos,
            'lindows' => self::lindows,
            'wearos', 'wear os', 'wear-os' => self::wearos,
            'androidtv', 'android tv', 'android-tv' => self::androidtv,
            'lineageos' => self::lineageos,
            // the last one
            'unknown', '' => self::unknown,
            default => throw new UnexpectedValueException(
                sprintf('the os "%s" is unknown', $name),
            ),
        };
    }

    /** @throws void */
    #[Override]
    public function getName(): string | null
    {
        return match ($this) {
            self::unknown => null,
            self::windows10, self::windows11, self::windowsnt61, self::windowsnt62, self::windowsnt63, self::windowsnt64 => 'Windows',
            self::windowsnt31, self::windowsnt35, self::windowsnt351, self::windowsnt40, self::windowsnt41, self::windowsnt410, self::windowsnt50, self::windowsnt501, self::windowsnt51, self::windowsnt52, self::windowsnt53, self::windowsnt60 => 'Windows NT',
            self::windowsphone10, self::windowsphone65, self::windowsphone75, self::windowsphone80, self::windowsphone81 => 'Windows Phone OS',
            self::windowsrt62, self::windowsrt63 => 'Windows RT',
            default => $this->value,
        };
    }

    /** @throws void */
    #[Override]
    public function getMarketingName(): string | null
    {
        return match ($this) {
            self::aosp => 'AOSP',
            self::cos => 'COS',
            self::windows10, self::windowsnt64 => 'Windows 10',
            self::windows11 => 'Windows 11',
            self::windowsnt31, self::windowsnt35, self::windowsnt351, self::windowsnt40, self::windowsnt41, self::windowsnt410 => 'Windows NT',
            self::windowsnt50, self::windowsnt501 => 'Windows 2000',
            self::windowsnt51, self::windowsnt52, self::windowsnt53 => 'Windows XP',
            self::windowsnt60 => 'Windows Vista',
            self::windowsnt61 => 'Windows 7',
            self::windowsnt62 => 'Windows 8',
            self::windowsnt63 => 'Windows 8.1',
            self::windowsphone10, self::windowsphone65, self::windowsphone75, self::windowsphone80, self::windowsphone81 => 'Windows Phone OS',
            self::windowsrt62, self::windowsrt63 => 'Windows RT',
            self::unknown => null,
            default => $this->value,
        };
    }

    /** @throws void */
    #[Override]
    public function getManufacturer(): Company
    {
        return match ($this) {
            self::android, self::chromeos, self::fuchsia, self::wearos, self::androidtv => Company::google,
            self::asha, self::nokiaos, self::series30, self::series40, self::series60 => Company::nokia,
            self::atvosx, self::audioos, self::ios, self::macosx, self::darwin, self::macintosh => Company::apple,
            self::bada => Company::samsung,
            self::cellos, self::orbisos, self::newsos => Company::sony,
            self::fireos => Company::amazon,
            self::firefoxos => Company::mozilla,
            self::miuios => Company::xiaomi,
            self::netcast, self::lgwebos => Company::lg,
            self::windows, self::windows2003, self::windows31, self::windows311, self::windows95, self::windows98, self::windowsce, self::windowsiot, self::windowsme, self::windowsmobileos, self::windowsnt, self::windows10, self::windows11, self::windowsnt31, self::windowsnt35, self::windowsnt351, self::windowsnt40, self::windowsnt41, self::windowsnt410, self::windowsnt50, self::windowsnt501, self::windowsnt51, self::windowsnt52, self::windowsnt53, self::windowsnt60, self::windowsnt61, self::windowsnt62, self::windowsnt63, self::windowsnt64, self::windowsphone, self::windowsphone10, self::windowsphone65, self::windowsphone75, self::windowsphone80, self::windowsphone81, self::windowsrt62, self::windowsrt63, self::azurelinux, self::kinos => Company::microsoft,
            self::yi => Company::baidu,
            self::harmonyos => Company::huawei,
            default => Company::unknown,
        };
    }

    /**
     * @return array{factory: class-string|null, search: array<int, string>|null, value?: float|int|string}
     *
     * @throws void
     */
    #[Override]
    public function getVersion(): array
    {
        return match ($this) {
            self::amigaos => ['factory' => VersionBuilderFactory::class, 'search' => ['AmigaOS']],
            self::arklinux => ['factory' => VersionBuilderFactory::class, 'search' => ['Ark Linux']],
            self::bada => ['factory' => VersionBuilderFactory::class, 'search' => ['Bada']],
            self::brew => ['factory' => VersionBuilderFactory::class, 'search' => ['BREW; U;', 'BREW;?']],
            self::cos => ['factory' => VersionBuilderFactory::class, 'search' => ['COS like Android', 'Chinese Operating System']],
            self::cyanogenmod => ['factory' => VersionBuilderFactory::class, 'search' => ['CyanogenMod']],
            self::fuchsia => ['factory' => VersionBuilderFactory::class, 'search' => ['Fuchsia']],
            self::darwin => ['factory' => VersionBuilderFactory::class, 'search' => ['Darwin']],
            self::dragonflybsd => ['factory' => VersionBuilderFactory::class, 'search' => ['DragonFly']],
            self::jolios => ['factory' => VersionBuilderFactory::class, 'search' => ['Joli OS']],
            self::liberate => ['factory' => VersionBuilderFactory::class, 'search' => ['Liberate']],
            self::linuxmint => ['factory' => VersionBuilderFactory::class, 'search' => ['Mint', 'mint']],
            self::macintosh => ['factory' => VersionBuilderFactory::class, 'search' => ['Macintosh']],
            self::miuios => ['factory' => VersionBuilderFactory::class, 'search' => ['MIUI\\/V', 'MIUI']],
            self::mocordroid => ['factory' => VersionBuilderFactory::class, 'search' => ['MocorDroid']],
            self::netbsd => ['factory' => VersionBuilderFactory::class, 'search' => ['NetBSD']],
            self::openbsd => ['factory' => VersionBuilderFactory::class, 'search' => ['OpenBSD']],
            self::riscos => ['factory' => VersionBuilderFactory::class, 'search' => ['RISC']],
            self::unix => ['factory' => VersionBuilderFactory::class, 'search' => ['Unix']],
            self::lgwebos => ['factory' => VersionBuilderFactory::class, 'search' => ['Web0S']],
            self::wyderos => ['factory' => VersionBuilderFactory::class, 'search' => ['WyderOS']],
            self::yi => ['factory' => VersionBuilderFactory::class, 'search' => ['Yi']],
            self::harmonyos => ['factory' => VersionBuilderFactory::class, 'search' => ['HarmonyOS']],
            self::pardus => ['factory' => VersionBuilderFactory::class, 'search' => ['Pardus']],
            self::risingos => ['factory' => VersionBuilderFactory::class, 'search' => ['RisingOS']],
            self::blackpantheros => ['factory' => VersionBuilderFactory::class, 'search' => ['blackPanther OS']],
            self::kinos => ['factory' => VersionBuilderFactory::class, 'search' => ['KIN\.(?:One|Two)']],
            self::windowsce => ['factory' => VersionBuilderFactory::class, 'search' => ['Windows CE', 'WindowsCE']],
            self::wophone => ['factory' => VersionBuilderFactory::class, 'search' => ['WoPhone']],
            self::aros => ['factory' => VersionBuilderFactory::class, 'search' => ['AROS']],
            self::turbolinux => ['factory' => VersionBuilderFactory::class, 'search' => ['Turbolinux']],
            self::genix => ['factory' => VersionBuilderFactory::class, 'search' => ['GENIX']],
            self::newsos => ['factory' => VersionBuilderFactory::class, 'search' => ['NEWS-OS']],
            self::lindows => ['factory' => VersionBuilderFactory::class, 'search' => ['Lindows']],
            self::android => ['factory' => AndroidOsFactory::class, 'search' => null],
            self::atvosx, self::audioos, self::ios, self::watchos => ['factory' => IosFactory::class, 'search' => null],
            self::chromeos => ['factory' => ChromeOsFactory::class, 'search' => null],
            self::macosx => ['factory' => MacosFactory::class, 'search' => null],
            self::firefoxos => ['factory' => FirefoxOsFactory::class, 'search' => null],
            self::windowsmobileos => ['factory' => WindowsMobileOsFactory::class, 'search' => null],
            self::windowsphone => ['factory' => WindowsPhoneOsFactory::class, 'search' => null],
            self::windows2003 => ['factory' => null, 'search' => null, 'value' => 2003],
            self::windows31, self::windowsnt31 => ['factory' => null, 'search' => null, 'value' => 3.1],
            self::windows311 => ['factory' => null, 'search' => null, 'value' => 3.11],
            self::windowsnt35 => ['factory' => null, 'search' => null, 'value' => 3.5],
            self::windowsnt351 => ['factory' => null, 'search' => null, 'value' => 3.51],
            self::windowsnt40 => ['factory' => null, 'search' => null, 'value' => 4],
            self::windowsnt41 => ['factory' => null, 'search' => null, 'value' => 4.1],
            self::windowsnt410 => ['factory' => null, 'search' => null, 'value' => '4.10'],
            self::windowsnt50 => ['factory' => null, 'search' => null, 'value' => 5],
            self::windowsnt501 => ['factory' => null, 'search' => null, 'value' => 5.01],
            self::windowsnt51 => ['factory' => null, 'search' => null, 'value' => 5.1],
            self::windowsnt52 => ['factory' => null, 'search' => null, 'value' => 5.2],
            self::windowsnt53 => ['factory' => null, 'search' => null, 'value' => 5.3],
            self::windowsnt60 => ['factory' => null, 'search' => null, 'value' => 6],
            self::windowsphone65 => ['factory' => null, 'search' => null, 'value' => 6.5],
            self::windowsnt61 => ['factory' => null, 'search' => null, 'value' => 7],
            self::windowsphone75 => ['factory' => null, 'search' => null, 'value' => 7.5],
            self::windowsnt62, self::windowsphone80, self::windowsrt62 => ['factory' => null, 'search' => null, 'value' => 8],
            self::windowsnt63, self::windowsphone81, self::windowsrt63 => ['factory' => null, 'search' => null, 'value' => 8.1],
            self::windows95 => ['factory' => null, 'search' => null, 'value' => 95],
            self::windows98 => ['factory' => null, 'search' => null, 'value' => 98],
            self::windowsiot, self::windows10, self::windowsnt64, self::windowsphone10 => ['factory' => null, 'search' => null, 'value' => 10],
            self::windows11 => ['factory' => null, 'search' => null, 'value' => 11],
            self::windowsme => ['factory' => null, 'search' => null, 'value' => 'ME'],
            default => ['factory' => null, 'search' => null],
        };
    }

    /** @throws void */
    #[Override]
    public function getKey(): string
    {
        return match ($this) {
            self::amigaos => 'amiga os',
            self::atvosx => 'atv os x',
            self::audioos => 'audio os',
            self::backtracklinux => 'backtrack linux',
            self::centos => 'cent os linux',
            self::cpm => 'cp/m',
            self::fireos => 'fire-os',
            self::macosx => 'mac os x',
            self::dragonflybsd => 'dragonfly bsd',
            self::jolios => 'joli os',
            self::linuxmint => 'linux mint',
            self::miuios => 'miui os',
            self::nokiaos => 'nokia os',
            self::windows2003 => 'windows 2003',
            self::windows31 => 'windows 3.1',
            self::windows311 => 'windows 3.11',
            self::windows95 => 'windows 95',
            self::windows98 => 'windows 98',
            self::windowsce => 'windows ce',
            self::windowsiot => 'windows iot 10.0',
            self::windowsme => 'windows me',
            self::windowsmobileos => 'windows mobile os',
            self::windowsnt => 'windows nt',
            self::windows10 => 'windows nt 10.0',
            self::windows11 => 'windows nt 11.0',
            self::windowsnt31 => 'windows nt 3.1',
            self::windowsnt35 => 'windows nt 3.5',
            self::windowsnt351 => 'windows nt 3.51',
            self::windowsnt40 => 'windows nt 4.0',
            self::windowsnt41 => 'windows nt 4.1',
            self::windowsnt410 => 'windows nt 4.10',
            self::windowsnt50 => 'windows nt 5.0',
            self::windowsnt501 => 'windows nt 5.01',
            self::windowsnt51 => 'windows nt 5.1',
            self::windowsnt52 => 'windows nt 5.2',
            self::windowsnt53 => 'windows nt 5.3',
            self::windowsnt60 => 'windows nt 6.0',
            self::windowsnt61 => 'windows nt 6.1',
            self::windowsnt62 => 'windows nt 6.2',
            self::windowsnt63 => 'windows nt 6.3',
            self::windowsnt64 => 'windows nt 6.4',
            self::windowsphone => 'windows phone',
            self::windowsphone10 => 'windows phone 10.0',
            self::windowsphone65 => 'windows phone 6.5',
            self::windowsphone75 => 'windows phone 7.5',
            self::windowsphone80 => 'windows phone 8.0',
            self::windowsphone81 => 'windows phone 8.1',
            self::windowsrt62 => 'windows rt 6.2',
            self::windowsrt63 => 'windows rt 6.3',
            self::zenwalkgnulinux => 'zenwalk gnu linux',
            self::harmonyos => 'harmony-os',
            self::archlinux => 'arch-linux',
            self::risingos => 'rising-os',
            self::azurelinux => 'azure-linux',
            self::blackpantheros => 'black-panther-os',
            self::kinos => 'kin-os',
            self::wophone => 'wo-phone',
            self::starbladeos => 'star-blade-os',
            self::nextstep => 'next-step',
            self::newsos => 'news-os',
            self::wearos => 'wear-os',
            self::androidtv => 'android-tv',
            default => $this->name,
        };
    }
}
