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

class ShiruFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'samurai10' => 'shiru samurai10',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general shiru device';

    use Factory\DeviceFactoryTrait;
}
