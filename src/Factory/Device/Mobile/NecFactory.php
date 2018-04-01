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

class NecFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'n905i' => 'nec n905i',
        'n705i' => 'nec n705i',
        '0912'  => 'nec 0912',
        'n-06e' => 'nec n-06e',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general nec device';

    use Factory\DeviceFactoryTrait;
}
