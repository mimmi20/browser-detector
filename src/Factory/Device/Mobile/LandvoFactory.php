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

class LandvoFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'xm300 pro' => 'landvo xm300 pro',
        'xm100s'    => 'landvo xm100s',
        'xm100'     => 'landvo xm100',
        'l900'      => 'landvo l900',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general landvo device';

    use Factory\DeviceFactoryTrait;
}
