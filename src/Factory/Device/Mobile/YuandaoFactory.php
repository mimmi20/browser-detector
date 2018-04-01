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

class YuandaoFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'n90fhdrk'       => 'yuandao n90fhdrk',
        'n90 dual core2' => 'yuandao n90 dual core2',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general yuandao device';

    use Factory\DeviceFactoryTrait;
}
