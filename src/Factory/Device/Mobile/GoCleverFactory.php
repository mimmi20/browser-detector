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

class GoCleverFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'tq700'            => 'goclever tq700',
        'terra_101'        => 'goclever a1021',
        'insignia_785_pro' => 'goclever insignia 785 pro',
        'aries_785'        => 'goclever aries 785',
        'aries_101'        => 'goclever aries 101',
        'orion7o'          => 'goclever orion 7o',
        'quantum 4'        => 'goclever quantum 4',
        'quantum_700m'     => 'goclever quantum 700m',
        'tab a93.2'        => 'goclever a93.2',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general goclever device';

    use Factory\DeviceFactoryTrait;
}
