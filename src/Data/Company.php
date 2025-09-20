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

use Override;
use UnexpectedValueException;

use function mb_strtolower;
use function sprintf;

enum Company: string implements CompanyInterface
{
    case unknown = 'unknown';

    case hoco = 'hoco';

    case gtx = 'GTX';

    case vasoun = 'Vasoun';

    case kenshi = 'Kenshi';

    case wishtel = 'Wishtel';

    case lunnen = 'LUNNEN';

    case mipo = 'mipo';

    case acd = 'ACD';

    case meta = 'Meta';

    case atozee = 'Atozee';

    case everis = 'Everis';

    case unitech = 'Unitech';

    case stylo = 'Stylo';

    case realix = 'Realix';

    case opelmobile = 'Opel Mobile';

    case okapimobile = 'Okapi Mobile';

    case olax = 'Olax';

    case lville = 'Lville';

    case trimble = 'Trimble';

    case google = 'Google';

    case apple = 'Apple';

    case microsoft = 'Microsoft';

    case ajib = 'Ajib';

    case mintt = 'Mintt';

    case iotwe = 'IOTWE';

    case fenoti = 'Fenoti';

    case sparx = 'Sparx';

    case dcode = 'Dcode';

    case ibrit = 'iBrit';

    case nordmende = 'Nordmende';

    case vios = 'Vios';

    case atmpc = 'ATMPC';

    case benco = 'Benco';

    case safaricom = 'Safaricom';

    case yumkem = 'Yumkem';

    case bookry = 'Bookry';

    case tbucci = 'tbucci';

    case gener8 = 'Gener8';

    case omix = 'OMIX';

    case yestel = 'Yestel';

    case duoqin = 'Duoqin';

    case vocal = 'Vocal';

    case oscal = 'Oscal';

    case vitumi = 'Vitumi';

    case iiif150 = 'iiiF150';

    case searchcraft = 'Searchcraft';

    case dxdcs = 'DxDcS';

    case databite = 'Databite';

    case senuto = 'Senuto';

    case acquia = 'Acquia';

    case criteo = 'Criteo';

    case nubia = 'Nubia';

    case bigme = 'Bigme';

    case netflix = 'Netflix';

    case waze = 'Waze';

    case qjy = 'QJY';

    case meanit = 'MeanIT';

    case yezz = 'Yezz';

    case byjus = 'BYJUS';

    case joyar = 'Joyar';

    case kalley = 'Kalley';

    case ceibal = 'Ceibal';

    case foxxd = 'Foxxd';

    case vankyo = 'Vankyo';

    case aeezo = 'AEEZO';

    case dna = 'DNA';

    case itech = 'ITECH';

    case nexech = 'Nexech';

    case einsundeins = '1 & 1';

    case corn = 'Corn';

    case logic = 'Logic';

    case hammer = 'Hammer';

    case rungee = 'RunGee';

    case bmax = 'BMAX';

    case jambo = 'Jambo';

    case fanvace = 'Fanvace';

    case rombica = 'Rombica';

    case novis = 'Novis';

    case pritom = 'Pritom';

    case pixus = 'Pixus';

    case tibuta = 'Tibuta';

    case daria = 'Daria';

    case dijitsu = 'Dijitsu';

    case wildred = 'WildRed';

    case asano = 'Asano';

    case hi = 'Hi';

    case scoole = 'Scoole';

    case soundmax = 'Soundmax';

    case topdevice = 'TopDevice';

    case bigben = 'Bigben';

    case krono = 'Krono';

    case calme = 'Calme';

    case xb = 'XB';

    case ziovo = 'Ziovo';

    case ihunt = 'iHunt';

    case emporia = 'Emporia';

    case microera = 'MicroEra';

    case villaon = 'Villaon';

    case zebra = 'Zebra';

    case sonim = 'Sonim';

    case xsmart = 'XSmart';

    case moondrop = 'Moondrop';

    case maxwest = 'Maxwest';

    case fplus = 'F+';

    case energizer = 'Energizer';

    case ayya = 'AYYA';

    case xreal = 'XREAL';

    case wainyok = 'Wainyok';

    case hotPepper = 'Hot Pepper';

    case eaglesoar = 'EagleSoar';

    case blowPlatinum = 'Blow Platinum';

    case cepter = 'Cepter';

    case clovertek = 'Clovertek';

    case visualLand = 'Visual Land';

    case padpro = 'Padpro';

    case inoi = 'Inoi';

    case jumper = 'Jumper';

    case flycoay = 'Flycoay';

    case magch = 'MAGCH';

    case oangcc = 'Oangcc';

    case aocwei = 'AOCWEI';

    case aauw = 'AAUW';

    case vale = 'Vale';

    case relndoo = 'Relndoo';

    case headwolf = 'HeadWolf';

    case hezire = 'Hezire';

    case weelikeit = 'Weelikeit';

    case meswao = 'Meswao';

    case colorroom = 'Colorroom';

    case erisson = 'Erisson';

    case vision = 'Vision';

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
            'hoco' => self::hoco,
            'gtx' => self::gtx,
            'vasoun' => self::vasoun,
            'kenshi' => self::kenshi,
            'wishtel', 'wish-tel', 'wishtel private limited' => self::wishtel,
            'lunnen' => self::lunnen,
            'mipo' => self::mipo,
            'acd' => self::acd,
            'meta', 'meta inc' => self::meta,
            'atozee' => self::atozee,
            'everis' => self::everis,
            'unitech' => self::unitech,
            'stylo' => self::stylo,
            'realix' => self::realix,
            'opelmobile', 'opel mobile', 'opel-mobile' => self::opelmobile,
            'okapimobile', 'okapi mobile', 'okapi-mobile' => self::okapimobile,
            'olax' => self::olax,
            'lville' => self::lville,
            'trimble' => self::trimble,
            'google', 'google inc.' => self::google,
            'apple', 'apple inc' => self::apple,
            'microsoft', 'microsoft corporation' => self::microsoft,
            'ajib' => self::ajib,
            'mintt' => self::mintt,
            'iotwe' => self::iotwe,
            'fenoti' => self::fenoti,
            'sparx' => self::sparx,
            'dcode' => self::dcode,
            'ibrit' => self::ibrit,
            'nordmende', 'talisman brands, inc. d/b/a established' => self::nordmende,
            'vios' => self::vios,
            'atmpc' => self::atmpc,
            'benco' => self::benco,
            'safaricom' => self::safaricom,
            'yumkem' => self::yumkem,
            'bookry', 'bookry ltd.' => self::bookry,
            'tbucci' => self::tbucci,
            'gener8' => self::gener8,
            'omix' => self::omix,
            'yestel' => self::yestel,
            'duoqin' => self::duoqin,
            'vocal' => self::vocal,
            'oscal' => self::oscal,
            'vitumi' => self::vitumi,
            'iiif150', 'shenzhen oxo technology co., ltd.' => self::iiif150,
            'searchcraft', 'searchcraft inc.' => self::searchcraft,
            'dxdcs' => self::dxdcs,
            'databite' => self::databite,
            'senuto', 'senuto sp. z o.o.' => self::senuto,
            'acquia', 'acquia, inc.' => self::acquia,
            'criteo' => self::criteo,
            'nubia' => self::nubia,
            'bigme' => self::bigme,
            'netflix', 'netflix, inc.' => self::netflix,
            'waze' => self::waze,
            'qjy' => self::qjy,
            'meanit' => self::meanit,
            'yezz' => self::yezz,
            'byjus' => self::byjus,
            'joyar' => self::joyar,
            'kalley' => self::kalley,
            'ceibal' => self::ceibal,
            'foxxd' => self::foxxd,
            'vankyo' => self::vankyo,
            'aeezo' => self::aeezo,
            'dna', 'dna oyj' => self::dna,
            'itech', 'itech slu' => self::itech,
            'nexech' => self::nexech,
            'einsundeins', '1 & 1' => self::einsundeins,
            'corn' => self::corn,
            'logic' => self::logic,
            'hammer' => self::hammer,
            'rungee' => self::rungee,
            'bmax' => self::bmax,
            'jambo', 'jambotechnology hakuna matata chill limited' => self::jambo,
            'fanvace' => self::fanvace,
            'rombica' => self::rombica,
            'novis' => self::novis,
            'pritom' => self::pritom,
            'pixus' => self::pixus,
            'tibuta' => self::tibuta,
            'daria' => self::daria,
            'dijitsu' => self::dijitsu,
            'wildred' => self::wildred,
            'asano' => self::asano,
            'hi' => self::hi,
            'scoole' => self::scoole,
            'soundmax' => self::soundmax,
            'topdevice', 'top-device' => self::topdevice,
            'bigben', 'bigben interactive' => self::bigben,
            'krono' => self::krono,
            'calme' => self::calme,
            'xb' => self::xb,
            'ziovo' => self::ziovo,
            'ihunt' => self::ihunt,
            'emporia', 'emporia telecom gmbh & co. kg' => self::emporia,
            'microera' => self::microera,
            'villaon' => self::villaon,
            'zebra', 'zebra technologies corp.' => self::zebra,
            'sonim' => self::sonim,
            'xsmart', 'x-smart' => self::xsmart,
            'moondrop', 'chengdu shuiyueyu technology co., ltd.' => self::moondrop,
            'maxwest' => self::maxwest,
            'fplus', 'f+', 'f-plus' => self::fplus,
            'energizer' => self::energizer,
            'ayya' => self::ayya,
            'xreal' => self::xreal,
            'wainyok' => self::wainyok,
            'hotpepper', 'hot-pepper', 'hot pepper', 'hot pepper mobile, inc.' => self::hotPepper,
            'eaglesoar', 'eagle-soar' => self::eaglesoar,
            'blowplatinum', 'blow platinum', 'blow-platinum' => self::blowPlatinum,
            'cepter' => self::cepter,
            'clovertek' => self::clovertek,
            'visualland', 'visual-land', 'visual land' => self::visualLand,
            'padpro' => self::padpro,
            'inoi' => self::inoi,
            'jumper' => self::jumper,
            'flycoay' => self::flycoay,
            'magch' => self::magch,
            'oangcc' => self::oangcc,
            'aocwei' => self::aocwei,
            'aauw' => self::aauw,
            'vale' => self::vale,
            'relndoo' => self::relndoo,
            'headwolf', 'head-wolf' => self::headwolf,
            'hezire' => self::hezire,
            'weelikeit' => self::weelikeit,
            'meswao' => self::meswao,
            'colorroom' => self::colorroom,
            'erisson' => self::erisson,
            'vision', 'vision technology', 'vision-technology' => self::vision,
            // the last one
            'unknown', '' => self::unknown,
            default => throw new UnexpectedValueException(
                sprintf('the company "%s" is unknown', $name),
            ),
        };
    }

    /**
     * Returns the name of the company
     *
     * @throws void
     */
    #[Override]
    public function getName(): string | null
    {
        return match ($this) {
            self::wishtel => 'Wishtel Private Limited',
            self::meta => 'Meta Inc',
            self::google => 'Google Inc.',
            self::apple => 'Apple Inc',
            self::microsoft => 'Microsoft Corporation',
            self::nordmende => 'Talisman Brands, Inc. d/b/a Established',
            self::bookry => 'Bookry Ltd.',
            self::iiif150 => 'SHENZHEN OXO Technology Co., Ltd.',
            self::searchcraft => 'Searchcraft Inc.',
            self::senuto => 'Senuto Sp. z o.o.',
            self::acquia => 'Acquia, Inc.',
            self::netflix => 'Netflix, Inc.',
            self::dna => 'DNA Oyj',
            self::itech => 'ITECH SLU',
            self::jambo => 'JamboTechnology Hakuna Matata Chill Limited',
            self::bigben => 'Bigben Interactive',
            self::emporia => 'Emporia Telecom GmbH & Co. KG',
            self::zebra => 'Zebra Technologies Corp.',
            self::moondrop => 'Chengdu Shuiyueyu Technology Co., Ltd.',
            self::hotPepper => 'Hot Pepper Mobile, Inc.',
            self::vision => 'Vision Technology',
            self::unknown => null,
            default => $this->value,
        };
    }

    /**
     * Returns the name of the company
     *
     * @throws void
     */
    #[Override]
    public function getBrandname(): string | null
    {
        return match ($this) {
            self::unknown => null,
            default => $this->value,
        };
    }

    /**
     * Returns the name of the company
     *
     * @throws void
     */
    #[Override]
    public function getKey(): string
    {
        return match ($this) {
            self::wishtel => 'wish-tel',
            self::opelmobile => 'opel-mobile',
            self::okapimobile => 'okapi-mobile',
            self::topdevice => 'top-device',
            self::xsmart => 'x-smart',
            self::fplus => 'f-plus',
            self::hotPepper => 'hot-pepper',
            self::eaglesoar => 'eagle-soar',
            self::blowPlatinum => 'blow-platinum',
            self::visualLand => 'visual-land',
            self::headwolf => 'head-wolf',
            self::vision => 'vision-technology',
            default => $this->name,
        };
    }
}
