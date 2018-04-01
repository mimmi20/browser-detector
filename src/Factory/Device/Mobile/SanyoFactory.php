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

class SanyoFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'scp6780'  => 'sanyo scp6780',
        'scp6760'  => 'sanyo scp6760',
        'scp-6750' => 'sanyo scp6750',
        'scp588cn' => 'sanyo scp588cn',
        'scp3810'  => 'sanyo scp3810',
        'e4100'    => 'sanyo e4100',
        'pm-8200'  => 'sanyo pm8200',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general sanyo device';

    use Factory\DeviceFactoryTrait;
}
