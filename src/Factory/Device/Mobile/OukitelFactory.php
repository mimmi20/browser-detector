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

class OukitelFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'universetap' => 'oukitel universetap',
        'u16 max'     => 'oukitel u16 max',
        'u10'         => 'oukitel u10',
        'u7 plus'     => 'oukitel u7 plus',
        'k10000'      => 'oukitel k10000',
        'k6000 plus'  => 'oukitel k6000 plus',
        'k6000 pro'   => 'oukitel k6000 pro',
        'k4000'       => 'oukitel k4000',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general oukitel device';

    use Factory\DeviceFactoryTrait;
}
