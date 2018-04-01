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

class OystersFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        't72n_3g'     => 'oysters t72n_3g',
        't72m 3g'     => 'oysters t72m 3g',
        't72hm3g'     => 'oysters t72hm3g',
        't72ha_3g'    => 'oysters t72ha_3g',
        't72er3g'     => 'oysters t72er3g',
        'pacific800i' => 'oysters pacific 800i',
        'pacific 800' => 'oysters pacific 800',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general oysters device';

    use Factory\DeviceFactoryTrait;
}
