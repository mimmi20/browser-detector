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

class KddiFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'kc31' => 'kddi kc31',
        'kc4a' => 'kddi kc4a',
        'is04' => 'kddi is04',
        'sn3f' => 'kddi sn3f',
        'sn3v' => 'kddi sn3v',
        'ca3h' => 'kddi ca3h',
        'ts3w' => 'kddi ts3w',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general kddi device';

    use Factory\DeviceFactoryTrait;
}
