<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory\Device;

use BrowserDetector\Cache\CacheInterface;
use BrowserDetector\Factory\DeviceFactoryInterface;
use BrowserDetector\Loader\DeviceLoaderFactory;
use Psr\Log\LoggerInterface;

class MobileFactory implements DeviceFactoryInterface
{
    private $factories = [
        '/startrail|starxtrem|starshine|staraddict|starnaute|startext|startab/i' => 'sfr', // also includes the 'Tunisie Telecom' and the 'Altice' branded devices
        '/HTC|Sprint (APA|ATP)|ADR(?!910L)[a-z0-9]+|NexusHD2|Amaze[ _]4G[);\/ ]|(Desire|Sensation|Evo ?3D|IncredibleS|Wildfire|Butterfly)[ _]?([^;\/]+) Build|(Amaze[ _]4G|One ?[XELSV\+]+)[);\/ ]|SPV E6[05]0|One M8|X525a|PG86100|PC36100|XV6975|PJ83100[);\/ ]|2PYB2|0PJA10|T\-Mobile_Espresso/' => 'htc',
        // @todo: rules with company name in UA
        '/hiphone/i' => 'hiphone',
        '/technisat/i' => 'technisat',
        '/samsung[is \-;\/]|gt\-i8750/i' => 'samsung',
        '/nokia/i' => 'nokia',
        '/blackberry/i' => 'rim',
        '/asus/i' => 'asus',
        '/feiteng/i' => 'feiteng',
        '/myphone|cube_lte/i' => 'myphone', // must be before Cube
        '/cube/i' => 'cube',
        '/LG/' => 'lg',
        '/pantech/i' => 'pantech',
        '/HP/' => 'hp',
        '/sony/i' => 'sony',
        '/accent/i' => 'accent',
        '/lenovo/i' => 'lenovo',
        '/zte|racer/i' => 'zte',
        '/acer|da241hl/i' => 'acer',
        '/amazon/i' => 'amazon',
        '/amoi/i' => 'amoi',
        '/blaupunkt/i' => 'blaupunkt',
        '/CCE /' => 'cce',
        '/endeavour/i' => 'blaupunkt', // must be before Onda
        '/ONDA/' => 'onda',
        '/archos/i' => 'archos',
        '/irulu/i' => 'irulu',
        '/symphony/i' => 'symphony',
        '/spice/i' => 'spice',
        '/arnova/i' => 'arnova',
        '/ bn /i' => 'barnesnoble',
        '/coby/i' => 'coby',
        '/o\+|oplus/i' => 'oplus',
        '/goly/i' => 'goly',
        '/WM\d{4}/' => 'wondermedia',
        '/comag/i' => 'comag',
        '/coolpad/i' => 'coolpad',
        '/cosmote/i' => 'cosmote',
        '/creative/i' => 'creative',
        '/cubot/i' => 'cubot',
        '/dell/i' => 'dell',
        '/denver/i' => 'denver',
        '/sharp|shl25/i' => 'sharp',
        '/flytouch/i' => 'flytouch',
        '/n\-06e|n[79]05i/i' => 'nec', // must be before docomo
        '/docomo/i' => 'docomo',
        '/easypix/i' => 'easypix',
        '/xoro/i' => 'xoro',
        '/memup/i' => 'memup',
        '/fujitsu/i' => 'fujitsu',
        '/honlin/i' => 'honlin',
        '/huawei/i' => 'huawei',
        '/micromax/i' => 'micromax',
        '/explay/i' => 'explay',
        '/oneplus/i' => 'oneplus',
        '/kingzone/i' => 'kingzone',
        '/goophone/i' => 'goophone',
        '/g\-tide/i' => 'gtide',
        '/turbo ?pad/i' => 'turbopad',
        '/haier/i' => 'haier',
        '/hummer/i' => 'hummer',
        '/oysters/i' => 'oysters',
        '/gfive/i' => 'gfive',
        '/iconbit/i' => 'iconbit',
        '/sxz/i' => 'sxz',
        '/aoc/i' => 'aoc',
        '/jay\-tech/i' => 'jaytech',
        '/jolla/i' => 'jolla',
        '/kazam/i' => 'kazam',
        '/kddi/i' => 'kddi',
        '/kobo/i' => 'kobo',
        '/lenco/i' => 'lenco',
        '/le ?pan/i' => 'lepan',
        '/logicpd/i' => 'logicpd',
        '/medion/i' => 'medion',
        '/meizu/i' => 'meizu',
        '/hisense/i' => 'hisense',
        '/minix/i' => 'minix',
        '/allwinner/i' => 'allwinner',
        '/supra/i' => 'supra',
        '/prestigio/i' => 'prestigio',
        '/mobistel/i' => 'mobistel',
        '/moto/i' => 'motorola',
        '/nintendo/i' => 'nintendo',
        '/crosscall|trekker|odyssey/i' => 'crosscall', // must be before ODYS
        '/odys/i' => 'odys',
        '/oppo/i' => 'oppo',
        '/panasonic/i' => 'panasonic',
        '/pandigital/i' => 'pandigital',
        '/phicomm/i' => 'phicomm',
        '/pomp/i' => 'pomp',
        '/qmobile/i' => 'qmobile',
        '/sanyo/i' => 'sanyo',
        '/siemens/i' => 'siemens',
        '/benq/i' => 'siemens',
        '/sagem/i' => 'sagem',
        '/ouya/i' => 'ouya',
        '/trevi/i' => 'trevi',
        '/cowon/i' => 'cowon',
        '/homtom/i' => 'homtom',
        '/hosin/i' => 'hosin',
        '/hasee/i' => 'hasee',
        '/tecno/i' => 'tecno',
        '/intex/i' => 'intex',
        '/mt\-gt\-a9500|gt\-a7100/i' => 'htm', // must be before samsung (gt rule)
        '/gt\-h/i' => 'feiteng',
        '/u25gt\-c4w|u51gt/i' => 'cube',
        '/gt\-9000/i' => 'star',
        '/sc\-74jb|sc\-91mid/i' => 'supersonic',
        '/(gt|sam|sc|sch|sec|sgh|shv|shw|sm|sph|continuum|ek|yp)\-/i' => 'samsung', // must be before orange and sprint
        '/sprint/i' => 'sprint',
        '/gionee/i' => 'gionee',
        '/videocon/i' => 'videocon',
        '/gigaset/i' => 'gigaset',
        '/dns|s4503q/i' => 'dns',
        '/kyocera/i' => 'kyocera',
        '/texet/i' => 'texet',
        '/s\-tell/i' => 'stell',
        '/bliss/i' => 'bliss',
        '/alcatel/i' => 'alcatel',
        '/tolino/i' => 'tolino',
        '/toshiba/i' => 'toshiba',
        '/trekstor/i' => 'trekstor',
        '/viewsonic/i' => 'viewsonic',
        '/view(pad|phone)/i' => 'viewsonic',
        '/wiko/i' => 'wiko',
        '/BLU/' => 'blu',
        '/vivo (iv|4\.65)/i' => 'blu',
        '/vivo/i' => 'vivo',
        '/haipai/i' => 'haipai',
        '/megafon/i' => 'megafon',
        '/yuanda/i' => 'yuanda',
        '/pocketbook/i' => 'pocketbook',
        '/goclever/i' => 'goclever',
        '/senseit/i' => 'senseit',
        '/twz/i' => 'twz',
        '/i\-mobile/i' => 'imobile',
        '/evercoss/i' => 'evercoss',
        '/dino/i' => 'dino',
        '/shaan|iball/i' => 'shaan',
        '/modecom/i' => 'modecom',
        '/kiano/i' => 'kiano',
        '/philips/i' => 'philips',
        '/infinix/i' => 'infinix',
        '/infocus/i' => 'infocus',
        '/karbonn/i' => 'karbonn',
        '/pentagram/i' => 'pentagram',
        '/smartfren/i' => 'smartfren',
        '/gce x86 phone/i' => 'google',
        '/ngm/i' => 'ngm',
        '/orange (hi 4g|reyo)/i' => 'zte', // must be before orange
        '/orange/i' => 'orange',
        '/spv/i' => 'orange',
        '/mot/i' => 'motorola',
        '/P(GN|HS|KT)\-?\d{3}/' => 'condor',
        '/hs\-/i' => 'hisense',
        '/beeline pro/i' => 'zte',
        '/beeline/i' => 'beeline',
        '/digma/i' => 'digma',
        '/axgio/i' => 'axgio',
        '/zopo/i' => 'zopo',
        '/malata/i' => 'malata',
        '/starway/i' => 'starway',
        '/starmobile/i' => 'starmobile',
        '/logicom/i' => 'logicom',
        '/gigabyte/i' => 'gigabyte',
        '/qumo/i' => 'qumo',
        '/celkon/i' => 'celkon',
        '/bravis/i' => 'bravis',
        '/fnac/i' => 'fnac',
        '/i15\-tcl/i' => 'cube',
        '/tcl/i' => 'tcl',
        '/radxa/i' => 'radxa',
        '/xolo/i' => 'xolo',
        '/dragon touch/i' => 'dragontouch',
        '/ramos/i' => 'ramos',
        '/woxter/i' => 'woxter',
        '/k\-?touch/i' => 'ktouch',
        '/mastone/i' => 'mastone',
        '/nuqleo/i' => 'nuqleo',
        '/wexler/i' => 'wexler',
        '/exeq/i' => 'exeq',
        '/4good/i' => 'fourgood',
        '/utstar/i' => 'utstarcom',
        '/walton/i' => 'walton',
        '/quadro/i' => 'quadro',
        '/xiaomi/i' => 'xiaomi',
        '/pipo/i' => 'pipo',
        '/tesla/i' => 'tesla',
        '/doro/i' => 'doro',
        '/captiva/i' => 'captiva',
        '/elephone/i' => 'elephone',
        '/cyrus/i' => 'cyrus',
        '/wopad/i' => 'wopad',
        '/anka/i' => 'anka',
        '/lemon/i' => 'lemon',
        '/lava/i' => 'lava',
        '/sop\-/i' => 'sop',
        '/vsun/i' => 'vsun',
        '/advan/i' => 'advan',
        '/velocity/i' => 'velocitymicro',
        '/allview/i' => 'allview',
        '/turbo\-x/i' => 'turbo-x',
        '/tagi/i' => 'tagi',
        '/avvio/i' => 'avvio',
        '/e\-boda/i' => 'eboda',
        '/ergo/i' => 'ergo',
        '/pulid/i' => 'pulid',
        '/dexp/i' => 'dexp',
        '/keneksi/i' => 'keneksi',
        '/reeder/i' => 'reeder',
        '/globex/i' => 'globex',
        '/oukitel/i' => 'oukitel',
        '/itel/i' => 'itel',
        '/wileyfox/i' => 'wileyfox',
        '/morefine/i' => 'morefine',
        '/vernee/i' => 'vernee',
        '/iocean/i' => 'iocean',
        '/intki/i' => 'intki',
        '/i\-joy/i' => 'ijoy',
        '/inq/i' => 'inq',
        '/inew/i' => 'inew',
        '/iberry/i' => 'iberry',
        '/koobee/i' => 'koobee',
        '/kingsun/i' => 'kingsun',
        '/komu/i' => 'komu',
        '/kopo/i' => 'kopo',
        '/koridy/i' => 'koridy',
        '/kumai/i' => 'kumai',
        '/konrow/i' => 'konrow',
        '/nexus ?[45]/i' => 'lg', // must be before MTC
        '/MTC/' => 'mtc',
        '/eSTAR/' => 'estar',
        '/flipkart|xt811/i' => 'flipkart',
        '/XT\d{3,4}|WX\d{3}|MB\d{3}/' => 'motorola', // must be before 3Q
        '/3Q/' => 'triq',
        '/UMI/' => 'umi',
        '/NTT/' => 'nttsystem',
        '/lingwin/i' => 'lingwin',
        '/boway/i' => 'boway',
        '/sprd/i' => 'sprd',
        '/NEC\-/' => 'nec',
        '/thl[ _]/i' => 'thl',
        '/iq1055/i' => 'mls', // must be before Fly
        '/fly[ _]|(iq|fs)\d{3,4}|phoenix 2/i' => 'fly',
        '/bmobile[ _]/i' => 'bmobile',
        '/HL/' => 'honlin',
        '/mtech/i' => 'mtech',
        '/myTAB/' => 'mytab',
        '/lexand/i' => 'lexand',
        '/meeg/i' => 'meeg',
        '/mofut/i' => 'mofut',
        '/majestic/i' => 'majestic',
        '/mlled/i' => 'mlled',
        '/m\.t\.t\./i' => 'mtt',
        '/meu/i' => 'meu',
        '/noain/i' => 'noain',
        '/nomi/i' => 'nomi',
        '/nexian/i' => 'nexian',
        '/ouki/i' => 'ouki',
        '/opsson/i' => 'opsson',
        '/qilive/i' => 'qilive',
        '/quechua/i' => 'quechua',
        '/stx/i' => 'stonex',
        '/sunvan/i' => 'sunvan',
        '/vollo/i' => 'vollo',
        '/bluboo/i' => 'bluboo',
        '/nuclear/i' => 'nuclear',
        '/uniscope/i' => 'uniscope',
        '/voto/i' => 'voto',
        '/la\-m1|la2\-t/i' => 'beidou',
        '/yusun/i' => 'yusun',
        '/ytone/i' => 'ytone',
        '/zeemi/i' => 'zeemi',
        '/bush/i' => 'bush',
        '/B[iI][rR][dD][ _\-]/' => 'bird',
        '/bq /i' => 'bq',
        '/cherry/i' => 'cherry-mobile',
        '/desay/i' => 'desay',
        '/datang/i' => 'datang',
        '/doov/i' => 'doov',
        '/EBEST/' => 'ebest',
        '/ETON/' => 'eton',
        '/evolveo/i' => 'evolveo',
        '/telenor[ _]/i' => 'telenor',
        '/concorde/i' => 'concorde',
        '/poly ?pad/i' => 'polypad',
        '/readboy/i' => 'readboy',
        '/sencor/i' => 'sencor',
        // @todo: general rules
        '/auxus/i' => 'iberry',
        '/lumia|maemo rx|portalmmm\/2\.0 n7|portalmmm\/2\.0 nk|nok[0-9]+|symbian.*\s([a-z0-9]+)$|rx-51 n900|rm-(1031|104[25]|106[234567]|107[234567]|1089|109[029]|1109|111[34]|1127|1141|1154)|ta-[0-9]{4} build|(adr|android) 5\.[01].* n1|5130c\-2|arm; 909|id336|genm14/i' => 'nokia', // also includes the 'Microsoft' branded Lumia devices,
        '/(adr|android) 4\.4.* n1/i' => 'newsman',
        '/(adr|android) 4\.2.* n1/i' => 'oppo',
        '/(adr|android) 4\.0.* n1/i' => 'tizzbird',
        '/rm\-(997|560)/i' => 'rossmoor',
        '/u30gt|u55gt/i' => 'cube',
        '/gtx75/i' => 'utstarcom',
        '/galaxy s3 ex/i' => 'hdc',
        '/nexus[ _]?7/i' => 'asus',
        '/nexus 6p/i' => 'huawei',
        '/nexus 6/i' => 'motorola',
        '/nexus ?(one|9|evohd2|hd2)/i' => 'htc',
        '/p160u|touchpad|pixi|palm|cm_tenderloin|slate/i' => 'hp',
        '/galaxy|nexus|i(7110|9100|9300)|blaze|s8500/i' => 'samsung',
        '/smart ?(tab(10|7)|4g|ultra 6)/i' => 'zte',
        '/idea(tab|pad)|smarttab|thinkpad/i' => 'lenovo',
        '/iconia|liquid/i' => 'acer',
        '/playstation/i' => 'sony',
        '/kindle|silk|kf(tt|ot|jwi|sowi|thwi|apwa|aswi|apwi|dowi|auwi|giwi|tbwi|mewi|fowi|sawi|sawa|arwi|thwa|jwa)|sd4930ur|fire2/i' => 'amazon',
        '/bntv600/i' => 'barnesnoble',
        '/playbook|rim tablet|bb10|stv100|bb[ab]100\-2|sth100\-2|bbd100\-1/i' => 'rim',
        '/b15/i' => 'caterpillar',
        '/cat ?(nova|stargate|tablet|helix)/i' => 'catsound',
        '/MID1014/' => 'micromax',
        '/MID0714|MIDC|PMID/' => 'polaroid',
        '/MID(1024|1125|1126|1045|1048|1060|1065|4331|7012|7015A?|7016|7022|7032|7035|7036|7042|7047|7048|7052|7065|7120|8024|8042|8048|8065|8125|8127|8128|9724|9740|9742)/' => 'coby',
        '/(?<!\/)MID713|MID(06[SN]|08[S]?|12|13|14|15|701|702|703|704|705(DC)?|706[AS]?|707|708|709|711|712|714|717|781|801|802|901|1001|1002|1003|1004( 3G)?|1005|1009|1010|7802|9701|9702)/' => 'manta',
        '/P[AS]P|PM[PT]/' => 'prestigio',
        '/smartpad7503g|smartpad970s2(3g)?|m[_\-][mp]p[0-9a-z]+|m\-ipro[0-9a-z]+/i' => 'mediacom',
        '/(mpqc|mpdc)\d{1,4}|ph\d{3}|mid(7c|74c|82c|84c|801|811|701|711|170|77c|43c|102c|103c|104c|114c)|mp(843|717|718|843|888|959|969|1010|7007|7008)|mgp7/i' => 'mpman',
        '/nbpc724/i' => 'coby',
        '/wtdr1018/i' => 'comag',
        '/ziilabs|ziio7/i' => 'creative',
        '/ta[dq]\-/i' => 'denver',
        '/connect(7pro|8plus)/i' => 'odys',
        '/\d{3}SH|SH\-?\d{2,4}[CDEFUW]/' => 'sharp',
        '/p900i/i' => 'docomo',
        '/easypad|easyphone|junior 4\.0/i' => 'easypix',
        '/smart\-e5/i' => 'efox',
        '/telepad/i' => 'xoro',
        '/slidepad|sp\d{3}|spng\d{3}/i' => 'memup',
        '/epad|p7901a/i' => 'zenithink',
        '/p7mini/i' => 'huawei',
        '/m532|m305|f\-0\d[def]|is11t/i' => 'fujitsu',
        '/sn10t1|hsg\d{4}/i' => 'hannspree',
        '/PC1088/' => 'honlin',
        '/INM\d{3,4}/' => 'intenso',
        '/sailfish/i' => 'jolla',
        '/zoom2|nook ?color/i' => 'logicpd',
        '/lifetab/i' => 'medion',
        '/cynus/i' => 'mobistel',
        '/DARK(MOON|SIDE|NIGHT|FULL)/' => 'wiko',
        '/ARK/' => 'ark',
        '/Ever(Classic|Glory|Magic|Mellow|Miracle|Shine|Smart|Star|Trendy)/' => 'evertek',
        '/Magic/' => 'magic',
        '/M[Ii][ -](\d|PAD|M[AI]X|NOTE|A1|1S|3|ONE)/' => 'xiaomi',
        '/HM[ _](NOTE|1SC|1SW|1S|1)/' => 'xiaomi',
        '/WeTab/' => 'neofonie',
        '/SIE\-/' => 'siemens',
        '/CAL21|C771|C811/' => 'casio',
        '/g3mini/i' => 'lg',
        '/P[CG]\d{5}/' => 'htc',
        '/OK[AU]\d{1,2}/' => 'ouki',
        '/[AC]\d{5}/' => 'nomi',
        '/one e\d{4}/i' => 'oneplus',
        '/one a200[135]/i' => 'oneplus',
        '/f5281|u972|e621t|eg680|e2281uk/i' => 'hisense',
        '/TBD\d{4}|TBD[BCG]\d{3,4}/' => 'zeki',
        '/AC0732C|RC9724C|MT0739D|QS0716D|LC0720C|MT0812E/' => 'triq',
        '/ImPAD6213M_v2/' => 'impression',
        '/D6000/' => 'innos',
        '/[SV]T\d{5}/' => 'trekstor',
        '/e6560|c6750|c6742|c6730|c6522n|c5215|c5170|c5155|c5120|dm015k|kc\-s701/i' => 'kyocera',
        '/p4501|p850x|e4004|e691x|p1050x|p1032x|p1040x|s1035x|p1035x|p4502|p851x|x5001/i' => 'medion',
        '/g6600/i' => 'huawei',
        '/DG\d{3,4}/' => 'doogee',
        '/Touchlet|X7G|X10\./' => 'pearl',
        '/terra pad|pad1002/i' => 'wortmann',
        '/g710[68]/i' => 'samsung',
        '/e1041x|e1050x|b5531/i' => 'lenovo',
        '/rio r1|gsmart/i' => 'gigabyte',
        '/[ ;](l\-?ement|l\-ite|l\-?ixir)|e[89]12|e731|e1031|kt712a_4\\.4|tab1062|tab950/i' => 'logicom',
        '/ [CDEFG]\d{4}/' => 'sony',
        '/PM\-\d{4}/' => 'sanyo',
        '/folio_and_a|toshiba_ac_and_az|folio100/i' => 'toshiba',
        '/(aqua|cloud)[_ \.]/i' => 'intex',
        '/bv[5-8]000/i' => 'blackview',
        '/XELIO_NEXT|(MAVEN|SPACE|TAO|THOR)_?X?10/' => 'odys',
        '/NEXT|Next\d|DATAM803HC|NX785QC8G|NXM900MC|NX008HD8G|NX010HI8G|NXM908HC|NXM726/' => 'nextbook',
        '/A310|ATLAS[_ ]W|BASE Tab|KIS PLUS|N799D|N9101|N9180|N9510|N9515|N9520|N9521|N9810|N918St|N958St|NX\d{2,3}|OPEN[C2]|U9180| V9 |V788D|V8000|V9180|X501|X920|Z221|Z835|Z768G|Z820|Z981/' => 'zte',
        '/lutea|bs 451|n9132|grand s flex|e8q\+|s8q|s7q/i' => 'zte',
        '/ultrafone/i' => 'zen',
        '/ mt791 /i' => 'keenhigh',
        '/g100w|stream\-s110| (a1|a3|b1|b3)\-/i' => 'acer',
        '/wildfire|desire/i' => 'htc',
        '/a101it|a7eb|a70bht|a70cht|a70hb|a70s|a80ksc|a35dm|a70h2|a50ti/i' => 'archos',
        '/b51\+/i' => 'sprd',
        '/sphs_on_hsdroid/i' => 'mhorse',
        '/TAB A742|TAB7iD|ZEN \d/' => 'wexler',
        '/VS810PP/' => 'lg',
        '/vox s502 3g|(cs|vs|ps|tt|pt|lt|ct|ts|ns|ht)\d{3,4}[aempqs]/i' => 'digma',
        '/A400/' => 'celkon',
        '/A5000/' => 'sony',
        '/A1002|A811|S[45]A\d|SC7 PRO HD/' => 'lexand',
        '/A121|A120|A116|A114|A093|A065| A96 |Q327| A47/' => 'micromax',
        '/smart tab 4g/i' => 'lenovo',
        '/smart tab 4|vfd \d{3}|985n/i' => 'vodafone',
        '/smart ?tab|s6000d/i' => 'lenovo',
        '/S208|S308|S550|S600|Z100 Pro|NOTE Plus/' => 'cubot',
        '/TQ\d{3}/' => 'goclever',
        '/q8002/i' => 'crypto',
        '/a1000s|q10[01]0i?|q[678]00s?|q2000|omega[ _]\d/i' => 'xolo',
        '/s750/i' => 'beneve',
        '/blade/i' => 'zte',
        '/ z110/i' => 'xido',
        '/titanium|machfive|sparkle v/i' => 'karbonn',
        '/a727/i' => 'azpen',
        '/(ags|a[ln]e|ath|ba[ch]|bl[an]|bnd|cam|ch[cm]|che[12]?|clt|dli|duk|eml|fig|frd|gra|h[36]0|kiw|lon|m[hy]a|nem|plk|pra|rne|scl|trt|vky|vtr|was|y220)\-/i' => 'huawei',
        '/V1\d{2}|GN\d{3}/' => 'gionee',
        '/v919 3g air/i' => 'onda', // must be before acer
        '/a501 bright/i' => 'bravis', // must be before acer
        '/tm785m3/i' => 'nuvision',
        '/m785|800p71d|800p3[12]c|101p51c|x1010|a1013r|s10\-0g/i' => 'mecer', // must be before acer
        '/ [aevzs]\d{3} /i' => 'acer',
        '/AT\-AS\d{2}[DS]/' => 'wolfgang',
        '/AT1010\-T/' => 'lenovo',
        '/vk\-/i' => 'vkmobile',
        '/FP[12]/' => 'fairphone',
        '/le 1 pro|le 2|le max|le ?x\d{3}/i' => 'leeco',
        '/loox|uno_x10|xelio|neo_quad10|ieos_quad|sky plus|maven_10_plus|maven10_hd_plus_3g|maven_x10_hd_lte|space10_plus|adm816|noon|xpress|genesis|tablet-pc-4|kinder-tablet|evolution12|mira|score_plus|pro q8 plus|rapid7lte|neo6_lte|rapid_10/i' => 'odys',
        '/CINK|JERRY|BLOOM|SLIDE|GETAWAY|WAX|KITE|BARRY|HIGHWAY|OZZY|RIDGE|PULP|SUNNY|FEVER|PLUS|SUNSET|FIZZ|U FEEL|ROBBY|BIRDY| GOA|IGGY|JIMMY|STAIRWAY|SUBLIM/' => 'wiko',
        '/l5510|rainbow|view xl|view prime|lenny/i' => 'wiko',
        '/BQS|BQ \d{4}/' => 'bq',
        '/aquaris/i' => 'bq',
        '/Pre\//' => 'hp',
        '/ME\d{3}[A-Z]|[KPZ]0[0-2][0-9a-zA-Z]/' => 'asus',
        '/padfone|transformer|slider sl101|eee_701|tpad_10|tx201la/i' => 'asus',
        '/QtCarBrowser/' => 'teslamotors',
        '/m[bez]\d{3}/i' => 'motorola',
        '/vodafone smart 4 max|smart 4 turbo/i' => 'vodafone',
        '/s5003d_champ/i' => 'switel',
        '/one[ _]?touch|v860|vodafone (smart|785|875|975n)|vf\-(795|895n)|m812c|telekom puls/i' => 'alcatel',
        '/vodafone 975/i' => 'vodafone',
        '/xperia/i' => 'sony',
        '/momodesign md droid/i' => 'zte',
        '/ droid|milestone|xoom|razr hd| z /i' => 'motorola',
        '/(vns)\-/i' => 'huawei',
        '/SGP\d{3}|X[ML]\d{2}[th]/' => 'sony',
        '/sgpt\d{2}/i' => 'sony',
        '/(YU|AO)\d{4}/' => 'yu',
        '/u\d{4}|ideos|vodafone[ _]858|vodafone 845|ascend|m860| p6 |hi6210sft|honor|enjoy 7 plus/i' => 'huawei',
        '/vodafone 890n/i' => 'yulong',
        '/one [sx]|a315c|vpa/i' => 'htc',
        '/OP\d{3}/' => 'olivetti',
        '/VS\d{3}/' => 'lg',
        '/surftab|vt10416|breeze 10\.1 quad|xintroni10\.1|st70408_4/i' => 'trekstor',
        '/AT\d{2,3}|T\-0\d[CD]/' => 'toshiba',
        '/E[vV][oO] ?3D|PJ83100|831C|Eris 2\.1|0PCV1|MDA|0PJA10/' => 'htc',
        '/adr\d{4}/i' => 'htc',
        '/mt6515m\-a1\+/i' => 'united',
        '/ c7 | h1 | cheetah | x12 | x16 | x17_s | x18 /i' => 'cubot',
        '/mt10b/i' => 'excelvan',
        '/mt10/i' => 'mtn',
        '/m1009|mt13|kp\-703/i' => 'excelvan',
        '/MT6582\/|mn84l_8039_20203/' => 'unknown',
        '/mt6515m\-a1\+/' => 'united',
        '/nook/i' => 'barnesnoble',
        '/BIGCOOL|COOLFIVE|COOL\-K|Just5|LINK5/' => 'konrow',
        '/v1_viper|a4you|p5_quad|x2_soul|ax4nano|x1_soul|p5_energy/i' => 'allview',
        '/PLT([^;\/]+) Build/' => 'proscan',
        '/[SLWM]T\d{2}|[SM]K\d{2}|SO\-\d{2}[BCDEFG]/' => 'sony',
        '/l\d{2}u/i' => 'sony',
        '/RMD\-\d{3,4}/' => 'ritmix',
        '/AX\d{3}/' => 'bmobile',
        '/free(way )?tab|xino z[\d]+ x[\d]+/i' => 'modecom',
        '/OV\-|Solution 7III|Qualcore 1010/' => 'overmax',
        '/FX2/' => 'faktorzwei',
        '/AN\d{1,2}|ARCHM\d{3}/' => 'arnova',
        '/POV|TAB\-PROTAB|MOB\-5045/' => 'point-of-view',
        '/PI\d{4}/' => 'philips',
        '/FUNC/' => 'dfunc',
        '/iD[jnsxr][DQ]?\d{1,2}/' => 'digma',
        '/GM/' => 'generalmobile',
        '/ZP\d{3}/' => 'zopo',
        '/s450\d/i' => 'dns',
        '/phoenix 2/i' => 'fly',
        '/vtab1008/i' => 'vizio',
        '/tab10\-400/i' => 'yarvik',
        '/terra_101|orion7o|aries|insignia|quantum/i' => 'goclever',
        '/venue|xcd35/i' => 'dell',
        '/funtab|zilo/i' => 'orange',
        '/fws610_eu/i' => 'phicomm',
        '/samurai10/i' => 'shiru',
        '/ignis 8/i' => 'tbtouch',
        '/k1 turbo/i' => 'kingzone',
        '/ a10 |mp907c/i' => 'allwinner',
        '/shield tablet/i' => 'nvidia',
        '/u7 plus|u16 max|k6000 pro|k6000 plus|k4000|k10000|universetap/i' => 'oukitel',
        '/k107/i' => 'yuntab',
        '/mb40ii1/i' => 'dns',
        '/m3 note/i' => 'meizu',
        '/ m[35] |f103| e7 | v6l |pioneer|dream_d1|(adr|android) 4\.2.* p2/i' => 'gionee',
        '/w[12]00| w8/i' => 'thl',
        '/w713|cp\d{4}|n930|5860s|8079|8190q|8295/i' => 'coolpad',
        '/w960/i' => 'sony',
        '/n8000d|n[579]1[01]0/i' => 'samsung',
        '/n003/i' => 'neo',
        '/ v1 /i' => 'maxtron',
        '/7007hd/i' => 'perfeo', // must be before alcatel
        '/TM\-\d{4}/' => 'texet', // must be before alcatel
        '/(OT\-)?[4-9]0[0-7]\d[ADFHKMNOXY]|OT\-[89][09]\d/' => 'alcatel',
        '/ W\d{3}[ )]/' => 'haier',
        '/NT\-\d{4}[SPTM]/' => 'iconbit',
        '/T[GXZ]\d{2,3}/' => 'irbis',
        '/YD\d{3}/' => 'yota',
        '/OK\d{3}/' => 'sunup',
        '/ACE/' => 'samsung',
        '/PX\-\d{4}/' => 'intego',
        '/ip\d{4}/i' => 'dex',
        '/P1060X/' => 'lenovo',
        '/P\d{4}/' => 'elephone',
        '/One/' => 'htc',
        '/element p501|element[ _]?(7|8|9\.7|10)/i' => 'sencor',
        '/elegance|intelect|cavion|slim ?tab ?(7|8|10)|core 10\.1 dual 3g/i' => 'kiano',
        '/ c4 |phablet \d|tab[_ ]?(7|8|9|10)[_ ]?3g/i' => 'trevi',
        '/ v\d\-?[ace]?[ )]/i' => 'inew',
        '/(RP|KM)\-U[DQ]M\d{2}/' => 'verico',
        '/KM\-/' => 'kttech',
        '/primo76|primo 91/i' => 'msi',
        '/x\-pad|navipad/i' => 'texet', // must be before odys' visio rule
        '/visio/i' => 'odys',
        '/ g3 |p713|p509|c660|(ls|vm|ln)\d{3}|optimus g|l\-0\d[cde]/i' => 'lg',
        '/zera[ _]f|boost iise|ice2|prime s|explosion/i' => 'highscreen',
        '/iris708/i' => 'ais',
        '/l930/i' => 'ciotcud',
        '/x8\+/i' => 'triray',
        '/(atlantis|discovery) \d{3,4}/i' => 'blaupunkt',
        '/surfer 7\.34|m1_plus|d7\.2 3g|rioplay|art 3g|atlant/i' => 'explay',
        '/pmsmart450/i' => 'pmedia',
        '/f031|n900\+|sc[lt]2\d|isw11sc|s7562|sghi\d{3}|i8910/i' => 'samsung',
        '/iusai/i' => 'opsson',
        '/netbox| x10 | e1[05]i| x2 |r800x|s500i|x1i|x10i|[ls]39h|h3213|h3311|h8216|h8324|ebrd\d{4}/i' => 'sony',
        '/PROV?\d{3}[B\d]?/' => 'polaroid',
        '/x90\d{1,2}|n52\d{2}|r[12678]\d{2,3}|u70\dt|find7|a3[37]f|r7[ks]?f|r7plusf| 1201 |n1t/i' => 'oppo',
        '/N\d{4}/' => 'star',
        '/technipad|aqipad|techniphone/i' => 'technisat', // must be before apple
        '/medipad/i' => 'bewatec',
        '/mipad/i' => 'xiaomi',
        '/android.*iphone/i' => 'xianghe',
        '/ucweb.*adr.*iphone/i' => 'xianghe',
        '/ipodder|tripadvisor/i' => 'generalmobile',
        '/ipad|ipod|iphone|like mac os x|darwin|cfnetwork|dataaccessd|iuc ?\(/i' => 'apple',
        '/iPh\d\,\d|Puffin\/[\d\.]+I[TP]/' => 'apple',
        '/t\-mobile/i' => 'tmobile',
        '/A101|A500|Z[25]00| T0[346789] | S55 |DA220HQL| E39 /' => 'acer',
        '/a1303|a309w/i' => 'china-phone',
        '/k910l| [ak]1 ?| a6[05] |yoga tablet|tab2a7\-|p770|zuk |(adr|android) [67].* p2|yb1\-x90l|b5060|s1032x|x1030x/i' => 'lenovo',
        '/impad/i' => 'impression',
        '/tab917qc|tab785dual/i' => 'sunstech',
        '/m7t|p93g|i75|m83g| m6 |m[69]pro| t9 /i' => 'pipo',
        '/md948g/i' => 'mway',
        '/smartphone650/i' => 'master',
        '/mx enjoy tv box/i' => 'geniatech',
        '/m5301/i' => 'iru',
        '/gv7777/i' => 'prestigio',
        '/9930i/i' => 'star',
        '/m717r\-hd/i' => 'vastking',
        '/m502/i' => 'navon',
        '/lencm900hz/i' => 'lenco',
        '/xm[13]00/i' => 'landvo',
        '/m370i/i' => 'infocus',
        '/dm550/i' => 'blackview',
        '/ m8 /i' => 'amlogic',
        '/m601/i' => 'aoc',
        '/IM\-[AT]\d{3}[LKS]|ADR910L/' => 'pantech',
        '/vf\-?\d{3,4}|\d{4}[biky]/i' => 'tcl',
        '/SPX\-\d/' => 'simvalley',
        '/H[MTW]\-[GINW]\d{2,3}/' => 'haier',
        '/RG\d{3}/' => 'ruggear',
        '/(android|adr).* iris/i' => 'lava',
        '/ap\-105/i' => 'mitashi',
        '/AP\-\d{3}/' => 'assistant',
        '/ARM; WIN (JR|HD)/' => 'blu',
        '/tp\d{1,2}(\.\d)?\-\d{4}|tu\-\d{4}/i' => 'ionik',
        '/ft[ _]\d{4}/i' => 'lifeware',
        '/(od|sm|yq)\d{3}/i' => 'smartisan',
        '/ls\-\d{4}/i' => 'lyf',
        '/redmi|note 4|2015562|2014(81[138]|501|011)|2013(02[23]|061)/i' => 'xiaomi',
        '/mx\d/i' => 'meizu',
        '/x[69]pro|x5max_pro/i' => 'doogee',
        '/x\d ?(plus|max|pro)/i' => 'vivo',
        '/neffos|tp\d{3}/i' => 'tplink',
        '/hudl 2|hudl ht7s3/i' => 'tesco',
        '/ht\d{1,2} ?(pro)?/i' => 'homtom',
        '/tb\d{3,4}/i' => 'acme',
        '/nt\. ?(p|i)10g2/i' => 'ninetec',
        '/N[BP]\d{2,3}/' => 'bravis',
        '/tp\d{2}\-3g/i' => 'theq',
        '/ftj?\d{3}/i' => 'freetel',
        '/RUNE/' => 'bsmobile',
        '/IRON/' => 'umi',
        '/tlink|every35|primo[78]|qm73[45]\-8g/i' => 'thomson',
        '/mz\-| m\ds? |m\d{3}|m\d note|pro 5/i' => 'meizu',
        '/[sxz]\d{3}[ae]/i' => 'htc',
        '/(i\-style|iq) ?\d/i' => 'imobile',
        '/pt\-gf200/i' => 'pantech',
        '/k\-8s/i' => 'keener',
        '/h1\+/i' => 'hummer',
        '/impress_l/i' => 'vertex',
        '/neo\-x5/i' => 'minix',
        '/numy_note_9|novo7fire/i' => 'ainol',
        '/tab\-97e\-01/i' => 'reellex',
        '/vega/i' => 'advent',
        '/dream| x9 |amaze|butterfly2/i' => 'htc',
        '/ xst2 /i' => 'fourgsystems',
        '/tf300t/i' => 'asus',
        '/f10x/i' => 'nextway',
        '/adtab 7 lite/i' => 'adspec',
        '/neon\-n1|wing\-w2/i' => 'axgio',
        '/t118|t108/i' => 'twinovo',
        '/touareg8_3g/i' => 'accent',
        '/chagall/i' => 'pegatron',
        '/turbo x6/i' => 'turbopad',
        '/ l52 | g30 |pad g781/i' => 'haier',
        '/air a70/i' => 'roverpad',
        '/sp\-6020 quasar/i' => 'woo',
        '/q10s/i' => 'wopad',
        '/ctab785r16\-3g|pkt\-301/i' => 'condor',
        '/uq785\-m1bgv/i' => 'verico',
        '/t9666\-1/i' => 'telsda',
        '/h7100/i' => 'feiteng',
        '/xda|cocoon/i' => 'o2',
        '/kkt20|pixelv1|pixel v2\+| x17 |x1 atom|x1 selfie|x5 4g/i' => 'lava',
        '/pulse|mytouch4g|ameo|garminfone/i' => 'tmobile',
        '/g009/i' => 'yxtel',
        '/picopad_s1/i' => 'axioo',
        '/adi_5s/i' => 'artel',
        '/norma 2/i' => 'keneksi',
        '/t880g/i' => 'etuline',
        '/studio 5\.5|studio xl 2/i' => 'blu',
        '/f3_pro|y6_piano|y6 max| t6 /i' => 'doogee',
        '/tab\-970/i' => 'prology',
        '/a66a/i' => 'evercoss',
        '/n90fhdrk/i' => 'yuandao',
        '/nova/i' => 'catsound',
        '/i545/i' => 'samsung',
        '/discovery/i' => 'generalmobile',
        '/t720/i' => 'motorola',
        '/n820|a862w/i' => 'amoi',
        '/n90 dual core2/i' => 'yuandao',
        '/tpc\-/i' => 'jaytech',
        '/ g9 /i' => 'mastone',
        '/dl1|eluga_arc_2/i' => 'panasonic',
        '/zt180/i' => 'zenithink',
        '/e1107/i' => 'yusu',
        '/is05/i' => 'sharp',
        '/p4d sirius/i' => 'nvsbl',
        '/ c2 /i' => 'zopo',
        '/a0001/i' => 'oneplus',
        '/smartpad/i' => 'einsundeins',
        '/i4901/i' => 'idea',
        '/lead [12]|t1_plus|elite [45]|shark 1/i' => 'leagoo',
        '/forward|dynamic/i' => 'ngm',
        '/gnet/i' => 'gnet',
        '/hive v 3g|hive iv 3g/i' => 'turbo-x',
        '/turkcell/i' => 'turkcell',
        '/is04/i' => 'kddi',
        '/be pro|paris|vienna|u007|future|power_3/i' => 'ulefone',
        '/t1x plus|vandroid/i' => 'advan',
        '/sense golly/i' => 'ipro',
        '/sirius_qs/i' => 'vonino',
        '/dl 1803/i' => 'dl',
        '/s10q\-3g/i' => 'smartbook',
        '/ s30 /i' => 'firefly',
        '/apollo|thor/i' => 'vernee',
        '/1505\-a02|inote/i' => 'itel',
        '/mitab think|mismart wink/i' => 'wolder',
        '/pixel|glass 1/i' => 'google',
        '/909t| m13 /i' => 'mpie',
        '/z30/i' => 'magnus',
        '/up580/i' => 'uhappy',
        '/swift/i' => 'wileyfox',
        '/m9c max/i' => 'bqeel',
        '/qt\-10/i' => 'qmax',
        '/ilium l820/i' => 'lanix',
        '/s501m 3g|t700i_3g/i' => 'fourgood',
        '/ixion_es255|h135/i' => 'dexp',
        '/atl\-21/i' => 'artizlee',
        '/w032i\-c3|tr10rs1|tr10cd1/i' => 'intel',
        '/CS\d{2}/' => 'cyrus',
        '/ t02 /i' => 'changhong',
        '/crown| r6 | a8 |alife [ps]1|omega_pro/i' => 'blackview',
        '/london|hammer_s|z2 pro/i' => 'umi',
        '/vi8 plus|hibook|hi10 pro/i' => 'chuwi',
        '/jy\-/i' => 'jiayu',
        '/ m10 |edison 3/i' => 'bq',
        '/ m20 /i' => 'timmy',
        '/g708 oc/i' => 'colorfly',
        '/q880_xk/i' => 'tianji',
        '/c55/i' => 'ctroniq',
        '/l900/i' => 'landvo',
        '/ k5 /i' => 'komu',
        '/ x6 /i' => 'voto',
        '/VT\d{3}/' => 'voto',
        '/ m71 /i' => 'eplutus',
        '/ (d10|y14) /i' => 'xgody',
        '/tab1024/i' => 'intenso',
        '/ifive mini 4s/i' => 'fnf',
        '/ i10 | h150 /i' => 'symphony',
        '/ arc /i' => 'kobo',
        '/m92d\-3g/i' => 'sumvier',
        '/ f5 | h7 /i' => 'tecno',
        '/a88x/i' => 'alldaymall',
        '/bs1078/i' => 'yonestoptech',
        '/excellent8/i' => 'tomtec',
        '/ih\-g101/i' => 'innohit',
        '/g900/i' => 'ippo',
        '/nimbus 80qb/i' => 'woxter',
        '/gs55\-6|gs53\-6/i' => 'gigaset',
        '/vkb011b/i' => 'fengxiang',
        '/trooper|tornado|thunder/i' => 'kazam',
        '/end_101g\-test/i' => 'blaupunkt',
        '/ n3 /i' => 'goophone',
        '/king 7/i' => 'pptv',
        '/admire sxy|cinemax/i' => 'zen',
        '/1501_m02/i' => 'threesixty',
        '/d4c5|k9c6|c5j6/i' => 'teclast',
        '/t72/i' => 'oysters',
        '/ns\-14t004|ns\-p10a6100/i' => 'insignia',
        '/blaster 2/i' => 'justfive',
        '/picasso/i' => 'bluboo',
        '/strongphoneq4/i' => 'evolveo',
        '/shift[457]/i' => 'shift',
        '/k960/i' => 'jlinksz',
        '/i\-call|elektra l|neon[79]/i' => 'ijoy',
        '/ektra/i' => 'kodak',
        '/kt107/i' => 'bdf',
        '/m52_red_note/i' => 'mlais',
        '/sunmicrosystems/i' => 'sun',
        '/ a50/i' => 'micromax',
        '/max2_plus_3g/i' => 'innjoo',
        '/coolpix s800c/i' => 'nikon',
        '/vsd220/i' => 'viewsonic',
        '/primo[\- _]/i' => 'walton',
        '/x538/i' => 'sunsbell',
        '/i1\-3gd/i' => 'cube',
        '/sf1/i' => 'obi',
        '/harrier tab/i' => 'ee',
        '/excite prime/i' => 'cloudfone',
        '/ z1 /i' => 'ninetology',
        '/ Presto /' => 'oplus',
        '/crono/i' => 'majestic',
        '/NS\d{1,4}/' => 'nous',
        '/monster x5|quadra 7 ultraslim/i' => 'pentagram',
        '/F1\d/' => 'pulid',
        '/q\-smart|qtab/i' => 'qmobile',
        '/andromax|androtab|pd6d1j/i' => 'smartfren',
        '/ax5_duo/i' => 'maxx',
        '/ga10h/i' => 'gooweel',
        '/ypy_s450/i' => 'positivo',
        '/ph\-1/i' => 'essential',
        '/flare2x/i' => 'cherry-mobile',
        '/tc970/i' => 'lepan',
        '/mfc[0-9]{3}[a-z]{2,}/i' => 'lexibook',
        '/mypad (1000|750) ?hd/i' => 'yooz',
        '/MyPad|[Mm]yTab/' => 'myphone',
        '/vt75c/i' => 'videocon',
        '/rct\d{4}/i' => 'rca-tablets',
        '/(centurion|gladiator| glory|luxury|sensuelle|victory)([ _\-]?[2-6])?[);\/ ]|surfing tab/i' => 'brondi',
        '/momo(\d|mini)/i' => 'ployer',
        '/ezee/i' => 'storex',
        '/cyclone voyager/i' => 'sumvision',
        '/I5/' => 'sop',
        '/i5/' => 'vsun',
        '/KIN\.(One|Two)|ZuneHD|Windows NT 6\.(2|3).*ARM;/' => 'microsoft',
    ];

    /**
     * @var \BrowserDetector\Loader\DeviceLoaderFactory
     */
    private $loaderFactory;

    /**
     * @param \BrowserDetector\Cache\CacheInterface $cache
     * @param \Psr\Log\LoggerInterface              $logger
     */
    public function __construct(CacheInterface $cache, LoggerInterface $logger)
    {
        $this->loaderFactory = new DeviceLoaderFactory($cache, $logger);
    }

    /**
     * detects the device name from the given user agent
     *
     * @param string $useragent
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \BrowserDetector\Loader\NotFoundException
     *
     * @return array
     */
    public function __invoke(string $useragent): array
    {
        $loaderFactory = $this->loaderFactory;

        foreach ($this->factories as $rule => $company) {
            try {
                if (preg_match($rule, $useragent)) {
                    $loader = $loaderFactory($company, 'mobile');

                    return $loader($useragent);
                }
            } catch (\Throwable $e) {
                throw new \InvalidArgumentException(sprintf('An error occured while matching rule "%s"', $rule), 0, $e);
            }
        }

        $loader = $loaderFactory('unknown', 'mobile');

        return $loader($useragent);
    }
}
