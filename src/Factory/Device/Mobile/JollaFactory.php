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

class JollaFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'jolla c'                 => 'jolla jolla c',
        'jolla; sailfish; tablet' => 'jolla sailfish tablet',
        'jolla'                   => 'jolla sailfish',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general jolla device';

    use Factory\DeviceFactoryTrait;
}
