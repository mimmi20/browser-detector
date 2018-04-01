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

class HannspreeFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'sn10t1'  => 'hannspree sn10t1',
        'hsg1303' => 'hannspree hsg1303',
        'hsg1279' => 'hannspree hsg1279',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general hannspree device';

    use Factory\DeviceFactoryTrait;
}
