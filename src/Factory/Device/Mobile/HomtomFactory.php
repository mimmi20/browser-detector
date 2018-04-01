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

class HomtomFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'ht17pro' => 'homtom ht17 pro',
        'nt17pro' => 'homtom ht17 pro',
        'ht7 pro' => 'homtom ht7 pro',
        'ht20'    => 'homtom ht20',
        'ht17'    => 'homtom ht17',
        'ht16'    => 'homtom ht16',
        'ht3'     => 'homtom ht3',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general homtom device';

    use Factory\DeviceFactoryTrait;
}
