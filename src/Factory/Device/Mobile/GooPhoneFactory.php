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

class GooPhoneFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        's4 mega' => 'goophone s4 mega',
        'n3'      => 'goophone n3',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general goophone device';

    use Factory\DeviceFactoryTrait;
}
