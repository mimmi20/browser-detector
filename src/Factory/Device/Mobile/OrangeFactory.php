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

class OrangeFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'funtab 8' => 'orange funtab 8',
        'zilo'     => 'orange zilo',
        'm700'     => 'spv m700',
        'e650'     => 'spv e650',
        'e600'     => 'spv e600',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general orange device';

    use Factory\DeviceFactoryTrait;
}
