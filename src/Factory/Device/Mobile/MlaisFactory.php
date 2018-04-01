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

class MlaisFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'm52_red_note' => 'mlais m52 red note',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general mlais device';

    use Factory\DeviceFactoryTrait;
}
