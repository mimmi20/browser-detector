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

class UmiFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'iron pro'      => 'umi iron pro',
        'iron'          => 'umi iron',
        'zero'          => 'umi zero',
        'hammer_s'      => 'umi hammer s',
        'london'        => 'umi london',
        'umi_diamond_x' => 'umi diamond x',
        'umi_diamond'   => 'umi diamond',
        'umi_max'       => 'umi max',
        'umi_super'     => 'umi super',
        'umi_x2'        => 'umi x2',
        'umi x2'        => 'umi x2',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general umi device';

    use Factory\DeviceFactoryTrait;
}
