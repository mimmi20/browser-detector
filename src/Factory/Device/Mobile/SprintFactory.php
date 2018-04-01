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

class SprintFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'ppc-6700'  => 'sprint 6700',
        'apa9292kt' => 'sprint 9292',
        'apa7373kt' => 'sprint a7373',
        's2151'     => 'sprint s2151',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general sprint device';

    use Factory\DeviceFactoryTrait;
}
