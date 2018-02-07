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
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

class MotorolaFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'moto g4 plus'    => 'motorola moto g4 plus',
        'xt830c'          => 'motorola xt830c',
        'xt1563'          => 'motorola xt1563',
        'xt1562'          => 'motorola xt1562',
        'xt1064'          => 'motorola xt1064',
        'moto g 2014'     => 'motorola xt1064',
        'xt1072'          => 'motorola xt1072',
        'moto g play'     => 'motorola moto g play',
        'xt1604'          => 'motorola xt1604',
        'xt1602'          => 'motorola xt1602',
        'xt1607'          => 'motorola xt1607',
        'xt1609'          => 'motorola xt1609',
        'xt1601'          => 'motorola xt1601',
        'xt1603'          => 'motorola xt1603',
        'xt1650'          => 'motorola xt1650',
        'xt1684'          => 'motorola xt1684',
        'xt1685'          => 'motorola xt1685',
        'xt1686'          => 'motorola xt1686',
        'xt1687'          => 'motorola xt1687',
        'moto g (5) plus' => 'motorola xt1686',
        'moto g (5)'      => 'motorola moto g5',
        'xt1032'          => 'motorola xt1032',
        'xt1585'          => 'motorola xt1585',
        'xt1581'          => 'motorola xt1581',
        'xt1580'          => 'motorola xt1580',
        'xt1572'          => 'motorola xt1572',
        'moto x'          => 'motorola xt1052',
        'xt1097'          => 'motorola xt1097',
        'xt1096'          => 'motorola xt1096',
        'xt1095'          => 'motorola xt1095',
        'xt1092'          => 'motorola xt1092',
        'xt1635-02'       => 'motorola xt1635-02',
        'xt1254'          => 'motorola xt1254',
        'moto g (4)'      => 'motorola moto g4',
        'moto g'          => 'motorola xt1032',
        'xt1528'          => 'motorola xt1528',
        'xt1527'          => 'motorola xt1527',
        'xt1526'          => 'motorola xt1526',
        'xt1524'          => 'motorola xt1524',
        'xt1521'          => 'motorola xt1521',
        'xt1511'          => 'motorola xt1511',
        'xt1506'          => 'motorola xt1506',
        'xt1505'          => 'motorola xt1505',
        'motoe2(4g-lte)'  => 'motorola xt1528',
        'motoe2'          => 'motorola xt1505',
        'motog3'          => 'motorola motog3',
        'xt1080'          => 'motorola xt1080',
        'xt1068'          => 'motorola xt1068',
        'xt1060'          => 'motorola xt1060',
        'xt1058'          => 'motorola xt1058',
        'xt1056'          => 'motorola xt1056',
        'xt1055'          => 'motorola xt1055',
        'xt1053'          => 'motorola xt1053',
        'xt1052'          => 'motorola xt1052',
        'xt1040'          => 'motorola xt1040',
        'xt1039'          => 'motorola xt1039',
        'xt1033'          => 'motorola xt1033',
        'xt1030'          => 'motorola xt1030',
        'xt1025'          => 'motorola xt1025',
        'xt1023'          => 'motorola xt1023',
        'xt1022'          => 'motorola xt1022',
        'xt1021'          => 'motorola xt1021',
        'xt926'           => 'motorola xt926',
        'xt925'           => 'motorola xt925',
        'droid razr hd'   => 'motorola xt923',
        'razr hd'         => 'motorola xt925',
        'xt922'           => 'motorola xt922',
        'xt980'           => 'motorola xt980',
        'xt910'           => 'motorola xt910',
        'xt907'           => 'motorola xt907',
        'xt890'           => 'motorola xt890',
        'xt875'           => 'motorola xt875',
        'droid bionic 4g' => 'motorola xt875',
        'xt720'           => 'motorola milestone xt720',
        'xt702'           => 'motorola xt702',
        'xt615'           => 'motorola xt615',
        'xt610'           => 'motorola xt610',
        'xt535'           => 'motorola xt535',
        'xt530'           => 'motorola xt530',
        'xt531'           => 'motorola xt531',
        'xt389'           => 'motorola xt389',
        'xt320'           => 'motorola xt320',
        'xt316'           => 'motorola xt316',
        'xt311'           => 'motorola xt311',
        'wx308'           => 'motorola wx308',
        't720'            => 'motorola t720',
        'razrv3x'         => 'motorola razrv3x',
        'mot-v3i'         => 'motorola razr v3i',
        'nexus 6'         => 'motorola nexus 6',
        'mz608'           => 'motorola mz608',
        'mz607'           => 'motorola mz607',
        'xoom 2 me'       => 'motorola mz607',
        'mz615'           => 'motorola mz615',
        'mz616'           => 'motorola mz616',
        'xoom 2'          => 'motorola mz616',
        'mz606'           => 'motorola mz606',
        'mz604'           => 'motorola mz604',
        'mz601'           => 'motorola mz601',
        'xoom'            => 'motorola xoom',
        'milestone x'     => 'motorola milestone x',
        'milestone'       => 'motorola milestone',
        'me860'           => 'motorola me860',
        'me600'           => 'motorola me600',
        'me525'           => 'motorola me525',
        'me511'           => 'motorola me511',
        'mb886'           => 'motorola mb886',
        'mb860'           => 'motorola mb860',
        'mb632'           => 'motorola mb632',
        'mb612'           => 'motorola mb612',
        'mb526'           => 'motorola mb526',
        'mb525'           => 'motorola mb525',
        'mb511'           => 'motorola mb511',
        'mb300'           => 'motorola mb300',
        'mb200'           => 'motorola mb200',
        'es405b'          => 'motorola es405b',
        'e1000'           => 'motorola e1000',
        'droid x2'        => 'motorola droid x2',
        'droidx'          => 'motorola droidx',
        'droid4'          => 'motorola droid4',
        'droid2'          => 'motorola droid2',
        'droid razr 4g'   => 'motorola xt912b',
        'droid razr'      => 'motorola razr',
        'droid pro'       => 'motorola xt610',
        'droid-bionic'    => 'motorola droid bionic',
        'droid bionic'    => 'motorola droid bionic',
        'xt865'           => 'motorola droid bionic',
        'motoa953'        => 'motorola a953',
        'motoq9c'         => 'motorola q9c',
        'l7'              => 'motorola slvr l7',
        ' z '             => 'motorola moto z',
        ' droid '         => 'motorola droid',
        'v360v'           => 'motorola v360v',
    ];

    /**
     * @var \BrowserDetector\Loader\ExtendedLoaderInterface
     */
    private $loader;

    /**
     * @param \BrowserDetector\Loader\ExtendedLoaderInterface $loader
     */
    public function __construct(ExtendedLoaderInterface $loader)
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
    public function detect(string $useragent, Stringy $s): array
    {
        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('general motorola device', $useragent);
    }
}
