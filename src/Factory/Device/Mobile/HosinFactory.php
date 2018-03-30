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
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

class HosinFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'v70' => 'hosin v70',
        't70' => 'hosin t70',
        't50' => 'hosin t50',
        'u7'  => 'hosin u7',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general hosin device';

    use Factory\DeviceFactoryTrait;
}
