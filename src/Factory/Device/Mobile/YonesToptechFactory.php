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

class YonesToptechFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'bs1078' => 'yones-toptech bs1078',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general yones-toptech device';

    use Factory\DeviceFactoryTrait;
}
