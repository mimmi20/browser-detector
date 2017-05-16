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
class HuaweiFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'h60-l01'                         => 'huawei h60-l01',
        'h60-l02'                         => 'huawei h60-l02',
        'h60-l04'                         => 'huawei h60-l04',
        'h60-l12'                         => 'huawei h60-l12',
        'nexus 6p'                        => 'nexus 6p',
        'tag-al00'                        => 'tag-al00',
        'tag-l21'                         => 'tag-l21',
        'tag-l01'                         => 'tag-l01',
        'ale-21'                          => 'ale 21',
        'ale-l21'                         => 'ale-l21',
        'ale-l02'                         => 'ale-l02',
        'gra-l09'                         => 'gra-l09',
        'grace'                           => 'grace',
        'p7-l10'                          => 'p7-l10',
        'p7-l09'                          => 'p7-l09',
        'p7 mini'                         => 'p7 mini',
        'p7mini'                          => 'p7 mini',
        'p2-6011'                         => 'p2-6011',
        'eva-l19'                         => 'eva-l19',
        'eva-l09'                         => 'eva-l09',
        'scl-l01'                         => 'scl-l01',
        'scl-l21'                         => 'scl-l21',
        'scl-u31'                         => 'scl-u31',
        'nxt-l29'                         => 'nxt-l29',
        'nxt-al10'                        => 'nxt-al10',
        'gem-703l'                        => 'gem-703l',
        'gem-702l'                        => 'gem-702l',
        'gem-701l'                        => 'gem-701l',
        'g630-u251'                       => 'g630-u251',
        'g630-u20'                        => 'g630-u20',
        'g620s-l01'                       => 'g620s-l01',
        'g610-u20'                        => 'g610-u20',
        'g7-l11'                          => 'g7-l11',
        'g7-l01'                          => 'g7-l01',
        'g6-l11'                          => 'g6-l11',
        'g6-u10'                          => 'g6-u10',
        'pe-tl10'                         => 'pe-tl10',
        'rio-l01'                         => 'rio-l01',
        'cun-l21'                         => 'cun-l21',
        'cun-l03'                         => 'cun-l03',
        'crr-l09'                         => 'crr-l09',
        'chc-u01'                         => 'chc-u01',
        'g750-u10'                        => 'g750-u10',
        'g750-t00'                        => 'g750-t00',
        'g740-l00'                        => 'g740-l00',
        'g730-u27'                        => 'g730-u27',
        'g730-u10'                        => 'g730-u10',
        'vns-l31'                         => 'vns-l31',
        'vns-l21'                         => 'vns-l21',
        'tit-u02'                         => 'tit-u02',
        'y635-l21'                        => 'y635-l21',
        'y625-u51'                        => 'y625-u51',
        'y625-u21'                        => 'y625-u21',
        'y600-u151'                       => 'huawei y600-u151',
        'y600-u20'                        => 'y600-u20',
        'y600-u00'                        => 'y600-u00',
        'y560-l01'                        => 'y560-l01',
        'y550-l01'                        => 'y550-l01',
        'y540-u01'                        => 'y540-u01',
        'y530-u00'                        => 'y530-u00',
        'y511'                            => 'y511',
        'y360-u61'                        => 'y360-u61',
        'y360-u31'                        => 'y360-u31',
        'y340-u081'                       => 'y340-u081',
        'y336-u02'                        => 'y336-u02',
        'y330-u11'                        => 'y330-u11',
        'y330-u05'                        => 'y330-u05',
        'y330-u01'                        => 'y330-u01',
        'y320-u30'                        => 'y320-u30',
        'y320-u10'                        => 'y320-u10',
        'y300'                            => 'y300',
        'y220-u10'                        => 'y220-u10',
        'y210-0100'                       => 'y210-0100',
        'w2-u00'                          => 'w2-u00',
        'w1-u00'                          => 'w1-u00',
        'h30-u10'                         => 'h30-u10',
        'kiw-l21'                         => 'kiw-l21',
        'lyo-l21'                         => 'lyo-l21',
        'vodafone 858'                    => 'vodafone 858',
        'vodafone 845'                    => 'vodafone 845',
        'u9510e'                          => 'u9510e',
        'u9510'                           => 'u9510',
        'u9508'                           => 'u9508',
        'u9200'                           => 'u9200',
        'u8950n-1'                        => 'u8950n-1',
        'u8950n'                          => 'u8950n',
        'u8950d'                          => 'u8950d',
        'u8950-1'                         => 'u8950-1',
        'u8950'                           => 'u8950',
        'u8860'                           => 'u8860',
        'u8850'                           => 'u8850',
        'u8825'                           => 'u8825',
        'u8815'                           => 'u8815',
        'u8800'                           => 'u8800',
        'huawei u8666 build/huaweiu8666e' => 'u8666',
        'u8666e'                          => 'u8666e',
        'u8666'                           => 'u8666',
        'u8655'                           => 'u8655',
        'huawei-u8651t'                   => 'u8651t',
        'huawei-u8651s'                   => 'u8651s',
        'huawei-u8651'                    => 'u8651',
        'u8650'                           => 'u8650',
        'u8600'                           => 'u8600',
        'u8520'                           => 'u8520',
        'u8510'                           => 's41hw',
        'u8500'                           => 'u8500',
        'u8350'                           => 'u8350',
        'u8185'                           => 'u8185',
        'u8180'                           => 'u8180',
        'u8110'                           => 'u8110',
        'tsp21'                           => 'u8110',
        'u8100'                           => 'u8100',
        'u7510'                           => 'u7510',
        's8600'                           => 's8600',
        'p6-u06'                          => 'p6-u06',
        'p6 s-u06'                        => 'p6 s-u06',
        'mt7-tl10'                        => 'mt7-tl10',
        'mt7-l09'                         => 'mt7-l09',
        'jazz'                            => 'mt7-l09',
        'mt2-l01'                         => 'mt2-l01',
        'mt1-u06'                         => 'mt1-u06',
        's8-701w'                         => 's8-701w',
        't1-701u'                         => 't1-701u',
        't1 7.0'                          => 't1-701u',
        't1-a21l'                         => 't1-a21l',
        't1-a21w'                         => 't1-a21w',
        'm2-a01l'                         => 'm2-a01l',
        'fdr-a01l'                        => 'fdr-a01l',
        'fdr-a01w'                        => 'fdr-a01w',
        'm2-a01w'                         => 'm2-a01w',
        'm2-801w'                         => 'm2-801w',
        'm2-801l'                         => 'm2-801l',
        'ath-ul01'                        => 'ath-ul01',
        'mediapad x1 7.0'                 => 'mediapad x1 7.0',
        'mediapad t1 8.0'                 => 's8-701u',
        'mediapad m1 8.0'                 => 'mediapad m1 8.0',
        'mediapad 10 link+'               => 'mediapad 10+',
        'mediapad 10 fhd'                 => 'mediapad 10 fhd',
        'mediapad 10 link'                => 'huawei s7-301w',
        'mediapad 7 lite'                 => 'mediapad 7 lite',
        'mediapad 7 classic'              => 'mediapad 7 classic',
        'mediapad 7 youth'                => 'mediapad 7 youth',
        'mediapad'                        => 'huawei s7-301w',
        'm860'                            => 'm860',
        'm635'                            => 'm635',
        'ideos s7 slim'                   => 's7_slim',
        'ideos s7'                        => 'ideos s7',
        'ideos '                          => 'bm-swu300',
        'g510-0100'                       => 'g510-0100',
        'g7300'                           => 'g7300',
        'g6609'                           => 'g6609',
        'g6600'                           => 'g6600',
        'g700-u10'                        => 'g700-u10',
        'g527-u081'                       => 'g527-u081',
        'g525-u00'                        => 'g525-u00',
        'g510'                            => 'g510',
        'hn3-u01'                         => 'hn3-u01',
        'hol-u19'                         => 'hol-u19',
        'vie-l09'                         => 'vie-l09',
        'vie-al10'                        => 'vie-al10',
        'frd-l09'                         => 'frd-l09',
        'nmo-l31'                         => 'nmo-l31',
        'd2-0082'                         => 'd2-0082',
        'p8max'                           => 'p8max',
        '4afrika'                         => '4afrika',
    ];

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
        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('general huawei device', $useragent);
    }
}
