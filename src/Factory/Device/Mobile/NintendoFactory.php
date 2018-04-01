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

class NintendoFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'wiiu'        => 'nintendo wiiu',
        'wii'         => 'nintendo wii',
        'dsi'         => 'nintendo dsi',
        'nintendo ds' => 'nintendo ds',
        '3ds'         => 'nintendo 3ds',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general nintendo device';

    use Factory\DeviceFactoryTrait;
}
