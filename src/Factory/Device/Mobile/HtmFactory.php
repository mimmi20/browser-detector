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

class HtmFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'mt-gt-a9500' => 'htm gt-a9500',
        'gt-a7100'    => 'htm gt-a7100',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general htm device';

    use Factory\DeviceFactoryTrait;
}
