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

namespace BrowserDetector\Data;

use Override;
use UaData\CompanyInterface;
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

    case matomo = 'Matomo';

    case akaMessenger = 'aka Messenger';

    case tuneIn = 'TuneIn';

    case onecook = 'Onecook';

    case softmeTech = 'Softme Tech';

    case intel = 'Intel';

    case readly = 'Readly';

    case avast = 'AVAST';

    case appsmedia = 'AppsMedia';

    case kaweApps = 'Kawe Apps';

    case reuters = 'Reuters';

    case playitTechnology = 'PLAYIT TECHNOLOGY';

    case xing = 'XING';

    case fSecure = 'F-Secure';

    case suaat = 'SUAAT';

    case gTab = 'G-Tab';

    case polestar = 'Polestar';

    case kinogoGe = 'Kinogo.ge';

    case cookieJarApps = 'CookieJarApps';

    case larsWindolf = 'Lars Windolf';

    case videoDownloadStudio = 'Video Download Studio';

    case maxthon = 'Maxthon';

    case yobiMobi = 'Yobi Mobi';

    case myHomeScreen = 'My Home Screen';

    case blueWalletServices = 'BlueWallet Services';

    case anyDeskSoftware = 'AnyDesk Software';

    case towoLabs = 'Towo Labs';

    case talkTalkTelecom = 'TalkTalk Telecom';

    case kpn = 'KPN';

    case mopotab = 'MopoTab';

    case quora = 'Quora';

    case morris = 'Morris';

    case dezor = 'Dezor';

    case bestseller = 'Bestseller';

    case hazuki = 'hazuki';

    case surfboard = 'Surfboard';

    case tenta = 'Tenta';

    case mobileV5 = 'Mobile_V5';

    case swisscows = 'Swisscows';

    case wolvesInteractive = 'Wolves Interactive';

    case buhlDataService = 'Buhl Data Service';

    case baySpringMedia = 'Bay Spring Media';

    case twoKitConsulting = '2kit consulting';

    case volcanoTechnology = 'Volcano Technology';

    case omshyApps = 'OmshyApps';

    case reddit = 'reddit';

    case thinkFree = 'THINK FREE';

    case nifty = 'NIFTY';

    case wiseplayApps = 'Wiseplay Apps';

    case canon = 'Canon';

    case intex = 'Intex';

    case orange = 'Orange';

    case accent = 'Accent';

    case ipro = 'IPRO';

    case castify = 'Castify';

    case theNewYorkTimes = 'The New York Times';

    case vishaGroup = 'Visha Group';

    case spring = 'Spring';

    case gnome = 'GNOME';

    case kde = 'KDE';

    case gnu = 'GNU';

    case asdDev = 'ASD Dev';

    case dsTools = 'DS tools';

    case npr = 'NPR';

    case appsForGoogle = 'Apps For Google';

    case italiaonline = 'Italiaonline';

    case telekom = 'Telekom';

    case armobsoft = 'Armobsoft';

    case kaldor = 'Kaldor';

    case podverse = 'Podverse';

    case mediahuisNrc = 'Mediahuis NRC';

    case globalMediaEntertainment = 'Global Media & Entertainment';

    case kajabi = 'Kajabi';

    case iHeartMedia = 'iHeartMedia';

    case citrix = 'Citrix';

    case vaporware = 'VaporWare';

    case netscape = 'Netscape';

    case oregan = 'Oregan';

    case aol = 'AOL';

    case ant = 'Ant';

    case tor = 'Tor';

    case cameronKaiser = 'Cameron Kaiser';

    case orangeLabs = 'Orange Labs';

    case bird = 'Bird';

    case mikulasPatocka = 'Mikulas Patocka';

    case myriad = 'Myriad';

    case kddi = 'KDDI';

    case freeSoftwareFoundation = 'Free Software Foundation';

    case sandLabs = 'Sand Labs';

    case davidRosca = 'David Rosca';

    case linkfluence = 'Linkfluence';

    case dorado = 'Dorado';

    case redbot = 'redbot.org';

    case scaDigital = 'SCA Digital';

    case mediahuis = 'Mediahuis';

    case multimediosDigital = 'Multimedios Digital';

    case entertainmentNetwork = 'Entertainment Network';

    case swisscom = 'Swisscom';

    case sonyNetwork = 'Sony Network';

    case fancyMobileApps = 'Fancy Mobile Apps';

    case browserWorks = 'BrowserWorks';

    case salamweb = 'Salam Web';

    case paloAltoNetworks = 'Palo Alto Networks';

    case roblox = 'Roblox';

    case bonprix = 'BonPrix';

    case spotify = 'Spotify';

    case yahooJapan = 'Yahoo! Japan';

    case sogou = 'Sogou';

    case haixu = 'Haixu';

    case nasai = 'Nasai';

    case phpGroup = 'PHP Group';

    case bbc = 'BBC';

    case christianDywan = 'Christian Dywan';

    case apache = 'Apache';

    case thomasDickey = 'Thomas Dickey';

    case omniDevelopment = 'Omni Development';

    case phantomJS = 'PhantomJS';

    case markCavage = 'Mark Cavage';

    case wkhtmltopdforg = 'wkhtmltopdf.org';

    case espial = 'Espial';

    case vivaldi = 'Vivaldi';

    case kTouch = 'K-Touch';

    case zopo = 'ZOPO';

    case mastone = 'Mastone';

    case greenOrange = 'Green Orange';

    case nextbook = 'Nextbook';

    case odys = 'Odys';

    case lephone = 'Lephone';

    case maxtron = 'Maxtron';

    case amoi = 'Amoi';

    case voto = 'Voto';

    case provisio = 'Provisio';

    case lunascape = 'Lunascape';

    case crazybrowser = 'CrazyBrowser';

    case avantForce = 'Avant Force';

    case getdownloadWs = 'getdownload.ws';

    case kaylonTechnologies = 'Kaylon Technologies';

    case xavierRoche = 'Xavier Roche';

    case abelssoft = 'Abelssoft';

    case kmeleonbrowserOrg = 'kmeleonbrowser.org';

    case ncsa = 'NCSA';

    case designScience = 'Design Science';

    case deepnetSecurity = 'Deepnet Security';

    case yesLogic = 'YesLogic';

    case fenrir = 'Fenrir';

    case flashpeak = 'FlashPeak';

    case acoobrowser = 'www.acoobrowser.com';

    case morequick = 'morequick';

    case compaq = 'Compaq';

    case osf = 'OSF';

    case sakamotoHironori = 'Sakamoto Hironori';

    case acorn = 'Acorn';

    case perplexity = 'Perplexity';

    case openatomFoundation = 'OpenAtom Foundation';

    case oceanHero = 'OceanHero';

    case eVentures = 'e.ventures';

    case hubspot = 'HubSpot';

    case linspire = 'Linspire';

    case vodafone = 'Vodafone';

    case nexstreaming = 'NexStreaming';

    case qualcomm = 'Qualcomm';

    case comodo = 'Comodo';

    case flock = 'Flock';

    case panasonic = 'Panasonic';

    case logicware = 'LogicWare';

    case pocketbook = 'PocketBook';

    case nuvomondo = 'Nuvomondo';

    case aftvnewsCom = 'AFTVnews.com';

    case cliqz = 'Cliqz';

    case theInternetArchive = 'The Internet Archive';

    case lnmbbs = 'LNMBBS';

    case bose = 'Bose';

    case sonyEricsson = 'SonyEricsson';

    case docomo = 'DoCoMo';

    case nexian = 'Nexian';

    case spice = 'Spice';

    case cosmix = 'Cosmix';

    case overmax = 'Overmax';

    case freelander = 'FreeLander';

    case dogTorance = 'Dogtorance';

    case wafer = 'Wafer';

    case flextech = 'Flextech';

    case fly = 'Fly';

    case tyd = 'TenYiDe';

    case torch = 'Torch';

    case compuware = 'Compuware';

    case indurama = 'Indurama';

    case multynet = 'Multynet';

    case whaleTV = 'Whale TV';

    case konka = 'Konka';

    case easou = 'easou';

    case marketwire = 'Marketwire';

    case richardTrautvetter = 'Richard Trautvetter';

    case beonexBusinessServices = 'Beonex Business Services';

    case deezer = 'Deezer';

    case webin = 'Webin';

    case appSimply = 'AppSimply';

    case bloop = 'Bloop';

    case woxter = 'Woxter';

    case iridiumBrowserTeam = 'Iridium Browser Team';

    case cocCoc = 'Cốc Cốc';

    case adaptiveBee = 'AdaptiveBee';

    case x115com = '115.com';

    case digitalPebble = 'DigitalPebble';

    case basecamp = 'Basecamp';

    case adbeat = 'Adbeat';

    case kinza = 'kinza.jp';

    case postbox = 'Postbox';

    case kkbox = 'KKBOX';

    case nortonLifeLock = 'NortonLifeLock';

    case foundry376 = 'Foundry 376';

    case cryptoPro = 'CRYPTO-PRO';

    case bywayEndeavors = 'Byway Endeavors';

    case sparkMail = 'Spark Mail';

    case pingdom = 'Pingdom';

    case blackPixel = 'Black Pixel';

    case pinterest = 'Pinterest';

    case ekioh = 'Ekioh';

    case mesa = 'Mesa';

    case quickHeal = 'Quick Heal';

    case nvidia = 'Nvidia';

    case bytedance = 'Bytedance';

    case ryte = 'Ryte';

    case toddDitchendorf = 'Todd Ditchendorf';

    case whitehat = 'WhiteHat';

    case ok = 'ok.';

    case dyon = 'Dyon';

    case panavox = 'Panavox';

    case grapeshot = 'Grapeshot';

    case cheBinLiu = 'Che-Bin Liu';

    case sinaWeibo = 'Sina Weibo';

    case hatena = 'Hatena';

    case okta = 'Okta';

    case schoolwires = 'Schoolwires';

    case chatwork = 'ChatWork';

    case flixster = 'Flixster';

    case timeWarnerCable = 'Time Warner Cable';

    case salesforce = 'Salesforce';

    case similarTech = 'SimilarTech';

    case diigo = 'Diigo';

    case ericssonResearch = 'Ericsson Research';

    case soundCloud = 'SoundCloud';

    case dorada = 'Dorada';

    case espn = 'ESPN';

    case videoLan = 'VideoLAN';

    case gihyunJung = 'Gihyun Jung';

    case webExpansion = 'Web Expansion';

    case inboxcube = 'Inboxcube';

    case leysinMedia = 'Leysin Media';

    case tvPlus = 'TV+';

    case regal = 'REGAL';

    case formovie = 'Formovie';

    case singer = 'SINGER';

    case prismPlus = 'PRISM+';

    case infraware = 'Infraware';

    case topTech = 'Top-Tech';

    case aoc = 'AOC';

    case telly = 'Telly';

    case newsblur = 'newsblur';

    case texet = 'TeXet';

    case shopKeep = 'ShopKeep';

    case compass = 'Compass';

    case wonjooJang = 'WONJOO JANG';

    case sanyo = 'Sanyo';

    case sprint = 'Sprint';

    case smartfren = 'Smartfren';

    case lightspeedSystems = 'Lightspeed Systems';

    case unister = 'Unister';

    case deedBaltic = 'DEED Baltic';

    case wooRank = 'WooRank';

    case nineteenTen = 'Nineteen Ten';

    case yisou = 'Yisou';

    case semrush = 'Semrush';

    case browserEdsonThiago = 'Browser Edson Thiago';

    case michelDeBoer = 'Michel de Boer';

    case cultraview = 'Cultraview';

    case system76 = 'System76';

    case playNow = 'Play Now';

    case botech = 'Botech';

    case brandt = 'Brandt';

    case bauhn = 'BAUHN';

    case jvc = 'JVC';

    case beko = 'Beko';

    case altus = 'Altus';

    case profilo = 'PROFiLO';

    case fedirTsapana = 'Fedir Tsapana';

    case arcelik = 'Arcelik';

    case pantech = 'Pantech';

    case elsevier = 'Elsevier';

    case wpoFoundation = 'WPO Foundation';

    case rickCranisky = 'Rick Cranisky';

    case shiftphones = 'Shift Phones';

    case shiira = 'Shiira';

    case newsMe = 'News.me';

    case wireSwiss = 'Wire Swiss';

    case rivalIq = 'Rival IQ';

    case mailbar = 'MailBar';

    case blackboard = 'Blackboard';

    case chimoosoft = 'Chimoosoft';

    case novarra = 'Novarra';

    case sendo = 'Sendo';

    case siemens = 'Siemens';

    case adobe = 'Adobe';

    case rambler = 'rambler';

    case lindenLabs = 'Linden Labs';

    case piriform = 'Piriform';

    case gateway = 'Gateway';

    case kingsoft = 'Kingsoft';

    case builtwith = 'BuiltWith';

    case doubleVerify = 'DoubleVerify';

    case avira = 'Avira';

    case dell = 'Dell';

    case aspiegel = 'Aspiegel';

    case topsyLabs = 'Topsy Labs';

    case daum = 'Daum';

    case ichiro = 'Ichiro';

    case brandwatch = 'brandwatch';

    case mailRu = 'Mail.Ru';

    case tailrank = 'Tailrank';

    case domainTools = 'DomainTools';

    case nikon = 'Nikon';

    case teslaMotors = 'Tesla Motors';

    case ouya = 'Ouya';

    case zetakeySolutions = 'Zetakey Solutions';

    case mapleStudio = 'Maple Studio';

    case msi = 'MSI';

    case benq = 'BenQ';

    case sagem = 'Sagem';

    case utstarcom = 'UTStarcom';

    case vkMobile = 'VK Mobile';

    case lePan = 'Le Pan';

    case velocityMicro = 'Velocity Micro';

    case netcraft = 'Netcraft';

    case sistrix = 'Sistrix';

    case xovi = 'Xovi';

    case majestic12 = 'Majestic-12';

    case zoomInformation = 'Zoom Information';

    case torstenRueckert = 'Torsten Rueckert';

    case commonCrawl = 'CommonCrawl';

    case domainstats = 'Domainstats';

    case nagios = 'Nagios';

    case ahrefs = 'Ahrefs';

    case seobility = 'seobility';

    case babbar = 'BABBAR';

    case censys = 'Censys';

    case seomoz = 'SEOmoz';

    case dataforseo = 'DataForSEO';

    case itteco = 'Itteco';

    case sharashka = 'Sharashka';

    case owler = 'Owler';

    case benKurtovic = 'Ben Kurtovic';

    case semanticVisions = 'Semantic Visions';

    case notionLabs = 'Notion Labs';

    case anthropic = 'Anthropic';

    case kagi = 'Kagi';

    case valimail = 'Valimail';

    case grasGroup = 'GRAS Group';

    case cybaa = 'Cybaa';

    case heexy = 'Heexy';

    case archi301 = 'ARCHI301';

    case emClient = 'eM Client';

    case findFiles = 'FindFiles';

    case projectDiscovery = 'ProjectDiscovery';

    case jaimeIniesta = 'Jaime Iniesta';

    case alexandreTourette = 'Alexandre Tourette';

    case torbenHansen = 'Torben Hansen';

    case sqalix = 'Sqalix';

    case vertexWP = 'VertexWP';

    case postman = 'Postman';

    case recordedFuture = 'Recorded Future';

    case bitsightTechnologies = 'BitSight Technologies';

    case ceramic = 'Ceramic';

    case screamingFrog = 'Screaming Frog';

    case startMe = 'start.me';

    case domainsBot = 'DomainsBot';

    case rwthAachen = 'RWTH Aachen';

    case manfredSchauer = 'Dr. Manfred Schauer';

    case parallelWebSystems = 'Parallel Web Systems';

    case ibou = 'Ibou';

    case mistralAI = 'Mistral AI';

    case incsub = 'Incsub';

    case meinsUndVogel = 'Meins und Vogel';

    case agencyAnalytics = 'AgencyAnalytics';

    case dynalist = 'Dynalist';

    case barzmannInternetSolutions = 'Barzmann Internet Solutions';

    case spazioDati = 'SpazioDati';

    case dataprovider = 'Dataprovider';

    case hessischesStatistischesLandesamt = 'Hessisches Statistisches Landesamt';

    case comscore = 'Comscore';

    case lumeWeaver = 'LumeWeaver';

    case nlpc = 'NLPC';

    case mindup = 'mindUp';

    case exipert = 'Exipert';

    case timpi = 'Timpi';

    case archiveTeam = 'ArchiveTeam';

    case finax = 'Finax';

    case keywordsStandings = 'Keywords Standings';

    case flowTeam = 'Flow Team';

    case companySpotter = 'CompanySpotter';

    case smartisan = 'Smartisan';

    case ghSoftware = 'GH Software';

    case arquivo = 'Arquivo';

    case serpstat = 'Serpstat';

    case morningscore = 'Morningscore';

    case ergo = 'Ergo';

    case github = 'GitHub';

    case prestigio = 'Prestigio';

    case rakutenMobile = 'Rakuten Mobile';

    case eightPecxStudios = '8pecxstudios';

    case danew = 'Danew';

    case zaojianzhen = 'ZaoJianZhen';

    case leeco = 'LeEco';

    case leagoo = 'Leagoo';

    case aopen = 'AOpen';

    case elementSoftware = 'Element Software';

    case pagePeeker = 'PagePeeker';

    case adrienBarbaresi = 'Adrien Barbaresi';

    case w3c = 'W3C';

    case brightInteractive = 'Bright Interactive';

    case elbertAlias = 'Elbert Alias';

    case barnesNoble = 'Barnes & Noble';

    case phoenixStudio = 'Phoenix Studio';

    case awow = 'Awow';

    case yooz = 'yooz';

    case eyeota = 'Eyeota';

    case onlineMediaGroup = 'Online Media Group';

    case xianghe = 'Xianghe';

    case surLy = 'Sur.ly';

    case jckkcfug = 'Jckkcfug';

    case lagenio = 'LAGENIO';

    case vikusha = 'VIKUSHA';

    case webmeup = 'WebMeUp';

    case bdf = 'BDF';

    case totalSecurity = 'Total Security';

    case superbird = 'superbird';

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
            'the-browser-company', 'the browser company', 'the browser company of new york, inc', 'thebrowser' => self::thebrowser,
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
            'matomo' => self::matomo,
            'akamessenger', 'aka-messenger', 'aka messenger' => self::akaMessenger,
            'tunein', 'tunein, inc.', 'tune-in' => self::tuneIn,
            'onecook', 'onecook co., ltd.' => self::onecook,
            'softmetech', 'softme-tech', 'softme tech' => self::softmeTech,
            'intel', 'intel corporation' => self::intel,
            'readly', 'readly international' => self::readly,
            'avast', 'avast software s.r.o.', 'avast-software' => self::avast,
            'appsmedia', 'appsmedia inc', 'apps-media' => self::appsmedia,
            'kaweapps', 'kawe apps', 'kawe-apps' => self::kaweApps,
            'reuters' => self::reuters,
            'playittechnology', 'playit technology pte. ltd.', 'playit-technology', 'playit technology' => self::playitTechnology,
            'xing', 'xing ag' => self::xing,
            'fsecure', 'f-secure corporation', 'f-secure' => self::fSecure,
            'suaat' => self::suaat,
            'gtab', 'g-tab' => self::gTab,
            'polestar' => self::polestar,
            'kinogoge', 'kinogo-ge', 'kinogo.ge' => self::kinogoGe,
            'cookiejarapps', 'cookie-jar-apps' => self::cookieJarApps,
            'larswindolf', 'lars windolf' => self::larsWindolf,
            'videodownloadstudio', 'video-download-studio', 'video download studio' => self::videoDownloadStudio,
            'maxthon', 'maxthon international limited' => self::maxthon,
            'yobimobi', 'yobi-mobi', 'yobi mobi' => self::yobiMobi,
            'myhomescreen', 'my-home-screen', 'my home screen' => self::myHomeScreen,
            'bluewalletservices', 'bluewallet-services', 'bluewallet services', 'bluewallet services s. r. l.' => self::blueWalletServices,
            'anydesksoftware', 'anydesk-software', 'anydesk software gmbh', 'anydesk software' => self::anyDeskSoftware,
            'towolabs', 'towo-labs', 'towo labs' => self::towoLabs,
            'talktalktelecom', 'talk-talk-telecom', 'talktalk telecom group limited', 'talktalk telecom' => self::talkTalkTelecom,
            'kpn' => self::kpn,
            'mopotab', 'mopotab inc' => self::mopotab,
            'quora', 'quora, inc.' => self::quora,
            'morris', 'morris xar' => self::morris,
            'dezor', 'dezor sa' => self::dezor,
            'bestseller', 'bestseller a/s' => self::bestseller,
            'hazuki' => self::hazuki,
            'surfboard', 'surfboard holding bv' => self::surfboard,
            'tenta', 'tenta llc' => self::tenta,
            'mobilev5', 'mobile-v5', 'mobile_v5' => self::mobileV5,
            'swisscows' => self::swisscows,
            'wolvesinteractive', 'wolves-interactive', 'wolves interactive' => self::wolvesInteractive,
            'buhldataservice', 'buhl-data-service', 'buhl data service', 'buhl data service gmbh' => self::buhlDataService,
            'bayspringmedia', 'bay-spring-media', 'bay spring media', 'bay spring media llc' => self::baySpringMedia,
            'twokitconsulting', '2kit-consulting', '2kit consulting' => self::twoKitConsulting,
            'volcanotechnology', 'volcano-technology', 'volcano technology', 'volcano technology limited' => self::volcanoTechnology,
            'omshyapps', 'omshy-apps' => self::omshyApps,
            'reddit', 'reddit inc.' => self::reddit,
            'thinkfree', 'think-free', 'think free' => self::thinkFree,
            'nifty', 'nifty corporation' => self::nifty,
            'wiseplayapps', 'wiseplay-apps', 'wiseplay apps' => self::wiseplayApps,
            'canon', 'canon inc.' => self::canon,
            'intex', 'intex technologies (i) ltd.' => self::intex,
            'orange', 'orange s.a.' => self::orange,
            'accent' => self::accent,
            'ipro', 'shenzhen zhike communication co., ltd' => self::ipro,
            'castify' => self::castify,
            'thenewyorktimes', 'the new york times company', 'new-york-times', 'the new york times' => self::theNewYorkTimes,
            'vishagroup', 'visha-group', 'visha group' => self::vishaGroup,
            'spring', 'spring (sg) pte. ltd.' => self::spring,
            'gnome', 'the gnome project', 'the-gnome-project' => self::gnome,
            'kde', 'kde e.v.' => self::kde,
            'gnu' => self::gnu,
            'asddev', 'asd dev', 'asd-dev' => self::asdDev,
            'dstools', 'ds tools', 'ds-tools' => self::dsTools,
            'npr' => self::npr,
            'appsforgoogle', 'apps for google', 'apps-for-google' => self::appsForGoogle,
            'italiaonline', 'italiaonline s.p.a.' => self::italiaonline,
            'telekom', 'deutsche telekom ag' => self::telekom,
            'armobsoft', 'armobsoft fze' => self::armobsoft,
            'kaldor', 'kaldor ltd.' => self::kaldor,
            'podverse' => self::podverse,
            'mediahuisnrc', 'mediahuis nrc', 'mediahuis-nrc' => self::mediahuisNrc,
            'globalmediaentertainment', 'global media & entertainment', 'global-media-entertainment' => self::globalMediaEntertainment,
            'kajabi' => self::kajabi,
            'iheartmedia', 'iheartmedia management services, inc.', 'iheart-media' => self::iHeartMedia,
            'citrix' => self::citrix,
            'vaporware' => self::vaporware,
            'netscape' => self::netscape,
            'oregan', 'oregan networks ltd' => self::oregan,
            'aol', 'america online, inc.' => self::aol,
            'ant', 'ant software limited' => self::ant,
            'tor', 'the tor project' => self::tor,
            'cameronkaiser', 'cameron-kaiser', 'cameron kaiser' => self::cameronKaiser,
            'orangelabs', 'orange labs uk', 'orange-labs', 'orange labs' => self::orangeLabs,
            'bird' => self::bird,
            'mikulaspatocka', 'mikulas-patocka', 'mikulas patocka' => self::mikulasPatocka,
            'myriad', 'myriad group' => self::myriad,
            'kddi', 'kddi corporation' => self::kddi,
            'freesoftwarefoundation', 'free software foundation, inc.', 'free-software-foundation', 'free software foundation' => self::freeSoftwareFoundation,
            'sandlabs', 'sand-labs', 'sand labs' => self::sandLabs,
            'davidrosca', 'david rosca and community', 'david-rosca', 'david rosca' => self::davidRosca,
            'linkfluence', 'linkfluence sas' => self::linkfluence,
            'dorado' => self::dorado,
            'redbot', 'redbot.org' => self::redbot,
            'scadigital', 'sca digital pty ltd', 'sca-igital', 'sca digital' => self::scaDigital,
            'mediahuis' => self::mediahuis,
            'multimediosdigital', 'multimedios-digital', 'multimedios digital' => self::multimediosDigital,
            'entertainmentnetwork', 'entertainment-network', 'entertainment network (india) ltd.', 'entertainment network' => self::entertainmentNetwork,
            'swisscom', 'swisscom ltd' => self::swisscom,
            'sonynetwork', 'sony-network', 'sony network communications inc.', 'sony network' => self::sonyNetwork,
            'fancymobileapps', 'fancy-mobile-apps', 'fancy mobile apps' => self::fancyMobileApps,
            'browserworks', 'browser-works' => self::browserWorks,
            'salamweb', 'salam web', 'salam web technologies dmcc' => self::salamweb,
            'paloaltonetworks', 'palo-alto', 'palo alto networks, inc.', 'palo alto networks' => self::paloAltoNetworks,
            'roblox', 'roblox corporation' => self::roblox,
            'bonprix', 'bonprix handelsgesellschaft mbh' => self::bonprix,
            'spotify', 'spotify ab' => self::spotify,
            'yahoojapan', 'yahoo-japan', 'yahoo! japan', 'yahoo! japan corp.' => self::yahooJapan,
            'sogou', 'sogou inc' => self::sogou,
            'haixu' => self::haixu,
            'nasai' => self::nasai,
            'phpgroup', 'the php group', 'php-group', 'php group' => self::phpGroup,
            'bbc' => self::bbc,
            'christiandywan', 'christian-dywan', 'christian dywan' => self::christianDywan,
            'apache', 'the apache software foundation' => self::apache,
            'thomasdickey', 'thomas-dickey', 'thomas dickey' => self::thomasDickey,
            'omnidevelopment', 'omni-development', 'omni development inc', 'omni development' => self::omniDevelopment,
            'phantomjs', 'phantom-js', 'phantomjs.org' => self::phantomJS,
            'markcavage', 'mark-cavage', 'mark cavage' => self::markCavage,
            'wkhtmltopdforg', 'wk-html-to-pdf.org', 'wkhtmltopdf.org' => self::wkhtmltopdforg,
            'espial', 'espial-group', 'espial group' => self::espial,
            'vivaldi', 'vivaldi technologies' => self::vivaldi,
            'ktouch', 'k-touch' => self::kTouch,
            'zopo' => self::zopo,
            'mastone' => self::mastone,
            'greenorange', 'green-orange', 'green orange' => self::greenOrange,
            'nextbook' => self::nextbook,
            'odys' => self::odys,
            'lephone' => self::lephone,
            'maxtron' => self::maxtron,
            'amoi' => self::amoi,
            'voto', 'voto mobile' => self::voto,
            'provisio', 'provisio gmbh / llc' => self::provisio,
            'lunascape', 'lunascape corporation' => self::lunascape,
            'crazybrowser', 'crazybrowser.com', 'crazy-browser' => self::crazybrowser,
            'avantforce', 'avant force', 'avant-force' => self::avantForce,
            'getdownloadws', 'getdownload.ws', 'get-download' => self::getdownloadWs,
            'kaylontechnologies', 'kaylon technologies', 'kaylon-technologies' => self::kaylonTechnologies,
            'xavierroche', 'xavier roche', 'xavier-roche' => self::xavierRoche,
            'abelssoft', 'ascora gmbh' => self::abelssoft,
            'kmeleonbrowserorg', 'kmeleonbrowser.org', 'kmeleon-browser.org' => self::kmeleonbrowserOrg,
            'ncsa', 'national center for supercomputing applications' => self::ncsa,
            'designscience', 'design science, inc.', 'design-science', 'design science' => self::designScience,
            'deepnetsecurity', 'deepnet-security', 'deepnet security' => self::deepnetSecurity,
            'yeslogic', 'yes-logic', 'yeslogic pty. ltd.' => self::yesLogic,
            'fenrir', 'fenrir inc' => self::fenrir,
            'flashpeak', 'flashpeak inc.' => self::flashpeak,
            'acoobrowser', 'www.acoobrowser.com' => self::acoobrowser,
            'morequick' => self::morequick,
            'compaq', 'compaq computer corporation' => self::compaq,
            'osf', 'open software foundation' => self::osf,
            'sakamotohironori', 'sakamoto-hironori', 'sakamoto hironori' => self::sakamotoHironori,
            'acorn' => self::acorn,
            'perplexity', 'perplexity ai, inc.' => self::perplexity,
            'openatomfoundation', 'openatom foundation', 'openatom-foundation' => self::openatomFoundation,
            'oceanhero', 'oceanhero gmbh', 'ocean-hero' => self::oceanHero,
            'eventures', 'e.ventures managementgesellschaft mbh', 'e.ventures' => self::eVentures,
            'hubspot', 'hubspot, inc.', 'hubspot-inc' => self::hubspot,
            'linspire', 'linspire, inc.', 'linspire-inc' => self::linspire,
            'vodafone' => self::vodafone,
            'nexstreaming', 'nexstreaming europe s.l.' => self::nexstreaming,
            'qualcomm', 'qualcomm incorporated.' => self::qualcomm,
            'comodo', 'comodo group inc' => self::comodo,
            'flock', 'flock fz-llc' => self::flock,
            'panasonic' => self::panasonic,
            'logicware', 'logicware & lsoft technologies' => self::logicware,
            'pocketbook' => self::pocketbook,
            'nuvomondo', 'nuvomondo ltd' => self::nuvomondo,
            'aftvnewscom', 'aftvnews.com' => self::aftvnewsCom,
            'cliqz', 'cliqz gmbh' => self::cliqz,
            'theinternetarchive', 'archive.org', 'the internet archive' => self::theInternetArchive,
            'lnmbbs' => self::lnmbbs,
            'bose' => self::bose,
            'sonyericsson', 'sony-ericsson' => self::sonyEricsson,
            'docomo', 'ntt-docomo', 'ntt docomo' => self::docomo,
            'nexian' => self::nexian,
            'spice' => self::spice,
            'cosmix', 'cosmix corporation' => self::cosmix,
            'overmax' => self::overmax,
            'freelander' => self::freelander,
            'dogtorance', 'dog-torance' => self::dogTorance,
            'wafer', 'wafer co.' => self::wafer,
            'flextech', 'flextech inc.' => self::flextech,
            'fly' => self::fly,
            'tyd', 'tenyide' => self::tyd,
            'torch', 'torch mobile' => self::torch,
            'compuware', 'compuware corporation', 'compuware-apm' => self::compuware,
            'indurama' => self::indurama,
            'multynet' => self::multynet,
            'whaletv', 'whale-tv', 'whale tv pte. ltd.', 'whale tv' => self::whaleTV,
            'konka' => self::konka,
            'easou', 'easou icp' => self::easou,
            'marketwire', 'marketwire l.p.' => self::marketwire,
            'richardtrautvetter', 'richard-trautvetter', 'richard trautvetter' => self::richardTrautvetter,
            'beonexbusinessservices', 'beonex-business-services', 'beonex business services' => self::beonexBusinessServices,
            'deezer' => self::deezer,
            'webin' => self::webin,
            'appsimply', 'app-simply', 'appsimply, llc' => self::appSimply,
            'bloop', 'bloop s.r.l.' => self::bloop,
            'woxter' => self::woxter,
            'iridiumbrowserteam', 'iridium-browser-team', 'iridium browser team' => self::iridiumBrowserTeam,
            'coccoc', 'coc-coc-company', 'cốc cốc company limited', 'cốc cốc' => self::cocCoc,
            'adaptivebee', 'adaptive-bee', 'adaptivebee sasu' => self::adaptiveBee,
            'x115com', '115-com', '115.com' => self::x115com,
            'digitalpebble', 'digital-pebble', 'digitalpebble ltd' => self::digitalPebble,
            'basecamp' => self::basecamp,
            'adbeat', 'adbeat.com' => self::adbeat,
            'kinza', 'kinza.jp' => self::kinza,
            'postbox', 'postbox, inc.' => self::postbox,
            'kkbox', 'kkbox taiwan co., ltd.' => self::kkbox,
            'nortonlifelock', 'nortonlifelock inc.', 'norton-life-lock' => self::nortonLifeLock,
            'foundry376', 'foundry 376, llc.', 'foundry-376', 'foundry 376' => self::foundry376,
            'cryptopro', 'crypto-pro llc', 'crypto-pro' => self::cryptoPro,
            'bywayendeavors', 'byway-endeavors', 'byway endeavors' => self::bywayEndeavors,
            'sparkmail', 'spark-mail', 'spark mail limited', 'spark mail' => self::sparkMail,
            'pingdom', 'pingdom ab' => self::pingdom,
            'blackpixel', 'black-pixel', 'black pixel' => self::blackPixel,
            'pinterest', 'pinterest inc.' => self::pinterest,
            'ekioh', 'ekioh ltd.' => self::ekioh,
            'mesa', 'mesa dynamics, llc' => self::mesa,
            'quickheal', 'quick-heal', 'quick heal technologies ltd.', 'quick heal' => self::quickHeal,
            'nvidia', 'nvidia corporation' => self::nvidia,
            'bytedance', 'beijing bytedance technology ltd.' => self::bytedance,
            'ryte', 'ryte gmbh' => self::ryte,
            'toddditchendorf', 'todd-ditchendorf', 'todd ditchendorf' => self::toddDitchendorf,
            'whitehat', 'whitehat security' => self::whitehat,
            'ok', 'ok.' => self::ok,
            'dyon' => self::dyon,
            'panavox' => self::panavox,
            'grapeshot', 'grapeshot limited' => self::grapeshot,
            'chebinliu', 'che-bin-liu', 'che-bin liu' => self::cheBinLiu,
            'sinaweibo', 'sina-weibo', 'sina corporation', 'sina weibo' => self::sinaWeibo,
            'hatena', 'hatena co., ltd.' => self::hatena,
            'okta', 'okta, inc.' => self::okta,
            'schoolwires', 'schoolwires, inc.' => self::schoolwires,
            'chatwork', 'chat-work' => self::chatwork,
            'flixster', 'flixster, inc.' => self::flixster,
            'timewarnercable', 'time-warner-cable', 'time warner cable' => self::timeWarnerCable,
            'salesforce', 'salesforce.com, inc.' => self::salesforce,
            'similartech', 'similar-tech', 'similartech ltd.' => self::similarTech,
            'diigo', 'diigo, inc.' => self::diigo,
            'ericssonresearch', 'ericsson-research', 'ericsson research' => self::ericssonResearch,
            'soundcloud', 'sound-cloud', 'soundcloud limited' => self::soundCloud,
            'dorada', 'dorada app software ltd' => self::dorada,
            'espn', 'espn internet ventures.' => self::espn,
            'videolan', 'video-lan', 'videolan non-profit organization' => self::videoLan,
            'gihyunjung', 'gihyun-jung', 'gihyun jung' => self::gihyunJung,
            'webexpansion', 'web-expansion', 'web expansion cyprus ltd.', 'web expansion' => self::webExpansion,
            'inboxcube', 'inboxcube inc.' => self::inboxcube,
            'leysinmedia', 'leysin-media', 'shanghai leysin media co, ltd.', 'leysin media' => self::leysinMedia,
            'tvplus', 'tv+' => self::tvPlus,
            'regal' => self::regal,
            'formovie' => self::formovie,
            'singer' => self::singer,
            'prismplus', 'prism+' => self::prismPlus,
            'infraware', 'infraware inc' => self::infraware,
            'toptech', 'top-tech' => self::topTech,
            'aoc' => self::aoc,
            'telly', 'telly, inc.' => self::telly,
            'newsblur' => self::newsblur,
            'texet' => self::texet,
            'shopkeep', 'shop-keep', 'shopkeep inc.' => self::shopKeep,
            'compass', 'compass security ag' => self::compass,
            'wonjoojang', 'wonjoo-jang', 'wonjoo jang' => self::wonjooJang,
            'sanyo' => self::sanyo,
            'sprint' => self::sprint,
            'smartfren', 'pt smartfren telecom, tbk' => self::smartfren,
            'lightspeedsystems', 'lightspeed-systems', 'lightspeed systems' => self::lightspeedSystems,
            'unister', 'unister holding gmbh' => self::unister,
            'deedbaltic', 'deed baltic, uab', 'deed-baltic', 'deed baltic' => self::deedBaltic,
            'woorank', 'woo-rank' => self::wooRank,
            'nineteenten', 'nineteen-ten', 'nineteen ten llc', 'nineteen ten' => self::nineteenTen,
            'yisou' => self::yisou,
            'semrush', 'semrush inc.' => self::semrush,
            'browseredsonthiago', 'browser-edson-thiago', 'browser edson thiago' => self::browserEdsonThiago,
            'micheldeboer', 'michel-de-boer', 'michel de boer' => self::michelDeBoer,
            'cultraview' => self::cultraview,
            'system76' => self::system76,
            'playnow', 'play now', 'play-now' => self::playNow,
            'botech' => self::botech,
            'brandt' => self::brandt,
            'bauhn' => self::bauhn,
            'jvc' => self::jvc,
            'beko' => self::beko,
            'altus' => self::altus,
            'profilo' => self::profilo,
            'fedirtsapana', 'fedir-tsapana', 'fedir tsapana' => self::fedirTsapana,
            'arcelik', 'arcelik a.s.' => self::arcelik,
            'pantech' => self::pantech,
            'elsevier', 'elsevier ltd' => self::elsevier,
            'wpofoundation', 'wpo foundation', 'wpo-foundation' => self::wpoFoundation,
            'rickcranisky', 'rick cranisky', 'rick-cranisky' => self::rickCranisky,
            'shiftphones', 'shift-phones', 'shift gmbh', 'shift phones' => self::shiftphones,
            'shiira' => self::shiira,
            'newsme', 'news.me', 'news.me inc' => self::newsMe,
            'wireswiss', 'wire-swiss', 'wire swiss gmbh', 'wire swiss' => self::wireSwiss,
            'rivaliq', 'rival-iq', 'rival iq corporation', 'rival iq' => self::rivalIq,
            'mailbar', 'mailbar inc.' => self::mailbar,
            'blackboard', 'blackboard inc.' => self::blackboard,
            'chimoosoft' => self::chimoosoft,
            'novarra', 'novarra inc.' => self::novarra,
            'sendo' => self::sendo,
            'siemens' => self::siemens,
            'adobe', 'adobe systems incorporated' => self::adobe,
            'rambler' => self::rambler,
            'lindenlabs', 'linden-labs', 'linden labs' => self::lindenLabs,
            'piriform', 'piriform software ltd' => self::piriform,
            'gateway', 'gateway, inc.' => self::gateway,
            'kingsoft' => self::kingsoft,
            'builtwith', 'builtwith pty ltd' => self::builtwith,
            'doubleverify', 'doubleverify inc.', 'double-verify' => self::doubleVerify,
            'avira', 'avira operations gmbh & co. kg.', 'avira-operations' => self::avira,
            'dell' => self::dell,
            'aspiegel', 'aspiegel plc' => self::aspiegel,
            'topsylabs', 'topsy-labs', 'topsy labs' => self::topsyLabs,
            'daum', 'daum-corporation', 'daum communications corp' => self::daum,
            'ichiro' => self::ichiro,
            'brandwatch' => self::brandwatch,
            'mailru', 'mail.ru', 'mail.ru group' => self::mailRu,
            'tailrank', 'tailrank inc' => self::tailrank,
            'domaintools', 'domain-tools' => self::domainTools,
            'nikon', 'kabushiki-gaisha nikon' => self::nikon,
            'teslamotors', 'tesla-motors', 'tesla motors' => self::teslaMotors,
            'ouya', 'ouya, inc.' => self::ouya,
            'zetakeysolutions', 'zetakey-solutions', 'zetakey solutions limited', 'zetakey solutions' => self::zetakeySolutions,
            'maplestudio', 'maple-studio', 'maple studio' => self::mapleStudio,
            'msi' => self::msi,
            'benq' => self::benq,
            'sagem' => self::sagem,
            'utstarcom' => self::utstarcom,
            'vkmobile', 'vk-mobile', 'vk mobile' => self::vkMobile,
            'lepan', 'le-pan', 'le pan' => self::lePan,
            'velocitymicro', 'velocity-micro', 'velocity micro' => self::velocityMicro,
            'netcraft', 'netcraft ltd.' => self::netcraft,
            'sistrix', 'sistrix gmbh' => self::sistrix,
            'xovi', 'xovi gmbh' => self::xovi,
            'majestic12', 'majestic-12', 'majestic-12 ltd' => self::majestic12,
            'zoominformation', 'zoom-information', 'zoom information inc.', 'zoom information' => self::zoomInformation,
            'torstenrueckert', 'torsten-rueckert', 'torsten rueckert internetdienstleistungen', 'torsten rueckert' => self::torstenRueckert,
            'commoncrawl', 'common-crawl-foundation', 'commoncrawl foundation' => self::commonCrawl,
            'domainstats', 'domainstats international ab' => self::domainstats,
            'nagios', 'nagios enterprises, llc.', 'nagios-enterprises' => self::nagios,
            'ahrefs', 'ahrefs pte ltd' => self::ahrefs,
            'seobility', 'seobility gmbh' => self::seobility,
            'babbar' => self::babbar,
            'censys', 'censys, inc.' => self::censys,
            'seomoz', 'seomoz, inc.' => self::seomoz,
            'dataforseo', 'dataforseo ou' => self::dataforseo,
            'itteco' => self::itteco,
            'sharashka', 'sharashka, inc.' => self::sharashka,
            'owler', 'owler, inc.' => self::owler,
            'benkurtovic', 'ben-kurtovic', 'ben kurtovic' => self::benKurtovic,
            'semanticvisions', 'semantic-visions', 'semantic visions, s.r.o.', 'semantic visions' => self::semanticVisions,
            'notionlabs', 'notion-labs', 'notion labs, inc.', 'notion labs' => self::notionLabs,
            'anthropic', 'anthropic pbc' => self::anthropic,
            'kagi', 'kagi inc.' => self::kagi,
            'valimail', 'valimail inc.' => self::valimail,
            'grasgroup', 'gras group, inc.', 'gras-group', 'gras group' => self::grasGroup,
            'cybaa', 'cybaa ltd' => self::cybaa,
            'heexy' => self::heexy,
            'archi301' => self::archi301,
            'emclient', 'em client s.r.o.', 'em-client', 'em client' => self::emClient,
            'findfiles', 'findfiles.net ug', 'findfiles.net', 'find-files' => self::findFiles,
            'projectdiscovery', 'projectdiscovery, inc.', 'project-discovery' => self::projectDiscovery,
            'jaimeiniesta', 'jaime-iniesta', 'jaime iniesta' => self::jaimeIniesta,
            'alexandretourette', 'alexandre-tourette', 'alexandre tourette' => self::alexandreTourette,
            'torbenhansen', 'torben-hansen', 'torben hansen' => self::torbenHansen,
            'sqalix' => self::sqalix,
            'vertexwp', 'vertex-wp' => self::vertexWP,
            'postman', 'postman, inc.' => self::postman,
            'recordedfuture', 'recorded future, inc.', 'recorded-future', 'recorded future' => self::recordedFuture,
            'bitsighttechnologies', 'bitsight technologies, inc.', 'bitsight-technologies', 'bitsight technologies' => self::bitsightTechnologies,
            'ceramic', 'ceramic, inc.' => self::ceramic,
            'screamingfrog', 'screaming-frog', 'screaming frog ltd', 'screaming frog' => self::screamingFrog,
            'startme', 'start.me', 'start.me bv' => self::startMe,
            'domainsbot', 'domains-bot', 'domainsbot srl' => self::domainsBot,
            'rwthaachen', 'rwth-aachen', 'rwth aachen university', 'rwth aachen' => self::rwthAachen,
            'manfredschauer', 'manfred-schauer', 'dr. manfred schauer' => self::manfredSchauer,
            'parallelwebsystems', 'parallel web systems inc.', 'parallel-web-systems', 'parallel web systems' => self::parallelWebSystems,
            'ibou' => self::ibou,
            'mistralai', 'mistral-ai', 'mistral ai' => self::mistralAI,
            'incsub', 'incsub, llc.' => self::incsub,
            'meinsundvogel', 'meins und vogel gmbh', 'meins-und-vogel', 'meins und vogel' => self::meinsUndVogel,
            'agencyanalytics', 'agencyanalytics inc', 'agency-analytics' => self::agencyAnalytics,
            'dynalist', 'dynalist inc.' => self::dynalist,
            'barzmanninternetsolutions', 'barzmann-internet-solutions', 'barzmann internet solutions gmbh', 'barzmann internet solutions' => self::barzmannInternetSolutions,
            'spaziodati', 'spazio-dati', 'spaziodati s.r.l.' => self::spazioDati,
            'dataprovider', 'dataprovider b.v.' => self::dataprovider,
            'hessischesstatistischeslandesamt', 'hessisches statistisches landesamt', 'hessisches-statistisches-landesamt' => self::hessischesStatistischesLandesamt,
            'comscore', 'comscore, inc.' => self::comscore,
            'lumeweaver', 'lumeweaver labs', 'lume-weaver' => self::lumeWeaver,
            'nlpc', 'natural language processing centre' => self::nlpc,
            'mindup', 'mindup web + intelligence gmbh' => self::mindup,
            'exipert', 'exipert, inc. dba checkmark network' => self::exipert,
            'timpi', 'timpi inc.' => self::timpi,
            'archiveteam', 'archive-team' => self::archiveTeam,
            'finax', 'finax, o.c.p, a.s.' => self::finax,
            'keywordsstandings', 'keywords-standings', 'keywords standings ltd.', 'keywords standings' => self::keywordsStandings,
            'flowteam', 'flow-team', 'flow team' => self::flowTeam,
            'companyspotter', 'company-spotter', 'companyspotter bv' => self::companySpotter,
            'smartisan', 'smartisan technology co., ltd' => self::smartisan,
            'ghsoftware', 'gh-software', 'gh software' => self::ghSoftware,
            'arquivo', 'arquivo.pt' => self::arquivo,
            'serpstat', 'serpstat global ltd' => self::serpstat,
            'morningscore', 'morning-score' => self::morningscore,
            'ergo' => self::ergo,
            'github', 'github inc.' => self::github,
            'prestigio' => self::prestigio,
            'rakutenmobile', 'rakuten mobile', 'rakuten-mobile' => self::rakutenMobile,
            'eightpecxstudios', '8pecxstudios' => self::eightPecxStudios,
            'danew' => self::danew,
            'zaojianzhen' => self::zaojianzhen,
            'leeco', 'leshi internet information & technology' => self::leeco,
            'leagoo', 'leagoo international co., limited' => self::leagoo,
            'aopen' => self::aopen,
            'elementsoftware', 'element-software', 'element software' => self::elementSoftware,
            'pagepeeker', 'page-peeker', 'pagepeeker srl' => self::pagePeeker,
            'adrienbarbaresi', 'adrien-barbaresi', 'adrien barbaresi' => self::adrienBarbaresi,
            'w3c' => self::w3c,
            'brightinteractive', 'bright interactive ltd', 'bright interactive', 'bright-interactive' => self::brightInteractive,
            'elbertalias', 'elbert alias', 'elbert-alias' => self::elbertAlias,
            'barnesnoble', 'barnes & noble', 'barnes-noble' => self::barnesNoble,
            'phoenixstudio', 'phoenix studio', 'phoenix-studio' => self::phoenixStudio,
            'awow' => self::awow,
            'yooz' => self::yooz,
            'eyeota', 'eyeota pte ltd' => self::eyeota,
            'onlinemediagroup', 'online-media-group', 'online media group, inc.', 'online media group' => self::onlineMediaGroup,
            'xianghe', 'xianghe technology co., ltd.' => self::xianghe,
            'surly', 'sur.ly llc', 'sur.ly' => self::surLy,
            'jckkcfug' => self::jckkcfug,
            'lagenio' => self::lagenio,
            'vikusha' => self::vikusha,
            'webmeup' => self::webmeup,
            'bdf' => self::bdf,
            'totalsecurity', 'total-security', 'total security ltd.', 'total security' => self::totalSecurity,
            'superbird' => self::superbird,
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
            self::thebrowser => 'The Browser Company of New York, Inc',
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
            self::tuneIn => 'TuneIn, Inc.',
            self::onecook => 'Onecook Co., Ltd.',
            self::intel => 'Intel Corporation',
            self::readly => 'Readly International',
            self::avast => 'AVAST Software s.r.o.',
            self::appsmedia => 'AppsMedia Inc',
            self::playitTechnology => 'PLAYIT TECHNOLOGY PTE. LTD.',
            self::xing => 'XING AG',
            self::fSecure => 'F-Secure Corporation',
            self::maxthon => 'Maxthon International Limited',
            self::blueWalletServices => 'BlueWallet Services S. R. L.',
            self::anyDeskSoftware => 'AnyDesk Software GmbH',
            self::talkTalkTelecom => 'TalkTalk Telecom Group Limited',
            self::mopotab => 'MopoTab Inc',
            self::quora => 'Quora, Inc.',
            self::morris => 'Morris Xar',
            self::dezor => 'Dezor SA',
            self::bestseller => 'Bestseller A/S',
            self::tenta => 'Tenta LLC',
            self::buhlDataService => 'Buhl Data Service GmbH',
            self::baySpringMedia => 'Bay Spring Media LLC',
            self::volcanoTechnology => 'Volcano Technology Limited',
            self::reddit => 'reddit inc.',
            self::nifty => 'NIFTY Corporation',
            self::canon => 'Canon Inc.',
            self::intex => 'Intex Technologies (I) Ltd.',
            self::orange => 'Orange S.A.',
            self::ipro => 'Shenzhen Zhike Communication Co., Ltd',
            self::theNewYorkTimes => 'The New York Times Company',
            self::spring => 'Spring (SG) PTE. LTD.',
            self::gnome => 'The GNOME Project',
            self::kde => 'KDE e.V.',
            self::italiaonline => 'Italiaonline S.p.A.',
            self::telekom => 'Deutsche Telekom AG',
            self::armobsoft => 'Armobsoft FZE',
            self::kaldor => 'Kaldor Ltd.',
            self::iHeartMedia => 'iHeartMedia Management Services, Inc.',
            self::oregan => 'Oregan Networks Ltd',
            self::aol => 'America Online, Inc.',
            self::ant => 'ANT Software Limited',
            self::tor => 'The Tor Project',
            self::orangeLabs => 'Orange Labs UK',
            self::myriad => 'Myriad Group',
            self::kddi => 'KDDI Corporation',
            self::freeSoftwareFoundation => 'Free Software Foundation, Inc.',
            self::davidRosca => 'David Rosca and Community',
            self::linkfluence => 'Linkfluence SAS',
            self::scaDigital => 'SCA Digital Pty Ltd',
            self::entertainmentNetwork => 'Entertainment Network (India) Ltd.',
            self::swisscom => 'Swisscom Ltd',
            self::sonyNetwork => 'Sony Network Communications Inc.',
            self::salamweb => 'Salam Web Technologies DMCC',
            self::paloAltoNetworks => 'Palo Alto Networks, Inc.',
            self::roblox => 'Roblox Corporation',
            self::bonprix => 'bonprix Handelsgesellschaft mbH',
            self::spotify => 'Spotify AB',
            self::sogou => 'Sogou Inc',
            self::phpGroup => 'the PHP Group',
            self::apache => 'The Apache Software Foundation',
            self::omniDevelopment => 'Omni Development Inc',
            self::phantomJS => 'phantomjs.org',
            self::espial => 'Espial Group',
            self::vivaldi => 'Vivaldi Technologies',
            self::voto => 'Voto Mobile',
            self::provisio => 'PROVISIO GmbH / LLC',
            self::lunascape => 'Lunascape Corporation',
            self::crazybrowser => 'CrazyBrowser.com',
            self::abelssoft => 'Ascora GmbH',
            self::ncsa => 'National Center for Supercomputing Applications',
            self::designScience => 'Design Science, Inc.',
            self::yesLogic => 'YesLogic Pty. Ltd.',
            self::fenrir => 'Fenrir Inc',
            self::flashpeak => 'FlashPeak Inc.',
            self::compaq => 'Compaq Computer Corporation',
            self::osf => 'Open Software Foundation',
            self::perplexity => 'Perplexity AI, Inc.',
            self::oceanHero => 'OceanHero GmbH',
            self::eVentures => 'e.ventures Managementgesellschaft mbH',
            self::hubspot => 'HubSpot, Inc.',
            self::linspire => 'Linspire, Inc.',
            self::nexstreaming => 'NexStreaming Europe S.L.',
            self::qualcomm => 'Qualcomm Incorporated.',
            self::comodo => 'Comodo Group Inc',
            self::flock => 'Flock FZ-LLC',
            self::logicware => 'LogicWare & LSoft Technologies',
            self::nuvomondo => 'Nuvomondo Ltd',
            self::cliqz => 'Cliqz GmbH',
            self::docomo => 'NTT DoCoMo',
            self::cosmix => 'Cosmix Corporation',
            self::wafer => 'Wafer Co.',
            self::flextech => 'Flextech Inc.',
            self::torch => 'Torch Mobile',
            self::compuware => 'Compuware Corporation',
            self::whaleTV => 'Whale TV PTE. LTD.',
            self::easou => 'easou ICP',
            self::marketwire => 'Marketwire L.P.',
            self::appSimply => 'AppSimply, LLC',
            self::bloop => 'Bloop S.R.L.',
            self::cocCoc => 'Cốc Cốc Company Limited',
            self::adaptiveBee => 'AdaptiveBee SASU',
            self::digitalPebble => 'DigitalPebble Ltd',
            self::adbeat => 'adbeat.com',
            self::postbox => 'Postbox, Inc.',
            self::kkbox => 'KKBOX Taiwan Co., Ltd.',
            self::nortonLifeLock => 'NortonLifeLock Inc.',
            self::foundry376 => 'Foundry 376, LLC.',
            self::cryptoPro => 'CRYPTO-PRO LLC',
            self::sparkMail => 'Spark Mail Limited',
            self::pingdom => 'Pingdom AB',
            self::pinterest => 'Pinterest Inc.',
            self::ekioh => 'Ekioh Ltd.',
            self::mesa => 'Mesa Dynamics, LLC',
            self::quickHeal => 'Quick Heal Technologies Ltd.',
            self::nvidia => 'Nvidia Corporation',
            self::bytedance => 'Beijing Bytedance Technology Ltd.',
            self::ryte => 'Ryte GmbH',
            self::whitehat => 'WhiteHat Security',
            self::grapeshot => 'Grapeshot Limited',
            self::sinaWeibo => 'Sina Corporation',
            self::hatena => 'Hatena Co., Ltd.',
            self::okta => 'Okta, Inc.',
            self::schoolwires => 'Schoolwires, Inc.',
            self::flixster => 'Flixster, Inc.',
            self::salesforce => 'Salesforce.com, Inc.',
            self::similarTech => 'SimilarTech Ltd.',
            self::diigo => 'Diigo, Inc.',
            self::soundCloud => 'SoundCloud Limited',
            self::dorada => 'Dorada App Software Ltd',
            self::espn => 'ESPN Internet Ventures.',
            self::videoLan => 'VideoLAN non-profit organization',
            self::webExpansion => 'Web Expansion Cyprus Ltd.',
            self::inboxcube => 'Inboxcube Inc.',
            self::leysinMedia => 'Shanghai Leysin Media Co, Ltd.',
            self::infraware => 'Infraware Inc',
            self::telly => 'Telly, Inc.',
            self::shopKeep => 'ShopKeep Inc.',
            self::compass => 'Compass Security AG',
            self::smartfren => 'PT Smartfren Telecom, Tbk',
            self::unister => 'Unister Holding GmbH',
            self::deedBaltic => 'DEED Baltic, UAB',
            self::nineteenTen => 'Nineteen Ten LLC',
            self::semrush => 'Semrush Inc.',
            self::arcelik => 'Arcelik A.S.',
            self::elsevier => 'Elsevier Ltd',
            self::shiftphones => 'SHIFT GmbH',
            self::newsMe => 'News.me Inc',
            self::wireSwiss => 'Wire Swiss GmbH',
            self::rivalIq => 'Rival IQ Corporation',
            self::mailbar => 'MailBar Inc.',
            self::blackboard => 'Blackboard Inc.',
            self::novarra => 'Novarra Inc.',
            self::adobe => 'Adobe Systems Incorporated',
            self::piriform => 'Piriform Software Ltd',
            self::gateway => 'Gateway, Inc.',
            self::builtwith => 'BuiltWith Pty Ltd',
            self::doubleVerify => 'DoubleVerify Inc.',
            self::avira => 'Avira Operations GmbH & Co. KG.',
            self::aspiegel => 'Aspiegel PLC',
            self::daum => 'Daum Communications Corp',
            self::mailRu => 'Mail.Ru Group',
            self::tailrank => 'Tailrank Inc',
            self::nikon => 'Kabushiki-gaisha Nikon',
            self::teslaMotors => 'Tesla Motors',
            self::ouya => 'OUYA, Inc.',
            self::zetakeySolutions => 'Zetakey Solutions Limited',
            self::netcraft => 'Netcraft Ltd.',
            self::sistrix => 'SISTRIX GmbH',
            self::xovi => 'Xovi GmbH',
            self::majestic12 => 'Majestic-12 Ltd',
            self::zoomInformation => 'Zoom Information Inc.',
            self::torstenRueckert => 'Torsten Rueckert Internetdienstleistungen',
            self::commonCrawl => 'CommonCrawl Foundation',
            self::domainstats => 'Domainstats International AB',
            self::nagios => 'Nagios Enterprises, LLC.',
            self::ahrefs => 'Ahrefs Pte Ltd',
            self::seobility => 'seobility GmbH',
            self::censys => 'Censys, Inc.',
            self::seomoz => 'SEOmoz, Inc.',
            self::dataforseo => 'DataForSEO OU',
            self::sharashka => 'Sharashka, Inc.',
            self::owler => 'Owler, Inc.',
            self::semanticVisions => 'Semantic Visions, s.r.o.',
            self::notionLabs => 'Notion Labs, Inc.',
            self::anthropic => 'Anthropic PBC',
            self::kagi => 'Kagi Inc.',
            self::valimail => 'Valimail Inc.',
            self::grasGroup => 'GRAS Group, Inc.',
            self::cybaa => 'Cybaa Ltd',
            self::emClient => 'eM Client s.r.o.',
            self::findFiles => 'FindFiles.net UG',
            self::projectDiscovery => 'ProjectDiscovery, Inc.',
            self::postman => 'Postman, Inc.',
            self::recordedFuture => 'Recorded Future, Inc.',
            self::bitsightTechnologies => 'BitSight Technologies, Inc.',
            self::ceramic => 'Ceramic, Inc.',
            self::screamingFrog => 'Screaming Frog Ltd',
            self::startMe => 'start.me BV',
            self::domainsBot => 'DomainsBot SRL',
            self::rwthAachen => 'RWTH Aachen University',
            self::parallelWebSystems => 'Parallel Web Systems Inc.',
            self::incsub => 'Incsub, LLC.',
            self::meinsUndVogel => 'Meins und Vogel GmbH',
            self::agencyAnalytics => 'AgencyAnalytics Inc',
            self::dynalist => 'Dynalist Inc.',
            self::barzmannInternetSolutions => 'Barzmann Internet Solutions GmbH',
            self::spazioDati => 'SpazioDati S.r.l.',
            self::dataprovider => 'Dataprovider B.V.',
            self::comscore => 'Comscore, Inc.',
            self::lumeWeaver => 'LumeWeaver Labs',
            self::nlpc => 'Natural Language Processing Centre',
            self::mindup => 'mindUp Web + Intelligence GmbH',
            self::exipert => 'Exipert, Inc. dba CheckMark Network',
            self::timpi => 'Timpi Inc.',
            self::finax => 'Finax, o.c.p, a.s.',
            self::keywordsStandings => 'Keywords Standings Ltd.',
            self::companySpotter => 'CompanySpotter BV',
            self::smartisan => 'Smartisan Technology Co., Ltd',
            self::arquivo => 'Arquivo.pt',
            self::serpstat => 'Serpstat Global LTD',
            self::surfboard => 'Surfboard Holding BV',
            self::github => 'GitHub Inc.',
            self::leeco => 'Leshi Internet Information & Technology',
            self::leagoo => 'LEAGOO International Co., Limited',
            self::pagePeeker => 'pagepeeker SRL',
            self::brightInteractive => 'Bright Interactive Ltd',
            self::eyeota => 'Eyeota Pte Ltd',
            self::onlineMediaGroup => 'Online Media Group, Inc.',
            self::xianghe => 'Xianghe Technology Co., Ltd.',
            self::surLy => 'Sur.ly LLC',
            self::yahooJapan => 'Yahoo! Japan Corp.',
            self::totalSecurity => 'Total Security Ltd.',
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
            self::akaMessenger => 'aka-messenger',
            self::tuneIn => 'tune-in',
            self::softmeTech => 'softme-tech',
            self::avast => 'avast-software',
            self::appsmedia => 'apps-media',
            self::kaweApps => 'kawe-apps',
            self::playitTechnology => 'playit-technology',
            self::fSecure => 'f-secure',
            self::gTab => 'g-tab',
            self::kinogoGe => 'kinogo-ge',
            self::cookieJarApps => 'cookie-jar-apps',
            self::larsWindolf => 'lars windolf',
            self::videoDownloadStudio => 'video-download-studio',
            self::yobiMobi => 'yobi-mobi',
            self::myHomeScreen => 'my-home-screen',
            self::blueWalletServices => 'bluewallet-services',
            self::anyDeskSoftware => 'anydesk-software',
            self::towoLabs => 'towo-labs',
            self::talkTalkTelecom => 'talk-talk-telecom',
            self::mobileV5 => 'mobile-v5',
            self::wolvesInteractive => 'wolves-interactive',
            self::buhlDataService => 'buhl-data-service',
            self::baySpringMedia => 'bay-spring-media',
            self::twoKitConsulting => '2kit-consulting',
            self::volcanoTechnology => 'volcano-technology',
            self::omshyApps => 'omshy-apps',
            self::thinkFree => 'think-free',
            self::wiseplayApps => 'wiseplay-apps',
            self::theNewYorkTimes => 'new-york-times',
            self::vishaGroup => 'visha-group',
            self::gnome => 'the-gnome-project',
            self::asdDev => 'asd-dev',
            self::dsTools => 'ds-tools',
            self::appsForGoogle => 'apps-for-google',
            self::mediahuisNrc => 'mediahuis-nrc',
            self::globalMediaEntertainment => 'global-media-entertainment',
            self::iHeartMedia => 'iheart-media',
            self::cameronKaiser => 'cameron-kaiser',
            self::orangeLabs => 'orange-labs',
            self::mikulasPatocka => 'mikulas-patocka',
            self::freeSoftwareFoundation => 'free-software-foundation',
            self::sandLabs => 'sand-labs',
            self::davidRosca => 'david-rosca',
            self::scaDigital => 'sca-igital',
            self::multimediosDigital => 'multimedios-digital',
            self::entertainmentNetwork => 'entertainment-network',
            self::sonyNetwork => 'sony-network',
            self::fancyMobileApps => 'fancy-mobile-apps',
            self::browserWorks => 'browser-works',
            self::paloAltoNetworks => 'palo-alto',
            self::yahooJapan => 'yahoo-japan',
            self::phpGroup => 'php-group',
            self::christianDywan => 'christian-dywan',
            self::thomasDickey => 'thomas-dickey',
            self::omniDevelopment => 'omni-development',
            self::phantomJS => 'phantom-js',
            self::markCavage => 'mark-cavage',
            self::wkhtmltopdforg => 'wk-html-to-pdf.org',
            self::espial => 'espial-group',
            self::kTouch => 'k-touch',
            self::greenOrange => 'green-orange',
            self::crazybrowser => 'crazy-browser',
            self::avantForce => 'avant-force',
            self::getdownloadWs => 'get-download',
            self::kaylonTechnologies => 'kaylon-technologies',
            self::xavierRoche => 'xavier-roche',
            self::kmeleonbrowserOrg => 'kmeleon-browser.org',
            self::designScience => 'design-science',
            self::deepnetSecurity => 'deepnet-security',
            self::yesLogic => 'yes-logic',
            self::acoobrowser => 'www.acoobrowser.com',
            self::sakamotoHironori => 'sakamoto-hironori',
            self::openatomFoundation => 'openatom-foundation',
            self::oceanHero => 'ocean-hero',
            self::eVentures => 'e.ventures',
            self::hubspot => 'hubspot-inc',
            self::linspire => 'linspire-inc',
            self::aftvnewsCom => 'aftvnews.com',
            self::theInternetArchive => 'archive.org',
            self::sonyEricsson => 'sony-ericsson',
            self::docomo => 'ntt-docomo',
            self::dogTorance => 'dog-torance',
            self::compuware => 'compuware-apm',
            self::whaleTV => 'whale-tv',
            self::richardTrautvetter => 'richard-trautvetter',
            self::beonexBusinessServices => 'beonex-business-services',
            self::appSimply => 'app-simply',
            self::iridiumBrowserTeam => 'iridium-browser-team',
            self::cocCoc => 'coc-coc-company',
            self::adaptiveBee => 'adaptive-bee',
            self::x115com => '115-com',
            self::digitalPebble => 'digital-pebble',
            self::nortonLifeLock => 'norton-life-lock',
            self::foundry376 => 'foundry-376',
            self::cryptoPro => 'crypto-pro',
            self::bywayEndeavors => 'byway-endeavors',
            self::sparkMail => 'spark-mail',
            self::blackPixel => 'black-pixel',
            self::quickHeal => 'quick-heal',
            self::toddDitchendorf => 'todd-ditchendorf',
            self::cheBinLiu => 'che-bin-liu',
            self::sinaWeibo => 'sina-weibo',
            self::chatwork => 'chat-work',
            self::timeWarnerCable => 'time-warner-cable',
            self::similarTech => 'similar-tech',
            self::ericssonResearch => 'ericsson-research',
            self::soundCloud => 'sound-cloud',
            self::videoLan => 'video-lan',
            self::gihyunJung => 'gihyun-jung',
            self::webExpansion => 'web-expansion',
            self::leysinMedia => 'leysin-media',
            self::tvPlus => 'tv+',
            self::prismPlus => 'prism+',
            self::topTech => 'top-tech',
            self::shopKeep => 'shop-keep',
            self::wonjooJang => 'wonjoo-jang',
            self::lightspeedSystems => 'lightspeed-systems',
            self::deedBaltic => 'deed-baltic',
            self::wooRank => 'woo-rank',
            self::nineteenTen => 'nineteen-ten',
            self::browserEdsonThiago => 'browser-edson-thiago',
            self::michelDeBoer => 'michel-de-boer',
            self::playNow => 'play-now',
            self::fedirTsapana => 'fedir-tsapana',
            self::wpoFoundation => 'wpo-foundation',
            self::rickCranisky => 'rick-cranisky',
            self::shiftphones => 'shift-phones',
            self::newsMe => 'news.me',
            self::wireSwiss => 'wire-swiss',
            self::rivalIq => 'rival-iq',
            self::lindenLabs => 'linden-labs',
            self::doubleVerify => 'double-verify',
            self::avira => 'avira-operations',
            self::topsyLabs => 'topsy-labs',
            self::daum => 'daum-corporation',
            self::mailRu => 'mail.ru',
            self::domainTools => 'domain-tools',
            self::teslaMotors => 'tesla-motors',
            self::zetakeySolutions => 'zetakey-solutions',
            self::mapleStudio => 'maple-studio',
            self::vkMobile => 'vk-mobile',
            self::lePan => 'le-pan',
            self::velocityMicro => 'velocity-micro',
            self::majestic12 => 'majestic-12',
            self::zoomInformation => 'zoom-information',
            self::torstenRueckert => 'torsten-rueckert',
            self::commonCrawl => 'common-crawl-foundation',
            self::nagios => 'nagios-enterprises',
            self::benKurtovic => 'ben-kurtovic',
            self::semanticVisions => 'semantic-visions',
            self::notionLabs => 'notion-labs',
            self::grasGroup => 'gras-group',
            self::emClient => 'em-client',
            self::findFiles => 'find-files',
            self::projectDiscovery => 'project-discovery',
            self::jaimeIniesta => 'jaime-iniesta',
            self::alexandreTourette => 'alexandre-tourette',
            self::torbenHansen => 'torben-hansen',
            self::vertexWP => 'vertex-wp',
            self::bitsightTechnologies => 'bitsight-technologies',
            self::screamingFrog => 'screaming-frog',
            self::recordedFuture => 'recorded-future',
            self::startMe => 'start.me',
            self::domainsBot => 'domains-bot',
            self::rwthAachen => 'rwth-aachen',
            self::manfredSchauer => 'manfred-schauer',
            self::parallelWebSystems => 'parallel-web-systems',
            self::mistralAI => 'mistral-ai',
            self::meinsUndVogel => 'meins-und-vogel',
            self::agencyAnalytics => 'agency-analytics',
            self::barzmannInternetSolutions => 'barzmann-internet-solutions',
            self::spazioDati => 'spazio-dati',
            self::hessischesStatistischesLandesamt => 'hessisches-statistisches-landesamt',
            self::lumeWeaver => 'lume-weaver',
            self::archiveTeam => 'archive-team',
            self::keywordsStandings => 'keywords-standings',
            self::flowTeam => 'flow-team',
            self::companySpotter => 'company-spotter',
            self::ghSoftware => 'gh-software',
            self::morningscore => 'morning-score',
            self::rakutenMobile => 'rakuten-mobile',
            self::eightPecxStudios => '8pecxstudios',
            self::elementSoftware => 'element-software',
            self::pagePeeker => 'page-peeker',
            self::adrienBarbaresi => 'adrien-barbaresi',
            self::brightInteractive => 'bright-interactive',
            self::elbertAlias => 'elbert-alias',
            self::barnesNoble => 'barnes-noble',
            self::phoenixStudio => 'phoenix-studio',
            self::onlineMediaGroup => 'online-media-group',
            self::surLy => 'sur.ly',
            self::totalSecurity => 'total-security',
            default => $this->name,
        };
    }
}
