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

class KumaiFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'kumai 918'  => 'kumai 918',
        'kumai 290s' => 'kumai 290s',
        'kumai 290'  => 'kumai 290',
        'kumai 260'  => 'kumai 260',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general kumai device';

    use Factory\DeviceFactoryTrait;
}
