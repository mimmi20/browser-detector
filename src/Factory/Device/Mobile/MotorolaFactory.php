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
class MotorolaFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'moto g play'          => 'motorola moto g play',
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
        'moto g (5) plus'          => 'motorola xt1686',
        'moto g (5)'          => 'motorola moto g5',
        'xt1032'          => 'motorola xt1032',
        'xt1581'          => 'motorola xt1581',
        'xt1580'          => 'motorola xt1580',
        'xt1572'          => 'motorola xt1572',
        'xt1092'          => 'motorola xt1092',
        'xt1635-02'       => 'motorola xt1635-02',
        'xt1254'          => 'motorola xt1254',
        'moto g (4)'      => 'motorola moto g4',
        'xt1528'          => 'motorola xt1528',
        'xt1527'          => 'motorola xt1527',
        'xt1526'          => 'motorola xt1526',
        'xt1524'          => 'motorola xt1524',
        'xt1521'          => 'motorola xt1521',
        'xt1511'          => 'motorola xt1511',
        'xt1506'          => 'motorola xt1506',
        'xt1505'          => 'motorola xt1505',
        'motoe2(4g-lte)'  => 'motorola xt1528',
        'motog3'          => 'motog3',
        'xt1080'          => 'xt1080',
        'xt1068'          => 'xt1068',
        'xt1060'          => 'motorola xt1060',
        'xt1058'          => 'xt1058',
        'xt1056'          => 'motorola xt1056',
        'xt1055'          => 'motorola xt1055',
        'xt1053'          => 'motorola xt1053',
        'xt1052'          => 'xt1052',
        'xt1040'          => 'motorola xt1040',
        'xt1039'          => 'xt1039',
        'xt1033'          => 'xt1033',
        'xt1025'          => 'motorola xt1025',
        'xt1022'          => 'motorola xt1022',
        'xt1021'          => 'xt1021',
        'xt926'           => 'xt926',
        'xt925'           => 'xt925',
        'droid razr hd'   => 'xt923',
        'xt910'           => 'xt910',
        'xt907'           => 'xt907',
        'xt890'           => 'xt890',
        'xt875'           => 'xt875',
        'droid bionic 4g' => 'xt875',
        'xt720'           => 'milestone xt720',
        'xt702'           => 'xt702',
        'xt615'           => 'xt615',
        'xt610'           => 'xt610',
        'xt535'           => 'motorola xt535',
        'xt530'           => 'xt530',
        'xt389'           => 'xt389',
        'xt320'           => 'xt320',
        'xt316'           => 'xt316',
        'xt311'           => 'xt311',
        'wx308'           => 'wx308',
        't720'            => 't720',
        'razrv3x'         => 'razrv3x',
        'mot-v3i'         => 'razr v3i',
        'nexus 6'         => 'nexus 6',
        'mz608'           => 'mz608',
        'mz607'           => 'mz607',
        'xoom 2 me'       => 'mz607',
        'mz615'           => 'mz615',
        'mz616'           => 'mz616',
        'xoom 2'          => 'mz616',
        'mz604'           => 'mz604',
        'mz601'           => 'mz601',
        'xoom'            => 'xoom',
        'milestone x'     => 'milestone x',
        'milestone'       => 'milestone',
        'me860'           => 'me860',
        'me600'           => 'me600',
        'me525'           => 'me525',
        'me511'           => 'me511',
        'mb886'           => 'motorola mb886',
        'mb860'           => 'mb860',
        'mb632'           => 'mb632',
        'mb612'           => 'mb612',
        'mb526'           => 'mb526',
        'mb525'           => 'mb525',
        'mb511'           => 'mb511',
        'mb300'           => 'mb300',
        'mb200'           => 'mb200',
        'es405b'          => 'es405b',
        'e1000'           => 'e1000',
        'droid x2'        => 'droid x2',
        'droidx'          => 'droidx',
        'droid razr 4g'   => 'xt912b',
        'droid razr'      => 'razr',
        'droid pro'       => 'droid pro',
        'droid-bionic'    => 'droid bionic',
        'droid bionic'    => 'droid bionic',
        'droid2'          => 'droid2',
        'motoa953'        => 'a953',
        'motoq9c'         => 'q9c',
        'l7'              => 'slvr l7',
        ' droid '         => 'droid',
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

        return $this->loader->load('general motorola device', $useragent);
    }
}
