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
use BrowserDetector\Detector\Company\Creative;
use BrowserDetector\Detector\Device\GeneralMobile;
use BrowserDetector\Detector\Device\Mobile\Acer;
use BrowserDetector\Detector\Device\Mobile\Alcatel;
use BrowserDetector\Detector\Device\Mobile\Amazon;
use BrowserDetector\Detector\Device\Mobile\Amoi;
use BrowserDetector\Detector\Device\Mobile\Apple;
use BrowserDetector\Detector\Device\Mobile\Archos;
use BrowserDetector\Detector\Device\Mobile\Arnova;
use BrowserDetector\Detector\Device\Mobile\Asus;
use BrowserDetector\Detector\Device\Mobile\BarnesNoble;
use BrowserDetector\Detector\Device\Mobile\Beidou;
use BrowserDetector\Detector\Device\Mobile\BlackBerry;
use BrowserDetector\Detector\Device\Mobile\Blaupunkt;
use BrowserDetector\Detector\Device\Mobile\Caterpillar;
use BrowserDetector\Detector\Device\Mobile\CatSound;
use BrowserDetector\Detector\Device\Mobile\Coby;
use BrowserDetector\Detector\Device\Mobile\Comag;
use BrowserDetector\Detector\Device\Mobile\Coolpad;
use BrowserDetector\Detector\Device\Mobile\Cosmote;
use BrowserDetector\Detector\Device\Mobile\Cube;
use BrowserDetector\Detector\Device\Mobile\Cubot;
use BrowserDetector\Detector\Device\Mobile\Dell;
use BrowserDetector\Detector\Device\Mobile\Denver;
use BrowserDetector\Detector\Device\Mobile\DoCoMo;
use BrowserDetector\Detector\Device\Mobile\Easypix;
use BrowserDetector\Detector\Device\Mobile\Efox;
use BrowserDetector\Detector\Device\Mobile\EinsUndEins;
use BrowserDetector\Detector\Device\Mobile\Epad;
use BrowserDetector\Detector\Device\Mobile\FaktorZwei;
use BrowserDetector\Detector\Device\Mobile\Feiteng;
use BrowserDetector\Detector\Device\Mobile\Flytouch;
use BrowserDetector\Detector\Device\Mobile\Fujitsu;
use BrowserDetector\Detector\Device\Mobile\Hannspree;
use BrowserDetector\Detector\Device\Mobile\Hdc;
use BrowserDetector\Detector\Device\Mobile\HiPhone;
use BrowserDetector\Detector\Device\Mobile\Honlin;
use BrowserDetector\Detector\Device\Mobile\Hp;
use BrowserDetector\Detector\Device\Mobile\Htc;
use BrowserDetector\Detector\Device\Mobile\Htm;
use BrowserDetector\Detector\Device\Mobile\Huawei;
use BrowserDetector\Detector\Device\Mobile\IconBit;
use BrowserDetector\Detector\Device\Mobile\Intenso;
use BrowserDetector\Detector\Device\Mobile\Ionik;
use BrowserDetector\Detector\Device\Mobile\Jaytech;
use BrowserDetector\Detector\Device\Mobile\Jolla;
use BrowserDetector\Detector\Device\Mobile\Kazam;
use BrowserDetector\Detector\Device\Mobile\Kddi;
use BrowserDetector\Detector\Device\Mobile\KeenHigh;
use BrowserDetector\Detector\Device\Mobile\Kobo;
use BrowserDetector\Detector\Device\Mobile\Lenco;
use BrowserDetector\Detector\Device\Mobile\Lenovo;
use BrowserDetector\Detector\Device\Mobile\LePan;
use BrowserDetector\Detector\Device\Mobile\Lg;
use BrowserDetector\Detector\Device\Mobile\Logikpd;
use BrowserDetector\Detector\Device\Mobile\Medion;
use BrowserDetector\Detector\Device\Mobile\Meizu;
use BrowserDetector\Detector\Device\Mobile\Memup;
use BrowserDetector\Detector\Device\Mobile\Micromax;
use BrowserDetector\Detector\Device\Mobile\Microsoft;
use BrowserDetector\Detector\Device\Mobile\Miui;
use BrowserDetector\Detector\Device\Mobile\Mobistel;
use BrowserDetector\Detector\Device\Mobile\Motorola;
use BrowserDetector\Detector\Device\Mobile\Nec;
use BrowserDetector\Detector\Device\Mobile\Neofonie;
use BrowserDetector\Detector\Device\Mobile\Nextbook;
use BrowserDetector\Detector\Device\Mobile\Nintendo;
use BrowserDetector\Detector\Device\Mobile\Nokia;
use BrowserDetector\Detector\Device\Mobile\Nvsbl;
use BrowserDetector\Detector\Device\Mobile\O2;
use BrowserDetector\Detector\Device\Mobile\Odys;
use BrowserDetector\Detector\Device\Mobile\Olivetti;
use BrowserDetector\Detector\Device\Mobile\Oppo;
use BrowserDetector\Detector\Device\Mobile\Panasonic;
use BrowserDetector\Detector\Device\Mobile\Pandigital;
use BrowserDetector\Detector\Device\Mobile\Pantech;
use BrowserDetector\Detector\Device\Mobile\Pearl;
use BrowserDetector\Detector\Device\Mobile\Phicomm;
use BrowserDetector\Detector\Device\Mobile\Pipo;
use BrowserDetector\Detector\Device\Mobile\PointOfView;
use BrowserDetector\Detector\Device\Mobile\Pomp;
use BrowserDetector\Detector\Device\Mobile\Prestigio;
use BrowserDetector\Detector\Device\Mobile\Qmobile;
use BrowserDetector\Detector\Device\Mobile\Samsung;
use BrowserDetector\Detector\Device\Mobile\Sanyo;
use BrowserDetector\Detector\Device\Mobile\Sharp;
use BrowserDetector\Detector\Device\Mobile\Siemens;
use BrowserDetector\Detector\Device\Mobile\Simvalley;
use BrowserDetector\Detector\Device\Mobile\SonyEricsson;
use BrowserDetector\Detector\Device\Mobile\Sprint;
use BrowserDetector\Detector\Device\Mobile\Star;
use BrowserDetector\Detector\Device\Mobile\Technisat;
use BrowserDetector\Detector\Device\Mobile\Texet;
use BrowserDetector\Detector\Device\Mobile\Thl;
use BrowserDetector\Detector\Device\Mobile\Tmobile;
use BrowserDetector\Detector\Device\Mobile\Tolino;
use BrowserDetector\Detector\Device\Mobile\Toshiba;
use BrowserDetector\Detector\Device\Mobile\TrekStor;
use BrowserDetector\Detector\Device\Mobile\TriQ;
use BrowserDetector\Detector\Device\Mobile\ViewSonic;
use BrowserDetector\Detector\Device\Mobile\Vizio;
use BrowserDetector\Detector\Device\Mobile\Wiko;
use BrowserDetector\Detector\Device\Mobile\WonderMedia;
use BrowserDetector\Detector\Device\Mobile\Xiaomi;
use BrowserDetector\Detector\Device\Mobile\Yuandao;
use BrowserDetector\Detector\Device\Mobile\Yusu;
use BrowserDetector\Detector\Device\Mobile\Zenithink;
use BrowserDetector\Detector\Device\Mobile\Zopo;
use BrowserDetector\Detector\Device\Mobile\Zte;
use BrowserDetector\Detector\Type\Device as DeviceType;
use BrowserDetector\Helper\Classname;
use BrowserDetector\Helper\MobileDevice;
use Psr\Log\LoggerInterface;
use UaMatcher\Device\DeviceHasChildrenInterface;
use WurflCache\Adapter\AdapterInterface;

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
     * @param string                               $useragent
     * @param \Psr\Log\LoggerInterface             $logger
     * @param \WurflCache\Adapter\AdapterInterface $cache
     *
     * @return \UaMatcher\Device\DeviceInterface
     */
    public static function detect($useragent, LoggerInterface $logger, AdapterInterface $cache = null)
    {
        foreach (self::getChain($cache, $logger) as $device) {
            /** @var \UaMatcher\Device\DeviceInterface $device */
            $device->setUserAgent($useragent);

            if ($device->canHandle()) {
                $device->setLogger($logger);
                $device->setCache($cache);

                return $device;
            }
        }

        $device = new GeneralMobile($useragent, $logger);
        $device->setCache($cache);

        return $device;
        $helper = new MobileDevice($useragent);

        if ($helper->isSamsung()) {
            $device = new Samsung($useragent, $logger);
        } elseif ($helper->isApple()) {
            $device = new Apple($useragent, $logger);
        } elseif ($helper->isHtc()) {
            $device = new Htc($useragent, $logger);
        } elseif ($helper->isHuawei()) {
            $device = new Huawei($useragent, $logger);
        } elseif ($helper->isSony()) {
            $device = new SonyEricsson($useragent, $logger);
        } elseif ($helper->isNokia()) {
            $device = new Nokia($useragent, $logger);
        } elseif ($helper->isAmazon()) {
            $device = new Amazon($useragent, $logger);
        } elseif ($helper->isAlcatel()) {
            $device = new Alcatel($useragent, $logger);
        } elseif ($helper->isAcer()) {
            $device = new Acer($useragent, $logger);
        } elseif ($helper->isMotorola()) {
            $device = new Motorola($useragent, $logger);
        } elseif ($helper->isMicrosoft()) {
            $device = new Microsoft($useragent, $logger);
        } elseif ($helper->isZte()) {
            $device = new Zte($useragent, $logger);
        } elseif ($helper->isLg()) {
            $device = new Lg($useragent, $logger);
        } elseif (preg_match('/amoi/i', $useragent)) {
            $device = new Amoi($useragent, $logger);
        } elseif ($helper->isArchos()) {
            $device = new Archos($useragent, $logger);
        } elseif ($helper->isArnova()) {
            $device = new Arnova($useragent, $logger);
        } elseif ($helper->isAsus()) {
            $device = new Asus($useragent, $logger);
        } elseif (preg_match('/ BN /', $useragent)) {
            $device = new BarnesNoble($useragent, $logger);
        } elseif ($helper->isBeidou()) {
            $device = new Beidou($useragent, $logger);
        } elseif ($helper->isBlackberry()) {
            $device = new BlackBerry($useragent, $logger);
        } elseif ($helper->isCaterpillar()) {
            $device = new Caterpillar($useragent, $logger);
        } elseif ($helper->isCatSound()) {
            $device = new CatSound($useragent, $logger);
        } elseif ($helper->isCoby()) {
            $device = new Coby($useragent, $logger);
        } elseif ($helper->isComag()) {
            $device = new Comag($useragent, $logger);
        } elseif ($helper->isCosmote()) {
            $device = new Cosmote($useragent, $logger);
        } elseif ($helper->isCreative()) {
            $device = new Creative($useragent, $logger);
        } elseif ($helper->isCube()) {
            $device = new Cube($useragent, $logger);
        } elseif ($helper->isCubot()) {
            $device = new Cubot($useragent, $logger);
        } elseif ($helper->isDell()) {
            $device = new Dell($useragent, $logger);
        } elseif ($helper->isDenver()) {
            $device = new Denver($useragent, $logger);
        } elseif ($helper->isDocomo()) {
            $device = new DoCoMo($useragent, $logger);
        } elseif ($helper->isEasypix()) {
            $device = new Easypix($useragent, $logger);
        } elseif ($helper->isEfox()) {
            $device = new Efox($useragent, $logger);
        } elseif ($helper->isEpad()) {
            $device = new Epad($useragent, $logger);
        } elseif ($helper->isFeiteng()) {
            $device = new Feiteng($useragent, $logger);
        } elseif ($helper->isFlytouch()) {
            $device = new Flytouch($useragent, $logger);
        } elseif ($helper->isFujitsu()) {
            $device = new Fujitsu($useragent, $logger);
        } elseif ($helper->isHannspree()) {
            $device = new Hannspree($useragent, $logger);
        } elseif ($helper->isHdc()) {
            $device = new Hdc($useragent, $logger);
        } elseif ($helper->isHiphone()) {
            $device = new HiPhone($useragent, $logger);
        } elseif ($helper->isHonlin()) {
            $device = new Honlin($useragent, $logger);
        } elseif ($helper->isHp()) {
            $device = new Hp($useragent, $logger);
        } elseif ($helper->isHtm()) {
            $device = new Htm($useragent, $logger);
        } elseif ($helper->isIconbit()) {
            $device = new IconBit($useragent, $logger);
        } elseif ($helper->isIntenso()) {
            $device = new Intenso($useragent, $logger);
        } elseif ($helper->isIonik()) {
            $device = new Ionik($useragent, $logger);
        } elseif ($helper->isJaytech()) {
            $device = new Jaytech($useragent, $logger);
        } elseif ($helper->isJolla()) {
            $device = new Jolla($useragent, $logger);
        } elseif ($helper->isKazam()) {
            $device = new Kazam($useragent, $logger);
        } elseif ($helper->isKddi()) {
            $device = new Kddi($useragent, $logger);
        } elseif ($helper->isKeenhigh()) {
            $device = new KeenHigh($useragent, $logger);
        } elseif ($helper->isKobo()) {
            $device = new Kobo($useragent, $logger);
        } elseif ($helper->isLenco()) {
            $device = new Lenco($useragent, $logger);
        } elseif ($helper->isLenovo()) {
            $device = new Lenovo($useragent, $logger);
        } elseif ($helper->isLepan()) {
            $device = new LePan($useragent, $logger);
        } elseif ($helper->isLogikpd()) {
            $device = new Logikpd($useragent, $logger);
        } elseif ($helper->isMedion()) {
            $device = new Medion($useragent, $logger);
        } elseif ($helper->isMeizu()) {
            $device = new Meizu($useragent, $logger);
        } elseif ($helper->isMicromax()) {
            $device = new Micromax($useragent, $logger);
        } elseif ($helper->isMobistel()) {
            $device = new Mobistel($useragent, $logger);
        } elseif ($helper->isNec()) {
            $device = new Nec($useragent, $logger);
        } elseif ($helper->isNeofonia()) {
            $device = new Neofonie($useragent, $logger);
        } elseif ($helper->isNextbook()) {
            $device = new Nextbook($useragent, $logger);
        } elseif ($helper->isNintendo()) {
            $device = new Nintendo($useragent, $logger);
        } elseif ($helper->isOdys()) {
            $device = new Odys($useragent, $logger);
        } elseif ($helper->isOlivetti()) {
            $device = new Olivetti($useragent, $logger);
        } elseif ($helper->isOppo()) {
            $device = new Oppo($useragent, $logger);
        } elseif ($helper->isPanasonic()) {
            $device = new Panasonic($useragent, $logger);
        } elseif ($helper->isPandigital()) {
            $device = new Pandigital($useragent, $logger);
        } elseif ($helper->isPearl()) {
            $device = new Pearl($useragent, $logger);
        } elseif ($helper->isPhicomm()) {
            $device = new Phicomm($useragent, $logger);
        } elseif ($helper->isPipo()) {
            $device = new Pipo($useragent, $logger);
        } elseif ($helper->isPointofview()) {
            $device = new PointOfView($useragent, $logger);
        } elseif ($helper->isPomp()) {
            $device = new Pomp($useragent, $logger);
        } elseif ($helper->isPrestigio()) {
            $device = new Prestigio($useragent, $logger);
        } elseif ($helper->isQmobile()) {
            $device = new Qmobile($useragent, $logger);
        } elseif ($helper->isSanyo()) {
            $device = new Sanyo($useragent, $logger);
        } elseif ($helper->isSharp()) {
            $device = new Sharp($useragent, $logger);
        } elseif ($helper->isSiemens()) {
            $device = new Siemens($useragent, $logger);
        } elseif ($helper->isSimvallay()) {
            $device = new Simvalley($useragent, $logger);
        } elseif ($helper->isSprint()) {
            $device = new Sprint($useragent, $logger);
        } elseif ($helper->isStar()) {
            $device = new Star($useragent, $logger);
        } elseif ($helper->isTechnisat()) {
            $device = new Technisat($useragent, $logger);
        } elseif ($helper->isTexet()) {
            $device = new Texet($useragent, $logger);
        } elseif ($helper->isThl()) {
            $device = new Thl($useragent, $logger);
        } elseif ($helper->isTmobile()) {
            $device = new Tmobile($useragent, $logger);
        } elseif ($helper->isTolino()) {
            $device = new Tolino($useragent, $logger);
        } elseif ($helper->isToshiba()) {
            $device = new Toshiba($useragent, $logger);
        } elseif ($helper->isTrekstor()) {
            $device = new TrekStor($useragent, $logger);
        } elseif ($helper->isTriq()) {
            $device = new TriQ($useragent, $logger);
        } elseif ($helper->isViewsonic()) {
            $device = new ViewSonic($useragent, $logger);
        } elseif ($helper->isWiko()) {
            $device = new Wiko($useragent, $logger);
        } elseif ($helper->isWondermedia()) {
            $device = new WonderMedia($useragent, $logger);
        } elseif ($helper->isXiaomi()) {
            $device = new Xiaomi($useragent, $logger);
        } elseif ($helper->isYuandao()) {
            $device = new Yuandao($useragent, $logger);
        } elseif ($helper->isYusu()) {
            $device = new Yusu($useragent, $logger);
        } elseif ($helper->isZenithink()) {
            $device = new Zenithink($useragent, $logger);
        } elseif ($helper->isZopo()) {
            $device = new Zopo($useragent, $logger);
        } elseif ($helper->isCoolpad()) {
            $device = new Coolpad($useragent, $logger);
        } elseif ($helper->isFaktorZwei()) {
            $device = new FaktorZwei($useragent, $logger);
        } elseif ($helper->isO2()) {
            $device = new O2($useragent, $logger);
        } elseif ($helper->isNvsbl()) {
            $device = new Nvsbl($useragent, $logger);
        } elseif ($helper->isPantech()) {
            $device = new Pantech($useragent, $logger);
        } elseif ($helper->isMemup()) {
            $device = new Memup($useragent, $logger);
        } elseif ($helper->isEinsUndEins()) {
            $device = new EinsUndEins($useragent, $logger);
        } elseif ($helper->isVizio()) {
            $device = new Vizio($useragent, $logger);
        } elseif ($helper->isMiui()) {
            $device = new Miui($useragent, $logger);
        } else {
            $device = new GeneralMobile($useragent, $logger);
        }

        if ($device instanceof DeviceHasChildrenInterface) {
            $device = $device->detectDevice();
        }

        return $device;
    }

    /**
     * @param \WurflCache\Adapter\AdapterInterface $cache
     * @param \Psr\Log\LoggerInterface             $logger
     *
     * @return \UaMatcher\Device\DeviceInterface[]
     */
    private static function getChain(AdapterInterface $cache = null, LoggerInterface $logger = null)
    {
        static $list = null;

        if (null === $list) {
            if (null === $cache) {
                $list = self::buildDeviceChain($logger);
            } else {
                $success = null;
                $list    = $cache->getItem('MobileDeviceChain', $success);

                if (!$success) {
                    $list = self::buildDeviceChain($logger);

                    $cache->setItem('MobileDeviceChain', $list);
                }
            }
        }

        foreach ($list as $browser) {
            yield $browser;
        }
    }

    /**
     * creates the detection chain for browsers
     *
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \UaMatcher\Device\DeviceInterface[]
     */
    private static function buildDeviceChain(LoggerInterface $logger = null)
    {
        $sourceDirectory = __DIR__ . '/../../Device/Mobile/';

        $utils    = new Classname();
        $iterator = new \RecursiveDirectoryIterator($sourceDirectory);
        $list     = array();

        foreach (new \RecursiveIteratorIterator($iterator) as $file) {
            /** @var $file \SplFileInfo */
            if (!$file->isFile() || $file->getExtension() != 'php') {
                continue;
            }

            $className = $utils->getClassNameFromFile(
                $file->getBasename('.php'),
                '\BrowserDetector\Detector\Device\Mobile',
                true
            );

            try {
                /** @var \UaMatcher\Device\DeviceInterface $handler */
                $handler = new $className();
            } catch (\Exception $e) {
                $logger->error(new \Exception('an error occured while creating the device class', 0, $e));

                continue;
            }

            $list[] = $handler;
        }

        $names     = array();
        $companies = array();
        $weights   = array();

        foreach ($list as $key => $entry) {
            /** @var \UaMatcher\Device\DeviceInterface $entry */
            $names[$key]     = $entry->getCapability('device_name');
            $weights[$key]   = $entry->getWeight();
            $companies[$key] = $entry->getManufacturer()->getName();
        }

        array_multisort(
            $weights,
            SORT_DESC,
            SORT_NUMERIC,
            $companies,
            SORT_ASC,
            SORT_NATURAL,
            $names,
            SORT_ASC,
            SORT_NATURAL,
            $list
        );

        return $list;
    }
}
