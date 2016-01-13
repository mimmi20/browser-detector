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
use BrowserDetector\Helper\Classname;
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
     * @return \BrowserDetector\Detector\Device\AbstractDevice
     */
    public static function detect($useragent, LoggerInterface $logger, AdapterInterface $cache = null)
    {
        foreach (self::getChain($cache, $logger) as $device) {
            /** @var \BrowserDetector\Detector\Device\AbstractDevice $device */
            $device->setUserAgent($useragent);

            if ($device->canHandle()) {
                $device->setLogger($logger);

                if ($device instanceof DeviceHasChildrenInterface) {
                    $device = $device->detectDevice();
                }

                return $device;
            }
        }

        return new GeneralMobile($useragent, $logger);
    }

    /**
     * @param \WurflCache\Adapter\AdapterInterface $cache
     * @param \Psr\Log\LoggerInterface             $logger
     *
     * @return \BrowserDetector\Detector\Device\AbstractDevice[]
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

        foreach ($list as $device) {
            yield $device;
        }
    }

    /**
     * creates the detection chain for browsers
     *
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \BrowserDetector\Detector\Device\AbstractDevice[]
     */
    private static function buildDeviceChain(LoggerInterface $logger = null)
    {
        $sourceDirectory = __DIR__ . '/../../Device/Mobile/';

        $utils    = new Classname();
        $iterator = new \DirectoryIterator($sourceDirectory);
        $list     = array();

        foreach ($iterator as $file) {
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
                /** @var \BrowserDetector\Detector\Device\AbstractDevice $handler */
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
            /** @var \BrowserDetector\Detector\Device\AbstractDevice $entry */
            $names[$key]     = $entry->getCapability('code_name');
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
