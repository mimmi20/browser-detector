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

class SxzFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'pdx0-01' => 'sxz pdx0-01',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general sxz device';

    use Factory\DeviceFactoryTrait;
}
