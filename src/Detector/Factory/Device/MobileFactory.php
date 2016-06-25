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
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector\Factory\Device;

use BrowserDetector\Detector\Device\Mobile\Accent;
use BrowserDetector\Detector\Device\Mobile\Acer;
use BrowserDetector\Detector\Device\Mobile\Adspec;
use BrowserDetector\Detector\Device\Mobile\Advent;
use BrowserDetector\Detector\Device\Mobile\Ainol;
use BrowserDetector\Detector\Device\Mobile\Ais;
use BrowserDetector\Detector\Device\Mobile\Alcatel;
use BrowserDetector\Detector\Device\Mobile\AllWinner;
use BrowserDetector\Detector\Device\Mobile\Amazon;
use BrowserDetector\Detector\Device\Mobile\Amlogic;
use BrowserDetector\Detector\Device\Mobile\Amoi;
use BrowserDetector\Detector\Device\Mobile\Anka;
use BrowserDetector\Detector\Device\Mobile\Aoc;
use BrowserDetector\Detector\Device\Mobile\Apple;
use BrowserDetector\Detector\Device\Mobile\Archos;
use BrowserDetector\Detector\Device\Mobile\Ark;
use BrowserDetector\Detector\Device\Mobile\Arnova;
use BrowserDetector\Detector\Device\Mobile\Asus;
use BrowserDetector\Detector\Device\Mobile\Axgio;
use BrowserDetector\Detector\Device\Mobile\BarnesNoble;
use BrowserDetector\Detector\Device\Mobile\Beidou;
use BrowserDetector\Detector\Device\Mobile\BlackBerry;
use BrowserDetector\Detector\Device\Mobile\Blaupunkt;
use BrowserDetector\Detector\Device\Mobile\Bliss;
use BrowserDetector\Detector\Device\Mobile\Blu;
use BrowserDetector\Detector\Device\Mobile\Bmobile;
use BrowserDetector\Detector\Device\Mobile\Bq;
use BrowserDetector\Detector\Device\Mobile\Caterpillar;
use BrowserDetector\Detector\Device\Mobile\CatSound;
use BrowserDetector\Detector\Device\Mobile\Ciotcud;
use BrowserDetector\Detector\Device\Mobile\Coby;
use BrowserDetector\Detector\Device\Mobile\Comag;
use BrowserDetector\Detector\Device\Mobile\Condor;
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
use BrowserDetector\Detector\Device\Mobile\Elephone;
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
use BrowserDetector\Detector\Device\Mobile\GeneralMobile;
use BrowserDetector\Detector\Device\Mobile\Geniatech;
use BrowserDetector\Detector\Device\Mobile\Gfive;
use BrowserDetector\Detector\Device\Mobile\Gigabyte;
use BrowserDetector\Detector\Device\Mobile\Gionee;
use BrowserDetector\Detector\Device\Mobile\Globex;
use BrowserDetector\Detector\Device\Mobile\GoClever;
use BrowserDetector\Detector\Device\Mobile\Gzone;
use BrowserDetector\Detector\Device\Mobile\Haier;
use BrowserDetector\Detector\Device\Mobile\Haipai;
use BrowserDetector\Detector\Device\Mobile\Hannspree;
use BrowserDetector\Detector\Device\Mobile\Hdc;
use BrowserDetector\Detector\Device\Mobile\Highscreen;
use BrowserDetector\Detector\Device\Mobile\HiPhone;
use BrowserDetector\Detector\Device\Mobile\Honlin;
use BrowserDetector\Detector\Device\Mobile\Hp;
use BrowserDetector\Detector\Device\Mobile\Htc;
use BrowserDetector\Detector\Device\Mobile\Htm;
use BrowserDetector\Detector\Device\Mobile\Huawei;
use BrowserDetector\Detector\Device\Mobile\Hummer;
use BrowserDetector\Detector\Device\Mobile\IconBit;
use BrowserDetector\Detector\Device\Mobile\Imobile;
use BrowserDetector\Detector\Device\Mobile\Impression;
use BrowserDetector\Detector\Device\Mobile\Inew;
use BrowserDetector\Detector\Device\Mobile\Intego;
use BrowserDetector\Detector\Device\Mobile\Intenso;
use BrowserDetector\Detector\Device\Mobile\Intex;
use BrowserDetector\Detector\Device\Mobile\Ionik;
use BrowserDetector\Detector\Device\Mobile\Irbis;
use BrowserDetector\Detector\Device\Mobile\Iru;
use BrowserDetector\Detector\Device\Mobile\Irulu;
use BrowserDetector\Detector\Device\Mobile\Jaytech;
use BrowserDetector\Detector\Device\Mobile\Jolla;
use BrowserDetector\Detector\Device\Mobile\Kazam;
use BrowserDetector\Detector\Device\Mobile\Kddi;
use BrowserDetector\Detector\Device\Mobile\Keener;
use BrowserDetector\Detector\Device\Mobile\KeenHigh;
use BrowserDetector\Detector\Device\Mobile\Keneksi;
use BrowserDetector\Detector\Device\Mobile\Kiano;
use BrowserDetector\Detector\Device\Mobile\Kingzone;
use BrowserDetector\Detector\Device\Mobile\Kobo;
use BrowserDetector\Detector\Device\Mobile\Lenco;
use BrowserDetector\Detector\Device\Mobile\Lenovo;
use BrowserDetector\Detector\Device\Mobile\LePan;
use BrowserDetector\Detector\Device\Mobile\Lexand;
use BrowserDetector\Detector\Device\Mobile\Lg;
use BrowserDetector\Detector\Device\Mobile\Logicom;
use BrowserDetector\Detector\Device\Mobile\Logikpd;
use BrowserDetector\Detector\Device\Mobile\Magic;
use BrowserDetector\Detector\Device\Mobile\Malata;
use BrowserDetector\Detector\Device\Mobile\Manta;
use BrowserDetector\Detector\Device\Mobile\Master;
use BrowserDetector\Detector\Device\Mobile\Mastone;
use BrowserDetector\Detector\Device\Mobile\Medion;
use BrowserDetector\Detector\Device\Mobile\MegaFon;
use BrowserDetector\Detector\Device\Mobile\Meizu;
use BrowserDetector\Detector\Device\Mobile\Memup;
use BrowserDetector\Detector\Device\Mobile\Micromax;
use BrowserDetector\Detector\Device\Mobile\Mitashi;
use BrowserDetector\Detector\Device\Mobile\Miui;
use BrowserDetector\Detector\Device\Mobile\Mobistel;
use BrowserDetector\Detector\Device\Mobile\Modecom;
use BrowserDetector\Detector\Device\Mobile\Motorola;
use BrowserDetector\Detector\Device\Mobile\Msi;
use BrowserDetector\Detector\Device\Mobile\Mtc;
use BrowserDetector\Detector\Device\Mobile\Mway;
use BrowserDetector\Detector\Device\Mobile\Mytab;
use BrowserDetector\Detector\Device\Mobile\Nec;
use BrowserDetector\Detector\Device\Mobile\Neo;
use BrowserDetector\Detector\Device\Mobile\Neofonie;
use BrowserDetector\Detector\Device\Mobile\Nextbook;
use BrowserDetector\Detector\Device\Mobile\Nextway;
use BrowserDetector\Detector\Device\Mobile\Ngm;
use BrowserDetector\Detector\Device\Mobile\Nintendo;
use BrowserDetector\Detector\Device\Mobile\Nokia;
use BrowserDetector\Detector\Device\Mobile\Nomi;
use BrowserDetector\Detector\Device\Mobile\NttSystem;
use BrowserDetector\Detector\Device\Mobile\Nuqleo;
use BrowserDetector\Detector\Device\Mobile\Nvsbl;
use BrowserDetector\Detector\Device\Mobile\Odys;
use BrowserDetector\Detector\Device\Mobile\Onda;
use BrowserDetector\Detector\Device\Mobile\Oppo;
use BrowserDetector\Detector\Device\Mobile\Orange;
use BrowserDetector\Detector\Device\Mobile\Overmax;
use BrowserDetector\Detector\Device\Mobile\Oysters;
use BrowserDetector\Detector\Device\Mobile\Panasonic;
use BrowserDetector\Detector\Device\Mobile\Pandigital;
use BrowserDetector\Detector\Device\Mobile\Pantech;
use BrowserDetector\Detector\Device\Mobile\Pearl;
use BrowserDetector\Detector\Device\Mobile\Pegatron;
use BrowserDetector\Detector\Device\Mobile\Pentagram;
use BrowserDetector\Detector\Device\Mobile\Perfeo;
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
use BrowserDetector\Detector\Device\Mobile\Qumo;
use BrowserDetector\Detector\Device\Mobile\Reeder;
use BrowserDetector\Detector\Device\Mobile\Reellex;
use BrowserDetector\Detector\Device\Mobile\Ritmix;
use BrowserDetector\Detector\Device\Mobile\RoverPad;
use BrowserDetector\Detector\Device\Mobile\RugGear;
use BrowserDetector\Detector\Device\Mobile\Samsung;
use BrowserDetector\Detector\Device\Mobile\Sanyo;
use BrowserDetector\Detector\Device\Mobile\Senseit;
use BrowserDetector\Detector\Device\Mobile\Shaan;
use BrowserDetector\Detector\Device\Mobile\Sharp;
use BrowserDetector\Detector\Device\Mobile\Shiru;
use BrowserDetector\Detector\Device\Mobile\Siemens;
use BrowserDetector\Detector\Device\Mobile\SonyEricsson;
use BrowserDetector\Detector\Device\Mobile\Spice;
use BrowserDetector\Detector\Device\Mobile\Sprd;
use BrowserDetector\Detector\Device\Mobile\Sprint;
use BrowserDetector\Detector\Device\Mobile\Star;
use BrowserDetector\Detector\Device\Mobile\Starway;
use BrowserDetector\Detector\Device\Mobile\Stell;
use BrowserDetector\Detector\Device\Mobile\Sunstech;
use BrowserDetector\Detector\Device\Mobile\Supra;
use BrowserDetector\Detector\Device\Mobile\Sxz;
use BrowserDetector\Detector\Device\Mobile\Symphony;
use BrowserDetector\Detector\Device\Mobile\TbTouch;
use BrowserDetector\Detector\Device\Mobile\Technisat;
use BrowserDetector\Detector\Device\Mobile\Telsda;
use BrowserDetector\Detector\Device\Mobile\Tesla;
use BrowserDetector\Detector\Device\Mobile\Texet;
use BrowserDetector\Detector\Device\Mobile\Thl;
use BrowserDetector\Detector\Device\Mobile\Tmobile;
use BrowserDetector\Detector\Device\Mobile\Tolino;
use BrowserDetector\Detector\Device\Mobile\Toshiba;
use BrowserDetector\Detector\Device\Mobile\TrekStor;
use BrowserDetector\Detector\Device\Mobile\TriQ;
use BrowserDetector\Detector\Device\Mobile\Triray;
use BrowserDetector\Detector\Device\Mobile\TurboPad;
use BrowserDetector\Detector\Device\Mobile\Twinovo;
use BrowserDetector\Detector\Device\Mobile\Twz;
use BrowserDetector\Detector\Device\Mobile\Ultrafone;
use BrowserDetector\Detector\Device\Mobile\Umi;
use BrowserDetector\Detector\Device\Mobile\United;
use BrowserDetector\Detector\Device\Mobile\UtStarcom;
use BrowserDetector\Detector\Device\Mobile\VastKing;
use BrowserDetector\Detector\Device\Mobile\Verico;
use BrowserDetector\Detector\Device\Mobile\Vertex;
use BrowserDetector\Detector\Device\Mobile\Videocon;
use BrowserDetector\Detector\Device\Mobile\ViewSonic;
use BrowserDetector\Detector\Device\Mobile\Vivo;
use BrowserDetector\Detector\Device\Mobile\Wexler;
use BrowserDetector\Detector\Device\Mobile\Wiko;
use BrowserDetector\Detector\Device\Mobile\Wolgang;
use BrowserDetector\Detector\Device\Mobile\Woo;
use BrowserDetector\Detector\Device\Mobile\Wopad;
use BrowserDetector\Detector\Device\Mobile\Xiaomi;
use BrowserDetector\Detector\Device\Mobile\Xolo;
use BrowserDetector\Detector\Device\Mobile\Xoro;
use BrowserDetector\Detector\Device\Mobile\Yarvik;
use BrowserDetector\Detector\Device\Mobile\Yota;
use BrowserDetector\Detector\Device\Mobile\Yuanda;
use BrowserDetector\Detector\Device\Mobile\Yuandao;
use BrowserDetector\Detector\Device\Mobile\Yusu;
use BrowserDetector\Detector\Device\Mobile\Zeki;
use BrowserDetector\Detector\Device\Mobile\Zenithink;
use BrowserDetector\Detector\Device\Mobile\Zopo;
use BrowserDetector\Detector\Device\Mobile\Zte;
use BrowserDetector\Detector\Factory\FactoryInterface;
use BrowserDetector\Matcher\Device\DeviceHasChildrenInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2015 Thomas Mueller
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
        if (preg_match('/(HiPhone|V919)/i', $useragent)) {
            $device = new HiPhone($useragent, []);
        } elseif (preg_match('/(Technisat|TechniPad)/', $useragent)) {
            $device = new Technisat($useragent, []);
        } elseif (preg_match('/nokia/i', $useragent)) {
            $device = new Nokia($useragent, []);
        } elseif (preg_match('/(ipad|iphone|ipod|like mac os x)/i', $useragent)
            && !preg_match('/windows phone/i', $useragent)
            && !preg_match('/ adr /i', $useragent)
        ) {
            $device = new Apple($useragent, []);
        } elseif (preg_match('/samsung/i', $useragent)) {
            $device = new Samsung($useragent, []);
        } elseif (preg_match('/asus/i', $useragent)) {
            $device = new Asus($useragent, []);
        } elseif (preg_match('/MT\-GT\-A9500/i', $useragent)) {
            $device = new Htm($useragent, []);
        } elseif (preg_match('/GT\-A7100/i', $useragent)) {
            $device = new Sprd($useragent, []);
        } elseif (preg_match('/(Feiteng|GT\-H)/i', $useragent)) {
            $device = new Feiteng($useragent, []);
        } elseif (preg_match('/(cube|U30GT|U51GT|U55GT)/i', $useragent)) {
            $device = new Cube($useragent, []);
        } elseif (preg_match('/GT\-9000/i', $useragent)) {
            $device = new Star($useragent, []);
        } elseif (preg_match('/(gt|sam|sc|sch|sec|sgh|shv|shw|sm|sph|continuum)\-/i', $useragent)) {
            $device = new Samsung($useragent, []);
        } elseif (preg_match('/(HDC|Galaxy S3 EX)/i', $useragent)) {
            $device = new Hdc($useragent, []);
        } elseif (preg_match('/nexus (4|5)/i', $useragent)) {
            $device = new Lg($useragent, []);
        } elseif (preg_match('/nexus 7/i', $useragent)) {
            $device = new Asus($useragent, []);
        } elseif (preg_match('/nexus 6/i', $useragent)) {
            $device = new Motorola($useragent, []);
        } elseif (preg_match('/nexus one/i', $useragent)) {
            $device = new Htc($useragent, []);
        } elseif (preg_match('/(galaxy|nexus|i7110|i9100|i9300|yp\-g|blaze)/i', $useragent)) {
            $device = new Samsung($useragent, []);
        } elseif (preg_match('/sony/i', $useragent)) {
            $device = new SonyEricsson($useragent, []);
        } elseif (preg_match('/twinovo/i', $useragent)) {
            $device = new Twinovo($useragent, []);
        } elseif (preg_match('/LG/', $useragent)) {
            $device = new Lg($useragent, []);
        } elseif (preg_match('/htc/i', $useragent) && !preg_match('/WOHTC/', $useragent)) {
            $device = new Htc($useragent, []);
        } elseif (preg_match('/(SmartTab7|Smart 4G)/', $useragent)) {
            $device = new Zte($useragent, []);
        } elseif (preg_match('/(lenovo|ideatab|ideapad|smarttab)/i', $useragent)) {
            $device = new Lenovo($useragent, []);
        } elseif (preg_match('/(acer|iconia|liquid)/i', $useragent)) {
            $device = new Acer($useragent, []);
        } elseif (preg_match('/PLAYSTATION/i', $useragent)) {
            $device = new SonyEricsson($useragent, []);
        } elseif (preg_match('/(amazon|kindle|silk|KFTT|KFOT|KFJWI|KFSOWI|KFTHWI|SD4930UR)/i', $useragent)) {
            $device = new Amazon($useragent, []);
        } elseif (preg_match('/amoi/i', $useragent)) {
            $device = new Amoi($useragent, []);
        } elseif (preg_match('/(Blaupunkt|Endeavour)/i', $useragent)) {
            $device = new Blaupunkt($useragent, []);
        } elseif (preg_match('/ONDA/', $useragent)) {
            $device = new Onda($useragent, []);
        } elseif (preg_match('/archos/i', $useragent)) {
            $device = new Archos($useragent, []);
        } elseif (preg_match('/IRULU/', $useragent)) {
            $device = new Irulu($useragent, []);
        } elseif (preg_match('/Symphony/', $useragent)) {
            $device = new Symphony($useragent, []);
        } elseif (preg_match('/arnova/i', $useragent)) {
            $device = new Arnova($useragent, []);
        } elseif (preg_match('/ bn /i', $useragent)) {
            $device = new BarnesNoble($useragent, []);
        } elseif (preg_match('/beidou/i', $useragent)) {
            $device = new Beidou($useragent, []);
        } elseif (preg_match('/(BlackBerry|PlayBook|RIM Tablet|BB10)/i', $useragent)) {
            $device = new BlackBerry($useragent, []);
        } elseif (preg_match('/caterpillar/i', $useragent)) {
            $device = new Caterpillar($useragent, []);
        } elseif (preg_match('/B15/', $useragent)) {
            $device = new Caterpillar($useragent, []);
        } elseif (preg_match('/(CatNova|Cat StarGate|Cat Tablet)/i', $useragent)) {
            $device = new CatSound($useragent, []);
        } elseif (preg_match('/(Coby|NBPC724|MID\d{4})/i', $useragent)) {
            $device = new Coby($useragent, []);
        } elseif (preg_match('/(Comag|WTDR1018)/i', $useragent)) {
            $device = new Comag($useragent, []);
        } elseif (preg_match('/coolpad/i', $useragent)) {
            $device = new Coolpad($useragent, []);
        } elseif (preg_match('/cosmote/i', $useragent)) {
            $device = new Cosmote($useragent, []);
        } elseif (preg_match('/(Creative|ZiiLABS)/i', $useragent)) {
            $device = new Creative($useragent, []);
        } elseif (preg_match('/cubot/i', $useragent)) {
            $device = new Cubot($useragent, []);
        } elseif (preg_match('/dell/i', $useragent)) {
            $device = new Dell($useragent, []);
        } elseif (preg_match('/(Denver|TAD\-)/i', $useragent)) {
            $device = new Denver($useragent, []);
        } elseif (preg_match('/(nec|n905i)/i', $useragent) && !preg_match('/fennec/i', $useragent)) {
            $device = new Nec($useragent, []);
        } elseif (preg_match('/(DoCoMo|P900i)/i', $useragent)) {
            $device = new DoCoMo($useragent, []);
        } elseif (preg_match('/(Easypix|EasyPad|Junior 4\.0)/i', $useragent)) {
            $device = new Easypix($useragent, []);
        } elseif (preg_match('/(Efox|SMART\-E5)/', $useragent)) {
            $device = new Efox($useragent, []);
        } elseif (preg_match('/1 \& 1/i', $useragent)) {
            $device = new EinsUndEins($useragent, []);
        } elseif (preg_match('/p7901a/i', $useragent)) {
            $device = new Epad($useragent, []);
        } elseif (preg_match('/FaktorZwei/i', $useragent)) {
            $device = new FaktorZwei($useragent, []);
        } elseif (preg_match('/Flytouch/i', $useragent)) {
            $device = new Flytouch($useragent, []);
        } elseif (preg_match('/(Fujitsu|M532)/i', $useragent)) {
            $device = new Fujitsu($useragent, []);
        } elseif (preg_match('/SN10T1/i', $useragent)) {
            $device = new Hannspree($useragent, []);
        } elseif (preg_match('/DA241HL/', $useragent)) {
            $device = new Acer($useragent, []);
        } elseif (preg_match('/(Honlin|PC1088|HL)/', $useragent)) {
            $device = new Honlin($useragent, []);
        } elseif (preg_match('/Huawei/i', $useragent)) {
            $device = new Huawei($useragent, []);
        } elseif (preg_match('/micromax/i', $useragent)) {
            $device = new Micromax($useragent, []);
        } elseif (preg_match('/triray/i', $useragent)) {
            $device = new Triray($useragent, []);
        } elseif (preg_match('/SXZ/', $useragent)) {
            $device = new Sxz($useragent, []);
        } elseif (preg_match('/explay/i', $useragent)) {
            $device = new Explay($useragent, []);
        } elseif (preg_match('/pmedia/i', $useragent)) {
            $device = new Pmedia($useragent, []);
        } elseif (preg_match('/impression/i', $useragent)) {
            $device = new Impression($useragent, []);
        } elseif (preg_match('/kingzone/i', $useragent)) {
            $device = new Kingzone($useragent, []);
        } elseif (preg_match('/gzone/i', $useragent)) {
            $device = new Gzone($useragent, []);
        } elseif (preg_match('/reellex/i', $useragent)) {
            $device = new Reellex($useragent, []);
        } elseif (preg_match('/spice/i', $useragent)) {
            $device = new Spice($useragent, []);
        } elseif (preg_match('/turbopad/i', $useragent)) {
            $device = new TurboPad($useragent, []);
        } elseif (preg_match('/haier/i', $useragent)) {
            $device = new Haier($useragent, []);
        } elseif (preg_match('/sunstech/i', $useragent)) {
            $device = new Sunstech($useragent, []);
        } elseif (preg_match('/AOC/', $useragent)) {
            $device = new Aoc($useragent, []);
        } elseif (preg_match('/hummer/i', $useragent)) {
            $device = new Hummer($useragent, []);
        } elseif (preg_match('/oysters/i', $useragent)) {
            $device = new Oysters($useragent, []);
        } elseif (preg_match('/vertex/i', $useragent)) {
            $device = new Vertex($useragent, []);
        } elseif (preg_match('/pantech/i', $useragent)) {
            $device = new Pantech($useragent, []);
        } elseif (preg_match('/gfive/i', $useragent)) {
            $device = new Gfive($useragent, []);
        } elseif (preg_match('/(HP|P160U|TouchPad|Pixi|palm|Blazer|cm_tenderloin)/i', $useragent)) {
            $device = new Hp($useragent, []);
        } elseif (preg_match('/iconbit/i', $useragent)) {
            $device = new IconBit($useragent, []);
        } elseif (preg_match('/(INM803HC|INM8002KP)/', $useragent)) {
            $device = new Intenso($useragent, []);
        } elseif (preg_match('/ionik/i', $useragent)) {
            $device = new Ionik($useragent, []);
        } elseif (preg_match('/JAY\-tech/i', $useragent)) {
            $device = new Jaytech($useragent, []);
        } elseif (preg_match('/(jolla|sailfish)/i', $useragent)) {
            $device = new Jolla($useragent, []);
        } elseif (preg_match('/KAZAM/i', $useragent)) {
            $device = new Kazam($useragent, []);
        } elseif (preg_match('/KDDI/i', $useragent)) {
            $device = new Kddi($useragent, []);
        } elseif (preg_match('/Kobo Touch/i', $useragent)) {
            $device = new Kobo($useragent, []);
        } elseif (preg_match('/Lenco/i', $useragent)) {
            $device = new Lenco($useragent, []);
        } elseif (preg_match('/LePan/i', $useragent)) {
            $device = new LePan($useragent, []);
        } elseif (preg_match('/(LogicPD|Zoom2|NookColor)/', $useragent)) {
            $device = new Logikpd($useragent, []);
        } elseif (preg_match('/(medion|lifetab)/i', $useragent)) {
            $device = new Medion($useragent, []);
        } elseif (preg_match('/meizu/i', $useragent)) {
            $device = new Meizu($useragent, []);
        } elseif (preg_match('/allwinner/i', $useragent)) {
            $device = new AllWinner($useragent, []);
        } elseif (preg_match('/accent/i', $useragent)) {
            $device = new Accent($useragent, []);
        } elseif (preg_match('/yota/i', $useragent)) {
            $device = new Yota($useragent, []);
        } elseif (preg_match('/ainol/i', $useragent)) {
            $device = new Ainol($useragent, []);
        } elseif (preg_match('/supra/i', $useragent)) {
            $device = new Supra($useragent, []);
        } elseif (preg_match('/nextway/i', $useragent)) {
            $device = new Nextway($useragent, []);
        } elseif (preg_match('/amlogic/i', $useragent)) {
            $device = new Amlogic($useragent, []);
        } elseif (preg_match('/adspec/i', $useragent)) {
            $device = new Adspec($useragent, []);
        } elseif (preg_match('/m\-way/i', $useragent)) {
            $device = new Mway($useragent, []);
        } elseif (preg_match('/memup/i', $useragent)) {
            $device = new Memup($useragent, []);
        } elseif (preg_match('/miui/i', $useragent)
            && !preg_match('/miuibrowser/i', $useragent)
            && !preg_match('/build\/miui/i', $useragent)
        ) {
            $device = new Miui($useragent, []);
        } elseif (preg_match('/cynus/i', $useragent)) {
            $device = new Mobistel($useragent, []);
        } elseif (preg_match('/motorola/i', $useragent)) {
            $device = new Motorola($useragent, []);
        } elseif (preg_match('/WeTab/', $useragent)) {
            $device = new Neofonie($useragent, []);
        } elseif (preg_match('/Nextbook/', $useragent)) {
            $device = new Nextbook($useragent, []);
        } elseif (preg_match('/Nintendo/', $useragent)) {
            $device = new Nintendo($useragent, []);
        } elseif (preg_match('/Nvsbl/', $useragent)) {
            $device = new Nvsbl($useragent, []);
        } elseif (preg_match('/odys/i', $useragent)) {
            $device = new Odys($useragent, []);
        } elseif (preg_match('/oppo/i', $useragent)) {
            $device = new Oppo($useragent, []);
        } elseif (preg_match('/Panasonic/', $useragent)) {
            $device = new Panasonic($useragent, []);
        } elseif (preg_match('/pandigital/i', $useragent)) {
            $device = new Pandigital($useragent, []);
        } elseif (preg_match('/Phicomm/', $useragent)) {
            $device = new Phicomm($useragent, []);
        } elseif (preg_match('/pipo/i', $useragent)) {
            $device = new Pipo($useragent, []);
        } elseif (preg_match('/pomp/i', $useragent)) {
            $device = new Pomp($useragent, []);
        } elseif (preg_match('/Prestigio/', $useragent)) {
            $device = new Prestigio($useragent, []);
        } elseif (preg_match('/QMobile/', $useragent)) {
            $device = new Qmobile($useragent, []);
        } elseif (preg_match('/keener/i', $useragent)) {
            $device = new Keener($useragent, []);
        } elseif (preg_match('/Sanyo/', $useragent)) {
            $device = new Sanyo($useragent, []);
        } elseif (preg_match('/SHARP/', $useragent)) {
            $device = new Sharp($useragent, []);
        } elseif (preg_match('/Siemens/', $useragent)) {
            $device = new Siemens($useragent, []);
        } elseif (preg_match('/Sprint/', $useragent)) {
            $device = new Sprint($useragent, []);
        } elseif (preg_match('/Star/', $useragent) && !preg_match('/Aqua\_Star/', $useragent)) {
            $device = new Star($useragent, []);
        } elseif (preg_match('/texet/i', $useragent)) {
            $device = new Texet($useragent, []);
        } elseif (preg_match('/condor/i', $useragent)) {
            $device = new Condor($useragent, []);
        } elseif (preg_match('/s\-tell/i', $useragent)) {
            $device = new Stell($useragent, []);
        } elseif (preg_match('/verico/i', $useragent)) {
            $device = new Verico($useragent, []);
        } elseif (preg_match('/guggear/i', $useragent)) {
            $device = new RugGear($useragent, []);
        } elseif (preg_match('/telsda/i', $useragent)) {
            $device = new Telsda($useragent, []);
        } elseif (preg_match('/mitashi/i', $useragent)) {
            $device = new Mitashi($useragent, []);
        } elseif (preg_match('/bliss/i', $useragent)) {
            $device = new Bliss($useragent, []);
        } elseif (preg_match('/lexand/i', $useragent)) {
            $device = new Lexand($useragent, []);
        } elseif (preg_match('/alcatel/i', $useragent)) {
            $device = new Alcatel($useragent, []);
        } elseif (preg_match('/thl/i', $useragent) && !preg_match('/LIAuthLibrary/', $useragent)) {
            $device = new Thl($useragent, []);
        } elseif (preg_match('/T\-Mobile/', $useragent)) {
            $device = new Tmobile($useragent, []);
        } elseif (preg_match('/tolino/i', $useragent)) {
            $device = new Tolino($useragent, []);
        } elseif (preg_match('/Toshiba/i', $useragent)) {
            $device = new Toshiba($useragent, []);
        } elseif (preg_match('/TrekStor/', $useragent)) {
            $device = new TrekStor($useragent, []);
        } elseif (preg_match('/3Q/', $useragent)) {
            $device = new TriQ($useragent, []);
        } elseif (preg_match('/(ViewSonic|ViewPad)/', $useragent)) {
            $device = new ViewSonic($useragent, []);
        } elseif (preg_match('/Wiko/', $useragent)) {
            $device = new Wiko($useragent, []);
        } elseif (preg_match('/vivo/', $useragent)) {
            $device = new Vivo($useragent, []);
        } elseif (preg_match('/xiaomi/i', $useragent)) {
            $device = new Xiaomi($useragent, []);
        } elseif (preg_match('/haipai/i', $useragent)) {
            $device = new Haipai($useragent, []);
        } elseif (preg_match('/megafon/i', $useragent)) {
            $device = new MegaFon($useragent, []);
        } elseif (preg_match('/UMI/', $useragent)) {
            $device = new Umi($useragent, []);
        } elseif (preg_match('/MI \d/', $useragent)) {
            $device = new Xiaomi($useragent, []);
        } elseif (preg_match('/HM( |\_)(NOTE|1SC|1SW)/', $useragent)) {
            $device = new Xiaomi($useragent, []);
        } elseif (preg_match('/yuandao/i', $useragent)) {
            $device = new Yuandao($useragent, []);
        } elseif (preg_match('/yuanda/i', $useragent)) {
            $device = new Yuanda($useragent, []);
        } elseif (preg_match('/Yusu/', $useragent)) {
            $device = new Yusu($useragent, []);
        } elseif (preg_match('/Zenithink/i', $useragent)) {
            $device = new Zenithink($useragent, []);
        } elseif (preg_match('/zte/i', $useragent)) {
            $device = new Zte($useragent, []);
        } elseif (preg_match('/Fly/', $useragent) && !preg_match('/FlyFlow/', $useragent)) {
            $device = new Fly($useragent, []);
        } elseif (preg_match('/PocketBook/', $useragent)) {
            $device = new PocketBook($useragent, []);
        } elseif (preg_match('/Geniatech/', $useragent)) {
            $device = new Geniatech($useragent, []);
        } elseif (preg_match('/Yarvik/', $useragent)) {
            $device = new Yarvik($useragent, []);
        } elseif (preg_match('/GOCLEVER/', $useragent)) {
            $device = new GoClever($useragent, []);
        } elseif (preg_match('/senseit/i', $useragent)) {
            $device = new Senseit($useragent, []);
        } elseif (preg_match('/twz/i', $useragent)) {
            $device = new Twz($useragent, []);
        } elseif (preg_match('/irbis/i', $useragent)) {
            $device = new Irbis($useragent, []);
        } elseif (preg_match('/i\-mobile/i', $useragent)) {
            $device = new Imobile($useragent, []);
        } elseif (preg_match('/NGM/', $useragent)) {
            $device = new Ngm($useragent, []);
        } elseif (preg_match('/dino/i', $useragent)) {
            $device = new Dino($useragent, []);
        } elseif (preg_match('/(shaan|iball)/i', $useragent)) {
            $device = new Shaan($useragent, []);
        } elseif (preg_match('/bmobile/i', $useragent) && !preg_match('/icabmobile/i', $useragent)) {
            $device = new Bmobile($useragent, []);
        } elseif (preg_match('/modecom/i', $useragent)) {
            $device = new Modecom($useragent, []);
        } elseif (preg_match('/overmax/i', $useragent)) {
            $device = new Overmax($useragent, []);
        } elseif (preg_match('/kiano/i', $useragent)) {
            $device = new Kiano($useragent, []);
        } elseif (preg_match('/manta/i', $useragent)) {
            $device = new Manta($useragent, []);
        } elseif (preg_match('/philips/i', $useragent)) {
            $device = new Philips($useragent, []);
        } elseif (preg_match('/shiru/i', $useragent)) {
            $device = new Shiru($useragent, []);
        } elseif (preg_match('/TB Touch/i', $useragent)) {
            $device = new TbTouch($useragent, []);
        } elseif (preg_match('/NTT/', $useragent)) {
            $device = new NttSystem($useragent, []);
        } elseif (preg_match('/pentagram/i', $useragent)) {
            $device = new Pentagram($useragent, []);
        } elseif (preg_match('/zeki/i', $useragent)) {
            $device = new Zeki($useragent, []);
        } elseif (preg_match('/DFunc/', $useragent)) {
            $device = new Dfunc($useragent, []);
        } elseif (preg_match('/Digma/', $useragent)) {
            $device = new Digma($useragent, []);
        } elseif (preg_match('/axgio/i', $useragent)) {
            $device = new Axgio($useragent, []);
        } elseif (preg_match('/roverpad/i', $useragent)) {
            $device = new RoverPad($useragent, []);
        } elseif (preg_match('/zopo/i', $useragent)) {
            $device = new Zopo($useragent, []);
        } elseif (preg_match('/ultrafone/', $useragent)) {
            $device = new Ultrafone($useragent, []);
        } elseif (preg_match('/malata/i', $useragent)) {
            $device = new Malata($useragent, []);
        } elseif (preg_match('/starway/i', $useragent)) {
            $device = new Starway($useragent, []);
        } elseif (preg_match('/pegatron/i', $useragent)) {
            $device = new Pegatron($useragent, []);
        } elseif (preg_match('/logicom/i', $useragent)) {
            $device = new Logicom($useragent, []);
        } elseif (preg_match('/gigabyte/i', $useragent)) {
            $device = new Gigabyte($useragent, []);
        } elseif (preg_match('/qumo/i', $useragent)) {
            $device = new Qumo($useragent, []);
        } elseif (preg_match('/perfeo/i', $useragent)) {
            $device = new Perfeo($useragent, []);
        } elseif (preg_match('/ MT791 /i', $useragent)) {
            $device = new KeenHigh($useragent, []);
        } elseif (preg_match('/(g100w|stream\-s110)/i', $useragent)) {
            $device = new Acer($useragent, []);
        } elseif (preg_match('/ (a1|a3|b1)\-/i', $useragent)) {
            $device = new Acer($useragent, []);
        } elseif (preg_match('/wildfire/i', $useragent)) {
            $device = new Htc($useragent, []);
        } elseif (preg_match('/a101it/i', $useragent)) {
            $device = new Archos($useragent, []);
        } elseif (preg_match('/(sprd|SPHS|B51\+)/i', $useragent)) {
            $device = new Sprd($useragent, []);
        } elseif (preg_match('/TAB A742/', $useragent)) {
            $device = new Wexler($useragent, []);
        } elseif (preg_match('/ a\d{3} /i', $useragent) && preg_match('/android 3\.2/i', $useragent)) {
            $device = new Micromax($useragent, []);
        } elseif (preg_match('/ (a|e|v|z|s)\d{3} /i', $useragent)) {
            $device = new Acer($useragent, []);
        } elseif (preg_match('/AT\-AS40SE/', $useragent)) {
            $device = new Wolgang($useragent, []);
        } elseif (preg_match('/(United|MT6515M)/', $useragent)) {
            $device = new United($useragent, []);
        } elseif (preg_match('/(utstarcom|GTX75)/i', $useragent)) {
            $device = new UtStarcom($useragent, []);
        } elseif (preg_match('/(Fairphone|FP1)/i', $useragent)) {
            $device = new Fairphone($useragent, []);
        } elseif (preg_match('/(Videocon|A15)/', $useragent)) {
            $device = new Videocon($useragent, []);
        } elseif (preg_match('/intex/i', $useragent)) {
            $device = new Intex($useragent, []);
        } elseif (preg_match('/mastone/i', $useragent)) {
            $device = new Mastone($useragent, []);
        } elseif (preg_match('/BLU/', $useragent)) {
            $device = new Blu($useragent, []);
        } elseif (preg_match('/Nuqleo/', $useragent)) {
            $device = new Nuqleo($useragent, []);
        } elseif (preg_match('/ritmix/i', $useragent)) {
            $device = new Ritmix($useragent, []);
        } elseif (preg_match('/wexler/i', $useragent)) {
            $device = new Wexler($useragent, []);
        } elseif (preg_match('/exeq/i', $useragent)) {
            $device = new Exeq($useragent, []);
        } elseif (preg_match('/ergo/i', $useragent)) {
            $device = new Ergo($useragent, []);
        } elseif (preg_match('/pulid/i', $useragent)) {
            $device = new Pulid($useragent, []);
        } elseif (preg_match('/dns/i', $useragent)) {
            $device = new Dns($useragent, []);
        } elseif (preg_match('/dexp/i', $useragent)) {
            $device = new Dexp($useragent, []);
        } elseif (preg_match('/keneksi/i', $useragent)) {
            $device = new Keneksi($useragent, []);
        } elseif (preg_match('/gionee/i', $useragent)) {
            $device = new Gionee($useragent, []);
        } elseif (preg_match('/highscreen/i', $useragent)) {
            $device = new Highscreen($useragent, []);
        } elseif (preg_match('/reeder/i', $useragent)) {
            $device = new Reeder($useragent, []);
        } elseif (preg_match('/nomi/i', $useragent)) {
            $device = new Nomi($useragent, []);
        } elseif (preg_match('/globex/i', $useragent)) {
            $device = new Globex($useragent, []);
        } elseif (preg_match('/AIS/', $useragent)) {
            $device = new Ais($useragent, []);
        } elseif (preg_match('/CIOtCUD/i', $useragent)) {
            $device = new Ciotcud($useragent, []);
        } elseif (preg_match('/iNew/', $useragent)) {
            $device = new Inew($useragent, []);
        } elseif (preg_match('/Intego/', $useragent)) {
            $device = new Intego($useragent, []);
        } elseif (preg_match('/MTC/', $useragent)) {
            $device = new Mtc($useragent, []);
        } elseif (preg_match('/DARKMOON/', $useragent)) {
            $device = new Wiko($useragent, []);
        } elseif (preg_match('/ARK/', $useragent)) {
            $device = new Ark($useragent, []);
        } elseif (preg_match('/Magic/', $useragent)) {
            $device = new Magic($useragent, []);
        } elseif (preg_match('/BQS/', $useragent)) {
            $device = new Bq($useragent, []);
        } elseif (preg_match('/BQ \d{4}/', $useragent)) {
            $device = new Bq($useragent, []);
        } elseif (preg_match('/bq Aquaris 5 HD/', $useragent)) {
            $device = new Bq($useragent, []);
        } elseif (preg_match('/msi/i', $useragent) && !preg_match('/msie/i', $useragent)) {
            $device = new Msi($useragent, []);
        } elseif (preg_match('/Orange/', $useragent)) {
            $device = new Orange($useragent, []);
        } elseif (preg_match('/vastking/i', $useragent)) {
            $device = new VastKing($useragent, []);
        } elseif (preg_match('/wopad/i', $useragent)) {
            $device = new Wopad($useragent, []);
        } elseif (preg_match('/anka/i', $useragent)) {
            $device = new Anka($useragent, []);
        } elseif (preg_match('/myTAB/', $useragent)) {
            $device = new Mytab($useragent, []);
        } elseif (preg_match('/(LOOX|UNO\_X10|Xelio 7|NEO\_QUAD10|IEOS\_QUAD|Sky Plus)/i', $useragent)) {
            $device = new Odys($useragent, []);
        } elseif (preg_match('/iPh\d\,\d/', $useragent)) {
            $device = new Apple($useragent, []);
        } elseif (preg_match('/Puffin\/[\d\.]+IT/', $useragent)) {
            $device = new Apple\Ipad($useragent, []);
        } elseif (preg_match('/Puffin\/[\d\.]+IP/', $useragent)) {
            $device = new Apple\Iphone($useragent, []);
        } elseif (preg_match('/dataaccessd/', $useragent)) {
            $device = new Apple($useragent, []);
        } elseif (preg_match('/Pre/', $useragent) && !preg_match('/Presto/', $useragent)) {
            $device = new Hp($useragent, []);
        } elseif (preg_match('/(Z221|V788D|KIS PLUS|NX402|NX501|N918St|Beeline Pro|ATLAS_W)/', $useragent)) {
            $device = new Zte($useragent, []);
        } elseif (preg_match('/ME\d{3}[A-Z]/', $useragent)) {
            $device = new Asus($useragent, []);
        } elseif (preg_match('/(PadFone|Transformer)/', $useragent)) {
            $device = new Asus($useragent, []);
        } elseif (preg_match('/K0(0|1)[0-9a-zA-Z]/', $useragent)) {
            $device = new Asus($useragent, []);
        } elseif (preg_match('/QtCarBrowser/', $useragent)) {
            $device = new Tesla($useragent, []);
        } elseif (preg_match('/MOT/', $useragent)) {
            $device = new Motorola($useragent, []);
        } elseif (preg_match('/MB\d{3}/', $useragent)) {
            $device = new Motorola($useragent, []);
        } elseif (preg_match('/smart tab/i', $useragent)) {
            $device = new Lenovo($useragent, []);
        } elseif (preg_match('/one (s|x)/i', $useragent) && !preg_match('/vodafone smart/i', $useragent)) {
            $device = new Htc($useragent, []);
        } elseif (preg_match('/Tablet\-PC\-4/', $useragent)) {
            $device = new CatSound($useragent, []);
        } elseif (preg_match('/TBD\d{4}/', $useragent)) {
            $device = new Zeki($useragent, []);
        } elseif (preg_match('/TBD(B|C)\d{3,4}/', $useragent)) {
            $device = new Zeki($useragent, []);
        } elseif (preg_match('/AC0732C/', $useragent)) {
            $device = new TriQ($useragent, []);
        } elseif (preg_match('/ImPAD6213M_v2/', $useragent)) {
            $device = new Impression($useragent, []);
        } elseif (preg_match('/(A10100|C07000)/', $useragent)) {
            $device = new Nomi($useragent, []);
        } elseif (preg_match('/(C|D)\d{4}/', $useragent)) {
            $device = new SonyEricsson($useragent, []);
        } elseif (preg_match('/SGP\d{3}/', $useragent)) {
            $device = new SonyEricsson($useragent, []);
        } elseif (preg_match('/sgpt\d{2}/i', $useragent)) {
            $device = new SonyEricsson($useragent, []);
        } elseif (preg_match('/xperia/i', $useragent)) {
            $device = new SonyEricsson($useragent, []);
        } elseif (preg_match('/VS\d{3}/', $useragent)) {
            $device = new Lg($useragent, []);
        } elseif (preg_match('/(SurfTab|VT10416|breeze 10\.1 quad)/', $useragent)) {
            $device = new TrekStor($useragent, []);
        } elseif (preg_match('/AT\d{2,3}/', $useragent)) {
            $device = new Toshiba($useragent, []);
        } elseif (preg_match('/(PAP|PMP|PMT)/', $useragent)) {
            $device = new Prestigio($useragent, []);
        } elseif (preg_match('/(APA9292KT|PJ83100|831C|Evo 3D GSM|Eris 2\.1)/', $useragent)) {
            $device = new Htc($useragent, []);
        } elseif (preg_match('/adr\d{4}/i', $useragent)) {
            $device = new Htc($useragent, []);
        } elseif (preg_match('/Aqua\_Star/', $useragent)) {
            $device = new Intex($useragent, []);
        } elseif (preg_match('/NEXT/', $useragent)) {
            $device = new Nextbook($useragent, []);
        } elseif (preg_match('/XT\d{3,4}/', $useragent)) {
            $device = new Motorola($useragent, []);
        } elseif (preg_match('/( droid)/i', $useragent)) {
            $device = new Motorola($useragent, []);
        } elseif (preg_match('/MT6572\_TD/', $useragent)) {
            $device = new Cubot($useragent, []);
        } elseif (preg_match('/(S|L|W|M)T\d{2}/', $useragent)) {
            $device = new SonyEricsson($useragent, []);
        } elseif (preg_match('/SK\d{2}/', $useragent)) {
            $device = new SonyEricsson($useragent, []);
        } elseif (preg_match('/(SO-03E|SO-02D)/', $useragent)) {
            $device = new SonyEricsson($useragent, []);
        } elseif (preg_match('/VIVO/', $useragent)) {
            $device = new Blu($useragent, []);
        } elseif (preg_match('/NOOK/', $useragent)) {
            $device = new BarnesNoble($useragent, []);
        } elseif (preg_match('/Zaffire/', $useragent)) {
            $device = new Nuqleo($useragent, []);
        } elseif (preg_match('/BNRV\d{3}/', $useragent)) {
            $device = new BarnesNoble($useragent, []);
        } elseif (preg_match('/IQ\d{3,4}/', $useragent)) {
            $device = new Fly($useragent, []);
        } elseif (preg_match('/Phoenix 2/', $useragent)) {
            $device = new Fly($useragent, []);
        } elseif (preg_match('/TAB10\-400/', $useragent)) {
            $device = new Yarvik($useragent, []);
        } elseif (preg_match('/TQ\d{3}/', $useragent)) {
            $device = new GoClever($useragent, []);
        } elseif (preg_match('/RMD\-\d{3,4}/', $useragent)) {
            $device = new Ritmix($useragent, []);
        } elseif (preg_match('/(TERRA_101|ORION7o)/', $useragent)) {
            $device = new GoClever($useragent, []);
        } elseif (preg_match('/AX\d{3}/', $useragent)) {
            $device = new Bmobile($useragent, []);
        } elseif (preg_match('/FreeTAB \d{4}/', $useragent)) {
            $device = new Modecom($useragent, []);
        } elseif (preg_match('/Venue/', $useragent)) {
            $device = new Dell($useragent, []);
        } elseif (preg_match('/FunTab/', $useragent)) {
            $device = new Orange($useragent, []);
        } elseif (preg_match('/(OV\-|Solution 7III)/', $useragent)) {
            $device = new Overmax($useragent, []);
        } elseif (preg_match('/Zanetti/', $useragent)) {
            $device = new Kiano($useragent, []);
        } elseif (preg_match('/MID\d{3}/', $useragent)) {
            $device = new Manta($useragent, []);
        } elseif (preg_match('/FWS610_EU/', $useragent)) {
            $device = new Phicomm($useragent, []);
        } elseif (preg_match('/FX2/', $useragent)) {
            $device = new FaktorZwei($useragent, []);
        } elseif (preg_match('/AN\d{1,2}/', $useragent)) {
            $device = new Arnova($useragent, []);
        } elseif (preg_match('/(Touchlet|X7G)/', $useragent)) {
            $device = new Pearl($useragent, []);
        } elseif (preg_match('/POV/', $useragent)) {
            $device = new PointOfView($useragent, []);
        } elseif (preg_match('/PI\d{4}/', $useragent)) {
            $device = new Philips($useragent, []);
        } elseif (preg_match('/SM \- /', $useragent)) {
            $device = new Samsung($useragent, []);
        } elseif (preg_match('/(SH05C|304SH|SH\-01F)/', $useragent)) {
            $device = new Sharp($useragent, []);
        } elseif (preg_match('/SAMURAI10/', $useragent)) {
            $device = new Shiru($useragent, []);
        } elseif (preg_match('/Ignis 8/', $useragent)) {
            $device = new TbTouch($useragent, []);
        } elseif (preg_match('/A5000/', $useragent)) {
            $device = new SonyEricsson($useragent, []);
        } elseif (preg_match('/FUNC/', $useragent)) {
            $device = new Dfunc($useragent, []);
        } elseif (preg_match('/iD(j|n|s|x)D\d/', $useragent)) {
            $device = new Digma($useragent, []);
        } elseif (preg_match('/K910L/', $useragent)) {
            $device = new Lenovo($useragent, []);
        } elseif (preg_match('/TAB7iD/', $useragent)) {
            $device = new Wexler($useragent, []);
        } elseif (preg_match('/ZP\d{3}/', $useragent)) {
            $device = new Zopo($useragent, []);
        } elseif (preg_match('/s450\d/i', $useragent)) {
            $device = new Dns($useragent, []);
        } elseif (preg_match('/MB40II1/i', $useragent)) {
            $device = new Dns($useragent, []);
        } elseif (preg_match('/ M3 /', $useragent)) {
            $device = new Gionee($useragent, []);
        } elseif (preg_match('/(W100|W200|W8_beyond)/', $useragent)) {
            $device = new Thl($useragent, []);
        } elseif (preg_match('/NT\-\d{4}(S|P|T)/', $useragent)) {
            $device = new IconBit($useragent, []);
        } elseif (preg_match('/Primo76/', $useragent)) {
            $device = new Msi($useragent, []);
        } elseif (preg_match('/CINK PEAX 2/', $useragent)) {
            $device = new Wiko($useragent, []);
        } elseif (preg_match('/T(X|G)\d{2}/', $useragent)) {
            $device = new Irbis($useragent, []);
        } elseif (preg_match('/YD\d{3}/', $useragent)) {
            $device = new Yota($useragent, []);
        } elseif (preg_match('/X\-pad/', $useragent)) {
            $device = new Texet($useragent, []);
        } elseif (preg_match('/TM\-\d{4}/', $useragent)) {
            $device = new Texet($useragent, []);
        } elseif (preg_match('/ G3 /', $useragent)) {
            $device = new Lg($useragent, []);
        } elseif (preg_match('/(Zera_F|Boost IIse|Ice2|Prime S|Explosion)/', $useragent)) {
            $device = new Highscreen($useragent, []);
        } elseif (preg_match('/iris708/', $useragent)) {
            $device = new Ais($useragent, []);
        } elseif (preg_match('/L930/', $useragent)) {
            $device = new Ciotcud($useragent, []);
        } elseif (preg_match('/SMART Run/', $useragent)) {
            $device = new Mtc($useragent, []);
        } elseif (preg_match('/X8\+/', $useragent)) {
            $device = new Triray($useragent, []);
        } elseif (preg_match('/QS0716D/', $useragent)) {
            $device = new TriQ($useragent, []);
        } elseif (preg_match('/(Surfer 7\.34|M1_Plus|D7\.2 3G)/', $useragent)) {
            $device = new Explay($useragent, []);
        } elseif (preg_match('/PMSmart450/', $useragent)) {
            $device = new Pmedia($useragent, []);
        } elseif (preg_match('/(F031|SCL24|ACE)/', $useragent)) {
            $device = new Samsung($useragent, []);
        } elseif (preg_match('/ImPAD/', $useragent)) {
            $device = new Impression($useragent, []);
        } elseif (preg_match('/K1 turbo/', $useragent)) {
            $device = new Kingzone($useragent, []);
        } elseif (preg_match('/TAB917QC\-8GB/', $useragent)) {
            $device = new Sunstech($useragent, []);
        } elseif (preg_match('/(TPC\-PA10\.1M|M7T|P93G|i75)/', $useragent)) {
            $device = new Pipo($useragent, []);
        } elseif (preg_match('/ONE TOUCH/', $useragent)) {
            $device = new Alcatel($useragent, []);
        } elseif (preg_match('/6036Y/', $useragent)) {
            $device = new Alcatel($useragent, []);
        } elseif (preg_match('/MD948G/', $useragent)) {
            $device = new Mway($useragent, []);
        } elseif (preg_match('/P4501/', $useragent)) {
            $device = new Medion($useragent, []);
        } elseif (preg_match('/ V3 /', $useragent)) {
            $device = new Inew($useragent, []);
        } elseif (preg_match('/PX\-0905/', $useragent)) {
            $device = new Intego($useragent, []);
        } elseif (preg_match('/Smartphone650/', $useragent)) {
            $device = new Master($useragent, []);
        } elseif (preg_match('/MX Enjoy TV BOX/', $useragent)) {
            $device = new Geniatech($useragent, []);
        } elseif (preg_match('/TelePAD 9A1/', $useragent)) {
            $device = new Xoro($useragent, []);
        } elseif (preg_match('/A1000s/', $useragent)) {
            $device = new Xolo($useragent, []);
        } elseif (preg_match('/P3000/', $useragent)) {
            $device = new Elephone($useragent, []);
        } elseif (preg_match('/M5301/', $useragent)) {
            $device = new Iru($useragent, []);
        } elseif (preg_match('/ C7 /', $useragent)) {
            $device = new Cubot($useragent, []);
        } elseif (preg_match('/GV7777/', $useragent)) {
            $device = new Prestigio($useragent, []);
        } elseif (preg_match('/ N1 /', $useragent)) {
            $device = new Nokia($useragent, []);
        } elseif (preg_match('/N\d{4}/', $useragent)) {
            $device = new Star($useragent, []);
        } elseif (preg_match('/(Rio R1|GSmart\_T4)/', $useragent)) {
            $device = new Gigabyte($useragent, []);
        } elseif (preg_match('/7007HD/', $useragent)) {
            $device = new Perfeo($useragent, []);
        } elseif (preg_match('/IM\-A830L/', $useragent)) {
            $device = new Pantech($useragent, []);
        } elseif (preg_match('/K\-8S/', $useragent)) {
            $device = new Keener($useragent, []);
        } elseif (preg_match('/M601/', $useragent)) {
            $device = new Aoc($useragent, []);
        } elseif (preg_match('/H1\+/', $useragent)) {
            $device = new Hummer($useragent, []);
        } elseif (preg_match('/Pacific800i/', $useragent)) {
            $device = new Oysters($useragent, []);
        } elseif (preg_match('/Impress\_L/', $useragent)) {
            $device = new Vertex($useragent, []);
        } elseif (preg_match('/M040/', $useragent)) {
            $device = new Meizu($useragent, []);
        } elseif (preg_match('/CAL21/', $useragent)) {
            $device = new Gzone($useragent, []);
        } elseif (preg_match('/Numy_Note_9/', $useragent)) {
            $device = new Ainol($useragent, []);
        } elseif (preg_match('/TAB\-97E\-01/', $useragent)) {
            $device = new Reellex($useragent, []);
        } elseif (preg_match('/vega/i', $useragent)) {
            $device = new Advent($useragent, []);
        } elseif (preg_match('/dream/i', $useragent)) {
            $device = new Htc($useragent, []);
        } elseif (preg_match('/F10X/', $useragent)) {
            $device = new Nextway($useragent, []);
        } elseif (preg_match('/ M8 /', $useragent)) {
            $device = new Amlogic($useragent, []);
        } elseif (preg_match('/AdTab 7 Lite/', $useragent)) {
            $device = new Adspec($useragent, []);
        } elseif (preg_match('/Plane 10\.3 3G PS1043MG/', $useragent)) {
            $device = new Digma($useragent, []);
        } elseif (preg_match('/(Neon\-N1|WING\-W2)/', $useragent)) {
            $device = new Axgio($useragent, []);
        } elseif (preg_match('/T118/', $useragent)) {
            $device = new Twinovo($useragent, []);
        } elseif (preg_match('/(A1002|A811)/', $useragent)) {
            $device = new Lexand($useragent, []);
        } elseif (preg_match('/ A10/', $useragent)) {
            $device = new AllWinner($useragent, []);
        } elseif (preg_match('/TOUAREG8_3G/', $useragent)) {
            $device = new Accent($useragent, []);
        } elseif (preg_match('/chagall/', $useragent)) {
            $device = new Pegatron($useragent, []);
        } elseif (preg_match('/Turbo X6/', $useragent)) {
            $device = new TurboPad($useragent, []);
        } elseif (preg_match('/HW\-W718/', $useragent)) {
            $device = new Haier($useragent, []);
        } elseif (preg_match('/Air A70/', $useragent)) {
            $device = new RoverPad($useragent, []);
        } elseif (preg_match('/SP\-6020 QUASAR/', $useragent)) {
            $device = new Woo($useragent, []);
        } elseif (preg_match('/M717R-HD/', $useragent)) {
            $device = new VastKing($useragent, []);
        } elseif (preg_match('/Q10S/', $useragent)) {
            $device = new Wopad($useragent, []);
        } elseif (preg_match('/CTAB785R16\-3G/', $useragent)) {
            $device = new Condor($useragent, []);
        } elseif (preg_match('/RP\-UDM\d{2}/', $useragent)) {
            $device = new Verico($useragent, []);
        } elseif (preg_match('/(UQ785\-M1BGV|KM\-UQM11A)/', $useragent)) {
            $device = new Verico($useragent, []);
        } elseif (preg_match('/RG500/', $useragent)) {
            $device = new RugGear($useragent, []);
        } elseif (preg_match('/T9666\-1/', $useragent)) {
            $device = new Telsda($useragent, []);
        } elseif (preg_match('/1080P\-N003/', $useragent)) {
            $device = new Neo($useragent, []);
        } elseif (preg_match('/AP\-105/', $useragent)) {
            $device = new Mitashi($useragent, []);
        } elseif (preg_match('/H7100/', $useragent)) {
            $device = new Feiteng($useragent, []);
        } elseif (preg_match('/x909/', $useragent)) {
            $device = new Oppo($useragent, []);
        } elseif (preg_match('/CFNetwork/', $useragent)) {
            $device = new Apple($useragent, []);
        } else {
            $device = new GeneralMobile($useragent, []);
        }

        if ($device instanceof DeviceHasChildrenInterface) {
            $device = $device->detectDevice();
        }

        return $device;
    }
}
