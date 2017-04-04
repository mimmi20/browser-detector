<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory\Device;

use BrowserDetector\Factory;
use BrowserDetector\Loader\LoaderInterface;
use Psr\Cache\CacheItemPoolInterface;
use Stringy\Stringy;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class MobileFactory implements Factory\FactoryInterface
{
    /**
     * @var \Psr\Cache\CacheItemPoolInterface|null
     */
    private $cache = null;

    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \Psr\Cache\CacheItemPoolInterface       $cache
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(CacheItemPoolInterface $cache, LoaderInterface $loader)
    {
        $this->cache  = $cache;
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
    public function detect($useragent, Stringy $s = null)
    {
        if ($s->containsAny(['hiphone', 'v919'], false)) {
            return (new Mobile\HiPhoneFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['technisat', 'technipad', 'aqipad', 'techniphone'], false)) {
            return (new Mobile\TechnisatFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('navipad', false)) {
            return (new Mobile\TexetFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('medipad', false)) {
            return (new Mobile\BewatecFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('mipad', false)) {
            return (new Mobile\XiaomiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('nokia', false)) {
            return (new Mobile\NokiaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAll(['iphone', 'android'], false)
            && !$s->contains('windows phone', false)
        ) {
            return (new Mobile\XiangheFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAll(['iphone', 'linux'], false)) {
            return (new Mobile\XiangheFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAll(['iphone', 'adr', 'ucweb'], false)) {
            return (new Mobile\XiangheFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('samsung', false)) {
            return (new Mobile\SamsungFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('blackberry', false)) {
            return (new Mobile\BlackBerryFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['ipad', 'ipod', 'iphone', 'like mac os x'], false)
            && !$s->containsAny(['windows phone', ' adr ', 'ipodder', 'tripadvisor'], false)
        ) {
            return (new Mobile\AppleFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('asus', false)) {
            return (new Mobile\AsusFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('mt-gt-a9500', false)) {
            return (new Mobile\HtmFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('gt-a7100', false)) {
            return (new Mobile\SprdFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['feiteng', 'gt-h'], false)) {
            return (new Mobile\FeitengFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['cube', 'u30gt', 'u51gt', 'u55gt'], false)) {
            return (new Mobile\CubeFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('GTX75', true)) {
            return (new Mobile\UtStarcomFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('gt-9000', false)) {
            return (new Mobile\StarFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('u25gt-c4w', false)) {
            return (new Mobile\CubeFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('LG', true)) {
            return (new Mobile\LgFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(gt|sam|sc|sch|sec|sgh|shv|shw|sm|sph|continuum)\-/i', $useragent)) {
            return (new Mobile\SamsungFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['hdc', 'galaxy s3 ex'], false)) {
            return (new Mobile\HdcFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/nexus ?(4|5)/i', $useragent)) {
            return (new Mobile\LgFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['nexus 7', 'nexus_7', 'nexus7'], false)) {
            return (new Mobile\AsusFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('nexus 6p', false)) {
            return (new Mobile\HuaweiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('nexus 6', false)) {
            return (new Mobile\MotorolaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['nexus one', 'nexus 9'], false)) {
            return (new Mobile\HtcFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['nexus evohd2', 'nexushd2'], false)) {
            return (new Mobile\HtcFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('pantech', false)) {
            return (new Mobile\PantechFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['hp', 'p160u', 'touchpad', 'pixi', 'palm', 'blazer', 'cm_tenderloin'], false)) {
            return (new Mobile\HpFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['galaxy', 'nexus', 'i7110', 'i9100', 'i9300', 'yp-g', 'blaze'], false)) {
            return (new Mobile\SamsungFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('sony', false)) {
            return (new Mobile\SonyFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('twinovo', false)) {
            return (new Mobile\TwinovoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('CCE', true)) {
            return (new Mobile\CceFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('htc', false)
            && !$s->contains('WOHTC', false)
        ) {
            return (new Mobile\HtcFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['SmartTab10', 'SmartTab7', 'Smart 4G'], true)) {
            return (new Mobile\ZteFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['lenovo', 'ideatab', 'ideapad', 'smarttab', 'thinkpad'], false)) {
            return (new Mobile\LenovoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['zte', 'racer'], false)) {
            return (new Mobile\ZteFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['acer', 'iconia', 'liquid'], false)) {
            return (new Mobile\AcerFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('playstation', false)) {
            return (new Mobile\SonyFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['amazon', 'kindle', 'silk', 'kftt', 'kfot', 'kfjwi', 'kfsowi', 'kfthwi', 'sd4930ur', 'kfapwa'], false)) {
            return (new Mobile\AmazonFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('amoi', false)) {
            return (new Mobile\AmoiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['blaupunkt', 'endeavour'], false)) {
            return (new Mobile\BlaupunktFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ONDA', true)) {
            return (new Mobile\OndaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('archos', false)) {
            return (new Mobile\ArchosFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('IRULU', true)) {
            return (new Mobile\IruluFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('spice', false)) {
            return (new Mobile\SpiceFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Symphony', true)) {
            return (new Mobile\SymphonyFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('arnova', false)) {
            return (new Mobile\ArnovaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' bn ', false)) {
            return (new Mobile\BarnesNobleFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('beidou', false)) {
            return (new Mobile\BeidouFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['playbook', 'rim tablet', 'bb10'], false)) {
            return (new Mobile\BlackBerryFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('caterpillar', false)) {
            return (new Mobile\CaterpillarFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('B15', true)) {
            return (new Mobile\CaterpillarFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['catnova', 'cat nova', 'cat stargate', 'cat tablet'], false)) {
            return (new Mobile\CatSoundFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['coby', 'nbpc724'], false)) {
            return (new Mobile\CobyFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/MID\d{4}/', $useragent)) {
            return (new Mobile\CobyFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/WM\d{4}/', $useragent)) {
            return (new Mobile\WonderMediaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['comag', 'wtdr1018'], false)) {
            return (new Mobile\ComagFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('coolpad', false)) {
            return (new Mobile\CoolpadFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('cosmote', false)) {
            return (new Mobile\CosmoteFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['creative', 'ziilabs'], false)) {
            return (new Mobile\CreativeFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('cubot', false)) {
            return (new Mobile\CubotFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('dell', false)) {
            return (new Mobile\DellFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['denver', 'tad-'], false)) {
            return (new Mobile\DenverFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('CONNECT7PRO', true)) {
            return (new Mobile\OdysFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('nec', false) && !$s->contains('fennec', false)) {
            return (new Mobile\NecFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('SHARP', true)) {
            return (new Mobile\SharpFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/\d{3}SH/', $useragent)) {
            return (new Mobile\SharpFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/SH\-?\d{2,4}(C|D|F|U)/', $useragent)) {
            return (new Mobile\SharpFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['n-06e', 'n905i', 'n705i'], false)) {
            return (new Mobile\NecFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['docomo', 'p900i'], false)) {
            return (new Mobile\DoCoMoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['easypix', 'easypad', 'junior 4.0'], false)) {
            return (new Mobile\EasypixFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['Efox', 'SMART-E5'], true)) {
            return (new Mobile\EfoxFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('1 & 1', false)) {
            return (new Mobile\EinsUndEinsFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['xoro', 'telepad 9a1'], false)) {
            return (new Mobile\XoroFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['epad', 'p7901a'], false)) {
            return (new Mobile\EpadFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('p7mini', false)) {
            return (new Mobile\HuaweiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('faktorzwei', false)) {
            return (new Mobile\FaktorZweiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('flytouch', false)) {
            return (new Mobile\FlytouchFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['fujitsu', 'm532'], false)) {
            return (new Mobile\FujitsuFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('sn10t1', false)) {
            return (new Mobile\HannspreeFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('DA241HL', true)) {
            return (new Mobile\AcerFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['Honlin', 'PC1088', 'HL'], true)) {
            return (new Mobile\HonlinFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('huawei', false)) {
            return (new Mobile\HuaweiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('micromax', false)) {
            return (new Mobile\MicromaxFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('triray', false)) {
            return (new Mobile\TrirayFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('SXZ', true)) {
            return (new Mobile\SxzFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('explay', false)) {
            return (new Mobile\ExplayFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('pmedia', false)) {
            return (new Mobile\PmediaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('impression', false)) {
            return (new Mobile\ImpressionFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('oneplus', false)) {
            return (new Mobile\OneplusFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('kingzone', false)) {
            return (new Mobile\KingzoneFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('gzone', false)) {
            return (new Mobile\GzoneFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('goophone', false)) {
            return (new Mobile\GooPhoneFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('g-tide', false)) {
            return (new Mobile\GtideFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('reellex', false)) {
            return (new Mobile\ReellexFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['turbopad', 'turbo pad'], false)) {
            return (new Mobile\TurboPadFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('haier', false)) {
            return (new Mobile\HaierFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('sunstech', false)) {
            return (new Mobile\SunstechFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('AOC', true)) {
            return (new Mobile\AocFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('hummer', false)) {
            return (new Mobile\HummerFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('oysters', false)) {
            return (new Mobile\OystersFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('vertex', false)) {
            return (new Mobile\VertexFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('gfive', false)) {
            return (new Mobile\GfiveFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('iconbit', false)) {
            return (new Mobile\IconBitFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('intenso', false)) {
            return (new Mobile\IntensoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/INM\d{3,4}/', $useragent)) {
            return (new Mobile\IntensoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ionik', false)) {
            return (new Mobile\IonikFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('JAY-tech', false)) {
            return (new Mobile\JaytechFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['jolla', 'sailfish'], false)) {
            return (new Mobile\JollaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('kazam', false)) {
            return (new Mobile\KazamFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('kddi', false)) {
            return (new Mobile\KddiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('kobo touch', false)) {
            return (new Mobile\KoboFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('lenco', false)) {
            return (new Mobile\LencoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('LePan', true)) {
            return (new Mobile\LePanFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['LogicPD', 'Zoom2', 'NookColor'], true)) {
            return (new Mobile\LogicpdFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['medion', 'lifetab'], false)) {
            return (new Mobile\MedionFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('meizu', false)) {
            return (new Mobile\MeizuFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('hisense', false)) {
            return (new Mobile\HisenseFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('minix', false)) {
            return (new Mobile\MinixFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('allwinner', false)) {
            return (new Mobile\AllWinnerFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('accent', false)) {
            return (new Mobile\AccentFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('yota', false)) {
            return (new Mobile\YotaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ainol', false)) {
            return (new Mobile\AinolFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('supra', false)) {
            return (new Mobile\SupraFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('nextway', false)) {
            return (new Mobile\NextwayFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('amlogic', false)) {
            return (new Mobile\AmlogicFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('adspec', false)) {
            return (new Mobile\AdspecFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('m-way', false)) {
            return (new Mobile\MwayFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('memup', false)) {
            return (new Mobile\MemupFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('prestigio', false)) {
            return (new Mobile\PrestigioFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('xiaomi', false)) {
            return (new Mobile\XiaomiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/MI (\d|PAD|MAX)/', $useragent)) {
            return (new Mobile\XiaomiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/HM( |\_)(NOTE|1SC|1SW)/', $useragent)) {
            return (new Mobile\XiaomiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/miui/i', $useragent)
            && !preg_match('/miuibrowser/i', $useragent)
            && !preg_match('/build\/miui/i', $useragent)
        ) {
            return (new Mobile\MiuiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['mobistel', 'cynus'], false)) {
            return (new Mobile\MobistelFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('moto', false)) {
            return (new Mobile\MotorolaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('WeTab', true)) {
            return (new Mobile\NeofonieFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Nextbook', true)) {
            return (new Mobile\NextbookFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('nintendo', false)) {
            return (new Mobile\NintendoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Nvsbl', true)) {
            return (new Mobile\NvsblFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('odys', false)) {
            return (new Mobile\OdysFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('oppo', false)) {
            return (new Mobile\OppoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('panasonic', false)) {
            return (new Mobile\PanasonicFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('pandigital', false)) {
            return (new Mobile\PandigitalFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('phicomm', false)) {
            return (new Mobile\PhicommFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('pipo', false)) {
            return (new Mobile\PipoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('pomp', false)) {
            return (new Mobile\PompFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('qmobile', false)) {
            return (new Mobile\QmobileFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('keener', false)) {
            return (new Mobile\KeenerFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('sanyo', false)) {
            return (new Mobile\SanyoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('siemens', false)) {
            return (new Mobile\SiemensFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('SIE-', true)) {
            return (new Mobile\SiemensFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('sprint', false)) {
            return (new Mobile\SprintFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('intex', false)) {
            return (new Mobile\IntexFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('CAL21', true)) {
            return (new Mobile\GzoneFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(A|C)\d{5}/', $useragent)) {
            return (new Mobile\NomiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('one e1003', false)) {
            return (new Mobile\OneplusFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/one a200(1|3|5)/i', $useragent)) {
            return (new Mobile\OneplusFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('F5281', true)) {
            return (new Mobile\HisenseFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('MOT', true)) {
            return (new Mobile\MotorolaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/TBD\d{4}/', $useragent)) {
            return (new Mobile\ZekiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/TBD(B|C|G)\d{3,4}/', $useragent)) {
            return (new Mobile\ZekiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(AC0732C|RC9724C|MT0739D|QS0716D|LC0720C|MT0812E)/', $useragent)) {
            return (new Mobile\TriQFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ImPAD6213M_v2', true)) {
            return (new Mobile\ImpressionFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('S4503Q', true)) {
            return (new Mobile\DnsFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('dns', false)) {
            return (new Mobile\DnsFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('D6000', true)) {
            return (new Mobile\InnosFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(S|V)T\d{5}/', $useragent)) {
            return (new Mobile\TrekStorFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ONE E\d{4}/', $useragent)) {
            return (new Mobile\HtcFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(C|D|E|F)\d{4}/', $useragent)) {
            return (new Mobile\SonyFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Aqua_Star', true)) {
            return (new Mobile\IntexFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Star', true)) {
            return (new Mobile\StarFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('texet', false)) {
            return (new Mobile\TexetFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('condor', false)) {
            return (new Mobile\CondorFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('s-tell', false)) {
            return (new Mobile\StellFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('verico', false)) {
            return (new Mobile\VericoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ruggear', false)) {
            return (new Mobile\RugGearFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('telsda', false)) {
            return (new Mobile\TelsdaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('mitashi', false)) {
            return (new Mobile\MitashiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('bliss', false)) {
            return (new Mobile\BlissFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('lexand', false)) {
            return (new Mobile\LexandFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('alcatel', false)) {
            return (new Mobile\AlcatelFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/thl/i', $useragent) && !preg_match('/LIAuthLibrary/', $useragent)) {
            return (new Mobile\ThlFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('SPV', true)) {
            return (new Mobile\SpvFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('t-mobile', false)) {
            return (new Mobile\TmobileFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('tolino', false)) {
            return (new Mobile\TolinoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('toshiba', false)) {
            return (new Mobile\ToshibaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('trekstor', false)) {
            return (new Mobile\TrekStorFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('3Q', true)) {
            return (new Mobile\TriQFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['viewsonic', 'viewpad'], false)) {
            return (new Mobile\ViewSonicFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('wiko', false)) {
            return (new Mobile\WikoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('VIVO IV', true)) {
            return (new Mobile\BluFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('vivo', false)) {
            return (new Mobile\VivoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('haipai', false)) {
            return (new Mobile\HaipaiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('megafon', false)) {
            return (new Mobile\MegaFonFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('UMI', true)) {
            return (new Mobile\UmiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('yuandao', false)) {
            return (new Mobile\YuandaoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('yuanda', false)) {
            return (new Mobile\YuandaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Yusu', true)) {
            return (new Mobile\YusuFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('zenithink', false)) {
            return (new Mobile\ZenithinkFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/Fly/', $useragent) && !preg_match('/FlyFlow/', $useragent)) {
            return (new Mobile\FlyFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('pocketbook', false)) {
            return (new Mobile\PocketBookFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('geniatech', false)) {
            return (new Mobile\GeniatechFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('yarvik', false)) {
            return (new Mobile\YarvikFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('goclever', false)) {
            return (new Mobile\GoCleverFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('senseit', false)) {
            return (new Mobile\SenseitFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('twz', false)) {
            return (new Mobile\TwzFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('irbis', false)) {
            return (new Mobile\IrbisFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('i-mobile', false)) {
            return (new Mobile\ImobileFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('axioo', false)) {
            return (new Mobile\AxiooFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('artel', false)) {
            return (new Mobile\ArtelFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('sunup', false)) {
            return (new Mobile\SunupFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('evercoss', false)) {
            return (new Mobile\EvercossFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('NGM', true)) {
            return (new Mobile\NgmFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('dino', false)) {
            return (new Mobile\DinoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['shaan', 'iball'], false)) {
            return (new Mobile\ShaanFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/bmobile/i', $useragent) && !preg_match('/icabmobile/i', $useragent)) {
            return (new Mobile\BmobileFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('modecom', false)) {
            return (new Mobile\ModecomFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('overmax', false)) {
            return (new Mobile\OvermaxFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('kiano', false)) {
            return (new Mobile\KianoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('manta', false)) {
            return (new Mobile\MantaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('philips', false)) {
            return (new Mobile\PhilipsFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('shiru', false)) {
            return (new Mobile\ShiruFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('tb touch', false)) {
            return (new Mobile\TbTouchFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('NTT', true)) {
            return (new Mobile\NttSystemFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('pentagram', false)) {
            return (new Mobile\PentagramFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('zeki', false)) {
            return (new Mobile\ZekiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['Z221', 'V788D', 'KIS PLUS', 'NX402', 'NX501', 'N918St', 'Beeline Pro', 'ATLAS_W', 'BASE Tab', 'X920', ' V9 '], true)) {
            return (new Mobile\ZteFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['lutea'], false)) {
            return (new Mobile\ZteFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('beeline', false)) {
            return (new Mobile\BeelineFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('dfunc', false)) {
            return (new Mobile\DfuncFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('digma', false)) {
            return (new Mobile\DigmaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('axgio', false)) {
            return (new Mobile\AxgioFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('roverpad', false)) {
            return (new Mobile\RoverPadFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('zopo', false)) {
            return (new Mobile\ZopoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ultrafone', false)) {
            return (new Mobile\UltrafoneFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('malata', false)) {
            return (new Mobile\MalataFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('starway', false)) {
            return (new Mobile\StarwayFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('pegatron', false)) {
            return (new Mobile\PegatronFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('logicom', false)) {
            return (new Mobile\LogicomFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('gigabyte', false)) {
            return (new Mobile\GigabyteFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('qumo', false)) {
            return (new Mobile\QumoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('perfeo', false)) {
            return (new Mobile\PerfeoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('yxtel', false)) {
            return (new Mobile\YxtelFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('doogee', false)) {
            return (new Mobile\DoogeeFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('xianghe', false)) {
            return (new Mobile\XiangheFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('celkon', false)) {
            return (new Mobile\CelkonFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('bravis', false)) {
            return (new Mobile\BravisFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('fnac', false)) {
            return (new Mobile\FnacFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('etuline', false)) {
            return (new Mobile\EtulineFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('tcl', false)) {
            return (new Mobile\TclFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('radxa', false)) {
            return (new Mobile\RadxaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('kyocera', false)) {
            return (new Mobile\KyoceraFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('prology', false)) {
            return (new Mobile\PrologyFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('assistant', false)) {
            return (new Mobile\AssistantFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' mt791 ', false)) {
            return (new Mobile\KeenHighFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['g100w', 'stream-s110'], false)) {
            return (new Mobile\AcerFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ (a1|a3|b1)\-/i', $useragent)) {
            return (new Mobile\AcerFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['wildfire', 'desire'], false)) {
            return (new Mobile\HtcFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['a101it', 'a7eb', 'a70bht', 'a70cht', 'a70hb', 'a70s', 'a80ksc'], false)) {
            return (new Mobile\ArchosFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['sprd', 'SPHS', 'B51+'], false)) {
            return (new Mobile\SprdFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('TAB A742', true)) {
            return (new Mobile\WexlerFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('A400', true)) {
            return (new Mobile\CelkonFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('A5000', true)) {
            return (new Mobile\SonyFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['A101', 'A500'], true)) {
            return (new Mobile\AcerFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['A1002', 'A811'], true)) {
            return (new Mobile\LexandFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['A120', 'A116', 'A114', 'A093', 'A065'], true)) {
            return (new Mobile\MicromaxFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('S208', true)) {
            return (new Mobile\CubotFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ (a|e|v|z|s)\d{3} /i', $useragent)) {
            return (new Mobile\AcerFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('wolgang', false)) {
            return (new Mobile\WolgangFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('AT-AS40SE', true)) {
            return (new Mobile\WolgangFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('AT1010-T', true)) {
            return (new Mobile\LenovoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('united', false)) {
            return (new Mobile\UnitedFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('MT6515M', true)) {
            return (new Mobile\UnitedFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('utstarcom', false)) {
            return (new Mobile\UtStarcomFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('fairphone', false)) {
            return (new Mobile\FairphoneFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('FP1', true)) {
            return (new Mobile\FairphoneFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('videocon', false)) {
            return (new Mobile\VideoconFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('A15', true)) {
            return (new Mobile\VideoconFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('mastone', false)) {
            return (new Mobile\MastoneFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('BLU', true)) {
            return (new Mobile\BluFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('nuqleo', false)) {
            return (new Mobile\NuqleoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ritmix', false)) {
            return (new Mobile\RitmixFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('wexler', false)) {
            return (new Mobile\WexlerFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('exeq', false)) {
            return (new Mobile\ExeqFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ergo', false)) {
            return (new Mobile\ErgoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('pulid', false)) {
            return (new Mobile\PulidFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('dexp', false)) {
            return (new Mobile\DexpFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('dex', false)) {
            return (new Mobile\DexFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('keneksi', false)) {
            return (new Mobile\KeneksiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('gionee', false)) {
            return (new Mobile\GioneeFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('highscreen', false)) {
            return (new Mobile\HighscreenFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('reeder', false)) {
            return (new Mobile\ReederFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('nomi', false)) {
            return (new Mobile\NomiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('globex', false)) {
            return (new Mobile\GlobexFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('AIS', true)) {
            return (new Mobile\AisFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ciotcud', false)) {
            return (new Mobile\CiotcudFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('iNew', true)) {
            return (new Mobile\InewFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('intego', false)) {
            return (new Mobile\IntegoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('MTC', true)) {
            return (new Mobile\MtcFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['DARKMOON', 'DARKSIDE', 'CINK PEAX 2', 'JERRY', 'BLOOM', 'SLIDE2', 'LENNY', 'GETAWAY', 'RAINBOW'], true)) {
            return (new Mobile\WikoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ARK', true)) {
            return (new Mobile\ArkFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Magic', true)) {
            return (new Mobile\MagicFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('BQS', true)) {
            return (new Mobile\BqFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/BQ \d{4}/', $useragent)) {
            return (new Mobile\BqFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('aquaris', false)) {
            return (new Mobile\BqFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/msi/i', $useragent) && !preg_match('/msie/i', $useragent)) {
            return (new Mobile\MsiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Orange', true)) {
            return (new Mobile\OrangeFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('vastking', false)) {
            return (new Mobile\VastKingFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('wopad', false)) {
            return (new Mobile\WopadFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('anka', false)) {
            return (new Mobile\AnkaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ktouch', false)) {
            return (new Mobile\KtouchFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('lemon', false)) {
            return (new Mobile\LemonFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('lava', false)) {
            return (new Mobile\LavaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('velocity', false)) {
            return (new Mobile\VelocityMicroFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('myTAB', true)) {
            return (new Mobile\MytabFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['loox', 'uno_x10', 'xelio', 'neo_quad10', 'ieos_quad', 'sky plus', 'maven_10_plus', 'space10_plus_3g', 'adm816', 'noon', 'xpress'], false)) {
            return (new Mobile\OdysFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/iPh\d\,\d/', $useragent)) {
            return (new Mobile\AppleFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/Puffin\/[\d\.]+I(T|P)/', $useragent)) {
            return (new Mobile\AppleFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('dataaccessd', false)) {
            return (new Mobile\AppleFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/Pre/', $useragent) && !preg_match('/Presto/', $useragent)) {
            return (new Mobile\HpFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ME\d{3}[A-Z]/', $useragent)) {
            return (new Mobile\AsusFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['padfone', 'transformer', 'slider sl101'], false)) {
            return (new Mobile\AsusFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(K|P)0(0|1)[0-9a-zA-Z]/', $useragent)) {
            return (new Mobile\AsusFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('tesla', false)) {
            return (new Mobile\TeslaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('QtCarBrowser', true)) {
            return (new Mobile\TeslaMotorsFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/M(B|Z)\d{3}/', $useragent)) {
            return (new Mobile\MotorolaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/WX\d{3}/', $useragent)) {
            return (new Mobile\MotorolaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('smart tab', false)) {
            return (new Mobile\LenovoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('onetouch', false)) {
            return (new Mobile\AlcatelFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('mtech', false)) {
            return (new Mobile\MtechFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['v860', 'vodafone smart II', 'vodafone 975n'], false)) {
            return (new Mobile\AlcatelFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('vodafone smart 4g', false)) {
            return (new Mobile\ZteFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('vodafone smart tab iii 7', false)) {
            return (new Mobile\LenovoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/one (s|x)/i', $useragent) && !preg_match('/vodafone smart/i', $useragent)) {
            return (new Mobile\HtcFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['tablet-pc-4', 'kinder-tablet'], false)) {
            return (new Mobile\OdysFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/OP\d{3}/', $useragent)) {
            return (new Mobile\OlivettiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/SGP\d{3}/', $useragent)) {
            return (new Mobile\SonyFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/sgpt\d{2}/i', $useragent)) {
            return (new Mobile\SonyFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('xperia', false)) {
            return (new Mobile\SonyFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/VS\d{3}/', $useragent)) {
            return (new Mobile\LgFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['surftab', 'vt10416', 'breeze 10.1 quad'], false)) {
            return (new Mobile\TrekStorFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/AT\d{2,3}/', $useragent)) {
            return (new Mobile\ToshibaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['FOLIO_AND_A', 'TOSHIBA_AC_AND_AZ', 'folio100'], false)) {
            return (new Mobile\ToshibaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['PAP', 'PMP', 'PMT'], true)) {
            return (new Mobile\PrestigioFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['APA9292KT', 'PJ83100', '831C', 'Evo 3D GSM', 'Eris 2.1'], true)) {
            return (new Mobile\HtcFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/adr\d{4}/i', $useragent)) {
            return (new Mobile\HtcFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['NEXT', 'DATAM803HC'], true)) {
            return (new Mobile\NextbookFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/XT\d{3,4}/', $useragent)) {
            return (new Mobile\MotorolaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny([' droid', 'milestone', 'xoom'], false)) {
            return (new Mobile\MotorolaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/MT\d{4}/', $useragent)) {
            return (new Mobile\CubotFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/(S|L|W|M)T\d{2}/', $useragent)) {
            return (new Mobile\SonyFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/SK\d{2}/', $useragent)) {
            return (new Mobile\SonyFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/SO\-\d{2}(B|C|D|E)/', $useragent)) {
            return (new Mobile\SonyFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('L50u', true)) {
            return (new Mobile\SonyFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('NOOK', true)) {
            return (new Mobile\BarnesNobleFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Zaffire', true)) {
            return (new Mobile\NuqleoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/BNRV\d{3}/', $useragent)) {
            return (new Mobile\BarnesNobleFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/IQ\d{3,4}/', $useragent)) {
            return (new Mobile\FlyFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Phoenix 2', true)) {
            return (new Mobile\FlyFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('VTAB1008', true)) {
            return (new Mobile\VizioFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('TAB10-400', true)) {
            return (new Mobile\YarvikFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/TQ\d{3}/', $useragent)) {
            return (new Mobile\GoCleverFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/RMD\-\d{3,4}/', $useragent)) {
            return (new Mobile\RitmixFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['TERRA_101', 'ORION7o'], true)) {
            return (new Mobile\GoCleverFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/AX\d{3}/', $useragent)) {
            return (new Mobile\BmobileFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/FreeTAB \d{4}/', $useragent)) {
            return (new Mobile\ModecomFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Venue', true)) {
            return (new Mobile\DellFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('FunTab', true)) {
            return (new Mobile\OrangeFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['OV-', 'Solution 7III'], true)) {
            return (new Mobile\OvermaxFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Zanetti', true)) {
            return (new Mobile\KianoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/MID\d{3}/', $useragent)) {
            return (new Mobile\MantaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('FWS610_EU', true)) {
            return (new Mobile\PhicommFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('FX2', true)) {
            return (new Mobile\FaktorZweiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/AN\d{1,2}/', $useragent)) {
            return (new Mobile\ArnovaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ARCHM\d{3}/', $useragent)) {
            return (new Mobile\ArnovaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['Touchlet', 'X7G', 'X10.Dual'], true)) {
            return (new Mobile\PearlFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['POV', 'TAB-PROTAB'], true)) {
            return (new Mobile\PointOfViewFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/PI\d{4}/', $useragent)) {
            return (new Mobile\PhilipsFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('SM - ', true)) {
            return (new Mobile\SamsungFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('SAMURAI10', true)) {
            return (new Mobile\ShiruFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Ignis 8', true)) {
            return (new Mobile\TbTouchFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('A5000', true)) {
            return (new Mobile\SonyFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('FUNC', true)) {
            return (new Mobile\DfuncFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/iD(j|n|s|x|r)(D|Q)\d{1,2}/', $useragent)) {
            return (new Mobile\DigmaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['P1032X', 'P1050X', 'K910L', ' K1 ', ' A1', ' A65 '], true)) {
            return (new Mobile\LenovoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('TAB7iD', true)) {
            return (new Mobile\WexlerFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ZP\d{3}/', $useragent)) {
            return (new Mobile\ZopoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/s450\d/i', $useragent)) {
            return (new Mobile\DnsFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('MB40II1', false)) {
            return (new Mobile\DnsFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' M3 ', true)) {
            return (new Mobile\GioneeFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['W100', 'W200', 'W8_beyond'], true)) {
            return (new Mobile\ThlFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/NT\-\d{4}(S|P|T|M)/', $useragent)) {
            return (new Mobile\IconBitFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Primo76', true)) {
            return (new Mobile\MsiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/T(X|G)\d{2}/', $useragent)) {
            return (new Mobile\IrbisFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/YD\d{3}/', $useragent)) {
            return (new Mobile\YotaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('X-pad', true)) {
            return (new Mobile\TexetFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/TM\-\d{4}/', $useragent)) {
            return (new Mobile\TexetFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/OK\d{3}/', $useragent)) {
            return (new Mobile\SunupFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny([' G3 ', 'P509'], true)) {
            return (new Mobile\LgFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['zera f', 'zera_f', 'boost iise', 'ice2', 'prime s', 'explosion'], false)) {
            return (new Mobile\HighscreenFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('iris708', true)) {
            return (new Mobile\AisFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('L930', true)) {
            return (new Mobile\CiotcudFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('SMART Run', true)) {
            return (new Mobile\MtcFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('X8+', true)) {
            return (new Mobile\TrirayFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['Surfer 7.34', 'M1_Plus', 'D7.2 3G'], true)) {
            return (new Mobile\ExplayFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Art 3G', true)) {
            return (new Mobile\ExplayFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('PMSmart450', true)) {
            return (new Mobile\PmediaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['F031', 'SCL24', 'ACE'], true)) {
            return (new Mobile\SamsungFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ImPAD', true)) {
            return (new Mobile\ImpressionFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('K1 turbo', true)) {
            return (new Mobile\KingzoneFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('TAB917QC-8GB', true)) {
            return (new Mobile\SunstechFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('TAB785DUAL', true)) {
            return (new Mobile\SunstechFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['TPC-PA10.1M', 'M7T', 'P93G', 'i75', 'M83g', ' M6 ', 'M6pro', 'M9pro'], true)) {
            return (new Mobile\PipoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('ONE TOUCH', true)) {
            return (new Mobile\AlcatelFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['6036Y', '4034D', '5042D'], true)) {
            return (new Mobile\AlcatelFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('MD948G', true)) {
            return (new Mobile\MwayFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('P4501', true)) {
            return (new Mobile\MedionFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' V3 ', true)) {
            return (new Mobile\InewFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/PX\-\d{4}/', $useragent)) {
            return (new Mobile\IntegoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Smartphone650', true)) {
            return (new Mobile\MasterFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('MX Enjoy TV BOX', true)) {
            return (new Mobile\GeniatechFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('A1000s', true)) {
            return (new Mobile\XoloFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('P3000', true)) {
            return (new Mobile\ElephoneFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('M5301', true)) {
            return (new Mobile\IruFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' C7 ', true)) {
            return (new Mobile\CubotFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('GV7777', true)) {
            return (new Mobile\PrestigioFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' N1 ', true)) {
            return (new Mobile\NokiaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/RM\-\d{3,4}/', $useragent) && !preg_match('/(nokia|microsoft)/i', $useragent)) {
            return (new Mobile\RossMoorFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/RM\-\d{3,4}/', $useragent)) {
            return (new Mobile\NokiaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['5130c-2', 'lumia', 'arm; 909', 'id336', 'genm14'], false)) {
            return (new Mobile\NokiaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('N8000D', true)) {
            return (new Mobile\SamsungFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/N\d{4}/', $useragent)) {
            return (new Mobile\StarFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['Rio R1', 'GSmart_T4'], true)) {
            return (new Mobile\GigabyteFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('7007HD', true)) {
            return (new Mobile\PerfeoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('PT-GF200', true)) {
            return (new Mobile\PantechFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/IM\-A\d{3}(L|K)/', $useragent)) {
            return (new Mobile\PantechFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('K-8S', true)) {
            return (new Mobile\KeenerFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('M601', true)) {
            return (new Mobile\AocFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('H1+', true)) {
            return (new Mobile\HummerFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Pacific800i', true)) {
            return (new Mobile\OystersFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Impress_L', true)) {
            return (new Mobile\VertexFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['M040', 'MZ-MX5'], true)) {
            return (new Mobile\MeizuFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('NEO-X5', true)) {
            return (new Mobile\MinixFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Numy_Note_9', true)) {
            return (new Mobile\AinolFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Novo7Fire', true)) {
            return (new Mobile\AinolFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('TAB-97E-01', true)) {
            return (new Mobile\ReellexFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('vega', false)) {
            return (new Mobile\AdventFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['dream', ' x9 ', 'x315e', 'z715e'], false)) {
            return (new Mobile\HtcFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['netbox', ' x10 ', ' e10i ', ' xst2 ', ' x2 '], false)) {
            return (new Mobile\SonyFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('F10X', true)) {
            return (new Mobile\NextwayFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' M8 ', true)) {
            return (new Mobile\AmlogicFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/SPX\-\d/', $useragent)) {
            return (new Mobile\SimvalleyFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('AdTab 7 Lite', true)) {
            return (new Mobile\AdspecFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('PS1043MG', true)) {
            return (new Mobile\DigmaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('TT7026MW', true)) {
            return (new Mobile\DigmaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['Neon-N1', 'WING-W2'], true)) {
            return (new Mobile\AxgioFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['T108', 'T118'], true)) {
            return (new Mobile\TwinovoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains(' A10', true)) {
            return (new Mobile\AllWinnerFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('TOUAREG8_3G', true)) {
            return (new Mobile\AccentFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('chagall', false)) {
            return (new Mobile\PegatronFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Turbo X6', true)) {
            return (new Mobile\TurboPadFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('HW-W718', true)) {
            return (new Mobile\HaierFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Air A70', true)) {
            return (new Mobile\RoverPadFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('SP-6020 QUASAR', true)) {
            return (new Mobile\WooFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('M717R-HD', true)) {
            return (new Mobile\VastKingFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Q10S', true)) {
            return (new Mobile\WopadFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('CTAB785R16-3G', true)) {
            return (new Mobile\CondorFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/RP\-UDM\d{2}/', $useragent)) {
            return (new Mobile\VericoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['UQ785-M1BGV', 'KM-UQM11A'], true)) {
            return (new Mobile\VericoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('RG500', true)) {
            return (new Mobile\RugGearFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('T9666-1', true)) {
            return (new Mobile\TelsdaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('N003', true)) {
            return (new Mobile\NeoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('AP-105', true)) {
            return (new Mobile\MitashiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('H7100', true)) {
            return (new Mobile\FeitengFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('x909', true)) {
            return (new Mobile\OppoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('R815', true)) {
            return (new Mobile\OppoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('xda', false)) {
            return (new Mobile\O2Factory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('TIANYU', true)) {
            return (new Mobile\KtouchFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('KKT20', true)) {
            return (new Mobile\LavaFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['MDA', 'Pulse', 'myTouch4G'], true)) {
            return (new Mobile\TmobileFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('redmi', false)) {
            return (new Mobile\XiaomiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('G009', true)) {
            return (new Mobile\YxtelFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/DG\d{3,4}/', $useragent)) {
            return (new Mobile\DoogeeFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['H30-U10', 'KIW-L21', 'IDEOS S7', 'U8500', 'vodafone 858'], false)) {
            return (new Mobile\HuaweiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('PICOpad_S1', true)) {
            return (new Mobile\AxiooFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Adi_5S', true)) {
            return (new Mobile\ArtelFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Norma 2', true)) {
            return (new Mobile\KeneksiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('DM015K', true)) {
            return (new Mobile\KyoceraFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('KC-S701', true)) {
            return (new Mobile\KyoceraFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('T880G', true)) {
            return (new Mobile\EtulineFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('STUDIO 5.5', true)) {
            return (new Mobile\BluFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('F3_Pro', true)) {
            return (new Mobile\DoogeeFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('YOGA Tablet', true)) {
            return (new Mobile\LenovoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('TF300T', true)) {
            return (new Mobile\AsusFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('TAB-970', true)) {
            return (new Mobile\PrologyFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('AP-804', true)) {
            return (new Mobile\AssistantFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('Atlantis 1010A', true)) {
            return (new Mobile\BlaupunktFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('IP1020', true)) {
            return (new Mobile\DexFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('A66A', true)) {
            return (new Mobile\EvercossFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('One', true)) {
            return (new Mobile\HtcFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->containsAny(['ARM; WIN JR', 'ARM; WIN HD'], true)) {
            return (new Mobile\BluFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('n820', false)) {
            return (new Mobile\AmoiFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('N90FHDRK', true)) {
            return (new Mobile\YuandaoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('n90 dual core2', false)) {
            return (new Mobile\YuandaoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('lencm900hz', false)) {
            return (new Mobile\LencoFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if (preg_match('/ARM;/', $useragent)
            && preg_match('/Windows NT 6\.(2|3)/', $useragent)
            && !preg_match('/WPDesktop/', $useragent)
        ) {
            return (new Mobile\MicrosoftFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        if ($s->contains('cfnetwork', false)) {
            return (new Mobile\AppleFactory($this->cache, $this->loader))->detect($useragent, $s);
        }

        return $this->loader->load('general mobile device', $useragent);
    }
}
