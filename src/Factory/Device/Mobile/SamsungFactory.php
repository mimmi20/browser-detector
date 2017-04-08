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
namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;
use BrowserDetector\Loader\LoaderInterface;
use Stringy\Stringy;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class SamsungFactory implements Factory\FactoryInterface
{
    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(LoaderInterface $loader)
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
    public function detect($useragent, Stringy $s = null)
    {
        if ($s->contains('sm-a9000', false)) {
            return $this->loader->load('sm-a9000', $useragent);
        }

        if ($s->contains('sm-a800f', false)) {
            return $this->loader->load('sm-a800f', $useragent);
        }

        if ($s->contains('sm-a800y', false)) {
            return $this->loader->load('sm-a800y', $useragent);
        }

        if ($s->contains('sm-a800i', false)) {
            return $this->loader->load('sm-a800i', $useragent);
        }

        if ($s->contains('sm-a8000', false)) {
            return $this->loader->load('sm-a8000', $useragent);
        }

        if ($s->contains('sm-s820l', false)) {
            return $this->loader->load('sm-s820l', $useragent);
        }

        if ($s->contains('sm-a710m', false)) {
            return $this->loader->load('sm-a710m', $useragent);
        }

        if ($s->contains('sm-a710fd', false)) {
            return $this->loader->load('sm-a710fd', $useragent);
        }

        if ($s->contains('sm-a710f', false)) {
            return $this->loader->load('sm-a710f', $useragent);
        }

        if ($s->contains('sm-a7100', false)) {
            return $this->loader->load('sm-a7100', $useragent);
        }

        if ($s->contains('sm-a710y', false)) {
            return $this->loader->load('sm-a710y', $useragent);
        }

        if ($s->contains('sm-a700fd', false)) {
            return $this->loader->load('sm-a700fd', $useragent);
        }

        if ($s->contains('sm-a700f', false)) {
            return $this->loader->load('sm-a700f', $useragent);
        }

        if ($s->contains('sm-a700s', false)) {
            return $this->loader->load('sm-a700s', $useragent);
        }

        if ($s->contains('sm-a700k', false)) {
            return $this->loader->load('sm-a700k', $useragent);
        }

        if ($s->contains('sm-a700l', false)) {
            return $this->loader->load('sm-a700l', $useragent);
        }

        if ($s->contains('sm-a700h', false)) {
            return $this->loader->load('sm-a700h', $useragent);
        }

        if ($s->contains('sm-a700yd', false)) {
            return $this->loader->load('sm-a700yd', $useragent);
        }

        if ($s->contains('sm-a7000', false)) {
            return $this->loader->load('sm-a7000', $useragent);
        }

        if ($s->contains('sm-a7009', false)) {
            return $this->loader->load('sm-a7009', $useragent);
        }

        if ($s->contains('sm-a510fd', false)) {
            return $this->loader->load('sm-a510fd', $useragent);
        }

        if ($s->contains('sm-a510f', false)) {
            return $this->loader->load('sm-a510f', $useragent);
        }

        if ($s->contains('sm-a510m', false)) {
            return $this->loader->load('sm-a510m', $useragent);
        }

        if ($s->contains('sm-a510y', false)) {
            return $this->loader->load('sm-a510y', $useragent);
        }

        if ($s->contains('sm-a5100', false)) {
            return $this->loader->load('sm-a5100', $useragent);
        }

        if ($s->contains('sm-a510s', false)) {
            return $this->loader->load('sm-a510s', $useragent);
        }

        if ($s->contains('sm-a500fu', false)) {
            return $this->loader->load('sm-a500fu', $useragent);
        }

        if ($s->contains('sm-a500f', false)) {
            return $this->loader->load('sm-a500f', $useragent);
        }

        if ($s->contains('sm-a500h', false)) {
            return $this->loader->load('sm-a500h', $useragent);
        }

        if ($s->contains('sm-a500y', false)) {
            return $this->loader->load('sm-a500y', $useragent);
        }

        if ($s->contains('sm-a500l', false)) {
            return $this->loader->load('sm-a500l', $useragent);
        }

        if ($s->contains('sm-a5000', false)) {
            return $this->loader->load('sm-a5000', $useragent);
        }

        if ($s->contains('sm-a310f', false)) {
            return $this->loader->load('sm-a310f', $useragent);
        }

        if ($s->contains('sm-a300fu', false)) {
            return $this->loader->load('sm-a300fu', $useragent);
        }

        if ($s->contains('sm-a300f', false)) {
            return $this->loader->load('sm-a300f', $useragent);
        }

        if ($s->contains('sm-a300h', false)) {
            return $this->loader->load('sm-a300h', $useragent);
        }

        if ($s->contains('sm-j710fn', false)) {
            return $this->loader->load('sm-j710fn', $useragent);
        }

        if ($s->contains('sm-j710f', false)) {
            return $this->loader->load('sm-j710f', $useragent);
        }

        if ($s->contains('sm-j710m', false)) {
            return $this->loader->load('sm-j710m', $useragent);
        }

        if ($s->contains('sm-j710h', false)) {
            return $this->loader->load('sm-j710h', $useragent);
        }

        if ($s->contains('sm-j700f', false)) {
            return $this->loader->load('sm-j700f', $useragent);
        }

        if ($s->contains('sm-j700m', false)) {
            return $this->loader->load('sm-j700m', $useragent);
        }

        if ($s->contains('sm-j700h', false)) {
            return $this->loader->load('sm-j700h', $useragent);
        }

        if ($s->contains('sm-j510fn', false)) {
            return $this->loader->load('sm-j510fn', $useragent);
        }

        if ($s->contains('sm-j510f', false)) {
            return $this->loader->load('sm-j510f', $useragent);
        }

        if ($s->contains('sm-j500fn', false)) {
            return $this->loader->load('sm-j500fn', $useragent);
        }

        if ($s->contains('sm-j500f', false)) {
            return $this->loader->load('sm-j500f', $useragent);
        }

        if ($s->contains('sm-j500g', false)) {
            return $this->loader->load('sm-j500g', $useragent);
        }

        if ($s->contains('sm-j500m', false)) {
            return $this->loader->load('sm-j500m', $useragent);
        }

        if ($s->contains('sm-j500y', false)) {
            return $this->loader->load('sm-j500y', $useragent);
        }

        if ($s->contains('sm-j500h', false)) {
            return $this->loader->load('sm-j500h', $useragent);
        }

        if ($s->contains('sm-j5007', false)) {
            return $this->loader->load('sm-j5007', $useragent);
        }

        if ($s->containsAny(['sm-j500', 'galaxy j5'], false)) {
            return $this->loader->load('sm-j500', $useragent);
        }

        if ($s->contains('sm-j320g', false)) {
            return $this->loader->load('sm-j320g', $useragent);
        }

        if ($s->contains('sm-j320fn', false)) {
            return $this->loader->load('sm-j320fn', $useragent);
        }

        if ($s->contains('sm-j320f', false)) {
            return $this->loader->load('sm-j320f', $useragent);
        }

        if ($s->contains('sm-j3109', false)) {
            return $this->loader->load('sm-j3109', $useragent);
        }

        if ($s->contains('sm-j120fn', false)) {
            return $this->loader->load('sm-j120fn', $useragent);
        }

        if ($s->contains('sm-j120f', false)) {
            return $this->loader->load('sm-j120f', $useragent);
        }

        if ($s->contains('sm-j120g', false)) {
            return $this->loader->load('sm-j120g', $useragent);
        }

        if ($s->contains('sm-j120h', false)) {
            return $this->loader->load('sm-j120h', $useragent);
        }

        if ($s->contains('sm-j120m', false)) {
            return $this->loader->load('sm-j120m', $useragent);
        }

        if ($s->contains('sm-j110f', false)) {
            return $this->loader->load('sm-j110f', $useragent);
        }

        if ($s->contains('sm-j110g', false)) {
            return $this->loader->load('sm-j110g', $useragent);
        }

        if ($s->contains('sm-j110h', false)) {
            return $this->loader->load('sm-j110h', $useragent);
        }

        if ($s->contains('sm-j110l', false)) {
            return $this->loader->load('sm-j110l', $useragent);
        }

        if ($s->contains('sm-j110m', false)) {
            return $this->loader->load('sm-j110m', $useragent);
        }

        if ($s->contains('sm-j111f', false)) {
            return $this->loader->load('sm-j111f', $useragent);
        }

        if ($s->contains('sm-j105h', false)) {
            return $this->loader->load('sm-j105h', $useragent);
        }

        if ($s->contains('sm-j100h', false)) {
            return $this->loader->load('sm-j100h', $useragent);
        }

        if ($s->contains('sm-j100y', false)) {
            return $this->loader->load('sm-j100y', $useragent);
        }

        if ($s->contains('sm-j100f', false)) {
            return $this->loader->load('sm-j100f', $useragent);
        }

        if ($s->contains('sm-j100ml', false)) {
            return $this->loader->load('sm-j100ml', $useragent);
        }

        if ($s->contains('sm-j200gu', false)) {
            return $this->loader->load('sm-j200gu', $useragent);
        }

        if ($s->contains('sm-j200g', false)) {
            return $this->loader->load('sm-j200g', $useragent);
        }

        if ($s->contains('sm-j200f', false)) {
            return $this->loader->load('sm-j200f', $useragent);
        }

        if ($s->contains('sm-j200h', false)) {
            return $this->loader->load('sm-j200h', $useragent);
        }

        if ($s->contains('sm-j200bt', false)) {
            return $this->loader->load('sm-j200bt', $useragent);
        }

        if ($s->contains('sm-j200y', false)) {
            return $this->loader->load('sm-j200y', $useragent);
        }

        if ($s->contains('sm-t280', false)) {
            return $this->loader->load('sm-t280', $useragent);
        }

        if ($s->contains('sm-t2105', false)) {
            return $this->loader->load('sm-t2105', $useragent);
        }

        if ($s->contains('sm-t210r', false)) {
            return $this->loader->load('sm-t210r', $useragent);
        }

        if ($s->contains('sm-t210l', false)) {
            return $this->loader->load('sm-t210l', $useragent);
        }

        if ($s->contains('sm-t210', false)) {
            return $this->loader->load('sm-t210', $useragent);
        }

        if ($s->contains('sm-t900', false)) {
            return $this->loader->load('sm-t900', $useragent);
        }

        if ($s->contains('sm-t819', false)) {
            return $this->loader->load('sm-t819', $useragent);
        }

        if ($s->contains('sm-t815y', false)) {
            return $this->loader->load('sm-t815y', $useragent);
        }

        if ($s->contains('sm-t815', false)) {
            return $this->loader->load('sm-t815', $useragent);
        }

        if ($s->contains('sm-t813', false)) {
            return $this->loader->load('sm-t813', $useragent);
        }

        if ($s->contains('sm-t810x', false)) {
            return $this->loader->load('sm-t810x', $useragent);
        }

        if ($s->contains('sm-t810', false)) {
            return $this->loader->load('sm-t810', $useragent);
        }

        if ($s->contains('sm-t805', false)) {
            return $this->loader->load('sm-t805', $useragent);
        }

        if ($s->contains('sm-t800', false)) {
            return $this->loader->load('sm-t800', $useragent);
        }

        if ($s->contains('sm-t719', false)) {
            return $this->loader->load('sm-t719', $useragent);
        }

        if ($s->contains('sm-t715', false)) {
            return $this->loader->load('sm-t715', $useragent);
        }

        if ($s->contains('sm-t713', false)) {
            return $this->loader->load('sm-t713', $useragent);
        }

        if ($s->contains('sm-t710', false)) {
            return $this->loader->load('sm-t710', $useragent);
        }

        if ($s->contains('sm-t705m', false)) {
            return $this->loader->load('sm-t705m', $useragent);
        }

        if ($s->contains('sm-t705', false)) {
            return $this->loader->load('sm-t705', $useragent);
        }

        if ($s->contains('sm-t700', false)) {
            return $this->loader->load('sm-t700', $useragent);
        }

        if ($s->contains('sm-t670', false)) {
            return $this->loader->load('sm-t670', $useragent);
        }

        if ($s->contains('sm-t585', false)) {
            return $this->loader->load('sm-t585', $useragent);
        }

        if ($s->contains('sm-t580', false)) {
            return $this->loader->load('sm-t580', $useragent);
        }

        if ($s->contains('sm-t550x', false)) {
            return $this->loader->load('sm-t550x', $useragent);
        }

        if ($s->contains('sm-t550', false)) {
            return $this->loader->load('sm-t550', $useragent);
        }

        if ($s->contains('sm-t555', false)) {
            return $this->loader->load('sm-t555', $useragent);
        }

        if ($s->contains('sm-t561', false)) {
            return $this->loader->load('sm-t561', $useragent);
        }

        if ($s->contains('sm-t560', false)) {
            return $this->loader->load('sm-t560', $useragent);
        }

        if ($s->contains('sm-t535', false)) {
            return $this->loader->load('sm-t535', $useragent);
        }

        if ($s->contains('sm-t533', false)) {
            return $this->loader->load('sm-t533', $useragent);
        }

        if ($s->containsAny(['sm-t531', 'sm - t531'], false)) {
            return $this->loader->load('sm-t531', $useragent);
        }

        if ($s->contains('sm-t530nu', false)) {
            return $this->loader->load('sm-t530nu', $useragent);
        }

        if ($s->contains('sm-t530', false)) {
            return $this->loader->load('sm-t530', $useragent);
        }

        if ($s->contains('sm-t525', false)) {
            return $this->loader->load('sm-t525', $useragent);
        }

        if ($s->contains('sm-t520', false)) {
            return $this->loader->load('sm-t520', $useragent);
        }

        if ($s->contains('sm-t365', false)) {
            return $this->loader->load('sm-t365', $useragent);
        }

        if ($s->contains('sm-t355y', false)) {
            return $this->loader->load('sm-t355y', $useragent);
        }

        if ($s->contains('sm-t350', false)) {
            return $this->loader->load('sm-t350', $useragent);
        }

        if ($s->contains('sm-t335', false)) {
            return $this->loader->load('sm-t335', $useragent);
        }

        if ($s->contains('sm-t331', false)) {
            return $this->loader->load('sm-t331', $useragent);
        }

        if ($s->contains('sm-t330', false)) {
            return $this->loader->load('sm-t330', $useragent);
        }

        if ($s->contains('sm-t325', false)) {
            return $this->loader->load('sm-t325', $useragent);
        }

        if ($s->contains('sm-t320', false)) {
            return $this->loader->load('sm-t320', $useragent);
        }

        if ($s->contains('sm-t315', false)) {
            return $this->loader->load('sm-t315', $useragent);
        }

        if ($s->contains('sm-t311', false)) {
            return $this->loader->load('sm-t311', $useragent);
        }

        if ($s->contains('sm-t310', false)) {
            return $this->loader->load('sm-t310', $useragent);
        }

        if ($s->contains('sm-t235', false)) {
            return $this->loader->load('sm-t235', $useragent);
        }

        if ($s->contains('sm-t231', false)) {
            return $this->loader->load('sm-t231', $useragent);
        }

        if ($s->contains('sm-t230nu', false)) {
            return $this->loader->load('sm-t230nu', $useragent);
        }

        if ($s->contains('sm-t230', false)) {
            return $this->loader->load('sm-t230', $useragent);
        }

        if ($s->contains('sm-t211', false)) {
            return $this->loader->load('sm-t211', $useragent);
        }

        if ($s->contains('sm-t116', false)) {
            return $this->loader->load('sm-t116', $useragent);
        }

        if ($s->contains('sm-t113', false)) {
            return $this->loader->load('sm-t113', $useragent);
        }

        if ($s->contains('sm-t111', false)) {
            return $this->loader->load('sm-t111', $useragent);
        }

        if ($s->contains('sm-t110', false)) {
            return $this->loader->load('sm-t110', $useragent);
        }

        if ($s->contains('sm-p907a', false)) {
            return $this->loader->load('sm-p907a', $useragent);
        }

        if ($s->contains('sm-p905m', false)) {
            return $this->loader->load('sm-p905m', $useragent);
        }

        if ($s->contains('sm-p905v', false)) {
            return $this->loader->load('sm-p905v', $useragent);
        }

        if ($s->contains('sm-p905', false)) {
            return $this->loader->load('sm-p905', $useragent);
        }

        if ($s->contains('sm-p901', false)) {
            return $this->loader->load('sm-p901', $useragent);
        }

        if ($s->contains('sm-p900', false)) {
            return $this->loader->load('sm-p900', $useragent);
        }

        if ($s->contains('sm-p605', false)) {
            return $this->loader->load('sm-p605', $useragent);
        }

        if ($s->contains('sm-p601', false)) {
            return $this->loader->load('sm-p601', $useragent);
        }

        if ($s->contains('sm-p600', false)) {
            return $this->loader->load('sm-p600', $useragent);
        }

        if ($s->contains('sm-p550', false)) {
            return $this->loader->load('sm-p550', $useragent);
        }

        if ($s->contains('sm-p355', false)) {
            return $this->loader->load('sm-p355', $useragent);
        }

        if ($s->contains('sm-p350', false)) {
            return $this->loader->load('sm-p350', $useragent);
        }

        if ($s->contains('sm-n930fd', false)) {
            return $this->loader->load('sm-n930fd', $useragent);
        }

        if ($s->contains('sm-n930f', false)) {
            return $this->loader->load('sm-n930f', $useragent);
        }

        if ($s->contains('sm-n930w8', false)) {
            return $this->loader->load('sm-n930w8', $useragent);
        }

        if ($s->contains('sm-n9300', false)) {
            return $this->loader->load('sm-n9300', $useragent);
        }

        if ($s->contains('sm-n9308', false)) {
            return $this->loader->load('sm-n9308', $useragent);
        }

        if ($s->contains('sm-n930k', false)) {
            return $this->loader->load('sm-n930k', $useragent);
        }

        if ($s->contains('sm-n930l', false)) {
            return $this->loader->load('sm-n930l', $useragent);
        }

        if ($s->contains('sm-n930s', false)) {
            return $this->loader->load('sm-n930s', $useragent);
        }

        if ($s->contains('sm-n930az', false)) {
            return $this->loader->load('sm-n930az', $useragent);
        }

        if ($s->contains('sm-n930a', false)) {
            return $this->loader->load('sm-n930a', $useragent);
        }

        if ($s->contains('sm-n930t1', false)) {
            return $this->loader->load('sm-n930t1', $useragent);
        }

        if ($s->contains('sm-n930t', false)) {
            return $this->loader->load('sm-n930t', $useragent);
        }

        if ($s->contains('sm-n930r6', false)) {
            return $this->loader->load('sm-n930r6', $useragent);
        }

        if ($s->contains('sm-n930r7', false)) {
            return $this->loader->load('sm-n930r7', $useragent);
        }

        if ($s->contains('sm-n930r4', false)) {
            return $this->loader->load('sm-n930r4', $useragent);
        }

        if ($s->contains('sm-n930p', false)) {
            return $this->loader->load('sm-n930p', $useragent);
        }

        if ($s->contains('sm-n930v', false)) {
            return $this->loader->load('sm-n930v', $useragent);
        }

        if ($s->contains('sm-n930u', false)) {
            return $this->loader->load('sm-n930u', $useragent);
        }

        if ($s->contains('sm-n920a', false)) {
            return $this->loader->load('sm-n920a', $useragent);
        }

        if ($s->contains('sm-n920r', false)) {
            return $this->loader->load('sm-n920r', $useragent);
        }

        if ($s->contains('sm-n920s', false)) {
            return $this->loader->load('sm-n920s', $useragent);
        }

        if ($s->contains('sm-n920k', false)) {
            return $this->loader->load('sm-n920k', $useragent);
        }

        if ($s->contains('sm-n920l', false)) {
            return $this->loader->load('sm-n920l', $useragent);
        }

        if ($s->contains('sm-n920g', false)) {
            return $this->loader->load('sm-n920g', $useragent);
        }

        if ($s->contains('sm-n920c', false)) {
            return $this->loader->load('sm-n920c', $useragent);
        }

        if ($s->contains('sm-n920v', false)) {
            return $this->loader->load('sm-n920v', $useragent);
        }

        if ($s->contains('sm-n920t', false)) {
            return $this->loader->load('sm-n920t', $useragent);
        }

        if ($s->contains('sm-n920p', false)) {
            return $this->loader->load('sm-n920p', $useragent);
        }

        if ($s->contains('sm-n920a', false)) {
            return $this->loader->load('sm-n920a', $useragent);
        }

        if ($s->contains('sm-n920i', false)) {
            return $this->loader->load('sm-n920i', $useragent);
        }

        if ($s->contains('sm-n920w8', false)) {
            return $this->loader->load('sm-n920w8', $useragent);
        }

        if ($s->contains('sm-n9200', false)) {
            return $this->loader->load('sm-n9200', $useragent);
        }

        if ($s->contains('sm-n9208', false)) {
            return $this->loader->load('sm-n9208', $useragent);
        }

        if ($s->containsAny(['sm-n9009', 'n9009'], false)) {
            return $this->loader->load('sm-n9009', $useragent);
        }

        if ($s->contains('sm-n9008v', false)) {
            return $this->loader->load('sm-n9008v', $useragent);
        }

        if ($s->containsAny(['sm-n9007', 'N9007'], false)) {
            return $this->loader->load('sm-n9007', $useragent);
        }

        if ($s->containsAny(['sm-n9006', 'n9006'], false)) {
            return $this->loader->load('sm-n9006', $useragent);
        }

        if ($s->containsAny(['sm-n9005', 'n9005'], false)) {
            return $this->loader->load('sm-n9005', $useragent);
        }

        if ($s->containsAny(['sm-n9002', 'n9002'], false)) {
            return $this->loader->load('sm-n9002', $useragent);
        }

        if ($s->contains('sm-n8000', false)) {
            return $this->loader->load('sm-n8000', $useragent);
        }

        if ($s->contains('sm-n7505l', false)) {
            return $this->loader->load('sm-n7505l', $useragent);
        }

        if ($s->contains('sm-n7505', false)) {
            return $this->loader->load('sm-n7505', $useragent);
        }

        if ($s->contains('sm-n7502', false)) {
            return $this->loader->load('sm-n7502', $useragent);
        }

        if ($s->contains('sm-n7500q', false)) {
            return $this->loader->load('sm-n7500q', $useragent);
        }

        if ($s->contains('sm-n750', false)) {
            return $this->loader->load('sm-n750', $useragent);
        }

        if ($s->contains('sm-n916s', false)) {
            return $this->loader->load('sm-n916s', $useragent);
        }

        if ($s->contains('sm-n915fy', false)) {
            return $this->loader->load('sm-n915fy', $useragent);
        }

        if ($s->contains('sm-n915f', false)) {
            return $this->loader->load('sm-n915f', $useragent);
        }

        if ($s->contains('sm-n915t', false)) {
            return $this->loader->load('sm-n915t', $useragent);
        }

        if ($s->contains('sm-n915g', false)) {
            return $this->loader->load('sm-n915g', $useragent);
        }

        if ($s->contains('sm-n915p', false)) {
            return $this->loader->load('sm-n915p', $useragent);
        }

        if ($s->contains('sm-n915a', false)) {
            return $this->loader->load('sm-n915a', $useragent);
        }

        if ($s->contains('sm-n915v', false)) {
            return $this->loader->load('sm-n915v', $useragent);
        }

        if ($s->contains('sm-n915d', false)) {
            return $this->loader->load('sm-n915d', $useragent);
        }

        if ($s->contains('sm-n915k', false)) {
            return $this->loader->load('sm-n915k', $useragent);
        }

        if ($s->contains('sm-n915l', false)) {
            return $this->loader->load('sm-n915l', $useragent);
        }

        if ($s->contains('sm-n915s', false)) {
            return $this->loader->load('sm-n915s', $useragent);
        }

        if ($s->contains('sm-n9150', false)) {
            return $this->loader->load('sm-n9150', $useragent);
        }

        if ($s->contains('sm-n910v', false)) {
            return $this->loader->load('sm-n910v', $useragent);
        }

        if ($s->contains('sm-n910fq', false)) {
            return $this->loader->load('sm-n910fq', $useragent);
        }

        if ($s->contains('sm-n910fd', false)) {
            return $this->loader->load('sm-n910fd', $useragent);
        }

        if ($s->contains('sm-n910f', false)) {
            return $this->loader->load('sm-n910f', $useragent);
        }

        if ($s->contains('sm-n910c', false)) {
            return $this->loader->load('sm-n910c', $useragent);
        }

        if ($s->contains('sm-n910a', false)) {
            return $this->loader->load('sm-n910a', $useragent);
        }

        if ($s->contains('sm-n910h', false)) {
            return $this->loader->load('sm-n910h', $useragent);
        }

        if ($s->contains('sm-n910k', false)) {
            return $this->loader->load('sm-n910k', $useragent);
        }

        if ($s->contains('sm-n910p', false)) {
            return $this->loader->load('sm-n910p', $useragent);
        }

        if ($s->contains('sm-n910x', false)) {
            return $this->loader->load('sm-n910x', $useragent);
        }

        if ($s->contains('sm-n910s', false)) {
            return $this->loader->load('sm-n910s', $useragent);
        }

        if ($s->contains('sm-n910l', false)) {
            return $this->loader->load('sm-n910l', $useragent);
        }

        if ($s->contains('sm-n910g', false)) {
            return $this->loader->load('sm-n910g', $useragent);
        }

        if ($s->contains('sm-n910m', false)) {
            return $this->loader->load('sm-n910m', $useragent);
        }

        if ($s->contains('sm-n910t1', false)) {
            return $this->loader->load('sm-n910t1', $useragent);
        }

        if ($s->contains('sm-n910t3', false)) {
            return $this->loader->load('sm-n910t3', $useragent);
        }

        if ($s->contains('sm-n910t', false)) {
            return $this->loader->load('sm-n910t', $useragent);
        }

        if ($s->contains('sm-n910u', false)) {
            return $this->loader->load('sm-n910u', $useragent);
        }

        if ($s->contains('sm-n910r4', false)) {
            return $this->loader->load('sm-n910r4', $useragent);
        }

        if ($s->contains('sm-n910w8', false)) {
            return $this->loader->load('sm-n910w8', $useragent);
        }

        if ($s->contains('sm-n9100h', false)) {
            return $this->loader->load('sm-n9100h', $useragent);
        }

        if ($s->contains('sm-n9100', false)) {
            return $this->loader->load('sm-n9100', $useragent);
        }

        if ($s->contains('sm-n900v', false)) {
            return $this->loader->load('sm-n900v', $useragent);
        }

        if ($s->contains('sm-n900a', false)) {
            return $this->loader->load('sm-n900a', $useragent);
        }

        if ($s->contains('sm-n900s', false)) {
            return $this->loader->load('sm-n900s', $useragent);
        }

        if ($s->contains('sm-n900t', false)) {
            return $this->loader->load('sm-n900t', $useragent);
        }

        if ($s->contains('sm-n900p', false)) {
            return $this->loader->load('sm-n900p', $useragent);
        }

        if ($s->contains('sm-n900l', false)) {
            return $this->loader->load('sm-n900l', $useragent);
        }

        if ($s->contains('sm-n900k', false)) {
            return $this->loader->load('sm-n900k', $useragent);
        }

        if ($s->contains('sm-n9000q', false)) {
            return $this->loader->load('sm-n9000q', $useragent);
        }

        if ($s->contains('sm-n900w8', false)) {
            return $this->loader->load('sm-n900w8', $useragent);
        }

        if ($s->contains('sm-n900', false)) {
            return $this->loader->load('sm-n900', $useragent);
        }

        if ($s->contains('sm-g935fd', false)) {
            return $this->loader->load('sm-g935fd', $useragent);
        }

        if ($s->contains('sm-g935f', false)) {
            return $this->loader->load('sm-g935f', $useragent);
        }

        if ($s->contains('sm-g935a', false)) {
            return $this->loader->load('sm-g935a', $useragent);
        }

        if ($s->contains('sm-g935p', false)) {
            return $this->loader->load('sm-g935p', $useragent);
        }

        if ($s->contains('sm-g935r', false)) {
            return $this->loader->load('sm-g935r', $useragent);
        }

        if ($s->contains('sm-g935t', false)) {
            return $this->loader->load('sm-g935t', $useragent);
        }

        if ($s->contains('sm-g935v', false)) {
            return $this->loader->load('sm-g935v', $useragent);
        }

        if ($s->contains('sm-g935w8', false)) {
            return $this->loader->load('sm-g935w8', $useragent);
        }

        if ($s->contains('sm-g935k', false)) {
            return $this->loader->load('sm-g935k', $useragent);
        }

        if ($s->contains('sm-g935l', false)) {
            return $this->loader->load('sm-g935l', $useragent);
        }

        if ($s->contains('sm-g935s', false)) {
            return $this->loader->load('sm-g935s', $useragent);
        }

        if ($s->contains('sm-g935x', false)) {
            return $this->loader->load('sm-g935x', $useragent);
        }

        if ($s->contains('sm-g9350', false)) {
            return $this->loader->load('sm-g9350', $useragent);
        }

        if ($s->contains('sm-g930fd', false)) {
            return $this->loader->load('sm-g930fd', $useragent);
        }

        if ($s->contains('sm-g930f', false)) {
            return $this->loader->load('sm-g930f', $useragent);
        }

        if ($s->contains('sm-g9308', false)) {
            return $this->loader->load('sm-g9308', $useragent);
        }

        if ($s->contains('sm-g930a', false)) {
            return $this->loader->load('sm-g930a', $useragent);
        }

        if ($s->contains('sm-g930p', false)) {
            return $this->loader->load('sm-g930p', $useragent);
        }

        if ($s->contains('sm-g930v', false)) {
            return $this->loader->load('sm-g930v', $useragent);
        }

        if ($s->contains('sm-g930r', false)) {
            return $this->loader->load('sm-g930r', $useragent);
        }

        if ($s->contains('sm-g930t', false)) {
            return $this->loader->load('sm-g930t', $useragent);
        }

        if ($s->contains('sm-g930', false)) {
            return $this->loader->load('sm-g930', $useragent);
        }

        if ($s->contains('sm-g9006v', false)) {
            return $this->loader->load('sm-g9006v', $useragent);
        }

        if ($s->contains('sm-g928f', false)) {
            return $this->loader->load('sm-g928f', $useragent);
        }

        if ($s->contains('sm-g928v', false)) {
            return $this->loader->load('sm-g928v', $useragent);
        }

        if ($s->contains('sm-g928w8', false)) {
            return $this->loader->load('sm-g928w8', $useragent);
        }

        if ($s->contains('sm-g928c', false)) {
            return $this->loader->load('sm-g928c', $useragent);
        }

        if ($s->contains('sm-g928g', false)) {
            return $this->loader->load('sm-g928g', $useragent);
        }

        if ($s->contains('sm-g928p', false)) {
            return $this->loader->load('sm-g928p', $useragent);
        }

        if ($s->contains('sm-g928i', false)) {
            return $this->loader->load('sm-g928i', $useragent);
        }

        if ($s->contains('sm-g9287', false)) {
            return $this->loader->load('sm-g9287', $useragent);
        }

        if ($s->contains('sm-g925f', false)) {
            return $this->loader->load('sm-g925f', $useragent);
        }

        if ($s->contains('sm-g925t', false)) {
            return $this->loader->load('sm-g925t', $useragent);
        }

        if ($s->contains('sm-g925r4', false)) {
            return $this->loader->load('sm-g925r4', $useragent);
        }

        if ($s->contains('sm-g925i', false)) {
            return $this->loader->load('sm-g925i', $useragent);
        }

        if ($s->contains('sm-g925p', false)) {
            return $this->loader->load('sm-g925p', $useragent);
        }

        if ($s->contains('sm-g925k', false)) {
            return $this->loader->load('sm-g925k', $useragent);
        }

        if ($s->contains('sm-g920k', false)) {
            return $this->loader->load('sm-g920k', $useragent);
        }

        if ($s->contains('sm-g920l', false)) {
            return $this->loader->load('sm-g920l', $useragent);
        }

        if ($s->contains('sm-g920p', false)) {
            return $this->loader->load('sm-g920p', $useragent);
        }

        if ($s->contains('sm-g920v', false)) {
            return $this->loader->load('sm-g920v', $useragent);
        }

        if ($s->contains('sm-g920t1', false)) {
            return $this->loader->load('sm-g920t1', $useragent);
        }

        if ($s->contains('sm-g920t', false)) {
            return $this->loader->load('sm-g920t', $useragent);
        }

        if ($s->contains('sm-g920a', false)) {
            return $this->loader->load('sm-g920a', $useragent);
        }

        if ($s->contains('sm-g920fd', false)) {
            return $this->loader->load('sm-g920fd', $useragent);
        }

        if ($s->contains('sm-g920f', false)) {
            return $this->loader->load('sm-g920f', $useragent);
        }

        if ($s->contains('sm-g920i', false)) {
            return $this->loader->load('sm-g920i', $useragent);
        }

        if ($s->contains('sm-g920s', false)) {
            return $this->loader->load('sm-g920s', $useragent);
        }

        if ($s->contains('sm-g9200', false)) {
            return $this->loader->load('sm-g9200', $useragent);
        }

        if ($s->contains('sm-g9208', false)) {
            return $this->loader->load('sm-g9208', $useragent);
        }

        if ($s->contains('sm-g9209', false)) {
            return $this->loader->load('sm-g9209', $useragent);
        }

        if ($s->contains('sm-g920r', false)) {
            return $this->loader->load('sm-g920r', $useragent);
        }

        if ($s->contains('sm-g920w8', false)) {
            return $this->loader->load('sm-g920w8', $useragent);
        }

        if ($s->contains('sm-g903f', false)) {
            return $this->loader->load('sm-g903f', $useragent);
        }

        if ($s->contains('sm-g901f', false)) {
            return $this->loader->load('sm-g901f', $useragent);
        }

        if ($s->contains('sm-g900w8', false)) {
            return $this->loader->load('sm-g900w8', $useragent);
        }

        if ($s->contains('sm-g900v', false)) {
            return $this->loader->load('sm-g900v', $useragent);
        }

        if ($s->contains('sm-g900t', false)) {
            return $this->loader->load('sm-g900t', $useragent);
        }

        if ($s->contains('sm-g900i', false)) {
            return $this->loader->load('sm-g900i', $useragent);
        }

        if ($s->contains('sm-g900f', false)) {
            return $this->loader->load('sm-g900f', $useragent);
        }

        if ($s->contains('sm-g900a', false)) {
            return $this->loader->load('sm-g900a', $useragent);
        }

        if ($s->contains('sm-g900h', false)) {
            return $this->loader->load('sm-g900h', $useragent);
        }

        if ($s->contains('sm-g900', false)) {
            return $this->loader->load('sm-g900', $useragent);
        }

        if ($s->contains('sm-g890a', false)) {
            return $this->loader->load('sm-g890a', $useragent);
        }

        if ($s->contains('sm-g870f', false)) {
            return $this->loader->load('sm-g870f', $useragent);
        }

        if ($s->contains('sm-g870a', false)) {
            return $this->loader->load('sm-g870a', $useragent);
        }

        if ($s->contains('sm-g850fq', false)) {
            return $this->loader->load('sm-g850fq', $useragent);
        }

        if ($s->containsAny(['sm-g850f', 'galaxy alpha'], false)) {
            return $this->loader->load('sm-g850f', $useragent);
        }

        if ($s->contains('sm-g850a', false)) {
            return $this->loader->load('sm-g850a', $useragent);
        }

        if ($s->contains('sm-g850m', false)) {
            return $this->loader->load('sm-g850m', $useragent);
        }

        if ($s->contains('sm-g850t', false)) {
            return $this->loader->load('sm-g850t', $useragent);
        }

        if ($s->contains('sm-g850w', false)) {
            return $this->loader->load('sm-g850w', $useragent);
        }

        if ($s->contains('sm-g850y', false)) {
            return $this->loader->load('sm-g850y', $useragent);
        }

        if ($s->contains('sm-g800hq', false)) {
            return $this->loader->load('sm-g800hq', $useragent);
        }

        if ($s->contains('sm-g800h', false)) {
            return $this->loader->load('sm-g800h', $useragent);
        }

        if ($s->contains('sm-g800f', false)) {
            return $this->loader->load('sm-g800f', $useragent);
        }

        if ($s->contains('sm-g800m', false)) {
            return $this->loader->load('sm-g800m', $useragent);
        }

        if ($s->contains('sm-g800a', false)) {
            return $this->loader->load('sm-g800a', $useragent);
        }

        if ($s->contains('sm-g800r4', false)) {
            return $this->loader->load('sm-g800r4', $useragent);
        }

        if ($s->contains('sm-g800y', false)) {
            return $this->loader->load('sm-g800y', $useragent);
        }

        if ($s->contains('sm-g720n0', false)) {
            return $this->loader->load('sm-g720n0', $useragent);
        }

        if ($s->contains('sm-g720d', false)) {
            return $this->loader->load('sm-g720d', $useragent);
        }

        if ($s->contains('sm-g7202', false)) {
            return $this->loader->load('sm-g7202', $useragent);
        }

        if ($s->contains('sm-g7102t', false)) {
            return $this->loader->load('sm-g7102t', $useragent);
        }

        if ($s->contains('sm-g7102', false)) {
            return $this->loader->load('sm-g7102', $useragent);
        }

        if ($s->contains('sm-g7105l', false)) {
            return $this->loader->load('sm-g7105l', $useragent);
        }

        if ($s->contains('sm-g7105', false)) {
            return $this->loader->load('sm-g7105', $useragent);
        }

        if ($s->contains('sm-g7106', false)) {
            return $this->loader->load('sm-g7106', $useragent);
        }

        if ($s->contains('sm-g7108v', false)) {
            return $this->loader->load('sm-g7108v', $useragent);
        }

        if ($s->contains('sm-g7108', false)) {
            return $this->loader->load('sm-g7108', $useragent);
        }

        if ($s->contains('sm-g7109', false)) {
            return $this->loader->load('sm-g7109', $useragent);
        }

        if ($s->contains('sm-g710l', false)) {
            return $this->loader->load('sm-g710l', $useragent);
        }

        if ($s->contains('sm-g710', false)) {
            return $this->loader->load('sm-g710', $useragent);
        }

        if ($s->contains('sm-g531f', false)) {
            return $this->loader->load('sm-g531f', $useragent);
        }

        if ($s->contains('sm-g531h', false)) {
            return $this->loader->load('sm-g531h', $useragent);
        }

        if ($s->contains('sm-g530t', false)) {
            return $this->loader->load('sm-g530t', $useragent);
        }

        if ($s->contains('sm-g530h', false)) {
            return $this->loader->load('sm-g530h', $useragent);
        }

        if ($s->contains('sm-g530fz', false)) {
            return $this->loader->load('sm-g530fz', $useragent);
        }

        if ($s->contains('sm-g530f', false)) {
            return $this->loader->load('sm-g530f', $useragent);
        }

        if ($s->contains('sm-g530y', false)) {
            return $this->loader->load('sm-g530y', $useragent);
        }

        if ($s->contains('sm-g530m', false)) {
            return $this->loader->load('sm-g530m', $useragent);
        }

        if ($s->contains('sm-g530bt', false)) {
            return $this->loader->load('sm-g530bt', $useragent);
        }

        if ($s->contains('sm-g5306w', false)) {
            return $this->loader->load('sm-g5306w', $useragent);
        }

        if ($s->contains('sm-g5308w', false)) {
            return $this->loader->load('sm-g5308w', $useragent);
        }

        if ($s->contains('sm-g389f', false)) {
            return $this->loader->load('sm-g389f', $useragent);
        }

        if ($s->contains('sm-g3815', false)) {
            return $this->loader->load('sm-g3815', $useragent);
        }

        if ($s->contains('sm-g388f', false)) {
            return $this->loader->load('sm-g388f', $useragent);
        }

        if ($s->contains('sm-g386f', false)) {
            return $this->loader->load('sm-g386f', $useragent);
        }

        if ($s->contains('sm-g361f', false)) {
            return $this->loader->load('sm-g361f', $useragent);
        }

        if ($s->contains('sm-g361h', false)) {
            return $this->loader->load('sm-g361h', $useragent);
        }

        if ($s->contains('sm-g360hu', false)) {
            return $this->loader->load('sm-g360hu', $useragent);
        }

        if ($s->contains('sm-g360h', false)) {
            return $this->loader->load('sm-g360h', $useragent);
        }

        if ($s->contains('sm-g360t1', false)) {
            return $this->loader->load('sm-g360t1', $useragent);
        }

        if ($s->contains('sm-g360t', false)) {
            return $this->loader->load('sm-g360t', $useragent);
        }

        if ($s->contains('sm-g360bt', false)) {
            return $this->loader->load('sm-g360bt', $useragent);
        }

        if ($s->contains('sm-g360f', false)) {
            return $this->loader->load('sm-g360f', $useragent);
        }

        if ($s->contains('sm-g360g', false)) {
            return $this->loader->load('sm-g360g', $useragent);
        }

        if ($s->contains('sm-g360az', false)) {
            return $this->loader->load('sm-g360az', $useragent);
        }

        if ($s->contains('sm-g357fz', false)) {
            return $this->loader->load('sm-g357fz', $useragent);
        }

        if ($s->contains('sm-g355hq', false)) {
            return $this->loader->load('sm-g355hq', $useragent);
        }

        if ($s->contains('sm-g355hn', false)) {
            return $this->loader->load('sm-g355hn', $useragent);
        }

        if ($s->contains('sm-g355h', false)) {
            return $this->loader->load('sm-g355h', $useragent);
        }

        if ($s->contains('sm-g355m', false)) {
            return $this->loader->load('sm-g355m', $useragent);
        }

        if ($s->contains('sm-g3502l', false)) {
            return $this->loader->load('sm-g3502l', $useragent);
        }

        if ($s->contains('sm-g3502t', false)) {
            return $this->loader->load('sm-g3502t', $useragent);
        }

        if ($s->contains('sm-g3500', false)) {
            return $this->loader->load('sm-g3500', $useragent);
        }

        if ($s->contains('sm-g350e', false)) {
            return $this->loader->load('sm-g350e', $useragent);
        }

        if ($s->contains('sm-g350', false)) {
            return $this->loader->load('sm-g350', $useragent);
        }

        if ($s->contains('sm-g318h', false)) {
            return $this->loader->load('sm-g318h', $useragent);
        }

        if ($s->contains('sm-g313hu', false)) {
            return $this->loader->load('sm-g313hu', $useragent);
        }

        if ($s->contains('sm-g313hn', false)) {
            return $this->loader->load('sm-g313hn', $useragent);
        }

        if ($s->contains('sm-g310hn', false)) {
            return $this->loader->load('sm-g310hn', $useragent);
        }

        if ($s->contains('sm-g130h', false)) {
            return $this->loader->load('sm-g130h', $useragent);
        }

        if ($s->contains('sm-g110h', false)) {
            return $this->loader->load('sm-g110h', $useragent);
        }

        if ($s->contains('sm-e700f', false)) {
            return $this->loader->load('sm-e700f', $useragent);
        }

        if ($s->contains('sm-e700h', false)) {
            return $this->loader->load('sm-e700h', $useragent);
        }

        if ($s->contains('sm-e700m', false)) {
            return $this->loader->load('sm-e700m', $useragent);
        }

        if ($s->contains('sm-e7000', false)) {
            return $this->loader->load('sm-e7000', $useragent);
        }

        if ($s->contains('sm-e7009', false)) {
            return $this->loader->load('sm-e7009', $useragent);
        }

        if ($s->contains('sm-e500h', false)) {
            return $this->loader->load('sm-e500h', $useragent);
        }

        if ($s->contains('sm-c115', false)) {
            return $this->loader->load('sm-c115', $useragent);
        }

        if ($s->contains('sm-c111', false)) {
            return $this->loader->load('sm-c111', $useragent);
        }

        if ($s->contains('sm-c105', false)) {
            return $this->loader->load('sm-c105', $useragent);
        }

        if ($s->contains('sm-c101', false)) {
            return $this->loader->load('sm-c101', $useragent);
        }

        if ($s->contains('sm-z130h', false)) {
            return $this->loader->load('sm-z130h', $useragent);
        }

        if ($s->contains('sm-b550h', false)) {
            return $this->loader->load('sm-b550h', $useragent);
        }

        if ($s->contains('sgh-t999', false)) {
            return $this->loader->load('sgh-t999', $useragent);
        }

        if ($s->contains('sgh-t989d', false)) {
            return $this->loader->load('sgh-t989d', $useragent);
        }

        if ($s->contains('sgh-t989', false)) {
            return $this->loader->load('sgh-t989', $useragent);
        }

        if ($s->contains('sgh-t959v', false)) {
            return $this->loader->load('sgh-t959v', $useragent);
        }

        if ($s->contains('sgh-t959', false)) {
            return $this->loader->load('sgh-t959', $useragent);
        }

        if ($s->contains('sgh-t899m', false)) {
            return $this->loader->load('sgh-t899m', $useragent);
        }

        if ($s->contains('sgh-t889', false)) {
            return $this->loader->load('sgh-t889', $useragent);
        }

        if ($s->contains('sgh-t859', false)) {
            return $this->loader->load('sgh-t859', $useragent);
        }

        if ($s->contains('sgh-t839', false)) {
            return $this->loader->load('sgh-t839', $useragent);
        }

        if ($s->containsAny(['sgh-t769', 'blaze'], false)) {
            return $this->loader->load('sgh-t769', $useragent);
        }

        if ($s->contains('sgh-t759', false)) {
            return $this->loader->load('sgh-t759', $useragent);
        }

        if ($s->contains('sgh-t669', false)) {
            return $this->loader->load('sgh-t669', $useragent);
        }

        if ($s->contains('sgh-t528g', false)) {
            return $this->loader->load('sgh-t528g', $useragent);
        }

        if ($s->contains('sgh-t499', false)) {
            return $this->loader->load('sgh-t499', $useragent);
        }

        if ($s->contains('sgh-m919', false)) {
            return $this->loader->load('sgh-m919', $useragent);
        }

        if ($s->contains('sgh-i997r', false)) {
            return $this->loader->load('sgh-i997r', $useragent);
        }

        if ($s->contains('sgh-i997', false)) {
            return $this->loader->load('sgh-i997', $useragent);
        }

        if ($s->contains('SGH-I957R', false)) {
            return $this->loader->load('sgh-i957r', $useragent);
        }

        if ($s->contains('SGH-i957', false)) {
            return $this->loader->load('sgh-i957', $useragent);
        }

        if ($s->contains('sgh-i917', false)) {
            return $this->loader->load('sgh-i917', $useragent);
        }

        if ($s->contains('sgh-i900v', false)) {
            return $this->loader->load('sgh-i900v', $useragent);
        }

        if ($s->contains('sgh-i9000', false)) {
            return $this->loader->load('sgh-i9000', $useragent);
        }

        if ($s->contains('sgh-i9008', false)) {
            return $this->loader->load('sgh-i9008', $useragent);
        }

        if ($s->contains('sgh-i900', false)) {
            return $this->loader->load('sgh-i900', $useragent);
        }

        if ($s->contains('sgh-i897', false)) {
            return $this->loader->load('sgh-i897', $useragent);
        }

        if ($s->contains('sgh-i857', false)) {
            return $this->loader->load('sgh-i857', $useragent);
        }

        if ($s->contains('sgh-i780', false)) {
            return $this->loader->load('sgh-i780', $useragent);
        }

        if ($s->contains('sgh-i777', false)) {
            return $this->loader->load('sgh-i777', $useragent);
        }

        if ($s->contains('sgh-i747m', false)) {
            return $this->loader->load('sgh-i747m', $useragent);
        }

        if ($s->contains('sgh-i747', false)) {
            return $this->loader->load('sgh-i747', $useragent);
        }

        if ($s->contains('sgh-i727r', false)) {
            return $this->loader->load('sgh-i727r', $useragent);
        }

        if ($s->contains('sgh-i727', false)) {
            return $this->loader->load('sgh-i727', $useragent);
        }

        if ($s->contains('sgh-i717', false)) {
            return $this->loader->load('sgh-i717', $useragent);
        }

        if ($s->contains('sgh-i577', false)) {
            return $this->loader->load('sgh-i577', $useragent);
        }

        if ($s->contains('sgh-i547', false)) {
            return $this->loader->load('sgh-i547', $useragent);
        }

        if ($s->contains('sgh-i497', false)) {
            return $this->loader->load('sgh-i497', $useragent);
        }

        if ($s->contains('sgh-i467', false)) {
            return $this->loader->load('sgh-i467', $useragent);
        }

        if ($s->contains('sgh-i337m', false)) {
            return $this->loader->load('sgh-i337m', $useragent);
        }

        if ($s->contains('sgh-i337', false)) {
            return $this->loader->load('sgh-i337', $useragent);
        }

        if ($s->contains('sgh-i317', false)) {
            return $this->loader->load('sgh-i317', $useragent);
        }

        if ($s->contains('sgh-i257', false)) {
            return $this->loader->load('sgh-i257', $useragent);
        }

        if ($s->contains('sgh-f480i', false)) {
            return $this->loader->load('sgh-f480i', $useragent);
        }

        if ($s->contains('sgh-f480', false)) {
            return $this->loader->load('sgh-f480', $useragent);
        }

        if ($s->contains('sgh-e250i', false)) {
            return $this->loader->load('sgh-e250i', $useragent);
        }

        if ($s->contains('sgh-e250', false)) {
            return $this->loader->load('sgh-e250', $useragent);
        }

        if ($s->containsAny(['sgh-b100', 'sec-sghb100'], false)) {
            return $this->loader->load('sgh-b100', $useragent);
        }

        if ($s->contains('sec-sghu600b', false)) {
            return $this->loader->load('sgh-u600b', $useragent);
        }

        if ($s->contains('sgh-u800e', false)) {
            return $this->loader->load('sgh-u800e', $useragent);
        }

        if ($s->contains('sgh-u800', false)) {
            return $this->loader->load('sgh-u800', $useragent);
        }

        if ($s->contains('shv-e370k', false)) {
            return $this->loader->load('shv-e370k', $useragent);
        }

        if ($s->contains('shv-e250k', false)) {
            return $this->loader->load('shv-e250k', $useragent);
        }

        if ($s->contains('shv-e250l', false)) {
            return $this->loader->load('shv-e250l', $useragent);
        }

        if ($s->contains('shv-e250s', false)) {
            return $this->loader->load('shv-e250s', $useragent);
        }

        if ($s->contains('shv-e210l', false)) {
            return $this->loader->load('shv-e210l', $useragent);
        }

        if ($s->contains('shv-e210k', false)) {
            return $this->loader->load('shv-e210k', $useragent);
        }

        if ($s->contains('shv-e210s', false)) {
            return $this->loader->load('shv-e210s', $useragent);
        }

        if ($s->contains('shv-e160s', false)) {
            return $this->loader->load('shv-e160s', $useragent);
        }

        if ($s->contains('shw-m110s', false)) {
            return $this->loader->load('shw-m110s', $useragent);
        }

        if ($s->contains('shw-m180s', false)) {
            return $this->loader->load('shw-m180s', $useragent);
        }

        if ($s->contains('shw-m380s', false)) {
            return $this->loader->load('shw-m380s', $useragent);
        }

        if ($s->contains('shw-m380w', false)) {
            return $this->loader->load('shw-m380w', $useragent);
        }

        if ($s->contains('shw-m930bst', false)) {
            return $this->loader->load('shw-m930bst', $useragent);
        }

        if ($s->contains('shw-m480w', false)) {
            return $this->loader->load('shw-m480w', $useragent);
        }

        if ($s->contains('shw-m380k', false)) {
            return $this->loader->load('shw-m380k', $useragent);
        }

        if ($s->contains('scl24', false)) {
            return $this->loader->load('scl24', $useragent);
        }

        if ($s->contains('sch-u820', false)) {
            return $this->loader->load('sch-u820', $useragent);
        }

        if ($s->contains('sch-u750', false)) {
            return $this->loader->load('sch-u750', $useragent);
        }

        if ($s->contains('sch-u660', false)) {
            return $this->loader->load('sch-u660', $useragent);
        }

        if ($s->contains('sch-u485', false)) {
            return $this->loader->load('sch-u485', $useragent);
        }

        if ($s->contains('sch-r970', false)) {
            return $this->loader->load('sch-r970', $useragent);
        }

        if ($s->contains('sch-r950', false)) {
            return $this->loader->load('sch-r950', $useragent);
        }

        if ($s->contains('sch-r720', false)) {
            return $this->loader->load('sch-r720', $useragent);
        }

        if ($s->contains('sch-r530u', false)) {
            return $this->loader->load('sch-r530u', $useragent);
        }

        if ($s->contains('sch-r530c', false)) {
            return $this->loader->load('sch-r530c', $useragent);
        }

        if ($s->contains('sch-n719', false)) {
            return $this->loader->load('sch-n719', $useragent);
        }

        if ($s->contains('sch-m828c', false)) {
            return $this->loader->load('sch-m828c', $useragent);
        }

        if ($s->contains('sch-i535', false)) {
            return $this->loader->load('sch-i535', $useragent);
        }

        if ($s->contains('sch-i919', false)) {
            return $this->loader->load('sch-i919', $useragent);
        }

        if ($s->contains('sch-i815', false)) {
            return $this->loader->load('sch-i815', $useragent);
        }

        if ($s->contains('sch-i800', false)) {
            return $this->loader->load('sch-i800', $useragent);
        }

        if ($s->contains('sch-i699', false)) {
            return $this->loader->load('sch-i699', $useragent);
        }

        if ($s->contains('sch-i605', false)) {
            return $this->loader->load('sch-i605', $useragent);
        }

        if ($s->contains('sch-i545', false)) {
            return $this->loader->load('sch-i545', $useragent);
        }

        if ($s->contains('sch-i510', false)) {
            return $this->loader->load('sch-i510', $useragent);
        }

        if ($s->contains('sch-i500', false)) {
            return $this->loader->load('sch-i500', $useragent);
        }

        if ($s->contains('sch-i435', false)) {
            return $this->loader->load('sch-i435', $useragent);
        }

        if ($s->contains('sch-i400', false)) {
            return $this->loader->load('sch-i400', $useragent);
        }

        if ($s->contains('sch-i200', false)) {
            return $this->loader->load('sch-i200', $useragent);
        }

        if ($s->contains('SCH-S720C', false)) {
            return $this->loader->load('sch-s720c', $useragent);
        }

        if ($s->contains('GT-S8600', false)) {
            return $this->loader->load('gt-s8600', $useragent);
        }

        if ($s->contains('GT-S8530', false)) {
            return $this->loader->load('gt-s8530', $useragent);
        }

        if ($s->contains('s8500', false)) {
            return $this->loader->load('gt-s8500', $useragent);
        }

        if ($s->containsAny(['samsung-s8300', 'gt-s8300'], false)) {
            return $this->loader->load('gt-s8300', $useragent);
        }

        if ($s->containsAny(['samsung-s8003', 'gt-s8003'], false)) {
            return $this->loader->load('gt-s8003', $useragent);
        }

        if ($s->containsAny(['samsung-s8000', 'gt-s8000'], false)) {
            return $this->loader->load('gt-s8000', $useragent);
        }

        if ($s->containsAny(['samsung-s7710', 'gt-s7710'], false)) {
            return $this->loader->load('gt-s7710', $useragent);
        }

        if ($s->contains('gt-s7582', false)) {
            return $this->loader->load('gt-s7582', $useragent);
        }

        if ($s->contains('gt-s7580', false)) {
            return $this->loader->load('gt-s7580', $useragent);
        }

        if ($s->contains('gt-s7562l', false)) {
            return $this->loader->load('gt-s7562l', $useragent);
        }

        if ($s->contains('gt-s7562', false)) {
            return $this->loader->load('gt-s7562', $useragent);
        }

        if ($s->contains('gt-s7560', false)) {
            return $this->loader->load('gt-s7560', $useragent);
        }

        if ($s->contains('gt-s7530', false)) {
            return $this->loader->load('gt-s7530', $useragent);
        }

        if ($s->contains('gt-s7500', false)) {
            return $this->loader->load('gt-s7500', $useragent);
        }

        if ($s->contains('gt-s7392', false)) {
            return $this->loader->load('gt-s7392', $useragent);
        }

        if ($s->contains('gt-s7390', false)) {
            return $this->loader->load('gt-s7390', $useragent);
        }

        if ($s->contains('gt-s7330', false)) {
            return $this->loader->load('gt-s7330', $useragent);
        }

        if ($s->contains('gt-s7275r', false)) {
            return $this->loader->load('gt-s7275r', $useragent);
        }

        if ($s->contains('gt-s7275', false)) {
            return $this->loader->load('gt-s7275', $useragent);
        }

        if ($s->contains('gt-s7272', false)) {
            return $this->loader->load('gt-s7272', $useragent);
        }

        if ($s->contains('gt-s7270', false)) {
            return $this->loader->load('gt-s7270', $useragent);
        }

        if ($s->contains('gt-s7262', false)) {
            return $this->loader->load('gt-s7262', $useragent);
        }

        if ($s->contains('gt-s7250', false)) {
            return $this->loader->load('gt-s7250', $useragent);
        }

        if ($s->contains('gt-s7233e', false)) {
            return $this->loader->load('gt-s7233e', $useragent);
        }

        if ($s->contains('gt-s7230e', false)) {
            return $this->loader->load('gt-s7230e', $useragent);
        }

        if ($s->containsAny(['samsung-s7220', 'gt-s7220'], false)) {
            return $this->loader->load('gt-s7220', $useragent);
        }

        if ($s->contains('gt-s6810p', false)) {
            return $this->loader->load('gt-s6810p', $useragent);
        }

        if ($s->contains('gt-s6810b', false)) {
            return $this->loader->load('gt-s6810b', $useragent);
        }

        if ($s->contains('gt-s6810', false)) {
            return $this->loader->load('gt-s6810', $useragent);
        }

        if ($s->contains('gt-s6802', false)) {
            return $this->loader->load('gt-s6802', $useragent);
        }

        if ($s->contains('gt-s6500d', false)) {
            return $this->loader->load('gt-s6500d', $useragent);
        }

        if ($s->contains('gt-s6500t', false)) {
            return $this->loader->load('gt-s6500t', $useragent);
        }

        if ($s->contains('gt-s6500', false)) {
            return $this->loader->load('gt-s6500', $useragent);
        }

        if ($s->contains('gt-s6312', false)) {
            return $this->loader->load('gt-s6312', $useragent);
        }

        if ($s->contains('gt-s6310n', false)) {
            return $this->loader->load('gt-s6310n', $useragent);
        }

        if ($s->contains('gt-s6310', false)) {
            return $this->loader->load('gt-s6310', $useragent);
        }

        if ($s->contains('gt-s6102b', false)) {
            return $this->loader->load('gt-s6102b', $useragent);
        }

        if ($s->contains('gt-s6102', false)) {
            return $this->loader->load('gt-s6102', $useragent);
        }

        if ($s->contains('gt-s5839i', false)) {
            return $this->loader->load('gt-s5839i', $useragent);
        }

        if ($s->contains('gt-s5830l', false)) {
            return $this->loader->load('gt-s5830l', $useragent);
        }

        if ($s->contains('gt-s5830i', false)) {
            return $this->loader->load('gt-s5830i', $useragent);
        }

        if ($s->contains('gt-s5830c', false)) {
            return $this->loader->load('gt-s5830c', $useragent);
        }

        if ($s->contains('gt-s5570i', false)) {
            return $this->loader->load('gt-s5570i', $useragent);
        }

        if ($s->contains('gt-s5570', false)) {
            return $this->loader->load('gt-s5570', $useragent);
        }

        if ($s->containsAny(['gt-s5830', 'ace'], false)) {
            return $this->loader->load('gt-s5830', $useragent);
        }

        if ($s->contains('gt-s5780', false)) {
            return $this->loader->load('gt-s5780', $useragent);
        }

        if ($s->contains('gt-s5750e', false)) {
            return $this->loader->load('gt-s5750e orange', $useragent);
        }

        if ($s->contains('gt-s5690', false)) {
            return $this->loader->load('gt-s5690', $useragent);
        }

        if ($s->contains('gt-s5670', false)) {
            return $this->loader->load('gt-s5670', $useragent);
        }

        if ($s->contains('gt-s5660', false)) {
            return $this->loader->load('gt-s5660', $useragent);
        }

        if ($s->contains('gt-s5620', false)) {
            return $this->loader->load('gt-s5620', $useragent);
        }

        if ($s->contains('gt-s5560i', false)) {
            return $this->loader->load('gt-s5560i', $useragent);
        }

        if ($s->contains('gt-s5560', false)) {
            return $this->loader->load('gt-s5560', $useragent);
        }

        if ($s->contains('gt-s5380', false)) {
            return $this->loader->load('gt-s5380', $useragent);
        }

        if ($s->contains('gt-s5369', false)) {
            return $this->loader->load('gt-s5369', $useragent);
        }

        if ($s->contains('gt-s5363', false)) {
            return $this->loader->load('gt-s5363', $useragent);
        }

        if ($s->contains('gt-s5360', false)) {
            return $this->loader->load('gt-s5360', $useragent);
        }

        if ($s->contains('gt-s5330', false)) {
            return $this->loader->load('gt-s5330', $useragent);
        }

        if ($s->contains('gt-s5310m', false)) {
            return $this->loader->load('gt-s5310m', $useragent);
        }

        if ($s->contains('gt-s5310', false)) {
            return $this->loader->load('gt-s5310', $useragent);
        }

        if ($s->contains('gt-s5302', false)) {
            return $this->loader->load('gt-s5302', $useragent);
        }

        if ($s->contains('gt-s5301l', false)) {
            return $this->loader->load('gt-s5301l', $useragent);
        }

        if ($s->contains('gt-s5301', false)) {
            return $this->loader->load('gt-s5301', $useragent);
        }

        if ($s->contains('gt-s5300b', false)) {
            return $this->loader->load('gt-s5300b', $useragent);
        }

        if ($s->contains('gt-s5300', false)) {
            return $this->loader->load('gt-s5300', $useragent);
        }

        if ($s->contains('gt-s5280', false)) {
            return $this->loader->load('gt-s5280', $useragent);
        }

        if ($s->contains('gt-s5260', false)) {
            return $this->loader->load('gt-s5260', $useragent);
        }

        if ($s->contains('gt-s5250', false)) {
            return $this->loader->load('gt-s5250', $useragent);
        }

        if ($s->contains('gt-s5233s', false)) {
            return $this->loader->load('gt-s5233s', $useragent);
        }

        if ($s->contains('gt-s5230w', false)) {
            return $this->loader->load('gt s5230w', $useragent);
        }

        if ($s->contains('gt-s5230', false)) {
            return $this->loader->load('gt-s5230', $useragent);
        }

        if ($s->contains('gt-s5222', false)) {
            return $this->loader->load('gt-s5222', $useragent);
        }

        if ($s->contains('gt-s5220', false)) {
            return $this->loader->load('gt-s5220', $useragent);
        }

        if ($s->contains('gt-s3850', false)) {
            return $this->loader->load('gt-s3850', $useragent);
        }

        if ($s->contains('gt-s3802', false)) {
            return $this->loader->load('gt-s3802', $useragent);
        }

        if ($s->contains('gt-s3653', false)) {
            return $this->loader->load('gt-s3653', $useragent);
        }

        if ($s->contains('gt-s3650', false)) {
            return $this->loader->load('gt-s3650', $useragent);
        }

        if ($s->contains('gt-s3370', false)) {
            return $this->loader->load('gt-s3370', $useragent);
        }

        if ($s->contains('gt-p7511', false)) {
            return $this->loader->load('gt-p7511', $useragent);
        }

        if ($s->contains('gt-p7510', false)) {
            return $this->loader->load('gt-p7510', $useragent);
        }

        if ($s->contains('gt-p7501', false)) {
            return $this->loader->load('gt-p7501', $useragent);
        }

        if ($s->contains('gt-p7500m', false)) {
            return $this->loader->load('gt-p7500m', $useragent);
        }

        if ($s->contains('gt-p7500', false)) {
            return $this->loader->load('gt-p7500', $useragent);
        }

        if ($s->contains('gt-p7320', false)) {
            return $this->loader->load('gt-p7320', $useragent);
        }

        if ($s->contains('gt-p7310', false)) {
            return $this->loader->load('gt-p7310', $useragent);
        }

        if ($s->contains('gt-p7300b', false)) {
            return $this->loader->load('gt-p7300b', $useragent);
        }

        if ($s->contains('gt-p7300', false)) {
            return $this->loader->load('gt-p7300', $useragent);
        }

        if ($s->contains('gt-p7100', false)) {
            return $this->loader->load('gt-p7100', $useragent);
        }

        if ($s->contains('gt-p6810', false)) {
            return $this->loader->load('gt-p6810', $useragent);
        }

        if ($s->contains('gt-p6800', false)) {
            return $this->loader->load('gt-p6800', $useragent);
        }

        if ($s->contains('gt-p6211', false)) {
            return $this->loader->load('gt-p6211', $useragent);
        }

        if ($s->contains('gt-p6210', false)) {
            return $this->loader->load('gt-p6210', $useragent);
        }

        if ($s->contains('gt-p6201', false)) {
            return $this->loader->load('gt-p6201', $useragent);
        }

        if ($s->contains('gt-p6200', false)) {
            return $this->loader->load('gt-p6200', $useragent);
        }

        if ($s->contains('gt-p5220', false)) {
            return $this->loader->load('gt-p5220', $useragent);
        }

        if ($s->contains('gt-p5210', false)) {
            return $this->loader->load('gt-p5210', $useragent);
        }

        if ($s->contains('gt-p5200', false)) {
            return $this->loader->load('gt-p5200', $useragent);
        }

        if ($s->contains('gt-p5113', false)) {
            return $this->loader->load('gt-p5113', $useragent);
        }

        if ($s->contains('gt-p5110', false)) {
            return $this->loader->load('gt-p5110', $useragent);
        }

        if ($s->contains('gt-p5100', false)) {
            return $this->loader->load('gt-p5100', $useragent);
        }

        if ($s->contains('gt-p3113', false)) {
            return $this->loader->load('gt-p3113', $useragent);
        }

        if ($s->containsAny(['gt-p3100', 'galaxy tab 2 3g'], false)) {
            return $this->loader->load('gt-p3100', $useragent);
        }

        if ($s->containsAny(['gt-p3110', 'galaxy tab 2'], false)) {
            return $this->loader->load('gt-p3110', $useragent);
        }

        if ($s->contains('gt-p1010', false)) {
            return $this->loader->load('gt-p1010', $useragent);
        }

        if ($s->contains('gt-p1000n', false)) {
            return $this->loader->load('gt-p1000n', $useragent);
        }

        if ($s->contains('gt-p1000m', false)) {
            return $this->loader->load('gt-p1000m', $useragent);
        }

        if ($s->contains('gt-p1000', false)) {
            return $this->loader->load('gt-p1000', $useragent);
        }

        if ($s->contains('gt-n9000', false)) {
            return $this->loader->load('gt-n9000', $useragent);
        }

        if ($s->contains('gt-n8020', false)) {
            return $this->loader->load('gt-n8020', $useragent);
        }

        if ($s->contains('gt-n8013', false)) {
            return $this->loader->load('gt-n8013', $useragent);
        }

        if ($s->contains('gt-n8010', false)) {
            return $this->loader->load('gt-n8010', $useragent);
        }

        if ($s->contains('gt-n8005', false)) {
            return $this->loader->load('gt-n8005', $useragent);
        }

        if ($s->containsAny(['gt-n8000d', 'n8000d'], false)) {
            return $this->loader->load('gt-n8000d', $useragent);
        }

        if ($s->contains('gt-n8000', false)) {
            return $this->loader->load('gt-n8000', $useragent);
        }

        if ($s->contains('gt-n7108', false)) {
            return $this->loader->load('gt-n7108', $useragent);
        }

        if ($s->contains('gt-n7105', false)) {
            return $this->loader->load('gt-n7105', $useragent);
        }

        if ($s->contains('gt-n7100', false)) {
            return $this->loader->load('gt-n7100', $useragent);
        }

        if ($s->contains('GT-N7000', false)) {
            return $this->loader->load('gt-n7000', $useragent);
        }

        if ($s->contains('GT-N5120', false)) {
            return $this->loader->load('gt-n5120', $useragent);
        }

        if ($s->contains('GT-N5110', false)) {
            return $this->loader->load('gt-n5110', $useragent);
        }

        if ($s->contains('GT-N5100', false)) {
            return $this->loader->load('gt-n5100', $useragent);
        }

        if ($s->contains('GT-M7600', false)) {
            return $this->loader->load('gt-m7600', $useragent);
        }

        if ($s->contains('GT-I9515', false)) {
            return $this->loader->load('gt-i9515', $useragent);
        }

        if ($s->contains('GT-I9506', false)) {
            return $this->loader->load('gt-i9506', $useragent);
        }

        if ($s->contains('GT-I9505X', false)) {
            return $this->loader->load('gt-i9505x', $useragent);
        }

        if ($s->contains('GT-I9505G', false)) {
            return $this->loader->load('gt-i9505g', $useragent);
        }

        if ($s->contains('GT-I9505', false)) {
            return $this->loader->load('gt-i9505', $useragent);
        }

        if ($s->contains('GT-I9502', false)) {
            return $this->loader->load('gt-i9502', $useragent);
        }

        if ($s->contains('GT-I9500', false)) {
            return $this->loader->load('gt-i9500', $useragent);
        }

        if ($s->contains('GT-I9308', false)) {
            return $this->loader->load('gt-i9308', $useragent);
        }

        if ($s->contains('GT-I9305', false)) {
            return $this->loader->load('gt-i9305', $useragent);
        }

        if ($s->containsAny(['gt-i9301i', 'i9301i'], false)) {
            return $this->loader->load('gt-i9301i', $useragent);
        }

        if ($s->containsAny(['gt-i9301q', 'i9301q'], false)) {
            return $this->loader->load('gt-i9301q', $useragent);
        }

        if ($s->containsAny(['gt-i9301', 'i9301'], false)) {
            return $this->loader->load('gt-i9301', $useragent);
        }

        if ($s->contains('GT-I9300I', false)) {
            return $this->loader->load('gt-i9300i', $useragent);
        }

        if ($s->containsAny(['GT-l9300', 'GT-i9300', 'I9300'], false)) {
            return $this->loader->load('gt-i9300', $useragent);
        }

        if ($s->containsAny(['GT-I9295', 'I9295'], false)) {
            return $this->loader->load('gt-i9295', $useragent);
        }

        if ($s->contains('GT-I9210', false)) {
            return $this->loader->load('gt-i9210', $useragent);
        }

        if ($s->contains('GT-I9205', false)) {
            return $this->loader->load('gt-i9205', $useragent);
        }

        if ($s->contains('GT-I9200', false)) {
            return $this->loader->load('gt-i9200', $useragent);
        }

        if ($s->contains('gt-i9195i', false)) {
            return $this->loader->load('gt-i9195i', $useragent);
        }

        if ($s->containsAny(['gt-i9195', 'i9195'], false)) {
            return $this->loader->load('gt-i9195', $useragent);
        }

        if ($s->containsAny(['gt-i9192', 'i9192'], false)) {
            return $this->loader->load('gt-i9192', $useragent);
        }

        if ($s->containsAny(['gt-i9190', 'i9190'], false)) {
            return $this->loader->load('gt-i9190', $useragent);
        }

        if ($s->contains('gt-i9152', false)) {
            return $this->loader->load('gt-i9152', $useragent);
        }

        if ($s->contains('gt-i9128v', false)) {
            return $this->loader->load('gt-i9128v', $useragent);
        }

        if ($s->contains('gt-i9105p', false)) {
            return $this->loader->load('gt-i9105p', $useragent);
        }

        if ($s->contains('gt-i9105', false)) {
            return $this->loader->load('gt-i9105', $useragent);
        }

        if ($s->contains('gt-i9103', false)) {
            return $this->loader->load('gt-i9103', $useragent);
        }

        if ($s->contains('gt-i9100t', false)) {
            return $this->loader->load('gt-i9100t', $useragent);
        }

        if ($s->contains('gt-i9100p', false)) {
            return $this->loader->load('gt-i9100p', $useragent);
        }

        if ($s->contains('gt-i9100g', false)) {
            return $this->loader->load('gt-i9100g', $useragent);
        }

        if ($s->containsAny(['gt-i9100', 'i9100'], false)) {
            return $this->loader->load('gt-i9100', $useragent);
        }

        if ($s->contains('gt-i9088', false)) {
            return $this->loader->load('gt-i9088', $useragent);
        }

        if ($s->contains('gt-i9082l', false)) {
            return $this->loader->load('gt-i9082l', $useragent);
        }

        if ($s->contains('gt-i9082', false)) {
            return $this->loader->load('gt-i9082', $useragent);
        }

        if ($s->contains('gt-i9070p', false)) {
            return $this->loader->load('gt-i9070p', $useragent);
        }

        if ($s->contains('gt-i9070', false)) {
            return $this->loader->load('gt-i9070', $useragent);
        }

        if ($s->contains('gt-i9060l', false)) {
            return $this->loader->load('gt-i9060l', $useragent);
        }

        if ($s->contains('gt-i9060i', false)) {
            return $this->loader->load('gt-i9060i', $useragent);
        }

        if ($s->contains('gt-i9060', false)) {
            return $this->loader->load('gt-i9060', $useragent);
        }

        if ($s->contains('gt-i9023', false)) {
            return $this->loader->load('gt-i9023', $useragent);
        }

        if ($s->contains('gt-i9010p', false)) {
            return $this->loader->load('gt-i9010p', $useragent);
        }

        if ($s->containsAny(['galaxy s4', 'galaxy-s4'], false)) {
            return $this->loader->load('gt-i9500', $useragent);
        }

        if ($s->containsAny(['Galaxy S', 'Galaxy-S'], false)) {
            return $this->loader->load('samsung gt-i9010', $useragent);
        }

        if ($s->contains('GT-I9010', false)) {
            return $this->loader->load('samsung gt-i9010', $useragent);
        }

        if ($s->contains('gt-i9008l', false)) {
            return $this->loader->load('gt-i9008l', $useragent);
        }

        if ($s->contains('gt-i9008', false)) {
            return $this->loader->load('gt-i9008', $useragent);
        }

        if ($s->contains('gt-i9003l', false)) {
            return $this->loader->load('gt-i9003l', $useragent);
        }

        if ($s->contains('gt-i9003', false)) {
            return $this->loader->load('gt-i9003', $useragent);
        }

        if ($s->contains('gt-i9001', false)) {
            return $this->loader->load('gt-i9001', $useragent);
        }

        if ($s->containsAny(['gt-i9000', 'sgh-t959v'], false)) {
            return $this->loader->load('gt-i9000', $useragent);
        }

        if ($s->containsAny(['gt-i8910', 'i8910'], false)) {
            return $this->loader->load('gt-i8910', $useragent);
        }

        if ($s->contains('gt-i8750', false)) {
            return $this->loader->load('gt-i8750', $useragent);
        }

        if ($s->contains('gt-i8730', false)) {
            return $this->loader->load('gt-i8730', $useragent);
        }

        if ($s->contains('omnia7', false)) {
            return $this->loader->load('gt-i8700', $useragent);
        }

        if ($s->contains('gt-i8552', false)) {
            return $this->loader->load('gt-i8552', $useragent);
        }

        if ($s->contains('gt-i8530', false)) {
            return $this->loader->load('gt-i8530', $useragent);
        }

        if ($s->contains('gt-i8350', false)) {
            return $this->loader->load('gt-i8350', $useragent);
        }

        if ($s->contains('gt-i8320', false)) {
            return $this->loader->load('gt-i8320', $useragent);
        }

        if ($s->contains('gt-i8262', false)) {
            return $this->loader->load('gt-i8262', $useragent);
        }

        if ($s->contains('gt-i8260', false)) {
            return $this->loader->load('gt-i8260', $useragent);
        }

        if ($s->contains('gt-i8200n', false)) {
            return $this->loader->load('gt-i8200n', $useragent);
        }

        if ($s->contains('GT-I8200', false)) {
            return $this->loader->load('gt-i8200', $useragent);
        }

        if ($s->contains('GT-I8190N', false)) {
            return $this->loader->load('gt-i8190n', $useragent);
        }

        if ($s->contains('GT-I8190', false)) {
            return $this->loader->load('gt-i8190', $useragent);
        }

        if ($s->contains('GT-I8160P', false)) {
            return $this->loader->load('gt-i8160p', $useragent);
        }

        if ($s->contains('GT-I8160', false)) {
            return $this->loader->load('gt-i8160', $useragent);
        }

        if ($s->contains('GT-I8150', false)) {
            return $this->loader->load('gt-i8150', $useragent);
        }

        if ($s->contains('GT-i8000V', false)) {
            return $this->loader->load('gt-i8000v', $useragent);
        }

        if ($s->contains('GT-i8000', false)) {
            return $this->loader->load('gt-i8000', $useragent);
        }

        if ($s->contains('GT-I6410', false)) {
            return $this->loader->load('gt-i6410', $useragent);
        }

        if ($s->contains('GT-I5801', false)) {
            return $this->loader->load('gt-i5801', $useragent);
        }

        if ($s->contains('GT-I5800', false)) {
            return $this->loader->load('gt-i5800', $useragent);
        }

        if ($s->contains('GT-I5700', false)) {
            return $this->loader->load('gt-i5700', $useragent);
        }

        if ($s->contains('GT-I5510', false)) {
            return $this->loader->load('gt-i5510', $useragent);
        }

        if ($s->contains('GT-I5508', false)) {
            return $this->loader->load('gt-i5508', $useragent);
        }

        if ($s->contains('GT-I5503', false)) {
            return $this->loader->load('gt-i5503', $useragent);
        }

        if ($s->contains('GT-I5500', false)) {
            return $this->loader->load('gt-i5500', $useragent);
        }

        if ($s->contains('nexus s 4g', false)) {
            return $this->loader->load('nexus s 4g', $useragent);
        }

        if ($s->contains('nexus s', false)) {
            return $this->loader->load('nexus s', $useragent);
        }

        if ($s->contains('nexus 10', false)) {
            return $this->loader->load('nexus 10', $useragent);
        }

        if ($s->contains('nexus player', false)) {
            return $this->loader->load('nexus player', $useragent);
        }

        if ($s->contains('nexus', false)) {
            return $this->loader->load('galaxy nexus', $useragent);
        }

        if ($s->contains('Galaxy', false)) {
            return $this->loader->load('gt-i7500', $useragent);
        }

        if ($s->contains('GT-E3309T', false)) {
            return $this->loader->load('gt-e3309t', $useragent);
        }

        if ($s->contains('GT-E2550', false)) {
            return $this->loader->load('gt-e2550', $useragent);
        }

        if ($s->contains('GT-E2252', false)) {
            return $this->loader->load('gt-e2252', $useragent);
        }

        if ($s->contains('GT-E2222', false)) {
            return $this->loader->load('gt-e2222', $useragent);
        }

        if ($s->contains('GT-E2202', false)) {
            return $this->loader->load('gt-e2202', $useragent);
        }

        if ($s->contains('GT-E1282T', false)) {
            return $this->loader->load('gt-e1282t', $useragent);
        }

        if ($s->contains('GT-C6712', false)) {
            return $this->loader->load('gt-c6712', $useragent);
        }

        if ($s->contains('GT-C3780', false)) {
            return $this->loader->load('gt-c3780', $useragent);
        }

        if ($s->contains('GT-C3510', false)) {
            return $this->loader->load('gt-c3510', $useragent);
        }

        if ($s->contains('GT-C3500', false)) {
            return $this->loader->load('gt-c3500', $useragent);
        }

        if ($s->contains('GT-C3350', false)) {
            return $this->loader->load('gt-c3350', $useragent);
        }

        if ($s->contains('GT-C3322', false)) {
            return $this->loader->load('gt-c3322', $useragent);
        }

        if ($s->contains('gt-C3312r', false)) {
            return $this->loader->load('gt-c3312r', $useragent);
        }

        if ($s->contains('GT-C3310', false)) {
            return $this->loader->load('gt-c3310', $useragent);
        }

        if ($s->contains('GT-C3262', false)) {
            return $this->loader->load('gt-c3262', $useragent);
        }

        if ($s->contains('GT-B7722', false)) {
            return $this->loader->load('gt-b7722', $useragent);
        }

        if ($s->contains('GT-B7610', false)) {
            return $this->loader->load('gt-b7610', $useragent);
        }

        if ($s->contains('GT-B7510', false)) {
            return $this->loader->load('gt-b7510', $useragent);
        }

        if ($s->contains('GT-B7350', false)) {
            return $this->loader->load('gt-b7350', $useragent);
        }

        if ($s->contains('gt-b5510l', false)) {
            return $this->loader->load('gt-b5510l', $useragent);
        }

        if ($s->contains('gt-b5510', false)) {
            return $this->loader->load('gt-b5510', $useragent);
        }

        if ($s->contains('gt-b3410', false)) {
            return $this->loader->load('gt-b3410', $useragent);
        }

        if ($s->contains('gt-b2710', false)) {
            return $this->loader->load('gt-b2710', $useragent);
        }

        if ($s->contains('gt-b2100i', false)) {
            return $this->loader->load('gt-b2100i', $useragent);
        }

        if ($s->containsAny(['gt-b2100', 'b2100'], false)) {
            return $this->loader->load('gt-b2100', $useragent);
        }

        if ($s->contains('F031', false)) {
            return $this->loader->load('f031', $useragent);
        }

        if ($s->contains('Continuum-I400', false)) {
            return $this->loader->load('continuum i400', $useragent);
        }

        if ($s->contains('CETUS', false)) {
            return $this->loader->load('cetus', $useragent);
        }

        if ($s->contains('sc-06d', false)) {
            return $this->loader->load('sc-06d', $useragent);
        }

        if ($s->contains('sc-02f', false)) {
            return $this->loader->load('sc-02f', $useragent);
        }

        if ($s->contains('sc-02c', false)) {
            return $this->loader->load('sc-02c', $useragent);
        }

        if ($s->contains('sc-02b', false)) {
            return $this->loader->load('sc-02b', $useragent);
        }

        if ($s->contains('sc-01f', false)) {
            return $this->loader->load('sc-01f', $useragent);
        }

        if ($s->contains('S3500', false)) {
            return $this->loader->load('s3500', $useragent);
        }

        if ($s->contains('R631', false)) {
            return $this->loader->load('r631', $useragent);
        }

        if ($s->contains('i7110', false)) {
            return $this->loader->load('i7110', $useragent);
        }

        if ($s->contains('yp-gs1', false)) {
            return $this->loader->load('yp-gs1', $useragent);
        }

        if ($s->contains('yp-gi1', false)) {
            return $this->loader->load('yp-gi1', $useragent);
        }

        if ($s->contains('yp-gb70', false)) {
            return $this->loader->load('yp-gb70', $useragent);
        }

        if ($s->contains('yp-g70', false)) {
            return $this->loader->load('yp-g70', $useragent);
        }

        if ($s->contains('yp-g1', false)) {
            return $this->loader->load('yp-g1', $useragent);
        }

        if ($s->contains('sch-r730', false)) {
            return $this->loader->load('sch-r730', $useragent);
        }

        if ($s->contains('sph-p100', false)) {
            return $this->loader->load('sph-p100', $useragent);
        }

        if ($s->contains('sph-m930', false)) {
            return $this->loader->load('sph-m930', $useragent);
        }

        if ($s->contains('sph-m840', false)) {
            return $this->loader->load('sph-m840', $useragent);
        }

        if ($s->contains('sph-m580', false)) {
            return $this->loader->load('sph-m580', $useragent);
        }

        if ($s->contains('sph-l900', false)) {
            return $this->loader->load('sph-l900', $useragent);
        }

        if ($s->contains('sph-l720', false)) {
            return $this->loader->load('sph-l720', $useragent);
        }

        if ($s->contains('sph-l710', false)) {
            return $this->loader->load('sph-l710', $useragent);
        }

        if ($s->contains('sph-ip830w', false)) {
            return $this->loader->load('sph-ip830w', $useragent);
        }

        if ($s->contains('sph-d710bst', false)) {
            return $this->loader->load('sph-d710bst', $useragent);
        }

        if ($s->contains('sph-d710', false)) {
            return $this->loader->load('sph-d710', $useragent);
        }

        if ($s->contains('smart-tv', false)) {
            return $this->loader->load('samsung smart tv', $useragent);
        }

        return $this->loader->load('general samsung device', $useragent);
    }
}
