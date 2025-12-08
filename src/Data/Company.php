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

/** @phpcs:disable SlevomatCodingStandard.Classes.ClassLength.ClassTooLong */
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

    case blow = 'Blow';

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

    case honkuahg = 'HONKUAHG';

    case egotek = 'Egotek';

    case zzb = 'ZZB';

    case newal = 'NEWAL';

    case sber = 'Sber';

    case senna = 'Senna';

    case trecfone = 'TrecFone';

    case thebrowser = 'The Browser Company';

    case readdle = 'Readdle';

    case eightloops = 'eightloops';

    case listia = 'Listia';

    case ecosia = 'Ecosia';

    case nhn = 'NHN';

    case duckDuckGo = 'Duck Duck Go';

    case keeper = 'Keeper Security';

    case lamantineSoftware = 'Lamantine Software';

    case opera = 'Opera';

    case asus = 'Asus';

    case bbk = 'BBK';

    case oppo = 'OPPO';

    case realme = 'Realme';

    case vivo = 'vivo';

    case oneplus = 'OnePlus';

    case huawei = 'Huawei';

    case xiaomi = 'Xiaomi';

    case yandex = 'Yandex';

    case yahoo = 'Yahoo';

    case wordpress = 'WordPress';

    case zoom = 'Zoom';

    case qwant = 'QWANT';

    case qiuwoky = 'Qiuwoky';

    case v7 = 'V7';

    case apoloSign = 'ApoloSign';

    case multilaser = 'Multilaser';

    case premier = 'Premier';

    case volla = 'Volla';

    case nesons = 'Nesons';

    case openbox = 'Openbox';

    case mortal = 'Mortal';

    case homii = 'HOMII';

    case andersson = 'Andersson';

    case whoop = 'Whoop';

    case hanson = 'Hanson';

    case cloudMobile = 'Cloud Mobile';

    case idata = 'iData';

    case anbernic = 'Anbernic';

    case fontel = 'Fontel';

    case consung = 'Consung';

    case novey = 'Novey';

    case iiyama = 'Iiyama';

    case jasmineTea = 'jasmine tea';

    case sowly = 'SOWLY';

    case mione = 'Mione';

    case pagraer = 'Pagraer';

    case unoPhone = 'UnoPhone';

    case gruenberg = 'Grünberg';

    case akai = 'Akai';

    case saba = 'Saba';

    case onyxBoox = 'Onyx Boox';

    case ghia = 'Ghia';

    case eudora = 'Eudora';

    case cuiud = 'CUIUD';

    case biegedy = 'Biegedy';

    case grundig = 'Grundig';

    case duduAuto = 'DUDU AUTO';

    case vorcom = 'Vorcom';

    case hemilton = 'Hemilton';

    case saiet = 'Saiet';

    case syco = 'Syco';

    case mobiWire = 'MobiWire';

    case hometech = 'Hometech';

    case cmf = 'CMF';

    case homatics = 'Homatics';

    case kgtel = 'KGTEL';

    case samsung = 'Samsung';

    case sony = 'Sony';

    case motorola = 'Motorola';

    case oukitel = 'Oukitel';

    case blackview = 'Blackview';

    case zte = 'ZTE';

    case tecno = 'Tecno';

    case poco = 'Poco';

    case infinix = 'Infinix';

    case nothing = 'Nothing';

    case tMobile = 'T-Mobile';

    case doogee = 'Doogee';

    case vortex = 'Vortex';

    case lenovo = 'Lenovo';

    case itel = 'iTel';

    case umi = 'UMIDIGI';

    case cubot = 'Cubot';

    case unihertz = 'Unihertz';

    case allwinner = 'AllWinner';

    case dexp = 'DEXP';

    case onvo = 'Onvo';

    case agm = 'AGM';

    case digma = 'Digma';

    case teclast = 'Teclast';

    case onn = 'Onn';

    case zuum = 'Zuum';

    case amazon = 'Amazon';

    case alldocube = 'Alldocube';

    case hotwav = 'Hotwav';

    case fujitsu = 'Fujitsu';

    case meizu = 'Meizu';

    case casper = 'Casper';

    case ulefone = 'Ulefone';

    case hmdGlobal = 'HMD Global';

    case ltMobile = 'LT Mobile';

    case att = 'AT&T';

    case nokia = 'Nokia';

    case reeder = 'Reeder';

    case fossibot = 'FOSSiBOT';

    case sharp = 'Sharp';

    case cricket = 'Cricket';

    case blu = 'BLU';

    case globalsec = 'GlobalSec';

    case kruegermatz = 'Krüger&Matz';

    case kyocera = 'Kyocera';

    case acer = 'Acer';

    case gigaset = 'Gigaset';

    case tcl = 'TCL';

    case nOne = 'N-One';

    case bq = 'BQ';

    case logicom = 'Logicom';

    case walton = 'Walton';

    case htc = 'HTC';

    case mHorse = 'M-HORSE';

    case generalMobile = 'General Mobile';

    case condor = 'Condor';

    case fairphone = 'Fairphone';

    case mobvoi = 'Mobvoi';

    case iget = 'iGET';

    case xgody = 'Xgody';

    case allcall = 'AllCall';

    case vgoTel = 'VGO Tel';

    case lg = 'LG';

    case aligator = 'Aligator';

    case retroidPocket = 'Retroid Pocket';

    case xView = 'X-View';

    case peaq = 'PEAQ';

    case lava = 'Lava';

    case hafury = 'Hafury';

    case coolpad = 'Coolpad';

    case uhans = 'Uhans';

    case toscido = 'TOSCiDO';

    case sky = 'Sky';

    case wileyfox = 'Wileyfox';

    case oysters = 'Oysters';

    case blackberry = 'BlackBerry';

    case vertu = 'Vertu';

    case ugoos = 'Ugoos';

    case chuwi = 'Chuwi';

    case boostMobile = 'Boost Mobile';

    case ace = 'Ace';

    case gfive = 'GFive';

    case mediacom = 'Mediacom';

    case adreamer = 'Adreamer';

    case cat = 'Cat';

    case micromax = 'Micromax';

    case symphony = 'Symphony';

    case archos = 'Archos';

    case haier = 'Haier';

    case nec = 'NEC';

    case greenLion = 'Green Lion';

    case feonal = 'Feonal';

    case thomson = 'Thomson';

    case majestic = 'Majestic';

    case honor = 'Honor';

    case facetel = 'Facetel';

    case hoozo = 'Hoozo';

    case nuu = 'NUU';

    case maxcom = 'Maxcom';

    case mobicel = 'Mobicel';

    case droidPlayer = 'Droid Player';

    case hisense = 'HiSense';

    case allview = 'Allview';

    case rhino = 'Rhino';

    case freeYond = 'FreeYond';

    case meMobile = 'MeMobile';

    case xMobile = 'X-Mobile';

    case bmobile = 'Bmobile';

    case sohoStyle = 'Soho Style';

    case veidoo = 'Veidoo';

    case crosscall = 'CROSSCALL';

    case mazeSpeed = 'Maze Speed';

    case mKopa = 'M-KOPA';

    case sColor = 'S-Color';

    case hiGrace = 'HiGrace';

    case myphone = 'MyPhone';

    case sigmaMobile = 'Sigma Mobile';

    case goodtel = 'GOODTEL';

    case vontar = 'Vontar';

    case pulid = 'PULID';

    case readboy = 'Readboy';

    case techpad = 'TechPad';

    case blaupunkt = 'Blaupunkt';

    case landRover = 'Land Rover';

    case doro = 'Doro';

    case iconbit = 'iconBIT';

    case eplutus = 'Eplutus';

    case greatAsia = 'Great Asia';

    case fmt = 'FMT';

    case sebbe = 'SEBBE';

    case blackton = 'Blackton';

    case lanix = 'Lanix';

    case xtigi = 'X-Tigi';

    case ruggear = 'RugGear';

    case kinstone = 'Kinstone';

    case sunmax = 'Sunmax';

    case magic = 'Magic';

    case energySistem = 'Energy Sistem';

    case medion = 'Medion';

    case alcatel = 'Alcatel';

    case kemplerStrauss = 'Kempler & Strauss';

    case toshiba = 'Toshiba';

    case wortmann = 'Wortmann';

    case imo = 'IMO';

    case chinaTelecom = 'China Telecom';

    case rephone = 'rephone';

    case magenta = 'Magenta';

    case redline = 'RedLine';

    case skyworth = 'SkyWorth';

    case tesla = 'Tesla';

    case inew = 'iNew';

    case goclever = 'GOCLEVER';

    case irbis = 'Irbis';

    case insys = 'INSYS';

    case spc = 'SPC';

    case lyf = 'LYF';

    case jio = 'Jio';

    case dgtec = 'Dgtec';

    case konrow = 'Konrow';

    case acme = 'ACME';

    case nttSystem = 'NTT System';

    case pcd = 'PCD';

    case philips = 'Philips';

    case conquest = 'Conquest';

    case mozilla = 'Mozilla';

    case baidu = 'Baidu';

    case jusyea = 'JUSYEA';

    case klipad = 'Klipad';

    case alpsmart = 'alpsmart';

    case telia = 'Telia';

    case polaroid = 'Polaroid';

    case bell = 'Bell';

    case everfine = 'Everfine';

    case ucweb = 'UCWeb';

    case karbonn = 'Karbonn';

    case gionee = 'Gionee';

    case caterpillar = 'Caterpillar';

    case acepad = 'Acepad';

    case korax = 'Korax';

    case xppen = 'XPPen';

    case gotv = 'GOtv';

    case skBroadband = 'SK Broadband';

    case transpeed = 'Transpeed';

    case oxtab = 'OX TAB';

    case qlink = 'QLink';

    case smoothMobile = 'Smooth Mobile';

    case canaima = 'Canaima';

    case atouch = 'Atouch';

    case dmoao = 'DMOAO';

    case mecool = 'Mecool';

    case ibm = 'IBM';

    case access = 'Access';

    case berkeley = 'Berkeley';

    case danger = 'Danger';

    case softwareInThePublicInterest = 'Software in the Public Interest';

    case redhat = 'Redhat';

    case freebsd = 'FreeBSD';

    case gentoo = 'Gentoo';

    case haiku = 'Haiku';

    case hp = 'HP';

    case vitanuova = 'Vita Nuova';

    case sun = 'Sun';

    case kaios = 'KaiOS';

    case canonical = 'Canonical';

    case linuxFoundation = 'Linux Foundation';

    case mandriva = 'Mandriva';

    case fabienCoeurjoly = 'Fabien Coeurjoly';

    case mediatek = 'MediaTek';

    case nintendo = 'Nintendo';

    case acceleratedTechnology = 'Accelerated Technology';

    case oracle = 'Oracle';

    case palm = 'Palm';

    case trolltech = 'Trolltech';

    case jide = 'Jide';

    case rim = 'RIM';

    case jolla = 'Jolla';

    case slackware = 'Slackware';

    case ylmf = 'YLMF';

    case suse = 'Suse';

    case syllable = 'Syllable';

    case symbianFoundation = 'Symbian Foundation';

    case ventana = 'Ventana';

    case alibaba = 'Alibaba';

    case nComputing = 'NComputing';

    case cloudMosa = 'CloudMosa';

    case vizio = 'Vizio';

    case dec = 'DEC';

    case enova = 'eNOVA';

    case wozifan = 'WOZIFAN';

    case tjd = 'TJD';

    case rocket = 'Rocket';

    case sunwind = 'SunWind';

    case qilive = 'Qilive';

    case neoregent = 'Neoregent';

    case hiNova = 'Hi Nova';

    case moonchild = 'Moonchild';

    case obigo = 'Obigo';

    case arsslensoft = 'Arsslensoft';

    case positivo = 'Positivo';

    case brondi = 'Brondi';

    case orbic = 'Orbic';

    case tabero = 'Tabero';

    case luna = 'Luna';

    case next = 'NEXT';

    case qin = 'QIN';

    case koobee = 'Koobee';

    case airtel = 'Airtel';

    case siragon = 'Siragon';

    case quantum = 'Quantum';

    case vimoq = 'VIMOQ';

    case fortuneShip = 'FortuneShip';

    case hiby = 'HiBy';

    case chcnav = 'CHCnav';

    case hytera = 'Hytera';

    case urovo = 'Urovo';

    case razer = 'Razer';

    case byd = 'BYD';

    case ans = 'ANS';

    case alps = 'Alps';

    case dialn = 'DIALN';

    case eyemoo = 'Eyemoo';

    case moxee = 'Moxee';

    case ravoz = 'Ravoz';

    case gplus = 'Gplus';

    case o2 = 'O2';

    case techstorm = 'Techstorm';

    case digit4g = 'Digit4G';

    case tadaam = 'TADAAM';

    case netbox = 'NetBox';

    case dynalink = 'Dynalink';

    case sailf = 'SAILF';

    case viipoo = 'VIIPOO';

    case wiko = 'Wiko';

    case star = 'Star';

    case aiwa = 'Aiwa';

    case joysurf = 'JoySurf';

    case island = 'Island';

    case geniusDevices = 'Genius Devices';

    case tuerksat = 'Türksat';

    case bncf = 'BNCF';

    case edanix = 'Edanix';

    case aiplus = 'AI+';

    case voix = 'VOIX';

    case yasin = 'YASIN';

    case redfoxunitedinc = 'RedFoxUnitedInc';

    case tencent = 'Tencent';

    case snap = 'Snap';

    case ilegendsoft = 'iLegendSoft';

    case flipboard = 'Flipboard';

    case slack = 'Slack';

    case gramvis = 'Gramvis';

    case linkedin = 'LinkedIn';

    case emadElsaid = 'Emad Elsaid';

    case twitter = 'Twitter';

    case aloha = 'Aloha';

    case agileBits = 'AgileBits';

    case vmware = 'VMware';

    case streema = 'Streema';

    case radioArabella = 'Radio Arabella';

    case phonostar = 'phonostar';

    case acast = 'Acast';

    case turkcell = 'Turkcell';

    case rakuten = 'Rakuten';

    case srware = 'SRWare';

    case ghostery = 'Ghostery';

    case seznam = 'Seznam';

    case tiktok = 'TikTok';

    case alexanderClauss = 'Alexander Clauss';

    case evernote = 'Evernote';

    case cheetahMobile = 'Cheetah Mobile';

    case dsaSolutions = 'dsa Solutions';

    case gl9 = 'gl9';

    case privacywall = 'PrivacyWall';

    case braveSoftware = 'Brave Software';

    case umeTech = 'Ume Tech';

    case bravoUnicorn = 'Bravo Unicorn';

    case stoutner = 'Stoutner';

    case goodiware = 'Good.iWare';

    case kakao = 'Kakao';

    case pixelMotion = 'Pixel Motion';

    case xbmcfoundation = 'XBMC Foundation';

    case eyeo = 'Eyeo';

    case sfr = 'SFR';

    case moyaApp = 'Moya App';

    case quark = 'Quark';

    case moonshotAI = 'Moonshot AI';

    case deepseekAI = 'DeepSeek AI';

    case keplr = 'Team Keplr';

    case viberMedia = 'Viber Media';

    case canopy = 'Canopy';

    case genspark = 'Genspark';

    case pia = 'PIA';

    case tuYafeng = 'Tu Yafeng';

    case pythonSoftwareFoundation = 'Python Software Foundation';

    case openai = 'OpenAI';

    case telegram = 'Telegram';

    case cloudviewTechnology = 'CloudView Technology';

    case soulSoft = 'SoulSoft';

    case qihoo = 'Qihoo';

    case line = 'LINE';

    case nortonMobile = 'NortonMobile';

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
            'meta', 'meta platforms, inc.' => self::meta,
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
            'blow' => self::blow,
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
            'honkuahg' => self::honkuahg,
            'egotek' => self::egotek,
            'zzb' => self::zzb,
            'newal' => self::newal,
            'sber' => self::sber,
            'senna' => self::senna,
            'trecfone' => self::trecfone,
            'the-browser-company', 'the browser company', 'the browser company of new york', 'thebrowser' => self::thebrowser,
            'readdle' => self::readdle,
            'eightloops', 'eightloops gmbh' => self::eightloops,
            'listia', 'listia inc.' => self::listia,
            'ecosia', 'ecosia gmbh' => self::ecosia,
            'nhn', 'nhn-corporation', 'nhn corporation' => self::nhn,
            'duckduckgo', 'duck duck go', 'duck duck go inc.', 'duck-duck-go' => self::duckDuckGo,
            'keeper', 'keeper security', 'keeper security, inc.' => self::keeper,
            'lamantine-software', 'lamantine software', 'lamantinesoftware' => self::lamantineSoftware,
            'opera', 'opera software asa' => self::opera,
            'asus', 'asustek computer inc.' => self::asus,
            'bbk', 'bbk electronics corp ltd' => self::bbk,
            'oppo', 'oppo electronics corp.' => self::oppo,
            'realme' => self::realme,
            'vivo', 'vivo electronics corp.' => self::vivo,
            'oneplus', 'shenzhen oneplus science & technology co., ltd.' => self::oneplus,
            'huawei' => self::huawei,
            'xiaomi', 'xiaomi tech' => self::xiaomi,
            'yandex', 'yandex llc' => self::yandex,
            'yahoo', 'yahoo! inc.' => self::yahoo,
            'wordpress', 'wordpress.org' => self::wordpress,
            'zoom', 'zoom communications inc.' => self::zoom,
            'qwant', 'qwant sas' => self::qwant,
            'qiuwoky' => self::qiuwoky,
            'v7', 'v7 devices' => self::v7,
            'apolosign', 'apolo-sign' => self::apoloSign,
            'multilaser' => self::multilaser,
            'premier' => self::premier,
            'volla', 'volla systeme gmbh' => self::volla,
            'nesons' => self::nesons,
            'openbox' => self::openbox,
            'mortal' => self::mortal,
            'homii' => self::homii,
            'andersson' => self::andersson,
            'whoop' => self::whoop,
            'hanson' => self::hanson,
            'cloudmobile', 'cloud-mobile', 'cloud mobile' => self::cloudMobile,
            'idata' => self::idata,
            'anbernic' => self::anbernic,
            'fontel' => self::fontel,
            'consung' => self::consung,
            'novey' => self::novey,
            'iiyama' => self::iiyama,
            'jasmine tea', 'jasminetea', 'jasmine-tea' => self::jasmineTea,
            'sowly' => self::sowly,
            'mione' => self::mione,
            'pagraer' => self::pagraer,
            'unophone', 'uno-phone' => self::unoPhone,
            'grünberg', 'gruenberg' => self::gruenberg,
            'akai' => self::akai,
            'saba' => self::saba,
            'onyxboox', 'onyx boox', 'onyx-boox' => self::onyxBoox,
            'ghia' => self::ghia,
            'eudora' => self::eudora,
            'cuiud' => self::cuiud,
            'biegedy' => self::biegedy,
            'grundig' => self::grundig,
            'duduauto', 'dudu auto', 'dudu-auto' => self::duduAuto,
            'vorcom' => self::vorcom,
            'hemilton' => self::hemilton,
            'saiet' => self::saiet,
            'syco' => self::syco,
            'mobiwire', 'mobi-wire' => self::mobiWire,
            'hometech' => self::hometech,
            'cmf' => self::cmf,
            'homatics' => self::homatics,
            'kgtel' => self::kgtel,
            'samsung' => self::samsung,
            'sony' => self::sony,
            'motorola' => self::motorola,
            'oukitel', 'shenzhen yunji intelligent technology co,.ltd.' => self::oukitel,
            'blackview', 'blackview international group' => self::blackview,
            'zte' => self::zte,
            'tecno', 'tecno mobile' => self::tecno,
            'poco' => self::poco,
            'infinix', 'infinix inc.' => self::infinix,
            'nothing', 'nothing-phone', 'nothing technology ltd' => self::nothing,
            'tmobile', 't-mobile' => self::tMobile,
            'doogee' => self::doogee,
            'vortex' => self::vortex,
            'lenovo' => self::lenovo,
            'itel', 'itel mobile' => self::itel,
            'umi', 'umidigi' => self::umi,
            'cubot' => self::cubot,
            'unihertz' => self::unihertz,
            'allwinner' => self::allwinner,
            'dexp' => self::dexp,
            'onvo' => self::onvo,
            'agm' => self::agm,
            'digma' => self::digma,
            'teclast' => self::teclast,
            'onn' => self::onn,
            'zuum' => self::zuum,
            'amazon', 'amazon.com, inc.' => self::amazon,
            'alldocube' => self::alldocube,
            'hotwav' => self::hotwav,
            'fujitsu' => self::fujitsu,
            'meizu', 'meizu technology co., ltd.' => self::meizu,
            'casper' => self::casper,
            'ulefone', 'ulefone technology co., ltd.' => self::ulefone,
            'hmdglobal', 'hmd global', 'hmd-global', 'hmd global oy' => self::hmdGlobal,
            'ltmobile', 'lt-mobile', 'lt mobile' => self::ltMobile,
            'at&t', 'att', 'at-t' => self::att,
            'nokia' => self::nokia,
            'reeder' => self::reeder,
            'fossibot', 'fossi-bot' => self::fossibot,
            'sharp', 'sharp corporation' => self::sharp,
            'cricket' => self::cricket,
            'blu' => self::blu,
            'globalsec', 'global-sec' => self::globalsec,
            'kruegermatz', 'krüger&matz', 'kruger-matz' => self::kruegermatz,
            'kyocera' => self::kyocera,
            'acer' => self::acer,
            'gigaset', 'gigaset communications gmbh' => self::gigaset,
            'tcl', 'tcl communication ltd.' => self::tcl,
            'none', 'n-one' => self::nOne,
            'bq' => self::bq,
            'logicom' => self::logicom,
            'walton', 'walton hi-tech industries ltd.' => self::walton,
            'htc' => self::htc,
            'mhorse', 'm-horse' => self::mHorse,
            'generalmobile', 'general-mobile', 'general mobile' => self::generalMobile,
            'condor' => self::condor,
            'fairphone' => self::fairphone,
            'mobvoi' => self::mobvoi,
            'iget' => self::iget,
            'xgody' => self::xgody,
            'allcall' => self::allcall,
            'vgotel', 'vgo tel', 'vgo-tel' => self::vgoTel,
            'lg' => self::lg,
            'aligator' => self::aligator,
            'retroidpocket', 'retroid pocket', 'retroid-pocket' => self::retroidPocket,
            'xview', 'x-view' => self::xView,
            'peaq' => self::peaq,
            'lava' => self::lava,
            'hafury' => self::hafury,
            'coolpad' => self::coolpad,
            'uhans' => self::uhans,
            'toscido' => self::toscido,
            'sky' => self::sky,
            'wileyfox' => self::wileyfox,
            'oysters' => self::oysters,
            'blackberry', 'blackberry limited', 'black-berry' => self::blackberry,
            'vertu' => self::vertu,
            'ugoos' => self::ugoos,
            'chuwi', 'chuwi inc' => self::chuwi,
            'boostmobile', 'boost-mobile', 'boost mobile' => self::boostMobile,
            'ace' => self::ace,
            'gfive' => self::gfive,
            'mediacom' => self::mediacom,
            'adreamer' => self::adreamer,
            'cat', 'catsound', 's4 handelsgruppe gmbh' => self::cat,
            'micromax', 'micromax informatics ltd.' => self::micromax,
            'symphony' => self::symphony,
            'archos', 'archos s.a.' => self::archos,
            'haier' => self::haier,
            'nec' => self::nec,
            'greenlion', 'green lion', 'green-lion' => self::greenLion,
            'feonal' => self::feonal,
            'thomson' => self::thomson,
            'majestic' => self::majestic,
            'honor' => self::honor,
            'facetel' => self::facetel,
            'hoozo' => self::hoozo,
            'nuu', 'nuu-mobile', 'nuu mobile' => self::nuu,
            'maxcom' => self::maxcom,
            'mobicel' => self::mobicel,
            'droidplayer', 'droid-player', 'droid player' => self::droidPlayer,
            'hisense', 'hisense company ltd.' => self::hisense,
            'allview', 'allview electronics sp. z o.o.' => self::allview,
            'rhino' => self::rhino,
            'freeyond', 'free-yond' => self::freeYond,
            'memobile', 'me-mobile' => self::meMobile,
            'xmobile', 'x-mobile' => self::xMobile,
            'bmobile' => self::bmobile,
            'sohostyle', 'soho style', 'soho-style' => self::sohoStyle,
            'veidoo' => self::veidoo,
            'crosscall', 'crosscall sas' => self::crosscall,
            'mazespeed', 'maze speed', 'maze-speed' => self::mazeSpeed,
            'mkopa', 'm-kopa' => self::mKopa,
            'scolor', 's-color' => self::sColor,
            'higrace', 'hi-grace' => self::hiGrace,
            'myphone' => self::myphone,
            'sigmamobile', 'sigma mobile', 'sigma-mobile' => self::sigmaMobile,
            'goodtel' => self::goodtel,
            'vontar' => self::vontar,
            'pulid' => self::pulid,
            'readboy' => self::readboy,
            'techpad' => self::techpad,
            'blaupunkt' => self::blaupunkt,
            'landrover', 'land rover', 'land-rover' => self::landRover,
            'doro', 'doro ab' => self::doro,
            'iconbit' => self::iconbit,
            'eplutus', 'richmond international (hong kong) electronic technology development co.,ltd' => self::eplutus,
            'greatasia', 'great asia', 'great-asia' => self::greatAsia,
            'fmt' => self::fmt,
            'sebbe' => self::sebbe,
            'blackton' => self::blackton,
            'lanix', 'lanix mobile' => self::lanix,
            'xtigi', 'x-tigi' => self::xtigi,
            'ruggear' => self::ruggear,
            'kinstone' => self::kinstone,
            'sunmax' => self::sunmax,
            'magic' => self::magic,
            'energysistem', 'energy sistem', 'energy-sistem' => self::energySistem,
            'medion' => self::medion,
            'alcatel' => self::alcatel,
            'kemplerstrauss', 'kempler & strauss', 'kempler-strauss', 'kempler and strauss' => self::kemplerStrauss,
            'toshiba' => self::toshiba,
            'wortmann', 'wortmann ag' => self::wortmann,
            'imo', 'verve connect limited' => self::imo,
            'chinatelecom', 'china telecom', 'china-telecom' => self::chinaTelecom,
            'rephone' => self::rephone,
            'magenta' => self::magenta,
            'redline' => self::redline,
            'skyworth', 'sky-worth' => self::skyworth,
            'tesla' => self::tesla,
            'inew' => self::inew,
            'goclever' => self::goclever,
            'irbis' => self::irbis,
            'insys' => self::insys,
            'spc' => self::spc,
            'lyf' => self::lyf,
            'jio' => self::jio,
            'dgtec' => self::dgtec,
            'konrow' => self::konrow,
            'acme', 'acme grupe' => self::acme,
            'nttsystem', 'ntt system', 'ntt-system' => self::nttSystem,
            'pcd' => self::pcd,
            'philips' => self::philips,
            'conquest' => self::conquest,
            'mozilla', 'mozilla-foundation', 'mozilla foundation' => self::mozilla,
            'baidu' => self::baidu,
            'jusyea' => self::jusyea,
            'klipad' => self::klipad,
            'alpsmart' => self::alpsmart,
            'telia' => self::telia,
            'polaroid' => self::polaroid,
            'bell' => self::bell,
            'everfine' => self::everfine,
            'ucweb', 'ucweb inc.' => self::ucweb,
            'karbonn' => self::karbonn,
            'gionee' => self::gionee,
            'caterpillar' => self::caterpillar,
            'acepad' => self::acepad,
            'korax' => self::korax,
            'xppen', 'xp-pen' => self::xppen,
            'gotv', 'go-tv' => self::gotv,
            'skbroadband', 'sk broadband', 'sk-broadband' => self::skBroadband,
            'transpeed' => self::transpeed,
            'oxtab', 'ox tab', 'ox-tab' => self::oxtab,
            'qlink' => self::qlink,
            'smoothmobile', 'smooth mobile', 'smooth-mobile' => self::smoothMobile,
            'canaima' => self::canaima,
            'atouch' => self::atouch,
            'dmoao' => self::dmoao,
            'mecool' => self::mecool,
            'ibm' => self::ibm,
            'access', 'access co., ltd.' => self::access,
            'berkeley', 'berkley-university', 'university of california, berkeley' => self::berkeley,
            'danger', 'danger, inc.' => self::danger,
            'softwareinthepublicinterest', 'software in the public interest', 'software-in-the-public-interest', 'software in the public interest, inc.' => self::softwareInThePublicInterest,
            'redhat', 'red hat inc' => self::redhat,
            'freebsd', 'free-bsd-foundation', 'freebsd foundation' => self::freebsd,
            'gentoo', 'gentoo foundation inc' => self::gentoo,
            'haiku', 'haiku, inc.' => self::haiku,
            'hp', 'hp inc.' => self::hp,
            'vitanuova', 'vita nuova', 'vita-nuova', 'vita nuova holdings ltd' => self::vitanuova,
            'sun', 'sun-microsystems', 'sun microsystems, inc.' => self::sun,
            'kaios', 'kaios technologies' => self::kaios,
            'canonical', 'canonical foundation' => self::canonical,
            'linuxfoundation', 'linux foundation', 'linux-foundation' => self::linuxFoundation,
            'mandriva' => self::mandriva,
            'fabiencoeurjoly', 'fabien coeurjoly' => self::fabienCoeurjoly,
            'mediatek' => self::mediatek,
            'nintendo' => self::nintendo,
            'acceleratedtechnology', 'accelerated technology', 'accelerated-technology' => self::acceleratedTechnology,
            'oracle' => self::oracle,
            'palm' => self::palm,
            'trolltech' => self::trolltech,
            'jide', 'jide technology' => self::jide,
            'rim', 'research in motion limited' => self::rim,
            'jolla', 'jolla ltd.' => self::jolla,
            'slackware', 'slackware linux, inc.' => self::slackware,
            'ylmf', 'ylmf computer technology co., ltd.' => self::ylmf,
            'suse' => self::suse,
            'syllable', 'syllable project' => self::syllable,
            'symbianfoundation', 'symbian foundation', 'symbian-foundation' => self::symbianFoundation,
            'ventana' => self::ventana,
            'alibaba', 'alibaba group holding limited' => self::alibaba,
            'ncomputing', 'n-computing' => self::nComputing,
            'cloudmosa', 'cloud-mosa', 'cloudmosa inc.' => self::cloudMosa,
            'vizio' => self::vizio,
            'dec', 'digital equipment corporation' => self::dec,
            'enova' => self::enova,
            'wozifan' => self::wozifan,
            'tjd' => self::tjd,
            'rocket' => self::rocket,
            'sunwind', 'sun-wind' => self::sunwind,
            'qilive' => self::qilive,
            'neoregent' => self::neoregent,
            'hinova', 'hi nova', 'hi-nova' => self::hiNova,
            'moonchild', 'moonchild productions', 'moonchild-productions' => self::moonchild,
            'obigo' => self::obigo,
            'arsslensoft' => self::arsslensoft,
            'positivo' => self::positivo,
            'brondi' => self::brondi,
            'orbic' => self::orbic,
            'tabero' => self::tabero,
            'luna' => self::luna,
            'next' => self::next,
            'qin' => self::qin,
            'koobee', 'shenzhen koobee communication equipment co.,ltd' => self::koobee,
            'airtel' => self::airtel,
            'siragon' => self::siragon,
            'quantum' => self::quantum,
            'vimoq' => self::vimoq,
            'fortuneship', 'fortune-ship' => self::fortuneShip,
            'hiby', 'hi-by' => self::hiby,
            'chcnav' => self::chcnav,
            'hytera' => self::hytera,
            'urovo' => self::urovo,
            'razer' => self::razer,
            'byd' => self::byd,
            'ans' => self::ans,
            'alps' => self::alps,
            'dialn' => self::dialn,
            'eyemoo' => self::eyemoo,
            'moxee' => self::moxee,
            'ravoz' => self::ravoz,
            'gplus' => self::gplus,
            'o2' => self::o2,
            'techstorm' => self::techstorm,
            'digit4g' => self::digit4g,
            'tadaam' => self::tadaam,
            'netbox' => self::netbox,
            'dynalink' => self::dynalink,
            'sailf' => self::sailf,
            'viipoo' => self::viipoo,
            'wiko' => self::wiko,
            'star' => self::star,
            'aiwa' => self::aiwa,
            'joysurf', 'joy-surf' => self::joysurf,
            'island', 'island technology, inc.' => self::island,
            'geniusdevices', 'genius-devices', 'genius devices' => self::geniusDevices,
            'türksat', 'tuerksat', 'turksat' => self::tuerksat,
            'bncf' => self::bncf,
            'edanix' => self::edanix,
            'aiplus', 'ai+', 'ai-plus' => self::aiplus,
            'voix' => self::voix,
            'yasin' => self::yasin,
            'redfoxunitedinc' => self::redfoxunitedinc,
            'tencent', 'tencent holdings ltd.' => self::tencent,
            'snap', 'snap inc.' => self::snap,
            'ilegendsoft', 'ilegendsoft, inc.' => self::ilegendsoft,
            'flipboard', 'flipboard, inc.' => self::flipboard,
            'slack', 'slack technologies' => self::slack,
            'gramvis', 'gramvis lab' => self::gramvis,
            'linkedin', 'linkedin corporation', 'linked-in' => self::linkedin,
            'emadelsaid', 'emad-elsaid', 'emad elsaid' => self::emadElsaid,
            'twitter' => self::twitter,
            'aloha', 'aloha mobile ltd.', 'aloha-mobile' => self::aloha,
            'agilebits', 'agilebits, inc.', 'agile-bits' => self::agileBits,
            'vmware', 'vmware, inc.' => self::vmware,
            'streema' => self::streema,
            'radioarabella', 'radio arabella studiobetriebsges. mbh', 'radio-arabella', 'radio arabella' => self::radioArabella,
            'phonostar', 'phonostar gmbh' => self::phonostar,
            'acast', 'acast ab' => self::acast,
            'turkcell', 'turkcell iletisim hizmetleri a.s.' => self::turkcell,
            'rakuten' => self::rakuten,
            'srware' => self::srware,
            'ghostery', 'ghostery, inc.' => self::ghostery,
            'seznam', 'seznam.cz, a.s.' => self::seznam,
            'tiktok', 'tiktok pte. ltd.' => self::tiktok,
            'alexanderclauss', 'alexander clauss', 'alexander-clauss' => self::alexanderClauss,
            'evernote', 'evernote corporation' => self::evernote,
            'cheetahmobile', 'cheetah-mobile', 'cheetah mobile' => self::cheetahMobile,
            'dsasolutions', 'dsa-solutions', 'dsa solutions gmbh', 'dsa solutions' => self::dsaSolutions,
            'gl9' => self::gl9,
            'privacywall' => self::privacywall,
            'bravesoftware', 'brave-software', 'brave software inc.', 'brave software' => self::braveSoftware,
            'umetech', 'ume-tech', 'ume tech' => self::umeTech,
            'bravounicorn', 'bravo-unicorn', 'bravo unicorn pte. ltd', 'bravo unicorn' => self::bravoUnicorn,
            'stoutner' => self::stoutner,
            'goodiware', 'good-iware', 'good.iware, inc.', 'good.iware' => self::goodiware,
            'kakao', 'kakao corp.' => self::kakao,
            'pixelmotion', 'pixel-motion', 'pixel motion inc.', 'pixel motion' => self::pixelMotion,
            'xbmcfoundation', 'xbmc-foundation', 'xbmc foundation' => self::xbmcfoundation,
            'eyeo', 'eyeo gmbh' => self::eyeo,
            'sfr', 'societe francaise du radiotelephone' => self::sfr,
            'moyaapp', 'moya-app', 'moya app (pty) ltd', 'moya app' => self::moyaApp,
            'quark', 'quark-team', 'quark team' => self::quark,
            'moonshotai', 'moonshot-ai', 'moonshot ai' => self::moonshotAI,
            'deepseekai', 'deepseek ai', 'deepseek-ai', 'hangzhou deepseek artificial intelligence basic technology research co., ltd.' => self::deepseekAI,
            'keplr', 'team keplr', 'team-keplr' => self::keplr,
            'vibermedia', 'viber media', 'viber-media' => self::viberMedia,
            'canopy' => self::canopy,
            'genspark' => self::genspark,
            'pia', 'pia private internet access, inc' => self::pia,
            'tuyafeng', 'tu-yafeng', 'tu yafeng' => self::tuYafeng,
            'pythonsoftwarefoundation', 'python-software-foundation', 'python software foundation' => self::pythonSoftwareFoundation,
            'openai', 'openai lp' => self::openai,
            'telegram', 'telegram messenger inc.' => self::telegram,
            'cloudviewtechnology', 'cloudview-technology', 'cloudview technology' => self::cloudviewTechnology,
            'soulsoft', 'soul-soft' => self::soulSoft,
            'qihoo', 'qihoo 360 technology co. ltd.' => self::qihoo,
            'line', 'line corporation' => self::line,
            'nortonmobile', 'norton-mobile' => self::nortonMobile,
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
            self::meta => 'Meta Platforms, Inc.',
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
            self::thebrowser => 'The Browser Company of New York',
            self::eightloops => 'eightloops GmbH',
            self::listia => 'Listia Inc.',
            self::ecosia => 'Ecosia GmbH',
            self::nhn => 'NHN Corporation',
            self::duckDuckGo => 'Duck Duck Go Inc.',
            self::keeper => 'Keeper Security, Inc.',
            self::opera => 'Opera Software ASA',
            self::asus => 'ASUSTeK Computer Inc.',
            self::bbk => 'BBK Electronics Corp Ltd',
            self::oppo => 'OPPO Electronics Corp.',
            self::vivo => 'Vivo Electronics Corp.',
            self::oneplus => 'Shenzhen OnePlus Science & Technology Co., Ltd.',
            self::xiaomi => 'Xiaomi Tech',
            self::yandex => 'Yandex LLC',
            self::yahoo => 'Yahoo! Inc.',
            self::wordpress => 'wordpress.org',
            self::zoom => 'Zoom Communications Inc.',
            self::qwant => 'QWANT SAS',
            self::v7 => 'V7 Devices',
            self::volla => 'Volla Systeme GmbH',
            self::oukitel => 'Shenzhen Yunji Intelligent Technology Co,.Ltd.',
            self::blackview => 'Blackview International Group',
            self::tecno => 'Tecno Mobile',
            self::infinix => 'Infinix Inc.',
            self::nothing => 'Nothing Technology Ltd',
            self::itel => 'iTel Mobile',
            self::amazon => 'Amazon.com, Inc.',
            self::meizu => 'Meizu Technology Co., Ltd.',
            self::ulefone => 'Ulefone Technology Co., Ltd.',
            self::hmdGlobal => 'HMD Global Oy',
            self::sharp => 'Sharp Corporation',
            self::gigaset => 'Gigaset Communications GmbH',
            self::tcl => 'TCL Communication Ltd.',
            self::walton => 'Walton Hi-Tech Industries Ltd.',
            self::blackberry => 'BlackBerry Limited',
            self::chuwi => 'CHUWI Inc',
            self::cat => 'S4 Handelsgruppe GmbH',
            self::micromax => 'Micromax Informatics Ltd.',
            self::archos => 'Archos S.A.',
            self::nuu => 'NUU Mobile',
            self::hisense => 'HiSense Company Ltd.',
            self::allview => 'Allview Electronics SP. Z O.O.',
            self::crosscall => 'CROSSCALL SAS',
            self::doro => 'Doro AB',
            self::eplutus => 'Richmond International (Hong Kong) Electronic Technology Development Co.,Ltd',
            self::lanix => 'Lanix Mobile',
            self::wortmann => 'Wortmann AG',
            self::imo => 'Verve Connect Limited',
            self::acme => 'ACME Grupe',
            self::mozilla => 'Mozilla Foundation',
            self::ucweb => 'UCWeb Inc.',
            self::access => 'Access Co., Ltd.',
            self::berkeley => 'University of California, Berkeley',
            self::danger => 'Danger, Inc.',
            self::softwareInThePublicInterest => 'Software in the Public Interest, Inc.',
            self::redhat => 'Red Hat Inc',
            self::freebsd => 'FreeBSD Foundation',
            self::gentoo => 'Gentoo Foundation Inc',
            self::haiku => 'Haiku, Inc.',
            self::hp => 'HP Inc.',
            self::vitanuova => 'Vita Nuova Holdings Ltd',
            self::sun => 'Sun Microsystems, Inc.',
            self::kaios => 'KaiOS Technologies',
            self::canonical => 'Canonical Foundation',
            self::jide => 'Jide Technology',
            self::rim => 'Research in Motion Limited',
            self::jolla => 'Jolla Ltd.',
            self::slackware => 'Slackware Linux, Inc.',
            self::ylmf => 'YLMF Computer Technology Co., Ltd.',
            self::syllable => 'Syllable Project',
            self::alibaba => 'Alibaba Group Holding Limited',
            self::cloudMosa => 'CloudMosa Inc.',
            self::dec => 'Digital Equipment Corporation',
            self::moonchild => 'Moonchild Productions',
            self::koobee => 'Shenzhen koobee Communication Equipment Co.,Ltd',
            self::island => 'Island Technology, Inc.',
            self::tencent => 'Tencent Holdings Ltd.',
            self::snap => 'Snap Inc.',
            self::ilegendsoft => 'iLegendSoft, Inc.',
            self::flipboard => 'Flipboard, Inc.',
            self::slack => 'Slack Technologies',
            self::gramvis => 'Gramvis Lab',
            self::linkedin => 'LinkedIn Corporation',
            self::aloha => 'Aloha Mobile Ltd.',
            self::agileBits => 'AgileBits, Inc.',
            self::vmware => 'VMware, Inc.',
            self::radioArabella => 'Radio Arabella Studiobetriebsges. mbH',
            self::phonostar => 'phonostar GmbH',
            self::acast => 'Acast AB',
            self::turkcell => 'Turkcell Iletisim Hizmetleri A.S.',
            self::ghostery => 'Ghostery, Inc.',
            self::seznam => 'Seznam.cz, a.s.',
            self::tiktok => 'TikTok Pte. Ltd.',
            self::evernote => 'Evernote Corporation',
            self::dsaSolutions => 'dsa Solutions GmbH',
            self::braveSoftware => 'Brave Software Inc.',
            self::bravoUnicorn => 'Bravo Unicorn Pte. Ltd',
            self::goodiware => 'Good.iWare, Inc.',
            self::kakao => 'Kakao Corp.',
            self::pixelMotion => 'Pixel Motion Inc.',
            self::eyeo => 'Eyeo GmbH',
            self::sfr => 'SOCIETE FRANCAISE DU RADIOTELEPHONE',
            self::moyaApp => 'Moya App (Pty) Ltd',
            self::quark => 'Quark Team',
            self::deepseekAI => 'Hangzhou DeepSeek Artificial Intelligence Basic Technology Research Co., Ltd.',
            self::pia => 'PIA Private Internet Access, Inc',
            self::openai => 'OpenAI LP',
            self::telegram => 'Telegram Messenger Inc.',
            self::qihoo => 'Qihoo 360 Technology Co. Ltd.',
            self::line => 'LINE Corporation',
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
            self::visualLand => 'visual-land',
            self::headwolf => 'head-wolf',
            self::vision => 'vision-technology',
            self::thebrowser => 'the-browser-company',
            self::nhn => 'nhn-corporation',
            self::duckDuckGo => 'duck-duck-go',
            self::lamantineSoftware => 'lamantine-software',
            self::apoloSign => 'apolo-sign',
            self::cloudMobile => 'cloud-mobile',
            self::jasmineTea => 'jasmine-tea',
            self::unoPhone => 'uno-phone',
            self::onyxBoox => 'onyx-boox',
            self::duduAuto => 'dudu-auto',
            self::mobiWire => 'mobi-wire',
            self::nothing => 'nothing-phone',
            self::tMobile => 't-mobile',
            self::hmdGlobal => 'hmd-global',
            self::ltMobile => 'lt-mobile',
            self::att => 'at-t',
            self::fossibot => 'fossi-bot',
            self::globalsec => 'global-sec',
            self::kruegermatz => 'kruger-matz',
            self::nOne => 'n-one',
            self::mHorse => 'm-horse',
            self::generalMobile => 'general-mobile',
            self::vgoTel => 'vgo-tel',
            self::retroidPocket => 'retroid-pocket',
            self::xView => 'x-view',
            self::blackberry => 'black-berry',
            self::boostMobile => 'boost-mobile',
            self::cat => 'catsound',
            self::greenLion => 'green-lion',
            self::nuu => 'nuu-mobile',
            self::droidPlayer => 'droid-player',
            self::freeYond => 'free-yond',
            self::meMobile => 'me-mobile',
            self::xMobile => 'x-mobile',
            self::sohoStyle => 'soho-style',
            self::mazeSpeed => 'maze-speed',
            self::mKopa => 'm-kopa',
            self::sColor => 's-color',
            self::hiGrace => 'hi-grace',
            self::sigmaMobile => 'sigma-mobile',
            self::landRover => 'land-rover',
            self::greatAsia => 'great-asia',
            self::xtigi => 'x-tigi',
            self::energySistem => 'energy-sistem',
            self::kemplerStrauss => 'kempler-strauss',
            self::chinaTelecom => 'china-telecom',
            self::skyworth => 'sky-worth',
            self::nttSystem => 'ntt-system',
            self::mozilla => 'mozilla-foundation',
            self::xppen => 'xp-pen',
            self::gotv => 'go-tv',
            self::skBroadband => 'sk-broadband',
            self::oxtab => 'ox-tab',
            self::smoothMobile => 'smooth-mobile',
            self::berkeley => 'berkley-university',
            self::softwareInThePublicInterest => 'software-in-the-public-interest',
            self::freebsd => 'free-bsd-foundation',
            self::vitanuova => 'vita-nuova',
            self::sun => 'sun-microsystems',
            self::linuxFoundation => 'linux-foundation',
            self::fabienCoeurjoly => 'fabien coeurjoly',
            self::acceleratedTechnology => 'accelerated-technology',
            self::symbianFoundation => 'symbian-foundation',
            self::nComputing => 'n-computing',
            self::cloudMosa => 'cloud-mosa',
            self::sunwind => 'sun-wind',
            self::hiNova => 'hi-nova',
            self::moonchild => 'moonchild-productions',
            self::fortuneShip => 'fortune-ship',
            self::hiby => 'hi-by',
            self::joysurf => 'joy-surf',
            self::geniusDevices => 'genius-devices',
            self::tuerksat => 'turksat',
            self::aiplus => 'ai-plus',
            self::linkedin => 'linked-in',
            self::emadElsaid => 'emad-elsaid',
            self::aloha => 'aloha-mobile',
            self::agileBits => 'agile-bits',
            self::radioArabella => 'radio-arabella',
            self::alexanderClauss => 'alexander-clauss',
            self::cheetahMobile => 'cheetah-mobile',
            self::dsaSolutions => 'dsa-solutions',
            self::braveSoftware => 'brave-software',
            self::umeTech => 'ume-tech',
            self::bravoUnicorn => 'bravo-unicorn',
            self::goodiware => 'good-iware',
            self::pixelMotion => 'pixel-motion',
            self::xbmcfoundation => 'xbmc-foundation',
            self::moyaApp => 'moya-app',
            self::quark => 'quark-team',
            self::moonshotAI => 'moonshot-ai',
            self::deepseekAI => 'deepseek-ai',
            self::keplr => 'team-keplr',
            self::viberMedia => 'viber-media',
            self::tuYafeng => 'tu-yafeng',
            self::pythonSoftwareFoundation => 'python-software-foundation',
            self::cloudviewTechnology => 'cloudview-technology',
            self::soulSoft => 'soul-soft',
            self::nortonMobile => 'norton-mobile',
            default => $this->name,
        };
    }
}
