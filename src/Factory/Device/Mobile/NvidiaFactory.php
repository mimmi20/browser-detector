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

class NvidiaFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'shield tablet k1' => 'nvidia shield tablet k1',
        'shield tablet'    => 'nvidia shield tablet',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general nvidia device';

    use Factory\DeviceFactoryTrait;
}
