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

namespace BrowserDetector\Helper;

use UaHelper\Utils;

/**
 * helper to get information if the device is a mobile
 *
 * @package   BrowserDetector
 */
class MobileDevice
{
    /**
     * @var string the user agent to handle
     */
    private $useragent = '';

    /**
     * @var \UaHelper\Utils the helper class
     */
    private $utils = null;

    /**
     * Class Constructor
     *
     * @param string $useragent
     *
     * @return \BrowserDetector\Helper\MobileDevice
     */
    public function __construct($useragent)
    {
        $this->utils = new Utils();

        $this->useragent = $useragent;
        $this->utils->setUserAgent($useragent);
    }

    /**
     * Returns true if the give $useragent is from a mobile device
     *
     * @return bool
     */
    public function isMobile()
    {
        /**
         * @var array Collection of mobile browser keywords
         */
        $mobileBrowsers = array(
            'android',
            'arm; touch',
            'aspen simulator',
            'bada',
            'bb10',
            'blackberry',
            'blazer',
            'bolt',
            'brew',
            'cldc',
            'dalvik',
            'danger hiptop',
            'embider',
            'fennec',
            'firefox or ie',
            'foma',
            'folio100',
            'gingerbread',
            'hd_mini_t',
            'hp-tablet',
            'hpwOS',
            'htc',
            'ipad',
            'iphone',
            'iphoneosx',
            'iphone os',
            'ipod',
            'iris',
            'iuc(u;ios',
            'j2me',
            'juc(linux;u;',
            'juc (linux; u;',
            'kindle',
            'lenovo',
            'like mac os x',
            'linux armv',
            'look-alike',
            'maemo',
            'meego',
            'midp',
            'mobile version',
            'mobile safari',
            'mqqbrowser',
            'netfront',
            'nintendo',
            'nokia',
            'obigo',
            'openwave',
            'opera mini',
            'opera mobi',
            'palm',
            'phone',
            'playstation',
            'pocket pc',
            'pocketpc',
            'rim tablet',
            'samsung',
            'series40',
            'series 60',
            'silk',
            'symbian',
            'symbianos',
            'symbos',
            'toshiba_ac_and_az',
            'touchpad',
            'transformer tf',
            'up.browser',
            'up.link',
            'xblwp7',
            'wap2',
            'webos',
            'wetab-browser',
            'windows ce',
            'windows mobile',
            'windows phone os',
            'wireless',
            'xda_diamond_2',
            'zunewp7',
            'wpdesktop',
            'jolla',
            'sailfish',
            'padfone',
            'st80208',
        );

        if ($this->utils->checkIfContains($mobileBrowsers, true)) {
            $noMobiles = array(
                'xbox', 'badab', 'badap', 'simbar', 'google-tr', 'googlet',
                'google wireless transcoder', 'eeepc', 'i9988_custom',
                'i9999_custom', 'wuid=', 'smart-tv', 'sonydtv'
            );

            if ($this->utils->checkIfContains($noMobiles, true)) {
                return false;
            }

            return true;
        }

        if ($this->utils->checkIfContains('tablet', true)
            && !$this->utils->checkIfContains('tablet pc', true)
        ) {
            return true;
        }

        if ($this->utils->checkIfContains('mobile', true)
            && !$this->utils->checkIfContains('automobile', true)
        ) {
            return true;
        }

        if ($this->utils->checkIfContains('sonydtv', true)) {
            return false;
        }

        if ($this->utils->checkIfContains(array('ARM;'))
            && $this->utils->checkIfContains(array('Windows NT 6.2', 'Windows NT 6.3'))
        ) {
            return true;
        }

        $doMatch = preg_match('/\d+\*\d+/', $this->useragent);
        if ($doMatch) {
            return true;
        }

        $helper = new FirefoxOs();
        $helper->setUserAgent($this->useragent);

        if ($helper->isFirefoxOs()) {
            return true;
        }

        $windowsHelper = new Windows($this->useragent);

        if ($windowsHelper->isWindows() && $this->utils->checkIfContains('touch', true)) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isSamsung()
    {
        $samsungPhones = array(
            'samsung',
            'samsung',
            'gt-',
            'sam-',
            'sc-',
            'sch-',
            'sec-',
            'sgh-',
            'shv-',
            'shw-',
            'sm-',
            'sph-',
            'galaxy',
            'nexus',
            'i7110',
            'i9100',
            'i9300',
            'yp-g',
            'continuum-',
            'blaze'
        );

        if (!$this->utils->checkIfContains($samsungPhones, true)) {
            return false;
        }

        $otherMobiles = array(
            'Asus',
            'U30GT',
            'Nexus 7',
            'Nexus 4',
            'Nexus 5',
            'Nexus 9',
            'NexusHD2',
            'Nexus One',
            'NexusOne',
            'Nexus-One',
            'GT-H',
            'MT-GT-',
            'Galaxy S3 EX'
        );

        if ($this->utils->checkIfContains($otherMobiles)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isApple()
    {
        if (!$this->utils->checkIfContains(array('ipad', 'iphone', 'ipod', 'like mac os x'), true)) {
            return false;
        }

        if ($this->utils->checkIfContains(array('Android', 'MooPad'))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isHtc()
    {
        if ($this->utils->checkIfContains('WOHTC')) {
            return false;
        }

        $htcPhones = array(
            'HTC',
            '7 Trophy',
            ' a6288 ',
            'Desire_A8181',
            'Desire HD',
            'Desire S',
            'EVO3D_X515m',
            'HD2',
            'IncredibleS_S710e',
            'MDA_Compact_V',
            'MDA Vario',
            'MDA_Vario_V',
            'One S',
            'Sensation_4G',
            'SensationXE',
            'SensationXL',
            'Sensation XL',
            'Sensation_Z710e',
            'Xda_Diamond_2',
            'Vision-T-Mobile-G2',
            'Wildfire S',
            'Wildfire S A510e',
            'HTC_WildfireS_A510e',
            'VPA_Touch',
            'APA9292KT',
            'APA7373KT',
            'APX515CKT',
            ' a315c ',
            'Nexus One',
            'NexusOne',
            'Nexus-One',
            'Nexus 9',
            'pcdadr6350',
            'ADR6350',
            'PJ83100',
            'Vodafone Smart Tab III 7'
        );

        if (!$this->utils->checkIfContains($htcPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isHuawei()
    {
        $huaweiPhones = array(
            'Huawei',
            'HUAWEI',
            'IDEOS ',
            'Ideos ',
            'U8100',
            'U8110',
            'U8180',
            'U8500',
            'U8510',
            'U8650',
            'u8800',
            'U8850',
            'Vodafone 858',
            'Vodafone 845',
            'TSP21'
        );

        if (!$this->utils->checkIfContains($huaweiPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isSony()
    {
        $sonyPhones = array(
            'sonyericsson',
            'sony',
            'c1505',
            'c1605',
            'c1905',
            'c2105',
            'c5303',
            'c6602',
            'c6603',
            'c6503',
            'c6903',
            'xperia z',
            'c6833',
            'd6503',
            'd5503',
            'd6603',
            'd5803',
            'd2303',
            'd2005',
            'e10i',
            'e15i',
            'e15av',
            'ebrd1',
            'lt15i',
            'lt18',
            'lt18i',
            'lt22i',
            'lt25i',
            'lt26i',
            'lt28h',
            'lt30p',
            'mk16i',
            'mt11i',
            'mt15i',
            'mt27i',
            'nexushd2',
            'r800i',
            's312',
            'sk17i',
            'sgp311',
            'sgp312',
            'sgp321',
            'sgp511',
            'sgp512',
            'sgp521',
            'sgpt12',
            'sgpt13',
            'st15i',
            'st16i',
            'st17i',
            'st18i',
            'st19i',
            'st20i',
            'st21i',
            'st22i',
            'st23i',
            'st24i',
            'st25i',
            'st26i',
            'st27i',
            'u20i',
            'w508a',
            'w760i',
            'wt13i',
            'wt19i',
            'x1i',
            'x10',
            'xst2',
            'playstation',
            'psp',
            'xperia arc'
        );

        if (!$this->utils->checkIfContains($sonyPhones, true)) {
            return false;
        }

        $others = array('uno_x10', 'x10.dual');

        if ($this->utils->checkIfContains($others, true)) {
            return false;
        }

        return true;
    }

    public function isNokia()
    {
        $nokiaPhones = array(
            'nokia',
            's60; symbos;',
            'series 40',
            'series 60',
            's60v5',
            'n900'
        );

        if (!$this->utils->checkIfContains($nokiaPhones, true)) {
            return false;
        }

        if ($this->utils->checkIfContains(array('N90 DUAL CORE2'))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isAmazon()
    {
        $amazonPhones = array(
            'Amazon',
            'Kindle',
            'Silk',
            'KFTT',
            'KFOT',
            'KFJWI',
            'KFSOWI',
            'KFTHWI',
            'SD4930UR',
        );

        if (!$this->utils->checkIfContains($amazonPhones)) {
            return false;
        }

        if ($this->utils->checkIfContains('PlayStation')) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isAlcatel()
    {
        $alcatelPhones = array(
            'ALCATEL',
            'Alcatel',
            'Vodafone 975N',
            'Vodafone Smart II',
            'ONE TOUCH',
        );

        if (!$this->utils->checkIfContains($alcatelPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isAcer()
    {
        $otherPhones = array('HTC', 'IdeaTab', 'Wildfire S A510e', 'HTC_WildfireS_A510e', 'A101IT', 'SmartTabII7');

        if ($this->utils->checkIfContains($otherPhones)) {
            return false;
        }

        $acerPhones = array(
            'Acer',
            'Iconia',
            ' A100 ',
            ' A101 ',
            ' A200 ',
            ' A210 ',
            ' A211 ',
            ' A500 ',
            ' A501 ',
            ' A510 ',
            ' A511 ',
            ' A700 ',
            ' A701 ',
            ' A1-',
            ' A3-',
            ' B1-',
            ' E140 ',
            ' E310 ',
            ' E320 ',
            ' G100W ',
            'Stream-S110',
            ' Liquid ',
            ' S500 ',
            ' Z150 ',
            ' V370 ',
        );

        if (!$this->utils->checkIfContains($acerPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isMotorola()
    {
        if ($this->utils->checkIfContains(array('HTC', 'Amazon Kindle Fire'))) {
            return false;
        }

        $motorolaPhones = array(
            'motorola',
            'moto',
            //'mot',
            'mb200',
            'mb300',
            ' droid ',
            ' droidx ',
            'droid-bionic',
            'xt702',
            'mz601',
            'mz604',
            'mz616',
            'xoom',
            'milestone',
            'mb511',
            'mb525',
            'mb526',
            'mb632',
            'mb860',
            'me511',
            'me525',
            'me600',
            'xt316',
            'xt320',
            'xt610',
            'xt615',
            'xt890',
            'xt907',
            'xt910',
            'xt925',
            'xt1021',
            'xt1052',
            'xt1032',
        );

        if (!$this->utils->checkIfContains($motorolaPhones, true)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isMicrosoft()
    {
        if (!$this->utils->checkIfContains(array('ARM;'))) {
            return false;
        }

        if (!$this->utils->checkIfContains(array('Windows NT 6.2', 'Windows NT 6.3'))) {
            return false;
        }

        if ($this->utils->checkIfContains(array('WPDesktop'))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isArchos()
    {
        $archosPhones = array(
            'archos',
            'a35dm',
            'a70bht',
            'a70cht',
            'a70s',
            'a70h2',
            'a80ksc',
            'a101it',
            'a70hb',
            'a7eb'
        );

        if (!$this->utils->checkIfContains($archosPhones, true)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isArnova()
    {
        $arnovaPhones = array(
            'ARNOVA',
            'AN7CG2',
            'AN7DG3',
            'AN7FG3',
            'AN10BG3',
            'AN10DG3',
            'ARCHM901',
            'AN7BG2DT',
            'AN9G2I'
        );

        if (!$this->utils->checkIfContains($arnovaPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isAsus()
    {
        $asusPhones = array(
            'Asus',
            'ASUS',
            'Transformer',
            'Slider SL101',
            'eee_701',
            'eeepc',
            'Nexus 7',
            'PadFone',
            'ME301T',
            'ME302C',
            'ME371MG',
            'ME173X',
            'ME302KL',
            'ME172V',
            'K00E',
            'K00F',
            'K00Z',
            'ME372CG',
            'TF300T',
        );

        if (!$this->utils->checkIfContains($asusPhones)) {
            return false;
        }

        if ($this->utils->checkIfContains(array('IdeaTab'))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isBeidou()
    {
        $beidouPhones = array(
            'Beidou',
            'LA-M1'
        );

        if (!$this->utils->checkIfContains($beidouPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isBlackberry()
    {
        $rimPhones = array('BlackBerry', 'PlayBook', 'RIM Tablet', 'BB10');

        if (!$this->utils->checkIfContains($rimPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isBlaupunkt()
    {
        $blaupunktPhones = array('Blaupunkt', 'Endeavour');

        if (!$this->utils->checkIfContains($blaupunktPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isCaterpillar()
    {
        $caterpillarPhones = array(
            'Caterpillar',
            'B15Q',
        );

        if (!$this->utils->checkIfContains($caterpillarPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isCatSound()
    {
        $catSoundPhones = array(
            'CatNova',
            'CAT NOVA',
            'CatNova8',
            'Cat StarGate',
            'Cat Tablet',
            'Tablet-PC-4',
            'TOLINO_BROWSER',
            'Weltbild',
            'Kinder-Tablet'
        );

        if (!$this->utils->checkIfContains($catSoundPhones)) {
            return false;
        }

        if ($this->utils->checkIfContains(array('INM8002KP'))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isCoby()
    {
        $cobyphones = array(
            'Coby',
            'MID8024',
            'MID1125',
            'MID1126',
            'MID7015',
            'MID7022',
            'MID8127',
            'MID8128',
            'MID9742',
            'NBPC724'
        );

        if (!$this->utils->checkIfContains($cobyphones, true)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isComag()
    {
        $comagphones = array(
            'Comag',
            'WTDR1018',
        );

        if (!$this->utils->checkIfContains($comagphones, true)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isCosmote()
    {
        if (!$this->utils->checkIfContains('cosmote', true)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isCreative()
    {
        $creativePhones = array('Creative', 'ZiiLABS');

        if (!$this->utils->checkIfContains($creativePhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isCube()
    {
        if (!$this->utils->checkIfContains(array('cube', 'U30GT'))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isCubot()
    {
        $cubotPhones = array('CUBOT');

        if (!$this->utils->checkIfContains($cubotPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isZte()
    {
        $ztePhones = array(
            'zte',
            'base tab',
            'base lutea',
            'BASE_Lutea_3',
            'racerii',
            ' x920 ',
            ' n600 ',
            ' w713 ',
            ' v880 ',
            ' v9 ',
            'smarttab7',
            'smarttab10',
            'blade',
            'kis plus',
            'vodafone smart 4g',
        );

        if (!$this->utils->checkIfContains($ztePhones, true)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isDell()
    {
        $dellphones = array('dell');

        if (!$this->utils->checkIfContains($dellphones, true)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isDenver()
    {
        if (!$this->utils->checkIfContains(array('Denver', 'TAD-'))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isDocomo()
    {
        $doCoMophones = array(
            'DoCoMo',
            'P900i'
        );

        if (!$this->utils->checkIfContains($doCoMophones, true)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isEasypix()
    {
        if (!$this->utils->checkIfContains(array('Easypix', 'Junior 4.0', 'EasyPad'))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isEfox()
    {
        $efoxPhones = array(
            'Efox', 'SMART-E5'
        );

        if (!$this->utils->checkIfContains($efoxPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isEpad()
    {
        if (!$this->utils->checkIfContains('p7901a', true)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isFeiteng()
    {
        if (!$this->utils->checkIfContains(array('Feiteng', 'GT-H'))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isFlytouch()
    {
        if (!$this->utils->checkIfContains('Flytouch')) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isFujitsu()
    {
        if (!$this->utils->checkIfContains(array('Fujitsu', 'M532'))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isHannspree()
    {
        if (!$this->utils->checkIfContains('SN10T1')) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isHdc()
    {
        $hdcPhones = array(
            'HDC',
            'Galaxy S3 EX'
        );

        if (!$this->utils->checkIfContains($hdcPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isHiphone()
    {
        if (!$this->utils->checkIfContains(array('HiPhone', 'V919'))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isHonlin()
    {
        $honlinPhones = array(
            'Honlin',
            'HL',
            'PC1088',
        );

        if (!$this->utils->checkIfContains($honlinPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isHp()
    {
        $hpPhones = array(
            'HP',
            'Hp',
            'P160U',
            'TouchPad',
            'hpwOS',
            'hp-tablet',
            'Pre/',
            'Pixi/',
            'Touchpad',
            'Palm',
            'Blazer',
            'HPiPAQ',
            'cm_tenderloin'
        );

        if (!$this->utils->checkIfContains($hpPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isHtm()
    {
        $htmPhones = array(
            'MT-GT-A9500',
        );

        if (!$this->utils->checkIfContains($htmPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isIconbit()
    {
        $iconBitPhones = array('IconBit', 'nt-1001t', 'nt-1002t');

        if (!$this->utils->checkIfContains($iconBitPhones, true)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isIntenso()
    {
        if (!$this->utils->checkIfContains(array('INM803HC', 'INM8002KP'))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isIonik()
    {
        $ionikPhones = array('ionik', 'tp10.1-1500dc');

        if (!$this->utils->checkIfContains($ionikPhones, true)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isJaytech()
    {
        $jaytechphones = array(
            'JAY-tech',
            'TPC-PA10.1M',
        );

        if (!$this->utils->checkIfContains($jaytechphones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isJolla()
    {
        if (!$this->utils->checkIfContains(array('jolla', 'sailfish'), true)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isKazam()
    {
        $kazamPhones = array('KAZAM');

        if (!$this->utils->checkIfContains($kazamPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isKddi()
    {
        $kddiPhones = array('KDDI');

        if (!$this->utils->checkIfContains($kddiPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isKeenhigh()
    {
        if (!$this->utils->checkIfContains(' MT791 ')) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isKobo()
    {
        if (!$this->utils->checkIfContains('Kobo Touch')) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isLenco()
    {
        $lencoPhones = array(
            'Lenco',
            'LENCM900HZ',
            'CoolTab-70'
        );

        if (!$this->utils->checkIfContains($lencoPhones, true)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isLenovo()
    {
        $lenovoPhones = array(
            'Lenovo-',
            'Lenovo/',
            'Lenovo',
            'A1_07',
            ' K1 ',
            'ThinkPad',
            'IdeaTab',
            'SmartTab II',
            'SmartTabII7',
            'SmartTabII10',
            'SmartTabIII10',
            'Vodafone Smart Tab III 10',
            'Vodafone Smart Tab 4'
        );

        if (!$this->utils->checkIfContains($lenovoPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isLepan()
    {
        if (!$this->utils->checkIfContains('LePan')) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isLg()
    {
        $lgPhones = array(
            'LG-',
            'LG/',
            'LG',
            'Optimus-',
            'Optimus 2X',
            ' p990 ',
            ' GT540 ',
            ' GT-540 ',
            'Nexus 4',
            'Nexus 5',
        );

        if (!$this->utils->checkIfContains($lgPhones)) {
            return false;
        }

        if ($this->utils->checkIfContains(array('-LGG-'))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isLogikpd()
    {
        if (!$this->utils->checkIfContains(array('LogicPD', 'Zoom2', 'NookColor'))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isMedion()
    {
        if ($this->utils->checkIfContains('medion', true)) {
            return true;
        }

        if ($this->utils->checkIfContains(array('MD_', 'LIFETAB', 'P4501'))) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isMeizu()
    {
        $meizuPhones = array('Meizu', ' M9 ');

        if (!$this->utils->checkIfContains($meizuPhones, true)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isMicromax()
    {
        $micromaxPhones = array('Micromax', ' A114 ');

        if (!$this->utils->checkIfContains($micromaxPhones, true)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isMobistel()
    {
        if (!$this->utils->checkIfContains('cynus', true)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isNec()
    {
        $necPhones = array(
            'Nec',
            'N905i',
            'N705i'
        );

        if (!$this->utils->checkIfContains($necPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isNeofonia()
    {
        if (!$this->utils->checkIfContains(array('WeTab', 'WeTab-Browser'))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isNextbook()
    {
        if (!$this->utils->checkIfContains(array('Nextbook', 'DATAM803HC', 'NEXT'))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isNintendo()
    {
        $nintendoDevices = array('Nintendo');

        if (!$this->utils->checkIfContains($nintendoDevices)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isOdys()
    {
        $odysPhones = array(
            'odys',
            'loox plus',
            ' genesis ',
            ' noon ',
            ' loox ',
            'xpress pro',
            'xelio',
            'uno_x10',
            'adm816kc',
            'adm816hc',
            'neo_quad10',
        );

        if (!$this->utils->checkIfContains($odysPhones, true)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isOlivetti()
    {
        if (!$this->utils->checkIfContains('OP') || $this->utils->checkIfContains(
                array('OPN-B', 'OPENMASTER', 'SL20_20101210_B_PD_INX7E_ENG_6410POP', 'Build/JOP')
            )
        ) {
            return false;
        }

        if ($this->utils->checkIfContains('OPR/')) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isOppo()
    {
        if (!$this->utils->checkIfContains(array('Oppo', 'X909'))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isPanasonic()
    {
        if (!$this->utils->checkIfContains(array('Panasonic', ' dL1 '))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isPandigital()
    {
        if (!$this->utils->checkIfContains(array('pandigital', 'SL20_20101210_B_PD_INX7E_ENG_6410POP'))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isPearl()
    {
        if (!$this->utils->checkIfContains(array(' X7G ', 'X10.Dual'))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isPhicomm()
    {
        $phicommPhones = array(
            'Phicomm',
            'FWS610_EU'
        );

        if (!$this->utils->checkIfContains($phicommPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isPipo()
    {
        $pipophones = array(
            'pipo',
            'm9pro',
            'm6pro',
        );

        if (!$this->utils->checkIfContains($pipophones, true)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isPointofview()
    {
        if (!$this->utils->checkIfContains(array('TAB-PROTAB'))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isPomp()
    {
        $pompPhones = array('pomp');

        if (!$this->utils->checkIfContains($pompPhones, true)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isPrestigio()
    {
        $phones = array(
            'Prestigio',
            'PMP5080CPRO',
            'PMP3370B',
            'PMP5197DULTRA',
            'PMP5580C',
            'PMP7100D3G',
            'PMP7280C3G',
            'PMP5770D',
            'PAP5000TDUO',
            'PMP5080B',
        );

        if (!$this->utils->checkIfContains($phones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isQmobile()
    {
        $qmobilePhones = array(
            'QMobile',
            ' A10 '
        );

        if (!$this->utils->checkIfContains($qmobilePhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isSanyo()
    {
        if (!$this->utils->checkIfContains(array('Sanyo', 'PM-8200'))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isSharp()
    {
        $sharpPhones = array(
            'SHARP',
            'IS05',
            'SH80F',
            'SH7228U',
            'SH8128U'
        );

        if (!$this->utils->checkIfContains($sharpPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isSiemens()
    {
        $siemensPhones = array(
            'Siemens',
            'SIE-',
            'SL45i',
        );

        if (!$this->utils->checkIfContains($siemensPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isSimvallay()
    {
        if (!$this->utils->checkIfContains(array('SPX-5'))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isSprint()
    {
        if (!$this->utils->checkIfContains('Sprint')) {
            return false;
        }

        if ($this->utils->checkIfContains(array('APA9292KT', 'APA7373KT', 'APX515CKT'))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isStar()
    {
        $starPhones = array('Star', 'N9500');

        if (!$this->utils->checkIfContains($starPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isTechnisat()
    {
        $phones = array(
            'Technisat',
            'TechniPad'
        );

        if (!$this->utils->checkIfContains($phones, true)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isTexet()
    {
        if (!$this->utils->checkIfContains(array('Texet', 'NaviPad TM-7055HD 3G'))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isThl()
    {
        if (!$this->utils->checkIfContains(array('thl'), true)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isTmobile()
    {
        $tmobilePhones = array(
            'T-Mobile',
            'myTouch4G',
            'MDA compact',
            'T-Mobile_G2_Touch',
            'Pulse',
            'Ameo'
        );

        if (!$this->utils->checkIfContains($tmobilePhones, true)) {
            return false;
        }

        if ($this->utils->checkIfContains('Vision-T-Mobile-G2')) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isTolino()
    {
        if (!$this->utils->checkIfContains(array('tolino'), true)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isToshiba()
    {
        $toshibaPhones = array(
            'Toshiba-',
            'Toshiba/',
            'Toshiba',
            'AT100',
            'AT200',
            'AT300',
            'folio100',
            'TSB_CLOUD_COMPANION;FOLIO_AND_A',
            'TOSHIBA_AC_AND_AZ',
            'TOSHIBA_FOLIO_AND_A'
        );

        if (!$this->utils->checkIfContains($toshibaPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isTrekstor()
    {
        $trekStorPhones = array(
            'TrekStor',
            'ST10216-1',
            'ST10416-1',
            'ST70104',
            'ST80216',
            'Liro_Color',
            'SurfTab_',
            'ST701041',
            'VT10416',
            'breeze 10.1 quad',
        );

        if (!$this->utils->checkIfContains($trekStorPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isTriq()
    {
        $triQphones = array(
            '3Q',
            'MT0812E',
        );

        if (!$this->utils->checkIfContains($triQphones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isViewsonic()
    {
        if (!$this->utils->checkIfContains(array('ViewSonic', 'ViewPad'))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isWiko()
    {
        $phones = array(
            'Wiko',
            'RAINBOW',
            'GETAWAY',
            'DARKMOON',
            'LENNY',
        );

        if (!$this->utils->checkIfContains($phones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isWondermedia()
    {
        if (!$this->utils->checkIfContains(array(' WM8650 ', ' WM8850 '))) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isXiaomi()
    {
        $xiaomiPhones = array(
            'Xiaomi',
            'MI 2',
            'MI 3W',
        );

        if (!$this->utils->checkIfContains($xiaomiPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isYuandao()
    {
        $yuandaoPhones = array(
            'yuandao',
            'n90 dual core2',
            'n90fhdrk'
        );

        if (!$this->utils->checkIfContains($yuandaoPhones, true)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isYusu()
    {
        $yusuPhones = array(
            'Yusu',
            'e1107'
        );

        if (!$this->utils->checkIfContains($yusuPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isZenithink()
    {
        $zenithinkPhones = array(
            'Zenithink',
            ' zt180 '
        );

        if (!$this->utils->checkIfContains($zenithinkPhones, true)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isZopo()
    {
        $zopoPhones = array(
            ' ZP100 ',
            ' ZP200 ',
            ' ZP300 ',
            ' ZP500 ',
            ' ZP800H ',
            ' ZP810 ',
            ' ZP900 ',
            ' ZP900H ',
            ' ZP910 ',
            ' ZP950 ',
            ' ZP980 '
        );

        if (!$this->utils->checkIfContains($zopoPhones)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isCoolpad()
    {
        if (!$this->utils->checkIfContains(' N930 ')) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isFaktorZwei()
    {
        if (!$this->utils->checkIfContains('FX2-PAD10')) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isO2()
    {
        if (!$this->utils->checkIfContains('Xda_orbit_2')) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isNvsbl()
    {
        if (!$this->utils->checkIfContains('P4D SIRIUS')) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isPantech()
    {
        if (!$this->utils->checkIfContains('PantechP2020')) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isMemup()
    {
        if (!$this->utils->checkIfContains('Slidepad')) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isEinsUndEins()
    {
        if (!$this->utils->checkIfContains('smartpad')) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isVizio()
    {
        if (!$this->utils->checkIfContains('VTAB1008')) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isMiui()
    {
        if (!$this->utils->checkIfContains('MIUI.us Sensation 4G')) {
            return false;
        }

        return true;
    }
}
