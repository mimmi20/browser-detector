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
        $factoriesBeforeSamsung = [
            'hiphone'     => Mobile\HiPhoneFactory::class,
            'v919 3g air' => Mobile\OndaFactory::class,
            'technisat'   => Mobile\TechnisatFactory::class,
            'technipad'   => Mobile\TechnisatFactory::class,
            'aqipad'      => Mobile\TechnisatFactory::class,
            'techniphone' => Mobile\TechnisatFactory::class,
            'navipad'     => Mobile\TexetFactory::class,
            'medipad'     => Mobile\BewatecFactory::class,
            'mipad'       => Mobile\XiaomiFactory::class,
            'nokia'       => Mobile\NokiaFactory::class,
        ];

        foreach ($factoriesBeforeSamsung as $test => $factoryName) {
            if ($s->contains($test, false)) {
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

        $factoriesBeforeApple = [
            'samsung'    => Mobile\SamsungFactory::class,
            'blackberry' => Mobile\BlackBerryFactory::class,
        ];

        foreach ($factoriesBeforeApple as $test => $factoryName) {
            if ($s->contains($test, false)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if ($s->containsAny(['ipad', 'ipod', 'iphone', 'like mac os x', 'darwin', 'cfnetwork'], false)
            && !$s->containsAny(['windows phone', ' adr ', 'ipodder', 'tripadvisor'], false)
        ) {
            return (new Mobile\AppleFactory($this->loader))->detect($useragent, $s);
        }

        $factoriesBeforeLg = [
            'asus'        => Mobile\AsusFactory::class,
            'mt-gt-a9500' => Mobile\HtmFactory::class,
            'gt-a7100'    => Mobile\HtmFactory::class,
            'feiteng'     => Mobile\FeitengFactory::class,
            'gt-h'        => Mobile\FeitengFactory::class,
            'cube'        => Mobile\CubeFactory::class,
            'u30gt'       => Mobile\CubeFactory::class,
            'u51gt'       => Mobile\CubeFactory::class,
            'u55gt'       => Mobile\CubeFactory::class,
            'i15-tcl'     => Mobile\CubeFactory::class,
            'u25gt-c4w'   => Mobile\CubeFactory::class,
            'gtx75'       => Mobile\UtStarcomFactory::class,
            'gt-9000'     => Mobile\StarFactory::class,
        ];

        foreach ($factoriesBeforeLg as $test => $factoryName) {
            if ($s->contains($test, false)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if ($s->contains('LG', true)) {
            return (new Mobile\LgFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(gt|sam|sc|sch|sec|sgh|shv|shw|sm|sph|continuum|ek|yp)\-/i', $useragent)) {
            return (new Mobile\SamsungFactory($this->loader))->detect($useragent, $s);
        }

        $factoriesBeforeOnda = [
            'hdc'           => Mobile\HdcFactory::class,
            'galaxy s3 ex'  => Mobile\HdcFactory::class,
            'nexus 5'       => Mobile\LgFactory::class,
            'nexus 4'       => Mobile\LgFactory::class,
            'nexus5'        => Mobile\LgFactory::class,
            'nexus4'        => Mobile\LgFactory::class,
            'nexus 7'       => Mobile\AsusFactory::class,
            'nexus_7'       => Mobile\AsusFactory::class,
            'nexus7'        => Mobile\AsusFactory::class,
            'nexus 6p'      => Mobile\HuaweiFactory::class,
            'nexus 6'       => Mobile\MotorolaFactory::class,
            'nexus one'     => Mobile\HtcFactory::class,
            'nexus 9'       => Mobile\HtcFactory::class,
            'nexus evohd2'  => Mobile\HtcFactory::class,
            'nexushd2'      => Mobile\HtcFactory::class,
            'pantech'       => Mobile\PantechFactory::class,
            'hp'            => Mobile\HpFactory::class,
            'p160u'         => Mobile\HpFactory::class,
            'touchpad'      => Mobile\HpFactory::class,
            'pixi'          => Mobile\HpFactory::class,
            'palm'          => Mobile\HpFactory::class,
            'cm_tenderloin' => Mobile\HpFactory::class,
            'slate'         => Mobile\HpFactory::class,
            'galaxy'        => Mobile\SamsungFactory::class,
            'nexus'         => Mobile\SamsungFactory::class,
            'i7110'         => Mobile\SamsungFactory::class,
            'i9100'         => Mobile\SamsungFactory::class,
            'i9300'         => Mobile\SamsungFactory::class,
            'blaze'         => Mobile\SamsungFactory::class,
            's8500'         => Mobile\SamsungFactory::class,
            'sony'          => Mobile\SonyFactory::class,
            'accent'        => Mobile\AccentFactory::class,
            'smarttab10'    => Mobile\ZteFactory::class,
            'smarttab7'     => Mobile\ZteFactory::class,
            'smart 4g'      => Mobile\ZteFactory::class,
            'smart ultra 6' => Mobile\ZteFactory::class,
            'lenovo'        => Mobile\LenovoFactory::class,
            'ideatab'       => Mobile\LenovoFactory::class,
            'ideapad'       => Mobile\LenovoFactory::class,
            'smarttab'      => Mobile\LenovoFactory::class,
            'thinkpad'      => Mobile\LenovoFactory::class,
            'startrail4'    => Mobile\SfrFactory::class,
            'zte'           => Mobile\ZteFactory::class,
            'racer'         => Mobile\ZteFactory::class,
            'acer'          => Mobile\AcerFactory::class,
            'iconia'        => Mobile\AcerFactory::class,
            'liquid'        => Mobile\AcerFactory::class,
            'playstation'   => Mobile\SonyFactory::class,
            'amazon'        => Mobile\AmazonFactory::class,
            'kindle'        => Mobile\AmazonFactory::class,
            'silk'          => Mobile\AmazonFactory::class,
            'kftt'          => Mobile\AmazonFactory::class,
            'kfot'          => Mobile\AmazonFactory::class,
            'kfjwi'         => Mobile\AmazonFactory::class,
            'kfsowi'        => Mobile\AmazonFactory::class,
            'kfthwi'        => Mobile\AmazonFactory::class,
            'sd4930ur'      => Mobile\AmazonFactory::class,
            'kfapwa'        => Mobile\AmazonFactory::class,
            'kfaswi'        => Mobile\AmazonFactory::class,
            'kfapwi'        => Mobile\AmazonFactory::class,
            'kfdowi'        => Mobile\AmazonFactory::class,
            'kfauwi'        => Mobile\AmazonFactory::class,
            'kfgiwi'        => Mobile\AmazonFactory::class,
            'kftbwi'        => Mobile\AmazonFactory::class,
            'kfmewi'        => Mobile\AmazonFactory::class,
            'kffowi'        => Mobile\AmazonFactory::class,
            'kfsawi'        => Mobile\AmazonFactory::class,
            'kfsawa'        => Mobile\AmazonFactory::class,
            'kfarwi'        => Mobile\AmazonFactory::class,
            'kfthwa'        => Mobile\AmazonFactory::class,
            'kfjwa'         => Mobile\AmazonFactory::class,
            'fire2'         => Mobile\AmazonFactory::class,
            'amoi'          => Mobile\AmoiFactory::class,
            'blaupunkt'     => Mobile\BlaupunktFactory::class,
            'endeavour'     => Mobile\BlaupunktFactory::class,
            'dataaccessd'   => Mobile\AppleFactory::class,
            'cce'           => Mobile\CceFactory::class,
        ];

        foreach ($factoriesBeforeOnda as $test => $factoryName) {
            if ($s->contains($test, false)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if ($s->contains('htc', false) && !$s->contains('wohtc', false)) {
            return (new Mobile\HtcFactory($this->loader))->detect($useragent, $s);
        }

        $factoriesBeforeCoby = [
            'onda'         => Mobile\OndaFactory::class,
            'archos'       => Mobile\ArchosFactory::class,
            'irulu'        => Mobile\IruluFactory::class,
            'symphony'     => Mobile\SymphonyFactory::class,
            'spice'        => Mobile\SpiceFactory::class,
            'arnova'       => Mobile\ArnovaFactory::class,
            ' bn '         => Mobile\BarnesNobleFactory::class,
            'bntv600'      => Mobile\BarnesNobleFactory::class,
            'playbook'     => Mobile\BlackBerryFactory::class,
            'rim tablet'   => Mobile\BlackBerryFactory::class,
            'bb10'         => Mobile\BlackBerryFactory::class,
            'stv100'       => Mobile\BlackBerryFactory::class,
            'bba100-2'     => Mobile\BlackBerryFactory::class,
            'bbb100-2'     => Mobile\BlackBerryFactory::class,
            'b15'          => Mobile\CaterpillarFactory::class,
            'catnova'      => Mobile\CatSoundFactory::class,
            'cat nova'     => Mobile\CatSoundFactory::class,
            'cat stargate' => Mobile\CatSoundFactory::class,
            'cat tablet'   => Mobile\CatSoundFactory::class,
            'cathelix'     => Mobile\CatSoundFactory::class,
            'coby'         => Mobile\CobyFactory::class,
            'nbpc724'      => Mobile\CobyFactory::class,
            'o+'           => Mobile\OplusFactory::class,
            'oplus'        => Mobile\OplusFactory::class,
            'goly'         => Mobile\GolyFactory::class,
        ];

        foreach ($factoriesBeforeCoby as $test => $factoryName) {
            if ($s->contains($test, false)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if (preg_match('/MID\d{4}/', $useragent)) {
            return (new Mobile\CobyFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/WM\d{4}/', $useragent)) {
            return (new Mobile\WonderMediaFactory($this->loader))->detect($useragent, $s);
        }

        $factoriesBeforeNec = [
            'comag'        => Mobile\ComagFactory::class,
            'wtdr1018'     => Mobile\ComagFactory::class,
            'coolpad'      => Mobile\CoolpadFactory::class,
            'cosmote'      => Mobile\CosmoteFactory::class,
            'creative'     => Mobile\CreativeFactory::class,
            'ziilabs'      => Mobile\CreativeFactory::class,
            'ziio7'        => Mobile\CreativeFactory::class,
            'cubot'        => Mobile\CubotFactory::class,
            'dell'         => Mobile\DellFactory::class,
            'denver'       => Mobile\DenverFactory::class,
            'tad-'         => Mobile\DenverFactory::class,
            'taq-'         => Mobile\DenverFactory::class,
            'connect7pro'  => Mobile\OdysFactory::class,
            'connect8plus' => Mobile\OdysFactory::class,
            'sharp'        => Mobile\SharpFactory::class,
        ];

        foreach ($factoriesBeforeNec as $test => $factoryName) {
            if ($s->contains($test, false)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if ($s->contains('nec', false) && !$s->contains('fennec', false)) {
            return (new Mobile\NecFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/\d{3}SH/', $useragent)) {
            return (new Mobile\SharpFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/SH\-?\d{2,4}(C|D|F|U)/', $useragent)) {
            return (new Mobile\SharpFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/m\-(m|p)p/i', $useragent)) {
            return (new Mobile\MediacomFactory($this->loader))->detect($useragent, $s);
        }

        $factoriesBeforeHannspree = [
            'n-06e'      => Mobile\NecFactory::class,
            'n905i'      => Mobile\NecFactory::class,
            'n705i'      => Mobile\NecFactory::class,
            'docomo'     => Mobile\DoCoMoFactory::class,
            'p900i'      => Mobile\DoCoMoFactory::class,
            'easypix'    => Mobile\EasypixFactory::class,
            'easypad'    => Mobile\EasypixFactory::class,
            'junior 4.0' => Mobile\EasypixFactory::class,
            'smart-e5'   => Mobile\EfoxFactory::class,
            'xoro'       => Mobile\XoroFactory::class,
            'telepad'    => Mobile\XoroFactory::class,
            'memup'      => Mobile\MemupFactory::class,
            'slidepad'   => Mobile\MemupFactory::class,
            'epad'       => Mobile\ZenithinkFactory::class,
            'p7901a'     => Mobile\ZenithinkFactory::class,
            'p7mini'     => Mobile\HuaweiFactory::class,
            'flytouch'   => Mobile\FlytouchFactory::class,
            'fujitsu'    => Mobile\FujitsuFactory::class,
            'm532'       => Mobile\FujitsuFactory::class,
            'm305'       => Mobile\FujitsuFactory::class,
            'sn10t1'     => Mobile\HannspreeFactory::class,
        ];

        foreach ($factoriesBeforeHannspree as $test => $factoryName) {
            if ($s->contains($test, false)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if (preg_match('/hsg\d{4}/i', $useragent)) {
            return (new Mobile\HannspreeFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('DA241HL', true)) {
            return (new Mobile\AcerFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('SHL25', true)) {
            return (new Mobile\SharpFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('thl', false) && !$s->contains('liauthlibrary', false)) {
            return (new Mobile\ThlFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['Honlin', 'PC1088', 'HL'], true)) {
            return (new Mobile\HonlinFactory($this->loader))->detect($useragent, $s);
        }

        $factoriesBeforeIntenso = [
            'huawei'    => Mobile\HuaweiFactory::class,
            'micromax'  => Mobile\MicromaxFactory::class,
            'explay'    => Mobile\ExplayFactory::class,
            'oneplus'   => Mobile\OneplusFactory::class,
            'kingzone'  => Mobile\KingzoneFactory::class,
            'goophone'  => Mobile\GooPhoneFactory::class,
            'g-tide'    => Mobile\GtideFactory::class,
            'turbopad'  => Mobile\TurboPadFactory::class,
            'turbo pad' => Mobile\TurboPadFactory::class,
            'haier'     => Mobile\HaierFactory::class,
            'hummer'    => Mobile\HummerFactory::class,
            'oysters'   => Mobile\OystersFactory::class,
            'gfive'     => Mobile\GfiveFactory::class,
            'iconbit'   => Mobile\IconBitFactory::class,
            'sxz'       => Mobile\SxzFactory::class,
            'aoc'       => Mobile\AocFactory::class,
        ];

        foreach ($factoriesBeforeIntenso as $test => $factoryName) {
            if ($s->contains($test, false)) {
                /*  @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if (preg_match('/INM\d{3,4}/', $useragent)) {
            return (new Mobile\IntensoFactory($this->loader))->detect($useragent, $s);
        }

        $factoriesBeforeXiaomi = [
            'jay-tech'     => Mobile\JaytechFactory::class,
            'jolla'        => Mobile\JollaFactory::class,
            'sailfish'     => Mobile\JollaFactory::class,
            'kazam'        => Mobile\KazamFactory::class,
            'kddi'         => Mobile\KddiFactory::class,
            'kobo'         => Mobile\KoboFactory::class,
            'lenco'        => Mobile\LencoFactory::class,
            'lepan'        => Mobile\LePanFactory::class,
            'logicpd'      => Mobile\LogicpdFactory::class,
            'zoom2'        => Mobile\LogicpdFactory::class,
            'nookcolor'    => Mobile\LogicpdFactory::class,
            'nook color'   => Mobile\LogicpdFactory::class,
            'medion'       => Mobile\MedionFactory::class,
            'lifetab'      => Mobile\MedionFactory::class,
            'meizu'        => Mobile\MeizuFactory::class,
            'hisense'      => Mobile\HisenseFactory::class,
            'minix'        => Mobile\MinixFactory::class,
            'allwinner'    => Mobile\AllWinnerFactory::class,
            'supra'        => Mobile\SupraFactory::class,
            'prestigio'    => Mobile\PrestigioFactory::class,
            'mobistel'     => Mobile\MobistelFactory::class,
            'cynus'        => Mobile\MobistelFactory::class,
            'moto'         => Mobile\MotorolaFactory::class,
            'nintendo'     => Mobile\NintendoFactory::class,
            'odys'         => Mobile\OdysFactory::class,
            'oppo'         => Mobile\OppoFactory::class,
            'panasonic'    => Mobile\PanasonicFactory::class,
            'pandigital'   => Mobile\PandigitalFactory::class,
            'phicomm'      => Mobile\PhicommFactory::class,
            'pomp'         => Mobile\PompFactory::class,
            'qmobile'      => Mobile\QmobileFactory::class,
            'sanyo'        => Mobile\SanyoFactory::class,
            'siemens'      => Mobile\SiemensFactory::class,
            'benq'         => Mobile\SiemensFactory::class,
            'sagem'        => Mobile\SagemFactory::class,
            'ouya'         => Mobile\OuyaFactory::class,
            'trevi'        => Mobile\TreviFactory::class,
            'cowon'        => Mobile\CowonFactory::class,
            'homtom'       => Mobile\HomtomFactory::class,
            'hosin'        => Mobile\HosinFactory::class,
            'hasee'        => Mobile\HaseeFactory::class,
            'tecno'        => Mobile\TecnoFactory::class,
            'intex'        => Mobile\IntexFactory::class,
            'sprint'       => Mobile\SprintFactory::class,
            'gionee'       => Mobile\GioneeFactory::class,
            'videocon'     => Mobile\VideoconFactory::class,
            'gigaset'      => Mobile\GigasetFactory::class,
            'dns'          => Mobile\DnsFactory::class,
            'kyocera'      => Mobile\KyoceraFactory::class,
            'texet'        => Mobile\TexetFactory::class,
            's-tell'       => Mobile\StellFactory::class,
            'bliss'        => Mobile\BlissFactory::class,
            'alcatel'      => Mobile\AlcatelFactory::class,
            'tolino'       => Mobile\TolinoFactory::class,
            'toshiba'      => Mobile\ToshibaFactory::class,
            'trekstor'     => Mobile\TrekStorFactory::class,
            'viewsonic'    => Mobile\ViewSonicFactory::class,
            'viewpad'      => Mobile\ViewSonicFactory::class,
            'wiko'         => Mobile\WikoFactory::class,
            'vivo iv'      => Mobile\BluFactory::class,
            'vivo'         => Mobile\VivoFactory::class,
            'haipai'       => Mobile\HaipaiFactory::class,
            'megafon'      => Mobile\MegaFonFactory::class,
            'yuanda'       => Mobile\YuandaFactory::class,
            'pocketbook'   => Mobile\PocketBookFactory::class,
            'goclever'     => Mobile\GoCleverFactory::class,
            'senseit'      => Mobile\SenseitFactory::class,
            'twz'          => Mobile\TwzFactory::class,
            'i-mobile'     => Mobile\ImobileFactory::class,
            'evercoss'     => Mobile\EvercossFactory::class,
            'dino'         => Mobile\DinoFactory::class,
            'shaan'        => Mobile\ShaanFactory::class,
            'iball'        => Mobile\ShaanFactory::class,
            'modecom'      => Mobile\ModecomFactory::class,
            'kiano'        => Mobile\KianoFactory::class,
            'philips'      => Mobile\PhilipsFactory::class,
            'infinix'      => Mobile\InfinixFactory::class,
            'infocus'      => Mobile\InfocusFactory::class,
            'karbonn'      => Mobile\KarbonnFactory::class,
            'pentagram'    => Mobile\PentagramFactory::class,
            'smartfren'    => Mobile\SmartfrenFactory::class,
            'ngm'          => Mobile\NgmFactory::class,
            'orange hi 4g' => Mobile\ZteFactory::class,
            'orange reyo'  => Mobile\ZteFactory::class,
            'orange'       => Mobile\OrangeFactory::class,
            'spv'          => Mobile\OrangeFactory::class,
            't-mobile'     => Mobile\TmobileFactory::class,
            'mot'          => Mobile\MotorolaFactory::class,
            'hs-'          => Mobile\HisenseFactory::class,
            'beeline pro'  => Mobile\ZteFactory::class,
            'beeline'      => Mobile\BeelineFactory::class,
            'digma'        => Mobile\DigmaFactory::class,
            'axgio'        => Mobile\AxgioFactory::class,
            'zopo'         => Mobile\ZopoFactory::class,
            'malata'       => Mobile\MalataFactory::class,
            'starway'      => Mobile\StarwayFactory::class,
            'starmobile'   => Mobile\StarmobileFactory::class,
            'logicom'      => Mobile\LogicomFactory::class,
            'gigabyte'     => Mobile\GigabyteFactory::class,
            'qumo'         => Mobile\QumoFactory::class,
            'celkon'       => Mobile\CelkonFactory::class,
            'bravis'       => Mobile\BravisFactory::class,
            'fnac'         => Mobile\FnacFactory::class,
            'tcl'          => Mobile\TclFactory::class,
            'radxa'        => Mobile\RadxaFactory::class,
            'xolo'         => Mobile\XoloFactory::class,
            'dragon touch' => Mobile\DragonTouchFactory::class,
            'ramos'        => Mobile\RamosFactory::class,
            'woxter'       => Mobile\WoxterFactory::class,
            'ktouch'       => Mobile\KtouchFactory::class,
            'k-touch'      => Mobile\KtouchFactory::class,
            'mastone'      => Mobile\MastoneFactory::class,
            'nuqleo'       => Mobile\NuqleoFactory::class,
            'wexler'       => Mobile\WexlerFactory::class,
            'exeq'         => Mobile\ExeqFactory::class,
            '4good'        => Mobile\FourGoodFactory::class,
            'utstar'       => Mobile\UtStarcomFactory::class,
            'walton'       => Mobile\WaltonFactory::class,
            'quadro'       => Mobile\QuadroFactory::class,
            'xiaomi'       => Mobile\XiaomiFactory::class,
            'pipo'         => Mobile\PipoFactory::class,
            'tesla'        => Mobile\TeslaFactory::class,
            'doro'         => Mobile\DoroFactory::class,
            'captiva'      => Mobile\CaptivaFactory::class,
            'elephone'     => Mobile\ElephoneFactory::class,
            'cyrus'        => Mobile\CyrusFactory::class,
            'wopad'        => Mobile\WopadFactory::class,
            'anka'         => Mobile\AnkaFactory::class,
            'lemon'        => Mobile\LemonFactory::class,
            'lava'         => Mobile\LavaFactory::class,
            'sop-'         => Mobile\SopFactory::class,
            'vsun'         => Mobile\VsunFactory::class,
            'advan'        => Mobile\AdvanFactory::class,
            'velocity'     => Mobile\VelocityMicroFactory::class,
            'allview'      => Mobile\AllviewFactory::class,
            'myphone'      => Mobile\MyphoneFactory::class,
            'turbo-x'      => Mobile\TurboxFactory::class,
            'tagi'         => Mobile\TagiFactory::class,
            'avvio'        => Mobile\AvvioFactory::class,
            'e-boda'       => Mobile\EbodaFactory::class,
            'ergo'         => Mobile\ErgoFactory::class,
            'pulid'        => Mobile\PulidFactory::class,
            'dexp'         => Mobile\DexpFactory::class,
            'keneksi'      => Mobile\KeneksiFactory::class,
            'reeder'       => Mobile\ReederFactory::class,
            'globex'       => Mobile\GlobexFactory::class,
            'oukitel'      => Mobile\OukitelFactory::class,
            'itel'         => Mobile\ItelFactory::class,
            'wileyfox'     => Mobile\WileyfoxFactory::class,
            'morefine'     => Mobile\MorefineFactory::class,
            'vernee'       => Mobile\VerneeFactory::class,
            'iocean'       => Mobile\IoceanFactory::class,
        ];

        foreach ($factoriesBeforeXiaomi as $test => $factoryName) {
            if ($s->contains($test, false)) {
                /* @var Factory\FactoryInterface $factory */
                $factory = new $factoryName($this->loader);

                return $factory->detect($useragent, $s);
            }
        }

        if ($s->contains('BLU', true)) {
            return (new Mobile\BluFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('MTC', true)) {
            return (new Mobile\MtcFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('eSTAR', true)) {
            return (new Mobile\EstarFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['DARKMOON', 'DARKSIDE', 'DARKNIGHT'], true)) {
            return (new Mobile\WikoFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ARK', true)) {
            return (new Mobile\ArkFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Magic', true)) {
            return (new Mobile\MagicFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('XT811', true)) {
            return (new Mobile\FlipkartFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/XT\d{3,4}/', $useragent)) {
            return (new Mobile\MotorolaFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/M[Ii][ -](\d|PAD|MAX|NOTE|A1)/', $useragent)) {
            return (new Mobile\XiaomiFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/HM[ _](NOTE|1SC|1SW|1S)/', $useragent)) {
            return (new Mobile\XiaomiFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('WeTab', true)) {
            return (new Mobile\NeofonieFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('SIE-', true)) {
            return (new Mobile\SiemensFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('CAL21', true)) {
            return (new Mobile\CasioFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('g3mini', false)) {
            return (new Mobile\LgFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/P[CG]\d{5}/', $useragent)) {
            return (new Mobile\HtcFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/[AC]\d{5}/', $useragent)) {
            return (new Mobile\NomiFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/one e\d{4}/i', $useragent)) {
            return (new Mobile\OneplusFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/one a200[135]/i', $useragent)) {
            return (new Mobile\OneplusFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('HS-', true)) {
            return (new Mobile\HisenseFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['f5281', 'u972', 'e621t', 'eg680', 'e2281uk'], false)) {
            return (new Mobile\HisenseFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/TBD\d{4}/', $useragent)) {
            return (new Mobile\ZekiFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/TBD[BCG]\d{3,4}/', $useragent)) {
            return (new Mobile\ZekiFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(AC0732C|RC9724C|MT0739D|QS0716D|LC0720C|MT0812E)/', $useragent)) {
            return (new Mobile\TriQFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ImPAD6213M_v2', true)) {
            return (new Mobile\ImpressionFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('S4503Q', true)) {
            return (new Mobile\DnsFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('D6000', true)) {
            return (new Mobile\InnosFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/[SV]T\d{5}/', $useragent)) {
            return (new Mobile\TrekStorFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('c6730', false)) {
            return (new Mobile\KyoceraFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['p4501', 'p850x', 'e4004', 'e691x', 'p1050x', 'p1032x', 'p1040x', 's1035x', 'p1035x', 'p4502', 'p851x'], false)) {
            return (new Mobile\MedionFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['g6600'], false)) {
            return (new Mobile\HuaweiFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/DG\d{3,4}/', $useragent)) {
            return (new Mobile\DoogeeFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['Touchlet', 'X7G', 'X10.'], true)) {
            return (new Mobile\PearlFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/mpqc\d{3,4}/i', $useragent)) {
            return (new Mobile\MpmanFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['terra pad', 'pad1002'], false)) {
            return (new Mobile\WortmannFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/[CDEFG]\d{4}/', $useragent)) {
            return (new Mobile\SonyFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/PM\-\d{4}/', $useragent)) {
            return (new Mobile\SanyoFactory($this->loader))->detect($useragent, $s);
        }

        if (preg_match('/aqua[_ ]|cloud_m5_ii/i', $useragent)) {
            return (new Mobile\IntexFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('3Q', true)) {
            return (new Mobile\TriQFactory($this->loader))->detect($useragent, $s);
        }

        if ($s->contains('UMI', true)) {
            return (new Mobile\UmiFactory($this->loader))->detect($useragent, $s);
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

        if ($s->containsAny(['A1002', 'A811'], true)) {
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

        if ($s->containsAny(['FOLIO_AND_A', 'TOSHIBA_AC_AND_AZ', 'folio100'], false)) {
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
            ' v3 '            => Mobile\InewFactory::class,
            'smartphone650'   => Mobile\MasterFactory::class,
            'mx enjoy tv box' => Mobile\GeniatechFactory::class,
            'm5301'           => Mobile\IruFactory::class,
            'gv7777'          => Mobile\PrestigioFactory::class,
            ' n1 '       => Mobile\NokiaFactory::class,
            '5130c-2'    => Mobile\NokiaFactory::class,
            'lumia'      => Mobile\NokiaFactory::class,
            'arm; 909'   => Mobile\NokiaFactory::class,
            'id336'      => Mobile\NokiaFactory::class,
            'genm14'     => Mobile\NokiaFactory::class,
            'n900'       => Mobile\NokiaFactory::class,
            '9930i'      => Mobile\StarFactory::class,
            'n9100'      => Mobile\SamsungFactory::class,
            'n7100'      => Mobile\SamsungFactory::class,
            'm717r-hd'   => Mobile\VastKingFactory::class,
            'tm785m3'    => Mobile\NuVisionFactory::class,
            'm502'       => Mobile\NavonFactory::class,
            'lencm900hz' => Mobile\LencoFactory::class,
            'xm100'      => Mobile\LandvoFactory::class,
            'dm015k'     => Mobile\KyoceraFactory::class,
            'm370i'      => Mobile\InfocusFactory::class,
            'dm550'      => Mobile\BlackviewFactory::class,
            ' m8 '       => Mobile\AmlogicFactory::class,
            'm601'       => Mobile\AocFactory::class,
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

        if (preg_match('/RP\-UDM\d{2}/', $useragent)) {
            return (new Mobile\VericoFactory($this->loader))->detect($useragent, $s);
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

        $factoriesBeforeXiaomi = [
            '7007hd'    => Mobile\PerfeoFactory::class,
            'pt-gf200'  => Mobile\PantechFactory::class,
            'k-8s'      => Mobile\KeenerFactory::class,
            'h1+'       => Mobile\HummerFactory::class,
            'impress_l' => Mobile\VertexFactory::class,
            'neo-x5'      => Mobile\MinixFactory::class,
            'numy_note_9' => Mobile\AinolFactory::class,
            'novo7fire'   => Mobile\AinolFactory::class,
            'tab-97e-01'  => Mobile\ReellexFactory::class,
            'vega'        => Mobile\AdventFactory::class,
            'dream'       => Mobile\HtcFactory::class,
            ' x9 '        => Mobile\HtcFactory::class,
            'amaze'        => Mobile\HtcFactory::class,
            'butterfly2'   => Mobile\HtcFactory::class,
            ' xst2 '       => Mobile\FourgSystemsFactory::class,
            'netbox'       => Mobile\SonyFactory::class,
            ' x10 '        => Mobile\SonyFactory::class,
            ' e10i '       => Mobile\SonyFactory::class,
            ' x2 '         => Mobile\SonyFactory::class,
            'r800x'        => Mobile\SonyFactory::class,
            's500i'        => Mobile\SonyFactory::class,
            'x1i'          => Mobile\SonyFactory::class,
            'x10i'         => Mobile\SonyFactory::class,
            'tf300t'       => Mobile\AsusFactory::class,
            'f10x'         => Mobile\NextwayFactory::class,
            'adtab 7 lite' => Mobile\AdspecFactory::class,
            'neon-n1'      => Mobile\AxgioFactory::class,
            'wing-w2'      => Mobile\AxgioFactory::class,
            't118'         => Mobile\TwinovoFactory::class,
            't108'         => Mobile\TwinovoFactory::class,
            'touareg8_3g'  => Mobile\AccentFactory::class,
            'chagall'      => Mobile\PegatronFactory::class,
            'turbo x6'     => Mobile\TurboPadFactory::class,
            ' l52 '          => Mobile\HaierFactory::class,
            ' g30 '          => Mobile\HaierFactory::class,
            'pad g781'       => Mobile\HaierFactory::class,
            'air a70'        => Mobile\RoverPadFactory::class,
            'sp-6020 quasar' => Mobile\WooFactory::class,
            'q10s'           => Mobile\WopadFactory::class,
            'ctab785r16-3g'  => Mobile\CondorFactory::class,
            'pkt-301' => Mobile\CondorFactory::class,
            'uq785-m1bgv'    => Mobile\VericoFactory::class,
            'km-uqm11a'      => Mobile\VericoFactory::class,
            't9666-1'        => Mobile\TelsdaFactory::class,
            'n003'           => Mobile\NeoFactory::class,
            'h7100'          => Mobile\FeitengFactory::class,
            'x909'           => Mobile\OppoFactory::class,
            'r815'           => Mobile\OppoFactory::class,
            'r8106'          => Mobile\OppoFactory::class,
            'u705t'          => Mobile\OppoFactory::class,
            'find7'          => Mobile\OppoFactory::class,
            'a37f'           => Mobile\OppoFactory::class,
            'a33f'           => Mobile\OppoFactory::class,
            'r7f'            => Mobile\OppoFactory::class,
            'r7sf'           => Mobile\OppoFactory::class,
            'r7kf'           => Mobile\OppoFactory::class,
            'r7plusf'        => Mobile\OppoFactory::class,
            'x9006'          => Mobile\OppoFactory::class,
            'x9076'          => Mobile\OppoFactory::class,
            ' 1201 '         => Mobile\OppoFactory::class,
            'n1t'            => Mobile\OppoFactory::class,
            'r831k'          => Mobile\OppoFactory::class,
            'xda'            => Mobile\O2Factory::class,
            'kkt20'          => Mobile\LavaFactory::class,
            'pixelv1'        => Mobile\LavaFactory::class,
            'pixel v2+'      => Mobile\LavaFactory::class,
            ' x17 '          => Mobile\LavaFactory::class,
            'x1 atom'        => Mobile\LavaFactory::class,
            'x1 selfie'      => Mobile\LavaFactory::class,
            'x5 4g'          => Mobile\LavaFactory::class,
            'pulse'          => Mobile\TmobileFactory::class,
            'mytouch4g'      => Mobile\TmobileFactory::class,
            'ameo'           => Mobile\TmobileFactory::class,
            'garminfone'     => Mobile\TmobileFactory::class,
            'redmi'          => Mobile\XiaomiFactory::class,
            'note 4'         => Mobile\XiaomiFactory::class,
            '2014818'        => Mobile\XiaomiFactory::class,
            '2014813'        => Mobile\XiaomiFactory::class,
            '2014011'        => Mobile\XiaomiFactory::class,
            '2015562'        => Mobile\XiaomiFactory::class,
            'g009'           => Mobile\YxtelFactory::class,
            'picopad_s1'     => Mobile\AxiooFactory::class,
            'adi_5s'         => Mobile\ArtelFactory::class,
            'norma 2'        => Mobile\KeneksiFactory::class,
            'kc-s701'        => Mobile\KyoceraFactory::class,
            't880g'          => Mobile\EtulineFactory::class,
            'studio 5.5'     => Mobile\BluFactory::class,
            'studio xl 2'    => Mobile\BluFactory::class,
            'f3_pro'         => Mobile\DoogeeFactory::class,
            'y6_piano'       => Mobile\DoogeeFactory::class,
            'y6 max'         => Mobile\DoogeeFactory::class,
            ' t6 '           => Mobile\DoogeeFactory::class,
            'tab-970'        => Mobile\PrologyFactory::class,
            'a66a'           => Mobile\EvercossFactory::class,
            'n90fhdrk'       => Mobile\YuandaoFactory::class,
            'nova'           => Mobile\CatSoundFactory::class,
            'i545'           => Mobile\SamsungFactory::class,
            'discovery'      => Mobile\GeneralMobileFactory::class,
            't720'           => Mobile\MotorolaFactory::class,
            'n820'           => Mobile\AmoiFactory::class,
            'n90 dual core2' => Mobile\YuandaoFactory::class,
            'tpc-'           => Mobile\JaytechFactory::class,
            ' g9 '           => Mobile\MastoneFactory::class,
            'dl1'            => Mobile\PanasonicFactory::class,
            'eluga_arc_2'    => Mobile\PanasonicFactory::class,
            'zt180'          => Mobile\ZenithinkFactory::class,
            'e1107'          => Mobile\YusuFactory::class,
            'is05'           => Mobile\SharpFactory::class,
            'p4d sirius'     => Mobile\NvsblFactory::class,
            ' c2 '           => Mobile\ZopoFactory::class,
            'a0001'          => Mobile\OneplusFactory::class,
            'smartpad'       => Mobile\EinsUndEinsFactory::class,
            'n930'           => Mobile\CoolpadFactory::class,
            '8079'           => Mobile\CoolpadFactory::class,
            '5860s'          => Mobile\CoolpadFactory::class,
            'la-m1'          => Mobile\BeidouFactory::class,
            'i4901'          => Mobile\IdeaFactory::class,
            'lead 1'         => Mobile\LeagooFactory::class,
            'lead 2'         => Mobile\LeagooFactory::class,
            't1_plus'        => Mobile\LeagooFactory::class,
            'elite 4'        => Mobile\LeagooFactory::class,
            'elite 5'        => Mobile\LeagooFactory::class,
            'shark 1'        => Mobile\LeagooFactory::class,
            'v1_viper'       => Mobile\AllviewFactory::class,
            'a4you'          => Mobile\AllviewFactory::class,
            'p5_quad'        => Mobile\AllviewFactory::class,
            'x2_soul'        => Mobile\AllviewFactory::class,
            'ax4nano'        => Mobile\AllviewFactory::class,
            'x1_soul'        => Mobile\AllviewFactory::class,
            'forward_art'    => Mobile\NgmFactory::class,
            'gnet'           => Mobile\GnetFactory::class,
            'hive v 3g'      => Mobile\TurboxFactory::class,
            'hive iv 3g'     => Mobile\TurboxFactory::class,
            'turkcell'       => Mobile\TurkcellFactory::class,
            ' v1 '           => Mobile\MaxtronFactory::class,
            'l-ement500'     => Mobile\LogicomFactory::class,
            'is04'           => Mobile\KddiFactory::class,
            'be pro'         => Mobile\UlefoneFactory::class,
            'paris'          => Mobile\UlefoneFactory::class,
            'vienna'         => Mobile\UlefoneFactory::class,
            'u007'           => Mobile\UlefoneFactory::class,
            'future'         => Mobile\UlefoneFactory::class,
            'power_3'        => Mobile\UlefoneFactory::class,
            't1x plus'       => Mobile\AdvanFactory::class,
            'vandroid'       => Mobile\AdvanFactory::class,
            'sense golly'    => Mobile\IproFactory::class,
            'sirius_qs'      => Mobile\VoninoFactory::class,
            'dl 1803'        => Mobile\DlFactory::class,
            's10q-3g'        => Mobile\SmartbookFactory::class,
            'trekker-x1'     => Mobile\CrosscallFactory::class,
            ' s30 '          => Mobile\FireflyFactory::class,
            'apollo'         => Mobile\VerneeFactory::class,
            'thor'           => Mobile\VerneeFactory::class,
            '1505-a02'       => Mobile\ItelFactory::class,
            'mitab think'    => Mobile\WolderFactory::class,
            'pixel'          => Mobile\GoogleFactory::class,
            'gce x86 phone'  => Mobile\GoogleFactory::class,
            'glass 1'        => Mobile\GoogleFactory::class,
            '909t'           => Mobile\MpieFactory::class,
            ' m13 '          => Mobile\MpieFactory::class,
            'z30'            => Mobile\MagnusFactory::class,
            'up580'          => Mobile\UhappyFactory::class,
            'swift'          => Mobile\WileyfoxFactory::class,
            'm9c max'        => Mobile\BqeelFactory::class,
            'qt-10'          => Mobile\QmaxFactory::class,
            'ilium l820'     => Mobile\LanixFactory::class,
            's501m 3g'       => Mobile\FourGoodFactory::class,
            't700i_3g'       => Mobile\FourGoodFactory::class,
            'ixion_es255'    => Mobile\DexpFactory::class,
            'h135'           => Mobile\DexpFactory::class,
            'atl-21'         => Mobile\ArtizleeFactory::class,
            'w032i-c3'       => Mobile\IntelFactory::class,
            'tr10rs1'        => Mobile\IntelFactory::class,
            'tr10cd1'        => Mobile\IntelFactory::class,
            'cs24'           => Mobile\CyrusFactory::class,
            'cs25'           => Mobile\CyrusFactory::class,
            ' t02 '          => Mobile\ChanghongFactory::class,
            'crown'          => Mobile\BlackviewFactory::class,
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
            'trooper_x55'     => Mobile\KazamFactory::class,
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

        foreach ($factoriesBeforeXiaomi as $test => $factoryName) {
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
