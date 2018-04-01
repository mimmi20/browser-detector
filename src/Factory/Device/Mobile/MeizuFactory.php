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

class MeizuFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'm6 note'  => 'meizu m6 note',
        'm3 note'  => 'meizu m3 note',
        'm2 note'  => 'meizu m2 note',
        'm571c'    => 'meizu m2 note',
        'm1 note'  => 'meizu m1 note',
        'pro 5'    => 'meizu pro 5',
        'mz-mx5'   => 'meizu mx5',
        'mx4 pro'  => 'meizu mx4 pro',
        'mx4'      => 'meizu mx4',
        'm040'     => 'meizu m040',
        'm032'     => 'meizu m032',
        'meizu_m9' => 'meizu m9',
        ' m9 '     => 'meizu m9',
        ' m2 '     => 'meizu m2',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general meizu device';

    use Factory\DeviceFactoryTrait;
}
