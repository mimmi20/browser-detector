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
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

class KazamFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'thunder2 50'  => 'kazam thunder2 50',
        'thunder q45'  => 'kazam thunder q45',
        'trooper2 50'  => 'kazam trooper2 50',
        'trooper 455'  => 'kazam trooper 455',
        'trooper 451'  => 'kazam trooper 451',
        'trooper 450l' => 'kazam trooper 450l',
        'trooper_450l' => 'kazam trooper 450l',
        'trooper_x55'  => 'kazam trooper x55',
        'trooper x55'  => 'kazam trooper x55',
        'trooper_x50'  => 'kazam trooper x50',
        'trooper x50'  => 'kazam trooper x50',
        'trooper_x45'  => 'kazam trooper x45',
        'trooper_x40'  => 'kazam trooper x40',
        'trooper_x35'  => 'kazam trooper x35',
        'tornado 348'  => 'kazam tornado 348',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general kazam device';

    use Factory\DeviceFactoryTrait;
}
