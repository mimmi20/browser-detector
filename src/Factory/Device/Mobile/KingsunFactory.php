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

class KingsunFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        's6'  => 'kingsun s6',
        's5q' => 'kingsun s5q',
        's8'  => 'kingsun s8',
        'f1'  => 'kingsun f1',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general kingsun device';

    use Factory\DeviceFactoryTrait;
}
