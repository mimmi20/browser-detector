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

use BrowserDetector\Factory;
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

class MobileFactory implements Factory\FactoryInterface
{
    /**
     * @var \BrowserDetector\Loader\ExtendedLoaderInterface
     */
    private $loader;

    /**
     * @param \BrowserDetector\Loader\ExtendedLoaderInterface $loader
     */
    public function __construct(ExtendedLoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    /**
     * detects the device name from the given user agent
     *
     * @param string           $useragent
     * @param \Stringy\Stringy $s
     *
     * @return array
     */
    public function detect(string $useragent, Stringy $s): array
    {
        $factoriesBeforeXianghe = [
            '/hiphone/i'                                => Mobile\HiPhoneFactory::class,
            '/v919 3g air/i'                            => Mobile\OndaFactory::class,
            '/technisat|technipad|aqipad|techniphone/i' => Mobile\TechnisatFactory::class,
            '/navipad/i'                                => Mobile\TexetFactory::class,
            '/medipad/i'                                => Mobile\BewatecFactory::class,
            '/mipad/i'                                  => Mobile\XiaomiFactory::class,
            '/nokia/i'                                  => Mobile\NokiaFactory::class,
        ];

        foreach ($factoriesBeforeXianghe as $rule => $factoryName) {
            if (preg_match($rule, $useragent)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if ($s->containsAll(['iphone', 'android'], false)
            && !$s->containsAny(['windows phone', 'iphone; cpu iphone os'], false)
        ) {
            return (new Mobile\XiangheFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAll(['iphone', 'adr', 'ucweb'], false)) {
            return (new Mobile\XiangheFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ipad|ipod|iphone|like mac os x|darwin|cfnetwork/i', $useragent)
            && !preg_match('/windows phone| adr |ipodder|tripadvisor/i', $useragent)
        ) {
            return (new Mobile\AppleFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('htc', false) && !$s->contains('wohtc', false)) {
            return (new Mobile\HtcFactory($this->loader))->detect($useragent, $s);
        }

        $factoriesBeforeNec = [
            '/samsung/i'                                                  => Mobile\SamsungFactory::class,
            '/blackberry/i'                                               => Mobile\BlackBerryFactory::class,
            '/asus/i'                                                     => Mobile\AsusFactory::class,
            '/mt\-gt\-a9500|gt\-a7100/i'                                  => Mobile\HtmFactory::class,
            '/feiteng|gt\-h/i'                                            => Mobile\FeitengFactory::class,
            '/cube|u30gt|u51gt|u55gt|i15\-tcl|u25gt\-c4w/i'               => Mobile\CubeFactory::class,
            '/gtx75/i'                                                    => Mobile\UtStarcomFactory::class,
            '/gt\-9000/i'                                                 => Mobile\StarFactory::class,
            '/LG/'                                                        => Mobile\LgFactory::class,
            '/(gt|sam|sc|sch|sec|sgh|shv|shw|sm|sph|continuum|ek|yp)\-/i' => Mobile\SamsungFactory::class,
            '/hdc|galaxy s3 ex/i'                                         => Mobile\HdcFactory::class,
            '/nexus ?[45]/i'                                              => Mobile\LgFactory::class,
            '/nexus[ _]?7/i'                                              => Mobile\AsusFactory::class,
            '/nexus 6p/i'                                                 => Mobile\HuaweiFactory::class,
            '/nexus 6/i'                                                  => Mobile\MotorolaFactory::class,
            '/nexus ?(?:one|9|evohd2|hd2)/i'                              => Mobile\HtcFactory::class,
            '/pantech/i'                                                  => Mobile\PantechFactory::class,
            '/hp|p160u|touchpad|pixi|palm|cm_tenderloin|slate/i'          => Mobile\HpFactory::class,
            '/galaxy|nexus|i(?:7110|9100|9300)|blaze|s8500/i'             => Mobile\SamsungFactory::class,
            '/sony/i'                                                     => Mobile\SonyFactory::class,
            '/accent/i'                                                   => Mobile\AccentFactory::class,
            '/smart ?(?:tab(?:10|7)|4g|ultra 6)/i'                        => Mobile\ZteFactory::class,
            '/lenovo|idea(?:tab|pad)|smarttab|thinkpad/i'                 => Mobile\LenovoFactory::class,
            '/startrail4/i'                                               => Mobile\SfrFactory::class,
            '/zte|racer/i'                                                => Mobile\ZteFactory::class,
            '/acer|iconia|liquid/i'                                       => Mobile\AcerFactory::class,
            '/playstation/i'                                              => Mobile\SonyFactory::class,
            // @todo: amazon
            '/amazon|kindle|silk|kf(?:tt|ot|jwi|sowi|thwi|apwa|aswi|apwi|dowi|auwi|giwi|tbwi|mewi|fowi|sawi|sawa|arwi|thwa|jwa)|sd4930ur|fire2/i' => Mobile\AmazonFactory::class,
            // @todo: others
            '/amoi/i'                                         => Mobile\AmoiFactory::class,
            '/blaupunkt|endeavour/i'                          => Mobile\BlaupunktFactory::class,
            '/dataaccessd/i'                                  => Mobile\AppleFactory::class,
            '/cce/i'                                          => Mobile\CceFactory::class,
            '/onda/i'                                         => Mobile\OndaFactory::class,
            '/archos/i'                                       => Mobile\ArchosFactory::class,
            '/irulu/i'                                        => Mobile\IruluFactory::class,
            '/symphony/i'                                     => Mobile\SymphonyFactory::class,
            '/spice/i'                                        => Mobile\SpiceFactory::class,
            '/arnova/i'                                       => Mobile\ArnovaFactory::class,
            '/ bn |bntv600/i'                                 => Mobile\BarnesNobleFactory::class,
            '/playbook|rim tablet|bb10|stv100|bb[ab]100\-2/i' => Mobile\BlackBerryFactory::class,
            '/b15/i'                                          => Mobile\CaterpillarFactory::class,
            '/cat ?(?:nova|stargate|tablet|helix)/i'          => Mobile\CatSoundFactory::class,
            '/coby|nbpc724/i'                                 => Mobile\CobyFactory::class,
            '/o\+|oplus/i'                                    => Mobile\OplusFactory::class,
            '/goly/i'                                         => Mobile\GolyFactory::class,
            '/MID\d{4}/'                                      => Mobile\CobyFactory::class,
            '/WM\d{4}/'                                       => Mobile\WonderMediaFactory::class,
            '/comag|wtdr1018/i'                               => Mobile\ComagFactory::class,
            '/coolpad/i'                                      => Mobile\CoolpadFactory::class,
            '/cosmote/i'                                      => Mobile\CosmoteFactory::class,
            '/creative|ziilabs|ziio7/i'                       => Mobile\CreativeFactory::class,
            '/cubot/i'                                        => Mobile\CubotFactory::class,
            '/dell/i'                                         => Mobile\DellFactory::class,
            '/denver|ta[dq]\-/i'                              => Mobile\DenverFactory::class,
            '/connect(?:7pro|8plus)/i'                        => Mobile\OdysFactory::class,
            '/sharp/i'                                        => Mobile\SharpFactory::class,
        ];

        foreach ($factoriesBeforeNec as $rule => $factoryName) {
            if (preg_match($rule, $useragent)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if ($s->contains('nec', false) && !$s->contains('fennec', false)) {
            return (new Mobile\NecFactory($this->loader))->detect($useragent, $s);
        }

        $factoriesBeforeThl = [
            '/\d{3}SH/'                      => Mobile\SharpFactory::class,
            '/SH\-?\d{2,4}(C|D|F|U)/'        => Mobile\SharpFactory::class,
            '/m\-(m|p)p/i'                   => Mobile\MediacomFactory::class,
            '/n\-06e|n[79]05i/i'             => Mobile\NecFactory::class,
            '/docomo|p900i/i'                => Mobile\DoCoMoFactory::class,
            '/easy(?:pix|pad)|junior 4\.0/i' => Mobile\EasypixFactory::class,
            '/smart\-e5/i'                   => Mobile\EfoxFactory::class,
            '/xoro|telepad/i'                => Mobile\XoroFactory::class,
            '/memup|slidepad/i'              => Mobile\MemupFactory::class,
            '/epad|p7901a/i'                 => Mobile\ZenithinkFactory::class,
            '/p7mini/i'                      => Mobile\HuaweiFactory::class,
            '/flytouch/i'                    => Mobile\FlytouchFactory::class,
            '/fujitsu|m532|m305/i'           => Mobile\FujitsuFactory::class,
            '/sn10t1|hsg\d{4}/i'             => Mobile\HannspreeFactory::class,
            '/DA241HL/'                      => Mobile\AcerFactory::class,
            '/SHL25/'                        => Mobile\SharpFactory::class,
        ];

        foreach ($factoriesBeforeThl as $rule => $factoryName) {
            if (preg_match($rule, $useragent)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if ($s->contains('thl', false) && !$s->contains('liauthlibrary', false)) {
            return (new Mobile\ThlFactory($this->loader))->detect($useragent, $s);
        }

        $factoriesBeforeFly = [
            // @todo: rules with company name in UA
            '/honlin/i'       => Mobile\HonlinFactory::class,
            '/huawei/i'       => Mobile\HuaweiFactory::class,
            '/micromax/i'     => Mobile\MicromaxFactory::class,
            '/explay/i'       => Mobile\ExplayFactory::class,
            '/oneplus/i'      => Mobile\OneplusFactory::class,
            '/kingzone/i'     => Mobile\KingzoneFactory::class,
            '/goophone/i'     => Mobile\GooPhoneFactory::class,
            '/g\-tide/i'      => Mobile\GtideFactory::class,
            '/turbo ?pad/i'   => Mobile\TurboPadFactory::class,
            '/haier/i'        => Mobile\HaierFactory::class,
            '/hummer/i'       => Mobile\HummerFactory::class,
            '/oysters/i'      => Mobile\OystersFactory::class,
            '/gfive/i'        => Mobile\GfiveFactory::class,
            '/iconbit/i'      => Mobile\IconBitFactory::class,
            '/sxz/i'          => Mobile\SxzFactory::class,
            '/aoc/i'          => Mobile\AocFactory::class,
            '/jay\-tech/i'    => Mobile\JaytechFactory::class,
            '/jolla/i'        => Mobile\JollaFactory::class,
            '/kazam/i'        => Mobile\KazamFactory::class,
            '/kddi/i'         => Mobile\KddiFactory::class,
            '/kobo/i'         => Mobile\KoboFactory::class,
            '/lenco/i'        => Mobile\LencoFactory::class,
            '/lepan/i'        => Mobile\LePanFactory::class,
            '/logicpd/i'      => Mobile\LogicpdFactory::class,
            '/medion/i'       => Mobile\MedionFactory::class,
            '/meizu/i'        => Mobile\MeizuFactory::class,
            '/hisense/i'      => Mobile\HisenseFactory::class,
            '/minix/i'        => Mobile\MinixFactory::class,
            '/allwinner/i'    => Mobile\AllWinnerFactory::class,
            '/supra/i'        => Mobile\SupraFactory::class,
            '/prestigio/i'    => Mobile\PrestigioFactory::class,
            '/mobistel/i'     => Mobile\MobistelFactory::class,
            '/moto/i'         => Mobile\MotorolaFactory::class,
            '/nintendo/i'     => Mobile\NintendoFactory::class,
            '/odys/i'         => Mobile\OdysFactory::class,
            '/oppo/i'         => Mobile\OppoFactory::class,
            '/panasonic/i'    => Mobile\PanasonicFactory::class,
            '/pandigital/i'   => Mobile\PandigitalFactory::class,
            '/phicomm/i'      => Mobile\PhicommFactory::class,
            '/pomp/i'         => Mobile\PompFactory::class,
            '/qmobile/i'      => Mobile\QmobileFactory::class,
            '/sanyo/i'        => Mobile\SanyoFactory::class,
            '/siemens/i'      => Mobile\SiemensFactory::class,
            '/benq/i'         => Mobile\SiemensFactory::class,
            '/sagem/i'        => Mobile\SagemFactory::class,
            '/ouya/i'         => Mobile\OuyaFactory::class,
            '/trevi/i'        => Mobile\TreviFactory::class,
            '/cowon/i'        => Mobile\CowonFactory::class,
            '/homtom/i'       => Mobile\HomtomFactory::class,
            '/hosin/i'        => Mobile\HosinFactory::class,
            '/hasee/i'        => Mobile\HaseeFactory::class,
            '/tecno/i'        => Mobile\TecnoFactory::class,
            '/intex/i'        => Mobile\IntexFactory::class,
            '/sprint/i'       => Mobile\SprintFactory::class,
            '/gionee/i'       => Mobile\GioneeFactory::class,
            '/videocon/i'     => Mobile\VideoconFactory::class,
            '/gigaset/i'      => Mobile\GigasetFactory::class,
            '/dns/i'          => Mobile\DnsFactory::class,
            '/kyocera/i'      => Mobile\KyoceraFactory::class,
            '/texet/i'        => Mobile\TexetFactory::class,
            '/s\-tell/i'      => Mobile\StellFactory::class,
            '/bliss/i'        => Mobile\BlissFactory::class,
            '/alcatel/i'      => Mobile\AlcatelFactory::class,
            '/tolino/i'       => Mobile\TolinoFactory::class,
            '/toshiba/i'      => Mobile\ToshibaFactory::class,
            '/trekstor/i'     => Mobile\TrekStorFactory::class,
            '/viewsonic/i'    => Mobile\ViewSonicFactory::class,
            '/viewpad/i'      => Mobile\ViewSonicFactory::class,
            '/wiko/i'         => Mobile\WikoFactory::class,
            '/vivo iv/i'      => Mobile\BluFactory::class,
            '/vivo/i'         => Mobile\VivoFactory::class,
            '/haipai/i'       => Mobile\HaipaiFactory::class,
            '/megafon/i'      => Mobile\MegaFonFactory::class,
            '/yuanda/i'       => Mobile\YuandaFactory::class,
            '/pocketbook/i'   => Mobile\PocketBookFactory::class,
            '/goclever/i'     => Mobile\GoCleverFactory::class,
            '/senseit/i'      => Mobile\SenseitFactory::class,
            '/twz/i'          => Mobile\TwzFactory::class,
            '/i\-mobile/i'    => Mobile\ImobileFactory::class,
            '/evercoss/i'     => Mobile\EvercossFactory::class,
            '/dino/i'         => Mobile\DinoFactory::class,
            '/shaan/i'        => Mobile\ShaanFactory::class,
            '/iball/i'        => Mobile\ShaanFactory::class,
            '/modecom/i'      => Mobile\ModecomFactory::class,
            '/kiano/i'        => Mobile\KianoFactory::class,
            '/philips/i'      => Mobile\PhilipsFactory::class,
            '/infinix/i'      => Mobile\InfinixFactory::class,
            '/infocus/i'      => Mobile\InfocusFactory::class,
            '/karbonn/i'      => Mobile\KarbonnFactory::class,
            '/pentagram/i'    => Mobile\PentagramFactory::class,
            '/smartfren/i'    => Mobile\SmartfrenFactory::class,
            '/ngm/i'          => Mobile\NgmFactory::class,
            '/orange hi 4g/i' => Mobile\ZteFactory::class,
            '/orange reyo/i'  => Mobile\ZteFactory::class,
            '/orange/i'       => Mobile\OrangeFactory::class,
            '/spv/i'          => Mobile\OrangeFactory::class,
            '/t\-mobile/i'    => Mobile\TmobileFactory::class,
            '/mot/i'          => Mobile\MotorolaFactory::class,
            '/hs\-/i'         => Mobile\HisenseFactory::class,
            '/beeline pro/i'  => Mobile\ZteFactory::class,
            '/beeline/i'      => Mobile\BeelineFactory::class,
            '/digma/i'        => Mobile\DigmaFactory::class,
            '/axgio/i'        => Mobile\AxgioFactory::class,
            '/zopo/i'         => Mobile\ZopoFactory::class,
            '/malata/i'       => Mobile\MalataFactory::class,
            '/starway/i'      => Mobile\StarwayFactory::class,
            '/starmobile/i'   => Mobile\StarmobileFactory::class,
            '/logicom/i'      => Mobile\LogicomFactory::class,
            '/gigabyte/i'     => Mobile\GigabyteFactory::class,
            '/qumo/i'         => Mobile\QumoFactory::class,
            '/celkon/i'       => Mobile\CelkonFactory::class,
            '/bravis/i'       => Mobile\BravisFactory::class,
            '/fnac/i'         => Mobile\FnacFactory::class,
            '/tcl/i'          => Mobile\TclFactory::class,
            '/radxa/i'        => Mobile\RadxaFactory::class,
            '/xolo/i'         => Mobile\XoloFactory::class,
            '/dragon touch/i' => Mobile\DragonTouchFactory::class,
            '/ramos/i'        => Mobile\RamosFactory::class,
            '/woxter/i'       => Mobile\WoxterFactory::class,
            '/k\-?touch/i'    => Mobile\KtouchFactory::class,
            '/mastone/i'      => Mobile\MastoneFactory::class,
            '/nuqleo/i'       => Mobile\NuqleoFactory::class,
            '/wexler/i'       => Mobile\WexlerFactory::class,
            '/exeq/i'         => Mobile\ExeqFactory::class,
            '/4good/i'        => Mobile\FourGoodFactory::class,
            '/utstar/i'       => Mobile\UtStarcomFactory::class,
            '/walton/i'       => Mobile\WaltonFactory::class,
            '/quadro/i'       => Mobile\QuadroFactory::class,
            '/xiaomi/i'       => Mobile\XiaomiFactory::class,
            '/pipo/i'         => Mobile\PipoFactory::class,
            '/tesla/i'        => Mobile\TeslaFactory::class,
            '/doro/i'         => Mobile\DoroFactory::class,
            '/captiva/i'      => Mobile\CaptivaFactory::class,
            '/elephone/i'     => Mobile\ElephoneFactory::class,
            '/cyrus/i'        => Mobile\CyrusFactory::class,
            '/wopad/i'        => Mobile\WopadFactory::class,
            '/anka/i'         => Mobile\AnkaFactory::class,
            '/lemon/i'        => Mobile\LemonFactory::class,
            '/lava/i'         => Mobile\LavaFactory::class,
            '/sop\-/i'        => Mobile\SopFactory::class,
            '/vsun/i'         => Mobile\VsunFactory::class,
            '/advan/i'        => Mobile\AdvanFactory::class,
            '/velocity/i'     => Mobile\VelocityMicroFactory::class,
            '/allview/i'      => Mobile\AllviewFactory::class,
            '/myphone/i'      => Mobile\MyphoneFactory::class,
            '/turbo\-x/i'     => Mobile\TurboxFactory::class,
            '/tagi/i'         => Mobile\TagiFactory::class,
            '/avvio/i'        => Mobile\AvvioFactory::class,
            '/e\-boda/i'      => Mobile\EbodaFactory::class,
            '/ergo/i'         => Mobile\ErgoFactory::class,
            '/pulid/i'        => Mobile\PulidFactory::class,
            '/dexp/i'         => Mobile\DexpFactory::class,
            '/keneksi/i'      => Mobile\KeneksiFactory::class,
            '/reeder/i'       => Mobile\ReederFactory::class,
            '/globex/i'       => Mobile\GlobexFactory::class,
            '/oukitel/i'      => Mobile\OukitelFactory::class,
            '/itel/i'         => Mobile\ItelFactory::class,
            '/wileyfox/i'     => Mobile\WileyfoxFactory::class,
            '/morefine/i'     => Mobile\MorefineFactory::class,
            '/vernee/i'       => Mobile\VerneeFactory::class,
            '/iocean/i'       => Mobile\IoceanFactory::class,
            '/intki/i'        => Mobile\IntkiFactory::class,
            '/i\-joy/i'       => Mobile\IjoyFactory::class,
            '/inq/i'          => Mobile\InqFactory::class,
            '/inew/i'         => Mobile\InewFactory::class,
            '/iberry/i'       => Mobile\IberryFactory::class,
            '/koobee/i'       => Mobile\KoobeeFactory::class,
            '/kingsun/i'      => Mobile\KingsunFactory::class,
            '/komu/i'         => Mobile\KomuFactory::class,
            '/kopo/i'         => Mobile\KopoFactory::class,
            '/koridy/i'       => Mobile\KoridyFactory::class,
            '/kumai/i'        => Mobile\KumaiFactory::class,
            '/konrow/i'       => Mobile\KonrowFactory::class,
            '/BLU/'           => Mobile\BluFactory::class,
            '/MTC/'           => Mobile\MtcFactory::class,
            '/eSTAR/'         => Mobile\EstarFactory::class,
            // @todo: general rules
            '/PC1088|HL/'                                                               => Mobile\HonlinFactory::class,
            '/INM\d{3,4}/'                                                              => Mobile\IntensoFactory::class,
            '/sailfish/i'                                                               => Mobile\JollaFactory::class,
            '/zoom2|nook ?color/i'                                                      => Mobile\LogicpdFactory::class,
            '/lifetab/i'                                                                => Mobile\MedionFactory::class,
            '/cynus/i'                                                                  => Mobile\MobistelFactory::class,
            '/DARK(?:MOON|SIDE|NIGHT)/'                                                 => Mobile\WikoFactory::class,
            '/ARK/'                                                                     => Mobile\ArkFactory::class,
            '/Magic/'                                                                   => Mobile\MagicFactory::class,
            '/XT811/'                                                                   => Mobile\FlipkartFactory::class,
            '/XT\d{3,4}/'                                                               => Mobile\MotorolaFactory::class,
            '/M[Ii][ -](?:\d|PAD|MAX|NOTE|A1)/'                                         => Mobile\XiaomiFactory::class,
            '/HM[ _](?:NOTE|1SC|1SW|1S)/'                                               => Mobile\XiaomiFactory::class,
            '/WeTab/'                                                                   => Mobile\NeofonieFactory::class,
            '/SIE\-/'                                                                   => Mobile\SiemensFactory::class,
            '/CAL21/'                                                                   => Mobile\CasioFactory::class,
            '/g3mini/i'                                                                 => Mobile\LgFactory::class,
            '/P[CG]\d{5}/'                                                              => Mobile\HtcFactory::class,
            '/[AC]\d{5}/'                                                               => Mobile\NomiFactory::class,
            '/one e\d{4}/i'                                                             => Mobile\OneplusFactory::class,
            '/one a200[135]/i'                                                          => Mobile\OneplusFactory::class,
            '/HS\-/'                                                                    => Mobile\HisenseFactory::class,
            '/f5281|u972|e621t|eg680|e2281uk/i'                                         => Mobile\HisenseFactory::class,
            '/TBD\d{4}|TBD[BCG]\d{3,4}/'                                                => Mobile\ZekiFactory::class,
            '/AC0732C|RC9724C|MT0739D|QS0716D|LC0720C|MT0812E/'                         => Mobile\TriQFactory::class,
            '/ImPAD6213M_v2/'                                                           => Mobile\ImpressionFactory::class,
            '/S4503Q/'                                                                  => Mobile\DnsFactory::class,
            '/D6000/'                                                                   => Mobile\InnosFactory::class,
            '/[SV]T\d{5}/'                                                              => Mobile\TrekStorFactory::class,
            '/e6560|c6750|c6742|c6730|c6522n|c5215|c5170|c5155|c5120|dm015k|kc\-s701/i' => Mobile\KyoceraFactory::class,
            '/p4501|p850x|e4004|e691x|p1050x|p1032x|p1040x|s1035x|p1035x|p4502|p851x/i' => Mobile\MedionFactory::class,
            '/g6600/i'                                                                  => Mobile\HuaweiFactory::class,
            '/DG\d{3,4}/'                                                               => Mobile\DoogeeFactory::class,
            '/Touchlet|X7G|X10\./'                                                      => Mobile\PearlFactory::class,
            '/mpqc\d{3,4}/i'                                                            => Mobile\MpmanFactory::class,
            '/terra pad|pad1002/i'                                                      => Mobile\WortmannFactory::class,
            '/[CDEFG]\d{4}/'                                                            => Mobile\SonyFactory::class,
            '/PM\-\d{4}/'                                                               => Mobile\SanyoFactory::class,
            '/folio_and_a|toshiba_ac_and_az|folio100/i'                                 => Mobile\ToshibaFactory::class,
            '/(aqua|cloud)[_ \.]/i'                                                     => Mobile\IntexFactory::class,
            '/3Q/'                                                                      => Mobile\TriQFactory::class,
            '/UMI/'                                                                     => Mobile\UmiFactory::class,
        ];

        foreach ($factoriesBeforeFly as $rule => $factoryName) {
            if (preg_match($rule, $useragent)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if (preg_match('/F[Ll][Yy]/', $useragent) && !preg_match('/FlyFlow/', $useragent)) {
            return (new Mobile\FlyFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/bmobile/i', $useragent) && !preg_match('/icabmobile/i', $useragent)) {
            return (new Mobile\BmobileFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('NTT', true)) {
            return (new Mobile\NttSystemFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['Z221', 'V788D', 'KIS PLUS', 'N918St', 'ATLAS_W', 'BASE Tab', 'X920', ' V9 ', 'ATLAS W', 'OPENC', 'OPEN2', 'A310'], true)) {
            return (new Mobile\ZteFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['lutea', 'bs 451', 'n9132', 'grand s flex', 'e8q+', 's8q', 's7q'], false)) {
            return (new Mobile\ZteFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/NX\d{3}/', $useragent)) {
            return (new Mobile\ZteFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ultrafone', false)) {
            return (new Mobile\ZenFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' mt791 ', false)) {
            return (new Mobile\KeenHighFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['g100w', 'stream-s110'], false)) {
            return (new Mobile\AcerFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ (a1|a3|b1|b3)\-/i', $useragent)) {
            return (new Mobile\AcerFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['wildfire', 'desire'], false)) {
            return (new Mobile\HtcFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['a101it', 'a7eb', 'a70bht', 'a70cht', 'a70hb', 'a70s', 'a80ksc', 'a35dm', 'a70h2', 'a50ti'], false)) {
            return (new Mobile\ArchosFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['sprd', 'b51+'], false)) {
            return (new Mobile\SprdFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('sphs_on_hsdroid', false)) {
            return (new Mobile\MhorseFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('TAB A742', true)) {
            return (new Mobile\WexlerFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('VS810PP', true)) {
            return (new Mobile\LgFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['vox s502 3g'], false)) {
            return (new Mobile\DigmaFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(cs|vs|ps|tt|pt|lt|ct|ts|ns|ht)\d{3,4}[aempqs]/i', $useragent)) {
            return (new Mobile\DigmaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('A400', true)) {
            return (new Mobile\CelkonFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('A5000', true)) {
            return (new Mobile\SonyFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['A101', 'A500', 'Z200', 'Z500', ' T09 ', ' T08 ', ' T07 ', ' T06 ', ' T04 ', ' T03 ', ' S55 ', 'DA220HQL'], true)) {
            return (new Mobile\AcerFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['A1002', 'A811', 'S5A4'], true)) {
            return (new Mobile\LexandFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['A120', 'A116', 'A114', 'A093', 'A065', ' A96 ', 'Q327', ' A47'], true)) {
            return (new Mobile\MicromaxFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['smart tab 4g'], false)) {
            return (new Mobile\LenovoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['smart tab 4', 'vfd 600', '985n'], false)) {
            return (new Mobile\VodafoneFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['smarttab', 'smart tab', 's6000d'], false)) {
            return (new Mobile\LenovoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['S208', 'S550', 'S600', 'Z100 Pro', 'S308', 'NOTE Plus'], true)) {
            return (new Mobile\CubotFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['a1000s', 'q1010i', 'q600s'], false)) {
            return (new Mobile\XoloFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('s750', false)) {
            return (new Mobile\BeneveFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('blade', false)) {
            return (new Mobile\ZteFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' z110', false)) {
            return (new Mobile\XidoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['titanium', 'machfive', 'sparkle v'], false)) {
            return (new Mobile\KarbonnFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('a727', false)) {
            return (new Mobile\AzpenFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(ags|ale|ath|bah|bl[an]|bnd|cam|ch[cm]|che[12]?|duk|fig|frd|gra|h[36]0|kiw|lon|m[hy]a|nem|plk|pra|rne|scl|vky|vtr|was|y220)\-/i', $useragent)) {
            return (new Mobile\HuaweiFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/V1\d{2}/', $useragent)) {
            return (new Mobile\GioneeFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ [aevzs]\d{3} /i', $useragent)) {
            return (new Mobile\AcerFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('AT-AS40SE', true)) {
            return (new Mobile\WolgangFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('AT1010-T', true)) {
            return (new Mobile\LenovoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('vk-', false)) {
            return (new Mobile\VkMobileFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['FP1', 'FP2'], true)) {
            return (new Mobile\FairphoneFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/le ?x\d{3}/i', $useragent)) {
            return (new Mobile\LeecoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['le 1 pro', 'le max'], false)) {
            return (new Mobile\LeecoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['loox', 'uno_x10', 'xelio', 'neo_quad10', 'ieos_quad', 'sky plus', 'maven_10_plus', 'space10_plus', 'adm816', 'noon', 'xpress', 'genesis', 'tablet-pc-4', 'kinder-tablet', 'evolution12', 'mira', 'score_plus', 'pro q8 plus', 'rapid7lte', 'neo6_lte', 'rapid_10'], false)) {
            return (new Mobile\OdysFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['CINK PEAX 2', 'JERRY', 'BLOOM', 'SLIDE', 'LENNY', 'GETAWAY', 'WAX', 'KITE', 'BARRY', 'HIGHWAY', 'OZZY', 'RIDGE', 'PULP', 'SUNNY', 'FEVER', 'PLUS', 'SUNSET', 'FIZZ', 'U FEEL', 'CINK SLIM', 'ROBBY'], true)) {
            return (new Mobile\WikoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['l5510', 'rainbow'], false)) {
            return (new Mobile\WikoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('BQS', true)) {
            return (new Mobile\BqFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/BQ \d{4}/', $useragent)) {
            return (new Mobile\BqFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('aquaris', false)) {
            return (new Mobile\BqFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('myTAB', true)) {
            return (new Mobile\MytabFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/iPh\d\,\d/', $useragent)) {
            return (new Mobile\AppleFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/Puffin\/[\d\.]+I[TP]/', $useragent)) {
            return (new Mobile\AppleFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/iuc ?\(/i', $useragent)) {
            return (new Mobile\AppleFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/Pre/', $useragent) && !preg_match('/Presto/', $useragent)) {
            return (new Mobile\HpFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ME\d{3}[A-Z]/', $useragent)) {
            return (new Mobile\AsusFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['padfone', 'transformer', 'slider sl101', 'eee_701', 'tpad_10', 'tx201la'], false)) {
            return (new Mobile\AsusFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/[KP]0[0-2][0-9a-zA-Z]/', $useragent)) {
            return (new Mobile\AsusFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('QtCarBrowser', true)) {
            return (new Mobile\TeslaMotorsFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/m[bez]\d{3}/i', $useragent)) {
            return (new Mobile\MotorolaFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/WX\d{3}/', $useragent)) {
            return (new Mobile\MotorolaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('mtech', false)) {
            return (new Mobile\MtechFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['vodafone smart 4 max', 'smart 4 turbo'], false)) {
            return (new Mobile\VodafoneFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['onetouch', 'one_touch', 'one touch', 'v860', 'vodafone smart', 'vodafone 975n', 'vodafone 875', 'vodafone 785', 'vf-795', 'vf-895n', 'm812c', 'telekom puls'], false)) {
            return (new Mobile\AlcatelFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('xperia', false)) {
            return (new Mobile\SonyFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny([' droid', 'milestone', 'xoom', 'razr hd', ' z '], false)) {
            return (new Mobile\MotorolaFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/SGP\d{3}|X[ML]\d{2}[th]/', $useragent)) {
            return (new Mobile\SonyFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/sgpt\d{2}/i', $useragent)) {
            return (new Mobile\SonyFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(YU|AO)\d{4}/', $useragent)) {
            return (new Mobile\YuFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/u\d{4}/i', $useragent)) {
            return (new Mobile\HuaweiFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['ideos', 'vodafone 858', 'vodafone 845', 'ascend', 'm860', ' p6 ', 'hi6210sft', 'honor'], false)) {
            return (new Mobile\HuaweiFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/P(GN|KT)\-?\d{3}/', $useragent)) {
            return (new Mobile\CondorFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/GN\d{3}/', $useragent)) {
            return (new Mobile\GioneeFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('vodafone 890n', false)) {
            return (new Mobile\YulongFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['a315c', 'vpa'], false)) {
            return (new Mobile\HtcFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/one [sx]/i', $useragent)) {
            return (new Mobile\HtcFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/OP\d{3}/', $useragent)) {
            return (new Mobile\OlivettiFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/VS\d{3}/', $useragent)) {
            return (new Mobile\LgFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['surftab', 'vt10416', 'breeze 10.1 quad', 'xintroni10.1', 'st70408_4'], false)) {
            return (new Mobile\TrekStorFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/AT\d{2,3}/', $useragent)) {
            return (new Mobile\ToshibaFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/P[AS]P|PM[PT]/', $useragent)) {
            return (new Mobile\PrestigioFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/E[vV][oO] ?3D/', $useragent)) {
            return (new Mobile\HtcFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['PJ83100', '831C', 'Eris 2.1', '0PCV1', 'MDA', '0PJA10'], true)) {
            return (new Mobile\HtcFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/adr\d{4}/i', $useragent)) {
            return (new Mobile\HtcFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['NEXT', 'DATAM803HC'], true)) {
            return (new Mobile\NextbookFactory($this->loader))->detect($useragent, $s);
        }

        $factoriesBeforeGeneralMobile = [
            'mt6515m-a1+' => Mobile\UnitedFactory::class,
            ' c7 '        => Mobile\CubotFactory::class,
            ' h1 '        => Mobile\CubotFactory::class,
            ' cheetah '   => Mobile\CubotFactory::class,
            ' x12 '       => Mobile\CubotFactory::class,
            ' x16 '       => Mobile\CubotFactory::class,
            ' x17_s '     => Mobile\CubotFactory::class,
            'mt10b'       => Mobile\ExcelvanFactory::class,
            'mt10'        => Mobile\MtnFactory::class,
            'm1009'       => Mobile\ExcelvanFactory::class,
            'mt13'        => Mobile\ExcelvanFactory::class,
            'kp-703'      => Mobile\ExcelvanFactory::class,
        ];

        foreach ($factoriesBeforeGeneralMobile as $test => $factoryName) {
            if ($s->contains($test, false)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if ($s->containsAny(['MT6582/', 'mn84l_8039_20203'], true)) {
            return $this->loader->load('general mobile device', $useragent);
        }

        $factoriesBeforeSony = [
            'mt6515m-a1+' => Mobile\UnitedFactory::class,
            'l50u'        => Mobile\SonyFactory::class,
            'nook'        => Mobile\BarnesNobleFactory::class,
            'iq1055'      => Mobile\MlsFactory::class,
        ];

        foreach ($factoriesBeforeSony as $test => $factoryName) {
            if ($s->contains($test, false)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if (preg_match('/[SLWM]T\d{2}|[SM]K\d{2}|SO\-\d{2}[BCDEG]/', $useragent)) {
            return (new Mobile\SonyFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/l\d{2}u/i', $useragent)) {
            return (new Mobile\SonyFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(IQ|FS)\d{3,4}/', $useragent)) {
            return (new Mobile\FlyFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/TQ\d{3}/', $useragent)) {
            return (new Mobile\GoCleverFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/RMD\-\d{3,4}/', $useragent)) {
            return (new Mobile\RitmixFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/AX\d{3}/', $useragent)) {
            return (new Mobile\BmobileFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/FreeTAB \d{4}/', $useragent)) {
            return (new Mobile\ModecomFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['OV-', 'Solution 7III'], true)) {
            return (new Mobile\OvermaxFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/MID\d{3}/', $useragent)) {
            return (new Mobile\MantaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('FX2', true)) {
            return (new Mobile\FaktorZweiFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/AN\d{1,2}/', $useragent)) {
            return (new Mobile\ArnovaFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ARCHM\d{3}/', $useragent)) {
            return (new Mobile\ArnovaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['POV', 'TAB-PROTAB'], true)) {
            return (new Mobile\PointOfViewFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/PI\d{4}/', $useragent)) {
            return (new Mobile\PhilipsFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('FUNC', true)) {
            return (new Mobile\DfuncFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/iD[jnsxr][DQ]?\d{1,2}/', $useragent)) {
            return (new Mobile\DigmaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('GM', true)) {
            return (new Mobile\GeneralMobileFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ZP\d{3}/', $useragent)) {
            return (new Mobile\ZopoFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/s450\d/i', $useragent)) {
            return (new Mobile\DnsFactory($this->loader))->detect($useragent, $s);
        }

        $factoriesBeforeIconbit = [
            'phoenix 2'     => Mobile\FlyFactory::class,
            'vtab1008'      => Mobile\VizioFactory::class,
            'tab10-400'     => Mobile\YarvikFactory::class,
            'terra_101'     => Mobile\GoCleverFactory::class,
            'orion7o'       => Mobile\GoCleverFactory::class,
            'venue'         => Mobile\DellFactory::class,
            'funtab'        => Mobile\OrangeFactory::class,
            'zilo'          => Mobile\OrangeFactory::class,
            'fws610_eu'     => Mobile\PhicommFactory::class,
            'samurai10'     => Mobile\ShiruFactory::class,
            'ignis 8'       => Mobile\TbTouchFactory::class,
            'k1 turbo'      => Mobile\KingzoneFactory::class,
            ' a10 '         => Mobile\AllWinnerFactory::class,
            'mp907c'        => Mobile\AllWinnerFactory::class,
            'shield tablet' => Mobile\NvidiaFactory::class,
            'k910l'         => Mobile\LenovoFactory::class,
            ' k1 '          => Mobile\LenovoFactory::class,
            ' a1'           => Mobile\LenovoFactory::class,
            ' a65 '         => Mobile\LenovoFactory::class,
            ' a60 '         => Mobile\LenovoFactory::class,
            'yoga tablet'   => Mobile\LenovoFactory::class,
            'tab2a7-'       => Mobile\LenovoFactory::class,
            'p770'          => Mobile\LenovoFactory::class,
            'zuk '          => Mobile\LenovoFactory::class,
            ' p2 '          => Mobile\LenovoFactory::class,
            'yb1-x90l'      => Mobile\LenovoFactory::class,
            'b5060'         => Mobile\LenovoFactory::class,
            's1032x'        => Mobile\LenovoFactory::class,
            'x1030x'        => Mobile\LenovoFactory::class,
            'tab7id'        => Mobile\WexlerFactory::class,
            'mb40ii1'       => Mobile\DnsFactory::class,
            'm3 note'       => Mobile\MeizuFactory::class,
            ' m3 '          => Mobile\GioneeFactory::class,
            ' m5 '          => Mobile\GioneeFactory::class,
            'f103'          => Mobile\GioneeFactory::class,
            ' e7 '          => Mobile\GioneeFactory::class,
            ' v6l '         => Mobile\GioneeFactory::class,
            'w100'          => Mobile\ThlFactory::class,
            'w200'          => Mobile\ThlFactory::class,
            ' w8'           => Mobile\ThlFactory::class,
            'w713'          => Mobile\CoolpadFactory::class,
            'ot-'           => Mobile\AlcatelFactory::class,
            'n8000d'        => Mobile\SamsungFactory::class,
            'n003'          => Mobile\NeoFactory::class,
            ' v1 '          => Mobile\MaxtronFactory::class,
        ];

        foreach ($factoriesBeforeIconbit as $test => $factoryName) {
            if ($s->contains($test, false)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if (preg_match('/(OT\-)?[4-9]0[0-7]\d[ADKMNOXY]/', $useragent)) {
            return (new Mobile\AlcatelFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ W\d{3}[ )]/', $useragent)) {
            return (new Mobile\HaierFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/NT\-\d{4}[SPTM]/', $useragent)) {
            return (new Mobile\IconBitFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/T[GXZ]\d{2,3}/', $useragent)) {
            return (new Mobile\IrbisFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/YD\d{3}/', $useragent)) {
            return (new Mobile\YotaFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/TM\-\d{4}/', $useragent)) {
            return (new Mobile\TexetFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/OK\d{3}/', $useragent)) {
            return (new Mobile\SunupFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ACE', true)) {
            return (new Mobile\SamsungFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/PX\-\d{4}/', $useragent)) {
            return (new Mobile\IntegoFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/cp\d{4}/i', $useragent)) {
            return (new Mobile\CoolpadFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ip\d{4}/i', $useragent)) {
            return (new Mobile\DexFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/P\d{4}/', $useragent)) {
            return (new Mobile\ElephoneFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('One', true)) {
            return (new Mobile\HtcFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ v\d\-?[ace]?[ )]/i', $useragent)) {
            return (new Mobile\InewFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(RP|KM)\-U[DQ]M\d{2}/', $useragent)) {
            return (new Mobile\VericoFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/KM\-/', $useragent)) {
            return (new Mobile\KtTechFactory($this->loader))->detect($useragent, $s);
        }

        $factoriesBeforeRossMoor = [
            'primo76'         => Mobile\MsiFactory::class,
            'x-pad'           => Mobile\TexetFactory::class,
            'visio'           => Mobile\OdysFactory::class,
            ' g3 '            => Mobile\LgFactory::class,
            'p509'            => Mobile\LgFactory::class,
            'c660'            => Mobile\LgFactory::class,
            'ls670'           => Mobile\LgFactory::class,
            'vm670'           => Mobile\LgFactory::class,
            'ln240'           => Mobile\LgFactory::class,
            'optimus g'       => Mobile\LgFactory::class,
            'l-05e'           => Mobile\LgFactory::class,
            'zera_f'          => Mobile\HighscreenFactory::class,
            'zera f'          => Mobile\HighscreenFactory::class,
            'boost iise'      => Mobile\HighscreenFactory::class,
            'ice2'            => Mobile\HighscreenFactory::class,
            'prime s'         => Mobile\HighscreenFactory::class,
            'explosion'       => Mobile\HighscreenFactory::class,
            'iris708'         => Mobile\AisFactory::class,
            'l930'            => Mobile\CiotcudFactory::class,
            'x8+'             => Mobile\TrirayFactory::class,
            'surfer 7.34'     => Mobile\ExplayFactory::class,
            'm1_plus'         => Mobile\ExplayFactory::class,
            'd7.2 3g'         => Mobile\ExplayFactory::class,
            'rioplay'         => Mobile\ExplayFactory::class,
            'art 3g'          => Mobile\ExplayFactory::class,
            'pmsmart450'      => Mobile\PmediaFactory::class,
            'f031'            => Mobile\SamsungFactory::class,
            'scl24'           => Mobile\SamsungFactory::class,
            'sct21'           => Mobile\SamsungFactory::class,
            'n900+'           => Mobile\SamsungFactory::class,
            'impad'           => Mobile\ImpressionFactory::class,
            'tab917qc'        => Mobile\SunstechFactory::class,
            'tab785dual'      => Mobile\SunstechFactory::class,
            'm7t'             => Mobile\PipoFactory::class,
            'p93g'            => Mobile\PipoFactory::class,
            'i75'             => Mobile\PipoFactory::class,
            'm83g'            => Mobile\PipoFactory::class,
            ' m6 '            => Mobile\PipoFactory::class,
            'm6pro'           => Mobile\PipoFactory::class,
            'm9pro'           => Mobile\PipoFactory::class,
            ' t9 '            => Mobile\PipoFactory::class,
            'md948g'          => Mobile\MwayFactory::class,
            'smartphone650'   => Mobile\MasterFactory::class,
            'mx enjoy tv box' => Mobile\GeniatechFactory::class,
            'm5301'           => Mobile\IruFactory::class,
            'gv7777'          => Mobile\PrestigioFactory::class,
            'auxus'           => Mobile\IberryFactory::class,
            ' n1 '            => Mobile\NokiaFactory::class,
            '5130c-2'         => Mobile\NokiaFactory::class,
            'lumia'           => Mobile\NokiaFactory::class,
            'arm; 909'        => Mobile\NokiaFactory::class,
            'id336'           => Mobile\NokiaFactory::class,
            'genm14'          => Mobile\NokiaFactory::class,
            'n900'            => Mobile\NokiaFactory::class,
            '9930i'           => Mobile\StarFactory::class,
            'n9100'           => Mobile\SamsungFactory::class,
            'n7100'           => Mobile\SamsungFactory::class,
            'm717r-hd'        => Mobile\VastKingFactory::class,
            'tm785m3'         => Mobile\NuVisionFactory::class,
            'm502'            => Mobile\NavonFactory::class,
            'lencm900hz'      => Mobile\LencoFactory::class,
            'xm300'           => Mobile\LandvoFactory::class,
            'xm100'           => Mobile\LandvoFactory::class,
            'm370i'           => Mobile\InfocusFactory::class,
            'dm550'           => Mobile\BlackviewFactory::class,
            ' m8 '            => Mobile\AmlogicFactory::class,
            'm601'            => Mobile\AocFactory::class,
        ];

        foreach ($factoriesBeforeRossMoor as $test => $factoryName) {
            if ($s->contains($test, false)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if ($s->containsAny(['rm-997', 'rm-560'], false) && !preg_match('/(nokia|microsoft)/i', $useragent)) {
            return (new Mobile\RossMoorFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/RM\-\d{3,4}/', $useragent)) {
            return (new Mobile\NokiaFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/TA\-\d{4}/', $useragent)) {
            return (new Mobile\NokiaFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/N\d{4}/', $useragent)) {
            return (new Mobile\StarFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/IM\-A\d{3}(L|K)/', $useragent)) {
            return (new Mobile\PantechFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/vf\-?\d{3,4}/i', $useragent)) {
            return (new Mobile\TclFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/\d{4}(b|i|k|y)/i', $useragent)) {
            return (new Mobile\TclFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/SPX\-\d/', $useragent)) {
            return (new Mobile\SimvalleyFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/H[MTW]\-[GINW]\d{2,3}/', $useragent)) {
            return (new Mobile\HaierFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/RG\d{3}/', $useragent)) {
            return (new Mobile\RugGearFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('iris', false) && !$s->contains('windows', false)) {
            return (new Mobile\LavaFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ap-105', false)) {
            return (new Mobile\MitashiFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/AP\-\d{3}/', $useragent)) {
            return (new Mobile\AssistantFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(atlantis|discovery) \d{3,4}/i', $useragent)) {
            return (new Mobile\BlaupunktFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ARM; WIN (JR|HD)/', $useragent)) {
            return (new Mobile\BluFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/tp\d{1,2}(\.\d)?\-\d{4}/i', $useragent)) {
            return (new Mobile\IonikFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/tu\-\d{4}/i', $useragent)) {
            return (new Mobile\IonikFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ft[ _]\d{4}/i', $useragent)) {
            return (new Mobile\LifewareFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(sm|yq)\d{3}/i', $useragent)) {
            return (new Mobile\SmartisanFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ls\-\d{4}/i', $useragent)) {
            return (new Mobile\LyfFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('mx4', false)) {
            return (new Mobile\MeizuFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['x9pro', 'x5max_pro', 'x6pro'], false)) {
            return (new Mobile\DoogeeFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/x\d ?(plus|max|pro)/i', $useragent)) {
            return (new Mobile\VivoFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/neffos|tp\d{3}/i', $useragent)) {
            return (new Mobile\TplinkFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ht\d{1,2} ?(pro)?/i', $useragent)) {
            return (new Mobile\HomtomFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/tb\d{3,4}/i', $useragent)) {
            return (new Mobile\AcmeFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/nt\. ?(p|i)10g2/i', $useragent)) {
            return (new Mobile\NinetecFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/N[BP]\d{2,3}/', $useragent)) {
            return (new Mobile\BravisFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/tp\d{2}\-3g/i', $useragent)) {
            return (new Mobile\TheqFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ftj?\d{3}/i', $useragent)) {
            return (new Mobile\FreetelFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('RUNE', true)) {
            return (new Mobile\BsMobileFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('IRON', true)) {
            return (new Mobile\UmiFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/bv[5-8]000/i', $useragent)) {
            return (new Mobile\BlackviewFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/rio r1|gsmart/i', $useragent)) {
            return (new Mobile\GigabyteFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/mz\-| m\d |m\d{3}|m\d note|pro 5/i', $useragent)) {
            return (new Mobile\MeizuFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/[sxz]\d{3}[ae]/i', $useragent)) {
            return (new Mobile\HtcFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(i\-style|iq) ?\d/i', $useragent)) {
            return (new Mobile\ImobileFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/BIGCOOL|COOLFIVE|COOL\-K|Just5|LINK5/', $useragent)) {
            return (new Mobile\KonrowFactory($this->loader))->detect($useragent, $s);
        }

        $factoriesBeforeFly = [
            '7007hd'          => Mobile\PerfeoFactory::class,
            'pt-gf200'        => Mobile\PantechFactory::class,
            'k-8s'            => Mobile\KeenerFactory::class,
            'h1+'             => Mobile\HummerFactory::class,
            'impress_l'       => Mobile\VertexFactory::class,
            'neo-x5'          => Mobile\MinixFactory::class,
            'numy_note_9'     => Mobile\AinolFactory::class,
            'novo7fire'       => Mobile\AinolFactory::class,
            'tab-97e-01'      => Mobile\ReellexFactory::class,
            'vega'            => Mobile\AdventFactory::class,
            'dream'           => Mobile\HtcFactory::class,
            ' x9 '            => Mobile\HtcFactory::class,
            'amaze'           => Mobile\HtcFactory::class,
            'butterfly2'      => Mobile\HtcFactory::class,
            ' xst2 '          => Mobile\FourgSystemsFactory::class,
            'netbox'          => Mobile\SonyFactory::class,
            ' x10 '           => Mobile\SonyFactory::class,
            ' e10i '          => Mobile\SonyFactory::class,
            ' x2 '            => Mobile\SonyFactory::class,
            'r800x'           => Mobile\SonyFactory::class,
            's500i'           => Mobile\SonyFactory::class,
            'x1i'             => Mobile\SonyFactory::class,
            'x10i'            => Mobile\SonyFactory::class,
            'tf300t'          => Mobile\AsusFactory::class,
            'f10x'            => Mobile\NextwayFactory::class,
            'adtab 7 lite'    => Mobile\AdspecFactory::class,
            'neon-n1'         => Mobile\AxgioFactory::class,
            'wing-w2'         => Mobile\AxgioFactory::class,
            't118'            => Mobile\TwinovoFactory::class,
            't108'            => Mobile\TwinovoFactory::class,
            'touareg8_3g'     => Mobile\AccentFactory::class,
            'chagall'         => Mobile\PegatronFactory::class,
            'turbo x6'        => Mobile\TurboPadFactory::class,
            ' l52 '           => Mobile\HaierFactory::class,
            ' g30 '           => Mobile\HaierFactory::class,
            'pad g781'        => Mobile\HaierFactory::class,
            'air a70'         => Mobile\RoverPadFactory::class,
            'sp-6020 quasar'  => Mobile\WooFactory::class,
            'q10s'            => Mobile\WopadFactory::class,
            'ctab785r16-3g'   => Mobile\CondorFactory::class,
            'pkt-301'         => Mobile\CondorFactory::class,
            'uq785-m1bgv'     => Mobile\VericoFactory::class,
            't9666-1'         => Mobile\TelsdaFactory::class,
            'h7100'           => Mobile\FeitengFactory::class,
            'x909'            => Mobile\OppoFactory::class,
            'r815'            => Mobile\OppoFactory::class,
            'r8106'           => Mobile\OppoFactory::class,
            'u705t'           => Mobile\OppoFactory::class,
            'find7'           => Mobile\OppoFactory::class,
            'a37f'            => Mobile\OppoFactory::class,
            'a33f'            => Mobile\OppoFactory::class,
            'r7f'             => Mobile\OppoFactory::class,
            'r7sf'            => Mobile\OppoFactory::class,
            'r7kf'            => Mobile\OppoFactory::class,
            'r7plusf'         => Mobile\OppoFactory::class,
            'x9006'           => Mobile\OppoFactory::class,
            'x9076'           => Mobile\OppoFactory::class,
            ' 1201 '          => Mobile\OppoFactory::class,
            'n1t'             => Mobile\OppoFactory::class,
            'r831k'           => Mobile\OppoFactory::class,
            'xda'             => Mobile\O2Factory::class,
            'kkt20'           => Mobile\LavaFactory::class,
            'pixelv1'         => Mobile\LavaFactory::class,
            'pixel v2+'       => Mobile\LavaFactory::class,
            ' x17 '           => Mobile\LavaFactory::class,
            'x1 atom'         => Mobile\LavaFactory::class,
            'x1 selfie'       => Mobile\LavaFactory::class,
            'x5 4g'           => Mobile\LavaFactory::class,
            'pulse'           => Mobile\TmobileFactory::class,
            'mytouch4g'       => Mobile\TmobileFactory::class,
            'ameo'            => Mobile\TmobileFactory::class,
            'garminfone'      => Mobile\TmobileFactory::class,
            'redmi'           => Mobile\XiaomiFactory::class,
            'note 4'          => Mobile\XiaomiFactory::class,
            '2014818'         => Mobile\XiaomiFactory::class,
            '2014813'         => Mobile\XiaomiFactory::class,
            '2014011'         => Mobile\XiaomiFactory::class,
            '2015562'         => Mobile\XiaomiFactory::class,
            'g009'            => Mobile\YxtelFactory::class,
            'picopad_s1'      => Mobile\AxiooFactory::class,
            'adi_5s'          => Mobile\ArtelFactory::class,
            'norma 2'         => Mobile\KeneksiFactory::class,
            't880g'           => Mobile\EtulineFactory::class,
            'studio 5.5'      => Mobile\BluFactory::class,
            'studio xl 2'     => Mobile\BluFactory::class,
            'f3_pro'          => Mobile\DoogeeFactory::class,
            'y6_piano'        => Mobile\DoogeeFactory::class,
            'y6 max'          => Mobile\DoogeeFactory::class,
            ' t6 '            => Mobile\DoogeeFactory::class,
            'tab-970'         => Mobile\PrologyFactory::class,
            'a66a'            => Mobile\EvercossFactory::class,
            'n90fhdrk'        => Mobile\YuandaoFactory::class,
            'nova'            => Mobile\CatSoundFactory::class,
            'i545'            => Mobile\SamsungFactory::class,
            'discovery'       => Mobile\GeneralMobileFactory::class,
            't720'            => Mobile\MotorolaFactory::class,
            'n820'            => Mobile\AmoiFactory::class,
            'n90 dual core2'  => Mobile\YuandaoFactory::class,
            'tpc-'            => Mobile\JaytechFactory::class,
            ' g9 '            => Mobile\MastoneFactory::class,
            'dl1'             => Mobile\PanasonicFactory::class,
            'eluga_arc_2'     => Mobile\PanasonicFactory::class,
            'zt180'           => Mobile\ZenithinkFactory::class,
            'e1107'           => Mobile\YusuFactory::class,
            'is05'            => Mobile\SharpFactory::class,
            'p4d sirius'      => Mobile\NvsblFactory::class,
            ' c2 '            => Mobile\ZopoFactory::class,
            'a0001'           => Mobile\OneplusFactory::class,
            'smartpad'        => Mobile\EinsUndEinsFactory::class,
            'n930'            => Mobile\CoolpadFactory::class,
            '8079'            => Mobile\CoolpadFactory::class,
            '5860s'           => Mobile\CoolpadFactory::class,
            'la-m1'           => Mobile\BeidouFactory::class,
            'i4901'           => Mobile\IdeaFactory::class,
            'lead 1'          => Mobile\LeagooFactory::class,
            'lead 2'          => Mobile\LeagooFactory::class,
            't1_plus'         => Mobile\LeagooFactory::class,
            'elite 4'         => Mobile\LeagooFactory::class,
            'elite 5'         => Mobile\LeagooFactory::class,
            'shark 1'         => Mobile\LeagooFactory::class,
            'v1_viper'        => Mobile\AllviewFactory::class,
            'a4you'           => Mobile\AllviewFactory::class,
            'p5_quad'         => Mobile\AllviewFactory::class,
            'x2_soul'         => Mobile\AllviewFactory::class,
            'ax4nano'         => Mobile\AllviewFactory::class,
            'x1_soul'         => Mobile\AllviewFactory::class,
            'forward_art'     => Mobile\NgmFactory::class,
            'gnet'            => Mobile\GnetFactory::class,
            'hive v 3g'       => Mobile\TurboxFactory::class,
            'hive iv 3g'      => Mobile\TurboxFactory::class,
            'turkcell'        => Mobile\TurkcellFactory::class,
            'l-ement500'      => Mobile\LogicomFactory::class,
            'is04'            => Mobile\KddiFactory::class,
            'be pro'          => Mobile\UlefoneFactory::class,
            'paris'           => Mobile\UlefoneFactory::class,
            'vienna'          => Mobile\UlefoneFactory::class,
            'u007'            => Mobile\UlefoneFactory::class,
            'future'          => Mobile\UlefoneFactory::class,
            'power_3'         => Mobile\UlefoneFactory::class,
            't1x plus'        => Mobile\AdvanFactory::class,
            'vandroid'        => Mobile\AdvanFactory::class,
            'sense golly'     => Mobile\IproFactory::class,
            'sirius_qs'       => Mobile\VoninoFactory::class,
            'dl 1803'         => Mobile\DlFactory::class,
            's10q-3g'         => Mobile\SmartbookFactory::class,
            'trekker-x1'      => Mobile\CrosscallFactory::class,
            ' s30 '           => Mobile\FireflyFactory::class,
            'apollo'          => Mobile\VerneeFactory::class,
            'thor'            => Mobile\VerneeFactory::class,
            '1505-a02'        => Mobile\ItelFactory::class,
            'inote'           => Mobile\ItelFactory::class,
            'mitab think'     => Mobile\WolderFactory::class,
            'pixel'           => Mobile\GoogleFactory::class,
            'gce x86 phone'   => Mobile\GoogleFactory::class,
            'glass 1'         => Mobile\GoogleFactory::class,
            '909t'            => Mobile\MpieFactory::class,
            ' m13 '           => Mobile\MpieFactory::class,
            'z30'             => Mobile\MagnusFactory::class,
            'up580'           => Mobile\UhappyFactory::class,
            'swift'           => Mobile\WileyfoxFactory::class,
            'm9c max'         => Mobile\BqeelFactory::class,
            'qt-10'           => Mobile\QmaxFactory::class,
            'ilium l820'      => Mobile\LanixFactory::class,
            's501m 3g'        => Mobile\FourGoodFactory::class,
            't700i_3g'        => Mobile\FourGoodFactory::class,
            'ixion_es255'     => Mobile\DexpFactory::class,
            'h135'            => Mobile\DexpFactory::class,
            'atl-21'          => Mobile\ArtizleeFactory::class,
            'w032i-c3'        => Mobile\IntelFactory::class,
            'tr10rs1'         => Mobile\IntelFactory::class,
            'tr10cd1'         => Mobile\IntelFactory::class,
            'cs24'            => Mobile\CyrusFactory::class,
            'cs25'            => Mobile\CyrusFactory::class,
            ' t02 '           => Mobile\ChanghongFactory::class,
            'crown'           => Mobile\BlackviewFactory::class,
            ' r6 '            => Mobile\BlackviewFactory::class,
            ' a8 '            => Mobile\BlackviewFactory::class,
            'alife p1'        => Mobile\BlackviewFactory::class,
            'omega_pro'       => Mobile\BlackviewFactory::class,
            'k107'            => Mobile\YuntabFactory::class,
            'london'          => Mobile\UmiFactory::class,
            'hammer_s'        => Mobile\UmiFactory::class,
            'elegance'        => Mobile\KianoFactory::class,
            'slimtab7_3gr'    => Mobile\KianoFactory::class,
            'u7 plus'         => Mobile\OukitelFactory::class,
            'u16 max'         => Mobile\OukitelFactory::class,
            'k6000 pro'       => Mobile\OukitelFactory::class,
            'k6000 plus'      => Mobile\OukitelFactory::class,
            'k4000'           => Mobile\OukitelFactory::class,
            'k10000'          => Mobile\OukitelFactory::class,
            'universetap'     => Mobile\OukitelFactory::class,
            'vi8 plus'        => Mobile\ChuwiFactory::class,
            'hibook'          => Mobile\ChuwiFactory::class,
            'jy-'             => Mobile\JiayuFactory::class,
            ' m10 '           => Mobile\BqFactory::class,
            'edison 3'        => Mobile\BqFactory::class,
            ' m20 '           => Mobile\TimmyFactory::class,
            'g708 oc'         => Mobile\ColorflyFactory::class,
            'q880_xk'         => Mobile\TianjiFactory::class,
            'c55'             => Mobile\CtroniqFactory::class,
            'l900'            => Mobile\LandvoFactory::class,
            ' k5 '            => Mobile\KomuFactory::class,
            ' x6 '            => Mobile\VotoFactory::class,
            ' m71 '           => Mobile\EplutusFactory::class,
            ' d10 '           => Mobile\XgodyFactory::class,
            'hudl 2'          => Mobile\TescoFactory::class,
            'tab1024'         => Mobile\IntensoFactory::class,
            'ifive mini 4s'   => Mobile\FnfFactory::class,
            ' i10 '           => Mobile\SymphonyFactory::class,
            ' h150 '          => Mobile\SymphonyFactory::class,
            ' arc '           => Mobile\KoboFactory::class,
            'm92d-3g'         => Mobile\SumvierFactory::class,
            ' c4 '            => Mobile\TreviFactory::class,
            'phablet 5,3 q'   => Mobile\TreviFactory::class,
            ' f5 '            => Mobile\TecnoFactory::class,
            ' h7 '            => Mobile\TecnoFactory::class,
            'a88x'            => Mobile\AlldaymallFactory::class,
            'bs1078'          => Mobile\YonesToptechFactory::class,
            'excellent8'      => Mobile\TomtecFactory::class,
            'ih-g101'         => Mobile\InnoHitFactory::class,
            'g900'            => Mobile\IppoFactory::class,
            'nimbus 80qb'     => Mobile\WoxterFactory::class,
            'gs55-6'          => Mobile\GigasetFactory::class,
            'gs53-6'          => Mobile\GigasetFactory::class,
            'vkb011b'         => Mobile\FengxiangFactory::class,
            'trooper'         => Mobile\KazamFactory::class,
            'tornado'         => Mobile\KazamFactory::class,
            'thunder'         => Mobile\KazamFactory::class,
            'end_101g-test'   => Mobile\BlaupunktFactory::class,
            ' n3 '            => Mobile\GooPhoneFactory::class,
            'king 7'          => Mobile\PptvFactory::class,
            'admire sxy'      => Mobile\ZenFactory::class,
            'cinemax'         => Mobile\ZenFactory::class,
            '1501_m02'        => Mobile\ThreeSixtyFactory::class,
            'd4c5'            => Mobile\TeclastFactory::class,
            'k9c6'            => Mobile\TeclastFactory::class,
            't72'             => Mobile\OystersFactory::class,
            'ns-14t004'       => Mobile\InsigniaFactory::class,
            'ns-p10a6100'     => Mobile\InsigniaFactory::class,
            'blaster 2'       => Mobile\JustFiveFactory::class,
            'picasso'         => Mobile\BlubooFactory::class,
            'strongphoneq4'   => Mobile\EvolveoFactory::class,
            'shift7'          => Mobile\ShiftFactory::class,
            'shift5.2'        => Mobile\ShiftFactory::class,
            'k960'            => Mobile\JlinkszFactory::class,
            'q8002'           => Mobile\CryptoFactory::class,
            'i-call'          => Mobile\IjoyFactory::class,
            'elektra l'       => Mobile\IjoyFactory::class,
            'ektra'           => Mobile\KodakFactory::class,
            'kt107'           => Mobile\BdfFactory::class,
            'm52_red_note'    => Mobile\MlaisFactory::class,
            'sunmicrosystems' => Mobile\SunFactory::class,
            ' p2'             => Mobile\GioneeFactory::class,
            ' a50'            => Mobile\MicromaxFactory::class,
            'max2_plus_3g'    => Mobile\InnjooFactory::class,
            'a727'            => Mobile\AzpenFactory::class,
            'coolpix s800c'   => Mobile\NikonFactory::class,
            'vsd220'          => Mobile\ViewSonicFactory::class,
            'primo-zx'        => Mobile\WaltonFactory::class,
            'x538'            => Mobile\SunsbellFactory::class,
            'i1-3gd'          => Mobile\CubeFactory::class,
            'sf1'             => Mobile\ObiFactory::class,
            'harrier tab'     => Mobile\EeFactory::class,
            'excite prime'    => Mobile\CloudfoneFactory::class,
            ' z1 '            => Mobile\NinetologyFactory::class,
        ];

        foreach ($factoriesBeforeFly as $test => $factoryName) {
            if ($s->contains((string) $test, false)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if ($s->contains('presto', false) && !$s->contains('opera', false)) {
            return (new Mobile\OplusFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('I5', true)) {
            return (new Mobile\SopFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('i5', true)) {
            return (new Mobile\VsunFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['kin.two', 'zunehd'], false)) {
            return (new Mobile\MicrosoftFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ARM;/', $useragent)
            && preg_match('/Windows NT 6\.(2|3)/', $useragent)
            && !preg_match('/WPDesktop/', $useragent)
        ) {
            return (new Mobile\MicrosoftFactory($this->loader))->detect($useragent, $s);
        }

        return $this->loader->load('general mobile device', $useragent);
    }
}
