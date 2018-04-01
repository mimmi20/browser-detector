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

class GigasetFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'gs55-6' => 'gigaset gs55-6',
        'gs53-6' => 'gigaset gs53-6',
        'gs160'  => 'gigaset gs160',
        'qv1030' => 'gigaset qv1030',
        'qv830'  => 'gigaset qv830',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general gigaset device';

    use Factory\DeviceFactoryTrait;
}
