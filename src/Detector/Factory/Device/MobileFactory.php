<?php
/**
 * Copyright (c) 2012-2016, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector\Factory\Device;


use BrowserDetector\Detector\Device\Mobile\GeneralMobile;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class MobileFactory implements FactoryInterface
{
    /**
     * detects the device name from the given user agent
     *
     * @param string $useragent
     *
     * @return \UaResult\Device\DeviceInterface
     */
    public static function detect($useragent)
    {
        if (preg_match('/(hiphone|v919)/i', $useragent)) {
            return Mobile\HiPhoneFactory::detect($useragent);
        }

        if (preg_match('/(Technisat|TechniPad|AQIPAD|TechniPhone)/', $useragent)) {
            return Mobile\TechnisatFactory::detect($useragent);
        }

        if (preg_match('/(NaviPad)/', $useragent)) {
            return Mobile\TexetFactory::detect($useragent);
        }

        if (preg_match('/(MediPaD)/', $useragent)) {
            return Mobile\BewatecFactory::detect($useragent);
        }

        if (preg_match('/(MiPad)/', $useragent)) {
            return Mobile\XiaomiFactory::detect($useragent);
        }

        if (preg_match('/(nokia|5130c\-2|lumia)/i', $useragent)) {
            return Mobile\NokiaFactory::detect($useragent);
        }

        if (preg_match('/iphone/i', $useragent) && preg_match('/android/i', $useragent)) {
            return Mobile\XiangheFactory::detect($useragent);
        }

        if (preg_match('/(ipad|iphone|ipod|like mac os x)/i', $useragent)
            && !preg_match('/windows phone/i', $useragent)
            && !preg_match('/ adr /i', $useragent)
        ) {
            return Mobile\AppleFactory::detect($useragent);
        }

        if (preg_match('/samsung/i', $useragent)) {
            return Mobile\SamsungFactory::detect($useragent);
        }

        if (preg_match('/asus/i', $useragent)) {
            return Mobile\AsusFactory::detect($useragent);
        }

        if (preg_match('/mt\-gt\-a9500/i', $useragent)) {
            return Mobile\HtmFactory::detect($useragent);
        }

        if (preg_match('/gt\-a7100/i', $useragent)) {
            return Mobile\SprdFactory::detect($useragent);
        }

        if (preg_match('/(feiteng|gt\-h)/i', $useragent)) {
            return Mobile\FeitengFactory::detect($useragent);
        }

        if (preg_match('/(cube|u30gt|u51gt|u55gt)/i', $useragent)) {
            return Mobile\CubeFactory::detect($useragent);
        }

        if (preg_match('/(gt|sam|sc|sch|sec|sgh|shv|shw|sm|sph|continuum)\-/i', $useragent)) {
            return Mobile\SamsungFactory::detect($useragent);
        }

        if (preg_match('/(hdc|galaxy s3 ex)/i', $useragent)) {
            return Mobile\HdcFactory::detect($useragent);
        }

        if (preg_match('/nexus (4|5)/i', $useragent)) {
            return Mobile\LgFactory::detect($useragent);
        }

        if (preg_match('/nexus 7/i', $useragent)) {
            return Mobile\AsusFactory::detect($useragent);
        }

        if (preg_match('/nexus 6/i', $useragent)) {
            return Mobile\MotorolaFactory::detect($useragent);
        }

        if (preg_match('/nexus (one|9)/i', $useragent)) {
            return Mobile\HtcFactory::detect($useragent);
        }

        if (preg_match('/nexus(hd2| evohd2)/i', $useragent)) {
            return Mobile\HtcFactory::detect($useragent);
        }

        if (preg_match('/(hp|p160u|touchpad|pixi|palm|blazer|cm\_tenderloin)/i', $useragent)) {
            return Mobile\HpFactory::detect($useragent);
        }

        if (preg_match('/(galaxy|nexus|i7110|i9100|i9300|yp\-g|blaze)/i', $useragent)) {
            return Mobile\SamsungFactory::detect($useragent);
        }

        if (preg_match('/sony/i', $useragent)) {
            return Mobile\SonyFactory::detect($useragent);
        }

        if (preg_match('/twinovo/i', $useragent)) {
            return Mobile\TwinovoFactory::detect($useragent);
        }

        if (preg_match('/LG/', $useragent)) {
            return Mobile\LgFactory::detect($useragent);
        }

        if (preg_match('/htc/i', $useragent) && !preg_match('/WOHTC/', $useragent)) {
            return Mobile\HtcFactory::detect($useragent);
        }

        if (preg_match('/(SmartTab7|Smart 4G)/', $useragent)) {
            return Mobile\ZteFactory::detect($useragent);
        }

        if (preg_match('/(lenovo|ideatab|ideapad|smarttab)/i', $useragent)) {
            return Mobile\LenovoFactory::detect($useragent);
        }

        if (preg_match('/(acer|iconia|liquid)/i', $useragent)) {
            return Mobile\AcerFactory::detect($useragent);
        }

        if (preg_match('/playstation/i', $useragent)) {
            return Mobile\SonyFactory::detect($useragent);
        }

        if (preg_match('/(amazon|kindle|silk|kftt|kfot|kfjwi|kfsowi|kfthwi|sd4930ur)/i', $useragent)) {
            return Mobile\AmazonFactory::detect($useragent);
        }

        if (preg_match('/amoi/i', $useragent)) {
            return Mobile\AmoiFactory::detect($useragent);
        }

        if (preg_match('/(blaupunkt|endeavour)/i', $useragent)) {
            return Mobile\BlaupunktFactory::detect($useragent);
        }

        if (preg_match('/ONDA/', $useragent)) {
            return Mobile\OndaFactory::detect($useragent);
        }

        if (preg_match('/archos/i', $useragent)) {
            return Mobile\ArchosFactory::detect($useragent);
        }

        if (preg_match('/IRULU/', $useragent)) {
            return Mobile\IruluFactory::detect($useragent);
        }

        if (preg_match('/spice/i', $useragent)) {
            return Mobile\SpiceFactory::detect($useragent);
        }

        if (preg_match('/Symphony/', $useragent)) {
            return Mobile\SymphonyFactory::detect($useragent);
        }

        if (preg_match('/arnova/i', $useragent)) {
            return Mobile\ArnovaFactory::detect($useragent);
        }

        if (preg_match('/ bn /i', $useragent)) {
            return Mobile\BarnesNobleFactory::detect($useragent);
        }

        if (preg_match('/beidou/i', $useragent)) {
            return Mobile\BeidouFactory::detect($useragent);
        }

        if (preg_match('/(blackberry|playbook|rim tablet|bb10)/i', $useragent)) {
            return Mobile\BlackBerryFactory::detect($useragent);
        }

        if (preg_match('/caterpillar/i', $useragent)) {
            return Mobile\CaterpillarFactory::detect($useragent);
        }

        if (preg_match('/B15/', $useragent)) {
            return Mobile\CaterpillarFactory::detect($useragent);
        }

        if (preg_match('/(catnova|cat stargate|cat tablet)/i', $useragent)) {
            return Mobile\CatSoundFactory::detect($useragent);
        }

        if (preg_match('/(coby|nbpc724)/i', $useragent)) {
            return Mobile\CobyFactory::detect($useragent);
        }

        if (preg_match('/MID\d{4}/', $useragent)) {
            return Mobile\CobyFactory::detect($useragent);
        }

        if (preg_match('/WM\d{4}/', $useragent)) {
            return Mobile\WonderMediaFactory::detect($useragent);
        }

        if (preg_match('/(comag|wtdr1018)/i', $useragent)) {
            return Mobile\ComagFactory::detect($useragent);
        }

        if (preg_match('/coolpad/i', $useragent)) {
            return Mobile\CoolpadFactory::detect($useragent);
        }

        if (preg_match('/cosmote/i', $useragent)) {
            return Mobile\CosmoteFactory::detect($useragent);
        }

        if (preg_match('/(creative|ziilabs)/i', $useragent)) {
            return Mobile\CreativeFactory::detect($useragent);
        }

        if (preg_match('/cubot/i', $useragent)) {
            return Mobile\CubotFactory::detect($useragent);
        }

        if (preg_match('/dell/i', $useragent)) {
            return Mobile\DellFactory::detect($useragent);
        }

        if (preg_match('/(denver|tad\-)/i', $useragent)) {
            return Mobile\DenverFactory::detect($useragent);
        }

        if (preg_match('/(nec|n905i)/i', $useragent) && !preg_match('/fennec/i', $useragent)) {
            return Mobile\NecFactory::detect($useragent);
        }

        if (preg_match('/SHARP/', $useragent)) {
            return Mobile\SharpFactory::detect($useragent);
        }

        if (preg_match('/(SH05C|304SH)/', $useragent)) {
            return Mobile\SharpFactory::detect($useragent);
        }

        if (preg_match('/SH\-\d{2}(D|F)/', $useragent)) {
            return Mobile\SharpFactory::detect($useragent);
        }

        if (preg_match('/(docomo|p900i)/i', $useragent)) {
            return Mobile\DoCoMoFactory::detect($useragent);
        }

        if (preg_match('/(easypix|easypad|junior 4\.0)/i', $useragent)) {
            return Mobile\EasypixFactory::detect($useragent);
        }

        if (preg_match('/(Efox|SMART\-E5)/', $useragent)) {
            return Mobile\EfoxFactory::detect($useragent);
        }

        if (preg_match('/1 \& 1/i', $useragent)) {
            return Mobile\EinsUndEinsFactory::detect($useragent);
        }

        if (preg_match('/(xoro|telepad 9a1)/i', $useragent)) {
            return Mobile\XoroFactory::detect($useragent);
        }

        if (preg_match('/(epad|p7901a)/i', $useragent)) {
            return Mobile\EpadFactory::detect($useragent);
        }

        if (preg_match('/p7mini/i', $useragent)) {
            return Mobile\HuaweiFactory::detect($useragent);
        }

        if (preg_match('/faktorzwei/i', $useragent)) {
            return Mobile\FaktorZweiFactory::detect($useragent);
        }

        if (preg_match('/flytouch/i', $useragent)) {
            return Mobile\FlytouchFactory::detect($useragent);
        }

        if (preg_match('/(fujitsu|m532)/i', $useragent)) {
            return Mobile\FujitsuFactory::detect($useragent);
        }

        if (preg_match('/sn10t1/i', $useragent)) {
            return Mobile\HannspreeFactory::detect($useragent);
        }

        if (preg_match('/DA241HL/', $useragent)) {
            return Mobile\AcerFactory::detect($useragent);
        }

        if (preg_match('/(Honlin|PC1088|HL)/', $useragent)) {
            return Mobile\HonlinFactory::detect($useragent);
        }

        if (preg_match('/huawei/i', $useragent)) {
            return Mobile\HuaweiFactory::detect($useragent);
        }

        if (preg_match('/micromax/i', $useragent)) {
            return Mobile\MicromaxFactory::detect($useragent);
        }

        if (preg_match('/triray/i', $useragent)) {
            return Mobile\TrirayFactory::detect($useragent);
        }

        if (preg_match('/SXZ/', $useragent)) {
            return Mobile\SxzFactory::detect($useragent);
        }

        if (preg_match('/explay/i', $useragent)) {
            return Mobile\ExplayFactory::detect($useragent);
        }

        if (preg_match('/pmedia/i', $useragent)) {
            return Mobile\PmediaFactory::detect($useragent);
        }

        if (preg_match('/impression/i', $useragent)) {
            return Mobile\ImpressionFactory::detect($useragent);
        }

        if (preg_match('/kingzone/i', $useragent)) {
            return Mobile\KingzoneFactory::detect($useragent);
        }

        if (preg_match('/gzone/i', $useragent)) {
            return Mobile\GzoneFactory::detect($useragent);
        }

        if (preg_match('/g\-tide/i', $useragent)) {
            return Mobile\GtideFactory::detect($useragent);
        }

        if (preg_match('/reellex/i', $useragent)) {
            return Mobile\ReellexFactory::detect($useragent);
        }

        if (preg_match('/turbopad/i', $useragent)) {
            return Mobile\TurboPadFactory::detect($useragent);
        }

        if (preg_match('/haier/i', $useragent)) {
            return Mobile\HaierFactory::detect($useragent);
        }

        if (preg_match('/sunstech/i', $useragent)) {
            return Mobile\SunstechFactory::detect($useragent);
        }

        if (preg_match('/AOC/', $useragent)) {
            return Mobile\AocFactory::detect($useragent);
        }

        if (preg_match('/hummer/i', $useragent)) {
            return Mobile\HummerFactory::detect($useragent);
        }

        if (preg_match('/oysters/i', $useragent)) {
            return Mobile\OystersFactory::detect($useragent);
        }

        if (preg_match('/vertex/i', $useragent)) {
            return Mobile\VertexFactory::detect($useragent);
        }

        if (preg_match('/pantech/i', $useragent)) {
            return Mobile\PantechFactory::detect($useragent);
        }

        if (preg_match('/gfive/i', $useragent)) {
            return Mobile\GfiveFactory::detect($useragent);
        }

        if (preg_match('/iconbit/i', $useragent)) {
            return Mobile\IconBitFactory::detect($useragent);
        }

        if (preg_match('/intenso/', $useragent)) {
            return Mobile\IntensoFactory::detect($useragent);
        }

        if (preg_match('/INM\d{3,4}/', $useragent)) {
            return Mobile\IntensoFactory::detect($useragent);
        }

        if (preg_match('/ionik/i', $useragent)) {
            return Mobile\IonikFactory::detect($useragent);
        }

        if (preg_match('/JAY\-tech/i', $useragent)) {
            return Mobile\JaytechFactory::detect($useragent);
        }

        if (preg_match('/(jolla|sailfish)/i', $useragent)) {
            return Mobile\JollaFactory::detect($useragent);
        }

        if (preg_match('/kazam/i', $useragent)) {
            return Mobile\KazamFactory::detect($useragent);
        }

        if (preg_match('/kddi/i', $useragent)) {
            return Mobile\KddiFactory::detect($useragent);
        }

        if (preg_match('/kobo touch/i', $useragent)) {
            return Mobile\KoboFactory::detect($useragent);
        }

        if (preg_match('/lenco/i', $useragent)) {
            return Mobile\LencoFactory::detect($useragent);
        }

        if (preg_match('/LePan/', $useragent)) {
            return Mobile\LePanFactory::detect($useragent);
        }

        if (preg_match('/(LogicPD|Zoom2|NookColor)/', $useragent)) {
            return Mobile\LogicpdFactory::detect($useragent);
        }

        if (preg_match('/(medion|lifetab)/i', $useragent)) {
            return Mobile\MedionFactory::detect($useragent);
        }

        if (preg_match('/meizu/i', $useragent)) {
            return Mobile\MeizuFactory::detect($useragent);
        }

        if (preg_match('/allwinner/i', $useragent)) {
            return Mobile\AllWinnerFactory::detect($useragent);
        }

        if (preg_match('/accent/i', $useragent)) {
            return Mobile\AccentFactory::detect($useragent);
        }

        if (preg_match('/yota/i', $useragent)) {
            return Mobile\YotaFactory::detect($useragent);
        }

        if (preg_match('/ainol/i', $useragent)) {
            return Mobile\AinolFactory::detect($useragent);
        }

        if (preg_match('/supra/i', $useragent)) {
            return Mobile\SupraFactory::detect($useragent);
        }

        if (preg_match('/nextway/i', $useragent)) {
            return Mobile\NextwayFactory::detect($useragent);
        }

        if (preg_match('/amlogic/i', $useragent)) {
            return Mobile\AmlogicFactory::detect($useragent);
        }

        if (preg_match('/adspec/i', $useragent)) {
            return Mobile\AdspecFactory::detect($useragent);
        }

        if (preg_match('/m\-way/i', $useragent)) {
            return Mobile\MwayFactory::detect($useragent);
        }

        if (preg_match('/memup/i', $useragent)) {
            return Mobile\MemupFactory::detect($useragent);
        }

        if (preg_match('/xiaomi/i', $useragent)) {
            return Mobile\XiaomiFactory::detect($useragent);
        }

        if (preg_match('/MI (\d|PAD)/', $useragent)) {
            return Mobile\XiaomiFactory::detect($useragent);
        }

        if (preg_match('/HM( |\_)(NOTE|1SC|1SW)/', $useragent)) {
            return Mobile\XiaomiFactory::detect($useragent);
        }

        if (preg_match('/miui/i', $useragent)
            && !preg_match('/miuibrowser/i', $useragent)
            && !preg_match('/build\/miui/i', $useragent)
        ) {
            return Mobile\MiuiFactory::detect($useragent);
        }

        if (preg_match('/(mobistel|cynus)/i', $useragent)) {
            return Mobile\MobistelFactory::detect($useragent);
        }

        if (preg_match('/moto/i', $useragent)) {
            return Mobile\MotorolaFactory::detect($useragent);
        }

        if (preg_match('/WeTab/', $useragent)) {
            return Mobile\NeofonieFactory::detect($useragent);
        }

        if (preg_match('/Nextbook/', $useragent)) {
            return Mobile\NextbookFactory::detect($useragent);
        }

        if (preg_match('/Nintendo/', $useragent)) {
            return Mobile\NintendoFactory::detect($useragent);
        }

        if (preg_match('/Nvsbl/', $useragent)) {
            return Mobile\NvsblFactory::detect($useragent);
        }

        if (preg_match('/odys/i', $useragent)) {
            return Mobile\OdysFactory::detect($useragent);
        }

        if (preg_match('/oppo/i', $useragent)) {
            return Mobile\OppoFactory::detect($useragent);
        }

        if (preg_match('/panasonic/i', $useragent)) {
            return Mobile\PanasonicFactory::detect($useragent);
        }

        if (preg_match('/pandigital/i', $useragent)) {
            return Mobile\PandigitalFactory::detect($useragent);
        }

        if (preg_match('/phicomm/i', $useragent)) {
            return Mobile\PhicommFactory::detect($useragent);
        }

        if (preg_match('/pipo/i', $useragent)) {
            return Mobile\PipoFactory::detect($useragent);
        }

        if (preg_match('/pomp/i', $useragent)) {
            return Mobile\PompFactory::detect($useragent);
        }

        if (preg_match('/prestigio/i', $useragent)) {
            return Mobile\PrestigioFactory::detect($useragent);
        }

        if (preg_match('/qmobile/i', $useragent)) {
            return Mobile\QmobileFactory::detect($useragent);
        }

        if (preg_match('/keener/i', $useragent)) {
            return Mobile\KeenerFactory::detect($useragent);
        }

        if (preg_match('/sanyo/i', $useragent)) {
            return Mobile\SanyoFactory::detect($useragent);
        }

        if (preg_match('/siemens/i', $useragent)) {
            return Mobile\SiemensFactory::detect($useragent);
        }

        if (preg_match('/sprint/i', $useragent)) {
            return Mobile\SprintFactory::detect($useragent);
        }

        if (preg_match('/intex/i', $useragent)) {
            return Mobile\IntexFactory::detect($useragent);
        }

        if (preg_match('/Aqua\_Star/', $useragent)) {
            return Mobile\IntexFactory::detect($useragent);
        }

        if (preg_match('/Star/', $useragent)) {
            return Mobile\StarFactory::detect($useragent);
        }

        if (preg_match('/texet/i', $useragent)) {
            return Mobile\TexetFactory::detect($useragent);
        }

        if (preg_match('/condor/i', $useragent)) {
            return Mobile\CondorFactory::detect($useragent);
        }

        if (preg_match('/s\-tell/i', $useragent)) {
            return Mobile\StellFactory::detect($useragent);
        }

        if (preg_match('/verico/i', $useragent)) {
            return Mobile\VericoFactory::detect($useragent);
        }

        if (preg_match('/ruggear/i', $useragent)) {
            return Mobile\RugGearFactory::detect($useragent);
        }

        if (preg_match('/telsda/i', $useragent)) {
            return Mobile\TelsdaFactory::detect($useragent);
        }

        if (preg_match('/mitashi/i', $useragent)) {
            return Mobile\MitashiFactory::detect($useragent);
        }

        if (preg_match('/bliss/i', $useragent)) {
            return Mobile\BlissFactory::detect($useragent);
        }

        if (preg_match('/lexand/i', $useragent)) {
            return Mobile\LexandFactory::detect($useragent);
        }

        if (preg_match('/alcatel/i', $useragent)) {
            return Mobile\AlcatelFactory::detect($useragent);
        }

        if (preg_match('/thl/i', $useragent) && !preg_match('/LIAuthLibrary/', $useragent)) {
            return Mobile\ThlFactory::detect($useragent);
        }

        if (preg_match('/T\-Mobile/', $useragent)) {
            return Mobile\TmobileFactory::detect($useragent);
        }

        if (preg_match('/tolino/i', $useragent)) {
            return Mobile\TolinoFactory::detect($useragent);
        }

        if (preg_match('/toshiba/i', $useragent)) {
            return Mobile\ToshibaFactory::detect($useragent);
        }

        if (preg_match('/trekstor/i', $useragent)) {
            return Mobile\TrekStorFactory::detect($useragent);
        }

        if (preg_match('/3Q/', $useragent)) {
            return Mobile\TriQFactory::detect($useragent);
        }

        if (preg_match('/(viewsonic|viewpad)/i', $useragent)) {
            return Mobile\ViewSonicFactory::detect($useragent);
        }

        if (preg_match('/wiko/i', $useragent)) {
            return Mobile\WikoFactory::detect($useragent);
        }

        if (preg_match('/vivo/', $useragent)) {
            return Mobile\VivoFactory::detect($useragent);
        }

        if (preg_match('/haipai/i', $useragent)) {
            return Mobile\HaipaiFactory::detect($useragent);
        }

        if (preg_match('/megafon/i', $useragent)) {
            return Mobile\MegaFonFactory::detect($useragent);
        }

        if (preg_match('/UMI/', $useragent)) {
            return Mobile\UmiFactory::detect($useragent);
        }

        if (preg_match('/yuandao/i', $useragent)) {
            return Mobile\YuandaoFactory::detect($useragent);
        }

        if (preg_match('/yuanda/i', $useragent)) {
            return Mobile\YuandaFactory::detect($useragent);
        }

        if (preg_match('/Yusu/', $useragent)) {
            return Mobile\YusuFactory::detect($useragent);
        }

        if (preg_match('/Zenithink/i', $useragent)) {
            return Mobile\ZenithinkFactory::detect($useragent);
        }

        if (preg_match('/zte/i', $useragent)) {
            return Mobile\ZteFactory::detect($useragent);
        }

        if (preg_match('/Fly/', $useragent) && !preg_match('/FlyFlow/', $useragent)) {
            return Mobile\FlyFactory::detect($useragent);
        }

        if (preg_match('/pocketbook/i', $useragent)) {
            return Mobile\PocketBookFactory::detect($useragent);
        }

        if (preg_match('/geniatech/i', $useragent)) {
            return Mobile\GeniatechFactory::detect($useragent);
        }

        if (preg_match('/yarvik/i', $useragent)) {
            return Mobile\YarvikFactory::detect($useragent);
        }

        if (preg_match('/goclever/i', $useragent)) {
            return Mobile\GoCleverFactory::detect($useragent);
        }

        if (preg_match('/senseit/i', $useragent)) {
            return Mobile\SenseitFactory::detect($useragent);
        }

        if (preg_match('/twz/i', $useragent)) {
            return Mobile\TwzFactory::detect($useragent);
        }

        if (preg_match('/irbis/i', $useragent)) {
            return Mobile\IrbisFactory::detect($useragent);
        }

        if (preg_match('/i\-mobile/i', $useragent)) {
            return Mobile\ImobileFactory::detect($useragent);
        }

        if (preg_match('/NGM/', $useragent)) {
            return Mobile\NgmFactory::detect($useragent);
        }

        if (preg_match('/dino/i', $useragent)) {
            return Mobile\DinoFactory::detect($useragent);
        }

        if (preg_match('/(shaan|iball)/i', $useragent)) {
            return Mobile\ShaanFactory::detect($useragent);
        }

        if (preg_match('/bmobile/i', $useragent) && !preg_match('/icabmobile/i', $useragent)) {
            return Mobile\BmobileFactory::detect($useragent);
        }

        if (preg_match('/modecom/i', $useragent)) {
            return Mobile\ModecomFactory::detect($useragent);
        }

        if (preg_match('/overmax/i', $useragent)) {
            return Mobile\OvermaxFactory::detect($useragent);
        }

        if (preg_match('/kiano/i', $useragent)) {
            return Mobile\KianoFactory::detect($useragent);
        }

        if (preg_match('/manta/i', $useragent)) {
            return Mobile\MantaFactory::detect($useragent);
        }

        if (preg_match('/philips/i', $useragent)) {
            return Mobile\PhilipsFactory::detect($useragent);
        }

        if (preg_match('/shiru/i', $useragent)) {
            return Mobile\ShiruFactory::detect($useragent);
        }

        if (preg_match('/tb touch/i', $useragent)) {
            return Mobile\TbTouchFactory::detect($useragent);
        }

        if (preg_match('/NTT/', $useragent)) {
            return Mobile\NttSystemFactory::detect($useragent);
        }

        if (preg_match('/pentagram/i', $useragent)) {
            return Mobile\PentagramFactory::detect($useragent);
        }

        if (preg_match('/zeki/i', $useragent)) {
            return Mobile\ZekiFactory::detect($useragent);
        }

        if (preg_match('/beeline/i', $useragent)) {
            return Mobile\BeelineFactory::detect($useragent);
        }

        if (preg_match('/DFunc/', $useragent)) {
            return Mobile\DfuncFactory::detect($useragent);
        }

        if (preg_match('/Digma/', $useragent)) {
            return Mobile\DigmaFactory::detect($useragent);
        }

        if (preg_match('/axgio/i', $useragent)) {
            return Mobile\AxgioFactory::detect($useragent);
        }

        if (preg_match('/roverpad/i', $useragent)) {
            return Mobile\RoverPadFactory::detect($useragent);
        }

        if (preg_match('/zopo/i', $useragent)) {
            return Mobile\ZopoFactory::detect($useragent);
        }

        if (preg_match('/ultrafone/', $useragent)) {
            return Mobile\UltrafoneFactory::detect($useragent);
        }

        if (preg_match('/malata/i', $useragent)) {
            return Mobile\MalataFactory::detect($useragent);
        }

        if (preg_match('/starway/i', $useragent)) {
            return Mobile\StarwayFactory::detect($useragent);
        }

        if (preg_match('/pegatron/i', $useragent)) {
            return Mobile\PegatronFactory::detect($useragent);
        }

        if (preg_match('/logicom/i', $useragent)) {
            return Mobile\LogicomFactory::detect($useragent);
        }

        if (preg_match('/gigabyte/i', $useragent)) {
            return Mobile\GigabyteFactory::detect($useragent);
        }

        if (preg_match('/qumo/i', $useragent)) {
            return Mobile\QumoFactory::detect($useragent);
        }

        if (preg_match('/perfeo/i', $useragent)) {
            return Mobile\PerfeoFactory::detect($useragent);
        }

        if (preg_match('/yxtel/i', $useragent)) {
            return Mobile\YxtelFactory::detect($useragent);
        }

        if (preg_match('/doogee/i', $useragent)) {
            return Mobile\DoogeeFactory::detect($useragent);
        }

        if (preg_match('/xianghe/i', $useragent)) {
            return Mobile\XiangheFactory::detect($useragent);
        }

        if (preg_match('/ MT791 /i', $useragent)) {
            return Mobile\KeenHighFactory::detect($useragent);
        }

        if (preg_match('/(g100w|stream\-s110)/i', $useragent)) {
            return Mobile\AcerFactory::detect($useragent);
        }

        if (preg_match('/ (a1|a3|b1)\-/i', $useragent)) {
            return Mobile\AcerFactory::detect($useragent);
        }

        if (preg_match('/wildfire/i', $useragent)) {
            return Mobile\HtcFactory::detect($useragent);
        }

        if (preg_match('/a101it/i', $useragent)) {
            return Mobile\ArchosFactory::detect($useragent);
        }

        if (preg_match('/(sprd|SPHS|B51\+)/i', $useragent)) {
            return Mobile\SprdFactory::detect($useragent);
        }

        if (preg_match('/TAB A742/', $useragent)) {
            return Mobile\WexlerFactory::detect($useragent);
        }

        if (preg_match('/ a\d{3} /i', $useragent) && preg_match('/android 3\.2/i', $useragent)) {
            return Mobile\MicromaxFactory::detect($useragent);
        }

        if (preg_match('/ (a|e|v|z|s)\d{3} /i', $useragent)) {
            return Mobile\AcerFactory::detect($useragent);
        }

        if (preg_match('/wolgang/i', $useragent)) {
            return Mobile\WolgangFactory::detect($useragent);
        }

        if (preg_match('/AT\-AS40SE/', $useragent)) {
            return Mobile\WolgangFactory::detect($useragent);
        }

        if (preg_match('/united/i', $useragent)) {
            return Mobile\UnitedFactory::detect($useragent);
        }

        if (preg_match('/MT6515M/', $useragent)) {
            return Mobile\UnitedFactory::detect($useragent);
        }

        if (preg_match('/utstarcom/i', $useragent)) {
            return Mobile\UtStarcomFactory::detect($useragent);
        }

        if (preg_match('/GTX75/', $useragent)) {
            return Mobile\UtStarcomFactory::detect($useragent);
        }

        if (preg_match('/fairphone/i', $useragent)) {
            return Mobile\FairphoneFactory::detect($useragent);
        }

        if (preg_match('/FP1/', $useragent)) {
            return Mobile\FairphoneFactory::detect($useragent);
        }

        if (preg_match('/videocon/i', $useragent)) {
            return Mobile\VideoconFactory::detect($useragent);
        }

        if (preg_match('/A15/', $useragent)) {
            return Mobile\VideoconFactory::detect($useragent);
        }

        if (preg_match('/mastone/i', $useragent)) {
            return Mobile\MastoneFactory::detect($useragent);
        }

        if (preg_match('/BLU/', $useragent)) {
            return Mobile\BluFactory::detect($useragent);
        }

        if (preg_match('/nuqleo/i', $useragent)) {
            return Mobile\NuqleoFactory::detect($useragent);
        }

        if (preg_match('/ritmix/i', $useragent)) {
            return Mobile\RitmixFactory::detect($useragent);
        }

        if (preg_match('/wexler/i', $useragent)) {
            return Mobile\WexlerFactory::detect($useragent);
        }

        if (preg_match('/exeq/i', $useragent)) {
            return Mobile\ExeqFactory::detect($useragent);
        }

        if (preg_match('/ergo/i', $useragent)) {
            return Mobile\ErgoFactory::detect($useragent);
        }

        if (preg_match('/pulid/i', $useragent)) {
            return Mobile\PulidFactory::detect($useragent);
        }

        if (preg_match('/dns/i', $useragent)) {
            return Mobile\DnsFactory::detect($useragent);
        }

        if (preg_match('/dexp/i', $useragent)) {
            return Mobile\DexpFactory::detect($useragent);
        }

        if (preg_match('/keneksi/i', $useragent)) {
            return Mobile\KeneksiFactory::detect($useragent);
        }

        if (preg_match('/gionee/i', $useragent)) {
            return Mobile\GioneeFactory::detect($useragent);
        }

        if (preg_match('/highscreen/i', $useragent)) {
            return Mobile\HighscreenFactory::detect($useragent);
        }

        if (preg_match('/reeder/i', $useragent)) {
            return Mobile\ReederFactory::detect($useragent);
        }

        if (preg_match('/nomi/i', $useragent)) {
            return Mobile\NomiFactory::detect($useragent);
        }

        if (preg_match('/globex/i', $useragent)) {
            return Mobile\GlobexFactory::detect($useragent);
        }

        if (preg_match('/AIS/', $useragent)) {
            return Mobile\AisFactory::detect($useragent);
        }

        if (preg_match('/CIOtCUD/i', $useragent)) {
            return Mobile\CiotcudFactory::detect($useragent);
        }

        if (preg_match('/iNew/', $useragent)) {
            return Mobile\InewFactory::detect($useragent);
        }

        if (preg_match('/intego/i', $useragent)) {
            return Mobile\IntegoFactory::detect($useragent);
        }

        if (preg_match('/MTC/', $useragent)) {
            return Mobile\MtcFactory::detect($useragent);
        }

        if (preg_match('/DARKMOON/', $useragent)) {
            return Mobile\WikoFactory::detect($useragent);
        }

        if (preg_match('/ARK/', $useragent)) {
            return Mobile\ArkFactory::detect($useragent);
        }

        if (preg_match('/Magic/', $useragent)) {
            return Mobile\MagicFactory::detect($useragent);
        }

        if (preg_match('/BQS/', $useragent)) {
            return Mobile\BqFactory::detect($useragent);
        }

        if (preg_match('/BQ \d{4}/', $useragent)) {
            return Mobile\BqFactory::detect($useragent);
        }

        if (preg_match('/bq Aquaris 5 HD/', $useragent)) {
            return Mobile\BqFactory::detect($useragent);
        }

        if (preg_match('/msi/i', $useragent) && !preg_match('/msie/i', $useragent)) {
            return Mobile\MsiFactory::detect($useragent);
        }

        if (preg_match('/SPV/', $useragent)) {
            return Mobile\SpvFactory::detect($useragent);
        }

        if (preg_match('/Orange/', $useragent)) {
            return Mobile\OrangeFactory::detect($useragent);
        }

        if (preg_match('/vastking/i', $useragent)) {
            return Mobile\VastKingFactory::detect($useragent);
        }

        if (preg_match('/wopad/i', $useragent)) {
            return Mobile\WopadFactory::detect($useragent);
        }

        if (preg_match('/anka/i', $useragent)) {
            return Mobile\AnkaFactory::detect($useragent);
        }

        if (preg_match('/ktouch/i', $useragent)) {
            return Mobile\KtouchFactory::detect($useragent);
        }

        if (preg_match('/lemon/i', $useragent)) {
            return Mobile\LemonFactory::detect($useragent);
        }

        if (preg_match('/lava/i', $useragent)) {
            return Mobile\LavaFactory::detect($useragent);
        }

        if (preg_match('/velocity/i', $useragent)) {
            return Mobile\VelocityMicroFactory::detect($useragent);
        }

        if (preg_match('/myTAB/', $useragent)) {
            return Mobile\MytabFactory::detect($useragent);
        }

        if (preg_match('/(loox|uno\_x10|xelio|neo\_quad10|ieos\_quad|sky plus)/i', $useragent)) {
            return Mobile\OdysFactory::detect($useragent);
        }

        if (preg_match('/iPh\d\,\d/', $useragent)) {
            return Mobile\AppleFactory::detect($useragent);
        }

        if (preg_match('/Puffin\/[\d\.]+I(T|P)/', $useragent)) {
            return Mobile\AppleFactory::detect($useragent);
        }

        if (preg_match('/dataaccessd/', $useragent)) {
            return Mobile\AppleFactory::detect($useragent);
        }

        if (preg_match('/Pre/', $useragent) && !preg_match('/Presto/', $useragent)) {
            return Mobile\HpFactory::detect($useragent);
        }

        if (preg_match('/(Z221|V788D|KIS PLUS|NX402|NX501|N918St|Beeline Pro|ATLAS_W)/', $useragent)) {
            return Mobile\ZteFactory::detect($useragent);
        }

        if (preg_match('/ME\d{3}[A-Z]/', $useragent)) {
            return Mobile\AsusFactory::detect($useragent);
        }

        if (preg_match('/(PadFone|Transformer)/', $useragent)) {
            return Mobile\AsusFactory::detect($useragent);
        }

        if (preg_match('/K0(0|1)[0-9a-zA-Z]/', $useragent)) {
            return Mobile\AsusFactory::detect($useragent);
        }

        if (preg_match('/tesla/i', $useragent)) {
            return Mobile\TeslaFactory::detect($useragent);
        }

        if (preg_match('/QtCarBrowser/', $useragent)) {
            return Mobile\TeslaMotorsFactory::detect($useragent);
        }

        if (preg_match('/MOT/', $useragent)) {
            return Mobile\MotorolaFactory::detect($useragent);
        }

        if (preg_match('/MB\d{3}/', $useragent)) {
            return Mobile\MotorolaFactory::detect($useragent);
        }

        if (preg_match('/smart tab/i', $useragent)) {
            return Mobile\LenovoFactory::detect($useragent);
        }

        if (preg_match('/onetouch/i', $useragent)) {
            return Mobile\AlcatelFactory::detect($useragent);
        }

        if (preg_match('/mtech/i', $useragent)) {
            return Mobile\MtechFactory::detect($useragent);
        }

        if (preg_match('/one (s|x)/i', $useragent) && !preg_match('/vodafone smart/i', $useragent)) {
            return Mobile\HtcFactory::detect($useragent);
        }

        if (preg_match('/(Tablet\-PC\-4|Kinder\-Tablet)/', $useragent)) {
            return Mobile\CatSoundFactory::detect($useragent);
        }

        if (preg_match('/TBD\d{4}/', $useragent)) {
            return Mobile\ZekiFactory::detect($useragent);
        }

        if (preg_match('/TBD(B|C|G)\d{3,4}/', $useragent)) {
            return Mobile\ZekiFactory::detect($useragent);
        }

        if (preg_match('/AC0732C/', $useragent)) {
            return Mobile\TriQFactory::detect($useragent);
        }

        if (preg_match('/ImPAD6213M\_v2/', $useragent)) {
            return Mobile\ImpressionFactory::detect($useragent);
        }

        if (preg_match('/(A|C)\d{5}/', $useragent)) {
            return Mobile\NomiFactory::detect($useragent);
        }

        if (preg_match('/(C|D)\d{4}/', $useragent)) {
            return Mobile\SonyFactory::detect($useragent);
        }

        if (preg_match('/OP\d{3}/', $useragent)) {
            return Mobile\OlivettiFactory::detect($useragent);
        }

        if (preg_match('/SGP\d{3}/', $useragent)) {
            return Mobile\SonyFactory::detect($useragent);
        }

        if (preg_match('/sgpt\d{2}/i', $useragent)) {
            return Mobile\SonyFactory::detect($useragent);
        }

        if (preg_match('/xperia/i', $useragent)) {
            return Mobile\SonyFactory::detect($useragent);
        }

        if (preg_match('/VS\d{3}/', $useragent)) {
            return Mobile\LgFactory::detect($useragent);
        }

        if (preg_match('/(SurfTab|VT10416|breeze 10\.1 quad)/', $useragent)) {
            return Mobile\TrekStorFactory::detect($useragent);
        }

        if (preg_match('/AT\d{2,3}/', $useragent)) {
            return Mobile\ToshibaFactory::detect($useragent);
        }

        if (preg_match('/(PAP|PMP|PMT)/', $useragent)) {
            return Mobile\PrestigioFactory::detect($useragent);
        }

        if (preg_match('/(APA9292KT|PJ83100|831C|Evo 3D GSM|Eris 2\.1)/', $useragent)) {
            return Mobile\HtcFactory::detect($useragent);
        }

        if (preg_match('/adr\d{4}/i', $useragent)) {
            return Mobile\HtcFactory::detect($useragent);
        }

        if (preg_match('/NEXT/', $useragent)) {
            return Mobile\NextbookFactory::detect($useragent);
        }

        if (preg_match('/XT\d{3,4}/', $useragent)) {
            return Mobile\MotorolaFactory::detect($useragent);
        }

        if (preg_match('/( droid)/i', $useragent)) {
            return Mobile\MotorolaFactory::detect($useragent);
        }

        if (preg_match('/MT6572\_TD/', $useragent)) {
            return Mobile\CubotFactory::detect($useragent);
        }

        if (preg_match('/(S|L|W|M)T\d{2}/', $useragent)) {
            return Mobile\SonyFactory::detect($useragent);
        }

        if (preg_match('/SK\d{2}/', $useragent)) {
            return Mobile\SonyFactory::detect($useragent);
        }

        if (preg_match('/(SO\-03E|SO\-02D)/', $useragent)) {
            return Mobile\SonyFactory::detect($useragent);
        }

        if (preg_match('/VIVO/', $useragent)) {
            return Mobile\BluFactory::detect($useragent);
        }

        if (preg_match('/NOOK/', $useragent)) {
            return Mobile\BarnesNobleFactory::detect($useragent);
        }

        if (preg_match('/Zaffire/', $useragent)) {
            return Mobile\NuqleoFactory::detect($useragent);
        }

        if (preg_match('/BNRV\d{3}/', $useragent)) {
            return Mobile\BarnesNobleFactory::detect($useragent);
        }

        if (preg_match('/IQ\d{3,4}/', $useragent)) {
            return Mobile\FlyFactory::detect($useragent);
        }

        if (preg_match('/Phoenix 2/', $useragent)) {
            return Mobile\FlyFactory::detect($useragent);
        }

        if (preg_match('/VTAB1008/', $useragent)) {
            return Mobile\VizioFactory::detect($useragent);
        }

        if (preg_match('/TAB10\-400/', $useragent)) {
            return Mobile\YarvikFactory::detect($useragent);
        }

        if (preg_match('/TQ\d{3}/', $useragent)) {
            return Mobile\GoCleverFactory::detect($useragent);
        }

        if (preg_match('/RMD\-\d{3,4}/', $useragent)) {
            return Mobile\RitmixFactory::detect($useragent);
        }

        if (preg_match('/(TERRA_101|ORION7o)/', $useragent)) {
            return Mobile\GoCleverFactory::detect($useragent);
        }

        if (preg_match('/AX\d{3}/', $useragent)) {
            return Mobile\BmobileFactory::detect($useragent);
        }

        if (preg_match('/FreeTAB \d{4}/', $useragent)) {
            return Mobile\ModecomFactory::detect($useragent);
        }

        if (preg_match('/Venue/', $useragent)) {
            return Mobile\DellFactory::detect($useragent);
        }

        if (preg_match('/FunTab/', $useragent)) {
            return Mobile\OrangeFactory::detect($useragent);
        }

        if (preg_match('/(OV\-|Solution 7III)/', $useragent)) {
            return Mobile\OvermaxFactory::detect($useragent);
        }

        if (preg_match('/Zanetti/', $useragent)) {
            return Mobile\KianoFactory::detect($useragent);
        }

        if (preg_match('/MID\d{3}/', $useragent)) {
            return Mobile\MantaFactory::detect($useragent);
        }

        if (preg_match('/FWS610_EU/', $useragent)) {
            return Mobile\PhicommFactory::detect($useragent);
        }

        if (preg_match('/FX2/', $useragent)) {
            return Mobile\FaktorZweiFactory::detect($useragent);
        }

        if (preg_match('/AN\d{1,2}/', $useragent)) {
            return Mobile\ArnovaFactory::detect($useragent);
        }

        if (preg_match('/(Touchlet|X7G)/', $useragent)) {
            return Mobile\PearlFactory::detect($useragent);
        }

        if (preg_match('/POV/', $useragent)) {
            return Mobile\PointOfViewFactory::detect($useragent);
        }

        if (preg_match('/PI\d{4}/', $useragent)) {
            return Mobile\PhilipsFactory::detect($useragent);
        }

        if (preg_match('/SM \- /', $useragent)) {
            return Mobile\SamsungFactory::detect($useragent);
        }

        if (preg_match('/SAMURAI10/', $useragent)) {
            return Mobile\ShiruFactory::detect($useragent);
        }

        if (preg_match('/Ignis 8/', $useragent)) {
            return Mobile\TbTouchFactory::detect($useragent);
        }

        if (preg_match('/A5000/', $useragent)) {
            return Mobile\SonyFactory::detect($useragent);
        }

        if (preg_match('/FUNC/', $useragent)) {
            return Mobile\DfuncFactory::detect($useragent);
        }

        if (preg_match('/iD(j|n|s|x)D\d/', $useragent)) {
            return Mobile\DigmaFactory::detect($useragent);
        }

        if (preg_match('/K910L/', $useragent)) {
            return Mobile\LenovoFactory::detect($useragent);
        }

        if (preg_match('/TAB7iD/', $useragent)) {
            return Mobile\WexlerFactory::detect($useragent);
        }

        if (preg_match('/ZP\d{3}/', $useragent)) {
            return Mobile\ZopoFactory::detect($useragent);
        }

        if (preg_match('/s450\d/i', $useragent)) {
            return Mobile\DnsFactory::detect($useragent);
        }

        if (preg_match('/MB40II1/i', $useragent)) {
            return Mobile\DnsFactory::detect($useragent);
        }

        if (preg_match('/ M3 /', $useragent)) {
            return Mobile\GioneeFactory::detect($useragent);
        }

        if (preg_match('/(W100|W200|W8_beyond)/', $useragent)) {
            return Mobile\ThlFactory::detect($useragent);
        }

        if (preg_match('/NT\-\d{4}(S|P|T)/', $useragent)) {
            return Mobile\IconBitFactory::detect($useragent);
        }

        if (preg_match('/Primo76/', $useragent)) {
            return Mobile\MsiFactory::detect($useragent);
        }

        if (preg_match('/CINK PEAX 2/', $useragent)) {
            return Mobile\WikoFactory::detect($useragent);
        }

        if (preg_match('/T(X|G)\d{2}/', $useragent)) {
            return Mobile\IrbisFactory::detect($useragent);
        }

        if (preg_match('/YD\d{3}/', $useragent)) {
            return Mobile\YotaFactory::detect($useragent);
        }

        if (preg_match('/X\-pad/', $useragent)) {
            return Mobile\TexetFactory::detect($useragent);
        }

        if (preg_match('/TM\-\d{4}/', $useragent)) {
            return Mobile\TexetFactory::detect($useragent);
        }

        if (preg_match('/ G3 /', $useragent)) {
            return Mobile\LgFactory::detect($useragent);
        }

        if (preg_match('/(Zera_F|Boost IIse|Ice2|Prime S|Explosion)/', $useragent)) {
            return Mobile\HighscreenFactory::detect($useragent);
        }

        if (preg_match('/iris708/', $useragent)) {
            return Mobile\AisFactory::detect($useragent);
        }

        if (preg_match('/L930/', $useragent)) {
            return Mobile\CiotcudFactory::detect($useragent);
        }

        if (preg_match('/SMART Run/', $useragent)) {
            return Mobile\MtcFactory::detect($useragent);
        }

        if (preg_match('/X8\+/', $useragent)) {
            return Mobile\TrirayFactory::detect($useragent);
        }

        if (preg_match('/QS0716D/', $useragent)) {
            return Mobile\TriQFactory::detect($useragent);
        }

        if (preg_match('/(Surfer 7\.34|M1_Plus|D7\.2 3G)/', $useragent)) {
            return Mobile\ExplayFactory::detect($useragent);
        }

        if (preg_match('/PMSmart450/', $useragent)) {
            return Mobile\PmediaFactory::detect($useragent);
        }

        if (preg_match('/(F031|SCL24|ACE)/', $useragent)) {
            return Mobile\SamsungFactory::detect($useragent);
        }

        if (preg_match('/ImPAD/', $useragent)) {
            return Mobile\ImpressionFactory::detect($useragent);
        }

        if (preg_match('/K1 turbo/', $useragent)) {
            return Mobile\KingzoneFactory::detect($useragent);
        }

        if (preg_match('/TAB917QC\-8GB/', $useragent)) {
            return Mobile\SunstechFactory::detect($useragent);
        }

        if (preg_match('/(TPC\-PA10\.1M|M7T|P93G|i75)/', $useragent)) {
            return Mobile\PipoFactory::detect($useragent);
        }

        if (preg_match('/ONE TOUCH/', $useragent)) {
            return Mobile\AlcatelFactory::detect($useragent);
        }

        if (preg_match('/6036Y/', $useragent)) {
            return Mobile\AlcatelFactory::detect($useragent);
        }

        if (preg_match('/MD948G/', $useragent)) {
            return Mobile\MwayFactory::detect($useragent);
        }

        if (preg_match('/P4501/', $useragent)) {
            return Mobile\MedionFactory::detect($useragent);
        }

        if (preg_match('/ V3 /', $useragent)) {
            return Mobile\InewFactory::detect($useragent);
        }

        if (preg_match('/PX\-\d{4}/', $useragent)) {
            return Mobile\IntegoFactory::detect($useragent);
        }

        if (preg_match('/Smartphone650/', $useragent)) {
            return Mobile\MasterFactory::detect($useragent);
        }

        if (preg_match('/MX Enjoy TV BOX/', $useragent)) {
            return Mobile\GeniatechFactory::detect($useragent);
        }

        if (preg_match('/A1000s/', $useragent)) {
            return Mobile\XoloFactory::detect($useragent);
        }

        if (preg_match('/P3000/', $useragent)) {
            return Mobile\ElephoneFactory::detect($useragent);
        }

        if (preg_match('/M5301/', $useragent)) {
            return Mobile\IruFactory::detect($useragent);
        }

        if (preg_match('/ C7 /', $useragent)) {
            return Mobile\CubotFactory::detect($useragent);
        }

        if (preg_match('/GV7777/', $useragent)) {
            return Mobile\PrestigioFactory::detect($useragent);
        }

        if (preg_match('/ N1 /', $useragent)) {
            return Mobile\NokiaFactory::detect($useragent);
        }

        if (preg_match('/N\d{4}/', $useragent)) {
            return Mobile\StarFactory::detect($useragent);
        }

        if (preg_match('/(Rio R1|GSmart\_T4)/', $useragent)) {
            return Mobile\GigabyteFactory::detect($useragent);
        }

        if (preg_match('/7007HD/', $useragent)) {
            return Mobile\PerfeoFactory::detect($useragent);
        }

        if (preg_match('/IM\-A830L/', $useragent)) {
            return Mobile\PantechFactory::detect($useragent);
        }

        if (preg_match('/K\-8S/', $useragent)) {
            return Mobile\KeenerFactory::detect($useragent);
        }

        if (preg_match('/M601/', $useragent)) {
            return Mobile\AocFactory::detect($useragent);
        }

        if (preg_match('/H1\+/', $useragent)) {
            return Mobile\HummerFactory::detect($useragent);
        }

        if (preg_match('/Pacific800i/', $useragent)) {
            return Mobile\OystersFactory::detect($useragent);
        }

        if (preg_match('/Impress\_L/', $useragent)) {
            return Mobile\VertexFactory::detect($useragent);
        }

        if (preg_match('/M040/', $useragent)) {
            return Mobile\MeizuFactory::detect($useragent);
        }

        if (preg_match('/CAL21/', $useragent)) {
            return Mobile\GzoneFactory::detect($useragent);
        }

        if (preg_match('/Numy_Note_9/', $useragent)) {
            return Mobile\AinolFactory::detect($useragent);
        }

        if (preg_match('/TAB\-97E\-01/', $useragent)) {
            return Mobile\ReellexFactory::detect($useragent);
        }

        if (preg_match('/vega/i', $useragent)) {
            return Mobile\AdventFactory::detect($useragent);
        }

        if (preg_match('/dream/i', $useragent)) {
            return Mobile\HtcFactory::detect($useragent);
        }

        if (preg_match('/F10X/', $useragent)) {
            return Mobile\NextwayFactory::detect($useragent);
        }

        if (preg_match('/ M8 /', $useragent)) {
            return Mobile\AmlogicFactory::detect($useragent);
        }

        if (preg_match('/SPX\-\d/', $useragent)) {
            return Mobile\SimvalleyFactory::detect($useragent);
        }

        if (preg_match('/AdTab 7 Lite/', $useragent)) {
            return Mobile\AdspecFactory::detect($useragent);
        }

        if (preg_match('/Plane 10\.3 3G PS1043MG/', $useragent)) {
            return Mobile\DigmaFactory::detect($useragent);
        }

        if (preg_match('/(Neon\-N1|WING\-W2)/', $useragent)) {
            return Mobile\AxgioFactory::detect($useragent);
        }

        if (preg_match('/T118/', $useragent)) {
            return Mobile\TwinovoFactory::detect($useragent);
        }

        if (preg_match('/(A1002|A811)/', $useragent)) {
            return Mobile\LexandFactory::detect($useragent);
        }

        if (preg_match('/ A10/', $useragent)) {
            return Mobile\AllWinnerFactory::detect($useragent);
        }

        if (preg_match('/TOUAREG8_3G/', $useragent)) {
            return Mobile\AccentFactory::detect($useragent);
        }

        if (preg_match('/chagall/', $useragent)) {
            return Mobile\PegatronFactory::detect($useragent);
        }

        if (preg_match('/Turbo X6/', $useragent)) {
            return Mobile\TurboPadFactory::detect($useragent);
        }

        if (preg_match('/HW\-W718/', $useragent)) {
            return Mobile\HaierFactory::detect($useragent);
        }

        if (preg_match('/Air A70/', $useragent)) {
            return Mobile\RoverPadFactory::detect($useragent);
        }

        if (preg_match('/SP\-6020 QUASAR/', $useragent)) {
            return Mobile\WooFactory::detect($useragent);
        }

        if (preg_match('/M717R-HD/', $useragent)) {
            return Mobile\VastKingFactory::detect($useragent);
        }

        if (preg_match('/Q10S/', $useragent)) {
            return Mobile\WopadFactory::detect($useragent);
        }

        if (preg_match('/CTAB785R16\-3G/', $useragent)) {
            return Mobile\CondorFactory::detect($useragent);
        }

        if (preg_match('/RP\-UDM\d{2}/', $useragent)) {
            return Mobile\VericoFactory::detect($useragent);
        }

        if (preg_match('/(UQ785\-M1BGV|KM\-UQM11A)/', $useragent)) {
            return Mobile\VericoFactory::detect($useragent);
        }

        if (preg_match('/RG500/', $useragent)) {
            return Mobile\RugGearFactory::detect($useragent);
        }

        if (preg_match('/T9666\-1/', $useragent)) {
            return Mobile\TelsdaFactory::detect($useragent);
        }

        if (preg_match('/1080P\-N003/', $useragent)) {
            return Mobile\NeoFactory::detect($useragent);
        }

        if (preg_match('/AP\-105/', $useragent)) {
            return Mobile\MitashiFactory::detect($useragent);
        }

        if (preg_match('/H7100/', $useragent)) {
            return Mobile\FeitengFactory::detect($useragent);
        }

        if (preg_match('/x909/', $useragent)) {
            return Mobile\OppoFactory::detect($useragent);
        }

        if (preg_match('/xda/i', $useragent)) {
            return Mobile\O2Factory::detect($useragent);
        }

        if (preg_match('/TIANYU/', $useragent)) {
            return Mobile\KtouchFactory::detect($useragent);
        }

        if (preg_match('/KKT20/', $useragent)) {
            return Mobile\LavaFactory::detect($useragent);
        }

        if (preg_match('/MDA/', $useragent)) {
            return Mobile\TmobileFactory::detect($useragent);
        }

        if (preg_match('/redmi_note/i', $useragent)) {
            return Mobile\XiaomiFactory::detect($useragent);
        }

        if (preg_match('/G009/', $useragent)) {
            return Mobile\YxtelFactory::detect($useragent);
        }

        if (preg_match('/DG330/', $useragent)) {
            return Mobile\DoogeeFactory::detect($useragent);
        }

        if (preg_match('/One/', $useragent)) {
            return Mobile\HtcFactory::detect($useragent);
        }

        if (preg_match('/ARM;/', $useragent)
            && preg_match('/Windows NT 6\.(2|3)/', $useragent)
            && !preg_match('/WPDesktop/', $useragent)
        ) {
            return Mobile\MicrosoftFactory::detect($useragent);
        }

        if (preg_match('/CFNetwork/', $useragent)) {
            return Mobile\AppleFactory::detect($useragent);
        }

        return new GeneralMobile($useragent);
    }
}
