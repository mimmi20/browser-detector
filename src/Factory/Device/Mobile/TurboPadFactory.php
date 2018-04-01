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

class TurboPadFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'turbo x6'      => 'turbopad turbo x6',
        'turbo pad 500' => 'turbopad pad 500',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general turbopad device';

    use Factory\DeviceFactoryTrait;
}
