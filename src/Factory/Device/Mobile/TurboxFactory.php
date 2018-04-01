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

class TurboxFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'pi_4g'      => 'turbo-x pi 4g',
        'coral ii'   => 'turbo-x coral ii',
        'hive v 3g'  => 'turbo-x hive v 3g',
        'hive iv 3g' => 'turbo-x hive iv 3g',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general turbo-x device';

    use Factory\DeviceFactoryTrait;
}
