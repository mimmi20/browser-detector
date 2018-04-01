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

class KoobeeFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'm3'   => 'koobee m3',
        'm2'   => 'koobee m2',
        't550' => 'koobee t550',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general koobee device';

    use Factory\DeviceFactoryTrait;
}
