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

namespace BrowserDetector\Factory\Device;

use BrowserDetector\Factory;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class MobileFactory implements Factory\FactoryInterface
{
    /**
     * detects the device name from the given user agent
     *
     * @param string $useragent
     *
     * @return \UaResult\Device\DeviceInterface
     */
    public function detect($useragent)
    {
        $deviceCode = 'general mobile device';

        if (preg_match('/(hiphone|v919)/i', $useragent)) {
            return (new Mobile\HiPhoneFactory())->detect($useragent);
        }

        if (preg_match('/(Technisat|TechniPad|AQIPAD|TechniPhone)/', $useragent)) {
            return (new Mobile\TechnisatFactory())->detect($useragent);
        }

        if (preg_match('/(NaviPad)/', $useragent)) {
            return (new Mobile\TexetFactory())->detect($useragent);
        }

        if (preg_match('/(MediPaD)/', $useragent)) {
            return (new Mobile\BewatecFactory())->detect($useragent);
        }

        if (preg_match('/(MiPad)/', $useragent)) {
            return (new Mobile\XiaomiFactory())->detect($useragent);
        }

        if (preg_match('/(nokia)/i', $useragent)) {
            return (new Mobile\NokiaFactory())->detect($useragent);
        }

        if (preg_match('/iphone/i', $useragent)
            && preg_match('/android/i', $useragent)
            && !preg_match('/windows phone/i', $useragent)
        ) {
            return (new Mobile\XiangheFactory())->detect($useragent);
        }

        if (preg_match('/iphone/i', $useragent)
            && preg_match('/linux/i', $useragent)
        ) {
            return (new Mobile\XiangheFactory())->detect($useragent);
        }

        if (preg_match('/iphone/i', $useragent)
            && preg_match('/adr/i', $useragent)
            && preg_match('/ucweb/i', $useragent)
        ) {
            return (new Mobile\XiangheFactory())->detect($useragent);
        }

        if (preg_match('/iphone/i', $useragent)
            && preg_match('/blackberry/i', $useragent)
        ) {
            return (new Mobile\BlackBerryFactory())->detect($useragent);
        }

        if (preg_match('/(ipad|iphone|ipod|like mac os x)/i', $useragent)
            && !preg_match('/windows phone/i', $useragent)
            && !preg_match('/ adr /i', $useragent)
            && !preg_match('/iPodder/', $useragent)
            && !preg_match('/tripadvisor/i', $useragent)
        ) {
            return (new Mobile\AppleFactory())->detect($useragent);
        }

        if (preg_match('/samsung/i', $useragent)) {
            return (new Mobile\SamsungFactory())->detect($useragent);
        }

        if (preg_match('/asus/i', $useragent)) {
            return (new Mobile\AsusFactory())->detect($useragent);
        }

        if (preg_match('/mt\-gt\-a9500/i', $useragent)) {
            return (new Mobile\HtmFactory())->detect($useragent);
        }

        if (preg_match('/gt\-a7100/i', $useragent)) {
            return (new Mobile\SprdFactory())->detect($useragent);
        }

        if (preg_match('/(feiteng|gt\-h)/i', $useragent)) {
            return (new Mobile\FeitengFactory())->detect($useragent);
        }

        if (preg_match('/(cube|u30gt|u51gt|u55gt)/i', $useragent)) {
            return (new Mobile\CubeFactory())->detect($useragent);
        }

        if (preg_match('/GTX75/', $useragent)) {
            return (new Mobile\UtStarcomFactory())->detect($useragent);
        }

        if (preg_match('/gt\-9000/i', $useragent)) {
            return (new Mobile\StarFactory())->detect($useragent);
        }

        if (preg_match('/u25gt\-c4w/i', $useragent)) {
            return (new Mobile\CubeFactory())->detect($useragent);
        }

        if (preg_match('/(gt|sam|sc|sch|sec|sgh|shv|shw|sm|sph|continuum)\-/i', $useragent)) {
            return (new Mobile\SamsungFactory())->detect($useragent);
        }

        if (preg_match('/(hdc|galaxy s3 ex)/i', $useragent)) {
            return (new Mobile\HdcFactory())->detect($useragent);
        }

        if (preg_match('/nexus ?(4|5)/i', $useragent)) {
            return (new Mobile\LgFactory())->detect($useragent);
        }

        if (preg_match('/nexus[ _]?7/i', $useragent)) {
            return (new Mobile\AsusFactory())->detect($useragent);
        }

        if (preg_match('/nexus 6p/i', $useragent)) {
            return (new Mobile\HuaweiFactory())->detect($useragent);
        }

        if (preg_match('/nexus 6/i', $useragent)) {
            return (new Mobile\MotorolaFactory())->detect($useragent);
        }

        if (preg_match('/nexus (one|9)/i', $useragent)) {
            return (new Mobile\HtcFactory())->detect($useragent);
        }

        if (preg_match('/nexus(hd2| evohd2)/i', $useragent)) {
            return (new Mobile\HtcFactory())->detect($useragent);
        }

        if (preg_match('/pantech/i', $useragent)) {
            return (new Mobile\PantechFactory())->detect($useragent);
        }

        if (preg_match('/(hp|p160u|touchpad|pixi|palm|blazer|cm\_tenderloin)/i', $useragent)) {
            return (new Mobile\HpFactory())->detect($useragent);
        }

        if (preg_match('/(galaxy|nexus|i7110|i9100|i9300|yp\-g|blaze)/i', $useragent)) {
            return (new Mobile\SamsungFactory())->detect($useragent);
        }

        if (preg_match('/sony/i', $useragent)) {
            return (new Mobile\SonyFactory())->detect($useragent);
        }

        if (preg_match('/twinovo/i', $useragent)) {
            return (new Mobile\TwinovoFactory())->detect($useragent);
        }

        if (preg_match('/LG/', $useragent)) {
            return (new Mobile\LgFactory())->detect($useragent);
        }

        if (preg_match('/CCE/', $useragent)) {
            return (new Mobile\CceFactory())->detect($useragent);
        }

        if (preg_match('/htc/i', $useragent)
            && !preg_match('/WOHTC/', $useragent)
        ) {
            return (new Mobile\HtcFactory())->detect($useragent);
        }

        if (preg_match('/(SmartTab7|Smart 4G)/', $useragent)) {
            return (new Mobile\ZteFactory())->detect($useragent);
        }

        if (preg_match('/(lenovo|ideatab|ideapad|smarttab)/i', $useragent)) {
            return (new Mobile\LenovoFactory())->detect($useragent);
        }

        if (preg_match('/(acer|iconia|liquid)/i', $useragent)) {
            return (new Mobile\AcerFactory())->detect($useragent);
        }

        if (preg_match('/playstation/i', $useragent)) {
            return (new Mobile\SonyFactory())->detect($useragent);
        }

        if (preg_match('/(amazon|kindle|silk|kftt|kfot|kfjwi|kfsowi|kfthwi|sd4930ur)/i', $useragent)) {
            return (new Mobile\AmazonFactory())->detect($useragent);
        }

        if (preg_match('/amoi/i', $useragent)) {
            return (new Mobile\AmoiFactory())->detect($useragent);
        }

        if (preg_match('/(blaupunkt|endeavour)/i', $useragent)) {
            return (new Mobile\BlaupunktFactory())->detect($useragent);
        }

        if (preg_match('/ONDA/', $useragent)) {
            return (new Mobile\OndaFactory())->detect($useragent);
        }

        if (preg_match('/archos/i', $useragent)) {
            return (new Mobile\ArchosFactory())->detect($useragent);
        }

        if (preg_match('/IRULU/', $useragent)) {
            return (new Mobile\IruluFactory())->detect($useragent);
        }

        if (preg_match('/spice/i', $useragent)) {
            return (new Mobile\SpiceFactory())->detect($useragent);
        }

        if (preg_match('/Symphony/', $useragent)) {
            return (new Mobile\SymphonyFactory())->detect($useragent);
        }

        if (preg_match('/arnova/i', $useragent)) {
            return (new Mobile\ArnovaFactory())->detect($useragent);
        }

        if (preg_match('/ bn /i', $useragent)) {
            return (new Mobile\BarnesNobleFactory())->detect($useragent);
        }

        if (preg_match('/beidou/i', $useragent)) {
            return (new Mobile\BeidouFactory())->detect($useragent);
        }

        if (preg_match('/(blackberry|playbook|rim tablet|bb10)/i', $useragent)) {
            return (new Mobile\BlackBerryFactory())->detect($useragent);
        }

        if (preg_match('/caterpillar/i', $useragent)) {
            return (new Mobile\CaterpillarFactory())->detect($useragent);
        }

        if (preg_match('/B15/', $useragent)) {
            return (new Mobile\CaterpillarFactory())->detect($useragent);
        }

        if (preg_match('/(catnova|cat stargate|cat tablet)/i', $useragent)) {
            return (new Mobile\CatSoundFactory())->detect($useragent);
        }

        if (preg_match('/(coby|nbpc724)/i', $useragent)) {
            return (new Mobile\CobyFactory())->detect($useragent);
        }

        if (preg_match('/MID\d{4}/', $useragent)) {
            return (new Mobile\CobyFactory())->detect($useragent);
        }

        if (preg_match('/WM\d{4}/', $useragent)) {
            return (new Mobile\WonderMediaFactory())->detect($useragent);
        }

        if (preg_match('/(comag|wtdr1018)/i', $useragent)) {
            return (new Mobile\ComagFactory())->detect($useragent);
        }

        if (preg_match('/coolpad/i', $useragent)) {
            return (new Mobile\CoolpadFactory())->detect($useragent);
        }

        if (preg_match('/cosmote/i', $useragent)) {
            return (new Mobile\CosmoteFactory())->detect($useragent);
        }

        if (preg_match('/(creative|ziilabs)/i', $useragent)) {
            return (new Mobile\CreativeFactory())->detect($useragent);
        }

        if (preg_match('/cubot/i', $useragent)) {
            return (new Mobile\CubotFactory())->detect($useragent);
        }

        if (preg_match('/dell/i', $useragent)) {
            return (new Mobile\DellFactory())->detect($useragent);
        }

        if (preg_match('/(denver|tad\-)/i', $useragent)) {
            return (new Mobile\DenverFactory())->detect($useragent);
        }

        if (preg_match('/CONNECT7PRO/', $useragent)) {
            return (new Mobile\OdysFactory())->detect($useragent);
        }

        if (preg_match('/(nec|n905i)/i', $useragent) && !preg_match('/fennec/i', $useragent)) {
            return (new Mobile\NecFactory())->detect($useragent);
        }

        if (preg_match('/SHARP/', $useragent)) {
            return (new Mobile\SharpFactory())->detect($useragent);
        }

        if (preg_match('/SH05C/', $useragent)) {
            return (new Mobile\SharpFactory())->detect($useragent);
        }

        if (preg_match('/\d{3}SH/', $useragent)) {
            return (new Mobile\SharpFactory())->detect($useragent);
        }

        if (preg_match('/SH\-\d{2}(D|F)/', $useragent)) {
            return (new Mobile\SharpFactory())->detect($useragent);
        }

        if (preg_match('/(docomo|p900i)/i', $useragent)) {
            return (new Mobile\DoCoMoFactory())->detect($useragent);
        }

        if (preg_match('/(easypix|easypad|junior 4\.0)/i', $useragent)) {
            return (new Mobile\EasypixFactory())->detect($useragent);
        }

        if (preg_match('/(Efox|SMART\-E5)/', $useragent)) {
            return (new Mobile\EfoxFactory())->detect($useragent);
        }

        if (preg_match('/1 \& 1/i', $useragent)) {
            return (new Mobile\EinsUndEinsFactory())->detect($useragent);
        }

        if (preg_match('/(xoro|telepad 9a1)/i', $useragent)) {
            return (new Mobile\XoroFactory())->detect($useragent);
        }

        if (preg_match('/(epad|p7901a)/i', $useragent)) {
            return (new Mobile\EpadFactory())->detect($useragent);
        }

        if (preg_match('/p7mini/i', $useragent)) {
            return (new Mobile\HuaweiFactory())->detect($useragent);
        }

        if (preg_match('/faktorzwei/i', $useragent)) {
            return (new Mobile\FaktorZweiFactory())->detect($useragent);
        }

        if (preg_match('/flytouch/i', $useragent)) {
            return (new Mobile\FlytouchFactory())->detect($useragent);
        }

        if (preg_match('/(fujitsu|m532)/i', $useragent)) {
            return (new Mobile\FujitsuFactory())->detect($useragent);
        }

        if (preg_match('/sn10t1/i', $useragent)) {
            return (new Mobile\HannspreeFactory())->detect($useragent);
        }

        if (preg_match('/DA241HL/', $useragent)) {
            return (new Mobile\AcerFactory())->detect($useragent);
        }

        if (preg_match('/(Honlin|PC1088|HL)/', $useragent)) {
            return (new Mobile\HonlinFactory())->detect($useragent);
        }

        if (preg_match('/huawei/i', $useragent)) {
            return (new Mobile\HuaweiFactory())->detect($useragent);
        }

        if (preg_match('/micromax/i', $useragent)) {
            return (new Mobile\MicromaxFactory())->detect($useragent);
        }

        if (preg_match('/triray/i', $useragent)) {
            return (new Mobile\TrirayFactory())->detect($useragent);
        }

        if (preg_match('/SXZ/', $useragent)) {
            return (new Mobile\SxzFactory())->detect($useragent);
        }

        if (preg_match('/explay/i', $useragent)) {
            return (new Mobile\ExplayFactory())->detect($useragent);
        }

        if (preg_match('/pmedia/i', $useragent)) {
            return (new Mobile\PmediaFactory())->detect($useragent);
        }

        if (preg_match('/impression/i', $useragent)) {
            return (new Mobile\ImpressionFactory())->detect($useragent);
        }

        if (preg_match('/oneplus/i', $useragent)) {
            return (new Mobile\OneplusFactory())->detect($useragent);
        }

        if (preg_match('/kingzone/i', $useragent)) {
            return (new Mobile\KingzoneFactory())->detect($useragent);
        }

        if (preg_match('/gzone/i', $useragent)) {
            return (new Mobile\GzoneFactory())->detect($useragent);
        }

        if (preg_match('/goophone/i', $useragent)) {
            return (new Mobile\GooPhoneFactory())->detect($useragent);
        }

        if (preg_match('/g\-tide/i', $useragent)) {
            return (new Mobile\GtideFactory())->detect($useragent);
        }

        if (preg_match('/reellex/i', $useragent)) {
            return (new Mobile\ReellexFactory())->detect($useragent);
        }

        if (preg_match('/(turbopad|turbo pad)/i', $useragent)) {
            return (new Mobile\TurboPadFactory())->detect($useragent);
        }

        if (preg_match('/haier/i', $useragent)) {
            return (new Mobile\HaierFactory())->detect($useragent);
        }

        if (preg_match('/sunstech/i', $useragent)) {
            return (new Mobile\SunstechFactory())->detect($useragent);
        }

        if (preg_match('/AOC/', $useragent)) {
            return (new Mobile\AocFactory())->detect($useragent);
        }

        if (preg_match('/hummer/i', $useragent)) {
            return (new Mobile\HummerFactory())->detect($useragent);
        }

        if (preg_match('/oysters/i', $useragent)) {
            return (new Mobile\OystersFactory())->detect($useragent);
        }

        if (preg_match('/vertex/i', $useragent)) {
            return (new Mobile\VertexFactory())->detect($useragent);
        }

        if (preg_match('/gfive/i', $useragent)) {
            return (new Mobile\GfiveFactory())->detect($useragent);
        }

        if (preg_match('/iconbit/i', $useragent)) {
            return (new Mobile\IconBitFactory())->detect($useragent);
        }

        if (preg_match('/intenso/', $useragent)) {
            return (new Mobile\IntensoFactory())->detect($useragent);
        }

        if (preg_match('/INM\d{3,4}/', $useragent)) {
            return (new Mobile\IntensoFactory())->detect($useragent);
        }

        if (preg_match('/ionik/i', $useragent)) {
            return (new Mobile\IonikFactory())->detect($useragent);
        }

        if (preg_match('/JAY\-tech/i', $useragent)) {
            return (new Mobile\JaytechFactory())->detect($useragent);
        }

        if (preg_match('/(jolla|sailfish)/i', $useragent)) {
            return (new Mobile\JollaFactory())->detect($useragent);
        }

        if (preg_match('/kazam/i', $useragent)) {
            return (new Mobile\KazamFactory())->detect($useragent);
        }

        if (preg_match('/kddi/i', $useragent)) {
            return (new Mobile\KddiFactory())->detect($useragent);
        }

        if (preg_match('/kobo touch/i', $useragent)) {
            return (new Mobile\KoboFactory())->detect($useragent);
        }

        if (preg_match('/lenco/i', $useragent)) {
            return (new Mobile\LencoFactory())->detect($useragent);
        }

        if (preg_match('/LePan/', $useragent)) {
            return (new Mobile\LePanFactory())->detect($useragent);
        }

        if (preg_match('/(LogicPD|Zoom2|NookColor)/', $useragent)) {
            return (new Mobile\LogicpdFactory())->detect($useragent);
        }

        if (preg_match('/(medion|lifetab)/i', $useragent)) {
            return (new Mobile\MedionFactory())->detect($useragent);
        }

        if (preg_match('/meizu/i', $useragent)) {
            return (new Mobile\MeizuFactory())->detect($useragent);
        }

        if (preg_match('/hisense/i', $useragent)) {
            return (new Mobile\HisenseFactory())->detect($useragent);
        }

        if (preg_match('/minix/i', $useragent)) {
            return (new Mobile\MinixFactory())->detect($useragent);
        }

        if (preg_match('/allwinner/i', $useragent)) {
            return (new Mobile\AllWinnerFactory())->detect($useragent);
        }

        if (preg_match('/accent/i', $useragent)) {
            return (new Mobile\AccentFactory())->detect($useragent);
        }

        if (preg_match('/yota/i', $useragent)) {
            return (new Mobile\YotaFactory())->detect($useragent);
        }

        if (preg_match('/ainol/i', $useragent)) {
            return (new Mobile\AinolFactory())->detect($useragent);
        }

        if (preg_match('/supra/i', $useragent)) {
            return (new Mobile\SupraFactory())->detect($useragent);
        }

        if (preg_match('/nextway/i', $useragent)) {
            return (new Mobile\NextwayFactory())->detect($useragent);
        }

        if (preg_match('/amlogic/i', $useragent)) {
            return (new Mobile\AmlogicFactory())->detect($useragent);
        }

        if (preg_match('/adspec/i', $useragent)) {
            return (new Mobile\AdspecFactory())->detect($useragent);
        }

        if (preg_match('/m\-way/i', $useragent)) {
            return (new Mobile\MwayFactory())->detect($useragent);
        }

        if (preg_match('/memup/i', $useragent)) {
            return (new Mobile\MemupFactory())->detect($useragent);
        }

        if (preg_match('/prestigio/i', $useragent)) {
            return (new Mobile\PrestigioFactory())->detect($useragent);
        }

        if (preg_match('/xiaomi/i', $useragent)) {
            return (new Mobile\XiaomiFactory())->detect($useragent);
        }

        if (preg_match('/MI (\d|PAD|MAX)/', $useragent)) {
            return (new Mobile\XiaomiFactory())->detect($useragent);
        }

        if (preg_match('/HM( |\_)(NOTE|1SC|1SW)/', $useragent)) {
            return (new Mobile\XiaomiFactory())->detect($useragent);
        }

        if (preg_match('/miui/i', $useragent)
            && !preg_match('/miuibrowser/i', $useragent)
            && !preg_match('/build\/miui/i', $useragent)
        ) {
            return (new Mobile\MiuiFactory())->detect($useragent);
        }

        if (preg_match('/(mobistel|cynus)/i', $useragent)) {
            return (new Mobile\MobistelFactory())->detect($useragent);
        }

        if (preg_match('/moto/i', $useragent)) {
            return (new Mobile\MotorolaFactory())->detect($useragent);
        }

        if (preg_match('/WeTab/', $useragent)) {
            return (new Mobile\NeofonieFactory())->detect($useragent);
        }

        if (preg_match('/Nextbook/', $useragent)) {
            return (new Mobile\NextbookFactory())->detect($useragent);
        }

        if (preg_match('/Nintendo/', $useragent)) {
            return (new Mobile\NintendoFactory())->detect($useragent);
        }

        if (preg_match('/Nvsbl/', $useragent)) {
            return (new Mobile\NvsblFactory())->detect($useragent);
        }

        if (preg_match('/odys/i', $useragent)) {
            return (new Mobile\OdysFactory())->detect($useragent);
        }

        if (preg_match('/oppo/i', $useragent)) {
            return (new Mobile\OppoFactory())->detect($useragent);
        }

        if (preg_match('/panasonic/i', $useragent)) {
            return (new Mobile\PanasonicFactory())->detect($useragent);
        }

        if (preg_match('/pandigital/i', $useragent)) {
            return (new Mobile\PandigitalFactory())->detect($useragent);
        }

        if (preg_match('/phicomm/i', $useragent)) {
            return (new Mobile\PhicommFactory())->detect($useragent);
        }

        if (preg_match('/pipo/i', $useragent)) {
            return (new Mobile\PipoFactory())->detect($useragent);
        }

        if (preg_match('/pomp/i', $useragent)) {
            return (new Mobile\PompFactory())->detect($useragent);
        }

        if (preg_match('/qmobile/i', $useragent)) {
            return (new Mobile\QmobileFactory())->detect($useragent);
        }

        if (preg_match('/keener/i', $useragent)) {
            return (new Mobile\KeenerFactory())->detect($useragent);
        }

        if (preg_match('/sanyo/i', $useragent)) {
            return (new Mobile\SanyoFactory())->detect($useragent);
        }

        if (preg_match('/siemens/i', $useragent)) {
            return (new Mobile\SiemensFactory())->detect($useragent);
        }

        if (preg_match('/sprint/i', $useragent)) {
            return (new Mobile\SprintFactory())->detect($useragent);
        }

        if (preg_match('/intex/i', $useragent)) {
            return (new Mobile\IntexFactory())->detect($useragent);
        }

        if (preg_match('/CAL21/', $useragent)) {
            return (new Mobile\GzoneFactory())->detect($useragent);
        }

        if (preg_match('/N\-06E/', $useragent)) {
            return (new Mobile\NecFactory())->detect($useragent);
        }

        if (preg_match('/(A|C)\d{5}/', $useragent)) {
            return (new Mobile\NomiFactory())->detect($useragent);
        }

        if (preg_match('/one e1003/i', $useragent)) {
            return (new Mobile\OneplusFactory())->detect($useragent);
        }

        if (preg_match('/one a200(1|3|5)/i', $useragent)) {
            return (new Mobile\OneplusFactory())->detect($useragent);
        }

        if (preg_match('/F5281/', $useragent)) {
            return (new Mobile\HisenseFactory())->detect($useragent);
        }

        if (preg_match('/MOT/', $useragent)) {
            return (new Mobile\MotorolaFactory())->detect($useragent);
        }

        if (preg_match('/TBD\d{4}/', $useragent)) {
            return (new Mobile\ZekiFactory())->detect($useragent);
        }

        if (preg_match('/TBD(B|C|G)\d{3,4}/', $useragent)) {
            return (new Mobile\ZekiFactory())->detect($useragent);
        }

        if (preg_match('/(AC0732C|RC9724C|MT0739D|QS0716D|LC0720C)/', $useragent)) {
            return (new Mobile\TriQFactory())->detect($useragent);
        }

        if (preg_match('/ImPAD6213M\_v2/', $useragent)) {
            return (new Mobile\ImpressionFactory())->detect($useragent);
        }

        if (preg_match('/S4503Q/', $useragent)) {
            return (new Mobile\DnsFactory())->detect($useragent);
        }

        if (preg_match('/dns/i', $useragent)) {
            return (new Mobile\DnsFactory())->detect($useragent);
        }

        if (preg_match('/D6000/', $useragent)) {
            return (new Mobile\InnosFactory())->detect($useragent);
        }

        if (preg_match('/(S|V)T\d{5}/', $useragent)) {
            return (new Mobile\TrekStorFactory())->detect($useragent);
        }

        if (preg_match('/ONE E\d{4}/', $useragent)) {
            return (new Mobile\HtcFactory())->detect($useragent);
        }

        if (preg_match('/(C|D|E|F)\d{4}/', $useragent)) {
            return (new Mobile\SonyFactory())->detect($useragent);
        }

        if (preg_match('/Aqua\_Star/', $useragent)) {
            return (new Mobile\IntexFactory())->detect($useragent);
        }

        if (preg_match('/Star/', $useragent)) {
            return (new Mobile\StarFactory())->detect($useragent);
        }

        if (preg_match('/texet/i', $useragent)) {
            return (new Mobile\TexetFactory())->detect($useragent);
        }

        if (preg_match('/condor/i', $useragent)) {
            return (new Mobile\CondorFactory())->detect($useragent);
        }

        if (preg_match('/s\-tell/i', $useragent)) {
            return (new Mobile\StellFactory())->detect($useragent);
        }

        if (preg_match('/verico/i', $useragent)) {
            return (new Mobile\VericoFactory())->detect($useragent);
        }

        if (preg_match('/ruggear/i', $useragent)) {
            return (new Mobile\RugGearFactory())->detect($useragent);
        }

        if (preg_match('/telsda/i', $useragent)) {
            return (new Mobile\TelsdaFactory())->detect($useragent);
        }

        if (preg_match('/mitashi/i', $useragent)) {
            return (new Mobile\MitashiFactory())->detect($useragent);
        }

        if (preg_match('/bliss/i', $useragent)) {
            return (new Mobile\BlissFactory())->detect($useragent);
        }

        if (preg_match('/lexand/i', $useragent)) {
            return (new Mobile\LexandFactory())->detect($useragent);
        }

        if (preg_match('/alcatel/i', $useragent)) {
            return (new Mobile\AlcatelFactory())->detect($useragent);
        }

        if (preg_match('/thl/i', $useragent) && !preg_match('/LIAuthLibrary/', $useragent)) {
            return (new Mobile\ThlFactory())->detect($useragent);
        }

        if (preg_match('/T\-Mobile/', $useragent)) {
            return (new Mobile\TmobileFactory())->detect($useragent);
        }

        if (preg_match('/tolino/i', $useragent)) {
            return (new Mobile\TolinoFactory())->detect($useragent);
        }

        if (preg_match('/toshiba/i', $useragent)) {
            return (new Mobile\ToshibaFactory())->detect($useragent);
        }

        if (preg_match('/trekstor/i', $useragent)) {
            return (new Mobile\TrekStorFactory())->detect($useragent);
        }

        if (preg_match('/3Q/', $useragent)) {
            return (new Mobile\TriQFactory())->detect($useragent);
        }

        if (preg_match('/(viewsonic|viewpad)/i', $useragent)) {
            return (new Mobile\ViewSonicFactory())->detect($useragent);
        }

        if (preg_match('/wiko/i', $useragent)) {
            return (new Mobile\WikoFactory())->detect($useragent);
        }

        if (preg_match('/vivo/', $useragent)) {
            return (new Mobile\VivoFactory())->detect($useragent);
        }

        if (preg_match('/haipai/i', $useragent)) {
            return (new Mobile\HaipaiFactory())->detect($useragent);
        }

        if (preg_match('/megafon/i', $useragent)) {
            return (new Mobile\MegaFonFactory())->detect($useragent);
        }

        if (preg_match('/UMI/', $useragent)) {
            return (new Mobile\UmiFactory())->detect($useragent);
        }

        if (preg_match('/yuandao/i', $useragent)) {
            return (new Mobile\YuandaoFactory())->detect($useragent);
        }

        if (preg_match('/yuanda/i', $useragent)) {
            return (new Mobile\YuandaFactory())->detect($useragent);
        }

        if (preg_match('/Yusu/', $useragent)) {
            return (new Mobile\YusuFactory())->detect($useragent);
        }

        if (preg_match('/Zenithink/i', $useragent)) {
            return (new Mobile\ZenithinkFactory())->detect($useragent);
        }

        if (preg_match('/zte/i', $useragent)) {
            return (new Mobile\ZteFactory())->detect($useragent);
        }

        if (preg_match('/Fly/', $useragent) && !preg_match('/FlyFlow/', $useragent)) {
            return (new Mobile\FlyFactory())->detect($useragent);
        }

        if (preg_match('/pocketbook/i', $useragent)) {
            return (new Mobile\PocketBookFactory())->detect($useragent);
        }

        if (preg_match('/geniatech/i', $useragent)) {
            return (new Mobile\GeniatechFactory())->detect($useragent);
        }

        if (preg_match('/yarvik/i', $useragent)) {
            return (new Mobile\YarvikFactory())->detect($useragent);
        }

        if (preg_match('/goclever/i', $useragent)) {
            return (new Mobile\GoCleverFactory())->detect($useragent);
        }

        if (preg_match('/senseit/i', $useragent)) {
            return (new Mobile\SenseitFactory())->detect($useragent);
        }

        if (preg_match('/twz/i', $useragent)) {
            return (new Mobile\TwzFactory())->detect($useragent);
        }

        if (preg_match('/irbis/i', $useragent)) {
            return (new Mobile\IrbisFactory())->detect($useragent);
        }

        if (preg_match('/i\-mobile/i', $useragent)) {
            return (new Mobile\ImobileFactory())->detect($useragent);
        }

        if (preg_match('/axioo/i', $useragent)) {
            return (new Mobile\AxiooFactory())->detect($useragent);
        }

        if (preg_match('/artel/i', $useragent)) {
            return (new Mobile\ArtelFactory())->detect($useragent);
        }

        if (preg_match('/sunup/i', $useragent)) {
            return (new Mobile\SunupFactory())->detect($useragent);
        }

        if (preg_match('/evercoss/i', $useragent)) {
            return (new Mobile\EvercossFactory())->detect($useragent);
        }

        if (preg_match('/NGM/', $useragent)) {
            return (new Mobile\NgmFactory())->detect($useragent);
        }

        if (preg_match('/dino/i', $useragent)) {
            return (new Mobile\DinoFactory())->detect($useragent);
        }

        if (preg_match('/(shaan|iball)/i', $useragent)) {
            return (new Mobile\ShaanFactory())->detect($useragent);
        }

        if (preg_match('/bmobile/i', $useragent) && !preg_match('/icabmobile/i', $useragent)) {
            return (new Mobile\BmobileFactory())->detect($useragent);
        }

        if (preg_match('/modecom/i', $useragent)) {
            return (new Mobile\ModecomFactory())->detect($useragent);
        }

        if (preg_match('/overmax/i', $useragent)) {
            return (new Mobile\OvermaxFactory())->detect($useragent);
        }

        if (preg_match('/kiano/i', $useragent)) {
            return (new Mobile\KianoFactory())->detect($useragent);
        }

        if (preg_match('/manta/i', $useragent)) {
            return (new Mobile\MantaFactory())->detect($useragent);
        }

        if (preg_match('/philips/i', $useragent)) {
            return (new Mobile\PhilipsFactory())->detect($useragent);
        }

        if (preg_match('/shiru/i', $useragent)) {
            return (new Mobile\ShiruFactory())->detect($useragent);
        }

        if (preg_match('/tb touch/i', $useragent)) {
            return (new Mobile\TbTouchFactory())->detect($useragent);
        }

        if (preg_match('/NTT/', $useragent)) {
            return (new Mobile\NttSystemFactory())->detect($useragent);
        }

        if (preg_match('/pentagram/i', $useragent)) {
            return (new Mobile\PentagramFactory())->detect($useragent);
        }

        if (preg_match('/zeki/i', $useragent)) {
            return (new Mobile\ZekiFactory())->detect($useragent);
        }

        if (preg_match('/(Z221|V788D|KIS PLUS|NX402|NX501|N918St|Beeline Pro|ATLAS_W)/', $useragent)) {
            return (new Mobile\ZteFactory())->detect($useragent);
        }

        if (preg_match('/beeline/i', $useragent)) {
            return (new Mobile\BeelineFactory())->detect($useragent);
        }

        if (preg_match('/DFunc/', $useragent)) {
            return (new Mobile\DfuncFactory())->detect($useragent);
        }

        if (preg_match('/Digma/', $useragent)) {
            return (new Mobile\DigmaFactory())->detect($useragent);
        }

        if (preg_match('/axgio/i', $useragent)) {
            return (new Mobile\AxgioFactory())->detect($useragent);
        }

        if (preg_match('/roverpad/i', $useragent)) {
            return (new Mobile\RoverPadFactory())->detect($useragent);
        }

        if (preg_match('/zopo/i', $useragent)) {
            return (new Mobile\ZopoFactory())->detect($useragent);
        }

        if (preg_match('/ultrafone/', $useragent)) {
            return (new Mobile\UltrafoneFactory())->detect($useragent);
        }

        if (preg_match('/malata/i', $useragent)) {
            return (new Mobile\MalataFactory())->detect($useragent);
        }

        if (preg_match('/starway/i', $useragent)) {
            return (new Mobile\StarwayFactory())->detect($useragent);
        }

        if (preg_match('/pegatron/i', $useragent)) {
            return (new Mobile\PegatronFactory())->detect($useragent);
        }

        if (preg_match('/logicom/i', $useragent)) {
            return (new Mobile\LogicomFactory())->detect($useragent);
        }

        if (preg_match('/gigabyte/i', $useragent)) {
            return (new Mobile\GigabyteFactory())->detect($useragent);
        }

        if (preg_match('/qumo/i', $useragent)) {
            return (new Mobile\QumoFactory())->detect($useragent);
        }

        if (preg_match('/perfeo/i', $useragent)) {
            return (new Mobile\PerfeoFactory())->detect($useragent);
        }

        if (preg_match('/yxtel/i', $useragent)) {
            return (new Mobile\YxtelFactory())->detect($useragent);
        }

        if (preg_match('/doogee/i', $useragent)) {
            return (new Mobile\DoogeeFactory())->detect($useragent);
        }

        if (preg_match('/xianghe/i', $useragent)) {
            return (new Mobile\XiangheFactory())->detect($useragent);
        }

        if (preg_match('/celkon/i', $useragent)) {
            return (new Mobile\CelkonFactory())->detect($useragent);
        }

        if (preg_match('/bravis/i', $useragent)) {
            return (new Mobile\BravisFactory())->detect($useragent);
        }

        if (preg_match('/fnac/i', $useragent)) {
            return (new Mobile\FnacFactory())->detect($useragent);
        }

        if (preg_match('/etuline/i', $useragent)) {
            return (new Mobile\EtulineFactory())->detect($useragent);
        }

        if (preg_match('/tcl/i', $useragent)) {
            return (new Mobile\TclFactory())->detect($useragent);
        }

        if (preg_match('/radxa/i', $useragent)) {
            return (new Mobile\RadxaFactory())->detect($useragent);
        }

        if (preg_match('/kyocera/i', $useragent)) {
            return (new Mobile\KyoceraFactory())->detect($useragent);
        }

        if (preg_match('/prology/i', $useragent)) {
            return (new Mobile\PrologyFactory())->detect($useragent);
        }

        if (preg_match('/assistant/i', $useragent)) {
            return (new Mobile\AssistantFactory())->detect($useragent);
        }

        if (preg_match('/ MT791 /i', $useragent)) {
            return (new Mobile\KeenHighFactory())->detect($useragent);
        }

        if (preg_match('/(g100w|stream\-s110)/i', $useragent)) {
            return (new Mobile\AcerFactory())->detect($useragent);
        }

        if (preg_match('/ (a1|a3|b1)\-/i', $useragent)) {
            return (new Mobile\AcerFactory())->detect($useragent);
        }

        if (preg_match('/(wildfire|desire)/i', $useragent)) {
            return (new Mobile\HtcFactory())->detect($useragent);
        }

        if (preg_match('/a101it/i', $useragent)) {
            return (new Mobile\ArchosFactory())->detect($useragent);
        }

        if (preg_match('/(sprd|SPHS|B51\+)/i', $useragent)) {
            return (new Mobile\SprdFactory())->detect($useragent);
        }

        if (preg_match('/TAB A742/', $useragent)) {
            return (new Mobile\WexlerFactory())->detect($useragent);
        }

        if (preg_match('/ a\d{3} /i', $useragent) && preg_match('/android 3\.2/i', $useragent)) {
            return (new Mobile\MicromaxFactory())->detect($useragent);
        }

        if (preg_match('/S208/', $useragent)) {
            return (new Mobile\CubotFactory())->detect($useragent);
        }

        if (preg_match('/A400/', $useragent)) {
            return (new Mobile\CelkonFactory())->detect($useragent);
        }

        if (preg_match('/ (a|e|v|z|s)\d{3} /i', $useragent)) {
            return (new Mobile\AcerFactory())->detect($useragent);
        }

        if (preg_match('/wolgang/i', $useragent)) {
            return (new Mobile\WolgangFactory())->detect($useragent);
        }

        if (preg_match('/AT\-AS40SE/', $useragent)) {
            return (new Mobile\WolgangFactory())->detect($useragent);
        }

        if (preg_match('/AT1010\-T/', $useragent)) {
            return (new Mobile\LenovoFactory())->detect($useragent);
        }

        if (preg_match('/united/i', $useragent)) {
            return (new Mobile\UnitedFactory())->detect($useragent);
        }

        if (preg_match('/MT6515M/', $useragent)) {
            return (new Mobile\UnitedFactory())->detect($useragent);
        }

        if (preg_match('/utstarcom/i', $useragent)) {
            return (new Mobile\UtStarcomFactory())->detect($useragent);
        }

        if (preg_match('/fairphone/i', $useragent)) {
            return (new Mobile\FairphoneFactory())->detect($useragent);
        }

        if (preg_match('/FP1/', $useragent)) {
            return (new Mobile\FairphoneFactory())->detect($useragent);
        }

        if (preg_match('/videocon/i', $useragent)) {
            return (new Mobile\VideoconFactory())->detect($useragent);
        }

        if (preg_match('/A15/', $useragent)) {
            return (new Mobile\VideoconFactory())->detect($useragent);
        }

        if (preg_match('/mastone/i', $useragent)) {
            return (new Mobile\MastoneFactory())->detect($useragent);
        }

        if (preg_match('/BLU/', $useragent)) {
            return (new Mobile\BluFactory())->detect($useragent);
        }

        if (preg_match('/nuqleo/i', $useragent)) {
            return (new Mobile\NuqleoFactory())->detect($useragent);
        }

        if (preg_match('/ritmix/i', $useragent)) {
            return (new Mobile\RitmixFactory())->detect($useragent);
        }

        if (preg_match('/wexler/i', $useragent)) {
            return (new Mobile\WexlerFactory())->detect($useragent);
        }

        if (preg_match('/exeq/i', $useragent)) {
            return (new Mobile\ExeqFactory())->detect($useragent);
        }

        if (preg_match('/ergo/i', $useragent)) {
            return (new Mobile\ErgoFactory())->detect($useragent);
        }

        if (preg_match('/pulid/i', $useragent)) {
            return (new Mobile\PulidFactory())->detect($useragent);
        }

        if (preg_match('/dexp/i', $useragent)) {
            return (new Mobile\DexpFactory())->detect($useragent);
        }

        if (preg_match('/dex/i', $useragent)) {
            return (new Mobile\DexFactory())->detect($useragent);
        }

        if (preg_match('/keneksi/i', $useragent)) {
            return (new Mobile\KeneksiFactory())->detect($useragent);
        }

        if (preg_match('/gionee/i', $useragent)) {
            return (new Mobile\GioneeFactory())->detect($useragent);
        }

        if (preg_match('/highscreen/i', $useragent)) {
            return (new Mobile\HighscreenFactory())->detect($useragent);
        }

        if (preg_match('/reeder/i', $useragent)) {
            return (new Mobile\ReederFactory())->detect($useragent);
        }

        if (preg_match('/nomi/i', $useragent)) {
            return (new Mobile\NomiFactory())->detect($useragent);
        }

        if (preg_match('/globex/i', $useragent)) {
            return (new Mobile\GlobexFactory())->detect($useragent);
        }

        if (preg_match('/AIS/', $useragent)) {
            return (new Mobile\AisFactory())->detect($useragent);
        }

        if (preg_match('/CIOtCUD/i', $useragent)) {
            return (new Mobile\CiotcudFactory())->detect($useragent);
        }

        if (preg_match('/iNew/', $useragent)) {
            return (new Mobile\InewFactory())->detect($useragent);
        }

        if (preg_match('/intego/i', $useragent)) {
            return (new Mobile\IntegoFactory())->detect($useragent);
        }

        if (preg_match('/MTC/', $useragent)) {
            return (new Mobile\MtcFactory())->detect($useragent);
        }

        if (preg_match('/(DARKMOON|DARKSIDE|CINK PEAX 2|JERRY|BLOOM|SLIDE2)/', $useragent)) {
            return (new Mobile\WikoFactory())->detect($useragent);
        }

        if (preg_match('/ARK/', $useragent)) {
            return (new Mobile\ArkFactory())->detect($useragent);
        }

        if (preg_match('/Magic/', $useragent)) {
            return (new Mobile\MagicFactory())->detect($useragent);
        }

        if (preg_match('/BQS/', $useragent)) {
            return (new Mobile\BqFactory())->detect($useragent);
        }

        if (preg_match('/BQ \d{4}/', $useragent)) {
            return (new Mobile\BqFactory())->detect($useragent);
        }

        if (preg_match('/aquaris/i', $useragent)) {
            return (new Mobile\BqFactory())->detect($useragent);
        }

        if (preg_match('/msi/i', $useragent) && !preg_match('/msie/i', $useragent)) {
            return (new Mobile\MsiFactory())->detect($useragent);
        }

        if (preg_match('/SPV/', $useragent)) {
            return (new Mobile\SpvFactory())->detect($useragent);
        }

        if (preg_match('/Orange/', $useragent)) {
            return (new Mobile\OrangeFactory())->detect($useragent);
        }

        if (preg_match('/vastking/i', $useragent)) {
            return (new Mobile\VastKingFactory())->detect($useragent);
        }

        if (preg_match('/wopad/i', $useragent)) {
            return (new Mobile\WopadFactory())->detect($useragent);
        }

        if (preg_match('/anka/i', $useragent)) {
            return (new Mobile\AnkaFactory())->detect($useragent);
        }

        if (preg_match('/ktouch/i', $useragent)) {
            return (new Mobile\KtouchFactory())->detect($useragent);
        }

        if (preg_match('/lemon/i', $useragent)) {
            return (new Mobile\LemonFactory())->detect($useragent);
        }

        if (preg_match('/lava/i', $useragent)) {
            return (new Mobile\LavaFactory())->detect($useragent);
        }

        if (preg_match('/velocity/i', $useragent)) {
            return (new Mobile\VelocityMicroFactory())->detect($useragent);
        }

        if (preg_match('/myTAB/', $useragent)) {
            return (new Mobile\MytabFactory())->detect($useragent);
        }

        if (preg_match('/(loox|uno\_x10|xelio|neo\_quad10|ieos\_quad|sky plus|maven\_10\_plus|space10_plus_3g)/i', $useragent)) {
            return (new Mobile\OdysFactory())->detect($useragent);
        }

        if (preg_match('/iPh\d\,\d/', $useragent)) {
            return (new Mobile\AppleFactory())->detect($useragent);
        }

        if (preg_match('/Puffin\/[\d\.]+I(T|P)/', $useragent)) {
            return (new Mobile\AppleFactory())->detect($useragent);
        }

        if (preg_match('/dataaccessd/', $useragent)) {
            return (new Mobile\AppleFactory())->detect($useragent);
        }

        if (preg_match('/Pre/', $useragent) && !preg_match('/Presto/', $useragent)) {
            return (new Mobile\HpFactory())->detect($useragent);
        }

        if (preg_match('/ME\d{3}[A-Z]/', $useragent)) {
            return (new Mobile\AsusFactory())->detect($useragent);
        }

        if (preg_match('/(PadFone|Transformer)/', $useragent)) {
            return (new Mobile\AsusFactory())->detect($useragent);
        }

        if (preg_match('/(K|P)0(0|1)[0-9a-zA-Z]/', $useragent)) {
            return (new Mobile\AsusFactory())->detect($useragent);
        }

        if (preg_match('/tesla/i', $useragent)) {
            return (new Mobile\TeslaFactory())->detect($useragent);
        }

        if (preg_match('/QtCarBrowser/', $useragent)) {
            return (new Mobile\TeslaMotorsFactory())->detect($useragent);
        }

        if (preg_match('/MB\d{3}/', $useragent)) {
            return (new Mobile\MotorolaFactory())->detect($useragent);
        }

        if (preg_match('/smart tab/i', $useragent)) {
            return (new Mobile\LenovoFactory())->detect($useragent);
        }

        if (preg_match('/onetouch/i', $useragent)) {
            return (new Mobile\AlcatelFactory())->detect($useragent);
        }

        if (preg_match('/mtech/i', $useragent)) {
            return (new Mobile\MtechFactory())->detect($useragent);
        }

        if (preg_match('/one (s|x)/i', $useragent) && !preg_match('/vodafone smart/i', $useragent)) {
            return (new Mobile\HtcFactory())->detect($useragent);
        }

        if (preg_match('/(Tablet\-PC\-4|Kinder\-Tablet)/', $useragent)) {
            return (new Mobile\CatSoundFactory())->detect($useragent);
        }

        if (preg_match('/OP\d{3}/', $useragent)) {
            return (new Mobile\OlivettiFactory())->detect($useragent);
        }

        if (preg_match('/SGP\d{3}/', $useragent)) {
            return (new Mobile\SonyFactory())->detect($useragent);
        }

        if (preg_match('/sgpt\d{2}/i', $useragent)) {
            return (new Mobile\SonyFactory())->detect($useragent);
        }

        if (preg_match('/xperia/i', $useragent)) {
            return (new Mobile\SonyFactory())->detect($useragent);
        }

        if (preg_match('/VS\d{3}/', $useragent)) {
            return (new Mobile\LgFactory())->detect($useragent);
        }

        if (preg_match('/(SurfTab|VT10416|breeze 10\.1 quad)/', $useragent)) {
            return (new Mobile\TrekStorFactory())->detect($useragent);
        }

        if (preg_match('/AT\d{2,3}/', $useragent)) {
            return (new Mobile\ToshibaFactory())->detect($useragent);
        }

        if (preg_match('/(PAP|PMP|PMT)/', $useragent)) {
            return (new Mobile\PrestigioFactory())->detect($useragent);
        }

        if (preg_match('/(APA9292KT|PJ83100|831C|Evo 3D GSM|Eris 2\.1)/', $useragent)) {
            return (new Mobile\HtcFactory())->detect($useragent);
        }

        if (preg_match('/adr\d{4}/i', $useragent)) {
            return (new Mobile\HtcFactory())->detect($useragent);
        }

        if (preg_match('/NEXT/', $useragent)) {
            return (new Mobile\NextbookFactory())->detect($useragent);
        }

        if (preg_match('/XT\d{3,4}/', $useragent)) {
            return (new Mobile\MotorolaFactory())->detect($useragent);
        }

        if (preg_match('/( droid)/i', $useragent)) {
            return (new Mobile\MotorolaFactory())->detect($useragent);
        }

        if (preg_match('/MT\d{4}/', $useragent)) {
            return (new Mobile\CubotFactory())->detect($useragent);
        }

        if (preg_match('/(S|L|W|M)T\d{2}/', $useragent)) {
            return (new Mobile\SonyFactory())->detect($useragent);
        }

        if (preg_match('/SK\d{2}/', $useragent)) {
            return (new Mobile\SonyFactory())->detect($useragent);
        }

        if (preg_match('/SO\-\d{2}(B|C|D|E)/', $useragent)) {
            return (new Mobile\SonyFactory())->detect($useragent);
        }

        if (preg_match('/L50u/', $useragent)) {
            return (new Mobile\SonyFactory())->detect($useragent);
        }

        if (preg_match('/VIVO/', $useragent)) {
            return (new Mobile\BluFactory())->detect($useragent);
        }

        if (preg_match('/NOOK/', $useragent)) {
            return (new Mobile\BarnesNobleFactory())->detect($useragent);
        }

        if (preg_match('/Zaffire/', $useragent)) {
            return (new Mobile\NuqleoFactory())->detect($useragent);
        }

        if (preg_match('/BNRV\d{3}/', $useragent)) {
            return (new Mobile\BarnesNobleFactory())->detect($useragent);
        }

        if (preg_match('/IQ\d{3,4}/', $useragent)) {
            return (new Mobile\FlyFactory())->detect($useragent);
        }

        if (preg_match('/Phoenix 2/', $useragent)) {
            return (new Mobile\FlyFactory())->detect($useragent);
        }

        if (preg_match('/VTAB1008/', $useragent)) {
            return (new Mobile\VizioFactory())->detect($useragent);
        }

        if (preg_match('/TAB10\-400/', $useragent)) {
            return (new Mobile\YarvikFactory())->detect($useragent);
        }

        if (preg_match('/TQ\d{3}/', $useragent)) {
            return (new Mobile\GoCleverFactory())->detect($useragent);
        }

        if (preg_match('/RMD\-\d{3,4}/', $useragent)) {
            return (new Mobile\RitmixFactory())->detect($useragent);
        }

        if (preg_match('/(TERRA_101|ORION7o)/', $useragent)) {
            return (new Mobile\GoCleverFactory())->detect($useragent);
        }

        if (preg_match('/AX\d{3}/', $useragent)) {
            return (new Mobile\BmobileFactory())->detect($useragent);
        }

        if (preg_match('/FreeTAB \d{4}/', $useragent)) {
            return (new Mobile\ModecomFactory())->detect($useragent);
        }

        if (preg_match('/Venue/', $useragent)) {
            return (new Mobile\DellFactory())->detect($useragent);
        }

        if (preg_match('/FunTab/', $useragent)) {
            return (new Mobile\OrangeFactory())->detect($useragent);
        }

        if (preg_match('/(OV\-|Solution 7III)/', $useragent)) {
            return (new Mobile\OvermaxFactory())->detect($useragent);
        }

        if (preg_match('/Zanetti/', $useragent)) {
            return (new Mobile\KianoFactory())->detect($useragent);
        }

        if (preg_match('/MID\d{3}/', $useragent)) {
            return (new Mobile\MantaFactory())->detect($useragent);
        }

        if (preg_match('/FWS610_EU/', $useragent)) {
            return (new Mobile\PhicommFactory())->detect($useragent);
        }

        if (preg_match('/FX2/', $useragent)) {
            return (new Mobile\FaktorZweiFactory())->detect($useragent);
        }

        if (preg_match('/AN\d{1,2}/', $useragent)) {
            return (new Mobile\ArnovaFactory())->detect($useragent);
        }

        if (preg_match('/(Touchlet|X7G)/', $useragent)) {
            return (new Mobile\PearlFactory())->detect($useragent);
        }

        if (preg_match('/POV/', $useragent)) {
            return (new Mobile\PointOfViewFactory())->detect($useragent);
        }

        if (preg_match('/PI\d{4}/', $useragent)) {
            return (new Mobile\PhilipsFactory())->detect($useragent);
        }

        if (preg_match('/SM \- /', $useragent)) {
            return (new Mobile\SamsungFactory())->detect($useragent);
        }

        if (preg_match('/SAMURAI10/', $useragent)) {
            return (new Mobile\ShiruFactory())->detect($useragent);
        }

        if (preg_match('/Ignis 8/', $useragent)) {
            return (new Mobile\TbTouchFactory())->detect($useragent);
        }

        if (preg_match('/A5000/', $useragent)) {
            return (new Mobile\SonyFactory())->detect($useragent);
        }

        if (preg_match('/FUNC/', $useragent)) {
            return (new Mobile\DfuncFactory())->detect($useragent);
        }

        if (preg_match('/iD(j|n|s|x|r)(D|Q)\d{1,2}/', $useragent)) {
            return (new Mobile\DigmaFactory())->detect($useragent);
        }

        if (preg_match('/K910L/', $useragent)) {
            return (new Mobile\LenovoFactory())->detect($useragent);
        }

        if (preg_match('/P10(32|50)X/', $useragent)) {
            return (new Mobile\LenovoFactory())->detect($useragent);
        }

        if (preg_match('/TAB7iD/', $useragent)) {
            return (new Mobile\WexlerFactory())->detect($useragent);
        }

        if (preg_match('/ZP\d{3}/', $useragent)) {
            return (new Mobile\ZopoFactory())->detect($useragent);
        }

        if (preg_match('/s450\d/i', $useragent)) {
            return (new Mobile\DnsFactory())->detect($useragent);
        }

        if (preg_match('/MB40II1/i', $useragent)) {
            return (new Mobile\DnsFactory())->detect($useragent);
        }

        if (preg_match('/ M3 /', $useragent)) {
            return (new Mobile\GioneeFactory())->detect($useragent);
        }

        if (preg_match('/(W100|W200|W8_beyond)/', $useragent)) {
            return (new Mobile\ThlFactory())->detect($useragent);
        }

        if (preg_match('/NT\-\d{4}(S|P|T|M)/', $useragent)) {
            return (new Mobile\IconBitFactory())->detect($useragent);
        }

        if (preg_match('/Primo76/', $useragent)) {
            return (new Mobile\MsiFactory())->detect($useragent);
        }

        if (preg_match('/T(X|G)\d{2}/', $useragent)) {
            return (new Mobile\IrbisFactory())->detect($useragent);
        }

        if (preg_match('/YD\d{3}/', $useragent)) {
            return (new Mobile\YotaFactory())->detect($useragent);
        }

        if (preg_match('/X\-pad/', $useragent)) {
            return (new Mobile\TexetFactory())->detect($useragent);
        }

        if (preg_match('/TM\-\d{4}/', $useragent)) {
            return (new Mobile\TexetFactory())->detect($useragent);
        }

        if (preg_match('/OK\d{3}/', $useragent)) {
            return (new Mobile\SunupFactory())->detect($useragent);
        }

        if (preg_match('/ G3 /', $useragent)) {
            return (new Mobile\LgFactory())->detect($useragent);
        }

        if (preg_match('/(Zera_F|Boost IIse|Ice2|Prime S|Explosion)/', $useragent)) {
            return (new Mobile\HighscreenFactory())->detect($useragent);
        }

        if (preg_match('/iris708/', $useragent)) {
            return (new Mobile\AisFactory())->detect($useragent);
        }

        if (preg_match('/L930/', $useragent)) {
            return (new Mobile\CiotcudFactory())->detect($useragent);
        }

        if (preg_match('/SMART Run/', $useragent)) {
            return (new Mobile\MtcFactory())->detect($useragent);
        }

        if (preg_match('/X8\+/', $useragent)) {
            return (new Mobile\TrirayFactory())->detect($useragent);
        }

        if (preg_match('/(Surfer 7\.34|M1_Plus|D7\.2 3G)/', $useragent)) {
            return (new Mobile\ExplayFactory())->detect($useragent);
        }

        if (preg_match('/Art 3G/', $useragent)) {
            return (new Mobile\ExplayFactory())->detect($useragent);
        }

        if (preg_match('/PMSmart450/', $useragent)) {
            return (new Mobile\PmediaFactory())->detect($useragent);
        }

        if (preg_match('/(F031|SCL24|ACE)/', $useragent)) {
            return (new Mobile\SamsungFactory())->detect($useragent);
        }

        if (preg_match('/ImPAD/', $useragent)) {
            return (new Mobile\ImpressionFactory())->detect($useragent);
        }

        if (preg_match('/K1 turbo/', $useragent)) {
            return (new Mobile\KingzoneFactory())->detect($useragent);
        }

        if (preg_match('/TAB917QC\-8GB/', $useragent)) {
            return (new Mobile\SunstechFactory())->detect($useragent);
        }

        if (preg_match('/TAB785DUAL/', $useragent)) {
            return (new Mobile\SunstechFactory())->detect($useragent);
        }

        if (preg_match('/(TPC\-PA10\.1M|M7T|P93G|i75|M83g| M6 )/', $useragent)) {
            return (new Mobile\PipoFactory())->detect($useragent);
        }

        if (preg_match('/ONE TOUCH/', $useragent)) {
            return (new Mobile\AlcatelFactory())->detect($useragent);
        }

        if (preg_match('/(6036Y|4034D|5042D)/', $useragent)) {
            return (new Mobile\AlcatelFactory())->detect($useragent);
        }

        if (preg_match('/MD948G/', $useragent)) {
            return (new Mobile\MwayFactory())->detect($useragent);
        }

        if (preg_match('/P4501/', $useragent)) {
            return (new Mobile\MedionFactory())->detect($useragent);
        }

        if (preg_match('/ V3 /', $useragent)) {
            return (new Mobile\InewFactory())->detect($useragent);
        }

        if (preg_match('/PX\-\d{4}/', $useragent)) {
            return (new Mobile\IntegoFactory())->detect($useragent);
        }

        if (preg_match('/Smartphone650/', $useragent)) {
            return (new Mobile\MasterFactory())->detect($useragent);
        }

        if (preg_match('/MX Enjoy TV BOX/', $useragent)) {
            return (new Mobile\GeniatechFactory())->detect($useragent);
        }

        if (preg_match('/A1000s/', $useragent)) {
            return (new Mobile\XoloFactory())->detect($useragent);
        }

        if (preg_match('/P3000/', $useragent)) {
            return (new Mobile\ElephoneFactory())->detect($useragent);
        }

        if (preg_match('/M5301/', $useragent)) {
            return (new Mobile\IruFactory())->detect($useragent);
        }

        if (preg_match('/ C7 /', $useragent)) {
            return (new Mobile\CubotFactory())->detect($useragent);
        }

        if (preg_match('/GV7777/', $useragent)) {
            return (new Mobile\PrestigioFactory())->detect($useragent);
        }

        if (preg_match('/ N1 /', $useragent)) {
            return (new Mobile\NokiaFactory())->detect($useragent);
        }

        if (preg_match('/RM\-\d{3,4}/', $useragent) && !preg_match('/(nokia|microsoft)/i', $useragent)) {
            return (new Mobile\RossMoorFactory())->detect($useragent);
        }

        if (preg_match('/RM\-\d{3,4}/', $useragent)) {
            return (new Mobile\NokiaFactory())->detect($useragent);
        }

        if (preg_match('/(5130c\-2|lumia|arm; 909|id336|genm14)/i', $useragent)) {
            return (new Mobile\NokiaFactory())->detect($useragent);
        }

        if (preg_match('/N8000D/', $useragent)) {
            return (new Mobile\SamsungFactory())->detect($useragent);
        }

        if (preg_match('/N\d{4}/', $useragent)) {
            return (new Mobile\StarFactory())->detect($useragent);
        }

        if (preg_match('/(Rio R1|GSmart\_T4)/', $useragent)) {
            return (new Mobile\GigabyteFactory())->detect($useragent);
        }

        if (preg_match('/7007HD/', $useragent)) {
            return (new Mobile\PerfeoFactory())->detect($useragent);
        }

        if (preg_match('/PT\-GF200/', $useragent)) {
            return (new Mobile\PantechFactory())->detect($useragent);
        }

        if (preg_match('/IM\-A\d{3}(L|K)/', $useragent)) {
            return (new Mobile\PantechFactory())->detect($useragent);
        }

        if (preg_match('/K\-8S/', $useragent)) {
            return (new Mobile\KeenerFactory())->detect($useragent);
        }

        if (preg_match('/M601/', $useragent)) {
            return (new Mobile\AocFactory())->detect($useragent);
        }

        if (preg_match('/H1\+/', $useragent)) {
            return (new Mobile\HummerFactory())->detect($useragent);
        }

        if (preg_match('/Pacific800i/', $useragent)) {
            return (new Mobile\OystersFactory())->detect($useragent);
        }

        if (preg_match('/Impress\_L/', $useragent)) {
            return (new Mobile\VertexFactory())->detect($useragent);
        }

        if (preg_match('/(M040|MZ\-MX5)/', $useragent)) {
            return (new Mobile\MeizuFactory())->detect($useragent);
        }

        if (preg_match('/(NEO\-X5)/', $useragent)) {
            return (new Mobile\MinixFactory())->detect($useragent);
        }

        if (preg_match('/Numy_Note_9/', $useragent)) {
            return (new Mobile\AinolFactory())->detect($useragent);
        }

        if (preg_match('/Novo7Fire/', $useragent)) {
            return (new Mobile\AinolFactory())->detect($useragent);
        }

        if (preg_match('/TAB\-97E\-01/', $useragent)) {
            return (new Mobile\ReellexFactory())->detect($useragent);
        }

        if (preg_match('/vega/i', $useragent)) {
            return (new Mobile\AdventFactory())->detect($useragent);
        }

        if (preg_match('/dream/i', $useragent)) {
            return (new Mobile\HtcFactory())->detect($useragent);
        }

        if (preg_match('/F10X/', $useragent)) {
            return (new Mobile\NextwayFactory())->detect($useragent);
        }

        if (preg_match('/ M8 /', $useragent)) {
            return (new Mobile\AmlogicFactory())->detect($useragent);
        }

        if (preg_match('/SPX\-\d/', $useragent)) {
            return (new Mobile\SimvalleyFactory())->detect($useragent);
        }

        if (preg_match('/AdTab 7 Lite/', $useragent)) {
            return (new Mobile\AdspecFactory())->detect($useragent);
        }

        if (preg_match('/PS1043MG/', $useragent)) {
            return (new Mobile\DigmaFactory())->detect($useragent);
        }

        if (preg_match('/TT7026MW/', $useragent)) {
            return (new Mobile\DigmaFactory())->detect($useragent);
        }

        if (preg_match('/(Neon\-N1|WING\-W2)/', $useragent)) {
            return (new Mobile\AxgioFactory())->detect($useragent);
        }

        if (preg_match('/T1(0|1)8/', $useragent)) {
            return (new Mobile\TwinovoFactory())->detect($useragent);
        }

        if (preg_match('/(A1002|A811)/', $useragent)) {
            return (new Mobile\LexandFactory())->detect($useragent);
        }

        if (preg_match('/ A10/', $useragent)) {
            return (new Mobile\AllWinnerFactory())->detect($useragent);
        }

        if (preg_match('/TOUAREG8_3G/', $useragent)) {
            return (new Mobile\AccentFactory())->detect($useragent);
        }

        if (preg_match('/chagall/', $useragent)) {
            return (new Mobile\PegatronFactory())->detect($useragent);
        }

        if (preg_match('/Turbo X6/', $useragent)) {
            return (new Mobile\TurboPadFactory())->detect($useragent);
        }

        if (preg_match('/HW\-W718/', $useragent)) {
            return (new Mobile\HaierFactory())->detect($useragent);
        }

        if (preg_match('/Air A70/', $useragent)) {
            return (new Mobile\RoverPadFactory())->detect($useragent);
        }

        if (preg_match('/SP\-6020 QUASAR/', $useragent)) {
            return (new Mobile\WooFactory())->detect($useragent);
        }

        if (preg_match('/M717R-HD/', $useragent)) {
            return (new Mobile\VastKingFactory())->detect($useragent);
        }

        if (preg_match('/Q10S/', $useragent)) {
            return (new Mobile\WopadFactory())->detect($useragent);
        }

        if (preg_match('/CTAB785R16\-3G/', $useragent)) {
            return (new Mobile\CondorFactory())->detect($useragent);
        }

        if (preg_match('/RP\-UDM\d{2}/', $useragent)) {
            return (new Mobile\VericoFactory())->detect($useragent);
        }

        if (preg_match('/(UQ785\-M1BGV|KM\-UQM11A)/', $useragent)) {
            return (new Mobile\VericoFactory())->detect($useragent);
        }

        if (preg_match('/RG500/', $useragent)) {
            return (new Mobile\RugGearFactory())->detect($useragent);
        }

        if (preg_match('/T9666\-1/', $useragent)) {
            return (new Mobile\TelsdaFactory())->detect($useragent);
        }

        if (preg_match('/N003/', $useragent)) {
            return (new Mobile\NeoFactory())->detect($useragent);
        }

        if (preg_match('/AP\-105/', $useragent)) {
            return (new Mobile\MitashiFactory())->detect($useragent);
        }

        if (preg_match('/H7100/', $useragent)) {
            return (new Mobile\FeitengFactory())->detect($useragent);
        }

        if (preg_match('/x909/', $useragent)) {
            return (new Mobile\OppoFactory())->detect($useragent);
        }

        if (preg_match('/R815/', $useragent)) {
            return (new Mobile\OppoFactory())->detect($useragent);
        }

        if (preg_match('/xda/i', $useragent)) {
            return (new Mobile\O2Factory())->detect($useragent);
        }

        if (preg_match('/TIANYU/', $useragent)) {
            return (new Mobile\KtouchFactory())->detect($useragent);
        }

        if (preg_match('/KKT20/', $useragent)) {
            return (new Mobile\LavaFactory())->detect($useragent);
        }

        if (preg_match('/MDA/', $useragent)) {
            return (new Mobile\TmobileFactory())->detect($useragent);
        }

        if (preg_match('/redmi/i', $useragent)) {
            return (new Mobile\XiaomiFactory())->detect($useragent);
        }

        if (preg_match('/G009/', $useragent)) {
            return (new Mobile\YxtelFactory())->detect($useragent);
        }

        if (preg_match('/DG\d{3,4}/', $useragent)) {
            return (new Mobile\DoogeeFactory())->detect($useragent);
        }

        if (preg_match('/H30\-U10/', $useragent)) {
            return (new Mobile\HuaweiFactory())->detect($useragent);
        }

        if (preg_match('/KIW\-L21/', $useragent)) {
            return (new Mobile\HuaweiFactory())->detect($useragent);
        }

        if (preg_match('/PICOpad_S1/', $useragent)) {
            return (new Mobile\AxiooFactory())->detect($useragent);
        }

        if (preg_match('/Adi_5S/', $useragent)) {
            return (new Mobile\ArtelFactory())->detect($useragent);
        }

        if (preg_match('/Norma 2/', $useragent)) {
            return (new Mobile\KeneksiFactory())->detect($useragent);
        }

        if (preg_match('/DM015K/', $useragent)) {
            return (new Mobile\KyoceraFactory())->detect($useragent);
        }

        if (preg_match('/KC\-S701/', $useragent)) {
            return (new Mobile\KyoceraFactory())->detect($useragent);
        }

        if (preg_match('/T880G/', $useragent)) {
            return (new Mobile\EtulineFactory())->detect($useragent);
        }

        if (preg_match('/STUDIO 5\.5/', $useragent)) {
            return (new Mobile\BluFactory())->detect($useragent);
        }

        if (preg_match('/F3_Pro/', $useragent)) {
            return (new Mobile\DoogeeFactory())->detect($useragent);
        }

        if (preg_match('/YOGA Tablet/', $useragent)) {
            return (new Mobile\LenovoFactory())->detect($useragent);
        }

        if (preg_match('/TF300T/', $useragent)) {
            return (new Mobile\AsusFactory())->detect($useragent);
        }

        if (preg_match('/TAB\-970/', $useragent)) {
            return (new Mobile\PrologyFactory())->detect($useragent);
        }

        if (preg_match('/AP\-804/', $useragent)) {
            return (new Mobile\AssistantFactory())->detect($useragent);
        }

        if (preg_match('/Atlantis 1010A/', $useragent)) {
            return (new Mobile\BlaupunktFactory())->detect($useragent);
        }

        if (preg_match('/IP1020/', $useragent)) {
            return (new Mobile\DexFactory())->detect($useragent);
        }

        if (preg_match('/A66A/', $useragent)) {
            return (new Mobile\EvercossFactory())->detect($useragent);
        }

        if (preg_match('/One/', $useragent)) {
            return (new Mobile\HtcFactory())->detect($useragent);
        }

        if (preg_match('/ARM; WIN (JR|HD)/', $useragent)) {
            return (new Mobile\BluFactory())->detect($useragent);
        }

        if (preg_match('/ARM;/', $useragent)
            && preg_match('/Windows NT 6\.(2|3)/', $useragent)
            && !preg_match('/WPDesktop/', $useragent)
        ) {
            return (new Mobile\MicrosoftFactory())->detect($useragent);
        }

        if (preg_match('/CFNetwork/', $useragent)) {
            return (new Mobile\AppleFactory())->detect($useragent);
        }

        return (new Factory\DeviceFactory())->get($deviceCode, $useragent);
    }
}
