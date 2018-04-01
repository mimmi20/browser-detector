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

class AxgioFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'wing-w2'  => 'axgio wing w2',
        'neon n2q' => 'axgio neon n2q',
        'neon-n1'  => 'axgio neon n1',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general axgio device';

    use Factory\DeviceFactoryTrait;
}
