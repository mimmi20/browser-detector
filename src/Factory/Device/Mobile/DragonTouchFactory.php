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

class DragonTouchFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'y88x' => 'dragon touch y88x',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general dragon touch device';

    use Factory\DeviceFactoryTrait;
}
