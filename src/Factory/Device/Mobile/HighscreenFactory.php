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

class HighscreenFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'zera f'     => 'highscreen zera f',
        'zera_f'     => 'highscreen zera f',
        'prime s'    => 'highscreen omega prime s',
        'ice2'       => 'highscreen ice 2',
        'explosion'  => 'highscreen explosion',
        'boost iise' => 'highscreen boost ii se',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general highscreen device';

    use Factory\DeviceFactoryTrait;
}
