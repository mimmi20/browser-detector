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

class PearlFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'x10.quad.fm' => 'pearl x10.quad.fm',
        'x10.dual+'   => 'pearl x10+',
        'x10.dual'    => 'pearl x10',
        'x7g'         => 'pearl touchlet x7g',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general pearl device';

    use Factory\DeviceFactoryTrait;
}
