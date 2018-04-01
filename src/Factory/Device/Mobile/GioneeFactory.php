<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;

class GioneeFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'v188s'    => 'gionee v188s',
        'v188'     => 'gionee v188',
        'v185'     => 'gionee v185',
        'v182'     => 'gionee v182',
        'v6l'      => 'gionee v6l',
        'gpad_g2'  => 'gionee gpad g2',
        'gpad_g1'  => 'gionee gpad g1',
        'f103 pro' => 'gionee f103 pro',
        'f103'     => 'gionee f103',
        'gn9008'   => 'gionee gn9008',
        'gn9006'   => 'gionee gn9006',
        'gn9005'   => 'gionee gn9005',
        'gn9004'   => 'gionee gn9004',
        'gn9002'   => 'gionee gn9002',
        'gn9001'   => 'gionee gn9001',
        'gn9000l'  => 'gionee gn9000l',
        'gn9000'   => 'gionee gn9000',
        'gn878'    => 'gionee gn878',
        'gn868'    => 'gionee gn868',
        'gn810'    => 'gionee gn810',
        'gn800'    => 'gionee gn800',
        'gn705w'   => 'gionee gn705w',
        ' e7 '     => 'gionee e7',
        ' m5 '     => 'gionee m5',
        ' m3 '     => 'gionee m3',
        'gionee50' => 'gionee 50',
        ' p2'      => 'gionee p2',
        's80'      => 'gionee s80',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general gionee device';

    use Factory\DeviceFactoryTrait;
}
