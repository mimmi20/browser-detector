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
use Psr\Cache\CacheItemPoolInterface;
use Stringy\Stringy;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class HuaweiFactory implements Factory\FactoryInterface
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
        if ($s->contains('nexus 6p', false)) {
            return $this->loader->load('nexus 6p', $useragent);
        }

        if ($s->contains('tag-al00', false)) {
            return $this->loader->load('tag-al00', $useragent);
        }

        if ($s->contains('tag-l21', false)) {
            return $this->loader->load('tag-l21', $useragent);
        }

        if ($s->contains('tag-l01', false)) {
            return $this->loader->load('tag-l01', $useragent);
        }

        if ($s->contains('ale-21', false)) {
            return $this->loader->load('ale 21', $useragent);
        }

        if ($s->contains('ale-l21', false)) {
            return $this->loader->load('ale-l21', $useragent);
        }

        if ($s->contains('ale-l02', false)) {
            return $this->loader->load('ale-l02', $useragent);
        }

        if ($s->contains('gra-l09', false)) {
            return $this->loader->load('gra-l09', $useragent);
        }

        if ($s->contains('GRACE', false)) {
            return $this->loader->load('grace', $useragent);
        }

        if ($s->contains('p7-l10', false)) {
            return $this->loader->load('p7-l10', $useragent);
        }

        if ($s->contains('p7-l09', false)) {
            return $this->loader->load('p7-l09', $useragent);
        }

        if ($s->containsAny(['p7 mini', 'p7mini'], false)) {
            return $this->loader->load('p7 mini', $useragent);
        }

        if ($s->contains('p2-6011', false)) {
            return $this->loader->load('p2-6011', $useragent);
        }

        if ($s->contains('eva-l19', false)) {
            return $this->loader->load('eva-l19', $useragent);
        }

        if ($s->contains('eva-l09', false)) {
            return $this->loader->load('eva-l09', $useragent);
        }

        if ($s->contains('scl-l01', false)) {
            return $this->loader->load('scl-l01', $useragent);
        }

        if ($s->contains('scl-l21', false)) {
            return $this->loader->load('scl-l21', $useragent);
        }

        if ($s->contains('scl-u31', false)) {
            return $this->loader->load('scl-u31', $useragent);
        }

        if ($s->contains('nxt-l29', false)) {
            return $this->loader->load('nxt-l29', $useragent);
        }

        if ($s->contains('nxt-al10', false)) {
            return $this->loader->load('nxt-al10', $useragent);
        }

        if ($s->contains('gem-703l', false)) {
            return $this->loader->load('gem-703l', $useragent);
        }

        if ($s->contains('gem-702l', false)) {
            return $this->loader->load('gem-702l', $useragent);
        }

        if ($s->contains('gem-701l', false)) {
            return $this->loader->load('gem-701l', $useragent);
        }

        if ($s->contains('g630-u251', false)) {
            return $this->loader->load('g630-u251', $useragent);
        }

        if ($s->contains('g630-u20', false)) {
            return $this->loader->load('g630-u20', $useragent);
        }

        if ($s->contains('g620s-l01', false)) {
            return $this->loader->load('g620s-l01', $useragent);
        }

        if ($s->contains('g610-u20', false)) {
            return $this->loader->load('g610-u20', $useragent);
        }

        if ($s->contains('g7-l11', false)) {
            return $this->loader->load('g7-l11', $useragent);
        }

        if ($s->contains('g7-l01', false)) {
            return $this->loader->load('g7-l01', $useragent);
        }

        if ($s->contains('g6-l11', false)) {
            return $this->loader->load('g6-l11', $useragent);
        }

        if ($s->contains('g6-u10', false)) {
            return $this->loader->load('g6-u10', $useragent);
        }

        if ($s->contains('pe-tl10', false)) {
            return $this->loader->load('pe-tl10', $useragent);
        }

        if ($s->contains('rio-l01', false)) {
            return $this->loader->load('rio-l01', $useragent);
        }

        if ($s->contains('cun-l21', false)) {
            return $this->loader->load('cun-l21', $useragent);
        }

        if ($s->contains('cun-l03', false)) {
            return $this->loader->load('cun-l03', $useragent);
        }

        if ($s->contains('crr-l09', false)) {
            return $this->loader->load('crr-l09', $useragent);
        }

        if ($s->contains('chc-u01', false)) {
            return $this->loader->load('chc-u01', $useragent);
        }

        if ($s->contains('g750-u10', false)) {
            return $this->loader->load('g750-u10', $useragent);
        }

        if ($s->contains('g750-t00', false)) {
            return $this->loader->load('g750-t00', $useragent);
        }

        if ($s->contains('g740-l00', false)) {
            return $this->loader->load('g740-l00', $useragent);
        }

        if ($s->contains('g730-u27', false)) {
            return $this->loader->load('g730-u27', $useragent);
        }

        if ($s->contains('g730-u10', false)) {
            return $this->loader->load('g730-u10', $useragent);
        }

        if ($s->contains('vns-l31', false)) {
            return $this->loader->load('vns-l31', $useragent);
        }

        if ($s->contains('vns-l21', false)) {
            return $this->loader->load('vns-l21', $useragent);
        }

        if ($s->contains('tit-u02', false)) {
            return $this->loader->load('tit-u02', $useragent);
        }

        if ($s->contains('y635-l21', false)) {
            return $this->loader->load('y635-l21', $useragent);
        }

        if ($s->contains('y625-u51', false)) {
            return $this->loader->load('y625-u51', $useragent);
        }

        if ($s->contains('y625-u21', false)) {
            return $this->loader->load('y625-u21', $useragent);
        }

        if ($s->contains('y600-u20', false)) {
            return $this->loader->load('y600-u20', $useragent);
        }

        if ($s->contains('y600-u00', false)) {
            return $this->loader->load('y600-u00', $useragent);
        }

        if ($s->contains('y560-l01', false)) {
            return $this->loader->load('y560-l01', $useragent);
        }

        if ($s->contains('y550-l01', false)) {
            return $this->loader->load('y550-l01', $useragent);
        }

        if ($s->contains('y540-u01', false)) {
            return $this->loader->load('y540-u01', $useragent);
        }

        if ($s->contains('y530-u00', false)) {
            return $this->loader->load('y530-u00', $useragent);
        }

        if ($s->contains('y511', false)) {
            return $this->loader->load('y511', $useragent);
        }

        if ($s->contains('y635-l21', false)) {
            return $this->loader->load('y635-l21', $useragent);
        }

        if ($s->contains('y360-u61', false)) {
            return $this->loader->load('y360-u61', $useragent);
        }

        if ($s->contains('y360-u31', false)) {
            return $this->loader->load('y360-u31', $useragent);
        }

        if ($s->contains('y340-u081', false)) {
            return $this->loader->load('y340-u081', $useragent);
        }

        if ($s->contains('y336-u02', false)) {
            return $this->loader->load('y336-u02', $useragent);
        }

        if ($s->contains('y330-u11', false)) {
            return $this->loader->load('y330-u11', $useragent);
        }

        if ($s->contains('y330-u05', false)) {
            return $this->loader->load('y330-u05', $useragent);
        }

        if ($s->contains('y330-u01', false)) {
            return $this->loader->load('y330-u01', $useragent);
        }

        if ($s->contains('y320-u30', false)) {
            return $this->loader->load('y320-u30', $useragent);
        }

        if ($s->contains('y320-u10', false)) {
            return $this->loader->load('y320-u10', $useragent);
        }

        if ($s->contains('y300', false)) {
            return $this->loader->load('y300', $useragent);
        }

        if ($s->contains('y220-u10', false)) {
            return $this->loader->load('y220-u10', $useragent);
        }

        if ($s->contains('y210-0100', false)) {
            return $this->loader->load('y210-0100', $useragent);
        }

        if ($s->contains('w2-u00', false)) {
            return $this->loader->load('w2-u00', $useragent);
        }

        if ($s->contains('w1-u00', false)) {
            return $this->loader->load('w1-u00', $useragent);
        }

        if ($s->contains('h30-u10', false)) {
            return $this->loader->load('h30-u10', $useragent);
        }

        if ($s->contains('kiw-l21', false)) {
            return $this->loader->load('kiw-l21', $useragent);
        }

        if ($s->contains('lyo-l21', false)) {
            return $this->loader->load('lyo-l21', $useragent);
        }

        if ($s->contains('vodafone 858', false)) {
            return $this->loader->load('vodafone 858', $useragent);
        }

        if ($s->contains('vodafone 845', false)) {
            return $this->loader->load('vodafone 845', $useragent);
        }

        if ($s->contains('u9510e', false)) {
            return $this->loader->load('u9510e', $useragent);
        }

        if ($s->contains('u9510', false)) {
            return $this->loader->load('u9510', $useragent);
        }

        if ($s->contains('u9508', false)) {
            return $this->loader->load('u9508', $useragent);
        }

        if ($s->contains('u9200', false)) {
            return $this->loader->load('u9200', $useragent);
        }

        if ($s->contains('u8950n-1', false)) {
            return $this->loader->load('u8950n-1', $useragent);
        }

        if ($s->contains('u8950n', false)) {
            return $this->loader->load('u8950n', $useragent);
        }

        if ($s->contains('u8950d', false)) {
            return $this->loader->load('u8950d', $useragent);
        }

        if ($s->contains('u8950-1', false)) {
            return $this->loader->load('u8950-1', $useragent);
        }

        if ($s->contains('u8950', false)) {
            return $this->loader->load('u8950', $useragent);
        }

        if ($s->contains('u8860', false)) {
            return $this->loader->load('u8860', $useragent);
        }

        if ($s->contains('u8850', false)) {
            return $this->loader->load('u8850', $useragent);
        }

        if ($s->contains('u8825', false)) {
            return $this->loader->load('u8825', $useragent);
        }

        if ($s->contains('u8815', false)) {
            return $this->loader->load('u8815', $useragent);
        }

        if ($s->contains('u8800', false)) {
            return $this->loader->load('u8800', $useragent);
        }

        if ($s->contains('HUAWEI U8666 Build/HuaweiU8666E', false)) {
            return $this->loader->load('u8666', $useragent);
        }

        if ($s->contains('u8666e', false)) {
            return $this->loader->load('u8666e', $useragent);
        }

        if ($s->contains('u8666', false)) {
            return $this->loader->load('u8666', $useragent);
        }

        if ($s->contains('u8655', false)) {
            return $this->loader->load('u8655', $useragent);
        }

        if ($s->contains('huawei-u8651t', false)) {
            return $this->loader->load('u8651t', $useragent);
        }

        if ($s->contains('huawei-u8651s', false)) {
            return $this->loader->load('u8651s', $useragent);
        }

        if ($s->contains('huawei-u8651', false)) {
            return $this->loader->load('u8651', $useragent);
        }

        if ($s->contains('u8650', false)) {
            return $this->loader->load('u8650', $useragent);
        }

        if ($s->contains('u8600', false)) {
            return $this->loader->load('u8600', $useragent);
        }

        if ($s->contains('u8520', false)) {
            return $this->loader->load('u8520', $useragent);
        }

        if ($s->contains('u8510', false)) {
            return $this->loader->load('s41hw', $useragent);
        }

        if ($s->contains('u8500', false)) {
            return $this->loader->load('u8500', $useragent);
        }

        if ($s->contains('u8350', false)) {
            return $this->loader->load('u8350', $useragent);
        }

        if ($s->contains('u8185', false)) {
            return $this->loader->load('u8185', $useragent);
        }

        if ($s->contains('u8180', false)) {
            return $this->loader->load('u8180', $useragent);
        }

        if ($s->containsAny(['u8110', 'tsp21'], false)) {
            return $this->loader->load('u8110', $useragent);
        }

        if ($s->contains('u8100', false)) {
            return $this->loader->load('u8100', $useragent);
        }

        if ($s->contains('u7510', false)) {
            return $this->loader->load('u7510', $useragent);
        }

        if ($s->contains('s8600', false)) {
            return $this->loader->load('s8600', $useragent);
        }

        if ($s->contains('p6-u06', false)) {
            return $this->loader->load('p6-u06', $useragent);
        }

        if ($s->contains('p6 s-u06', false)) {
            return $this->loader->load('p6 s-u06', $useragent);
        }

        if ($s->contains('mt7-tl10', false)) {
            return $this->loader->load('mt7-tl10', $useragent);
        }

        if ($s->containsAny(['mt7-l09', 'jazz'], false)) {
            return $this->loader->load('mt7-l09', $useragent);
        }

        if ($s->contains('mt2-l01', false)) {
            return $this->loader->load('mt2-l01', $useragent);
        }

        if ($s->contains('mt1-u06', false)) {
            return $this->loader->load('mt1-u06', $useragent);
        }

        if ($s->contains('s8-701w', false)) {
            return $this->loader->load('s8-701w', $useragent);
        }

        if ($s->containsAny(['t1-701u', 't1 7.0'], false)) {
            return $this->loader->load('t1-701u', $useragent);
        }

        if ($s->contains('t1-a21l', false)) {
            return $this->loader->load('t1-a21l', $useragent);
        }

        if ($s->contains('t1-a21w', false)) {
            return $this->loader->load('t1-a21w', $useragent);
        }

        if ($s->contains('m2-a01l', false)) {
            return $this->loader->load('m2-a01l', $useragent);
        }

        if ($s->contains('fdr-a01l', false)) {
            return $this->loader->load('fdr-a01l', $useragent);
        }

        if ($s->contains('fdr-a01w', false)) {
            return $this->loader->load('fdr-a01w', $useragent);
        }

        if ($s->contains('m2-a01w', false)) {
            return $this->loader->load('m2-a01w', $useragent);
        }

        if ($s->contains('m2-801w', false)) {
            return $this->loader->load('m2-801w', $useragent);
        }

        if ($s->contains('m2-801l', false)) {
            return $this->loader->load('m2-801l', $useragent);
        }

        if ($s->contains('ath-ul01', false)) {
            return $this->loader->load('ath-ul01', $useragent);
        }

        if ($s->contains('mediapad x1 7.0', false)) {
            return $this->loader->load('mediapad x1 7.0', $useragent);
        }

        if ($s->contains('mediapad t1 8.0', false)) {
            return $this->loader->load('s8-701u', $useragent);
        }

        if ($s->contains('mediapad m1 8.0', false)) {
            return $this->loader->load('mediapad m1 8.0', $useragent);
        }

        if ($s->contains('mediapad 10 link+', false)) {
            return $this->loader->load('mediapad 10+', $useragent);
        }

        if ($s->contains('mediapad 10 fhd', false)) {
            return $this->loader->load('mediapad 10 fhd', $useragent);
        }

        if ($s->contains('mediapad 10 link', false)) {
            return $this->loader->load('huawei s7-301w', $useragent);
        }

        if ($s->contains('mediapad 7 lite', false)) {
            return $this->loader->load('mediapad 7 lite', $useragent);
        }

        if ($s->contains('mediapad 7 classic', false)) {
            return $this->loader->load('mediapad 7 classic', $useragent);
        }

        if ($s->contains('mediapad 7 youth', false)) {
            return $this->loader->load('mediapad 7 youth', $useragent);
        }

        if ($s->contains('mediapad', false)) {
            return $this->loader->load('huawei s7-301w', $useragent);
        }

        if ($s->contains('m860', false)) {
            return $this->loader->load('m860', $useragent);
        }

        if ($s->contains('m635', false)) {
            return $this->loader->load('m635', $useragent);
        }

        if ($s->contains('ideos s7 slim', false)) {
            return $this->loader->load('s7_slim', $useragent);
        }

        if ($s->contains('ideos s7', false)) {
            return $this->loader->load('ideos s7', $useragent);
        }

        if ($s->contains('ideos ', false)) {
            return $this->loader->load('bm-swu300', $useragent);
        }

        if ($s->contains('g510-0100', false)) {
            return $this->loader->load('g510-0100', $useragent);
        }

        if ($s->contains('g7300', false)) {
            return $this->loader->load('g7300', $useragent);
        }

        if ($s->contains('g6609', false)) {
            return $this->loader->load('g6609', $useragent);
        }

        if ($s->contains('g6600', false)) {
            return $this->loader->load('g6600', $useragent);
        }

        if ($s->contains('g700-u10', false)) {
            return $this->loader->load('g700-u10', $useragent);
        }

        if ($s->contains('g527-u081', false)) {
            return $this->loader->load('g527-u081', $useragent);
        }

        if ($s->contains('g525-u00', false)) {
            return $this->loader->load('g525-u00', $useragent);
        }

        if ($s->contains('g510', false)) {
            return $this->loader->load('g510', $useragent);
        }

        if ($s->contains('hn3-u01', false)) {
            return $this->loader->load('hn3-u01', $useragent);
        }

        if ($s->contains('hol-u19', false)) {
            return $this->loader->load('hol-u19', $useragent);
        }

        if ($s->contains('vie-l09', false)) {
            return $this->loader->load('vie-l09', $useragent);
        }

        if ($s->contains('vie-al10', false)) {
            return $this->loader->load('vie-al10', $useragent);
        }

        if ($s->contains('frd-l09', false)) {
            return $this->loader->load('frd-l09', $useragent);
        }

        if ($s->contains('nmo-l31', false)) {
            return $this->loader->load('nmo-l31', $useragent);
        }

        if ($s->contains('d2-0082', false)) {
            return $this->loader->load('d2-0082', $useragent);
        }

        if ($s->contains('p8max', false)) {
            return $this->loader->load('p8max', $useragent);
        }

        if ($s->contains('4afrika', false)) {
            return $this->loader->load('4afrika', $useragent);
        }

        return $this->loader->load('general huawei device', $useragent);
    }
}
