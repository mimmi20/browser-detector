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

class DoogeeFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        't6'             => 'doogee t6',
        'x9pro'          => 'doogee x9 pro',
        'x6pro'          => 'doogee x6 pro',
        'x5max_pro'      => 'doogee x5max pro',
        'y6 max 3d'      => 'doogee y6 max 3d',
        'y6 max'         => 'doogee y6 max',
        'y6_piano_black' => 'doogee y6 piano black',
        'y6_piano'       => 'doogee y6 piano',
        'dg2014'         => 'doogee dg2014',
        'dg800'          => 'doogee dg800',
        'dg600'          => 'doogee dg600',
        'dg330'          => 'doogee dg330',
        'dg310'          => 'doogee dg310',
        'dg300'          => 'doogee dg300',
        'f3_pro'         => 'doogee f3 pro',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general doogee device';

    use Factory\DeviceFactoryTrait;
}
