<?php
/**
 * Copyright (c) 2012-2015, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
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
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector\Factory\Device;

use BrowserDetector\Detector\Company;
use BrowserDetector\Detector\Device\GeneralMobile;
use BrowserDetector\Detector\Device\Mobile\Acer;
use BrowserDetector\Detector\Device\Mobile\Ais;
use BrowserDetector\Detector\Device\Mobile\Alcatel;
use BrowserDetector\Detector\Device\Mobile\Amazon;
use BrowserDetector\Detector\Device\Mobile\Amoi;
use BrowserDetector\Detector\Device\Mobile\Apple;
use BrowserDetector\Detector\Device\Mobile\Archos;
use BrowserDetector\Detector\Device\Mobile\Ark;
use BrowserDetector\Detector\Device\Mobile\Arnova;
use BrowserDetector\Detector\Device\Mobile\Asus;
use BrowserDetector\Detector\Device\Mobile\BarnesNoble;
use BrowserDetector\Detector\Device\Mobile\Beidou;
use BrowserDetector\Detector\Device\Mobile\BlackBerry;
use BrowserDetector\Detector\Device\Mobile\Blaupunkt;
use BrowserDetector\Detector\Device\Mobile\Blu;
use BrowserDetector\Detector\Device\Mobile\Bmobile;
use BrowserDetector\Detector\Device\Mobile\Bq;
use BrowserDetector\Detector\Device\Mobile\Caterpillar;
use BrowserDetector\Detector\Device\Mobile\CatSound;
use BrowserDetector\Detector\Device\Mobile\Ciotcud;
use BrowserDetector\Detector\Device\Mobile\Coby;
use BrowserDetector\Detector\Device\Mobile\Comag;
use BrowserDetector\Detector\Device\Mobile\Coolpad;
use BrowserDetector\Detector\Device\Mobile\Cosmote;
use BrowserDetector\Detector\Device\Mobile\Creative;
use BrowserDetector\Detector\Device\Mobile\Cube;
use BrowserDetector\Detector\Device\Mobile\Cubot;
use BrowserDetector\Detector\Device\Mobile\Dell;
use BrowserDetector\Detector\Device\Mobile\Denver;
use BrowserDetector\Detector\Device\Mobile\Dexp;
use BrowserDetector\Detector\Device\Mobile\Dfunc;
use BrowserDetector\Detector\Device\Mobile\Digma;
use BrowserDetector\Detector\Device\Mobile\Dino;
use BrowserDetector\Detector\Device\Mobile\Dns;
use BrowserDetector\Detector\Device\Mobile\DoCoMo;
use BrowserDetector\Detector\Device\Mobile\Easypix;
use BrowserDetector\Detector\Device\Mobile\Efox;
use BrowserDetector\Detector\Device\Mobile\EinsUndEins;
use BrowserDetector\Detector\Device\Mobile\Epad;
use BrowserDetector\Detector\Device\Mobile\Ergo;
use BrowserDetector\Detector\Device\Mobile\Exeq;
use BrowserDetector\Detector\Device\Mobile\Explay;
use BrowserDetector\Detector\Device\Mobile\Fairphone;
use BrowserDetector\Detector\Device\Mobile\FaktorZwei;
use BrowserDetector\Detector\Device\Mobile\Feiteng;
use BrowserDetector\Detector\Device\Mobile\Fly;
use BrowserDetector\Detector\Device\Mobile\Flytouch;
use BrowserDetector\Detector\Device\Mobile\Fujitsu;
use BrowserDetector\Detector\Device\Mobile\Geniatech;
use BrowserDetector\Detector\Device\Mobile\Gionee;
use BrowserDetector\Detector\Device\Mobile\GoClever;
use BrowserDetector\Detector\Device\Mobile\Hannspree;
use BrowserDetector\Detector\Device\Mobile\Hdc;
use BrowserDetector\Detector\Device\Mobile\Highscreen;
use BrowserDetector\Detector\Device\Mobile\HiPhone;
use BrowserDetector\Detector\Device\Mobile\Honlin;
use BrowserDetector\Detector\Device\Mobile\Hp;
use BrowserDetector\Detector\Device\Mobile\Htc;
use BrowserDetector\Detector\Device\Mobile\Htm;
use BrowserDetector\Detector\Device\Mobile\Huawei;
use BrowserDetector\Detector\Device\Mobile\IconBit;
use BrowserDetector\Detector\Device\Mobile\Impression;
use BrowserDetector\Detector\Device\Mobile\Inew;
use BrowserDetector\Detector\Device\Mobile\Intego;
use BrowserDetector\Detector\Device\Mobile\Intenso;
use BrowserDetector\Detector\Device\Mobile\Intex;
use BrowserDetector\Detector\Device\Mobile\Ionik;
use BrowserDetector\Detector\Device\Mobile\Irbis;
use BrowserDetector\Detector\Device\Mobile\Irulu;
use BrowserDetector\Detector\Device\Mobile\Jaytech;
use BrowserDetector\Detector\Device\Mobile\Jolla;
use BrowserDetector\Detector\Device\Mobile\Kazam;
use BrowserDetector\Detector\Device\Mobile\Kddi;
use BrowserDetector\Detector\Device\Mobile\KeenHigh;
use BrowserDetector\Detector\Device\Mobile\Keneksi;
use BrowserDetector\Detector\Device\Mobile\Kiano;
use BrowserDetector\Detector\Device\Mobile\Kingzone;
use BrowserDetector\Detector\Device\Mobile\Kobo;
use BrowserDetector\Detector\Device\Mobile\Lenco;
use BrowserDetector\Detector\Device\Mobile\Lenovo;
use BrowserDetector\Detector\Device\Mobile\LePan;
use BrowserDetector\Detector\Device\Mobile\Lg;
use BrowserDetector\Detector\Device\Mobile\Logikpd;
use BrowserDetector\Detector\Device\Mobile\Magic;
use BrowserDetector\Detector\Device\Mobile\Malata;
use BrowserDetector\Detector\Device\Mobile\Manta;
use BrowserDetector\Detector\Device\Mobile\Master;
use BrowserDetector\Detector\Device\Mobile\Mastone;
use BrowserDetector\Detector\Device\Mobile\Medion;
use BrowserDetector\Detector\Device\Mobile\Meizu;
use BrowserDetector\Detector\Device\Mobile\Memup;
use BrowserDetector\Detector\Device\Mobile\Micromax;
use BrowserDetector\Detector\Device\Mobile\Microsoft;
use BrowserDetector\Detector\Device\Mobile\Miui;
use BrowserDetector\Detector\Device\Mobile\Mobistel;
use BrowserDetector\Detector\Device\Mobile\Modecom;
use BrowserDetector\Detector\Device\Mobile\Motorola;
use BrowserDetector\Detector\Device\Mobile\Msi;
use BrowserDetector\Detector\Device\Mobile\Mtc;
use BrowserDetector\Detector\Device\Mobile\Mway;
use BrowserDetector\Detector\Device\Mobile\Mytab;
use BrowserDetector\Detector\Device\Mobile\Nec;
use BrowserDetector\Detector\Device\Mobile\Neofonie;
use BrowserDetector\Detector\Device\Mobile\Nextbook;
use BrowserDetector\Detector\Device\Mobile\Ngm;
use BrowserDetector\Detector\Device\Mobile\Nintendo;
use BrowserDetector\Detector\Device\Mobile\Nokia;
use BrowserDetector\Detector\Device\Mobile\Nomi;
use BrowserDetector\Detector\Device\Mobile\NttSystem;
use BrowserDetector\Detector\Device\Mobile\Nuqleo;
use BrowserDetector\Detector\Device\Mobile\Nvsbl;
use BrowserDetector\Detector\Device\Mobile\O2;
use BrowserDetector\Detector\Device\Mobile\Odys;
use BrowserDetector\Detector\Device\Mobile\Olivetti;
use BrowserDetector\Detector\Device\Mobile\Onda;
use BrowserDetector\Detector\Device\Mobile\Oppo;
use BrowserDetector\Detector\Device\Mobile\Orange;
use BrowserDetector\Detector\Device\Mobile\Overmax;
use BrowserDetector\Detector\Device\Mobile\Panasonic;
use BrowserDetector\Detector\Device\Mobile\Pandigital;
use BrowserDetector\Detector\Device\Mobile\Pantech;
use BrowserDetector\Detector\Device\Mobile\Pearl;
use BrowserDetector\Detector\Device\Mobile\Pentagram;
use BrowserDetector\Detector\Device\Mobile\Phicomm;
use BrowserDetector\Detector\Device\Mobile\Philips;
use BrowserDetector\Detector\Device\Mobile\Pipo;
use BrowserDetector\Detector\Device\Mobile\Pmedia;
use BrowserDetector\Detector\Device\Mobile\PocketBook;
use BrowserDetector\Detector\Device\Mobile\PointOfView;
use BrowserDetector\Detector\Device\Mobile\Pomp;
use BrowserDetector\Detector\Device\Mobile\Prestigio;
use BrowserDetector\Detector\Device\Mobile\Pulid;
use BrowserDetector\Detector\Device\Mobile\Qmobile;
use BrowserDetector\Detector\Device\Mobile\Ritmix;
use BrowserDetector\Detector\Device\Mobile\Samsung;
use BrowserDetector\Detector\Device\Mobile\Sanyo;
use BrowserDetector\Detector\Device\Mobile\Senseit;
use BrowserDetector\Detector\Device\Mobile\Shaan;
use BrowserDetector\Detector\Device\Mobile\Sharp;
use BrowserDetector\Detector\Device\Mobile\Shiru;
use BrowserDetector\Detector\Device\Mobile\Siemens;
use BrowserDetector\Detector\Device\Mobile\Simvalley;
use BrowserDetector\Detector\Device\Mobile\SonyEricsson;
use BrowserDetector\Detector\Device\Mobile\Sprd;
use BrowserDetector\Detector\Device\Mobile\Sprint;
use BrowserDetector\Detector\Device\Mobile\Star;
use BrowserDetector\Detector\Device\Mobile\Sunstech;
use BrowserDetector\Detector\Device\Mobile\Sxz;
use BrowserDetector\Detector\Device\Mobile\Symphony;
use BrowserDetector\Detector\Device\Mobile\TbTouch;
use BrowserDetector\Detector\Device\Mobile\Technisat;
use BrowserDetector\Detector\Device\Mobile\Tesla;
use BrowserDetector\Detector\Device\Mobile\Texet;
use BrowserDetector\Detector\Device\Mobile\Thl;
use BrowserDetector\Detector\Device\Mobile\Tmobile;
use BrowserDetector\Detector\Device\Mobile\Tolino;
use BrowserDetector\Detector\Device\Mobile\Toshiba;
use BrowserDetector\Detector\Device\Mobile\TrekStor;
use BrowserDetector\Detector\Device\Mobile\TriQ;
use BrowserDetector\Detector\Device\Mobile\Triray;
use BrowserDetector\Detector\Device\Mobile\Twz;
use BrowserDetector\Detector\Device\Mobile\Ultrafone;
use BrowserDetector\Detector\Device\Mobile\United;
use BrowserDetector\Detector\Device\Mobile\UtStarcom;
use BrowserDetector\Detector\Device\Mobile\Videocon;
use BrowserDetector\Detector\Device\Mobile\ViewSonic;
use BrowserDetector\Detector\Device\Mobile\Vivo;
use BrowserDetector\Detector\Device\Mobile\Vizio;
use BrowserDetector\Detector\Device\Mobile\Wexler;
use BrowserDetector\Detector\Device\Mobile\Wiko;
use BrowserDetector\Detector\Device\Mobile\Wolgang;
use BrowserDetector\Detector\Device\Mobile\WonderMedia;
use BrowserDetector\Detector\Device\Mobile\Xiaomi;
use BrowserDetector\Detector\Device\Mobile\Xoro;
use BrowserDetector\Detector\Device\Mobile\Yarvik;
use BrowserDetector\Detector\Device\Mobile\Yuandao;
use BrowserDetector\Detector\Device\Mobile\Yusu;
use BrowserDetector\Detector\Device\Mobile\Zeki;
use BrowserDetector\Detector\Device\Mobile\Zenithink;
use BrowserDetector\Detector\Device\Mobile\Zopo;
use BrowserDetector\Detector\Device\Mobile\Zte;
use Psr\Log\LoggerInterface;
use UaMatcher\Device\DeviceHasChildrenInterface;

/**
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class MobileFactory
{
    /**
     * detects the device name from the given user agent
     *
     * @param string                   $useragent
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \BrowserDetector\Detector\Device\AbstractDevice
     */
    public static function detect($useragent, LoggerInterface $logger)
    {
        if (preg_match('/(HiPhone|V919)/i', $useragent)) {
            $device = new HiPhone($useragent, $logger);
        } elseif (preg_match('/(Technisat|TechniPad)/', $useragent)) {
            $device = new Technisat($useragent, $logger);
        } elseif (preg_match('/nokia/i', $useragent)) {
            $device = new Nokia($useragent, $logger);
        } elseif (preg_match('/(ipad|iphone|ipod|like mac os x)/i', $useragent)
            && !preg_match('/windows phone/i', $useragent)
        ) {
            $device = new Apple($useragent, $logger);
        } elseif (preg_match('/samsung/i', $useragent)) {
            $device = new Samsung($useragent, $logger);
        } elseif (preg_match('/asus/i', $useragent)) {
            $device = new Asus($useragent, $logger);
        } elseif (preg_match('/MT\-GT\-A9500/i', $useragent)) {
            $device = new Htm($useragent, $logger);
        } elseif (preg_match('/GT\-A7100/i', $useragent)) {
            $device = new Sprd($useragent, $logger);
        } elseif (preg_match('/(Feiteng|GT\-H)/i', $useragent)) {
            $device = new Feiteng($useragent, $logger);
        } elseif (preg_match('/(cube|U30GT|U51GT)/i', $useragent)) {
            $device = new Cube($useragent, $logger);
        } elseif (preg_match('/(gt|sam|sc|sch|sec|sgh|shv|shw|sm|sph|continuum)\-/i', $useragent)) {
            $device = new Samsung($useragent, $logger);
        } elseif (preg_match('/(HDC|Galaxy S3 EX)/i', $useragent)) {
            $device = new Hdc($useragent, $logger);
        } elseif (preg_match('/nexus (4|5)/i', $useragent)) {
            $device = new Lg($useragent, $logger);
        } elseif (preg_match('/nexus 7/i', $useragent)) {
            $device = new Asus($useragent, $logger);
        } elseif (preg_match('/nexus 6/i', $useragent)) {
            $device = new Motorola($useragent, $logger);
        } elseif (preg_match('/nexus one/i', $useragent)) {
            $device = new Htc($useragent, $logger);
        } elseif (preg_match('/(galaxy|nexus|i7110|i9100|i9300|yp\-g|blaze)/i', $useragent)) {
            $device = new Samsung($useragent, $logger);
        } elseif (preg_match('/sony/i', $useragent)) {
            $device = new SonyEricsson($useragent, $logger);
        } elseif (preg_match('/LG/', $useragent)) {
            $device = new Lg($useragent, $logger);
        } elseif (preg_match('/htc/i', $useragent) && !preg_match('/WOHTC/', $useragent)) {
            $device = new Htc($useragent, $logger);
        } elseif (preg_match('/(lenovo|ideatab|ideapad|smarttab)/i', $useragent)) {
            $device = new Lenovo($useragent, $logger);
        } elseif (preg_match('/(acer|iconia)/i', $useragent)) {
            $device = new Acer($useragent, $logger);
        } elseif (preg_match('/PLAYSTATION/i', $useragent)) {
            $device = new SonyEricsson($useragent, $logger);
        } elseif (preg_match('/(amazon|kindle|silk|KFTT|KFOT|KFJWI|KFSOWI|KFTHWI|SD4930UR)/i', $useragent)) {
            $device = new Amazon($useragent, $logger);
        } elseif (preg_match('/amoi/i', $useragent)) {
            $device = new Amoi($useragent, $logger);
        } elseif (preg_match('/(Blaupunkt|Endeavour)/i', $useragent)) {
            $device = new Blaupunkt($useragent, $logger);
        } elseif (preg_match('/ONDA/', $useragent)) {
            $device = new Onda($useragent, $logger);
        } elseif (preg_match('/archos/i', $useragent)) {
            $device = new Archos($useragent, $logger);
        } elseif (preg_match('/IRULU/', $useragent)) {
            $device = new Irulu($useragent, $logger);
        } elseif (preg_match('/Symphony/', $useragent)) {
            $device = new Symphony($useragent, $logger);
        } elseif (preg_match('/arnova/i', $useragent)) {
            $device = new Arnova($useragent, $logger);
        } elseif (preg_match('/ bn /i', $useragent)) {
            $device = new BarnesNoble($useragent, $logger);
        } elseif (preg_match('/beidou/i', $useragent)) {
            $device = new Beidou($useragent, $logger);
        } elseif (preg_match('/(BlackBerry|PlayBook|RIM Tablet|BB10)/i', $useragent)) {
            $device = new BlackBerry($useragent, $logger);
        } elseif (preg_match('/caterpillar/i', $useragent)) {
            $device = new Caterpillar($useragent, $logger);
        } elseif (preg_match('/B15/', $useragent)) {
            $device = new Caterpillar($useragent, $logger);
        } elseif (preg_match('/(CatNova|Cat StarGate|Cat Tablet)/i', $useragent)) {
            $device = new CatSound($useragent, $logger);
        } elseif (preg_match('/(Coby|NBPC724|MID\d{4})/i', $useragent)) {
            $device = new Coby($useragent, $logger);
        } elseif (preg_match('/(Comag|WTDR1018)/i', $useragent)) {
            $device = new Comag($useragent, $logger);
        } elseif (preg_match('/coolpad/i', $useragent)) {
            $device = new Coolpad($useragent, $logger);
        } elseif (preg_match('/cosmote/i', $useragent)) {
            $device = new Cosmote($useragent, $logger);
        } elseif (preg_match('/(Creative|ZiiLABS)/i', $useragent)) {
            $device = new Creative($useragent, $logger);
        } elseif (preg_match('/cubot/i', $useragent)) {
            $device = new Cubot($useragent, $logger);
        } elseif (preg_match('/dell/i', $useragent)) {
            $device = new Dell($useragent, $logger);
        } elseif (preg_match('/(Denver|TAD\-)/i', $useragent)) {
            $device = new Denver($useragent, $logger);
        } elseif (preg_match('/(nec|n905i)/i', $useragent) && !preg_match('/fennec/i', $useragent)) {
            $device = new Nec($useragent, $logger);
        } elseif (preg_match('/(DoCoMo|P900i)/i', $useragent)) {
            $device = new DoCoMo($useragent, $logger);
        } elseif (preg_match('/(Easypix|EasyPad|Junior 4\.0)/i', $useragent)) {
            $device = new Easypix($useragent, $logger);
        } elseif (preg_match('/(Efox|SMART\-E5)/', $useragent)) {
            $device = new Efox($useragent, $logger);
        } elseif (preg_match('/1 \& 1/i', $useragent)) {
            $device = new EinsUndEins($useragent, $logger);
        } elseif (preg_match('/p7901a/i', $useragent)) {
            $device = new Epad($useragent, $logger);
        } elseif (preg_match('/FaktorZwei/i', $useragent)) {
            $device = new FaktorZwei($useragent, $logger);
        } elseif (preg_match('/Flytouch/i', $useragent)) {
            $device = new Flytouch($useragent, $logger);
        } elseif (preg_match('/(Fujitsu|M532)/i', $useragent)) {
            $device = new Fujitsu($useragent, $logger);
        } elseif (preg_match('/SN10T1/i', $useragent)) {
            $device = new Hannspree($useragent, $logger);
        } elseif (preg_match('/(Honlin|PC1088|HL)/', $useragent)) {
            $device = new Honlin($useragent, $logger);
        } elseif (preg_match('/Huawei/i', $useragent)) {
            $device = new Huawei($useragent, $logger);
        } elseif (preg_match('/micromax/i', $useragent)) {
            $device = new Micromax($useragent, $logger);
        } elseif (preg_match('/triray/i', $useragent)) {
            $device = new Triray($useragent, $logger);
        } elseif (preg_match('/SXZ/', $useragent)) {
            $device = new Sxz($useragent, $logger);
        } elseif (preg_match('/explay/i', $useragent)) {
            $device = new Explay($useragent, $logger);
        } elseif (preg_match('/pmedia/i', $useragent)) {
            $device = new Pmedia($useragent, $logger);
        } elseif (preg_match('/impression/i', $useragent)) {
            $device = new Impression($useragent, $logger);
        } elseif (preg_match('/kingzone/i', $useragent)) {
            $device = new Kingzone($useragent, $logger);
        } elseif (preg_match('/sunstech/i', $useragent)) {
            $device = new Sunstech($useragent, $logger);
        } elseif (preg_match('/Pantech/i', $useragent)) {
            $device = new Pantech($useragent, $logger);
        } elseif (preg_match('/(HP|P160U|TouchPad|Pixi|palm|Blazer|cm_tenderloin)/i', $useragent)) {
            $device = new Hp($useragent, $logger);
        } elseif (preg_match('/IconBit/i', $useragent)) {
            $device = new IconBit($useragent, $logger);
        } elseif (preg_match('/(INM803HC|INM8002KP)/', $useragent)) {
            $device = new Intenso($useragent, $logger);
        } elseif (preg_match('/ionik/i', $useragent)) {
            $device = new Ionik($useragent, $logger);
        } elseif (preg_match('/JAY\-tech/i', $useragent)) {
            $device = new Jaytech($useragent, $logger);
        } elseif (preg_match('/(jolla|sailfish)/i', $useragent)) {
            $device = new Jolla($useragent, $logger);
        } elseif (preg_match('/KAZAM/i', $useragent)) {
            $device = new Kazam($useragent, $logger);
        } elseif (preg_match('/KDDI/i', $useragent)) {
            $device = new Kddi($useragent, $logger);
        } elseif (preg_match('/Kobo Touch/i', $useragent)) {
            $device = new Kobo($useragent, $logger);
        } elseif (preg_match('/Lenco/i', $useragent)) {
            $device = new Lenco($useragent, $logger);
        } elseif (preg_match('/LePan/i', $useragent)) {
            $device = new LePan($useragent, $logger);
        } elseif (preg_match('/(LogicPD|Zoom2|NookColor)/', $useragent)) {
            $device = new Logikpd($useragent, $logger);
        } elseif (preg_match('/(medion|LifeTab)/i', $useragent)) {
            $device = new Medion($useragent, $logger);
        } elseif (preg_match('/Meizu/i', $useragent)) {
            $device = new Meizu($useragent, $logger);
        } elseif (preg_match('/m\-way/i', $useragent)) {
            $device = new Mway($useragent, $logger);
        } elseif (preg_match('/Memup/i', $useragent)) {
            $device = new Memup($useragent, $logger);
        } elseif (preg_match('/miui/i', $useragent)
            && !preg_match('/miuibrowser/i', $useragent)
            && !preg_match('/build\/miui/i', $useragent)
        ) {
            $device = new Miui($useragent, $logger);
        } elseif (preg_match('/cynus/i', $useragent)) {
            $device = new Mobistel($useragent, $logger);
        } elseif (preg_match('/motorola/i', $useragent)) {
            $device = new Motorola($useragent, $logger);
        } elseif (preg_match('/WeTab/', $useragent)) {
            $device = new Neofonie($useragent, $logger);
        } elseif (preg_match('/Nextbook/', $useragent)) {
            $device = new Nextbook($useragent, $logger);
        } elseif (preg_match('/Nintendo/', $useragent)) {
            $device = new Nintendo($useragent, $logger);
        } elseif (preg_match('/Nvsbl/', $useragent)) {
            $device = new Nvsbl($useragent, $logger);
        } elseif (preg_match('/odys/i', $useragent)) {
            $device = new Odys($useragent, $logger);
        } elseif (preg_match('/oppo/i', $useragent)) {
            $device = new Oppo($useragent, $logger);
        } elseif (preg_match('/Panasonic/', $useragent)) {
            $device = new Panasonic($useragent, $logger);
        } elseif (preg_match('/pandigital/i', $useragent)) {
            $device = new Pandigital($useragent, $logger);
        } elseif (preg_match('/Phicomm/', $useragent)) {
            $device = new Phicomm($useragent, $logger);
        } elseif (preg_match('/pipo/i', $useragent)) {
            $device = new Pipo($useragent, $logger);
        } elseif (preg_match('/pomp/i', $useragent)) {
            $device = new Pomp($useragent, $logger);
        } elseif (preg_match('/Prestigio/', $useragent)) {
            $device = new Prestigio($useragent, $logger);
        } elseif (preg_match('/QMobile/', $useragent)) {
            $device = new Qmobile($useragent, $logger);
        } elseif (preg_match('/Sanyo/', $useragent)) {
            $device = new Sanyo($useragent, $logger);
        } elseif (preg_match('/SHARP/', $useragent)) {
            $device = new Sharp($useragent, $logger);
        } elseif (preg_match('/Siemens/', $useragent)) {
            $device = new Siemens($useragent, $logger);
        } elseif (preg_match('/Sprint/', $useragent)) {
            $device = new Sprint($useragent, $logger);
        } elseif (preg_match('/Star/', $useragent) && !preg_match('/Aqua\_Star/', $useragent)) {
            $device = new Star($useragent, $logger);
        } elseif (preg_match('/texet/i', $useragent)) {
            $device = new Texet($useragent, $logger);
        } elseif (preg_match('/alcatel/i', $useragent)) {
            $device = new Alcatel($useragent, $logger);
        } elseif (preg_match('/thl/i', $useragent) && !preg_match('/LIAuthLibrary/', $useragent)) {
            $device = new Thl($useragent, $logger);
        } elseif (preg_match('/T\-Mobile/', $useragent)) {
            $device = new Tmobile($useragent, $logger);
        } elseif (preg_match('/tolino/i', $useragent)) {
            $device = new Tolino($useragent, $logger);
        } elseif (preg_match('/Toshiba/i', $useragent)) {
            $device = new Toshiba($useragent, $logger);
        } elseif (preg_match('/TrekStor/', $useragent)) {
            $device = new TrekStor($useragent, $logger);
        } elseif (preg_match('/3Q/', $useragent)) {
            $device = new TriQ($useragent, $logger);
        } elseif (preg_match('/(ViewSonic|ViewPad)/', $useragent)) {
            $device = new ViewSonic($useragent, $logger);
        } elseif (preg_match('/Wiko/', $useragent)) {
            $device = new Wiko($useragent, $logger);
        } elseif (preg_match('/vivo/', $useragent)) {
            $device = new Vivo($useragent, $logger);
        } elseif (preg_match('/xiaomi/i', $useragent)) {
            $device = new Xiaomi($useragent, $logger);
        } elseif (preg_match('/MI \d/', $useragent)) {
            $device = new Xiaomi($useragent, $logger);
        } elseif (preg_match('/HM (NOTE|1SC)/', $useragent)) {
            $device = new Xiaomi($useragent, $logger);
        } elseif (preg_match('/yuandao/i', $useragent)) {
            $device = new Yuandao($useragent, $logger);
        } elseif (preg_match('/Yusu/', $useragent)) {
            $device = new Yusu($useragent, $logger);
        } elseif (preg_match('/Zenithink/i', $useragent)) {
            $device = new Zenithink($useragent, $logger);
        } elseif (preg_match('/zte/i', $useragent)) {
            $device = new Zte($useragent, $logger);
        } elseif (preg_match('/Fly/', $useragent)) {
            $device = new Fly($useragent, $logger);
        } elseif (preg_match('/PocketBook/', $useragent)) {
            $device = new PocketBook($useragent, $logger);
        } elseif (preg_match('/Geniatech/', $useragent)) {
            $device = new Geniatech($useragent, $logger);
        } elseif (preg_match('/Yarvik/', $useragent)) {
            $device = new Yarvik($useragent, $logger);
        } elseif (preg_match('/GOCLEVER/', $useragent)) {
            $device = new GoClever($useragent, $logger);
        } elseif (preg_match('/senseit/i', $useragent)) {
            $device = new Senseit($useragent, $logger);
        } elseif (preg_match('/twz/i', $useragent)) {
            $device = new Twz($useragent, $logger);
        } elseif (preg_match('/irbis/i', $useragent)) {
            $device = new Irbis($useragent, $logger);
        } elseif (preg_match('/NGM/', $useragent)) {
            $device = new Ngm($useragent, $logger);
        } elseif (preg_match('/dino/i', $useragent)) {
            $device = new Dino($useragent, $logger);
        } elseif (preg_match('/(shaan|iball)/i', $useragent)) {
            $device = new Shaan($useragent, $logger);
        } elseif (preg_match('/bmobile/i', $useragent) && !preg_match('/icabmobile/i', $useragent)) {
            $device = new Bmobile($useragent, $logger);
        } elseif (preg_match('/modecom/i', $useragent)) {
            $device = new Modecom($useragent, $logger);
        } elseif (preg_match('/overmax/i', $useragent)) {
            $device = new Overmax($useragent, $logger);
        } elseif (preg_match('/kiano/i', $useragent)) {
            $device = new Kiano($useragent, $logger);
        } elseif (preg_match('/manta/i', $useragent)) {
            $device = new Manta($useragent, $logger);
        } elseif (preg_match('/philips/i', $useragent)) {
            $device = new Philips($useragent, $logger);
        } elseif (preg_match('/shiru/i', $useragent)) {
            $device = new Shiru($useragent, $logger);
        } elseif (preg_match('/TB Touch/i', $useragent)) {
            $device = new TbTouch($useragent, $logger);
        } elseif (preg_match('/NTT/', $useragent)) {
            $device = new NttSystem($useragent, $logger);
        } elseif (preg_match('/pentagram/i', $useragent)) {
            $device = new Pentagram($useragent, $logger);
        } elseif (preg_match('/zeki/i', $useragent)) {
            $device = new Zeki($useragent, $logger);
        } elseif (preg_match('/DFunc/', $useragent)) {
            $device = new Dfunc($useragent, $logger);
        } elseif (preg_match('/Digma/', $useragent)) {
            $device = new Digma($useragent, $logger);
        } elseif (preg_match('/zopo/i', $useragent)) {
            $device = new Zopo($useragent, $logger);
        } elseif (preg_match('/ MT791 /i', $useragent)) {
            $device = new KeenHigh($useragent, $logger);
        } elseif (preg_match('/(g100w|stream\-s110)/i', $useragent)) {
            $device = new Acer($useragent, $logger);
        } elseif (preg_match('/ (a1|a3|b1)\-/i', $useragent)) {
            $device = new Acer($useragent, $logger);
        } elseif (preg_match('/wildfire/i', $useragent)) {
            $device = new Htc($useragent, $logger);
        } elseif (preg_match('/a101it/i', $useragent)) {
            $device = new Archos($useragent, $logger);
        } elseif (preg_match('/(sprd|SPHS|B51\+)/i', $useragent)) {
            $device = new Sprd($useragent, $logger);
        } elseif (preg_match('/TAB A742/', $useragent)) {
            $device = new Wexler($useragent, $logger);
        } elseif (preg_match('/ (a|e|v|z|s)\d{3} /i', $useragent)) {
            $device = new Acer($useragent, $logger);
        } elseif (preg_match('/AT\-AS40SE/', $useragent)) {
            $device = new Wolgang($useragent, $logger);
        } elseif (preg_match('/(United|MT6515M)/', $useragent)) {
            $device = new United($useragent, $logger);
        } elseif (preg_match('/ultrafone/', $useragent)) {
            $device = new Ultrafone($useragent, $logger);
        } elseif (preg_match('/malata/i', $useragent)) {
            $device = new Malata($useragent, $logger);
        } elseif (preg_match('/(utstarcom|GTX75)/i', $useragent)) {
            $device = new UtStarcom($useragent, $logger);
        } elseif (preg_match('/(Fairphone|FP1)/i', $useragent)) {
            $device = new Fairphone($useragent, $logger);
        } elseif (preg_match('/(Videocon|A15)/', $useragent)) {
            $device = new Videocon($useragent, $logger);
        } elseif (preg_match('/intex/i', $useragent)) {
            $device = new Intex($useragent, $logger);
        } elseif (preg_match('/mastone/i', $useragent)) {
            $device = new Mastone($useragent, $logger);
        } elseif (preg_match('/BLU/', $useragent)) {
            $device = new Blu($useragent, $logger);
        } elseif (preg_match('/Nuqleo/', $useragent)) {
            $device = new Nuqleo($useragent, $logger);
        } elseif (preg_match('/ritmix/i', $useragent)) {
            $device = new Ritmix($useragent, $logger);
        } elseif (preg_match('/wexler/i', $useragent)) {
            $device = new Wexler($useragent, $logger);
        } elseif (preg_match('/exeq/i', $useragent)) {
            $device = new Exeq($useragent, $logger);
        } elseif (preg_match('/ergo/i', $useragent)) {
            $device = new Ergo($useragent, $logger);
        } elseif (preg_match('/pulid/i', $useragent)) {
            $device = new Pulid($useragent, $logger);
        } elseif (preg_match('/dns/i', $useragent)) {
            $device = new Dns($useragent, $logger);
        } elseif (preg_match('/dexp/i', $useragent)) {
            $device = new Dexp($useragent, $logger);
        } elseif (preg_match('/keneksi/i', $useragent)) {
            $device = new Keneksi($useragent, $logger);
        } elseif (preg_match('/gionee/i', $useragent)) {
            $device = new Gionee($useragent, $logger);
        } elseif (preg_match('/highscreen/i', $useragent)) {
            $device = new Highscreen($useragent, $logger);
        } elseif (preg_match('/nomi/i', $useragent)) {
            $device = new Nomi($useragent, $logger);
        } elseif (preg_match('/AIS/', $useragent)) {
            $device = new Ais($useragent, $logger);
        } elseif (preg_match('/CIOtCUD/i', $useragent)) {
            $device = new Ciotcud($useragent, $logger);
        } elseif (preg_match('/iNew/', $useragent)) {
            $device = new Inew($useragent, $logger);
        } elseif (preg_match('/Intego/', $useragent)) {
            $device = new Intego($useragent, $logger);
        } elseif (preg_match('/MTC/', $useragent)) {
            $device = new Mtc($useragent, $logger);
        } elseif (preg_match('/DARKMOON/', $useragent)) {
            $device = new Wiko($useragent, $logger);
        } elseif (preg_match('/ARK/', $useragent)) {
            $device = new Ark($useragent, $logger);
        } elseif (preg_match('/Magic/', $useragent)) {
            $device = new Magic($useragent, $logger);
        } elseif (preg_match('/BQS/', $useragent)) {
            $device = new Bq($useragent, $logger);
        } elseif (preg_match('/BQ \d{4}/', $useragent)) {
            $device = new Bq($useragent, $logger);
        } elseif (preg_match('/msi/i', $useragent) && !preg_match('/msie/i', $useragent)) {
            $device = new Msi($useragent, $logger);
        } elseif (preg_match('/Orange/', $useragent)) {
            $device = new Orange($useragent, $logger);
        } elseif (preg_match('/myTAB/', $useragent)) {
            $device = new Mytab($useragent, $logger);
        } elseif (preg_match('/(LOOX|UNO\_X10|Xelio 7|NEO\_QUAD10)/i', $useragent)) {
            $device = new Odys($useragent, $logger);
        } elseif (preg_match('/iPh\d\,\d/', $useragent)) {
            $device = new Apple($useragent, $logger);
        } elseif (preg_match('/Puffin\/[\d\.]+IT/', $useragent)) {
            $device = new Apple\Ipad($useragent, $logger);
        } elseif (preg_match('/Puffin\/[\d\.]+IP/', $useragent)) {
            $device = new Apple\Iphone($useragent, $logger);
        } elseif (preg_match('/dataaccessd/', $useragent)) {
            $device = new Apple($useragent, $logger);
        } elseif (preg_match('/Pre/', $useragent) && !preg_match('/Presto/', $useragent)) {
            $device = new Hp($useragent, $logger);
        } elseif (preg_match('/(Z221|V788D|KIS PLUS|NX402|NX501|N918St|Beeline Pro)/', $useragent)) {
            $device = new Zte($useragent, $logger);
        } elseif (preg_match('/ME\d{3}[A-Z]/', $useragent)) {
            $device = new Asus($useragent, $logger);
        } elseif (preg_match('/(PadFone|Transformer)/', $useragent)) {
            $device = new Asus($useragent, $logger);
        } elseif (preg_match('/K0(0|1)[0-9a-zA-Z]/', $useragent)) {
            $device = new Asus($useragent, $logger);
        } elseif (preg_match('/QtCarBrowser/', $useragent)) {
            $device = new Tesla($useragent, $logger);
        } elseif (preg_match('/MOT/', $useragent)) {
            $device = new Motorola($useragent, $logger);
        } elseif (preg_match('/MB\d{3}/', $useragent)) {
            $device = new Motorola($useragent, $logger);
        } elseif (preg_match('/smart tab/i', $useragent)) {
            $device = new Lenovo($useragent, $logger);
        } elseif (preg_match('/one (s|x)/i', $useragent)) {
            $device = new Htc($useragent, $logger);
        } elseif (preg_match('/Tablet\-PC\-4/', $useragent)) {
            $device = new CatSound($useragent, $logger);
        } elseif (preg_match('/TBD\d{4}/', $useragent)) {
            $device = new Zeki($useragent, $logger);
        } elseif (preg_match('/TBD(B|C)\d{3,4}/', $useragent)) {
            $device = new Zeki($useragent, $logger);
        } elseif (preg_match('/AC0732C/', $useragent)) {
            $device = new TriQ($useragent, $logger);
        } elseif (preg_match('/(C|D)\d{4}/', $useragent)) {
            $device = new SonyEricsson($useragent, $logger);
        } elseif (preg_match('/SGP\d{3}/', $useragent)) {
            $device = new SonyEricsson($useragent, $logger);
        } elseif (preg_match('/sgpt\d{2}/i', $useragent)) {
            $device = new SonyEricsson($useragent, $logger);
        } elseif (preg_match('/xperia/i', $useragent)) {
            $device = new SonyEricsson($useragent, $logger);
        } elseif (preg_match('/VS\d{3}/', $useragent)) {
            $device = new Lg($useragent, $logger);
        } elseif (preg_match('/(SurfTab|VT10416|breeze 10\.1 quad)/', $useragent)) {
            $device = new TrekStor($useragent, $logger);
        } elseif (preg_match('/AT\d{2,3}/', $useragent)) {
            $device = new Toshiba($useragent, $logger);
        } elseif (preg_match('/(PAP|PMP|PMT)/', $useragent)) {
            $device = new Prestigio($useragent, $logger);
        } elseif (preg_match('/(APA9292KT|PJ83100|831C|Evo 3D GSM|Eris 2\.1)/', $useragent)) {
            $device = new Htc($useragent, $logger);
        } elseif (preg_match('/(pcdadr6350)/i', $useragent)) {
            $device = new Htc($useragent, $logger);
        } elseif (preg_match('/Aqua\_Star/', $useragent)) {
            $device = new Intex($useragent, $logger);
        } elseif (preg_match('/NEXT/', $useragent)) {
            $device = new Nextbook($useragent, $logger);
        } elseif (preg_match('/XT\d{3,4}/', $useragent)) {
            $device = new Motorola($useragent, $logger);
        } elseif (preg_match('/( droid)/i', $useragent)) {
            $device = new Motorola($useragent, $logger);
        } elseif (preg_match('/(S|L|W|M)T\d{2}/', $useragent)) {
            $device = new SonyEricsson($useragent, $logger);
        } elseif (preg_match('/SO-03E/', $useragent)) {
            $device = new SonyEricsson($useragent, $logger);
        } elseif (preg_match('/VIVO/', $useragent)) {
            $device = new Blu($useragent, $logger);
        } elseif (preg_match('/NOOK/', $useragent)) {
            $device = new BarnesNoble($useragent, $logger);
        } elseif (preg_match('/Zaffire/', $useragent)) {
            $device = new Nuqleo($useragent, $logger);
        } elseif (preg_match('/BNRV\d{3}/', $useragent)) {
            $device = new BarnesNoble($useragent, $logger);
        } elseif (preg_match('/IQ\d{3,4}/', $useragent)) {
            $device = new Fly($useragent, $logger);
        } elseif (preg_match('/Phoenix 2/', $useragent)) {
            $device = new Fly($useragent, $logger);
        } elseif (preg_match('/TAB10\-400/', $useragent)) {
            $device = new Yarvik($useragent, $logger);
        } elseif (preg_match('/TQ\d{3}/', $useragent)) {
            $device = new GoClever($useragent, $logger);
        } elseif (preg_match('/RMD\-\d{3,4}/', $useragent)) {
            $device = new Ritmix($useragent, $logger);
        } elseif (preg_match('/(TERRA_101|ORION7o)/', $useragent)) {
            $device = new GoClever($useragent, $logger);
        } elseif (preg_match('/AX\d{3}/', $useragent)) {
            $device = new Bmobile($useragent, $logger);
        } elseif (preg_match('/FreeTAB \d{4}/', $useragent)) {
            $device = new Modecom($useragent, $logger);
        } elseif (preg_match('/Venue/', $useragent)) {
            $device = new Dell($useragent, $logger);
        } elseif (preg_match('/FunTab/', $useragent)) {
            $device = new Orange($useragent, $logger);
        } elseif (preg_match('/(OV\-|Solution 7III)/', $useragent)) {
            $device = new Overmax($useragent, $logger);
        } elseif (preg_match('/MT6572\_TD/', $useragent)) {
            $device = new Cubot($useragent, $logger);
        } elseif (preg_match('/Zanetti/', $useragent)) {
            $device = new Kiano($useragent, $logger);
        } elseif (preg_match('/MID\d{3}/', $useragent)) {
            $device = new Manta($useragent, $logger);
        } elseif (preg_match('/FWS610_EU/', $useragent)) {
            $device = new Phicomm($useragent, $logger);
        } elseif (preg_match('/FX2/', $useragent)) {
            $device = new FaktorZwei($useragent, $logger);
        } elseif (preg_match('/AN\d{1,2}/', $useragent)) {
            $device = new Arnova($useragent, $logger);
        } elseif (preg_match('/(Touchlet|X7G)/', $useragent)) {
            $device = new Pearl($useragent, $logger);
        } elseif (preg_match('/POV/', $useragent)) {
            $device = new PointOfView($useragent, $logger);
        } elseif (preg_match('/PI\d{4}/', $useragent)) {
            $device = new Philips($useragent, $logger);
        } elseif (preg_match('/SM \- /', $useragent)) {
            $device = new Samsung($useragent, $logger);
        } elseif (preg_match('/SH05C/', $useragent)) {
            $device = new Sharp($useragent, $logger);
        } elseif (preg_match('/SAMURAI10/', $useragent)) {
            $device = new Shiru($useragent, $logger);
        } elseif (preg_match('/Ignis 8/', $useragent)) {
            $device = new TbTouch($useragent, $logger);
        } elseif (preg_match('/A5000/', $useragent)) {
            $device = new SonyEricsson($useragent, $logger);
        } elseif (preg_match('/FUNC/', $useragent)) {
            $device = new Dfunc($useragent, $logger);
        } elseif (preg_match('/iD(j|n|s|x)D\d/', $useragent)) {
            $device = new Digma($useragent, $logger);
        } elseif (preg_match('/K910L/', $useragent)) {
            $device = new Lenovo($useragent, $logger);
        } elseif (preg_match('/TAB7iD/', $useragent)) {
            $device = new Wexler($useragent, $logger);
        } elseif (preg_match('/ZP\d{3}/', $useragent)) {
            $device = new Zopo($useragent, $logger);
        } elseif (preg_match('/S4505M/', $useragent)) {
            $device = new Dns($useragent, $logger);
        } elseif (preg_match('/ M3 /', $useragent)) {
            $device = new Gionee($useragent, $logger);
        } elseif (preg_match('/(W100|W200|W8_beyond)/', $useragent)) {
            $device = new Thl($useragent, $logger);
        } elseif (preg_match('/NT\-\d{4}(S|P|T)/', $useragent)) {
            $device = new IconBit($useragent, $logger);
        } elseif (preg_match('/Primo76/', $useragent)) {
            $device = new Msi($useragent, $logger);
        } elseif (preg_match('/CINK PEAX 2/', $useragent)) {
            $device = new Wiko($useragent, $logger);
        } elseif (preg_match('/T(X|G)\d{2}/', $useragent)) {
            $device = new Irbis($useragent, $logger);
        } elseif (preg_match('/(X-pad LITE|X-pad STYLE)/', $useragent)) {
            $device = new Texet($useragent, $logger);
        } elseif (preg_match('/ G3 /', $useragent)) {
            $device = new Lg($useragent, $logger);
        } elseif (preg_match('/Zera_F/', $useragent)) {
            $device = new Highscreen($useragent, $logger);
        } elseif (preg_match('/A10100/', $useragent)) {
            $device = new Nomi($useragent, $logger);
        } elseif (preg_match('/iris708/', $useragent)) {
            $device = new Ais($useragent, $logger);
        } elseif (preg_match('/L930/', $useragent)) {
            $device = new Ciotcud($useragent, $logger);
        } elseif (preg_match('/SMART Run/', $useragent)) {
            $device = new Mtc($useragent, $logger);
        } elseif (preg_match('/X8\+/', $useragent)) {
            $device = new Triray($useragent, $logger);
        } elseif (preg_match('/QS0716D/', $useragent)) {
            $device = new TriQ($useragent, $logger);
        } elseif (preg_match('/s4502M/', $useragent)) {
            $device = new Dns($useragent, $logger);
        } elseif (preg_match('/(Surfer 7\.34|M1_Plus)/', $useragent)) {
            $device = new Explay($useragent, $logger);
        } elseif (preg_match('/PMSmart450/', $useragent)) {
            $device = new Pmedia($useragent, $logger);
        } elseif (preg_match('/(F031|SCL24|ACE)/', $useragent)) {
            $device = new Samsung($useragent, $logger);
        } elseif (preg_match('/ImPAD/', $useragent)) {
            $device = new Impression($useragent, $logger);
        } elseif (preg_match('/K1 turbo/', $useragent)) {
            $device = new Kingzone($useragent, $logger);
        } elseif (preg_match('/TAB917QC\-8GB/', $useragent)) {
            $device = new Sunstech($useragent, $logger);
        } elseif (preg_match('/(TPC\-PA10\.1M|M7T)/', $useragent)) {
            $device = new Pipo($useragent, $logger);
        } elseif (preg_match('/ONE TOUCH/', $useragent)) {
            $device = new Alcatel($useragent, $logger);
        } elseif (preg_match('/MD948G/', $useragent)) {
            $device = new Mway($useragent, $logger);
        } elseif (preg_match('/P4501/', $useragent)) {
            $device = new Medion($useragent, $logger);
        } elseif (preg_match('/ V3 /', $useragent)) {
            $device = new Inew($useragent, $logger);
        } elseif (preg_match('/PX\-0905/', $useragent)) {
            $device = new Intego($useragent, $logger);
        } elseif (preg_match('/Smartphone650/', $useragent)) {
            $device = new Master($useragent, $logger);
        } elseif (preg_match('/MX Enjoy TV BOX/', $useragent)) {
            $device = new Geniatech($useragent, $logger);
        } elseif (preg_match('/TelePAD 9A1/', $useragent)) {
            $device = new Xoro($useragent, $logger);
        } elseif (preg_match('/ C7 /', $useragent)) {
            $device = new Cubot($useragent, $logger);
        } elseif (preg_match('/GV7777/', $useragent)) {
            $device = new Prestigio($useragent, $logger);
        } elseif (preg_match('/ N1 /', $useragent)) {
            $device = new Nokia($useragent, $logger);
        } elseif (preg_match('/N9500/', $useragent)) {
            $device = new Star($useragent, $logger);
        } elseif (preg_match('/CFNetwork/', $useragent)) {
            $device = new Apple($useragent, $logger);
        } else {
            $device = new GeneralMobile($useragent, $logger);
        }

        if ($device instanceof DeviceHasChildrenInterface) {
            $device = $device->detectDevice();
        }

        return $device;
    }
}
