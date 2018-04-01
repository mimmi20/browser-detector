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

class BluFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'studio xl 2'     => 'blu studio xl 2',
        'studio g'        => 'blu studio g',
        'vivo iv'         => 'blu vivo iv',
        'studio 7.0'      => 'blu studio 7.0',
        'studio 5.5'      => 'blu studio 5.5',
        'studio 5.0 s ii' => 'blu studio 5.0 s ii',
        'win hd w510u'    => 'blu win hd w510u',
        'win hd lte'      => 'blu win hd lte',
        'win jr w410a'    => 'blu win jr w410a',
        'win jr lte'      => 'blu win jr lte',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general blu device';

    use Factory\DeviceFactoryTrait;
}
