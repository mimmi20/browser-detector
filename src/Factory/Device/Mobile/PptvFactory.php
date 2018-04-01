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

class PptvFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'king 7s' => 'pptv king 7s',
        'king 7'  => 'pptv king 7',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general pptv device';

    use Factory\DeviceFactoryTrait;
}
