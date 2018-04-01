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

class UlefoneFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'power_3'  => 'ulefone power 3',
        'future'   => 'ulefone future',
        'u007 pro' => 'ulefone u007 pro',
        'u007'     => 'ulefone u007',
        'vienna'   => 'ulefone vienna',
        'paris'    => 'ulefone paris',
        'be pro'   => 'ulefone be pro',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general ulefone device';

    use Factory\DeviceFactoryTrait;
}
