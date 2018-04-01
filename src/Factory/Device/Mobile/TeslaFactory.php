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

class TeslaFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'ttl7'         => 'tesla ttl7',
        'tth7'         => 'tesla tth7',
        'tablet_785'   => 'tesla tablet 785',
        'tablet_l7_3g' => 'tesla tablet l7 3g',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general tesla device';

    use Factory\DeviceFactoryTrait;
}
