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

class EvercossFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'a66a' => 'evercoss a66a',
        'a5p'  => 'evercoss a5p',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general evercoss device';

    use Factory\DeviceFactoryTrait;
}
