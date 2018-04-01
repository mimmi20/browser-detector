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

class OlivettiFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'op111' => 'olivetti op111',
        'op110' => 'olivetti op110',
        'op070' => 'olivetti olipad 70',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general olivetti device';

    use Factory\DeviceFactoryTrait;
}
